<?php

if (!function_exists('banner_popup_ajax')) {
	add_action( 'wp_ajax_banner_popup_ajax', 'banner_popup_ajax' );
	add_action( 'wp_ajax_nopriv_banner_popup_ajax', 'banner_popup_ajax' );

	function banner_popup_ajax(){
		//print_r($_POST);
		show_popup_old( $_POST['post_id']);
		die;
	}
}
if (!function_exists('check_cookie_old')) {
	add_action( 'wp_ajax_check_cookie_old', 'check_cookie_old' ); // wp_ajax_{ЗНАЧЕНИЕ ПАРАМЕТРА ACTION!!}
	add_action( 'wp_ajax_nopriv_check_cookie_old', 'check_cookie_old' );  // wp_ajax_nopriv_{ЗНАЧЕНИЕ ACTION!!}
// первый хук для авторизованных, второй для не авторизованных пользователей

	function check_cookie_old() {
		$cookie_id = $_POST['cookie_id'];
		$cookie_id_2 = $_POST['cookie_id_2'];
		if(isset($_COOKIE[$cookie_id]) || isset($_COOKIE[$cookie_id_2])) {
			$result = 'yes';
		} else {
			$result = 'no';
		}
		echo $result;
	}
}

if (!function_exists('show_popup_old')) {
	
	function show_popup_old($post_id) {
		$current_language = get_locale();
		if(get_post_type($post_id) == 'addpages') {
			
			$review_id = get_field('addpage_review',$post_id);
			$post_id = $review_id;
		} elseif(get_post_type($post_id) == 'promocodes') {
			$review_id = get_field('promocode_review',$post_id);
			$post_id = $review_id;
		}
		$result = '';
		$banners = array();
		
		$r_q_args = array(
			'post_type' => 'banners',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'orderby' => 'rand',
			'meta_query' => array(
				'relation'		=> 'AND',
				array(
					'key' => 'banner_posts',
					'value' => serialize( strval( $post_id ) ),
					'compare' => 'LIKE'
				),
				array(
					'key'	 	=> 'banner_place',
					'value'	  	=> array('popup','popup_quiz','popup_quiz_vote'),
					'compare' 	=> 'IN',
				)
			)
		);
		if($current_language != 'ru_RU') {
			$r_q_args['meta_query'][] = array(
				'key'     => 'enable_translations',
				'value'   => $current_language,
				'compare' => 'LIKE'
			);
		}
		$reverse_query = get_posts($r_q_args);
		$a = 0;
		if(!empty($reverse_query)) {
			$a .= 1;//banner_posts_ignore
			foreach ($reverse_query as $item) {
				
				$a .= 333;
				
				if (get_field('geo_target_city',$item->ID) && get_field('geo_target_city',$item->ID) != '') {
					$ip          = $_SERVER['HTTP_X_FORWARDED_FOR'];
					$SxGeo       = new SxGeo( TEMPLATEPATH . '/inc/SxGeoCity.dat' );
					$city        = $SxGeo->get( $ip );
					$detect_city_banner = $city['city']['name_ru'];
					$geo_target_city = get_field('geo_target_city',$item->ID);
					$geo_target_city = explode( ',', $geo_target_city );
					if ($detect_city_banner == '') {
						$detect_city_banner = 'aaaaaaaaaaaaaaaaaaaaaaaaa';
					}
					if (in_array($detect_city_banner,$geo_target_city)) {
					
					} else {
						continue;
					}
				}
				
				
				if($current_language == 'ru_RU' && !empty(get_field('enable_translations',$item->ID))) {
					continue;
				}
				$trigger = get_field('banner_triggers',$item->ID);
				if($trigger && $trigger == 'seconds_after_load') {
					if(get_field('banner_seconds',$item->ID)) {
						$seconds = get_field('banner_seconds',$item->ID)*1000;
					} else {
						$seconds = 17000;
					}
				} else {
					$seconds = 0;
				}
				$banners[] = array(
					'id' => $item->ID,
					'time' => $seconds
				);
			}
		}
		$term_list = wp_get_post_terms( $post_id, 'affiliate-tags', array('fields' => 'ids') );
		if(!empty($term_list)) {
			$a .= 2;
			$r_q_args_by_tags = array(
				'post_type' => 'banners',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'orderby' => 'rand',
				'meta_query'	=> array(
					'relation'		=> 'AND',
					array(
						'key'	 	=> 'banner_place',
						'value'	  	=> array('popup','popup_quiz','popup_quiz_vote'),
						'compare' 	=> 'IN',
					),
					array(
						'key'	 	=> 'banner_default',
						'value'	  	=> 1,
						'compare' 	=> '!=',
					)
				),
				'tax_query' => array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'id',
						'terms'    => $term_list,
					),
				),
			);
			if($current_language != 'ru_RU') {
				$r_q_args_by_tags['meta_query'][] = array(
					'key'     => 'enable_translations',
					'value'   => $current_language,
					'compare' => 'LIKE'
				);
			}
			$by_tags = get_posts($r_q_args_by_tags);
			$if_quiz = 0;
			if(!empty($by_tags)) {
				//banner_posts_ignore
				foreach ($by_tags as $item) {
					
					if (get_field('geo_target_city',$item->ID) && get_field('geo_target_city',$item->ID) != '') {
						$ip          = $_SERVER['HTTP_X_FORWARDED_FOR'];
						$SxGeo       = new SxGeo( TEMPLATEPATH . '/inc/SxGeoCity.dat' );
						$city        = $SxGeo->get( $ip );
						$detect_city_banner = $city['city']['name_ru'];
						if ($detect_city_banner == '') {
							$detect_city_banner = 'aaaaaaaaaaaaaaaaaaaaaaaaa';
						}
						$geo_target_city = get_field('geo_target_city',$item->ID);
						$geo_target_city = explode( ',', $geo_target_city );
						
						if (in_array($detect_city_banner,$geo_target_city)) {
						
						} else {
							continue;
						}
					}
					
					if($current_language == 'ru_RU' && !empty(get_field('enable_translations',$item->ID))) {
						continue;
					}
					$trigger = get_field('banner_triggers',$item->ID);
					if($trigger && $trigger == 'seconds_after_load') {
						if(get_field('banner_seconds',$item->ID)) {
							$seconds = get_field('banner_seconds',$item->ID)*1000;
						} else {
							$seconds = 17000;
						}
					} else {
						$seconds = 0;
					}
					$banners[] = array(
						'id' => $item->ID,
						'time' => $seconds
					);
					
					if (get_field('banner_place',$item->ID) == 'popup_quiz') {
						$if_quiz = 1;
					}
				}
			}
		}
		
		if(empty($banners) && !empty($term_list)) {
			$a .= 3;
			$r_q_args_by_default = array(
				'post_type' => 'banners',
				'posts_per_page' => -1,
				'orderby' => 'rand',
				'post_status' => 'publish',
				'meta_query'	=> array(
					'relation'		=> 'AND',
					array(
						'key'	 	=> 'banner_default',
						'value'	  	=> 1,
						'compare' 	=> '=',
					),
					array(
						'key'	 	=> 'banner_place',
						'value'	  	=> array('popup','popup_quiz'),
						'compare' 	=> 'IN',
					)
				),
				'tax_query' => array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'id',
						'terms'    => $term_list,
					),
				),
			);
			if($current_language != 'ru_RU') {
				$r_q_args_by_default['meta_query'][] = array(
					'key'     => 'enable_translations',
					'value'   => $current_language,
					'compare' => 'LIKE'
				);
			}
			$default = get_posts($r_q_args_by_default);
			
			if(!empty($default)) {
				//banner_posts_ignore
				foreach ($default as $item) {
					
					if ( get_field( 'geo_target_city', $item->ID ) && get_field( 'geo_target_city', $item->ID ) != '' ) {
						$ip                 = $_SERVER['HTTP_X_FORWARDED_FOR'];
						$SxGeo              = new SxGeo( TEMPLATEPATH . '/inc/SxGeoCity.dat' );
						$city               = $SxGeo->get( $ip );
						$detect_city_banner = $city['city']['name_ru'];
						if ($detect_city_banner == '') {
							$detect_city_banner = 'aaaaaaaaaaaaaaaaaaaaaaaaa';
						}
						$geo_target_city    = get_field( 'geo_target_city', $item->ID );
						$geo_target_city    = explode( ',', $geo_target_city );
						
						if ( in_array( $detect_city_banner, $geo_target_city ) ) {
						
						} else {
							continue;
						}
					}
					
					if($current_language == 'ru_RU' && !empty(get_field('enable_translations',$item->ID))) {
						continue;
					}
					$trigger = get_field('banner_triggers',$item->ID);
					if($trigger && $trigger == 'seconds_after_load') {
						if(get_field('banner_seconds',$item->ID)) {
							$seconds = get_field('banner_seconds',$item->ID)*1000;
						} else {
							$seconds = 17000;
						}
					} else {
						$seconds = 0;
					}
					$banners[] = array(
						'id' => $item->ID,
						'time' => $seconds
					);
				}
			}
		}
		
		if(count($banners) == 1 && $if_quiz == 1 && !empty($term_list)) {
			$a .= 3.5;
			$r_q_args_by_default = array(
				'post_type' => 'banners',
				'posts_per_page' => -1,
				'orderby' => 'rand',
				'post_status' => 'publish',
				'meta_query'	=> array(
					'relation'		=> 'AND',
					array(
						'key'	 	=> 'banner_default',
						'value'	  	=> 1,
						'compare' 	=> '=',
					),
					array(
						'key'	 	=> 'banner_place',
						'value'	  	=> array('popup','popup_quiz'),
						'compare' 	=> 'IN',
					)
				),
				'tax_query' => array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'id',
						'terms'    => $term_list,
					),
				)
			);
			if($current_language != 'ru_RU') {
				$r_q_args_by_default['meta_query'][] = array(
					'key'     => 'enable_translations',
					'value'   => $current_language,
					'compare' => 'LIKE'
				);
			}
			$default = get_posts($r_q_args_by_default);
			
			if(!empty($default)) {
				//banner_posts_ignore
				foreach ($default as $item) {
					
					if ( get_field( 'geo_target_city', $item->ID ) && get_field( 'geo_target_city', $item->ID ) != '' ) {
						$ip                 = $_SERVER['HTTP_X_FORWARDED_FOR'];
						$SxGeo              = new SxGeo( TEMPLATEPATH . '/inc/SxGeoCity.dat' );
						$city               = $SxGeo->get( $ip );
						$detect_city_banner = $city['city']['name_ru'];
						if ($detect_city_banner == '') {
							$detect_city_banner = 'aaaaaaaaaaaaaaaaaaaaaaaaa';
						}
						$geo_target_city    = get_field( 'geo_target_city', $item->ID );
						$geo_target_city    = explode( ',', $geo_target_city );
						
						if ( in_array( $detect_city_banner, $geo_target_city ) ) {
						
						} else {
							continue;
						}
					}
					
					if($current_language == 'ru_RU' && !empty(get_field('enable_translations',$item->ID))) {
						continue;
					}
					$trigger = get_field('banner_triggers',$item->ID);
					if($trigger && $trigger == 'seconds_after_load') {
						if(get_field('banner_seconds',$item->ID)) {
							$seconds = get_field('banner_seconds',$item->ID)*1000;
						} else {
							$seconds = 17000;
						}
					} else {
						$seconds = 0;
					}
					$banners[] = array(
						'id' => $item->ID,
						'time' => $seconds
					);
				}
			}
		}
		
		//print_r($banners);
		if(!empty($banners)) {
			$a .= 4;
			function cmp_by_optionNumber($a, $b) {
				return $a["time"] - $b["time"];
			}
			usort($banners, "cmp_by_optionNumber");
			//	print_r($banners);
			$x = 0;
			foreach ($banners as $item) {
				if (get_field('banner_posts_ignore',$item['id'])) {
					if (gettype(get_field('banner_posts_ignore',$item['id'])) == 'array') {
						if (!empty($post_id)) {
							if (get_post_type($post_id) == 'casino') {
								if (in_array($post_id,get_field('banner_posts_ignore',$item['id']))) {
									continue;
								}
							}
						}
					}
				}
				$x++;
				$rows = get_field('banner_links',$item['id']);
				$banner_type = get_field('banner_type',$item['id']);
				$banner_place = get_field('banner_place',$item['id']);
				$trigger = get_field('banner_triggers',$item['id']);
				$seconds = $item['time'];
				$i = 0;
				if($rows && !empty($rows)) {
					shuffle( $rows );
					foreach($rows as $row) {
						$link_active = $row['banner_link_active'];
						if ($row['banner_link']) {
							$i++;
							$link = $row['banner_link'];
							if($i==2) {
								break;
							};
						} else {
							continue;
						}
					}
				}
				if ($banner_type == 'image') {
					if ($banner_place == 'popup_quiz') {
						if (get_field('link_bot_color_text',$item['id'])) {
							$color = get_field('link_bot_color_text',$item['id']);
						} else {
							$color = '#FFF';
						}
						$banner_content = '';
						if (get_field('link_bot_zagolovok',$item['id'])) {
							$banner_content .= '<span class="title_quiz" style="color:'.$color.'">'.get_field('link_bot_zagolovok',$item['id']).'</span>';
						}
						if (get_field('link_bot_text',$item['id'])) {
							$banner_content .= '<span class="desc_quiz" style="color:'.$color.'">'.get_field('link_bot_text',$item['id']).'</span>';
						}
						$banner_content .= '<div class="social_links_quiz">';
						
						
						if (get_field('link_bot_links_viber_link',$item['id'])) {
							if (get_field('link_bot_links_viber_text',$item['id'])) {
								$text = get_field('link_bot_links_viber_text',$item['id']);
							} else {
								$text = 'Viber';
							}
							$banner_content .= '<a href="'.get_field('link_bot_links_viber_link',$item['id']).'" class="link viber" data-id="'.$item['id'].'"><img src="/wp-content/themes/eto-razvod-1/img/viber.svg" alt="">'.$text.'</a>';
						}
						
						if (get_field('link_bot_links_telegram_link',$item['id'])) {
							if (get_field('link_bot_links_telegram_text',$item['id'])) {
								$text = get_field('link_bot_links_telegram_text',$item['id']);
							} else {
								$text = 'Telegram';
							}
							$banner_content .= '<a href="'.get_field('link_bot_links_telegram_link',$item['id']).'" class="link telegram" data-id="'.$item['id'].'"><img src="/wp-content/themes/eto-razvod-1/img/telegram.svg" alt="">'.$text.'</a>';
						}
						$banner_content .= '</div>';
						
					} else {
						$image = get_field('banner_file',$item['id']);
						if($image) {
							$banner_content = '<img data-img="'.$image['url'].'" class="b_img_main" src="'.$image['url'].'" />';
						} else {
							$banner_content = get_the_title();
						}
					}
					
				} elseif ($banner_type == 'text_button') {
					if (get_field('banner_text_button',$item['id'])) {
						$banner_content = get_field('banner_text_button',$item['id']);
					} else {
						$banner_content = __('Перейти','er_theme');
					}
				} elseif ($banner_type == 'image_random') {
					if ($banner_place == 'popup_quiz') {
						if (get_field('link_bot_color_text',$item['id'])) {
							$color = get_field('link_bot_color_text',$item['id']);
						} else {
							$color = '#FFF';
						}
						$banner_content = '';
						if (get_field('link_bot_zagolovok',$item['id'])) {
							$banner_content .= '<span class="title_quiz" style="color:'.$color.'">'.get_field('link_bot_zagolovok',$item['id']).'</span>';
						}
						if (get_field('link_bot_text',$item['id'])) {
							$banner_content .= '<span class="desc_quiz" style="color:'.$color.'">'.get_field('link_bot_text',$item['id']).'</span>';
						}
						$banner_content .= '<div class="social_links_quiz">';
						
						
						if (get_field('link_bot_links_viber_link',$item['id'])) {
							if (get_field('link_bot_links_viber_text',$item['id'])) {
								$text = get_field('link_bot_links_viber_text',$item['id']);
							} else {
								$text = 'Viber';
							}
							$banner_content .= '<a href="'.get_field('link_bot_links_viber_link',$item['id']).'" class="link viber" data-id="'.$item['id'].'"><img src="/wp-content/themes/eto-razvod-1/img/viber.svg" alt="">'.$text.'</a>';
						}
						
						if (get_field('link_bot_links_telegram_link',$item['id'])) {
							if (get_field('link_bot_links_telegram_text',$item['id'])) {
								$text = get_field('link_bot_links_telegram_text',$item['id']);
							} else {
								$text = 'Telegram';
							}
							$banner_content .= '<a href="'.get_field('link_bot_links_telegram_link',$item['id']).'" class="link telegram" data-id="'.$item['id'].'"><img src="/wp-content/themes/eto-razvod-1/img/telegram.svg" alt="">'.$text.'</a>';
						}
						$banner_content .= '</div>';
						
					} else {
						
						/*$arr = [];
						$arr[] = '1';
						foreach (get_field('images_random',202260)  as $item ) {
							$arr[] = $item['randimg']['url'];
						}
						echo $arr[array_rand($arr, 1)];*/
						
						$images_random = get_field('images_random',$item['id']);
						if (gettype($images_random) == 'array') {
							
							if (count($images_random) > 0) {
								$arr = [];
								$arr[] = get_field('banner_file',$item['id'])['url'];
								$image = get_field('banner_file',$item['id']);
								foreach ($images_random  as $items2 ) {
									$arr[] = $items2['randimg']['url'];
								}
								$arr_n = array_rand($arr, 1);
								if($image) {
									$banner_content = '<img data-img="'.$arr[$arr_n].'" class="b_img_main" src="'.$arr[$arr_n].'" />';
								} else {
									$banner_content = get_the_title();
								}
								
							} else {
								$image = get_field('banner_file',$item['id']);
								if($image) {
									$banner_content = '<img data-img="'.$image['url'].'" class="b_img_main" src="'.$image['url'].'" />';
								} else {
									$banner_content = get_the_title();
								}
							}
						} else {
							$image = get_field('banner_file',$item['id']);
							if($image) {
								$banner_content = '<img data-img="'.$image['url'].'" class="b_img_main" src="'.$image['url'].'" />';
							} else {
								$banner_content = get_the_title();
							}
						}
						
					}
					
				} else {
					if (get_field('banner_code',$item['id'])) {
						$banner_content = get_field('banner_code',$item['id']);
					} else {
						$banner_content = get_the_title();
					}
				}
				$result .= '<div class="popup_container" id="popup_'.$item['id'].'">';
				if ($banner_place == 'popup_quiz') {
					if (get_field('link_bot_left_zagolovok',$item['id'])) {
						$z = get_field('link_bot_left_zagolovok',$item['id']);
					} else {
						$z = 'Акция';
					}
					
					$result .= '<div class="popup_b popup_b1 te3 border_radius_general box_shadow_general popup_link_main m8" data-place="'.$banner_place.'" data-text="'.$z.'">';
				} else {
					$result .= '<div class="popup_b popup_b1 te3 border_radius_general box_shadow_general popup_link_main m9" data-place="'.$banner_place.'">';
				}
				
				
				
				if ($banner_place == 'popup_quiz') {
					$result .= '<span class="popup_close_button" id="close_'.$item['id'].'" onclick="euAcceptCookiesWP3();"  data-id="'.$item['id'].'"></span>';
					if (get_field('banner_file',$item['id'])) {
						$style = 'style="background: url('.get_field('banner_file',$item['id'])['url'].');"';
					} else {
						$style = '';
					}
					
					$result .= '<div id="visit_'.$item['id'].'"  data-class="popup_quiz" class="popup_main_link_main popup_quiz" '.$style.'>'.$banner_content.'</div>';
					$turnoffbanner = '';
					
					/*document.getElementById("visit_'.$item['id'].'").onclick = function() {
						document.getElementById("popup_'.$item['id'].'").style.display = "none";
		console.log("asfasfasf3");
	}
	*/
					$alljs = '
					jQuery(function($){
					function getCookie'.$item['id'].'(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
}

		$("#close_'.$item['id'].'").click(function(){
		
			if (document.cookie.indexOf("quiz_hide_'.$item['id'].'") == -1) { //1
				document.cookie = "quiz_hide_'.$item['id'].'=1; path=/; expires=Tue, 19 Jan 2038 03:14:07 GMT";
			} else {
				if (getCookie'.$item['id'].'("quiz_hide_'.$item['id'].'") == 1) { //2
					document.cookie = "quiz_hide_'.$item['id'].'=2; path=/; expires=Tue, 19 Jan 2038 03:14:07 GMT";
				} else if (getCookie'.$item['id'].'("quiz_hide_'.$item['id'].'") == 2) {
					document.cookie = "quiz_hide_'.$item['id'].'=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
					
					
			$.ajax({
			url: "'.admin_url("admin-ajax.php").'",
			type: "POST",
			data: "action=set_cookie_promo&cookie_id=popup_close_'.$item['id'].'&cookie_time=86400", // было 172800
			success: function( data ) {
			}
			
		});
				}
				
			}
			
			
			
		});
		
	});';
				} else {
					$result .= '<span class="popup_close_button" id="close_'.$item['id'].'" onclick="euAcceptCookiesWP3();" data-id="'.$item['id'].'"></span>';
					
					
					if ($banner_type == 'image_random') {
						$images_random = get_field('images_random',$item['id']);
						if (gettype($images_random) == 'array') {
							
							if ( count( $images_random ) > 0 ) {
								$arr   = [];
								$arr[] = $link;
								foreach ( $images_random as $items2 ) {
									$arr[] = $items2['url'];
								}
							}
						}
						$link = $arr[$arr_n];
					}
					
					if (get_field('html_banner_setting_turn_off_link',$item['id'])) {
						if (get_field('html_banner_setting_turn_off_link',$item['id']) == 1) {
							if (get_field('html_banner_setting_additional_title',$item['id'])) {
								$html_banner_setting_additional_title = '<span class="html_setting_itional_title">'.get_field('html_banner_setting_additional_title',$item['id']).'</span>';
							} else {
								$html_banner_setting_additional_title = '';
							}
							$result .= '<div id="visit_'.$item['id'].'" class="popup_main_link_main popup_turn_off_link"  data-class="popup_turn_off_link">'.$banner_content.'</div>';
						} else {
							$result .= '<a href="'.$link.'" target="_blank" rel="nofollow" id="visit_'.$item['id'].'" class="popup_main_link_main"  data-class="popup_quiz2">'.$banner_content.'</a>';
						}
					} else {
						$result .= '<a href="'.$link.'" target="_blank" rel="nofollow" id="visit_'.$item['id'].'" class="popup_main_link_main"  data-class="popup_quiz2">'.$banner_content.'</a>';
					}
					
					$turnoffbanner = 'document.getElementById("visit_'.$item['id'].'").onclick = function() {
		document.getElementById("popup_'.$item['id'].'").style.display = "none";
	}';
					$alljs = '
					jQuery(function($){
		$("#close_'.$item['id'].',#visit_'.$item['id'].'").click(function(){
			
			$.ajax({
			url: "'.admin_url("admin-ajax.php").'",
			type: "POST",
			data: "action=set_cookie_promo&cookie_id=popup_close_'.$item['id'].'&cookie_time=86400", // было 172800
			success: function( data ) {
			}
		});
		});
	});
	
	jQuery(function($){
		$("#visit_'.$item['id'].'").click(function(){
			
			$.ajax({
			url: "'.admin_url("admin-ajax.php").'",
			type: "POST",
			data: "action=set_cookie_promo&cookie_id=popup_visit_'.$item['id'].'&cookie_time=86400", // было 259200
			success: function( data ) {
			
			}
		});
		let id = ' . $item['id'] . ';
			if (id != "") {
				$.ajax({
					url: my_ajax_object.ajax_url,
					type: "POST",
					data: "action=clicklink&id="+id,
					success: function (data) {
	
					}
				});
			}
		});
	});';
				}
				
				$result .= '</div>';
				$result .= '</div>';
				$result .= '<script>';
				$seconds = $seconds - 6000;
				$result .= '
			function show_'.$item['id'].'() {
			  document.getElementById("popup_'.$item['id'].'").style.visibility = "visible";
			  document.getElementById("popup_'.$item['id'].'").className = "popup_container popup_fade";
			  let id = ' . $item['id'] . ';
		if (id != "") {
			/*$.ajax({
				url: my_ajax_object.ajax_url,
				type: "POST",
				data: "action=show_popupstat&id="+id,
				success: function (data) {

				}
			});*/
		}
			}
			jQuery(function($){
				if ((document.cookie.indexOf("popup_close_'.$item['id'].'") == -1) && (document.cookie.indexOf("popup_visit_'.$item['id'].'") == -1)) {
					setTimeout("show_'.$item['id'].'()", '.$seconds.');
				}
				/*$.ajax({
					url: "'.admin_url("admin-ajax.php").'",
					type: "POST",
					data: "action=check_cookie_old&cookie_id=popup_close_'.$item['id'].'&cookie_id_2=popup_visit_'.$item['id'].'",
					success: function( data ) {
						var cookies_exist = data;
						if (cookies_exist == "no0") {
							console.log("п");
							setTimeout("show_'.$item['id'].'()", '.$seconds.');
						}
					}
				});*/
				
				$("#close_'.$item['id'].'").click(function(){
		let id = $(this).attr("data-id");
		if (id != "") {
			$.ajax({
				url: my_ajax_object.ajax_url,
				type: "POST",
				data: "action=closepopup&id=" + id,
				success: function (data) {
					console.log("closepopup");
				}
			});
		}
		});
		
				$(document).click( function(e){
				if ($(window).width() > 499 ) {
				
					var div = $( "#visit_'.$item['id'].'" );
						if ( !div.is(e.target)
						&& div.has(e.target).length === 0 ) {
							//div.parent().parent().hide();
							//div.parent().parent().attr("hide","afsfasf");
						}
				}
				});
			});
			
			
	document.getElementById("close_'.$item['id'].'").onclick = function() {
		document.getElementById("popup_'.$item['id'].'").style.display = "none";
	}
	'.$turnoffbanner.$alljs.'
	
			';
				$result .= '</script>';
				
				
			}
		}
		
		//$result .= $post_id;
		//$result .= check_cookie('popup_close_59397');
		echo $result;
		
	}
}

