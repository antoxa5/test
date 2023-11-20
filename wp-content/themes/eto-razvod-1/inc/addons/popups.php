<?php

if ( ! function_exists( 'popup_alert_message' ) ) {
	add_action( 'wp_ajax_popup_alert_message', 'popup_alert_message' );
	add_action( 'wp_ajax_nopriv_popup_alert_message', 'popup_alert_message' );
	function popup_alert_message() {
		$data   = $_POST;
		$result = '';
		$result .= '<div class="popup_container" id="popup_' . $data['type'] . '">';
		$result .= '<div class="popup_window box_shadow">';
		$result .= '<div class="popup_close_button pointer"></div>';
		if ( $data['type'] == 'image' ) {
			$result .= '<div class="p_30 flex flex_column font_small">';
			$result .= '<img src="' . $data['message'] . '" style="max-width:1000px;" />';
			$result .= '</div>';
		} elseif ( $data['type'] == 'single_promocode' ) {
			$string = $data['message'];
			$array  = explode( '_', $string );
			$result .= '<div class="p_30 flex flex_column font_small">';
			$num    = $array[3] - 1;
			$item   = get_field( 'promocodes_items', $array[2] )[ $num ];
			$result .= '<div class="promocode_button_container">';
			$result .= '<div class="promocode_text_container" id="promocode_text_container_' . $array[2] . '_' . $array[3] . '">';
			$result .= '<div class="promocode_single_text" id="promocode_text_' . $array[2] . '_' . $array[3] . '">' . $item['text'] . '</div>';
			$result .= '<input value="' . $item['text'] . '" type="text" id="promocode_text_' . $array[2] . '_' . $array[3] . '_input" style="position: absolute;z-index: -99999;">';
			$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold promocode_3" href="' . get_bloginfo( 'url' ) . '/visit2/' . $array[2] . '-' . $array[3] . '/" target="_blank" rel="nofollow">' . __( 'Получить', 'er_theme' ) . '</a>';
			$result .= '<div class="link_promocode_text_copy_popup button button_green button_centered m_t_20 pointer font_smaller font_bold">' . __( 'Скопировать', 'er_theme' ) . '</div>';
			$result .= '</div>';
			$result .= '</div>';
			$result .= '</div>';
			
		} elseif ( $data['type'] == 'copy_widget' ) {
			$result .= '<div class="p_30 flex flex_column font_small" style="width:300px;">';
			$result .= '<span class="copy_widget_title">Разместите данный код на вашем сайте</span>';
			$result .= '<textarea readonly style="resize: none;"><a href="https://etorazvod.ru/"><img src="https://etorazvod.ru/widget/rate_img_mini.png" alt=""></a></textarea>';
			$result .= '<div class="copy_code_widget button button_green font_small font_bold pointer m_t_20">Скопировать</div></div>';
			
		} else {
			if ( $data['type'] == 'error' ) {
				$color = 'color_red';
			} elseif ( $data['type'] == 'ok' ) {
				$color = 'color_green';
			} else {
				$color = 'color_dark_blue';
			}
			$result .= '<div class="p_30 flex flex_column ' . $color . ' font_small" style="max-width:300px;">';
			$result .= $data['message'];
			$result .= '</div>';
		}
		$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}


if ( ! function_exists( 'popup_form_ajax' ) ) {
	add_action( 'wp_ajax_popup_form_ajax', 'popup_form_ajax' );
	add_action( 'wp_ajax_nopriv_popup_form_ajax', 'popup_form_ajax' );
	function popup_form_ajax() {
		$data   = $_POST;
		$result = '';
		if ( $data['type'] == 'alert' ) {
		} else {
			
			if ( ! is_user_logged_in() && $data['type'] == 'review' || ! is_user_logged_in() && $data['type'] == 'abuse' ) {
				$result .= print_js_links()['events'];
				$result .= popup_auth_not_ajax();
			} else {
				$result .= '<div class="popup_container" id="popup_' . $data['type'] . '">';
				$result .= '<div class="popup_window box_shadow">';
				$result .= '<div class="popup_close_button pointer"></div>';
				$result .= print_css_links( 'popup_forms' );
				if ( $data['type'] == 'review' ) {
					$result .= form_review( $data['post_id'] );
				} elseif ( $data['type'] == 'abuse' ) {
					$result .= form_abuse( $data['post_id'] );
				} elseif ( $data['type'] == 'share_post' ) {
					$link       = get_the_permalink( $data['post_id'] );
					$post_title = get_the_title( $data['post_id'] );
					$result     .= '<div class="p_30 flex flex_column asfasf">';
					$result     .= '<div class="title color_dark_blue font_bold m_b_20">' . __( 'Поделиться страницей', 'er_theme' ) . '</div>';
					$result     .= '<div class="social_share_links" id="social_share_popup">';
					$result     .= '<ul>';
					$buttons    = social_buttons_array();
					$post_link  = get_the_permalink( $data['post_id'] );
					foreach ( $buttons as $item ) {
						$item_count = 0;
						
						if ( $item['id'] == 'pinterest' ) {
							$link = 'https://pinterest.com/pin/create/button/?url=' . $post_link;
						} elseif ( $item['id'] == 'email' ) {
							$link = 'mailto:?&subject=&cc=&bcc=&body=' . $post_link;
						} elseif ( $item['id'] == 'linkedin' ) {
							$link = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $post_link;
							
						} elseif ( $item['id'] == 'facebook' ) {
							$link = 'https://www.facebook.com/sharer/sharer.php?u=' . $post_link;
						} elseif ( $item['id'] == 'vkontakte' ) {
							$link = 'https://vk.com/share.php?url=' . $post_link;
						} elseif ( $item['id'] == 'odnoklassniki' ) {
							$link = 'https://connect.ok.ru/offer?url=' . $post_link;
						} elseif ( $item['id'] == 'telegram' ) {
							$link = 'https://telegram.me/share/url?url=' . $post_link;
						} elseif ( $item['id'] == 'viber' ) {
							$link = 'viber://forward?text=' . $post_link;
						} elseif ( $item['id'] == 'whatsapp' ) {
							$link = 'whatsapp://send?text=' . $post_link;
						} else {
							$link = $post_link;
						}
						$item_count_get = get_field( 'social_shares_' . $item['id'], $data['post_id'] );
						if ( $item_count_get && $item_count_get > 0 ) {
							$item_count = $item_count_get;
						}
						$result .= '<li class="social_item_icon_' . $item['id'] . '" data-social-id="' . $item['id'] . '" data-post-id="' . $data['post_id'] . '" data-link="' . $link . '">';
						
						if ( $item_count > 0 ) {
							$result .= '<span class="social_item_count">' . $item_count . '</span>';
						} else {
							$result .= '<span class="social_item_count social_item_count_empty"></span>';
						}
						$result .= '</li>';
					}
					/*$result .= '<a href="viber://forward?text='.$post_title.' '.$link.'" class="share_icon_viber" target="_blank"></a>';
                    $result .= '<a href="https://api.whatsapp.com/send?text='.$post_title.' '.$link.'" class="share_icon_whatsapp" target="_blank"></a>';
                    $result .= '<a href="https://t.me/share/url?url='.$link.'&text='.$post_title.'" class="share_icon_telegram" target="_blank"></a>';
                    $result .= '<a href="https://twitter.com/intent/tweet?text='.$post_title.'&url='.$link.'" class="share_icon_twitter" target="_blank"></a>';
                    */
					$result .= '</ul>';
					$result .= '</div>';
					$result .= '</div>';
				} elseif ( $data['type'] == 'share_search' ) {
					$link   = $data['post_id'];
					$result .= '<div class="p_30 flex flex_column afasf3011">';
					$result .= '<div class="title color_dark_blue font_bold m_b_20">' . __( 'Поделиться страницей', 'er_theme' ) . '</div>';
					$result .= '<ul class="popup_share_icons">';
					$result .= '<a href="https://vk.com/share.php?url=' . $link . '&title=' . $post_title . '" class="share_icon_vk" target="_blank"></a>';
					/*$result .= '<li data-link="https://connect.ok.ru/offer?url='.$link.'&title='.$post_title.'" class="share_icon_odnoklassniki"></li>';*/
					$result .= '<a href="viber://forward?text=' . $post_title . ' ' . $link . '" class="share_icon_viber" target="_blank"></a>';
					$result .= '<a href="https://api.whatsapp.com/send?text=' . $post_title . ' ' . $link . '" class="share_icon_whatsapp" target="_blank"></a>';
					$result .= '<a href="https://t.me/share/url?url=' . $link . '&text=' . $post_title . '" class="share_icon_telegram" target="_blank"></a>';
					$result .= '<a href="https://twitter.com/intent/tweet?text=' . $post_title . '&url=' . $link . '" class="share_icon_twitter" target="_blank"></a>';
					$result .= '</ul>';
					$result .= '</div>';
				} elseif ( $data['type'] == 'share_comment' ) {
					//print_r($data);
					$comment_type    = get_field( 'comment_type', 'comment_' . $data['post_id'] );
					$comment_id      = get_comment( $data['post_id'] );
					$comment_post_id = $comment_id->comment_post_ID;
					
					$post_title = get_the_title( $comment_post_id );
					$result     .= '<div class="p_30 flex flex_column">';
					if ( $comment_type == 'reviews' ) {
						$result .= '<div class="title color_dark_blue font_bold m_b_20">' . __( 'Поделиться отзывом', 'er_theme' ) . '</div>';
						$link   = get_the_permalink( $comment_post_id ) . 'comment-' . $data['post_id'] . '/';
					} else {
						$result .= '<div class="title color_dark_blue font_bold m_b_20">' . __( 'Поделиться комментарием', 'er_theme' ) . '</div>';
						$link   = get_the_permalink( $comment_post_id ) . '%23comment-' . $data['post_id'];
					}
					$result .= '<ul class="popup_share_icons">';
					$result .= '<a href="https://vk.com/share.php?url=' . $link . '" class="share_icon_vk" target="_blank"></a>';
					/*$result .= '<li data-link="https://connect.ok.ru/offer?url='.$link.'&title='.$post_title.'" class="share_icon_odnoklassniki"></li>';*/
					$result .= '<a href="viber://forward?text=' . $link . '" class="share_icon_viber" target="_blank"></a>';
					$result .= '<a href="https://api.whatsapp.com/send?text=' . $link . '" class="share_icon_whatsapp" target="_blank"></a>';
					$result .= '<a href="https://t.me/share/url?url=' . $link . '" class="share_icon_telegram" target="_blank"></a>';
					$result .= '<a href="https://twitter.com/intent/tweet?url=' . $link . '" class="share_icon_twitter" target="_blank"></a>';
					$result .= '</ul>';
					$result .= '</div>';
					
				} elseif ( $data['type'] == 'permalik_comment' ) {
					$comment_type = get_field( 'comment_type', 'comment_' . $data['post_id'] );
					$result       .= '<div class="p_30 flex flex_column">';
					if ( $comment_type == 'reviews' ) {
						$comment_iddd = get_comment( $data['post_id'] );
						//print_r($comment_iddd);
						$comment_post_iddd = $comment_iddd->comment_post_ID;
						$result            .= '<div class="title color_dark_blue font_bold m_b_20">' . __( 'Ссылка на отзыв', 'er_theme' ) . '</div>';
						$result            .= '<input type="text" value="' . get_the_permalink( $comment_post_iddd ) . 'comment-' . $data['post_id'] . '/" />';
					} else {
						$comment_iddd = get_comment( $data['post_id'] );
						//print_r($comment_iddd);
						$comment_post_iddd = $comment_iddd->comment_post_ID;
						$result .= '<div class="title color_dark_blue font_bold m_b_20">' . __( 'Ссылка на комментарий', 'er_theme' ) . '</div>';
						$result .= '<input type="text" value="' . get_the_permalink( $comment_post_iddd ) . 'comment-' . $data['post_id'] . '/" />';
					}
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

if ( ! function_exists( 'form_review' ) ) {
	function form_review( $post_id ) {
		$result = '';
		if ( get_post_type( $post_id ) == 'casino' ) {
			$rating_fields_group = get_rating_fields_group( $post_id );
			$ratings             = get_comment_rating_fields( $rating_fields_group, 'key' );
		}
		//if($rating_fields_group != 0) {
		$result .= '<form action="' . admin_url( 'admin-ajax.php' ) . '" method="post" id="popup_form_review">';
		$result .= print_css_links( 'review_form' );
		$result .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase">' . __( 'Добавить отзыв', 'er_theme' ) . '</div>';
		$result .= '<textarea name="comment_text" class="m_b_20"></textarea>';
		$result .= '<input type="hidden" name="action" value="new_submit_review" />';
		$result .= '<input type="hidden" name="type_send" value="review" />';
		$result .= '<input type="hidden" name="post_id" value="' . $post_id . '" />';
		
		if ( get_post_type( $post_id ) == 'casino' ) {
			$result .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase">' . __( 'Оцените компанию по критериям', 'er_theme' ) . '</div>';
			$result .= '<div class="rating_columns flex m_b_20">';
			
			foreach ( $ratings as $item ) {
				$result .= '<div class="form_rating flex">';
				$result .= '<div class="form_field_name color_dark_gray font_smaller">' . $item['field_label'] . '</div>';
				$result .= '<div class="rating m_b_15">';
				$result .= rating_field( $item['field_min'], $item['field_max'], 'rating', $item['field_name'] );
				$result .= '</div>';
				$result .= '</div>';
			}
			$result .= '</div>';
			$result .= '<script type="text/javascript">
		             jQuery(document).ready(function($) {
		                $( \'input[type="submit"]\' ).prop( "disabled", true );
		                $(".rating input").change(function(){
                        if ($(\'.form_rating:not(:has(:radio:checked))\').length) {
                            //alert("At least one group is blank");
                            $( \'input[type="submit"]\' ).prop( "disabled", true );
                        } else {
		                   // alert("fine");
                            $( \'input[type="submit"]\' ).prop( "disabled", false );
                         };
                        });
		             });
		             </script>';
		}
		$result .= '<ul class="review_form_icons flex">';
		$result .= '<li class="form_icon_img inactive"><span class="form_icon_img_inside"></span><span class="add_image_text"><span>Добавить изображение</span></span></li>';
		$result .= '<li class="form_icon_notify inactive"><span class="form_icon_notify_inside"></span><span class="subs_comments"><span>Подписаться на эту компанию</span></span></li>';
		//$result .= '<li class="form_icon_link inactive"></li>';
		$result .= '</ul>';
		$result .= '<input class="button button_big button_green m_b_10 pointer font_small font_bold" type="submit" value="' . __( 'Разместить отзыв', 'er_theme' ) . '" />';
		$result .= '</form>';
		
		//}
		return $result;
	}
}

if ( ! function_exists( 'form_abuse' ) ) {
	function form_abuse( $post_id ) {
		$result       = '';
		$result       .= '<form action="' . admin_url( 'admin-ajax.php' ) . '" method="post" id="popup_form_abuse">';
		$company_name = get_field( 'company_name', $post_id );
		$result       .= print_css_links( 'review_form' );
		$result       .= '<div class="title color_dark_blue font_smaller">' . __( 'Жалоба на компанию', 'er_theme' ) . ' <span class="text_underline">' . $company_name . '</span></div>';
		$result       .= '<textarea name="comment_text" class="m_b_20"></textarea>';
		$result       .= '<input type="hidden" name="action" value="new_submit_review" />';
		$result       .= '<input type="hidden" name="post_id" value="' . $post_id . '" />';
		$result       .= '<input type="hidden" name="is_abuse" value="yes" />';
		$result       .= '<ul class="review_form_icons flex">';
		$result       .= '<li class="form_icon_img inactive"><span class="form_icon_img_inside"></span><span class="add_image_text"><span>Добавить изображение</span></span></li>';
		$result       .= '<li class="form_icon_notify inactive"><span class="form_icon_notify_inside"></span><span class="subs_comments"><span>Подписаться на эту компанию</span></span></li>';
		//$result .= '<li class="form_icon_link inactive"></li>';
		$result .= '</ul>';
		$result .= '<input class="button button_big button_violet m_b_10 pointer font_small font_bold" type="submit" value="' . __( 'Разместить жалобу', 'er_theme' ) . '" />';
		$result .= '</form>';
		
		return $result;
	}
}

if ( ! function_exists( 'popup_auth_not_ajax' ) ) {
	function popup_auth_not_ajax() {
		$result           = '';
		$result           .= print_js_links()['auth'];
		$result           .= '<div class="popup_container" id="popup_auth">';
		$result           .= '<div class="popup_window box_shadow">';
		$result           .= '<div class="popup_close_button pointer"></div>';
		$result           .= '<div class="popup_columns two_columns">';
		$result           .= '<div class="popup_column_left flex_column align_left flex_padding">';
		$result           .= '<div class="title font_new_medium color_dark_blue font_bold m_b_20">' . __( 'Вход', 'er_theme' ) . '</div>';
		$result           .= '<form class="regform flex flex_column"  action="' . admin_url( 'admin-ajax.php' ) . '" method="post" id="popup_auth_form">';
		$result           .= '<input type="hidden" name="action" value="user_login" />';
		$result           .= '<input type="text" name="email" placeholder="' . __( 'Ваш E-mail', 'er_theme' ) . '" class="input_big m_b_10 placeholder_dark">';
		$result           .= '<input type="password" name="password" placeholder="' . __( 'Пароль', 'er_theme' ) . '" class="input_big m_b_15 placeholder_dark">';
		$result           .= '<div class="checkbox_container m_b_10 font_small color_dark_blue">';
		$result           .= '<input type="checkbox" id="remember__input" name="remember" checked="checked" class="custom-checkbox">';
		$result           .= '<label for="remember__input">' . __( 'Запомнить меня', 'er_theme' ) . '</label>';
		$result           .= '</div>';
		$result           .= '<input type="submit" name="submit" class="button button_big button_green m_b_10 pointer font_small font_bold" value="' . __( 'Войти', 'er_theme' ) . '" id="regbtn">';
		$result           .= '<div class="link_container"><span class="span_link link_recover_popup color_blue pointer font_small">' . __( 'Восстановить пароль', 'er_theme' ) . '</span></div>';
		$result           .= '</form>';
		$result           .= '</div>';
		$result           .= '<div class="popup_column_right flex_column align_left">';
		$current_language = get_locale();
		if ( $current_language == 'ru_RU' ) {
			$result .= '<div class="row_border_bottom flex_row flex_padding" id="social_login_mask">';
			$result .= '<div class="title color_dark_blue font_bold m_b_20">' . __( 'Используйте сервисы для регистрации', 'er_theme' ) . '</div>';
			$result .= social_login_icons( 'full' );
			$result .= '</div>';
		}
		$result .= '<div class="flex_row flex_padding">';
		$result .= '<div class="title color_dark_blue font_bold m_b_20">' . __( 'У вас еще нет аккаунта?', 'er_theme' ) . '</div>';
		$result .= '<div class="button button_big button_violet m_b_10 pointer reg_link font_small font_bold">' . __( 'Создать аккаунт', 'er_theme' ) . '</div>';
		$result .= '<div class="link_container"><span class="span_link link_terms_popup color_blue pointer font_small">' . __( 'Условия пользования сайтом', 'er_theme' ) . '</span></div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		
		return $result;
	}
}

if ( ! function_exists( 'upload_file_url' ) ) {
	function upload_file_url( $url ) {
		$timeout_seconds = 5;
		$temp_file       = download_url( $url, $timeout_seconds );
		$typeimg         = wp_check_filetype( basename( $url ) );
		if ( ! is_wp_error( $temp_file ) ) {
			$file        = array(
				'name'     => basename( $url ),
				'type'     => $typeimg['type'],
				'tmp_name' => $temp_file,
				'error'    => 0,
				'size'     => filesize( $temp_file ),
			);
			$arr_img_ext = array( 'image/png', 'image/jpeg', 'image/jpg', 'image/gif' );
			if ( in_array( $file['type'], $arr_img_ext ) ) {
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

if ( ! function_exists( 'ajax_upload_file' ) ) {
	add_action( 'wp_ajax_ajax_upload_file', 'ajax_upload_file' );
	add_action( 'wp_ajax_nopriv_ajax_upload_file', 'ajax_upload_file' );
	function ajax_upload_file() {
		$arr_img_ext = array(
			'image/png',
			'image/jpeg',
			'image/jpg',
			'image/gif',
			'application/msword',
			'application/pdf'
		);
		if ( in_array( $_FILES['file']['type'], $arr_img_ext ) ) {
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			//$file = & $_FILES['file'];
			$attachment_id = media_handle_upload( 'file', 0 );
			
			if ( is_wp_error( $attachment_id ) ) {
				$result = array(
					'status'  => 'error',
					'message' => __( 'Ошибка загрузки изображения', 'er_theme' ),
				);
			} else {
				$file_url  = wp_get_attachment_url( $attachment_id );
				$thumb_url = wp_get_attachment_thumb_url( $attachment_id );
				
				if ( substr( $file_url, - 3 ) == 'pdf' ) {
					$thumb_url = '/wp-content/themes/eto-razvod-1/img/pdf-upload-comment.svg';
				} elseif ( substr( $file_url, - 3 ) == 'doc' ) {
					$thumb_url = '/wp-content/themes/eto-razvod-1/img/doc-upload-comment.svg';
				}
				
				$result = array(
					'status'    => 'ok',
					'message'   => __( 'Изображение успешно загружено', 'er_theme' ),
					'file_id'   => $attachment_id,
					'file_url'  => $file_url,
					'thumb_url' => $thumb_url
				);
			}
			echo json_encode( $result );
		} else {
			$result = array(
				'status'  => 'error',
				'message' => __( 'Допустимые форматы: jpg, jpeg, png, gif', 'er_theme' ),
			);
			echo json_encode( $result );
		}
		die;
	}
}


if ( ! function_exists( 'ajax_upload_file_doc' ) ) {
	add_action( 'wp_ajax_ajax_upload_file_doc', 'ajax_upload_file_doc' );
	add_action( 'wp_ajax_nopriv_ajax_upload_file_doc', 'ajax_upload_file_doc' );
	function ajax_upload_file_doc() {
		$arr_img_ext = array(
			'image/png',
			'image/jpeg',
			'image/jpg',
			'image/gif',
			'application/msword',
			'application/pdf'
		);
		if ( in_array( $_FILES['file']['type'], $arr_img_ext ) ) {
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			//$file = & $_FILES['file'];
			$attachment_id = media_handle_upload( 'file', 0 );
			
			if ( is_wp_error( $attachment_id ) ) {
				$result = array(
					'status'  => 'error',
					'message' => __( 'Ошибка загрузки изображения', 'er_theme' ),
				);
			} else {
				$file_url  = wp_get_attachment_url( $attachment_id );
				$thumb_url = wp_get_attachment_thumb_url( $attachment_id );
				
				if ( substr( $file_url, - 3 ) == 'pdf' ) {
					$thumb_url = '/wp-content/themes/eto-razvod-1/img/pdf-upload-comment.svg';
				} elseif ( substr( $file_url, - 3 ) == 'doc' ) {
					$thumb_url = '/wp-content/themes/eto-razvod-1/img/doc-upload-comment.svg';
				}
				
				$result = array(
					'status'    => 'ok',
					'message'   => __( 'Изображение успешно загружено', 'er_theme' ),
					'file_id'   => $attachment_id,
					'file_url'  => $file_url,
					'thumb_url' => $thumb_url
				);
			}
			echo json_encode( $result );
		} else {
			$result = array(
				'status'  => 'error',
				'message' => __( 'Допустимые форматы: jpg, jpeg, png, gif', 'er_theme' ),
			);
			echo json_encode( $result );
		}
		die;
	}
}

if ( ! function_exists( 'ajax_append_form_images' ) ) {
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


if ( ! function_exists( 'outside_append_new_comment' ) ) {
	add_action( 'wp_ajax_outside_append_new_comment', 'outside_append_new_comment' );
	add_action( 'wp_ajax_nopriv_outside_append_new_comment', 'outside_append_new_comment' );
	function outside_append_new_comment() {
		$data                = $_POST;
		$args['comment__in'] = $data['comment_id'];
		$new_comment         = get_comments( $args );
		$post_id             = $new_comment[0]->comment_post_ID;
		$company_name        = get_field( 'company_name', $post_id );
		$post_status         = get_post_status( $post_id );
		$link                = get_the_permalink( $post_id );
		if ( function_exists( 'get_rating_fields_group' ) ) {
			$rating_fields_group = get_rating_fields_group( $post_id );
		} else {
			$rating_fields_group = 0;
		}
		if ( $data['type'] == 'review' ) {
			echo '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">' . __( 'Ваш отзыв на компанию', 'er_theme' ) . ' ' . $company_name . ' ' . __( 'опубликован!', 'er_theme' ) . '</div>';
			wp_list_comments( array(
				'callback'      => 'custom_comment_single',
				//'per_page' => -1,
				'rating_fields' => get_comment_rating_fields( $rating_fields_group, 'key' ),
			), $new_comment );
			if ( $post_status == 'publish' ) {
				echo '<a href="' . $link . '#comment-' . $data['comment_id'] . '" class="button button_green font_small font_bold button_big link_no_underline m_t_20">' . __( 'Посмотреть отзыв на странице компании', 'er_theme' ) . '</a>';
			} elseif ( $post_status == 'draft' ) {
				echo '<div class="m_t_20 color_dark_blue font_small ">' . __( 'Так как вы добавили отзыв на компанию, которой еще не было на сайте, он будет доступен после модерации.' ) . '</div>';
			}
		} elseif ( $data['type'] == 'abuse' ) {
			echo '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">' . __( 'Ваша жалоба на компанию', 'er_theme' ) . ' ' . $company_name . ' ' . __( 'опубликована!', 'er_theme' ) . '</div>';
			wp_list_comments( array(
				'callback'      => 'custom_abuse_single',
				//'per_page' => -1,
				'rating_fields' => get_comment_rating_fields( $rating_fields_group, 'key' ),
			), $new_comment );
			if ( $post_status == 'publish' ) {
				echo '<a href="' . $link . '#abuse" class="button button_violet font_small font_bold button_big link_no_underline m_t_20">' . __( 'Посмотреть жалобу на странице компании', 'er_theme' ) . '</a>';
			} elseif ( $post_status == 'draft' ) {
				echo '<div class="m_t_20 color_dark_blue font_small">' . __( 'Так как вы добавили жалобу на компанию, которой еще не было на сайте, она будет доступна после модерации.' ) . '</div>';
			}
		}
		
		
		die;
	}
}


if ( ! function_exists( 'append_new_comment' ) ) {
	add_action( 'wp_ajax_append_new_comment', 'append_new_comment' );
	add_action( 'wp_ajax_nopriv_append_new_comment', 'append_new_comment' );
	function append_new_comment() {
		$data                = $_POST;
		$args['comment__in'] = $data['comment_id'];
		$new_comment         = get_comments( $args );
		$post_id             = $new_comment[0]->comment_post_ID;
		if ( function_exists( 'get_rating_fields_group' ) ) {
			$rating_fields_group = get_rating_fields_group( $post_id );
		} else {
			$rating_fields_group = 0;
		}
		if ( $data['type'] == 'review' ) {
			wp_list_comments( array(
				'callback'      => 'custom_comment_single',
				//'per_page' => -1,
				'rating_fields' => get_comment_rating_fields( $rating_fields_group, 'key' ),
			), $new_comment );
		} elseif ( $data['type'] == 'comment' ) {
			wp_list_comments( array(
				'callback' => 'custom_comment_single',
			), $new_comment );
		} elseif ( $data['type'] == 'abuse' ) {
			wp_list_comments( array(
				'callback'      => 'custom_abuse_single',
				//'per_page' => -1,
				'rating_fields' => get_comment_rating_fields( $rating_fields_group, 'key' ),
			), $new_comment );
		}
		
		die;
	}
}

if ( ! function_exists( 'append_new_reply' ) ) {
	add_action( 'wp_ajax_append_new_reply', 'append_new_reply' );
	add_action( 'wp_ajax_nopriv_append_new_reply', 'append_new_reply' );
	function append_new_reply() {
		$data                = $_POST;
		$args['comment__in'] = $data['comment_id'];
		$new_comment         = get_comments( $args );
		$post_id             = $new_comment[0]->comment_post_ID;
		if ( function_exists( 'get_rating_fields_group' ) ) {
			$rating_fields_group = get_rating_fields_group( $post_id );
		} else {
			$rating_fields_group = 0;
		}
		if ( $data['type'] == 'review' ) {
			wp_list_comments( array(
				'callback'      => 'custom_comment_single',
				//'per_page' => -1,
				'rating_fields' => get_comment_rating_fields( $rating_fields_group, 'key' ),
			), $new_comment );
		} elseif ( $data['type'] == 'comment' ) {
			wp_list_comments( array(
				'callback' => 'custom_comment_single',
			), $new_comment );
		} elseif ( $data['type'] == 'abuse' ) {
			wp_list_comments( array(
				'callback'      => 'custom_abuse_single',
				//'per_page' => -1,
				'rating_fields' => get_comment_rating_fields( $rating_fields_group, 'key' ),
			), $new_comment );
		}
		
		die;
	}
}


function wp_new_comment_test( $commentdata, $wp_error = false ) {
	global $wpdb;
	
	if ( isset( $commentdata['user_ID'] ) ) {
		$commentdata['user_ID'] = (int) $commentdata['user_ID'];
		$commentdata['user_id'] = $commentdata['user_ID'];
	}
	
	$prefiltered_user_id = ( isset( $commentdata['user_id'] ) ) ? (int) $commentdata['user_id'] : 0;
	
	if ( ! isset( $commentdata['comment_author_IP'] ) ) {
		$commentdata['comment_author_IP'] = $_SERVER['REMOTE_ADDR'];
	}
	
	if ( ! isset( $commentdata['comment_agent'] ) ) {
		$commentdata['comment_agent'] = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';
	}
	
	/**
	 * Filters a comment's data before it is sanitized and inserted into the database.
	 *
	 * @param array $commentdata Comment data.
	 *
	 * @since 5.6.0 Comment data includes the `comment_agent` and `comment_author_IP` values.
	 *
	 * @since 1.5.0
	 */
	$commentdata = apply_filters( 'preprocess_comment', $commentdata );
	
	$commentdata['comment_post_ID'] = (int) $commentdata['comment_post_ID'];
	if ( isset( $commentdata['user_ID'] ) && $prefiltered_user_id !== (int) $commentdata['user_ID'] ) {
		$commentdata['user_ID'] = (int) $commentdata['user_ID'];
		$commentdata['user_id'] = $commentdata['user_ID'];
	} elseif ( isset( $commentdata['user_id'] ) ) {
		$commentdata['user_id'] = (int) $commentdata['user_id'];
	}
	
	$commentdata['comment_parent'] = isset( $commentdata['comment_parent'] ) ? absint( $commentdata['comment_parent'] ) : 0;
	
	$parent_status = ( $commentdata['comment_parent'] > 0 ) ? wp_get_comment_status( $commentdata['comment_parent'] ) : '';
	
	$commentdata['comment_parent'] = ( 'approved' === $parent_status || 'unapproved' === $parent_status ) ? $commentdata['comment_parent'] : 0;
	
	$commentdata['comment_author_IP'] = preg_replace( '/[^0-9a-fA-F:., ]/', '', $commentdata['comment_author_IP'] );
	
	$commentdata['comment_agent'] = substr( $commentdata['comment_agent'], 0, 254 );
	
	if ( empty( $commentdata['comment_date'] ) ) {
		$commentdata['comment_date'] = current_time( 'mysql' );
	}
	
	if ( empty( $commentdata['comment_date_gmt'] ) ) {
		$commentdata['comment_date_gmt'] = current_time( 'mysql', 1 );
	}
	
	if ( empty( $commentdata['comment_type'] ) ) {
		$commentdata['comment_type'] = 'comment';
	}
	
	$commentdata = wp_filter_comment( $commentdata );
	
	// Выключена проверка на апрув - по умолчанию для всех ревью любого пользователя нужно ручное подтверждение
	// $commentdata['comment_approved'] = wp_allow_comment( $commentdata, $wp_error );
	// if ( is_wp_error( $commentdata['comment_approved'] ) ) {
	// 	return $commentdata['comment_approved'];
	// }
	
	$comment_ID = wp_insert_comment( $commentdata );
	if ( ! $comment_ID ) {
		$fields = array( 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content' );
		
		foreach ( $fields as $field ) {
			if ( isset( $commentdata[ $field ] ) ) {
				$commentdata[ $field ] = $wpdb->strip_invalid_text_for_column( $wpdb->comments, $field, $commentdata[ $field ] );
			}
		}
		
		$commentdata = wp_filter_comment( $commentdata );
		
		// Выключена проверка на апрув - по умолчанию для всех ревью любого пользователя нужно ручное подтверждение
		// $commentdata['comment_approved'] = wp_allow_comment( $commentdata, $wp_error );
		// if ( is_wp_error( $commentdata['comment_approved'] ) ) {
		// 	return $commentdata['comment_approved'];
		// }
		
		$comment_ID = wp_insert_comment( $commentdata );
		if ( ! $comment_ID ) {
			return false;
		}
	}
	
	/**
	 * Fires immediately after a comment is inserted into the database.
	 *
	 * @param int $comment_ID The comment ID.
	 * @param int|string $comment_approved 1 if the comment is approved, 0 if not, 'spam' if spam.
	 * @param array $commentdata Comment data.
	 *
	 * @since 4.5.0 The `$commentdata` parameter was added.
	 *
	 * @since 1.2.0
	 */
	do_action( 'comment_post', $comment_ID, $commentdata['comment_approved'], $commentdata );
	
	return $comment_ID;
}

if ( ! function_exists( 'new_submit_review' ) ) {
	add_action( 'wp_ajax_new_submit_review', 'new_submit_review' );
	add_action( 'wp_ajax_nopriv_new_submit_review', 'new_submit_review' );
	function new_submit_review() {
		$data = $_POST;
		//print_r($data);
		$files       = $data['files'];
		$links       = $data['links'];
		$cur_user_id = get_current_user_id();
		$user_info   = get_userdata( $cur_user_id );
		$commentdata = array(
			'comment_post_ID'      => $data['post_id'],
			'comment_content'      => htmlspecialchars( $data['comment_text'] ),
			'comment_author'       => $user_info->display_name,
			'comment_author_email' => $user_info->user_email,
			'comment_type'         => 'comment',
			'user_ID'              => $cur_user_id,
		);
		//print_r($commentdata);
		$result = array();
		if ( strlen( preg_replace( '/\s+/', '', $commentdata['comment_content'] ) ) == 0 ) {
			$result['status']  = 'error';
			$result['message'] = __( 'Вы не написали отзыв', 'er_theme' );
		} else {
			$new_comment = wp_new_comment( $commentdata, true );
			if ( is_wp_error( $new_comment ) ) {
				$result['status']  = 'error';
				$result['message'] = $new_comment->get_error_message();
				
			} else {
				wp_set_comment_status( $new_comment, 0 );
				if ( $new_comment && ! empty( $data['rating'] ) && $data['comment_text'] ) {
					/*					foreach ($data['rating'] as $key => $value) {
											update_field($key,$value,'comment_'.$new_comment);
										}*/
					$user_stat_rate_arr = [];
					foreach ( $data['rating'] as $key => $value ) {
						update_field( $key, $value, 'comment_' . $new_comment );
						array_push( $user_stat_rate_arr, $value );
					}
					$user_stat_rate = 0;
					foreach ( $user_stat_rate_arr as $item ) {
						$user_stat_rate = intval( $user_stat_rate ) + intval( $item );
					}
					$user_stat_rate_upate = $user_stat_rate / 4;
					$rate_from_comments   = get_field( 'rate_from_comments', 'user_' . $cur_user_id );
					
					
					$args_reviews = [
						'status'     => 'approve',
						'user_id'    => $cur_user_id,
						'count'      => true,
						'meta_query' => [
							'relation' => 'AND',
							[
								'key'     => 'comment_type',
								'value'   => 'reviews',
								'compare' => '=',
							]
						]
					];
					
					$review_count = get_comments( $args_reviews );
					
					if ( $rate_from_comments != 0 && $rate_from_comments != '' ) {
						$rate_from_comments = ( ( $rate_from_comments * $review_count ) + $user_stat_rate_upate ) / $review_count + 1;
					} else {
						$rate_from_comments = $user_stat_rate_upate;
					}
					
					//update_field('rate_from_comments',round($rate_from_comments,1),'user_'.$cur_user_id);
					$current_average = get_field( 'reviews_rating_average', $data['post_id'] );
					if ( $current_average == 0 || $current_average == '' || ! $current_average || $current_average == 0.01 ) {
						$av_rate_update = $user_stat_rate_upate;
					} else {
						$av_rate_update = ( $user_stat_rate_upate + $current_average ) / 2;
					}
					//update_field('reviews_rating_average',round($av_rate_update,1),$data['post_id']);
					
					if ( $user_stat_rate_upate > 3 ) {
						$comment_goodness = 'good';
						
						$count_good = get_field( 'reviews_count_good', $data['post_id'] );
						if ( $count_good != 0 && $count_good != '' ) {
							$count_good_new = $count_good + 1;
						} else {
							$count_good_new = 1;
						}
						//update_field('reviews_count_good',$count_good_new,$data['post_id']);
					} else {
						$comment_goodness = 'bad';
					}
					
				}
				if ( $new_comment ) {
					$current_language = get_locale();
					update_field( 'language_original', $current_language, 'comment_' . $new_comment );
					update_field( 'field_5fce35905450b', 0, 'comment_' . $new_comment );
					if ( ! empty( $files ) ) {
						foreach ( $files as $file ) {
							if ( array_key_exists( $file, $links ) ) {
								
								$row = array(
									'file_type' => 'url',
									'file'      => $file,
									'link'      => $links[ $file ]
								);
							} else {
								$row = array(
									'file_type' => 'image',
									'file'      => $file
								);
							}
							//print_r($row);
							add_row( 'comment_files', $row, 'comment_' . $new_comment );
						}
					}
					$result['status'] = 'ok';
					
					if ( $data['is_abuse'] ) {
						update_field( 'is_abuse', 1, 'comment_' . $new_comment );
						$result['message'] = __( 'Ваша жалоба ожидает модерации', 'er_theme' );
						update_field( 'comment_type', 'abuses', 'comment_' . $new_comment );
						if ( $new_comment->comment_parent == 0 ) {
							update_field( 'abuse_state', 'not_seen', 'comment_' . $new_comment );
							update_field( 'abuse_state', 'not_seen', $new_comment );
						}
						//$current_count_abuses = get_field('reviews_count_abuses',$data['post_id']);
						if ( ! $current_count_abuses || $current_count_abuses == '' ) {
							$current_count_abuses = 0;
						}
						$current_count_reviews ++;
						//update_field('reviews_count_abuses',$current_count_reviews,$data['post_id']);
						
					} else {
						
						update_field( 'abuse_state', 'progress', 'comment_' . $new_comment->comment_parent );
						
						update_field( 'comment_type', 'reviews', 'comment_' . $new_comment );
						$result['message'] = __( 'Ваш отзыв ожидает модерации', 'er_theme' );
						
						$current_count_reviews = get_field( 'reviews_count_reviews', $data['post_id'] );
						if ( ! $current_count_reviews || $current_count_reviews == '' ) {
							$current_count_reviews = 0;
						}
						$current_count_reviews ++;
						//update_field('reviews_count_reviews',$current_count_reviews,$data['post_id']);
					}
					$result['comment_id'] = $new_comment;
				} else {
					$result['status']  = 'error';
					$result['message'] = __( 'Возникла ошибка', 'er_theme' );
				}
			}
		}
		//print_r($result);
		
		echo json_encode( $result );
		die;
	}
}


if ( ! function_exists( 'new_submit_reply' ) ) {
	add_action( 'wp_ajax_new_submit_reply', 'new_submit_reply' );
	add_action( 'wp_ajax_nopriv_new_submit_reply', 'new_submit_reply' );
	function new_submit_reply() {
		$data        = $_POST;
		$cur_user_id = get_current_user_id();
		$user_info   = get_userdata( $cur_user_id );
		$commentdata = array(
			'comment_post_ID'      => $data['post_id'],
			'comment_content'      => htmlspecialchars( $data['comment_text'] ),
			'comment_author'       => $user_info->display_name,
			'comment_author_email' => $user_info->user_email,
			'comment_type'         => 'comment',
			'user_ID'              => $cur_user_id,
			'comment_parent'       => $data['parent_id']
		);
		$result      = array();
		if ( strlen( preg_replace( '/\s+/', '', $commentdata['comment_content'] ) ) == 0 ) {
			$result['status']  = 'error';
			$result['message'] = __( 'Вы не написали комментарий', 'er_theme' );
		} else {
			$new_comment = wp_new_comment( $commentdata, true );
			if ( is_wp_error( $new_comment ) ) {
				$result['status']  = 'error';
				$result['message'] = $new_comment->get_error_message();
			} else {
				wp_set_comment_status( $new_comment, 0 );
				if ( $new_comment ) {
					$current_language = get_locale();
					update_field( 'language_original', $current_language, 'comment_' . $new_comment );
					update_field( 'field_5fce35905450b', 0, 'comment_' . $new_comment );
					if ( intval( $data['company_id'] ) != 0 ) {
						update_field( 'id_company', intval( $data['company_id'] ), 'comment_' . $new_comment );
						update_field( 'id_company', intval( $data['company_id'] ), $new_comment );
					}
					//update_field('abuse_state','progress','comment_'.$new_comment->comment_parent);
					//update_field('abuse_state','progress','comment_'.$new_comment->comment_parent);
					$result['status'] = 'ok';
					update_field( 'comment_type', 'comment', 'comment_' . $new_comment );
					$result['message']    = __( 'Ваш комментарий ожидает модерации', 'er_theme' );
					$result['comment_id'] = $new_comment;
					
				} else {
					$result['status']  = 'error';
					$result['message'] = __( 'Возникла ошибка', 'er_theme' );
				}
			}
		}
		//print_r($result);
		echo json_encode( $result );
		die;
	}
}


if ( ! function_exists( 'ajax_popup_reset_password' ) ) {
	add_action( 'wp_ajax_ajax_popup_reset_password', 'ajax_popup_reset_password' );
	add_action( 'wp_ajax_nopriv_ajax_popup_reset_password', 'ajax_popup_reset_password' );
	
	function ajax_popup_reset_password() {
		$result           = '';
		$result           .= '<div class="popup_container" id="popup_auth">';
		$result           .= '<div class="popup_window box_shadow">';
		$result           .= '<div class="popup_close_button pointer"></div>';
		$result           .= '<div class="popup_columns two_columns">';
		$result           .= '<div class="popup_column_left flex_column align_left flex_padding">';
		$result           .= '<div class="title font_new_medium color_dark_blue font_bold m_b_20">' . __( 'Восстановление пароля', 'er_theme' ) . '</div>';
		$result           .= '<form class="regform flex flex_column"  action="' . admin_url( 'admin-ajax.php' ) . '" method="post" id="popup_reset_password_new">';
		$result           .= '<input type="hidden" name="action" value="user_reset_password_new" />';
		$result           .= '<input type="text" name="email" placeholder="' . __( 'Ваш E-mail', 'er_theme' ) . '" class="input_big m_b_10 placeholder_dark">';
		$result           .= '<input type="submit" name="submit" class="button button_big button_green m_b_10 pointer font_small font_bold" value="' . __( 'Восстановить пароль', 'er_theme' ) . '" id="regbtn">';
		$result           .= '</form>';
		$result           .= '</div>';
		$result           .= '<div class="popup_column_right flex_column align_left">';
		$current_language = get_locale();
		if ( $current_language == 'ru_RU' ) {
			$result .= '<div class="row_border_bottom flex_row flex_padding" id="social_login_mask">';
			$result .= '<div class="title color_dark_blue font_bold m_b_20">' . __( 'Используйте сервисы для входа', 'er_theme' ) . '</div>';
			$result .= social_login_icons( 'full' );
			$result .= '</div>';
		}
		$result .= '<div class="flex_row flex_padding">';
		$result .= '<div class="button button_big button_green m_b_10 pointer auth_link font_bold font_small">' . __( 'Войти в мой аккаунт', 'er_theme' ) . '</div>';
		$result .= '<div class="button button_big button_violet m_b_10 pointer reg_link font_bold font_small">' . __( 'Создать аккаунт', 'er_theme' ) . '</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		echo $result;
		die;
	}
}


add_action( 'wp_ajax_user_reset_password_new', 'user_reset_password_new' );
add_action( 'wp_ajax_nopriv_user_reset_password_new', 'user_reset_password_new' );

function user_reset_password_new() {
	global $wpdb;
	
	date_default_timezone_set( 'Europe/Moscow' );
	$retrivemail = $_POST["email"];
// пустой ответ каптчи
// Проверка вашего секретного ключа
	
	
	if ( filter_var( $retrivemail, FILTER_VALIDATE_EMAIL ) ) {
		
		if ( email_exists( $retrivemail ) ) {

//            $user = get_user_by( 'email', $retrivemail );
//            $user2 = get_userdata($user->ID);
//            $userlogin = $user2->data->user_login;
//            $get_password_key = get_password_reset_key( $user2 );
//            $get_password_key_link = get_site_url().'/forgot-password/?key='.$get_password_key.'&login='.$userlogin;
//            $status = 'ok';
//
//            $headers = array(
//            'From: Eto-Razvod <check@eto-razvod.info>',
//            );
//            $message = '';
//            $message .= "Вы заказали восстановление пароля для аккаунта: ".$get_password_key_link." \r\n\r\n";
//            $message .= "Если Вы не заказывали восстановление пароля - то не переходите по данной ссылке.";
//            $subject = 'Восстановление пароля на сайте eto-razvod.ru';
//            wp_mail( $retrivemail, $subject, $message, $headers );
			
			
			$mydb     = new wpdb( 'eto_sendmail', 'V9OgJszo3sgUmm3r', 'eto_sendmail', 'localhost' );
			$user     = get_user_by( 'email', $retrivemail );
			$user2    = get_userdata( $user->ID );
			$mail_key = wp_generate_uuid4();
			
			$mydb->insert(
				'mails',
				array(
					'status'    => 'not_sent',
					'reg_date'  => $user2->data->user_registered,
					'user_id'   => $user2->data->ID,
					'mail_type' => 'reset_password',
					'mail_key'  => $mail_key,
					'sent'      => date( 'Y-m-d H:i:s' )
				),
				array( '%s', '%s', '%s', '%s', '%s', '%s' )
			);
			
			
			$user                  = get_user_by( 'email', $retrivemail );
			$user2                 = get_userdata( $user->ID );
			$userlogin             = $user2->data->user_login;
			$get_password_key      = get_password_reset_key( $user2 );
			$get_password_key_link = get_site_url() . '/forgot-password/?key=' . $get_password_key . '&login=' . $userlogin;
			$status                = 'ok';
			$status_mess           = __( 'Ссылка для восстановления пароля успешно отправлена на Ваш E-mail', 'er_theme' );
			$headers               = array(
				'From: Это развод™ <check@eto-razvod.info>',
				'content-type: text/html',
			);
			$message               = '';
			$message               .= "Вы заказали восстановление пароля для аккаунта: " . $get_password_key_link . " \r\n\r\n";
			$message               .= 'Если Вы не заказывали восстановление пароля - то не переходите по данной ссылке. <img src="https://etorazvod.ru/engine/mail_update_status.php?key=' . $mail_key . '" style="width:1px; height:1px;" />';
			$subject               = 'Восстановление пароля на сайте eto-razvod.ru';
//wp_mail( $retrivemail, $subject, $message, $headers );
			
			
			$mailResult = false;
			$mailResult = wp_mail( $retrivemail, $subject, $message, $headers );
			if ( $mailResult == 1 ) {
				$mail = $mydb->get_results( "select * from mails WHERE mail_key = '$mail_key'" );
				
				
				$mydb->update(
					'mails',
					array( 'status' => 'sent' ),
					array( 'id' => $mail[0]->id ),
					array( '%s' )
				);
				$mydb->update(
					'mails',
					array( 'updated' => date( 'Y-m-d H:i:s' ) ),
					array( 'id' => $mail[0]->id ),
					array( '%s' )
				);
				
				
			}
		} else {
			$status      = 'error';
			$status_mess = __( 'E-mail не зарегистрирован', 'er_theme' );
		}
		
	} else {
		$status      = 'error';
		$status_mess = __( 'Пожалуйста, введите E-mail', 'er_theme' );
	}
	
	
	$result = array(
		'status'  => $status,
		'message' => $status_mess
	);
	echo json_encode( $result );
	die;
}


add_action( 'wp_ajax_setlostpw', 'setlostpwfunc' );
add_action( 'wp_ajax_nopriv_setlostpw', 'setlostpwfunc' );

function setlostpwfunc() {
	
	
	$block_input_username = htmlspecialchars( $_POST["block_input_username"] );
	$block_input_psw1     = $_POST["block_input_psw1"];
	$block_input_psw2     = $_POST["block_input_psw2"];
	
	if ( $block_input_psw1 == $block_input_psw2 ) {
		$user = get_user_by( 'login', $block_input_username );
		wp_set_password( $block_input_psw1, $user->ID );
		
		wp_set_current_user( $user->ID );
		wp_set_auth_cookie( $user->ID );
		
		$result = array(
			'status'       => 'ok',
			'secondstatus' => 'Пароль успешно был установлен'
		);
	} else {
		$result = array(
			'status'       => 'error',
			'secondstatus' => 'Введённые пароли не совпадают'
		);
	}
	
	
	echo json_encode( $result );
	die;
	
}

if ( ! function_exists( 'get_single_newform_by_name' ) ) {
	add_action( 'wp_ajax_get_single_newform_by_name', 'get_single_newform_by_name' );
	add_action( 'wp_ajax_nopriv_get_single_newform_by_name', 'get_single_newform_by_name' );
	function get_single_newform_by_name() {
		$data   = $_POST;
		$result = '';
		$result .= form_separate_review_single_new( $data['post_id'], $data['new_name'] );
		echo $result;
		die;
	}
}
if (!function_exists('autocomplete_search_results')) {
	add_action( 'wp_ajax_autocomplete_search_results', 'autocomplete_search_results' );
	add_action( 'wp_ajax_nopriv_autocomplete_search_results', 'autocomplete_search_results' );
	function autocomplete_search_results() {
		$data = $_POST;

		$result = '';
		$cyr = $eng = array();

		$prase = $data['phrase'];
		$search_type = $data['type'];

		$current_language = get_locale();

		if($search_type == 'search_companies') {
			$arr_url = ['https:','http:','/'];
			$args = array(
				'post_status' => array( 'publish' ),
				'posts_per_page' => -1,
				'post_type'=>'casino',
				'orderby' => 'menu_order',

				'order' => 'ASC',
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key' => 'company_name',
						'value' => $prase,
						'compare' => 'LIKE'
					),
					array(
						'key'     => 'company_name',
						'value'   => $prase,
						'compare' => 'LIKE'
					),
					array(
						'key' => 'company_redirect_key',
						'value' => preg_replace('/\s+/', '', $prase),
						'compare' => 'LIKE'
					),
					array(
						'key'		=> 'websites_$_site_url',
						'compare'	=> 'LIKE',
						'value'		=> str_replace($arr_url, "", $prase)
					),
					array(
						'key' => 'company_redirect_key',
						'value' => str_replace($arr_url, "", $prase),
						'compare' => 'LIKE'
					)
				)
			);

			if( $current_language == 'ru_RU' ) {
				// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
				$args['turn_off_on_ru_language'] = 1;		
			}

            if($data['tags'] && !empty($data['tags'])) {
                $existing = explode(',', $data['tags']);
            } else {
                $existing = array();
            }
            if(!empty($existing)) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'affiliate-tags',
                        'field'    => 'id',
                        'terms'    => $existing,
                    ),
                );
            }
			if($prase != '') {
				$prase_explode = explode(' ',$prase);
				if (count($prase_explode) == 1) {
					//$result .= 'удалить'.'test1';
					if(isRussian($prase)) {

						//$result .= 'RU';
						$letters = [
							[ 'ай', 'i' ],
							[ 'кс', 'x' ],
							[ 'аль', 'al' ],
							[ 'с', 'c' ],
							[ 'тиньк', 'tink' ],
							[ 'блэк', 'black' ],
							[ 'э', 'a' ],
							[ 'гик', 'geek' ],
							[ 'брейн', 'brain' ],
							[ 'бреин', 'brain' ],
							[ 'гикбреин', 'geekbrain' ],
							[ 'гикбрейнс', 'geekbrain' ],
							[ 'юни', 'uni' ],
							[ 'юник', 'unic' ],
							[ 'кредит', 'credit' ],
							[ 'пицца', 'pizza' ]
						];

						$arr = [];
						foreach ($letters as $value) {

							if (strstr($prase, $value[0])) {
								if (strpos($prase, $value[0]) !== FALSE) {

									$args['meta_query'][] = array(
										'key' => 'company_name',
										'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase)),
										'compare' => 'LIKE'
									);
									$args['meta_query'][] = array(
										'key' => 'company_redirect_key',
										'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase)),
										'compare' => 'LIKE'
									);
									//$result .= 'удалить56565656999'.$test;

								}
							}
						}

						$letters2 = [[' ','-'],[' ','.'],[' ',' & ']];

						$arr = [];
						foreach ($letters2 as $value) {

							if (strstr($prase, $value[0])) {
								if (strpos($prase, $value[0]) !== FALSE) {
									$test = str_replace($value[0], $value[1], $prase);
									$args['meta_query'][] = array(
										'key' => 'company_name',
										'value' => str_replace($value[0], $value[1], $prase),
										'compare' => 'LIKE'
									);
									$args['meta_query'][] = array(
										'key' => 'company_redirect_key',
										'value' => str_replace($value[0], $value[1], $prase),
										'compare' => 'LIKE'
									);

								}
							}
						}
						//$result .= $test;


						$phrase_alter = transliterator_transliterate('Russian-Latin/BGN', $prase);
						//$result .= 'удалить436346346'.transliterator_transliterate('Russian-Latin/BGN', $prase);

						//$result .= '<br />';
						//$result .= $phrase_alter;

					} else {
						//$result .= 'not_RU';
						$letters = [
							[ 'h', 'х' ],
							[ 'tink', 'тиньк' ],
							[ 'tink', 'тиньк' ],
							[ 'black', 'блэк' ],
							[ 'a', 'э' ]
						];

						$arr = [];
						foreach ($letters as $value) {

							if (strstr($prase, $value[0])) {
								if (strpos($prase, $value[0]) !== FALSE) {

									$args['meta_query'][] = array(
										'key' => 'company_name',
										'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase)),
										'compare' => 'LIKE'
									);
									$args['meta_query'][] = array(
										'key' => 'company_redirect_key',
										'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase)),
										'compare' => 'LIKE'
									);

								}
							}
						}

						$letters2 = [[' ','-'],[' ','.'],[' ',' & ']];

						$arr = [];
						foreach ($letters2 as $value) {

							if (strstr($prase, $value[0])) {
								if (strpos($prase, $value[0]) !== FALSE) {
									$test = str_replace($value[0], $value[1], $prase);
									$args['meta_query'][] = array(
										'key' => 'company_name',
										'value' => str_replace($value[0], $value[1], $prase),
										'compare' => 'LIKE'
									);
									$args['meta_query'][] = array(
										'key' => 'company_redirect_key',
										'value' => str_replace($value[0], $value[1], $prase),
										'compare' => 'LIKE'
									);

								}
							}
						}

						$phrase_alter = transliterator_transliterate('Latin-Russian/BGN', $prase);
						//$result .= 'удалить3463463463'.transliterator_transliterate('Latin-Russian/BGN', $prase);
						//print_r(transliterator_list_ids());
						//$result .= '<br />';
						//$result .= $phrase_alter;

					}
				}
				elseif (count($prase_explode) == 2) {
					//$result .= 'удалить'.'test2';
					//разбивка на 2 слова
					//if (    ((isRussian($prase_explode[0])) && !(isRussian($prase_explode[1]))) || (isRussian($prase_explode[1])) && !(isRussian($prase_explode[0])) ) {
					//если оно из слов русское, а второе нет
					//$result .= 'удалить'.'test4';
					if (mb_strlen($prase_explode[0], 'utf-8') > 5) {
						if(isRussian($prase_explode[0])) {

							//$result .= 'RU';
							$letters = [
								[ 'ай', 'i' ],
								[ 'кс', 'x' ],
								[ 'аль', 'al' ],
								[ 'с', 'c' ],
								[ 'тиньк', 'tink' ],
								[ 'блэк', 'black' ],
								[ 'э', 'a' ],
								[ 'гик', 'geek' ],
								[ 'брейн', 'brain' ],
								[ 'бреин', 'brain' ],
								[ 'гикбреин', 'geekbrain' ],
								[ 'гикбрейнс', 'geekbrain' ],
								[ 'юни', 'uni' ],
								[ 'юник', 'unic' ],
								[ 'кредит', 'credit' ],
								[ 'пицца', 'pizza' ]
							];

							$arr = [];
							foreach ($letters as $value) {

								if (strstr($prase_explode[0], $value[0])) {
									if (strpos($prase_explode[0], $value[0]) !== FALSE) {

										$args['meta_query'][] = array(
											'key' => 'company_name',
											'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase_explode[0])),
											'compare' => 'LIKE'
										);
										$args['meta_query'][] = array(
											'key' => 'company_redirect_key',
											'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase_explode[0])),
											'compare' => 'LIKE'
										);

									}
								}
							}

							$letters2 = [[' ','-'],[' ','.'],[' ',' & ']];

							$arr = [];
							foreach ($letters2 as $value) {

								if (strstr($prase_explode[0], $value[0])) {
									if (strpos($prase_explode[0], $value[0]) !== FALSE) {
										$test = str_replace($value[0], $value[1], $prase_explode[0]);
										$args['meta_query'][] = array(
											'key' => 'company_name',
											'value' => str_replace($value[0], $value[1], $prase_explode[0]),
											'compare' => 'LIKE'
										);
										$args['meta_query'][] = array(
											'key' => 'company_redirect_key',
											'value' => str_replace($value[0], $value[1], $prase_explode[0]),
											'compare' => 'LIKE'
										);

									}
								}
							}
							//$result .= $test;


							$phrase_alter = transliterator_transliterate('Russian-Latin/BGN', $prase_explode[0]);
							//$result .= '<br />';
							//$result .= $phrase_alter;

						} else {
							//$result .= 'удалить'.'3 шаг';
							//$result .= 'not_RU';
							$letters = [
								[ 'h', 'х' ],
								[ 'tink', 'тиньк' ],
								[ 'tink', 'тиньк' ],
								[ 'black', 'блэк' ],
								[ 'a', 'э' ]
							];

							$arr = [];
							foreach ($letters as $value) {

								if (strstr($prase_explode[0], $value[0])) {
									if (strpos($prase_explode[0], $value[0]) !== FALSE) {

										$args['meta_query'][] = array(
											'key' => 'company_name',
											'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase_explode[0])),
											'compare' => 'LIKE'
										);
										$args['meta_query'][] = array(
											'key' => 'company_redirect_key',
											'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase_explode[0])),
											'compare' => 'LIKE'
										);

									}
								}
							}

							$letters2 = [[' ','-'],[' ','.'],[' ',' & ']];

							$arr = [];
							foreach ($letters2 as $value) {

								if (strstr($prase, $value[0])) {
									if (strpos($prase, $value[0]) !== FALSE) {
										$test = str_replace($value[0], $value[1], $prase);
										$args['meta_query'][] = array(
											'key' => 'company_name',
											'value' => str_replace($value[0], $value[1], $prase),
											'compare' => 'LIKE'
										);
										$args['meta_query'][] = array(
											'key' => 'company_redirect_key',
											'value' => str_replace($value[0], $value[1], $prase),
											'compare' => 'LIKE'
										);

									}
								}
							}

							$phrase_alter = transliterator_transliterate('Latin-Russian/BGN', $prase_explode[0]);
							//$result .= 'удалить9999'.transliterator_transliterate('Latin-Russian/BGN', $prase_explode[0]);
							//print_r(transliterator_list_ids());
							//$result .= '<br />';
							//$result .= $phrase_alter;

						}
					}

					if (mb_strlen($prase_explode[1], 'utf-8') > 5) {
						if(isRussian($prase_explode[1])) {

							//$result .= 'RU';
							$letters = [
								[ 'ай', 'i' ],
								[ 'кс', 'x' ],
								[ 'аль', 'al' ],
								[ 'с', 'c' ],
								[ 'тиньк', 'tink' ],
								[ 'блэк', 'black' ],
								[ 'э', 'a' ],
								[ 'гик', 'geek' ],
								[ 'брейн', 'brain' ],
								[ 'бреин', 'brain' ],
								[ 'гикбреин', 'geekbrain' ],
								[ 'гикбрейнс', 'geekbrain' ],
								[ 'юни', 'uni' ],
								[ 'юник', 'unic' ],
								[ 'кредит', 'credit' ],
								[ 'пицца', 'pizza' ]
							];

							$arr = [];
							foreach ($letters as $value) {

								if (strstr($prase_explode[1], $value[0])) {
									if (strpos($prase_explode[1], $value[0]) !== FALSE) {

										$args['meta_query'][] = array(
											'key' => 'company_name',
											'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase_explode[1])),
											'compare' => 'LIKE'
										);
										$args['meta_query'][] = array(
											'key' => 'company_redirect_key',
											'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase_explode[1])),
											'compare' => 'LIKE'
										);

									}
								}
							}

							$letters2 = [[' ','-'],[' ','.'],[' ',' & ']];

							$arr = [];
							foreach ($letters2 as $value) {

								if (strstr($prase_explode[1], $value[0])) {
									if (strpos($prase_explode[1], $value[0]) !== FALSE) {
										$test = str_replace($value[0], $value[1], $prase_explode[1]);
										$args['meta_query'][] = array(
											'key' => 'company_name',
											'value' => str_replace($value[0], $value[1], $prase_explode[1]),
											'compare' => 'LIKE'
										);
										$args['meta_query'][] = array(
											'key' => 'company_redirect_key',
											'value' => str_replace($value[0], $value[1], $prase_explode[1]),
											'compare' => 'LIKE'
										);

									}
								}
							}
							//$result .= $test;


							$phrase_alter = transliterator_transliterate('Russian-Latin/BGN', $prase_explode[1]);
							//$result .= '<br />';
							//$result .= $phrase_alter;

						} else {
							//$result .= 'not_RU';
							$letters = [
								[ 'h', 'х' ],
								[ 'tink', 'тиньк' ],
								[ 'tink', 'тиньк' ],
								[ 'black', 'блэк' ],
								[ 'a', 'э' ]
							];

							$arr = [];
							foreach ($letters as $value) {

								if (strstr($prase_explode[1], $value[0])) {
									if (strpos($prase_explode[1], $value[0]) !== FALSE) {

										$args['meta_query'][] = array(
											'key' => 'company_name',
											'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase_explode[1])),
											'compare' => 'LIKE'
										);
										$args['meta_query'][] = array(
											'key' => 'company_redirect_key',
											'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase_explode[1])),
											'compare' => 'LIKE'
										);

									}
								}
							}

							$letters2 = [[' ','-'],[' ','.'],[' ',' & ']];

							$arr = [];
							foreach ($letters2 as $value) {

								if (strstr($prase, $value[0])) {
									if (strpos($prase, $value[0]) !== FALSE) {
										$test = str_replace($value[0], $value[1], $prase);
										$args['meta_query'][] = array(
											'key' => 'company_name',
											'value' => str_replace($value[0], $value[1], $prase),
											'compare' => 'LIKE'
										);
										$args['meta_query'][] = array(
											'key' => 'company_redirect_key',
											'value' => str_replace($value[0], $value[1], $prase),
											'compare' => 'LIKE'
										);

									}
								}
							}


							$phrase_alter = transliterator_transliterate('Latin-Russian/BGN', $prase_explode[1]);
							//$result .= 'удалить8888888'.transliterator_transliterate('Latin-Russian/BGN', $prase_explode[1]);
							//print_r(transliterator_list_ids());
							//$result .= '<br />';
							//$result .= $phrase_alter;

						}
					}
					/*} else {
						//$result .= 'удалить'.'test5';
						if(isRussian($prase)) {

							//$result .= 'RU';
							$letters = [['ай','i'],['кс','x'],['аль','al'],['с','c'],['тиньк','tink'],['блэк','black'],['э','a'],['гик],'geek;
				,['брейнс
				,'brains								$arr = [];
							foreach ($letters as $value) {

								if (strstr($prase, $value[0])) {
									if (strpos($prase, $value[0]) !== FALSE) {

										$args['meta_query'][] = array(
											'key' => 'company_name',
											'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase)),
											'compare' => 'LIKE'
										);

									}
								}
							}

							$letters2 = [[' ','-'],[' ','.'],[' ],'&;

							$arr = [];
							foreach ($letters2 as $value) {

								if (strstr($prase, $value[0])) {
									if (strpos($prase, $value[0]) !== FALSE) {
										$test = str_replace($value[0], $value[1], $prase);
										$args['meta_query'][] = array(
											'key' => 'company_name',
											'value' => str_replace($value[0], $value[1], $prase),
											'compare' => 'LIKE'
										);

									}
								}
							}
							//$result .= $test;


							$phrase_alter = transliterator_transliterate('Russian-Latin/BGN', $prase);
							//$result .= '<br />';
							//$result .= $phrase_alter;

						} else {
							//$result .= 'not_RU';
							$letters = [['h','х'],['tink','тиньк'],['tink','тиньк'],['black','блэк'],['a','э']];

							$arr = [];
							foreach ($letters as $value) {

								if (strstr($prase, $value[0])) {
									if (strpos($prase, $value[0]) !== FALSE) {

										$args['meta_query'][] = array(
											'key' => 'company_name',
											'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase)),
											'compare' => 'LIKE'
										);

									}
								}
							}
							$phrase_alter = transliterator_transliterate('Latin-Russian/BGN', $prase);
							//$result .= 'удалить333'.transliterator_transliterate('Latin-Russian/BGN', $prase);
							//print_r(transliterator_list_ids());
							//$result .= '<br />';
							//$result .= $phrase_alter;

						}
					}*/
					
				} else {
					//$result .= 'удалить'.'test3';
					if(isRussian($prase)) {

						//$result .= 'RU';
						$letters = [
							[ 'ай', 'i' ],
							[ 'кс', 'x' ],
							[ 'аль', 'al' ],
							[ 'с', 'c' ],
							[ 'тиньк', 'tink' ],
							[ 'блэк', 'black' ],
							[ 'э', 'a' ],
							[ 'гик', 'geek' ],
							[ 'брейн', 'brain' ],
							[ 'бреин', 'brain' ],
							[ 'гикбреин', 'geekbrain' ],
							[ 'гикбрейнс', 'geekbrain' ],
							[ 'юни', 'uni' ],
							[ 'юник', 'unic' ],
							[ 'кредит', 'credit' ],
							[ 'пицца', 'pizza' ]
						];


						$arr = [];
						foreach ($letters as $value) {

							if (strstr($prase, $value[0])) {
								if (strpos($prase, $value[0]) !== FALSE) {

									$args['meta_query'][] = array(
										'key' => 'company_name',
										'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase)),
										'compare' => 'LIKE'
									);
									$args['meta_query'][] = array(
										'key' => 'company_redirect_key',
										'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase)),
										'compare' => 'LIKE'
									);

								}
							}
						}

						$letters2 = [[' ','-'],[' ','.'],[' ',' & ']];

						$arr = [];
						foreach ($letters2 as $value) {

							if (strstr($prase, $value[0])) {
								if (strpos($prase, $value[0]) !== FALSE) {
									$test = str_replace($value[0], $value[1], $prase);
									$args['meta_query'][] = array(
										'key' => 'company_name',
										'value' => str_replace($value[0], $value[1], $prase),
										'compare' => 'LIKE'
									);
									$args['meta_query'][] = array(
										'key' => 'company_redirect_key',
										'value' => str_replace($value[0], $value[1], $prase),
										'compare' => 'LIKE'
									);
								}
							}
						}
						//$result .= $test;


						$phrase_alter = transliterator_transliterate('Russian-Latin/BGN', $prase);
						//$result .= '<br />';
						//$result .= $phrase_alter;

					} else {
						//$result .= 'not_RU';
						$letters = [
							[ 'h', 'х' ],
							[ 'tink', 'тиньк' ],
							[ 'tink', 'тиньк' ],
							[ 'black', 'блэк' ],
							[ 'a', 'э' ]
						];

						$arr = [];
						foreach ($letters as $value) {

							if (strstr($prase, $value[0])) {
								if (strpos($prase, $value[0]) !== FALSE) {

									$args['meta_query'][] = array(
										'key' => 'company_name',
										'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase)),
										'compare' => 'LIKE'
									);
									$args['meta_query'][] = array(
										'key' => 'company_redirect_key',
										'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase)),
										'compare' => 'LIKE'
									);

								}
							}
						}

						$letters2 = [[' ','-'],[' ','.'],[' ',' & ']];

						$arr = [];
						foreach ($letters2 as $value) {

							if (strstr($prase, $value[0])) {
								if (strpos($prase, $value[0]) !== FALSE) {
									$test = str_replace($value[0], $value[1], $prase);
									$args['meta_query'][] = array(
										'key' => 'company_name',
										'value' => str_replace($value[0], $value[1], $prase),
										'compare' => 'LIKE'
									);
									$args['meta_query'][] = array(
										'key' => 'company_redirect_key',
										'value' => str_replace($value[0], $value[1], $prase),
										'compare' => 'LIKE'
									);

								}
							}
						}


						$phrase_alter = transliterator_transliterate('Latin-Russian/BGN', $prase);
						//$result .= 'удалить4444'.transliterator_transliterate('Latin-Russian/BGN', $prase);
						//print_r(transliterator_list_ids());
						//$result .= '<br />';
						//$result .= $phrase_alter;

					}
				}

				if($phrase_alter != '') {
					$args['meta_query'][] = array(
						'key' => 'company_name',
						'value' => $phrase_alter,
						'compare' => 'LIKE'
					);
					$args['meta_query'][] = array(
						'key' => 'company_redirect_key',
						'value' => preg_replace('/\s+/', '', $phrase_alter),
						'compare' => 'LIKE'
					);
				}
				if($prase != '') {
					$args['meta_query'][] = array(
						'key'     => 'company_name',
						'value'   => $prase,
						'compare' => 'LIKE'
					);
					$args['meta_query'][] = array(
						'key' => 'company_redirect_key',
						'value' => preg_replace('/\s+/', '', $prase),
						'compare' => 'LIKE'
					);

					$arr_url = ['https:','http:','/'];
					$args['meta_query'][] = array(
						'key'		=> 'websites_$_site_url',
						'compare'	=> 'LIKE',
						'value'		=> str_replace($arr_url, "", $prase)
					);
					$args['meta_query'][] = array(
						'key' => 'company_redirect_key',
						'value' => str_replace($arr_url, "", $prase),
						'compare' => 'LIKE'
					);
				}

			}
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				$result .= '<ul>';
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					global $post;
					$company_name = get_field('company_name',$post->ID);
					if(!$company_name || $company_name == '') {
						$company_name = get_the_title($post->ID);
					}
					$result .= '<li data-id="'.$post->ID.'">'.$company_name.'</li>';
				}
				$result .= '</ul>';
			} else {
				$result .= '<div class="search_not_found_container">';
				$result .= '<div class="search_not_found color_dark_gray font_small">'.__('Компании','er_theme').' '.$prase.' '.__('еще нет на сайте','er_theme').'</div>';
				$result .= '<div class="button button_violet font_small font_bold autocomplete_add_new pointer">'.__('Добавить','er_theme').'</div>';
				$result .= '</div>';

			}
			wp_reset_postdata();
		} elseif($search_type == 'filter_ratings' || $search_type == 'filter_news') {
			if($data['tags'] && !empty($data['tags'])) {
				$existing = explode(',', $data['tags']);
			} else {
				$existing = array();
			}

			$args = array(
				'taxonomy' => 'affiliate-tags',
				'orderby' => 'meta_value',
				'order' => 'ASC',
				'meta_key' => 'tag_human_title',
				'hide_empty' => false,
				'hierarchical' => false,
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key'     => 'tag_human_title',
						'value'   => $prase,
						'compare' => 'LIKE'
					),
					array(
						'key'     => 'tag_human_title',
						'value'   => transliterator_transliterate('Russian-Latin/BGN', $prase),
						'compare' => 'LIKE'
					)
				)

			);

			if( $current_language == 'ru_RU' ) {
				// Включаем признак для фильтрации таксономий с включенным чекбоксом "Спрятать на русском языке" через terms_clauses
				$args['tag_hide_on_ru_language'] = 1;		
			}

			$term_query = new WP_Term_Query( $args );

			if( ! empty( $term_query->terms ) ) {
				$result .= '<ul>';
				foreach($term_query->terms as $tag) {
					if(!in_array($tag->term_id,$existing)) {
						$human_title = get_field('tag_human_title','term_'.$tag->term_id);
						if($human_title && $human_title != '') {
							if (isRussian(mb_substr($human_title, 0, 1))) {
								$cyr[] = '<li data-id="'.$tag->term_id.'">'.$human_title.'<input type="hidden" name="tags[]" value="'.$tag->term_id.'"></li>';
							} else {
								$eng[] = '<li data-id="'.$tag->term_id.'">'.$human_title.'<input type="hidden" name="tags[]" value="'.$tag->term_id.'"></li>';
							}
							//$result .= '<li data-id="'.$tag->term_id.'">'.$human_title.'<input type="hidden" name="tags[]" value="'.$tag->term_id.'"></li>';
						}
					}

				}
				foreach ( $cyr as $item ) {
					$result .= $item;
				}
				foreach ( $eng as $item ) {
					$result .= $item;
				}
				$result .= '</ul>';
			} else {
				$result .= '<div class="search_not_found_container">';
				$result .= '<div class="search_not_found color_dark_gray font_small">'.__('Рубрика не найдена','er_theme').'</div>';
				$result .= '</div>';
			}
		} elseif($search_type == 'filter_ratings_comp_type') {
			if($data['tags'] && !empty($data['tags'])) {
				$existing = explode(',', $data['tags']);
			} else {
				$existing = array();
			}

			$args = array(
				'taxonomy' => 'affiliate-tags',
				'orderby' => 'meta_value',
				'order' => 'ASC',
				'meta_key' => 'tag_human_title',
				'hide_empty' => false,
				'hierarchical' => false,
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key'     => 'tag_human_title',
						'value'   => $prase,
						'compare' => 'LIKE'
					),
					array(
						'key'     => 'tag_human_title',
						'value'   => transliterator_transliterate('Russian-Latin/BGN', $prase),
						'compare' => 'LIKE'
					)
				)

			);

			if( $current_language == 'ru_RU' ) {
				// Включаем признак для фильтрации таксономий с включенным чекбоксом "Спрятать на русском языке" через terms_clauses
				$args['tag_hide_on_ru_language'] = 1;		
			}

			$term_query = new WP_Term_Query( $args );

			if( ! empty( $term_query->terms ) ) {
				$result .= '<ul>';
				foreach($term_query->terms as $tag) {
					$term_temp = get_term( $tag->term_id, 'affiliate-tags' );
					$slug = $term_temp->slug;
					$term_id_wrapper = get_term_by('slug', $slug, 'companytypes');
					if ($term_id_wrapper->term_id != '') {
						if(!in_array($tag->term_id,$existing)) {
							$human_title = get_field('tag_human_title','term_'.$tag->term_id);
							if($human_title && $human_title != '') {
								if (isRussian(mb_substr($human_title, 0, 1))) {
									$cyr[] = '<li data-id="'.$tag->term_id.'">'.$human_title.'<input type="hidden" name="tags[]" value="'.$tag->term_id.'"></li>';
								} else {
									$eng[] = '<li data-id="'.$tag->term_id.'">'.$human_title.'<input type="hidden" name="tags[]" value="'.$tag->term_id.'"></li>';
								}
								//$result .= '<li data-id="'.$tag->term_id.'">'.$human_title.'<input type="hidden" name="tags[]" value="'.$tag->term_id.'"></li>';
							}
						}
					}

				}
				foreach ( $cyr as $item ) {
					$result .= $item;
				}
				foreach ( $eng as $item ) {
					$result .= $item;
				}
				$result .= '</ul>';
			} else {
				$result .= '<div class="search_not_found_container">';
				$result .= '<div class="search_not_found color_dark_gray font_small">'.__('Рубрика не найдена','er_theme').'</div>';
				$result .= '</div>';
			}
		}



		echo $result;
		die;
	}

}

if ( ! function_exists( 'otuside_submit_form' ) ) {
	add_action( 'wp_ajax_otuside_submit_form', 'otuside_submit_form' );
	add_action( 'wp_ajax_nopriv_otuside_submit_form', 'otuside_submit_form' );
	function otuside_submit_form() {
		$data = $_POST;
		//print_r($data);
		$result       = array();
		$type         = $data['type_send'];
		$comment_text = $data['comment_text'];
		$new_name     = $data['new_name'];
		$files        = $data['files'];
		$links        = $data['links'];
		$cur_user_id  = get_current_user_id();
		$user_info    = get_userdata( $cur_user_id );
		if ( ! $comment_text || $comment_text == '' ) {
			$result['status']  = 'error';
			$result['message'] = __( 'Пожалуйста, введите текст', 'er_theme' );
		} else {
			if ( $data['post_id'] == 0 && $new_name != '' ) {
				$new_post_data = array(
					'post_title'   => sanitize_text_field( $new_name ),
					'post_content' => '',
					'post_status'  => 'draft',
					'post_author'  => 1,
					'post_type'    => 'casino'
				);
				
				// Вставляем запись в базу данных
				$new_post_id = wp_insert_post( $new_post_data, true );
				if ( is_wp_error( $new_post_id ) ) {
					$result['status']  = 'error';
					$result['message'] = $new_post_id->get_error_message();
				} else {
					update_field( 'company_name', sanitize_text_field( $new_name ), $new_post_id );
					$post_id = $new_post_id;
				}
			} else {
				$post_id = $data['post_id'];
			}
			
			if ( $post_id && $post_id != 0 && $post_id != '' ) {
				$commentdata = array(
					'comment_post_ID'      => $post_id,
					'comment_content'      => htmlspecialchars( $data['comment_text'] ),
					'comment_author'       => $user_info->display_name,
					'comment_author_email' => $user_info->user_email,
					'comment_type'         => 'comment',
					'user_ID'              => $cur_user_id,
				);
				//print_r($commentdata);
				
				if ( strlen( preg_replace( '/\s+/', '', $commentdata['comment_content'] ) ) == 0 ) {
					$result['status']  = 'error';
					$result['message'] = __( 'Вы не написали отзыв', 'er_theme' );
				} else {
					$new_comment = wp_new_comment( $commentdata, true );
					if ( is_wp_error( $new_comment ) ) {
						$result['status']  = 'error';
						$result['message'] = $new_comment->get_error_message();
					} else {
						$current_language = get_locale();
						update_field( 'language_original', $current_language, 'comment_' . $new_comment );
						wp_set_comment_status( $new_comment, 0 );
						if ( $new_comment ) {
							if ( ! empty( $data['rating'] ) ) {
								$user_stat_rate_arr = [];
								foreach ( $data['rating'] as $key => $value ) {
									update_field( $key, $value, 'comment_' . $new_comment );
								}
							}
							update_field( 'field_5fce35905450b', 0, 'comment_' . $new_comment );
							if ( ! empty( $files ) ) {
								foreach ( $files as $file ) {
									if ( array_key_exists( $file, $links ) ) {
										
										$row = array(
											'file_type' => 'url',
											'file'      => $file,
											'link'      => $links[ $file ]
										);
									} else {
										$row = array(
											'file_type' => 'image',
											'file'      => $file
										);
									}
									//print_r($row);
									add_row( 'comment_files', $row, 'comment_' . $new_comment );
								}
							}
							$result['status'] = 'ok';
							$result['type']   = $type;
							
							if ( $type == 'abuse' ) {
								update_field( 'is_abuse', 1, 'comment_' . $new_comment );
								$result['message'] = __( 'Ваша жалоба ожидает модерации', 'er_theme' );
								update_field( 'comment_type', 'abuses', 'comment_' . $new_comment );
								update_field( 'abuse_state', 'not_seen', $new_comment );
								
							} elseif ( $type == 'review' ) {
								
								update_field( 'comment_type', 'reviews', 'comment_' . $new_comment );
								$result['message'] = __( 'Ваш отзыв ожидает модерации', 'er_theme' );
							}
							$result['comment_id'] = $new_comment;
						} else {
							$result['status']  = 'error';
							$result['message'] = __( 'Возникла ошибка', 'er_theme' );
						}
					}
				}
			} else {
				$result['status']  = 'error';
				$result['message'] = __( 'Возникла ошибка', 'er_theme' );
			}
			
			
		}
		echo json_encode( $result );
		die;
	}
}

if ( ! function_exists( 'load_popup_outside_form' ) ) {
	add_action( 'wp_ajax_load_popup_outside_form', 'load_popup_outside_form' );
	add_action( 'wp_ajax_nopriv_load_popup_outside_form', 'load_popup_outside_form' );
	function load_popup_outside_form() {
		$data   = $_POST;
		$result = '';
		
		$rating_fields_group = get_rating_fields_group( $data['id'] );
		if ( ! $rating_fields_group ) {
			$rating_fields_group = 87485;
		}
		if ( $data['type'] == 'reviewgetcompany' ) {
			$current_language = get_locale();
			if ( $current_language != 'ru_RU' ) {
				$result .= '<span class="review_connect_company font_small color_dark_gray">Do you want to link the ' . get_field( 'company_name', $data['id'] ) . ' company to your profile?</span><div class="review_connect_company_btn button button_violet font_small font_bold pointer">Link the company</div>';
			} else {
				$result .= '<span class="review_connect_company font_small color_dark_gray">Вы хотите привязать компанию ' . get_field( 'company_name', $data['id'] ) . ' к вашему аккаунту?</span><div class="review_connect_company_btn button button_violet font_small font_bold pointer">Привязать компанию</div>';
			}
			
		} else {
			$ratings = get_comment_rating_fields( $rating_fields_group, 'key' );
			//$result .= $data['type'].' '.$data['id'].' '.$data['exists'].' '.$data['company_name'];
			$result .= '<form action="' . admin_url( 'admin-ajax.php' ) . '" method="post" id="popup_outside_form_form">';
			$result .= print_css_links( 'review_form' );
			$result .= print_css_links( 'popup_forms' );
			$result .= '<textarea name="comment_text" class="m_b_20"></textarea>';
			$result .= '<input type="hidden" name="action" value="otuside_submit_form" />';
			$result .= '<input type="hidden" name="type_send" value="' . $data['type'] . '" />';
			$result .= '<input type="hidden" name="post_id" value="' . $data['id'] . '" />';
			if ( $data['id'] == 0 && $data['exists'] == 0 && $data['company_name'] != '' ) {
				$result .= '<input type="hidden" name="new_name" value="' . $data['company_name'] . '" />';
			}
			if ( $data['type'] == 'review' ) {
				$result .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">' . __( 'Оцените компанию по критериям', 'er_theme' ) . '</div>';
				$result .= '<div class="rating_columns flex m_b_20">';
				
				foreach ( $ratings as $item ) {
					$result .= '<div class="form_rating flex">';
					$result .= '<div class="form_field_name color_dark_gray font_smaller">' . $item['field_label'] . '</div>';
					$result .= '<div class="rating m_b_15">';
					$result .= rating_field( $item['field_min'], $item['field_max'], 'rating', $item['field_name'] );
					$result .= '</div>';
					$result .= '</div>';
				}
				
				$result .= '</div>';
				$result .= '<script type="text/javascript">
		             jQuery(document).ready(function($) {
		                $( \'input[type="submit"]\' ).prop( "disabled", true );
		                $(".rating input").change(function(){
                        if ($(\'.form_rating:not(:has(:radio:checked))\').length) {
                            //alert("At least one group is blank");
                            $( \'input[type="submit"]\' ).prop( "disabled", true );
                        } else {
		                   // alert("fine");
                            $( \'input[type="submit"]\' ).prop( "disabled", false );
                         };
                        });
		             });
		             </script>';
			}
			
			
			$result .= '<ul class="review_form_icons flex">';
			$result .= '<li class="form_icon_img inactive"><span class="form_icon_img_inside"></span><span class="add_image_text"><span>Добавить изображение</span></span></li>';
			$result .= '<li class="form_icon_notify inactive"><span class="form_icon_notify_inside"></span><span class="subs_comments"><span>Подписаться на эту компанию</span></span></li>';
			//$result .= '<li class="form_icon_link inactive"></li>';
			$result .= '</ul>';
			if ( $data['type'] == 'abuse' ) {
				$result .= '<input class="button button_big button_violet m_b_10 pointer font_small font_bold" type="submit" value="' . __( 'Разместить жалобу', 'er_theme' ) . '" />';
				
			} elseif ( $data['type'] == 'review' ) {
				$result .= '<input class="button button_big button_green m_b_10 pointer font_small font_bold" type="submit" value="' . __( 'Разместить отзыв', 'er_theme' ) . '" />';
			}
			$result .= '</form>';
		}
		echo $result;
		die;
	}
}

if ( ! function_exists( 'ajax_resort_ratings' ) ) {
	add_action( 'wp_ajax_ajax_resort_ratings', 'ajax_resort_ratings' );
	add_action( 'wp_ajax_nopriv_ajax_resort_ratings', 'ajax_resort_ratings' );
	function ajax_resort_ratings() {
		$data = $_POST;
		//print_r($data);
		$tags   = $data['tags'];
		$sort   = $data['sort'];
		$result = '';
		$result .= rating_table_all( $tags, $sort );
		echo $result;
		die;
	}
}

if ( ! function_exists( 'ajax_link_outside' ) ) {
	add_action( 'wp_ajax_ajax_link_outside', 'ajax_link_outside' );
	add_action( 'wp_ajax_nopriv_ajax_link_outside', 'ajax_link_outside' );
	function ajax_link_outside() {
		$data   = $_POST;
		$result = array();
		if ( ! is_user_logged_in() ) {
			$result['status'] = 'auth';
			if ( $data['type'] == 'review' ) {
				$result['message'] = __( 'Чтобы оставить отзыв компании, пожалуйста, авторизуйтесь на сайте.', 'er_theme' );
			} elseif ( $data['type'] == 'abuse' ) {
				$result['message'] = __( 'Чтобы оставить жалобу на компанию, пожалуйста, авторизуйтесь на сайте.', 'er_theme' );
			} else {
				$result['message'] = __( 'Пожалуйста, авторизуйтесь на сайте.', 'er_theme' );
			}
			
		} else {
			$current_user     = wp_get_current_user();
			$user_id          = $current_user->data->ID;
			$result['status'] = 'ok';
			$message          = '';
			$class_type       = $data['type'];
			if ( $class_type == 'reviewgetcompany' ) {
				$class_type = 'review';
			}
			$message .= '<div class="popup_container" id="popup_link_outside_' . $class_type . '" data-form-type="' . $data['type'] . '">';
			$message .= '<div class="popup_window box_shadow">';
			$message .= '<div class="popup_close_button pointer"></div>';
			
			$message .= '<div class="p_30 flex flex_column">';
			if ( $data['type'] == 'abuse' ) {
				$message .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">' . __( 'Новая жалоба на компанию', 'er_theme' ) . '</div>';
			} elseif ( $data['type'] == 'review' ) {
				$message .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">' . __( 'Новый отзыв о компании', 'er_theme' ) . '</div>';
			} elseif ( $data['type'] == 'reviewgetcompany' ) {
				$message .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">' . __( 'Добавить компанию', 'er_theme' ) . '</div>';
			}
			
			$message           .= '<div class="autocomplete_container" data-type="search_companies" id="popup_search_companies">';
			$message           .= '<input name="autocomplete_text" type="text" value="" placeholder="' . __( 'Введите название компании', 'er_theme' ) . '" />';
			$message           .= '<input name="autocomplete_result" type="hidden" value="" />';
			$message           .= '<div class="autocomplete_icon_search"></div>';
			$message           .= '<div class="autocomplete_icon_close"></div>';
			$message           .= '<div class="autocomplete_search_results"></div>';
			$message           .= '</div>';
			$message           .= '<div class="outside_form_container"></div>';
			$message           .= '</div>';
			$message           .= '</div>';
			$message           .= '</div>';
			$result['message'] = $message;
		}
		echo json_encode( $result );
		
		die;
	}
}


function autocomplete_input( $id, $type, $text ) {
	$message = '';
	$message .= '<div class="autocomplete_container" data-type="' . $type . '" id="' . $id . '">';
	$message .= '<input name="autocomplete_text" type="text" value="" placeholder="' . $text . '" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"/>';
	$message .= '<input name="autocomplete_result" type="hidden" value="" />';
	$message .= '<div class="autocomplete_icon_search"></div>';
	$message .= '<div class="autocomplete_icon_close"></div>';
	$message .= '<div class="autocomplete_search_results"></div>';
	if ( $type == 'filter_ratings' ) {
		$message .= '<form id="filter_form_' . $id . '" class="outside_tags" action="' . admin_url( 'admin-ajax.php' ) . '" method="post">';
		$message .= '<input type="hidden" name="action" value="ajax_resort_ratings" />';
		$message .= '<input type="hidden" name="sort" value="title" />';
		$message .= '<ul></ul>';
		$message .= '</form>';
	} elseif ( $type == 'filter_news' ) {
		$message .= '<form id="filter_form_' . $id . '" class="outside_tags" action="' . admin_url( 'admin-ajax.php' ) . '" method="post">';
		$message .= '<input type="hidden" name="action" value="resort_news_tags" />';
		$message .= '<input type="hidden" name="sort" value="date" />';
		$message .= '<ul></ul>';
		$message .= '</form>';
	} elseif ( $type == 'filter_ratings_comp_type' ) {
		$message .= '<form id="filter_form_' . $id . '" class="outside_tags" action="' . admin_url( 'admin-ajax.php' ) . '" method="post">';
		$message .= '<input type="hidden" name="action" value="resort_news_tags" />';
		$message .= '<input type="hidden" name="sort" value="date" />';
		$message .= '<ul></ul>';
		$message .= '</form>';
	}
	$message .= '</div>';
	
	
	return $message;
}

if ( ! function_exists( 'form_separate_review_single' ) ) {
	function form_separate_review_single( $post_id, $new_name = '' ) {
		$result = '';
		if ( $new_name != '' ) {
			$company_name = $new_name;
			$result       .= '<h1>' . __( 'Новый отзыв о компании', 'er_theme' ) . ' ' . $company_name . '</h1>';
			$result       .= '<div class="review_change_company"><a href="' . get_bloginfo( 'url' ) . '/add-review/" rel="nofollow">' . __( 'Я хочу написать отзыв о другой компании', 'er_theme' ) . '</a></div>';
		} else {
			$company_name = get_field( 'company_name', $post_id );
			$result       .= '<h1>' . __( 'Новый отзыв о компании', 'er_theme' ) . ' ' . $company_name . '</h1>';
			$result       .= '<div class="review_change_company"><a href="' . get_bloginfo( 'url' ) . '/add-review/" rel="nofollow">' . __( 'Я хочу написать отзыв о другой компании', 'er_theme' ) . '</a></div>';
		}
		
		$result .= '<div class="form_separate_review_single">';
		if ( $post_id == 0 ) {
			$rating_fields_group = 87485;
		} elseif ( get_post_type( $post_id ) == 'casino' ) {
			$rating_fields_group = get_rating_fields_group( $post_id );
			
			
		}
		$ratings = get_comment_rating_fields( $rating_fields_group, 'key' );
		//if($rating_fields_group != 0) {
		$result .= '<form action="' . admin_url( 'admin-ajax.php' ) . '" method="post" id="popup_form_review_newform" class="clickable">';
		$result .= print_css_links( 'review_form' );
		if ( isset( $_COOKIE["_ym_uid"] ) ) {
			$timervop = htmlspecialchars( $_COOKIE["_ym_uid"] );
			$result   .= '<input type="hidden" name="ym_uid" value="' . $timervop . '" />';
			// update_field('client_id_yandex', $timervop, 'user_'.$user_id);
		}
		
		$result .= '<input type="hidden" name="action" value="new_submit_review_newform" />';
		$result .= '<input type="hidden" name="type_send" value="review" />';
		$result .= '<input type="hidden" name="post_id" value="' . $post_id . '" />';
		if ( $post_id == 0 && $new_name != '' ) {
			$result .= '<input type="hidden" name="new_name" value="' . $new_name . '" />';
		}
		
		
		if ( ! empty( $ratings ) ) {
			$result .= '<div class="new_form_block has_notice">';
			$result .= '<div class="notice"><span>' . __( 'Оценка компании является обязательной для публикации отзыва.', 'er_theme' ) . '</span></div>';
			$result .= '<div class="new_form_block_title color_dark_blue font_bolder font_smaller_2 font_uppercase">' . __( 'Оцените компанию по критериям', 'er_theme' ) . ' *</div>';
			$result .= '<div class="new_form_block_content">';
			$result .= '<div class="rating_columns flex">';
			
			foreach ( $ratings as $item ) {
				$result .= '<div class="form_rating flex">';
				$result .= '<div class="form_field_name color_dark_gray font_smaller">' . $item['field_label'] . '</div>';
				$result .= '<div class="rating m_b_15">';
				$result .= rating_field( $item['field_min'], $item['field_max'], 'rating', $item['field_name'] );
				$result .= '</div>';
				$result .= '</div>';
			}
			$result .= '</div>';
			/*$result .= '<script type="text/javascript">
		             jQuery(document).ready(function($) {
					 	$(\'input[name="review_title"],textarea,.form_rating:not(:has(:radio:checked))\').on(\'keyup\', function() {
							let empty = false;

							$(\'input[name="review_title"],textarea,.form_rating:not(:has(:radio:checked))\').each(function() {
							  empty = $(this).val().length == 0;
							});

							if (empty)
							  $(\'input[type="submit"]\').attr(\'disabled\', \'disabled\');
							else
							  $(\'input[type="submit"]\').attr(\'disabled\', false);
						  });
		                $( \'input[type="submit"]\' ).prop( "disabled", true );
		                $(".rating input").change(function(){
                        if ($(\'.form_rating:not(:has(:radio:checked))\').length) {
                            //alert("At least one group is blank");
                            $( \'input[type="submit"]\' ).prop( "disabled", true );
						} else if($(\'input[name="review_title"]\').val().length < 1) {
							$( \'input[type="submit"]\' ).prop( "disabled", true );
						} else if($(\'textarea\').val().length < 1) {
							$( \'input[type="submit"]\' ).prop( "disabled", true );
                        } else {
		                   // alert("fine");
                            $( \'input[type="submit"]\' ).prop( "disabled", false );
                         };
                        });
		             });
		             </script>';*/
			$result .= '</div>';
			$result .= '</div>';
		}
		
		$result .= '<div class="flex flex_wrap">';
		$result .= '<div class="single_newform_left how_long">';
		$result .= '<div class="line_title">' . __( 'Как давно пользовались?', 'er_theme' ) . '</div>';
		$result .= '<select name="review_year"class="m_b_20">';
		$result .= '<option value="2023" selected>' . __( '2023', 'er_theme' ) . '</option>';
		$result .= '<option value="2022">' . __( '2022', 'er_theme' ) . '</option>';
		$result .= '<option value="2021">' . __( '2021', 'er_theme' ) . '</option>';
		$result .= '<option value="2020">' . __( '2020', 'er_theme' ) . '</option>';
		$result .= '<option value="2019">' . __( '2019', 'er_theme' ) . '</option>';
		$result .= '<option value="2018">' . __( '2018', 'er_theme' ) . '</option>';
		$result .= '<option value="2017">' . __( '2017', 'er_theme' ) . '</option>';
		$result .= '<option value="2016">' . __( '2016', 'er_theme' ) . '</option>';
		$result .= '<option value="2015">' . __( '2015', 'er_theme' ) . '</option>';
		$result .= '</select>';
		$result .= '</div>';
		$result .= '<div class="single_newform_right right_recommend">';
		$result .= '<div class="title">' . __( 'Рекомендуете друзьям?', 'er_theme' ) . ' *</div>';
		$result .= '<div class="checkbox_container font_small color_dark_blue">';
		$result .= '<input type="radio" id="recomend_for_friends" name="recomend_for_friends"  class="custom-checkbox" value="yes">';
		
		$result .= '<label for="recomend_for_friends" class="m_right_10">' . __( 'Да', 'er_theme' ) . '</label>';
		
		$result .= '<input type="radio" id="recomend_for_friends_no" name="recomend_for_friends"  class="custom-checkbox" value="no">';
		$result .= '<label for="recomend_for_friends_no">' . __( 'Нет', 'er_theme' ) . '</label>';
		$result .= '</div>';
		
		$result .= '</div>';
		$result .= '<div class="single_newform_left pm_cont">';
		
		$result .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase">' . __( 'Плюсы', 'er_theme' ) . '</div>';
		$result .= '<div class="plus_minus_container plus">';
		$result .= '<input type="text" name="review_pluses[]" value="" class="" placeholder="' . __( 'Введите текст..', 'er_theme' ) . '" />';
		$result .= '<div class="plus" data-total="1">+</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '<div class="single_newform_right pm_cont">';
		$result .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase">' . __( 'Минусы', 'er_theme' ) . '</div>';
		$result .= '<div class="plus_minus_container minus">';
		$result .= '<input type="text" name="review_minuses[]" value="" class="" placeholder="' . __( 'Введите текст..', 'er_theme' ) . '" />';
		$result .= '<div class="plus" data-total="1">+</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '<div class="new_form_block has_notice has_notice_text_comment">';
		$result .= '<div class="notice"><span class="color_dark_blue">' . __( 'Укажите главную мысль отзыва. Упоминать название компании в заголовке не нужно. ', 'er_theme' ) . '</span></div>';
		$result .= '<div class="new_form_block_line_input">';
		$result .= '<div class="line_title">' . __( 'Заголовок', 'er_theme' ) . ' *</div>';
		$result .= '<input type="text" name="review_title" value="" class="" />';
		$result .= '</div>';
		$result .= '<textarea name="comment_text" class="m_b_20" placeholder="' . __( 'Текст отзыва', 'er_theme' ) . ' *"></textarea>';
		$result .= '<ul class="review_form_icons flex">';
		$result .= '<li class="form_icon_img inactive"><span class="form_icon_img_inside"></span><span class="add_image_text"><span>Добавить изображение</span></span></li>';
		$result .= '<li class="form_icon_notify inactive"><span class="form_icon_notify_inside"></span><span class="subs_comments"><span>Подписаться на ответы компании</span></span></li>';
		//$result .= '<li class="form_icon_link inactive"></li>';
		$result .= '</ul>';
		$result .= '</div>';
		
		
		$result .= '<div class="review_single_button_container_width">';
		
		$result .= '<input class="button button_big button_green m_b_10 pointer font_small font_bold" type="submit" value="' . __( 'Опубликовать отзыв', 'er_theme' ) . '" />';
		$result .= '<div class="button button_big button_border m_b_10 pointer font_small font_bold preview_review clickable">' . __( 'Предпросмотр', 'er_theme' ) . '</div>';
		$result .= '</div>';
		
		$result .= '</form>';
		$result .= '<div class="preview"></div>';
		$result .= '</div>';
		
		return $result;
	}
}


if ( ! function_exists( 'review_form_separate3' ) ) {
	function review_form_separate3( $post_id ) {
		$result = '';
		$result .= '<div class="review_form_separate">';
		$result .= '<div class="wrap flex_column">';
		if ( $post_id != 0 ) {
			//$company_name = get_field('company_name',$post_id);
			//$result .= '<h1>'.__('Новый отзыв о компании','er_theme').' '.$company_name.'</h1>';
			//$result .= '<div class="review_change_company"><a href="'.get_bloginfo('url').'/add-review/">'.__('Я хочу написать отзыв о другой компании','er_theme').'</a></div>';
			$result .= form_separate_review_single( $post_id );
		} else {
			$result .= '<h1>' . __( 'Новый отзыв', 'er_theme' ) . '</h1>';
			$result .= '<div class="autocomplete_container" data-type="search_companies" id="popup_search_companies">';
			$result .= '<input name="autocomplete_text" type="text" value="" placeholder="' . __( 'Введите название компании', 'er_theme' ) . '" />';
			$result .= '<input name="autocomplete_result" type="hidden" value="" />';
			$result .= '<div class="autocomplete_icon_search"></div>';
			$result .= '<div class="autocomplete_icon_close"></div>';
			$result .= '<div class="autocomplete_search_results"></div>';
			$result .= '</div>';
			$result .= '<div class="outside_form_container"></div>';
		}
		
		
		$result .= '</div>';
		$result .= '</div>';
		echo $result;
	}
}


if ( ! function_exists( 'after_login_new_comment_form_submit_auth_me' ) ) {
	add_action( 'wp_ajax_after_login_new_comment_form_submit_auth_me', 'after_login_new_comment_form_submit_auth_me' );
	add_action( 'wp_ajax_nopriv_after_login_new_comment_form_submit_auth_me', 'after_login_new_comment_form_submit_auth_me' );
	function after_login_new_comment_form_submit_auth_me() {
		$data                        = $_POST;
		$result                      = array();
		$login_data                  = array();
		$login_data['user_login']    = $data['email'];
		$login_data['user_password'] = $data['password'];
		$remember                    = $data['remember'];
		if ( $remember == 'on' ) {
			$login_data['remember'] = true;
		} else {
			$login_data['remember'] = false;
		}
		
		
		$user_verify = wp_signon( $login_data, true );
		if ( is_wp_error( $user_verify ) ) {
			$result['status']  = 'login_error';
			$result['message'] = $user_verify->get_error_message();
		} else {
			$result['status']  = 'login_ok';
			$result['message'] = 'ok';
		}
		echo json_encode( $result );
		die;
	}
}
if ( ! function_exists( 'after_login_new_comment_form_submit' ) ) {
	add_action( 'wp_ajax_after_login_new_comment_form_submit', 'after_login_new_comment_form_submit' );
	add_action( 'wp_ajax_nopriv_after_login_new_comment_form_submit', 'after_login_new_comment_form_submit' );
	function after_login_new_comment_form_submit() {
		$data   = $_POST;
		$result = array();
		
		if ( ! $data['email'] ) {
			$result['status']  = 'error';
			$result['message'] = __( 'Пожалуйста, укажите E-mail', 'er_theme' );
		} else {
			if ( filter_var( $data['email'], FILTER_VALIDATE_EMAIL ) ) {
				if ( email_exists( $data['email'] ) ) {
					$result['status']  = 'auth';
					$result['message'] = '<div class="line_new_form">' . __( 'E-mail уже зарегистрирован. Введите пароль, чтобы авторизоваться, или ', 'er_theme' ) . '<span class="change_email_newform link_underline">' . __( 'Укажите другой', 'er_theme' ) . '</span></div>';
					$result['message'] .= '<div class="line_new_form m_t_15"><input type="password" name="password" ></div>';
				} else {
					$result['status']  = 'new_reg';
					$result['message'] .= '<div class="line_new_form"><input type="text" name="name_first" placeholder="' . __( 'Имя', 'er_theme' ) . ' *" ></div>';
					$result['message'] .= '<div class="line_new_form m_t_15"><input type="text" name="name_last" placeholder="' . __( 'Фамилия ', 'er_theme' ) . '" ></div>';
					/*
					$last_id_user = get_field('last_id_user', 'option');
					$last_id_userToUpdate = intval($last_id_user) + 1;
					$login = 'id'.$last_id_userToUpdate;
					$password = wp_generate_password();
					$userdata = array(
						'user_login' => $login,
						'user_nicename' => $login,
						'user_pass' => $password,
						'user_email' => $data['email'],
						'remember' => true
					);
					$user_id = wp_insert_user( $userdata );
					if( is_wp_error( $user_id  ) ) {
						$result['status'] = 'error';
						$result['message'] = $user_id->get_error_message();
					} else {
						$result['status'] = 'new_reg';
						$result['user_id'] = $user_id;
						$result['password'] = $password;
						$result['message'] = __('Вы успешно зарегистрированы. Ваш пароль: ','er_theme');
						$key = wp_generate_uuid4();
						update_field('last_id_user', $last_id_userToUpdate, 'option');
						update_field('key_activation', $key, 'user_'.$user_id);
						$user_id_role = new WP_User($user_id);
						$user_id_role->set_role('registereduser');
						wp_new_user_notification( $user_id, 'user' );
						$content_reg = 'Здравствуйте! Добро пожаловать на сайт! Пожалуйста, если еще этого не сделали, заполните ваши интересы, чтобы мы могли предложить вам максимально релевантную информацию.';
						notify_user_action('system_registration',$user_id,'Добро пожаловать на сайт!',$content_reg);
						$content_email = 'Мы отправили письмо для активации на ваш адрес '.$data['email'].'. Пожалуйста, перейдите по ссылке, чтобы подтвердить ваш E-mail.';
						notify_user_action('system_activation_email',$user_id,'Подтвердите ваш E-mail',$content_email);
						wp_set_current_user ( $user_id );
						wp_set_auth_cookie  ( $user_id );
						if ($_COOKIE["_ym_uid"]) {
							$timervop = htmlspecialchars($_COOKIE["_ym_uid"]);
							update_field('client_id_yandex', $timervop, 'user_'.$user_id);
						}
						update_field('user_reg_type', 'user', 'user_'.$user_id);
					}*/
					
				}
			} else {
				$result['status']  = 'error';
				$result['message'] = __( 'E-mail не корректен', 'er_theme' );
			}
		}
		echo json_encode( $result );
		die;
	}
}

if ( ! function_exists( 'after_login_new_comment_form_submit_reg_me' ) ) {
	add_action( 'wp_ajax_after_login_new_comment_form_submit_reg_me', 'after_login_new_comment_form_submit_reg_me' );
	add_action( 'wp_ajax_nopriv_after_login_new_comment_form_submit_reg_me', 'after_login_new_comment_form_submit_reg_me' );
	function after_login_new_comment_form_submit_reg_me() {
		$data                 = $_POST;
		$last_id_user         = get_field( 'last_id_user', 'option' );
		$last_id_userToUpdate = intval( $last_id_user ) + 1;
		$login                = 'id' . $last_id_userToUpdate;
		$password             = wp_generate_password();
		if ( ! $data['name_first'] || $data['name_first'] == '' ) {
			$result['status']  = 'error';
			$result['message'] = __( 'Пожалуйста, укажите имя', 'er_theme' );
		} else {
			$userdata = array(
				'user_login'    => $login,
				'user_nicename' => $login,
				'user_pass'     => $password,
				'user_email'    => $data['email'],
				'first_name'    => $data['name_first'],
				'last_name'     => $data['name_last'],
				'display_name'  => $data['name_first'] . ' ' . $data['name_last'],
				'remember'      => true
			);
			$user_id  = wp_insert_user( $userdata );
			if ( is_wp_error( $user_id ) ) {
				$result['status']  = 'error';
				$result['message'] = $user_id->get_error_message();
			} else {
				$result['status']   = 'reg_ok';
				$result['user_id']  = $user_id;
				$result['password'] = $password;
				$result['message']  = __( 'Вы успешно зарегистрированы. Ваш пароль: ', 'er_theme' );
				$key                = wp_generate_uuid4();
				update_field( 'last_id_user', $last_id_userToUpdate, 'option' );
				update_field( 'key_activation', $key, 'user_' . $user_id );
				$user_id_role = new WP_User( $user_id );
				$user_id_role->set_role( 'registereduser' );
				wp_new_user_notification( $user_id, 'user' );
				$content_reg = 'Пожалуйста, если вы еще это не сделали, заполните ваши интересы в личном кабинете, чтобы мы предложили вам только важную информацию.';
				notify_user_action( 'system_registration', $user_id, 'Добро пожаловать на сайт!', $content_reg );
				$content_email = 'Мы отправили письмо для активации на ваш адрес ' . $data['email'] . '. Пожалуйста, перейдите по ссылке, чтобы подтвердить ваш E-mail.';
				notify_user_action( 'system_activation_email', $user_id, 'Подтвердите ваш E-mail', $content_email );
				wp_set_current_user( $user_id );
				wp_set_auth_cookie( $user_id );
				if ( $_COOKIE["_ym_uid"] ) {
					$timervop = htmlspecialchars( $_COOKIE["_ym_uid"] );
					update_field( 'client_id_yandex', $timervop, 'user_' . $user_id );
				}
				update_field( 'user_reg_type', 'user', 'user_' . $user_id );
			}
		}
		
		echo json_encode( $result );
		die;
	}
}

if ( ! function_exists( 'success_review_form' ) ) {
	add_action( 'wp_ajax_success_review_form', 'success_review_form' );
	add_action( 'wp_ajax_nopriv_success_review_form', 'success_review_form' );
	function success_review_form() {
		$data    = $_POST;
		$message = '';
		$post_id = $data['post_id'];
		$result  = array();
		if ( $data['user_id'] != 0 ) {
			$company_name     = get_field( 'company_name', $post_id );
			$term_slug        = get_term( get_field( 'company_type', $post_id ), 'companytypes' )->name;
			$term             = get_term_by( 'slug', $term_slug, 'affiliate-tags' );
			$term_human_title = get_field( 'tag_human_title', 'term_' . $term->term_id );
			$message          .= '<h1 class="text_centered">' . __( 'Ваш отзыв на компанию', 'er_theme' ) . ' ' . $company_name . ' ' . __( 'отправлен на модерацию!', 'er_theme' ) . '</h1>';
			if ( $term_human_title != '' ) {
				$message .= '<div class="text_centered">' . __( 'После модерации отзыв появится на сайте. Мы подобрали для вас лучшие бонусы категории', 'er_theme' ) . ' <span class="color_dark_blue font_bold">' . $term_human_title . '</span>.</div>';
				$message .= '<div class="text_centered m_t_20"><a href="' . get_the_permalink( $post_id ) . '" class="color_stabdart_blue">' . __( 'Перейти к обзору компании', 'er_theme' ) . ' ' . $company_name . '</a></div>';
				$message .= get_success_bonuses( $term->term_id );
			} else {
				$message .= '<div class="">' . __( 'После модерации отзыв появится на сайте. Мы подобрали для вас лучшие бонусы из различных категорий', 'er_theme' ) . '.</div>';
				$message .= '<div class="text_centered m_t_20"><a href="' . get_the_permalink( $post_id ) . '" class="color_stabdart_blue">' . __( 'Перейти к обзору компании', 'er_theme' ) . ' ' . $company_name . '</a></div>';
				$message .= get_success_bonuses( 'all' );
			}
			
			$result['status']  = 'ok';
			$result['message'] = $message;
		} else {
			$language = get_locale();
			if ( $language == 'en_US' ) {
				$text1 = 'There is only one step left!';
				$text2 = 'For a review to be published, please enter your email address and register or log in to the site.';
				$text3 = 'We will create a personal account for you, in which a lot of useful things await you: you can subscribe to company updates and keep abreast of its news, track new comments on reviews, edit your reviews and resolve issues with the company directly.';
				
			} elseif ( $language == 'de_DE' ) {
				$text1 = 'Es bleibt nur noch ein Schritt!';
				$text2 = 'Damit eine Bewertung veröffentlicht werden kann, geben Sie bitte Ihre E-Mail-Adresse ein und registrieren Sie sich oder melden Sie sich auf der Website an.';
				$text3 = 'Wir erstellen für Sie ein persönliches Konto, in dem viele nützliche Dinge auf Sie warten: Sie können Unternehmens-Updates abonnieren und über Neuigkeiten auf dem Laufenden bleiben, neue Kommentare zu Bewertungen verfolgen, Ihre Bewertungen bearbeiten und Probleme direkt mit dem Unternehmen lösen.';
			} elseif ( $language == 'es_ES' ) {
				$text1 = '¡Solo queda un paso!';
				$text2 = 'Para que se publique una reseña, ingrese su dirección de correo electrónico y regístrese o inicie sesión en el sitio.';
				$text3 = 'Crearemos una cuenta personal para usted, en la que le esperan muchas cosas útiles: puede suscribirse a las actualizaciones de la empresa y estar al tanto de sus novedades, realizar un seguimiento de los nuevos comentarios en las reseñas, editar sus reseñas y resolver problemas directamente con la empresa.';
			} elseif ( $language == 'fr_FR' ) {
				$text1 = 'Il ne reste plus qu`un pas !';
				$text2 = 'Pour qu`un avis soit publié, veuillez saisir votre adresse e-mail et vous inscrire ou vous connecter au site.';
				$text3 = 'Nous allons créer un compte personnel pour vous, dans lequel de nombreuses choses utiles vous attendent : vous pouvez vous abonner aux mises à jour de l`entreprise et vous tenir au courant de ses actualités, suivre les nouveaux commentaires sur les avis, modifier vos avis et résoudre directement les problèmes avec l`entreprise.';
			} else {
				$text1 = 'Остался всего один шаг!';
				$text2 = 'Чтобы отзыв был опубликован, пожалуйста, укажите адрес электронной почты и зарегистрируйтесь или авторизуйтесь на сайте.';
				$text3 = 'Мы создадим для вас личный кабинет, в котором вас ждет много полезного: вы можете подписаться на обновления компании и быть в курсе ее новостей, отслеживать новые комментарии к отзывам, редактировать свои отзывы и урегулировать вопросы с компанией напрямую.';
			}
			$message .= '<h1>' . $text1 . '</h1>';
			$message .= '<div class="">' . $text2 . '</div>';
			$message .= need_reg_review_form( $data['comment_id'], $post_id );
			$message .= '<div class="m_t_20">' . $text3 . '</div>';
			
			$result['status']  = 'need_reg';
			$result['message'] = $message;
		}
		echo json_encode( $result );
		die;
	}
}

if ( ! function_exists( 'need_reg_review_form' ) ) {
	function need_reg_review_form( $comment_id, $post_id ) {
		$result = '';
		//$result .= $comment_id.' / '.$post_id;
		$result   .= '<form id="after_login_new_comment_form" action="' . admin_url( 'admin-ajax.php' ) . '" method="post">';
		$result   .= '<input type="hidden" name="action" value="after_login_new_comment_form_submit" />';
		$result   .= '<input type="hidden" name="comment_id" value="' . $comment_id . '">';
		$result   .= '<input type="hidden" name="post_id" value="' . $post_id . '">';
		$language = get_locale();
		if ( $language == 'en_US' ) {
			$text1 = 'Enter Email';
			$text2 = 'Further';
		} elseif ( $language == 'de_DE' ) {
			$text1 = 'Email eingeben';
			$text2 = 'Des Weiteren';
		} elseif ( $language == 'es_ES' ) {
			$text1 = 'Ingrese correo electrónico';
			$text2 = 'Más lejos';
		} elseif ( $language == 'fr_FR' ) {
			$text1 = 'Entrez l`e-mail';
			$text2 = 'Plus loin';
		} else {
			$text1 = 'Введите E-mail';
			$text2 = 'Далее';
		}
		$result           .= '<input type="text" name="email" value="" class="m_b_20" placeholder="' . $text1 . '" />';
		$result           .= '<input class="button button_green m_b_10 pointer font_small font_bold" type="submit" value="' . $text2 . '" />';
		$result           .= '</form>';
		$current_language = get_locale();
		if ( $current_language == 'ru_RU' ) {
			$result .= '<div class="title color_dark_blue font_bold m_b_20">' . __( 'или используйте сервисы для входа', 'er_theme' ) . '</div>';
			$result .= social_login_icons( 'full' );
		}
		
		return $result;
	}
}

function get_success_bonuses( $term_id ) {
	$result = '';
	$language = get_locale();

	$args   = array(
		'post_type'   => 'casino',
		'post_status' => 'publish',
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
	);
	if ( $term_id != 'all' ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'affiliate-tags',
				'field'    => 'id',
				'terms'    => $term_id,
			),
		);
	}
	$args['posts_per_page'] = 6;
	$args['meta_query']     = array(
		'relation' => 'AND',
		array(
			'key'     => 'base_2_bonuses',
			'value'   => 0,
			'compare' => '>'
		)
	);
	$reviews                = new WP_Query( $args );
	if ( $reviews->have_posts() ) {
		while ( $reviews->have_posts() ) {
			$reviews->the_post();
			global $post;
			$show_ids[] = $post->ID;
		}
		wp_reset_postdata();
	}
	if ( ! empty( $show_ids ) ) {
		$result .= '<div class="get_bonuses_title"><span>' . __( 'Подарок за вашу лояльность', 'er_theme' ) . '</span></div>';
		$result .= '<ul class="flex top_companies_heygo top_companies_heygo_gift">';
		foreach ( $show_ids as $id ) {
			$company_name = get_field( 'company_name', $id );
			$bonus        = get_field( 'base_2_bonuses', $id )[0];
			if ( $bonus['bonus_format'] && $bonus['text'] ) {
				$bonus_title = $bonus['text'];
			} elseif ( $bonus['from'] || $bonus['to'] ) {
				$bonus_title = simple_from_to( $bonus );
				if ( $bonus['currency'] ) {
					$bonus_title .= ' ';
					$bonus_title .= term_field( $bonus['currency'], 'currencies', 'name' );
				}
			} else {
				$bonus_title = $company_name;
			}
			if ( count( $show_ids ) == 1 ) {
				$result .= '<li class="white_block border_radius_4px heygo_one_cols_item blocks_spheres_1" id="heygo_top_' . $id . '">';
			} elseif ( count( $show_ids ) == 2 ) {
				$result .= '<li class="white_block border_radius_4px heygo_two_cols_item blocks_spheres_2" id="heygo_top_' . $id . '">';
			} else {
				$result .= '<li class="white_block border_radius_4px blocks_spheres_3" id="heygo_top_' . $id . '">';
			}
			
			$result .= '<div class="block_header">';
			
			if ( function_exists( 'review_redirect_link' ) ) {
				$link = review_redirect_link( $id );
			} else {
				$link = '';
			}
			$review_link = get_the_permalink( $id );
			$result      .= '<a href="' . $review_link . '" class="review_logo" target="_blank"';
			$logo        = get_field( 'company_logo', $id );
			$logo_bg     = get_field( 'company_icon_bg', $id );
			
			if ( $logo_bg && $logo_bg != '' ) {
				$bg = ' background-color:' . $logo_bg . ';';
			} else {
				$bg = '';
			}
			
			if ( $logo && ! empty( $logo ) ) {
				$result .= ' style="background-image:url(' . $logo['sizes']['large'] . ');' . $bg . '"';
			}
			$result    .= '></a>';
			$term_slug = get_term( get_field( 'company_type', $id ), 'companytypes' )->name;
			if ( in_array( $term_slug, array( 'bloggers' ) ) ) {
				$result .= '<div class="color_dark_blue font_bold font_18">' . get_field( 'company_name', $id ) . '</div>';
			}
			//$result .= review_logo($id);
			$result  .= '<div class="color_dark_blue font_bold font_new_medium">' . $bonus_title . '</div>';
			$result  .= '</div>';
			$result  .= '<div class="block_footer">';
			$excerpt = get_the_excerpt( $id );
			if ( $excerpt && $excerpt != '' ) {
				$result .= '<div class="font_smaller color_dark_gray field_1 m_b_10">' . $bonus['comment'] . '</div>';
			}
			
			//$result .= '<div class="font_smaller color_dark_blue field_2 font_bold">Поле 2</div>';
			//$result .= '<div class="font_smaller color_dark_blue field_3 font_bold">Поле 3</div>';
			
			
			//$result .= '<div class="font_little color_dark_gray field_3">Поле 5</div>';
			$result .= '</div>';
			if ( $link != '' ) {
				if( function_exists( 'replace_ru_domain_for_lang' ) ) {
					$bonus['link'] = replace_ru_domain_for_lang( $bonus['link'], $language );
				}
				$result .= '<a href="' . $bonus['link'] . '" class="go_more pointer" target="_blank">' . __( 'Получить', 'er_theme' ) . '</a>';
			}
			$result .= '</li>';
			
		}
		$result .= '</ul>';
	}
	
	return $result;
}

if ( ! function_exists( 'after_login_new_comment_update_name_form_submit' ) ) {
	add_action( 'wp_ajax_after_login_new_comment_update_name_form_submit', 'after_login_new_comment_update_name_form_submit' );
	add_action( 'wp_ajax_nopriv_after_login_new_comment_update_name_form_submit', 'after_login_new_comment_update_name_form_submit' );
	function after_login_new_comment_update_name_form_submit() {
		$data   = $_POST;
		$result = array();
		if ( ! $data['name'] || $data['name'] == '' ) {
			$result['status']  = 'error';
			$result['message'] = __( 'Пожалуйста, укажите имя', 'er_theme' );
		} else {
			$commentarr     = [
				'comment_ID'     => $data['comment_id'],
				'comment_author' => $data['name'],
			];
			$update_comment = wp_update_comment( $commentarr, true );
			$user_id        = wp_update_user( [
				'ID'           => $data['user_id'],
				'display_name' => $data['name'],
				'first_name'   => $data['name'],
			] );
			if ( is_wp_error( $user_id ) ) {
				$result['status']  = 'error';
				$result['message'] = __( 'Возникла ошибка!', 'er_theme' );
			} else {
				$result['status']  = 'ok';
				$result['message'] = __( 'Спасибо, данные обновлены', 'er_theme' );
			}
		}
		
		echo json_encode( $result );
		die;
	}
}

if ( ! function_exists( 'attach_new_review_to_new_user_after_reg' ) ) {
	add_action( 'wp_ajax_attach_new_review_to_new_user_after_reg', 'attach_new_review_to_new_user_after_reg' );
	add_action( 'wp_ajax_nopriv_attach_new_review_to_new_user_after_reg', 'attach_new_review_to_new_user_after_reg' );
	function attach_new_review_to_new_user_after_reg() {
		$data       = $_POST;
		$comment_id = $data['comment_id'];
		$post_id    = $data['post_id'];
		$user_id    = $data['user_id'];
		$password   = $data['password'];
		$result     = '';
		//$result .= $comment_id.' / '.$post_id;
		$result       = array();
		$current_user = wp_get_current_user();
		$user_id      = $current_user->data->ID;
		$user_info    = get_userdata( $user_id );
		$commentarr   = [
			'comment_ID'           => $comment_id,
			'user_ID'              => $user_id,
			'comment_author'       => $user_info->display_name,
			'comment_author_email' => $user_info->user_email,
		];
		
		// Обновляем данные в БД
		wp_defer_comment_counting( true );
		$update_comment = wp_update_comment( $commentarr, true );
		$message        = '';
		if ( is_wp_error( $update_comment ) ) {
			$result['status']  = 'error';
			$message           .= '<h1>' . __( 'Возникла ошибка!', 'er_theme' ) . '</h1>';
			$message           .= '<div class="">' . $update_comment->get_error_message() . '</div>';
			$result['message'] = $message;
		} else {
			$company_name     = get_field( 'company_name', $post_id );
			$term_slug        = get_term( get_field( 'company_type', $post_id ), 'companytypes' )->name;
			$term             = get_term_by( 'slug', $term_slug, 'affiliate-tags' );
			$term_human_title = get_field( 'tag_human_title', 'term_' . $term->term_id );
			$message          .= '<h1 class="text_centered">' . __( 'Ваш отзыв на компанию', 'er_theme' ) . ' ' . $company_name . ' ' . __( 'отправлен на модерацию!', 'er_theme' ) . '</h1>';
			if ( $term_human_title != '' ) {
				$language = get_locale();
				if ( $language == 'en_US' ) {
					$text1 = 'After moderation the review will appear on the site. We have selected for you the best category bonuses';
				} elseif ( $language == 'de_DE' ) {
					$text1 = 'Nach der Moderation wird die Bewertung auf der Website veröffentlicht. Wir haben für Sie die besten Bonusse der Kategorie ausgewählt';
				} elseif ( $language == 'es_ES' ) {
					$text1 = 'Tras la moderación, la reseña aparecerá en el sitio web. Hemos seleccionado las mejores bonificaciones de categoría para usted';
				} elseif ( $language == 'fr_FR' ) {
					$text1 = 'Après modération, la critique apparaîtra sur le site web. Nous avons sélectionné pour vous les meilleurs bonus de catégorie';
				} else {
					$text1 = 'После модерации отзыв появится на сайте. Мы подобрали для вас лучшие бонусы категории';
				}
				$message .= '<div class="text_centered">' . $text1 . ' <span class="color_dark_blue font_bold">' . $term_human_title . '</span>.</div>';
				
				// $message .= '<form id="after_login_new_comment_form_update_name" action="'.admin_url( 'admin-ajax.php' ).'" method="post">';
				// $message .= '<div class="color_dark_blue font_bold m_b_15 m_t_20">'.__('Пожалуйста, дополните информацию о себе','er_theme').'</div>';
				//$message .= '<input type="hidden" name="action" value="after_login_new_comment_update_name_form_submit" />';
				// $message .= '<input type="hidden" name="comment_id" value="'.$comment_id.'">';
				//  $message .= '<input type="hidden" name="user_id" value="'.$user_id.'">';
				// $message .= '<input type="text" name="name" value="" class="m_b_20" placeholder="'.__('Ваше имя','er_theme').'" />';
				// $message .= '<input class="button button_green m_b_10 pointer font_small font_bold" type="submit" value="'.__('Обновить информацию','er_theme').'" />';
				// $message .= '</form>';
				if ( $language == 'en_US' ) {
					$text1 = 'Your login:';
				} elseif ( $language == 'de_DE' ) {
					$text1 = 'Dein Nutzername:';
				} elseif ( $language == 'es_ES' ) {
					$text1 = 'Su nombre de usuario:';
				} elseif ( $language == 'fr_FR' ) {
					$text1 = 'Votre nom d`utilisateur';
				} else {
					$text1 = 'Ваш логин:';
				}
				$message .= '<div class="new_auth_creds">';
				$message .= '<div class="new_auth_creds_left">';
				$message .= '<div class="new_auth_creds_title">' . $text1 . '</div>';
				$message .= '<div class="new_auth_creds_data">' . $user_info->user_email . '</div>';
				$message .= '</div>';
				$message .= '<div class="new_auth_creds_right">';
				if ( $language == 'en_US' ) {
					$text1 = 'Your password:';
				} elseif ( $language == 'de_DE' ) {
					$text1 = 'Ihr Passwort:';
				} elseif ( $language == 'es_ES' ) {
					$text1 = 'Su contraseña:';
				} elseif ( $language == 'fr_FR' ) {
					$text1 = 'Votre mot de passe:';
				} else {
					$text1 = 'Ваш пароль:';
				}
				$message .= '<div class="new_auth_creds_title">' . $text1 . '</div>';
				$message .= '<div class="new_auth_creds_data">' . $password . '</div>';
				$message .= '</div>';
				$message .= '</div>';
				if ( $language == 'en_US' ) {
					$text1 = 'We have already sent an email to you. Follow the link in it to activate your account.';
				} elseif ( $language == 'de_DE' ) {
					$text1 = 'Wir haben bereits eine E-Mail an Ihren Posteingang geschickt. Folgen Sie dem darin enthaltenen Link, um Ihr Konto zu aktivieren.';
				} elseif ( $language == 'es_ES' ) {
					$text1 = 'Ya hemos enviado un correo electrónico a su bandeja de entrada. Siga el enlace que aparece en él para activar su cuenta.';
				} elseif ( $language == 'fr_FR' ) {
					$text1 = 'Nous avons déjà envoyé un courriel à votre boîte de réception. Suivez le lien qui s`y trouve pour activer votre compte.';
				} else {
					$text1 = 'Мы уже отправили письмо на вашу почту. Перейдите по ссылке в нем, чтобы активировать аккаунт.';
				}
				$message .= '<div class="new_auth_creds_verify">' . $text1 . '</div>';
				$message .= '<div class="text_centered m_t_20"><a href="' . get_the_permalink( $post_id ) . '" class="color_stabdart_blue">' . __( 'Перейти к обзору компании', 'er_theme' ) . ' ' . $company_name . '</a></div>';
				$message .= get_success_bonuses( $term->term_id );
			} else {
				$language = get_locale();
				if ( $language == 'en_US' ) {
					$text1 = 'After moderation the review will appear on the site. We have selected for you the best category bonuses';
				} elseif ( $language == 'de_DE' ) {
					$text1 = 'Nach der Moderation wird die Bewertung auf der Website veröffentlicht. Wir haben für Sie die besten Bonusse der Kategorie ausgewählt';
				} elseif ( $language == 'es_ES' ) {
					$text1 = 'Tras la moderación, la reseña aparecerá en el sitio web. Hemos seleccionado las mejores bonificaciones de categoría para usted';
				} elseif ( $language == 'fr_FR' ) {
					$text1 = 'Après modération, la critique apparaîtra sur le site web. Nous avons sélectionné pour vous les meilleurs bonus de catégorie';
				} else {
					$text1 = 'После модерации отзыв появится на сайте. Мы подобрали для вас лучшие бонусы категории';
				}
				$message .= '<div class="">' . $text1 . '.</div>';
				
				$message .= '<div class="new_auth_creds">';
				$message .= '<div class="new_auth_creds_left">';
				if ( $language == 'en_US' ) {
					$text1 = 'Your login:';
				} elseif ( $language == 'de_DE' ) {
					$text1 = 'Dein Nutzername:';
				} elseif ( $language == 'es_ES' ) {
					$text1 = 'Su nombre de usuario:';
				} elseif ( $language == 'fr_FR' ) {
					$text1 = 'Votre nom d`utilisateur';
				} else {
					$text1 = 'Ваш логин:';
				}
				$message .= '<div class="new_auth_creds_title">' . $text1 . '</div>';
				$message .= '<div class="new_auth_creds_data">' . $user_info->user_email . '</div>';
				$message .= '</div>';
				$message .= '<div class="new_auth_creds_right">';
				if ( $language == 'en_US' ) {
					$text1 = 'Your password:';
				} elseif ( $language == 'de_DE' ) {
					$text1 = 'Ihr Passwort:';
				} elseif ( $language == 'es_ES' ) {
					$text1 = 'Su contraseña:';
				} elseif ( $language == 'fr_FR' ) {
					$text1 = 'Votre mot de passe:';
				} else {
					$text1 = 'Ваш пароль:';
				}
				$message .= '<div class="new_auth_creds_title">' . $text1 . '</div>';
				$message .= '<div class="new_auth_creds_data">' . $password . '</div>';
				$message .= '</div>';
				$message .= '</div>';
				if ( $language == 'en_US' ) {
					$text1 = 'We have already sent an email to you. Follow the link in it to activate your account.';
				} elseif ( $language == 'de_DE' ) {
					$text1 = 'Wir haben bereits eine E-Mail an Ihren Posteingang geschickt. Folgen Sie dem darin enthaltenen Link, um Ihr Konto zu aktivieren.';
				} elseif ( $language == 'es_ES' ) {
					$text1 = 'Ya hemos enviado un correo electrónico a su bandeja de entrada. Siga el enlace que aparece en él para activar su cuenta.';
				} elseif ( $language == 'fr_FR' ) {
					$text1 = 'Nous avons déjà envoyé un courriel à votre boîte de réception. Suivez le lien qui s`y trouve pour activer votre compte.';
				} else {
					$text1 = 'Мы уже отправили письмо на вашу почту. Перейдите по ссылке в нем, чтобы активировать аккаунт.';
				}
				$message .= '<div class="new_auth_creds_verify">' . $text1 . '</div>';
				$message .= '<div class="text_centered m_t_20"><a href="' . get_the_permalink( $post_id ) . '" class="color_stabdart_blue">' . __( 'Перейти к обзору компании', 'er_theme' ) . ' ' . $company_name . '</a></div>';
				$message .= get_success_bonuses( 'all' );
			}
			
			$result['status']  = 'ok';
			$result['message'] = $message;
		}
		echo json_encode( $result );
		die;
	}
}
if ( ! function_exists( 'attach_new_review_to_new_user' ) ) {
	add_action( 'wp_ajax_attach_new_review_to_new_user', 'attach_new_review_to_new_user' );
	add_action( 'wp_ajax_nopriv_attach_new_review_to_new_user', 'attach_new_review_to_new_user' );
	function attach_new_review_to_new_user() {
		$data       = $_POST;
		$comment_id = $data['comment_id'];
		$post_id    = $data['post_id'];
		$result     = '';
		//$result .= $comment_id.' / '.$post_id;
		$result       = array();
		$current_user = wp_get_current_user();
		$user_id      = $current_user->data->ID;
		$user_info    = get_userdata( $user_id );
		$commentarr   = [
			'comment_ID'           => $comment_id,
			'user_ID'              => $user_id,
			'comment_author'       => $user_info->display_name,
			'comment_author_email' => $user_info->user_email,
		];
		
		// Обновляем данные в БД
		$update_comment = wp_update_comment( $commentarr, true );
		$message        = '';
		if ( is_wp_error( $update_comment ) ) {
			$result['status']  = 'error';
			$message           .= '<h1>' . __( 'Возникла ошибка!', 'er_theme' ) . '</h1>';
			$message           .= '<div class="">' . $update_comment->get_error_message() . '</div>';
			$result['message'] = $message;
		} else {
			$company_name     = get_field( 'company_name', $post_id );
			$term_slug        = get_term( get_field( 'company_type', $post_id ), 'companytypes' )->name;
			$term             = get_term_by( 'slug', $term_slug, 'affiliate-tags' );
			$term_human_title = get_field( 'tag_human_title', 'term_' . $term->term_id );
			$message          .= '<h1 class="text_centered">' . __( 'Ваш отзыв на компанию', 'er_theme' ) . ' ' . $company_name . ' ' . __( 'отправлен на модерацию!', 'er_theme' ) . '</h1>';
			if ( $term_human_title != '' ) {
				$message .= '<div class="text_centered">' . __( 'После модерации отзыв появится на сайте. Мы подобрали для вас лучшие бонусы категории', 'er_theme' ) . ' <span class="color_dark_blue font_bold">' . $term_human_title . '</span>.</div>';
				$message .= '<div class="text_centered m_t_20"><a href="' . get_the_permalink( $post_id ) . '" class="color_stabdart_blue">' . __( 'Перейти к обзору компании', 'er_theme' ) . ' ' . $company_name . '</a></div>';
				$message .= get_success_bonuses( $term->term_id );
			} else {
				$message .= '<div class="text_centered">' . __( 'После модерации отзыв появится на сайте. Мы подобрали для вас лучшие бонусы из различных категорий', 'er_theme' ) . '.</div>';
				$message .= '<div class="text_centered m_t_20"><a href="' . get_the_permalink( $post_id ) . '" class="color_stabdart_blue">' . __( 'Перейти к обзору компании', 'er_theme' ) . ' ' . $company_name . '</a></div>';
				$message .= get_success_bonuses( 'all' );
			}
			
			$result['status']  = 'ok';
			$result['message'] = $message;
		}
		echo json_encode( $result );
		die;
	}
}
if ( ! function_exists( 'check_login_for_services' ) ) {
	add_action( 'wp_ajax_check_login_for_services', 'check_login_for_services' );
	add_action( 'wp_ajax_nopriv_check_login_for_services', 'check_login_for_services' );
	function check_login_for_services() {
		if ( is_user_logged_in() ) {
			echo 'yes';
		} else {
			echo 'no';
		}
		die;
	}
}
//рабочий new_submit_review_newform_preview
if ( ! function_exists( 'new_submit_review_newform_preview' ) ) {
	add_action( 'wp_ajax_new_submit_review_newform_preview', 'new_submit_review_newform_preview' );
	add_action( 'wp_ajax_nopriv_new_submit_review_newform_preview', 'new_submit_review_newform_preview' );
	function new_submit_review_newform_preview() {
		$data = $_POST;
		//	print_r($data);
		$review_year          = $data['review_year'];
		$review_pluses        = $data['review_pluses'];
		$review_minuses       = $data['review_minuses'];
		$review_title         = $data['review_title'];
		$files_doc            = $data['files_doc'];
		$comment_text         = $data['comment_text'];
		$recomend_for_friends = $data['recomend_for_friends'];
		$rating               = $data['rating'];
		$post_id              = $data['post_id'];
		$form_type = $data['form_type'];
		if ( ! is_user_logged_in() ) {
			$user_id = 'none';
		} else {
			$current_user = wp_get_current_user();
			$user_id      = $current_user->data->ID;
			
		}
		$errors = array();
		$result = '';
		if ( ! $rating || empty( $rating ) || count( $rating ) < 4 ) {
			$errors[] = __( 'Оцените компанию по критериям', 'er_theme' );
		}
		if ( ! $recomend_for_friends || $recomend_for_friends == '' ) {
			$errors[] = __( 'Укажите, порекомендуете ли вы компанию друзьям', 'er_theme' );
		}
		if ( ! $review_title || $review_title == '' ) {
			$errors[] = __( 'Укажите заголовок отзыва', 'er_theme' );
		}
		if ( ! $comment_text || $comment_text == '' ) {
			$errors[] = __( 'Укажите текст отзыва', 'er_theme' );
		}
		
		
		if ( ! empty( $errors ) ) {
			$result .= '<div class="font_smaller m_b_20 color_red reg_error">';
			$result .= '<ul>';
			foreach ( $errors as $error ) {
				$result .= '<li>' . $error . '</li>';
			}
			$result .= '</ul>';
			$result .= '</div>';
		} else {
			if ( ! empty( $rating ) ) {
				foreach ( $rating as $item ) {
					$total_rating[] = $item;
				}
				$rating_total_value  = array_sum( $total_rating );
				$rating_count        = count( $total_rating );
				$rating_total_result = $rating_total_value / $rating_count;
			}
			$result .= '<div class="white_block flex flex_column previe23">';
			if ( $user_id != 'none' ) {
				$user_name     = $current_user->data->display_name;
				$attachment_id = get_field( 'photo_profile', 'user_' . $user_id );
				if ( $attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '' ) {
					$avatar_url = 'style="background-image: url(' . $attachment_id['sizes']['thumbnail'] . ')"';
				} else {
					$avatar_url = '';
				}
			} else {
				$language = get_locale();
				if ( $language == 'fr_FR' ) {
					$text_a_user = 'Utilisateur anonyme';
				} elseif ( $language == 'es_ES' ) {
					$text_a_user = 'Usuario anónimo';
				} elseif ( $language == 'de_DE' ) {
					$text_a_user = 'Anonymer Nutzer';
				} elseif ( $language == 'en_US' ) {
					$text_a_user = 'Anonymous user';
				} else {
					$text_a_user = 'Анонимный пользователь';
				}
				$user_name  = $text_a_user;
				$avatar_url = '';
			}
			if ( ! empty( $files_doc ) ) {
				$status = 'set_status_good';
				$li_status = 'li_statusgood';
				$text_status = 'Достоверный отзыв';
			} elseif ( mb_strlen( $comment_text ) >= 149 ) {
				$status = 'set_status_normal';
				$li_status = 'li_statusnormal';
				$text_status = 'Отзыв одобрен к публикации';
			} else {
				$status = 'set_status_bad';
				$li_status = 'li_statusbad';
				$text_status = 'Недостоверный отзыв';
			}
			if ($form_type != 'new') {
				$status = '';
				$li_status = '';
				$text_status = '';
			}
			$result .= '<div data-v="" class="comment_header flex '.$li_status.'">';
			$result .= '<div class="comment_avatar pointer" ' . $avatar_url . '></div>';
			$result .= '<div class="comment_meta">';
			$result .= '<span class="comment-author">' . $user_name;
			if ($form_type == 'new') {
				$result .= '<span class="status_main">Статус <span class="set_status '.$status.'"><span class="status_comment_a"><span>'.$text_status.'</span></span></span></span>';
			}
			$result .= '</span>';
			if ( mb_strlen( $comment_text ) > 149 ) {
				$svg_color = '#FE8312';
			} else {
				$svg_color = '#FC1010';
			}
			$result .= '<span class="comment-date">' . date_i18n( 'j F Y в H:i' ) . '</span>';
			$result .= '</div>';
			if ( $rating_total_result > 0 ) {
				$result .= '<div class="comment_total_rating">';
				$result .= $rating_total_result;
				$result .= '</div>';
			}
			$result .= '</div>';
			
			if ( ! empty( $rating ) ) {
				$result .= '<div class="comment_rating_details">';
				if ( $post_id == 0 ) {
					$rating_fields_group = 87485;
				} elseif ( get_post_type( $post_id ) == 'casino' ) {
					$rating_fields_group = get_rating_fields_group( $post_id );
				}
				$ratings   = get_comment_rating_fields( $rating_fields_group, 'key' );
				$row_index = 0;
				foreach ( $ratings as $item ) {
					
					
					$row_index ++;
					$rating_value = $rating[ $item['field_name'] ] * 10 * 2;
					if ( $rating_value >= 70 ) {
						$rating_color = 'green';
					} elseif ( $rating_value >= 40 && $rating_value < 70 ) {
						$rating_color = 'orange';
					} elseif ( $rating_value < 40 ) {
						$rating_color = 'red';
					}
					if ( $row_index % 2 == 0 ) {
						$oddeven = 'even';
					} else {
						$oddeven = 'odd';
					}
					$result .= '<div class="rating_row ' . $oddeven . '">';
					$result .= '<div class="row_title color_dark_gray font_smaller">' . $item['field_label'] . '</div>';
					$result .= '<div class="ratings">';
					$result .= '<div class="rating_field ' . $rating_color . '"><div class="rating_value" style="width:' . $rating_value . '%"></div></div>';
					$result .= '<span class="number color_dark_gray font_smaller">' . round( $rating_value, 0 ) . '%</span>';
					$result .= '</div>';
					$result .= '</div>';
				}
				$result .= '</div>';
			}
			
			$result .= '<div class="comment-body">';
			$result .= '<div class="review_title">' . $review_title . '</div>';
			$result .= '<div class="review_text">' . $comment_text . '</div>';
			if ( array_filter( $review_pluses ) || array_filter( $review_minuses ) ) {
				$result .= '<div class="review_pluses_minuses flex flex_wrap m_t_15">';
				
				if ( array_filter( $review_pluses ) ) {
					$result .= '<div class="review_pluses_minuses_left">';
					$result .= '<div class="plus_minus_title font_small color_dark_gray">' . __( 'Плюсы', 'er_theme' ) . '</div>';
					$result .= '<ul class="pluses">';
					foreach ( $review_pluses as $item ) {
						if ( $item != '' ) {
							$result .= '<li>' . $item . '</li>';
						}
						
					}
					$result .= '</ul>';
					$result .= '</div>';
				}
				if ( array_filter( $review_minuses ) ) {
					$result .= '<div class="review_pluses_minuses_right">';
					$result .= '<div class="plus_minus_title font_small color_dark_gray">' . __( 'Минусы', 'er_theme' ) . '</div>';
					$result .= '<ul class="minuses">';
					foreach ( $review_minuses as $item ) {
						if ( $item != '' ) {
							$result .= '<li>' . $item . '</li>';
						}
					}
					$result .= '</ul>';
					$result .= '</div>';
				}
				$result .= '</div>';
			}
			$result .= '</div>';
			
			$result .= '<div class="comment_footer flex">';
			if ( $recomend_for_friends && $recomend_for_friends != '' ) {
				if ( $recomend_for_friends == 'yes' ) {
					$recomend_for_friends_value = __( 'Да', 'er_theme' );
				} elseif ( $recomend_for_friends == 'no' ) {
					$recomend_for_friends_value = __( 'Нет', 'er_theme' );
				}
				$result .= '<div class="recomend_for_friends">';
				$result .= '<span class="recomend_for_friends_title">' . __( 'Рекомендую:', 'er_theme' ) . ' </span>';
				$result .= '<span class="recomend_for_friends_value">' . $recomend_for_friends_value . '</span>';
				$result .= '</div>';
			}
			if ( $review_year && $review_year != '' ) {
				$result .= '<div class="review_year">';
				$result .= '<span class="review_year_title">' . __( 'Год использования:', 'er_theme' ) . ' </span>';
				$result .= '<span class="review_year_value">' . $review_year . '</span>';
				$result .= '</div>';
			}
			$result .= '</div>';
			$result .= '</div>';
		}
		
		
		echo $result;
		die;
	}
}

if ( ! function_exists( 'new_submit_review_newform2' ) ) {
	add_action( 'wp_ajax_new_submit_review_newform2', 'new_submit_review_newform2' );
	add_action( 'wp_ajax_nopriv_new_submit_review_newform2', 'new_submit_review_newform2' );
	function new_submit_review_newform2() {
		$data                 = $_POST;
		$files                = $data['files'];
		$pluses               = $data['review_pluses'];
		$minuses              = $data['review_minuses'];
		$review_year          = $data['review_year'];
		$review_title         = $data['review_title'];
		$recomend_for_friends = $data['recomend_for_friends'];
		//print_r($data);
		if ( ! is_user_logged_in() ) {
			$user_id = 'none';
		} else {
			$current_user = wp_get_current_user();
			$user_id      = $current_user->data->ID;
			
		}
		//echo $user_id;
		if ( $data['post_id'] == 0 && $data['new_name'] != '' ) {
			$new_post_data = array(
				'post_title'   => sanitize_text_field( $data['new_name'] ),
				'post_content' => '',
				'post_status'  => 'draft',
				'post_author'  => 1,
				'post_type'    => 'casino'
			);
			
			// Вставляем запись в базу данных
			$new_post_id = wp_insert_post( $new_post_data, true );
			if ( is_wp_error( $new_post_id ) ) {
				$result['status']  = 'error';
				$result['message'] = $new_post_id->get_error_message();
			} else {
				update_field( 'company_name', sanitize_text_field( $data['new_name'] ), $new_post_id );
				$post_id_comment = $new_post_id;
			}
		} else {
			$post_id_comment = $data['post_id'];
		}
		if ( $user_id == 'none' ) {
			$commentdata = array(
				'comment_post_ID' => $post_id_comment,
				'comment_content' => htmlspecialchars( $data['comment_text'] ),
				//'comment_author'       => $user_info->display_name,
				//'comment_author_email' => $user_info->user_email,
				'comment_type'    => 'comment',
				'user_ID'         => 0,
			);
		} else {
			$user_info   = get_userdata( $user_id );
			$commentdata = array(
				'comment_post_ID'      => $post_id_comment,
				'comment_content'      => htmlspecialchars( $data['comment_text'] ),
				'comment_author'       => $user_info->display_name,
				'comment_author_email' => $user_info->user_email,
				'comment_type'         => 'comment',
				'user_ID'              => $user_id,
			);
		}
		$rating = $data['rating'];
		$result = array();
		$errors = array();
		if ( ! $rating || empty( $rating ) || count( $rating ) < 4 ) {
			$errors[] = __( 'Оцените компанию по критериям', 'er_theme' );
		}
		if ( ! $recomend_for_friends || $recomend_for_friends == '' ) {
			$errors[] = __( 'Укажите, порекомендуете ли вы компанию друзьям', 'er_theme' );
		}
		if ( ! $review_title || $review_title == '' ) {
			$errors[] = __( 'Укажите заголовок отзыва', 'er_theme' );
		}
		
		if ( ! $commentdata['comment_content'] || $commentdata['comment_content'] == '' ) {
			$errors[] = __( 'Укажите текст отзыва', 'er_theme' );
		} /*elseif(strlen(preg_replace('/\s+/', '', $commentdata['comment_content'])) < 10 ) {
            $errors[] = __('Напишите в отзыве более 100 символов','er_theme');
        }*/
		
		
		if ( ! empty( $errors ) ) {
			$result['status']  = 'error';
			$result['message'] = '<ul>';
			foreach ( $errors as $error ) {
				$result['message'] .= '<li>' . $error . '</li>';
			}
			$result['message'] .= '</ul>';
		}
		echo json_encode( $result );
		die;
	}
}
// Рабочая отправка
if ( ! function_exists( 'new_submit_review_newform' ) ) {
	add_action( 'wp_ajax_new_submit_review_newform', 'new_submit_review_newform' );
	add_action( 'wp_ajax_nopriv_new_submit_review_newform', 'new_submit_review_newform' );
	function new_submit_review_newform() {
		$data                 = $_POST;
		$files                = $data['files'];
		$files_doc            = $data['files_doc'];
		$pluses               = $data['review_pluses'];
		$minuses              = $data['review_minuses'];
		$review_year          = $data['review_year'];
		$review_title         = $data['review_title'];
		$pubhidefiles         = $data['pubhidefiles'];
		$recomend_for_friends = $data['recomend_for_friends'];
		$form_type = $data['form_type'];
		//print_r($data);
		if ( ! is_user_logged_in() ) {
			$user_id = 'none';
		} else {
			$current_user = wp_get_current_user();
			$user_id      = $current_user->data->ID;
			
		}
		//echo $user_id;
		if ( $data['post_id'] == 0 && $data['new_name'] != '' ) {
			$new_post_data = array(
				'post_title'   => sanitize_text_field( $data['new_name'] ),
				'post_content' => '',
				'post_status'  => 'draft',
				'post_author'  => 1,
				'post_type'    => 'casino'
			);
			
			// Вставляем запись в базу данных
			$new_post_id = wp_insert_post( $new_post_data, true );
			if ( is_wp_error( $new_post_id ) ) {
				$result['status']  = 'error';
				$result['message'] = $new_post_id->get_error_message();
			} else {
				update_field( 'company_name', sanitize_text_field( $data['new_name'] ), $new_post_id );
				$post_id_comment = $new_post_id;
			}
		} else {
			$post_id_comment = $data['post_id'];
		}
		if ( $user_id == 'none' ) {
			$commentdata = array(
				'comment_post_ID' => $post_id_comment,
				'comment_content' => htmlspecialchars( $data['comment_text'] ),
				//'comment_author'       => $user_info->display_name,
				//'comment_author_email' => $user_info->user_email,
				'comment_type'    => 'comment',
				'user_ID'         => 0,
			);
		} else {
			$user_info   = get_userdata( $user_id );
			$commentdata = array(
				'comment_post_ID'      => $post_id_comment,
				'comment_content'      => htmlspecialchars( $data['comment_text'] ),
				'comment_author'       => $user_info->display_name,
				'comment_author_email' => $user_info->user_email,
				'comment_type'         => 'comment',
				'user_ID'              => $user_id,
			);
		}
		$rating = $data['rating'];
		$result = array();
		$errors = array();
		if ( ! $rating || empty( $rating ) || count( $rating ) < 4 ) {
			$errors[] = __( 'Оцените компанию по критериям', 'er_theme' );
		}
		if ( ! $recomend_for_friends || $recomend_for_friends == '' ) {
			$errors[] = __( 'Укажите, порекомендуете ли вы компанию друзьям', 'er_theme' );
		}
		if ( ! $review_title || $review_title == '' ) {
			$errors[] = __( 'Укажите заголовок отзыва', 'er_theme' );
		}
		
		if ( ! $commentdata['comment_content'] || $commentdata['comment_content'] == '' ) {
			$errors[] = __( 'Укажите текст отзыва', 'er_theme' );
		} /*elseif(strlen(preg_replace('/\s+/', '', $commentdata['comment_content'])) < 10 ) {
            $errors[] = __('Напишите в отзыве более 100 символов','er_theme');
        }*/
		
		// По умолчанию для всех ревью не апрувим
		$commentdata['comment_approved'] = 0;
		
		if ( ! empty( $errors ) ) {
			$result['status']  = 'error';
			$result['message'] = '<ul>';
			foreach ( $errors as $error ) {
				$result['message'] .= '<li>' . $error . '</li>';
			}
			$result['message'] .= '</ul>';
		} else {
			$new_comment = wp_new_comment_test( $commentdata, true );//тут весь движ
			if ( is_wp_error( $new_comment ) ) {
				$result['status']  = 'error';
				$result['message'] = $new_comment->get_error_message();
				
			} else {
				$current_language = get_locale();
				update_field( 'language_original', $current_language, 'comment_' . $new_comment );
				
				//Выключаем повторное выключение апрува
				// wp_set_comment_status( $new_comment, 0 );
				
				//echo 'new comment id: '.$new_comment;
				$result['status']     = 'ok';
				$result['user_id']    = $user_id;
				$result['comment_id'] = $new_comment;
				$result['post_id']    = $post_id_comment;
				$result['test']       = $commentdata;
				if ( $new_comment && ! empty( $data['rating'] ) && $data['comment_text'] ) {
					foreach ( $data['rating'] as $key => $value ) {
						update_field( $key, $value, 'comment_' . $new_comment );
					}
				}
				update_field( 'field_5fce35905450b', 0, 'comment_' . $new_comment );
				if ( ! empty( $pluses ) ) {
					foreach ( $pluses as $plus ) {
						if ( $plus != '' ) {
							$row = array(
								'text' => $plus
							);
							add_row( 'review_pluses', $row, 'comment_' . $new_comment );
						}
						
					}
				}
				if ( ! empty( $minuses ) ) {
					foreach ( $minuses as $minus ) {
						if ( $minus != '' ) {
							$row = array(
								'text' => $minus
							);
							add_row( 'review_minuses', $row, 'comment_' . $new_comment );
						}
					}
				}
				if ( $recomend_for_friends == 'yes' ) {
					update_field( 'review_recommend_friends', 'yes', 'comment_' . $new_comment );
				} elseif ( $recomend_for_friends == 'no' ) {
					update_field( 'review_recommend_friends', 'no', 'comment_' . $new_comment );
				}
				if ( $review_year != '' ) {
					update_field( 'review_year', $review_year, 'comment_' . $new_comment );
				}
				if ( $pubhidefiles != '' ) {
					update_field( 'watch_files', $pubhidefiles, 'comment_' . $new_comment );
				}
				if ( $review_title != '' ) {
					update_field( 'review_title', $review_title, 'comment_' . $new_comment );
				}
				if ( $data["ym_uid"] ) {
					
					update_field( 'client_id_yandex', $data["ym_uid"], 'comment_' . $new_comment );
				}
				if ( ! empty( $files ) ) {
					foreach ( $files as $file ) {
						if ( array_key_exists( $file, $links ) ) {
							
							$row = array(
								'file_type' => 'url',
								'file'      => $file,
								'link'      => $links[ $file ]
							);
						} else {
							$row = array(
								'file_type' => 'image',
								'file'      => $file
							);
						}
						//print_r($row);
						add_row( 'comment_files', $row, 'comment_' . $new_comment );
					}
				}
				//Обновление данных обзора
				if ($form_type == 'new') {
					if ( ! empty( $files_doc ) ) {
						update_field('status_comment','good','comment_'.$new_comment);
					} elseif ( mb_strlen( $data['comment_text'] ) >= 149 ) {
						update_field('status_comment','normal','comment_'.$new_comment);
					} else {
						update_field('status_comment','bad','comment_'.$new_comment);
					}
				}
				
				
				if ( ! empty( $files_doc ) ) {
					foreach ( $files_doc as $file ) {
						if ( array_key_exists( $file, $links ) ) {
							
							$row = array(
								'file_type' => 'url',
								'file'      => $file,
								'link'      => $links[ $file ]
							);
						} else {
							$row = array(
								'file_type' => 'image',
								'file'      => $file
							);
						}
						//print_r($row);
						add_row( 'comment_files_2', $row, 'comment_' . $new_comment );
					}
				}
			}
		}
		
		echo json_encode( $result );
		die;
	}
}


if ( ! function_exists( 'new_submit_review_newform2' ) ) {
	add_action( 'wp_ajax_new_submit_review_newform2', 'new_submit_review_newform2' );
	add_action( 'wp_ajax_nopriv_new_submit_review_newform2', 'new_submit_review_newform2' );
	function new_submit_review_newform2() {
		$data                 = $_POST;
		$files                = $data['files'];
		$files_doc            = $data['files_doc'];
		$pluses               = $data['review_pluses'];
		$minuses              = $data['review_minuses'];
		$review_year          = $data['review_year'];
		$review_title         = $data['review_title'];
		$pubhidefiles         = $data['pubhidefiles'];
		$recomend_for_friends = $data['recomend_for_friends'];
		//print_r($data);
		if ( ! is_user_logged_in() ) {
			$user_id = 'none';
		} else {
			$current_user = wp_get_current_user();
			$user_id      = $current_user->data->ID;
			
		}
		//echo $user_id;
		if ( $data['post_id'] == 0 && $data['new_name'] != '' ) {
			$new_post_data = array(
				'post_title'   => sanitize_text_field( $data['new_name'] ),
				'post_content' => '',
				'post_status'  => 'draft',
				'post_author'  => 1,
				'post_type'    => 'casino'
			);
			
			// Вставляем запись в базу данных
			$new_post_id = wp_insert_post( $new_post_data, true );
			if ( is_wp_error( $new_post_id ) ) {
				$result['status']  = 'error';
				$result['message'] = $new_post_id->get_error_message();
			} else {
				update_field( 'company_name', sanitize_text_field( $data['new_name'] ), $new_post_id );
				$post_id_comment = $new_post_id;
			}
		} else {
			$post_id_comment = $data['post_id'];
		}
		if ( $user_id == 'none' ) {
			$commentdata = array(
				'comment_post_ID' => $post_id_comment,
				'comment_content' => htmlspecialchars( $data['comment_text'] ),
				//'comment_author'       => $user_info->display_name,
				//'comment_author_email' => $user_info->user_email,
				'comment_type'    => 'comment',
				'user_ID'         => 0,
			);
		} else {
			$user_info   = get_userdata( $user_id );
			$commentdata = array(
				'comment_post_ID'      => $post_id_comment,
				'comment_content'      => htmlspecialchars( $data['comment_text'] ),
				'comment_author'       => $user_info->display_name,
				'comment_author_email' => $user_info->user_email,
				'comment_type'         => 'comment',
				'user_ID'              => $user_id,
			);
		}
		$rating = $data['rating'];
		$result = array();
		$errors = array();
		if ( ! $rating || empty( $rating ) || count( $rating ) < 4 ) {
			$errors[] = __( 'Оцените компанию по критериям', 'er_theme' );
		}
		if ( ! $recomend_for_friends || $recomend_for_friends == '' ) {
			$errors[] = __( 'Укажите, порекомендуете ли вы компанию друзьям', 'er_theme' );
		}
		if ( ! $review_title || $review_title == '' ) {
			$errors[] = __( 'Укажите заголовок отзыва', 'er_theme' );
		}
		
		if ( ! $commentdata['comment_content'] || $commentdata['comment_content'] == '' ) {
			$errors[] = __( 'Укажите текст отзыва', 'er_theme' );
		} /*elseif(strlen(preg_replace('/\s+/', '', $commentdata['comment_content'])) < 10 ) {
            $errors[] = __('Напишите в отзыве более 100 символов','er_theme');
        }*/
		
		// По умолчанию для всех ревью не апрувим
		$commentdata['comment_approved'] = 0;
		
		if ( ! empty( $errors ) ) {
			$result['status']  = 'error';
			$result['message'] = '<ul>';
			foreach ( $errors as $error ) {
				$result['message'] .= '<li>' . $error . '</li>';
			}
			$result['message'] .= '</ul>';
		} else {
			$new_comment = wp_new_comment_test( $commentdata, true );//тут весь движ
			if ( is_wp_error( $new_comment ) ) {
				$result['status']  = 'error';
				$result['message'] = $new_comment->get_error_message();
				
			} else {
				$current_language = get_locale();
				update_field( 'language_original', $current_language, 'comment_' . $new_comment );
				
				//Выключаем повторное выключение апрува
				// wp_set_comment_status( $new_comment, 0 );
				
				//echo 'new comment id: '.$new_comment;
				$result['status']     = 'ok';
				$result['user_id']    = $user_id;
				$result['comment_id'] = $new_comment;
				$result['post_id']    = $post_id_comment;
				$result['test']       = $commentdata;
				if ( $new_comment && ! empty( $data['rating'] ) && $data['comment_text'] ) {
					foreach ( $data['rating'] as $key => $value ) {
						update_field( $key, $value, 'comment_' . $new_comment );
					}
				}
				update_field( 'field_5fce35905450b', 0, 'comment_' . $new_comment );
				if ( ! empty( $pluses ) ) {
					foreach ( $pluses as $plus ) {
						if ( $plus != '' ) {
							$row = array(
								'text' => $plus
							);
							add_row( 'review_pluses', $row, 'comment_' . $new_comment );
						}
						
					}
				}
				if ( ! empty( $minuses ) ) {
					foreach ( $minuses as $minus ) {
						if ( $minus != '' ) {
							$row = array(
								'text' => $minus
							);
							add_row( 'review_minuses', $row, 'comment_' . $new_comment );
						}
					}
				}
				if ( $recomend_for_friends == 'yes' ) {
					update_field( 'review_recommend_friends', 'yes', 'comment_' . $new_comment );
				} elseif ( $recomend_for_friends == 'no' ) {
					update_field( 'review_recommend_friends', 'no', 'comment_' . $new_comment );
				}
				if ( $review_year != '' ) {
					update_field( 'review_year', $review_year, 'comment_' . $new_comment );
				}
				if ( $pubhidefiles != '' ) {
					update_field( 'watch_files', $pubhidefiles, 'comment_' . $new_comment );
				}
				if ( $review_title != '' ) {
					update_field( 'review_title', $review_title, 'comment_' . $new_comment );
				}
				if ( $data["ym_uid"] ) {
					
					update_field( 'client_id_yandex', $data["ym_uid"], 'comment_' . $new_comment );
				}
				if ( ! empty( $files ) ) {
					foreach ( $files as $file ) {
						if ( array_key_exists( $file, $links ) ) {
							
							$row = array(
								'file_type' => 'url',
								'file'      => $file,
								'link'      => $links[ $file ]
							);
						} else {
							$row = array(
								'file_type' => 'image',
								'file'      => $file
							);
						}
						//print_r($row);
						add_row( 'comment_files', $row, 'comment_' . $new_comment );
					}
				}
				//Обновление данных обзора
				if ( ! empty( $files_doc ) ) {
					update_field('status_comment','good','comment_'.$new_comment);
				} elseif ( mb_strlen( $data['comment_text'] ) >= 149 ) {
					update_field('status_comment','normal','comment_'.$new_comment);
				} else {
					update_field('status_comment','bad','comment_'.$new_comment);
				}
				
				if ( ! empty( $files_doc ) ) {
					foreach ( $files_doc as $file ) {
						if ( array_key_exists( $file, $links ) ) {
							
							$row = array(
								'file_type' => 'url',
								'file'      => $file,
								'link'      => $links[ $file ]
							);
						} else {
							$row = array(
								'file_type' => 'image',
								'file'      => $file
							);
						}
						//print_r($row);
						add_row( 'comment_files_2', $row, 'comment_' . $new_comment );
					}
				}
			}
		}
		
		echo json_encode( $result );
		die;
	}
}

function myplugin_comment_columns( $columns ) {
	$columns['my_custom_column'] = __( 'Дополнительная информация', 'er_theme' );
	
	return $columns;
}

add_filter( 'manage_edit-comments_columns', 'myplugin_comment_columns' );

function myplugin_comment_column( $column, $comment_ID ) {
	if ( 'my_custom_column' == $column ) {
		$result         = '';
		$comment        = get_comment( $comment_ID );
		$is_abuse       = get_field( 'is_abuse', 'comment_' . $comment_ID );
		$comment_type   = get_field( 'comment_type', 'comment_' . $comment_ID );
		$recommend      = get_field( 'review_recommend_friends', 'comment_' . $comment_ID );
		$review_pluses  = get_field( 'review_pluses', 'comment_' . $comment_ID );
		$review_minuses = get_field( 'review_minuses', 'comment_' . $comment_ID );
		$review_year    = get_field( 'review_year', 'comment_' . $comment_ID );
		$review_title   = get_field( 'review_title', 'comment_' . $comment_ID );
		if ( $review_title && $review_title != '' ) {
			$review_title = $review_title;
		} else {
			$review_title = wp_trim_words( $comment->comment_content, 7 );
		}
		$rating_service   = get_field( 'rating_service', 'comment_' . $comment_ID );
		$rating_team      = get_field( 'rating_team', 'comment_' . $comment_ID );
		$rating_quality   = get_field( 'rating_quality', 'comment_' . $comment_ID );
		$rating_price     = get_field( 'rating_price', 'comment_' . $comment_ID );
		$client_id_yandex = get_field( 'client_id_yandex', 'comment_' . $comment_ID );
		if ( $rating_service && $rating_team && $rating_quality && $rating_price ) {
			$total_rating = ( $rating_service + $rating_team + $rating_quality + $rating_price ) / 4;
		} else {
			$total_rating = '';
		}
		$result .= '<div class="change_post_ID"><span class="change" parent_id="'.$comment->comment_post_ID.'" comment_id="'.$comment_ID.'" >Изменить?</span></div>';
		if ( $is_abuse ) {
			$result .= '<div class="font_smaller color_dark_gray">' . __( 'ЖАЛОБА', 'er_theme' ) . '</div>';
		} elseif ( $comment_type == 'comment' ) {
			$result .= '<div class="font_smaller color_dark_gray">' . __( 'КОММЕНТАРИЙ/ОТВЕТ', 'er_theme' ) . '</div>';
		} elseif ( $comment_type == 'reviews' ) {
			$result .= '<div class="font_smaller color_dark_gray">' . __( 'ОТЗЫВ', 'er_theme' ) . '</div>';
		}
		
		if ( $comment_type != 'comment' ) {
			if ( $review_title != '' && $comment_type != 'abuses' ) {
				if ( get_post_status( $comment->comment_post_ID ) == 'publish' ) {
					$result .= '<a class="font_bolder" href="' . get_the_permalink( $comment->comment_post_ID ) . 'comment-' . $comment_ID . '/" target="_blank">' . $review_title . '</a>';
				} else {
					$result .= '<a class="font_bolder" href="' . get_the_permalink( $comment->comment_post_ID ) . 'comment-' . $comment_ID . '/" target="_blank">' . $review_title . '<span style="background:#d63637;color:#fff;padding:3px 10px;display:inline-block;border-radius:4px;margin-bottom:5px;font-weight:400">Обзор не опубликован!</span></a>';
				}
				
			}
			if ( $total_rating != '' ) {
				$result .= '<div class="font_bolder">' . __( 'Оценка', 'er_theme' ) . ': ' . $total_rating . '</div>';
			}
			if ( $recommend == 'yes' ) {
				$result .= '<div>' . __( 'Рекомендую друзьям', 'er_theme' ) . ': <span class="font_bolder color_green">' . __( 'Да', 'er_theme' ) . '</span></div>';
			} elseif ( $recommend == 'no' ) {
				$result .= '<div>' . __( 'Рекомендую друзьям', 'er_theme' ) . ': <span class="font_bolder color_red">' . __( 'Нет', 'er_theme' ) . '</span></div>';
			}
			if ( $review_year != '' ) {
				$result .= '<div>' . __( 'Год использования', 'er_theme' ) . ': <span class="font_bolder">' . $review_year . '</span></div>';
			}
			if ( ! empty( $review_pluses ) ) {
				$result .= '<div class="font_bolder">' . __( 'Плюсы:', 'er_theme' ) . '</div>';
				$result .= '<ul>';
				foreach ( $review_pluses as $item ) {
					$result .= '<li>+ ' . $item['text'] . '</li>';
				}
				$result .= '</ul>';
			}
			if ( ! empty( $review_minuses ) ) {
				$result .= '<div class="font_bolder">' . __( 'Минусы:', 'er_theme' ) . '</div>';
				$result .= '<ul>';
				foreach ( $review_minuses as $item ) {
					$result .= '<li>- ' . $item['text'] . '</li>';
				}
				$result .= '</ul>';
			}
			$company_name = get_field( 'company_name', $comment->comment_post_ID );
			/*if($review_title && $review_title != '') {
                $comm_rev_title = $review_title.' - '.__('отзыв о','er_theme').' '.$company_name;
            } else {
                $comm_rev_title = wp_trim_words($comment->comment_content, 5).' - '.__('отзыв о','er_theme').' '.$company_name;
            }*/
			
			if ( $review_title && $review_title != '' ) {
				$r_tit = $review_title;
			} else {
				$r_tit = wp_trim_words( $comment->comment_content, 5, '' );
			}
			$r_last = substr( $r_tit, - 1 );
			if ( in_array( $r_last, array( ',', '!', '?', '...', '.' ) ) ) {
				$r_tit = substr( $r_tit, 0, - 1 );
			}
			$comm_rev_title = $r_tit . ' - ' . __( 'отзыв о', 'er_theme' ) . ' ' . $company_name;
			
			
			if ( $comment->user_id && $comment->user_id != 0 ) {
				$comment_author = get_userdata( $comment->user_id );
				$author_name    = '';
				if ( $comment_author->first_name && ! $comment_author->last_name ) {
					$author_name .= $comment_author->first_name;
				} elseif ( ! $comment_author->first_name && $comment_author->last_name ) {
					$author_name .= $comment_author->last_name;
				} elseif ( $comment_author->first_name && $comment_author->last_name ) {
					$author_name .= $comment_author->first_name . ' ' . $comment_author->last_name;
				} else {
					$author_name .= $comment_author->user_nicename;
				}
			} else {
				$author_name = __( 'анонимный пользователь', 'er_theme' ) . ' ';
			}
			$descr = '';
			$descr .= get_comment_date( 'j F Y', $comment->comment_ID ) . ', ';
			
			$descr .= __( 'отзыв о компании', 'er_theme' ) . ' ';
			$descr .= $company_name;
			$descr .= ' ' . __( 'написал пользователь', 'er_theme' ) . ' ';
			$descr .= $author_name . ': ';
			/*if(array_filter($review_pluses)) {
                $descr .= __('плюсы: ','er_theme');
                $count_pluses = count($review_pluses);
                $review_pluses_x = 0;
                foreach ($review_pluses as $item) {
                    $review_pluses_x++;
                    if($item != '') {
                        $descr .= $item['text'];
                        if($review_pluses_x == $count_pluses) {
                            $descr .= '; ';
                        } else {
                            $descr .= ', ';
                        }
                    }

                }
            }
            if(array_filter($review_minuses)) {
                $descr .= __('минусы: ','er_theme');
                $count_minuses = count($review_minuses);
                $review_pluses_x = 0;
                foreach ($review_minuses as $item) {
                    $review_minuses_x++;
                    if($item != '') {
                        $descr .= $item['text'];
                        if($review_minuses_x == $count_minuses) {
                            $descr .= '; ';
                        } else {
                            $descr .= ', ';
                        }
                    }

                }
            }*/
			//if(!array_filter($review_pluses) && !array_filter($review_minuses)) {
			
			$r_descr      = wp_trim_words( $comment->comment_content, 15, '' );
			$r_descr_last = substr( $r_descr, - 1 );
			if ( in_array( $r_descr_last, array( ',', ':', ';', '-' ) ) ) {
				$r_descr = substr( $r_tit, 0, - 1 );
			} elseif ( in_array( $r_descr_last, array( '!', '?', '.', '...' ) ) ) {
				$r_descr = $r_descr;
			} else {
				$r_descr = $r_descr . '...';
			}
			$descr .= $r_descr;
			//}
			
			if ( get_field( 'status_comment', $comment ) ) {
				$set_status = 'set_status_' . get_field( 'status_comment', $comment );
			} else {
				$set_status = '';
			}
			$result .= '<style>.set_status.set_status_bad {
	background: url(/wp-content/themes/eto-razvod-1/img/cancel-comment-status.svg);
	width: 18px;
	height: 18px;
	background-size: contain;
	margin-left: 5px;
	background-repeat: no-repeat;
}

.set_status.set_status_normal {
	background: url(/wp-content/themes/eto-razvod-1/img/status_normal.svg);
	width: 18px;
	height: 18px;
	background-size: contain;
	margin-left: 5px;
	background-repeat: no-repeat;
}

.set_status.set_status_good {
	background: url(/wp-content/themes/eto-razvod-1/img/status_good.svg);
	width: 18px;
	height: 18px;
	background-size: contain;
	margin-left: 5px;
	background-repeat: no-repeat;
}</style>';
			
			
			
			$approved_by = $comment->user_id;
			$result .= '<br>'.$approved_by.'<br>';
			
			
			if ( get_field( 'status_comment', $comment ) ) {
				$result .= '<span class="status_comment_adm_wrapper" style="background:#2271b1!important;display:flex;padding:7px;color:#fff;align-items:center;line-height:1!important;border-radius:30px;margin-top:5px"><span class="set_status '.$set_status.'" style="background-color:#fff!important;border-radius:50%;background-size:68%!important;background-position:center!important;background-repeat:no-repeat!important;width:25px!important;height:25px!important;margin-left:0!important;margin-right:10px!important"></span>'.get_field_object('status_comment', $comment)['choices'][get_field( 'status_comment', $comment )].'</span>';
			}
			
			if ( $comm_rev_title != '' && $comment_type != 'abuses' ) {
				$result .= '<div class="m_t_10 font_smaller_2">' . __( 'Title', 'er_theme' ) . ': <span>' . $comm_rev_title . ' | Это развод™</span></div>';
			}
			if ( $comm_rev_title != '' && $comment_type != 'abuses' ) {
				$result .= '<div class="m_t_10 font_smaller_2">' . __( 'Description', 'er_theme' ) . ': <span>' . $descr . '</span></div>';
			}
		}
		
		
		if ( $client_id_yandex != '' ) {
			$result .= '<div class="m_t_10">' . __( 'Client ID', 'er_theme' ) . ': <span class="font_bolder">' . $client_id_yandex . '</span></div>';
		}
		
		
		echo $result;
	}
}

add_filter( 'manage_comments_custom_column', 'myplugin_comment_column', 10, 2 );
