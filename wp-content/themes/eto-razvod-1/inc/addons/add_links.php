<?php

if(!function_exists('show_add_links')) {
    function show_add_links($post_id) {
        $result = '';
        $post_type = get_post_type($post_id);
		if($post_type == 'addpages') {
			$postID = get_field('addpage_review',$post_id);
		} else {
			$postID = $post_id;
		}
        $add_pages = array();
        
        $add_pages_query = new WP_Query( array(
            'post_type' => 'addpages',
            'meta_query' => array(
                array(
                    'key' => 'addpage_review', // name of custom field
                    'value' => $postID, // matches exactly "123", not just 123. This prevents a match for "1234"
                    'compare' => '='
                )
            )

        ) );
        while ( $add_pages_query->have_posts() ) {
            $add_pages_query->the_post();
            global $post;
            $term = get_term(get_field('addpage_taxonomy'),'addpagestypes');
	        $add_pages_n = 0;
	        if (get_locale() != 'ru_RU') {
                $enable_translations = get_field('enable_translations',$post->ID);
	        	if (is_array( $enable_translations ) && !in_array(get_locale(), $enable_translations)) {
	        		continue;
				}
			}
			if($post->ID == $post_id) {
				//$add_pages[] = '<li class="current"><a class="link_no_underline" data-post-id="'.$post->ID.'" data-type="add_page">'.$term->name.'</a></li>';
				$main_page = '<li class="current"><a class="link_no_underline" data-post-id="'.$post->ID.'" data-type="add_page">'.$term->name.'</a></li>';
				$add_pages_n = 1;
			} else {
				$add_pages[] = '<li><a href="'.get_the_permalink().'" class="link_no_underline" data-post-id="'.$post->ID.'" data-type="add_page">'.$term->name.'</a></li>';
			}
            
            }
        wp_reset_postdata();
        $number_all = count($add_pages)+$add_pages_n;
        if(!empty($add_pages)) {
            $result .= '<div class="add_links_container">';
	        if (intval($number_all) > 4) {
		        $result .= '<span class="arrow_left_review" style="display: none;"></span>';
		        $result .= '<span class="arrow_right_review"></span>';
	        } else {
		        $result .= '<span class="arrow_left_review" style="display: none;"></span>';
		        $result .= '<span class="arrow_right_review dn data_arrow_'.$number_all.'"></span>';
	        }
            $result .= '<ul class="add_links font_smaller font_bold">';
	        $i = 0;
            foreach ($add_pages as $item) {
            	if ($i == 0) {
            		$result .= $main_page;
	            }
            	$i = ++$i;
                $result .= $item;
            }

            $result .= '</ul>';
            //$result .= '<span class="add_links_more"></span>';
            $result .= '</div>';
        }
        return $result;
    }
}

