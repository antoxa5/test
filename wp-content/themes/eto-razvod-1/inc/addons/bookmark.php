<?php

if (!function_exists('ajax_bookmark')) {
	add_action( 'wp_ajax_ajax_bookmark', 'ajax_bookmark' );
	add_action( 'wp_ajax_nopriv_ajax_bookmark', 'ajax_bookmark' );
	function ajax_bookmark() {
		$data = $_POST;
		//print_r($data);
		$result = array();

		if(!is_user_logged_in()) {
			$result['status'] = 'auth';
			$result['message'] = __('Чтобы добавить страницу в избранное, пожалуйста, авторизуйтесь на сайте.','er_theme');
		} else {
			$current_user = wp_get_current_user();
			$user_id = $current_user->data->ID;
			$current = get_field('user_bookmarks','user_'.$user_id);
			if(empty($current)) {
				update_field('user_bookmarks',array($data['id']),'user_'.$user_id);
				$result['status'] = 'added';
			} else {
				if(!in_array($data['id'],$current)) {
					$current[] = $data['id'];
					update_field('user_bookmarks',$current,'user_'.$user_id);
					$result['status'] = 'added';
				}  else {
					if (($key = array_search($data['id'], $current)) !== false) {
						unset($current[$key]);
						update_field('user_bookmarks',$current,'user_'.$user_id);
					}
					$result['status'] = 'deleted';
				} 
			}
		}
		echo json_encode($result);
		
		die;
	}
}

if (!function_exists('single_review_icons')) {
	add_action( 'wp_ajax_single_review_icons', 'single_review_icons' );
	add_action( 'wp_ajax_nopriv_single_review_icons', 'single_review_icons' );
	function single_review_icons() {
		$result = '';
		$post_id = $_POST['post_id'];
		if(get_post_type($_POST['post_id']) == 'promocodes') {
				$post_id = get_field('promocode_review',$_POST['post_id']);
			}
		if (function_exists('bookmark_icon')) {
			$result .= bookmark_icon($post_id);
		}
		$result .= '<li class="icon_share pointer review_icon_share pointer" data-id="'.$post_id.'" data-type="post" id="share_post_'.$post_id.'"></li>';
		echo $result;
		die;
	}
}

if (!function_exists('bookmark_icon')) {
	function bookmark_icon($post_id) {
		$result = '';
		if(get_post_type($post_id) == 'promocodes') {
				$post_id = get_field('promocode_review',$post_id);
			}
		if(is_user_logged_in()) {
			$current_user = wp_get_current_user();
			$user_id = $current_user->data->ID;
			$current = get_field('user_bookmarks','user_'.$user_id);
			if(in_array($post_id,$current)) {
				$active = ' active';
			} else {
				$active = '';
			}
		} else {
			$active = '';
		}
		$result .= '<li class="review_icon_favorites pointer icon_bookmark'.$active.'" id="bookmark_post_'.$post_id.'" data-id="'.$post_id.'"></li>';
		return $result;
	}
}