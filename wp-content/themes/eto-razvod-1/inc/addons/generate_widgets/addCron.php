<?php

$pathCore = '../../../../../../';
define('WP_USE_THEMES', false);
require($pathCore . 'wp-load.php');

include_once(TEMPLATEPATH . "/inc/addons/generate_widgets/generate_image_class.php");

$my_posts = new WP_Query;

$nowForQuery = new DateTime();

$myposts = $my_posts->query([
    'post_type' => 'casino',
//    'posts_per_page' => '10000',
    'meta_query' => array(
        array(
            'key' => 'company_widget_small_init',
            'value' => '1'
        ),
        array(
            'key' => 'start_widget_small_time',
            'value' => $nowForQuery->format('Ymd'),
            'compare' => '!=',
            'type' => 'DATE'
        )
    )
        ]);

foreach ($myposts as $post) {
    $casinoRating = new GenerateImageClass($post->ID);
    $casinoRating->createImage();
    $casinoRating->saveImage();

    $now = new DateTime();
    update_post_meta($post->ID, 'start_widget_small_time', $now->format('Ymd'));
    $start_widget_small_time = get_post_meta($post->ID, 'start_widget_small_time', true);
    
    echo $start_widget_small_time;
}
