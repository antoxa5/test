<?php
set_query_var('dashboard_type', 'dashboard_wallet');
set_query_var('dashboard_breadcrumb_name', 'Платежи');
$current_user = wp_get_current_user();
$user_id = $current_user->data->ID;
set_query_var('user_id',$user_id);
wp_localize_script( 'jquery', 'dashboard_var',array('1','1'));
if (!( is_user_logged_in())) {
	wp_redirect('/');
	exit;
}
get_header();
?>
<?php if (is_user_logged_in()) {
	echo user_dashboard_wallet_new();
}
?>
<div class="send_money">
    <div class="send_money__inside white_block block_content border_radius_4px m_t_15 flex flex_column">
        <div class="send_money__header">
            <span class="send_money__text color_dark_blue">Свободное пополнение средств</span>
        </div>
        <div class="send_money__footer flex  justify-content-space-between">
            <span class="send_money__footer__title color_dark_gray">Сумма</span>
            <div class="send_money__footer__inputs-wrapper flex flex_column">
                <input type="text" name="send_money__footer__amount" placeholder="" class="border_radius_4px  input_big placeholder_dark send_money__footer__amount">
            </div>
            <span class="valute_text">рублей</span>
            <span class="button font_bold color_white pointer link_no_underline send_money__footer__btn send_money__footer__btn_act">Пополнить</span>
        </div>
        <div class="send_money__underfooter">
            <input class="filter_field_checkbox custom-checkbox" id="accept_pay" type="checkbox" name="accept_pay" value="" checked="checked"><label for="accept_pay"><span class="field_title font_smaller color_dark_gray">Нажимая на кнопку «Оплата», Вы автоматически соглашаетесь с <a href="/offer/" target="_blank" class="color_dark_gray">Офертой на заключение договора</a>, <a href="/rules/" target="_blank" class="color_dark_gray">Правилами пользования сервисом</a>, <a href="/terms-of-use/" target="_blank" class="color_dark_gray">Пользовательским соглашением</a> и <a href="/privacy-policy/" target="_blank" class="color_dark_gray">Политикой Конфиденциальности</a>.</span></label>
        </div>
    </div>
</div>
<?php
global $post;
$posts_transactions = get_posts( [
	'posts_per_page' => 50,
	'post_type'      => 'tranzaktsii',
	'post_status'    => 'any',
	'meta_query'     => array(
		array(
			'key'     => 'id_user',
			'value'   => $user_id,
			'compare' => '==',
		)
	)
] );
if (count($posts_transactions) != 0) {
	?>
    <div class="wallet_history white_block block_content border_radius_4px m_t_15 flex flex_column">
        <div class="wallet_history__header flex">
            <div class="rating_th rating_field_number sort pointer sort_default" data-rating-field="number">Услуга</div>
            <div class="rating_th rating_field_number sort pointer sort_default" data-rating-field="number">Статус</div>
            <div class="rating_th rating_field_number sort pointer sort_default" data-rating-field="number">Цена</div>
        </div>
		<?php

		foreach ( $posts_transactions as $key => $post ) {
			$get_the_ID = get_the_ID();
			if (get_field('type', get_the_ID() ) == 'add') {
				$buytariff =  'Пополнение баланса';

			} else {
				if ( get_field( 'additional_info', $get_the_ID ) ) {
					$buytariff = get_field( 'additional_info_mini', $get_the_ID );
				} else {
					$buytariff = 'Оплата услуги';
				}
			}
			$result = '<div class="wallet_history__row flex  align-items-center">';
			$result .= '    <div class="wallet_history__row__title">';
			$result .= '        <span class="wallet_history__row__span__item font_bold">'.$buytariff.'</span>';
			$result .= '    </div>';
			$result .= '    <div class="wallet_history__row__status">';
			if (get_field('type', $get_the_ID ) == 'add') {
				if (get_field(    'add_options'.'_'.'status',    $get_the_ID    ) == 'yes') {
					$img_status = '<span class="wallet_img_status wallet_img_status_green"></span>';
					$name_paid = 'Оплачено';

				} else {
					$img_status = '<span class="wallet_img_status wallet_img_status_gray"></span>';
					$name_paid = 'Не оплачено';
				}
			} else  {
				$img_status = '<span class="wallet_img_status wallet_img_status_green"></span>';
				$name_paid = 'Оплачено';
			}
			$result .= '<div class="wallet_img_status_wrapper">'.$img_status.'<div class="wallet_img_status_text"><span class="wallet_img_status_paid">'.$name_paid.'</span><span class="wallet_img_status_date">'.get_the_date('j.n.Y').'</span></div></div>';
			$result .= '    </div>';
			$result .= '    <div class="wallet_history__row__amount">';
			if (get_field('type', $get_the_ID ) == 'spend') {
				$amount = get_field('add_options_spend'.'_'.'amount', $get_the_ID);
			} else {
				$amount = get_field('add_options'.'_'.'amount', $get_the_ID);
			}

			$result .= '        <span class="wallet_history__row__span__item">'.number_format($amount, 0, '.', ' ').' Р</span>';
			$result .= '    </div>';
			$result .= '    <div class="wallet_history__row flex align-items-center wallet_history_row_pay">';
			if ($get_the_ID == get_field('services_user_add_transaction_id_transaction','user_'.$user_id)[0]) {
				$services_user_add_transaction_date_before_end = explode(' ',get_field('services_user_add_transaction_date_before_end','user_'.$user_id));
				$services_user_add_transaction_date_before_end = $services_user_add_transaction_date_before_end[0];
				$services_user_add_transaction_date_before_end =  str_replace("/", ".", $services_user_add_transaction_date_before_end);
				$result .= '<span class="wallet_img_status_date">'.$services_user_add_transaction_date_before_end.'</span>';
			}
			$result .= '    </div>';
			$result .= '</div>';
			echo $result;
		}
		?>
    </div>
<?php } ?>
<span class="bycardfunc"></span><span class="bycardfunc2"></span>
<div id="popup_price_modal"></div>
<?php if (is_user_logged_in()) {
	echo user_dashboard_wallet2();
} ?>



<?php
get_footer('profile');;
?>