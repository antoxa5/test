<?php
$args['meta_query'] = array(
	'relation' => 'AND',
);
foreach ( $fields as $field ) {
	$key = get_term( $field['key'], 'field_types' )->slug;
	if ( $key == 'filter_top_bet' ) {
		$args['posts_per_page'] = 10;
	} elseif ( $key == 'filter_date' ) {
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
	} elseif ($key == 'filter_search_main') {
		$args['s'] = $field['value'];
	} elseif ($key == 'filter_special_freelance') {

		add_filter('posts_where', 'filter_meta_query_where'); //modify the where clause to filter meta data
		add_filter('posts_join' , 'filter_meta_join'); //join the meta table to the posts query
		if (!function_exists('filter_meta_query_where')) {
			function filter_meta_query_where($where = '')
			{
				global $wpdb;
				global $wp_query;
				global $sf_form_data;

				$array_terms_temp = [
					'Цифровой маркетинг',
					'реклама и маркетинг',
					'Музыка и аудио',
					'Копирайтинг',
					'Удаленная работа',
					'Перевод',
					'Работа с аудио и видео',
					'Разработка чертежей',
					'Программирование',
					'Инжиниринг',
					'Дизайн',
					'Дизайн',
					'Аутсорсинг и консалтинг',
					'Администрирование',
					'Арбитраж',
					'Веб-дизайн',
					'Контекстная реклама',
					'Копирайтинг',
					'Веб-программирование',
					'HTML-верстка',
					'Дизайн сайтов',
					'Разработка сайтов',
					'Наполнение сайтов',
					'SMM',
					'SEO-продвижение',
					'Написание научных работ',
					'Аудио и Мультимедиа',
					'Дизайн и Арт'
				];
				$array_terms = [];
				$array_text = '';
				foreach ($array_terms_temp as $item) {
					$num = get_term_by( 'name', $item, 'businessservices' )->term_id;
					$array_terms[] = $num;
					$array_text .= " OR wp_postmeta.meta_value = '".$num."'";

				}
				$array_text =  substr_replace($array_text, null, 0, 4);


				$where .= " AND (wp_postmeta.meta_key = 'earn_methods_1_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'earn_methods_2_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'earn_methods_3_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'earn_methods_4_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'earn_methods_5_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'earn_methods_6_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'earn_methods_7_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'earn_methods_8_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'earn_methods_9_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";


				return $where;
			}
		}

		if (!function_exists('filter_meta_join')) {
			function filter_meta_join( $join ) {
				global $wpdb;

				$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";

				return $join;
			}
		}
		$args_roll = array(
			'post_type'      => 'casino',
			'post_status' => array('publish'),
			'orderby'        => 'menu_order',
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => $tag,
				),
			),
		);
		$arr_test = [];
		$reviews_roll   = new WP_Query( $args_roll );
		if ( $reviews_roll->have_posts() ) {
			while ( $reviews_roll->have_posts() ) {
				$reviews_roll->the_post();
				$arr_test[] = get_the_ID();
			}

		}

		wp_reset_postdata();
		remove_filter('posts_where', 'filter_meta_query_where');
		remove_filter('posts_join' , 'filter_meta_join');
		$args['post__in'] = $arr_test;
	} elseif ($key == 'filter_special_like_cheat') {

		add_filter('posts_where', 'filter_meta_query_where1818191292941'); //modify the where clause to filter meta data
		add_filter('posts_join' , 'filter_meta_join1214012041204124'); //join the meta table to the posts query
		if (!function_exists('filter_meta_query_where1818191292941')) {
			function filter_meta_query_where1818191292941( $where = '' ) {
				global $wpdb;
				global $wp_query;
				global $sf_form_data;

				$array_terms_temp = [
					'Платная накрутка лайков',
					'Бесплатная накрутка лайков',
					'Накрутка лайков и просмотров',
					'Накрутка подписчиков',
					'Накрутка репостов',
					'Накрутка подписчиков на личную страницу, корпоративные аккаунты и группы',
					'Накрутка репостов и лайков на публикации',
					'Накрутка лайков',
					'Накрутка комментариев',
					'Покупка репостов',
				];
				$array_terms      = [];
				$array_text       = '';
				foreach ( $array_terms_temp as $item ) {
					$num           = get_term_by( 'name', $item, 'businessservices' )->term_id;
					$array_terms[] = $num;
					$array_text    .= " OR wp_postmeta.meta_value = '" . $num . "'";

				}
				$array_text = substr_replace( $array_text, null, 0, 4 );


				$where .= " AND (wp_postmeta.meta_key = 'services_promote_1_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_2_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_3_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_4_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_5_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_6_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_7_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_8_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_9_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";


				return $where;
			}
		}
		if (!function_exists('filter_meta_join1214012041204124')) {
			function filter_meta_join1214012041204124( $join ) {
				global $wpdb;

				$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";

				return $join;
			}
		}
		$args_roll = array(
			'post_type'      => 'casino',
			'post_status' => array('publish'),
			'orderby'        => 'menu_order',
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => $tag,
				),
			),
		);
		$arr_test = [];
		$reviews_roll   = new WP_Query( $args_roll );
		if ( $reviews_roll->have_posts() ) {
			while ( $reviews_roll->have_posts() ) {
				$reviews_roll->the_post();
				$arr_test[] = get_the_ID();
			}

		}

		wp_reset_postdata();
		remove_filter('posts_where', 'filter_meta_query_where1818191292941');
		remove_filter('posts_join' , 'filter_meta_join1214012041204124');
		$args['post__in'] = $arr_test;
	}  elseif ($key == 'filter_special_training_seo') {
		$args['post__in'] = array(132609,141412,143613,143586,131999,140732);
		//filter_special_training_seo
	}  elseif ($key == 'filter_special_premium') {
		$args['post__in'] = array(80965,41334,42652);
	}elseif ($key == 'filter_without_ndfl_workless') {

		add_filter('posts_where', 'filter_meta_query_where191919101042194124'); //modify the where clause to filter meta data
		add_filter('posts_join' , 'filter_meta_join11921491294124124124'); //join the meta table to the posts query
		if (!function_exists('filter_meta_query_where191919101042194124')) {
			function filter_meta_query_where191919101042194124( $where = '' ) {
				global $wpdb;
				global $wp_query;
				global $sf_form_data;

				$array_terms_temp = [
					'Справка 2-НДФЛ',
				];
				$array_terms      = [];
				$array_text       = '';
				foreach ( $array_terms_temp as $item ) {
					$num           = get_term_by( 'name', $item, 'businessservices' )->term_id;
					$array_terms[] = $num;
					$array_text    .= " AND wp_postmeta.meta_value != '" . $num . "'";

				}
				$array_text = substr_replace( $array_text, null, 0, 4 );

//documents_list_$_documents
				$where .= " AND (wp_postmeta.meta_key = 'documents_list_1_documents' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish') AND (wp_postmeta.meta_key = 'proof_of_income_0_exist' AND wp_postmeta.meta_value != 1)  )";
				$where .= " AND (wp_postmeta.meta_key = 'documents_list_2_documents' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish') AND (wp_postmeta.meta_key = 'proof_of_income_0_exist' AND wp_postmeta.meta_value != 1))";
				$where .= " AND (wp_postmeta.meta_key = 'documents_list_3_documents' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish') AND (wp_postmeta.meta_key = 'proof_of_income_0_exist' AND wp_postmeta.meta_value != 1))";
				$where .= " AND (wp_postmeta.meta_key = 'documents_list_4_documents' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish') AND (wp_postmeta.meta_key = 'proof_of_income_0_exist' AND wp_postmeta.meta_value != 1))";
				$where .= " AND (wp_postmeta.meta_key = 'documents_list_5_documents' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish') AND (wp_postmeta.meta_key = 'proof_of_income_0_exist' AND wp_postmeta.meta_value != 1))";
				$where .= " AND (wp_postmeta.meta_key = 'documents_list_6_documents' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish') AND (wp_postmeta.meta_key = 'proof_of_income_0_exist' AND wp_postmeta.meta_value != 1))";
				$where .= " AND (wp_postmeta.meta_key = 'documents_list_7_documents' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish') AND (wp_postmeta.meta_key = 'proof_of_income_0_exist' AND wp_postmeta.meta_value != 1))";
				$where .= " AND (wp_postmeta.meta_key = 'documents_list_8_documents' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish') AND (wp_postmeta.meta_key = 'proof_of_income_0_exist' AND wp_postmeta.meta_value != 1))";
				$where .= " AND (wp_postmeta.meta_key = 'documents_list_9_documents' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish') AND (wp_postmeta.meta_key = 'proof_of_income_0_exist' AND wp_postmeta.meta_value != 1))";


				return $where;
			}
		}
		if (!function_exists('filter_meta_join11921491294124124124')) {
			function filter_meta_join11921491294124124124( $join ) {
				global $wpdb;

				$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";

				return $join;
			}
		}
		$args_roll = array(
			'post_type'      => 'casino',
			'post_status' => array('publish'),
			'orderby'        => 'menu_order',
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => $tag,
				),
			),
		);
		$arr_test = [];
		$reviews_roll   = new WP_Query( $args_roll );
		if ( $reviews_roll->have_posts() ) {
			while ( $reviews_roll->have_posts() ) {
				$reviews_roll->the_post();
				$arr_test[] = get_the_ID();
			}

		}

		wp_reset_postdata();
		remove_filter('posts_where', 'filter_meta_query_where191919101042194124');
		remove_filter('posts_join' , 'filter_meta_join11921491294124124124');
		$args['post__in'] = $arr_test;
	} elseif ($key == 'filter_special_get_by_online') {
		add_filter('posts_where', 'filter_meta_query_where30101010101'); //modify the where clause to filter meta data
		add_filter('posts_join' , 'filter_meta_join318182842814'); //join the meta table to the posts query
		if (!function_exists('filter_meta_query_where30101010101')) {
			function filter_meta_query_where30101010101( $where = '' ) {
				global $wpdb;
				global $wp_query;
				global $sf_form_data;


				$where .= " AND (wp_postmeta.meta_key = 'pros_1_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%удаленно%' OR wp_postmeta.meta_value LIKE '%дистанционно%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_2_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%удаленно%' OR wp_postmeta.meta_value LIKE '%дистанционно%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_3_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%удаленно%' OR wp_postmeta.meta_value LIKE '%дистанционно%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_4_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%удаленно%' OR wp_postmeta.meta_value LIKE '%дистанционно%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_5_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%удаленно%' OR wp_postmeta.meta_value LIKE '%дистанционно%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_6_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%удаленно%' OR wp_postmeta.meta_value LIKE '%дистанционно%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_7_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%удаленно%' OR wp_postmeta.meta_value LIKE '%дистанционно%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_8_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%удаленно%' OR wp_postmeta.meta_value LIKE '%дистанционно%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_9_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%удаленно%' OR wp_postmeta.meta_value LIKE '%дистанционно%') AND (wp_posts.post_status = 'publish')    )";


				return $where;
			}
		}
		if (!function_exists('filter_meta_join318182842814')) {
			function filter_meta_join318182842814( $join ) {
				global $wpdb;

				$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";

				return $join;
			}
		}
		$args_roll = array(
			'post_type'      => 'casino',
			'post_status' => array('publish'),
			'orderby'        => 'menu_order',
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => 'rko',
				),
			),
		);
		$arr_test = [];
		$reviews_roll   = new WP_Query( $args_roll );
		if ( $reviews_roll->have_posts() ) {
			while ( $reviews_roll->have_posts() ) {
				$reviews_roll->the_post();
				$review_aff_tags = get_field('review_aff_tags',get_the_ID());

				if (is_array($review_aff_tags) && in_array(31, $review_aff_tags)) {
					//echo get_the_title();
					$arr_test[] = get_the_ID();
				}

			}

		}

		wp_reset_postdata();
		remove_filter('posts_where', 'filter_meta_query_where30101010101');
		remove_filter('posts_join' , 'filter_meta_join318182842814');
		$args['post__in'] = $arr_test;
	}elseif ($key == 'filter_special_unlimited_host') {
		add_filter('posts_where', 'filter_meta_query_where4'); //modify the where clause to filter meta data
		add_filter('posts_join' , 'filter_meta_join4'); //join the meta table to the posts query
		if (!function_exists('filter_meta_query_where4')) {
			function filter_meta_query_where4($where = '')
			{
				global $wpdb;
				global $wp_query;
				global $sf_form_data;




				$where .= " AND (wp_postmeta.meta_key = 'pros_1_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%безлимитный%' OR wp_postmeta.meta_value LIKE '%неограниченное дисковое%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_2_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%безлимитный%' OR wp_postmeta.meta_value LIKE '%неограниченное дисковое%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_3_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%безлимитный%' OR wp_postmeta.meta_value LIKE '%неограниченное дисковое%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_4_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%безлимитный%' OR wp_postmeta.meta_value LIKE '%неограниченное дисковое%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_5_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%безлимитный%' OR wp_postmeta.meta_value LIKE '%неограниченное дисковое%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_6_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%безлимитный%' OR wp_postmeta.meta_value LIKE '%неограниченное дисковое%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_7_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%безлимитный%' OR wp_postmeta.meta_value LIKE '%неограниченное дисковое%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_8_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%безлимитный%' OR wp_postmeta.meta_value LIKE '%неограниченное дисковое%') AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'pros_9_text' AND (wp_postmeta.meta_value LIKE '%онлайн%' OR wp_postmeta.meta_value LIKE '%безлимитный%' OR wp_postmeta.meta_value LIKE '%неограниченное дисковое%') AND (wp_posts.post_status = 'publish')    )";


				return $where;
			}
		}

		if (!function_exists('filter_meta_join4')) {
			function filter_meta_join4( $join ) {
				global $wpdb;

				$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";

				return $join;
			}
		}
		$args_roll = array(
			'post_type'      => 'casino',
			'post_status' => array('publish'),
			'orderby'        => 'menu_order',
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => 'hosting',
				),
			),
		);
		$arr_test = [];
		$reviews_roll   = new WP_Query( $args_roll );
		if ( $reviews_roll->have_posts() ) {
			while ( $reviews_roll->have_posts() ) {
				$reviews_roll->the_post();

				$review_aff_tags = get_field('review_aff_tags',get_the_ID());
				if (is_array($review_aff_tags) && in_array(654, $review_aff_tags)) {
					//echo get_the_title();
					$arr_test[] = get_the_ID();
				}

			}

		}

		wp_reset_postdata();
		remove_filter('posts_where', 'filter_meta_query_where4');
		remove_filter('posts_join' , 'filter_meta_join4');
		$args['post__in'] = $arr_test;
	}  elseif ($key == 'filter_special_traffic') {

		add_filter('posts_where', 'filter_meta_query_where1999999991'); //modify the where clause to filter meta data
		add_filter('posts_join' , 'filter_meta_join1124124214124124'); //join the meta table to the posts query
		if (!function_exists('filter_meta_query_where1999999991')) {
			function filter_meta_query_where1999999991( $where = '' ) {
				global $wpdb;
				global $wp_query;
				global $sf_form_data;

				$array_terms_temp = [
					'Обмен трафика',
					'Покупка трафика',
					'Покупка/ продажа трафика',
					'Покупка/продажа трафика',
					'Продажа трафика'
				];
				$array_terms      = [];
				$array_text       = '';
				foreach ( $array_terms_temp as $item ) {
					$num           = get_term_by( 'name', $item, 'businessservices' )->term_id;
					$array_terms[] = $num;
					$array_text    .= " OR wp_postmeta.meta_value = '" . $num . "'";

				}
				$array_text = substr_replace( $array_text, null, 0, 4 );


				$where .= " AND (wp_postmeta.meta_key = 'services_promote_1_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_2_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_3_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_4_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_5_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_6_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_7_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_8_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_9_services_list' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";


				return $where;
			}
		}
		if (!function_exists('filter_meta_join1124124214124124')) {
			function filter_meta_join1124124214124124( $join ) {
				global $wpdb;

				$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";

				return $join;
			}
		}
		$args_roll = array(
			'post_type'      => 'casino',
			'post_status' => array('publish'),
			'orderby'        => 'menu_order',
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => $tag,
				),
			),
		);
		$arr_test = [];
		$reviews_roll   = new WP_Query( $args_roll );
		if ( $reviews_roll->have_posts() ) {
			while ( $reviews_roll->have_posts() ) {
				$reviews_roll->the_post();
				$review_aff_tags = get_field('review_aff_tags',get_the_ID()); 
				if ( is_array( $review_aff_tags ) && in_array(665, $review_aff_tags) ) {
					$arr_test[] = get_the_ID();
				}

			}

		}

		wp_reset_postdata();
		remove_filter('posts_where', 'filter_meta_query_where1999999991');
		remove_filter('posts_join' , 'filter_meta_join1124124214124124');
		$args['post__in'] = $arr_test;
	}    elseif ($key == 'filter_special_min_dep') {

		add_filter('posts_where', 'filter_meta_query_where1999999991'); //modify the where clause to filter meta data
		add_filter('posts_join' , 'filter_meta_join1124124214124124'); //join the meta table to the posts query
		if (!function_exists('filter_meta_query_where1999999991')) {
			function filter_meta_query_where1999999991( $where = '' ) {
				global $wpdb;
				global $wp_query;
				global $sf_form_data;

				$array_terms_temp = [
					'rub'
				];
				$array_terms      = [];
				$array_text       = '';
				foreach ( $array_terms_temp as $item ) {
					$num           = get_term_by( 'name', $item, 'currencies' )->term_id;
					$array_terms[] = $num;
					$array_text    .= " OR wp_postmeta.meta_value = '" . $num . "'";

				}
				$array_text = substr_replace( $array_text, null, 0, 4 );


				$array_terms_temp2 = [
					'usd'
				];
				$array_terms2      = [];
				$array_text3       = '';
				foreach ( $array_terms_temp2 as $item ) {
					$num            = get_term_by( 'name', $item, 'currencies' )->term_id;
					$array_terms2[] = $num;
					$array_text3    .= " OR wp_postmeta.meta_value = '" . $num . "'";

				}
				$array_text3 = substr_replace( $array_text3, null, 0, 4 );


				$where .= " AND (wp_postmeta.meta_key = 'min_dep_1_currency' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'min_dep_2_currency' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'min_dep_3_currency' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'min_dep_4_currency' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'min_dep_5_currency' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'min_dep_6_currency' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";


				return $where;
			}
		}
		if (!function_exists('filter_meta_join1124124214124124')) {
			function filter_meta_join1124124214124124( $join ) {
				global $wpdb;

				$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";

				return $join;
			}
		}
		$args_roll = array(
			'post_type'      => 'casino',
			'post_status' => array('publish'),
			'orderby'        => 'menu_order',
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => $tag,
				),
			),
		);
		$arr_test = [];
		$reviews_roll   = new WP_Query( $args_roll );
		if ( $reviews_roll->have_posts() ) {
			while ( $reviews_roll->have_posts() ) {
				$reviews_roll->the_post();
				if (in_array(665,get_field('review_aff_tags',get_the_ID()))) {
					$arr_test[] = get_the_ID();
				}

			}

		}

		wp_reset_postdata();
		remove_filter('posts_where', 'filter_meta_query_where1999999991');
		remove_filter('posts_join' , 'filter_meta_join1124124214124124');
		$args['post__in'] = $arr_test;
	} elseif ($key == 'filter_special_rating_a') {

		add_filter('posts_where', 'filter_meta_query_where1'); //modify the where clause to filter meta data
		add_filter('posts_join' , 'filter_meta_join1'); //join the meta table to the posts query
		if (!function_exists('filter_meta_query_where1')) {
			function filter_meta_query_where1( $where = '' ) {
				global $wpdb;
				global $wp_query;
				global $sf_form_data;

				$array_terms_temp = [
					'ruAAA',
					'ruAA+',
					'AAA',
					'АА'
				];
				$array_terms      = [];
				$array_text       = '';
				foreach ( $array_terms_temp as $item ) {
					$num           = get_term_by( 'name', $item, 'ratingsafety' )->term_id;
					$array_terms[] = $num;
					$array_text    .= " OR wp_postmeta.meta_value = '" . $num . "'";

				}
				$array_text = substr_replace( $array_text, null, 0, 4 );


				$where .= " AND (wp_postmeta.meta_key = 'rating_a' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";

				/*$where .= " OR (wp_postmeta.meta_key = 'services_promote_2_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_3_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_4_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_5_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_6_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_7_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_8_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_9_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";*/


				return $where;
			}
		}
		if (!function_exists('filter_meta_join1')) {
			function filter_meta_join1( $join ) {
				global $wpdb;

				$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";

				return $join;
			}
		}
		$args_roll = array(
			'post_type'      => 'casino',
			'post_status' => array('publish'),
			'orderby'        => 'menu_order',
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => $tag,
				),
			),
		);
		$arr_test = [];
		$reviews_roll   = new WP_Query( $args_roll );
		if ( $reviews_roll->have_posts() ) {
			while ( $reviews_roll->have_posts() ) {
				$reviews_roll->the_post();
				if (in_array(16,get_field('review_aff_tags',get_the_ID()))) {
					$arr_test[] = get_the_ID();
				}

			}

		}

		wp_reset_postdata();
		remove_filter('posts_where', 'filter_meta_query_where1');
		remove_filter('posts_join' , 'filter_meta_join1');
		$args['post__in'] = $arr_test;
	}  elseif ($key == 'filter_special_dep_methods') {

		add_filter('posts_where', 'filter_meta_query_where1325235'); //modify the where clause to filter meta data
		add_filter('posts_join' , 'filter_meta_join12353252353'); //join the meta table to the posts query
		if (!function_exists('filter_meta_query_where1325235')) {
			function filter_meta_query_where1325235( $where = '' ) {
				global $wpdb;
				global $wp_query;
				global $sf_form_data;

				$array_terms_temp = [
					'Банковская карта (Visa/MC)',
					'Банковская карта',
					'Банковская карта (Visa/Mastercard/Maestro)',
					'Банковская карта (Visa/MC/МИР)',
					'VISA',
					'МИР',
					'Maestro',
					'Mastercard'
				];
				$array_terms      = [];
				$array_text       = '';
				foreach ( $array_terms_temp as $item ) {
					$num           = get_term_by( 'name', $item, 'paymentmethods' )->term_id;
					$array_terms[] = $num;
					$array_text    .= " OR wp_postmeta.meta_value LIKE '%\"" . $num . "\"%'";

				}
				$array_text = substr_replace( $array_text, null, 0, 4 );


				$where .= " AND (wp_postmeta.meta_key = 'deposit_methods' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";

				/*$where .= " OR (wp_postmeta.meta_key = 'services_promote_2_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_3_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_4_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_5_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_6_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_7_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_8_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_9_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";*/


				return $where;
			}
		}
		if (!function_exists('filter_meta_join12353252353')) {
			function filter_meta_join12353252353( $join ) {
				global $wpdb;

				$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";

				return $join;
			}
		}
		$args_roll = array(
			'post_type'      => 'casino',
			'post_status' => array('publish'),
			'orderby'        => 'menu_order',
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => $tag,
				),
			),
		);
		$arr_test = [];
		$reviews_roll   = new WP_Query( $args_roll );
		if ( $reviews_roll->have_posts() ) {
			while ( $reviews_roll->have_posts() ) {
				$reviews_roll->the_post();
				if (in_array(get_term_by( 'name', $tag, 'affiliate-tags' )->term_id,get_field('review_aff_tags',get_the_ID()))) {
					$arr_test[] = get_the_ID();
				}

			}

		}

		wp_reset_postdata();
		remove_filter('posts_where', 'filter_meta_query_where1325235');
		remove_filter('posts_join' , 'filter_meta_join12353252353');
		$args['post__in'] = $arr_test;
	}     elseif ($key == 'filter_special_withdrawal_methods') {

		add_filter('posts_where', 'filter_meta_query_where333353'); //modify the where clause to filter meta data
		add_filter('posts_join' , 'filter_meta_join353532523522353'); //join the meta table to the posts query
		if (!function_exists('filter_meta_query_where333353')) {
			function filter_meta_query_where333353( $where = '' ) {
				global $wpdb;
				global $wp_query;
				global $sf_form_data;

				$array_terms_temp = [
					'Банковская карта (Visa/MC)',
					'Банковская карта',
					'Банковская карта (Visa/Mastercard/Maestro)',
					'Банковская карта (Visa/MC/МИР)',
					'VISA',
					'МИР',
					'Maestro',
					'Mastercard'
				];
				$array_terms      = [];
				$array_text       = '';
				foreach ( $array_terms_temp as $item ) {
					$num           = get_term_by( 'name', $item, 'paymentmethods' )->term_id;
					$array_terms[] = $num;
					$array_text    .= " OR wp_postmeta.meta_value LIKE '%\"" . $num . "\"%'";

				}
				$array_text = substr_replace( $array_text, null, 0, 4 );


				$where .= " AND (wp_postmeta.meta_key = 'withdrawal_methods' AND (" . $array_text . ") AND (wp_posts.post_status = 'publish')    )";

				/*$where .= " OR (wp_postmeta.meta_key = 'services_promote_2_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_3_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_4_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_5_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_6_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_7_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_8_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";
				$where .= " OR (wp_postmeta.meta_key = 'services_promote_9_services_list' AND (".$array_text.") AND (wp_posts.post_status = 'publish')    )";*/


				return $where;
			}
		}
		if (!function_exists('filter_meta_join353532523522353')) {
			function filter_meta_join353532523522353( $join ) {
				global $wpdb;

				$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";

				return $join;
			}
		}
		$args_roll = array(
			'post_type'      => 'casino',
			'post_status' => array('publish'),
			'orderby'        => 'menu_order',
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => $tag,
				),
			),
		);
		$arr_test = [];
		$reviews_roll   = new WP_Query( $args_roll );
		if ( $reviews_roll->have_posts() ) {
			while ( $reviews_roll->have_posts() ) {
				$reviews_roll->the_post();
				if (in_array(get_term_by( 'name', $tag, 'affiliate-tags' )->term_id,get_field('review_aff_tags',get_the_ID()))) {
					$arr_test[] = get_the_ID();
				}

			}

		}

		wp_reset_postdata();
		remove_filter('posts_where', 'filter_meta_query_where333353');
		remove_filter('posts_join' , 'filter_meta_join353532523522353');
		$args['post__in'] = $arr_test;
	}    elseif ($key == 'filter_min_dep_owa') {



		$args_roll = array(
			'post_type'      => 'casino',
			'post_status' => array('publish'),
			'orderby'        => 'menu_order',
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'affiliate-tags',
					'field'    => 'name',
					'terms'    => $tag,
				),
			),
		);
		$arr_test = [];
		$reviews_roll   = new WP_Query( $args_roll );
		if ( $reviews_roll->have_posts() ) {
			while ( $reviews_roll->have_posts() ) {
				$reviews_roll->the_post();
				$get_the_ID = get_the_ID();
				if (in_array(get_term_by( 'name', $tag, 'affiliate-tags' )->term_id,get_field('review_aff_tags',$get_the_ID))) {
					if ( (get_field('min_dep_1_from',$get_the_ID) <= 10)  ) {
						$arr_test[] = $get_the_ID;
					}
				}

			}

		}

		wp_reset_postdata();

		$args['post__in'] = $arr_test;
	}
}
$args['meta_query'][] = get_more_fields_company($args,$fields);
$arr_post_temp = [];
?>