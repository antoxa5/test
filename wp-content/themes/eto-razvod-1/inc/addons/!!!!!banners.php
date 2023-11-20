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
		if(get_post_type($post_id) == 'addpages') {

			$review_id = get_field('addpage_review',$post_id);
			$post_id = $review_id;
		}
		$result = '';
		$banners = array();
		$reverse_query = get_posts(array(
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
					'value'	  	=> 'popup',
					'compare' 	=> '=',
				),
			)
		));
		if(!empty($reverse_query)) {
			foreach ($reverse_query as $item) {
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
			$by_tags = get_posts(array(
				'post_type' => 'banners',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'orderby' => 'rand',
				'meta_query'	=> array(
					'relation'		=> 'AND',
					array(
						'key'	 	=> 'banner_place',
						'value'	  	=> 'popup',
						'compare' 	=> '=',
					),
				),
				'tax_query' => array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'id',
						'terms'    => $term_list,
					),
				),
			));
			if(!empty($by_tags)) {
				foreach ($by_tags as $item) {
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

		if(empty($banners)) {
			$default = get_posts(array(
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
						'value'	  	=> 'popup',
						'compare' 	=> '=',
					),
				),
			));
			if(!empty($default)) {
				foreach ($default as $item) {
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
					$image = get_field('banner_file',$item['id']);
					if($image) {
						$banner_content = '<img data-img="'.$image['url'].'" class="banner_img" src="'.$image['url'].'" />';
					} else {
						$banner_content = get_the_title();
					}
				} elseif ($banner_type == 'text_button') {
					if (get_field('banner_text_button',$item['id'])) {
						$banner_content = get_field('banner_text_button',$item['id']);
					} else {
						$banner_content = __('Перейти','er_theme');
					}
				} else {
					if (get_field('banner_code',$item['id'])) {
						$banner_content = get_field('banner_code',$item['id']);
					} else {
						$banner_content = get_the_title();
					}
				}
				$result .= '<div class="popup_container" id="popup_'.$item['id'].'">';
				$result .= '<div class="popup_banner popup_banner1 border_radius_general box_shadow_general">';
				$result .= '<a class="popup_close_button" id="close_'.$item['id'].'" onclick="euAcceptCookiesWP3();"><a>';
				$result .= '<a href="'.$link.'" target="_blank" rel="nofollow" id="visit_'.$item['id'].'">'.$banner_content.'</a>';
				$result .= '</div>';
				$result .= '</div>';
				$result .= '<script>';
				$seconds = $seconds - 6000;
				$result .= '
			function show_'.$item['id'].'() {
			//alert("hello");
			  document.getElementById("popup_'.$item['id'].'").style.visibility = "visible";
			  document.getElementById("popup_'.$item['id'].'").className = "popup_container popup_fade";
			}
			jQuery(function($){
				$.ajax({
					url: "'.admin_url("admin-ajax.php").'",
					type: "POST",
					data: "action=check_cookie_old&cookie_id=popup_close_'.$item['id'].'&cookie_id_2=popup_visit_'.$item['id'].'", 
					success: function( data ) {
						var cookies_exist = data;
						//alert( cookies_exist );
						if (cookies_exist == "no0") {
						//alert("not yet");
						setTimeout("show_'.$item['id'].'()", '.$seconds.');
						//$( "#popup_'.$item['id'].'" ).hide( 2500 );
						
						}
					}
				});
			});
			
			/*function show_'.$item['id'].'() {
			//alert("hello");
			  document.getElementById("popup_'.$item['id'].'").style.visibility = "visible";
			}
			setTimeout("show()", 1000); */
			document.getElementById("close_'.$item['id'].'").onclick = function() { 

				document.getElementById("popup_'.$item['id'].'").style.display = "none"; 

			} 
			/*
			document.getElementById("popup_'.$item['id'].'").onclick = function() { 

				document.getElementById("popup_'.$item['id'].'").style.display = "none"; 

			} */
				jQuery(function($){ // есть разные варианты этой строчки, но такая мне нравится больше всего, т.к. всегда работает
		$("#close_'.$item['id'].'").click(function(){  
			//alert("Если это работает, уже неплохо"); // выводим сообщение
			$.ajax({
			url: "'.admin_url("admin-ajax.php").'",
			type: "POST",
			data: "action=misha&cookie_id=popup_close_'.$item['id'].'&cookie_time=172800", // можно также передать в виде массива или объекта
			success: function( data ) {
				//alert( data );
			}
		});
		});
	});
	/*
	jQuery(function($){ // есть разные варианты этой строчки, но такая мне нравится больше всего, т.к. всегда работает
		$("#popup_'.$item['id'].'").click(function(){  
			//alert("Если это работает, уже неплохо"); // выводим сообщение
			$.ajax({
			url: "'.admin_url("admin-ajax.php").'",
			type: "POST",
			data: "action=misha&cookie_id=popup_close_'.$item['id'].'&cookie_time=172800", // можно также передать в виде массива или объекта
			success: function( data ) {
				//alert( data );
			}
		});
		});
	});*/
	jQuery(function($){ // есть разные варианты этой строчки, но такая мне нравится больше всего, т.к. всегда работает
		$("#visit_'.$item['id'].'").click(function(){  
			//alert("Если это работает, уже неплохо"); // выводим сообщение
			$.ajax({
			url: "'.admin_url("admin-ajax.php").'",
			type: "POST",
			data: "action=misha&cookie_id=popup_visit_'.$item['id'].'&cookie_time=259200", // можно также передать в виде массива или объекта
			success: function( data ) {
				//alert( data );
			}
		});
		});
	});
			';
				$result .= '</script>';


			}
		}

		//$result .= $post_id;
		//$result .= check_cookie('popup_close_59397');
		echo $result;

	}
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
			}

			if(get_page_template_slug($post_id) == 'template-rating.php' || get_page_template_slug($post_id) == 'template-rating-all.php') {
				$banners['rating_1'] = 'default';
				$banners['rating_2'] = 'default';
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


if (!function_exists('show_h_info')) {
	add_action( 'wp_ajax_show_h_info', 'show_h_info' );
	add_action( 'wp_ajax_nopriv_show_h_info', 'show_h_info' );
	function show_h_info() {
		$data = $_POST;
		$object = $data['object'];
		$post_id = $data['post_id'];
		$goal = $data['goal'];
		if(get_post_type($post_id) == 'addpages') {

			$review_id = get_field('addpage_review',$post_id);
			$post_id = $review_id;
		}
		$result = '';
		//$result = $object.' / '.$goal.' / '.$post_id;
		$term_list = wp_get_post_terms( $post_id, 'affiliate-tags', array('fields' => 'ids') );
		if($goal == 'review_sidebar') {
			$side_banner_id = 0;
			$banner_place = 'sidebar';
			$reverse_query = get_posts(array(
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
				)
			));
			if($reverse_query && !empty($reverse_query)) {
				$side_banner_id = $reverse_query[0]->ID;

			} elseif(!empty($term_list)) {

				$term_id = $term_list[0];
				$er_banners = new WP_Query( array(
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
				) );
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

			} else {
				$side_banner_id = 0;
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
						$banner_content = '<div data-img="'.get_field('banner_file',$side_banner_id)['url'].'" class="banner_img b_number_1" style="background-image:url('.get_field('banner_file',$side_banner_id)['url'].'); height:'.get_field('banner_file',$side_banner_id)['sizes']['large-height'].'px"></div>';
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
			if(!empty($term_list)) {
				$term_id = $term_list[0];
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
						),
					),
				);
				$term_human_title = get_field('tag_human_title','term_'.$term_id);
				if($goal == 'popup') {
					$args['posts_per_page'] = 6;
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

				$reviews = new WP_Query( $args );
				if ( $reviews->have_posts() ) {
					while ( $reviews->have_posts() ) {
						$reviews->the_post();
						global $post;
						$show_ids[] = $post->ID;
					}
					wp_reset_postdata();
				}
				global $detect_city;
				if($goal == 'popup') {
					if (count($show_ids) != 0) {
					$result .= '<div class="popup_container heygo_container" id="popup_'.$goal.'" data-test="'.count($show_ids).'">';
					$result .= '<div class="popup_window box_shadow flex flex_column">';
					$result .= '<div class="popup_close_button pointer"></div>';
					if($term_human_title && $term_human_title != '') {
						$result .= '<div class="title color_dark_blue font_bolder m_b_30 font_uppercase font_smaller_2">'.__('Лучшие бонусы категории','er_theme').' '.$term_human_title.' '.__('для вас сегодня','er_theme');
						
						$result .= '</div>';
					} else {
						$result .= '<div class="title color_dark_blue font_bolder m_b_30 font_uppercase font_smaller_2">'.__('Самые выгодные предложения месяца','er_theme');
						if($detect_city && $detect_city != '') {
							$result .= ' в г. '.$detect_city;
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
						$result .= '<ul class="flex top_companies_heygo heygoone_cols_wrapper">';
					} elseif (count($show_ids) == 2) {
						$result .= '<ul class="flex top_companies_heygo heygotwo_cols_wrapper">';
					} else {
						$result .= '<ul class="flex top_companies_heygo">';
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
							$result .= '<li class="white_block border_radius_4px" id="heygo_top_' . $id . '">';
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

						//$result .= review_logo($id);
						$result  .= '<div class="color_dark_blue font_bold font_new_medium">' . $bonus_title . '</div>';
						$result  .= '</div>';
						$result  .= '<div class="block_footer">';
						$excerpt = get_the_excerpt( $id );
						if ( $excerpt && $excerpt != '' ) {
							$result .= '<div class="font_smaller color_dark_gray field_1 m_b_10">' . $bonus['comment'] . '</div>';
						}

						//$result .= '<div class="font_smaller color_dark_blue field_2 font_bold">Поле 2</div>';
						//$result .= '<div class="font_smaller color_dark_blue field_3 font_bold">Поле 3</div>';


						//$result .= '<div class="font_little color_dark_gray field_3">Поле 5</div>';
						$result .= '</div>';
						if ( $link != '' ) {
							$result .= '<a href="' . $link . '" class="go_more pointer" target="_blank">' . __( 'Получить', 'er_theme' ) . '</a>';
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
					shuffle($show_ids);
					$result .= '<div id="hey_content_'.$goal.'" class="white_block inline_heygo">';
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
					$result .= '<div class="company_title flex flex_column">';
					$result .= '<span class="color_dark_blue font_small font_bold m_b_5">'.$company_name.'</span>';
					$result .= '<span class="color_dark_gray font_smaller">'.__('Реклама','er_theme').'</span>';
					$result .= '</div>';
					if($link != '') {
						$result .= '<a href="'.$link.'" class="button button_heygo font_bold button_violet pointer link_no_underline font_18" target="_blank">'.$button_text.'</a>';
					}
					if($description && $description != '' && $goal == 'rating_1' || $description && $description != '' && $goal == 'rating_2') {
						$result .= '<div class="hey_description">'.$description.'</div>';
					}
					$result .= '</div>';
					if($img && $img != '') {
						$result .= '<div class="hey_image" style="background-image:url('.$img.');"></div>';
					} else {
						$result .= '<div class="hey_image"></div>';
					}
					if($description && $description != '' && $goal != 'rating_1' && $goal != 'rating_2') {
						$result .= '<div class="hey_description">'.$description.'</div>';
					}
					$result .= '</div>';
				}
			} else {
				$result .= 'none';
			}
		}



		echo $result;
		die;
	}

}

