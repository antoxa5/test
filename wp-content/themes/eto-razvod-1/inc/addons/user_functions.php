<?php

include_once(TEMPLATEPATH .'/inc/addons/messages.php');

if (!function_exists('user_dashboard')) {
	function user_dashboard() {
		$result = print_css_links('user_page');
		$result .= print_js_links()['user_page'];
		$result .= print_css_links('user_form');
		$result .= '<div class="page_content page_container background_light review_container_about visible">';
		$result .= '    <div class="wrap justify-content-space-between wrap-no-padding-top dashboadmain">';

		$result .= '            <div class="profile-wrapper__left">';
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		$counters = profile_stats_count( $user_id );
		$result .= user_menu($current_user,$user_id,'dashboard');
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center dashboard_page_center">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}

		$result .= '</div>';
		$result .= '<div class="comment_bar_info_wrapper">'.profile_comments($user_id,$counters,'dashboard').'</div>';
		$result .= '<div class="profile-rate white_block border_radius_4px">'.profile_rate($user_id).'</div>';
		$result .= '<div class="profile_stats_wrap">';
		$result .= '<div class="profile_comments_stats white_block border_radius_4px">'.profile_comments_stats($user_id,'Мои отзывы',0,1).'</div>';
		$result .= '<div class="profile_abuse_stats white_block border_radius_4px">'.profile_abuse_stats($user_id).'</div>';
		$result .= '</div>';
		$result .= profile_create_view($user_id);
		$result .= user_subscribe_data_dashboard_horizontal($user_id,'dashboard', FALSE, TRUE);
                
		$result .= '</div>';
		$result .= '            <div class="profile-wrapper__right profile-wrapper__right_dashboard">'.add_company($user_id).my_companies($user_id).my_posts_profile($user_id).fast_links_profile($user_id,'normal',[['/personal-account-instruction/','Инструкция по кабинету компаний'],['/dashboard/services/pro/','Включить аккаунт PRO'],['/advices/','Полезные советы'],['/user-edit/','Как заполнить аккаунт'],['/user-help/','Помощь']]).user_subscribe_data_dashboard($user_id,'dashboard', TRUE).menu_footer_links(true).'</div>';
		//$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';

		$result .= print_css_links('profile_top');
		return $result;
	}
}


if (!function_exists('add_company_user_dashboard')) {
	function add_company_user_dashboard() {
		$result = print_css_links('user_page');
		$result .= print_js_links()['user_page'];
		$result .= print_css_links('user_form');
		$result .= '<div class="page_content page_container background_light review_container_about visible">';
		$result .= '    <div class="wrap justify-content-space-between wrap-no-padding-top dashboadmain">';

		$result .= '            <div class="profile-wrapper__left">';
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		$counters = profile_stats_count( $user_id );
		$result .= user_menu($current_user,$user_id,'dashboard');
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center dashboard_page_center">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}

		$result .= '</div>';

		$result .= '<div class="bg_add_company">';
		$current_user     = wp_get_current_user();
		$user_id          = $current_user->data->ID;
		$message          = '';
		$class_type       = 'reviewgetcompany';
		if ( $class_type == 'reviewgetcompany' ) {
			$class_type = 'review';
		}
		$message .= '<div class="popup_container1" id="popup_link_outside_' . $class_type . '" data-form-type="' . 'reviewgetcompany' . '">';
		$message .= '<div class="popup_window1">';
		$message .= '<div class="popup_close_button pointer"></div>';

		$message .= '<div class="p_30 flex flex_column">';
		if ( 'reviewgetcompany' == 'abuse' ) {
			$message .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">' . __( 'Новая жалоба на компанию', 'er_theme' ) . '</div>';
		} elseif ( 'reviewgetcompany' == 'review' ) {
			$message .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">' . __( 'Новый отзыв о компании', 'er_theme' ) . '</div>';
		} elseif ( 'reviewgetcompany' == 'reviewgetcompany' ) {
			$message .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">' . __( 'Добавить компанию', 'er_theme' ) . '</div>';
		}

		$message .= '<div class="autocomplete_container" data-type="search_companies" id="popup_search_companies">';
		$message .= '<input name="autocomplete_text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="text" value="" placeholder="' . __( 'Введите название компании', 'er_theme' ) . '" />';
		$message .= '<input name="autocomplete_result" type="hidden" value="" />';
		$message .= '<div class="autocomplete_icon_search"></div>';
		$message .= '<div class="autocomplete_icon_close"></div>';
		$message .= '<div class="autocomplete_search_results"></div>';
		$message .= '</div>';
		$message .= '<div class="outside_form_container"></div>';
		$message .= '</div>';
		$message .= '</div>';
		$message .= '</div>';
		$result  .= $message;
		$result .= '</div>';

		$result .= '</div>';
		$result .= '            <div class="profile-wrapper__right profile-wrapper__right_dashboard">'.add_company($user_id).my_posts_profile($user_id).fast_links_profile($user_id,'normal',[['/dashboard/services/pro/','Включить аккаунт PRO'],['/advices/','Полезные советы'],['/user-edit/','Как заполнить аккаунт'],['/user-help/','Помощь']]).user_subscribe_data_dashboard($user_id,'dashboard', TRUE).menu_footer_links(true).'</div>';
		//$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';

		$result .= print_css_links('profile_top');
		return $result;
	}
}

if (!function_exists('user_menu')) {
	function user_menu($current_user, $user_id, $type) {
		$user_display_name_r = $current_user->data->display_name;
		$user_firstname_r = $current_user->user_firstname;
		if ($user_firstname_r == '') {
			$user_display_name = $user_display_name_r;
		} else {
			$user_display_name = $user_firstname_r;
		}
		$profile_stats_menu_count = profile_stats_menu_count($user_id);
		$user_picture = get_field('photo_profile', 'user_'.$user_id );

		$user_label = get_field('services_user_services','user_'.$user_id);
		$user_label = isset( $user_label[0] ) ? $user_label[0] : '';

		$result = '';
		$result .= '<div class="breadcrumbs_dashboard ismobile_flex">';
		if (function_exists('show_breadcrumbs')) {
			if ($type == 'dashboard') {
				$result .= show_breadcrumbs();
			} else {
				$result .= show_breadcrumbs(1);
			}
		}
		$result .= '</div>';
		$result .= '<div class="user_bar user_bar_dashboard menu_bar_p">';
		$profile_stats_menu_count_abuse = $profile_stats_menu_count['abuse_menu'];
		if ($profile_stats_menu_count_abuse == 0) {
			$profile_stats_menu_count_abuse = '';
		} else {
			$profile_stats_menu_count_abuse = '<span class="new-comments-profile__number font_bold border_circle_px">'.$profile_stats_menu_count_abuse.'</span>';
		}
		$result .= '<div class="user_picture border_circle"';
		if($user_picture && $user_picture != '') {
			$result .= ' style="background-image: url('.$user_picture["sizes"]["thumbnail"].')" ';
		}
		$result .= '></div>';
		$result .= '<div class="user_name flex inactive_user_nav pointer flex_column">';
		$result .= '<div class="user-name_fist-line"><span class="display_name font_bold">'.$user_display_name.'</span>';
		if($user_label && $user_label != '') {
			$result .= '<span class="user_label font_smaller">'.get_the_title($user_label).'</span>';
		}
		$result .= '</div><div class="register_time_days_user_profile">'.get_user_reg_date($user_id).'</div></div>';
		$result .= '</div>';

		$result .= '<ul class="user-profile-nav">';

		$act = [];
		$act['dashboard'] = '';
		$act['comments'] = '';
		$act['abuses'] = '';
		$act['user'] = '';
		$act['subscripton'] = '';
		$act['services'] = '';
		$act['wallet'] = '';
		$act['reviews'] = '';
		$act['notifications'] = '';
		$act['messages'] = '';
		$act['dashboard_blog'] = '';
		$act['subscribes'] = '';

		if ($type == 'dashboard') {
			$act['dashboard'] = ' user-profile-nav-item-active';
		}

		if ($type == 'comments') {
			$act['comments'] = ' user-profile-nav-item-active';
		}

		if ($type == 'abuses') {
			$act['abuses'] = ' user-profile-nav-item-active';
		}

		if ($type == 'user') {
			$act['user'] = ' user-profile-nav-item-active';
		}

		if ($type == 'subscripton') {
			$act['subscribes'] = ' user-profile-nav-item-active';
		}

		if ($type == 'services') {
			$act['services'] = ' user-profile-nav-item-active';
		}

		if ($type == 'wallet') {
			$act['wallet'] = ' user-profile-nav-item-active';
		}

		if ($type == 'reviews') {
			$act['reviews'] = ' user-profile-nav-item-active';
		}

		if ($type == 'notifications') {
			$act['notifications'] = ' user-profile-nav-item-active';
		}

		if ($type == 'messages') {
			$act['messages'] = ' user-profile-nav-item-active';
		}

		if ($type == 'dashboard_blog') {
			$act['dashboard_blog'] = ' user-profile-nav-item-active';
		}
		
		$result .= '<li class="user-profile-nav__item user_icon_home"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['dashboard'].'" href="/dashboard/" rel="nofollow">Главная</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_notify"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['notifications'].'" href="/dashboard/notifications/" rel="nofollow">Уведомления</a></li>';
		//if (($user_id == 9) || ($user_id == 17)) {
			$new_msg = notify_check_new('messages',$user_id);
			$result .= '<li class="user-profile-nav__item user_icon_messages"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['messages'].'" href="/dashboard/messages/" rel="nofollow">Сообщения';
			if($new_msg > 0) {
						$result .= '<span class="new-comments-profile__number font_bold border_circle_px" style="border-radius: 50%; padding: 0px; width: 19px;">'.$new_msg.'</span>';
					}
			$result .= '</a></li>';
			
		//}
		$result .= '<li class="user-profile-nav__item user_icon_reviews"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['comments'].'" href="/dashboard/comments/" rel="nofollow">Отзывы</a></li>';
		///dashboard/messages/

		$result .= '<li class="user-profile-nav__item user_icon_abuses"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['abuses'].'" href="/dashboard/abuses/" rel="nofollow">Жалобы '.$profile_stats_menu_count_abuse.'</a></li>';
		//$result .= '<li class="user-profile-nav__item user_icon_posts"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['reviews'].'" href="/dashboard/reviews/" rel="nofollow">Обзоры</a><span class="soon_dashboard">Скоро</span></li>';
		//$result .= '<li class="user-profile-nav__item user_icon_news"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['dashboard_blog'].'" href="/dashboard/services/blog/" rel="nofollow">Публикация статьи</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_profile"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['user'].'" href="/user/" rel="nofollow">Профиль</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_services"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['services'].'" href="/dashboard/services/" rel="nofollow">Сервисы</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_subscribes"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['subscribes'].'" href="/dashboard/subscription/" rel="nofollow">Подписки</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_balance"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['wallet'].'" href="/dashboard/wallet/" rel="nofollow">Платежи</a></li>';
		$result .= '</ul>';
		$result .= menu_footer_links(false);
		return $result;

	}
}

