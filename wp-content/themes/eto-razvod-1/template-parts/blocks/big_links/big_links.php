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
$id = 'er_block_big_links-' . $block['id'];
if( !empty($block['anchor']) ) {
	$id = $block['anchor'];
}
if(get_field('title_tag')) {
	$title_tag = get_field('title_tag');
} else {
	$title_tag = 'div';
}
//wp_enqueue_script( 'progressbar', get_template_directory_uri() . '/js/progressbar.js', array('jquery') );
if(get_field('description_tag')) {
	$description_tag = get_field('description_tag');
} else {
	$description_tag = 'div';
}
// Create class attribute allowing for custom "className" and "align" values.
$className = 'block_big_links';
if( !empty($block['className']) ) {
	$className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
	$className .= ' align' . $block['align'];
}
$style = get_field('style');
$links = get_field('links');
$links_2 = get_field('links_2');
$title = get_field('title');
$result = '';
$result .= '<div id="'.esc_attr($id).'" class="'.esc_attr($className).' '.$style.' background_light flex flex_column p_t_b_block">';
if($style == 'main_services') {
	$result .= '<div class="main_services_header">';
	$result .= '<div class="wrap">';
	if($title && $title != '') {
		$result .= '<'.$title_tag.' class="font_medium_new font_bold color_dark_blue features_title ">'.$title.'</'.$title_tag.'><div class="review_icon_share pointer m_l_15" data-type="share_post" data-id=""></div>';
	}
	$result .= '</div>';
	$result .= '</div>';
	if(count($links) > 2) {
	$result .= '<div class="services_header">';
		$result .= '<div class="wrap">';
			$result .= '<div class="tabs_hidden_tabs">';
			$result .= '<span class="active" data-container="first_tabs">'.__('Я пользователь','er_theme').'</span>';
			$result .= '<span class="inactive" data-container="second_tabs">'.__('Я представитель компании','er_theme').'</span>';
			$result .= '</div>';
		$result .= '</div>';
	}
	$result .= '</div>';
}
$result .= '<div class="wrap flex_column">';
if($style == 'main_services') {
	$result .= '<div class="services_main_image"></div>';
}
if(!empty($links)) {
	if($title && $title != '' && $style != 'main_services') {
		$result .= '<'.$title_tag.' class="font_new_medium_2 font_bold color_dark_blue features_title ">'.$title.'</'.$title_tag.'>';
	}
	if($style != 'tabs_hidden' && $style != 'main_services') {
		if(count($links) > 2) {
			$result .= '<div class="flex big_links_icons">';
			$result .= '<span class="big_link_arrow big_links_icon_left" data-link="left"></span>';
			$result .= '<a class="big_links_icon_center" href="'.get_bloginfo('url').'/services/" aria-label="'.__('Сервисы','er_theme').'"></a>';
			$result .= '<span class="big_link_arrow big_links_icon_right" data-link="right"></span>';
			$result .= '</div>';
		}
	}
	if($style == 'tabs_hidden') {
		$result .= '<div class="tabs_hidden_tabs">';
		$result .= '<span class="active" data-container="first_tabs">'.__('Для пользователей','er_theme').'</span>';
		$result .= '<span class="inactive" data-container="second_tabs">'.__('Для компаний','er_theme').'</span>';
		$result .= '</div>';
	}
	$result .= '<ul class="flex first_tabs active">';

	foreach($links as $link) {
		if($link['label_soon']) {
			$soon = 'soon';
		} else {
			$soon = '';
		}
		$result .= '<li class="white_block flex flex_column '.$soon.'">';
		$result .= '<h2 class="font_new_medium color_dark_blue m_b_10 font_bold link_no_underline" >'.$link['title'].'</h2>';
		$result .= '<a class="font_smaller color_dark_gray link_no_underline link_service_more link_service_more_1 '.$link['additional_class'].''.$link['additional_class'].'" href="'.$link['link_more'].'">'.$link['title_more'].'</a>';
		$result .= '</li>';
	}
	$result .= '</ul>';
	$result .= '<span class="tabs_mobile_mover tabs_mobile_mover_big_links">';
	for ($i = 1;$i <= count($links);$i++) {
		if ($i == 1) {
			$result .= '<span class="tabs_mobile_mover__item tabs_mobile_mover__item_active" data-n="'.$i.'"></span>';
		} else {
			$result .= '<span class="tabs_mobile_mover__item" data-n="'.$i.'"></span>';
		}
	}
	$result .= '</span>';

	if($links_2) {
		$result .= '<ul class="flex second_tabs inactive">';
		foreach($links_2 as $link) {
			if($link['label_soon']) {
				$soon = 'soon';
			} else {
				$soon = '';
			}
			$result .= '<li class="white_block flex flex_column '.$soon.'">';
			if ($link['title'] == 'Публикация обзора') {
				$result .= '<a class="font_new_medium color_dark_blue m_b_10 font_bold link_no_underline '.$link['additional_class'].'" href="'.$link['link'].'">'.$link['title'].'</a>';
			} else {
				if (is_user_logged_in()) {
					$result .= '<a class="font_new_medium color_dark_blue m_b_10 font_bold link_no_underline '.$link['additional_class'].'" href="'.$link['link'].'">'.$link['title'].'</a>';
				} else {
					$result .= '<span class="font_new_medium color_dark_blue m_b_10 font_bold link_no_underline pointer '.$link['additional_class'].'">'.$link['title'].'</span>';
				}
			}

			if ($link['title'] == 'Публикация обзора') {
				$result .= '<a class="font_smaller color_dark_gray link_no_underline link_service_more link_service_more_2 '.$link['additional_class_add'].'" href="'.$link['link_more'].'">'.$link['title_more'].'</a>';
			} else {
				if (is_user_logged_in()) {
					$result .= '<a class="font_smaller color_dark_gray link_no_underline link_service_more link_service_more_3 '.$link['additional_class_add'].'" href="'.$link['link_more'].'">'.__('Подробнее','er_theme').'</a>';
				} else {
					$result .= '<span class="font_smaller color_dark_gray link_no_underline link_service_more link_service_more_4 pointer '.$link['additional_class_add'].'">'.__('Подробнее','er_theme').'</span>';
				}
			}

			//$result .= '<a class="font_smaller color_dark_gray link_no_underline link_service_more" href="'.$link['link_more'].'">'.$link['title_more'].'</a>';
			$result .= '</li>';
		}
		$result .= '</ul>';
	}
}
$result .= '</div>';
$result .= '</div>';
echo $result;

?>