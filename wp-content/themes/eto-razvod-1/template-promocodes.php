<?php
/*
Template Name: Promocodes
*/
get_header();

if (have_posts()) :
        while (have_posts()) : the_post();
$actual_link = $_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI'];
$pos = strpos($actual_link, '?q=');


if ($pos === false) {
    the_content();
} else {
    $actual_link = urldecode($actual_link);
			$key = explode('?q=',$actual_link)[1];
			$prase = $key;
			$result = '';
	$search_active = ' active';
	$result .= '<div class="page_header page_header_rating page_rating_single page_s_promocodes_cat">';
				$result .= '<div class="wrap">';
					if (function_exists('show_breadcrumbs')) {
						$result .= show_breadcrumbs();
					}
					$result .= '<div class="page_heading_line">';
					$tag = get_field('affiliate_tag',$post->ID);
                    if($tag) {
                        $term_title = get_field('tag_human_title', 'term_' . $tag);
                    }
					$title = get_the_title($post->ID);
					$result .= '<h1 class="color_dark_blue flex font_medium_new">'.$title.'</h1>';
					$result .= '<div class="review_icon_share pointer m_l_15" data-type="share_post" data-id="'.$post->ID.'"></div>';
					$result .= '<form class="radius_small flex not_typing'.$search_active.'" id="search_results_form_promocodes" name="search_results_form" data-slug="'.$slug.'">';
					$result .= '<input type="text" name="s" class="placeholder_gray" value="'.$key.'" placeholder="'.__('Например, Финам').'" />';
					$result .= '<div class="big_search_icon_clear"></div>';
					$result .= '<div class="big_search_icon"></div>';
					$result .= '</form>';
				$result .= '</div>';
			$result .= '</div>';
			$result .= '</div>';
	/*
			$result .= '<div class="promocodes_header" data-tag="all">';
                $result .= '<div class="wrap">';
                $result .= '<div class="list_promocodes_top flex">';
                $result .= '<ul class="list_promocodes_tabs flex font_bolder font_smaller_2 font_uppercase color_dark_gray">';
                $result .= '<li class="active color_dark_blue" data-type="all">'.__('Все','er_theme').'</li>';
                $result .= '<li data-type="promocodes">'.__('Промокоды','er_theme').'</li>';
                $result .= '<li data-type="coupons">'.__('Купоны','er_theme').'</li>';
                $result .= '</ul>';
                $result .= '<ul class="list_promocodes_styler flex">';
                $result .= '<li class="active grid" data-type="grid"></li>';
                $result .= '<li class="list" data-type="list"></li>';
                $result .= '</ul>';
                $result .= '<div class="list_promocodes_sorter font_small">';
                $result .= '<div class="comments_sorter_title color_dark_gray pointer dropdown flex">'.__('Отсортировать по','er_theme').'</div>';
                $result .= '</div>';
                $result .= '</div>';
                $result .= '</div>';
                $result .= '</div>';*/
	$args_key = array(
				'posts_per_page' => -1,
				'post_type'=>'casino',
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
	
	$prase2 = '';
	if($prase != '') {

//$result .= 'удалить66666666'.transliterator_transliterate('Russian-Latin/BGN', $prase);
$prase_explode = explode(' ',$prase);
if (count($prase_explode) == 1) {
	//$result .= 'удалить'.'test1';
	if(isRussian($prase)) {

		//$result .= 'RU';
		$letters = [['ай','i'],['кс','x'],['аль','al'],['с','c'],['тиньк','tink'],['блэк','black'],['э','a'],['гик','geek'],['брейн','brain'],['бреин','brain'],['гикбреин','geekbrain'],['гикбрейнс','geekbrain']];

		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase, $value[0])) {
				if (strpos($prase, $value[0]) !== FALSE) {

					$args_key['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase)),
						'compare' => 'LIKE'
					);
					//$result .= 'удалить56565656999'.$test;

				}
			}
		}

		$letters2 = [[' ','-'],[' ','.']];

		$arr = [];
		foreach ($letters2 as $value) {

			if (strstr($prase, $value[0])) {
				if (strpos($prase, $value[0]) !== FALSE) {
					$test = str_replace($value[0], $value[1], $prase);
					$args_key['meta_query'][] = array(
						'key' => 'company_name',
						'value' => str_replace($value[0], $value[1], $prase),
						'compare' => 'LIKE'
					);

				}
			}
		}
		//$result .= $test;


		$phrase_alter = transliterator_transliterate('Russian-Latin/BGN', $prase);
		//$result .= 'удалить436346346'.transliterator_transliterate('Russian-Latin/BGN', $prase);

		//$result .= '<br />';
		//$result .= $phrase_alter;

	} else {
		//$result .= 'not_RU';
		$letters = [['h','х'],['tink','тиньк'],['tink','тиньк'],['black','блэк'],['a','э']];

		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase, $value[0])) {
				if (strpos($prase, $value[0]) !== FALSE) {

					$args_key['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase)),
						'compare' => 'LIKE'
					);

				}
			}
		}
		$phrase_alter = transliterator_transliterate('Latin-Russian/BGN', $prase);
		//$result .= 'удалить3463463463'.transliterator_transliterate('Latin-Russian/BGN', $prase);
		//print_r(transliterator_list_ids());
		//$result .= '<br />';
		//$result .= $phrase_alter;

	}
}
elseif (count($prase_explode) == 2) {
	//$result .= 'удалить'.'test2';
	//разбивка на 2 слова
	//if (    ((isRussian($prase_explode[0])) && !(isRussian($prase_explode[1]))) || (isRussian($prase_explode[1])) && !(isRussian($prase_explode[0])) ) {
	//если оно из слов русское, а второе нет
	//$result .= 'удалить'.'test4';
	if(isRussian($prase_explode[0])) {

		//$result .= 'RU';
		$letters = [['ай','i'],['кс','x'],['аль','al'],['с','c'],['тиньк','tink'],['блэк','black'],['э','a'],['гик','geek'],['брейн','brain'],['бреин','brain'],['гикбреин','geekbrain'],['гикбрейнс','geekbrain']];

		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase_explode[0], $value[0])) {
				if (strpos($prase_explode[0], $value[0]) !== FALSE) {

					$args_key['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase_explode[0])),
						'compare' => 'LIKE'
					);

				}
			}
		}

		$letters2 = [[' ','-'],[' ','.']];

		$arr = [];
		foreach ($letters2 as $value) {

			if (strstr($prase_explode[0], $value[0])) {
				if (strpos($prase_explode[0], $value[0]) !== FALSE) {
					$test = str_replace($value[0], $value[1], $prase_explode[0]);
					$args_key['meta_query'][] = array(
						'key' => 'company_name',
						'value' => str_replace($value[0], $value[1], $prase_explode[0]),
						'compare' => 'LIKE'
					);

				}
			}
		}
		//$result .= $test;


		$phrase_alter = transliterator_transliterate('Russian-Latin/BGN', $prase_explode[0]);
		//$result .= '<br />';
		//$result .= $phrase_alter;

	} else {
		//$result .= 'удалить'.'3 шаг';
		//$result .= 'not_RU';
		$letters = [['h','х'],['tink','тиньк'],['tink','тиньк'],['black','блэк'],['a','э']];

		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase_explode[0], $value[0])) {
				if (strpos($prase_explode[0], $value[0]) !== FALSE) {

					$args_key['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase_explode[0])),
						'compare' => 'LIKE'
					);

				}
			}
		}
		$phrase_alter = transliterator_transliterate('Latin-Russian/BGN', $prase_explode[0]);
		//$result .= 'удалить9999'.transliterator_transliterate('Latin-Russian/BGN', $prase_explode[0]);
		//print_r(transliterator_list_ids());
		//$result .= '<br />';
		//$result .= $phrase_alter;

	}

	if(isRussian($prase_explode[1])) {

		//$result .= 'RU';
		$letters = [['ай','i'],['кс','x'],['аль','al'],['с','c'],['тиньк','tink'],['блэк','black'],['э','a'],['гик','geek'],['брейн','brain'],['бреин','brain'],['гикбреин','geekbrain'],['гикбрейнс','geekbrain']];

		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase_explode[1], $value[0])) {
				if (strpos($prase_explode[1], $value[0]) !== FALSE) {

					$args_key['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase_explode[1])),
						'compare' => 'LIKE'
					);

				}
			}
		}

		$letters2 = [[' ','-'],[' ','.']];

		$arr = [];
		foreach ($letters2 as $value) {

			if (strstr($prase_explode[1], $value[0])) {
				if (strpos($prase_explode[1], $value[0]) !== FALSE) {
					$test = str_replace($value[0], $value[1], $prase_explode[1]);
					$args_key['meta_query'][] = array(
						'key' => 'company_name',
						'value' => str_replace($value[0], $value[1], $prase_explode[1]),
						'compare' => 'LIKE'
					);

				}
			}
		}
		//$result .= $test;


		$phrase_alter = transliterator_transliterate('Russian-Latin/BGN', $prase_explode[1]);
		//$result .= '<br />';
		//$result .= $phrase_alter;

	} else {
		//$result .= 'not_RU';
		$letters = [['h','х'],['tink','тиньк'],['tink','тиньк'],['black','блэк'],['a','э']];

		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase_explode[1], $value[0])) {
				if (strpos($prase_explode[1], $value[0]) !== FALSE) {

					$args_key['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase_explode[1])),
						'compare' => 'LIKE'
					);

				}
			}
		}
		$phrase_alter = transliterator_transliterate('Latin-Russian/BGN', $prase_explode[1]);
		//$result .= 'удалить8888888'.transliterator_transliterate('Latin-Russian/BGN', $prase_explode[1]);
		//print_r(transliterator_list_ids());
		//$result .= '<br />';
		//$result .= $phrase_alter;

	}
	/*} else {
		//$result .= 'удалить'.'test5';
		if(isRussian($prase)) {

			//$result .= 'RU';
			$letters = [['ай','i'],['кс','x'],['аль','al'],['с','c'],['тиньк','tink'],['блэк','black'],['э','a'],['гик],'geek;
,['брейнс
,'brains								$arr = [];
			foreach ($letters as $value) {

				if (strstr($prase, $value[0])) {
					if (strpos($prase, $value[0]) !== FALSE) {

						$args_key['meta_query'][] = array(
							'key' => 'company_name',
							'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase)),
							'compare' => 'LIKE'
						);

					}
				}
			}

			$letters2 = [[' ','-'],[' ','.']];

			$arr = [];
			foreach ($letters2 as $value) {

				if (strstr($prase, $value[0])) {
					if (strpos($prase, $value[0]) !== FALSE) {
						$test = str_replace($value[0], $value[1], $prase);
						$args_key['meta_query'][] = array(
							'key' => 'company_name',
							'value' => str_replace($value[0], $value[1], $prase),
							'compare' => 'LIKE'
						);

					}
				}
			}
			//$result .= $test;


			$phrase_alter = transliterator_transliterate('Russian-Latin/BGN', $prase);
			//$result .= '<br />';
			//$result .= $phrase_alter;

		} else {
			//$result .= 'not_RU';
			$letters = [['h','х'],['tink','тиньк'],['tink','тиньк'],['black','блэк'],['a','э']];

			$arr = [];
			foreach ($letters as $value) {

				if (strstr($prase, $value[0])) {
					if (strpos($prase, $value[0]) !== FALSE) {

						$args_key['meta_query'][] = array(
							'key' => 'company_name',
							'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase)),
							'compare' => 'LIKE'
						);

					}
				}
			}
			$phrase_alter = transliterator_transliterate('Latin-Russian/BGN', $prase);
			//$result .= 'удалить333'.transliterator_transliterate('Latin-Russian/BGN', $prase);
			//print_r(transliterator_list_ids());
			//$result .= '<br />';
			//$result .= $phrase_alter;

		}
	}*/

}
else {
	//$result .= 'удалить'.'test3';
	if(isRussian($prase)) {

		//$result .= 'RU';
		$letters = [['ай','i'],['кс','x'],['аль','al'],['с','c'],['тиньк','tink'],['блэк','black'],['э','a'],['гик','geek'],['брейн','brain'],['бреин','brain'],['гикбреин','geekbrain'],['гикбрейнс','geekbrain']];


		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase, $value[0])) {
				if (strpos($prase, $value[0]) !== FALSE) {

					$args_key['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase)),
						'compare' => 'LIKE'
					);

				}
			}
		}

		$letters2 = [[' ','-'],[' ','.']];

		$arr = [];
		foreach ($letters2 as $value) {

			if (strstr($prase, $value[0])) {
				if (strpos($prase, $value[0]) !== FALSE) {
					$test = str_replace($value[0], $value[1], $prase);
					$args_key['meta_query'][] = array(
						'key' => 'company_name',
						'value' => str_replace($value[0], $value[1], $prase),
						'compare' => 'LIKE'
					);

				}
			}
		}
		//$result .= $test;


		$phrase_alter = transliterator_transliterate('Russian-Latin/BGN', $prase);
		//$result .= '<br />';
		//$result .= $phrase_alter;

	} else {
		//$result .= 'not_RU';
		$letters = [['h','х'],['tink','тиньк'],['tink','тиньк'],['black','блэк'],['a','э']];

		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase, $value[0])) {
				if (strpos($prase, $value[0]) !== FALSE) {

					$args_key['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase)),
						'compare' => 'LIKE'
					);

				}
			}
		}
		$phrase_alter = transliterator_transliterate('Latin-Russian/BGN', $prase);
		//$result .= 'удалить4444'.transliterator_transliterate('Latin-Russian/BGN', $prase);
		//print_r(transliterator_list_ids());
		//$result .= '<br />';
		//$result .= $phrase_alter;

	}
}

