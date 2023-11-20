<?php


if ( ! function_exists( 'load_popular_rating' ) ) {
	add_action( 'wp_ajax_load_popular_rating', 'load_popular_rating' );
	add_action( 'wp_ajax_nopriv_load_popular_rating', 'load_popular_rating' );
	function load_popular_rating() {
		$data = $_POST;
		//echo $data['rating_id'];
		$result = '';
		$result .= '<div class="flex flex_column">';
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
		$result        .= '<div class="font_new_medium_2 font_bold m_b_20 color_dark_blue m_t_20">' . $title . '</div>';
		$result        .= '<div class="color_darker_gray m_b_35">' . __('Обзоры, отзывы, жалобы, акции','er_theme') . '</div>';
		$tag_term      = get_term( get_field( 'rating_tag', $data['rating_id'] ), 'affiliate-tags' );
		$tag           = $tag_term->slug;
		$args          = array(
			'post_type'      => 'casino',
			'posts_per_page' => 24,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => $tag,
				),
			),
		);
		$reviews       = new WP_Query( $args );
		$count_reviews = count( $reviews->posts );
		if ( $reviews->have_posts() ) {
			$result .= '<ul class="flex ul_content load_popular_rating">';
			while ( $reviews->have_posts() ) {
				$reviews->the_post();
				global $post;
				if ( function_exists( 'get_rating_fields_group' ) ) {
					$rating_fields_group = get_rating_fields_group( $post->ID );
				} else {
					$rating_fields_group = 0;
				}
				$comments_count = get_comments_count( $post->ID, get_comment_rating_fields( $rating_fields_group, 'name' ) );
				$result         .= '<li class="white_block flex flex_column">';

				$company_name = get_field( 'company_name', $post->ID );
				$result       .= '<div class="company_block_header flex">';
				$result       .= '<div class="compare_container" id="p_c_compare_container_' . $post->ID . '" data-post-id="' . $post->ID . '">' . compare_icon( $post->ID ) . '</div>';
				if ( function_exists( 'review_logo' ) ) {
					$result .= review_logo( $post->ID );
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
						if ( $t_x <= 1 ) {
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
			$result .= '<span class="arrow_list"><span class="arrow_left_rate"><span  class="arrow_left_rate__arrow"></span><span  class="arrow_left_rate__text">Назад</span></span><span class="arrow_right_rate"><span  class="arrow_right_rate__text">Далее</span><span  class="arrow_right_rate__arrow"></span></span></span>';
		}
		wp_reset_postdata();
		$result .= '<div class="popular_ratings_links">';
		$result .= '<a class="color_dark_blue font_small font_bold link_no_underline link_all_ratings" href="' . get_the_permalink( $data['rating_id'] ) . '">' . __( 'Перейти в рейтинг', 'er_theme' ) . '</a>';
		$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}

}


if ( ! function_exists( 'generate_table_fields' ) ) {
	function generate_table_fields( $table, $type ) {
		$result = array();
		if ( ! empty( $table['value'] ) ) {
			$th    = array();
			$row   = array();
			$i     = 0;
			$total = count( $table['value'] );
			foreach ( $table['value'] as $td ) {
				if ( $td['hideme_short'] && $type == 'short' ) {
					continue;
				}
				$i ++;
				$th_item = array();
				$td_item = array();
				// echo '<pre>';
				//print_r($td);
				//echo '<pre>';
				if ( $td['text_na'] && $td['text_na'] != '' ) {
					$td_item['text_na'] = $td['text_na'];
				} else {
					$td_item['text_na'] = 'N/A';
				}
				$td_id = $td['td'];
				if ( $td['td_name'] != '' ) {
					$th_item['value']          = $td['td_name'];
					$td_item['value']['label'] = $td['td_name'];
				} else {
					$th_item['value']          = $td['td_term']->name;
					$td_item['value']['label'] = $td['td_term']->name;
				}
				$th_item['field_name'] = $td['td_term']->slug;
				if ( $td['sort'] ) {
					$th_item['sort'] = $td['sort'];
				}
				$td_item['value']['value'] = $td['td_term']->slug;

				if ( $td['button_text'] != '' && in_array( $td['td']['value'], array(
						'link_visit',
						'link_review'
					) ) ) {
					$td_item['button_text'] = $td['button_text'];
				}
				if ( $td['review_link'] != '' && in_array( $td['td']['value'], array( 'link_visit' ) ) ) {
					$td_item['review_link'] = $td['review_link'];
				}
				if ( $td['hideme'] == true ) {
					$hideme = ' hideme1';
				} else {
					$hideme = '';
				}
				if ( $i == '1' ) {
					$th_item['class'] = 'item_first' . $hideme;
					$td_item['class'] = 'item_first' . $hideme;
				} elseif ( $i == '2' && ! $er_tags[4] ) {
					$th_item['class'] = 'item_' . $i . $hideme;
					$td_item['class'] = 'item_' . $i . ' blueh' . $hideme;
				} elseif ( $i == $total ) {
					$th_item['class'] = 'item_last bright' . $hideme;
					$td_item['class'] = 'item_last bright' . $hideme;
				} else {
					$th_item['class'] = 'item_' . $i . $hideme;
					$td_item['class'] = 'item_' . $i . $hideme;
				}
				if ( $td['information_fields'] ) {
					$td_item['information_fields'] = $td['information_fields'];
				}
				if ( $td['date_name'] ) {
					$td_item['date_name'] = $td['date_name'];
				}
				if ( $td['width'] != '' ) {
					$th_item['width'] = $td['width'];
				}


				$th[]  = $th_item;
				$row[] = $td_item;
			}


		} else {


			if ( $type == 'short' ) {
				$th  = array(
					array(
						'value'      => 'Компания',
						'class'      => 'item_first',
						'field_name' => 'name'
					),
					array(
						'value'      => 'Информация',
						'class'      => 'item_2',
						'field_name' => 'information'
					),
					array(
						'value'      => 'Бонусы',
						'class'      => 'item_3 hideme1',
						'field_name' => 'bonus'
					),
					array(
						'value'      => 'Регистрация',
						'class'      => 'item_last bright',
						'field_name' => 'link_visit'
					),
				);
				$row = array(
					array(
						'value' => array(
							'value' => 'name',
							'label' => 'Компания'
						),
						'class' => 'item_first'
					),
					array(
						'value' => array(
							'value' => 'information',
							'label' => 'Информмация'
						),
						'class' => 'item_2'
					),
					array(
						'value' => array(
							'value' => 'bonus',
							'label' => 'Бонусы'
						),
						'class' => 'item_3'
					),
					array(
						'value'       => array(
							'value' => 'link_visit',
							'label' => 'Регистрация'
						),
						'button_text' => 'Перейти',
						'class'       => 'item_last bright'
					),
				);
			} else {
				$th  = array(
					array(
						'value'      => 'Компания',
						'class'      => 'item_first',
						'field_name' => 'name'
					),
					array(
						'value'      => 'Бонусы',
						'class'      => 'item_2',
						'field_name' => 'bonus'
					),
					array(
						'value'      => 'Обзор',
						'class'      => 'item_3 hideme1',
						'field_name' => 'link_review'
					),
					array(
						'value'      => 'Регистрация',
						'class'      => 'item_last bright',
						'field_name' => 'link_visit'
					),
				);
				$row = array(
					array(
						'value' => array(
							'value' => 'name',
							'label' => 'Компания'
						),
						'class' => 'item_first'
					),
					array(
						'value' => array(
							'value' => 'bonus',
							'label' => 'Бонусы'
						),
						'class' => 'item_2 blueh'
					),
					array(
						'value' => array(
							'value' => 'link_review',
							'label' => 'Обзор'
						),
						'class' => 'item_3 hideme1'
					),
					array(
						'value'       => array(
							'value' => 'link_visit',
							'label' => 'Регистрация'
						),
						'button_text' => 'Перейти',
						'class'       => 'item_last bright'
					),
				);
			}
		}

		$result['th']  = $th;
		$result['row'] = $row;

		return $result;
	}
}


if ( ! function_exists( 'resort_table' ) ) {
	add_action( 'wp_ajax_resort_table', 'resort_table' );
	add_action( 'wp_ajax_nopriv_resort_table', 'resort_table' );
	function resort_table() {
		$result  = '';
		$data    = $_POST;
		$tag     = $data['tag'];
		$order   = $data['order'];
		$field   = $data['field'];
		$post_id = $data['post_id'];
		$fields  = get_field( 'more_fields', $post_id );
		$args    = array(
			'post_type'      => 'casino',
			'order'          => $order,
			'posts_per_page' => 100,
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => $tag,
				),
			),
		);

		if ( $field == 'system_count_bad' ) {
			if ($order == 'DESC') {
				$args['order'] = 'ASC';
			} elseif ($order == 'ASC') {
				$args['order'] = 'DESC';
			}
		}

		if ( $field == 'system_count_reviews' ) {
			if ($order == 'DESC') {
				$args['order'] = 'ASC';
			} elseif ($order == 'ASC') {
				$args['order'] = 'DESC';
			}
		}
		if ( $field == 'number' ) {
			if ($order == 'DESC') {
				$args['order'] = 'ASC';
			} elseif ($order == 'ASC') {
				$args['order'] = 'DESC';
			}
		}

		if ( $field == 'name' ) {
			$args['meta_key'] = 'company_name';
			$args['orderby']  = 'meta_value';
		} elseif ( $field == 'system_count_reviews' ) {
			$args['meta_key'] = 'reviews_count_reviews';
			$args['orderby']  = 'meta_value_num';
		} elseif ( $field == 'system_count_good' ) {
			$args['meta_key'] = 'reviews_count_good';
			$args['orderby']  = 'meta_value_num';
		} elseif ( $field == 'system_count_bad' ) {
			$args['meta_key'] = 'reviews_count_bad';
			$args['orderby']  = 'meta_value_num';
		} elseif ( $field == 'actives' ) {
			$args['meta_key'] = 'count_assets_0_number';
			$args['orderby']  = 'meta_value_num';
		} elseif ( $field == 'system_rating' ) {
			$args['meta_key'] = 'reviews_rating_average';
			$args['orderby']  = 'meta_value_num';
		} elseif ( $field == 'number' ) {
			$args['orderby'] = 'menu_order';
			//$args['order'] = $order;
		} elseif ($field == 'number_of_cryptocurrencies') {
			//$result .= '353535';
			$args['meta_key'] = 'number_of_cryptocurrencies_0_number';
			$args['orderby']  = 'meta_value_num';
		}


		if ( ! empty( $fields ) ) {
			include (TEMPLATEPATH . '/inc/rating_includes.php');
		}


		$reviews = new WP_Query( $args );
		$result  .= '<span style="display:none" class="count_rating">'.$reviews->found_posts.'</span>';
		$result  .= rating_table( $tag, $reviews );
		echo $result;
		die;
	}

}

