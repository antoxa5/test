<?php

if(!function_exists('popup_alert_message')) {
	add_action( 'wp_ajax_popup_alert_message', 'popup_alert_message' );
	add_action( 'wp_ajax_nopriv_popup_alert_message', 'popup_alert_message' );
	function popup_alert_message() {
		$data = $_POST;
		$result = '';
		$result .= '<div class="popup_container" id="popup_'.$data['type'].'">';
					$result .= '<div class="popup_window box_shadow">';
						$result .= '<div class="popup_close_button pointer"></div>';
						if($data['type'] == 'error') {
							$color = 'color_red';
						} elseif($data['type'] == 'ok') {
							$color = 'color_green';
						} else {
							$color = 'color_dark_blue';
						}
						$result .= '<div class="p_30 flex flex_column '.$color.' font_small">';
							$result .= $data['message'];
						$result .= '</div>';
					$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}

if(!function_exists('popup_form_ajax')) {
	add_action( 'wp_ajax_popup_form_ajax', 'popup_form_ajax' );
	add_action( 'wp_ajax_nopriv_popup_form_ajax', 'popup_form_ajax' );
	function popup_form_ajax() {
		$data = $_POST;
		$result = '';
		if($data['type'] == 'alert') {
		} else {
			
			if(!is_user_logged_in() && $data['type'] == 'review' || !is_user_logged_in() && $data['type'] == 'abuse') {
				$result .= print_js_links()['events'];
				$result .= popup_auth_not_ajax();
			} else {
				$result .= '<div class="popup_container" id="popup_'.$data['type'].'">';
					$result .= '<div class="popup_window box_shadow">';
					$result .= '<div class="popup_close_button pointer"></div>';
					$result .= print_css_links('popup_forms');
					if($data['type'] == 'review') {
						$result .= form_review($data['post_id']);
					} elseif($data['type'] == 'abuse') {
						$result .= form_abuse($data['post_id']);
					} elseif ($data['type'] == 'share_post') {
						$link = get_the_permalink($data['post_id']);
						$result .= '<div class="p_30 flex flex_column">';
						$result .= '<div class="title color_dark_blue font_bold m_b_20">'.__('Поделиться страницей','er_theme').'</div>';
						$result .= '<ul class="popup_share_icons">';
						$result .= '<li data-link="http://vk.com/share.php?url='.$link.'" class="share_icon_vk">ВК</li>';
						$result .= '</ul>';
						$result .= '</div>';
					} elseif ($data['type'] == 'share_comment') {
						$result .= '<div class="p_30 flex flex_column">';
						$result .= '<div class="title color_dark_blue font_bold m_b_20">'.__('Поделиться комментарием','er_theme').'</div>';
						$result .= '<ul class="popup_share_icons">';
						$result .= '<li data-link="'.$data['post_id'].'" class="share_icon_vk">ВК comment</li>';
						$result .= '</ul>';
						$result .= '</div>';

					} elseif ($data['type'] == 'permalik_comment') {
						$result .= '<div class="p_30 flex flex_column">';
						$result .= '<div class="title color_dark_blue font_bold m_b_20">'.__('Ссылка на комментарий','er_theme').'</div>';
						$result .= '<input type="text" value="'.get_comment_link($data['post_id']).'" />';
						$result .= '</div>';
					}

					$result .= '</div>';
				$result .= '</div>';
			}
		}
		echo $result;
		die;
	}
}

if(!function_exists('form_review')) {
	function form_review($post_id) {
		$result = '';
		$rating_fields_group = get_rating_fields_group(95);
		$ratings = get_comment_rating_fields($rating_fields_group,'key');
		if($rating_fields_group != 0) {
			$result .= '<form action="'.admin_url( 'admin-ajax.php' ).'" method="post" id="popup_form_review">';
			$result .= print_css_links('review_form');
			$result .= '<div class="title color_dark_blue font_bold font_uppercase">'.__('Добавить отзыв','er_theme').'</div>';
			$result .= '<textarea name="comment_text" class="m_b_20"></textarea>';
			$result .= '<input type="hidden" name="action" value="new_submit_review" />';
			$result .= '<input type="hidden" name="post_id" value="'.$post_id.'" />';
			$result .= '<div class="title color_dark_blue font_bold font_uppercase">'.__('Оценка','er_theme').'</div>';
			$result .= '<div class="rating_columns flex m_b_20">';
			foreach ($ratings as $item) {
				$result .= '<div class="form_rating flex">';
				$result .= '<div class="form_field_name color_dark_gray font_small">'.$item['field_label'].'</div>';
				$result .= '<div class="rating">';
				$result .= rating_field($item['field_min'],$item['field_max'],'rating',$item['field_name']);
				$result .= '</div>';
				$result .= '</div>';
			}
			$result .= '</div>';
			$result .= '<ul class="review_form_icons flex">';
				$result .= '<li class="form_icon_img inactive"></li>';
				$result .= '<li class="form_icon_notify inactive"></li>';
				$result .= '<li class="form_icon_link inactive"></li>';
			$result .= '</ul>';
			$result .= '<input class="button button_big button_green m_b_10 pointer" type="submit" value="'.__('Разместить отзыв','er_theme').'" />';
			$result .= '</form>';
		}
		return $result;
	}
}

if(!function_exists('form_abuse')) {
	function form_abuse($post_id) {
		$result = '';
			$result .= '<form action="'.admin_url( 'admin-ajax.php' ).'" method="post" id="popup_form_abuse">';
			$company_name = get_field('company_name',$post_id);
			$result .= print_css_links('review_form');
			$result .= '<div class="title color_dark_blue">'.__('Жалоба на компанию','er_theme').' <span class="text_underline">'.$company_name.'</span></div>';
			$result .= '<textarea name="comment_text" class="m_b_20"></textarea>';
			$result .= '<input type="hidden" name="action" value="new_submit_review" />';
			$result .= '<input type="hidden" name="post_id" value="'.$post_id.'" />';
			$result .= '<input type="hidden" name="is_abuse" value="yes" />';
			$result .= '<ul class="review_form_icons flex">';
				$result .= '<li class="form_icon_img inactive"></li>';
				$result .= '<li class="form_icon_notify inactive"></li>';
				$result .= '<li class="form_icon_link inactive"></li>';
			$result .= '</ul>';
			$result .= '<input class="button button_big button_violet m_b_10 pointer" type="submit" value="'.__('Разместить жалобу','er_theme').'" />';
			$result .= '</form>';
		return $result;
	}
}

if(!function_exists('popup_auth_not_ajax')) {
function popup_auth_not_ajax(){
		$result = '';
		$result .= print_js_links()['auth'];
		$result .= '<div class="popup_container" id="popup_auth">';
			$result .= '<div class="popup_window box_shadow">';
			$result .= '<div class="popup_close_button pointer"></div>';
				$result .= '<div class="popup_columns two_columns">';
					$result .= '<div class="popup_column_left flex_column align_left flex_padding">';
						$result .= '<div class="title font_big color_dark_blue font_bold m_b_20">'.__('Вход','er_theme').'</div>';
						$result .= '<form class="regform flex flex_column"  action="'.admin_url( 'admin-ajax.php' ).'" method="post" id="popup_auth_form">';
						$result .= '<input type="hidden" name="action" value="user_login" />';
						$result .= '<input type="text" name="email" placeholder="'.__('Ваш E-mail','er_theme').'" class="input_big m_b_10 placeholder_dark">';
						$result .= '<input type="password" name="password" placeholder="'.__('Пароль','er_theme').'" class="input_big m_b_10 placeholder_dark">';
						$result .= '<div class="checkbox_container m_b_10">';
                        	$result .= '<input type="checkbox" id="remember__input" name="remember" checked="checked">';
                            $result .= '<label for="remember__input">'.__('Запомнить меня','er_theme').'</label>';
                        $result .= '</div>';
						$result .= '<input type="submit" name="submit" class="button button_big button_green m_b_10 pointer" value="'.__('Войти','er_theme').'" id="regbtn">';
						$result .= '<div class="link_container"><span class="span_link link_recover_popup color_blue pointer">'.__('Восстановить пароль','er_theme').'</span></div>';
						$result .= '</form>';
					$result .= '</div>';
					$result .= '<div class="popup_column_right flex_column align_left">';
						$result .= '<div class="row_border_bottom flex_row flex_padding">';
							$result .= '<div class="title color_dark_blue font_bold m_b_20">'.__('Используйте сервисы для входа','er_theme').'</div>';
						$result .= social_login_icons('full');
						$result .= '</div>';
						
						$result .= '<div class="flex_row flex_padding">';
							$result .= '<div class="title color_dark_blue font_bold m_b_20">'.__('У вас еще нет аккаунта?','er_theme').'</div>';
							$result .= '<div class="button button_big button_violet m_b_10 pointer reg_link">'.__('Создать аккаунт','er_theme').'</div>';
							$result .= '<div class="link_container"><span class="span_link link_terms_popup color_blue pointer">'.__('Условия пользования сайтом','er_theme').'</span></div>';
						$result .= '</div>';
					$result .= '</div>';
				$result .= '</div>';
			$result .= '</div>';
		$result .= '</div>';
		return $result;
	}
}

if(!function_exists('upload_file_url')) {
	function upload_file_url($url) {
        $timeout_seconds = 5;
        $temp_file = download_url( $url, $timeout_seconds );
        $typeimg = wp_check_filetype(basename($url));
        if ( !is_wp_error( $temp_file ) ) {
			$file = array(
				'name'     => basename($url), 
				'type'     => $typeimg['type'],
				'tmp_name' => $temp_file,
				'error'    => 0,
				'size'     => filesize($temp_file),
			);
			$arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
			if (in_array($file['type'], $arr_img_ext)) {
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				require_once( ABSPATH . 'wp-admin/includes/media.php' );
			}
		}
		
		
        /*$temp_file = download_url( $url, $timeout_seconds );
		$arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
		$typeimg = wp_check_filetype(basename($url));
		if (in_array($typeimg, $arr_img_ext)) {
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			if ( !is_wp_error( $temp_file ) ) {
				$attachment_id = media_handle_upload( $temp_file, 0 );
			}
		}*/
	}
}

if(!function_exists('ajax_upload_file')) {
	add_action( 'wp_ajax_ajax_upload_file', 'ajax_upload_file' );
	add_action( 'wp_ajax_nopriv_ajax_upload_file', 'ajax_upload_file' );
	function ajax_upload_file() {
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
				$result = array(
					'status' => 'ok',
					'message' => __('Изображение успешно загружено','er_theme'),
					'file_id' => $attachment_id,
					'file_url' => $file_url,
					'thumb_url' => $thumb_url
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

if(!function_exists('ajax_append_form_images')) {
	add_action( 'wp_ajax_ajax_append_form_images', 'ajax_append_form_images' );
	add_action( 'wp_ajax_nopriv_ajax_append_form_images', 'ajax_append_form_images' );
	function ajax_append_form_images() {
		$result = '';
		$result .= '<ul class="form_add_images flex">';
			$result .= '<li class="add_new pointer"><label><input type="file" id="fileavatar_comment" accept="image/*"></label></li>';
		$result .= '</ul>';
		echo $result;
		die;
	}
}

if(!function_exists('append_new_comment')) {
	add_action( 'wp_ajax_append_new_comment', 'append_new_comment' );
	add_action( 'wp_ajax_nopriv_append_new_comment', 'append_new_comment' );
	function append_new_comment() {
		$data = $_POST;
		$args['comment__in'] = $data['comment_id'];
		$new_comment = get_comments($args);
		$post_id = $new_comment[0]->comment_post_ID;
		if(function_exists('get_rating_fields_group')) {
			$rating_fields_group = get_rating_fields_group($post_id);
		} else {
			$rating_fields_group = 0;
		}
		if($data['type'] == 'review') {
			wp_list_comments( array(
			'callback' => 'custom_comment_single',
			//'per_page' => -1,
			'rating_fields' => get_comment_rating_fields($rating_fields_group,'key'),
		),$new_comment);
		} elseif($data['type'] == 'abuse') {
			wp_list_comments( array(
			'callback' => 'custom_abuse_single',
			//'per_page' => -1,
			'rating_fields' => get_comment_rating_fields($rating_fields_group,'key'),
		),$new_comment);
		}
		
		die;
	}
}

if(!function_exists('new_submit_review')) {
	add_action( 'wp_ajax_new_submit_review', 'new_submit_review' );
	add_action( 'wp_ajax_nopriv_new_submit_review', 'new_submit_review' );
	function new_submit_review() {
		$data = $_POST;
		//print_r($data);
		$files = $data['files'];
		$links = $data['links'];
		$cur_user_id = get_current_user_id();
		$user_info = get_userdata($cur_user_id);
		$commentdata = array(
			'comment_post_ID'      => $data['post_id'],
			'comment_content'      => htmlspecialchars($data['comment_text']),
			'comment_author'       => $user_info->display_name,
			'comment_author_email' => $user_info->user_email,
			'comment_type'         => 'comment',
			'user_ID'              => $cur_user_id,
		);
		//print_r($commentdata);
		$result = array();
		if (strlen(preg_replace('/\s+/', '', $commentdata['comment_content'])) == 0) {
			$result['status'] = 'error';
			$result['message'] = __('Вы не написали отзыв','er_theme');
		} else {
			$new_comment = wp_new_comment( $commentdata, true );
			if( is_wp_error( $new_comment ) ) {
				$result['status'] = 'error';
				$result['message'] = $new_comment->get_error_message();
			} else{
				if($new_comment && !empty($data['rating']) && $data['comment_text']) {
					foreach ($data['rating'] as $key => $value) {
						update_field($key,$value,'comment_'.$new_comment);
					}
				}
				if($new_comment) {
					update_field('field_5fce35905450b',0,'comment_'.$new_comment);
					if(!empty($files)) {
					  foreach($files as $file) {
						if(array_key_exists($file, $links)) {

						  $row = array(
							'file_type' => 'url',
							'file' => $file,
							'link' => $links[$file]
						  );
						} else {
						  $row = array(
							'file_type' => 'image',
							'file' => $file
						  );
						}
						//print_r($row);
						add_row('comment_files',$row,'comment_'.$new_comment);
					  }
					}
					$result['status'] = 'ok';
					if($data['is_abuse']) {
						update_field('is_abuse',1,'comment_'.$new_comment);
						$result['message'] = __('Ваша жалоба ожидает модерации','er_theme');
						update_field('comment_type','abuses','comment_'.$new_comment);
					} else {
						update_field('comment_type','reviews','comment_'.$new_comment);
						$result['message'] = __('Ваш отзыв ожидает модерации','er_theme');
					}
					$result['comment_id'] = $new_comment;
				} else {
					$result['status'] = 'error';
					$result['message'] = __('Возникла ошибка','er_theme');
				}
			}
		}
		//print_r($result);
		echo json_encode($result);
		die;
	}
}