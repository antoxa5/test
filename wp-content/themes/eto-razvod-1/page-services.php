<?php
set_query_var( 'dashboard_type', 'dashboard_services' );
set_query_var( 'dashboard_breadcrumb_name', 'Сервисы' );
$current_user = wp_get_current_user();
$user_id      = $current_user->data->ID;
set_query_var( 'user_id', $user_id );
wp_localize_script( 'jquery', 'dashboard_var', array( '1', '1' ) );
if ( ! ( is_user_logged_in() ) ) {
	wp_redirect( '/' );
	exit;
}
get_header();
if ($user_id == 17444) {
	$url = "https://etorazvod.ru/wp-content/themes/eto-razvod-1/aaa.php?1";
	$json = file_get_contents($url);
	$data = json_decode($json, true);
	echo $_GET['a'];
	if (!empty($_GET['a'])) {
		$data_t = array_slice($data, 100, 30);

		foreach (  $data_t as $item_1 ) {
			$comment_ID = wp_insert_comment( wp_slash($item_1[0]) );
			foreach ( $item_1[1] as $key => $item ) {
				update_field($key,$item,'comment_'.$comment_ID);
			}
			update_field('test_id',4000,'comment_'.$comment_ID);
			echo 'https://etorazvod.ru/wp-admin/comment.php?action=editcomment&c='.$comment_ID.'<br>';
		}
	}
}


if ($user_id == 1754325235235535) {
	
	/*$arr = [ 'bi', 'fx', 'demofx', 'fx-cbr', 'fx-nbrb', 'crofr'];*/
	$arr = ['game'];
	foreach ($arr  as $item333 ) {
		$args = array(
			'posts_per_page' => -1,
			'post_type' => ['casino'],
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => $item333,
				),
			),
		);
		
		$query = new WP_Query( $args );
		
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$review_aff_tags_text = '';
				$review_aff_tags = get_field('review_aff_tags',get_the_ID());
				foreach ($review_aff_tags  as $item ) {
					$tag_term = get_term( $item, 'affiliate-tags' );
					$tag = $tag_term->slug;
					$review_aff_tags_text .= $tag.',';
				}
				$a = get_the_ID();


				//update_field( 'turn_off_on_ru_language', 'yes' );
				?>
				<li><?php echo get_the_permalink(); ?><?php print_r(get_field('enable_translations'))?></li>
				<?php


				$add_pages_query = new WP_Query( array(
					'post_type'  => 'addpages',
					'meta_query' => array(
						array(
							'key'     => 'addpage_review',
							'value'   => $a,
							'compare' => '='
						)
					)
				
				) );
				while ( $add_pages_query->have_posts() ) {
					$add_pages_query->the_post();
					//update_field( 'turn_off_on_ru_language', 'yes' );
					?>
					<li><?php echo get_the_permalink(); ?><?php print_r(get_field('enable_translations'))?></li>
				<?php }
				wp_reset_postdata();
				
				$add_pages_query = new WP_Query( array(
					'post_type'  => 'promocodes',
					'meta_query' => array(
						array(
							'key'     => 'promocode_review',
							'value'   => $a,
							'compare' => '='
						)
					)
				
				) );
				while ( $add_pages_query->have_posts() ) {
					$add_pages_query->the_post();
					//update_field( 'turn_off_on_ru_language', 'yes' );
					?>
					<li><?php echo get_the_permalink(); ?><?php print_r(get_field('enable_translations'))?></li>
				<?php }
				wp_reset_postdata();
				
				
				$add_pages_query = new WP_Query( array(
					'post_type'  => 'single',
					'meta_query' => array(
						array(
							'key'     => 'news_for_company_id',
							'value'   => $a,
							'compare' => '='
						)
					)
				
				) );
				while ( $add_pages_query->have_posts() ) {
					$add_pages_query->the_post();
					//update_field( 'turn_off_on_ru_language', 'yes' );
					?>
					<li><?php echo get_the_permalink(); ?><?php print_r(get_field('enable_translations'))?></li>
				<?php }
				wp_reset_postdata();
				
			}
		}
		
		wp_reset_postdata();
	}
wp_reset_postdata();
	foreach ( $arr as $item444 ) {
		$b = get_term_by( 'slug', $item444, 'affiliate-tags' );;
		
		$args = array(
			'post_type' => array('post','page'),
			'posts_per_page' => -1,
			'meta_query' => array(
				'relation'		=> 'AND',
				array(
					'key' => 'er_post_tags',
					'value' => serialize(strval($b->term_id)),
					'compare' => 'LIKE'
				)
			)
		);
		$news = new WP_Query($args);
		
		if ( $news->have_posts() ) {
			while ( $news->have_posts() ) {
				$news->the_post();
				//update_field( 'turn_off_on_ru_language', 'yes' );
				?>
				<li><?php echo get_the_permalink(); ?><?php print_r(get_field('enable_translations'))?></li>
				<?php
			}
		}
		wp_reset_postdata();
	}
}
if ($user_id == 1235235235235235733) {
	if (get_field('banner_posts_ignore',240519)) {
		print_r(get_field('banner_posts_ignore',240519));
	}
	
	$args = array(
		'posts_per_page' => -1,
		'post_type'=> array('promocodes'),
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key'		=> 'promocodes_items_$_system',
				'compare'	=> '=',
				'value'		=> 'advcake',
			)
		)
	
	);
	$the_query_company_promo_args = new WP_Query( $args );
	if ( $the_query_company_promo_args->have_posts() ) {
		while ( $the_query_company_promo_args->have_posts() ) {
			$the_query_company_promo_args->the_post();
			global $post;
			$promocodes = array();
			$promocodes_items =  get_field('promocodes_items',get_the_ID());
			$i = 0;
			foreach ($promocodes_items  as $item ) {
				++$i;
				if ( ( strtotime( $item['date_end'] ) <= strtotime( date( 'Y-m-d', strtotime( '-1 days' ) ) ) ) && (strtotime( $item['date_end'] ) != '' ) ) {
					delete_row('promocodes_items', $i, get_the_ID());
				}
			}
			
		}
	}
	wp_reset_postdata();
	
	//echo wp_trim_words( get_comment_text(59676), 18, '' );
	/*$client_id = 'fVQdfpYvEIbgqBX7q0wMCVVA87J6jG';
	$client_secret = 'P8gKXvNl34bB5VhVPVd9tFkenV7jfu';
	$auth_token = base64_encode("$client_id:$client_secret");
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.admitad.com/token/",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => "grant_type=client_credentials&client_id=$client_id&scope=advcampaigns banners websites advcampaigns_for_website",
		CURLOPT_HTTPHEADER => array(
			"Authorization: Basic $auth_token"
		),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		echo $response;
	}*/
	/*$item = get_field( 'affiliate_program_0_link', 235322 );
	print_r($item);*/
	/*if ($item) {
		$i = 0;
		foreach ($item  as $item3 ) {
			$i = ++$i;
			if (count($item) == $i) {
				$result3 .= count($item).$i.get_term_by( 'id', $item3, 'gamegenres' )->name.'';
			} else {
				$result3 .= count($item).$i.get_term_by( 'id', $item3, 'gamegenres' )->name.', ';
			}
			
		}
	}
	echo $result3;
	print_r(get_field( 'pros_4', 235322 ));*/
}
?>
<?php if ( is_user_logged_in() ) {
	echo user_dashboard_services();
}
get_footer( 'profile' );
?>
