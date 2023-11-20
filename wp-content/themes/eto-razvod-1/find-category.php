<?php
get_header();
$tag = get_query_var('tag');
$key = get_query_var('phrase');
if($key && $key != '') {
	$key = urldecode($key);
	$search_active = ' active';
} else {
	$search_active = '';
}
$term_id = get_query_var('term_id');
$human_title = get_query_var('human_title');
wp_enqueue_style('search_category', get_template_directory_uri() . '/css/search_category.css',[],$special_word);
wp_enqueue_script( 'progressbar', get_template_directory_uri() . '/js/progressbar.js', array('jquery'),$special_word );
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$current_language = get_locale();
if($current_language == 'ru_RU') {
    $text_search_1 = 'Поиск в рубрике';
    $text_search_2 = 'Поиск по запросу';
    $text_search_3 = 'Рубрика:';
    $text_search_4 = 'Поиск компаний';
    $text_search_5 = 'по запросу';
} else {
    $text_search_1 = 'Search in category';
    $text_search_2 = 'Search for';
    $text_search_3 = 'Category:';
    $text_search_4 = 'Company search';
    $text_search_5 = 'for';
}
$result = '';
$result .= '<div class="page_header page_header_search page_search_single">';
	$result .= '<div class="wrap">';
	if($key && $key != '' && $tag && $tag != 'all') {
		$result .= '<h1 class="color_dark_blue flex font_medium_new">'.$text_search_1.' '.__($human_title,'er_theme').' '.$text_search_5.' '.htmlspecialchars($key).'</h1>';
	} elseif ($key && $key != '' && $tag && $tag == 'all') {
		$result .= '<h1 class="color_dark_blue flex font_medium_new">'.$text_search_2.' '.htmlspecialchars($key).'</h1>';
	} elseif(!$key && $tag && $tag != 'all' || $key == '' && $tag && $tag != 'all') {
		$result .= '<h1 class="color_dark_blue flex font_medium_new">'.$text_search_3.' '.$human_title.'</h1>';
	} else {
		$result .= '<h1 class="color_dark_blue flex font_medium_new">'.$text_search_4.'</h1>';
	}
	
	$result .= '<div class="review_icon_share pointer m_l_15" data-type="share_search" data-id="'.$actual_link.'"></div>';
$result .= '<form class="radius_small flex not_typing'.$search_active.'" id="search_results_form" name="search_results_form">';
	$result .= '<input type="text" name="s" class="placeholder_gray" value="'.htmlspecialchars($key).'" placeholder="'.__('Поиск..').'" />';
	$result .= '<div class="big_search_icon_clear"></div>';
	$result .= '<div class="big_search_icon"></div>';
	$result .= '</form>';
	$result .= '</div>';
$result .= '</div>';
echo $result;
?>
<div class="search_results_filter_header font_small">
                <div class="wrap">
                    <div class="color_dark_blue search_filter_title"><?php _e('Фильтр','er_theme'); ?></div>
                    <?php 
					if($term_id && $term_id != '') { ?>
						<ul class="current_tag"><li data-term-id="<?php echo $term_id; ?>" data-slug="<?php echo $tag; ?>"aria-><?php echo $human_title; ?></li></ul>
					<?php } else { ?>
						<ul class="current_tag"></ul>
					<?php }
					?>
                    
                    <div class="search_results_top_sorter inactive dropdown flex" id="search_results_top_sorter">
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
<div class="page_content page_container search_category_container visible background_light">
<div class="wrap">
<div class="search_category_results_left">
	<?php echo search_results_filter($term_id); ?>
</div>
<div class="search_category_results_right">
	<?php
echo show_search_category_results($term_id,$key);
?>
</div>

                </div>
            </div>


    

<?php

get_footer();

?>