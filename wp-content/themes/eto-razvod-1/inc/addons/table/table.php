<?php
function review_table($type,$id) {
	
	global $post;
	$d = $id;
	$result = '';
	if(get_field('tool_name')) {
		$tool_name = get_field('tool_name');
	} else {
		$tool_name = '';
	}
	if(in_array($type,array('details'))) {
		$fields = acf_get_fields_by_id($id);
		$company_type = get_term( get_field('company_type'), 'companytypes' )->name;
		//	echo '<pre>';
		//	print_r($fields);
		//echo '</pre>';
		$result .= '<table class="review_table white_block '.$type.' visible" id="reviewsummary" cellpadding="5" cellspacing="0"><tbody>';
		foreach($fields as $field) {
			
			/*		echo '<pre>';
					print_r($field);
					echo '</pre>'; */
			if ($field['type'] == 'accordion') {
				$result .= '<tr><th colspan="2" class="group_title">';
				$result .= $field['label'];
				$result .= '</th></tr>';
			} elseif ($field['type'] == 'relationship' && ($field['name'] == 'been_casino' || $field['name'] == 'similar_slots'  || $field['name'] == 'another_slots')) {
				$ids = get_field($field['name']);
				$result .= '<tr>';
				$result .= '<th>'.$field['label'].'</th>';
				$result .= '<td>';
				$result .= '<div class="td_container td_container_19">';
				$i = 0;
				foreach ( $ids as $id ) {
					if ($i != 0) {
						$result .= ', ';
					}
					
					$result .= '<a href="'.get_the_permalink($id).'" rel="nofollow" target="_blank"><span>'.get_field('company_name',$id).'</span></a>';
					$i = ++$i;
				}
				$result .= '</div>';
				$result .= '</td>';
				$result .= '</tr>';
			} elseif ($field['name'] == 'base_2_bonuses_first_dep_best_444') {
				
				if (gettype(get_field('base_2_bonuses_first_dep_best_444')) == 'array') {
					if (count(get_field('base_2_bonuses_first_dep_best_444')) > 0) {
						$result .= '<tr>';
						$result .= '<th>'.$field['label'].'</th>';
						$result .= '<td>';
						$result_text = '';
						$i_base_2_bonuses_first_dep_best_444 = 0;
						foreach ( get_field('base_2_bonuses_first_dep_best_444') as $item ) {
							++$i_base_2_bonuses_first_dep_best_444;
							if ($i_base_2_bonuses_first_dep_best_444 == count(get_field('base_2_bonuses_first_dep_best_444'))) {
								$result_text .= '<span class="best_bonuses">'.$item['text'].' '.__('от').' <a href="'.get_the_permalink($item['casino']).'" rel="nofollow" target="_blank"><span>'.get_field('company_name',$item['casino']).'</span></a>'.' '.'<a href="'.$item['url'].'" class="get_bonus_button get_bonus_button_2">'.__('Receive').'</a></span>';
							} else {
								$result_text .= '<span class="best_bonuses">'.$item['text'].' '.__('от').' <a href="'.get_the_permalink($item['casino']).'" rel="nofollow" target="_blank"><span>'.get_field('company_name',$item['casino']).'</span></a>'.' '.'<a href="'.$item['url'].'" class="get_bonus_button get_bonus_button_2">'.__('Receive').'</a>, </span>';
							}
							
						}
						$result .= '<div class="td_container td_container_23">'.$result_text.'</div>';
						$result .= '</td>';
						$result .= '</tr>';
					}
				}
			} elseif ($field['type'] == 'relationship') {
				if ($field['name'] == 'been_casino' || $field['name'] == 'similar_slots' || $field['name'] == 'another_slots') {
					continue;
				}
				$id = get_field($field['name'])[0]->ID;
				$result .= '<tr>';
				$result .= '<th>'.$field['label'].'</th>';
				$result .= '<td>';
				$result .= '<div class="td_container td_container_1"><a href="'.get_the_permalink($id).'" rel="nofollow" target="_blank"><span>'.get_field('company_name',$id).'</span></a></div>';
				$result .= '</td>';
				$result .= '</tr>';
				
			} elseif($field['wrapper']['class'] == 'additional_fields') {
				$original_field = get_field_object($field['__key'])['value'];
				//print_r($original_field);
				if(!empty($original_field)) {
					foreach ($original_field as $item) {
						$result .= '<tr><th>';
						$result .= $item['label'];
						$result .= '</th>';
						$result .= '<td>';
						$result .= '<div class="td_container td_container_12">'.$item['value'].'</div>';
						$result .= '</td></tr>';
					}
				}
				
			} elseif(in_array($field['type'],array('repeater','clone','group'))) {
				$original_field = get_field_object($field['__key']);
				
				$field_result = repeater_fields($original_field,'review');
				//print_r($original_field);
				if (str_contains($field_result, 'field_exist no') && get_field('turn_off_disabled_checkboxes',get_the_ID()) == 'yes') {
					continue;
				}
				if (get_field('turn_off_disabled_checkboxes',get_the_ID()) == 'yes') {
					if ((isset(get_field($field['name'],get_the_ID())['app_exist']))) {
						if (get_field($field['name'],get_the_ID())['app_exist'] == 0) {
							continue;
						}
					}
				}
				if($field_result && strpos($field_result, 'N/A') === false) {
					if($field['label'] == 'Мобильные приложения' && in_array($company_type,array('bi','fx','cfd','fond'))) {
						$original_field['label'] = __('Мобильный трейдинг');
					}
					$result .= '<tr>';
					$result .= '<th>'.$original_field['label'].'</th>';
					$result .= '<td>';
					if ($company_type == 'courses') {
						$result .= '<div class="td_container td_container_2">'.$field_result.'</div>';
					} else {
						if ($field['label'] == 'Максимальный займ') {
							if (str_contains($field_result, ' / Ставка: до')) {
								$field_result = str_replace(" / Ставка: до"," / Ставка: от 0% до",$field_result);
							}
						}
						if ($field['name'] == 'product_price') {
							if (get_field('cena_cross_out',get_the_ID())) {
								$result .= '<div class="td_container td_container_20"><div class="repeater_field repeater_fromto item_single university_price_edu"><span class="field_number bbb9832hjasf"><span class="course_price"><span class="course_price_1"><a href="/visit/'.get_field('company_redirect_key',get_the_ID()).'/" target="_blank" rel="nofollow">От '.get_field('product_price_0_from',get_the_ID()).' RUB</a><span class="course_price_2">'.__('Купить со скидкой','sa_theme').'</span></span> <span class="course_price_3">'.get_field('cena_cross_out',get_the_ID()).' '.'RUB'.'</span></span></span> </div></div>';
								//$result .= '<div class="td_container td_container_17"><span  class="course_price"><span  class="course_price_1"><a href="/visit/'.get_field('company_redirect_key',get_the_ID()).'/" target="_blank">'.$field_result.' '.term_field($item['currency'],'currencies','name').'</a><span class="course_price_2">'.__('Купить со скидкой','sa_theme').'</span></span> <span class="course_price_3">'.get_field('cena_cross_out',get_the_ID()).' '.'RUB'.'</span></span></div>';
							} else {
								$result .= '<div class="td_container td_container_16">'.$field_result.'</div>';
							}
							
						} else {
							$subdomain = '';
							$language = get_locale();
							if ($language != 'ru_RU') {
								if ($language == 'en_US') {
									$after_dot_domain = 'com';
								} elseif ($language == 'fr_FR') {
									$after_dot_domain = 'fr';
								} elseif ($language == 'es_ES') {
									$after_dot_domain = 'es';
								} elseif ($language == 'de_DE') {
									$after_dot_domain = 'de';
								} elseif ($language == 'pl_PL') {
									$subdomain = 'pl.';
									$after_dot_domain = 'com';
								} elseif ($language == 'fi') {
									$subdomain = 'fi.';
									$after_dot_domain = 'com';
								} elseif ($language == 'nb_NO') {
									$subdomain = 'no.';
									$after_dot_domain = 'com';
								}
								
								$field_result = str_replace('eto-razvod.ru',$subdomain.'revieweek.'.$after_dot_domain, $field_result);
							}
							if (mb_substr($field_result, -2) == ', ') {
								$field_result = mb_substr($field_result,0, -2);
							}
							if ($field['name'] == 'base_2_support') {// && $post->ID == 95
								preg_match_all('/<div class="support_channel">([^"]+)<\/div>/',$field_result,$m_array);
								if (gettype($m_array) == 'array') {
									if (count($m_array[0]) > 0) {
										$field_result = preg_replace('/<div class="support_channel">([^"]+)<\/div>/', '', $field_result);
										$field_result = $field_result.'<div class="flexbox-support_channel">'.implode("", $m_array[0]).'</div>';
									}
								}
								$result .= '<div class="td_container td_container_11 logos_wrapper">'.$field_result.'</div>';
								
								
							} else {
								$result .= '<div class="td_container td_container_11">'.$field_result.'</div>';
							}
							
						}
						
						//product_price
						/*if (is_user_logged_in()) {
							$result .= print_r($field);
						}*/
					}
					
					$result .= '</td>';
					$result .= '</tr>';
				}
			} elseif(in_array($field['type'],array('taxonomy')) && $field['__key'] != '') {
				$original_field = get_field_object($field['__key']);
				$field_result = simple_field($field['type'],$original_field,'review');
				
				if($field_result && !preg_match("#^(<[^>]*>)+$#", $field_result)) {
					if($field['label'] == 'Терминалы' && $company_type == 'exchange') {
						$field['label'] = __('Платформа обменника');
					} elseif($field['label'] == 'Способы пополнения' && in_array($company_type,array('deliveryfood','pharmacy','medservice','carrent','bookinghotel','bookingtickets'))) {
						$field['label'] = __('Способы оплаты заказа');
					} elseif($field['label'] == 'Способы пополнения' && in_array($company_type,array('shop'))) {
						$field['label'] = __('Способы оплаты');
					}
					
					$result .= '<tr>';
					$result .= '<th>'.$field['label'].'</th>';
					$result .= '<td>';
					$result .= '<div class="td_container td_container_4">'.$field_result.'</div>';
					$result .= '</td>';
					$result .= '</tr>';
				}
			} elseif(in_array($field['type'],array('message'))) {
				$field_result = simple_field($field['type'],$field,'review');
				$result .= '<tr>';
				$result .= '<th>'.$field['label'].'</th>';
				$result .= '<td>';
				$result .= '<div class="td_container td_container_7">'.$field_result.'</div>';
				$result .= '</td>';
				$result .= '</tr>';
				
			} elseif(in_array($field['type'],array('taxonomy','date_picker','text','textarea','range','checkbox','number'))) {
				if($field['_clone']) {
					//echo 'cloned';
				}
				if($field['__key']) {
					$original_field = get_field_object($field['__key']);
					
				} else {
					$original_field = get_field_object($field['key']);
				}
				$field_result = simple_field($field['type'],$original_field,'review');
				
				/* echo '<pre>';
					print_r($field);
				echo '</pre>';
				echo '<pre>';
					print_r($original_field);
				echo '</pre>'; */
				if($field_result && !preg_match("#^(<[^>]*>)+$#", $field_result)) {
					
					if ($field['name'] != 'cena_cross_out') {
						/*if ($field['name'] == 'product_price') {
							$result .= '<tr>';
							$result .= '<th>'.$field['label'].'</th>';
							$result .= '<td>';
							$result .= '<div class="td_container td_container_8">'.$field_result.'</div>';
							$result .= '</td>';
							$result .= '</tr>';
						} else {*/
						$result .= '<tr>';
						$result .= '<th>'.$field['label'].'</th>';
						$result .= '<td>';
						if ($field['name'] == 'company_name') {
							if (preg_match('/[\p{Cyrillic}]+/u', $field_result)) {
								$result .= '<div class="td_container td_container_9" >' . $field_result . '</div>';
							} else {
								$result .= '<div class="td_container td_container_9" data-no-translation>' . $field_result . '</div>';
							}
						} else {
							$result .= '<div class="td_container td_container_9">' . $field_result . '</div>';
						}
						
						$result .= '</td>';
						$result .= '</tr>';
						/*}*/
					}
					
				}
				
				
			}
			
			if ($field['label'] == 'Рассрочка') {
				$term_slug = get_term( get_field('company_type'), 'companytypes' )->name;
				if ($term_slug == 'shop') {
					
					$args_mfo = [
						'post_type' => array('casino'),
						'posts_per_page' => 3,
						'_shuffle_and_pick' => 3,
						'orderby'        => 'menu_order',
						'order'          => 'ASC',
						'post__in' => [28745],
						'tax_query'      => array(
							array(
								'taxonomy' => 'affiliate-tags',
								'field'    => 'name',
								'terms'    => 'mfo',
							),
						),
					];
					if ( get_locale() == 'ru_RU' ) {
						// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
						$args_mfo['turn_off_on_ru_language'] = 1;
					}
					$text_mfo = '';
					$query_mfo = new WP_Query( $args_mfo );
					if( $query_mfo->have_posts() ){
						while( $query_mfo->have_posts() ){
							$query_mfo->the_post();
							$text_mfo .= '<a class="bonus_div_link" href="/visit/'.get_field('company_redirect_key',get_the_ID()).'/" target="_blank" rel="nofollow"><div class="bonus_div"><span class="field_number">'.get_field('company_name',get_the_ID()).'<span class="get_bonus_button">Получить</span></div></a>';
							//echo get_the_permalink();
						}
					}
					wp_reset_postdata();
					$language = get_locale();
					if ($language == 'ru_RU') {
						$result .= '<tr>';
						$result .= '<th>МФО для получения займа</th>';
						$result .= '<td>';
						$result .= '<div class="td_container td_container_10">'.$text_mfo.'</div>';
						$result .= '</td>';
						$result .= '</tr>';
					}
					
				}
			}
			/*if ($field['label'] == 'Цена - перечёркнутая, оставить пустым, если не надо') {
				$result
			}*/
		}
		
		
		$result .= '</tbody></table>';
		//$result .= affiliate_link('affiliate_link',$post->ID,'cta_button','default',1);
	}
	
	return $result;
}

