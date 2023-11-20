<?php

require_once("wp-load.php");
include_once(TEMPLATEPATH . "/inc/addons/generate_widgets/generate_image_class.php");

$comp_id = $_GET["comp_id"];

$img_url = 'https://' . $_SERVER['SERVER_NAME'] . "/icompany/" . $comp_id . '.png';

$casinoClass = new GenerateImageClass($comp_id);
$count_rewiews_company = $casinoClass->countedText($reviewsCount, __(' отзыв', 'er_theme'), __(' отзыва', 'er_theme'), __(' отзывов', 'er_theme'));

$post_company_title = get_the_title($comp_id);
$reviewsCount = get_field('reviews_count_reviews', $comp_id);
$rating = get_field('reviews_rating_average', $comp_id);
echo '<div class=my-widget_small">'
 . '<img id="etorazvod-widget_image" name="akbars-creditcard" src="' . $img_url . '" style="width: 100%;" alt="' . $post_company_title . ' - '.$reviewsCount.' '.$count_rewiews_company.'">'
 . '</div>';