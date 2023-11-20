<?php

add_action( 'after_setup_theme', 'er_load_language', 10 );
function er_load_language() {
	load_theme_textdomain( 'er_theme', TEMPLATEPATH );
}

add_action( 'after_setup_theme', 'er_include_addons', 11 );
function er_include_addons() {
	include_once( TEMPLATEPATH . '/inc/SxGeo.php' );
	include_once( TEMPLATEPATH . '/inc/rating_fields.php' );
	include_once( TEMPLATEPATH . '/inc/addons/navs/navs.php' );
	include_once( TEMPLATEPATH . '/inc/addons/comments_new.php' );
	include_once( TEMPLATEPATH . '/inc/addons/popups_new_test.php' );
	include_once( TEMPLATEPATH . '/inc/post_types.php' );
	include_once( TEMPLATEPATH . '/inc/promocodes_update.php' );
	include_once( TEMPLATEPATH . '/inc/promo_gdeslon_compare_and_update.php' );
	include_once( TEMPLATEPATH . '/inc/promo_advcake_compare_and_update.php' );
	include_once( TEMPLATEPATH . '/inc/addons/comments.php' );
	include_once( TEMPLATEPATH . '/inc/addons/news.php' );
	include_once( TEMPLATEPATH . '/inc/addons/notify.php' );
	include_once( TEMPLATEPATH . '/inc/addons/comments_content.php' );
	include_once( TEMPLATEPATH . '/inc/addons/list_more_ajax.php' );
	include_once( TEMPLATEPATH . '/inc/addons/layout.php' );
	include_once( TEMPLATEPATH . '/inc/addons/similar.php' );
	include_once( TEMPLATEPATH . '/inc/addons/filter.php' );
	include_once( TEMPLATEPATH . '/inc/addons/add_links.php' );
	include_once( TEMPLATEPATH . '/inc/addons/review_widgets.php' );
	include_once( TEMPLATEPATH . '/inc/addons/antibot.php' );
	include_once( TEMPLATEPATH . '/inc/addons/search.php' );
	include_once( TEMPLATEPATH . '/inc/addons/banners.php' );
	include_once( TEMPLATEPATH . '/inc/addons/admin_fix.php' );
	include_once( TEMPLATEPATH . '/inc/addons/redirects.php' );
	include_once( TEMPLATEPATH . '/inc/addons/company_activities.php' );
	include_once( TEMPLATEPATH . '/inc/addons/popups.php' );
	include_once( TEMPLATEPATH . '/inc/addons/breadcrumbs/breadcrumbs.php' );
	include_once( TEMPLATEPATH . '/inc/addons/cookies.php' );
	include_once( TEMPLATEPATH . '/inc/addons/recent.php' );
	include_once( TEMPLATEPATH . '/inc/addons/subscribe.php' );
	include_once( TEMPLATEPATH . '/inc/addons/verify_company.php' );
	include_once( TEMPLATEPATH . '/inc/addons/new_companies.php' );
	include_once( TEMPLATEPATH . '/inc/addons/bookmark.php' );
	include_once( TEMPLATEPATH . '/inc/addons/compare.php' );
	include_once( TEMPLATEPATH . '/inc/addons/blocks.php' );
	include_once( TEMPLATEPATH . '/inc/addons/contents.php' );
	include_once( TEMPLATEPATH . '/inc/options.php' );
	include_once( TEMPLATEPATH . '/inc/addons/fields/repeater.php' );
	include_once( TEMPLATEPATH . '/inc/addons/fields/simple.php' );
	include_once( TEMPLATEPATH . '/inc/addons/rating/rating.php' );
	include_once( TEMPLATEPATH . '/inc/addons/table/table.php' );
	include_once( TEMPLATEPATH . '/inc/addons/profile_functions.php' );
	include_once( TEMPLATEPATH . '/inc/addons/company_dashboard_functions.php' );
	include_once( TEMPLATEPATH . '/inc/addons/seo/custom-seo-options.php' );
	include_once( TEMPLATEPATH . '/inc/addons/user_functions.php' );
	include_once( TEMPLATEPATH . '/inc/addons/test_payments.php' );
}

wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', [], filemtime( TEMPLATEPATH . '/style.css' ) );

if ( ! function_exists( 'live_search' ) ) {
	function live_search( $id ) {
		$result = '';
		$result .= '<form method="post" action="' . admin_url( 'admin-ajax.php' ) . '" class="live_search inactive_live_search" id="' . $id . '">';
		$result .= '<input type="text" name="s" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />';
		$result .= '<div class="input_container">';
		$result .= '<span class="placeholder color_light_gray">' . __( 'Поиск <span class="color_dark_gray">по сайту...</span>', 'er_theme' ). '</span>';
		//$result .= '<span class="example color_dark_gray">'.__('Финам','er_theme').'</span>';
		$result .= '</div>';
		$result .= '<div class="search_icon"></div>';
		$result .= '</form>';
		
		return $result;
	}
}
if ( ! function_exists( 'auth_class' ) ) {
	function auth_class() {
		$result = 'not_logged_in';
		if ( is_user_logged_in() ) {
			$result = 'logged_in';
		}
		
		return $result;
	}
}

if ( ! function_exists( 'print_js_links' ) ) {
	function print_js_links() {
		$links                               = array();
		$links['general']                    = '<script src="' . get_template_directory_uri() . '/js/er-js.js?ver=' . filemtime( TEMPLATEPATH . '/js/er-js.js' ) . '" type="text/javascript"></script>';
		$links['events']                     = '<script src="' . get_template_directory_uri() . '/js/events.js?ver=' . filemtime( TEMPLATEPATH . '/js/events.js' ) . '" type="text/javascript"></script>';
		$links['auth']                       = '<script src="' . get_template_directory_uri() . '/js/er-auth.js?ver=' . filemtime( TEMPLATEPATH . '/js/er-auth.js' ) . '" type="text/javascript"></script>';
		$links['review_tabs']                = '<script src="' . get_template_directory_uri() . '/js/review_tabs.js?ver=' . filemtime( TEMPLATEPATH . '/js/review_tabs.js' ) . '" type="text/javascript"></script>';
		$links['user_profile']               = '<script src="' . get_template_directory_uri() . '/js/user_profile.js?ver=' . filemtime( TEMPLATEPATH . '/js/user_profile.js' ) . '" type="text/javascript"></script>';
		$links['show_block']                 = '<script src="' . get_template_directory_uri() . '/js/show_block.js?ver=' . filemtime( TEMPLATEPATH . '/js/show_block.js' ) . '" type="text/javascript"></script>';
		$links['user_page']                  = '<script src="' . get_template_directory_uri() . '/js/user_page.js?ver=' . filemtime( TEMPLATEPATH . '/js/user_page.js' ) . '" type="text/javascript"></script>';
		$links['comments_loader_dashboard']  = '<script src="' . get_template_directory_uri() . '/js/comments_loader_dashboard.js?ver=' . filemtime( TEMPLATEPATH . '/js/comments_loader_dashboard.js' ) . '" type="text/javascript"></script>';
		$links['abuses_loader_dashboard']    = '<script src="' . get_template_directory_uri() . '/js/abuses_loader_dashboard.js?ver=' . filemtime( TEMPLATEPATH . '/js/abuses_loader_dashboard.js' ) . '" type="text/javascript"></script>';
		$links['user_subscription']          = '<script src="' . get_template_directory_uri() . '/js/user_subscription.js?ver=' . filemtime( TEMPLATEPATH . '/js/user_subscription.js' ) . '" type="text/javascript"></script>';
		$links['user_editor']                = '<script src="' . get_template_directory_uri() . '/js/user_editor.js?ver=' . filemtime( TEMPLATEPATH . '/js/user_editor.js' ) . '" type="text/javascript"></script>';
		$links['cloudpayments']              = '<script src="https://widget.cloudpayments.ru/bundles/cloudpayments"></script>';
		$links['user_wallet']                = '<script src="' . get_template_directory_uri() . '/js/user_wallet.js?ver=' . filemtime( TEMPLATEPATH . '/js/user_wallet.js' ) . '" type="text/javascript"></script>';
		$links['user_wallet_new']            = '<script src="' . get_template_directory_uri() . '/js/user_wallet_new.js?ver=' . filemtime( TEMPLATEPATH . '/js/user_wallet_new.js' ) . '" type="text/javascript"></script>';
		$links['popup_inside_dashboard']     = '<script src="' . get_template_directory_uri() . '/js/popup_inside_dashboard.js?ver=' . filemtime( TEMPLATEPATH . '/js/popup_inside_dashboard.js' ) . '" type="text/javascript"></script>';
		$links['user_zero_message']          = '<script src="' . get_template_directory_uri() . '/js/user_zero_message.js?ver=' . filemtime( TEMPLATEPATH . '/js/user_zero_message.js' ) . '" type="text/javascript"></script>';
		$links['user_wallet_new_test']       = '<script src="' . get_template_directory_uri() . '/js/user_wallet_new_test.js?ver=' . filemtime( TEMPLATEPATH . '/js/user_wallet_new_test.js' ) . '" type="text/javascript"></script>';
		$links['promocode_dashboard_loader'] = '<script src="' . get_template_directory_uri() . '/js/promocode_dashboard_loader.js?ver=' . filemtime( TEMPLATEPATH . '/js/promocode_dashboard_loader.js' ) . '" type="text/javascript"></script>';
		
		return $links;
	}
}
if ( ! function_exists( 'print_css_links' ) ) {
	function print_css_links( $data ) {
		$links                           = array();
		$links['pre_footer']             = '<link rel="stylesheet" id="pre_footer" href="' . get_template_directory_uri() . '/css/pre_footer.css?ver=' . filemtime( TEMPLATEPATH . '/css/pre_footer.css' ) . '" type="text/css" media="all" />';
		$links['comments']               = '<link rel="stylesheet" id="comments" href="' . get_template_directory_uri() . '/css/comments.css?ver=' . filemtime( TEMPLATEPATH . '/css/comments.css' ) . '" type="text/css" media="all" />';
		$links['review_form']            = '<link rel="stylesheet" id="review_form" href="' . get_template_directory_uri() . '/css/review_form.css?ver=' . filemtime( TEMPLATEPATH . '/css/review_form.css' ) . '" type="text/css" media="all" />';
		$links['popup_forms']            = '<link rel="stylesheet" id="popup_forms" href="' . get_template_directory_uri() . '/css/popup_forms.css?ver=' . filemtime( TEMPLATEPATH . '/css/popup_forms.css' ) . '" type="text/css" media="all" />';
		$links['main_footer']            = '<link rel="stylesheet" id="main_footer" href="' . get_template_directory_uri() . '/css/main_footer.css?ver=' . filemtime( TEMPLATEPATH . '/css/main_footer.css' ) . '" type="text/css" media="all" />';
		$links['social_icons']           = '<link rel="stylesheet" id="social_icons" href="' . get_template_directory_uri() . '/css/social_icons.css?ver=' . filemtime( TEMPLATEPATH . '/css/social_icons.css' ) . '" type="text/css" media="all" />';
		$links['subscribe_form']         = '<link rel="stylesheet" id="subscribe_form" href="' . get_template_directory_uri() . '/css/subscribe_form.css?ver=' . filemtime( TEMPLATEPATH . '/css/subscribe_form.css' ) . '" type="text/css" media="all" />';
		$links['recent_visited']         = '<link rel="stylesheet" id="recent_visited" href="' . get_template_directory_uri() . '/css/recent_visited.css?ver=' . filemtime( TEMPLATEPATH . '/css/recent_visited.css' ) . '" type="text/css" media="all" />';
		$links['fast_links']             = '<link rel="stylesheet" id="fast_links" href="' . get_template_directory_uri() . '/css/fast_links.css?ver=' . filemtime( TEMPLATEPATH . '/css/fast_links.css' ) . '" type="text/css" media="all" />';
		$links['review_links']           = '<link rel="stylesheet" id="review_links" href="' . get_template_directory_uri() . '/css/review_links.css?ver=' . filemtime( TEMPLATEPATH . '/css/review_links.css' ) . '" type="text/css" media="all" />';
		$links['review_icons']           = '<link rel="stylesheet" id="review_icons" href="' . get_template_directory_uri() . '/css/review_icons.css?ver=' . filemtime( TEMPLATEPATH . '/css/review_icons.css' ) . '" type="text/css" media="all" />';
		$links['review_top']             = '<link rel="stylesheet" id="review_top" href="' . get_template_directory_uri() . '/css/review_top.css?ver=' . filemtime( TEMPLATEPATH . '/css/review_top.css' ) . '" type="text/css" media="all" />';
		$links['review_content']         = '<link rel="stylesheet" id="review_content" href="' . get_template_directory_uri() . '/css/review_content.css?ver=' . filemtime( TEMPLATEPATH . '/css/review_content.css' ) . '" type="text/css" media="all" />';
		$links['profile_top']            = '<link rel="stylesheet" id="profile_top" href="' . get_template_directory_uri() . '/css/profile_top.css?ver=' . filemtime( TEMPLATEPATH . '/css/profile_top.css' ) . '" type="text/css" media="all" />';
		$links['show_block']             = '<link rel="stylesheet" id="show_block" href="' . get_template_directory_uri() . '/css/show_block.css?ver=' . filemtime( TEMPLATEPATH . '/css/show_block.css' ) . '" type="text/css" media="all" />';
		$links['user_page']              = '<link rel="stylesheet" id="user_page" href="' . get_template_directory_uri() . '/css/user_page.css?ver=' . filemtime( TEMPLATEPATH . '/css/user_page.css' ) . '" type="text/css" media="all" />';
		$links['list_post_single']       = '<link rel="stylesheet" id="list_post_single" href="' . get_template_directory_uri() . '/css/list_post_single.css?ver=' . filemtime( TEMPLATEPATH . '/css/list_post_single.css' ) . '" type="text/css" media="all" />';
		$links['user_editor']            = '<link rel="stylesheet" id="user_editor" href="' . get_template_directory_uri() . '/css/user_editor.css?ver=' . filemtime( TEMPLATEPATH . '/css/user_editor.css' ) . '" type="text/css" media="all" />';
		$links['user_form']              = '<link rel="stylesheet" id="user_form" href="' . get_template_directory_uri() . '/css/user_form.css?ver=' . filemtime( TEMPLATEPATH . '/css/user_form.css' ) . '" type="text/css" media="all" />';
		$links['rating']                 = '<link rel="stylesheet" id="rating" href="' . get_template_directory_uri() . '/css/rating.css?ver=' . filemtime( TEMPLATEPATH . '/css/rating.css' ) . '" type="text/css" media="all" />';
		$links['user_service_form']      = '<link rel="stylesheet" id="user_service_form" href="' . get_template_directory_uri() . '/css/user_service_form.css?ver=' . filemtime( TEMPLATEPATH . '/css/pre_footer.css' ) . '" type="text/css" media="all" />';
		$links['popup_inside_dashboard'] = '<link rel="stylesheet" id="popup_inside_dashboard" href="' . get_template_directory_uri() . '/css/popup_inside_dashboard.css?ver=' . filemtime( TEMPLATEPATH . '/css/popup_inside_dashboard.css' ) . '" type="text/css" media="all" />';
		$links['user_skills']            = '<link rel="stylesheet" id="user_skills" href="' . get_template_directory_uri() . '/css/user_skills.css?ver=' . filemtime( TEMPLATEPATH . '/css/user_skills.css' ) . '" type="text/css" media="all" />';
		
		if ( is_string( $data ) ) {
			return isset( $links[ $data ] ) ? $links[ $data ] : '';
		} elseif ( is_array( $data ) ) {
			$result = '';
			foreach ( $data as $item ) {
				if ( array_key_exists( $item, $links ) ) {
					$result .= $links[ $item ];
				}
			}
			
			return $result;
		} else {
			return '';
		}
		
		
	}
}

if ( ! function_exists( 'user_auth' ) ) {
	add_action( 'wp_ajax_user_auth', 'user_auth' );
	add_action( 'wp_ajax_nopriv_user_auth', 'user_auth' );
	function user_auth() {
		$result = '';
		
		if ( ! is_user_logged_in() ) {
			$result .= '<div class="auth_button button button_green pointer">' . __( 'Вход', 'er_theme' ) . '</div>';
			$result .= '<div class="mobile_auth_icon pointer inactive"></div>';
			$result .= '<div class="user_nav_mobile">';
			$result .= '<div class="user_mobile_close_button pointer"></div>';
			$result .= '<div class="user_mobile_content"></div>';
			$result .= '</div>';
			//$result .= print_js_links()['general'];
			$result .= print_js_links()['events'];
		} else {
			$result .= '<div class="user_bar">';
			//$result .= print_js_links()['general'];
			//$result .= '<div class="user_icon icon_messages"></div>';
			//$result .= '<div class="user_icon icon_notifications"></div>';
			if ( function_exists( 'wp_get_current_user' ) ) {
				$current_user = wp_get_current_user();
				//print_r($current_user);
				$user_id             = $current_user->data->ID;
				$user_display_name_r = $current_user->data->display_name;
				$user_firstname_r    = $current_user->user_firstname;
				if ( $user_firstname_r == '' ) {
					$user_display_name = $user_display_name_r;
				} else {
					$user_display_name = $user_firstname_r;
				}
				$user_picture = get_field( 'photo_profile', 'user_' . $user_id );
				$user_label   = get_field( 'photo_profile', 'user_' . $user_id );
				$user_label   = get_field( 'services_user_services', 'user_' . $user_id )[0];
				$result       .= '<div class="user_picture border_circle"';
				if ( $user_picture && $user_picture != '' ) {
					$result .= ' style="background-image: url(' . $user_picture["sizes"]["thumbnail"] . ')" ';
				}
				$result .= '></div>';
				$result .= '<div class="mobile_user_picture inactive border_circle"';
				if ( $user_picture && $user_picture != '' ) {
					$result .= ' style="background-image: url(' . $user_picture["sizes"]["thumbnail"] . ')" ';
				}
				$result .= '></div>';
				$result .= '<div class="user_name flex inactive_user_nav pointer dropdown">';
				$result .= '<span class="display_name font_bold">' . $user_display_name . '</span>';
				if ( $user_label && $user_label != '' ) {
					$result .= '<span class="user_label font_smaller">' . get_the_title( $user_label ) . '</span>';
				}
				//$result .= '<div class="user_company">Finam</div>';
				$result .= '</div>';
				$result .= '<div class="user_nav_mobile">';
				$result .= '<div class="user_mobile_close_button pointer"></div>';
				$result .= '<div class="user_mobile_content"></div>';
				$result .= '</div>';
				
				//print_r($user_picture);
			}
			$result .= '<div class="user_icon icon_settings inactive_user_settings_nav pointer"></div>';
			$result .= '</div>';
		}
		echo $result;
		die;
	}
}


function user_auth_php() {
	$result = '';
	
	if ( ! is_user_logged_in() ) {
		$result .= '<div class="auth_button button button_green pointer">' . __( 'Вход', 'er_theme' ) . '</div>';
		$result .= '<div class="mobile_auth_icon pointer inactive"></div>';
		$result .= '<div class="user_nav_mobile">';
		$result .= '<div class="user_mobile_close_button pointer"></div>';
		$result .= '<div class="user_mobile_content"></div>';
		$result .= '</div>';
		//$result .= print_js_links()['general'];
		$result .= print_js_links()['events'];
	} else {
		$result .= '<div class="user_bar">';
		//$result .= print_js_links()['general'];
		//$result .= '<div class="user_icon icon_messages"></div>';
		//$result .= '<div class="user_icon icon_notifications"></div>';
		if ( function_exists( 'wp_get_current_user' ) ) {
			$current_user = wp_get_current_user();
			//print_r($current_user);
			$user_id             = $current_user->data->ID;
			$user_display_name_r = $current_user->data->display_name;
			$user_firstname_r    = $current_user->user_firstname;
			if ( $user_firstname_r == '' ) {
				$user_display_name = $user_display_name_r;
			} else {
				$user_display_name = $user_firstname_r;
			}
			$user_picture = get_field( 'photo_profile', 'user_' . $user_id );
			// $user_label   = get_field( 'photo_profile', 'user_' . $user_id );
			$user_label   = get_field( 'services_user_services', 'user_' . $user_id );
			if( isset( $user_label[0] ) ) {
				$user_label = $user_label[0];
			}
			$result       .= '<div class="user_picture border_circle"';
			if ( $user_picture && $user_picture != '' ) {
				$result .= ' style="background-image: url(' . $user_picture["sizes"]["thumbnail"] . ')" ';
			}
			$result .= '></div>';
			$result .= '<div class="mobile_user_picture inactive border_circle"';
			if ( $user_picture && $user_picture != '' ) {
				$result .= ' style="background-image: url(' . $user_picture["sizes"]["thumbnail"] . ')" ';
			}
			$result .= '></div>';
			$result .= '<div class="user_name flex inactive_user_nav pointer dropdown">';
			$result .= '<span class="display_name font_bold">' . $user_display_name . '</span>';
			if ( $user_label && $user_label != '' ) {
				$result .= '<span class="user_label font_smaller">' . get_the_title( $user_label ) . '</span>';
			}
			//$result .= '<div class="user_company">Finam</div>';
			$result .= '</div>';
			$result .= '<div class="user_nav_mobile">';
			$result .= '<div class="user_mobile_close_button pointer"></div>';
			$result .= '<div class="user_mobile_content"></div>';
			$result .= '</div>';
			
			//print_r($user_picture);
		}
		$result .= '<div class="user_icon icon_settings inactive_user_settings_nav pointer"></div>';
		$result .= '</div>';
	}
	return $result;
}

if ( ! function_exists( 'connect_heygo' ) ) {
	function connect_heygo() {
		if ( is_single() || is_page() ) {
			global $post;
			if ($post->ID != 158787) {
				wp_localize_script( 'jquery', 'banners_info', array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'b_p_id'   => $post->ID
				) );
				wp_enqueue_script( 'heygo', get_template_directory_uri() . '/js/heygo.js', array( 'jquery' ), filemtime( TEMPLATEPATH . '/js/heygo.js' ) );
			}
			
		}
	}
}


add_action( 'wp_enqueue_scripts', 'connect_heygo' );
if ( ! function_exists( 'er_js_connect' ) ) {
	function er_js_connect() {
		wp_localize_script( 'jquery', 'my_ajax_object_new',
			array( 'er_blog_url' => get_bloginfo( 'url' ) ) );
		$h_auth_callback = h_auth_config()['callback'];
		wp_enqueue_script( 'er-js', get_template_directory_uri() . '/js/er-js.js', array( 'jquery' ), filemtime( TEMPLATEPATH . '/js/er-js.js' ) );
		wp_enqueue_script( 'first', get_template_directory_uri() . '/js/first.js', array( 'jquery' ), filemtime( TEMPLATEPATH . '/js/first.js' ) );
		wp_enqueue_script( 'events', get_template_directory_uri() . '/js/events.js', array( 'jquery' ), filemtime( TEMPLATEPATH . '/js/events.js' ) );
		wp_enqueue_script( 'append-ajax-content', get_template_directory_uri() . '/js/append-ajax-content.js', array( 'jquery' ), filemtime( TEMPLATEPATH . '/js/append-ajax-content.js' ) );
		
		$rating_fields_group = 0;
		if ( function_exists( 'get_rating_fields_group' ) ) {
			if( isset( $post->ID ) ) {
				$rating_fields_group = get_rating_fields_group( $post->ID );
			}
		}
		
		$current_language = get_locale();
		
		$cookie_text = '<div class="cookies_popup"><div class="cookie_wrap_popup" style="padding-bottom: calc( env(safe-area-inset-bottom) - 20px);"><span class="mobile_cookie_text">' . __( 'Мы используем <a href="/privacy-policy/" target="_blank">файлы cookie</a>.', 'er_theme' ) . '</span><span class="pc_cookie_text">' . __( 'Мы используем файлы cookie, ознакомьтесь <br>с <a href="/privacy-policy/" target="_blank">Политикой конфиденциальности</a>.', 'er_theme' ) . '</span> <span class="closer_coockie_accept"></span></div></div>';
		
		// if ($current_language == 'ru_RU') {
		//     $cookie_text = '<div class="cookies_popup"><div class="cookie_wrap_popup" style="padding-bottom: calc( env(safe-area-inset-bottom) - 20px);"><span class="mobile_cookie_text">Мы используем <a href="/privacy-policy/" target="_blank">файлы cookie</a>.</span><span class="pc_cookie_text">Мы используем файлы cookie, ознакомьтесь <br>с <a href="/privacy-policy/" target="_blank">Политикой конфиденциальности</a>.</span> <span class="closer_coockie_accept"></span></div></div>';
		// } elseif($current_language == 'es_ES') {
		//     $cookie_text = '<div class="cookies_popup"><div class="cookie_wrap_popup" style="padding-bottom: calc( env(safe-area-inset-bottom) - 20px);"><span class="mobile_cookie_text">Utilizamos <a href="/privacy-policy/" target="_blank">cookies</a>.</span><span class="pc_cookie_text">Utilizamos cookies, consulte nuestra <br><a href="/privacy-policy/" target="_blank">política de privacidad</a>.</span> <span class="closer_coockie_accept"></span></div></div>';
		// } elseif($current_language == 'de_DE') {
		//     $cookie_text = '<div class="cookies_popup"><div class="cookie_wrap_popup" style="padding-bottom: calc( env(safe-area-inset-bottom) - 20px);"><span class="mobile_cookie_text">Wir verwenden <a href="/privacy-policy/" target="_blank">Cookies</a>.</span><span class="pc_cookie_text">Wir verwenden Cookies, siehe, unsere <a href="/privacy-policy/" target="_blank">Datenschutzrichtlinie</a> einverstanden.</span> <span class="closer_coockie_accept"></span></div></div>';
		// } elseif($current_language == 'fr_FR') {
		//     $cookie_text = '<div class="cookies_popup"><div class="cookie_wrap_popup" style="padding-bottom: calc( env(safe-area-inset-bottom) - 20px);"><span class="mobile_cookie_text">Nous utilisons <a href="/privacy-policy/" target="_blank">des cookies</a>.</span><span class="pc_cookie_text">Nous utilisons des cookies, consultez <br>notre <a href="/privacy-policy/" target="_blank">politique de confidentialité</a>.</span> <span class="closer_coockie_accept"></span></div></div>';
		// } elseif($current_language == 'pl_PL') {
		//     $cookie_text = '<div class="cookies_popup"><div class="cookie_wrap_popup" style="padding-bottom: calc( env(safe-area-inset-bottom) - 20px);"><span class="mobile_cookie_text">Używamy <a href="/privacy-policy/" target="_blank">plików cookie</a>.</span><span class="pc_cookie_text">Używamy plików cookie, zobacz <a href="/privacy-policy/" target="_blank">Politykę prywatności</a>.</span> <span class="closer_coockie_accept"></span></div></div>';
		// } else {
		//     $cookie_text = '<div class="cookies_popup"><div class="cookie_wrap_popup" style="padding-bottom: calc( env(safe-area-inset-bottom) - 20px);"><span class="mobile_cookie_text">This website uses <a href="/privacy-policy/" target="_blank">cookie files</a>.</span><span class="pc_cookie_text">This website uses cookie files, see our <a href="/privacy-policy/" target="_blank">Privacy Policy</a>.</span> <span class="closer_coockie_accept"></span></div></div>';
		// }
		
		$actual_link = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		if ( ( is_single() || ( is_page() ) && ( ( get_query_var( 'user_profile' ) != 'user_profile' ) && ( ! get_query_var( 'dashboard_type' ) ) ) ) ) {
			global $post;
			wp_localize_script( 'jquery', 'my_ajax_object',
				array(
					'ajax_url'            => admin_url( 'admin-ajax.php' ),
					'current_post_id'     => $post->ID,
					'rating_fields_group' => $rating_fields_group,
					'h_auth_callback'     => $h_auth_callback,
					'actual_link'         => $actual_link,
					'user_id'             => 0,
					'slug'                => 0,
					'cookie_text'         => $cookie_text,
					'post_type'			=> get_post_type()
				) );
		} elseif ( ( get_query_var( 'user_profile' ) == 'user_profile' ) || ( get_query_var( 'dashboard_type' ) ) ) {
			if ( get_query_var( 'user_profile' ) == 'user_profile' ) {
				$slug = 'user_profile';
			} else {
				$slug = get_post_field( 'post_name', get_the_ID() );
			}
			wp_localize_script( 'jquery', 'my_ajax_object',
				array(
					'ajax_url'            => admin_url( 'admin-ajax.php' ),
					'current_post_id'     => get_the_ID(),
					'rating_fields_group' => $rating_fields_group,
					'h_auth_callback'     => $h_auth_callback,
					'actual_link'         => $actual_link,
					'user_id'             => get_query_var( 'user_id' ),
					'slug'                => $slug,
					'cookie_text'         => $cookie_text,
					'post_type'			=> get_post_type()
				) );
		} else {
			wp_localize_script( 'jquery', 'my_ajax_object',
				array(
					'ajax_url'            => admin_url( 'admin-ajax.php' ),
					'current_post_id'     => 0,
					'rating_fields_group' => $rating_fields_group,
					'h_auth_callback'     => $h_auth_callback,
					'actual_link'         => $actual_link,
					'user_id'             => 0,
					'slug'                => 0,
					'cookie_text'         => $cookie_text,
					'post_type'			=> get_post_type()
				) );
		}
		
	}
	
	add_action( 'wp_enqueue_scripts', 'er_js_connect' );
}

if ( ! function_exists( 'popup_nav' ) ) {
	add_action( 'wp_ajax_popup_nav', 'popup_nav' );
	add_action( 'wp_ajax_nopriv_popup_nav', 'popup_nav' );
	
	function popup_nav() {
		$data   = $_POST;
		$result = '';
		if ( $data['nav_place'] == 'header_main' ) {
			$result           .= '<div class="bar">';
			$result           .= '<div class="wrap">';
			$result           .= '<div class="bar_top">';
			$current_language = get_locale();
			if ( $current_language != 'ru_RU' ) {
				$result .= '<a href="' . get_bloginfo( 'url' ) . '" class="logo revieweek"></a>';
			} else {
				$result .= '<a href="' . get_bloginfo( 'url' ) . '" class="logo"></a>';
			}
			
			if ( function_exists( 'live_search' ) ) {
				$result .= live_search( 'bar_search' );
			}
			$result .= '<div class="close_icon pointer"></div>';
			$result .= '</div>';
			if ( function_exists( 'theme_nav' ) ) {
				$result .= '<div class="bar_nav">';
				$result .= '<div class="bar_nav_1 bar_nav_menu">' . theme_nav( 'bar_1', 1, 'bar_1', 'bar_1', 'link_dark_blue font_smaller' ) . '</div>';
				$result .= '<div class="bar_nav_2 bar_nav_menu">' . theme_nav( 'bar_2', 1, 'bar_2', 'bar_2', 'link_dark_blue font_smaller' ) . '</div>';
				$result .= '<div class="bar_nav_3 bar_nav_menu">' . theme_nav( 'bar_3', 1, 'bar_3', 'bar_3', 'link_dark_blue font_smaller' ) . '</div>';
				$result .= '<div class="bar_nav_4 bar_nav_menu">' . theme_nav( 'bar_4', 1, 'bar_4', 'bar_4', 'link_dark_blue font_smaller' ) . '</div>';
				$result .= '<div class="bar_nav_5 bar_nav_menu">' . theme_nav( 'bar_5', 1, 'bar_5', 'bar_5', 'link_dark_blue font_smaller' ) . '</div>';
				$result .= '<div class="bar_nav_6 bar_nav_menu">' . theme_nav( 'bar_6', 1, 'bar_6', 'bar_6', 'link_dark_blue font_smaller' ) . '</div>';
				$result .= '</div>';
			}
			$result .= '</div>';
			$result .= '</div>';
			
			echo '
			<script src="' . get_template_directory_uri() . '/js/er-js.js?ver=' . filemtime( TEMPLATEPATH . '/js/er-js.js' ) . '" type="text/javascript"></script>
			<script type="text/javascript">
				$ = jQuery.noConflict();
				$(document).ready(function() {
					$(\'.close_icon\').click(function() {
						$(\'.bar\').remove();
					});

				});
			</script>
			';
		} elseif ( $data['nav_place'] == 'header_services' ) {
			$result .= '<div class="services_list box_shadow_down font_smaller">';
			$result .= '<a href="' . get_bloginfo( 'url' ) . '/add-company/" class="link_no_underline color_lighter_blue flex flex_column"><i class="icon_service_company"></i><span>' . __( 'Мои компании', 'er_theme' ) . '</span></a>';
			$result .= '<a href="' . get_bloginfo( 'url' ) . '/abuse/" class="link_no_underline color_lighter_blue flex flex_column"><i class="icon_service_abuse"></i><span>' . __( 'Жалобы', 'er_theme' ) . '</span></a>';
			//$result .= '<a class="link_no_underline color_lighter_blue flex flex_column soon"><i class="icon_service_advertise"></i><span>'.__('Разместить рекламу','er_theme').'</span></a>';
			$result .= '<a href="' . get_bloginfo( 'url' ) . '/review/" class="link_no_underline color_lighter_blue flex flex_column"><i class="icon_service_review"></i><span>' . __( 'Отзывы', 'er_theme' ) . '</span></a>';
			$result .= '<a href="#" class="link_no_underline color_lighter_blue flex flex_column pointer" onclick=\'clickAuthAction("gotodashboard_notifications")\'><i class="icon_service_notify"></i><span>' . __( 'Уведомления', 'er_theme' ) . '</span></a>';
			$result .= '<a href="#" class="link_no_underline color_lighter_blue flex flex_column pointer" onclick=\'clickAuthAction("gotodashboard_messages")\'><i class="icon_service_mail"></i><span>' . __( 'Сообщения', 'er_theme' ) . '</span></a>';
			$result .= '<a href="#" class="link_no_underline color_lighter_blue flex flex_column pointer" onclick=\'clickAuthAction("send_blog_post")\'><i class="icon_service_request  send_blog_post"></i><span class=" send_blog_post">' . __( 'Статьи', 'er_theme' ) . '</span></a>';
			$result .= '<a href="#" class="link_no_underline color_lighter_blue flex flex_column pointer" onclick=\'clickAuthAction("gotodashboard_pro")\'><i class="icon_service_pro"></i><span>' . __( 'PRO-аккаунт', 'er_theme' ) . '</span></a>';
			$result .= '<a href="/check/" class="link_no_underline color_lighter_blue flex flex_column"><i class="icon_service_check"></i><span>' . __( 'Расследование', 'er_theme' ) . '</span></a>';
			$result .= '<a href="/order/" class="link_no_underline color_lighter_blue flex flex_column"><i class="icon_service_find"></i><span>' . __( 'Подбор', 'er_theme' ) . '</span></a>';
			$result .= '</div>';
		}
		echo $result;
		die;
	}
}

