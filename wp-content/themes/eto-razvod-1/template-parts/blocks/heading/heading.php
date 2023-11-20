<?php
/**
 * CTA Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$id = 'block_heading-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$style = get_field('style');

$className = 'block_heading';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
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
$description = get_field('description');
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.'">';
	$result .= '<div class="wrap flex flex_column">';
		if($title) {
			$result .= '<'.$title_tag.' class="font_bigger line_big font_bold">'.$title.'</'.$title_tag.'>';
		}
		if($description) {
			$result .= '<'.$description_tag.' class="line_big heading_service_description">'.$description.'</'.$description_tag.'>';
		}
		$result .= '<div class="abuse_heading_plus"></div>';
	$result .= '</div>';
$result .= '</div>';
echo $result;