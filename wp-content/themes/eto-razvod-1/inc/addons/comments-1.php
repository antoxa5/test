<?php


if(!function_exists('get_rating_fields_group')) {
	function get_rating_fields_group($post_id) {
		$rating_fields_group = 0;
		if('casino' == get_post_type( $post_id )) {
			$term_slug = get_term( get_field('company_type',$post_id), 'companytypes' )->name;
			if (in_array($term_slug, array('job'))) {
				$rating_fields_group = 97577;
			} elseif (in_array($term_slug, array('payment'))) {
				$rating_fields_group = 97582;
			} elseif (in_array($term_slug, array('pharmacy'))) {
				$rating_fields_group = 97587;
			} elseif (in_array($term_slug, array('fx','cfd','fond','bi','crypto','cryptobot'))) {
				$rating_fields_group = 97592;
			} elseif (in_array($term_slug, array('crm'))) {
				$rating_fields_group = 97602;
			} elseif (in_array($term_slug, array('dating'))) {
				$rating_fields_group = 97616;
			} elseif (in_array($term_slug, array('deliveryfood'))) {
				$rating_fields_group = 97622;
			} elseif (in_array($term_slug, array('cpanetworks'))) {
				$rating_fields_group = 97628;
			} elseif (in_array($term_slug, array('bet'))) {
				$rating_fields_group = 97633;
			} elseif (in_array($term_slug, array('bookinghotel'))) {
				$rating_fields_group = 97639;
			} else {
				$rating_fields_group = 87485;
			}
		} else {
			$rating_fields_group = 0;
		}
		return $rating_fields_group;
	}
}


if(!function_exists('get_post_rating') && function_exists('get_comment_rating_fields') && function_exists('get_comments_count')) {
	function get_post_rating($group_id,$format) {
		global $post;
		 //echo $group_id;
		$fields = acf_get_fields($group_id);
		$result = '';
		if($format == 'layout') {
			if ( $fields ) {
				$total_rating      = array();
				$get_ratings_count = get_comments_count( $post->ID, get_comment_rating_fields( $group_id, 'name' ) );
				foreach ( $fields as $field ) {
					$comments_rating = $get_ratings_count['ratings_total'][ $field['name'] ]['total'];
					$rating_total[] = $comments_rating;

				}
				$print_total = array_sum( $rating_total ) / count($rating_total);
				$print_total_round = number_format( $print_total, 1, '.', '' );
				if($get_ratings_count['count'] > 0) {
				$result .= '<div class="white_block block_rating">';
				$result .= '<div class="ratings_container flex flex_column">';
				foreach ( $fields as $field ) {
				$row_index++;
				// echo '<pre>';
				//print_r($field);
				//echo '</pre>';
				if($row_index % 2 == 0){ 
					$oddeven = 'even';  
				} 
				else{ 
					$oddeven = 'odd';
				} 
				$field_value     = get_field( $field['name'], $post->ID );
				$comments_rating = $get_ratings_count['ratings_total'][ $field['name'] ];
				//print_r($comments_rating);
				if ( ! empty( $comments_rating ) && $comments_rating['count_all'] != 0 ) {
					$rating_value = ( $field_value + $comments_rating['total'] ) / 2 * 10;
				} else {
					$rating_value = $field_value * 10;
				}
				if ( $rating_value >= 70 ) {
					$rating_color = 'green';
				} elseif ( $rating_value >= 40 && $rating_value < 70 ) {
					$rating_color = 'orange';
				} elseif ( $rating_value < 40 ) {
					$rating_color = 'red';
				}
				$total_rating[]        = $rating_value / 10;
				$total_rating_author[] = $field_value;
				
				$result                .= '<div class="rating_row '.$oddeven.'">';
				$result                .= '<div class="ratings">';
				$result                .= '<div class="row_title color_dark_gray">' . $field['label'] . '</div>';
				$result                .= '<div class="rating_field ' . $rating_color . '">';
				$result                .= '<div class="rating_value" style="width:' . $rating_value . '%">';
				$result                .= '</div></div>';
				
				$result                .= '</div>';
				$result                .= '<span class="number color_dark_gray">' . round( $rating_value, 0 ) . '' . __( '%', 'sa_theme' ) . '</span>';
				$result                .= '</div>';
			}
					$result .= '</div>';
				$result .= '<div class="rating_page" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
					$data_percent = 100 / 5 * $print_total_round / 100;
				$result .= '<div class="rating_page_text review_average_round progress" id="rating_page_text_'.$post->ID.'" data-percent="'.$data_percent.'">';
				$result .= '
							<span class="inner color_dark_blue font_bold font_big" itemprop="ratingValue">' . $print_total_round . '</span>
	';

				$result .= '<meta itemprop="reviewCount" content="'.$get_ratings_count['count'].'" />';
				$result .= '<meta itemprop="itemReviewed" content="' . get_field( 'company_name',$post->ID ) . '" />';
				$result             .= '<meta itemprop="worstRating" content="0" />';
				$result             .= '<meta itemprop="bestRating" content="5" />';
				$result .= '</div>';
				$result .= '</div>';
				$result .= '</div>';
				}

			}
		} elseif($format == 'stars') {
			if ( $fields ) {
				$total_rating      = array();
				$get_ratings_count = get_comments_count( $post->ID, get_comment_rating_fields( $group_id, 'name' ) );
				foreach ( $fields as $field ) {
					$comments_rating = $get_ratings_count['ratings_total'][ $field['name'] ]['total'];
					$rating_total[] = $comments_rating;

				}
				$print_total = array_sum( $rating_total ) / count($rating_total);
				$print_total_round = number_format( $print_total, 1, '.', '' );
				$result = $print_total_round ;
			}
		} elseif($format == 'value') {
			if ( $fields ) {
				$total_rating      = array();
				$get_ratings_count = get_comments_count( $post->ID, get_comment_rating_fields( $group_id, 'name' ) );
				foreach ( $fields as $field ) {
					$comments_rating = $get_ratings_count['ratings_total'][ $field['name'] ]['total'];
					$rating_total[] = $comments_rating;

				}
				$print_total = array_sum( $rating_total ) / count($rating_total);
				$print_total_round = number_format( $print_total, 1, '.', '' );
				$result = $print_total_round;
			}
		}
		return $result;
	}

}


if(!function_exists('get_post_stars')) {
	function get_post_stars($group_id) {
		global $post;
		$result = '';
		//$result .= get_post_rating($group_id,'value');
		$percents = get_post_rating($group_id,'stars');
		$result .= '<div class="stars flex">';
		$y = 0;
		foreach (range(1, 5) as $i) {
			$y++;
			if($y <= $percents) {
					$class = 'full';
			} else {
				$class = 'empty';
				if($y - $percents == 0.5) {
					$class = 'half';
				} else {
					$class = 'empty';
				}
			}
				
			$result .= '<div class="'.$class.'"></div>';
		}
		$result .= '</div>';
		return $result;
	}
}



if(!function_exists('ajax_comments')) {
	add_action( 'wp_ajax_ajax_comments', 'ajax_comments' );
	add_action( 'wp_ajax_nopriv_ajax_comments', 'ajax_comments' );
	function ajax_comments() {
		$data = $_POST;
		$user_id = $data['user_id'];
		if ($user_id != "undefined") {
			$args_sorted = array(
				'user_id' => $user_id,
				'status' => 'approve',
			);
        } else {
			$args_sorted = array(
				//'user_id' => 9,
				'post_id' => $data['post_id'],
				'status' => 'approve',
				/*'meta_query' => array(
					'relation'		=> 'OR',
					array(
						'key'	 	=> 'is_abuse',
						'value'	  	=> '0',
						'compare' 	=> '=',
					),
					array(
						'key'     => 'is_abuse',
						'compare' => 'NOT EXISTS'
					)
				),*/
			);
        }

		$sort_type = $data['sort_type'];
		if($sort_type == 'new') {
			$args_sorted['orderby'] = 'comment_date_gmt';
			$args_sorted['order'] = 'ASC';
		} elseif($sort_type == 'old') {
			$args_sorted['orderby'] = 'comment_date_gmt';
			$args_sorted['order'] = 'DESC';
		} elseif($sort_type == 'best') {
			$args_sorted['meta_key'] = 'comment_rate';
			$args_sorted['orderby'] = 'meta_value';
			$args_sorted['order'] = 'ASC';
		}

		$comments_sorted = get_comments($args_sorted);

		$comments_top = '';
//		if ($user_id != "undefined") {
//			$get_ratings_count['count'] = count($comments_sorted);
//		} else {
//			$get_ratings_count = get_comments_count( $data['post_id'], get_comment_rating_fields( $data['rating_fields_group'], 'name' ) );
//        }

		$get_ratings_count['count'] = count($comments_sorted);
		$comments_top .= '<div class="white_block comments_top flex">';
		$comments_top .= print_js_links()['events'];
		$comments_top .= '<div class="comments_top_title font_uppercase font_bold color_dark_blue font_small">'.__('Отзывы','er_theme').'</div>';
		$comments_top .= '<div class="comments_top_count font_bold color_dark_gray">'.$get_ratings_count['count'].'</div>';
		if ($user_id == "undefined") {
			$comments_top .= '<div class="link_review_popup button button_green pointer">' . __( 'Оставить отзыв', 'er_theme' ) . '</div>';
		}
		$comments_top .= '<div class="comments_sorter">';
			$comments_top .= '<div class="comments_sorter_title color_dark_gray pointer dropdown flex">'.__('Отсортировать по','er_theme').'</div>';
			$comments_top .= '<ul>';
				if($sort_type == 'new') {
					$sort_new_active = ' active';
				} else {
					$sort_new_active = '';
				}
				if($sort_type == 'best') {
					$sort_best_active = ' active';
				} else {
					$sort_best_active = '';
				}
				if($sort_type == 'old') {
					$sort_old_active = ' active';
				} else {
					$sort_old_active = '';
				}
				$comments_top .= '<li class="sort_new color_dark_gray pointer'.$sort_new_active.'" data-sort-type="new">'.__('Сначала новые','er_theme').'</li>';
				$comments_top .= '<li class="sort_best color_dark_gray pointer'.$sort_best_active.'" data-sort-type="best">'.__('Сначала популярные','er_theme').'</li>';
				$comments_top .= '<li class="sort_old color_dark_gray pointer'.$sort_old_active.'" data-sort-type="old">'.__('Сначала старые','er_theme').'</li>';
			$comments_top .= '</ul>';
		$comments_top .= '</div>';
		$comments_top .= '</div>';

		echo $comments_top;

		wp_list_comments( array(
			'callback' => 'custom_comment_single',
			'per_page' => -1,
			'rating_fields' => get_comment_rating_fields($data['rating_fields_group'],'key'),
		),$comments_sorted);
		die;

	}
	
};


if(!function_exists('ajax_abuses')) {
	add_action( 'wp_ajax_ajax_abuses', 'ajax_abuses' );
	add_action( 'wp_ajax_nopriv_ajax_abuses', 'ajax_abuses' );
	function ajax_abuses() {
		$data = $_POST;
		$sort_type = $data['sort_type'];
		$user_id = $data['user_id'];
		if (($sort_type == 'user') || ($user_id != "undefined")) {
			$args_sorted = [
				'status'     => 'approve',
				'user_id'    => $user_id,
				'meta_query' => [
					'relation' => 'AND',
					[
						'key'     => 'is_abuse',
						'value'   => 1,
						'compare' => '='
					]
				]
			];
        } else {
			$args_sorted = array(
				'post_id' => $data['post_id'],
				'status' => 'approve',
				'meta_query' => array(
					'relation'		=> 'AND',
					array(
						'key'	 	=> 'is_abuse',
						'value'	  	=> 1,
						'compare' 	=> '=',
					),
				),
			);
        }

		if($sort_type == 'new') {
			$args_sorted['orderby'] = 'comment_date_gmt';
			$args_sorted['order'] = 'ASC';
		} elseif($sort_type == 'old') {
			$args_sorted['orderby'] = 'comment_date_gmt';
			$args_sorted['order'] = 'DESC';
		} elseif($sort_type == 'solved') {
			$args_sorted['meta_query'][] = array(
				'key'	 	=> 'abuse_state',
				'value'	  	=> 'solved',
				'compare' 	=> '=',
			);
		} elseif($sort_type == 'answered') {
			$args_sorted['meta_query'][] = array(
				'key'	 	=> 'abuse_state',
				'value'	  	=> 'progress',
				'compare' 	=> '=',
			);
		}
		
		$comments_sorted = get_comments($args_sorted);

		$comments_top = '';
		$comments_top .= '<div class="white_block comments_top flex">';
		$comments_top .= print_js_links()['events'];
		$comments_top .= '<div class="comments_top_title font_uppercase font_bold color_dark_blue font_small">'.__('Жалобы','er_theme').'</div>';
		$comments_top .= '<div class="comments_top_count font_bold color_dark_gray">'.count($comments_sorted).'</div>';
		if (($sort_type != 'user') && ($user_id == "undefined")) {
		    $comments_top .= '<div class="link_abuse_popup button button_violet pointer">'.__('Оставить жалобу','er_theme').'</div>';
		}
		$comments_top .= '<div class="abuses_sorter">';
			$comments_top .= '<div class="abuses_sorter_title color_dark_gray pointer dropdown flex">'.__('Отсортировать по','er_theme').'</div>';
			$comments_top .= '<ul>';
				if($sort_type == 'new') {
					$sort_new_active = ' active';
				} else {
					$sort_new_active = '';
				}
				if($sort_type == 'answered') {
					$sort_answered_active = ' active';
				} else {
					$sort_answered_active = '';
				}
				if($sort_type == 'solved') {
					$sort_solved_active = ' active';
				} else {
					$sort_solved_active = '';
				}
				if($sort_type == 'old') {
					$sort_old_active = ' active';
				} else {
					$sort_old_active = '';
				}
				$comments_top .= '<li class="sort_new color_dark_gray pointer'.$sort_new_active.'" data-sort-type="new">'.__('Сначала новые','er_theme').'</li>';
				$comments_top .= '<li class="sort_old color_dark_gray pointer'.$sort_old_active.'" data-sort-type="old">'.__('Сначала старые','er_theme').'</li>';
				$comments_top .= '<li class="sort_answered color_dark_gray pointer'.$sort_answered_active.'" data-sort-type="answered">'.__('Ответ получен','er_theme').'</li>';
				$comments_top .= '<li class="sort_solved color_dark_gray pointer'.$sort_solved_active.'" data-sort-type="solved">'.__('Проблема решена','er_theme').'</li>';

			$comments_top .= '</ul>';
		$comments_top .= '</div>';
		$comments_top .= '</div>';
		if (($sort_type == 'user') && (count($comments_sorted) == 0)) {

		} else {
			echo $comments_top;

			wp_list_comments( array(
				'callback' => 'custom_abuse_single',
				'per_page' => -1,
			),$comments_sorted);
        }

		die;
		
	}
	
};



function show_social_share_links($style,$link) {
	$result = '';
	$result .= '<div class="show_social_share_links style_'.$style.'">';
	$result .= '<ul>';
	$result .= '<li class="share_vk"><a href="http://vk.com/share.php?url='.$link.'"><i class="fab fa-vk"></i></li>';
	$result .= '<li class="share_ok"><a href="https://connect.ok.ru/offer?url='.$link.'"><i class="fab fa-odnoklassniki"></i></li>';
	$result .= '<li class="share_fb"><a href="http://www.facebook.com/sharer.php?u='.$link.'"><i class="fab fa-facebook-f"></i></li>';
	$result .= '<li class="share_twitter"><a href="http://twitter.com/share?url='.$link.'"><i class="fab fa-twitter"></i></li>';
	$result .= '</ul>';
	$result .= '</div>';
	
	return($result);
}

add_action( 'wp_ajax_popup_registration_final_social', 'popup_registration_final_social' );
add_action( 'wp_ajax_nopriv_popup_registration_final_social', 'popup_registration_final_social' );
 