if ( ! function_exists( 'resort_table_load_more' ) ) {
	add_action( 'wp_ajax_resort_table_load_more', 'resort_table_load_more' );
	add_action( 'wp_ajax_nopriv_resort_table_load_more', 'resort_table_load_more' );
	function resort_table_load_more() {
		$result  = '';
		$data    = $_POST;
		$tag     = $data['tag'];
		$offset  = $data['offset'];
		$total   = $data['total'];
		$post_id = $data['post_id'];
		$fields  = get_field( 'more_fields', $post_id );
		$args    = array(
			'post_status' => 'publish',
			'post_type'      => 'casino',
			'orderby'        => 'menu_order',
			'posts_per_page' => 100,
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => $tag,
				),
			),
		);
		if ( $offset && $offset > 0 ) {
			$args['offset'] = $offset;
		}

		if ( ! empty( $fields ) ) {
			include (TEMPLATEPATH . '/inc/rating_includes.php');
		}
		$reviews = new WP_Query( $args );
		$result  .= rating_table_more( $tag, $reviews, $offset, $post_id );
		echo $result;
		die;
	}

}


if ( ! function_exists( 'filter_table' ) ) {
	add_action( 'wp_ajax_filter_table', 'filter_table' );
	add_action( 'wp_ajax_nopriv_filter_table', 'filter_table' );
	function filter_table() {
		echo $_POST['fields'];
		$fields = str_replace( '\\', '', $_POST['fields'] );
		$fields = json_decode( $fields, true );
		echo '<pre>';
		print_r( $fields );
		echo '</pre>';
		$result = '';
		$data   = $_POST;
		$tag    = $data['tag'];
		$args   = array(
			'post_type'      => 'casino',
			'posts_per_page' => 100,
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => $tag,
				),
			),
		);
		/*if($field == 'name') {
			$args['orderby'] = 'title';
		} elseif($field == 'system_count_reviews') {
			$args['meta_key'] = 'reviews_count_reviews';
			$args['orderby'] = 'meta_value';
		} elseif($field == 'system_count_good') {
			$args['meta_key'] = 'reviews_count_good_percent';
			$args['orderby'] = 'meta_value';
		} elseif($field == 'system_count_bad') {
			$args['meta_key'] = 'reviews_count_bad_percent';
			$args['orderby'] = 'meta_value';
		} elseif($field == 'system_rating') {
			$args['meta_key'] = 'reviews_rating_average';
			$args['orderby'] = 'meta_value';
		} elseif($field == 'number') {
			$result .= $field;
			$args['meta_key'] = 'menu_order';
			$args['orderby'] = 'meta_value';
		}*/
		$reviews = new WP_Query( $args );
		$result  .= rating_table( $tag, $reviews );
		echo $result;
		die;
	}

}

function my_posts_where_documents_list( $where ) {
//documents_list_$_documents
	$where = str_replace( "meta_key = 'documents_list_$", "meta_key LIKE 'documents_list_%", $where );

	return $where;
}
add_filter( 'posts_where', 'my_posts_where_documents_list' );


function my_posts_where_base_2_bonuses( $where ) {
//documents_list_$_documents
	$where = str_replace( "meta_key = 'base_2_bonuses_$", "meta_key LIKE 'base_2_bonuses_%", $where );

	return $where;
}
add_filter( 'posts_where', 'my_posts_where_base_2_bonuses' );

function carbooking_prices_0_services_list( $where ) {
//documents_list_$_documents
	$where = str_replace( "meta_key = 'carbooking_prices_$", "meta_key LIKE 'carbooking_prices_%", $where );

	return $where;
}
add_filter( 'posts_where', 'carbooking_prices_0_services_list' );


function services_plus_0_services_list( $where ) {
	$where = str_replace( "meta_key = 'services_plus_$", "meta_key LIKE 'services_plus_%", $where );

	return $where;
}
add_filter( 'posts_where', 'services_plus_0_services_list' );


function services_promote_0_services_list( $where ) {
	$where = str_replace( "meta_key = 'services_promote_$", "meta_key LIKE 'services_promote_%", $where );

	return $where;
}
add_filter( 'posts_where', 'services_promote_0_services_list' );
//services_promote_$_services_list


function base_2_additional_fields_0_label( $where ) {
	$where = str_replace( "meta_key = 'base_2_additional_fields_$", "meta_key LIKE 'base_2_additional_fields_%", $where );

	return $where;
}
add_filter( 'posts_where', 'base_2_additional_fields_0_label' );
//base_2_additional_fields_$_label

function pros_0_text( $where ) {
	$where = str_replace( "meta_key = 'pros_$", "meta_key LIKE 'pros_%", $where );

	return $where;
}
add_filter( 'posts_where', 'pros_0_text' );
function services_0_services_list( $where ) {
	$where = str_replace( "meta_key = 'services_$", "meta_key LIKE 'services_%", $where );

	return $where;
}
add_filter( 'posts_where', 'services_0_services_list' );
//services_$_services_list


add_filter( 'posts_where', 'pros_0_text' );
function earn_methods_0_services_list( $where ) {
	$where = str_replace( "meta_key = 'earn_methods_$", "meta_key LIKE 'earn_methods_%", $where );

	return $where;
}
add_filter( 'posts_where', 'earn_methods_0_services_list' );
//earn_methods_$_services_list


function base_2_plarforms_0_device( $where ) {
	$where = str_replace( "meta_key = 'base_2_plarforms_$", "meta_key LIKE 'base_2_plarforms_%", $where );

	return $where;
}
add_filter( 'posts_where', 'base_2_plarforms_0_device' );
//earn_methods_$_services_list



/*if (! function_exists('get_more_post_per_company')) {
	function get_more_post_per_company($args = 0, $fields = 0) {

		return $args;
	}
}*/

