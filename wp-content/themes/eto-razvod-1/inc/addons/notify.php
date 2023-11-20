<?php


if(!function_exists('notify_user_icons')) {
    add_action('wp_ajax_notify_user_icons', 'notify_user_icons');
    add_action('wp_ajax_nopriv_notify_user_icons', 'notify_user_icons');
    function notify_user_icons() {
		$result = '';
		if(is_user_logged_in()) {
		//if(is_user_logged_in() && in_array(get_current_user_id(),array(9,17))) {
			$user_id = get_current_user_id();
			$new_notifications = notify_check_new('notifications',$user_id);
			$new_msg = notify_check_new('messages',$user_id);
			$result .= '<ul class="notify_user_icons">';
			//if($user_id == 9 || $user_id == 17) {
				$result .= '<li class="user_icon_msg_new inactive">';
					if($new_msg > 0) {
						$result .= '<span class="notify_counter">'.$new_msg.'</span>';
					}
				$result .= '</li>';
			//}
				$result .= '<li class="user_icon_notify_new inactive">';
					if($new_notifications > 0) {
						$result .= '<span class="notify_counter">'.$new_notifications.'</span>';
					}
				$result .= '</li>';
			$result .= '</ul>';
		}
		echo $result;
		die;
	}
	
}


function notify_user_icons_php() {
	$result = '';
	if(is_user_logged_in()) {
		//if(is_user_logged_in() && in_array(get_current_user_id(),array(9,17))) {
		$user_id = get_current_user_id();
		$new_notifications = notify_check_new('notifications',$user_id);
		$new_msg = notify_check_new('messages',$user_id);
		$result .= '<ul class="notify_user_icons">';
		//if($user_id == 9 || $user_id == 17) {
		$result .= '<li class="user_icon_msg_new inactive">';
		if($new_msg > 0) {
			$result .= '<span class="notify_counter">'.$new_msg.'</span>';
		}
		$result .= '</li>';
		//}
		$result .= '<li class="user_icon_notify_new inactive">';
		if($new_notifications > 0) {
			$result .= '<span class="notify_counter">'.$new_notifications.'</span>';
		}
		$result .= '</li>';
		$result .= '</ul>';
	}
	return $result;
}



if(!function_exists('notify_change_status')) {
    add_action('wp_ajax_notify_change_status', 'notify_change_status');
    add_action('wp_ajax_nopriv_notify_change_status', 'notify_change_status');
    function notify_change_status() {
		$result = '';
		$data = $_POST;
		$id = $data['id'];
		$status = $data['status'];
		$result .= $id.' '.$status;
		global $wpdb;
		$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
		$mydb->update(
					'notifications',
					array('status_read'=> $status),
					array( 'id' => $id ),
					array( '%s' )
				);
		echo $result;
		die;
	}
	
}

if(!function_exists('notify_single_popup')) {
    add_action('wp_ajax_notify_single_popup', 'notify_single_popup');
    add_action('wp_ajax_nopriv_notify_single_popup', 'notify_single_popup');
    function notify_single_popup() {
		$data = $_POST;
		$id = $data['id'];
		$result = '';
		if(is_user_logged_in()) {
			$result .= '<div class="popup_container" id="popup_single_notify">';
			$result .= '<div class="popup_window box_shadow popup_window_single_notification">';
			$result .= '<div class="popup_close_button pointer"></div>';
			$type = 'notifications';
			$user_id = get_current_user_id();
			$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
			$new_items = $mydb->get_results("SELECT * FROM `notifications` WHERE `user_id` LIKE '$user_id' AND `id` = '$id'");
			if(!empty($new_items)) {
				$item = $new_items[0];
				if($item->title != '') {
					$item_title = $item->title;
				} elseif($type == 'notifications' && $item->type =='system_news') {
					$item_title = __('Новости сайта','er_theme');
				}
				$result .= '<div class="single_notify_item">';
					$result .= '<div class="item_title color_dark_blue font_bolder font_smaller_2 font_uppercase">'.$item_title.'</div>';
					$result .= '<div class="item_date">'.$item->date.'</div>';
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
						$company_id = $comment->comment_post_ID;
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
					$result .= '<div class="read_button" data-id="'.$id.'">'.__('Отметить прочитанным','er_theme').'</div>';
				$result .= '</div>';
			}
			$result .= '</div>';
			$result .= '</div>';
		}
		echo $result;
		die;
	}
}

