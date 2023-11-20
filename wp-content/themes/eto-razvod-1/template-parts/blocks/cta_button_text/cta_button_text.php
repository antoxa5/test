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
$id = 'er_block_cta_button_text-' . $block['id'];
if( !empty($block['anchor']) ) {
	$id = $block['anchor'];
}
if(get_field('title_tag')) {
	$title_tag = get_field('title_tag');
} else {
	$title_tag = 'div';
}
if(get_field('description_tag')) {
	$description_tag = get_field('description_tag');
} else {
	$description_tag = 'div';
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'block_cta_button_text';
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
$result = '';
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.' background_light flex flex_column">';
$result .= '<div class="wrap">';
$result .= '<div class="white_block flex cta_button_text p_equal_big">';
if($style == 'style2') {
	$result .= '<a href="'.$button_link.'" class="button button_green pointer button_cta_text link_no_underline">'.$button_text.'</a>';
} else {
	$result .= '<a href="'.$button_link.'" class="button button_violet pointer button_padding_big font_small font_bold link_no_underline">'.$button_text.'</a>';
}
if($style == 'style2') {
	$result .= '<div class="cta_button_text_text line_big">';
	if($title && $title != '') {
		$result .= '<div class="cta_button_text_description color_dark_blue font_new_medium_2 font_bold m_b_10">'.$title.'</div>';
	}
	$result .= '<div class="cta_button_text_description color_dark_gray">'.$text.'</div></div>';
} else {
	$result .= '<div class="color_darker_gray cta_button_text_text line_big">'.$text.'</div>';
}
$result .= '</div>';
$result .= '</div>';
$result .= '</div>';
echo $result;

?>