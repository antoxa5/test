<?php
/**
 * FAQ List Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'er_block_faq-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'er_block_faq';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$items = get_field('questions');
$result = '';
if(!empty($items)) {
    //$total = count($items);
    $x = 0;
    $result .= '<ul id="'.esc_attr($id).'" class="'.esc_attr($className).'">';
    foreach ($items as $item) {
        $x++;
        if($item['question'] && $item['answer']) {
            $result .= '<li class="item_'.$x.'" id="'.esc_attr($id).'_'.$x.'">';
            $result .= '<div class="question">'.$item['question'].'</div>';
            $result .= '<div class="answer">'.$item['answer'].'</div>';
            $result .= '</li>';
        }
    }
    $result .= '</ul>';
}
echo $result;
?>