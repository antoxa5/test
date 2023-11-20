<?php
include_once(TEMPLATEPATH . "/inc/addons/generate_widgets/generate_image_class.php");
if (!function_exists('company_dashboard')) {
	function company_dashboard($userid = NULL,$comp_id = NULL,$company_slug = NULL) {
		$result = print_css_links('user_page');
		$result .= print_js_links()['user_page'];
		$result .= print_css_links('review_content');
		$result .= '<div class="page_content page_container background_light review_container_about visible">';
		$result .= '    <div class="wrap justify-content-space-between wrap-no-padding-top company_dashboard_main">';

		$result .= '            <div class="profile-wrapper__left">';
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		$counters = profile_stats_count( $user_id );
		$result .= company_menu($current_user,$user_id,'dashboard',$comp_id,$company_slug);
		$result .= '			</div>';
		$result .= '<div class="middle_without_left"><div class="profile-wrapper__center">';
		$result .= '<div class="breadcrumbs_dashboard">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}

		$result .= '</div>';

		$result .= '<div class="profile_stats_wrap">';
		$result .= '';

		$result .= '<div class="profile_comments_stats white_block border_radius_4px">'.company_comments_stats($comp_id,'Отзывы',0,1).'</div>';
		$result .= '<div class="company_count_stats white_block border_radius_4px">'.company_count_stats( $comp_id).'</div>';
		$result .= '<div class="profile_abuse_stats white_block border_radius_4px">'.company_abuse_stats( $comp_id ).'</div>';
		$result .= '</div>';

		/*$result .= '    <div class="infoblock button_gray border_radius_4px">';
		$result .= '        <a href="#" class="infoblock__link color_dark_blue link_no_underline font_bold flex justify-content-space-between"><span class="infoblock__link_inside flex">';
		$result .= '            <span class="infoblock__icon"></span>';
		$result .= '            <span class="infoblock__text border_no_color">Подключите PRO аккаунт и получите больше инструментов для развития</span></span>';
		$result .= '<span class="button display_inline font_bold button_green pointer font_small link_no_underline">Подключить</span>';
		$result .= '        </a>';
		$result    .= '</div>';*/
		$result .= '<div class="middle_without_left_blocks_wrapper" id="middle_dashboard_company">';
		$result .= profile_create_view($user_id);
		$result .= company_subscribe_data_dashboard($comp_id,'dashboard');
		$result .= widget_company_in_ratings($comp_id,'profile_widget');
		$result .= '</div>';
		$result .= '<div class="middle_without_left_blocks_wrapper">';
		$result .= '<div class=""></div>';
		//$result .= widget_company_in_ratings($comp_id,'profile_widget');
		$result .= '</div>';

		//$result .= '<div class="comment_bar_info_wrapper">'.profile_comments($user_id,$counters,'dashboard').'</div>';
		//$result .= '<div class="profile-rate white_block border_radius_4px">'.profile_rate($user_id).'</div>';
		/*$result .= '<div class="profile_stats_wrap">';
		$result .= '<div class="profile_comments_stats white_block border_radius_4px">'.profile_comments_stats($user_id,'Мои отзывы',0,1).'</div>';
		$result .= '<div class="profile_abuse_stats white_block border_radius_4px">'.company_abuse_stats( $comp_id ).'</div>';
		$result .= '</div>';*/
		/*$get_users = get_users( [
			'meta_key'     => 'company_user',
			'meta_value'   => sprintf('"%s"', $comp_id),
			'meta_compare' => 'LIKE',
		] );*/
		//$result .= count($get_users);

		$result .= '</div>';
		//$result .= '            <div class="profile-wrapper__right"><div class="profile_abuse_stats_sidebar white_block border_radius_4px">'.company_abuse_stats( $comp_id ).'</div>'.company_subscribe_data_dashboard($comp_id,'dashboard').widget_company_in_ratings($comp_id).'</div></div>';
		//$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';

		$result .= print_css_links('profile_top');
		return $result;
	}
}


if (!function_exists('company_menu')) {
	function company_menu($current_user, $user_id, $type, $comp_id = NULL, $company_slug = NULL) {
		$user_display_name = get_field('company_name',$comp_id);
		$abuse_stats = abuse_stats($comp_id,'post');
		$profile_stats_menu_count = company_stats_menu_count($comp_id);
		$user_picture = get_field('company_logo', $comp_id );
		$user_label = get_field('services_user_services','user_'.$user_id)[0];
		$result = '<div class="user_bar user_bar_dashboard menu_bar_p user_bar_dashboard_company">';
		$profile_stats_menu_count_abuse = $profile_stats_menu_count['abuse_menu'];
		if ($profile_stats_menu_count_abuse == 0) {
			$profile_stats_menu_count_abuse = '';
		} else {
			$profile_stats_menu_count_abuse = '<span class="new-comments-profile__number font_bold border_circle_px">'.$profile_stats_menu_count_abuse.'</span>';
		}


		if ($profile_stats_menu_count['comments_menu'] == 0) {
			$profile_stats_menu_count = '';
		} else {
			$profile_stats_menu_count = '<span class="new-comments-profile__number font_bold border_circle_px">'.$profile_stats_menu_count['comments_menu'].'</span>';
		}


		if ($abuse_stats['onlynew'] == 0) {
			$abuse_stats_onlynew = '';
		} else {
			$abuse_stats_onlynew = '<span class="new-comments-profile__number font_bold border_circle_px">'.$abuse_stats['onlynew'].'</span>';
		}
		$result .= '<div class="user_picture border_circle"';

		$logo_bg = get_field('company_icon_bg',$comp_id);
		if($logo_bg && $logo_bg != '') {
			$bg = ' background-color:'.$logo_bg.';';
		} else {
			$bg = '';
		}
		if($user_picture && $user_picture != '') {
			$result .= ' style="background-image: url('.$user_picture["sizes"]["large"].');'.$bg.'" ';
		}
		$result .= '></div>';
		$result .= '<div class="user_name flex inactive_user_nav pointer flex_column">';
		$result .= '<div class="user-name_fist-line"><span class="display_name font_bold">'.$user_display_name.'</span>';
		/*if($user_label && $user_label != '') {
			$result .= '<span class="user_label font_smaller">'.get_the_title($user_label).'</span>';
		}*/
		$result .= '</div><div class="register_time_days_user_profile color_dark_gray font_smaller">'.str_replace('https://', "", get_field('websites',$comp_id)[0]['site_url']).'</div></div>';//str_replace($order, $replace, $str);
		$result .= '</div>';

		$result .= '<ul class="user-profile-nav">';
		$act = [];
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

		if ($type == 'ratings') {
			$act['ratings'] = ' user-profile-nav-item-active';
		}

		if ($type == 'messages') {
			$act['messages'] = ' user-profile-nav-item-active';
		}

		if ($type == 'companies') {
			$act['companies'] = ' user-profile-nav-item-active';
		}

		if ($type == 'adv') {
			$act['adv'] = ' user-profile-nav-item-active';
		}
		/*$result .= '<li class="user-profile-nav__item user_icon_home"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['dashboard'].'" href="/dashboard/company/'.$company_slug.'/">Главная</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_reviews"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['comments'].'" href="/dashboard/comments/company/'.$company_slug.'/">Отзывы</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_posts"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['reviews'].'" href="/dashboard/reviews/company/'.$company_slug.'/">Обзоры</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_abuses"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['abuses'].'" href="/dashboard/abuses/company/'.$company_slug.'/">Жалобы '.$profile_stats_menu_count_abuse.'</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_news"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act.'" href="/dashboard/news/">Новости</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_profile"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['user'].'" href="/user/company/'.$company_slug.'/">Профиль</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_services"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['services'].'" href="/dashboard/services/company/'.$company_slug.'/">Сервисы</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_subscribes"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['subscribes'].'" href="/dashboard/subscription/company/'.$company_slug.'/">Подписки</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_balance"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['wallet'].'" href="/dashboard/wallet/company/'.$company_slug.'/">Платежи</a></li>';*/


		$result .= '<li class="user-profile-nav__item user_icon_home"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['dashboard'].'" href="/dashboard/company/'.$company_slug.'/" rel="nofollow">Главная</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_reviews"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['comments'].'" href="/dashboard/comments/company/'.$company_slug.'/" rel="nofollow">Отзывы</a></li>';
		if ($user_id == 9) {
			$result .= '<li class="user-profile-nav__item user_icon_reviews"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['messages'].'" href="/dashboard/messages/company/'.$company_slug.'/" rel="nofollow">Сообщения';
			$new_msg = notify_check_new('messages',$comp_id);
			if($new_msg > 0) {
						$result .= '<span class="new-comments-profile__number font_bold border_circle_px" style="border-radius: 50%; padding: 0px; width: 19px;">'.$new_msg.'</span>';
					}
			$result .= '</a></li>';
		}
		$result .= '<li class="user-profile-nav__item user_icon_ratings"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['ratings'].'" href="/dashboard/ratings/company/'.$company_slug.'/" rel="nofollow">Рейтинг</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_abuses"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['abuses'].'" href="/dashboard/abuses/company/'.$company_slug.'/" rel="nofollow">Жалобы '.$abuse_stats_onlynew.'</a></li>';
		$result .= '<li class="user-profile-nav__item user_icon_news"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['news'].' " href="/dashboard/services/blog/" rel="nofollow">Публикация статьи</a><!--<span class="soon_dashboard">Скоро</span>--></li>';

		$num              = '';

		global $post;
		$promocodes_query = new WP_Query( array(
			'post_type'  => 'promocodes',
			'post_status'    => 'publish',
			'meta_query' => array(
				array(
					'key'     => 'promocode_review',
					'value'   => $comp_id,
					'compare' => '='
				)
			)

		) );
		while ( $promocodes_query->have_posts() ) {
			$promocodes_query->the_post();

			$num = get_the_ID();
		}
		wp_reset_query();
		if ($num == '') {
			$result .= '<li class="user-profile-nav__item user_icon_companies soon_btn"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['companies'].'" a_href="/dashboard/companies/company/'.$company_slug.'/" rel="nofollow">Акции</a></li>';
		} else {
			$result .= '<li class="user-profile-nav__item user_icon_companies"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['companies'].'" href="/dashboard/promo/company/'.$company_slug.'/" rel="nofollow">Акции</a></li>';
		}

		$result .= '<li class="user-profile-nav__item user_icon_audience soon_btn"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['audience'].'" a_href="/dashboard/audience/company/'.$company_slug.'/" rel="nofollow">Аудитория</a><span class="soon_dashboard">Скоро</span></li>';
		$result .= '<li class="user-profile-nav__item user_icon_adv"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['adv'].'" href="/dashboard/adv/company/'.$company_slug.'/" rel="nofollow">Реклама</a><!--<span class="soon_dashboard">Скоро</span></li>-->';


		$result .= '<li class="user-profile-nav__item user_icon_profile"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['profile'].'" href="/dashboard/profile/company/'.$company_slug.'/" rel="nofollow">Профиль</a></li>';
		/*if (($user_id == 31) || ($user_id == 17)) {
			$result .= '<li class="user-profile-nav__item user_icon_profile"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['profile'].'" href="/dashboard/profile/company/'.$company_slug.'/" rel="nofollow">Профиль</a></li>';
		} else {
			$result .= '<li class="user-profile-nav__item user_icon_profile soon_btn"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['profile'].'" a_href="/dashboard/profile/company/'.$company_slug.'/" rel="nofollow">Профиль</a><span class="soon_dashboard">Скоро</span></li>';
		}*/

		//$result .= '<li class="user-profile-nav__item user_icon_balance soon_btn"><a class="radius_small color_dark_blue font_bold font_uppercase font_small user-profile-nav-item-hover '.$act['wallet'].'" a_href="/dashboard/wallet/company/'.$company_slug.'/" rel="nofollow">Платежи</a><span class="soon_dashboard">Скоро</span></li>';

		$result .= '</ul>';
		$result .= '<div class="wrap-links-user-menu-footer">';
		$result .= '<a class="wrap-links-user-menu-footer__link font_smaller color_dark_gray link_no_underline after-dot" href="/privacy-policy/"><span class="border_no_color">Конфиденциальность</span></a>';
		$result .= '<a class="wrap-links-user-menu-footer__link font_smaller color_dark_gray link_no_underline after-dot" href="/legal/"><span class="border_no_color">Юр. информация</span></a>';

		$result .= '<a class="wrap-links-user-menu-footer__link font_smaller color_dark_gray link_no_underline after-dot" href="/rules/"><span class="border_no_color">Правила и условия</span></a>';
		$result .= '<a class="wrap-links-user-menu-footer__link font_smaller color_dark_gray link_no_underline after-dot" href="/terms-of-use/"><span class="border_no_color">Соглашение</span></a>';
		$result .= '<a class="wrap-links-user-menu-footer__link font_smaller color_dark_gray link_no_underline" href="/offer/"><span class="border_no_color">Оферта</span></a>';

		$result .= '<div class="wrap-links-user-menu-footer__cr font_small color_dark_gray">' . __( 'Это развод™', 'er_theme' ) . ' &copy; ' . date( 'Y' ) . '</div>';
		$result .= '</div>';
		return $result;

	}
}