if($phrase_alter != '') {
	$args_key['meta_query'][] = array(
		'key' => 'company_name',
		'value' => $phrase_alter,
		'compare' => 'LIKE'
	);
}
if($prase != '') {
	$args_key['meta_query'][] = array(
		'key'     => 'company_name',
		'value'   => $prase,
		'compare' => 'LIKE'
	);
	$args_key['meta_query'][] = array(
		'key'		=> 'websites_$_site_url',
		'compare'	=> 'LIKE',
		'value'		=> $prase
	);
}




	}
	
	$current_language = get_locale();
	if( $current_language == 'ru_RU' ) {
		// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
		$args_key['turn_off_on_ru_language'] = 1;		
	}

	$the_query = new WP_Query( $args_key );


	$found = array();
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					global $post;
					
					$company_promo_args = array(
						'posts_per_page' => -1,
						'post_status' => 'publish',
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
								$found[] = $post->ID;
								//echo get_the_title($post->ID);
							}

						}
					}
					wp_reset_postdata();
				}
			}
			wp_reset_postdata();
	
			if(!empty($found)) {
				$result .= '<div class="page_content page_container background_light rating_container visible"><div class="wrap">';
				$result .= '<ul class="flex list_promocodes">';
				//print_r($found);
				foreach($found as $postt_id) {
							$review_id = get_field('promocode_review',$postt_id);
							$company_name = get_field('company_name',$review_id);
							//$result .= get_the_title($postt_id).'<br />';
							$promocodes = get_field('promocodes_items',$postt_id);
							$y = 0;
							$terms = get_term(get_field('promocode_taxonomy',$postt_id),'affiliate-tags')->slug;
		$terms_id = get_term(get_field('promocode_taxonomy',$postt_id),'affiliate-tags')->term_id;
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
					$the_post_for_slug = get_post( $postt_id );
					$xxx = 0;
							foreach ($promocodes as $item) {
								$xxx++;
								$result .= '<li class="white_block flex flex_column" id="cat_promocodes_'.$postt_id.'_'.$xxx.'">';
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
						$result .='<div class="promocode_block_content flex flex_column">';
						$result .= review_logo($review_id);
						if($size != '') {
							$result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size">' . $size . '</div>';
						} else {
							$result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size_text">' . $item_type . '</div>';
						}
						$result .= '<a class="promocode_item_title color_dark_blue link_no_underline font_bold do_not_translate_css_class" href="'.get_the_permalink($tasks[0]->ID).$the_post_for_slug->post_name.'/" target="_blank" aria-label="'.$company_name.'">'.$company_name.'</a>';
						if($item['title'] != '') {
							$result .= '<div class="color_dark_gray font_small m_t_10">' . $item['title'] . '</div>';
						}
							$result .= '<div class="promocode_button_container">';
									if($item['text'] != '' && $item['text'] != 'Не нужен') {
										$result .= '<div class="promocode_text_container">';
										$result .= '<div class="promocode_single_text" id="promocode_text_'.$post->ID.'_1">'.$item['text'].'</div>';
										$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-1/" target="_blank" rel="nofollow">'.__('Получить','er_theme').'</a>';
										$result .= '<div class="link_promocode_text_copy button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Скопировать','er_theme').'</div>';
										$result .= '</div>';
										$result .= '<div class="link_promocode_show_more_text button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Показать код','er_theme').'</div>';
									} else {
										$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-1/" target="_blank" rel="nofollow">'.__('Получить','er_theme').'</a>';
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
						}
				$result .= '</ul></div></div>';
				
			} else {
				$result .= '<div class="page_content page_container background_light rating_container visible"><div class="wrap">';
				$result .= __('Промокоды по вашему запросу не найдены');
				$result .= '</div></div>';
			}
	echo $result;
}

		?>
		
		
		
		
		
		<?php
		endwhile;
endif;


get_footer();

?>