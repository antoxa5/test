<?php
if (!function_exists('user_dashboard_messages')) {
	function user_dashboard_messages() {
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
		$threads = $mydb->get_results("SELECT * FROM `messages` WHERE `user_id` = '$user_id' OR `user_id_author` = '$user_id' ORDER BY `date` DESC", ARRAY_A);
		
		
		$threads_new = array();
        $admin_thread = false;
		if(!empty($threads)) {
			foreach($threads as $thread) {
				if(!in_array($thread['thread_id'],$threads_new)) {
					$threads_new[] = $thread['thread_id'];
                    //echo $thread['user_id'].'<br>';
                   // echo $thread['user_id_author'].'<br>';
                    if($thread['user_id'] == 'admin' || $thread['user_id_author'] == 'admin') {
                        $admin_thread = true;
                    }
				}
			}
		} else {
        }
        //echo $admin_thread;
		//echo '<pre>';
		//print_r($threads_new);
		//echo '</pre>';
		$result = print_css_links('user_page');
		$result .= print_js_links()['user_page'];
		$result .= print_js_links()['show_block'];
		$result .= print_css_links('show_block');
		$result .= print_js_links()['comments_loader_dashboard'];
		$result .= print_js_links()['user_zero_message'];
		$result .= '<div class="page_content page_container background_light review_container_about visible">';
		$result .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
		$result .= '        <div class="profile-wrapper">';
		$result .= '            <div class="profile-wrapper__left">';

		$result .= user_menu($current_user,$user_id,'messages');
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub profile-wrapper__center_sub_dashboard_messages">';
		$result .= '<div class="breadcrumbs_dashboard isdesctop">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		//if(!empty($threads)) {
		$result .= '<div class="user_messages_thread"></div>';
		//} else {
			//$result .= '<div class="user_zero_message">'.__('У вас еще нет личных сообщений. Они появятся, когда компания, о которой вы оставили отзыв или жалобу, напишет вам.','er_theme').'</div>';
		//}
		$result .= '</div>';
		$result .= '            <div class="profile-wrapper__right_sub">';
		//if(!empty($threads)) {
			$result .= '<ul class="message_users_list message_users_list_2 users">';
            if($admin_thread == false) {
                $result .= '<li data-thread-id="admin" class="inactive" id="thread_item_admin"><div class="user_picture border_circle" style="background-image: url('.get_bloginfo('url').'/wp-content/uploads/2021/07/avatar-150x150.png)"></div><span class="user_name">'.__('Администрация','er_theme').'</span></li>';
            }
			foreach($threads_new as $thread) {
				//print_r($thread);
				$thread_id = $thread;
				$thread_users = $mydb->get_results("SELECT `users` FROM `threads` WHERE `id` = '$thread_id'", ARRAY_A)[0]['users'];
				$type = $mydb->get_results("SELECT `type` FROM `threads` WHERE `id` = '$thread_id'", ARRAY_A)[0]['type'];
				//echo $type;
				//print_r($thread_users[0]);
				$thread_users_array = explode(',',$thread_users);
				//print_r($thread_users_array);
				$thread_u = array();
				foreach($thread_users_array as $user) {
					if($user_id != $user) {
						$thread_u[] = $user;
					}
				}
				//print_r($thread_u);
				if(count($thread_u) == 1) {
					if($type == 'user_company') {
                        $user_picture = get_field('company_icon', $thread_u[0]);
                        $user_names = get_field('company_name', $thread_u[0]);
                        if ($user_picture && $user_picture != '') {
                            $user_pic = '<div class="user_picture border_circle" style="background-image: url(' . $user_picture["sizes"]["thumbnail"] . ')"></div>';
                        } else {
                            $user_pic = '<div class="user_picture border_circle"></div>';
                        }
                    } elseif($type == 'user_admin') {
                        $user_pic = '<div class="user_picture border_circle" style="background-image: url('.get_bloginfo('url').'/wp-content/uploads/2021/07/avatar-150x150.png)"></div>';
                        $user_names = __('Администрация','er_theme');
                    } else {
						$user_info = get_userdata($thread_u[0]);
						$user_picture = get_field('photo_profile', 'user_'.$thread_u[0] );
						$user_names = $user_info->display_name;
						if($user_picture && $user_picture != '') {
							$user_pic = '<div class="user_picture border_circle" style="background-image: url('.$user_picture["sizes"]["thumbnail"].')"></div>';
						} else {
							$user_pic = '<div class="user_picture border_circle"></div>';
						}
					}
				} else {
					$user_names = 'several';
				}
				$new_items = $mydb->get_results("SELECT * FROM `messages` WHERE `status_read` = 'new' AND `thread_id` = '$thread_id' AND  `user_id_author` != '$user_id'");
				$count_new_items = count($new_items);
				if($count_new_items > 0) {
					$new_exists = '<span class="number">'.$count_new_items.'</span>';
				} else{
					$new_exists = '';
				}
				$result .= '<li data-thread-id="'.$thread_id.'" class="inactive" id="thread_item_'.$thread_id.'" data-id="'.$user_names.'">'.$user_pic.'<span class="user_name">'.$user_names.'</span>'.$new_exists.'</li>';
			}
			$result .= '</ul>';
		//} else {
			//$result .= '<div>';
           // $result .= '<div class=" button  link_new_review_outside button_green button_padding_big font_bold button_centered pointer m_b_15">'.__('Оставить отзыв','er_theme').'</div>';
			//$result .= '<div class=" button  link_new_abuse_outside button_violet button_padding_big font_bold button_centered pointer">'.__('Оставить жалобу','er_theme').'</div>';
           // $result .= '</div>';

		//}
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		if($_GET['thread'] != '') {
			$result .= '
			<script type="text/javascript">
			jQuery(document).ready(function($){
			//$( ".message_users_list.users li#thread_item_'.$_GET['thread'].'" ).trigger( "click" );
			load_thread('.$_GET['thread'].');
			
			$(".message_users_list li#thread_item_'.$_GET['thread'].'").addClass("current");
			});
			
			
			
			</script>
			';
		}
		if(!$_GET['thread']) {
		$result .= '
			<script type="text/javascript">
			jQuery(document).ready(function($){
			
			$(\'.message_users_list li\').removeClass(\'current\');
	$( ".message_users_list li" ).first().addClass( "current" );
	var thread_id_first = $(\'.message_users_list li:first-child\').attr(\'data-thread-id\');
	//alert(thread_id_first);
	load_thread(thread_id_first);
			});
			
			
			</script>
			';
		}
		$result .= print_css_links('profile_top');
		return $result;
	}
}




if (!function_exists('admin_dashboard_messages')) {
    function admin_dashboard_messages() {
        $current_user = wp_get_current_user();
        $user_id = $current_user->data->ID;
        $mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
        $threads = $mydb->get_results("SELECT * FROM `messages` WHERE `user_id` = 'admin' OR `user_id_author` = 'admin' ORDER BY `date` DESC", ARRAY_A);

        $threads_new = array();
        if(!empty($threads)) {
            foreach($threads as $thread) {
                if(!in_array($thread['thread_id'],$threads_new)) {
                    $threads_new[] = $thread['thread_id'];
                    //echo $thread['user_id'].'<br>';
                    // echo $thread['user_id_author'].'<br>';

                }
            }
        } else {
        }
        //echo $admin_thread;
        //echo '<pre>';
        //print_r($threads_new);
        //echo '</pre>';
        $result = print_css_links('user_page');
       // $result .= print_js_links()['user_page'];
       // $result .= print_js_links()['show_block'];
        //$result .= print_css_links('show_block');
        //$result .= print_js_links()['comments_loader_dashboard'];
        //$result .= print_js_links()['user_zero_message'];
        $result .= '<div class="page_content page_container background_light review_container_about visible">';
        $result .= '    <div class="wrap  justify-content-space-between wrap-no-padding-top">';
        $result .= '        <div class="profile-wrapper">';
        $result .= '            <div class="profile-wrapper__center_sub profile-wrapper__center_sub_dashboard_messages">';

        if(!empty($threads)) {
            $result .= '<div class="user_messages_thread"></div>';
        } else {
            $result .= '<div class="user_zero_message">'.__('У вас еще нет личных сообщений. Они появятся, когда компания, о которой вы оставили отзыв или жалобу, напишет вам.','er_theme').'</div>';
        }
        $result .= '</div>';
        $result .= '            <div class="profile-wrapper__right_sub">';
        if(!empty($threads)) {
            $result .= '<ul class="message_users_list message_users_list_1 users">';
            foreach($threads_new as $thread) {
                //print_r($thread);
                $thread_id = $thread;
                $thread_users = $mydb->get_results("SELECT `users` FROM `threads` WHERE `id` = '$thread_id'", ARRAY_A)[0]['users'];
                $type = $mydb->get_results("SELECT `type` FROM `threads` WHERE `id` = '$thread_id'", ARRAY_A)[0]['type'];
                //echo $type;
                //print_r($thread_users[0]);
                $thread_users_array = explode(',',$thread_users);
                //print_r($thread_users_array);
                $thread_u = array();
                foreach($thread_users_array as $user) {
                    if($user != 'admin') {
                        $thread_u[] = $user;
                    }
                }
                //print_r($thread_u);
                if(count($thread_u) == 1) {

                        $user_info = get_userdata($thread_u[0]);
                        $user_picture = get_field('photo_profile', 'user_'.$thread_u[0] );
                        $user_names = $user_info->display_name;
                        if($user_picture && $user_picture != '') {
                            $user_pic = '<div class="user_picture border_circle" style="background-image: url('.$user_picture["sizes"]["thumbnail"].')"></div>';
                        } else {
                            $user_pic = '<div class="user_picture border_circle"></div>';
                        }

                } else {
                    $user_names = 'several';
                }
                $new_items = $mydb->get_results("SELECT * FROM `messages` WHERE `status_read` = 'new' AND `thread_id` = '$thread_id' AND  `user_id_author` != '$user_id'");
                $count_new_items = count($new_items);
                if($count_new_items > 0) {
                    $new_exists = '<span class="number">'.$count_new_items.'</span>';
                } else{
                    $new_exists = '';
                }
                $result .= '<li data-thread-id="'.$thread_id.'" class="inactive" id="thread_item_'.$thread_id.'" data-id="'.$user_names.'">'.$user_pic.'<span class="user_name">'.$user_names.'</span>'.$new_exists.'</li>';
            }
            $result .= '</ul>';
        } else {
            $result .= '<div>';
            $result .= '<div class=" button  link_new_review_outside button_green button_padding_big font_bold button_centered pointer m_b_15">'.__('Оставить отзыв','er_theme').'</div>';
            $result .= '<div class=" button  link_new_abuse_outside button_violet button_padding_big font_bold button_centered pointer">'.__('Оставить жалобу','er_theme').'</div>';
            $result .= '</div>';

        }
        $result .= '        </div>';
        $result .= '    </div>';
        $result .= '</div>';
        if($_GET['thread'] != '') {
            $result .= '
			<script type="text/javascript">
			jQuery(document).ready(function($){
			//$( ".message_users_list.users li#thread_item_'.$_GET['thread'].'" ).trigger( "click" );
			load_thread_admin('.$_GET['thread'].');
			//alert("lll");
			$(".message_users_list li#thread_item_'.$_GET['thread'].'").addClass("current");
			});
			
			
			
			</script>
			';
        }
        if(!$_GET['thread']) {
            $result .= '
			<script type="text/javascript">
			jQuery(document).ready(function($){
			
			$(\'.message_users_list li\').removeClass(\'current\');
	$( ".message_users_list li" ).first().addClass( "current" );
	var thread_id_first = $(\'.message_users_list li:first-child\').attr(\'data-thread-id\');
	//alert(thread_id_first);
	load_thread_admin(thread_id_first);
			});
			
			
			</script>
			';
        }
        //$result .= print_css_links('profile_top');
        return $result;
    }
}



if(!function_exists('user_wellcome_direct_message')) {
    function user_wellcome_direct_message($user_id) {
        $result = '';
        $user_name = get_field('first_name','user_'.$user_id);
        if($user_name && $user_name != '') {
            $result .= '<p>'.__('Добрый день,','er_theme').' '.$user_name.__('! Спасибо за регистрацию на нашем сайте! Сейчас вам доступны следующие функции сайта:','er_theme').'</p>';
        } else {
            $result .= '<p>'.__('Добрый день!','er_theme').' '.__('Спасибо за регистрацию на нашем сайте! Сейчас вам доступны следующие функции сайта:','er_theme').'</p>';
        }
        //$result .= '<p>'.__('Сейчас вам доступны следующие функции сайта:','er_theme').'</p>';
		
		
		
		
        $result .= '<ul>';
        $result .= '<li>'.__('Просмотр уведомлений сайта и подписка на уведомления интересующих вас компаний.','er_theme').'</li>';
        $result .= '<li>'.__('Заполнение вашего профиля на сайте.','er_theme').'</li>';
        $result .= '<li>'.__('Изучение материалов сайта.','er_theme').'</li>';
        $result .= '<li>'.__('Публикация отзывов и жалоб.','er_theme').'</li>';
        $result .= '<li>'.__('Начисление баллов за активность на сайте (например, за публикации отзывов, жалоб и комментариев).','er_theme').'</li>';
        $result .= '</ul>';
        $result .= '<p>'.__('Рекомендуем:','er_theme').'</p>';
        $result .= '<ul>';
        $result .= '<li>'.__('Подтвердить ваш аккаунт, чтобы иметь доступ ко всем функциям сайта, например, получать уведомления об отзывах и жалобах на интересующие вас компании.','er_theme').'</li>';
        $result .= '<li>'.__('Заполнить личный кабинет, чтобы другие пользователи узнали больше о вас и вы лучше себя позиционировали в нашем сообществе.','er_theme').'</li>';
        $result .= '<li>'.__('Указать ваши интересы, чтобы для вас отображался наиболее подходящий под ваши интересы контент.','er_theme').'</li>';
        if (get_locale() == 'ru_RU') {
			$result .= '<li>Подписаться на нашу рассылку <a href="/user/" style="text-decoration: none;color: #000;border-bottom: 1px solid;margin-left: 5px;">здесь</a></li>';
			$result .= '<li>Вы можете выбрать подходящий вариант рассылки и управлять подпиской, отписаться от одной и подписать на другую.</li>';
		}
        $result .= '</ul>';
       /* $result .= '<p>'.__('На сайте вы можете:','er_theme').'</p>';
        $result .= '<ul>';
        $result .= '<li>'.__('изучать рейтинги и обзоры;','er_theme').'</li>';
        $result .= '<li>'.__('добавлять отзывы о компаниях и отвечать на отзывы других пользователей;','er_theme').'</li>';
        $result .= '<li>'.__('публиковать жалобы на компании;','er_theme').'</li>';
        $result .= '<li>'.__('отслеживать промокоды компаний.','er_theme').'</li>';
        $result .= '</ul>';
        $result .= '<p>'.__('Если вы хотите:','er_theme').'</p>';
        $result .= '<ul>';
        $result .= '<li>'.__('указать в профиле ссылки на ваши соц сети и другие ресурсы в сети;','er_theme').'</li>';
        $result .= '<li>'.__('получить значок PRO;','er_theme').'</li>';
        $result .= '<li>'.__('быть экспертом в какой-либо области;','er_theme').'</li>';
        $result .= '<li>'.__('изменить логин и url профиля;','er_theme').'</li>';
        $result .= '<li>'.__('размещать ссылки в ваших комментариях и услуги в профиле;','er_theme').'</li>';
        $result .= '<li>'.__('получать специальные предложения от компаний;','er_theme').'</li>';
        $result .= '<li>'.__('пользоваться приоритетной связью с компаниями;','er_theme').'</li>';
        $result .= '<li>'.__('пользоваться нашими авторскими обучающими материалами.','er_theme').'</li>';
        $result .= '</ul>';
        $result .= '<p><a class="button button_padding_big button_centered font_bold link_no_underline button_green" href="'.get_bloginfo('url').'/dashboard/services/pro/" target="_blank">'.__('Оформите статус PRO здесь','er_theme').'</a></p>';
        $result .= '<p>'.__('Если вы – представитель компании и хотели бы:','er_theme').'</p>';
        $result .= '<ul>';
        $result .= '<li>'.__('обновлять карточку вашего бренда;','er_theme').'</li>';
        $result .= '<li>'.__('публиковать актуальные акции и промокоды;','er_theme').'</li>';
        $result .= '<li>'.__('размещать экспертные статьи в Блоге;','er_theme').'</li>';
        $result .= '<li>'.__('отвечать на отзывы от лица официального представителя компании;','er_theme').'</li>';
        $result .= '<li>'.__('размещать ссылки в ваших комментариях и услуги в профиле;','er_theme').'</li>';
        $result .= '<li>'.__('отвечать на жалобы о компании;','er_theme').'</li>';
        $result .= '<li>'.__('пользоваться аналитикой.','er_theme').'</li>';
        $result .= '</ul>';*/
        $result .= '<p><a class="button button_padding_big button_centered font_bold link_no_underline button_green" href="'.get_bloginfo('url').'/dashboard-add-company/" target="_blank">'.__('Добавьте или привяжите компанию','er_theme').'</a></p>';
        return $result;
    }
}


if (!function_exists('load_thread')) {
	add_action( 'wp_ajax_load_thread', 'load_thread' );
	add_action( 'wp_ajax_nopriv_load_thread', 'load_thread' );
	function load_thread() {
		$result = '';
		$data = $_POST;
		$thread_id = $data['thread_id'];
        if($thread_id == 'admin') {
            $current_user = wp_get_current_user();
            $current_user_id = $current_user->data->ID;
            $result .= '<ul class="messages_list messages_list_3">';
            $user_pic = '<div class="user_picture border_circle" style="background-image: url('.get_bloginfo('url').'/wp-content/uploads/2021/07/avatar-150x150.png)"></div>';
            $result .= '<li data-message-id="default">';
            $result .= $user_pic;
            $result .= '<div class="message_container">';

            $result .= '<div class="message_content">'.user_wellcome_direct_message($current_user_id).'</div>';
            $result .= '<div class="message_meta">';
            $result .= '<span class="name">'.__('Администрация','er_theme').' </span>';
            //$result .= '<span class="date">дада</span>';
            $result .= '</div>';
            $result .= '</div>';
            $result .= '</li>';
            
			$result .= '<li data-message-id="default">';
			$result .= $user_pic;
			$result .= '<div class="message_container">';
			$result .= '<div class="message_content"><p>У нас появился новый сервис - email-рассылки!</p>

<p>Мы работаем над рассылками целой командой, делаем все, чтобы они были интересными для вас. Вы можете подписаться на наши рассылки <a href="/user/">на странице пользователя</a>.</p>
<ul>
	<li>Общая рассылка. Рассылка с горячими предложениями и последними новостями компаний разных рейтингов сайта.</li>
	<li>Тематическая рассылка. Создается с учетом ваших интересов, указанных в личном кабинете.</li>
	<li>Уведомления сайта. Автоматические уведомления, например, о новых комментариях к вашим отзывам.</li>
</ul>
<p>Выберите интересующие вас виды рассылки <a href="/user/">в этой форме</a>. Нажмите кнопку «Сохранить» и ждите наши письма. Будьте уверены, мы против спама. Вы в любой момент можете отписаться от писем.</p></div>';
			$result .= '<div class="message_meta">';
			$result .= '<span class="name">'.__('Администрация','er_theme').' </span>';
			//$result .= '<span class="date">дада</span>';
			$result .= '</div>';
			$result .= '</div>';
			$result .= '</li>';
			
            $result .= '</ul>';

            $result .= message_form('admin','admin','new_to_admin');
        } else {
			$current_user = wp_get_current_user();
			$current_user_id = $current_user->data->ID;
            $mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
            $messages = $mydb->get_results("SELECT * FROM `messages` WHERE `thread_id` = '$thread_id' ORDER BY `date` ASC", ARRAY_A);
			
			if (get_locale() == 'ru_RU' && gettype(array_search('admin', array_column($messages, 'user_type'))) == 'integer') {
				$messages[] = ['id' => 0, 'thread_id' => $thread_id, 'date' => '2023-03-13 9:00:00', 'user_type' => 'admin', 'user_id' => 0, 'user_id_author' => 'admin', 'status_read' => 'new', 'content'=> '
<p>У нас появился новый сервис - email-рассылки!</p>

<p>Мы работаем над рассылками целой командой, делаем все, чтобы они были интересными для вас. Вы можете подписаться на наши рассылки <a href="/user/">на странице пользователя</a>.</p>
<ul>
	<li>- Общая рассылка. Рассылка с горячими предложениями и последними новостями компаний разных рейтингов сайта.</li>
	<li>- Тематическая рассылка. Создается с учетом ваших интересов, указанных в личном кабинете.</li>
	<li>- Уведомления сайта. Автоматические уведомления, например, о новых комментариях к вашим отзывам.</li>
</ul>
<p>Выберите интересующие вас виды рассылки <a href="/user/">в этой форме</a>. Нажмите кнопку «Сохранить» и ждите наши письма. Будьте уверены, мы против спама. Вы в любой момент можете отписаться от писем.</p>'];
				//print_r($messages);
			}
	
			
	
			usort($messages, function($a, $b) {
				$dateA = strtotime($a['date']);
				$dateB = strtotime($b['date']);
				return $dateA - $dateB;
			});
			
            if(!empty($messages)) {
                $result .= '<ul class="messages_list messages_list_4" data-id="'.$thread_id.'">';
                $m_type = $messages[0]['user_type'];

                $current_user = wp_get_current_user();
                $current_user_id = $current_user->data->ID;
                if($m_type == 'admin') {
                    $result .= '<li data-message-id="default">';
                    $result .= '<div class="user_picture border_circle" style="background-image: url('.get_bloginfo('url').'/wp-content/uploads/2021/07/avatar-150x150.png)"></div>';
                    $result .= '<div class="message_container">';
                    $result .= '<div class="message_content">'.user_wellcome_direct_message($current_user_id).'</div>';
                    $result .= '<div class="message_meta">';
                    $result .= '<span class="name">'.__('Администрация','er_theme').' </span>';
                    //$result .= '<span class="date">дада</span>';
                    $result .= '</div>';
                    $result .= '</div>';
                    $result .= '</li>';
                    $recipient = 'admin';
                }

                foreach ($messages as $message) {
                    $user_info = '';

                    if($message['user_type'] == 'user') {
                        $user_info = get_userdata($message['user_id_author']);
                        $user_picture = get_field('photo_profile', 'user_'.$message['user_id_author'] );
                        $user_name = $user_info->display_name;
                        if($user_picture && $user_picture != '') {
                            $user_pic = '<div class="user_picture border_circle" style="background-image: url('.$user_picture["sizes"]["thumbnail"].')"></div>';
                        } else {
                            $user_pic = '<div class="user_picture border_circle"></div>';
                        }
                    } elseif($message['user_type'] == 'admin') {
                        if($current_user_id == $message['user_id_author']) {
                            $user_info = get_userdata($message['user_id_author']);
                            $user_picture = get_field('photo_profile', 'user_'.$message['user_id_author'] );
                            $user_name = $user_info->display_name;
                            if($user_picture && $user_picture != '') {
                                $user_pic = '<div class="user_picture border_circle" style="background-image: url('.$user_picture["sizes"]["thumbnail"].')"></div>';
                            } else {
                                $user_pic = '<div class="user_picture border_circle"></div>';
                            }
                        } else {
                            $user_pic = '<div class="user_picture border_circle" style="background-image: url(' . get_bloginfo('url') . '/wp-content/uploads/2021/07/avatar-150x150.png)"></div>';
                            $user_name = __('Администрация', 'er_theme');
                        }
                    } elseif($message['user_type'] == 'company') {
                        if($current_user_id == $message['user_id_author']) {
                            $user_info = get_userdata($message['user_id_author']);
                            $user_picture = get_field('photo_profile', 'user_'.$message['user_id_author'] );
                            $user_name = $user_info->display_name;
                            if($user_picture && $user_picture != '') {
                                $user_pic = '<div class="user_picture border_circle" style="background-image: url('.$user_picture["sizes"]["thumbnail"].')"></div>';
                            } else {
                                $user_pic = '<div class="user_picture border_circle"></div>';
                            }
                        } else {

                            $user_picture = get_field('company_icon', $message['user_id_author'] );
                            $user_name = get_field('company_name',$message['user_id_author']);
                            if($user_picture && $user_picture != '') {
                                $user_pic = '<div class="user_picture border_circle" style="background-image: url('.$user_picture["sizes"]["thumbnail"].')"></div>';
                            } else {
                                $user_pic = '<div class="user_picture border_circle"></div>';
                            }
                        }
                    }

                    if($current_user_id == $message['user_id_author']) {
                        $self = ' class="self"';
                    } else {
                        $self = '';
                        $recipient = $message['user_id_author'];
                        $mydb->update(
                            'messages',
                            array('status_read'=> 'read'),
                            array( 'id' => $message['id'] ),
                            array( '%s' )
                        );
                    }
                    $result .= '<li data-message-id="'.$message['id'].'"'.$self.'>';
                    $result .= $user_pic;
                    $result .= '<div class="message_container">';
                    $result .= '<div class="message_content">'.$message['content'].'</div>';
                    $result .= '<div class="message_meta">';
                    $result .= '<span class="name">'.$user_name.', </span>';
                    $result .= '<span class="date">'.$message['date'].'</span>';
                    $result .= '</div>';
                    $result .= '</div>';
                    $result .= '</li>';

                }
                $result .= '</ul>';
                $result .= message_form($recipient,$m_type,$thread_id);
            } else {

            }
        }

		//$result .= $thread_id;
		//print_r($messages);

		echo $result;
		die;
	}
}



if (!function_exists('load_thread_admin')) {
    add_action( 'wp_ajax_load_thread_admin', 'load_thread_admin' );
    add_action( 'wp_ajax_nopriv_load_thread_admin', 'load_thread_admin' );
    function load_thread_admin() {
        $result = '';
        $data = $_POST;
        $thread_id = $data['thread_id'];

            $mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
            $messages = $mydb->get_results("SELECT * FROM `messages` WHERE `thread_id` = '$thread_id' ORDER BY `date` ASC", ARRAY_A);
            if(!empty($messages)) {
                $result .= '<ul class="messages_list messages_list_1">';
                $m_type = $messages[0]['user_type'];

                $current_user = wp_get_current_user();
                $current_user_id = $current_user->data->ID;
                if($m_type == 'admin') {
                    $result .= '<li data-message-id="default" class="self">';
                    $result .= '<div class="user_picture border_circle" style="background-image: url('.get_bloginfo('url').'/wp-content/uploads/2021/07/avatar-150x150.png)"></div>';
                    $result .= '<div class="message_container">';
                    $result .= '<div class="message_content">Здравствуйте. Спасибо, что зарегистрировались на нашем сайте. Если у вас есть вопросы, нужна помощь, напишите нам, и мы постараемся вам помочь.</div>';
                    $result .= '<div class="message_meta">';
                    $result .= '<span class="name">'.__('Администрация','er_theme').' </span>';
                    //$result .= '<span class="date">дада</span>';
                    $result .= '</div>';
                    $result .= '</div>';
                    $result .= '</li>';
                    $recipient = 'admin';
                }

                foreach ($messages as $message) {
                    $user_info = '';


                        if('admin' != $message['user_id_author']) {
                            $user_info = get_userdata($message['user_id_author']);
                            $user_picture = get_field('photo_profile', 'user_'.$message['user_id_author'] );
                            $user_name = $user_info->display_name;
                            if($user_picture && $user_picture != '') {
                                $user_pic = '<div class="user_picture border_circle" style="background-image: url('.$user_picture["sizes"]["thumbnail"].')"></div>';
                            } else {
                                $user_pic = '<div class="user_picture border_circle"></div>';
                            }
                        } else {
                            $user_pic = '<div class="user_picture border_circle" style="background-image: url(' . get_bloginfo('url') . '/wp-content/uploads/2021/07/avatar-150x150.png)"></div>';
                            $user_name = __('Администрация', 'er_theme');
                        }


                    if('admin' == $message['user_id_author']) {
                        $self = ' class="self"';

                    } else {
                        $self = '';
                        $recipient = $message['user_id_author'];
                        $mydb->update(
                            'messages',
                            array('status_read'=> 'read'),
                            array( 'id' => $message['id'] ),
                            array( '%s' )
                        );
                    }
                    $result .= '<li data-message-id="'.$message['id'].'"'.$self.'>';
                    $result .= $user_pic;
                    $result .= '<div class="message_container">';
                    $result .= '<div class="message_content">'.$message['content'].'</div>';
                    $result .= '<div class="message_meta">';
                    $result .= '<span class="name">'.$user_name.', </span>';
                    $result .= '<span class="date">'.$message['date'].'</span>';
                    $result .= '</div>';
                    $result .= '</div>';
                    $result .= '</li>';

                }
                $result .= '</ul>';
                $result .= message_form_admin($recipient,$m_type,$thread_id);
            } else {

            }


        //$result .= $thread_id;
        //print_r($messages);

        echo $result;
        die;
    }
}

if (!function_exists('load_thread_company')) {
	add_action( 'wp_ajax_load_thread_company', 'load_thread_company' );
	add_action( 'wp_ajax_nopriv_load_thread_company', 'load_thread_company' );
	function load_thread_company() {
		$result = '';
		$data = $_POST;
		$thread_id = $data['thread_id'];
		$comp_id = $data['comp_id'];
		$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
		$messages = $mydb->get_results("SELECT * FROM `messages` WHERE `thread_id` = '$thread_id' ORDER BY `date` ASC", ARRAY_A);
		//$result .= $thread_id;
		//print_r($messages);
		if(!empty($messages)) {
			$result .= '<ul class="messages_list messages_list_2">';
			$m_type = $messages[0]['user_type'];
			
			$current_user_id = $comp_id;
			foreach ($messages as $message) {
				$user_info = '';
				
				if($current_user_id == $message['user_id_author']) {
					$user_picture = get_field('company_icon', $message['user_id_author'] );
					$user_name = get_field('company_name',$message['user_id_author']);
					if($user_picture && $user_picture != '') {
						$user_pic = '<div class="user_picture border_circle" style="background-image: url('.$user_picture["sizes"]["thumbnail"].')"></div>';
					} else {
						$user_pic = '<div class="user_picture border_circle"></div>';
					}
					
				} else {
					$user_info = get_userdata($message['user_id_author']);
					$user_picture = get_field('photo_profile', 'user_'.$message['user_id_author'] );
					$user_name = $user_info->display_name;
					if($user_picture && $user_picture != '') {
						$user_pic = '<div class="user_picture border_circle" style="background-image: url('.$user_picture["sizes"]["thumbnail"].')"></div>';
					} else {
						$user_pic = '<div class="user_picture border_circle"></div>';
					}
				}
				
				
				if($current_user_id == $message['user_id_author']) {
					$self = ' class="self"';
				} else {
					$self = '';
					$recipient = $message['user_id_author'];
					$mydb->update(
						'messages',
						array('status_read'=> 'read'),
						array( 'id' => $message['id'] ),
						array( '%s' )
					);
				}
				$result .= '<li data-message-id="'.$message['id'].'"'.$self.'>';
				$result .= $user_pic;
				$result .= '<div class="message_container">';
					$result .= '<div class="message_content">'.$message['content'].'</div>';
					$result .= '<div class="message_meta">';
					$result .= '<span class="name">'.$user_name.', </span>';
					$result .= '<span class="date">'.$message['date'].'</span>';
					$result .= '</div>';
				$result .= '</div>';
				$result .= '</li>';
			}
			$result .= '</ul>';
			$result .= message_form_company($recipient,$m_type,$thread_id,$comp_id);
		} else {
			
		}
		echo $result;
		die;
	}
}

if (!function_exists('message_form')) {
	function message_form($recipient,$recipient_type,$thread_id) {
		$result = '';
		$result .= '<form action="'.admin_url( 'admin-ajax.php' ).'" method="post" id="messages-respond" class="from_user" data-id="'.$thread_id.'">';
		$result .= '<textarea name="comment_text" class="m_b_20"></textarea>';
		$result .= '<input type="hidden" name="action" value="new_submit_respond_messages" />';
		$result .= '<input type="hidden" name="recipient" value="'.$recipient.'" />';
		$result .= '<input type="hidden" name="recipient_type" value="'.$recipient_type.'" />';
		$result .= '<input type="hidden" name="thread_id" value="'.$thread_id.'" />';
		$result .= '<div class="respond-buttons">';
		$result .= '<input class="button button_green pointer font_small font_bold" type="submit" value="'.__('Отправить','er_theme').'" />';
		$result .= '<ul class="respond_icons">';
			$result .= '<li class="r_i_img"></li>';
			$result .= '<li class="r_i_video"></li>';
		$result .= '</ul>';
		$result .= '</div>';
		$result .= '</form>';
		return $result;
	}
}

if (!function_exists('message_form_admin')) {
    function message_form_admin($recipient,$recipient_type,$thread_id) {
        $result = '';
        $result .= '<form action="'.admin_url( 'admin-ajax.php' ).'" method="post" id="messages-respond" class="from_user">';
        $result .= '<textarea name="comment_text" class="m_b_20"></textarea>';
        $result .= '<input type="hidden" name="action" value="new_submit_respond_messages_admin" />';
        $result .= '<input type="hidden" name="recipient" value="'.$recipient.'" />';
        $result .= '<input type="hidden" name="recipient_type" value="'.$recipient_type.'" />';
        $result .= '<input type="hidden" name="thread_id" value="'.$thread_id.'" />';
        $result .= '<div class="respond-buttons">';
        $result .= '<input class="button button_green pointer font_small font_bold" type="submit" value="'.__('Отправить','er_theme').'" />';
        $result .= '<ul class="respond_icons">';
        $result .= '<li class="r_i_img"></li>';
        $result .= '<li class="r_i_video"></li>';
        $result .= '</ul>';
        $result .= '</div>';
        $result .= '</form>';
        return $result;
    }
}

if (!function_exists('message_form_company')) {
	function message_form_company($recipient,$recipient_type,$thread_id,$comp_id) {
		$result = '';
		//$result .= $comp_id;
		$result .= '<form action="'.admin_url( 'admin-ajax.php' ).'" method="post" id="messages-respond" class="from_company">';
		$result .= '<textarea name="comment_text" class="m_b_20"></textarea>';
		$result .= '<input type="hidden" name="action" value="new_submit_respond_messages_company" />';
		$result .= '<input type="hidden" name="recipient" value="'.$recipient.'" />';
		$result .= '<input type="hidden" name="author" value="'.$comp_id.'" />';
		$result .= '<input type="hidden" name="recipient_type" value="'.$recipient_type.'" />';
		$result .= '<input type="hidden" name="thread_id" value="'.$thread_id.'" />';
		$result .= '<div class="respond-buttons">';
		$result .= '<input class="button button_green pointer font_small font_bold" type="submit" value="'.__('Отправить','er_theme').'" />';
		$result .= '<ul class="respond_icons">';
			$result .= '<li class="r_i_img"></li>';
			$result .= '<li class="r_i_video"></li>';
		$result .= '</ul>';
		$result .= '</div>';
		$result .= '</form>';
		return $result;
	}
}

if (!function_exists('message_form_company_new')) {
	function message_form_company_new($recipient,$recipient_type,$thread_id,$comp_id,$company_slug) {
		$result = '';
		//$result .= $comp_id;
		$result .= '<form action="'.admin_url( 'admin-ajax.php' ).'" method="post" id="messages-respond" class="from_company_new">';
		$result .= '<textarea name="comment_text" class="m_b_20"></textarea>';
		$result .= '<input type="hidden" name="action" value="new_submit_respond_messages_company_new" />';
		$result .= '<input type="hidden" name="recipient" value="'.$recipient.'" />';
		$result .= '<input type="hidden" name="author" value="'.$comp_id.'" />';
		$result .= '<input type="hidden" name="company_slug" value="'.$company_slug.'" />';
		$result .= '<input type="hidden" name="recipient_type" value="'.$recipient_type.'" />';
		$result .= '<input type="hidden" name="thread_id" value="'.$thread_id.'" />';
		$result .= '<div class="respond-buttons">';
		$result .= '<input class="button button_green pointer font_small font_bold" type="submit" value="'.__('Отправить','er_theme').'" />';
		$result .= '<ul class="respond_icons">';
			$result .= '<li class="r_i_img"></li>';
			$result .= '<li class="r_i_video"></li>';
		$result .= '</ul>';
		$result .= '</div>';
		$result .= '</form>';
		return $result;
	}
}

if (!function_exists('new_submit_respond_messages_company')) {
	add_action( 'wp_ajax_new_submit_respond_messages_company', 'new_submit_respond_messages_company' );
	add_action( 'wp_ajax_nopriv_new_submit_respond_messages_company', 'new_submit_respond_messages_company' );
	function new_submit_respond_messages_company() {
		$result = array();
		$data = $_POST;
		$comment_text = $data['comment_text'];
		$recipient = $data['recipient'];
		$comp_id = $data['author'];
		$recipient_type = $data['recipient_type'];
		$thread_id = $data['thread_id'];
		//print_r($_POST);
		if(!$comment_text || $comment_text == '') {
			$result['status'] = 'error';
			$result['message'] = __('Пожалуйста, напишите что-нибудь','er_theme');
		} else {
			$user_id = $comp_id;
			$result['status'] = 'ok';
			$result['message'] = __('ok','er_theme');
			$result['comp_id'] = $comp_id;
			$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
			$mydb->insert('messages',
			array(
				'thread_id'=> $thread_id,
				'user_type' => $recipient_type,
				'user_id' => $recipient, 
				'user_id_author' => $user_id,
				'status_read' => 'new', 
				'content' => $comment_text
			),
			array( '%s', '%s', '%s','%s','%s','%s'));
			$result['thread_id'] = $thread_id;
		}
		echo json_encode($result);
		die;
	}
}



if (!function_exists('new_submit_respond_messages_company_new')) {
	add_action( 'wp_ajax_new_submit_respond_messages_company_new', 'new_submit_respond_messages_company_new' );
	add_action( 'wp_ajax_nopriv_new_submit_respond_messages_company_new', 'new_submit_respond_messages_company_new' );
	function new_submit_respond_messages_company_new() {
		$result = array();
		$data = $_POST;
		$comment_text = $data['comment_text'];
		$recipient = $data['recipient'];
		$company_slug = $data['company_slug'];
		$comp_id = $data['author'];
		$recipient_type = $data['recipient_type'];
		//$thread_id = $data['thread_id'];
		//print_r($_POST);
		if(!$comment_text || $comment_text == '') {
			$result['status'] = 'error';
			$result['message'] = __('Пожалуйста, напишите что-нибудь','er_theme');
		} else {
			$user_id = $comp_id;
			$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
			$mydb->insert('threads',
			array(
				'type' => 'user_company',
				'status_publish' => 'publish', 
				'users' => $recipient.','.$user_id,
			),
			array( '%s', '%s', '%s'));
			$lastid = $mydb->insert_id;
			
			$result['status'] = 'ok';
			$result['message'] = __('ok','er_theme');
			$result['comp_id'] = $comp_id;
			
			$mydb->insert('messages',
			array(
				'thread_id'=> $lastid,
				'user_type' => $recipient_type,
				'user_id' => $recipient, 
				'user_id_author' => $user_id,
				'status_read' => 'new', 
				'content' => $comment_text
			),
			array( '%s', '%s', '%s','%s','%s','%s'));
			$result['thread_id'] = $lastid;
			$result['company_slug'] = $company_slug;
		}
		echo json_encode($result);
		die;
	}
}

if (!function_exists('company_direct_message_redirect')) {
	add_action( 'wp_ajax_company_direct_message_redirect', 'company_direct_message_redirect' );
	add_action( 'wp_ajax_nopriv_company_direct_message_redirect', 'company_direct_message_redirect' );
	function company_direct_message_redirect() {
		$result = array();
		$data = $_POST;
		$user_id = $data['user_id'];
		$company_slug = $data['company_slug'];
		$company_id = $data['company_id'];
		
		
		$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
		$threads_1 = $mydb->get_results("SELECT `thread_id` FROM `messages` WHERE `user_id` = '$user_id' AND `user_id_author` = '$company_id' AND `user_type` = 'company' GROUP BY `thread_id` ORDER BY `date` DESC", ARRAY_A);
		$threads_2 = $mydb->get_results("SELECT `thread_id` FROM `messages` WHERE `user_id` = '$company_id' AND `user_id_author` = '$user_id' AND `user_type` = 'company' GROUP BY `thread_id` ORDER BY `date` DESC", ARRAY_A);
		if(!empty($threads_1)) {
			$result['type'] = 'thread';
			$result['thread_id'] = $threads_1[0]['thread_id'];
			$result['company_slug'] = $company_slug;
			$result['company_id'] = $company_id;
			$result['user_id'] = $user_id;
		} elseif(!empty($threads_2)) {
			$result['type'] = 'thread';
			$result['thread_id'] = $threads_2[0]['thread_id'];
			$result['company_slug'] = $company_slug;
			$result['company_id'] = $company_id;
			$result['user_id'] = $user_id;
		} else {
			$result['type'] = 'new';
			$result['company_slug'] = $company_slug;
			$result['company_id'] = $company_id;
			$result['user_id'] = $user_id;
		}
		
		echo json_encode($result);
		die;
	}
}

if (!function_exists('new_submit_respond_messages')) {
	add_action( 'wp_ajax_new_submit_respond_messages', 'new_submit_respond_messages' );
	add_action( 'wp_ajax_nopriv_new_submit_respond_messages', 'new_submit_respond_messages' );
	function new_submit_respond_messages() {
		$result = array();
		$data = $_POST;
		$comment_text = $data['comment_text'];
		$recipient = $data['recipient'];
		$recipient_type = $data['recipient_type'];
		$thread_id = $data['thread_id'];
		//print_r($_POST);
		if(!$comment_text || $comment_text == '') {
			$result['status'] = 'error';
			$result['message'] = __('Пожалуйста, напишите что-нибудь','er_theme');
		} else {
			$current_user = wp_get_current_user();
			$user_id = $current_user->data->ID;
			$result['status'] = 'ok';
			$result['message'] = __('ok','er_theme');
			$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
            if($thread_id == 'new_to_admin') {
                $mydb->insert('threads',
                    array(
                        'type' => 'user_admin',
                        'status_publish' => 'publish',
                        'users' => $recipient.','.$user_id,
                    ),
                    array( '%s', '%s', '%s'));
                $lastid = $mydb->insert_id;

                $result['status'] = 'ok';
                $result['message'] = __('ok','er_theme');
                $result['comp_id'] = $comp_id;

                $mydb->insert('messages',
                    array(
                        'thread_id'=> $lastid,
                        'user_type' => 'admin',
                        'user_id' => $recipient,
                        'user_id_author' => $user_id,
                        'status_read' => 'new',
                        'content' => $comment_text
                    ),
                    array( '%s', '%s', '%s','%s','%s','%s'));
                $result['thread_id'] = $lastid;
                $thread_id = $lastid;
            } else {
                $mydb->insert('messages',
                    array(
                        'thread_id'=> $thread_id,
                        'user_type' => $recipient_type,
                        'user_id' => $recipient,
                        'user_id_author' => $user_id,
                        'status_read' => 'new',
                        'content' => $comment_text
                    ),
                    array( '%s', '%s', '%s','%s','%s','%s'));
            }

			$result['thread_id'] = $thread_id;
		}
		echo json_encode($result);
		die;
	}
}

if (!function_exists('new_submit_respond_messages_admin')) {
    add_action( 'wp_ajax_new_submit_respond_messages_admin', 'new_submit_respond_messages_admin' );
    add_action( 'wp_ajax_nopriv_new_submit_respond_messages_admin', 'new_submit_respond_messages_admin' );
    function new_submit_respond_messages_admin() {
        $result = array();
        $data = $_POST;
        $comment_text = $data['comment_text'];
        $recipient = $data['recipient'];
        $recipient_type = $data['recipient_type'];
        $thread_id = $data['thread_id'];
        //print_r($_POST);
        if(!$comment_text || $comment_text == '') {
            $result['status'] = 'error';
            $result['message'] = __('Пожалуйста, напишите что-нибудь','er_theme');
        } else {
            $current_user = wp_get_current_user();
            $user_id = $current_user->data->ID;
            $result['status'] = 'ok';
            $result['message'] = __('ok','er_theme');
            $mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');

                $mydb->insert('messages',
                    array(
                        'thread_id'=> $thread_id,
                        'user_type' => $recipient_type,
                        'user_id' => $recipient,
                        'user_id_author' => 'admin',
                        'status_read' => 'new',
                        'content' => $comment_text
                    ),
                    array( '%s', '%s', '%s','%s','%s','%s'));


            $result['thread_id'] = $thread_id;
        }
        echo json_encode($result);
        die;
    }
}


if (!function_exists('company_dashboard_messages')) {
	function company_dashboard_messages($userid = NULL,$comp_id = NULL,$company_slug = NULL) {
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
		//$threads = $mydb->get_results("SELECT `thread_id` FROM `messages` WHERE `user_id` = '$comp_id' OR `user_id_author` = '$comp_id' AND `user_type` = 'company'  GROUP BY `thread_id` ORDER BY `date` DESC", ARRAY_A);
		$threads = $mydb->get_results("SELECT * FROM `messages` WHERE `user_id` = '$comp_id' OR `user_id_author` = '$comp_id' ORDER BY `date` DESC", ARRAY_A);
		
		$threads_new = array();
		if(!empty($threads)) {
			foreach($threads as $thread) {
				if(!in_array($thread['thread_id'],$threads_new)) {
					$threads_new[] = $thread['thread_id'];
				}
			}
		}
		//echo '<pre>';
		//print_r($threads_new);
		//echo '</pre>';
		//print_r($threads);
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

		$result .= company_menu($current_user,$user_id,'messages',$comp_id,$company_slug);
		$result .= '			</div>';
		$result .= '            <div class="profile-wrapper__center_sub">';
		$result .= '<div class="breadcrumbs_dashboard">';
		if (function_exists('show_breadcrumbs')) {
			$result .= show_breadcrumbs();
		}
		$result .= '</div>';
		if(!empty($threads) || $_GET['new']) {
		$result .= '<div class="user_messages_thread">';
		if($_GET['new']) {
			$result .= '<div class="new_recipients">';
			$result .= '<div class="new_recipients_title">'.__('Получатели:','er_theme').'</div>';
			$user_id_new = $_GET['new'];
				$user_info_new = get_userdata($user_id_new);
				$user_picture_new = get_field('photo_profile', 'user_'.$user_id_new );
				if($user_picture_new && $user_picture_new != '') {
							$user_pic_new = '<div class="user_picture border_circle" style="background-image: url('.$user_picture_new["sizes"]["thumbnail"].')"></div>';
						} else {
							$user_pic_new = '<div class="user_picture border_circle"></div>';
						}
				$user_names_new = $user_info_new->display_name;
				$result .= '<ul class="new_recipients_list"><li data-thread-id="new" class="active current">'.$user_pic_new.'<span class="user_name">'.$user_names_new.'</span></li></ul>';
			$result .= '</div>';
			$result .= message_form_company_new($_GET['new'],'company','new',$comp_id,$company_slug);
		}
		$result .= '</div>';
		} else {
			$result .= '<div class="user_zero_message">'.__('У вас еще нет личных сообщений. Вы можете написать пользователям, оставившим отзыв или жалобу о вашей компании, личное сообщение через раздел Отзывы или Жалобы.','er_theme').'</div>';
		}
		$result .= '</div>';
		$result .= '            <div class="profile-wrapper__right_sub">';
		if(!empty($threads_new)) {
			$result .= '<ul class="message_users_list companies">';
			foreach($threads_new as $thread) {
				//print_r($thread);
				$thread_id = $thread;
				$thread_users = $mydb->get_results("SELECT `users` FROM `threads` WHERE `id` = '$thread_id'", ARRAY_A)[0]['users'];
				$type = $mydb->get_results("SELECT `type` FROM `threads` WHERE `id` = '$thread_id'", ARRAY_A)[0]['type'];
				//echo $type;
				//print_r($thread_users[0]);
				$thread_users_array = explode(',',$thread_users);
				//print_r($thread_users_array);
				$thread_u = array();
				foreach($thread_users_array as $user) {
					if($comp_id != $user) {
						$thread_u[] = $user;
					}
				}
				//print_r($thread_u);
				if(count($thread_u) == 1) {
					
						$user_info = get_userdata($thread_u[0]);
						$user_picture = get_field('photo_profile', 'user_'.$thread_u[0] );
						$user_names = $user_info->display_name;
						if($user_picture && $user_picture != '') {
							$user_pic = '<div class="user_picture border_circle" style="background-image: url('.$user_picture["sizes"]["thumbnail"].')"></div>';
						} else {
							$user_pic = '<div class="user_picture border_circle"></div>';
						}
					
				} else {
					$user_names = 'several';
				}
				$new_items = $mydb->get_results("SELECT * FROM `messages` WHERE `status_read` = 'new' AND `thread_id` = '$thread_id' AND  `user_id_author` != '$comp_id'");
				$count_new_items = count($new_items);
				if($count_new_items > 0) {
					$new_exists = '<span class="number">'.$count_new_items.'</span>';
				} else{
					$new_exists = '';
				}
				$result .= '<li data-thread-id="'.$thread_id.'" class="inactive" id="thread_item_'.$thread_id.'" data-company-id="'.$comp_id.'">'.$user_pic.'<span class="user_name">'.$user_names.'</span>'.$new_exists.'</li>';
			}
			$result .= '</ul>';
		}
		if($_GET['thread'] != '') {
			$result .= '
			<script type="text/javascript">
			jQuery(document).ready(function($){
			//$( ".message_users_list.companies li#thread_item_'.$_GET['thread'].'" ).trigger( "click" );
			load_thread_company('.$_GET['thread'].',2307);
			
			$(".message_users_list li#thread_item_'.$_GET['thread'].'").addClass("current");
			});
			
			
			
			</script>
			';
		}
		
		if(!$_GET['thread'] && !$_GET['new']) {
			$result .= '
			<script type="text/javascript">
			jQuery(document).ready(function($){
			
			$(\'.message_users_list li\').removeClass(\'current\');
	$( ".message_users_list li" ).first().addClass( "current" );
	var thread_id_first = $(\'.message_users_list li:first-child\').attr(\'data-thread-id\');
	//alert(thread_id_first);
	load_thread_company(thread_id_first,'.$comp_id.');
			});
			
			
			</script>
			';
		}
		$result .= '</div>';
		$result .= '        </div>';
		$result .= '    </div>';
		$result .= '</div>';
		$result .= print_css_links('profile_top');
		return $result;
	}
}

if(!function_exists('my_admin_page_dm_menu')) {
    function my_admin_page_dm_menu() {
        $curr_user_id = get_current_user_id();
        if(in_array($curr_user_id,array(9,1,2,17,18022))) {
            add_menu_page(
                __( 'Сообщения', 'er_theme' ),
                __( 'Сообщения', 'er_theme' ),
                'manage_options',
                'direct_messages',
                'my_admin_page_dm',
                'dashicons-schedule',
                3
            );
        }
    }
    add_action( 'admin_menu', 'my_admin_page_dm_menu' );
}

if(!function_exists('my_admin_page_dm')) {
    function my_admin_page_dm() {
	    $get_current_user_id = get_current_user_id();
	    if ($get_current_user_id == 23375) {
		    exit;
	    }
        wp_enqueue_style('messages', get_template_directory_uri() . '/css/messages.css', [], filemtime(TEMPLATEPATH . '/css/messages.css'));
        wp_enqueue_script( 'user-messages', get_template_directory_uri() . '/js/user_admin_messages.js', array('jquery'), filemtime(TEMPLATEPATH . '/js/user-messages.js') );
        $result = '';
        $result .= '<div id="wpbody" role="main">';
            $result .= '<div id="wpbody-content">';
                $result .= '<div class="wrap">';
                    $result .= '<h1>'.__('Переписки с пользователями','er_theme').'</h1>';
                    $result .= admin_dashboard_messages();
                $result .= '</div>';
            $result .= '</div>';
        $result .= '</div>';
        echo $result;
    }
}