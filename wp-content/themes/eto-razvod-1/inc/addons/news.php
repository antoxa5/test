<?php


if(!function_exists('news_tag_list')) {
    function news_tag_list($current) {

		$result = '';
		$args = array(
				'taxonomy' => 'affiliate-tags',
				'orderby' => 'meta_value',
				'order' => 'ASC',
				'meta_key' => 'tag_human_title',
				'hide_empty' => false,
				'hierarchical' => false,
				'meta_query' => array(
					array(
						'key'     => 'tag_human_title',
						'value'   => $prase,
						'compare' => 'LIKE'
					)
				)

			);

		$current_language = get_locale();

		if( $current_language != 'ru_RU' ) {
			$args['meta_query']['relation'] = 'AND';
			$args['meta_query'][] = array(
				'key'     => 'enable_translations',
				'value'   => $current_language,
				'compare' => 'LIKE'
			);
		// } else {
		// 	// Включаем признак для фильтрации таксономий с включенным чекбоксом "Отключить обзор на русском языке" через terms_clauses
		// 	$args['turn_off_on_ru_language'] = 1;		
		}

		$tags = get_terms( $args );
		if(!empty($tags)) {
			foreach($tags as $tag) {
				
				$args = array(
						'post_type' => 'page',
						'posts_per_page' => 30,
						'post_status' => 'publish',
						'orderby' => 'date',
						'order' => 'DESC',
					);
				// $args['meta_query'] = array(
				// 	'relation' => 'OR',
				// 	array(
				// 		'key'     => 'hide_from_news',
				// 		'value'   => '0',
				// 		'compare' => '=',
				// 	),
				// 	array(
				// 		'key'     => 'hide_from_news',
				// 		'value'   => '',
				// 		'compare' => 'NOT EXISTS'
				// 	)
				// );

				// Включаем признак для фильтрации записей с включенным чекбоксом "Скрыть в новостях" через posts_clauses
				$args['posts_hide_from_news'] = 1;

				if( $current_language == 'ru_RU' ) {
					// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
					$args['turn_off_on_ru_language'] = 1;		
				}

				$args['tax_query'] = array(
							'relation' => 'OR',
					);
				$args['tax_query'][] = array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'id',
					'terms'    => array($tag->term_id),
				);
				$news = new WP_Query($args);

				$count_all_news = $news->found_posts;

				if($count_all_news > 0) {
					$human_title = get_field('tag_human_title','term_'.$tag->term_id);
					if(!$human_title || $human_title == '') {
						continue;
					} elseif($tag->term_id == $current) {
						if (isRussian(mb_substr($human_title, 0, 1))) {
							$cyr[] = '<li data-id="'.$tag->term_id.'" data-slug="'.$tag->slug.'"><span>'.$human_title.'</span></li>';
						} else {
							$eng[] = '<li data-id="'.$tag->term_id.'" data-slug="'.$tag->slug.'"><span>'.$human_title.'</span></li>';
						}
					} else {
						if (isRussian(mb_substr($human_title, 0, 1))) {
							$cyr[] = '<li data-id="'.$tag->term_id.'" data-slug="'.$tag->slug.'"><a href="'.get_bloginfo('url').'/pages/'.$tag->slug.'/">'.$human_title.'</a></li>';
						} else {
							$eng[] = '<li data-id="'.$tag->term_id.'" data-slug="'.$tag->slug.'"><a href="'.get_bloginfo('url').'/pages/'.$tag->slug.'/">'.$human_title.'</a></li>';
						}
					}
				}
			
			}
		}

		if(!empty($cyr) || !empty($eng)) {
			$result .= '<ul class="news_tag_list asfsf">';
			foreach ( $cyr as $item ) {
				$result .= $item;
			}
			foreach ( $eng as $item ) {
				$result .= $item;
			}
			$result .= '</ul>';
		}

		return $result;
	}
}