if (!function_exists('profile_rate')) {
	function profile_rate($user_id) {
		$result = '';
		$result .= '<div class="profile-rate__inside">';
		$result .= '<span class="my-rate">';
		$result .= '<span class="my-rate__title font_small">';
		$result .= 'Мой рейтинг';
		$result .= '</span>';

		$all_rates = get_field('all_rates','user_'.$user_id);
		$good_rates = intval(get_field('good_rates','user_' . $user_id));

		if ($all_rates) {
			if ($all_rates > 0) {
				$numberrate = '<span class="color_green">+'.$all_rates.'</span>';
			} elseif ($all_rates < 0) {
				$numberrate = '<span class="color_red">'.$all_rates.'</span>';
			} else {
				$numberrate = '<span class="color_medium_gray">0</span>';
			}
		} else {
			$numberrate = '<span class="color_medium_gray">0</span>';
		}
		$result .= '<span class="my-rate__number">';
		$result .= $numberrate;
		$result .= '</span>';
		$result .= '</span>';
		$all_rates_minus = abs(intval($all_rates) - intval($good_rates));
		$result .= '<span class="rate-vote font_small">';
		$result .= '<span class="color_dark_blue"><span class="color_green"><span class="this-number-profile_plus">'.$good_rates.'</span> <span class="plus_name">'.counted_text($good_rates,__('плюс','er_theme'),__('плюса','er_theme'),__('плюсов','er_theme')).'</span></span> и <span class="this-number-profile_minus">'.$all_rates_minus.'</span>  <span class="minus_name">'.counted_text($all_rates_minus,__('минус','er_theme'),__('минуса','er_theme'),__('минусов','er_theme')).'</span></span>';
		$result .= '</span>';
		$result .= '<a href="/user/'.get_userdata( $user_id )->data->user_nicename.'/" class="profile_link absolute_right_25 line_height_zero font_small button button_bigger font_bold button_violet pointer link_no_underline" target="_blank">Мой профайл</a>';
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('fast_links_profile')) {
	function fast_links_profile( $user_id,$type, $array = [] ) {
		$result = '';
		if ($type == 'noborder') {
			$result .='<div class="side_block">';
		} elseif ($type == 'normal') {
			$result .='<div class="side_block white_block border_radius_4px">';
		}
		if ($type == 'noborder') {
			$result .= '<div class="side_block_column">';
		} elseif ($type == 'normal') {
			$result .= '<div class="block_content side_block_column fast_links_padding side_block_links">';
		}
		$result .='<ul class="fast-links-profile ul_none">';

		$services_user_services = get_field( 'services_user_services','user_'.$user_id );

		if ( ( ( isset( $services_user_services[0] ) && $services_user_services[0] == 84175 ) || ( $services_user_services == 84175 ) || ( isset( $services_user_services[0] ) && $services_user_services[0] == 84178 ) || ( $services_user_services == 84178 ) ) ) {

		} else {
			//$result .= '<li class="fast-links-profile__item"><a href="#" class="fast-links-profile__link color_wave_blue border_no_color link_no_underline">Включить аккаунт PRO</a></li>';
		}
		foreach ( $array as $item ) {
			if ($item[0] == '#') {
				$result .='<li class="fast-links-profile__item fast-links-profile__item_disabled"><a href="'.$item[0].'" class="fast-links-profile__link color_wave_blue border_no_color link_no_underline font_small">'.$item[1].'</a><span class="soon_dashboard">Скоро</span></li>';
			} else {
				$result .='<li class="fast-links-profile__item"><a href="'.$item[0].'" class="fast-links-profile__link color_wave_blue border_no_color link_no_underline font_small">'.$item[1].'</a></li>';
			}

		}

		//$result .='<li class="fast-links-profile__item"><a href="#" class="fast-links-profile__link color_wave_blue border_no_color link_no_underline">Как заполнить аккаунт</a></li>';
		//$result .='<li class="fast-links-profile__item"><a href="#" class="fast-links-profile__link color_wave_blue border_no_color link_no_underline">Помощь</a></li>';
		$result .='</ul>';
		$result .='</div>';
		$result .='</div>';
		return $result;
	}
}

if (!function_exists('my_posts_profile')) {
	function my_posts_profile( $user_id ) {
		$result = '';
		$result .='<div class="side_block white_block my_posts_profile my_posts_profile_real border_radius_4px"><span class="soon_dashboard">Скоро</span>';
		$result .='<div class="block_content side_block_column">';
		$result .= '<div class="number-stat-profile_line">'.number_stat_profile($user_id,'Мои обзоры',count_user_posts($user_id,'casino',true), 0, 1).'</div>';
		$result .= '<div class="new-comment-posts"><div class="new-comments-profile flex justify-content-space-between">';
		$result .= '	<a href="#"  class="new-comments-profile__link link_gray font_small link_no_underline font_underline_no_color">Новые комментарии</a>';

		$theNumbers = 0;
		$myposts = get_posts( array(
			'author'         => $user_id,
			'posts_per_page' => -1,
			'post_type'      => 'casino'
		) );
		foreach( $myposts as $post ){
			setup_postdata($post);
			$theNumbers = $theNumbers + get_comments_number( $post->ID );
		}
		wp_reset_postdata();

		$result .= '	<span  class="new-comments-profile__number font_bold border_circle_px">'.$theNumbers.'</span>';
		$result .= '</div></div>';
		$result .= '<div class="button button_gray pointer button_nopadding font_bold create_review font_small">Разместить обзор</div>';
		$result .='</div>';
		$result .='</div>';
		return '';
	}
}

if (!function_exists('add_company')) {
	function add_company( $user_id ) {
		$result = '';
		$result .='<div class="side_block white_block border_radius_4px company_switch_wrap"><span class="company_switch_title_dashboard color_dark_blue font_bold title_add_comp">Вы представитель компании?</span>';
		$result .='<div class="side_block_column">';
		$result .='<div class="bg_none_company company_switch_logo_dashboard"></div>';
		$result .='<span class="company_switch_title_dashboard color_dark_blue font_bold">Получите доступ к личному кабинету компании с аналитикой и сервисами. Отвечайте от лица представителя компании на отзывы, жалобы и управляйте ее репутацией.</span>';
		$result .='<a href="/dashboard-add-company/" rel="nofollow" class="link_no_underline button button_gray pointer button_nopadding font_bold create_review font_small">Добавить мою компанию</a>';
		$result .='</div>';
		$result .='</div>';
		return $result;
	}
}

if (!function_exists('my_companies')) {
	function my_companies( $user_id ) {

		$result = '';

		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		// $company_ids = get_field('company_user', 'user_'.$user_id);
		$company_ids2 = get_field('comp_statuses', 'user_'.$user_id);
		$company_ids2 = is_array( $company_ids2 ) ? $company_ids2 : array();

		if (count($company_ids2) != 0) {
			$result = '<div class="my_comp_dash side_block white_block border_radius_4px"><div class="block_content side_block_column fast_links_padding side_block_links">';
			$result .= '<div class="company_list_2"><span class="number-stat-profile__title font_small">Мои компании</span><div class="company_list_ul">';
			//$result .= print_r($company_ids2);
			foreach ($company_ids2  as $item ) {
				$post_id = $item['company_user'][0];

				if ($item['status']['value'] != 'ok') {
					$link = '/dashboard/wallet/?conn_id='.$item['id_conn_comp'][0];
				} else {
					$link = '/dashboard/company/'.get_post_field( 'post_name', $post_id );
				}
				$result .= '<a href="'.$link.'" class="review_logo"';
				$logo = get_field('company_logo',$post_id);
				$logo_bg = get_field('company_icon_bg',$post_id);
				if($logo_bg && $logo_bg != '') {
					$bg = ' background-color:'.$logo_bg.';';
				} else {
					$bg = '';
				}
				$lazy = false;
				if($logo && !empty($logo)) {
					if($lazy == true) {
						$result .= ' data-img="'.$logo['sizes']['large'].'"';
						$result .= ' style="'.$bg.'"';
					} else {
						$result .= ' style="background-image:url('.$logo['sizes']['large'].'); '.$bg.'"';
					}
					//$result .= ' data-img="'.$logo['sizes']['large'].'"';

				}
				if ($item['status']['value'] != 'ok') {
					$status_string = '<span class="status">'.$item['status']['label'].'</span>';
				} else {
					$status_string = '';
				}
				$result .= '>'.$status_string.'</a>';
			}
			$result .= '</div></div>';
			$result .= '</div></div>';
		}


		return $result;
	}
}

if (!function_exists('number_stat_profile')) {
	function number_stat_profile( $user_id,$title,$number,$center,$settings ) {
		$result = '<div class="number-stat-profile">';
		if ($center == 0) {
			$result .= '	<span class="number-stat-profile__title font_small">'.$title.'</span>';
			$result .= '	<span class="number-stat-profile__number font_bolder font_big_medium">'.$number.'</span>';
		} elseif ($center == 1) {
			$result .= '	<span class="number-stat-profile__title text_centered text-block font_small">'.$title.'</span>';
			$result .= '	<span class="number-stat-profile__number font_bolder font_big_medium text_centered">'.$number.'</span>';
		}

		if ($settings == 0) {

		} elseif ($settings == 1)  {
			$result .= '	<span class="number-stat-profile__icon"></span>';
		}

		$result .= '</div>';
		return $result;
	}
}
if (!function_exists('profile_comments_stats')) {
	function profile_comments_stats( $user_id,$title, $center,$settings ) {
		$result = '';
		$args_reviews = [
			'status'       => 'approve',
			'user_id'      => $user_id,
			'comment_type' => 'comment',
			'meta_query'   => [
				'relation' => 'AND',
				[
					'key'     => 'comment_type',
					'value'   => 'reviews',
					'compare' => '=',
				]
			]
		];
		$reviews_comments = get_comments($args_reviews);
		$review_count = count($reviews_comments);
		$this_arr_ids = [];
		$this_arr_rate = [];
		$comment_rate_count = 0;
		$positive = 0;
		$negative = 0;

		$result .= number_stat_profile($user_id,$title,$review_count,$center,$settings);
		foreach ( $reviews_comments as $item ) {
			$comment_id = $item->comment_ID;
			$comment_rate = intval(get_field('comment_rate','comment_'.$comment_id));
			if ($comment_rate != 0) {
				$comment_rate_count++;

				if ($comment_rate > 0) {
					$positive++;
				}

				if ($comment_rate < 0) {
					$negative++;
				}
			}
		}

		$line_rate__green = 0;
		$line_rate__red = 0;
		if( $comment_rate_count > 0 ) {
			$line_rate__green = $positive / $comment_rate_count * 100;
			$line_rate__red = $negative / $comment_rate_count * 100;
		}

		if (($positive != 0) || ($negative != 0)) {
			$result .= '<div class="line-rate"><span class="line-rate__green" style="max-width: '.$line_rate__green.'%;width: 100%;"></span><span class="line-rate__red"  style="max-width: '.$line_rate__red.'%;width: 100%;"></span></div>';
		}

		if (($positive != 0)) {
			$positive_text = '<img src="/wp-content/themes/eto-razvod-1/img/thumbs-up.svg" alt=""> '.round($line_rate__green).'%';
		} else {
			$positive_text = '';
		}

		if (($negative != 0)) {
			$negative_text = round($line_rate__red).'% <img src="/wp-content/themes/eto-razvod-1/img/thumbs-down.svg" alt="">';
		} else {
			$negative_text = '';
		}


		$result .= '<div class="number-rate"><span class="number-rate__green font_smaller">'.$positive_text.'</span><span class="number-rate__red font_smaller ">'.$negative_text.'</span></div>';
		$result .= '<a class="button font_bold button_violet pointer link_no_underline button_nopadding create_review" href="/add-review/" rel="nofollow">Оставить отзыв</a>';
		return $result;
	}
}


if(!function_exists('user_subscribe_data_dashboard')) {

	function user_subscribe_data_dashboard($userid,$type,$mobile = FALSE) {


		if ($type == "dashboard") {
			if ($mobile == TRUE) {
				$result = '<div class="side_block white_block subscribe_widget subscribe_widget_user_profile subscribe_widget_user_dashboard border_radius_4px ismobile_flex">';
			} else {
				$result = '<div class="side_block white_block subscribe_widget subscribe_widget_user_profile subscribe_widget_user_dashboard border_radius_4px">';
			}

		} else {
			$result = '<div class="side_block white_block subscribe_widget subscribe_widget_user_profile">';
		}

		$result .= '<div class="block_content flex flex_column">';
		$result .= '<div class="flex input_columns align_items_center">';
		$result .= '<span class="font_underline font_bold font_small pointer subscribe_link active">Подписки</span>';

		$result .= '<span class="alertsimg" id="subcribe_user"></span>';
		$result .= '</div>';

		$subscribe_companies_array =  get_field('user_subscriptions_posts','user_'.$userid);
		$subscribe_companies_array = is_array( $subscribe_companies_array ) ? $subscribe_companies_array : array();

		$result .= '<ul class="companies_subscribed">';
		foreach ( $subscribe_companies_array as $item ) {
			$review_logo_temp = review_logo($item);
			$review_logo_temp = str_replace("div", "li", $review_logo_temp);
			$result .= $review_logo_temp;
		}
		$result .= '</ul>';
		$result .= '<span class="font_small">';
		if (is_array($subscribe_companies_array) == false) {
			$subscribe_companies_array_count = 0;
		} else {
			$subscribe_companies_array_count = count($subscribe_companies_array);
		}
		if ($type == "dashboard") {
			$result .= __('Вы подписаны на','er_theme').' ' . $subscribe_companies_array_count . ' ' . counted_text( $subscribe_companies_array_count, __( 'компанию', 'er_theme' ), __( 'компании', 'er_theme' ), __( 'компаний', 'er_theme' ) );
		} else {
			if ($subscribe_companies_array_count != 0) {
				$result .= 'Пользователь подписан на ' . $subscribe_companies_array_count. ' ' . counted_text( $subscribe_companies_array_count, __( 'компанию', 'er_theme' ), __( 'компании', 'er_theme' ), __( 'компаний', 'er_theme' ) );
			}

		}
		$result .= '</span>';
		$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}

if(!function_exists('user_subscribe_data_dashboard_horizontal')) {

	function user_subscribe_data_dashboard_horizontal($userid,$type, $mobile = FALSE, $pc = FALSE) {


		if ($type == "dashboard") {
			if ($pc == TRUE) {
				$result = '<div class="side_block white_block subscribe_widget subscribe_widget_user_profile subscribe_widget_user_dashboard border_radius_4px isdesctop">';
			} else {
				$result = '<div class="side_block white_block subscribe_widget subscribe_widget_user_profile subscribe_widget_user_dashboard border_radius_4px">';
			}

		} else {
			$result = '<div class="side_block white_block subscribe_widget subscribe_widget_user_profile">';
		}

		$result .= '<div class="subscribe_widget_user_dashboard_horizontal flex justify-content-space-between">';


		$subscribe_companies_array =  get_field('user_subscriptions_posts','user_'.$userid);
		$subscribe_companies_array = is_array( $subscribe_companies_array ) ? $subscribe_companies_array : array();

		$result .= '<ul class="companies_subscribed">';
		foreach ( $subscribe_companies_array as $item ) {
			$review_logo_temp = review_logo($item);
			$review_logo_temp = str_replace("div", "li", $review_logo_temp);
			$result .= $review_logo_temp;
		}
		$result .= '</ul>';
		$result .= '<span class="font_small color_dark_gray">';
		if (is_array($subscribe_companies_array) == false) {
			$subscribe_companies_array_count = 0;
		} else {
			$subscribe_companies_array_count = count($subscribe_companies_array);
		}
		if ($type == "dashboard") {
			$result .= __('Вы подписаны на','er_theme').' ' . $subscribe_companies_array_count . ' ' . counted_text( $subscribe_companies_array_count, __( 'компанию', 'er_theme' ), __( 'компании', 'er_theme' ), __( 'компаний', 'er_theme' ) );
		} else {
			if ($subscribe_companies_array_count != 0) {
				$result .= 'Пользователь подписан на ' . $subscribe_companies_array_count. ' ' . counted_text( $subscribe_companies_array_count, __( 'компанию', 'er_theme' ), __( 'компании', 'er_theme' ), __( 'компаний', 'er_theme' ) );
			}

		}
		$result .= '</span>';

		$result .= '<div class="flex input_columns align_items_center bell_subs_horizontal">';
		//$result .= '<span class="font_underline font_bold font_small pointer subscribe_link active">Подписки</span>';

		$result .= '<span class="alertsimg" id="subcribe_user"></span>';
		$result .= '</div>';

		$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('profile_abuse_stats')) {
	function profile_abuse_stats( $user_id ) {
		$result = '';
		$args_abuse = [
			'status'     => 'approve',
			'user_id'    => $user_id,
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				]
			]
		];
		$abuse_count = count(get_comments($args_abuse));
		$result .= number_stat_profile($user_id,'Мои жалобы',$abuse_count, 0, 1);
		$count_abuses = profile_stats_count_abuses($user_id);
		$abuse_solved_count = $count_abuses['abuse_solved_count'];
		$abuse_new_count = $count_abuses['abuse_new_count'];
		$abuse_new_all_count = $count_abuses['abuse_new_all_count'];

		$result .= '<div class="new-comments-profile_wrapper flex">';
		$result .= '<div class="new-comments-profile flex justify-content-space-between">	<a href="#" class="new-comments-profile__link link_gray font_small link_no_underline font_underline_no_color">Новые</a>	<span class="new-comments-profile__number font_bold border_circle_px">'.$abuse_new_all_count.'</span></div>';
		$result .= '<div class="new-comments-profile flex justify-content-space-between">	<a href="#" class="new-comments-profile__link link_gray font_small link_no_underline font_underline_no_color">Архив</a>	<span class="new-comments-profile__number button_gray font_bold border_circle_px">'.$abuse_solved_count.'</span></div>';
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('profile_create_view')) {
	function profile_create_view( $user_id ) {
		$result = '';
		$result .= '<div class="profile_create_view block_content white_block border-color-grey border_radius_4px"><span class="soon_dashboard">Скоро</span>';
		$result .= '<div class="button button_gray pointer button_nopadding font_bold create_review font_small">Разместить обзор</div>';
		$result .= '<ul class="profile_create_view__ul ul_none">';
		$result .= '<li class="video-camera__icon-profile"><img src="/wp-content/themes/eto-razvod-1/img/video-camera__icon-profile.svg" alt=""></li>';
		$result .= '<li class="picture__icon-profile"><img src="/wp-content/themes/eto-razvod-1/img/picture__icon-profile.svg" alt=""></li>';
		$result .= '<li class="bell__icon-profile"><img src="/wp-content/themes/eto-razvod-1/img/bell__icon-profile.svg" alt=""></li>';
		$result .= '<li class="share__icon-profile"><img src="/wp-content/themes/eto-razvod-1/img/share__icon-profile.svg" alt=""></li>';
		$result .= '<li class="mic__icon-profile"><img src="/wp-content/themes/eto-razvod-1/img/mic__icon-profile.svg" alt=""></li>';
		$result .= '<li class="gear__icon-profile"><img src="/wp-content/themes/eto-razvod-1/img/gear__icon-profile.svg" alt=""></li>';
		$result .= '</ul>';
		$result .= '</div>';
		return '';
	}
}

if (!function_exists('user_dashboard_comments')) {
	function user_dashboard_comments() {
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		$result = print_css_links('user_page');
		$result .= print_js_links()['user_page'];
		$result .= print_js_links()['show_block'];
		$result .= print_css_links('show_block');
		$result .= print_js_links()['comments_loader_dashboard'];
		$result .= print_js_links()['user_zero_message'];
		$result .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result .= '<div class="page_content page_container background_light review_container_about visible">';
		$result .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result .= '        <div class="profile-wrapper">';
		$result .= '            <div class="profile-wrapper__left">';

		$result .= user_menu($current_user,$user_id,'comments');
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center profile-wrapper__center_sub_dashboard_comments">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= review_container_comments_profile();
		$result .= '</div>';
		$result .= '            <div class="profile-wrapper__right">'.'<div class="side_block white_block block_content border_radius_4px comment_user_page_profile_comments_stats">'.profile_comments_stats($user_id,'Отклики на отзывы',1,0).'</div>'.add_company($user_id).fast_links_profile( $user_id ,'noborder',[['/dashboard/services/pro/','Включить аккаунт PRO'],['/advices/','Полезные советы'],['/user-edit/','Как заполнить аккаунт'],['/user-help/','Помощь']]).menu_footer_links(true).'</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}

if (!function_exists('user_dashboard_abuses')) {
	function user_dashboard_abuses() {
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		$result = print_css_links('user_page');
		$result .= print_js_links()['user_page'];
		$result .= print_js_links()['show_block'];
		$result .= print_css_links('show_block');
		$result .= print_js_links()['abuses_loader_dashboard'];
		$result .= print_js_links()['user_zero_message'];
		//$links['user_zero_message']
		$result .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result .= '<div class="page_content page_container background_light review_container_about visible">';
		$result .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result .= '        <div class="profile-wrapper">';
		$result .= '            <div class="profile-wrapper__left">';

		$result .= user_menu($current_user,$user_id,'abuses');
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= review_container_abuses_profile();
		$result .= '</div>';
		$result .= '            <div class="profile-wrapper__right">'.user_abuses_stat_sidebar($user_id).add_company($user_id).user_abuses_stat_mini_sidebar($user_id).fast_links_profile( $user_id ,'noborder',[['/dashboard/services/pro/','Включить аккаунт PRO'],['/advices/','Полезные советы'],['/user-edit/','Как заполнить аккаунт'],['/user-help/','Помощь']]).menu_footer_links(true).'</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}

//if (!function_exists('user_adress')) {
//	function user_adress($userid) {
//		$result = '';
//		$result .= '<div class="container_side flex flex_column">';
//		$result .= '<div class="side_block white_block">';
//		$result .= '<div class="block_title_edit color_dark_blue">' . __( 'Адрес', 'er_theme' ) . '<span class="edit-icon-wrapper"><span class="settings_editor"></span><span class="edit_editor pointer"></span></span></div>';
//		$result .= '<div class="block_content side_block_column">127006, Москва, пер. Настасьинский, д. 7, стр. 2 Россия</div>';
//		$result .= '</div>';
//		$result .= '</div>';
//		return $result;
//	}
//}

if (!function_exists('get_user_name_ones')) {
	function get_user_name_ones($userid) {
		$userdata = get_userdata( $userid );

		$user_title = '';
		if ($userdata->first_name && !$userdata->last_name) {
			$user_title .= $userdata->first_name;
		} elseif (!$userdata->first_name && $userdata->last_name) {
			$user_title .= $userdata->last_name;
		} elseif ($userdata->first_name && $userdata->last_name) {
			$user_title .= $userdata->first_name . ' ' . $userdata->last_name;
		} else {
			$user_title .= $userdata->user_nicename;
		}
		return $user_title;
	}
}
if (!function_exists('user_edit_avatar_block')) {
	function user_edit_avatar_block($userid) {
		$result = '';
		$get_userdata = get_userdata($userid);
		$result .= '<div class="container_side flex flex_column user_edit_bar" data-name="'.$get_userdata->user_nicename.'">';
		$result .= '<div class="side_block white_block border_radius_4px">';
		$result .= '<div class="block_title_edit color_dark_blue justify-content-flex-end"><span class="edit-icon-wrapper justify-content-flex-end"><span class="edit_editor pointer" data-type="edit-profile"></span></span></div>';
		$result .= '<div class="block_content side_block_column align-items-center user_edit_avatar_block_wrapper">';
		$result .= '<div class="profile_logo"';
		$logo = get_field('photo_profile', 'user_'. $userid );

		if($logo && !empty($logo)) {
			//$logo['sizes']['medium'] = str_replace("beta2.", "", $logo['sizes']['medium']);
			$result .= ' style="background-image:url('.$logo['sizes']['medium'].');background-size: cover;"';
		} else {
			$result .= ' style="background-image: url(/wp-content/themes/eto-razvod-1/img/icon_user_default.svg);background-size: cover;border: 1px solid #cfdadf;"';
		}

		$result .= '></div>';
		$result .= '<span class="font_medium font_bold user_edit_avatar_block_title">'.get_user_name_ones($userid).'</span>';
		$country = get_field('adress_country','user_'.$userid);
		$city = get_field('adress_city','user_'.$userid);
		if ($country && $city) {
			$result .= '<span class="font_small title_desc_mini color_dark_blue">'.$city.', '.get_term( $country, 'countries')->name.'</span>';
		} elseif ($country) {
			$result .= '<span class="font_small title_desc_mini color_dark_blue">'.$country.'</span>';
		}

		$result .= '<span class="font_small color_light_gray title_desc_mini">'.$get_userdata->user_email.'</span>';
		$user_skills = get_field( 'user_skills', 'user_' . $userid );
		if ($user_skills) {

		} else {
			$result .= '<span class="skills-comments__add_s grey_color_bg color_dark_blue pointer active skills-comments__add_from_sidebar">Добавьте ваши интересы</span>';
		}

		$result .= '<ul class="ul_none social-ul">';
		$result .= '<li class="social-ul__item social-ul__item_twitter"></li>';
		//$result .= '<li class="social-ul__item social-ul__item_gplus"></li>';
		$result .= '<li class="social-ul__item social-ul__item_rss"></li>';
		$result .= '<li class="social-ul__item social-ul__item_whatsapp"></li>';
		$result .= '<li class="social-ul__item social-ul__item_skype"></li>';
		$result .= '</ul>';
		if (   !( (    get_field('user_activation', 'user_'.$userid ) == '') || (get_field('user_activation', 'user_'. $userid ) == 'no'))) {
			$result .= '<span class="button font_bold button_green link_no_underline user_edit_avatar_block_profile_confirm activated_profile">Подтвержденный профиль</span>';
		} else {
			$result .= '<span class="button font_bold button_violet pointer link_no_underline user_edit_avatar_block_profile_confirm nonactivated_profile">Подтвердить профиль</span>';
		}

		$result .= '</div>';


		$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('user_dashboard_profile_editor')) {
	function user_dashboard_profile_editor() {
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		$result = print_css_links('user_page');
		$result .= print_js_links()['user_page'];
		$result .= print_js_links()['user_editor'];
		$result .= print_css_links('user_form');
		$result .= print_css_links('popup_forms');
//		$result .= print_js_links()['show_block'];
//		$result .= print_css_links('show_block');
		$result .= print_css_links('user_editor');
		//$result .= print_js_links()['comments_loader_dashboard'];
		//$result .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result .= '<div class="page_content page_container background_light review_container_about visible">';
		$result .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result .= '        <div class="profile-wrapper">';
		$result .= '            <div class="profile-wrapper__left">';

		$result .= user_menu($current_user,$user_id,'user');
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= '<div class="comment_bar_info_wrapper comment_bar_info_wrapper_user_editor">'.profile_comments($user_id,NULL,'skills').'</div>';
		$result .= profile_container_about($user_id,NULL,'desc','show');

//			if (get_field('from_site_send', 'user_'.$user_id)) {
				if (intval(get_field('from_site_send', 'user_'.$user_id)) == 1) {
					$from_site_send = ' checked="checked"';
				} else {
					$from_site_send = '';
				}
//			} else {
//				$from_site_send = ' checked="checked"';
//			}
			
			if (get_field('all_send', 'user_'.$user_id)) {
				if (intval(get_field('all_send', 'user_'.$user_id)) == 1) {
					$all_send = ' checked="checked"';
				} else {
					$all_send = '';
				}
			} else {
				$all_send = '';
			}
			
			if (get_field('tematics_send', 'user_'.$user_id)) {
				if (intval(get_field('tematics_send', 'user_'.$user_id)) == 1) {
					$tematics_send = ' checked="checked"';
				} else {
					$tematics_send = '';
				}
			} else {
				$tematics_send = '';
			}
			
			$result .= '<div class="user-desc user-desc__border border_radius_4px" style="line-height: 0;">
<span class="skills-comments__title color_dark_blue font_bold font_uppercase">Уведомления и рассылки</span>
<div class="notify-all">
<div class="checkbox_container m_b_10 font_small color_dark_blue"><input type="checkbox" id="tech_notify" name="tech_notify" '.$from_site_send.' class="custom-checkbox custom-checkbox-green"><label for="tech_notify">Уведомления сайта</label></div>';
			$result .= '<div class="checkbox_container m_b_10 font_small color_dark_blue"><input type="checkbox" id="main_notify" name="main_notify" '.$all_send.' class="custom-checkbox custom-checkbox-green"><label for="main_notify">Общая рассылка</label></div>';
			$result .= '<div class="checkbox_container m_b_10 font_small color_dark_blue"><input type="checkbox" id="insterest_notify" name="insterest_notify" '.$tematics_send.' class="custom-checkbox custom-checkbox-green"><label for="insterest_notify">Тематическая рассылка</label></div></div><div class="button button_gray pointer button_nopadding font_bold mb20 savenotify">Сохранить</div></div>';

		$result .= '</div>';
		$result .= '            <div class="profile-wrapper__right_sub">'.user_edit_avatar_block($user_id).'<div class="container_side flex flex_column">'.user_contacts_sidebar($user_id,'edit').'</div>'.fast_links_profile( $user_id ,'noborder',[['/dashboard/services/pro/','Включить аккаунт PRO'],['/advices/','Полезные советы'],['/user-edit/','Как заполнить аккаунт'],['/user-help/','Помощь']]).menu_footer_links(true).'</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}

if(!function_exists('user_form')) {
	add_action( 'wp_ajax_user_form', 'user_form' );
	add_action( 'wp_ajax_nopriv_user_form', 'user_form' );

	function user_form() {
		$userid = intval($_POST['userid']);
		$user_info = get_userdata($userid);
		$service = htmlspecialchars($_POST['service']);
		$type = htmlspecialchars($_POST['type']);
		$typespend = htmlspecialchars($_POST['typespend']);



		$result = '';
		$result .= '<div class="popup_container" id="popup_edit_user_form">';
		$result .= '<div class="popup_window box_shadow border_radius_4px">';
		if ($type == 'edit_skills_popup') {
			$result .= '<div class="popup_close_button pointer turn_off_skills" data-close="popup_edit_user_form" onclick="set_cookie_skills()"></div>';
		} else {
			$result .= '<div class="popup_close_button pointer" data-close="popup_edit_user_form"></div>';
		}
		$result .= '<div class="flex_column user_popup_form_edit user-form test_class">';
		if ($type == 'edit-profile') {
			$result .= edit_profile($userid,$user_info);
		} elseif ($type == 'edit-contacts') {
			$result .= edit_contacts($userid,$user_info);
		}  elseif ($type == 'edit-about') {
			$result .= edit_about($userid,$user_info);
		}  elseif ($type == 'edit_skills_popup') {
			//$userid

			$current_user = wp_get_current_user();
			$userid = $current_user->ID;
			$result .= edit_skills_popup($userid,$user_info,$typespend);
		}  elseif ($type == 'service_popup') {
			$result .= service_popup($userid,$user_info,$typespend,$service);
		}
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}

if ( ! function_exists( 'edit_profile' ) ) {
	function edit_profile($userid,$user_info) {
		$result = '<span class="user-form__title color_dark_blue">' . __( 'Данные пользователя', 'er_theme' ) . '</span>';
		$result .= '<div class="flex justify-content-center user-form__avatar">';
		$result .= '<div class="profile_logo"';
		$logo = get_field('photo_profile', 'user_'. $userid );
		$adress = get_field('adress', 'user_'. $userid );

		if($logo && !empty($logo)) {
			//$logo['sizes']['medium'] = str_replace("beta2.", "", $logo['sizes']['medium']);
			$result .= ' style="background-image:url('.$logo['sizes']['medium'].');background-size: cover;"';
		} else {
			$result .= ' style="background-image: url(/wp-content/themes/eto-razvod-1/img/icon_user_default.svg);background-size: cover;border: 1px solid #cfdadf;"';
		}

		$result .= '></div>';
		$result .= '<span class="edit-button-profile pointer edit-button-profile-avatar"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M4.12379 15.0227L0.181736 15.0338L0.173828 11.0728L10.8783 0.456075C11.0223 0.311518 11.1933 0.196807 11.3817 0.118542C11.5702 0.0402772 11.7722 0 11.9763 0C12.1803 0 12.3823 0.0402772 12.5708 0.118542C12.7592 0.196807 12.9303 0.311518 13.0744 0.456075L14.7176 2.10715C14.8623 2.25175 14.977 2.42343 15.0553 2.61239C15.1336 2.80134 15.1738 3.00387 15.1738 3.2084C15.1738 3.41293 15.1336 3.61546 15.0553 3.80441C14.977 3.99337 14.8623 4.16505 14.7176 4.30965L4.12379 15.0227ZM1.75381 13.4427H4.12379L1.75381 11.0728V13.4427ZM11.9763 1.55732L3.33379 10.2828L4.91378 11.8628L13.6195 3.2084L11.9763 1.55732Z" fill="#001640"></path>
</svg>
</span>';
		if($logo && !empty($logo)) {
			$result .= '<span class="pointer remove-button-profile-avatar"></span>';
		} else {
			$result .= '<span class="pointer remove-button-profile-avatar" style="display: none;"></span>';
		}
		$result .= '</div>';
		$result .= '<div class="flex user-form__twoinputs">';

		if ( ( $user_info->first_name != '' ) ) {
			$result .= '<input type="text" name="firstname" placeholder="Имя" class="input_big m_b_10 placeholder_dark border_radius_4px" value="' . $user_info->first_name . '">';
		} else {
			$result .= '<input type="text" name="firstname" placeholder="Имя" class="input_big m_b_10 placeholder_dark border_radius_4px">';
		}
		if ( $user_info->last_name != '' ) {
			$result .= '<input type="text" name="lastname" placeholder="Фамилия" class="input_big m_b_10 placeholder_dark border_radius_4px" value="' . $user_info->last_name . '">';
		} else {
			$result .= '<input type="text" name="lastname" placeholder="Фамилия" class="input_big m_b_10 placeholder_dark border_radius_4px">';
		}
		$result .= '</div>';
		
		if (get_field('from_site_send', 'user_'.$userid)) {
			if (intval(get_field('from_site_send', 'user_'.$userid)) == 1) {
				$from_site_send = 1;
			} else {
				$from_site_send = 0;
			}
		} else {
			$from_site_send = 1;
		}
		
		if (get_field('all_send', 'user_'.$userid)) {
			if (intval(get_field('all_send', 'user_'.$userid)) == 1) {
				$all_send = 1;
			} else {
				$all_send = 0;
			}
		} else {
			$all_send = 0;
		}
		
		if (get_field('tematics_send', 'user_'.$userid)) {
			if (intval(get_field('tematics_send', 'user_'.$userid)) == 1) {
				$tematics_send = 1;
			} else {
				$tematics_send = 0;
			}
		} else {
			$tematics_send = 0;
		}
		
		
		$result .= '<span class="notifystatused" data-from_site_send="'.$from_site_send.'" data-all_send="'.$all_send.'"  data-tematics_send="'.$tematics_send.'"></span>';
		$result .= '<span class="user-form__title user-form__title_mt_40 color_dark_blue user-form__title_flex">E-mail <span class="edit_email pointer flex"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M4.12379 15.0227L0.181736 15.0338L0.173828 11.0728L10.8783 0.456075C11.0223 0.311518 11.1933 0.196807 11.3817 0.118542C11.5702 0.0402772 11.7722 0 11.9763 0C12.1803 0 12.3823 0.0402772 12.5708 0.118542C12.7592 0.196807 12.9303 0.311518 13.0744 0.456075L14.7176 2.10715C14.8623 2.25175 14.977 2.42343 15.0553 2.61239C15.1336 2.80134 15.1738 3.00387 15.1738 3.2084C15.1738 3.41293 15.1336 3.61546 15.0553 3.80441C14.977 3.99337 14.8623 4.16505 14.7176 4.30965L4.12379 15.0227ZM1.75381 13.4427H4.12379L1.75381 11.0728V13.4427ZM11.9763 1.55732L3.33379 10.2828L4.91378 11.8628L13.6195 3.2084L11.9763 1.55732Z" fill="#001640"></path>
</svg></span></span>';
		$user_info = get_userdata($userid);
		$result .= '<div class="flex w_input_100 email_input input_locked"><input type="text" name="email_name" placeholder="E-mail адрес" class="input_big m_b_10 placeholder_dark border_radius_4px" value="'.$user_info->data->user_email.'" data-mail="'.$user_info->data->user_email.'"></div>';
		$result .= '<div class="button button_green radius_small m_b_10 pointer submit-user-emails displaynone">Обновить E-mail</div>';
		if (get_field('new_email_field','user_'.$userid)) {
			$result .= '<span class="about_email color_dark_blue font_small">На E-mail адрес '.get_field('new_email_field','user_'.$userid).' отправлено письмо со ссылкой для изменения действующего E-mail адреса в профиле</span>';
		} else {
			$result .= '<span class="about_email color_dark_blue font_small"></span>';
		}
		
		$result .= '<span class="user-form__title user-form__title_mt_40 color_dark_blue user-form__title_flex">Пароль <span class="edit_password pointer flex"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M4.12379 15.0227L0.181736 15.0338L0.173828 11.0728L10.8783 0.456075C11.0223 0.311518 11.1933 0.196807 11.3817 0.118542C11.5702 0.0402772 11.7722 0 11.9763 0C12.1803 0 12.3823 0.0402772 12.5708 0.118542C12.7592 0.196807 12.9303 0.311518 13.0744 0.456075L14.7176 2.10715C14.8623 2.25175 14.977 2.42343 15.0553 2.61239C15.1336 2.80134 15.1738 3.00387 15.1738 3.2084C15.1738 3.41293 15.1336 3.61546 15.0553 3.80441C14.977 3.99337 14.8623 4.16505 14.7176 4.30965L4.12379 15.0227ZM1.75381 13.4427H4.12379L1.75381 11.0728V13.4427ZM11.9763 1.55732L3.33379 10.2828L4.91378 11.8628L13.6195 3.2084L11.9763 1.55732Z" fill="#001640"></path>
</svg></span></span>';
		$eye = '<span class="showpsw"><span class="eye-show"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="eye" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-eye fa-w-18 fa-7x"><path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z" class=""></path></svg></span><span class="eye-closed displaynone"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="eye-slash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-eye-slash fa-w-20 fa-7x"><path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z" class=""></path></svg></span></span>';
		$result .= '<div class="flex w_input_100 input_locked psw_input"><input type="text" name="password_1" placeholder="Пароль" class="input_big m_b_10 placeholder_dark border_radius_4px" value="">'.$eye.'</div>';
		$result .= '<div class="flex w_input_100 input_locked psw_input"><input type="text" name="password_2" placeholder="Повторите пароль" class="input_big m_b_10 placeholder_dark border_radius_4px" value="">'.$eye.'</div>';
		$result .= '<div class="button button_green radius_small m_b_10 pointer displaynone update_password">Обновить пароль</div>';
		$result .= '<span class="about_psw color_dark_blue font_small"></span>';


		/*$result .= '<div class="flex">';
		$result .= '<select name="select_specialization" class="select_big m_b_10 border_radius_4px select_arrow">';
		$result .= '<option selected="selected">Выберите специализацию</option>';
		$result .= '<option>1</option>';
		$result .= '<option>2</option>';
		$result .= '<option>3</option>';
		$result .= '<option>4</option>';
		$result .= '</select>';
		$result .= '</div>';*/
		//$result .= '<span class="user-form__title user-form__title_mt_40 color_dark_blue">' . __( 'Местоположение', 'er_theme' ) . '</span>';

		/**/
		
		$result .= '<div class="select__country" id="select__country">';
		$result .= '<div class="flex w_input_100 input__country" >';
		$result .= '<input id="name__country" type="text" class="input_big m_b_10 placeholder_dark border_radius_4px" value="'.$adress['country2'].'" name="name__country" placeholder="' . __( 'Начните вводить название страны', 'er_theme' ) . '" class="input_big m_b_10 placeholder_dark border_radius_4px">';
		$result .= '</div>';
		$result .= '<div class="country_search_icon_close"></div>';
		$result .= '<div class="block_search_results"></div>';
		$result .= '</div>';

		/*$result .= '<div class="flex autocomplete_county w_input_100" style="display:none">';
		$result .= '<input name="autocomplete_county" type="text" value="" id="autocomplete_county" class="input_big m_b_10 placeholder_dark border_radius_4px" />';
		$result .= '</div>';*/
		$adress_city = $adress['city'];
		if ( ( $adress_city != '' ) ) {
			$result .= '<div class="city_input" id="city_input">';
		} else {
			$result .= '<div class="city_input" id="city_input" style="display:none">';
		}
		
		$result .= '<div class="flex w_input_100">';
		$result .= '<input id="name__city" type="text" class="name__city input_big m_b_10 placeholder_dark border_radius_4px" name="name__city" value="'.$adress_city.'" placeholder="' . __( 'Начните вводить название города', 'er_theme' ) . '" class="input_big m_b_10 placeholder_dark border_radius_4px">';
		$result .= '</div>';
		$result .= '<div class="block_search_results"></div>';
		$result .= '</div>';

		$result .= '<span class="user-form__title user-form__title_mt_40 color_dark_blue">' . __( 'Подключить мои социальные сети', 'er_theme' ) . '</span>';

		$result .= '<ul class="ul_none social-ul user-form__social_mb_40">';
		$result .= '<li class="social-ul__item social-ul__item_twitter"></li>';
		$result .= '<li class="social-ul__item social-ul__item_rss"></li>';
		$result .= '<li class="social-ul__item social-ul__item_whatsapp"></li>';
		$result .= '<li class="social-ul__item social-ul__item_skype"></li>';
		$result .= '</ul>';

		$result .= '<div class="button button_gray pointer button_nopadding font_bold update_user_editor for_user_editor">' . __( 'Сохранить', 'er_theme' ) . '</div>';

		return $result;
	}
}

if (!function_exists('ajax_vk_load_cities')) {
	add_action('wp_ajax_ajax_vk_load_cities', 'ajax_vk_load_cities');
	add_action('wp_ajax_nopriv_ajax_vk_load_cities', 'ajax_vk_load_cities');
	function ajax_vk_load_cities() {
		$result = '';
		$data = $_POST;
		//echo $data['q'];
		if($data['country'] && $data['country'] != '') {
			$country = $data['country'];
		} else {
			$country = 1;
		}
		if($data['q'] && $data['q'] != '') {
			$query = '&q='.$data['q'];
		} else {
			$query = '';
		}
		$cities = file_get_contents("https://api.vk.com/method/database.getCities?country_id=".$country."&access_token=d6666074d6666074d6666074c7d63e5e41dd666d6666074895a807a6973647a9da0f241&v=5.130&count=100".$query."&lang=ru");
		$cities = json_decode($cities);
		//var_dump($country);
		$result .= '<div class="city_fields">';
		$result .= '<ul>';
		if(!empty($cities->response->items)) {
		
			foreach($cities->response->items as $item) {
				$result .= '<li data-city-id="'.$item->id.'">';
					$result .= '<div class="city_title">'.$item->title.'</div>';
					if($item->area && $item->area != '') {
						$result .= '<div class="city_area font_small color_gray">'.$item->area.'</div>';
					}
					if($item->region && $item->region != '') {
						$result .= '<div class="city_region font_small color_gray">'.$item->region.'</div>';
					}
					
				$result .= '</li>';
			}
		}
		$result .= '</ul>';
		$result .= '</div>';
	
		echo $result;
		die;
	}
}

if (!function_exists('ajax_vk_load_countries')) {
	add_action('wp_ajax_ajax_vk_load_countries', 'ajax_vk_load_countries');
	add_action('wp_ajax_nopriv_ajax_vk_load_countries', 'ajax_vk_load_countries');
	function ajax_vk_load_countries() {
		$result = '';
		
		$items = file_get_contents("https://api.vk.com/method/database.getCountries?need_all=1&count=300&access_token=d6666074d6666074d6666074c7d63e5e41dd666d6666074895a807a6973647a9da0f241&v=5.130&lang=ru");
		$items = json_decode($items);
		//print_r($_POST['q']);
		
		$result .= '<div class="user_field_countries">';
		
		if(!empty($items->response->items)) {
			$result .= '<ul>';
			foreach($items->response->items as $item) {
				if($_POST['q'] && $_POST['q'] != '') {
					$pos = mb_stripos($item->title, $_POST['q']);
					if ($pos !== false) {
						$result .= '<li data-country-id="'.$item->id.'">'.$item->title.'</li>';
					}
				} else {
					$result .= '<li data-country-id="'.$item->id.'">'.$item->title.'</li>';
				}
			}
			$result .= '</ul>';
		}
		$result .= '</div>';
		echo $result;
		die;
	}
}

if ( ! function_exists( 'edit_contacts' ) ) {
	function edit_contacts($userid,$user_info) {
		$contacts_email = get_field('contacts_e-mail','user_'.$userid);
		$contacts_skype = get_field('contacts_skype','user_'.$userid);
		$contacts_telegram = get_field('contacts_telegram','user_'.$userid);
		$result = '<div class="flex flex_column">';
		$result .= '<span class="user-form__title color_dark_blue">' . __( 'Контакты', 'er_theme' ) . '</span>';
if ((    get_field('services_user_services','user_'.$userid)[0] != 84175) && (get_field('services_user_services','user_'.$userid) != 84175)) {
	$result .= '<span class="title_not_work_without_pro">Эти контакты публикуются в открытом доступе только для аккаунтов<span class="user_label_profile_mini">PRO</span></span>';
}
		$result .= '<input type="text" name="profile_mail_input" placeholder="E-mail" class="input_big m_b_10 placeholder_dark border_radius_4px profile_mail_input contacts_input" value="'.$contacts_email.'">';
		$result .= '<input type="text" name="profile_skype_mail_input" placeholder="Skype" class="input_big m_b_10 placeholder_dark border_radius_4px profile_skype_mail_input contacts_input" value="'.$contacts_skype.'">';
		$result .= '<input type="text" name="profile_telegram_mail_input" placeholder="Telegram" class="input_big m_b_10 placeholder_dark border_radius_4px profile_telegram_mail_input contacts_input" value="'.$contacts_telegram.'">';
		$result .= '<div class="button button_gray pointer button_nopadding font_bold update_user_editor_contacts for_user_editor">' . __( 'Сохранить', 'er_theme' ) . '</div>';
		$result .= '</div>';
		return $result;
	}
}

if ( ! function_exists( 'edit_about' ) ) {
	function edit_about($userid,$user_info) {
		$user_desc = get_field('user_desc','user_'.$userid);
		if ($user_desc == 'undefined') {
			$user_desc = '';
		}
		$result = '<div class="flex flex_column textarea_about_wrapper">';
		$result .= '<span class="user-form__title color_dark_blue">' . __( 'Редактирование', 'er_theme' ) . '</span>';
		$result .= '<textarea name="edit_about" class="m_b_20 textarea_about">'.$user_desc.'</textarea>';
		$result .= '<div class="button button_gray pointer button_nopadding font_bold update_user_editor_about for_user_editor">' . __( 'Сохранить', 'er_theme' ) . '</div>';
		$result .= '</div>';
		return $result;
	}
}

if ( ! function_exists( 'edit_skills_popup' ) ) {
	function edit_skills_popup($userid,$user_info,$typespend) {
		$result = '';
		if (($typespend == 'reg') || ($typespend == 'simpleform')) {
			$result .= print_css_links( 'user_skills' );
		}
		$result .= '<div class="flex flex_column edit_skills_popup" data-skills="'.strlen(get_field('user_skills','user_'.$userid)[0]).'">';
		if ($typespend == 'reg') {
			$result .= '<span class="user-form__title color_dark_blue user-form__title_reg">' . __( 'Поздравляем!', 'er_theme' ) . '</span>';
			$result .= '<span class="user-form_title-under">Вы успешно зарегистрировались на нашем сайте.</span>';
			$result .= '<span class="user-form_title-under-second font_small color_darker_gray">Настройте ваши интересы, чтобы мы лучше понимали вас.</span>';
		} elseif ($typespend == 'simpleform') {
			$result .= '<span class="user-form_title-under-second font_small color_darker_gray">Настройте ваши интересы, чтобы мы лучше понимали вас.</span>';
		} else {
			$result .= '<span class="user-form__title color_dark_blue">' . __( 'Добавить интерес', 'er_theme' ) . '</span>';
		}



		$result .= autocomplete_input( 'ratings_all_filter_autocomplete_skills', 'filter_ratings', 'Начните вводить текст' );




		/*$result .= '<select name="select_skills" id="select_skills" class="select_big m_b_10 border_radius_4px select_arrow"><option selected="selected">Выберите навык</option>';
		$terms = get_terms( [

			'taxonomy' => 'affiliate-tags',
			'orderby' => 'meta_value',
			'order' => 'ASC',
			'meta_key' => 'tag_human_title',
			'hide_empty' => false,
			'hierarchical' => false,
		] );
		$cyr = [];$eng = [];
		foreach ( $terms as $term ) {
			$tag_human_title = get_field( 'tag_human_title', $term );
			if ( $tag_human_title != '' ) {
				if (isRussian(mb_substr($tag_human_title, 0, 1))) {
					$cyr[] = '<option value="' . $term->term_id . '">' . $tag_human_title . '</option>';
				} else {
					$eng[] = '<option value="' . $term->term_id . '">' . $tag_human_title . '</option>';
				}
			}
		}
		foreach ( $cyr as $item ) {
			$result .= $item;
		}
		foreach ( $eng as $item ) {
			$result .= $item;
		}


		$result .= '</select>';*/
		if (($typespend == 'reg') || ($typespend == 'simpleform')) {
			//.button_violet
			$result .= '<div class="button button_violet pointer button_nopadding font_bold update_user_editor_about for_user_editor add_skills_popup" style="margin-bottom: 20px;">' . __( 'Сохранить', 'er_theme' ) . '</div>';
			$current_language = get_locale();
            if($current_language != 'ru_RU') {
                $result .= '<div class="button button_gray pointer button_nopadding font_bold update_user_editor_about for_user_editor skip_skills">' . __( 'Set up later', 'er_theme' ) . '</div>';
            } else {
                $result .= '<div class="button button_gray pointer button_nopadding font_bold update_user_editor_about for_user_editor skip_skills">' . __( 'Настроить позже', 'er_theme' ) . '</div>';
            }

		} else {
			$result .= '<div class="button button_gray pointer button_nopadding font_bold  for_user_editor add_skills_popup">' . __( 'Сохранить', 'er_theme' ) . '</div>';
		}
		$result .= '</div>';
		return $result;
	}
}

if ( ! function_exists( 'service_popup' ) ) {
	function service_popup($userid,$user_info,$typespend = 'card',$service) {
		$result = '<div class="popup_service">';
		$result .= '<div class="popup_service__header">';
		$result .= '<span class="user-form__title color_dark_blue">Активация тарифа</span> <span class="popup_service__header_balance">Баланс аккаунта <span class="popup_service__header_number_wrapper border_radius_4px"><span class="popup_service__header_number" data-balance="'.get_field('balance','user_'.$userid).'">'.number_format(get_field('balance','user_'.$userid), 0, '.', ' ').'</span> <span class="popup_service__header_valute">Р</span></span></span>';
		$result .= '</div>';
		$result .= '<div class="popup_service__middle">';
		$result .= '<div class="popup_service__middle_text">';
		$result .= 'Вы выбрали тариф <span class="popup_service__middle_servicename" data-price="400" data-id="84175">PRO</span> на <span class="popup_service__middle_brset"></span>';
		$result .= '<span class="popup_service__middle_dec-wrap"><span class="input-number-mod-decrement">–</span><input class="input-number-mod" type="text" value="1" min="1" max="110" /><span class="input-number-mod-increment">+</span></span>';
		$result .= '<span class="popup_service__middle_takewordmonth">месяц<span class="popup_service__middle_takewordmonth-continue"></span></span>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '<div class="popup_service__footer">';
		/*		$result .= '<span class="popup_service__footer_text">';
				$result .= '<span class="checkbox_get"><input type="checkbox" name="autoupdate" id="autoupdate" checked="checked" /><label for="autoupdate"></label></span>';
				$result .= '<span class="popup_service__footer_text">';
				$result .= 'Автопродление тарифа';
				$result .= '<span class="popup_service__footer_question">';
				$result .= '<span class="popup_service__footer_advice">';
				$result .= 'По истечению срока действия тарифа - мы автоматически спишем с Вашего баланса недостающую сумму. Если Вам это интересно, то оставьте опцию включенной. Позже её можно будет изменить в настройках личного кабинета';
				$result .= '</span>';
				$result .= '</span>';
				$result .= '</span>';
				$result .= '</span>';*/
		if ($typespend == 'balance') {
			$result .= '<span class="popup_service__footer_text"><span  class="checkbox_get"><input type="checkbox" name="payfrombalance" id="payfrombalance" checked="checked" /><label for="payfrombalance"></label></span><span class="popup_service__footer_text"> Использовать баланс сайта </span></span>';
		} else {
			$result .= '<span class="popup_service__footer_text"><span  class="checkbox_get"><input type="checkbox" name="payfrombalance" id="payfrombalance" /><label for="payfrombalance"></label></span><span class="popup_service__footer_text"> Использовать баланс сайта </span></span>';
		}

		$result .= '</div>';
		$result .= '<span class="popup_service__about" title-attr-1="Активация тарифа" title-attr-2="Подтверждение операции" title-attr-3="Успешная активация тарифа" data-price="400">';
		$result .= '<span class="popup_service__about_line font_small">Для активации тарифа вам нужно';
		$result .= '<span class="popup_service__about_inlinebeen">';
		$result .= '<span class="popup_service__about_show-new-window-need popup_service__about_show-new-window-wr"><span class="popup_service__about_show-new-window-inside">'.number_format(get_field('price',$service), 0, '.', ' ').'</span> <span class="rur">Р</span></span> .';
		$result .= '</span></span>';
		$result .= '<span class="popup_service__about_line font_small">На балансе вашего аккаунта на данный момент есть';
		$result .= '<span class="popup_service__about_inlinebeen">';
		$result .= '<span class="popup_service__about_show-new-window-now  popup_service__about_show-new-window-wr"><span class="popup_service__about_show-new-window-inside">'.number_format(get_field('balance','user_'.$userid), 0, '.', ' ').'</span> <span class="rur">Р</span></span> .';
		$result .= '</span></span>';
		$result .= '<span class="popup_service__about_line font_small">Вы можете переходить к оплате тарифа с баланса аккаунта.';
		$result .= '</span></span>';
		$result .= '<div class="popup_service__paybtn" style="justify-content: center;">';
		$result .= '<span class="popup_service__paybtn_this" data-back=\'.formed-wrapper-input[data-step="accept_from_card"]\' data-now=\'.formed-wrapper-input[data-step="content_tariff"],.formed-wrapper-input[data-step="another"]\'>Далее</span>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '';
		return $result;
	}
}



if(!function_exists('abuse_stats')) {

	function abuse_stats($userid, $post_type = NULL) {

		$args_sorted_all = [
			'status'     => 'approve',
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				]
			],
			'count' => true,
		];

		if ($post_type == 'post') {
			$args_sorted_all['post_id'] = $userid;
		} else {
			$args_sorted_all['user_id'] = $userid;
		}

		$args_sorted_solved = [
			'status'     => 'approve',
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				]
			]
		];

		$args_sorted_solved['meta_query'][] = array(
			'key'	 	=> 'abuse_state',
			'value'	  	=> 'solved',
			'compare' 	=> '=',
		);

		if ($post_type == 'post') {
			$args_sorted_solved['post_id'] = $userid;
		} else {
			$args_sorted_solved['user_id'] = $userid;
		}
		$args_sorted_solved['count'] = true;
		$args_sorted_ans = [
			'status'     => 'approve',
			'count'               => true,
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				]
			]
		];
		$args_sorted_ans['meta_query'][] = array(
			'key'	 	=> 'abuse_state',
			'value'	  	=> 'progress',
			'compare' 	=> '=',
		);
		if ($post_type == 'post') {
			$args_sorted_ans['post_id'] = $userid;
		} else {
			$args_sorted_ans['user_id'] = $userid;
		}
		$args_sorted_ans['count'] = true;
		$args_sorted_onlynew = [
			'status'     => 'approve',
			'count'               => true,
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				]
			]
		];
		$args_sorted_onlynew['meta_query'][] = array(
			'key'	 	=> 'abuse_state',
			'value'	  	=> 'not_seen',
			'compare' 	=> '=',
		);
		if ($post_type == 'post') {
			$args_sorted_onlynew['post_id'] = $userid;
		} else {
			$args_sorted_onlynew['user_id'] = $userid;
		}
		//echo '<pre>';
		//print_r($args_sorted_onlynew);
		//echo '</pre>';
		$args_sorted_onlynew['count'] = true;
		$args_sorted_unsolved = [
			'status'     => 'approve',
			'count'               => true,
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				]
			]
		];
		$args_sorted_unsolved['meta_query'][] = array(
			'key'	 	=> 'abuse_state',
			'value'	  	=> 'solved',
			'compare' 	=> '!=',
		);
		if ($post_type == 'post') {
			$args_sorted_unsolved['post_id'] = $userid;
		} else {
			$args_sorted_unsolved['user_id'] = $userid;
		}
		$args_sorted_unsolved['count'] = true;
		//print_r(get_comments($args_sorted_onlynew));
		$new = get_comments($args_sorted_onlynew);
		$count_abuses = ['all' => get_comments($args_sorted_all),'solved' => get_comments($args_sorted_solved),'answered' => get_comments($args_sorted_ans),'onlynew' => get_comments($args_sorted_onlynew),'unsolved' => get_comments($args_sorted_unsolved)];

		return $count_abuses;

	}
}

