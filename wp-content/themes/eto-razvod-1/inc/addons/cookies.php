<?php
if(!function_exists('check_cookie')) {
	function check_cookie($cookie_id) {
		if(isset($_COOKIE[$cookie_id])) {
			$result = 'yes';
		} else {
			$result = 'no';
		}
		return $result;
	}
}
if(!function_exists('set_cookie')) {
	function set_cookie($cookie_id,$cookie_time){
		$visit_time = date('F j, Y  g:i a');
		if(isset($_COOKIE[$cookie_id])) {
			$result = 'yes';
		} else {
			$result = 'no';
		}
		if(!isset($_COOKIE[$cookie_id])) {
			setcookie($cookie_id, $visit_time, time()+$cookie_time, '/');
			$result = 'set';
		}
		return $result;
	}
}

if(!function_exists('check_user_logged_in')) {
    add_action('wp_ajax_check_user_logged_in', 'check_user_logged_in');
    add_action('wp_ajax_nopriv_check_user_logged_in', 'check_user_logged_in');
    function check_user_logged_in() {
        $result = array();
        if(!is_user_logged_in()) {
            $result['status'] = 'error';
            $result['message'] = __('Необходимо авторизоваться','er_theme');
        } else {
            $result['status'] = 'ok';
            $result['message'] = '';
            $result['user_id'] = get_current_user_id();
        }
        echo json_encode($result);
        die;
    }

}