<?php

if(!function_exists('widget_best_companies')) {
	function widget_best_companies($post_id) {
		$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
		$term = get_term_by('name', $term_slug, 'affiliate-tags');
		$tag_human_title = get_field('er_bc_text','term_'.$term->term_id);
		if(!$tag_human_title || $tag_human_title == '') {
			$tag_human_title = __('Лучшие компании в рейтинге','er_theme');
		}
		$result = '';
		$args = array(
				'post_type' => 'casino',
				'posts_per_page' => 3,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'tax_query' => array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'name',
						'terms'    => $term_slug,
					),
				),
			);
		$args_all = $args;
		$args_all['posts_per_page'] = -1;
		$all_reviews = new WP_Query( $args );
		$all_reviews_all = new WP_Query( $args_all );
		$all_count = $all_reviews_all->found_posts;
		$y = 0;
		if ( $all_reviews->have_posts() ) { 
			
			$result .= '<div class="side_block white_block">';
				$result .= '<div class="block_title font_smaller_2 font_bolder font_uppercase color_dark_blue">'.$tag_human_title.'</div>';
				$result .= '<div class="block_content">';
				$result .= '<div class="color_dark_gray font_smaller_2 company_in_rating_heading flex">';
				$result .= '<span>'.__('Компания','er_theme').'</span>';
				$result .= '<span class="c_i_r_heading_place">'.__('Место','er_theme').'</span>';
				$result .= '</div>';
				while ( $all_reviews->have_posts() ) {
					$all_reviews->the_post();
					global $post;
					$y++;
					if($y == 3) {
						$last = ' last';
					} else {
						$last = '';
					}
					if($y % 2 == 0){
						$oddeven = 'even'; 
					} else{
						$oddeven = 'odd'; 
					}
					$company_name = get_field('company_name',$post->ID);
					$result .= '<div class="company_in_rating_item flex'.$last.' '.$oddeven.'">';
					$result .= review_logo($post->ID);
					$result .= '<span class="font_smaller c_i_r_title font_bold font_18"><a href="'.get_the_permalink($post->ID).'" target="_blank" class="color_dark_blue link_no_underline">'.$company_name.'</a></span>';
					$result .= '<div class="font_smaller_2 c_i_r_place color_dark_gray c_1"><span class="color_dark_blue font_bold font_18">'.$y.'</span>/'.$all_count.'</div>';
					$result .= '</div>';
				}
			wp_reset_postdata();
			
				$result .= '</div>';
			$result .= '</div>';
		}
		return $result;
	}
}

