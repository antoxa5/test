<?php

if (!function_exists('get_contents')) {
	function get_contents( $content ) {


	 $pattern = "|<h.*>(.*)</h.*>|iU";
		preg_match_all($pattern, $content, $matches);
		$result = '';
		$i = 0;
		$x = 0;
		if(!empty($matches[1])) {
			$result .= '<div class="contents_list flex radius_small inactive">';
				$result .= '<div class="font_bolder font_smaller_2 color_dark_blue font_uppercase contents_title">'.__('Выбрать раздел','er_theme').'</div>';
				$result .= '<ul>';

				//print_r($matches[0]);
				foreach ($matches[0] as $match) {

					if($x == 0) {
						$active = ' class="active"';
					} else {
						$active = '';
					}
					$result .= '<li'.$active.' id="contents_'.$x.'" data-id="'.$x.'"><a href="#i-'.$i.'">'.$matches[1][$x].'</a>';
					$x++;
					if($match[2] == 3 && $matches[0][$x][2] == 2) {
						$result .= '</ul>';
						$result .= '</li>';
					} elseif($match[2] == 2 && $matches[0][$x][2] == 3) {
						$result .= '<ul>';
					} else {
						$result .= '</li>';
					}
					

				}
				foreach ($matches[1] as $match) {

					//$result .= '<li><a href="#i-'.$i.'">'.$match.'</a></li>';
				}
				$languge = get_locale();
				if ($languge == 'en_US') {
					$commend = 'Reviews';
				} elseif ($languge == 'fr_FR') {
					$commend = 'Critiques';
				} elseif ($languge == 'de_DE') {
					$commend = 'Bewertungen';
				} elseif ($languge == 'es_ES') {
					$commend = 'Comentarios';
				} else {
					$commend = 'Отзывы';
				}
				$result .= '<li class="link_open_reviews"><a href="#comments">1'.get_field('company_name',get_the_ID()).' '.__($commend,'er_theme').'</a></li>';
				$result .= '</ul>';
				$result .= '<span class="nav_arrow pointer"></span>';
			$result .= '</div>';
		}
		return $result;
	}
}
/*
if (!function_exists('my_heading_ids')) {
	function my_heading_ids($content) {
	  $content = preg_replace_callback("/\<h([2])/", function ($matches) {
		static $num = 1;
		$hTag = $matches[1];
		return '<h'. $hTag .' id="i-' . $num++ . '"';
	  }, $content);
	  return $content; 
	}
	add_filter('the_content', 'my_heading_ids');
}*/