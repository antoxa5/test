<?php
function er_block_categories( $categories, $post ) {
   /* if ( $post->post_type !== 'post' ) {
        return $categories;
    }*/
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'er-pagebuilder',
                'title' => __( 'Eto-Razvod', 'er_theme' ),
                'icon'  => 'wordpress',
            ),
        )
    );
}
add_filter( 'block_categories', 'er_block_categories', 10, 2 );



add_action('acf/init', 'er_blocks_list_posts');
function er_blocks_list_posts() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_posts',
            'title'             => __('Вкрапление постов'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/list_posts/list_posts.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/list_posts/list_posts.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'format-aside',
        ));
    }
}

add_action('acf/init', 'er_blocks_list_promocodes');
function er_blocks_list_promocodes() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_promocodes',
            'title'             => __('Вкрапление промокодов'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/list_promocodes/list_promocodes.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/list_promocodes/list_promocodes.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'format-aside',
        ));
    }
}

add_action('acf/init', 'er_blocks_list_reviews');
function er_blocks_list_reviews() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_reviews',
            'title'             => __('Вкрапление обзоров'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/list_reviews/list_reviews.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/list_reviews/list_reviews.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'excerpt-view',
        ));
    }
}


add_action('acf/init', 'er_blocks_list_comments');
function er_blocks_list_comments() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_list_comments',
            'title'             => __('Список отзывов'),
            'description'       => __('Комментарии и отзывы'),
            'render_template'   => 'template-parts/blocks/list_comments/list_comments.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/list_comments/list_comments.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'testimonial',
        ));
    }
}


add_action('acf/init', 'er_blocks_cta');
function er_blocks_cta() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_cta_reg',
            'title'             => __('Блок регистрации'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/cta/cta_reg.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/cta/cta_reg.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'megaphone',
        ));
    }
}


add_action('acf/init', 'er_blocks_popular_categories');
function er_blocks_popular_categories() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_popular_categories',
            'title'             => __('Популярные категории'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/popular_categories/popular_categories.php',
            //'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/popular_categories/popular_categories.css',
			'enqueue_assets' => function(){
			  wp_enqueue_script( 'popular_categories', get_template_directory_uri() . '/template-parts/blocks/popular_categories/popular_categories.js', array('jquery'), '1.2.5' );
                wp_enqueue_style( 'popular_categories', get_template_directory_uri() . '/template-parts/blocks/popular_categories/popular_categories.css', '', '1.7.10' );
			},
            'category'          => 'er-pagebuilder',
            'icon'              => 'megaphone',
        ));
    }
}

add_action('acf/init', 'er_blocks_popular_ratings');
function er_blocks_popular_ratings() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_popular_ratings',
            'title'             => __('Популярные рейтинги'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/popular_ratings/popular_ratings.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/popular_ratings/popular_ratings.css',
			'enqueue_assets' => function(){
			  wp_enqueue_script( 'popular_ratings', get_template_directory_uri() . '/template-parts/blocks/popular_ratings/popular_ratings.js', array('jquery'), '', true );
			},
            'category'          => 'er-pagebuilder',
            'icon'              => 'megaphone',
        ));
    }
}

add_action('acf/init', 'er_blocks_big_search');
function er_blocks_big_search() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_big_search',
            'title'             => __('Поисковая форма'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/big_search/big_search.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/big_search/big_search.css',
			'enqueue_assets' => function(){
			  wp_enqueue_script( 'big_search', get_template_directory_uri() . '/template-parts/blocks/big_search/big_search.js', array('jquery'), '', true );
			},
            'category'          => 'er-pagebuilder',
            'icon'              => 'search',
        ));
    }
}

add_action('acf/init', 'er_blocks_big_search_main');
function er_blocks_big_search_main() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_big_search_main',
            'title'             => __('Поисковая форма с редиректом'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/big_search_main/big_search.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/big_search_main/big_search.css',
			'enqueue_assets' => function(){
			  wp_enqueue_script( 'big_search', get_template_directory_uri() . '/template-parts/blocks/big_search_main/big_search.js', array('jquery'), '1.2.4', true );
			},
            'category'          => 'er-pagebuilder',
            'icon'              => 'search',
        ));
    }
}

add_action('acf/init', 'er_blocks_cta_button_text');
function er_blocks_cta_button_text() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_cta_button_text',
            'title'             => __('Кнопка с текстом'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/cta_button_text/cta_button_text.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/cta_button_text/cta_button_text.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'megaphone',
        ));
    }
}



add_action('acf/init', 'er_blocks_cta_button_text2');
function er_blocks_cta_button_text2() {
	
	// Check function exists.
	if( function_exists('acf_register_block_type') ) {
		
		// Register a testimonial block.
		acf_register_block_type(array(
			'name'              => 'er_cta_button_text2',
			'title'             => __('Блок экспертное мнение'),
			'description'       => __('С различными настройками'),
			'render_template'   => 'template-parts/blocks/cta_button_text2/cta_button_text.php',
			'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/cta_button_text/cta_button_text.css',
			'category'          => 'er-pagebuilder',
			'icon'              => 'megaphone',
		));
	}
}

