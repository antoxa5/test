<?php

add_theme_support( 'menus' );// Added in 3.0

register_nav_menus( array(
	'sections' => __( 'Разделы', 'er_theme' ),
	'primary' => __( 'Primary Navigation', 'er_theme' ),
	'footer_1' => __( 'Footer 1', 'er_theme' ),
	'news' => __( 'News', 'er_theme' ),
	'footer_2' => __( 'Footer 2', 'er_theme' ),
	'footer_3' => __( 'Footer 3', 'er_theme' ),
	'foo_1' => __( 'Foo 1', 'er_theme' ),
	'foo_2' => __( 'Foo 2', 'er_theme' ),
	'foo_3' => __( 'Foo 3', 'er_theme' ),
	'footer_bottom' => __( 'Footer Bottom', 'er_theme' ),
	'fast_links' => __( 'Fast Links', 'er_theme' ),
	'bar_1' => __( 'Bar 1', 'er_theme' ),
	'bar_2' => __( 'Bar 2', 'er_theme' ),
	'bar_3' => __( 'Bar 3', 'er_theme' ),
	'bar_4' => __( 'Bar 4', 'er_theme' ),
	'bar_5' => __( 'Bar 5', 'er_theme' ),
	'bar_6' => __( 'Bar 6', 'er_theme' ),
	'news_nav' => __( 'News Nav', 'er_theme' ),
	'fast_links_1' => __( 'Fast 1', 'er_theme' ),
	'fast_links_2' => __( 'Fast 2', 'er_theme' ),
	'fast_links_3' => __( 'Fast 3', 'er_theme' ),
	'fast_links_4' => __( 'Fast 4', 'er_theme' ),
	'fast_links_5' => __( 'Fast 5', 'er_theme' ),
	'fast_links_6' => __( 'Fast 6', 'er_theme' ),
	'fast_links_7' => __( 'Fast 7', 'er_theme' ),
	'fast_links_8' => __( 'Fast 8', 'er_theme' ),
	'fast_links_9' => __( 'Fast 9', 'er_theme' ),
	'fast_links_10' => __( 'Fast 10', 'er_theme' ),
	'fast_links_11' => __( 'Fast 11', 'er_theme' ),
) );

function wp_get_menu_array($current_menu) {

	$array_menu = wp_get_nav_menu_items($current_menu);
	$menu = array();
	if($array_menu && !empty($array_menu)) {
        $current_language = get_locale();
		foreach ($array_menu as $m) {
			//  echo '<pre>';
//print_r($m);
			// echo '</pre>';
            $hide_on_languages = get_field('hide_on_languages',$m->ID);
            if(get_field('hide_on_languages',$m->ID)) {
                if(in_array($current_language, $hide_on_languages)) {
                    continue;
                }

                /*echo '<div style="display:none;">';
                print_r($m);
                print_r(get_field('hide_on_languages',$m->ID));
                echo '</div>';*/
            }

			if (empty($m->menu_item_parent)) {
				$menu[$m->ID] = array();
				$menu[$m->ID]['ID'] = $m->ID;
				$menu[$m->ID]['title'] = $m->title;
				$menu[$m->ID]['url'] = $m->url;
				$menu[$m->ID]['icon'] = get_field('icon',$m->ID);
				$menu[$m->ID]['classes'] = get_field('menu_add_classes',$m->ID);
				//$menu[$m->ID]['icon'] = $m->url;
				$menu[$m->ID]['children'] = array();


			}
		}

		$submenu = array();
		foreach ($array_menu as $m) {
			if ($m->menu_item_parent) {
				$submenu[$m->ID] = array();
				$submenu[$m->ID]['ID'] = $m->ID;
				$submenu[$m->ID]['title'] = $m->title;
				$submenu[$m->ID]['url'] = $m->url;
				$submenu[$m->ID]['icon'] = get_field('icon',$m->ID);
				$menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
			}
		}

		return $menu;
	}

}

