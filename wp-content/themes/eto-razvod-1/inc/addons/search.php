<?php

if(!function_exists('search_results_filter')) {
	function search_results_filter($tag) {
		$result = '';

        $current_language = get_locale();

		$t_args = array(
			'taxonomy' => 'affiliate-tags',

			'orderby' => 'meta_value',
  			'order' => 'ASC',
			'meta_key' => 'tag_human_title',
			'hide_empty' => false,
		);

        if( $current_language == 'ru_RU' ) {
			// Включаем признак для фильтрации таксономий с включенным чекбоксом "Спрятать на русском языке" через terms_clauses
			$t_args['tag_hide_on_ru_language'] = 1;		
		}

		$terms = new WP_Term_Query( $t_args );

		$result .= '<div class="search_results_filter">';

		if( ! empty( $term_query->terms ) ) {
			$result .= '<div class="search_results_filter_tags">';
			$y = 0;
			$cyr = [];$eng = [];
			foreach( $term_query->terms as $term ) {
				$human_title = '';

				$human_title = get_field('tag_human_title', 'term_' . $term->term_id);
				if($human_title != '' && $tag != $term->term_id) {
					$y++;

					//$result .= '<li data-term-id="'.$term->term_id.'" data-slug="'.$term->slug.'">'.$human_title.'</li>';

					if (isRussian(mb_substr($human_title, 0, 1))) {
						$cyr[] = '<li data-term-id="'.$term->term_id.'" data-slug="'.$term->slug.'">'.$human_title.'</li>';
					} else {
						$eng[] = '<li data-term-id="'.$term->term_id.'" data-slug="'.$term->slug.'">'.$human_title.'</li>';
					}


				}
			}
			$yr = 0;
			foreach ( $cyr as $item ) {
				$yr++;
				if($yr == 10) {
					$result .= '<div class="search_results_filter_tags_more">';
				}
				$result .= $item;
			}
			foreach ( $eng as $item ) {
				$result .= $item;
			}

				$result .= '</div>';
				$result .= '<div class="dropdown pointer color_dark_gray font_smaller flex link_show_more_results_filter_tags">'.__('Больше','er_theme').'</div>';
			$result .= '</div>';
		}

		$result .= '</div>';
		return $result;
	}
}



