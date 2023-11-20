<?php

$request = explode('/', $_SERVER['REQUEST_URI']);
$aaaa = array(
	'post_type' => 'promocodes_cats',
	'name' => $request[2],
);
$pc = get_posts($aaaa);
if(empty($pc)) {
	$wp_query->set_404();
	status_header( 404 );
	nocache_headers();
	include("404.php");
	die;
}
$post_id_zero = $pc[0]->ID;
$cat_promo_tag = get_field('affiliate_tag',$post_id_zero);
$post_promo_tag = get_field('promocode_taxonomy',get_the_ID());
if ($cat_promo_tag != $post_promo_tag) {
	$wp_query->set_404();
	status_header( 404 );
	nocache_headers();
	include("404.php");
	die;
}
if ($request[4] != '') {
	if (substr($request[4], 0, 1) == '?') {
		//echo 'Работает #1';
	} else {
		$wp_query->set_404();
		status_header( 404 );
		nocache_headers();
		include("404.php");
		die;
	}
} else {
	//echo 'Работает #2';
}
$review_id = get_field('promocode_review',$post->ID);
$review_aff_tags_text = '';
$review_aff_tags = get_field('review_aff_tags',$review_id);
foreach ($review_aff_tags  as $item ) {
	$tag_term = get_term( $item, 'affiliate-tags' );
	$tag = $tag_term->slug;
	$review_aff_tags_text .= $tag.',';
}
wp_localize_script( 'jquery', 'meta_page',
	array( 'affiliate_tags' =>  rtrim($review_aff_tags_text, ", ")));
$permalink_review = get_the_permalink($review_id);
wp_localize_script( 'jquery', 'review_page',
	array( 'id' =>  $review_id, 'permalink' => $permalink_review, 'permalink_comments' => $permalink_review.'#comments', 'permalink_abuses' => $permalink_review.'#abuse')
);
get_header();
wp_enqueue_script( 'get-ad-text', get_template_directory_uri() . '/js/get-ad-text.js', array( 'jquery' ), '10.137'  )
; //

if (have_posts()) :
        while (have_posts()) : the_post();
		$review_id = get_field('promocode_review',$post->ID);
		echo review_top($review_id); 
		wp_enqueue_script( 'progressbar', get_template_directory_uri() . '/js/progressbar.js', array('jquery'),$special_word );
		wp_enqueue_script( 'review_ajax_content', get_template_directory_uri() . '/js/promocode_ajax_content.js', array('jquery'),$special_word );
		wp_enqueue_script( 'review_top', get_template_directory_uri() . '/js/review_top.js', array('jquery'),$special_word );
        wp_enqueue_script( 'promocode_load', get_template_directory_uri() . '/js/promocode_load.js', array('jquery'),$special_word );
		echo print_css_links('review_content');
		echo print_js_links()['show_block'];
			echo print_css_links('show_block');
