<?php
get_header();

if (have_posts()) :
	while (have_posts()) : the_post();
		$page_rate_count = get_field('page_rate_count',$post->ID);

		?>
		<?php echo print_css_links('review_content') ?>
		<?php wp_enqueue_script( 'user_reset_password', get_template_directory_uri() . '/js/user_reset_password.js', array('jquery'), $special_word ); ?>
        <div class="page_content page_container review_container_content single_container visible single_news" <?php if($page_rate_count && $page_rate_count != 0 && $page_rate_count != '') { ?>itemprop="itemReviewed" itemscope itemtype="https://schema.org/Product"<?php } ?>>
            <div class="wrap flex_column">
						<?php
						function formsetter()
						{
							/*$formedrun = '<div class="block_content flex flex_column justify-content-center" id="rp">';
							$formedrun .= '<span class="title-rp color_dark_gray font_small smw_center">Укажите Ваш e-mail</span>';
							$formedrun .= '<input class="input_big m_b_10 placeholder_dark border_radius_4px block_input" type="text" placeholder="E-mail" id="emailget">';
							$formedrun .= '<input class="block_button button button_green button_padding_big font_small font_bold button_centered pointer" type="button" value="Восстановить" id="rpgo">';
							$formedrun .= '<span class="rpmessage" style="display:none;"></span>';
							$formedrun .= '</div>';*/
							$result = '<div class="popup_window reg_form_main">';
							$result .= '<div class="popup_columns two_columns">';
							$result .= '<div class="popup_column_left flex_column align_left flex_padding">';
							$result .= '<div class="title font_new_medium color_dark_blue font_bold m_b_20">'.__('Восстановление пароля','er_theme').'</div>';
							$result .= '<form class="regform flex flex_column"  action="'.admin_url( 'admin-ajax.php' ).'" method="post" id="popup_reset_password_new">';
							$result .= '<input type="hidden" name="action" value="user_reset_password_new" />';
							$result .= '<input type="text" name="email" placeholder="'.__('Ваш E-mail','er_theme').'" class="input_big m_b_10 placeholder_dark">';
							$result .= '<input type="submit" name="submit" class="button button_big button_green m_b_10 pointer font_small font_bold" value="'.__('Восстановить пароль','er_theme').'" id="regbtn">';
							$result .= '</form>';
							$result .= '</div>';
							$result .= '<div class="popup_column_right flex_column align_left">';
							$result .= '<div class="flex_row flex_padding">';
							$result .= '<div class="title font_new_medium color_dark_blue font_bold m_b_20">'.__('Используйте сервисы для входа','er_theme').'</div>';
							$result .= social_login_icons('full');
							$result .= '</div>';
							$result .= '<div class="flex_row flex_padding">';
							$result .= '<a href="/signin/" class="display_block button button_big button_green m_b_10 pointer font_bold font_small link_no_underline">'.__('Войти в мой аккаунт','er_theme').'</a>';
							$result .= '<a href="/signup/" class="display_block button button_big button_violet m_b_10 pointer font_bold font_small link_no_underline">'.__('Создать аккаунт','er_theme').'</a>';
							$result .= '</div>';
							$result .= '</div>';
							$result .= '</div>';
							$result .= '</div>';
							echo $result;
						}
						?>
						<?php
						function formgetresult($a)
						{

						    $formedrun = '<div class="page_content page_container review_container_content single_container visible single_news"><div class="wrap flex_column">';
                            $formedrun .= '<div class="the_content color_dark_blue">';
                            $formedrun .= '<h1 class="m_b_30" style="text-align: center;">'.get_the_title().'</h1>';
                            $formedrun .= '<div class="wrap-set" style="text-align: center;">';
							$formedrun .= '<span class="title-rp color_dark_gray font_small smw_center">Введите пароли</span>';
							$formedrun .= '<input class="block_input block_input_username" type="text" placeholder="" value="'.$a.'" style="display:none;">';
							$formedrun .= '<div class="password-wp flex justify-content-center"><input class="input_big m_b_10 placeholder_dark border_radius_4px block_input block_input_psw1" type="password" placeholder="Укажите пароль"><span class="showerbtnpassword" onclick="showfuncnew()" style="display: none;"><i class="far fa-eye"></i></span></div>';
							$formedrun .= '<div class="password-wp flex justify-content-center"><input class="input_big m_b_10 placeholder_dark border_radius_4px block_input block_input_psw2" type="password" placeholder="Повторите пароль"><span class="showerbtnpassword" onclick="showfuncnew()" style="display: none;"><i class="far fa-eye"></i></span></div>';
							$formedrun .= '<span class="passwordtested" style="display:none;"></span>';
							$formedrun .= '<input class="block_button button button_green button_padding_big font_small font_bold button_centered pointer" type="button" value="Установить пароль" id="rpgosetnewpassword">';
							$formedrun .= '</div></div></div></div>';
							echo $formedrun;
						}
						?>
						<?php if (($_GET['key']) && ($_GET['login'])) {
							$is_ok = check_password_reset_key( $_GET['key'], $_GET['login'] );

							if( is_wp_error($is_ok) ){
								//echo '<div class="block_content" id="rp">';
								formsetter();
								echo '<span class="rpmessage" id="rpmessage_error">'.$is_ok->get_error_message().'</span>';
								//echo '</div>';
							}
							else {
								echo '<div class="block_content flex flex_column justify-content-center" id="rp">';
								$a = $_GET['login'];
								formgetresult($a);
								echo '<span class="rpmessage"></span>';
								echo '</div>';
							}

						} else {
							formsetter();
						} ?>
            </div>
        </div>
	<?php endwhile;
endif; ?>
<?php get_footer();
?>