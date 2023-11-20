<?php

if( file_exists( ABSPATH . 'yookassa/lib/autoload.php' ) ) {
	require ABSPATH . 'yookassa/lib/autoload.php';
} else {
	return;
}

use YooKassa\Client;
$client = new Client();
//
$userid = wp_get_current_user();
$user_email = $userid->user_email;
$user_id_new = $userid->ID;
//echo $user_id_new;
if (in_array($user_id_new,[17,31])) {
	$client->setAuth('824838', 'test_qd-OeMY4CKWMRoCvZc8T22-n6Sk3wnZEKr6aWVAa0gs');
} else {
	$client->setAuth('817766', 'live_HzL_mN-sOGZtlp785knee4PIQJkR1Phfp7pqK8w50us');
}
$payments = $client->getPayments();

//echo '<pre>';echo json_encode($payments->items);echo '</pre>';
$arr =  $payments->items;
foreach ( $arr as $item ) {
	/*echo '<pre>';
	print_r($item);
	echo '</pre>';*/
	//echo intval($item->amount->value).' '.$item->status.'<br>';
	if ($item->status == "succeeded") {
		$id = intval($item->metadata->id);
		//echo $id.'<br>';
		if ($id != 0) {
			/*print_r(get_field_object('add_options',$id));
			echo '<br>';
			print_r(get_field('add_options',$id));
			echo '<hr>';*/
			if (get_field('add_options_status', $id) != 'yes') {
				//print_r(get_field('add_options',$id));
				update_field( 'add_options' . '_' . 'amount', intval($item->amount->value), $id );
				update_field( 'add_options' . '_' . 'all_json', json_encode( $item ), $id );
				update_field( 'add_options' . '_' . 'status', 'yes', $id );
				$balanceupdated = intval( get_field( 'balance', 'user_' . $item->metadata->userid ) ) + intval($item->amount->value);
				update_field( 'balance', $balanceupdated, 'user_' . $item->metadata->userid );


				$amount = get_field('add_options'.'_'.'amount', $id);
				$content_balance = 'Здравствуйте!<br> 
Ваш баланс на сайте etorazvod.ru был успешно пополнен '.get_the_date('j.n.Y',$id).' на сумму '.number_format($amount, 0, '.', ' ').' рублей. <br>';

				if (intval($item->amount->value) == 4990) {
					if (get_field('connect_company',intval($item->metadata->id))) {
						//echo 'Все ок, мы нашли id привязки<br>';
						$i = 0;
						$connect_company_id = get_field('connect_company',intval($item->metadata->id))[0];
						//echo 'id '.$connect_company_id.'<br>';

						if( have_rows('comp_statuses','user_'.intval($item->metadata->userid)) ):
							while ( have_rows('comp_statuses','user_'.intval($item->metadata->userid)) ) : the_row();
								//echo 'Ищем '.$connect_company_id.'<br>';
								$i = ++$i;
								$sub_value = get_sub_field('status');
								if ($connect_company_id == get_sub_field('id_conn_comp')[0]) {
									//echo 'Нашли '.$connect_company_id.'<br>';
									update_sub_field('status', 'moderation');
									$balanceupdated = intval( get_field( 'balance', 'user_' . $item->metadata->userid ) ) - intval($item->amount->value);
									update_field( 'balance', $balanceupdated, 'user_' . $item->metadata->userid );
								}
							endwhile;
						else :
							//echo 'Нет компаний '.$connect_company_id.'<br>';
						endif;

					} else {
						//echo 'Это оплата '.$connect_company_id.'<br>'.$item->metadata->id;
					}
				}



				if ( get_field( 'service', $id ) == 'pro' ) {
					if ( intval( $item->amount->value ) == ( intval( get_field( 'month', intval( $item->metadata->id ) ) ) * 400 ) ) {
						update_field( 'services_user_date_activation', date( 'd/m/Y H:i:s' ), 'user_' . $item->metadata->userid );
						$dater_end = date( 'd/m/Y H:i:s', strtotime( "+1 month" ) );

						if ( get_field( 'services_user_add_transaction_date_before_end', 'user_' . $item->metadata->userid ) ) {
							/*$date = str_replace('/', "-", get_field('services_user_add_transaction_date_before_end','user_'.$item->metadata->userid));
							$dater_end = date('d/m/Y H:i:s', strtotime($date. ' + 1 month'));*/


							$varmonth  = intval( get_field( 'month', intval( $item->metadata->id ) ) );
							$textmonth = '+ ' . $varmonth . ' month';
							$date      = str_replace( '/', "-", get_field( 'services_user_add_transaction_date_before_end', 'user_' . $item->metadata->userid ) );
							$dater_end = date( 'd/m/Y H:i:s', strtotime( $date . ' ' . $textmonth ) );
							update_field( 'services_user_add_transaction_date_before_end', $dater_end, 'user_' . $item->metadata->userid );
						} else {
							update_field( 'services_user_add_transaction_date_before_end', $dater_end, 'user_' . $item->metadata->userid );
						}


						update_field( 'additional_info_mini', 'Подключение тарифа', $id );
						update_field( 'additional_info', 'Подключение тарифа ' . get_the_title( 84175 ) . ' до ' . str_replace( '/', '.', strtok( get_field( 'services_user_add_transaction_date_before_end', 'user_' . $item->metadata->userid ), ' ' ) ), $id );
						update_field( 'services_user_services', 84175, 'user_' . $item->metadata->userid );
						update_field( 'services_user_periodicity', 'period', 'user_' . $item->metadata->userid );
						update_field( 'services_user_add_transaction_id_transaction', $id, 'user_' . $item->metadata->userid );


						$balanceupdated = intval( get_field( 'balance', 'user_' . $item->metadata->userid ) ) - intval( $item->amount->value );
						update_field( 'balance', $balanceupdated, 'user_' . $item->metadata->userid );
					}
				}


				notify_user_action('system_balance_plus',$item->metadata->userid,'Баланс на сайте пополнен!',$content_balance);
				afunction(get_post($id), '[Оплачено] '.get_the_title($id));

			}
		}
	}
}
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
$price_take = $_POST['price'];
?>
<?php if (is_user_logged_in()) {
	echo user_dashboard_wallet_new_test();
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
            <span class="button font_bold color_white pointer link_no_underline next_btn_r">Далее</span>
            <!--<span class="button font_bold color_white pointer link_no_underline send_money__footer__btn send_money__footer__btn_act">Пополнить</span>-->
        </div>
        <div class="send_money__footer flex  justify-content-space-between send_money__footer_step_2" style="display:none;">
			<?php
			if ($_GET['price']) {
				echo '<span class="back_to_price">Вернуться к выбору споба верификации</span>';
			} else {
				echo '<span class="back_to_price">Вернуться к вводу суммы</span>';
			}
			?>

            <!--Вернуться к выбору споба верифаикции-->
            <div class="price_final">
                <div class="price_final_inside">
                    <span class="send_money__footer__title color_dark_gray">Сумма к оплате</span>
                    <div class="send_money__footer__inputs-wrapper flex flex_column">
                        <span class="price_from_input"></span>
                    </div>
                    <span class="valute_text">рублей</span>
                </div>
                <div class="get_pay_method">
                    <span value="bank_card"><input type="radio" name="paymethod" id="paymethod_1" checked><label for="paymethod_1">Банковская карта</label></span>
                    <span value="yoo_money"><input type="radio" name="paymethod" id="paymethod_2"><label for="paymethod_2">ЮMoney</label></span>
                    <span value="qiwi"><input type="radio" name="paymethod" id="paymethod_4"><label for="paymethod_4">QIWI Кошелек</label></span>
                    <span value="alfabank"><input type="radio" name="paymethod" id="paymethod_5"><label for="paymethod_5">Альфа-Клик</label></span>
                    <span value="tinkoff_bank"><input type="radio" name="paymethod" id="paymethod_6"><label for="paymethod_6">Тинькофф</label></span>
                    <span value="sberbank"><input type="radio" name="paymethod" id="paymethod_7"><label for="paymethod_7">СберБанк Онлайн/SberPay</label></span>
                    <span value="mobile_balance"><input type="radio" name="paymethod" id="paymethod_8"><label for="paymethod_8">Баланс телефона</label></span>
                    <span value="cash"><input type="radio" name="paymethod" id="paymethod_9"><label for="paymethod_9">Наличными</label></span>
                </div>
                <div class="buttons_wrap">
                    <select name="select_method" class="select_big m_b_10 select_arrow">
                        <option selected="selected" value="bank_card">Банковская карта</option>
                        <option value="yoo_money">ЮMoney</option>
                        <option value="qiwi">QIWI Кошелек</option>

                        <option value="alfabank">Альфа-Клик</option>
                        <option value="tinkoff_bank">Тинькофф</option>
                        <option value="sberbank">СберБанк Онлайн/SberPay</option>
                        <option value="mobile_balance">Баланс телефона</option>
                        <option value="cash">Наличными</option>
                    </select>
                    <span class="button font_bold color_white pointer link_no_underline send_money__footer__btn send_money__footer__btn_act">Пополнить</span>
                </div>
            </div>
            <div class="send_money__underfooter">
                <input class="filter_field_checkbox custom-checkbox" id="accept_pay" type="checkbox" name="accept_pay" value="" checked="checked"><label for="accept_pay"><span class="field_title font_smaller color_dark_gray">Нажимая на кнопку «Пополнить», Вы автоматически соглашаетесь с <a href="/offer/" target="_blank" class="color_dark_gray">Офертой на заключение договора</a>, <a href="/rules/" target="_blank" class="color_dark_gray">Правилами пользования сервисом</a>, <a href="/terms-of-use/" target="_blank" class="color_dark_gray">Пользовательским соглашением</a> и <a href="/privacy-policy/" target="_blank" class="color_dark_gray">Политикой Конфиденциальности</a>.</span></label>
            </div>
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
		$userid = wp_get_current_user();
		$user_email = $userid->user_email;
		$user_id_new = $userid->ID;
		foreach ( $posts_transactions as $key => $post ) {

			$get_the_ID = get_the_ID();
			/* Достаем имя компании */
			
			$get_link_comp = get_field('connect_company', $get_the_ID);
			// print_r ($get_link_comp);
			$company_id = $get_link_comp[0]; // Получаем ID записи компании
			$field_object = get_field_object('company_name', $company_id); // Получаем объект поля

			if ($field_object) {
				$field_name = $field_object['name']; // Получаем имя поля
				$field_value = get_field($field_name, $company_id); // Получаем значения поля
			}
			// print_r ($field_name);
			// print_r ($field_value);


			if (get_field('type', get_the_ID() ) == 'add') {
				if (get_field('connect_company',get_the_ID())) {
					$buytariff =  'Верификация компании';
				} else {
					if (get_field('additional_info_mini',get_the_ID()) == 'Подключение тарифа') {
						$buytariff =  'Подключение PRO';
					} else {
						$buytariff =  'Пополнение баланса';
					}
				}


			} else {
				if ( get_field( 'additional_info', $get_the_ID ) ) {
					$buytariff = get_field( 'additional_info_mini', $get_the_ID );
				} else {
					$buytariff = 'Оплата услуги';
				}
			}
			$result = '<div class="wallet_history__row flex  align-items-center" attr-id="'.get_field('connect_company',get_the_ID())[0].'">';
			$result .= '    <div class="wallet_history__row__title">';
			$result .= '        <span class="wallet_history__row__span__item font_bold">'.$buytariff.'</span>';
			$result .= '        <span class="wallet_history__row__span__item font_bold">'. $field_value . '</span>'; //as
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
			$id_transaction = get_field('add_options' . '_' . 'id_transaction', $get_the_ID);
			if (get_field('type', $get_the_ID ) == 'add') {
				if ( get_field( 'add_options' . '_' . 'status', $get_the_ID ) == 'yes' ) {

				} else {
					$result .= '<span class="wallet_history__row__icon_card wallet_history__row__icon" data-amount="'.$amount.'"  data-email="'.$user_email.'" data-userid="'.$user_id_new.'" data-trans_id="'.$id_transaction.'"  data-id="'.$get_the_ID.'" data-method="bank_card"></span>';
				}
			}
			if ($get_the_ID == get_field('services_user_add_transaction_id_transaction','user_'.$user_id)[0]) {
				$services_user_add_transaction_date_before_end = explode(' ',get_field('services_user_add_transaction_date_before_end','user_'.$user_id));
				$services_user_add_transaction_date_before_end = $services_user_add_transaction_date_before_end[0];
				$services_user_add_transaction_date_before_end =  str_replace("/", ".", $services_user_add_transaction_date_before_end);
				$result .= '<span class="wallet_img_status_date">до '.$services_user_add_transaction_date_before_end.'</span>';
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
get_footer('profile');
?>