if(!function_exists('single_post')) {
    function single_post($post_id) {
        $result = '';
        $author_id = get_the_author_meta( 'ID' );
		// $author_id = get_the_author_ID($post_id);

		$current_language = get_locale();

        $author = get_userdata($author_id);
        $attachment_id = get_field('photo_profile', 'user_'. $author_id );
		$user_status = get_field('user_site_statuses','user_'.$author_id);
		$user_alt_name = get_user_alt_name( $author_id, $current_language );

		if(!empty($user_status) && $user_status['value'] != 'none') {
				$user_status_label = '<span class="user_comment_status status_'.$user_status['value'].' user_label font_smaller" >'.$user_status['label'].'</span>';
			}  else {
				$user_status_label = '';
			}
        $thumb = get_the_post_thumbnail_url( $post_id, 'large' );
        $result .= '<div class="white_block flex flex_column">';
            $result .= '<div class="block_header flex">';
                $result .= '<div class="author_avatar"';
                if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') {
                    $result .= ' style="background-image: url('.$attachment_id['sizes']['thumbnail'].');"';
                }
                $result .= '></div>';
                $result .= '<div class="post_meta">';
                    $result .= '<div class="post_meta_author font_bold font_small color_dark_blue pointer">';

					if( $user_alt_name ) {
						$result .= $user_alt_name;
					} elseif( $author->first_name && !$author->last_name ) {
                        $result .= $author->first_name;
                    } elseif( !$author->first_name && $author->last_name ) {
                        $result .= $author->last_name;
                    } elseif( $author->first_name && $author->last_name ) {
                        $result .= $author->first_name.' '.$author->last_name;
                    } else {
                        $result .= $author->user_nicename;
                    }

					$result .= $user_status_label;
                    $result .= '</div>';
                    $result .= '<div class="post_meta_date font_smaller color_dark_gray">'.get_the_date('F j Y',$post_id).'</div>';
                $result .= '</div>';
            $result .= '</div>';
            if($thumb && $thumb != '') {
                $result .= '<div class="post_image" style="background-image: url('.$thumb.');"></div>';
            }
            $result .= '<a class="news_title font_medium_new font_bold color_dark_blue link_no_underline" href="'.get_the_permalink($post_id).'">'.get_the_title($post_id).'</a>';
			$excerpt = get_the_excerpt($post_id);
			if($excerpt && $excerpt != '') {
				$result .= '<div class="news_execrpt color_dark_blue">'.$excerpt.'</div>';
			}
            $terms = get_the_terms( $post_id, 'affiliate-tags' );
            $result .= '<div class="news_footer flex">';
                $result .= '<span class="news_comments_count color_dark_gray font_small">'.get_comments_number( $post_id ).'</span>';
                if(!empty($terms)) {
                    $t_x = 0;
                    $result .= '<ul class="company_card_tags font_small flex">';
                    foreach ($terms as $term) {
                        $t_x++;
                        if($t_x <= 3) {
                            $result .= '<li class="color_dark_blue">' . get_field('tag_human_title', 'term_' . $term->term_id) . '</li>';
                        }
                    }
                    $result .= '</ul>';
                }
                $result .= '<div class="review_icon_share pointer m_l_auto" data-type="share_post" data-id="'.$post_id.'"></div>';
            $result .= '</div>';
        $result .= '</div>';
        return $result;
    }
}

if (!function_exists('er_pagination')) {


function er_pagination($pages = '', $range = 4)
{
$showitems = ($range)+1;

global $paged;
if(empty($paged)) $paged = 1;

if($pages == '')
{
global $wp_query;
$pages = $wp_query->max_num_pages;
if(!$pages)
{
$pages = 1;
}
}

if(1 != $pages)
{
echo "<div class='pagination'>";
    //if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'> &laquo;</a>";
    if($paged > 1 ) echo "<a class='last' href='".get_pagenum_link($paged - 1)."'>&laquo; ".__('Предыдущая','er_theme')."</a>";

    for ($i=1; $i <= $pages; $i++)
    {
    if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
    {
    echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
    }
    }

    if ($paged < $pages ) echo "<a class='last' href='".get_pagenum_link($paged + 1)."'>".__('Следующая','er_theme')." &raquo;</a>";
    //if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
    echo "</div>\n";
}
}

}



	
if (!function_exists('resort_news_tags')) {
	add_action( 'wp_ajax_resort_news_tags', 'resort_news_tags' );
	add_action( 'wp_ajax_nopriv_resort_news_tags', 'resort_news_tags' );

	function resort_news_tags(){
		$data = $_POST;
		//print_r($data);
		
		$args = array(
			'post_type' => array('page'),
			'posts_per_page' => 30,
			'post_status' => 'publish',
			'orderby' => 'date',
			'order' => 'DESC',
			'offset' => $offset
		);
		// $args['meta_query'] = array(
		// 	'relation' => 'OR',
		// 	array(
		// 		'key'     => 'hide_from_news',
		// 		'value'   => '0',
		// 		'compare' => '=',
		// 	),
		// 	array(
		// 		'key'     => 'hide_from_news',
		// 		'value'   => '',
		// 		'compare' => 'NOT EXISTS'
		// 	)
		// );

		// Включаем признак для фильтрации записей с включенным чекбоксом "Скрыть в новостях" через posts_clauses
		$args['posts_hide_from_news'] = 1;

		$current_language = get_locale();
		if($current_language == 'ru_RU') {
			// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
			$args['turn_off_on_ru_language'] = 1;		
		}

		if(!empty($data['tags'])) {
			$all_tags = implode( ',', $data['tags'] );
			$args['tax_query'] = array(
				'relation' => 'OR',
			);
			if(!empty($data['tags'])) {
				$args['tax_query'][] = array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'id',
					'terms'    => $data['tags'],
				);
			}

		} else {
			$all_tags = 'all';
		}

		$news = new WP_Query($args);
		$count_all_news = $news->found_posts;
		if ( $news->have_posts() ) { ?><?php
			while ( $news->have_posts() ) {
				$news->the_post();
				global $post;
				echo single_post($post->ID);

				?>

				<?php
			} ?>

		<?php }?>
		<?php
		wp_reset_postdata();

		if($count_all_news > 30) {
			$result .= '<div class="button button_comments button_green pointer load_more_news font_small font_bold m_b_20" data-offset="30" data-total="'.$count_all_news.'" data-tag="'.$all_tags.'">'.__('Загрузить еще','er_theme').'</div>';
		}
		echo $result;
		die;
	}
}