if ( ! function_exists( 'popup_reg' ) ) {
	add_action( 'wp_ajax_popup_reg', 'popup_reg' );
	add_action( 'wp_ajax_nopriv_popup_reg', 'popup_reg' );
	
	function popup_reg() {
		$result           = '';
		$result           .= '<div class="popup_container" id="popup_reg">';
		$result           .= '<div class="popup_window box_shadow">';
		$result           .= '<div class="popup_close_button pointer"></div>';
		$result           .= '<div class="popup_columns two_columns">';
		$result           .= '<div class="popup_column_left flex_column align_left flex_padding">';
		$result           .= '<div class="title font_new_medium color_dark_blue font_bold m_b_20">' . __( 'Регистрация', 'er_theme' ) . '</div>';
		$result           .= '<form class="regform flex flex_column"  action="' . admin_url( 'admin-ajax.php' ) . '" method="post" id="popup_reg_form">';
		$result           .= '<ul class="reg_type_links font_small flex">';
		$result           .= '<li data-type="user" class="active">' . __( 'Я пользователь', 'er_theme' ) . '</li>';
		$result           .= '<li data-type="company" class="last inactive">' . __( 'Я представитель компании', 'er_theme' ) . '</li>';
		$result           .= '</ul>';
		$result           .= '<input type="hidden" name="reg_type" value="user" />';
		$result           .= '<input type="hidden" name="action" value="user_registration" />';
		$result           .= '<input type="email" name="email" placeholder="' . __( 'Ваш E-mail', 'er_theme' ) . '" class="input_big m_b_10 placeholder_dark">';
		$result           .= '<div class="input_columns">';
		$result           .= '<input type="text" name="firstname" placeholder="' . __( 'Имя', 'er_theme' ) . '" class="input_big m_b_10 placeholder_dark">';
		$result           .= '<input type="text" name="lastname" placeholder="' . __( 'Фамилия', 'er_theme' ) . '" class="input_big m_b_10 placeholder_dark">';
		$result           .= '</div>';
		$result           .= '<input type="password" name="password" placeholder="' . __( 'Пароль', 'er_theme' ) . '" class="input_big m_b_10 placeholder_dark">';
		$result           .= '<input type="password" name="password_repeat" placeholder="' . __( 'Повторите пароль', 'er_theme' ) . '" class="input_big m_b_10 placeholder_dark">';
		$result           .= '<input type="submit" name="submit" class="button button_big button_violet m_b_10 pointer font_small font_bold" value="' . __( 'Зарегистрироваться', 'er_theme' ) . '" id="regbtn">';
		$result           .= '<div class="link_container"><a class="span_link link_terms_popup color_blue pointer font_small" href="' . get_bloginfo( 'url' ) . '/rules/" target="_blank">' . __( 'Условия пользования сайтом', 'er_theme' ) . '</a></div>';
		$result           .= '</form>';
		$result           .= '</div>';
		$result           .= '<div class="popup_column_right flex_column align_left">';
		$current_language = get_locale();
		if ( $current_language == 'ru_RU' ) {
			$result .= '<div class="row_border_bottom flex_row flex_padding" id="social_login_mask">';
			$result .= '<div class="title color_dark_blue font_bold m_b_20">' . __( 'Используйте сервисы для регистрации', 'er_theme' ) . '</div>';
			$result .= social_login_icons( 'full' );
			$result .= '</div>';
		}
		$result .= '<div class="flex_row flex_padding">';
		$result .= '<div class="title color_dark_blue font_bold m_b_20">' . __( 'У вас уже есть аккаунт?', 'er_theme' ) . '</div>';
		$result .= '<div class="button button_big button_green m_b_10 pointer auth_link font_bold font_small">' . __( 'Войти в мой аккаунт', 'er_theme' ) . '</div>';
		$result .= '<div class="link_container"><span class="span_link link_recover_popup color_blue pointer font_small">' . __( 'Восстановить пароль', 'er_theme' ) . '</span></div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}

if ( ! function_exists( 'popup_auth' ) ) {
	add_action( 'wp_ajax_popup_auth', 'popup_auth' );
	add_action( 'wp_ajax_nopriv_popup_auth', 'popup_auth' );
	
	function popup_auth() {
		$result           = '';
		$result           .= print_js_links()['auth'];
		$result           .= '<div class="popup_container" id="popup_auth">';
		$result           .= '<div class="popup_window box_shadow">';
		$result           .= '<div class="popup_close_button pointer"></div>';
		$result           .= '<div class="popup_columns two_columns">';
		$result           .= '<div class="popup_column_left flex_column align_left flex_padding">';
		$result           .= '<div class="title font_new_medium color_dark_blue font_bold m_b_20">' . __( 'Вход', 'er_theme' ) . '</div>';
		$result           .= '<form class="regform flex flex_column"  action="' . admin_url( 'admin-ajax.php' ) . '" method="post" id="popup_auth_form">';
		$result           .= '<input type="hidden" name="action" value="user_login" />';
		$result           .= '<input type="text" name="email" placeholder="' . __( 'Ваш E-mail', 'er_theme' ) . '" class="input_big m_b_10 placeholder_dark">';
		$result           .= '<input type="password" name="password" placeholder="' . __( 'Пароль', 'er_theme' ) . '" class="input_big m_b_15 placeholder_dark">';
		$result           .= '<div class="checkbox_container m_b_10 font_small color_dark_blue">';
		$result           .= '<input type="checkbox" id="remember__input" name="remember" checked="checked" class="custom-checkbox">';
		$result           .= '<label for="remember__input">' . __( 'Запомнить меня', 'er_theme' ) . '</label>';
		$result           .= '</div>';
		$result           .= '<input type="submit" name="submit" class="button button_big button_green m_b_10 pointer font_small font_bold" value="' . __( 'Войти', 'er_theme' ) . '" id="regbtn">';
		$result           .= '<div class="link_container"><span class="span_link link_recover_popup color_blue pointer font_small">' . __( 'Восстановить пароль', 'er_theme' ) . '</span></div>';
		$result           .= '</form>';
		$result           .= '</div>';
		$result           .= '<div class="popup_column_right flex_column align_left">';
		$current_language = get_locale();
		if ( $current_language == 'ru_RU' ) {
			$result .= '<div class="row_border_bottom flex_row flex_padding" id="social_login_mask">';
			$result .= '<div class="title color_dark_blue font_bold m_b_20">' . __( 'Используйте сервисы для входа', 'er_theme' ) . '</div>';
			$result .= social_login_icons( 'full' );
			$result .= '</div>';
		}
		$result .= '<div class="flex_row flex_padding">';
		$result .= '<div class="title color_dark_blue font_bold m_b_20">' . __( 'У вас еще нет аккаунта?', 'er_theme' ) . '</div>';
		$result .= '<div class="button button_big button_violet m_b_10 pointer reg_link font_bold font_small">' . __( 'Создать аккаунт', 'er_theme' ) . '</div>';
		$result .= '<div class="link_container"><a class="span_link link_terms_popup color_blue pointer font_small" href="' . get_bloginfo( 'url' ) . '/rules/" target="_blank">' . __( 'Условия пользования сайтом', 'er_theme' ) . '</a></div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}


if ( ! function_exists( 'user_login' ) ) {
	
	add_action( 'wp_ajax_user_login', 'user_login' );
	add_action( 'wp_ajax_nopriv_user_login', 'user_login' );
	
	function user_login() {
		$data = $_POST;
		//print_r($data);
		$result                      = array();
		$login_data                  = array();
		$login_data['user_login']    = $data['email'];
		$login_data['user_password'] = $data['password'];
		$remember                    = $data['remember'];
		if ( $remember == 'on' ) {
			$login_data['remember'] = true;
		} else {
			$login_data['remember'] = false;
		}
		
		
		$user_verify = wp_signon( $login_data, true );
		if ( is_wp_error( $user_verify ) ) {
			$result['status']  = 'error';
			$result['message'] = $user_verify->get_error_message();
		} else {
			$result['status']  = 'ok';
			$result['message'] = 'ok';
		}
		echo json_encode( $result );
		die;
		
	}
	
}

function __search_by_title_only( $search, &$wp_query ) {
	global $wpdb;
	if ( empty( $search ) ) {
		return $search; // skip processing - no search term in query
	}
	$q      = $wp_query->query_vars;
	$n      = ! empty( $q['exact'] ) ? '' : '%';
	$search =
	$searchand = '';
	foreach ( (array) $q['search_terms'] as $term ) {
		$term      = esc_sql( $wpdb->esc_like( $term ) );
		$search    .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
		$searchand = ' AND ';
	}
	if ( ! empty( $search ) ) {
		$search = " AND ({$search}) ";
		if ( ! is_user_logged_in() ) {
			$search .= " AND ($wpdb->posts.post_password = '') ";
		}
	}
	
	return $search;
}

//add_filter('posts_search', '__search_by_title_only', 500, 2);

if ( ! function_exists( 'pre_footer' ) ) {
	add_action( 'wp_ajax_pre_footer', 'pre_footer' );
	add_action( 'wp_ajax_nopriv_pre_footer', 'pre_footer' );
	function pre_footer() {
		$result        = '';
		$recent_viewed = recent_viewed();
		if ( $recent_viewed && $recent_viewed != 'none' ) {
			$result .= $recent_viewed;
		}
		$result .= '<div class="pre_footer">';
		$result .= print_css_links( 'pre_footer' );
		$result .= '<div class="wrap">';
		$result .= '<div class="pre_footer_text color_dark_blue line_big"><span class="font_bold">' . __( 'eto-razvod.ru', 'er_theme' ) . '</span> ' . __( '&mdash; это крупный информационный сервис обзоров и отзывов о компаниях, которые у всех на слуху и не только. Размещайте жалобы, отзывы и обзоры на компании. Это неоценимо полезно!', 'er_theme' ) . '</div>';
		$result .= '<div class="pre_footer_image"></div>';
		$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}

function pre_footer_php() {
	$result        = '';
	$recent_viewed = recent_viewed();
	if ( $recent_viewed && $recent_viewed != 'none' ) {
		$result .= $recent_viewed;
	}
	$result .= '<div class="pre_footer">';
	$result .= print_css_links( 'pre_footer' );
	$result .= '<div class="wrap">';
	$result .= '<div class="pre_footer_text color_dark_blue line_big"><span class="font_bold">' . __( 'eto-razvod.ru', 'er_theme' ) . '</span> ' . __( '&mdash; это крупный информационный сервис обзоров и отзывов о компаниях, которые у всех на слуху и не только. Размещайте жалобы, отзывы и обзоры на компании. Это неоценимо полезно!', 'er_theme' ) . '</div>';
	$result .= '<div class="pre_footer_image"></div>';
	$result .= '</div>';
	$result .= '</div>';
	return $result;
}


if ( ! function_exists( 'recent_visited' ) ) {
	add_action( 'wp_ajax_recent_visited', 'recent_visited' );
	add_action( 'wp_ajax_nopriv_recent_visited', 'recent_visited' );
	function recent_visited() {
		$result = '';
		$result .= print_css_links( 'recent_visited' );
		$result .= '<div class="recent_visited">';
		$result .= '<div class="wrap">';
		$result .= '<div class="recent_title uppercase font_bold">' . __( 'Вы недавно смотрели', 'er_theme' ) . '</div>';
		$result .= '<div class="recent_content"></div>';
		$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}

if ( ! function_exists( 'user_registration' ) ) {
	
	add_action( 'wp_ajax_user_registration', 'user_registration' );
	add_action( 'wp_ajax_nopriv_user_registration', 'user_registration' );
	
	function user_registration() {
		$data = $_POST;
		//print_r($data);
		$result               = array();
		$errors               = array();
		$last_id_user         = get_field( 'last_id_user', 'option' );
		$last_id_userToUpdate = intval( $last_id_user ) + 1;
		$login                = 'id' . $last_id_userToUpdate;
		update_field( 'last_id_user', $last_id_userToUpdate, 'option' );
		if ( $data['password'] && $data['password'] != '' && $data['password_repeat'] && $data['password_repeat'] != '' ) {
			if ( $data['password'] != $data['password_repeat'] ) {
				$errors[] = __( 'Введенные пароли не совпадают', 'er_theme' );
			}
		} else {
			if ( ! $data['password'] || $data['password'] == '' ) {
				$errors[] = __( 'Введите пароль', 'er_theme' );
			}
			if ( ! $data['password_repeat'] || $data['password_repeat'] = '' ) {
				$errors[] = __( 'Введите повтор пароля', 'er_theme' );
			}
		}
		if ( ! $data['email'] || $data['email'] == '' ) {
			$errors[] = __( 'Укажите E-mail', 'er_theme' );
		}
		if ( ! $data['firstname'] || $data['firstname'] == '' ) {
			$errors[] = __( 'Укажите Имя', 'er_theme' );
		}
		if ( filter_var( $data['email'], FILTER_VALIDATE_EMAIL ) ) {
		} else {
			if ( $data['email'] && $data['email'] != '' ) {
				$errors[] = __( 'Email-адрес некорректен', 'er_theme' );
			}
		}
		if ( email_exists( $data['email'] ) ) {
			if ( $data['email'] && $data['email'] != '' ) {
				$errors[] = __( 'Пользователь с таким email уже зарегистрирован', 'er_theme' );
			}
		}
		if ( ! empty( $errors ) ) {
			$result['status']  = 'error';
			$result['message'] = '';
			$result['message'] .= '<ul>';
			foreach ( $errors as $error ) {
				$result['message'] .= '<li>' . $error . '</li>';
			}
			$result['message'] .= '</ul>';
		} else {
			$userdata = array(
				'user_login'    => $login,
				'user_nicename' => $login,
				'user_pass'     => $data['password'],
				'user_email'    => $data['email'],
				'remember'      => true
			);
			if ( $data['firstname'] && $data['firstname'] != '' ) {
				$userdata['first_name'] = $data['firstname'];
			}
			if ( $data['lastname'] && $data['lastname'] != '' ) {
				$userdata['last_name'] = $data['lastname'];
			}
			if ( $data['firstname'] && $data['firstname'] != '' && $data['lastname'] && $data['lastname'] != '' ) {
				$userdata['display_name'] = $data['firstname'] . ' ' . $data['lastname'];
			} elseif ( $data['firstname'] && $data['firstname'] != '' && ! $data['lastname'] ) {
				$userdata['display_name'] = $data['firstname'];
			} elseif ( ! $data['firstname'] && $data['lastname'] && $data['lastname'] != '' ) {
				$userdata['display_name'] = $data['lastname'];
			} else {
				$userdata['display_name'] = $data['email'];
			}
			$user_id = wp_insert_user( $userdata );
			if ( is_wp_error( $user_id ) ) {
				$result['status']  = 'error333';
				$result['message'] = $user_id->get_error_message();
				$result['mail'] = $data['email'];
			} else {
				//echo $user_id;
				$key = wp_generate_uuid4();
				update_field( 'key_activation', $key, 'user_' . $user_id );
				$user_id_role = new WP_User( $user_id );
				$user_id_role->set_role( 'registereduser' );
				wp_new_user_notification( $user_id, 'user' );
				
				$content_reg = __( 'Пожалуйста, если вы еще это не сделали, заполните ваши интересы в личном кабинете, чтобы мы предложили вам только важную информацию.', 'er_theme' );
				notify_user_action( 'system_registration', $user_id, __( 'Добро пожаловать на сайт!', 'er_theme' ), $content_reg );
				$content_email = wp_sprintf( __( 'Мы отправили письмо для активации на ваш адрес %s. Пожалуйста, перейдите по ссылке, чтобы подтвердить ваш E-mail.', 'er_theme' ), $data['email'] );
				notify_user_action( 'system_activation_email', $user_id, __( 'Подтвердите ваш E-mail', 'er_theme' ), $content_email );
				wp_set_current_user( $user_id );
				wp_set_auth_cookie( $user_id );
				if ( isset( $_COOKIE["_ym_uid"] ) ) {
					$timervop = htmlspecialchars( $_COOKIE["_ym_uid"] );
					update_field( 'client_id_yandex', $timervop, 'user_' . $user_id );
				}
				if ( $data['reg_type'] && $data['reg_type'] != '' ) {
					update_field( 'user_reg_type', $data['reg_type'], 'user_' . $user_id );
				}
				$result['status']  = 'ok';
				$result['message'] = wp_sprintf( __( 'Вы успешно зарегистрировались с E-mail адресом: %s. Ваш пароль: %s', 'er_theme' ), $data['email'], $data['password'] );
				$result['user_id'] = $user_id;
			}
			
		}
		
		print_r( json_encode( $result ) );
		die;
		
	}
	
}

if ( ! function_exists( 'main_footer' ) ) {
	add_action( 'wp_ajax_main_footer', 'main_footer' );
	add_action( 'wp_ajax_nopriv_main_footer', 'main_footer' );
	function main_footer() {
		$result           = '';
		$result           .= '<div class="main_footer">';
		$result           .= fast_links( 'footer_fast_links' );
		$result           .= print_css_links( array( 'main_footer', 'social_icons', 'subscribe_form', 'fast_links' ) );
		$result           .= '<div class="wrap height_footer">';
		$result           .= '<div class="main_footer_navs">';
		$result           .= '<div class="foo_nav">';
		$result           .= '<div class="menu_title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_30">' . __( 'Сообщество', 'er_theme' ) . '</div>';
		
		$result           .= theme_nav( 'foo_1', 0, 'foo_1', 'foo_1', 'link_dark_blue font_smaller' );
		$result           .= '</div>';
		$result           .= '<div class="foo_nav">';
		$result           .= '<div class="menu_title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_30">' . __( 'О нас', 'er_theme' ) . '</div>';
		$result           .= theme_nav( 'foo_2', 0, 'foo_2', 'foo_2', 'link_dark_blue font_smaller' );
		$result           .= '</div>';
		$result           .= '<div class="foo_nav">';
		$result           .= '<div class="menu_title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_30">' . __( 'Для компаний', 'er_theme' ) . '</div>';
		$result           .= theme_nav( 'foo_3', 0, 'foo_3', 'foo_3', 'link_dark_blue font_smaller' );
		$result           .= '</div>';
		$result           .= '</div>';
		$result           .= '<div class="main_footer_right">';
		$result           .= subscribe_form( 'footer_subscribe' );
		$current_language = get_locale();
		if ( $current_language != 'ru_RU' ) {
			$result .= social_networks();
		} else {
			$result .= '<div class="play_buttons">';
			// $result .= '<div class="message_wrapper"><div class="message_inside"><a href="https://play.google.com/store/apps/details?id=ru.etorazvod" target="_blank"><span class="message_img"></span><span class="message_text"><span>'.__('Наше приложение на Android','er_theme').'</span><span>'.__('Скачайте его в Google Play','er_theme').'</span></span></a></div></div>';
			$result .= '<div class="message_wrapper">';
			$result .= '<div class="menu_title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_30">' . __( 'Наши приложения', 'er_theme' ) . '</div>';
			$result .= '<div class="app_wrap_links flex">';
			$result .= '<a href="https://play.google.com/store/apps/details?id=ru.etorazvod" target="_blank" rel="nofollow" class="app_link_android"></a>';
			$result .= '<a href="https://apps.apple.com/ua/app/это-развод/id1612079343?l=ru" target="_blank" rel="nofollow" class="app_link_ios"></a>';
			$result .= '</div>';
			$result .= '</div>';
			$result .= '</div>';
			
			
			$result .= social_networks();
		}
		$result .= '</div>';
		$result .= '</div>';
		$result .= '<div class="footer_bottom_nav">';
		$result .= '<div class="wrap">';
		$result .= theme_nav( 'footer_bottom', 0, 'footer_bottom', 'footer_bottom', 'link_dark_blue font_smaller_2 link_underline' );
		// $result .= do_shortcode('[language-switcher]');
		$result .= '</div>';
		$result .= '</div>';
		$result .= '<div class="copyrights font_smaller_2 color_dark_blue">';
		$result .= '<div class="wrap do_not_translate_css_class">';
		
		// if ( $current_language == 'ru_RU' ) {
		// 	$result .= __( '&copy; Copyright 2015&mdash;', 'er_theme' ) . date( 'Y' ) . ' ' . __( '&laquo;Это развод™&raquo;', 'er_theme' );
		// } else {
		// 	$result .= __( '&copy; Copyright 2015&mdash;', 'er_theme' ) . date( 'Y' ) . ' ' . __( '&laquo;Revieweek™&raquo;', 'er_theme' );
		// }
		
		$result .= __( '&copy; Copyright 2015&mdash;', 'er_theme' ) . date( 'Y' ) . ' ' . __( '&laquo;Это развод™&raquo;', 'er_theme' );
		
		
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}


function main_footer_php() {
	$result           = '';
	$result           .= '<div class="main_footer">';
	$result           .= fast_links( 'footer_fast_links' );
	$result           .= print_css_links( array( 'main_footer', 'social_icons', 'subscribe_form', 'fast_links' ) );
	$result           .= '<div class="wrap height_footer">';
	$result           .= '<div class="main_footer_navs">';
	$result           .= '<div class="foo_nav">';
	$result           .= '<div class="menu_title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_30">' . __( 'Сообщество', 'er_theme' ) . '</div>';
	$result           .= theme_nav( 'foo_1', 0, 'foo_1', 'foo_1', 'link_dark_blue font_smaller' );
	$result           .= '</div>';
	$result           .= '<div class="foo_nav">';
	$result           .= '<div class="menu_title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_30">' . __( 'О нас', 'er_theme' ) . '</div>';
	$result           .= theme_nav( 'foo_2', 0, 'foo_2', 'foo_2', 'link_dark_blue font_smaller' );
	$result           .= '</div>';
	$result           .= '<div class="foo_nav">';
	$result           .= '<div class="menu_title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_30">' . __( 'Для компаний', 'er_theme' ) . '</div>';
	$result           .= theme_nav( 'foo_3', 0, 'foo_3', 'foo_3', 'link_dark_blue font_smaller' );
	$result           .= '</div>';
	$result           .= '</div>';
	$result           .= '<div class="main_footer_right">';
	$result           .= subscribe_form( 'footer_subscribe' );
	$current_language = get_locale();
	if ( $current_language != 'ru_RU' ) {
		$result .= social_networks();
	} else {
		$result .= '<div class="play_buttons">';
		// $result .= '<div class="message_wrapper"><div class="message_inside"><a href="https://play.google.com/store/apps/details?id=ru.etorazvod" target="_blank"><span class="message_img"></span><span class="message_text"><span>'.__('Наше приложение на Android','er_theme').'</span><span>'.__('Скачайте его в Google Play','er_theme').'</span></span></a></div></div>';
		$result .= '<div class="message_wrapper">';
		$result .= '<div class="menu_title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_30">' . __( 'Наши приложения', 'er_theme' ) . '</div>';
		$result .= '<div class="app_wrap_links flex">';
		$result .= '<a href="https://play.google.com/store/apps/details?id=ru.etorazvod" target="_blank" rel="nofollow" class="app_link_android"></a>';
		$result .= '<a href="https://apps.apple.com/ua/app/это-развод/id1612079343?l=ru" target="_blank" rel="nofollow" class="app_link_ios"></a>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		
		
		$result .= social_networks();
	}
	$result .= '</div>';
	$result .= '</div>';
	$result .= '<div class="footer_bottom_nav">';
	$result .= '<div class="wrap">';
	$result .= theme_nav( 'footer_bottom', 0, 'footer_bottom', 'footer_bottom', 'link_dark_blue font_smaller_2 link_underline' );
	// $result .= do_shortcode('[language-switcher]');
	$result .= '</div>';
	$result .= '</div>';
	$result .= '<div class="copyrights font_smaller_2 color_dark_blue">';
	$result .= '<div class="wrap do_not_translate_css_class">';
	
	// if ( $current_language == 'ru_RU' ) {
	// 	$result .= __( '&copy; Copyright 2015&mdash;', 'er_theme' ) . date( 'Y' ) . ' ' . __( '&laquo;Это развод™&raquo;', 'er_theme' );
	// } else {
	// 	$result .= __( '&copy; Copyright 2015&mdash;', 'er_theme' ) . date( 'Y' ) . ' ' . __( '&laquo;Revieweek™&raquo;', 'er_theme' );
	// }
	
	$result .= __( '&copy; Copyright 2015&mdash;', 'er_theme' ) . date( 'Y' ) . ' ' . __( '&laquo;Это развод™&raquo;', 'er_theme' );
	
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
	return $result;
}

if ( ! function_exists( 'subscribe_form' ) ) {
	function subscribe_form( $id ) {
		$result           = '';
		$result           .= '<div class="subscribe_form">';
		$result           .= '<div class="menu_title color_dark_blue font_bolder font_smaller_2 font_uppercase">' . __( 'Подписаться на рассылку', 'er_theme' ) . '</div>';
		$result           .= '<form method="post" action="' . admin_url( 'admin-ajax.php' ) . '" id="' . $id . '">';
		$result           .= '<input type="hidden" name="action" value="ajax_email_subscribe" />';
		$result           .= '<input type="text" name="email" placeholder="' . __( 'Ваш E-mail', 'er_theme' ) . '" />';
		$result           .= '<input type="submit" class="button button_green button_medium  button_zero_radius font_small font_bold pointer" value="' . __( 'Подписаться', 'er_theme' ) . '" />';
		$result           .= '</form>';
		$current_language = get_locale();
		if ( $current_language == 'en_US' ) {
			
			
			//$result .= '<a href="https://twitter.com/Revieweek" class="revieweek_tw">twitter.com/Revieweek</a>';
		}
		$result .= '</div>';
		
		return $result;
	}
}

if ( ! function_exists( 'social_networks' ) ) {
	function social_networks() {
		$current_language = get_locale();
		if ( $current_language == 'ru_RU' ) {
			$result = '';
			$result .= '<div class="social_networks">';
			$result .= '<div class="menu_title color_dark_blue font_bolder font_smaller_2 m_b_30 font_uppercase">' . __( 'Мы в социальных сетях', 'er_theme' ) . '</div>';
			$result .= '<ul>';
			/*$result .= '<li><a href="https://www.instagram.com/etorazvod.ru/" target="_blank" class="social_icon_instagram"></a></li>';*/
			$result .= '<li><a href="https://t.me/etorazvodru" target="_blank" rel="nofollow" class="social_icon_telegram"></a></li>';
			$result .= '<li><a href="https://vk.com/etorazvod" target="_blank" rel="nofollow" class="social_icon_vk"></a></li>';
			$result .= '<li><a href="https://ok.ru/etorazvod" target="_blank" rel="nofollow" class="social_icon_odnoklassniki"></a></li>';
			$result .= '<li><a href="https://twitter.com/etorazvodru" target="_blank" rel="nofollow" class="social_icon_twitter"></a></li>';
			$result .= '<li><a href="https://www.pinterest.ru/etorazvod/" target="_blank" rel="nofollow" class="social_icon_pinterest"></a></li>';
			$result .= '<li><a href="https://zen.yandex.ru/id/5c066820817f780400714af2" target="_blank" rel="nofollow" class="social_icon_yandex"></a></li>';
			$result .= '<li><a href="https://www.youtube.com/channel/UCibinJburN_Qe9w4r04SdeQ" target="_blank" rel="nofollow" class="social_icon_youtube"></a></li>';
			
			$result .= '</ul>';
			$result .= '</div>';
		} elseif ( $current_language == 'fr_FR' ) {
			$result = '';
			$result .= '<div class="social_networks">';
			$result .= '<div class="menu_title color_dark_blue font_bolder font_smaller_2 m_b_30 font_uppercase">' . __( 'Nous sommes sur les médias sociaux', 'er_theme' ) . '</div>';
			$result .= '<ul>';
			$result .= '<li><a href="https://twitter.com/revieweek" target="_blank" rel="nofollow" class="social_icon_twitter"></a></li>';
			$result .= '<li><a href="https://www.facebook.com/revieweek/" target="_blank" rel="nofollow" class="social_icon_facebook"></a></li>';
			
			$result .= '</ul>';
			$result .= '</div>';
		} else {
			$result = '';
			$result .= '<div class="social_networks">';
			$result .= '<div class="menu_title color_dark_blue font_bolder font_smaller_2 m_b_30 font_uppercase">' . __( 'We are on social media', 'er_theme' ) . '</div>';
			$result .= '<ul>';
			$result .= '<li><a href="https://twitter.com/revieweek" target="_blank" rel="nofollow" class="social_icon_twitter"></a></li>';
			$result .= '<li><a href="https://www.facebook.com/revieweek/" target="_blank" rel="nofollow" class="social_icon_facebook"></a></li>';
			
			$result .= '</ul>';
			$result .= '</div>';
		}
		
		return $result;
	}
}

if ( ! function_exists( 'fast_links' ) ) {
	function fast_links( $id ) {
		$current_language = get_locale();
		$result           = '';
		$result           .= '<div class="fast_links inactive" id="' . $id . '">';
		$result           .= '<div class="wrap fast_links_opener pointer">';
		$result           .= '<div class="fast_links_link font_uppercase color_dark_blue font_bolder font_smaller_2 pointer">' . __( 'Быстрые ссылки', 'er_theme' ) . '</div>';
		
		// if ($current_language == 'en_US') {
		// 	$text = 'Explore all categories';
		// } elseif ($current_language == 'fr_FR') {
		// 	$text = 'Explorer toutes les catégories';
		// } elseif ($current_language == 'de_DE') {
		// 	$text = 'Entdecken Sie alle Kategorien';
		// } elseif ($current_language == 'es_ES') {
		// 	$text = 'Explora todas las categorías';
		// } elseif ($current_language == 'pl_PL') {
		// 	$text = 'Przeglądaj wszystkie kategorie';
		// } elseif ($current_language == 'ru_RU') {
		// 	$text = 'Изучите все категории';
		// }
		
		// $result           .= '<div class="fast_links_description font_smaller color_dark_gray">' . $text . '</div>';
		$result           .= '<div class="fast_links_description font_smaller color_dark_gray">' . __( 'Изучите все категории', 'er_theme' ) . '</div>';
		$result           .= '</div>';
		$result           .= '<div class="fast_links_content">';
		$result           .= '<div class="wrap">';
		$result           .= '<div class="fast_links_left">';
		//if ( ! in_array( $current_language, array( 'en_US', 'fr_FR', 'es_ES', 'de_DE' ) ) ) {
		
		if(strpos(theme_nav( 'fast_links_1', 1, 'fast_1', 'fast_1', 'link_dark_blue font_smaller' ), '_item_') !== false) {
			$result .= '<div class="fast_link_item">' . theme_nav( 'fast_links_1', 1, 'fast_1', 'fast_1', 'link_dark_blue font_smaller' ) . '</div>';
		}
		if(strpos(theme_nav( 'fast_links_2', 1, 'fast_2', 'fast_2', 'link_dark_blue font_smaller' ), '_item_') !== false) {
			$result .= '<div class="fast_link_item">' . theme_nav( 'fast_links_2', 1, 'fast_2', 'fast_2', 'link_dark_blue font_smaller' ) . '</div>';
		}
		if(strpos(theme_nav( 'fast_links_3', 1, 'fast_3', 'fast_3', 'link_dark_blue font_smaller' ), '_item_') !== false) {
			$result .= '<div class="fast_link_item">' . theme_nav( 'fast_links_3', 1, 'fast_3', 'fast_3', 'link_dark_blue font_smaller' ) . '</div>';
		}
		if(strpos(theme_nav( 'fast_links_4', 1, 'fast_4', 'fast_4', 'link_dark_blue font_smaller' ), '_item_') !== false) {
			$result .= '<div class="fast_link_item">' . theme_nav( 'fast_links_4', 1, 'fast_4', 'fast_4', 'link_dark_blue font_smaller' ) . '</div>';
		}
		if(strpos(theme_nav( 'fast_links_5', 1, 'fast_5', 'fast_5', 'link_dark_blue font_smaller' ), '_item_') !== false) {
			$result .= '<div class="fast_link_item">' . theme_nav( 'fast_links_5', 1, 'fast_5', 'fast_5', 'link_dark_blue font_smaller' ) . '</div>';
		}
		if(strpos(theme_nav( 'fast_links_6', 1, 'fast_6', 'fast_6', 'link_dark_blue font_smaller' ), '_item_') !== false) {
			$result .= '<div class="fast_link_item">' . theme_nav( 'fast_links_6', 1, 'fast_6', 'fast_6', 'link_dark_blue font_smaller' ) . '</div>';
		}
		
		//}
		
		if(strpos(theme_nav( 'fast_links_7', 1, 'fast_7', 'fast_7', 'link_dark_blue font_smaller' ), '_item_') !== false) {
			$result .= '<div class="fast_link_item">' . theme_nav( 'fast_links_7', 1, 'fast_7', 'fast_7', 'link_dark_blue font_smaller' ) . '</div>';
		}
		
		if(strpos(theme_nav( 'fast_links_8', 1, 'fast_8', 'fast_8', 'link_dark_blue font_smaller' ), '_item_') !== false) {
			$result .= '<div class="fast_link_item">' . theme_nav( 'fast_links_8', 1, 'fast_8', 'fast_8', 'link_dark_blue font_smaller' ) . '</div>';
		}
		//if ( ! in_array( $current_language, array( 'en_US', 'fr_FR', 'es_ES', 'de_DE' ) ) ) {
		if(strpos(theme_nav( 'fast_links_9', 1, 'fast_9', 'fast_9', 'link_dark_blue font_smaller' ), '_item_') !== false) {
			$result .= '<div class="fast_link_item">' . theme_nav( 'fast_links_9', 1, 'fast_9', 'fast_9', 'link_dark_blue font_smaller' ) . '</div>';
		}
		
		//}
		$result .= '</div>';
		$result .= '<div class="fast_links_right">';
		if(strpos(theme_nav( 'fast_links_10', 1, 'fast_10', 'fast_10', 'link_dark_blue font_smaller' ), '_item_') !== false) {
			$result .= '<div class="fast_link_item">' . theme_nav( 'fast_links_10', 1, 'fast_10', 'fast_10', 'link_dark_blue font_smaller' ) . '</div>';
		}
		
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		
		return $result;
	}
}

if ( ! function_exists( 'review_breadcrumbs' ) ) {
	function review_breadcrumbs( $post_id ) {
		$result = '';
		$result .= '<div class="review_breadcrumbs color_medium_gray font_smaller_2">';
		$result .= '<span>zdes budut hlebnye kkroshki</span>';
		$result .= '</div>';
		
		return $result;
	}
}

if ( ! function_exists( 'detect_city' ) ) {
	function detect_city() {
		/*$result = '';
		$SxGeo = new SxGeo(TEMPLATEPATH . '/inc/SxGeoCity.dat');
		$ip = '79.142.197.140';
		$city = $SxGeo->get($ip);
		$result .= $city['city']['name_ru'];
		return $result;*/
		global $detect_city;
		$ip          = $_SERVER['HTTP_X_FORWARDED_FOR'];
		$SxGeo       = new SxGeo( TEMPLATEPATH . '/inc/SxGeoCity.dat' );
		$city        = $SxGeo->get( $ip );
		$detect_city = $city['city']['name_ru'];
	}
}

add_action( 'init', 'detect_city' );

if ( ! function_exists( 'review_main' ) ) {
	function review_main( $post_id, $type = '' ) {
		$result        = '';
		$result        .= '<div class="review_main">';
		$company_title = get_field( 'company_name', $post_id );
		
		if ( get_post_type() == 'promocodes' ) {
			$company_title = get_the_title();
			if ( $company_title && $company_title != '' ) {
				$result .= '<h1 class="review_company_title review_company_title_1 font_bold font_medium_new color_dark_blue" itemscope="" itemtype="http://schema.org/Organization">' . $company_title . '</h1>';
			}
		} else {
			if ( $company_title && $company_title != '' ) {
				$current_language = get_locale();
				$content          = apply_filters( 'the_content', get_the_content() );
				if ( $current_language != 'ru_RU' ) {
					$content = get_the_content();
				}
				$result .= '<meta itemprop="name" content="' . $company_title . '">';
				if ( $content && $content != '' ) {
					if (preg_match('/[А-Яа-яЁё]/u', $company_title) == 1) {
						$result .= '<div class="review_company_title review_company_title_3 font_bold font_medium_new color_dark_blue" itemscope="" itemtype="http://schema.org/Organization">' . $company_title . '</div>';
					} else {
						$result .= '<div class="review_company_title review_company_title_3 font_bold font_medium_new color_dark_blue do_not_translate_css_class" itemscope="" itemtype="http://schema.org/Organization">' . $company_title . '</div>';
					}
					
				} else {
					if ( $type == 'single_review_page' ) {
						$result .= '<div class="review_company_title font_bold font_medium_new color_dark_blue link_no_underline" itemscope="" itemtype="http://schema.org/Organization">' . $company_title . '</div>';
					} else {
						if (preg_match('/[А-Яа-яЁё]/u', $company_title) == 1) {
							$result .= '<h1 class="review_company_title review_company_title_2 font_bold font_medium_new color_dark_blue" itemscope="" itemtype="http://schema.org/Organization">' . $company_title . '</h1>';
						} else {
							$result .= '<h1 class="review_company_title review_company_title_2 font_bold font_medium_new color_dark_blue do_not_translate_css_class" itemscope="" itemtype="http://schema.org/Organization">' . $company_title . '</h1>';
						}
					}
					
				}
			}
		}
		
		
		if ( function_exists( 'get_rating_fields_group' ) ) {
			$rating_fields_group = get_rating_fields_group( $post_id );
		} else {
			$rating_fields_group = 0;
		}
		$result .= '<div class="stars_and_reviews flex" itemscope="" itemprop="aggregateRating" itemtype="https://schema.org/AggregateRating">';
		
		$reviews_count = get_field( 'reviews_count_reviews', $post_id );
		
		if ( ( get_post_type() == 'addpages' ) || ( $type == 'single_review_page' ) ) {
			$result .= get_post_stars( $rating_fields_group, $post_id, $reviews_count );
		} else {
			$result .= get_post_stars( $rating_fields_group, 0, $reviews_count );
		}
		$result        .= '<div class="stars_and_reviews_counts flex flex_column m_l_15 font_small line_big">';
		
		if ( ! $reviews_count || $reviews_count == '' ) {
			$reviews_count = 0;
		}
		if ( $reviews_count ) {
			if ( get_query_var( 'comment_single_page' ) ) {
				$comment = get_query_var( 'comment_single_page' );
				$result  .= '<div class="reviews_count_reviews"><span class="color_dark_gray">' . __( 'Всего отзывов', 'er_theme' ) . '</span> <a class="color_dark_blue link_dashed link_no_underline" href="' . get_the_permalink( $comment->comment_post_ID ) . '#comments">' . $reviews_count . '</a></div>';
			} else {
				$result .= '<div class="reviews_count_reviews"><span class="color_dark_gray">' . __( 'Всего отзывов', 'er_theme' ) . '</span> <span class="color_dark_blue link_dashed">' . $reviews_count . '</span></div>';
			}
			
		} else {
			
			$result .= '<div class="reviews_count_reviews"><span class="color_dark_gray">' . __( 'Еще нет отзывов', 'er_theme' ) . '</span></div>';
		}
		$abuses_count = get_field( 'reviews_count_abuses', $post_id );
		if ( ! $abuses_count || $abuses_count == '' ) {
			$abuses_count = 0;
		}
		if ( $abuses_count ) {
			if ( get_query_var( 'comment_single_page' ) ) {
				$comment = get_query_var( 'comment_single_page' );
				$result  .= '<div class="reviews_count_abuses"><a class="color_dark_blue link_dashed link_no_underline" href="' . get_the_permalink( $comment->comment_post_ID ) . '#abuse">' . $abuses_count . ' ' . counted_text( $abuses_count, __( 'жалоба', 'er_theme' ), __( 'жалобы', 'er_theme' ), __( 'жалоб', 'er_theme' ) ) . '</a></div>';
			} else {
				$result .= '<div class="reviews_count_abuses"><span class="color_dark_blue link_dashed">' . $abuses_count . ' ' . counted_text( $abuses_count, __( 'жалоба', 'er_theme' ), __( 'жалобы', 'er_theme' ), __( 'жалоб', 'er_theme' ) ) . '</span></div>';
			}
			
		} else {
			$result .= '<div class="reviews_count_abuses"><span class="color_dark_blue link_dashed">' . __( 'Еще нет жалоб', 'er_theme' ) . '</span></div>';
		}
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		
		return $result;
	}
}

if ( ! function_exists( 'review_top_rating' ) ) {
	function review_top_rating( $post_id, $font_big = true, $type = '' ) {
		$result        = '';
		$system_rating = get_field( 'reviews_rating_average', $post_id );
		if ( ! $system_rating || $system_rating == '' ) {
			$system_rating = 0;
		}
		$data_percent = 100 / 5 * $system_rating / 100;
		$result       .= '<div class="rating_page_text review_average_round progress" id="rating_list_item_' . $post_id . '" data-percent="' . $data_percent . '">';
		if ( $font_big == true ) {
			$result .= '<span class="inner color_dark_blue font_bold font_big">' . number_format( $system_rating, 1, '.', '' ) . '</span>';
		} else {
			$result .= '<span class="inner color_dark_blue font_bold">' . number_format( $system_rating, 1, '.', '' ) . '</span>';
		}
		
		$result .= '</div>';
		if ( $type == 'singletest' ) {
			$print_total       = get_field( 'reviews_rating_average', $postID );
			$get_ratings_count = get_comments_count( $postID, get_comment_rating_fields( 0, 'name' ) );
			$print_total_round = number_format( $print_total, 1, '.', '' );
			$result1           = '<span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
			$data_percent      = 100 / 5 * $print_total_round / 100;
			
			$result1 .= '<meta itemprop="bestRating" content="5" />';
			$result1 .= '<meta itemprop="worstRating" content="1" />';
			$result1 .= '<span class="inner color_dark_blue font_bold font_20" itemprop="ratingValue">' . $print_total_round . '</span>';
			$result1 .= '<meta itemprop="reviewCount" content="' . $get_ratings_count['count'] . '" />';
			$result1 .= '</span>';
		}
		
		return $result;
	}
}

if ( ! function_exists( 'review_card' ) ) {
	function review_card( $post_id ) {
		$result              = '';
		$er_company_site_str = get_field( 'websites', $post_id )[0]['site_url'];
		$verified            = get_field( 'company_verified_status', $post_id );
		if ($er_company_site_str == '') {
			if ($company_type = get_term( get_field('company_type',$post_id), 'companytypes' )->name == 'courses') {
				$er_company_site_str = get_field('websites',get_field('online_school',$post_id)[0]->ID)[0]['site_url'];
				$verified = get_field('company_verified_status',get_field('online_school',$post_id)[0]->ID);
				$post_id = get_field('online_school',$post_id)[0]->ID;
			} else {
				$er_company_site_str = get_field( 'websites', $post_id )[0]['site_url'];
				$verified            = get_field( 'company_verified_status', $post_id );
			}
		}
		if ( $verified || $er_company_site_str && $er_company_site_str != '' ) {
			$result .= '<div class="review_card">';
			if ( $verified ) {
				$result .= '<div class="company_status status_verified color_dark_gray font_small">' . __( 'Подтвержденная компания', 'er_theme' ) . '</div>';
			} else {
				$result .= '<div class="company_status status_unverified color_dark_gray font_small">' . __( 'Неподтвержденная компания', 'er_theme' ) . '</div>';
			}
			
			if ( $er_company_site_str && $er_company_site_str != '' ) {
				$er_company_site_str_2 = preg_replace( '#^[^:/.]*[:/]+#i', '', $er_company_site_str );
				$site                  = preg_replace( '/^www\./', '', rtrim( $er_company_site_str_2, '/' ) );
				$pos_instagram         = strpos( $site, 'instagram.com/' );
				if ( $pos_instagram === false ) {
					$n_url      = $site;
					$icon_insta = '';
				} else {
					$n_url      = str_replace( "instagram.com/", "@", $site );
					$icon_insta = ' site_insta';
					
				}
				$link = review_redirect_link( $post_id );
				if ( ! $link || $link == '' ) {
					$link = '';
				}
				$result .= '<a class="company_site link_no_underline" href="' . $link . '" target="_blank" rel="nofollow">';
				$result .= '<div class="site_url font_bold color_dark_blue font_22' . $icon_insta . '" target="_blank">' . $n_url . '</div>';
				$result .= '<span class="font_smaller_2 color_medium_gray">' . __( 'Перейти на сайт', 'er_theme' ) . '</span>';
				$result .= '</div>';
			}
			$result .= '</a>';
		}
		
		return $result;
	}
}


if ( ! function_exists( 'review_logo' ) ) {
	function review_logo( $post_id, $lazy = false, $linked = false, $webp = false ) {
		$result = '';
		if ( $linked == true ) {
			if (get_field( 'company_verified_status', $post_id )) {
				$verifed = 'verifed_logo_obz';
			} else {
				$verifed = '';
			}
			$result .= '<a itemprop="url image" class="review_logo '.$verifed.'" href="' . get_the_permalink( $post_id ) . '"';
		} else {
			if (get_field( 'company_verified_status', $post_id )) {
				$verifed = 'verifed_logo';
			} else {
				$verifed = '';
			}
			$result .= '<div class="review_logo '.$verifed.'"';
		};
		
		$logo    = get_field( 'company_logo', $post_id );
		$logo_bg = get_field( 'company_icon_bg', $post_id );
		if ( $logo_bg && $logo_bg != '' ) {
			$bg = ' background-color:' . $logo_bg . ';';
		} else {
			$bg = '';
		}
		if ( $logo && ! empty( $logo ) ) {
			if ( $lazy == true ) {
				if ( $webp == true ) {
					$result .= ' data-img="' . $logo['sizes']['large'] . '"';
					$result .= ' style="' . $bg . '"';
				} else {
					$result .= ' data-img="' . $logo['sizes']['large'] . '"';
					$result .= ' style="' . $bg . '"';
				}
				
			} else {
				if ( $webp == true ) {
					$result .= ' itemprop="url image" style="background-image:url(' . $logo['sizes']['large'] . '); ' . $bg . '"';
				} else {
					$result .= ' itemprop="url image" style="background-image:url(' . $logo['sizes']['large'] . '); ' . $bg . '"';
				}
				
			}
			//$result .= ' data-img="'.$logo['sizes']['large'].'"';
			
		}
		if ( $linked == true ) {
			$result .= '></a>';
		} else {
			$result .= '></div>';
		};
		
		$result .= '<meta itemprop="contentUrl" content="' . $logo['sizes']['large'] . '">';
		
		return '<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">' . $result . '</div>';
	}
}

if ( ! function_exists( 'review_icon' ) ) {
	function review_icon( $post_id ) {
		$result  = '';
		$result  .= '<div class="review_icon"';
		$logo    = get_field( 'company_icon', $post_id );
		$logo_bg = get_field( 'company_icon_bg', $post_id );
		if ( $logo_bg && $logo_bg != '' ) {
			$bg = ' background-color:' . $logo_bg . ';';
		} else {
			$bg = '';
		}
		if ( $logo && ! empty( $logo ) ) {
			$result .= ' style="background-image:url(' . $logo['sizes']['large'] . ');' . $bg . '"';
		}
		$result .= '></div>';
		
		return $result;
	}
}

if ( ! function_exists( 'review_redirect_link' ) ) {
	function review_redirect_link( $post_id ) {
		$result = '';
		$key    = get_field( 'company_redirect_key', $post_id );
		if ( $key && $key != '' ) {
			$result .= get_bloginfo( 'url' ) . '/visit/' . $key . '/';
		}
		
		return $result;
	}
}

if ( ! function_exists( 'review_redirect_link_replace_no_affilate' ) ) {
	function review_redirect_link_replace_no_affilate( $post_id ) {
		$result = '';
		
		
		$company_site_affiliate_url = get_field( 'company_site_affiliate_url', $post_id );
		
		
		$parse_url = parse_url( $company_site_affiliate_url );
		//print_r($parse_url);
		
		
		$a = 0;
		while ( $a == 0 ) {
			
			if ( array_key_exists( 'path', $parse_url ) ) {
				
				if ( ( $parse_url['path'] == '/' ) || ( strlen( $parse_url['path'] ) < 2 ) ) {
					$a = 1;
					break;
				} elseif ( ( strpos( $parse_url['host'], 'eto-razvod.ru' ) !== false ) ) {
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
		
		$cur_terms = get_the_terms( $post_id, 'affiliate-tags' );
		//print_r($cur_terms[0]);
		$term_id   = $cur_terms[0]->term_id;
		$term_name = $cur_terms[0]->name;
		
		if ( $a == 1 ) {
			$args = array(
				'post_type'      => 'casino',
				'orderby'        => 'menu_order',
				'posts_per_page' => 100,
				'order'          => 'ASC',
				'tax_query'      => array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'name',
						'terms'    => $term_name,
					),
				),
			);
			
			$reviews = new WP_Query( $args );
			if ( $reviews->have_posts() ) {
				while ( $reviews->have_posts() ) {
					$reviews->the_post();
					
					$company_site_affiliate_url = get_field( 'company_site_affiliate_url', get_the_ID() );
					
					
					$parse_url = parse_url( $company_site_affiliate_url );
					//print_r($parse_url);
					
					
					$a2 = 0;
					while ( $a2 == 0 ) {
						
						if ( array_key_exists( 'path', $parse_url ) ) {
							
							if ( ( $parse_url['path'] == '/' ) || ( strlen( $parse_url['path'] ) < 2 ) ) {
								break;
							} elseif ( ( strpos( $parse_url['host'], 'eto-razvod.ru' ) !== false ) ) {
								break;
							} else {
								$a2  = 1;
								$key = get_field( 'company_redirect_key', get_the_ID() );
								break;
							}
							
						} else {
							break;
						}
						
					}
					if ( $a2 == 1 ) {
						break;
					}
				}
			} else {
			
			}
			wp_reset_postdata();
		} else {
			$key = get_field( 'company_redirect_key', $post_id );
		}
		
		
		if ( $key && $key != '' ) {
			$result .= get_bloginfo( 'url' ) . '/visit/' . $key . '/';
		}
		
		return $result;
	}
}

if ( ! function_exists( 'review_top' ) ) {
	function review_top( $post_id, $type = '' ) {
		$result = '';
		$result .= print_css_links( 'review_top' );
		$result .= '<div class="review_header">';
		$result .= '<div class="wrap">';
		
		
		if ( function_exists( 'show_breadcrumbs' ) ) {
			$result .= show_breadcrumbs();
		}
		if ( function_exists( 'review_logo' ) ) {
			if ( get_post_type() == 'addpages' || get_post_type() == 'promocodes' || get_post_type() == 'casino' || get_query_var( 'comment_single_page' ) ) {
				$result .= review_logo( $post_id, false, true );
			} else {
				$result .= review_logo( $post_id );
			}
			
		}
		if ( function_exists( 'review_main' ) ) {
			$result .= review_main( $post_id, $type );
		}
		$result .= '<div class="review_top_rating_container flex flex_column">';
		if ( function_exists( 'review_top_rating' ) ) {
			$result .= review_top_rating( $post_id );
		}
		$result .= '<div class="compare_container" id="p_c_compare_container_' . $post_id . '" data-post-id="' . $post_id . '">' . compare_icon( $post_id ) . '</div>';
		$result .= '</div>';
		if ( function_exists( 'review_card' ) ) {
			$result .= review_card( $post_id );
		}
		if ( function_exists( 'review_bar' ) ) {
			$result .= review_bar( $post_id );
		}
		$result .= '</div>';
		$result .= '</div>';
		
		return $result;
	}
}

if ( ! function_exists( 'page_top' ) ) {
	function page_top( $post_id, $type ) {
		$result = '';
		$result .= '<div class="page_header page_header_rating page_rating_single page_s_' . $type . '">';
		$result .= '<div class="wrap">';
		if ( function_exists( 'show_breadcrumbs' ) ) {
			$result .= show_breadcrumbs();
		}
		$result .= '<div class="page_heading_line">';
		
		$icon_color = get_field( 'template_rating_icon_color', $post_id );
		if ( ! $icon_color || $icon_color == '' ) {
			$icon_color = '#5427ab';
		}
		if ( $type == 'promocodes_cat' ) {
			
			$tag = get_field( 'affiliate_tag', $post_id );
			if ( $tag ) {
				$term_title = get_field( 'tag_human_title', 'term_' . $tag );
			}
			// if($term_title && $term_title != '') {
			//  $title = '<span class="m_right_10">'.__('Рубрика:','er_theme').'</span><span class="color_violet dropdown pointer flex link_change_promocode_cat">'.$term_title.'</span>';
			// } else {
			$title = get_the_title( $post_id );
			// }
		} else {
			$title = get_the_title();
		}
		
		if ( $type == 'rating' ) {
			$result .= '<div class="rating_icon border_circle font_uppercase font_bold" style="background-color:' . $icon_color . ';">' . mb_substr( $title, 0, 1 ) . '</div>';
		}
		$result .= '<h1 class="color_dark_blue flex font_medium_new">' . $title . '</h1>';
		$result .= '<div class="review_icon_share pointer m_l_15" data-type="share_post" data-id="' . $post_id . '"></div>';
		$result .= '</div>';
		if ( $type == 'rating' ) {
			global $post;
			
			if ( $post->post_parent ) {
				$parent_post_id = $post->post_parent;
				$arrayPosts     = get_field( 'our_order', $post->post_parent );
			} else {
				$parent_post_id = $post_id;
				$arrayPosts     = get_field( 'our_order', $post_id );
			}
			
			if ( gettype( $arrayPosts ) == 'string' ) {
				$arrayPosts = [];
			}
			
			wp_reset_postdata();
			if ( count( $arrayPosts ) != 0 ) {
				$arr_temp  = [];
				$args_temp = [
					'post_parent' => $parent_post_id,
					'post_type'   => 'page',
					'numberposts' => - 1,
					'post_status' => 'publish',
					'orderby'     => 'title',
					'order'       => 'ASC'
				];
				$childrens = get_children( $args_temp );
				if ( $childrens && ! empty( $childrens ) ) {
					foreach ( $childrens as $children ) {
						$arrayPosts[] = $children->ID;
					}
				}
			}
			$args = [
				'post_parent' => $parent_post_id,
				'post_type'   => 'page',
				'numberposts' => - 1,
				'post_status' => 'publish',
				'orderby'     => 'title',
				'order'       => 'ASC'
			];
			if ( $post->post_parent ) {
				if ( count( $arrayPosts ) != 0 ) {
					$args['orderby']  = 'post__in';
					$args['post__in'] = $arrayPosts;
				}
			} else {
				if ( count( $arrayPosts ) != 0 ) {
					$args['orderby']  = 'post__in';
					$args['post__in'] = $arrayPosts;
				}
			}
			if (get_field('text_for_rating',$parent_post_id)) {
				$language = get_locale();
				if ($language == 'ru_RU') {
					$result .= '<div class="text_for_rating">' . get_field( 'text_for_rating', $parent_post_id ) . '</div>';
				}
			} else {
				$language = get_locale();
				if ($language == 'ru_RU') {
					// $result .= '<div class="text_for_rating"><p>В этом рейтинге собраны самые лучшие компании в '.do_shortcode('[year]').' году в разделе '.do_shortcode('[get_rating_name_shortcode]').'. На '.do_shortcode('[get_date_now_shortcode]').' доступно '.do_shortcode('[get_count_rating]').'. Вы можете воспользоваться сортировкой по положительным и отрицательным отзывам, рейтингу и другим критериям.</p></div>';
					$result .= '<div class="text_for_rating"><p>' . wp_sprintf( __( 'В этом рейтинге собраны самые лучшие компании в %s году в разделе %s. На %s доступно %s. Вы можете воспользоваться сортировкой по положительным и отрицательным отзывам, рейтингу и другим критериям.', 'er_theme'), do_shortcode('[year]'), do_shortcode('[get_rating_name_shortcode]'), do_shortcode('[get_date_now_shortcode]'), do_shortcode('[get_count_rating]') ) . '</p></div>';
				}
				
			}
			
			if (get_field('text_for_rating_other',$parent_post_id)) {
				$language = get_locale();
				if ($language != 'ru_RU') {
					if (strlen(get_field( 'text_for_rating_other_'.strtolower($language), $parent_post_id )) > 10) {
						$result .= '<div class="text_for_rating">' . get_field( 'text_for_rating_other_'.strtolower($language), $parent_post_id ) . '</div>';
					}
					
				}
			}
			
			$childrens = get_children( $args );
			if ( $childrens && ! empty( $childrens ) ) {
				$ch_y     = 0;
				$ch_total = count( $childrens );
				$result   .= '<ul class="rating_children" data-id="' . count( $arrayPosts ) . '">';
				foreach ( $childrens as $children ) {
					$ch_y ++;
					$ancor = get_field( 'child_ancor', $children->ID );
					if ( $ancor && $ancor != '' ) {
						$title = $ancor;
					} else {
						$title = $children->post_title;
					}
					/*if($ch_y == 6) {
                            $result .= '<div class="hide_more flex flex_wrap">';
                        }*/
					if ( $children->ID == $post_id ) {
						$result .= '<li class="active"><span>' . $title . '</span></li>';
					} else {
						$result .= '<li><a href="' . get_the_permalink( $children->ID ) . '"><span>' . $title . '</span></a></li>';
					}
					/*if($ch_y > 6 && $ch_y == $ch_total) {
                            $result .= '</div>';
                        }*/
				}
				
				if ( $ch_y > 6 ) {
					if ( $ch_y > 12 ) {
						$val_hide_pc = '';
					} else {
						$val_hide_pc = ' hide_pc';
					}
					$result .= '<div class="buttons m_b_20 flex new_pos ' . $val_hide_pc . '">';
					
					$result .= '<div class="color_dark_gray font_smaller link_dropdown pointer show_more_popular_categories show_more_popular_categories_2" data-ch="' . $ch_y . '">' . __( 'Показать все', 'er_theme' ) . '</div>';
					$result .= '</div>';
				}
				$result .= '</ul>';
			}
		}
		$result .= '</div>';
		if ( $type == 'rating' ) {
			
			$tag_term = get_term( get_field( 'rating_tag', $post_id ), 'affiliate-tags' );
			$tag      = $tag_term->slug;
			$term_id  = get_term_by( 'name', $tag, 'affiliate-tags' )->term_id;
			if ( get_field( 'tags_rating_inherit', 'term_' . $term_id ) ) {
				$custom_table = get_field_object( 'tags_recommended_fields_rating_new', 'term_' . get_field( 'tags_rating_inherit', 'term_' . $term_id ) );
			} else {
				$custom_table = get_field_object( 'tags_recommended_fields_rating_new', 'term_' . $term_id );
			}
			$table_1 = generate_table_fields( $custom_table, 'full' );
			if ( ! empty( $table_1 ) ) {
				$result .= '<div class="rating_header font_uppercase font_bolder font_smaller_2 color_dark_gray" data-tag="' . $tag . '">';
				$result .= '<div class="wrap">';
				
				$result .= '<div class="rating_th rating_field_number sort pointer sort_default" data-rating-field="number">' . __( 'Место' ) . '</div>';
				foreach ( $table_1['th'] as $item ) {
					if ( $item['sort'] == 1 ) {
						$sort = ' sort pointer sort_default';
					} else {
						$sort = '';
					}
					if ( 'system_count_good' == $item['field_name'] ) {
						$result .= '<div class="rating_th rating_field_' . $item['field_name'] . $sort . '" data-rating-field="' . $item['field_name'] . '"><span class="thumb_up"></span></div>';
					} elseif ( 'system_count_bad' == $item['field_name'] ) {
						$result .= '<div class="rating_th rating_field_' . $item['field_name'] . $sort . '" data-rating-field="' . $item['field_name'] . '"><span class="thumb_down"></span></div>';
					} else {
						$result .= '<div class="rating_th rating_field_' . $item['field_name'] . $sort . '" data-rating-field="' . $item['field_name'] . '">' . $item['value'] . '</div>';
					}
				}
				
				
				$result .= '</div>';
				$result .= '</div>';
				
			}
		} elseif ( $type == 'promocodes_cat' ) {
			/*$result .= '<div class="promocodes_header" data-tag="'.$tag.'">';
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
		}
		$result .= '</div>';
		
		return $result;
	}
}

if ( ! function_exists( 'rating_icons' ) ) {
	function rating_icons( $post_id, $term_id ) {
		$result = '';
		$result .= '<div class="rating_icons background_light">';
		$result .= '<div class="wrap flex_column">';
		$result .= '<ul>';
		//$result .= '<li class="icon_bg icon_filter pointer border_circle font_smaller color_dark_gray" data-term-id="'.$term_id.'">'.__('Открыть фильтр','er_theme').'</li>';
		//$result .= '<li class="icon_bg icon_compare pointer border_circle font_smaller color_dark_gray">'.__('Сравнить','er_theme').'</li>';
		$result .= bookmark_icon( $post_id );
		$result .= '<li class="review_icon_share pointer m_r_0" data-type="share_post" data-id="' . $post_id . '"></li>';
		$result .= '</ul>';
		if ( function_exists( 'tag_filters' ) ) {
			$result .= tag_filters( $term_id );
		}
		$result .= '</div>';
		$result .= '</div>';
		
		return $result;
	}
}


if ( ! function_exists( 'counted_text' ) ) {
	function counted_text( $number, $text_1, $text_2, $text_3 ) {
		if ( $number == 1 ) {
			$count_text = $text_1;
		} elseif ( $number > 1 && $number <= 4 ) {
			$count_text = $text_2;
		} else {
			if ( substr( $number, - 1 ) == 1 && substr( $number, - 2 ) != 11 ) {
				$count_text = $text_1;
			} elseif ( substr( $number, - 1 ) > 1 && substr( $number, - 1 ) < 5 && substr( $number, - 2 ) > 21 ) {
				$count_text = $text_2;
			} else {
				$count_text = $text_3;
			}
		}
		
		return $count_text;
	}
}


if ( ! function_exists( 'review_bar' ) ) {
	function review_bar( $post_id = 0 ) {
		$result = '';
		$result .= '<div class="review_bar flex">';
		if ( function_exists( 'review_links' ) ) {
			$result .= review_links( $post_id );
		}
		if ( function_exists( 'review_icons' ) ) {
			$result .= review_icons();
		}
		$link = review_redirect_link( $post_id );
		if ( ! $link || $link == '' ) {
			$link = '';
		}
		$result .= '<a class="review_icon_redirect pointer" href="' . $link . '" target="_blank"></a>';
		$result .= '</div>';
		
		return $result;
	}
}

if ( ! function_exists( 'review_links' ) ) {
	function review_links( $post_id = 0 ) {
		global $post;
		$result = '';
		if ( $post_id != 0 ) {
			$post_type = get_post_type( $post->ID );
		}
		if ( $post_type == 'promocodes' ) {
			$reviews_active    = '';
			$promocodes_active = true;
			$company_active    = false;
		} elseif ( $post_type == 'addpages' ) {
			$reviews_active    = '';
			$promocodes_active = false;
			$company_active    = 'active';
		} else {
			$reviews_active    = ' active';
			$promocodes_active = false;
			$company_active    = '';
			$result            .= print_js_links()['review_tabs'];
		}
		$result      .= print_css_links( 'review_links' );
		$term_slug   = get_term( get_field( 'company_type', $post_id ), 'companytypes' )->name;
		$term_id     = get_term_by( 'slug', $term_slug, 'affiliate-tags' )->term_id;
		$tab_company = get_field( 'tab_custom_about', 'term_' . $term_id );
		$tab_similar = get_field( 'tab_custom_similar', 'term_' . $term_id );
		if ( ! $tab_company || $tab_company == '' ) {
			$tab_company = __( 'О компании', 'er_theme' );
		}
		if ( ! $tab_similar || $tab_similar == '' ) {
			$tab_similar = __( 'Похожие компании', 'er_theme' );
		}
		//echo $post_type;
		//echo $promocodes_active;
		$current_language = get_locale();
		if ( get_query_var( 'comment_single_page' ) ) {
			$comment      = get_query_var( 'comment_single_page' );
			$content_post = get_post( $comment->comment_post_ID );
			$content      = apply_filters( 'the_content', $content_post->post_content );
			if ( $current_language != 'ru_RU' ) {
				$content = get_the_content( $content_post->post_content );
			}
		} else {
			$content = apply_filters( 'the_content', get_the_content() );
			if ( $current_language != 'ru_RU' ) {
				$content = get_the_content();
			}
		}
		$result .= '<ul class="review_links font_uppercase flex font_smaller_2 font_bolder color_dark_gray">';
		
		if ( $promocodes_active == true ) {
			//$content_2 = apply_filters( 'the_content', get_the_content($post_id) );
			$content_post = get_post( $post_id );
			$content_2    = $content_post->post_content;
			$content_2    = apply_filters( 'the_content', $content_2 );
			if ( $current_language != 'ru_RU' ) {
				$content = $content_post->post_content;
			}
			$result .= '<li><a href="' . get_the_permalink( $post_id ) . '#about" class="color_dark_gray link_no_underline">' . $tab_company . '</a></li>';
			
			$result .= '<li><a href="' . get_the_permalink( $post_id ) . '#comments" class="color_dark_gray link_no_underline">' . __( 'Отзывы', 'er_theme' ) . '</a></li>';
			if ( $content_2 != '' ) {
				$result .= '<li><a href="' . get_the_permalink( $post_id ) . '#fullreview" class="color_dark_gray link_no_underline">' . __( 'Обзор', 'er_theme' ) . '</a></li>';
			}
			$result .= '<li><a href="' . get_the_permalink( $post_id ) . '#abuse" class="color_dark_gray link_no_underline">' . __( 'Жалобы', 'er_theme' ) . '</a></li>';
			$result .= '<li class="active"><a>' . __( 'Акции', 'er_theme' ) . '</a></li>';
			$result .= '<li class="pointer review_link_similar"><a href="' . get_the_permalink( $post_id ) . '#similar" class="color_dark_gray link_no_underline">' . $tab_similar . '</a></li>';
			
			
		} else {
			
			
			$result .= '<li class="review_link_company pointer ' . $company_active . '" data-tab="review_container_about"><a href="' . get_the_permalink( $post_id ) . '#about" class="color_dark_gray link_no_underline">' . $tab_company . '</a></li>';
			
			$result .= '<li class="review_link_reviews pointer" data-tab="review_container_reviews"><a href="' . get_the_permalink( $post_id ) . '#comments" class="color_dark_gray link_no_underline">' . __( 'Отзывы', 'er_theme' ) . '</a></li>';
			
			if ( $content != '' || $term_slug == 'cryptocurrency' ) {
				$result .= '<li class="review_link_fullreview pointer" data-tab="review_container_content"><a href="' . get_the_permalink( $post_id ) . '#fullreview" class="color_dark_gray link_no_underline">' . __( 'Обзор', 'er_theme' ) . '</a></li>';
			}
			$result .= '<li class="review_link_abuses pointer" data-tab="review_container_abuses"><a href="' . get_the_permalink( $post_id ) . '#abuse" class="color_dark_gray link_no_underline">' . __( 'Жалобы', 'er_theme' ) . '</a></li>';
			
			
			$promocodes_query = new WP_Query( array(
				'post_type'  => 'promocodes',
				'meta_query' => array(
					array(
						'key'     => 'promocode_review', // name of custom field
						'value'   => $post_id, // matches exactly "123", not just 123. This prevents a match for "1234"
						'compare' => '='
					)
				)
			
			) );
			while ( $promocodes_query->have_posts() ) {
				$promocodes_query->the_post();
				global $post;
				$current_language = get_locale();
				if ( $current_language != 'ru_RU' ) {
					$is_enabled = get_field( 'enable_translations', $post->ID );
					// print_r($is_enabled);
					if ( in_array( $current_language, $is_enabled ) ) {
						$result .= '<li><a href="' . get_the_permalink() . '" class="do_not_translate_css_class link_no_underline color_dark_gray">Coupons</a></li>';
					}
					
				} else {
					$result .= '<li data-tab="review_container_actions do_not_translate_css_class"><a href="' . get_the_permalink() . '" class="link_no_underline color_dark_gray do_not_translate_css_class">' . __( 'Акции', 'er_theme' ) . '</a></li>';
				}
				
			}
			wp_reset_postdata();
			
			/*if (get_field('newslink_'.strtolower($current_language),get_the_ID())) {
				$result .= '<li><a href="'.get_field('newslink_'.strtolower($current_language),get_the_ID()).'" class="link_no_underline color_dark_gray do_not_translate_css_class">Новости</a></li>';
			}*/
			
			$result .= '<li class="pointer review_link_similar" data-tab="review_container_similar"><a href="' . get_the_permalink( $post_id ) . '#similar" class="color_dark_gray link_no_underline">' . $tab_similar . '</a></li>';
		}
		$result .= '</ul>';
		
		return $result;
	}
}

if ( ! function_exists( 'review_icons' ) ) {
	function review_icons() {
		global $post;
		$result = '';
		$result .= print_css_links( 'review_icons' );
		$result .= '<ul class="review_icons" id="review_icons_top_' . $post->ID . '" data-id="' . $post->ID . '">';
		$result .= '<li class="review_icon_share review_icon_share_new pointer" data-type="share_post" data-id="' . $post->ID . '"><span>' . __( 'Поделиться', 'er_theme' ) . '</span></li>';
		$result .= bookmark_icon( $post->ID );
		
		//$result .= '<li class="review_icon_share pointer review_icon_share_new" data-type="share_post" data-id="'.$post->ID.'"></li>';
		$result .= '</ul>';
		
		return $result;
	}
}

if ( ! function_exists( 'user_logout_ajax' ) ) {
	add_action( 'wp_ajax_user_logout_ajax', 'user_logout_ajax' );
	add_action( 'wp_ajax_nopriv_user_logout_ajax', 'user_logout_ajax' );
	
	function user_logout_ajax() {
		
		wp_logout();
		if ( is_user_logged_in() ) {
			$logged = 1;
		} else {
			$logged = 0;
		}
		echo $logged;
		die;
	}
}

if ( ! function_exists( 'user_nav' ) ) {
	add_action( 'wp_ajax_user_nav', 'user_nav' );
	add_action( 'wp_ajax_nopriv_user_nav', 'user_nav' );
	function user_nav() {
		$result   = '';
		$site_url = get_bloginfo( 'url' );
		$result   .= '<ul class="user_nav box_shadow_down color_dark_blue no_underline hover_bg_light font_smaller_2 font_uppercase font_bolder">';
		$result   .= '<li class="user_icon_home"><a href="' . $site_url . '/dashboard/" rel="nofollow">' . __( 'Главная', 'er_theme' ) . '</a></li>';
		$result   .= '<li class="user_icon_notify"><a href="' . $site_url . '/dashboard/notifications/" rel="nofollow">' . __( 'Уведомления', 'er_theme' ) . '</a></li>';
		$result   .= '<li class="user_icon_messages"><a href="' . $site_url . '/dashboard/messages/" rel="nofollow">' . __( 'Сообщения', 'er_theme' ) . '</a></li>';
		$result   .= '<li class="user_icon_reviews"><a href="' . $site_url . '/dashboard/comments/" rel="nofollow">' . __( 'Отзывы', 'er_theme' ) . '</a></li>';
		$result   .= '<li class="user_icon_abuses"><a href="' . $site_url . '/dashboard/abuses/" rel="nofollow">' . __( 'Жалобы', 'er_theme' ) . '</a></li>';
		//$result .= '<li class="user_icon_posts"><a href="'.$site_url.'/dashboard/reviews/" rel="nofollow">'.__('Обзоры','er_theme').'</a></li>';
		//$result .= '<li class="user_icon_news"><a href="'.$site_url.'/dashboard/services/blog/" rel="nofollow">'.__('Публикация статьи','er_theme').'</a></li>';
		$result .= '<li class="user_icon_profile"><a href="' . $site_url . '/user/">' . __( 'Профиль', 'er_theme' ) . '</a></li>';
		$result .= '<li class="user_icon_services"><a href="' . $site_url . '/dashboard/services/" rel="nofollow">' . __( 'Сервисы', 'er_theme' ) . '</a></li>';
		$result .= '<li class="user_icon_subscribes"><a href="' . $site_url . '/dashboard/subscription/" rel="nofollow">' . __( 'Подписки', 'er_theme' ) . '</a></li>';
		$result .= '<li class="user_icon_balance"><a href="' . $site_url . '/dashboard/wallet/" rel="nofollow">' . __( 'Платежи', 'er_theme' ) . '</a></li>';
		$result .= '<li class="user_icon_logout"><a class="link_logout pointer">' . __( 'Выйти', 'er_theme' ) . '</a></li>';
		$result .= '</ul>';
		echo $result;
		die;
	}
}

if ( ! function_exists( 'user_nav_settings' ) ) {
	add_action( 'wp_ajax_user_nav_settings', 'user_nav_settings' );
	add_action( 'wp_ajax_nopriv_user_nav_settings', 'user_nav_settings' );
	function user_nav_settings() {
		$result   = '';
		$site_url = get_bloginfo( 'url' );
		$result   .= '<div class="user_nav_settings">';
		
		$current_user = wp_get_current_user();
		$user_id      = $current_user->data->ID;
		$company_ids  = get_field( 'company_user', 'user_' . $user_id );
		$company_ids2 = get_field( 'comp_statuses', 'user_' . $user_id );
		if ( count( $company_ids2 ) != 0 ) {
			$result .= '<div class="company_list"><span class="company_title color_dark_gray">' . __( 'Мои компании', 'er_theme' ) . '</span><div class="company_list_ul">';
			//$result .= print_r($company_ids2);
			foreach ( $company_ids2 as $item ) {
				$post_id = $item['company_user'][0];
				
				if ( $item['status']['value'] != 'ok' ) {
					$link = '/dashboard/wallet/?conn_id=' . $item['id_conn_comp'][0];
				} else {
					$link = '/dashboard/company/' . get_post_field( 'post_name', $post_id );
				}
				$result  .= '<a href="' . $link . '" class="review_logo"';
				$logo    = get_field( 'company_logo', $post_id );
				$logo_bg = get_field( 'company_icon_bg', $post_id );
				if ( $logo_bg && $logo_bg != '' ) {
					$bg = ' background-color:' . $logo_bg . ';';
				} else {
					$bg = '';
				}
				$lazy = false;
				if ( $logo && ! empty( $logo ) ) {
					if ( $lazy == true ) {
						$result .= ' data-img="' . $logo['sizes']['large'] . '"';
						$result .= ' style="' . $bg . '"';
					} else {
						$result .= ' style="background-image:url(' . $logo['sizes']['large'] . '); ' . $bg . '"';
					}
					//$result .= ' data-img="'.$logo['sizes']['large'].'"';
					
				}
				if ( $item['status']['value'] != 'ok' ) {
					$status_string = '<span class="status">' . $item['status']['label'] . '</span>';
				} else {
					$status_string = '';
				}
				$result .= '>' . $status_string . '</a>';
			}
			$result .= '</div></div>';
		}
		$result .= '<ul class="color_dark_blue font_small font_bold user_settings_links">';
		$result .= '<li class="link_add_review pointer" data-link="' . get_bloginfo( 'url' ) . '/review/">' . __( 'Добавить отзыв', 'er_theme' ) . '</li>';
		$result .= '<li class="link_add_company_review pointer" data-link="' . get_bloginfo( 'url' ) . '/order/">' . __( 'Добавить обзор', 'er_theme' ) . '</li>';
		$result .= '<li class="link_add_news pointer" data-link="' . get_bloginfo( 'url' ) . '/author/">' . __( 'Стать автором', 'er_theme' ) . '</li>';
		$result .= '<li class="link_add_abuse pointer" data-link="' . get_bloginfo( 'url' ) . '/abuse/">' . __( 'Оставить жалобу', 'er_theme' ) . '</li>';
		$result .= '<li class="link_add_company pointer" data-link="' . get_bloginfo( 'url' ) . '/add-company/">' . __( 'Добавить компанию', 'er_theme' ) . '</li>';
		$result .= '<li class="link_check_company pointer" data-link="' . get_bloginfo( 'url' ) . '/check/">' . __( 'Проверить компанию', 'er_theme' ) . '</li>';
		$result .= '</ul>';
		$result .= '</div>';
		echo $result;
		die;
	}
}

if ( ! function_exists( 'load_more' ) ) {
	add_action( 'wp_ajax_load_more', 'load_more' );
	add_action( 'wp_ajax_nopriv_load_more', 'load_more' );
	function load_more() {
		$data = $_POST;
		$args = array(
			'post_type'      => $data['post_type'],
			'posts_per_page' => 6,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'term_id',
					'terms'    => $data['tag'],
				)
			),
		);
		
		$result         = '';
		$args['offset'] = $data['offset'];
		$query          = new WP_Query( $args );
		// print_r($query);
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				global $post;
				if ( $data['post_type'] == 'casino' ) {
					if ( function_exists( 'get_rating_fields_group' ) ) {
						$rating_fields_group = get_rating_fields_group( $post->ID );
					} else {
						$rating_fields_group = 0;
					}
					$comments_count = get_comments_count( $post->ID, get_comment_rating_fields( $rating_fields_group, 'name' ) );
					$result         .= '<li class="white_block flex flex_column flex_column_4" itemscope="" itemtype="http://schema.org/Organization">';
					$company_name   = get_field( 'company_name', $post->ID );
					$result         .= '<div class="company_block_header flex">';
					$result         .= '<div class="compare_container compare_container_p_c_more" id="p_c_compare_container_' . $post->ID . '" data-post-id="' . $post->ID . '">' . compare_icon( $post->ID ) . '</div>';
					if ( function_exists( 'review_logo' ) ) {
						$result .= review_logo( $post->ID );
					}
					$result .= '<div class="flex flex_column">';
					$result .= '<meta itemprop="name" content="' . $company_name . '">';
					$result .= '<a itemprop="url" class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="' . get_the_permalink( $post->ID ) . '">' . $company_name . '</a>';
					$result .= '<div class="font_small"><span class="color_dark_gray count_reviews">' . __( 'Отзывы', 'er_theme' ) . '</span><span class="color_dark_blue">' . $comments_count['count'] . '</span></div>';
					$terms  = get_the_terms( $post->ID, 'affiliate-tags' );
					if ( ! empty( $terms ) ) {
						$t_x    = 0;
						$result .= '<ul class="company_card_tags flex" data-id="4">';
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
					$result .= '<div class="company_block_footer flex" itemscope="" itemprop="aggregateRating" itemtype="https://schema.org/AggregateRating">';
					$result .= get_post_stars( $rating_fields_group );
					$result .= review_top_rating( $post->ID );
					$result .= '</div>';
					$result .= '</li>';
				}
			}
		}
		wp_reset_postdata();
		echo $result;
		die;
	}
}

if ( ! function_exists( 'ajax_show_popular_cat_content' ) ) {
	add_action( 'wp_ajax_ajax_show_popular_cat_content', 'ajax_show_popular_cat_content' );
	add_action( 'wp_ajax_nopriv_ajax_show_popular_cat_content', 'ajax_show_popular_cat_content' );
	function ajax_show_popular_cat_content() {
		$data = $_POST;
		$args = array(
			'post_type'   => $data['post_type'],
			'post_status' => 'publish'
		);
		if ( $data['post_type'] == 'casino' ) {
			$args['orderby']        = 'menu_order';
			$args['order']          = 'ASC';
			$args['tax_query']      = array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'term_id',
					'terms'    => $data['term_id'],
				)
			);
			$args['posts_per_page'] = 6;
		} elseif ( $data['post_type'] == 'promocodes' ) {
			$args['posts_per_page'] = 3;
			$args['tax_query']      = array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'term_id',
					'terms'    => $data['term_id'],
				)
			);
			$args['meta_query']     = array(
				array(
					'key'     => 'promocodes_items',
					'value'   => 0,
					'compare' => '>'
				)
			);
		}
		if ( $data['post_type'] == 'casino' ) {
			$current_language = get_locale();
			if ( $current_language != 'ru_RU' ) {
				$args['meta_query'] = array(
					'relation' => 'OR',
					array(
						'key'     => 'languages_' . strtolower( $current_language ) . '_sorting',
						'compare' => 'NOT EXISTS',
					),
					array(
						'key'     => 'languages_' . strtolower( $current_language ) . '_sorting',
						'value'   => 0,
						'compare' => '=',
					),
					array(
						'key'     => 'languages_' . strtolower( $current_language ) . '_sorting',
						'value'   => '',
						'compare' => '=',
					)
				);
			}
		}
		$query_reviews                = new WP_Query( $args );
		
		if ( $data['post_type'] == 'casino' ) {
			if ( $current_language != 'ru_RU' ) {
				
				wp_reset_postdata();
				$args_a = array(
					//'post_type'      => 'casino',
					'post_type'      => 'casino',
					'posts_per_page' => - 1,
					'post_status'    => 'publish',
					'meta_key'       => 'languages_' . strtolower( $current_language ) . '_sorting',
					'orderby'        => 'meta_value',
					'order'          => 'ASC',
					'meta_query'     => array(
						'relation' => 'AND',
						array(
							'key'     => 'languages_' . strtolower( $current_language ) . '_sorting',
							'value'   => '',
							'compare' => '!=',
						),
					),
					'tax_query'      => array(
						array(
							'taxonomy' => 'affiliate-tags',
							'field'    => 'term_id',
							'terms'    => $data['term_id']
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
					$lastend = end( $query_reviews->posts )->menu_order;
					
					foreach ( $reviews2->posts as $item ) {
						
						$i = 0;
						//$item->menu_order = get_field('languages_'.strtolower($current_language).'_sort',$item->ID);
						foreach ( $query_reviews->posts as $key => $item2 ) {
							
							if ( $item2->ID == $item->ID ) {
								$i = 1;
								/*unset($query_reviews->posts[$key]);
								$query_reviews->posts[$key] = $item;*/
								$query_reviews->posts[ $key ]->menu_order = get_field( 'languages_' . strtolower( $current_language ) . '_sorting', $item->ID );
							}
						}
						
						if ( $lastend > get_field( 'languages_' . strtolower( $current_language ) . '_sorting', $item->ID ) && $i == 0 ) {
							$item->menu_order = get_field( 'languages_' . strtolower( $current_language ) . '_sorting', $item->ID );
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
		}
		
		$args_total                   = $args;
		$args_total['posts_per_page'] = - 1;
		$query_total                  = new WP_Query( $args_total );
		$total                        = count( $query_total->posts );
		$current                      = count( $query_reviews->posts );
		
		
		if ( $query_reviews->have_posts() ) {
			
			$result .= '<ul class="flex ul_content">';
			$yyy    = 0;
			while ( $query_reviews->have_posts() ) {
				$query_reviews->the_post();
				global $post;
				if ( $data['post_type'] == 'casino' ) {
					if ( function_exists( 'get_rating_fields_group' ) ) {
						$rating_fields_group = get_rating_fields_group( $post->ID );
					} else {
						$rating_fields_group = 0;
					}
					$comments_count = get_comments_count( $post->ID, get_comment_rating_fields( $rating_fields_group, 'name' ) );
					$result         .= '<li class="white_block flex flex_column flex_column_5 itemscope="" itemtype="http://schema.org/Organization" asfafasfasfasf">';
					$company_name   = get_field( 'company_name', $post->ID );
					$result         .= '<div class="company_block_header flex">';
					$result         .= '<div class="compare_container compare_container_p_c_cat_more" id="p_c_compare_container_' . $post->ID . '" data-post-id="' . $post->ID . '">' . compare_icon( $post->ID ) . '</div>';
					if ( function_exists( 'review_logo' ) ) {
						$result .= review_logo( $post->ID );
					}
					$result .= '<div class="flex flex_column">';
					$result .= '<meta itemprop="name" content="' . $company_name . '">';
					$result .= '<a itemprop="url" class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="' . get_the_permalink( $post->ID ) . '">' . $company_name . '</a>';
					$result .= '<div class="font_small"><span class="color_dark_gray count_reviews">' . __( 'Отзывы', 'er_theme' ) . '</span><span class="color_dark_blue">' . $comments_count['count'] . '</span></div>';
					$terms  = get_the_terms( $post->ID, 'affiliate-tags' );
					if ( ! empty( $terms ) ) {
						$t_x    = 0;
						$result .= '<ul class="company_card_tags flex" data-id="5">';
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
					$result .= '<div class="company_block_footer flex" itemscope="" itemprop="aggregateRating" itemtype="https://schema.org/AggregateRating">';
					$result .= get_post_stars( $rating_fields_group );
					$result .= review_top_rating( $post->ID );
					$result .= '</div>';
					$result .= '</li>';
					
				} elseif ( $data['post_type'] == 'promocodes' ) {
					$items = get_field( 'promocodes_items' );
					//print_r($item);
					// echo '<br /><br />';
					$review_id    = get_field( 'promocode_review' );
					$company_name = get_field( 'company_name', $review_id );
					$xxx          = 0;
					
					if ( $yyy < 10 ) {
						//echo ' / '.$yyy;
						foreach ( $items as $item ) {
							if ( $yyy == 9 ) {
								break;
							}
							$xxx ++;
							if ( $xxx == 4 ) {
								break;
							}
							$yyy ++;
							$result .= '<li class="white_block flex flex_column" id="popular_promocodes_' . $post->ID . '">';
							if ( $item['discount_size'] != '' & $item['discount_currency'] == '%' ) {
								$size = $item['discount_size'] . $item['discount_currency'];
							} elseif ( $item['discount_size'] != '' & $item['discount_currency'] != '%' ) {
								$size = $item['discount_size'] . ' ' . $item['discount_currency'];
							} else {
								$size = '';
							}
							if ( $item['type'] == 'discount' ) {
								$item_type = __( 'Скидка на заказ', 'er_theme' );
							} elseif ( $item['type'] == 'reg' ) {
								$item_type = __( 'Бонус при регистрации', 'er_theme' );
							} elseif ( $item['type'] == 'demo' ) {
								$item_type = __( 'Бесплатный демо-счет', 'er_theme' );
							} elseif ( $item['type'] == 'gift' ) {
								$item_type = __( 'Подарок', 'er_theme' );
							} elseif ( $item['type'] == 'delivery' ) {
								$item_type = __( 'Бесплатная доставка', 'er_theme' );
							}
							$current_date = time();
							$diff         = strtotime( $item['date_end'] . ' 23:59' ) - $current_date;
							$diff_human   = date( 'Y-m-d H:i:s', $diff );
							//$result .= $diff;
							$rest_human = date_parse( $diff_human );
							//print_r($rest_human);
							//echo '<br /><br />';
							if ( $rest_human['year'] < 1970 ) {
								$result .= '<div class="promocode_block_alert"><span class="promocode_alert_simple_text">' . __( 'Истекает сегодня', 'er_theme' ) . '</span></div>';
							} else {
								$result .= '<div class="promocode_block_alert">';
								$result .= '<span class="promocode_alert_simple_text">' . __( 'Истекает через', 'er_theme' ) . '</span>';
								$result .= '<span class="number">' . $rest_human['day'] . '</span>';
								$result .= '<span class="number">' . $rest_human['hour'] . '</span>';
								$result .= '<span class="number">' . $rest_human['minute'] . '</span>';
								$result .= '</div>';
								
							}
							$result .= '<div class="promocode_block_content flex flex_column">';
							if ( $size != '' ) {
								$result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size">' . $size . '</div>';
							} else {
								$result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size_text">' . $item_type . '</div>';
							}
							$result .= '<a class="promocode_item_title color_dark_blue link_no_underline font_bold" href="' . get_the_permalink() . '" target="_blank">' . $company_name . '</a>';
							if ( $item['title'] != '' ) {
								$result .= '<div class="color_dark_gray font_small m_t_15">' . $item['title'] . '</div>';
							}
							$result .= '<div class="promocode_button_container">';
							if ( $item['text'] != '' && $item['text'] != 'Не нужен' ) {
								$result .= '<div class="promocode_text_container">';
								$result .= '<div class="promocode_single_text" id="promocode_text_' . $post->ID . '_1">' . $item['text'] . '</div>';
								$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="' . get_bloginfo( 'url' ) . '/visit2/' . $post->ID . '-1/" target="_blank" rel="nofollow">' . __( 'Получить', 'er_theme' ) . '</a>';
								$result .= '<div class="link_promocode_text_copy button button_green button_centered m_t_20 pointer font_smaller font_bold">' . __( 'Скопировать', 'er_theme' ) . '</div>';
								$result .= '</div>';
								$result .= '<div class="link_promocode_show_more_text button button_green button_centered m_t_20 pointer font_smaller font_bold">' . __( 'Показать код', 'er_theme' ) . '</div>';
							} else {
								$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="' . get_bloginfo( 'url' ) . '/visit2/' . $post->ID . '-1/" target="_blank" rel="nofollow">' . __( 'Получить', 'er_theme' ) . '</a>';
							}
							$result .= '</div>';
							$result .= '</div>';
							if ( $item['description'] != '' ) {
								$result .= '<div class="promocode_full_description color_dark_gray font_small">' . $item['description'] . '</div>';
							}
							$result .= '<div class="promocode_block_footer flex">';
							if ( $item['description'] != '' ) {
								$result .= '<span class="font_smaller color_dark_gray inactive dropdown pointer flex link_promocode_show_more">' . __( 'Подробнее', 'er_theme' ) . '</span>';
							}
							$count_used = 1;
							if ( $item['visits'] && $item['visits'] != '' && $item['visits'] != 0 ) {
								$count_used = $item['visits'];
							}
							$result .= '<span class="m_l_auto font_bold font_smaller color_dark_blue">' . $count_used . ' ' . counted_text( $count_used, __( 'использует', 'er_theme' ), __( 'используют', 'er_theme' ), __( 'используют', 'er_theme' ) ) . '</span>';
							$result .= '</div>';
							$result .= '</li>';
						}
						
					}
					
				}
				
				
			}
			
			$result .= '</ul>';
			if ( $data['post_type'] == 'casino' ) {
				if ( $current < $total ) {
					$more_classes = 'button pointer button_violet button_padding_big font_small font_bold radius_small button_centered line_show_more flex';
					$result       .= '<div class="' . $more_classes . ' inactive" data-offset="' . $current . '" data-block-id="' . $data['block_append'] . '" data-container="ul.ul_content" data-per-page="' . $args['posts_per_page'] . '" data-total="' . $total . '" data-post-type="casino" data-tag="' . $data['term_id'] . '">' . __( 'Показать еще', 'er_theme' ) . '</div>';
				}
			}
		}
		wp_reset_postdata();
		echo $result;
		die;
	}
}

if ( ! function_exists( 'get_field_lang_translation_term' ) ) {
	function get_field_lang_translation_term( $field_name, $term_id ) {
		$current_language = get_locale();
		if ( $current_language == 'ru_RU' ) {
			$result = get_field( $field_name, 'term_' . $term_id );
		} else {
			$field       = get_field( $field_name . '_lang', 'term_' . $term_id );
			$field_array = array();
			if ( ! empty( $field ) ) {
				foreach ( $field as $item ) {
					$field_array[ $item['lang'] ] = $item['text'];
				}
			}
			if ( $field_array[ $current_language ] != '' ) {
				$result = $field_array[ $current_language ];
			} else {
				$result = get_field( $field_name, 'term_' . $term_id );
			}
		}
		
		return $result;
		
	}
}

if ( ! function_exists( 'er_title' ) ) {
	function er_title() {
		
		global $post, $news_page_company_name;
		
		$title = '';
		$result = '';
		
		$current_language = get_locale();
		
		// $curr_language = get_locale();
		// if ( $curr_language != 'ru_RU' ) {
		// 	$site_language = __( 'Revieweek™', 'er_theme' );
		// } else {
		// 	$site_language = __( 'Это развод™', 'er_theme' );
		// }
		
		$site_language = __( 'Это развод™', 'er_theme' );
		
		if ( is_post_type_archive( array( 'promocodes' ) ) ) {
			
			$result .= __( 'Бесплатные промокоды на скидку', 'er_theme' ) . ' | ' . $site_language;
			
		} elseif ( is_404() ) {
			
			$result .= __( 'Страница не найдена', 'er_theme' ) . ' | ' . $site_language;
			
		} elseif ( is_category() ) {
			
			if ( is_paged() ) {
				$paged  = get_query_var( 'paged', 0 );
				$result .= __( 'Рубрика', 'er_theme' ) . ' ' . single_cat_title( '', 0 ) . ', ' . __( 'страница', 'er_theme' ) . ' ' . $paged . ' | ' . $site_language;
			} else {
				$result .= __( 'Рубрика', 'er_theme' ) . ' ' . single_cat_title( '', 0 ) . ' | ' . $site_language;
			}
			
		} else {
			
			if ( is_singular( 'promocodes' ) ) {
				$result = get_the_title( $post->ID ) . ' | ' . date_i18n( 'F Y' );
				if ($current_language == 'en_US') {
					$result = str_replace('промокоды', "promo codes", $result);
					$result = str_replace('промокод', "promo code", $result);
					$result = str_replace('промо коды', "promo codes", $result);
					$result = str_replace('промо код', "promo code", $result);
					$result = str_replace('промо-коды', "promo codes", $result);
					$result = str_replace('промо-код', "promo code", $result);
				} elseif ($current_language == 'fr_FR') {
					$result = str_replace('промокоды', "code promotionnel", $result);
					$result = str_replace('промокод', "code promotionnel", $result);
					$result = str_replace('промо коды', "code promotionnel", $result);
					$result = str_replace('промо код', "code promotionnel", $result);
					$result = str_replace('промо-коды', "code promotionnel", $result);
					$result = str_replace('промо-код', "code promotionnel", $result);
				} elseif ($current_language == 'de_DE') {
					$result = str_replace('промокоды', "werbecode", $result);
					$result = str_replace('промокод', "werbecode", $result);
					$result = str_replace('промо коды', "werbecode", $result);
					$result = str_replace('промо код', "werbecode", $result);
					$result = str_replace('промо-коды', "werbecode", $result);
					$result = str_replace('промо-код', "werbecode", $result);
				} elseif ($current_language == 'es_ES') {
					$result = str_replace('промокоды', "código promocional", $result);
					$result = str_replace('промокод', "código promocional", $result);
					$result = str_replace('промо коды', "código promocional", $result);
					$result = str_replace('промо код', "código promocional", $result);
					$result = str_replace('промо-коды', "código promocional", $result);
					$result = str_replace('промо-код', "código promocional", $result);
				} elseif ($current_language == 'pl_PL') {
					$result = str_replace('промокоды', "kody promocyjne", $result);
					$result = str_replace('промокод', "kod promocyjny", $result);
					$result = str_replace('промо коды', "kody promocyjne", $result);
					$result = str_replace('промо код', "kod promocyjny", $result);
					$result = str_replace('промо-коды', "kody promocyjne", $result);
					$result = str_replace('промо-код', "kod promocyjny", $result);
				}
				//$current_language == 'en_US' || $current_language == 'fr_FR' || $current_language == 'de_DE' || $current_language == 'es_ES'
			} elseif( $news_page_company_name ) {
				
				$result .= $news_page_company_name . ' ' . __( 'новости', 'er_theme' ) . ' | ' . $site_language;
				
			} elseif ( is_singular( 'casino' ) ) {
				$term_slug = get_term( get_field( 'company_type', $post->ID ), 'companytypes' )->name;
				$term_id   = get_term_by( 'name', $term_slug, 'affiliate-tags' )->term_id;
				//$tag_add = get_field('tag_add_title','term_'.$term_id);
				$tag_add = get_field_lang_translation_term( 'tag_add_title', $term_id );
				
				if ( $tag_add != '' ) {
					$title          = get_post_meta( $post->ID, 'seo_title', true );
					$title_priority = get_field( 'title_priority', $post->ID );
					if ( $title && $title != '' && $title_priority == true ) {
						//$result = $title;
						$result = str_replace( '[year]', wp_date( 'Y' ), $title );
						$result = str_replace( '[top_course]', do_shortcode('[top_course]'), $result );
						//$result = str_replace( '[top_course]', "4eeeeeee", $result );
						
					} else {
						$get_title = get_the_title( $post->ID );
						$cyr       = [
							'Љ', 'Њ', 'Џ', 'џ', 'ш', 'ђ', 'ч', 'ћ', 'ж', 'љ', 'њ', 'Ш', 'Ђ', 'Ч', 'Ћ', 'Ж', 'Ц',
							'ц', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о',
							'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
							'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
							'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
						];
						$lat       = [
							'Lj', 'Nj', 'Dž', 'dž', 'š', 'đ', 'č', 'ć', 'ž', 'lj', 'nj', 'Š', 'Đ', 'Č', 'Ć', 'Ž',
							'C', 'c', 'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n',
							'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sht', 'a', 'i', 'y', 'e',
							'yu', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'Io', 'Zh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N',
							'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Sht', 'A', 'I', 'Y', 'e',
							'Yu', 'Ya',
						];
						
						if ( $current_language == 'en_US' ) {
							$get_title = str_replace( 'это развод?', "", $get_title );
							$get_title = str_replace( $cyr, $lat, $get_title );
							$get_title .= 'is it a scam?';
						} elseif ( $current_language == 'fr_FR' ) {
							$get_title = str_replace( 'это развод?', "", $get_title );
							$get_title = str_replace( $cyr, $lat, $get_title );
							$get_title .= 'est-ce une arnaque?';
						} elseif ( $current_language == 'es_ES' ) {
							$get_title = str_replace( 'это развод?', "", $get_title );
							$get_title = str_replace( $cyr, $lat, $get_title );
							$get_title .= 'es una estafa?';
						} elseif ( $current_language == 'de_DE' ) {
							$get_title = str_replace( 'это развод?', "", $get_title );
							$get_title = str_replace( $cyr, $lat, $get_title );
							$get_title .= 'ist das ein Betrug?';
						} elseif ( $current_language == 'pl_PL' ) {
							$get_title = str_replace( 'это развод?', "", $get_title );
							$get_title = str_replace( $cyr, $lat, $get_title );
							$get_title .= 'czy to jest rozwód?';
						}
						$result = $get_title . ' ' . $tag_add . ' | ' . $site_language;
					}
					
				} else {
					$title = get_post_meta( $post->ID, 'seo_title', true );
					if ( $title && $title != '' ) {
						//$result = $title;
						$result = str_replace( '[year]', wp_date( 'Y' ), $title );
						$result = str_replace( '[top_course]', do_shortcode('[top_course]'), $result );
					} else {
						$result = get_the_title( $post->ID ) . ' | ' . $site_language;
					}
				}
			} else {
				
				if( isset( $post->ID ) ) {
					$title = get_post_meta( $post->ID, 'seo_title', true );
				}
				
				if ( $title && $title != '' ) {
					//$result = $title;
					$result = str_replace( '[year]', wp_date( 'Y' ) , $title );
					$result = str_replace( '[top_course]', do_shortcode('[top_course]'), $result );
				} else {
					if( isset( $post->ID ) ) {
						$result = get_the_title( $post->ID ) . ' | ' . $site_language;
					}
				}
			}
		}
		
		return $result;
	}
}

if ( ! function_exists( 'er_description' ) ) {
	function er_description() {
		
		global $post, $news_page_company_name;
		
		$result = '';
		$current_language = get_locale();
		
		if ( is_post_type_archive( array( 'promocodes' ) ) ) {
			$result .= __( 'Промокоды на скидку, бонус или бесплатную доставку для ведущий интернет-компаний. Полный список бесплатных промокодов на одной странице.', 'er_theme' );
		} elseif ( is_category() ) {
			if ( is_paged() ) {
				$paged  = get_query_var( 'paged', 0 );
				// $result .= 'Полезные статьи блога из рубрики ' . single_cat_title( '', 0 ) . ', страница ' . $paged . ' - только главное: обзоры, перспективы, советы, инструкции. Читайте и оставляйте комментарии.';
				$result .= wp_sprintf( __( 'Полезные статьи блога из рубрики %s, страница %s - только главное: обзоры, перспективы, советы, инструкции. Читайте и оставляйте комментарии.', 'er_theme'), single_cat_title( '', 0 ), $paged );
			} else {
				$result .= wp_sprintf( __( 'Полезные статьи блога из рубрики %s - только главное: обзоры, перспективы, советы, инструкции. Читайте и оставляйте комментарии.', 'er_theme'), single_cat_title( '', 0 ) );
			}
		} elseif ( is_404() ) {
			// if ( $current_language != 'ru_RU' ) {
			// 	$result .= __( 'The document was not found. You probably could have followed a link that leads to deleted material or made a mistake in the URL.', 'er_theme' );
			// } else {
			// 	$result .= __( 'Документ не найден. Вероятно, вы могли бы перейти по ссылке, которая ведёт на удаленный материал или сделали ошибку в адресе URL.', 'er_theme' );
			// }
			$result .= __( 'Документ не найден. Вероятно, вы могли бы перейти по ссылке, которая ведёт на удаленный материал или сделали ошибку в адресе URL.', 'er_theme' );
			
		} elseif( $news_page_company_name ) {
			// $result .= $news_page_company_name . ' ' . __( 'новости', 'er_theme' ) . ' ' . mb_strtolower( wp_date( 'F Y' ) ) . '. Будьте в курсе последних новостей и комментариев компании.';
			$result .= wp_sprintf( __( '%s новости %s. Будьте в курсе последних новостей и комментариев компании.', 'er_theme' ), $news_page_company_name, mb_strtolower( wp_date( 'F Y' ) ) );
		} else {
			$description = get_post_meta( $post->ID, 'seo_desc', true );
			$result      = str_replace( '[year]', wp_date( 'Y' ), $description );
			$result = str_replace( '[top_course]', do_shortcode('[top_course]'), $result );
		}
		
		return $result;
	}
}

if ( ! function_exists( 'user_reg_social' ) ) {
	function user_reg_social( $social_email, $social_identifier, $social_provider, $social_firstname, $social_lastname, $avatar_url ) {
		$result   = array();
		$password = wp_generate_password();
		$login    =
			strtolower( substr( $social_provider, 0, 2 ) ) . '' . $social_identifier;
		$userdata = array(
			'user_login'    => $login,
			'user_nicename' => $login,
			'user_pass'     => $password,
			'remember'      => true
		);
		if ( $social_email && $social_email != '' ) {
			$user_email = $social_email;
		} else {
			$user_email = $login . '@eto.ru';
		}
		
		$userdata['user_email'] = $user_email;
		if ( $social_firstname && $social_firstname != '' ) {
			$userdata['first_name'] = $social_firstname;
		}
		if ( $social_lastname && $social_lastname != '' ) {
			$userdata['last_name'] = $social_lastname;
		}
		if ( $social_firstname && $social_firstname != '' && $social_lastname && $social_lastname != '' ) {
			$userdata['display_name'] = $social_firstname . ' ' . $social_lastname;
		} elseif ( $social_firstname && $social_firstname != '' && ! $social_lastname ) {
			$userdata['display_name'] = $social_firstname;
		} elseif ( ! $social_firstname && $social_lastname && $social_lastname != '' ) {
			$userdata['display_name'] = $social_lastname;
		} else {
			$userdata['display_name'] = $user_email;
		}
		$user_id = wp_insert_user( $userdata );
		if ( $user_id ) {
			$user_id_role = new WP_User( $user_id );
			$user_id_role->set_role( 'registereduser' );
			$result['status']  = 'ok';
			$result['user_id'] = $user_id;
			$key               = wp_generate_uuid4();
			update_field( 'key_activation', $key, 'user_' . $user_id );
			if ( $_COOKIE["_ym_uid"] ) {
				$timervop = htmlspecialchars( $_COOKIE["_ym_uid"] );
				update_field( 'client_id_yandex', $timervop, 'user_' . $user_id );
			}
			if ( $social_provider && $social_provider != '' && $social_identifier && $social_identifier != '' ) {
				update_field( 'provider_' . $social_provider, $social_identifier, 'user_' . $user_id );
				update_field( 'user_reg_from_social', 'yes', 'user_' . $user_id );
			}
			wp_clear_auth_cookie();
			wp_set_current_user( $user_id );
			wp_set_auth_cookie( $user_id );
			$content_reg = __( 'Пожалуйста, если вы еще это не сделали, заполните ваши интересы в личном кабинете, чтобы мы предложили вам только важную информацию.', 'er_theme' );
			notify_user_action( 'system_registration', $user_id, __( 'Добро пожаловать на сайт!', 'er_theme' ), $content_reg );
			if ( $social_email && $social_email != '' ) {
				// $content_email = 'Мы отправили письмо для активации на ваш адрес ' . $social_email . '. Пожалуйста, перейдите по ссылке, чтобы подтвердить ваш E-mail.';
				$content_email = wp_sprintf( __( 'Мы отправили письмо для активации на ваш адрес %s. Пожалуйста, перейдите по ссылке, чтобы подтвердить ваш E-mail.', 'er_theme' ), $social_email );
				
				notify_user_action( 'system_activation_email', $user_id, __( 'Подтвердите ваш E-mail', 'er_theme' ), $content_email );
			} else {
				// $content_email = 'Вы авторизовались через ' . $social_provider . '. Чтобы иметь доступ ко всем функциям сайта, пожалуйста, укажите ваш E-mail в настройках профиля.';
				$content_email = wp_sprintf( __( 'Вы авторизовались через %s. Чтобы иметь доступ ко всем функциям сайта, пожалуйста, укажите ваш E-mail в настройках профиля.', 'er_theme' ), $social_provider );
				
				notify_user_action( 'system_activation_email_not_found', $user_id, __( 'Укажите ваш E-mail', 'er_theme' ), $content_email );
			}
			
			
			if ( $avatar_url && $avatar_url != '' && $avatar_url != 'none' ) {
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				$timeout_seconds = 5;
				
				$temp_file = download_url( $avatar_url, $timeout_seconds );
				
				$typeimg = wp_check_filetype( basename( $avatar_url ) );
				if ( ! is_wp_error( $temp_file ) ) {
					$file = array(
						'name'     => basename( $avatar_url ),
						'type'     => $typeimg['type'],
						'tmp_name' => $temp_file,
						'error'    => 0,
						'size'     => filesize( $temp_file ),
					);
					
					$overrides = array( 'test_form' => false, 'test_size' => true );
					$results   = wp_handle_sideload( $file, $overrides );
					
					if ( ! empty( $results['error'] ) ) {
					} else {
						$filepath    = $results['file'];
						$filename    = $results['url'];
						$filetype    = $results['type'];
						$arr_img_ext = array( 'image/png', 'image/jpeg', 'image/jpg', 'image/gif' );
						if ( in_array( $filetype, $arr_img_ext ) ) {
							$upload        = wp_upload_bits( basename( $filename ), null, file_get_contents( $filepath ) );
							$filename      = $upload['url'];
							$filepath      = $upload['file'];
							$filetype      = wp_check_filetype( basename( $filename ), null );
							$wp_upload_dir = wp_upload_dir();
							$attachment    = array(
								'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
								'post_mime_type' => $filetype['type'],
								'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
								'post_content'   => '',
								'post_status'    => 'inherit'
							);
							$attach_id     = wp_insert_attachment( $attachment, $filename );
							apply_filters( 'wp_handle_upload', array(
								'file' => $filepath,
								'url'  => $filename,
								'type' => $filetype
							), 'upload' );
							$attach_data = wp_generate_attachment_metadata( $attach_id, $filepath );
							wp_update_attachment_metadata( $attach_id, $attach_data );
							update_field( 'photo_profile', $attach_id, 'user_' . $user_id );
							
						}
					}
				}
			}
		} else {
			$result['status'] = 'error';
			
		}
		
		return $result;
	}
}

/*

if (!function_exists('user_reg_social')) {
	function user_reg_social($social_email, $social_identifier, $social_provider, $social_firstname, $social_lastname,$avatar_url) {
		$password = wp_generate_password();
		$last_id_user = get_field('last_id_user', 'option');
        $last_id_userToUpdate = intval($last_id_user) + 1;
		$login = 'id'.$last_id_user;
		$userdata = array(
			'user_login' => $login,
			'user_nicename' => $login,
			'user_pass' => $password,
			'remember' => true
        );
		if($social_email && $social_email != '') {
			$user_email = $social_email;
		} else {
			$user_email = $login.'@eto.ru';
		}
		
		$userdata['user_email'] = $user_email;
		
		if($social_firstname && $social_firstname != '') {
			$userdata['first_name'] = $social_firstname;
		}
		if($social_lastname && $social_lastname != '') {
			$userdata['last_name'] = $social_lastname;
		}
		if($social_firstname && $social_firstname != '' && $social_lastname && $social_lastname != '') {
			$userdata['display_name'] = $social_firstname.' '.$social_lastname;
		} elseif($social_firstname && $social_firstname != '' && !$social_lastname) {
			$userdata['display_name'] = $social_firstname;
		} elseif(!$social_firstname && $social_lastname && $social_lastname != '') {
			$userdata['display_name'] = $social_lastname;
		} else {
			$userdata['display_name'] = $user_email;
		}
        $user_id = wp_insert_user( $userdata );
		if($user_id) {
			$key = wp_generate_uuid4();
			update_field('last_id_user', $last_id_userToUpdate, 'option');
			update_field('key_activation', $key, 'user_'.$user_id);
        	$user_id_role = new WP_User($user_id);
        	$user_id_role->set_role('registereduser');
			if ($_COOKIE["_ym_uid"]) {
			  $timervop = htmlspecialchars($_COOKIE["_ym_uid"]);
			  update_field('client_id_yandex', $timervop, 'user_'.$user_id);
			}
			if ($social_provider && $social_provider != '' && $social_identifier && $social_identifier != '') {
				update_field('provider_'.$social_provider,$social_identifier,'user_'.$user_id);
				update_field('user_reg_from_social','yes','user_'.$user_id);
			}
			wp_clear_auth_cookie();
			wp_set_current_user ( $user_id );
			wp_set_auth_cookie  ( $user_id );
			if($avatar_url && $avatar_url != '' && $avatar_url != 'none') {
				$urler = $avatar_url;
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        $url = $urler;
        $timeout_seconds = 5;

        $temp_file = download_url( $url, $timeout_seconds );

        $typeimg = wp_check_filetype(basename($url));
        if ( !is_wp_error( $temp_file ) ) {


        $file = array(
        'name'     => basename($url),
        'type'     => $typeimg['type'],
        'tmp_name' => $temp_file,
        'error'    => 0,
        'size'     => filesize($temp_file),
        );

        $overrides = array('test_form' => false,'test_size' => true);
        $results = wp_handle_sideload( $file, $overrides );

        if ( !empty( $results['error'] ) ) {
        echo "Ошибка";
        } else {
        $filepath  = $results['file'];
        $filename = $results['url'];
        $filetype      = $results['type'];
        $arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
        if (in_array($filetype, $arr_img_ext)) {
        $upload = wp_upload_bits(basename( $filename ), null, file_get_contents($filepath));
        $filename = $upload['url'];
        $filepath =  $upload['file'];
        $filetype = wp_check_filetype( basename( $filename ), null );
        $wp_upload_dir = wp_upload_dir();
        $attachment = array(
        'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
        'post_mime_type' => $filetype['type'],
        'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
        'post_content'   => '',
        'post_status'    => 'inherit'
        );
        $attach_id = wp_insert_attachment( $attachment, $filename);
        apply_filters('wp_handle_upload', array('file' => $filepath, 'url' => $filename, 'type' => $filetype), 'upload');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $filepath );
        wp_update_attachment_metadata( $attach_id, $attach_data );
        update_field('photo_profile', $attach_id, 'user_'.$user_id);
        $attachment_id = get_field('photo_profile', 'user_'.$user_id);

        }
        }
        }
        
			}
			return $user_id;
		} else {
			return 'error';
		}
	}
}
*/

add_filter( 'wp_targeted_link_rel', 'my_function_remove_noreferrer' );
function my_function_remove_noreferrer( $rel_values ) {
	return preg_replace( '/noreferrer\s*/i', '', $rel_values );
}

function im_formatter( $content ) {
	$replace     = array( " noreferrer" => "", "noreferrer " => "" );
	$new_content = strtr( $content, $replace );
	
	return $new_content;
}

add_filter( 'the_content', 'im_formatter', 999 );


if ( ! function_exists( 'ajax_show_reply_form' ) ) {
	add_action( 'wp_ajax_ajax_show_reply_form', 'ajax_show_reply_form' );
	add_action( 'wp_ajax_nopriv_ajax_show_reply_form', 'ajax_show_reply_form' );
	function ajax_show_reply_form() {
		$data   = $_POST;
		$result = '';
		if ( is_user_logged_in() ) {
			$result .= '<form action="' . admin_url( 'admin-ajax.php' ) . '" method="post" id="form_reply" class="reply_form">';
			$result .= '<textarea name="comment_text" class="m_b_20" placeholder="' . __( 'Введите ваше сообщение', 'er_theme' ) . '"></textarea>';
			$result .= '<input type="hidden" name="action" value="new_submit_reply" />';
			$result .= '<input type="hidden" name="company_id" value="' . $data['company_id'] . '" />';
			$result .= '<input type="hidden" name="post_id" value="' . $data['post_id'] . '" />';
			$result .= '<input type="hidden" name="parent_id" value="' . $data['parent_id'] . '" />';
			$result .= '<input class="button button_green button_comments font_small font_bold m_b_10 pointer" type="submit" value="' . __( 'Ответить', 'er_theme' ) . '" />';
			$result .= '</form>';
		} else {
			$result = 'auth';
		}
		echo $result;
		die;
	}
}

function wpa_show_permalinks( $post_link, $post ) {
	
	if ( is_object( $post ) && $post->post_type == 'promocodes' ) {
		
		$terms = null;
		$terms_promocode_taxonomy = get_term( get_field( 'promocode_taxonomy' ), 'affiliate-tags' );
		if( isset( $terms_promocode_taxonomy->slug ) ) {
			
			$terms = $terms_promocode_taxonomy->slug;
			
			$args2 = array(
				'post_type' => 'promocodes_cats',
				'tax_query' => array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'slug',
						'terms'    => $terms
					)
				)
			);
			
			$slug_url = '';
			$promocode_category = get_posts( $args2 );
			
			if( isset( $promocode_category[0]->post_name ) ) {
				$slug_url = $promocode_category[0]->post_name;
			}
			
			if ( $terms ) {
				return str_replace( '%show_category%', $slug_url, $post_link );
			}
			
		}
		
	}
	
	return $post_link;
}

add_filter( 'post_type_link', 'wpa_show_permalinks', 1, 2 );
add_rewrite_rule( 'promocode/([^/]+)/([^/]+)', 'index.php?promocodes=$matches[2]', 'top' );


function wpa_show_permalinks_2( $post_link, $post ) {
	if ( is_object( $post ) && $post->post_type == 'addpages' ) {
		
		$terms = get_term( get_field( 'addpage_taxonomy' ), 'addpagestypes' );
		if( isset( $terms->slug ) ) {
			$terms = $terms->slug;
		}
		
		$review_id = get_field( 'addpage_review' );
		$slug = get_post_field( 'post_name', $review_id );
		if ( $terms ) {
			return str_replace( '%show_category%', $slug, $post_link );
		}
	}
	
	return $post_link;
}

add_filter( 'post_type_link', 'wpa_show_permalinks_2', 1, 2 );
add_rewrite_rule( 'review/([^/]+)/([^/]+)', 'index.php?addpages=$matches[2]', 'top' );

function webp_upload_mimes( $existing_mimes ) {
	$existing_mimes['webp'] = 'image/webp';
	
	return $existing_mimes;
}

add_filter( 'mime_types', 'webp_upload_mimes' );

function webp_is_displayable( $result, $path ) {
	if ( $result === false ) {
		$displayable_image_types = array( IMAGETYPE_WEBP );
		$info                    = @getimagesize( $path );
		
		if ( empty( $info ) ) {
			$result = false;
		} elseif ( ! in_array( $info[2], $displayable_image_types ) ) {
			$result = false;
		} else {
			$result = true;
		}
	}
	
	return $result;
}

add_filter( 'file_is_displayable_image', 'webp_is_displayable', 10, 2 );
/*
add_filter('the_content', 'changeUrlEz');

function changeUrlEz($content) {
	global $referalString;
	$content = preg_replace('/https:\/\/eto-razvod.ru/','', $content);
	return $content;
}*/

function set_r_v() {
	
	if ( is_singular() ) {
		global $post, $wp_query;
		
		// Исключение на русской версии поста с опцией 'Отключить обзор на русском языке'
		$curr_language = get_locale();
		if( $curr_language == 'ru_RU' and get_field( 'turn_off_on_ru_language',$post->ID ) == 'yes' ) {
			
			$wp_query->set_404();
			status_header( 404 );
			nocache_headers();
			
		}
		
		if( 'casino' == get_post_type() ) {
			
			echo recent_viewed_add( $post->ID );
			
		}
		
	}
}

add_action( 'wp', 'set_r_v' );



function alter_the_query( $request ) {
	
	$wp_query = new WP_Query();
	$wp_query->parse_query( $request );
	
	$curr_language = get_locale();
	
	// Подменяем страницы в зависимости от языка
	if( isset( $wp_query->get_queried_object()->post_name ) and isset( $wp_query->get_queried_object()->post_type ) and $wp_query->get_queried_object()->post_type == 'page' ) {
		
		$reassign = array(
			'en_US' => array(
				'legal' => '223046',
				'privacy-policy' => '223079',
				'rules' => '223101',
				'terms-of-use' => '223120',
				'offer' => '223160',
				'personal-data' => '223176',
			),
			'fr_FR' => array(
				'legal' => '223066',
				'privacy-policy' => '223083',
				'rules' => '223106',
				'terms-of-use' => '223126',
				'offer' => '223163',
				'personal-data' => '223181',
			),
			'de_DE' => array(
				'legal' => '223071',
				'privacy-policy' => '223090',
				'rules' => '223113',
				'terms-of-use' => '223143',
				'offer' => '223166',
				'personal-data' => '223184',
			),
			'es_ES' => array(
				'legal' => '223074',
				'privacy-policy' => '223093',
				'rules' => '223116',
				'terms-of-use' => '223149',
				'offer' => '223172',
				'personal-data' => '223185',
			),
			'pl_PL' => array(
				'legal' => '219957',
				'privacy-policy' => '219961',
				'rules' => '219964',
				'terms-of-use' => '219967',
				'offer' => '219970',
				'personal-data' => '223191',
			),
		);
		
		
		$reassign_page_id = '';
		if( isset( $reassign[ $curr_language ][ $wp_query->get_queried_object()->post_name ] ) ) {
			$reassign_page_id = $reassign[ $curr_language ][ $wp_query->get_queried_object()->post_name ];
		}
		
		if( $reassign_page_id ) {
			
			// $wp_query->set( 'page_id', $reassign_page_id );
			
			unset( $request['pagename'] );
			$request['page_id'] = $reassign_page_id;
			
		}
		
	}
	
	
	
	return $request;
}
add_filter( 'request', 'alter_the_query' );


// add_filter( 'posts_pre_query', 'wp_kama_posts_pre_query_filter', 10, 2 );
// function wp_kama_posts_pre_query_filter( $posts, $query ){

// error_log( print_r( [ basename(__FILE__) . ':' . __LINE__, $query ], 1 ) );
// 	return $posts;
// }


// add_filter( 'terms_pre_query', 'wp_kama_posts_pre_query_filter', 10, 2 );
// function wp_kama_posts_pre_query_filter( $posts, $query ){

// error_log( print_r( [ basename(__FILE__) . ':' . __LINE__, $query ], 1 ) );
// 	return $posts;
// }


add_action( "pre_get_posts", "custom_front_page" );
function custom_front_page( $wp_query ) {
	
	if ( is_admin() ) {
		return;
	}
	
	$curr_language = get_locale();
	
	// Замена главной страницы в зависимости от домена/языка		
	if ( $wp_query->get( 'page_id' ) == get_option( 'page_on_front' ) ):
		if ( $curr_language == 'en_US' ) {
			$wp_query->set( 'page_id', 182912 );
		} elseif ( $curr_language == 'fr_FR' ) {
			$wp_query->set( 'page_id', 191086 );
		} elseif ( $curr_language == 'de_DE' ) {
			$wp_query->set( 'page_id', 193428 );
		} elseif ( $curr_language == 'es_ES' ) {
			$wp_query->set( 'page_id', 193475 );
		} elseif ( $curr_language == 'pl_PL' ) {
			$wp_query->set( 'page_id', 219845 );
		} else {
			$wp_query->set( 'page_id', 132557 );
		}
	endif;
	
}

if ( ! function_exists( 'redirect_on_language_enabled' ) ) {
	add_action( 'template_redirect', 'redirect_on_language_enabled' );
	function redirect_on_language_enabled() {
		global $post;
		$current_language = get_locale();
		$is_enabled       = array();
		
		if ( $current_language != 'ru_RU' && $post->ID && $_SERVER['REQUEST_URI'] != '/robots.txt' ) {
			
			
			$is_enabled = get_field( 'enable_translations', $post->ID );
			// print_r($is_enabled);
			if ( ! in_array( $current_language, $is_enabled ) ) {
				//echo 'redirect';
				//$link = 'https://revieweek.com';
				//wp_redirect($link);
				global $wp_query;
				$wp_query->set_404();
				status_header( 404 );
				include( TEMPLATEPATH . "/404.php" );
				exit();
			}
		}
	}
}
if ( ! function_exists( 'redirect_on_language' ) ) {
	add_action( 'template_redirect', 'redirect_on_language' );
	function redirect_on_language() {
		if ( is_singular() ) {
			global $post;
			$redirect_on_language = get_field( 'redirect_on_language', $post->ID );
			if ( $redirect_on_language && $redirect_on_language != 'no' ) {
				if ( $redirect_on_language == 'en_US' ) {
					if ( $_SERVER['REQUEST_URI'] == '/home-en/' ) {
						$link = 'https://revieweek.com';
						wp_redirect( $link );
						exit;
					}
				} elseif ( $redirect_on_language == 'fr_FR' ) {
					if ( $_SERVER['REQUEST_URI'] == '/home-fr/' ) {
						$link = 'https://revieweek.fr';
						wp_redirect( $link );
						exit;
					}
				} elseif ( $redirect_on_language == 'de_DE' ) {
					if ( $_SERVER['REQUEST_URI'] == '/home-de/' ) {
						$link = 'https://revieweek.de';
						wp_redirect( $link );
						exit;
					}
				} elseif ( $redirect_on_language == 'es_ES' ) {
					if ( $_SERVER['REQUEST_URI'] == '/home-es/' ) {
						$link = 'https://revieweek.es';
						wp_redirect( $link );
						exit;
					}
				} elseif ( $redirect_on_language == 'pl_PL' ) {
					if ( $_SERVER['REQUEST_URI'] == '/home-pl/' ) {
						$link = 'https://pl.revieweek.com';
						wp_redirect( $link );
						exit;
					}
				}
			}
			/*if($soon_on_site) {
                wp_redirect(home_url());
                exit;
            }*/
		}
	}
}

add_shortcode( 'er_text', 'er_text_shortcodes' );

function er_text_shortcodes( $atts ) {
	if ( $atts['type'] == 'count_reviews' ) {
		$current_language = get_locale();
		if ( $current_language == 'ru_RU' ) {
			$comments_count = wp_count_comments();
			$number         = $comments_count->approved;
		} elseif ( $current_language != 'ru_RU' ) {
			$posts_in_language_args = array(
				'post_type'      => 'casino',
				'post_status'    => 'publish',
				'posts_per_page' => - 1,
				'meta_query'     => array(
					'relation' => 'AND',
					array(
						'key'     => 'enable_translations',
						'value'   => $current_language,
						'compare' => 'LIKE'
					)
				)
			
			);
			$posts_in_language      = new WP_Query( $posts_in_language_args );
			wp_reset_postdata();
			$post_ids_lang        = wp_list_pluck( $posts_in_language->posts, 'ID' );
			$post_ids_lang_string = implode( ',', $post_ids_lang );
			global $wpdb;
			$sql = "SELECT comment_ID
         FROM {$wpdb->comments} WHERE
         comment_post_ID in (" . implode( ',', $post_ids_lang ) . ") AND comment_approved = 1
         ORDER by comment_date DESC";
			
			$comments_list = $wpdb->get_results( $sql );
			$number        = count( $comments_list );
		} else {
			$comments_count = wp_count_comments();
			$number         = $comments_count->approved;
		}
		
		return __( number_format( $number, 0, ',', ' ' ) . ' <span>' . counted_text( $number, __( 'отзыв', 'er_theme' ), __( 'отзыва', 'er_theme' ), __( 'отзывов', 'er_theme' ) ) ).'</span>';
	} elseif ( $atts['type'] == 'count_casino' ) {
		$current_language = get_locale();
		if ( $current_language == 'ru_RU' ) {
			$number = wp_count_posts( 'casino' )->publish;
		} elseif ( $current_language != 'ru_RU' ) {
			$posts_in_language_args = array(
				'post_type'      => 'casino',
				'post_status'    => 'publish',
				'posts_per_page' => - 1,
				'meta_query'     => array(
					'relation' => 'AND',
					array(
						'key'     => 'enable_translations',
						'value'   => $current_language,
						'compare' => 'LIKE'
					)
				)
			
			);
			$posts_in_language      = new WP_Query( $posts_in_language_args );
			$number                 = $posts_in_language->found_posts;
		} else {
			$number = wp_count_posts( 'casino' )->publish;
		}
		
		return number_format( $number, 0, ',', ' ' ) . ' <span>' . counted_text( $number, __( 'компании', 'er_theme' ), __( 'компаний', 'er_theme' ), __( 'компаний', 'er_theme' ) ).'</span>';
		
	} elseif ( $atts['type'] == 'count_ratings' ) {
		$args_2       = array(
			'post_parent' => 0,
			'post_type'  => 'page',
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'template-rating.php'
		);
		$count_query  = new WP_Query( $args_2 );
		$cout_ratings = $count_query->found_posts;
		
		return number_format( $cout_ratings, 0, ',', ' ' ) . ' <span>' . counted_text( $cout_ratings, 'рейтинг', 'рейтинга', 'рейтингов' ).'</span>';
	}
	
	return '';
}


function my_acf_format_value( $value, $post_id, $field ) {
	
	// Render shortcodes in all textarea values.
	return do_shortcode( $value );
}

// Apply to all fields.
// add_filter('acf/format_value', 'my_acf_format_value', 10, 3);

// Apply to textarea fields.
add_filter( 'acf/format_value/type=textarea', 'my_acf_format_value', 10, 3 );


add_action( 'admin_init', 'wpse_74018_enable_draft_comments' );

/**
 * Add Comments Meta Box if CPT is 'draft' or 'pending'
 */
function wpse_74018_enable_draft_comments() {
	if ( isset( $_GET['post'] ) ) {
		$post_id = absint( $_GET['post'] );
		$post    = get_post( $post_id );
		if ( 'draft' == $post->post_status || 'pending' == $post->post_status ) {
			add_meta_box(
				'commentsdiv',
				__( 'Comments' ),
				'post_comment_meta_box',
				'casino', // CHANGE FOR YOUR CPT
				'normal',
				'core'
			);
		}
	}
}


function promocodes_faq( $values ) {
	$result            = '';
	$datetime          = new DateTime( 'tomorrow' );
	$tomorrow          = $datetime->format( 'd.m.Y' );
	$custom_promocodes = get_field( 'promocode_faq_add', $values['post_id'] );
	if ( ! empty( $custom_promocodes ) ) {
		$fields = array();
		foreach ( $custom_promocodes as $custom_promocode ) {
			$fields[] = array(
				'question' => $custom_promocode['question'],
				'answer'   => $custom_promocode['answer'],
			);
		}
	} else {
		$current_language = get_locale();
		if ( $current_language != 'ru_RU' ) {
			
			$cyr               = [
				'Љ',
				'Њ',
				'Џ',
				'џ',
				'ш',
				'ђ',
				'ч',
				'ћ',
				'ж',
				'љ',
				'њ',
				'Ш',
				'Ђ',
				'Ч',
				'Ћ',
				'Ж',
				'Ц',
				'ц',
				'а',
				'б',
				'в',
				'г',
				'д',
				'е',
				'ё',
				'ж',
				'з',
				'и',
				'й',
				'к',
				'л',
				'м',
				'н',
				'о',
				'п',
				'р',
				'с',
				'т',
				'у',
				'ф',
				'х',
				'ц',
				'ч',
				'ш',
				'щ',
				'ъ',
				'ы',
				'ь',
				'э',
				'ю',
				'я',
				'А',
				'Б',
				'В',
				'Г',
				'Д',
				'Е',
				'Ё',
				'Ж',
				'З',
				'И',
				'Й',
				'К',
				'Л',
				'М',
				'Н',
				'О',
				'П',
				'Р',
				'С',
				'Т',
				'У',
				'Ф',
				'Х',
				'Ц',
				'Ч',
				'Ш',
				'Щ',
				'Ъ',
				'Ы',
				'Ь',
				'Э',
				'Ю',
				'Я'
			];
			$lat               = [
				'Lj',
				'Nj',
				'Dž',
				'dž',
				'š',
				'đ',
				'č',
				'ć',
				'ž',
				'lj',
				'nj',
				'Š',
				'Đ',
				'Č',
				'Ć',
				'Ž',
				'C',
				'c',
				'a',
				'b',
				'v',
				'g',
				'd',
				'e',
				'io',
				'zh',
				'z',
				'i',
				'y',
				'k',
				'l',
				'm',
				'n',
				'o',
				'p',
				'r',
				's',
				't',
				'u',
				'f',
				'h',
				'ts',
				'ch',
				'sh',
				'sht',
				'a',
				'i',
				'y',
				'e',
				'yu',
				'ya',
				'A',
				'B',
				'V',
				'G',
				'D',
				'E',
				'Io',
				'Zh',
				'Z',
				'I',
				'Y',
				'K',
				'L',
				'M',
				'N',
				'O',
				'P',
				'R',
				'S',
				'T',
				'U',
				'F',
				'H',
				'Ts',
				'Ch',
				'Sh',
				'Sht',
				'A',
				'I',
				'Y',
				'e',
				'Yu',
				'Ya'
			];
			$values['company'] = str_replace( $cyr, $lat, $values['company'] );
			if ( $values['count_all'] == 1 ) {
				$sklon = [ 'active', 'coupon', 'available', 'active', 'coupon', 'which will allow ' ];
			} elseif ( ( $values['count_all'] >= 2 ) && ( $values['count_all'] <= 4 ) ) {
				$sklon = [ 'active', 'coupon', 'available', 'актуальных', 'coupons', 'which will allow ' ];
			} elseif ( $values['count_all'] >= 5 ) {
				$sklon = [ 'active', 'coupon', 'available', 'актуальных', 'coupons', 'which will allow ' ];
			}
			
			if ( $values['count_all'] == 0 ) {
				$fields = array(
					/*array(
                        'question' => __('Где взять промокод компании ','er_theme').$values['company'].'?',
                        'answer' => 'На нашем сайте. Сейчас у нас нет промокодов '.$values['company'].'. В ближайшее время промокоды появятся на этой странице.',
                    ),*/
					array(
						// 'question' => 'What are promo codes, coupons and discounts of ' . $values['company'] . ' for ' . $values['date'] . '?',
						'question' => wp_sprintf( __( 'What are promo codes, coupons and discounts of %s for %s?', 'er_theme' ), $values['company'], $values['date'] ),
						// 'answer'   => substr_replace( $values['titles'], "", - 2 ) . ' и другие.',
						'answer'   => wp_sprintf( __( '%s и другие.', 'er_theme' ), substr_replace( $values['titles'], "", - 2 ) ),
						// 'answer'   => 'For ' . $values['date'] . ' we do not have promo codes of ' . $values['company'] . ', but we are already working on it.'
						'answer'   => wp_sprintf( __( 'For %s we do not have promo codes of %s, but we are already working on it.', 'er_theme' ), $values['date'], $values['company'] ),
					),
					array(
						// 'question' => 'How to use a promotional code on the site of ' . $values['company'] . '?',
						'question' => wp_sprintf( __( 'How to use a promotional code on the site of %s?', 'er_theme' ), $values['company'] ),
						// 'answer'   => 'Examine the promotional codes on our website, copy the desired promotional code and use it when ordering services from ' . $values['company'] . '.'
						'answer'   => wp_sprintf( __( 'Examine the promotional codes on our website, copy the desired promotional code and use it when ordering services from %s.', 'er_theme' ), $values['company'] ),
					),
				);
				
				
			} elseif ( ( $values['count_all'] == 1 ) ) {
				$fields = array(
					/*array(
                        'question' => __('Где взять промокод компании ','er_theme').$values['company'].'?',
                        'answer' => 'На нашем сайте.',
                    ),*/
					array(
						'question' => 'How many promo codes of ' . $values['company'] . ' will help you save money? ',
						'answer'   => 'You have 1 promo code available of ' . $values['company'] . '.'
					),
					array(
						'question' => 'What are promo codes, coupons and discounts of ' . $values['company'] . ' for ' . $values['date'] . '?',
						'answer'   => 'For ' . $values['date'] . ' there is 1 promo code available of ' . $values['company'] . ', which will help you save on purchases  ' . $values['discount_max'] . '. It will expire on ' . $values['date'] . '.'
					),
					array(
						'question' => 'How to use a promotional code on the site of ' . $values['company'] . '?',
						'answer'   => 'Examine the promotional codes on our website, copy the desired promotional code and use it when ordering services from ' . $values['company'] . '.'
					
					),
				);
			} elseif ( ( $values['count_all'] == 2 ) ) {
				$fields = array(
					/*array(
                        'question' => __('Где взять промокод компании ','er_theme').$values['company'].'?',
                        'answer' => 'На нашем сайте.',
                    ),*/
					array(
						'question' => 'How many promo codes of ' . $values['company'] . ' will help you save money?',
						'answer'   => 'You have 2 promo codes available of ' . $values['company'] . '.'
					),
					array(
						'question' => 'What are promo codes, coupons and discounts of ' . $values['company'] . ' for ' . $values['date'] . '?',
						'answer'   => 'For ' . $values['date'] . ' there are 2 promo codes available for ' . $values['company'] . ', which will help you save on purchases ' . $values['discount_max'] . ': ' . substr_replace( $values['titles'], "", - 2 ) . '.<br> One of them expires ' . $values['date'] . '.'
					
					),
					array(
						'question' => 'How to use a promotional code on the site of ' . $values['company'] . '?',
						//'answer' => 'Изучите промокоды на нашем сайте, скопируйте нужный промокод и используйте его при заказе услуг в компании '.$values['company'].'.'
						'answer'   => 'Examine the promotional codes on our website, copy the desired promotional code and use it when ordering services from ' . $values['company'] . '.'
					
					),
				);
			} elseif ( ( $values['count_all'] == 3 ) ) {
				$fields = array(
					/*array(
                        'question' => __('Где взять промокод компании ','er_theme').$values['company'].'?',
                        'answer' => 'На нашем сайте.',
                    ),*/
					array(
						'question' => 'How many promo codes of ' . $values['company'] . ' will help you save money?',
						'answer'   => 'Today you have access to 3 actual promotional codes of ' . $values['company'] . '.'
					),
					array(
						'question' => 'What are promo codes, coupons and discounts of ' . $values['company'] . ' for ' . $values['date'] . '?',
						//'answer' => substr_replace($values['titles'], "", -2).' и другие.',
						'answer'   => 'For ' . $values['date'] . ' there are 3 promo codes available for ' . $values['company'] . ', which will help you save on purchases ' . $values['discount_max'] . ': ' . substr_replace( $values['titles'], "", - 2 ) . '.<br> Some of them expire ' . $values['date'] . '.'
					
					),
					array(
						'question' => 'How to use a promotional code on the site of ' . $values['company'] . '?',
						//'answer' => 'Изучите промокоды на нашем сайте, скопируйте нужный промокод и используйте его при заказе услуг в компании '.$values['company'].'.'
						'answer'   => 'Examine the promotional codes on our website, copy the desired promotional code and use it when ordering services from ' . $values['company'] . '.'
					
					),
				);
			} elseif ( ( $values['count_all'] == 4 ) ) {
				$fields = array(
					/*array(
                        'question' => __('Где взять промокод компании ','er_theme').$values['company'].'?',
                        'answer' => 'На нашем сайте.',
                    ),*/
					array(
						'question' => 'How many promo codes of ' . $values['company'] . ' will help you save money?',
						'answer'   => 'Today you have access to 4 actual promotional codes of ' . $values['company'] . '.'
					),
					array(
						'question' => 'What are promo codes, coupons and discounts of ' . $values['company'] . ' for ' . $values['date'] . '?',
						//'answer' => substr_replace($values['titles'], "", -2).' и другие.',
						'answer'   => 'For ' . $values['date'] . ' the following promo codes of  ' . $values['company'] . ' are available and will save you money on purchases  ' . $values['discount_max'] . ': ' . substr_replace( $values['titles'], "", - 2 ) . '.<br> Some of them expire on ' . $values['date'] . '.'
					
					),
					array(
						'question' => 'How to use a promotional code on the site of ' . $values['company'] . '?',
						//'answer' => 'Изучите промокоды на нашем сайте, скопируйте нужный промокод и используйте его при заказе услуг в компании '.$values['company'].'.'
						'answer'   => 'Explore promo codes of ' . $values['company'] . ', copy the required promotional code and use it when ordering services of' . $values['company'] . '.'
					
					),
				);
			} elseif ( ( $values['count_all'] >= 5 ) ) {
				$fields = array(
					/*array(
                        'question' => __('Где взять промокод компании ','er_theme').$values['company'].'?',
                        'answer' => 'На нашем сайте.',
                    ),*/
					array(
						'question' => 'How many promo codes of ' . $values['company'] . ' will help you save money?',
						'answer'   => 'Today you have access to ' . $values['count_all'] . ' actual promotional codes of ' . $values['company'] . '.'
					),
					array(
						'question' => 'What are promo codes, coupons and discounts of ' . $values['company'] . ' for ' . $values['date'] . '?',
						//'answer' => substr_replace($values['titles'], "", -2).' и другие.',
						'answer'   => 'For ' . $values['date'] . ' the following promo codes of ' . $values['company'] . ' are available and will save you money on purchases ' . $values['discount_max'] . ': ' . substr_replace( $values['titles'], "", - 2 ) . '.<br> Some of them expire on ' . $values['date'] . '.'
					
					),
					array(
						'question' => 'How to use a promotional code on the site of ' . $values['company'] . '?',
						//'answer' => 'Изучите промокоды на нашем сайте, скопируйте нужный промокод и используйте его при заказе услуг в компании '.$values['company'].'.'
						'answer'   => 'Explore promo codes of ' . $values['company'] . ', copy the required promotional code and use it when ordering services of ' . $values['company'] . '.'
					
					),
				);
			}
		} else {
			
			if ( $values['count_all'] == 1 ) {
				$sklon = [ 'актуален', 'промокод', 'доступен', 'актуальный', 'промокод', 'который позволит' ];
			} elseif ( ( $values['count_all'] >= 2 ) && ( $values['count_all'] <= 4 ) ) {
				$sklon = [ 'актуальны', 'промокода', 'доступно', 'актуальных', 'промокода', 'которые позволят' ];
			} elseif ( $values['count_all'] >= 5 ) {
				$sklon = [ 'актуальны', 'промокодов', 'доступно', 'актуальных', 'промокодов', 'которые позволят' ];
			}
			
			if ( $values['count_all'] == 0 ) {
				$fields = array(
					/*array(
                    'question' => __('Где взять промокод компании ','er_theme').$values['company'].'?',
                    'answer' => 'На нашем сайте. Сейчас у нас нет промокодов '.$values['company'].'. В ближайшее время промокоды появятся на этой странице.',
                ),*/
					array(
						// 'question' => 'Какие есть промокоды, купоны и скидки ' . $values['company'] . ' на ' . $values['date'] . '?',
						'question' => wp_sprintf( __( 'Какие есть промокоды, купоны и скидки %s на %s?', 'er_theme' ), $values['company'], $values['date'] ),
						// 'answer'   => substr_replace( $values['titles'], "", - 2 ) . ' и другие.',
						'answer'   => wp_sprintf( __( '%s и другие.', 'er_theme' ), substr_replace( $values['titles'], "", - 2 ) ),
						// 'answer'   => 'На ' . $values['date'] . ' у нас нет промокодов ' . $values['company'] . ', но мы уже работаем над этим.'
						'answer'   => wp_sprintf( __( 'На %s у нас нет промокодов %s, но мы уже работаем над этим.', 'er_theme' ), $values['date'], $values['company'] ),
					),
					array(
						// 'question' => 'Как использовать промокод на сайте ' . $values['company'] . '?',
						'question' => wp_sprintf( __( 'Как использовать промокод на сайте %s?', 'er_theme' ), $values['company'] ),
						// 'answer'   => 'Изучите промокоды на нашем сайте, скопируйте нужный промокод и используйте его при заказе услуг в компании ' . $values['company'] . '.'
						'answer'   => wp_sprintf( __( 'Изучите промокоды на нашем сайте, скопируйте нужный промокод и используйте его при заказе услуг в компании %s.', 'er_theme' ), $values['company'] ),
					),
				);
			} elseif ( ( $values['count_all'] == 1 ) ) {
				$fields = array(
					/*array(
                    'question' => __('Где взять промокод компании ','er_theme').$values['company'].'?',
                    'answer' => 'На нашем сайте.',
                ),*/
					array(
						// 'question' => 'Сколько промокодов ' . $values['company'] . ' помогут вам сэкономить?',
						'question' => wp_sprintf( __( 'Сколько промокодов %s помогут вам сэкономить?', 'er_theme' ), $values['company'] ),
						// 'answer'   => 'Вам доступен 1 промокод компании ' . $values['company'] . '.'
						'answer'   => wp_sprintf( __( 'Вам доступен %s промокод компании %s.', 'er_theme' ), 1, $values['company'] ),
					),
					array(
						// 'question' => 'Какие есть промокоды, купоны и скидки ' . $values['company'] . ' на ' . $values['date'] . '?',
						'question' => wp_sprintf( __( 'Какие есть промокоды, купоны и скидки %s на %s?', 'er_theme' ), $values['company'], $values['date'] ),
						// 'answer'   => 'На ' . $values['date'] . ' актуален 1 промокод ' . $values['company'] . ', который позволит сэкономить на покупках ' . $values['discount_max'] . '. Его действие закончится ' . $values['date'] . '.'
						'answer'   => wp_sprintf( __( 'На %s актуален %s промокод %s, который позволит сэкономить на покупках %s. Его действие закончится %s.', 'er_theme' ), $values['date'], 1, $values['company'], $values['discount_max'], $values['date'] ),
					),
					array(
						// 'question' => 'Как использовать промокод на сайте ' . $values['company'] . '?',
						'question' => wp_sprintf( __( 'Как использовать промокод на сайте %s?', 'er_theme' ), $values['company'] ),
						// 'answer'   => 'Скопируйте промокод и используйте его при заказе услуг в компании ' . $values['company'] . '.'
						'answer'   => wp_sprintf( __( 'Скопируйте промокод и используйте его при заказе услуг в компании %s.', 'er_theme' ), $values['company'] ),
					),
				);
			} elseif ( ( $values['count_all'] == 2 ) ) {
				$fields = array(
					/*array(
                    'question' => __('Где взять промокод компании ','er_theme').$values['company'].'?',
                    'answer' => 'На нашем сайте.',
                ),*/
					array(
						// 'question' => 'Сколько промокодов ' . $values['company'] . ' помогут вам сэкономить?',
						'question' => wp_sprintf( __( 'Сколько промокодов %s помогут вам сэкономить?', 'er_theme' ), $values['company'] ),
						// 'answer'   => 'Вам доступно 2 актуальных промокода компании ' . $values['company'] . '.'
						'answer'   => wp_sprintf( __( 'Вам доступно %s актуальных промокода компании %s.', 'er_theme' ), 2, $values['company'] ),
					),
					array(
						// 'question' => 'Какие есть промокоды, купоны и скидки ' . $values['company'] . ' на ' . $values['date'] . '?',
						'question' => wp_sprintf( __( 'Какие есть промокоды, купоны и скидки %s на %s?', 'er_theme' ), $values['company'], $values['date'] ),
						// 'answer'   => 'На ' . $values['date'] . ' актуально 2 промокода ' . $values['company'] . ', которые позволят сэкономить на покупках до ' . $values['discount_max'] . ': ' . substr_replace( $values['titles'], "", - 2 ) . '.<br> Действие одного из них истекает ' . $values['date'] . '.'
						'answer'   => wp_sprintf( __( 'На %s актуально %s промокода %s, которые позволят сэкономить на покупках до %s: %s.<br> Действие одного из них истекает %s', 'er_theme' ), $values['date'], 2, $values['company'], $values['discount_max'], substr_replace( $values['titles'], "", - 2 ), $values['date'] ),
					),
					array(
						// 'question' => 'Как использовать промокод на сайте ' . $values['company'] . '?',
						'question' => wp_sprintf( __( 'Как использовать промокод на сайте %s?', 'er_theme' ), $values['company'] ),
						//'answer' => 'Изучите промокоды на нашем сайте, скопируйте нужный промокод и используйте его при заказе услуг в компании '.$values['company'].'.'
						// 'answer'   => 'Изучите промокоды, скопируйте нужный промокод и используйте его при заказе услуг в компании ' . $values['company'] . '.'
						'answer'   => wp_sprintf( __( 'Изучите промокоды, скопируйте нужный промокод и используйте его при заказе услуг в компании %s.', 'er_theme' ), $values['company'] ),
					),
				);
			} elseif ( ( $values['count_all'] == 3 ) ) {
				$fields = array(
					/*array(
                    'question' => __('Где взять промокод компании ','er_theme').$values['company'].'?',
                    'answer' => 'На нашем сайте.',
                ),*/
					array(
						// 'question' => 'Сколько промокодов ' . $values['company'] . ' помогут вам сэкономить?',
						'question' => wp_sprintf( __( 'Сколько промокодов %s помогут вам сэкономить?', 'er_theme' ), $values['company'] ),
						// 'answer'   => 'Сегодня вам доступно 3 актуальных промокода компании ' . $values['company'] . '.'
						'answer'   => wp_sprintf( __( 'Сегодня вам доступно %s актуальных промокода компании %s.', 'er_theme' ), 3, $values['company'] ),
					),
					array(
						// 'question' => 'Какие есть промокоды, купоны и скидки ' . $values['company'] . ' на ' . $values['date'] . '?',
						'question' => wp_sprintf( __( 'Какие есть промокоды, купоны и скидки %s на %s?', 'er_theme' ), $values['company'], $values['date'] ),
						//'answer' => substr_replace($values['titles'], "", -2).' и другие.',
						// 'answer'   => 'На ' . $values['date'] . ' актуально 3 промокода ' . $values['company'] . ', которые позволят сэкономить на покупках до ' . $values['discount_max'] . ': ' . substr_replace( $values['titles'], "", - 2 ) . '.<br> Некоторые из них истекают ' . $values['date'] . '.'
						'answer'   => wp_sprintf( __( 'На %s актуально %s промокода %s, которые позволят сэкономить на покупках до %s: %s.<br> Некоторые из них истекают %s.', 'er_theme' ), $values['date'], 3, $values['company'], $values['discount_max'], substr_replace( $values['titles'], "", - 2 ), $values['date'] ),
					),
					array(
						// 'question' => 'Как использовать промокод на сайте ' . $values['company'] . '?',
						'question' => wp_sprintf( __( 'Как использовать промокод на сайте %s?', 'er_theme' ), $values['company'] ),
						//'answer' => 'Изучите промокоды на нашем сайте, скопируйте нужный промокод и используйте его при заказе услуг в компании '.$values['company'].'.'
						// 'answer'   => 'Изучите промокоды, скопируйте нужный промокод и используйте его при заказе услуг в компании ' . $values['company'] . '.'
						'answer'   => wp_sprintf( __( 'Изучите промокоды, скопируйте нужный промокод и используйте его при заказе услуг в компании %s.', 'er_theme' ), $values['company'] ),
					),
				);
			} elseif ( ( $values['count_all'] == 4 ) ) {
				$fields = array(
					/*array(
                    'question' => __('Где взять промокод компании ','er_theme').$values['company'].'?',
                    'answer' => 'На нашем сайте.',
                ),*/
					array(
						// 'question' => 'Сколько промокодов ' . $values['company'] . ' помогут вам сэкономить?',
						'question' => wp_sprintf( __( 'Сколько промокодов %s помогут вам сэкономить?', 'er_theme' ), $values['company'] ),
						// 'answer'   => 'Сегодня вам доступно 4 актуальных промокода компании ' . $values['company'] . '.'
						'answer'   => wp_sprintf( __( 'Сегодня вам доступно %s актуальных промокода компании %s.', 'er_theme' ), 4, $values['company'] ),
					),
					array(
						// 'question' => 'Какие есть промокоды, купоны и скидки ' . $values['company'] . ' на ' . $values['date'] . '?',
						'question' => wp_sprintf( __( 'Какие есть промокоды, купоны и скидки %s на %s?', 'er_theme' ), $values['company'], $values['date'] ),
						//'answer' => substr_replace($values['titles'], "", -2).' и другие.',
						// 'answer'   => 'На ' . $values['date'] . ' доступны следующие промокоды ' . $values['company'] . ', которые позволят сэкономить на покупках до ' . $values['discount_max'] . ': ' . substr_replace( $values['titles'], "", - 2 ) . '.<br> Некоторые из них истекают ' . $values['date'] . '.'
						'answer'   => wp_sprintf( __( 'На %s доступны следующие промокоды %s, которые позволят сэкономить на покупках до %s: %s.<br> Некоторые из них истекают %s.', 'er_theme' ), $values['date'], $values['company'], $values['discount_max'], substr_replace( $values['titles'], "", - 2 ), $values['date'] ),
					),
					array(
						// 'question' => 'Как использовать промокод на сайте ' . $values['company'] . '?',
						'question' => wp_sprintf( __( 'Как использовать промокод на сайте %s?', 'er_theme' ), $values['company'] ),
						//'answer' => 'Изучите промокоды на нашем сайте, скопируйте нужный промокод и используйте его при заказе услуг в компании '.$values['company'].'.'
						// 'answer'   => 'Изучите промокоды ' . $values['company'] . ', скопируйте нужный промокод и используйте его при заказе услуг в компании ' . $values['company'] . '.'
						'answer'   => wp_sprintf( __( 'Изучите промокоды %s, скопируйте нужный промокод и используйте его при заказе услуг в компании %s.', 'er_theme' ), $values['company'], $values['company'] ),
					),
				);
			} elseif ( ( $values['count_all'] >= 5 ) ) {
				$fields = array(
					/*array(
                    'question' => __('Где взять промокод компании ','er_theme').$values['company'].'?',
                    'answer' => 'На нашем сайте.',
                ),*/
					array(
						// 'question' => 'Сколько промокодов ' . $values['company'] . ' помогут вам сэкономить?',
						'question' => wp_sprintf( __( 'Сколько промокодов %s помогут вам сэкономить?', 'er_theme' ), $values['company'] ),
						// 'answer'   => 'Сегодня вам доступно ' . $values['count_all'] . ' актуальных промокодов компании ' . $values['company'] . '.'
						'answer'   => wp_sprintf( __( 'Сегодня вам доступно %s актуальных промокодов компании %s.', 'er_theme' ), $values['count_all'], $values['company'] ),
					),
					array(
						// 'question' => 'Какие есть промокоды, купоны и скидки ' . $values['company'] . ' на ' . $values['date'] . '?',
						'question' => wp_sprintf( __( 'Какие есть промокоды, купоны и скидки %s на %s?', 'er_theme' ), $values['company'], $values['date'] ),
						//'answer' => substr_replace($values['titles'], "", -2).' и другие.',
						// 'answer'   => 'На ' . $values['date'] . ' доступны следующие промокоды ' . $values['company'] . ', которые позволят сэкономить на покупках до ' . $values['discount_max'] . ': ' . substr_replace( $values['titles'], "", - 2 ) . '.<br> Некоторые из них истекают ' . $values['date'] . '.'
						'answer'   => wp_sprintf( __( 'На %s доступны следующие промокоды %s, которые позволят сэкономить на покупках до %s: %s.<br> Некоторые из них истекают %s.', 'er_theme' ), $values['date'], $values['company'], $values['discount_max'], substr_replace( $values['titles'], "", - 2 ), $values['date'] ),
					
					),
					array(
						// 'question' => 'Как использовать промокод на сайте ' . $values['company'] . '?',
						'question' => wp_sprintf( __( 'Как использовать промокод на сайте %s?', 'er_theme' ), $values['company'] ),
						//'answer' => 'Изучите промокоды на нашем сайте, скопируйте нужный промокод и используйте его при заказе услуг в компании '.$values['company'].'.'
						// 'answer'   => 'Изучите промокоды ' . $values['company'] . ', скопируйте нужный промокод и используйте его при заказе услуг в компании ' . $values['company'] . '.'
						'answer'   => wp_sprintf( __( 'Изучите промокоды %s, скопируйте нужный промокод и используйте его при заказе услуг в компании %s.', 'er_theme' ), $values['company'], $values['company'] ),
					),
				);
			}
//        $fields = array(
//            array(
//                'question' => __('Где взять промокод компании ','er_theme').$values['company'].'?',
//                'answer' => 'Использовать промокоды вы можете прямо сейчас. На сегодняшнюю дату '.$values['date'].' '.$sklon[0].' '.$values['count_all'].' '.$sklon[1].' '.$values['company'].', '.$sklon[5].' легко сэкономить на покупках от '.$values['discount_min'].'% до '.$values['discount_max'].'%. Некоторые из них истекают '.$tomorrow.'. Спешите воспользоваться ими прямо сейчас.',
//            ),
//            /*array(
//                'question' => 'Насколько актуальны промокоды компании '.$values['company'].'?',
//                'answer' => 'Все промокоды '.$values['company'].' актуальны на сегодняшнюю дату '.$values['date'].' и проверены нашими специалистами.'
//            ),*/
//            array(
//                'question' => 'Сколько промокодов '.$values['company'].' помогут вам сэкономить?',
//                'answer' => 'Сегодня вам '.$sklon[2].' '.$values['count_all'].' '.$sklon[3].' '.$sklon[4].' компании '.$values['company'].': из них: скидок – '.$values['count_all'].'. Спешите воспользоваться ими для большей выгоды.'
//            ),
//            array(
//                'question' => 'Какие есть промокоды, купоны и скидки '.$values['company'].' на '.$values['date'].'?',
//                'answer' => substr_replace($values['titles'], "", -2).' и другие.'
//            ),
//            array(
//                'question' => 'Как использовать промокод на сайте '.$values['company'].'?',
//                'answer' => 'Найдите подходящий промокод из списка прямо сейчас. Для этого просто изучите промокоды, скопируйте нужный промокод и используйте его при заказе услуг в компании '.$values['company'].'.'
//            ),
//        );
		}
	}
	$result           .= '<div itemscope="" itemtype="https://schema.org/FAQPage" class="schema-faq wp-block-yoast-faq-block yoast-faq-accordion">';
	
	// $current_language = get_locale();
	// if ( $current_language == 'ru_RU' ) {
	// 	$result .= '<h2>Частые вопросы о промокодах ' . $values['company'] . '</h2>';
	// } elseif ( $current_language == 'fr_FR' ) {
	// 	$result .= '<h2>Questions fréquentes sur les codes promo de ' . $values['company'] . '</h2>';
	// } else {
	// 	$result .= '<h2>Frequently asked questions about promo codes of ' . $values['company'] . '</h2>';
	// }
	
	$result .= '<h2>' . wp_sprintf( __( 'Частые вопросы о промокодах %s', 'er_theme' ), $values['company'] ) . '</h2>';
	
	$total   = count( $fields );
	$counter = 0;
	foreach ( $fields as $item ) {
		$counter ++;
		if ( $counter % 2 == 0 ) {
			$oddeven = "even";
		} else {
			$oddeven = "odd";
		}
		$result .= '<div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question" class="schema-faq-section ' . $oddeven . '" id="faq_item' . $counter . '"><div itemprop="name" class="schema-faq-question"><span>' . $item['question'];
		$result .= '</span></div><div class="schema-faq-answer" itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"><span itemprop="text">' . $item['answer'] . '</span></div></div>';
	}
	$result .= '</div>';
	
	return $result;
}


//Для нашего нового юзверя "Зарегистрированный пользоваль" сносим кнопку консоль, он там видит служебную инфу
function remove_menus() {
	global $menu;
	global $current_user;
	if ( in_array( 'registereduser', $current_user->roles ) ) {
		
		$restricted = array( __( 'Dashboard' ) );
		end( $menu );
		while ( prev( $menu ) ) {
			$value = explode( ' ', $menu[ key( $menu ) ][0] );
			if ( in_array( $value[0] != null ? $value[0] : '', $restricted ) ) {
				unset( $menu[ key( $menu ) ] );
			}
		}
	}
}

add_action( 'admin_menu', 'remove_menus' );

//Для нашего нового юзверя "Зарегистрированный пользоваль" делаем редирект со страницы "Консоль" на его профиль
function dashboard_redirect() {
	global $current_user;
	if ( in_array( 'registereduser', $current_user->roles ) ) {
		wp_redirect( admin_url( 'profile.php' ) );
	}
}

add_action( 'load-index.php', 'dashboard_redirect' );

//Проверка роли юзверя
function is_user_role( $role, $user_id = null ) {
	$user = is_numeric( $user_id ) ? get_userdata( $user_id ) : wp_get_current_user();
	
	if ( ! $user ) {
		return false;
	}
	
	return in_array( $role, (array) $user->roles );
}

if ( is_user_role( 'registereduser' ) ) {
	function hide_admin_bar() {
		return false;
	}
	
	add_filter( 'show_admin_bar', 'hide_admin_bar' );
}


add_filter( 'manage_users_columns', 'rudr_modify_user_table' );

function rudr_modify_user_table( $columns ) {
	
	
	$columns['registration_date'] = __( 'Дата регистрации', 'er_theme' );
	
	return $columns;
	
}

add_filter( 'manage_users_custom_column', 'rudr_modify_user_table_row', 10, 3 );

function rudr_modify_user_table_row( $row_output, $column_id_attr, $user ) {
	
	$date_format = 'j/m/Y H:i';
	
	switch ( $column_id_attr ) {
		case 'registration_date' :
			return date( $date_format, strtotime( get_the_author_meta( 'registered', $user ) ) );
			break;
		default:
	}
	
	return $row_output;
	
}

add_filter( 'manage_users_sortable_columns', 'rudr_make_registered_column_sortable' );

function rudr_make_registered_column_sortable( $columns ) {
	return wp_parse_args( array( 'registration_date' => 'registered' ), $columns );
}

//
function my_page_columns( $columns ) {
	$columns = array(
		'cb'               => '< input type="checkbox" />',
		'title'            => __( 'Название', 'er_theme' ),
		'banner_type'      => __( 'Тип баннера', 'er_theme' ),
		'banner_place'     => __( 'Место размещения', 'er_theme' ),
		'banner_targeting' => __( 'Таргетинг', 'er_theme' ),
		'date'             => __( 'Дата', 'er_theme' ),
	);
	
	return $columns;
}

function my_custom_columns( $column ) {
	global $post;
	if ( $column == 'banner_type' ) {
		echo get_field( 'banner_type', $post->ID );
	} elseif ( $column == 'banner_place' ) {
		echo get_field( 'banner_place', $post->ID );
	} elseif ( $column == 'banner_targeting' ) {
		$default  = get_field( 'banner_default', $post->ID );
		$by_tags  = get_field( 'banner_tags', $post->ID );
		$by_posts = get_field( 'banner_posts', $post->ID );
		$time     = get_field( 'banner_seconds', $post->ID );
		if ( $default ) {
			echo __( 'По умолчанию', 'er_theme' );
		}
		if ( ! empty( $by_tags ) ) {
			echo '<div>';
			echo '<strong>' . __( 'Метки:', 'er_theme' ) . ' </strong>';
			// print_r($by_tags);
			$terms = get_terms( 'affiliate-tags', array( 'include' => $by_tags ) );
			$i     = 0;
			$total = count( $terms );
			foreach ( $terms as $term ) {
				$i ++;
				echo $term->name;
				if ( $i != $total ) {
					echo ', ';
				}
			}
			echo '</div>';
		}
		if ( ! empty( $by_posts ) ) {
			echo '<div>';
			echo '<strong>' . __( 'Посты:', 'er_theme' ) . ' </strong>';
			$i     = 0;
			$total = count( $by_posts );
			foreach ( $by_posts as $post ) {
				$i ++;
				echo '<a href="' . get_the_permalink( $post ) . '" target="_blank">';
				echo get_the_title( $post );
				echo '</a>';
				if ( $i != $total ) {
					echo ' / ';
				}
				
			}
			echo '</div>';
		}
		if ( $time ) {
			echo '<div>';
			echo '<strong>' . __( 'Время:', 'er_theme' ) . ' </strong>';
			echo $time;
			echo '</div>';
		}
	} else {
		echo '';
	}
}

add_action( "manage_banners_posts_custom_column", "my_custom_columns" );
add_filter( "manage_edit-banners_columns", "my_page_columns" );


function my_page_columns_brokers( $columns ) {
	$columns                  = array();
	$columns['cb']            = __( 'ID', 'er_theme' );
	$columns['title']         = __( 'Название', 'er_theme' );
	$columns['description']   = __( 'Описание', 'er_theme' );
	$columns['banners_popup'] = __( 'Попап', 'er_theme' );
	$columns['banners_side']  = __( 'Сайдбар', 'er_theme' );
	$columns['banners_top']   = __( 'Хед', 'er_theme' );
	//$columns['banners_popout'] = __('Плашка','er_theme');
	$columns['date'] = __( 'Дата', 'er_theme' );
	
	return $columns;
}

function my_custom_columns_brokers( $column ) {
	global $post;
	if ( $column == 'banners_popup' ) {
		echo show_banners_id_wp_admin( $post->ID, 'popup' );
	} elseif ( $column == 'banners_side' ) {
		echo show_banners_id_wp_admin( $post->ID, 'sidebar' );
	} elseif ( $column == 'banners_top' ) {
		echo show_banners_id_wp_admin( $post->ID, 'top' );
	} elseif ( $column == 'banners_popout' ) {
		echo show_banners_id_wp_admin( $post->ID, 'popout' );
	} else {
		echo '';
	}
}

add_filter( "manage_edit-casino_columns", "my_page_columns_brokers" );
add_action( "manage_casino_posts_custom_column", "my_custom_columns_brokers" );

add_filter( 'manage_edit-banners_sortable_columns', 'my_sortable_banners_column' );
function my_sortable_banners_column( $columns ) {
	$columns['banner_type']  = 'type';
	$columns['banner_place'] = 'place';
	
	//To make a column 'un-sortable' remove it from the array
	//unset($columns['date']);
	
	return $columns;
}

add_action( 'pre_get_posts', 'my_slice_orderby' );
function my_slice_orderby( $query ) {
	if ( ! is_admin() ) {
		return;
	}
	
	$orderby = $query->get( 'orderby' );
	
	if ( 'type' == $orderby ) {
		$query->set( 'meta_key', 'banner_type' );
		$query->set( 'orderby', 'meta_value' );
		
	} elseif ( 'place' == $orderby ) {
		$query->set( 'meta_key', 'banner_place' );
		$query->set( 'orderby', 'meta_value' );
	}
}

function pine_banner_type_dropdown() {
	$scr = get_current_screen();
	if ( $scr->base == 'edit' && $scr->post_type == 'banners' ) {
		$selected  = filter_input( INPUT_GET, 'banner_type', FILTER_SANITIZE_STRING );
		$selected2 = filter_input( INPUT_GET, 'banner_place', FILTER_SANITIZE_STRING );
		$selected3 = filter_input( INPUT_GET, 'banner_targeting', FILTER_SANITIZE_STRING );
		
		$choices = [
			'image'       => __( 'Изображение', 'er_theme' ),
			'html'        => __( 'HTML', 'er_theme' ),
			'text_button' => __( 'Текст с кнопкой', 'er_theme' ),
		];
		
		$choices2 = [
			'popup'   => __( 'Попап', 'er_theme' ),
			'popout'  => __( 'Выезжающий', 'er_theme' ),
			'sidebar' => __( 'Сайдбар', 'er_theme' ),
			'top'     => __( 'Шапка', 'er_theme' ),
		];
		$choices3 = [
			'banner_tags'    => __( 'Метки', 'er_theme' ),
			'banner_posts'   => __( 'Посты', 'er_theme' ),
			'banner_default' => __( 'Дефолтный', 'er_theme' ),
		];
		
		echo '<select name="banner_type">';
		echo '<option value="all" ' . ( ( $selected == 'all' ) ? 'selected="selected"' : "" ) . '>' . __( 'Все типы', 'er_theme' ) . '</option>';
		foreach ( $choices as $key => $value ) {
			echo '<option value="' . $key . '" ' . ( ( $selected == $key ) ? 'selected="selected"' : "" ) . '>' . $value . '</option>';
		}
		echo '</select>';
		echo '<select name="banner_place">';
		echo '<option value="all" ' . ( ( $selected2 == 'all' ) ? 'selected="selected"' : "" ) . '>' . __( 'Все места', 'er_theme' ) . '</option>';
		foreach ( $choices2 as $key => $value ) {
			echo '<option value="' . $key . '" ' . ( ( $selected2 == $key ) ? 'selected="selected"' : "" ) . '>' . $value . '</option>';
		}
		echo '</select>';
		echo '<select name="banner_targeting">';
		echo '<option value="all" ' . ( ( $selected3 == 'all' ) ? 'selected="selected"' : "" ) . '>' . __( 'Любой таргетинг', 'er_theme' ) . '</option>';
		foreach ( $choices3 as $key => $value ) {
			echo '<option value="' . $key . '" ' . ( ( $selected3 == $key ) ? 'selected="selected"' : "" ) . '>' . $value . '</option>';
		}
		echo '</select>';
	}
}

add_action( 'restrict_manage_posts', 'pine_banner_type_dropdown' );

function pine_banner_type_filter( $query ) {
	if ( is_admin() && $query->is_main_query() ) {
		$scr = get_current_screen();
		if ( $scr->base !== 'edit' && $scr->post_type !== 'banners' ) {
			return;
		}
		
		if ( isset( $_GET['banner_type'] ) && $_GET['banner_type'] != 'all' ) {
			$query->set( 'meta_query', array(
				array(
					'key'   => 'banner_type',
					'value' => sanitize_text_field( $_GET['banner_type'] )
				)
			) );
		}
		if ( isset( $_GET['banner_place'] ) && $_GET['banner_place'] != 'all' ) {
			$query->set( 'meta_query', array(
				array(
					'key'   => 'banner_place',
					'value' => sanitize_text_field( $_GET['banner_place'] )
				)
			) );
		}
		if ( isset( $_GET['banner_targeting'] ) && $_GET['banner_targeting'] != 'all' ) {
			if ( $_GET['banner_targeting'] == 'banner_default' ) {
				$query->set( 'meta_query', array(
					array(
						'key'     => sanitize_text_field( $_GET['banner_targeting'] ),
						'value'   => 1,
						'compare' => '=',
					)
				) );
			} else {
				$query->set( 'meta_query', array(
					array(
						'key'     => sanitize_text_field( $_GET['banner_targeting'] ),
						'value'   => array( '' ),
						'compare' => 'NOT IN',
					)
				) );
			}
		}
		if ( isset( $_GET['banner_type'] ) && $_GET['banner_type'] != 'all' && isset( $_GET['banner_place'] ) && $_GET['banner_place'] != 'all' ) {
			$query->set( 'meta_query', array(
				array(
					'key'   => 'banner_type',
					'value' => sanitize_text_field( $_GET['banner_type'] )
				),
				array(
					'key'   => 'banner_place',
					'value' => sanitize_text_field( $_GET['banner_place'] )
				)
			
			) );
		}
		if ( isset( $_GET['banner_type'] ) && $_GET['banner_type'] != 'all' && isset( $_GET['banner_targeting'] ) && $_GET['banner_targeting'] != 'all' ) {
			if ( $_GET['banner_targeting'] == 'banner_default' ) {
				$query->set( 'meta_query', array(
					
					array(
						'key'     => sanitize_text_field( $_GET['banner_targeting'] ),
						'value'   => 1,
						'compare' => '=',
					),
					array(
						'key'   => 'banner_type',
						'value' => sanitize_text_field( $_GET['banner_type'] )
					)
				
				) );
			} else {
				$query->set( 'meta_query', array(
					
					array(
						'key'     => sanitize_text_field( $_GET['banner_targeting'] ),
						'value'   => array( '' ),
						'compare' => 'NOT IN',
					),
					array(
						'key'   => 'banner_type',
						'value' => sanitize_text_field( $_GET['banner_type'] )
					)
				
				) );
			}
		}
		if ( isset( $_GET['banner_place'] ) && $_GET['banner_place'] != 'all' && isset( $_GET['banner_targeting'] ) && $_GET['banner_targeting'] != 'all' ) {
			if ( $_GET['banner_targeting'] == 'banner_default' ) {
				$query->set( 'meta_query', array(
					
					array(
						'key'     => sanitize_text_field( $_GET['banner_targeting'] ),
						'value'   => 1,
						'compare' => '=',
					),
					array(
						'key'   => 'banner_place',
						'value' => sanitize_text_field( $_GET['banner_place'] )
					)
				
				) );
			} else {
				$query->set( 'meta_query', array(
					
					array(
						'key'     => sanitize_text_field( $_GET['banner_targeting'] ),
						'value'   => array( '' ),
						'compare' => 'NOT IN',
					),
					array(
						'key'   => 'banner_place',
						'value' => sanitize_text_field( $_GET['banner_place'] )
					)
				
				) );
			}
		}
		if ( isset( $_GET['banner_type'] ) && $_GET['banner_type'] != 'all' && isset( $_GET['banner_place'] ) && $_GET['banner_place'] != 'all' && isset( $_GET['banner_targeting'] ) && $_GET['banner_targeting'] != 'all' ) {
			if ( $_GET['banner_targeting'] == 'banner_default' ) {
				$query->set( 'meta_query', array(
					
					array(
						'key'     => sanitize_text_field( $_GET['banner_targeting'] ),
						'value'   => 1,
						'compare' => '=',
					),
					array(
						'key'   => 'banner_type',
						'value' => sanitize_text_field( $_GET['banner_type'] )
					),
					array(
						'key'   => 'banner_place',
						'value' => sanitize_text_field( $_GET['banner_place'] )
					)
				
				) );
			} else {
				$query->set( 'meta_query', array(
					
					array(
						'key'     => sanitize_text_field( $_GET['banner_targeting'] ),
						'value'   => array( '' ),
						'compare' => 'NOT IN',
					),
					array(
						'key'   => 'banner_type',
						'value' => sanitize_text_field( $_GET['banner_type'] )
					),
					array(
						'key'   => 'banner_place',
						'value' => sanitize_text_field( $_GET['banner_place'] )
					)
				
				) );
			}
		}
	}
}

add_action( 'pre_get_posts', 'pine_banner_type_filter' );

function show_banners_id_wp_admin( $post_id, $banner_place ) {
	$banners       = array();
	$reverse_query = get_posts( array(
		'post_type'      => 'banners',
		'posts_per_page' => - 1,
		'orderby'        => 'rand',
		'meta_query'     => array(
			'relation' => 'AND',
			array(
				'key'     => 'banner_posts',
				'value'   => serialize( strval( $post_id ) ),
				'compare' => 'LIKE'
			),
			array(
				'key'     => 'banner_default',
				'value'   => 1,
				'compare' => '!=',
			),
			array(
				'key'     => 'banner_place',
				'value'   => $banner_place,
				'compare' => '=',
			),
		)
	) );
	if ( ! empty( $reverse_query ) ) {
		foreach ( $reverse_query as $item ) {
			$banners[] = $item->ID;
		}
	}
	if ( empty( $reverse_query ) && $banner_place != 'popup' || $banner_place == 'popup' ) {
		$term_list = wp_get_post_terms( $post_id, 'affiliate-tags', array( 'fields' => 'ids' ) );
		
		if ( ! empty( $term_list ) ) {
			$by_tags = get_posts( array(
				'post_type'      => 'banners',
				'posts_per_page' => - 1,
				'orderby'        => 'title',
				'meta_query'     => array(
					'relation' => 'AND',
					array(
						'key'     => 'banner_place',
						'value'   => $banner_place,
						'compare' => '=',
					),
					array(
						'key'     => 'banner_default',
						'value'   => 1,
						'compare' => '!=',
					),
				),
				'tax_query'      => array(
					array(
						'taxonomy' => 'affiliate-tags',
						'field'    => 'id',
						'terms'    => $term_list,
					),
				),
			) );
			
			if ( ! empty( $by_tags ) ) {
				foreach ( $by_tags as $item ) {
					$banners[] = $item->ID;
				}
			}
		}
	}
	
	
	if ( ! empty( $banners ) ) {
		$x = 0;
		
		foreach ( $banners as $post_id ) {
			$x ++;
			$result .= '<div>';
			$result .= '<a href="https://eto-razvod.ru/wp-admin/post.php?post=' . $post_id . '&action=edit" target="_blank">';
			$result .= get_the_title( $post_id );
			$result .= '</a>';
			if ( $banner_place == 'popup' ) {
				$result .= ' (';
				$result .= get_field( 'banner_seconds', $post_id );
				$result .= ' sec )';
			}
			$banner_tags = get_field( 'banner_tags', $post_id );
			if ( ! empty( $banner_tags ) ) {
				$total  = count( $banner_tags );
				$result .= ' / ';
				$y      = 0;
				foreach ( $banner_tags as $item ) {
					$y ++;
					$term   = get_term_by( 'id', $item, 'affiliate-tags' )->slug;
					$result .= $term;
					if ( $y != $total ) {
						$result .= ', ';
					}
				}
			}
			$result .= '</div>';
		}
		
		
	} else {
		$result .= __( 'N/A', 'er_theme' );
	}
	
	if ( empty( $banners ) ) {
		$default = get_posts( array(
			'post_type'      => 'banners',
			'posts_per_page' => - 1,
			'orderby'        => 'rand',
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => 'banner_default',
					'value'   => 1,
					'compare' => '=',
				),
				array(
					'key'     => 'banner_place',
					'value'   => $banner_place,
					'compare' => '=',
				),
			),
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'id',
					'terms'    => $term_list,
				),
			)
		) );
		if ( ! empty( $default ) ) {
			foreach ( $default as $item ) {
				$banners[] = $item->ID;
				
			}
		}
	}
	return $result;
}

function new_contact_methods( $contactmethods ) {
	
	$contactmethods['user_activation'] = __( 'Активация', 'er_theme' );
	return $contactmethods;
	
}
add_filter( 'user_contactmethods', 'new_contact_methods', 10, 1 );

function new_modify_user_table( $column ) {
	
	$column['user_activation'] = __( 'Активация', 'er_theme' );
	return $column;
	
}
add_filter( 'manage_users_columns', 'new_modify_user_table' );

function new_modify_user_table_row( $val, $column_name, $user_id ) {
	switch ( $column_name ) {
		case 'user_activation' :
			if ( get_user_meta( $user_id, 'user_activation', true ) == 'yes' ) {
				$status = '<span class="act-admin" style="background: #0073aa;color: #FFF;padding: 5px;display: inline-block;line-height: 1.3;border-radius: 4px;">' . __( 'Активирован', 'er_theme' ) . '</span>';
			} else {
				$status = '';
			}
			
			return $status;
		default:
	}
	
	return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );


function new_contact_methods2( $contactmethods ) {
	
	$contactmethods['user_activation2'] = __( 'Баланс', 'er_theme' );
	return $contactmethods;
	
}
add_filter( 'user_contactmethods', 'new_contact_methods2', 10, 1 );

function new_modify_user_table2( $column ) {
	
	$column['user_activation2'] = __( 'Баланс', 'er_theme' );
	return $column;
	
}
add_filter( 'manage_users_columns', 'new_modify_user_table2' );

function new_modify_user_table_row2( $val, $column_name, $user_id ) {
	switch ( $column_name ) {
		case 'user_activation2' :
			if ( ( get_user_meta( $user_id, 'balance', true ) != '' ) || ( get_user_meta( $user_id, 'balance', true ) != 0 ) ) {
				$status = '<span class="act-admin" style="background: #0073aa;color: #FFF;padding: 5px;display: inline-block;line-height: 1.3;border-radius: 4px;">' . get_user_meta( $user_id, 'balance', true ) . ' <span class="rur" style="color: #FFF;font-size: 13px;">a</span></span>';
			} else {
				$status = '<span class="act-admin act-none" style="background: #0073aa;color: #FFF;padding: 5px;display: inline-block;line-height: 1.3;border-radius: 4px;">0 <span class="rur" style="color: #FFF;font-size: 13px;">a</span></span>';
			}
			
			return $status;
		default:
	}
	
	return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row2', 10, 3 );

add_action( 'wp_ajax_setlostpwnew', 'setlostpwnewfunc' );
add_action( 'wp_ajax_nopriv_setlostpwnew', 'setlostpwnewfunc' );
function setlostpwnewfunc() {
	
	$block_input_username = htmlspecialchars( $_POST["block_input_username"] );
	$block_input_psw1     = $_POST["block_input_psw1"];
	$block_input_psw2     = $_POST["block_input_psw2"];
	
	if ( $block_input_psw1 == $block_input_psw2 ) {
		$user = get_user_by( 'login', $block_input_username );
		wp_set_password( $block_input_psw1, $user->ID );
		
		wp_set_current_user( $user->ID );
		wp_set_auth_cookie( $user->ID );
		
		$result = array(
			'status'       => 'ok',
			'secondstatus' => __( 'Пароль был успешно установлен', 'er_theme' ),
		);
	} else {
		$result = array(
			'status'       => 'error',
			'secondstatus' => __( 'Введённые пароли не совпадают', 'er_theme' ),
		);
	}
	
	echo json_encode( $result );
	die;
	
}

add_action( 'wp_ajax_retrivemailnew', 'retrivemailnewfunc' );
add_action( 'wp_ajax_nopriv_retrivemailnew', 'retrivemailnewfunc' );
function retrivemailnewfunc() {
	global $wpdb;
	
	date_default_timezone_set( 'Europe/Moscow' );
	$retrivemail = $_POST["retrivemailnew"];
	
	if ( filter_var( $retrivemail, FILTER_VALIDATE_EMAIL ) ) {
		
		if ( email_exists( $retrivemail ) ) {
			
			$mydb     = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
			$user     = get_user_by( 'email', $retrivemail );
			$user2    = get_userdata( $user->ID );
			$mail_key = wp_generate_uuid4();
			
			$mydb->insert(
				'mails',
				array(
					'status'    => 'not_sent',
					'reg_date'  => $user2->data->user_registered,
					'user_id'   => $user2->data->ID,
					'mail_type' => 'reset_password',
					'mail_key'  => $mail_key,
					'sent'      => date( 'Y-m-d H:i:s' )
				),
				array( '%s', '%s', '%s', '%s', '%s', '%s' )
			);
			
			
			$user                  = get_user_by( 'email', $retrivemail );
			$user2                 = get_userdata( $user->ID );
			$userlogin             = $user2->data->user_login;
			$get_password_key      = get_password_reset_key( $user2 );
			$get_password_key_link = get_site_url() . '/forgot-password/?key=' . $get_password_key . '&login=' . $userlogin;
			$status                = 'ok';
			
			$headers = array(
				'From: ' . __( 'Это развод™', 'er_theme' ) . ' <check@eto-razvod.info>',
				'content-type: text/html',
			);
			$message = '';
			// $message .= "Вы запросили восстановление пароля для аккаунта: " . $get_password_key_link . " \r\n\r\n";
			$message .= __( 'Вы запросили восстановление пароля для аккаунта: %s', 'er_theme' ) . "\r\n\r\n";
			// $message .= 'Если Вы не запрашивали восстановление пароля - то не переходите по данной ссылке. <img src="https://eto-razvod.ru/engine/mail_update_status.php?key=' . $mail_key . '" style="width:1px; height:1px;" />';
			$message .= __( 'Если Вы не запрашивали восстановление пароля - то не переходите по этой ссылке.', 'er_theme' ) . ' <img src="https://eto-razvod.ru/engine/mail_update_status.php?key=' . $mail_key . '" style="width:1px; height:1px;" />';
			$subject = __( 'Восстановление пароля на сайте eto-razvod.ru', 'er_theme' );
			
			$mailResult = false;
			$mailResult = wp_mail( $retrivemail, $subject, $message, $headers );
			if ( $mailResult == 1 ) {
				$mail = $mydb->get_results( "select * from mails WHERE mail_key = '$mail_key'" );
				
				$mydb->update(
					'mails',
					array( 'status' => 'sent' ),
					array( 'id' => $mail[0]->id ),
					array( '%s' )
				);
				$mydb->update(
					'mails',
					array( 'updated' => date( 'Y-m-d H:i:s' ) ),
					array( 'id' => $mail[0]->id ),
					array( '%s' )
				);
				
			}
		} else {
			$status = 'notexist';
		}
		
	} else {
		$status = 'notemail';
	}
	
	
	$result = array(
		'check'  => $retrivemail,
		'status' => $status
	);
	echo json_encode( $result );
	die;
}

function seach_by_websites_brokers( $where ) {
	
	$where = str_replace( "meta_key = 'websites_$", "meta_key LIKE 'websites_%", $where );
	
	return $where;
}

add_filter( 'posts_where', 'seach_by_websites_brokers' );


add_filter( 'xmlrpc_enabled', '__return_false' );

remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.

add_action( 'wp_ajax_get_user_notify', 'get_user_notifyfunc' );
add_action( 'wp_ajax_nopriv_get_user_notify', 'get_user_notifyfunc' );

function get_user_notifyfunc() {
	$userid = intval( $_POST['userid'] );
	wp_new_user_notification( $userid, 'user' );
	die;
}

function remove_category_link( $content ) {
	$replace     = array( "category/" => "" );
	$new_content = strtr( $content, $replace );
	
	return $new_content;
}

add_filter( 'the_content', 'remove_category_link', 999 );


function devise_remove_schedule_delete() {
	remove_action( 'wp_scheduled_delete', 'wp_scheduled_delete' );
}

add_action( 'init', 'devise_remove_schedule_delete' );

remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );


/*add_action( 'admin_head-post.php', 'admin_head_post_editing' );
function admin_head_post_editing() {
	global $post;
	global $current_user;
	
	$arr_ids   = [ 19117 ];
	$arr_posts = [ 154423, 176628, 154370, 158574, 154109, 161919, 154370, 184280, 160119, 153444 ];
	
	if ( ( in_array( $current_user->data->ID, $arr_ids ) ) || ( in_array( 'author', $current_user->roles ) ) ) {
		//echo 'editing_2';
		if ( ( ( $post->post_status == 'publish' ) && ( get_field( 'company_type', $post->ID ) != 15604 ) && ( ! ( in_array( $post->ID, $arr_posts ) ) ) ) && ( $post->post_author != $current_user->data->ID ) ) {
			//echo 'editing_3';
			//print_r($post);
			echo '<- Вернитесь назад [0]';
			exit;
		}
		if ( ( $post->post_author != $current_user->data->ID ) && ( $post->post_type != 'casino' ) ) {
			//echo 'editing_3';
			//print_r($post);
			echo '<- Вернитесь назад [1]';
			exit;
		} elseif ( ( $post->post_type != 'casino' ) && ( $post->post_author != $current_user->data->ID ) ) {
			echo $post->post_author;
			echo $current_user->data->ID;
			//echo 'editing_3';
			//print_r($post);
			echo '<- Вернитесь назад [2]';
			exit;
		}
	}
	
}*/


function my_admin_head() {
	global $current_user;
	if ( $current_user->data->ID == 23375 ) {
		echo '<style>li#menu-media,li#menu-tools,li#menu-users,li#wp-admin-bar-user-info,li#wp-admin-bar-edit-profile,li#wp-admin-bar-trp_edit_translation, li#wp-admin-bar-imagify { display: none !important; }</style>';
	}
}

add_action( 'admin_head', 'my_admin_head' );

if ( ! function_exists( 'share_update_count' ) ) {
	add_action( 'wp_ajax_share_update_count', 'share_update_count' );
	add_action( 'wp_ajax_nopriv_share_update_count', 'share_update_count' );
	function share_update_count() {
		//print_r($_POST);
		$data           = $_POST;
		$item_count_get = 0;
		$item_count_get = get_field( 'social_shares_' . $data['social_id'], $data['post_id'] );
		$item_count_get ++;
		update_field( 'social_shares_' . $data['social_id'], $item_count_get, $data['post_id'] );
		echo $item_count_get;
		die;
	}
	
}

if ( ! function_exists( 'show_social_buttons' ) ) {
	function show_social_buttons( $post_id, $container_id = 'top' ) {
		$result = '';
		//$post_id = apply_filters( 'wpml_object_id', $post_id, 'post' );
		$post_link = get_the_permalink( $post_id );
		if ( function_exists( 'social_buttons_array' ) ) {
			$buttons = social_buttons_array();
			if ( ! empty( $buttons ) ) {
				$result .= '<div class="social_share_links" id="social_share_' . $container_id . '">';
				$result .= '<ul>';
				
				foreach ( $buttons as $item ) {
					$item_count = 0;
					
					if ( $item['id'] == 'pinterest' ) {
						$link = 'https://pinterest.com/pin/create/button/?url=' . $post_link;
					} elseif ( $item['id'] == 'email' ) {
						$link = 'mailto:?&subject=&cc=&bcc=&body=' . $post_link;
					} elseif ( $item['id'] == 'linkedin' ) {
						$link = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $post_link;
						
					} elseif ( $item['id'] == 'vkontakte' ) {
						$link = 'https://vk.com/share.php?url=' . $post_link;
					} elseif ( $item['id'] == 'odnoklassniki' ) {
						$link = 'https://connect.ok.ru/offer?url=' . $post_link;
					} elseif ( $item['id'] == 'telegram' ) {
						$link = 'https://telegram.me/share/url?url=' . $post_link;
					} elseif ( $item['id'] == 'viber' ) {
						$link = 'viber://forward?text=' . $post_link;
					} elseif ( $item['id'] == 'whatsapp' ) {
						$link = 'whatsapp://send?text=' . $post_link;
					} else {
						$link = $post_link;
					}
					
					
					/*elseif($item['id'] == 'facebook') {
	                $link = 'https://www.facebook.com/sharer/sharer.php?u='. $post_link;
                }
                    */
					$item_count_get = get_field( 'social_shares_' . $item['id'], $post_id );
					if ( $item_count_get && $item_count_get > 0 ) {
						$item_count = $item_count_get;
					}
					$result .= '<li class="social_item_icon_' . $item['id'] . '" data-social-id="' . $item['id'] . '" data-post-id="' . $post_id . '" data-link="' . $link . '">';
					
					if ( $item_count > 0 ) {
						$result .= '<span class="social_item_count">' . $item_count . '</span>';
					} else {
						$result .= '<span class="social_item_count social_item_count_empty"></span>';
					}
					$result .= '</li>';
				}
				$result .= '</ul>';
				$result .= '</div>';
			}
		}
		
		return $result;
	}
}


if ( ! function_exists( 'social_buttons_array' ) ) {
	function social_buttons_array() {
		$buttons   = array();
		$buttons[] = array(
			'name' => __( 'Vkontakte', 'savart' ),
			'id'   => 'vkontakte',
		);
		$buttons[] = array(
			'name' => __( 'Linkedin', 'savart' ),
			'id'   => 'linkedin',
		);
		$lang = get_locale();
		if ($lang != 'ru_RU') {
			$buttons[] = array(
				'name' => __( 'Facebook', 'savart' ),
				'id'   => 'facebook',
			);
		}
		
		$buttons[] = array(
			'name' => __( 'Odnoklassniki', 'savart' ),
			'id'   => 'odnoklassniki',
		);
		$buttons[] = array(
			'name' => __( 'Pinterest', 'savart' ),
			'id'   => 'pinterest',
		);
		$buttons[] = array(
			'name' => __( 'Whatsapp', 'savart' ),
			'id'   => 'whatsapp',
		);
		$buttons[] = array(
			'name' => __( 'Viber', 'savart' ),
			'id'   => 'viber',
		);
		$buttons[] = array(
			'name' => __( 'Telegram', 'savart' ),
			'id'   => 'telegram',
		);
		$buttons[] = array(
			'name' => __( 'E-mail', 'savart' ),
			'id'   => 'email',
		);
		
		return $buttons;
	}
}

// Add to admin_init function
add_filter( "manage_edit-affiliate-tags_columns", 'theme_columns' );

function theme_columns( $theme_columns ) {
	$new_columns = array(
		'cb'          => '<input type="checkbox" />',
		'name'        => __( 'Name' ),
		'header_icon' => __( 'Название метки', 'er_theme' ),
		'id'          => __( 'ID' ),
//      'description' => __('Description'),
		'slug'        => __( 'Slug' ),
		'posts'       => __( 'Posts' )
	);
	
	return $new_columns;
}

add_filter( "manage_affiliate-tags_custom_column", 'manage_theme_columns', 10, 3 );

function manage_theme_columns( $out, $column_name, $theme_id ) {
	$theme = get_term( $theme_id, 'affiliate-tags' );
	switch ( $column_name ) {
		case 'header_icon':
			// get header image url
			$data = maybe_unserialize( $theme->description );
			$out  .= __( 'Метка:', 'er_theme' ) . ' ' . get_field( 'tag_human_title', 'term_' . $theme_id );
			break;
		
		case 'id':
			$out .= $theme_id;
			break;
		
		default:
			break;
	}
	
	return $out;
}

function get_year_shortcode( $atts ) {
	$year = date( "Y" );
	
	return $year;
}

add_shortcode( 'year', 'get_year_shortcode' );

add_filter( 'the_title', 'add_shortcode_to_title' );

function add_shortcode_to_title( $title ) {
	return do_shortcode( $title );
}

add_filter( 'trp_no_translate_selectors', 'trpc_no_stranslate_selectors', 10, 2 );
function trpc_no_stranslate_selectors( $selectors_array, $language ) {
	$selectors_array[] = '.do_not_translate_css_class';
	$selectors_array[] = '#do_not_translate_css_id';
	
	return $selectors_array;
}

/*$parametri = array( 'dikobraz@ya.ru', 'Успешное обновление ', 'Тест сообщение' );

if ( ! wp_next_scheduled( 'turn_off_post', $parametri ) ) {
	wp_schedule_event( time(), 'hourly', 'turn_off_post', $parametri );
}

add_action( 'turn_off_post', 'turn_off_post_func', 10, 3 );

function turn_off_post_func( $to, $subject, $msg ) {

}*/

function wpse_allowedtags() {
	// Add custom tags to this string
	return '<a>';
}

if ( ! function_exists( 'wpse_custom_wp_trim_excerpt' ) ) :
	
	function wpse_custom_wp_trim_excerpt( $wpse_excerpt ) {
		$raw_excerpt = $wpse_excerpt;
		if ( '' == $wpse_excerpt ) {
			
			$wpse_excerpt = get_the_content( '' );
			$wpse_excerpt = strip_shortcodes( $wpse_excerpt );
			$wpse_excerpt = apply_filters( 'the_content', $wpse_excerpt );
			$wpse_excerpt = str_replace( ']]>', ']]&gt;', $wpse_excerpt );
			$wpse_excerpt = strip_tags( $wpse_excerpt, wpse_allowedtags() ); /*IF you need to allow just certain tags. Delete if all tags are allowed */
			
			//Set the excerpt word count and only break after sentence is complete.
			$excerpt_word_count = 75;
			$excerpt_length     = apply_filters( 'excerpt_length', $excerpt_word_count );
			$tokens             = array();
			$excerptOutput      = '';
			$count              = 0;
			
			// Divide the string into tokens; HTML tags, or words, followed by any whitespace
			preg_match_all( '/(<[^>]+>|[^<>\s]+)\s*/u', $wpse_excerpt, $tokens );
			
			foreach ( $tokens[0] as $token ) {
				
				if ( $count >= $excerpt_length && preg_match( '/[\,\;\?\.\!]\s*$/uS', $token ) ) {
					// Limit reached, continue until , ; ? . or ! occur at the end
					$excerptOutput .= trim( $token );
					break;
				}
				
				// Add words to complete sentence
				$count ++;
				
				// Append what's left of the token
				$excerptOutput .= $token;
			}
			
			$wpse_excerpt      = trim( force_balance_tags( $excerptOutput ) );
			$wpse_excerpt_last = substr( $wpse_excerpt, - 1 );
			if ( in_array( $wpse_excerpt_last, array( ',', '!', '?', '...', '.', ':', ';' ) ) ) {
				$wpse_excerpt = substr( $wpse_excerpt, 0, - 1 );
			}
			$excerpt_end  = '...';
			$excerpt_more = apply_filters( 'excerpt_more', $excerpt_end );
			
			//$pos = strrpos($wpse_excerpt, '</');
			//if ($pos !== false)
			// Inside last HTML tag
			//$wpse_excerpt = substr_replace($wpse_excerpt, $excerpt_end, $pos, 0); /* Add read more next to last word */
			//else
			// After the content
			$wpse_excerpt .= $excerpt_more; /*Add read more in new paragraph */
			
			return $wpse_excerpt;
			
		}
		
		return apply_filters( 'wpse_custom_wp_trim_excerpt', $wpse_excerpt, $raw_excerpt );
	}

endif;

remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
add_filter( 'get_the_excerpt', 'wpse_custom_wp_trim_excerpt' );

function exclude_en( $query ) {
	if ( ! $query->is_main_query() && ! $query->is_admin ) {
		if ( ! empty( $query->query_vars['post_type'] ) && in_array(
				$query->query_vars['post_type'], array( 'post', 'page', 'casino' ) ) ) {
			$current_language = get_locale();
			if ( $current_language != 'ru_RU' ) {
				
				global $global_tp_posts_in;
				
				$query->set( 'post__in', $global_tp_posts_in );
				
				/*
                $meta_query[] = array(
                    'key' => 'enable_translations',
                    'value' => $current_language,
                    'compare' => 'LIKE',
                );
                $query->set('meta_query', $meta_query);*/
			}
		}
		
		
	} elseif ( $query->is_admin ) {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			if ( ! empty( $query->query_vars['post_type'] ) && in_array(
					$query->query_vars['post_type'], array( 'post', 'page', 'casino' ) ) ) {
				$current_language = get_locale();
				if ( $current_language != 'ru_RU' ) {
					global $global_tp_posts_in;
					
					$query->set( 'post__in', $global_tp_posts_in );
				}
			}
		}
	} elseif ( $query->is_archive ) {
		$current_language = get_locale();
		if ( $current_language != 'ru_RU' ) {
			$meta_query = array(
				'relation' => 'AND',
				array(
					'key'     => 'enable_translations',
					'value'   => $current_language,
					'compare' => 'LIKE'
				),
			);
			$query->set( 'meta_query', $meta_query );
		}
		
	}
	
}
add_action( 'pre_get_posts', 'exclude_en' );


function set_global_tp_posts_in() {
	global $global_tp_posts_in;
	$global_tp_posts_in = array();
	$current_language   = get_locale();
	if ( $current_language != 'ru_RU' ) {
		$posts_in_language_args = array(
			'post_type'      => array( 'post', 'page', 'casino', 'promocodes', 'promocodes_cats' ),
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => 'enable_translations',
					'value'   => $current_language,
					'compare' => 'LIKE'
				)
			)
		
		);
		$posts_in_language      = new WP_Query( $posts_in_language_args );
		wp_reset_postdata();
		$global_tp_posts_in = wp_list_pluck( $posts_in_language->posts, 'ID' );
	}
	
}
add_action( 'after_setup_theme', 'set_global_tp_posts_in' );