if (!function_exists('user_abuses_stat_sidebar')) {
	function user_abuses_stat_sidebar( $user_id ) {
		$result = '';
		$result .='<div class="side_block white_block border_radius_4px">';
		$result .='<div class="block_content side_block_column">';
		$result .= '<div class="number-stat-profile_w100">'.number_stat_profile($user_id,'Мои жалобы',abuse_stats($user_id)['all'], 0, 1).'</div>';
		$result .= '<span class="button font_bold button_violet pointer link_no_underline button_nopadding create_review link_new_abuse_outside">Подать жалобу</span>';
		$result .='</div>';
		$result .='</div>';
		return $result;
	}
}

if ( ! function_exists( 'user_abuses_stat_mini_sidebar' ) ) {
	function user_abuses_stat_mini_sidebar( $userid ) {
		$abuse_stats = abuse_stats($userid);
		$get_stat = [];
		if ($abuse_stats['answered'] != 0) {
			$get_stat['answered'] = '<span class="new-comments-profile__number font_bold border_circle_px ans_get">'.$abuse_stats['answered'].'</span>';
		} else {
			$get_stat['answered'] = '<span class="new-comments-profile__number font_bold border_circle_px ans_get">0</span>';
		}
		if ($abuse_stats['solved'] != 0) {
			$get_stat['solved'] = '<span class="new-comments-profile__number font_bold border_circle_px button_gray noans_get">'.$abuse_stats['solved'].'</span>';
		} else {
			$get_stat['solved'] = '<span class="new-comments-profile__number font_bold border_circle_px button_gray noans_get">0</span>';
		}
		if ($abuse_stats['unsolved'] != 0) {
			$get_stat['unsolved'] = '<span class="new-comments-profile__number font_bold border_circle_px button_gray noans_get">'.$abuse_stats['unsolved'].'</span>';
		} else {
			$get_stat['unsolved'] = '<span class="new-comments-profile__number font_bold border_circle_px button_gray noans_get">0</span>';
		}
		$result = '<div class="side_block white_block border_radius_4px">';
		$result .= '	<div class="block_content side_block_column">';
		$result .= '		<div class="number-stat-profile_w100">';
		$result .= '			<div class="number-stat-profile"> <span class="number-stat-profile__title">Активность</span> <span class="number-stat-profile__icon"></span></div>';
		$result .= '		</div>';
		$result .= '<ul class="ul_none abuses_mini_stats">';
		$result .= '    <li class="abuses_mini_stats__item"><span class="color_dark_gray border_no_color">Ответы</span>'.$get_stat['answered'].'</li>';
		$result .= '    <li class="abuses_mini_stats__item"><span class="color_dark_gray border_no_color">Решено</span>'.$get_stat['solved'].'</li>';
		$result .= '    <li class="abuses_mini_stats__item"><span class="color_dark_gray border_no_color">Не решено</span>'.$get_stat['unsolved'].'</li>';
		$result .= '</ul>';
		$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('user_dashboard_subscripton')) {
	function user_dashboard_subscripton() {
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		$result = print_css_links('user_page');
		$result .= print_js_links()['user_subscription'];
		$result .= print_js_links()['user_page'];
		$result .= print_js_links()['show_block'];
		$result .= print_css_links('show_block');
		$result .= print_js_links()['user_zero_message'];
		wp_enqueue_script( 'progressbar', get_template_directory_uri() . '/js/progressbar.js', array('jquery') );
		wp_enqueue_script( 'review_top', get_template_directory_uri() . '/js/review_top.js', array('jquery') );
		//$result .= print_js_links()['comments_loader_dashboard'];
		$result .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result .= '<div class="page_content page_container background_light review_container_about visible">';
		$result .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result .= '        <div class="profile-wrapper">';
		$result .= '            <div class="profile-wrapper__left">';

		$result .= user_menu($current_user,$user_id,'subscripton');
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= '<div class="subscribes_wrapper"></div>';
		$result .= '</div>';
		$result .= '            <div class="profile-wrapper__right_sub">'.get_user_subs_sidebar($user_id).add_company($user_id).fast_links_profile( $user_id ,'noborder',[['/dashboard/services/pro/','Включить аккаунт PRO'],['/advices/','Полезные советы'],['/user-edit/','Как заполнить аккаунт'],['/user-help/','Помощь']]).menu_footer_links(true).'</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}

if (!function_exists('user_dashboard_notification')) {
	function user_dashboard_notification() {
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		$result = print_css_links('user_page');
		$result .= print_js_links()['user_page'];
		$result .= print_js_links()['show_block'];
		$result .= print_css_links('show_block');
		$result .= print_js_links()['user_zero_message'];
		wp_enqueue_script( 'progressbar', get_template_directory_uri() . '/js/progressbar.js', array('jquery') );
		wp_enqueue_script( 'review_top', get_template_directory_uri() . '/js/review_top.js', array('jquery') );
		//$result .= print_js_links()['comments_loader_dashboard'];
		$result .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result .= '<div class="page_content page_container background_light review_container_about visible">';
		$result .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result .= '        <div class="profile-wrapper">';
		$result .= '            <div class="profile-wrapper__left">';

		$result .= user_menu($current_user,$user_id,'notifications');
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center dashboard_page_center">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';


		$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
			$new_items = $mydb->get_results("SELECT * FROM `notifications` WHERE `user_id` LIKE '$user_id' ORDER BY id DESC");
			$user_companies = get_field('user_subscriptions_posts','user_'.$user_id);
			/*if($user_id == 9) {
				
				if(!empty($user_companies)) {
					
					foreach ($user_companies as $user_company) {
						$new_items_2 = array();
						$new_items_2 = $mydb->get_results("SELECT * FROM `notifications` WHERE `user_id` LIKE '$user_company' AND `type` LIKE 'system_new_review_notify_company' ORDER BY id DESC");
						if(!empty($new_items_2)) {
							foreach($new_items_2 as $new_item_2) {
								$new_items[] = $new_item_2;
							}
						}
						$new_items_3 = array();
						$new_items_3 = $mydb->get_results("SELECT * FROM `notifications` WHERE `user_id` LIKE '$user_company' AND `type` LIKE 'system_new_abuse_notify_company' ORDER BY id DESC");
						if(!empty($new_items_3)) {
							foreach($new_items_3 as $new_item_3) {
								$new_items[] = $new_item_3;
							}
						}
					}
				}
				echo '<pre>';
				print_r($new_items);
				echo '</pre>';
			}*/
		
			/*if(!empty($user_companies)) {
				foreach ($user_companies as $user_company) {
					$new_items_2 = array();
					$new_items_2 = $mydb->get_results("SELECT * FROM `notifications` WHERE `user_id` LIKE '$user_id' AND `status_read` = 'new' ORDER BY id DESC LIMIT 3");
				}
			}*/
		$new_notifications = notify_check_new('notifications',$user_id);
		
		if(!empty($new_items)) {

				$type = '';
				$result .= '<ul class="popup_notifications_list">';
				foreach ($new_items as $item) {
					$result .= '<li class="notify_item notify_item_'.$type.' status_'.$item->status_read.'" data-id="'.$item->id.'">';
					if($type == 'messages' && $item->user_type =='admin') {
						$item_title = __('Администрация сайта','er_theme');
					} elseif($type == 'messages' && $item->user_type =='user') {
						$user_author = get_userdata( $item->user_id_author );
						$item_title = $user_author->display_name;
					} elseif($item->title != '') {
						$item_title = $item->title;
					} elseif($type == 'notifications' && $item->type =='system_news') {
						$item_title = __('Новости сайта','er_theme');
					}
					$result .= '<div class="item_date">'.$item->date.'</div>';
					$result .= '<div class="item_title">'.$item_title.'</div>';
					$type = 'notifications';
					if($type == 'notifications' && $item->type == 'system_new_abuse_notify_user_approved') {
						$comment_id = $item->content;
						$comment = get_comment($comment_id);
						$company_id = $comment->comment_post_ID;
						
						
						
						$company_name = get_field('company_name',$company_id);
						$company_link = get_the_permalink($company_id);
						
						$item_content = __('Ваша жалоба на компанию','er_theme').' <a href="'.$company_link.'">'.$company_name.'</a> '.__('успешно прошла модерацию. Теперь Вы можете увидеть ее на').' <a href="'.$company_link.'#abuse">'.__('странице компании','er_theme').'</a>';
					} elseif($type == 'notifications' && $item->type == 'system_new_review_notify_user_approved') {
						$comment_id = $item->content;
						$comment = get_comment($comment_id);
						$company_id = isset( $comment->comment_post_ID ) ? $comment->comment_post_ID : '';
						
						if(get_post_type($company_id) == 'casino') {
							$company_name = get_field('company_name',$company_id);
							$company_link = get_the_permalink($company_id);
							$item_content = __('Ваш отзыв на компанию','er_theme').' <a href="'.$company_link.'">'.$company_name.'</a> '.__('успешно прошел модерацию. Теперь Вы можете увидеть его на').' <a href="'.$company_link.'#comment-'.$comment_id.'">'.__('странице компании','er_theme').'</a>';
						} else {
							$company_name = get_the_title($company_id);
							$company_link = get_the_permalink($company_id);
							$item_content = __('Ваш отзыв на запись','er_theme').' <a href="'.$company_link.'">'.$company_name.'</a> '.__('успешно прошел модерацию. Теперь Вы можете увидеть его на').' <a href="'.$company_link.'#comment-'.$comment_id.'">'.__('странице записи','er_theme').'</a>';
						}
						
						
						
					} elseif($type == 'notifications' && $item->type == 'system_new_comment_notify_user_approved') {
						$comment_id = $item->content;
						$comment = get_comment($comment_id);
						$company_id = $comment->comment_post_ID;
						if(get_post_type($company_id) == 'casino' && $comment->comment_parent > 0) {
							$comment_parent = get_comment($comment->comment_parent);
							$company_name = get_field('company_name',$company_id);
							$company_link = get_the_permalink($company_id);
							$item_content = __('Ваш ответ на отзыв пользователя','er_theme').' '.$comment_parent->comment_author.__(' на компанию','er_theme').' <a href="'.$company_link.'">'.$company_name.'</a> '.__('успешно прошел модерацию. Теперь Вы можете увидеть его на').' <a href="'.$company_link.'#comment-'.$comment_id.'">'.__('странице компании','er_theme').'</a>';
						} else {
							$company_name = get_the_title($company_id);
							$company_link = get_the_permalink($company_id);
							$item_content = __('Ваш комментарий к записи','er_theme').' <a href="'.$company_link.'">'.$company_name.'</a> '.__('успешно прошел модерацию. Теперь Вы можете увидеть его на').' <a href="'.$company_link.'#comment-'.$comment_id.'">'.__('странице записи','er_theme').'</a>';
						}
						
						
						
						
					} else {
						$item_content = $item->content;
					}
					$result .= '<div class="item_content">'.$item_content.'</div>';
					if($item->status_read == 'new') {
						$result .= '<div class="read_button">'.__('Отметить прочитанным','er_theme').'</div>';
					} elseif($item->status_read == 'read') {
						$result .= '<div class="read_button_read">'.__('Прочитано','er_theme').'</div>';
					}
					
					$result .= '</li>';
				}
				$result .= '</ul>';
			}
		
		$result .= '</div>';

		$result .= '<div class="profile-wrapper__right profile-wrapper__right_dashboard">';
		$result .= '<ul class="notify_full_sorter">';
		$result .= '<li>'.__('Все уведомления','er_theme').'</li>';
		if($new_notifications > 0) {
			$result .= '<li>'.__('Новые уведомления','er_theme').'<span class="new-comments-profile__number font_bold border_circle_px" style="border-radius: 50%; padding: 0px; width: 19px;">'.$new_notifications.'</span></li>';
		}
		
		$result .= '</ul>';
		$result .= '</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}

if ( ! function_exists( 'get_user_subs_sidebar' ) ) {
	function get_user_subs_sidebar($userid) {

		$subscribe_companies_array =  get_field('user_subscriptions_posts','user_'.$userid);

		if (is_array($subscribe_companies_array) == false) {
			$subscribe_companies_array_count = 0;
			$subscribe_companies_array = array();
		} else {
			$subscribe_companies_array_count = count($subscribe_companies_array);
		}
		$result = '<div class="side_block white_block my_posts_profile border_radius_4px">';
		$result .= '    <div class="block_content side_block_column">';
		$result .= '        <div class="number-stat-profile_w100">';
		$result .= '            <div class="number-stat-profile"><span class="number-stat-profile__title">Мои подписки</span> <span class="number-stat-profile__number font_bolder font_big_medium">'.$subscribe_companies_array_count.'</span> <span class="number-stat-profile__icon"></span></div>';
		$result .= '        </div>';

		$result .= '<ul class="companies_subscribed">';
		foreach ( $subscribe_companies_array as $item ) {
			$review_logo_temp = review_logo($item);
			$review_logo_temp = str_replace("div", "li", $review_logo_temp);
			$result .= $review_logo_temp;
		}
		$result .= '</ul>';
		$result .= '<span class="font_smaller color_dark_gray">';

		$result .= __('Вы подписаны на','er_theme').' ' . $subscribe_companies_array_count . ' ' . counted_text( $subscribe_companies_array_count, __( 'компанию', 'er_theme' ), __( 'компании', 'er_theme' ), __( 'компаний', 'er_theme' ) );
		$result .= '</span>';
		$result .= '    </div>';
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('get_user_subs')) {
	add_action( 'wp_ajax_get_user_subs', 'get_user_subs' );
	add_action( 'wp_ajax_nopriv_get_user_subs', 'get_user_subs' );

	function get_user_subs() {

		$userid = intval($_POST['userid']);
		$sort_type = $_POST['sort'];
		$subscribe_companies_array = get_field( 'user_subscriptions_posts','user_'.$userid );

		if (is_array($subscribe_companies_array) == false) {
			$count_subscribe_companies_array = 0;
			$subscribe_companies_array = array();
		} else {
			$count_subscribe_companies_array = count($subscribe_companies_array);
		}


		//$result    = '<div class="subscribes_wrapper">';
		$result = print_js_links()['events'];
		$result    .= '<div class="white_block comments_top flex comment_top_dashboard_comments__header">';
		$result    .= '<div class="comments_top_title font_uppercase font_bold color_dark_blue font_small">' . __( 'Подписки', 'er_theme' ) . '</div>';
		$result    .= '<div class="comments_top_count font_bold color_dark_gray">'.$count_subscribe_companies_array.'</div>';

		$result    .= '<div class="comments_sorter_subs">';
		$result    .= '<div class="comments_sorter_title color_dark_gray pointer dropdown flex">' . __( 'Отсортировать по', 'er_theme' ) . '</div>';
		$result    .= '<ul>';
		if ( $sort_type == 'new' ) {

			$sort_new_active = ' active';
		} else {
			$sort_new_active = '';
		}
		if ( $sort_type == 'best' ) {
			$sort_best_active = ' active';
		} else {
			$sort_best_active = '';
		}
		if ( $sort_type == 'old' ) {
			$sort_old_active = ' active';
			$subscribe_companies_array = array_reverse($subscribe_companies_array);
		} else {
			$sort_old_active = '';
		}
		$result .= '<li class="sort_new color_dark_gray pointer' . $sort_new_active . '" data-sort-type="new">' . __( 'Сначала новые', 'er_theme' ) . '</li>';
		$result .= '<li class="sort_old color_dark_gray pointer' . $sort_old_active . '" data-sort-type="old">' . __( 'Сначала старые', 'er_theme' ) . '</li>';
		$result .= '</ul>';
		$result .= '</div>';
		$result .= '</div>';



		foreach ( $subscribe_companies_array as $item ) {
			$review_logo_temp = review_logo($item);
			$review_logo_temp = str_replace("review_logo", "subscribes-list-wrapper__img border_circle", $review_logo_temp);
			$result .= '<div class="subscribes-list-wrapper__item flex border_radius_4px white_block justify-content-space-between">';
			$result .=  $review_logo_temp;
			$result .= '    <div class="subscribes-list-wrapper__info subscribes-list-wrapper__info flex flex_column justify-content-center">';
			$result .= '        <div class="subscribes-list-wrapper__info_header">';
			$result .= '				<span class="subscribes-list-wrapper__titlewrapper flex">';
			$result .= '					<a class="subscribes-list-wrapper__title font_bold  color_dark_blue link_no_underline" href="'.get_permalink($item).'" target="_blank">'.get_field('company_name',$item).'</a>';
			$result .= '					<span class="subscribes-list-wrapper__settings"></span>';
			$result .= '				</span>';
			$result .= '        </div>';
			$result .= '        <div class="subscribes-list-wrapper__info_footer flex justify-content-space-between">';
			$result .= '            <div class="subscribes-list-wrapper__info_footer__links">';
			$affiliateTagsItems = get_the_terms( $item, 'affiliate-tags' );
			foreach ($affiliateTagsItems  as $term ) {
				if(get_field('er_bc_link','term_'.$term->term_id) && get_field('er_bc_text','term_'.$term->term_id) ) {
					$itemText = get_field('er_bc_text','term_'.$term->term_id);
					$itemLink = get_field('er_bc_link','term_'.$term->term_id);
					break;
				}
			}
			if (count($affiliateTagsItems) != 0) {
				$result .= '                <a href="'.$itemLink.'" class="color_dark_blue link_no_underline border_bottom_dotted font_small text">'.$itemText.'</a>';
			}
			$result .= '            </div>';
			$result .= '            <div class="subscribes-list-wrapper__info_footer__stats">';
			$result .= '                <span class="subscribes-list-wrapper__info_footer__commends color_dark_gray"><span class="subscribes-list-wrapper__info_footer__commendsnumbers color_dark_blue font_underline font_smaller">'.get_comments_number( $item ).'</span> отзывов</span>';
			$result .= '                <span class="subscribes-list-wrapper__info_footer__plus color_green font_bold font_smaller">+9</span>';
			$result .= '                <span class="subscribes-list-wrapper__info_footer__red color_red font_bold font_smaller">+9</span>';
			$result .= '            </div>';
			$result .= '        </div>';
			$result .= '    </div>';
			$result .= '    <div class="subscribes-list-wrapper__rate">';
			$result .= '        <div class="flex flex_column">'.review_top_rating($item,false).'</div>';
			$result .= '    </div>';

			$result .= '<div class="ismobile_flex">';
			$result .= '<div class="first_column">';
			$result .=  $review_logo_temp;
			$result .= '				<span class="subscribes-list-wrapper__titlewrapper flex">';
			$result .= '					<a class="subscribes-list-wrapper__title font_bold  color_dark_blue link_no_underline" href="'.get_permalink($item).'" target="_blank">'.get_field('company_name',$item).'</a>';
			$result .= '					<span class="subscribes-list-wrapper__settings"></span>';
			$result .= '				</span>';
			$result .= '        </div>';

			$result .= '<div class="second_column">';
			$result .= '            <div class="subscribes-list-wrapper__info_footer__stats">';
			$result .= '                <span class="subscribes-list-wrapper__info_footer__commends color_dark_gray"><span class="subscribes-list-wrapper__info_footer__commendsnumbers color_dark_blue font_underline font_smaller">'.get_comments_number( $item ).'</span> отзывов</span>';
			$result .= '                <span class="subscribes-list-wrapper__info_footer__plus color_green font_bold font_smaller">+9</span>';
			$result .= '                <span class="subscribes-list-wrapper__info_footer__red color_red font_bold font_smaller">+9</span>';
			$result .= '            </div>';
			$result .= '        <div class="subscribes-list-wrapper__info_footer flex justify-content-space-between">';
			$result .= '            <div class="subscribes-list-wrapper__info_footer__links">';
			$affiliateTagsItems = get_the_terms( $item, 'affiliate-tags' );
			foreach ($affiliateTagsItems  as $term ) {
				if(get_field('er_bc_link','term_'.$term->term_id) && get_field('er_bc_text','term_'.$term->term_id) ) {
					$itemText = get_field('er_bc_text','term_'.$term->term_id);
					$itemLink = get_field('er_bc_link','term_'.$term->term_id);
					break;
				}
			}
			if (count($affiliateTagsItems) != 0) {
				$result .= '                <a href="'.$itemLink.'" class="color_dark_blue link_no_underline border_bottom_dotted font_small text">'.$itemText.'</a>';
			}
			$result .= '            </div>';

			$result .= '        </div>';
			$result .= '</div>';


			$result .= '<div class="third_column">';
			if(function_exists('get_rating_fields_group')) {
				$rating_fields_group = get_rating_fields_group($item);
			} else {
				$rating_fields_group = 0;
			}
			$result .= '<div class="stars_and_reviews flex">';
			//$result .=  get_post_stars($rating_fields_group);
			//$result .= get_post_rating($group_id,'value');
			$percents = get_post_rating($rating_fields_group,'stars',$item);
			$result .= '<div class="stars flex">';
			$y = 0;
			foreach (range(1, 5) as $i) {
				$y++;
				if($y <= $percents) {
					$class = 'full';
				} else {
					$class = 'empty';
					if($y - $percents == 0.5) {
						$class = 'half';
					} else {
						$class = 'empty';
					}
				}

				$result .= '<div class="'.$class.'"></div>';
			}
			$result .= '</div>';
			$result .= '</div>';

			$result .= '        <div class="flex flex_column mobile_rate">'.review_top_rating($item,false).'</div>';
			$result .= '</div>';


			$result .= '</div>';
			$result .= '</div>';
		}


		//$result .= '</div>';

		echo $result;
		die;
	}
}



if (!function_exists('user_dashboard_services')) {
	function user_dashboard_services() {
		$current_user = wp_get_current_user();
		$user_id      = $current_user->data->ID;
		$result       = print_css_links( 'user_page' );
		$result       .= print_js_links()['user_subscription'];
		$result       .= print_js_links()['user_page'];
		$result       .= print_js_links()['show_block'];
		$result       .= print_css_links( 'show_block' );
		$result       .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result       .= '<div class="page_content page_container background_light review_container_about visible">';
		$result       .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result       .= '        <div class="profile-wrapper">';
		$result       .= '            <div class="profile-wrapper__left">';

		$result .= user_menu( $current_user, $user_id, 'services' );
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if ( function_exists( 'show_breadcrumbs' ) ) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= '<div class="services_wrapper">';
		/*$result .= '    <div class="infoblock button_gray border_radius_4px">';
		$result .= '        <a href="#" class="infoblock__link color_dark_blue link_no_underline font_bold flex">';
		$result .= '            <span class="infoblock__icon"></span>';
		$result .= '            <span class="infoblock__text border_no_color">Узнайте как получить бонусы за отзывы</span>';
		$result .= '        </a>';
		$result    .= '</div>';*/
		$result    .= '<div class="white_block comments_top flex comment_top_dashboard_comments__header">';
		$result    .= '<div class="comments_top_title font_uppercase font_bold color_dark_blue font_small">' . __( 'Сервисы', 'er_theme' ) . '</div>';
		$get_act_service = get_field('services_user_services','user_'.$user_id)[0];
		$get_number = 4;
		if ($get_act_service == '') {
			$get_number = 4;
		} else {
			$get_number = 5;
		}

		$get_number = 2;
		if ($get_act_service == '') {
			$get_number_free = 2;
		} else {
			$get_number_free = 1;
		}


		$result    .= '<div class="comments_top_count font_bold color_dark_gray">'.$get_number.' активно</div>';
		$result .= '<div class="show_block_comments"><div class="color_dark_gray font_small link_review_map link_dropdown link_inactive show_block show_block_to_up" data-block=".comment_top_dashboard_comments__footer" data-type="comment_top_dashboard_comments__footer_show"></div></div>';
		$result .= '</div>';

		$result .= '    <div class="white_block flex comment_top_dashboard_comments__footer comment_top_dashboard_comments__footer_show"><ul class="menu-take-comments-dashboard">    <li class="menu-take-comments-dashboard__item menu-take-comments-dashboard__item_services pointer" data-sort-type="my_service"><span class="border_no_color">Мои сервисы</span></li>    <li class="menu-take-comments-dashboard__item menu-take-comments-dashboard__item_services pointer" data-sort-type="add_service"><span class="border_no_color">Добавить</span> <span class="new-comments-profile__number font_bold border_circle_px ans_get">'.$get_number_free.'</span></li>            </ul></div>';
		$result .= '<div class="hero_elem_b p_30 border_radius_4px m_t_15 profile_create_view" style="background: url(/wp-content/themes/eto-razvod-1/img/bg_pro.png);background-repeat: no-repeat;background-size:cover;position: relative;">';
		$result .= '    <div class="hero_elem_b__title font_bolder  font_medium m_b_20">Аккаунт PRO для пользователя</div>';
		$result .= '    <div class="hero_elem_b__button"><a href="/dashboard/services/pro/" rel="nofollow" class="button display_inline font_bold button_green pointer font_small link_no_underline connect_pro_promo">Подключить</a></div>';
		$result .= '</div>';
		$result .= '<div class="get_service_wrapper flex justify-content-space-between">';
		$result .= '    <div class="get_service_item white_block block_content border_radius_4px m_t_15 flex flex_column">';
		$result .= '<span class="add_to_bookmark pointer"></span>';
		$result .= '        <span class="get_service_item__title font_bold m_b_10 m_t_10">PRO Аккаунт</span>';
		$result .= '        <a href="#" class="get_service_item__link color_dark_gray link_no_underline font_small border_bottom_dotted m_b_20">Подробнее о сервисе</a>';
		$result .= '        <div class="get_service_item__footer flex justify-content-space-between align-items-center">';
		$users = get_users( [
			'meta_key'   => 'services_user_services',
			'meta_compare' => 'exist'
		] );
		//$result .= print_r(get_page_by_path( 'alpari', 'ARRAY_A', 'casino' )['ID']);
		//get_page_by_path( $page_path, $output, $post_type );

		$result .= '            <span class="get_service_item__number color_dark_blue">'.count($users).' '.__('используют','er_theme').'</span>';
		if ($get_act_service == '') {
			$result .= '            <a href="/dashboard/services/pro/" rel="nofollow" class="link_no_underline get_service_item__turner get_service_item__turner_turnoff border_radius_4px pointer">Включить</a>';
		} else {
			$result .= '            <div class="get_service_item__turner get_service_item__turner_turnon border_radius_4px pointer">Включено</div>';
		}
		$result .= '        </div>';
		$result .= '        <span class="get_service_item__bookmark"></span>';
		$result .= '    </div>';
		$result .= '    <div class="get_service_item white_block block_content border_radius_4px m_t_15 flex flex_column">';
		$result .= '<span class="add_to_bookmark pointer"></span>';
		$result .= '        <span class="get_service_item__title font_bold m_b_10 m_t_10">Публикация статьи в блог</span>';
		$result .= '        <a href="#" class="get_service_item__link color_dark_gray link_no_underline font_small border_bottom_dotted m_b_20">Подробнее о сервисе</a>';
		$result .= '        <div class="get_service_item__footer flex justify-content-space-between align-items-center">';
		$result .= '            <span class="get_service_item__number color_dark_blue">27 '.__('используют','er_theme').'</span>';
		$result .= '            <a href="/dashboard/services/blog/" rel="nofollow" class="link_no_underline get_service_item__turner get_service_item__turner_turnoff border_radius_4px pointer">Включить</a>';
		$result .= '        </div>';
		$result .= '        <span class="get_service_item__bookmark"></span>';
		$result .= '    </div>';
		$result .= '    <div class="get_service_item white_block block_content border_radius_4px m_t_15 flex flex_column">';
		$result .= '<span class="add_to_bookmark pointer"></span>';
		$result .= '        <span class="get_service_item__title font_bold m_b_10 m_t_10">Оставить жалобу</span>';
		$result .= '        <a href="'.site_url('/abuse/').'" rel="nofollow" class="get_service_item__link color_dark_gray link_no_underline font_small border_bottom_dotted m_b_20">Подробнее о сервисе</a>';
		$result .= '        <div class="get_service_item__footer flex justify-content-space-between align-items-center">';
		$result .= '            <span class="get_service_item__number color_dark_blue">1023 '.__('используют','er_theme').'</span>';

		$result .= '            <div class="get_service_item__turner get_service_item__turner_turnon border_radius_4px pointer">Включено</div>';
		$result .= '        </div>';
		$result .= '        <span class="get_service_item__bookmark"></span>';
		$result .= '    </div>';
		$result .= '    <div class="get_service_item white_block block_content border_radius_4px m_t_15 flex flex_column">';
		$result .= '<span class="add_to_bookmark pointer"></span>';
		$result .= '        <span class="get_service_item__title font_bold m_b_10 m_t_10">Добавить отзыв</span>';
		$result .= '        <a href="'.site_url('/review/').'" class="get_service_item__link color_dark_gray link_no_underline font_small border_bottom_dotted m_b_20">Подробнее о сервисе</a>';
		$result .= '        <div class="get_service_item__footer flex justify-content-space-between align-items-center">';
		$result .= '            <span class="get_service_item__number color_dark_blue " style="white-space: nowrap">'.(count_users()['total_users']+10000).' '.__('используют','er_theme').'</span>';
		//$result .= '            <div class="get_service_item__turner get_service_item__turner_turnoff border_radius_4px pointer">Включить</div>';
		$result .= '            <div class="get_service_item__turner get_service_item__turner_turnon border_radius_4px pointer">Включено</div>';
		$result .= '        </div>';
		$result .= '        <span class="get_service_item__bookmark"></span>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= '<div class="hero_elem_b p_30 border_radius_4px m_t_15 profile_create_view" style="background: url(/wp-content/themes/eto-razvod-1/img/bg_black_triangle.png);background-repeat: no-repeat;background-size:cover;position: relative;"><span class="soon_dashboard">Скоро</span>';
		$result .= '    <div class="hero_elem_b__title font_bolder  font_medium m_b_20 color_white">Партнерская программа</div>';
		$result .= '    <div class="hero_elem_b__button"><a href="#" class="button display_inline font_bold button_green pointer font_small link_no_underline">Подключить</a></div>';
		$result .= '</div>';
		
		
		$result .= '<div class="get_service_wrapper flex justify-content-space-between">';
		$result .= '    <div class="get_service_item white_block block_content border_radius_4px m_t_15 flex flex_column">';
		$result .= '<span class="add_to_bookmark pointer"></span>';
		$result .= '        <span class="get_service_item__title font_bold m_b_10 m_t_10">Уведомления и рассылки</span>';
		$result .= '        <a href="/email/" class="get_service_item__link color_dark_gray link_no_underline font_small border_bottom_dotted m_b_20">Подробнее о сервисе</a>';
		$result .= '        <div class="get_service_item__footer flex justify-content-space-between align-items-center">';//'.count_users()['total_users'].'
		$result .= '            <span class="get_service_item__number color_dark_blue">'.get_user_count() .' '.__('используют','er_theme').'</span>';
		$result .= '            <div class="get_service_item__turner get_service_item__turner_turnon border_radius_4px pointer">Включено</div>';
		$result .= '        </div>';
		$result .= '        <span class="get_service_item__bookmark"></span>';
		$result .= '    </div>';
		$result .= '    <div class="get_service_item white_block block_content border_radius_4px m_t_15 flex flex_column">';
		$result .= '<span class="add_to_bookmark pointer"></span>';
		
		$result .= '        <span class="get_service_item__title font_bold m_b_10 m_t_10">Подбор компании</span>';
		$result .= '        <a href="#" class="get_service_item__link color_dark_gray link_no_underline font_small border_bottom_dotted m_b_20">Подробнее о сервисе</a>';
		$result .= '        <div class="get_service_item__footer flex justify-content-space-between align-items-center">';
		$result .= '            <span class="get_service_item__number color_dark_blue">1289 '.__('используют','er_theme').'</span>';
		$result .= '            <div class="get_service_item__turner get_service_item__turner_turnon border_radius_4px pointer">Включено</div>';
		$result .= '        </div>';
		$result .= '        <span class="get_service_item__bookmark"></span>';
		$result .= '    </div>';
		$result .= '</div>';
		
		
		$result .= '<div class="get_service_wrapper flex justify-content-space-between">';
		$result .= '    <div class="get_service_item white_block block_content border_radius_4px m_t_15 flex flex_column">';
		$result .= '<span class="add_to_bookmark pointer"></span>';
		$result .= '        <span class="get_service_item__title font_bold m_b_10 m_t_10">Запрос на расследование</span>';
		$result .= '        <a href="#" class="get_service_item__link color_dark_gray link_no_underline font_small border_bottom_dotted m_b_20">Подробнее о сервисе</a>';
		$result .= '        <div class="get_service_item__footer flex justify-content-space-between align-items-center">';//'.count_users()['total_users'].'
		$result .= '            <span class="get_service_item__number color_dark_blue">678 '.__('используют','er_theme').'</span>';
		$result .= '            <div class="get_service_item__turner get_service_item__turner_turnon border_radius_4px pointer">Включено</div>';
		$result .= '        </div>';
		$result .= '        <span class="get_service_item__bookmark"></span>';
		$result .= '    </div>';
		$result .= '</div>';
		
		$result .= '</div>';
		$result .= '</div>';
		$result .= '            <div class="profile-wrapper__right_sub">'.act_services($user_id).add_company($user_id).act_services_banner($user_id).fast_links_profile( $user_id ,'noborder',[['/dashboard/services/pro/','Включить аккаунт PRO'],['/advices/','Полезные советы'],['/user-edit/','Как заполнить аккаунт'],['/user-help/','Помощь']]).menu_footer_links(true).'</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}

if (!function_exists('act_services')) {
	function act_services($user_id) {
		$result = '<div class="side_block white_block border_radius_4px"><div class="block_content side_block_column sidebar_active_services ">'.number_stat_profile($user_id,'Активные сервисы',3, 1, 0).'<a href="#" class="link_no_underline text_centered border_bottom_dotted color_dark_blue link_act_services font_smaller">Как заработать бонусы?</a><a href="#" class="link_no_underline text_centered border_bottom_dotted color_dark_blue link_act_services font_smaller">Все сервисы</a></div></div>';
		return $result;
	}
}

if (!function_exists('act_services_banner')) {
	function act_services_banner($user_id) {
		//$result = '<div class="side_block white_block border_radius_4px"><div class="block_content side_block_column"><div class="r_b_sidebar"><span class="r_b_sidebar__title">Рекламный баннер</span></div></div></div>';
		$result = '';
		return $result;
	}
}

if (!function_exists('user_balance')) {
	function user_balance($user_id) {
		$balance = intval(get_field('balance','user_'.$user_id));
		$balance = number_format($balance, 0, '.', ' ').' Р';
		$result = '<div class="side_block white_block border_radius_4px"><div class="block_content side_block_column balance_service"><span class="balance_logo_wrapper"></span>'.number_stat_profile($user_id,'Остаток на счету',$balance, 1, 0).'</div></div>';
		return $result;
	}
}

if (!function_exists('ez_bonus_block')) {
	function ez_bonus_block($user_id) {
		$balance = '<span class="ez_logo_wrapper"></span>0';
		$result = '<div class="side_block white_block border_radius_4px"><div class="block_content side_block_column ez_bonus_service"><span class="soon_dashboard">Скоро</span>'.number_stat_profile($user_id,'Бонусы Etorazvod',$balance, 0, 0).'<a href="#" class="font_smaller text_underline_dashed link_no_underline color_dark_blue">Как заработать бонусы?</a></div></div>';
		return $result;
	}
}

if (!function_exists('user_dashboard_wallet')) {
	function user_dashboard_wallet() {
		$current_user = wp_get_current_user();
		$user_id      = $current_user->data->ID;
		$result = print_css_links( 'user_page' );
		$result .= print_js_links()['user_subscription'];
		$result .= print_js_links()['user_page'];
		$result .= print_js_links()['show_block'];
		$result .= print_css_links( 'show_block' );
		$result .= print_css_links( 'rating' );
		$result .= print_js_links()['cloudpayments'];
		$result .= print_js_links()['user_wallet'];
		$result .= print_css_links('user_form');
		$result .= print_css_links( 'user_service_form' );
		$result       .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result       .= '<div class="page_content page_container background_light review_container_about visible">';
		$result       .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result       .= '        <div class="profile-wrapper">';
		$result       .= '            <div class="profile-wrapper__left">';

		$result .= user_menu( $current_user, $user_id, 'wallet' );
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if ( function_exists( 'show_breadcrumbs' ) ) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= '<div class="services_wrapper">';

		global $post;
		$posts_transactions = get_posts( [
			'posts_per_page' => 50,
			'post_type'      => 'tranzaktsii',
			'post_status'    => 'any',
			'meta_query'     => array(
				array(
					'key'     => 'id_user',
					'value'   => $user_id,
					'compare' => '==',
				)
			)
		] );

		$result    .= '<div class="white_block comments_top flex comment_top_dashboard_comments__header">';
		$result    .= '<div class="comments_top_title font_uppercase font_bold color_dark_blue font_small">' . __( 'Все платежи', 'er_theme' ) . '</div>';
		$result    .= '<div class="comments_top_count font_bold color_dark_gray">'.count($posts_transactions).'</div>';
		//$result .= '<div class="show_block_comments"><div class="color_dark_gray font_small link_review_map link_dropdown link_inactive show_block show_block_to_up" data-block=".comment_top_dashboard_comments__footer" data-type="comment_top_dashboard_comments__footer_show"></div></div>';
		$result .= '</div>';

		//$result .= '    <div class="white_block flex comment_top_dashboard_comments__footer comment_top_dashboard_comments__footer_show"><ul class="menu-take-comments-dashboard">    <li class="menu-take-comments-dashboard__item menu-take-comments-dashboard__item_abuses pointer" data-sort-type="new"><span class="border_no_color">Все</span></li>    <li class="menu-take-comments-dashboard__item menu-take-comments-dashboard__item_abuses pointer" data-sort-type="onlynew"><span class="border_no_color">Новые</span> <span class="new-comments-profile__number font_bold border_circle_px ans_get">2</span></li>            </ul></div>';
		return $result;
	}
}

if ( ! function_exists( 'user_dashboard_wallet2' ) ) {
	function user_dashboard_wallet2() {
		$current_user = wp_get_current_user();
		$user_id      = $current_user->data->ID;
		$result       = '</div>';
		$result       .= '</div>';
		$result       .= '            <div class="profile-wrapper__right_sub">' . user_balance( $user_id ) . ez_bonus_block( $user_id ) . fast_links_profile( $user_id, 'noborder',[['/dashboard/services/pro/','Включить аккаунт PRO'],['/advices/','Полезные советы'],['/user-edit/','Как заполнить аккаунт'],['/user-help/','Помощь']] ) .menu_footer_links(true). '</div>';
		$result       .= '        </div>';
		$result       .= '    </div>';
		$result       .= '</div>';
		$result       .= print_css_links( 'profile_top' );

		return $result;
	}
}

if (!function_exists('user_dashboard_wallet_new')) {
	function user_dashboard_wallet_new() {

		$current_user = wp_get_current_user();
		$user_id      = $current_user->data->ID;
		$result = print_css_links( 'user_page' );
		$result .= print_js_links()['user_subscription'];
		$result .= print_js_links()['user_page'];
		$result .= print_js_links()['show_block'];
		$result .= print_css_links( 'show_block' );
		$result .= print_css_links( 'rating' );
		$result .= print_js_links()['user_wallet_new'];
		$result .= print_css_links('user_form');
		$result .= print_css_links( 'user_service_form' );
		$result       .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result       .= '<div class="page_content page_container background_light review_container_about visible">';
		$result       .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result       .= '        <div class="profile-wrapper">';
		$result       .= '            <div class="profile-wrapper__left">';

		$result .= user_menu( $current_user, $user_id, 'wallet' );
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if ( function_exists( 'show_breadcrumbs' ) ) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= '<div class="services_wrapper">';

		global $post;
		$posts_transactions = get_posts( [
			'posts_per_page' => 50,
			'post_type'      => 'tranzaktsii',
			'post_status'    => 'any',
			'meta_query'     => array(
				array(
					'key'     => 'id_user',
					'value'   => $user_id,
					'compare' => '==',
				)
			)
		] );

		$result    .= '<div class="white_block comments_top flex comment_top_dashboard_comments__header">';
		$result    .= '<div class="comments_top_title font_uppercase font_bold color_dark_blue font_small">' . __( 'Все платежи', 'er_theme' ) . '</div>';
		$result    .= '<div class="comments_top_count font_bold color_dark_gray">'.count($posts_transactions).'</div>';
		//$result .= '<div class="show_block_comments"><div class="color_dark_gray font_small link_review_map link_dropdown link_inactive show_block show_block_to_up" data-block=".comment_top_dashboard_comments__footer" data-type="comment_top_dashboard_comments__footer_show"></div></div>';
		$result .= '</div>';

		//$result .= '    <div class="white_block flex comment_top_dashboard_comments__footer comment_top_dashboard_comments__footer_show"><ul class="menu-take-comments-dashboard">    <li class="menu-take-comments-dashboard__item menu-take-comments-dashboard__item_abuses pointer" data-sort-type="new"><span class="border_no_color">Все</span></li>    <li class="menu-take-comments-dashboard__item menu-take-comments-dashboard__item_abuses pointer" data-sort-type="onlynew"><span class="border_no_color">Новые</span> <span class="new-comments-profile__number font_bold border_circle_px ans_get">2</span></li>            </ul></div>';
		return $result;

	}
}

if (!function_exists('user_dashboard_wallet_new_test')) {
	function user_dashboard_wallet_new_test() {

		$current_user = wp_get_current_user();
		$user_id      = $current_user->data->ID;
		$result = print_css_links( 'user_page' );
		$result .= print_js_links()['user_subscription'];
		$result .= print_js_links()['user_page'];
		$result .= print_js_links()['show_block'];
		$result .= print_css_links( 'show_block' );
		$result .= print_css_links( 'rating' );
		$result .= print_css_links('user_form');
		$result .= print_css_links( 'user_service_form' );
		$result .= print_js_links()['user_wallet_new_test'];
		$result       .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result       .= '<div class="page_content page_container background_light review_container_about visible">';
		$result       .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result       .= '        <div class="profile-wrapper">';
		$result       .= '            <div class="profile-wrapper__left">';

		$result .= user_menu( $current_user, $user_id, 'wallet' );
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if ( function_exists( 'show_breadcrumbs' ) ) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= '<div class="services_wrapper">';

		global $post;
		$posts_transactions = get_posts( [
			'posts_per_page' => 50,
			'post_type'      => 'tranzaktsii',
			'post_status'    => 'any',
			'meta_query'     => array(
				array(
					'key'     => 'id_user',
					'value'   => $user_id,
					'compare' => '==',
				)
			)
		] );

		$result    .= '<div class="white_block comments_top flex comment_top_dashboard_comments__header wallet_header">';
		$result    .= '<div class="comments_top_title font_uppercase font_bold color_dark_blue font_small">' . __( 'Все платежи', 'er_theme' ) . '</div>';
		$result    .= '<div class="comments_top_count font_bold color_dark_gray">'.count($posts_transactions).'</div>';
		//$result .= '<div class="show_block_comments"><div class="color_dark_gray font_small link_review_map link_dropdown link_inactive show_block show_block_to_up" data-block=".comment_top_dashboard_comments__footer" data-type="comment_top_dashboard_comments__footer_show"></div></div>';
		$result .= '</div>';

		//$result .= '    <div class="white_block flex comment_top_dashboard_comments__footer comment_top_dashboard_comments__footer_show"><ul class="menu-take-comments-dashboard">    <li class="menu-take-comments-dashboard__item menu-take-comments-dashboard__item_abuses pointer" data-sort-type="new"><span class="border_no_color">Все</span></li>    <li class="menu-take-comments-dashboard__item menu-take-comments-dashboard__item_abuses pointer" data-sort-type="onlynew"><span class="border_no_color">Новые</span> <span class="new-comments-profile__number font_bold border_circle_px ans_get">2</span></li>            </ul></div>';
		return $result;

	}
}

if ( ! function_exists( 'savefio' ) ) {
	add_action( 'wp_ajax_savefio', 'savefio' );
	add_action( 'wp_ajax_nopriv_savefio', 'savefio' );

	function savefio() {
		$first_name = htmlspecialchars( $_POST["first_name"] );
		$last_name  = htmlspecialchars( $_POST["last_name"] );
		$city  = htmlspecialchars( $_POST["city"] );
		$country  = htmlspecialchars( $_POST["country"] );

		$user_id = wp_update_user( [
			'ID'         => get_current_user_id(),
			'first_name' => $first_name,
			'last_name'  => $last_name,
		] );

		if (!empty($country) && $country != '') {
			update_field( 'adress_country2', $country, 'user_' . get_current_user_id() );
		} else {
			update_field( 'adress_country2', '', 'user_' . get_current_user_id() );
		}

		if (!empty($city) && $country != '') {
			update_field( 'adress_city', $city, 'user_' . get_current_user_id() );
		} else {
			update_field( 'adress_city', '', 'user_' . get_current_user_id() );
		}
		//update_field( 'adress_city', $city, 'user_' . get_current_user_id() );
		$result = array(
			'status'     => 'ok',
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'city'       => $city,
			'country'    => $country
		);
		echo json_encode( $result );
		die;
	}
}
if ( ! function_exists( 'update_contact_email' ) ) {
	add_action( 'wp_ajax_update_contact_email', 'update_contact_email' );
	add_action( 'wp_ajax_nopriv_update_contact_email', 'update_contact_email' );
	function update_contact_email() {
		$email = htmlspecialchars( $_POST["email"] );
		//Проверка email
		$troubles = [];
		if ( ( filter_var( $email, FILTER_VALIDATE_EMAIL ) ) || ($email == "")) {

		} else {
			array_push( $troubles, 'Указан некорректный адрес электронной почты' );
		}


		if ( count( $troubles ) == 0 ) {

			update_field( 'contacts_e-mail', $email, 'user_' . get_current_user_id() );
			$result = array(
				'status'   => 'ok',
				'troubles' => json_encode( $troubles )
			);
		} else {
			$result = array(
				'status'   => 'error',
				'troubles' => json_encode( $troubles )
			);
		}
		echo json_encode( $result );
		die;
	}
}

if ( ! function_exists( 'update_contact_skype' ) ) {
	add_action( 'wp_ajax_update_contact_skype', 'update_contact_skype' );
	add_action( 'wp_ajax_nopriv_update_contact_skype', 'update_contact_skype' );

	function update_contact_skype() {
		$skype = htmlspecialchars( $_POST["skype"] );
		//Проверка skype
		$troubles     = [];
		$skypechecked = preg_match( "/[а-я]/i", $skype );

		if ( $skypechecked == 1 ) {
			array_push( $troubles, 'Удалите киррилические символы в Skype-логине' );
		}

		if ( ( preg_match( '/\s/', $skype ) ) ) {
			array_push( $troubles, 'Удалите пробелы из Skype-логина' );
		}


		if ( count( $troubles ) == 0 ) {

			update_field( 'contacts_skype', $skype, 'user_' . get_current_user_id() );
			$result = array(
				'status'   => 'ok',
				'troubles' => json_encode( $troubles )
			);
		} else {
			$result = array(
				'status'   => 'error',
				'troubles' => json_encode( $troubles )
			);
		}
		echo json_encode( $result );
		die;
	}
}

if ( ! function_exists( 'update_contact_telegram' ) ) {
	add_action( 'wp_ajax_update_contact_telegram', 'update_contact_telegram' );
	add_action( 'wp_ajax_nopriv_update_contact_telegram', 'update_contact_telegram' );

	function update_contact_telegram() {
		$telegram = htmlspecialchars( $_POST["telegram"] );
//Проверка telegram
		$troubles        = [];
		$telegramchecked = preg_match( "/[а-я]/i", $telegram );

		if ( $telegramchecked == 1 ) {
			array_push( $troubles, 'Удалите киррилические символы в telegram-логине' );
		}

		if ( ( preg_match( '/\s/', $telegram ) ) ) {
			array_push( $troubles, 'Удалите пробелы из telegram-логина' );
		}


		if ( count( $troubles ) == 0 ) {

			update_field( 'contacts_telegram', $telegram, 'user_' . get_current_user_id() );
			$result = array(
				'status'   => 'ok',
				'troubles' => json_encode( $troubles )
			);
		} else {
			$result = array(
				'status'   => 'error',
				'troubles' => json_encode( $troubles )
			);
		}
		echo json_encode( $result );
		die;
	}
}

if ( ! function_exists( 'update_contact_about' ) ) {
	add_action( 'wp_ajax_update_contact_about', 'update_contact_about' );
	add_action( 'wp_ajax_nopriv_update_contact_about', 'update_contact_about' );

	function update_contact_about() {
		$edit_about = htmlspecialchars( $_POST["edit_about"] );
		update_field('user_desc',$edit_about,'user_' . get_current_user_id());

		$result = array(
			'status'   => 'ok',
			'troubles' => ''
		);
		echo json_encode( $result );
		die;
	}
}


if ( ! function_exists( 'card_before' ) ) {
	add_action( 'wp_ajax_card_before', 'card_before' );
	add_action( 'wp_ajax_nopriv_card_before', 'card_before' );

	function card_before() {
		date_default_timezone_set( 'Europe/Moscow' );
		$userid = wp_get_current_user();
		$amountval = htmlspecialchars( $_POST["amountval"] );

		$poster_id = wp_insert_post( wp_slash( array(
			'post_status'   => 'publish',
			'post_type'  => 'tranzaktsii',
			'post_title' => 'Пополнение баланса ' . date( 'd.m.Y H:i:s' ).' [ '.$userid->user_email.' , '.$userid->user_nicename.' , '.$userid->user_firstname. ' '. $userid->user_lastname.'] Сумма: '.$amountval.' RUB',
		) ) );


		$dater = date( 'd/m/Y' );
		update_field( 'type', 'add', $poster_id );
		update_field( 'add_options' . '_' . 'add_variations', 'card', $poster_id );
		update_field( 'add_options' . '_' . 'amount', $amountval, $poster_id );
		update_field( 'add_options' . '_' . 'data', $dater, $poster_id );
		update_field( 'data_time', date( 'd/m/Y H:i:s' ), $poster_id );
		update_field( 'add_options' . '_' . 'id_valute', 'rub', $poster_id );
		update_field( 'add_options' . '_' . 'status', 'empty', $poster_id );
		update_field( 'id_user', get_current_user_id(), $poster_id );
		
		update_field('id_user_text', get_current_user_id(), $poster_id);
		$result = array(
			'status' => 'ok',
			'id'     => $poster_id
		);
		echo json_encode( $result );
		die;
	}
}
if ( ! function_exists( 'card_after' ) ) { //ex. cardpay
	add_action( 'wp_ajax_card_after', 'card_after' );
	add_action( 'wp_ajax_nopriv_card_after', 'card_after' );

	function card_after() {
		date_default_timezone_set( 'Europe/Moscow' );
		$invoceid = htmlspecialchars( $_POST["invoceid"] );
		$resultid = htmlspecialchars( $_POST["resultid"] );
		if ( $invoceid != '' ) {
			$curl = curl_init();
			curl_setopt_array( $curl, array(
				CURLOPT_URL            => "https://api.cloudpayments.ru/v2/payments/find",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING       => "",
				CURLOPT_MAXREDIRS      => 10,
				CURLOPT_TIMEOUT        => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST  => "POST",
				CURLOPT_POSTFIELDS     => "InvoiceId=" . $invoceid,
				CURLOPT_HTTPHEADER     => array(
					"Authorization: Basic " . base64_encode( 'pk_9e9845c4d45b6acc7a06acc1a1841' . ":" . '865ba5295f8861bf3929db80b31a88c6' ),
					"Content-Type: application/x-www-form-urlencoded"
				),
			) );
			$response = curl_exec( $curl );
			curl_close( $curl );
			$resonsejson = json_decode( $response );

			if ( ( $resonsejson->Model->ReasonCode == 0 ) ) {
				$TransactionId = $resonsejson->Model->TransactionId;

				global $post;
				$posts2 = get_posts( [
					'posts_per_page' => - 1,
					'post_type'      => 'tranzaktsii',
					'meta_key'       => 'add_options_id_transaction',
					'meta_compare'   => '==',
					'meta_value'     => $TransactionId,
				] );

				if ( count( $posts2 ) == 0 ) {
					update_field( 'add_options' . '_' . 'amount', $resonsejson->Model->Amount, $resultid );

					update_field( 'add_options' . '_' . 'id_transaction', $resonsejson->Model->InvoiceId, $resultid );
					update_field( 'add_options' . '_' . 'id_transaction_acquirer', $resonsejson->Model->TransactionId, $resultid );
					update_field( 'add_options' . '_' . 'all_json', json_encode( $resonsejson->Model ), $resultid );
					update_field( 'add_options' . '_' . 'status', 'yes', $resultid );
					$balanceupdated = intval( get_field( 'balance', 'user_' . get_current_user_id() ) ) + intval( $resonsejson->Model->Amount );
					update_field( 'balance', $balanceupdated, 'user_' . get_current_user_id() );

					$result = array(
						'status'            => 'ok',
						'CardHolderMessage' => $resonsejson->Model->CardHolderMessage,
						'balance'           => get_field( 'balance', 'user_' . get_current_user_id() )
					);
				}
			} else {
				$result = array(
					'status'            => 'error',
					'CardHolderMessage' => $resonsejson->Model->CardHolderMessage,
				);
			}
		}
		echo json_encode( $result );
		die;
	}
}

if ( ! function_exists( 'get_more_info' ) ) {
	add_action( 'wp_ajax_get_more_info', 'get_more_info' );
	add_action( 'wp_ajax_nopriv_get_more_info', 'get_more_info' );

	function get_more_info() {
		date_default_timezone_set( 'Europe/Moscow' );
		$current_user = wp_get_current_user();
		$result       = [ 'time' => time(), 'email' => $current_user->user_email ];
		echo json_encode( $result );
		die;
	}
}



add_action( 'wp_ajax_card_pay_for_service', 'card_pay_for_service' );
add_action( 'wp_ajax_nopriv_card_pay_for_service', 'card_pay_for_service' );

function card_pay_for_service(){
	date_default_timezone_set( 'Europe/Moscow' );
	$invoceid = htmlspecialchars($_POST["invoceid"]);
	$resultid = htmlspecialchars($_POST["resultid"]);
	if ($invoceid != '') {
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.cloudpayments.ru/v2/payments/find",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "InvoiceId=".$invoceid,
			CURLOPT_HTTPHEADER     => array(
				"Authorization: Basic " . base64_encode( 'pk_9e9845c4d45b6acc7a06acc1a1841' . ":" . '865ba5295f8861bf3929db80b31a88c6' ),
				"Content-Type: application/x-www-form-urlencoded"
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$resonsejson = json_decode($response);

		if (($resonsejson->Model->ReasonCode == 0)) {
			$TransactionId = $resonsejson->Model->TransactionId;

			global $post;
			$posts2 = get_posts([
				'posts_per_page' => -1,
				'post_type'      => 'tranzaktsii',
				'meta_key'       => 'add_options_id_transaction',
				//'post_status' => 'any',
				'meta_compare'   => '==', // optional
				'meta_value'     => $TransactionId,
			]);

			if (count($posts2) == 0) {

				// $dater = date('d/m/Y');
				// update_field('type', 'add', $resultid);
				// update_field('add_options'.'_'.'add_variations', 'card', $resultid);
				update_field('add_options'.'_'.'amount', $resonsejson->Model->Amount, $resultid);
				// update_field('add_options'.'_'.'data', $dater, $resultid);
				// update_field('data_time', date('d/m/Y H:i:s'), $resultid);
				// update_field('add_options'.'_'.'id_valute', 'rub', $resultid);

				update_field('add_options'.'_'.'id_transaction', $resonsejson->Model->InvoiceId, $resultid);
				update_field('add_options'.'_'.'id_transaction_acquirer', $resonsejson->Model->TransactionId, $resultid);
				update_field('add_options'.'_'.'all_json', json_encode($resonsejson->Model), $resultid);
				//update_field('id_user', get_current_user_id(), $resultid);
				update_field('add_options'.'_'.'status', 'yes', $resultid);
				$balanceupdated = intval(    get_field('balance','user_'.get_current_user_id())    ) + intval(    $resonsejson->Model->Amount    );
				update_field('balance', $balanceupdated, 'user_'.get_current_user_id());

				$dataid = htmlspecialchars($_POST['dataid']);
				$inputnumbermod = abs(intval(htmlspecialchars($_POST['inputnumbermod'])));
				if ($inputnumbermod == 0) {
					$inputnumbermod = 1;
				}

				if (($dataid != '') && ($dataid != 0) && ($dataid != '0')) {


					if (    ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) || (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) && (intval($dataid) == 84178)    ) {
						function add_months($months, DateTime $dateObject) {
							$next = new DateTime($dateObject->format('Y-m-d'));
							$next->modify('last day of +'.$months.' month');

							if($dateObject->format('d') > $next->format('d')) {
								return $dateObject->diff($next);
							} else {
								return new DateInterval('P'.$months.'M');
							}
						}

						function endCycle($d1, $months)
						{
							$date = new DateTime($d1);

							$newDate = $date->add(add_months($months, $date));


							//ДАТАДАТА$newDate->sub(new DateInterval('P1D'));


							$dateReturned = $newDate->format('Y-m-d');

							return $dateReturned;
						}


						$getamountForOneMounth = get_field('secret_balance_spend_for_update','user_'.get_current_user_id());
						$amountval = $getamountForOneMounth * intval($inputnumbermod);
						$pricefromcloudpayments = $resonsejson->Model->Amount;
						if (intval($pricefromcloudpayments) == intval($amountval)) {
							//intval($pricefromcloudpayments) == intval($amountval
							$poster_id = wp_insert_post(  wp_slash( array(
								'post_type'     => 'tranzaktsii',
								'post_title' => 'Списание баланса '.date('d.m.Y H:i:s'),
							) ) );

							$dater = date('d/m/Y');
							update_field('type', 'spend', $poster_id);
							update_field('add_options_spend'.'_'.'amount', $amountval, $poster_id);
							update_field('add_options_spend'.'_'.'data', date('Y-m-d H:i:s'), $poster_id);
							update_field('add_options_spend'.'_'.'id_valute', 'rub', $poster_id);
							update_field('add_options_spend'.'_'.'type_spend', 'auto', $poster_id);
							update_field('data_time', date('Y-m-d H:i:s'), $poster_id);
							update_field('id_user', get_current_user_id(), $poster_id);
							update_field('id_user_text', get_current_user_id(), $poster_id);

							$oldbalance = get_field('balance','user_'.get_current_user_id());
							$newbalance = intval($oldbalance) - intval($amountval);
							update_field('balance',$newbalance,'user_'.get_current_user_id());

							update_field('services_user_services',$dataid,'user_'.get_current_user_id());
							update_field('services_user_periodicity','period','user_'.get_current_user_id());
							update_field('services_user_add_transaction_id_transaction',$poster_id,'user_'.get_current_user_id());

							update_field('additional_info_mini','Обновление тарифа '.get_the_title($dataid).'', $poster_id);
							update_field('additional_info','Обновление тарифа с PRO на PRO+  до '.str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')), $poster_id);

							$result = array(
								'status' => 'ok',
								'CardHolderMessage' => $resonsejson->Model->CardHolderMessage,
							);


						} else {
							//intval($pricefromcloudpayments) == intval($amountval
							$result = array(
								'status' => 'error1',
								'CardHolderMessage' => $resonsejson->Model->CardHolderMessage,
							);
						}
					} else {
						function add_months($months, DateTime $dateObject) {
							$next = new DateTime($dateObject->format('Y-m-d'));
							$next->modify('last day of +'.$months.' month');

							if($dateObject->format('d') > $next->format('d')) {
								return $dateObject->diff($next);
							} else {
								return new DateInterval('P'.$months.'M');
							}
						}

						function endCycle($d1, $months)
						{
							$date = new DateTime($d1);

							$newDate = $date->add(add_months($months, $date));


							//ДАТАДАТА$newDate->sub(new DateInterval('P1D'));


							$dateReturned = $newDate->format('Y-m-d');

							return $dateReturned;
						}


						$getamountForOneMounth = get_field('price', $dataid);
						$amountval = $getamountForOneMounth * intval($inputnumbermod);
						$pricefromcloudpayments = $resonsejson->Model->Amount;
						if (intval($pricefromcloudpayments) == intval($amountval)) {
							//intval($pricefromcloudpayments) == intval($amountval
							$poster_id = wp_insert_post(  wp_slash( array(
								'post_type'     => 'tranzaktsii',
								'post_title' => 'Списание баланса '.date('d.m.Y H:i:s'),
							) ) );

							$dater = date('d/m/Y');
							update_field('type', 'spend', $poster_id);
							update_field('add_options_spend'.'_'.'amount', $amountval, $poster_id);
							update_field('add_options_spend'.'_'.'data', date('Y-m-d H:i:s'), $poster_id);
							update_field('add_options_spend'.'_'.'id_valute', 'rub', $poster_id);
							update_field('add_options_spend'.'_'.'type_spend', 'auto', $poster_id);
							update_field('data_time', date('Y-m-d H:i:s'), $poster_id);
							update_field('id_user', get_current_user_id(), $poster_id);
							update_field('id_user_text', get_current_user_id(), $poster_id);

							$oldbalance = get_field('balance','user_'.get_current_user_id());
							$newbalance = intval($oldbalance) - intval($amountval);
							update_field('balance',$newbalance,'user_'.get_current_user_id());




							if (    (get_field('services_user_services','user_'.get_current_user_id())[0] == $dataid) || (get_field('services_user_services','user_'.get_current_user_id()) == $dataid)    ) {
								$services_user_date_activation = get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id());
								//update_field('services_user_date_activation',$services_user_date_activation,'user_'.get_current_user_id());
							} else {
								update_field('services_user_date_activation',date('d/m/Y H:i:s'),'user_'.get_current_user_id());
							}


							$startDate = ''.date('Y-m-d').'';
							$nMonths = intval($inputnumbermod);
							$final = endCycle($startDate, $nMonths);

							$time = strtotime($final);
							$newformat = date('d/m/Y',$time);

							$date_before_end = $newformat.' '.date('H:i:s');

							if (    (get_field('services_user_services','user_'.get_current_user_id())[0] == $dataid) || (get_field('services_user_services','user_'.get_current_user_id()) == $dataid)    ) {

								$timestampstart = strtotime( str_replace(    '/', '-',$services_user_date_activation) );


								$services_user_date_activation_get_time = stristr($services_user_date_activation, ' ');
								$services_user_date_activation_get_time = str_replace(' ', '', $services_user_date_activation_get_time);

								$startDate = ''.date('Y-m-d', $timestampstart).'';
								$nMonths = intval($inputnumbermod);
								$final = endCycle($startDate, $nMonths);

								$time = strtotime($final);
								$newformat = date('d/m/Y',$time);

								$date_before_end = $newformat.' '.date('H:i:s');//$services_user_date_activation_get_time;

								update_field('services_user_add_transaction_date_before_end',$date_before_end,'user_'.get_current_user_id());



								update_field('additional_info_mini','Продление тарифа '.get_the_title($dataid).'', $poster_id);
								update_field('additional_info','Продление тарифа '.get_the_title($dataid).' до '.str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')), $poster_id);

							} else {

								$startDate = ''.date('Y-m-d').'';
								$nMonths = intval($inputnumbermod);
								$final = endCycle($startDate, $nMonths);

								$time = strtotime($final);
								$newformat = date('d/m/Y',$time);

								$date_before_end = $newformat.' '.date('H:i:s');

								update_field('services_user_add_transaction_date_before_end',$date_before_end,'user_'.get_current_user_id());


								update_field('additional_info_mini','Подключение тарифа '.get_the_title($dataid).'', $poster_id);
								update_field('additional_info','Подключение тарифа '.get_the_title($dataid).' до '.str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')), $poster_id);
							}


							update_field('services_user_services',$dataid,'user_'.get_current_user_id());
							update_field('services_user_periodicity','period','user_'.get_current_user_id());
							update_field('services_user_add_transaction_id_transaction',$poster_id,'user_'.get_current_user_id());


							$result = array(
								'status' => 'ok',
								'CardHolderMessage' => $resonsejson->Model->CardHolderMessage,
							);


						} else {
							//intval($pricefromcloudpayments) == intval($amountval
							$result = array(
								'status' => 'error1',
								'CardHolderMessage' => $resonsejson->Model->CardHolderMessage,
							);
						}
					}



				} else {
					$result = array(
						'status' => 'error2',
						'CardHolderMessage' => $resonsejson->Model->CardHolderMessage,
					);
				}



			}
		} else {
			$result = array(
				'status' => 'error3',
				'CardHolderMessage' => $resonsejson->Model->CardHolderMessage,
			);
		}
	}



	echo json_encode($result);
	die;
}


add_action( 'wp_ajax_balance_pay_for_service', 'balance_pay_for_service' );
add_action( 'wp_ajax_nopriv_balance_pay_for_service', 'balance_pay_for_service' );

function balance_pay_for_service(){
	date_default_timezone_set( 'Europe/Moscow' );
	$balancefield = get_field('balance','user_'.get_current_user_id());
	if ($balancefield == '') {
		$balancefield = 0;
	}
	$dataid = htmlspecialchars($_POST['dataid']);
	$inputnumbermod = abs(intval(htmlspecialchars($_POST['inputnumbermod'])));
	if ($inputnumbermod == 0) {
		$inputnumbermod = 1;
	}

	if (($dataid != '') && ($dataid != 0) && ($dataid != '0')) {
		$i = 3;
		if (    ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) || (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) && (intval($dataid) == 84178)    ) {
			//if ($i === 1) {
			//1    ===============================================================================================
			//Находим количество дней для тарифа ПРО от сегодняшнего дня - до даты ОКОНЧАНИЯ
			date_default_timezone_set( 'Europe/Moscow' );
			$start = strtotime(date('d-m-Y H:i:s'));
			$end = strtotime(   str_replace(    '/', '-', get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id())    )    );

			$days_between = ceil(abs($end - $start) / 86400);
			//echo $days_between;
			//echo "<br>";
			//echo '$start '.$start.' date '.date('d/m/Y H:i:s');
			//echo "<hr>";
			//echo '$end  '.$end.'services_user_add_transaction_date_before_end '.get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id());
			//echo "<hr>";
			//2    ===============================================================================================
			//Находим количество дней для тарифа ПРО от АКТИВАЦИИ - до даты ОКОНЧАНИЯ
			$start = strtotime(    str_replace(    '/', '-', get_field('services_user_date_activation','user_'.get_current_user_id()) )    );
			$end = strtotime(    str_replace(    '/', '-', get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()) )    );

			$days_between2 = ceil(abs($end - $start) / 86400);
			//echo $days_between2;
			//echo "<br>";
			//5    ===============================================================================================
			//НАХОДИМ ЦЕНУ за 1 день ПРО
			// ЦЕНА ЗА ПРО * 12 / 365
			$priceforonedaypro = (150 * 12) / 365;
			//6    ===============================================================================================
			//Вычиляем цену (от сегодняшнего дня ДО конечного) дня для тарифа ПРО
			//Шаг 1 умножаем шаг 5
			$prorealprice = $priceforonedaypro * $days_between;
			//8    ===============================================================================================
			//НАХОДИМ ЦЕНУ за 1 день ПРО+
			// ЦЕНА ЗА ПРО+ * 12 / 365
			$priceforonedayproplus = (300 * 12) / 365;
			//9    ===============================================================================================
			//Вычиляем цену (от сегодняшнего дня ДО конечного) дня для тарифа ПРО+
			//Шаг 1 умножаем шаг 8
			$proplusrealprice = $priceforonedayproplus * $days_between;
			//10    ===============================================================================================
			//РАЗНИЦА
			//вычетаем из Шаг 9 - Шаг 6
			$raznica = $proplusrealprice - $prorealprice;
			//echo $raznica;
			function add_months($months, DateTime $dateObject)
			{
				$next = new DateTime($dateObject->format('Y-m-d'));
				$next->modify('last day of +'.$months.' month');

				if($dateObject->format('d') > $next->format('d')) {
					return $dateObject->diff($next);
				} else {
					return new DateInterval('P'.$months.'M');
				}
			}

			function endCycle($d1, $months)
			{
				$date = new DateTime($d1);

				$newDate = $date->add(add_months($months, $date));


				///ДАТАДАТА$newDate->sub(new DateInterval('P1D'));


				$dateReturned = $newDate->format('Y-m-d');

				return $dateReturned;
			}


			$getamountForOneMounth = get_field('secret_balance_spend_for_update','user_'.get_current_user_id());
			$amountval = $getamountForOneMounth * 1;
			$oldbalance = $balancefield;

			if (intval($amountval) <= intval($oldbalance)) {

				$newbalance = intval($oldbalance) - intval($amountval);
				if (($newbalance >= 0)) {
					$poster_id = wp_insert_post(  wp_slash( array(
						'post_type'     => 'tranzaktsii',
						'post_title' => 'Списание баланса '.date('d.m.Y H:i:s'),
					) ) );

					$dater = date('d/m/Y');
					update_field('type', 'spend', $poster_id);
					update_field('add_options_spend'.'_'.'amount', $amountval, $poster_id);
					update_field('add_options_spend'.'_'.'data', date('Y-m-d H:i:s'), $poster_id);
					update_field('add_options_spend'.'_'.'id_valute', 'rub', $poster_id);
					update_field('add_options_spend'.'_'.'type_spend', 'auto', $poster_id);
					update_field('data_time', date('Y-m-d H:i:s'), $poster_id);
					update_field('id_user', get_current_user_id(), $poster_id);
					update_field('id_user_text', get_current_user_id(), $poster_id);



					update_field('balance',$newbalance,'user_'.get_current_user_id());

					update_field('services_user_services',$dataid,'user_'.get_current_user_id());
					update_field('services_user_periodicity','period','user_'.get_current_user_id());


					update_field('services_user_add_transaction_id_transaction',$poster_id,'user_'.get_current_user_id());

					// $startDate = ''.date('Y-m-d').'';
					// $nMonths = intval($inputnumbermod);
					// $final = endCycle($startDate, $nMonths);

					// $time = strtotime($final);
					// $newformat = date('d/m/Y',$time);

					// $date_before_end = $newformat.' '.date('H:i:s');


					// $b = strtotime( str_replace(    '/', '-','11/12/2020 16:03:02') );
					// echo date('Y-m-d', $b);






					// services_user>services    =    id услуги
					// services_user>periodicity    =    period
					// services_user>date_activation    =  date('d/m/Y H:i:s')
					// services_user>add_transaction>id_transaction    =    id транзы
					// services_user>add_transaction>date_before_end    =    date('d/m/Y H:i:s') + 1 mounth
					update_field('additional_info_mini','Обновление тарифа '.get_the_title($dataid).'', $poster_id);
					update_field('additional_info','Обновление тарифа с PRO на PRO+  до '.str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')), $poster_id);

					$result = array(
						'status' => 'ok',
						'id' => $poster_id
					);
				}

			} else {
				$result = array(
					'status' => 'error',
					'id' => '0'
				);
			}
		} else {

			function add_months($months, DateTime $dateObject)
			{
				$next = new DateTime($dateObject->format('Y-m-d'));
				$next->modify('last day of +'.$months.' month');

				if($dateObject->format('d') > $next->format('d')) {
					return $dateObject->diff($next);
				} else {
					return new DateInterval('P'.$months.'M');
				}
			}

			function endCycle($d1, $months)
			{
				$date = new DateTime($d1);

				$newDate = $date->add(add_months($months, $date));


				///ДАТАДАТА$newDate->sub(new DateInterval('P1D'));


				$dateReturned = $newDate->format('Y-m-d');

				return $dateReturned;
			}


			$getamountForOneMounth = get_field('price', $dataid);
			$amountval = $getamountForOneMounth * intval($inputnumbermod);
			$oldbalance = $balancefield;

			if (intval($amountval) <= intval($oldbalance)) {

				$newbalance = intval($oldbalance) - intval($amountval);
				if ($newbalance >= 0) {
					$poster_id = wp_insert_post(  wp_slash( array(
						'post_type'     => 'tranzaktsii',
						'post_title' => 'Списание баланса '.date('d.m.Y H:i:s'),
					) ) );

					$dater = date('d/m/Y');
					update_field('type', 'spend', $poster_id);
					update_field('add_options_spend'.'_'.'amount', $amountval, $poster_id);
					update_field('add_options_spend'.'_'.'data', date('Y-m-d H:i:s'), $poster_id);
					update_field('add_options_spend'.'_'.'id_valute', 'rub', $poster_id);
					update_field('add_options_spend'.'_'.'type_spend', 'auto', $poster_id);
					update_field('data_time', date('Y-m-d H:i:s'), $poster_id);
					update_field('id_user', get_current_user_id(), $poster_id);
					update_field('id_user_text', get_current_user_id(), $poster_id);



					update_field('balance',$newbalance,'user_'.get_current_user_id());



					if (    (get_field('services_user_services','user_'.get_current_user_id())[0] == $dataid) || (get_field('services_user_services','user_'.get_current_user_id()) == $dataid)    ) {
						$services_user_date_activation = get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id());
						//update_field('services_user_date_activation',$services_user_date_activation,'user_'.get_current_user_id());

					} else {
						update_field('services_user_date_activation',date('d/m/Y H:i:s'),'user_'.get_current_user_id());
					}

					update_field('services_user_add_transaction_id_transaction',$poster_id,'user_'.get_current_user_id());

					// $startDate = ''.date('Y-m-d').'';
					// $nMonths = intval($inputnumbermod);
					// $final = endCycle($startDate, $nMonths);

					// $time = strtotime($final);
					// $newformat = date('d/m/Y',$time);

					// $date_before_end = $newformat.' '.date('H:i:s');


					// $b = strtotime( str_replace(    '/', '-','11/12/2020 16:03:02') );
					// echo date('Y-m-d', $b);

					if (    (get_field('services_user_services','user_'.get_current_user_id())[0] == $dataid) || (get_field('services_user_services','user_'.get_current_user_id()) == $dataid)    ) {

						$timestampstart = strtotime( str_replace(    '/', '-',$services_user_date_activation) );


						$services_user_date_activation_get_time = stristr($services_user_date_activation, ' ');
						$services_user_date_activation_get_time = str_replace(' ', '', $services_user_date_activation_get_time);

						$startDate = ''.date('Y-m-d', $timestampstart).'';
						$nMonths = intval($inputnumbermod);
						$final = endCycle($startDate, $nMonths);

						$time = strtotime($final);
						$newformat = date('d/m/Y',$time);

						$date_before_end = $newformat.' '.date('H:i:s');//$services_user_date_activation_get_time;

						update_field('services_user_add_transaction_date_before_end',$date_before_end,'user_'.get_current_user_id());

						update_field('additional_info_mini','Продление тарифа '.get_the_title($dataid).'', $poster_id);
						update_field('additional_info','Продление тарифа '.get_the_title($dataid).' до '.str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')), $poster_id);
					} else {

						$startDate = ''.date('Y-m-d').'';
						$nMonths = intval($inputnumbermod);
						$final = endCycle($startDate, $nMonths);

						$time = strtotime($final);
						$newformat = date('d/m/Y',$time);

						$date_before_end = $newformat.' '.date('H:i:s');

						update_field('services_user_add_transaction_date_before_end',$date_before_end,'user_'.get_current_user_id());

						update_field('additional_info_mini','Подключение тарифа '.get_the_title($dataid).'', $poster_id);
						update_field('additional_info','Подключение тарифа '.get_the_title($dataid).' до '.str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')), $poster_id);
					}


					update_field('services_user_services',$dataid,'user_'.get_current_user_id());
					update_field('services_user_periodicity','period','user_'.get_current_user_id());

					// services_user>services    =    id услуги
					// services_user>periodicity    =    period
					// services_user>date_activation    =  date('d/m/Y H:i:s')
					// services_user>add_transaction>id_transaction    =    id транзы
					// services_user>add_transaction>date_before_end    =    date('d/m/Y H:i:s') + 1 mounth

					$result = array(
						'status' => 'ok',
						'id' => $poster_id,
					);
				}
			} else {
				$result = array(
					'status' => 'error',
					'id' => '0'
				);
			}
		}

	} else {
		$result = array(
			'status' => 'error',
			'id' => '0'
		);
	}

	echo json_encode($result);
	die;

}

if (!function_exists('user_dashboard_reviews')) {
	function user_dashboard_reviews() {
		global $post;
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		$result = print_css_links('user_page');
		$result .= print_js_links()['user_page'];
		$result .= print_js_links()['show_block'];
		$result .= print_css_links('show_block');
		$result .= print_js_links()['comments_loader_dashboard'];
		$result .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result .= '<div class="page_content page_container background_light review_container_about visible">';
		$result .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result .= '        <div class="profile-wrapper">';
		$result .= '            <div class="profile-wrapper__left">';
		$result .= print_css_links( 'list_post_single' );
		$result .= user_menu($current_user,$user_id,'reviews');
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= '<div class="user_zero_message">Вы еще не публиковали свои обзоры на нашем сайте.</div>';
		$sort_type = 'new';
		if ( $sort_type == 'new' ) {
			$myposts = get_posts( array(
				'author'         => $user_id,
				'posts_per_page' => 10,
				'post_type'      => 'casino'
			) );
		} elseif ( $sort_type == 'old' ) {
			$myposts = get_posts( array(
				'author'         => $user_id,
				'posts_per_page' => 10,
				'post_type'      => 'casino',
				'orderby'        => 'date',
				'order'          => 'ASC',
			) );
		} elseif ( $sort_type == 'best' ) {
			$myposts = get_posts( array(
				'author'         => $user_id,
				'posts_per_page' => 10,
				'post_type'      => 'casino',
				'orderby'        => 'date',
				'order'          => 'ASC',
			) );
		}


		foreach( $myposts as $post ){
			setup_postdata( $post );
			$result .= list_post_single(get_the_ID(),$user_id,'casino');
		}
		//$result .= review_container_comments_profile();
		$result .= '</div>';
		$result .= '            <div class="profile-wrapper__right_sub"><div class="side_block white_block block_content border_radius_4px">'.profile_comments_stats($user_id,'Мои отклики',1,0).'</div>'.fast_links_profile( $user_id ,'noborder',[['/dashboard/services/pro/','Включить аккаунт PRO'],['/advices/','Полезные советы'],['/user-edit/','Как заполнить аккаунт'],['/user-help/','Помощь']]).menu_footer_links(true).'</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}

if(!function_exists('user_zero_messages')) {
	add_action( 'wp_ajax_user_zero_messages', 'user_zero_messages' );
	add_action( 'wp_ajax_nopriv_user_zero_messages', 'user_zero_messages' );
	function user_zero_messages() {
		$type = $_POST['type'];
		$html = '<div class="user_zero_message">';
		if ($type == 'abuse') {
			$result = 'Вы еще не публиковали жалобы.';
		} elseif ($type == 'reviews') {
			$result = 'Вы еще не публиковали свои отзывы.';
		} elseif ($type == 'subs') {
			$result = 'У вас нет активных подписок на обновления информации, отзывов и жалоб на компании.';
		}
		$html_end = '</div>';

		echo $html.$result.$html_end;
		die;
	}
}
if ( ! function_exists( 'user_after_reg_fields' ) ) {
	add_action( 'wp_ajax_user_after_reg_fields', 'user_after_reg_fields' );
	add_action( 'wp_ajax_nopriv_user_after_reg_fields', 'user_after_reg_fields' );
	function user_after_reg_fields() {
		$data = $_POST;
		//print_r($data);
		$fields      = array();
		$result      = '';
		$user_id     = $data['user_id'];
		$user_avatar = get_field( 'avatarimage', 'user_' . $user_id );
		if ( ! $user_avatar || $user_avatar == '' ) {
			$fields['user_avatar'] = array(
				'type'  => 'avatar_upload',
				'name'  => 'user_avatar',
				'title' => __( 'Аватар', 'sa_theme' ),
			);
		}
		/*$result .= '<div class="popup_container" id="popup_update_fields">';
		$result .= '<div class="popup_window box_shadow">';
		$result .= '<div class="popup_close_button pointer"></div>';*/
		$result .= '<form class="form_popup flex flex_column"  action="' . admin_url( 'admin-ajax.php' ) . '" method="post" id="popup_update_fields">';

		if ( array_key_exists( 'user_avatar', $fields ) && $data['step'] != 'fields' || $data['step'] == 'avatar' ) {
			$result .= '<input type="hidden" name="action" value="user_update_fields_avatar" />';
			$result .= '<div class="file_upload_avatar">';
			$result .= '<label for="file_upload_avatar">';
			$result .= '<div class="file_upload_avatar_image m_b_10"><div class="file_delete"></div></div>';
			$result .= '<input type="file" id="file_upload_avatar" accept="image/*">';
			$result .= '<div class="button button_violet radius_small m_b_10 pointer link_upload_avatar">' . __( 'Загрузить аватар', 'sa_theme' ) . '</div>';
			$result .= '</label>';
			$result .= '</div>';
			$result .= '<div class="link_container"></div>';
		} else {
			$result .= '<input type="hidden" name="action" value="user_update_fields" />';
			foreach ( $fields as $field ) {
				if ( $field['type'] == 'text' ) {
					$result .= '<input type="text" name="' . $field['name'] . '" placeholder="' . $field['title'] . '" class="input_big m_b_10 placeholder_dark radius_small" />';
				} elseif ( $field['type'] == 'textarea' ) {
					$result .= '<textarea name="' . $field['name'] . '" placeholder="' . $field['title'] . '" class="input_big m_b_10 placeholder_dark radius_small"></textarea>';
				} elseif ( $field['type'] == 'select_country' ) {
					$result .= '<div class="filter_field_select_country dropdown inactive radius_small input_big m_b_10" id="form_popup_select_country" >';
					$result .= '<span class="field_title">' . $field['title'] . '</span>';
					$result .= '<input type="hidden" name="' . $field['name'] . '" value="" />';
					$result .= '</div>';
				} elseif ( $field['type'] == 'select_city' ) {
					$result .= '<div class="filter_field_select_city m_b_10" id="form_popup_select_cities" >';
					$result .= '<input type="text" name="' . $field['name'] . '" placeholder="' . $field['title'] . '" class="input_big  placeholder_dark radius_small" />';
					$result .= '</div>';
				} elseif ( $field['type'] == 'taxonomy' ) {
					$result .= '<div class="filter_field_select_tax dropdown inactive radius_small input_big m_b_10" id="form_popup_select_countries" data-taxonomy="' . $field['taxonomy'] . '" >';
					$result .= '<span class="field_title">' . $field['title'] . '</span>';
					$result .= '<input type="hidden" name="' . $field['name'] . '" value="" />';
					$result .= '</div>';
				}
			}
			$result .= '<input type="submit" name="submit" class="button button_violet radius_small m_b_10 pointer" value="' . __( 'Завершить регистрацию', 'sa_theme' ) . '">';
			$result .= '<div class="link_container"><span class="span_link link_skip_fields font_small pointer">' . __( 'Заполнить позже', 'sa_theme' ) . '</span></div>';
		}
		$result .= '</form>';
		/*$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';*/
		echo $result;
		die;
	}
}
if(!function_exists('menu_footer_links')) {
	function menu_footer_links($isMobile = false){
		if ($isMobile == true) {
			$result = '<div class="wrap-links-user-menu-footer ismobile_flex">';
		} else {
			$result = '<div class="wrap-links-user-menu-footer isdesctop">';
		}
		$primaryNav = wp_get_nav_menu_items(5681);
		$i = 0;
		foreach ( $primaryNav as $item ) {
			$i++;
			$name = $item->title;

			if ($name == 'Юридическая информация') {
				$name = 'Информация';
			}

			if ($name == 'Политика конфиденциальности') {
				$name = 'Конфиденциальность';
			}

			if ($name == 'Пользовательское соглашение') {
				$name = 'Соглашение';
			}

			if (count($primaryNav) == $i) {
				$result .= '<a class="wrap-links-user-menu-footer__link font_smaller color_dark_gray link_no_underline" href="'.$item->url.'"><span class="border_no_color">'.$name.'</span></a>';
			} else {
				$result .= '<a class="wrap-links-user-menu-footer__link font_smaller color_dark_gray link_no_underline after-dot" href="'.$item->url.'"><span class="border_no_color">'.$name.'</span></a>';
			}
		}
		$result .= '<div class="wrap-links-user-menu-footer__cr font_small color_dark_gray">' . __( 'Это развод™', 'er_theme' ) . ' &copy; ' . date( 'Y' ) . '</div>';
		$result .= '</div>';
		return $result;
	}
}
if(!function_exists('ajax_upload_avatar')) {
	add_action( 'wp_ajax_ajax_upload_avatar', 'ajax_upload_avatar' );
	add_action( 'wp_ajax_nopriv_ajax_upload_avatar', 'ajax_upload_avatar' );
	function ajax_upload_avatar() {
		//$user_id = $_POST['user_id'];
		$arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
		if (in_array($_FILES['file']['type'], $arr_img_ext)) {
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			//$file = & $_FILES['file'];
			$attachment_id = media_handle_upload( 'file', 0 );

			if ( is_wp_error( $attachment_id ) ) {
				$result = array(
					'status' => 'error',
					'message' => __('Ошибка загрузки изображения','er_theme'),
				);
			} else {
				$file_url = wp_get_attachment_url($attachment_id);
				$thumb_url = wp_get_attachment_thumb_url($attachment_id);
				$medium_url = wp_get_attachment_image_url($attachment_id,'medium');
				$result = array(
					'status' => 'ok',
					'message' => __('Изображение успешно загружено','er_theme'),
					'file_id' => $attachment_id,
					'file_url' => $file_url,
					'thumb_url' => $thumb_url,
					'medium_url' => $medium_url,
					'text_0' => __('Загрузить аватар','sa_theme'),
					'text_1' => __('Сохранить аватар','sa_theme'),
					'text_2' => __('Загрузить новый','sa_theme'),
				);
			}
			echo json_encode($result);
		} else {
			$result = array(
				'status' => 'error',
				'message' => __('Допустимые форматы: jpg, jpeg, png, gif','er_theme'),
			);
			echo json_encode($result);
		}
		die;
	}
}

if(!function_exists('user_update_fields_avatar')) {
	add_action( 'wp_ajax_user_update_fields_avatar', 'user_update_fields_avatar' );
	add_action( 'wp_ajax_nopriv_user_update_fields_avatar', 'user_update_fields_avatar' );
	function user_update_fields_avatar() {
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;

		$id_go_upd = 0;
		$args = array( 'post_type' => 'attachment', 'post_mime_type' => 'image' ,'post_status' => null, 'author' => $user_id, 'numberposts' => 1 );
		$attachments = get_posts($args);
		if ($attachments) {
			foreach ( $attachments as $attachment ) {
				$id_go_upd = $attachment->ID;
				$guid = $attachment->guid;
			}
		}
		//echo $id_go_upd;
		wp_reset_postdata();
		if ($id_go_upd != 0) {
			update_field('photo_profile', $id_go_upd, 'user_'.$user_id);
		}

		$arr_media = ['url' => wp_get_attachment_image_url($id_go_upd,'medium'),'url_thumb' => wp_get_attachment_image_url($id_go_upd,'thumbnail')];
		echo json_encode($arr_media);
		die;
	}
}


if (!function_exists('remove_avatar')) {
	add_action( 'wp_ajax_remove_avatar', 'remove_avatar' );
	add_action( 'wp_ajax_nopriv_remove_avatar', 'remove_avatar' );

	function remove_avatar() {
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		update_field('photo_profile','', 'user_'. $user_id );
		echo 'background-image: url(/wp-content/themes/eto-razvod-1/img/icon_user_default.svg);background-size: cover;border: 1px solid #cfdadf;';
		die;
	}
}

if ( ! function_exists( 'gotoverify_profile' ) ) {
	add_action( 'wp_ajax_gotoverify_profile', 'gotoverify_profile' );
	add_action( 'wp_ajax_nopriv_gotoverify_profile', 'gotoverify_profile' );
	function gotoverify_profile() {
		$answear = 'Произошла ошибка, обратитесь за помощью на e-mail адрес - info@eto-razvod.ru';
		$status = 'error';
		if ( is_user_logged_in() ) {
			$current_user  = wp_get_current_user();
			$user_id       = intval( $current_user->data->ID );
			$key = wp_generate_uuid4();
			update_field('key_activation', $key, 'user_'.$user_id);

			date_default_timezone_set( 'Europe/Moscow' );
			global $wpdb;

			$user = new WP_User($user_id);

			$user_login = stripslashes($user->user_login);
			$user_email = stripslashes($user->user_email);
			$headers[] = 'content-type: text/html';
			$headers[] = 'List-Unsubscribe: <mailto:info@eto-razvod.info?subject=Отпишите меня от рассылок>, <https://etorazvod.ru/?unsubscribe='.$user_email.'>';
			$user_info = get_userdata($user_id);
			$user_bio = $user->__get('key_activation');

			$mail_key = wp_generate_uuid4();
			$linkact = get_site_url().'/activation/?activation='.$user_bio.'&user='.$user_info->data->user_nicename.'&key='.$mail_key;
			$message = sprintf(__("Добрый день, уважаемый пользователь! Вы запросили подтверждение вашего профиля."), get_option('blogname')) . "\r\n\r\n";
			$message .= sprintf(__('Для того, чтобы подтвердить профиль, перейдите, пожалуйста, по ссылке ниже: %s'), $linkact) . "\r\n\r\n";
			$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');

			$mydb->insert(
				'mails',
				array('status'=> 'not_sent','reg_date' => $user_info->data->user_registered,'user_id' => $user_info->data->ID, 'mail_type' => 'registration','mail_key' => $mail_key, 'sent' => date('Y-m-d H:i:s')),
				array( '%s', '%s', '%s','%s','%s','%s')
			);

			$linkerimg = '<img src="https://etorazvod.ru/engine/mail_update_status.php?key='.$mail_key.'" style="width:1px; height:1px;" />';
			$message .= sprintf(__('%s'), $linkerimg) . "\r\n\r\n";
			$timeset = get_field('timeset',$user_id);

			$mailResult = false;
			$time = time();
			$timeRazNica = time() - intval($timeset);
			if ($timeRazNica > 120) {
				if (strlen($user_email) > 3) {
					$answear = 'Ссылка для подтверждения вашего профиля отправлена на почту, указанную при регистрации';
					$status = 'ok';
					if (get_field('from_site_send', 'user_'.$user_id)) {
						if (intval(get_field('from_site_send', 'user_'.$user_id)) != 0) {
							$mailResult = wp_mail($user_email, sprintf(__('[%s] Подтверждение профиля на сайте eto-razvod.ru'), get_option('blogname')), $message, $headers);
						}
					} else {
						$mailResult = wp_mail($user_email, sprintf(__('[%s] Подтверждение профиля на сайте eto-razvod.ru'), get_option('blogname')), $message, $headers);
					}
					
				} else {
					$answear = 'Произошла ошибка, обратитесь за помощью на e-mail адрес - info@eto-razvod.ru';
				}
				update_field('timeset',$time, $user_id);
			} else {
				$timecheck = 120 - $timeRazNica;
				$answear = 'Через '.$timecheck.' секунд можно будет запросить повторное письмо с инструкциями по активации';
			}


			if ($mailResult == 1) {
				$mail = $mydb->get_results("select * from mails WHERE mail_key = '$mail_key'");

				$mydb->update(
					'mails',
					array('status'=> 'sent'),
					array( 'id' => $mail[0]->id ),
					array( '%s' )
				);
				$mydb->update(
					'mails',
					array('updated'=> date('Y-m-d H:i:s')),
					array( 'id' => $mail[0]->id ),
					array( '%s' )
				);


			}

		} else {
			$answear = 'Произошла ошибка, обратитесь за помощью на e-mail адрес - info@eto-razvod.ru';
		}
		$array = ['answear' => $answear, 'status' => $status];
		echo json_encode($array);
		die;
	}
}

add_action( 'wp_ajax_savepass', 'savepassfunc' );
add_action( 'wp_ajax_nopriv_savepass', 'savepassfunc' );

function savepassfunc(){


	$currentuserdata = wp_get_current_user();
	$iduser = $currentuserdata->data->ID;
	$loginuser = $currentuserdata->data->user_login;
	$passuser = $_POST["savepass"];

	if ( (isset($passuser)) && ($passuser != '') && ($passuser != ' ')) {
		$user_id = wp_update_user( [
			'ID'       => $iduser,
			'user_login' => $loginuser,
			'user_pass' => $passuser
		] );

		if ( is_wp_error( $user_id ) ) {
			$textstatus = "Пароль некорректный";
		}
		else {
			$textstatus = "Ok";
			$content_reg = 'Ваш пароль был успешно изменен. Если вы этого не делали, пожалуйста, срочно свяжитесь с администрацией сайта, чтобы обезопасить свой аккаунт.';
			notify_user_action('system_password_changed',$iduser,'Пароль успешно изменен!',$content_reg);
		}

		$result = array(
			'status' => 'ok',
			'secondstatus' => $textstatus
		);
		echo json_encode($result);
		die;
	} else {

		$result = array(
			'status' => 'errr',
			'secondstatus' => 'errr'
		);
		echo json_encode($result);
		die;
	}

}

add_action( 'wp_ajax_setemailnew', 'setemailnewfunc' );
add_action( 'wp_ajax_nopriv_setemailnew', 'setemailnewfunc' );

function setemailnewfunc(){
	global $wpdb;
	date_default_timezone_set( 'Europe/Moscow' );
	$date = new DateTime();
	$emailnew = htmlspecialchars($_POST["emailnew"]);

	function getName($n) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';

		for ($i = 0; $i < $n; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}
		return $randomString;
	}

	if(filter_var($emailnew, FILTER_VALIDATE_EMAIL)) {
		if ( email_exists($emailnew) ) {
			$user_info = get_userdata(get_current_user_id());
			if ($user_info->data->user_email == $emailnew) {
				update_field('new_email_field', '', 'user_'.get_current_user_id());
				update_field('date_from_update', '', 'user_'.get_current_user_id());
				$result = array(
					'status' => 'Перезагрузка страницы',
					'status_second' => 'refresh'
				);
			} else {
				$result = array(
					'status' => 'Пользователь с таким e-mail уже есть',
					'status_second' => 'error'
				);
			}

		} else {
			update_field('new_email_field', $emailnew, 'user_'.get_current_user_id());
			update_field('date_from_update', $date->getTimestamp(), 'user_'.get_current_user_id());
			update_field('key_activation', getName(10), 'user_'.get_current_user_id());
			update_field('user_activation', 'no', 'user_'.get_current_user_id());
			$user_info = get_userdata(get_current_user_id());
			$linkact = get_site_url().'/activation-email/?activation='.get_field('key_activation','user_'.get_current_user_id()).'&user='.$user_info->data->user_nicename;
			$message = sprintf(__("Вы отправили запрос на изменение e-mail адреса на сайте %s!"), get_option('blogname')) . "<br>";
			$message .= sprintf(__('На данный момент у Вас установлен e-mail адрес: %s'), $user_info->data->user_email) . "<br>";
			$message .= sprintf(__('Вы отправили запрос на изменение e-mail адреса на: %s'), $emailnew) . "<br>";
			$message .= sprintf(__('Для того, чтобы изменения вступили в силу - перейдите по ссылке: %s'), $linkact) . "<br><br>";



			//wp_mail($emailnew, sprintf(__('[%s] Вы отправили запрос на изменение e-mail адреса на сайте eto-razvod.ru'), get_option('blogname')), $message);



			$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
			$user = get_user_by( 'ID', get_current_user_id() );
			$user2 = get_userdata($user->ID);
			$mail_key = wp_generate_uuid4();

			$mydb->insert(
				'mails',
				array('status'=> 'not_sent','reg_date' => $user2->data->user_registered,'user_id' => $user2->data->ID, 'mail_type' => 'change_email','mail_key' => $mail_key, 'sent' => date('Y-m-d H:i:s')),
				array( '%s', '%s', '%s','%s','%s','%s')
			);

			$headers = array(
				'From: Это развод™ <check@eto-razvod.info>',
				'content-type: text/html',
			);
			$linkerimg = '<img src="https://etorazvod.ru/engine/mail_update_status.php?key='.$mail_key.'" style="width:1px; height:1px;" />';
			$message .= sprintf(__('%s'), $linkerimg) . "\r\n\r\n";

			$mailResult = false;
			$mailResult = wp_mail($emailnew, sprintf(__('[%s] Вы отправили запрос на изменение e-mail адреса на сайте eto-razvod.ru'), get_option('blogname')), $message, $headers);
			if ($mailResult == 1) {
				$mail = $mydb->get_results("select * from mails WHERE mail_key = '$mail_key'");

				$mydb->update(
					'mails',
					array('status'=> 'sent'),
					array( 'id' => $mail[0]->id ),
					array( '%s' )
				);
				$mydb->update(
					'mails',
					array('updated'=> date('Y-m-d H:i:s')),
					array( 'id' => $mail[0]->id ),
					array( '%s' )
				);


			}



			$result = array(
				'status' => 'Для подтверждения перейдите по ссылке отправленной на новый e-mail',
				'status_second' => 'ok'
			);
		}
	} else {
		$result = array(
			'status' => 'Email-адрес некорректен',
			'status_second' => 'error'
		);
	}




	echo json_encode($result);

	die;

}

add_action( 'wp_ajax_current_user', 'current_userfunc' );
add_action( 'wp_ajax_nopriv_current_user', 'current_userfunc' );

function current_userfunc(){
	$user = wp_get_current_user();
	$user_email = $user->user_email;
	$user_id = $user->ID;
	$result = array(
		'email' => $user_email,
		'userid' => $user_id
	);
	echo json_encode($result);
	die;
}

//wp_new_user_notification( $user_id, 'user' );

if ( ! function_exists( 'card_before_new' ) ) {
	add_action( 'wp_ajax_card_before_new', 'card_before_new' );
	add_action( 'wp_ajax_nopriv_card_before_new', 'card_before_new' );

	function card_before_new() {
		date_default_timezone_set( 'Europe/Moscow' );
		$userid = wp_get_current_user();
		$user_email = $userid->user_email;
		$user_id_new = $userid->ID;

		$amountval = intval( $_POST["amountval"] );
		$id_trans_wp = intval( $_POST["id_trans_wp"] );
		if ($id_trans_wp != 0) {
			$poster_id = wp_insert_post( wp_slash( array(
				'post_status'   => 'publish',
				'post_type'  => 'tranzaktsii',
				'post_title' => 'Привязка компании ' . date( 'd.m.Y H:i:s' ).' [ '.$userid->user_email.' , '.$userid->user_nicename.' , '.$userid->user_firstname. ' '. $userid->user_lastname.'] Сумма: '.$amountval.' RUB',
			) ) );
			update_field( 'connect_company', $id_trans_wp, $poster_id );
		} else {
			$poster_id = wp_insert_post( wp_slash( array(
				'post_status'   => 'publish',
				'post_type'  => 'tranzaktsii',
				'post_title' => 'Пополнение баланса ' . date( 'd.m.Y H:i:s' ).' [ '.$userid->user_email.' , '.$userid->user_nicename.' , '.$userid->user_firstname. ' '. $userid->user_lastname.'] Сумма: '.$amountval.' RUB',
			) ) );
		}


		$id_trans = time();
		$dater = date( 'd/m/Y' );
		update_field( 'type', 'add', $poster_id );
		update_field( 'add_options' . '_' . 'add_variations', 'card', $poster_id );
		update_field( 'add_options' . '_' . 'amount', $amountval, $poster_id );
		update_field( 'add_options' . '_' . 'data', $dater, $poster_id );
		update_field( 'data_time', date( 'd/m/Y H:i:s' ), $poster_id );
		update_field( 'add_options' . '_' . 'id_valute', 'rub', $poster_id );
		update_field( 'add_options' . '_' . 'status', 'empty', $poster_id );
		update_field( 'id_user', get_current_user_id(), $poster_id );
		
		update_field('id_user_text', get_current_user_id(), $poster_id);
		update_field( 'add_options' . '_' . 'id_transaction', $id_trans, $poster_id );

		if ($_POST['service'] == "PRO") {
			update_field('service','pro',$poster_id);
		}
		if (intval($_POST['month']) > 0) {
			update_field('month',intval($_POST['month']),$poster_id);
		}
		//update_field( 'id_user', get_current_user_id(), $poster_id );


		$result = array(
			'email' => $user_email,
			'userid' => $user_id_new,
			'id'     => $poster_id,
			'trans_id' => $id_trans
		);
		echo json_encode( $result );
		die;
	}
}

function ajax_check_user_logged_in() {
	echo is_user_logged_in()?'yes':'no';
	die();
}
add_action('wp_ajax_is_user_logged_in', 'ajax_check_user_logged_in');
add_action('wp_ajax_nopriv_is_user_logged_in', 'ajax_check_user_logged_in');

function check_user_skills() {
	$current_user = wp_get_current_user();
	$user_id = $current_user->data->ID;

	$user_skills = get_field( 'user_skills','user_'.$user_id );
	$user_skills = isset( $user_skills[0] ) ? $user_skills[0] : '';
	if ( strlen( $user_skills ) < 2 ) {
		echo 'yes';
	} else {
		echo 'no';
	}
	die;
}
add_action('wp_ajax_check_user_skills', 'check_user_skills');
add_action('wp_ajax_nopriv_check_user_skills', 'check_user_skills');

if (!function_exists('ajax_link_outside_add_company')) {
	add_action( 'wp_ajax_ajax_link_outside_add_company', 'ajax_link_outside_add_company' );
	add_action( 'wp_ajax_nopriv_ajax_link_outside_add_company', 'ajax_link_outside_add_company' );
	function ajax_link_outside_add_company() {
		$data = $_POST;
		$result = array();
		if(!is_user_logged_in()) {
			$result['status'] = 'auth';
			if($data['type'] == 'review') {
				$result['message'] = __('Чтобы оставить отзыв компании, пожалуйста, авторизуйтесь на сайте.','er_theme');
			} elseif($data['type'] == 'abuse') {
				$result['message'] = __('Чтобы оставить жалобу на компанию, пожалуйста, авторизуйтесь на сайте.','er_theme');
			} else {
				$result['message'] = __('Пожалуйста, авторизуйтесь на сайте.','er_theme');
			}

		} else {
			$current_user = wp_get_current_user();
			$user_id = $current_user->data->ID;
			$result['status'] = 'ok';
			$message = '';
			$class_type = $data['type'];
			if ($class_type == 'reviewgetcompany') {
				$class_type = 'review';
			}
			$message .= '<div class="popup_container" id="popup_link_outside_'.$class_type.'" data-form-type="'.$data['type'].'">';
			$message .= '<div class="popup_window box_shadow">';
			$message .= '<div class="popup_close_button pointer"></div>';

			$message .= '<div class="p_30 flex flex_column">';
			if($data['type'] == 'abuse') {
				$message .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">'.__('Новая жалоба на компанию','er_theme').'</div>';
			} elseif($data['type'] == 'review') {
				$message .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">'.__('Новый отзыв о компании','er_theme').'</div>';
			} elseif($data['type'] == 'reviewgetcompany') {
				$message .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">'.__('Добавить компанию','er_theme').'</div>';
			}

			$message .= '<div class="autocomplete_container" data-type="search_companies" id="popup_search_companies">';
			$message .= '<input name="autocomplete_text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" type="text" value="" placeholder="'.__('Введите название компании','er_theme').'" />';
			$message .= '<input name="autocomplete_result" type="hidden" value="" />';
			$message .= '<div class="autocomplete_icon_search"></div>';
			$message .= '<div class="autocomplete_icon_close"></div>';
			$message .= '<div class="autocomplete_search_results"></div>';
			$message .= '</div>';
			$message .= '<div class="outside_form_container"></div>';
			$message .= '</div>';
			$message .= '</div>';
			$message .= '</div>';
			$result['message'] = $message;
		}
		echo json_encode($result);

		die;
	}
}

if (!function_exists('ajax_load_documents_form')) {
	add_action( 'wp_ajax_ajax_load_documents_form', 'ajax_load_documents_form' );
	add_action( 'wp_ajax_nopriv_ajax_load_documents_form', 'ajax_load_documents_form' );
	function ajax_load_documents_form() {
        $current_language = get_locale();
        if($current_language != 'ru_RU') {
            $text_oplata = 'Payment';
            $text_widget = 'Widget';
        } else {
            $text_oplata = 'Оплата';
            $text_widget = 'Виджет';
        }
		$result = '<span class="add_comment_company__title color_dark_blue add_comment_company__title_comm">Пожалуйста, добавьте в свободной форме важную информацию, о которой мы должны знать. (Необязательно)
</span><textarea name="add_comment_company" class="m_b_20 add_comment_company"></textarea>';
		$result .= '<form class="fileUpload" enctype="multipart/form-data" style="display:none;">
        				<div class="form-group">
        					<span class="file_title">Подтверждающие документы</span>
        					<div class="step_4_add_comp">
        					<p>Загрузите скриншоты документов и иные файлы, подтверждающие, что это ваша компания. Отправьте файлы в следующих форматах: png, jpg, pdf, doc, docx, вес - до 500 кб.</p> 

<p>Ваши файлы являются конфиденциальной информацией и не будут опубликованы нами в открытом доступе на сайте (см. пункты документов). Эта информация необходима для того, чтобы идентифицировать вашу принадлежность компании, чтобы карточка вашей компании не попала в руки ваших конкурентов или иных лиц.</p> 

<p>После проверки документов модераторами вы сможете работать с карточкой компании.</p> 

<p>Подробнее в наших документах:</p>

</div>
            				<div class="fileuploadcomp_wrapper">
            				<label>
							<input type="file" id="fileuploadcomp" accept="image/*, application/*" multiple />
							</label>
							</div>
						</div>
					</form>
					
					<div class="select_contact">
					<span class="add_company_title">Контактное лицо</span>
    <div class="select_contact_inside">
    <select name="select_contact" class="select_big m_b_10 border_radius_4px select_arrow">
		<option selected="selected">Мессенджер для связи</option>
		<option value="telegram">Telegram</option>
		<option value="skype">Skype</option>
		<option value="email">E-mail</option>
		<option value="whatsapp">WhatsApp</option>
		<option value="viber">Viber</option>
		</select>
<input type="text" name="contact_name" placeholder="Логин" class="input_big m_b_10 placeholder_dark border_radius_4px" value="">
</div>
</div>

					<span class="add_company_title">Как получить статус «Подтвержденная компания»?</span>
					<div class="step_5_add_comp">
					

<p>Для того, чтобы подтвердить права на управление профилем компании и получить статус «Подтвержденная компания», а также пользоваться возможностью редактировать информацию в карточке, вам нужно:</p>
<p>Оплатить 4990 рублей. Мы берем разовую оплату для проведения модерации.</p>
<p>Бесплатно пройти верификацию и получить статус «Подтвержденная компания», установив виджет нашего проекта на одну из страниц вашего сайта.</p>
<!--(виджет устанавливается либо на главную страницу, либо на страницу о компании, он не является сквозной ссылкой).-->

</div>
<span class="add_company_title">После подтверждения компании вы получите:</span>

<ul class="ul_add_company">
<li>Личный кабинет компании со статистикой и аналитикой. <a href="/wp-content/uploads/2021/10/1633317835774.png"><img class="aligncenter" src="/wp-content/uploads/2021/10/1633317835774.png"></a></li>
<li>Статус «Подтвержденная компания». <a href="/wp-content/uploads/2021/10/1633354332543-1.png"><img class="aligncenter" src="/wp-content/uploads/2021/10/1633354332543-1.png"></a></li>
</ul>
<span class="add_company_title">Вы сможете:</span>
<ul class="ul_add_company">
<li>Редактировать информации о компании.</li>
<li>Приватно урегулировать споры с пользователями, оставившими отзывы и жалобы через внутренний мессенджер на нашем сайте. <a href="/wp-content/uploads/2021/10/1633318084681-1.png"><img class="aligncenter" src="/wp-content/uploads/2021/10/1633318084681-1.png"></a></li></li>
<li>Отвечать на отзывы и жалобы от лица компании.</li>
<li>Повышать позиции компании в рейтинге.</li> 
<li>Публиковать экспертные статьи на нашем сайте.</li> 
<li>Добавлять акции, баннеры, попап и дополнительные промо-материалы.</li>
<li>Размещать дополнительную рекламу на страницах конкурентов.</li>
</ul>

					<div class="add_company_wrap"> 
						<div class="add_company_wrap_item">
							<span><input type="radio" name="verify_method" id="pay" checked=""><label for="verify_method">'.$text_oplata.'</label></span>
						</div>
						<div class="add_company_wrap_item">
							<span><input type="radio" name="verify_method" id="widget"><label for="verify_method">'.$text_widget.'</label></span>
						</div>
					</div>
					<div class="finish_btn_add_company button button_violet font_small font_bold pointer">Далее</div>
					<div class="back_first_step button button_green font_small font_bold pointer m_t_10">Назад</div>
					';
		echo $result;
		die;
	}
}

add_action( 'wp_ajax_file_upload', 'file_upload_callback' );
add_action( 'wp_ajax_nopriv_file_upload', 'file_upload_callback' );
function file_upload_callback() {
	$arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif','application/msword','application/pdf');
	$b = '';
	for($i = 0; $i < count($_FILES['file']['name']); $i++) {

		if (in_array($_FILES['file']['type'][$i], $arr_img_ext)) {

			$upload = wp_upload_bits($_FILES['file']['name'][$i], null, file_get_contents($_FILES['file']['tmp_name'][$i]));
			//$b .= $upload['url'].',';
			$params['guid'] = $upload['url'];
			$params['post_mime_type'] = 'image/jpeg';
			// Insert the attachment.
			$attach_id = wp_insert_attachment($params, $upload['file'], 0);
			if (!is_numeric($attach_id)) {
				return false;
			}
			if (!function_exists('wp_generate_attachment_metadata')) {
				// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
				require_once ABSPATH . 'wp-admin/includes/image.php';
			}
			// Generate the metadata for the attachment, and update the database record.
			$metas['_wp_attachment_metadata'] = wp_generate_attachment_metadata($attach_id, $upload['file']);
			foreach ($metas as $key => $value) {
				update_post_meta($attach_id, $key, $value);
			}
			if (substr($upload['url'], -3) == "pdf") {
				$b .= '<span class="fileuploadcomp_item" style="background-image:url(/wp-content/themes/eto-razvod-1/img/file_pdf.svg);background-repeat: no-repeat;background-size: 50px;" att-id="'.$attach_id.'"><span class="close"></span></span>';
			} else {
				$b .= '<span class="fileuploadcomp_item" style="background-image:url('.$upload['url'].');" att-id="'.$attach_id.'"><span class="close"></span></span>';
			}

			//$upload['url'] will gives you uploaded file path
		}
	}
	echo $b;
	die;
}




add_action( 'wp_ajax_connect_company', 'connect_company_callback' );
add_action( 'wp_ajax_nopriv_connect_company', 'connect_company_callback' );
function connect_company_callback() {
	$poster_id = wp_insert_post( wp_slash( array(
		'post_status'   => 'publish',
		'post_type'  => 'request_add_company',
		'post_title' => 'Привязка компании',
	) ) );
	$company_name = htmlspecialchars($_POST['company_name']);
	$comp_id = $_POST['comp_id'];
	$comment_company = htmlspecialchars($_POST['comment_company']);
	$verify_method = htmlspecialchars($_POST['verify_method']);
	$image_views = $_POST['image_views'];
	$image_views_array = explode(",", $image_views);
	$contact_type = htmlspecialchars($_POST['contact_type']);
	$login_type = htmlspecialchars($_POST['login_type']);

	foreach ($image_views_array  as $item ) {
		$args = array('image_set' => intval($item));
		add_row('image_array', $args, $poster_id);
	}

	$current_user = wp_get_current_user();
	$user_id = $current_user->data->ID;

	update_field( 'user_id', $user_id, $poster_id );
	update_field( 'comp_id', $comp_id, $poster_id );
	update_field( 'company_name', $company_name, $poster_id );
	update_field( 'comment_company', $comment_company, $poster_id );
	update_field( 'type', $verify_method, $poster_id );
	update_field( 'contact_type', $contact_type, $poster_id );
	update_field( 'messanger_login', $login_type, $poster_id );
	$arr_temp = ['company_user' => $comp_id,'status' => 'nopay','id_conn_comp'=> $poster_id];
	add_row('comp_statuses',$arr_temp,'user_'.$user_id);
	//echo $b;
	//print_r($image_views_array);
	$arr = ['poster_id' => $poster_id,'price' => 1000];
	echo json_encode($arr);
	die;
}

/*$poster_id = wp_insert_post( wp_slash( array(
	'post_status'   => 'publish',
	'post_type'  => 'tranzaktsii',
	'post_title' => 'Пополнение баланса ' . date( 'd.m.Y H:i:s' ).' [ '.$userid->user_email.' , '.$userid->user_nicename.' , '.$userid->user_firstname. ' '. $userid->user_lastname.'] Сумма: '.$amountval.' RUB',
) ) );*/

add_action( 'wp_ajax_show_empty_company', 'show_empty_company_callback' );
add_action( 'wp_ajax_nopriv_show_empty_company', 'show_empty_company_callback' );
function show_empty_company_callback() {
	acf_form_head();
	$array_to_upd = [];
	$array_temp = get_field_objects(150502);
	foreach ($array_temp  as $item ) {
		$array_to_upd[] = $item['key'];
	}

	$field_additional_information = get_field_object('additional_information',150502);
	$field_additional_information_key = $field_additional_information['key'];

	$arr_del = ['field_6035832243eea','field_5e00aa15d398a','field_61224c430cb34','field_60922d2382c21','field_5e4039fc1efce','field_5ece31913b442','field_5ece31b13b443','field_5ece31d43b444','field_5ece31dd3b445','field_5ece32003b446','field_6038ba4c3352b','field_60357e303c3e7','field_5ec3c271989da','field_5eaac22ec64d0','additional_information',$field_additional_information_key];
	foreach ($arr_del  as $item ) {
		if (($key = array_search($item, $array_to_upd)) !== false) {
			unset($array_to_upd[$key]);
		}
	}


	$acf_form_settings = array('post_id'       => 150502,
	                           'post_title'    => false,
	                           'post_content'  => false,
	                           'fields' => $array_to_upd,
	                           'submit_value'  => __('Update meta'));
	acf_form($acf_form_settings);
	die;
}

add_action( 'wp_ajax_add_company_by_user', 'add_company_by_user_callback' );
add_action( 'wp_ajax_nopriv_add_company_by_user', 'add_company_by_user_callback' );
function add_company_by_user_callback() {
	$name = $_POST['name'];
	$cat = $_POST['cat'];
	$term = get_term( intval($cat), 'affiliate-tags' );
	$slug = $term->slug;
	$term_id_wrapper = get_term_by('slug', $slug, 'companytypes');

	$current_user = wp_get_current_user();
	$user_id = $current_user->data->ID;



	$poster_id = wp_insert_post( wp_slash( array(
		'post_title'    => sanitize_text_field( $name ),
		'post_content'  => '',
		'post_status'   => 'draft',
		'post_author'   => $user_id,
		'post_type' => 'casino'
	) ) );

	update_field('company_name',sanitize_text_field( $name ),$poster_id);
	update_field('company_type',intval($term_id_wrapper->term_id),$poster_id);


	$arr = ['poster_id' => $poster_id,'cat' => $cat];
	echo json_encode($arr);
	die;
}

add_action( 'wp_ajax_add_company_by_user_editer', 'add_company_by_user_editer_callback' );
add_action( 'wp_ajax_nopriv_add_company_by_user_editer', 'add_company_by_user_editer_callback' );
function add_company_by_user_editer_callback() {
	$name = $_POST['name'];
	$cat = $_POST['cat'];
	$term = get_term( intval($cat), 'affiliate-tags' );
	$slug = $term->slug;
	$term_id_wrapper = get_term_by('slug', $slug, 'companytypes');

	$current_user = wp_get_current_user();
	$user_id = $current_user->data->ID;


	$poster_id = $_POST['add_new_company'];


	//update_field('company_name',sanitize_text_field( $name ),$poster_id);
	update_field('company_type',intval($term_id_wrapper->term_id),$poster_id);


	$arr = ['poster_id' => $poster_id,'cat' => $cat];
	echo json_encode($arr);
	die;
}

add_action( 'wp_ajax_show_tags_this', 'show_tags_this_callback' );
add_action( 'wp_ajax_nopriv_show_tags_this', 'show_tags_this_callback' );
function show_tags_this_callback() {
    //echo 'New company';
    $current_user = wp_get_current_user();
    $user_id = $current_user->data->ID;
    echo sa_new_form_for_add_company($user_id);
	//echo '<div class="get_cat_add_company">'.autocomplete_input( 'ratings_all_filter_autocomplete_skills', 'filter_ratings_comp_type', 'Укажите категорию вашей компании' ).'</div>';
	die;
}
//autocomplete_input( 'ratings_all_filter_autocomplete_skills', 'filter_ratings', 'Начните вводить текст' );

if (!function_exists('user_dashboard_messages')) {
	function user_dashboard_messages() {
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		$result = print_css_links('user_page');
		$result .= print_js_links()['user_page'];
		$result .= print_js_links()['show_block'];
		$result .= print_css_links('show_block');
		$result .= print_js_links()['comments_loader_dashboard'];
		$result .= print_js_links()['user_zero_message'];
		$result .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result .= '<div class="page_content page_container background_light review_container_about visible">';
		$result .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result .= '        <div class="profile-wrapper">';
		$result .= '            <div class="profile-wrapper__left">';

		$result .= user_menu($current_user,$user_id,'messages');
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub profile-wrapper__center_sub_dashboard_comments">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= review_container_comments_profile();
		$result .= '</div>';
		$result .= '            <div class="profile-wrapper__right_sub"><div class="side_block white_block block_content border_radius_4px comment_user_page_profile_comments_stats">'.profile_comments_stats($user_id,'Отклики на отзывы',1,0).'</div>'.fast_links_profile( $user_id ,'noborder',[['/dashboard/services/pro/','Включить аккаунт PRO'],['/advices/','Полезные советы'],['/user-edit/','Как заполнить аккаунт'],['/user-help/','Помощь']]).menu_footer_links(true).'</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}

add_action( 'wp_ajax_save_my_data', 'acf_form_head' );
add_action( 'wp_ajax_nopriv_save_my_data', 'acf_form_head' );



if (!function_exists('user_dashboard_publish_to_blog')) {
	function user_dashboard_publish_to_blog() {
		$current_user = wp_get_current_user();
		$user_id      = $current_user->data->ID;
		$result       = print_css_links( 'user_page' );
		$result       .= print_js_links()['user_subscription'];
		$result       .= print_js_links()['user_page'];
		$result       .= print_js_links()['show_block'];
		$result       .= print_css_links( 'show_block' );
		$result       .= print_css_links('user_service_form');
		$result       .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result       .= wp_enqueue_style( 'rating', get_template_directory_uri() . '/css/rating.css' );
		$result       .= '<div class="page_content page_container background_light review_container_about visible">';
		$result       .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result       .= '        <div class="profile-wrapper">';
		$result       .= '            <div class="profile-wrapper__left">';

		$result .= user_menu( $current_user, $user_id, 'services' );
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if ( function_exists( 'show_breadcrumbs' ) ) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= '<div class="services_wrapper">';

$result .= '<div class="white_block border_radius_4px p_30 flex flex_column">';
$result .= '	<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">Добавить статью</div>';

$result .= '<p style="font-size: 14px;">Вы можете опубликовать на нашем сайте свою статью, рассказать читателям о чем-то важном и привлечь их внимание к вашей компании. Стоимость публикации статьи в <a href="https://etorazvod.ru/blog/" target="_blank">Блог</a> - 14 000 руб, в <a href="https://etorazvod.ru/pages/" target="_blank">Статьи</a> - 20 000 руб. Статья должна быть уникальной: от 90% уникальности в любом сервисе проверки уникальности. Также мы проверяем качество статьи в программе Тургенев, статья должна иметь показатель риска не более 2 баллов.</p>';
//$result .= '<p style="font-size: 14px;">Вы можете опубликовать на нашем сайте свою статью, рассказать читателям о чем-то важном и привлечь их внимание к вашей компании. Стоимость публикации статьи в <a href="https://etorazvod.ru/blog/" target="_blank">Блог</a> - 14 000 руб, в <a href="https://etorazvod.ru/pages/" target="_blank">Статьи</a> - 20 000 руб. Статья должна быть уникальной: от 90% уникальности в любом сервисе проверки уникальности.</p>';

$result .= '<p style="font-size: 14px;margin-bottom: 20px;">Для того, чтобы опубликовать статью на наш сайт, сначала добавьте текст статьи в форму ниже или прикрепите ее в формате doc файла и отправьте на модерацию. Также оставьте в поле ниже свой актуальный контакт в мессенджере (WhatsApp, Skype, Telegram или Viber), после чего наш менеджер свяжется с вами.</p>';
$result .= '	<input type="text" name="title_name" placeholder="Название статьи" class="input_big m_b_10 placeholder_dark border_radius_4px input_form" value=""><textarea name="text_blogpost" class="m_b_20 text_area_text" placeholder="Текст статьи"></textarea>';

					$result .= '<form class="fileUpload fileUploadM m_b_20" enctype="multipart/form-data">';
        			$result .= '	<div class="form-group">';
        			$result .= '		<span class="file_title">Прикрепить файлы</span>';
        			$result .= '		<div class="step_4_add_comp">';
        			$result .= '		<p>Отправьте файлы в следующих форматах: png, jpg, pdf, doc, docx, вес - до 2 МБ</p>';
					$result .= '	</div>';
            		$result .= '		<div class="fileuploadcomp_wrapper">';
            		$result .= '		<label>';
					$result .= '		<input type="file" id="fileuploadcomp" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
text/plain, application/pdf, image/*" multiple="">';
					$result .= '		</label>';
					$result .= '		</div>';
					$result .= '	</div>';
					$result .= '</form>';




$result .= '	<div class="select_contact">';
$result .= '		<span class="add_company_title">Контактное лицо</span>';
$result .= '		<div class="select_contact_inside">';
$result .= '			<select name="select_contact" class="select_big m_b_10 border_radius_4px select_arrow">';
$result .= '				<option selected="selected">Мессенджер для связи</option>';
$result .= '				<option value="telegram">Telegram</option>';
$result .= '				<option value="skype">Skype</option>';
		$result .= '				<option value="whatsapp">WhatsApp</option>';
$result .= '				<option value="viber">Viber</option>';
$result .= '			</select>';
$result .= '			<input type="text" name="contact_name" placeholder="Логин" class="input_big m_b_10 placeholder_dark border_radius_4px" value="">';
$result .= '		</div>';
$result .= '	</div>';
$result .= '	<div class="button button_violet font_small font_bold pointer send_blog_post">Отправить</div>';
$result .= '</div>';





// args


		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;

		$args = array(
			'numberposts'	=> -1,
			'post_type'		=> 'userblogpost',
			'meta_query'	=> array(
				'relation'		=> 'AND',
				array(
					'key'		=> 'user_id',
					'value'		=> $user_id,
					'compare'	=> '='
				)
			)
		);

		$the_query = new WP_Query( $args );
		if( $the_query->have_posts() ):
			$result .= '<div class="wallet_history white_block block_content border_radius_4px m_t_15 flex flex_column">';
			$result .= '<div class="wallet_history__header flex">';
			$result .= '    <div class="rating_th rating_field_number sort  sort_default" data-rating-field="number">Название</div>';
			$result .= '    <div class="rating_th rating_field_number sort  sort_default" data-rating-field="number">Статус</div>';
			$result .= '    <div class="rating_th rating_field_number sort  sort_default" data-rating-field="number">Дата</div>';
			$result .= '</div>';
			while ( $the_query->have_posts() ) : $the_query->the_post();

				$result .= '<div class="wallet_history__row flex  align-items-center" attr-id="'.get_the_ID().'">    <div class="wallet_history__row__title">        <span class="wallet_history__row__span__item font_bold">'.get_the_title(get_the_ID()).'</span>    </div>    <div class="wallet_history__row__status"><div class="wallet_img_status_wrapper"><span class="wallet_img_status wallet_img_status_gray"></span><div class="wallet_img_status_text"><span class="wallet_img_status_paid">На модерации</span><span class="wallet_img_status_date">4.10.2021</span></div></div>    </div>    <div class="wallet_history__row__amount">        <span class="wallet_history__row__span__item">'.get_the_date('j.n.Y',get_the_ID()).'</span>    </div>    <!--<div class="wallet_history__row flex align-items-center wallet_history_row_pay"><span class="wallet_history__row__icon_card wallet_history__row__icon" data-amount="4990" data-email="dikobraz@ya.ru" data-userid="17" data-trans_id="1633322981" data-id="159266" data-method="bank_card"></span>    </div>--></div>';
			endwhile;
			$result .= '</div>';

		endif;
		wp_reset_query();






		$result .= '</div>';
		$result .= '</div>';
		$result .= '            <div class="profile-wrapper__right_sub">'.add_company($user_id).act_services($user_id).act_services_banner($user_id).fast_links_profile( $user_id ,'noborder',[['/dashboard/services/pro/','Включить аккаунт PRO'],['/advices/','Полезные советы'],['/user-edit/','Как заполнить аккаунт'],['/user-help/','Помощь']]).menu_footer_links(true).'</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}


if (!function_exists('user_dashboard_pro_buy')) {
	function user_dashboard_pro_buy() {
		$current_user = wp_get_current_user();
		$user_id      = $current_user->data->ID;
		$result       = print_css_links( 'user_page' );
		$result       .= print_js_links()['user_subscription'];
		$result       .= print_js_links()['user_page'];
		$result       .= print_js_links()['show_block'];
		$result       .= print_css_links( 'show_block' );
		$result       .= print_css_links('user_service_form');
		$result       .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result       .= wp_enqueue_style( 'rating', get_template_directory_uri() . '/css/rating.css' );
		$result       .= '<div class="page_content page_container background_light review_container_about visible">';
		$result       .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result       .= '        <div class="profile-wrapper">';
		$result       .= '            <div class="profile-wrapper__left">';

		$result .= user_menu( $current_user, $user_id, 'services' );
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if ( function_exists( 'show_breadcrumbs' ) ) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= '<div class="services_wrapper">';

		$result .= '<div class="white_block border_radius_4px p_30 flex flex_column">';
		$result .= '	<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">PRO аккаунт</div>';
		if ( get_field( 'services_user_services', 'user_' . get_current_user_id() )[0] == 84175 ) {
			$result .= '<div class="infoblock button_gray border_radius_4px">        <span class="infoblock__link color_dark_blue font_bold flex">            <span class="infoblock__icon"></span>            <span class="infoblock__text">На данный момент у вас подключен <span class="user_label font_smaller pro_get_t">PRO</span> до '.strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ').'</span>        </span></div>';
		}
		//$result .= '<p style="font-size: 14px;">Вы можете опубликовать на нашем сайте свою статью, рассказать читателям о чем-то важном и привлечь их внимание к вашей компании. Стоимость публикации статьи в <a href="https://etorazvod.ru/blog/" target="_blank">Блог</a> - 14 000 руб, в <a href="https://etorazvod.ru/pages/" target="_blank">Статьи</a> - 20 000 руб. Статья должна быть уникальной: от 90% уникальности в любом сервисе проверки уникальности. Также мы проверяем качество статьи в программе Тургенев, статья должна иметь показатель риска не более 2 баллов.</p>';
//$result .= '<p style="font-size: 14px;">Вы можете опубликовать на нашем сайте свою статью, рассказать читателям о чем-то важном и привлечь их внимание к вашей компании. Стоимость публикации статьи в <a href="https://etorazvod.ru/blog/" target="_blank">Блог</a> - 14 000 руб, в <a href="https://etorazvod.ru/pages/" target="_blank">Статьи</a> - 20 000 руб. Статья должна быть уникальной: от 90% уникальности в любом сервисе проверки уникальности.</p>';
		if ( get_field( 'services_user_services', 'user_' . get_current_user_id() )[0] == 84175 ) {
			$result .= '<div class="get_tariff">Вы выбрали продление тарифа <span class="user_label font_smaller pro_get_t">PRO</span> на <div class="incr_inputs"><span class="input-number-decrement">–</span><input class="input-number" type="text" value="1" min="1" max="100"><span class="input-number-increment">+</span></div><span class="month_take"> месяц<span class="sklon"></span></span></div>';
		} else {
			$result .= '<div class="get_tariff">Вы выбрали тариф <span class="user_label font_smaller pro_get_t">PRO</span> на <div class="incr_inputs"><span class="input-number-decrement">–</span><input class="input-number" type="text" value="1" min="1" max="100"><span class="input-number-increment">+</span></div><span class="month_take"> месяц<span class="sklon"></span></span></div>';
		}


		/*$result .= '<p style="font-size: 14px;margin-bottom: 20px;">Для того, чтобы опубликовать статью на наш сайт, сначала добавьте текст статьи в форму ниже или прикрепите ее в формате doc файла и отправьте на модерацию. Также оставьте в поле ниже свой актуальный контакт в мессенджере (WhatsApp, Skype, Telegram или Viber), после чего наш менеджер свяжется с вами.</p>';
		$result .= '	<input type="text" name="title_name" placeholder="Название статьи" class="input_big m_b_10 placeholder_dark border_radius_4px input_form" value=""><textarea name="text_blogpost" class="m_b_20 text_area_text" placeholder="Текст статьи"></textarea>';

		$result .= '<form class="fileUpload fileUploadM m_b_20" enctype="multipart/form-data">';
		$result .= '	<div class="form-group">';
		$result .= '		<span class="file_title">Прикрепить файлы</span>';
		$result .= '		<div class="step_4_add_comp">';
		$result .= '		<p>Отправьте файлы в следующих форматах: png, jpg, pdf, doc, docx, вес - до 2 МБ</p>';
		$result .= '	</div>';
		$result .= '		<div class="fileuploadcomp_wrapper">';
		$result .= '		<label>';
		$result .= '		<input type="file" id="fileuploadcomp" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
text/plain, application/pdf, image/*" multiple="">';
		$result .= '		</label>';
		$result .= '		</div>';
		$result .= '	</div>';
		$result .= '</form>';*/




/*		$result .= '	<div class="select_contact">';
		$result .= '		<span class="add_company_title">Контактное лицо</span>';
		$result .= '		<div class="select_contact_inside">';
		$result .= '			<select name="select_contact" class="select_big m_b_10 border_radius_4px select_arrow">';
		$result .= '				<option selected="selected">Мессенджер для связи</option>';
		$result .= '				<option value="telegram">Telegram</option>';
		$result .= '				<option value="skype">Skype</option>';
		$result .= '				<option value="whatsapp">WhatsApp</option>';
		$result .= '				<option value="viber">Viber</option>';
		$result .= '			</select>';
		$result .= '			<input type="text" name="contact_name" placeholder="Логин" class="input_big m_b_10 placeholder_dark border_radius_4px" value="">';
		$result .= '		</div>';
		$result .= '	</div>';*/
		if ( get_field( 'services_user_services', 'user_' . get_current_user_id() )[0] == 84175 ) {
			$result .= '	<div class="pro_account_buy button button_violet font_small font_bold pointer">Продлить PRO тариф</div>';
		} else {
			$result .= '	<div class="pro_account_buy button button_violet font_small font_bold pointer">Подключить PRO аккаунт</div>';
		}



		$result .= '<div class="get_tariff_main_text">
<p style="font-size: 14px;">Получите максимум пользы от нашего сайта, подключив PRO-аккаунт и активно пользуясь его возможностями. С PRO-аккаунтом у вас будет больше полезного функционала в личном кабинете, быстрее – связь с интересующими вас компаниями.</p> 
<p style="font-size: 14px;">Вы получите значок PRO, сможете разместить услуги в профиле и ссылки в ваших комментариях, получите приоритетную связь с компаниями.</p>
<p style="font-size: 14px;">Стоимость аккаунта: 400 руб./мес. Чтобы подключить аккаунт, нажмите на кнопку «Подключить PRO аккаунт», и вы будете направлены на страницу оплаты. Вы можете оплатить аккаунт сразу на несколько месяцев. Для этого воспользуйтесь удобным способом оплаты.</p>
<!--<p style="font-size: 14px;">Получите максимум пользы от нашего сайта, подключив PRO-аккаунт и активно пользуясь его возможностями. С PRO-аккаунтом у вас будет больше полезного функционала в личном кабинете, удобнее - работа с сайтом, быстрее – связь с интересующими вас компаниями. Теперь вы – на шаг впереди в отличие от пользователей бесплатных аккаунтов.</p> 

<p style="font-size: 14px;">Кроме личного кабинета с профилем, публикации отзывов, жалобы и комментариев, доступных на бесплатном аккаунте, вы получите значок PRO, сможете разместить услуги в профиле и ссылки в ваших комментариях, пользоваться персональными акциями и скидками по промокодам, получите приоритетную связь с компаниями и т.д.</p> 

<p style="font-size: 14px;">Стоимость аккаунта: 400 руб./мес. Чтобы подключить аккаунт, нажмите на кнопку «Подключить PRO аккаунт», вы будете направлены на страницу оплаты. Для удобства вы можете оплатить аккаунт сразу на несколько месяцев. Для этого воспользуйтесь удобным способом оплаты: банковской картой, платежными системами ЮMoney, Webmoney, QIWI Кошелек, СберБанк Онлайн/SberPay, при помощи баланса телефона и т.д.</p>-->
</div><!--<figure class="wp-block-table get_tariff_main_table"><table><tbody><tr><td>&nbsp;</td><td><strong>БЕСПЛАТНЫЙ АККАУНТ</strong></td><td><strong>PRO (400 РУБ/МЕС.)</strong></td></tr><tr><td>Профиль пользователя</td><td>+</td><td>+</td></tr><tr><td>Публикация отзывов и комментариев</td><td>+</td><td>+</td></tr><tr><td>Публикация жалоб</td><td>+</td><td>+</td></tr><tr><td>Значок PRO</td><td></td><td>+</td></tr><tr><td>Публикация контактов в профиле</td><td></td><td>+</td></tr><tr><td>Публикация услуг в профиле</td><td></td><td>+</td></tr><tr><td>Специальные акции и скидки по промокодам</td><td></td><td>+</td></tr><tr><td>Возможность приоритетной коммуникации с компанией</td><td></td><td>+</td></tr><tr><td>Профиль виден всем в Интернете</td><td></td><td>+</td></tr><tr><td>Разовое изменение логина и url-профиля</td><td></td><td>+</td></tr><tr><td>Возможность оставлять ссылки в комментариях</td><td></td><td>+</td></tr><tr><td>Включение в рейтинг экспертов по выбранной области</td><td></td><td>+</td></tr><tr><td>Наши обучающие материалы</td><td></td><td>+</td></tr></tbody></table></figure>--><div class="table_prices">
<div class="table_prices__col">
<div class="table_prices__header"><span class="table_prices__header_text"><br>Бесплатный<br></span><p></p>
</div>
<div class="table_prices__body">
<ul class="table_prices__ul">
<li>Профиль пользователя</li>
<li>Публикация отзывов и комментариев</li>
<li>Публикация жалоб</li>
<li class="table_prices__ul_none_color">Значок PRO</li>
<li class="table_prices__ul_none_color">Публикация контактов в профиле</li>
<li class="table_prices__ul_none_color">Публикация услуг в профиле</li>
<li class="table_prices__ul_none_color">Специальные акции и скидки по промокодам</li>
<li class="table_prices__ul_none_color">Возможность приоритетной коммуникации с компанией</li>
<li class="table_prices__ul_none_color">Профиль виден всем в Интернете</li>
<li class="table_prices__ul_none_color">Разовое изменение логина и url-профиля</li>
<li class="table_prices__ul_none_color">Возможность оставлять ссылки в комментариях</li>
<li class="table_prices__ul_none_color">Включение в рейтинг экспертов по выбранной области</li>
<li class="table_prices__ul_none_color">Наши обучающие материалы</li>
</ul>
<p><span class="table_price_number">'.do_shortcode('[price_language_1]').' | <span class="table_price_number_text">НАВСЕГДА</span></span><br></p>
</div>
</div>
<div class="table_prices__col bg_black_white_text">
<div class="table_prices__header"><span class="table_prices__header_text"><br>Premium<br></span><p></p>
</div>
<div class="table_prices__body">
<ul class="table_prices__ul">
<li>Профиль пользователя</li>
<li>Публикация отзывов и комментариев</li>
<li>Публикация жалоб</li>
<li>Значок PRO</li>
<li>Публикация контактов в профиле</li>
<li>Публикация услуг в профиле</li>
<li>Специальные акции и скидки по промокодам</li>
<li>Возможность приоритетной коммуникации с компанией</li>
<li>Профиль виден всем в Интернете</li>
<li>Разовое изменение логина и url-профиля</li>
<li>Возможность оставлять ссылки в комментариях</li>
<li>Включение в рейтинг экспертов по выбранной области</li>
<li>Наши обучающие материалы</li>
</ul>
<p><span class="table_price_number">'.do_shortcode('[price_language_2]').' | <span class="table_price_number_text">В МЕСЯЦ</span></span><br></p>
</div>
</div>
</div>';


		$result .= '</div>';





// args


		global $post;
		$posts_transactions = get_posts( [
			'posts_per_page' => 50,
			'post_type'      => 'tranzaktsii',
			'post_status'    => 'any',
			'meta_query'     => array(
				array(
					'key'     => 'id_user',
					'value'   => $user_id,
					'compare' => '==',
				)
			)
		] );
		if (count($posts_transactions) != 0) {
			$result .= '<div class="wallet_history white_block block_content border_radius_4px m_t_15 flex flex_column">
				<div class="wallet_history__header flex">
					<div class="rating_th rating_field_number sort pointer sort_default" data-rating-field="number">Услуга</div>
					<div class="rating_th rating_field_number sort pointer sort_default" data-rating-field="number">Статус</div>
					<div class="rating_th rating_field_number sort pointer sort_default" data-rating-field="number">Цена</div>
				</div>';
				$userid = wp_get_current_user();
				$user_email = $userid->user_email;
				$user_id_new = $userid->ID;
				foreach ( $posts_transactions as $key => $post ) {

					$get_the_ID = get_the_ID();

					$get_link_comp = get_field('connect_company', $get_the_ID);
					print_r ($get_link_comp);
					// $company_name = get_field();

					if (get_field('additional_info_mini',get_the_ID()) == 'Подключение тарифа') {
						if (get_field('type', get_the_ID() ) == 'add') {
							if (get_field('connect_company',get_the_ID())) {
								$buytariff =  'Верификация компании';
							} else {
								if (get_field('additional_info_mini',get_the_ID()) == 'Подключение тарифа') {
									$buytariff =  'Подключение PRO';
								} else {
									$buytariff =  'Пополнение баланса';
								}
							}


						} else {
							if ( get_field( 'additional_info', $get_the_ID ) ) {
								$buytariff = get_field( 'additional_info_mini', $get_the_ID );
							} else {
								$buytariff = 'Оплата услуги';
							}
						}
						$result .= '<div class="wallet_history__row flex  align-items-center" attr-id="'.get_field('connect_company',get_the_ID())[0].'">';
						$result .= '    <div class="wallet_history__row__title">';
						$result .= '        <span class="wallet_history__row__span__item font_bold">'.$buytariff.'</span>';
						$result .= '    <span class="company_name">'.$company_name.'</span>'; // Добавляем название компании
						$result .= '    </div>';
						$result .= '    <div class="wallet_history__row__status">';
						if (get_field('type', $get_the_ID ) == 'add') {
							if (get_field(    'add_options'.'_'.'status',    $get_the_ID    ) == 'yes') {
								$img_status = '<span class="wallet_img_status wallet_img_status_green"></span>';
								$name_paid = 'Оплачено';

							} else {
								$img_status = '<span class="wallet_img_status wallet_img_status_gray"></span>';
								$name_paid = 'Не оплачено';
							}
						} else  {
							$img_status = '<span class="wallet_img_status wallet_img_status_green"></span>';
							$name_paid = 'Оплачено';
						}
						$result .= '<div class="wallet_img_status_wrapper">'.$img_status.'<div class="wallet_img_status_text"><span class="wallet_img_status_paid">'.$name_paid.'</span><span class="wallet_img_status_date">'.get_the_date('j.n.Y').'</span></div></div>';
						$result .= '    </div>';
						$result .= '    <div class="wallet_history__row__amount">';
						if (get_field('type', $get_the_ID ) == 'spend') {
							$amount = get_field('add_options_spend'.'_'.'amount', $get_the_ID);
						} else {
							$amount = get_field('add_options'.'_'.'amount', $get_the_ID);
						}

						$result .= '        <span class="wallet_history__row__span__item">'.number_format($amount, 0, '.', ' ').' Р</span>';
						$result .= '    </div>';
						$result .= '    <div class="wallet_history__row flex align-items-center wallet_history_row_pay">';
						$id_transaction = get_field('add_options' . '_' . 'id_transaction', $get_the_ID);
						if (get_field('type', $get_the_ID ) == 'add') {
							if ( get_field( 'add_options' . '_' . 'status', $get_the_ID ) == 'yes' ) {

							} else {
								$result .= '<span class="wallet_history__row__icon_card wallet_history__row__icon" data-amount="'.$amount.'"  data-email="'.$user_email.'" data-userid="'.$user_id_new.'" data-trans_id="'.$id_transaction.'"  data-id="'.$get_the_ID.'" data-method="bank_card"></span>';
							}
						}
						if ($get_the_ID == get_field('services_user_add_transaction_id_transaction','user_'.$user_id)[0]) {
							$services_user_add_transaction_date_before_end = explode(' ',get_field('services_user_add_transaction_date_before_end','user_'.$user_id));
							$services_user_add_transaction_date_before_end = $services_user_add_transaction_date_before_end[0];
							$services_user_add_transaction_date_before_end =  str_replace("/", ".", $services_user_add_transaction_date_before_end);
							$result .= '<span class="wallet_img_status_date">до '.$services_user_add_transaction_date_before_end.'</span>';
						}
						$result .= '    </div>';
						$result .= '</div>';
                    }

				}
				$result .= '</div>';
		}






		$result .= '</div>';
		$result .= '</div>';
		$result .= '            <div class="profile-wrapper__right_sub">'.add_company($user_id).act_services($user_id).act_services_banner($user_id).fast_links_profile( $user_id ,'noborder',[['/dashboard/services/pro/','Включить аккаунт PRO'],['/advices/','Полезные советы'],['/user-edit/','Как заполнить аккаунт'],['/user-help/','Помощь']]).menu_footer_links(true).'</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}



add_action( 'wp_ajax_send_blog_post', 'send_blog_post_callback' );
add_action( 'wp_ajax_nopriv_send_blog_post', 'send_blog_post_callback' );
function send_blog_post_callback() {


	$text_blogpost = htmlspecialchars($_POST['text_blogpost']);
	$contact_type = htmlspecialchars($_POST['contact_type']);
	$login_type = htmlspecialchars($_POST['login_type']);
	$title_name = htmlspecialchars($_POST['title_name']);

	$poster_id = wp_insert_post( wp_slash( array(
		'post_status'   => 'publish',
		'post_type'  => 'userblogpost',
		'post_title' => $title_name,
	) ) );



	$current_user = wp_get_current_user();
	$user_id = $current_user->data->ID;


	update_field( 'text', $text_blogpost, $poster_id );
	update_field( 'contact_type', $contact_type, $poster_id );
	update_field( 'messanger_login', $login_type, $poster_id );
	update_field( 'user_id', $user_id, $poster_id );

	$image_views = htmlspecialchars($_POST['image_views']);
	$image_views_array = explode(",", $image_views);
	foreach ($image_views_array  as $item ) {
		$args = array('image_set' => intval($item));
		add_row('image_array', $args, $poster_id);
	}


	$arr = ['status' => 'ok'];

	echo json_encode($arr);
	die;
}

add_action( 'save_post', 'balance_spender', 10,3 );

function balance_spender( $post_id, $post, $update ) {
	date_default_timezone_set( 'Europe/Moscow' );
	if ( 'tranzaktsii' !== $post->post_type ) {
		return;
	}

	if ( get_post_status( $post_id ) == 'publish' )   {
		if (get_field('add_options_spend_type_spend') == 'hand') {
			if (get_user_meta( get_field('id_user', $post_id), 'spend_hand_balance', true ) == '') {
				$usermetaarray = [];
			} else {
				$usermetaarray = get_user_meta( get_field('id_user', $post_id), 'spend_hand_balance', true );
			}

			$usermetaarray_temp = $usermetaarray;

			if (in_array($post_id, $usermetaarray)) {

			} else {
				$oldbalance = get_field('balance','user_'.get_field('id_user', $post_id));
				$newbalance = intval($oldbalance) - intval(get_field('add_options_spend'.'_'.'amount', $post_id));
				if (intval($newbalance) < 0) {
					$newbalance = 0;
				}
				update_field('balance',$newbalance,'user_'.get_field('id_user', $post_id));

				array_push($usermetaarray_temp, $post_id);
				update_user_meta( get_field('id_user', $post_id), 'spend_hand_balance', $usermetaarray_temp );

				update_field('add_options_spend'.'_'.'data', date('F j, Y'), $post_id);
				update_field('data_time', date('Y-m-d H:i:s'), $post_id);
				update_field('add_options_spend'.'_'.'status_spend','Баланс был успешно списан '.date('d.m.Y H:i:s'));
				//wp_mail('dikobraz@ya.ru', 'Какая-то тема '.$post_id, 'Какое-то сообщение');

				remove_action( 'save_post', 'balance_spender' );
				wp_update_post( array( 'ID' => $post_id, 'post_title' => 'Списание баланса '.date('d.m.Y H:i:s'), ) );
				add_action( 'save_post', 'balance_spender' );
			}



		}


	}
}

add_action('admin_head', 'css_for_spend');

function css_for_spend() {
	echo '<style>
#status_spend {
    position: relative;
    background: #007cba;
    color: #FFF;
}

#status_spend:before {content: " ";width: 100%;height: 100%;position: absolute;background: transparent;left: 0;top: 0;z-index: 1;}

#status_spend {}

#status_spend textarea {
background: transparent;
    border: 0;
    color: #FFF;
    padding: 0;
    font-size: 20px;
    height: auto !important;
    display: block !important;
    height: unset !important;
    height: 130px !important;
}

tr#handspend .filters.-f3 {
    display: none;
}

tr#handspend .choices {
    display: none;
}

tr#handspend .values {
    background: transparent;
    width: unset !important;
    width: 100% !important;
}

tr#handspend .acf-relationship {
    height: unset !important;
}

tr#handspend .acf-relationship .list {
    height: unset;
    width: 100% !important;
}

tr#handspend .acf-relationship {
    position: relative;
}

tr#handspend .acf-relationship:before {content: " ";width: 100%;height: 100%;background: transparent;position: absolute;z-index: 1;}

tr#hiddenfield, .hiddenfield {
    display: none;
}
div#date_before_end_admin {
    padding: 0;
    margin: 0;
    border: none !important;
}

td.acf-field.acf-field-group.acf-field-5fb40586652aa .acf-fields.-top.-border {
    border: none;
    height: unset !important;
    padding-top: 0 !important;
}


div#date_before_end_admin .acf-label {
    display: none !important;
}
th.acf-th[data-name="periodicity"] {
    display: none !important;
}

td#hiddenfield2 {
    display: none;
}
@font-face {
    font-family: "rublregular";
    src: url("/wp-content/themes/eto-razvod-1/fonts/rouble-webfont.eot");
    src: url("/wp-content/themes/eto-razvod-1/fonts/rouble-webfont.eot?#iefix") format("embedded-opentype"),
         url("/wp-content/themes/eto-razvod-1/fonts/rouble-webfont.woff2") format("woff2"),
         url("/wp-content/themes/eto-razvod-1/fonts/rouble-webfont.woff") format("woff"),
         url("/wp-content/themes/eto-razvod-1/fonts/rouble-webfont.ttf") format("truetype");
    font-weight: normal;
    font-style: normal;
}

.rur {
    font-family: "rublregular";
    font-weight: normal;
    font-size: 20px;
    color: #706f6f;
}
td.tariff_type.column-tariff_type {
    max-width: 55px !important;
    width: 55px !important;
}

th#tariff_type {
    max-width: 55px !important;
    width: 55px !important;
}
.user-activated {
    background: #0069ff;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    font-size: 18px;
    color: #FFF;
    line-height: 2;
}

.user-activated > .label-pro {
    background: #FFF;
    color: #0069ff;
    border-radius: 5px;
    padding: 0px 10px;
    line-height: 2;
}
</style>';
}




/*add_action( 'pre_get_posts', 'foo_modify_query_exclude_category' );
function foo_modify_query_exclude_category( $query ) {
	$language = get_locale();
	if ($language == 'ru_RU') {
			if ( ($query->is_main_query() || $query->is_front_page() || $query->is_page || $query->is_single || $query->is_singular || !$query->is_main_query()) && ! $query->get( 'post__not_in' )) {
				$query->set( 'post__not_in', [214147, 213380, 213673, 213655, 213711, 213700, 214122, 214122, 214536, 175678, 214562, 175678,214671, 214677, 214646, 214664, 214639, 214657, 215102, 215111, 214671, 215175, 215218, 215197, 215236, 215236,215250] );
			}
	}
	
}*/


add_action("init", function() {
	// First line of defence defused
	add_filter('upload_mimes', function ($mimes) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	});
	
	// Add the XML Declaration if it's missing (otherwise WordPress does not allow uploads)
	add_filter("wp_handle_upload_prefilter", function ($upload) {
		if (!empty($upload["type"]) && $upload["type"] === "image/svg+xml") {
			$contents = file_get_contents($upload["tmp_name"]);
			if (strpos($contents, "<?xml") === false) {
				file_put_contents($upload["tmp_name"], '<?xml version="1.0" encoding="UTF-8"?>' . $contents);
			}
		}
		return $upload;
	}, 10, 1);
});


