<?php
$review_aff_tags_text = '';
$review_aff_tags = get_field('er_post_tags',$post->ID);
foreach ($review_aff_tags  as $item ) {
	$tag_term = get_term( $item, 'affiliate-tags' );
	$tag = $tag_term->slug;
	$review_aff_tags_text .= $tag.',';
}
if (count($review_aff_tags) != 0) {
	wp_localize_script( 'jquery', 'meta_page',
		array( 'affiliate_tags' =>  rtrim($review_aff_tags_text, ", ")));
}
get_header();

$locales = [ 'en_US', 'es_ES', 'de_DE', 'fr_FR', 'pl_PL', 'fi', 'id_ID' ];

$current_language = get_locale();

$content = apply_filters( 'the_content', get_the_content() );

foreach( $locales as $locale ) {

	if ( $current_language == $locale ) {

		$translate_separately = get_field( 'translate_separately', get_the_ID() );
		$content = get_the_content();

		break;

	}

}
// if(	$current_language == 'en_US' || $current_language == 'de_DE' || $current_language == 'fr_FR' || $current_language == 'es_ES' || $current_language == 'pl_PL') {
// 	$translate_separately = get_field('translate_separately',get_the_ID());
// }

// $news_page_company_name = get_field('company_name',get_the_ID());
// $content = apply_filters( 'the_content', get_the_content() );

// if($current_language == 'en_US' || $current_language == 'fr_FR' || $current_language == 'pl_PL' || $current_language == 'es_ES' || $current_language == 'fr_FR' || $current_language == 'de_DE') {
// 	$content =   get_the_content();
// }

if($content != '') {

	if ( $translate_separately == true ) {
		$translation_no_class = ' do_not_translate_css_class';
	} else {
		$translation_no_class = '';
	}

	// $current_language = get_locale();

	// if ( $translate_separately == 1 && $current_language == 'en_US' ) {
	// 	$translations       = get_field( 'translations', get_the_ID() );
	// 	$translations_array = array();
	// 	if ( ! empty( $translations ) ) {
	// 		foreach ( $translations as $translation ) {
	// 			$translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
	// 		}
	// 	}
	// 	$translated_content = $translations_array[ $current_language ];
	// 	if ( $translated_content == '' ) {
	// 		$translation_no_class = '';
	// 	}
	// } elseif ( $translate_separately == 1 && $current_language == 'pl_PL' ) {
	// 	$translations       = get_field( 'translations', get_the_ID() );
	// 	$translations_array = array();
	// 	if ( ! empty( $translations ) ) {
	// 		foreach ( $translations as $translation ) {
	// 			$translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
	// 		}
	// 	}
	// 	$translated_content = $translations_array[ $current_language ];
	// 	if ( $translated_content == '' ) {
	// 		$translation_no_class = '';
	// 	}
	// } elseif ( $translate_separately == 1 && $current_language == 'fr_FR' ) {
	// 	$translations       = get_field( 'translations', get_the_ID() );
	// 	$translations_array = array();
	// 	if ( ! empty( $translations ) ) {
	// 		foreach ( $translations as $translation ) {
	// 			$translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
	// 		}
	// 	}
	// 	$translated_content = $translations_array[ $current_language ];
	// 	if ( $translated_content == '' ) {
	// 		$translation_no_class = '';
	// 	}
	// } elseif ( $translate_separately == 1 && $current_language == 'es_ES' ) {
	// 	$translations       = get_field( 'translations', get_the_ID() );
	// 	$translations_array = array();
	// 	if ( ! empty( $translations ) ) {
	// 		foreach ( $translations as $translation ) {
	// 			$translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
	// 		}
	// 	}
	// 	$translated_content = $translations_array[ $current_language ];
	// 	if ( $translated_content == '' ) {
	// 		$translation_no_class = '';
	// 	}
	// } elseif ( $translate_separately == 1 && $current_language == 'de_DE' ) {
	// 	$translations       = get_field( 'translations', get_the_ID() );
	// 	$translations_array = array();
	// 	if ( ! empty( $translations ) ) {
	// 		foreach ( $translations as $translation ) {
	// 			$translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
	// 		}
	// 	}
	// 	$translated_content = $translations_array[ $current_language ];
	// 	if ( $translated_content == '' ) {
	// 		$translation_no_class = '';
	// 	}
	// }

	if ( $translate_separately == 1 && $current_language != 'ru_RU' ) {
		$translations       = get_field( 'translations', get_the_ID() );
		$translations_array = array();
		if ( ! empty( $translations ) ) {
			foreach ( $translations as $translation ) {
				$translations_array[ $translation['translation_language'] ] = $translation['translation_content'];
			}
		}
		$translated_content = $translations_array[ $current_language ];
		if ( $translated_content == '' ) {
			$translation_no_class = '';
		}
	}

}


if (have_posts()) :
	while (have_posts()) : the_post();
$page_rate_count = get_field('page_rate_count',$post->ID);

		?>
        <div class="page_content page_container review_container_content single_container visible single_news" <?php if($page_rate_count && $page_rate_count != 0 && $page_rate_count != '') { ?>itemprop="itemReviewed" itemscope itemtype="https://schema.org/Product"<?php } ?>>
            <div class="wrap flex_column">
				<?php echo show_breadcrumbs(); ?>
				<?php echo print_css_links('review_content') ?>
                <div class="the_content color_dark_blue <?php echo $translation_no_class; ?>">
                    <h1 class="m_b_30" itemprop="name"><?php the_title(); ?></h1>
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
					// $current_language_get = get_locale();
					// $current_language = get_locale();
					//echo '<div style="display: none;">translate_separately: '.$translate_separately.' '.$current_language.'</div>';

					if( $translate_separately == 1 && $current_language == 'ru_RU' ) {

						$content_main = get_the_content();
						$content_main = apply_filters( 'the_content', $content_main );
						echo $content_main;

					} elseif ( $translate_separately == 1 && in_array( $current_language, $locales ) ) {

						$translations = get_field('translations',$post->ID);
						$translations_array = array();

						if(!empty($translations)) {

							foreach($translations as $translation) {

								$translations_array[$translation['translation_language']] = $translation['translation_content'];

							}

						}

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

							if (get_field('turnoffpics',get_the_ID()) == 'yes' ) {

								$content_main = preg_replace('/<img[^>]+./','',$content_main);

							}

							$content_main = preg_replace('#<script src="(.*?)travelpayouts(.*?)" [^>]+>.*?</script>#is', '', $content_main, -1);

							echo '<div data-id="get_con_v2" id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';

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
						echo '<span class="get_con3"></span><div data-id="get_con_v3" id="get_con">'.$content_main.'</div><span class="d_class_m"></span>';
					}
					?>
					<?php
					if ( $current_language == 'ru_RU' ) {
						if ( get_field( 'widget_social', $post->ID ) == 'stoyuristov' ) {
							if ( get_field( 'turn_off_stoyuristov', $post->ID ) == 1 ) {

							} else {
							}
						}

						if ( get_field( 'widget_social', $post->ID ) == 'svoywidgetmain' ) {
							if ( get_field( 'widget_social', $post->ID ) == 'svoywidget' ) {
								echo get_field( 'widget_social', $post->ID );
							}
						}
					} ?>
						<div class="list_more_container" id="list_more_container_main">
							<?php echo list_more_included_blog_news(get_the_ID()); ?>
						</div>

               		<?php




					if (comments_open()) {
					echo single_post_comments_top($post->ID);
					
					comments_template(); 
					}
					 ?>
                </div>



            </div>
        </div>

	<?php
	endwhile;
endif;


get_footer();

?>