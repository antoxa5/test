<?php
////
include_once(TEMPLATEPATH .'/inc/addons/navs/navs.php');
include_once(TEMPLATEPATH .'/inc/post_types.php');
include_once(TEMPLATEPATH .'/inc/addons/comments.php');
include_once(TEMPLATEPATH .'/inc/addons/redirects.php');
include_once(TEMPLATEPATH .'/inc/addons/popups.php');
include_once(TEMPLATEPATH .'/inc/addons/breadcrumbs/breadcrumbs.php');
include_once(TEMPLATEPATH .'/inc/addons/cookies.php');
include_once(TEMPLATEPATH .'/inc/addons/recent.php');
include_once(TEMPLATEPATH .'/inc/addons/subscribe.php');
include_once(TEMPLATEPATH .'/inc/addons/bookmark.php');
include_once(TEMPLATEPATH .'/inc/addons/blocks.php');
include_once(TEMPLATEPATH .'/inc/addons/contents.php');
include_once(TEMPLATEPATH .'/inc/options.php');
include_once(TEMPLATEPATH .'/inc/addons/fields/repeater.php');
include_once(TEMPLATEPATH .'/inc/addons/fields/simple.php');
include_once(TEMPLATEPATH .'/inc/addons/rating/rating.php');
include_once(TEMPLATEPATH .'/inc/addons/table/table.php');
include_once(TEMPLATEPATH .'/inc/addons/profile_functions.php');
include_once(TEMPLATEPATH .'/inc/addons/seo/custom-seo-options.php');
include_once(TEMPLATEPATH .'/inc/addons/user_functions.php');

wp_enqueue_style('style', get_template_directory_uri() . '/style.css');

if (!function_exists('live_search')) {
	function live_search($id) {
		$result = '';
		$result .= '<form method="post" action="'.admin_url('admin-ajax.php').'" class="live_search" id="'.$id.'">';
			$result .= '<input type="text" name="s" />';
			$result .= '<div class="input_container">';
				$result .= '<span class="placeholder color_light_gray">'.__('Начните вводить название компании, например','er_theme').'</span>';
				$result .= '<span class="example color_dark_gray">'.__('Финам','er_theme').'</span>';
			$result .= '</div>';
			$result .= '<div class="search_icon"></div>';
		$result .= '</form>';
		return $result;
	}
}
if (!function_exists('auth_class')) {
	function auth_class() {
		$result = 'not_logged_in';
		if(is_user_logged_in()) {
			$result = 'logged_in';
		}
		return $result;
	}
}

if (!function_exists('print_js_links')) {
	function print_js_links() {
		$links = array();
		$links['general'] = '<script src="'.get_template_directory_uri() . '/js/er-js.js" type="text/javascript"></script>';
		$links['events'] = '<script src="'.get_template_directory_uri() . '/js/events.js" type="text/javascript"></script>';
		$links['auth'] = '<script src="'.get_template_directory_uri() . '/js/er-auth.js" type="text/javascript"></script>';
		$links['review_tabs'] = '<script src="'.get_template_directory_uri() . '/js/review_tabs.js" type="text/javascript"></script>';
        $links['user_profile'] = '<script src="'.get_template_directory_uri() . '/js/user_profile.js" type="text/javascript"></script>';
		$links['show_block'] = '<script src="'.get_template_directory_uri() . '/js/show_block.js" type="text/javascript"></script>';
		$links['user_page'] = '<script src="'.get_template_directory_uri() . '/js/user_page.js" type="text/javascript"></script>';
		return $links;
	}
}
if (!function_exists('print_css_links')) {
	function print_css_links($data) {
		$links = array();
		$links['pre_footer'] = '<link rel="stylesheet" id="pre_footer" href="'.get_template_directory_uri() . '/css/pre_footer.css" type="text/css" media="all" />';
		$links['review_form'] = '<link rel="stylesheet" id="review_form" href="'.get_template_directory_uri() . '/css/review_form.css" type="text/css" media="all" />';
		$links['popup_forms'] = '<link rel="stylesheet" id="popup_forms" href="'.get_template_directory_uri() . '/css/popup_forms.css" type="text/css" media="all" />';
		$links['main_footer'] = '<link rel="stylesheet" id="main_footer" href="'.get_template_directory_uri() . '/css/main_footer.css" type="text/css" media="all" />';
		$links['social_icons'] = '<link rel="stylesheet" id="social_icons" href="'.get_template_directory_uri() . '/css/social_icons.css" type="text/css" media="all" />';
		$links['subscribe_form'] = '<link rel="stylesheet" id="subscribe_form" href="'.get_template_directory_uri() . '/css/subscribe_form.css" type="text/css" media="all" />';
		$links['recent_visited'] = '<link rel="stylesheet" id="recent_visited" href="'.get_template_directory_uri() . '/css/recent_visited.css" type="text/css" media="all" />';
		$links['fast_links'] = '<link rel="stylesheet" id="fast_links" href="'.get_template_directory_uri() . '/css/fast_links.css" type="text/css" media="all" />';
		$links['review_links'] = '<link rel="stylesheet" id="review_links" href="'.get_template_directory_uri() . '/css/review_links.css" type="text/css" media="all" />';
		$links['review_icons'] = '<link rel="stylesheet" id="review_icons" href="'.get_template_directory_uri() . '/css/review_icons.css" type="text/css" media="all" />';
		$links['review_top'] = '<link rel="stylesheet" id="review_top" href="'.get_template_directory_uri() . '/css/review_top.css" type="text/css" media="all" />';
		$links['review_content'] = '<link rel="stylesheet" id="review_content" href="'.get_template_directory_uri() . '/css/review_content.css" type="text/css" media="all" />';
        $links['profile_top'] = '<link rel="stylesheet" id="profile_top" href="'.get_template_directory_uri() . '/css/profile_top.css" type="text/css" media="all" />';
		$links['show_block'] = '<link rel="stylesheet" id="show_block" href="'.get_template_directory_uri() . '/css/show_block.css" type="text/css" media="all" />';
		$links['user_page'] = '<link rel="stylesheet" id="user_page" href="'.get_template_directory_uri() . '/css/user_page.css" type="text/css" media="all" />';


		if(is_string($data)) {
			return $links[$data];
		} elseif(is_array($data)) {
			$result = '';
			foreach ($data as $item) {
				if(array_key_exists($item,$links)) {
					$result .= $links[$item];
				}
			}
			return $result;
		} else {
			return '';
		}


	}
}