if(!function_exists('big_search_load_cats')) {
	add_action( 'wp_ajax_big_search_load_cats', 'big_search_load_cats' );
	add_action( 'wp_ajax_nopriv_big_search_load_cats', 'big_search_load_cats' );
	function big_search_load_cats() {

		$data = $_POST;
		$tag = $data['tag'];
		$search_type = $data['type'];
		$result = '';

        $t_args = array(
            'taxonomy' => 'affiliate-tags',

            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_key' => 'tag_human_title',
            'hide_empty' => false,
            'meta_query' => array()
        );

        $current_language = get_locale();

        if( $current_language != 'ru_RU' ) {
            $t_args['meta_query']['relation'] = 'AND';
            $t_args['meta_query'][] = array(
                'key'     => 'enable_translations',
                'value'   => $current_language,
                'compare' => 'LIKE'
            );
        } else {
			// Включаем признак для фильтрации таксономий с включенным чекбоксом "Спрятать на русском языке" через terms_clauses
			$t_args['tag_hide_on_ru_language'] = 1;		
		}

		$term_query = new WP_Term_Query( $t_args );

		$result .= '<div class="big_search_load_cats box_shadow_down">';
		if( ! empty( $term_query->terms ) ) {
			$result .= '<ul>';
			if($tag != 'all') {
			$result .= '<li data-term-id="all">'.__('Все категории','er_theme').'</li>';
			}
			$cyr = [];$eng = [];
			foreach( $term_query->terms as $term ) {
				$human_title = '';

				$human_title = get_field('tag_human_title', 'term_' . $term->term_id);
				if($human_title != '' && $tag != $term->term_id) {

					if($search_type == 'promocodes_big') {
						$check_args = array(
							'posts_per_page' => 1,
							'post_type'=>'promocodes_cats',
						);
						$check_args['tax_query'] = array(
							array(
								'taxonomy' => 'affiliate-tags',
								'field' => 'term_id',
								'terms' => $term->term_id,
							)
						);
						$check_cats = get_posts($check_args);
						if(count($check_cats) > 0) {

							//$result .= '<li data-term-id="'.$term->term_id.'" data-slug="'.$check_cats[0]->post_name.'">'.$human_title.'</li>';

							if (isRussian(mb_substr($human_title, 0, 1))) {
								$cyr[] = '<li data-term-id="'.$term->term_id.'" data-slug="'.$check_cats[0]->post_name.'">'.$human_title.'</li>';
							} else {
								$eng[] = '<li data-term-id="'.$term->term_id.'" data-slug="'.$check_cats[0]->post_name.'">'.$human_title.'</li>';
							}
						}
					} else {
						//$result .= '<li data-term-id="'.$term->term_id.'" data-slug="'.$term->slug.'">'.$human_title.'</li>';
						$tag_rating = get_field('er_bc_link','term_'.$term->term_id);
						if (isRussian(mb_substr($human_title, 0, 1))) {
							$cyr[] = '<li data-term-id="'.$term->term_id.'" data-slug="'.$term->slug.'" data-link="'.$tag_rating.'">'.$human_title.'</li>';
						} else {
							$eng[] = '<li data-term-id="'.$term->term_id.'" data-slug="'.$term->slug.'" data-link="'.$tag_rating.'">'.$human_title.'</li>';
						}
					}

				}

			}
			foreach ( $cyr as $item ) {
				$result .= $item;
			}
			foreach ( $eng as $item ) {
				$result .= $item;
			}
			$result .= '</ul>';
		}
		$result .= '</div>';
		echo $result;
		die;
	}
}
if(!function_exists('big_search_results')) {
function isRussian($text) {
    return preg_match('/[А-Яа-яЁё]/u', $text);
}
}

if(!function_exists('big_search_results_redirect')) {
	add_action( 'wp_ajax_big_search_results_redirect', 'big_search_results_redirect' );
	add_action( 'wp_ajax_nopriv_big_search_results_redirect', 'big_search_results_redirect' );
	function big_search_results_redirect() {
		$data = $_POST;
		$prase = $data['phrase'];
		$tag = $data['tag'];
		$search_type = $data['type'];
		$link = get_bloginfo('url').'/search/?tag='.$tag.'&phrase='.$prase;
		wp_redirect( $link );
	}
}