// Отфильтровываем записи с включенным чекбоксом "Отключить обзор на русском языке"
add_filter( 'posts_clauses', 'er_posts_filter', 10, 2 );
function er_posts_filter( $clauses, $query ){

	if ( is_admin() && ! wp_doing_ajax() ) {
		return $clauses;
	}
	
	$current_language = get_locale();
	if ( $current_language == 'ru_RU' and ( ( $query->is_main_query() and 'blog' === $query->get( 'category_name' ) ) or ( 1 === $query->get( 'turn_off_on_ru_language' ) ) ) ) {
		
		$clauses['where'] .= " AND wp_posts.ID NOT IN ( SELECT post_id FROM wp_postmeta WHERE meta_key='turn_off_on_ru_language' AND meta_value = 'yes' ) ";
		
	}
	
	if ( ( '' !== $query->get( 'redirect_on_language' ) ) ) {
		
		$case = ( $query->get( 'redirect_on_language' ) == 'any' ) ? "meta_value <> 'no'" : "meta_value = '" . stripslashes( $query->get( 'redirect_on_language' ) ) . "'";
		
		$clauses['where'] .= " AND wp_posts.ID NOT IN ( SELECT post_id FROM wp_postmeta WHERE meta_key='redirect_on_language' AND " . $case . " ) ";
		
	}
	
	if ( ( 1 === $query->get( 'posts_hide_from_news' ) ) ) {
		
		$clauses['where'] .= " AND wp_posts.ID NOT IN ( SELECT post_id FROM wp_postmeta WHERE meta_key='hide_from_news' AND meta_value = '1' ) ";
		
	}

	return $clauses;
}




