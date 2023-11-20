<?php
/*
Template Name: Temporary ST
*/
get_header();
if (!function_exists('st_print')) {
    function st_print($arr)
    {
        echo '<br>';
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
        echo '<hr>';
    }
}
if (!function_exists('clear_url')){
    function clear_url($cur_url){
        $url = str_ireplace("https://", "", $cur_url);
        $url = str_ireplace("http://", "", $url);
        $url = 'https://'.$url;
        return parse_url($url)['host'];
    }
}
include_once(TEMPLATEPATH .'/inc/SxGeo.php');

function my_geo(){

    echo '<h1>geo</h1>';
    global $detect_city;
    st_print($_SERVER);
    $ip = $_SERVER['HTTP_X_REAL_IP'];
    st_print($ip);
    $SxGeo = new SxGeo(TEMPLATEPATH . '/inc/SxGeoCity.dat');
    $city = $SxGeo->get($ip);
    $detect_city = $city['city']['name_ru'];
    st_print($detect_city);
    $ip = $_SERVER['REMOTE_ADDR'];

    st_print($SxGeo->getCityFull($ip)); // Вся информация о городе
    st_print($SxGeo->get($ip));         // Краткая информация о городе или код страны (если используется база SxGeo Country)
    st_print($SxGeo->about());          // Информация о базе данных
}
my_geo();



get_footer();

?>