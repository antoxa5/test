<?php

if (!function_exists('list_more_ajax')) {
	add_action( 'wp_ajax_list_more_ajax', 'list_more_ajax' );
	add_action( 'wp_ajax_nopriv_list_more_ajax', 'list_more_ajax' );
	function list_more_ajax() {
		$data = $_POST;
		$post_id = $data['post_id'];
		if(get_post_type($post_id) == 'promocodes') {
			$post_id = get_field('promocode_review',$post_id);
		}
		$result = '';
		$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
		$term = get_term_by('name', $term_slug, 'affiliate-tags');
		$args = array(
			'post_type' => array('post'),
			'posts_per_page' => 3,
			'orderby' => 'date',
			'order' => 'DESC',
			'parent_alt_pages_hide' => 1,
			'meta_query' => array(
					'relation'		=> 'AND',
                    array(
                        'key' => 'er_post_tags',
                        'value' => '"'.$term->term_id.'"',
                        'compare' => 'LIKE'
                    )
                )
		);
        $current_language = get_locale();
        if($current_language != 'ru_RU') {
            $args['meta_query'][] = array(
                'key'     => 'enable_translations',
                'value'   => $current_language,
                'compare' => 'LIKE'
            );
        }
		
		
		$news = new WP_Query($args);
		
		if ( $news->have_posts() ) {
		$result .= '<div class="list_more_widget flex flex_column">';
				$result .= '<div class="flex_100 font_smaller_2 font_bolder font_uppercase color_dark_blue m_b_30">'.__('Еще по теме','er_theme').'</div>';
				$result .= '<ul class="white_block">';
                            while ( $news->have_posts() ) {
                                $news->the_post();
                                global $post;
				$author_id = get_the_author_meta('ID', $post->ID);
        $author = get_userdata($author_id);
        $attachment_id = get_field('photo_profile', 'user_'. $author_id );
        $thumb = get_the_post_thumbnail_url( $post_id, 'large' );
		$user_alt_name = get_user_alt_name( $author_id, $current_language );

				$result .= '<li>';
				$result .= '<div class="author_avatar"';
                if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') {
                    $result .= ' style="background-image: url('.$attachment_id['sizes']['thumbnail'].');"';
                }
                $result .= '></div>';
					$result .= '<div class="news_middle">';
						$result .= '<a href="'.get_the_permalink().'" class="color_dark_blue link_no_underline font_bold font_small">'.get_the_title().'</a>';
								$result .= '<div class="news_list_meta flex">';
								$result .= '<div class="post_meta_author font_bold font_small color_dark_blue pointer">';

								if( $user_alt_name ) {
									$result .= $user_alt_name;
								} elseif($author->first_name && !$author->last_name) {
									$result .= $author->first_name;
								} elseif(!$author->first_name && $author->last_name) {
									$result .= $author->last_name;
								} elseif($author->first_name && $author->last_name) {
									$result .= $author->first_name.' '.$author->last_name;
								} else {
									$result .= $author->user_nicename;
								}

								$result .= '</div>';
								$result .= '<div class="post_meta_date font_smaller color_dark_gray">'.get_the_date('F j Y',$post->ID).'</div>';
								$result .= '</div>';
					$result .= '</div>';
				$result .= '</li>';
			
							}
				$result .= '</ul>';
			
 		wp_reset_postdata();
		$result .= '</div>';
		}
		echo $result;
		die;
		
	}
	
}