if(!function_exists('big_search_results')) {
	add_action( 'wp_ajax_big_search_results', 'big_search_results' );
	add_action( 'wp_ajax_nopriv_big_search_results', 'big_search_results' );
	function big_search_results() {
		$data = $_POST;
		$prase = $data['phrase'];
		$tag = $data['tag'];
		$search_type = $data['type'];
		$result = '';

		$args = array(
			'posts_per_page' => 3,
			'post_type'=>'casino',
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key' => 'company_name',
					'value' => $prase,
					'compare' => 'LIKE'
				)
			)
		);


		if($tag != 'all') {
			$args['tax_query'] = array(
            array(
                'taxonomy' => 'affiliate-tags',
                'field' => 'term_id',
                'terms' => $tag,
            )
        );
		}
		$prase2 = '';
		if($prase != '') {
			include_once(TEMPLATEPATH .'/inc/get_search.php');
		}

        $current_language = get_locale();
        if( $current_language == 'ru_RU' ) {
			// Включаем признак для фильтрации таксономий с включенным чекбоксом "Спрятать на русском языке" через terms_clauses
			$args['tag_hide_on_ru_language'] = 1;		
		}

		$args_2 = $args;
		$args_2['posts_per_page'] = -1;
		$the_query = new WP_Query( $args );

		$found = array();
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				global $post;
				$found[] = $post->ID;
			}
		}
		wp_reset_postdata();



		if ( !empty($found) ) {

			$current = count($found);
			$the_query_total = new WP_Query( $args );
			$total = $the_query_total->found_posts;
			//$result .= $search_type;
			$result .= '<ul class="results_content" data="s0">';

			foreach($found as $post_id) {
				if(function_exists('get_rating_fields_group')) {
                        $rating_fields_group = get_rating_fields_group($post_id);
                    } else {
                        $rating_fields_group = 0;
                    }
                    $comments_count = get_comments_count( $post_id, get_comment_rating_fields( $rating_fields_group, 'name' ) );
				$result .= '<li class="white_block flex flex_column flex_column_1">';
                    $company_name = get_field('company_name',$post_id);
                    $result .='<div class="company_block_header flex">';
					$result .= '<div class="compare_container compare_container_s_r" id="s_r_compare_container_'.$post_id.'" data-post-id="'.$post_id.'">'.compare_icon($post_id).'</div>';
                    if (function_exists('review_logo')) {
                        $result .= review_logo($post_id);
                    }
                    $result .= '<div class="flex flex_column">';
                    $result .= '<a class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="'.get_the_permalink($post_id).'">'.$company_name.'</a>';
                    $result .= '<div class="font_small"><span class="color_dark_gray count_reviews">'.__('Отзывы','er_theme').'</span><span class="color_dark_blue">'.$comments_count['count'].'</span></div>';
                    $terms = get_the_terms($post_id,'affiliate-tags');
                    if(!empty($terms)) {
                        $t_x = 0;
                        $result .= '<ul class="company_card_tags flex" data-id="2">';
                        foreach ($terms as $term) {
                            $t_x++;
                            if($t_x <= 1) {
                                $result .= '<li class="color_dark_blue">' . get_field('tag_human_title', 'term_' . $term->term_id) . '</li>';
                            }
                        }
                        $result .= '</ul>';
                    }
                    $result .='</div>';
                    $result .='</div>';
                    $result .='<div class="company_block_footer flex">';
                    $result .= get_post_stars($rating_fields_group);
                    $result .= review_top_rating($post_id);
                    $result .='</div>';
                    $result .= '</li>';
			}
			$result .= '</ul>';
			if($current < $total) {
				$more_classes = 'button pointer button_violet radius_small button_padding_big font_small font_bold button_centered line_show_more_search flex';
				$result .= '<div class="'.$more_classes.' inactive" data-offset="'.$current.'" data-block-id="er_block_comments-block_608179d7d8fba" data-container="ul.results_content" data-per-page="3" data-total="'.$total.'" data-phrase="'.$prase.'" data-tag="'.$tag.'">'.__('Показать еще','er_theme').'</div>';
			}
		} else {
			$result .= '<div class="error m_t_20 color_red">'.__('По данным параметрам ничего не найдено','er_theme').'</div>';
		}
		if($prase == '' && $tag != 'all') {
			$term_name = get_term_by('term_id', $tag, 'affiliate-tags')->slug;
			$tag_human_title = get_field('tag_human_title','term_'.$tag);
			$result .= '<a class="color_blue m_t_15 button_centered" href="'.get_bloginfo('url').'/search/'.$term_name.'/">'.__('Все компании рубрики','er_theme').' '.$tag_human_title.'</a>';
		}

		echo $result;
		die;
	}
}