function show_popup_old_php($post_id) {
	$current_language = get_locale();
	$result = '';
	if ($post_id != 158787) {
		if(get_post_type($post_id) == 'addpages') {
			
			$review_id = get_field('addpage_review',$post_id);
			$post_id = $review_id;
		} elseif(get_post_type($post_id) == 'promocodes') {
			$review_id = get_field('promocode_review',$post_id);
			$post_id = $review_id;
		}
		$result = '';
		$banners = array();
		
		$r_q_args = array(
			'post_type' => 'banners',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'orderby' => 'rand',
			'meta_query' => array(
				'relation'		=> 'AND',
				array(
					'key' => 'banner_posts',
					'value' => serialize( strval( $post_id ) ),
					'compare' => 'LIKE'
				),
				array(
					'key'	 	=> 'banner_place',
					'value'	  	=> array('popup','popup_quiz','popup_quiz_vote'),
					'compare' 	=> 'IN',
				)
			)
		);
		if($current_language != 'ru_RU') {
			$r_q_args['meta_query'][] = array(
				'key'     => 'enable_translations',
				'value'   => $current_language,
				'compare' => 'LIKE'
			);
		}
		$reverse_query = get_posts($r_q_args);
		$a = 0;
		if(!empty($reverse_query)) {
			$a .= 1;//banner_posts_ignore
			foreach ($reverse_query as $item) {
				
				$a .= 333;
				
				if (get_field('geo_target_city',$item->ID) && get_field('geo_target_city',$item->ID) != '') {
					$ip          = $_SERVER['HTTP_X_FORWARDED_FOR'];
					$SxGeo       = new SxGeo( TEMPLATEPATH . '/inc/SxGeoCity.dat' );
					$city        = $SxGeo->get( $ip );
					$detect_city_banner = $city['city']['name_ru'];
					if ($detect_city_banner == '') {
						$detect_city_banner = 'aaaaaaaaaaaaaaaaaaaaaaaaa';
					}
					$geo_target_city = get_field('geo_target_city',$item->ID);
					$geo_target_city = explode( ',', $geo_target_city );
					
					if (in_array($detect_city_banner,$geo_target_city)) {
					
					} else {
						continue;
					}
				}
				
				
				if($current_language == 'ru_RU' && !empty(get_field('enable_translations',$item->ID))) {
					continue;
				}
				$trigger = get_field('banner_triggers',$item->ID);
				if($trigger && $trigger == 'seconds_after_load') {
					if(get_field('banner_seconds',$item->ID)) {
						$seconds = get_field('banner_seconds',$item->ID)*1000;
					} else {
						$seconds = 17000;
					}
				} else {
					$seconds = 0;
				}
				$banners[] = array(
					'id' => $item->ID,
					'time' => $seconds
				);
			}
		}
		$term_list = wp_get_post_terms( $post_id, 'affiliate-tags', array('fields' => 'ids') );
		if(!empty($term_list)) {
			$a .= 2;
			$r_q_args_by_tags = array(
				'post_type' => 'banners',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'orderby' => 'rand',
				'meta_query'	=> array(
					'relation'		=> 'AND',
					array(
						'key'	 	=> 'banner_place',
						'value'	  	=> array('popup','popup_quiz','popup_quiz_vote'),
						'compare' 	=> 'IN',
					),
					array(
						'key'	 	=> 'banner_default',
						'value'	  	=> 1,
						'compare' 	=> '!=',
					)
				),
				'tax_query' => array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'id',
						'terms'    => $term_list,
					),
				),
			);
			if($current_language != 'ru_RU') {
				$r_q_args_by_tags['meta_query'][] = array(
					'key'     => 'enable_translations',
					'value'   => $current_language,
					'compare' => 'LIKE'
				);
			}
			$by_tags = get_posts($r_q_args_by_tags);
			$if_quiz = 0;
			if(!empty($by_tags)) {
				//banner_posts_ignore
				foreach ($by_tags as $item) {
					
					if (get_field('geo_target_city',$item->ID) && get_field('geo_target_city',$item->ID) != '') {
						$ip          = $_SERVER['HTTP_X_FORWARDED_FOR'];
						$SxGeo       = new SxGeo( TEMPLATEPATH . '/inc/SxGeoCity.dat' );
						$city        = $SxGeo->get( $ip );
						$detect_city_banner = $city['city']['name_ru'];
						if ($detect_city_banner == '') {
							$detect_city_banner = 'aaaaaaaaaaaaaaaaaaaaaaaaa';
						}
						$geo_target_city = get_field('geo_target_city',$item->ID);
						$geo_target_city = explode( ',', $geo_target_city );
						
						if (in_array($detect_city_banner,$geo_target_city)) {
						
						} else {
							continue;
						}
					}
					
					if($current_language == 'ru_RU' && !empty(get_field('enable_translations',$item->ID))) {
						continue;
					}
					$trigger = get_field('banner_triggers',$item->ID);
					if($trigger && $trigger == 'seconds_after_load') {
						if(get_field('banner_seconds',$item->ID)) {
							$seconds = get_field('banner_seconds',$item->ID)*1000;
						} else {
							$seconds = 17000;
						}
					} else {
						$seconds = 0;
					}
					$banners[] = array(
						'id' => $item->ID,
						'time' => $seconds
					);
					
					if (get_field('banner_place',$item->ID) == 'popup_quiz') {
						$if_quiz = 1;
					}
				}
			}
		}
		
		if(empty($banners) && !empty($term_list)) {
			$a .= 3;
			$r_q_args_by_default = array(
				'post_type' => 'banners',
				'posts_per_page' => -1,
				'orderby' => 'rand',
				'post_status' => 'publish',
				'meta_query'	=> array(
					'relation'		=> 'AND',
					array(
						'key'	 	=> 'banner_default',
						'value'	  	=> 1,
						'compare' 	=> '=',
					),
					array(
						'key'	 	=> 'banner_place',
						'value'	  	=> array('popup','popup_quiz'),
						'compare' 	=> 'IN',
					)
				),
				'tax_query' => array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'id',
						'terms'    => $term_list,
					),
				),
			);
			if($current_language != 'ru_RU') {
				$r_q_args_by_default['meta_query'][] = array(
					'key'     => 'enable_translations',
					'value'   => $current_language,
					'compare' => 'LIKE'
				);
			}
			$default = get_posts($r_q_args_by_default);
			
			if(!empty($default)) {
				//banner_posts_ignore
				foreach ($default as $item) {
					
					if ( get_field( 'geo_target_city', $item->ID ) && get_field( 'geo_target_city', $item->ID ) != '' ) {
						$ip                 = $_SERVER['HTTP_X_FORWARDED_FOR'];
						$SxGeo              = new SxGeo( TEMPLATEPATH . '/inc/SxGeoCity.dat' );
						$city               = $SxGeo->get( $ip );
						$detect_city_banner = $city['city']['name_ru'];
						if ($detect_city_banner == '') {
							$detect_city_banner = 'aaaaaaaaaaaaaaaaaaaaaaaaa';
						}
						$geo_target_city    = get_field( 'geo_target_city', $item->ID );
						$geo_target_city    = explode( ',', $geo_target_city );
						
						if ( in_array( $detect_city_banner, $geo_target_city ) ) {
						
						} else {
							continue;
						}
					}
					
					if($current_language == 'ru_RU' && !empty(get_field('enable_translations',$item->ID))) {
						continue;
					}
					$trigger = get_field('banner_triggers',$item->ID);
					if($trigger && $trigger == 'seconds_after_load') {
						if(get_field('banner_seconds',$item->ID)) {
							$seconds = get_field('banner_seconds',$item->ID)*1000;
						} else {
							$seconds = 17000;
						}
					} else {
						$seconds = 0;
					}
					$banners[] = array(
						'id' => $item->ID,
						'time' => $seconds
					);
				}
			}
		}
		
		if(count($banners) == 1 && $if_quiz == 1 && !empty($term_list)) {
			$a .= 3.5;
			$r_q_args_by_default = array(
				'post_type' => 'banners',
				'posts_per_page' => -1,
				'orderby' => 'rand',
				'post_status' => 'publish',
				'meta_query'	=> array(
					'relation'		=> 'AND',
					array(
						'key'	 	=> 'banner_default',
						'value'	  	=> 1,
						'compare' 	=> '=',
					),
					array(
						'key'	 	=> 'banner_place',
						'value'	  	=> array('popup','popup_quiz'),
						'compare' 	=> 'IN',
					)
				),
				'tax_query' => array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'id',
						'terms'    => $term_list,
					),
				)
			);
			if($current_language != 'ru_RU') {
				$r_q_args_by_default['meta_query'][] = array(
					'key'     => 'enable_translations',
					'value'   => $current_language,
					'compare' => 'LIKE'
				);
			}
			$default = get_posts($r_q_args_by_default);
			
			if(!empty($default)) {
				//banner_posts_ignore
				foreach ($default as $item) {
					
					if ( get_field( 'geo_target_city', $item->ID ) && get_field( 'geo_target_city', $item->ID ) != '' ) {
						$ip                 = $_SERVER['HTTP_X_FORWARDED_FOR'];
						$SxGeo              = new SxGeo( TEMPLATEPATH . '/inc/SxGeoCity.dat' );
						$city               = $SxGeo->get( $ip );
						$detect_city_banner = $city['city']['name_ru'];
						if ($detect_city_banner == '') {
							$detect_city_banner = 'aaaaaaaaaaaaaaaaaaaaaaaaa';
						}
						$geo_target_city    = get_field( 'geo_target_city', $item->ID );
						$geo_target_city    = explode( ',', $geo_target_city );
						
						if ( in_array( $detect_city_banner, $geo_target_city ) ) {
						
						} else {
							continue;
						}
					}
					
					if($current_language == 'ru_RU' && !empty(get_field('enable_translations',$item->ID))) {
						continue;
					}
					$trigger = get_field('banner_triggers',$item->ID);
					if($trigger && $trigger == 'seconds_after_load') {
						if(get_field('banner_seconds',$item->ID)) {
							$seconds = get_field('banner_seconds',$item->ID)*1000;
						} else {
							$seconds = 17000;
						}
					} else {
						$seconds = 0;
					}
					$banners[] = array(
						'id' => $item->ID,
						'time' => $seconds
					);
				}
			}
		}
		
		//print_r($banners);
		if(!empty($banners)) {
			$a .= 4;
			function cmp_by_optionNumber($a, $b) {
				return $a["time"] - $b["time"];
			}
			usort($banners, "cmp_by_optionNumber");
			//	print_r($banners);
			$x = 0;
			foreach ($banners as $item) {
				$x++;
				$rows = get_field('banner_links',$item['id']);
				$banner_type = get_field('banner_type',$item['id']);
				$banner_place = get_field('banner_place',$item['id']);
				$trigger = get_field('banner_triggers',$item['id']);
				$seconds = $item['time'];
				$i = 0;
				if($rows && !empty($rows)) {
					shuffle( $rows );
					foreach($rows as $row) {
						$link_active = $row['banner_link_active'];
						if ($row['banner_link']) {
							$i++;
							$link = $row['banner_link'];
							if($i==2) {
								break;
							};
						} else {
							continue;
						}
					}
				}
				if ($banner_type == 'image') {
					if ($banner_place == 'popup_quiz') {
						if (get_field('link_bot_color_text',$item['id'])) {
							$color = get_field('link_bot_color_text',$item['id']);
						} else {
							$color = '#FFF';
						}
						$banner_content = '';
						if (get_field('link_bot_zagolovok',$item['id'])) {
							$banner_content .= '<span class="title_quiz" style="color:'.$color.'">'.get_field('link_bot_zagolovok',$item['id']).'</span>';
						}
						if (get_field('link_bot_text',$item['id'])) {
							$banner_content .= '<span class="desc_quiz" style="color:'.$color.'">'.get_field('link_bot_text',$item['id']).'</span>';
						}
						$banner_content .= '<div class="social_links_quiz">';
						
						
						if (get_field('link_bot_links_viber_link',$item['id'])) {
							if (get_field('link_bot_links_viber_text',$item['id'])) {
								$text = get_field('link_bot_links_viber_text',$item['id']);
							} else {
								$text = 'Viber';
							}
							$banner_content .= '<a href="'.get_field('link_bot_links_viber_link',$item['id']).'" class="link viber" data-id="'.$item['id'].'"><img src="/wp-content/themes/eto-razvod-1/img/viber.svg" alt="">'.$text.'</a>';
						}
						
						if (get_field('link_bot_links_telegram_link',$item['id'])) {
							if (get_field('link_bot_links_telegram_text',$item['id'])) {
								$text = get_field('link_bot_links_telegram_text',$item['id']);
							} else {
								$text = 'Telegram';
							}
							$banner_content .= '<a href="'.get_field('link_bot_links_telegram_link',$item['id']).'" class="link telegram" data-id="'.$item['id'].'"><img src="/wp-content/themes/eto-razvod-1/img/telegram.svg" alt="">'.$text.'</a>';
						}
						$banner_content .= '</div>';
						
					} else {
						$image = get_field('banner_file',$item['id']);
						if($image) {
							$banner_content = '<img data-img="'.$image['url'].'" class="b_img" src="'.$image['url'].'" />';
						} else {
							$banner_content = get_the_title();
						}
					}
					
				} elseif ($banner_type == 'text_button') {
					if (get_field('banner_text_button',$item['id'])) {
						$banner_content = get_field('banner_text_button',$item['id']);
					} else {
						$banner_content = __('Перейти','er_theme');
					}
				} elseif ($banner_type == 'image_random') {
					if ($banner_place == 'popup_quiz') {
						if (get_field('link_bot_color_text',$item['id'])) {
							$color = get_field('link_bot_color_text',$item['id']);
						} else {
							$color = '#FFF';
						}
						$banner_content = '';
						if (get_field('link_bot_zagolovok',$item['id'])) {
							$banner_content .= '<span class="title_quiz" style="color:'.$color.'">'.get_field('link_bot_zagolovok',$item['id']).'</span>';
						}
						if (get_field('link_bot_text',$item['id'])) {
							$banner_content .= '<span class="desc_quiz" style="color:'.$color.'">'.get_field('link_bot_text',$item['id']).'</span>';
						}
						$banner_content .= '<div class="social_links_quiz">';
						
						
						if (get_field('link_bot_links_viber_link',$item['id'])) {
							if (get_field('link_bot_links_viber_text',$item['id'])) {
								$text = get_field('link_bot_links_viber_text',$item['id']);
							} else {
								$text = 'Viber';
							}
							$banner_content .= '<a href="'.get_field('link_bot_links_viber_link',$item['id']).'" class="link viber" data-id="'.$item['id'].'"><img src="/wp-content/themes/eto-razvod-1/img/viber.svg" alt="">'.$text.'</a>';
						}
						
						if (get_field('link_bot_links_telegram_link',$item['id'])) {
							if (get_field('link_bot_links_telegram_text',$item['id'])) {
								$text = get_field('link_bot_links_telegram_text',$item['id']);
							} else {
								$text = 'Telegram';
							}
							$banner_content .= '<a href="'.get_field('link_bot_links_telegram_link',$item['id']).'" class="link telegram" data-id="'.$item['id'].'"><img src="/wp-content/themes/eto-razvod-1/img/telegram.svg" alt="">'.$text.'</a>';
						}
						$banner_content .= '</div>';
						
					} else {
						
						/*$arr = [];
						$arr[] = '1';
						foreach (get_field('images_random',202260)  as $item ) {
							$arr[] = $item['randimg']['url'];
						}
						echo $arr[array_rand($arr, 1)];*/
						
						$images_random = get_field('images_random',$item['id']);
						if (gettype($images_random) == 'array') {
							
							if (count($images_random) > 0) {
								$arr = [];
								$arr[] = get_field('banner_file',$item['id'])['url'];
								$image = get_field('banner_file',$item['id']);
								foreach ($images_random  as $items2 ) {
									$arr[] = $items2['randimg']['url'];
								}
								$arr_n = array_rand($arr, 1);
								if($image) {
									$banner_content = '<img data-img="'.$arr[$arr_n].'" class="b_img" src="'.$arr[$arr_n].'" />';
								} else {
									$banner_content = get_the_title();
								}
								
							} else {
								$image = get_field('banner_file',$item['id']);
								if($image) {
									$banner_content = '<img data-img="'.$image['url'].'" class="b_img" src="'.$image['url'].'" />';
								} else {
									$banner_content = get_the_title();
								}
							}
						} else {
							$image = get_field('banner_file',$item['id']);
							if($image) {
								$banner_content = '<img data-img="'.$image['url'].'" class="b_img" src="'.$image['url'].'" />';
							} else {
								$banner_content = get_the_title();
							}
						}
						
					}
					
				} else {
					if (get_field('banner_code',$item['id'])) {
						$banner_content = get_field('banner_code',$item['id']);
					} else {
						$banner_content = get_the_title();
					}
				}
				$result .= '<div class="popup_container" id="popup_'.$item['id'].'">';
				if ($banner_place == 'popup_quiz') {
					if (get_field('link_bot_left_zagolovok',$item['id'])) {
						$z = get_field('link_bot_left_zagolovok',$item['id']);
					} else {
						$z = 'Акция';
					}
					
					$result .= '<div class="popup_b popup_b1 te3 border_radius_general box_shadow_general popup_link_main m7" data-place="'.$banner_place.'" data-text="'.$z.'">';
				} else {
					$result .= '<div class="popup_b popup_b1 te3 border_radius_general box_shadow_general popup_link_main m6" data-place="'.$banner_place.'">';
				}
				
				
				
				if ($banner_place == 'popup_quiz') {
					$result .= '<span class="popup_close_button" id="close_'.$item['id'].'" onclick="euAcceptCookiesWP3();"  data-id="'.$item['id'].'"></span>';
					if (get_field('banner_file',$item['id'])) {
						$style = 'style="background: url('.get_field('banner_file',$item['id'])['url'].');"';
					} else {
						$style = '';
					}
					
					$result .= '<div id="visit_'.$item['id'].'"  data-class="popup_quiz" class="popup_main_link_main popup_quiz" '.$style.'>'.$banner_content.'</div>';
					$turnoffbanner = '';
					
					/*document.getElementById("visit_'.$item['id'].'").onclick = function() {
						document.getElementById("popup_'.$item['id'].'").style.display = "none";
		console.log("asfasfasf3");
	}
	*/
					$alljs = '
					jQuery(function($){
					function getCookie'.$item['id'].'(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
}

		$("#close_'.$item['id'].'").click(function(){
		
			if (document.cookie.indexOf("quiz_hide_'.$item['id'].'") == -1) { //1
				document.cookie = "quiz_hide_'.$item['id'].'=1; path=/; expires=Tue, 19 Jan 2038 03:14:07 GMT";
			} else {
				if (getCookie'.$item['id'].'("quiz_hide_'.$item['id'].'") == 1) { //2
					document.cookie = "quiz_hide_'.$item['id'].'=2; path=/; expires=Tue, 19 Jan 2038 03:14:07 GMT";
				} else if (getCookie'.$item['id'].'("quiz_hide_'.$item['id'].'") == 2) {
					document.cookie = "quiz_hide_'.$item['id'].'=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
					
					
			$.ajax({
			url: "'.admin_url("admin-ajax.php").'",
			type: "POST",
			data: "action=set_cookie_promo&cookie_id=popup_close_'.$item['id'].'&cookie_time=86400", // было 172800
			success: function( data ) {
			}
			
		});
				}
				
			}
			
			
			
		});
		
	});';
				} else {
					$result .= '<span class="popup_close_button" id="close_'.$item['id'].'" onclick="euAcceptCookiesWP3();" data-id="'.$item['id'].'"></span>';
					
					
					if ($banner_type == 'image_random') {
						$images_random = get_field('images_random',$item['id']);
						if (gettype($images_random) == 'array') {
							
							if ( count( $images_random ) > 0 ) {
								$arr   = [];
								$arr[] = $link;
								foreach ( $images_random as $items2 ) {
									$arr[] = $items2['url'];
								}
							}
						}
						$link = $arr[$arr_n];
					}
					
					if (get_field('html_banner_setting_turn_off_link',$item['id'])) {
						if (get_field('html_banner_setting_turn_off_link',$item['id']) == 1) {
							if (get_field('html_banner_setting_additional_title',$item['id'])) {
								$html_banner_setting_additional_title = '<span class="html_setting_itional_title">'.get_field('html_banner_setting_additional_title',$item['id']).'</span>';
							} else {
								$html_banner_setting_additional_title = '';
							}
							$result .= '<div id="visit_'.$item['id'].'" class="popup_main_link_main popup_turn_off_link"  data-class="popup_turn_off_link">'.$banner_content.'</div>';
						} else {
							$result .= '<a href="'.$link.'" target="_blank" rel="nofollow" id="visit_'.$item['id'].'" class="popup_main_link_main"  data-class="popup_quiz2">'.$banner_content.'</a>';
						}
					} else {
						$result .= '<a href="'.$link.'" target="_blank" rel="nofollow" id="visit_'.$item['id'].'" class="popup_main_link_main"  data-class="popup_quiz2">'.$banner_content.'</a>';
					}
					
					$turnoffbanner = 'document.getElementById("visit_'.$item['id'].'").onclick = function() {
		document.getElementById("popup_'.$item['id'].'").style.display = "none";
	}';
					$alljs = '
					jQuery(function($){
		$("#close_'.$item['id'].',#visit_'.$item['id'].'").click(function(){
			
			$.ajax({
			url: "'.admin_url("admin-ajax.php").'",
			type: "POST",
			data: "action=set_cookie_promo&cookie_id=popup_close_'.$item['id'].'&cookie_time=86400", // было 172800
			success: function( data ) {
			}
		});
		});
	});
	
	jQuery(function($){
		$("#visit_'.$item['id'].'").click(function(){
			
			$.ajax({
			url: "'.admin_url("admin-ajax.php").'",
			type: "POST",
			data: "action=set_cookie_promo&cookie_id=popup_visit_'.$item['id'].'&cookie_time=86400", // было 259200
			success: function( data ) {
			
			}
		});
		let id = ' . $item['id'] . ';
			if (id != "") {
				$.ajax({
					url: my_ajax_object.ajax_url,
					type: "POST",
					data: "action=clicklink&id="+id,
					success: function (data) {
	
					}
				});
			}
		});
	});';
				}
				
				$result .= '</div>';
				$result .= '</div>';
				$result .= '<script>';
				$seconds = $seconds - 6000;
				$result .= '
			function show_'.$item['id'].'() {
			  document.getElementById("popup_'.$item['id'].'").style.visibility = "visible";
			  document.getElementById("popup_'.$item['id'].'").className = "popup_container popup_fade";
			  let id = ' . $item['id'] . ';
		if (id != "") {
			/*$.ajax({
				url: my_ajax_object.ajax_url,
				type: "POST",
				data: "action=show_popupstat&id="+id,
				success: function (data) {

				}
			});*/
		}
			}
			jQuery(function($){
				if ((document.cookie.indexOf("popup_close_'.$item['id'].'") == -1) && (document.cookie.indexOf("popup_visit_'.$item['id'].'") == -1)) {
					setTimeout("show_'.$item['id'].'()", '.$seconds.');
				}
				
				$("#close_'.$item['id'].'").click(function(){
		let id = $(this).attr("data-id");
		if (id != "") {
			$.ajax({
				url: my_ajax_object.ajax_url,
				type: "POST",
				data: "action=closepopup&id=" + id,
				success: function (data) {
					console.log("closepopup");
				}
			});
		}
		});
		
				$(document).click( function(e){
					if ($(window).width() > 499 ) {
					
						var div = $( "#visit_'.$item['id'].'" );
							if ( !div.is(e.target)
							&& div.has(e.target).length === 0 ) {
								//div.parent().parent().hide();
								//div.parent().parent().attr("hide","afsfasf");
							}
					}
				});
			});
			
			
	document.getElementById("close_'.$item['id'].'").onclick = function() {
		document.getElementById("popup_'.$item['id'].'").style.display = "none";
	}
	'.$turnoffbanner.$alljs.'
	
			';
				$result .= '</script>';
				
				
			}
		}
	}
	
	//$result .= $post_id;
	//$result .= check_cookie('popup_close_59397');
	echo $result;
	
}


