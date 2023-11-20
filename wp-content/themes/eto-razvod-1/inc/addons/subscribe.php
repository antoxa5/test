<?php

if (!function_exists('ajax_subscribe')) {
	add_action( 'wp_ajax_ajax_subscribe', 'ajax_subscribe' );
	add_action( 'wp_ajax_nopriv_ajax_subscribe', 'ajax_subscribe' );
	function ajax_subscribe() {
        $current_language = get_locale();
        if($current_language != 'ru_RU')  {
            $v_text_tosubscribe = __('To sign up for company updates, please log in.','er_theme');
            $v_text_youaresubscribed = __('You have successfully subscribed','er_theme');
        } else {
            $v_text_tosubscribe = __('Чтобы подписаться на обновления компании, пожалуйста, авторизуйтесь на сайте.','er_theme');
            $v_text_youaresubscribed = __('Вы успешно подписались','er_theme');
        }
		$data = $_POST;		
		$result = array();
		if(!is_user_logged_in()) {
			$result['status'] = 'auth';
			$result['message'] = $v_text_tosubscribe;
		} else {
			$current_user = wp_get_current_user();
			$user_id = $current_user->data->ID;
			$current = get_field('user_subscriptions_posts','user_'.$user_id);
			if(empty($current)) {
				update_field('user_subscriptions_posts',array($data['id']),'user_'.$user_id);
				$result['status'] = 'added';
				$result['message'] = $v_text_youaresubscribed;
				notify_user_action('system_new_subscriber',$data['id'],__('Новая подписка на вашу компанию!','er_theme'),$user_id);
			} else {
				if(!in_array($data['id'],$current)) {
					$current[] = $data['id'];
					update_field('user_subscriptions_posts',$current,'user_'.$user_id);
					$result['status'] = 'added';
					$result['message'] = $v_text_youaresubscribed;
					notify_user_action('system_new_subscriber',$data['id'],__('Новая подписка на вашу компанию!','er_theme'),$user_id);
				}  else {
					if (($key = array_search($data['id'], $current)) !== false) {
						unset($current[$key]);
						update_field('user_subscriptions_posts',$current,'user_'.$user_id);
					}
					$result['status'] = 'deleted';
					$result['message'] = __('Подписаться на эту компанию','er_theme');
				} 
			}
		}
		echo json_encode($result);
		
		die;
	}
}

if (!function_exists('post_subscribe_icon')) {
	function post_subscribe_icon($post_id) {
		$result = '';
		if(is_user_logged_in()) {
			$current_user = wp_get_current_user();
			$user_id = $current_user->data->ID;
			$current = get_field('user_subscriptions_posts','user_'.$user_id);
			if(in_array($post_id,$current)) {
				$active = ' active';
			} else {
				$active = '';
			}
		} else {
			$active = '';
		}
		$result .= '<span class="icon_subscribe pointer'.$active.'" data-id="'.$post_id.'" data-type="post" id="subscribe_post_'.$post_id.'"></span>';
		return $result;
	}
}



