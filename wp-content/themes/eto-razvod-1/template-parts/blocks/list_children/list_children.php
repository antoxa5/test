<?php
/**
 * List Categories Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$id = 'er_block_list_children-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'er_block_list_children';
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
$style = get_field('style');
$title = get_field('title');
$description = get_field('description');
$childrens = get_children( [
	'post_parent' => my_acf_post_id(),
	'post_type'   => 'page', 
	'numberposts' => -1,
	'post_status' => 'publish',
	'orderby' => 'title',
	'order' =>'ASC'
] );

//print_r($childrens);
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.'">';
if($title) {
    $result .= '<'.$title_tag.' class="block_title">'.$title.'</'.$title_tag.'>';
}
if($description) {
    $result .= '<'.$description_tag.' class="block_description">'.$description.'</'.$description_tag.'>';
}
if($childrens && !empty($childrens)) {
	$result .= '<ul>';
	foreach($childrens as $children) {
		if(get_field('child_icon',$children->ID) && get_field('child_icon',$children->ID) != '') {
			$icon = get_field('child_icon',$children->ID);
		} else {
			$icon = '<i class="fas fa-hashtag"></i>';
		}
		$result .= '<li><a href="'.get_the_permalink($children->ID).'">'.$icon.'<span>'.$children->post_title.'</span></a></li>';
	}
	$result .= '<ul>';
}
    $result .= '</div>';

echo $result;




?>