// Отфильтровываем таксономии с включенным чекбоксом "Отключить обзор на русском языке"
add_filter( 'terms_clauses', 'er_tag_hide_on_ru_language_filter', 10, 3 );
function er_tag_hide_on_ru_language_filter( $clauses, $taxonomies, $args ){
	
	if ( isset( $args['tag_hide_on_ru_language'] ) and  1 === $args['tag_hide_on_ru_language'] ) {
		
		$clauses['where'] .= " AND t.term_id NOT IN ( SELECT term_id FROM wp_termmeta WHERE meta_key='tag_hide_on_ru_language' AND meta_value = 'yes' ) ";
		
	}
	
	return $clauses;
}




/*add_action( 'edit_comment', 'add_update_comment_meta' );
function add_update_comment_meta( $comment_id ){
	$test = get_field('review_title','comment_'.$comment_id);

	$test = $test.'222';

	update_field('review_title',$test,'comment_'.$comment_id);
}


add_action('transition_comment_status', 'my_approve_comment_callback', 10, 3);
function my_approve_comment_callback($new_status, $old_status, $comment) {
	if($old_status != $new_status) {
		if($new_status == 'approved') {
			$test = get_field('review_title',$comment);

			$test = $test.'222';

			update_field('review_title',$test,$comment);
		}
	}
}*/

