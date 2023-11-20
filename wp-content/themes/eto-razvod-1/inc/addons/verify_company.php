<?php




if (!function_exists('ajax_verify_company_block')) {
	add_action( 'wp_ajax_ajax_verify_company_block', 'ajax_verify_company_block' );
	add_action( 'wp_ajax_nopriv_ajax_verify_company_block', 'ajax_verify_company_block' );
	function ajax_verify_company_block() {
		$data = $_POST;
		$post_id = $data['post_id'];
		if(get_post_type($data['post_id']) == 'promocodes') {
				$post_id = get_field('promocode_review',$data['post_id']);
			}
		$result = '';		
		$result .= '<div class="verify_company_widget">';
		
		/*$result .= '<div class="side_block white_block widget_link_company pointer flex flex_column" data-id="'.$post_id.'">';
			$result .= '<div class="font_bolder color_white m_b_15">'.__('Это развод™ для компаний','er_theme').'</div>';
			$result .= '<div class="color_white m_b_20 font_small font_bold">'.__('Улучшайте SEO, приглашайте клиентов писать отзывы и отвечайте им бесплатно','er_theme').'</div>';
			$result .= '<div class="button button_green font_small font_bold">'.__('Получить доступ','er_theme').'</div>';
		$result .= '</div>';*/
		
		/*$result .= '<div class="side_block white_block">';
				$result .= '<div class="block_title font_smaller_2 font_bolder font_uppercase color_dark_blue">'.__('Это ваша компания?','er_theme').'</div>';
				$result .= '<div class="block_content font_smaller line_22">';
				$result .= '<p>'.__('Подайте заявку на профиль своей компании, чтобы получить доступ к бесплатным бизнес-инструментам Это развод™','er_theme').'</p>';
				$result .= '<a class="color_dark_gray link_right link_inactive link_no_underline" href="'.get_bloginfo('url').'/add-company/">'.__('Подробнее','er_theme').'</a>';
				$result .= '</div>';
		$result .= '</div>';*/

		$result .= '<div class="side_block white_block">';
		$result .= '<div class="block_title font_smaller_2 font_bolder font_uppercase color_dark_blue">'.__('Это ваша компания?','er_theme').'</div>';
		$result .= '<div class="block_content font_smaller line_22">';
		$result .= '<p>'.__('Подключите личный кабинет своей компании, чтобы получить доступ к бесплатным бизнес-инструментам Это развод™','er_theme').'</p>';
		if (is_user_logged_in()) {
			$result .= '<a class="link_to_dashboard_add_company color_dark_gray link_right link_inactive link_no_underline" href="/dashboard-add-company/?company_sidebar='.$post_id.'">'.__('Подробнее','er_theme').'</a>';
		} else {
			$result .= '<span class="link_to_dashboard_add_company color_dark_gray link_right link_inactive link_no_underline pointer" onclick="click_sidebar = '.$post_id.';auth_link()">'.__('Подробнее','er_theme').'</span>';
		}

		$result .= '</div>';
		$result .= '</div>';

		$result .= '</div>';
		echo $result;
		die;
	}
}