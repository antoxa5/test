<?php
if(!is_singular('post')) {
    // force 404
    $wp_query->set_404();
    status_header( 404 );
    nocache_headers();
    include("404.php");
    die;
}

get_header();

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
                        <div class="single_review_date font_small color_dark_gray"><?php echo get_the_date('j F Y'); ?> <?php _e('года','er_theme'); ?></div>
                        <div class="review_icon_share pointer m_l_15" data-type="share_post" data-id="<?php echo $post->ID; ?>"></div>
                    </div>
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
					<?php
					if ( $curr_language_get == 'ru_RU' ) {
						if ( get_field( 'widget_social', $post->ID ) == 'stoyuristov' ) {
							if ( get_field( 'turn_off_stoyuristov', $post->ID ) == 1 ) {

							} else {
							}
						}
					} ?>
					<?php 
					echo single_post_comments_top($post->ID);
					comments_template(); ?>
				</div>
		
						
					
			</div>
		</div>
		
		<?php
		endwhile;
endif;


get_footer();

?>