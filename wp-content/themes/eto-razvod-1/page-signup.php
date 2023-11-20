<?php
if (( is_user_logged_in())) {
	wp_redirect('/');
	exit;
}
get_header();

if (have_posts()) :
	while (have_posts()) : the_post();
$page_rate_count = get_field('page_rate_count',$post->ID);

		?>
        <div class="page_content page_container review_container_content single_container visible single_news" <?php if($page_rate_count && $page_rate_count != 0 && $page_rate_count != '') { ?>itemprop="itemReviewed" itemscope itemtype="https://schema.org/Product"<?php } ?>>
            <div class="wrap flex_column">
                <?php
                $result = '<div class="popup_window reg_form_main">';
                $result .= '<div class="popup_columns two_columns">';
                $result .= '<div class="popup_column_left flex_column align_left flex_padding">';
                $result .= '<div class="title font_new_medium color_dark_blue font_bold m_b_20">'.__('Регистрация','er_theme').'</div>';
                $result .= '<form class="regform flex flex_column"  action="'.admin_url( 'admin-ajax.php' ).'" method="post" id="popup_reg_form">';
                $result .= '<ul class="reg_type_links font_small flex">';
                $result .= '<li data-type="user" class="active">'.__('Я пользователь','er_theme').'</li>';
                $result .= '<li data-type="company" class="last inactive">'.__('Я представитель компании','er_theme').'</li>';
                $result .= '</ul>';
                $result .= '<input type="hidden" name="reg_type" value="user" />';
                $result .= '<input type="hidden" name="action" value="user_registration" />';
                $result .= '<input type="email" name="email" placeholder="'.__('Ваш E-mail','er_theme').'" class="input_big m_b_10 placeholder_dark">';
                $result .= '<div class="input_columns">';
                $result .= '<input type="text" name="firstname" placeholder="'.__('Имя','er_theme').'" class="input_big m_b_10 placeholder_dark">';
                $result .= '<input type="text" name="lastname" placeholder="'.__('Фамилия','er_theme').'" class="input_big m_b_10 placeholder_dark">';
                $result .= '<input type="text" name="thispage" value="notpopup" class="input_big m_b_10 placeholder_dark" style="display:none;">';
                $result .= '</div>';
                $result .= '<input type="password" name="password" placeholder="'.__('Пароль','er_theme').'" class="input_big m_b_10 placeholder_dark">';
                $result .= '<input type="password" name="password_repeat" placeholder="'.__('Повторите пароль','er_theme').'" class="input_big m_b_10 placeholder_dark">';
                $result .= '<input type="submit" name="submit" class="button button_big button_violet m_b_10 pointer font_small font_bold" value="'.__('Зарегистрироваться','er_theme').'" id="regbtn">';
                $result .= '<div class="link_container"><a class="span_link link_terms_popup color_blue pointer font_small" href="'.get_bloginfo('url').'/rules/" target="_blank">'.__('Условия пользования сайтом','er_theme').'</a></div>';
                $result .= '</form>';
                $result .= '</div>';
                $result .= '<div class="popup_column_right flex_column align_left">';
                $result .= '<div class="flex_row flex_padding">';
                $result .= '<div class="title font_new_medium color_dark_blue font_bold m_b_20">'.__('Используйте сервисы для регистрации','er_theme').'</div>';
                $result .= '<ul class="reg_type_links font_small flex">';
                $result .= '</ul>';
                $result .= social_login_icons('full');
                $result .= '</div>';
                $result .= '<div class="flex_row flex_padding">';
                $result .= '<div class="title color_dark_blue font_bold m_b_20">'.__('У вас уже есть аккаунт?','er_theme').'</div>';
                $result .= '<a href="/signin/" rel="nofollow" class="display_block button button_big button_green m_b_10 pointer font_bold font_small link_no_underline">'.__('Войти в мой аккаунт','er_theme').'</a>';
                $result .= '<div class="link_container"><a href="/forgot-password/" rel="nofollow" class="span_link color_blue pointer font_small">'.__('Восстановить пароль','er_theme').'</a></div>';
                $result .= '</div>';
                $result .= '</div>';
                $result .= '</div>';
                $result .= '</div>';
                echo $result;
                ?>
                </div>



            </div>
        </div>

	<?php
	endwhile;
endif;


get_footer();

?>