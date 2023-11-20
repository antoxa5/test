<?php
/**
 * List Reviews Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$id = 'er_list_promocodes-' . $block['id'];
if( !empty($block['anchor']) ) {
$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'er_list_promocodes';
if( !empty($block['className']) ) {
$className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
$className .= ' align' . $block['align'];
}
$result = '';
$style = get_field('style');
$title = get_field('title');
$title_tag = get_field('title_tag');
$description = get_field('description');
$post_type = 'promocodes';
$targeting = get_field('targeting');
$posts_per_page = get_field('count');
$pagination = get_field('pagination');
$sort = get_field('sort');
$sort_order = get_field('sort_order');
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.' background_light flex flex_column p_t_b_block">';
$result .= '<div class="wrap flex_column">';
if($title && $title != '') {
    $result .= '<'.$title_tag.' class="font_big font_bolder m_b_40 color_dark_blue listed3">'.$title.'</'.$title_tag.'>';
}
$args = array(
    'post_type' => 'promocodes',
	'post_status' => 'publish',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key' => 'promocodes_items',
            'value' => 0,
            'compare' => '>'
        )
    ),
);
$current_language = get_locale();
if($current_language != 'ru_RU' ) {
    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key' => 'enable_translations',
        'value' => $current_language,
        'compare' => 'LIKE'
    );
}
if ( $current_language == 'ru_RU' ) {
	// Включаем признак для фильтрации записей с включенным чекбоксом "Отключить обзор на русском языке" через posts_clauses
	$args['turn_off_on_ru_language'] = 1;
}

$query_reviews = new WP_Query($args);
if ( $query_reviews->have_posts() ) {
   /* $result .= '<div class="white_block list_promocodes_top flex">';
    $result .= '<ul class="list_promocodes_tabs flex font_smaller_2 font_uppercase color_medium_gray font_bolder">';
        $result .= '<li class="active color_dark_blue" data-type="all">'.__('Все','er_theme').'</li>';
        $result .= '<li data-type="promocodes">'.__('Промокоды','er_theme').'</li>';
        $result .= '<li data-type="coupons">'.__('Купоны','er_theme').'</li>';
    $result .= '</ul>';
    $result .= '<ul class="list_promocodes_styler flex">';
        $result .= '<li class="active grid" data-type="grid"></li>';
        $result .= '<li class="list" data-type="list"></li>';
    $result .= '</ul>';
    $result .= '<div class="list_promocodes_sorter font_small">';
        $result .= '<div class="comments_sorter_title color_dark_gray pointer dropdown flex">'.__('Отсортировать по','er_theme').'</div>';
    $result .= '</div>';
    $result .= '</div>';*/
    $result .= '<ul class="flex list_promocodes">';
    while ( $query_reviews->have_posts() ) {
        $query_reviews->the_post();
        global $post;
        $items = get_field('promocodes_items',$post->ID);
        $review_id = get_field('promocode_review',$post->ID);
        $company_name = get_field('company_name',$review_id);
        if($current_language != 'ru_RU') {
            $cyr = ['Љ', 'Њ', 'Џ', 'џ', 'ш', 'ђ', 'ч', 'ћ', 'ж', 'љ', 'њ', 'Ш', 'Ђ', 'Ч', 'Ћ', 'Ж','Ц','ц', 'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п', 'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я', 'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П', 'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
            ];
            $lat = ['Lj', 'Nj', 'Dž', 'dž', 'sh', 'đ', 'ch', 'ć', 'zh', 'lj', 'nj', 'Sh', 'Đ', 'Ch', 'Ć', 'Zh','C','c', 'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p', 'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya', 'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P', 'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
            ];
            $company_name = str_replace($cyr, $lat, $company_name);
        }
        $xxx = 0;
        foreach($items as $item) {
            $hour = 12;
            $today = strtotime($hour . ':00:00');
            $yesterday = strtotime('-1 day', $today);

            $date_end_m = strtotime($item['date_end']);
            if(($date_end_m < $yesterday && !empty($item['date_end']) && $item['date_end'] != 'None') || ($item['hide_promos'] == 'yes')) {

            } else {
                $xxx++;
                $promocode_single_array = array(
                    'count' => $item['visits'],
                    'item' => $item,
                    'post' => $post,
                    'xxx' => $xxx,
                    'review_id' => $review_id,
                    'company_name' => $company_name
                );
                $promocodes_array[] = $promocode_single_array;
                $iter = ++$iter;

            }
        }
        /*

        */
    }
    array_multisort(array_map(function($element) {
        return $element['count'];
    }, $promocodes_array), SORT_DESC, $promocodes_array);
    $promocodes_current_count = 0;
    foreach($promocodes_array as $promocode_single) {
        $promocodes_current_count++;
        if($promocodes_current_count > 30) {
            break;
        }
        $item = $promocode_single['item'];
        $post = $promocode_single['post'];
        $xxx = $promocode_single['xxx'];
        $review_id = $promocode_single['review_id'];
        $company_name = $promocode_single['company_name'];
        $result .= '<li class="white_block flex flex_column" id="list_promocodes_'.$post->ID.'_'.$xxx.'">';
        if($item['discount_size'] != '' & $item['discount_currency'] == '%') {
            $size = $item['discount_size'].$item['discount_currency'];
        } elseif($item['discount_size'] != '' & $item['discount_currency'] != '%') {
            $size = $item['discount_size'].' '.$item['discount_currency'];
        } else {
            $size = '';
        }
        if ($item['type'] == 'discount') {
            $item_type = __('Скидка на заказ','er_theme');
        } elseif($item['type'] == 'reg') {
            $item_type = __('Бонус при регистрации','er_theme');
        } elseif($item['type'] == 'demo') {
            $item_type = __('Бесплатный демо-счет','er_theme');
        } elseif($item['type'] == 'gift') {
            $item_type = __('Подарок','er_theme');
        } elseif($item['type'] == 'delivery') {
            $item_type = __('Бесплатная доставка','er_theme');
        }
        $result .='<div class="promocode_block_content flex flex_column">';
        $result .= review_logo($review_id);
        if($size != '') {
            $result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size">' . $size . '</div>';
        } else {
            $result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size_text">' . $item_type . '</div>';
        }
        $terms = get_term(get_field('promocode_taxonomy',$post->ID),'affiliate-tags')->slug;
        $terms_id = get_term(get_field('promocode_taxonomy',$post->ID),'affiliate-tags')->term_id;
        $tasks = get_posts(array(
            'post_type' => 'promocodes_cats',
            'meta_query' => array(
                array(
                    'key' => 'affiliate_tag', // name of custom field
                    'value' => $terms_id, // matches exaclty "123", not just 123. This prevents a match for "1234"
                    'compare' => '='
                )
            )
        ));
        if($current_language != 'ru_RU' ) {
            // $result .= get_the_permalink($tasks[0]->ID);
            $p_link = get_the_permalink($tasks[0]->ID).$post->post_name.'/';
            //$result .= $p_link;
            $result .= '<a class="promocode_item_title promocode_item_title_1 color_dark_blue link_no_underline font_bold do_not_translate_css_class" href="'.get_the_permalink($tasks[0]->ID).$post->post_name.'/" target="_blank" aria-label="'.$company_name.'">'.$company_name.'</a>';
        } else {
            $result .= '<a class="promocode_item_title promocode_item_title_1 color_dark_blue link_no_underline font_bold" href="'.get_the_permalink($tasks[0]->ID).$post->post_name.'/" target="_blank">'.$company_name.'</a>';
        }

        if($item['title'] != '') {
            $result .= '<div class="color_dark_gray font_small m_t_15">' . $item['title'] . '</div>';
        }
        $result .= '<div class="promocode_button_container">';
        if($item['text'] != '' && $item['text'] != 'Не нужен') {
            $result .= '<div class="promocode_text_container">';
            $result .= '<div class="promocode_single_text" id="promocode_text_'.$post->ID.'_1">'.$item['text'].'</div>';
            $result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$xxx.'/" target="_blank" rel="nofollow">'.__('Получить','er_theme').'</a>';
            $result .= '<div class="link_promocode_text_copy button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Скопировать','er_theme').'</div>';
            $result .= '</div>';
            $result .= '<div class="link_promocode_show_more_text button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Показать код','er_theme').'</div>';
        } else {
            $result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$xxx.'/" target="_blank" rel="nofollow">'.__('Получить','er_theme').'</a>';
        }
        $result .='</div>';
        $result .='</div>';
        if($item['description'] != '') {
            $result .= '<div class="promocode_full_description color_dark_gray font_small">'.$item['description'].'</div>';
        }
        $result .='<div class="promocode_block_footer flex">';
        if($item['description'] != '') {
            $result .= '<span class="font_smaller color_dark_gray inactive dropdown pointer flex link_promocode_show_more">'.__('Подробнее','er_theme').'</span>';
        }
        $count_used = 1;
        if($item['visits'] && $item['visits'] != '' && $item['visits'] != 0) {
            $count_used = $item['visits'];
        }
        $result .= '<span class="m_l_auto font_bold font_smaller color_dark_blue">'.$count_used.' '.counted_text($count_used,__('использует','er_theme'),__('используют','er_theme'),__('используют','er_theme')).'</span>';
        $result .='</div>';
        $result .= '</li>';
    }
    $result .= '</ul>';
}
wp_reset_postdata();


$result .= '</div>';
$result .= '</div>';
echo $result;