if(!function_exists('show_company_map')) {
	add_action( 'wp_ajax_show_company_map', 'show_company_map' );
	add_action( 'wp_ajax_nopriv_show_company_map', 'show_company_map' );
	function show_company_map() {
		$result = '';
		$post_id = $_POST['post_id'];
		$address = get_field('company_main_office',$post_id);
		
		
		$result .= '
            <style>
            #clinic-map {
                width: 100%;
                height: 231px;
                margin: 0;
                padding: 0;
            }
        </style>
        
        <script>
            ymaps.ready(init);
            function init() {
                var myMap = new ymaps.Map(\'clinic-map\', {
                    center: [55.753994, 37.622093],
                    zoom: 9
                });

                ymaps.geocode(\''.$address.'\', {
results: 1
}).then(function (res) {
var firstGeoObject = res.geoObjects.get(0),
coords = firstGeoObject.geometry.getCoordinates(),
bounds = firstGeoObject.properties.get(\'boundedBy\');
myMap.geoObjects.add(firstGeoObject);
myMap.setBounds(bounds, {
checkZoomRange: true
});
});
}
</script>

<div id="clinic-map"></div>
            
            ';
		echo $result;
		die;
	}
}

if(!function_exists('ajax_append_address')) {
	add_action( 'wp_ajax_ajax_append_address', 'ajax_append_address' );
	add_action( 'wp_ajax_nopriv_ajax_append_address', 'ajax_append_address' );
	function ajax_append_address() {
		$data = $_POST;
		$post_id = $data['post_id'];
		//echo $post_id;
		$result = '';
		$result .= review_block_address($post_id);
		echo $result;
		die;
	}
}