add_action('acf/init', 'er_blocks_big_links');
function er_blocks_big_links() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_block_big_links',
            'title'             => __('Большие ссылки'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/big_links/big_links.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/big_links/big_links.css',
            'enqueue_assets' => function(){
	            wp_enqueue_script( 'big_links', get_template_directory_uri() . '/template-parts/blocks/big_links/big_links.js', array('jquery'), '', true );
            },
            'category'          => 'er-pagebuilder',
            'icon'              => 'megaphone',
        ));
    }
}

add_action('acf/init', 'er_blocks_list_more');
function er_blocks_list_more() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_block_list_more',
            'title'             => __('Еще по теме'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/list_more/list_more.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/list_more/list_more.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'megaphone',
        ));
    }
}

add_action('acf/init', 'er_blocks_steps');
function er_blocks_steps() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_block_steps',
            'title'             => __('Шаги'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/steps/steps.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/steps/steps.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'megaphone',
        ));
    }
}

add_action('acf/init', 'er_blocks_heading');
function er_blocks_heading() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_block_heading',
            'title'             => __('Заголовок лендинга'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/heading/heading.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/heading/heading.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'megaphone',
        ));
    }
}

add_action('acf/init', 'er_blocks_text_image');
function er_blocks_text_image() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_block_text_image',
            'title'             => __('Текст с картинкой'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/text_image/text_image.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/text_image/text_image.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'megaphone',
        ));
    }
}

add_action('acf/init', 'er_blocks_team');
function er_blocks_team() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_block_team',
            'title'             => __('Команда'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/team/team.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/team/team.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'megaphone',
        ));
    }
}

add_action('acf/init', 'er_blocks_features');
function er_blocks_features() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_block_features',
            'title'             => __('Цифры с картинкой'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/features/features.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/features/features.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'megaphone',
        ));
    }
}

add_action('acf/init', 'er_blocks_list_categories');
function er_blocks_list_categories() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'list_categories',
            'title'             => __('Ссылки на рубрики'),
            'description'       => __('Show Terms from Taxonomies in different styles'),
            'render_template'   => 'template-parts/blocks/list_categories/list_categories.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/list_categories/list_categories.css',
            'category'          => 'er-pagebuilder',
        ));
    }
}



add_action('acf/init', 'er_blocks_polls');
function er_blocks_polls() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_polls',
            'title'             => __('Опрос'),
            'description'       => __('Вопросы и ответы'),
            'render_template'   => 'template-parts/blocks/poll/poll.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/poll/poll.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'chart-bar',
        ));
    }
}

add_action('acf/init', 'er_blocks_prices');
function er_blocks_prices() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_prices',
            'title'             => __('Цены'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/prices/prices.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/prices/prices.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'cart',
        ));
    }
}

add_action('acf/init', 'er_blocks_text');
function er_blocks_text() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_text',
            'title'             => __('Текстовый блок'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/text/text.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/text/text.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'text',
        ));
    }
}

add_action('acf/init', 'er_blocks_quotes');
function er_blocks_quotes() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_quotes',
            'title'             => __('Выделенный текст'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/quotes/quotes.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/quotes/quotes.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'editor-quote',
        ));
    }
}

add_action('acf/init', 'er_blocks_form');
function er_blocks_form() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_form',
            'title'             => __('Конверсионная форма'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/form/form.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/form/form.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'feedback',
        ));
    }
}

add_action('acf/init', 'er_blocks_search');
function er_blocks_search() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_search',
            'title'             => __('Поисковая форма'),
            'description'       => __('С различными настройками'),
            'render_template'   => 'template-parts/blocks/search/search.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/search/search.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'search',
        ));
    }
}

add_action('acf/init', 'er_blocks_list_rating');
function er_blocks_list_rating() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_list_rating',
            'title'             => __('Рейтинг компаний'),
            'description'       => __('Таблица с настройками'),
            'render_template'   => 'template-parts/blocks/list_rating/list_rating.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/list_rating/list_rating.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'list-view',
        ));
    }
}

add_action('acf/init', 'er_blocks_list_services');
function er_blocks_list_services() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_list_services',
            'title'             => __('Таблица услуг'),
            'description'       => __('Таблица с настройками'),
            'render_template'   => 'template-parts/blocks/list_services/list_services.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/list_services/list_services.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'list-view',
        ));
    }
}

add_action('acf/init', 'er_blocks_features_2');
function er_blocks_features_2() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // Register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'er_features_2',
            'title'             => __('Преимущества 2'),
            'description'       => __('Список с иконками или без'),
            'render_template'   => 'template-parts/blocks/features/features_2.php',
            'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/features/features_2.css',
            'category'          => 'er-pagebuilder',
            'icon'              => 'editor-ul',
            'mode' => 'edit',
        ));
    }
}

?>