function popup_registration_final_social() {
	$result = '';
	$social_username = $_POST['social_username'];
	$social_first_name = $_POST['first_name'];
	$social_last_name = $_POST['last_name'];
	$social_email = $_POST['email'];
	$provider = $_POST['provider'];
	$identifier = $_POST['identifier'];
	$urler = $_POST['urler'];
	$result .= '<div class="popup_container" id="popup_login">';
    $result .= '<div class="popup_banner border_radius_general box_shadow_general popupsociallogin">';
    $result .= '<a class="popup_close_button"></a>';
	
	$result .= '<script src="https://www.google.com/recaptcha/api.js"></script>';
	$result .= '<div class="popup_login_container popup_reg popup_reg_final">';
	$result .= '<div class="popup_login_left">';
	$result .= '<div class="regform__title">'.__('Завершите регистрацию на сайте','er_theme').'</div>';
	$result .= '<div class="social_links_message">';
	if($urler && $urler != '') {
		$result .= '<div class="social_links_image" style="background-image: url('.$urler.');"></div>';
	}
		$result .= '<div class="social_links_message_text">'.__('Вы вошли через','er_theme');
		if($provider == 'Vkontakte') { 
			$result .= ' '.__('VK','er_theme');
		} else {
			$result .= ' '.$provider;
		}
	if ($social_first_name != '' || $social_last_name != '') { 
		$result .= ' (';
	}
	if ($social_first_name != '') { 
		$result .= $social_first_name;
	}
	if ($social_last_name != '') { 
		$result .= ' '.$social_last_name;
	}
	if ($social_first_name != '' || $social_last_name != '') { 
		$result .= ')';
	}
	$result .= '. '.__('Завершите регистрацию или ','er_theme');
	$result .= '<a href="">'.__('войдите другим способом','er_theme').'';
	
	$result .= '</a>';
		$result .= '.</div>';
	$result .= '</div>';
	$result .= '<form class="regform regformsocial"  action="" method="post" id="regform">';
	$result .= '<div class="regform__line" style="display: none">
                            <input type="text" name="login" placeholder="Логин" ';
							
	if($social_username && $social_username != '') { 
		$result .= 'value="'.$social_username.'"';
	 };
	$result .= '/></div>';
	$result .= '<div class="regform__line" id="login_temp_input" style="display: none">
                            <span class="text-login" name="login">
                                <span for="logintemp">https://eto-razvod.ru/user/</span><input type="text" name="logintemp" placeholder="Создайте логин" id="logintemp"'; 
	if($social_username && $social_username != '') { 
		$result .= 'value="'.$social_username.'"'; 
	}; 

	$result .= '/></span><span class="text_after_login">Логин нельзя изменить позже. Используйте только латинские буквы и цифры, например: q, r, u, 1, 2, 3.</span></div>';
	$result .= '
                        <div class="regform__twocol regformsocial1" id="realfi">
                            <input type="text" name="realfirstname" placeholder="Имя"';
	if($social_first_name && $social_first_name != '') {
		$result .= 'value="'.$social_first_name.'"'; 
	}
	$result .= '/>
                            <input type="text" name="reallastname" placeholder="Фамилия"';
	if($social_last_name && $social_last_name != '') {
		$result .= 'value="'.$social_last_name.'"'; 
	}
	$result .= '/>
                        </div>
                        <div class="g-recaptcha  regformsocial5" data-sitekey="6Lf6dpIUAAAAALNlGI5LwOMRyOOFLLuSqoeBExgr" data-theme="light" style="transform:scale(0.8); transform-origin:0;"></div>
                        ';
	if($provider && $provider != '') {
		$result .= '<input type="hidden" name="social_provider" value="'.$provider.'" />';
		$result .= '<input type="hidden" name="provider" value="'.$provider.'" />';
	}
	if($identifier && $identifier != '') {
		$result .= '<input type="hidden" name="social_id" value="'.$identifier.'" />';
	}
	if($urler && $urler != '') {
		$result .= '<input type="hidden" name="urler" value="'.$urler.'" />';
	}
	$result .= '
                        <div class="regform__line regformsocial2">
                        
                            <input type="email" name="email" placeholder="E-mail"';
	if($social_email && $social_email != '') {
		$result .= 'value="'.$social_email.'"'; 
	}
	
	$pswinput = wp_generate_password();
	$result .= '/>
                      
                        </div>
                        
                        <div class="regform__line regformsocial3">
                            <input type="text" class="pwinput pwinput1" name="password" placeholder="Пароль" value="'.$pswinput.'" />
                        </div>
                        <div class="regform__line regformsocial4">
                            <input type="text" class="pwinput" name="password_repeat"  placeholder="Повторите пароль"  value="'.$pswinput.'" />
                        </div>
                    	<input type="submit" name="submit" value="'.__('Завершить регистрацию','er_theme').'" id="regbtn" class="regformsocial6" />
						';
	$result .= '</form>';
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
    $result .= '</div>';
	echo $result;
	echo '
    <script type="text/javascript">
	
    jQuery(document).ready(function($){
        $(\'#popup_comment_modal .popup_close_button\').on(\'click\', function(){
          $("#popup_comment_modal").empty();
      });
    });
	</script>
	<script type="text/javascript">
            $ = jQuery.noConflict();
            $(document).ready(function() {
            $(\'input#logintemp\').keyup(function() {
$(\'input[name="login"]\').val($(this).val());
})                

pschecke1 = 0;pschecke2 = 0;pschecke3 = 0;pschecke4 = 0;
                $("#regbtn").click(function(e) {
e.preventDefault();
                        login = $(\'input[name="login"]\').val();
                        email = $(\'input[name="email"]\').val();
                        password = $(\'input[name="password"]\').val();
                        password_repeat = $(\'input[name="password_repeat"]\').val();
                        firstname = $(\'input[name="realfirstname"]\').val();
                        lastname = $(\'input[name="reallastname"]\').val();
                        captcha = $(\'textarea[name="g-recaptcha-response"]\').val();
                        urler = $(\'input[name="urler"]\').val(); 
                        provider = $(\'input[name="provider"]\').val();
                        social_id = $(\'input[name="social_id"]\').val();

                        $(\'.regform__line input\').css(\'border\',\'none\');
                        $(\'.text-login\').css(\'border\',\'none\');
                        $(\'.passwordtestedb\').css(\'display\',\'none\');
                        $(\'.regform__twocol input\').css(\'border\',\'none\');
                        $(\'.passwordtested\').css(\'display\',\'none\');
                        
                        $.ajax({
                            url: "'.admin_url("admin-ajax.php").'",
                            type: \'POST\',
                            data: \'action=registerusermainnew2&login=\' + login+ \'&email=\' + email+ \'&password=\' + encodeURIComponent(password)+ \'&password_repeat=\' + encodeURIComponent(password_repeat)+ \'&captcha=\' + captcha+\'&firstname=\'+firstname+\'&lastname=\'+lastname+\'&urler=\'+urler+\'&provider=\'+provider+\'&social_id=\'+social_id,
                            beforeSend: function(xhr) {

                            },
                            success: function(data) {
                                result = $.parseJSON(data);
                                if (result.ok == 0) {
                                    texttroubles = \'\';
                                    jQuery.each( $.parseJSON(result.troubles), function( i, val ) {
                                    texttroubles += \'<span>\'+val+\'</span>\';
                                    });
                                    jQuery.each( $.parseJSON(result.statuses), function( i, val ) {
                                    $(\'input[type="\'+val+\'"],input[name="\'+val+\'"],.text-login[name="\'+val+\'"],input[attr-name-pw="\'+val+\'"]\').css(\'border\',\'2px solid #c30000\');
                                    });
                                    $(\'.passwordtestedb\').css(\'display\',\'block\');
                                    //$(\'.passwordtestedb\').html(texttroubles);
                                    $(\'.passwordchecker\').css(\'display\',\'none\');
                                    grecaptcha.reset();
                                } else {
                                    //window.location.replace("/user/");
									location.reload(true);
                                }     
                            }
                        });
});

    $(\'.regform__line .pwinput\').on("keypress keyup keydown", function() {
        //$(\'.showerbtnpassword\').css(\'display\',\'flex\');
        var pass = $(this).val();
        passlenght = $(this).val().length;
        if ((passlenght < 8) && (passlenght > 0)) {
            if ($(\'input[name="password"]\').val().length > 7) {

            } else {
                $(\'.passwordchecker .pschecke1\').text(\'Минимальная длина пароля 8 символов\');
                $(\'.passwordchecker .pschecke1\').css(\'display\',\'block\');
                $(\'.passwordchecker\').css(\'display\',\'block\');
                pschecke1 = 0;
            }

            
        } else {
            $(\'.passwordchecker .pschecke1\').css(\'display\',\'none\');
            pschecke1 = 1;
        }


        if (/[а-яА-ЯЁё]/.test($(this).val())) {
            $(\'.passwordchecker .pschecke2\').text(\'Удалите кириллические символы из пароля\');
            $(\'.passwordchecker .pschecke2\').css(\'display\',\'block\');
            //$(\'.passwordchecker span\').text(\'Удалите кириллические символы из пароля\');
            $(\'.passwordchecker\').css(\'display\',\'block\');
            pschecke2 = 0;
        } else {
            $(\'.passwordchecker .pschecke2\').css(\'display\',\'none\');
            pschecke2 = 1;
        }

        if ($(this).val().match(/\s/g)){
            $(\'.passwordchecker .pschecke3\').text(\'Удалите пробелы из пароля\');
            $(\'.passwordchecker .pschecke3\').css(\'display\',\'block\');
            $(\'.passwordchecker\').css(\'display\',\'block\');
            pschecke3 = 0;
        } else {
            $(\'.passwordchecker .pschecke3\').css(\'display\',\'none\');
            pschecke3 = 1;
        }
        if (encodeURIComponent($(\'input[name="password"]\').val()) == encodeURIComponent($(\'input[name="password_repeat"]\').val())) {
            $(\'.passwordchecker .pschecke4\').css(\'display\',\'none\');
            pschecke4 = 1;
        } else {
            $(\'.passwordchecker .pschecke4\').text(\'Введённые пароли не совпадают\');
            $(\'.passwordchecker .pschecke4\').css(\'display\',\'block\');
            $(\'.passwordchecker\').css(\'display\',\'block\');
            pschecke4 = 0;
        }
        if ((pschecke1 == 1) && (pschecke2 == 1) && (pschecke3 == 1) && (pschecke4 == 1)) {
            $(\'.passwordchecker\').css(\'display\',\'none\');
            $(\'.pwinput\').css(\'border\',\'none\');
        } else {
            $(\'.pwinput\').css(\'border\',\'2px solid rgb(195, 0, 0)\');
        }

    });

            });



            </script>
	
	';
	die;
}

add_action( 'wp_ajax_send_comment_abuse_form', 'send_comment_abuse_form' );
add_action( 'wp_ajax_nopriv_send_comment_abuse_form', 'send_comment_abuse_form' );

function send_comment_abuse_form() {
    global $wpdb;
    $mail_key = wp_generate_uuid4();
    $message = array();
    if($_POST['abuse_text'] != '') {
        $comment_id = $_POST['comment_id'];
        $headers = array(
            'From: Eto-Razvod <check@eto-razvod.info>',
            'content-type: text/html'
        );
        $subject = __('Жалоба на комментарий #','er_theme').$comment_id;
        $text = '';
        $cur_user_id = get_current_user_id();
        $user = get_user_by( 'id', $cur_user_id );
        $text .= __('Здравствуйте. Поступила жалоба на комментарий #','er_theme').$comment_id;
        $text .= __(' от пользователя ');
        $text .= $user->display_name.' ('.$user->user_email.')';
        $text .= __('. Ссылка на комментарий: ');
        $text .= get_comment_link($comment_id);
        $text .= __(' Текст жалобы: ','er_theme');
        $text .= $_POST['abuse_text'];
        $text .= '<img src="https://eto-razvod.ru/engine/mail_update_status.php?key='.$mail_key.'" style="width:1px; height:1px;" />';

        $mailResult = false;
        $mailResult = wp_mail( 'info@eto-razvod.ru', $subject, $text, $headers );
        if($mailResult == true) {
            $message['status'] = 'ok';
            $message['message'] = __('Спасибо! Ваша жалоба успешно отправлена.','er_theme');

            date_default_timezone_set( 'Europe/Moscow' );
            $mydb = new wpdb('sendmail','hsd8SGDDdhus','sendmails','localhost');
            $user = get_user_by( 'ID', $cur_user_id );
            $user2 = get_userdata($user->ID);
            //$mail_key = wp_generate_uuid4();

            $mydb->insert(
                'mails',
                array('status'=> 'not_sent','reg_date' => $user2->data->user_registered,'user_id' => $user2->data->ID, 'mail_type' => 'send_comment_abuse_form','mail_key' => $mail_key, 'sent' => date('Y-m-d H:i:s')),
                array( '%s', '%s', '%s','%s','%s','%s')
            );

            $mail = $mydb->get_results("select * from mails WHERE mail_key = '$mail_key'");

            $mydb->update(
                'mails',
                array('status'=> 'sent'),
                array( 'id' => $mail[0]->id ),
                array( '%s' )
            );
            $mydb->update(
                'mails',
                array('updated'=> date('Y-m-d H:i:s')),
                array( 'id' => $mail[0]->id ),
                array( '%s' )
            );
        } else {
            $message['status'] = 'error';
            $message['message'] = __('Ошибка отправки жалобы. Пожалуйста, сообщите администратору на info@eto-razvod.ru.','er_theme');
        }
    } else {
        $message['status'] = 'error';
        $message['message'] = __('Пожалуйста, опишите суть жалобы','er_theme');
    }
    $result = json_encode($message);
    echo $result;
    die;
};

add_action( 'wp_ajax_comment_abuse_form', 'comment_abuse_form' );
add_action( 'wp_ajax_nopriv_comment_abuse_form', 'comment_abuse_form' );
 
function comment_abuse_form() {
	$result = '';
	$comment_id = $_POST['comment_id'];
	$message = array();
	$result .= '<div class="popup_container" id="popup_abuse">';
    $result .= '<div class="popup_banner border_radius_general box_shadow_general">';
    $result .= '<a class="popup_close_button"></a>';
	//$result .= 'abuse for '.$comment_id;
	$result .= '<div class="regform__title">'.__('Отправить жалобу на комментарий','er_theme').'</div>';
	$comment = get_comment($comment_id);
	$attachment_id = get_field('photo_profile', 'user_'. $comment->user_id );
	$result .= '<div class="abuse_form_comment">';
	$result .= '<div class="comment_header">';
	$result .= '<div class="comment_avatar"';
	if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') { $result .= 'style="background-image: url('.$attachment_id['sizes']['thumbnail'].')"'; };
	$result .= '></div>';
	$comment_author = get_userdata( $comment->user_id );
	$result .= '<div class="comment_meta">';
	if($comment_author->first_name && !$comment_author->last_name) { 
		$author_name = $comment_author->first_name; 
	} elseif(!$comment_author->first_name && $comment_author->last_name) { 
		$author_name = $comment_author->last_name; 
	} elseif($comment_author->first_name && $comment_author->last_name) { 
		$author_name = $comment_author->first_name.' '.$comment_author->last_name; 
	} else {
		$author_name = $comment_author->user_nicename; 
	} 
  $labelpro = '';
  if (    (    (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84175) || (get_field('services_user_services','user_'.$comment->user_id) == 84175) || (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84178) || (get_field('services_user_services','user_'.$comment->user_id) == 84178)    )    ) {
    $namep = get_field('services_user_services','user_'.$comment->user_id)[0];
    if (get_field('services_user_services','user_'.$comment->user_id)[0] == '') {
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    } else {
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    }
  } else {
    $labelpro = '';
  }

	$result .= '<span class="comment-author">'.$author_name.' '.$labelpro.'</span>';
    $result .= '<span class="comment-date">'.get_comment_date('j F Y в H:i',$comment_id).'</span>';
    $result .= '</div>';
	$result .= '</div>';
	$result .= '<div class="comment-content"><div class="comment_text">'.$comment->comment_content.'</div></div>';
	$result .= '</div>';
	$result .= '<form class="comment_abuse_send_form" id="form_abuse_'.$comment_id.'" method="post" action="'.admin_url('admin-ajax.php').'">';
	$result .= '<div class="form_textarea"><textarea name="abuse_text" placeholder="'.__('Опишите Вашу жалобу...','er_theme').'"></textarea></div>';
	$result .= '<input type="hidden" name="action" value="send_comment_abuse_form">';
	$result .= '<input type="hidden" name="comment_id" value="'.$comment_id.'">';
	$result .= '<div class="form_submit"><input type="submit" class="submit_comment_abuse" name="submit_comment_abuse" value="'.__('Отправить жалобу','er_theme').'" />';
	$result .= '</form>';
	$result .= '</div>';
	$result .= '</div>';
	echo $result;
	echo '
    <script type="text/javascript">
	
    jQuery(document).ready(function($){
        $(\'#popup_comment_modal .popup_close_button\').on(\'click\', function(){
          $("#popup_comment_modal").empty();
      });
	  $(\'.comment_abuse_send_form\').on(\'submit\', function(e) {
			e.preventDefault();

			var $form = $(this);
			var form_id = $form.attr(\'id\');
			//alert(form_id);
			$.post($form.attr(\'action\'), $form.serialize(), function(data) {
				//alert(data);
				result = JSON.parse(data);
				$( "#form_abuse_'.$comment_id.'" ).append( \'<p class="spam_result_message style_\'+result.status+\'">\'+result.message+\'</p>\' );
							$(\'.spam_result_message\').delay(5000).hide(0);
				if(result.status === \'ok\') {
					$( "#form_abuse_'.$comment_id.' .form_textarea" ).remove();
					$( "#form_abuse_'.$comment_id.' .form_submit" ).remove();
					setTimeout(function() {
					  $(\'#popup_comment_modal\').empty();
					}, 3000);
				}
			});
		});
    });
	
	</script>';
	die;
}

if(!function_exists('comment_rate_action')) {
	add_action( 'wp_ajax_comment_rate_action', 'comment_rate_action' );
	add_action( 'wp_ajax_nopriv_comment_rate_action', 'comment_rate_action' );

	function comment_rate_action() {
		$data = $_POST;
		$result = array();
		$cookie_plus = 'rate_plus_'.$data['comment_id'];
		$cookie_minus = 'rate_minus_'.$data['comment_id'];
		$plus_exists = check_cookie($cookie_plus);
		$minus_exists = check_cookie($cookie_minus);
		$current = get_field('comment_rate', 'comment_'.$data['comment_id']);
		if(!$current || $current == '') {
			$current = 0;
		}
		if($data['rate_action'] == 'plus' && $plus_exists == 'no' && $minus_exists == 'no') {
			$result['status'] = set_cookie($cookie_plus,'31556926');
			$new_value = $current + 1;
			update_field('comment_rate', $new_value, 'comment_'.$data['comment_id']);
			$result['new_value'] = $new_value;
		} elseif($data['rate_action'] == 'plus' && $plus_exists == 'yes' && $minus_exists == 'no' || $data['rate_action'] == 'minus' && $plus_exists == 'no' && $minus_exists == 'yes') {
			$result['status'] = 'error';
			$result['message'] = __('Вы уже голосовали за этот комментарий','er_theme');
			$result['new_value'] = $current;
		} elseif($data['rate_action'] == 'minus' && $plus_exists == 'yes' && $minus_exists == 'no') {
			unset($_COOKIE[$cookie_plus]);
			setcookie($cookie_plus, '', time() - 3600, '/');
			$result['status'] = 'cancel_plus';
			$new_value = $current - 1;
			update_field('comment_rate', $new_value, 'comment_'.$data['comment_id']);
			$result['new_value'] = $new_value;
		} elseif($data['rate_action'] == 'plus' && $plus_exists == 'no' && $minus_exists == 'yes') {
			unset($_COOKIE[$cookie_minus]);
			setcookie($cookie_minus, '', time() - 3600, '/');
			$result['status'] = 'cancel_minus';
			$new_value = $current + 1;
			update_field('comment_rate', $new_value, 'comment_'.$data['comment_id']);
			$result['new_value'] = $new_value;
		} elseif($data['rate_action'] == 'minus' && $plus_exists == 'no' && $minus_exists == 'no') { 
			$result['status'] = set_cookie($cookie_minus,'31556926');
			$new_value = $current - 1;
			update_field('comment_rate', $new_value, 'comment_'.$data['comment_id']);
			$result['new_value'] = $new_value;
		}
		if($result['new_value'] == 0) {
			$result['new_value_type'] = 'neutral';
		} elseif($result['new_value'] > 0) {
			$result['new_value_type'] = 'positive';
			$result['new_value'] = '+'.$result['new_value'];
		} elseif($result['new_value'] < 0) {
			$result['new_value_type'] = 'negative';
		}
		echo json_encode($result);
		die;
	}
}


add_action( 'wp_ajax_update_page_rate_cackle', 'update_page_rate_cackle' );
add_action( 'wp_ajax_nopriv_update_page_rate_cackle', 'update_page_rate_cackle' );
 
function update_page_rate_cackle() {
	$data = $_POST;
	print_r($data);
	update_field('page_rate_count',$data['count'],$data['post_id']);
	update_field('page_rate_rating',$data['rating'],$data['post_id']);
	die;
}

add_action( 'wp_ajax_resort_comments', 'resort_comments' );
add_action( 'wp_ajax_nopriv_resort_comments', 'resort_comments' );
 
function resort_comments() {
	$args_sorted = array(
		'post_id' => $_POST['post_id'],
		'status' => 'approve',
	);
	$sort_type = $_POST['sort_type'];
	if($sort_type == 'new') {
		$args_sorted['orderby'] = 'comment_date_gmt';
		$args_sorted['order'] = 'ASC';
	} elseif($sort_type == 'old') {
		$args_sorted['orderby'] = 'comment_date_gmt';
		$args_sorted['order'] = 'DESC';
	} elseif($sort_type == 'best') {
		$args_sorted['meta_key'] = 'comment_rate';
		$args_sorted['orderby'] = 'meta_value';
		$args_sorted['order'] = 'ASC';
	}
	$comments_sorted = get_comments($args_sorted);
	wp_list_comments( array(
		'callback' => 'custom_comment_single',
		'rating_fields' => get_comment_rating_fields($_POST['rating_fields_group'],'key'),
	),$comments_sorted);
	?>
	<script type="text/javascript">
    jQuery(document).ready(function($){
		$('a[href*=".jpg"],a[href*=".png"],a[href*=".jpeg"],a[href*=".gif"]').click(function( event ) {
            event.preventDefault();
            var img_url = this.href;
            $.ajax({
                url: "<?php echo admin_url("admin-ajax.php"); ?>",
                type: "POST",
                data: "action=show_popup_img&img_url="+img_url,
                beforeSend: function(xhr) {

                },
                success: function( data ) {
                    $("#popup_img_modal").html(data);
                    $("#popup_img_modal .popup_container").show();
                }
            });
        });
		$('.comment-body').hover(function() {
			//alert('sdfdsf');
			var header_hovered = $(this).attr("data-body-id");
			var comment_id = $(this).closest('li').attr('data-commentid');
			//alert(header_hovered);
			//alert(comment_id);
			$('.hovered_'+comment_id).toggleClass('visible');
		});
		$('.comment_avatar, .comment-author').click(function() {
			<?php if(!is_user_logged_in()) { ?>
			$.ajax({
						url: "<?php echo admin_url("admin-ajax.php"); ?>",
						type: "POST",
						data: "action=popup_login",
						beforeSend: function(xhr) {

						},
						success: function( data ) {
							$("#popup_comment_modal").html(data);
							$("#popup_comment_modal .popup_container").show();
						}
					});
			<?php } else { ?>
			datalink = $(this).attr('data-link');
			if (datalink != '') {
			//window.location.replace(''+datalink+'');
			window.open(datalink);
			}
			<?php }?>
			})
		$('.comment_more_actions_link_spam').click(function() {
			
			<?php if(!is_user_logged_in()) { ?>
			$.ajax({
						url: "<?php echo admin_url("admin-ajax.php"); ?>",
						type: "POST",
						data: "action=popup_login",
						beforeSend: function(xhr) {

						},
						success: function( data ) {
							$("#popup_comment_modal").html(data);
							$("#popup_comment_modal .popup_container").show();
						}
					});
			<?php } else { ?>
			var comment_id = $(this).closest('li.comment').attr('data-commentid');
			//alert(comment_id);
			$.ajax({
						url: "<?php echo admin_url("admin-ajax.php"); ?>",
						type: "POST",
						data: "action=comment_spam_form&comment_id="+comment_id,
						beforeSend: function(xhr) {

						},
						success: function( data ) {
							result = JSON.parse(data);
							$('.comment_more_actions_links_'+comment_id).toggleClass('visible');
							$( ".comment_text_"+comment_id ).append( '<p class="spam_result_message style_'+result.status+'">'+result.message+'</p>' );
							$('.spam_result_message').delay(5000).hide(0);
							
						}
					});
			<?php } ?>
		});
		$('.comment_more_actions_link_abuse').click(function() {
			
			<?php if(!is_user_logged_in()) { ?>
			$.ajax({
						url: "<?php echo admin_url("admin-ajax.php"); ?>",
						type: "POST",
						data: "action=popup_login",
						beforeSend: function(xhr) {

						},
						success: function( data ) {
							$("#popup_comment_modal").html(data);
							$("#popup_comment_modal .popup_container").show();
						}
					});
			<?php } else { ?>
			var comment_id = $(this).closest('li.comment').attr('data-commentid');
			$.ajax({
						url: "<?php echo admin_url("admin-ajax.php"); ?>",
						type: "POST",
						data: "action=comment_abuse_form&comment_id="+comment_id,
						beforeSend: function(xhr) {

						},
						success: function( data ) {
							$("#popup_comment_modal").html(data);
							$("#popup_comment_modal .popup_container").show();
						}
					});
			<?php } ?>
		});
		$('.comment_permalink').click(function() {
			var comment_id = $(this).closest('li').attr('data-commentid');
			//alert(comment_id);
			$.ajax({
                url: "<?php echo admin_url("admin-ajax.php"); ?>",
                type: "POST",
                data: "action=comment_popup_actions&action_type=comment_permalink&comment_id="+comment_id,
                beforeSend: function(xhr) {

                },
                success: function( data ) {
					$("#popup_comment_modal").html(data);
                    $("#popup_comment_modal .popup_container").show();
					$("#popup_comment_modal input[type='text']").select();
                }
            });
		});
		$('.comment_share').click(function() {
			var comment_id = $(this).closest('li').attr('data-commentid');
			$.ajax({
                url: "<?php echo admin_url("admin-ajax.php"); ?>",
                type: "POST",
                data: "action=comment_popup_actions&action_type=comment_share&comment_id="+comment_id,
                beforeSend: function(xhr) {

                },
                success: function( data ) {
					//alert(data);
					$("#popup_comment_modal").html(data);
                    $("#popup_comment_modal .popup_container").show();
                }
            });
		});
		$('.comment_more_actions').click(function() {
			var comment_id = $(this).closest('li').attr('data-commentid');
			//alert(comment_id);
			$('.comment_more_actions_links_'+comment_id).toggleClass('visible');
		});
        $('a.comment-reply-link').click(function() {
            var post_id = <?php echo $_POST['post_id']; ?>;
            var parent_id = $(this).attr("data-commentid");
            var appendto = $(this).attr("data-appendto");
            $.ajax({
                url: "<?php echo admin_url("admin-ajax.php"); ?>",
                type: "POST",
                data: "action=show_reply_form&form_id=reply_form&post_id="+post_id+"&parent_id="+parent_id,
                success: function( data ) {
                    $( "li .comment_form" ).remove();                    
                    $( "#comment-"+appendto+" > .comment-body.body_"+appendto+"" ).after( data );
                    //$( data ).first().after( "#comment-"+appendto+" .comment-body" );
                }
            });
        });
		$('.comment_total_rating').click(function() {
			var id = $(this).closest('li').attr("id");
			$('#'+id+' .comment_rating_details').toggleClass('visible');
		});
		$('.comment_rate .rate_action').click(function() {
			var cookie_class = $(this).attr("data-commentaction");
		   // alert(cookie_class);
			var id = $(this).closest('li').attr("id");
			var id_num = $(this).closest('li').attr("data-commentid");
			var comment_action = $(this).attr("data-commentaction");
			var comment_number_container = $(this).closest('.comment_rate').attr("id");
			$.ajax({
				url: "<?php echo admin_url("admin-ajax.php"); ?>",
				type: "POST",
				data: "action=set_cookie_rate&cookie_id="+cookie_class+"_"+id_num+"&cookie_time="+172800,
				success: function( data ) {
				   // alert( data );
					var cookies_exist = data;
					if (cookies_exist == "no") {
						$.ajax({
							url: "<?php echo admin_url("admin-ajax.php"); ?>",
							type: "POST",
							dataType: "text json",
							data: "action=update_comment_rate&id="+id+"&comment_id="+id_num+"&comment_action="+comment_action,
							beforeSend: function(xhr) {

							},
							success: function( data ) {
								//alert( data );
								$('#'+comment_number_container+' .rate_number_container span').removeClass();
								$('#'+comment_number_container+' .rate_number_container span').addClass('rate_number '+data['new_class']);
								$('#'+comment_number_container+' .rate_number').html(data['new_rate']);
							}
						});
					} else {
						alert('<?php _e('Вы уже голосовали за этот комментарий!', 'sa_theme'); ?>');
					}
				}
			});


		});
	});
	</script>
	<?php
	die;
}

add_action( 'wp_ajax_comment_spam_form', 'comment_spam_form' );
add_action( 'wp_ajax_nopriv_comment_spam_form', 'comment_spam_form' );

function comment_spam_form() {
    //print_r($_POST);
    global $wpdb;
    $mail_key = wp_generate_uuid4();
    $comment_id = $_POST['comment_id'];
    $message = array();
    $headers = array(
        'From: Eto-Razvod <check@eto-razvod.info>',
        'content-type: text/html'
    );
    $subject = __('Жалоба на комментарий #','er_theme').$comment_id;
    $text = '';

    $cur_user_id = get_current_user_id();
    $user = get_user_by( 'id', $cur_user_id );
    $text .= __('Здравствуйте. Поступила жалоба на спам в комментарии #','er_theme').$comment_id;
    $text .= __(' от пользователя ');
    $text .= $user->display_name.' ('.$user->user_email.')';
    $text .= __('. Ссылка на комментарий: ');
    $text .= get_comment_link($comment_id);
    $text .= '<img src="https://eto-razvod.ru/engine/mail_update_status.php?key='.$mail_key.'" style="width:1px; height:1px;" />';

    $mailResult = false;
    $mailResult = wp_mail( 'info@eto-razvod.ru', $subject, $text, $headers );
    if($mailResult == true) {
        $message['status'] = 'ok';
        $message['message'] = __('Жалоба на спам отправлена','er_theme');

        date_default_timezone_set( 'Europe/Moscow' );
        $mydb = new wpdb('sendmail','hsd8SGDDdhus','sendmails','localhost');
        $user = get_user_by( 'ID', $cur_user_id );
        $user2 = get_userdata($user->ID);
        //$mail_key = wp_generate_uuid4();

        $mydb->insert(
            'mails',
            array('status'=> 'not_sent','reg_date' => $user2->data->user_registered,'user_id' => $user2->data->ID, 'mail_type' => 'comment_spam_form','mail_key' => $mail_key, 'sent' => date('Y-m-d H:i:s')),
            array( '%s', '%s', '%s','%s','%s','%s')
        );

        $mail = $mydb->get_results("select * from mails WHERE mail_key = '$mail_key'");

        $mydb->update(
            'mails',
            array('status'=> 'sent'),
            array( 'id' => $mail[0]->id ),
            array( '%s' )
        );
        $mydb->update(
            'mails',
            array('updated'=> date('Y-m-d H:i:s')),
            array( 'id' => $mail[0]->id ),
            array( '%s' )
        );

    } else {
        $message['status'] = 'error';
        $message['message'] = __('Ошибка отправки жалобы. Пожалуйста, сообщите администратору на info@eto-razvod.ru.','er_theme');
    }
    $result = json_encode($message);
    echo $result;
    die;
}

add_action( 'wp_ajax_comment_subscribtion', 'comment_subscribtion' );
add_action( 'wp_ajax_nopriv_comment_subscribtion', 'comment_subscribtion' );
 
function comment_subscribtion() {
	//print_r($_POST);
	$user_id = get_current_user_id();
	//echo $user_id;
	$message = array();
	$message['status'] = 'error';
	if($_POST['subscribe_action'] == 'unsubscribed') {
		$current_posts = get_field('comments_subscribed','user_'.$user_id);
		if(!in_array($_POST['post_id'],$current_posts)) {
			$current_posts[] = $_POST['post_id'];
			update_field('comments_subscribed',$current_posts, 'user_'.$user_id);
			$message['status'] = 'ok';
			$message['new_result'] = 'subscribed';
		}
	} elseif($_POST['subscribe_action'] == 'subscribed') {
		$current_posts = get_field('comments_subscribed','user_'.$user_id);
		if (($key = array_search($_POST['post_id'], $current_posts)) !== false) {
			unset($current_posts[$key]);
			update_field('comments_subscribed',$current_posts, 'user_'.$user_id);
			$message['status'] = 'ok';
			$message['new_result'] = 'unsubscribed';
		}
	}
	$result = json_encode($message);
	echo $result;
	die;
}

add_action( 'wp_ajax_popup_registration', 'popup_registration' );
add_action( 'wp_ajax_nopriv_popup_registration', 'popup_registration' );
 
function popup_registration() {
	$result = '';
	$result .= '<div class="popup_container" id="popup_login">';
    $result .= '<div class="popup_banner border_radius_general box_shadow_general">';
    $result .= '<a class="popup_close_button"></a>';
	$result .= '<ul class="mobile_auth_links">';
	$result .= '<li class="tab_auth">'.__('Вход','er_theme').'</li>';
	$result .= '<li class="active">'.__('Регистрация','er_theme').'</li>';
	$result .= '</ul>';
	$result .= '<script src="https://www.google.com/recaptcha/api.js"></script>';
	$result .= '<div class="popup_login_container popup_reg">';
		$result .= '<div class="popup_login_left">';
			$result .= '<div class="regform__title">'.__('Регистрация по E-mail','er_theme').'</div>';
			$result .= '
			<form class="regform"  action="" method="post" id="regform">
						<div class="regform__line" id="login_temp_input">
                            <span class="text-login" name="login">
                                <span for="logintemp">https://eto-razvod.ru/user/</span><input type="text" name="logintemp" placeholder="Создайте логин" id="logintemp"  />
                            </span>
                            
                        </div>
						<span class="text_after_login">Логин нельзя изменить позже. Используйте только латинские буквы и цифры, например: q, r, u, 1, 2, 3.</span>
                        <!--<div class="reg_popup_form_left">-->
                        <div class="regform__line" style="display: none" id="loginwithclass">
                            <input type="text" name="login" placeholder="Логин">
                        </div>
                        
                        <div class="regform__twocol" id="realfi">
                            <input type="text" name="realfirstname" placeholder="Имя" />
                            <input type="text" name="reallastname" placeholder="Фамилия" />
                        </div>
                        <!--div class="g-recaptcha" data-sitekey="6Lf6dpIUAAAAALNlGI5LwOMRyOOFLLuSqoeBExgr" data-theme="light" style="transform:scale(0.8); transform-origin:0;"></div-->
                        <!--</div>-->
						<!--<div class="reg_popup_form_right">-->
                        <div class="regform__line" id="emailwithclass">
                        
                            <input type="email" name="email" placeholder="E-mail" />
                      
                        </div>
                        <div class="pswwrapperwithclass">
                        <div class="regform__line" id="passwordwithclass">
                            <input type="password" class="pwinput pwinput1" name="password"  attr-name-pw="password" placeholder="Пароль"><span class="showerbtnpassword" onclick="showfuncnew2()" style="display: none;"><i class="far fa-eye"></i></span>
                        </div>
                        <div class="regform__line" id="password_repeatwithclass">
                            <input type="password" class="pwinput" name="password_repeat" attr-name-pw="password" placeholder="Повторите пароль"><span class="showerbtnpassword" onclick="showfuncnew2()" style="display: none;"><i class="far fa-eye"></i></span>
                        </div>
                        </div>
                        <div class="g-recaptcha" data-sitekey="6Lf6dpIUAAAAALNlGI5LwOMRyOOFLLuSqoeBExgr" data-theme="light" style="transform:scale(0.8); transform-origin:0;"></div>
                    	<input type="submit" name="submit" value="Зарегистрироваться" id="regbtn" />
						<!--</div>-->
						
                        <span class="passwordchecker" style="display: none;"><span class="titlerb">Текущие ошибки ввода пароля:</span><span class="pschecke1"></span><span class="pschecke2"></span><span class="pschecke3"></span><span class="pschecke4"></span></span>
                        <span class="passwordtestedb" style="display: none;"></span>
                        
                        
                    </form>
			
			';
	
			
		$result .= '</div>';
		$result .= '<div class="popup_login_right">';
			$result .= '<div class="popup_login_left_left">';
			$result .= '<div class="popup_login_title">'.__('Вход через соц. сети','er_theme').'</div>';
			$result .= '<ul class="social_login_links">';
			$result .= '<li class="Google"><a onclick="javascript:auth_popup(\'Google\');"></a></li>';
			$result .= '<li class="Vkontakte"><a onclick="javascript:auth_popup(\'Vkontakte\');"></a></li>';
			$result .= '<li class="Yandex"><a onclick="javascript:auth_popup(\'Yandex\');"></a></li>';
			$result .= '<li class="Odnoklassniki"><a onclick="javascript:auth_popup(\'Odnoklassniki\');"></a></li>';
			$result .= '</ul>';
			$result .= '</div>';
			$result .= '<div class="popup_login_right_right">';
			$result .= '<div class="popup_login_title">'.__('У вас уже есть аккаунт?','er_theme').'</div>';
			$result .= '<div class="create_link">'.__('Войти по E-mail и паролю','er_theme').'</div>';
			$result .= '</div>';
		$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
    $result .= '</div>';
	echo $result;
	echo '
    <script type="text/javascript">
	
    jQuery(document).ready(function($){
        $(\'#popup_comment_modal .popup_close_button\').on(\'click\', function(){
          $("#popup_comment_modal").empty();
      });
    });
	</script>
	<script type="text/javascript">
            $ = jQuery.noConflict();
			$(document).ready(function() { 
				$(".create_link").click(function() {
					//alert("reg");
					$("#popup_comment_modal").empty();
					$.ajax({
						url: "'.admin_url("admin-ajax.php").'",
						type: "POST",
						data: "action=popup_login",
						beforeSend: function(xhr) {

						},
						success: function( data ) {
							$("#popup_comment_modal").html(data);
							$("#popup_comment_modal .popup_container").show();
						}
					});
				});
				
				$(".tab_auth").click(function() {
					//alert("reg");
					$("#popup_comment_modal").empty();
					$.ajax({
						url: "'.admin_url("admin-ajax.php").'",
						type: "POST",
						data: "action=popup_login",
						beforeSend: function(xhr) {

						},
						success: function( data ) {
							$("#popup_comment_modal").html(data);
							$("#popup_comment_modal .popup_container").show();
						}
					});
				});
				
			});
	</script>
	
	<script type="text/javascript">
            $ = jQuery.noConflict();
            $(document).ready(function() {
            $(\'input#logintemp\').keyup(function() {
$(\'input[name="login"]\').val($(this).val());
})                

pschecke1 = 0;pschecke2 = 0;pschecke3 = 0;pschecke4 = 0;
                $("#regbtn").click(function(e) {
e.preventDefault();
                        login = $(\'input[name="login"]\').val();
                        email = $(\'input[name="email"]\').val();
                        password = $(\'input[name="password"]\').val();
                        password_repeat = $(\'input[name="password_repeat"]\').val();
                        firstname = $(\'input[name="realfirstname"]\').val();
                        lastname = $(\'input[name="reallastname"]\').val();
                        captcha = $(\'textarea[name="g-recaptcha-response"]\').val();
                        urler = $(\'input[name="urler"]\').val(); 
                        provider = $(\'input[name="provider"]\').val();
                        social_id = $(\'input[name="social_id"]\').val();

                        $(\'.regform__line input\').css(\'border\',\'none\');
                        $(\'.text-login\').css(\'border\',\'none\');
                        $(\'.passwordtestedb\').css(\'display\',\'none\');
                        $(\'.regform__twocol input\').css(\'border\',\'none\');
                        $(\'.passwordtested\').css(\'display\',\'none\');
                        
                        $.ajax({
                            url: "'.admin_url("admin-ajax.php").'",
                            type: \'POST\',
                            data: \'action=registerusermainnew2&login=\' + login+ \'&email=\' + email+ \'&password=\' + encodeURIComponent(password)+ \'&password_repeat=\' + encodeURIComponent(password_repeat)+ \'&captcha=\' + captcha+\'&firstname=\'+firstname+\'&lastname=\'+lastname+\'&urler=\'+urler+\'&provider=\'+provider+\'&social_id=\'+social_id,
                            beforeSend: function(xhr) {

                            },
                            success: function(data) {
                                result = $.parseJSON(data);
                                if (result.ok == 0) {
                                    texttroubles = \'\';
                                    jQuery.each( $.parseJSON(result.troubles), function( i, val ) {
                                    texttroubles += \'<span>\'+val+\'</span>\';
                                    });
                                    jQuery.each( $.parseJSON(result.statuses), function( i, val ) {
                                    $(\'input[type="\'+val+\'"],input[name="\'+val+\'"],.text-login[name="\'+val+\'"],input[attr-name-pw="\'+val+\'"]\').css(\'border\',\'2px solid #c30000\');
                                    });
                                    $(\'.passwordtestedb\').css(\'display\',\'block\');
                                    //$(\'.passwordtestedb\').html(texttroubles);
                                    $(\'.passwordchecker\').css(\'display\',\'none\');
                                    grecaptcha.reset();
                                } else {
                                    //window.location.replace("/user/");
									location.reload(true);
                                }     
                            }
                        });
});

    $(\'.regform__line .pwinput\').on("keypress keyup keydown", function() {
        //$(\'.showerbtnpassword\').css(\'display\',\'flex\');
        var pass = $(this).val();
        passlenght = $(this).val().length;
        if ((passlenght < 8) && (passlenght > 0)) {
            if ($(\'input[name="password"]\').val().length > 7) {

            } else {
                $(\'.passwordchecker .pschecke1\').text(\'Минимальная длина пароля 8 символов\');
                $(\'.passwordchecker .pschecke1\').css(\'display\',\'block\');
                $(\'.passwordchecker\').css(\'display\',\'block\');
                pschecke1 = 0;
            }

            
        } else {
            $(\'.passwordchecker .pschecke1\').css(\'display\',\'none\');
            pschecke1 = 1;
        }


        if (/[а-яА-ЯЁё]/.test($(this).val())) {
            $(\'.passwordchecker .pschecke2\').text(\'Удалите кириллические символы из пароля\');
            $(\'.passwordchecker .pschecke2\').css(\'display\',\'block\');
            //$(\'.passwordchecker span\').text(\'Удалите кириллические символы из пароля\');
            $(\'.passwordchecker\').css(\'display\',\'block\');
            pschecke2 = 0;
        } else {
            $(\'.passwordchecker .pschecke2\').css(\'display\',\'none\');
            pschecke2 = 1;
        }

        if ($(this).val().match(/\s/g)){
            $(\'.passwordchecker .pschecke3\').text(\'Удалите пробелы из пароля\');
            $(\'.passwordchecker .pschecke3\').css(\'display\',\'block\');
            $(\'.passwordchecker\').css(\'display\',\'block\');
            pschecke3 = 0;
        } else {
            $(\'.passwordchecker .pschecke3\').css(\'display\',\'none\');
            pschecke3 = 1;
        }
        if (encodeURIComponent($(\'input[name="password"]\').val()) == encodeURIComponent($(\'input[name="password_repeat"]\').val())) {
            $(\'.passwordchecker .pschecke4\').css(\'display\',\'none\');
            pschecke4 = 1;
        } else {
            $(\'.passwordchecker .pschecke4\').text(\'Введённые пароли не совпадают\');
            $(\'.passwordchecker .pschecke4\').css(\'display\',\'block\');
            $(\'.passwordchecker\').css(\'display\',\'block\');
            pschecke4 = 0;
        }
        if ((pschecke1 == 1) && (pschecke2 == 1) && (pschecke3 == 1) && (pschecke4 == 1)) {
            $(\'.passwordchecker\').css(\'display\',\'none\');
            $(\'.pwinput\').css(\'border\',\'none\');
        } else {
            $(\'.pwinput\').css(\'border\',\'2px solid rgb(195, 0, 0)\');
        }

    });

            });



            </script>
	';
	die;
}

add_action( 'wp_ajax_popup_recover', 'popup_recover' );
add_action( 'wp_ajax_nopriv_popup_recover', 'popup_recover' );
 
function popup_recover() {
  $result = '';
  $result .= '<div class="popup_container" id="popup_login">';
    $result .= '<div class="popup_banner border_radius_general box_shadow_general">';
    $result .= '<a class="popup_close_button"></a>';
  $result .= '<script src="https://www.google.com/recaptcha/api.js"></script>';
  $result .= '<div class="regform__title">'.__('Восстановление пароля','er_theme').'</div>';
    $result .= '<div class="block_content" id="rp">';
    $result .= '<span class="title-rp" style="text-align: center;">Укажите Ваш e-mail</span>';
    $result .= '<input class="block_input" type="text" placeholder="E-mail"><div class="g-recaptcha" data-sitekey="6Lf6dpIUAAAAALNlGI5LwOMRyOOFLLuSqoeBExgr" data-theme="light"></div>';
    $result .= '<input class="block_button" type="button" value="Восстановить" id="rpgo">';
    $result .= '<span class="rpmessage" style="display:none;"></span>';
    $result .= '</div>';
  //$result .= '<div class="popup_login_left">';
  //$result .= '<div class="regform__title">'.__('Восстановление пароля','er_theme').'</div>';
  //$result .= '<input class="block_input" type="text" placeholder="E-mail"><div class="g-recaptcha" data-sitekey="6Lf6dpIUAAAAALNlGI5LwOMRyOOFLLuSqoeBExgr" data-theme="light" style="transform:scale(0.8); transform-origin:0;"></div>';
    //$result .= '<input class="block_button" type="button" value="'.__('Восстановить','er_theme').'" id="rpgo">';
  //$result .= '</div>';
  //$result .= '<div class="popup_login_right">';
  //$result .= '</div>';

  $result .= '</div>';
    $result .= '</div>';
  echo $result;
  echo '
    <script type="text/javascript">
  
    jQuery(document).ready(function($){
        $(\'#popup_comment_modal .popup_close_button\').on(\'click\', function(){
          $("#popup_comment_modal").empty();
      });


          $(\'#rpgo\').click(function() {
          $(\'#rpmessage_error\').css(\'display\',\'none\');
          retrivemail = $(\'#rp input.block_input\').val();
          captcha = $(\'textarea[name="g-recaptcha-response"\').val();

          console.log(retrivemail);
          $.ajax({
          url: avatar.ajaxurl,
          type: \'POST\',
          data: \'action=retrivemail&retrivemail=\' + retrivemail+\'&captcha=\'+captcha,
          beforeSend: function(xhr) {

          },
          success: function(data) {
          result = $.parseJSON(data);
          //console.log(result.status);
          if (result.status == \'ok\') {
          $(\'.rpmessage\').text(\'Сообщение со ссылкой для изменения пароля было Вам отправлено по e-mail\');
          $(\'.rpmessage\').css(\'display\',\'block\');
          } else if (result.status == \'notexist\') {
          grecaptcha.reset();
          $(\'.rpmessage\').text(\'Пользователь с указанным e-mail адресом не был найден\');
          $(\'.rpmessage\').css(\'display\',\'block\');
          } else if (result.status == \'notemail\') {
            grecaptcha.reset();
          $(\'.rpmessage\').text(\'Вы указали некорректный e-mail\');
          $(\'.rpmessage\').css(\'display\',\'block\');
          } else if (result.status == \'recaptcha\') {
            grecaptcha.reset();
          $(\'.rpmessage\').text(\'Не пройдена каптча! Попробуйте еще раз! \');
          $(\'.rpmessage\').css(\'display\',\'block\');
          grecaptcha.reset();
          }
          }
          });  
          });


    });
    
    </script>
    <style>
    #rp input.block_input {
    width: 318px;
    height: 49px;
    background: #FFF;
    padding: 0 16px;
    border: 0;
    border-radius: 20px;
    color: #999;
    font-size: 17px;
    line-height: 49px;
    display: block;
    margin: 0 auto;
    background: #F2F5F9;
    border-radius: 20px;
}

#rp {
    margin-bottom: 40px;
    width: 100%;
}
.title-rp {
    font-style: normal;
    font-weight: 400;
    font-size: 23px;
    line-height: 27px;
    text-align: center;
    color: #000;
    margin-bottom: 32px;
    font-family: "Roboto",sans-serif;
    font-weight: 400;
    font-size: 22px;
    display: block;
}
.block_input_psw1 {
    margin-bottom: 15px !important;
    display: block;
}
.rpmessage {
    text-align: center;
    position: absolute;
    left: 0;
    right: 0;
    margin: auto;
    margin-top: 10px;
    color: #444444;
}

#rp {
    position: relative;
}
.wrap-set {
    width: 100%;
    display: flex;
    flex-direction: column;
}
#rp .g-recaptcha iframe {
    min-width: unset;
}

#rp .title-rp {
    color: #999;
    font-size: 16px;
}
#rpmessage_error {
    position: relative;
}

#rpmessage_error {
    margin-top: -30px;
    margin-bottom: 30px;
}


.passwordtested {
    text-align: center;
}

.passwordtested > span {
    width: 318px;
    background: red;
    width: 318px;
    background: #FFF;
    padding: 0 16px;
    border: 0;
    border-radius: 20px;
    color: #999;
    font-size: 13px;
    display: block;
    margin: 0 auto;
    background: #F2F5F9;
    border-radius: 20px;
    height: unset;
    margin-top: 10px;
    background: #717171;
    color: #FFF;
    padding-top: 5px;
    padding-bottom: 5px;
}
.password-wp {
    display: flex;
}

.password-wp {width: 350px;margin: 0 auto;}

.showerbtnpassword {
    position: absolute;
    right: 0;
    bottom: 0;
    top: 0;
    right: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 49px;
    top: 0;
    margin-top: 0;
    color: #444444;
}

.password-wp {position: relative;}
.g-recaptcha {
    text-align: center;
    width: unset;
}

.g-recaptcha > div {
    text-align: center;
    display: inline-block;
}
.g-recaptcha {
    margin-top: 10px;
}
.g-recaptcha + input.block_button {
    margin-top: 3px;
}
#rp {
    margin-bottom: 60px;
}
    </style>
  
  
  
  ';
  die;
}
add_action( 'wp_ajax_youtube_link_append', 'youtube_link_append' );
add_action( 'wp_ajax_nopriv_youtube_link_append', 'youtube_link_append' );

function youtube_link_append(){
	$data = $_POST;
	$url = $data['url'];
	$url_components = parse_url($url); 
	parse_str($url_components['query'], $params);
	$video_id = $params['v'];
	$result = '';
	$result .= '<div class="popup_container" id="popup_login">';
    $result .= '<div class="popup_banner border_radius_general box_shadow_general">';
    $result .= '<a class="popup_close_button"></a>';
	$result .= '<iframe width="100%" height="315" src="https://www.youtube.com/embed/'.$video_id.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
	$result .= '</div>';
    $result .= '</div>';
	echo $result;
	echo '
    <script type="text/javascript">
	
    jQuery(document).ready(function($){
        $(\'#popup_comment_modal .popup_close_button\').on(\'click\', function(){
          $("#popup_comment_modal").empty();
      });
    });
    
    </script>';
	die;
}

add_action( 'wp_ajax_popup_login', 'popup_login' );
add_action( 'wp_ajax_nopriv_popup_login', 'popup_login' );
 
function popup_login() {
	$result = '';
	$result .= '<div class="popup_container" id="popup_login">';
    $result .= '<div class="popup_banner border_radius_general box_shadow_general">';
    $result .= '<a class="popup_close_button"></a>';
	$result .= '<ul class="mobile_auth_links">';
	$result .= '<li class="active">'.__('Вход','er_theme').'</li>';
	$result .= '<li class="tab_reg">'.__('Регистрация','er_theme').'</li>';
	$result .= '</ul>';
	$result .= '<script src="https://www.google.com/recaptcha/api.js"></script>';
	$result .= '<div class="popup_login_container popup_log">';
	
	$result .= '<div class="popup_login_left">';
	
	$result .= '<div class="regform__title">Авторизация по E-mail</div>';
	$result .= '<form class="regform"  action="" method="post" id="regform">';
	$result .= '<div class="regform__line">
                            <input type="email" name="email" placeholder="E-mail">
                        </div>
                        <div class="regform__line">
                            <input type="password" name="password" placeholder="'.__('Пароль','er_theme').'">
                        </div>
						<div class="g-recaptcha" data-sitekey="6Lf6dpIUAAAAALNlGI5LwOMRyOOFLLuSqoeBExgr" data-theme="light" style="transform:scale(0.8); transform-origin:0;"></div>
                        <div class="regform__twocol">
                            <div class="remember">
                                <input type="checkbox" id="remember__input" name="remember" checked="checked">
                                <label for="remember__input">'.__('Запомнить меня','er_theme').'</label>
                            </div>
                            <div class="two-links-regform">
                                <a href="/reset-password/" class="ihaveacc"'.__('Забыли пароль?','er_theme').'></a>
                            </div>
                        </div>
						<input type="submit" name="submit" value="Войти" id="regbtn">
                        <span class="errorarea"></span>
                    </form>
						';
	$result .= '</div>';
	$result .= '<div class="popup_login_right">';
	$result .= '<div class="popup_login_left_left">';
	$result .= '<div class="popup_login_title">'.__('Вход через соц. сети','er_theme').'</div>';
	$result .= '<ul class="social_login_links">';
		$result .= '<li class="Google"><a onclick="javascript:auth_popup(\'Google\');"></a></li>';
		$result .= '<li class="Vkontakte"><a onclick="javascript:auth_popup(\'Vkontakte\');"></a></li>';
		$result .= '<li class="Yandex"><a onclick="javascript:auth_popup(\'Yandex\');"></a></li>';
		$result .= '<li class="Odnoklassniki"><a onclick="javascript:auth_popup(\'Odnoklassniki\');"></a></li>';
		$result .= '</ul>';
	$result .= '</div>';
	$result .= '<div class="popup_login_right_right">';
	$result .= '<div class="popup_login_title">'.__('У вас еще нет аккаунта?','er_theme').'</div>';
	$result .= '<div class="create_link">'.__('Создать аккаунт','er_theme').'</div>';
	$result .= '<div class="recover_link">'.__('Восстановить пароль','er_theme').'</div>';
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
    $result .= '</div>';
	echo $result;
	echo '
    <script type="text/javascript">
	
    jQuery(document).ready(function($){
        $(\'#popup_comment_modal .popup_close_button\').on(\'click\', function(){
          $("#popup_comment_modal").empty();
      });
    });
    
    </script>
	
	<script type="text/javascript">
            $ = jQuery.noConflict();
            $(document).ready(function() {   
				$(".create_link").click(function() {
					//alert("reg");
					$("#popup_comment_modal").empty();
					$.ajax({
						url: "'.admin_url("admin-ajax.php").'",
						type: "POST",
						data: "action=popup_registration",
						beforeSend: function(xhr) {

						},
						success: function( data ) {
							$("#popup_comment_modal").html(data);
							$("#popup_comment_modal .popup_container").show();
						}
					});
				});
				$(".tab_reg").click(function() {
					//alert("reg");
					$("#popup_comment_modal").empty();
					$.ajax({
						url: "'.admin_url("admin-ajax.php").'",
						type: "POST",
						data: "action=popup_registration",
						beforeSend: function(xhr) {

						},
						success: function( data ) {
							$("#popup_comment_modal").html(data);
							$("#popup_comment_modal .popup_container").show();
						}
					});
				});
				$(".recover_link").click(function() {
					//alert("reg");
					$("#popup_comment_modal").empty();
					$.ajax({
						url: "'.admin_url("admin-ajax.php").'",
						type: "POST",
						data: "action=popup_recover",
						beforeSend: function(xhr) {

						},
						success: function( data ) {
							$("#popup_comment_modal").html(data);
							$("#popup_comment_modal .popup_container").show();
						}
					});
				});
                $("#regbtn").click(function() {
						//alert("ok");
                        
                        email = $(\'input[name="email"]\').val();
                        password = $(\'input[name="password"]\').val();
                        captcha = $(\'textarea[name="g-recaptcha-response"\').val();
                        password = ""+password+"";
                        if ($(\'input#remember__input\').is(":checked"))
                        {
                             remember = \'yes\';
                        } else {
                             remember = \'no\';
                        }

                        $.ajax({
                            url: "'.admin_url("admin-ajax.php").'",
                            type: \'POST\',
                            data: \'action=loginusermain&email=\' + email+ \'&password=\' + encodeURIComponent(password)+ \'&remember=\' + remember+ \'&captcha=\' + captcha,
                            beforeSend: function(xhr) {

                            },
                            success: function(data) {
                                result = $.parseJSON(data);
                                //alert(data);
                                console.log(result.email+\' \'+ result.password);

                                if ((result.status == \'error\') || (result.status == "")) {
                                    $(\'.errorarea\').text(result.messagetext);
                                    grecaptcha.reset();
                                } else if (result.status == \'recaptcha\') {
                                    $(\'.errorarea\').text(result.messagetext);
                                    grecaptcha.reset();
                                } else if (result.status != \'ok\') {
                                    $(\'.errorarea\').text(result.messagetext);
                                    grecaptcha.reset();
                                }

                                $(\'#regform input\').css(\'border\',\'none\');                                
                                $(\'#regform input[name="submit"]\').css(\'border\',\'none\');

                                if ( (result.status != \'ok\') ) { 
                                    if (result.status != \'recaptcha\') {
                                        $(\'input[type="email"],input[name="password"]\').css(\'border\',\'2px solid #c30000\');
                                    }                                    
                                } else {
                                    //alert(result.messagetext);
                                    document.cookie = "loggeduser=1; path=/; expires=Tue, 19 Jan 2038 03:14:07 GMT";
                                    //window.location.replace("/user/");
									location.reload(true);
                                }       
                            }
                        });
                        return false;
                    });
            });
</script>
    ';
	die;
}

add_action( 'wp_ajax_post_share', 'post_share' );
add_action( 'wp_ajax_nopriv_post_share', 'post_share' );

function is_registered_from_social($user_id) {
	$reg = get_field('user_reg_from_social','user_'.$user_id);
	if($reg && $reg == 'yes') {
		$result['status'] = 1;
	} else {
		$result['status'] = 0;
	}
	
	$provider_Google = get_field('provider_Google','user_'.$user_id);
	$provider_Yandex = get_field('provider_Yandex','user_'.$user_id);
	$provider_Vkontakte = get_field('provider_Vkontakte','user_'.$user_id);
    $provider_Odnoklassniki = get_field('provider_Odnoklassniki','user_'.$user_id);

	if($provider_Google && $provider_Google != '') {
		$result['providers'][] = array (
			'provider' => 'Google',
			'identificator'=> $provider_Google
		);
	}
	if($provider_Yandex && $provider_Yandex != '') {
		$result['providers'][] = array (
			'provider' => 'Yandex',
			'identificator'=> $provider_Yandex
		);
	}
	if($provider_Vkontakte && $provider_Vkontakte != '') {
		$result['providers'][] = array (
			'provider' => 'Vkontakte',
			'identificator'=> $provider_Vkontakte
		);
	}
    if($provider_Odnoklassniki && $provider_Odnoklassniki != '') {
        $result['providers'][] = array (
            'provider' => 'Odnoklassniki',
            'identificator'=> $provider_Odnoklassniki
        );
    }

	if(!empty($result['providers'])) {
		$result['main'] = $result['providers'][0]['provider'];
	} else {
		$result['main'] = 'none';
	}
	return $result;
}
 
function post_share() {
	$data = $_POST;
	//print_r($data);
	$result .= '<div class="popup_container" id="popup_comment_'.$data['action_type'].'">';
    $result .= '<div class="popup_banner border_radius_general box_shadow_general">';
    $result .= '<a class="popup_close_button"></a>';
	$result .= show_social_share_links('popup_links',get_the_permalink($data['post_id']));
	$result .= '</div>';
    $result .= '</div>';
	echo $result;
	echo '
    <script type="text/javascript">
	
    jQuery(document).ready(function($){
		$("#popup_comment_modal .show_social_share_links a").click(function() {
			window.open($(this).attr("href"),"title", "width=500, height=400");
			return false;
		});
        $(\'#popup_comment_modal .popup_close_button\').on(\'click\', function(){
          $("#popup_comment_modal").empty();
      });
    });
    
    </script>
    ';
	die;
}

add_action( 'wp_ajax_comment_popup_actions', 'comment_popup_actions' );
add_action( 'wp_ajax_nopriv_comment_popup_actions', 'comment_popup_actions' );
 
function comment_popup_actions() {
	//print_r($_POST);
	$data = $_POST;
	$result = '';
	$result .= '<div class="popup_container" id="popup_comment_'.$data['action_type'].'">';
    $result .= '<div class="popup_banner border_radius_general box_shadow_general">';
    $result .= '<a class="popup_close_button"></a>';
	if($data['action_type'] == 'comment_permalink' && $data['comment_id'] && $data['comment_id'] != '') {
		$result .= '<div class="regform__title">'.__('Ссылка на комментарий','er_theme').'</div>';
		$result .= '<input type="text" value="'.get_comment_link($data['comment_id']).'" />';
	} elseif($data['action_type'] == 'comment_share' && $data['comment_id'] && $data['comment_id'] != '') {
		$result .= show_social_share_links('popup_links',get_comment_link($data['comment_id']));
	}
	$result .= '</div>';
    $result .= '</div>';
	echo $result;
	echo '
    <script type="text/javascript">
	
    jQuery(document).ready(function($){
		$("#popup_comment_modal .show_social_share_links a").click(function() {
			window.open($(this).attr("href"),"title", "width=500, height=400");
			return false;
		});
        $(\'#popup_comment_modal .popup_close_button\').on(\'click\', function(){
          $("#popup_comment_modal").empty();
      });
    });
    
    </script>
    ';
	die;
}

function custom_comment_single_hidden( $comment, $args, $depth){ 
if($depth > 1) { ?>
	<li  id="show-comment-<?php comment_ID(); ?>">
	<?php
  $labelpro = '';
  if (    (    (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84175) || (get_field('services_user_services','user_'.$comment->user_id) == 84175) || (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84178) || (get_field('services_user_services','user_'.$comment->user_id) == 84178)    )    ) {
    $namep = get_field('services_user_services','user_'.$comment->user_id)[0];
    if (get_field('services_user_services','user_'.$comment->user_id)[0] == '') {
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    } else {
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    }
  }  else {
    $labelpro = '';
  }
  ?>
	<?php $comment_author = get_userdata( $comment->user_id ); ?>
	<span class="comment-author"><?php if($comment_author->first_name && !$comment_author->last_name) { echo $comment_author->first_name.' '.$labelpro; } elseif(!$comment_author->first_name && $comment_author->last_name) { echo $comment_author->last_name.' '.$labelpro; } elseif($comment_author->first_name && $comment_author->last_name) { echo $comment_author->first_name.' '.$comment_author->last_name.' '.$labelpro; } else { echo $comment_author->user_nicename.' '.$labelpro; } ?></span>
    <span class="comment-date"><?php comment_date( 'j F Y в H:i' ); ?></span>
    <div class="comment_text"><?php echo apply_filters('the_content', $comment->comment_content); ?></div>
	</li>
	<?php
} else {
	?>
	<?php
  $labelpro = '';
  if (    (    (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84175) || (get_field('services_user_services','user_'.$comment->user_id) == 84175) || (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84178) || (get_field('services_user_services','user_'.$comment->user_id) == 84178)    )    ) {
    $namep = get_field('services_user_services','user_'.$comment->user_id)[0];
    if (get_field('services_user_services','user_'.$comment->user_id)[0] == '') {
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    } else {
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    }
  }  else {
    $labelpro = '';
  }
  ?>
	<li id="show-comment-<?php echo $comment->comment_ID; ?>" itemprop="review" itemscope itemtype="http://schema.org/Review" data-commentid="<?php comment_ID(); ?>">
    	<meta itemprop="itemReviewed" content="<?php echo get_field('company_name' ); ?>" />
    	<?php $comment_author = get_userdata( $comment->user_id ); ?>       
  				<span class="comment-author" itemprop="author"><?php if($comment_author->first_name && !$comment_author->last_name) { echo $comment_author->first_name; } elseif(!$comment_author->first_name && $comment_author->last_name) { echo $comment_author->last_name; } elseif($comment_author->first_name && $comment_author->last_name) { echo $comment_author->first_name.' '.$comment_author->last_name; } else { echo $comment_author->user_nicename; } ?></span>
          <?php echo $labelpro; ?>
                   <?php
		
                $total_rating = get_comment_rating_values($args['rating_fields'],$comment,'total');
			    $total_rating_value = 5 / 100 * $total_rating;
			    if ($total_rating != 0) {
				    
			?>
                <div  class="comment_total_rating" itemprop="reviewRating" itemscope="" itemtype="https://schema.org/Rating">
                    <span itemprop="ratingValue"><?php echo round($total_rating_value,1); ?></span>
                    <meta itemprop="worstRating" content = "0.1" />
                    <meta itemprop="bestRating" content = "5" />
                </div>

            <?php }; 
            ?>
                    <span class="comment-date" itemprop="datePublished" content="<?php comment_date( 'Y-m-d' ); ?>"><?php comment_date( 'j F Y в H:i' ); ?></span>
                    <div itemprop="reviewBody" class="comment_text comment_text_<?php echo $comment->comment_ID; ?>"><?php echo apply_filters('the_content', $comment->comment_content); ?></div>
	</li>
	<?php
}
?>
	
<?php }


function custom_abuse_single( $comment, $args, $depth){
	$is_abuse = get_field('is_abuse', $comment);
	if($depth > 1) { 
		
	} else {
		//print_r($comment);
		$attachment_id = get_field('photo_profile', 'user_'. $comment->user_id );
		$comment_class = get_comment_class('',$comment->comment_ID,$comment->comment_post_ID);
		$comment_class_print = '';
		foreach ($comment_class as $item) {
			$comment_class_print .= $item.' ';
		}
		//print_r($comment_class);
		//echo $comment->comment_ID;
	?>

<?php   $labelpro = '';
  if (    (    (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84175) || (get_field('services_user_services','user_'.$comment->user_id) == 84175) || (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84178) || (get_field('services_user_services','user_'.$comment->user_id) == 84178)    )    ) {
    $namep = get_field('services_user_services','user_'.$comment->user_id)[0];
    if (get_field('services_user_services','user_'.$comment->user_id)[0] == '') {
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    } else {
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    }
  } else {
    $labelpro = '';
  } ?>
<li class="<?php echo $comment_class_print; ?> white_block" id="comment-<?php echo $comment->comment_ID; ?>" data-commentid="<?php comment_ID(); ?>">
        <div class="comment-body body_<?php echo $comment->comment_ID; ?>" data-body-id="body_<?php echo $comment->comment_ID; ?>">
		<div class="comment_header flex">
      <?php $comment_author = get_userdata( $comment->user_id ); ?>
          <?php if (get_field('pub_profile', 'user_'.$comment->user_id) == 'yes') {
            $pubprofile = ' data-pub="1" ';
          } else {
            $pubprofile = '';
          } ?>   
			<div class="comment_avatar"  <?php echo $pubprofile; ?> data-link="<?php echo 'https://eto-razvod.ru/user/'.$comment_author->user_nicename.'/'; ?>" <?php if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') { ?>style="background-image: url(<?php echo $attachment_id['sizes']['thumbnail']; ?>)" <?php }; ?>><?php if(is_registered_from_social($comment->user_id)['main'] && is_registered_from_social($comment->user_id)['main'] != 'none') { echo '<div class="social_provider_registered '.is_registered_from_social($comment->user_id)['main'].'"></div>'; }; ?></div>
			<div class="comment_meta">
        <div class="comment_author_wrapper">
          <?php $comment_author = get_userdata( $comment->user_id ); ?>       
  				<span class="comment-author font_bold font_small color_dark_blue" itemprop="author" data-link="<?php echo 'https://eto-razvod.ru/user/'.$comment_author->user_nicename.'/'; ?>" <?php echo $pubprofile; ?>><?php if($comment_author->first_name && !$comment_author->last_name) { echo $comment_author->first_name; } elseif(!$comment_author->first_name && $comment_author->last_name) { echo $comment_author->last_name; } elseif($comment_author->first_name && $comment_author->last_name) { echo $comment_author->first_name.' '.$comment_author->last_name; } else { echo $comment_author->user_nicename; } ?></span>
          <?php echo $labelpro; ?><?php echo $user_status_label; ?>
        </div>
				<span class="comment-date font_small color_dark_gray" itemprop="datePublished" content="<?php comment_date( 'Y-m-d' ); ?>"><?php comment_date( 'j F Y в H:i' ); ?></span>
			</div>
           
            <?php
		
                $abuse_state = get_field('abuse_state', $comment);
                if($abuse_state && !empty($abuse_state)) {
	                $abuse_state_value = $abuse_state['value'];
	                $abuse_state_label = $abuse_state['label'];
                } else {
	                $abuse_state_value = 'not_seen';
	                $abuse_state_label = __('Новая','er_theme');
                }
                ?>
                <div class="comment_is_abuse <?php echo $abuse_state_value; ?>"><?php echo $abuse_state_label; ?></div>
            <?php
                
            ?>
			
		</div>
		<div class="comment-content">
			<div itemprop="reviewBody" class="comment_text comment_text_<?php echo $comment->comment_ID; ?>"><?php echo apply_filters('the_content', $comment->comment_content); ?></div>
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

		<div class="comment_footer font_small">
            <?php
            $childcomments = get_comments(array(
	            'post_id'   => get_the_ID(),
	            'status'    => 'approve',
	            'order'     => 'DESC',
	            'parent'    => $comment->comment_ID,
            ));
            $comment_replies = count($childcomments);
            if($comment_replies != 0) { 
            ?>
                <div class="comment_reply_count dropdown flex color_dark_gray m_right_20 pointer"><?php _e('Развернуть','er_theme'); ?></div>
            <?php } ?>
			<div class="comment_footer_right hovered_<?php echo $comment->comment_ID; ?>">
				
			</div>
			<div class="comment_fast_links hovered_<?php echo $comment->comment_ID; ?>">
           		<span class="comment_permalink"></span>
           		<span class="comment_share"></span>
           		<span class="comment_more_actions"></span>
           		<ul class="comment_more_actions_links comment_more_actions_links_<?php echo $comment->comment_ID; ?>">
						<li class="comment_more_actions_link_spam"><?php _e('Это спам','er_theme'); ?></li>
						<li class="comment_more_actions_link_abuse"><?php _e('Пожаловаться','er_theme'); ?></li>
					</ul>
		   </div>
		</div>
	</div>

	<?php // без закрывающего </li> (!)
	}
}

function custom_comment_single( $comment, $args, $depth){
    $comment_rate = get_field('comment_rate', $comment);
	$is_abuse = get_field('is_abuse', $comment);
    if(!$comment_rate) {
	    $comment_rate = 0;
    }
	$user_status = get_field('user_site_statuses','user_'.$comment->user_id);
	
		if(!empty($user_status) && $user_status['value'] != 'none') {
			$user_status_label = '<span class="user_comment_status status_'.$user_status['value'].' user_label font_smaller" >'.$user_status['label'].'</span>';
		}  else {
			$user_status_label = '';
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
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    } else {
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    }
  }  else {
    $labelpro = '';
  }
  ?>
        <li class="<?php echo $comment_class_print; ?>" id="comment-<?php comment_ID(); ?>" data-commentid="<?php echo $comment->comment_ID; ?>">
        <div class="comment-body body_<?php echo $comment->comment_ID; ?>" data-body-id="body_<?php echo $comment->comment_ID; ?>">
            <div class="comment_header flex">
                <?php $comment_author = get_userdata( $comment->user_id ); 
				
				?>
          <?php if (get_field('pub_profile', 'user_'.$comment->user_id) == 'yes') {
            $pubprofile = ' data-pub="1" ';
          } else {
            $pubprofile = '';
          } ?>   
                <div class="comment_avatar" <?php echo $pubprofile; ?> data-link="<?php echo 'https://eto-razvod.ru/user/'.$comment_author->user_nicename.'/'; ?>" <?php if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') { ?>style="background-image: url(<?php echo $attachment_id['sizes']['thumbnail']; ?>)" <?php }; ?>><?php if(is_registered_from_social($comment->user_id)['main'] && is_registered_from_social($comment->user_id)['main'] != 'none') { echo '<div class="social_provider_registered '.is_registered_from_social($comment->user_id)['main'].'"></div>'; }; ?></div>
                
                <div class="comment_meta">
                    <span class="comment-author font_bold font_small color_dark_blue" <?php echo $pubprofile; ?> data-link="<?php echo 'https://eto-razvod.ru/user/'.$comment_author->user_nicename.'/'; ?>"><?php if($comment_author->first_name && !$comment_author->last_name) { echo $comment_author->first_name.' '.$labelpro; } elseif(!$comment_author->first_name && $comment_author->last_name) { echo $comment_author->last_name.' '.$labelpro; } elseif($comment_author->first_name && $comment_author->last_name) { echo $comment_author->first_name.' '.$comment_author->last_name.' '.$labelpro; } else { echo $comment_author->user_nicename.' '.$labelpro; } ?><?php echo $user_status_label; ?><span class="comment_parent_author_link font_normal color_dark_gray">
<?php $par_comm_obj = get_comment( $comment->comment_parent );
                            $par_aurhor = get_userdata($par_comm_obj->user_id);

                       ?>
                       <?php if($par_aurhor->first_name && !$par_aurhor->last_name) { echo $par_aurhor->first_name; } elseif(!$par_aurhor->first_name && $par_aurhor->last_name) { echo $par_aurhor->last_name; } elseif($par_aurhor->first_name && $par_aurhor->last_name) { echo $par_aurhor->first_name.' '.$par_aurhor->last_name; } else { echo $par_aurhor->user_nicename; } ?>
                </span></span>
                    <span class="comment-date font_small color_dark_gray"><?php comment_date( 'j F Y в H:i' ); ?></span>
                </div>
                
                <div class="comment_rate" id="rate-comment-<?php echo $comment->comment_ID; ?>">
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
                
                
            </div>
			<?php if ($total_rating != 0) { ?>
                <div class="comment_rating_details">
					<?php echo get_comment_rating_values($args['rating_fields'],$comment,'list'); ?>
                </div>
			<?php }; ?>
            <div class="comment-content">
                <div class="comment_text comment_text_<?php echo $comment->comment_ID; ?>"><?php  
		echo apply_filters('the_content', $comment->comment_content); ?></div>
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

            <div class="comment_footer font_small">

                <a rel="nofollow" class="comment-reply-link color_dark_blue pointer" data-commentid="<?php echo $comment->comment_parent ?>" data-postid="<?php echo get_the_ID(); ?>" data-appendto="<?php echo $comment->comment_ID; ?>"><?php _e('Ответить','er_theme'); ?></a>
                <div class="comment_footer_right hovered_<?php echo $comment->comment_ID; ?>">
					
                </div>
                <div class="comment_fast_links hovered_<?php echo $comment->comment_ID; ?>">
					<span class="comment_permalink"></span>
					<span class="comment_share"></i></span>
					<span class="comment_more_actions"></span>
					<ul class="comment_more_actions_links comment_more_actions_links_<?php echo $comment->comment_ID; ?>">
						<li class="comment_more_actions_link_spam"><?php _e('Это спам','er_theme'); ?></li>
						<li class="comment_more_actions_link_abuse"><?php _e('Пожаловаться','er_theme'); ?></li>
					</ul>
			   </div>
            </div>
        </div>
	<?php } else {
		//print_r($comment);
		$attachment_id = get_field('photo_profile', 'user_'. $comment->user_id );
		$comment_class = get_comment_class('',$comment->comment_ID,$comment->comment_post_ID);
		$comment_class_print = '';
		foreach ($comment_class as $item) {
			$comment_class_print .= $item.' ';
		}
		//print_r($comment_class);
		//echo $comment->comment_ID;
	?>

<?php   $labelpro = '';
  if (    (    (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84175) || (get_field('services_user_services','user_'.$comment->user_id) == 84175) || (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84178) || (get_field('services_user_services','user_'.$comment->user_id) == 84178)    )    ) {
    $namep = get_field('services_user_services','user_'.$comment->user_id)[0];
    if (get_field('services_user_services','user_'.$comment->user_id)[0] == '') {
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    } else {
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    }
  } else {
    $labelpro = '';
  } ?>
<li class="<?php echo $comment_class_print; ?> white_block" id="comment-<?php echo $comment->comment_ID; ?>" itemprop="review" itemscope itemtype="http://schema.org/Review" data-commentid="<?php comment_ID(); ?>">
    <meta itemprop="itemReviewed" content="<?php echo get_field('company_name' ); ?>" />
        <div class="comment-body body_<?php echo $comment->comment_ID; ?>" data-body-id="body_<?php echo $comment->comment_ID; ?>">
		<div class="comment_header flex">
      <?php $comment_author = get_userdata( $comment->user_id ); ?>
          <?php if (get_field('pub_profile', 'user_'.$comment->user_id) == 'yes') {
            $pubprofile = ' data-pub="1" ';
          } else {
            $pubprofile = '';
          } ?>   
			<div class="comment_avatar"  <?php echo $pubprofile; ?> data-link="<?php echo 'https://eto-razvod.ru/user/'.$comment_author->user_nicename.'/'; ?>" <?php if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') { ?>style="background-image: url(<?php echo $attachment_id['sizes']['thumbnail']; ?>)" <?php }; ?>><?php if(is_registered_from_social($comment->user_id)['main'] && is_registered_from_social($comment->user_id)['main'] != 'none') { echo '<div class="social_provider_registered '.is_registered_from_social($comment->user_id)['main'].'"></div>'; }; ?></div>
			<div class="comment_meta">
        <div class="comment_author_wrapper">
          <?php $comment_author = get_userdata( $comment->user_id ); ?>       
  				<span class="comment-author font_bold font_small color_dark_blue" itemprop="author" data-link="<?php echo 'https://eto-razvod.ru/user/'.$comment_author->user_nicename.'/'; ?>" <?php echo $pubprofile; ?>><?php if($comment_author->first_name && !$comment_author->last_name) { echo $comment_author->first_name; } elseif(!$comment_author->first_name && $comment_author->last_name) { echo $comment_author->last_name; } elseif($comment_author->first_name && $comment_author->last_name) { echo $comment_author->first_name.' '.$comment_author->last_name; } else { echo $comment_author->user_nicename; } ?></span>
          <?php echo $labelpro; ?><?php echo $user_status_label; ?>
        </div>
				<span class="comment-date font_small color_dark_gray" itemprop="datePublished" content="<?php comment_date( 'Y-m-d' ); ?>"><?php comment_date( 'j F Y в H:i' ); ?></span>
			</div>
           
            <?php
		/*
		if($is_abuse) {
                $abuse_state = get_field('abuse_state', $comment);
                if($abuse_state && !empty($abuse_state)) {
	                $abuse_state_value = $abuse_state['value'];
	                $abuse_state_label = $abuse_state['label'];
                } else {
	                $abuse_state_value = 'not_seen';
	                $abuse_state_label = __('ожидает','er_theme');
                }
                ?>
                <div class="comment_is_abuse <?php echo $abuse_state_value; ?>">
                    <div class="abuse_title"><?php _e('Жалоба','er_theme'); ?></div>
                    <div class="abuse_state"><?php echo $abuse_state_label; ?></div>
                </div>
            <?php }*/
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
			?>
                <div  class="comment_total_rating" itemprop="reviewRating" itemscope="" itemtype="https://schema.org/Rating">
                    <div class="review_average_round progress small pointer <?php echo $rating_color;?>" id="comment_rating_total_<?php echo $comment->comment_ID; ?>" data-percent="<?php echo $data_percent; ?>">
                        <div class="inner color_dark_blue font_bold font_small pointer" itemprop="ratingValue"><?php echo round($total_rating_value,1); ?></div>
                        
                    </div>
                    <meta itemprop="worstRating" content = "0.1" />
                    <meta itemprop="bestRating" content = "5" />
                </div>

            <?php }; 
            ?>
			<div class="comment_rate" id="rate-comment-<?php echo $comment->comment_ID; ?>">
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
		</div>
		<?php if ($total_rating != 0) { ?>
            <div class="comment_rating_details">
				<?php echo get_comment_rating_values($args['rating_fields'],$comment,'list'); ?>
            </div>
		<?php }; ?>
		<div class="comment-content">
			<div itemprop="reviewBody" class="comment_text comment_text_<?php echo $comment->comment_ID; ?>"><?php echo apply_filters('the_content', $comment->comment_content); ?></div>
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

		<div class="comment_footer font_small">
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
            if($comment_replies != 0) { 
            ?>
                <div class="comment_reply_count dropdown flex color_dark_gray m_right_20 pointer"><?php echo $comment_replies; ?> <?php echo $comment_replies_text; ?></div>
            <?php } ?>
			<a rel="nofollow" class="comment-reply-link color_dark_blue pointer" data-commentid="<?php echo $comment->comment_ID; ?>" data-postid="<?php echo get_the_ID(); ?>" data-appendto="<?php comment_ID(); ?>"><?php _e('Ответить','er_theme'); ?></a>
			<div class="comment_footer_right hovered_<?php echo $comment->comment_ID; ?>">
				
			</div>
			<div class="comment_fast_links hovered_<?php echo $comment->comment_ID; ?>">
           		<span class="comment_permalink"></span>
           		<span class="comment_share"></span>
           		<span class="comment_more_actions"></span>
           		<ul class="comment_more_actions_links comment_more_actions_links_<?php echo $comment->comment_ID; ?>">
						<li class="comment_more_actions_link_spam"><?php _e('Это спам','er_theme'); ?></li>
						<li class="comment_more_actions_link_abuse"><?php _e('Пожаловаться','er_theme'); ?></li>
					</ul>
		   </div>
		</div>
	</div>

	<?php // без закрывающего </li> (!)
	}


}

function custom_comment_profile_page( $comment, $args, $depth){
    $comment_rate = get_field('comment_rate', $comment);
  $is_abuse = get_field('is_abuse', $comment);
    if(!$comment_rate) {
      $comment_rate = 0;
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
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    } else {
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    }
  }  else {
    $labelpro = '';
  }
  ?>
        <li class="<?php echo $comment_class_print; ?>" id="comment-<?php comment_ID(); ?>" data-commentid="<?php echo $comment->comment_ID; ?>">
        <div class="comment-body body_<?php echo $comment->comment_ID; ?>"  data-body-id="body_<?php echo $comment->comment_ID; ?>"  data-parentid="<?php echo $comment->comment_post_ID; ?>"  data-post-status="<?php echo get_post_status($comment->comment_post_ID); ?>" data-body-id="body_<?php echo $comment->comment_ID; ?>">
            <div class="comment_header">
                <?php $comment_author = get_userdata( $comment->user_id ); ?>
          <?php if (get_field('pub_profile', 'user_'.$comment->user_id) == 'yes') {
            $pubprofile = ' data-pub="1" ';
          } else {
            $pubprofile = '';
          } ?>   
                <div class="comment_avatar" <?php echo $pubprofile; ?> data-link="<?php echo 'https://eto-razvod.ru/user/'.$comment_author->user_nicename.'/'; ?>" <?php if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') { ?>style="background-image: url(<?php echo $attachment_id['sizes']['thumbnail']; ?>)" <?php }; ?>><?php if(is_registered_from_social($comment->user_id)['main'] && is_registered_from_social($comment->user_id)['main'] != 'none') { echo '<div class="social_provider_registered '.is_registered_from_social($comment->user_id)['main'].'"></div>'; }; ?></div>
                
                <div class="comment_meta">
                    <span class="comment-author" <?php echo $pubprofile; ?> data-link="<?php echo 'https://eto-razvod.ru/user/'.$comment_author->user_nicename.'/'; ?>"><?php if($comment_author->first_name && !$comment_author->last_name) { echo $comment_author->first_name.' '.$labelpro; } elseif(!$comment_author->first_name && $comment_author->last_name) { echo $comment_author->last_name.' '.$labelpro; } elseif($comment_author->first_name && $comment_author->last_name) { echo $comment_author->first_name.' '.$comment_author->last_name.' '.$labelpro; } else { echo $comment_author->user_nicename.' '.$labelpro; } ?><span class="comment_parent_author_link font_normal color_dark_gray">
<?php $par_comm_obj = get_comment( $comment->comment_parent );
                            $par_aurhor = get_userdata($par_comm_obj->user_id);

                       ?>
                       <?php if($par_aurhor->first_name && !$par_aurhor->last_name) { echo $par_aurhor->first_name; } elseif(!$par_aurhor->first_name && $par_aurhor->last_name) { echo $par_aurhor->last_name; } elseif($par_aurhor->first_name && $par_aurhor->last_name) { echo $par_aurhor->first_name.' '.$par_aurhor->last_name; } else { echo $par_aurhor->user_nicename; } ?>
                </span></span>
                    <span class="comment-date"><?php comment_date( 'j F Y в H:i' ); ?></span>
                </div>
                
                
                <div class="comment_rate" id="rate-comment-<?php echo $comment->comment_ID; ?>">
            <span class="rate_plus rate_action" data-commentaction="plus" data-comment-id="<?php echo $comment->comment_ID; ?>"></span>
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
            <span class="rate_minus rate_action" data-commentaction="minus" data-comment-id="<?php echo $comment->comment_ID; ?>"></span>
          </div>
                
            </div>
      <?php if ($total_rating != 0) { ?>
                <div class="comment_rating_details">
          <?php echo get_comment_rating_values($args['rating_fields'],$comment,'list'); ?>
                </div>
      <?php }; ?>
            <div class="comment-upper-content">
              <?php 
	  setup_postdata( $comment->comment_post_ID );
    echo '<a class="comment-post-link" href="#">'.get_the_title($comment->comment_post_ID).'</a>'; 
				wp_reset_postdata();?>
            </div>
            <div class="comment-content">
                <div class="comment_text comment_text_<?php echo $comment->comment_ID; ?>"><?php echo apply_filters('the_content', $comment->comment_content); ?></div>
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

            <div class="comment_footer">

                <a rel="nofollow" style="display:none" class="comment-reply-link" data-commentid="<?php echo $comment->comment_parent ?>" data-postid="<?php echo get_the_ID(); ?>" data-appendto="<?php echo $comment->comment_ID; ?>">Ответить</a>
                <div class="comment_footer_right hovered_<?php echo $comment->comment_ID; ?>">
          
                </div>
                <div class="comment_fast_links hovered_<?php echo $comment->comment_ID; ?>">
          <span class="comment_permalink"></span>
          <span class="comment_share"></span>
          <span class="comment_more_actions"></span>
          <ul class="comment_more_actions_links comment_more_actions_links_<?php echo $comment->comment_ID; ?>">
            <li class="comment_more_actions_link_spam"><?php _e('Это спам','er_theme'); ?></li>
            <li class="comment_more_actions_link_abuse"><?php _e('Пожаловаться','er_theme'); ?></li>
          </ul>
         </div>
            </div>
        </div>
  <?php } else {
    //print_r($comment);
    $attachment_id = get_field('photo_profile', 'user_'. $comment->user_id );
    $comment_class = get_comment_class('',$comment->comment_ID,$comment->comment_post_ID);
    $comment_class_print = '';
    foreach ($comment_class as $item) {
      $comment_class_print .= $item.' ';
    }
    //print_r($comment_class);
    //echo $comment->comment_ID;
  ?>

<?php   $labelpro = '';
  if (    (    (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84175) || (get_field('services_user_services','user_'.$comment->user_id) == 84175) || (    get_field('services_user_services','user_'.$comment->user_id)[0] == 84178) || (get_field('services_user_services','user_'.$comment->user_id) == 84178)    )    ) {
    $namep = get_field('services_user_services','user_'.$comment->user_id)[0];
    if (get_field('services_user_services','user_'.$comment->user_id)[0] == '') {
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    } else {
      $labelpro = ' <span class="label-pro">'.get_the_title($namep).'</span>';
    }
  } else {
    $labelpro = '';
  } ?>
<li class="<?php echo $comment_class_print; ?>" id="comment-<?php echo $comment->comment_ID; ?>" itemprop="review" itemscope itemtype="http://schema.org/Review" data-commentid="<?php comment_ID(); ?>">
    <meta itemprop="itemReviewed" content="<?php echo get_field('company_name' ); ?>" />
        <div class="comment-body body_<?php echo $comment->comment_ID; ?>"  data-body-id="body_<?php echo $comment->comment_ID; ?>"  data-parentid="<?php echo $comment->comment_post_ID; ?>"  data-post-status="<?php echo get_post_status($comment->comment_post_ID); ?>" data-body-id="body_<?php echo $comment->comment_ID; ?>">
    <div class="comment_header">
      <?php $comment_author = get_userdata( $comment->user_id ); ?>
          <?php if (get_field('pub_profile', 'user_'.$comment->user_id) == 'yes') {
            $pubprofile = ' data-pub="1" ';
          } else {
            $pubprofile = '';
          } ?>   
      <div class="comment_avatar"  <?php echo $pubprofile; ?> data-link="<?php echo 'https://eto-razvod.ru/user/'.$comment_author->user_nicename.'/'; ?>" <?php if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') { ?>style="background-image: url(<?php echo $attachment_id['sizes']['thumbnail']; ?>)" <?php }; ?>><?php if(is_registered_from_social($comment->user_id)['main'] && is_registered_from_social($comment->user_id)['main'] != 'none') { echo '<div class="social_provider_registered '.is_registered_from_social($comment->user_id)['main'].'"></div>'; }; ?></div>
      <div class="comment_meta">
        <div class="comment_author_wrapper">
          <?php $comment_author = get_userdata( $comment->user_id ); ?>       
          <span class="comment-author" itemprop="author" data-link="<?php echo 'https://eto-razvod.ru/user/'.$comment_author->user_nicename.'/'; ?>" <?php echo $pubprofile; ?>><?php if($comment_author->first_name && !$comment_author->last_name) { echo $comment_author->first_name; } elseif(!$comment_author->first_name && $comment_author->last_name) { echo $comment_author->last_name; } elseif($comment_author->first_name && $comment_author->last_name) { echo $comment_author->first_name.' '.$comment_author->last_name; } else { echo $comment_author->user_nicename; } ?></span>
          <?php echo $labelpro; ?>
        </div>
        <span class="comment-date" itemprop="datePublished" content="<?php comment_date( 'Y-m-d' ); ?>"><?php comment_date( 'j F Y в H:i' ); ?></span>
      </div>
           
            <?php
    /*
    if($is_abuse) {
                $abuse_state = get_field('abuse_state', $comment);
                if($abuse_state && !empty($abuse_state)) {
                  $abuse_state_value = $abuse_state['value'];
                  $abuse_state_label = $abuse_state['label'];
                } else {
                  $abuse_state_value = 'not_seen';
                  $abuse_state_label = __('ожидает','er_theme');
                }
                ?>
                <div class="comment_is_abuse <?php echo $abuse_state_value; ?>">
                    <div class="abuse_title"><?php _e('Жалоба','er_theme'); ?></div>
                    <div class="abuse_state"><?php echo $abuse_state_label; ?></div>
                </div>
            <?php }*/
                $total_rating = get_comment_rating_values($args['rating_fields'],$comment,'total');
          $total_rating_value = 5 / 100 * $total_rating;
          if ($total_rating != 0) {
            if ( $total_rating >= 70 ) {
              $rating_color = 'green';
            } elseif ( $total_rating >= 40 && $total_rating < 70 ) {
              $rating_color = 'orange';
            } elseif ( $total_rating < 40 ) {
              $rating_color = 'red';
            }
      ?>
                <div  class="comment_total_rating" itemprop="reviewRating" itemscope="" itemtype="https://schema.org/Rating">
                    <div class="c100 p<?php echo round($total_rating,0); ?> small <?php echo $rating_color;?>">
                        <span itemprop="ratingValue"><?php echo round($total_rating_value,1); ?></span>
                        <div class="slice">
                            <div class="bar1"></div>
                            <div class="fill"></div>
                        </div>
                    </div>
                    <meta itemprop="worstRating" content = "0.1" />
                    <meta itemprop="bestRating" content = "5" />
                </div>

            <?php }; 
            ?>
      <div class="comment_rate" id="rate-comment-<?php echo $comment->comment_ID; ?>">
          <span class="rate_plus rate_action" data-commentaction="plus" data-comment-id="<?php echo $comment->comment_ID; ?>"></span>
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
          <span class="rate_minus rate_action" data-commentaction="minus" data-comment-id="<?php echo $comment->comment_ID; ?>"></span>
        </div>
    </div>
    <?php if ($total_rating != 0) { ?>
            <div class="comment_rating_details">
        <?php echo get_comment_rating_values($args['rating_fields'],$comment,'list'); ?>
            </div>
    <?php }; ?>
    <?php 
	  
	  setup_postdata( $comment->comment_post_ID );
    echo '<a class="comment-post-link" href="#">'.get_the_title($comment->comment_post_ID).'</a>'; 
				wp_reset_postdata();?>
    <div class="comment-content">
      <div itemprop="reviewBody" class="comment_text comment_text_<?php echo $comment->comment_ID; ?>"><?php echo apply_filters('the_content', $comment->comment_content); ?></div>
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

    <div class="comment_footer">
            <?php
            $childcomments = get_comments(array(
              'post_id'   => get_the_ID(),
              'status'    => 'approve',
              'order'     => 'DESC',
              'parent'    => $comment->comment_ID,
            ));/*
            $comment_replies = count($childcomments);
            if (substr($comment_replies, -1) == 1) {
                $comment_replies_text = __('ответ','er_theme');
            } elseif(substr($comment_replies, -1) > 1 && substr($comment_replies, -1) < 5) {
              $comment_replies_text = __('ответа','er_theme');
            } else {
              $comment_replies_text = __('ответов','er_theme');
            }
            if($comment_replies != 0) { 
            ?>
                <div class="comment_reply_count"><?php echo $comment_replies; ?> <?php echo $comment_replies_text; ?></div>
            <?php } */?>
      <a rel="nofollow" class="comment-reply-link" data-commentid="<?php echo $comment->comment_ID; ?>" style="display:none" data-postid="<?php echo get_the_ID(); ?>" data-appendto="<?php comment_ID(); ?>">Ответить</a>
      <div class="comment_footer_right hovered_<?php echo $comment->comment_ID; ?>">
        
        <div class="comment_fast_links hovered_<?php echo $comment->comment_ID; ?>">
               <span class="comment_permalink"><i class="fas fa-link"></i></span>
               <span class="comment_share"><i class="fas fa-share-alt"></i></span>
               <span class="comment_more_actions"><i class="fas fa-bars"></i></span>
               <ul class="comment_more_actions_links comment_more_actions_links_<?php echo $comment->comment_ID; ?>">
            <li class="comment_more_actions_link_spam"><?php _e('Это спам','er_theme'); ?></li>
            <li class="comment_more_actions_link_abuse"><?php _e('Пожаловаться','er_theme'); ?></li>
          </ul>
       </div>
      </div>
    </div>
  </div>

  <?php // без закрывающего </li> (!)
  }


}

function get_comment_rating_fields($group_id,$field_name_type) {
	$rating = acf_get_fields($group_id);
	$rating_fields = array();
	foreach ($rating as $item) {
	    if($field_name_type == 'name') {
		    $rating_fields[] = array(
			    'field_label' => $item['label'],
			    'field_name'  => $item['name'],
			    'field_min'   => $item['min'],
			    'field_max'   => $item['max']
		    );
        } else {
		    $rating_fields[] = array(
			    'field_label' => $item['label'],
			    'field_name'  => $item['key'],
			    'field_min'   => $item['min'],
			    'field_max'   => $item['max']
		    );
	    }
	}
	return $rating_fields;
}


function get_comment_rating_values($rating,$comment,$format) {
    if ($format == 'list') {
	    if ( ! empty( $rating ) ) {
		    $result = '';
			$row_index = 0;
		    foreach ( $rating as $item ) {
				$row_index++;
			    $rating_value = get_field( $item['field_name'], $comment ) * 10 * 2;
			    if ( $rating_value >= 70 ) {
				    $rating_color = 'green';
			    } elseif ( $rating_value >= 40 && $rating_value < 70 ) {
				    $rating_color = 'orange';
			    } elseif ( $rating_value < 40 ) {
				    $rating_color = 'red';
			    }
				if($row_index % 2 == 0){ 
					$oddeven = 'even';  
				} 
				else{ 
					$oddeven = 'odd';
				}
			    $result .= '<div class="rating_row '.$oddeven.'">';
			    $result .= '<div class="row_title color_dark_gray">' . $item['field_label'] . '</div>';
			    $result .= '<div class="ratings">';
			    $result .= '<div class="rating_field ' . $rating_color . '"><div class="rating_value" style="width:' . $rating_value . '%"></div></div>';
			    $result .= '<span class="number color_dark_gray">' . round( $rating_value, 0 ) . '%</span>';
			    $result .= '</div>';
			    $result .= '</div>';
		    }
	    }
    } elseif($format == 'total') {
	    if ( ! empty( $rating ) ) {
		    $total_rating = array();
		    foreach ( $rating as $item ) {
			    $rating_value = get_field( $item['field_name'], $comment ) * 10 * 2;
			    $total_rating[] = $rating_value;
		    }
		    $rating_total_value = array_sum($total_rating);
		    $rating_count = count($total_rating);
		    $rating_total_result = $rating_total_value / $rating_count;
		    $result .= $rating_total_result;
	    }
    }
    return $result;
}

function check_user_post_review($post_id,$time,$ratings,$by_user) {
	$args = array(
	        'post_id' => $post_id,
	);
	if($by_user == true) {
		$args['user_id'] = get_current_user_id();
    }
	if(!empty($ratings)) {
		$args['meta_query'] = array(
			'relation' => 'AND'
        );
		foreach ($ratings as $rating ) {
			$args['meta_query'][] = array(
				'key' => $rating['field_name'],
				'compare' => 'EXISTS',
            );
		}
    }
	$comments = get_comments( $args );
	$result['count'] = count($comments);
	$comment_dates = array();
	foreach ($comments as $comment) {
		$comment_dates[] = $comment->comment_date;
	}
	$mostRecent= 0;
	foreach($comment_dates as $date){
		$curDate = strtotime($date);
		if ($curDate > $mostRecent) {
			$mostRecent = $curDate;
		}
	}
	$result['recent_review'] = $mostRecent;
	if($mostRecent < strtotime($time)) {
		$result['allowed_to_review'] = true;
	} else {
		$result['allowed_to_review'] = false;
    }
	return $result;


}

function show_comment_form($post_id,$form_id,$rating_fields_group) {
    $result = '';
	if ( is_user_logged_in() ) {

		if(is_singular('casino')) {
			$result .= custom_comment_form( $post_id, 0, __( 'Оставить отзыв', 'er_theme' ), '', __( 'Оставьте свой отзыв...', 'er_theme' ), $rating_fields_group,'form_review' );
		} else {
			$result .= custom_comment_form( $post_id, 0, '', __( 'Оставить комментарий', 'er_theme' ), __( 'Оставьте свой комментарий...', 'er_theme' ), 0,'form_review' );
		}
		
	} else {
		$result .= '<div class="comment_form" id="'.$form_id.'">';
		$result .= '<div class="auth_text">'.__('Пожалуйста, войдите или зарегистрируйтесь, чтобы оставить отзыв.','er_theme').'</div>';
		$result .= '<ul class="social_login_links">';
		$result .= '<li class="Email"></li>';
		$result .= '<li class="Google"><a onclick="javascript:auth_popup(\'Google\');"></a></li>';
		$result .= '<li class="Vkontakte"><a onclick="javascript:auth_popup(\'Vkontakte\');"></a></li>';
		$result .= '<li class="Yandex"><a onclick="javascript:auth_popup(\'Yandex\');"></a></li>';
		$result .= '<li class="Odnoklassniki"><a onclick="javascript:auth_popup(\'Odnoklassniki\');"></a></li>';
		$result .= '</ul>';
		$result .= '</div>';
		
	}
	return $result;
}

add_action( 'wp_ajax_file_upload_comment', 'file_upload_comment' );
add_action( 'wp_ajax_nopriv_file_upload_comment', 'file_upload_comment' );

function file_upload_comment() {
$arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
if (in_array($_FILES['file']['type'], $arr_img_ext)) {
    $upload = wp_upload_bits($_FILES["file"]["name"], null, file_get_contents($_FILES["file"]["tmp_name"]));
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');

    $filename = $upload['url'];
    $filepath =  $upload['file'];
    $filetype = wp_check_filetype( basename( $filename ), null );

    $wp_upload_dir = wp_upload_dir();
    $attachment = array(
        'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
        'post_mime_type' => $filetype['type'],
        'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $filename);
    apply_filters('wp_handle_upload', array('file' => $filepath, 'url' => $filename, 'type' => $filetype), 'upload');

    $attach_data = wp_generate_attachment_metadata( $attach_id, $filepath );
    wp_update_attachment_metadata( $attach_id, $attach_data );
    //update_field('photo_profile', $attach_id, 'user_'.get_current_user_id());
    //$attachment_id = get_field('photo_profile', 'user_'.get_current_user_id());
    $image_url = wp_get_attachment_url($attach_id);
    $result = array(
        'status' => 'ok',
        'uploadedfile' => $attach_id,
		'image_url' => $image_url
    ); 
    echo json_encode($result);
}
wp_die();
}
function url_isImage($l) {
    $arr = explode("?", $l);
    return preg_match("#\.(jpg|jpeg|gif|png)$# i", $arr[0]);
}
add_action( 'wp_ajax_add_file_by_link', 'add_file_by_link' );
add_action( 'wp_ajax_nopriv_add_file_by_link', 'add_file_by_link' );

function add_file_by_link() {
	$data = $_POST;
	$result = array();
	//print_r($data);
	//echo $data['parse_link'];
	if (filter_var($data['parse_link'], FILTER_VALIDATE_URL)) { 
		
		if(url_isImage($data['parse_link'])) {
			//echo 'image';
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			$url = $data['parse_link'];
			$timeout_seconds = 5;
			$temp_file = download_url( $url, $timeout_seconds );
			//print_r($temp_file);
			$typeimg = wp_check_filetype(basename($url));
			if ( !is_wp_error( $temp_file ) ) {
				$file = array(
					'name'     => basename($url), 
					'type'     => $typeimg['type'],
					'tmp_name' => $temp_file,
					'error'    => 0,
					'size'     => filesize($temp_file),
				);
				$overrides = array('test_form' => false,'test_size' => true);    
            	$results = wp_handle_sideload( $file, $overrides );
				if ( !empty( $results['error'] ) ) {        
					$result['status'] = 'error';
					$result['message'] = __('Невозможно прикрепить данное изображение','er_theme');
				} else {
					$filepath  = $results['file']; 
					$filename = $results['url'];  
					$filetype      = $results['type']; 
					$arr_img_ext = array('image/png', 'image/jpeg', 'image/webp', 'image/jpg', 'image/gif');
					if (in_array($filetype, $arr_img_ext)) {
						$upload = wp_upload_bits(basename( $filename ), null, file_get_contents($filepath));
						$filename = $upload['url'];
						$filepath =  $upload['file'];
						$filetype = wp_check_filetype( basename( $filename ), null );
						$wp_upload_dir = wp_upload_dir();
						$attachment = array(
							'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
							'post_mime_type' => $filetype['type'],
							'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
							'post_content'   => '',
							'post_status'    => 'inherit'
						);
						$attach_id = wp_insert_attachment( $attachment, $filename);
						apply_filters('wp_handle_upload', array('file' => $filepath, 'url' => $filename, 'type' => $filetype), 'upload');
						$attach_data = wp_generate_attachment_metadata( $attach_id, $filepath );
						wp_update_attachment_metadata( $attach_id, $attach_data );
						//echo $attach_id;
						$result['status'] = 'ok';
						$result['message'] = __('Изображение успешно загружено!','er_theme');
						$result['file'] = $attach_id;
						$image_url = wp_get_attachment_url($attach_id);
						$result['image_url'] = $image_url;
						$result['type'] = 'image';
					}
				}
			} else {
				$result['status'] = 'error';
				$result['message'] = __('Невозможно прикрепить данное изображение','er_theme');
			}
		} else {
			$url = $data['parse_link'];
			$url_components = parse_url($url); 
			parse_str($url_components['query'], $params);
			$video_id = $params['v'];
			if($video_id && $video_id != '') {
				
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				$url = 'http://img.youtube.com/vi/'.$video_id.'/sddefault.jpg';
				$timeout_seconds = 5;
				$temp_file = download_url( $url, $timeout_seconds );
				//print_r($temp_file);
				$typeimg = wp_check_filetype(basename($url));
				if ( !is_wp_error( $temp_file ) ) {
				$file = array(
					'name'     => basename($url), 
					'type'     => $typeimg['type'],
					'tmp_name' => $temp_file,
					'error'    => 0,
					'size'     => filesize($temp_file),
				);
				$overrides = array('test_form' => false,'test_size' => true);    
            	$results = wp_handle_sideload( $file, $overrides );
				if ( !empty( $results['error'] ) ) {        
					$result['status'] = 'error';
					$result['message'] = __('Невозможно прикрепить данное изображение','er_theme');
				} else {
					$filepath  = $results['file']; 
					$filename = $results['url'];  
					$filetype      = $results['type']; 
					$arr_img_ext = array('image/png', 'image/jpeg', 'image/webp', 'image/jpg', 'image/gif');
					if (in_array($filetype, $arr_img_ext)) {
						$upload = wp_upload_bits(basename( $filename ), null, file_get_contents($filepath));
						$filename = $upload['url'];
						$filepath =  $upload['file'];
						$filetype = wp_check_filetype( basename( $filename ), null );
						$wp_upload_dir = wp_upload_dir();
						$attachment = array(
							'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
							'post_mime_type' => $filetype['type'],
							'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
							'post_content'   => '',
							'post_status'    => 'inherit'
						);
						$attach_id = wp_insert_attachment( $attachment, $filename);
						apply_filters('wp_handle_upload', array('file' => $filepath, 'url' => $filename, 'type' => $filetype), 'upload');
						$attach_data = wp_generate_attachment_metadata( $attach_id, $filepath );
						wp_update_attachment_metadata( $attach_id, $attach_data );
						//echo $attach_id;
						$result['status'] = 'ok';
						$result['message'] = __('Изображение успешно загружено!','er_theme');
						$result['file'] = $attach_id;
						$result['video'] = $data['parse_link'];
						$image_url = wp_get_attachment_url($attach_id);
						$result['image_url'] = $image_url;
						$result['type'] = 'url';
					}
				}
			} else {
				$result['status'] = 'error';
				$result['message'] = __('Невозможно прикрепить данное изображение','er_theme');
			}
			}
			
			
		}
	} else {
		
		$result['status'] = 'error';
		$result['message'] = __('Пожалуйста, укажите действительный URL','er_theme');
	}
	echo json_encode($result);
	die;
}

add_action( 'wp_ajax_show_reply_form', 'show_reply_form' );
add_action( 'wp_ajax_nopriv_show_reply_form', 'show_reply_form' );

function show_reply_form() {
    $data = $_POST;
    $form_id = $data['form_id'];
	$post_id = $data['post_id'];
	$parent_id = $data['parent_id'];
	$result = '';
	if(is_user_logged_in()){
	$result .= custom_comment_form( $post_id, $parent_id, 0, __( 'Комментировать', 'er_theme' ), __( 'Оставьте свой комментарий...', 'er_theme' ), 0 ,$form_id);
		} else {
		$result .= '<div class="comment_form" id="'.$form_id.'">';
		$result .= '<div class="auth_text">'.__('Пожалуйста, войдите или зарегистрируйтесь, чтобы оставить комментарий.','er_theme').'</div>';
		$result .= '<ul class="social_login_links">';
		$result .= '<li class="Email"></li>';
		$result .= '<li class="Google"><a onclick="javascript:auth_popup(\'Google\');"></a></li>';
		$result .= '<li class="Vkontakte"><a onclick="javascript:auth_popup(\'Vkontakte\');"></a></li>';
		$result .= '<li class="Yandex"><a onclick="javascript:auth_popup(\'Yandex\');"></a></li>';
		$result .= '<li class="Odnoklassniki"><a onclick="javascript:auth_popup(\'Odnoklassniki\');"></a></li>';
		$result .= '</ul>';
		$result .= '</div>';
		
	}
	echo $result;
	echo '
	
	<script type="text/javascript">
                jQuery(document).ready(function($) {
	$(\'.social_login_links .Email\').click(function() {
			$.ajax({
                url: "'.admin_url("admin-ajax.php").'",
                type: "POST",
                data: "action=popup_login",
                beforeSend: function(xhr) {

                },
                success: function( data ) {
					$("#popup_comment_modal").html(data);
                    $("#popup_comment_modal .popup_container").show();
                }
            });
		});
		$(\'.form_file_icon\').click(function() {
			$(\'#reply_form .form_file_links\').toggleClass(\'visible\');
		});
	});
	</script>
		';

	die;
}



function rating_field($min,$max,$master_field,$field_name) {
    $result = '';
    $icon = '<span class="icon"></span>';
	foreach (range($min, $max) as $i) {
		$result .= '<label>';
	    $result .= '<input type="radio" name="'.$master_field.'['.$field_name.']" value="'.$i.'" />';
		$values_array = array_fill(1, $i, $icon);
		foreach ($values_array as $item) {
		    $result .= $item;
        }
		$result .= '</label>';
	}

    return $result;
}

function rating_field_admin($min,$max,$master_field,$field_name,$comment_id) {
    $result = '';
    $icon = '<span class="icon"></span>';
	$has_rating = get_field($field_name,'comment_'.$comment_id);
	
	foreach (range($min, $max) as $i) {
		
		$result .= '<label>';
		if($i == $has_rating) {
			$result .= '<input type="radio" name="'.$master_field.'['.$comment_id.']['.$field_name.']" value="'.$i.'" checked data-comment-id="'.$comment_id.'" data-field="'.$field_name.'" />';
		} else {
			$result .= '<input type="radio" name="'.$master_field.'['.$comment_id.']['.$field_name.']" value="'.$i.'" data-comment-id="'.$comment_id.'" data-field="'.$field_name.'" />';
		}
	    
		
		$values_array = array_fill(1, $i, $icon);
		foreach ($values_array as $item) {
		    $result .= $item;
        }
		
		$result .= '</label>';
		
	}

    return $result;
}


function custom_comment_form($post_id,$parent_id,$button_text,$button_text_comment,$textarea_placeholder,$rating_fields,$form_id) {
    $result = '';
	$user_pic = get_field('photo_profile', 'user_'. get_current_user_id() );
    $result .= '<div class="comment_form" id="'.$form_id.'">';
	$result .= '<div class="form_result"></div>';
    $result .= '<form id="'.$form_id.'_comment_form" method="post" action="'.admin_url('admin-ajax.php').'">';
	$result .= '<input type="hidden" name="action" value="submit_comment" />';
	$result .= '<input type="hidden" name="post_id" value="'.$post_id.'" />';
	$result .= '<input type="hidden" name="user_id" value="'.get_current_user_id().'" />';
	if($parent_id != 0){
		$result .= '<input type="hidden" name="parent_id" value="'.$parent_id.'" />';
    }

	$ratings = get_comment_rating_fields($rating_fields,'key');

	if($rating_fields != 0) {
		$result .= '<div class="form_columns">';
		$result .= '<div class="form_textarea form_review">';
		if($user_pic) {
			$result .= '<div class="form_user_pic" style="background-image: url('.$user_pic['sizes']['thumbnail'].');border-radius: 50%;"></div>';
		} else {
			$result .= '<div class="form_user_pic" style="border-radius: 50%;"></div>';
		}
		$result .= '<textarea name="comment_text" placeholder="'.$textarea_placeholder.'"></textarea>';
		$result .= '<div class="form_attached_files form_review"><ul></ul></div>';
		$result .= '<div class="form_file_icon"></div>';
		$result .= '<ul class="form_file_links">';
		$result .= '<li class="form_file_link_web">'.__('Загрузить из интернета','er_theme').'</li><li class="form_file_link_web_form"><textarea name="form_file_link_web_form_textarea" placeholder="'.__('Ссылка на изображение, видео (Youtube)','er_theme').'"></textarea><input type="submit" name="submit_link" value="'.__(' Добавить','er_theme').'" /></li>';
		$result .= '<li class="form_file_link_image">
<div class="form-group">
<div class="fileavatar-wrapper">
<div class="form-group" data-form-id="form_review">
<label class="label">
<span class="title">'.__('Загрузить с компьютера','er_theme').'</span>
<input type="file" id="fileavatar_comment" accept="image/*">
</label>
</div>
</div>
</div>
</li>';
		$result .= '</ul>';
		$result .= '</div>';
		$result .= '<div class="form_terms">'.__('Нам важна полнота информации о компании.  Просим вас оценить ее по этим критериям.','er_theme').'</div>';
		$result .= '<div class="form_column_left">';
	    foreach ($ratings as $item) {
	        $result .= '<div class="form_rating">';
		    $result .= '<div class="form_field_name">'.$item['field_label'].'</div>';
	        $result .= '<div class="rating">';
		    $result .= rating_field($item['field_min'],$item['field_max'],'rating',$item['field_name']);
		    $result .= '</div>';
		    $result .= '</div>';
        }
		$result .= '</div>';
		
		$result .= '<div class="form_column_right">';
		
		//$result .= '<div class="form_terms"><strong>'.__('Чтобы оставить отзыв, нужно дать оценку по всем пунктам.','er_theme').'</strong></div>';
		
		/*$result .= '<div class="is_abuse"><label for="is_abuse" class="control control-checkbox">'.__('Комментарий/отзыв является жалобой?','er_theme').'<input type="checkbox" name="is_abuse" id="is_abuse" /><div class="control_indicator"></div></label></div>';*/
		$result .= '<div class="form_submit"><input type="submit" class="submit_review" name="submit_review" value="'.$button_text.'" />';
		/*$result .= '<input type="submit" class="submit_comment" name="submit_comment" value="'.$button_text_comment.'" />';*/
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '<script type="text/javascript">
		             jQuery(document).ready(function($) {
		                $( ".submit_review" ).prop( "disabled", true );
		                $(".rating input").change(function(){
                        //alert(\'changed\');
                        if ($(\'.form_rating:not(:has(:radio:checked))\').length) {
                            //alert("At least one group is blank");
                            $( ".submit_review" ).prop( "disabled", true );
							$(\'textarea[name="comment_text"]\').attr("name", "comment_text");
                        } else {
		                   // alert("fine");
                            $( ".submit_review" ).prop( "disabled", false );
                            $( ".submit_comment" ).prop( "disabled", true );
                            $(\'textarea[name="comment_text"]\').attr("name", "review_text");
                         };
                        }); 
		             });
		             </script>';

    } else {
		$result .= '<div class="form_textarea reply_form">';
		if($user_pic) {
			$result .= '<div class="form_user_pic" style="background-image: url('.$user_pic['sizes']['thumbnail'].');border-radius: 50%;"></div>';
		} else {
			$result .= '<div class="form_user_pic" style="border-radius: 50%;"></div>';
		}
		$result .= '<textarea name="comment_text" placeholder="'.$textarea_placeholder.'"></textarea>';
		$result .= '<div class="form_attached_files reply_form"><ul></ul></div>';
		$result .= '<div class="form_file_icon"></div>';
		$result .= '<ul class="form_file_links">';
		$result .= '<li class="form_file_link_web">'.__('Загрузить из интернета','er_theme').'</li><li class="form_file_link_web_form"><textarea name="form_file_link_web_form_textarea" placeholder="'.__('Ссылка на изображение, видео (Youtube)','er_theme').'"></textarea><input type="submit" name="submit_link" value="'.__(' Добавить','er_theme').'" /></li>';
		$result .= '<li class="form_file_link_image">
<div class="form-group">
<div class="fileavatar-wrapper">
<div class="form-group" data-form-id="reply_form">
<label class="label">
<span class="title">'.__('Загрузить с компьютера','er_theme').'</span>
<input type="file" id="fileavatar_comment" accept="image/*">
</label>
</div>
</div>
</div>
</li>';
		$result .= '</ul>';
		$result .= '</div>';
		if($form_id == 'reply_form') {
			//$result .= '<div class="form_terms">' . __( 'Оставляя комментарий, вы соглашаетесь с правилами сайта.', 'er_theme' ) . '</div>';
		} else {
			//$result .= '<div class="form_terms">' . __( 'Ранее вы уже оставляли отзыв к этой странице, поэтому в течение 3-х месяцев вы можете оставлять к ней только комментарии и жалобы. Оставляя комментарий, вы соглашаетесь с правилами сайта.', 'er_theme' ) . '</div>';
		}
		$result .= '<div class="form_submit">';
		$result .= '<input type="submit" name="submit_comment" value="'.$button_text_comment.'" />';
		if($form_id != 'reply_form') {
			//$result .= '<div class="is_abuse"><label for="is_abuse" class="control control-checkbox">' . __( 'Комментарий является жалобой?', 'er_theme' ) . '<input type="checkbox" name="is_abuse" id="is_abuse" /><div class="control_indicator"></div></label></div>';
		}
		$result .= '</div>';
	}

	$result .= '</form>';
    $result .= '</div>';
    if( is_user_role( 'moderator_plus' ) ) {
        $resultformode = 'location.reload();';
    } else {
        $resultformode = '';
    }
    $result .= '
    <script type="text/javascript">
                jQuery(document).ready(function($) {
				
			

	$(\'#'.$form_id.'_comment_form\').on(\'submit\', function(e) {
		e.preventDefault();
		
		
		
	var $form = $(this);
		$.post($form.attr(\'action\'), $form.serialize(), function(data) {
		//alert(data);
		//вывод всего
    result = $.parseJSON(data);
    console.log(result.status);
    console.log(result.count);
    console.log(result);
    if (result.status == "ok") {
		$( "#'.$form_id.' .form_result" ).empty();
		$( "#'.$form_id.' .form_result" ).append( \'<span class="success">\'+result.texttoecho+\'</span>\');'.$resultformode.'
        

    if(data != \'Обнаружен дубликат комментария. Кажется, вы уже сказали это!\') {
        $( "#'.$form_id.' form" ).empty();
    };

    } else if (result.status == "error") {
      texttroubles = "";
      jQuery.each( $.parseJSON(result.troubles), function( i, val ) {
      texttroubles += "<span>"+val+"</span>";
      });
      $( "#'.$form_id.' form" ).find(".form_columns").after(\'<p class="spam_result_message style_ok">\'+texttroubles+\'</p>\')
      

    }
		//location.reload();
		
		});
	});
 
});
		</script>
		';
    return $result;
}
add_action( 'wp_ajax_better_acf_update_field', 'better_acf_update_field' );
add_action( 'wp_ajax_nopriv_better_acf_update_field', 'better_acf_update_field' );
function better_acf_update_field() {

	print_r($_POST);
	echo update_field($_POST['field_name'],$_POST['value'],$_POST['id']);
	die;
}


add_action( 'wp_ajax_submit_comment', 'submit_comment' );
add_action( 'wp_ajax_nopriv_submit_comment', 'submit_comment' );
function submit_comment() {
	$data = $_POST;
	 //print_r($data);
	$files = $data['files'];
	$links = $data['links'];
    $user_info = get_userdata($data['user_id']);
	$commentdata = array(
		'comment_post_ID'      => $data['post_id'],
		'comment_content'      => htmlspecialchars($data['comment_text']),
		'comment_author'       => $user_info->display_name,
		'comment_author_email' => $user_info->user_email,
		'comment_type'         => 'comment',
		'user_ID'              => $data['user_id'],
	);
	if($data['parent_id']) {
		$commentdata['comment_parent'] = $data['parent_id'];
    }

//	if($data['comment_text']) {
//		$commentdata['comment_content'] = htmlspecialchars($data['comment_text']);
//    } elseif($data['review_text']) {
//		$commentdata['comment_content'] = htmlspecialchars($data['review_text']);
//    }

$troubles = [];
$status= [];

  if (strlen(preg_replace('/\s+/', '', $commentdata['comment_content'])) == 0) {
    array_push($troubles, 'Вы не заполнили комменатарий');
    array_push($status, 'commentempty');
  }

$ok = 0;
$wp_set_comment_status = 0;
//делаем ссылку
if ((    get_field('services_user_services','user_'.get_current_user_id())[0] == 84178) || (get_field('services_user_services','user_'.get_current_user_id()) == 84178) || (is_user_role( 'moderator_plus' ))) {
$comment_post_type = get_post_type($data['post_id']);
if((in_array($comment_post_type,array('post'))) || (is_user_role( 'moderator_plus' ))) {

// $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// $linkset = parse_url($actual_link);
// $user = "/blog/";

// if(strpos($linkset['path'], $user) !== false){ 

  $textfrompost = $commentdata['comment_content'];
  $textfrompost = htmlspecialchars($textfrompost);
  $textexplode = explode(" ", $textfrompost);

  $regex = "((https?|ftp)\:\/\/)?";
  $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";
  $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})";
  $regex .= "(\:[0-9]{2,5})?";
  $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
  $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?";
  $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?";

  $textfull = '';
  $urlisnotempty = 0;
  foreach ($textexplode as $key => $value) {
  //echo strlen($value);      
  /////////////////////////////////////////////////////////////////////////////  
  $remove_go_from_text = rtrim($value, ".");
  //echo strlen($remove_go_from_text);
  if (strlen($value) == strlen($remove_go_from_text)) {
  $strwithdot = '';        
  } else {
  $strwithdot = '.'; 
  }
  /////////////////////////////////////////////////////////////////////////////
  $remove_go_from_text2 = rtrim($remove_go_from_text, "!");

  if (strlen($remove_go_from_text2) == strlen($remove_go_from_text)) {
  $strwithcomma = '';        
  } else {
  $strwithcomma = '!'; 
  }
  /////////////////////////////////////////////////////////////////////////////
  $remove_go_from_text3 = rtrim($remove_go_from_text2, ",");

  if (strlen($remove_go_from_text2) == strlen($remove_go_from_text3)) {
  $strwithup = '';        
  } else {
  $strwithup = ','; 
  }
  /////////////////////////////////////////////////////////////////////////////
  //echo strlen($remove_go_from_text);

  if(preg_match("/^$regex$/", $remove_go_from_text3)) 
  {     
  //if ($urlisnotempty != 1) {

  if (strpos($remove_go_from_text3, 'https://') !== false) {
  $textfull .= '<a href="'.htmlspecialchars($remove_go_from_text3).'">'.htmlspecialchars($remove_go_from_text3).'</a>'.$strwithdot.''.$strwithcomma.''.$strwithup.' ';
  } elseif (strpos($remove_go_from_text3, 'http://') !== false) {
  $textfull .= '<a href="'.htmlspecialchars($remove_go_from_text3).'">'.htmlspecialchars($remove_go_from_text3).'</a>'.$strwithdot.''.$strwithcomma.''.$strwithup.' ';
  } else {
  $textfull .= '<a href="https://'.htmlspecialchars($remove_go_from_text3).'">'.htmlspecialchars($remove_go_from_text3).'</a>'.$strwithdot.''.$strwithcomma.''.$strwithup.' ';
  }

  $urlisnotempty = 1;

  //} else {      
  //  $textfull .= htmlspecialchars($value).' ';
  //}
  } else {
  $textfull .= htmlspecialchars($value).' ';
  }
  }
  $commentdata['comment_content'] = '';
  $commentdata['comment_content'] = $textfull;
  $wp_set_comment_status = 1;
}
}
//делаем ссылку



if (count($troubles) == 0) {
  $new_comment = wp_new_comment( $commentdata );
  if($new_comment && !empty($data['rating']) && $data['review_text']) {
          foreach ($data['rating'] as $key => $value) {
              update_field($key,$value,'comment_'.$new_comment);
            }
    
    }


  if($new_comment) {
    if(!empty($files)) {
      //print_r($files);
      //print_r($links);
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



      global $wpdb, $post, $current_user;
      $userId = get_current_user_id();
      $where = 'WHERE comment_approved = 1 AND user_id = ' . $userId ;
      $comment_count = $wpdb->get_var("SELECT COUNT( * ) AS total 
                                       FROM {$wpdb->comments}
                                       {$where}");
      if ($comment_count < 101) {
        wp_set_comment_status($new_comment,0);
        $pubstatus = 0;
      } else {
        $pubstatus = 1;
      }
      if ($wp_set_comment_status == 1) {
        wp_set_comment_status($new_comment,0);
      }

      if( is_user_role( 'moderator_plus' ) ) {
          wp_set_comment_status($new_comment,1);
      }


      if($data['is_abuse'] == 'on') {
        //echo __( 'Спасибо! Ваша жалоба добавлена на сайт и отправлена представителям компании, которые, надеемся, в ближайшее время отреагируют. Чтобы увидеть жалобу в списке комментариев,', 'er_theme' );
        $texttoecho = 'Спасибо! Ваша жалоба добавлена на сайт и отправлена представителям компании, которые, надеемся, в ближайшее время отреагируют. Чтобы увидеть жалобу в списке комментариев, <a href="'.get_the_permalink($data['post_id']).'/#comment-'.$new_comment.'" onclick="window.location.reload()">'.__('обновите страницу','er_theme').'.</a>';

        update_field('is_abuse',1,'comment_'.$new_comment);
      } else {
        if ( $data['comment_text'] ) {
          if ($pubstatus == 1) {
            //echo __( 'Спасибо! Комментарий добавлен на сайт. Чтобы увидеть его,', 'er_theme' );
            $texttoecho = 'Спасибо! Комментарий добавлен на сайт. Чтобы увидеть его, <a href="'.get_the_permalink($data['post_id']).'/#comment-'.$new_comment.'" onclick="window.location.reload()">'.__('обновите страницу','er_theme').'.</a>';
          } else {
            //echo __( 'Спасибо! Ваш комментарий будет проверен модератором и добавлен на сайт.', 'er_theme' );
            $texttoecho = 'Спасибо! Ваш комментарий будет проверен модератором и добавлен на сайт.';
              if( is_user_role( 'moderator_plus' ) ) {
                  $texttoecho = 'Спасибо! Ваш комментарий был добавлен.';
              }
          }
        } elseif ( $data['review_text'] ) {
          if ($pubstatus == 1) {
            //echo __( 'Спасибо! Отзыв добавлен на сайт. Чтобы увидеть его,', 'er_theme' );
            $texttoecho = 'Спасибо! Отзыв добавлен на сайт. Чтобы увидеть его, <a href="'.get_the_permalink($data['post_id']).'/#comment-'.$new_comment.'" onclick="window.location.reload()">'.__('обновите страницу','er_theme').'.</a>';
          } else {
            $texttoecho = 'Спасибо! Ваш отзыв будет проверен модератором и добавлен на сайт.';
            //echo __( 'Спасибо! Ваш отзыв будет проверен модератором и добавлен на сайт.', 'er_theme' );
              if( is_user_role( 'moderator_plus' ) ) {
                  $texttoecho = 'Спасибо! Ваш комментарий был добавлен.';
              }
          }          
        }
      }
      if ($pubstatus == 1) {
        //echo ' <a href="'.get_the_permalink($data['post_id']).'/#comment-'.$new_comment.'" onclick="window.location.reload()">'.__('обновите страницу','er_theme').'.</a>';
      }
    };
    $ok = 1;
    $result = array(
       'status' => 'ok',
       'texttoecho' => $texttoecho,
       'count' => count($troubles)
    );
    echo json_encode($result);
} else {
      $result = array(
        'status' => 'error',
        'troubles' => json_encode($troubles),
        'count' => count($troubles)
    );
    echo json_encode($result);
}

	die;
}


	
add_action( 'wp_ajax_rate_comment_admin_stars', 'rate_comment_admin_stars' );
add_action( 'wp_ajax_nopriv_rate_comment_admin_stars', 'rate_comment_admin_stars' );
function rate_comment_admin_stars() {
	$data = $_POST;
	print_r($data);
	update_field($data['field'],$data['curr_value'],'comment_'.$data['comment_id']);
	die;
}

add_action( 'wp_ajax_update_comment_rate', 'update_comment_rate' );
add_action( 'wp_ajax_nopriv_update_comment_rate', 'update_comment_rate' );
function update_comment_rate() {
	$data = $_POST;
	//print_r($data);
	$current_rate = get_field('comment_rate','comment_'.$data['comment_id']);
	if(!$current_rate) {
		$current_rate = 0;
    }
	if($data['comment_action'] == 'plus') {
	    $new_rate = $current_rate + 1;
    } elseif($data['comment_action'] == 'minus') {
		$new_rate = $current_rate - 1;
    }
	//echo 'current rate'.$current_rate;
	//echo '<br />';
	//echo 'new rate'.$new_rate;
	update_field('comment_rate',$new_rate,'comment_'.$data['comment_id']);
	//echo $new_rate;
	if($new_rate == 0) {
		$rate_number_class = 'neutral';
		$comment_rate_plus = '';
	} elseif($new_rate > 0) {
		$rate_number_class = 'positive';
		$comment_rate_plus = '+';
	} elseif($new_rate < 0) {
		$rate_number_class = 'negative';
		$comment_rate_plus = '';
	}
	$result = array(
		'new_rate' => $comment_rate_plus.$new_rate,
		'new_class' => $rate_number_class,
	);
	echo json_encode($result);
	die;
}

function true_get_comment_depth( $comment_id ) {
	$depth = 0;
	while( $comment_id > 0  ) { // не знаю, можно ли тут обойтись без цикла, если знаете как, буду рад вашим предложениям
		$comment = get_comment( $comment_id );
		$comment_id = $comment->comment_parent;
		$depth++;
	}
	return $depth;
}

function check_rating($comment_id) {
	$count_check = 0;
	if(get_field('rating_service','comment_'.$comment_id) && get_field('rating_service','comment_'.$comment_id) != '' && get_field('rating_service','comment_'.$comment_id) != 0) {
		$count_check++;
	}
	
	if(get_field('rating_team','comment_'.$comment_id) && get_field('rating_team','comment_'.$comment_id) != '' && get_field('rating_team','comment_'.$comment_id) != 0) {
		$count_check++;
	}
	
	if(get_field('rating_quality','comment_'.$comment_id) && get_field('rating_quality','comment_'.$comment_id) != '' && get_field('rating_quality','comment_'.$comment_id) != 0) {
		$count_check++;
	}
	
	if(get_field('rating_price','comment_'.$comment_id) && get_field('rating_price','comment_'.$comment_id) != '' && get_field('rating_price','comment_'.$comment_id) != 0) {
		$count_check++;
	}
	
	return $count_check;
}

function my_admin_menu() {
	$curr_user_id = get_current_user_id();
		if(in_array($curr_user_id,array(9,1,2,17,14,12,6))) {
			add_menu_page(
				__( 'Импорт из Cackle', 'er_theme' ),
				__( 'Импорт из Cackle', 'er_theme' ),
				'manage_options',
				'import-from-cackle',
				'my_admin_page_contents',
				'dashicons-schedule',
				3
			);
		}
	}

	//add_action( 'admin_menu', 'my_admin_menu' );


	function my_admin_page_contents() {
		 wp_enqueue_style('comments', get_template_directory_uri() . '/css/comments.css');
		?>
			<h1>
				<?php esc_html_e( 'Импорт комментариев из Cackle', 'er_theme' ); ?>
			</h1>
			
		<?php
		$args = array(
			//'number' => 200,
		);
		if($_GET['by_user'] && $_GET['by_user'] != '') {
			$args['user_id'] = $_GET['by_user'];
			
		}
		if($_GET['comment_post_id'] && $_GET['comment_post_id'] != '') {
			$args['post_id'] = $_GET['comment_post_id'];
			
		}
		$comments = get_comments($args); ?>
		
		<?php
		if(!empty($comments)) {
			foreach($comments as $comment){
				if(true_get_comment_depth($comment->comment_ID) > 1) {
					continue;
				} else {
					$count_mess = '';
					$comment_message = $comment->comment_content;
					$count_mess = iconv_strlen($comment_message);
					if($count_mess > 1) {
						$post_type = get_post_type($comment->comment_post_ID);
						if(!in_array($post_type,array('casino')) || check_rating($comment->comment_ID) == 4) {
							continue;
						} else {
							$comments_result[] = $comment;
						}
							

					} else {
						continue;
					}
					
				}
				
			}
		}
		if(!empty($comments_result)) {
			echo count($comments_result);
			echo '<table class="wp-list-table widefat fixed striped table-view-list posts">';
			echo '<thead>';
			echo '<tr>';
			echo '<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Выделить все</label><input id="cb-select-all-1" type="checkbox"></td>';
			echo '<th scope="col" id="title" class="manage-column column-primary sortable desc">'.__('Текст комментария','er_theme').'</th>';
			echo '<th scope="col" id="author" class="manage-column column-comment_rating" width="300px">'.__('Оценка','er_theme').'</th>';
			echo '<th scope="col" id="author" class="manage-column column-comment_date" width="180px">'.__('Дата','er_theme').'</th>';
			echo '<th scope="col" id="author" class="manage-column column-comment_user" width="180px">'.__('Пользователь','er_theme').'</th>';
			echo '<th scope="col" id="author" class="manage-column column-comment_post" width="150px">'.__('Страница','er_theme').'</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody id="the-list">';
			$coo = 0;
			foreach($comments_result as $comment){
				
				$coo++;
				if($coo == 100) {
					break;
				}
			
				echo '<tr>';
				echo '<th scope="row" class="check-column">			<label class="screen-reader-text" for="cb-select-'.$comment->comment_ID.'">'.__('Выбрать','er_theme').'</label>
			<input id="cb-select-'.$comment->comment_ID.'" type="checkbox" name="comment[]" value="'.$comment->comment_ID.'">
			<div class="locked-indicator">
				<span class="locked-indicator-icon" aria-hidden="true"></span>
				
			</div>
			</th>';
				$page = get_post($comment->comment_post_ID);
				$attachment_id = get_field('photo_profile', 'user_'. $comment->user_id );
				echo '<td>'.$comment->comment_content.'</td>';
				echo '<td>';
				if(true_get_comment_depth($comment->comment_ID) > 1) {
					echo __('Это комментарий, не отзыв!','er_theme');
				} else {
				//echo get_comment_rating_values(get_comment_rating_fields(87485,'key'),$comment,'list');
					
					$ratings = get_comment_rating_fields(87485,'key');

							foreach ($ratings as $item) {
	        echo '<div class="form_rating">';
		    echo '<div class="form_field_name">'.$item['field_label'].'</div>';
	        echo '<div class="rating">';
		    echo rating_field_admin($item['field_min'],$item['field_max'],'rating',$item['field_name'],$comment->comment_ID);
		    echo '</div>';
		    echo '</div>';
        }
					
					
					
					
				}
				echo '</td>';
				echo '<td>'.$comment->comment_date_gmt.'</td>';
				echo '<td>';
				echo '<a href="/wp-admin/admin.php?page=import-from-cackle&by_user='.$comment->user_id.'">';
				?><div class="comment_avatar" <?php if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') { ?>style="background-image: url(<?php echo $attachment_id['sizes']['thumbnail']; ?>)" <?php }; ?>><?php if(is_registered_from_social($comment->user_id)['main'] && is_registered_from_social($comment->user_id)['main'] != 'none') { echo '<div class="social_provider_registered '.is_registered_from_social($comment->user_id)['main'].'"></div>'; }; ?></div><?php
				$comment_author = get_userdata( $comment->user_id ); 
				if($comment_author->first_name && !$comment_author->last_name) { 
					echo $comment_author->first_name; 
				} elseif(!$comment_author->first_name && $comment_author->last_name) { 
					echo $comment_author->last_name; 
				} elseif($comment_author->first_name && $comment_author->last_name) { 
					echo $comment_author->first_name.' '.$comment_author->last_name; } else { 
					echo $comment_author->user_nicename; 
				}
				echo '</a>';
				echo '</td>';
				echo '<td><a href="/wp-admin/admin.php?page=import-from-cackle&comment_post_id='.$comment->comment_post_ID.'">'.$page->post_title.'</a>';
				$term_slug = get_term( get_field('company_type',$comment->comment_post_ID), 'companytypes' )->name;
				echo '<div>'.$term_slug.'</div>';
				echo '</td>';
				echo '</tr>';
			}
			echo '</tbody>';
			echo '</table>';
			echo '
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$(".rating input").change(function(){
									//alert(\'changed\');
									var curr_value = $(this).val();
									var field = $(this).attr(\'data-field\');

									var comment_id = $(this).attr(\'data-comment-id\');
									//alert(curr_value);
									//alert(field);
									//alert(comment_id);
									$.ajax({
										url: "'.admin_url("admin-ajax.php").'",
										type: "POST",
										data: "action=rate_comment_admin_stars&curr_value="+curr_value+"&field="+field+"&comment_id="+comment_id,
										beforeSend: function(xhr) {

										},
										success: function( data ) {
											//alert(data);
											
										}
									});
					});
				});
			</script>
			
			';
		}
	}

function get_comments_count($post_id,$ratings) {
	$args = array(
		'post_id' => $post_id,
        'parent' => 0,
		'number' => ''
	);
	if(!empty($ratings) && $ratings != 0) {
		$args['meta_query'] = array(
			'relation' => 'AND'
		);
		foreach ($ratings as $rating ) {
			$args['meta_query'][] = array(
				'key' => $rating['field_name'],
				'compare' => 'EXISTS',
			);
		}
	}
	$comments = get_comments( $args );
	//echo '<pre>';
	//print_r($comments);
	//echo '</pre>';
	$result['count'] = count($comments);
	$result['negative'] = 0;
	$result['positive'] = 0;
	if(!empty($ratings) && $ratings != 0) {
		$result['ratings_total'] = array();

		$result['ratings'] = array();
		$x = 0;
		foreach ($comments as $comment) {
		    $x++;
		    //print_r($comment);
			$result['ratings'][$x] = array(
                'comment_id' => $comment->comment_ID,
            );
			$result['ratings'][$x]['rating_fields'] = array();
			$result['ratings'][$x]['numbers'] = array();
			foreach($ratings as $rating) {
				$result['ratings'][$x]['rating_fields'][] = array(
				        'field_name' => $rating['field_name'],
                        'field_value' => get_field($rating['field_name'],$comment),
                );
				$result['ratings_total'][$rating['field_name']]['values'][] = get_field($rating['field_name'],$comment);
				$result['ratings'][$x]['numbers'][] = get_field($rating['field_name'],$comment);
            }
			$result['ratings'][$x]['average'] = array_sum($result['ratings'][$x]['numbers']) / count($result['ratings'][$x]['rating_fields']);
			if($result['ratings'][$x]['average'] <= 2) {
				$result['negative']++;
			} else {
				$result['positive']++;
			}
        }
		foreach($ratings as $item) {
			$item_count = count($result['ratings_total'][$item['field_name']]['values']);
			$item_sum = array_sum($result['ratings_total'][$item['field_name']]['values']);
			$result['ratings_total'][$item['field_name']]['count_all'] = $item_count;
			$result['ratings_total'][$item['field_name']]['sum'] = $item_sum;
			$result['ratings_total'][$item['field_name']]['total'] = $item_sum / $item_count;
		}

	}
	
	if($result['count'] == 0) {
		$result['negative_percent'] = 0;
		$result['positive_percent'] = 0;
	} else {
		$result['negative_percent'] = round(($result['negative'] / $result['count'] * 100),0);
		$result['positive_percent'] = round(($result['positive'] / $result['count'] * 100),0);
	}
	
	return $result;
}


function page_single_rating($post_id) {
	
	$res = '';
	$page_rate_count = get_field('page_rate_count',$post_id);
	$page_rate_rating = get_field('page_rate_rating',$post_id);
    $pgname = 'page_rate_'.$post_id;

    if (isset($_COOKIE[$pgname])) {
        $pgnameclass = '<span class="pgname"></span>';
    } else {
        $pgnameclass = '';
    }

    $res .= '<div class="page_simple_rating">'.$pgnameclass;
	$icon = '<span class="icon"></span>';
	$res .= '<div class="rating">';
	foreach (range(1, 5) as $i) {
		
		$res .= '<label>';
		if($i == round($page_rate_rating)) {
			$res .= '<input type="radio" name="page_single_rate" value="'.$i.'" checked data-comment-id="'.$post_id.'" />';
		} else {
			$res .= '<input type="radio" name="page_single_rate" value="'.$i.'" data-comment-id="'.$post_id.'" />';
		}
	    
		
		$values_array = array_fill(1, $i, $icon);
		foreach ($values_array as $item) {
		    $res .= $item;
        }
		
		$res .= '</label>';
		
	}
	
	$res .= '</div>';
	if($page_rate_count && $page_rate_count != 0 && $page_rate_rating && $page_rate_rating != 0) {
	$res .= '<div class="rating_page_text" itemprop="aggregateRating"
    itemscope itemtype="http://schema.org/AggregateRating">';
	$res .= '<span class="rating_page_text_rating" itemprop="ratingValue">'.number_format( $page_rate_rating, 2, '.', '' ).'</span>';
	$res .= ' / ';
	$res .= '<span class="rating_page_text_count" itemprop="ratingCount">'.$page_rate_count.'</span>';
		
		$res                          .= '<meta itemprop="itemReviewed" content="' . get_the_title( $post_id ) . '" />';
	$res .= '</div>';
	} else {
		$res .= '<div class="rating_page_text">';
		$res .= '<span class="rating_page_text_rating"></span>';
		$res .= '</div>';
		//$res .= ' / ';
		//$res .= '<span class="rating_page_text_count"></span>';
	}
	
	$res .= '</div>';
	
	$res .= '
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$(".rating input").click(function(){
									//alert(\'changed\');
									var curr_value = $(this).val();
									var post_id = $(this).attr(\'data-comment-id\');
									//alert(curr_value);
									//alert(field);
									//alert(post_id);
									$.ajax({
										url: "'.admin_url("admin-ajax.php").'",
										type: "POST",
										data: "action=page_single_rating_rate&curr_value="+curr_value+"&post_id="+post_id,
										beforeSend: function(xhr) {

										},
										success: function( data ) {
											//alert(data);
											result = JSON.parse(data);
											//alert(result.count);
											//alert(result.rating);
											$(".page_simple_rating").prepend("<span class=\"pgname\"></span>");
											$(\'.rating_page_text .error\').remove();';
	if($page_rate_count && $page_rate_count != 0 && $page_rate_rating && $page_rate_rating != 0) {
	$res .= '$(".rating_page_text_count").empty();
	$(".rating_page_text_count").text(result.count);';
	} else {
		$res .= '$(".rating_page_text").append(\'<span class="rating_page_text_count"> / \'+result.count+\'</span>\');';
	}
											
	$res .= ' 								$(".rating_page_text_rating").empty();
											
											$(".rating_page_text_rating").text(result.rating);
											if(result.error) {
											//alert(result.error);
											
												$(".rating_page_text").append(\'<span class="error">\'+result.error+\'</span>\');
												setTimeout(function() {
  													$(\'.rating_page_text .error\').remove();
													}, 2000);
											}
										}
									});
					});
				});
			</script>
			
			';
	return $res;
}

add_action( 'wp_ajax_page_single_rating_rate', 'page_single_rating_rate' );
add_action( 'wp_ajax_nopriv_page_single_rating_rate', 'page_single_rating_rate' );
function page_single_rating_rate() {
	$data = $_POST;
	
	$cookie_id = 'page_rate_'.$data['post_id'];
    $visit_time = date('F j, Y  g:i a');
	//print_r($data);
	$page_rate_count = get_field('page_rate_count',$data['post_id']);
	$page_rate_rating = get_field('page_rate_rating',$data['post_id']);
	if(!isset($_COOKIE[$cookie_id])) {
	
	if($page_rate_count && $page_rate_count != '' && $page_rate_rating && $page_rate_rating != '') {
		$new_count = $page_rate_count+1;
		$new_rating = ($page_rate_rating + $data['curr_value']) / 2;
	} else {
		$new_count = 1;
		$new_rating = $data['curr_value'];
	}
	update_field('page_rate_count',$new_count,$data['post_id']);
	update_field('page_rate_rating',$new_rating,$data['post_id']);
	$result = array(
		'count' => $new_count,
		'rating' => number_format( $new_rating, 2, '.', '' ),
		
	);
	

    

        // set a cookie for 1 year
        setcookie($cookie_id, $visit_time, strtotime("+1 year"), '/');

    } else {
		$result = array(
			'count' => $page_rate_count,
			'rating' => number_format( $page_rate_rating, 2, '.', '' ),
			'error' => __('Вы уже голосовали за эту страницу!','er_theme')
		);
	}
	echo json_encode($result);
	die;
}




if(!function_exists('comment_link_spam')) {
add_action( 'wp_ajax_comment_link_spam', 'comment_link_spam' );
add_action( 'wp_ajax_nopriv_comment_link_spam', 'comment_link_spam' );

	function comment_link_spam() {
		global $wpdb;
		if(is_user_logged_in()) {
			$cur_user_id = get_current_user_id();
			$comment_id = $_POST['comment_id'];
			$check_cookie = check_cookie('link_spam_u_'.$cur_user_id.'_c_'.$comment_id);
			if($check_cookie == 'no') {
				$mail_key = wp_generate_uuid4();
				$message = array();
				$headers = array(
					'From: Eto-Razvod <check@eto-razvod.info>',
					'content-type: text/html'
				);
				$subject = __('Жалоба на комментарий #','er_theme').$comment_id;
				$text = '';


				$user = get_user_by( 'id', $cur_user_id );
				$text .= __('Здравствуйте. Поступила жалоба на спам в комментарии #','er_theme').$comment_id;
				$text .= __(' от пользователя ');
				$text .= $user->display_name.' ('.$user->user_email.')';
				$text .= __('. Ссылка на комментарий: ');
				$text .= get_comment_link($comment_id);
				$text .= '<img src="https://eto-razvod.ru/engine/mail_update_status.php?key='.$mail_key.'" style="width:1px; height:1px;" />';

				$mailResult = false;
				$mailResult = wp_mail( 'me@artemsaveliev.com', $subject, $text, $headers );
				if($mailResult == true) {
					$message['status'] = 'ok';
					$message['message'] = __('Жалоба на спам отправлена','er_theme');

					date_default_timezone_set( 'Europe/Moscow' );
					$mydb = new wpdb('sendmail','hsd8SGDDdhus','sendmails','localhost');
					$user = get_user_by( 'ID', $cur_user_id );
					$user2 = get_userdata($user->ID);
					//$mail_key = wp_generate_uuid4();

					$mydb->insert(
						'mails',
						array('status'=> 'not_sent','reg_date' => $user2->data->user_registered,'user_id' => $user2->data->ID, 'mail_type' => 'comment_spam_form','mail_key' => $mail_key, 'sent' => date('Y-m-d H:i:s')),
						array( '%s', '%s', '%s','%s','%s','%s')
					);

					$mail = $mydb->get_results("select * from mails WHERE mail_key = '$mail_key'");

					$mydb->update(
						'mails',
						array('status'=> 'sent'),
						array( 'id' => $mail[0]->id ),
						array( '%s' )
					);
					$mydb->update(
						'mails',
						array('updated'=> date('Y-m-d H:i:s')),
						array( 'id' => $mail[0]->id ),
						array( '%s' )
					);
					set_cookie('link_spam_u_'.$cur_user_id.'_c_'.$comment_id,'31556926');
				} else {
					$message['status'] = 'error';
					$message['message'] = __('Ошибка отправки жалобы. Пожалуйста, сообщите администратору на info@eto-razvod.ru.','er_theme');
				}
			} else {
				$message['status'] = 'error';
				$message['message'] = __('Вы уже отправляли жалобу на этот комментарий','er_theme');
			}
		
		} else {
			$message['status'] = 'auth';
			$message['message'] = __('Пожалуйста, авторизуйтесь, чтобы пожаловаться на спам в комментарии.','er_theme');
		}
		
		$result = json_encode($message);
		echo $result;
			
		die;
	}

}





?>