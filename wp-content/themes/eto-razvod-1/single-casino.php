<?php

// Фильтруем новости компании для адресов типа /review/[CASINO_POST_TYPE_SLUG]/news
global $wp, $news_page_company_name;

$post_type = '';
$company_slug = '';
$news_page_company_name = '';
$is_company_news_page = false;


if( strlen( $wp->request ) ) {

	$slugs = explode( '/', $wp->request );

	if( count( $slugs ) == 3 ) {

		list( $post_type, $company_slug, $is_company_news_page ) = $slugs;
		$is_company_news_page = ( $is_company_news_page == 'news' ) ? true : false;
	
		if( $is_company_news_page and $company_slug ) {

			$news_page_company_id = get_post_id_by_meta_key_and_value( 'company_redirect_key', $company_slug );

			if( $news_page_company_id ) {

				$news_page_company_id = get_post_id_by_meta_key_and_value( 'company_redirect_key', $company_slug );

				query_posts(
					array(
						'p' => $news_page_company_id,
						'post_type' => array('casino'),
					)
				);

                $news_page_company_name = get_post_meta( $news_page_company_id, 'company_name', true );

				$news_posts = new WP_Query( 'category_name=blog&meta_key=news_for_company_id&meta_value=' . $news_page_company_id );

				// Отдаем 404, если нет новостей компании
				if( !$news_posts->have_posts() ) {

					wp_redirect( esc_url( home_url('/404/' ) ), 302);
					exit;

				}

			}

		}

	}

}



$review_aff_tags_text = '';
$review_aff_tags = get_field('review_aff_tags',$post->ID);
if(is_array($review_aff_tags) || $review_aff_tags instanceof Countable) {
	foreach ($review_aff_tags  as $item ) {
		$tag_term = get_term( $item, 'affiliate-tags' );
		$tag = $tag_term->slug;
		$review_aff_tags_text .= $tag.',';
	}
}
wp_localize_script( 'jquery', 'meta_page',
	array( 'affiliate_tags' =>  rtrim($review_aff_tags_text, ", ")));
get_header();

$locales = [ 'en_US', 'es_ES', 'de_DE', 'fr_FR', 'pl_PL', 'fi', 'id_ID' ];

$current_language = get_locale();

