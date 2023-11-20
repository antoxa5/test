<?php
function custom_comment_single_hidden_new( $comment, $args, $depth) {
	
	$comment_data = get_comment_current_content($comment->comment_ID);
	$current_language = get_locale();

	$comment_status = wp_get_comment_status( $comment->comment_ID );

	if ( $comment_status != "approved" ) {
		return;
	}
	if (get_field('comment_type',$comment) == 'abuses' || get_field('comment_type','comment_'.$comment->comment_parent) == 'abuses') {
		return;
	}

	if(!$comment_data['available'] || $comment_data['available'] != 'yes') {
		echo '<li>';
		return;
	}

	if($depth > 1) {
		$attachment_id = get_field('photo_profile', 'user_'. $comment->user_id );
		$comment_class = get_comment_class('',$comment->comment_ID,$comment->comment_post_ID);
		$comment_class_print = '';
		foreach ($comment_class as $item) {
			$comment_class_print .= $item.' ';
		}
		//print_r($comment_class);
		//echo $comment->comment_ID;
		?>
		<?php
		$labelpro = '';
		if (    (    (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84175) || (get_field('services_user_services','user_'.$comment->user_id) == 84175) || (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84178) || (get_field('services_user_services','user_'.$comment->user_id) == 84178)    )    ) {
			$namep = get_field('services_user_services','user_'.$comment->user_id)[0];
			if (get_field('services_user_services','user_'.$comment->user_id)[0] == '') {
				$labelpro = ' <span class="label-pro user_label font_smaller label-pro-comments">'.get_the_title($namep).'</span>';
				$company_ids = get_field('company_user', 'user_'.$comment->user_id);
				
				if (count($company_ids) != 0) {
					$labelpro = ' <span class="label-pro user_label font_smaller label-pro-comments">Официальный представитель</span>';
					$companies = '';
					foreach ($company_ids  as $item ) {
						$post_id = $item;
						$companies .= '<a href="/review/'.get_post_field( 'post_name', $post_id ).'" class="review_logo"';
						$logo = get_field('company_logo',$post_id);
						$logo_bg = get_field('company_icon_bg',$post_id);
						if($logo_bg && $logo_bg != '') {
							$bg = ' background-color:'.$logo_bg.';';
						} else {
							$bg = '';
						}
						$lazy = false;
						if($logo && !empty($logo)) {
							if($lazy == true) {
								$companies .= ' data-img="'.$logo['sizes']['large'].'"';
								$companies .= ' style="'.$bg.'"';
							} else {
								$companies .= ' style="background-image:url('.$logo['sizes']['large'].'); '.$bg.'"';
							}
							//$companies .= ' data-img="'.$logo['sizes']['large'].'"';
							
						}
						$companies .= '></a>';
					}
					$labelpro = '';//$labelpro = '<span class="labelprocompany">'.$labelpro.' '.$companies.'</span>';
				}
			} else {
				$labelpro = ' <span class="label-pro user_label font_smaller label-pro-comments">'.get_the_title($namep).'</span>';
				$company_ids = get_field('company_user', 'user_'.$comment->user_id);
				
				if (count($company_ids) != 0) {
					$labelpro = ' <span class="label-pro user_label font_smaller label-pro-comments">Официальный представитель</span>';
					$companies = '';
					foreach ($company_ids  as $item ) {
						$post_id = $item;
						$companies .= '<a href="/review/'.get_post_field( 'post_name', $post_id ).'" class="review_logo"';
						$logo = get_field('company_logo',$post_id);
						$logo_bg = get_field('company_icon_bg',$post_id);
						if($logo_bg && $logo_bg != '') {
							$bg = ' background-color:'.$logo_bg.';';
						} else {
							$bg = '';
						}
						$lazy = false;
						if($logo && !empty($logo)) {
							if($lazy == true) {
								$companies .= ' data-img="'.$logo['sizes']['large'].'"';
								$companies .= ' style="'.$bg.'"';
							} else {
								$companies .= ' style="background-image:url('.$logo['sizes']['large'].'); '.$bg.'"';
							}
							//$companies .= ' data-img="'.$logo['sizes']['large'].'"';
							
						}
						$companies .= '></a>';
					}
					$labelpro = '';//$labelpro = '<span class="labelprocompany">'.$labelpro.' '.$companies.'</span>';
				}
			}
		}  else {
			$labelpro = '';
		}
		if ($comment->comment_approved == 0) {
			$holded = ' data-hold="1"';
			$holded_span = '<span class="moderate_text">На модерации</span>';
		} else {
			$holded = '';
			$holded_span = '';
		}
		?>
        <li  class="<?php echo $comment_class_print; ?> comment" id="ajax-comment-<?php comment_ID(); ?>"   data-commentid_v="2" data-commentid="<?php echo $comment->comment_ID; ?>" <?php echo $holded; ?>><?php echo $holded_span; ?>
        <div class="comment-body body_<?php echo $comment->comment_ID; ?>" data-body-id="body_<?php echo $comment->comment_ID; ?>">
            <div class="comment_header flex">
				<?php $comment_author = get_userdata( $comment->user_id );
				
				?>
				<?php if (get_field('pub_profile', 'user_'.$comment->user_id) == 'yes') {
					$pubprofile = ' data-pub="1" ';
				} else {
					$pubprofile = '';
				} ?>
				<?php
				$company_id = get_field('id_company',$comment);
				?>
				<?php
				$company_id = get_field('id_company',$comment);
				//this_company_id
				?>
				<?php if ($company_id) {
					$logo = get_field('company_logo',$company_id[0]);
					$logo_bg = get_field('company_icon_bg',$company_id[0]);
					if($logo_bg && $logo_bg != '') {
						$bg = ' background-color:'.$logo_bg.';';
					} else {
						$bg = '';
					}
					if($logo && !empty($logo)) {
						$comment_avatar = ' data-img="'.$logo['sizes']['large'].'"';
					}
					?>
                    <div class="comment_avatar comment_avatar_company" <?php echo $pubprofile; ?> data-link="<?php echo get_bloginfo('url').'/user/'.$comment_author->user_nicename.'/'; ?>" <?php if($logo && !empty($logo)) { echo $comment_avatar; }; ?>></div>
				<?php } else { ?>
                    <div class="comment_avatar" <?php echo $pubprofile; ?> data-link="<?php echo get_bloginfo('url').'/user/'.$comment_author->user_nicename.'/'; ?>" <?php if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') { ?>style="background-image: url(<?php echo $attachment_id['sizes']['thumbnail']; ?>)" <?php }; ?>><?php if(is_registered_from_social($comment->user_id)['main'] && is_registered_from_social($comment->user_id)['main'] != 'none') { echo '<div class="social_provider_registered '.is_registered_from_social($comment->user_id)['main'].'"></div>'; }; ?></div>
				<?php } ?>

                <div class="comment_meta">
                    <span class="comment-author font_bold font_small color_dark_blue m_b_5 pointer" <?php echo $pubprofile; ?> data-link="<?php echo get_bloginfo('url').'/user/'.$comment_author->user_nicename.'/'; ?>">
						<?php if ( $company_id ) {
							echo get_field( 'company_name', $company_id[0] );
		
						} else {
							if ( $comment_author->first_name && ! $comment_author->last_name ) {
			
								echo $comment_author->first_name . ' ' . $labelpro;
							} elseif ( ! $comment_author->first_name && $comment_author->last_name ) {
			
								echo $comment_author->last_name . ' ' . $labelpro;
							} elseif ( $comment_author->first_name && $comment_author->last_name ) {
			
								echo $comment_author->first_name . ' ' . $comment_author->last_name . ' ' . $labelpro;
							} elseif ( $comment_author->user_nicename ) {
			
								echo $comment_author->user_nicename . ' ' . $labelpro;
							} else {
								echo __('Анонимный пользователь','er_theme');
							}?><?php echo $user_status_label;
						} ?>
						<?php if (get_field('company_user','user_'.$comment_author->data->ID)) {
							if (in_array($comment_author->data->ID,[1,17,9,31,8])){
			
							} else {
								if ( !$company_id ) {
									echo '<span class="user_label user_label_purple font_smaller">' . get_field( 'company_name', get_field( 'company_user', 'user_' . $comment_author->data->ID )[0] ) . '</span>';
								}
							}
						} ?>
<span class="comment_parent_author_link font_normal color_dark_gray">
<?php
if ( $comment->comment_parent != 0 ) {
	$par_comm_obj = get_comment( $comment->comment_parent );
	$par_aurhor   = get_userdata( $par_comm_obj->user_id );
}


?>
<?php if ( $par_aurhor->first_name && ! $par_aurhor->last_name ) {
	echo $par_aurhor->first_name;
} elseif ( ! $par_aurhor->first_name && $par_aurhor->last_name ) {
	echo $par_aurhor->last_name;
} elseif ( $par_aurhor->first_name && $par_aurhor->last_name ) {
	echo $par_aurhor->first_name . ' ' . $par_aurhor->last_name;
} else {
	echo $par_aurhor->user_nicename;
} ?>
</span>
                </span></span>
                    <span class="comment-date font_smaller color_dark_gray"><?php comment_date( 'j F Y',$comment->comment_ID ); ?> <?php echo __('в','er_theme'); ?> <?php comment_date( 'H:i',$comment->comment_ID ); ?></span>
                </div><?php
				$comment_new = 1;
				if ($comment_new == 1) { ?>
					<?php
					$who_rate_golos_user_com = get_field( 'who_rate_golos_user_com', 'comment_' . $comment->comment_ID );
					
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
					
					$plus_anon = intval(get_field('plus_anon','comment_'.$comment->comment_ID));
					$minus_anon = intval(get_field('minus_anon','comment_'.$comment->comment_ID));
					$positive_array = $positive_array + $plus_anon;
					$minus_array = $minus_array + $minus_anon;
					//$positive_array = $positive_array + ;
					?>
                    <div class="comment_rate comment_rate_main rate-comment-<?php echo $comment->comment_ID; ?>" data-id="4" id="rate-comment-<?php echo $comment->comment_ID; ?>"><span class="load_ajax_comm"></span><span class="load_ajax_comm"></span>
                        <span class="title_comment_rate" data-id_rate="2"><?php echo __('Оцените ответ','er_theme') ?></span>
                        <span class="rate_plus_wrapper">
                                <span class="rate_plus rate_action pointer" data-commentaction="plus" data-comment-id="<?php echo $comment->comment_ID; ?>"></span>
		                        <span class="number_plus"><?php echo $positive_array; ?></span>
                            </span>
						<?php
						if($comment_rate == 0) {
							$rate_number_class = 'neutral';
							$comment_rate_plus = '';
						} elseif($comment_rate > 0) {
							$rate_number_class = 'positive';
							$comment_rate_plus = '+';
						} elseif($comment_rate < 0) {
							$rate_number_class = 'negative';
							$comment_rate_plus = '';
						}
						
						?>
                        <div class="rate_number_container"><span class="rate_number <?php echo $rate_number_class; ?>"><?php echo $comment_rate_plus.$comment_rate; ?></span></div>


                        <span class="rate_minus_wrapper">
                                <span class="number_minus"><?php echo $minus_array; ?></span>
                                <span class="rate_minus rate_action pointer" data-commentaction="minus" data-comment-id="<?php echo $comment->comment_ID; ?>"></span>

                            </span>


                    </div>
				<?php } else { ?>
                    <div class="comment_rate rate-comment-<?php echo $comment->comment_ID; ?>" data-id="3" id="rate-comment-<?php echo $comment->comment_ID; ?>"><span class="load_ajax_comm"></span>
                        <span class="rate_plus rate_action pointer" data-commentaction="plus" data-comment-id="<?php echo $comment->comment_ID; ?>"></span>
						<?php
						if($comment_rate == 0) {
							$rate_number_class = 'neutral';
							$comment_rate_plus = '';
						} elseif($comment_rate > 0) {
							$rate_number_class = 'positive';
							$comment_rate_plus = '+';
						} elseif($comment_rate < 0) {
							$rate_number_class = 'negative';
							$comment_rate_plus = '';
						}
						?>
                        <div class="rate_number_container"><span class="rate_number <?php echo $rate_number_class; ?>"><?php echo $comment_rate_plus.$comment_rate; ?></span></div>
                        <span class="rate_minus rate_action pointer" data-commentaction="minus" data-comment-id="<?php echo $comment->comment_ID; ?>"></span>
                    </div>
				<?php } ?>

            </div>
			
			<?php if ($total_rating != 0) { ?>
                <div class="comment_rating_details">
					<?php echo get_comment_rating_values($args['rating_fields'],$comment,'list'); ?>
                </div>
			<?php }; ?>
            <div class="comment-content">
                <div data-id="0391" class="comment_text comment_text_<?php echo $comment->comment_ID; ?> do_not_translate_css_class"><?php
					if (($comment->user_id == 31) || ($comment->user_id == 17) || ($comment->user_id == 15128)) {
						$current_language = get_locale();
						$textfrompost = $comment_data['content'];
						/*if($current_language != 'ru_RU') {
									$translations = get_field('comment_translations','comment_'.$comment->comment_ID);
									$textfrompost = $translations[0]['translation'];
									$language_original = get_field('language_original','comment_'.$comment->comment_ID);
									if($language_original == $current_language) {
										$textfrompost = $comment->comment_content;
									}
								} else {
									$textfrompost = $comment->comment_content;
								}*/
						if ( strstr( $textfrompost, '<a href' ) ) {
							/*if($current_language != 'ru_RU') {
										$translations = get_field('comment_translations','comment_'.$comment->comment_ID);
										$textfull = $translations[0]['translation'];
										$language_original = get_field('language_original','comment_'.$comment->comment_ID);
										if($language_original == $current_language) {
											$textfull = $comment->comment_content;
										}
									} else {
										$textfull = $comment->comment_content;
									}*/
							$textfull = $comment_data['content'];
						} else {
							
							
							$textfrompost = htmlspecialchars( $textfrompost );$textfrompost = trim(preg_replace('/(\r?\n){2,}/', ' ezTwoTab81939831 ', $textfrompost));$textfrompost = trim(preg_replace('/[\r\n]+/', ' ezOneTab81939831 ', $textfrompost));
							$textexplode  = explode( " ", $textfrompost );
							
							$regex = "((https?|ftp)\:\/\/)?";
							$regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";
							$regex .= "([a-z0-9-.]*)\.([a-z]{2,3})";
							$regex .= "(\:[0-9]{2,5})?";
							$regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
							$regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?";
							$regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?";
							
							$textfull      = '';
							$urlisnotempty = 0;
							foreach ( $textexplode as $key => $value ) {
								//echo strlen($value);
								/////////////////////////////////////////////////////////////////////////////
								$remove_go_from_text = rtrim( $value, "." );
								//echo strlen($remove_go_from_text);
								if ( strlen( $value ) == strlen( $remove_go_from_text ) ) {
									$strwithdot = '';
								} else {
									$strwithdot = '.';
								}
								/////////////////////////////////////////////////////////////////////////////
								$remove_go_from_text2 = rtrim( $remove_go_from_text, "!" );
								
								if ( strlen( $remove_go_from_text2 ) == strlen( $remove_go_from_text ) ) {
									$strwithcomma = '';
								} else {
									$strwithcomma = '!';
								}
								/////////////////////////////////////////////////////////////////////////////
								$remove_go_from_text3 = rtrim( $remove_go_from_text2, "," );
								
								if ( strlen( $remove_go_from_text2 ) == strlen( $remove_go_from_text3 ) ) {
									$strwithup = '';
								} else {
									$strwithup = ',';
								}
								/////////////////////////////////////////////////////////////////////////////
								//echo strlen($remove_go_from_text);
								
								if ( preg_match( "/^$regex$/", $remove_go_from_text3 ) ) {
									//if ($urlisnotempty != 1) {
									
									if ( strpos( $remove_go_from_text3, 'https://' ) !== false ) {
										$textfull .= '<a href="' . htmlspecialchars( $remove_go_from_text3 ) . '">' . htmlspecialchars( $remove_go_from_text3 ) . '</a>' . $strwithdot . '' . $strwithcomma . '' . $strwithup . ' ';
									} elseif ( strpos( $remove_go_from_text3, 'http://' ) !== false ) {
										$textfull .= '<a href="' . htmlspecialchars( $remove_go_from_text3 ) . '">' . htmlspecialchars( $remove_go_from_text3 ) . '</a>' . $strwithdot . '' . $strwithcomma . '' . $strwithup . ' ';
									} else {
										$textfull .= '<a href="https://' . htmlspecialchars( $remove_go_from_text3 ) . '">' . htmlspecialchars( $remove_go_from_text3 ) . '</a>' . $strwithdot . '' . $strwithcomma . '' . $strwithup . ' ';
									}
									
									$urlisnotempty = 1;
									
									//} else {
									//  $textfull .= htmlspecialchars($value).' ';
									//}
								} else {
									$textfull = $comment_data['content'];
									/*if($current_language != 'ru_RU') {
											$translations = get_field('comment_translations','comment_'.$comment->comment_ID);
											$textfull = $translations[0]['translation'];
											$language_original = get_field('language_original','comment_'.$comment->comment_ID);
											if($language_original == $current_language) {
												$textfull = $comment->comment_content;
											}
										} else {
											$textfull = $comment->comment_content;
										}*/
								}
							}
						}
					} else {
						//$textfull = $comment->comment_content;
						$textfull = $comment_data['content'];
					}
					
					$textfull = trim(preg_replace('/ ezOneTab81939831 /', "\n", $textfull));$textfull = trim(preg_replace('/ ezTwoTab81939831 /', "\n\n", $textfull));$textfull = str_replace('ezTwoTab81939831', "", $textfull);$textfull = str_replace('amp;','',$textfull);echo apply_filters('the_content', $textfull); ?></div>
				<?php
				$comment_files ='';
				$comment_files = get_field('comment_files','comment_'.$comment->comment_ID);
				if(!empty($comment_files)) {
					echo '<ul class="comment_attached_files_list">';
					foreach ($comment_files as $file) {
						$full = wp_get_attachment_image_url( $file['file'], 'full' );
						$thumb = wp_get_attachment_image_url( $file['file'], 'thumbnail' );
						if($file['file_type'] == 'url') {
							echo '<li><a href="'.$file['link'].'" style="background-image:url('.$thumb.');" class="youtube_link">';
							echo '</a></li>';
						} else {
							echo '<li><a href="'.$full.'" style="background-image:url('.$thumb.');">';
							echo '</a></li>';
						}
					}
					echo '</ul>';
				}
				?>
            </div>

            <div class="comment_footer font_smaller">

                <span data-user-id="<?php echo $comment->user_id; ?>" class="comment-reply-link color_dark_blue pointer inactive"   data-commentid_v="3" data-commentid="<?php echo $comment->comment_parent ?>" data-postid="<?php echo $comment->comment_post_ID; ?>" data-appendto="<?php echo $comment->comment_ID; ?>"><?php _e('Ответить','er_theme'); ?></span>
                <div class="comment_footer_right hovered_<?php echo $comment->comment_ID; ?>">

                </div>
                <div class="comment_fast_links hovered_<?php echo $comment->comment_ID; ?>">
                    <span class="comment_permalink"></span>
                    <span class="comment_share"></i></span>

                </div>

            </div>
        </div>
	<?php } else {
		?>
		<?php
		if (    (    (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84175) || (get_field('services_user_services','user_'.$comment->user_id) == 84175) || (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84178) || (get_field('services_user_services','user_'.$comment->user_id) == 84178)    )    ) {
			$namep = get_field('services_user_services','user_'.$comment->user_id)[0];
			if (get_field('services_user_services','user_'.$comment->user_id)[0] == '') {
				$labelpro = ' <span class="label-pro user_label font_smaller label-pro-comments">'.get_the_title($namep).'</span>';
				$company_ids = get_field('company_user', 'user_'.$comment->user_id);
				
				if (count($company_ids) != 0) {
					$labelpro = ' <span class="label-pro user_label font_smaller label-pro-comments">Официальный представитель</span>';
					$companies = '';
					foreach ($company_ids  as $item ) {
						$post_id = $item;
						$companies .= '<a href="/review/'.get_post_field( 'post_name', $post_id ).'" class="review_logo"';
						$logo = get_field('company_logo',$post_id);
						$logo_bg = get_field('company_icon_bg',$post_id);
						if($logo_bg && $logo_bg != '') {
							$bg = ' background-color:'.$logo_bg.';';
						} else {
							$bg = '';
						}
						$lazy = false;
						if($logo && !empty($logo)) {
							if($lazy == true) {
								$companies .= ' data-img="'.$logo['sizes']['large'].'"';
								$companies .= ' style="'.$bg.'"';
							} else {
								$companies .= ' style="background-image:url('.$logo['sizes']['large'].'); '.$bg.'"';
							}
						}
						$companies .= '></a>';
					}
					$labelpro = '';
				}
			} else {
				$labelpro = ' <span class="label-pro user_label font_smaller label-pro-comments">'.get_the_title($namep).'</span>';
				$company_ids = get_field('company_user', 'user_'.$comment->user_id);
				
				if (count($company_ids) != 0) {
					$labelpro = ' <span class="label-pro user_label font_smaller label-pro-comments">Официальный представитель</span>';
					$companies = '';
					
					foreach ($company_ids  as $item ) {
						$post_id = $item;
						$companies .= '<a href="/review/'.get_post_field( 'post_name', $post_id ).'" class="review_logo"';
						$logo = get_field('company_logo',$post_id);
						$logo_bg = get_field('company_icon_bg',$post_id);
						if($logo_bg && $logo_bg != '') {
							$bg = ' background-color:'.$logo_bg.';';
						} else {
							$bg = '';
						}
						$lazy = false;
						if($logo && !empty($logo)) {
							if($lazy == true) {
								$companies .= ' data-img="'.$logo['sizes']['large'].'"';
								$companies .= ' style="'.$bg.'"';
							} else {
								$companies .= ' style="background-image:url('.$logo['sizes']['large'].'); '.$bg.'"';
							}
						}
						$companies .= '></a>';
					}
					$labelpro = '';
				}
			}
		}  else {
			$labelpro = '';
		}
		$attachment_id = get_field('photo_profile', 'user_'. $comment->user_id );
		if (get_field('status_comment',$comment)) {
			$status_comment_li = 'li_status'.get_field('status_comment',$comment);
		} else {
			$status_comment_li = '';
		}
		?>
		<?php


		$total_rating = get_comment_rating_values($args['rating_fields'],$comment,'total');
		$total_rating_value = 5 / 100 * $total_rating;
		$data_percent = $total_rating / 100;
		if ($total_rating != 0) {
			if ( $total_rating >= 70 ) {
				$rating_color = 'green';
			} elseif ( $total_rating >= 40 && $total_rating < 70 ) {
				$rating_color = 'orange';
			} elseif ( $total_rating < 40 ) {
				$rating_color = 'red';
			}

		$who_rate_golos_user_com = get_field( 'who_rate_golos_user_com', 'comment_' . $comment->comment_ID );
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
		$plus_anon = intval(get_field('plus_anon','comment_'.$comment->comment_ID));
		$minus_anon = intval(get_field('minus_anon','comment_'.$comment->comment_ID));
		$positive_array = $positive_array + $plus_anon;
		$minus_array = $minus_array + $minus_anon;
		}
			?>
        <li id="comment-<?php echo $comment->comment_ID; ?>" class="comment white_block <?=$status_comment_li?>" itemprop="review" itemscope itemtype="http://schema.org/Review" data-commentid="<?php echo $comment->comment_ID; ?>" data-date="<?=strtotime(get_comment_date( 'd-m-Y H:i:s',$comment->comment_ID ))?>" data-stars="<?=round($total_rating_value,1)?>" data-best="<?=($positive_array+$minus_array)?>">
		<meta itemprop="name" content="<?php echo get_field('company_name' ); ?>" />
		<div class="comment-body body_<?php echo $comment->comment_ID; ?>" data-body-id="body_<?php echo $comment->comment_ID; ?>">
			<?php
			$comment_rate = get_field('comment_rate', $comment);
			
			$current_language = get_locale();
			$review_title = '';
			$review_title = $comment_data['title'];
			if(!$review_title || $review_title == '') {
				$review_title = wp_trim_words($comment_data['content'], 7,'');
			}
			$review_title_last = substr($review_title, -1);
			if(in_array($review_title_last,array(',','.'))) {
				$review_title = substr($review_title,0, -1);
			} elseif(in_array($review_title_last,array('!','?','...'))) {
				$review_title = $review_title;
			} else {
				if(!$comment_data['title'] || $comment_data['title'] == '') {
					$review_title = $review_title.'...';
				}
			}
			if($review_title && $review_title != '' && get_post_type($comment->comment_post_ID) == 'casino') { ?>
				<?php
				echo '<link itemprop="url" href = "'.get_the_permalink($comment->comment_post_ID).'comment-'.$comment->comment_ID.'/" />';
				?>
			<?php } else { ?>
                <link itemprop="url" href = "<?php echo get_comment_link($comment->comment_ID); ?>" />
			<?php  } ?>
			<?php
			if($current_language != 'ru_RU') {
				$cyr = ['Љ', 'Њ', 'Џ', 'џ', 'ш', 'ђ', 'ч', 'ћ', 'ж', 'љ', 'њ', 'Ш', 'Ђ', 'Ч', 'Ћ', 'Ж','Ц','ц', 'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п', 'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я', 'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П', 'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
				];
				$lat = ['Lj', 'Nj', 'Dž', 'dž', 'š', 'đ', 'č', 'ć', 'ž', 'lj', 'nj', 'Š', 'Đ', 'Č', 'Ć', 'Ž','C','c', 'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p', 'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya', 'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P', 'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
				];
			} else {
				$cyr = [];
				$lat = [];
			}
			?>
            <div class="comment_header flex">
				<?php $comment_author = get_userdata( $comment->user_id ); ?>
				<?php if (get_field('pub_profile', 'user_'.$comment->user_id) == 'yes') {
					$pubprofile = ' data-pub="1" ';
				} else {
					$pubprofile = '';
				}
				$user_status = get_field('user_site_statuses','user_'.$comment->user_id);
				if(!empty($user_status) && $user_status['value'] != 'none') {
					$user_status_label = '<span class="user_comment_status status_'.$user_status['value'].' user_label font_smaller" >'.$user_status['label'].'</span>';
				}  else {
					$user_status_label = '';
				}
				?>
				<?php $company_id = get_field('id_company',$comment); ?>
				<?php
				if ($comment_author->user_nicename) {
					$comment_avatar_link = 'data-link="'.get_bloginfo('url').'/user/'.$comment_author->user_nicename.'/"';
				} else {
					$comment_avatar_link = '';
				}
				
				?>
                <div class="comment_avatar pointer"  <?php echo $pubprofile; ?> <?=$comment_avatar_link?> <?php if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') { ?>style="background-image: url(<?php echo $attachment_id['sizes']['thumbnail']; ?>)" <?php }; ?>><?php if(is_registered_from_social($comment->user_id)['main'] && is_registered_from_social($comment->user_id)['main'] != 'none') { echo '<div class="social_provider_registered '.is_registered_from_social($comment->user_id)['main'].'"></div>'; }; ?></div>
                <div class="comment_meta comment_meta_main">

				<span itemprop="itemReviewed" itemscope="" itemtype="https://schema.org/Organization">
					<meta itemprop="name" content="<?php echo get_field('company_name' ); ?>" />
					<meta itemprop="telephone" content="<?php echo get_field('base_2_support_phones',$comment->comment_post_ID)[0]['text']; ?>" />
					<meta itemprop="address" content="<?php echo str_replace($cyr,$lat,get_field('company_main_office',$comment->comment_post_ID)); ?>" />
					<meta itemprop="url" content="<?php echo get_the_permalink( $post_id ); ?>" />
				</span>

				<?php $comment_author = get_userdata( $comment->user_id ); ?>
                    <div class="comment_author_wrapper" itemprop="author" itemscope="" itemtype="https://schema.org/Person">
                        <div class="comment-author font_bold font_small color_dark_blue pointer" data-link="<?php echo get_bloginfo('url').'/user/'.$comment_author->user_nicename.'/'; ?>" <?php echo $pubprofile; ?>>
                            <span class="comment-author"><meta itemprop="name" content="<?php if($comment_author->first_name && !$comment_author->last_name) { echo str_replace($cyr,$lat,$comment_author->first_name); } elseif (!$comment_author->first_name && $comment_author->last_name) { echo str_replace($cyr,$lat,$comment_author->last_name); } elseif($comment_author->first_name && $comment_author->last_name) { echo str_replace($cyr,$lat,$comment_author->first_name.' '.$comment_author->last_name); } elseif ($comment_author->user_nicename) { echo str_replace($cyr,$lat,$comment_author->user_nicename); } else { if (strlen( $comment->comment_author )) { echo str_replace($cyr,$lat,$comment->comment_author); } else { echo __('Анонимный пользователь','er_theme'); } } ?>" />
							<?php 

								$user_alt_name = get_user_alt_name( $comment->user_id, $current_language );

								if( $user_alt_name ) {
									echo $user_alt_name . ' ' . $labelpro;
								} elseif( $comment_author->first_name && !$comment_author->last_name ) { 
									echo str_replace( $cyr, $lat, $comment_author->first_name ) . ' ' . $labelpro;
								} elseif( !$comment_author->first_name && $comment_author->last_name ) { 
									echo str_replace( $cyr, $lat, $comment_author->last_name ) . ' ' . $labelpro;
								} elseif( $comment_author->first_name && $comment_author->last_name ) { 
									echo str_replace( $cyr, $lat, $comment_author->first_name . ' ' . $comment_author->last_name ) . ' ' . $labelpro;
								} elseif ( $comment_author->user_nicename) { 
									echo str_replace( $cyr, $lat, $comment_author->user_nicename ).' '.$labelpro;
								} else { 
									if ( strlen( $comment->comment_author ) ) { 
										echo str_replace( $cyr, $lat, $comment->comment_author );
									} else { 
										echo __('Анонимный пользователь','er_theme');
									} 
								} 
							?>
								
							<?=$user_status_label?>
							<?php
								if (get_field('status_comment',$comment)) {
									$set_status = 'set_status_'.get_field('status_comment',$comment);
								} else {
									$set_status = '';
								}
							?>
							</span>
                        </div>
						<?php if ($comment_author->user_nicename) { ?>
                            <link itemprop="url" href = "<?php echo get_bloginfo('url').'/user/'.$comment_author->user_nicename.'/'; ?>" />
						<?php } ?>
						
						<?php if($attachment_id) { ?>
                            <link itemprop="image" href = "<?php echo $attachment_id['sizes']['thumbnail']; ?>" />
						<?php } ?>

                    </div>
                    <span class="comment-date font_smaller color_dark_gray" itemprop="datePublished" content="<?php comment_date( 'Y-m-d',$comment->comment_ID ); ?>T<?php comment_date( 'H:i:s',$comment->comment_ID ); ?>+00:00"><?php comment_date( 'j F Y',$comment->comment_ID ); ?> <?php echo __('в','er_theme'); ?> <?php comment_date( 'H:i',$comment->comment_ID ); ?></span>
                </div>

				<div class="ratingwrapper">
                    <div data-value="<?=round($total_rating_value,1)?>" class="comment_total_rating">
                        <div class="review_average_round progress small pointer <?php echo $rating_color;?>" id="comment_rating_total_<?php echo $comment->comment_ID; ?>" data-percent="<?php echo $data_percent; ?>">
                            <div class="inner color_dark_blue font_bold font_small pointer"><?php echo round($total_rating_value,1); ?></div>
                        </div>
                    </div>
				</div>
				<?php
				$comment_new = 1;
				if ($comment_new == 1) { ?>
					<?php
					$who_rate_golos_user_com = get_field( 'who_rate_golos_user_com', 'comment_' . $comment->comment_ID );
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
					$plus_anon = intval(get_field('plus_anon','comment_'.$comment->comment_ID));
					$minus_anon = intval(get_field('minus_anon','comment_'.$comment->comment_ID));
					$positive_array = $positive_array + $plus_anon;
					$minus_array = $minus_array + $minus_anon;
					?>
                    <div class="comment_rate comment_rate_main rate-comment-<?php echo $comment->comment_ID; ?>" data-id="4">
						<?php if (get_field('status_comment',$comment)) { ?>
							<span class="set_status <?=$set_status?>"><span class="status_comment_a"><span><?=get_field_object('status_comment', $comment)['choices'][get_field( 'status_comment', $comment )]?></span></span></span>
						<?php } ?>
						<span class="load_ajax_comm"></span>
                        <span class="title_comment_rate" data-id_rate="2"><?php echo __('Оцените отзыв','er_theme') ?></span>
                        <span class="rate_plus_wrapper">
							<span class="rate_plus rate_action pointer" data-commentaction="plus" data-comment-id="<?php echo $comment->comment_ID; ?>"></span>
							<span class="number_plus"><?php echo $positive_array; ?></span>
						</span>
						<?php
						if($comment_rate == 0) {
							$rate_number_class = 'neutral';
							$comment_rate_plus = '';
						} elseif($comment_rate > 0) {
							$rate_number_class = 'positive';
							$comment_rate_plus = '+';
						} elseif($comment_rate < 0) {
							$rate_number_class = 'negative';
							$comment_rate_plus = '';
						}
						?>
                        <div class="rate_number_container"><span class="rate_number <?php echo $rate_number_class; ?>"><?php echo $comment_rate_plus.$comment_rate; ?></span></div>
                        <span class="rate_minus_wrapper">
							<span class="number_minus"><?php echo $minus_array; ?></span>
							<span class="rate_minus rate_action pointer" data-commentaction="minus" data-comment-id="<?php echo $comment->comment_ID; ?>"></span>
						</span>
                    </div>
				<?php } else { ?>
                    <div class="comment_rate rate-comment-<?php echo $comment->comment_ID; ?>" data-id="4" id="rate-comment-<?php echo $comment->comment_ID; ?>"><span class="load_ajax_comm"></span><span class="load_ajax_comm"></span>
                        <span class="rate_plus rate_action pointer" data-commentaction="plus" data-comment-id="<?php echo $comment->comment_ID; ?>"></span>
						<?php
						if($comment_rate == 0) {
							$rate_number_class = 'neutral';
							$comment_rate_plus = '';
						} elseif($comment_rate > 0) {
							$rate_number_class = 'positive';
							$comment_rate_plus = '+';
						} elseif($comment_rate < 0) {
							$rate_number_class = 'negative';
							$comment_rate_plus = '';
						}
						?>
                        <div class="rate_number_container"><span class="rate_number <?php echo $rate_number_class; ?>"><?php echo $comment_rate_plus.$comment_rate; ?></span></div>
                        <span class="rate_minus rate_action pointer" data-commentaction="minus" data-comment-id="<?php echo $comment->comment_ID; ?>"></span>
                    </div>
				<?php } ?>
            </div>
			
			<?php if ($total_rating != 0) { ?>
                <div class="comment_rating_details">
					<?php echo get_comment_rating_values($args['rating_fields'],$comment,'list'); ?>
                </div>
			<?php } ?>

            <div class="comment-content">
				<?php
				echo '<a href="'.get_the_permalink($comment->comment_post_ID).'comment-'.$comment->comment_ID.'/" class="review_title link_no_underline" title="'.__('Подробнее об отзыве','er_theme').'">'.$review_title.'</a>';
				?>
                <div itemprop="reviewBody" class="comment_text comment_text_<?php echo $comment->comment_ID; ?> do_not_translate_css_class"><?php if (($comment->user_id == 31) || ($comment->user_id == 17) || ($comment->user_id == 15128)) {
						$current_language = get_locale();
						$textfrompost = $comment_data['content'];
						if ( strstr( $textfrompost, '<a href' ) ) {
							$textfull = $comment_data['content'];
							$type = 1;
						} else {
							$type = 2;
							$textfrompost = htmlspecialchars( $textfrompost );$textfrompost = trim(preg_replace('/(\r?\n){2,}/', ' ezTwoTab81939831 ', $textfrompost));$textfrompost = trim(preg_replace('/[\r\n]+/', ' ezOneTab81939831 ', $textfrompost));
							$textexplode  = explode( " ", $textfrompost );
							$regex = "((https?|ftp)\:\/\/)?";
							$regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";
							$regex .= "([a-z0-9-.]*)\.([a-z]{2,3})";
							$regex .= "(\:[0-9]{2,5})?";
							$regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
							$regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?";
							$regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?";
							
							$textfull      = '';
							$urlisnotempty = 0;
							foreach ( $textexplode as $key => $value ) {
								$remove_go_from_text = rtrim( $value, "." );
								if ( strlen( $value ) == strlen( $remove_go_from_text ) ) {
									$strwithdot = '';
								} else {
									$strwithdot = '.';
								}
								$remove_go_from_text2 = rtrim( $remove_go_from_text, "!" );
								
								if ( strlen( $remove_go_from_text2 ) == strlen( $remove_go_from_text ) ) {
									$strwithcomma = '';
								} else {
									$strwithcomma = '!';
								}
								$remove_go_from_text3 = rtrim( $remove_go_from_text2, "," );
								
								if ( strlen( $remove_go_from_text2 ) == strlen( $remove_go_from_text3 ) ) {
									$strwithup = '';
								} else {
									$strwithup = ',';
								}
								
								if ( preg_match( "/^$regex$/", $remove_go_from_text3 ) ) {
									
									if ( strpos( $remove_go_from_text3, 'https://' ) !== false ) {
										$textfull .= '<a href="' . htmlspecialchars( $remove_go_from_text3 ) . '">' . htmlspecialchars( $remove_go_from_text3 ) . '</a>' . $strwithdot . '' . $strwithcomma . '' . $strwithup . ' ';
									} elseif ( strpos( $remove_go_from_text3, 'http://' ) !== false ) {
										$textfull .= '<a href="' . htmlspecialchars( $remove_go_from_text3 ) . '">' . htmlspecialchars( $remove_go_from_text3 ) . '</a>' . $strwithdot . '' . $strwithcomma . '' . $strwithup . ' ';
									} else {
										$textfull .= '<a href="https://' . htmlspecialchars( $remove_go_from_text3 ) . '">' . htmlspecialchars( $remove_go_from_text3 ) . '</a>' . $strwithdot . '' . $strwithcomma . '' . $strwithup . ' ';
									}
									
									$urlisnotempty = 1;
								} else {
									$textfull .= htmlspecialchars( $value ) . ' ';
								}
							}
						}
					} else {
						$textfull = $comment_data['content'];
					}
					
					$textfull = trim(preg_replace('/ ezOneTab81939831 /', "\n", $textfull));
				$textfull = trim(preg_replace('/ ezTwoTab81939831 /', "\n\n", $textfull));
				$textfull = str_replace('ezTwoTab81939831', "", $textfull);
				$textfull = str_replace('amp;','',$textfull);

					
					if ($current_language == 'ru_RU') {
						$continue_reading_btn = 'Читать далее';
					} elseif ($current_language == 'en_US') {
						$continue_reading_btn = 'Read more';
					} elseif ($current_language == 'de_DE') {
						$continue_reading_btn = 'Weiter lesen';
					} elseif ($current_language == 'es_ES') {
						$continue_reading_btn = 'Lee mas';
					} elseif ($current_language == 'fr_FR') {
						$continue_reading_btn = 'Lire la suite';
					} elseif ($current_language == 'pl_PL') {
						$continue_reading_btn = 'Czytaj więcej';
					} elseif ($current_language == 'fi') {
						$continue_reading_btn = 'Lue lisää';
					} elseif ($current_language == 'id_ID') {
						$continue_reading_btn = 'Baca lebih lanjut';
					}

					if (get_post_type($comment->comment_post_ID) != 'page' && get_post_type($comment->comment_post_ID) != 'post') {
						$continue_reading = '<a href="'.get_the_permalink($comment->comment_post_ID).'comment-'.$comment->comment_ID.'/" class="continue_reading continue_3reading">'.$continue_reading_btn.'</a>';
						$textfull1 = $textfull;
						if (strlen(truncateToWord( $textfull, 300,'' )) == 4) {
							$textfull = truncateToWord2( $textfull, 300,$continue_reading );
						} else {
							$textfull = truncateToWord( $textfull, 300,$continue_reading );
						}


					}
					echo apply_filters('the_content', $textfull);
					$comment_files ='';
					$comment_files = get_field('comment_files','comment_'.$comment->comment_ID);
					if(!empty($comment_files)) {
						echo '<ul class="comment_attached_files_list">';
						foreach ($comment_files as $file) {
							$full = wp_get_attachment_image_url( $file['file'], 'full' );
							$thumb = wp_get_attachment_image_url( $file['file'], 'thumbnail' );
							if($file['file_type'] == 'url') {
								echo '<li><a href="'.$file['link'].'" style="background-image:url('.$thumb.');" class="youtube_link">';
								echo '</a></li>';
							} else {
								echo '<li><a href="'.$full.'" style="background-image:url('.$thumb.');">';
								echo '</a></li>';
							}
						}
						echo '</ul>';
					}

					$comment_files = get_field('comment_files_2','comment_'.$comment->comment_ID);
					if(!empty($comment_files)) {
						$company_admin = 0;
						$userid_logged = -1;
						$admin_staff = 0;

						if (is_user_logged_in()) {
							$userid_logged = get_current_user_id();
							if (gettype(get_field('company_user','user_'.$userid_logged)) == 'array') {
								if (in_array($comment->comment_post_ID,get_field('company_user','user_'.$userid_logged))) {
									$company_admin = 1;
								}
							}
							$user_data = get_userdata( $userid_logged );
							$user_roles = $user_data->roles;
							if (gettype($user_roles) == 'array') {
								if (in_array('administrator',$user_roles)) {
									$admin_staff = 1;
								}
								if (in_array('moderator_plus',$user_roles)) {
									$admin_staff = 1;
								}
								if (in_array('moderator_editor_new',$user_roles)) {
									$admin_staff = 1;
								}
								if (in_array('admin2',$user_roles)) {
									$admin_staff = 1;
								}
								if (in_array('beta_role',$user_roles)) {
									$admin_staff = 1;
								}
							}
						}

						if ((get_field('watch_files', $comment) == 'pub') || ($userid_logged == $comment->user_id) || ($company_admin == 1) || ($admin_staff == 1)) {
							echo '<ul class="comment_attached_files_list">';
							foreach ( $comment_files as $file ) {
								$full = wp_get_attachment_image_url( $file['file']['ID'], 'full' );
								if ( empty( $full ) ) {
									$full = wp_get_attachment_url( $file['file']['ID'] );
								}
								$thumb = wp_get_attachment_image_url( $file['file']['ID'], 'thumbnail' );
								if ( empty( $thumb ) ) {
									$thumb = wp_get_attachment_url( $file['file']['ID'] );
								}
								if ( $file['file_type'] == 'url' ) {
									echo '<li><a href="' . $file['link'] . '" style="background-image:url(' . $thumb . ');" class="youtube_link">';
									echo '</a></li>';
								} else {
									if ( substr( $thumb, - 3 ) == 'pdf' ) {
										$thumb = '/wp-content/themes/eto-razvod-1/img/pdf-upload-comment.svg';
									} elseif ( substr( $thumb, - 3 ) == 'doc' ) {
										$thumb = '/wp-content/themes/eto-razvod-1/img/doc-upload-comment.svg';
									}
									echo '<li><a href="' . $full . '" style="background-image:url(' . $thumb . ');">';
									echo '</a></li>';
								}
							}
							echo '</ul>';
						}
					}
					?>
				</div>
				<?php
				$review_pluses = $comment_data['pluses'];
				$review_minuses = $comment_data['minuses'];
				if(!empty($review_pluses) || !empty($review_minuses)) {
					$result_pluses = '';
					$result_pluses .= '<div class="review_pluses_minuses flex flex_wrap m_t_15">';

					if(!empty($review_pluses)) {
						$result_pluses .= '<div class="review_pluses_minuses_left">';
						$result_pluses .= '<div class="plus_minus_title font_smaller_2 color_dark_blue font_uppercase font_bolder">'.__('Плюсы','er_theme').'</div>';
						$result_pluses .= '<ul class="pluses">';
						foreach ($review_pluses as $item) {
							if($item != '') {
								$result_pluses .= '<li>'.$item.'</li>';
							}

						}
						$result_pluses .= '</ul>';
						$result_pluses .= '</div>';
					}
					if(!empty($review_minuses)) {
						$result_pluses .= '<div class="review_pluses_minuses_right">';
						$result_pluses .= '<div class="plus_minus_title font_smaller_2 color_dark_blue font_uppercase font_bolder">'.__('Минусы','er_theme').'</div>';
						$result_pluses .= '<ul class="minuses">';
						foreach ($review_minuses as $item) {
							if($item != '') {
								$result_pluses .= '<li>'.$item.'</li>';
							}
						}
						$result_pluses .= '</ul>';
						$result_pluses .= '</div>';
					}
					$result_pluses .= '</div>';
					echo $result_pluses;
				}
				?>
            </div>
            <div class="comment_footer comment_footer_parent font_smaller">
				<?php
				$childcomments = get_comments(array(
					'post_id'   => get_the_ID(),
					'status'    => 'approve',
					'order'     => 'DESC',
					'parent'    => $comment->comment_ID,
				));
				$comment_replies = count($childcomments);
				if (substr($comment_replies, -1) == 1) {
					$comment_replies_text = __('ответ','er_theme');
				} elseif(substr($comment_replies, -1) > 1 && substr($comment_replies, -1) < 5) {
					$comment_replies_text = __('ответа','er_theme');
				} else {
					$comment_replies_text = __('ответов','er_theme');
				}
				?>
				<?php if($comment_replies != 0) { ?>
                    <div class="comment_reply_count dropdown flex color_dark_gray m_right_20 pointer"><?php echo $comment_replies; ?> <?php echo $comment_replies_text; ?></div>
				<?php } ?>
                <span data-user-id="<?php echo $comment->user_id; ?>" class="comment-reply-link color_dark_blue pointer inactive" data-commentid_v="61" data-commentid="<?php echo $comment->comment_ID; ?>" data-postid="<?php echo $comment->comment_post_ID; ?>" data-appendto="<?php comment_ID(); ?>"><?php _e('Ответить на отзыв','er_theme'); ?></span>
                <div class="comment_fast_links hovered_<?php echo $comment->comment_ID; ?>">
                    <span class="comment_permalink"></span>
                    <span class="comment_share"></span>
                </div>
				<?php if(get_field('review_recommend_friends','comment_'.$comment->comment_ID) == 'yes') { ?>
					<div class="comment_recommend_yes color_dark_gray font_small "><?php _e('Рекомендую','er_theme'); ?></div>
				<?php } elseif(get_field('review_recommend_friends','comment_'.$comment->comment_ID) == 'no') { ?>
					<div class="comment_recommend_no color_dark_gray font_small m_t_20"><?php _e('Не рекомендую','er_theme'); ?></div>
				<?php } ?>
				<?php

				
				$total_rating = get_comment_rating_values($args['rating_fields'],$comment,'total');
				$total_rating_value = 5 / 100 * $total_rating;
				if ($total_rating != 0) {
					
					?><div style="display: none;" class="comment_total_rating" itemprop="reviewRating" itemscope="" itemtype="https://schema.org/Rating"><meta itemprop="bestRating" content = "5" /><meta itemprop="worstRating" content = "1" /><span itemprop="ratingValue"><?php echo (floatval(round($total_rating_value,1)) > 0.0) ? round($total_rating_value,1) : 1; ?></span></div><?php };
				?>
            </div></div>
		<?php
	}
	?>

<?php }