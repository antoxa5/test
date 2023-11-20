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
$className = 'block_text_image text_features';
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
$numbers = get_field('numbers');
$image_position = get_field('image_position');
$image_link = wp_get_attachment_image_url( $image, 'large' );
$result = '';
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.' image_'.$image_position.'">';
	$result .= '<div class="wrap flex">';
if($title) {
				$result .= '<'.$title_tag.' class="font_new_medium_2 font_bold color_dark_blue features_title ">'.$title.'</'.$title_tag.'>';
			}
		$result .= '<div class="text_image_text flex flex_column">';
			if(!empty($numbers)) {
				$result .= '<ul class="features_numbers flex">';
				foreach($numbers as $number) {
					$result .= '<li class="'.$number['class'].'">';
					$result .= '<span class="fea_number_title">'.$number['title'].'</span>';
					$result .= '<span class="fea_number_text">'.$number['text'].'</span>';
					$result .= '</li>';
				}
				$result .= '</ul>';
			}




			if($title) {
				$result .= '<div class="text_image_text_content">'.$text.'</div>';
			}
		$result .= '</div>';
		$result .= '<div class="asfasfasf text_image_image_77">';
		
			$result .= '<img asfasfaf src="'.$image_link.'" />';
		$result .= '</div>';
	$result .= '</div>';
$result .= '</div>';
echo $result;

?>