function ajax_append_address_php() {
	$post_id = get_the_ID();
	//echo $post_id;
	$result = '';
	$result .= review_block_address($post_id);
	return $result;
}

if(!function_exists('review_block_address')) {
	function review_block_address($post_id) {
		$result = '';
		$address = get_field('company_main_office',$post_id);
		$current_language = get_locale();
		if($current_language != 'ru_RU') {
			$address = str_replace("г. ", "", $address);
			$cyr = ['Љ', 'Њ', 'Џ', 'џ', 'ш', 'ђ', 'ч', 'ћ', 'ж', 'љ', 'њ', 'Ш', 'Ђ', 'Ч', 'Ћ', 'Ж','Ц','ц', 'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п', 'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я', 'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П', 'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
			];
			$lat = ['Lj', 'Nj', 'Dž', 'dž', 'sh', 'đ', 'ch', 'ć', 'zh', 'lj', 'nj', 'SH', 'Đ', 'CH', 'Ć', 'ZH','C','c', 'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p', 'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya', 'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P', 'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
			];
			$address = str_replace($cyr, $lat, $address);
		}
		if($address && $address != '') {
			$result .= '<div class="side_block white_block company_address_block">';
			$result .= '<div class="block_title font_smaller_2 font_bolder font_uppercase color_dark_blue">' . __('Адрес', 'er_theme') . '</div>';
			$result .= '<div class="block_content font_small">';
			$result .= $address;
			$result .= '<div class="color_dark_gray font_smaller link_review_map m_t_10 link_dropdown inactive pointer" data-post-id="'.$post_id.'">' . __('Карта', 'er_theme') . '</div>';
			$result .= '<script src="//api-maps.yandex.ru/2.1/?apikey=d6f72bfc-b860-4c1d-8b72-e17c25e1d664&lang='.$current_language.'" type="text/javascript"></script>';
			$result .= '</div>';
			$result .= '<div id="map_container"></div>';
			$result .= '</div>';
		}
		return $result;
	}
	
}