if (!function_exists('get_h_info')) {
	add_action( 'wp_ajax_get_h_info', 'get_h_info' );
	add_action( 'wp_ajax_nopriv_get_h_info', 'get_h_info' );
	function get_h_info() {
		$data = $_POST;
		$post_id = $data['post_id'];
		$goal = $data['goal'];
		$result = '';
		$banners = array();
		if($goal == 'all') {
			$banners['popup'] = 'default';
			if(get_post_type($post_id) == 'casino') {
				$banners['review_reviews_1'] = 'default';
				$banners['review_reviews_2'] = 'default';
				$banners['review_abuses_1'] = 'default';
				$banners['review_abuses_2'] = 'default';
				$banners['review_content_1'] = 'default';
				$banners['review_content_2'] = 'default';
				$banners['review_sidebar'] = 'default';
				$banners['quizpost'] = 'default';
			}
			
			if(get_post_type($post_id) == 'addpages') {
				
				$banners['review_sidebar'] = 'default';
			}
			
			if(get_post_type($post_id) == 'promocodes') {
				
				$banners['review_sidebar'] = 'default';
			}

			if(get_page_template_slug($post_id) == 'template-rating.php' || get_page_template_slug($post_id) == 'template-rating-all.php') {
				$banners['rating_1'] = 'default';
				$banners['rating_2'] = 'default';
				$banners['rating_3'] = 'default';
			}
			/*if(get_post_type($post_id) == 'post' || get_post_type($post_id) == 'casino') {
				$banners['sidebar'] = 'default';
				$banners['after_content'] = 'default';
			}*/
			if(get_page_template_slug($post_id) == 'template-news.php') {
				$banners['news_list_1'] = 'default';
				$banners['news_list_2'] = 'default';
			}
			if(get_post_type($post_id) == 'post') {
				$banners['news_single_1'] = 'default';
				$banners['news_single_2'] = 'default';
			}
		} else {
			$banners[$goal] = 'default';
		}
		if(!empty($banners)) {
			$result .= json_encode($banners);
		}
		echo $result;
		die;
	}
}