if ( ! function_exists( 'truncateToWord2' ) ) {
	function truncateToWord2( $content, $length = 200, $continue_reading = '' ) {
		if ( mb_strlen( $content ) > $length ) {
			$spaceAtPos = strpos( $content, ' ', $length );
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


if(!function_exists('savesendingmails')) {
	add_action( 'wp_ajax_savesendingmails', 'savesendingmails' );
	add_action( 'wp_ajax_nopriv_savesendingmails', 'savesendingmails' );
	function savesendingmails() {
		$data = $_POST;
		$site = (int)$data['site'];
		$all = (int)$data['all'];
		$tematics = (int)$data['tematics'];
		$current_user = wp_get_current_user();
		$user_id      = $current_user->data->ID;
		
		$arr = [
			'site' => $site,
			'all' => $all,
			'tematics' => $tematics
		];
		$check_fild_from_site_send = update_field('from_site_send', $arr['site'], 'user_'.$user_id);
		update_field('all_send', $arr['all'], 'user_'.$user_id);
		update_field('tematics_send', $arr['tematics'], 'user_'.$user_id);
		$email = $current_user->user_email;
		$arr['email'] = $current_user->user_email;
		$arr['user_id'] = $user_id;
		$arr['check_fild_from_site_send'] = $check_fild_from_site_send;
		
		if ($arr['all'] == 1) {
			
			$api_key = 'e9c51614cdd55d1e810e44e5499d8d77';
			
			$add_names = '';
			if (!empty(wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'first_name', true ))))) {
				$add_names .= '&merge_1='.wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'first_name', true )));
			}
			
			if (!empty(wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'last_name', true ))))) {
				$add_names .= '&merge_2='.wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'last_name', true )));
			}
			
			$url = 'https://api.dashamail.ru/?method=lists.add_member&&api_key=e9c51614cdd55d1e810e44e5499d8d77&list_id=145821&email='.$email.$add_names.'&format=xml';
			
			$data = [];
			$post_data = json_encode($data);
			
			$options = array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $post_data,
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
					'Authorization: Bearer ' . $api_key,
				),
			);
			$curl = curl_init();
			curl_setopt_array($curl, $options);
			$response = curl_exec($curl);
			curl_close($curl);
			$arr['all_p'] = $response;
		} else {
			$api_key = 'e9c51614cdd55d1e810e44e5499d8d77';
			
			$url = 'https://api.dashamail.ru/?method=lists.get_members&api_key=e9c51614cdd55d1e810e44e5499d8d77&list_id=145821&email='.$email.'&format=xml';
			
			$data = [];
			$post_data = json_encode($data);
			
			$options = array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $post_data,
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
					'Authorization: Bearer ' . $api_key,
				),
			);
			$curl = curl_init();
			curl_setopt_array($curl, $options);
			$response = curl_exec($curl);
			curl_close($curl);
			$response_arr = (array) simplexml_load_string($response);
			$response_arr2 = (array) $response_arr['data'];
			$response_arr3 = (array) $response_arr2['row'][0]->id;
			$idtodelete = $response_arr3[0];
			
			if (!empty($idtodelete)) {
				$url = 'https://api.dashamail.ru/?method=lists.delete_member&api_key=e9c51614cdd55d1e810e44e5499d8d77&member_id=' . $idtodelete . '&format=xml';
				
				$data      = [];
				$post_data = json_encode( $data );
				
				$options = array(
					CURLOPT_URL            => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_CUSTOMREQUEST  => 'POST',
					CURLOPT_POSTFIELDS     => $post_data,
					CURLOPT_HTTPHEADER     => array(
						'Content-Type: application/json',
						'Authorization: Bearer ' . $api_key,
					),
				);
				$curl    = curl_init();
				curl_setopt_array( $curl, $options );
				$response = curl_exec( $curl );
				curl_close( $curl );
			}
			$arr['all_m'] = $response;
		}
		
		$user_skills = get_field( 'user_skills', 'user_' . $user_id );
		foreach ($user_skills  as $item ) {
			$term_id = $item;
			if (get_field('id_base_dashamail','term_'.$term_id)) {
				$id_base = intval(get_field('id_base_dashamail','term_'.$term_id));
				if ($arr['tematics'] == 1) {
					$id_base = intval(get_field( 'id_base_dashamail', 'term_' . $term_id ));
					$api_key = 'e9c51614cdd55d1e810e44e5499d8d77';
					$add_names = '';
					if (!empty(wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'first_name', true ))))) {
						$add_names .= '&merge_1='.wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'first_name', true )));
					}
					
					if (!empty(wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'last_name', true ))))) {
						$add_names .= '&merge_2='.wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'last_name', true )));
					}
					$url = 'https://api.dashamail.ru/?method=lists.add_member&&api_key=e9c51614cdd55d1e810e44e5499d8d77&list_id='.$id_base.'&email='.$email.$add_names.'&format=xml';
					
					$data = [];
					$post_data = json_encode($data);
					
					$options = array(
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS => $post_data,
						CURLOPT_HTTPHEADER => array(
							'Content-Type: application/json',
							'Authorization: Bearer ' . $api_key,
						),
					);
					$curl = curl_init();
					curl_setopt_array($curl, $options);
					$response = curl_exec($curl);
					curl_close($curl);
					$arr['tematics_p'.$item] = $response;
				} else {
					$api_key = 'e9c51614cdd55d1e810e44e5499d8d77';
					
					$url = 'https://api.dashamail.ru/?method=lists.get_members&api_key=e9c51614cdd55d1e810e44e5499d8d77&list_id='.$id_base.'&email='.$email.'&format=xml';
					
					$data = [];
					$post_data = json_encode($data);
					
					$options = array(
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS => $post_data,
						CURLOPT_HTTPHEADER => array(
							'Content-Type: application/json',
							'Authorization: Bearer ' . $api_key,
						),
					);
					$curl = curl_init();
					curl_setopt_array($curl, $options);
					$response = curl_exec($curl);
					curl_close($curl);
					$response_arr = (array) simplexml_load_string($response);
					$response_arr2 = (array) $response_arr['data'];
					$response_arr3 = (array) $response_arr2['row'][0]->id;
					$idtodelete = $response_arr3[0];
					
					if (!empty($idtodelete)) {
						$url = 'https://api.dashamail.ru/?method=lists.delete_member&api_key=e9c51614cdd55d1e810e44e5499d8d77&member_id='.$idtodelete.'&format=xml';
						
						$data = [];
						$post_data = json_encode($data);
						
						$options = array(
							CURLOPT_URL => $url,
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_CUSTOMREQUEST => 'POST',
							CURLOPT_POSTFIELDS => $post_data,
							CURLOPT_HTTPHEADER => array(
								'Content-Type: application/json',
								'Authorization: Bearer ' . $api_key,
							),
						);
						$curl = curl_init();
						curl_setopt_array($curl, $options);
						$response = curl_exec($curl);
						curl_close($curl);
					}
					
					$arr['tematics_m'.$item] = $response;
				}
			}
		}
		
		wp_send_json($arr);
		die();
	}
}


