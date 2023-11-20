<?php
/**
 * List Posts Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'er_block_popular_ratings-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}
if(get_field('title_tag')) {
    $title_tag = get_field('title_tag');
} else {
    $title_tag = 'div';
}
if(get_field('description_tag')) {
    $description_tag = get_field('description_tag');
} else {
    $description_tag = 'div';
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'block_popular_ratings';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$title = get_field('title');
$ratings = get_field('ratings_ids');
$current_language = get_locale();
if($current_language != 'ru_RU') {
    $ratings = array(6021,9362,7209,697,5692);
}
$post_type = get_field('post_type');
if(!$post_type || $post_type == '') {
    $post_type = 'casino';
}
$style = get_field('style');
$tags = get_field('tags');
$tags_on_load = get_field('show_on_load');
$pagination = get_field('pagination');
$result = '';
wp_enqueue_script( 'progressbar', get_template_directory_uri() . '/js/progressbar.js', array('jquery') );



if(!empty($ratings)) {
	$pages = $ratings;
} else {
	$args = array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'template-rating.php'
        );
	$pages = get_pages($args);
}

$args_2 = array(
			'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => 'template-rating.php'
        );
$count_query = new WP_Query($args_2);
//print_r($count_query);
$cout_ratings = $count_query->found_posts;
//print_r($args);

$count_tags = count($pages);
if(!empty($pages)) {
$result .= '<div id="'.esc_attr($id).'" class="asfasfasf2 flex flex_column p_t_b_block '.esc_attr($className).' '.$style.'">';
	$result .= '<div class="wrap">';
		$result .= '<div class="popular_ratings_left flex flex_column">';
		if($title && $title != '') {
			$result .= '<a class="font_new_medium_2 font_bold m_b_50 color_dark_blue title_h2" href="'.get_bloginfo('url').'/ratings/">'.$title.'</a>';
		}
		$result .= '<ul class="flex flex_column popular_ratings_list color_dark_blue">';
		$y = 0;
		foreach($pages as $page){ 
			$y++;
			if(!empty($ratings)) {
				$page_id = $page;
			} else {
				$page_id = $page->ID;
			}
			if($y == 1) {
				$first = ' class="active"';
			} else {
				$first = ' class="inactive"';
			}
			if(get_field('rating_list_title',$page_id)) {
				$rating_title = get_field('rating_list_title',$page_id);
			} else {
				$rating_title = get_the_title($page_id);	
			}
			if($count_tags > $tags_on_load && $y == $tags_on_load + 1) {
					$result .= '<div class="hide_more flex flex_wrap">';
				}
			$result .= '<li data-rating-id="'.$page_id.'"'.$first.'><span>'.$rating_title.'</span></li>';
			if($count_tags > $tags_on_load && $y == $count_tags) {
					$result .= '</div>';
				}
		}
		$result .= '</ul>';
		if($count_tags > $tags_on_load) {
		$result .= '<div class="buttons m_t_15 flex">';
			$result .= '<a class="color_dark_gray font_smaller link_no_underline pointer" href="'.get_bloginfo('url').'/ratings/">'.__('Показать все рейтинги','er_theme').'</a>';
		$result .= '</div>';
		}
		$result .= '</div>';
		$result .= '<div class="popular_ratings_right flex flex_column">';

		$result .= '</div>';
		$result .= '<div class="home_popular_ratings_more">';
			$i = 0;
			
            if ($i == 4) {
				foreach($pages as $page){
					$page_id = $page;
					$data = array();
					$data['rating_id'] = $page_id;
					if ( get_field( 'rating_list_title', $data['rating_id'] ) ) {
						$title = get_field( 'rating_list_title', $data['rating_id'] );
					} else {
						$title = get_the_title( $data['rating_id'] );
					}
					if ( get_field( 'rating_list_description', $data['rating_id'] ) ) {
						$description = get_field( 'rating_list_description', $data['rating_id'] );
					} else {
						$description = get_the_title( $data['rating_id'] );
					}
					$result        .= '<a href="'.get_the_permalink($page_id).'">' . $title . '</a>';
					$result        .= '<div>' . $description . '</div>';
					$result .= '<div>'.__('Обзоры, отзывы, жалобы, акции','er_theme').'</div>';
					$tag_term      = get_term( get_field( 'rating_tag', $data['rating_id'] ), 'affiliate-tags' );
					$tag           = $tag_term->slug;
					$args          = array(
						'post_type'      => 'casino',
						'posts_per_page' => 6,
						'orderby'        => 'menu_order',
						'post_status' => 'publish',
						'order'          => 'ASC',
						'tax_query'      => array(
							array(
								'taxonomy' => 'affiliate-tags',
								'field'    => 'name',
								'terms'    => $tag,
							),
						),
					);
					if ( $current_language != 'ru_RU' ) {
						$args['meta_query'] = array(
							'relation' => 'OR',
							array(
								'key'     => 'languages_'.strtolower($current_language).'_sorting',
								'compare' => 'NOT EXISTS',
							),
							array(
								'key'     => 'languages_'.strtolower($current_language).'_sorting',
								'value' => 0,
								'compare' => '=',
							),
							array(
								'key'     => 'languages_'.strtolower($current_language).'_sorting',
								'value' => '',
								'compare' => '=',
							)
						);
					}
		
					$reviews       = new WP_Query( $args );
		
		
					if ( $current_language != 'ru_RU' ) {
			
						wp_reset_postdata();
						$args_a = array(
							//'post_type'      => 'casino',
							'post_type'      => 'casino',
							'posts_per_page' => - 1,
							'post_status'    => 'publish',
							'meta_key'			=> 'languages_'.strtolower($current_language).'_sorting',
							'orderby'			=> 'meta_value',
							'order'				=> 'ASC',
							'meta_query'     => array(
								'relation' => 'AND',
								array(
									'key'     => 'languages_'.strtolower($current_language).'_sorting',
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
						//echo $tag.'<br>'.count( $reviews2->posts );
						if ( count( $reviews2->posts ) > 0 ) {
							$lastend = end($reviews->posts)->menu_order;
				
							foreach ( $reviews2->posts as $item ) {
					
								$i = 0;
								//$item->menu_order = get_field('languages_'.strtolower($current_language).'_sort',$item->ID);
								foreach ( $reviews->posts as $key => $item2 ) {
						
									if ( $item2->ID == $item->ID ) {
										$i = 1;
										/*unset($query_reviews->posts[$key]);
										$query_reviews->posts[$key] = $item;*/
										$reviews->posts[ $key ]->menu_order = get_field( 'languages_'.strtolower($current_language).'_sorting', $item->ID );
									}
								}
					
								if ($lastend > get_field( 'languages_'.strtolower($current_language).'_sorting', $item->ID ) && $i == 0) {
									$item->menu_order = get_field( 'languages_'.strtolower($current_language).'_sorting', $item->ID );
									$reviews->posts[] = $item;
								}
					
								$menu_order = [];
								foreach ( $reviews->posts as $key => $row ) {
									$menu_order[ $key ] = $row->menu_order;
								}
							}
				
				
				
				
							array_multisort( $menu_order, SORT_ASC, $reviews->posts );
						}
					}
					$count_reviews = count( $reviews->posts );
					if ( $reviews->have_posts() ) {
						$result .= '<ul class="flex ul_content load_popular_rating asfasf">';
						while ( $reviews->have_posts() ) {
							$reviews->the_post();
							global $post;
							if ( function_exists( 'get_rating_fields_group' ) ) {
								$rating_fields_group = get_rating_fields_group( $post->ID );
							} else {
								$rating_fields_group = 0;
							}
							$comments_count = get_comments_count( $post->ID, get_comment_rating_fields( $rating_fields_group, 'name' ) );
							$result         .= '<li class="white_block flex flex_column  asfasfasf">';
				
							$company_name = get_field( 'company_name', $post->ID );
							$result       .= '<div class="company_block_header flex">';
							$result       .= '<div class="compare_container" id="p_c_compare_container_' . $post->ID . '" data-post-id="' . $post->ID . '">' . compare_icon( $post->ID ) . '</div>';
							if ( function_exists( 'review_logo' ) ) {
								$result .= review_logo( $post->ID,false,false,true );
							}
							$terms  = get_the_terms( $post->ID, 'affiliate-tags' );
							$result .= '<div class="flex flex_column">';
							$result .= '<a class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="' . get_the_permalink( $post->ID ) . '">' . $company_name . '</a>';
							$result .= '<div class="font_small"><span class="color_dark_gray count_reviews">' . __( 'Отзывы', 'er_theme' ) . '</span><span class="color_dark_blue">' . $comments_count['count'] . '</span></div>';
							if ( ! empty( $terms ) ) {
								$t_x    = 0;
								$result .= '<ul class="company_card_tags flex">';
								foreach ( $terms as $term ) {
									$t_x ++;
									if ( $t_x <= 3 ) {
										if ( get_field( 'tag_human_title', 'term_' . $term->term_id ) != '' ) {
											$result .= '<li class="color_dark_blue">' . get_field( 'tag_human_title', 'term_' . $term->term_id ) . '</li>';
										}
									}
								}
								$result .= '</ul>';
							}
							$result .= '</div>';
							$result .= '</div>';
							$result .= '<div class="company_block_footer flex">';
							$result .= get_post_stars( $rating_fields_group );
							$result .= review_top_rating( $post->ID );
							$result .= '</div>';
							$result .= '</li>';
				
						}
						$result .= '</ul>';
						$result .= '<span class="tabs_mobile_mover tabs_rates">';
						for ( $i = 1; $i <= $count_reviews; $i ++ ) {
							if ( $i == 1 ) {
								$result .= '<span class="tabs_mobile_mover__item tabs_mobile_mover__item_active" data-n="' . $i . '"></span>';
							} else {
								$result .= '<span class="tabs_mobile_mover__item" data-n="' . $i . '"></span>';
							}
						}
						$result .= '</span>';
					}
					wp_reset_postdata();
					//$result .= $page;
				}
			}
        $result .= '</div>';
	$result .= '</div>';
$result .= '</div>';
echo $result;
}

?>