if (!function_exists('user_auth')) {
	add_action( 'wp_ajax_user_auth', 'user_auth' );
	add_action( 'wp_ajax_nopriv_user_auth', 'user_auth' );
	function user_auth() {
		$result = '';
		
		if(!is_user_logged_in()) {
			$result .= '<div class="auth_button button button_green pointer">'.__('Вход','er_theme').'</div>';
			//$result .= print_js_links()['general'];
			$result .= print_js_links()['events'];
		} else {
			$result .= '<div class="user_bar">';
			//$result .= print_js_links()['general'];
				//$result .= '<div class="user_icon icon_messages"></div>';
				//$result .= '<div class="user_icon icon_notifications"></div>';
				if(function_exists('wp_get_current_user')) {
					$current_user = wp_get_current_user();
					//print_r($current_user);
					$user_id = $current_user->data->ID;
					$user_display_name = $current_user->data->display_name;
					$user_picture = get_field('photo_profile', 'user_'.$user_id );
					$user_label = get_field('photo_profile', 'user_'.$user_id );
					$user_label = get_field('services_user_services','user_'.$user_id)[0];
					$result .= '<div class="user_picture border_circle"';
					if($user_picture && $user_picture != '') {
						$result .= ' style="background-image: url('.$user_picture["sizes"]["thumbnail"].')" ';
					}
					$result .= '></div>';
					$result .= '<div class="user_name flex inactive_user_nav pointer dropdown">';
						$result .= '<span class="display_name font_bold">'.$user_display_name.'</span>';
						if($user_label && $user_label != '') {
							$result .= '<span class="user_label font_smaller">'.get_the_title($user_label).'</span>';
						}
						//$result .= '<div class="user_company">Finam</div>';
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
if (!function_exists('er_js_connect')) {
	function er_js_connect() {
		
		$h_auth_callback = h_auth_config()['callback'];
		wp_enqueue_script( 'er-js', get_template_directory_uri() . '/js/er-js.js', array('jquery') );
		wp_enqueue_script( 'events', get_template_directory_uri() . '/js/events.js', array('jquery') );
		wp_enqueue_script( 'append-ajax-content', get_template_directory_uri() . '/js/append-ajax-content.js', array('jquery') );
		if(function_exists('get_rating_fields_group')) {
			$rating_fields_group = get_rating_fields_group($post->ID);
		} else {
			$rating_fields_group = 0;
		}
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		if(is_single()) {		
		global $post;
		wp_localize_script( 'jquery', 'my_ajax_object',
				array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'current_post_id' => $post->ID, 'rating_fields_group' => $rating_fields_group, 'h_auth_callback' => $h_auth_callback,'actual_link' => $actual_link, 'user_id' => 0 ) );
		} elseif (get_query_var('user_profile') == 'user_profile') {
			wp_localize_script( 'jquery', 'my_ajax_object',
				array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'current_post_id' => $post->ID, 'rating_fields_group' => $rating_fields_group, 'h_auth_callback' => $h_auth_callback,'actual_link' => $actual_link, 'user_id' => get_query_var('user_id')   ) );
		} else {
			wp_localize_script( 'jquery', 'my_ajax_object',
				array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'current_post_id' => 0, 'rating_fields_group' => $rating_fields_group, 'h_auth_callback' => $h_auth_callback,'actual_link' => $actual_link, 'user_id' => 0 ) );
		}
		
	}
	add_action( 'wp_enqueue_scripts', 'er_js_connect' );
}

if (!function_exists('popup_nav')) {
	add_action( 'wp_ajax_popup_nav', 'popup_nav' );
	add_action( 'wp_ajax_nopriv_popup_nav', 'popup_nav' );

	function popup_nav(){
		$data = $_POST;
		$result = '';
		if($data['nav_place'] == 'header_main') {
			$result .= '<div class="bar">';
				$result .= '<div class="wrap">';
					$result .= '<div class="bar_top">';
						$result .= '<a href="'.get_bloginfo('url').'" class="logo"></a>';
				if(function_exists('live_search')) {
						$result .= live_search('bar_search');
				}
						$result .= '<div class="close_icon pointer"></div>';
					$result .= '</div>';
				if(function_exists('theme_nav')) {
					$result .= '<div class="bar_nav">';
						$result .= '<div class="bar_nav_1 bar_nav_menu">'.theme_nav('bar_1',1,'bar_1','bar_1','link_dark_blue').'</div>';
						$result .= '<div class="bar_nav_2 bar_nav_menu">'.theme_nav('bar_2',1,'bar_2','bar_2','link_dark_blue').'</div>';
						$result .= '<div class="bar_nav_3 bar_nav_menu">'.theme_nav('bar_3',1,'bar_3','bar_3','link_dark_blue').'</div>';
						$result .= '<div class="bar_nav_4 bar_nav_menu">'.theme_nav('bar_4',1,'bar_4','bar_4','link_dark_blue').'</div>';
						$result .= '<div class="bar_nav_5 bar_nav_menu">'.theme_nav('bar_5',1,'bar_5','bar_5','link_dark_blue').'</div>';
						$result .= '<div class="bar_nav_6 bar_nav_menu">'.theme_nav('bar_6',1,'bar_6','bar_6','link_dark_blue').'</div>';
					$result .= '</div>';
				}
				$result .= '</div>';
			$result .= '</div>';
			
			echo '
			<script src="'.get_template_directory_uri() . '/js/er-js.js" type="text/javascript"></script>
			<script type="text/javascript">
				$ = jQuery.noConflict();
				$(document).ready(function() { 
					$(\'.close_icon\').click(function() {
						$(\'.bar\').remove();
					});

				});
			</script>
			';
		} elseif($data['nav_place'] == 'header_services') {
			$result .= '<div class="services_list box_shadow_down font_smaller">';
				$result .= '<a href="'.get_bloginfo('url').'/add-company-2/" class="link_no_underline link_dark_blue flex flex_column"><i class="icon_service_company"></i><span>'.__('Разместить компанию','er_theme').'</span></a>';
				$result .= '<a href="'.get_bloginfo('url').'/abuse/" class="link_no_underline link_dark_blue flex flex_column"><i class="icon_service_abuse"></i><span>'.__('Оставить жалобу','er_theme').'</span></a>';
				$result .= '<a href="'.get_bloginfo('url').'/advertise/" class="link_no_underline link_dark_blue flex flex_column"><i class="icon_service_advertise"></i><span>'.__('Разместить рекламу','er_theme').'</span></a>';
				$result .= '<a href="'.get_bloginfo('url').'/reviews/" class="link_no_underline link_dark_blue flex flex_column"><i class="icon_service_review"></i><span>'.__('Написать отзыв','er_theme').'</span></a>';
			$result .= '</div>';
		}
		echo $result;
		die;
	}
}

if (!function_exists('popup_reg')) {
	add_action( 'wp_ajax_popup_reg', 'popup_reg' );
	add_action( 'wp_ajax_nopriv_popup_reg', 'popup_reg' );

	function popup_reg(){
		$result = '';
		$result .= '<div class="popup_container" id="popup_reg">';
			$result .= '<div class="popup_window box_shadow">';
			$result .= '<div class="popup_close_button pointer"></div>';
				$result .= '<div class="popup_columns two_columns">';
					$result .= '<div class="popup_column_left flex_column align_left flex_padding">';
						$result .= '<div class="title font_big color_dark_blue font_bold m_b_20">'.__('Регистрация','er_theme').'</div>';
						$result .= '<form class="regform flex flex_column"  action="'.admin_url( 'admin-ajax.php' ).'" method="post" id="popup_reg_form">';
						$result .= '<input type="hidden" name="action" value="user_registration" />';
						$result .= '<input type="email" name="email" placeholder="'.__('Ваш E-mail','er_theme').'" class="input_big m_b_10 placeholder_dark">';
						$result .= '<div class="input_columns">';
							$result .= '<input type="text" name="firstname" placeholder="'.__('Имя','er_theme').'" class="input_big m_b_10 placeholder_dark">';
							$result .= '<input type="text" name="lastname" placeholder="'.__('Фамилия','er_theme').'" class="input_big m_b_10 placeholder_dark">';
						$result .= '</div>';
						$result .= '<input type="password" name="password" placeholder="'.__('Пароль','er_theme').'" class="input_big m_b_10 placeholder_dark">';
						$result .= '<input type="password" name="password_repeat" placeholder="'.__('Повторите пароль','er_theme').'" class="input_big m_b_10 placeholder_dark">';
						$result .= '<input type="submit" name="submit" class="button button_big button_violet m_b_10 pointer" value="'.__('Зарегистрироваться','er_theme').'" id="regbtn">';
						$result .= '<div class="link_container"><span class="span_link link_terms_popup color_blue pointer">'.__('Условия пользования сайтом','er_theme').'</span></div>';
						$result .= '</form>';
					$result .= '</div>';
					$result .= '<div class="popup_column_right flex_column align_left">';
						$result .= '<div class="row_border_bottom flex_row flex_padding">';
							$result .= '<div class="title color_dark_blue font_bold m_b_20">'.__('Используйте сервисы для входа','er_theme').'</div>';
							$result .= social_login_icons('full');
						$result .= '</div>';
						$result .= '<div class="flex_row flex_padding">';
							$result .= '<div class="title color_dark_blue font_bold m_b_20">'.__('У вас уже есть аккаунт?','er_theme').'</div>';
							$result .= '<div class="button button_big button_green m_b_10 pointer auth_link">'.__('Войти в мой аккаунт','er_theme').'</div>';
							$result .= '<div class="link_container"><span class="span_link link_recover_popup color_blue pointer">'.__('Восстановить пароль','er_theme').'</span></div>';
						$result .= '</div>';
					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}

if (!function_exists('popup_auth')) {
	add_action( 'wp_ajax_popup_auth', 'popup_auth' );
	add_action( 'wp_ajax_nopriv_popup_auth', 'popup_auth' );

	function popup_auth(){
		$result = '';
		$result .= print_js_links()['auth'];
		$result .= '<div class="popup_container" id="popup_auth">';
			$result .= '<div class="popup_window box_shadow">';
			$result .= '<div class="popup_close_button pointer"></div>';
				$result .= '<div class="popup_columns two_columns">';
					$result .= '<div class="popup_column_left flex_column align_left flex_padding">';
						$result .= '<div class="title font_big color_dark_blue font_bold m_b_20">'.__('Вход','er_theme').'</div>';
						$result .= '<form class="regform flex flex_column"  action="'.admin_url( 'admin-ajax.php' ).'" method="post" id="popup_auth_form">';
						$result .= '<input type="hidden" name="action" value="user_login" />';
						$result .= '<input type="text" name="email" placeholder="'.__('Ваш E-mail','er_theme').'" class="input_big m_b_10 placeholder_dark">';
						$result .= '<input type="password" name="password" placeholder="'.__('Пароль','er_theme').'" class="input_big m_b_10 placeholder_dark">';
						$result .= '<div class="checkbox_container m_b_10">';
                        	$result .= '<input type="checkbox" id="remember__input" name="remember" checked="checked">';
                            $result .= '<label for="remember__input">'.__('Запомнить меня','er_theme').'</label>';
                        $result .= '</div>';
						$result .= '<input type="submit" name="submit" class="button button_big button_green m_b_10 pointer" value="'.__('Войти','er_theme').'" id="regbtn">';
						$result .= '<div class="link_container"><span class="span_link link_recover_popup color_blue pointer">'.__('Восстановить пароль','er_theme').'</span></div>';
						$result .= '</form>';
					$result .= '</div>';
					$result .= '<div class="popup_column_right flex_column align_left">';
						$result .= '<div class="row_border_bottom flex_row flex_padding">';
							$result .= '<div class="title color_dark_blue font_bold m_b_20">'.__('Используйте сервисы для входа','er_theme').'</div>';
							$result .= social_login_icons('full');
						$result .= '</div>';
						$result .= '<div class="flex_row flex_padding">';
							$result .= '<div class="title color_dark_blue font_bold m_b_20">'.__('У вас еще нет аккаунта?','er_theme').'</div>';
							$result .= '<div class="button button_big button_violet m_b_10 pointer reg_link">'.__('Создать аккаунт','er_theme').'</div>';
							$result .= '<div class="link_container"><span class="span_link link_terms_popup color_blue pointer">'.__('Условия пользования сайтом','er_theme').'</span></div>';
						$result .= '</div>';
					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}
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
			$args = array('s' => $_POST['s'], 'posts_per_page' => -1,'post_type'=>'casino');

			$the_query = new WP_Query( $args );

			$result .= '<div class="search_results">';
					$result .= '<div class="wrap">';

					if ( $the_query->have_posts() ) { 
					$count = $the_query->found_posts;
					$result .= '<div class="search_results_count"><span class="font_bold color_dark_gray">'.__('Результат поиска:','er_theme').'</span> <span class="color_dark_blue">'.$count.'</span></div>';
					$result .= '<div class="search_results_content">';
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							$result .= '<div class="flex m_t_15">';
							$company_name = get_field('company_name',$post->ID);
							if(!$company_name || $company_name == '') {
								$company_name = get_the_title();
							}
							$result .= '<a href="'.get_the_permalink($post->ID).'" class="link_no_underline color_dark_blue font_bold">'.$company_name.'</a>';
							/*$result .= review_logo($post->ID);
							$company_name = get_field('company_name',$post->ID);
							if(!$company_name || $company_name == '') {
								$company_name = get_the_title();
							}
							$result .= '<a href="'.get_the_permalink($post->ID).'" class="link_no_underline color_dark_blue font_big font_bold">'.$company_name.'</a>';
							if(function_exists('get_rating_fields_group')) {
								$rating_fields_group = get_rating_fields_group($post->ID);
							} else {
								$rating_fields_group = 0;
							}
							$result .= get_post_stars($rating_fields_group);
							$result .= review_top_rating($post->ID);
							*/$result .= '</div>';
						}
					$result .= '</div>';
					} else {
						 $result .= '<div class="search_results_count">'.__('Материалы по Вашему запросу не найдены','er_theme').'</div>';
					}

					$result .= '<div class="search_results_banner">';
					$result .= '</div>';
				$result .= '</div>';

			$result .= '</div>';
		}
		echo $result;
		die;
	}
}

