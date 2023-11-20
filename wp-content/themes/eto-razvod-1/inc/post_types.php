<?php
function cptui_register_my_cpts_promocodes() {

    /**
     * Post Type: Промокоды.
     */

    $labels = array(
        "name" => __( "Промокоды", "custom-post-type-ui" ),
        "singular_name" => __( "Промокод", "custom-post-type-ui" ),
    );

    $args = array(
        "label" => __( "Промокоды", "custom-post-type-ui" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "promocode/%show_category%", "with_front" => false ),
        "query_var" => true,
        "supports" => array( "title", "editor", "comments" ),
    );

    register_post_type( "promocodes", $args );
}

add_action( 'init', 'cptui_register_my_cpts_promocodes' );

function cptui_register_my_cpts_addpages() {

    /**
     * Post Type: Доп. страницы.
     */

    $labels = array(
        "name" => __( "Доп. страницы", "custom-post-type-ui" ),
        "singular_name" => __( "Доп. страница", "custom-post-type-ui" ),
    );

    $args = array(
        "label" => __( "Доп. страницы", "custom-post-type-ui" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "review/%show_category%", "with_front" => false ),
        "query_var" => true,
        "supports" => array( "title", "editor", "thumbnail","comments" ),
    );

    register_post_type( "addpages", $args );
}

add_action( 'init', 'cptui_register_my_cpts_addpages' );


function cptui_register_my_cpts_promocodes_cats() {

    /**
     * Post Type: Категории промокодов.
     */

    $labels = array(
        "name" => __( "Категории промокодов", "custom-post-type-ui" ),
        "singular_name" => __( "Категория", "custom-post-type-ui" ),
    );

    $args = array(
        "label" => __( "Категории промокодов", "custom-post-type-ui" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "promocode", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "editor", "thumbnail", "comments" ),
    );

    register_post_type( "promocodes_cats", $args );
}

add_action( 'init', 'cptui_register_my_cpts_promocodes_cats' );


add_action('init', 'casino_posts');

function casino_posts() {
    $args = array(
        'labels' => array(
            'name' => __( 'Brokers' ),
            'singular_name' => __( 'Broker' ),
            'add_new' => __( 'Add New' ),
            'add_new_item' => __( 'Add New Broker Site' ),
            'edit' => __( 'Edit' ),
            'edit_item' => __( 'Edit Broker Site' ),
            'new_item' => __( 'New Broker Site' ),
            'view' => __( 'View Broker Site' ),
            'view_item' => __( 'View Broker Site' ),
            'search_items' => __( 'Search Broker Sites' ),
            'not_found' => __( 'No Broker Sites found' ),
            'not_found_in_trash' => __( 'No Broker Sites found in Trash' ),
            'parent' => __( 'Parent Broker Site' ),

        ),

        'public' => true,
        'show_ui' => true,
        //"show_in_rest" => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array( 'slug' => 'review', 'with_front' => false ),
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'comments','page-attributes', 'revisions','author')
    );

    register_post_type('casino',$args);

    $labels = array(
        'name' => _x( 'Broker Tags', 'affiliate tag' ),
        'singular_name' => _x( 'Genre', 'affiliate tag' ),
        'search_items' =>  __( 'Search Broker Tags' ),
        'all_items' => __( 'All Broker Tags' ),
        'parent_item' => __( 'Parent Broker Tag' ),
        'parent_item_colon' => __( 'Parent Broker Tag:' ),
        'edit_item' => __( 'Edit Broker Tag' ),
        'update_item' => __( 'Update Broker Tag' ),
        'add_new_item' => __( 'Add New Broker Tag' ),
        'new_item_name' => __( 'New Broker Tag' ),
        'menu_name' => __( 'Broker Tags' ),
    );

    register_taxonomy('affiliate-tags',array('casino','post','page'), array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'affiliates' ),
    ));



}

add_action('admin_init', 'create_metaboxes');

add_action('save_post','save_seometaboxes');
add_action('save_post','save_blogmetaboxes');
add_action('save_post','save_casinometaboxes');


function get_distinct_values($key, $excludeArray)
{
    global $wpdb;
    $x = $wpdb->get_col("SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key='$key'");
    $types = array();
    foreach($x as $y)
    {
        if (!in_array($y, $excludeArray)) {
            $types[] = $y;
        }
    }
    return $types;
}





?>