if ( ! function_exists( 'rating_table_similar' ) ) {
	function rating_table_similar() {
		$result = '';
		global $post;
		$curr_page = $post->ID;
		wp_reset_postdata();
		$children = get_pages( array( 'child_of' => $curr_page ) );
		if ( count( $children ) > 0 ) {
			$pages = $children;
		} else {
			$curr_tag    = get_field( 'rating_tag', $curr_page );
			$tag_widgets = get_field( 'tag_widgets', 'term_' . $curr_tag );
			$tags_array  = array();
			if ( ! empty( $tag_widgets ) ) {
				foreach ( $tag_widgets as $widget ) {
					$tags_array[] = get_field( 'tag', $widget );
				}
			}
			//echo '<div style="display:none;">';
			//print_r($tags_array);
			//echo '</div>';
			$args = array(
				'posts_per_page' => 3,
				'post_type'      => 'page',
				'post__not_in'   => array( $curr_page ),
				'meta_query'     => array(
					'relation' => 'AND',
					array(
						'key'   => '_wp_page_template',
						'value' => 'template-rating.php'
					),
					array(
						'key'     => 'rating_tag',
						'value'   => $tags_array,
						'compare' => 'IN',
					)
				)
			);

			$query = new WP_Query( $args );
			$pages = $query->posts;
			/*$pages = get_pages(array(
				'meta_key' => '_wp_page_template',
				'meta_value' => 'template-rating.php',
				'number' => 3,
				//'sort_column' => 'rand',
				//'sort_order' => 'ASC'
			));*/
		}


		if ( ! empty( $pages ) ) {
			$result .= '<div class="white_block rating_table rating_table_all" data-count="'.count($pages).'">';
			$y      = 0;
			foreach ( $pages as $page ) {
				$y ++;
				if ($y < 6) {
					$tag_term        = get_term( get_field( 'rating_tag', $page->ID ), 'affiliate-tags' );
					$tag_human_title = get_field( 'tag_human_title', 'term_' . $tag_term->term_id );
					$tag             = $tag_term->slug;
					$fields          = get_field( 'more_fields', $page->ID );
					$args            = array(
						'post_type'      => 'casino',
						'posts_per_page' => 3,
						'orderby'        => 'menu_order',
						'order'          => 'ASC',
						'tax_query'      => array(
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

					$reviews       = new WP_Query( $args );
					$count_reviews = $reviews->found_posts;
					wp_reset_postdata();
					$p_i    = 0;
					$result .= '<div class="main_row rating_table_row">';
					$result .= '<div class="rating_table_td rating_all_logos flex">';
					if ( $count_reviews > 0 ) {
						$arr_post_temp = [];
						foreach ( $reviews->posts as $item ) {
							if (in_array($item->ID, $arr_post_temp)) {

							} else {
								$p_i ++;
								if ( $p_i <= 3 ) {
									$result .= review_logo( $item->ID );
								}
							}
							$arr_post_temp[] = $item->ID;

						}
					}
					$result .= '</div>';
					$result .= '<div class="rating_table_td rating_all_title flex flex_column ">';
					$result .= '<div class="font_new_medium font_bold m_b_5"><a href="' . get_the_permalink( $page->ID ) . '" target="_blank" class="link_no_underline color_dark_blue">' . get_the_title( $page->ID ) . '</a></div>';
					$result .= '<div>';
					$result .= '<span class="color_dark_gray font_small m_right_10">' . __( 'Рубрика:', 'er_theme' ) . '</span>';
					$result .= '<span class="color_dark_blue font_small font_underline_dotted">' . $tag_human_title . '</span>';
					$result .= '</div>';
					$result .= '</div>';
					$result .= '<div class="rating_table_td rating_all_count color_dark_blue">';
					$result .= '<div class="font_small font_bold">' . __( 'В рейтинге:', 'er_theme' ) . '</div>';
					if($tag == 'bloggers') {
						$result .= '<div class="font_small font_underline_dotted inline_block" data-v="1">' . $count_reviews . ' ' . counted_text( $count_reviews, __( 'блогер', 'er_theme' ), __( 'блогера', 'er_theme' ), __( 'блогеров', 'er_theme' ) ) . '</div>';
					} else {
						$result .= '<div class="font_small font_underline_dotted inline_block" data-v="2">' . $count_reviews . ' ' . counted_text( $count_reviews, __( 'компания', 'er_theme' ), __( 'компании', 'er_theme' ), __( 'компаний', 'er_theme' ) ) . '</div>';
					}

					$result .= '</div>';
					$result .= '</div>';
				}
			}
			$result .= '</div>';
		}

		return $result;
	}
}

if ( ! function_exists( 'rating_table_all' ) ) {
	function rating_table_all( $tags = array(), $sort = 'title' ) {
		$result = '';

		$args = array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'template-rating.php',
			'order'          => 'ASC',
			'orderby'        => 'title',
			'posts_per_page' => '-1',
		);
		//echo $sort;
		if ( $sort == 'title' ) {
			$args['order']   = 'ASC';
			$args['orderby'] = 'title';
		} elseif ( $sort == 'title_reverse' ) {
			$args['order']   = 'DESC';
			$args['orderby'] = 'title';
		} elseif ( $sort == 'new' ) {
			$args['order']   = 'DESC';
			$args['orderby'] = 'date';
		} elseif ( $sort == 'old' ) {
			$args['order']   = 'ASC';
			$args['orderby'] = 'date';
		}
		if ( ! empty( $tags ) ) {
			//print_r($tags);
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'term_id',
					'terms'    => $tags,
				),
			);
		}
		//echo '<pre>';
		//print_r($args);
		//echo '</pre>';
		//$pages = get_pages($args);
		$pages = new WP_Query( $args );
		//echo '<pre>';
		//print_r($pages->posts);
		//echo '</pre>';
		if ( ! empty( $pages->posts ) ) {
			$result .= '<div class="white_block rating_table rating_table_all">';
			foreach ( $pages->posts as $page ) {
				if ( isRussian( mb_substr( ( get_the_title( $page->ID ) ), 0, 1 ) ) ) {
					$tag_term        = get_term( get_field( 'rating_tag', $page->ID ), 'affiliate-tags' );
					$tag_human_title = get_field( 'tag_human_title', 'term_' . $tag_term->term_id );
					$tag             = $tag_term->slug;
					$fields          = get_field( 'more_fields', $page->ID );
					$args            = array(
						'post_type'      => 'casino',
						'posts_per_page' => 3,
						'orderby'        => 'menu_order',
						'order'          => 'ASC',
						'tax_query'      => array(
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
					$reviews       = new WP_Query( $args );
					$count_reviews = $reviews->found_posts;
					wp_reset_postdata();
					$p_i    = 0;
					$result .= '<div class="main_row rating_table_row">';
					$result .= '<div class="rating_table_td rating_all_logos flex">';
					$arr_post_temp = [];
					if ( $count_reviews > 0 ) {
						foreach ( $reviews->posts as $item ) {
							if (in_array($item->ID, $arr_post_temp)) {

							} else {
								$p_i ++;
								if ( $p_i <= 3 ) {
									$result .= review_logo( $item->ID );
								}
							}
							$arr_post_temp[] = $item->ID;
						}
					}
					$result .= '</div>';
					$result .= '<div class="rating_table_td rating_all_title flex flex_column ">';
					$result .= '<div class="font_new_medium font_bold m_b_5"><a href="' . get_the_permalink( $page->ID ) . '" target="_blank" class="link_no_underline color_dark_blue">' . get_the_title( $page->ID ) . '</a></div>';
					$result .= '<div>';
					$result .= '<span class="color_dark_gray font_small m_right_10">' . __( 'Рубрика:', 'er_theme' ) . '</span>';
					$result .= '<span class="color_dark_blue font_small font_underline_dotted">' . $tag_human_title . '</span>';
					$result .= '</div>';
					$result .= '</div>';
					$result .= '<div class="rating_table_td rating_all_count color_dark_blue">';
					$result .= '<div class="font_small font_bold">' . __( 'В рейтинге:', 'er_theme' ) . '</div>';
					if($tag == 'bloggers') {
						$result .= '<div class="font_small font_underline_dotted inline_block" data-v="3">' . $count_reviews . ' ' . counted_text( $count_reviews, __( 'блогер', 'er_theme' ), __( 'блогера', 'er_theme' ), __( 'блогеров', 'er_theme' ) ) . '</div>';
					} else {
						$result .= '<div class="font_small font_underline_dotted inline_block"  data-v="4">' . $count_reviews . ' ' . counted_text( $count_reviews, __( 'компания', 'er_theme' ), __( 'компании', 'er_theme' ), __( 'компаний', 'er_theme' ) ) . '</div>';
					}
					$result .= '</div>';
					$result .= '</div>';
				}
			}
			foreach ( $pages->posts as $page ) {
				if ( isRussian( mb_substr( ( get_the_title( $page->ID ) ), 0, 1 ) ) ) {
				} else {
					$tag_term        = get_term( get_field( 'rating_tag', $page->ID ), 'affiliate-tags' );
					$tag_human_title = get_field( 'tag_human_title', 'term_' . $tag_term->term_id );
					$tag             = $tag_term->slug;
					$fields          = get_field( 'more_fields', $page->ID );
					$args            = array(
						'post_type'      => 'casino',
						'posts_per_page' => 3,
						'orderby'        => 'menu_order',
						'order'          => 'ASC',
						'tax_query'      => array(
							array(
								'taxonomy' => 'affiliate-tags',
								'field'    => 'name',
								'terms'    => $tag,
							),
						),
					);
					if ( ! empty( $fields ) ) {
						$args['meta_query'] = array(
							'relation' => 'AND',
						);
						foreach ( $fields as $field ) {
							$args['meta_query'][] = array(
								'key'     => get_term( $field['key'], 'field_types' )->slug,
								'value'   => $field['value'],
								'compare' => 'LIKE',
							);

						}
					}
					$reviews       = new WP_Query( $args );
					$count_reviews = $reviews->found_posts;
					wp_reset_postdata();
					$p_i    = 0;
					$result .= '<div class="main_row rating_table_row">';
					$result .= '<div class="rating_table_td rating_all_logos flex">';
					if ( $count_reviews > 0 ) {
						foreach ( $reviews->posts as $item ) {
							$p_i ++;
							if ( $p_i <= 3 ) {
								$result .= review_logo( $item->ID );
							}
						}
					}
					$result .= '</div>';
					$result .= '<div class="rating_table_td rating_all_title flex flex_column ">';
					$result .= '<div class="font_new_medium font_bold m_b_5"><a href="' . get_the_permalink( $page->ID ) . '" target="_blank" class="link_no_underline color_dark_blue">' . get_the_title( $page->ID ) . '</a></div>';
					$result .= '<div>';
					$result .= '<span class="color_dark_gray font_small m_right_10">' . __( 'Рубрика:', 'er_theme' ) . '</span>';
					$result .= '<span class="color_dark_blue font_small font_underline_dotted">' . $tag_human_title . '</span>';
					$result .= '</div>';
					$result .= '</div>';
					$result .= '<div class="rating_table_td rating_all_count color_dark_blue">';
					$result .= '<div class="font_small font_bold">' . __( 'В рейтинге:', 'er_theme' ) . '</div>';
					if($tag == 'bloggers') {
						$result .= '<div class="font_small font_underline_dotted inline_block" data-v="5">' . $count_reviews . ' ' . counted_text( $count_reviews, __( 'блогер', 'er_theme' ), __( 'блогера', 'er_theme' ), __( 'блогеров', 'er_theme' ) ) . '</div>';
					} else {
						$result .= '<div class="font_small font_underline_dotted inline_block" data-v="6">' . $count_reviews . ' ' . counted_text( $count_reviews, __( 'компания', 'er_theme' ), __( 'компании', 'er_theme' ), __( 'компаний', 'er_theme' ) ) . '</div>';
					}
					$result .= '</div>';
					$result .= '</div>';
				}
			}
			$result .= '</div>';
		}

		return $result;
	}
}

function my_posts_where_regul( $where ) {

	$where = str_replace( "meta_key = 'regulators_list_$", "meta_key LIKE 'regulators_list_%", $where );

	return $where;
}

add_filter( 'posts_where', 'my_posts_where_regul' );

if ( ! function_exists( 'rating_table_default' ) ) {
	function rating_table_default( $tag, $fields ) {
		$result = '';
		$fields = get_field( 'more_fields' );
		global $post;
		$post_idd = $post->ID;
		wp_reset_postdata();
		$args = array(
			'post_type'      => 'casino',
			'orderby'        => 'menu_order',
			'posts_per_page' => 100,
			'order'          => 'ASC',
			'tax_query'      => array(
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
		$reviews   = new WP_Query( $args );
		$count_all = $reviews->found_posts;
		$result    .= rating_table( $tag, $reviews );
		//$result .= '<div style="display:none;">test</div>';
		if ( $count_all > 100 ) {
			$more_classes = 'button pointer button_violet radius_small button_padding_big font_small font_bold button_centered line_show_more_rating_rows flex';
			$result       .= '<div class="' . $more_classes . ' inactive" data-offset="100" data-per-page="100" data-total="' . $count_all . '" data-post-id="' . $post_idd . '" data-tag="' . $tag . '">' . __( 'Показать еще', 'sa_theme' ) . '</div>';
		}

		return $result;
	}
}


if ( ! function_exists( 'rating_table_more' ) ) {
	function rating_table_more( $tag, $query, $offset, $post_id ) {
		$post_idd      = $post_id;
		$add_signature = get_field( 'add_signature', $post_idd );
		$result        = '';

		$term_id = get_term_by( 'name', $tag, 'affiliate-tags' )->term_id;

		if ( get_field( 'tags_rating_inherit', 'term_' . $term_id ) ) {
			$custom_table        = get_field_object( 'tags_recommended_fields_rating_new', 'term_' . get_field( 'tags_rating_inherit', 'term_' . $term_id ) );
			$custom_table_more_1 = get_field_object( 'tags_recommended_fields_rating_more_1', 'term_' . get_field( 'tags_rating_inherit', 'term_' . $term_id ) );
			$custom_table_more_2 = get_field_object( 'tags_recommended_fields_rating_more_2', 'term_' . get_field( 'tags_rating_inherit', 'term_' . $term_id ) );
		} else {
			$custom_table        = get_field_object( 'tags_recommended_fields_rating_new', 'term_' . $term_id );
			$custom_table_more_1 = get_field_object( 'tags_recommended_fields_rating_more_1', 'term_' . $term_id );
			$custom_table_more_2 = get_field_object( 'tags_recommended_fields_rating_more_2', 'term_' . $term_id );
		}
		//echo '<pre>';
		$table_1      = generate_table_fields( $custom_table, 'full' );
		$table_more_1 = generate_table_fields( $custom_table_more_1, 'full' );
		$table_more_2 = generate_table_fields( $custom_table_more_2, 'full' );

		$th_1       = $table_1['th'];
		$row_1      = $table_1['row'];
		$row_more_1 = $table_more_1['row'];
		$row_more_2 = $table_more_2['row'];
		//$result .= generate_table_fields($custom_table,'full');
		//echo '</pre>';

		$reviews = $query;
		$arr_post_temp = [];
		if ( $reviews->have_posts() ) {
			$count = $reviews->found_posts;

			//$result .= '<div class="white_block rating_table">';
			$i = $offset;
			while ( $reviews->have_posts() ) {
				if (in_array(get_the_ID(), $arr_post_temp)) {

				} else {

					$reviews->the_post();
					global $post;
					$i ++;
					$company_name        = get_field( 'company_name' );
					$company_link_review = get_the_permalink();
					//echo $rating_fields_group;
					$link                  = get_bloginfo( 'url' ) . '/visit/' . get_field( 'company_redirect_key' ) . '/';
					$er_company_site_str   = get_field( 'websites' )[0]['site_url'];
					$er_company_site_str_2 = preg_replace( '#^[^:/.]*[:/]+#i', '', $er_company_site_str );
					$site                  = preg_replace( '/^www\./', '', rtrim( $er_company_site_str_2, '/' ) );


					$result .= '<div class="main_row rating_table_row font_smaller" id="row_' . $i . '" data-menu-order="'.$post->menu_order.'">';
					$result .= '<div class="rating_table_td rating_field_number font_bold">' . $i . '</div>';
					foreach ( $row_1 as $row ) {
						$ffvalue_0 = '';
						$ffvalue_0 = brokers_field_new( $row, get_the_ID(), $the_field );
						if ( $ffvalue_0 && $ffvalue_0 != '' && $ffvalue_0 != 'N/A' ) {
							$result .= '<div class="rating_table_td ' . $row['class'] . ' rating_field_' . $row['value']['value'] . '">' . brokers_field_new( $row, get_the_ID(), $the_field ) . '</div>';
						} else {
							$result .= '<div class="rating_table_td ' . $row['class'] . ' rating_field_' . $row['value']['value'] . '">' . $row['text_na'] . '</div>';
						}

					}
					$result .= '<div class="rating_row_more flex flex_column">';
					if ( ! empty( $row_more_1 ) ) {

						$result .= '<div class="rating_sub_row flex rating_sub_row_first">';
						if ( $add_signature && $add_signature != '' ) {
							//$result .= '<div class="rating_add_signature"><span class="color_dark_gray font_smaller font_underline_dotted">' . $add_signature . '</span></div>';
						}
						foreach ( $row_more_1 as $row ) {
							$result  .= '<div class="rating_sub_row_td rating_field_' . $row['value']['value'] . '">';
							$result  .= '<div class="rating_sub_row_td_title m_b_10 color_medium_gray">' . $row['value']['label'] . '</div>';
							$ffvalue = '';
							$ffvalue = brokers_field_new( $row, get_the_ID(), $the_field );
							if ( $ffvalue && $ffvalue != '' && $ffvalue != 'N/A' ) {
								$result .= '<div class="rating_sub_row_td_content color_dark_blue font_18 font_bold">' . brokers_field_new( $row, get_the_ID(), $the_field ) . '</div>';
								$result .= '</div>';
							} else {
								$result .= '<div class="rating_sub_row_td_content color_dark_blue font_18 font_bold">' . $row['text_na'] . '</div>';
								$result .= '</div>';
							}

						}
						$result .= '</div>';
					}
					if ( ! empty( $row_more_2 ) ) {
						$result .= '<div class="rating_sub_row row_mini flex">';
						foreach ( $row_more_2 as $row ) {
							$result    .= '<div class="rating_sub_row_td flex rating_field_' . $row['value']['value'] . '">';
							$result    .= '<div class="rating_sub_row_td_title color_medium_gray">' . $row['value']['label'] . '</div>';
							$ffvalue_2 = '';
							$ffvalue_2 = brokers_field_new( $row, get_the_ID(), $the_field );
							if ( $ffvalue_2 && $ffvalue_2 != '' && $ffvalue_2 != 'N/A' ) {
								$result .= '<div class="rating_sub_row_td_content color_dark_blue font_small ">' . brokers_field_new( $row, get_the_ID(), $the_field ) . '</div>';
								$result .= '</div>';
							} else {
								$result .= '<div class="rating_sub_row_td_content color_dark_blue font_small ">' . $row['text_na'] . '</div>';
								$result .= '</div>';
							}


						}
						$result .= '</div>';
					}
					$result .= '<div class="rating_sub_row row_buttons flex">';
					if($tag == 'bloggers') {
						$company_link_text = __( 'Отзывы о блогере', 'er_theme' );
					} else {
						$company_link_text = __( 'Отзывы о компании', 'er_theme' );
					}
					$result .= '<a href="' . $company_link_review . '" class="button inline_block button_green pointer font_small font_bold link_no_underline" target="_blank">' . $company_link_text . ' ' . $company_name . '</a>';
					$result .= '<a class="button inline_block button_violet pointer font_small font_bold link_no_underline" href="' . $link . '" target="_blank">' . $site . '</a>';
					$result .= '</div>';
					$result .= '</div>';
					$result .= '</div>';
				}
				$arr_post_temp[] = get_the_ID();

			}
			//$result .= '</div>';

		}
		wp_reset_postdata();

		return $result;
	}
}


if ( ! function_exists( 'rating_table' ) ) {
	function rating_table( $tag, $query ) {
		global $post;
		$post_idd      = $post->ID;
		$add_signature = get_field( 'add_signature', $post_idd );
		wp_reset_postdata();
		$result = '';

		$term_id = get_term_by( 'name', $tag, 'affiliate-tags' )->term_id;

		if ( get_field( 'tags_rating_inherit', 'term_' . $term_id ) ) {
			$custom_table        = get_field_object( 'tags_recommended_fields_rating_new', 'term_' . get_field( 'tags_rating_inherit', 'term_' . $term_id ) );
			$custom_table_more_1 = get_field_object( 'tags_recommended_fields_rating_more_1', 'term_' . get_field( 'tags_rating_inherit', 'term_' . $term_id ) );
			$custom_table_more_2 = get_field_object( 'tags_recommended_fields_rating_more_2', 'term_' . get_field( 'tags_rating_inherit', 'term_' . $term_id ) );
		} else {
			$custom_table        = get_field_object( 'tags_recommended_fields_rating_new', 'term_' . $term_id );
			$custom_table_more_1 = get_field_object( 'tags_recommended_fields_rating_more_1', 'term_' . $term_id );
			$custom_table_more_2 = get_field_object( 'tags_recommended_fields_rating_more_2', 'term_' . $term_id );
		}
		//echo '<pre>';
		$table_1      = generate_table_fields( $custom_table, 'full' );
		$table_more_1 = generate_table_fields( $custom_table_more_1, 'full' );
		$table_more_2 = generate_table_fields( $custom_table_more_2, 'full' );

		$th_1       = $table_1['th'];
		$row_1      = $table_1['row'];
		$row_more_1 = $table_more_1['row'];
		$row_more_2 = $table_more_2['row'];
		//$result .= generate_table_fields($custom_table,'full');
		//echo '</pre>';

		$reviews = $query;
		if ( $reviews->have_posts() ) {
			$count = $reviews->found_posts;

			$result .= '<div class="white_block rating_table">';
			$i      = 0;
			$arr_post_temp = [];
			while ( $reviews->have_posts() ) {
				$reviews->the_post();
				global $post;
				if (in_array(get_the_ID(), $arr_post_temp)) {

				} else {
					$arr_post_temp[] = get_the_ID();
					$i ++;
					$company_name        = get_field( 'company_name' );
					$company_link_review = get_the_permalink();
					//echo $rating_fields_group;
					$link                  = get_bloginfo( 'url' ) . '/visit/' . get_field( 'company_redirect_key' ) . '/';
					$er_company_site_str   = get_field( 'websites' )[0]['site_url'];
					$er_company_site_str_2 = preg_replace( '#^[^:/.]*[:/]+#i', '', $er_company_site_str );
					$site                  = preg_replace( '/^www\./', '', rtrim( $er_company_site_str_2, '/' ) );


					$result .= '<div class="main_row rating_table_row font_smaller" id="row_' . $i . '" data-menu-order="'.$post->menu_order.'" data-row-id="'.$i.'" data-tags="'.implode(",", get_field('review_aff_tags',get_the_ID())).'">';
					$result .= '<div class="rating_table_td rating_field_number font_bold">' . $i . '</div>';
					foreach ( $row_1 as $row ) {
						$ffvalue_0 = '';
						$ffvalue_0 = brokers_field_new( $row, get_the_ID(), $the_field );
						if ( $ffvalue_0 && $ffvalue_0 != '' && $ffvalue_0 != 'N/A' ) {
							$result .= '<div class="rating_table_td ' . $row['class'] . ' rating_field_' . $row['value']['value'] . '">' . brokers_field_new( $row, get_the_ID(), $the_field ) . '</div>';
						} else {
							$result .= '<div class="rating_table_td ' . $row['class'] . ' rating_field_' . $row['value']['value'] . '">' . $row['text_na'] . '</div>';
						}

					}
					$result .= '<div class="rating_row_more flex flex_column">';

					if ( ! empty( $row_more_1 ) ) {
						$result .= '<div class="rating_sub_row flex rating_sub_row_first">';
						if ( $add_signature && $add_signature != '' ) {
							//$result .= '<div class="rating_add_signature"><span class="color_dark_gray font_smaller font_underline_dotted">' . $add_signature . '</span></div>';
						}
						foreach ( $row_more_1 as $row ) {
							$result  .= '<div class="rating_sub_row_td rating_field_' . $row['value']['value'] . '">';
							$result  .= '<div class="rating_sub_row_td_title m_b_10 color_medium_gray">' . $row['value']['label'] . '</div>';
							$ffvalue = '';
							$ffvalue = brokers_field_new( $row, get_the_ID(), $the_field );
							if ( $ffvalue && $ffvalue != '' && $ffvalue != 'N/A' ) {
								$result .= '<div class="rating_sub_row_td_content color_dark_blue font_18 font_bold">' . brokers_field_new( $row, get_the_ID(), $the_field ) . '</div>';
								$result .= '</div>';
							} else {
								$result .= '<div class="rating_sub_row_td_content color_dark_blue font_18 font_bold">' . $row['text_na'] . '</div>';
								$result .= '</div>';
							}

						}
						$result .= '</div>';
					}
					if ( ! empty( $row_more_2 ) ) {
						$result .= '<div class="rating_sub_row row_mini flex">';
						foreach ( $row_more_2 as $row ) {
							$result    .= '<div class="rating_sub_row_td flex rating_field_' . $row['value']['value'] . '">';
							$result    .= '<div class="rating_sub_row_td_title color_medium_gray">' . $row['value']['label'] . '</div>';
							$ffvalue_2 = '';
							$ffvalue_2 = brokers_field_new( $row, get_the_ID(), $the_field );
							if ( $ffvalue_2 && $ffvalue_2 != '' && $ffvalue_2 != 'N/A' ) {
								$result .= '<div class="rating_sub_row_td_content color_dark_blue font_small ">' . brokers_field_new( $row, get_the_ID(), $the_field ) . '</div>';
								$result .= '</div>';
							} else {
								$result .= '<div class="rating_sub_row_td_content color_dark_blue font_small ">' . $row['text_na'] . '</div>';
								$result .= '</div>';
							}


						}
						$result .= '</div>';
					}
					$result .= '<div class="rating_sub_row row_buttons flex">';
					if($tag == 'bloggers') {
						$company_link_text = __( 'Отзывы о блогере', 'er_theme' );
					} else {
						$company_link_text = __( 'Отзывы о компании', 'er_theme' );
					}
					$result .= '<a href="' . $company_link_review . '" class="button inline_block button_green pointer font_small font_bold link_no_underline" target="_blank">' . $company_link_text . ' ' . $company_name . '</a>';
					$result .= '<a class="button inline_block button_violet pointer font_small font_bold link_no_underline" href="' . $link . '" target="_blank">' . $site . '</a>';
					$result .= '</div>';
					$result .= '</div>';
					$result .= '</div>';
				}

			}
			$result .= '</div>';

		}
		wp_reset_postdata();

		return $result;
	}
}


function bonustable_func( $atts ) {
	extract( shortcode_atts( array(
		'usa'             => 'n',
		'num'             => 10,
		'orderby'         => 'menu_order',
		'sort'            => 'ASC',
		'type'            => 'full',
		'meta_key'        => '',
		'meta_value'      => '',
		'show_search'     => 0,
		'full_link'       => '',
		'full_link_title' => __( "Перейти в рейтинг", "er_theme" ),
		'tag'             => '',
		'autoload'        => 0,
		'version'         => 1
	), $atts ) );
	$result = '';
	//$result .= $meta_key;
	//$result .= $sort.'<br />'.$type.'<br />'.$show_search.'<br />'.$orderby.'<br />'.$num.'<br />'.$tag.'<br />'.$version;
	$term_id = get_term_by( 'slug', $tag, 'affiliate-tags' )->term_id;
	$result  .= bottom_brokers_new( array(
		$term_id,
		$orderby,
		$sort,
		$num,
		$type,
		$tag,
		$show_search,
		$meta_key,
		$meta_value
	) );
	if ( $autoload && $autoload != 0 ) {
		$result .= '<div class="autoload_posts_button_container"><a data-offset="100" class="autoload_posts_button"><span class="autoload_posts_button_texter">' . __( 'Показать еще', 'er_theme' ) . '</span><img src="/wp-content/themes/eto-razvod-1/img/spinner-solid.svg" alt=""></a></div>
		<script type="text/javascript">
    allpost = [];
		jQuery(".autoload_posts_button").click(function() {
		var offset = $(this).attr("data-offset");
        jQuery(this).addClass("loading");
          inumber = 0;    
          jQuery("tr[data-id]").each(function() {
          inumber++;
          allpost.push(jQuery(this).attr("data-id"));
          })
          var offset = inumber; //закомментить если что
          var sizeoffset = 51; //поменять на 50 если что
          //console.log($(this).attr("data-offset"));
          //console.log(sizeoffset);
		$.ajax({
			url: "' . admin_url( "admin-ajax.php" ) . '",
			type: "POST",
			data: "action=autoload_posts_rating&offset="+offset+"&orderby=' . $orderby . '&order=' . $sort . '&post_type=casino&posts_per_page="+sizeoffset+"&type=' . $type . '&tag=' . $tag . '&meta_key=' . $meta_key . '&meta_value=' . $meta_value . '&term_id=' . $term_id . '&pn="+allpost+"",
			beforeSend: function(xhr) {

			},
			success: function( data ) {
                jQuery(".autoload_posts_button").removeClass("loading");
			//alert("ok");
				//alert(data);

				var obj = jQuery.parseJSON( data );
        //alert(obj.pn);
				$( ".autoload_posts_button" ).attr( "data-offset", obj.new_offset );
				$( "#table_shop tbody" ).append( $( obj.posts ) );
				if(obj.last_click === true) {
					$(".autoload_posts_button").remove();
				}
                jQuery(".tablewrapper-ins tr > td").each(function() {
if (($(this).hasClass("item_first")) || ($(this).hasClass("bonus")) || ($(this).hasClass("item_last"))  ) {
} else {
if (jQuery(this).hasClass("dntch")) {
} else {
jQuery(this).addClass("dntch");
htmlgetter = jQuery(this).html();
jQuery(this).html("<div class=\"newjsblock\">"+htmlgetter+"</div>");
}

}
})
jQuery(".comptable .bonus_div").each(function() {
    if (jQuery(this).hasClass(\'dntch\')) {  } else {
    jQuery(this).addClass(\'dntch\');
if (jQuery(this).text() == "") {
jQuery(this).parent().addClass("hideempty");
jQuery(this).parent().remove();
}
jQuery(this).find(".bonus_comment").attr("data-text", jQuery(this).find(".bonus_comment").text());
topstyletable = jQuery(this).find(".bonus_comment").height() + 29;
jQuery( "<span class=\"newcomment\" style=\"display:none;top: -"+topstyletable+"px\">"+jQuery(this).find(".bonus_comment").text()+"</span>" ).insertBefore(jQuery(this).find(".bonus_comment").parent());
jQuery(this).find(".bonus_comment").empty();
}
})
jQuery(".comptable tbody > tr").each(function() {
if (jQuery(this).hasClass("dntch")) {  } else {
jQuery(this).addClass("dntch");
if (jQuery(this).parent().parent().parent().attr("id") != "bottom_brokers_list") {
if (!(jQuery(this).find(".bonus-wrapper").length)) {
if (jQuery(this).height() > 70) {
gethtml = jQuery(this).find("td.item_last.link_visit").html();
gethtml = "<div class=\"showwrapper\">"+gethtml+"<span class=\"goshow\"></span></div>";
jQuery(this).find("td.item_last.link_visit").empty();
jQuery(this).find("td.item_last.link_visit").html(gethtml);
jQuery(this).addClass("addshadow");
jQuery(this).find("td").attr("style", "overflow: hidden");
jQuery(this).attr("true-height", jQuery(this).height()+"px");
}
jQuery(this).find(".list_style_2").attr("style", "height: 32px;display: flex;align-items: flex-start;");
jQuery(this).find(".lending_rate>div").attr("style", "height: 32px;display: flex;align-items: flex-start;");
jQuery(this).find(".bonus-wrapper").attr("style", "height: 32px;display: flex;align-items: flex-start;");
jQuery(this).find(".field_text.safe_rules").attr("style", "height: 15px;display: flex;align-items: flex-start;");
jQuery(this).find("span.field_text.project_details").attr("style", "height: 32px;display: flex;align-items: flex-start;");
jQuery(this).find("td.item_4.pros > div").attr("style", "height: 32px;display: flex;align-items: flex-start;");
jQuery(this).attr("style","height: 76px");
} else {
if (jQuery(this).height() > 70) {
gethtml = jQuery(this).find("td.item_last.link_visit").html();
gethtml = "<div class=\"showwrapper\">"+gethtml+"<span class=\"goshow\"></span></div>";
jQuery(this).find("td.item_last.link_visit").empty();
jQuery(this).find("td.item_last.link_visit").html(gethtml);
jQuery(this).addClass("addshadow");
jQuery(this).find("td").attr("style", "overflow: hidden");
jQuery(this).attr("true-height", jQuery(this).height()+"px");
jQuery(this).find(".bonus_div").each(function(){
if (jQuery(this).text().length > 15) {
if ((jQuery(this).text().length > 21)) {
jQuery(this).parent().addClass("gohideahref30");
} else {
jQuery(this).parent().addClass("gohideahref");
}

}
})
}
jQuery(this).attr("date-test",jQuery(this).height());
jQuery(this).find(".list_style_2").attr("style", "height: 60px;display: flex;align-items: flex-start;");
jQuery(this).find(".bonus-wrapper").attr("style", "height: 60px;display: flex;align-items: flex-start;");
jQuery(this).find(".project_details").attr("style", "height: 60px;display: flex;align-items: flex-start;");
jQuery(this).find(".newjsblock").attr("style", "height: 60px;display: flex;align-items: flex-start;flex-direction: column;");
jQuery(this).find(".field_text.safe_rules").attr("style", "height: 43px;display: flex;align-items: flex-start;");
jQuery(this).find("span.field_text.project_details").attr("style", "height: 60px;display: flex;align-items: flex-start;");
jQuery(this).find("td.item_4.pros > div").attr("style", "height: 60px;display: flex;align-items: flex-start;");
jQuery(this).attr("style","height: 76px");
jQuery(this).find(".bonus-wrapper").each(function(){
if (jQuery(this).children().length == 1) {
if ((jQuery(this).text().length > 60)) {
} else {
jQuery(this).children().attr("style","display:block !important;");
}
}
})
}
}
}
})
jQuery( "span.goshow" ).toggle(function() {
getTr = jQuery(this).parent().parent().parent();
getTr.find("td").removeAttr("style");
getTr.removeClass("addshadow");
getTr.find(".list_style_2").removeAttr("style");
getTr.find(".bonus-wrapper").removeAttr("style");
getTr.find(".lending_rate>div").removeAttr("style");
getTr.find(".project_details").removeAttr("style");
getTr.find(".newjsblock").removeAttr("style");
getTr.find(".field_text.safe_rules").removeAttr("style");
getTr.find("span.field_text.project_details").removeAttr("style");
getTr.find("td.item_4.pros > div").removeAttr("style");
jQuery(this).css("transform", "rotate(180deg)");
getTr.find(".bonus_div").each(function(){
if (jQuery(this).text().length > 15) {
if ((jQuery(this).text().length > 21)) {
jQuery(this).parent().removeClass("gohideahref30");
} else {
jQuery(this).parent().removeClass("gohideahref");
}
}
})
getTr.removeAttr("style");
getTr.find(".bonus-wrapper").each(function(){
if (jQuery(this).children().length == 1) {
if ((jQuery(this).text().length > 60)) {
} else {
jQuery(this).children().attr("style","display:block !important;");
}
}
})
}, function() {
if (!(getTr.find(".bonus-wrapper").length)) {
getTr = jQuery(this).parent().parent().parent();
getTr.addClass("addshadow");
getTr.find("td").attr("style", "overflow: hidden");
getTr.find(".list_style_2").attr("style", "height: 32px;display: flex;align-items: flex-start;");
getTr.find(".bonus-wrapper").attr("style", "height: 32px;display: flex;align-items: flex-start;");
getTr.find(".lending_rate>div").attr("style", "height: 32px;display: flex;align-items: flex-start;");
getTr.find(".field_text.safe_rules").attr("style", "height: 15px;display: flex;align-items: flex-start;");
getTr.find("span.field_text.project_details").attr("style", "height: 32px;display: flex;align-items: flex-start;");
getTr.find("td.item_4.pros > div").attr("style", "height: 32px;display: flex;align-items: flex-start;");
jQuery(this).css("transform", "rotate(0)");
getTr.attr("style","height: 76px");
} else {
getTr = jQuery(this).parent().parent().parent();
getTr.addClass("addshadow");
getTr.find("td").attr("style", "overflow: hidden");
getTr.find(".list_style_2").attr("style", "height: 60px;display: flex;align-items: flex-start;");
getTr.find(".bonus-wrapper").attr("style", "height: 60px;display: flex;align-items: flex-start;");
getTr.find(".project_details").attr("style", "height: 60px;display: flex;align-items: flex-start;");
getTr.find(".lending_rate>div").attr("style", "height: 60px;display: flex;align-items: flex-start;");
getTr.find(".newjsblock").attr("style", "height: 60px;display: flex;align-items: flex-start;flex-direction: column;");
getTr.find(".field_text.safe_rules").attr("style", "height: 43px;display: flex;align-items: flex-start;");
getTr.find("span.field_text.project_details").attr("style", "height: 60px;display: flex;align-items: flex-start;");
getTr.find("td.item_4.pros > div").attr("style", "height: 60px;display: flex;align-items: flex-start;");
jQuery(this).css("transform", "rotate(0)");
getTr.find(".bonus_div").each(function(){
if (jQuery(this).text().length > 15) {
if ((jQuery(this).text().length > 21)) {
jQuery(this).parent().addClass("gohideahref30");
} else {
jQuery(this).parent().addClass("gohideahref");
}
}
})
getTr.attr("style","height: 76px");
}
getTr.find(".bonus-wrapper").each(function(){
if (jQuery(this).children().length == 1) {
if ((jQuery(this).text().length > 60)) {
} else {
jQuery(this).children().attr("style","display:block !important;");
}
}
})
});
			}
		});
	});
		</script>
		';
	}

	return $result;
}


add_shortcode( 'bonustable', 'bonustable_func' );

function bottom_brokers_new( $er_tags ) {


	$result = '';

	$er_tag = array( $er_tags[0] );
	if ( ! $er_tags[4] ) {
		if ( get_field( 'block_title_recommend', 'term_' . $er_tags[0] ) ) {
			$result .= '<h2 id="bottombrokers">' . get_field( 'block_title_recommend', 'term_' . $er_tags[0] ) . '</h2>';
		} else {
			$result .= '<h2 id="bottombrokers">Выберите надежную компанию</h2>';
		}
	}
	if ( $er_tags[3] ) {
		$num = $er_tags[3];
	} else {
		$num = 3;
	}
	if ( $er_tags[2] ) {
		$sort = $er_tags[2];
	} else {
		$sort = 'ASC';
	}
	if ( $er_tags[1] ) {
		$orderby = $er_tags[1];
	} else {
		$orderby = 'menu_order';
	}


	$post__not_in = $er_tags[11];
	if ( $post__not_in && $post__not_in != '' ) {
		//$args[] =  explode(",", $post__not_in);
		$args = array(
			'post_type'      => 'casino',
			'posts_per_page' => $num,

			'orderby'     => 'menu_order',
			'order'       => 'ASC',
			'post_status' => 'publish',

			'tax_query' => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'id',
					'terms'    => $er_tag,
				),
			),
		);
	} else {
		$args = array(
			'post_type'      => 'casino',
			'posts_per_page' => $num,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post_status'    => 'publish',
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'id',
					'terms'    => $er_tag,
				),
			),
		);
	}

	if ( $er_tags[7] && $er_tags[8] ) {
		//echo $er_tags[7];
		//echo $er_tags[8];
		$args['meta_query'] = array(
			'relation' => 'AND',
			array(
				'key'     => $er_tags[7],
				'value'   => $er_tags[8],
				'compare' => 'LIKE',
			),
		);
	}

	$autoload_layout = $er_tags[9];
	$offset          = $er_tags[10];
	if ( $offset && $offset != '' ) {
		$args['offset'] = $offset;
	}


	//print_r($args);
	$er_posts = new WP_Query( $args );


	// The Loop
	if ( $er_posts->have_posts() ) {
		if ( $er_tags[4] ) {
			if ( get_field( 'tags_rating_inherit', 'term_' . $er_tags[0] ) ) {
				$custom_table = get_field_object( 'tags_recommended_fields_rating', 'term_' . get_field( 'tags_rating_inherit', 'term_' . $er_tags[0] ) );
			} else {
				$custom_table = get_field_object( 'tags_recommended_fields_rating', 'term_' . $er_tags[0] );
			}
		} else {
			$custom_table = get_field_object( 'tags_recommended_fields', 'term_' . $er_tags[0] );
		}
		if ( ! empty( $custom_table['value'] ) ) {

			$th    = array();
			$row   = array();
			$i     = 0;
			$total = count( $custom_table['value'] );
			foreach ( $custom_table['value'] as $td ) {
				if ( $td['hideme_short'] && $er_tags[4] == 'short' ) {
					continue;
				}
				$i ++;
				$th_item = array();
				$td_item = array();
				// echo '<pre>';
				//print_r($td);
				//echo '<pre>';
				$td_id = $td['td'];
				//echo $td['td']['value'];
				if ( $td['td_name'] != '' ) {
					$th_item['value'] = $td['td_name'];
				} else {
					$th_item['value'] = $td['td']['label'];
				}
				if ( $td['sort'] ) {
					$th_item['sort'] = $td['sort'];
				}
				$td_item['value'] = $td['td'];
				if ( $td['button_text'] != '' && in_array( $td['td']['value'], array(
						'link_visit',
						'link_review'
					) ) ) {
					$td_item['button_text'] = $td['button_text'];
				}
				if ( $td['review_link'] != '' && in_array( $td['td']['value'], array( 'link_visit' ) ) ) {
					$td_item['review_link'] = $td['review_link'];
				}
				if ( $td['hideme'] == true ) {
					$hideme = ' hideme1';
				} else {
					$hideme = '';
				}
				if ( $i == '1' ) {
					$th_item['class'] = 'item_first' . $hideme;
					$td_item['class'] = 'item_first' . $hideme;
				} elseif ( $i == '2' && ! $er_tags[4] ) {
					$th_item['class'] = 'item_' . $i . $hideme;
					$td_item['class'] = 'item_' . $i . ' blueh' . $hideme;
				} elseif ( $i == $total ) {
					$th_item['class'] = 'item_last bright' . $hideme;
					$td_item['class'] = 'item_last bright' . $hideme;
				} else {
					$th_item['class'] = 'item_' . $i . $hideme;
					$td_item['class'] = 'item_' . $i . $hideme;
				}
				if ( $td['information_fields'] ) {
					$td_item['information_fields'] = $td['information_fields'];
				}
				if ( $td['date_name'] ) {
					$td_item['date_name'] = $td['date_name'];
				}
				if ( $td['width'] != '' ) {
					$th_item['width'] = $td['width'];
				}


				$th[]  = $th_item;
				$row[] = $td_item;
			}


		} else {


			if ( $er_tags[4] ) {
				$th  = array(
					array(
						'value' => 'Компания',
						'class' => 'item_first'
					),
					array(
						'value' => 'Информация',
						'class' => 'item_2'
					),
					array(
						'value' => 'Бонусы',
						'class' => 'item_3 hideme1'
					),
					array(
						'value' => 'Регистрация',
						'class' => 'item_last bright'
					),
				);
				$row = array(
					array(
						'value' => array(
							'value' => 'name',
							'label' => 'Компания'
						),
						'class' => 'item_first'
					),
					array(
						'value' => array(
							'value' => 'information',
							'label' => 'Информмация'
						),
						'class' => 'item_2'
					),
					array(
						'value' => array(
							'value' => 'bonus',
							'label' => 'Бонусы'
						),
						'class' => 'item_3'
					),
					array(
						'value'       => array(
							'value' => 'link_visit',
							'label' => 'Регистрация'
						),
						'button_text' => 'Перейти',
						'class'       => 'item_last bright'
					),
				);
			} else {
				$th  = array(
					array(
						'value' => 'Компания',
						'class' => 'item_first'
					),
					array(
						'value' => 'Бонусы',
						'class' => 'item_2'
					),
					array(
						'value' => 'Обзор',
						'class' => 'item_3 hideme1'
					),
					array(
						'value' => 'Регистрация',
						'class' => 'item_last bright'
					),
				);
				$row = array(
					array(
						'value' => array(
							'value' => 'name',
							'label' => 'Компания'
						),
						'class' => 'item_first'
					),
					array(
						'value' => array(
							'value' => 'bonus',
							'label' => 'Бонусы'
						),
						'class' => 'item_2 blueh'
					),
					array(
						'value' => array(
							'value' => 'link_review',
							'label' => 'Обзор'
						),
						'class' => 'item_3 hideme1'
					),
					array(
						'value'       => array(
							'value' => 'link_visit',
							'label' => 'Регистрация'
						),
						'button_text' => 'Перейти',
						'class'       => 'item_last bright'
					),
				);
			}
		}


		$table_head = '';
		foreach ( $th as $item ) {
			//print_r($item);
			if ( ! $item['sort'] ) {
				$sort = ' sorter-false';
			} else {
				$sort = '';
			}
			$table_head .= '<th class="' . $item['class'] . $sort . '">';
			$table_head .= $item['value'];
			$table_head .= '</th>';
		}
		if ( $er_tags[4] ) {
			//print_r($er_tags);
			if ( ! isset( $_REQUEST['search_submit_company'] ) ) {
				//print_r($_REQUEST);
				if ( $er_tags[6] == 1 ) {
					// $result .= loop_search_er($er_tags[5], false,'');
					//$result .= '<div id="new_table_search"></div>';
				}
			}
			//$result .= '<script src="'.get_bloginfo('template_url').'/js/jquery.tablesorter.js"></script>';
			//$result .= '<script>';
			//$result .= 'jQuery(document).ready(function($){';
			//$result .= '$(".sortable_table").tablesorter();';
			//$result .= '$(".er_search_box").appendTo("#new_table_search");';
			//$result .= '});';
			//$result .= '</script>';
			if ( ! $autoload_layout || $autoload_layout != 'autoload' ) {
				$result .= '<div class="tablewrapper"><div class="tablewrapper-ins"><table cellpadding="3"  cellspacing="0" class="comptable er_newtable renewed sortable_table full_table ratetable-' . get_the_id() . '" align="center" id="table_' . $er_tags[5] . '">';
			}
		} else {
			if ( ! $autoload_layout || $autoload_layout != 'autoload' ) {
				$result .= '<table cellpadding="3" cellspacing="0" class="comptable er_newtable renewed ratetable-' . get_the_id() . '" align="center">';
			}
		}
		if ( ! $autoload_layout || $autoload_layout != 'autoload' ) {
			$result .= '<thead><tr>';
			$result .= $table_head;
			$result .= '</tr></thead>';
		}
		if ( $offset && $offset != '' ) {
			$x = $offset;
		} else {
			$x = 0;
		}
		$bbbi = 0;
		while ( $er_posts->have_posts() ) {
			$er_posts->the_post();
			if ( in_array( get_the_ID(), explode( ",", $post__not_in ) ) ) {
				$bbbi = ++ $bbbi;
			} else {

				$x ++;
				$the_field = '';
				if ( $x % 2 == 0 ) {
					$oddeven = 'even';
				} else {
					$oddeven = 'odd';
				}
				$result .= '<tr id="row_' . $x . '" class="' . $oddeven . '" data-id="' . get_the_ID() . '">';
				foreach ( $row as $item ) {

					if ( $er_tags[4] && $item['value']['value'] == 'information' ) {

						$information_class = ' company_info';
					} else {
						$information_class = '';
					}
					$result .= '<td class="' . $item['class'] . $information_class . ' ' . $item['value']['value'] . '">';
					if ( $item['value']['value'] == 'information' ) {
						//echo '<pre>';
						//print_r($item);
						//echo '</pre>';
						if ( $item['information_fields'] ) {
							foreach ( $item['information_fields'] as $it ) {
								if ( information_field( $it['value'], get_the_ID() ) ) {
									$result .= '<div>' . $it['label'] . ': <strong>';
									$result .= information_field( $it['value'], get_the_ID() );
									$result .= '</strong></div>';
								}
							}
						}
					} elseif ( $item['value']['value'] == 'name' && $er_tags[4] ) {

						$result .= '<div class="er_order_number">' . $x . '</div>';

						$item['value']['value'] = 'name_full';
						$result                 .= brokers_field_new( $item, get_the_ID(), $the_field );
						//print_r(get_post_custom());
					} else {
						$result .= brokers_field_new( $item, get_the_ID(), $the_field );
					}
					$result .= '</td>';
				}
				$result .= '</tr>';
			}

		}
		if ( ! $autoload_layout || $autoload_layout != 'autoload' ) {
			if ( $er_tags[4] ) {
				$result .= '</table><div class="navtab"></div></div></div>';
			} else {
				$result .= '</table>';
			}
		}

	}
	wp_reset_postdata();

	return $result;
}

function brokers_field_new( $item, $post_id, $the_field ) {
	$result   = '';
	$yes      = __( 'Да', 'sa_theme' );
	$no       = __( 'Нет', 'sa_theme' );
	$na       = __( 'N/A', 'sa_theme' );
	$free     = __( 'Бесплатно', 'sa_theme' );
	$field_id = $item['value']['value'];
	//$result .= $field_id.'<br />';

	if ( $field_id == 'link_review' ) {
		if ( $item['button_text'] ) {
			$text = $item['button_text'];
		} else {
			$text = __( 'Обзор', 'sa_theme' );
		}
		$link   = get_the_permalink( $post_id );
		$result .= '<a href="' . $link . '">' . $text . '</a>';
	} elseif ( $field_id == 'system_count_reviews' ) {
		$value = get_field( 'reviews_count_reviews', $post_id );
		if ( ! $value || $value == '' ) {
			$value = 0;
		}
		$result .= '<span class="color_dark_blue">' . $value . '</span> <span class="color_dark_gray">' . counted_text( $value, __( 'отзыв', 'er_theme' ), __( 'отзыва', 'er_theme' ), __( 'отзывов', 'er_theme' ) ) . '</span>';

	} elseif ( $field_id == 'system_count_good' ) {
		$value = get_field( 'reviews_count_good', $post_id );
		if ( ! $value || $value == '' ) {
			$value = 0;
		}
		$result .= '<span class="color_green font_bold">+' . $value . '</span>';

	} elseif ( $field_id == 'system_count_bad' ) {
		$value = get_field( 'reviews_count_bad', $post_id );
		if ( ! $value || $value == '' ) {
			$value = 0;
		}
		$result .= '<span class="color_red font_bold">-' . $value . '</span>';

	} elseif ( $field_id == 'system_count_percents' ) {
		$value_good = get_field( 'reviews_count_good_percent', $post_id );
		if ( ! $value_good || $value_good == '' ) {
			$value_good = 0;
		}
		$value_bad = get_field( 'reviews_count_bad_percent', $post_id );
		if ( ! $value_bad || $value_bad == '' ) {
			$value_bad = 0;
		}
		$result .= '<span class="font_bold icon_rating_good">' . number_format( $value_good, 0, '.', '' ) . '%</span><span class="font_bold icon_rating_bad">' . number_format( $value_bad, 0, '.', '' ) . '%</span>';

	} elseif ( $field_id == 'system_rating' ) {
		$system_rating = get_field( 'reviews_rating_average', $post_id );
		if ( ! $system_rating || $system_rating == '' ) {
			$system_rating = 0;
		}
		$data_percent = 100 / 5 * $system_rating / 100;
		$result       .= '<div class="rating_page_text review_average_round progress" id="rating_list_item_' . $post_id . '" data-percent="' . $data_percent . '">';
		$result       .= '<span class="inner color_dark_blue font_bold font_big">' . number_format( $system_rating, 1, '.', '' ) . '</span>';
		$result       .= '</div>';

	} elseif ( $field_id == 'system_type' ) {

		$result .= $field_id;

	} elseif ( $field_id == 'name' ) {


		$company_name = get_field( 'company_name', $post_id );
		$result       .= review_logo( $post_id );
		$result       .= '<div class="company_title line_big">';
		$company_link = get_the_permalink( $post_id );
		$company_name = get_field( 'company_name', $post_id );
		if($tag == 'bloggers') {
			$company_link_text = __( 'Отзывы о блогере', 'er_theme' );
		} else {
			$company_link_text = __( 'Отзывы о компании', 'er_theme' );
		}
		$result       .= '<a href="' . $company_link . '" class="link_no_underline company_name font_bold font_new_medium color_dark_blue m_b_10" title="' . $company_link_text . ' ' . $company_name . '">' . $company_name . '</a>';
		$result       .= '<div class="rating_table_link_more pointer dropdown flex color_dark_gray">' . __( 'Подробнее', 'er_theme' ) . '</div>';
		$result       .= '</div>';

	} elseif ( $field_id == 'name_full' ) {
		$logo = get_field( 'company_icon', $post_id )['url'];
		if ( ! $logo ) {
			$logo = get_field( 'company_logo', $post_id )['url'];
		}
		$company_name          = get_field( 'company_name', $post_id );
		$link                  = get_bloginfo( 'url' ) . '/visit/' . get_field( 'company_redirect_key', $post_id ) . '/';
		$company_link          = get_the_permalink( $post_id );
		$er_company_site_str   = get_field( 'websites', $post_id )[0]['site_url'];
		$er_company_site_str_2 = preg_replace( '#^[^:/.]*[:/]+#i', '', $er_company_site_str );
		$site                  = preg_replace( '/^www\./', '', rtrim( $er_company_site_str_2, '/' ) );
		$established           = get_field( 'company_established', $post_id );

		$result .= '<div class="er_company_name_img"><a class="er_table_title_link" href="' . $company_link . '" style="background-image:url(' . $logo . ')" rel="nofollow"></a></div>';
		if ( $company_name || $site ) {
			$result .= '<div class="er_table_name_site">';
			if ( $company_name ) {
				$result .= '<a class="er_table_title_name" href="' . $company_link . '" >' . $company_name . '</a>';
			}
			if ( $site ) {
				$result .= '<div class="er_table_title_site">';
				$result .= '<a href="' . $link . '" target="_blank" rel="nofollow">' . $site . '</a>';
				$result .= '</div>';
			}
			$result .= '</div>';
		}
	} elseif ( $field_id == 'bonus' ) {
		$item = get_field_object( 'base_2_bonuses', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $no;
		}

	} elseif ( $field_id == 'api' ) {
		$item = get_field_object( 'api_integration', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}

	} elseif ( $field_id == 'min_dep' ) {
		$item         = get_field_object( 'min_dep', $post_id );
		$result_print = repeater_fields( $item, 'rating' );
		if ( $result_print && $result_print != '<div class="repeater_field repeater_fromto item_single min_dep">N/A</div>' ) {
			$result .= $result_print;
		} else {
			$result .= __( 'От', 'er_theme' ) . ' 1 USD';
		}

	} elseif ( $field_id == 'pros' ) {
		$item = get_field_object( 'pros', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}

	} elseif ( $field_id == 'card_price_issue' ) {
		$item = get_field_object( 'card_issue_price', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}

	} elseif ( $field_id == 'spreads' ) {
		$item = get_field_object( 'base_2_spreads', $post_id );
		if ( simple_field( $item['type'], $item, 'rating' ) ) {
			$result .= simple_field( $item['type'], $item, 'rating' );
		} else {
			$result .= $na;
		}

	} elseif ( $field_id == 'loan_sum' ) {
		$item = get_field_object( 'loan_max', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'loan_term' ) {
		$item = get_field_object( 'loan_length', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'lending_rate' ) {
		$item = get_field_object( 'loan_rate', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'credit_sum' ) {
		$item = get_field_object( 'loan_sum', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'credit_percent' ) {
		$item = get_field_object( 'percent_on_loan', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}

	} elseif ( $field_id == 'card_cashback' ) {
		$item = get_field_object( 'cashback', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}

	} elseif ( $field_id == 'commission_aquiring' ) {
		$item = get_field_object( 'aquiring_commission', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'money_trransfer' ) {
		$item = get_field_object( 'money_transfer_speed', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'connect_cost' ) {
		$item = get_field_object( 'account_opening_price', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'open_account_cost' ) {
		$item = get_field_object( 'account_opening_price', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}

	} elseif ( $field_id == 'card_percent_capital' ) {
		$item = get_field_object( 'percent_on_capital', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}

	} elseif ( $field_id == 'orders_proceed_speed' ) {
		$item = get_field_object( 'application_processing_speed', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'credit_term' ) {
		$item = get_field_object( 'loan_length_credit', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'monthly_payment' ) {
		$item = get_field_object( 'minimum_monthly_payment_card', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'credit_light_term' ) {
		$item = get_field_object( 'grace_period', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}

	} elseif ( $field_id == 'transaction_speed' ) {
		$item = get_field_object( 'card_transfer_speed', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}

	} elseif ( $field_id == 'actives' ) {
		$item = get_field_object( 'count_assets', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'insurance_programms' ) {
		$item = get_field_object( 'count_insurance_programms', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'fiat' ) {
		$item = get_field_object( 'exchange_for_fiat_currencies', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}

	} elseif ( $field_id == 'project_features' ) {
		$item = get_field_object( 'project_details', $post_id );
		if ( simple_field( $item['type'], $item, 'rating' ) ) {
			$result .= simple_field( $item['type'], $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'courses_categories' ) {
		$item = get_field_object( 'cources_categories', $post_id );
		if ( simple_field( $item['type'], $item, 'rating' ) ) {
			$result .= simple_field( $item['type'], $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'earn_methods' ) {
		$item = get_field_object( 'earn_methods', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'services_plus' ) {
		$item = get_field_object( 'services_plus', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}

	} elseif ( $field_id == 'services' ) {
		$item = get_field_object( 'services', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}

	} elseif ( $field_id == 'rating' ) {
		$item = get_field_object( 'total_score', $post_id );
		if ( simple_field( $item['type'], $item, 'rating' ) ) {
			$result .= simple_field( $item['type'], $item, 'rating' );
		} else {
			$result .= $na;
		}

	} elseif ( $field_id == 'address' ) {

	} elseif ( $field_id == 'age' ) {
		$item = get_field_object( 'age_restrictions', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'delivery_hours' ) {
		$item = get_field_object( 'company_hours_delivery', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'min_order' ) {
		$item = get_field_object( 'delivery_min_order', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'deposit_term' ) {
		$item = get_field_object( 'invest_work_terms', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}

	} elseif ( $field_id == 'payout_term' ) {
		$item = get_field_object( 'payout_terms', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'storage' ) {
		$item   = get_field_object( 'safe_term', $post_id );
		$result .= repeater_fields( $item, 'rating' );
		$item2  = get_field_object( 'safe_rules', $post_id );
		$result .= simple_field( $item2['type'], $item2, 'rating' );
	} elseif ( $field_id == 'application_processing' ) {
		$item = get_field_object( 'application_processing_speed', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'exchange_directions' ) {
		$item = get_field_object( 'number_of_exchange_directions', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'bet_points' ) {
		$item = get_field_object( 'bet_points_count', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'deposit_limit' ) {
		$item = get_field_object( 'income_min_limit', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'withdrawal_limit' ) {
		$item = get_field_object( 'outcome_max_limit', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'sales_ammount' ) {
		$item = get_field_object( 'trading_volume_day', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'registered_capital' ) {
		$item = get_field_object( 'registered_сapital', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'base_2_mobile_version' ) {
		$item = get_field_object( 'base_2_mobile_version', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'payout' ) {
		$item = get_field_object( 'payouts', $post_id );
		if ( repeater_fields( $item, 'rating' ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} else {
			$result .= $na;
		}
	} elseif ( $field_id == 'link_visit' ) {
		if ( $item['button_text'] ) {
			$text = $item['button_text'];
		} else {
			$text = __( 'Перейти', 'sa_theme' );
		}
		if ( wp_is_mobile() ) {
			//$bonuses = get_field_object('base_2_bonuses',$post_id);
			//$result .= repeater_fields($bonuses,'rating');
		}
		$link   = get_bloginfo( 'url' ) . '/visit/' . get_field( 'company_redirect_key', $post_id ) . '/';
		$result .= '<a href="' . $link . '" target="_blank" rel="nofollow" class="visit">' . $text . '</a>';
		/* if($item['review_link']) {
			 $result .= '<a href="'.get_the_permalink($post_id).'" target="_blank" rel="nofollow">'.__('Обзор','er_theme').'</a>';
		 }*/


	} else {
		$item = get_field_object( $field_id, $post_id );
		if ( in_array( $item['type'], array( 'repeater' ) ) ) {
			if ( repeater_fields( $item, 'rating' ) ) {
				$result .= repeater_fields( $item, 'rating' );
			} else {
				$result .= $na;
			}
		} elseif ( in_array( $item['type'], array( 'taxonomy', 'date_picker', 'text', 'textarea', 'range' ) ) ) {
			if ( simple_field( $item['type'], $item, 'rating' ) ) {
				$result .= simple_field( $item['type'], $item, 'rating' );
			} else {
				$result .= $na;
			}
		}
	}

	return $result;
}

function information_field( $field_id, $post_id ) {
	$result = '';
	//$result .= $field_id.' '.$post_id;
	if ( $field_id == 'orders' ) {
		$item   = get_field_object( 'order_types_list', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'liquidity' ) {
		$item   = get_field_object( 'liquidity_providers_list', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'terminals' ) {
		$item   = get_field_object( 'terminals_list', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'main_office' ) {
		$item   = get_field_object( 'company_main_office', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'languages' ) {
		$item   = get_field_object( 'languages_list', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'game_publisher' ) {
		$item   = get_field_object( 'game_publisher', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'owner' ) {
		$item   = get_field_object( 'company_owner', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'main_office_manufacturer' ) {
		$item   = get_field_object( 'company_main_office_manufacturer', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'wmid' ) {
		if ( get_field( 'webmoney_wmid', $post_id ) ) {
			$item = get_field_object( 'webmoney_wmid', $post_id );

			$result .= simple_field( $item['type'], $item, 'rating' );
		}
	} elseif ( $field_id == 'bl' ) {
		if ( get_field( 'webmoney_bl', $post_id ) ) {
			$item   = get_field_object( 'webmoney_bl', $post_id );
			$result .= simple_field( $item['type'], $item, 'rating' );
		}
	} elseif ( $field_id == 'delivery_features' ) {
		$item   = get_field_object( 'delivery_details', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'stocks' ) {
		$item   = get_field_object( 'fonds_list', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'regions' ) {
		$item   = get_field_object( 'project_regions', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'project_features' ) {
		$item   = get_field_object( 'project_details', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'reestr_number' ) {
		$item   = get_field_object( 'register_number', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'card_type' ) {
		$item   = get_field_object( 'cardd_type', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'game_genre' ) {
		$item   = get_field_object( 'game_genre', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'game_type' ) {
		$item   = get_field_object( 'game_type', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'option_types' ) {
		$item   = get_field_object( 'option_types_list', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'kitchen_types' ) {
		$item   = get_field_object( 'kitchen_types', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'accept_orders' ) {
		$item   = get_field_object( 'accept_applications', $post_id );
		$result .= repeater_fields( $item, 'rating' );
	} elseif ( $field_id == 'ibank' ) {
		$item   = get_field_object( 'online_banking', $post_id );
		$result .= repeater_fields( $item, 'rating' );
	} elseif ( $field_id == 'pay_by_phone' ) {
		$item   = get_field_object( 'pay_by_phone', $post_id );
		$result .= repeater_fields( $item, 'rating' );
	} elseif ( $field_id == 'free_delivery_terms' ) {
		$item   = get_field_object( 'delivery_free_terms', $post_id );
		$result .= repeater_fields( $item, 'rating_info_fromto' );
	} elseif ( $field_id == 'age' ) {
		$item   = get_field_object( 'age_restrictions', $post_id );
		$result .= repeater_fields( $item, 'rating' );
	} elseif ( $field_id == 'first_loan' ) {
		$item   = get_field_object( 'loan_first', $post_id );
		$result .= repeater_fields( $item, 'rating' );
	} elseif ( $field_id == 'docs' ) {
		$item   = get_field_object( 'documents_list', $post_id );
		$result .= repeater_fields( $item, 'rating' );
	} elseif ( $field_id == 'issue' ) {
		$item   = get_field_object( 'account_opening_price', $post_id );
		$result .= repeater_fields( $item, 'rating' );
	} elseif ( $field_id == 'forbusiness_loans' ) {
		$item   = get_field_object( 'business_loans', $post_id );
		$result .= repeater_fields( $item, 'rating' );
	} elseif ( $field_id == 'reissue' ) {
		$item   = get_field_object( 'card_reissue_price', $post_id );
		$result .= repeater_fields( $item, 'rating' );
	} elseif ( $field_id == 'insurance' ) {
		$item   = get_field_object( 'loan_insurance', $post_id );
		$result .= repeater_fields( $item, 'rating' );
	} elseif ( $field_id == 'cryptocurrencies' ) {
		$item   = get_field_object( 'number_of_cryptocurrencies', $post_id );
		$result .= repeater_fields( $item, 'rating' );
	} elseif ( $field_id == 'support' ) {
		$item   = get_field_object( 'base_2_support', $post_id );
		$result .= repeater_fields( $item, 'rating' );
	} elseif ( $field_id == 'licenses' ) {
		$item   = get_field_object( 'base_2_licenses', $post_id );
		$result .= repeater_fields( $item, 'rating' );
	} elseif ( $field_id == 'laws' ) {
		$item   = get_field_object( 'controllers_laws', $post_id );
		$result .= repeater_fields( $item, 'rating' );
	} elseif ( $field_id == 'demo' ) {
		$item   = get_field_object( 'free_demo', $post_id );
		$result .= repeater_fields( $item, 'rating', $post_id );
	} elseif ( $field_id == 'partners' ) {
		$item   = get_field_object( 'affiliate_program', $post_id );
		$result .= repeater_fields( $item, 'rating_yes_link' );
	} elseif ( $field_id == 'owner' ) {
		$item   = get_field_object( 'company_owner', $post_id );
		$result .= simple_field( $item['type'], $item, 'rating' );
	} elseif ( $field_id == 'regulators' ) {
		$item   = get_field_object( 'regulators_list', $post_id );
		$result .= repeater_fields( $item, 'rating' );
	} else {
		$item = get_field_object( $field_id, $post_id );
		if ( in_array( $item['type'], array( 'repeater' ) ) ) {
			$result .= repeater_fields( $item, 'rating' );
		} elseif ( in_array( $item['type'], array( 'taxonomy', 'date_picker', 'text', 'textarea', 'range' ) ) ) {
			$result .= simple_field( $item['type'], $item, 'rating' );
		}
	}

	return $result;
}

?>