<?php
/**
 * CTA Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$id = 'er_block_cta-' . $block['id'];
if( !empty($block['anchor']) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$style = get_field('style');

$text = get_field('text');
$button_text = get_field('button_text');
$className = 'er_block_cta';
if( !empty($block['className']) ) {
	$className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
	$className .= ' align' . $block['align'];
}
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.' p_t_b_block flex flex_column">';
if($style == 'style2') {

	if(get_field('title_tag_2')) {
		$title_tag_2 = get_field('title_tag_2');
	} else {
		$title_tag_2 = 'div';
	}
	if(get_field('description_tag_2')) {
		$description_tag_2 = get_field('description_tag_2');
	} else {
		$description_tag_2 = 'div';
	}
	$title_2 = get_field('title_2');
	$description_2 = get_field('description_2');
	if($title_2) {
		$result .= '<'.$title_tag_2.' class="font_new_medium_2 line_big font_bold color_dark_blue  text_centered">'.$title_2.'</'.$title_tag_2.'>';
	}
	if($description_2) {
		$result .= '<'.$description_tag_2.' class="block_description line_big color_dark_blue  text_centered m_b_20">'.$description_2.'</'.$description_tag_2.'>';
	}
	$result .= '<div class="history_wrapper">';
	$result .= '<div class="reg_container">';
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
$title = get_field('title');
$title_authorized = get_field('titile_authorized');
if(is_user_logged_in() && $title_authorized && $title_authorized != '') {
	$title = $title_authorized;
}
$description = get_field('description');
$button_classes = get_field('button_classes');
$button_classes_authorized = get_field('button_classes_authorized');
if(is_user_logged_in() && $button_classes_authorized && $button_classes_authorized != '') {
	$button_classes = $button_classes_authorized;
}
if($title) {
	$result .= '<'.$title_tag.' class="font_new_medium font_bold color_dark_blue  text_centered">'.$title.'</'.$title_tag.'>';
}
if($description) {
	$result .= '<'.$description_tag.' class="block_description line_big color_dark_blue  text_centered m_b_20">'.$description.'</'.$description_tag.'>';
}

if (!$button_text || $button_text == '') {
	$button_text = __('Зарегистрироваться','er_theme');
}
$button_text_authorized = get_field('button_text_authorized');
if(is_user_logged_in() && $button_text_authorized && $button_text_authorized != '') {
	$button_text = $button_text_authorized;
}
$result .= '<div class=" button  '.$button_classes.' button_centered pointer">'.$button_text.'</div>';

if($style == 'style2') {
	$result .= '</div>';
	$result .= '</div>';
}
$result .= '</div>';

echo $result;