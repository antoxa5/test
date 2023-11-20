<?php
if (!function_exists('clear_url')){
	function clear_url($cur_url){
		$url = str_ireplace("https://", "", $cur_url);
		$url = str_ireplace("http://", "", $url);
		$url = 'https://'.$url;
		return parse_url($url)['host'];
	}
}


