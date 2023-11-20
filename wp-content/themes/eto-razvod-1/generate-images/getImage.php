<?php
require('/home/eto/web/eto-razvod.ru/public_html/wp-load.php');
if (isset($_GET['id'])) {

} else {
	exit();
}
/**
 * Imagettftextblur Example (Without Blur)
 *
 * Copyright (c) 2013-2022 Andrew G. Johnson <andrew@andrewgjohnson.com>
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in the
 * Software without restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the
 * Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN
 * AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * PHP version 5
 *
 * @category  Andrewgjohnson
 * @package   Imagettftextblur
 * @author    Andrew G. Johnson <andrew@andrewgjohnson.com>
 * @copyright 2013-2022 Andrew G. Johnson <andrew@andrewgjohnson.com>
 * @license   https://opensource.org/licenses/mit/ The MIT License
 * @link      https://github.com/andrewgjohnson/imagettftextblur
 */
$rand = rand();
// include the imagettftextblur source if you're not using Composer
if (file_exists('testfonts.php')) {
	include_once 'testfonts.php';
} else {
	die('imagettftextblur.php not found');
}
$nameHash = time().rand();
// set the parameters for our image
$width            = 600;
$height           = 300;
$size             = 40;
$font             = __DIR__ . '/Stem-Regular.ttf';


$string           = 'Кредитная карта Халва от Совкомбанка это развод?';

// calculate the text size in advance
$text_dimensions  = imagettfbbox($size, 0, $font, $string);

// calculate the text's edges
$text_left        = min($text_dimensions[0], $text_dimensions[6]);
$text_right       = max($text_dimensions[2], $text_dimensions[4]);
$text_top         = min($text_dimensions[1], $text_dimensions[3]);
$text_bottom      = max($text_dimensions[5], $text_dimensions[7]);

// calculate the text's position
$x_offset         = ($width / 2)  - (($text_right - $text_left) / 2);
$y_offset         = ($height / 2) - (($text_bottom - $text_top) / 2);

// create our image

function truncateToWord( $content, $length = 200, $continue_reading = '' ) {
	if ( mb_strlen( $content ) >= $length ) {
		if (mb_strpos( $content, '" ', $length ) == mb_strpos( $content, ' ', $length )-1 ){
			return $content;
		}
		$spaceAtPos = mb_strpos( $content, ' ', $length );
		$content    = mb_substr( $content, 0, $spaceAtPos );
		$check      = preg_match( '/(\.|\?|\,|\!)/', mb_substr( $content, - 1 ) );
		if ( $check == 1 ) {
			$content = mb_substr( $content, 0, - 1 );
		}
	}
	
	return $content;
}
$string_temp = get_the_title($_GET['id']);
if (preg_match('/[А-Яа-яЁё]/u', get_field('company_name',$_GET['id'])) == 1) {
	if ( get_locale() == 'en_US' ) {
		$string_temp = trp_translate( $string_temp, 'en_US', false );
	} elseif ( get_locale() == 'fr_FR' ) {
		$string_temp = trp_translate( $string_temp, 'fr_FR', false );
	} elseif ( get_locale() == 'de_DE' ) {
		$string_temp = trp_translate( $string_temp, 'de_DE', false );
	} elseif ( get_locale() == 'es_ES' ) {
		$string_temp = trp_translate( $string_temp, 'es_ES', false );
	} elseif ( get_locale() == 'pl_PL' ) {
		$string_temp = trp_translate( $string_temp, 'pl_PL', false );
	} elseif ( get_locale() == 'fi' ) {
		$string_temp = trp_translate( $string_temp, 'fi', false );
	} elseif ( get_locale() == 'id_ID' ) {
		$string_temp = trp_translate( $string_temp, 'id_ID', false );
	}
} else {
	if ( get_locale() == 'en_US' ) {
		$string_temp = get_field('company_name',$_GET['id']).' - is this a scam?';
	} elseif ( get_locale() == 'fr_FR' ) {
		$string_temp = get_field('company_name',$_GET['id']).' - Est-ce une arnaque ?';
	} elseif ( get_locale() == 'de_DE' ) {
		$string_temp = get_field('company_name',$_GET['id']).' -  Ist das ein Betrug?';
	} elseif ( get_locale() == 'es_ES' ) {
		$string_temp = get_field('company_name',$_GET['id']).' - ¿es una estafa?';
	} elseif ( get_locale() == 'pl_PL' ) {
		$string_temp = get_field('company_name',$_GET['id']).' - czy to oszustwo?';	
	} elseif ( get_locale() == 'fi' ) {
		$string_temp = get_field('company_name',$_GET['id']).' - Onko tämä huijaus?';	
	} elseif ( get_locale() == 'id_ID' ) {
		$string_temp = get_field('company_name',$_GET['id']).' - apakah ini penipuan?';	
	}
}
$string           = truncateToWord( $string_temp, 35,'' );
if ($string_temp == $string) {
	$string_temp = '';
	$bottoTop = 500;
} else {
	$bottoTop = 450;
}
$im               = imagecreatetruecolor($width, $height);
$string_temp_second = str_replace($string,'',$string_temp);