if (!function_exists('user_login')) {
	
	add_action( 'wp_ajax_user_login', 'user_login' );
	add_action( 'wp_ajax_nopriv_user_login', 'user_login' );

	function user_login(){
		$data = $_POST;
		//print_r($data);
		$result = array();
		$login_data = array();  
		$login_data['user_login'] = $data['email'];
		$login_data['user_password'] = $data['password']; 
		$remember = $data['remember'];
		if ($remember == 'on') {
			$login_data['remember'] = true;
		} else {
			$login_data['remember'] = false;
		}


		$user_verify = wp_signon( $login_data, true ); 
		if ( is_wp_error( $user_verify ) ) {
				$result['status'] = 'error';
				$result['message'] = $user_verify->get_error_message();
			} else {
				$result['status'] = 'ok';
				$result['message'] = 'ok';
			}
		echo json_encode($result);
		die;

	}

}

if (!function_exists('pre_footer')) {
	add_action( 'wp_ajax_pre_footer', 'pre_footer' );
	add_action( 'wp_ajax_nopriv_pre_footer', 'pre_footer' );
	function pre_footer(){
		$result = '';
        $recent_viewed = recent_viewed();
        if($recent_viewed && $recent_viewed != 'none') {
            $result .= $recent_viewed;
        }
		$result .= '<div class="pre_footer">';
		$result .= print_css_links('pre_footer');
			$result .= '<div class="wrap">';
				$result .= '<div class="pre_footer_text font_medium color_dark_blue line_big"><span class="font_bold">'.__('Эторазвод.ру','er_theme').'</span>'.__(' &mdash; это крупный информационный сервис обзоров и отзывов о российских компаниях. Наш сервис позволяет размещать жалобы, отзывы и обзоры на различные компании.','er_theme').'</div>';
				$result .= '<div class="pre_footer_image"></div>';
			$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}

if (!function_exists('recent_visited')) {
	add_action( 'wp_ajax_recent_visited', 'recent_visited' );
	add_action( 'wp_ajax_nopriv_recent_visited', 'recent_visited' );
	function recent_visited(){
		$result = '';
		$result .= print_css_links('recent_visited');
		$result .= '<div class="recent_visited">';
			$result .= '<div class="wrap">';
				$result .= '<div class="recent_title uppercase font_bold">'.__('Вы недавно смотрели','er_theme').'</div>';
				$result .= '<div class="recent_content"></div>';
			$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}

if (!function_exists('user_registration')) {
	
	add_action( 'wp_ajax_user_registration', 'user_registration' );
	add_action( 'wp_ajax_nopriv_user_registration', 'user_registration' );

	function user_registration(){
		$data = $_POST;
		//print_r($data);
		$result = array();
		$errors = array();
		$last_id_user = get_field('last_id_user', 'option');
		$last_id_userToUpdate = intval($last_id_user) + 1;
		$login = 'id'.$last_id_userToUpdate;
		if($data['password'] && $data['password'] != '' && $data['password_repeat'] && $data['password_repeat'] != '') {
			if($data['password'] != $data['password_repeat']) {
				$errors[] = __('Введенные пароли не совпадают','er_theme');
			} 
		} else {
			if(!$data['password'] || $data['password'] == '') {
				$errors[] = __('Введите пароль','er_theme');
			}
			if(!$data['password_repeat'] || $data['password_repeat'] = '') {
				$errors[] = __('Введите повтор пароля','er_theme');
			}
		}
		if(!$data['email'] || $data['email'] == '') {
			$errors[] = __('Укажите E-mail','er_theme');
		}
		if(!$data['firstname'] || $data['firstname'] == '') {
			$errors[] = __('Укажите Имя','er_theme');
		}
		if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
		} else {
			if($data['email'] && $data['email'] != '') {
				$errors[] = __('Email-адрес некорректен','er_theme');
			}
		}
		if ( email_exists($data['email']) ) {
			if($data['email'] && $data['email'] != '') {
				$errors[] = __('Пользователь с таким email уже зарегистрирован','er_theme');
			}
		}
		if(!empty($errors)) {
			$result['status'] = 'error';
			$result['message'] = '';
			$result['message'] .= '<ul>';
			foreach($errors as $error) {
				$result['message'] .= '<li>'.$error.'</li>';
			}
			$result['message'] .= '</ul>';
		} else {
			$userdata = array(
				'user_login' => $login,
				'user_nicename' => $login,
				'user_pass' => $data['password'],
				'user_email' => $data['email'],
				'remember' => true
			);
			if($data['firstname'] && $data['firstname'] != '') {
				$userdata['first_name'] = $data['firstname'];
			}
			if($data['lastname'] && $data['lastname'] != '') {
				$userdata['last_name'] = $data['lastname'];
			}
			if($data['firstname'] && $data['firstname'] != '' && $data['lastname'] && $data['lastname'] != '') {
				$userdata['display_name'] = $data['firstname'].' '.$data['lastname'];
			} elseif($data['firstname'] && $data['firstname'] != '' && !$data['lastname']) {
				$userdata['display_name'] = $data['firstname'];
			} elseif(!$data['firstname'] && $data['lastname'] && $data['lastname'] != '') {
				$userdata['display_name'] = $data['lastname'];
			} else {
				$userdata['display_name'] = $data['email'];
			}
			$user_id = wp_insert_user( $userdata );
			if( is_wp_error( $user_id  ) ) {
				$result['status'] = 'error';
				$result['message'] = $user_id->get_error_message();
			} else {
				//echo $user_id;
				$key = wp_generate_uuid4();
				update_field('last_id_user', $last_id_userToUpdate, 'option');
				update_field('key_activation', $key, 'user_'.$user_id);
				$user_id_role = new WP_User($user_id);
				$user_id_role->set_role('registereduser');
				wp_set_current_user ( $user_id );
				wp_set_auth_cookie  ( $user_id );
				if ($_COOKIE["_ym_uid"]) {
				  $timervop = htmlspecialchars($_COOKIE["_ym_uid"]);
				  update_field('client_id_yandex', $timervop, 'user_'.$user_id);
				}
				$result['status'] = 'ok';
				$result['message'] = __('Вы успешно зарегистрировались с E-mail адресом:','er_theme').' '.$data['email'].' '.__('Ваш пароль:','er_theme').' '.$data['password'];
				$result['user_id'] = $user_id;
			}
			
		}
		
		print_r(json_encode($result));
		die;

	}

}

if (!function_exists('main_footer')) {
	add_action( 'wp_ajax_main_footer', 'main_footer' );
	add_action( 'wp_ajax_nopriv_main_footer', 'main_footer' );
	function main_footer(){
		$result = '';
		$result .= '<div class="main_footer">';
			$result .= fast_links('footer_fast_links');
		$result .= print_css_links(array('main_footer','social_icons','subscribe_form','fast_links'));
			$result .= '<div class="wrap height_footer">';
				$result .= '<div class="main_footer_navs">';
					$result .= '<div class="foo_nav">';
						$result .= '<div class="menu_title color_dark_blue font_bold font_small font_uppercase">'.__('Сообщество','er_theme').'</div>';
						$result .= theme_nav('foo_1',0,'foo_1','foo_1','link_dark_blue');
					$result .= '</div>';
					$result .= '<div class="foo_nav">';
						$result .= '<div class="menu_title color_dark_blue font_bold font_small font_uppercase">'.__('О нас','er_theme').'</div>';
						$result .= theme_nav('foo_2',0,'foo_2','foo_2','link_dark_blue');
					$result .= '</div>';
					$result .= '<div class="foo_nav">';
						$result .= '<div class="menu_title color_dark_blue font_bold font_small font_uppercase">'.__('Для компаний','er_theme').'</div>';
						$result .= theme_nav('foo_3',0,'foo_3','foo_3','link_dark_blue');
					$result .= '</div>';
				$result .= '</div>';
				$result .= '<div class="main_footer_right">';
					$result .= subscribe_form('footer_subscribe');
					$result .= social_networks();
				$result .= '</div>';
			$result .= '</div>';
			$result .= '<div class="footer_bottom_nav">';
				$result .= '<div class="wrap">';
					$result .= theme_nav('footer_bottom',0,'footer_bottom','footer_bottom','link_dark_blue font_small link_underline');
				$result .= '</div>';
			$result .= '</div>';
			$result .= '<div class="copyrights font_small color_dark_blue">';
				$result .= '<div class="wrap">';
				$result .= __('&copy; Copyright 2015&mdash;','er_theme').date('Y').__(' &laquo;Это развод™&raquo;','er_theme');
				$result .= '</div>';
			$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}

if (!function_exists('subscribe_form')) {
	function subscribe_form($id) {
		$result = '';
		$result .= '<div class="subscribe_form">';
		$result .= '<div class="menu_title color_dark_blue font_bold font_small font_uppercase">'.__('Подписаться на рассылку','er_theme').'</div>';
		$result .= '<form method="post" action="'.admin_url('admin-ajax.php').'" id="'.$id.'">';
			$result .= '<input type="text" placeholder="'.__('Ваш E-mail','er_theme').'" />';
			$result .= '<input type="submit" class="button button_green button_medium  button_zero_radius" value="'.__('Подписаться','er_theme').'" />';
		$result .= '</form>';
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('social_networks')) {
	function social_networks() {
		$result = '';
		$result .= '<div class="social_networks">';
		$result .= '<div class="menu_title color_dark_blue font_bold font_small font_uppercase">'.__('Мы в социальных сетях','er_theme').'</div>';
		$result .= '<ul>';
			$result .= '<li><a href="https://www.youtube.com/channel/UCibinJburN_Qe9w4r04SdeQ" target="_blank" class="social_icon_youtube"></a></li>';
			$result .= '<li><a href="https://vk.com/etorazvod" target="_blank" class="social_icon_vk"></a></li>';
			$result .= '<li><a href="https://ok.ru/etorazvod" target="_blank" class="social_icon_odnoklassniki"></a></li>';
			$result .= '<li><a href="https://zen.yandex.ru/id/5c066820817f780400714af2" target="_blank" class="social_icon_yandex"></a></li>';
			$result .= '<li><a href="https://www.pinterest.ru/etorazvod/" target="_blank" class="social_icon_pinterest"></a></li>';
			$result .= '<li><a href="https://twitter.com/etorazvodru" target="_blank" class="social_icon_twitter"></a></li>';
			$result .= '<li><a href="https://www.instagram.com/etorazvod.ru/" target="_blank" class="social_icon_instagram"></a></li>';
		$result .= '</ul>';
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('fast_links')) {
	function fast_links($id) {
		$result = '';
		$result .= '<div class="fast_links" id="'.$id.'">';
			$result .= '<div class="wrap">';
				$result .= '<div class="fast_links_link font_uppercase color_dark_blue font_bold pointer">'.__('Быстрые ссылки','er_theme').'</div>';
				$result .= '<div class="fast_links_description font_small color_dark_gray">'.__('Изучите популярные категории','er_theme').'</div>';
			$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('review_breadcrumbs')) {
	function review_breadcrumbs($post_id) {
		$result = '';
		$result .= '<div class="review_breadcrumbs color_medium_gray font_smaller">';
		$result .= '<span>zdes budut hlebnye kkroshki</span>';
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('review_main')) {
	function review_main($post_id) {
		$result = '';
		$result .= '<div class="review_main">';
		$company_title = get_field('company_name',$post_id);
		if($company_title && $company_title != '') {
			$result .= '<div class="review_company_title font_bold font_big color_dark_blue">'.$company_title.'</div>';
		}
		if(function_exists('get_rating_fields_group')) {
			$rating_fields_group = get_rating_fields_group($post->ID);
		} else {
			$rating_fields_group = 0;
		}
			$result .= '<div class="stars_and_reviews flex">';
				$result .=  get_post_stars($rating_fields_group);
				$result .= '<div class="stars_and_reviews_counts flex flex_column m_l_15 font_small line_big">';
					$reviews_count = get_field('reviews_count_reviews',$post->ID);
					if(!$reviews_count || $reviews_count == '') {
						$reviews_count = 0;
					}
					if($reviews_count) {
						$result .= '<div class="reviews_count_reviews"><span class="color_dark_blue">'.$reviews_count.'</span> <span class="color_dark_gray">'.counted_text($reviews_count,__('отзыв','er_theme'),__('отзыва','er_theme'),__('отзывов','er_theme')).'</span></div>';
					} else {
						$result .= '<div class="reviews_count_reviews"><span class="color_dark_gray">'.__('Еще нет отзывов','er_theme').'</span></div>';
					}
					$abuses_count = get_field('reviews_count_abuses',$post->ID);
					if(!$abuses_count || $abuses_count == '') {
						$abuses_count = 0;
					}
					if($abuses_count) {
						$result .= '<div class="reviews_count_reviews"><span class="color_dark_blue">'.$abuses_count.'</span> <span class="color_dark_gray">'.counted_text($abuses_count,__('жалоба','er_theme'),__('жалобы','er_theme'),__('жалоб','er_theme')).'</span></div>';
					} else {
						$result .= '<div class="reviews_count_abuses"><span class="color_dark_gray">'.__('Еще нет жалоб','er_theme').'</span></div>';
					}	
				$result .= '</div>';
			$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}

if(!function_exists('review_top_rating')) {
	function review_top_rating($post_id) {
		$result = '';
		$system_rating = get_field('reviews_rating_average',$post_id);
		if(!$system_rating || $system_rating == '') {
			$system_rating = 0;
		}
		$data_percent = 100 / 5 * $system_rating / 100;
		$result .= '<div class="rating_page_text review_average_round progress" id="rating_list_item_'.$post_id.'" data-percent="'.$data_percent.'">';
		$result .= '<span class="inner color_dark_blue font_bold font_big">'.$system_rating.'</span>';
		$result .=  '</div>';
		return $result;
	}
}

if (!function_exists('review_card')) {
	function review_card($post_id) {
		$result = '';
		$er_company_site_str = get_field('websites',$post_id)[0]['site_url'];
		$verified = get_field('company_verified_status',$post_id);
		if($verified || $er_company_site_str && $er_company_site_str != '') {
			$result .= '<div class="review_card">';
			if($verified) {
				$result .= '<div class="company_status status_verified color_dark_gray">'.__('Подтвержденная компания','er_theme').'</div>';
			}

			if($er_company_site_str && $er_company_site_str != '') {
					$er_company_site_str_2 = preg_replace('#^[^:/.]*[:/]+#i', '', $er_company_site_str);
					$site = preg_replace('/^www\./', '', rtrim($er_company_site_str_2,'/'));
				$result .= '<div class="company_site">';
					$result .= '<a class="site_url font_bold color_dark_blue font_big" target="_blank">'.$site.'</a>';
					$result .= '<span class="font_smaller color_medium_gray">'.__('Перейти на сайт','er_theme').'</span>';
				$result .= '</div>';
			}
			$result .= '</div>';
		}
		return $result;
	}
}


if (!function_exists('review_logo')) {
	function review_logo($post_id) {
		$result = '';
		$result .= '<div class="review_logo"';
		$logo = get_field('company_logo',$post_id);
		$logo_bg = get_field('company_icon_bg',$post_id);
		if($logo_bg && $logo_bg != '') {
			$bg = ' background-color:'.$logo_bg.';';
		} else {
			$bg = '';
		}
		if($logo && !empty($logo)) {
			$result .= ' style="background-image:url('.$logo['sizes']['large'].');'.$bg.'"';
		}
		$result .= '></div>';
		return $result;
	}
}

if (!function_exists('review_icon')) {
    function review_icon($post_id) {
        $result = '';
        $result .= '<div class="review_icon"';
        $logo = get_field('company_icon',$post_id);
        $logo_bg = get_field('company_icon_bg',$post_id);
        if($logo_bg && $logo_bg != '') {
            $bg = ' background-color:'.$logo_bg.';';
        } else {
            $bg = '';
        }
        if($logo && !empty($logo)) {
            $result .= ' style="background-image:url('.$logo['sizes']['large'].');'.$bg.'"';
        }
        $result .= '></div>';
        return $result;
    }
}

if(!function_exists('review_redirect_link')) {
	function review_redirect_link($post_id) {
		$result = '';
		$key = get_field('company_redirect_key',$post_id);
		if($key && $key != '') {
			$result .= get_bloginfo('url').'/visit/'.$key.'/';
		}
		return $result;
	}
}

if (!function_exists('review_top')) {
	function review_top($post_id) {
		$result = '';
		$result .= print_css_links('review_top');
		$result .= '<div class="review_header">';
			$result .= '<div class="wrap">';
			if (function_exists('show_breadcrumbs')) {
				$result .= show_breadcrumbs();
			}
			if (function_exists('review_logo')) {
				$result .= review_logo($post_id);
			}
			if (function_exists('review_main')) {
				$result .= review_main($post_id);
			}
			$result .= '<div class="review_top_rating_container flex flex_column">';
			if(function_exists('review_top_rating')) {
				$result .= review_top_rating($post_id);
			}
			$result .= '</div>';
			if (function_exists('review_card')) {
				$result .= review_card($post_id);
			}
			if (function_exists('review_bar')) {
				$result .= review_bar();
			}
			$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('page_top')) {
	function page_top($post_id,$type) {
		$result = '';
		$result .= '<div class="page_header">';
			$result .= '<div class="wrap">';

				$result .= '<div class="page_heading_line">';
        if($type == 'promocodes_cat') {
            $result .= show_breadcrumbs();
        }
					$icon_color = get_field('template_rating_icon_color',$post_id);
					if(!$icon_color || $icon_color == '') {
						$icon_color = '#5427ab';
					}
                if($type == 'promocodes_cat') {

                    $tag = get_field('affiliate_tag',$post_id);
                    if($tag) {
                        $term_title = get_field('tag_human_title', 'term_' . $tag);
                    }
                    if($term_title && $term_title != '') {
                        $title = '<span class="m_right_10">'.__('Рубрика:','er_theme').'</span><span class="color_violet dropdown pointer flex link_change_promocode_cat">'.$term_title.'</span>';
                    } else {
                        $title = get_the_title();
                    }
                } else {
                    $title = get_the_title();
                }

					if($type == 'rating') {
						$result .= '<div class="rating_icon border_circle font_big font_uppercase" style="background-color:'.$icon_color.';">'.$title[0].'</div>';
					}
					$result .= '<h1 class="color_dark_blue flex">'.$title.'</h1>';
				$result .= '</div>';
			$result .= '</div>';
			if($type == 'rating') {
				$tag_term = get_term( get_field('rating_tag',$post_id), 'affiliate-tags' );
				$tag = $tag_term->slug;
				$term_id = get_term_by('name', $tag, 'affiliate-tags')->term_id;
				if(get_field('tags_rating_inherit','term_'.$term_id)) {
					$custom_table = get_field_object('tags_recommended_fields_rating_new','term_'.get_field('tags_rating_inherit','term_'.$term_id));
				} else {
					$custom_table = get_field_object('tags_recommended_fields_rating_new','term_'.$term_id);
				}
				$table_1 = generate_table_fields($custom_table,'full');
					if(!empty($table_1)) {
						$result .= '<div class="rating_header font_uppercase font_bold font_smaller color_dark_gray" data-tag="'.$tag.'">';
							$result .= '<div class="wrap">';
								$result .= '<div class="rating_th rating_field_number sort pointer sort_default" data-rating-field="number">'.__('Место').'</div>';
								foreach($table_1['th'] as $item) {
									if($item['sort'] == 1) {
										$sort = ' sort pointer sort_default';
									} else {
										$sort = '';
									}
									if('system_count_good' == $item['field_name']) {
										$result .= '<div class="rating_th rating_field_'.$item['field_name'].$sort.'" data-rating-field="'.$item['field_name'].'"><span class="thumb_up"></span></div>';
									} elseif('system_count_bad' == $item['field_name']) {
										$result .= '<div class="rating_th rating_field_'.$item['field_name'].$sort.'" data-rating-field="'.$item['field_name'].'"><span class="thumb_down"></span></div>';
									} else {
										$result .= '<div class="rating_th rating_field_'.$item['field_name'].$sort.'" data-rating-field="'.$item['field_name'].'">'.$item['value'].'</div>';
									}
								}
								
								
								
							$result .= '</div>';
						$result .= '</div>';
					}
				} elseif($type == 'promocodes_cat') {
                $result .= '<div class="promocodes_header" data-tag="'.$tag.'">';
                $result .= '<div class="wrap">';
                $result .= '<div class="list_promocodes_top flex">';
                $result .= '<ul class="list_promocodes_tabs flex font_small font_uppercase color_dark_gray font_bold">';
                $result .= '<li class="active color_dark_blue" data-type="all">'.__('Все','er_theme').'</li>';
                $result .= '<li data-type="promocodes">'.__('Промокоды','er_theme').'</li>';
                $result .= '<li data-type="coupons">'.__('Купоны','er_theme').'</li>';
                $result .= '</ul>';
                $result .= '<ul class="list_promocodes_styler flex">';
                $result .= '<li class="active grid" data-type="grid"></li>';
                $result .= '<li class="list" data-type="list"></li>';
                $result .= '</ul>';
                $result .= '<div class="list_promocodes_sorter">';
                $result .= '<div class="comments_sorter_title color_dark_gray pointer dropdown flex">'.__('Отсортировать по','er_theme').'</div>';
                $result .= '</div>';
                $result .= '</div>';
                $result .= '</div>';
                $result .= '</div>';
                }
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('rating_icons')) {
	function rating_icons($post_id) {
		$result = '';
		$result .= '<div class="rating_icons background_light">';
			$result .= '<div class="wrap">';
				$result .= '<ul>';
					$result .= '<li class="icon_bg icon_filter pointer border_circle font_small color_dark_gray">'.__('Открыть фильтр','er_theme').'</li>';
					$result .= '<li class="icon_bg icon_compare pointer border_circle font_small color_dark_gray">'.__('Сравнить','er_theme').'</li>';
					$result .= bookmark_icon($post_id);
				$result .= '</ul>';
			$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}


if(!function_exists('counted_text')) {
	function counted_text($number,$text_1,$text_2,$text_3) {		
		if($number == 1) {
			$count_text = $text_1;
		} elseif($number > 1 && $number <= 4 ) {
			$count_text = $text_2;
		} else {
			if ( substr( $number, - 1 ) == 1 && substr( $number, - 2 ) != 11) {
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


if (!function_exists('review_bar')) {
	function review_bar() {
		$result = '';
		$result .= '<div class="review_bar flex">';
		if (function_exists('review_links')) {
			$result .= review_links();
		}
		if (function_exists('review_icons')) {
			$result .= review_icons();
		}
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('review_links')) {
	function review_links() {
		$result = '';
		$result .= print_css_links('review_links');
		$result .= print_js_links()['review_tabs'];
		$result .= '<ul class="review_links font_uppercase flex font_small font_bold color_dark_gray">';
			$result .= '<li class="review_link_reviews pointer" data-tab="review_container_reviews">'.__('Отзывы','er_theme').'</li>';
			$result .= '<li class="review_link_company pointer active color_dark_blue" data-tab="review_container_about">'.__('О компании','er_theme').'</li>';
			$result .= '<li class="review_link_company pointer" data-tab="review_container_content">'.__('Обзор','er_theme').'</li>';
			$result .= '<li class="review_link_abuses pointer" data-tab="review_container_abuses">'.__('Жалобы','er_theme').'</li>';
			$result .= '<li class="review_link_actions pointer" data-tab="review_container_actions">'.__('Акции','er_theme').'</li>';
		$result .= '</ul>';
		return $result;
	}
}

if (!function_exists('review_icons')) {
	function review_icons() {
		global $post;
		$result = '';
		$result .= print_css_links('review_icons');
		$result .= '<ul class="review_icons" id="review_icons_top_'.$post->ID.'" data-id="'.$post->ID.'">';
			$result .= bookmark_icon($post->ID);
			$result .= '<li class="review_icon_share pointer" data-type="share_post" data-id="'.$post->ID.'"></li>';
		$result .= '</ul>';
		return $result;
	}
}

if (!function_exists('user_logout_ajax')) {
	add_action( 'wp_ajax_user_logout_ajax', 'user_logout_ajax' );
	add_action( 'wp_ajax_nopriv_user_logout_ajax', 'user_logout_ajax' );

	function user_logout_ajax(){
		
		wp_logout();
		die;
	}
	
}

if (!function_exists('user_nav')) {
	add_action( 'wp_ajax_user_nav', 'user_nav' );
	add_action( 'wp_ajax_nopriv_user_nav', 'user_nav' );
	function user_nav() {
		$result = '';
		$site_url = get_bloginfo('url');
		$result .= '<ul class="user_nav box_shadow_down color_dark_blue no_underline hover_bg_light font_small font_uppercase font_bold">';
			$result .= '<li class="user_icon_home"><a href="'.$site_url.'/user/dashboard/">'.__('Главная','sa_theme').'</a></li>';
			$result .= '<li class="user_icon_profile"><a href="'.$site_url.'/user/">'.__('Профиль','sa_theme').'</a></li>';
			$result .= '<li class="user_icon_reviews"><a href="'.$site_url.'/user/reviews/">'.__('Отзывы','sa_theme').'</a></li>';
			$result .= '<li class="user_icon_abuses"><a href="'.$site_url.'/user/abuses/">'.__('Жалобы','sa_theme').'</a></li>';
			$result .= '<li class="user_icon_balance"><a href="'.$site_url.'/user/balance/">'.__('Платежи','sa_theme').'</a></li>';
			$result .= '<li class="user_icon_tariffs"><a href="'.$site_url.'/user/tariff/">'.__('Тарифы','sa_theme').'</a></li>';
			$result .= '<li class="user_icon_logout"><a class="link_logout pointer">'.__('Выйти','sa_theme').'</a></li>';
		$result .= '</ul>';
		echo $result;
		die;
	}
}

if (!function_exists('user_nav_settings')) {
	add_action( 'wp_ajax_user_nav_settings', 'user_nav_settings' );
	add_action( 'wp_ajax_nopriv_user_nav_settings', 'user_nav_settings' );
	function user_nav_settings() {
		$result = '';
		$site_url = get_bloginfo('url');
		$result .= '<ul class="user_nav_settings box_shadow_down color_dark_blue font_small font_bold">';
			$result .= '<li class="link_add_review pointer" data-link="'.get_bloginfo('url').'/reviews/">'.__('Добавить отзыв','sa_theme').'</li>';
			$result .= '<li class="link_add_company_review pointer" data-link="'.get_bloginfo('url').'/order/">'.__('Добавить обзор','sa_theme').'</li>';
			$result .= '<li class="link_add_news pointer" data-link="'.get_bloginfo('url').'/author/">'.__('Стать автором','sa_theme').'</li>';
			$result .= '<li class="link_add_abuse pointer" data-link="'.get_bloginfo('url').'/abuse/">'.__('Оставить жалобу','sa_theme').'</li>';
			$result .= '<li class="link_add_company pointer" data-link="'.get_bloginfo('url').'/add-company-2/">'.__('Добавить компанию','sa_theme').'</li>';
			$result .= '<li class="link_check_company pointer" data-link="'.get_bloginfo('url').'/check/">'.__('Проверить компанию','sa_theme').'</li>';
		$result .= '</ul>';
		echo $result;
		die;
	}
}


if (!function_exists('ajax_show_popular_cat_content')) {
	add_action( 'wp_ajax_ajax_show_popular_cat_content', 'ajax_show_popular_cat_content' );
	add_action( 'wp_ajax_nopriv_ajax_show_popular_cat_content', 'ajax_show_popular_cat_content' );
	function ajax_show_popular_cat_content() {
		$data = $_POST;
		$args = array(
			'post_type' => $data['post_type'],
		);
		if($data['post_type'] == 'casino') {
		    $args['tax_query'] = array(
                array(
                    'taxonomy' => 'affiliate-tags',
                    'field' => 'term_id',
                    'terms' => $data['term_id'],
                )
            );
            $args['posts_per_page'] = 6;
        } elseif($data['post_type'] == 'promocodes') {
            $args['posts_per_page'] = 3;
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'affiliate-tags',
                    'field' => 'term_id',
                    'terms' => $data['term_id'],
                )
            );
            $args['meta_query'] = array(
                array(
                    'key' => 'promocodes_items',
                    'value' => 0,
                    'compare' => '>'
                )
            );
        }
		$query_reviews = new WP_Query($args);
		if ( $query_reviews->have_posts() ) {
			$result .= '<ul class="flex">';
			while ( $query_reviews->have_posts() ) {
				$query_reviews->the_post();
				global $post;
				if($data['post_type'] == 'casino') {
                    if(function_exists('get_rating_fields_group')) {
                        $rating_fields_group = get_rating_fields_group($post->ID);
                    } else {
                        $rating_fields_group = 0;
                    }
                    $comments_count = get_comments_count( $post->ID, get_comment_rating_fields( $rating_fields_group, 'name' ) );
                    $result .= '<li class="white_block flex flex_column">';
                    $company_name = get_field('company_name',$post->ID);
                    $result .='<div class="company_block_header flex">';
                    if (function_exists('review_logo')) {
                        $result .= review_logo($post->ID);
                    }
                    $result .= '<div class="flex flex_column">';
                    $result .= '<div class="font_medium font_bold color_dark_blue company_name">'.$company_name.'</div>';
                    $result .= '<div class="font_small"><span class="color_dark_gray count_reviews">'.__('Отзывы','er_theme').'</span><span class="color_dark_blue">'.$comments_count['count'].'</span></div>';
                    $result .='</div>';
                    $result .='</div>';
                    $result .='<div class="company_block_footer flex">';
                    $result .= get_post_stars($rating_fields_group);
                    $result .= review_top_rating($post->ID);
                    $result .='</div>';
                    $result .= '</li>';

				} elseif($data['post_type'] == 'promocodes') {
                    $item = get_field('promocodes_items')[0];
                    //print_r($item);
                   // echo '<br /><br />';
                    $review_id = get_field('promocode_review');
                    $company_name = get_field('company_name',$review_id);
                    $result .= '<li class="white_block flex flex_column">';
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
                    if($size != '') {
                        $result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size">' . $size . '</div>';
                    } else {
                        $result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size_text">' . $item_type . '</div>';
                    }
                    $result .= '<a class="promocode_item_title font_small color_dark_blue link_no_underline font_bold" href="'.get_the_permalink().'" target="_blank">'.$company_name.'</a>';
                    if($item['title'] != '') {
                        $result .= '<div class="color_dark_gray font_small m_t_10">' . $item['title'] . '</div>';
                    }
                    if($item['text'] != '') {
                        $result .= '<div class="link_promocode_show_more_text button button_green button_centered m_t_20 pointer">'.__('Показать код','er_theme').'</div>';
                    } else {
                        $result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer" href="" target="_blank">'.__('Получить','er_theme').'</a>';
                    }
                    $result .='</div>';
                    $result .='<div class="promocode_block_footer flex">';
                    if($item['description'] != '') {
                        $result .= '<span class="font_smaller color_dark_gray inactive dropdown pointer flex link_promocode_show_more">'.__('Подробнее','er_theme').'</span>';
                    }
                    $count_used = 1;
                    $result .= '<span class="m_l_auto font_bold font_smaller color_dark_blue">'.$count_used.' '.counted_text($count_used,__('использует','er_theme'),__('используют','er_theme'),__('используют','er_theme')).'</span>';
                    $result .='</div>';
                    $result .= '</li>';
                }




			}
			$result .= '</ul>';
		}
		wp_reset_postdata();
		echo $result;
		die;
	}
}

if (!function_exists('er_title')) {
	function er_title() {
		global $post;
		$result = '';
		if( is_post_type_archive(array('promocodes')) )
		{
			$result .= __('Бесплатные промокоды на скидку | Это развод™','er_theme');
		} elseif(is_404()) {
			$result .= __('Страница не найдена | Это развод™','er_theme');
		} elseif(is_category()) {
			if(is_paged()) {
				$paged = get_query_var( 'paged', 0 );
				$result .= 'Рубрика '.single_cat_title('',0).', страница '.$paged.' | Это развод™';
			} else {
				$result .= __('Рубрика ','er_theme').single_cat_title('',0).__(' | Это развод™','er_theme');
			}
		} else {
			if(is_singular('promocodes')) {
				$result = get_the_title($post->ID).' | '.date_i18n('F Y');
			} else {
				$title = get_post_meta($post->ID, 'seo_title', true);
				if($title && $title != '') {
					$result = $title;
				} else {
					$result = get_the_title($post->ID).' | Это развод™';
				}
			}
		}
		return $result;
	}
}

if (!function_exists('er_description')) {
	function er_description() {
		global $post;
		$result = '';
		if( is_post_type_archive(array('promocodes')) )
		{
			$result .= __('Промокоды на скидку, бонус или беплатную доставку для ведущий интернет-компаний. Полный список бесплатных промокодов на одной странице.','er_theme');
		} elseif(is_category()) {
			if(is_paged()) {
				$paged = get_query_var( 'paged', 0 );
				$result .= 'Полезные статьи блога из рубрики '.single_cat_title('',0).', страница '.$paged.' - только главное: обзоры, перспективы, советы, инструкции. Читайте и оставляйте комментарии.';
			} else {
				$result .= __('Полезные статьи блога из рубрики ','er_theme').single_cat_title('',0).' - только главное: обзоры, перспективы, советы, инструкции. Читайте и оставляйте комментарии.';
			}
		} else {
			$description = get_post_meta($post->ID, 'seo_desc', true);
				$result = $description;
		}
		return $result;
	}
}

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

add_filter( 'wp_targeted_link_rel', 'my_function_remove_noreferrer' );
function my_function_remove_noreferrer( $rel_values ) {
   return preg_replace( '/noreferrer\s*/i', '', $rel_values );
}

function im_formatter($content) {
$replace = array(" noreferrer" => "" ,"noreferrer " => "");
$new_content = strtr($content, $replace);
return $new_content;
}
add_filter('the_content', 'im_formatter', 999);