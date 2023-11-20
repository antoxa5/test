<?php
$tag = get_query_var('tag');
$term_id = get_query_var('term_id');

$request = explode('/', $_SERVER['REQUEST_URI']);

if ($request[3] != '') {
	if (substr($request[3], 0, 1) == '?') {
		//echo 'Работает #1';
	} else {
		$wp_query->set_404();
		status_header( 404 );
		nocache_headers();
		include("404.php");
		die;
	}
} else {
	//echo 'Работает #2';
}
get_header();
if(!$term_id || $term_id == '') {
	$term_id = 'all';
}
$human_title = get_query_var('human_title');
wp_enqueue_style('news', get_template_directory_uri() . '/css/news.css');
wp_enqueue_style('rating', get_template_directory_uri() . '/css/rating.css');

$current_language = get_locale();

		?>
        <div class="page_header news_page_top">
           <?php
           $news_header = '';
		$news_header .= '<div class="wrap">';
		if (function_exists('show_breadcrumbs')) {
			$news_header .= show_breadcrumbs(0,$term_id);
		}
		$news_header .= '<div class="page_heading_line">';
		$news_header .= '<h1 class="color_dark_blue flex font_medium_new">'.$human_title.'</h1>';
		//$news_header .= '<div class="review_icon_share pointer m_l_15" data-type="share_post" data-id="'.$post->ID.'"></div>';
		$news_header .= '</div>';
		$news_header .= '</div>';
		echo $news_header;
           ?>
            <div class="news_header font_small">
                <div class="wrap">
                    <span class="link_news_filter icon_bg icon_filter pointer border_circle flex m_r_50 color_dark_gray font_smaller"><?php _e('Фильтр','er_theme'); ?></span>
                    <ul class="news_tab_selector">
                    	<li class="active"><span><?php _e('Статьи','er_theme'); ?></span></li>
                    	<li><a href="<?php bloginfo('url');?>/category/blog/"><?php _e('Блог','er_theme'); ?></a></li>
                    </ul>
                    <?php //echo autocomplete_input('ratings_all_filter_autocomplete','filter_news',__('Выберите темы','er_theme'));?>
                </div>
            </div>
        </div>

            <div class="page_content page_container background_light news_container visible">
                <div class="wrap">
                    <div class="news_left news_left_2">
	<?php // echo theme_nav('fast_links_10',0,'fast_10','fast_10','link_dark_blue font_smaller'); ?>
                   	<?php if(function_exists('news_tag_list')) {
							echo news_tag_list($term_id);
						  } ?>
                    </div>
                    <div class="news_middle">
                        <?php

                        $args = array(
                            'post_type' => array('page'),
                            'posts_per_page' => 30,
                            'orderby' => 'date',
							'post_status' => 'publish',
                            'order' => 'DESC',
                            'parent_alt_pages_hide' => 1,
                        );

                        $args_meta_query = array();

                        if ( $current_language == 'ru_RU' ) {

                            // Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
                            $args['turn_off_on_ru_language'] = 1;

                        } else {

                            $args_meta_query = array_merge( $args_meta_query, 
                                array(
                                    'relation' => 'AND',
                                    array(
                                        array(
                                            'key' => 'enable_translations',
                                            'value' => $current_language,
                                            'compare' => 'LIKE',
                                        ),
                                    )
                                )
                            );

                        }

                        // Включаем признак для фильтрации записей с включенным чекбоксом "Скрыть в новостях" через posts_clauses
                        $args['posts_hide_from_news'] = 1;

                        $args['meta_query'] = array( $args_meta_query );

                        // if($current_language != 'ru_RU') {
                        //     $args['meta_key'] = 'enable_translations';
                        //     $args['meta_value'] = $current_language;
                        //     $args['meta_compare'] = 'LIKE';
                        // }
						// $args['meta_query'] = array(
						// 	'relation' => 'OR',
						// 	array(
						// 		'key'     => 'hide_from_news',
						// 		'value'   => '0',
						// 		'compare' => '=',
						// 	),
						// 	array(
						// 		'key'     => 'hide_from_news',
						// 		'value'   => '',
						// 		'compare' => 'NOT EXISTS'
						// 	)
						// );

                        if($term_id != 'all') {
                            $args['tax_query'] = array(
                                'relation' => 'OR',
                            );
                                $args['tax_query'][] = array(
                                    'taxonomy' => 'affiliate-tags',
                                    'field'    => 'id',
                                    'terms'    => array($term_id),
                                );
                            

                        }
                        //print_r($args);
                        $news = new WP_Query($args);
						$count_all_news = $news->found_posts;
                        if ( $news->have_posts() ) { ?><?php
                            while ( $news->have_posts() ) {
                                $news->the_post();
                                global $post;
                                echo single_post($post->ID);

                                ?>

                                <?php
                            } ?>

                        <?php }?>
                        <?php
                        wp_reset_postdata();
						if($count_all_news > 30) {
							echo '<div class="button button_comments button_green pointer load_more_news font_small font_bold m_b_20" data-offset="30" data-total="'.$count_all_news.'" data-tag="'.$term_id.'">'.__('Загрузить еще','er_theme').'</div>';
						}
						
                        ?>
                    </div>
                    <div class="news_right">
                        <div class="white_block">
                            <?php

	$posts_in_language_args = array(
		'post_type' => array('page'),
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'date',
		'order' => 'DESC',
        'parent_alt_pages_hide' => 1,
	);

    if($current_language != 'ru_RU') {

		$posts_in_language_args = array_merge( $posts_in_language_args, 
			array(
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'enable_translations',
						'value' => $current_language,
						'compare' => 'LIKE'
					)
				)
        	)
		);

    } else {

        // $args = array(
        //     'post_type' => array('post'),
        //     'number' => 30
        // );
        // $comments = get_comments($args);

		// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
		$posts_in_language_args['turn_off_on_ru_language'] = 1;

    }

	$posts_in_language = new WP_Query( $posts_in_language_args );

	wp_reset_postdata();

	$post_ids_lang = wp_list_pluck($posts_in_language->posts, 'ID');
	$post_ids_lang_string = implode(',', $post_ids_lang);

	global $wpdb;
	$sql = "SELECT comment_ID, comment_date, comment_content, comment_post_ID, user_id
		FROM {$wpdb->comments} 
		WHERE comment_post_ID in (".implode(',', $post_ids_lang).") AND comment_approved = 1
		ORDER by comment_date ASC LIMIT 30";

	$comments_list = $wpdb->get_results( $sql );

	$comments = $comments_list;

	$locales = [ 'en_US', 'es_ES', 'de_DE', 'fr_FR', 'pl_PL', 'fi', 'id_ID' ];

                            foreach($comments as $comment) {

                                $result = '';
								$attachment_id = '';
                                $attachment_id = get_field('photo_profile', 'user_'. $comment->user_id );
                                $result .= '<div class="news_comment flex flex_column">';
                                $result .= '<a class="news_comment_title font_small color_dark_blue font_bold" href="'.get_the_permalink($comment->comment_post_ID).'">'.wp_trim_words(get_the_title($comment->comment_post_ID),4).'</a>';

                                $comment_translations = get_field( 'comment_translations', $comment );

								$text = wp_trim_words($comment->comment_content,12);
								if ($current_language == 'ru_RU') {
									if (! preg_match('/^[a-z0-9 .}, !@#$%^&*()_+|\';?><-]+$/i',  wp_trim_words($comment->comment_content,12)) ) {

									} else {
										$a = 1;

										if( $comment_translations ) {

                                            foreach ( $comment_translations as $item ) {
                                                if ( $item['language'] == 'ru_RU' ) {
                                                    $text = wp_trim_words( $item['translation'], 12 );
                                                }
                                            }
										}
									}
								}

                                foreach( $locales as $locale ) {
                                
                                    if ( $current_language == $locale ) {

                                        if( $comment_translations ) {

                                            foreach ( $comment_translations as $item ) {

                                                if ( $item['language'] == $locale ) {

                                                    $text = wp_trim_words( $item['translation'], 12 );

                                                }

                                            }

                                        }

                                        break;

                                    }
                                
                                }

								$result .= '<div class="news_comment_content color_dark_gray font_smaller line_big">'.$text.'</div>';
                                $result .= '<div class="news_comment_footer flex">';
                                    $result .= '<div class="author_avatar"';
                                    if( isset($attachment_id['sizes']['thumbnail']) &&  $attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '' ) {
                                        $result .= ' style="background-image: url('.$attachment_id['sizes']['thumbnail'].');"';
                                    }
                                    $result .= '></div>';
                                    $result .= '<div class="post_meta flex flex_column">';

                                    $result .= '<div class="post_meta_author font_bold font_small color_dark_blue pointer m_b_5">';
                                    $author = get_userdata( $comment->user_id );

                                    $user_alt_name = get_user_alt_name( $comment->user_id, $current_language );

                                    if( $user_alt_name ) {
                                        $result .= $user_alt_name;
                                    } elseif($author->first_name && !$author->last_name) {
                                        $result .= $author->first_name;
                                    } elseif(!$author->first_name && $author->last_name) {
                                        $result .= $author->last_name;
                                    } elseif($author->first_name && $author->last_name) {
                                        $result .= $author->first_name.' '.$author->last_name;
                                    } else {
                                        $result .= $author->user_nicename;
                                    }
                                    $result .= '</div>';

                                    $result .= '<div class="post_meta_date font_smaller color_dark_gray">'.get_comment_date('F j Y', $comment->comment_ID ).'</div>';
                                    $result .= '</div>';
                                $result .= '</div>';
                                $result .= '</div>';
                                echo $result;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
		
		
		<?php


get_footer();

?>