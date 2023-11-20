<?php
/*
Template Name: Rating
*/
wp_localize_script( 'jquery', 'meta_page',
	array( 'affiliate_tags' => get_term( intval( get_field( 'rating_tag', $post->ID ) ), 'affiliate-tags' )->slug ) );
get_header();

if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		$tag_term = get_term( get_field( 'rating_tag' ), 'affiliate-tags' );
		$tag      = $tag_term->slug;
		$fields   = get_field( 'more_fields' );

		if ( ! $fields || $fields = '' ) {
			$fields = array();
		}
		wp_enqueue_style( 'rating', get_template_directory_uri() . '/css/rating.css', '', '1.10.482' );
        wp_enqueue_script( 'rating_table', get_template_directory_uri() . '/js/rating_table.js', array( 'jquery' ), '10.127'  );
        wp_enqueue_script( 'filter_table', get_template_directory_uri() . '/js/filter_table.js', array( 'jquery' ), '10.130'  );
		echo page_top( $post->ID, 'rating' );
		echo rating_icons( $post->ID, $tag_term->term_id );
		echo print_js_links()['show_block'];
		echo print_css_links( 'show_block' );
		wp_enqueue_script( 'progressbar', get_template_directory_uri() . '/js/progressbar.js', array( 'jquery' ) );
        if(function_exists('sa_rating_filters')) {
            echo sa_rating_filters($tag_term);
        }
		?>

		<div class="page_content page_container background_light rating_container visible template_rating">
			<div class="wrap flex_column if_<?= $tag ?>">
				<?php
				if ( $tag == 'courses' ) {
					$tag = 'courses2';
				}

				echo rating_table_default( $tag, $fields );
				?>
				<?php $content = apply_filters( 'the_content', get_the_content() );
				if ( $content != '' ) {
					?>
					<div class="the_content">
						<?php the_content(); ?>

					</div>

					<div class="color_dark_gray font_small link_review_map link_dropdown link_inactive show_block"
						 data-block=".the_content" data-type="swipeDown">Читать полностью
					</div>
				<?php }; ?>

			</div>
		</div>
		<?php
		$current_language = get_locale();
		if ( $current_language == 'ru_RU' ) {
			?>

			<div id="er_block_list_more-block_6086bb1d29be0" class="er_block_list_more  background_light">
				<div class="wrap flex_wrap">
					<div class="flex_100 font_smaller_2 font_bolder font_uppercase color_dark_blue m_b_30">Похожие
						рейтинги
					</div>
					<?php

					echo rating_table_similar();

					?>
				</div>
			</div>
			<?php
		}

	endwhile;
endif;
get_footer();
?>