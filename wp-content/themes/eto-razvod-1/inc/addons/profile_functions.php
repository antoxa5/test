<?php
if (!function_exists('profile_logo')) {
	function profile_logo($user_id) {
		$result = '';
		$result .= '<div class="profile_logo"';
		$logo = get_field('photo_profile', 'user_'. $user_id );

		if($logo && !empty($logo)) {
			//$logo['sizes']['medium'] = str_replace("beta2.", "", $logo['sizes']['medium']);
			$result .= ' style="background-image:url('.$logo['sizes']['medium'].');background-size: cover;"';
		} else {
			$result .= ' style="background-image: url(/wp-content/themes/eto-razvod-1/img/icon_user_default.svg);background-size: cover;border: 1px solid #cfdadf;"';
		}

		$result .= '></div>';
		return $result;
	}
}

if(!function_exists('user_contacts_sidebar')) {
	/**
	 * @param $user_id
	 * @param null $type
	 *
	 * @return string
	 */
	function user_contacts_sidebar($user_id,$type = NULL) {
		$contacts_email = get_field('contacts_e-mail','user_'.$user_id);
		$contacts_skype = get_field('contacts_skype','user_'.$user_id);
		$contacts_telegram = get_field('contacts_telegram','user_'.$user_id);

		if ( ( (($contacts_email != '') || ($contacts_skype != '') || ($contacts_telegram != '')) && ( ((    get_field('services_user_services','user_'.$user_id)[0] == 84175) || (get_field('services_user_services','user_'.$user_id) == 84175)) ) ) || ($type == 'edit')) {
			$result = '';

			if ($type == 'edit') {
				$result .= '<div class="side_block white_block border_radius_4px">';
				$result .= '<div class="block_title_edit color_dark_blue">' . __( 'Контакты', 'er_theme' ) . '<span class="edit-icon-wrapper"><span class="settings_editor"></span><span class="edit_editor pointer" data-type="edit-contacts"></span></span></div>';
			} else {
				$result .= '<div class="side_block white_block">';
				$result .= '<div class="block_title font_smaller_2 font_bolder font_uppercase color_dark_blue">' . __( 'Контакты', 'er_theme' ) . '</div>';
			}

			$result .= '<div class="block_content side_block_column">';
			$result .= '<div class="profile_sidebar_contact_link__email_wrapper font_small">';
			if ( $contacts_email ) {
				$result .= '<a class="profile_sidebar_contact_link profile_sidebar_contact_link__email" href="mailto:' . $contacts_email . '"><span class="profile_mail"></span>' . $contacts_email . '</a>';
			} else {
				if ($type == 'edit') {
					$result .= '<span class="profile_sidebar_contact_link profile_sidebar_contact_link__email" style="opacity: 0.2;"><span class="profile_mail"></span>Незаполнено</span>';
				}
			}
			$result .= '</div>';
			$result .= '<div class="profile_sidebar_contact_link__skype_wrapper font_small">';
			if ( $contacts_skype ) {
				$result .= '<a class="profile_sidebar_contact_link profile_sidebar_contact_link__skype" href="skype:' . $contacts_skype . '?chat"><span class="profile_skype"></span>' . $contacts_skype . '</a>';
			} else {
				if ( $type == 'edit' ) {
					$result .= '<span class="profile_sidebar_contact_link profile_sidebar_contact_link__skype" style="opacity: 0.2;"><span class="profile_skype"></span>Незаполнено</span>';
				}
			}
			$result .= '</div>';
			$result .= '<div class="profile_sidebar_contact_link__telegram_wrapper font_small">';
			if ( $contacts_telegram ) {
				$result .= '<a class="profile_sidebar_contact_link profile_sidebar_contact_link__telegram" href="https://t.me/' . $contacts_telegram . '"><span class="profile_telegram"></span>' . $contacts_telegram . '</a>';
			} else {
				if ( $type == 'edit' ) {
					$result .= '<span class="profile_sidebar_contact_link profile_sidebar_contact_link__telegram" style="opacity: 0.2;"><span class="profile_telegram"></span>Незаполнено</span>';
				}
			}
			$result .= '</div>';
			//$result .= '<div class="color_dark_gray font_small link_review_map link_dropdown link_inactive">'.__('Карта','er_theme').'</div>';
			$result .= '</div>';
			$result .= '</div>';

			return $result;
		}
	}

}