if(!function_exists('review_block_company_news')) {
	function review_block_company_news( $post_id ) {
		
		if( !$post_id ) {
			return;
		}
		
		$result = '';
		
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 5,
			'meta_key' => 'news_for_company_id',
			'meta_value' => $post_id,
		);
		
		$news = get_posts( $args );
		
		if( count( $news) ) {
			$company_title = get_field( 'company_name', $post_id );
			$company_uri = get_field( 'company_redirect_key', $post_id );
			
			$result .= '<div class="side_block white_block">';
			$result .= '<div class="block_title font_smaller_2 font_bolder font_uppercase color_dark_blue">' . __('Новости', 'er_theme') . ( strlen( $company_title ) ? ' ' .$company_title : '' ) . '</div>';
			
			foreach( $news as $post ) {
				
				$result .= '<div class="block_content font_smaller">';
				$result .= '<a href="' . get_permalink( $post->ID ) . '" target="_blank" class="color_dark_blue link_no_underline">' . $post->post_title . '</a>';
				$result .= '<div class="post_meta_date font_smaller color_dark_gray">' . wp_date( 'd F Y', strtotime( $post->post_date ) ) . '</div>';
				$result .= '</div>';
			}
			
			$result .= '<div class="block_all_link"><a href="/review/' . $company_uri . '/news/" class="font_uppercase color_blue font_smaller_2 font_bolder link_no_underline">Все новости компании</a></div></div>';
		}
		
		return $result;
		
	}
}

if(!function_exists('review_block_main_button')) {
	function review_block_main_button($post_id) {
		$result = '';
		$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
		$term_id = get_term_by('name', $term_slug, 'affiliate-tags')->term_id;
		$tag_button_text = get_field('main_button_text','term_'.$term_id);
		$button_text = get_field('review_button_text',$post_id);
		if(!$button_text || $button_text == '') {
			if($tag_button_text && $tag_button_text != '') {
				$button_text = $tag_button_text;
			} else {
				$button_text = __('Регистрация','er_theme');
			}
		}
		if(function_exists('review_redirect_link')) {
			$link = review_redirect_link($post_id);
		} else {
			$link = '';
		}
		if($link != '') {
			$result .= '<a href="'.$link.'" class="review_block_main_button button button_bigger font_medium font_bold button_violet pointer link_no_underline a4" target="_blank" rel="nofollow" data-company="">'.$button_text.'</a>';
		}
		return $result;
	}
	
}


