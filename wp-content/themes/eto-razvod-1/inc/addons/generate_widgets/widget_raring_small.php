<?php

include_once(TEMPLATEPATH . "/inc/addons/generate_widgets/generate_image_class.php");

if (!function_exists('get_reting_casino_dashboard')) {
    
    function get_reting_casino_dashboard($comp_id) {
        $casinoRating = new GenerateImageClass($comp_id);
        $casinoRating->createImage();
        $casinoRating->saveImage();
        return $casinoRating->outputImage();
    }

}

if (!function_exists('init_widget_small')) {

    add_action('wp_ajax_init_widget_small', 'init_widget_small');
    add_action('wp_ajax_nopriv_init_widget_small', 'init_widget_small');

    function init_widget_small() {


        $comp_id = $_POST['comp_id'];
        $current_user_for_rating = wp_get_current_user();
        $user_id_for_rating = $current_user_for_rating->data->ID;
        
        $casinoClass = new GenerateImageClass($comp_id);
        $reviewsCount = get_field('reviews_count_reviews', $comp_id);
        $count_rewiews_company = $casinoClass->countedText($reviewsCount, __(' отзыв', 'er_theme'), __(' отзыва', 'er_theme'), __(' отзывов', 'er_theme'));

        $company_id_for_rating = get_field('comp_statuses', 'user_' . $user_id_for_rating);
        $company_id_for_rating = is_array($company_id_for_rating) ? $company_id_for_rating : array();
        $post_slug = get_post_field( 'post_name', $comp_id );
        $post_company_title = get_the_title( $comp_id );
        $post_id_for_rating = $company_id_for_rating[0]['company_user'][0];

        $dir = $_SERVER['DOCUMENT_ROOT'] . "/icompany/";

        $check_init = get_post_meta($comp_id, 'company_widget_small_init', true);
        if ($check_init == 1) {
            update_post_meta($comp_id, 'company_widget_small_init', 0);
            echo '<h3>Вы отключили свой виджет</h3>';
            die;
        } else {
            update_post_meta($comp_id, 'company_widget_small_init', 1);
            update_post_meta($comp_id, 'start_widget_small_time', date('Y-m-d H:i:s'));
            
//            echo '<h3>Скопируйте и вставьте код виджета на свой сайт:</h3><div class="div_widget_small_for_company">&lt;div class=my-widget_small" &gt;&lt;img id="etorazvod-widget_image" name="'.$post_slug.'" src="https://' . $_SERVER['SERVER_NAME'] . '/icompany/' . $comp_id . '.png" style="width: 100%;" alt="'.$post_company_title.' - '.$reviewsCount.$count_rewiews_company.'"&gt;'
//            . '&lt;script src="https://beta2.eto-razvod.ru/gen_widgets.js"&gt;'
//            . '&lt;/script&gt;'
//            . '&lt;/div&gt;</div>';
            
            echo '<h3>Скопируйте и вставьте код виджета на свой сайт:</h3>'
            . '<div class="div_widget_small_for_company">&lt;div id="er_widget_small"&gt;&lt;/div&gt;'
            . '&lt;script id="erw_script" src="https://beta2.eto-razvod.ru/gen_widgets.js?comp_id='.$comp_id.'"&gt;'
            . '&lt;/script&gt;'
            . '</div>';
            die;
        }
    }

}