function savesendingmails_static($site = 1, $all = 1, $tematics = 1, $mail = 0) {
	
	$current_user = wp_get_current_user();
	$user_id      = $current_user->data->ID;
	
	$arr = [
		'site' => $site,
		'all' => $all,
		'tematics' => $tematics
	];
	update_field('from_site_send', $arr['site'], 'user_'.$user_id);
	update_field('all_send', $arr['all'], 'user_'.$user_id);
	update_field('tematics_send', $arr['tematics'], 'user_'.$user_id);
	if ($mail == 0) {
		$email = $current_user->user_email;
	} else {
		$email = $mail;
	}
	
	$arr['email'] = $email;
	$arr['user_id'] = $user_id;
	
	if ($arr['all'] == 1) {
		
		$api_key = 'e9c51614cdd55d1e810e44e5499d8d77';
		$add_names = '';
		if (!empty(wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'first_name', true ))))) {
			$add_names .= '&merge_1='.wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'first_name', true )));
		}
		
		if (!empty(wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'last_name', true ))))) {
			$add_names .= '&merge_2='.wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'last_name', true )));
		}
		$url = 'https://api.dashamail.ru/?method=lists.add_member&&api_key=e9c51614cdd55d1e810e44e5499d8d77&list_id=145821&email='.$email.$add_names.'&format=xml';
		
		$data = [];
		$post_data = json_encode($data);
		
		$options = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $post_data,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $api_key,
			),
		);
		$curl = curl_init();
		curl_setopt_array($curl, $options);
		$response = curl_exec($curl);
		curl_close($curl);
		$arr['all_p'] = $response;
	} else {
		$api_key = 'e9c51614cdd55d1e810e44e5499d8d77';
		
		$url = 'https://api.dashamail.ru/?method=lists.get_members&api_key=e9c51614cdd55d1e810e44e5499d8d77&list_id=145821&email='.$email.'&format=xml';
		
		$data = [];
		$post_data = json_encode($data);
		
		$options = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $post_data,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $api_key,
			),
		);
		$curl = curl_init();
		curl_setopt_array($curl, $options);
		$response = curl_exec($curl);
		curl_close($curl);
		$response_arr = (array) simplexml_load_string($response);
		$response_arr2 = (array) $response_arr['data'];
		$response_arr3 = (array) $response_arr2['row'][0]->id;
		$idtodelete = $response_arr3[0];
		
		if (!empty($idtodelete)) {
			$url = 'https://api.dashamail.ru/?method=lists.delete_member&api_key=e9c51614cdd55d1e810e44e5499d8d77&member_id=' . $idtodelete . '&format=xml';
			
			$data      = [];
			$post_data = json_encode( $data );
			
			$options = array(
				CURLOPT_URL            => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CUSTOMREQUEST  => 'POST',
				CURLOPT_POSTFIELDS     => $post_data,
				CURLOPT_HTTPHEADER     => array(
					'Content-Type: application/json',
					'Authorization: Bearer ' . $api_key,
				),
			);
			$curl    = curl_init();
			curl_setopt_array( $curl, $options );
			$response = curl_exec( $curl );
			curl_close( $curl );
		}
		$arr['all_m'] = $response;
	}
	
	$user_skills = get_field( 'user_skills', 'user_' . $user_id );
	foreach ($user_skills  as $item ) {
		$term_id = $item;
		if (get_field('id_base_dashamail','term_'.$term_id)) {
			$id_base = intval(get_field('id_base_dashamail','term_'.$term_id));
			if ($arr['tematics'] == 1) {
				$id_base = intval(get_field( 'id_base_dashamail', 'term_' . $term_id ));
				$api_key = 'e9c51614cdd55d1e810e44e5499d8d77';
				
				$add_names = '';
				if (!empty(wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'first_name', true ))))) {
					$add_names .= '&merge_1='.wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'first_name', true )));
				}
				
				if (!empty(wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'last_name', true ))))) {
					$add_names .= '&merge_2='.wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'last_name', true )));
				}
				
				$url = 'https://api.dashamail.ru/?method=lists.add_member&&api_key=e9c51614cdd55d1e810e44e5499d8d77&list_id='.$id_base.'&email='.$email.$add_names.'&format=xml';
				
				$data = [];
				$post_data = json_encode($data);
				
				$options = array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => $post_data,
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json',
						'Authorization: Bearer ' . $api_key,
					),
				);
				$curl = curl_init();
				curl_setopt_array($curl, $options);
				$response = curl_exec($curl);
				curl_close($curl);
				$arr['tematics_p'.$item] = $response;
			} else {
				$api_key = 'e9c51614cdd55d1e810e44e5499d8d77';
				
				$url = 'https://api.dashamail.ru/?method=lists.get_members&api_key=e9c51614cdd55d1e810e44e5499d8d77&list_id='.$id_base.'&email='.$email.'&format=xml';
				
				$data = [];
				$post_data = json_encode($data);
				
				$options = array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => $post_data,
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json',
						'Authorization: Bearer ' . $api_key,
					),
				);
				$curl = curl_init();
				curl_setopt_array($curl, $options);
				$response = curl_exec($curl);
				curl_close($curl);
				$response_arr = (array) simplexml_load_string($response);
				$response_arr2 = (array) $response_arr['data'];
				$response_arr3 = (array) $response_arr2['row'][0]->id;
				$idtodelete = $response_arr3[0];
				
				if (!empty($idtodelete)) {
					$url = 'https://api.dashamail.ru/?method=lists.delete_member&api_key=e9c51614cdd55d1e810e44e5499d8d77&member_id='.$idtodelete.'&format=xml';
					
					$data = [];
					$post_data = json_encode($data);
					
					$options = array(
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS => $post_data,
						CURLOPT_HTTPHEADER => array(
							'Content-Type: application/json',
							'Authorization: Bearer ' . $api_key,
						),
					);
					$curl = curl_init();
					curl_setopt_array($curl, $options);
					$response = curl_exec($curl);
					curl_close($curl);
				}
				
				$arr['tematics_m'.$item] = $response;
			}
		}
	}
}