if (!function_exists('show_h_info1242424242424')) {
	add_action( 'wp_ajax_show_h_info1242424242424', 'show_h_info1242424242424' );
	add_action( 'wp_ajax_nopriv_show_h_info1242424242424', 'show_h_info1242424242424' );
	function show_h_info1242424242424() {
		$data = $_POST;
		$object = $data['object'];
		$post_id = $data['post_id'];
		$goal = $data['goal'];
		if(get_post_type($post_id) == 'addpages') {

			$review_id = get_field('addpage_review',$post_id);
			$post_id = $review_id;
		} elseif(get_post_type($post_id) == 'promocodes') {
			$review_id = get_field('promocode_review',$post_id);
			$post_id = $review_id;
		}
		$result = '';
		
		//$result = $object.' / '.$goal.' / '.$post_id;
		$term_list = wp_get_post_terms( $post_id, 'affiliate-tags', array('fields' => 'ids') );
		if($goal == 'review_sidebar') {
            $current_language = get_locale();
			$side_banner_id = 0;
			$banner_place = 'sidebar';
			$arr_rqp = array(
				'post_type' => 'banners',
				'posts_per_page' => 1,
				'post_status' => 'publish',
				'orderby' => 'rand',
				'meta_query' => array(
					'relation'		=> 'AND',
					array(
						'key' => 'banner_posts', // name of custom field
						'value' => serialize( strval( $post_id ) ), // matches exactly "123", not just 123. This prevents a match for "1234"
						'compare' => 'LIKE'
					),
					array(
						'key'	 	=> 'banner_place',
						'value'	  	=> $banner_place,
						'compare' 	=> '=',
					),
					array(
						'key'	 	=> 'banner_paid',
						'value'	  	=> 1,
						'compare' 	=> '=',
					),
				)
			);
			
			if($current_language != 'ru_RU') {
				$arr_rqp['meta_query'][] = array(
                    'key'     => 'enable_translations',
                    'value'   => $current_language,
                    'compare' => 'LIKE'
                );
            } else {
				$arr_rqp['meta_query'][] = array(
					'key'     => 'enable_translations',
					'value'   => '',
					'compare' => '='
				);
			}
			
            $reverse_query_paid = get_posts($arr_rqp);
            
			$arr_rq = array(
				'post_type' => 'banners',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'orderby' => 'rand',
				'meta_query' => array(
					'relation'		=> 'AND',
					array(
						'key' => 'banner_posts', // name of custom field
						'value' => serialize( strval( $post_id ) ), // matches exactly "123", not just 123. This prevents a match for "1234"
						'compare' => 'LIKE'
					),
					array(
						'key'	 	=> 'banner_place',
						'value'	  	=> $banner_place,
						'compare' 	=> '=',
					),
				)
			);
			
            if($current_language != 'ru_RU') {
				$arr_rq['meta_query'][] = array(
                    'key'     => 'enable_translations',
                    'value'   => $current_language,
                    'compare' => 'LIKE'
                );
            } else {
				$arr_rq['meta_query'][] = array(
					'key'     => 'enable_translations',
					'value'   => '',
					'compare' => '='
				);
			}
			$reverse_query = get_posts($arr_rq);
            if($reverse_query_paid && !empty($reverse_query_paid)) {
                $side_banner_id = $reverse_query_paid[0]->ID;
                ///echo '<div style="display:none;">';
                ///print_r($reverse_query_paid);
                ///echo '</div>';

            } elseif($reverse_query && !empty($reverse_query) || !empty($term_list)) {
                $side_banners = array();
                $n_term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
                $n_term = get_term_by('slug', $n_term_slug, 'affiliate-tags');
                $term_id = $term_list[0];
                $paid_args_new = array(
                    'post_type' => 'banners',
                    'posts_per_page' => -1,
                    //'orderby' => 'rand',
                    'post_status' => 'publish',
                    'meta_query'	=> array(
                        'relation'		=> 'AND',
                        array(
                            'key'	 	=> 'banner_place',
                            'value'	  	=> $banner_place,
                            'compare' 	=> '=',
                        ),
                        array(
                            'key'	 	=> 'banner_paid',
                            'value'	  	=> 1,
                            'compare' 	=> '=',
                        ),
                    ),
                    /*'tax_query' => array(
                        array(
                            'taxonomy' => 'affiliate-tags',
                            'field'    => 'id',
                            'terms'    => $n_term->term_id,
                        ),
                    ),*/
                );
                if($current_language != 'ru_RU') {
                    $paid_args_new['meta_query'][] = array(
                        'key'     => 'enable_translations',
                        'value'   => $current_language,
                        'compare' => 'LIKE'
                    );
					} else {
						$paid_args_new['meta_query'][] = array(
							'key'     => 'enable_translations',
							'value'   => '',
							'compare' => '=='
						);
					}
                if(!empty($term_list)) {
                    $paid_args_new['tax_query'] = array(
                        'relation' => 'OR',
                    );
                    foreach ($term_list as $term_list_item) {
                        $paid_args_new['tax_query'][] = array(
                            'taxonomy' => 'affiliate-tags',
                            'field'    => 'id',
                            'terms'    => $term_list_item,
                        );
                    }

                }
                $er_banners_paid_side_term = new WP_Query($paid_args_new  );

                if ( $er_banners_paid_side_term->have_posts() ) {
                    while ( $er_banners_paid_side_term->have_posts() ) {
                        $er_banners_paid_side_term->the_post();
                        global $post;
                        $side_banners[] = $post->ID;
                    }
                } else {

                }
                wp_reset_postdata();
                if(!empty($reverse_query)) {
                    $side_banners[] = $reverse_query[0]->ID;
                    //echo $reverse_query[0]->ID;
                }

                //echo '<div style="display:none;">reversequery';
                //print_r($reverse_query);
               // echo '</div>';
                //if($data['post_id'] == 52798) {
                   // echo '<div style="display:none;">';
                   // print_r($side_banners);
                   // echo '</div>';
                //}
                $next_sidebar = 1;
                global $wpdb;
                $mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
                $side_banners_count = count($side_banners);
                $exists_sidebar = $mydb->get_results("SELECT * FROM `banners_show` WHERE `post_id` = '$post_id'");
                if(!empty($exists_sidebar)) {
                    if($exists_sidebar[0]->number == $side_banners_count) {
                        if($exists_sidebar[0]->last == $side_banners_count || $exists_sidebar[0]->last > $side_banners_count) {
                            $next_sidebar = 1;
                        } else {
                            $next_sidebar = $exists_sidebar[0]->last + 1;
                        }
                        $mydb->update(
                            'banners_show',
                            array('last'=> $next_sidebar),
                            array( 'post_id' => $post_id ),
                            array( '%s' )
                        );
                    } else {
                        $mydb->update(
                            'banners_show',
                            array('number'=> $side_banners_count),
                            array( 'post_id' => $post_id ),
                            array( '%s' )
                        );
                        $next_sidebar = 1;
                    }
                } else {
                    $mydb->insert('banners_show',
                        array(
                            'post_id'=> $post_id,
                            'number' => $side_banners_count,
                            'last' => 1
                        ),
                        array( '%s', '%s', '%s'));
                    $next_sidebar = 1;
                }

                //shuffle($side_banners);
                $next_sidebar_chose = $next_sidebar - 1;
				$side_banner_id = $side_banners[$next_sidebar_chose];

			} elseif(!empty($term_list)) {

				$term_id = $term_list[0];
				 $arr_er_banners = array(
					'post_type' => 'banners',
					'posts_per_page' => 1,
					'orderby' => 'rand',
					'post_status' => 'publish',
					'meta_query'	=> array(
						'relation'		=> 'AND',
						array(
							'key'	 	=> 'banner_place',
							'value'	  	=> $banner_place,
							'compare' 	=> '=',
						),
					),
					'tax_query' => array(
						array(
							'taxonomy' => 'affiliate-tags',
							'field'    => 'id',
							'terms'    => $term_id,
						),
					),
				) ;
                if($current_language != 'ru_RU') {
					$arr_er_banners['meta_query'][] = array(
                        'key'     => 'enable_translations',
                        'value'   => $current_language,
                        'compare' => 'LIKE'
                    );
                } else {
					$arr_er_banners['meta_query'][] = array(
						'key'     => 'enable_translations',
						'value'   => '',
						'compare' => '=='
					);
				}
                $er_banners = new WP_Query($arr_er_banners);
				if ( $er_banners->have_posts() ) {
					while ( $er_banners->have_posts() ) {
						$er_banners->the_post();
						global $post;
						$side_banner_id = $post->ID;
					}
				} else {
					$side_banner_id = 0;
				}
				wp_reset_postdata();
                //echo '<div style="display:none;">emptytermsslist';
                //print_r($term_list);
               // echo $side_banner_id;
                //echo '</div>';
			} else {
				$side_banner_id = 0;
			}
            if($side_banner_id == 0) {


	            // print_r($term_list);
	            $term_id = $term_list[0];
				$arr_er_banners_2 =  array(
		            'post_type' => 'banners',
		            'posts_per_page' => 1,
		            'orderby' => 'rand',
		            'post_status' => 'publish',
		            'meta_query'	=> array(
			            'relation'		=> 'AND',
			            array(
				            'key'	 	=> 'banner_place',
				            'value'	  	=> $banner_place,
				            'compare' 	=> '=',
			            ),
						array(
							'key'	 	=> 'banner_default',
							'value'	  	=> 1,
							'compare' 	=> '!=',
						),
		            ),
		            'tax_query' => array(
			            array(
				            'taxonomy' => 'affiliate-tags',
				            'field'    => 'id',
				            'terms'    => $term_id,
			            ),
		            ),
	            ) ;
	            if($current_language != 'ru_RU') {
		            $arr_er_banners_2['meta_query'][] = array(
			            'key'     => 'enable_translations',
			            'value'   => $current_language,
			            'compare' => 'LIKE'
		            );
	            } else {
					$arr_er_banners_2['meta_query'][] = array(
						'key'     => 'enable_translations',
						'value'   => '',
						'compare' => '=='
					);
				}
				$er_banners = new WP_Query($arr_er_banners_2);
	            if ( $er_banners->have_posts() ) {
		            while ( $er_banners->have_posts() ) {
			            $er_banners->the_post();
			            global $post;
			            $side_banner_id = $post->ID;
		            }
	            } else {
	            	$def_array = array(
						'post_type' => 'banners',
						'posts_per_page' => 1,
						'orderby' => 'rand',
						'post_status' => 'publish',
						'meta_query'	=> array(
							'relation'		=> 'AND',
							array(
								'key'	 	=> 'banner_place',
								'value'	  	=> $banner_place,
								'compare' 	=> '=',
							),
							array(
								'key'	 	=> 'banner_default',
								'value'	  	=> 1,
								'compare' 	=> '=',
							),
						),
		
					);
		
					if($current_language != 'ru_RU') {
						$def_array['meta_query'][] = array(
							'key'     => 'enable_translations',
							'value'   => $current_language,
							'compare' => 'LIKE'
						);
					} else {
						$def_array['meta_query'][] = array(
							'key'     => 'enable_translations',
							'value'   => '',
							'compare' => '=='
						);
					}
	            	
		            $default_sidebar = new WP_Query($def_array) ;
		            /**/
		            //print_r($default_sidebar);
		            if ( $default_sidebar->have_posts() ) {
			            while ( $default_sidebar->have_posts() ) {
				            $default_sidebar->the_post();
				            global $post;
				            $side_banner_id = $post->ID;
			            }
		            } else {
			            $side_banner_id = 0;
		            }
		            wp_reset_postdata();
	            }
	            wp_reset_postdata();
	            //$side_banner_id = 0;
            }
			if($side_banner_id && $side_banner_id != 0 && $side_banner_id != '') {

				$rows = get_field('banner_links',$side_banner_id);
				if($rows) $i = 0; {
					shuffle( $rows );
					foreach($rows as $row) {
						// $link_active = $row['banner_link_active'];

						if ($row['banner_link']) {
							$i++; if($i==2) break;
							$link = $row['banner_link'];
						} else {
							continue;
						}

					}
				}
				if (get_field('banner_type',$side_banner_id) && get_field('banner_type',$side_banner_id) == 'image') {
					if (get_field('banner_file',$side_banner_id)) {
						$banner_content = '<div data-img="'.get_field('banner_file',$side_banner_id)['url'].'" class="b_img_main b_number_1" style="background-image:url('.get_field('banner_file',$side_banner_id)['url'].'); height:'.get_field('banner_file',$side_banner_id)['sizes']['large-height'].'px"></div>';
						if (get_locale() == 'ru_RU') {
							if (get_field('connect_with_posts',$side_banner_id)) {
								if (gettype(get_field('connect_with_posts',$side_banner_id)) == 'array') {
									if (count(get_field('connect_with_posts',$side_banner_id)) > 0) {
										$connect_with_posts = get_field('connect_with_posts',$side_banner_id)[0];
										if (get_field('websites_0_site_url',$connect_with_posts)) {
											$er_company_site_str_2 = preg_replace( '#^[^:/.]*[:/]+#i', '', get_field('websites_0_site_url',$connect_with_posts) );
											$site                  = preg_replace( '/^www\./', '', rtrim( $er_company_site_str_2, '/' ) );
											$banner_content .= '<span class="b_description_title">Реклама - '.$site.'</span>';
										}
									}
								}
							}
						}
					} else {
						$banner_content = get_the_title($side_banner_id);
					}
				} elseif (get_field('banner_type',$side_banner_id) && get_field('banner_type',$side_banner_id) == 'text_button') {
					if (get_field('banner_text_button',$side_banner_id)) {
						$banner_content = get_field('banner_text_button',$side_banner_id);
					} else {
						$banner_content = __('Перейти','er_theme');
					}

				} else {
					if (get_field('banner_code',$side_banner_id)) {
						$banner_content = get_field('banner_code',$side_banner_id);
					} else {
						$banner_content = get_the_title($side_banner_id);
					}
				}
				$result .= '<div class="block" id="sidebar_banner';
				if (!get_field('disable_floating',$side_banner_id)) {
					$result .= '_fixed';
				};
				$result .= '">';
				$result .= '<a rel="nofollow" target="_blank" href="'.$link.'">'.$banner_content.'</a>';

				$result .= '</div>';
			} else {
				$result .= 'none';
			}
			//$result .= $side_banner_id;
		
		} else {
			
			if($goal == 'popup') {
				$promocodes_query = new WP_Query( array(
					'post_type' => 'promocodes',
                    'post_status' => 'publish',
					'meta_query' => array(
						array(
							'key' => 'promocode_review', // name of custom field
							'value' => $post_id, // matches exactly "123", not just 123. This prevents a match for "1234"
							'compare' => '='
						)
					)

				) );
				if($promocodes_query->have_posts()) {
					while ( $promocodes_query->have_posts() ) {
						$promocodes_query->the_post();
						global $post;
						$promo_p_id = $post->ID;
					}
				} else {
					$promo_p_id = 0;
					$p_array = array();
				}
				wp_reset_postdata();
				$hour = 12;
				$today              = strtotime($hour . ':00:00');
				$yesterday          = strtotime('-1 day', $today);


				if($promo_p_id != 0) {
					$promocodes = get_field('promocodes_items',$promo_p_id);
					if($promocodes && !empty($promocodes))  {
						$ppp = 0;
						foreach ($promocodes as $item) {
							$date_end_m = strtotime($item['date_end']);
							if(($date_end_m < $yesterday && !empty($item['date_end']) && $item['date_end'] != 'None') || ($item['hide_promos'] == 'yes')) {

							} else {
								if($ppp == 7) {
									break;
								}
								$ppp++;
								$p_array[] = $item;
							}

						}
					} else {
						$p_array = array();
					}
				} else {
					$p_array = array();
				}
				
			}
			
			if($goal == 'popup' && !empty($p_array)) {
				//$result .= 'none';
				
				$result .= '<div class="popup_container heygo_container promocode_heygo" id="popup_'.$goal.'" >';
					$result .= '<div class="popup_window box_shadow flex flex_column">';
					$result .= '<div class="popup_close_button pointer" data-id="'.$goal.'"></div>';
				$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
					$term = get_term_by('slug', $term_slug, 'affiliate-tags');

					if (get_field('img_promo_special',$post_id)) {
						$img = get_field('img_promo_special',$post_id);
					} elseif (get_field('img_promo_banner','term_'.$term->term_id)) {
						$img = get_field('img_promo_banner','term_'.$term->term_id);
					} else {
						$img = get_field('img_promo_banner','term_'.$term->term_id);
					}
				if($img && $img != '') {
						$result .= '<div class="promo_heygo_top" style="background-image:url('.$img.');">';
					} else {
						$result .= '<div class="promo_heygo_top">';
					}
				
				$result .= review_logo($post_id);
				$result .= '</div>';
				if (count($p_array) == 1) {
					$result .= '<div class="arrow_top_promocodes_wrap" style="display: none"><div class="arrow_left_top_promocodes"></div>';
					$result .= '<div class="arrow_right_top_promocodes"></div></div>';
				} else {
					$result .= '<div class="arrow_top_promocodes_wrap"><div class="arrow_left_top_promocodes"></div>';
					$result .= '<div class="arrow_right_top_promocodes"></div></div>';
				}
				$result .= '<ul class="heygo_promocodes" data-count="'.count($p_array).'" data-count-list="">';
				$yyyyy = 0;
				foreach ($p_array as $item) {
					$yyyyy++;
					$result .= '<li id="heygo_promocodes_'.$post_id.'_'.$yyyyy.'">';
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
					if($size != '') {
						$result .= '<div class="font_bold font_big m_b_20 discount_size">' . $size . '</div>';
					} else {
						$result .= '<div class="font_bold font_big m_b_20 discount_size_text">' . $item_type . '</div>';
					}
					if($item['title'] != '') {
						$result .= '<div class="popup_big_promos_title font_18 font_bold m_t_15">' . $item['title'] . '</div>';
					}
					
					$result .= '<div class="promocode_button_container">';

						if($item['text'] != '' && $item['text'] != 'Не нужен') {
							$result .= '<div class="promocode_text_container" id="promocode_text_container_'.$post->ID.'_'.$yyyyy.'">';

							$result .= '<div class="promocode_single_text" id="promocode_text_'.$post->ID.'_'.$yyyyy.'">'.$item['text'].'</div>';
							$result .= '<input value="'.$item['text'].'" type="text" id="promocode_text_'.$post->ID.'_'.$yyyyy.'_input" style="position: absolute;z-index: -99999;">';
							$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold get_promocode_1" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$yyyyy.'/" target="_blank" rel="nofollow">'.__('Получить','er_theme').'</a>';
							$result .= '<div class="link_promocode_text_copy button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Скопировать','er_theme').'</div>';
							$result .= '</div>';
						} else {
							$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold get_promocode_2" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$yyyyy.'/" target="_blank" rel="nofollow">'.__('Получить','er_theme').'</a>';
						}
					$result .='</div>';
					if($item['description'] != '') {
						$result .= '<div class="promocode_full_description color_dark_gray font_small">'.$item['description'].'</div>';
						$result .= '<span class="font_smaller color_dark_gray inactive dropdown pointer flex link_promocode_show_more">'.__('Подробнее','er_theme').'</span>';
					}
					$result .= '</li>';
				}
				$result .= '</ul>';


				if (count($p_array) < 2) {
					$result .= '<div class="flex heygo_slider_dots heygo_slider_big_promocodes" style="display: none;">';
				} else {
					$result .= '<div class="flex heygo_slider_dots heygo_slider_big_promocodes">';
				}
				for ($i = 1;$i <= count($p_array);$i++) {
					if ( $i == 1 ) {
						$result .= '<span class="active number_'.$i.'" data-number="'.$i.'"></span>';
					} else {
						$result .= '<span class="inactive number_'.$i.'" data-number="'.$i.'"></span>';
					}
				}
				$result .= '</div>';

				/*if (count($p_array) <= 1) {
					$result .= '<div class="flex heygo_slider_big_block_pro_codes_slider" style="display: none;">';

				} else {
					$result .= '<div class="flex heygo_slider_big_block_pro_codes_slider">';
				}
				$i = 0;
				foreach ($p_array as $item) {
				$i = ++$i;
				if ($i == 1) {
					$result .= '<span class="active number_1" data-number="1"></span>';

				} else {
					$result .= '<span class="inactive number_'.$i.'" data-number="'.$i.'"></span>';
				}
				}*/

				$result .= '</div>';

				$result .= '</div>';
					$result .= '</div>';
				
				
			} elseif(!empty($term_list)) {
				$term_id = $term_list[0];
				if($term_id == 15603) {
					$term_id = 17;
                } elseif($term_id == 16172) {
                    $term_id = 653;
				} elseif($term_id == 9786) {
					$term_id = 664;
				}
				$show_ids = array();
				$args = array(
					'post_type' => 'casino',
					'posts_per_page' => 3,
					'post_status' => 'publish',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'tax_query' => array(
						array(
							'taxonomy' => 'affiliate-tags',
							'field'    => 'id',
							'terms'    => $term_id,
						)
					),
				);
				$term_human_title = get_field('tag_human_title','term_'.$term_id);

				if($goal == 'popup') {
					$curr_bonuses = get_field( 'base_2_bonuses', $post_id );
					if(!empty($curr_bonuses)) {
						$show_ids[] = $post_id;
						$args['posts_per_page'] = 8;
						$args['post__not_in'] = array($post_id);
					} else {
						$args['posts_per_page'] = 9;
					}
					$args['meta_query'] = array(
						'relation'		=> 'AND',
						array(
							'key' => 'base_2_bonuses',
							'value' => 0,
							'compare' => '>'
						)
					);


					if(wp_get_post_parent_id($post_id) != 0 && get_page_template_slug($post_id) == 'template-rating.php') {
						$fields = get_field('more_fields',$post_id);
						if(!empty($fields)) {
							foreach($fields as $field) {
								$args['meta_query'][] = array(
									'key' => get_term( $field['key'], 'field_types' )->slug,
									'value' => $field['value'],
									'compare' => 'LIKE',
								);

							}
						}
					}
				}

				/*if ($goal == 'rating_1') {
					if ( ! empty( $fields ) ) {
						$args['meta_query'] = array(
							'relation' => 'AND',
						);
						foreach ( $fields as $field ) {
							$key = get_term( $field['key'], 'field_types' )->slug;
							if ( $key == 'filter_top_bet' ) {
								$args['posts_per_page'] = 10;
							}
						}
						$args['meta_query'][] = get_more_fields_company($args,$fields);
					}
				}*/

				if(strpos($goal, 'rating_') !== false){
					$fields = get_field('more_fields',$post_id);
					if ( ! empty( $fields ) ) {
						$args['meta_query'] = array(
							'relation' => 'AND',
						);
						foreach ( $fields as $field ) {
							$key = get_term( $field['key'], 'field_types' )->slug;
							if ( $key == 'filter_top_bet' ) {
								$args['posts_per_page'] = 10;
							}
						}
						$args['meta_query'][] = get_more_fields_company($args,$fields);
					}
				}

				if ( $current_language == 'ru_RU' ) {
					$args['turn_off_on_ru_language'] = 1;

				}

				$reviews = new WP_Query( $args );
				if ( $reviews->have_posts() ) {
					while ( $reviews->have_posts() ) {
						$reviews->the_post();
						global $post;
						$show_ids[] = $post->ID;
					}
					wp_reset_postdata();
				}
				$show_ids = array_unique($show_ids);
				global $detect_city;
				$language = get_locale();
				if($goal == 'popup') {
					if (count($show_ids) != 0) {
					$result .= '<div class="popup_container heygo_container" id="popup_'.$goal.'" data-test="'.count($show_ids).'" data-set="3">';
					$result .= '<div class="popup_window box_shadow flex flex_column">';
					$result .= '<div class="popup_close_button pointer" data-id="'.$goal.'"></div>';
					if($term_human_title && $term_human_title != '') {
						$result .= '<div class="title color_dark_blue font_bolder m_b_30 font_uppercase font_smaller_2">'.__('Лучшие бонусы категории','er_theme').' '.$term_human_title.' '.__('сегодня','er_theme');
						if($detect_city && $detect_city != '') {
							if ($language == 'ru_RU') {
								$result .= ' для г. '.$detect_city;
							}
						}
						$result .= '</div>';
					} else {
						$result .= '<div class="title color_dark_blue font_bolder m_b_30 font_uppercase font_smaller_2">'.__('Самые выгодные предложения месяца','er_theme');
						if($detect_city && $detect_city != '') {
							if ($language == 'ru_RU') {
								$result .= ' для г. '.$detect_city;
							}
						}
						$result .= '</div>';
					}
					



					if (count($show_ids) == 1) {
						$result .= '<div class="arrow_top_companies_wrap" style="display: none"><div class="arrow_left_top_companies"></div>';
						$result .= '<div class="arrow_right_top_companies"></div></div>';
					} else {
						$result .= '<div class="arrow_top_companies_wrap"><div class="arrow_left_top_companies"></div>';
						$result .= '<div class="arrow_right_top_companies"></div></div>';
					}




					if (count($show_ids) == 1) {
						$result .= '<ul class="flex top_companies_heygo heygoone_cols_wrapper top_companies_heygo_best_com top_companies_heygo_best_com_1">';
					} elseif (count($show_ids) == 2) {
						$result .= '<ul class="flex top_companies_heygo heygotwo_cols_wrapper top_companies_heygo_best_com top_companies_heygo_best_com_2">';
					} else {
						$result .= '<ul class="flex top_companies_heygo top_companies_heygo_best_com top_companies_heygo_best_com_3">';
					}
					
					foreach($show_ids as $id) {

						$company_name = get_field( 'company_name', $id );
						$bonus        = get_field( 'base_2_bonuses', $id )[0];
						if ( $bonus['bonus_format'] && $bonus['text'] ) {
							$bonus_title = $bonus['text'];
						} elseif ( $bonus['from'] || $bonus['to'] ) {
							$bonus_title = simple_from_to( $bonus );
							if ( $bonus['currency'] ) {
								$bonus_title .= ' ';
								$bonus_title .= term_field( $bonus['currency'], 'currencies', 'name' );
							}
						} else {
							$bonus_title = $company_name;
						}
						if ( count( $show_ids ) == 1 ) {
							$result .= '<li class="white_block border_radius_4px heygo_one_cols_item" id="heygo_top_' . $id . '">';
						} elseif ( count( $show_ids ) == 2 ) {
							$result .= '<li class="white_block border_radius_4px heygo_two_cols_item" id="heygo_top_' . $id . '">';
						} else {
							if ($language == 'ru_RU') {
								$excplusive = 'ЭКСКЛЮЗИВ';
							} else {
								$excplusive = 'EXCLUSIVE';
							}
							$result .= '<li class="white_block border_radius_4px heygo1" id="heygo_top_' . $id . '"><span class="exclusive_b">'.$excplusive.'</span>';
						}

						$result .= '<div class="block_header">';

						if ( function_exists( 'review_redirect_link' ) ) {
							$link = review_redirect_link( $id );
						} else {
							$link = '';
						}
						$result  .= '<a href="' . $link . '" class="review_logo" target="_blank"';
						$logo    = get_field( 'company_logo', $id );
						$logo_bg = get_field( 'company_icon_bg', $id );
						if ( $logo_bg && $logo_bg != '' ) {
							$bg = ' background-color:' . $logo_bg . ';';
						} else {
							$bg = '';
						}
						
						if ( $logo && ! empty( $logo ) ) {
							$result .= ' style="background-image:url(' . $logo['sizes']['large'] . ');' . $bg . '"';
						}
						$result .= '></a>';
						$term_slug = get_term( get_field('company_type',$id), 'companytypes' )->name;
						if (in_array($term_slug, array('bloggers'))) {
							$result .= '<div class="color_dark_blue font_bold font_18">'.get_field( 'company_name', $id ).'</div>';
						}
						//$result .= review_logo($id);
						$result  .= '<div class="color_dark_blue font_bold font_new_medium">' . $bonus_title . '</div>';
						$result  .= '</div>';
						$result  .= '<div class="block_footer">';
						$excerpt = get_the_excerpt( $id );
						if ( $excerpt && $excerpt != '' ) {
							$result .= '<div class="font_smaller color_dark_gray field_1 m_b_10">' . do_shortcode( $bonus['comment'] ) . '</div>';
						}

						//$result .= '<div class="font_smaller color_dark_blue field_2 font_bold">Поле 2</div>';
						//$result .= '<div class="font_smaller color_dark_blue field_3 font_bold">Поле 3</div>';


						//$result .= '<div class="font_little color_dark_gray field_3">Поле 5</div>';
						$result .= '</div>';
						if ( $link != '' ) {
							if( function_exists( 'replace_ru_domain_for_lang' ) ) {
								$bonus['link'] = replace_ru_domain_for_lang( $bonus['link'], $language );
							}
							$result .= '<a href="' . $bonus['link'] . '" class="go_more pointer" target="_blank">' . __( 'Получить', 'er_theme' ) . '</a>';
						}
						$result .= '</li>';

					}
					$result .= '</ul>';
					if($goal == 'popup') {
						if (count($show_ids) < 4) {
							$result .= '<div class="flex heygo_slider" style="display: none;">';
						} else {
							$result .= '<div class="flex heygo_slider">';
						}
						$result .= '<span class="active number_1" data-number="1"></span>';
						$result .= '<span class="inactive number_2" data-number="2"></span>';
						if (count($show_ids) > 6) {
							$result .= '<span class="inactive number_3" data-number="3"></span>';
						}
						$result .= '</div>';
						if (count($show_ids) < 2) {
							$result .= '<div class="flex heygo_slider_mobile" style="display: none;">';
						} else {
							$result .= '<div class="flex heygo_slider_mobile">';
						}
						for ($i = 1;$i <= count($show_ids);$i++) {
							if ( $i == 1 ) {
								$result .= '<span class="active number_'.$i.'" data-number="'.$i.'"></span>';
							} else {
								$result .= '<span class="inactive number_'.$i.'" data-number="'.$i.'"></span>';
							}
						}
						$result .= '</div>';


					}
					$result .= '</div>';
					$result .= '</div>';
					} else {
						$result .= 'none';
					}
				} else {
					if (count($show_ids) != 0) {
						shuffle($show_ids);
						$result .= '<div id="hey_content_'.$goal.'" class="white_block inline_heygo" data-type="'.$goal.'"  data-id="'.$post_id.'" data-more-field="'.get_field('more_fields',$post_id)[0]['key'].'" data-id-set="'.wp_get_post_parent_id($post_id).'" data-id-set-new="'.get_page_template_slug($post_id).'">';
						$id = $show_ids[0];
						$company_name = get_field('company_name',$id);
						$description = get_the_excerpt($id);
						$button_text = get_field('review_button_text',$id);
						if(!$button_text || $button_text == '') {
							$button_text = __('Регистрация','er_theme');
						}
						if(function_exists('review_redirect_link')) {
							$link = review_redirect_link($id);
						} else {
							$link = '';
						}

						$term_slug = get_term( get_field('company_type',$id), 'companytypes' )->name;
						$term = get_term_by('slug', $term_slug, 'affiliate-tags');
						$img = get_field('img_promo_banner','term_'.$term->term_id);
						$result .= '<div class="block_header flex">';
						$result .= review_logo($id);
						$result .= '<div class="company_title flex flex_column t3">';
						$result .= '<span class="color_dark_blue font_small font_bold m_b_5">'.$company_name.'</span>';
						$result .= '<span class="color_dark_gray font_smaller">'.__('Реклама','er_theme').'</span>';
						$result .= '</div>';
						if($link != '') {
							$result .= '<a href="'.$link.'" class="button button_heygo font_bold button_violet pointer link_no_underline font_18" target="_blank" rel="nofollow">'.$button_text.'</a>';
						}
						if(($description && $description != '' && $goal == 'rating_1') || ($description && $description != '' && $goal == 'rating_2')|| ($description && $description != '' && $goal == 'rating_3')) {
							$result .= '<div class="hey_description">'.$description.'</div>';
						}
						$result .= '</div>';
						if($img && $img != '') {
							$result .= '<div class="hey_image" style="background-image:url('.$img.');" data-id="'.count($show_ids).'"></div>';
						} else {
							$result .= '<div class="hey_image" data-id="'.count($show_ids).'"></div>';
						}
						if($description && $description != '' && $goal != 'rating_1' && $goal != 'rating_2' && $goal != 'rating_3') {
							$result .= '<div class="hey_description">'.$description.'</div>';
						}
						$result .= '</div>';
					}
				}
				if ($goal == 'quizpost') {
					$current_language = get_locale();
					$banners = [];
					$r_q_args = array(
						'post_type'      => 'banners',
						'posts_per_page' => 1,
						'post_status'    => 'publish',
						'orderby'        => 'rand',
						'meta_query'     => array(
							'relation' => 'AND',
							array(
								'key'     => 'banner_posts',
								'value'   => serialize( strval( $post_id ) ),
								'compare' => 'LIKE'
							),
							array(
								'key'     => 'banner_place',
								'value'   => array( 'post_quiz' ),
								'compare' => 'IN',
							)
						)
					);
					if ( $current_language != 'ru_RU' ) {
						$r_q_args['meta_query'][] = array(
							'key'     => 'enable_translations',
							'value'   => $current_language,
							'compare' => 'LIKE'
						);
					}
					$reverse_query = get_posts( $r_q_args );
					$a             = 0;
					if ( ! empty( $reverse_query ) ) {
						//banner_posts_ignore
						foreach ( $reverse_query as $item ) {
							$banners[] = array(
								'id'   => $item->ID,
								'time' => 10
							);
						}
					}
					wp_reset_postdata();
					
					
					$term_list = wp_get_post_terms( $post_id, 'affiliate-tags', array( 'fields' => 'ids' ) );
					
					if ( ! empty( $term_list ) ) {
						$a                .= 2;
						$r_q_args_by_tags = array(
							'post_type'      => 'banners',
							'posts_per_page' => - 1,
							'post_status'    => 'publish',
							'orderby'        => 'rand',
							'meta_query'     => array(
								'relation' => 'AND',
								array(
									'key'     => 'banner_place',
									'value'   => array( 'post_quiz' ),
									'compare' => 'IN',
								),
								array(
									'key'     => 'banner_default',
									'value'   => 1,
									'compare' => '!=',
								)
							),
							'tax_query'      => array(
								array(
									'taxonomy' => 'affiliate-tags',
									'field'    => 'id',
									'terms'    => $term_list,
								),
							),
						);
						if ( $current_language != 'ru_RU' ) {
							$r_q_args_by_tags['meta_query'][] = array(
								'key'     => 'enable_translations',
								'value'   => $current_language,
								'compare' => 'LIKE'
							);
						}
						$by_tags = get_posts( $r_q_args_by_tags );
						if ( ! empty( $by_tags ) ) {
							//banner_posts_ignore
							foreach ( $by_tags as $item ) {
								$banners[] = array(
									'id'   => $item->ID,
									'time' => 10
								);
							}
						}
					}
					if ( ! empty( $banners ) ) {
						foreach ( $banners as $item ) {
							//banner_posts_ignoreВАЖНО
							$rows         = get_field( 'banner_links', $item['id'] );
							$banner_type  = get_field( 'banner_type', $item['id'] );
							$banner_place = get_field( 'banner_place', $item['id'] );
							$trigger      = get_field( 'banner_triggers', $item['id'] );
							$seconds      = $item['time'];
							$i            = 0;
							if ( $rows && ! empty( $rows ) ) {
								shuffle( $rows );
								foreach ( $rows as $row ) {
									$link_active = $row['banner_link_active'];
									if ( $row['banner_link'] ) {
										$i ++;
										$link = $row['banner_link'];
										if ( $i == 2 ) {
											break;
										};
									} else {
										continue;
									}
								}
							}
							if ( $banner_type == 'image' ) {
								if ( get_field( 'link_bot_color_text', $item['id'] ) ) {
									$color = get_field( 'link_bot_color_text', $item['id'] );
								} else {
									$color = '#FFF';
								}
								$banner_content = '';
								if ( get_field( 'link_bot_zagolovok', $item['id'] ) ) {
									$banner_content .= '<span class="title_quiz" style="color:' . $color . '">' . get_field( 'link_bot_zagolovok', $item['id'] ) . '</span>';
								}
								if ( get_field( 'link_bot_text', $item['id'] ) ) {
									$banner_content .= '<span class="desc_quiz" style="color:' . $color . '">' . get_field( 'link_bot_text', $item['id'] ) . '</span>';
								}
								$banner_content .= '<div class="social_links_quiz">';
								
								
								if ( get_field( 'link_bot_links_viber_link', $item['id'] ) ) {
									if ( get_field( 'link_bot_links_viber_text', $item['id'] ) ) {
										$text = get_field( 'link_bot_links_viber_text', $item['id'] );
									} else {
										$text = 'Viber';
									}
									$banner_content .= '<a href="' . get_field( 'link_bot_links_viber_link', $item['id'] ) . '" class="link viber" data-id="' . $item['id'] . '"><img src="/wp-content/themes/eto-razvod-1/img/viber.svg" alt="">' . $text . '</a>';
								}
								
								if ( get_field( 'link_bot_links_telegram_link', $item['id'] ) ) {
									if ( get_field( 'link_bot_links_telegram_text', $item['id'] ) ) {
										$text = get_field( 'link_bot_links_telegram_text', $item['id'] );
									} else {
										$text = 'Telegram';
									}
									$banner_content .= '<a href="' . get_field( 'link_bot_links_telegram_link', $item['id'] ) . '" class="link telegram" data-id="' . $item['id'] . '"><img src="/wp-content/themes/eto-razvod-1/img/telegram.svg" alt="">' . $text . '</a>';
								}
								$banner_content .= '</div>';
								
								if ( get_field( 'banner_file', $item['id'] ) ) {
									$style = 'style="background: url(' . get_field( 'banner_file', $item['id'] )['url'] . ');"';
								} else {
									$style = '';
								}
								
								if (get_field('link_bot_left_zagolovok',$item['id'])) {
									$z = get_field('link_bot_left_zagolovok',$item['id']);
								} else {
									$z = 'Акция';
								}
								
								$result = '<div class="quiz_wrapper"><span class="quiz_wrapper_title">'.$z.'</span><div data-class="popup_quiz" class="popup_main_link_main popup_quiz inpostquiz" ' . $style . '>' . $banner_content . '</div></div>';
								
							}
						}
					}
				}
			} else {
				$result .= 'none';
			}
		}



		echo $result;
		die;
	}

}

