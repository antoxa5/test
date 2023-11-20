<?php
wp_localize_script( 'jquery', 'meta_page',
	array( 'affiliate_tags' =>  get_term( intval(get_field('affiliate_tag',$post->ID)), 'affiliate-tags' )->slug));
get_header();
if (have_posts()) :
    while (have_posts()) : the_post();
		$actual_link = $_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI'];
		$pos = strpos($actual_link, '?q=');

		if ($pos !== false) {
			$actual_link = urldecode($actual_link);
			$key = explode('?q=',$actual_link)[1];
			$prase = $key;
			$result = '';
			
			$slug = $post->post_name;
			$search_active = ' active';
			$result .= '<div class="page_header page_header_rating page_rating_single page_s_promocodes_cat">';
				$result .= '<div class="wrap">';
					if (function_exists('show_breadcrumbs')) {
						$result .= show_breadcrumbs();
					}
					$result .= '<div class="page_heading_line">';
					$tag = get_field('affiliate_tag',$post->ID);
                    if($tag) {
                        $term_title = get_field('tag_human_title', 'term_' . $tag);
                    }
					$title = get_the_title($post->ID);
					$result .= '<h1 class="color_dark_blue flex font_medium_new">'.$title.'</h1>';
					$result .= '<div class="review_icon_share pointer m_l_15" data-type="share_post" data-id="'.$post->ID.'"></div>';
					$result .= '<form class="radius_small flex not_typing'.$search_active.'" id="search_results_form_promocodes" name="search_results_form" data-slug="'.$slug.'">';
					$result .= '<input type="text" name="s" class="placeholder_gray" value="'.$key.'" placeholder="'.__('Например, Финам').'" />';
					$result .= '<div class="big_search_icon_clear"></div>';
					$result .= '<div class="big_search_icon"></div>';
					$result .= '</form>';
				$result .= '</div>';
			$result .= '</div>';
			$result .= '</div>';
			/*$result .= '<div class="promocodes_header" data-tag="'.$tag.'">';
                $result .= '<div class="wrap">';
                $result .= '<div class="list_promocodes_top flex">';
                $result .= '<ul class="list_promocodes_tabs flex font_bolder font_smaller_2 font_uppercase color_dark_gray">';
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
                $result .= '</div>';
                $result .= '</div>';
                $result .= '</div>';
			*/
			$args_key = array(
				'posts_per_page' => -1,
				'post_type'=>'casino',
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key' => 'company_name',
						'value' => $prase,
						'compare' => 'LIKE'
					)
				)
			);
			$args_key['tax_query'] = array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field' => 'term_id',
					'terms' => $tag,
				)
			);
			$prase2 = '';
			if($prase != '') {
				include_once(TEMPLATEPATH .'/inc/get_search.php');
			}
			$the_query = new WP_Query( $args_key );

			$found = array();
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					global $post;
					
					$company_promo_args = array(
						'posts_per_page' => -1,
					'post_type'=> array('promocodes'),
						'post_status' => 'publish',
						'meta_query' => array(
							'relation' => 'AND',
						)
					);
					$company_promo_args['meta_query'][] = array(
						'key' => 'promocode_review',
						'value' => $post->ID,
						'compare' => '='
					);
					$language = get_locale();
					if ($language != 'ru_RU') {
						$company_promo_args['meta_query'][] = array(
							'key' => 'enable_translations',
							'value' => $language,
							'compare' => 'LIKE'
						);
					}
					$the_query_company_promo_args = new WP_Query( $company_promo_args );
					if ( $the_query_company_promo_args->have_posts() ) { 
						while ( $the_query_company_promo_args->have_posts() ) {
							$the_query_company_promo_args->the_post();
							global $post;
							$promocodes = array();
							//echo get_the_title($post->ID);
							$promocodes = get_field('promocodes_items');
							if($promocodes && !empty($promocodes)) {
								$found[] = $post->ID;
								//echo get_the_title($post->ID);
							}

						}
					}
					wp_reset_postdata();
				}
			}
			wp_reset_postdata();
			
			if(!empty($found)) {
				$result .= '<div class="page_content page_container background_light rating_container visible"><div class="wrap">';
				$result .= '<ul class="flex list_promocodes asfa399">';
				//print_r($found);
				foreach($found as $postt_id) {
							$review_id = get_field('promocode_review',$postt_id);
							$company_name = get_field('company_name',$review_id);
							//$result .= get_the_title($postt_id).'<br />';
							$promocodes = get_field('promocodes_items',$postt_id);
							$y = 0;
					$terms = get_term(get_field('promocode_taxonomy',$postt_id),'affiliate-tags')->slug;
		$terms_id = get_term(get_field('promocode_taxonomy',$postt_id),'affiliate-tags')->term_id;
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
					$the_post_for_slug = get_post( $postt_id );
					$xxx = 0;
							foreach ($promocodes as $item) {
								$xxx++;
								$result .= '<li class="white_block flex flex_column" id="cat_promocodes_'.$postt_id.'_'.$xxx.'">';
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
						$result .= '<a class="promocode_item_title color_dark_blue link_no_underline font_bold promocode_item_title_2" href="'.get_the_permalink($tasks[0]->ID).$the_post_for_slug->post_name.'/" target="_blank">'.$company_name.'</a>';
						if($item['title'] != '') {
							$result .= '<div class="color_dark_gray font_small m_t_10">' . $item['title'] . '</div>';
						}
							$result .= '<div class="promocode_button_container">';
									if($item['text'] != '' && $item['text'] != 'Не нужен') {
										$result .= '<div class="promocode_text_container">';
										$result .= '<div class="promocode_single_text" id="promocode_text_'.$post->ID.'_1">'.$item['text'].'</div>';
										$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-1/" target="_blank" rel="nofollow">'.__('Получить','er_theme').'</a>';
										$result .= '<div class="link_promocode_text_copy button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Скопировать','er_theme').'</div>';
										$result .= '</div>';
										$result .= '<div class="link_promocode_show_more_text button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Показать код','er_theme').'</div>';
									} else {
										$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-1/" target="_blank" rel="nofollow">'.__('Получить','er_theme').'</a>';
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
						}
				$result .= '</ul></div></div>';
				
			} else {
				$result .= '<div class="page_content page_container background_light rating_container visible"><div class="wrap">';
				$result .= __('Промокоды по вашему запросу не найдены');
				$result .= '</div></div>';
			}
				
			
			echo $result;
		} else {
			function wpa_show_permalinks2( $post_link, $post ){
				if ( is_object( $post ) && $post->post_type == 'promocodes' ){
					$terms = get_term(get_field('promocode_taxonomy'),'affiliate-tags')->slug;
					$args2 = array (
						'post_type' => 'promocodes_cats',
						'tax_query' => array(
							array(
								'taxonomy' => 'affiliate-tags',
								'field'    => 'slug',
								'terms'    => get_term(get_field('promocode_taxonomy'),'affiliate-tags')->slug
							)
						)
					);

					$promocode_category = get_posts($args2);
					$slug_url = $promocode_category[0]->post_name;
					if( $terms ){
						return str_replace( '%show_category%' , $slug_url , $post_link );
					}
				}
				return $post_link;
			}
			echo page_top($post->ID,'promocodes_cat'); ?>
        <div class="page_content page_container background_light rating_container visible">
            <div class="wrap">
                <?php
                $tag = get_field('affiliate_tag',$post->ID);
                $args = array(
                    'post_type' => 'promocodes',
                    'posts_per_page' => -1,
                    'meta_query' => array(
						'relation' => 'AND',
                        array(
                            'key' => 'promocodes_items',
                            'value' => 0,
                            'compare' => '>'
                        )
                    ),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'affiliate-tags',
                            'field' => 'term_id',
                            'terms' => $tag,
                        )
                    ),
                );
				$language = get_locale();
				if ($language != 'ru_RU') {
					$args['meta_query'][] = array(
						'key' => 'enable_translations',
						'value' => 'pl_PL',
						'compare' => 'LIKE'
					);
				}
                $query_reviews = new WP_Query($args);
        if ( $query_reviews->have_posts() ) {
            $result .= '<ul class="flex list_promocodes list_promocode sasfaf" dataid="'.$language.'">';
            $promocodes_array = array();
            $yyy = 0;
            while ( $query_reviews->have_posts() ) {
                $query_reviews->the_post();
                global $post;
                $items = get_field('promocodes_items',$post->ID);
                $review_id = get_field('promocode_review',$post->ID);
                $company_name = get_field('company_name',$review_id);
				if(!empty($items)) {
                    $nnn = 0;
					foreach ($items as $item) {

                        $hour = 12;
                        $today = strtotime($hour . ':00:00');
                        $yesterday = strtotime('-1 day', $today);

                        $date_end_m = strtotime($item['date_end']);
                        if(($date_end_m < $yesterday && !empty($item['date_end']) && $item['date_end'] != 'None') || ($item['hide_promos'] == 'yes')) {

                        } else {
                            $xxx++;
                            $yyy++;
                            $nnn++;
                            $promocode_single_array = array(
                                'count' => $item['visits'],
                                'item' => $item,
                                'post' => $post,
                                'yyy' => $yyy,
                                'nnn' => $nnn,
                                'review_id' => $review_id,
                                'company_name' => $company_name
                            );
                            $promocodes_array[] = $promocode_single_array;

                        }


					}
						
				}
                
                
            }
            $promocodes_current_count = 0;
            array_multisort(array_map(function($element) {
                return $element['count'];
            }, $promocodes_array), SORT_DESC, $promocodes_array);
            foreach($promocodes_array as $promocode_single) {
                $promocodes_current_count++;
                if($promocodes_current_count > 90) {
                    break;
                }
                $item = $promocode_single['item'];
                $post = $promocode_single['post'];
                $nnn = $promocode_single['nnn'];
                $yyy = $promocode_single['yyy'];
                $review_id = $promocode_single['review_id'];
                $company_name = $promocode_single['company_name'];

                $result .= '<li class="white_block flex flex_column" id="cat_promocodes_'.$post->ID.'">';
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
                $result .= '<a class="promocode_item_title color_dark_blue link_no_underline font_bold promocode_item_title_3 do_not_translate_css_class" href="'.wpa_show_permalinks2(get_the_permalink(),$post).'" target="_blank">'.$company_name.'</a>';
                if($item['title'] != '') {
                    $result .= '<div class="color_dark_gray font_small m_t_10">' . $item['title'] . '</div>';
                }
                $result .= '<div class="promocode_button_container">';
                if($item['text'] != '' && $item['text'] != 'Не нужен') {
                    $result .= '<div class="promocode_text_container">';
                    $result .= '<div class="promocode_single_text" id="promocode_text_'.$post->ID.'_'.$nnn.'">'.$item['text'].'</div>';
                    $result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$nnn.'/" target="_blank">'.__('Получить','er_theme').'</a>';
                    $result .= '<div class="link_promocode_text_copy button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Скопировать','er_theme').'</div>';
                    $result .= '</div>';
                    $result .= '<div class="link_promocode_show_more_text button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Показать код','er_theme').'</div>';
                } else {
                    $result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$nnn.'/" target="_blank">'.__('Получить','er_theme').'</a>';
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
        } else {
			$result .= '<p>'.__('В данной категории сейчас нет промокодов.','er_theme').'</p>';
		}
                wp_reset_postdata();
                echo $result;
                ?>
            </div>
        </div>
<?php
			
		}
        
    endwhile;
endif;



get_footer();

?>
