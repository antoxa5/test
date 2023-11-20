<?php
/**
 * CTA Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$id = 'block_steps-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$style = get_field('style');

$className = 'block_steps';
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
$steps = get_field('steps');
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.' p_t_b_block">';
	$result .= '<div class="wrap flex flex_column">';
		if($title) {
			$result .= '<'.$title_tag.' class="font_big line_big font_bold color_dark_blue  ">'.$title.'</'.$title_tag.'>';
		}
		if($description) {
			$result .= '<'.$description_tag.' class="block_description line_big color_dark_blue   ">'.$description.'</'.$description_tag.'>';
		}
		if(!empty($steps)) {
		$result .= '<ul class="steps flex">';
			$x = 0;
			foreach($steps as $step) {
				$x++;
				$result .='<li>';
					$result .= '<div class="step_number">'.$x.'</div>';
					$result .= '<div class="step_text">'.$step['text'].'</div>';
				$result .='</li>';
			}
		$result .= '</ul>';
		}
	$result .= '</div>';
$result .= '</div>';
echo $result;