if(!function_exists('user_subscribe_data')) {
	add_action( 'wp_ajax_user_subscribe_data', 'user_subscribe_data' );
	add_action( 'wp_ajax_nopriv_user_subscribe_data', 'user_subscribe_data' );

	function user_subscribe_data() {
		$data = $_POST;
		$userid = intval($data['userid']);
		$type = $data['type'];



		if ($type == "dashboard") {
			$result = '<div class="side_block white_block subscribe_widget subscribe_widget_user_profile">';
		} else {
			$result = '<div class="side_block white_block subscribe_widget subscribe_widget_user_profile">';
		}

		$result .= '<div class="block_content flex flex_column">';
		$result .= '<div class="flex input_columns align_items_center">';
		$result .= '<span class="font_underline font_bold font_smaller pointer subscribe_link active">Подписки</span>';

		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		$current = get_field('user_subscriptions_users','user_'.$user_id);

		if(is_array($current) && in_array($userid, $current)) {
			$result .= '<span class="alertsimg active" id="subcribe_user"></span>';
		} else {
			$result .= '<span class="alertsimg" id="subcribe_user"></span>';
		}
		$result .= '</div>';

		$subscribe_companies_array =  get_field('user_subscriptions_posts','user_'.$userid);
		if (is_array($subscribe_companies_array) == false) {
			$subscribe_companies_array_count = 0;
		} else {
			$subscribe_companies_array_count = count($subscribe_companies_array);
		}
		//$subscribe_companies_array_count = count($subscribe_companies_array);
		if ($subscribe_companies_array_count != 0) {
			$result .= '<ul class="companies_subscribed">';
		}
		$i = 0;
		if ($subscribe_companies_array_count != 0) {
			foreach ( $subscribe_companies_array as $item ) {
				$review_logo_temp = review_logo($item);
				$review_logo_temp = str_replace("div", "li", $review_logo_temp);
				$result .= $review_logo_temp;
				if ($i > 5) {
					break;
				}
			}
		}

		if ($subscribe_companies_array_count != 0) {
			$result .= '</ul>';
		}
		$result .= '<span class="font_smaller color_dark_gray">';

		if ($type == "dashboard") {
			$result .= 'Вы подписаны на ' . $subscribe_companies_array_count . ' ' . counted_text( $subscribe_companies_array_count, __( 'компанию', 'er_theme' ), __( 'компании', 'er_theme' ), __( 'компаний', 'er_theme' ) );
		} else {
			if ($subscribe_companies_array_count != 0) {
				$result .= 'Пользователь подписан на ' . $subscribe_companies_array_count. ' ' . counted_text( $subscribe_companies_array_count, __( 'компанию', 'er_theme' ), __( 'компании', 'er_theme' ), __( 'компаний', 'er_theme' ) );
			}

		}
		$result .= '</span>';
		$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}



if (!function_exists('profile_top')) {
	function profile_top($user_id,$counters) {

		$result = '';
		$result .= print_css_links('profile_top');
		$result .= '<div class="profile_header" data-userid="'.$user_id.'">';
		$result .= '<div class="wrap">';
		if (function_exists('profile_logo')) {
			$result .= profile_logo($user_id);
		}
		if (function_exists('profile_main')) {
			$result .= profile_main($user_id);
		}
		if (function_exists('profile_card')) {
			$result .= profile_card($user_id);
		}
		if (function_exists('profile_bar')) {
			$result .= profile_bar($user_id,$counters);
		}
		$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}
if (!function_exists('profile_card')) {
	function profile_card($user_id) {
		$all_rates = get_field('all_rates','user_'.$user_id);
		$good_rates = intval(get_field('good_rates','user_' . $user_id));

		if (get_field('all_rates','user_'.$user_id)) {
			if (get_field('all_rates','user_'.$user_id) > 0) {
				$numberrate = '<span class="color_green">+'.get_field('all_rates','user_'.$user_id).'</span>';
				//$numberold = get_field('all_rates','user_'.$user_id);
			} elseif (get_field('all_rates','user_'.$user_id) < 0) {
				$numberrate = '<span class="color_red">'.get_field('all_rates','user_'.$user_id).'</span>';
				//$numberold = get_field('all_rates','user_'.$user_id);
			} else {
				$numberrate = '<span class="color_medium_gray">0</span>';
				//$numberold = 0;
			}
		} else {
			$numberrate = '<span class="color_medium_gray">0</span>';
			//$numberold = 0;
		}
		$result = '';
		$result .= print_js_links()['user_profile'];
		$result .= '<div class="profile_card">';
		$result .= '<div class="number_profile font_medium_new">'.$numberrate.'</div>';
		$result .= '<div class="user_site font_small">';
		$all_rates_minus = abs(intval($all_rates) - intval($good_rates));
        $current_language = get_locale();
        if($current_language != 'ru_RU') {
            $result .= '<span class="profile_usermetr"></span><span class="color_dark_blue"><span class="this-number-profile_plus">'.$good_rates.'</span> <span class="plus_name">'.counted_text($good_rates,__('plus','er_theme'),__('pluses','er_theme'),__('pluses','er_theme')).'</span> and <span class="this-number-profile_minus">'.$all_rates_minus.'</span>  <span class="minus_name">'.counted_text($all_rates_minus,__('minus','er_theme'),__('minuses','er_theme'),__('minuses','er_theme')).'</span></span>';
        } else {
            $result .= '<span class="profile_usermetr"></span><span class="color_dark_blue"><span class="this-number-profile_plus">'.$good_rates.'</span> <span class="plus_name">'.counted_text($good_rates,__('плюс','er_theme'),__('плюса','er_theme'),__('плюсов','er_theme')).'</span> и <span class="this-number-profile_minus">'.$all_rates_minus.'</span>  <span class="minus_name">'.counted_text($all_rates_minus,__('минус','er_theme'),__('минуса','er_theme'),__('минусов','er_theme')).'</span></span>';
        }

		$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('profile_main')) {
	function profile_main($user_id) {
		$result = '';
		$result .= '<div class="profile_main"><div class="profile_main_header">';

		$userdata = get_userdata( $user_id );

		if ($userdata->first_name && !$userdata->last_name) {
			$user_title = $userdata->first_name;
		} elseif (!$userdata->first_name && $userdata->last_name) {
			$user_title = $userdata->last_name;
		} elseif ($userdata->first_name && $userdata->last_name) {
			$user_title = $userdata->first_name . ' ' . $userdata->last_name;
		} else {
			$user_title = $userdata->user_nicename;
		}




		$regdate = get_user_reg_date($user_id);

		$labelpro = '';

		if (    (    (    get_field('services_user_services','user_'.$user_id)[0] == 84175) || (get_field('services_user_services','user_'.$user_id) == 84175) || (    get_field('services_user_services','user_'.$user_id)[0] == 84178) || (get_field('services_user_services','user_'.$user_id) == 84178)    )    ) {
			$namep = get_field('services_user_services','user_'.$user_id)[0];
			if (get_field('services_user_services','user_'.$user_id)[0] == '') {
				$labelpro = ' <span class="user_label_profile">'.get_the_title($namep).'</span>';
			} else {
				$labelpro = ' <span class="user_label_profile">'.get_the_title($namep).'</span>';
			}

		}

		if($user_title && $user_title != '') {
			$result .= '<div class="profile_user_title font_bold font_medium_new color_dark_blue">'.$user_title.'</div>'.$labelpro.$regdate;
		}
		$result .= '</div><div class="profile_main_footer flex">';

		$rate_from_comments = get_field('rate_from_comments','user_'.$user_id);
		if ($rate_from_comments) {
			$rate_from_comments = floatval( $rate_from_comments );
			$result             .= '<div class="stars flex">';

			if ( $rate_from_comments <= 0.49 ) {
				$rate_empty = 5;
				$arr_list = ['empty','empty','empty','empty','empty'];
			} elseif ( ( $rate_from_comments >= 0.5 ) && ( $rate_from_comments <= 0.99 ) ) {
				$result     .= '<div class="half"></div>';
				$rate_empty = 4;
				$arr_list = ['half','empty','empty','empty','empty'];
			} elseif ( ( $rate_from_comments >= 1 ) && ( $rate_from_comments <= 1.49 ) ) {
				$result     .= '<div class="full"></div>';
				$rate_empty = 4;
				$arr_list = ['full','empty','empty','empty','empty'];
			} elseif (($rate_from_comments >= 1.5) && ($rate_from_comments <= 1.99) ) {
				$result .= '<div class="full"></div>';
				$result .= '<div class="half"></div>';
				$rate_empty = 3;
				$arr_list = ['full','half','empty','empty','empty'];
			} elseif (($rate_from_comments >= 2) && ($rate_from_comments <= 2.49) ) {
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$rate_empty = 3;
				$arr_list = ['full','full','empty','empty','empty'];
			} elseif (($rate_from_comments >= 2.5) && ($rate_from_comments <= 2.99) ) {
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$result .= '<div class="half"></div>';
				$rate_empty = 2;
				$arr_list = ['full','full','half','empty','empty'];
			} elseif (($rate_from_comments >= 3) && ($rate_from_comments <= 3.49) ) {
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$rate_empty = 2;
				$arr_list = ['full','full','full','empty','empty'];
			} elseif (($rate_from_comments >= 3.5) && ($rate_from_comments <= 3.99) ) {
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$result .= '<div class="half"></div>';
				$rate_empty = 1;
				$arr_list = ['full','full','full','half','empty'];
			} elseif (($rate_from_comments >= 4) && ($rate_from_comments <= 4.49) ) {
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$rate_empty = 1;
				$arr_list = ['full','full','full','full','empty'];
			} elseif (($rate_from_comments >= 4.5) && ($rate_from_comments < 4.99) ) {
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$result .= '<div class="half"></div>';
				$rate_empty = 0;
				$arr_list = ['full','full','full','full','half'];
			} elseif (($rate_from_comments == 5)) {
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$result .= '<div class="full"></div>';
				$rate_empty = 0;
				$arr_list = ['full','full','full','full','full'];
			}

			for ($i = 0; $i < $rate_empty; $i++) {
				$result .= '<div class="empty"></div>';
			}

			$result .= '</div>';
			$result .= '<span class="arr_list" data-vals="'.implode(",", $arr_list).'"></span>';
		} else {
			$result .= '<div class="stars flex"><div class="empty"></div><div class="empty"></div><div class="empty"></div><div class="empty"></div><div class="empty"></div></div>';

		}
		$counters = profile_stats_count($user_id);
		$review_count  = $counters['review_count'];
		$abuse_count   = $counters['abuse_count'];
		$result .= '<div class="mini-comment-count-user-header flex_column flex">';
		$result .= '<span class="mini-comment-count-user-header__reviews flex color_dark_gray font_small">Всего отзывов <span class="mini-comment-count-user-header__count color_dark_blue mini-comment-count-user-header__reviewsnumber">'.$review_count.'</span></span>';
		$result .= '<span class="mini-comment-count-user-header__reviews flex "><span class="mini-comment-count-user-header__count mini-comment-count-user-header__abusesnumber link_no_underline color_dark_blue border_no_color font_small">'.$abuse_count.' '.counted_text($abuse_count,__('жалоба','er_theme'),__('жалобы','er_theme'),__('жалоб','er_theme')).'</span></span>';
		$result .= '</div>';
		$result .= '</div>';

		if(function_exists('get_rating_fields_group')) {
			$rating_fields_group = get_rating_fields_group($post->ID);
		} else {
			$rating_fields_group = 0;
		}

		$result .=  get_post_rating($rating_fields_group,'layout');
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('get_user_reg_date')) {
	function get_user_reg_date($user_id) {
		$userdata = get_userdata($user_id);
		$postdate = $userdata->data->user_registered;
		$today = date('Y-m-d'); // today date
		$diff = strtotime($today) - strtotime($postdate);
		$days = (int)$diff/(60*60*24);
		$year = $days / 365;
        $current_language = get_locale();
        if($current_language != 'ru_RU') {
            if ($year >= 1) {
                if (intval($year) == 1) {
                    $regdate = '<span class="font_smaller color_medium_gray register_time_days">registered for 1 year</span>';
                } elseif ((intval($year) == 2) || (intval($year) == 3)  || (intval($year) == 4)) {
                    $regdate = '<span class="font_smaller color_medium_gray register_time_days">registered for '.intval($year).' years</span>';
                } elseif ((intval($year) == 5) || (intval($year) == 6) || (intval($year) == 7) || (intval($year) == 8) || (intval($year) == 9) || (intval($year) == 10)) {
                    $regdate = '<span class="font_smaller color_medium_gray register_time_days">registered for '.intval($year).' years</span>';
                } else {
                    $regdate = '<span class="font_smaller color_medium_gray register_time_days">registered for '.intval($days).' days</span>';
                }
            } else {
                $regdate = '<span class="font_smaller color_medium_gray register_time_days">registered for '.intval($days).' days</span>';
            }
        } else {
            if ($year >= 1) {
                if (intval($year) == 1) {
                    $regdate = '<span class="font_smaller color_medium_gray register_time_days">на сайте 1 год</span>';
                } elseif ((intval($year) == 2) || (intval($year) == 3)  || (intval($year) == 4)) {
                    $regdate = '<span class="font_smaller color_medium_gray register_time_days">на сайте '.intval($year).' года</span>';
                } elseif ((intval($year) == 5) || (intval($year) == 6) || (intval($year) == 7) || (intval($year) == 8) || (intval($year) == 9) || (intval($year) == 10)) {
                    $regdate = '<span class="font_smaller color_medium_gray register_time_days">на сайте '.intval($year).' лет</span>';
                } else {
                    $regdate = '<span class="font_smaller color_medium_gray register_time_days">на сайте '.intval($days).' дней</span>';
                }
            } else {
                $regdate = '<span class="font_smaller color_medium_gray register_time_days">на сайте '.intval($days).' дней</span>';
            }
        }

		return $regdate;
	}
}
if (!function_exists('profile_bar')) {
	function profile_bar($user_id,$counters) {
		$result = '';
		$result .= '<div class="profile_bar flex">';
		if (function_exists('profile_links')) {
			$result .= profile_links($user_id,$counters);
		}
//		if (function_exists('review_icons')) {
//			$result .= review_icons();
//		}
		$result .= '</div>';
		return $result;
	}
}

if (!function_exists('profile_links')) {
	function profile_links($user_id,$counters) {
		$result = '';
		$result .= print_css_links('review_links');
		$result .= print_js_links()['review_tabs'];
		$review_count  = $counters['review_count'];
		$abuse_count   = $counters['abuse_count'];
		$comment_count = $counters['comment_count'];
		$posts_count = $counters['posts_count'];
        $current_language = get_locale();
        if($current_language != 'ru_RU') {
            $result .= '<ul class="review_links font_uppercase flex font_smaller_2 font_bolder color_dark_gray">';
            $result .= '<li class="review_link_user pointer active color_dark_blue" data-tab="review_container_about">'.__('Information','er_theme').'</li>';
            if ($review_count != 0) {
                $result .= '<li class="review_link_user pointer" data-tab="review_container_comments_profile">'.__('Reviews','er_theme').'</li>';
            }
            if ($posts_count != 0) {
                $result .= '<li class="review_link_user pointer" data-tab="review_container_reviews_profile">'.__('Company Overviews','er_theme').'</li>';
            }
            if ($abuse_count != 0) {
                $result .= '<li class="review_link_user pointer" data-tab="review_container_abuses_profile">'.__('Complaints','er_theme').'</li>';
            }
            $result .= '</ul>';
            if (   !( (    get_field('user_activation', 'user_'.$user_id ) == '') || (get_field('user_activation', 'user_'. $user_id ) == 'no'))) {
                $result .= '<div class="profilebar_status status_verified font_smaller">Verified profile</div>';
            }
        } else {
            $result .= '<ul class="review_links font_uppercase flex font_smaller_2 font_bolder color_dark_gray">';
            $result .= '<li class="review_link_user pointer active color_dark_blue" data-tab="review_container_about">'.__('Информация','er_theme').'</li>';
            if ($review_count != 0) {
                $result .= '<li class="review_link_user pointer" data-tab="review_container_comments_profile">'.__('Отзывы','er_theme').'</li>';
            }
            if ($posts_count != 0) {
                $result .= '<li class="review_link_user pointer" data-tab="review_container_reviews_profile">'.__('Обзоры','er_theme').'</li>';
            }
            if ($abuse_count != 0) {
                $result .= '<li class="review_link_user pointer" data-tab="review_container_abuses_profile">'.__('Жалобы','er_theme').'</li>';
            }
            $result .= '</ul>';
            if (   !( (    get_field('user_activation', 'user_'.$user_id ) == '') || (get_field('user_activation', 'user_'. $user_id ) == 'no'))) {
                $result .= '<div class="profilebar_status status_verified font_smaller">Подтвержденный профиль</div>';
            }
        }

		return $result;
	}
}

if (!function_exists('profile_icons')) {
	function profile_icons() {
		$result = '';
		$result .= print_css_links('review_icons');
		$result .= '<ul class="profile_icons">';
		$result .= '<li class="profile_icon_favorites pointer"></li>';
		$result .= '<li class="profile_icon_share pointer"></li>';
		$result .= '</ul>';
		return $result;
	}
}


if (!function_exists('updownrate')) {
	add_action('wp_ajax_updownrate', 'updownrate');
	add_action('wp_ajax_nopriv_updownrate', 'updownrate');

	function updownrate()
	{
		$profile_user_id     = $_POST['user_id'];
		$comment_id = $_POST['user_id'];
		$cookie_plus = 'rate_plus_'.$_POST['user_id'];
		$cookie_minus = 'rate_minus_'.$_POST['user_id'];
		$plus_exists = check_cookie($cookie_plus);
		$minus_exists = check_cookie($cookie_minus);
		$rate_action = $_POST['rate_action'];
		$profile_user_id_arr = get_comment( $profile_user_id );
		$profile_user_id = $profile_user_id_arr->user_id;
		$thisnumber_rate     = intval($_POST['thisnumber_rate']);
		$status              = [];
		$get_current_user_id = get_current_user_id();
		$all_rates_gl = 0;
		$good_rates_gl = 0;
		$all_rates_minus = 0;

		if ( is_user_logged_in() ) {
			if ( $profile_user_id == $get_current_user_id ) {
				$message = 'Вы не можете проголосать за себя';
				$status  = 'error';
			} else {
				$all_rates = intval(get_field('all_rates','user_' . $profile_user_id));
				$who_rate_golos_user_com = get_field( 'who_rate_golos_user_com', 'comment_' . $comment_id );
				$good_rates = intval(get_field('good_rates','user_' . $profile_user_id));
				//$who_rate_golos_user_com = explode( ',', $who_rate_golos_user_com );

				$who_rate_golos_user_com = explode('|',$who_rate_golos_user_com);
				if (count($who_rate_golos_user_com) != 0) {
					$tmArr_2 = [];
					foreach ( $who_rate_golos_user_com as $item ) {
						$tmArr_2[] = explode( ',', $item );
					}
				} else {
					$tmArr_2 = [];
				}

				if ( in_array( [$get_current_user_id,$thisnumber_rate], $tmArr_2 ) ) {
					$message = 'Вы уже голосовали';
					$status  = 'error';
				} elseif (( in_array( [$get_current_user_id,$thisnumber_rate*-1], $tmArr_2 ) )) {
					$message = 'Вы отменили Ваш голос';
					$status  = 'ok';
					if ($thisnumber_rate == 1) {

						$all_rates = $all_rates + 1;
						update_field('all_rates',$all_rates,'user_' . $profile_user_id);
					} elseif ($thisnumber_rate == -1) {
						$good_rates = $good_rates - 1;
						update_field('good_rates',$good_rates,'user_' . $profile_user_id);
						$all_rates = $all_rates - 1;
						update_field('all_rates',$all_rates,'user_' . $profile_user_id);
					}

					if (($key = array_search([$get_current_user_id,$thisnumber_rate*-1], $tmArr_2)) !== false) {
						unset($tmArr_2[$key]);
					}

					$tmpArr = array();
					foreach ($tmArr_2 as $sub) {
						$tmpArr[] = implode(',', $sub);
					}
					$result = implode('|', $tmpArr);
					update_field('who_rate_golos_user_com',$result,'comment_'.$comment_id);

					$all_rates_gl = intval(get_field('all_rates','user_' . $profile_user_id));
					$good_rates_gl = intval(get_field('good_rates','user_' . $profile_user_id));

					$all_rates_minus = abs(intval($all_rates_gl) - intval($good_rates_gl));

				} else {

					if ( count( $status ) == 0 ) {
						$message = 'Ваш голос был учтен';
						$status  = 'ok';
						if ($thisnumber_rate == 1) {

							$good_rates = $good_rates + 1;
							update_field('good_rates',$good_rates,'user_' . $profile_user_id);

							$all_rates = $all_rates + 1;
							update_field('all_rates',$all_rates,'user_' . $profile_user_id);
						} elseif ($thisnumber_rate == -1) {

							$all_rates = $all_rates - 1;
							update_field('all_rates',$all_rates,'user_' . $profile_user_id);
						}

						$array_push = [$get_current_user_id,$thisnumber_rate];
						array_push($tmArr_2, $array_push);

						$tmpArr = array();
						foreach ($tmArr_2 as $sub) {
							$tmpArr[] = implode(',', $sub);
						}
						$result = implode('|', $tmpArr);
						update_field('who_rate_golos_user_com',$result,'comment_'.$comment_id);

						$all_rates_gl = intval(get_field('all_rates','user_' . $profile_user_id));
						$good_rates_gl = intval(get_field('good_rates','user_' . $profile_user_id));

						$all_rates_minus = abs(intval($all_rates_gl) - intval($good_rates_gl));
					}
				}

			}
		} else {
			if($rate_action == 'plus' && $plus_exists == 'no' && $minus_exists == 'no') {
				//добавляю в минус - 1
				$minus_anon = intval(get_field('minus_anon','comment_'.$comment_id))-1;
				update_field('minus_anon',$minus_anon,'comment_'.$comment_id);
			} elseif($rate_action == 'plus' && $plus_exists == 'yes' && $minus_exists == 'no') {
				//добавляю в плюс + 1
				$plus_anon = intval(get_field('plus_anon','comment_'.$comment_id))+1;
				update_field('plus_anon',$plus_anon,'comment_'.$comment_id);
			} elseif($rate_action == 'minus' && $plus_exists == 'no' && $minus_exists == 'yes') {
				//добавляю в минус + 1
				$minus_anon = intval(get_field('minus_anon','comment_'.$comment_id))+1;
				update_field('minus_anon',$minus_anon,'comment_'.$comment_id);
			} elseif($rate_action == 'minus' && $plus_exists == 'yes' && $minus_exists == 'no') {

			} elseif($rate_action == 'plus' && $plus_exists == 'no' && $minus_exists == 'yes') {

			} elseif($rate_action == 'minus' && $plus_exists == 'no' && $minus_exists == 'no') {
				//добавляю в плюс - 1
				$plus_anon = intval(get_field('plus_anon','comment_'.$comment_id))-1;
				update_field('plus_anon',$plus_anon,'comment_'.$comment_id);
			}
			$message = 'Необходимо авторизоваться'.$rate_action.$plus_exists.$minus_exists;
			$status  = 'error';
		}

		$who_rate_golos_user_com = get_field( 'who_rate_golos_user_com', 'comment_' . $comment_id );

		//$who_rate_golos_user_com = explode( ',', $who_rate_golos_user_com );

		$who_rate_golos_user_com = explode('|',$who_rate_golos_user_com);
		if (count($who_rate_golos_user_com) != 0) {
			$tmArr_2 = [];
			foreach ( $who_rate_golos_user_com as $item ) {
				$tmArr_2[] = explode( ',', $item );
			}
		} else {
			$tmArr_2 = [];
		}
		$i = 0;
		$arr_Ocenki = [];
		$positive_array = 0;
		$minus_array = 0;
		foreach ( $tmArr_2 as $item ) {
			if ($i == 0) {

			} else {
				if (intval($item[1]) > 0) {
					$positive_array = ++$positive_array;
				} else {
					$minus_array = ++$minus_array;
				}
				$arr_Ocenki[] = intval($item[1]);
			}
			$i = ++$i;
		}
		//echo $positive_array.' '.$minus_array;

		$plus_anon = intval(get_field('plus_anon','comment_'.$comment_id));
		$minus_anon = intval(get_field('minus_anon','comment_'.$comment_id));
		$positive_array = $positive_array + $plus_anon;
		$minus_array = $minus_array + $minus_anon;

        $current_language = get_locale();
        if($current_language != 'ru_RU') {
            $result = ['message' => $message, 'status' => $status, 'all_rates_gl' => $all_rates_gl, 'good_rates_gl' => $good_rates_gl,'all_rates_minus' => $all_rates_minus, 'plus_name' => counted_text($good_rates_gl,__('plus','er_theme'),__('pluses','er_theme'),__('pluses','er_theme')), 'minus_name' => counted_text($all_rates_minus,__('minus','er_theme'),__('minuses','er_theme'),__('minuses','er_theme')), 'positive_array' => $positive_array, 'minus_array' => $minus_array ];
        } else {
            $result = ['message' => $message, 'status' => $status, 'all_rates_gl' => $all_rates_gl, 'good_rates_gl' => $good_rates_gl,'all_rates_minus' => $all_rates_minus, 'plus_name' => counted_text($good_rates_gl,__('плюс','er_theme'),__('плюса','er_theme'),__('плюсов','er_theme')), 'minus_name' => counted_text($all_rates_minus,__('минус','er_theme'),__('минуса','er_theme'),__('минусов','er_theme')), 'positive_array' => $positive_array, 'minus_array' => $minus_array ];
        }

		echo json_encode($result);
		die;
	}
}

if (!function_exists('profile_stats_count_abuses')) {
	function profile_stats_count_abuses( $userid ) {
		$args_abuse = [
			'status'     => 'approve',
			'user_id'    => $userid,
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
			'user_id'    => $userid,
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
			'user_id'    => $userid,
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
			'user_id'    => $userid,
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
if (!function_exists('profile_stats_menu_count')) {
	function profile_stats_menu_count( $userid ) {
		$args_abuse_menu = [
			'status'     => 'approve',
			'user_id'    => $userid,
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				],
				/*[
					'key'	 	=> 'abuse_state',
					'compare' => 'NOT EXISTS',
					'value' => ''
				]*/
				[
					'key'	 	=> 'abuse_state',
					'value'	  	=> 'not_seen',
					'compare' 	=> '=',
				]
			]
		];
		$abuse_menu = count( get_comments( $args_abuse_menu ) );

		$args_comments_menu = [
			'status'       => 'approve',
			'user_id'      => $userid,
			'comment_type' => 'comment',
			'meta_query'   => [
				'relation' => 'AND',
				[
					'key'     => 'comment_type',
					'value'   => 'comments',
					'compare' => '=',
				]
			],
			'comment_date' => '2021-04-07'
		];
		$comments_menu = count( get_comments( $args_comments_menu ) );

		return ['abuse_menu' => $abuse_menu,'comments_menu' => $comments_menu];

	}
}

if (!function_exists('profile_stats_count')) {
	function profile_stats_count($userid) {
		$args_reviews = [
			'status'       => 'approve',
			'user_id'      => $userid,
			'count' => true,
			'meta_query'   => [
				'relation' => 'AND',
				[
					'key'     => 'comment_type',
					'value'   => 'reviews',
					'compare' => '=',
				]
			]
		];

		$args_comments = [
			'status'       => 'approve',
			'user_id'      => $userid,
			'meta_query'   => [
				'relation' => 'AND',
				[
					'key'     => 'comment_type',
					'value'   => 'reviews',
					'compare' => '!=',
				],
				[
					'relation' => 'OR',
					[
						'key'     => 'is_abuse',
						'value'   => 1,
						'compare' => '!='
					],
					[
						'key'     => 'is_abuse',
						'compare' => 'NOT EXISTS'
					]
				]
			]
		];

		$args_abuse = [
			'status'     => 'approve',
			'user_id'    => $userid,
			'count' => true,
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				]
			]
		];

		$args_comments_all = [
			'status'       => 'approve',
			'user_id'      => $userid,
			'count' => true
		];
		$review_count  = get_comments( $args_reviews ) ;
		$abuse_count   = get_comments( $args_abuse ) ;
		$comment_count = get_comments( $args_comments ) ;
		$comment_count = count($comment_count);
		$comment_count_all = get_comments( $args_comments_all ) ;

		$posts_count = count_user_posts( $userid, 'casino', true );

		return ['review_count' => $review_count,'abuse_count' => $abuse_count,'comment_count' => $comment_count, 'posts_count' => $posts_count, 'comment_count_all' => $comment_count_all];
	}
}
if ( ! function_exists( 'profile_comments' ) ) {
	function profile_comments( $userid, $counters = NULL, $type = NULL ) {


		$user_skills = get_field( 'user_skills', 'user_' . $userid );

		$result = '';
		if ( $type != 'skills' ) {

			$review_count  = $counters['review_count'];
			$abuse_count   = $counters['abuse_count'];
			$comment_count = $counters['comment_count'];
			$comment_count_all = $counters['comment_count_all'];
			$posts_count   = $counters['posts_count'];

			if ( $posts_count != 0 ) {
				$result .= print_css_links( 'list_post_single' );
			}

			if ( ( $review_count != 0 ) || ( $abuse_count != 0 ) || ( $comment_count != 0 ) || ($comment_count_all != 0) ) {

			}
			$result .= wp_enqueue_style( 'comments', get_template_directory_uri() . '/css/comments.css' );
		}

		if (( $type == 'skills' ) || ($type == 'dashboard') ) {
			$result .= '<div class="comment_bar_info border_radius_4px">';
		} else {
			$result .= '<div class="comment_bar_info white_block">';
		}
		if ( $type == 'skills' ) {
			$result .= '<div class="skills-comments skills-comments__header"><span class="skills-comments__title color_dark_blue font_bold font_uppercase">Мои интересы</span></div>';
		}
		if ( $type != 'skills' ) {
			$result .= '<div class="table-comments-info">';
			$result .= '<div class="table-comments-info__itemcomments"><span class="itemcomments__number color_dark_blue font_bold">' . $review_count . '</span><span
                                class="itemcomments__title color_dark_gray">Отзывы</span></div>';
			$result .= '<div class="table-comments-info__itemcomments"><span class="itemcomments__number color_dark_blue font_bold">' . $abuse_count . '</span><span
                                class="itemcomments__title color_dark_gray">Жалобы</span></div>';
			$result .= '<div class="table-comments-info__itemcomments"><span class="itemcomments__number color_dark_blue font_bold">' . $comment_count . '</span><span
                                class="itemcomments__title color_dark_gray">Комментарии</span></div>';
			$result .= '<div class="table-comments-info__itemcomments"><span class="itemcomments__number color_dark_blue font_bold">' . $posts_count . '</span><span
                                class="itemcomments__title color_dark_gray">Обзоры</span></div>';
			$result .= '</div>';
		}
		$current_user = wp_get_current_user();
		$current_user_id = $current_user->data->ID;
		if ((get_query_var('user_profile')  == 'user_profile') && (count($user_skills) == 0) && ($userid != $current_user_id)) {

		} else {

			if ( $type == 'skills' ) {
				$result .= '<div class="skills-comments skills-comments__footer">';
			} else {
				$result .= '<div class="skills-comments">';
			}

			if ( $type != 'skills' ) {
				$result .= '<span class="skills-comments__title color_dark_blue font_bold font_uppercase skills-comments__title_border">Интересы</span>';
			}
			$result .= '<span class="skills-comments__myskill-wrapper font_small color_dark_blue">';
			foreach ( $user_skills as $item ) {
				$result .= '<span class="skills-comments__myskill" data-skill="' . get_term( $item, 'affiliate-tags' )->term_id . '">' . get_field('tag_human_title','term_'.get_term( $item, 'affiliate-tags' )->term_id) . '</span>';
			}
			$result .= '</span>';
			$result .= '<span class="skills-comments__add grey_color_bg color_dark_blue pointer">Добавить</span>';
			if ( get_current_user_id() == $userid ) {
				$result .= '<span class="edit-button-profile pointer"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M4.12379 15.0227L0.181736 15.0338L0.173828 11.0728L10.8783 0.456075C11.0223 0.311518 11.1933 0.196807 11.3817 0.118542C11.5702 0.0402772 11.7722 0 11.9763 0C12.1803 0 12.3823 0.0402772 12.5708 0.118542C12.7592 0.196807 12.9303 0.311518 13.0744 0.456075L14.7176 2.10715C14.8623 2.25175 14.977 2.42343 15.0553 2.61239C15.1336 2.80134 15.1738 3.00387 15.1738 3.2084C15.1738 3.41293 15.1336 3.61546 15.0553 3.80441C14.977 3.99337 14.8623 4.16505 14.7176 4.30965L4.12379 15.0227ZM1.75381 13.4427H4.12379L1.75381 11.0728V13.4427ZM11.9763 1.55732L3.33379 10.2828L4.91378 11.8628L13.6195 3.2084L11.9763 1.55732Z" fill="#001640"/>
</svg>
</span>';
			}
			$result .= '</div>';
		}
		//if ( $type != 'skills' ) {
		$result .= '</div>';
		//}

		return $result;
	}
}

if (!function_exists('profile_container_about')) {
	function profile_container_about($userid,$counters = NULL,$type = NULL,$show = 'no') {


		$user_desc = get_field('user_desc','user_'.$userid);
		$result = '';
		if ($type != 'desc') {
			$result .= profile_comments($userid,$counters);
		}

		if (($user_desc) || ($show == 'show')) {
			$result .= print_js_links()['show_block'];
			$result .= print_css_links('show_block');
			if ((($user_desc == '') || ($user_desc == 'undefined')) && ($show == 'show')) {
				$user_desc = '<span class="text_undefined">Здесь вы можете указать информацию о себе</span>';
			}
			if ($type == 'desc') {
				$result .= '<div class="user-desc user-desc__border border_radius_4px">';
				$result .= '<div class="button button_gray pointer button_nopadding font_bold create_review mb20 edit_your_about isdesctop">Редактировать текст о себе</div>';
				$result .= '<div class="button button_gray pointer button_nopadding font_bold create_review mb20 edit_your_about ismobile_flex">Редактировать</div>';
				$result .= '<div class="user-desc__text_user-editor">'.$user_desc.'</div>';
			} else {
				if ($user_desc != 'undefined') {
				$result .= '<div class="user-desc">';
				$result .= '<div class="user-desc__text">'.$user_desc.'</div>';
				$result .= '<div class="color_dark_gray font_small link_review_map link_dropdown link_inactive show_block" data-block=".user-desc__text" data-type="swipeDown">Читать полностью</div>';
				}
			}
			if ($user_desc != 'undefined') {
			$result .= '</div>';
			}
		}
		return $result;
	}
}

if (!function_exists('review_container_comments_profile')) {
	function review_container_comments_profile() {
		$result = '<ul id="reviews" class="review-user-profile"></ul>';
		$result .= wp_enqueue_script( 'ajax-comments', get_template_directory_uri() . '/js/ajax-comments.js', array('jquery') );
		return $result;
	}
}

if (!function_exists('review_container_abuses_profile')) {
	function review_container_abuses_profile() {
		$result = '<ul id="abuses"></ul>';
		$result .= wp_enqueue_script( 'ajax-abuses', get_template_directory_uri() . '/js/ajax-abuses.js', array('jquery') );
		return $result;
	}
}

if (!function_exists('ajax_subscribe_user')) {
	add_action( 'wp_ajax_ajax_subscribe_user', 'ajax_subscribe_user' );
	add_action( 'wp_ajax_nopriv_ajax_subscribe_user', 'ajax_subscribe_user' );
	function ajax_subscribe_user() {
		$data = $_POST;
		$result = array();
		if(!is_user_logged_in()) {
			$result['status'] = 'auth';
			$result['message'] = __('Чтобы подписаться на обновления компании, пожалуйста, авторизуйтесь на сайте.','er_theme');
		} else {
			$current_user = wp_get_current_user();
			$user_id = $current_user->data->ID;
			$current = get_field('user_subscriptions_users','user_'.$user_id);
			if (intval($user_id) != intval($data['userid'])) {
				if(empty($current)) {
					update_field('user_subscriptions_users',array($data['userid']),'user_'.$user_id);
					$result['status'] = 'added';
					$result['message'] = __('Вы успешно подписались','er_theme');
				} else {
					if(!in_array($data['userid'],$current)) {
						$current[] = $data['userid'];
						update_field('user_subscriptions_users',$current,'user_'.$user_id);
						$result['status'] = 'added';
						$result['message'] = __('Вы успешно подписались','er_theme');
					}  else {
						if (($key = array_search($data['userid'], $current)) !== false) {
							unset($current[$key]);
							update_field('user_subscriptions_users',$current,'user_'.$user_id);
						}
						$result['status'] = 'deleted';
						$result['message'] = __('Подписаться на эту компанию','er_theme');
					}
				}
			} else {
				$result['status'] = 'this';
				$result['message'] = __('Вы успешно подписались','er_theme');
			}

		}
		echo json_encode($result);

		die;
	}
}



function list_post_single($postid,$userid,$post_type) {
	$result = '';
	$attachment_id = get_field('photo_profile', 'user_'. $userid );
	$comment_author = get_userdata( $userid );

	$labelpro = '';
	if (    (    (    get_field('services_user_services','user_'.$userid)[0] == 84175) || (get_field('services_user_services','user_'.$userid) == 84175) || (    get_field('services_user_services','user_'.$userid)[0] == 84178) || (get_field('services_user_services','user_'.$userid) == 84178)    )    ) {
		$namep = get_field('services_user_services','user_'.$userid)[0];
		if (get_field('services_user_services','user_'.$userid)[0] == '') {
			$labelpro = ' <span class="label-pro user_label font_smaller label-pro-comments">'.get_the_title($namep).'</span>';
		} else {
			$labelpro = ' <span class="label-pro user_label font_smaller label-pro-comments">'.get_the_title($namep).'</span>';
		}
	} else {
		$labelpro = '';
	}

	if (get_field('pub_profile', 'user_'.$userid) == 'yes') {
		$pubprofile = ' data-pub="1" ';
	} else {
		$pubprofile = '';
	}
	if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') {
		$styleImgAvatar = 'style="background-image: url('.$attachment_id['sizes']['thumbnail'].')"';
	} else {
		$styleImgAvatar = '';
	}
	if(is_registered_from_social($userid)['main'] && is_registered_from_social($userid)['main'] != 'none') { $social_provider_registered = '<div class="social_provider_registered '.is_registered_from_social($userid)['main'].'"></div>'; } else {
		$social_provider_registered = '';
	}

	if($comment_author->first_name && !$comment_author->last_name) { $textname = $comment_author->first_name; } elseif(!$comment_author->first_name && $comment_author->last_name) { $textname = $comment_author->last_name; } elseif($comment_author->first_name && $comment_author->last_name) { $textname = $comment_author->first_name.' '.$comment_author->last_name; } else { $textname = $comment_author->user_nicename; }

	$result .= '<div class="list-post-single">';
	$result .= '    <div class="list-post-single__header flex">';
	$result .= '        <div class="list-post-single__avatar" '.$pubprofile.' data-link="https://etorazvod.ru/user/'.$comment_author->user_nicename.'/" '.$styleImgAvatar.'>'.$social_provider_registered.'</div>';
	$result .= '        <div class="list-post-single__meta">';
	$result .= '            <div class="list-post-single__author_wrapper">';
	$result .= '                <span class="list-post-single__author font_bold font_small color_dark_blue" itemprop="author" data-link="https://etorazvod.ru/user/'.$comment_author->user_nicename.'/" '.$pubprofile.'>'.$textname.'</span>';
	$result .= '                '.$labelpro.' <span class="list-post-single__metalist-post-single__to_id color_dark_gray font_small">заказал(а) обзор на компанию <a href="'.get_the_permalink($postid).'" class="color_dark_blue link_no_underline hover_dark font_bold">'.get_field("company_name",$postid).'</a></span>';
	$result .= '            </div>';
	$result .= '            <span class="list-post-single__date font_small color_dark_gray" itemprop="datePublished" content="'.get_the_date( 'Y-m-d',$postid ).'">'.get_the_date( 'j F Y',$postid ).'</span>';
	$result .= '        </div>';
	$result .= '    </div>';
	$result .= '<div class="list-post-single__content-wrapper">';
	$result .= '    <span class="list-post-single__title list-post-single__title font_medium_new font_bold color_dark_blue">'.get_the_title($postid).'</span>';
	$result .= '    <div class="list-post-single__content font_18">';
	//$get_the_content = mb_substr(wp_filter_nohtml_kses(get_the_content($postid)), 0, 300, "utf-8");
	$get_the_content = wp_filter_nohtml_kses(get_the_content($postid));
	$get_the_content = str_replace("[toc]", '', $get_the_content);
	$get_the_content = explode('.',$get_the_content);

	$result .=  $get_the_content[0].'. '.$get_the_content[1].'. '.$get_the_content[2].'. ';
	$result .= '    </div>';
	$result .= '    <a href="'.get_the_permalink($postid).'" class="m_t_15 button-user-profile display-block review_block_main_button button button_bigger font_medium font_bold button_violet pointer link_no_underline" target="_blank">Перейти на обзор</a>';
	$result .= '</div>';
	$result .= '</div>';
	return $result;
}


if (!function_exists('get_user_posts')) {
	add_action( 'wp_ajax_get_user_posts', 'get_user_posts' );
	add_action( 'wp_ajax_nopriv_get_user_posts', 'get_user_posts' );
	function get_user_posts() {
		$userid = $_POST['user_id'];
		$sort_type = $_POST['sort_type'];
		global $post;
		$result = print_js_links()['events'];
		$result .= '<div class="white_block profile_top flex">';
		$result .= '   <div class="profile_top_title font_uppercase font_bold color_dark_blue font_small">Обзоры</div>';
		$result .= '   <div class="profile_top_count font_bold color_dark_gray">'.count_user_posts( $userid, 'casino', true ).'</div>';
		$result .= '   <div class="profile_sorter font_smaller">';
		$result .= '      <div class="profile_sorter_title color_dark_gray pointer dropdown flex">Отсортировать по</div>';
		$result .= '      <ul class="font_smaller">';
		if ( $sort_type == 'new' ) {
			$result .= '         <li class="sort_new color_dark_gray pointer active" data-sort-type="new">Сначала новые</li>';
		} else {
			$result .= '         <li class="sort_new color_dark_gray pointer" data-sort-type="new">Сначала новые</li>';
		}


		if ( $sort_type == 'best' ) {
			$result .= '         <li class="sort_best color_dark_gray pointer active" data-sort-type="best">Сначала популярные</li>';
		} else {
			$result .= '         <li class="sort_best color_dark_gray pointer" data-sort-type="best">Сначала популярные</li>';
		}

		if ( $sort_type == 'old' ) {
			$result .= '         <li class="sort_old color_dark_gray pointer active" data-sort-type="old">Сначала старые</li>';
		} else {
			$result .= '         <li class="sort_old color_dark_gray pointer" data-sort-type="old">Сначала старые</li>';
		}

		$result .= '      </ul>';
		$result .= '   </div>';
		$result .= '</div>';
		if ( $sort_type == 'new' ) {
			$myposts = get_posts( array(
				'author'         => $userid,
				'posts_per_page' => 10,
				'post_type'      => 'casino'
			) );
		} elseif ( $sort_type == 'old' ) {
			$myposts = get_posts( array(
				'author'         => $userid,
				'posts_per_page' => 10,
				'post_type'      => 'casino',
				'orderby'        => 'date',
				'order'          => 'ASC',
			) );
		} elseif ( $sort_type == 'best' ) {
			$myposts = get_posts( array(
				'author'         => $userid,
				'posts_per_page' => 10,
				'post_type'      => 'casino',
				'orderby'        => 'date',
				'order'          => 'ASC',
			) );
		}


		foreach( $myposts as $post ){
			setup_postdata( $post );
			$result .= list_post_single(get_the_ID(),$userid,'casino');
		}
		$result .= '</div>';

		wp_reset_postdata();

		echo $result;
		die;
	}
}

if (!function_exists('review_container_reviews_profile')) {
	function review_container_reviews_profile($userid) {
		$result = '<div class="profile_posts_wrapper"></div>';
		$result .= wp_enqueue_script( 'ajax-posts', get_template_directory_uri() . '/js/ajax-posts.js', array('jquery') );
		return $result;
	}
}

if ( ! function_exists( 'user_skills_remove' ) ) {
	add_action( 'wp_ajax_user_skills_remove', 'user_skills_remove' );
	add_action( 'wp_ajax_nopriv_user_skills_remove', 'user_skills_remove' );
	function user_skills_remove() {
		if ( is_user_logged_in() ) {
			$current_user  = wp_get_current_user();
			$user_id       = intval( $current_user->data->ID );
			$skills        = get_field( 'user_skills', 'user_' . $user_id );
			$removeskillid = intval( $_POST['id'] );
			if ( ( $key = array_search( $removeskillid, $skills ) ) !== false ) {
				unset( $skills[ $key ] );
				update_field( 'user_skills', $skills, 'user_' . $user_id );
			}
			
			
			
			if (get_field('id_base_dashamail','term_'.$removeskillid)) {
				$id_base = intval(get_field('id_base_dashamail','term_'.$removeskillid));
				$api_key = 'e9c51614cdd55d1e810e44e5499d8d77';
				$email = $current_user->user_email;
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
			}
			
			
			echo json_encode( $skills );
		}
		die;
	}
}

if ( ! function_exists( 'user_skills_add' ) ) {
	add_action( 'wp_ajax_user_skills_add', 'user_skills_add' );
	add_action( 'wp_ajax_nopriv_user_skills_add', 'user_skills_add' );
	function user_skills_add() {
		if ( is_user_logged_in() ) {
			$current_user  = wp_get_current_user();
			$user_id       = intval( $current_user->data->ID );
			$skills        = get_field( 'user_skills', 'user_' . $user_id );
			$removeskillid = intval( $_POST['id'] );

			if(!in_array($removeskillid,$skills)) {
				$skills[] = $removeskillid;
				update_field( 'user_skills', $skills, 'user_' . $user_id );
				echo '<span class="skills-comments__myskill" data-skill="'.get_term($removeskillid,'affiliate-tags')->term_id.'">' . get_field('tag_human_title','term_'.get_term($removeskillid,'affiliate-tags')->term_id) . '</span>';
			}

		}
		die;
	}
}
if ( ! function_exists( 'user_skills_add_mass' ) ) {
	add_action( 'wp_ajax_user_skills_add_mass', 'user_skills_add_mass' );
	add_action( 'wp_ajax_nopriv_user_skills_add_mass', 'user_skills_add_mass' );
	function user_skills_add_mass() {
		if ( is_user_logged_in() ) {
			$current_user  = wp_get_current_user();
			$user_id       = intval( $current_user->data->ID );
			$skills        = get_field( 'user_skills', 'user_' . $user_id );
			$removeskillid = $_POST['id'];
			$removeskillid_arr = explode(',',$removeskillid);
			$email = $current_user->user_email;
			
			
			
			foreach ($removeskillid_arr  as $item ) {
				if((!in_array(intval($item),$skills)) && (intval($item) != 0)) {
					$skills[] = intval($item);
					update_field( 'user_skills', $skills, 'user_' . $user_id );
					echo '<span class="skills-comments__myskill" data-skill="'.get_term(intval($item),'affiliate-tags')->term_id.'">' . get_field('tag_human_title','term_'.get_term(intval($item),'affiliate-tags')->term_id) . '</span>';
				}
			}
			if (get_field('tematics_send', 'user_'.$user_id)) {
				if ( intval( get_field( 'tematics_send', 'user_' . $user_id ) ) == 1 ) {
					foreach ( $removeskillid_arr as $item ) {
						$term_id = $item;
						if ( intval( $item ) != 0 ) {
							if ( get_field( 'id_base_dashamail', 'term_' . $term_id ) ) {
								$id_base = intval( get_field( 'id_base_dashamail', 'term_' . $term_id ) );
								$id_base = intval( get_field( 'id_base_dashamail', 'term_' . $term_id ) );
								$api_key = 'e9c51614cdd55d1e810e44e5499d8d77';
								
								$add_names = '';
								if (!empty(wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'first_name', true ))))) {
									$add_names .= '&merge_1='.wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'first_name', true )));
								}
								
								if (!empty(wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'last_name', true ))))) {
									$add_names .= '&merge_2='.wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'last_name', true )));
								}
								
								$url = 'https://api.dashamail.ru/?method=lists.add_member&&api_key=e9c51614cdd55d1e810e44e5499d8d77&list_id=' . $id_base . '&email=' . $email .$add_names. '&format=xml';
								
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
								$arr[ 'tematics_p' . $item ] = $response;
							}
						}
					}
				}
			}
			
			
		}
		die;
	}
}