function print_nav($menu,$class,$id,$color_class = 'link_gray') {
	$language = get_locale();
	if(!$color_class || $color_class == '') {
		$color_class = 'link_gray';
	}
	$result = '';
	$menu = wp_get_menu_array($menu);
	if(!empty($menu)) {
		$result .= '<div id="'.$id.'" class="nav '.$class.'">';
		$result .= '<ul>';
		foreach($menu as $item) {

			if($item['classes'] && $item['classes'] != '') {
				$classes = 'class="'.$item['classes'].'"';
			} else {
				$classes = '';
			}
			if ($language != 'ru_RU') {
				$enable_translations = get_field( 'enable_translations', url_to_postid( $item['url'] ) );
				if( is_array( $enable_translations ) && in_array( $language, $enable_translations ) ) {
					$show_menu = 1;
				} else {
					$show_menu = 0;
				}
			} else {
				$show_menu = 1;
			}
			if ($show_menu == 1) {
				$result .= '<li id="'.$id.'_item_'.$item['ID'].'" '.$classes.'>';
				if($item['url'] && $item['url'] != '') {
					$result .= '<a href="'.$item['url'].'" class="'.$color_class.' link_no_underline">'.$item['title'].'</a>';
				} else {
					$result .= '<span>'.$item['title'].'</span>';
				}
				$result .= '</li>';
			}
			
		}
		$result .= '</ul>';
		if($class == 'nav_dropdown') {
			$result .= '<span class="nav_arrow pointer"></span>';
		}
		$result .= '</div>';
	}
	return $result;
}
if (!function_exists('monoprog_get_menu_by_location')) {
	function monoprog_get_menu_by_location($location) {
		if(empty($location)) return false;

		$locations = get_nav_menu_locations();
		if(!isset($locations[$location])) return false;

		return get_term( $locations[$location], 'nav_menu' );
	}
}
if (!function_exists('theme_nav')) {
	function theme_nav($place,$show_title,$class,$id,$color_class) {
		$result = '';
		$menu_obj = monoprog_get_menu_by_location($place);
		$nav_menu_html = print_nav($menu_obj->name,$class,$id,$color_class);
		if ($show_title) {
			if(strpos($nav_menu_html, '_item_') !== false) {
				$result .= '<div class="menu_title color_dark_blue font_bolder font_smaller_2">'.esc_html($menu_obj->name).'</div>';
			}
		}
		$result .= $nav_menu_html;
		return $result;

	}
}

if(!function_exists('append_main_nav')) {
	add_action( 'wp_ajax_append_main_nav', 'append_main_nav' );
	add_action( 'wp_ajax_nopriv_append_main_nav', 'append_main_nav' );
	function append_main_nav() {
		$data = $_POST;

		$link = $data['actual_link'];

		$actual_companies = '';
		$actual_promocode = '';
		$actual_pages = '';
		$actual_ratings = '';
		if(function_exists('url_to_postid')) {
			$get_post_id = url_to_postid($link);
			if(get_page_template_slug($get_post_id) == 'template-rating.php') {
				$actual_rating = 1;
			} else {
				$actual_rating = 0;
			}
		} else {
			$actual_rating = 0;
		}
		if(strpos($link, '/promocode/') !== false) {
			$active = 'promocode';
		} elseif(strpos($link, '/pages/') !== false || strpos($link, '/blog/') !== false || 'page' == get_post_type($get_post_id) && !get_field('hide_from_news',$get_post_id)) {
			$active = 'pages';
		} elseif(strpos($link, '/ratings/') !== false || $actual_rating == 1) {
			$active = 'ratings';
		} else {
			$active = 'companies';
		}
		$result = '';
		$result .= '<ul>';
		if($active == 'companies') {
			$result .= '<li class="active link_gray">'.__('Компании').'</li>';
		} elseif($active == 'ratings') {
			$result .= '<li class="active">'.__('Рейтинги').'</li>';
		} elseif($active == 'pages') {
			$result .= '<li class="active">'.__('Новости').'</li>';
		} elseif($active == 'promocode') {
			$result .= '<li class="active">'.__('Промокоды').'</li>';
		}
		$result .= '</ul>';
		$result .= '<span class="nav_arrow pointer"></span>';
		echo $result;
		die;
	}
}

if(!function_exists('append_main_nav_more')) {
	add_action( 'wp_ajax_append_main_nav_more', 'append_main_nav_more' );
	add_action( 'wp_ajax_nopriv_append_main_nav_more', 'append_main_nav_more' );
	function append_main_nav_more() {
		$data = $_POST;
		$link = $data['actual_link'];
		if(function_exists('url_to_postid')) {
			$get_post_id = url_to_postid($link);
			if(get_page_template_slug($get_post_id) == 'template-rating.php') {
				$actual_rating = 1;
			} else {
				$actual_rating = 0;
			}
		} else {
			$actual_rating = 0;
		}
		$actual_companies = '';
		$actual_promocode = '';
		$actual_pages = '';
		$actual_ratings = '';
		if(strpos($link, '/promocode/') !== false) {
			$active = 'promocode';
		} elseif(strpos($link, '/pages/') !== false || strpos($link, '/blog/') !== false) {
			$active = 'pages';
		} elseif(strpos($link, '/ratings/') !== false || $actual_rating == 1) {
			$active = 'ratings';
		} else {
			$active = 'companies';
		}
		$result = '';
		$result .= '<ul class="header_section_sub_links box_shadow_down">';
		if($active != 'companies') {
			$result .= '<li><a href="'.get_bloginfo('url').'/" class="link_gray link_no_underline">'.__('Компании').'</a></li>';
		}
		if($active != 'ratings') {
			$result .= '<li><a href="'.get_bloginfo('url').'/ratings/" class="link_gray link_no_underline">'.__('Рейтинги').'</a></li>';
		}
		if($active != 'pages') {
			$result .= '<li><a href="'.get_bloginfo('url').'/pages/" class="link_gray link_no_underline">'.__('Новости').'</a></li>';
		}
		if($active != 'promocode') {
			$result .= '<li><a href="'.get_bloginfo('url').'/promocode/" class="link_gray link_no_underline">'.__('Промокоды').'</a></li>';
		}
		$result .= '</ul>';
		echo $result;
		die;
	}
}