if (!function_exists('ajax_popup_add_links')) {
    add_action('wp_ajax_ajax_popup_add_links', 'ajax_popup_add_links');
    add_action('wp_ajax_nopriv_ajax_popup_add_links', 'ajax_popup_add_links');
    function ajax_popup_add_links() {
        $data = $_POST;
        //print_r($data);
        $result = '';
        $result .= '<div class="popup_container" id="popup_'.$data['type'].'">';
        $result .= '<div class="popup_window box_shadow add_page_popup">';
            $result .= '<div class="popup_close_button pointer"></div>';

                if($data['type'] == 'add_page') {
                    $result .= '<div class="flex popup_add_page_columns" style="width:1110px;">';
                    $result .= '<div class="popup_add_column_left">';
                    $result .= '<div class="popup_add_column_header"></div>';
                    $review_id = get_field('addpage_review',$data['id']);
                    $result .= review_logo($review_id);
                    $company_name = get_field('company_name',$review_id);
                    $terms = get_the_terms($review_id,'affiliate-tags');
                    $result .= '<div class="font_big color_dark_blue m_t_15 font_bold">'.$company_name.'</div>';
                    if(!empty($terms)) {
                        $t_x = 0;
                        $result .= '<ul class="company_card_tags flex" data-id="6">';
                        foreach ($terms as $term) {
                            $t_x++;
                            if($t_x <= 3) {
                                $result .= '<li class="color_dark_blue">' . get_field('tag_human_title', 'term_' . $term->term_id) . '</li>';
                            }
                        }
                        $result .= '</ul>';
                    }
                    $result .= '<div class="popup_add_column_excerpt color_dark_gray">'.get_the_excerpt($review_id).'</div>';
                    $result .= '<div class="button button_medium font_bold color_dark_blue button_company_more pointer">'.__('Подробнее о компании','er_theme').'</div>';
                    $result .= '</div>';
                    $result .= '<div class="popup_add_column_right p_30 color_dark_blue">';
                    $result .= '<h1>'.get_the_title($data['id']).'</h1>';
                    $result .= apply_filters('the_content', get_post_field('post_content', $data['id']));
                    $result .= '</div>';
                    $result .= '</div>';
                } elseif($data['type'] == 'promocodes') {
                    $result .= '<div class="flex popup_add_page_columns" style="width:1110px;">';
                    $result .= '<div class="popup_add_column_left">';
                    $result .= '<div class="popup_add_column_header"></div>';
                    $review_id = get_field('promocode_review',$data['id']);
                    $result .= review_logo($review_id);
                    $company_name = get_field('company_name',$review_id);
                    $terms = get_the_terms($review_id,'affiliate-tags');
                    $result .= '<div class="font_big color_dark_blue m_t_15 font_bold">'.$company_name.'</div>';
                    if(!empty($terms)) {
                        $t_x = 0;
                        $result .= '<ul class="company_card_tags flex" data-id="7">';
                        foreach ($terms as $term) {
                            $t_x++;
                            if($t_x <= 3) {
                                $result .= '<li class="color_dark_blue">' . get_field('tag_human_title', 'term_' . $term->term_id) . '</li>';
                            }
                        }
                        $result .= '</ul>';
                    }
                    $result .= '<div class="popup_add_column_excerpt color_dark_gray">'.get_the_excerpt($review_id).'</div>';
                        $result .= '<div class="button button_medium font_bold color_dark_blue button_company_more pointer">'.__('Подробнее о компании','er_theme').'</div>';
                    $result .= '</div>';
                    $result .= '<div class="popup_add_column_right flex flex_column">';
                        $result .= '<div class="list_promocodes_top flex p_30">';
                            $result .= '<ul class="list_promocodes_tabs flex font_small font_uppercase color_dark_gray font_bold">';
                            $result .= '<li class="active color_dark_blue" data-type="all">'.__('Все','er_theme').'</li>';
                            $result .= '<li data-type="promocodes">'.__('Промокоды','er_theme').'</li>';
                            $result .= '<li data-type="coupons">'.__('Купоны','er_theme').'</li>';
                            $result .= '</ul>';
                            $result .= '<ul class="list_promocodes_styler flex">';
                            $result .= '<li class="active grid" data-type="grid"></li>';
                            $result .= '<li class="list" data-type="list"></li>';
                            $result .= '</ul>';
                            $result .= '<div class="list_promocodes_sorter">';
                            $result .= '<div class="comments_sorter_title color_dark_gray pointer dropdown flex">'.__('Отсортировать по','er_theme').'</div>';
                            $result .= '</div>';
                        $result .= '</div>';
                        $items = get_field('promocodes_items',$data['id']);
                        if(!empty($items)) {
                            $result .= '<ul class="flex list_promocodes">';
                            foreach ($items as $item) {
                                $result .= '<li class="white_block flex flex_column">';
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
                                if($size != '') {
                                    $result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size">' . $size . '</div>';
                                } else {
                                    $result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size_text">' . $item_type . '</div>';
                                }
                                if($item['title'] != '') {
                                    $result .= '<div class="color_dark_gray font_small m_t_10">' . $item['title'] . '</div>';
                                }
                                if($item['text'] != '') {
                                    $result .= '<div class="link_promocode_show_more_text button button_green button_centered m_t_20 pointer">'.__('Показать код','er_theme').'</div>';
                                } else {
                                    $result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer" href="" target="_blank">'.__('Получить','er_theme').'</a>';
                                }
                                $result .='</div>';
                                $result .='<div class="promocode_block_footer flex">';
                                if($item['description'] != '') {
                                    $result .= '<span class="font_smaller color_dark_gray inactive dropdown pointer flex link_promocode_show_more">'.__('Подробнее','er_theme').'</span>';
                                }
                                $count_used = 1;
                                $result .= '<span class="m_l_auto font_bold font_smaller color_dark_blue">'.$count_used.' '.counted_text($count_used,__('использует','er_theme'),__('используют','er_theme'),__('используют','er_theme')).'</span>';
                                $result .='</div>';
                                $result .= '</li>';
                            }
                            $result .= '</ul>';
                        }
                    $result .= '</div>';
                    $result .= '</div>';
                }

            $result .= '</div>';
        $result .= '</div>';
        echo $result;
        die;
    }
}

?>