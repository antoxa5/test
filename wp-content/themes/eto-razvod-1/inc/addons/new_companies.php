<?php




if (!function_exists('ajax_new_companies_block')) {
	add_action( 'wp_ajax_ajax_new_companies_block', 'ajax_new_companies_block' );
	add_action( 'wp_ajax_nopriv_ajax_new_companies_block', 'ajax_new_companies_block' );
	function ajax_new_companies_block() {
		$data = $_POST;
		$result = '';
		$post_id = $data['post_id'];
		if(get_post_type($post_id) == 'promocodes') {
			$post_id = get_field('promocode_review',$post_id);
		}
		$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
		$args = array(
				'post_type' => 'casino',
				'posts_per_page' => 3,
				'post_status' => 'publish',
				'orderby' => 'date',
				'order' => 'DESC',
				'post__not_in' => array ($post_id),
				'tax_query' => array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'name',
						'terms'    => $term_slug,
					),
				),
			);
        $current_language = get_locale();
        if($current_language != 'ru_RU') {
            $args['meta_query']['relation'] = 'AND';
            $args['meta_query'][] = array(
                'key'     => 'enable_translations',
                'value'   => $current_language,
                'compare' => 'LIKE'
            );
        }
		$reviews = new WP_Query( $args );
		if ( $reviews->have_posts() ) {
			$result .= '<div class="wrap new_companies_widget flex_column">';
			$result .= '<div class="color_dark_blue font_uppercase font_bolder font_smaller_2 m_b_30">'.__('Новые компании на сайте','er_theme').'</div>';
				$result .= '<ul class="flex new_companies_ul ul_content">';
				$iter = 0;
				while ( $reviews->have_posts() ) {
					$reviews->the_post();
					global $post;
					if(function_exists('get_rating_fields_group')) {
						$rating_fields_group = get_rating_fields_group($post->ID);
					} else {
						$rating_fields_group = 0;
					}
					$comments_count = get_comments_count( $post->ID, get_comment_rating_fields( $rating_fields_group, 'name' ) );
					$result .= '<li class="white_block flex flex_column">';
					$company_name = get_field('company_name',$post->ID);
					$result .='<div class="company_block_header flex">';
					$result .= '<div class="compare_container" id="p_c_compare_container_'.$post->ID.'" data-post-id="'.$post->ID.'">'.compare_icon($post->ID).'</div>';
					if (function_exists('review_logo')) {
						$result .= review_logo($post->ID);
					}
					$terms = get_the_terms($post->ID,'affiliate-tags');
					$result .= '<div class="flex flex_column">';
					$result .= '<a class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="'.get_the_permalink($post->ID).'">'.$company_name.'</a>';
					$result .= '<div class="font_small"><span class="color_dark_gray count_reviews">'.__('Отзывы','er_theme').'</span><span class="color_dark_blue">'.$comments_count['count'].'</span></div>';
					if(!empty($terms)) {
						$t_x = 0;
						$result .= '<ul class="company_card_tags flex">';
						foreach ($terms as $term) {
							$t_x++;
							if($t_x <= 3) {
								$result .= '<li class="color_dark_blue">' . get_field('tag_human_title', 'term_' . $term->term_id) . '</li>';
							}
						}
						$result .= '</ul>';
					}
					$result .='</div>';
					$result .='</div>';
					$result .='<div class="company_block_footer flex">';
					$result .= get_post_stars($rating_fields_group);
					$result .= review_top_rating($post->ID);
					$result .='</div>';
					$result .= '</li>';
					$iter = ++$iter;
				}
				$result .= '</ul>';

			$result .= '<span class="tabs_mobile_mover tabs_mobile_mover_new_companies_ul">';
			for ($i = 1;$i <= $iter;$i++) {
				if ($i == 1) {
					$result .= '<span class="tabs_mobile_mover__item tabs_mobile_mover__item_active" data-n="'.$i.'"></span>';
				} else {
					$result .= '<span class="tabs_mobile_mover__item" data-n="'.$i.'"></span>';
				}
			}
			$result .= '</span>';

			$result .= '</div>';
			}
			wp_reset_postdata();
		
		
		
		
		echo $result;
		die;
	}
}