if(!function_exists('notify_main_popup')) {
    add_action('wp_ajax_notify_main_popup', 'notify_main_popup');
    add_action('wp_ajax_nopriv_notify_main_popup', 'notify_main_popup');
    function notify_main_popup() {
		$result = '';
		if(is_user_logged_in()) {
			$result .= '<div class="popup_container" id="popup_'.$data['type'].'">';
			$result .= '<div class="popup_window box_shadow popup_window_main_notifications">';
			$result .= '<div class="popup_close_button pointer"></div>';
			$type = 'notifications';
			$user_id = get_current_user_id();
			$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
			$new_items = $mydb->get_results("SELECT * FROM `notifications` WHERE `user_id` LIKE '$user_id' ORDER BY id DESC");
			
			if(!empty($new_items)) {
				$result .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase notify_popup_title">';
				$result .= __('Все уведомления','er_theme');
				$result .= '</div>';
				$result .= '<ul class="popup_notifications_list">';
				foreach ($new_items as $item) {
					$result .= '<li class="notify_item notify_item_'.$type.' status_'.$item->status_read.'">';
					if($type == 'messages' && $item->user_type =='admin') {
                        $current_language = get_locale();
                        if($current_language != 'ru_RU') {
                            $item_title = __('Site Administration','er_theme');
                        } else {
                            $item_title = __('Администрация сайта','er_theme');
                        }

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
					$result .= '<div class="item_content">'.$item->content.'</div>';
					$result .= '<div class="read_button">'.__('Прочитано','er_theme').'</div>';
					$result .= '</li>';
				}
				$result .= '</ul>';
			}
			$result .= '</div>';
			$result .= '</div>';
		}
		echo $result;
		die;
	}
}


if(!function_exists('notify_check_new')) {
	function notify_check_new($type,$user_id) {
		global $wpdb;
		$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
		$new_items = array();
		if($type == 'notifications' && $user_id > 0) {
			$new_items = $mydb->get_results("SELECT * FROM `notifications` WHERE `status_read` = 'new' AND `user_id` LIKE '$user_id' ");
		} elseif($type == 'messages' && $user_id > 0) {
			$new_items = $mydb->get_results("SELECT * FROM `messages` WHERE `status_read` = 'new' AND `user_id` LIKE '$user_id' ");
			if (get_locale() == 'ru_RU') {
				$new_items[] = (object) ['id' => 0, 'thread_id' => 0, 'date' => '2023-03-09 13:37:16', 'user_type' => 'admin', 'user_id' => 17, 'user_id_author' => 'admin', 'status_read' => 'new', 'content'=> 'test'];
			}
			$admin_threads = $mydb->get_results("SELECT * FROM `threads` WHERE `type` = 'user_admin' AND `users` = 'admin,$user_id' ORDER BY id DESC LIMIT 3");
            if(empty($admin_threads)) {
                $new_items[] = array();
            }
        }
		return count($new_items);
		
	}
}

if(!function_exists('notify_show_recent_popup')) {
    add_action('wp_ajax_notify_show_recent_popup', 'notify_show_recent_popup');
    add_action('wp_ajax_nopriv_notify_show_recent_popup', 'notify_show_recent_popup');
    function notify_show_recent_popup() {
		$result = '';
		$data = $_POST;
		$type = $data['type'];
		if(is_user_logged_in() && $type != '') {
			$user_id = get_current_user_id();
			$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
			if($type == 'notifications' && $user_id > 0) {
				$new_items = $mydb->get_results("SELECT * FROM `notifications` WHERE `user_id` LIKE '$user_id' AND `status_read` = 'new' ORDER BY id DESC LIMIT 3");
			} elseif($type == 'messages' && $user_id > 0) {
                $new_items = array();
				$new_items = $mydb->get_results("SELECT * FROM `messages` WHERE `user_id` LIKE '$user_id' AND `status_read` = 'new' ORDER BY id DESC LIMIT 3");
				if (get_locale() == 'ru_RU') {
					$new_items[] = (object) ['id' => 0, 'thread_id' => 0, 'date' => '2023-03-09 13:37:16', 'user_type' => 'admin', 'user_id' => 0, 'user_id_author' => 'admin', 'status_read' => 'new', 'content'=> 'У нас появился новый сервис - емайл-рассылки!

Мы работаем над рассылками целой командой, делаем все, чтобы они были интересными для вас. Здесь вы можете подписаться на наши рассылки: https://etorazvod.ru/user/

- Общая рассылка. Рассылка с горячими предложениями и последними новостями компаний разных рейтингов сайта.

- Тематическая рассылка. Создается с учетом ваших интересов, указанных в личном кабинете.

- Уведомления сайта. Автоматические уведомления, например, о новых комментариях к вашим отзывам.

В форме по этой ссылке - https://etorazvod.ru/user/ выберите интересующие вас виды рассылки, нажмите кнопку «Сохранить» и ждите наши письма. Будьте уверены, мы против спама. Вы в любой момент можете отписаться от получение писем. '];
				}
			    $admin_threads = $mydb->get_results("SELECT * FROM `threads` WHERE `type` = 'user_admin' AND `users` = 'admin,$user_id' ORDER BY id DESC LIMIT 3");
				/*if (get_locale() == 'ru_RU') {
					$admin_threads[] = (object) ['id' => 0, 'thread_id' => 'admin', 'date' => '2023-03-09 13:37:16', 'user_type' => 'admin', 'user_id' => 0, 'user_id_author' => 'admin', 'status_read' => 'new', 'content'=> 'У нас появился новый сервис - емайл-рассылки!

Мы работаем над рассылками целой командой, делаем все, чтобы они были интересными для вас. Здесь вы можете подписаться на наши рассылки: https://etorazvod.ru/user/

- Общая рассылка. Рассылка с горячими предложениями и последними новостями компаний разных рейтингов сайта.

- Тематическая рассылка. Создается с учетом ваших интересов, указанных в личном кабинете.

- Уведомления сайта. Автоматические уведомления, например, о новых комментариях к вашим отзывам.

В форме по этой ссылке - https://etorazvod.ru/user/ выберите интересующие вас виды рассылки, нажмите кнопку «Сохранить» и ждите наши письма. Будьте уверены, мы против спама. Вы в любой момент можете отписаться от получение писем. '];
				}*/
                /*if(empty($admin_threads)) {
                    $obj = new stdObject();
                    $obj->id = 'admin';
                    $obj->user_type = 'admin';
                    $obj->user_id = $user_id;
                    $obj->user_id_author = 'admin';
                    $obj->status_read = 'new';
                    $obj->content = 'ddd';
                    $new_items[] = $obj;
                    );
                }*/
            }
			
				//print_r($new_items);
				$result .= '<div class="notify_container_small '.$type.' box_shadow_down">';
				if(!empty($new_items) || empty($admin_threads) && $type == 'messages') {
				$result .= '<ul>';
                if(empty($admin_threads) && $type == 'messages') {
                    $item_title_m = '';
                    $current_language = get_locale();
                    if($current_language != 'ru_RU') {
                        $item_title_m = __('Site Administration','er_theme');
                    } else {
                        $item_title_m = __('Администрация сайта','er_theme');
                    }
                    $result .= '<li class="notify_item notify_item_messages status_new" data-thread-id="0">';
                    $result .= '<span class="item_title">'.$item_title_m.'</span>';
                    $item_content = user_wellcome_direct_message($user_id);
                    $result .= '<span class="item_content">'.wp_trim_words($item_content, 9, '...' ).'</span>';
                    $result .= '</li>';
                }
				foreach ($new_items as $item) {
					if($type == 'messages') {
						$thread = ' data-thread-id="'.$item->thread_id.'"';
					} else {
						$thread = '';
					}
					$result .= '<li class="notify_item notify_item_'.$type.' status_'.$item->status_read.'" data-id="'.$item->id.'"'.$thread.'>';
					if($type == 'messages' && $item->user_type =='admin') {
                        $current_language = get_locale();
                        if($current_language != 'ru_RU') {
                            $item_title = __('Site Administration','er_theme');
                        } else {
                            $item_title = __('Администрация сайта','er_theme');
                        }
					} elseif($type == 'messages' && $item->user_type =='user') {
						$user_author = get_userdata( $item->user_id_author );
						$item_title = $user_author->display_name;
					} elseif($type == 'messages' && $item->user_type =='company') {
						$comp_id = $item->user_id_author ;
						$item_title = get_field('company_name',$comp_id);
					} elseif($item->title != '') {
						$item_title = $item->title;
					} elseif($type == 'notifications' && $item->type =='system_news') {
						$item_title = __('Новости сайта','er_theme');
					}
					$result .= '<span class="item_title">'.$item_title.'</span>';
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
						$company_id = $comment->comment_post_ID;
						$company_name = get_field('company_name',$company_id);
						$company_link = get_the_permalink($company_id);
						$item_content = __('Ваш отзыв на компанию','er_theme').' <a href="'.$company_link.'">'.$company_name.'</a> '.__('успешно прошел модерацию. Теперь Вы можете увидеть его на').' <a href="'.$company_link.'/comment-'.$comment_id.'/">'.$company_link.'/comment-'.$comment_id.'/</a>';
					} elseif($type == 'notifications' && $item->type == 'system_new_comment_notify_user_approved') {
						$comment_id = $item->content;
						$comment = get_comment($comment_id);
						$company_id = $comment->comment_post_ID;
						if(get_post_type($company_id) == 'casino' && $comment->comment_parent > 0) {
							$comment_parent = get_comment($comment->comment_parent);
							$company_name = get_field('company_name',$company_id);
							$company_link = get_the_permalink($company_id);
							$item_content = __('Ваш ответ на отзыв пользователя','er_theme').' '.$comment_parent->comment_author.__(' на компанию','er_theme').' <a href="'.$company_link.'">'.$company_name.'</a> '.__('успешно прошел модерацию. Теперь Вы можете увидеть его на').' <a href="'.$company_link.'/comment-'.$comment_id.'/">'.$company_link.'/comment-'.$comment_id.'/</a>';
						} else {
							$company_name = get_the_title($company_id);
							$company_link = get_the_permalink($company_id);
							$item_content = __('Ваш комментарий к записи','er_theme').' <a href="'.$company_link.'">'.$company_name.'</a> '.__('успешно прошел модерацию. Теперь Вы можете увидеть его на').' <a href="'.$company_link.'#comment-'.$comment_id.'">'.__('странице записи','er_theme').'</a>';
						}
						
						
						
						
					} else {
						$item_content = $item->content;
					}
					$result .= '<span class="item_content">'.wp_trim_words($item_content, 7, '...' ).'</span>';
					$result .= '</li>';
				}
				$result .= '</ul>';
				} else {
					if($type == 'messages') {
						$result .= '<div class="no_items">'.__('Нет новых сообщений','er_theme').'</div>';
					} elseif($type == 'notifications') {
						$result .= '<div class="no_items">'.__('Нет новых уведомлений','er_theme').'</div>';
					}
				}
				if($type == 'messages') {
					$result .= '<a class="all_notify_msg" href="'.get_bloginfo('url').'/dashboard/messages/" rel="nofollow">'.__('Все сообщения','er_theme').'</a>';
				} elseif($type == 'notifications') {
					$result .= '<a class="all_notify_button all_notify_msg" href="'.get_bloginfo('url').'/dashboard/notifications/" rel="nofollow">'.__('Все уведомления','er_theme').'</a>';
				}
				
				$result .= '</div>';
		
			
		}
		
		echo $result;
		die;
	}
}


if(!function_exists('notify_user_action')) {
	function notify_user_action($type,$user_id,$title,$content) {
		$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
	
		
		$mydb->insert('notifications',
			array(
				'user_id'=> $user_id,
				'type' => $type,
				'status_read' => 'new', 
				'status_send' => 'not_sent',
				'title' => $title, 
				'content' => $content
			),
			array( '%s', '%s', '%s','%s','%s','%s'));
	}
}



