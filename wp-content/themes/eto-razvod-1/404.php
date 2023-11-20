<?php
get_header();

?>
    <div class="page_content page_container review_container_content single_container visible single_news background_light single_404">
        <div class="wrap">
			<?php echo print_css_links('review_content') ?>
            <div class="the_left_content"></div>
            <div class="the_content color_dark_gray font_small">
                <h1 class="m_b_10 font_22 color_dark_blue"><?php _e( 'Извините, страница не существует', 'er_theme' ); ?></h1>
				<?php _e( 'Вероятно, вы могли перейти по ссылке, которая ведет на удаленный материал или сделали ошибку в адресе URL. Воспользуйтесь формой поиска, с помощью которой вы быстро найдёте искомую страницу или перейдете в нужный раздел.', 'er_theme' ); ?>
               <?php 
				$result = '';
				$result .= '<form class="radius_small flex not_typing'.$search_active.'" id="search_results_form" name="search_results_form">';
				$result .= '<input type="text" name="s" class="placeholder_gray" value="'.htmlspecialchars_decode($key).'" placeholder="'.__('Поиск..').'" />';
				$result .= '<div class="big_search_icon_clear"></div>';
				$result .= '<div class="big_search_icon"></div>';
				$result .= '</form>';
				echo $result;
				?>
                <div class="flex buttons_404">
                    <a href="<?php bloginfo('url'); ?>" class="button button_green link_no_underline button_padding_big font_small font_bold pointer"><?php _e('Поиск компаний','er_theme'); ?></a>
                    <a href="<?php bloginfo('url'); ?>/pages/" class="button link_no_underline button_dark_gray button_padding_big font_small font_bold pointer"><?php _e('Поиск новостей','er_theme'); ?></a>
                    <a href="<?php bloginfo('url'); ?>/promocode/" class="button button_violet link_no_underline button_padding_big font_small font_bold pointer"><?php _e('Поиск купонов','er_theme'); ?></a>
                </div>
            </div>



        </div>
    </div>

<?php

get_footer();

?>