if ( ! function_exists( 'update_user_star_rating' ) ) {
	add_action( 'wp_ajax_update_user_star_rating', 'update_user_star_rating' );
	add_action( 'wp_ajax_nopriv_update_user_star_rating', 'update_user_star_rating' );
	function update_user_star_rating() {
		$userid = intval($_POST['userid']);

		if ( is_user_logged_in() ) {

			$stars = $_POST['stars'];
			$x_pos = $_POST['x_pos'];
			if (intval($x_pos) < 25) {
				$stars = floatval($stars) - 0.5;
			}
			$current_user = wp_get_current_user();
			$current_user_user_id = $current_user->data->ID;


			$star_rate_user_id = get_field('star_rate_user_id','user_'.$userid);
			$rate_from_comments = floatval(get_field('rate_from_comments','user_'.$userid));

			//если  за него  голосовал
			if (($key = array_search($current_user_user_id, array_column($star_rate_user_id, 'userid'))) !== false) {
				//ниже описал для чего эта проверка
				if (count($star_rate_user_id) > 0) {
					unset($star_rate_user_id[$key]);
					update_field('star_rate_user_id',$star_rate_user_id,'user_'.$userid);
					$row = array(
						'userid' => $current_user_user_id,
						'rate' => $stars
					);
					add_row('star_rate_user_id', $row, 'user_'.$userid);
					$star_rate_user_id_temp = get_field('star_rate_user_id','user_'.$userid);
					$star_rate_user_id_rates_temp = array_column($star_rate_user_id_temp, 'rate');
					$star_rate_user_id_rates_sum = array_sum($star_rate_user_id_rates_temp);
					update_field('rate_from_comments',$star_rate_user_id_rates_sum,'user_'.$userid);
					//ниже если не голосовал (это фикс бага или фичи array_search через array_column), при пустом массиве он отдает true, а эта штука его фиксить
				} else {
					$row = array(
						'userid' => $current_user_user_id,
						'rate' => $stars
					);
					add_row('star_rate_user_id', $row, 'user_'.$userid);

					if ($rate_from_comments == 0) {
						update_field('rate_from_comments',$stars,'user_'.$userid);
					} else {
						$rate_from_comments = ($rate_from_comments + $stars) / 2;
						update_field('rate_from_comments',$rate_from_comments,'user_'.$userid);
					}
				}
				//ниже если не голосовал
			} else {
				$row = array(
					'userid' => $current_user_user_id,
					'rate' => $stars
				);
				add_row('star_rate_user_id', $row, 'user_'.$userid);

				if ($rate_from_comments == 0) {
					update_field('rate_from_comments',$stars,'user_'.$userid);
				} else {
					$rate_from_comments = ($rate_from_comments + $stars) / 2;
					update_field('rate_from_comments',$rate_from_comments,'user_'.$userid);
				}
			}

		}
		die;
	}
}





