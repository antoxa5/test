<?php




if (!function_exists('ajax_similar_companies')) {
	add_action( 'wp_ajax_ajax_similar_companies', 'ajax_similar_companies' );
	add_action( 'wp_ajax_nopriv_ajax_similar_companies', 'ajax_similar_companies' );
	function ajax_similar_companies() {
		$data = $_POST;
		$result = '';
		$post_id = $data['post_id'];
		$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
		$args = array(
				'post_type' => 'casino',
				'posts_per_page' => 6,
				'post_status' => 'publish',
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'post__not_in' => array($post_id),
				'tax_query' => array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'name',
						'terms'    => $term_slug,
					),
				),
			);
		$reviews = new WP_Query( $args );
		if ( $reviews->have_posts() ) {
				$result .= '<ul class="flex ul_content flex_column">';
				while ( $reviews->have_posts() ) {
					$reviews->the_post();
					global $post;
					if(function_exists('get_rating_fields_group')) {
						$rating_fields_group = get_rating_fields_group($post->ID);
					} else {
						$rating_fields_group = 0;
					}
					$comments_count = get_comments_count( $post->ID, get_comment_rating_fields( $rating_fields_group, 'name' ) );
					$result .= '<li class="white_block flex">';
					
					if (function_exists('review_logo')) {
						$result .= review_logo($post->ID);
					}
					
					$result .= '<div class="review_main">';
					$company_title = get_field('company_name',$post->ID);
					if($company_title && $company_title != '') {
						$result .= '<div class="review_company_title font_bold font_new_medium color_dark_blue"><a href="'.get_the_permalink($post->ID).'" target="_blank" class="color_dark_blue link_no_underline">'.$company_title.'</a></div>';
					}
					$terms = get_the_terms($post->ID,'affiliate-tags');
					
					if(!empty($terms)) {
						$t_x = 0;
						$result .= '<ul class="company_card_tags flex" data-id="3">';
						foreach ($terms as $term) {
							$t_x++;
							if($t_x <= 3) {
								if(get_field('tag_human_title', 'term_' . $term->term_id) && get_field('tag_human_title', 'term_' . $term->term_id) != '') {
									$result .= '<li class="color_dark_blue">' . get_field('tag_human_title', 'term_' . $term->term_id) . '</li>';
								}
							}
						}
						$result .= '</ul>';
					}
					if(function_exists('get_rating_fields_group')) {
						$rating_fields_group = get_rating_fields_group($post->ID);
					} else {
						$rating_fields_group = 0;
					}
						$result .= '<div class="stars_and_reviews flex">';
							$result .=  get_post_stars($rating_fields_group);
							$result .= '<div class="stars_and_reviews_counts flex flex_column m_l_15 font_small line_big">';
								$reviews_count = get_field('reviews_count_reviews',$post->ID);
								if(!$reviews_count || $reviews_count == '') {
									$reviews_count = 0;
								}
								if($reviews_count) {
									$result .= '<a href="'.get_the_permalink($post->ID).'#comments" class="reviews_count_reviews" style="text-decoration: none;"><span class="color_dark_gray">'.__('Всего отзывов','er_theme').'</span> <span class="color_dark_blue link_dashed">'.$reviews_count.'</span></a>';
								} else {
									$result .= '<a href="'.get_the_permalink($post->ID).'#comments" class="reviews_count_reviews"><span class="color_dark_gray" style="text-decoration: none;">'.__('Еще нет отзывов','er_theme').'</span></div>';
								}
								$abuses_count = get_field('reviews_count_abuses',$post->ID);
								if(!$abuses_count || $abuses_count == '') {
									$abuses_count = 0;
								}
								if($abuses_count) {
									$result .= '<a href="'.get_the_permalink($post->ID).'#abuse" class="reviews_count_reviews_2" style="text-decoration: none;"><span class="color_dark_blue link_dashed">'.$abuses_count.' '.counted_text($abuses_count,__('жалоба','er_theme'),__('жалобы','er_theme'),__('жалоб','er_theme')).'</span></a>';
								} else {
									$result .= '<a href="'.get_the_permalink($post->ID).'#abuse" class="reviews_count_abuses_2" style="text-decoration: none;"><span class="color_dark_blue link_dashed">'.__('Еще нет жалоб','er_theme').'</span></a>';
								}	
							$result .= '</div>';
						$result .= '</div>';
					$result .= '</div>';
					$result .= '<div class="review_top_rating_container flex flex_column">';
					if(function_exists('review_top_rating')) {
						$result .= review_top_rating($post->ID);
					}
					$result .= '<div class="compare_container" id="p_c_compare_container_'.$post->ID.'" data-post-id="'.$post->ID.'">'.compare_icon($post->ID).'</div>';
					$result .= '</div>';
					
					
					
					
					
					$result .= '</li>';

				}
				$result .= '</ul>';
			}
			wp_reset_postdata();
		
		
		
		
		echo $result;
		die;
	}
}