$page_rate_count = get_field('page_rate_count',$post->ID);
	        $cur_user_id = get_current_user_id();
            if (($cur_user_id == 22968) || ($cur_user_id == 17) || ($cur_user_id == 1) || ($cur_user_id == 31) || ($cur_user_id == 18627) ) { ?>
        <div class="active_fixed_page__single_review_2 active_fixed_page__single_prcode page_content page_container background_light review_container_actions single_container visible" <?php if($page_rate_count && $page_rate_count != 0 && $page_rate_count != '') { ?>itemprop="itemReviewed" itemscope itemtype="https://schema.org/Product"<?php } ?>>

            <?php } else {  ?>
                <div class="active_fixed_page__single_review_2 active_fixed_page__single_prcode page_content page_container background_light review_container_actions single_container visible" <?php if($page_rate_count && $page_rate_count != 0 && $page_rate_count != '') { ?>itemprop="itemReviewed" itemscope itemtype="https://schema.org/Product"<?php } ?>>
        <?php }
	        ?>


            <meta itemprop="name" content="<?php the_title(); ?>" />
			<div class="wrap">
				<div class="container_left">
                    <div class="main_button_mobile flex flex_column">
						<?php
						if(function_exists('review_block_main_button_replace_no_affilate')) {
							$review_block_main_button_replace_no_affilate = review_block_main_button_replace_no_affilate($review_id);
							echo $review_block_main_button_replace_no_affilate;
						}
						?>
						<div class="data-ad" data-main-post-id="<?php echo $review_id; ?>"></div>
                    </div>
				<?php
					
					$content = apply_filters( 'the_content', get_the_content() );
                    $current_language = get_locale();
                    if($current_language != 'ru_RU') {
                        $content =   get_the_content();
                    }
					$short_description = get_field('promocode_description');
					if($short_description && $short_description != '') {
					?>
					
				<div class="single_promocode_content_text white_block">
						<?php if(strlen($short_description) > 245) { ?>
						    <div class="promo_content"><?php if($short_description && $short_description != '') { echo $short_description; } ?></div>
                        <?php } else { ?>
                            <div class="promo_content" style="height:unset;"><?php if($short_description && $short_description != '') { echo $short_description; } ?></div>
                        <?php } ?>
                    <?php if(strlen($short_description) > 245) { ?>
						<div class="color_dark_gray font_small link_review_map link_dropdown link_inactive show_block" data-block=".promo_content" data-type="swipeDown"><?php _e(' Читать полностью','er_theme'); ?></div>
				    <?php } ?>
                    </div>
				
				<?php }
					$result = '';
					$promocodes = get_field('promocodes_items');
					$company_name = get_field('company_name',$review_id);
					$faq_company_name = $company_name;
					$faq_url_company = get_bloginfo('url').'/visit/'.get_field('company_redirect_key',$review_id).'/';
					$faq_url_review = get_permalink();
					function max_with_key($array, $key) {
                            if (!is_array($array) || count($array) == 0) return false;
                            $max = $array[0][$key];
                            $keyr = $array[0][$key].''.$array[0]['y'];
                            foreach($array as $a) {
                                if($a[$key] > $max) {
                                    $max = $a[$key];
                                    $keyr = $a[$key].''.$a['y'];
                                }
                            }
                            return $keyr;
                        }

                        function min_with_key($array, $key) {
                            if (!is_array($array) || count($array) == 0) return false;
                            $max = $array[0][$key];
                            $keyr = $array[0][$key].''.$array[0]['y'];
                            foreach($array as $a) {
                                if($a[$key] < $max) {
                                    $max = $a[$key];
                                    $keyr = $a[$key].''.$a['y'];
                                }
                            }
                            return $keyr;
                        }
					if($promocodes && !empty($promocodes)) {
						$faq_discounts = array();
                		$faq_count_promocodes = count($promocodes);
						/*$result .= '<div class="white_block list_promocodes_top flex">';
						$result .= '<ul class="list_promocodes_tabs flex font_smaller_2 font_uppercase color_medium_gray font_bolder">';
							$result .= '<li class="active color_dark_blue" data-type="all">'.__('Все','er_theme').'</li>';
							$result .= '<li data-type="promocodes">'.__('Промокоды','er_theme').'</li>';
							$result .= '<li data-type="coupons">'.__('Купоны','er_theme').'</li>';
						$result .= '</ul>';
						$result .= '<div class="list_promocodes_sorter font_small">';
							$result .= '<div class="comments_sorter_title color_dark_gray pointer dropdown flex">'.__('Отсортировать по','er_theme').'</div>';
						$result .= '</div>';
						$result .= '</div>';*/
						$y = 0; 
						$result .= '<ul class="flex list_promocodes single_promocodes_list">';
						$count_all = count($promocodes);

						$hour = 12;
						$today              = strtotime($hour . ':00:00');
						$yesterday          = strtotime('-1 day', $today);

						foreach ($promocodes as $item) {
                            $y++;

							$date_end_m = strtotime($item['date_end']);
							if(($date_end_m < $yesterday && !empty($item['date_end']) && $item['date_end'] != 'None') || ($item['hide_promos'] == 'yes')) {
								$count_all = --$count_all;
							} else {
								//$result .= '<span class="date_end" style="display: none">'.strtotime($item['date_end']).' '.$yesterday.'</span>';
								if($item['text'] != '' && $item['text'] != 'Не нужен') {
									$border = 'border_green';
								} else {
									$border = 'border_biolet';
								}
								if($y > 9) {
									$hidden_default = ' hidden';
								} else {
									$hidden_default = '';
								}
								$result .= '<li class="white_block flex '.$border.''.$hidden_default.'" id="single_promocodes_'.$post->ID.'_'.$y.'">';
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
								if($item['discount_currency'] && $item['discount_currency'] == '%') {
									$faq_discounts[] = array('x' => $item['discount_size'],'y' => $item['discount_currency']);

								}
								if ($y < 4) {

									$faq_discount_titles .= $item['title'].', ';
								}
								$result .='<div class="promocode_block_content flex">';
								$result .= '<div class="promocode_list_single_left">';
								if($size != '') {
									$result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size">' . $size . '</div>';
								} else {
									$result .= '<div class="color_dark_blue font_bold font_big m_b_20 discount_size_text">' . $item_type . '</div>';
								}
								$terms = get_term(get_field('promocode_taxonomy',$post->ID),'affiliate-tags')->slug;
								$result .= '<div class="promocode_item_title color_dark_blue link_no_underline font_bold">'.$company_name.'</div>';


								$result .='</div>';
								$result .= '<div class="promocode_list_single_right">';
								if($item['title'] != '') {
									$result .= '<div class="promo_title color_dark_blue font_18 font_bold">' . $item['title'] . '</div>';
								}

								if($item['description'] != '') {
									$result .= '<div class="promocode_full_description color_dark_gray font_small">'.$item['description'].'</div>';
								}
								$result .= '<div class="promocode_button_container">';
								if($item['text'] != '' && $item['text'] != 'Не нужен') {
									$result .= '<div class="promocode_text_container">';
									$result .= '<div class="promocode_single_text" id="promocode_text_'.$post->ID.'_'.$y.'">'.$item['text'].'</div>';
									$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$y.'/" target="_blank">'.__('Получить','er_theme').'</a>';
									$result .= '<div class="link_promocode_text_copy button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Скопировать','er_theme').'</div>';
									$result .= '</div>';
									$result .= '<div class="link_promocode_show_more_text_popup button button_green button_centered m_t_20 pointer font_smaller font_bold">'.__('Показать код','er_theme').'</div>';
								} else {
									$result .= '<a class="link_promocode_get_visit button button_violet button_centered m_t_20 pointer link_no_underline font_smaller font_bold" href="'.get_bloginfo('url').'/visit2/'.$post->ID.'-'.$y.'/" target="_blank">'.__('Получить','er_theme').'</a>';
								}
								$result .='</div>';
								$result .='<div class="promocode_block_footer flex">';
								if($item['description'] != '') {
									$result .= '<span class="font_smaller color_dark_gray inactive dropdown pointer flex link_promocode_show_more">'.__('Подробнее','er_theme').'</span>';
								}
								$count_used = 1;
								if($item['visits'] && $item['visits'] != '' && $item['visits'] != 0) {
									$count_used = $item['visits'];
								}
								$result .= '<span class="promo_used font_bold font_smaller color_dark_blue">'.$count_used.' '.counted_text($count_used,__('использует','er_theme'),__('используют','er_theme'),__('используют','er_theme')).'</span>';
								$result .='</div>';
								$result .='</div>';
								$result .='</div>';


								$result .= '</li>';
                            }

						}
						$result .= '</ul>';
						$faq_count_promocodes = $count_all;
						
					}
					echo $result;
					if($count_all > 9) {
							echo '<div class="button button_comments button_green pointer load_more_single_promocodes font_small font_bold m_b_20" data-offset="9" >'.__('Показать еще','er_theme').'</div>';
						}
					
				?>
                    <?php if($content != '') { ?>
                    <div class="single_promocode_content_text white_block">
                        <div class="promo_content_main">
							<?php
							$curr_language_get = get_locale();
							if (get_field('turnoffpics',get_the_ID()) == 'yes' && $curr_language_get != 'ru_RU'  ) {
								$content_main = get_the_content();
								$content_main = apply_filters( 'the_content', $content_main );
								$content_main = preg_replace('/<img[^>]+./','',$content_main);
								echo $content_main;
							} else {
								the_content();
							}
							?>
						</div>
                    </div>
                    <?php } ?>
				<?php if(!get_field('er_pixel_disable',$review_id)) { ?><img src="<?php bloginfo('url'); ?>/visit/<?php echo get_field('company_redirect_key',$review_id);?>/?view=true" data-lazy-src="<?php bloginfo('url'); ?>/visit/<?php echo get_field('company_redirect_key',$review_id);?>/" class="er_pixel" alt="" /><?php }; ?>
				<?php 
					$faq_today_date  = date('d.m.Y');
            $faq_values = array();
            $faq_values['company'] = $faq_company_name;
            $faq_values['date'] = $faq_today_date;
            $faq_values['count_all'] = $faq_count_promocodes;
            if(!empty($faq_discounts)) {
                $faq_values['discount_min'] = min_with_key($faq_discounts, 'x');
                $faq_values['discount_max'] = max_with_key($faq_discounts, 'x');
            }


            $faq_values['url_company'] = $faq_url_company;
            $faq_values['url_review'] = $faq_url_review;
            $faq_values['titles'] = $faq_discount_titles;
			$faq_values['post_id'] = $post->ID;
            echo promocodes_faq($faq_values);
					?>
					<div class="promocodes_simple_rating">
			<?php echo page_single_rating($post->ID); ?>
			</div>
				
				<div class="list_more_container">
					<?=list_more_included($post->ID)?>
				</div>
				</div>
				<div class="container_side flex flex_column">

					<?php
					if(function_exists('review_block_main_button_replace_no_affilate')) {
						echo '<div class="main_button_desktop flex flex_column">'.$review_block_main_button_replace_no_affilate.'</div>';
						echo '<div class="data-ad" data-main-post-id="<?php echo $review_id; ?>"></div>'; //
					}
                    echo widget_company_in_ratings($review_id); ?>
					<div class="subscribe_container"></div>
					<div class="review_sidebar_banner"></div>
				</div>
			</div>
		</div>
		
		<div class="page_after_content background_light"><?=ajax_new_companies_block_php()?></div>
		<?php
		endwhile;
endif;


get_footer();

?>