if (!function_exists('ajax_subscribe_block')) {
	add_action( 'wp_ajax_ajax_subscribe_block', 'ajax_subscribe_block' );
	add_action( 'wp_ajax_nopriv_ajax_subscribe_block', 'ajax_subscribe_block' );
	function ajax_subscribe_block() {
		$data = $_POST;
		$post_id = $data['post_id'];
		if(get_post_type($data['post_id']) == 'promocodes') {
				$post_id = get_field('promocode_review',$data['post_id']);
			}
		if(is_user_logged_in()) {
			$current_user = wp_get_current_user();
			$user_id = $current_user->data->ID;
			$current = get_field('user_subscriptions_posts','user_'.$user_id);
			if(in_array($post_id,$current)) {
				$active = ' active';
				$text = __('Вы подписаны','er_theme');
			} else {
				$active = '';
				if(get_post_type($data['post_id']) == 'promocodes') {
					$text = __('Узнать первым о новых промокодах','er_theme');
				} else {
					$text = __('Подписаться на эту компанию','er_theme');
				}
				
			}
		} else {
			$active = '';
			if(get_post_type($data['post_id']) == 'promocodes') {
					$text = __('Узнать первым о новых промокодах','er_theme');
				} else {
					$text = __('Подписаться на эту компанию','er_theme');
				}
		}
		
		$result = '';
		$current = get_field('user_subscriptions_posts','user_'.$user_id);
		$result .= '<div class="side_block white_block subscribe_widget" id="subscribe_post_'.$post_id.'">';
			$result .= '<div class="block_content flex">';
				$result .= '<span class="font_underline font_bold font_smaller pointer subscribe_link'.$active.'" data-id="'.$post_id.'" data-type="post" >'.$text.'</span>';
				$result .= '<span class="alertsimg'.$active.'"></span>';
			$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}

function ajax_subscribe_block_php() {
	$data['post_id'] = get_the_ID();
	$post_id = $data['post_id'];
	if(get_post_type($data['post_id']) == 'promocodes') {
		$post_id = get_field('promocode_review',$data['post_id']);
	}
	if(is_user_logged_in()) {
		$current_user = wp_get_current_user();
		$user_id = $current_user->data->ID;
		$current = get_field('user_subscriptions_posts','user_'.$user_id);
		if(is_array($current) && in_array($post_id, $current)) {
			$active = ' active';
			$text = __('Вы подписаны','er_theme');
		} else {
			$active = '';
			if(get_post_type($data['post_id']) == 'promocodes') {
				$text = __('Узнать первым о новых промокодах','er_theme');
			} else {
				$text = __('Подписаться на эту компанию','er_theme');
			}
			
		}
	} else {
		$active = '';
		if(get_post_type($data['post_id']) == 'promocodes') {
			$text = __('Узнать первым о новых промокодах','er_theme');
		} else {
			$text = __('Подписаться на эту компанию','er_theme');
		}
	}
	
	$result = '';
	$current = get_field('user_subscriptions_posts','user_'.$user_id);
	$result .= '<div class="side_block white_block subscribe_widget" id="subscribe_post_'.$post_id.'">';
	$result .= '<div class="block_content flex">';
	$result .= '<span class="font_underline font_bold font_smaller pointer subscribe_link'.$active.'" data-id="'.$post_id.'" data-type="post" >'.$text.'</span>';
	$result .= '<span class="alertsimg'.$active.'"></span>';
	$result .= '</div>';
	$result .= '</div>';
	return $result;
}
if (!function_exists('ajax_email_subscribe')) {
	add_action( 'wp_ajax_ajax_email_subscribe', 'ajax_email_subscribe' );
	add_action( 'wp_ajax_nopriv_ajax_email_subscribe', 'ajax_email_subscribe' );
	function ajax_email_subscribe() {
		$email = $_POST['email'];
		$result = array();
		if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
		//if(!$email || $email == '') {
			$result['status']= 'error';
			$result['message']= __('Пожалуйста, укажите E-mail', 'er_theme');
		} else {
			$mail_key = wp_generate_uuid4();
			$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');
			$subscribed = $mydb->get_results("select * from subscribers WHERE user_email = '$email'");
			if(!empty($subscribed)) {
				$result['status']= 'error';
				$result['message']= __('Вы уже подписались ранее', 'er_theme');
			} else {
			
			$mydb->insert(
				'subscribers',
				array(
					'user_email'=> $email,
					'wp_id' => 0,
					'status' => 'unverified', 
					'key' => $mail_key
				),
				array( '%s', '%s', '%s', '%s')
			);
			$result['status']= 'ok';
			$result['message']= __('Вы успешно подписались', 'er_theme');
				
				
				
			$api_key = 'e9c51614cdd55d1e810e44e5499d8d77';
			
			$add_names = '';
			if (!empty(wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'first_name', true ))))) {
				$add_names .= '&merge_1='.wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'first_name', true )));
			}
			
			if (!empty(wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'last_name', true ))))) {
				$add_names .= '&merge_2='.wp_strip_all_tags(htmlspecialchars(get_user_meta( $user_id, 'last_name', true )));
			}
			
			$url = 'https://api.dashamail.ru/?method=lists.add_member&&api_key=e9c51614cdd55d1e810e44e5499d8d77&list_id=142139&email='.$email.$add_names.'&format=xml';
			
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
		echo json_encode($result);
		die;
	}
}