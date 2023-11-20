<?php

$parametri = array('Добавление', 'новых промокодов из', 'admitad');

if( !wp_next_scheduled('add_new_promo_admitad', $parametri ) )
	wp_schedule_event( time(), 'hourly', 'add_new_promo_admitad', $parametri );

add_action( 'add_new_promo_admitad', 'misha_send', 10, 3 );

function misha_send( $to, $subject, $msg ) {
	//wp_mail( $to, $subject, $msg );
	date_default_timezone_set('Europe/Moscow');
	$conversion_date = date('Y-m-d');
	$conversion_time = date('H:i:s');
	
	
	$xmlfile = file_get_contents('http://export.admitad.com/ru/webmaster/websites/1117906/coupons/export/?website=1117906&code=5eed2460da&keyword=&region=00&only_my=on&user=aroma39&format=xml&v=1');
	$ob= simplexml_load_string($xmlfile);
	$json  = json_encode($ob);
	$configData = json_decode($json, true);
	$companies = $configData['advcampaigns']['advcampaign'];
	$coupons = $configData['coupons']['coupon'];
	$existing_codes = array();
	$x = 0;
	foreach ($companies as $company) {
		$company_id = $company['@attributes']['id'];
		//echo $company_id;
		//echo '<br />';
		$promocode_company = get_posts(array(
			'post_type' => 'promocodes',
			'posts_per_page' => '-1',
			'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
			'meta_key' => 'promocode_company_id',
			'meta_value' => $company_id,
		));
		if(!empty($promocode_company) && $promocode_company[0]->ID && $promocode_company[0]->ID != '') {
			$p_id = $promocode_company[0]->ID;
			//echo 'exists as '.$promocode_company[0]->post_title.' with ID '.$p_id;
			//echo '<br />';
			$codes = get_field('promocodes_items', $p_id);
			$existing_codes[$company_id]['post_id'] = $p_id;
			//print_r($codes);
			if(!empty($codes)) {
				foreach ($codes as $code) {
					$existing_codes[$company_id]['codes'][] = $code['coupon_id'];
				}
			} else {
				$existing_codes[$company_id]['codes'] = array();
			}
			//echo '<br />';
		} else {
			//echo 'does not exist';
			//echo '<br />';
		}
		$x++;
	}
	//echo '<pre>';
	//print_r($existing_codes);
	//echo '</pre>';
	$y = 0;
	$count_added = 0;
	$count_not_added = 0;
	foreach ($coupons as $coupon) {
		
		//print_r($coupon);
		$advcampaign_id = $coupon['advcampaign_id'];
		$promocode_id = $coupon['@attributes']['id'];
		if(array_key_exists($advcampaign_id,$existing_codes)) {
			//echo 'company '.$advcampaign_id.' is added';
			//echo '<br />';
			$the_post_id = $existing_codes[$advcampaign_id]['post_id'];
			
			if(!$the_post_id || $the_post_id == '' || count(get_field('promocodes_items', $the_post_id)) > 10) {
				continue;
			} else {
				if(in_array($promocode_id,$existing_codes[$advcampaign_id]['codes'])) {
					//echo 'promocode '.$promocode_id.' exists';
					$count_added++;
					continue;
				} else {
					$y++;
					$count_not_added++;
					
					//echo 'promocode '.$promocode_id.' does not exist';
					//echo '<br />';
					if($y > 30) {
						continue;
					} else {
						$name = $coupon['name'];
						$description = $coupon['description'];
						$logo = $coupon['logo'];
						$gotolink = $coupon['gotolink'];
						$date_start = $coupon['date_start'];
						$date_end = $coupon['date_end'];
						$promocode = $coupon['promocode'];
						$discount = $coupon['discount'];
						/*
						echo 'post_id: ' . $the_post_id;
						echo 'name: ' . $name;
						echo '<br />';
						echo 'coupon_id: ' . $promocode_id;
						echo '<br />';
						echo 'advcampaign_id: ' . $advcampaign_id;
						echo '<br />';
						echo 'description: ' . $description;
						echo '<br />';
						echo 'logo: ' . $logo;
						echo '<br />';
						echo 'gotolink: ' . $gotolink;
						echo '<br />';
						echo 'date_start: ' . $date_start;
						echo '<br />';
						echo 'date_end: ' . $date_end;
						echo '<br />';
						echo 'promocode: ' . $promocode;
						echo '<br />';
						echo 'discount: ' . $discount;
						echo '<br /><br />';*/
						
						//////////////////////////////////////
						///
						if (gettype($coupon['discount']) != 'array') {
							preg_match_all('!\d+!', $discount, $matches); //вырезаем числа
							$discount_size_upd = implode("", $matches[0]); //объединяем числа  ///////цена
							
							$admitadvalutes = array('$', '€', '%','руб.','р.','R','₱','₽','грн.','AMD','£');
							$discount_currency_upd_temp = '';
							
							foreach ($admitadvalutes as $one_admitad_valute) {
								if (strpos($discount, $one_admitad_valute) !== FALSE) {
									$valutes = [['$','USD'],['USD','USD'],['€','EURO'],['EURO','EURO'],['%','%'],['руб.','RUB'],['р.','RUB'],['R','RUB'],['₱','RUB'],['RUB','RUB'],['₽','RUB'],['грн.','UAH'],['AMD','AMD'],['£','GBP']];
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
						} else {
							$discount_size_upd = 0;
							$discount_currency_upd = '%';
						}
						
						//////////////////////////////////////
						
						$row = array(
							'type' => 'discount',
							'title' => $name,
							'description' => $description,
							'partner_link' => $gotolink,
							'coupon_id' => $promocode_id,
							'text' => $promocode,
							'system' => 'admitad',
							//'discount_size' => substr($discount, 0, -1),
							'discount_size' => $discount_size_upd,
							//'discount_currency' => '%',
							'discount_currency' => $discount_currency_upd,
							'date_start' => $date_start,
							'date_end' => $date_end
						
						);
						//print_r($row);
						add_row('promocodes_items', $row, $the_post_id);
						// my_acf_save_post($the_post_id);
					}
				}
			}
			//echo '<br />';
			//echo '<br />';
		} else {
			//echo 'company '.$advcampaign_id.' is not added';
			//echo '<br />';
			//echo '<br />';
		}
		
		
		
	}
}








$parametri = array('Удаление истекших промокодов');

if( !wp_next_scheduled('delete_promos_from_ads_feeds', $parametri ) )
	wp_schedule_event( time(), 'daily', 'delete_promos_from_ads_feeds', $parametri );

add_action( 'delete_promos_from_ads_feeds', 'delete_promos_from_ads_feeds', 10, 3 );

function delete_promos_from_ads_feeds( $to) {
	function check_old_promo(){
		global $wpdb;
		$date =  date('Y-m-d H:i:s', strtotime('-1 day'));
		$query = "SELECT DISTINCT(`post_id`) FROM `wp_postmeta`
        WHERE `meta_key` LIKE 'promocodes\_items\__\_date\_end' AND `meta_value` < '".$date."'";
		$arr = $wpdb->get_results($query, ARRAY_A);
		$str = implode(',', array_map(function($el){ return $el['post_id']; }, $arr));
		$query = "SELECT `post_id`,`meta_value` FROM `wp_postmeta`
        WHERE `meta_key` LIKE 'promocodes_items' AND `meta_value` IS NOT NULL AND `meta_value` !=' ' AND `meta_value` !=''
        AND `post_id` IN (".$str.")";
		$id_array = $wpdb->get_results($query, ARRAY_A);
		//////////////////вернутьecho "<h1>Осталось кампаний с просрочеными промо: <span style='color: red'>".count($id_array)."</span></h1>";
		return $id_array;
	}
	$array = check_old_promo();
	$time_now_1 = strtotime('-1 day');
	$date_now_1 =  date('Y-m-d H:i:s', $time_now_1);
	foreach ($array as $company){
		/* [post_id] => 48728
				[meta_value] => 4*/
		$count_del = 0;
		$curent_promo_count = $company['meta_value'];
		$post = get_post($company['post_id']);
		
		if ($post->post_type == 'promocodes') {
			if ($curent_promo_count > 50) {
				$a = '<strong>!!!</strong>';
				//delete_row('');
				//delete_field('promocodes_items',$post->ID);
			} else {
				$a = '';
			}
			//////////////////вернутьecho '<hr>'.$a.'<b>'.$post->post_title.'</b> всего промо '.$curent_promo_count.'<br>'.$post->ID.'<br>';
			//print_r();
			$array_system = [];
			$array_to_delete = [];
			for ($i=0; $i<$curent_promo_count; $i++){
				$ap = get_post_meta($company['post_id'],'promocodes_items_'.$i.'_date_end',true);
				$time_end = strtotime($ap);
				$system = get_post_meta($company['post_id'],'promocodes_items_'.$i.'_system',true);
				
				if($time_end < $time_now_1 && !empty($ap) && $ap != 'None') {   //if($time_end < $time_now_1 && !empty($ap)) {
					//echo $ap.'<br>';
					$count_del++;
					/* if( delete_row('promocodes_items', $i+1,$company['post_id'])){
						 $message .=  "deleting ".$i." elem in page ".$company['post_id']."<br>";
						 $i--;
						 $curent_promo_count--;// = get_promo_items_count_1($p_id);
					 }*/
					if ($system == 'manual') {
						//$array_system[] = $i;
						
					} else {
						$array_to_delete[] = $i;
					}
				}
				
				if ($system == 'manual') {
					$array_system[] = $i;
				}
			}
			
			if (count($array_system) == 0) {
				delete_field('promocodes_items',$post->ID);
			} else {
				//Вернутьprint_r($array_to_delete);
				foreach ( $array_to_delete as $item ) {
					delete_row('promocodes_items', $item+1,$post->ID);
				}
				
			}
			
			//////////////////вернутьecho 'просроченных <b>'.$count_del.'</b>';
		}
		
	}
	
	function st_print($arr){
		//////////////////вернутьecho '<br>';
		//////////////////вернутьecho '<pre>';
		//////////////////вернутьprint_r($arr);
		//////////////////вернутьecho '</pre>';
		//////////////////вернутьecho '<hr>';
	}
}

//*********************************************

function del_promo_interval( $schedules ) {
	$schedules['every_min'] = array(
		'interval' => 60,
		'display' => 'Каждую 1 мин'
	);
	return $schedules;
}
add_filter( 'cron_schedules', 'del_promo_interval');


/**
 * получает количество промо в компании
 * @param $p_id
 * @return mixed
 */
function get_promo_items_count($p_id){
	global $wpdb;
	$query = "SELECT `meta_value` FROM `wp_postmeta`
                WHERE `meta_key` LIKE 'promocodes_items' AND `post_id` = ".$p_id;
	$res = $wpdb->get_results($query, ARRAY_A);
	return $res[0]['meta_value'];
}


/**
 * получает ID содержащие просроченые промо
 * @param $date
 * @param int $start
 * @param int $items
 * @return mixed
 */
function get_meta_id($date, $start = 0, $items = 50){
	global $wpdb;
	$query = "SELECT DISTINCT(`post_id`) FROM `wp_postmeta` WHERE `meta_key` LIKE 'promocodes\_items\__\_date\_end' AND `meta_value` < '".$date."'";
	$arr = $wpdb->get_results($query, ARRAY_A);
	$str = implode(',', array_map(function($el){ return $el['post_id']; }, $arr));
	$query = "SELECT `post_id`,`meta_value` FROM `wp_postmeta`
            WHERE `meta_key` LIKE 'promocodes_items' AND `meta_value` IS NOT NULL AND `meta_value` !=' ' AND `meta_value` !=''
            AND `post_id`  AND `post_id` != '89562' IN (".$str.")";
	if ($start!= -1 && $items != -1)
		$query .= " LIMIT ".$start.",".$items;
	return $wpdb->get_results($query, ARRAY_A);
}

//$mess_params = array('me@artemsaveliev.com', 'Удаление промо', 'Тест сообщение');
$mess_params = array('a.galaychuk@gmail.com', 'Удаление промо');


add_filter( 'cron_schedules', 'cron_add_five_min_2' );
function cron_add_five_min_2( $schedules ) {
	$schedules['five_min_extra'] = array(
		'interval' => 60 * 5,
		'display' => 'Раз в 5 минут'
	);
	return $schedules;
}

function deleting_date_end_promo( $to, $subject ) {
	//date_default_timezone_set('Europe/Moscow');
	$message    = "";
	$time_now_1 = strtotime( '-1 day' );
	$date_now_1 = date( 'Y-m-d H:i:s', $time_now_1 );
	foreach ( get_meta_id( $date_now_1, 1, 1 ) as $promocode ) {
		$p_id = $promocode['post_id'];
		if ( $promocode['meta_value'] ) {
			$curent_promo_count = $promocode['meta_value'];
			for ( $i = 0; $i < $curent_promo_count; $i ++ ) {
				$ap       = get_post_meta( $p_id, 'promocodes_items_' . $i . '_date_end', true );
				$time_end = strtotime( $ap );
				if ( $time_end < $time_now_1 || empty( $ap ) ) {   //if($time_end < $time_now_1 && !empty($ap)) {
					if ( delete_row( 'promocodes_items', $i + 1, $p_id ) ) {
						$message .= "deleting " . $i . " elem in page " . $p_id . "<br>";
						$i --;
						$curent_promo_count --;// = get_promo_items_count($p_id);
					}
				}
			}
		}
	}
	
	// wp_mail( $to, $subject, $message );
	return 1;
}


function new_st_del_promo($to, $subject){
	global $wpdb;
	$message = "";
	$time_now_1 = strtotime('-1 day');
	$date_now_1 =  date('Y-m-d H:i:s', $time_now_1);
	
	$query = "SELECT DISTINCT(`post_id`) FROM `wp_postmeta`
        WHERE `meta_key` LIKE 'promocodes\_items\__\_date\_end' AND `meta_value` < '".$date_now_1."'
        ORDER BY `post_id` DESC LIMIT 1";
	$arr = $wpdb->get_results($query, ARRAY_A);
	$p_id = $arr[0];
	$p_id = $p_id['post_id'];
	if (!$p_id)
		return 0;
	$query = "SELECT `meta_value` FROM `wp_postmeta`
                WHERE `meta_key` LIKE 'promocodes_items' AND `post_id` = ".$p_id;
	$res = $wpdb->get_results($query, ARRAY_A);
	$curent_promo_count =  $res[0]['meta_value'];
	
	for ($i=0; $i<$curent_promo_count; $i++) {
		$ap = get_post_meta($p_id,'promocodes_items_'.$i.'_date_end',true);
		$time_end = strtotime($ap);
		if($time_end < $time_now_1 && !empty($ap) && $ap != 'None') {   //if($time_end < $time_now_1 && !empty($ap)) {
			if( delete_row('promocodes_items', $i+1,$p_id)){
				$message .=  "deleting ".$i." elem in page ".$p_id."<br>";
				$i--;
				$curent_promo_count--;// = get_promo_items_count_1($p_id);
			}
		}
	}
	
	//wp_mail( $to, $subject, $message );
	return 1;
}





//***************************





?>