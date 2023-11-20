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
$id = 'er_block_text_image-' . $block['id'];
if( !empty($block['anchor']) ) {
	$id = $block['anchor'];
}
if(get_field('title_tag')) {
	$title_tag = get_field('title_tag');
} else {
	$title_tag = 'div';
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'block_text_image';
if( !empty($block['className']) ) {
	$className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
	$className .= ' align' . $block['align'];
}
$button_text = get_field('button_text');
$button_link = get_field('button_link');
$text = get_field('text');
$style = get_field('style');
$title = get_field('title');
$text = get_field('text');
$image = get_field('image');
$accord = get_field('accord');
$image_position = get_field('image_position');
$image_link = wp_get_attachment_image_url( $image, 'large' );
$result = '';
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.' image_'.$image_position.'">';
if ($accord == 'yes') {
	$result .= '<div class="accord accord-active wrap flex">';
} else {
	$result .= '<div class="wrap flex">';
}


$result .= '<div class="text_image_text flex flex_column">';
if($title) {
	$result .= '<'.$title_tag.' class="title_text_image_block font_new_medium_2 font_bold color_dark_blue ">'.$title.'</'.$title_tag.'>';
}
if($text) {
	$result .= '<div class="text_image_text_content">'.$text.'</div>';
}
$result .= '</div>';
$result .= '<div class="text_image_image text_image_image_55">';
$language = get_locale();
if ($language != 'ru_RU') {
	if (str_contains($image_link,'land_company-min.png')) {
		$image_link = '/wp-content/themes/eto-razvod-1/img/land_company-min_en.png';
	}
	
	if (str_contains($image_link,'land_reviews-min.png')) {
		$image_link = '/wp-content/uploads/2022/02/land_reviews-min_en.png';
	}
	
	if (str_contains($image_link,'land_author-min.png')) {
		$image_link = '/wp-content/uploads/2022/02/land_author-min_en.png';
	}
}

$result .= '<img afsafasf src="'.$image_link.'" />';
$result .= '</div>';
$result .= '</div>';
$result .= '</div>';
echo $result;

?>