if (!function_exists('list_more_included')) {
    function list_more_included($post_id) {
        $post_id = $post_id;
        if(get_post_type($post_id) == 'promocodes') {
            $post_id = get_field('promocode_review',$post_id);
        }
        $result = '';
        $term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
        if ($term_slug == 'university') {
			$term_slug = 'learn';
		}
        $term = get_term_by('name', $term_slug, 'affiliate-tags');
        /*if ($term_slug == 'mfo') {
			
			$args = array(
				'post_type' => array('page'),
				'posts_per_page' => 3,
				'orderby' => 'date',
				'order' => 'ASC',
				'meta_query' => array(
					'relation'		=> 'AND',
					array(
						'key' => 'er_post_tags',
						'value' => serialize(strval($term->term_id)),
						'compare' => 'LIKE'
					),
					array(
						'key'   => '_wp_page_template',
						'value' => 'template-rating.php',
						'compare' => '!='
					),
				)
			);
		} else {
			$args = array(
				'post_type' => array('post','page'),
				'posts_per_page' => 3,
				'orderby' => 'date',
				'order' => 'DESC',
				'meta_query' => array(
					'relation'		=> 'AND',
					array(
						'key' => 'er_post_tags',
						'value' => serialize(strval($term->term_id)),
						'compare' => 'LIKE'
					),
					array(
						'key'   => '_wp_page_template',
						'value' => 'template-rating.php',
						'compare' => '!='
					),
				)
			);
		}*/
		$args = array(
			'post_type' => array('post','page'),
			'posts_per_page' => 15,
			'orderby' => 'date',
			'order' => 'DESC',
			'parent_alt_pages_hide' => 1,
			'meta_query' => array(
				'relation'		=> 'AND',
				array(
					'key' => 'er_post_tags',
					'value' => serialize(strval($term->term_id)),
					'compare' => 'LIKE'
				)
			)
		);
        
        $current_language = get_locale();
        if($current_language != 'ru_RU') {
            $args['meta_query'][] = array(
                'key'     => 'enable_translations',
                'value'   => $current_language,
                'compare' => 'LIKE'
            );
		} else {

			// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
			$args['turn_off_on_ru_language'] = 1;

		}

        $news = new WP_Query($args);

        if ( $news->have_posts() ) {
            
            $i = 0;
			$result_li = '';
            while ( $news->have_posts() ) {
                $news->the_post();
                global $post;
                if (get_page_template_slug($post->ID) == 'template-rating.php') {
                	continue;
				}
				$i = $i + 1;
				if ($i == 4) {
					break;
				}

				$author_id = isset($post->post_author) ? get_the_author_meta('ID', $post->post_author) : 0;
                $author = get_userdata($author_id);
				$user_alt_name = get_user_alt_name( $author_id, $current_language );

				if( $user_alt_name ) {
					$author_name = $user_alt_name;
				} elseif($author->first_name && !$author->last_name) {
                    $author_name = $author->first_name;
                } elseif(!$author->first_name && $author->last_name) {
                    $author_name = $author->last_name;
                } elseif($author->first_name && $author->last_name) {
                    $author_name = $author->first_name.' '.$author->last_name;
                } else {
                    $author_name = $author->user_nicename;
                }

                $attachment_id = get_field('photo_profile', 'user_'. $author_id );
                $thumb = get_the_post_thumbnail_url( $post_id, 'large' );
                $result_li .= '<li>';
                $result_li .= '<div class="author_avatar"';
                if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') {
                    $result_li .= ' style="background-image: url('.$attachment_id['sizes']['thumbnail'].');"';
                }
                $result_li .= '></div>';
                $result_li .= '<div class="news_middle">';
                $result_li .= '<a href="'.get_the_permalink().'" class="color_dark_blue link_no_underline font_bold font_small">'.get_the_title().'</a>';
                $result_li .= '<div class="news_list_meta flex">';
                $result_li .= '<div class="post_meta_author font_bold font_small color_dark_blue pointer">';
				$result_li .= $author_name;
                $result_li .= '</div>';
                $result_li .= '<div class="post_meta_date font_smaller color_dark_gray">'.get_the_date('F j Y',$post->ID).'</div>';
                $result_li .= '</div>';
                $result_li .= '</div>';
                $result_li .= '</li>';

            }
			wp_reset_postdata();
            
            if ($result_li != '') {
				$result .= '<div class="list_more_widget flex flex_column list_more_widget_2" data-tag="'.$term_slug.'" data-count="'.$news->post_count.'">';
				$result .= '<div class="flex_100 font_smaller_2 font_bolder font_uppercase color_dark_blue m_b_30">'.__('Еще по теме','er_theme').'</div>';
				$result .= '<ul class="white_block">';
				$result .= $result_li;
				$result .= '</ul>';
				$result .= '</div>';
			}
        }
        echo $result;
    }

}


