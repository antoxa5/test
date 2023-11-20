<?php
$request = explode('/', $_SERVER['REQUEST_URI']);
if ($request[2] != get_post_field( 'post_name', get_field('addpage_review') )) {
	$wp_query->set_404();
	status_header( 404 );
	nocache_headers();
	include("404.php");
	die;
}
$review_id = get_field('addpage_review',$post->ID);
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
wp_enqueue_script( 'get-ad-text', get_template_directory_uri() . '/js/get-ad-text.js', array( 'jquery' ), '10.136'  );//
if (have_posts()) :
        while (have_posts()) : the_post();
		$review_id = get_field('addpage_review',$post->ID);
		echo review_top($review_id);
		wp_enqueue_script( 'progressbar', get_template_directory_uri() . '/js/progressbar.js', array('jquery'), $special_word.filemtime(TEMPLATEPATH . '/js/progressbar.js') );
		wp_enqueue_script( 'review_ajax_content', get_template_directory_uri() . '/js/promocode_ajax_content.js', array('jquery'), $special_word.filemtime(TEMPLATEPATH . '/js/promocode_ajax_content.js') );
        wp_enqueue_script( 'promocode_load', get_template_directory_uri() . '/js/promocode_load.js', array('jquery'),$special_word );
		wp_enqueue_script( 'review_top', get_template_directory_uri() . '/js/review_top.js', array('jquery'),$special_word );
		echo print_css_links('review_content');
	        $cur_user_id = get_current_user_id();
	        if (($cur_user_id == 22968) || ($cur_user_id == 17) || ($cur_user_id == 1) || ($cur_user_id == 31) || ($cur_user_id == 18627) ) { ?>
                <div class="active_fixed_page__single_review_2 active_fixed_page__single_addpage page_content page_container background_light review_container_actions single_container visible">
	        <?php } else {  ?>
                <div class="active_fixed_page__single_review_2 active_fixed_page__single_addpage page_content page_container background_light review_container_actions single_container visible">
	        <?php }
	        ?>
		

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
					echo show_add_links($post->ID);
				?>
				<?php 
					
					$content = apply_filters( 'the_content', get_the_content() ); 
					if($content != '') {
					?>
						<?php
							$curr_language_get = get_locale();
						?>
				<div class="single_promocode_content_text white_block">
						<h1><?php the_title(); ?></h1>
						<?php if(!get_field('er_pixel_disable',$review_id)) { ?><img src="<?php bloginfo('url'); ?>/visit/<?php echo get_field('company_redirect_key',$review_id);?>/?view=true" data-lazy-src="<?php bloginfo('url'); ?>/visit/<?php echo get_field('company_redirect_key',$review_id);?>/" class="er_pixel" alt="" /><?php }; ?>

					<?php
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
						<?php
						if ( $curr_language_get == 'ru_RU' ) {
							if ( get_field( 'widget_social', $post->ID ) == 'stoyuristov' ) {
								if ( get_field( 'turn_off_stoyuristov', $post->ID ) == 1 ) {

								} else {
								}
							}
							if ( get_field( 'widget_social', $post->ID ) == 'svoywidgetmain' ) {
								if ( get_field( 'svoywidget', $post->ID ) ) {
									echo '<div class="mywidgetm" data-id="'.sanitize_text_field(get_field( 'svoywidget', $post->ID )).'">'.get_field( 'svoywidget', $post->ID ).'</div>';
								}
							}
						} ?>
                <div class="comment_addpages">
	                <?php
	                echo single_post_comments_top($post->ID);
	                comments_template();
	                ?>
                </div>
				<?php }; ?>		
				
				<div class="list_more_container">
					<?=list_more_included($review_id)?>
				</div>
				</div>
				<div class="container_side flex flex_column">
                    <div class="main_button_desktop flex flex_column">
                        <?php
                        if(function_exists('review_block_main_button_replace_no_affilate')) {
	                        echo $review_block_main_button_replace_no_affilate;
                        }
                        ?>
						<div class="data-ad" data-main-post-id="<?php echo $review_id; ?>"></div>
                    </div>
					<?php echo widget_company_in_ratings($review_id); ?>
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