if(!function_exists('widget_sidebar_old_companies')) {
	function widget_sidebar_old_companies($post_id) {
		$result = '';
		$page_term_list = wp_get_post_terms( $post_id, 'affiliate-tags', array('fields' => 'ids') );
		$page_term = $page_term_list[0];
		if(!$page_term) {
            $page_term = get_field('er_post_tags')[0];
        }
        if($page_term) {
            $p_term = $page_term;
        } else {
            $p_term = 1065;
        }
		if (!empty(get_field('tag_widgets','term_'.$p_term))) {
            $custom_widgets = get_field('tag_widgets','term_'.$p_term);
        } else {
            $custom_widgets = get_field('tag_widgets','term_1065');
        }
		$i = 0;
		if (!empty($custom_widgets)) {
            foreach ($custom_widgets as $w) {
				$fields = get_fields($w);
				$widget_tag = $fields['tag'];
                
				if($widget_tag == $p_term) {
					continue;
				}
				$i++;
				if($i == 4) {
					break;
				}
                $widget_title = $fields['widget_title'];
				$widget_link_title = $fields['widget_link_title'];
                $widget_link_url = $fields['widget_link_url'];
				
				$loop = new WP_Query( array( 'post_type' => 'casino', 'post_status' => 'publish', 'posts_per_page' => '3', 'order'=> 'ASC', 'orderby'=>'menu_order',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'affiliate-tags',
                            'field'    => 'id',
                            'terms'    => $widget_tag,
                        ),
                    ),
                ) );
                $all_count = $loop->found_posts;
				
				if(!empty($loop->posts)) {
				$x=0;
				$result .= '<div class="side_block white_block">';
					$result .= '<div class="block_title font_smaller_2 font_bolder font_uppercase color_dark_blue">'.$widget_title.'</div>';
					$result .= '<div class="block_content">';
						$result .= '<div class="color_dark_gray font_smaller_2 company_in_rating_heading flex">';
						$result .= '<span>'.__('Компания','er_theme').'</span>';
						$result .= '<span class="c_i_r_heading_place">'.__('Место','er_theme').'</span>';
						$result .= '</div>';
						foreach($loop->posts as $p) {
							$x++;
							if($x == 3) {
								$last = ' last';
							} else {
								$last = '';
							}
							if($x % 2 == 0){
								$oddeven = 'even'; 
							} else{
								$oddeven = 'odd'; 
							}
							$company_name = get_field('company_name',$p->ID);
							$result .= '<div class="company_in_rating_item flex'.$last.' '.$oddeven.'">';
							$result .= review_logo($p->ID);
							$result .= '<span class="font_smaller c_i_r_title font_bold font_18"><a href="'.get_the_permalink($p->ID).'" target="_blank" class="color_dark_blue link_no_underline">'.$company_name.'</a></span>';
							$result .= '<div class="font_smaller_2 c_i_r_place color_dark_gray c4"><span class="color_dark_blue font_bold font_18">'.$x.'</span>/'.$all_count.'</div>';
							$result .= '</div>';
						}
					$result .= '</div>';
				$result .= '</div>';
				}
			}
		}
		
		
		
		return $result;
	}
}