if(!function_exists('review_block_main_button_replace_no_affilate')) {
	function review_block_main_button_replace_no_affilate($post_id) {
		$result = '';
		
		
		$company_site_affiliate_url = get_field('company_site_affiliate_url',$post_id);
		
		
		$parse_url = parse_url($company_site_affiliate_url);
		//print_r($parse_url);
		
		
		$a = 0;
		while ($a == 0) {
			if (array_key_exists('fragment', $parse_url) && (strlen($parse_url['fragment']) > 1)) {
				break;
			} elseif (array_key_exists('query', $parse_url) && (strlen($parse_url['query']) > 1)) {
				break;
			} elseif (array_key_exists('path', $parse_url)) {
				
				if (    ($parse_url['path'] == '/') || (    strlen($parse_url['path']) < 2  ) ) {
					$a = 1;
					break;
				} elseif ((strpos($parse_url['host'], 'eto-razvod.ru') !== false)) {
					$a = 1;
					break;
				} else {
					break;
				}
				
			} else {
				$a = 1;
				break;
			}
		}
		if (array_key_exists('query', $parse_url)) {
			if ( $parse_url['query'] == 'nopay' ) {
				$a = 1;
			}
		}
		
		/*$cur_terms = get_the_terms($post_id, 'affiliate-tags');
		//print_r($cur_terms[0]);
		$term_id = $cur_terms[0]->term_id;
		$term_name = $cur_terms[0]->name;*/
		
		$cur_terms = get_field('review_aff_tags',$post_id);
		$tttt = gettype($cur_terms);
		if (gettype($cur_terms) == 'array') {
			//print_r($cur_terms[0]);
			$term_id = $cur_terms[0];
			$term_name = get_term($cur_terms[0])->name;
		} else {
			$cur_terms = get_the_terms($post_id, 'affiliate-tags');
			$term_id = $cur_terms[0]->term_id;
			$term_name = $cur_terms[0]->name;
		}
		$term_name_temp = $term_name;
		
		if ($a == 1) {
			
			if(is_array($cur_terms)) {
				if (in_array(11, $cur_terms)) {
					$term_name = 'bi';
				} elseif (in_array(10, $cur_terms)) {
					$term_name = 'fx';
				}			
			}
			
			$args = array(
				'post_type'         => 'casino',
				'orderby'           => 'menu_order',
				'posts_per_page'    => 3,
				'_shuffle_and_pick' => 3,
				'order'          => 'ASC',
				'post_status' => 'publish',
				'tax_query'      => array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'name',
						'terms'    => $term_name,
					),
				),
			
			);
			if ( get_locale() == 'ru_RU' ) {
				// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
				$args['turn_off_on_ru_language'] = 1;
			}
			
			$reviews   = new WP_Query( $args );
			if ( $reviews->have_posts() ) {
				while ( $reviews->have_posts() ) {
					$reviews->the_post();
					$key = get_field('company_redirect_key',$post_id);
					$company_site_affiliate_url = get_field('company_site_affiliate_url',get_the_ID());
					
					
					$parse_url = parse_url($company_site_affiliate_url);
					//print_r($parse_url);
					
					
					$a2 = 0;
					while ($a2 == 0) {
						if (array_key_exists('query', $parse_url) && (strlen($parse_url['query']) > 1)) {
							$a2 = 1;
							$key = get_field('company_redirect_key',get_the_ID());
							$term_slug = get_term( get_field('company_type',get_the_ID()), 'companytypes' )->name;
							$term_id = get_term_by('name', $term_slug, 'affiliate-tags')->term_id;
							$tag_button_text = get_field('main_button_text','term_'.$term_id);
							
							$add_brand = get_field('add_brand','term_'.$term_id);
							
							$button_text = get_field('review_button_text',get_the_ID());
							if(!$button_text || $button_text == '') {
								if($tag_button_text && $tag_button_text != '') {
									if ($add_brand == 1) {
										if (($term_name == 'credit')) {
											$company_name = firstCharToLowercase(get_field('company_name',get_the_ID()));
											$button_text = __($tag_button_text,'er_theme').' '.$company_name;
										} elseif (($term_name == 'university')) {
											$company_name = get_field('university_short',get_the_ID());
											if ($company_name == '') {
												$company_name = get_field('company_name',get_the_ID());
											}
											$button_text = __($tag_button_text,'er_theme').' '.$company_name;
										} elseif (($term_name == 'bloggers')) {
											$company_name = get_field('company_name',get_the_ID());
											$button_text = $company_name.' '.__($tag_button_text,'er_theme');
										} elseif (($term_name == 'courses')) {
											$company_name = get_field('company_name',get_field('online_school',get_the_ID())[0]->ID);
											$button_text = __($tag_button_text,'er_theme').' '.$company_name;
										} else {
											$company_name = get_field('company_name',get_the_ID());
											$button_text = __($tag_button_text,'er_theme').' '.$company_name;
										}
									} else {
										$button_text = __($tag_button_text,'er_theme');
									}
								} else {
									$button_text = __('Регистрация','er_theme');
								}
							}
							break;
						} elseif (array_key_exists('path', $parse_url)) {
							
							if (    ($parse_url['path'] == '/') || (    strlen($parse_url['path']) < 2  ) ) {
								break;
							} elseif ((strpos($parse_url['host'], 'eto-razvod.ru') !== false)) {
								break;
							} else {
								$a2 = 1;
								$key = get_field('company_redirect_key',get_the_ID());
								$term_slug = get_term( get_field('company_type',get_the_ID()), 'companytypes' )->name;
								$term_id = get_term_by('name', $term_slug, 'affiliate-tags')->term_id;
								$tag_button_text = get_field('main_button_text','term_'.$term_id);
								
								$add_brand = get_field('add_brand','term_'.$term_id);
								
								$button_text = get_field('review_button_text',get_the_ID());
								if(!$button_text || $button_text == '') {
									if($tag_button_text && $tag_button_text != '') {
										if ($add_brand == 1) {
											if (($term_name == 'credit')) {
												$company_name = firstCharToLowercase(get_field('company_name',get_the_ID()));
												$button_text = __($tag_button_text,'er_theme').' '.$company_name;
											} elseif (($term_name == 'university')) {
												$company_name = get_field('university_short',get_the_ID());
												if ($company_name == '') {
													$company_name = get_field('company_name',get_the_ID());
												}
												$button_text = __($tag_button_text,'er_theme').' '.$company_name;
											} elseif (($term_name == 'bloggers')) {
												$company_name = get_field('company_name',get_the_ID());
												$button_text = $company_name.' '.__($tag_button_text,'er_theme');
											} elseif (($term_name == 'courses')) {
												$company_name = get_field('company_name',get_field('online_school',get_the_ID())[0]->ID);
												$button_text = __($tag_button_text,'er_theme').' '.$company_name;
											} else {
												$company_name = get_field('company_name',get_the_ID());
												$button_text = __($tag_button_text,'er_theme').' '.$company_name;
											}
										} else {
											$button_text = __($tag_button_text,'er_theme');
										}
									} else {
										$button_text = __('Регистрация','er_theme');
									}
								}
								break;
							}
							
						} else {
							break;
						}
						
					}
					if ($a2 == 1) {
						break;
					}
				}
			} else {
				$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
				$term_id = get_term_by('name', $term_slug, 'affiliate-tags')->term_id;
				$tag_button_text = get_field('main_button_text','term_'.$term_id);
				
				$add_brand = get_field('add_brand','term_'.$term_id);
				
				$button_text = get_field('review_button_text',$post_id);
				if(!$button_text || $button_text == '') {
					if($tag_button_text && $tag_button_text != '') {
						if ($add_brand == 1) {
							if (($term_name == 'credit')) {
								$company_name = firstCharToLowercase(get_field('company_name',$post_id));
								$button_text = __($tag_button_text,'er_theme').' '.$company_name;
							} elseif (($term_name == 'university')) {
								$company_name = get_field('university_short',$post_id);
								if ($company_name == '') {
									$company_name = get_field('company_name',$post_id);
								}
								$button_text = __($tag_button_text,'er_theme').' '.$company_name;
							} elseif (($term_name == 'bloggers')) {
								$company_name = get_field('company_name',$post_id);
								$button_text = $company_name.' '.__($tag_button_text,'er_theme');
							} elseif (($term_name == 'courses')) {
								$company_name = get_field('company_name',get_field('online_school',$post_id)[0]->ID);
								$button_text = __($tag_button_text,'er_theme').' '.$company_name;
							} else {
								$company_name = get_field('company_name',$post_id);
								$button_text = __($tag_button_text,'er_theme').' '.$company_name;
							}
						} else {
							$button_text = $tag_button_text;
						}
					} else {
						$button_text = __('Регистрация','er_theme');
					}
				}
				$key = get_field('company_redirect_key',$post_id);
			}
			wp_reset_postdata();
		} else {
			$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
			$term_id = get_term_by('name', $term_slug, 'affiliate-tags')->term_id;
			$tag_button_text = get_field('main_button_text','term_'.$term_id);
			
			$add_brand = get_field('add_brand','term_'.$term_id);
			
			$button_text = get_field('review_button_text',$post_id);
			if(!$button_text || $button_text == '') {
				if($tag_button_text && $tag_button_text != '') {
					if ($add_brand == 1) {
						if (($term_name == 'credit')) {
							$company_name = firstCharToLowercase(get_field('company_name',$post_id));
							$button_text = __($tag_button_text,'er_theme').' '.$company_name;
						} elseif (($term_name == 'university')) {
							$company_name = get_field('university_short',$post_id);
							if ($company_name == '') {
								$company_name = get_field('company_name',$post_id);
							}
							$button_text = __($tag_button_text,'er_theme').' '.$company_name;
						} elseif (($term_name == 'bloggers')) {
							$company_name = get_field('company_name',$post_id);
							$button_text = $company_name.' '.__($tag_button_text,'er_theme');
						} elseif (($term_name == 'courses')) {
							if (get_field('sklon_courses',get_field('online_school',$post_id)[0]->ID)) {
								$company_name = get_field('sklon_courses',get_field('online_school',$post_id)[0]->ID);
							} else {
								$company_name = get_field('company_name',get_field('online_school',$post_id)[0]->ID);
							}
							//$company_name = get_field('company_name',get_field('online_school',$post_id)[0]->ID);
							$button_text = __($tag_button_text,'er_theme').' '.$company_name;
						} else {
							$company_name = get_field('company_name',$post_id);
							$button_text = __($tag_button_text,'er_theme').' '.$company_name;
						}
						
					} else {
						$button_text = $tag_button_text;
					}
				} else {
					$button_text = __('Регистрация','er_theme');
				}
			}
			$key = get_field('company_redirect_key',$post_id);
		}
		
		
		
		
		/*if(function_exists('review_redirect_link_replace_no_affilate')) {
			$link = review_redirect_link_replace_no_affilate($post_id);
		} else {
			$link = '';
		}*/
		
		if ($key == '') {
			$link = review_redirect_link($post_id);
		} else {
			$link = get_bloginfo('url').'/visit/'.$key.'/';
		}
		
		if ($button_text == '') {
			$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
			$term_id = get_term_by('name', $term_slug, 'affiliate-tags')->term_id;
			
			$tag_button_text = get_field('main_button_text','term_'.$term_id);
			
			$add_brand = get_field('add_brand','term_'.$term_id);
			
			$button_text = get_field('review_button_text',$post_id);
			if(!$button_text || $button_text == '') {
				if($tag_button_text && $tag_button_text != '') {
					if ($add_brand == 1) {
						if (($term_name == 'credit')) {
							$company_name = firstCharToLowercase(get_field('company_name',$post_id));
							$button_text = __($tag_button_text,'er_theme').' '.$company_name;
						} elseif (($term_name == 'university')) {
							$company_name = get_field('university_short',$post_id);
							if ($company_name == '') {
								$company_name = get_field('company_name',$post_id);
							}
							$button_text = __($tag_button_text,'er_theme').' '.$company_name;
						} elseif (($term_name == 'bloggers')) {
							$company_name = get_field('company_name',$post_id);
							$button_text = $company_name.' '.__($tag_button_text,'er_theme');
						} elseif (($term_name == 'courses')) {
							$company_name = get_field('company_name',get_field('online_school',$post_id)[0]->ID);
							$button_text = __($tag_button_text,'er_theme').' '.$company_name;
						}  else {
							$company_name = get_field('company_name',$post_id);
							$button_text = __($tag_button_text,'er_theme').' '.$company_name;
						}
						
					} else {
						$button_text = $tag_button_text;
					}
				} else {
					$button_text = __('Регистрация','er_theme');
				}
			}
			
			//$button_text = __('Регистрация','er_theme');
		}
		
		if($link != '') {
			if ($term_name == 'mfo' && $a == 1 && get_locale() == 'ru_RU') {
				$result .= '<a href="/visit/max-credit/" class="review_block_main_button button button_bigger font_medium font_bold button_violet pointer link_no_underline a2" target="_blank" rel="nofollow">Взять займ в Макс.Кредит</a>';
			} else {
				$result .= '<a href="'.$link.'" class="review_block_main_button button button_bigger font_medium font_bold button_violet pointer link_no_underline a2" target="_blank" rel="nofollow">'.$button_text.'</a>';
			}
		}
		return $result;
	}
	
}

