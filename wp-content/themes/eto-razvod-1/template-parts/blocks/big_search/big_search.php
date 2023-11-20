
<?php

$id = 'er_block_comments-' . $block['id'];

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
// Create class attribute allowing for custom "className" and "align" values.
$className = 'er_block_comments';
if( !empty($block['className']) ) {
	$className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
	$className .= ' align' . $block['align'];
}
$title = get_field('title');
$style = get_field('style');
$tags = get_field('tags');

$search_type = get_field('search_type');
$current_language = get_locale();
if($current_language != 'ru_RU' && $search_type == 'promocodes_big') {
    $tags = array(10,17,11,16);
}
$ids = get_field('ids');
if($current_language != 'ru_RU' && $search_type == 'companies_big') {
    $ids = array(7175,14405,5316);
    $tags = array(10,17,11,16,20291,3417);
}
$search_example = get_field('search_example');
$over_button_text = get_field('over_button_text');
if($search_example && $search_example != '') {
	$search_example_text = get_field('company_name',$search_example);
	if(!$search_example_text || $search_example_text == '') {
		$search_example_text = __('Финам','er_theme');
        if($current_language != 'ru_RU') {
            $search_example_text = 'Binance';
        }
	}
} else {
	$search_example_text = __('Финам','er_theme');
    if($current_language != 'ru_RU') {
        $search_example_text = 'Binance';
    }
}
if($search_type == '' || !$search_type) {
	$search_type = 'companies_big';
	$post_type = 'casino';
} elseif($search_type == 'promocodes_big') {
	$post_type = 'promocodes';
}
$result = '';

