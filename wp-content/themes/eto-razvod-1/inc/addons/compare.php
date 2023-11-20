<?php

if (!function_exists('ajax_compare')) {
	add_action( 'wp_ajax_ajax_compare', 'ajax_compare' );
	add_action( 'wp_ajax_nopriv_ajax_compare', 'ajax_compare' );
	function ajax_compare() {
		$data = $_POST;
		//print_r($data);
		$result = array();
		if(!is_user_logged_in()) {
			$result['status'] = 'auth';
			$result['message'] = __('Чтобы добавить компанию в сравнение, пожалуйста, авторизуйтесь на сайте.','er_theme');
		} else {
			$current_user = wp_get_current_user();
			$user_id = $current_user->data->ID;
			$current = get_field('user_compare','user_'.$user_id);
			if(empty($current)) {
				update_field('user_compare',array($data['id']),'user_'.$user_id);
				$result['status'] = 'added';
			} else {
				if(!in_array($data['id'],$current)) {
					$current[] = $data['id'];
					update_field('user_compare',$current,'user_'.$user_id);
					$result['status'] = 'added';
				}  else {
					if (($key = array_search($data['id'], $current)) !== false) {
						unset($current[$key]);
						update_field('user_compare',$current,'user_'.$user_id);
					}
					$result['status'] = 'deleted';
				} 
			}
		}
		echo json_encode($result);
		
		die;
	}
}

if (!function_exists('compare_icon_ajax')) {
	add_action( 'wp_ajax_compare_icon_ajax', 'compare_icon_ajax' );
	add_action( 'wp_ajax_nopriv_compare_icon_ajax', 'compare_icon_ajax' );
	function compare_icon_ajax() {
		$result = '';
		$post_id = $_POST['post_id'];
		if (function_exists('compare_icon')) {
			$result .= compare_icon($post_id);
		}
		echo $result;
		die;
	}
}

if (!function_exists('compare_icon')) {
	function compare_icon($post_id) {
		$result = '';
		if(is_user_logged_in()) {
			$current_user = wp_get_current_user();
			$user_id = $current_user->data->ID;
			$current = get_field('user_compare','user_'.$user_id);
			if( is_array( $current ) && in_array( $post_id, $current ) ) {
				$active = ' active';
			} else {
				$active = '';
			}
		} else {
			$active = '';
		}
		$result .= '<span class="review_icon_compare pointer icon_compare'.$active.'" id="compare_post_'.$post_id.'" data-id="'.$post_id.'"></span>';
		return $result;
	}
}