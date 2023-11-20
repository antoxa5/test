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
$id = 'er_block_text_image_team-' . $block['id'];
if( !empty($block['anchor']) ) {
	$id = $block['anchor'];
}
if(get_field('title_tag')) {
	$title_tag = get_field('title_tag');
} else {
	$title_tag = 'div';
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'block_text_image_team';
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
$position = get_field('position');
$image = get_field('image');
$image_position = get_field('image_position');
$image_link = wp_get_attachment_image_url( $image, 'large' );
$result = '';
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.' image_'.$image_position.'">';
$result .= '<div class="wrap flex">';
$result .= '<div class="text_image_text flex flex_column">';
if($title) {
	$result .= '<div class="font_new_medium_2 font_bold color_violet">'.$title.'</div>';
}
if($position) {
    $result .= '<div class="font_bold color_dark_blue m_t_15">'.$position.'</div>';
}
if($text) {
	$result .= '<div class="text_image_text_content">'.$text.'</div>';
}
$result .= '</div>';
$result .= '<div class="text_image_image text_image_image_66">';
$result .= '<img src="'.$image_link.'" />';
$result .= '</div>';
$result .= '</div>';
$result .= '</div>';
echo $result;

?>