if (have_posts()) :
	while (have_posts()) : the_post();

		echo review_top($post->ID);
		// if($current_language == 'en_US' || $current_language == 'de_DE' || $current_language == 'fr_FR' || $current_language == 'es_ES' || $current_language == 'pl_PL') {

		if( in_array( $current_language, $locales ) ) {
			$translate_separately = get_field('translate_separately',$post->ID);
		}

		$verified = get_field('company_verified_status',$post->ID);
		wp_enqueue_script( 'progressbar', get_template_directory_uri() . '/js/progressbar.js', array('jquery'), $special_word );
		wp_enqueue_script( 'review_ajax_content', get_template_directory_uri() . '/js/review_ajax_content.js', array('jquery'),$special_word.filemtime(TEMPLATEPATH . '/js/review_ajax_content.js') ); ?>

		<?php
		$cur_user_id = get_current_user_id();
		wp_enqueue_script( 'review_default', get_template_directory_uri() . '/js/review_default.js', array('jquery'),$special_word.filemtime(TEMPLATEPATH . '/js/review_default.js') );
		wp_enqueue_script( 'review_top', get_template_directory_uri() . '/js/review_top.js', array('jquery'),$special_word );
		if (($cur_user_id == 22968) || ($cur_user_id == 17) || ($cur_user_id == 1) || ($cur_user_id == 31) || ($cur_user_id == 18627) ) { ?>
			<div class="active_fixed_page__single_review_2 page_content page_container background_light review_container_about single_container visible">
		<?php } else {  ?>
			<div class="active_fixed_page__single_review_2 page_content page_container background_light review_container_about single_container visible">
		<?php }
		?>


		<?php if(!get_field('er_pixel_disable')) { ?><img src="<?php bloginfo('url'); ?>/visit/<?php echo get_field('company_redirect_key',$post->ID);?>/?view=true" data-lazy-src="<?php bloginfo('url'); ?>/visit/<?php echo get_field('company_redirect_key',$post->ID);?>/" class="er_pixel" alt="" /><?php }; ?>
		<div class="wrap">
			<div class="container_left">
				<div class="main_button_mobile flex flex_column">
					<?php
					if(function_exists('review_block_main_button_replace_no_affilate')) {
						$review_block_main_button_replace_no_affilate = review_block_main_button_replace_no_affilate($post->ID);
						/*if ($cur_user_id == 17) {
							echo review_block_main_button_replace_no_affilate($post->ID);
						} else {
							echo review_block_main_button($post->ID);
						}*/
						echo $review_block_main_button_replace_no_affilate;
					}
					?>
					<div class="data-ad"></div>
				</div>


			<?php if( ( $is_company_news_page ) ) : // Новости компании 

				if( $news_page_company_id ) :

					$post_data_src = $post;

					wp_enqueue_style('news', get_template_directory_uri() . '/css/news.css');

					?>
					<div class="page_header news_page_top news_page_top_8">
						<?php

						$news_header = '';

						$news_header .= '<div class="page_heading_line">';
						$news_header .= '<h1 class="color_dark_blue flex font_medium_new">Новости ' . $news_page_company_name . '</h1>';
						$news_header .= '</div>';
						echo $news_header;

						?>
					</div>

					<div class="background_light news_container visible">
						<div class="wrap">
							<div class="news_middle">
							<?php

								while ( $news_posts->have_posts() ) {

									echo single_post( $news_posts->the_post() );

								}

							?>

							<?php
							wp_reset_postdata();

							setup_postdata( $post_data_src );

							er_pagination(); 
							?>
							</div>
						</div>
					</div>

				<?php endif; ?>

			<?php else : ?>

				<?php $term_slug = get_term( get_field('company_type'), 'companytypes' )->name;
				if (in_array($term_slug, array('bi'))) {
					$table_id = 57424;
				} elseif(in_array($term_slug, array('fond'))) {
					$table_id = 57418;
				} elseif(in_array($term_slug, array('crm'))) {
					$table_id = 79235;
				} elseif(in_array($term_slug, array('delivery'))) {
					$table_id = 160740;
				} elseif(in_array($term_slug, array('university'))) {
					$table_id = 162677;
				} elseif(in_array($term_slug, array('uk'))) {
					$table_id = 156853;
				} elseif(in_array($term_slug, array('nft'))) {
					$table_id = 156924;
				} elseif(in_array($term_slug, array('nft-games'))) {
					$table_id = 158100;
				} elseif(in_array($term_slug, array('wallet'))) {
					$table_id = 148898;
				} elseif(in_array($term_slug, array('cryptocurrency'))) {
					$table_id = 159359;
				} elseif(in_array($term_slug, array('accounting'))) {
					$table_id = 151015;
				} elseif(in_array($term_slug, array('tour'))) {
					$table_id = 151012;
				} elseif(in_array($term_slug, array('audit'))) {
					$table_id = 147972;
				} elseif(in_array($term_slug, array('fitness'))) {
					$table_id = 167422;
				} elseif(in_array($term_slug, array('defi'))) {
					$table_id = 165894;
				} elseif(in_array($term_slug, array('boards'))) {
					$table_id = 148003;
				} elseif(in_array($term_slug, array('dental'))) {
					$table_id = 147998;
				} elseif(in_array($term_slug, array('consult'))) {
					$table_id = 146909;
				} elseif(in_array($term_slug, array('marketing'))) {
					$table_id = 146052;
				} elseif(in_array($term_slug, array('bloggers'))) {
					$table_id = 146273;
				} elseif(in_array($term_slug, array('cashbox'))) {
					$table_id = 150015;
				} elseif(in_array($term_slug, array('sanatorium'))) {
					$table_id = 150052;
				} elseif(in_array($term_slug, array('sitebuild'))) {
					$table_id = 143500;
				} elseif(in_array($term_slug, array('sitebuilder'))) {
					$table_id = 143500;
				} elseif(in_array($term_slug, array('analytics'))) {
					$table_id = 144556;
				} elseif(in_array($term_slug, array('legal'))) {
					$table_id = 144593;
				} elseif(in_array($term_slug, array('program'))) {
					$table_id = 143544;
				} elseif(in_array($term_slug, array('vpn'))) {
					$table_id = 143128;
				} elseif(in_array($term_slug, array('bookingtravel'))) {
					$table_id = 142996;
				} elseif(in_array($term_slug, array('edo'))) {
					$table_id = 79290;
				} elseif(in_array($term_slug, array('exchange'))) {
					$table_id = 57409;
				} elseif(in_array($term_slug, array('mfo'))) {
					$table_id = 57403;
				} elseif(in_array($term_slug, array('credit'))) {
					$table_id = 57400;
				} elseif(in_array($term_slug, array('mining'))) {
					$table_id = 187180;
				} elseif(in_array($term_slug, array('miningtools'))) {
					$table_id = 196174;
				} elseif(in_array($term_slug, array('miningpow'))) {
					$table_id = 196179;
				} elseif(in_array($term_slug, array('fx','cfd'))) {
					$table_id = 57406;
				} elseif(in_array($term_slug, array('invest'))) {
					$table_id = 57412;
				} elseif(in_array($term_slug, array('crypto'))) {
					$table_id = 57415;
				} elseif(in_array($term_slug, array('bet'))) {
					$table_id = 57421;
				} elseif(in_array($term_slug, array('creditcard'))) {
					$table_id = 57427;
				} elseif(in_array($term_slug, array('debitcard'))) {
					$table_id = 57430;
				} elseif(in_array($term_slug, array('insurance'))) {
					$table_id = 57433;
				} elseif(in_array($term_slug, array('reviewsites'))) {
					$table_id = 194196;
				} elseif(in_array($term_slug, array('rko'))) {
					$table_id = 57436;
				} elseif(in_array($term_slug, array('cardealer'))) {
					$table_id = 113284;
				} elseif(in_array($term_slug, array('forbusiness'))) {
					$table_id = 57439;
				} elseif(in_array($term_slug, array('shop'))) {
					$table_id = 59202;
				} elseif(in_array($term_slug, array('game'))) {
					$table_id = 57442;
				} elseif(in_array($term_slug, array('payment'))) {
					$table_id = 57445;
				} elseif(in_array($term_slug, array('creditrating'))) {
					$table_id = 57451;
				} elseif(in_array($term_slug, array('cryptoloans'))) {
					$table_id = 187136;
				} elseif(in_array($term_slug, array('creditservis'))) {
					$table_id = 57454;
				} elseif(in_array($term_slug, array('cardbitcoin'))) {
					$table_id = 57457;
				} elseif(in_array($term_slug, array('deliveryfood'))) {
					$table_id = 57460;
				} elseif(in_array($term_slug, array('job'))) {
					$table_id = 57463;
				} elseif(in_array($term_slug, array('learn'))) {
					$table_id = 59944;
//} elseif(in_array($term_slug, array('learn2'))) {
					//$table_id = 59944;
				} elseif(in_array($term_slug, array('hosting'))) {
					$table_id = 57469;
				} elseif(in_array($term_slug, array('domains'))) {
					$table_id = 57472;
				} elseif(in_array($term_slug, array('providers'))) {
					$table_id = 57475;
				} elseif(in_array($term_slug, array('medservice'))) {
					$table_id = 57478;
				} elseif(in_array($term_slug, array('dating'))) {
					$table_id = 57481;
				} elseif(in_array($term_slug, array('bookingtickets'))) {
					$table_id = 57484;
				} elseif(in_array($term_slug, array('bookinghotel'))) {
					$table_id = 57487;
				} elseif(in_array($term_slug, array('avia'))) {
					$table_id = 120110;
				} elseif(in_array($term_slug, array('carrent'))) {
					$table_id = 57493;
				} elseif(in_array($term_slug, array('smmtools'))) {
					$table_id = 57499;
				} elseif(in_array($term_slug, array('antivirus'))) {
					$table_id = 130138;
				} elseif(in_array($term_slug, array('seo'))) {
					$table_id = 130479;
				} elseif(in_array($term_slug, array('advert'))) {
					$table_id = 57502;
				} elseif(in_array($term_slug, array('product'))) {
					$table_id = 57505;
				} elseif(in_array($term_slug, array('cryptobot'))) {
					$table_id = 57508;
				} elseif(in_array($term_slug, array('pharmacy'))) {
					$table_id = 57511;
				} elseif(in_array($term_slug, array('cpanetworks'))) {
					$table_id = 57515;
				} elseif(in_array($term_slug, array('chatbot'))) {
					$table_id = 57528;
				} elseif(in_array($term_slug, array('charg'))) {
					$table_id = 58553;
				} elseif(in_array($term_slug, array('developer'))) {
					$table_id = 103607;
				} elseif(in_array($term_slug, array('courses'))) {
					$table_id = 204536;
				} elseif(in_array($term_slug, array('onlinecasino'))) {
					$table_id = 220016;
				} elseif(in_array($term_slug, array('slotsonline'))) {
					$table_id = 235569;
				} elseif(in_array($term_slug, array('slotprovider'))) {
					$table_id = 251008;
				}  elseif(in_array($term_slug, array('default'))) {
					$table_id = 58556;
				}  elseif(in_array($term_slug, array('ai'))) {
					$table_id = 254586;
				} else {
					$table_id = 58556;
				}
				$current_language = get_locale();
				echo show_add_links($post->ID);

				$review_excerpt = get_the_excerpt($post->ID);
				if($review_excerpt && $review_excerpt != '') {
					echo print_js_links()['show_block'];
					echo print_css_links('show_block');
					echo '<div class="white_block the_excerpt">';
					if(mb_strlen($review_excerpt) > 139) {
						echo '<div class="the_excerpt_content" data-len="' . mb_strlen( $review_excerpt ) . '">' . $review_excerpt . '</div>';
					} else {
						echo '<div class="the_excerpt_content" data-len="' . mb_strlen( $review_excerpt ) . '" style="height:unset;">' . $review_excerpt . '</div>';
					}
					if(mb_strlen($review_excerpt) > 139) {//245
						echo '<div class="color_dark_gray font_small link_review_map link_dropdown link_inactive show_block" data-block=".the_excerpt_content" data-type="swipeDown">Читать полностью</div>';
					}
					echo '</div>';
				}
				echo review_table('details',$table_id);

				$widget_show_html = '';
				$curr_language_get = get_locale();
				if ( $curr_language_get == 'ru_RU' ) {

					if ( get_field( 'widget_social', $post->ID ) == 'osago24online' ) {

						$widget_show_html .= "
							<div id='widgetosago24online'>
								<script>var B2CWidgetLocation = 'https://my.agenters.ru/widgets/eosago/';</script>
								<script id='app-b2c-module-root' src='https://my.agenters.ru/widgets/eosago/assets/b2c-frame.loader.js'></script>
							</div>
							<script>
								$('#widgetosago24online').show();
							</script>
						";

					}

					if ( get_field( 'widget_social', $post->ID ) == 'travelpayouts' ) {
						$widget_show_html .= '<div class="travel_wrapper" style="margin-top: -20px; margin-bottom: 20px;"><script src="//c26.travelpayouts.com/content?promo_id=1151&shmarker=271942&trs=34014&city_from=Moscow&title=%D0%9B%D1%83%D1%87%D1%88%D0%B8%D0%B5%20%D1%86%D0%B5%D0%BD%D1%8B%20%D0%BD%D0%B0%20%D1%82%D1%83%D1%80%D1%8B&popular=true&powered_by=true" charset="utf-8"></script></div>';
					}

					if ( get_field( 'widget_social', $post->ID ) == 'svoywidgetmain' ) {

						if ( get_field( 'svoywidget', $post->ID ) ) {
							$widget_show_html .= '<div class="mywidgetm" data-id="'.sanitize_text_field(get_field( 'svoywidget', $post->ID )).'">'.get_field( 'svoywidget', $post->ID ).'</div>';
						}

					}
				}

				// Показ виджетов в зависимости от настройки поля widget_show_order в ACF-группе Дополнительные виджеты
				$widget_show_order = get_field( 'widget_show_order', $post->ID );
				if( $widget_show_order == 'after_table' or $widget_show_order == '0' ) {
					echo $widget_show_html;
				}

		        echo '<div id="after_table"></div>';

				if((is_array($review_aff_tags) || $review_aff_tags instanceof Countable) && count( $review_aff_tags ) != 0 ) {
					if ( get_field( 'turn_on_off', 'term_' . $review_aff_tags[0] ) == 'yes' ) {
						echo '<div class="get_b_table" post-id="'.get_the_ID().'" data-id="'.$review_aff_tags[0].'"></div>';
					} elseif ( get_field( 'turn_on_off', 'term_' . $review_aff_tags[1] ) == 'yes' ) {
						echo '<div class="get_b_table" post-id="'.get_the_ID().'" data-id="'.$review_aff_tags[1].'"></div>';
					} elseif ( get_field( 'turn_on_off', 'term_' . $review_aff_tags[2] ) == 'yes' ) {
						echo '<div class="get_b_table" post-id="'.get_the_ID().'" data-id="'.$review_aff_tags[2].'"></div>';
					} elseif ( get_field( 'turn_on_off', 'term_' . $review_aff_tags[3] ) == 'yes' ) {
						echo '<div class="get_b_table" post-id="'.get_the_ID().'" data-id="'.$review_aff_tags[3].'"></div>';
					} elseif ( get_field( 'turn_on_off', 'term_' . $review_aff_tags[4] ) == 'yes' ) {
						echo '<div class="get_b_table" post-id="'.get_the_ID().'" data-id="'.$review_aff_tags[4].'"></div>';
					}
				} else {
					$cur_terms = get_the_terms($post->ID, 'affiliate-tags');
					//print_r($cur_terms[0]);
					$term_id = $cur_terms[0]->term_id;
					if ($term_id != '') {
						if ( get_field( 'turn_on_off', 'term_' . $term_id ) == 'yes' ) {
							echo '<div class="get_b_table" post-id="'.get_the_ID().'" data-id="'.$term_id.'"></div>';
						} elseif ( get_field( 'turn_on_off', 'term_' . $cur_terms[1]->term_id ) == 'yes' ) {
							echo '<div class="get_b_table" post-id="'.get_the_ID().'" data-id="'.$cur_terms[1]->term_id .'"></div>';
						} elseif ( get_field( 'turn_on_off', 'term_' . $cur_terms[2]->term_id ) == 'yes' ) {
							echo '<div class="get_b_table" post-id="'.get_the_ID().'" data-id="'.$cur_terms[2]->term_id .'"></div>';
						} elseif ( get_field( 'turn_on_off', 'term_' . $cur_terms[3]->term_id ) == 'yes' ) {
							echo '<div class="get_b_table" post-id="'.get_the_ID().'" data-id="'.$cur_terms[3]->term_id .'"></div>';
						} elseif ( get_field( 'turn_on_off', 'term_' . $cur_terms[4]->term_id ) == 'yes' ) {
							echo '<div class="get_b_table" post-id="'.get_the_ID().'" data-id="'.$cur_terms[4]->term_id .'"></div>';
						}
					}
				}
				?>

				<div id="after_review"></div>

				<?php
				// Показ виджетов в зависимости от настройки поля widget_show_order в ACF-группе Дополнительные виджеты
				if( $widget_show_order == 'after_review' ) {
					echo $widget_show_html;
				}
				?>

				<ul id="reviews_about"></ul>
				<?php /*<div class="flex review_table_links justify-content-center">
					<a href="#comments" class="link_show_review_tab button button_violet button_padding_big font_small font_bold pointer link_no_underline"><?php _e('Читать отзывы','er_theme'); ?></a>
                        <?php if( '' !== get_post($post->ID)->post_content ) { ?>
                            <a href="#fullreview" class="link_show_content_tab button button_green button_padding_big font_small font_bold pointer link_no_underline"><?php _e('Читать обзор','er_theme'); ?></a>
                        <?php } ?>

					</div>*/?>
				<div class="list_more_container" id="list_more_container_main">
					<?=list_more_included($post->ID)?>
				</div>

			<?php endif; ?>


			</div>
			<div class="container_side flex flex_column">
				<div class="main_button_desktop flex flex_column">
					<?php
					if(function_exists('review_block_main_button_replace_no_affilate')) {
						/*if ($cur_user_id == 17) {
							echo review_block_main_button_replace_no_affilate($post->ID);
						} else {
							echo review_block_main_button($post->ID);
						}*/
						echo $review_block_main_button_replace_no_affilate;
					}
					?>
					<div class="data-ad"></div>
				</div>
				<div class="ajax_address_container"><?=ajax_append_address_php()?></div>
				<?php
				/*if(function_exists('review_block_address')) {
						echo review_block_address($post->ID);
				}*/


				?>
				<?php if( !$is_company_news_page ) : ?>
				<div class="company_news_container"><?=review_block_company_news( $post->ID )?></div>
				<?php endif; ?>

				<div class="subscribe_container"><?=ajax_subscribe_block_php()?></div><?php if (!$verified)  { ?>
					<div class="verify_container" data-id="<?php echo $post->ID; ?>"></div>
				<?php } ?>
				<div class="review_sidebar_banner"></div>
			</div>
		</div>
		</div>
		<div class="page_content page_container review_container_content single_container">
			<div class="wrap">
				<?php echo print_css_links('review_content');
				$current_language = get_locale();
				$news_page_company_name = get_field('company_name',$post->ID);
				$content = apply_filters( 'the_content', get_the_content() );
				// if($current_language == 'en_US' || $current_language == 'fr_FR' || $current_language == 'pl_PL' || $current_language == 'es_ES' || $current_language == 'fr_FR' || $current_language == 'de_DE') {
				if( in_array( $current_language, $locales ) ) {
					$content =   get_the_content();
				}
				if($content != '' || $term_slug == 'cryptocurrency') {

					if($translate_separately == true) {
						$translation_no_class = ' do_not_translate_css_class';
					} else {
						$translation_no_class = '';
					}

					$tag_H = ( $term_slug == 'cryptocurrency' ) ? 'h2' : 'h1';

					foreach( $locales as $locale ) {

                        if ( $translate_separately == 1 && $current_language == $locale ) {
                            // echo 'content for '.$current_language;
                            $translations       = get_field( 'translations', $post->ID );
                            $translations_array = array();
                            if ( ! empty( $translations ) ) {
                                foreach ( $translations as $translation ) {
                                    $translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
                                }
                            }
                            //print_r($translations_array);
                            $translated_content = $translations_array[ $current_language ];
                            if ( $translated_content == '' ) {
								$translation_no_class = '';
                            }

							break;
                        }

					}

                        // if ( $translate_separately == 1 && $curr_language == 'en_US' ) {
                        //     // echo 'content for '.$curr_language;
                        //     $translations       = get_field( 'translations', $post->ID );
                        //     $translations_array = array();
                        //     if ( ! empty( $translations ) ) {
                        //         foreach ( $translations as $translation ) {
                        //             $translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
                        //         }
                        //     }
                        //     //print_r($translations_array);
                        //     $translated_content = $translations_array[ $curr_language ];
                        //     if ( $translated_content == '' ) {
						// 		$translation_no_class = '';
                        //     }
                        // } elseif ( $translate_separately == 1 && $curr_language == 'pl_PL' ) {
						// 	// echo 'content for '.$curr_language;
						// 	$translations       = get_field( 'translations', $post->ID );
						// 	$translations_array = array();
						// 	if ( ! empty( $translations ) ) {
						// 		foreach ( $translations as $translation ) {
						// 			$translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
						// 		}
						// 	}
						// 	//print_r($translations_array);
						// 	$translated_content = $translations_array[ $curr_language ];
						// 	if ( $translated_content == '' ) {
						// 		$translation_no_class = '';
						// 	}
						// } elseif ( $translate_separately == 1 && $curr_language == 'fr_FR' ) {
						// 	// echo 'content for '.$curr_language;
						// 	$translations       = get_field( 'translations', $post->ID );
						// 	$translations_array = array();
						// 	if ( ! empty( $translations ) ) {
						// 		foreach ( $translations as $translation ) {
						// 			$translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
						// 		}
						// 	}
						// 	//print_r($translations_array);
						// 	$translated_content = $translations_array[ $curr_language ];
						// 	if ( $translated_content == '' ) {
						// 		$translation_no_class = '';
						// 	}
						// } elseif ( $translate_separately == 1 && $curr_language == 'es_ES' ) {
						// 	// echo 'content for '.$curr_language;
						// 	$translations       = get_field( 'translations', $post->ID );
						// 	$translations_array = array();
						// 	if ( ! empty( $translations ) ) {
						// 		foreach ( $translations as $translation ) {
						// 			$translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
						// 		}
						// 	}
						// 	//print_r($translations_array);
						// 	$translated_content = $translations_array[ $curr_language ];
						// 	if ( $translated_content == '' ) {
						// 		$translation_no_class = '';
						// 	}
						// } elseif ( $translate_separately == 1 && $curr_language == 'de_DE' ) {
						// 	// echo 'content for '.$curr_language;
						// 	$translations       = get_field( 'translations', $post->ID );
						// 	$translations_array = array();
						// 	if ( ! empty( $translations ) ) {
						// 		foreach ( $translations as $translation ) {
						// 			$translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
						// 		}
						// 	}
						// 	//print_r($translations_array);
						// 	$translated_content = $translations_array[ $curr_language ];
						// 	if ( $translated_content == '' ) {
						// 		$translation_no_class = '';
						// 	}
						// }

					?>

					<div id="the_c" class="the_content the_content_2 color_dark_blue<?php echo $translation_no_class; ?>">
						<<?php echo $tag_H; ?> class="m_b_10"><?php if(get_field('title_alter',$post->ID) != '') { echo get_field('title_alter',$post->ID); } else { echo $news_page_company_name; ?> <?php _e('это развод?','er_theme'); if($content != '') { echo ' '; $current_language = get_locale(); if($current_language == 'ru_RU') {
								if ($table_id == 204536) {
									_e('Отзывы','er_theme');
								} else {
									_e('Обзор и отзывы','er_theme');
								}


							} else { _e('Reviews and description','er_theme'); } } }  ?></<?php echo $tag_H; ?>>
						<div class="single_review_meta flex m_b_30">

							<div class="single_review_date font_small color_dark_gray">
								<meta itemprop="datePublished" content="<?php echo get_the_date('c'); ?>">
							<?php _e('Опубликовано:','er_theme'); ?> <?php echo get_the_date('j F Y'); ?> <?php $current_language = get_locale(); if($current_language == 'ru_RU') { _e('года','er_theme'); }; ?>

								<?php if ($current_language == 'ru_RU') {
									$city = 'года';
								} elseif ($current_language == 'en_US') {
									$city = '';
								} elseif ($current_language == 'fr_FR') {
									$city = '';
								} elseif ($current_language == 'es_ES') {
									$city = '';
								} elseif ($current_language == 'de_DE') {
									$city = '';
								} elseif ($current_language == 'pl_PL') {
									$city = '';
								} elseif ($current_language == 'fi') {
									$city = '';
								} elseif ($current_language == 'id_ID') {
									$city = '';
								} ?>
								<meta itemprop="dateModified" content="<?php echo get_the_modified_date('c'); ?>">
								<?php if (get_the_modified_date('j F Y') != get_the_date('j F Y')) { echo '<span class="updated updatedblock font_smaller_2">'.__('Обновлено:','er_theme').' '.get_the_modified_date('j F Y').' '; _e($city,'er_theme');echo '</span>'; }  ?></div>
							<div class="review_icon_share pointer m_l_15" data-type="share_post" data-id="<?php echo $post->ID; ?>"></div>
						</div>
						<?php //echo get_contents(apply_filters( 'the_content', get_the_content() )); ?>
						<?php if($term_slug == 'cryptocurrency') {
							$coin_title = get_field('company_name',$post->ID);
							$coin_short = get_field('currency_short',$post->ID);
							if ($coin_short == 'USDT') {
								$coin_short = 'BTC';
							}
							if ($current_language == 'ru_RU') {
								$lang = 'ru';
							} elseif ($current_language == 'en_US') {
								$lang = 'en';
							} elseif ($current_language == 'fr_FR') {
								$lang = 'fr';
							} elseif ($current_language == 'de_DE') {
								$lang = 'de_DE';
							} elseif ($current_language == 'es_ES') {
								$lang = 'es';
							} elseif ($current_language == 'pl_PL') {
								$lang = 'pl';
							} elseif ($current_language == 'fi') {
								$lang = 'fi';
							} elseif ($current_language == 'id_ID') {
								$lang = 'id';
							} else {
								$lang = 'en';
							}
							?>
							<h3>Онлайн график криптовалюты <?php echo $coin_title; ?></h3>

							<!-- TradingView Widget BEGIN -->
							<div class="tradingview-widget-container">
								<div id="tradingview_d3128"></div>
								<div class="tradingview-widget-copyright"><a href="https://ru.tradingview.com/symbols/<?php echo $coin_short; ?>USDT/?exchange=BINANCE" rel="noopener" target="_blank"><span class="blue-text">График <?php echo $coin_short; ?>USDT</span></a> от TradingView</div>
								<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
								<script type="text/javascript">
									new TradingView.widget(
										{
											"width":  '100%',
											"height": 610,
											"symbol": "BINANCE:<?php echo $coin_short; ?>USDT",
											"interval": "D",
											"timezone": "Etc/UTC",
											"theme": "light",
											"style": "1",
											"locale": "<?=$lang?>",
											"toolbar_bg": "#f1f3f6",
											"enable_publishing": false,
											"allow_symbol_change": true,
											"container_id": "tradingview_d3128"
										}
									);
								</script>
							</div>
							<?php echo do_shortcode( '[cryptobuy]' ); ?>
						<?php }


						$curr_language = get_locale();
						//echo '<div style="display: none;">translate_separately: '.$translate_separately.' '.$curr_language.'</div>';
						if($translate_separately == 1 && $curr_language == 'ru_RU') {
							//the_content();
							$content_main = get_the_content();
							$content_main = apply_filters( 'the_content', $content_main );
							echo $content_main;
						} elseif ($translate_separately == 1 && $curr_language == 'en_US') {
							// echo 'content for '.$curr_language;
							$translations = get_field('translations',$post->ID);
							$translations_array = array();
							if(!empty($translations)) {
								foreach($translations as $translation) {
									$translations_array[$translation['translation_language']] = $translation['translation_content'];
								}
							}
							//print_r($translations_array);
							$translated_content = $translations_array[$curr_language];
							if($translated_content != '') {
								if($curr_language == 'en_US') {
									$translated_content = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $translated_content);
									$translated_content = str_replace('fraudbroker.com', 'revieweek.com', $translated_content);
								}
								echo '<div id="get_con">'.$translated_content.'</div><span class="d_class_m"></span>';
							} else {

								$content_main = get_the_content();
								$content_main = apply_filters( 'the_content', $content_main );

								if (get_field('turnoffpics',get_the_ID()) == 'yes' && $curr_language != 'ru_RU'  ) {
									$content_main = preg_replace('/<img[^>]+./','',$content_main);
								}
								if ($curr_language != 'ru_RU') {
									$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
								}
								echo '<div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';

							}
						} elseif ($translate_separately == 1 && $curr_language == 'fr_FR') {
							// echo 'content for '.$curr_language;
							$translations = get_field('translations',$post->ID);
							$translations_array = array();
							if(!empty($translations)) {
								foreach($translations as $translation) {
									$translations_array[$translation['translation_language']] = $translation['translation_content'];
								}
							}
							//print_r($translations_array);
							$translated_content = $translations_array[$curr_language];
							if($translated_content != '') {
								if($curr_language == 'fr_FR') {
									$translated_content = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $translated_content);
									$translated_content = str_replace('fraudbroker.com', 'revieweek.com', $translated_content);
								}
								echo '<div id="get_con">'.$translated_content.'</div><span class="d_class_m"></span>';
							} else {

								$content_main = get_the_content();
								$content_main = apply_filters( 'the_content', $content_main );

								if (get_field('turnoffpics',get_the_ID()) == 'yes' && $curr_language != 'ru_RU'  ) {
									$content_main = preg_replace('/<img[^>]+./','',$content_main);
								}
								if ($curr_language != 'ru_RU') {
									$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
								}
								echo '<div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';

							}
						} elseif ($translate_separately == 1 && $curr_language == 'de_DE') {
							// echo 'content for '.$curr_language;
							$translations = get_field('translations',$post->ID);
							$translations_array = array();
							if(!empty($translations)) {
								foreach($translations as $translation) {
									$translations_array[$translation['translation_language']] = $translation['translation_content'];
								}
							}
							//print_r($translations_array);
							$translated_content = $translations_array[$curr_language];
							if($translated_content != '') {
								if($curr_language == 'de_DE') {
									$translated_content = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $translated_content);
									$translated_content = str_replace('fraudbroker.com', 'revieweek.com', $translated_content);
								}
								echo '<div id="get_con">'.$translated_content.'</div><span class="d_class_m"></span>';
							} else {

								$content_main = get_the_content();
								$content_main = apply_filters( 'the_content', $content_main );

								if (get_field('turnoffpics',get_the_ID()) == 'yes' && $curr_language != 'ru_RU'  ) {
									$content_main = preg_replace('/<img[^>]+./','',$content_main);
								}
								if ($curr_language != 'ru_RU') {
									$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
								}
								echo '<div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';

							}
						} elseif ($translate_separately == 1 && $curr_language == 'es_ES') {
							// echo 'content for '.$curr_language;
							$translations = get_field('translations',$post->ID);
							$translations_array = array();
							if(!empty($translations)) {
								foreach($translations as $translation) {
									$translations_array[$translation['translation_language']] = $translation['translation_content'];
								}
							}
							//print_r($translations_array);
							$translated_content = $translations_array[$curr_language];
							if($translated_content != '') {
								if($curr_language == 'es_ES') {
									$translated_content = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $translated_content);
									$translated_content = str_replace('fraudbroker.com', 'revieweek.com', $translated_content);
								}
								echo '<div id="get_con">'.$translated_content.'</div><span class="d_class_m"></span>';
							} else {

								$content_main = get_the_content();
								$content_main = apply_filters( 'the_content', $content_main );

								if (get_field('turnoffpics',get_the_ID()) == 'yes' && $curr_language != 'ru_RU'  ) {
									$content_main = preg_replace('/<img[^>]+./','',$content_main);
								}
								if ($curr_language != 'ru_RU') {
									$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
								}
								echo '<div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';

							}
						} elseif ($translate_separately == 1 && $curr_language == 'pl_PL') {
							// echo 'content for '.$curr_language;
							$translations = get_field('translations',$post->ID);
							$translations_array = array();
							if(!empty($translations)) {
								foreach($translations as $translation) {
									$translations_array[$translation['translation_language']] = $translation['translation_content'];
								}
							}
							//print_r($translations_array);
							$translated_content = $translations_array[$curr_language];
							if($translated_content != '') {
								if($curr_language == 'pl_PL') {
									$translated_content = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $translated_content);
									$translated_content = str_replace('fraudbroker.com', 'revieweek.com', $translated_content);
								}
								echo '<div id="get_con">'.$translated_content.'</div><span class="d_class_m"></span>';
							} else {

								$content_main = get_the_content();
								$content_main = apply_filters( 'the_content', $content_main );

								if (get_field('turnoffpics',get_the_ID()) == 'yes' && $curr_language != 'ru_RU'  ) {
									$content_main = preg_replace('/<img[^>]+./','',$content_main);
								}
								if ($curr_language != 'ru_RU') {
									$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
								}
								echo '<div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';

							}
						} elseif ($translate_separately == 1 && $curr_language == 'fi') {
							// echo 'content for '.$curr_language;
							$translations = get_field('translations',$post->ID);
							$translations_array = array();
							if(!empty($translations)) {
								foreach($translations as $translation) {
									$translations_array[$translation['translation_language']] = $translation['translation_content'];
								}
							}
							//print_r($translations_array);
							$translated_content = $translations_array[$curr_language];
							if($translated_content != '') {
								if($curr_language == 'fi') {
									$translated_content = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $translated_content);
									$translated_content = str_replace('fraudbroker.com', 'revieweek.com', $translated_content);
								}
								echo '<div id="get_con">'.$translated_content.'</div><span class="d_class_m"></span>';
							} else {

								$content_main = get_the_content();
								$content_main = apply_filters( 'the_content', $content_main );

								if (get_field('turnoffpics',get_the_ID()) == 'yes' && $curr_language != 'ru_RU'  ) {
									$content_main = preg_replace('/<img[^>]+./','',$content_main);
								}
								if ($curr_language != 'ru_RU') {
									$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
								}
								echo '<div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';

							}
						} elseif ($translate_separately == 1 && $curr_language == 'id_ID') {
							// echo 'content for '.$curr_language;
							$translations = get_field('translations',$post->ID);
							$translations_array = array();
							if(!empty($translations)) {
								foreach($translations as $translation) {
									$translations_array[$translation['translation_language']] = $translation['translation_content'];
								}
							}
							//print_r($translations_array);
							$translated_content = $translations_array[$curr_language];
							if($translated_content != '') {
								if($curr_language == 'fi') {
									$translated_content = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $translated_content);
									$translated_content = str_replace('fraudbroker.com', 'revieweek.com', $translated_content);
								}
								echo '<div id="get_con">'.$translated_content.'</div><span class="d_class_m"></span>';
							} else {

								$content_main = get_the_content();
								$content_main = apply_filters( 'the_content', $content_main );

								if (get_field('turnoffpics',get_the_ID()) == 'yes' && $curr_language != 'ru_RU'  ) {
									$content_main = preg_replace('/<img[^>]+./','',$content_main);
								}
								if ($curr_language != 'ru_RU') {
									$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
								}
								echo '<div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';

							}
						} else {
							$content_main = get_the_content();
							$content_main = apply_filters( 'the_content', $content_main );

							if (get_field('turnoffpics',get_the_ID()) == 'yes' && $curr_language != 'ru_RU'  ) {
								$content_main = preg_replace('/<img[^>]+./','',$content_main);
							}
							if ($curr_language != 'ru_RU') {
								$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
							}
							echo '<div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';
						}
						?>
						<?php  ?>
						<?php $curr_language_get = get_locale();
						if ( $curr_language_get == 'ru_RU' ) {
							if ( get_field( 'widget_social', $post->ID ) == 'stoyuristov' ) {
								if ( get_field( 'turn_off_stoyuristov', $post->ID ) == 1 ) {

								} else {
								}
							}
						} ?>
						<div class="list_more_container"></div>
					</div>
				<?php }; ?>
			</div>
			<div class="wrap" id="setter">
				<?php $curr_language_get = get_locale();
				if ( $curr_language_get == 'ru_RU' ) {
					if ( get_field( 'widget_social', $post->ID ) == 'travelpayouts' ) {
						echo '<div  style="margin-top: -20px;width: 100%;max-width: 775px;margin: 0 auto; margin-bottom: 20px;" class="seq"><script src="//c26.travelpayouts.com/content?promo_id=1151&shmarker=271942&trs=34014&city_from=Moscow&title=%D0%9B%D1%83%D1%87%D1%88%D0%B8%D0%B5%20%D1%86%D0%B5%D0%BD%D1%8B%20%D0%BD%D0%B0%20%D1%82%D1%83%D1%80%D1%8B&popular=true&powered_by=true" charset="utf-8"></script></div>';
					}

					if ( get_field( 'widget_social', $post->ID ) == 'svoywidgetmain' ) {
						if ( get_field( 'svoywidget', $post->ID ) ) {
							echo '<div class="mywidgetm" data-id="'.sanitize_text_field(get_field( 'svoywidget', $post->ID )).'">'.get_field( 'svoywidget', $post->ID ).'</div>';
						}
					}
				} ?>
			</div>
		</div>
		<div class="page_content page_container background_light review_container_reviews single_container" <?php /*if(get_field('reviews_count_reviews',$post->ID) > 0) {*/ ?> <?php /*} */?> itemid="<?php echo get_the_permalink($post->ID);?>" >
			<?php
			$c_logo = get_field('company_logo',$post->ID);
			$c_name = get_field('company_name',$post->ID);
			$c_phone = get_field('base_2_support_phones',$post->ID)[0]['text'];
			$c_url = get_field('websites',$post->ID)[0]['site_url'];
			$c_address = get_field('company_main_office',$post->ID);
			if($curr_language_get != 'ru_RU') {
				$cyr = ['Љ', 'Њ', 'Џ', 'џ', 'ш', 'ђ', 'ч', 'ћ', 'ж', 'љ', 'њ', 'Ш', 'Ђ', 'Ч', 'Ћ', 'Ж','Ц','ц', 'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п', 'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я', 'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П', 'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
				];
				$lat = ['Lj', 'Nj', 'Dž', 'dž', 'š', 'đ', 'č', 'ć', 'ž', 'lj', 'nj', 'Š', 'Đ', 'Č', 'Ć', 'Ž','C','c', 'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p', 'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya', 'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P', 'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
				];
			} else {
				$cyr = [];
				$lat = [];
			}
			/*
			if($c_logo != '') { ?>
				<meta itemprop="image" content="<?php echo $c_logo['sizes']['large']; ?>">
			<?php }; ?>
			<?php
			if($c_name != '') { ?>
				<meta itemprop="name" content="<?php echo str_replace($cyr,$lat,$c_name); ?>">
			<?php }; ?>
			<?php
			if($c_phone != '') { ?>
				<meta itemprop="telephone" content="<?php echo $c_phone; ?>">
			<?php }; ?>
			<?php
			if($c_url != '') { ?>
				<link itemprop="url" href="<?php echo $c_url; ?>">
			<?php }; ?>
			<?php
			if($c_address != '') { ?>
				<meta itemprop="address" content="<?php echo str_replace($cyr,$lat,$c_address); ?>">
			<?php }; 
			*/
			?>

			<div class="wrap">
				<div class="container_left">
					<div class="subscribe_container mobile"></div><?php if (!$verified)  { ?>
						<!--<div class="verify_container" data-id="<?php /*echo $post->ID; */?>"></div>-->
					<?php } ?>
					<?php
					if(function_exists('get_rating_fields_group')) {
						$rating_fields_group = get_rating_fields_group($post->ID);
					} else {
						$rating_fields_group = 0;
					}

					echo get_post_rating($rating_fields_group,'layout'); ?>
					<?php comments_template(); ?>
				</div>
				<div class="container_side flex flex_column">
					<?php echo widget_company_in_ratings($post->ID); ?>
					<div class="subscribe_container desktop"></div><?php if (!$verified)  { ?>
						<div class="verify_container" data-id="<?php echo $post->ID; ?>"></div>
					<?php } ?>
					<div class="review_sidebar_banner"></div>
				</div>
			</div>
		</div>

		<div class="page_content page_container background_light review_container_similar single_container">
			<div class="wrap">
				<div class="container_left">
					<div class="similar_container"></div>
					<div class="list_more_container"></div>
				</div>
				<div class="container_side flex flex_column">
					<?php //echo widget_best_companies($post->ID); ?>
					<?php echo widget_sidebar_old_companies($post->ID); ?>
					<div class="subscribe_container"></div><?php if (!$verified)  { ?>
						<div class="verify_container" data-id="<?php echo $post->ID; ?>"></div>
					<?php } ?>
					<div class="review_sidebar_banner"></div>
				</div>
			</div>
		</div>
		<div class="page_content page_container background_light review_container_abuses single_container">
			<div class="wrap">
				<div class="container_left">
					<ul id="abuses">
						<?php wp_enqueue_script( 'ajax-abuses', get_template_directory_uri() . '/js/ajax-abuses.js', array('jquery'),$special_word.filemtime(TEMPLATEPATH . '/js/ajax-abuses.js')  ); ?>
					</ul>
					<div class="list_more_container"></div>
				</div>
				<div class="container_side flex flex_column">
					<div class="abuse_activity_container"><?=ajax_company_activities_abuses_php()?></div>
					<div class="subscribe_container"></div>
					<?php if (!$verified)  { ?>
						<div class="verify_container" data-id="<?php echo $post->ID; ?>"></div>
					<?php } ?>
					<div class="review_sidebar_banner"></div>
				</div>
			</div>
		</div>
		<div class="page_after_content background_light"><?=ajax_new_companies_block_php()?></div>

		<?php
		if($post->ID == 48483) { ?>
		<?php }
	endwhile;
endif;


get_footer();

?>