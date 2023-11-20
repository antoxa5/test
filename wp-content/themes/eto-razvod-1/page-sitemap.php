<?php
get_header();

if (have_posts()) :
        while (have_posts()) : the_post();
		
			
		?>
		<div class="page_content page_container review_container_content single_container visible single_news">
			<div class="wrap flex_column">
			<?php echo show_breadcrumbs(); ?>
			<?php echo print_css_links('review_content') ?>
				<div class="the_content color_dark_blue">
					<h1 class="m_b_30"><?php the_title(); ?></h1>
					<h2>Обзоры</h2>

		<?php

        $current_language = get_locale();
        if($current_language != 'ru_RU') {
            $args_reviews = array(
                'posts_per_page' => 500,
                'post_type' => array('casino'),
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'enable_translations',
                        'value' => $current_language,
                        'compare' => 'LIKE'
                    )
                )
            );
            $query = new WP_Query( $args_reviews );
            if($query->have_posts()) {
                echo '<ul>';
            while ( $query->have_posts() ) {
                $query->the_post();

                ?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
            }
                echo '</ul>';
            }
            wp_reset_postdata();

            ?>

            <?php
            $args_promocats = array(
                'posts_per_page' => -1,
                'post_type' => array('promocodes_cats'),
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'enable_translations',
                        'value' => $current_language,
                        'compare' => 'LIKE'
                    )
                )
            );
            $query_promocats = new WP_Query( $args_promocats );
            if($query_promocats->have_posts()) {
                echo '<h2>Категории промокодов</h2><ul>';
            while ( $query_promocats->have_posts() ) {
                $query_promocats->the_post();

                ?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
            }
                echo '</ul>';
            } wp_reset_postdata();
            $args_posts = array(
                'posts_per_page' => -1,
                'post_type' => array('post'),
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'enable_translations',
                        'value' => $current_language,
                        'compare' => 'LIKE'
                    )
                )
            );
            $query_posts = new WP_Query( $args_posts );
            if($query_posts->have_posts()) {
                echo '<h2>Статьи</h2><ul>';
                while ( $query_posts->have_posts() ) {
                    $query_posts->the_post();

                    ?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
                }
                echo '</ul>';
            } wp_reset_postdata();
        } else {


		 $query = new WP_Query( [ 'post_type' => 'casino', 'posts_per_page' => '500', 'turn_off_on_ru_language' => 1 ] ); ?>
		<ul>
		 <?php
		 while ( $query->have_posts() ) {
			$query->the_post();

			?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
		} wp_reset_postdata();?>

				<?php
		 $query_r2 = new WP_Query( [ 'post_type' => 'casino', 'posts_per_page' => '500', 'offset' => '500', 'turn_off_on_ru_language' => 1 ] ); ?>
		 
		 <?php
		 while ( $query_r2->have_posts() ) {
			$query_r2->the_post();

			?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
		} wp_reset_postdata();?>
				<?php
		 $query_r3 = new WP_Query( [ 'post_type' => 'casino', 'posts_per_page' => '500', 'offset' => '1000', 'turn_off_on_ru_language' => 1 ] ); ?>
		 
		 <?php
		 while ( $query_r3->have_posts() ) {
			$query_r3->the_post();

			?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
		} wp_reset_postdata();?>
				<?php
		 $query_r4 = new WP_Query( [ 'post_type' => 'casino', 'posts_per_page' => '500', 'offset' => '1500', 'turn_off_on_ru_language' => 1 ] ); ?>
		 
		 <?php
		 while ( $query_r4->have_posts() ) {
			$query_r4->the_post();

			?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
		} wp_reset_postdata();?>
				<?php
		 $query_r5 = new WP_Query( [ 'post_type' => 'casino', 'posts_per_page' => '500', 'offset' => '2000', 'turn_off_on_ru_language' => 1 ] ); ?>
		 
		 <?php
		 while ( $query_r5->have_posts() ) {
			$query_r5->the_post();

			?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
		} wp_reset_postdata();?>
					</ul>
      <h2>Дополнительная информация по компаниям</h2>
      <ul>
    <?php
        global $wpdb;

        $companies_with_news = $wpdb->get_results( "
            SELECT DISTINCT pm1.`meta_value` AS name, pm2.`meta_value` AS slug
            FROM `{$wpdb->prefix}postmeta` AS pm1 LEFT JOIN `{$wpdb->prefix}postmeta` AS pm2
            ON pm1.`post_id`=pm2.`post_id`
            WHERE 
                pm1.`meta_key` = 'company_name' AND 
                pm1.`meta_value` <> '' AND 
                pm2.`meta_key` = 'company_redirect_key' AND 
                pm1.`post_id` IN (
                    SELECT DISTINCT `meta_value` FROM `{$wpdb->prefix}postmeta` 
                    WHERE `meta_key` = 'news_for_company_id' AND `meta_value` <> ''
                ) AND
                pm1.`post_id` NOT IN (
                	SELECT post_id FROM `{$wpdb->prefix}postmeta` WHERE `meta_key`='turn_off_on_ru_language' AND `meta_value` = 'yes'
                )" );


        foreach( $companies_with_news as $company ) {

            ?><li><a href="/review/<?php echo $company->slug; ?>/news/"><?php echo $company->name; ?> новости</a></li><?php

        }

    ?>
       <?php
		 $query2 = new WP_Query( [ 'post_type' => 'addpages', 'posts_per_page' => '3000', 'turn_off_on_ru_language' => 1 ] ); ?>
		 
		 <?php
		 while ( $query2->have_posts() ) {
			$query2->the_post();

			?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
		} wp_reset_postdata();?>
					</ul>
                    <?php the_content(); ?>
                    
       <h2>Категории промокодов</h2>
       <ul>
       <?php
		 $query3 = new WP_Query( [ 'post_type' => 'promocodes_cats', 'posts_per_page' => '3000', 'turn_off_on_ru_language' => 1 ] ); ?>
		 
		 <?php
		 while ( $query3->have_posts() ) {
			$query3->the_post();

			?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
		} wp_reset_postdata();?>
					</ul>
       <h2>Промокоды компаний</h2>
       <ul>
       <?php
		 $query4 = new WP_Query( [ 'post_type' => 'promocodes', 'posts_per_page' => '500', 'turn_off_on_ru_language' => 1 ] );

		 ?>
		 
		 <?php
		 while ( $query4->have_posts() ) {
			$query4->the_post();

			?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
		} wp_reset_postdata();
         $query5 = new WP_Query( [ 'post_type' => 'promocodes', 'posts_per_page' => '500', 'offset' => '500', 'turn_off_on_ru_language' => 1 ] );
         while ( $query5->have_posts() ) {
             $query5->the_post();

             ?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
         } wp_reset_postdata();

         $query6 = new WP_Query( [ 'post_type' => 'promocodes', 'posts_per_page' => '500', 'offset' => '1000', 'turn_off_on_ru_language' => 1 ] );
         while ( $query6->have_posts() ) {
             $query6->the_post();

             ?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
         } wp_reset_postdata();

         $query7 = new WP_Query( [ 'post_type' => 'promocodes', 'posts_per_page' => '500', 'offset' => '1500', 'turn_off_on_ru_language' => 1 ] );
         while ( $query7->have_posts() ) {
             $query7->the_post();

             ?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
         } wp_reset_postdata();

         $query8 = new WP_Query( [ 'post_type' => 'promocodes', 'posts_per_page' => '500', 'offset' => '2000', 'turn_off_on_ru_language' => 1 ] );
         while ( $query8->have_posts() ) {
             $query8->the_post();

             ?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
         } wp_reset_postdata();

         $query9 = new WP_Query( [ 'post_type' => 'promocodes', 'posts_per_page' => '500', 'offset' => '2500', 'turn_off_on_ru_language' => 1 ] );
         while ( $query9->have_posts() ) {
             $query9->the_post();

             ?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
         } wp_reset_postdata();

         $query10 = new WP_Query( [ 'post_type' => 'promocodes', 'posts_per_page' => '500', 'offset' => '3000', 'turn_off_on_ru_language' => 1 ] );
         while ( $query10->have_posts() ) {
             $query10->the_post();

             ?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li><?php
         } wp_reset_postdata();
         }
		 ?>
					</ul>
				</div>
		
						
					
			</div>
		</div>
		
		<?php
		endwhile;
endif;


get_footer();

?>