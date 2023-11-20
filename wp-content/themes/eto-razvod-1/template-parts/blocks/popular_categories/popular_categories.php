<?php
/**
 * List Posts Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$current_language = get_locale();

// Create id attribute allowing for custom "anchor" value.
$id = 'er_block_popular_cats-' . $block['id'];
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
$className = 'block_popular_cats';
if( !empty($block['className']) ) {
	$className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
	$className .= ' align' . $block['align'];
}
$title = get_field('title');
$post_type = get_field('post_type');
if(!$post_type || $post_type == '') {
	$post_type = 'casino';
}
$style = get_field('style');
$tags = get_field('tags');

if($current_language != 'ru_RU' && $post_type == 'promocodes') {
	$tags = array(10,17,11,16);
}
$tags_on_load = get_field('show_on_load');
$pagination = get_field('pagination');
$result = '';
wp_enqueue_script( 'progressbar', get_template_directory_uri() . '/js/progressbar.js', array('jquery') );
$count_tags = count($tags);
$result .= '<div id="'.esc_attr($id).'_links" class="asfsfasaf1 flex flex_column p_t_b_block '.esc_attr($className).' '.$style.'">';
$result .= '<div class="wrap flex_column">';
if($title && $title != '') {
	$result .= '<'.$title_tag.' class="font_new_medium_2 font_bold m_b_25 color_dark_blue">'.$title.' <span class="color_violet">'.$count_tags.'</span></'.$title_tag.'>';
}
if(!empty($tags)) {
	$result .= '<ul class="popular_cats flex color_dark_blue">';
	$tag_i = 0;
	$first_active = 0;
	foreach($tags as $tag) {
		$tag_i++;
		
		if($tag_i == 1) {
			$active = ' class="active"';
			$first_active = $tag;
		} else {
			$active = '';
		}
		if($tag_i == $tags_on_load + 1) {
			$result .= '<div class="hide_more flex flex_wrap">';
		}
		$tag_human_title = get_field('tag_human_title','term_'.$tag);
		$result .= '<li'.$active.' data-term-id="'.$tag.'" data-post-type="'.$post_type.'" data-block-append="'.esc_attr($id).'_links_result"><span>'.$tag_human_title.'</span></li>';
		if($count_tags > $tags_on_load && $tag_i == $count_tags) {
			$result .= '</div>';
		}
	}
	$result .= '</ul>';
}
if($count_tags > $tags_on_load) {
	$result .= '<div class="buttons m_t_15 flex">';
	$result .= '<div class="color_dark_gray font_smaller link_dropdown pointer show_more_popular_categories show_more_popular_categories_1">'.__('Показать все','er_theme').'</div>';
	$result .= '</div>';
}
$result .= '</div>';
$result .= '</div>';
$result .= '<div class="background_light block_reviews_list '.$post_type.'" id="'.esc_attr($id).'_links_result">';

if($post_type == 'casino') {
	$result .= '<div class="wrap flex_wrap">';
	$args = array(
		'post_type' => 'casino',
		'posts_per_page' => 6,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'tax_query' => array(
			array(
				'taxonomy' => 'affiliate-tags',
				'field' => 'term_id',
				'terms' => $first_active,
			)
		),
	);

	if( $current_language == 'ru_RU' ) {
		// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
		$args['turn_off_on_ru_language'] = 1;		
	}

	$args_total = $args;

	if ($current_language == 'en_US') {
		$args['meta_query'] = array(
			'relation' => 'OR',
			array(
				'key'     => 'languages_en_us_sorting',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'languages_en_us_sorting',
				'value' => 0,
				'compare' => '=',
			),
			array(
				'key'     => 'languages_en_us_sorting',
				'value' => '',
				'compare' => '=',
			)
		);
	} elseif ($current_language == 'fr_FR') {
		$args['meta_query'] = array(
			'relation' => 'OR',
			array(
				'key'     => 'languages_fr_fr_sorting',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'languages_fr_fr_sorting',
				'value' => 0,
				'compare' => '=',
			),
			array(
				'key'     => 'languages_fr_fr_sorting',
				'value' => '',
				'compare' => '=',
			)
		);
	} elseif ($current_language == 'es_ES') {
		$args['meta_query'] = array(
			'relation' => 'OR',
			array(
				'key'     => 'languages_es_es_sorting',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'languages_es_es_sorting',
				'value' => 0,
				'compare' => '=',
			),
			array(
				'key'     => 'languages_es_es_sorting',
				'value' => '',
				'compare' => '=',
			)
		);
	} elseif ($current_language == 'de_DE') {
		$args['meta_query'] = array(
			'relation' => 'OR',
			array(
				'key'     => 'languages_de_de_sorting',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'languages_de_de_sorting',
				'value' => 0,
				'compare' => '=',
			),
			array(
				'key'     => 'languages_de_de_sorting',
				'value' => '',
				'compare' => '=',
			)
		);
	} elseif ($current_language == 'pl_PL') {
		$args['meta_query'] = array(
			'relation' => 'OR',
			array(
				'key'     => 'languages_pl_pl_sorting',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'languages_pl_pl_sorting',
				'value' => 0,
				'compare' => '=',
			),
			array(
				'key'     => 'languages_pl_pl_sorting',
				'value' => '',
				'compare' => '=',
			)
		);
	} elseif ($current_language == 'fi') {
		$args['meta_query'] = array(
			'relation' => 'OR',
			array(
				'key'     => 'languages_fi_sorting',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'languages_fi_sorting',
				'value' => 0,
				'compare' => '=',
			),
			array(
				'key'     => 'languages_fi_sorting',
				'value' => '',
				'compare' => '=',
			)
		);
	} elseif ($current_language == 'id_ID') {
		$args['meta_query'] = array(
			'relation' => 'OR',
			array(
				'key'     => 'languages_id_id_sorting',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'languages_id_id_sorting',
				'value' => 0,
				'compare' => '=',
			),
			array(
				'key'     => 'languages_id_id_sorting',
				'value' => '',
				'compare' => '=',
			)
		);
	}

	//$args_total['posts_per_page'] = -1;
	$query_total = new WP_Query($args_total);
	$query_reviews = new WP_Query($args);
	
	
	if ( $current_language == 'en_US' ) {
		
		wp_reset_postdata();
		$args_a = array(
			//'post_type'      => 'casino',
			'post_type'      => 'casino',
			'posts_per_page' => - 1,
			'post_status'    => 'publish',
			'meta_key'			=> 'languages_en_us_sorting',
			'orderby'			=> 'meta_value',
			'order'				=> 'ASC',
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
					'field' => 'term_id',
					'terms' => $first_active,
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
			$lastend = end($query_total->posts)->menu_order;
			
			foreach ( $reviews2->posts as $item ) {
				
				$i = 0;
				//$item->menu_order = get_field('languages_en_us_sort',$item->ID);
				foreach ( $query_reviews->posts as $key => $item2 ) {
					
					if ( $item2->ID == $item->ID ) {
						$i = 1;
						/*unset($query_reviews->posts[$key]);
						$query_reviews->posts[$key] = $item;*/
						$query_reviews->posts[ $key ]->menu_order = get_field( 'languages_en_us_sorting', $item->ID );
					}
				}
				
				if ($lastend > get_field( 'languages_en_us_sorting', $item->ID ) && $i == 0) {
					$item->menu_order = get_field( 'languages_en_us_sorting', $item->ID );
					$query_reviews->posts[] = $item;
				}
				
				$menu_order = [];
				foreach ( $query_reviews->posts as $key => $row ) {
					$menu_order[ $key ] = $row->menu_order;
				}
			}

			array_multisort( $menu_order, SORT_ASC, $query_reviews->posts );
		}
	} elseif ( $current_language == 'fr_FR' ) {
		wp_reset_postdata();
		$args_a = array(
			//'post_type'      => 'casino',
			'post_type'      => 'casino',
			'posts_per_page' => - 1,
			'post_status'    => 'publish',
			'meta_key'			=> 'languages_fr_fr_sorting',
			'orderby'			=> 'meta_value',
			'order'				=> 'ASC',
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
					'field' => 'term_id',
					'terms' => $first_active,
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
			$lastend = end($query_total->posts)->menu_order;
			
			foreach ( $reviews2->posts as $item ) {
				
				$i = 0;
				//$item->menu_order = get_field('languages_en_us_sort',$item->ID);
				foreach ( $query_reviews->posts as $key => $item2 ) {
					
					if ( $item2->ID == $item->ID ) {
						$i = 1;
						/*unset($query_reviews->posts[$key]);
						$query_reviews->posts[$key] = $item;*/
						$query_reviews->posts[ $key ]->menu_order = get_field( 'languages_fr_fr_sorting', $item->ID );
					}
				}
				
				if ($lastend > get_field( 'languages_fr_fr_sorting', $item->ID ) && $i == 0) {
					$item->menu_order = get_field( 'languages_fr_fr_sorting', $item->ID );
					$query_reviews->posts[] = $item;
				}
				
				$menu_order = [];
				foreach ( $query_reviews->posts as $key => $row ) {
					$menu_order[ $key ] = $row->menu_order;
				}
			}

			array_multisort( $menu_order, SORT_ASC, $query_reviews->posts );
		}
	} elseif ( $current_language == 'es_ES' ) {
		wp_reset_postdata();
		$args_a = array(
			//'post_type'      => 'casino',
			'post_type'      => 'casino',
			'posts_per_page' => - 1,
			'post_status'    => 'publish',
			'meta_key'			=> 'languages_es_es_sorting',
			'orderby'			=> 'meta_value',
			'order'				=> 'ASC',
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
					'field' => 'term_id',
					'terms' => $first_active,
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
			$lastend = end($query_total->posts)->menu_order;
			
			foreach ( $reviews2->posts as $item ) {
				
				$i = 0;
				//$item->menu_order = get_field('languages_en_us_sort',$item->ID);
				foreach ( $query_reviews->posts as $key => $item2 ) {
					
					if ( $item2->ID == $item->ID ) {
						$i = 1;
						/*unset($query_reviews->posts[$key]);
						$query_reviews->posts[$key] = $item;*/
						$query_reviews->posts[ $key ]->menu_order = get_field( 'languages_es_es_sorting', $item->ID );
					}
				}
				
				if ($lastend > get_field( 'languages_es_es_sorting', $item->ID ) && $i == 0) {
					$item->menu_order = get_field( 'languages_es_es_sorting', $item->ID );
					$query_reviews->posts[] = $item;
				}
				
				$menu_order = [];
				foreach ( $query_reviews->posts as $key => $row ) {
					$menu_order[ $key ] = $row->menu_order;
				}
			}

			array_multisort( $menu_order, SORT_ASC, $query_reviews->posts );
		}
	} elseif ( $current_language == 'de_DE' ) {
		wp_reset_postdata();
		$args_a = array(
			//'post_type'      => 'casino',
			'post_type'      => 'casino',
			'posts_per_page' => - 1,
			'post_status'    => 'publish',
			'meta_key'			=> 'languages_de_de_sorting',
			'orderby'			=> 'meta_value',
			'order'				=> 'ASC',
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
					'field' => 'term_id',
					'terms' => $first_active,
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
			$lastend = end($query_total->posts)->menu_order;
			
			foreach ( $reviews2->posts as $item ) {
				
				$i = 0;
				//$item->menu_order = get_field('languages_en_us_sort',$item->ID);
				foreach ( $query_reviews->posts as $key => $item2 ) {
					
					if ( $item2->ID == $item->ID ) {
						$i = 1;
						/*unset($query_reviews->posts[$key]);
						$query_reviews->posts[$key] = $item;*/
						$query_reviews->posts[ $key ]->menu_order = get_field( 'languages_de_de_sorting', $item->ID );
					}
				}
				
				if ($lastend > get_field( 'languages_de_de_sorting', $item->ID ) && $i == 0) {
					$item->menu_order = get_field( 'languages_de_de_sorting', $item->ID );
					$query_reviews->posts[] = $item;
				}
				
				$menu_order = [];
				foreach ( $query_reviews->posts as $key => $row ) {
					$menu_order[ $key ] = $row->menu_order;
				}
			}

			array_multisort( $menu_order, SORT_ASC, $query_reviews->posts );
		}
		
	} elseif ( $current_language == 'pl_PL' ) {
		wp_reset_postdata();
		$args_a = array(
			//'post_type'      => 'casino',
			'post_type'      => 'casino',
			'posts_per_page' => - 1,
			'post_status'    => 'publish',
			'meta_key'			=> 'languages_pl_pl_sorting',
			'orderby'			=> 'meta_value',
			'order'				=> 'ASC',
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
					'field' => 'term_id',
					'terms' => $first_active,
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
			$lastend = end($query_total->posts)->menu_order;
			
			foreach ( $reviews2->posts as $item ) {
				
				$i = 0;
				//$item->menu_order = get_field('languages_en_us_sort',$item->ID);
				foreach ( $query_reviews->posts as $key => $item2 ) {
					
					if ( $item2->ID == $item->ID ) {
						$i = 1;
						/*unset($query_reviews->posts[$key]);
						$query_reviews->posts[$key] = $item;*/
						$query_reviews->posts[ $key ]->menu_order = get_field( 'languages_pl_pl_sorting', $item->ID );
					}
				}
				
				if ($lastend > get_field( 'languages_pl_pl_sorting', $item->ID ) && $i == 0) {
					$item->menu_order = get_field( 'languages_pl_pl_sorting', $item->ID );
					$query_reviews->posts[] = $item;
				}
				
				$menu_order = [];
				foreach ( $query_reviews->posts as $key => $row ) {
					$menu_order[ $key ] = $row->menu_order;
				}
			}
			
			array_multisort( $menu_order, SORT_ASC, $query_reviews->posts );
		}
		
	} elseif ( $current_language == 'fi' ) {
		wp_reset_postdata();
		$args_a = array(
			//'post_type'      => 'casino',
			'post_type'      => 'casino',
			'posts_per_page' => - 1,
			'post_status'    => 'publish',
			'meta_key'			=> 'languages_fi_sorting',
			'orderby'			=> 'meta_value',
			'order'				=> 'ASC',
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
					'field' => 'term_id',
					'terms' => $first_active,
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
			$lastend = end($query_total->posts)->menu_order;
			
			foreach ( $reviews2->posts as $item ) {
				
				$i = 0;
				//$item->menu_order = get_field('languages_en_us_sort',$item->ID);
				foreach ( $query_reviews->posts as $key => $item2 ) {
					
					if ( $item2->ID == $item->ID ) {
						$i = 1;
						/*unset($query_reviews->posts[$key]);
						$query_reviews->posts[$key] = $item;*/
						$query_reviews->posts[ $key ]->menu_order = get_field( 'languages_fi_sorting', $item->ID );
					}
				}
				
				if ($lastend > get_field( 'languages_fi_sorting', $item->ID ) && $i == 0) {
					$item->menu_order = get_field( 'languages_fi_sorting', $item->ID );
					$query_reviews->posts[] = $item;
				}
				
				$menu_order = [];
				foreach ( $query_reviews->posts as $key => $row ) {
					$menu_order[ $key ] = $row->menu_order;
				}
			}
			
			array_multisort( $menu_order, SORT_ASC, $query_reviews->posts );
		}

	} elseif ( $current_language == 'id_ID' ) {
		wp_reset_postdata();
		$args_a = array(
			//'post_type'      => 'casino',
			'post_type'      => 'casino',
			'posts_per_page' => - 1,
			'post_status'    => 'publish',
			'meta_key'			=> 'languages_id_id_sorting',
			'orderby'			=> 'meta_value',
			'order'				=> 'ASC',
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
					'field' => 'term_id',
					'terms' => $first_active,
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
			$lastend = end($query_total->posts)->menu_order;
			
			foreach ( $reviews2->posts as $item ) {
				
				$i = 0;
				//$item->menu_order = get_field('languages_en_us_sort',$item->ID);
				foreach ( $query_reviews->posts as $key => $item2 ) {
					
					if ( $item2->ID == $item->ID ) {
						$i = 1;
						/*unset($query_reviews->posts[$key]);
						$query_reviews->posts[$key] = $item;*/
						$query_reviews->posts[ $key ]->menu_order = get_field( 'languages_id_id_sorting', $item->ID );
					}
				}
				
				if ($lastend > get_field( 'languages_id_id_sorting', $item->ID ) && $i == 0) {
					$item->menu_order = get_field( 'languages_id_id_sorting', $item->ID );
					$query_reviews->posts[] = $item;
				}
				
				$menu_order = [];
				foreach ( $query_reviews->posts as $key => $row ) {
					$menu_order[ $key ] = $row->menu_order;
				}
			}
			
			array_multisort( $menu_order, SORT_ASC, $query_reviews->posts );
		}
		
	}

	$total = count($query_total->posts);
	$current = count($query_reviews->posts);
	if ( $query_reviews->have_posts() ) {
		$result .= '<ul class="flex ul_content">';
		while ( $query_reviews->have_posts() ) {
			$query_reviews->the_post();
			global $post;
			if(function_exists('get_rating_fields_group')) {
				$rating_fields_group = get_rating_fields_group($post->ID);
			} else {
				$rating_fields_group = 0;
			}
			$comments_count = get_comments_count( $post->ID, get_comment_rating_fields( $rating_fields_group, 'name' ) );
			$result .= '<li class="white_block flex flex_column" itemscope="" itemtype="http://schema.org/Organization">';
			$company_name = get_field('company_name',$post->ID);
			$result .= '<div class="company_block_header flex">';
			$result .= '<div class="compare_container" id="p_c_compare_container_'.$post->ID.'" data-post-id="'.$post->ID.'">'.compare_icon($post->ID).'</div>';
			if (function_exists('review_logo')) {
				$result .= review_logo($post->ID,false,false,true);
			}
			$terms = get_the_terms($post->ID,'affiliate-tags');
			$result .= '<div class="flex flex_column">';
			$result .= '<meta itemprop="name" content="' . $company_name . '">';
			$result .= '<a itemprop="url" class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="'.get_the_permalink($post->ID).'">'.$company_name.'</a>';
			$result .= '<div class="font_small"><span class="color_dark_gray count_reviews">'.__('Отзывы','er_theme').'</span><span class="color_dark_blue">'.$comments_count['count'].'</span></div>';
			if(!empty($terms)) {
				$t_x = 0;
				$result .= '<ul class="company_card_tags flex">';
				foreach ($terms as $term) {
					$t_x++;
					if($t_x <= 1) {
						if(get_field('tag_human_title', 'term_' . $term->term_id) != '') {
							$result .= '<li class="color_dark_blue">' . get_field('tag_human_title', 'term_' . $term->term_id) . '</li>';
						}
					}
				}
				$result .= '</ul>';
			}
			$result .='</div>';
			$result .='</div>';
			$result .='<div class="company_block_footer flex" itemscope="" itemprop="aggregateRating" itemtype="https://schema.org/AggregateRating">';
			$result .= get_post_stars( $rating_fields_group, $post->ID, $comments_count['count'] );
			$result .= review_top_rating( $post->ID );
			$result .='</div>';
			$result .= '</li>';
			
		}
		$result .= '</ul>';
	}
	wp_reset_postdata();
	if($current < $total) {
		$more_classes = 'button pointer button_violet radius_small button_padding_big font_small font_bold button_centered line_show_more flex';
		$result .= '<div class="'.$more_classes.' inactive" data-offset="'.$current.'" data-block-id="'.esc_attr($id).'_links_result" data-container="ul.ul_content" data-per-page="'.$args['posts_per_page'].'" data-total="'.$total.'" data-post-type="casino" data-tag="'.$first_active.'">'.__('Показать еще','sa_theme').'</div>';
	}
	$result .= '</div>';
	
	/*foreach($tags as $tag) {
		if($first_active == $tag) {
			continue;
		}
		$result .= '<div class="home_popular_categories_more">';
		$args = array(
			'post_type' => 'casino',
			'posts_per_page' => 6,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'tax_query' => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field' => 'term_id',
					'terms' => $tag,
				)
			),
		);

		if( $current_language == 'ru_RU' ) {
			// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
			$args['turn_off_on_ru_language'] = 1;		
		}

		$args_total = $args;
		$query_reviews = new WP_Query($args);
		$current = count($query_reviews->posts);
		if ( $query_reviews->have_posts() ) {
			$result .= '<ul class="flex">';
			while ( $query_reviews->have_posts() ) {
				$query_reviews->the_post();
				global $post;
				if(function_exists('get_rating_fields_group')) {
					$rating_fields_group = get_rating_fields_group($post->ID);
				} else {
					$rating_fields_group = 0;
				}
				$comments_count = get_comments_count( $post->ID, get_comment_rating_fields( $rating_fields_group, 'name' ) );
				$result .= '<li class="white_block flex flex_column" itemscope="" itemtype="http://schema.org/Organization">';
				$company_name = get_field('company_name',$post->ID);
				$result .='<div class="company_block_header flex">';
				$result .= '<div class="compare_container" id="p_c_compare_container_'.$post->ID.'" data-post-id="'.$post->ID.'">'.compare_icon($post->ID).'</div>';
				if (function_exists('review_logo')) {
					$result .= review_logo($post->ID,false,false,true);
				}
				$terms = get_the_terms($post->ID,'affiliate-tags');
				$result .= '<div class="flex flex_column">';
				$result .= '<meta itemprop="name" content="' . $company_name . '">';
				$result .= '<a itemprop="url" class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="'.get_the_permalink($post->ID).'">'.$company_name.'</a>';
				$result .= '<div class="font_small"><span class="color_dark_gray count_reviews">'.__('Отзывы','er_theme').'</span><span class="color_dark_blue">'.$comments_count['count'].'</span></div>';
				if(!empty($terms)) {
					$t_x = 0;
					$result .= '<ul class="company_card_tags flex">';
					foreach ($terms as $term) {
						$t_x++;
						if($t_x <= 1) {
							if(get_field('tag_human_title', 'term_' . $term->term_id) != '') {
								$result .= '<li class="color_dark_blue">' . get_field('tag_human_title', 'term_' . $term->term_id) . '</li>';
							}
						}
					}
					$result .= '</ul>';
				}
				$result .='</div>';
				$result .='</div>';
				$result .= '</li>';
				
			}
			$result .= '</ul>';
		}
		wp_reset_postdata();
		
		$result .= '</div>';
		
	}*/
	
	
	
} elseif($post_type == 'promocodes') {
	$result .= '<div class="wrap flex_wrap">';
	$promocodes_current_count = 0;
	$args = array(
		'post_type' => $post_type,
		'posts_per_page' => 9,
		'tax_query' => array(
			array(
				'taxonomy' => 'affiliate-tags',
				'field' => 'term_id',
				'terms' => $first_active,
			)
		),
		'meta_query' => array(
			array(
				'key' => 'promocodes_items',
				'value' => 0,
				'compare' => '>'
			)
		),
	);

	if( $current_language == 'ru_RU' ) {
		// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
		$args['turn_off_on_ru_language'] = 1;		
	}

	$query_reviews = new WP_Query($args);
	//  print_r($query_reviews);
	if ( $query_reviews->have_posts() ) {
		$result .= '<ul class="flex popular_cat_ul home_slide">';
		$promocodes_array = array();
		$yyy = 0;
		$iter = 0;
		while ( $query_reviews->have_posts() ) {
			$query_reviews->the_post();
			global $post;
			$items = get_field('promocodes_items',$post->ID);
			$review_id = get_field('promocode_review',$post->ID);
			$company_name = get_field('company_name',$review_id);
			if($current_language != 'ru_RU') {
				$cyr = ['Љ', 'Њ', 'Џ', 'џ', 'ш', 'ђ', 'ч', 'ћ', 'ж', 'љ', 'њ', 'Ш', 'Ђ', 'Ч', 'Ћ', 'Ж','Ц','ц', 'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п', 'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я', 'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П', 'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
				];
				$lat = ['Lj', 'Nj', 'Dž', 'dž', 'sh', 'đ', 'ch', 'ć', 'zh', 'lj', 'nj', 'Sh', 'Đ', 'Ch', 'Ć', 'Zh','C','c', 'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p', 'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya', 'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P', 'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
				];
				$company_name = str_replace($cyr, $lat, $company_name);
			}
			$xxx = 0;
			
//			if($yyy < 10) {
				//echo ' / '.$yyy;
				foreach($items as $item) {
					$hour = 12;
					$today = strtotime($hour . ':00:00');
					$yesterday = strtotime('-1 day', $today);

					$date_end_m = strtotime($item['date_end']);
					if(($date_end_m < $yesterday && !empty($item['date_end']) && $item['date_end'] != 'None') || ($item['hide_promos'] == 'yes')) {

					} else {
						$xxx++;
						$yyy++;
						$promocode_single_array = array(
							'count' => $item['visits'],
							'item' => $item,
							'post' => $post,
							'yyy' => $yyy,
							'xxx' => $xxx,
							'review_id' => $review_id,
							'company_name' => $company_name
						);
						$promocodes_array[] = $promocode_single_array;
						$iter = ++$iter;

					}
				}
//			}
		}
		array_multisort(array_map(function($element) {
			return $element['count'];
		}, $promocodes_array), SORT_DESC, $promocodes_array);
		foreach($promocodes_array as $promocode_single) {
			$promocodes_current_count++;
			if($promocodes_current_count > 15) {
				break;
			}
			$item = $promocode_single['item'];
			$post = $promocode_single['post'];
			$xxx = $promocode_single['xxx'];
			$yyy = $promocode_single['yyy'];
			$review_id = $promocode_single['review_id'];
			$company_name = $promocode_single['company_name'];
			$result .= '<li class="white_block flex flex_column" id="popular_promocodes_'.$post->ID.'_'.$yyy.'">';
			if($item['discount_size'] != '' & $item['discount_currency'] == '%') {
				$size = $item['discount_size'].$item['discount_currency'];
			} elseif($item['discount_size'] != '' & $item['discount_currency'] != '%') {
				$size = $item['discount_size'].' '.$item['discount_currency'];
			} else {
				$size = '';
			}
			if ($item['type'] == 'discount') {
				$item_type = __('Скидка на заказ','er_theme');
			} elseif($item['type'] == 'reg') {
				$item_type = __('Бонус при регистрации','er_theme');
			} elseif($item['type'] == 'demo') {
				$item_type = __('Бесплатный демо-счет','er_theme');
			} elseif($item['type'] == 'gift') {
				$item_type = __('Подарок','er_theme');
			} elseif($item['type'] == 'delivery') {
				$item_type = __('Бесплатная доставка','er_theme');
			}
			$current_date = time();
			$diff =  strtotime($item['date_end'].' 23:59') - $current_date;
			$diff_human = date('Y-m-d H:i:s',$diff);
			$rest_human = date_parse($diff_human);

			$date1 = new DateTime($item['date_end']);
			$date2 = new DateTime(date('Y-m-d',$current_date));
			$interval = $date1->diff($date2);
			$diff_date = $interval->days;
			if (  !$item['date_end'] || $item['date_end']== '' ) {
				$result .= '<div class="promocode_block_alert promocode_block_alert_2"><span class="promocode_alert_simple_text">'.__('Бессрочный','er_theme').'</span></div>';
			}
			elseif($rest_human['year'] < 1970 || $diff_date <= 0) {
				$result .= '<div class="promocode_block_alert promocode_block_alert_2"><span class="promocode_alert_simple_text">'.__('Истекает сегодня','er_theme').'</span></div>';
			} else {
				$result .= '<div class="promocode_block_alert  promocode_block_alert_3">';
				$result .= '<span class="promocode_alert_simple_text">'.__('Истекает через','er_theme').'';
				//$result .= ' '.$diff_human_new.' '.counted_text($diff_human_new,__('день','er_theme'),__('дня','er_theme'),__('дней','er_theme'));
				$result .= ' '.$diff_date.' '.counted_text($diff_date,__('день','er_theme'),__('дня','er_theme'),__('дней','er_theme'));
				//$result .= ' '.$rest_human['hour'].' '.counted_text($rest_human['hour'],__('час','er_theme'),__('часа','er_theme'),__('часов','er_theme'));
				//$result .= ' '.$rest_human['minute'].' '.counted_text($rest_human['minute'],__('минута','er_theme'),__('минуты','er_theme'),__('минут','er_theme'));
				$result .= '</span>';
				$result .= $item['date_end'];
				$result .= '</div>';

			}
			$result .='<div class="promocode_block_content flex flex_column">';

			if($size != '') {
				$result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size">' . $size . '</div>';
			} else {
				$result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size_text">' . $item_type . '</div>';
			}
			$terms = get_term(get_field('promocode_taxonomy',$post->ID),'affiliate-tags')->slug;
			$terms_id = get_term(get_field('promocode_taxonomy',$post->ID),'affiliate-tags')->term_id;
			$tasks = get_posts(array(
				'post_type' => 'promocodes_cats',
				'meta_query' => array(
					array(
						'key' => 'affiliate_tag', // name of custom field
						'value' => $terms_id, // matches exaclty "123", not just 123. This prevents a match for "1234"
						'compare' => '='
					)
				)
			));
			$result .= '<a class="promocode_item_title color_dark_blue link_no_underline font_bold do_not_translate_css_class" href="'.get_the_permalink($tasks[0]->ID).$post->post_name.'/" target="_blank">'.$company_name.'</a>';
			if($item['title'] != '') {
				$result .= '<div class="color_dark_gray font_small m_t_15">' . $item['title'] . '</div>';
			}
			$result .= '<div class="promocode_button_container">';
			if($item['text'] != '' && $item['text'] != 'Не нужен') {
				$result .= '<div class="promocode_text_container">';
				$result .= '<div class="promocode_single_text" id="promocode_text_'.$post->ID.'_'.$xxx.'">'.$item['text'].'</div>';
				$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$xxx.'/" target="_blank" rel="nofollow">'.__('Получить','er_theme').'</a>';
				$result .= '<div class="link_promocode_text_copy button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Скопировать','er_theme').'</div>';
				$result .= '</div>';
				$result .= '<div class="link_promocode_show_more_text button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Показать код','er_theme').'</div>';
			} else {
				$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$xxx.'/" target="_blank" rel="nofollow">'.__('Получить','er_theme').'</a>';
			}
			$result .='</div>';
			$result .='</div>';
			if($item['description'] != '') {
				$result .= '<div class="promocode_full_description color_dark_gray font_small">'.$item['description'].'</div>';
			}
			$result .='<div class="promocode_block_footer flex">';
			if($item['description'] != '') {
				$result .= '<span class="font_smaller color_dark_gray inactive dropdown pointer flex link_promocode_show_more">'.__('Подробнее','er_theme').'</span>';
			}
			$count_used = 1;
			if($item['visits'] && $item['visits'] != '' && $item['visits'] != 0) {
				$count_used = $item['visits'];
			}
			$result .= '<span class="m_l_auto font_bold font_smaller color_dark_blue">'.$count_used.' '.counted_text($count_used,__('использует','er_theme'),__('используют','er_theme'),__('используют','er_theme')).'</span>';
			$result .='</div>';
			$result .= '</li>';
		}
		$result .= '</ul>';
		$result .= '<span class="tabs_mobile_mover tabs_mobile_mover_popular_cat_ul">';
		for ($i = 1;$i <= $iter;$i++) {
			if ($i == 1) {
				$result .= '<span class="tabs_mobile_mover__item tabs_mobile_mover__item_active" data-n="'.$i.'"></span>';
			} else {
				$result .= '<span class="tabs_mobile_mover__item" data-n="'.$i.'"></span>';
			}
		}
		$result .= '</span>';
	}
	wp_reset_postdata();
	$result .= '</div>';
}

$result .= '</div>';
echo $result;

?>