if (!function_exists('company_comments_stats')) {
	function company_comments_stats( $comp_id,$title, $center,$settings ) {
		$result = '';

		$args_reviews = [
			'post_id' => $comp_id,
			'status' => 'approve',
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

		$result .= number_stat_company($comp_id,$title,$review_count,$center,$settings);
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
		$line_rate__green = $positive / $comment_rate_count * 100;
		$line_rate__red = $negative / $comment_rate_count * 100;

		$value_good = get_field('reviews_count_good_percent',$comp_id);
		if(!$value_good || $value_good == '') {
			$value_good = 0;
		}
		$value_bad = get_field('reviews_count_bad_percent',$comp_id);
		if(!$value_bad || $value_bad == '') {
			$value_bad = 0;
		}


		if (($value_good != 0) || ($value_bad !=0)) {
			$result .= '<div class="line-rate"><span class="line-rate__green" style="max-width: '.$value_good.'%;width: 100%;"></span><span class="line-rate__red"  style="max-width: '.$value_bad.'%;width: 100%;"></span></div>';
		}

		if (($value_good != 0)) {
			$positive_text = '<img src="/wp-content/themes/eto-razvod-1/img/thumbs-up.svg" alt=""> '.round($value_good).'%';
		} else {
			$positive_text = '';
		}

		if (($value_bad != 0)) {
			$negative_text = round($value_bad).'% <img src="/wp-content/themes/eto-razvod-1/img/thumbs-down.svg" alt="">';
		} else {
			$negative_text = '';
		}

		if (($value_good != 0) && ($value_bad != 0)) {
			$result .= '<div class="number-rate"><span class="number-rate__green font_smaller">'.$positive_text.'</span><span class="number-rate__red font_smaller ">'.$negative_text.'</span></div>';
		}
		return $result;
	}
}

if (!function_exists('company_abuse_stats')) {
	function company_abuse_stats( $comp_id ) {
		$result = '';
		$args_abuse = [
			'status'     => 'approve',
			'post_id'    => $comp_id,
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
		$result .= number_stat_company($comp_id,'Жалобы',$abuse_count, 0, 0);
		$count_abuses = company_stats_count_abuses($comp_id);
		$abuse_solved_count = $count_abuses['abuse_solved_count'];
		$abuse_new_count = $count_abuses['abuse_new_count'];
		$abuse_new_all_count = $count_abuses['abuse_new_all_count'];

		$result .= '<div class="new-comments-profile_wrapper flex">';
		$result .= '<div class="new-comments-profile flex justify-content-space-between">	<a href="#" class="new-comments-profile__link link_gray font_small link_no_underline font_underline">Новые</a>	<span class="new-comments-profile__number font_bold border_circle_px">'.$abuse_new_all_count.'</span></div>';
		$result .= '<div class="new-comments-profile flex justify-content-space-between">	<a href="#" class="new-comments-profile__link link_gray font_small link_no_underline font_underline">Архив</a>	<span class="new-comments-profile__number button_gray font_bold border_circle_px">'.$abuse_solved_count.'</span></div>';
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('number_stat_company')) {
	function number_stat_company( $comp_id,$title,$number,$center,$settings ) {
		$result = '<div class="number-stat-profile">';
		if ($center == 0) {
			$result .= '	<span class="number-stat-profile__title">'.$title.'</span>';
			$result .= '	<span class="number-stat-profile__number font_bolder font_big_medium">'.$number.'</span>';
		} elseif ($center == 1) {
			$result .= '	<span class="number-stat-profile__title text_centered text-block">'.$title.'</span>';
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


if (!function_exists('company_stats_count_abuses')) {
	function company_stats_count_abuses( $comp_id ) {
		$args_abuse = [
			'status'     => 'approve',
			'post_id'    => $comp_id,
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				]
			]
		];
		$args_abuse_solved = [
			'status'     => 'approve',
			'post_id'    => $comp_id,
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				],
				[
					'key'	 	=> 'abuse_state',
					'value'	  	=> 'solved',
					'compare' 	=> '=',
				]
			]
		];
		$args_abuse_new = [
			'status'     => 'approve',
			'post_id'    => $comp_id,
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				],
				[
					'key'	 	=> 'abuse_state',
					'compare' => 'NOT EXISTS',
					'value' => ''
				]
			]
		];

		$args_abuse_new_all = [
			'status'     => 'approve',
			'post_id'    => $comp_id,
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				],
				[
					'key'	 	=> 'abuse_state',
					'value'	  	=> 'not_seen',
					'compare' 	=> '=',
				]
			]
		];

		$abuse_count   = count( get_comments( $args_abuse ) );
		$abuse_solved_count   = count( get_comments( $args_abuse_solved ) );
		$abuse_new_count = count( get_comments( $args_abuse_new ) );
		$abuse_new_all_count = count( get_comments( $args_abuse_new_all ) );

		return ['abuse_count' => $abuse_count,'abuse_solved_count' => $abuse_solved_count, 'abuse_new_count' => $abuse_new_count, 'abuse_new_all_count' => $abuse_new_all_count];
	}
}

