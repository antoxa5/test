<?php
//require('/home/eto/web/eto-razvod.ru/public_html/wp-load.php');
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

// include the imagettftextblur source if you're not using Composer
if (file_exists('testfonts.php')) {
	include_once 'testfonts.php';
} else {
	die('imagettftextblur.php not found');
}
$nameHash = time();
// set the parameters for our image
$width            = 600;
$height           = 300;
$size             = 40;
$font             = __DIR__ . '/Stem-Regular.ttf';

$string           = 'Карта рассрочки Свобода от Home Credit Bank это развод?';

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
$im               = imagecreatetruecolor($width, $height);

$im = imagecreatefrompng(
	'https://eto-razvod.ru/wp-content/themes/eto-razvod-1/font/images_temp/og-image.png');
$png = imagecreatefrompng('https://eto-razvod.ru/wp-content/themes/eto-razvod-1/font/images_temp/gradient.png');
$jpeg = imagecreatefrompng('https://eto-razvod.ru/wp-content/themes/eto-razvod-1/font/images_temp/og-image.png');

list($width, $height) = getimagesize('https://eto-razvod.ru/wp-content/themes/eto-razvod-1/font/images_temp/og-image.png');
list($newwidth, $newheight) = getimagesize('https://eto-razvod.ru/wp-content/themes/eto-razvod-1/font/images_temp/gradient.png');
$im = imagecreatetruecolor($width, $height);
imagecopyresampled($im, $jpeg, 0, 0, 0, 0, $width, $height, $width, $height);
imagecopyresampled($im, $png, 0, 0, 0, 0, $newwidth, $newheight, $newwidth, $newheight);







// set our image's colors
$background_color = imagecolorallocate($im, 0xEE, 0xEE, 0xEE);
$text_color       = imagecolorallocate($im, 0x00, 0x00, 0x00);

// fill our image with the background color
imagefill($im, 0, 0, $background_color);

// place the text onto our image
imagettftextblur(
	$im,
	$size,
	0,
	$x_offset,
	$y_offset,
	$text_color,
	$font,
	$string
);


// display our image and destroy the GD resource
header('Content-Type: image/png');

//imagepng($im);
$save = "final-".$nameHash.".png";
imagepng($im, $save);
imagedestroy($im);



$im               = imagecreatetruecolor($width, $height);

$im = imagecreatefrompng(
	'https://eto-razvod.ru/wp-content/themes/eto-razvod-1/font/images_temp/final-'.$nameHash.'.png');
$png = imagecreatefrompng('https://eto-razvod.ru/wp-content/themes/eto-razvod-1/font/logo-og.png');
$jpeg = imagecreatefrompng('https://eto-razvod.ru/wp-content/themes/eto-razvod-1/font/images_temp/final-'.$nameHash.'.png');

list($width, $height) = getimagesize('https://eto-razvod.ru/wp-content/themes/eto-razvod-1/font/images_temp/final-'.$nameHash.'.png');
list($newwidth, $newheight) = getimagesize('https://eto-razvod.ru/wp-content/themes/eto-razvod-1/font/logo-og.png');
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
header('Content-Type: image/png');

imagepng($im);
$save = "final-m-".$nameHash.".png";
imagepng($im, $save);
imagedestroy($im);