if($style == 'land_light') {
	$result .= '<div id="'.esc_attr($id).'" class="flex flex_column padding_big_block search_big s2 '.$search_type.' '.$style.'" data-type="'.$search_type.'">';
	if($title && $title != '') {

	}
	$result .= '<div class="wrap flex_column">';
	$result .= '<div class="font_new_medium_2 font_bold m_b_40 color_dark_blue text_centered">'.$title.'</div>';
	$result .= '<div class="search_box flex">';
	$result .= '<div class="form_container">';
	$result .= '<form class="radius_small flex not_typing">';
	$result .= '<ul class="selector font_bold color_dark_blue inactive">';
	$result .= '<li class="placeholder_text"><span class="example_placeholder desktop">'.__('Например','er_theme').' </span><span class="example_placeholder mobile">'.__('Например','er_theme').' </span><span class="color_dark_blue search_example_text pointer">'.$search_example_text.'</span></li>';
	$result .= '</ul>';
	$result .= '<input type="text" name="s" class="placeholder_gray" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" aria-label="'.__('Искать', 'er_theme').'">';
	$result .= '<div class="big_search_icon_clear"></div>';
	$result .= '<div class="big_search_icon"></div>';

	$result .= '</form>';
	if(!empty($tags)) {
		$result .= '<ul class="tags_light flex color_dark_blue font_small">';
		$tag_i = 0;
		$first_active = 0;
		foreach($tags as $tag) {
			$tag_i++;

			if($tag_i == 1) {
				$active = ' class="active"';
				$first_active = $tag;
			} else {
				$active = '';
			}
			$tag_human_title = get_field('tag_human_title','term_'.$tag);
			$result .= '<li'.$active.' data-term-id="'.$tag.'" data-post-type="'.$post_type.'"><span>'.$tag_human_title.'</span></li>';
			

		}
		$result .= '</ul>';
	}
	$result .= '</div>';
	$result .= '<div class="big_search_results">';
	if(!empty($ids)) {
		$result .= '<ul class="results_content">';
		foreach($ids as $post_id) {
			if(function_exists('get_rating_fields_group')) {
				$rating_fields_group = get_rating_fields_group($post_id);
			} else {
				$rating_fields_group = 0;
			}
			$comments_count = get_comments_count( $post_id, get_comment_rating_fields( $rating_fields_group, 'name' ) );
			$result .= '<li class="white_block flex flex_column flex_column_7">';
			$company_name = get_field('company_name',$post_id);
			$result .='<div class="company_block_header flex">';
			$result .= '<div class="compare_container compare_container_s_r" id="s_r_compare_container_'.$post_id.'" data-post-id="'.$post_id.'">'.compare_icon($post_id).'</div>';
			if (function_exists('review_logo')) {
				$result .= review_logo($post_id);
			}
			$result .= '<div class="flex flex_column">';
			$result .= '<a class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="'.get_the_permalink($post_id).'">'.$company_name.'</a>';
			$result .= '<div class="font_small"><span class="color_dark_gray count_reviews">'.__('Отзывы','er_theme').'</span><span class="color_dark_blue">'.$comments_count['count'].'</span></div>';
			$terms = get_the_terms($post_id,'affiliate-tags');
			if(!empty($terms)) {
				$t_x = 0;
				$result .= '<ul class="company_card_tags flex">';
				foreach ($terms as $term) {
					$t_x++;
					if($t_x <= 1) {
						$result .= '<li class="color_dark_blue">' . get_field('tag_human_title', 'term_' . $term->term_id) . '</li>';
					}
				}
				$result .= '</ul>';
			}
			$result .='</div>';
			$result .='</div>';
			$result .='<div class="company_block_footer flex">';
			$result .= get_post_stars($rating_fields_group,$post_id);
			$result .= review_top_rating($post_id);
			$result .='</div>';
			$result .= '</li>';
		}
		$result .= '</ul>';

		$result .= '<span class="tabs_mobile_mover big_search_results_tabs">';
		for ($i = 1;$i <= count($ids);$i++) {
			if ($i == 1) {
				$result .= '<span class="tabs_mobile_mover__item tabs_mobile_mover__item_active" data-n="'.$i.'"></span>';
			} else {
				$result .= '<span class="tabs_mobile_mover__item" data-n="'.$i.'"></span>';
			}
		}
		$result .= '</span>';
	}
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
} else {




	$result .= '<div id="'.esc_attr($id).'" class="flex flex_column padding_big_block search_big s1 '.$search_type.' '.$style.'" data-type="'.$search_type.'">';
	$result .= '<div class="wrap flex_column">';
	if($title && $title != '') {
		$result .= '<div class="font_big font_bolder m_b_40 color_dark_blue listed1">'.$title.'</div>';
	}
	$result .= '<div class="search_box">';
	$result .= '<div class="form_container">';
	$result .= '<form class="radius_small flex not_typing">';
	$result .= '<ul class="selector font_bold color_dark_blue inactive">';
	$current_language = get_locale();
	if ($current_language == 'en_US') {
		$textlong = 'Select a category or enter a name, for example';
		$textsmall = 'For example';
		$textcal = '';
	} elseif ($current_language == 'fr_FR') {
		$textlong = 'Sélectionnez une catégorie ou entrez un nom, par ex.';
		$textsmall = 'Par exemple';
		$textcal = 'Toutes les catégories';
	} elseif ($current_language == 'es_ES') {
		$textlong = 'Seleccione una categoría o introduzca un nombre, por ejemplo';
		$textsmall = 'Por ejemplo';
		$textcal = 'Todas las categorías';
	} elseif ($current_language == 'de_DE') {
		$textlong = 'Geben Sie einen Namen ein, zum Beispiel';
		$textsmall = 'Zum Beispiel';
		$textcal = 'Alle Kategorien';
	} elseif ($current_language == 'ru_RU') {
		$textlong = 'Выберите категорию или введите название, например';
		$textsmall = 'Например';
		$textcal = 'Все категории';
	}
	$result .= '<li class="placeholder_text"><span class="example_placeholder desktop">'.$textlong.' </span><span class="example_placeholder mobile">'.$textsmall.' </span><span class="color_dark_blue search_example_text pointer">'.$search_example_text.'</span></li>';
	$result .= '<li class="active link_dropdown pointer" data-category="all">'.$textcal.'</li>';
	$result .= '</ul>';
	$result .= '<input type="text" name="s" class="placeholder_gray" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" aria-label="'.__('Искать', 'er_theme').'">';
	$result .= '<div class="big_search_icon_clear"></div>';
	$result .= '<div class="big_search_icon"></div>';

	$result .= '</form>';
	$result .= '</div>';
	$result .= '<div class="search_settings flex m_t_20">';
	/*if($search_type == 'companies_big' && $style != 'default_plus') {
		$result .= '<div class="link_search_more icon_bg icon_filter pointer border_circle flex m_r_50 color_dark_blue"><span>' . __('Детальные настройки', 'er_theme') . '</span></div>';
	}*/


	if(!empty($tags)) {
		$result .= '<span class="color_medium_gray tags_title ">'.__('Популярно:','er_theme').'</span>';
		$result .= '<ul class="tags flex color_blue">';
		$tag_i = 0;
		$first_active = 0;
		foreach($tags as $tag) {
			$tag_i++;

			if($tag_i == 1) {
				$active = ' class="active"';
				$first_active = $tag;
			} else {
				$active = '';
			}
			
			$tag_human_title = get_field('tag_human_title','term_'.$tag);
			$result .= '<li'.$active.' data-term-id="'.$tag.'" data-post-type="'.$post_type.'"><span>'.$tag_human_title.'</span></li>';
			

		}
		$result .= '</ul>';
	}
	$result .= '</div>';
	$result .= '</div>';
	$result .= '<div class="big_search_results">';
	if(!empty($ids) && $style == 'default_plus') {
		$result .= '<ul class="results_content">';
		foreach($ids as $post_id) {
			if(function_exists('get_rating_fields_group')) {
				$rating_fields_group = get_rating_fields_group($post_id);
			} else {
				$rating_fields_group = 0;
			}
			$comments_count = get_comments_count( $post_id, get_comment_rating_fields( $rating_fields_group, 'name' ) );
			$result .= '<li class="white_block flex flex_column flex_column_9">';
			if($over_button_text != '' && $style == 'default_plus') {
				$result .= '<div class="over_button_text">';
				$result .= '<div class="button button_green font_small font_bold pointer">'.$over_button_text.'</div>';
				$result .= '</div>';
			}
			$company_name = get_field('company_name',$post_id);
			$result .='<div class="company_block_header flex">';
			$result .= '<div class="compare_container compare_container_s_r" id="s_r_compare_container_'.$post_id.'" data-post-id="'.$post_id.'">'.compare_icon($post_id).'</div>';
			if (function_exists('review_logo')) {
				$result .= review_logo($post_id);
			}
			$result .= '<div class="flex flex_column">';
			$result .= '<a class="font_new_medium font_bold color_dark_blue company_name link_no_underline" href="'.get_the_permalink($post_id).'">'.$company_name.'</a>';
			$result .= '<div class="font_small"><span class="color_dark_gray count_reviews">'.__('Отзывы','er_theme').'</span><span class="color_dark_blue">'.$comments_count['count'].'</span></div>';
			$terms = get_the_terms($post_id,'affiliate-tags');
			if(!empty($terms)) {
				$t_x = 0;
				$result .= '<ul class="company_card_tags flex">';
				foreach ($terms as $term) {
					$t_x++;
					if($t_x <= 3) {
						$result .= '<li class="color_dark_blue">' . get_field('tag_human_title', 'term_' . $term->term_id) . '</li>';
					}
				}
				$result .= '</ul>';
			}
			$result .='</div>';
			$result .='</div>';
			$result .='<div class="company_block_footer flex">';
			$result .= get_post_stars($rating_fields_group,$post_id);
			$result .= review_top_rating($post_id);
			$result .='</div>';
			$result .= '</li>';
		}
		$result .= '</ul>';
	}
	$result .= '</div>';
	$result .= '</div>';
	$result .= '</div>';
}
echo $result;

?>