remove_action( 'wp_head', 'wp_generator' );

function get_crypto_buying() {
	
	// $link = '<div class="topreview cta_full"><a class="cta" href="https://eto-razvod.ru/visit/binance-coin-buy/" target="_blank" rel="noopener">Купить ' . get_field( 'company_name', get_the_ID() ) . ' на Binance</a></div>';
	$link = '<div class="topreview cta_full"><a class="cta" href="https://eto-razvod.ru/visit/binance-coin-buy/" target="_blank" rel="noopener">' . wp_sprintf( __( 'Купить %s на Binance', 'er_theme' ), get_field( 'company_name', get_the_ID() ) ) . '</a></div>';
	return $link; // никаких echo, только return
	
}
add_shortcode( 'cryptobuy', 'get_crypto_buying' );

function set_shortcode_en_us() {
	$set_shortcode_en_us = '<p style="text-align: center;">
	<strong>Please keep yourself informed about news and complaints. We copy the most valuable information to social networks, so please sign up!</strong>
	</p>

	<div class="socialmedia-buttons smw_center">
	<a href="https://www.facebook.com/groups/1075688842518024/" target="_blank" rel="nofollow noopener noreferrer">
	<img class="bounce" src="/wp-content/themes/eto-razvod-1/img/social/facebook-logo.png" alt="" width="64" height="64" />
	</a>
	<a href="https://twitter.com/Revieweek" target="_blank" rel="nofollow noopener noreferrer">
	<img class="bounce" src="/wp-content/themes/eto-razvod-1/img/social/twitter-logo.png" alt="" width="64" height="64" />
	</a>
	<a href="https://www.linkedin.com/in/ameli-ross" target="_blank" rel="nofollow noopener noreferrer">
	<img class="bounce" src="/wp-content/themes/eto-razvod-1/img/social/linkedin-logo.png" alt="" width="64" height="64" />
	</a>
	</div>';
	
	return $set_shortcode_en_us;
}