$cur_terms = get_field('review_aff_tags',$_GET['id']);
if (gettype($cur_terms) == 'array') {
	//print_r($cur_terms[0]);
	$term_id = $cur_terms[0];
	//echo $term_id;
	
	if ($term_id) {
		foreach ($cur_terms as $item) {
			$rating_link = get_field('er_bc_link', 'term_' . $item);
			/*if(!get_field('er_bc_link','term_'.$item) || !get_field('er_bc_text','term_'.$item) ) {
				continue;
			}*/
			if (get_field('tag_human_title', 'term_' . $item) && $rating_link != '') {
				$var_human = get_field('er_bc_text', 'term_' . $item);
				$term_name = get_term( $term_id )->name;
				break;
			}
		}
	}
} else {
	$cur_terms = get_the_terms($_GET['id'], 'affiliate-tags');
	//print_r($cur_terms[0]);
	$term_id = $cur_terms[0]->slug;
	
	
	if ($term_id) {
		foreach ($cur_terms as $term) {
			if (!get_field('er_bc_link', 'term_' . $term->term_id) || !get_field('er_bc_text', 'term_' . $term->term_id)) {
				continue;
			}
			if (get_field('er_bc_link', 'term_' . $term->term_id) && get_field('er_bc_text', 'term_' . $term->term_id)) {
				$var_human = get_field('er_bc_text', 'term_' . $term->term_id);
				$term_name = get_term( $term->term_id )->name;
				break;
			}
		}
	}
}


$url_t = 'https://eto-razvod.net/generate-images/'.$term_name.'.png';
$array = @get_headers($url_t);
$string_200 = $array[0];

if(strpos($string_200, "200")) {
	$url_im = 'https://eto-razvod.net/generate-images/bookingtravel.png?a=1';
} else {
	$url_im = 'https://eto-razvod.net/generate-images/og-image.png';
}


$png = imagecreatefrompng('https://eto-razvod.net/generate-images/gradient.png');
$jpeg = imagecreatefrompng($url_im);

list($width, $height) = getimagesize($url_im);
list($newwidth, $newheight) = getimagesize('https://eto-razvod.net/generate-images/gradient.png');
$im = imagecreatetruecolor($width, $height);
imagecopyresampled($im, $jpeg, 0, 0, 0, 0, $width, $height, $width, $height);
imagecopyresampled($im, $png, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);




// set our image's colors
$background_color = imagecolorallocate($im, 0xEE, 0xEE, 0xEE);
$text_color       = imagecolorallocate($im, 0xFF, 0xFF, 0xFF);

// fill our image with the background color
imagefill($im, 0, 0, $background_color);

// place the text onto our image
imagettftextblur(
	$im,
	$size,
	0,
	30,
	$bottoTop,
	$text_color,
	$font,
	$string
);
/*if ($string_temp == $string) {
	$string_temp_second = $string;
} else {*/
	if (mb_substr($string_temp_second, 0, 1) == ' ') {
		$string_temp_second = mb_substr($string_temp_second,1);
	}
