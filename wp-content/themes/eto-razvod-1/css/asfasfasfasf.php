<?php
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
	$b = 0;
	if ( $er_tags[7] && $er_tags[8] ) {
		$b = 1;
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
	$a =  0;
	
	
	
	
	$autoload_layout = $er_tags[9];
	$offset          = $er_tags[10];
	if ( $offset && $offset != '' ) {
		$args['offset'] = $offset;
	}
	
	$total_args = $args;
	$total_args['posts_per_page'] = -1;
	//print_r($args);
	$current_language = get_locale();
	if ( $current_language != 'ru_RU' ) {
		$args['posts_per_page'] = $args['posts_per_page'] + 10;
	}
	if ($er_tag[0] == 26) {
		if (get_field('region_new',$er_tags[9])[0] == 7573 || get_field('region_new',$er_tags[9])[0] == 7663 ) {
			$a = 1;
			//$args['posts_per_page'] = 1;
			$args['meta_query'][] = array(
				'key'     => 'region_new',
				'value'   => get_field('region_new',$er_tags[9])[0],
				'compare' => 'LIKE',
			);
		}
		
	}
	$er_posts = new WP_Query( $args );
	
	/*$current_language = get_locale();
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
					'field'    => 'id',
					'terms'    => $er_tag,
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
			$lastend = end($er_posts->posts)->menu_order;
			
			foreach ( $reviews2->posts as $item ) {
				
				$i = 0;
				foreach ( $er_posts->posts as $key => $item2 ) {
					
					if ( $item2->ID == $item->ID ) {
						$i = 1;
						$er_posts->posts[ $key ]->menu_order = get_field( 'languages_'.strtolower($current_language).'_sorting', $item->ID );
					}
				}
				
				if ($lastend > get_field( 'languages_'.strtolower($current_language).'_sorting', $item->ID ) && $i == 0) {
					$item->menu_order = get_field( 'languages_'.strtolower($current_language).'_sorting', $item->ID );
					$er_posts->posts[] = $item;
				}
				
				$menu_order = [];
				foreach ( $er_posts->posts as $key => $row ) {
					$menu_order[ $key ] = $row->menu_order;
				}
			}
			
			
			
			
			array_multisort( $menu_order, SORT_ASC, $er_posts->posts );
		}
	}*/
	
	
	
	
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
					'field'    => 'id',
					'terms'    => $er_tag,
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
			$lastend = end($er_posts->posts)->menu_order;
			
			foreach ( $reviews2->posts as $item ) {
				
				$i = 0;
				//$item->menu_order = get_field('languages_'.strtolower($current_language).'_sort',$item->ID);
				foreach ( $er_posts->posts as $key => $item2 ) {
					
					if ( $item2->ID == $item->ID ) {
						$i = 1;
						/*unset($query_reviews->posts[$key]);
						$query_reviews->posts[$key] = $item;*/
						$er_posts->posts[ $key ]->menu_order = get_field( 'languages_'.strtolower($current_language).'_sorting', $item->ID );
					}
				}
				
				if ($lastend > get_field( 'languages_'.strtolower($current_language).'_sorting', $item->ID ) && $i == 0) {
					$item->menu_order = get_field( 'languages_'.strtolower($current_language).'_sorting', $item->ID );
					$er_posts->posts[] = $item;
				}
				
				$menu_order = [];
				foreach ( $er_posts->posts as $key => $row ) {
					$menu_order[ $key ] = $row->menu_order;
				}
			}
			
			
			
			
			array_multisort( $menu_order, SORT_ASC, $er_posts->posts );
			
		}
		$er_posts->posts  = array_slice($er_posts->posts, 0, 5);
	}
	
	if (is_user_logged_in()) {
		//print_r($er_posts->posts);
	}
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
		print_r($custom_table['value']);
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
				/*$th  = array(
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
				);*/
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
						'class' => 'item_2'
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
				
				/*array(
					'value' => array(
						'value' => 'information',
						'label' => 'Информмация'
					),
					'class' => 'item_2'
				),*/
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
				
				$result .= '<div count="'.$er_tags[9].' '.count($er_tags).'" c="'.$a.$b.'" class="tablewrapper idclass'.$er_tags[9].'"><div class="tablewrapper-ins"><table cellpadding="3"  cellspacing="0" class="comptable er_newtable renewed sortable_table full_table ratetable-' . get_the_id() . '" align="center" id="table_' . $er_tags[5] . '">';
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
						$result                 .= brokers_field_new( $item, get_the_ID(), $the_field, 0, $er_tags[9] );
						//print_r(get_post_custom());
					} else {
						$result .= brokers_field_new( $item, get_the_ID(), $the_field, 0, $er_tags[9] );
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