function ajax_new_companies_block_php() {
	$result = '';
	$post_id = get_the_ID();
	if(get_post_type($post_id) == 'promocodes') {
		$post_id = get_field('promocode_review',$post_id);
	}
	$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
	$args = array(
		'post_type' => 'casino',
		'posts_per_page' => 3,
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC',
		'post__not_in' => array ($post_id),
		'tax_query' => array(
			array(
				'taxonomy' => 'affiliate-tags',
				'field'    => 'name',
				'terms'    => $term_slug,
			),
		),
	);
	$current_language = get_locale();
	if($current_language != 'ru_RU') {
		$args['meta_query']['relation'] = 'AND';
		$args['meta_query'][] = array(
			'key'     => 'enable_translations',
			'value'   => $current_language,
			'compare' => 'LIKE'
		);
	}
	$reviews = new WP_Query( $args );
	if ( $reviews->have_posts() ) {
		$result .= '<div class="wrap new_companies_widget flex_column">';
		$result .= '<div class="color_dark_blue font_uppercase font_bolder font_smaller_2 m_b_30">'.__('Новые компании на сайте','er_theme').'</div>';
		$result .= '<ul class="flex new_companies_ul ul_content">';
		$iter = 0;
		while ( $reviews->have_posts() ) {
			$reviews->the_post();
			global $post;
			if(function_exists('get_rating_fields_group')) {
				$rating_fields_group = get_rating_fields_group($post->ID);
			} else {
				$rating_fields_group = 0;
			}
			$comments_count = get_comments_count( $post->ID, get_comment_rating_fields( $rating_fields_group, 'name' ) );
			$result .= '<li class="white_block flex flex_column">';
			$company_name = get_field('company_name',$post->ID);
			$result .='<div class="company_block_header flex">';
			$result .= '<div class="compare_container" id="p_c_compare_container_'.$post->ID.'" data-post-id="'.$post->ID.'">'.compare_icon($post->ID).'</div>';
			if (function_exists('review_logo')) {
				$result .= review_logo($post->ID);
			}
			$terms = get_the_terms($post->ID,'affiliate-tags');
			$result .= '<div class="flex flex_column">';
			$result .= '<a class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="'.get_the_permalink($post->ID).'">'.$company_name.'</a>';
			$result .= '<div class="font_small"><span class="color_dark_gray count_reviews">'.__('Отзывы','er_theme').'</span><span class="color_dark_blue">'.$comments_count['count'].'</span></div>';
			if(!empty($terms)) {
				$t_x = 0;
				$result .= '<ul class="company_card_tags flex">';
				foreach ($terms as $term) {
					$t_x++;
					if($t_x <= 3) {
						$result .= '<li class="color_dark_blue">' . get_field('tag_human_title', 'term_' . $term->term_id) . '</li>';
					}
				}
				$result .= '</ul>';
			}
			$result .='</div>';
			$result .='</div>';
			$result .='<div class="company_block_footer flex">';
			$result .= get_post_stars($rating_fields_group);
			$result .= review_top_rating($post->ID);
			$result .='</div>';
			$result .= '</li>';
			$iter = ++$iter;
		}
		$result .= '</ul>';
		
		$result .= '<span class="tabs_mobile_mover tabs_mobile_mover_new_companies_ul">';
		for ($i = 1;$i <= $iter;$i++) {
			if ($i == 1) {
				$result .= '<span class="tabs_mobile_mover__item tabs_mobile_mover__item_active" data-n="'.$i.'"></span>';
			} else {
				$result .= '<span class="tabs_mobile_mover__item" data-n="'.$i.'"></span>';
			}
		}
		$result .= '</span>';
		
		$result .= '</div>';
	}
	wp_reset_postdata();
	
	
	
	
	return $result;
}

