<?php
/**
 * Search Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$id = 'er_block_search-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'er_block_search';
$result = '';
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).'">';
    $result .= '<div class="block_content">';
        $result .= '<div class="search_form_container">';
        $result .= '<form method="get" id="searchform" action="'.get_bloginfo("url").'">';
        $result .= '<input class="block_input_search" type="text" placeholder="Введите название компании или URL адрес" value="" name="s"  autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false"/>';
        $result .= '<button class="block_search_button" type="submit"></button>';
        $result .= '</form>';
        $result .= '</div>';
    $result .= '</div>';
$result .= '</div>';
echo $result;
?>