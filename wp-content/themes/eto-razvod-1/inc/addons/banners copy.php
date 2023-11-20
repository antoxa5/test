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
                    'value'	  	=> 'popup',
                    'compare' 	=> '=',
                ),
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

		if(!empty($reverse_query)) {
			foreach ($reverse_query as $item) {
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
            $r_q_args_by_tags = array(
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
            );
            if($current_language != 'ru_RU') {
                $r_q_args_by_tags['meta_query'][] = array(
                    'key'     => 'enable_translations',
                    'value'   => $current_language,
                    'compare' => 'LIKE'
                );
            }
			$by_tags = get_posts($r_q_args_by_tags);

			if(!empty($by_tags)) {
				foreach ($by_tags as $item) {
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

		if(empty($banners)) {
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
                        'value'	  	=> 'popup',
                        'compare' 	=> '=',
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
				foreach ($default as $item) {
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
				$result .= '<div class="popup_banner popup_banner1 border_radius_general box_shadow_general popup_link_main">';
				$result .= '<a class="popup_close_button" id="close_'.$item['id'].'" onclick="euAcceptCookiesWP3();"><a>';
				$result .= '<a href="'.$link.'" target="_blank" rel="nofollow" id="visit_'.$item['id'].'" class="popup_main_link_main">'.$banner_content.'</a>';
				$result .= '</div>';
				$result .= '</div>';
				$result .= '<script>';
				$seconds = $seconds - 6000;
				$result .= '
			function show_'.$item['id'].'() {
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
						if (cookies_exist == "no0") {
							console.log("п");
							setTimeout("show_'.$item['id'].'()", '.$seconds.');
						}
					}
				});
				
				$(document).click( function(e){ // событие клика по веб-документу
				if ($(window).width() > 499 ) {
				
					var div = $( "#visit_'.$item['id'].'" ); // тут указываем ID элемента
						if ( !div.is(e.target) // если клик был не по нашему блоку
						&& div.has(e.target).length === 0 ) { // и не по его дочерним элементам
							div.parent().parent().hide(); // скрываем его
						}
				}
				});
			});
			
			
	document.getElementById("close_'.$item['id'].'").onclick = function() { 
		document.getElementById("popup_'.$item['id'].'").style.display = "none"; 
	} 
	jQuery(function($){
		$("#close_'.$item['id'].'").click(function(){  
			//alert("Если это работает, уже неплохо");
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
			//alert("Если это работает, уже неплохо");
			$.ajax({
			url: "'.admin_url("admin-ajax.php").'",
			type: "POST",
			data: "action=set_cookie_promo&cookie_id=popup_visit_'.$item['id'].'&cookie_time=86400", // было 259200
			success: function( data ) {
				
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
            $reverse_query_paid = get_posts(array(
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
            ));
            if($current_language != 'ru_RU') {
                $reverse_query_paid['meta_query'][] = array(
                    'key'     => 'enable_translations',
                    'value'   => $current_language,
                    'compare' => 'LIKE'
                );
            }
			$reverse_query = get_posts(array(
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
			));
            if($current_language != 'ru_RU') {
                $reverse_query['meta_query'][] = array(
                    'key'     => 'enable_translations',
                    'value'   => $current_language,
                    'compare' => 'LIKE'
                );
            }
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
                $mydb = new wpdb('sendmail','hsd8SGDDdhus','sendmails','localhost');
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
                if($current_language != 'ru_RU') {
                    $er_banners['meta_query'][] = array(
                        'key'     => 'enable_translations',
                        'value'   => $current_language,
                        'compare' => 'LIKE'
                    );
                }
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
                $default_sidebar = new WP_Query( array(
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

                )) ;
                if($current_language != 'ru_RU') {
                    $default_sidebar['meta_query'][] = array(
                        'key'     => 'enable_translations',
                        'value'   => $current_language,
                        'compare' => 'LIKE'
                    );
                }
                //print_r($default_sidebar);
                if ( $default_sidebar->have_posts() ) {
                    while ( $default_sidebar->have_posts() ) {
                        $default_sidebar->the_post();
                        global $post;
                        $side_banner_id = $post->ID;
                    }
                } else {
                   // print_r($term_list);
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
                    if($current_language != 'ru_RU') {
                        $er_banners['meta_query'][] = array(
                            'key'     => 'enable_translations',
                            'value'   => $current_language,
                            'compare' => 'LIKE'
                        );
                    }
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
                    //$side_banner_id = 0;
                }
                wp_reset_postdata();
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
					$result .= '<div class="popup_close_button pointer"></div>';
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
							$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold get_promocode_1" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$yyyyy.'/" target="_blank">'.__('Получить','er_theme').'</a>';
							$result .= '<div class="link_promocode_text_copy button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Скопировать','er_theme').'</div>';
							$result .= '</div>';
						} else {
							$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold get_promocode_2" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$yyyyy.'/" target="_blank">'.__('Получить','er_theme').'</a>';
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
					$result .= '<div class="popup_container heygo_container" id="popup_'.$goal.'" data-test="'.count($show_ids).'" data-set="3">';
					$result .= '<div class="popup_window box_shadow flex flex_column">';
					$result .= '<div class="popup_close_button pointer"></div>';
					if($term_human_title && $term_human_title != '') {
						$result .= '<div class="title color_dark_blue font_bolder m_b_30 font_uppercase font_smaller_2">'.__('Лучшие бонусы категории','er_theme').' '.$term_human_title.' '.__('сегодня','er_theme');
						if($detect_city && $detect_city != '') {
							$result .= ' для г. '.$detect_city;
						}
						$result .= '</div>';
					} else {
						$result .= '<div class="title color_dark_blue font_bolder m_b_30 font_uppercase font_smaller_2">'.__('Самые выгодные предложения месяца','er_theme');
						if($detect_city && $detect_city != '') {
							$result .= ' для г. '.$detect_city;
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
						$result .= '<ul class="flex top_companies_heygo heygoone_cols_wrapper top_companies_heygo_best_com">';
					} elseif (count($show_ids) == 2) {
						$result .= '<ul class="flex top_companies_heygo heygotwo_cols_wrapper top_companies_heygo_best_com">';
					} else {
						$result .= '<ul class="flex top_companies_heygo top_companies_heygo_best_com">';
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
							$result .= '<div class="font_smaller color_dark_gray field_1 m_b_10">' . $bonus['comment'] . '</div>';
						}

						//$result .= '<div class="font_smaller color_dark_blue field_2 font_bold">Поле 2</div>';
						//$result .= '<div class="font_smaller color_dark_blue field_3 font_bold">Поле 3</div>';


						//$result .= '<div class="font_little color_dark_gray field_3">Поле 5</div>';
						$result .= '</div>';
						if ( $link != '' ) {
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
						$result .= '<div class="company_title flex flex_column">';
						$result .= '<span class="color_dark_blue font_small font_bold m_b_5">'.$company_name.'</span>';
						$result .= '<span class="color_dark_gray font_smaller">'.__('Реклама','er_theme').'</span>';
						$result .= '</div>';
						if($link != '') {
							$result .= '<a href="'.$link.'" class="button button_heygo font_bold button_violet pointer link_no_underline font_18" target="_blank">'.$button_text.'</a>';
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