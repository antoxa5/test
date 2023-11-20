<?php
if (!function_exists('resort_show_search_category_results')) {
	add_action( 'wp_ajax_resort_show_search_category_results', 'resort_show_search_category_results' );
	add_action( 'wp_ajax_nopriv_resort_show_search_category_results', 'resort_show_search_category_results' );
	
	function resort_show_search_category_results(){
		$data = $_POST;
		$term_id = $data['term_id'];
		$key = $data['key'];
		$sort = $data['sort'];
		$search_result_tabs_active = $data['search_result_tabs_active'];
		$result = '';
		//$result .= $term_id.' '.$key.' '.$sort;
		
		if ($search_result_tabs_active == 'posts') {
			$args_posts = array(
				'posts_per_page' => -1,
				'post_type' => array('post', 'addpages', 'page'),
				
				's' => $key,
				'sentence' => true,
				
				'post__not_in' => array(139302, 86973, 77815, 86973, 75091, 132557, 137116, 132567, 75094, 75089, 132579, 132583, 132585, 132597, 132581, 132591, 132589, 132587, 132571, 30322, 170, 132565, 140367, 32829, 128, 9857, 75096, 133173, 132559, 32827, 130, 32916, 86256, 76866, 132569, 132562, 132557, 136964, 99062, 136964, 19540, 98993, 139296, 132573, 98982, 75098, 132576, 139302, 88311, 76861, 81639, 99047),
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key' => '_wp_page_template',
						'compare' => 'NOT EXISTS',
					),
					array(
						'key' => '_wp_page_template',
						'compare' => 'NOT IN',
						'value' => array('template-rating.php', 'template-service.php', 'category.php', 'single-post.php', 'template-landing.php', 'template-news.php', 'template-promocodes.php', 'template-rating-all.php')
					)
				)
			);
			
			if($sort == 'title') {
				$args_posts['order'] = 'ASC';
				$args_posts['orderby'] = 'title';
			} elseif($sort == 'title_reverse') {
				$args_posts['order'] = 'DESC';
				$args_posts['orderby'] = 'title';
			} elseif($sort == 'new') {
				$args_posts['order'] = 'DESC';
				$args_posts['orderby'] = 'date';
			} elseif($sort == 'old') {
				$args_posts['order'] = 'ASC';
				$args_posts['orderby'] = 'date';
			}
			
			$the_query_posts = new WP_Query( $args_posts );
			$found_posts = array();
			if ( $the_query_posts->have_posts() ) {
				while ( $the_query_posts->have_posts() ) {
					$the_query_posts->the_post();
					global $post;
					$found_posts[] = $post->ID;
				}
			}
			wp_reset_postdata();
			//$result .= count($found_posts);
			
			if ( !empty($found_posts) ) {
				$result .= '<ul class="result_tab_content result_posts results_content posts active" data="s2">';
				foreach($found_posts as $post_id) {
					$result .= company_layout_post($post_id);
				}
				$result .= '</ul>';
			}
		} elseif($search_result_tabs_active == 'ratings') {
			$args_ratings = array(
				'posts_per_page' => -1,
				'post_type'=> array('page'),
				'meta_key' => '_wp_page_template',
				'meta_value' => 'template-rating.php',
				's' => $key,
			);
			
			if($sort == 'title') {
				$args_ratings['order'] = 'ASC';
				$args_ratings['orderby'] = 'title';
			} elseif($sort == 'title_reverse') {
				$args_ratings['order'] = 'DESC';
				$args_ratings['orderby'] = 'title';
			} elseif($sort == 'new') {
				$args_ratings['order'] = 'DESC';
				$args_ratings['orderby'] = 'date';
			} elseif($sort == 'old') {
				$args_ratings['order'] = 'ASC';
				$args_ratings['orderby'] = 'date';
			}
			$the_query_rating = new WP_Query( $args_ratings );
			$found_rating = array();
			if ( $the_query_rating->have_posts() ) {
				while ( $the_query_rating->have_posts() ) {
					$the_query_rating->the_post();
					global $post;
					$found_rating[] = $post->ID;
				}
			}
			wp_reset_postdata();
			
			if ( !empty($found_rating) ) {
				$result .= '<div class="result_tab_content result_ratings active" data="s2">';
				foreach($found_rating as $post_id) {
					$result .= rating_layout_single($post_id);
				}
				$result .= '</div>';
				$args_more = array();
			}
		} else {
			$args = array(
				'post_type' => 'casino',
				'posts_per_page' => -1,
				'post_status' => 'publish',
			);
			if($sort == 'title') {
				$args['order'] = 'ASC';
				$args['orderby'] = 'title';
			} elseif($sort == 'title_reverse') {
				$args['order'] = 'DESC';
				$args['orderby'] = 'title';
			} elseif($sort == 'new') {
				$args['order'] = 'DESC';
				$args['orderby'] = 'date';
			} elseif($sort == 'old') {
				$args['order'] = 'ASC';
				$args['orderby'] = 'date';
			}
			if($term_id && $term_id != '' && $term_id != 'undefined') {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field' => 'term_id',
						'terms' => $term_id,
					)
				);
			}
			if($key && $key != '') {
				$prase = $key;
				$args['meta_query']['relation'] = 'OR';
				$args['meta_query'][] = array(
					'key' => 'company_name',
					'value' => $prase,
					'compare' => 'LIKE'
				);
				$prase2 = '';
				if($prase != '') {
					include_once(TEMPLATEPATH .'/inc/get_search.php');
				}
			}
			if($sort == 'title') {
				$args['order'] = 'ASC';
				$args['orderby'] = 'title';
			} elseif($sort == 'title_reverse') {
				$args['order'] = 'DESC';
				$args['orderby'] = 'title';
			} elseif($sort == 'new') {
				$args['order'] = 'DESC';
				$args['orderby'] = 'date';
			} elseif($sort == 'old') {
				$args['order'] = 'ASC';
				$args['orderby'] = 'date';
			}
			$arr_post_temp = [];
			$the_query = new WP_Query( $args );
			$found = array();
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					global $post;
					if (in_array($post->ID, $arr_post_temp)) {
					
					} else {
						$found[] = $post->ID;
					}
					$arr_post_temp[] = $post->ID;
					
				}
			}
			wp_reset_postdata();
			if ( !empty($found) ) {
				$result .= '<ul class="results_content" data="s1">';
				foreach($found as $post_id) {
					$result .= company_layout_single_search_results($post_id);
				}
				$result .= '</ul>';
			} else {
				$result .= '<div class="result_text flex flex_column">';
				$result .= '<div class="not_found text_centered m_b_20 color_black">'.__('Компании не найдены','er_theme').'</div>';
				//$result .= '<a href="/add-company/" class="button pointer button_violet link_no_underline radius_small button_padding_big font_small font_bold button_centered">'.__('Добавить новую компанию','er_theme').'</a>';
				$result .= '</div>';
			}
		}
		
		echo $result;
		die;
	}
}