if (!function_exists('load_more_search')) {
    add_action( 'wp_ajax_load_more_search', 'load_more_search' );
    add_action( 'wp_ajax_nopriv_load_more_search', 'load_more_search' );
    function load_more_search() {
		$data = $_POST;
		$prase = $data['phrase'];
		$tag = $data['tag'];
		$result = '';

		$args = array(
			'posts_per_page' => 3,
			'post_type'=>'casino',
			'post_status' => 'publish',
			'orderby' => 'menu_order',
		'order' => 'ASC',
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key' => 'company_name',
					'value' => $prase,
					'compare' => 'LIKE'
				)
			)
		);
		if($tag != 'all') {
			$args['tax_query'] = array(
            array(
                'taxonomy' => 'affiliate-tags',
                'field' => 'term_id',
                'terms' => $tag,
            )
        );
		}
	    if($prase != '') {
		    include_once(TEMPLATEPATH .'/inc/get_search.php');
	    }
		$args['offset'] = $data['offset'];

        if( $current_language == 'ru_RU' ) {
			// Включаем признак для фильтрации таксономий с включенным чекбоксом "Спрятать на русском языке" через terms_clauses
			$args['tag_hide_on_ru_language'] = 1;		
		}

		$the_query = new WP_Query( $args );
		$found = array();
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				global $post;
				$found[] = $post->ID;
			}
		}
		wp_reset_postdata();
		if ( !empty($found) ) {
			foreach($found as $post_id) {
				if(function_exists('get_rating_fields_group')) {
                        $rating_fields_group = get_rating_fields_group($post_id);
                    } else {
                        $rating_fields_group = 0;
                    }
                    $comments_count = get_comments_count( $post_id, get_comment_rating_fields( $rating_fields_group, 'name' ) );
				$result .= '<li class="white_block flex flex_column flex_column_2">';
                    $company_name = get_field('company_name',$post_id);
                    $result .='<div class="company_block_header flex">';
					$result .= '<div class="compare_container compare_container_s_r" id="s_r_compare_container_'.$post_id.'" data-post-id="'.$post_id.'">'.compare_icon($post_id).'</div>';
                    if (function_exists('review_logo')) {
                        $result .= review_logo($post_id);
                    }
                    $result .= '<div class="flex flex_column">';
                    $result .= '<a class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="'.get_the_permalink($post_id).'">'.$company_name.'</a>';
                    $result .= '<div class="font_small"><span class="color_dark_gray count_reviews">'.__('Отзывы','er_theme').'</span><span class="color_dark_blue">'.$comments_count['count'].'</span></div>';
                    $terms = get_the_terms($post_id,'affiliate-tags');
                    if(!empty($terms)) {
                        $t_x = 0;
                        $result .= '<ul class="company_card_tags flex" data-n="1">';
                        foreach ($terms as $term) {
                            $t_x++;
                            if($t_x <= 1) {
                                $result .= '<li class="color_dark_blue">' . get_field('tag_human_title', 'term_' . $term->term_id) . '</li>';
                            }
                        }
                        $result .= '</ul>';
                    }
                    $result .='</div>';
                    $result .='</div>';
                    $result .='<div class="company_block_footer flex">';
                    $result .= get_post_stars($rating_fields_group);
                    $result .= review_top_rating($post_id);
                    $result .='</div>';
                    $result .= '</li>';
			}

		}
		echo $result;
		die;
	}
}

if (!function_exists('live_search_ajax_add_phrase')) {

    add_action('wp_ajax_live_search_ajax_add_phrase', 'live_search_ajax_add_phrase');
    add_action('wp_ajax_nopriv_live_search_ajax_add_phrase', 'live_search_ajax_add_phrase');

    function live_search_ajax_add_phrase() {
        $data = $_POST;
        $phrase = $data['phrase'];
        if($phrase != '') {
            global $wpdb;
            $mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
            $mydb->insert('search_queries',
                array(
                    'query'=> $phrase,
                    'type' => 'ajax'
                ),
                array( '%s', '%s'));
        }
    }
}

function my_posts_where_promocodes_main( $where ) {

	$where = str_replace( "meta_key = 'promocodes_items_$", "meta_key LIKE 'promocodes_items_%", $where );

	return $where;
}

add_filter( 'posts_where', 'my_posts_where_promocodes_main' );


