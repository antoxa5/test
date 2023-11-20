<?php
/**
 * List Posts Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'er_block_list_more-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'er_block_list_more';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$result = '';
$args = array(
			'post_type' => array('post'),
			'posts_per_page' => 3,
			'orderby' => 'date',
			'order' => 'DESC',
			'parent_alt_pages_hide' => 1,
		);
$current_language = get_locale();
if($current_language != 'ru_RU') {
    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key'     => 'enable_translations',
        'value'   => $current_language,
        'compare' => 'LIKE'
    );
} else {

	// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
	$args['turn_off_on_ru_language'] = 1;

}

$news = new WP_Query($args);
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.' background_light">';
	$result .= '<div class="wrap flex_wrap">';
		$result .= '<div class="flex_100 font_smaller_2 font_bolder font_uppercase color_dark_blue m_b_30">'.__('Еще по теме','er_theme').'</div>';
		$result .= '<div class="container_left">';
			$result .= '<div class="white_block">';
			if ( $news->have_posts() ) { 
				$result .= '<ul>';
                            while ( $news->have_posts() ) {
                                $news->the_post();
                                global $post;
			$author_id = get_the_author_meta('ID', $post->post_author);
		$user_alt_name = get_user_alt_name( $author_id, $current_language );

        $author = get_userdata($author_id);
        $attachment_id = get_field('photo_profile', 'user_'. $author_id );
        $thumb = get_the_post_thumbnail_url( $post_id, 'large' );
				$result .= '<li>';
				$result .= '<div class="author_avatar"';
                if($attachment_id['sizes']['thumbnail'] && $attachment_id['sizes']['thumbnail'] != '') {
                    $result .= ' style="background-image: url('.$attachment_id['sizes']['thumbnail'].');"';
                }
                $result .= '></div>';
					$result .= '<div class="news_middle">';
						$result .= '<a href="'.get_the_permalink().'" class="color_dark_blue link_no_underline font_bold font_small">'.get_the_title().'</a>';
								$result .= '<div class="news_list_meta flex">';
								$result .= '<div class="post_meta_author font_bold font_small color_dark_blue pointer">';

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
								$result .= '<div class="post_meta_date font_smaller color_dark_gray">'.get_the_date('F j Y',$post->ID).'</div>';
								$result .= '</div>';
					$result .= '</div>';
				$result .= '</li>';
			
							}
				$result .= '</ul>';
			}
 wp_reset_postdata();
			$result .= '</div>';
		$result .= '</div>';
		$result .= '<div class="container_side flex flex_column">';
			$result .= '<div class="white_block side_block">';
				$result .= '<div class="block_title font_smaller_2 font_bolder font_uppercase color_dark_blue">'.__('Ваша компания есть на сайте?','er_theme').'</div>';
				$result .= '<div class="block_content font_smaller line_height_22">';
				$result .= '<p>'.__('Подайте заявку на управление профилем своей компании, чтобы получить доступ к бесплатным бизнес-инструментам Etorazvod и вовремя отвечать на отзывы.','er_theme').'</p>';
				$result .= '<a class="color_dark_gray link_right link_inactive link_no_underline" href="'.get_bloginfo('url').'/add-company/">'.__('Подробнее','er_theme').'</a>';
				$result .= '</div>';
			$result .= '</div>';
		$result .= '</div>';
	$result .= '</div>';
$result .= '</div>';
echo $result;
?>