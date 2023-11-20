<?php
if(function_exists('get_rating_fields_group')) {
	$rating_fields_group = get_rating_fields_group($post->ID);
} else {
	$rating_fields_group = 0;
}
global $special_word;
wp_enqueue_style('comments', get_template_directory_uri() . '/css/comments.css', [], $special_word.filemtime(TEMPLATEPATH . '/css/comments.css'));
//if ( have_comments() ) :
$comments_top = '';
$comments_top .= print_js_links()['events'];
?>
<h2 class="show-comments-title"><?php _e('Отзывы'); ?></h2>
<ul class="show-comments">
<?php
//комментарии
	$language = get_locale();
	if (get_post_type() == 'casino') {

	$args_sorted = array(
		'post_id' => get_the_ID(),
		'status' => 'approve',
	);
	$comments_sorted = $args_sorted;
	$get_ratings_count['count'] = count($comments_sorted);
	$comments_top = '';
	$comments_top .= '<div class="white_block comments_top flex">';
	if(get_post_type(get_the_ID()) == 'casino') {
		$comments_count_top_number = get_field('reviews_count_reviews',get_the_ID());
		if(!$comments_count_top_number || $comments_count_top_number == '') {
			$comments_count_top_number = 0;
		}
	} else {
		$comments_count_top_number = $get_ratings_count['count'];
	}
	$post_slug = get_post_field( 'post_name', get_the_ID() );
	$company_name = get_field('company_name',get_the_ID());
	if($company_name != '') {
		$comments_top .= '<h2 class="comments_top_title font_uppercase font_bolder color_dark_blue font_smaller_2">'.$company_name.' '.__('отзывы','er_theme').'</h2>';
	} else {
		$comments_top .= '<h2 class="comments_top_title font_uppercase font_bolder color_dark_blue font_smaller_2">'.__('Отзывы','er_theme').'</h2>';
	}

	$comments_top .= '<div class="comments_top_count font_bold color_dark_gray font_small">'.$comments_count_top_number.'</div>';
//if (($user_id == "undefined") && ($data['slug'] != 'comments') && ($data['slug'] != 'dashboard_company')) {
	$comments_top .= '<a class="link_no_underline button button_comments button_green pointer font_small font_bold" href="'.get_bloginfo('url').'/add-review/?id='.$post_slug.'" rel="nofollow">' . __( 'Добавить отзыв', 'er_theme' ) . '</a>';
//}
	/*if (($data['slug'] == 'comments') || ($data['slug'] == 'dashboard_company')) {
	$comments_top .= '<div class="show_block_comments"><div class="color_dark_gray font_small link_review_map link_dropdown link_inactive show_block show_block_to_up" data-block=".comment_top_dashboard_comments__footer" data-type="comment_top_dashboard_comments__footer_show"></div></div>';
	} else {*/
	if($comments_count_top_number > 0) {
		$comments_top .= '<div class="comments_sorter  comments_top_show_comments">';
		$comments_top .= '<div class="comments_sorter_title color_dark_gray pointer font_smaller dropdown flex">'.__('Отсортировать','er_theme').'</div>';
		$comments_top .= '<ul class="font_smaller">';
		$sort_type = 'new';
		if($sort_type == 'new') {
			$sort_new_active = ' active';
		} else {
			$sort_new_active = '';
		}
		if($sort_type == 'best') {
			$sort_best_active = ' active';
		} else {
			$sort_best_active = '';
		}
		if($sort_type == 'old') {
			$sort_old_active = ' active';
		} else {
			$sort_old_active = '';
		}
		$comments_top .= '<li class="sort_best color_dark_gray pointer'.$sort_best_active.'" data-sort-type="badrun">'.__('По возрастанию оценки','er_theme').'</li>';
		$comments_top .= '<li class="sort_best color_dark_gray pointer'.$sort_best_active.'" data-sort-type="goodrun">'.__('По убыванию оценки','er_theme').'</li>';
		$comments_top .= '<li class="sort_new color_dark_gray pointer'.$sort_new_active.'" data-sort-type="new">'.__('Сначала новые','er_theme').'</li>';
		$comments_top .= '<li class="sort_old color_dark_gray pointer'.$sort_old_active.'" data-sort-type="old">'.__('Сначала старые','er_theme').'</li>';
		$comments_top .= '<li class="sort_best color_dark_gray pointer'.$sort_best_active.'" data-sort-type="best">'.__('Сначала популярные','er_theme').'</li>';
		$comments_top .= '</ul>';
		$comments_top .= '</div>';
	}
	/*}*/
	$comments_top .= '</div>';
	echo $comments_top;
	if ($comments_count_top_number == 0) {
		echo '<div class="text_centered m_t_15 m_b_20 no_reviews_yet color_dark_gray">'.__('Ещё нет отзывов, будьте первым!','er_theme').'</div>';
	}
}


/*if (get_post_type() == 'casino' && $language == 'ru_RU') {

	if (get_post_type($post->ID) == 'casino') {
		wp_list_comments(array(
			'callback' => 'custom_comment_single_hidden_new',
			'per_page' => -1,
			'rating_fields' => get_comment_rating_fields($rating_fields_group, 'key'),
		));
	} else {
		wp_list_comments(array(
			'callback' => 'custom_comment_single_hidden',
			'per_page' => -1,

		));
	}
} else {
	if (get_post_type($post->ID) == 'casino') {
		wp_list_comments(array(
			'callback' => 'custom_comment_single_hidden',
			'per_page' => -1,
			'rating_fields' => get_comment_rating_fields($rating_fields_group, 'key'),
		));
	} else {
		wp_list_comments(array(
			'callback' => 'custom_comment_single_hidden',
			'per_page' => -1,

		));
	}
}*/
	if (get_post_type($post->ID) == 'casino') {
		wp_list_comments(array(
			'callback' => 'custom_comment_single_hidden_new',
			'per_page' => -1,
			'rating_fields' => get_comment_rating_fields($rating_fields_group, 'key'),
		));
	} else {
		wp_list_comments(array(
			'callback' => 'custom_comment_single_hidden',
			'per_page' => -1,

		));
	}
?>
</ul>
<ul id="reviews">
	<?php

    if (get_post_type($post->ID) == 'casino') {
        wp_enqueue_script('ajax-comments', get_template_directory_uri() . '/js/ajax-comments.js', array('jquery'), '1'.$special_word.filemtime(TEMPLATEPATH . '/js/ajax-comments.js'));
    } else {
        wp_enqueue_script('ajax-comments', get_template_directory_uri() . '/js/single_comments.js', array('jquery'), '1'.$special_word.filemtime(TEMPLATEPATH . '/js/single_comments.js'));
    }

	/*wp_list_comments( array(
	'callback' => 'custom_comment_single',
	'per_page' => -1,
	'rating_fields' => get_comment_rating_fields($rating_fields_group,'key'),
));*/
	?>
</ul>