if (!function_exists('ajax_new_companies_block_included')) {
    function ajax_new_companies_block_included($post_id) {
        $result = '';
        $post_id = $post_id;
        if(get_post_type($post_id) == 'promocodes') {
            $post_id = get_field('promocode_review',$post_id);
        }
        $term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
        $args = array(
            'post_type' => 'casino',
            'posts_per_page' => 3,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'post__not_in' => array ($post_id),
            'tax_query' => array(
                array(
                    'taxonomy' => 'affiliate-tags',
                    'field'    => 'name',
                    'terms'    => $term_slug,
                ),
            ),
        );
        $current_language = get_locale();
        if($current_language != 'ru_RU') {
            $args['meta_query']['relation'] = 'AND';
            $args['meta_query'][] = array(
                'key'     => 'enable_translations',
                'value'   => $current_language,
                'compare' => 'LIKE'
            );
        }
        $reviews = new WP_Query( $args );
        if ( $reviews->have_posts() ) {
            $result .= '<div class="wrap new_companies_widget flex_column">';
            $result .= '<div class="color_dark_blue font_uppercase font_bolder font_smaller_2 m_b_30">'.__('Новые компании на сайте','er_theme').'</div>';
            $result .= '<ul class="flex new_companies_ul ul_content">';
            $iter = 0;
            while ( $reviews->have_posts() ) {
                $reviews->the_post();
                global $post;
                if(function_exists('get_rating_fields_group')) {
                    $rating_fields_group = get_rating_fields_group($post->ID);
                } else {
                    $rating_fields_group = 0;
                }
                $comments_count = get_comments_count( $post->ID, get_comment_rating_fields( $rating_fields_group, 'name' ) );
                $result .= '<li class="white_block flex flex_column">';
                $company_name = get_field('company_name',$post->ID);
                $result .='<div class="company_block_header flex">';
                $result .= '<div class="compare_container" id="p_c_compare_container_'.$post->ID.'" data-post-id="'.$post->ID.'">'.compare_icon($post->ID).'</div>';
                if (function_exists('review_logo')) {
                    $result .= review_logo($post->ID);
                }
                $terms = get_the_terms($post->ID,'affiliate-tags');
                $result .= '<div class="flex flex_column">';
                $result .= '<a class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="'.get_the_permalink($post->ID).'">'.$company_name.'</a>';
                $result .= '<div class="font_small"><span class="color_dark_gray count_reviews">'.__('Отзывы','er_theme').'</span><span class="color_dark_blue">'.$comments_count['count'].'</span></div>';
                if(!empty($terms)) {
                    $t_x = 0;
                    $result .= '<ul class="company_card_tags flex">';
                    foreach ($terms as $term) {
                        $t_x++;
                        if($t_x <= 3) {
                            $result .= '<li class="color_dark_blue">' . get_field('tag_human_title', 'term_' . $term->term_id) . '</li>';
                        }
                    }
                    $result .= '</ul>';
                }
                $result .='</div>';
                $result .='</div>';
                $result .='<div class="company_block_footer flex">';
                $result .= get_post_stars($rating_fields_group);
                $result .= review_top_rating($post->ID);
                $result .='</div>';
                $result .= '</li>';
                $iter = ++$iter;
            }
            $result .= '</ul>';

            $result .= '<span class="tabs_mobile_mover tabs_mobile_mover_new_companies_ul">';
            for ($i = 1;$i <= $iter;$i++) {
                if ($i == 1) {
                    $result .= '<span class="tabs_mobile_mover__item tabs_mobile_mover__item_active" data-n="'.$i.'"></span>';
                } else {
                    $result .= '<span class="tabs_mobile_mover__item" data-n="'.$i.'"></span>';
                }
            }
            $result .= '</span>';

            $result .= '</div>';
        }
        wp_reset_postdata();




        echo $result;
    }
}