if (!function_exists('show_h_info')) {
	add_action( 'wp_ajax_show_h_info', 'show_h_info' );
	add_action( 'wp_ajax_nopriv_show_h_info', 'show_h_info' );
	function show_h_info() {
		$data = $_POST;
		$object = $data['object'];
		$post_id = $data['post_id'];
		
		$goal = $data['goal'];
		$second = $data['second'];
		if(get_post_type($post_id) == 'addpages') {
			
			$review_id = get_field('addpage_review',$post_id);
			$post_id = $review_id;
		} elseif(get_post_type($post_id) == 'promocodes') {
			$review_id = get_field('promocode_review',$post_id);
			$post_id = $review_id;
		}
		$result = '';

//$result = $object.' / '.$goal.' / '.$post_id;
		$term_list = wp_get_post_terms( $post_id, 'affiliate-tags', array('fields' => 'ids') );
		if($goal == 'review_sidebar') {
			$current_language = get_locale();
			if ($current_language == 'ru_RU') {
				if (get_field('base_2_bonuses',$post_id)) {
					if (gettype(get_field('base_2_bonuses',$post_id)) == 'array') {
						$total_counter = 0;
						if (count(get_field('base_2_bonuses',$post_id)) > 0) {
							$result .= '<div class="base_2_bon_sidebar white_block top1" style="padding-top: 0;">';
							$company_name = get_field('company_name',$post_id);
							
							$pattern = '/\([^)]*\)/'; // The regular expression pattern
							$replacement = ''; // The replacement string
							
							$newString_company_name = preg_replace($pattern, $replacement, $company_name); // Perform the replacement
							
							$result .= '<div class="block_title font_smaller_2 font_bolder font_uppercase color_dark_blue" style="margin-left: -30px;margin-right: -30px;text-transform: unset;font-weight: normal;font-size: 16px;color: #5B6068;font-size: 18px;">'.__('Бонусы компании','er_theme').' <span style="color: #001640;text-decoration: none;border-bottom: 1px solid #001640;">'.$newString_company_name.'</span></div>';
							/*$result .= '<span class="base_2_bon_sidebar_title">'.__('Бонусы компании','er_theme').'<span>'.get_field('company_name',$post_id).'</span></span>';*/
							foreach ( get_field( 'base_2_bonuses', $post_id ) as $item ) {
								$total_counter ++;
								
								if ( ! $item['hide_from_rating'] ) {
									if ( $total_counter > 2 ) {
										continue;
									}
									if ( $item['link'] ) {
										
										$result .= '<a class="bonus_div_link bonus_div_link44" href="' . str_replace( "https://etorazvod.ru", "", $item['link'] ) . '" target="_blank" rel="nofollow">';
										if ( wp_is_mobile() && $item['comment'] ) {
											$result .= '<i class="fas fa-question"></i>';
										}
										
									} else {
										$result .= '<div class="bonus_div_link">';
									}
									$result .= '<div class="bonus_div bonus_div_1">';
									if ( $item['bonus_format'] && $item['text'] ) {
										$result .= $item['text'];
										$result .= '<span class="get_bonus_button get_bonus_button_1">' . __( 'Получить', 'er_theme' ) . '</span>';										
									} elseif ( $item['bonus_format'] && ! $item['text'] && $item['comment'] ) {
										$result .= $item['comment'];
									} elseif ( $item['from'] || $item['to'] ) {
										$result .= simple_from_to( $item );
										if ( $item['currency'] ) {
											$result .= ' ';
											$result .= term_field( $item['currency'], 'currencies', 'name' );
										}
										
										$result .= '<span class="get_bonus_button get_bonus_button_2">' . __( 'Получить', 'er_theme' ) . '</span>';										
									}
									
									
									$result .= '</div>';
									if ( $item['link'] ) {
										$result .= '</a>';
									} else {
										$result .= '</div>';
									}

									if ( $item['comment'] ) {											
										$result .= '<div class="bonus_comment">';
										$result .= do_shortcode( $item['comment'] );
										$result .= '</div>';
									}
									//}
								}
							}
							$result .= '</div>';
							
						}
					}
				}
				
				
				$cur_terms = get_field( 'review_aff_tags', $post_id );
				$tttt      = gettype( $cur_terms );
				if ( gettype( $cur_terms ) == 'array' ) {
					//print_r($cur_terms[0]);
					$term_id   = $cur_terms[0];
					$term_name = get_term( $cur_terms[0] )->name;
				} else {
					$cur_terms = get_the_terms( $post_id, 'affiliate-tags' );
					$term_id   = $cur_terms[0]->term_id;
					$term_name = $cur_terms[0]->name;
				}
				
				if ($term_id == 16172) {
					$term_id = 653;
				}
				
				
				
				$args     = array(
					'post_type'      => 'casino',
					'posts_per_page' => 3,
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
					'post_status'    => 'publish',
					'tax_query'      => array(
						array(
							'taxonomy' => 'affiliate-tags',
							'field'    => 'id',
							'terms'    => $term_id,
						),
					),
					'meta_query'	=> array(
						array(
							'key' => 'base_2_bonuses_0_bonus_type',
							'value' => '',
							'compare' => '!='
						)
					)
				);
				if (get_post_type($post_id) == 'casino') {
					$args['post__not_in'] = [$post_id];
				}
				if ( $current_language == 'ru_RU' ) {
					// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
					$args['turn_off_on_ru_language'] = 1;
				}
				$er_posts = new WP_Query( $args );
				
				if ( $er_posts->have_posts() ) {
					$result .= '<div class="base_2_bon_sidebar white_block b-top-3"><div class="block_title font_smaller_2 font_bolder font_uppercase color_dark_blue" style="margin-left: -30px;margin-right: -30px;">Лучшие бонусы</div>';
					$result .= '<table class="er_newtable"><tbody>';
					
					while ( $er_posts->have_posts() ) {
						$er_posts->the_post();
						global $post;
						$post_id = $post->ID;
						$company_name          = get_field( 'company_name', $post_id );
						$short_name_table_post = get_field( 'short_name_table_post', $post_id );
						$link                  = get_bloginfo( 'url' ) . '/visit/' . get_field( 'company_redirect_key', $post_id ) . '/';
						$company_link          = get_the_permalink( $post_id );
						$er_company_site_str   = get_field( 'websites', $post_id )[0]['site_url'];
						$er_company_site_str_2 = preg_replace( '#^[^:/.]*[:/]+#i', '', $er_company_site_str );
						$site                  = preg_replace( '/^www\./', '', rtrim( $er_company_site_str_2, '/' ) );
						$established           = get_field( 'company_established', $post_id );
						/*if ($real_id == 216302) {*/
						if ( get_field( 'company_verified_status', $post_id ) ) {
							$company_verified_status = 'set_modified_verified';
						} else {
							$company_verified_status = '';
						}
						$logo = get_field( 'company_logo', $post_id )['url'];
						
						$result .= '<tr id="row_1" class="odd" data-id="127797">
            <td class="item_first name">';
						$result .= '<div class="er_company_name_img"><a class="er_table_title_link ' . $company_verified_status . '" href="' . $company_link. '" style="background-image:url(' . $logo . ')" rel="nofollow" aria-label="' . $company_name . '"></a></div>';
						
						$company_name = str_replace('.','. ', $company_name);
						
						$pattern = '/\([^)]*\)/'; // The regular expression pattern
						$replacement = ''; // The replacement string
						
						$newString_company_name = preg_replace($pattern, $replacement, $company_name); // Perform the replacement
						
						$result .= ' <div class="er_table_name_site er_modified_table"><a class="er_table_title_name" href="'.$company_link.'">'.$newString_company_name.'</a></div>
            </td>
            <td class="item_2 bonus">
                <div class="bonus-wrapper">';
						$total_counter = 0;
						foreach ( get_field( 'base_2_bonuses', $post_id ) as $item ) {
							$total_counter ++;
							
							if ( ! $item['hide_from_rating'] ) {
								if ( $total_counter > 1 ) {
									break;
								}
								if ( $item['link'] ) {
									
									$result .= '<a class="bonus_div_link bonus_div_link44" href="' . str_replace( "https://etorazvod.ru", "", $item['link'] ) . '" target="_blank" rel="nofollow">';
									/*if ( wp_is_mobile() && $item['comment'] ) {
										$result .= '<i class="fas fa-question"></i>';
									}*/
									
								} else {
									$result .= '<a class="bonus_div_link bonus_div_link44" href="/visit/' . get_field('company_redirect_key',$post_id) . '" target="_blank" rel="nofollow">';
								}
								$result .= '<div class="bonus_div bonus_div_3">';
								if ( $item['bonus_format'] && $item['text'] ) {
									$result .= '<span class="text-v">'.$item['text'].'</span>';
									$result .= '<span class="get_bonus_button get_bonus_button_1">' . __( 'Получить', 'er_theme' ) . '</span>';									
								} elseif ( $item['bonus_format'] && ! $item['text'] && $item['comment'] ) {
									$result .= $item['comment'];
								} elseif ( $item['from'] || $item['to'] ) {
									
									$result .= '<span class="bonus_n">'.simple_from_to( $item );
									if ( $item['currency'] ) {
										$result .= ' ';
										$result .= term_field( $item['currency'], 'currencies', 'name' );
									}
									$result .= '</span>';
									
									$result .= '<span class="get_bonus_button get_bonus_button_2">' . __( 'Получить', 'er_theme' ) . '</span>';
									
								}
								
								
								$result .= '</div>';
								if ( $item['link'] ) {
									$result .= '</a>';
								} else {
									$result .= '</a>';
								}
								if ( $item['comment'] ) {										
									$result .= '<div class="bonus_comment">';
									$result .= do_shortcode( $item['comment'] );
									$result .= '</div>';
								}
								//}
							}
						}
						$result .= '</div>
            </td>
        </tr>';
					}
					
					$result .= '</tbody></table>';
					$result .= '</div>';
				}
				wp_reset_postdata();;

			} else {
				$current_language = get_locale();
				$side_banner_id = 0;
				$banner_place = 'sidebar';
				$arr_rqp = array(
					'post_type' => 'banners',
					'posts_per_page' => 1,
					'post_status' => 'publish',
					'orderby' => 'rand',
					'meta_query' => array(
						'relation'		=> 'AND',
						array(
							'key' => 'banner_posts', // name of custom field
							'value' => serialize( strval( $post_id ) ), // matches exactly "123", not just 123. This prevents a match for "1234"
							'compare' => 'LIKE'
						),
						array(
							'key'	 	=> 'banner_place',
							'value'	  	=> $banner_place,
							'compare' 	=> '=',
						),
						array(
							'key'	 	=> 'banner_paid',
							'value'	  	=> 1,
							'compare' 	=> '=',
						),
					)
				);
				
				if($current_language != 'ru_RU') {
					$arr_rqp['meta_query'][] = array(
						'key'     => 'enable_translations',
						'value'   => $current_language,
						'compare' => 'LIKE'
					);
				} else {
					$arr_rqp['meta_query'][] = array(
						'key'     => 'enable_translations',
						'value'   => '',
						'compare' => '='
					);
				}
				
				$reverse_query_paid = get_posts($arr_rqp);
				
				$arr_rq = array(
					'post_type' => 'banners',
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'orderby' => 'rand',
					'meta_query' => array(
						'relation'		=> 'AND',
						array(
							'key' => 'banner_posts', // name of custom field
							'value' => serialize( strval( $post_id ) ), // matches exactly "123", not just 123. This prevents a match for "1234"
							'compare' => 'LIKE'
						),
						array(
							'key'	 	=> 'banner_place',
							'value'	  	=> $banner_place,
							'compare' 	=> '=',
						),
					)
				);
				
				if($current_language != 'ru_RU') {
					$arr_rq['meta_query'][] = array(
						'key'     => 'enable_translations',
						'value'   => $current_language,
						'compare' => 'LIKE'
					);
				} else {
					$arr_rq['meta_query'][] = array(
						'key'     => 'enable_translations',
						'value'   => '',
						'compare' => '='
					);
				}
				$reverse_query = get_posts($arr_rq);
				if($reverse_query_paid && !empty($reverse_query_paid)) {
					$side_banner_id = $reverse_query_paid[0]->ID;
///echo '<div style="display:none;">';
					///print_r($reverse_query_paid);
					///echo '</div>';
					
				} elseif($reverse_query && !empty($reverse_query) || !empty($term_list)) {
					$side_banners = array();
					$n_term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
					$n_term = get_term_by('slug', $n_term_slug, 'affiliate-tags');
					$term_id = $term_list[0];
					$paid_args_new = array(
						'post_type' => 'banners',
						'posts_per_page' => -1,
//'orderby' => 'rand',
						'post_status' => 'publish',
						'meta_query'	=> array(
							'relation'		=> 'AND',
							array(
								'key'	 	=> 'banner_place',
								'value'	  	=> $banner_place,
								'compare' 	=> '=',
							),
							array(
								'key'	 	=> 'banner_paid',
								'value'	  	=> 1,
								'compare' 	=> '=',
							),
						),
						/*'tax_query' => array(
						array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'id',
						'terms'    => $n_term->term_id,
						),
						),*/
					);
					if($current_language != 'ru_RU') {
						$paid_args_new['meta_query'][] = array(
							'key'     => 'enable_translations',
							'value'   => $current_language,
							'compare' => 'LIKE'
						);
					} else {
						$paid_args_new['meta_query'][] = array(
							'key'     => 'enable_translations',
							'value'   => '',
							'compare' => '=='
						);
					}
					if(!empty($term_list)) {
						$paid_args_new['tax_query'] = array(
							'relation' => 'OR',
						);
						foreach ($term_list as $term_list_item) {
							$paid_args_new['tax_query'][] = array(
								'taxonomy' => 'affiliate-tags',
								'field'    => 'id',
								'terms'    => $term_list_item,
							);
						}
						
					}
					$er_banners_paid_side_term = new WP_Query($paid_args_new  );
					
					if ( $er_banners_paid_side_term->have_posts() ) {
						while ( $er_banners_paid_side_term->have_posts() ) {
							$er_banners_paid_side_term->the_post();
							global $post;
							$side_banners[] = $post->ID;
						}
					} else {
					
					}
					wp_reset_postdata();
					if(!empty($reverse_query)) {
						$side_banners[] = $reverse_query[0]->ID;
//echo $reverse_query[0]->ID;
					}

//echo '<div style="display:none;">reversequery';
					//print_r($reverse_query);
					// echo '</div>';
//if($data['post_id'] == 52798) {
// echo '<div style="display:none;">';
					// print_r($side_banners);
					// echo '</div>';
//}
					$next_sidebar = 1;
					global $wpdb;
					$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
					$side_banners_count = count($side_banners);
					$exists_sidebar = $mydb->get_results("SELECT * FROM `banners_show` WHERE `post_id` = '$post_id'");
					if(!empty($exists_sidebar)) {
						if($exists_sidebar[0]->number == $side_banners_count) {
							if($exists_sidebar[0]->last == $side_banners_count || $exists_sidebar[0]->last > $side_banners_count) {
								$next_sidebar = 1;
							} else {
								$next_sidebar = $exists_sidebar[0]->last + 1;
							}
							$mydb->update(
								'banners_show',
								array('last'=> $next_sidebar),
								array( 'post_id' => $post_id ),
								array( '%s' )
							);
						} else {
							$mydb->update(
								'banners_show',
								array('number'=> $side_banners_count),
								array( 'post_id' => $post_id ),
								array( '%s' )
							);
							$next_sidebar = 1;
						}
					} else {
						$mydb->insert('banners_show',
							array(
								'post_id'=> $post_id,
								'number' => $side_banners_count,
								'last' => 1
							),
							array( '%s', '%s', '%s'));
						$next_sidebar = 1;
					}

//shuffle($side_banners);
					$next_sidebar_chose = $next_sidebar - 1;
					$side_banner_id = $side_banners[$next_sidebar_chose];
					
				} elseif(!empty($term_list)) {
					
					$term_id = $term_list[0];
					$arr_er_banners = array(
						'post_type' => 'banners',
						'posts_per_page' => 1,
						'orderby' => 'rand',
						'post_status' => 'publish',
						'meta_query'	=> array(
							'relation'		=> 'AND',
							array(
								'key'	 	=> 'banner_place',
								'value'	  	=> $banner_place,
								'compare' 	=> '=',
							),
						),
						'tax_query' => array(
							array(
								'taxonomy' => 'affiliate-tags',
								'field'    => 'id',
								'terms'    => $term_id,
							),
						),
					) ;
					if($current_language != 'ru_RU') {
						$arr_er_banners['meta_query'][] = array(
							'key'     => 'enable_translations',
							'value'   => $current_language,
							'compare' => 'LIKE'
						);
					} else {
						$arr_er_banners['meta_query'][] = array(
							'key'     => 'enable_translations',
							'value'   => '',
							'compare' => '=='
						);
					}
					$er_banners = new WP_Query($arr_er_banners);
					if ( $er_banners->have_posts() ) {
						while ( $er_banners->have_posts() ) {
							$er_banners->the_post();
							global $post;
							$side_banner_id = $post->ID;
						}
					} else {
						$side_banner_id = 0;
					}
					wp_reset_postdata();
//echo '<div style="display:none;">emptytermsslist';
					//print_r($term_list);
					// echo $side_banner_id;
					//echo '</div>';
				} else {
					$side_banner_id = 0;
				}
				if($side_banner_id == 0) {


// print_r($term_list);
					$term_id = $term_list[0];
					$arr_er_banners_2 =  array(
						'post_type' => 'banners',
						'posts_per_page' => 1,
						'orderby' => 'rand',
						'post_status' => 'publish',
						'meta_query'	=> array(
							'relation'		=> 'AND',
							array(
								'key'	 	=> 'banner_place',
								'value'	  	=> $banner_place,
								'compare' 	=> '=',
							),
							array(
								'key'	 	=> 'banner_default',
								'value'	  	=> 1,
								'compare' 	=> '!=',
							),
						),
						'tax_query' => array(
							array(
								'taxonomy' => 'affiliate-tags',
								'field'    => 'id',
								'terms'    => $term_id,
							),
						),
					) ;
					if($current_language != 'ru_RU') {
						$arr_er_banners_2['meta_query'][] = array(
							'key'     => 'enable_translations',
							'value'   => $current_language,
							'compare' => 'LIKE'
						);
					} else {
						$arr_er_banners_2['meta_query'][] = array(
							'key'     => 'enable_translations',
							'value'   => '',
							'compare' => '=='
						);
					}
					$er_banners = new WP_Query($arr_er_banners_2);
					if ( $er_banners->have_posts() ) {
						while ( $er_banners->have_posts() ) {
							$er_banners->the_post();
							global $post;
							$side_banner_id = $post->ID;
						}
					} else {
						$def_array = array(
							'post_type' => 'banners',
							'posts_per_page' => 1,
							'orderby' => 'rand',
							'post_status' => 'publish',
							'meta_query'	=> array(
								'relation'		=> 'AND',
								array(
									'key'	 	=> 'banner_place',
									'value'	  	=> $banner_place,
									'compare' 	=> '=',
								),
								array(
									'key'	 	=> 'banner_default',
									'value'	  	=> 1,
									'compare' 	=> '=',
								),
							),
						
						);
						
						if($current_language != 'ru_RU') {
							$def_array['meta_query'][] = array(
								'key'     => 'enable_translations',
								'value'   => $current_language,
								'compare' => 'LIKE'
							);
						} else {
							$def_array['meta_query'][] = array(
								'key'     => 'enable_translations',
								'value'   => '',
								'compare' => '=='
							);
						}
						
						$default_sidebar = new WP_Query($def_array) ;
						/**/
//print_r($default_sidebar);
						if ( $default_sidebar->have_posts() ) {
							while ( $default_sidebar->have_posts() ) {
								$default_sidebar->the_post();
								global $post;
								$side_banner_id = $post->ID;
							}
						} else {
							$side_banner_id = 0;
						}
						wp_reset_postdata();
					}
					wp_reset_postdata();
//$side_banner_id = 0;
				}
				if($side_banner_id && $side_banner_id != 0 && $side_banner_id != '') {
					
					$rows = get_field('banner_links',$side_banner_id);
					if($rows) $i = 0; {
						shuffle( $rows );
						foreach($rows as $row) {
// $link_active = $row['banner_link_active'];
							
							if ($row['banner_link']) {
								$i++; if($i==2) break;
								$link = $row['banner_link'];
							} else {
								continue;
							}
							
						}
					}
					if (get_field('banner_type',$side_banner_id) && get_field('banner_type',$side_banner_id) == 'image') {
						if (get_field('banner_file',$side_banner_id)) {
							$banner_content = '<div data-img="'.get_field('banner_file',$side_banner_id)['url'].'" class="b_img_main b_number_1" style="background-image:url('.get_field('banner_file',$side_banner_id)['url'].'); height:'.get_field('banner_file',$side_banner_id)['sizes']['large-height'].'px"></div>';
							if (get_locale() == 'ru_RU') {
								if (get_field('connect_with_posts',$side_banner_id)) {
									if (gettype(get_field('connect_with_posts',$side_banner_id)) == 'array') {
										if (count(get_field('connect_with_posts',$side_banner_id)) > 0) {
											$connect_with_posts = get_field('connect_with_posts',$side_banner_id)[0];
											if (get_field('websites_0_site_url',$connect_with_posts)) {
												$er_company_site_str_2 = preg_replace( '#^[^:/.]*[:/]+#i', '', get_field('websites_0_site_url',$connect_with_posts) );
												$site                  = preg_replace( '/^www\./', '', rtrim( $er_company_site_str_2, '/' ) );
												$banner_content .= '<span class="b_description_title">Реклама - '.$site.'</span>';
											}
										}
									}
								}
							}
						} else {
							$banner_content = get_the_title($side_banner_id);
						}
					} elseif (get_field('banner_type',$side_banner_id) && get_field('banner_type',$side_banner_id) == 'text_button') {
						if (get_field('banner_text_button',$side_banner_id)) {
							$banner_content = get_field('banner_text_button',$side_banner_id);
						} else {
							$banner_content = __('Перейти','er_theme');
						}
						
					} else {
						if (get_field('banner_code',$side_banner_id)) {
							$banner_content = get_field('banner_code',$side_banner_id);
						} else {
							$banner_content = get_the_title($side_banner_id);
						}
					}
					$result .= '<div class="block" id="sidebar_banner';
					if (!get_field('disable_floating',$side_banner_id)) {
						$result .= '_fixed';
					};
					$result .= '">';
					$result .= '<a rel="nofollow" target="_blank" href="'.$link.'">'.$banner_content.'</a>';
					
					$result .= '</div>';
				} else {
					$result .= 'none';
				}
//$result .= $side_banner_id;
			}
			
		
		} else {
			
			if($goal == 'popup') {
				$promocodes_query = new WP_Query( array(
					'post_type' => 'promocodes',
					'post_status' => 'publish',
					'meta_query' => array(
						array(
							'key' => 'promocode_review', // name of custom field
							'value' => $post_id, // matches exactly "123", not just 123. This prevents a match for "1234"
							'compare' => '='
						)
					)
				
				) );
				if($promocodes_query->have_posts()) {
					while ( $promocodes_query->have_posts() ) {
						$promocodes_query->the_post();
						global $post;
						$promo_p_id = $post->ID;
					}
				} else {
					$promo_p_id = 0;
					$p_array = array();
				}
				wp_reset_postdata();
				$hour = 12;
				$today              = strtotime($hour . ':00:00');
				$yesterday          = strtotime('-1 day', $today);
				
				
				if($promo_p_id != 0) {
					$promocodes = get_field('promocodes_items',$promo_p_id);
					if($promocodes && !empty($promocodes))  {
						$ppp = 0;
						foreach ($promocodes as $item) {
							$date_end_m = strtotime($item['date_end']);
							if(($date_end_m < $yesterday && !empty($item['date_end']) && $item['date_end'] != 'None') || ($item['hide_promos'] == 'yes')) {
							
							} else {
								if($ppp == 7) {
									break;
								}
								$ppp++;
								$p_array[] = $item;
							}
							
						}
					} else {
						$p_array = array();
					}
				} else {
					$p_array = array();
				}
				
			}
			if ($second == 1) {
				if(!empty($term_list)) {
					$term_id = $term_list[0];
					if($term_id == 15603) {
						$term_id = 17;
					} elseif($term_id == 16172) {
						$term_id = 653;
					} elseif($term_id == 9786) {
						$term_id = 664;
					}
					$show_ids = array();
					$args = array(
						'post_type' => 'casino',
						'posts_per_page' => 3,
						'post_status' => 'publish',
						'orderby' => 'menu_order',
						'order' => 'ASC',
						'tax_query' => array(
							array(
								'taxonomy' => 'affiliate-tags',
								'field'    => 'id',
								'terms'    => $term_id,
							)
						),
					);
					$term_human_title = get_field('tag_human_title','term_'.$term_id);
					
					if($goal == 'popup') {
						$curr_bonuses = get_field( 'base_2_bonuses', $post_id );
						if(!empty($curr_bonuses)) {
							$show_ids[] = $post_id;
							$args['posts_per_page'] = 8;
							$args['post__not_in'] = array($post_id);
						} else {
							$args['posts_per_page'] = 9;
						}
						$args['meta_query'] = array(
							'relation'		=> 'AND',
							array(
								'key' => 'base_2_bonuses',
								'value' => 0,
								'compare' => '>'
							)
						);
						$current_language = get_locale();
						if ( $current_language == 'ru_RU' ) {
							// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
							$args['turn_off_on_ru_language'] = 1;
						}
						
						if(wp_get_post_parent_id($post_id) != 0 && get_page_template_slug($post_id) == 'template-rating.php') {
							$fields = get_field('more_fields',$post_id);
							if(!empty($fields)) {
								foreach($fields as $field) {
									$args['meta_query'][] = array(
										'key' => get_term( $field['key'], 'field_types' )->slug,
										'value' => $field['value'],
										'compare' => 'LIKE',
									);
									
								}
							}
						}
					}
					
					/*if ($goal == 'rating_1') {
					if ( ! empty( $fields ) ) {
					$args['meta_query'] = array(
					'relation' => 'AND',
					);
					foreach ( $fields as $field ) {
					$key = get_term( $field['key'], 'field_types' )->slug;
					if ( $key == 'filter_top_bet' ) {
					$args['posts_per_page'] = 10;
					}
					}
					$args['meta_query'][] = get_more_fields_company($args,$fields);
					}
					}*/
					
					if(strpos($goal, 'rating_') !== false){
						$fields = get_field('more_fields',$post_id);
						if ( ! empty( $fields ) ) {
							$args['meta_query'] = array(
								'relation' => 'AND',
							);
							foreach ( $fields as $field ) {
								$key = get_term( $field['key'], 'field_types' )->slug;
								if ( $key == 'filter_top_bet' ) {
									$args['posts_per_page'] = 10;
								}
							}
							$args['meta_query'][] = get_more_fields_company($args,$fields);
						}
					}

					if ( $current_language == 'ru_RU' ) {
						$args['turn_off_on_ru_language'] = 1;
					}

					$reviews = new WP_Query( $args );
					if ( $reviews->have_posts() ) {
						while ( $reviews->have_posts() ) {
							$reviews->the_post();
							global $post;
							$show_ids[] = $post->ID;
						}
						wp_reset_postdata();
					}
					$show_ids = array_unique($show_ids);
					global $detect_city;
					$language = get_locale();
					if($goal == 'popup') {
						if (count($show_ids) != 0) {
							$result .= '<div class="popup_container heygo_container heygo_listing_bonus '.count($show_ids).'" id="popup_'.$goal.'" data-test="'.count($show_ids).'" data-set="3">';
							$result .= '<div class="popup_window box_shadow flex flex_column">';
							$result .= '<div class="popup_close_button pointer" data-id="'.$goal.'"></div>';
							if($term_human_title && $term_human_title != '') {
								$result .= '<div class="title color_dark_blue font_bolder m_b_30 font_uppercase font_smaller_2">'.__('Лучшие бонусы категории','er_theme').' '.$term_human_title.' '.__('сегодня','er_theme');
								if($detect_city && $detect_city != '') {
									if ($language == 'ru_RU') {
										$result .= ' для г. '.$detect_city;
									}
								}
								$result .= '</div>';
							} else {
								$result .= '<div class="title color_dark_blue font_bolder m_b_30 font_uppercase font_smaller_2">'.__('Самые выгодные предложения месяца','er_theme');
								if($detect_city && $detect_city != '') {
									if ($language == 'ru_RU') {
										$result .= ' для г. '.$detect_city;
									}
								}
								$result .= '</div>';
							}
							
							
							
							
							if (count($show_ids) == 1) {
								$result .= '<div class="arrow_top_companies_wrap" style="display: none"><div class="arrow_left_top_companies"></div>';
								$result .= '<div class="arrow_right_top_companies"></div></div>';
							} else {
								$result .= '<div class="arrow_top_companies_wrap"><div class="arrow_left_top_companies"></div>';
								$result .= '<div class="arrow_right_top_companies"></div></div>';
							}
							
							
							
							
							if (count($show_ids) == 1) {
								$result .= '<ul class="flex top_companies_heygo heygoone_cols_wrapper top_companies_heygo_best_com top_companies_heygo_best_com_1">';
							} elseif (count($show_ids) == 2) {
								$result .= '<ul class="flex top_companies_heygo heygotwo_cols_wrapper top_companies_heygo_best_com top_companies_heygo_best_com_2">';
							} else {
								$result .= '<ul class="flex top_companies_heygo top_companies_heygo_best_com top_companies_heygo_best_com_3">';
							}
							
							foreach($show_ids as $id) {
								
								$company_name = get_field( 'company_name', $id );
								$bonus        = get_field( 'base_2_bonuses', $id )[0];
								if ( $bonus['bonus_format'] && $bonus['text'] ) {
									$bonus_title = $bonus['text'];
								} elseif ( $bonus['from'] || $bonus['to'] ) {
									$bonus_title = simple_from_to( $bonus );
									if ( $bonus['currency'] ) {
										$bonus_title .= ' ';
										$bonus_title .= term_field( $bonus['currency'], 'currencies', 'name' );
									}
								} else {
									$bonus_title = $company_name;
								}
								if ( count( $show_ids ) == 1 ) {
									$result .= '<li class="white_block border_radius_4px heygo_one_cols_item" id="heygo_top_' . $id . '">';
								} elseif ( count( $show_ids ) == 2 ) {
									$result .= '<li class="white_block border_radius_4px heygo_two_cols_item" id="heygo_top_' . $id . '">';
								} else {
									if ($language == 'ru_RU') {
										$excplusive = 'ЭКСКЛЮЗИВ';
									} else {
										$excplusive = 'EXCLUSIVE';
									}
									$result .= '<li class="white_block border_radius_4px heygo2" id="heygo_top_' . $id . '"><span class="exclusive_b">'.$excplusive.'</span>';
								}
								
								$result .= '<div class="block_header">';
								
								if ( function_exists( 'review_redirect_link' ) ) {
									$link = review_redirect_link( $id );
								} else {
									$link = '';
								}
								$result  .= '<a href="' . $link . '" class="review_logo" target="_blank"';
								$logo    = get_field( 'company_logo', $id );
								$logo_bg = get_field( 'company_icon_bg', $id );
								if ( $logo_bg && $logo_bg != '' ) {
									$bg = ' background-color:' . $logo_bg . ';';
								} else {
									$bg = '';
								}
								
								if ( $logo && ! empty( $logo ) ) {
									$result .= ' style="background-image:url(' . $logo['sizes']['large'] . ');' . $bg . '"';
								}
								$result .= '></a>';
								$term_slug = get_term( get_field('company_type',$id), 'companytypes' )->name;
								if (in_array($term_slug, array('bloggers'))) {
									$result .= '<div class="color_dark_blue font_bold font_18">'.get_field( 'company_name', $id ).'</div>';
								}
								//$result .= review_logo($id);
								$result  .= '<div class="color_dark_blue font_bold font_new_medium">' . $bonus_title . '</div>';
								$result  .= '</div>';
								$result  .= '<div class="block_footer">';
								$excerpt = get_the_excerpt( $id );
								if ( $excerpt && $excerpt != '' ) {
									$result .= '<div class="font_smaller color_dark_gray field_1 m_b_10">' . do_shortcode( $bonus['comment'] ) . '</div>';
								}
								
								//$result .= '<div class="font_smaller color_dark_blue field_2 font_bold">Поле 2</div>';
								//$result .= '<div class="font_smaller color_dark_blue field_3 font_bold">Поле 3</div>';
								
								
								//$result .= '<div class="font_little color_dark_gray field_3">Поле 5</div>';
								$result .= '</div>';
								if ( $link != '' ) {
									if( function_exists( 'replace_ru_domain_for_lang' ) ) {
										$bonus['link'] = replace_ru_domain_for_lang( $bonus['link'], $language );
									}
									$result .= '<a href="' . $bonus['link'] . '" class="go_more pointer" target="_blank">' . __( 'Получить', 'er_theme' ) . '</a>';
								}
								$result .= '</li>';
								
							}
							$result .= '</ul>';
							
							if($goal == 'popup') {
								if (count($show_ids) < 4) {
									$result .= '<div class="flex heygo_slider" style="display: none;">';
								} else {
									$result .= '<div class="flex heygo_slider">';
								}
								$result .= '<span class="active number_1" data-number="1"></span>';
								$result .= '<span class="inactive number_2" data-number="2"></span>';
								if (count($show_ids) > 6) {
									$result .= '<span class="inactive number_3" data-number="3"></span>';
								}
								$result .= '</div>';
								if (count($show_ids) < 2) {
									$result .= '<div class="flex heygo_slider_mobile" style="display: none;">';
								} else {
									$result .= '<div class="flex heygo_slider_mobile">';
								}
								for ($i = 1;$i <= count($show_ids);$i++) {
									if ( $i == 1 ) {
										$result .= '<span class="active number_'.$i.'" data-number="'.$i.'"></span>';
									} else {
										$result .= '<span class="inactive number_'.$i.'" data-number="'.$i.'"></span>';
									}
								}
								$result .= '</div>';
								
								
							}
							$result .= '</div>';
							$result .= '</div>';
						} else {
							$result .= 'none';
						}
					} else {
						if (count($show_ids) != 0) {
							shuffle($show_ids);
							$result .= '<div id="hey_content_'.$goal.'" class="white_block inline_heygo" data-type="'.$goal.'"  data-id="'.$post_id.'" data-more-field="'.get_field('more_fields',$post_id)[0]['key'].'" data-id-set="'.wp_get_post_parent_id($post_id).'" data-id-set-new="'.get_page_template_slug($post_id).'">';
							$id = $show_ids[0];
							$company_name = get_field('company_name',$id);
							$description = get_the_excerpt($id);
							$button_text = get_field('review_button_text',$id);
							if(!$button_text || $button_text == '') {
								$button_text = __('Регистрация','er_theme');
							}
							if(function_exists('review_redirect_link')) {
								$link = review_redirect_link($id);
							} else {
								$link = '';
							}
							
							$term_slug = get_term( get_field('company_type',$id), 'companytypes' )->name;
							$term = get_term_by('slug', $term_slug, 'affiliate-tags');
							$img = get_field('img_promo_banner','term_'.$term->term_id);
							$result .= '<div class="block_header flex">';
							$result .= review_logo($id);
							$result .= '<div class="company_title flex flex_column t0">';
							$result .= '<span class="color_dark_blue font_small font_bold m_b_5">'.$company_name.'</span>';
							$result .= '<span class="color_dark_gray font_smaller">'.__('Реклама','er_theme').'</span>';
							$result .= '</div>';
							if($link != '') {
								$result .= '<a href="'.$link.'" class="button button_heygo font_bold button_violet pointer link_no_underline font_18" target="_blank" rel="nofollow">'.$button_text.'</a>';
							}
							if(($description && $description != '' && $goal == 'rating_1') || ($description && $description != '' && $goal == 'rating_2')|| ($description && $description != '' && $goal == 'rating_3')) {
								$result .= '<div class="hey_description">'.$description.'</div>';
							}
							$result .= '</div>';
							if($img && $img != '') {
								$result .= '<div class="hey_image" style="background-image:url('.$img.');" data-id="'.count($show_ids).'"></div>';
							} else {
								$result .= '<div class="hey_image" data-id="'.count($show_ids).'"></div>';
							}
							if($description && $description != '' && $goal != 'rating_1' && $goal != 'rating_2' && $goal != 'rating_3') {
								$result .= '<div class="hey_description">'.$description.'</div>';
							}
							$result .= '</div>';
						}
					}
					if ($goal == 'quizpost') {
						$current_language = get_locale();
						$banners = [];
						$r_q_args = array(
							'post_type'      => 'banners',
							'posts_per_page' => 1,
							'post_status'    => 'publish',
							'orderby'        => 'rand',
							'meta_query'     => array(
								'relation' => 'AND',
								array(
									'key'     => 'banner_posts',
									'value'   => serialize( strval( $post_id ) ),
									'compare' => 'LIKE'
								),
								array(
									'key'     => 'banner_place',
									'value'   => array( 'post_quiz' ),
									'compare' => 'IN',
								)
							)
						);
						if ( $current_language != 'ru_RU' ) {
							$r_q_args['meta_query'][] = array(
								'key'     => 'enable_translations',
								'value'   => $current_language,
								'compare' => 'LIKE'
							);
						}
						$reverse_query = get_posts( $r_q_args );
						$a             = 0;
						if ( ! empty( $reverse_query ) ) {
							//banner_posts_ignore
							foreach ( $reverse_query as $item ) {
								$banners[] = array(
									'id'   => $item->ID,
									'time' => 10
								);
							}
						}
						wp_reset_postdata();
						
						
						$term_list = wp_get_post_terms( $post_id, 'affiliate-tags', array( 'fields' => 'ids' ) );
						
						if ( ! empty( $term_list ) ) {
							$a                .= 2;
							$r_q_args_by_tags = array(
								'post_type'      => 'banners',
								'posts_per_page' => - 1,
								'post_status'    => 'publish',
								'orderby'        => 'rand',
								'meta_query'     => array(
									'relation' => 'AND',
									array(
										'key'     => 'banner_place',
										'value'   => array( 'post_quiz' ),
										'compare' => 'IN',
									),
									array(
										'key'     => 'banner_default',
										'value'   => 1,
										'compare' => '!=',
									)
								),
								'tax_query'      => array(
									array(
										'taxonomy' => 'affiliate-tags',
										'field'    => 'id',
										'terms'    => $term_list,
									),
								),
							);
							if ( $current_language != 'ru_RU' ) {
								$r_q_args_by_tags['meta_query'][] = array(
									'key'     => 'enable_translations',
									'value'   => $current_language,
									'compare' => 'LIKE'
								);
							}
							$by_tags = get_posts( $r_q_args_by_tags );
							if ( ! empty( $by_tags ) ) {
								//banner_posts_ignore
								foreach ( $by_tags as $item ) {
									$banners[] = array(
										'id'   => $item->ID,
										'time' => 10
									);
								}
							}
						}
						if ( ! empty( $banners ) ) {
							foreach ( $banners as $item ) {
								//banner_posts_ignoreВАЖНО
								$rows         = get_field( 'banner_links', $item['id'] );
								$banner_type  = get_field( 'banner_type', $item['id'] );
								$banner_place = get_field( 'banner_place', $item['id'] );
								$trigger      = get_field( 'banner_triggers', $item['id'] );
								$seconds      = $item['time'];
								$i            = 0;
								if ( $rows && ! empty( $rows ) ) {
									shuffle( $rows );
									foreach ( $rows as $row ) {
										$link_active = $row['banner_link_active'];
										if ( $row['banner_link'] ) {
											$i ++;
											$link = $row['banner_link'];
											if ( $i == 2 ) {
												break;
											};
										} else {
											continue;
										}
									}
								}
								if ( $banner_type == 'image' ) {
									if ( get_field( 'link_bot_color_text', $item['id'] ) ) {
										$color = get_field( 'link_bot_color_text', $item['id'] );
									} else {
										$color = '#FFF';
									}
									$banner_content = '';
									if ( get_field( 'link_bot_zagolovok', $item['id'] ) ) {
										$banner_content .= '<span class="title_quiz" style="color:' . $color . '">' . get_field( 'link_bot_zagolovok', $item['id'] ) . '</span>';
									}
									if ( get_field( 'link_bot_text', $item['id'] ) ) {
										$banner_content .= '<span class="desc_quiz" style="color:' . $color . '">' . get_field( 'link_bot_text', $item['id'] ) . '</span>';
									}
									$banner_content .= '<div class="social_links_quiz">';
									
									
									if ( get_field( 'link_bot_links_viber_link', $item['id'] ) ) {
										if ( get_field( 'link_bot_links_viber_text', $item['id'] ) ) {
											$text = get_field( 'link_bot_links_viber_text', $item['id'] );
										} else {
											$text = 'Viber';
										}
										$banner_content .= '<a href="' . get_field( 'link_bot_links_viber_link', $item['id'] ) . '" class="link viber" data-id="' . $item['id'] . '"><img src="/wp-content/themes/eto-razvod-1/img/viber.svg" alt="">' . $text . '</a>';
									}
									
									if ( get_field( 'link_bot_links_telegram_link', $item['id'] ) ) {
										if ( get_field( 'link_bot_links_telegram_text', $item['id'] ) ) {
											$text = get_field( 'link_bot_links_telegram_text', $item['id'] );
										} else {
											$text = 'Telegram';
										}
										$banner_content .= '<a href="' . get_field( 'link_bot_links_telegram_link', $item['id'] ) . '" class="link telegram" data-id="' . $item['id'] . '"><img src="/wp-content/themes/eto-razvod-1/img/telegram.svg" alt="">' . $text . '</a>';
									}
									$banner_content .= '</div>';
									
									if ( get_field( 'banner_file', $item['id'] ) ) {
										$style = 'style="background: url(' . get_field( 'banner_file', $item['id'] )['url'] . ');"';
									} else {
										$style = '';
									}
									
									if (get_field('link_bot_left_zagolovok',$item['id'])) {
										$z = get_field('link_bot_left_zagolovok',$item['id']);
									} else {
										$z = 'Акция';
									}
									
									$result = '<div class="quiz_wrapper"><span class="quiz_wrapper_title">'.$z.'</span><div data-class="popup_quiz" class="popup_main_link_main popup_quiz inpostquiz" ' . $style . '>' . $banner_content . '</div></div>';
									
								}
							}
						}
					}
				}  else {
					$result .= 'none';
				}
			} elseif($goal == 'popup' && !empty($p_array)) {
//$result .= 'none';
				
				$result .= '<div class="popup_container heygo_container promocode_heygo" id="popup_'.$goal.'" >';
				$result .= '<div class="popup_window box_shadow flex flex_column">';
				$result .= '<div class="popup_close_button pointer" data-id="'.$goal.'"></div>';
				$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
				$term = get_term_by('slug', $term_slug, 'affiliate-tags');
				
				if (get_field('img_promo_special',$post_id)) {
					$img = get_field('img_promo_special',$post_id);
				} elseif (get_field('img_promo_banner','term_'.$term->term_id)) {
					$img = get_field('img_promo_banner','term_'.$term->term_id);
				} else {
					$img = get_field('img_promo_banner','term_'.$term->term_id);
				}
				if($img && $img != '') {
					$result .= '<div class="promo_heygo_top" style="background-image:url('.$img.');">';
				} else {
					$result .= '<div class="promo_heygo_top">';
				}
				
				$result .= review_logo($post_id);
				$result .= '</div>';
				if (count($p_array) == 1) {
					$result .= '<div class="arrow_top_promocodes_wrap" style="display: none"><div class="arrow_left_top_promocodes"></div>';
					$result .= '<div class="arrow_right_top_promocodes"></div></div>';
				} else {
					$result .= '<div class="arrow_top_promocodes_wrap"><div class="arrow_left_top_promocodes"></div>';
					$result .= '<div class="arrow_right_top_promocodes"></div></div>';
				}
				$result .= '<ul class="heygo_promocodes" data-count="'.count($p_array).'" data-count-list="">';
				$yyyyy = 0;
				foreach ($p_array as $item) {
					$yyyyy++;
					$result .= '<li id="heygo_promocodes_'.$post_id.'_'.$yyyyy.'">';
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
					if($size != '') {
						$result .= '<div class="font_bold font_big m_b_20 discount_size">' . $size . '</div>';
					} else {
						$result .= '<div class="font_bold font_big m_b_20 discount_size_text">' . $item_type . '</div>';
					}
					if($item['title'] != '') {
						$result .= '<div class="popup_big_promos_title font_18 font_bold m_t_15">' . $item['title'] . '</div>';
					}
					
					$result .= '<div class="promocode_button_container">';
					
					if($item['text'] != '' && $item['text'] != 'Не нужен') {
						$result .= '<div class="promocode_text_container" id="promocode_text_container_'.$post->ID.'_'.$yyyyy.'">';
						
						$result .= '<div class="promocode_single_text" id="promocode_text_'.$post->ID.'_'.$yyyyy.'">'.$item['text'].'</div>';
						$result .= '<input value="'.$item['text'].'" type="text" id="promocode_text_'.$post->ID.'_'.$yyyyy.'_input" style="position: absolute;z-index: -99999;">';
						$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold get_promocode_1" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$yyyyy.'/" target="_blank" rel="nofollow">'.__('Получить','er_theme').'</a>';
						$result .= '<div class="link_promocode_text_copy button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Скопировать','er_theme').'</div>';
						$result .= '</div>';
					} else {
						$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold get_promocode_2" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$yyyyy.'/" target="_blank" rel="nofollow">'.__('Получить','er_theme').'</a>';
					}
					$result .='</div>';
					if($item['description'] != '') {
						$result .= '<div class="promocode_full_description color_dark_gray font_small">'.$item['description'].'</div>';
						$result .= '<span class="font_smaller color_dark_gray inactive dropdown pointer flex link_promocode_show_more">'.__('Подробнее','er_theme').'</span>';
					}
					$result .= '</li>';
				}
				$result .= '</ul>';
				
				
				if (count($p_array) < 2) {
					$result .= '<div class="flex heygo_slider_dots heygo_slider_big_promocodes" style="display: none;">';
				} else {
					$result .= '<div class="flex heygo_slider_dots heygo_slider_big_promocodes">';
				}
				for ($i = 1;$i <= count($p_array);$i++) {
					if ( $i == 1 ) {
						$result .= '<span class="active number_'.$i.'" data-number="'.$i.'"></span>';
					} else {
						$result .= '<span class="inactive number_'.$i.'" data-number="'.$i.'"></span>';
					}
				}
				$result .= '</div>';
				
				/*if (count($p_array) <= 1) {
				$result .= '<div class="flex heygo_slider_big_block_pro_codes_slider" style="display: none;">';
					
					} else {
					$result .= '<div class="flex heygo_slider_big_block_pro_codes_slider">';
						}
						$i = 0;
						foreach ($p_array as $item) {
						$i = ++$i;
						if ($i == 1) {
						$result .= '<span class="active number_1" data-number="1"></span>';
						
						} else {
						$result .= '<span class="inactive number_'.$i.'" data-number="'.$i.'"></span>';
						}
						}*/
				
				$result .= '</div>';
				
				$result .= '</div>';
				$result .= '</div>';
				
				
				
				
				
				
				
				
				
				/////////////////////////////////////////////////////////////
				
				///
				///
				///
				///
				///           /////////////////////////////////
			} elseif(!empty($term_list)) {
				$term_id = $term_list[0];
				if($term_id == 15603) {
					$term_id = 17;
				} elseif($term_id == 16172) {
					$term_id = 653;
				} elseif($term_id == 9786) {
					$term_id = 664;
				}
				$show_ids = array();
				$args = array(
					'post_type' => 'casino',
					'posts_per_page' => 3,
					'post_status' => 'publish',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'tax_query' => array(
						array(
							'taxonomy' => 'affiliate-tags',
							'field'    => 'id',
							'terms'    => $term_id,
						)
					),
				);
				$term_human_title = get_field('tag_human_title','term_'.$term_id);
				
				if($goal == 'popup') {
					$curr_bonuses = get_field( 'base_2_bonuses', $post_id );
					if(!empty($curr_bonuses)) {
						$show_ids[] = $post_id;
						$args['posts_per_page'] = 8;
						$args['post__not_in'] = array($post_id);
					} else {
						$args['posts_per_page'] = 9;
					}
					$args['meta_query'] = array(
						'relation'		=> 'AND',
						array(
							'key' => 'base_2_bonuses',
							'value' => 0,
							'compare' => '>'
						)
					);
					
					
					if(wp_get_post_parent_id($post_id) != 0 && get_page_template_slug($post_id) == 'template-rating.php') {
						$fields = get_field('more_fields',$post_id);
						if(!empty($fields)) {
							foreach($fields as $field) {
								$args['meta_query'][] = array(
									'key' => get_term( $field['key'], 'field_types' )->slug,
									'value' => $field['value'],
									'compare' => 'LIKE',
								);
								
							}
						}
					}
				}
				
				/*if ($goal == 'rating_1') {
				if ( ! empty( $fields ) ) {
				$args['meta_query'] = array(
				'relation' => 'AND',
				);
				foreach ( $fields as $field ) {
				$key = get_term( $field['key'], 'field_types' )->slug;
				if ( $key == 'filter_top_bet' ) {
				$args['posts_per_page'] = 10;
				}
				}
				$args['meta_query'][] = get_more_fields_company($args,$fields);
				}
				}*/
				
				if(strpos($goal, 'rating_') !== false){
					$fields = get_field('more_fields',$post_id);
					if ( ! empty( $fields ) ) {
						$args['meta_query'] = array(
							'relation' => 'AND',
						);
						foreach ( $fields as $field ) {
							$key = get_term( $field['key'], 'field_types' )->slug;
							if ( $key == 'filter_top_bet' ) {
								$args['posts_per_page'] = 10;
							}
						}
						$args['meta_query'][] = get_more_fields_company($args,$fields);
					}
				}
				
				$reviews = new WP_Query( $args );
				if ( $reviews->have_posts() ) {
					while ( $reviews->have_posts() ) {
						$reviews->the_post();
						global $post;
						$show_ids[] = $post->ID;
					}
					wp_reset_postdata();
				}
				$show_ids = array_unique($show_ids);
				global $detect_city;
				$language = get_locale();
				if($goal == 'popup') {
					if (count($show_ids) != 0) {
						$result .= '<div class="popup_container heygo_container heygo_listing_bonus '.count($show_ids).'" id="popup_'.$goal.'" data-test="'.count($show_ids).'" data-set="3">';
						$result .= '<div class="popup_window box_shadow flex flex_column">';
						$result .= '<div class="popup_close_button pointer" data-id="'.$goal.'"></div>';
						if($term_human_title && $term_human_title != '') {
							$result .= '<div class="title color_dark_blue font_bolder m_b_30 font_uppercase font_smaller_2">'.__('Лучшие бонусы категории','er_theme').' '.$term_human_title.' '.__('сегодня','er_theme');
							if($detect_city && $detect_city != '') {
								if ($language == 'ru_RU') {
									$result .= ' для г. '.$detect_city;
								}
							}
							$result .= '</div>';
						} else {
							$result .= '<div class="title color_dark_blue font_bolder m_b_30 font_uppercase font_smaller_2">'.__('Самые выгодные предложения месяца','er_theme');
							if($detect_city && $detect_city != '') {
								if ($language == 'ru_RU') {
									$result .= ' для г. '.$detect_city;
								}
							}
							$result .= '</div>';
						}
						
						
						
						
						if (count($show_ids) == 1) {
							$result .= '<div class="arrow_top_companies_wrap" style="display: none"><div class="arrow_left_top_companies"></div>';
							$result .= '<div class="arrow_right_top_companies"></div></div>';
						} else {
							$result .= '<div class="arrow_top_companies_wrap"><div class="arrow_left_top_companies"></div>';
							$result .= '<div class="arrow_right_top_companies"></div></div>';
						}
						
						
						
						
						if (count($show_ids) == 1) {
							$result .= '<ul class="flex top_companies_heygo heygoone_cols_wrapper top_companies_heygo_best_com top_companies_heygo_best_com_1">';
						} elseif (count($show_ids) == 2) {
							$result .= '<ul class="flex top_companies_heygo heygotwo_cols_wrapper top_companies_heygo_best_com top_companies_heygo_best_com_2">';
						} else {
							$result .= '<ul class="flex top_companies_heygo top_companies_heygo_best_com top_companies_heygo_best_com_3">';
						}
						
						foreach($show_ids as $id) {
							
							$company_name = get_field( 'company_name', $id );
							$bonus        = get_field( 'base_2_bonuses', $id )[0];
							if ( $bonus['bonus_format'] && $bonus['text'] ) {
								$bonus_title = $bonus['text'];
							} elseif ( $bonus['from'] || $bonus['to'] ) {
								$bonus_title = simple_from_to( $bonus );
								if ( $bonus['currency'] ) {
									$bonus_title .= ' ';
									$bonus_title .= term_field( $bonus['currency'], 'currencies', 'name' );
								}
							} else {
								$bonus_title = $company_name;
							}
							if ( count( $show_ids ) == 1 ) {
								$result .= '<li class="white_block border_radius_4px heygo_one_cols_item" id="heygo_top_' . $id . '">';
							} elseif ( count( $show_ids ) == 2 ) {
								$result .= '<li class="white_block border_radius_4px heygo_two_cols_item" id="heygo_top_' . $id . '">';
							} else {
								if ($language == 'ru_RU') {
									$excplusive = 'ЭКСКЛЮЗИВ';
								} else {
									$excplusive = 'EXCLUSIVE';
								}
								$result .= '<li class="white_block border_radius_4px heygo3" id="heygo_top_' . $id . '"><span class="exclusive_b">'.$excplusive.'</span>';
							}
							
							$result .= '<div class="block_header">';
							
							if ( function_exists( 'review_redirect_link' ) ) {
								$link = review_redirect_link( $id );
							} else {
								$link = '';
							}
							$result  .= '<a href="' . $link . '" class="review_logo" target="_blank"';
							$logo    = get_field( 'company_logo', $id );
							$logo_bg = get_field( 'company_icon_bg', $id );
							if ( $logo_bg && $logo_bg != '' ) {
								$bg = ' background-color:' . $logo_bg . ';';
							} else {
								$bg = '';
							}
							
							if ( $logo && ! empty( $logo ) ) {
								$result .= ' style="background-image:url(' . $logo['sizes']['large'] . ');' . $bg . '"';
							}
							$result .= '></a>';
							$term_slug = get_term( get_field('company_type',$id), 'companytypes' )->name;
							if (in_array($term_slug, array('bloggers'))) {
								$result .= '<div class="color_dark_blue font_bold font_18">'.get_field( 'company_name', $id ).'</div>';
							}
							//$result .= review_logo($id);
							$result  .= '<div class="color_dark_blue font_bold font_new_medium">' . $bonus_title . '</div>';
							$result  .= '</div>';
							$result  .= '<div class="block_footer">';
							$excerpt = get_the_excerpt( $id );
							if ( $excerpt && $excerpt != '' ) {
								$result .= '<div class="font_smaller color_dark_gray field_1 m_b_10">' . do_shortcode( $bonus['comment'] ) . '</div>';
							}
							
							//$result .= '<div class="font_smaller color_dark_blue field_2 font_bold">Поле 2</div>';
							//$result .= '<div class="font_smaller color_dark_blue field_3 font_bold">Поле 3</div>';
							
							
							//$result .= '<div class="font_little color_dark_gray field_3">Поле 5</div>';
							$result .= '</div>';
							if ( $link != '' ) {
								if( function_exists( 'replace_ru_domain_for_lang' ) ) {
									$bonus['link'] = replace_ru_domain_for_lang( $bonus['link'], $language );
								}
								$result .= '<a href="' . $bonus['link'] . '" class="go_more pointer" target="_blank">' . __( 'Получить', 'er_theme' ) . '</a>';
							}
							$result .= '</li>';
							
						}
						$result .= '</ul>';
						
						if($goal == 'popup') {
							if (count($show_ids) < 4) {
								$result .= '<div class="flex heygo_slider" style="display: none;">';
							} else {
								$result .= '<div class="flex heygo_slider">';
							}
							$result .= '<span class="active number_1" data-number="1"></span>';
							$result .= '<span class="inactive number_2" data-number="2"></span>';
							if (count($show_ids) > 6) {
								$result .= '<span class="inactive number_3" data-number="3"></span>';
							}
							$result .= '</div>';
							if (count($show_ids) < 2) {
								$result .= '<div class="flex heygo_slider_mobile" style="display: none;">';
							} else {
								$result .= '<div class="flex heygo_slider_mobile">';
							}
							for ($i = 1;$i <= count($show_ids);$i++) {
								if ( $i == 1 ) {
									$result .= '<span class="active number_'.$i.'" data-number="'.$i.'"></span>';
								} else {
									$result .= '<span class="inactive number_'.$i.'" data-number="'.$i.'"></span>';
								}
							}
							$result .= '</div>';
							
							
						}
						$result .= '</div>';
						$result .= '</div>';
					} else {
						$result .= 'none';
					}
				} else {
					if (count($show_ids) != 0) {
						shuffle($show_ids);
						$result .= '<div id="hey_content_'.$goal.'" class="white_block inline_heygo" data-type="'.$goal.'"  data-id="'.$post_id.'" data-more-field="'.get_field('more_fields',$post_id)[0]['key'].'" data-id-set="'.wp_get_post_parent_id($post_id).'" data-id-set-new="'.get_page_template_slug($post_id).'">';
						$id = $show_ids[0];
						$company_name = get_field('company_name',$id);
						$description = get_the_excerpt($id);
						$button_text = get_field('review_button_text',$id);
						if(!$button_text || $button_text == '') {
							$button_text = __('Регистрация','er_theme');
						}
						if(function_exists('review_redirect_link')) {
							$link = review_redirect_link($id);
						} else {
							$link = '';
						}
						
						$term_slug = get_term( get_field('company_type',$id), 'companytypes' )->name;
						$term = get_term_by('slug', $term_slug, 'affiliate-tags');
						$img = get_field('img_promo_banner','term_'.$term->term_id);
						$result .= '<div class="block_header flex">';
						$result .= review_logo($id);
						$result .= '<div class="company_title flex flex_column t5">';
						$result .= '<span class="color_dark_blue font_small font_bold m_b_5">'.$company_name.'</span>';
						if (get_locale() == 'ru_RU') {
							$result .= '<span class="color_dark_gray font_smaller">'.__('Выбор редакции','er_theme').'</span>';
						} else {
							$result .= '<span class="color_dark_gray font_smaller">'.__('Выбор редакции','er_theme').'</span>';
						}
						
						$result .= '</div>';
						if($link != '') {
							$result .= '<a href="'.$link.'" class="button button_heygo font_bold button_violet pointer link_no_underline font_18" target="_blank" rel="nofollow">'.$button_text.'</a>';
						}
						if(($description && $description != '' && $goal == 'rating_1') || ($description && $description != '' && $goal == 'rating_2')|| ($description && $description != '' && $goal == 'rating_3')) {
							$result .= '<div class="hey_description">'.$description.'</div>';
						}
						$result .= '</div>';
						if($img && $img != '') {
							$result .= '<div class="hey_image" style="background-image:url('.$img.');" data-id="'.count($show_ids).'"></div>';
						} else {
							$result .= '<div class="hey_image" data-id="'.count($show_ids).'"></div>';
						}
						if($description && $description != '' && $goal != 'rating_1' && $goal != 'rating_2' && $goal != 'rating_3') {
							$result .= '<div class="hey_description">'.$description.'</div>';
						}
						$result .= '</div>';
					}
				}
				if ($goal == 'quizpost') {
					$current_language = get_locale();
					$banners = [];
					$r_q_args = array(
						'post_type'      => 'banners',
						'posts_per_page' => 1,
						'post_status'    => 'publish',
						'orderby'        => 'rand',
						'meta_query'     => array(
							'relation' => 'AND',
							array(
								'key'     => 'banner_posts',
								'value'   => serialize( strval( $post_id ) ),
								'compare' => 'LIKE'
							),
							array(
								'key'     => 'banner_place',
								'value'   => array( 'post_quiz' ),
								'compare' => 'IN',
							)
						)
					);
					if ( $current_language != 'ru_RU' ) {
						$r_q_args['meta_query'][] = array(
							'key'     => 'enable_translations',
							'value'   => $current_language,
							'compare' => 'LIKE'
						);
					}
					$reverse_query = get_posts( $r_q_args );
					$a             = 0;
					if ( ! empty( $reverse_query ) ) {
						//banner_posts_ignore
						foreach ( $reverse_query as $item ) {
							$banners[] = array(
								'id'   => $item->ID,
								'time' => 10
							);
						}
					}
					wp_reset_postdata();
					
					
					$term_list = wp_get_post_terms( $post_id, 'affiliate-tags', array( 'fields' => 'ids' ) );
					
					if ( ! empty( $term_list ) ) {
						$a                .= 2;
						$r_q_args_by_tags = array(
							'post_type'      => 'banners',
							'posts_per_page' => - 1,
							'post_status'    => 'publish',
							'orderby'        => 'rand',
							'meta_query'     => array(
								'relation' => 'AND',
								array(
									'key'     => 'banner_place',
									'value'   => array( 'post_quiz' ),
									'compare' => 'IN',
								),
								array(
									'key'     => 'banner_default',
									'value'   => 1,
									'compare' => '!=',
								)
							),
							'tax_query'      => array(
								array(
									'taxonomy' => 'affiliate-tags',
									'field'    => 'id',
									'terms'    => $term_list,
								),
							),
						);
						if ( $current_language != 'ru_RU' ) {
							$r_q_args_by_tags['meta_query'][] = array(
								'key'     => 'enable_translations',
								'value'   => $current_language,
								'compare' => 'LIKE'
							);
						}
						$by_tags = get_posts( $r_q_args_by_tags );
						if ( ! empty( $by_tags ) ) {
							//banner_posts_ignore
							foreach ( $by_tags as $item ) {
								$banners[] = array(
									'id'   => $item->ID,
									'time' => 10
								);
							}
						}
					}
					if ( ! empty( $banners ) ) {
						foreach ( $banners as $item ) {
							//banner_posts_ignoreВАЖНО
							$rows         = get_field( 'banner_links', $item['id'] );
							$banner_type  = get_field( 'banner_type', $item['id'] );
							$banner_place = get_field( 'banner_place', $item['id'] );
							$trigger      = get_field( 'banner_triggers', $item['id'] );
							$seconds      = $item['time'];
							$i            = 0;
							if ( $rows && ! empty( $rows ) ) {
								shuffle( $rows );
								foreach ( $rows as $row ) {
									$link_active = $row['banner_link_active'];
									if ( $row['banner_link'] ) {
										$i ++;
										$link = $row['banner_link'];
										if ( $i == 2 ) {
											break;
										};
									} else {
										continue;
									}
								}
							}
							if ( $banner_type == 'image' ) {
								if ( get_field( 'link_bot_color_text', $item['id'] ) ) {
									$color = get_field( 'link_bot_color_text', $item['id'] );
								} else {
									$color = '#FFF';
								}
								$banner_content = '';
								if ( get_field( 'link_bot_zagolovok', $item['id'] ) ) {
									$banner_content .= '<span class="title_quiz" style="color:' . $color . '">' . get_field( 'link_bot_zagolovok', $item['id'] ) . '</span>';
								}
								if ( get_field( 'link_bot_text', $item['id'] ) ) {
									$banner_content .= '<span class="desc_quiz" style="color:' . $color . '">' . get_field( 'link_bot_text', $item['id'] ) . '</span>';
								}
								$banner_content .= '<div class="social_links_quiz">';
								
								
								if ( get_field( 'link_bot_links_viber_link', $item['id'] ) ) {
									if ( get_field( 'link_bot_links_viber_text', $item['id'] ) ) {
										$text = get_field( 'link_bot_links_viber_text', $item['id'] );
									} else {
										$text = 'Viber';
									}
									$banner_content .= '<a href="' . get_field( 'link_bot_links_viber_link', $item['id'] ) . '" class="link viber" data-id="' . $item['id'] . '"><img src="/wp-content/themes/eto-razvod-1/img/viber.svg" alt="">' . $text . '</a>';
								}
								
								if ( get_field( 'link_bot_links_telegram_link', $item['id'] ) ) {
									if ( get_field( 'link_bot_links_telegram_text', $item['id'] ) ) {
										$text = get_field( 'link_bot_links_telegram_text', $item['id'] );
									} else {
										$text = 'Telegram';
									}
									$banner_content .= '<a href="' . get_field( 'link_bot_links_telegram_link', $item['id'] ) . '" class="link telegram" data-id="' . $item['id'] . '"><img src="/wp-content/themes/eto-razvod-1/img/telegram.svg" alt="">' . $text . '</a>';
								}
								$banner_content .= '</div>';
								
								if ( get_field( 'banner_file', $item['id'] ) ) {
									$style = 'style="background: url(' . get_field( 'banner_file', $item['id'] )['url'] . ');"';
								} else {
									$style = '';
								}
								
								if (get_field('link_bot_left_zagolovok',$item['id'])) {
									$z = get_field('link_bot_left_zagolovok',$item['id']);
								} else {
									$z = 'Акция';
								}
								
								$result = '<div class="quiz_wrapper"><span class="quiz_wrapper_title">'.$z.'</span><div data-class="popup_quiz" class="popup_main_link_main popup_quiz inpostquiz" ' . $style . '>' . $banner_content . '</div></div>';
								
							}
						}
					}
				}
			} else {
				$result .= 'none';
			}
		}
		
		
		
		echo $result;
		die;
	}
	
}


add_action( 'wp_ajax_set_cookie_promo', 'test_function' );
add_action( 'wp_ajax_nopriv_set_cookie_promo', 'test_function' );
function test_function(){

	$cookie_id = $_POST['cookie_id'];
	$cookie_time = $_POST['cookie_time'];
	echo $cookie_id;
	$visit_time = date('F j, Y  g:i a');

	if(!isset($_COOKIE[$cookie_id])) {

		// set a cookie for 1 year
		setcookie($cookie_id, $visit_time, time()+$cookie_time, '/');

	}

	die;
}