if(!function_exists('show_search_category_results')) {
	function show_search_category_results($term_id,$key) {
		$result = '';
		if(!$term_id && !$key || iconv_strlen($key) == 1 || $term_id == 'all' && $key == '') {
			$result .= '<div class="main_result" data-main_result="6">';
			$result .= '<div class="result_text flex flex_column">';
			$result .= '<div class="not_found text_centered m_b_20 color_black">'.__('Пожалуйста, введите запрос или выберите рубрику для поиска','er_theme').'</div>';
			//$result .= '<a href=/add-company/ class="button pointer button_violet radius_small button_padding_big font_small font_bold button_centered">'.__('Добавить новую компанию','er_theme').'</div>';
			$result .= '</div>';
			$result .= '</div>';
		} else {

			$curr_lang = get_locale();

			$args = array(
				'post_type' => 'casino',
				'posts_per_page' => -1,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'post_status' => 'publish',
			);
			if($term_id && $term_id != '') {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field' => 'term_id',
						'terms' => $term_id,
					)
				);
			}
			if($key && $key != '') {
				$prase = $key;
				$args['meta_query']['relation'] = 'OR';
				$args['meta_query'][] = array(
					'key' => 'company_name',
					'value' => $prase,
					'compare' => 'LIKE'
				);
				
				$terms_get = get_terms(
					array(
						'taxonomy' => 'affiliate-tags',
						'meta_query' => array(
							array(
								'key'     => 'tag_human_title',
								'value'   => $prase,
								'compare' => '=='
							)
						)
					)
				);
				
				if (count($terms_get) != 0) {
					
					$prase_companytypes = get_term_by('slug', $terms_get[0]->name, 'companytypes');
					
					if (    gettype($prase_companytypes) == 'object'  ) {
						$args['meta_query'][] = array(
							'key' => 'company_type',
							'value' => $prase_companytypes->term_id,
							'compare' => '=='
						);
					}
				}
				
				/*if ($prase == 'курсы программирования') { */
//					$args['meta_query'][] = array(
//						 'taxonomy' => 'affiliate-tags',
//                                    'field'    => 'id',
//                                    'terms'    => array(4652),
//					);
				
				/*}*/
				
				$prase_companytypes = get_term_by('slug', $prase, 'companytypes');
				
				if (    is_array($prase_companytypes)  ) {
					$args['meta_query'][] = array(
						'key' => 'company_type',
						'value' => $prase_companytypes->term_id,
						'compare' => '=='
					);
				}
				/*$args['meta_query'][] = array(
					'key' => 'company_type',
					'value' => 57433,
					'compare' => 'IN'
				);*/
				$prase2 = '';
				if($prase != '') {
					include_once(TEMPLATEPATH .'/inc/get_search.php');
				}
			}
			//print_r($args);

			if( $curr_lang == 'ru_RU' ) {
				// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
				$args['turn_off_on_ru_language'] = 1;
			}


			$the_query = new WP_Query( $args );
			$found = array();
			$found_promocodes = array();
			$found_promocodes['promocodes']['count'] = 0;
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					global $post;
					$found[] = $post->ID;
					
					
					
					
					$company_promo_args = array(
						'posts_per_page' => -1,
						'post_type'=> array('promocodes'),
					
					);
					$company_promo_args['meta_query'][] = array(
						'key' => 'promocode_review',
						'value' => $post->ID,
						'compare' => '='
					);
					$the_query_company_promo_args = new WP_Query( $company_promo_args );
					if ( $the_query_company_promo_args->have_posts() ) {
						while ( $the_query_company_promo_args->have_posts() ) {
							$the_query_company_promo_args->the_post();
							global $post;
							$promocodes = array();
							//echo get_the_title($post->ID);
							$promocodes = get_field('promocodes_items');
							if($promocodes && !empty($promocodes)) {
								$promocodes_count_new = $found_promocodes['promocodes']['count'] + count($promocodes);
								$found_promocodes['promocodes']['count'] = $promocodes_count_new;
								$found_promocodes['promocodes']['posts'][] = $post->ID;
							}
							
						}
					}
					wp_reset_postdata();
				}
			}
			wp_reset_postdata();
			if ( !empty($found) ) {
				$result .= '<div class="main_result" data-main_result="companies">';
				$result .= '<ul class="result_tab_content result_companies results_content active" data="s2">';
				foreach($found as $post_id) {
					$result .= company_layout_single_search_results($post_id);
				}
				$result .= '</ul>';
				$result .= '</div>';
				$args_more = array();
				if(count($found) < 5) {
					$result .= '<div class="result_text flex flex_column result_tab_content_search_page result_companies active">';
					$result .= '<div class="found_text text_centered m_b_20 color_black">'.__('Это все результаты','er_theme').'</div>';
					$result .= '<a href="/add-company/" class="button pointer button_violet link_no_underline radius_small button_padding_big font_small font_bold button_centered">'.__('Добавить новую компанию','er_theme').'</a>';
					$result .= '</div>';
					if($term_id && $term_id != '' && $key && $key != '') {
						//$result .= 'еще по метке и запросу';
						foreach($found as $post_id) {
							$terms_more = get_the_terms( $post_id, 'affiliate-tags' );
							if(!empty($terms_more)) {
								foreach ($terms_more as $term) {
									$terms_more_array[] = $term->term_id;
								}
								
							}
							$args_more = array(
								'post_type' => 'casino',
								'posts_per_page' => 10,
								'orderby' => 'menu_order',
								'order' => 'ASC',
								'post__not_in' => $found,
								'post_status' => 'publish',
							);
							$args_more['tax_query'] = array(
								array(
									'taxonomy' => 'affiliate-tags',
									'field' => 'term_id',
									'terms' => $term_id,
								)
							);
							//print_r($args_more);

							if( $curr_lang == 'ru_RU' ) {
								// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
								$args_more['turn_off_on_ru_language'] = 1;
							}

							$the_query_more = new WP_Query( $args_more );
							if ( $the_query_more->have_posts() ) {
								while ( $the_query_more->have_posts() ) {
									$the_query_more->the_post();
									global $post;
									$found_more[] = $post->ID;
								}
							}
							wp_reset_postdata();
							if ( !empty($found_more) ) {
								$count_more = count($found_more);
								$result .= '<div class="white_block found_more_top flex  result_tab_content_search_page result_companies active">';
								$result .= '<div class="comments_top_title font_uppercase font_bolder color_dark_blue font_smaller_2">'.__('Похожие компании','er_theme').'</div>';
								$result .= '<div class="comments_top_count font_bold color_dark_gray font_small">'.$count_more.'</div>';
								$result .= '<div class="found_more_sorter font_small">';
								$result .= '<div class="comments_sorter_title color_dark_gray pointer dropdown flex">'.__('Отсортировать по','er_theme').'</div>';
								$result .= '</div>';
								$result .= '</div>';
								$result .= '<div class="more_result result_tab_content_search_page result_companies active">';
								$result .= '<ul class="results_content" data="s3">';
								foreach($found_more as $post_id) {
									$result .= company_layout_single_search_results($post_id);
								}
								$result .= '</ul>';
								$result .= '</div>';
							}
							
						}
					} elseif($key && $key != '' && !$term_id || $key && $key != '' && $term_id == '' || $key && $key != '' && $term_id == 'all') {
						//$result .= 'еще по запросу';
						foreach($found as $post_id) {
							$terms_more = get_the_terms( $post_id, 'affiliate-tags' );
							if(!empty($terms_more)) {
								foreach ($terms_more as $term) {
									$terms_more_array[] = $term->term_id;
								}
								
							}
						}
						
						if(!empty($terms_more_array)) {
							$args_more = array(
								'post_type' => 'casino',
								'posts_per_page' => 10,
								'orderby' => 'menu_order',
								'order' => 'ASC',
								'post__not_in' => $found,
								'post_status' => 'publish',
							);
							$args_more['tax_query'] = array(
								array(
									'taxonomy' => 'affiliate-tags',
									'field' => 'term_id',
									'terms' => $terms_more_array,
								)
							);

							if( $curr_lang == 'ru_RU' ) {
								// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
								$args_more['turn_off_on_ru_language'] = 1;
							}

							//print_r($args_more);
							$the_query_more = new WP_Query( $args_more );
							if ( $the_query_more->have_posts() ) {
								while ( $the_query_more->have_posts() ) {
									$the_query_more->the_post();
									global $post;
									$found_more[] = $post->ID;
								}
							}
							wp_reset_postdata();
							if ( !empty($found_more) ) {
								$count_more = count($found_more);
								$result .= '<div class="white_block found_more_top flex result_tab_content_search_page result_companies active">';
								$result .= '<div class="comments_top_title font_uppercase font_bolder color_dark_blue font_smaller_2">'.__('Похожие компании','er_theme').'</div>';
								$result .= '<div class="comments_top_count font_bold color_dark_gray font_small">'.$count_more.'</div>';
								$result .= '<div class="found_more_sorter font_small">';
								$result .= '<div class="comments_sorter_title color_dark_gray pointer dropdown flex">'.__('Отсортировать по','er_theme').'</div>';
								$result .= '</div>';
								$result .= '</div>';
								$result .= '<div class="more_result result_tab_content_search_page result_companies active">';
								$result .= '<ul class="results_content" data="s4">';
								foreach($found_more as $post_id) {
									$result .= company_layout_single_search_results($post_id);
								}
								$result .= '</ul>';
								$result .= '</div>';
							}
						}
					}
				}
			} else {
				$result .= '<div class="main_result" data-main_result="2">';
				$result .= '<div class="result_text flex flex_column">';
				$result .= '<div class="not_found text_centered m_b_20 color_black">'.__('Компании не найдены','er_theme').'</div>';
				$result .= '<a href="/add-company/" class="button pointer button_violet link_no_underline radius_small button_padding_big font_small font_bold button_centered">'.__('Добавить новую компанию','er_theme').'</a>';
				$result .= '</div>';
				$result .= '</div>';
				if($term_id && $term_id != '' && $key && $key != '') {
					//$result .= 'еще по метке и запросу';
					$args_more = array(
						'post_type' => 'casino',
						'posts_per_page' => 10,
						'orderby' => 'menu_order',
						'order' => 'ASC',
						'post__not_in' => $found,
						'post_status' => 'publish',
					);
					$args_more['tax_query'] = array(
						array(
							'taxonomy' => 'affiliate-tags',
							'field' => 'term_id',
							'terms' => $term_id,
						)
					);

					if( $curr_lang == 'ru_RU' ) {
						// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
						$args_more['turn_off_on_ru_language'] = 1;
					}

					//print_r($args_more);
					$the_query_more = new WP_Query( $args_more );
					if ( $the_query_more->have_posts() ) {
						while ( $the_query_more->have_posts() ) {
							$the_query_more->the_post();
							global $post;
							$found_more[] = $post->ID;
						}
					}
					wp_reset_postdata();
					if ( !empty($found_more) ) {
						$count_more = count($found_more);
						$result .= '<div class="white_block found_more_top flex">';
						$result .= '<div class="comments_top_title font_uppercase font_bolder color_dark_blue font_smaller_2">'.__('Похожие компании','er_theme').'</div>';
						$result .= '<div class="comments_top_count font_bold color_dark_gray font_small">'.$count_more.'</div>';
						$result .= '<div class="found_more_sorter font_small">';
						$result .= '<div class="comments_sorter_title color_dark_gray pointer dropdown flex">'.__('Отсортировать по','er_theme').'</div>';
						$result .= '</div>';
						$result .= '</div>';
						$result .= '<div class="more_result">';
						$result .= '<ul class="results_content" data="s5">';
						foreach($found_more as $post_id) {
							$result .= company_layout_single_search_results($post_id);
						}
						$result .= '</ul>';
						$result .= '</div>';
					}
				} else {
					$args_more = array(
						'post_type' => 'casino',
						'posts_per_page' => 100,
						'orderby' => 'menu_order',
						'order' => 'ASC',
						'post__not_in' => $found,
						'post_status' => 'publish',
					);
					$args_more['tax_query'] = array(
						array(
							'taxonomy' => 'affiliate-tags',
							'field' => 'term_id',
							'terms' => array(10,11),
						)
					);

					if( $curr_lang == 'ru_RU' ) {
						// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
						$args_more['turn_off_on_ru_language'] = 1;
					}

					//print_r($args_more);
					$the_query_more = new WP_Query( $args_more );
					
					if ( $the_query_more->have_posts() ) {
						while ( $the_query_more->have_posts() ) {
							$the_query_more->the_post();
							global $post;
							$found_more[] = $post->ID;
						}
					}
					wp_reset_postdata();
					
					if ( !empty($found_more) ) {
						$count_more = count($found_more);
						$result .= '<div class="white_block found_more_top flex">';
						$result .= '<div class="comments_top_title font_uppercase font_bolder color_dark_blue font_smaller_2">'.__('Похожие компании','er_theme').'</div>';
						$result .= '<div class="comments_top_count font_bold color_dark_gray font_small">'.$count_more.'</div>';
						$result .= '<div class="found_more_sorter font_small">';
						$result .= '<div class="comments_sorter_title color_dark_gray pointer dropdown flex">'.__('Отсортировать по','er_theme').'</div>';
						$result .= '</div>';
						$result .= '</div>';
						$result .= '<div class="more_result">';
						$result .= '<ul class="results_content">';
						foreach($found_more as $post_id) {
							$result .= company_layout_single_search_results($post_id);
						}
						$result .= '</ul>';
						$result .= '</div>';
					}
				}
				
			}

			if($curr_lang != 'ru_RU') {
				$args_posts = array(
					'posts_per_page' => -1,
					'post_type' => array('post',  'page'),
					'orderby' => 'title',
					's' => $prase,
					'sentence' => true,
					'order' => 'ASC',
					'meta_query' => array(
						'relation' => 'AND',
						array(
							'key' => 'enable_translations',
							'value' => $curr_lang,
							'compare' => 'LIKE',
						),
						array(
							'key' => '_wp_page_template',
							'compare' => 'NOT IN',
							'value' => array('template-rating.php', 'template-service.php', 'category.php', 'single-post.php', 'template-landing.php', 'template-news.php', 'template-promocodes.php', 'template-rating-all.php')
						)
					)
				);
			} else {
				$args_posts = array(
					'posts_per_page' => -1,
					'post_type' => array('post', 'addpages', 'page'),
					's' => $prase,
					'sentence' => true,
					'post__not_in' => array(139302, 86973, 77815, 86973, 75091, 132557, 137116, 132567, 75094, 75089, 132579, 132583, 132585, 132597, 132581, 132591, 132589, 132587, 132571, 30322, 170, 132565, 140367, 32829, 128, 9857, 75096, 133173, 132559, 32827, 130, 32916, 86256, 76866, 132569, 132562, 132557, 136964, 99062, 136964, 19540, 98993, 139296, 132573, 98982, 75098, 132576, 139302, 88311, 76861, 81639, 99047),
					'meta_query' => array(
						'relation' => 'OR',
						array(
							'key' => '_wp_page_template',
							'compare' => 'NOT EXISTS',
						),
						array(
							'key' => '_wp_page_template',
							'compare' => 'NOT IN',
							'value' => array('template-rating.php', 'template-service.php', 'category.php', 'single-post.php', 'template-landing.php', 'template-news.php', 'template-promocodes.php', 'template-rating-all.php')
						)
					)
				);

				// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
				$args_posts['turn_off_on_ru_language'] = 1;

			}
			$args_posts['order'] = 'ASC';
			$args_posts['orderby'] = 'title';
			$the_query_posts = new WP_Query( $args_posts );
			$found_posts = array();
			if ( $the_query_posts->have_posts() ) {
				while ( $the_query_posts->have_posts() ) {
					$the_query_posts->the_post();
					global $post;
					$found_posts[] = $post->ID;
				}
			}
			wp_reset_postdata();
			//$result .= count($found_posts);
			
			if ( !empty($found_posts) ) {
				$result .= '<div class="main_result" data-main_result="posts">';
				$result .= '<ul class="result_tab_content result_posts results_content posts" data="s2">';
				foreach($found_posts as $post_id) {
					$result .= company_layout_post($post_id);
				}
				$result .= '</ul>';
				$result .= '</div>';
				$args_more = array();
			}
			
			$args_ratings = array(
				'posts_per_page' => -1,
				'post_type'=> array('page'),
				'meta_key' => '_wp_page_template',
				'meta_value' => 'template-rating.php',
				'orderby' => 'title',
				's' => $prase,
				'order' => 'ASC',
			);

			if( $curr_lang == 'ru_RU' ) {
				// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
				$args_ratings['turn_off_on_ru_language'] = 1;
			}

			$the_query_rating = new WP_Query( $args_ratings );
			$found_rating = array();
			if ( $the_query_rating->have_posts() ) {
				while ( $the_query_rating->have_posts() ) {
					$the_query_rating->the_post();
					global $post;
					$found_rating[] = $post->ID;
				}
			}
			wp_reset_postdata();
			
			if ( !empty($found_rating) ) {
				$result .= '<div class="main_result" data-main_result="ratings">';
				$result .= '<div class="result_tab_content result_ratings" data="s2">';
				foreach($found_rating as $post_id) {
					$result .= rating_layout_single($post_id);
				}
				$result .= '</div>';
				$result .= '</div>';
				$args_more = array();
			}
			
			$count_promos = 0;
			$result .= '<div class="result_tab_content result_promocodes" data="s2">';
			foreach($found_promocodes['promocodes']['posts'] as $postt_id) {
				$review_id = get_field('promocode_review',$postt_id);
				$company_name = get_field('company_name',$review_id);
				//$result .= get_the_title($postt_id).'<br />';
				$promocodes = get_field('promocodes_items',$postt_id);
				$y = 0;
				$hour = 12;
				$today              = strtotime($hour . ':00:00');
				$yesterday          = strtotime('-1 day', $today);
				foreach ($promocodes as $item) {
					$y++;
					$date_end_m = strtotime($item['date_end']);
					if(($date_end_m < $yesterday && !empty($item['date_end']) && $item['date_end'] != 'None') || ($item['hide_promos'] == 'yes')) {
					
					} else {
						$count_promos = ++$count_promos;
						if($item['text'] != '' && $item['text'] != 'Не нужен') {
							$border = 'border_green';
						} else {
							$border = 'border_biolet';
						}
						if($y > 9) {
							$hidden_default = ' hidden';
						} else {
							$hidden_default = '';
						}
						
						$terms = get_the_terms($review_id,'affiliate-tags');
						
						
						$result .= '<li class="white_block flex '.$border.''.$hidden_default.'" id="single_promocodes_'.$postt_id.'_'.$y.'" data-tags="'.$terms[0]->term_id.'">';
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
						if($item['discount_currency'] && $item['discount_currency'] == '%') {
							$faq_discounts[] = array('x' => $item['discount_size'],'y' => $item['discount_currency']);
							
						}
						if ($y < 4) {
							
							$faq_discount_titles .= $item['title'].', ';
						}
						$result .='<div class="promocode_block_content flex">';
						$result .= '<div class="promocode_list_single_left">';
						$result .= review_logo($review_id);
						$terms = get_term(get_field('promocode_taxonomy',$postt_id),'affiliate-tags')->slug;
						$result .= '<div class="promocode_item_title color_dark_blue link_no_underline font_bold">'.$company_name.'</div>';
						
						
						$result .='</div>';
						$result .= '<div class="promocode_list_single_right">';
						if($item['title'] != '') {
							$result .= '<div class="promo_title color_dark_blue font_18 font_bold">' . $item['title'] . '</div>';
						}
						
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
						$result .= '<span class="promo_used font_bold font_smaller color_dark_blue">'.$count_used.' '.counted_text($count_used,__('использует','er_theme'),__('используют','er_theme'),__('используют','er_theme')).'</span>';
						$result .='</div>';
						$result .='</div>';
						$result .= '<div class="promocode_list_single_right_right">';
						
						if($size != '') {
							$result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size">' . $size . '</div>';
						} else {
							$result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size_text">' . $item_type . '</div>';
						}
						
						
						$result .= '<div class="promocode_button_container">';
						if($item['text'] != '' && $item['text'] != 'Не нужен') {
							$result .= '<div class="promocode_text_container">';
							$result .= '<div class="promocode_single_text" id="promocode_text_'.$postt_id.'_'.$y.'">'.$item['text'].'</div>';
							$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$postt_id.'-'.$y.'/" target="_blank" rel="nofollow">'.__('Получить','er_theme').'</a>';
							$result .= '<div class="link_promocode_text_copy button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Скопировать','er_theme').'</div>';
							$result .= '</div>';
							$result .= '<div class="link_promocode_show_more_text_popup button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Показать код','er_theme').'</div>';
						} else {
							$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$postt_id.'-'.$y.'/" target="_blank" rel="nofollow">'.__('Получить','er_theme').'</a>';
						}
						$result .='</div>';
						
						
						$result .= '</div>';
						$result .='</div>';
						
						
						$result .= '</li>';
					}
				}
			}
			$result .= '</div>';
			
			$result .= '<ul class="search_result_tabs"><li class="tab_companies active" data-id="companies">Компании<span> | '.count($found).'</span></li><li class="tab_posts inactive" data-id="posts">Новости<span> | '.count($found_posts).'</span></li><li class="tab_ratings inactive" data-id="ratings">Рейтинги<span> | '.count($found_rating).'</span></li><li class="tab_promocodes inactive" data-id="promocodes">Промокоды<span> | '.$count_promos.'</span></li></ul>';
			/*$args_promocodes = array(
				'posts_per_page' => -1,
				'post_type'=> array('promocodes'),
				'orderby' => 'title',
				's' => $prase,
				'order' => 'ASC',

			);
			$the_query_promocodes = new WP_Query( $args_promocodes );*/
			
			/*$the_query_rating = new WP_Query( $args_ratings );
			$found_rating = array();
			if ( $the_query_rating->have_posts() ) {
				while ( $the_query_rating->have_posts() ) {
					$the_query_rating->the_post();
					global $post;
					$found_rating[] = $post->ID;
				}
			}
			wp_reset_postdata();

			if ( !empty($found_rating) ) {
				$result .= '<div class="main_result">';
				$result .= '<div class="result_tab_content result_ratings" data="s2">';
				foreach($found_rating as $post_id) {
					$result .= rating_layout_single($post_id);
				}
				$result .= '</div>';
				$result .= '</div>';
				$args_more = array();
			}*/
			
		}
		
		return $result;
	}
}