if (!function_exists('load_more_news')) {
	add_action( 'wp_ajax_load_more_news', 'load_more_news' );
	add_action( 'wp_ajax_nopriv_load_more_news', 'load_more_news' );

	function load_more_news(){
		$data = $_POST;
		$tag = $data['tag'];
		if($tag != 'all') {
			$tags_array = explode(',',$tag);
		} else {
			$tags_array = array();
		}
		$offset = $data['offset'];
		$total = $data['total'];
		$result = '';
		$new_offset = $offset + 30;
		$args = array(
			'post_type' => array('page'),
			'posts_per_page' => 30,
			'orderby' => 'date',
			'post_status' => 'publish',
			'order' => 'DESC',
			'offset' => $offset
		);
		// $args['meta_query'] = array(
		// 	'relation' => 'OR',
		// 	array(
		// 		'key'     => 'hide_from_news',
		// 		'value'   => '0',
		// 		'compare' => '=',
		// 	),
		// 	array(
		// 		'key'     => 'hide_from_news',
		// 		'value'   => '',
		// 		'compare' => 'NOT EXISTS'
		// 	)
		// );

		$current_language = get_locale();
		if($current_language == 'ru_RU') {
			// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
			$args['turn_off_on_ru_language'] = 1;		
		}

		// Включаем признак для фильтрации записей с включенным чекбоксом "Скрыть в новостях" через posts_clauses
		$args['posts_hide_from_news'] = 1;

		if(!empty($tags_array)) {
			$args['tax_query'] = array(
				'relation' => 'OR',
			);
			if(!empty($tags_array)) {
				$args['tax_query'][] = array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'id',
					'terms'    => $tags_array,
				);
			}

		}

		$news = new WP_Query($args);
		$count_all_news = $news->found_posts;
		if ( $news->have_posts() ) { ?><?php
			while ( $news->have_posts() ) {
				$news->the_post();
				global $post;
				echo single_post($post->ID);

				?>

				<?php
			} ?>

		<?php }?>
		<?php
		wp_reset_postdata();

		if($new_offset < $total) {
		$result .= '<div class="button button_comments button_green pointer load_more_news font_small font_bold m_b_20" data-offset="'.$new_offset.'" data-total="'.$total.'" data-tag="'.$tag.'">'.__('Загрузить еще','er_theme').'</div>';
		}
		echo $result;
		die;
	}
}

if( !function_exists( 'get_template_for_company_news' ) ) {

	function get_template_for_company_news( $template ) {

		global $wp;

		if( strlen( $wp->request ) ) {

			$post_type = '';
			$company_slug = '';
			$is_news = false;
			$company_name = '';

			$slugs = explode( '/', $wp->request );

			if( count( $slugs ) == 3 ) {

				list( $post_type, $company_slug, $is_news ) = $slugs;
				$is_news = ( $is_news == 'news' ) ? true : false;

				if( $is_news and $company_slug ) {

					// $new_template = locate_template( array( 'news.php' ) );
					$new_template = locate_template( array( 'single-casino.php' ) );

					if( $new_template ) {
						$template = $new_template;
					}

				}

			}

		}

		return $template;

	}

}

if (!function_exists('get_post_id_by_meta_key_and_value')) {
	/**
	 * Get post id from meta key and value
	 * @param string $key
	 * @param mixed $value
	 * @return int|bool
	 * @author David M&aring;rtensson <david.martensson@gmail.com>
	 */
	function get_post_id_by_meta_key_and_value( $key, $value ) {
		global $wpdb;
		$meta = $wpdb->get_results("SELECT * FROM `".$wpdb->postmeta."` WHERE meta_key='".$wpdb->escape($key)."' AND meta_value='".$wpdb->escape($value)."'");
		if (is_array($meta) && !empty($meta) && isset($meta[0])) {
			$meta = $meta[0];
		}		
		if (is_object($meta)) {
			return $meta->post_id;
		}
		else {
			return false;
		}
	}
}
