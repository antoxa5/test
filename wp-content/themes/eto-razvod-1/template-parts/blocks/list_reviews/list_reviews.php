<?php
/**
 * List Reviews Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$id = 'sa_list_reviews-' . $block['id'];
if( !empty($block['anchor']) ) {
$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'sa_list_reviews';
if( !empty($block['className']) ) {
$className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
$className .= ' align' . $block['align'];
}
$result = '';
$style = get_field('style');
/*if(!$width || $width == '') {
	$width = 'default';
}*/
$title = get_field('title');
$description = get_field('description');
$post_type = get_field('post_type');
$targeting = get_field('query_type');
$posts_per_page = get_field('count');
$pagination = get_field('pagination');
$sort = get_field('sort');
$sort_order = get_field('sort_order');

if($style == 'rating') {
	$rating_columns = get_field('rating_columns');
	if(!empty($rating_columns)) {
		$fields = $rating_columns;
	} else {
		$fields = 'default';
	}
} else {
	$fields = 'default';
}

$current_language = get_locale();
if($targeting == 'post_ids') {
	$post_ids = get_field('post_ids');
    if($current_language != 'ru_RU') {
        $post_ids = array(83082, 99743, 49078, 225871, 225886);
    }
}
$args = array();

if($targeting == 'post_ids' && !empty($post_ids)) {
	$args['post__in'] = $post_ids;
}


if($post_type && $post_type != '') {
$args['post_type'] = $post_type;
}
if($sort && $sort != '' && $sort != 'count_reviews' && $sort != 'rating') {
	$args['orderby'] = $sort;
}
if($sort_order && $sort_order != '') {
	$args['order'] = $sort_order;
} else {
	$args['order'] = 'ASC';
}
if($posts_per_page < 0) {
	$args['posts_per_page'] = -1;
} else {
	$args['posts_per_page'] = $posts_per_page;
}

if( $current_language == 'ru_RU' ) {
    // Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
    $args['turn_off_on_ru_language'] = 1;		
}

$query = new WP_Query($args);

$result .= '<div id="'.esc_attr($id).'" class="sa_block '.esc_attr($className).' style_'.$style.' post_type_'.$post_type.'">';
$result .= '<div class="wrap flex_column">';
if(!empty($title)) {
	$result .= display_tagged_text($title);
}
if(!empty($description)) {
	$result .= display_tagged_text($description);
}
if ( $query->have_posts() ) {
    $result .= '<ul class="flex">';
    while ($query->have_posts()) {
        $query->the_post();
        global $post;
        if($style == 'logos' && $post_type == 'promocodes') {
            $terms = get_term(get_field('promocode_taxonomy',$post->ID),'affiliate-tags')->slug;
			$terms_id = get_term(get_field('promocode_taxonomy',$post->ID),'affiliate-tags')->term_id;
				$tasks = get_posts(array(
                            'post_type' => 'promocodes_cats',
                            'meta_query' => array(
                                array(
                                    'key' => 'affiliate_tag', // name of custom field
                                    'value' => $terms_id, // matches exaclty "123", not just 123. This prevents a match for "1234"
                                    'compare' => '='
                                )
                            )
                        ));
            $review_id = get_field('promocode_review',$post->ID);
            $company_name = get_field('company_name',$review_id);
            $result .= '<li><a href="'.get_the_permalink($tasks[0]->ID).$post->post_name.'/" target="_blank" class="do_not_translate_css_class" aria-label="'.$company_name.'">' . review_logo($review_id) . '</a></li>';
        }
    }
    $result .= '</ul>';
}
wp_reset_postdata();
$result .= '</div>';
$result .= '</div>';
echo $result;