if ( ! function_exists( 'replace_ap_fb_rev_link' ) ) {
	function replace_ap_fb_rev_link( $text ) {
		$current_language = get_locale();
		if ( $current_language == 'en_US' ) {
			$text = str_replace( 'eto-razvod.ru', 'revieweek.com', $text );
			$text = str_replace( 'Это развод', 'Revieweek', $text );
			$text = str_replace( '[sc name="social"][/sc]', set_shortcode_en_us(), $text );
			$text = str_replace( '[sc name="social"]', set_shortcode_en_us(), $text );
			$text = str_replace( '[/sc]', set_shortcode_en_us(), $text );
		} elseif ( $current_language == 'fr_FR' ) {
			$text = str_replace( 'eto-razvod.ru', 'revieweek.fr', $text );
			$text = str_replace( 'Это развод', 'Revieweek', $text );
			$text = str_replace( '[sc name="social"][/sc]', '', $text );
			$text = str_replace( '[sc name="social"]', '', $text );
			$text = str_replace( '[/sc]', '', $text );
		} elseif ( $current_language == 'de_DE' ) {
			$text = str_replace( 'eto-razvod.ru', 'revieweek.de', $text );
			$text = str_replace( 'Это развод', 'Revieweek', $text );
			$text = str_replace( '[sc name="social"][/sc]', '', $text );
			$text = str_replace( '[sc name="social"]', '', $text );
			$text = str_replace( '[/sc]', '', $text );
		} elseif ( $current_language == 'es_ES' ) {
			$text = str_replace( 'eto-razvod.ru', 'revieweek.es', $text );
			$text = str_replace( 'Это развод', 'Revieweek', $text );
			$text = str_replace( '[sc name="social"][/sc]', '', $text );
			$text = str_replace( '[sc name="social"]', '', $text );
			$text = str_replace( '[/sc]', '', $text );
		} elseif ( $current_language == 'pl_PL' ) {
			$text = str_replace( 'eto-razvod.ru', 'pl.revieweek.com', $text );
			$text = str_replace( 'Это развод', 'Revieweek', $text );
			$text = str_replace( '[sc name="social"][/sc]', '', $text );
			$text = str_replace( '[sc name="social"]', '', $text );
			$text = str_replace( '[/sc]', '', $text );
		}
		
		return $text;
	}
	
	add_filter( 'the_content', 'replace_ap_fb_rev_link' );
}