if (!function_exists('live_search_ajax')) {

	add_action( 'wp_ajax_live_search_ajax', 'live_search_ajax' );
	add_action( 'wp_ajax_nopriv_live_search_ajax', 'live_search_ajax' );

	function live_search_ajax(){
		$result = '';

		if($_POST['s'] == '') {
			$result .= '<div class="search_results">';
				$result .= '<div class="wrap">';
					$result .= '<div>'.__('Пожалуйста, введите поисковый запрос','er_theme').'</div>';
			$result .= '</div>';
		$result .= '</div>';
		} else {
			$current_language = get_locale();
			$prase = $_POST['s'];

			$args = array(
				'posts_per_page' => -1,
				'post_type'=>'casino',
				'post_status' => 'publish',
				'orderby' => 'menu_order',
                // 'suppress_filters' => false,
				'order' => 'ASC',
			);
			
			$args['meta_query'] = array(
				'relation' => 'OR',
				array(
					'key'     => 'company_name',
					'value'   => $prase,
					'compare' => 'LIKE'
				),
				array(
					'key'     => 'company_redirect_key',
					'value'   => $prase,
					'compare' => 'LIKE'
				)
			);

			if($prase != '') {
				include_once(TEMPLATEPATH .'/inc/get_search.php');
			}

            if($current_language != 'ru_RU') {
                $args_posts = array(
                    'posts_per_page' => -1,
                    'post_type' => array('post',  'page'),
                    'orderby' => 'title',
					'post_status' => 'publish',
                    's' => $prase,
                    'sentence' => true,
                    'order' => 'ASC',
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key' => 'enable_translations',
                            'value' => $current_language,
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
                    'orderby' => 'title',
                    's' => $prase,
					'post_status' => 'publish',
                    'sentence' => true,
                    'order' => 'ASC',
                    'post__not_in' => array(139302, 86973, 77815, 86973, 75091, 132557, 137116, 132567, 75094, 75089, 132579, 132583, 132585, 132597, 132581, 132591, 132589, 132587, 132571, 30322, 170, 132565, 140367, 32829, 128, 9857, 75096, 133173, 132559, 32827, 130, 32916, 86256, 76866, 132569, 132562, 132557, 136964, 99062, 136964, 19540, 98993, 139296, 132573, 98982, 75098, 132576, 139302, 88311, 76861, 81639, 99047),
                    'meta_query' => array(
						'relation' => 'AND',
						[
							array(
								'key'     => 'turn_off_on_ru_language',
								'value'   => 'yes',
								'compare' => '!='
							),
						],
						[
							'relation' => 'OR',
							array(
								'key'     => '_wp_page_template',
								'compare' => 'NOT EXISTS',
							),
							array(
								'key'     => '_wp_page_template',
								'compare' => 'NOT IN',
								'value'   => array(
									'template-rating.php',
									'template-service.php',
									'category.php',
									'single-post.php',
									'template-landing.php',
									'template-news.php',
									'template-promocodes.php',
									'template-rating-all.php'
								)
							)
						]
                    )
                );

            }
				

			$args_ratings = array(
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'post_type'=> array('page'),
				'meta_key' => '_wp_page_template',
				'meta_value' => 'template-rating.php',
				'orderby' => 'title',
				's' => $prase,
				'order' => 'ASC',
				'meta_query' => [],
			);

			$args_promocodes = array(
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'post_type'=> array('promocodes'),
				'orderby' => 'title',
				's' => $prase,
				'order' => 'ASC',
				'meta_query' => [],
			);

			if( $current_language == 'ru_RU' ) {
				// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses

				$turn_off_on_ru_language = [
					'relation' => 'AND',
					[
						'key'     => 'turn_off_on_ru_language',
						'value'   => 'yes',
						'compare' => '!='
					],
				];

				// $tmp = $args['meta_query'];
				// $args['meta_query'] = $turn_off_on_ru_language;
				// array_push( $args['meta_query'], $tmp );

				$args['turn_off_on_ru_language'] = 1;

				$tmp = $args_posts['meta_query'];
				$args_posts['meta_query'] = $turn_off_on_ru_language;
				array_push( $args_posts['meta_query'], $tmp );

				$tmp = $args_ratings['meta_query'];
				$args_ratings['meta_query'] = $turn_off_on_ru_language;
				array_push( $args_ratings['meta_query'], $tmp );

				$tmp = $args_ratings['meta_query'];
				$args_ratings['meta_query'] = $turn_off_on_ru_language;
				array_push( $args_ratings['meta_query'], $tmp );

				$args_ratings['tag_hide_on_ru_language'] = 1;

				// $args_promocodes['turn_off_on_ru_language'] = 1;
			}

			$args['parent_alt_pages_hide'] = 1;
			$args_posts['parent_alt_pages_hide'] = 1;
			$args_ratings['parent_alt_pages_hide'] = 1;
			// $args_promocodes['parent_alt_pages_hide'] = 1;

			$the_query = new WP_Query( $args );
			$the_query_posts = new WP_Query( $args_posts );
			$the_query_ratings = new WP_Query( $args_ratings );
			// $the_query_promocodes = new WP_Query( $args_promocodes );
			$found = array();
			$found['promocodes']['count'] = 0;

			// $posts_temp = [];
			// foreach ( $the_query->posts as $item ) {
			// 	if (get_field('turn_off_on_ru_language',$item->ID) == 'yes' && $current_language == 'ru_RU') {
				
			// 	} else {
			// 		$posts_temp[] = $item;
			// 	}
			// }
			// $the_query->posts = $posts_temp;

			$result .= '<div class="search_results">';
					$result .= '<div class="wrap">';
					if ( $the_query->have_posts() ) {
						$found['companies']['count'] = count($the_query->posts);
						
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							global $post;
							if(!isset($post)) {
								continue;
							}
							
							if ($current_language == 'ru_RU') {
								/*if (get_field('turn_off_on_ru_language',$post->ID) == 'yes') {
									continue;
								} else {*/
									$found['companies']['posts'][] = $post->ID;
								/*}*/
							} else {
								$found['companies']['posts'][] = $post->ID;
							}

							$company_promo_args = array(
								'posts_per_page' => -1,
								'post_type'=> array('promocodes'),
								'meta_query' => array(
									'relation' => 'AND',
									array(
										'key'		=> 'promocodes_items_$_date_end',
										'compare'	=> '>=',
										'type' => 'DATE',
										'value'		=> date('Y-m-d',strtotime('-1 days')),
									),
									array(
										'key'		=> 'promocodes_items_$_date_end',
										'compare'	=> '!=',
										'type'      => 'DATE',
										'value'		=> '',
									)
								)

							);
							$company_promo_args['meta_query'][] = array(
								'key' => 'promocode_review',
								'value' => $post->ID,
								'compare' => '='
							);

							if( $current_language == 'ru_RU' ) {
								// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
								$company_promo_args['turn_off_on_ru_language'] = 1;
							}


							$the_query_company_promo_args = new WP_Query( $company_promo_args );
							if ( $the_query_company_promo_args->have_posts() ) {
								while ( $the_query_company_promo_args->have_posts() ) {
									$the_query_company_promo_args->the_post();
									global $post;
									$promocodes = array();
									//echo get_the_title($post->ID);
									$promocodes = get_field('promocodes_items');
									if($promocodes && !empty($promocodes)) {
										$promocodes_count_new = $found['promocodes']['count'] + count($promocodes);
										$found['promocodes']['count'] = $promocodes_count_new;
										$found['promocodes']['posts'][] = $post->ID;
									}

								}
							}
							wp_reset_postdata();
						}

					}
					wp_reset_postdata();
					if ( $the_query_posts->have_posts() ) {
						$found['posts']['count'] = $the_query_posts->found_posts;
						while ( $the_query_posts->have_posts() ) {
							$the_query_posts->the_post();
							global $post;
							$found['posts']['posts'][] = $post->ID;
						}

					}
					wp_reset_postdata();
					if ( $the_query_ratings->have_posts() ) {
						$found['ratings']['count'] = $the_query_ratings->found_posts;
						while ( $the_query_ratings->have_posts() ) {
							$the_query_ratings->the_post();
							global $post;
								$found['ratings']['posts'][] = $post->ID;
							
						}

					}
					wp_reset_postdata();
					/*if ( $the_query_promocodes->have_posts() ) {
						$found['promocodes']['count'] = $the_query_promocodes->found_posts;
						while ( $the_query_promocodes->have_posts() ) {
							$the_query_promocodes->the_post();
							global $post;
							$found['promocodes']['posts'][] = $post->ID;
						}

					}
					wp_reset_postdata();*/
					if ( !empty($found)) {
						$found_companies = isset($found['companies']['count']) ? $found['companies']['count'] : 0;
						// if(!$found_companies || $found_companies == '') {
						// 	$found_companies = 0;
						// }

						$found_posts = isset($found['posts']['count']) ? $found['posts']['count'] : 0;
						// if(!$found_posts || $found_posts == '') {
						// 	$found_posts = 0;
						// }

						$found_ratings = isset($found['ratings']['count']) ? $found['ratings']['count'] : 0;
						// if(!$found_ratings || $found_ratings == '') {
						// 	$found_ratings = 0;
						// }

						$found_promocodes = isset($found['promocodes']['count']) ? $found['promocodes']['count'] : 0;
						// if(!$found_promocodes || $found_promocodes == '') {
						// 	$found_promocodes = 0;
						// }

						$total_found = $found_companies + $found_posts + $found_ratings + $found_promocodes;
    	                    $result .= '<div class="search_results_count"><span class="font_bolder color_dark_gray font_smaller_2 font_uppercase" data-id="'.$found_companies.' '.$found_posts.' '.$found_ratings.' '.$found_promocodes.' '.$total_found.'">'.__('Результат поиска:','er_theme').'</span> <span class="color_dark_blue font_small">'.__($total_found).'</span> <span class="color_dark_blue font_small">'.counted_text($total_found,__('материал','er_theme'),__('материала','er_theme'),__('материалов','er_theme')).'</span></div>';

						$result .= '<div class="search_results_content">';
						$result .= '<ul class="search_result_tabs">';
						$result .= '<li class="tab_companies active" data-id="companies">'.__('Компании','er_theme').'<span> | '.$found_companies.'</span></li>';
						$result .= '<li class="tab_posts inactive" data-id="posts">'.__('Новости','er_theme').'<span> | '.$found_posts.'</span></li>';
						$result .= '<li class="tab_ratings inactive" data-id="ratings">'.__('Рейтинги','er_theme').'<span> | '.$found_ratings.'</span></li>';
						$result .= '<li class="tab_promocodes inactive" data-id="promocodes">'.__('Промокоды','er_theme').'<span> | '.$found_promocodes.'</span></li>';
						$result .= '</ul>';
						if($found_companies > 0) {
							$result .= '<div class="result_tab_content result_companies active results_content">';
							foreach($found['companies']['posts'] as $postt_id) {
									$result .= company_layout_single($postt_id);
							}
							$result .= '</div>';
						} else {
							//$result .= '<div class="result_tab_content result_companies active results_content">';
							//$result .= '<a href="/add-company/" class="block_button button button_green button_padding_big font_small font_bold button_centered pointer search_none_btn">Добавить компанию</a>';
							//$result .= '<a href="/order/" class="block_button button button_green button_padding_big font_small font_bold button_centered pointer search_none_btn">Заказать обзор</a>';
							//$result .= '</div>';
						}
						if($found_posts > 0) {
							$result .= '<div class="result_tab_content result_posts">';
							foreach($found['posts']['posts'] as $postt_id) {
								$result .= company_layout_post($postt_id);
								//$result .= get_the_title($postt_id).'<br />';
							}
							$result .= '</div>';
						}

						if($found_ratings > 0) {
							$result .= '<div class="result_tab_content result_ratings">';
							foreach($found['ratings']['posts'] as $postt_id) {
								$result .= rating_layout_single($postt_id);
								//$result .= '<a href="'.get_the_permalink($postt_id).'">'.get_the_title($postt_id).'</a>';
							}
							$result .= '</div>';
						}

						if($found_promocodes > 0) {
							$result .= '<div class="result_tab_content result_promocodes">';
							foreach($found['promocodes']['posts'] as $postt_id) {
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
										$result .= '<li class="white_block flex '.$border.''.$hidden_default.'" id="single_promocodes_'.$postt_id.'_'.$y.'">';
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

											$faq_discount_titles .= isset($item['title']) ? $item['title'].', ' : '';
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
						}

						$result .= '</div>';
					} else {
						 $result .= '<div class="search_results_count">'.__('Материалы по Вашему запросу не найдены','er_theme').'</div>';
					}

					//$result .= '<div class="search_results_banner">';
					$result .= '</div>';
				$result .= '</div>';

			$result .= '</div>';
		}
		echo $result;
		die;
	}
}

?>