if (!function_exists('get_feed_user_profile_new')) {
	add_action( 'wp_ajax_get_feed_user_profile_new', 'get_feed_user_profile_new' );
	add_action( 'wp_ajax_nopriv_get_feed_user_profile_new', 'get_feed_user_profile_new' );
	function get_feed_user_profile_new() {
		global $post;
		$userid = $_POST['user_id'];
		$sort_type = $_POST['sort_type'];
		$data_review_post = $_POST['data_review_post'];
		$data_post = $_POST['data_post'];
		$data_review = $_POST['data_review'];
		$data_comment = $_POST['data_comment'];
		$data_abuse = $_POST['data_abuse'];

		$feed   = [];
		$types  = [];
		$items  = [];
		$offset = [];
//Обзоры-посты

		$myposts = get_posts( array(
			'author'         => $userid,
			'posts_per_page' => 20,
			'post_type'      => 'casino',
			'offset' => $data_review_post
		) );
		foreach ( $myposts as $post ) {
			setup_postdata( $post );
			$vals = [ 'review_post', get_the_ID(), $post->post_date ];
			array_push( $items, $vals );
		}
		wp_reset_postdata();
		$var_types = [ 'review_post', count( $myposts ) ];
		array_push( $types, $var_types );
		if (($data_review_post != "all") && ($data_review_post != "0")  && ($data_review_post != 0)) {

		}


//посты
		$myposts = get_posts( array(
			'author'         => $userid,
			'posts_per_page' => 20,
			'post_type'      => 'post',
			'offset' => $data_post
		) );
		foreach ( $myposts as $post ) {
			setup_postdata( $post );
			$vals = [ 'post', get_the_ID(), $post->post_date ];
			array_push( $items, $vals );
		}
		wp_reset_postdata();
		$var_types = [ 'post', count( $myposts ) ];
		array_push( $types, $var_types );
		if (($data_post != "all") && ($data_post != "0")  && ($data_post != 0)) {

		}
//отзывы-обзоры


		$args_reviews = [
			'status'       => 'approve',
			'user_id'      => $userid,
			'comment_type' => 'comment',
			'number'       => 20,
			'offset' => $data_review,
			'meta_query'   => [
				'relation' => 'AND',
				[
					'key'     => 'comment_type',
					'value'   => 'reviews',
					'compare' => '=',
				]
			]
		];
		if (($data_review != "all") && ($data_review != "0")  && ($data_review != 0)) {
			$args_reviews['offset'] = intval($data_review);
		}
		$comments     = get_comments( $args_reviews );

		foreach ( $comments as $comment ) {
			$vals = [ 'review', $comment->comment_ID, $comment->comment_date ];
			array_push( $items, $vals );
		}
		$var_types = [ 'review', count( $comments ) ];
		array_push( $types, $var_types );
//		echo '<pre>';
//		print_r($items);
//		echo '</pre>';


		//echo '333'.$data_review;
//комменты-простые
		$args_comments = [
			'status'       => 'approve',
			'user_id'      => $userid,
			'comment_type' => 'comment',
			'number'       => 20,
			'offset' => $data_comment,
			'meta_query'   => [
				'relation' => 'AND',
				[
					'key'     => 'comment_type',
					'value'   => 'comment',
					'compare' => '=',
				]
			]
		];

		if (($data_comment != "all") && ($data_comment != "0")  && ($data_comment != 0)) {
			$args_comments['offset'] = intval($data_comment);
		}

		$comments      = get_comments( $args_comments );

		foreach ( $comments as $comment ) {
			$vals = [ 'comment', $comment->comment_ID, $comment->comment_date ];
			array_push( $items, $vals );
		}
		$var_types = [ 'comment', count( $comments ) ];
		array_push( $types, $var_types );



//жалобы
		$args_abuse = [
			'status'     => 'approve',
			'user_id'    => $userid,
			'number'     => 20,
			'offset' => $data_abuse,
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				]
			]
		];
		$comments   = get_comments( $args_abuse );

		foreach ( $comments as $comment ) {
			$vals = [ 'abuse', $comment->comment_ID, $comment->comment_date ];
			array_push( $items, $vals );
		}

		$var_types = [ 'abuse', count( $comments ) ];
		array_push( $types, $var_types );
		if (($data_abuse != "all") && ($data_abuse != "0")  && ($data_abuse != 0)) {

		}

		function sortFunction( $a, $b ) {
			return strtotime( $a[2] ) - strtotime( $b[2] );
		}

		usort( $items, "sortFunction" );


		$items = array_reverse($items, false);

		/*echo '<pre>';
		print_r($items);
		echo '</pre>';*/