add_action('admin_head', 'hidesaq');

function hidesaq() {
	echo '<style>
    .notice.notice-error.is-dismissible {
    display: none;
}
  </style>';
}

add_filter( 'the_posts', function( $posts, WP_Query $query ) {
	if ( $pick = $query->get( '_shuffle_and_pick' ) ) {
		shuffle( $posts );
		$posts = array_slice( $posts, 0, (int) $pick );
	}
	
	return $posts;
}, 10, 2 );

/**
 * Add Disallow for some file types.
 * Add "Disallow: /wp-login.php/\n".
 * Remove "Allow: /wp-admin/admin-ajax.php\n".
 * Calculate and add a "Sitemap:" link.
 */
// add_filter( 'robots_txt', function( $output, $public ) {
// 	/**
// 	 * If "Search engine visibility" is disabled,
// 	 * strongly tell all robots to go away.
// 	 */
// 	if ( '0' == $public ) {

// 		$output = "User-agent: *\nDisallow: /\nDisallow: /*\nDisallow: /*?\n";

// 	} else {

// 		/**
// 		 * Get site path.
// 		 */
// 		$site_url = parse_url( site_url() );
// 		$path     = ( ! empty( $site_url['path'] ) ) ? $site_url['path'] : '';

// 		/**
// 		 * Add new disallow.
// 		 */
// 		$output .= "Disallow: $path/wp-login.php\n";

// 		/**
// 		 * Disallow some file types
// 		 */
// 		foreach ( [ 'jpeg', 'jpg', 'gif', 'png', 'mp4', 'webm', 'woff', 'woff2', 'ttf', 'eot' ] as $ext ) {
// 			$output .= "Disallow: /*.{$ext}$\n";
// 		}

// 		/**
// 		 * Remove line that allows robots to access AJAX interface.
// 		 */
// 		$robots = preg_replace( '/Allow: [^\0\s]*\/wp-admin\/admin-ajax\.php\n/', '', $output );

// 		/**
// 		 * If no error occurred, replace $output with modified value.
// 		 */
// 		if ( null !== $robots ) {
// 			$output = $robots;
// 		}
// 		/**
// 		 * Calculate and add a "Sitemap:" link.
// 		 * Modify as needed.
// 		 */
// 		$output .= "Sitemap: {$site_url[ 'scheme' ]}://{$site_url[ 'host' ]}/sitemap_index.xml\n";
// 	}

// 	return $output;

// }, 99, 2 );


function firstCharToLowercase( $value ) {
	$firstChar  = mb_substr( $value, 0, 1 );
	$firstChar  = mb_strtolower( $firstChar );
	$otherChars = mb_substr(
		$value,
		1,
		mb_strlen( $value )
	);
	
	return $firstChar . $otherChars;
}

add_action( 'wp_ajax_check_cookie_accept_popup_multilanguge', 'check_cookie_accept_popup_multilanguge' );
add_action( 'wp_ajax_nopriv_check_cookie_accept_popup_multilanguge', 'check_cookie_accept_popup_multilanguge' );


function check_cookie_accept_popup_multilanguge() {
	$cookie_id = $_POST['cookie_id'];
	if ( isset( $_COOKIE[ $cookie_id ] ) ) {
		$result = 'yes';
	} else {
		$result = '000';
	}
	echo $result;
	die;
}

add_action( 'wp_ajax_set_cookie_accept_popup_multilanguage', 'set_cookie_accept_popup_multilanguage' );
add_action( 'wp_ajax_nopriv_set_cookie_accept_popup_multilanguage', 'set_cookie_accept_popup_multilanguage' );


function set_cookie_accept_popup_multilanguage() {
	
	$cookie_id   = $_POST['cookie_id'];
	$cookie_time = $_POST['cookie_time'];
	echo $cookie_id;
	$visit_time = date( 'F j, Y  g:i a' );
	
	if ( ! isset( $_COOKIE[ $cookie_id ] ) ) {
		
		// set a cookie for 1 year
		setcookie( $cookie_id, $visit_time, time() + $cookie_time, '/' );
		
	}
	die;
}


/*add_action( 'edit_comment', 'add_update_comment_meta' );
function add_update_comment_meta( $comment_id ) {*/
/*$test = get_field('test_id','comment_'.$comment_id);

$test = $test.'222';

update_field('test_id',$test,'comment_'.$comment_id);*/
/*}*/