if(!function_exists('company_subscribe_data_dashboard')) {

	function company_subscribe_data_dashboard($comp_id,$type) {
		$get_users = get_users( [
			'meta_key'     => 'user_subscriptions_posts',
			'meta_value'   => sprintf('"%s"', $comp_id),
			'meta_compare' => 'LIKE',
		] );

		if ($type == "dashboard") {
			$result = '<div class="side_block white_block subscribe_widget subscribe_widget_user_profile subscribe_widget_user_dashboard border_radius_4px">';
		} else {
			$result = '<div class="side_block white_block subscribe_widget subscribe_widget_user_profile">';
		}

		$result .= '<div class="block_content flex flex_column">';
		$result .= '<div class="flex input_columns align_items_center">';
		$result .= '<span class="font_underline font_bold font_small pointer subscribe_link active">Подписчики</span>';

		$result .= '<span class="alertsimg" id="subcribe_user"></span>';
		$result .= '</div>';

		//$subscribe_companies_array =  get_field('user_subscriptions_posts','user_'.$comp_id);
		$result .= '<ul class="companies_subscribed">';
		$i = 0;
		foreach ($get_users  as $item ) {
			$i = ++$i;
			$review_logo_temp = profile_logo($item->data->ID);
			$review_logo_temp = str_replace("div", "li", $review_logo_temp);
			$review_logo_temp = str_replace("profile_logo", "review_logo", $review_logo_temp);
			$result .= $review_logo_temp;
			if ($i > 5) {
				break;
			}
		}
		/*foreach ( $subscribe_companies_array as $item ) {
			$review_logo_temp = review_logo($item);
			$review_logo_temp = str_replace("div", "li", $review_logo_temp);
			$result .= $review_logo_temp;
		}*/
		$result .= '</ul>';
		$result .= '<span class="font_small">';
		/*if (is_array($subscribe_companies_array) == false) {
			$subscribe_companies_array_count = 0;
		} else {
			$subscribe_companies_array_count = count($subscribe_companies_array);
		}*/
		$get_users_count = count($get_users);
		if ($type == "dashboard") {
			$result .= 'На вас '.counted_text( $get_users_count, __( 'подписан', 'er_theme' ), __( 'подписаны', 'er_theme' ), __( 'подписано', 'er_theme' ) ).' ' . $get_users_count . ' ' . counted_text( $get_users_count, __( 'человек', 'er_theme' ), __( 'человека', 'er_theme' ), __( 'человек', 'er_theme' ) );
		} else {

		}
		$result .= '</span>';
		$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('company_dashboard_comments')) {
	function company_dashboard_comments($userid = NULL,$comp_id = NULL,$company_slug = NULL) {
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		$result = print_css_links('user_page');
		$result .= print_js_links()['user_page'];
		$result .= print_js_links()['show_block'];
		$result .= print_css_links('show_block');
		$result .= print_js_links()['comments_loader_dashboard'];
		$result .= print_js_links()['popup_inside_dashboard'];
		$result .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result .= '<div class="page_content page_container background_light review_container_about visible">';
		$result .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result .= '        <div class="profile-wrapper">';
		$result .= '            <div class="profile-wrapper__left">';

		$result .= company_menu($current_user,$user_id,'comments',$comp_id,$company_slug);
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub">';
		$result .= '<div class="breadcrumbs_dashboard">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= review_container_comments_company();
		$result .= '</div>';
//		$result .= '            <div class="profile-wrapper__right_sub"><div class="side_block white_block block_content border_radius_4px comments_sidebar_company">'.comments_sidebar_company( $comp_id ).'</div>'.take_pro_sidebar_company().fast_links_profile( $user_id ,'noborder',[['/dashboard/services/pro/','Включить аккаунт PRO'],['#','Полезные советы'],['#','Как заполнить аккаунт'],['#','Помощь']]).'</div>';
		$result .= '            <div class="profile-wrapper__right_sub"><div class="side_block white_block block_content border_radius_4px comments_sidebar_company">'.comments_sidebar_company( $comp_id ).'</div>'.take_pro_sidebar_company().fast_links_profile( $user_id ,'noborder',[['/company-help/','Помощь']]).'</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}
if (!function_exists('take_pro_sidebar_company')) {
	function take_pro_sidebar_company() {
		$result = '<div class="side_block white_block block_content border_radius_4px take_pro_sidebar_company"><span class="font_small white-space-nowrap mb20 display-block">PRO всего за 400 Р в месяц</span> <div class="link_review_popup button button_comments button_green pointer font_small font_bold">Подключить PRO</div></div>';
		$result = '';
		return $result;
	}
}
if (!function_exists('review_container_comments_company')) {
	function review_container_comments_company() {
		$result = '<ul id="reviews" class="review-user-profile"></ul>';
		$result .= wp_enqueue_script( 'ajax-comments', get_template_directory_uri() . '/js/ajax-comments.js', array('jquery'), filemtime(TEMPLATEPATH . '/js/ajax-comments.js') );
		return $result;
	}
}

if (!function_exists('company_dashboard_abuses')) {
	function company_dashboard_abuses($userid = NULL,$comp_id = NULL,$company_slug = NULL) {
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;

		$result = print_css_links('user_page');
		$result .= print_js_links()['user_page'];
		$result .= print_js_links()['show_block'];
		$result .= print_css_links('show_block');
		$result .= print_css_links('popup_inside_dashboard');
		$result .= print_js_links()['abuses_loader_dashboard'];
		$result .= print_js_links()['popup_inside_dashboard'];
		$result .= wp_enqueue_script( 'ajax-comments', get_template_directory_uri() . '/js/ajax-comments.js', array('jquery'), filemtime(TEMPLATEPATH . '/js/ajax-comments.js') );
		$result .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css', [], filemtime(TEMPLATEPATH . '/css/comments.css') );
		$result .= '<div class="page_content page_container background_light review_container_about visible">';
		$result .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result .= '        <div class="profile-wrapper">';
		$result .= '            <div class="profile-wrapper__left">';

		$result .= company_menu($current_user,$user_id,'abuses',$comp_id,$company_slug);
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub">';
		$result .= '<div class="breadcrumbs_dashboard">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= review_container_abuses_profile();
		//$result .= popup_inside_dashboard($user_id,$comp_id,$company_slug);
		$result .= '</div>';
//		$result .= '            <div class="profile-wrapper__right_sub"><div class="side_block white_block border_radius_4px"><div class="block_content side_block_column">'.company_abuse_stats( $comp_id ).'</div></div>'.take_pro_sidebar_company().fast_links_profile( $user_id ,'noborder',[['/dashboard/services/pro/','Включить аккаунт PRO'],['#','Полезные советы'],['#','Как заполнить аккаунт'],['#','Помощь']]).'</div>';
		$result .= '            <div class="profile-wrapper__right_sub"><div class="side_block white_block border_radius_4px"><div class="block_content side_block_column">'.company_abuse_stats( $comp_id ).'</div></div>'.take_pro_sidebar_company().fast_links_profile( $user_id ,'noborder',[['/company-help/','Помощь']]).'</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}

if (!function_exists('popup_inside_dashboard')) {
	function popup_inside_dashboard( $userid = null, $comp_id = null, $company_slug = null ) {
		$result = '';
		$result .= '<div class="popup_inside_dashboard__wrapper">';
		$result .= '<div class="popup_inside_dashboard border_radius_4px">';
		$result .= '<span class="popup_inside_dashboard__title">Для доступа к этой странице <br>вам нужен уровень <span class="font_bold">PRO</span></span>';
		$result .= '<div class="link_review_popup button button_comments button_green pointer font_small font_bold">Подключить PRO</div>';
		$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}

if ( ! function_exists( 'company_count_stats' ) ) {
	function company_count_stats( $comp_id ) {
		$result        = '';
		$title         = 'Рейтинг';
		$system_rating = get_field( 'reviews_rating_average', $comp_id );
		if ( ! $system_rating || $system_rating == '' ) {
			$system_rating = 0;
		}
		$data_percent = 100 / 5 * $system_rating / 100;

		wp_enqueue_script( 'progressbar', get_template_directory_uri() . '/js/progressbar.js', array('jquery'), filemtime(TEMPLATEPATH . '/js/progressbar.js') );

		$get_rating_fields_group = get_rating_fields_group($comp_id);
		$get_post_rating = get_post_rating($get_rating_fields_group,'value',$comp_id);

		$result       .= number_stat_company( $comp_id, $title, $get_post_rating, 0, 1 );
		$result       .= '<span class="gradients_wrapper">
<span class="gradients_wrapper_line_1"></span>
<span class="gradients_wrapper_line_2"></span>
<span class="gradients_wrapper_line_3"></span>
</span>';

		return $result;
	}
}

if ( ! function_exists( 'comments_sidebar_company' ) ) {
	function comments_sidebar_company( $comp_id ,$type = '') {
		wp_enqueue_script( 'progressbar', get_template_directory_uri() . '/js/progressbar.js', array('jquery'), filemtime(TEMPLATEPATH . '/js/progressbar.js')  );
		$current_language = get_locale();
        if($type == 'single_review_page') {
            $company_title = get_field('company_name',$comp_id);
            if($current_language == 'ru_RU') {
                $statistika_po_otzyvam = 'Статистика по отзывам о компании';
            } elseif($current_language == 'fr_FR') {
                $statistika_po_otzyvam = 'Statistique de critiques sur';
            } else {
                $statistika_po_otzyvam = 'Company review statistics for';
            }
            $result        = '<span class="number-stat-profile__title text_centered text-block">'.$statistika_po_otzyvam;
            if($company_title && $company_title != '') {
                $result .= ' '.$company_title;
            }
            $result .= '</span>';
        } else {
            $result        = '<span class="number-stat-profile__title text_centered text-block">'.__('Отзывы','er_theme').'</span>';
        }

		$get_rating_fields_group = get_rating_fields_group($comp_id);
		$get_post_rating = get_post_rating($get_rating_fields_group,'layout_sidebar',$comp_id);
		$result .= $get_post_rating;
		return $result;
	}
}

if (!function_exists('company_dashboard_ratings')) {
	function company_dashboard_ratings($userid = NULL,$comp_id = NULL,$company_slug = NULL) {
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;

		$result = print_css_links('user_page');
		$result .= print_js_links()['user_page'];
		$result .= print_js_links()['show_block'];
		$result .= print_css_links('show_block');
		$result .= print_css_links('popup_inside_dashboard');
		//$result .= print_js_links()['abuses_loader_dashboard'];
		$result .= print_js_links()['popup_inside_dashboard'];
		$result .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result .= '<div class="page_content page_container background_light review_container_about visible">';
		$result .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result .= '        <div class="profile-wrapper">';
		$result .= '            <div class="profile-wrapper__left">';

		$result .= company_menu($current_user,$user_id,'ratings',$comp_id,$company_slug);
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub">';
		$result .= '<div class="breadcrumbs_dashboard">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= company_rating_content($userid,$comp_id,$company_slug);
		$result .= '</div>';
		//take_pro_sidebar_company().
//		$result .= '            <div class="profile-wrapper__right_sub"><span class="button font_bold button_violet pointer link_no_underline button_nopadding create_review side_block">Добавить в рейтинг</span>'.fast_links_profile( $user_id ,'noborder',[['#','Полезные советы'],['#','Как заполнить аккаунт'],['#','Помощь']]).'</div>';
		$result .= '            <div class="profile-wrapper__right_sub">'.fast_links_profile( $user_id ,'noborder',[['/company-help/','Помощь']]).'</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}

if (!function_exists('company_rating_content')) {
	function company_rating_content($userid = NULL,$comp_id = NULL,$company_slug = NULL) {
		wp_enqueue_script( 'progressbar', get_template_directory_uri() . '/js/progressbar.js', array('jquery'), filemtime(TEMPLATEPATH . '/js/progressbar.js')  );
		wp_enqueue_script( 'review_top', get_template_directory_uri() . '/js/review_top.js', array('jquery'), filemtime(TEMPLATEPATH . '/js/review_top.js') );
		$result = print_css_links('review_content');
		$result .= '<div class="company_rating_content_first-line__wrapper">';
		$result .= '<div class="company_rating_content_first-line border_radius_4px white_block">';
		$result .= review_logo($comp_id);
		if(function_exists('get_rating_fields_group')) {
			$rating_fields_group = get_rating_fields_group($comp_id);
		} else {
			$rating_fields_group = 0;
		}
		$result .= '<div class="stars_and_reviews flex">';
		//$result .=  get_post_stars($rating_fields_group);
		//$result .= get_post_rating($group_id,'value');
		$percents = get_post_rating($rating_fields_group,'stars',$comp_id);
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
		$result .= '<div class="stars_and_reviews_counts flex flex_column m_l_15 font_small line_big">';
		$reviews_count = get_field('reviews_count_reviews',$comp_id);
		if(!$reviews_count || $reviews_count == '') {
			$reviews_count = 0;
		}
		if($reviews_count) {
			$result .= '<div class="reviews_count_reviews"><span class="color_dark_gray">'.__('Всего отзывов','er_theme').'</span> <span class="color_dark_blue link_dashed">'.$reviews_count.'</span></div>';
		} else {
			$result .= '<div class="reviews_count_reviews"><span class="color_dark_gray">'.__('Еще нет отзывов','er_theme').'</span></div>';
		}
		$abuses_count = get_field('reviews_count_abuses',$comp_id);
		if(!$abuses_count || $abuses_count == '') {
			$abuses_count = 0;
		}
		if($abuses_count) {
			$result .= '<div class="reviews_count_reviews"><span class="color_dark_blue link_dashed">'.$abuses_count.' '.counted_text($abuses_count,__('жалоба','er_theme'),__('жалобы','er_theme'),__('жалоб','er_theme')).'</span></div>';
		} else {
			$result .= '<div class="reviews_count_abuses"><span class="color_dark_blue link_dashed">'.__('Еще нет жалоб','er_theme').'</span></div>';
		}
		$result .= '</div>';
		$result .= '</div>';
		$result .= '<div class="review_top_rating_container flex flex_column">'.review_top_rating($comp_id,false).'</div>';
		$result .= '</div>';
		$result .= widget_company_in_ratings($comp_id,'rate_page_dashboard');
		$result .= '</div>';
		return $result;
	}
}


if (!function_exists('company_dashboard_adv')) {
	function company_dashboard_adv($userid = NULL,$comp_id = NULL,$company_slug = NULL) {
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;

		$result = print_css_links('user_page');
		$result .= print_js_links()['user_page'];
		$result .= print_js_links()['show_block'];
		$result .= print_css_links('show_block');
		$result .= print_css_links('popup_inside_dashboard');
		//$result .= print_js_links()['abuses_loader_dashboard'];
		$result .= print_js_links()['popup_inside_dashboard'];
		$result .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result .= '<div class="page_content page_container background_light adv_container_about visible">';
		$result .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result .= '        <div class="profile-wrapper">';
		$result .= '            <div class="profile-wrapper__left">';

		$result .= company_menu($current_user,$user_id,'adv',$comp_id,$company_slug);
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub">';
		$result .= '<div class="breadcrumbs_dashboard">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= company_adv_content($userid,$comp_id,$company_slug);
		$result .= '</div>';
		//take_pro_sidebar_company().
//		$result .= '            <div class="profile-wrapper__right_sub"><span class="button font_bold button_violet pointer link_no_underline button_nopadding create_review side_block">Добавить в рейтинг</span>'.fast_links_profile( $user_id ,'noborder',[['#','Полезные советы'],['#','Как заполнить аккаунт'],['#','Помощь']]).'</div>';
		$result .= '            <div class="profile-wrapper__right_sub">'.fast_links_profile( $user_id ,'noborder',[['/company-help/','Помощь']]).'</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}

if (!function_exists('company_adv_content')) {
	function company_adv_content($userid = NULL,$comp_id = NULL,$company_slug = NULL) {
		wp_enqueue_script( 'progressbar', get_template_directory_uri() . '/js/progressbar.js', array('jquery'), filemtime(TEMPLATEPATH . '/js/progressbar.js')  );
		
		$result = print_css_links('adv');
		$result .= '<div class="company_adv_content_first-line__wrapper">';
                $result .= '<div class="company_adv_content_first-line border_radius_4px white_block">';
                $result .= '<h2>Реклама</h2>';
                $result .= '<p>Уважаемые представители компаний! Предлагаем вам разместить у себя на сайте  виджет с вашим рейтингом и количеством отзывов в карточке компании на нашем сайте. Это даст вам возможность выстроить более доверительные отношения с вашими клиентами, которые смогут удостовериться в вашем высоком рейтинге и положительных отзывах, основанных на клиентском опыте.</p>';
                $result .= '<p>В качестве вознаграждения за размещение виджета, мы готовы вам предложить скидки на наши рекламные услуги или персональные условия размещения на нашем сайте. Более подробную информацию можно узнать у нашего специалиста по работе с партнерами Екатерины:</p>';
                $result .= '<p>в телеграме <a href="https://t.me/katesmile" terget="_blank">https://t.me/katesmile</a></p>';
                $result .= '<p>по почте <a href="mailto:pr@eto-razvod.ru" terget="_blank">pr@eto-razvod.ru</a> (с пометкой “Виджет”)</p>';
                $result .= '<div class="worning_block">';
                $result .= get_reting_casino_dashboard($comp_id);
//                $result .= get_reting_casino_not_padding();
                $result .= '</div>';
                
                $check_init_widget_small = get_post_meta($comp_id, 'company_widget_small_init', true);
                $casinoClass = new GenerateImageClass($comp_id);
//                $casinoClass->rating = get_field('reviews_rating_average', $comp_id);
                $reviewsCount = get_field('reviews_count_reviews', $comp_id);
                $count_rewiews_company = $casinoClass->countedText($reviewsCount, __(' отзыв', 'er_theme'), __(' отзыва', 'er_theme'), __(' отзывов', 'er_theme'));
                $post_company_title = get_the_title( $comp_id );
                
                if($check_init_widget_small == 1) {
                    $power_ = 'checked';
//                    $inner_text_widget_small = '<h3>Скопируйте и вставьте код виджета на свой сайт:</h3><div class="div_widget_small_for_company">&lt;div class=my-widget_small"&gt;&lt;img id="etorazvod-widget_image" name="'.$company_slug.'" src="https://' . $_SERVER['SERVER_NAME'] . '/icompany/' . $comp_id . '.png" style="width: 100%;" alt="'.$post_company_title.' - '.$reviewsCount.$count_rewiews_company.'"&gt;'
//                    . '&lt;script src="https://beta2.eto-razvod.ru/gen_widgets.js"&gt;'
//                    . '&lt;/script&gt;'
//                    . '&lt;/div&gt;</div>';
                    
                    $inner_text_widget_small = '<h3>Скопируйте и вставьте код виджета на свой сайт:</h3>'
                    . '<div class="div_widget_small_for_company">&lt;div id="er_widget_small"&gt;&lt;/div&gt;'
                    . '&lt;script id="erw_script" src="https://beta2.eto-razvod.ru/gen_widgets.js?comp_id='.$comp_id.'"&gt;'
                    . '&lt;/script&gt;'
                    . '</div>';
                    
                } else {
                    $power_ = '';
                    $inner_text_widget_small = '<h3>Виджет отключен!</h3>';
                }
                
                $result .= '<div class="checkbox_container m_b_10 font_small color_dark_blue">'
                        . '<input type="hidden" value="'.$comp_id.'" id="hidden_comp_id" />'
                        . '<input type="checkbox" id="power_widget_small" name="power_widget_small" class="custom-checkbox custom-checkbox-green" '.$power_.'>'
                        . '<label for="power_widget_small">Подключить виджет</label>'
                        . '</div>'
                        . '<div class="box_widget_code">'.$inner_text_widget_small.'</div>';
                
//                $result .= '<div class="white_block border_radius_4px">'
//                        . '<button class="get_widget_small line_height_zero font_small button button_bigger font_bold button_violet pointer link_no_underline" onclick="ajax_get_widget_small()" >Виджет</button>'
//                        . '<div class="widget_small_result"></div>'
//                        . '</div>';
		
//		$result .= widget_company_in_ratings($comp_id,'rate_page_dashboard');
		$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}


if (!function_exists('company_stats_menu_count')) {
	function company_stats_menu_count( $post_id ) {
		$args_abuse_menu = [
			'status'     => 'approve',
			'post_id'    => $post_id,
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				],
				[
					'key'	 	=> 'abuse_state',
					'value'	  	=> 'not_seen',
					'compare' 	=> '=',
				]
			]
		];
		$abuse_menu = get_comments( $args_abuse_menu );

		$args_comments_menu = [
			'status'       => 'approve',
			'post_id'      => $post_id,
			'comment_type' => 'comment',
			'meta_query'   => [
				'relation' => 'AND',
				[
					'key'     => 'comment_type',
					'value'   => 'reviews',
					'compare' => '=',
				]
			],
			'count' => true
		];
		$comments_menu = get_comments( $args_comments_menu );

		return ['abuse_menu' => $abuse_menu,'comments_menu' => $comments_menu];

	}
}

if (!function_exists('company_edit_avatar_block')) {
	function company_edit_avatar_block($comp_id) {
		$result = '';
		$get_userdata = get_userdata($userid);
		$result .= '<div class="company_sidebar_editor container_side flex flex_column user_edit_bar" data-name="'.$get_userdata->user_nicename.'">';
		$result .= '<div class="side_block white_block border_radius_4px">';
		$result .= '<div class="block_title_edit color_dark_blue justify-content-flex-end"><!--<span class="edit-icon-wrapper justify-content-flex-end"><span class="edit_editor pointer" data-type="edit-profile"></span></span>--></div>';
		$result .= '<div class="block_content side_block_column align-items-center user_edit_avatar_block_wrapper">';


		$result .= '<div class="profile_logo"';
		$user_picture = get_field('company_logo', $comp_id );
		$logo_bg = get_field('company_icon_bg',$comp_id);
		if($logo_bg && $logo_bg != '') {
			$bg = ' background-color:'.$logo_bg.';';
		} else {
			$bg = '';
		}
		if($user_picture && $user_picture != '') {
			$result .= ' style="background-image: url('.$user_picture["sizes"]["large"].');'.$bg.'" ';
		}
		$result .= '></div>';
		$user_display_name = get_field('company_name',$comp_id);

		$result .= '<span class="font_medium font_bold user_edit_avatar_block_title">'.$user_display_name.'</span>';

		$er_company_site_str = get_field('websites',$comp_id)[0]['site_url'];
		$er_company_site_str_2 = preg_replace('#^[^:/.]*[:/]+#i', '', $er_company_site_str);
		$site = preg_replace('/^www\./', '', rtrim($er_company_site_str_2,'/'));
		$link = review_redirect_link($comp_id);
		$result .= '<span class="hr_comp_profile"></span>';
		$result .= '<a class="company_site link_no_underline" href="'.$link.'" target="_blank" rel="nofollow">';
		$result .= '<div class="site_url font_bold color_dark_blue font_22" target="_blank" data-no-translation>'.$site.'</div>';
		$result .= '<span class="font_smaller_2 color_medium_gray">'.__('Перейти на сайт','er_theme').'</span>';
		$result .= '</a>';


		/*if (   !( (    get_field('user_activation', 'user_'.$userid ) == '') || (get_field('user_activation', 'user_'. $userid ) == 'no'))) {
			$result .= '<span class="button font_bold button_green link_no_underline user_edit_avatar_block_profile_confirm activated_profile">Подтвержденный профиль</span>';
		} else {
			$result .= '<span class="button font_bold button_violet pointer link_no_underline user_edit_avatar_block_profile_confirm nonactivated_profile">Подтвердить профиль</span>';
		}*/
		/*$result .= '<span class="button font_bold button_violet pointer link_no_underline user_edit_avatar_block_profile_confirm nonactivated_profile">Подтвержденная компания</span>';*/

		$result .= '</div>';


		$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('company_dashboard_profile_editor')) {
	function company_dashboard_profile_editor($userid = NULL,$comp_id = NULL,$company_slug = NULL) {
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

		$result .= company_menu($current_user,$user_id,'dashboard',$comp_id,$company_slug);
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		$result .= '<div class="comment_bar_info_wrapper comment_bar_info_wrapper_user_editor">'.profile_comments($user_id,NULL,'skills').'</div>';
		$result .= profile_container_about($user_id,NULL,'desc','show');
		$result .= '</div>';
//		$result .= '            <div class="profile-wrapper__right_sub">'.company_edit_avatar_block($comp_id).'<div class="container_side flex flex_column">'.user_contacts_sidebar($user_id,'edit').'</div>'.fast_links_profile( $user_id ,'noborder',[['/dashboard/services/pro/','Включить аккаунт PRO'],['/advices/','Полезные советы'],['/user-edit/','Как заполнить аккаунт'],['/user-help/','Помощь']]).menu_footer_links(true).'</div>';
//		$result .= '            <div class="profile-wrapper__right_sub">'.company_edit_avatar_block($comp_id).'<div class="container_side flex flex_column">'.user_contacts_sidebar($user_id,'edit').'</div>'.fast_links_profile( $user_id ,'noborder',[['/user-help/','Помощь']]).menu_footer_links(true).'</div>';
		$result .= '            <div class="profile-wrapper__right_sub">'.company_edit_avatar_block($comp_id).'<div class="container_side flex flex_column">'.user_contacts_sidebar($user_id,'edit').'</div>'.fast_links_profile( $user_id ,'noborder',[['/company-help/','Помощь']]).menu_footer_links(true).'</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}

if(!function_exists('company_t_contacts_sidebar')) {
	function company_t_contacts_sidebar($comp_id_main_test,$type = NULL) {
		//if (($contacts_email != '') || ($contacts_skype != '') || ($contacts_telegram != '')) {
			$result = '';

			if ($type == 'edit') {
				$result .= '<div class="side_block white_block border_radius_4px dashboard_editor">';
				$result .= '<div class="block_title_edit color_dark_blue">' . __( 'Виды поддержки', 'er_theme' ) . '<span class="edit-icon-wrapper"><span class="settings_editor"></span><span class="edit_editor pointer edit_editor_company" data-type="edit-contacts"></span></span></div>';
			} else {
				$result .= '<div class="side_block white_block dashboard_editor">';
				$result .= '<div class="block_title font_smaller_2 font_bolder font_uppercase color_dark_blue">' . __( 'Контакты', 'er_theme' ) . '</div>';
			}

			$result .= '<div class="block_content side_block_column">';


		$get_support = get_field('base_2_support',$comp_id_main_test);

		foreach ($get_support  as $item ) {


			$result .= '<div class="profile_sidebar_contact_link__email_wrapper font_small">';
			$result .= '<span class="profile_sidebar_contact_link" >';
			if (get_field('icon','channels_'.$item['channel'])) {
				$result .= '<i class="'.get_field('icon','channels_'.$item['channel']).'" aria-hidden="true"></i>';
			}
			if ($item['text'] != '') {
				$result .= $item['text'];
			} else {
				$result .= get_term_by('ID', $item['channel'], 'channels')->name;
			}
			$result .= '</span>';
			$result .= '</div>';
			//print_r(get_term_by('ID', $item['channel'], 'channels'));
		}
			//$result .= '<div class="color_dark_gray font_small link_review_map link_dropdown link_inactive">'.__('Карта','er_theme').'</div>';
			$result .= '</div>';
			$result .= '</div>';

			return $result;
		//}
	}

}

if(!function_exists('company_t_contacts_social_sidebar')) {
	function company_t_contacts_social_sidebar($comp_id_main_test,$type = NULL) {
		//if (($contacts_email != '') || ($contacts_skype != '') || ($contacts_telegram != '')) {
		$result = '';

		if ($type == 'edit') {
			$result .= '<div class="side_block white_block border_radius_4px dashboard_editor_2">';
			$result .= '<div class="block_title_edit color_dark_blue">' . __( 'Социальные сети', 'er_theme' ) . '<span class="edit-icon-wrapper"><span class="settings_editor"></span><span class="edit_editor pointer edit_editor_company" data-type="edit-contacts"></span></span></div>';
		} else {
			$result .= '<div class="side_block white_block dashboard_editor_2">';
			$result .= '<div class="block_title font_smaller_2 font_bolder font_uppercase color_dark_blue">' . __( 'Контакты', 'er_theme' ) . '</div>';
		}

		$result .= '<div class="block_content side_block_column">';


		$get_support = get_field('social_networks',$comp_id_main_test);

		foreach ($get_support  as $item ) {


			$result .= '<div class="profile_sidebar_contact_link__email_wrapper font_small">';
			$result .= '<a class="profile_sidebar_contact_link" href="'.$item['link'].'">';
			if (get_field('icon','channels_'.$item['channel'])) {
				$result .= '<i class="'.get_field('icon','channels_'.$item['channel']).'" aria-hidden="true"></i>';
			}

			if ($item['text'] != '') {
				$result .= $item['text'];
			} else {
				$result .= get_term_by('ID', $item['channel'], 'channels')->name;
			}
			$result .= '</a>';
			$result .= '</div>';
			//print_r(get_term_by('ID', $item['channel'], 'channels'));
		}
		//$result .= '<div class="color_dark_gray font_small link_review_map link_dropdown link_inactive">'.__('Карта','er_theme').'</div>';
		$result .= '</div>';
		$result .= '</div>';

		return $result;
		//}
	}

}

if(!function_exists('company_form')) {
	add_action( 'wp_ajax_company_form', 'company_form' );
	add_action( 'wp_ajax_nopriv_company_form', 'company_form' );

	function company_form() {
		$userid = intval($_POST['userid']);
		$user_info = get_userdata($userid);
		$service = htmlspecialchars($_POST['service']);
		$type = htmlspecialchars($_POST['type']);
		$typespend = htmlspecialchars($_POST['typespend']);
		$company_id = htmlspecialchars($_POST['company_id']);
		$company_slug = htmlspecialchars($_POST['company_slug']);


		$result = '';
		$result .= '<div class="popup_container" id="popup_edit_user_form">';
		$result .= '<div class="popup_window box_shadow border_radius_4px">';
		if ($type == 'edit_skills_popup') {
			$result .= '<div class="popup_close_button pointer turn_off_skills" data-close="popup_edit_user_form" onclick="set_cookie_skills()"></div>';
		} else {
			$result .= '<div class="popup_close_button pointer" data-close="popup_edit_user_form"></div>';
		}
		$result .= '<div class="flex_column user_popup_form_edit user-form" id="set_'.$type.'">';
		if ($type == 'edit-profile') {
			$result .= edit_profile($userid,$user_info);
		} elseif ($type == 'edit-contacts') {
			$result .= company_edit_contacts($userid,$user_info,$typespend,$company_id,$company_slug,$service);
		}  elseif ($type == 'edit-about') {
			$result .= edit_about($userid,$user_info);
		}  elseif ($type == 'edit_skills_popup') {
			//$userid

			$current_user = wp_get_current_user();
			$userid = $current_user->ID;
			$result .= edit_skills_popup($userid,$user_info,$typespend);
		}  elseif ($type == 'service_popup') {
			$result .= service_popup($userid,$user_info,$typespend,$service);
		}  elseif ($type == 'add_promo') {
			/*$result .= $company_id;
			$result .= $company_slug;*/
			$result .= add_promo($userid,$user_info,$typespend,$company_id,$company_slug,$service);
		}
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}

if ( ! function_exists( 'add_promo' ) ) {
	function add_promo($userid,$user_info,$typespend,$company_id,$company_slug,$service) {
		if ($service == '') {
			if ($typespend == 'promo') {
				$result = '<span class="user-form__title color_dark_blue">' . __( 'Добавить промокод', 'er_theme' ) . '</span>';
			} else {
				$result = '<span class="user-form__title color_dark_blue">' . __( 'Добавить акцию', 'er_theme' ) . '</span>';
			}
			$result .= '<div class="two_cols">';
			$result .= '<select name="select_promotype" class="select_big m_b_10 border_radius_4px select_arrow">';
			$result .= '<option value="discount" selected="selected" data-i="0">Скидка на заказ</option><option value="gift">Подарок к покупке</option><option value="delivery">Бесплатная доставка</option><option value="reg">Бонус при регистрации</option><option value="demo">Бесплатный демо-счет</option>';
			$result .= '</select>';
			$result .= '<input type="text" name="add_promo_name" placeholder="Название" class="input_big m_b_10 placeholder_dark border_radius_4px" value="">';
			$result .= '</div>';
			$result .= '<textarea name="add_promo_desc" class="m_b_20 add_comment_company" placeholder="Описание"></textarea>';
			$result .= '<input type="text" name="add_promo_link" placeholder="Ссылка" class="input_big m_b_10 placeholder_dark border_radius_4px" value="">';
			$result .= '<div class="two_cols">';
			$result .= '<input type="text" name="add_promo_amount" placeholder="Размер скидки" class="input_big m_b_10 placeholder_dark border_radius_4px" value="">';
			$result .= '<input type="text" name="add_promo_discount_currency" placeholder="Валюта скидки" class="input_big m_b_10 placeholder_dark border_radius_4px" value="">';
			$result .= '</div>';
			if ($typespend != 'promo') {
				$result .= '<input type="text" name="add_promo_text" placeholder="Текст промокода" class="input_big m_b_10 placeholder_dark border_radius_4px" value="" style="display: none">';
			} else {
				$result .= '<input type="text" name="add_promo_text" placeholder="Текст промокода" class="input_big m_b_10 placeholder_dark border_radius_4px" value="">';
			}


			$result .= '<div class="two_cols">';
			$result .= '<input type="date" id="start_promo" name="start_promo"
       value="'.date('Y-m-d').'"
       min="'.date('Y-m-d').'" max="2033-12-31" class="input_big m_b_10 placeholder_dark border_radius_4px" value=""><span class="data_about_add_promo"> - </span>';
			$result .= '<input type="date" id="end_promo" name="end_promo"
       value="'.date('Y-m-d').'"
       min="'.date('Y-m-d').'" max="2033-12-31" class="input_big m_b_10 placeholder_dark border_radius_4px" value="">';
			$result .= '</div>';


			/*$result .= '<div class="flex user-form__twoinputs">';

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
			$result .= '<span class="about_psw color_dark_blue font_small"></span>';*/


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

			/*$result .= '<div class="flex">';
			$result .= '<select name="select_specialization" class="select_big m_b_10 border_radius_4px select_arrow">';
			$result .= '<option selected="selected">Выберите страну</option>';
			$result .= '<option>1</option>';
			$result .= '<option>2</option>';
			$result .= '<option>3</option>';
			$result .= '<option>4</option>';
			$result .= '</select>';
			$result .= '</div>';

			$result .= '<div class="flex">';
			$result .= '<select name="select_specialization" class="select_big m_b_10 border_radius_4px select_arrow">';
			$result .= '<option selected="selected">Выберите город</option>';
			$result .= '<option>1</option>';
			$result .= '<option>2</option>';
			$result .= '<option>3</option>';
			$result .= '<option>4</option>';
			$result .= '</select>';
			$result .= '</div>';*/

			/*$result .= '<span class="user-form__title user-form__title_mt_40 color_dark_blue">' . __( 'Подключить мои социальные сети', 'er_theme' ) . '</span>';

			$result .= '<ul class="ul_none social-ul user-form__social_mb_40">';
			$result .= '<li class="social-ul__item social-ul__item_twitter"></li>';
			$result .= '<li class="social-ul__item social-ul__item_rss"></li>';
			$result .= '<li class="social-ul__item social-ul__item_whatsapp"></li>';
			$result .= '<li class="social-ul__item social-ul__item_skype"></li>';
			$result .= '</ul>';*/

			$result .= '<div class="button button_gray pointer button_nopadding font_bold send_promocode"  data-type="add">' . __( 'Отправить промокод', 'er_theme' ) . '</div>';
		} else {

			if ($typespend == 'promo') {
				$result = '<span class="user-form__title color_dark_blue">' . __( 'Добавить промокод', 'er_theme' ) . '</span>';
			} else {
				$result = '<span class="user-form__title color_dark_blue">' . __( 'Добавить акцию', 'er_theme' ) . '</span>';
			}
			$single_promocodes = str_replace("single_promocodes_", "",$service);
			$single_promocodes = explode('_',$single_promocodes);
			$ticker = intval($single_promocodes[1]) - 1;
			$result .= '<div class="two_cols get_id_from_class" data-id="'.$single_promocodes[0].'" data-number="'.$ticker.'">';

			$result .= '<select name="select_promotype" class="select_big m_b_10 border_radius_4px select_arrow">';
			$result .= '<option value="discount" selected="selected" data-i="0">Скидка на заказ</option><option value="gift">Подарок к покупке</option><option value="delivery">Бесплатная доставка</option><option value="reg">Бонус при регистрации</option><option value="demo">Бесплатный демо-счет</option>';
			$result .= '</select>';
			$result .= '<input type="text" name="add_promo_name" placeholder="Название" class="input_big m_b_10 placeholder_dark border_radius_4px" value="'.get_field('promocodes_items_'.$ticker.'_title',$single_promocodes[0]).'">';
			$result .= '</div>';
			$result .= '<textarea name="add_promo_desc" class="m_b_20 add_comment_company" placeholder="Описание">'.get_field('promocodes_items_'.$ticker.'_description',$single_promocodes[0]).'</textarea>';
			$result .= '<input type="text" name="add_promo_link" placeholder="Ссылка" class="input_big m_b_10 placeholder_dark border_radius_4px" value="'.get_field('promocodes_items_'.$ticker.'_partner_link',$single_promocodes[0]).'">';
			$result .= '<div class="two_cols">';
			$result .= '<input type="text" name="add_promo_amount" placeholder="Размер скидки" class="input_big m_b_10 placeholder_dark border_radius_4px" value="'.get_field('promocodes_items_'.$ticker.'_discount_size',$single_promocodes[0]).'">';
			$result .= '<input type="text" name="add_promo_discount_currency" placeholder="Валюта скидки" class="input_big m_b_10 placeholder_dark border_radius_4px" value="'.get_field('promocodes_items_'.$ticker.'_discount_currency',$single_promocodes[0]).'">';
			$result .= '</div>';
			if ($typespend != 'promo') {
				$result .= '<input type="text" name="add_promo_text" placeholder="Текст промокода" class="input_big m_b_10 placeholder_dark border_radius_4px" value="" style="display: none">';
			} else {
				$result .= '<input type="text" name="add_promo_text" placeholder="Текст промокода" class="input_big m_b_10 placeholder_dark border_radius_4px" value="">';
			}


			$result .= '<div class="two_cols">';
			$result .= '<input type="date" id="start_promo" name="start_promo"
       value="'.get_field('promocodes_items_'.$ticker.'_date_start',$single_promocodes[0]).'"
       min="'.date('Y-m-d').'" max="2033-12-31" class="input_big m_b_10 placeholder_dark border_radius_4px" value=""><span class="data_about_add_promo"> - </span>';
			$result .= '<input type="date" id="end_promo" name="end_promo"
       value="'.get_field('promocodes_items_'.$ticker.'_date_end',$single_promocodes[0]).'"
       min="'.date('Y-m-d').'" max="2033-12-31" class="input_big m_b_10 placeholder_dark border_radius_4px" value="">';
			$result .= '</div>';


			/*$result .= '<div class="flex user-form__twoinputs">';

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
			$result .= '<span class="about_psw color_dark_blue font_small"></span>';*/


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

			/*$result .= '<div class="flex">';
			$result .= '<select name="select_specialization" class="select_big m_b_10 border_radius_4px select_arrow">';
			$result .= '<option selected="selected">Выберите страну</option>';
			$result .= '<option>1</option>';
			$result .= '<option>2</option>';
			$result .= '<option>3</option>';
			$result .= '<option>4</option>';
			$result .= '</select>';
			$result .= '</div>';

			$result .= '<div class="flex">';
			$result .= '<select name="select_specialization" class="select_big m_b_10 border_radius_4px select_arrow">';
			$result .= '<option selected="selected">Выберите город</option>';
			$result .= '<option>1</option>';
			$result .= '<option>2</option>';
			$result .= '<option>3</option>';
			$result .= '<option>4</option>';
			$result .= '</select>';
			$result .= '</div>';*/

			/*$result .= '<span class="user-form__title user-form__title_mt_40 color_dark_blue">' . __( 'Подключить мои социальные сети', 'er_theme' ) . '</span>';

			$result .= '<ul class="ul_none social-ul user-form__social_mb_40">';
			$result .= '<li class="social-ul__item social-ul__item_twitter"></li>';
			$result .= '<li class="social-ul__item social-ul__item_rss"></li>';
			$result .= '<li class="social-ul__item social-ul__item_whatsapp"></li>';
			$result .= '<li class="social-ul__item social-ul__item_skype"></li>';
			$result .= '</ul>';*/

			$result .= '<div class="button button_gray pointer button_nopadding font_bold send_promocode" data-type="edit">' . __( 'Отправить промокод', 'er_theme' ) . '</div>';
		}


		return $result;
	}
}

if ( ! function_exists( 'company_edit_contacts' ) ) {
	function company_edit_contacts($userid,$user_info = null,$typespend = null,$company_id = null,$company_slug = null,$service = null) {
		/*$contacts_email = get_field('contacts_e-mail','user_'.$userid);
		$contacts_skype = get_field('contacts_skype','user_'.$userid);
		$contacts_telegram = get_field('contacts_telegram','user_'.$userid);*/
		$result = '<div class="flex flex_column">';
		$result .= '<span class="user-form__title color_dark_blue">' . __( $service, 'er_theme' ) . '</span>';
		//$result .= var_dump(get_field($typespend,$company_id));
		$get_support = get_field($typespend,$company_id);
		foreach ($get_support  as $item ) {
			$result .= '<div class="block_wrapper"><span class="close_block_wrapper_cf_company"></span>';

			if (get_field('icon','channels_'.$item['channel'])) {
				$result .= '<i class="'.get_field('icon','channels_'.$item['channel']).'" aria-hidden="true"></i>';
			}
				$result .= '<input type="text" name="profile_mail_input" placeholder="'.get_term_by('ID', $item['channel'], 'channels')->name.'" class="input_big m_b_10 placeholder_dark border_radius_4px " value="'.$item['text'].'">';
			$result .= '</div>';
		}
		/*$result .= '<input type="text" name="profile_mail_input" placeholder="E-mail" class="input_big m_b_10 placeholder_dark border_radius_4px profile_mail_input contacts_input" value="'.$contacts_email.'">';
		$result .= '<input type="text" name="profile_skype_mail_input" placeholder="Skype" class="input_big m_b_10 placeholder_dark border_radius_4px profile_skype_mail_input contacts_input" value="'.$contacts_skype.'">';
		$result .= '<input type="text" name="profile_telegram_mail_input" placeholder="Telegram" class="input_big m_b_10 placeholder_dark border_radius_4px profile_telegram_mail_input contacts_input" value="'.$contacts_telegram.'">';*/
		$result .= '<div class="button button_gray pointer button_nopadding font_bold update_user_editor_contacts for_user_editor">' . __( 'Сохранить', 'er_theme' ) . '</div>';
		$result .= '</div>';
		return $result;
	}
}


if ( ! function_exists( 'company_dashboard_promo' ) ) {
	function company_dashboard_promo( $userid = null, $comp_id = null, $company_slug = null ) {


		$current_user = wp_get_current_user();
		$user_id      = $current_user->data->ID;
		$result       = print_css_links( 'user_page' );
		$result       .= print_js_links()['user_page'];
		$result       .= print_js_links()['show_block'];
		$result       .= print_css_links( 'show_block' );
		//$result .= print_js_links()['comments_loader_dashboard'];
		$result .= print_js_links()['popup_inside_dashboard'];
		$result .= print_js_links()['promocode_dashboard_loader'];
		$result .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		$result .= '<div class="page_content page_container background_light review_container_about visible">';
		$result .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result .= '        <div class="profile-wrapper">';
		$result .= '            <div class="profile-wrapper__left">';

		$result .= company_menu( $current_user, $user_id, 'companies', $comp_id, $company_slug );
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center profile-wrapper__center_promo">';
		$result .= '<div class="breadcrumbs_dashboard">';
		if ( function_exists( 'show_breadcrumbs' ) ) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		//$result .= review_container_comments_company();


		$num              = '';
		$promocodes_query = new WP_Query( array(
			'post_type'  => 'promocodes',
			'post_status'    => 'publish',
			'meta_query' => array(
				array(
					'key'     => 'promocode_review', // name of custom field
					'value'   => $comp_id, // matches exactly "123", not just 123. This prevents a match for "1234"
					'compare' => '='
				)
			)

		) );
		while ( $promocodes_query->have_posts() ) {
			$promocodes_query->the_post();
			global $post;
			$num = get_the_ID();
		}
		wp_reset_postdata();
		$act_promo     = 0;
		$not_act_promo = 0;


		$result .= '<div class="white_block comments_top flex comment_top_dashboard_comments__header">';
		$result .= '   <script src="https://etorazvod.ru/wp-content/themes/eto-razvod-1/js/events.js" type="text/javascript"></script>';
		$result .= '   <h2 class="comments_top_title font_uppercase font_bolder color_dark_blue font_smaller_2">Акции</h2>';
		$result .= '   <div class="comments_top_count font_bold color_dark_gray font_small"></div>';
		$result .= '   <div class="show_block_comments">';
		$result .= '      <div class="color_dark_gray font_small link_review_map link_dropdown link_inactive show_block show_block_to_up" data-block=".comment_top_dashboard_comments__footer" data-type="comment_top_dashboard_comments__footer_show"></div>';
		$result .= '   </div>';
		$result .= '</div>';


		$result .= '<div class="white_block flex comment_top_dashboard_comments__footer comment_top_dashboard_comments__footer_show">';
		$result .= '   <ul class="menu-take-comments-dashboard">';
		$result .= '      <li class="menu-take-comments-dashboard__item_comp_d menu-take-comments-dashboard__item_comp_d_promo flex align_items_center pointer" data-sort-type="new"><span class="border_no_color">Все</span></li>';
		$result .= '      <li class="menu-take-comments-dashboard__item_comp_d menu-take-comments-dashboard__item_comp_d_promo flex align_items_center pointer" data-sort-type="answers"><span class="circus_promo circus_promo_purple"></span><span class="border_no_color">Акции</span> <!--<span class="new-comments-profile__number font_bold border_circle_px ans_get" style="border-radius: 50%; padding: 0px; width: 32px;">0</span>--></li>';
		$result .= '      <li class="menu-take-comments-dashboard__item_comp_d menu-take-comments-dashboard__item_comp_d_promo flex align_items_center pointer" data-sort-type="noanswers"><span class="circus_promo circus_promo_green"></span><span class="border_no_color">Промокоды</span> <!--<span class="new-comments-profile__number font_bold border_circle_px button_gray noans_get" style="border-radius: 50%; padding: 0px; width: 32px;">1</span>--></li>';
		$result .= '   </ul>';
		$result .= '</div>';


		$result .= '<div class="side_block white_block border_radius_4px add_promocode_wrapper"><span class="add_promocode_btn_main">Добавить акцию</span>';
		$result .= '<span class="promocode_btn_add act pointer" onclick="typeact_promo = \'promo\'">Промокод</span><span class="promocode_btn_add pointer" onclick="typeact_promo = \'action\'">Акции</span></div>';

		if ( $num != '' ) {
			$promocodes       = get_field( 'promocodes_items', $num );
			$company_name     = get_field( 'company_name', $comp_id );
			$faq_company_name = $company_name;
			$faq_url_company  = get_bloginfo( 'url' ) . '/visit/' . get_field( 'company_redirect_key', $comp_id ) . '/';
			$faq_url_review   = get_permalink();
			function max_with_key( $array, $key ) {
				if ( ! is_array( $array ) || count( $array ) == 0 ) {
					return false;
				}
				$max  = $array[0][ $key ];
				$keyr = $array[0][ $key ] . '' . $array[0]['y'];
				foreach ( $array as $a ) {
					if ( $a[ $key ] > $max ) {
						$max  = $a[ $key ];
						$keyr = $a[ $key ] . '' . $a['y'];
					}
				}

				return $keyr;
			}

			function min_with_key( $array, $key ) {
				if ( ! is_array( $array ) || count( $array ) == 0 ) {
					return false;
				}
				$max  = $array[0][ $key ];
				$keyr = $array[0][ $key ] . '' . $array[0]['y'];
				foreach ( $array as $a ) {
					if ( $a[ $key ] < $max ) {
						$max  = $a[ $key ];
						$keyr = $a[ $key ] . '' . $a['y'];
					}
				}

				return $keyr;
			}

			if ( $promocodes && ! empty( $promocodes ) ) {
				$faq_discounts        = array();
				$faq_count_promocodes = count( $promocodes );

				$y         = 0;
				$result    .= '<ul class="flex list_promocodes single_promocodes_list">';
				$count_all = count( $promocodes );

				$hour      = 12;
				$today     = strtotime( $hour . ':00:00' );
				$yesterday = strtotime( '-1 day', $today );

				foreach ( $promocodes as $item ) {

					$y ++;

					$date_end_m = strtotime( $item['date_end'] );
					if ( $date_end_m < $yesterday && ! empty( $item['date_end'] ) && $item['date_end'] != 'None' ) {
						$not_act_promo = ++ $not_act_promo;
					} else {
						if (($item['hide_promos'] =='yes')|| ($item['hide_promos'] =='removed')) {

						} else {
							$act_promo = ++ $act_promo;
						}

						//$result .= '<span class="date_end" style="display: none">'.strtotime($item['date_end']).' '.$yesterday.'</span>';
						if ( $item['text'] != '' && $item['text'] != 'Не нужен' ) {
							$border = 'border_green';
						} else {
							$border = 'border_biolet';
						}
						if ( $y > 9 ) {
							$hidden_default = ' hidden';
						} else {
							$hidden_default = '';
						}

						if (($item['hide_promos'] =='yes') || ($item['hide_promos'] =='removed')) {
							$result .= '<li class="white_block relative_position flex ' . $border . '' . $hidden_default . '" id="single_promocodes_' . $num . '_' . $y . '">';
						} else {
							$result .= '<li class="white_block flex ' . $border . '' . $hidden_default . '" id="single_promocodes_' . $num . '_' . $y . '">';
						}

						$result .= '<span class="remove_promo"  onclick=\'remove_promo('. $num . ',' . $y . ',company_page.company_id,company_page.company_slug);\'></span>';
						if ($item['hide_promos'] =='yes') {
							$result .= '<span class="hide_promos">На модерации</span>';
						} elseif ($item['hide_promos'] =='removed') {
							$result .= '<span class="hide_promos">На удалении</span>';
						}

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
						if ( $item['discount_currency'] && $item['discount_currency'] == '%' ) {
							$faq_discounts[] = array(
								'x' => $item['discount_size'],
								'y' => $item['discount_currency']
							);

						}
						if ( $y < 4 ) {

							$faq_discount_titles .= $item['title'] . ', ';
						}
						$result .= '<div class="promocode_block_content flex">';
						$result .= '<div class="promocode_list_single_left">';
						if ( $size != '' ) {
							$result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size">' . $size . '</div>';
						} else {
							$result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size_text">' . $item_type . '</div>';
						}
						$terms  = get_term( get_field( 'promocode_taxonomy', $comp_id ), 'affiliate-tags' )->slug;
						$result .= '<div class="promocode_item_title color_dark_blue link_no_underline font_bold">' . $company_name . '</div>';


						$result .= '</div>';
						$result .= '<div class="promocode_list_single_right">';
						if ( $item['title'] != '' ) {
							$result .= '<div class="promo_title color_dark_blue font_18 font_bold">' . $item['title'] . '</div>';
						}

						if ( $item['description'] != '' ) {
							$result .= '<div class="promocode_full_description color_dark_gray font_small">' . $item['description'] . '</div>';
						}
						$result .= '<div class="promocode_button_container">';
						if ( $item['text'] != '' && $item['text'] != 'Не нужен' ) {
							$result .= '<div class="promocode_text_container">';
							$result .= '<div class="promocode_single_text" id="promocode_text_' . $comp_id . '_' . $y . '">' . $item['text'] . '</div>';
							$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="' . get_bloginfo( 'url' ) . '/visit2/' . $comp_id . '-' . $y . '/" target="_blank" rel="nofollow">' . __( 'Получить', 'er_theme' ) . '</a>';
							$result .= '<div class="link_promocode_text_copy button button_green button_centered m_t_20 pointer font_smaller font_bold">' . __( 'Скопировать', 'er_theme' ) . '</div>';
							$result .= '</div>';
							$result .= '<div class="link_promocode_show_more_text_popup button button_green button_centered m_t_20 pointer font_smaller font_bold">' . __( 'Показать код', 'er_theme' ) . '</div>';
						} else {
							$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="' . get_bloginfo( 'url' ) . '/visit2/' . $comp_id . '-' . $y . '/" target="_blank" rel="nofollow">' . __( 'Получить', 'er_theme' ) . '</a>';
						}
						$result .= '</div>';
						$result .= '<div class="promocode_block_footer flex">';
						$result .= '<span class="font_smaller color_dark_gray pointer" style="margin-right: 20px;" onclick=\'popup_company_form("add_promo",0,"single_promocodes_' . $num . '_' . $y . '","",company_page.company_id,company_page.company_slug);\'>Изменить</span>';
						if ( $item['description'] != '' ) {
							$result .= '<span class="font_smaller color_dark_gray inactive dropdown pointer flex link_promocode_show_more">' . __( 'Подробнее', 'er_theme' ) . '</span>';
						}
						$count_used = 1;
						if ( $item['visits'] && $item['visits'] != '' && $item['visits'] != 0 ) {
							$count_used = $item['visits'];
						}
						$result .= '<span class="promo_used font_bold font_smaller color_dark_blue">' . $count_used . ' ' . counted_text( $count_used, __( 'использует', 'er_theme' ), __( 'используют', 'er_theme' ), __( 'используют', 'er_theme' ) ) . '</span>';
						$result .= '</div>';
						$result .= '</div>';
						$result .= '</div>';


						$result .= '</li>';
					}

				}
				$result .= '</ul>';

			}
			if ( $count_all > 9 ) {
				$result .= '<div class="button button_comments button_green pointer load_more_single_promocodes font_small font_bold m_b_20" data-offset="9" >' . __( 'Показать еще', 'er_theme' ) . '</div>';
			}
		}
		$result .= '</div>';


		//$result .= company_subscribe_data_dashboard($comp_id,'dashboard');
		$result .= '            <div class="profile-wrapper__right">' . company_subscribe_data_dashboard( $comp_id, 'dashboard' ) . sidebar_promo( $comp_id, $act_promo, $not_act_promo ) . fast_links_profile( $user_id, 'noborder', [
				[
					'#',
					'Включить аккаунт PRO'
				],
				[ '/advices/', 'Полезные советы' ],
				[ '/user-edit/', 'Как заполнить аккаунт' ],
				[ '/user-help/', 'Помощь' ]
			] ) . '</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links( 'profile_top' );

		return $result;
	}
}


if (!function_exists('sidebar_promo')) {
	function sidebar_promo($comp_id, $act_promo, $not_act_promo) {
		$result = '';
		$result .= '<div class="side_block white_block border_radius_4px sidebar_promo">';
		$result .= '   <div class="block_content side_block_column">';
		$result .= '      <div class="number-stat-profile_w100">';
		$result .= '         <div class="number-stat-profile"> <span class="number-stat-profile__title">Активность</span></div>';
		$result .= '      </div>';
		$result .= '      <ul class="ul_none abuses_mini_stats">';
		$result .= '         <li class="abuses_mini_stats__item"><span class="color_dark_gray border_no_color">Активные</span><span class="new-comments-profile__number font_bold border_circle_px ans_get all_promos_number" style="border-radius: 50%; padding: 0px; width: 32px;">'.$act_promo.'</span></li>';
		$result .= '         <li class="abuses_mini_stats__item"><span class="color_dark_gray border_no_color">Завершенные</span><span class="new-comments-profile__number font_bold border_circle_px button_gray noans_get" style="border-radius: 50%; padding: 0px; width: 32px;">'.$not_act_promo.'</span></li>';
		$result .= '      </ul>';
		$result .= '   </div>';
		$result .= '</div>';
		return $result;
	}
}


if(!function_exists('add_promocode_main')) {
	add_action( 'wp_ajax_add_promocode_main', 'add_promocode_main' );
	add_action( 'wp_ajax_nopriv_add_promocode_main', 'add_promocode_main' );

	function add_promocode_main() {
		date_default_timezone_set('Europe/Moscow');

		$select_promotype            = $_POST['select_promotype'];
		$add_promo_name              = $_POST['add_promo_name'];
		$add_promo_desc              = $_POST['add_promo_desc'];
		$add_promo_link              = $_POST['add_promo_link'];
		$add_promo_amount            = $_POST['add_promo_amount'];
		$add_promo_discount_currency = $_POST['add_promo_discount_currency'];
		$add_promo_text              = $_POST['add_promo_text'];
		$start_promo                 = $_POST['start_promo'];
		$end_promo                   = $_POST['end_promo'];
		$company_id                  = $_POST['company_id'];
		$get_id_from_class           = intval( $_POST['get_id_from_class'] );
		$get_number_from_class       = intval( $_POST['get_number_from_class'] )+1;
		$type_main                   = $_POST['type_main'];

		$num = '';
		if ( $type_main == 'edit' ) {
			$i           = $get_number_from_class - 1;
			$info_before = json_encode( get_field( 'promocodes_items', $get_id_from_class )[ $i ] );
			$row         = array(
				'type'              => $select_promotype,
				'title'             => $add_promo_name,
				'description'       => $add_promo_desc,
				'partner_link'      => $add_promo_link,
				'discount_size'     => $add_promo_amount,
				'discount_currency' => $add_promo_discount_currency,
				'text'              => $add_promo_text,
				'date_start'        => $start_promo,
				'date_end'          => $end_promo,
			);

			update_row( 'promocodes_items', $get_number_from_class, $row, $get_id_from_class );
			$info_after = json_encode( get_field( 'promocodes_items', $get_id_from_class )[ $i ] );
			//echo $get_number_from_class.' '.$get_id_from_class;
			$row = array(
				'type_change' => 'edit',
				'info_before' => $info_before,
				'info_after'  => $info_after,
				'user'        => get_current_user_id(),
				'time'        => date( 'Y-m-d H:i:s' )
			);

			add_row( 'dates_promos', $row, 'option' );
		} else {
			$promocodes_query = new WP_Query( array(
				'post_type'  => 'promocodes',
				'post_status'    => 'publish',
				'meta_query' => array(
					array(
						'key'     => 'promocode_review',
						// name of custom field
						'value'   => $company_id,
						// matches exactly "123", not just 123. This prevents a match for "1234"
						'compare' => '='
					)
				)

			) );
			while ( $promocodes_query->have_posts() ) {
				$promocodes_query->the_post();
				global $post;
				$num = get_the_ID();
			}
			wp_reset_postdata();

			if ( $num != '' ) {
				$row = array(
					'type'              => $select_promotype,
					'title'             => $add_promo_name,
					'description'       => $add_promo_desc,
					'partner_link'      => $add_promo_link,
					'discount_size'     => $add_promo_amount,
					'discount_currency' => $add_promo_discount_currency,
					'text'              => $add_promo_text,
					'date_start'        => $start_promo,
					'date_end'          => $end_promo,
					'hide_promos'       => 'yes',
				);

				add_row( 'promocodes_items', $row, $num );
			}
			$info_after = json_encode( end( get_field( 'promocodes_items', $num ) ) );

			//echo $get_number_from_class.' '.$get_id_from_class;

			$row = array(
				'type_change' => 'add',
				'info_before' => '',
				'info_after'  => $info_after,
				'user'        => get_current_user_id(),
				'time'        => date( 'Y-m-d H:i:s' )
			);

			add_row( 'dates_promos', $row, 'option' );
		}
		die;

	}
}



add_action('toplevel_page_list_edited_promocodes', 'before_acf_options_page', 1);
function before_acf_options_page() {
	/*
		Before ACF outputs the options page content
		start an object buffer so that we can capture the output
	*/
	ob_start();
}

/*
	create an action for your options page that will run after the ACF callback function
	see above for information on the hook you need to use
*/
add_action('toplevel_page_list_edited_promocodes', 'after_acf_options_page', 20);
function after_acf_options_page() {
	/*
		After ACF finishes get the output and modify it
	*/
	$content = ob_get_clean();

	$count = 1; // the number of times we should replace any string

	// insert something before the <h1>
	/*$my_content = '<p>This will be inserted before the &lt;h1&gt;</p>';
	$content = str_replace('<h1', $my_content.'<h1', $content, $count);*/
	
	// insert something after the <h1>
	$my_content = '<p>This will be inserted after the &lt;h1&gt;</p>';
	$content = str_replace('</h1>', '</h1>'.$my_content, $content, $count);

	// insert something after the form
	$my_content = '<p>This will be inserted after the form</p>';
	$content = str_replace('</form>', '</form>'.$my_content, $content, $count);

	// output the new content
	echo $content;
}

if(!function_exists('remove_promo')) {
	add_action( 'wp_ajax_remove_promo', 'remove_promo' );
	add_action( 'wp_ajax_nopriv_remove_promo', 'remove_promo' );

	function remove_promo() {
		date_default_timezone_set('Europe/Moscow');
		$company_id                  = $_POST['company_id'];
		$get_id_from_class           = intval( $_POST['id'] );
		$get_number_from_class       = intval( $_POST['num'] );
			$row         = array(
				'hide_promos'          => 'removed',
			);

		update_row( 'promocodes_items', $get_number_from_class, $row, $get_id_from_class );
		die;

	}
}

add_action( 'wp_ajax_send_to_moderate', 'send_to_moderate_callback' );
add_action( 'wp_ajax_nopriv_send_to_moderate', 'send_to_moderate_callback' );
function send_to_moderate_callback() {
	$current_user = wp_get_current_user();
	$user_id = $current_user->data->ID;
	$posts = get_posts(array(
		'numberposts'	=> -1,
		'post_type'		=> 'request_add_company',
		'meta_query'	=> array(
			'relation'		=> 'AND',
			array(
				'key'	 	=> 'user_id',
				'value'	  	=> $user_id,
				'compare' 	=> '=',
			),
			array(
				'key'	  	=> 'comp_id',
				'value'	  	=> intval($_POST['company_id']),
				'compare' 	=> '=',
			),
		),
	));

	if (count($posts) == 0) {
		$poster_id = wp_insert_post( wp_slash( array(
			'post_status'   => 'publish',
			'post_type'  => 'request_add_company',
			'post_title' => 'Привязка компании',
		) ) );
		//$company_name = htmlspecialchars($_POST['company_name']);
		$comp_id = $_POST['company_id'];

		//$image_views_array = explode(",", $image_views);
		$contact_type = htmlspecialchars($_POST['select_contact']);
		$login_type = htmlspecialchars($_POST['contact_name']);



		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;

		update_field( 'user_id', $user_id, $poster_id );
		update_field( 'comp_id', $comp_id, $poster_id );
		update_field( 'company_name', get_the_title($comp_id), $poster_id );
		//update_field( 'comment_company', $comment_company, $poster_id );
		update_field( 'type', 'pay', $poster_id );
		update_field( 'contact_type', $contact_type, $poster_id );
		update_field( 'messanger_login', $login_type, $poster_id );
		update_field('add_or_connect','Заявка',$poster_id);
		$arr_temp = ['company_user' => $comp_id,'status' => 'nopay','id_conn_comp'=> $poster_id];
		add_row('comp_statuses',$arr_temp,'user_'.$user_id);
		//echo $b;
		//print_r($image_views_array);
		$arr = ['poster_id' => $poster_id,'price' => 1000];
		echo json_encode($arr);
	}
	die;
}