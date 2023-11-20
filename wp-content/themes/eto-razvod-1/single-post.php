<?php
$review_aff_tags_text = '';
$review_aff_tags = get_field('er_post_tags',$post->ID);
foreach ($review_aff_tags  as $item ) {
	$tag_term = get_term( $item, 'affiliate-tags' );
	$tag = $tag_term->slug;
	$review_aff_tags_text .= $tag.',';
}
wp_localize_script( 'jquery', 'meta_page',
	array( 'affiliate_tags' =>  rtrim($review_aff_tags_text, ", ")));
get_header();

$current_language = get_locale();

$locales = [ 'en_US', 'es_ES', 'de_DE', 'fr_FR', 'pl_PL', 'fi', 'id_ID' ];

// if($current_language == 'en_US' || $current_language == 'de_DE' || $current_language == 'fr_FR' || $current_language == 'es_ES' || $current_language == 'pl_PL') {
if( in_array( $current_language, $locales ) ) {
	$translate_separately = get_field('translate_separately',get_the_ID());
}

$news_page_company_name = get_field('company_name',get_the_ID());
$content = apply_filters( 'the_content', get_the_content() );
// if($current_language == 'en_US' || $current_language == 'fr_FR' || $current_language == 'pl_PL' || $current_language == 'es_ES' || $current_language == 'fr_FR' || $current_language == 'de_DE') {
if( in_array( $current_language, $locales ) ) {
	$content =   get_the_content();
}
if($content != '') {

	if ( $translate_separately == true ) {
		$translation_no_class = ' do_not_translate_css_class';
	} else {
		$translation_no_class = '';
	}

	foreach( $locales as $locale ) {

		if ( $translate_separately == 1 && $current_language == $locale ) {
			// echo 'content for '.$current_language;
			$translations       = get_field( 'translations', get_the_ID() );
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

	// if ( $translate_separately == 1 && $current_language == 'en_US' ) {
	// 	// echo 'content for '.$current_language;
	// 	$translations       = get_field( 'translations', get_the_ID() );
	// 	$translations_array = array();
	// 	if ( ! empty( $translations ) ) {
	// 		foreach ( $translations as $translation ) {
	// 			$translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
	// 		}
	// 	}
	// 	//print_r($translations_array);
	// 	$translated_content = $translations_array[ $current_language ];
	// 	if ( $translated_content == '' ) {
	// 		$translation_no_class = '';
	// 	}
	// } elseif ( $translate_separately == 1 && $current_language == 'pl_PL' ) {
	// 	// echo 'content for '.$current_language;
	// 	$translations       = get_field( 'translations', get_the_ID() );
	// 	$translations_array = array();
	// 	if ( ! empty( $translations ) ) {
	// 		foreach ( $translations as $translation ) {
	// 			$translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
	// 		}
	// 	}
	// 	//print_r($translations_array);
	// 	$translated_content = $translations_array[ $current_language ];
	// 	if ( $translated_content == '' ) {
	// 		$translation_no_class = '';
	// 	}
	// } elseif ( $translate_separately == 1 && $current_language == 'fr_FR' ) {
	// 	// echo 'content for '.$current_language;
	// 	$translations       = get_field( 'translations', get_the_ID() );
	// 	$translations_array = array();
	// 	if ( ! empty( $translations ) ) {
	// 		foreach ( $translations as $translation ) {
	// 			$translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
	// 		}
	// 	}
	// 	//print_r($translations_array);
	// 	$translated_content = $translations_array[ $current_language ];
	// 	if ( $translated_content == '' ) {
	// 		$translation_no_class = '';
	// 	}
	// } elseif ( $translate_separately == 1 && $current_language == 'es_ES' ) {
	// 	// echo 'content for '.$current_language;
	// 	$translations       = get_field( 'translations', get_the_ID() );
	// 	$translations_array = array();
	// 	if ( ! empty( $translations ) ) {
	// 		foreach ( $translations as $translation ) {
	// 			$translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
	// 		}
	// 	}
	// 	//print_r($translations_array);
	// 	$translated_content = $translations_array[ $current_language ];
	// 	if ( $translated_content == '' ) {
	// 		$translation_no_class = '';
	// 	}
	// } elseif ( $translate_separately == 1 && $current_language == 'de_DE' ) {
	// 	// echo 'content for '.$current_language;
	// 	$translations       = get_field( 'translations', get_the_ID() );
	// 	$translations_array = array();
	// 	if ( ! empty( $translations ) ) {
	// 		foreach ( $translations as $translation ) {
	// 			$translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
	// 		}
	// 	}
	// 	//print_r($translations_array);
	// 	$translated_content = $translations_array[ $current_language ];
	// 	if ( $translated_content == '' ) {
	// 		$translation_no_class = '';
	// 	}
	// }
}
if (have_posts()) :
        while (have_posts()) : the_post();




$page_rate_count = get_field('page_rate_count',$post->ID);
		?>
		
		<div class="page_content page_container review_container_content single_container visible single_news" <?php if($page_rate_count && $page_rate_count != 0 && $page_rate_count != '') { ?>itemprop="itemReviewed" itemscope itemtype="https://schema.org/Product"<?php } ?>>
			<div class="wrap flex_column">
			<?php echo show_breadcrumbs(); ?>
			<?php echo print_css_links('review_content') ?>
				<div class="the_content color_dark_blue">
					<h1 class="m_b_10" itemprop="name"><?php the_title(); ?></h1>
                    <div class="single_review_meta flex m_b_30">
						<?php if ($current_language == 'ru_RU') {
							$update = 'Опубликовано: ';
						} elseif ($current_language == 'en_US') {
							$update = 'Published: ';
						} elseif ($current_language == 'fr_FR') {
							$update = 'Publié: ';
						} elseif ($current_language == 'es_ES') {
							$update = 'Publicado: ';
						} elseif ($current_language == 'de_DE') {
							$update = 'Veröffentlicht: ';
						} elseif ($current_language == 'pl_PL') {
							$update = 'Opublikowany: ';
						} elseif ($current_language == 'fi') {
							$update = 'Julkaisija: ';
						} elseif ($current_language == 'id_ID') {
							$update = 'Diterbitkan oleh: ';
						} ?>
                        <div class="single_review_date font_small color_dark_gray"><?php echo $update; ?><?php echo get_the_date('j F Y'); if($current_language == 'ru_RU') { _e(' года','er_theme'); } ?>
								<?php if (get_the_modified_date('j F Y') != get_the_date('j F Y')) { ?>

									<?php if ($current_language == 'ru_RU') {
										$update = 'Обновлено: ';
									} elseif ($current_language == 'en_US') {
										$update = 'Updated: ';
									} elseif ($current_language == 'fr_FR') {
										$update = 'Actualisé: ';
									} elseif ($current_language == 'es_ES') {
										$update = 'Actualizado: ';
									} elseif ($current_language == 'de_DE') {
										$update = 'Aktualisiert: ';
									} elseif ($current_language == 'pl_PL') {
										$update = 'Aktualizacja: ';
									} elseif ($current_language == 'fi') {
										$update = 'Julkaisija: ';
									} elseif ($current_language == 'id_ID') {
										$update = 'Diperbarui: ';
									} ?>

									<?php echo '<span class="updated updateded font_smaller_2">'.$update.''.get_the_modified_date('j F Y'); ?>

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

									<?php
										_e($city,'er_theme');
										echo '</span>';
								}
							?>

						</div>
                        <div class="review_icon_share pointer m_l_15" data-type="share_post" data-id="<?php echo $post->ID; ?>"></div>
                    </div>
					<?php
					//echo '<div style="display: none;">translate_separately: '.$translate_separately.' '.$current_language.'</div>';
					if($translate_separately == 1 && $current_language == 'ru_RU') {
						//the_content();
						$content_main = get_the_content();
						$content_main = apply_filters( 'the_content', $content_main );
						echo $content_main;
					} elseif ($translate_separately == 1 && $current_language == 'en_US') {
						// echo 'content for '.$current_language;
						$translations = get_field('translations',$post->ID);
						$translations_array = array();
						if(!empty($translations)) {
							foreach($translations as $translation) {
								$translations_array[$translation['translation_language']] = $translation['translation_content'];
							}
						}
						//print_r($translations_array);
						$translated_content = $translations_array[$current_language];
						if($translated_content != '') {
							if($current_language == 'en_US') {
								$translated_content = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $translated_content);
								$translated_content = str_replace('fraudbroker.com', 'revieweek.com', $translated_content);
							}
							echo $translated_content;
						} else {

							$content_main = get_the_content();
							$content_main = apply_filters( 'the_content', $content_main );

							if (get_field('turnoffpics',get_the_ID()) == 'yes' && $current_language != 'ru_RU'  ) {
								$content_main = preg_replace('/<img[^>]+./','',$content_main);
							}
							if ($current_language != 'ru_RU') {
								$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
							}
							echo '<div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';

						}
					} elseif ($translate_separately == 1 && $current_language == 'fr_FR') {
						// echo 'content for '.$current_language;
						$translations = get_field('translations',$post->ID);
						$translations_array = array();
						if(!empty($translations)) {
							foreach($translations as $translation) {
								$translations_array[$translation['translation_language']] = $translation['translation_content'];
							}
						}
						//print_r($translations_array);
						$translated_content = $translations_array[$current_language];
						if($translated_content != '') {
							if($current_language == 'fr_FR') {
								$translated_content = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $translated_content);
								$translated_content = str_replace('fraudbroker.com', 'revieweek.com', $translated_content);
							}
							echo $translated_content;
						} else {

							$content_main = get_the_content();
							$content_main = apply_filters( 'the_content', $content_main );

							if (get_field('turnoffpics',get_the_ID()) == 'yes' && $current_language != 'ru_RU'  ) {
								$content_main = preg_replace('/<img[^>]+./','',$content_main);
							}
							if ($current_language != 'ru_RU') {
								$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
							}
							echo '<div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';

						}
					} elseif ($translate_separately == 1 && $current_language == 'de_DE') {
						// echo 'content for '.$current_language;
						$translations = get_field('translations',$post->ID);
						$translations_array = array();
						if(!empty($translations)) {
							foreach($translations as $translation) {
								$translations_array[$translation['translation_language']] = $translation['translation_content'];
							}
						}
						//print_r($translations_array);
						$translated_content = $translations_array[$current_language];
						if($translated_content != '') {
							if($current_language == 'de_DE') {
								$translated_content = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $translated_content);
								$translated_content = str_replace('fraudbroker.com', 'revieweek.com', $translated_content);
							}
							echo $translated_content;
						} else {

							$content_main = get_the_content();
							$content_main = apply_filters( 'the_content', $content_main );

							if (get_field('turnoffpics',get_the_ID()) == 'yes' && $current_language != 'ru_RU'  ) {
								$content_main = preg_replace('/<img[^>]+./','',$content_main);
							}
							if ($current_language != 'ru_RU') {
								$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
							}
							echo '<div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';

						}
					} elseif ($translate_separately == 1 && $current_language == 'es_ES') {
						// echo 'content for '.$current_language;
						$translations = get_field('translations',$post->ID);
						$translations_array = array();
						if(!empty($translations)) {
							foreach($translations as $translation) {
								$translations_array[$translation['translation_language']] = $translation['translation_content'];
							}
						}
						//print_r($translations_array);
						$translated_content = $translations_array[$current_language];
						if($translated_content != '') {
							if($current_language == 'es_ES') {
								$translated_content = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $translated_content);
								$translated_content = str_replace('fraudbroker.com', 'revieweek.com', $translated_content);
							}
							echo $translated_content;
						} else {

							$content_main = get_the_content();
							$content_main = apply_filters( 'the_content', $content_main );

							if (get_field('turnoffpics',get_the_ID()) == 'yes' && $current_language != 'ru_RU'  ) {
								$content_main = preg_replace('/<img[^>]+./','',$content_main);
							}
							if ($current_language != 'ru_RU') {
								$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
							}
							echo '<div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';

						}
					} elseif ($translate_separately == 1 && $current_language == 'pl_PL') {
						// echo 'content for '.$current_language;
						$translations = get_field('translations',$post->ID);
						$translations_array = array();
						if(!empty($translations)) {
							foreach($translations as $translation) {
								$translations_array[$translation['translation_language']] = $translation['translation_content'];
							}
						}
						//print_r($translations_array);
						$translated_content = $translations_array[$current_language];
						if($translated_content != '') {
							if($current_language == 'pl_PL') {
								$translated_content = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $translated_content);
								$translated_content = str_replace('fraudbroker.com', 'revieweek.com', $translated_content);
							}
							echo '<span class="get_con5"></span>'.$translated_content;
						} else {

							$content_main = get_the_content();
							$content_main = apply_filters( 'the_content', $content_main );

							if (get_field('turnoffpics',get_the_ID()) == 'yes' && $current_language != 'ru_RU'  ) {
								$content_main = preg_replace('/<img[^>]+./','',$content_main);
							}
							if ($current_language != 'ru_RU') {
								$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
							}
							echo '<span class="get_con4"></span><div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';

						}
					} elseif ($translate_separately == 1 && $current_language == 'fi') {
						// echo 'content for '.$current_language;
						$translations = get_field('translations',$post->ID);
						$translations_array = array();
						if(!empty($translations)) {
							foreach($translations as $translation) {
								$translations_array[$translation['translation_language']] = $translation['translation_content'];
							}
						}
						//print_r($translations_array);
						$translated_content = $translations_array[$current_language];
						if($translated_content != '') {
							if($current_language == 'fi') {
								$translated_content = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $translated_content);
								$translated_content = str_replace('fraudbroker.com', 'revieweek.com', $translated_content);
							}
							echo '<span class="get_con5"></span>'.$translated_content;
						} else {

							$content_main = get_the_content();
							$content_main = apply_filters( 'the_content', $content_main );

							if (get_field('turnoffpics',get_the_ID()) == 'yes' && $current_language != 'ru_RU'  ) {
								$content_main = preg_replace('/<img[^>]+./','',$content_main);
							}
							if ($current_language != 'ru_RU') {
								$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
							}
							echo '<span class="get_con4"></span><div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';

						}
					} elseif ($translate_separately == 1 && $current_language == 'id_ID') {
						// echo 'content for '.$current_language;
						$translations = get_field('translations',$post->ID);
						$translations_array = array();
						if(!empty($translations)) {
							foreach($translations as $translation) {
								$translations_array[$translation['translation_language']] = $translation['translation_content'];
							}
						}
						//print_r($translations_array);
						$translated_content = $translations_array[$current_language];
						if($translated_content != '') {
							if($current_language == 'id_ID') {
								$translated_content = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $translated_content);
								$translated_content = str_replace('fraudbroker.com', 'revieweek.com', $translated_content);
							}
							echo '<span class="get_con5"></span>'.$translated_content;
						} else {

							$content_main = get_the_content();
							$content_main = apply_filters( 'the_content', $content_main );

							if (get_field('turnoffpics',get_the_ID()) == 'yes' && $current_language != 'ru_RU'  ) {
								$content_main = preg_replace('/<img[^>]+./','',$content_main);
							}
							if ($current_language != 'ru_RU') {
								$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
							}
							echo '<span class="get_con4"></span><div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';

						}
					} else {
						$content_main = get_the_content();
						$content_main = apply_filters( 'the_content', $content_main );

						if (get_field('turnoffpics',get_the_ID()) == 'yes' && $current_language != 'ru_RU'  ) {
							$content_main = preg_replace('/<img[^>]+./','',$content_main);
						}
						if ($current_language != 'ru_RU') {
							$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);
						}
						echo '<span class="get_con3"></span><div id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';
					}
					?>
					<?php
					if ( $current_language == 'ru_RU' ) {
						if ( get_field( 'widget_social', $post->ID ) == 'stoyuristov' ) {
							if ( get_field( 'turn_off_stoyuristov', $post->ID ) == 1 ) {

							} else {

							}
						}
					} ?>
					<?php 
					if ( $current_language == 'ru_RU' ) {
						if ( get_field( 'widget_social', $post->ID ) == 'travelpayouts' ) {
							echo '<div  style="width: 100%;max-width: 775px;margin: 0 auto; margin-bottom: 20px;" class="seq"><script src="//c26.travelpayouts.com/content?promo_id=1151&shmarker=271942&trs=34014&city_from=Moscow&title=%D0%9B%D1%83%D1%87%D1%88%D0%B8%D0%B5%20%D1%86%D0%B5%D0%BD%D1%8B%20%D0%BD%D0%B0%20%D1%82%D1%83%D1%80%D1%8B&popular=true&powered_by=true" charset="utf-8"></script></div>';
						}

						if ( get_field( 'widget_social', $post->ID ) == 'svoywidgetmain' ) {
							if ( get_field( 'svoywidget', $post->ID ) ) {
								echo '<div class="mywidgetm" data-id="'.sanitize_text_field(get_field( 'svoywidget', $post->ID )).'">'.get_field( 'svoywidget', $post->ID ).'</div>';
							}
						}
					}


					?>

						<div class="list_more_container" id="list_more_container_main">
							<?php echo list_more_included_blog_news(get_the_ID()); ?>
						</div>
                    <div id="comments">
					<?php 
					echo single_post_comments_top($post->ID);
					comments_template(); ?>
                    </div>
				</div>
		
						
					
			</div>
		</div>
		
		<?php
		endwhile;
endif;


get_footer();

?>