add_action( 'edit_comment',
	function( $comment_ID )
	{
		$comment = get_comment($comment_ID);
		//Отзыв прошел модерацию, статус «Одобрен к публикации»
		if (get_field('temp_status',$comment) != get_field('status_comment',$comment)) {
			if (get_field('status_comment',$comment) == 'normal') {
				
				// $current_language = get_locale();
				// if ( $current_language == 'ru_RU' ) {
				// 	$text_a_user = 'Анонимный пользователь';
				// } elseif ( $current_language == 'fr_FR' ) {
				// 	$text_a_user = 'Utilisateur anonyme';
				// } elseif ( $current_language == 'es_ES' ) {
				// 	$text_a_user = 'Usuario anónimo';
				// } elseif ( $current_language == 'de_DE' ) {
				// 	$text_a_user = 'Anonymer Nutzer';
				// } elseif ( $current_language == 'pl_PL' ) {
				// 	$text_a_user = 'Użytkownik anonimowy';
				// } else {
				// 	$text_a_user = 'Anonymous user';
				// }
				
				$text_a_user = __( 'Анонимный пользователь', 'er_theme' );
				
				$get_comment = $comment;
				$user_comment_author = $get_comment->user_id;
				$cyr = [];
				$lat = [];
				$comment_author = get_userdata( $get_comment->user_id );
				if ( $comment_author->first_name && ! $comment_author->last_name ) {
					$aa = $comment_author->first_name;
				} elseif ( ! $comment_author->first_name && $comment_author->last_name ) {
					$aa = $comment_author->last_name;
				} elseif ( $comment_author->first_name && $comment_author->last_name ) {
					$aa = $comment_author->first_name . ' ' . $comment_author->last_name;
				} elseif ( $comment_author->user_nicename ) {
					$aa = $comment_author->user_nicename;
				} else {
					$aa = $text_a_user;
				}
				if (get_field('review_title',$get_comment)) {
					$review_title = get_field('review_title',$get_comment);
				} else {
					$review_title = wp_trim_words($get_comment->comment_content, 7,'');
				}
// 				$content_balance = 'Здравствуйте, '.$aa.'!<br>

// Ваш отзыв <a href="'.get_permalink($get_comment->comment_post_ID).'comment-'.$get_comment->comment_ID.'/">'.$review_title.'</a> был опубликован на сайте со статусом «Одобрен к публикации». Ваш отзыв участвует в рейтинге компании.
// <br><br>
// Следите за ответом компании и комментариями пользователей к вашему отзыву любым удобным способом – через личный кабинет, почту или на сайте в карточке компании.
// <br><br>
// Чтобы получить статус «Достоверный», добавьте к отзыву фото доказательств пользования услугами компании. Это могут быть фото или скриншоты договора с компанией, чека оплаты услуги, чека, подтверждающего перевод денег онлайн, других документов, подтверждающих ваше взаимодействие с компанией.
// <br><br>
// После исправления ваш отзыв автоматически отправится на повторную проверку модераторами.
// <br><br>
// Правила пользования сервисом <a href="https://eto-razvod.ru/rules/">https://eto-razvod.ru/rules/</a>.<br><br>

// С уважением, <br>
// Администрация сайта <br>
// ';
				
				$content_balance = wp_sprintf( __( 'Здравствуйте, %s!<br>

Ваш отзыв %s был опубликован на сайте со статусом «Одобрен к публикации». Ваш отзыв участвует в рейтинге компании.
<br><br>
Следите за ответом компании и комментариями пользователей к вашему отзыву любым удобным способом – через личный кабинет, почту или на сайте в карточке компании.
<br><br>
Чтобы получить статус «Достоверный», добавьте к отзыву фото доказательств пользования услугами компании. Это могут быть фото или скриншоты договора с компанией, чека оплаты услуги, чека, подтверждающего перевод денег онлайн, других документов, подтверждающих ваше взаимодействие с компанией.
<br><br>
После исправления ваш отзыв автоматически отправится на повторную проверку модераторами.
<br><br>
Правила пользования сервисом <a href="https://eto-razvod.ru/rules/">https://eto-razvod.ru/rules/</a>.<br><br>

С уважением, <br>
Администрация сайта <br>
', 'er_theme' ), $aa, '<a href="'.get_permalink($get_comment->comment_post_ID).'comment-'.$get_comment->comment_ID.'/">'.$review_title.'</a>' );
				
				if (get_post_type($get_comment->comment_post_ID) == 'casino' && intval($get_comment->comment_parent) == 0) {
					if ( $user_comment_author != 0 ) {
						notify_user_action( 'system_comment_is_normal', $user_comment_author, __( 'Отзыв прошел модерацию, статус «Одобрен к публикации»', 'er_theme' ), $content_balance );
					}
					
					$headers    = array( 'Content-Type: text/html; charset=UTF-8' );
					
					if (mb_strlen($get_comment->comment_author_email) > 0 && is_email( $get_comment->comment_author_email ) && mb_strpos($get_comment->comment_author_email, 'eto.ru') === false) {
						wp_mail( $get_comment->comment_author_email, __( 'Отзыв прошел модерацию, статус «Одобрен к публикации»', 'er_theme' ), $content_balance, $headers );
					}
				}
			}
		}
		
		//Отзыв прошел модерацию, статус «Достоверный»
		if (get_field('temp_status',$comment) != get_field('status_comment',$comment)) {
			if (get_field('status_comment',$comment) == 'good') {
				
				// $current_language = get_locale();
				// if ( $current_language == 'ru_RU' ) {
				// 	$text_a_user = 'Анонимный пользователь';
				// } elseif ( $current_language == 'fr_FR' ) {
				// 	$text_a_user = 'Utilisateur anonyme';
				// } elseif ( $current_language == 'es_ES' ) {
				// 	$text_a_user = 'Usuario anónimo';
				// } elseif ( $current_language == 'de_DE' ) {
				// 	$text_a_user = 'Anonymer Nutzer';
				// } elseif ( $current_language == 'pl_PL' ) {
				// 	$text_a_user = 'Użytkownik anonimowy';
				// } else {
				// 	$text_a_user = 'Anonymous user';
				// }
				
				$text_a_user = __( 'Анонимный пользователь', 'er_theme' );
				
				$get_comment = $comment;
				$user_comment_author = $get_comment->user_id;
				$cyr = [];
				$lat = [];
				$comment_author = get_userdata( $get_comment->user_id );
				if ( $comment_author->first_name && ! $comment_author->last_name ) {
					$aa = $comment_author->first_name;
				} elseif ( ! $comment_author->first_name && $comment_author->last_name ) {
					$aa = $comment_author->last_name;
				} elseif ( $comment_author->first_name && $comment_author->last_name ) {
					$aa = $comment_author->first_name . ' ' . $comment_author->last_name;
				} elseif ( $comment_author->user_nicename ) {
					$aa = $comment_author->user_nicename;
				} else {
					$aa = $text_a_user;
				}
				if (get_field('review_title',$get_comment)) {
					$review_title = get_field('review_title',$get_comment);
				} else {
					$review_title = wp_trim_words($get_comment->comment_content, 7,'');
				}

// 				$content_balance = 'Здравствуйте, '.$aa.'!<br>

// Ваш отзыв <a href="'.get_permalink($get_comment->comment_post_ID).'comment-'.$get_comment->comment_ID.'/">'.$review_title.'</a> был опубликован на сайте со статусом «Достоверный». Ваш отзыв участвует в рейтинге компании.
// <br><br>
// Следите за ответом компании и комментариями пользователей к вашему отзыву любым удобным способом – через личный кабинет, почту или на сайте в карточке компании.
// <br><br>
// Правила пользования сервисом <a href="https://eto-razvod.ru/rules/">https://eto-razvod.ru/rules/</a>.<br><br>

// С уважением, <br>
// Администрация сайта <br>
// ';
				
				$content_balance = wp_sprintf( __( 'Здравствуйте, %s!<br>

Ваш отзыв %s был опубликован на сайте со статусом «Достоверный». Ваш отзыв участвует в рейтинге компании.
<br><br>
Следите за ответом компании и комментариями пользователей к вашему отзыву любым удобным способом – через личный кабинет, почту или на сайте в карточке компании.
<br><br>
Правила пользования сервисом <a href="https://eto-razvod.ru/rules/">https://eto-razvod.ru/rules/</a>.<br><br>

С уважением, <br>
Администрация сайта <br>
', 'er_theme' ), $aa, '<a href="'.get_permalink($get_comment->comment_post_ID).'comment-'.$get_comment->comment_ID.'/">'.$review_title.'</a>' );
				
				if (get_post_type($get_comment->comment_post_ID) == 'casino' && intval($get_comment->comment_parent) == 0) {
					if ( $user_comment_author != 0 ) {
						notify_user_action( 'system_comment_is_good', $user_comment_author, __( 'Отзыв прошел модерацию, статус «Достоверный»', 'er_theme' ), $content_balance );
					}
					
					$headers    = array( 'Content-Type: text/html; charset=UTF-8' );
					
					if (mb_strlen($get_comment->comment_author_email) > 0 && is_email( $get_comment->comment_author_email ) && mb_strpos($get_comment->comment_author_email, 'eto.ru') === false) {
						wp_mail( $get_comment->comment_author_email, __( 'Отзыв прошел модерацию, статус «Достоверный»', 'er_theme' ), $content_balance, $headers );
					}
				}
			}
		}
		
		//Отзыв прошел модерацию, статус «Недостоверный»
		if (get_field('temp_status',$comment) != get_field('status_comment',$comment)) {
			if (get_field('status_comment',$comment) == 'bad') {
				
				// $current_language = get_locale();
				// if ( $current_language == 'ru_RU' ) {
				// 	$text_a_user = 'Анонимный пользователь';
				// } elseif ( $current_language == 'fr_FR' ) {
				// 	$text_a_user = 'Utilisateur anonyme';
				// } elseif ( $current_language == 'es_ES' ) {
				// 	$text_a_user = 'Usuario anónimo';
				// } elseif ( $current_language == 'de_DE' ) {
				// 	$text_a_user = 'Anonymer Nutzer';
				// } elseif ( $current_language == 'pl_PL' ) {
				// 	$text_a_user = 'Użytkownik anonimowy';
				// } else {
				// 	$text_a_user = 'Anonymous user';
				// }
				
				$text_a_user = __( 'Анонимный пользователь', 'er_theme' );
				
				$get_comment = $comment;
				$user_comment_author = $get_comment->user_id;
				$cyr = [];
				$lat = [];
				$comment_author = get_userdata( $get_comment->user_id );
				if ( $comment_author->first_name && ! $comment_author->last_name ) {
					$aa = $comment_author->first_name;
				} elseif ( ! $comment_author->first_name && $comment_author->last_name ) {
					$aa = $comment_author->last_name;
				} elseif ( $comment_author->first_name && $comment_author->last_name ) {
					$aa = $comment_author->first_name . ' ' . $comment_author->last_name;
				} elseif ( $comment_author->user_nicename ) {
					$aa = $comment_author->user_nicename;
				} else {
					$aa = $text_a_user;
				}
				if (get_field('review_title',$get_comment)) {
					$review_title = get_field('review_title',$get_comment);
				} else {
					$review_title = wp_trim_words($get_comment->comment_content, 7,'');
				}

// 				$content_balance = 'Здравствуйте, '.$aa.'!<br>

// Ваш отзыв <a href="'.get_permalink($get_comment->comment_post_ID).'comment-'.$get_comment->comment_ID.'/">'.$review_title.'</a> был опубликован на сайте со статусом «Недостоверный». Ваш отзыв не участвует в рейтинге компании.
// <br><br>
// Следите за ответом компании и комментариями пользователей к вашему отзыву любым удобным способом – через личный кабинет, почту или на сайте в карточке компании.
// <br><br>
// Чтобы получить статус «Одобрен к публикации», добавьте к отзыву больше текста и подробной  информации о пользовании услугами компании. Чтобы получить статус «Достоверный», добавьте к отзыву фото доказательств пользования услугами компании.
// <br><br>
// Это могут быть фото или скриншоты договора с компанией, чека оплаты услуги, чека, подтверждающего перевод денег онлайн, других документов, подтверждающих ваше взаимодействие с компанией.
// <br><br>
// После исправления ваш отзыв автоматически отправится на повторную проверку модераторами.
// <br><br>
// Правила пользования сервисом <a href="https://eto-razvod.ru/rules/">https://eto-razvod.ru/rules/</a>.<br><br>

// С уважением, <br>
// Администрация сайта <br>
// ';
				
				$content_balance = wp_sprintf( __( 'Здравствуйте, %s!<br>

Ваш отзыв %s был опубликован на сайте со статусом «Недостоверный». Ваш отзыв не участвует в рейтинге компании.
<br><br>
Следите за ответом компании и комментариями пользователей к вашему отзыву любым удобным способом – через личный кабинет, почту или на сайте в карточке компании.
<br><br>
Чтобы получить статус «Одобрен к публикации», добавьте к отзыву больше текста и подробной  информации о пользовании услугами компании. Чтобы получить статус «Достоверный», добавьте к отзыву фото доказательств пользования услугами компании.
<br><br>
Это могут быть фото или скриншоты договора с компанией, чека оплаты услуги, чека, подтверждающего перевод денег онлайн, других документов, подтверждающих ваше взаимодействие с компанией.
<br><br>
После исправления ваш отзыв автоматически отправится на повторную проверку модераторами.
<br><br>
Правила пользования сервисом <a href="https://eto-razvod.ru/rules/">https://eto-razvod.ru/rules/</a>.<br><br>

С уважением, <br>
Администрация сайта <br>
', 'er_theme' ), $aa, '<a href="'.get_permalink($get_comment->comment_post_ID).'comment-'.$get_comment->comment_ID.'/">'.$review_title.'</a>' );
				
				if (get_post_type($get_comment->comment_post_ID) == 'casino' && intval($get_comment->comment_parent) == 0) {
					if ( $user_comment_author != 0 ) {
						notify_user_action( 'system_comment_is_bad', $user_comment_author, __( 'Отзыв прошел модерацию, статус «Недостоверный»', 'er_theme' ), $content_balance );
					}
					
					$headers    = array( 'Content-Type: text/html; charset=UTF-8' );
					
					if (mb_strlen($get_comment->comment_author_email) > 0 && is_email( $get_comment->comment_author_email ) && mb_strpos($get_comment->comment_author_email, 'eto.ru') === false) {
						wp_mail( $get_comment->comment_author_email, __( 'Отзыв прошел модерацию, статус «Недостоверный»', 'er_theme' ), $content_balance, $headers );
					}
				}
			}
		}
		
		
		
		//Обновим статус (последнее значение установим в доп-поле для сверок)
		if (get_field('temp_status',$comment) != get_field('status_comment',$comment)) {
			update_field( 'temp_status', get_field( 'status_comment', $comment ), $comment );
		}
		update_post_info( get_comment($comment_ID)->comment_post_ID );
	}
);

add_action( 'transition_comment_status', 'recheck_comments', 10, 3 );
/**
 * @param $new_status
 * @param $old_status
 * @param $comment
 */
function recheck_comments( $new_status, $old_status, $comment ) {
	$i = 0;
	if ( $old_status != $new_status ) {
		$i = 1;
		if ( $new_status == 'approved' ) {
			$current = get_locale();
			
			$fields = get_fields('comment_'.$comment->comment_ID);
			$comment_type_existing = $fields['comment_type'];
			$parent = $comment->comment_parent;
			if($comment_type_existing != 'abuses') {
				if(array_key_exists('rating_service',$fields) && array_key_exists('rating_team',$fields) && array_key_exists('rating_quality',$fields) && array_key_exists('rating_price',$fields) && $parent == 0) {
					$comment_type = 'reviews';
				} else {
					$comment_type = 'comment';
				}
			}
			
			if($comment_type_existing != $comment_type && $comment_type_existing != 'abuses') {
				update_field('comment_type',$comment_type,'comment_'.$comment->comment_ID);
			}
			
			if(($comment_type == 'reviews') && (($comment_type_existing != 'abuses'))) {
				
				$post_curr_avg = get_field('reviews_rating_average',$comment->comment_post_ID);
				if (!$post_curr_avg || $post_curr_avg == '0.01' || $post_curr_avg == '0') {
					$post_curr_avg = 0;
				}
				
				$curr_count = get_field('reviews_count_reviews',$comment->comment_post_ID);
				if (!$curr_count || $curr_count == '0') {
					$curr_count = 0;
				}
				
				$curr_good = get_field('reviews_count_good',$comment->comment_post_ID);
				if (!$curr_good || $curr_good == '0') {
					$curr_good = 0;
				}
				
				$curr_bad = get_field('reviews_count_bad',$comment->comment_post_ID);
				if (!$curr_bad || $curr_bad == '0') {
					$curr_bad = 0;
				}
				
				$new_rate = ( $fields['rating_service'] + $fields['rating_team'] + $fields['rating_quality'] + $fields['rating_price']) / 4 ;
				$new_rate = number_format($new_rate, 2, '.', '');
				update_field('comment_avg',$new_rate,'comment_'.$comment->comment_ID);
				
				if($new_rate > 3) {
					$new_rate_goodness = 'good';
				} else {
					$new_rate_goodness = 'bad';
				}
				
				if($post_curr_avg == 0) {
					$rate_avg_new = $new_rate;
				} else {
					$rate_avg_new = (($post_curr_avg * $curr_count) + $new_rate) / ($curr_count + 1);
					
				}
				update_field('reviews_rating_average',$rate_avg_new,$comment->comment_post_ID);
				
				if($curr_count == 0) {
					$curr_count_new = 1;
				} else {
					$curr_count_new = $curr_count + 1;
				}
				update_field('reviews_count_reviews',$curr_count_new,$comment->comment_post_ID);
				if($new_rate_goodness == 'good') {
					if($curr_good == 0) {
						$curr_good_new = 1;
					} else {
						$curr_good_new = $curr_good + 1;
					}
					$curr_bad_new = $curr_bad;
					update_field('reviews_count_good',$curr_good_new,$comment->comment_post_ID);
				} elseif($new_rate_goodness == 'bad') {
					if($curr_bad == 0) {
						$curr_bad_new = 1;
					} else {
						$curr_bad_new = $curr_bad + 1;
					}
					$curr_good_new = $curr_good;
					update_field('reviews_count_bad',$curr_bad_new,$comment->comment_post_ID);
				}
				$per_new_good = $curr_good_new / $curr_count_new * 100;
				$per_new_bad = $curr_bad_new / $curr_count_new * 100;
				update_field('reviews_count_good_percent',$per_new_good,$comment->comment_post_ID);
				update_field('reviews_count_bad_percent',$per_new_bad,$comment->comment_post_ID);
			} elseif ($comment_type_existing == 'abuses') {
				$curr_count_ab = get_field('reviews_count_abuses',$comment->comment_post_ID);
				if (!$curr_count_ab || $curr_count_ab == '0') {
					$curr_count_ab = 0;
				}
				if($curr_count_ab == 0) {
					$curr_count_ab_new = 1;
				} else {
					$curr_count_ab_new = $curr_count_ab + 1;
				}
				update_field('reviews_count_abuses',$curr_count_ab_new,$comment->comment_post_ID);
			}
			update_field('cron_updated','yes','comment_'.$comment->comment_ID);
		} else {
			update_post_info( $comment->comment_post_ID );
		}
		
		//Отзыв не прошел модерацию
		if ( $new_status != 'approved' ) {
			
			// $current_language = get_locale();
			// if ( $current_language == 'ru_RU' ) {
			// 	$text_a_user = 'Анонимный пользователь';
			// } elseif ( $current_language == 'fr_FR' ) {
			// 	$text_a_user = 'Utilisateur anonyme';
			// } elseif ( $current_language == 'es_ES' ) {
			// 	$text_a_user = 'Usuario anónimo';
			// } elseif ( $current_language == 'de_DE' ) {
			// 	$text_a_user = 'Anonymer Nutzer';
			// } elseif ( $current_language == 'pl_PL' ) {
			// 	$text_a_user = 'Użytkownik anonimowy';
			// } else {
			// 	$text_a_user = 'Anonymous user';
			// }
			
			$text_a_user = __( 'Анонимный пользователь', 'er_theme' );
			
			$get_comment = $comment;
			$user_comment_author = $get_comment->user_id;
			$cyr = [];
			$lat = [];
			$comment_author = get_userdata( $get_comment->user_id );
			if ( $comment_author->first_name && ! $comment_author->last_name ) {
				$aa = $comment_author->first_name;
			} elseif ( ! $comment_author->first_name && $comment_author->last_name ) {
				$aa = $comment_author->last_name;
			} elseif ( $comment_author->first_name && $comment_author->last_name ) {
				$aa = $comment_author->first_name . ' ' . $comment_author->last_name;
			} elseif ( $comment_author->user_nicename ) {
				$aa = $comment_author->user_nicename;
			} else {
				$aa = $text_a_user;
			}
			if (get_field('review_title',$get_comment)) {
				$review_title = get_field('review_title',$get_comment);
			} else {
				$review_title = wp_trim_words($get_comment->comment_content, 7,'');
			}
			if (get_field('company_name',$get_comment->comment_post_ID)) {
				$c_name = get_field('company_name',$get_comment->comment_post_ID);
			} else {
				$c_name = get_the_title($get_comment->comment_post_ID);
			}

// 				$content_balance = 'Здравствуйте, '.$aa.'!<br>

// Ваш отзыв на компанию <a href="'.get_permalink($get_comment->comment_post_ID).'">'.$c_name.'</a> снят с публикации модератором сайта по этим причинам:<br>
// <ul class="ul_notify">
// <li>содержание отзыва оскорбительно или запрещено законом</li>
// <li>отзыв содержит мало полезных сведений о товаре / услуге</li>
// <li>запрещено размещать отзывы с упоминанием фамилий, имен и других персональных данных</li>
// <li>запрещено размещать отзывы со ссылками</li>
// <li>запрещено размещать отзывы с рекламой.</li>
// </ul>
// Правила пользования сервисом <a href="https://eto-razvod.ru/rules/">https://eto-razvod.ru/rules/</a>.<br><br>

// Заблокированные отзывы доступны в вашем профиле. После исправления отзывы автоматически отправляются на повторную проверку модераторами.<br><br>

// С уважением, <br>
// Администрация сайта <br>
// ';
			
			$content_balance = wp_sprintf( __( 'Здравствуйте, %s!<br>

Ваш отзыв на компанию %s снят с публикации модератором сайта по этим причинам:<br>
<ul class="ul_notify">
<li>содержание отзыва оскорбительно или запрещено законом</li>
<li>отзыв содержит мало полезных сведений о товаре / услуге</li>
<li>запрещено размещать отзывы с упоминанием фамилий, имен и других персональных данных</li>
<li>запрещено размещать отзывы со ссылками</li>
<li>запрещено размещать отзывы с рекламой.</li>
</ul>
Правила пользования сервисом <a href="https://eto-razvod.ru/rules/">https://eto-razvod.ru/rules/</a>.<br><br>

Заблокированные отзывы доступны в вашем профиле. После исправления отзывы автоматически отправляются на повторную проверку модераторами.<br><br>

С уважением, <br>
Администрация сайта <br>
', 'er_theme' ), $aa, '<a href="'.get_permalink($get_comment->comment_post_ID).'">'.$c_name.'</a>' );
			
			if (get_post_type($get_comment->comment_post_ID) == 'casino' && intval($get_comment->comment_parent) == 0) {
				if ( $user_comment_author != 0 ) {
					notify_user_action( 'system_comment_is_spam', $user_comment_author, __( 'Отзыв не прошел модерацию', 'er_theme' ), $content_balance );
				}
				
				$headers    = array( 'Content-Type: text/html; charset=UTF-8' );
				
				if (mb_strlen($get_comment->comment_author_email) > 0 && is_email( $get_comment->comment_author_email ) && mb_strpos($get_comment->comment_author_email, 'eto.ru') === false) {
					wp_mail( $get_comment->comment_author_email, __( 'Отзыв не прошел модерацию', 'er_theme' ), $content_balance, $headers );
				}
			}
		}
		
		
		if(get_field('is_abuse','comment_'.$comment->comment_ID)) {
			$comment_type = 'abuses';
		} else {
			$comment_type = get_field('comment_type','comment_'.$comment->comment_ID);
		}
		if($new_status == 'approved') {
			$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
			if($comment_type == 'abuses') {
				if(get_post_type($comment->comment_post_ID) == 'casino') {
					$mydb->insert('notifications',
						array(
							'user_id'=> $comment->comment_post_ID,
							'type' => 'system_new_abuse_notify_company',
							'status_read' => 'new',
							'status_send' => 'not_sent',
							'title' => __( 'Новая жалоба на вашу компанию!', 'er_theme' ),
							'content' => $comment->comment_ID
						),
						array( '%s', '%s', '%s','%s','%s','%s'));
				}
				
				$mydb->insert('notifications',
					array(
						'user_id'=> $comment->user_id,
						'type' => 'system_new_abuse_notify_user_approved',
						'status_read' => 'new',
						'status_send' => 'not_sent',
						'title' => __( 'Ваша жалоба прошла модерацию!', 'er_theme' ),
						'content' => $comment->comment_ID
					),
					array( '%s', '%s', '%s','%s','%s','%s'));
			} elseif($comment_type == 'reviews') {
				if(get_post_type($comment->comment_post_ID) == 'casino') {
					$mydb->insert('notifications',
						array(
							'user_id'=> $comment->comment_post_ID,
							'type' => 'system_new_review_notify_company',
							'status_read' => 'new',
							'status_send' => 'not_sent',
							'title' => __( 'Новый отзыв о вашей компании!', 'er_theme' ),
							'content' => $comment->comment_ID
						),
						array( '%s', '%s', '%s','%s','%s','%s'));
				}
				$mydb->insert('notifications',
					array(
						'user_id'=> $comment->user_id,
						'type' => 'system_new_review_notify_user_approved',
						'status_read' => 'new',
						'status_send' => 'not_sent',
						'title' => __( 'Ваш отзыв прошел модерацию!', 'er_theme' ),
						'content' => $comment->comment_ID
					),
					array( '%s', '%s', '%s','%s','%s','%s'));
				$user_email = get_userdata($comment->user_id)->data->user_email;
				if ($current == 'ru_RU') {
					if ( isset( $user_email ) ) {
						$headers    = array( 'Content-Type: text/html; charset=UTF-8' );
						$comment_id = $comment->comment_ID;
						$company_id = $comment->comment_post_ID;
						if ( get_post_type( $company_id ) == 'casino' ) {
							$type         = __( 'отзыв', 'er_theme' );
							$company_name = get_field( 'company_name', $company_id );
							$company_link = get_the_permalink( $company_id );
							// $item_content = __( 'Ваш отзыв на компанию', 'er_theme' ) . ' <a href="' . $company_link . '">' . $company_name . '</a> ' . __( 'успешно прошел модерацию. Теперь Вы можете увидеть его на' ) . ' <a href="' . $company_link . '/comment-' . $comment_id . '/">' . $company_link . '/comment-' . $comment_id  . '/</a>';
							$item_content = wp_sprintf( __( 'Ваш отзыв на компанию %s успешно прошел модерацию. Теперь Вы можете увидеть его на %s', 'er_theme' ), '<a href="' . $company_link . '">' . $company_name . '</a>', '<a href="' . $company_link . '/comment-' . $comment_id . '/">' . $company_link . '/comment-' . $comment_id  . '/</a>' );
						} else {
							$type         = __( 'комментарий', 'er_theme' );
							$company_name = get_the_title( $company_id );
							$company_link = get_the_permalink( $company_id );
							// $item_content = __( 'Ваш отзыв на запись', 'er_theme' ) . ' <a href="' . $company_link . '">' . $company_name . '</a> ' . __( 'успешно прошел модерацию. Теперь Вы можете увидеть его на' ) . ' <a href="' . $company_link . '/comment-' . $comment_id . '/">' . $company_link . '/comment-' . $comment_id  . '/</a>';
							$item_content = wp_sprintf( __( 'Ваш отзыв на запись %s успешно прошел модерацию. Теперь Вы можете увидеть его на %s', 'er_theme' ), '<a href="' . $company_link . '">' . $company_name . '</a>', '<a href="' . $company_link . '/comment-' . $comment_id . '/">' . $company_link . '/comment-' . $comment_id  . '/</a>' );
						}
						
						// wp_mail( $user_email, 'Ваш ' . $type . ' прошел модерацию!', $item_content, $headers );
						wp_mail( $user_email, wp_sprintf( __( 'Ваш %s прошел модерацию!', 'er_theme' ), $type ), $item_content, $headers );
					}
				}
				
			} elseif($comment_type == 'comment') {
				if(get_post_type($comment->comment_post_ID) == 'casino') {
					$mydb->insert('notifications',
						array(
							'user_id'=> $comment->comment_post_ID,
							'type' => 'system_new_comment_notify_company',
							'status_read' => 'new',
							'status_send' => 'not_sent',
							'title' => __('Новый комментарий о вашей компании!','er_theme'),
							'content' => $comment->comment_ID
						),
						array( '%s', '%s', '%s','%s','%s','%s'));
					
				}
				$mydb->insert('notifications',
					array(
						'user_id'=> $comment->user_id,
						'type' => 'system_new_comment_notify_user_approved',
						'status_read' => 'new',
						'status_send' => 'not_sent',
						'title' => __('Ваш комментарий прошел модерацию!','er_theme'),
						'content' => $comment->comment_ID
					),
					array( '%s', '%s', '%s','%s','%s','%s'));
				
				if ($current == 'ru_RU') {
					if ($comment->comment_parent > 0) {
						$comment_parent = get_comment($comment->comment_parent);
						$user_email = get_userdata($comment_parent->user_id)->data->user_email;
						if (isset($user_email)) {
							$headers = array('Content-Type: text/html; charset=UTF-8');
							$comment_parent_id = $comment_parent->comment_ID;
							$company_id = $comment_parent->comment_post_ID;
							if(get_post_type($company_id) == 'casino') {
								$type         = __( 'отзыв', 'er_theme' );
								$company_name = get_field('company_name',$company_id);
								$company_link = get_the_permalink($company_id);
								//$item_content = __('Ваш отзыв на компанию','er_theme').' <a href="'.$company_link.'">'.$company_name.'</a> '.__('успешно прошел модерацию. Теперь Вы можете увидеть его на').' <a href="'.$company_link.'#comment-'.$comment_parent_id.'">'.__('странице компании','er_theme').'</a>';
								// $item_content = 'Уведомляем вас о том, что на ваш отзыв, который вы оставили о компании <a href="'.$company_link.'">'.$company_name.'</a> '.get_comment_date( 'd.m.Y', $comment_parent_id ).' на сайте eto-razvod.ru, появился новый комментарий. Вы можете посмотреть его на нашем сайте, перейдя по <a href="'.$company_link.'/comment-'.$comment_parent_id.'/">'.$company_link.'/comment-'.$comment_parent_id.'/</a>';
								$item_content = wp_sprintf( __( 'Уведомляем вас о том, что на ваш отзыв, который вы оставили о компании %s %s на сайте eto-razvod.ru, появился новый комментарий. Вы можете посмотреть его на нашем сайте, перейдя по %s', 'er_theme' ), '<a href="'.$company_link.'">'.$company_name.'</a>', get_comment_date( 'd.m.Y', $comment_parent_id ), '<a href="'.$company_link.'/comment-'.$comment_parent_id.'/">'.$company_link.'/comment-'.$comment_parent_id.'/</a>' );
								// wp_mail($user_email,'Новый комментарий к вашему отзыву',$item_content, $headers);
								wp_mail( $user_email, __( 'Новый комментарий к вашему отзыву', 'er_theme' ), $item_content, $headers );
							}
						}
					}
				}
				
			}
		}
		
	} else {
		update_post_info( $comment->comment_post_ID );
	}
}

/**
 * Скрипт пересчета данных аналитики компании
 *
 * @param int $post_id Cюда передаём post_ID компаниии (post_type = casino)
 * @param string $watch Тип работы скрипт, по-умолчанию '', значение see не обновляет данные в БД
 *
 */
function update_post_info( $post_id, $watch = '' ) {
	$comments = get_comments( [
		'post_id'    => $post_id,
		'status'     => 'approve',
		'number'     => '',
		'meta_query' => [
			'key'     => 'cron_updated',
			'value'   => 'yes',
			'compare' => '=',
		]
	] );
	//Обнуляем данные поста
	if ( $watch == '' ) {
		update_field( 'reviews_rating_average', '', $post_id );
		update_field( 'reviews_count_reviews', 0, $post_id );
		update_field( 'reviews_count_good', 0, $post_id );
		update_field( 'reviews_count_bad', 0, $post_id );
		update_field( 'reviews_count_good_percent', 0, $post_id );
		update_field( 'reviews_count_bad_percent', 0, $post_id );
		update_field( 'reviews_count_abuses', 0, $post_id );
	}
	
	
	foreach ( $comments as $comment ) {
		//Берем оценки
		$fields                = get_fields( 'comment_' . $comment->comment_ID );
		$comment_type_existing = $fields['comment_type'];
		$parent                = $comment->comment_parent;
		//сопоставлеям типы
		/*if ($fields['status_comment'] == 'bad') {
			continue;
		}*/
		if ( $comment_type_existing != 'abuses' ) {
			
			if ( array_key_exists( 'rating_service', $fields ) && array_key_exists( 'rating_team', $fields ) && array_key_exists( 'rating_quality', $fields ) && array_key_exists( 'rating_price', $fields ) && $parent == 0 ) {
				//если нет родителя и есть параметры оценки - то это обзор
				$comment_type = 'reviews';
			} else {
				//все остальное ответ
				$comment_type = 'comment';
			}
		}
		
		if ( ( $comment_type == 'reviews' ) && ( $comment_type_existing != 'abuses' ) ) {
			
			if ( $watch == 'see' ) {
				echo $comment_type_existing . ' 0. Отзыв $comment->comment_ID' . $comment->comment_ID . ' $curr_count_ab_new ' . $curr_count_ab_new . ' reviews_count_abuses ' . get_field( 'reviews_count_abuses', $comment->comment_post_ID ) . '<br>';
			}
			
			$post_curr_avg = get_field( 'reviews_rating_average', $comment->comment_post_ID );
			if ( ! $post_curr_avg || $post_curr_avg == '0.01' || $post_curr_avg == '0' ) {
				$post_curr_avg = 0;
			}
			
			$curr_count = get_field( 'reviews_count_reviews', $comment->comment_post_ID );
			if ( ! $curr_count || $curr_count == '0' ) {
				$curr_count = 0;
			}
			
			$curr_good = get_field( 'reviews_count_good', $comment->comment_post_ID );
			if ( ! $curr_good || $curr_good == '0' ) {
				$curr_good = 0;
			}
			
			$curr_bad = get_field( 'reviews_count_bad', $comment->comment_post_ID );
			if ( ! $curr_bad || $curr_bad == '0' ) {
				$curr_bad = 0;
			}
			
			$new_rate = ( $fields['rating_service'] + $fields['rating_team'] + $fields['rating_quality'] + $fields['rating_price'] ) / 4;
			$new_rate = number_format( $new_rate, 2, '.', '' ); //массив
			
			
			if ( $new_rate > 3 ) {
				$new_rate_goodness = 'good';  //массив
			} else {
				$new_rate_goodness = 'bad';  //массив
			}
			
			if ( $post_curr_avg == 0 ) {
				$rate_avg_new = $new_rate;
			} else {
				$rate_avg_new = ( ( $post_curr_avg * $curr_count ) + $new_rate ) / ( $curr_count + 1 );
				
			}
			if ( $watch == '' ) {
				if ($fields['status_comment'] == 'bad') {
				
				} else {
					update_field( 'reviews_rating_average', $rate_avg_new, $comment->comment_post_ID );
				}
			} else if ( $watch == 'see' ) {
				echo $rate_avg_new . '<br>';
			}
			
			if ( $curr_count == 0 ) {
				$curr_count_new = 1;
			} else {
				$curr_count_new = $curr_count + 1;
			}
			if ( $watch == '' ) {
				update_field( 'reviews_count_reviews', $curr_count_new, $comment->comment_post_ID );
			} else if ( $watch == 'see' ) {
				echo $curr_count_new . '<br>';
			}
			if ( $new_rate_goodness == 'good' ) {
				if ( $curr_good == 0 ) {
					$curr_good_new = 1;
				} else {
					$curr_good_new = $curr_good + 1;
				}
				$curr_bad_new = $curr_bad;
				if ( $watch == '' ) {
					update_field( 'reviews_count_good', $curr_good_new, $comment->comment_post_ID );
				} else if ( $watch == 'see' ) {
					echo $curr_good_new . '<br>';
				}
			} elseif ( $new_rate_goodness == 'bad' ) {
				if ( $curr_bad == 0 ) {
					$curr_bad_new = 1;
				} else {
					$curr_bad_new = $curr_bad + 1;
				}
				$curr_good_new = $curr_good;
				if ( $watch == '' ) {
					update_field( 'reviews_count_bad', $curr_bad_new, $comment->comment_post_ID );
				} else if ( $watch == 'see' ) {
					echo $curr_bad_new . '<br>';
				}
			}
			$per_new_good = $curr_good_new / $curr_count_new * 100;
			$per_new_bad  = $curr_bad_new / $curr_count_new * 100;
			if ( $watch == '' ) {
				update_field( 'reviews_count_good_percent', $per_new_good, $comment->comment_post_ID );
				update_field( 'reviews_count_bad_percent', $per_new_bad, $comment->comment_post_ID );
			} else if ( $watch == 'see' ) {
				echo $per_new_good . '<br>';
				echo $per_new_bad . '<br>';
			}
			
			
		} elseif ( $comment_type_existing == 'abuses' ) {
			if ( $watch == 'see' ) {
				echo 'абуза 1. $comment->comment_ID' . $comment->comment_ID . ' $curr_count_ab_new ' . $curr_count_ab_new . ' reviews_count_abuses ' . get_field( 'reviews_count_abuses', $comment->comment_post_ID ) . '<br>';
			}
			$curr_count_ab = get_field( 'reviews_count_abuses', $comment->comment_post_ID );
			if ( ! $curr_count_ab || $curr_count_ab == '0' ) {
				$curr_count_ab = 0;
			}
			if ( $curr_count_ab == 0 ) {
				$curr_count_ab_new = 1;
				if ( $watch == 'see' ) {
					echo 'абуза 2. $comment->comment_ID' . $comment->comment_ID . ' $curr_count_ab_new ' . $curr_count_ab_new . ' reviews_count_abuses ' . get_field( 'reviews_count_abuses', $comment->comment_post_ID ) . '<br>';
				}
			} else {
				$curr_count_ab_new = $curr_count_ab + 1;
				if ( $watch == 'see' ) {
					echo 'абуза 3. $comment->comment_ID' . $comment->comment_ID . ' $curr_count_ab_new ' . $curr_count_ab_new . ' reviews_count_abuses ' . get_field( 'reviews_count_abuses', $comment->comment_post_ID ) . '<br>';
				}
			}
			if ( $watch == '' ) {
				update_field( 'reviews_count_abuses', $curr_count_ab_new, $comment->comment_post_ID );
			} else if ( $watch == 'see' ) {
				echo $curr_count_ab_new . '<br>';
			}
		}
	}
}

add_action( 'wp_ajax_check_info_by_url', 'check_info_by_url' );
add_action( 'wp_ajax_nopriv_check_info_by_url', 'check_info_by_url' );
function check_info_by_url() {
	$checkedurl = url_to_postid( $_POST['checkedurl'] );
	echo $checkedurl;
	die;
}


function afunction( $post, $new_title ) {
	// if new_title isn't defined, return
	if ( empty ( $new_title ) ) {
		return;
	}
	
	// ensure title case of $new_title
	$new_title = mb_convert_case( $new_title, MB_CASE_TITLE, "UTF-8" );
	
	// if $new_title is defined, but it matches the current title, return
	if ( $post->post_title === $new_title ) {
		return;
	}
	
	// place the current post and $new_title into array
	$post_update = array(
		'ID'         => $post->ID,
		'post_title' => $new_title
	);
	
	wp_update_post( $post_update );
}

/*$params = array('Обновление постов с неправильной статой');

if( !wp_next_scheduled('update_post_stats_cron', $params ) )
	wp_schedule_event( time(), '30min_test', 'update_post_stats_cron', $params );

add_action( 'update_post_stats_cron', 'update_post_stats', 10, 3 );

function update_post_stats() {
	$text_with_links = get_field('text_with_links', 'option');
	$text_with_links = explode(',',$text_with_links);
	if (count($text_with_links) != 0) {
		foreach ( $text_with_links as $key => $value ) {
			$url_to_postid = url_to_postid( $value );
			update_post_info($url_to_postid);
			unset($text_with_links[$key]);
			break;
		}
		$text_with_links = implode(',',$text_with_links);
		update_field('text_with_links',$text_with_links, 'option');
	}
}*/

class T5_Posts_By_Content {
	protected static $content = '';
	
	protected static $like = true;
	
	/**
	 * Mapper for get_posts() with extra arguments 'content' and 'like'
	 *
	 * 'content' must be a string with optional '%' for free values.
	 * 'like' must be TRUE or FALSE.
	 *
	 * @param array $args See get_posts.
	 *
	 * @return array
	 */
	public static function get( $args ) {
		if ( isset ( $args['content'] ) ) {
			// This is TRUE by default for get_posts().
			// We need FALSE to let the WHERE filter do its work.
			$args['suppress_filters'] = false;
			self::$content            = $args['content'];
			add_filter( 'posts_where', array( __CLASS__, 'where_filter' ) );
		}
		
		isset ( $args['like'] ) and self::$like = (bool) $like;
		
		return get_posts( $args );
	}
	
	/**
	 * Changes the WHERE clause.
	 *
	 * @param string $where
	 *
	 * @return string
	 */
	public static function where_filter( $where ) {
		// Make sure we run this just once.
		remove_filter( 'posts_where', array( __CLASS__, 'where_filter' ) );
		
		global $wpdb;
		$like = self::$like ? 'LIKE' : 'NOT LIKE';
		// Escape the searched text.
		$extra = $wpdb->prepare( '%s', self::$content );
		
		// Reset vars for the next use.
		self::$content = '';
		self::$like    = true;
		
		return "$where AND post_content $like $extra";
	}
}

function hide_input_user_text() {
	echo '<script>jQuery("#useridtext input").attr("readonly","readonly");useridtext = jQuery("#useridtext input").val();
if (parseInt(useridtext) > 0) {
	jQuery("#useridtext").html(\'<a href="/wp-admin/user-edit.php?user_id=\'+useridtext+\'">Перейти в профиль</a>\');
}</script>';
}
add_action('admin_footer', 'hide_input_user_text');

function price_language_2_func( $atts ) {
	$current_language = get_locale();
	if ( $current_language == 'ru_RU' ) {
		return '400 рублей'; // никаких echo, только return
	} elseif ( $current_language == 'en_US' ) {
		return '5.99 $'; // никаких echo, только return
	} else {
		return '4.99 €'; // никаких echo, только return
	}
	
}

add_shortcode( 'price_language_2', 'price_language_2_func' );


function price_language_1_func( $atts ) {
	$current_language = get_locale();
	if ( $current_language == 'ru_RU' ) {
		return '0 рублей'; // никаких echo, только return
	} elseif ( $current_language == 'en_US' ) {
		return '0 $'; // никаких echo, только return
	} else {
		return '0 €'; // никаких echo, только return
	}
	
}


add_shortcode( 'price_language_1', 'price_language_1_func' );


function get_rating_name_shortcode( $atts ) {
	return '«'.get_the_title().'»';
	
}
add_shortcode( 'get_rating_name_shortcode', 'get_rating_name_shortcode' );


function get_date_now_shortcode( $atts ) {
	return date("d.m.Y");
	
}
add_shortcode( 'get_date_now_shortcode', 'get_date_now_shortcode' );


function get_count_rating( $atts ) {
	$tag_term = get_term( get_field('rating_tag',get_the_ID()), 'affiliate-tags' );
	$tag = $tag_term->slug;
	$fields = get_field('more_fields',get_the_ID());
	$args = array(
		'post_type' => 'casino',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
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
	
	$all_reviews = new WP_Query( $args );
	wp_reset_query();
	
	return $all_reviews->found_posts.' '.counted_text($all_reviews->found_posts,'предложение','предложения','предложений');
	
}
add_shortcode( 'get_count_rating', 'get_count_rating' );


//date("Y-m-d")


if ( ! function_exists( 'get_text_sentences' ) ) {
	function get_text_sentences( $body, $sentencesToDisplay = 2 ) {
		$nakedBody = preg_replace( '/\s+/', ' ', strip_tags( $body ) );
		$sentences = preg_split( '/(\s)(\.|\?|\!)/', $nakedBody );
		
		if ( count( $sentences ) <= $sentencesToDisplay ) {
			return $nakedBody;
		}
		
		$stopAt = 0;
		foreach ( $sentences as $i => $sentence ) {
			$stopAt += mb_strlen( $sentence );
			
			if ( $i >= $sentencesToDisplay - 1 ) {
				break;
			}
		}
		
		$stopAt += ( $sentencesToDisplay * 2 );
		
		return trim( mb_substr( $nakedBody, 0, $stopAt ) );
	}
}

function count4comment($body) {
	$nakedBody = preg_replace('/\s+/',' ',strip_tags($body));
	$sentences = preg_split('/(\.|\?|\!)(\s)/',$nakedBody);
	
	
	return count($sentences);
}

function tease4comment($body, $sentencesToDisplay = 2) {
	$nakedBody = preg_replace('/\s+/',' ',strip_tags($body));
	$sentences = preg_split('/(\.|\?|\!)(\s)/',$nakedBody);
	
	if (count($sentences) <= $sentencesToDisplay)
		return $nakedBody;
	
	$stopAt = 0;
	foreach ($sentences as $i => $sentence) {
		$stopAt += mb_strlen($sentence);
		
		if ($i >= $sentencesToDisplay - 1)
			break;
	}
	
	$stopAt += ($sentencesToDisplay * 2);
	return trim(mb_substr($nakedBody, 0, $stopAt));
}


function remove4comment($body, $sentencesToDisplay = 2) {
	$nakedBody = preg_replace('/\s+/',' ',strip_tags($body));
	$sentences = preg_split('/(\.|\?|\!)(\s)/',$nakedBody);
	
	if (count($sentences) <= $sentencesToDisplay)
		return $nakedBody;
	
	$stopAt = 0;
	foreach ($sentences as $i => $sentence) {
		$stopAt += mb_strlen($sentence);
		
		if ($i >= $sentencesToDisplay - 1)
			break;
	}
	
	$stopAt += ($sentencesToDisplay * 2);
	return str_replace(trim(mb_substr($nakedBody, 0, $stopAt)),'',$nakedBody);
}

if ( ! function_exists( 'mb_ucfirst' ) ) {
	function mb_ucfirst( $string, $encoding ) {
		$firstChar = mb_substr( $string, 0, 1, $encoding );
		$then      = mb_substr( $string, 1, null, $encoding );
		
		return mb_strtoupper( $firstChar, $encoding ) . $then;
	}
}

if ( ! function_exists( 'truncateToWord' ) ) {
	function truncateToWord( $content, $length = 200, $continue_reading = '' ) {
		if ( mb_strlen( $content ) >= $length ) {
			if (mb_strpos( $content, '" ', $length ) == mb_strpos( $content, ' ', $length )-1 ){
				return $content;
			}
			$spaceAtPos = mb_strpos( $content, ' ', $length );
			$content    = mb_substr( $content, 0, $spaceAtPos );
			$check      = preg_match( '/(\.|\?|\,|\!)/', mb_substr( $content, - 1 ) );
			if ( $check == 1 ) {
				$content = mb_substr( $content, 0, - 1 );
			}
			$content = $content . '... ' . $continue_reading;
		}
		
		return $content;
	}
}

if ( ! function_exists( 'truncateToWord4comment' ) ) {
	function truncateToWord4comment( $content, $length = 200, $continue_reading = '' ) {
		if ( mb_strlen( esc_html($content) ) >= $length ) {
			$spaceAtPos = mb_strpos( $content, ' ', $length );
			$content    = mb_substr( $content, 0, $spaceAtPos );
			$check      = preg_match( '/(\.|\?|\!)/', mb_substr( $content, - 1 ) );
			if ( $check == 1 ) {
				$content = mb_substr( $content, 0, - 1 );
			}
			$content = $content.$continue_reading;
		}
		
		return $content;
	}
}

add_action( 'wp_ajax_get_posts_companies_ajax', 'get_posts_companies_ajax' );
add_action( 'wp_ajax_nopriv_get_posts_companies_ajax', 'get_posts_companies_ajax' );


function get_posts_companies_ajax() {
	$post_id = intval($_POST['post_id']);
	$cur_terms = get_field('review_aff_tags',$post_id);
	
	if (gettype($cur_terms) == 'array') {
		//print_r($cur_terms[0]);
		$term_id = $cur_terms[0];
		$term_name = get_term($cur_terms[0])->name;
	} else {
		$cur_terms = get_the_terms($post_id, 'affiliate-tags');
		$term_id = $cur_terms[0]->term_id;
		$term_name = $cur_terms[0]->name;
	}
	if (in_array(11,$cur_terms)) {
		$term_name = 'bi';
	} elseif (in_array(10,$cur_terms)) {
		$term_name = 'fx';
	}
	$args = array(
		'post_type'         => 'casino',
		'orderby'           => 'menu_order',
		'posts_per_page'    => 5,
		'_shuffle_and_pick' => 5,
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
	$arr = [];
	$reviews   = new WP_Query( $args );
	if ( $reviews->have_posts() ) {
		while ( $reviews->have_posts() ) {
			$reviews->the_post();
			
			
			$er_company_site_str = get_field( 'websites', get_the_ID() )[0]['site_url'];
			if ( $er_company_site_str && $er_company_site_str != '' ) {
				$er_company_site_str_2 = preg_replace( '#^[^:/.]*[:/]+#i', '', $er_company_site_str );
				$site                  = preg_replace( '/^www\./', '', rtrim( $er_company_site_str_2, '/' ) );
			} else {
				$site = get_field('company_name',get_the_ID());
			}
			
			
			$arr[] = $site;
		}
	}
	wp_reset_query();
	wp_send_json($arr);
	die();
}

/*function register_custom_acf_fields55() {
	acf_add_local_field( array(
		'key'          => 'field_middle_name',
		'label'        => 'Middle Name',
		'name'         => 'middle_name',
		'type'         => 'text',
		'parent'       => 'group_5f7fdf8d45812',
		'instructions' => '',
		'required'     => 0,
	) );
	
}
add_action( 'acf/init', 'register_custom_acf_fields55' );*/


function allchargeback( $atts ){
	$language = get_locale();
	if ($language == 'ru_RU') {
		return '<iframe class="nes-iframe" src="https://allchargebacks.ru/partners/forms/violet_without_logo/index.php?utm_source=partner333667" frameborder="0"></iframe>
<link rel="stylesheet" href="https://allchargebacks.ru/partners/forms/violet_without_logo/iframe.css">';
	} else {
		return '';
	}
}

add_shortcode( 'allchargeback', 'allchargeback' );

function queans( $atts ){
	$params = shortcode_atts(
		array(
			'question' => '',
			'answear' => ''
		),
		$atts
	);
	return '<div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question" class="schema-faq-section get-faq active"><div itemprop="name" class="schema-faq-question"><h3>'.$params[ 'question' ].'</h3></div><div class="schema-faq-answer" itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"><span itemprop="text">'.$params[ 'answear' ].'</span></div></div>';
}

add_shortcode( 'queans', 'queans' );

function queanswrap( $atts, $shortcode_content = null ) {
	
	$params = shortcode_atts(
		array(
			'anchor' => ''
		),
		$atts
	);
	if ($params[ 'anchor' ] == '') {
		return '<div itemscope="" itemtype="https://schema.org/FAQPage" class="schema-faq wp-block-yoast-faq-block yoast-faq-accordion">'.do_shortcode( $shortcode_content ).'</div>';
	} else {
		return '<div itemscope="" itemtype="https://schema.org/FAQPage" class="schema-faq wp-block-yoast-faq-block yoast-faq-accordion"><h2>'.$params[ 'anchor' ].'</h2>'.do_shortcode( $shortcode_content ).'</div>';
	}
	
}

add_shortcode( 'queanswrap', 'queanswrap' );

add_action('admin_bar_menu', 'add_toolbar_items', 100);
function add_toolbar_items($admin_bar){
	$admin_bar->add_menu( array(
		'id'    => 'my-item',
		'title' => 'Функции',
		'href'  => '#',
		'meta'  => array(
			'title' => __('Функции'),
		),
	));
	$admin_bar->add_menu( array(
		'id'    => 'my-sub-item',
		'parent' => 'my-item',
		'title' => 'Перевести',
		'href'  => "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."?translateid=".url_to_postid('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']),
		'meta'  => array(
			'title' => __('Перевести'),
			'target' => '_blank',
			'class' => 'my_menu_item_class'
		),
	));
	$admin_bar->add_menu( array(
		'id'    => 'my-second-sub-item',
		'parent' => 'my-item',
		'title' => 'Просмотреть непереведенное (рейтинги)',
		'href'  => "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."?check_untranslated",
		'meta'  => array(
			'title' => __('My Second Sub Menu Item'),
			'target' => '_blank',
			'class' => 'my_menu_item_class'
		),
	));
	if (get_post_type(url_to_postid('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])) == 'casino' && get_locale() == 'en_US') {
		
		$url =$_SERVER['REQUEST_URI'];
		$url = strtok($url, '?');
		
		$admin_bar->add_menu( array(
			'id'    => 'my-third-sub-item',
			'parent' => 'my-item',
			'title' => 'Перевести на польский язык',
			'href'  => "http://".$_SERVER['HTTP_HOST'].$url."?go_translate=1",
			'meta'  => array(
				'title' => __('My Second Sub Menu Item aa'),
				'target' => '_blank',
				'class' => 'my_menu_item_class'
			),
		));
	}
}


/*add_filter('acf/load_field/name=en_us_sort', function($field) {
	global $post;
	if ($field['value'] == '') {
		$field['value'] = $post->menu_order;
		update_field('languages_en_us_sort',$post->menu_order,$post->ID);
	}
	
	return $field;
});

add_filter('acf/load_field/name=fr_fr_sort', function($field) {
	global $post;
	if ($field['value'] == '') {
		$field['value'] = $post->menu_order;
		update_field('languages_fr_fr_sort',$post->menu_order,$post->ID);
	}
	
	return $field;
});


add_filter('acf/load_field/name=es_es_sort', function($field) {
	global $post;
	if ($field['value'] == '') {
		$field['value'] = $post->menu_order;
		update_field('languages_es_es_sort',$post->menu_order,$post->ID);
	}
	
	return $field;
});

add_filter('acf/load_field/name=de_de_sort', function($field) {
	global $post;
	
	if ($field['value'] == '') {
		$field['value'] = $post->menu_order;
		
		update_field( 'languages_de_de_sort', $post->menu_order, $post->ID );
	}
	
	return $field;
});*/

function wpa_show_permalinks3test( $post_link, $post ){
	if ( is_object( $post ) && $post->post_type == 'promocodes' ){
		$terms = get_term(get_field('promocode_taxonomy'),'affiliate-tags')->slug;
		$args2 = array (
			'post_type' => 'promocodes_cats',
			'tax_query' => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'slug',
					'terms'    => get_term(get_field('promocode_taxonomy'),'affiliate-tags')->slug
				)
			)
		);
		
		$promocode_category = get_posts($args2);
		$slug_url = $promocode_category[0]->post_name;
		if( $terms ){
			return str_replace( '%show_category%' , $slug_url , $post_link );
		}
	}
	return $post_link.'?';
}

add_action( 'wp_ajax_clickviber', 'clickviber' );
add_action( 'wp_ajax_nopriv_clickviber', 'clickviber' );


function clickviber() {
	$id = intval($_POST['id']);
	$field = intval(get_field('stats_showgoviber',$id)) + 1;
	update_field('stats_showgoviber',$field, $id);
	die;
}

add_action( 'wp_ajax_clicklink', 'clicklink' );
add_action( 'wp_ajax_nopriv_clicklink', 'clicklink' );


function clicklink() {
	$id = intval($_POST['id']);
	$field = intval(get_field('stats_showgo',$id)) + 1;
	update_field('stats_showgo',$field, $id);
	die;
}

add_action( 'wp_ajax_show_popupstat', 'show_popupstat' );
add_action( 'wp_ajax_nopriv_show_popupstat', 'show_popupstat' );


function show_popupstat() {
	$id = intval($_POST['id']);
	$field = intval(get_field('stats_showstats',$id)) + 1;
	update_field('stats_showstats',$field, $id);
	die;
}

add_action( 'wp_ajax_clicktelegram', 'clicktelegram' );
add_action( 'wp_ajax_nopriv_clicktelegram', 'clicktelegram' );


function clicktelegram() {
	$id = intval($_POST['id']);
	$field = intval(get_field('stats_showgotelegram',$id)) + 1;
	update_field('stats_showgotelegram',$field, $id);
	die;
}


add_action( 'wp_ajax_closepopup', 'closepopup' );
add_action( 'wp_ajax_nopriv_closepopup', 'closepopup' );


function closepopup() {
	$id = intval($_POST['id']);
	$field = intval(get_field('stats_showclosed',$id)) + 1;
	update_field('stats_showclosed',$field, $id);
	die;
}

function add_travelpayouts( $atts ){
	return '<script src="//c26.travelpayouts.com/content?promo_id=1151&shmarker=271942&trs=34014&city_from=Moscow&title=%D0%9B%D1%83%D1%87%D1%88%D0%B8%D0%B5%20%D1%86%D0%B5%D0%BD%D1%8B%20%D0%BD%D0%B0%20%D1%82%D1%83%D1%80%D1%8B&popular=true&powered_by=true" charset="utf-8"></script>';
}

add_shortcode( 'travelpayouts', 'add_travelpayouts' );


function add_credithub( $atts ){
	return '<div class="widget_credithub"><div id="credithub_widget-5f0777a68eeef"></div></div>
<script>
           (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
             try {
              new CredithubWidgetForm.init({
               color: "blue",
               id: "bc28855e-b3b3-4b43-b643-e38387bf947b",
               cpaLink: "https://api.leadcraft.ru/clicks/bc28855e-b3b3-4b43-b643-e38387bf947b",
               target: "credithub_widget-5f0777a68eeef",
              });
             } catch(e) { }
            });
            var n = d.getElementsByTagName("script")[0],
             s = d.createElement("script"),
             f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://wt.credithub.ru/form.js";
            if (w.opera == "[object Opera]") {
             d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
           })(document, window, "credithub_widget_form");
</script>';
}

add_shortcode( 'credithub', 'add_credithub' );


if ( function_exists( 'add_theme_support' ) ) add_theme_support( 'post-thumbnails' );


function youtubeshortcode( $atts ){
	$params = shortcode_atts(
		array(
			'ruru' => '',
			'enus' => '',
			'frfr' => '',
			'dede' => '',
			'eses' => '',
		),
		$atts
	);
	
	$language = get_locale();
	if ($language == 'ru_RU') {
		$video = $params[ 'ruru' ];
	}
	if ($language == 'en_US') {
		$video = $params[ 'enus' ];
	}
	
	if ($language == 'fr_FR') {
		$video = $params[ 'frfr' ];
		if ($video == '') {
			$video = $params[ 'enus' ];
		}
	}
	
	if ($language == 'de_DE') {
		$video = $params[ 'dede' ];
		if ($video == '') {
			$video = $params[ 'enus' ];
		}
	}
	
	if ($language == 'es_ES') {
		$video = $params[ 'eses' ];
		if ($video == '') {
			$video = $params[ 'enus' ];
		}
	}
	
	if ($language == 'pl_PL') {
		$video = $params[ 'plpl' ];
		if ($video == '') {
			$video = $params[ 'enus' ];
		}
	}
	
	if ($video == '') {
		return '';
	} else {
		return '<iframe src="'.$video.'" width="100%" height="355" frameborder="0" allowfullscreen="allowfullscreen"></iframe>';
	}
	
	//return '<div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question" class="schema-faq-section get-faq"><div itemprop="name" class="schema-faq-question"><span>'.$params[ 'question' ].'</span></div><div class="schema-faq-answer" itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"><span itemprop="text">'.$params[ 'answear' ].'</span></div></div>';
}

add_shortcode( 'youtubeshortcode', 'youtubeshortcode' );

function top_course( $atts ) {
	
	$params = shortcode_atts(
		array(
			'number' => ''
		),
		$atts
	);
	
	$args = array(
		'post_type' => 'casino',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'tax_query' => array(
			array(
				'taxonomy' => 'affiliate-tags',
				'field'    => 'name',
				'terms'    => 'courses',
			),
		),
	);
	$all_reviews = new WP_Query( $args );
	$count_all = $all_reviews->found_posts;
	if ($params[ 'number' ] == '') {
		return 'ТОП-'.$count_all.' '.counted_text($count_all,__('курс','er_theme'),__('курса','er_theme'),__('курсов','er_theme'));
	}
	
	//return '<a href="' . $params[ 'number' ] . '" target="_blank">' . $params[ 'anchor' ] . '</a>';
}

add_shortcode( 'top_course', 'top_course' );


add_filter( 'xmlrpc_enabled', '__return_false' );


function shortcode_feodot( $atts ) {
	$language = get_locale();
	if ($language == 'ru_RU') {
		return '<div id="feedot--quiz--17146"></div>
<!-- Загрузчик виджетов Feedot -->
<script>
    (function(f,ee,d,o,t) {
        if (ee._feedot) return;
        ee._feedot = f;
        o = d.createElement("script");
        o.src = "https://widget.info-static.ru/js/init.js?t="+(new Date().getTime());
        o.defer = true;
        d.body.appendChild(o);
    })("1c94885a3baabafe0ead07987653059d", window, document);
</script>
<!-- /Загрузчик виджетов Feedot -->';
	} else {
		return '';
	}
}

add_shortcode( 'shortcode_feodot', 'shortcode_feodot' );


function lawyertext( $atts ) {
	$language = get_locale();
	if ($language == 'ru_RU') {
		return '<h2>Бесплатная консультация юриста на eto-razvod.ru</h2>
													 Если у вас возникли проблемы с возвратом средств за бронирование, которые администрация не может решить, обратитесь за помощью к юристам. Заполните форму ниже и получите квалифицированную помощь бесплатно на нашем сайте. Ответьте всего на 3 вопроса, и юрист свяжется с вами с готовым решением. Также получить бесплатную консультацию можно в онлайн-чате, который находится в левом углу этой страницы.
';
	} else {
		return '';
	}
}

add_shortcode( 'lawyertext', 'lawyertext' );


if ( ! function_exists( 'get_b_table_f' ) ) {
	add_action( 'wp_ajax_get_b_table_f', 'get_b_table_f' );
	add_action( 'wp_ajax_nopriv_get_b_table_f', 'get_b_table_f' );
	function get_b_table_f() {
		
		$tag = intval($_POST['tag']);
		$post_id = intval($_POST['id']);
		$type = intval($_POST['type']);
		/*$term_object = get_term( $tag );
		$slug = $term_object->slug;*/
		
		$tag_broker_get = get_field('tag_broker_get','term_'.$tag);
		$term_object = get_term( $tag_broker_get );
		$slug = $term_object->slug;
		$widget_text = get_field('widget_text','term_'.$tag);
		$widget_text_desc = get_field('widget_text_desc','term_'.$tag);
		
		$bonustable = do_shortcode('[bonustable num=5 orderby="menu_order" tag="'.$slug.'" version="6" type="short" idpost="'.$post_id.'"]');
		
		if( strlen( $bonustable ) ) {
			echo '<h2 style="text-align: center;" class="asfasf'.$post_id.'"><span>'.$widget_text.'</span></h2><p style="text-align: center;"><strong>'.$widget_text_desc.'</strong><br></p>'.$bonustable;
		}
		
		die;
	}
}

// Подгрузка списка компаний на странице редактирования новостей
if ( is_admin() ) {
	
	global $pagenow;
	
	if( ( $pagenow == 'post.php' ) || (get_post_type() == 'post') ) {
		
		function acf_load_news_for_company_id_field_choices( $field ) {
			
			global $post, $wpdb;
			
			// reset choices
			$field['choices'] = array();
			$field['choices'][''] = 'Выберите компанию';
			
			$names = $wpdb->get_results( "SELECT pm.post_id, pm.meta_value AS company_name FROM $wpdb->postmeta AS pm, $wpdb->posts AS p WHERE pm.meta_key = 'company_name' AND pm.post_id=p.ID AND p.post_type='casino' AND p.post_status='publish' ORDER BY pm.meta_value ASC" );
			
			foreach( $names as $name ) {
				
				//if( strlen( $name->company_name ) )
				{
					$field['choices'][ $name->post_id ] = $name->company_name . ' (' . $name->post_id . ')';
				}
				
			}
			
			return $field;
			
		}
		
		add_filter('acf/load_field/name=news_for_company_id', 'acf_load_news_for_company_id_field_choices');
		
		
	}
	
}

// Подключаем шаблон новостей компаний для адресов типа /review/[CASINO_POST_TYPE_SLUG]/news
add_filter( 'template_include', 'news_page_template', 10 );
function news_page_template( $template ) {
	
	// inc/addons/news.php
	return get_template_for_company_news( $template );
	
}

add_filter( 'the_content', 'remove_category_blog', 99 );
function remove_category_blog( $content ) {
	return str_replace( 'category/blog/', 'blog/', $content );
}

// Меняем язык из формы ru_RU на ru для SEO в <html lang>
add_filter( 'language_attributes', function( $output ) {
	
	$output_lang = explode( '-', $output );
	
	if( isset( $output_lang[0] ) ) {
		
		$output = $output_lang[0] . '"';
		
	}
	
	return $output;
	
} );

// Удаляем лишние hreflang от плагина TranslatePress
add_filter('trp_hreflang', 'trpc_change_hreflang', 10, 2 );
function trpc_change_hreflang( $hreflang, $language ){
	
	$output_lang = explode( '-', $hreflang );
	
	if( isset( $output_lang[0] ) ) {
		
		$hreflang = $output_lang[0];
		
	}
	
	return $hreflang;
	
}

add_action( 'wp_ajax_translate_by_ajax', 'translate_by_ajax' );
add_action( 'wp_ajax_nopriv_translate_by_ajax', 'translate_by_ajax' );


function translate_by_ajax() {
	$text = $_POST['text'];
	$id = intval($_POST['id']);
	//$message = trp_translate($text, 'pl_PL',true);
	
	$url = 'https://revieweek.com/?p='.$id;
	$content = file_get_contents($url);
	$first_step = explode( 'id="get_con">' , $content );
	$second_step = explode("<city>" , $first_step[1] );
	$raised = trim($second_step[0]);
	$message = trp_translate($raised, 'pl_PL',true);
	
	$row = array(
		'translation_language' => 'pl_PL',
		'translation_content' => $message
	);
	
	add_row('translations', $row,$id);
	die();
	
}

