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
$id = 'er_block_list_posts-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'er_block_list_posts';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
$query_type = get_field('query_type');
$tags = get_field('tags');
$categories = get_field('categories');
$post_ids = get_field('post_ids');
$sort = get_field('sort');
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
$sort_order = get_field('sort_order');
$count = get_field('count');
$style = get_field('style');
$args = array(
    'posts_per_page' => $count,
    'post_type' => array('post','page'),
    'order' => $sort_order
);
print_r($post_ids);
if($query_type == 'post_ids') {
    if(!empty($post_ids)) {

        $args['post__in'] = $post_ids;
        $args['orderby'] = 'post__in';
    }
} elseif($query_type == 'tags') {
    if(!empty($tags)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'affiliate-tags',
                'field' => 'id',
                'terms' => $tags
            )
        );
    }
} elseif($query_type == 'categories') {
    if(!empty($categories)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field' => 'id',
                'terms' => $categories
            )
        );
    }
}
$posts = get_posts( $args );
$result = '';
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.'">';
if($title) {
    $result .= '<'.$title_tag.' class="block_title">'.$title.'</'.$title_tag.'>';
}
if(!empty($posts)) {
    $result .= '<ul>';
    foreach ($posts as $post) {
        $result .= '<li>';
        if($style == 'style1') {
            $description = get_the_excerpt($post->ID);
            $result .= '<a class="post_card_left" href="'.get_the_permalink($post->ID).'" target="_blank" style="background-image: url('.get_the_post_thumbnail_url( $post->ID, 'large' ).')">';
            $result .= '</a>';
            $result .= '<div class="post_card_right">';
            $result .= '<a class="post_card_title" href="'.get_the_permalink($post->ID).'" target="_blank">' . $post->post_title . '</a>';
            if($description) {
                $result .= '<div class="post_card_description">'.$description.'</div>';
            }
            $result .= '<div class="article_meta">';
            $result .= '<span class="article_date">'.get_the_date('d F Y',$p->ID).'</span>';
            $result .= '</div>';
            $result .= '</div>';
        } elseif($style == 'style2') {
            $description = get_the_excerpt($post->ID);
            $result .= '<a class="post_card_img" href="'.get_the_permalink($post->ID).'" target="_blank" style="background-image: url('.get_the_post_thumbnail_url( $post->ID, 'large' ).')">';
            $result .= '</a>';
            $result .= '<div class="post_card_content">';
            $result .= '<a class="post_card_title" href="'.get_the_permalink($post->ID).'" target="_blank">' . $post->post_title . '</a>';
            if($description) {
                $result .= '<div class="post_card_description">'.$description.'</div>';
            }
            $result .= '</div>';
            $result .= '<div class="article_meta">';
            $result .= '<span class="article_date">'.get_the_date('d F Y',$p->ID).'</span>';
            $result .= '</div>';
        }
        $result .= '</li>';
    }
    $result .= '</ul>';
}
$result .= '</div>';
echo $result;
?>