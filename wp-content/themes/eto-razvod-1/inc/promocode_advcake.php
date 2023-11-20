<?php
$mess_params = array('', 'Добавление advcake');

if( !wp_next_scheduled('add_offer_and_promo_advcake_hook', $mess_params ) )
	wp_schedule_event( time(), 'daily', 'add_offer_and_promo_advcake_hook', $mess_params );

add_action( 'add_offer_and_promo_advcake_hook', 'st_add_offer_and_promo_advcake', 10, 2 );

function st_add_offer_and_promo_advcake(){
	date_default_timezone_set('Europe/Moscow');
	$conversion_date = date('Y-m-d');
	$conversion_time = date('H:i:s');
	
	$jsonfile = file_get_contents('https://api.advcake.com/promocodes?pass=N9bsssUuxDHaGNy0');
	$configData = json_decode($jsonfile, true);
	
	foreach ($configData['data'] as $item){
		$url = clear_url($item['offer_url']);
		$offer_id = intval($item['offer_id']);
		$promocodes = get_posts(array(
			'post_type'		=> 'promocodes',
			'posts_per_page' => '-1',
			'post_status' => array('publish', 'pending', 'draft'),
			'meta_key'		=> 'url_site',
			'meta_value'	=> $url
		));
		
		if ($promocodes[0]->ID){    //в этом блоке добавляет айди слона в существующий
			if (empty(get_field('id_advcake', $promocodes[0]->ID))){
				update_field('id_advcake', $item['offer_id'], $promocodes[0]->ID);
			}
		} else{
		
		}
	}
	
	
	$offers_arr = [];
	foreach ($configData['data'] as $item){
		$offers_arr[$item['offer_id']][] = $item;
	}
	
	
	$existing_codes = array();
	$x = 0;
	foreach ($offers_arr as $company_id => $company){
		$promocode_company = get_posts(array(
			'post_type' => 'promocodes',
			'posts_per_page' => '-1',
			'post_status' => array('publish', 'pending', 'draft'),
			'meta_key' => 'id_advcake',
			'meta_value' => $company_id,
		));
		if(!empty($promocode_company) && $promocode_company[0]->ID && $promocode_company[0]->ID != '') {
			$p_id = $promocode_company[0]->ID;
			$codes = get_field('promocodes_items', $p_id);
			$existing_codes[$company_id]['post_id'] = $p_id;
			if(!empty($codes)) {
				foreach ($codes as $code) {
					$existing_codes[$company_id]['codes'][] = $code['coupon_id'];
				}
			} else {
				$existing_codes[$company_id]['codes'] = array();
			}
		}
		$x++;
	}
	
	
	$y = 0;
	$count_added = 0;
	$count_not_added = 0;
	foreach ($configData['data'] as $coupon) {
		$advcampaign_id = $coupon['offer_id'];
		$promocode_id = $coupon['id'];
		if(array_key_exists($advcampaign_id,$existing_codes)) {
			$the_post_id = $existing_codes[$advcampaign_id]['post_id'];
			if(!$the_post_id || $the_post_id == '') {
				continue;
			} else {
				if(in_array($promocode_id,$existing_codes[$advcampaign_id]['codes'])) {
					$count_added++;
					continue;
				} else {
					$y++;
					$count_not_added++;
					
					if (mb_strlen($coupon['description']) > 80) {
						$name = mb_substr($coupon['description'],0,80).'...';
						$description = $coupon['description'];
					} else {
						$name = $coupon['description'];
						$description = '';
					}
					
					
					//$logo = $coupon['logo'];
					if (!empty($coupon['landing']['link']))
						$gotolink = $coupon['landing']['link'];
					else
						$gotolink = $coupon['offer_url'];
					$date_start = $coupon['date_start'];
					$date_end = $coupon['date_end'];
					$promocode = $coupon['name'];
					$discount = $coupon['discount'];

//////////////////////////////////////
					$discount_size_upd = $coupon['discount'];
					$admitadvalutes = array('$', '€', '%','руб.','р.','R','₱','₽','грн.','AMD','£','rub');
					$discount_currency_upd_temp = '';
					
					foreach ($admitadvalutes as $one_admitad_valute) {
						if (strpos($coupon['discount_type'], $one_admitad_valute) !== FALSE) {
							$valutes = [['$','USD'],['USD','USD'],['€','EURO'],['EURO','EURO'],['%','%'],['руб.','RUB'],['р.','RUB'],['R','RUB'],['₱','RUB'],['RUB','RUB'],['₽','RUB'],['rub','RUB'],['грн.','UAH'],['AMD','AMD'],['£','GBP']];
							foreach ($valutes as $valutes_end) {
								if ($valutes_end[0] == $one_admitad_valute) {
									$discount_currency_upd_temp = $valutes_end[1];
								}
							}
						}
					}
					
					if ($discount_currency_upd_temp == '') {
						$discount_currency_upd = '%'; ///////валюта
					} else {
						$discount_currency_upd = $discount_currency_upd_temp; ///////валюта
					}
//////////////////////////////////////
					
					$row = array(
						'type' => 'discount',
						'title' => $name,
						'description' => $description,
						'partner_link' => $gotolink,
						'coupon_id' => $promocode_id,
						'text' => $promocode,
						'system' => 'advcake',
						'discount_size' => $discount_size_upd,
						'discount_currency' => $discount_currency_upd,
						'date_start' => $date_start,
						'date_end' => $date_end
					);
					add_row('promocodes_items', $row, $the_post_id);
				}
			}
		} else {}
	}
	
	return 1;
}

$mess_params3 = array('', 'Удадение advcake');

if( !wp_next_scheduled('remove_offer_and_promo_advcake_hook', $mess_params3 ) )
	wp_schedule_event( time(), 'twicedaily', 'remove_offer_and_promo_advcake_hook', $mess_params3 );

add_action( 'remove_offer_and_promo_advcake_hook', 'st_remove_offer_and_promo_advcake', 10, 2 );

function st_remove_offer_and_promo_advcake() {
	$args = array(
		'posts_per_page' => -1,
		'post_type'=> array('promocodes'),
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key'		=> 'promocodes_items_$_system',
				'compare'	=> '=',
				'value'		=> 'advcake',
			)
		)
	
	);
	$the_query_company_promo_args = new WP_Query( $args );
	if ( $the_query_company_promo_args->have_posts() ) {
		while ( $the_query_company_promo_args->have_posts() ) {
			$the_query_company_promo_args->the_post();
			global $post;
			$promocodes = array();
			$promocodes_items =  get_field('promocodes_items',get_the_ID());
			$i = 0;
			foreach ($promocodes_items  as $item ) {
				++$i;
				if ( ( strtotime( $item['date_end'] ) <= strtotime( date( 'Y-m-d', strtotime( '-1 days' ) ) ) ) && (strtotime( $item['date_end'] ) != '' ) ) {
					delete_row('promocodes_items', $i, get_the_ID());
				}
			}
			
		}
	}
	wp_reset_postdata();
	return 1;
}