//это шапка



			if ($sort_type == "new") {
			//$item_sorted = array_reverse($items);
		}
// elseif ($sort_type == "old") {
//			$item_sorted = $items;
//		}

		$args = array(
			'user_id' => $userid,
			'count' => true,
			'status' => 'approve'
		);
		$comments_count = get_comments($args);
		$count_user_posts = count_user_posts( $userid, 'casino', true );
		$allCounts = $comments_count + $count_user_posts;

		$comments_top = '';


		if (($allCounts != 0) && (($data_review_post == 0) && ($data_post == 0) && ($data_review == 0) && ($data_comment == 0) && ($data_abuse == 0)) ) {
			$comments_top .= '<div class="white_block comments_top flex comment_top_dashboard_comments__header">';
			$comments_top .= print_js_links()['events'];
			$comments_top .= '<div class="comments_top_title font_uppercase font_bolder  color_dark_blue font_smaller_2">' . __( 'Активность', 'er_theme' ) . '</div>';
			//$comments_top .= '<div class="comments_top_count font_bold color_dark_gray font_small">'.$allCounts.'</div>';
		if ($comments_top == 'assafas') {
			$comments_top .= '<div class="comments_sorter">';
			$comments_top .= '<div class="comments_sorter_title color_dark_gray pointer font_smaller dropdown flex">' . __( 'Отсортировать по', 'er_theme' ) . '</div>';
			$comments_top .= '<ul class="font_smaller">';
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
			} else {
				$sort_old_active = '';
			}
			$comments_top .= '<li class="sort_new color_dark_gray pointer' . $sort_new_active . '" data-sort-type="new">' . __( 'Сначала новые', 'er_theme' ) . '</li>';
			$comments_top .= '<li class="sort_best color_dark_gray pointer' . $sort_best_active . '" data-sort-type="best">' . __( 'Сначала популярные', 'er_theme' ) . '</li>';
			$comments_top .= '<li class="sort_old color_dark_gray pointer' . $sort_old_active . '" data-sort-type="old">' . __( 'Сначала старые', 'er_theme' ) . '</li>';
			$comments_top .= '</ul>';
			$comments_top .= '</div>';
		}
			$comments_top .= '</div>';
		}
		echo $comments_top;