if (!function_exists('list_more_included_blog_news')) {
	function list_more_included_blog_news($post_id) {
		$post_id = $post_id;
		if(get_post_type($post_id) == 'promocodes') {
			$post_id = get_field('promocode_review',$post_id);
		}
		$result = '';
		$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
		$term = get_term_by('name', $term_slug, 'affiliate-tags');
		
		$review_aff_tags = get_field('er_post_tags',$post_id);
		$term_id = $review_aff_tags[0];
		
		$args = array(
			'post_type' => array('post','page'),
			'posts_per_page' => 15,
			'orderby' => 'date',
			'order' => 'DESC',
			'parent_alt_pages_hide' => 1,
		);
		if (empty($term_id)) {
			$result = '';
			echo $result;
			return $result;
		}
		$dop_zagolovok = '';
		if (gettype(get_field('post_eshe_po_teme','affiliate-tags_'.$term_id)) == 'array' && count(get_field('post_eshe_po_teme','affiliate-tags_'.$term_id)) != 0) {
			if (gettype(get_field('post_eshe_po_teme',$post_id)) == 'array' && count(get_field('post_eshe_po_teme',$post_id)) != 0) {
				$args['post__in'] = get_field('post_eshe_po_teme',$post_id);
				$args['orderby'] = 'post__in';
				if (get_field('dop_zagolovok',$post_id)) {
					$dop_zagolovok = '<span class="dopzag">'.get_field('dop_zagolovok',$post_id).'</span>';
				}
				
			} else {
				$args['post__in'] = get_field('post_eshe_po_teme','affiliate-tags_'.$term_id);
				$args['orderby'] = 'post__in';
				if (get_field('dop_zagolovok','affiliate-tags_'.$term_id)) {
					$dop_zagolovok = '<span class="dopzag">' . get_field( 'dop_zagolovok', 'affiliate-tags_' . $term_id ) . '</span>';
				}
			}
			
		} else {
			if (gettype(get_field('post_eshe_po_teme',$post_id)) == 'array' && count(get_field('post_eshe_po_teme',$post_id)) != 0) {
				$args['post__in'] = get_field('post_eshe_po_teme',$post_id);
				$args['orderby'] = 'post__in';
				if (get_field('dop_zagolovok',$post_id)) {
					$dop_zagolovok = '<span class="dopzag">' . get_field( 'dop_zagolovok', $post_id ) . '</span>';
				}
			} else {
				$result = '';
				echo $result;
				return $result;
			}
		}
		
		if (empty($args['post__in'])) {
			$result = '';
			echo $result;
			return $result;
		}
		
		$current_language = get_locale();
		if($current_language != 'ru_RU') {
			$args['meta_query'][] = array(
				'key'     => 'enable_translations',
				'value'   => $current_language,
				'compare' => 'LIKE'
			);
		}
		
		$news_count = 0;
		$news = new WP_Query($args);
		if(is_array($news) || $news instanceof Countable) {
			$news_count = count($news);
		}
		
		if ( $news->have_posts() ) {
			$result .= '<div class="list_more_widget flex flex_column list_more_widget_1" data-tag="'.$term_id.'" data-count="'.$news_count.'">';
			$result .= '<div class="flex_100 font_smaller_2 font_bolder font_uppercase color_dark_blue m_b_30">'.__('Еще по теме','er_theme').' '.$dop_zagolovok.'</div>';
			$result .= '<ul class="white_block">';
			$i = 0;
			while ( $news->have_posts() ) {
				$news->the_post();
				global $post;
				if (get_page_template_slug($post->ID) == 'template-rating.php') {
					continue;
				}
				$i = $i + 1;
				$author_id = isset($post->post_author) ? get_the_author_meta('ID', $post->post_author) : 0;
				$author = get_userdata($author_id);
				$attachment_id = get_field('photo_profile', 'user_'. $author_id );
				$user_alt_name = get_user_alt_name( $author_id, $current_language );

				$thumb = get_the_post_thumbnail_url( $post_id, 'large' );
				$result .= '<li>';
				$result .= '<div class="author_avatar"';
				if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') {
					$result .= ' style="background-image: url('.$attachment_id['sizes']['thumbnail'].');"';
				}
				$result .= '></div>';
				$result .= '<div class="news_middle">';
				$result .= '<a href="'.get_the_permalink().'" class="color_dark_blue link_no_underline font_bold font_small">'.get_the_title().'</a>';
				$result .= '<div class="news_list_meta flex">';
				$result .= '<div class="post_meta_author font_bold font_small color_dark_blue pointer">';

				if( $user_alt_name ) {
					$result .= $user_alt_name;
				} elseif($author->first_name && !$author->last_name) {
					$result .= $author->first_name;
				} elseif(!$author->first_name && $author->last_name) {
					$result .= $author->last_name;
				} elseif($author->first_name && $author->last_name) {
					$result .= $author->first_name.' '.$author->last_name;
				} else {
					$result .= $author->user_nicename;
				}
				$result .= '</div>';
				$result .= '<div class="post_meta_date font_smaller color_dark_gray">'.get_the_date('F j Y',$post->ID).'</div>';
				$result .= '</div>';
				$result .= '</div>';
				$result .= '</li>';
				
			}
			$result .= '</ul>';
			
			wp_reset_postdata();
			$result .= '</div>';
		}
		echo $result;
		
		
	}
	
}


