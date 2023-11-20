<?php
/*
Template Name: Rating All
*/
get_header();

if (have_posts()) :
        while (have_posts()) : the_post();
            wp_enqueue_style('rating', get_template_directory_uri() . '/css/rating.css');
	        wp_enqueue_script( 'top_ratings', get_template_directory_uri() . '/js/top_ratings.js', array('jquery') );
		?>
        <div class="page_header page_rating_all">
            <div class="wrap flex_column">
                <div class="page_heading_line">
                    <h1 class="color_dark_blue flex font_medium_new"><?php the_title(); ?></h1>
                    <div class="review_icon_share pointer m_l_15" data-type="share_post" data-id="<?php echo $post->ID; ?>"></div>
                </div>
                <?php
                $current_language = get_locale();
                if($current_language == 'ru_RU') {
                    $top_ratings = get_field('rating_all_top');
                    $res_top_ratings = '';
                    if(!empty($top_ratings)) {
                        $res_top_ratings .= '<div class="flex big_links_icons_rates"><span class="big_links_icons_rate_arrow big_links_icons_rate_arrow_left" data-link="left"></span><span class="big_links_icons_rate_arrow big_links_icons_rate_arrow_right" data-link="right"></span></div><div class="top_ratings flex" id="top_rating_all">';
                        foreach ($top_ratings as $top_rating) {
                            $res_top_ratings .= '<div class="top_ratings_item">';
                            $res_top_ratings .= '<a class="color_dark_blue link_no_underline font_bold font_18 m_b_20 inline_block" href="'.get_the_permalink($top_rating).'" target="_blank">'.get_the_title($top_rating).'</a>';
                            $tag_term = get_term( get_field('rating_tag',$top_rating), 'affiliate-tags' );
                            $tag_human_title = get_field('tag_human_title','term_'.$tag_term->term_id);
                            $res_top_ratings .= '<div class="color_dark_blue font_small font_underline_dotted inline_block">'.$tag_human_title.'</div>';
                            $res_top_ratings .= '</div>';
                        }
                        $res_top_ratings .= '</div>';

                        $res_top_ratings .= '<span class="tabs_mobile_mover tabs_mobile_mover_top_ratings_item">';
                        for ($i = 1;$i <= count($top_ratings);$i++) {
                            if ($i == 1) {
                                $res_top_ratings .= '<span class="tabs_mobile_mover__item tabs_mobile_mover__item_active" data-n="'.$i.'"></span>';
                            } else {
                                $res_top_ratings .= '<span class="tabs_mobile_mover__item" data-n="'.$i.'"></span>';
                            }
                        }
                        $res_top_ratings .= '</span>';
                    }
                    echo $res_top_ratings;
                }

                ?>
            </div>
            <div class="rating_header rating_header_all font_small">
                <div class="wrap">
                    <div class="color_dark_blue rating_th"><?php _e('Выберите рубрику','er_theme'); ?></div>
                    <?php echo autocomplete_input('ratings_all_filter_autocomplete','filter_ratings',__('Начните вводить текст','er_theme'));?>

                    <div class="rating_all_sort inactive dropdown flex" id="rating_all_sort" data-autocomplete-form="#filter_form_ratings_all_filter_autocomplete">
                    	<div class="rating_all_sort_title color_dark_gray pointer font_smaller"><?php _e('Сортировать по','er_theme'); ?></div>
                    	<ul class="font_smaller">
                    		<li class="sort_title color_dark_gray pointer active" data-sort-type="title"><?php _e('По алфавиту (А-Я)','er_theme'); ?></li>
                    		<li class="sort_title_reverse color_dark_gray pointer" data-sort-type="title_reverse"><?php _e('По алфавиту (Я-А)','er_theme'); ?></li>
                    		<li class="sort_new color_dark_gray pointer" data-sort-type="new"><?php _e('Сначала новые','er_theme'); ?></li>
                    		<li class="sort_old color_dark_gray pointer" data-sort-type="old"><?php _e('Сначала старые','er_theme'); ?></li>
                    	</ul>
                    </div>
                </div>
            </div>
        </div>

            <div class="page_content page_container background_light rating_container visible">
                <div class="wrap">

<?php echo rating_table_all_main(); ?>

                </div>
            </div>


		<?php
		endwhile;
endif;


get_footer();

?>