//это шапка
		/*echo $data_review_post;
		echo $data_post;
		echo $data_review;
		echo $data_comment;
		echo $data_abuse;*/
		/*$_POST['data_review_post'];
		$data_post = $_POST['data_post'];
		$data_review = $_POST['data_review'];
		$data_comment = $_POST['data_comment'];
		$data_abuse = $_POST['data_abuse'];*/

		$data_review_post_temp = 0;
		$data_review_temp = 0;
		$data_abuse_temp = 0;
		$itter = 0;
		foreach ( $items as $item ) {
			//print_r($item);
			if ( ( $item[0] == 'review_post' ))  {
				/*echo list_post_single( $item[1], $userid, 'casino' );
				$data_review_post = ++$data_review_post;
				$itter = ++$itter;*/
			}


			if (( $item[0] == 'post' )) {
				//echo 'пост';
			}
			if (( $item[0] == 'review' )) {
				//echo 'коммент на обзоре';
				echo '<ul class="reviews">';
				echo custom_comment_single( null, null, 0, $item[1] );
				echo '</ul>';
				$data_review = ++$data_review;
				$itter = ++$itter;

			}
			if (( $item[0] == 'abuse' )){
				//echo 'жалоба';
				echo '<ul class="abuses">';
				echo custom_abuse_single( null, null, 0, $item[1] );
				echo '</ul>';
				$data_abuse = ++$data_abuse;
				$itter = ++$itter;
			}
			if (( $item[0] == 'comment' )) {
				//echo 'комменатий в блоге или ответ';
				echo '<ul class="reviews">';
				echo custom_comment_single( null, null, 0, $item[1] );
				echo '</ul>';
				$data_comment = ++$data_comment;
				$itter = ++$itter;

			}

		}

		/*foreach ( $types as $item ) {
			if ( $item[1] < 10 ) {
				$vars_offset = [ $item[0], 'all' ];
				array_push( $offset, $vars_offset );
			} else {
				$vars_offset = [ $item[0], $item[1] ];
				array_push( $offset, $vars_offset );
			}

			//$vars_offset = [ $item[0], $item[1] ];
			//array_push( $offset, $vars_offset );
		}


		$offset_new = [];
		$review_post_count = count_user_posts( $userid, 'casino', true );
		$post_count = count_user_posts( $userid, 'post', true );
		$args  = [
			'status'       => 'approve',
			'user_id'      => $userid,
			'comment_type' => 'comment',
			'count'               => true,
			'meta_query'   => [
				'relation' => 'AND',
				[
					'key'     => 'comment_type',
					'value'   => 'reviews',
					'compare' => '=',
				]
			]
		];
		$review_count = get_comments($args);

		$args  = [
			'status'       => 'approve',
			'user_id'      => $userid,
			'comment_type' => 'comment',
			'count' => true,
			'meta_query'   => [
				'relation' => 'AND',
				[
					'key'     => 'comment_type',
					'value'   => 'comments',
					'compare' => '=',
				]
			]
		];
		$comment_count = get_comments($args);
		$args = [
			'status'     => 'approve',
			'user_id'    => $userid,
			'count' => true,
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				]
			]
		];
		$abuse_count = get_comments($args);

		$offset_new = [['review_post',$review_post_count],['post',$post_count],['review',$review_count],['comment',$comment_count],['abuse',$abuse_count]];



		foreach ( $item_sorted as $item ) {
			//print_r($item);
			if ( ( $item[0] == 'review_post' ) && ($data_review_post != "all"))  {
				echo list_post_single( $item[1], $userid, 'casino' );
			}


			if (( $item[0] == 'post' )  && ($data_post != "all") ) {
				//echo 'пост';
			}
			if (( $item[0] == 'review' )  && ($data_review != "all")) {
				//echo 'коммент на обзоре';
				echo '<ul class="reviews">';
				echo custom_comment_single( null, null, 0, $item[1] );
				echo '</ul>';

			}
			if (( $item[0] == 'abuse' )   && ($data_abuse != "all")){
				//echo 'жалоба';
				echo '<ul class="abuses">';
				echo custom_abuse_single( null, null, 0, $item[1] );
				echo '</ul>';
			}
			if (( $item[0] == 'comment' )  && ($data_comment != "all")) {
				//echo 'комменатий в блоге или ответ';
			}

		}
		$dataset_load_btn = '';
		$allcounts_list = 0;
		foreach ( $offset as $key => $item ) {

			if ($item[1] == "all") {
				$allcounts_list = ++$allcounts_list;
			} elseif ($offset_new[$key][1] == $item[1]) {
				$allcounts_list = ++$allcounts_list;
			}



			$dataset_load_btn .= ' data_'.$item[0].'="'.$item[1].'"';
		}

		if ($allcounts_list < 5) {
			echo '<span class="load_more_feed_profile" '.$dataset_load_btn.'>Загрузить ещё</span>';
		}*/
		/*foreach ( $offset as $key => $item ) {

			if ($item[1] == "all") {
				$allcounts_list = ++$allcounts_list;
			} elseif ($offset_new[$key][1] == $item[1]) {
				$allcounts_list = ++$allcounts_list;
			}



			$dataset_load_btn .= ' data_'.$item[0].'="'.$item[1].'"';
		}*/

		$args_reviews_count = [
			'status'       => 'approve',
			'user_id'      => $userid,
			'comment_type' => 'comment',
			'number'       => 20,
			'offset' => $data_review,
			'meta_query'   => [
				'relation' => 'AND',
				[
					'key'     => 'comment_type',
					'value'   => 'reviews',
					'compare' => '=',
				]
			]
		];

		$reviews_count = 0;
		$comments_data = get_comments( $args_reviews_count );
		if(is_array($comments_data) || $comments_data instanceof Countable) {
			$reviews_count   = count($comments_data);
		}

		$args_abuse_count = [
			'status'     => 'approve',
			'user_id'    => $userid,
			'number'     => 20,
			'offset' => $data_abuse,
			'count' => true,
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'is_abuse',
					'value'   => 1,
					'compare' => '='
				]
			]
		];

		$abuse_count = 0;
		$comments_data = get_comments( $args_abuse_count );
		if(is_array($comments_data) || $comments_data instanceof Countable) {
			$abuse_count   = count($comments_data);
		}
		//if ($itter != 0) {
		if (($reviews_count != 0) && ($abuse_count != 0)) {
			echo '<span class="load_more_feed_profile button button_comments button_green pointer font_small font_bold" data_review_post="'.$data_review_post.'" data_post="'.$data_post.'" data_review="'.$data_review.'" data_comment="'.$data_comment.'" data_abuse="'.$data_abuse.'">Загрузить ещё</span>';
		}

		/*elseif (count_user_posts( $userid, 'casino', true ) != 0) {
			echo '<span class="load_more_feed_profile button button_comments button_green pointer font_small font_bold" data_review_post="'.$data_review_post.'" data_post="'.$data_post.'" data_review="'.$data_review.'" data_comment="'.$data_comment.'" data_abuse="'.$data_abuse.'">Загрузить ещё</span>';
		}*/

		die;

	}
}