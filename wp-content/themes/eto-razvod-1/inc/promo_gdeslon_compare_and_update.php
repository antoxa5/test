<?php
/*if (!function_exists('clear_url')){
    function clear_url($cur_url){
        $url = str_ireplace("https://", "", $cur_url);
        $url = str_ireplace("http://", "", $url);
        $url = 'https://'.$url;
        return parse_url($url)['host'];
    }
}


$mess_params = array('a.galaychuk@gmail.com', 'Сравнение адмитад и гдеслон');

if( !wp_next_scheduled('compare_admitad_gdeslon_hook', $mess_params ) )
    wp_schedule_event( time(), 'daily', 'compare_admitad_gdeslon_hook', $mess_params );

add_action( 'compare_admitad_gdeslon_hook', 'st_compare_admitad_gdeslon', 10, 2 );

function st_compare_admitad_gdeslon($to, $subject){

    date_default_timezone_set('Europe/Moscow');
    $conversion_date = date('Y-m-d');
    $conversion_time = date('H:i:s');

//  получение урлов с адмитада и заполнение постов урлами начало
    $xmlfile = file_get_contents('http://export.admitad.com/ru/webmaster/websites/1117906/coupons/export/?website=1117906&code=5eed2460da&keyword=&region=00&only_my=on&user=aroma39&format=xml&v=1');
    $object= simplexml_load_string($xmlfile);
    $jsonfile  = json_encode($object);
    $arrayfile = json_decode($jsonfile, true);

    foreach ($arrayfile['advcampaigns']['advcampaign'] as $item) {//массив с компаниями
        $company_id = $item['@attributes']['id'];

        $promocodes = get_posts(array(
            'post_type'		=> 'promocodes',
            'posts_per_page' => '-1',
            'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
            'meta_key'		=> 'promocode_company_id',
            'meta_value'	=> $company_id
        ));
        if ($promocodes[0]->ID){
            $cur_url = get_field('url_site', $promocodes[0]->ID);
            if($cur_url == ''){
//                $url = str_ireplace("https://", "", $item['site']);
//                $url = str_ireplace("http://", "", $url);
//                update_field('url_site', $url, $promocodes[0]->ID); // уточнить этот филд    !!!!!!!!!
                update_field('url_site', clear_url($item['site']), $promocodes[0]->ID);

            }else{}
        }
    }
//  получение урлов с адмитада и заполнение постов урлами конец


//получение урлов с гдеслона начало
    $xmlfile = file_get_contents('https://gdeslon.ru/api/v1/coupons/?format=xml&coupon_type=coupons&coupon_type=promo&tab=index&api_token=047aae0ae21eeef37223c90f1584c081536cad72');
    $object= simplexml_load_string($xmlfile);
    $jsonfile  = json_encode($object);
    $arrayfile = json_decode($jsonfile, true);

    foreach ($arrayfile['merchants']['merchant'] as $item) {
//        $url = str_ireplace("https://", "", $item['url']);
//        $url = str_ireplace("http://", "", $url);
        $url = clear_url($item['url']);
        $promocodes = get_posts(array(
            'post_type'		=> 'promocodes',
            'posts_per_page' => '-1',
            'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
            'meta_key'		=> 'url_site',
            'meta_value'	=> $url
        ));
        if ($promocodes[0]->ID){    //в этом блоке добавляет айди слона в существующий
            // echo ' exist '.$promocodes[0]->ID.'<br>';
            $id_gdeslon = get_field('id_gdeslon', $promocodes[0]->ID);
            if ($id_gdeslon == '' || $id_gdeslon != $item['id']){
                update_field('id_gdeslon', $item['id'], $promocodes[0]->ID); // уточнить этот филд
            }
        }else{  //тут добавляет новую компанию
            //  echo ' does not exist<br>';
            $post = array(
                'post_title'    => $item['name'],
                'post_date' => $conversion_date.' '.$conversion_time, // Дата и времпя конверсии
                'post_status'   => 'draft',   // Could be: publish
                'post_type' 	=> 'promocodes', // Could be: `page` or your CPT
                'post_name' => $item['id'],
            );
            $post_id = wp_insert_post( $post );

            if ( $post_id && ! is_wp_error( $post_id ) ) {
                update_field('id_gdeslon', $item['id'], $post_id);//_id_gdeslon    !!!!!!!!!!!!!!!
                update_field('url_site', $url, $post_id);//_url_site !!!!!!!!!!!!!
                echo $post_id.' added<br>';
            }
        }
    }
//получение урлов с гдеслона конец

}




$mess_params = array('a.galaychuk@gmail.com', 'Добавление промо гдеслон');
if( !wp_next_scheduled('add_promo_gdeslon_hook', $mess_params ) )
    wp_schedule_event( time(), 'hourly', 'add_promo_gdeslon_hook', $mess_params );

add_action( 'add_promo_gdeslon_hook', 'st_add_promo_gdeslon', 10, 2 );

function st_add_promo_gdeslon($to, $subject){

    $xmlfile = file_get_contents('https://gdeslon.ru/api/v1/coupons/?format=xml&coupon_type=coupons&coupon_type=promo&tab=index&api_token=047aae0ae21eeef37223c90f1584c081536cad72');
    $ob= simplexml_load_string($xmlfile);
    $json  = json_encode($ob);
    $configData = json_decode($json, true);
    $existing_codes = array();
    $x = 0;

//////// проверка в каких компаниях есть промо
    foreach ($configData['merchants']['merchant'] as $company) {
        $company_id = $company['id'];
        $promocode_company = get_posts(array(
            'post_type' => 'promocodes',
            'posts_per_page' => '-1',
            'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
            'meta_key' => 'id_gdeslon',
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
        } else {}
        $x++;
    }

////////// блок добавления промо
    foreach ($configData['coupons']['coupon']  as $coupon) {
        $advcampaign_id = $coupon['merchant-id'];
        $promocode_id = $coupon['id'];
        if(array_key_exists($advcampaign_id,$existing_codes)) {
            $the_post_id = $existing_codes[$advcampaign_id]['post_id'];
            if(!$the_post_id || $the_post_id == '') {
                continue;
            } else {
                if(in_array($promocode_id,$existing_codes[$advcampaign_id]['codes'])) {
                    continue;
                } else {
                    $name = $coupon['name'];
                    $description = $coupon['description'];
                    $logo = '';//$coupon['logo'];
                    $gotolink = $coupon['url'];
                    $date_start = $coupon['start-at'];
                    $date_end = $coupon['finish-at'];
                    $promocode = $coupon['code'];
                    $discount = '';//$coupon['discount'];

///////в этом блоке валюта скидки не работает///////////////////////////////

//////////конец блока////////////////////////////

                    $row = array(
                        'type' => 'discount',
                        'title' => $name,
                        'description' => $description,
                        'partner_link' => $gotolink,
                        'coupon_id' => $promocode_id,
                        'text' => $promocode,
                        'system' => 'gdeslon',
                        //'discount_size' => substr($discount, 0, -1),
                        //        'discount_size' => '',//$discount_size_upd,
                        //'discount_currency' => '%',
                        //        'discount_currency' => '',//$discount_currency_upd,
                        'date_start' => $date_start,
                        'date_end' => $date_end
                    );
                    add_row('promocodes_items', $row, $the_post_id);
                }
            }
        } else {}
    }
}*/