if(!function_exists('review_block_main_button_replace_no_affilate_test')) {
	function review_block_main_button_replace_no_affilate_test($post_id) {
		$result = '';
		
		
		$company_site_affiliate_url = get_field('company_site_affiliate_url',$post_id);
		
		
		$parse_url = parse_url($company_site_affiliate_url);
		//print_r($parse_url);
		
		
		$a = 0;
		while ($a == 0) {
			if (array_key_exists('fragment', $parse_url) && (strlen($parse_url['fragment']) > 1)) {
				break;
			} elseif (array_key_exists('query', $parse_url) && (strlen($parse_url['query']) > 1)) {
				break;
			} elseif (array_key_exists('path', $parse_url)) {
				
				if (    ($parse_url['path'] == '/') || (    strlen($parse_url['path']) < 2  ) ) {
					$a = 1;
					break;
				} elseif ((strpos($parse_url['host'], 'eto-razvod.ru') !== false)) {
					$a = 1;
					break;
				} else {
					break;
				}
				
			} else {
				$a = 1;
				break;
			}
		}
		if (array_key_exists('query', $parse_url)) {
			if ( $parse_url['query'] == 'nopay' ) {
				$a = 1;
			}
		}
		
		/*$cur_terms = get_the_terms($post_id, 'affiliate-tags');
		//print_r($cur_terms[0]);
		$term_id = $cur_terms[0]->term_id;
		$term_name = $cur_terms[0]->name;*/
		
		$cur_terms = get_field('review_aff_tags',$post_id);
		$tttt = gettype($cur_terms);
		if (gettype($cur_terms) == 'array') {
			//print_r($cur_terms[0]);
			$term_id = $cur_terms[0];
			$term_name = get_term($cur_terms[0])->name;
		} else {
			$cur_terms = get_the_terms($post_id, 'affiliate-tags');
			$term_id = $cur_terms[0]->term_id;
			$term_name = $cur_terms[0]->name;
		}
		$term_name_temp = $term_name;
		
		if ($a == 1) {
			
			
			if (in_array(11,$cur_terms)) {
				$term_name = 'bi';
			} elseif (in_array(10,$cur_terms)) {
				$term_name = 'fx';
			}
			
			$args = array(
				'post_type'         => 'casino',
				'orderby'           => 'menu_order',
				'posts_per_page'    => 3,
				'_shuffle_and_pick' => 3,
				'order'          => 'ASC',
				'post_status' => 'publish',
				'tax_query'      => array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'name',
						'terms'    => $term_name,
					),
				),
			
			);
			if ( get_locale() == 'ru_RU' ) {
				// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
				$args['turn_off_on_ru_language'] = 1;
			}
			
			$reviews   = new WP_Query( $args );
			if ( $reviews->have_posts() ) {
				while ( $reviews->have_posts() ) {
					$reviews->the_post();
					$key = get_field('company_redirect_key',$post_id);
					$company_site_affiliate_url = get_field('company_site_affiliate_url',get_the_ID());
					
					
					$parse_url = parse_url($company_site_affiliate_url);
					//print_r($parse_url);
					
					
					$a2 = 0;
					while ($a2 == 0) {
						if (array_key_exists('query', $parse_url) && (strlen($parse_url['query']) > 1)) {
							$a2 = 1;
							$key = get_field('company_redirect_key',get_the_ID());
							$term_slug = get_term( get_field('company_type',get_the_ID()), 'companytypes' )->name;
							$term_id = get_term_by('name', $term_slug, 'affiliate-tags')->term_id;
							$tag_button_text = get_field('main_button_text','term_'.$term_id);
							
							$add_brand = get_field('add_brand','term_'.$term_id);
							
							$button_text = get_field('review_button_text',get_the_ID());
							if(!$button_text || $button_text == '') {
								if($tag_button_text && $tag_button_text != '') {
									if ($add_brand == 1) {
										if (($term_name == 'credit')) {
											$company_name = firstCharToLowercase(get_field('company_name',get_the_ID()));
											$button_text = __($tag_button_text,'er_theme').' '.$company_name;
										} elseif (($term_name == 'university')) {
											$company_name = get_field('university_short',get_the_ID());
											if ($company_name == '') {
												$company_name = get_field('company_name',get_the_ID());
											}
											$button_text = __($tag_button_text,'er_theme').' '.$company_name;
										} elseif (($term_name == 'bloggers')) {
											$company_name = get_field('company_name',get_the_ID());
											$button_text = $company_name.' '.__($tag_button_text,'er_theme');
										} else {
											$company_name = get_field('company_name',get_the_ID());
											$button_text = __($tag_button_text,'er_theme').' '.$company_name;
										}
									} else {
										$button_text = __($tag_button_text,'er_theme');
									}
								} else {
									$button_text = __('Регистрация','er_theme');
								}
							}
							break;
						} elseif (array_key_exists('path', $parse_url)) {
							
							if (    ($parse_url['path'] == '/') || (    strlen($parse_url['path']) < 2  ) ) {
								break;
							} elseif ((strpos($parse_url['host'], 'eto-razvod.ru') !== false)) {
								break;
							} else {
								$a2 = 1;
								$key = get_field('company_redirect_key',get_the_ID());
								$term_slug = get_term( get_field('company_type',get_the_ID()), 'companytypes' )->name;
								$term_id = get_term_by('name', $term_slug, 'affiliate-tags')->term_id;
								$tag_button_text = get_field('main_button_text','term_'.$term_id);
								
								$add_brand = get_field('add_brand','term_'.$term_id);
								
								$button_text = get_field('review_button_text',get_the_ID());
								if(!$button_text || $button_text == '') {
									if($tag_button_text && $tag_button_text != '') {
										if ($add_brand == 1) {
											if (($term_name == 'credit')) {
												$company_name = firstCharToLowercase(get_field('company_name',get_the_ID()));
												$button_text = __($tag_button_text,'er_theme').' '.$company_name;
											} elseif (($term_name == 'university')) {
												$company_name = get_field('university_short',get_the_ID());
												if ($company_name == '') {
													$company_name = get_field('company_name',get_the_ID());
												}
												$button_text = __($tag_button_text,'er_theme').' '.$company_name;
											} elseif (($term_name == 'bloggers')) {
												$company_name = get_field('company_name',get_the_ID());
												$button_text = $company_name.' '.__($tag_button_text,'er_theme');
											} else {
												$company_name = get_field('company_name',get_the_ID());
												$button_text = __($tag_button_text,'er_theme').' '.$company_name;
											}
										} else {
											$button_text = __($tag_button_text,'er_theme');
										}
									} else {
										$button_text = __('Регистрация','er_theme');
									}
								}
								break;
							}
							
						} else {
							break;
						}
						
					}
					if ($a2 == 1) {
						break;
					}
				}
			} else {
				$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
				$term_id = get_term_by('name', $term_slug, 'affiliate-tags')->term_id;
				$tag_button_text = get_field('main_button_text','term_'.$term_id);
				
				$add_brand = get_field('add_brand','term_'.$term_id);
				
				$button_text = get_field('review_button_text',$post_id);
				if(!$button_text || $button_text == '') {
					if($tag_button_text && $tag_button_text != '') {
						if ($add_brand == 1) {
							if (($term_name == 'credit')) {
								$company_name = firstCharToLowercase(get_field('company_name',$post_id));
								$button_text = __($tag_button_text,'er_theme').' '.$company_name;
							} elseif (($term_name == 'university')) {
								$company_name = get_field('university_short',$post_id);
								if ($company_name == '') {
									$company_name = get_field('company_name',$post_id);
								}
								$button_text = __($tag_button_text,'er_theme').' '.$company_name;
							} elseif (($term_name == 'bloggers')) {
								$company_name = get_field('company_name',$post_id);
								$button_text = $company_name.' '.__($tag_button_text,'er_theme');
							} else {
								$company_name = get_field('company_name',$post_id);
								$button_text = __($tag_button_text,'er_theme').' '.$company_name;
							}
						} else {
							$button_text = $tag_button_text;
						}
					} else {
						$button_text = __('Регистрация','er_theme');
					}
				}
				$key = get_field('company_redirect_key',$post_id);
			}
			wp_reset_postdata();
		} else {
			$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
			$term_id = get_term_by('name', $term_slug, 'affiliate-tags')->term_id;
			$tag_button_text = get_field('main_button_text','term_'.$term_id);
			
			$add_brand = get_field('add_brand','term_'.$term_id);
			
			$button_text = get_field('review_button_text',$post_id);
			if(!$button_text || $button_text == '') {
				if($tag_button_text && $tag_button_text != '') {
					if ($add_brand == 1) {
						if (($term_name == 'credit')) {
							$company_name = firstCharToLowercase(get_field('company_name',$post_id));
							$button_text = __($tag_button_text,'er_theme').' '.$company_name;
						} elseif (($term_name == 'university')) {
							$company_name = get_field('university_short',$post_id);
							if ($company_name == '') {
								$company_name = get_field('company_name',$post_id);
							}
							$button_text = __($tag_button_text,'er_theme').' '.$company_name;
						} elseif (($term_name == 'bloggers')) {
							$company_name = get_field('company_name',$post_id);
							$button_text = $company_name.' '.__($tag_button_text,'er_theme');
						} else {
							$company_name = get_field('company_name',$post_id);
							$button_text = __($tag_button_text,'er_theme').' '.$company_name;
						}
						
					} else {
						$button_text = $tag_button_text;
					}
				} else {
					$button_text = __('Регистрация','er_theme');
				}
			}
			$key = get_field('company_redirect_key',$post_id);
		}
		
		
		
		
		/*if(function_exists('review_redirect_link_replace_no_affilate')) {
			$link = review_redirect_link_replace_no_affilate($post_id);
		} else {
			$link = '';
		}*/
		
		if ($key == '') {
			$link = review_redirect_link($post_id);
		} else {
			$link = get_bloginfo('url').'/visit/'.$key.'/';
		}
		
		if ($button_text == '') {
			$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
			$term_id = get_term_by('name', $term_slug, 'affiliate-tags')->term_id;
			
			$tag_button_text = get_field('main_button_text','term_'.$term_id);
			
			$add_brand = get_field('add_brand','term_'.$term_id);
			
			$button_text = get_field('review_button_text',$post_id);
			if(!$button_text || $button_text == '') {
				if($tag_button_text && $tag_button_text != '') {
					if ($add_brand == 1) {
						if (($term_name == 'credit')) {
							$company_name = firstCharToLowercase(get_field('company_name',$post_id));
							$button_text = __($tag_button_text,'er_theme').' '.$company_name;
						} elseif (($term_name == 'university')) {
							$company_name = get_field('university_short',$post_id);
							if ($company_name == '') {
								$company_name = get_field('company_name',$post_id);
							}
							$button_text = __($tag_button_text,'er_theme').' '.$company_name;
						} elseif (($term_name == 'bloggers')) {
							$company_name = get_field('company_name',$post_id);
							$button_text = $company_name.' '.__($tag_button_text,'er_theme');
						} else {
							$company_name = get_field('company_name',$post_id);
							$button_text = __($tag_button_text,'er_theme').' '.$company_name;
						}
						
					} else {
						$button_text = $tag_button_text;
					}
				} else {
					$button_text = __('Регистрация','er_theme');
				}
			}
			
			//$button_text = __('Регистрация','er_theme');
		}
		
		if($link != '') {
			$result .= '<a href="'.$link.'" class="review_block_main_button button button_bigger font_medium font_bold button_violet pointer link_no_underline a3" target="_blank" rel="nofollow">'.$button_text.'</a>';
		}
		return $result;
	}
	
}
if(!function_exists('get_ad_text')) {
	function get_ad_text ($post_id) {

		$company_url = get_field('websites',$post_id);
		$legal_name = get_field('company_legal',$post_id);
		$company_site_affiliate_url = get_field('company_site_affiliate_url',$post_id);
		$website = '';
		if (!empty($company_url) && $company_url[0]['site_url'] != '') {
			$website = str_ireplace('www.', '', parse_url($company_url[0]['site_url'], PHP_URL_HOST));
		}
		if (!empty($legal_name) && $legal_name[0]['name'] != '') {
			$name = $legal_name[0]['name'];
		} elseif (!empty($company_url) && $company_url[0]['site_url'] != '') {
			$name = str_ireplace('www.', '', parse_url($company_url[0]['site_url'], PHP_URL_HOST));

		} else {
			$name = '';
		}

		$ad_text = '';
		if($name != '' && $company_site_affiliate_url != ''
			&& !in_array(str_ireplace('www.', '', parse_url($company_site_affiliate_url, PHP_URL_HOST)), array('etorazvod.ru', 'eto-razvod.ru', $website))

		) {
			$ad_text .= '<div class="font_small color_dark_gray text_centered m_b_15" id="notice_ad">';
	//				$ad_text .= $website;
	//				$ad_text .= ' ';
	//				$ad_text .= str_ireplace('www.', '', parse_url($company_site_affiliate_url, PHP_URL_HOST));
			$ad_text .= __('Реклама','er_theme').' ';
			$ad_text .= $name;
			$ad_text .= '</div>';
		}



		return $ad_text;
	}
}


if(!function_exists('get_ad_text_show')) {
	add_action( 'wp_ajax_get_ad_text_show', 'get_ad_text_show' );
	add_action( 'wp_ajax_nopriv_get_ad_text_show', 'get_ad_text_show' );
	function get_ad_text_show() {
		$result = '';
		$post_id = $_POST['post_id'];
		if ( $post_id != '' ) {
			$result .= get_ad_text ($post_id);
		}
		echo $result;

		die;


	}
}