if (!function_exists('user_nav_mobile')) {
	add_action( 'wp_ajax_user_nav_mobile', 'user_nav_mobile' );
	add_action( 'wp_ajax_nopriv_user_nav_mobile', 'user_nav_mobile' );
	function user_nav_mobile() {
		$result = '';

		if(!is_user_logged_in()) {
			$result .= '<div class="logo_mobile_popup"></div>';
			$result .= '<div class="auth_button button button_green pointer m_b_15 font_18 font_bold">'.__('Войти в аккаунт','er_theme').'</div>';
			$result .= '<div class="reg_button button button_violet pointer font_18 font_bold">'.__('Зарегистрироваться','er_theme').'</div>';
		} else {
			$result .= '<div class="logo_mobile_popup"></div>';
			if(function_exists('wp_get_current_user')) {
				$current_user = wp_get_current_user();
				//print_r($current_user);
				$user_id = $current_user->data->ID;
				$user_display_name = $current_user->data->display_name;
				$user_picture = get_field('photo_profile', 'user_'.$user_id );
				$user_label = get_field('photo_profile', 'user_'.$user_id );
				$user_label = get_field('services_user_services','user_'.$user_id)[0];
				$result .= '<div class="modal_user_top">';
				$result .= '<div class="modal_user_picture border_circle"';
				if($user_picture && $user_picture != '') {
					$result .= ' style="background-image: url('.$user_picture["sizes"]["thumbnail"].')" ';
				}
				$result .= '></div>';
				$result .= '<div class="modal_user_name flex pointer">';
				$result .= '<span class="display_name font_bold">'.$user_display_name.'</span>';
				if($user_label && $user_label != '') {
					$result .= '<span class="user_label font_smaller">'.get_the_title($user_label).'</span>';
				}
				$result .= '</div>';
				$result .= '</div>';

			}
			$site_url = get_bloginfo('url');
			$result .= '<ul class="user_nav color_dark_blue no_underline font_smaller_2 font_uppercase font_bolder">';
			$result .= '<li class="user_icon_home"><a href="'.$site_url.'/dashboard/" rel="nofollow">'.__('Главная','er_theme').'</a></li>';
			$result .= '<li class="user_icon_reviews"><a href="'.$site_url.'/dashboard/comments/" rel="nofollow">'.__('Отзывы','er_theme').'</a></li>';
			$result .= '<li class="user_icon_abuses"><a href="'.$site_url.'/dashboard/abuses/" rel="nofollow">'.__('Жалобы','er_theme').'</a></li>';
			//$result .= '<li class="user_icon_posts"><a href="'.$site_url.'/dashboard/services/blog/" rel="nofollow">'.__('Публикация статьи','er_theme').'</a></li>';
			//$result .= '<li class="user_icon_news"><a href="'.$site_url.'/dashboard/news/" rel="nofollow">'.__('Новости','er_theme').'</a></li>';
			$result .= '<li class="user_icon_profile"><a href="'.$site_url.'/user/">'.__('Профиль','er_theme').'</a></li>';
			$result .= '<li class="user_icon_services"><a href="'.$site_url.'/dashboard/services/" rel="nofollow">'.__('Сервисы','er_theme').'</a></li>';
			$result .= '<li class="user_icon_subscribes"><a href="'.$site_url.'/dashboard/subscription/" rel="nofollow">'.__('Подписки','er_theme').'</a></li>';
			$result .= '<li class="user_icon_balance"><a href="'.$site_url.'/dashboard/wallet/" rel="nofollow">'.__('Платежи','er_theme').'</a></li>';
			$result .= '<li class="user_icon_logout"><a class="link_logout pointer">'.__('Выйти из аккаунта','er_theme').'</a></li>';
			$result .= '</ul>';
		}
		echo $result;
		die;
	}
}

?>