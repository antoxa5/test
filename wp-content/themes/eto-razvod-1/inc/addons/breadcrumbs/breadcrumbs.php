<?php

if (!function_exists('show_breadcrumbs')) {

    function show_breadcrumbs($uselink = 0,$news_cat = '') {
        $current_language = get_locale();
        if($current_language == 'ru_RU') {
            $otzyv_n = 'Отзыв №';
        } else {
            $otzyv_n = 'Review №';
        }
        $delimiter = '&#187;';
        $name = __('Главная', 'er_theme'); //text for the 'Home' link
        $currentBefore = '<span class="current_crumb">';
        $currentAfter = '</span>';
		$result = '';
        if ( is_search() ) {
            $result .= '<div class="breadcrumb">';
            $result .= '<a href="' . get_bloginfo('url') . '">' . $name . '</a> ' . $delimiter . ' ';

            if(isset($_REQUEST['s']) && $_REQUEST['s'] !='') {
                $result .= $currentBefore.'Результаты поиска по запросу: ' . get_search_query().$currentAfter;
            } elseif(isset($_REQUEST['s']) && $_REQUEST['s'] =='' && isset($_REQUEST['page']) && $_REQUEST['page'] == 'company') {
                $result .= $currentBefore.'Поиск по компаниям'.$currentAfter;
            } else {
                $result .= $currentBefore.'Поиск по сайту'.$currentAfter;
            }


            $result .= '</div>';
        } else {

            if (!is_home() && !is_front_page() || is_paged()) {

                $result .= '<div class="breadcrumb review_breadcrumbs color_medium_gray font_smaller_2" itemscope="" itemtype="https://schema.org/BreadcrumbList">';

                global $post;
                $home = get_bloginfo('url');
                if (!get_query_var('dashboard_type')) {
	                $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="1" />
<a itemprop="item" href="' . $home . '"><span itemprop="name">' . $name . '</span></a></span> ' . $delimiter . ' ';
                }


	            if ( get_query_var('dashboard_type') ) {
		            if ($uselink == 0) {
			            $currentBefore = '<div class="link_no_underline dashboard-breadcrumbs color_dark_gray flex"><span class="dashboard-breadcrumbs__arrow"></span><span class="dashboard-breadcrumbs__name">';
			            $currentAfter = '</span></div>';
		            } else {
			            $currentBefore = '<a href="/dashboard/" class="link_no_underline dashboard-breadcrumbs color_dark_gray flex"><span class="dashboard-breadcrumbs__arrow"></span><span class="dashboard-breadcrumbs__name">';
			            $currentAfter = '</span></a>';
		            }


		            $result .= $currentBefore;
		            $result .= get_query_var('dashboard_breadcrumb_name');
		            $result .= $currentAfter;

	            } elseif ( get_post_type() == 'casino' || get_post_type() == 'promocodes' && !is_post_type_archive('promocodes') || get_post_type() == 'promocodes_cats' || get_post_type() == 'addpages' ) {

                    if (get_post_type() == 'promocodes_cats') {

                        $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="2" />
<a itemprop="item" href="' . $home . '/promocode/"><span itemprop="name">' . __('Промокоды', 'er_theme') . '</span></a></span> ' . $delimiter . ' ';

                        // $result .= '<a href="' . $home . '/promocode/">';
                        // $result .= 'Промокоды';
                        // $result .= '</a>';
                        // $result .= ' &raquo; ';
                    }

                    if (get_post_type() == 'addpages') {
                        $review_id = get_field('addpage_review');

	                    $cur_terms = get_field('review_aff_tags',$review_id);
	                    if (gettype($cur_terms) == 'array') {
		                    //print_r($cur_terms[0]);
		                    $term_id = $cur_terms[0];
		                    //echo $term_id;

		                    if ($term_id) {
			                    foreach ($cur_terms as $item) {
				                    $rating_link = get_field('er_bc_link', 'term_' . $item);
				                    /*if(!get_field('er_bc_link','term_'.$item) || !get_field('er_bc_text','term_'.$item) ) {
										continue;
									}*/
				                    if (get_field('tag_human_title', 'term_' . $item) && $rating_link != '') {
										$result .= '<a href="' . get_bloginfo('url') . '/ratings/">' . __('Рейтинги', 'er_theme') . '</a> ' . $delimiter . ' ';
					                    $result .= '<a href="' . $rating_link . '">';
					                    $result .= get_field('er_bc_text', 'term_' . $item);
					                    $result .= '</a>';
					                    $result .= ' &#187; ';
					                    break;
				                    }
			                    }
		                    }
	                    } else {
		                    $cur_terms = get_the_terms($review_id, 'affiliate-tags');
		                    //print_r($cur_terms[0]);
		                    $term_id = $cur_terms[0]->slug;


		                    if ($term_id) {
			                    foreach ($cur_terms as $term) {
				                    if (!get_field('er_bc_link', 'term_' . $term->term_id) || !get_field('er_bc_text', 'term_' . $term->term_id)) {
					                    continue;
				                    }
				                    if (get_field('er_bc_link', 'term_' . $term->term_id) && get_field('er_bc_text', 'term_' . $term->term_id)) {
										$result .= '<a href="' . get_bloginfo('url') . '/ratings/">' . __('Рейтинги', 'er_theme') . '</a> ' . $delimiter . ' ';
				                    	$result .= '<a href="' . get_field('er_bc_link', 'term_' . $term->term_id) . '">';
					                    $result .= get_field('er_bc_text', 'term_' . $term->term_id);
					                    $result .= '</a>';
					                    $result .= ' &#187; ';
					                    break;
				                    }
			                    }
		                    }
	                    }

                        $result .= '<a href="' . get_the_permalink($review_id) . '">';
                        $result .= get_the_title($review_id);
                        $result .= '</a>';
                        $result .= ' &#187; ';
                    }


                    if (get_post_type() == 'promocodes' && get_query_var('dashboard_type') == '') {
                        $cur_terms = get_the_terms($post->ID, 'affiliate-tags');
                        $terms = get_term(get_field('promocode_taxonomy'), 'affiliate-tags');
                        //print_r($cur_terms[0]);
                        $term_id = $terms->term_id;
                        $tasks = get_posts(array(
                            'post_type' => 'promocodes_cats',
                            'meta_query' => array(
                                array(
                                    'key' => 'affiliate_tag', // name of custom field
                                    'value' => $term_id, // matches exaclty "123", not just 123. This prevents a match for "1234"
                                    'compare' => '='
                                )
                            )
                        ));
                        //print_r($tasks);

                        // $result .= '<a href="' . $home . '/promocode/">';
                        // $result .= 'Промокоды';
                        // $result .= '</a>';
                        // $result .= ' &raquo; ';

                        $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="2" />
<a itemprop="item" href="' . $home . '/promocode/"><span itemprop="name">' . __('Промокоды', 'er_theme') . '</span></a></span> ' . $delimiter . ' ';

                        // $result .= '<a href="' . get_the_permalink($tasks[0]->ID) . '">';
                        // $result .= $tasks[0]->post_title;
                        // $result .= '</a>';
                        // $result .= ' &raquo; ';

                        $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="3" />
<a itemprop="item" href="' . get_the_permalink($tasks[0]->ID) . '"><span itemprop="name">' . $tasks[0]->post_title . '</span></a></span> ' . $delimiter . ' ';

                    }
                    if (get_post_type() == 'casino') {

                        $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="2" />
<a itemprop="item" href="' . get_bloginfo('url') . '/ratings/"><span itemprop="name">' . __('Рейтинги', 'er_theme') . '</span></a></span> ' . $delimiter . ' ';
                        //echo $post->ID;
                        $cur_terms = get_the_terms($post->ID, 'affiliate-tags');
                        $cur_terms = get_field('review_aff_tags',$post->ID);
	                    if (gettype($cur_terms) == 'array') {
		                    //print_r($cur_terms[0]);
		                    $term_id = $cur_terms[0];
		                    //echo $term_id;

		                    if ($term_id) {
			                    foreach ($cur_terms as $item) {
				                    $rating_link = get_field('er_bc_link', 'term_' . $item);
				                    /*if(!get_field('er_bc_link','term_'.$item) || !get_field('er_bc_text','term_'.$item) ) {
										continue;
									}*/
				                    if (get_field('tag_human_title', 'term_' . $item) && $rating_link != '') {
					                    $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="3" />
<a itemprop="item" href="' . $rating_link . '"><span itemprop="name">';
					                    $result .= get_field('er_bc_text', 'term_' . $item);
					                    $result .= '</span></a></span>';
					                    $result .= ' &#187; ';
					                    break;
				                    }
			                    }
		                    }
	                    } else {
		                    $cur_terms = get_the_terms($post->ID, 'affiliate-tags');
		                    //print_r($cur_terms[0]);
		                    $term_id = $cur_terms[0]->slug;


		                    if ($term_id) {
			                    foreach ($cur_terms as $term) {
				                    if (!get_field('er_bc_link', 'term_' . $term->term_id) || !get_field('er_bc_text', 'term_' . $term->term_id)) {
					                    continue;
				                    }
				                    if (get_field('er_bc_link', 'term_' . $term->term_id) && get_field('er_bc_text', 'term_' . $term->term_id)) {
					                    $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="3" />
<a itemprop="item" href="' . get_field('er_bc_link', 'term_' . $term->term_id) . '"><span itemprop="name">';
					                    $result .= get_field('er_bc_text', 'term_' . $term->term_id);
					                    $result .= '</span></a></span>';
					                    $result .= ' &#187; ';
					                    break;
				                    }
			                    }
		                    }
	                    }
                    }

                    global $news_page_company_name;

                    if( $news_page_company_name ) {

                        $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="4" />
<a itemprop="item" href="' .get_the_permalink( $post->ID ) . '"><span itemprop="name">';
                        $result .= get_the_title();
                        $result .= '</span></a></span> ';
                        $result .= $delimiter . ' ';
                        $result .= $currentBefore;
                        $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="5" /><span itemprop="name">Новости';
                        $result .= '</span></span>';
                        $result .= $currentAfter;
                    } else {
                        $br_pos = 4;
                        if (get_post_type() == 'promocodes_cats') {
                            $br_pos = 3;
                        }

                        $result .= $currentBefore;
                        $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="'.$br_pos.'" /><span itemprop="name">' . get_the_title();
                        $result .= '</span></span>';
                        $result .= $currentAfter;                    
                    }

                } elseif(get_query_var('comment_single_page')) {
                    $comment = get_query_var('comment_single_page');
                    $comment_post_id = $comment->comment_post_ID;
                    //$result .= 'ffff';

                    if ($comment_post_id != 0 && $comment_post_id != '') {

                        $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="2" />
<a itemprop="item" href="' . get_bloginfo('url') . '/ratings/"><span itemprop="name">' . __('Рейтинги', 'er_theme') . '</span></a></span> ' . $delimiter . ' ';
                        //echo $post->ID;
                        /*$cur_terms = get_the_terms($comment_post_id, 'affiliate-tags');
                        //print_r($cur_terms[0]);
                        $term_id = $cur_terms[0]->term_id;
                        //echo $term_id;

                        if ($term_id) {
                            foreach ($cur_terms as $term) {
                                $rating_link = get_field('er_bc_link', 'term_' . $term->term_id);

                                if (get_field('tag_human_title', 'term_' . $term->term_id) && $rating_link != '') {
                                    $result .= '<a href="' . $rating_link . '">';
                                    $result .= get_field('er_bc_text', 'term_' . $term->term_id);
                                    $result .= '</a>';
                                    $result .= ' &raquo; ';
                                    break;
                                }
                            }
                        }*/


	                    $cur_terms = get_field('review_aff_tags',$comment_post_id);
	                    if (gettype($cur_terms) == 'array') {
		                    //print_r($cur_terms[0]);
		                    $term_id = $cur_terms[0];
		                    //echo $term_id;

		                    if ($term_id) {
			                    foreach ($cur_terms as $item) {
				                    $rating_link = get_field('er_bc_link', 'term_' . $item);
				                    /*if(!get_field('er_bc_link','term_'.$item) || !get_field('er_bc_text','term_'.$item) ) {
										continue;
									}*/
				                    if (get_field('tag_human_title', 'term_' . $item) && $rating_link != '') {
					                    $result .= '<a href="' . $rating_link . '">';
					                    $result .= get_field('er_bc_text', 'term_' . $item);
					                    $result .= '</a>';
					                    $result .= ' &#187; ';
					                    break;
				                    }
			                    }
		                    }
	                    } else {
		                    $cur_terms = get_the_terms($comment_post_id, 'affiliate-tags');
		                    //print_r($cur_terms[0]);
		                    $term_id = $cur_terms[0]->slug;


		                    if ($term_id) {
			                    foreach ($cur_terms as $term) {
				                    if (!get_field('er_bc_link', 'term_' . $term->term_id) || !get_field('er_bc_text', 'term_' . $term->term_id)) {
					                    continue;
				                    }
				                    if (get_field('er_bc_link', 'term_' . $term->term_id) && get_field('er_bc_text', 'term_' . $term->term_id)) {
					                    $result .= '<a href="' . get_field('er_bc_link', 'term_' . $term->term_id) . '">';
					                    $result .= get_field('er_bc_text', 'term_' . $term->term_id);
					                    $result .= '</a>';
					                    $result .= ' &#187; ';
					                    break;
				                    }
			                    }
		                    }
	                    }
                        $result .= '<a href="' . get_the_permalink($comment_post_id) . '">';
                        $result .= get_the_title($comment_post_id);
                        $result .= '</a>';
                        $result .= ' &#187; ';
                        $result .= $currentBefore;
                        $result .= $otzyv_n.' '.$comment->comment_ID;
                        $result .= $currentAfter;
                    }
                } elseif(is_post_type_archive('promocodes')) {

                    $result .= $currentBefore;
                    $result .= 'Промокоды';
                    $result .= $currentAfter;

                } else {

					if($news_cat != '') {
						
                        $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="2" />
<a itemprop="item" href="' . get_bloginfo('url') . '/pages/"><span itemprop="name">' . __('Статьи', 'er_theme') . '</span></a></span> ' . $delimiter . ' ';
						
						if(get_field('tag_human_title','term_'.$news_cat)) {
							$result .= $currentBefore;
							$result .= get_field('tag_human_title','term_'.$news_cat);
							$result .= $currentAfter;
						}
					}
                    if ( is_category() ) {
                        global $wp_query;
                        $cat_obj = $wp_query->get_queried_object();
                        $thisCat = $cat_obj->term_id;
                        $thisCat = get_category($thisCat);
                        $parentCat = get_category($thisCat->parent);

                        $cat_pos = 2;
                        $cats_html = '';

                        if ($thisCat->parent != 0) {
                            // $result .= (get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));

                            $cats_raw = explode( '<delimiter>', get_category_parents($parentCat, TRUE, '<delimiter>') );
                            if( is_array( $cats_raw ) and count( $cats_raw ) ) {
                                foreach( $cats_raw as $cat_raw ) {
                                    if( strlen( $cat_raw ) ) {
                                        $cats_html .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="'.$cat_pos.'" />';
                                        $cats_html .= str_replace( array( '<a href="', '">', '</a>' ), array( '<a itemprop="item" href="', '"><span itemprop="name">', '</span></a></span> ' ), $cat_raw );
                                        $cats_html .= $delimiter . ' ';

                                        $cat_pos++;
                                    }
                                }

                            }
                            $result .= $cats_html;

                        }
                        $result .= $currentBefore;
                        // $result .= single_cat_title('', 0);
                        $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="'.$cat_pos.'" /><span itemprop="name">' . 
                            single_cat_title('', 0);
                        $result .= '</span></span>';

                        $result .= $currentAfter;

                    } elseif ( is_day() ) {
                        $result .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
                        $result .= '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
                        $result .= $currentBefore . get_the_time('d') . $currentAfter;

                    } elseif ( is_month() ) {
                        $result .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
                        $result .= $currentBefore . get_the_time('F') . $currentAfter;

                    } elseif ( is_year() ) {
                        $result .= $currentBefore . get_the_time('Y') . $currentAfter;


                    } elseif ( is_single() && !is_attachment() ) {
                        $cat = get_the_category(); $cat = $cat[0];
                        // $result .= get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                        $cat_pos = 2;
                        $cats_html = '';

                        $cats_raw = explode( '<delimiter>', get_category_parents($cat, TRUE, '<delimiter>') );
                        if( is_array( $cats_raw ) and count( $cats_raw ) ) {
                            foreach( $cats_raw as $cat_raw ) {
                                if( strlen( $cat_raw ) ) {
                                    $cats_html .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="'.$cat_pos.'" />';
                                    $cats_html .= str_replace( array( '<a href="', '">', '</a>' ), array( '<a itemprop="item" href="', '"><span itemprop="name">', '</span></a></span> ' ), $cat_raw );
                                    $cats_html .= $delimiter . ' ';

                                    $cat_pos++;
                                }
                            }

                        }
                        $result .= $cats_html;

                        $result .= $currentBefore;
                        $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="'.$cat_pos.'" /><span itemprop="name">' . get_the_title();
                        $result .= '</span></span>';
                        $result .= $currentAfter;

                    } elseif ( is_attachment() ) {
                        $parent = get_post($post->post_parent);
                        $cat = get_the_category($parent->ID); $cat = $cat[0];
                        //echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                        $result .= '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
                        $result .= $currentBefore;
                        $result .= get_the_title();
                        $result .= $currentAfter;

                    } elseif ( get_query_var('dashboard_type') ) {
                    	if ($uselink == 0) {
		                    $currentBefore = '<div class="link_no_underline dashboard-breadcrumbs color_dark_gray flex"><span class="dashboard-breadcrumbs__arrow"></span><span class="dashboard-breadcrumbs__name">';
		                    $currentAfter = '</span></div>';
                    	} else {
		                    $currentBefore = '<a href="/dashboard/" class="link_no_underline dashboard-breadcrumbs color_dark_gray flex"><span class="dashboard-breadcrumbs__arrow"></span><span class="dashboard-breadcrumbs__name">';
		                    $currentAfter = '</span></a>';
                    	}


	                    $result .= $currentBefore;
	                    $result .= get_query_var('dashboard_breadcrumb_name');
	                    $result .= $currentAfter;

                    } elseif ( is_page() && !$post->post_parent ) {
						
                        $br_pos = 2;

                        if(is_page_template('template-rating.php')) {

                            $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="'.$br_pos.'" />
<a itemprop="item" href="' . get_bloginfo('url') . '/ratings/"><span itemprop="name">' . __('Рейтинги', 'er_theme') . '</span></a></span> ' . $delimiter . ' ';

                            $br_pos++;
						} else {
							if(!get_field('hide_from_news',$page->ID)) {

                                $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="2" />
<a itemprop="item" href="' . get_bloginfo('url') . '/pages/"><span itemprop="name">' . __('Статьи', 'er_theme') . '</span></a></span> ' . $delimiter . ' ';
								$cur_terms = get_the_terms( $review_id, 'affiliate-tags' );
								//print_r($cur_terms[0]);
								$term_slug = $cur_terms[0]->slug;
								$term_id = $cur_terms[0]->term_id;

                                $br_pos++;

								if($term_id) {
									$term_text_article = get_field('tag_human_title','term_'.$term_id);
									if($term_text_article != '') {

					                    $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="3" />
<a itemprop="item" href="' . get_bloginfo('url') . '/pages/'.$term_slug.'/"><span itemprop="name">';
					                    $result .= $term_text_article;
					                    $result .= '</span></a></span>';
					                    $result .= $delimiter . ' ';

                                        $br_pos++;

									}
									
								}
							}
							
						}
                        $result .= $currentBefore;

                        $result .= '<span itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><meta itemprop="position" content="'.$br_pos.'" /><span itemprop="name">' . get_the_title();
                        $result .= '</span></span>';
                        $result .= $currentAfter;

                    } elseif ( is_page() && $post->post_parent ) {
                        $parent_id  = $post->post_parent;
                        $breadcrumbs = array();
						if(is_page_template('template-rating.php')) {
							$result .= '<a href="' . get_bloginfo('url') . '/ratings/">' . __('Рейтинги','er_theme') . '</a> ' . $delimiter . ' ';
						}
                        while ($parent_id) {
                            $page = get_page($parent_id);
                            $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                            $parent_id  = $page->post_parent;
                        }
                        $breadcrumbs = array_reverse($breadcrumbs);
                        foreach ($breadcrumbs as $crumb) $result .= $crumb . ' ' . $delimiter . ' ';
                        $result .= $currentBefore;
                        $result .= get_the_title();
                        $result .= $currentAfter;

                    } elseif ( is_search()) {
                        $result .= $currentBefore . 'Результаты поиска &#39;' . get_search_query() . '&#39;' . $currentAfter;

                    } elseif ( is_tag() ) {
                        $result .= $currentBefore . 'Posts tagged &#39;';
                        single_tag_title();
                        $result .= '&#39;' . $currentAfter;

                    } elseif ( is_author() ) {
                        global $author;
                        $userdata = get_userdata($author);
                        $result .= $currentBefore . 'Articles posted by ' . $userdata->display_name . $currentAfter;

                    } elseif ( is_404() ) {
                        $result .= $currentBefore . 'Страница не найдена, зайдите на главную страницу' . $currentAfter;
                    }

                    if ( get_query_var('paged') ) {
                        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $result .= ' (';
                        $result .= __('Страница','er_theme') . ' ' . get_query_var('paged');
                        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $result .= ')';
                    }

                }

                $result .= '</div>';

            }

        }
        $current_language = get_locale();
        if ($current_language == 'en_US') {
			$result = str_replace("eto-razvod.ru", "revieweek.com",$result);
		} elseif ($current_language == 'es_ES') {
			$result = str_replace("eto-razvod.ru", "revieweek.es",$result);
		} elseif ($current_language == 'de_DE') {
			$result = str_replace("eto-razvod.ru", "revieweek.de",$result);
		} elseif ($current_language == 'fr_FR') {
			$result = str_replace("eto-razvod.ru", "revieweek.fr",$result);
		} elseif ($current_language == 'pl_PL') {
			$result = str_replace("eto-razvod.ru", "pl.revieweek.com",$result);
		} elseif ($current_language == 'fi') {
			$result = str_replace("eto-razvod.ru", "fi.revieweek.com",$result);
		} elseif ($current_language == 'id_ID') {
			$result = str_replace("eto-razvod.ru", "id.revieweek.com",$result);
		}

		return  $result;
    }
}


?>