/*}*/

$string           = $string_temp_second;
// place the text onto our image
imagettftextblur(
	$im,
	$size,
	0,
	30,
	530,
	$text_color,
	$font,
	$string
);
$string_type = $var_human;
if (get_locale() == 'en_US') {
	$string_type = trp_translate($var_human, 'en_US',false);
} elseif (get_locale() == 'fr_FR') {
	$string_type = trp_translate($var_human, 'fr_FR',false);
} elseif (get_locale() == 'de_DE') {
	$string_type = trp_translate($var_human, 'de_DE',false);
} elseif (get_locale() == 'es_ES') {
	$string_type = trp_translate($var_human, 'es_ES',false);
} elseif (get_locale() == 'pl_PL') {
	$string_type = trp_translate($var_human, 'pl_PL',false);
} elseif (get_locale() == 'fi') {
	$string_type = trp_translate($var_human, 'fi',false);
} elseif (get_locale() == 'id_ID') {
	$string_type = trp_translate($var_human, 'id_ID',false);
}
$text_dimensions  = imagettfbbox($size, 0, $font, $string_type);
$string           = $string_type;
// place the text onto our image
imagettftextblur(
	$im,
	20,
	0,
	1080 - (min($text_dimensions[0], $text_dimensions[6]) - max($text_dimensions[2], $text_dimensions[4]) / 2 * -1)-30,
	80,
	$text_color,
	__DIR__ . '/Stem-Light.ttf',
	$string
);
if (get_locale() == 'ru_RU') {
	$png = imagecreatefrompng('https://eto-razvod.net/generate-images/logo-og.png');
} else {
	$png = imagecreatefrompng('https://eto-razvod.net/generate-images/og-revieweek-image.png');
}

$jpeg = $im;

list($width, $height) = getimagesize('https://eto-razvod.net/generate-images/gradient.png');
if (get_locale() == 'ru_RU') {
	list( $newwidth, $newheight ) = getimagesize( 'https://eto-razvod.net/generate-images/logo-og.png' );
} else {
	list( $newwidth, $newheight ) = getimagesize( 'https://eto-razvod.net/generate-images/og-revieweek-image.png' );
}
$im = imagecreatetruecolor($width, $height);
imagecopyresampled($im, $jpeg, 0, 0, 0, 0, $width, $height, $width, $height);
imagecopyresampled($im, $png, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);


// set our image's colors
$background_color = imagecolorallocate($im, 0xEE, 0xEE, 0xEE);
$text_color       = imagecolorallocate($im, 0x00, 0x00, 0x00);

// fill our image with the background color
imagefill($im, 0, 0, $background_color);

// place the text onto our image
/*imagettftextblur(
	$im,
	$size,
	0,
	$x_offset,
	$y_offset,
	$text_color,
	$font,
	$string
);*/


// display our image and destroy the GD resource
/*header('Content-Type: image/png');

imagepng($im);*/
$save = "/home/eto/web/eto-razvod.ru/public_html/wp-content/og/sources/202212/final-m-".$nameHash.".png";
imagepng($im, $save);
imagedestroy($im);
echo __DIR__;
echo '<img src="https://etorazvod.ru/wp-content/og/sources/202212/final-m-'.$nameHash.'.png" alt=""/>';
echo '<br><a da="'.$term_name.'" href="https://etorazvod.ru/wp-content/og/sources/202212/final-m-'.$nameHash.'.png" target="_blank">https://etorazvod.ru/wp-content/og/sources/202212/final-m-'.$nameHash.'.png</a>';
//echo rs_upload_from_url('https://eto-razvod.net/generate-images/sources/final-m-'.$nameHash.'.png');
update_field( 'ru_ru_img', 'https://etorazvod.ru/wp-content/og/sources/202212/final-m-'.$nameHash.'.png', $_GET['id'] );