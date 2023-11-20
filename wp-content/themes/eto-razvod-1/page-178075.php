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

if (have_posts()) :
	while (have_posts()) : the_post();
$page_rate_count = get_field('page_rate_count',$post->ID);

		?>
        <div class="page_content page_container review_container_content single_container visible single_news" <?php if($page_rate_count && $page_rate_count != 0 && $page_rate_count != '') { ?>itemprop="itemReviewed" itemscope itemtype="https://schema.org/Product"<?php } ?>>
            <div class="wrap flex_column">
				<?php echo show_breadcrumbs(); ?>
				<?php echo print_css_links('review_content') ?>
                <div class="the_content color_dark_blue">
                    <h1 class="m_b_30" itemprop="name"><?php the_title(); ?></h1>
					
					<?php the_content(); ?>
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