if(!function_exists('rating_layout_single')) {
	function rating_layout_single($post_id) {
		$result = '';
		$tags = get_field('rating_tag',$post_id);
		$result .= '<div class="white_block rating_table rating_table_all" data-t="3" data-tags="'.$tags.'">';
		$tag_term = get_term( get_field('rating_tag',$post_id), 'affiliate-tags' );
		$tag_human_title = get_field('tag_human_title','term_'.$tag_term->term_id);
		$tag = $tag_term->slug;
		$fields = get_field( 'more_fields', $post_id );
		$args = array(
			'post_type' => 'casino',
			'posts_per_page' => 3,
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
		$reviews = new WP_Query( $args );
		$count_reviews = $reviews->found_posts;
		wp_reset_postdata();
		$p_i = 0;
		$result .= '<div class="main_row rating_table_row">';
		$result .= '<div class="rating_table_td rating_all_logos flex asfasfasf2">';
		if($count_reviews > 0) {
			foreach ($reviews->posts as $item) {
				$p_i++;
				if($p_i <= 3) {
					$result .= review_logo($item->ID);
				}
			}
		}
		$result .= '</div>';
		$result .= '<div class="rating_table_td rating_all_title flex flex_column ">';
		$result .= '<div class="font_new_medium font_bold m_b_5"><a href="'.get_the_permalink($post_id).'" target="_blank" class="link_no_underline color_dark_blue">'.get_the_title($post_id).'</a></div>';
		$result .= '<div>';
		$result .= '<span class="color_dark_gray font_small m_right_10">'.__('Рубрика:','er_theme').'</span>';
		$result .= '<span class="color_dark_blue font_small font_underline_dotted">'.$tag_human_title.'</span>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '<div class="rating_table_td rating_all_count color_dark_blue">';
		$result .= '<div class="font_small font_bold">'.__('В рейтинге:','er_theme').'</div>';
		$result .= '<div class="font_small font_underline_dotted inline_block">'.$count_reviews.' '.counted_text($count_reviews,__('компания','er_theme'),__('компании','er_theme'),__('компаний','er_theme')).'</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}

if(!function_exists('company_layout_post')) {
	function company_layout_post($post_id) {
		$result = '';
		if (get_post_type($post_id) == 'addpages') {
			$review_id = get_field('addpage_review',$post_id);
			$terms = get_the_terms($review_id,'affiliate-tags');
			$result .= '<li class="white_block flex" data-t="2" data-tags="'.$terms[0]->term_id.'">';
		} else {
			$review_aff_tags = get_field('er_post_tags',$post_id);
			$result .= '<li class="white_block flex" data-t="2" data-tags="'. ( isset( $review_aff_tags[0] ) ? $review_aff_tags[0] : '' ).'">';
		}

		$current_language = get_locale();

		$author_id = get_post_field( 'post_author', $post_id );
		$author = get_userdata($author_id);
		$attachment_id = get_field('photo_profile', 'user_'. $author_id );
		$user_alt_name = get_user_alt_name( $author_id, $current_language );

		$thumb = get_the_post_thumbnail_url( $post_id, 'large' );
		$result .= '<div class="author_avatar"';
		if( isset( $attachment_id['sizes']['thumbnail'] ) && $attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') {
			$result .= ' style="background-image: url('.$attachment_id['sizes']['thumbnail'].');"';
		}
		$result .= '></div>';
		$result .= '<div class="news_middle">';
		$url = get_the_permalink($post_id);
		if (get_post_type($post_id) == 'addpages') {
			$review_id = get_field('addpage_review',$post_id);
			$slug = get_post_field( 'post_name', $review_id );
			if( strpos($url, '%show_category%') !== false ) {
				$url = str_replace( '%show_category%' , $slug , $url );
			} else {
				$url = get_permalink($review_id) . get_post_field( 'post_name', $post_id );
			}
		}
		$result .= '<a href="'.$url.'" class="color_dark_blue link_no_underline font_bold font_small">'.get_the_title($post_id).'</a>';
		$result .= '<div class="news_list_meta flex">';
		$result .= '<a href="/user/'.$author->user_nicename.'/" class="link_no_underline post_meta_author font_bold font_small color_dark_blue pointer">';

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
		$result .= '</a>';
		$result .= '<div class="post_meta_date font_smaller color_dark_gray">'.get_the_date('F j Y',$post_id).'</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</li>';
		return $result;
	}
}
if(!function_exists('get_post_stars_new')) {
	function get_post_stars_new($post_id, $reviews_count = null) {
		$result = '';
		//$result .= get_post_rating($group_id,'value');
		$percents = get_field('reviews_rating_average',$post_id);
		if( $reviews_count > 0 ) {
			$result .= '<div itemscope="" itemprop="aggregateRating" itemtype="https://schema.org/AggregateRating" class="stars flex">';
		} else {
			$result .= '<div class="stars flex">';
		}
		
		
		if(get_post_type($post_id) == 'promocodes') {
			$postID = get_field('promocode_review',$post_id);
		} else {
			$postID = $post_id;
		}
		$system_rating = get_field( 'reviews_rating_average', $postID );
		if ( ! $system_rating || $system_rating == '' ) {
			$system_rating = 0;
		}
		
		$system_rating = number_format( $system_rating, 1, '.', '' );
		$percents = $system_rating;
		
		$y = 0;
		foreach (range(1, 5) as $i) {
			if( $percents > 0 ) {
				$y ++;
				if ( $y <= $percents ) {
					$class = 'full';
				} else {
					$class = 'empty';
					if ( $y - floatval( $percents ) == 0.5 ) {
						$class = 'half';
					} elseif ( $y - floatval( $percents ) == 0 ) {
						$class = 'empty';
					} elseif ( $y - floatval( $percents ) > 1 ) {
						$class = 'empty';
					} elseif ( ($y - floatval( $percents ) < 0.5)) {
						$class = 'full';
					} else {
						$class = 'half '.floatval( $percents ).' '.$y;
					}
				}
				
				$result .= '<div class="' . $class . '"></div>';
			} else {
				$class = 'empty';
				$result .= '<div class="' . $class . '"></div>';
			}
		}
		
		if( $reviews_count > 0 ) {
			$result .= '<meta itemprop="bestRating" content="5">';
			$result .= '<meta itemprop="ratingValue" content="' . $percents . '">';
			$result .= '<meta itemprop="reviewCount" content="' . floor( $reviews_count ) . '">';
		}
		$result .= '</div>';
		return $result;
	}
}

if(!function_exists('company_layout_single')) {
	function company_layout_single($post_id) {
		$result = '';
		/*if(function_exists('get_rating_fields_group')) {
					   $rating_fields_group = get_rating_fields_group($post_id);
				   } else {
					   $rating_fields_group = 0;
				   } */
		//$comments_count = get_comments_count( $post_id, get_comment_rating_fields( $rating_fields_group, 'name' ) );
		$terms = get_the_terms($post_id,'affiliate-tags');
		$result .= '<li class="white_block flex" data-t="1">';
		$company_name = get_field('company_name',$post_id);
		if (function_exists('review_logo')) {
			$result .= review_logo($post_id);
		}
		$result .='<div class="search_review_middle flex flex_column">';
		
		
		$result .= '<a class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="'.get_the_permalink($post_id).'">'.$company_name.'</a>';
		
		if(!empty($terms)) {
			$t_x = 0;
			$result .= '<ul class="company_card_tags flex" data-id="9">';
			foreach ($terms as $term) {
				$t_x++;
				if($t_x <= 3) {
					$result .= '<li class="color_dark_blue">' . get_field('tag_human_title', 'term_' . $term->term_id) . '</li>';
				}
			}
			$result .= '</ul>';
		}
		$result .= get_post_stars_new($post_id);
		$result .='</div>';
		$result .='<div class="review_search_right flex">';
		$result .= '<div class="compare_container compare_container_s_r" id="s_r_compare_container_'.$post_id.'" data-post-id="'.$post_id.'">'.compare_icon($post_id).'</div>';
		$result .= review_top_rating($post_id);
		$result .='</div>';
		$result .= '</li>';
		return $result;
	}
}

if(!function_exists('review_top_rating_and_percents')) {
	function review_top_rating_and_percents($post_id, $font_big = true) {
		$result = '';
		$system_rating = get_field('reviews_rating_average',$post_id);
		if(!$system_rating || $system_rating == '') {
			$system_rating = 0;
		}
		$data_percent = 100 / 5 * $system_rating / 100;
		$value_good = get_field('reviews_count_good_percent',$post_id);
		if(!$value_good || $value_good == '') {
			$value_good = 0;
		}
		$value_bad = get_field('reviews_count_bad_percent',$post_id);
		if(!$value_bad || $value_bad == '') {
			$value_bad = 0;
		}
		
		$result .= '<div class="review_top_rating_and_percents">';
		$result .= '<div class="review_top_rating_percents">';
		$result .= '<span class="icon_rating_good">'.number_format( $value_good, 0, '.', '' ).'%</span><span class="icon_rating_bad">'.number_format( $value_bad, 0, '.', '' ).'%</span>';
		$result .= '</div>';
		$result .= '<div class="rating_page_text review_average_round progress" id="rating_list_item_'.$post_id.'" data-percent="'.$data_percent.'">';
		if ($font_big == true) {
			$result .= '<span class="inner color_dark_blue font_bold font_big">'.number_format( $system_rating, 1, '.', '' ).'</span>';
		} else {
			$result .= '<span class="inner color_dark_blue font_bold">'.number_format( $system_rating, 1, '.', '' ).'</span>';
		}
		
		$result .=  '</div>';
		$result .=  '</div>';
		return $result;
	}
}


if(!function_exists('company_layout_single_search_results')) {
	function company_layout_single_search_results($post_id) {
		$result = '';
		/*if(function_exists('get_rating_fields_group')) {
					   $rating_fields_group = get_rating_fields_group($post_id);
				   } else {
					   $rating_fields_group = 0;
				   } */
		//$comments_count = get_comments_count( $post_id, get_comment_rating_fields( $rating_fields_group, 'name' ) );
		$terms = get_the_terms($post_id,'affiliate-tags');
		$result .= '<li class="white_block flex" data-tags="'.$terms[0]->term_id.'">';
		$company_name = get_field('company_name',$post_id);
		if (function_exists('review_logo')) {
			$result .= review_logo($post_id);
		}
		$result .='<div class="search_review_middle flex flex_column">';
		
		
		$result .= '<a class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="'.get_the_permalink($post_id).'">'.$company_name.'</a>';
		
		if(!empty($terms)) {
			$t_x = 0;
			$result .= '<ul class="company_card_tags flex" data-id="10">';
			foreach ($terms as $term) {
				$t_x++;
				if($t_x <= 3) {
					$result .= '<li class="color_dark_blue">' . get_field('tag_human_title', 'term_' . $term->term_id) . '</li>';
				}
			}
			$result .= '</ul>';
		}
		//$result .= get_post_stars_new($post_id);
		$result .= '<div class="stars_and_reviews flex">';
		$result .=  get_post_stars_new($post_id);
		$result .= '<div class="stars_and_reviews_counts flex flex_column m_l_15 font_small line_big">';
		$reviews_count = get_field('reviews_count_reviews',$post_id);
		if(!$reviews_count || $reviews_count == '') {
			$reviews_count = 0;
		}
		if($reviews_count) {
			$result .= '<div class="reviews_count_reviews"><span class="color_dark_gray">'.__('Всего отзывов','er_theme').'</span> <span class="color_dark_blue link_dashed">'.$reviews_count.'</span></div>';
		} else {
			$result .= '<div class="reviews_count_reviews"><span class="color_dark_gray">'.__('Еще нет отзывов','er_theme').'</span></div>';
		}
		$abuses_count = get_field('reviews_count_abuses',$post_id);
		if(!$abuses_count || $abuses_count == '') {
			$abuses_count = 0;
		}
		if($abuses_count) {
			$result .= '<div class="reviews_count_reviews"><span class="color_dark_blue link_dashed">'.$abuses_count.' '.counted_text($abuses_count,__('жалоба','er_theme'),__('жалобы','er_theme'),__('жалоб','er_theme')).'</span></div>';
		} else {
			$result .= '<div class="reviews_count_abuses"><span class="color_dark_blue link_dashed">'.__('Еще нет жалоб','er_theme').'</span></div>';
		}
		$result .= '</div>';
		$result .= '</div>';
		$result .='</div>';
		$result .='<div class="review_search_right flex">';
		$result .= '<div class="compare_container compare_container_s_r" id="s_r_compare_container_'.$post_id.'" data-post-id="'.$post_id.'">'.compare_icon($post_id).'</div>';
		$result .= review_top_rating_and_percents($post_id);
		$result .='</div>';
		$result .= '</li>';
		return $result;
	}
}