function new_array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}
if(!function_exists('widget_company_in_ratings')) {
	function widget_company_in_ratings($post_id, $type = '') {
		$terms = get_the_terms($post_id,'affiliate-tags');
		// $all_reviews = new WP_Query( $args );
		$result = '';
		if(!empty($terms)) {
			if ($type == 'rate_page_dashboard') {
				$result .= '<div class="side_block white_block '.$type.' border_radius_4px white_block" >';
			} else {
				$result .= '<div class="side_block white_block '.$type.'" id="company_in_ratings_widget">';
			}

				$result .= '<div class="block_title font_smaller_2 font_bolder font_uppercase color_dark_blue">'.__('Компания в рейтингах','er_theme').'</div>';
			$result .= '<div class="block_content">';
			$result .= '<div class="color_dark_gray font_smaller_2 company_in_rating_heading flex">';
			if ($type == 'rate_page_dashboard') {
				$result .= '<span class="rate_page_dashboard_title font_smaller border_no_color color_dark_blue">'.__('За неделю','er_theme').'</span>';
				$result .= '<span class="rate_page_dashboard_title font_smaller border_no_color">'.__('За месяц','er_theme').'</span>';
				$result .= '<span class="rate_page_dashboard_title font_smaller border_no_color">'.__('За год','er_theme').'</span>';
				$result .= '<span class="c_i_r_heading_place font_smaller border_no_color">'.__('Как формируются рейтинги','er_theme').'</span>';
			} else {
				$result .= '<span>'.__('Рейтинг','er_theme').'</span>';
				$result .= '<span class="c_i_r_heading_place">'.__('Место','er_theme').'</span>';
			}
			$result .= '</div>';
			$terms_array = array();
			foreach ($terms as $term) {
						$terms_array[] = $term->term_id;
					}
			$new_ratings_array = array();

			$args_pages = array(
				'post_type'		=> 'page',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'meta_query'	=> array(
					array(
						'key'	 	=> 'rating_tag',
						'value'	  	=> $terms_array,
						'compare' 	=> 'IN',
					),
				),	
			);

			// Фильтруем записи, у которых есть альтернативные страницы на текущем языке
			$args_pages['alt_pages_hide'] = 1;

			// $pages = get_posts($args_pages);
			$pages = new WP_Query( $args_pages );
			// $count_pages = count($pages);

			if(is_array($pages) || $pages instanceof Countable) {
				$count_pages = count($pages);
			} else {
				$count_pages = 0;
			}

			$y = 0;
			if ( ! empty( $pages->posts ) )
			foreach($pages->posts as $page){
				$y++;
				if($y == $count_pages) {
					$last = ' last';
				} else {
					$last = '';
				}
				if($y % 2 == 0){
					$oddeven = 'even'; 
				} else{
					$oddeven = 'odd'; 
				}
				if(get_field('rating_list_description',$page->ID)) {
					$rating_title = get_field('rating_list_description',$page->ID);
				} else {
					$rating_title = get_the_title($page->ID);	
				}
				$tag_term = get_term( get_field('rating_tag',$page->ID), 'affiliate-tags' );
				$tag = $tag_term->slug;
				$fields = get_field('more_fields',$page->ID);
				$args = array(
					'post_type' => 'casino',
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'tax_query' => array(
						array(
							'taxonomy' => 'affiliate-tags',
							'field'    => 'name',
							'terms'    => $tag,
						),
					),
				);
				
				if ( ! empty( $fields ) ) {
					include (TEMPLATEPATH . '/inc/rating_includes.php');
				}
				
				

				$reviews_array = array();
				$all_reviews = new WP_Query( $args );
				
				$current_language = get_locale();
				if ( $current_language == 'en_US' ) {
					
					wp_reset_postdata();
					$args_a = array(
						//'post_type'      => 'casino',
						'post_type'      => 'casino',
						'orderby'        => 'menu_order',
						'posts_per_page' => - 1,
						'order'          => 'ASC',
						'post_status'    => 'publish',
						'meta_query'     => array(
							'relation' => 'AND',
							array(
								'key'     => 'languages_en_us_sorting',
								'value'   => '',
								'compare' => '!=',
							),
						),
						'tax_query'      => array(
							array(
								'taxonomy' => 'affiliate-tags',
								'field'    => 'name',
								'terms'    => $tag,
							),
						)
					);
					
					$reviews2 = new WP_Query( $args_a );
					
					if ( $reviews2->have_posts() ) {
						while ( $reviews2->have_posts() ) {
							$reviews2->the_post();
							
						}
					}
					
					wp_reset_postdata();
					if ( count( $reviews2->posts ) > 0 ) {
						foreach ( $reviews2->posts as $item ) {
							//$item->menu_order = get_field('languages_en_us_sort',$item->ID);
							foreach ( $all_reviews->posts as $key => $item2 ) {
								if ( $item2->ID == $item->ID ) {
									/*unset($all_reviews->posts[$key]);
									$all_reviews->posts[$key] = $item;*/
									$all_reviews->posts[ $key ]->menu_order = get_field( 'languages_en_us_sorting', $item->ID );
								}
							}
						}
						
						$menu_order = [];
						foreach ( $all_reviews->posts as $key => $row ) {
							$menu_order[ $key ] = $row->menu_order;
						}
						array_multisort( $menu_order, SORT_ASC, $all_reviews->posts );
					}
				} elseif ( $current_language == 'fr_FR' ) {
					wp_reset_postdata();
					$args_a = array(
						//'post_type'      => 'casino',
						'post_type'      => 'casino',
						'orderby'        => 'menu_order',
						'posts_per_page' => - 1,
						'order'          => 'ASC',
						'post_status'    => 'publish',
						'meta_query'     => array(
							'relation' => 'AND',
							array(
								'key'     => 'languages_fr_fr_sorting',
								'value'   => '',
								'compare' => '!=',
							),
						),
						'tax_query'      => array(
							array(
								'taxonomy' => 'affiliate-tags',
								'field'    => 'name',
								'terms'    => $tag,
							),
						)
					);
					
					$reviews2 = new WP_Query( $args_a );
					
					if ( $reviews2->have_posts() ) {
						while ( $reviews2->have_posts() ) {
							$reviews2->the_post();
							
						}
					}
					
					wp_reset_postdata();
					if ( count( $reviews2->posts ) > 0 ) {
						foreach ( $reviews2->posts as $item ) {
							foreach ( $all_reviews->posts as $key => $item2 ) {
								if ( $item2->ID == $item->ID ) {
									$all_reviews->posts[ $key ]->menu_order = get_field( 'languages_fr_fr_sorting', $item->ID );
								}
							}
						}
						
						$menu_order = [];
						foreach ( $all_reviews->posts as $key => $row ) {
							$menu_order[ $key ] = $row->menu_order;
						}
						array_multisort( $menu_order, SORT_ASC, $all_reviews->posts );
					}
				} elseif ( $current_language == 'es_ES' ) {
					wp_reset_postdata();
					$args_a = array(
						//'post_type'      => 'casino',
						'post_type'      => 'casino',
						'orderby'        => 'menu_order',
						'posts_per_page' => - 1,
						'order'          => 'ASC',
						'post_status'    => 'publish',
						'meta_query'     => array(
							'relation' => 'AND',
							array(
								'key'     => 'languages_es_es_sorting',
								'value'   => '',
								'compare' => '!=',
							),
						),
						'tax_query'      => array(
							array(
								'taxonomy' => 'affiliate-tags',
								'field'    => 'name',
								'terms'    => $tag,
							),
						)
					);
					
					$reviews2 = new WP_Query( $args_a );
					
					if ( $reviews2->have_posts() ) {
						while ( $reviews2->have_posts() ) {
							$reviews2->the_post();
							
						}
					}
					
					wp_reset_postdata();
					if ( count( $reviews2->posts ) > 0 ) {
						foreach ( $reviews2->posts as $item ) {
							foreach ( $all_reviews->posts as $key => $item2 ) {
								if ( $item2->ID == $item->ID ) {
									$all_reviews->posts[ $key ]->menu_order = get_field( 'languages_es_es_sorting', $item->ID );
								}
							}
						}
						
						$menu_order = [];
						foreach ( $all_reviews->posts as $key => $row ) {
							$menu_order[ $key ] = $row->menu_order;
						}
						array_multisort( $menu_order, SORT_ASC, $all_reviews->posts );
					}
				} elseif ( $current_language == 'de_DE' ) {
					wp_reset_postdata();
					$args_a = array(
						//'post_type'      => 'casino',
						'post_type'      => 'casino',
						'orderby'        => 'menu_order',
						'posts_per_page' => - 1,
						'order'          => 'ASC',
						'post_status'    => 'publish',
						'meta_query'     => array(
							'relation' => 'AND',
							array(
								'key'     => 'languages_de_de_sorting',
								'value'   => '',
								'compare' => '!=',
							),
						),
						'tax_query'      => array(
							array(
								'taxonomy' => 'affiliate-tags',
								'field'    => 'name',
								'terms'    => $tag,
							),
						)
					);
					
					$reviews2 = new WP_Query( $args_a );
					
					if ( $reviews2->have_posts() ) {
						while ( $reviews2->have_posts() ) {
							$reviews2->the_post();
							
						}
					}
					
					wp_reset_postdata();
					if ( count( $reviews2->posts ) > 0 ) {
						foreach ( $reviews2->posts as $item ) {
							foreach ( $all_reviews->posts as $key => $item2 ) {
								if ( $item2->ID == $item->ID ) {
									$all_reviews->posts[ $key ]->menu_order = get_field( 'languages_de_de_sorting', $item->ID );
								}
							}
						}
						
						$menu_order = [];
						foreach ( $all_reviews->posts as $key => $row ) {
							$menu_order[ $key ] = $row->menu_order;
						}
						array_multisort( $menu_order, SORT_ASC, $all_reviews->posts );
					}
					
				} elseif ( $current_language == 'pl_PL' ) {
					wp_reset_postdata();
					$args_a = array(
						//'post_type'      => 'casino',
						'post_type'      => 'casino',
						'orderby'        => 'menu_order',
						'posts_per_page' => - 1,
						'order'          => 'ASC',
						'post_status'    => 'publish',
						'meta_query'     => array(
							'relation' => 'AND',
							array(
								'key'     => 'languages_pl_pl_sorting',
								'value'   => '',
								'compare' => '!=',
							),
						),
						'tax_query'      => array(
							array(
								'taxonomy' => 'affiliate-tags',
								'field'    => 'name',
								'terms'    => $tag,
							),
						)
					);
					
					$reviews2 = new WP_Query( $args_a );
					
					if ( $reviews2->have_posts() ) {
						while ( $reviews2->have_posts() ) {
							$reviews2->the_post();
							
						}
					}
					
					wp_reset_postdata();
					if ( count( $reviews2->posts ) > 0 ) {
						foreach ( $reviews2->posts as $item ) {
							foreach ( $all_reviews->posts as $key => $item2 ) {
								if ( $item2->ID == $item->ID ) {
									$all_reviews->posts[ $key ]->menu_order = get_field( 'languages_pl_pl_sorting', $item->ID );
								}
							}
						}
						
						$menu_order = [];
						foreach ( $all_reviews->posts as $key => $row ) {
							$menu_order[ $key ] = $row->menu_order;
						}
						array_multisort( $menu_order, SORT_ASC, $all_reviews->posts );
					}
					
				} elseif ( $current_language == 'fi' ) {
					wp_reset_postdata();
					$args_a = array(
						//'post_type'      => 'casino',
						'post_type'      => 'casino',
						'orderby'        => 'menu_order',
						'posts_per_page' => - 1,
						'order'          => 'ASC',
						'post_status'    => 'publish',
						'meta_query'     => array(
							'relation' => 'AND',
							array(
								'key'     => 'languages_fi_sorting',
								'value'   => '',
								'compare' => '!=',
							),
						),
						'tax_query'      => array(
							array(
								'taxonomy' => 'affiliate-tags',
								'field'    => 'name',
								'terms'    => $tag,
							),
						)
					);
					
					$reviews2 = new WP_Query( $args_a );
					
					if ( $reviews2->have_posts() ) {
						while ( $reviews2->have_posts() ) {
							$reviews2->the_post();
							
						}
					}
					
					wp_reset_postdata();
					if ( count( $reviews2->posts ) > 0 ) {
						foreach ( $reviews2->posts as $item ) {
							foreach ( $all_reviews->posts as $key => $item2 ) {
								if ( $item2->ID == $item->ID ) {
									$all_reviews->posts[ $key ]->menu_order = get_field( 'languages_fi_sorting', $item->ID );
								}
							}
						}
						
						$menu_order = [];
						foreach ( $all_reviews->posts as $key => $row ) {
							$menu_order[ $key ] = $row->menu_order;
						}
						array_multisort( $menu_order, SORT_ASC, $all_reviews->posts );
					}
					
				} elseif ( $current_language == 'id_ID' ) {
					wp_reset_postdata();
					$args_a = array(
						//'post_type'      => 'casino',
						'post_type'      => 'casino',
						'orderby'        => 'menu_order',
						'posts_per_page' => - 1,
						'order'          => 'ASC',
						'post_status'    => 'publish',
						'meta_query'     => array(
							'relation' => 'AND',
							array(
								'key'     => 'languages_id_id_sorting',
								'value'   => '',
								'compare' => '!=',
							),
						),
						'tax_query'      => array(
							array(
								'taxonomy' => 'affiliate-tags',
								'field'    => 'name',
								'terms'    => $tag,
							),
						)
					);
					
					$reviews2 = new WP_Query( $args_a );
					
					if ( $reviews2->have_posts() ) {
						while ( $reviews2->have_posts() ) {
							$reviews2->the_post();
							
						}
					}
					
					wp_reset_postdata();
					if ( count( $reviews2->posts ) > 0 ) {
						foreach ( $reviews2->posts as $item ) {
							foreach ( $all_reviews->posts as $key => $item2 ) {
								if ( $item2->ID == $item->ID ) {
									$all_reviews->posts[ $key ]->menu_order = get_field( 'languages_id_id_sorting', $item->ID );
								}
							}
						}
						
						$menu_order = [];
						foreach ( $all_reviews->posts as $key => $row ) {
							$menu_order[ $key ] = $row->menu_order;
						}
						array_multisort( $menu_order, SORT_ASC, $all_reviews->posts );
					}
					
				}

				$count_all = $all_reviews->found_posts;
				$c_y  = 0;

				/*if ( $all_reviews->have_posts() ) {
					while ( $all_reviews->have_posts() ) {
					$all_reviews->the_post();
						$c_y++;
						global $post;
						if($post->ID == $post_id) {
							$rating_number = $c_y;
							$new_ratings_array[] = array(
								'id' => $page->ID,
								'count_all' => $count_all,
								'title' => $rating_title,
								'number' => $rating_number
							);
							break;
						} else {
							$rating_number = 0;
						}
						//$reviews_array[] = $post->ID;
					}
				}
				wp_reset_postdata();*/
				$i_c = 0;
				$i_check = 0;
				foreach ($all_reviews->posts as $item) {
					$i_c = ++$i_c;
					if ($item->ID == $post_id) {
						$i_check = 1;
						$rating_number = $i_c;
						break;
					}
				}
				if ($i_check == 0) {
					$rating_number = 0;
				} else {
					$new_ratings_array[] = array(
						'id' => $page->ID,
						'count_all' => $count_all,
						'title' => $rating_title,
						'number' => $rating_number
					);
				}
				
				//print_r($reviews_array);
				//echo $post_id;
				/*if($rating_number != 0) {
				$result .= '<div class="company_in_rating_item flex'.$last.' '.$oddeven.'">';
				$result .= '<span class="c_i_r_icon">'.mb_substr($rating_title,0,1).'</span>';
				$result .= '<span class="font_smaller c_i_r_title"><a href="'.get_the_permalink($page->ID).'" target="_blank" class="color_dark_blue link_no_underline">'.$rating_title.'</a></span>';
				$result .= '<div class="font_smaller_2 c_i_r_place color_dark_gray c2"><span class="color_dark_blue font_bold font_18">'.$rating_number.'</span>/'.$count_all.'</div>';
				$result .= '</div>';
				}*/
			}	
				if(!empty($new_ratings_array)) {
				//usort($new_ratings_array, function($a, $b){ return $a['optionNumber'] <=> $b['optionNumber']; });
				$n_aaaa = new_array_sort($new_ratings_array, 'count_all', SORT_DESC);
				$yyy = 0;
				foreach ($n_aaaa as $rating) {
					$yyy++;
					if($yyy == count($new_ratings_array)) {
						$last = ' last';
					} else {
						$last = '';
					}
					if($yyy % 2 == 0){
						$oddeven = 'even'; 
					} else{
						$oddeven = 'odd'; 
					}
					$rating_title = $rating['title'];
					$page_id = $rating['id'];
					$count_all = $rating['count_all'];
					$rating_number = $rating['number'];
					$result .= '<div class="company_in_rating_item flex'.$last.' '.$oddeven.'">';
					$result .= '<span class="c_i_r_icon">'.mb_substr($rating_title,0,1).'</span>';
					$result .= '<span class="font_smaller c_i_r_title"><a href="'.get_the_permalink($page_id).'" target="_blank" class="color_dark_blue link_no_underline">'.$rating_title.'</a></span>';
					$result .= '<div class="font_smaller_2 c_i_r_place color_dark_gray c3"><span class="color_dark_blue font_bold font_18">'.$rating_number.'</span>/'.$count_all.'</div>';
					$result .= '</div>';
				}
			}
				$result .= '</div>';
			if ($type == 'profile_widget') {
				$result .= '<div class="block_all_link block_all_link_profile"><a href="'.get_bloginfo('url').'/ratings/" class="color_dark_gray font_underline font_small link_no_underline inline_block" target="_blank">'.__('Все рейтинги','er_theme').'</a></div>';
			} else {
				$result .= '<div class="block_all_link"><a href="'.get_bloginfo('url').'/ratings/" class="font_uppercase color_blue font_smaller_2 font_bolder link_no_underline" target="_blank">'.__('Все рейтинги','er_theme').'</a></div>';
			}
			
			$result .= '</div>';
			
			/*echo '<div style="display:none;">';
			echo '<pre>';
			print_r($new_ratings_array);
			echo '</pre>';
			echo '</div>';*/
		}
		return $result;
	}
}


?>