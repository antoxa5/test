<?php
/**
 * Features Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'er_block_features-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'er_block_features';
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
$style = get_field('style');
$items = get_field('features_list');
$buttons = get_field('buttons');
$title = get_field('title');
$description = get_field('description');
$result = '';
if(!empty($items)) {
    //$total = count($items);
    $x = 0;
    $result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.'">';
    if($title) {
        $result .= '<'.$title_tag.' class="block_title">'.$title.'</'.$title_tag.'>';
    }
    if($description) {
        $result .= '<'.$description_tag.' class="block_description">'.$description.'</'.$description_tag.'>';
    }
    $result .= '<ul>';
    foreach ($items as $item) {
        $x++;
        $result .= '<li class="item_'.$x.'" id="'.esc_attr($id).'_'.$x.'">';
        if($item['icon']) {
            $result .= '<div class="icon"><i class="' . $item['icon'] . '"></i></div>';
        }
        if($item['title'] || $item['title_numeric']) {
			if(!$item['title_automatic']) {
            	$result .= '<div class="title">' . $item['title'] . '</div>';
			
			} else {
				$title_numeric_get = $item['title_numeric'];
				if($title_numeric_get == 'count_posts') {
					$count_page = wp_count_posts('page')->publish;
					$count_p = wp_count_posts('post')->publish;
					$count_pages = $count_page + $count_p;
					if ( substr( $count_pages, - 1 ) == 1 && substr( $count_pages, - 2 ) != 11) {
                        $count_pages_text = __('статья и запись', 'er_theme');
                    } elseif ( substr( $count_pages, - 1 ) > 1 && substr( $count_pages, - 1 ) < 5 && substr( $count_pages, - 2 ) > 21 ) { 
                        $count_pages_text = __( 'статьи и записи', 'er_theme' );
                    } else {
                        $count_pages_text = __( 'статей и записей', 'er_theme' );
                    }
					$title_numeric = number_format($count_pages, 0, ',', ' ').' '.$count_pages_text;
				} elseif($title_numeric_get == 'count_comments') {
					$comments_count = wp_count_comments()->approved;
					if ( substr( $comments_count, - 1 ) == 1 && substr( $comments_count, - 2 ) != 11) {
                        $count_comment_text = __('отзыв', 'er_theme');
                    } elseif ( substr( $comments_count, - 1 ) > 1 && substr( $comments_count, - 1 ) < 5 && substr( $comments_count, - 2 ) > 21 ) {
                        $count_comment_text = __( 'отзыва', 'er_theme' );
                    } else {
                        $count_comment_text = __( 'отзывов', 'er_theme' );
                    }
					$title_numeric = number_format($comments_count, 0, ',', ' ').' '.$count_comment_text;
				} elseif($title_numeric_get == 'count_reviews') {
					$count_posts = wp_count_posts('casino')->publish;
					if ( substr( $count_posts, - 1 ) == 1 && substr( $count_posts, - 2 ) != 11) {
                        $count_posts_text = __('обзор компаний', 'er_theme');
                    } elseif ( substr( $count_posts, - 1 ) > 1 && substr( $count_posts, - 1 ) < 5 && substr( $count_posts, - 2 ) > 21 ) {
                        $count_posts_text = __( 'обзора компаний', 'er_theme' );
                    } else {
                        $count_posts_text = __( 'обзоров компаний', 'er_theme' );
                    }
					$title_numeric = number_format($count_posts, 0, ',', ' ').' '.$count_posts_text;
				} 
				$result .= '<div class="title">' . $title_numeric . '</div>';
			}
        }
        if($item['text']) {
			if($item['title_automatic'] && $item['title_numeric'] == 'count_comments') {
				$count_users = count_users()['total_users'];
					if ( substr( $count_users, - 1 ) == 1 && substr( $count_users, - 2 ) != 11) {
						// $count_users_text_1 = __('доверяет ', 'er_theme');
                        $count_users_text = __('пользователь доверяет нашему проекту и размещает на нем свои отзывы. Легко быть в курсе, легко делиться тем, что точно знаешь.', 'er_theme');
                    } elseif ( substr( $count_users, - 1 ) > 1 && substr( $count_users, - 1 ) < 5 && substr( $count_users, - 2 ) > 21 ) {
						//$count_users_text_1 = __('доверяют ', 'er_theme');
                        $count_users_text = __( 'пользователя доверяют нашему проекту и размещают на нем свои отзывы. Легко быть в курсе, легко делиться тем, что точно знаешь.', 'er_theme' );
                    } else {
						//$count_users_text_1 = __('доверяют ', 'er_theme');
                        $count_users_text = __( 'пользователей доверяют нашему проекту и размещают на нем свои отзывы. Легко быть в курсе, легко делиться тем, что точно знаешь.', 'er_theme' );
                    }
					$count_users_result = number_format($count_users, 0, ',', ' ').' '.$count_users_text;
				$result .= '<div class="text"><p>'.__('С 2015 года ','er_theme') .$count_users_result.'</p></div>';
			} else {
				
				$count_users_result = '';
				$result .= '<div class="text">' .$count_users_result.$item['text']. '</div>';
			}
            
        }
        if(!empty($item['buttons'])) {
            $result .= '<div class="buttons">';
                foreach ($item['buttons'] as $it) {
                    if($it['link'] && $it['text']) {
                        $result .= '<a href="'.$it['link'].'">'.$it['text'].'</a>';
                    }
                }
            $result .= '</div>';
        }
        $result .= '</li>';
    }
    $result .= '</ul></div>';
    if(!empty($buttons)) {
        $result .= '<div class="buttons general_buttons">';
        foreach ($buttons as $it) {
            if($it['link'] && $it['text']) {
                $result .= '<a href="'.$it['link'].'">'.$it['text'].'</a>';
            }
        }
        $result .= '</div>';
    }
}
echo $result;
?>