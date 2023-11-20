<?php
/*
add_action('init', 'gen_er_robots_file');

function gen_er_robots_file () {
	$request = $_SERVER['REQUEST_URI'];
	if ( $request == '/robots.txt' ) {
		$txt = "Mickey Mouse\n";
		$txt = "Mickey Mouse\n";
return $txt;
		exit;
	}
}*/


/*
add_action('init', 'check_revieweek_admin');


function check_revieweek_admin () {
	global $wpdb;
	$hooost = $_SERVER['HTTP_HOST'];
	$current_user_id = get_current_user_id();
	if(in_array($hooost,array('revieweek.de','www.revieweek.de','revieweek.es','www.revieweek.es')) && !isset($_POST['password_dfiewnrfff']) && check_cookie('review_log_check') == 'no') {
		echo 'Please enter the password to view the website under construction';
		$result = '<form method="POST">';
		$result .= '<input type="hidden" name="action" value="check_revieweek_admin_login">';
		$result .= '<input type="password" name="password_dfiewnrfff" value="" placeholder="Password">';
		$result .= '<input type="submit" value="Login">';
		$result .= '</form>';
		echo $result;
		exit;
	} elseif(in_array($hooost,array('revieweek.fr','www.revieweek.fr','revieweek.de','www.revieweek.de','revieweek.es','www.revieweek.es')) && isset($_POST['password_dfiewnrfff'])) {
		$pass = $_POST['password_dfiewnrfff'];
		if($pass == 'sdfdfdsijf*WFE') {
			set_cookie('review_log_check',172800);
		} else {
			echo 'Wrong password!';
			$result = '<form method="POST">';
			$result .= '<input type="hidden" name="action" value="check_revieweek_admin_login">';
			$result .= '<input type="password" name="password_dfiewnrfff" value="" placeholder="Password">';
			$result .= '<input type="submit" value="Login">';
			$result .= '</form>';
			echo $result;
			exit;
		}

	}
}

*/

add_filter( 'generate_rewrite_rules', function ( $wp_rewrite ){
	$wp_rewrite->rules = array_merge(
		['download/(\d+)/?$' => 'index.php?comment_single_page_new=$matches[1]'],
		$wp_rewrite->rules
	);
} );

add_filter( 'query_vars', function( $query_vars ){
	$query_vars[] = 'comment_single_page_new';
	return $query_vars;
} );

add_action( 'template_redirect', function(){
	$dl_id = intval( get_query_var( 'comment_single_page_new' ) );
	
	if ( $dl_id ) {
		//$comment = get_comment($dl_id);
		//print_r($comment);
		//echo $dl_id;
		//die;
		//include plugin_dir_path( __FILE__ ) . 'comment-single_view.php';
		
		status_header(200);
		//set_query_var('comment_single_page', $comment);
		set_query_var('page_title', __('Комментарий').' '.$dl_id);
		include(TEMPLATEPATH . "/comment-single_view_new.php");
		die;
	}
} );

add_action('init', 'set_review_single_link');

function set_review_single_link () {
	global $wpdb;
	
	$request = $_SERVER['REQUEST_URI'];
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	if ( strpos('/'.$request, '/comment-') ) {
		//echo $request;
		//$request = strtok($request, '?');
		//echo $request;
		$request = str_replace("?trp-edit-translation=true", "", $request);
		$affkey_key = explode('/', $request);
		//print_r($affkey_key);
		$curr_language = get_locale();
		$current_language = get_locale();
		
		//} else {
		if ( strpos('/'.$affkey_key[3], 'comment-') && !$affkey_key[4] ) {
			// echo 'bingo';
			$x_slug = $affkey_key[1];
			$b_slug = $affkey_key[2];
			//echo $b_slug;
			$affkey_key = str_replace('comment-', '', $affkey_key[3]);
			//  echo $affkey_key;
			$comment = get_comment($affkey_key);
			$c_post = get_post($comment->comment_post_ID);
			$c_slug = $c_post->post_name;
			/// echo $c_slug;
			if($current_language != 'ru_RU') {
				$is_enabled = array();
				$is_enabled = get_field('enable_translations',$c_post);
				if(!in_array($current_language,$is_enabled)) {
					global $wp_query;
					$wp_query->set_404();
					status_header(404);
					include(TEMPLATEPATH . "/404.php");
					exit();
				}
			}
			if (!empty($comment) && $b_slug == $c_slug && $x_slug == 'review' && $comment->comment_approved == 1) {
				
				//print_r($comment);
				status_header(200);
				wp_localize_script( 'jquery', 'banners_info', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'b_p_id' => $comment->comment_post_ID  ) );
				set_query_var('comment_single_page', $comment);
				$comment_ID = $comment->comment_ID;
				$comment_data = get_comment_current_content($comment_ID);
				$review_pluses = get_field('review_pluses','comment_'.$comment_ID);
				$review_minuses = get_field('review_minuses','comment_'.$comment_ID);
				$review_title = $comment_data['title'];
				$company_name = get_field('company_name',$comment->comment_post_ID);
				if(!$company_name || $company_name == '') {
					$company_name = get_the_title($comment->comment_post_ID);
					if($current_language != 'ru_RU') {
						$cyr = ['Љ', 'Њ', 'Џ', 'џ', 'ш', 'ђ', 'ч', 'ћ', 'ж', 'љ', 'њ', 'Ш', 'Ђ', 'Ч', 'Ћ', 'Ж','Ц','ц', 'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п', 'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я', 'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П', 'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
						];
						$lat = ['Lj', 'Nj', 'Dž', 'dž', 'sh', 'đ', 'ch', 'ć', 'zh', 'lj', 'nj', 'Sh', 'Đ', 'Ch', 'Ć', 'Zh','C','c', 'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p', 'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya', 'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P', 'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
						];
						$company_name = str_replace($cyr, $lat, $company_name);
					}
				}
				if($comment->user_id && $comment->user_id != 0) {
					$comment_author = get_userdata( $comment->user_id );
					$author_name = '';
					if($comment_author->first_name && !$comment_author->last_name) {
						$author_name .= $comment_author->first_name;
					} elseif(!$comment_author->first_name && $comment_author->last_name) {
						$author_name .= $comment_author->last_name;
					} elseif($comment_author->first_name && $comment_author->last_name) {
						$author_name .= $comment_author->first_name.' '.$comment_author->last_name;
					} else {
						$author_name .= $comment_author->user_nicename;
					}
					if($current_language != 'ru_RU') {
						$cyr = ['Љ', 'Њ', 'Џ', 'џ', 'ш', 'ђ', 'ч', 'ћ', 'ж', 'љ', 'њ', 'Ш', 'Ђ', 'Ч', 'Ћ', 'Ж','Ц','ц', 'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п', 'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я', 'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П', 'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
						];
						$lat = ['Lj', 'Nj', 'Dž', 'dž', 'sh', 'đ', 'ch', 'ć', 'zh', 'lj', 'nj', 'Sh', 'Đ', 'Ch', 'Ć', 'Zh','C','c', 'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p', 'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya', 'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P', 'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
						];
						$author_name = str_replace($cyr, $lat, $author_name);
					}
				} else {
					$author_name = __('анонимный пользователь','er_theme').' ';
					if($current_language != 'ru_RU') {
						$author_name = 'anonymous user';
					}
				}
				//$author_name .= ' ';
				if($review_title && $review_title != '') {
					$r_tit = $review_title;
					// $comm_rev_title = $review_title.' - '.__('отзыв о','er_theme').' '.$company_name;
				} else {
					$r_tit = wp_trim_words($comment_data['content'], 5,'');
				}
				
				$r_last = substr($r_tit, -1);
				if(in_array($r_last,array(',','!','?','...','.'))) {
					$r_tit = substr($r_tit,0, -1);
				}
				$recommend = get_field('review_recommend_friends','comment_'.$comment_ID);
				if($current_language != 'ru_RU') {
					$comm_rev_title = $r_tit.'... '.$company_name;
					
					if ($current_language == 'en_US') {
						if($recommend == 'yes') {
							$comm_rev_title .= ' - I recommend';
						} elseif($recommend == 'no') {
							$comm_rev_title .= " - I don't recommend it";
						}
					} elseif ($current_language == 'es_ES') {
						if($recommend == 'yes') {
							$comm_rev_title .= ' - Recomiendo';
						} elseif($recommend == 'no') {
							$comm_rev_title .= ' - No se recomienda';
						}
					} elseif ($current_language == 'de_DE') {
						if($recommend == 'yes') {
							$comm_rev_title .= ' - Ich empfehle';
						} elseif($recommend == 'no') {
							$comm_rev_title .= ' - Nicht empfohlen';
						}
					} elseif ($current_language == 'fr_FR') {
						if($recommend == 'yes') {
							$comm_rev_title .= ' - Je recommande';
						} elseif($recommend == 'no') {
							$comm_rev_title .= ' - Non recommandé';
						}
					}
					
					//$comm_rev_title = $r_tit.' - '.__('review about','er_theme').' '.$company_name;
				} else {
					//$comm_rev_title = $r_tit.' - '.__('отзыв о','er_theme').' '.$company_name;
					/*if (($comment_ID == 44032) || ($comment_ID == 45389)) {*/
						$comm_rev_title = $r_tit.'.. '.$company_name;
					/*} else {
						$comm_rev_title = $r_tit.'... '.$company_name;
					}*/
					if($recommend == 'yes') {
						$comm_rev_title .= ' - Рекомендую';
					} elseif($recommend == 'no') {
						$comm_rev_title .= ' - Не рекомендую';
					}
				}
				
				
				set_query_var('page_title', $comm_rev_title);
				if($current_language != 'ru_RU') {
					/*$descr = '';
					$descr .= get_comment_date( 'j F Y',$comment->comment_ID ).', ';
					if($current_language != 'ru_RU') {
						$descr .= __('review about','er_theme').' ';
					} else {
						$descr .= __('отзыв о компании','er_theme').' ';
					}

					$descr .= $company_name;
					if($current_language != 'ru_RU') {
						$descr .= ' '.__('written by','er_theme').' ';
					} else {
						$descr .= ' '.__('написал пользователь','er_theme').' ';
					}

					$descr .= $author_name.': ';
					if($current_language != 'ru_RU') {
						$translations = get_field('comment_translations','comment_'.$comment->comment_ID);
						//print_r($translations);
						$comm_tr_descr = $translations[0]['translation'];
						$r_descr = wp_trim_words($comm_tr_descr, 15,'');
					} else {
						$r_descr = wp_trim_words($comment->comment_content, 15,'');
					}

					$r_descr_last = substr($r_descr, -1);
					if(in_array($r_descr_last,array(',',':',';','-'))) {
						$r_descr = substr($r_descr,0, -1);
					} elseif(in_array($r_descr_last,array('!','?','.','...'))) {
						$r_descr = $r_descr;
					} else {
						$r_descr = $r_descr.'...';
					}
					$descr .= $r_descr;*/
					$descr = '';
					
					$r_descr = wp_trim_words($comment_data['content'], 15,'');
					
					
					$r_descr_last = substr($r_descr, -1);
					if(in_array($r_descr_last,array(',',':',';','-'))) {
						$r_descr = substr($r_descr,0, -1);
					} elseif(in_array($r_descr_last,array('!','?','.','...'))) {
						$r_descr = $r_descr;
					} else {
						$r_descr = $r_descr.'...';
					}
					$descr .= $r_descr;
					$descr .= ' - user '.$author_name;
					if($current_language != 'ru_RU') {
						$descr .= ' '.__('wrote a review about','er_theme').' ';
					} else {
						$descr .= ' '.__(' - написал отзыв о компании','er_theme').' ';
					}
					$descr .= $company_name.' company';
					
				} else {
					$descr = '';
					
					$r_descr = wp_trim_words($comment_data['content'], 15,'');
					
					
					$r_descr_last = substr($r_descr, -1);
					if(in_array($r_descr_last,array(',',':',';','-'))) {
						$r_descr = substr($r_descr,0, -1);
					} elseif(in_array($r_descr_last,array('!','?','.','...'))) {
						$r_descr = $r_descr;
					} else {
						$r_descr = $r_descr.'...';
					}
					
					
					/*if (($comment_ID == 44032) || ($comment_ID == 45389)) {*/
						$desciption_string = iconv('utf-8', 'utf-16le', wp_strip_all_tags($comment_data['content']));
						$desciption_string = strrev($desciption_string);
						$desciption_string = iconv('utf-16be', 'utf-8', $desciption_string);
						$desciption_string = get_text_sentences($desciption_string, 3);
						$desciption_string = iconv('utf-8', 'utf-16le', $desciption_string);
						$desciption_string = strrev($desciption_string);
						$desciption_string = iconv('utf-16be', 'utf-8', $desciption_string);
						$check = preg_match('/(\.|\?|\!)(\s)/',substr($desciption_string, 0, 2));
						if ($check == 1) {
							$desciption_string = preg_replace('/(\.|\?|\!)(\s)/','',$desciption_string,1);
						}
						$desciption_string = mb_ucfirst( $desciption_string, 'UTF-8' );
						
						$check = preg_match('/(\.|\?|\!)/',mb_substr($desciption_string, -1));
						if ($check == 1) {
							$desciption_string = mb_substr($desciption_string, 0, -1);
						}
						
						$descr .= wp_trim_words($desciption_string, 17,'').'..';
/*					} else {
						$descr .= $r_descr;
					}*/

					if($current_language != 'ru_RU') {
						$descr .= ' '.__('written by','er_theme').' ';
					} else {
						/*if (($comment_ID == 44032) || ($comment_ID == 45389)) {*/
							$descr .= ' '.__('- мнения реальных людей.','er_theme').'';
						/*} else {
							$descr .= ' '.__(' - написал отзыв о компании','er_theme').' ';
						}*/
					}

					/*if (($comment_ID != 44032) && ($comment_ID != 45389)) {
						$descr .= $company_name;
					}
					if (($comment_ID != 44032) && ($comment_ID != 45389)) {
						$descr .= ' пользователь ' . $author_name . '.';
					}*/
				}
				
				
				set_query_var('page_description', $descr);
				get_template_part( 'comment', 'single_view' );
				exit;
			}
		}
		//}
		
		
	} elseif ( strpos('/'.$request, '/review-') ) {
		$request = str_replace("/review-", "/comment-", $request);
		status_header(301);
		header("X-Robots-Tag: noindex, nofollow", true);
		header('Location: ' . $request . "\n\n");
		exit;
	}
	
	/*
		if ( strpos('/'.$request, '/user/') ) {
			$affkey_key = explode('user/', $request);
			$affkey_key = $affkey_key[1];
			$affkey_key = str_replace('/', '', $affkey_key);
			if($affkey_key) {
				$user = get_user_by( 'slug', $affkey_key );
				if(!empty($user)) {
					status_header(200);
					set_query_var('user_login', $affkey_key);
					set_query_var('page_title', __('Профиль пользователя').' '.$affkey_key);
					set_query_var('user_id', $user->ID);
					set_query_var('user_profile', 'user_profile');
					wp_localize_script( 'jquery', 'user_page',
						array( 'user_id' =>  $user->ID) );
					get_template_part( 'user', 'profile' );
					exit;
				}
	
			}
		}*/
	
}

add_action('init', 'set_userprofile_link');

function set_userprofile_link () {
	global $wpdb;
	
	$request = $_SERVER['REQUEST_URI'];
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	if (isset($_GET['affkey'])) {
		$request = '/user/'.$_GET['affkey'].'/';
	}
	
	
	if ( strpos('/'.$request, '/user/') ) {
		$affkey_key = explode('user/', $request);
		$affkey_key = $affkey_key[1];
		$affkey_key = str_replace('/', '', $affkey_key);
		if($affkey_key) {
			$user = get_user_by( 'slug', $affkey_key );
			if(!empty($user)) {
				status_header(200);
				set_query_var('user_login', $affkey_key);
				set_query_var('page_title', __('Профиль пользователя').' '.$affkey_key);
				set_query_var('user_id', $user->ID);
				set_query_var('user_profile', 'user_profile');
				wp_localize_script( 'jquery', 'user_page',
					array( 'user_id' =>  $user->ID) );
				get_template_part( 'user', 'profile' );
				exit;
			}
			
		}
	}
	
}


add_action('init', 'set_search_tag_link');

function set_search_tag_link () {
	global $wpdb;
	
	$request = $_SERVER['REQUEST_URI'];
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	
	if (isset($_GET['affkey'])) {
		$request = '/search/'.$_GET['affkey'].'/';
		//echo $_GET['affkey'];
		
	}
	
	
	if ( strpos('/'.$request, '/search/') ) {
		
		$affkey_key = explode('/', $request);
		$tag = $affkey_key[2];
		$affkey_key = $affkey_key[3];
		
		//$affkey_key = str_replace('/', '', $affkey_key);
		if($tag) {
			
			$term_id = get_term_by('slug', $tag, 'affiliate-tags')->term_id;
			if($term_id && $term_id != '') {
				$tag_human_title = get_field('tag_human_title','term_'.$term_id);
				if($affkey_key) {
					$key = explode('=', $affkey_key)[1];
					set_query_var('page_title', __('Компании в категории').' '.$tag_human_title.' по запросу '.urldecode($key));
					set_query_var('page_description', __('Полный список компаний категории').' '.$tag_human_title.__(' по запросу ').urldecode($key).__(': отзывы, информация, подробные обзоры, жалобы пользователей, скидки и акции.'));
					if($key) {
						set_query_var('phrase', $key);
					}
				} else {
					set_query_var('page_title', __('Компании в категории').' '.$tag_human_title);
					set_query_var('page_description', __('Полный список компаний категории').' '.$tag_human_title.__(': отзывы, информация, подробные обзоры, жалобы пользователей, скидки и акции.'));
				}
				
				status_header(200);
				set_query_var('tag', $tag);
				set_query_var('term_id', $term_id);
				set_query_var('human_title', $tag_human_title);
				
				//set_query_var('page_title', __('Компании в категории').' '.$tag_human_title);
				get_template_part( 'find', 'category' );
				exit;
			} else {
				$key = explode('=', $tag)[1];
				set_query_var('page_title', __('Поиск компании по запросу ').' '.urldecode($key));
				set_query_var('page_description', __('Полный список компаний по запросу ').urldecode($key).__(': отзывы, информация, подробные обзоры, жалобы пользователей, скидки и акции.'));
				status_header(200);
				if($key) {
					set_query_var('phrase', $key);
				}
				set_query_var('tag', 'all');
				set_query_var('term_id', '');
				//set_query_var('human_title', $tag_human_title);
				get_template_part( 'find', 'category' );
				exit;
			}
		} else {
			set_query_var('page_title', __('Поиск компаний'));
			status_header(200);
			set_query_var('phrase', '');
			set_query_var('tag', 'all');
			set_query_var('term_id', '');
			get_template_part( 'find', 'category' );
			exit;
		}
	}
	
}

add_action('init', 'set_page_tag_link');

function set_page_tag_link () {
	global $wpdb;
	
	$request = $_SERVER['REQUEST_URI'];
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	
	if (isset($_GET['affkey'])) {
		$request = '/pages/'.$_GET['affkey'].'/';
		//echo $_GET['affkey'];
		
	}
	
	
	if ( strpos('/'.$request, '/pages/') ) {
		
		$affkey_key = explode('/', $request);
		$tag = $affkey_key[2];
		
		//$affkey_key = str_replace('/', '', $affkey_key);
		if($tag) {
			
			$term_id = get_term_by('slug', $tag, 'affiliate-tags')->term_id;
			if($term_id && $term_id != '') {
				$tag_human_title = get_field('tag_human_title','term_'.$term_id);
				set_query_var('page_title', __('Статьи по теме').' '.$tag_human_title);
				set_query_var('page_description', __('Полезные статьи по теме').' '.$tag_human_title.__(': обзоры, перспективы, советы, инструкции. Читайте и оставляйте комментарии.'));
				status_header(200);
				set_query_var('tag', $tag);
				set_query_var('term_id', $term_id);
				set_query_var('human_title', $tag_human_title);
				
				//set_query_var('page_title', __('Компании в категории').' '.$tag_human_title);
				get_template_part( 'find', 'news' );
				exit;
			}
		}
	}
	
}




add_action('init', 'set_userprofile_link2');

function set_userprofile_link2 () {
	global $wpdb;
	global $current_user;
	
	$request = $_SERVER['REQUEST_URI'];
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	if (isset($_GET['affkey'])) {
		$request = '/dashboard/company/'.$_GET['affkey'].'/';
	}
	
	
	if ( strpos('/'.$request, '/dashboard/company/') ) {
		$affkey_key = explode('dashboard/company/', $request);
		$affkey_key = $affkey_key[1];
		$affkey_key = str_replace('/', '', $affkey_key);
		if($affkey_key) {
			//get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']
			if (get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' ) ) {
				$idPage = intval(get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']);
				
				$get_users = get_users( [
					'meta_key'     => 'company_user',
					'meta_value'   => sprintf('"%s"', $idPage),
					'meta_compare' => 'LIKE',
				] );
				$current_user_id = get_current_user_id();
				$get_user_id = $get_users[0]->data->ID;
				//проверяем кто и чью компанию пытается просмотреть
				if ($current_user_id == $get_user_id) {
					
					
					status_header(200);
					
					set_query_var('page_title', __('Дашборд компании').' '.$affkey_key);
					
					set_query_var('user_id', $current_user_id);
					set_query_var('company_slug', $affkey_key);
					set_query_var('company_dashboard', 'company_dashboard');
					set_query_var('comp_id', $idPage);
					
					wp_localize_script( 'jquery', 'company_page',
						array( 'user_id' =>  $get_users[0]->data->ID,'company_id' => $idPage,'company_slug' => $affkey_key));
					wp_localize_script( 'jquery', 'dashboard_var',array('1','1'));
					get_template_part( 'user', 'company' );
					exit;
				}
			}
			
		}
	}
	
}


add_action('init', 'set_dashboard_comments_company');

function set_dashboard_comments_company () {
	global $wpdb;
	global $current_user;
	
	$request = $_SERVER['REQUEST_URI'];
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	if (isset($_GET['affkey'])) {
		$request = '/dashboard/comments/company/'.$_GET['affkey'].'/';
	}
	
	
	if ( strpos('/'.$request, '/dashboard/comments/company/') ) {
		$affkey_key = explode('dashboard/comments/company/', $request);
		$affkey_key = $affkey_key[1];
		$affkey_key = str_replace('/', '', $affkey_key);
		if($affkey_key) {
			//get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']
			if (get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' ) ) {
				$idPage = intval(get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']);
				
				$get_users = get_users( [
					'meta_key'     => 'company_user',
					'meta_value'   => sprintf('"%s"', $idPage),
					'meta_compare' => 'LIKE',
				] );
				$current_user_id = get_current_user_id();
				$get_user_id = $get_users[0]->data->ID;
				//проверяем кто и чью компанию пытается просмотреть
				if ($current_user_id == $get_user_id) {
					
					
					status_header(200);
					
					set_query_var('page_title', __('Дашборд компании').' '.$affkey_key);
					
					set_query_var('user_id', $current_user_id);
					set_query_var('company_slug', $affkey_key);
					set_query_var('company_dashboard', 'company_dashboard');
					set_query_var('comp_id', $idPage);
					
					wp_localize_script( 'jquery', 'company_page',
						array( 'user_id' =>  $get_users[0]->data->ID,'company_id' => $idPage,'company_slug' => $affkey_key));
					get_template_part( 'user', 'company_comments' );
					exit;
				}
			}
			
		}
	}
	
}



add_action('init', 'set_dashboard_promo_company');

function set_dashboard_promo_company () {
	global $wpdb;
	global $current_user;
	
	$request = $_SERVER['REQUEST_URI'];
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	if (isset($_GET['affkey'])) {
		$request = '/dashboard/promo/company/'.$_GET['affkey'].'/';
	}
	
	
	if ( strpos('/'.$request, '/dashboard/promo/company/') ) {
		$affkey_key = explode('dashboard/promo/company/', $request);
		$affkey_key = $affkey_key[1];
		$affkey_key = str_replace('/', '', $affkey_key);
		if($affkey_key) {
			//get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']
			if (get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' ) ) {
				$idPage = intval(get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']);
				
				$get_users = get_users( [
					'meta_key'     => 'company_user',
					'meta_value'   => sprintf('"%s"', $idPage),
					'meta_compare' => 'LIKE',
				] );
				$current_user_id = get_current_user_id();
				$get_user_id = $get_users[0]->data->ID;
				//проверяем кто и чью компанию пытается просмотреть
				if ($current_user_id == $get_user_id) {
					
					
					status_header(200);
					
					set_query_var('page_title', __('Дашборд компании').' '.$affkey_key);
					
					set_query_var('user_id', $current_user_id);
					set_query_var('company_slug', $affkey_key);
					set_query_var('company_dashboard', 'company_dashboard');
					set_query_var('comp_id', $idPage);
					
					wp_localize_script( 'jquery', 'company_page',
						array( 'user_id' =>  $get_users[0]->data->ID,'company_id' => $idPage,'company_slug' => $affkey_key));
					get_template_part( 'user', 'company_promo' );
					exit;
				}
			}
			
		}
	}
	
}


add_action('init', 'set_dashboard_comments_company_messages');

function set_dashboard_comments_company_messages () {
	global $wpdb;
	global $current_user;
	
	$request = $_SERVER['REQUEST_URI'];
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	if (isset($_GET['affkey'])) {
		$request = '/dashboard/messages/company/'.$_GET['affkey'].'/';
	}
	
	
	if ( strpos('/'.$request, '/dashboard/messages/company/') ) {
		$affkey_key = explode('dashboard/messages/company/', $request);
		$affkey_key = $affkey_key[1];
		$affkey_key = str_replace('/', '', $affkey_key);
		
		$affkey_key2 = explode('?',$affkey_key);
		$affkey_key = $affkey_key2[0];
		
		if($affkey_key) {
			//get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']
			if (get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' ) ) {
				$idPage = intval(get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']);
				
				$get_users = get_users( [
					'meta_key'     => 'company_user',
					'meta_value'   => sprintf('"%s"', $idPage),
					'meta_compare' => 'LIKE',
				] );
				$current_user_id = get_current_user_id();
				$get_user_id = $get_users[0]->data->ID;
				//проверяем кто и чью компанию пытается просмотреть
				if ($current_user_id == $get_user_id) {
					
					
					status_header(200);
					
					set_query_var('page_title', __('Дашборд компании').' '.$affkey_key);
					
					set_query_var('user_id', $current_user_id);
					set_query_var('company_slug', $affkey_key);
					set_query_var('company_dashboard', 'company_dashboard');
					set_query_var('comp_id', $idPage);
					
					wp_localize_script( 'jquery', 'company_page',
						array( 'user_id' =>  $get_users[0]->data->ID,'company_id' => $idPage,'company_slug' => $affkey_key));
					get_template_part( 'user', 'company_messages' );
					exit;
				}
			}
			
		}
	}
	
}


add_action('init', 'set_dashboard_wallet_company');

function set_dashboard_wallet_company () {
	global $wpdb;
	global $current_user;
	
	$request = $_SERVER['REQUEST_URI'];
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	if (isset($_GET['affkey'])) {
		$request = '/dashboard/wallet/company/'.$_GET['affkey'].'/';
	}
	
	
	if ( strpos('/'.$request, '/dashboard/wallet/company/') ) {
		$affkey_key = explode('dashboard/wallet/company/', $request);
		$affkey_key = $affkey_key[1];
		$affkey_key = str_replace('/', '', $affkey_key);
		if($affkey_key) {
			//get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']
			if (get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' ) ) {
				$idPage = intval(get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']);
				
				$get_users = get_users( [
					'meta_key'     => 'company_user',
					'meta_value'   => sprintf('"%s"', $idPage),
					'meta_compare' => 'LIKE',
				] );
				$current_user_id = get_current_user_id();
				$get_user_id = $get_users[0]->data->ID;
				//проверяем кто и чью компанию пытается просмотреть
				if ($current_user_id == $get_user_id) {
					
					
					status_header(200);
					
					set_query_var('page_title', __('Дашборд компании').' '.$affkey_key);
					
					set_query_var('user_id', $current_user_id);
					set_query_var('company_slug', $affkey_key);
					set_query_var('company_dashboard', 'company_dashboard');
					set_query_var('comp_id', $idPage);
					
					wp_localize_script( 'jquery', 'company_page',
						array( 'user_id' =>  $get_users[0]->data->ID,'company_id' => $idPage,'company_slug' => $affkey_key));
					get_template_part( 'user', 'company_wallet' );
					exit;
				}
			}
			
		}
	}
	
}

add_action('init', 'set_dashboard_ratings_company');

function set_dashboard_ratings_company () {
	global $wpdb;
	global $current_user;
	
	$request = $_SERVER['REQUEST_URI'];
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	if (isset($_GET['affkey'])) {
		$request = '/dashboard/ratings/company/'.$_GET['affkey'].'/';
	}
	
	
	if ( strpos('/'.$request, '/dashboard/ratings/company/') ) {
		$affkey_key = explode('dashboard/ratings/company/', $request);
		$affkey_key = $affkey_key[1];
		$affkey_key = str_replace('/', '', $affkey_key);
		if($affkey_key) {
			//get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']
			if (get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' ) ) {
				$idPage = intval(get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']);
				
				$get_users = get_users( [
					'meta_key'     => 'company_user',
					'meta_value'   => sprintf('"%s"', $idPage),
					'meta_compare' => 'LIKE',
				] );
				$current_user_id = get_current_user_id();
				$get_user_id = $get_users[0]->data->ID;
				//проверяем кто и чью компанию пытается просмотреть
				if ($current_user_id == $get_user_id) {
					
					
					status_header(200);
					
					set_query_var('page_title', __('Дашборд компании').' '.$affkey_key);
					
					set_query_var('user_id', $current_user_id);
					set_query_var('company_slug', $affkey_key);
					set_query_var('company_dashboard', 'company_dashboard');
					set_query_var('comp_id', $idPage);
					
					wp_localize_script( 'jquery', 'company_page',
						array( 'user_id' =>  $get_users[0]->data->ID,'company_id' => $idPage,'company_slug' => $affkey_key));
					get_template_part( 'user', 'company_ratings' );
					exit;
				}
			}
			
		}
	}
	
}

add_action('init', 'set_dashboard_abuse_company');

function set_dashboard_abuse_company () {
	global $wpdb;
	global $current_user;
	
	$request = $_SERVER['REQUEST_URI'];
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	if (isset($_GET['affkey'])) {
		$request = '/dashboard/abuses/company/'.$_GET['affkey'].'/';
	}
	
	
	if ( strpos('/'.$request, '/dashboard/abuses/company/') ) {
		$affkey_key = explode('dashboard/abuses/company/', $request);
		$affkey_key = $affkey_key[1];
		$affkey_key = str_replace('/', '', $affkey_key);
		if($affkey_key) {
			//get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']
			if (get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' ) ) {
				$idPage = intval(get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']);
				
				$get_users = get_users( [
					'meta_key'     => 'company_user',
					'meta_value'   => sprintf('"%s"', $idPage),
					'meta_compare' => 'LIKE',
				] );
				$current_user_id = get_current_user_id();
				$get_user_id = $get_users[0]->data->ID;
				//проверяем кто и чью компанию пытается просмотреть
				if ($current_user_id == $get_user_id) {
					
					
					status_header(200);
					
					set_query_var('page_title', __('Дашборд компании').' '.$affkey_key);
					
					set_query_var('user_id', $current_user_id);
					set_query_var('company_slug', $affkey_key);
					set_query_var('company_dashboard', 'company_dashboard');
					set_query_var('comp_id', $idPage);
					
					wp_localize_script( 'jquery', 'company_page',
						array( 'user_id' =>  $get_users[0]->data->ID,'company_id' => $idPage,'company_slug' => $affkey_key));
					get_template_part( 'user', 'company_abuses' );
					exit;
				}
			}
			
		}
	}
	
}

add_action('init', 'hrt_redirect_rooms_5');

add_action('init', 'hrt_redirect_rooms_6');

function hrt_redirect_rooms_6()
{
	global $wpdb;
	
	$request = $_SERVER['REQUEST_URI'];
	$parts_request = parse_url($request);
	parse_str($parts_request['query'], $query_request);
	if (!empty($query_request)) {
		$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
		$request = 'https://' . $_SERVER['HTTP_HOST'] . $uri_parts[0];
		
	}
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) and $_SERVER['QUERY_STRING'] != '') {
			$request .= '?' . $_SERVER['QUERY_STRING'];
		}
	}
	if (isset($_GET['affkey'])) {
		$request = '/visit1/' . $_GET['affkey'] . '/';
	}
	
	
	if (strpos('/' . $request, '/visit1/')) {
		$affkey_key = explode('visit1/', $request);
		$affkey_key = $affkey_key[1];
		$affkey_key = str_replace('/', '', $affkey_key);
		
		$args = array(
			'post_type' => 'addpages',
			'post_status' => 'publish, draft, trash',
			'meta_query' => array(
				array(
					'key' => 'addpage_redirect_key',
					'value' => $affkey_key
				)
			)
		);
		$query = new WP_Query($args);
		
		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				$link = get_field('addpage_affiliate_url', get_the_ID());
				$post_id = get_the_ID();
			}
		} else {
			// Постов не найдено
		}
		// Возвращаем оригинальные данные поста. Сбрасываем $post.
		wp_reset_postdata();
		
		if ($link && $link != '') {
			$pos = strpos($link, 'admitad');
			if ($pos !== false) {
				$subid = htmlspecialchars($_COOKIE["_ym_uid"]);
				$parts = parse_url($link);
				parse_str($parts['query'], $query);
				if ($subid && $subid != '') {
					if (!empty($query)) {
						if ($query['subid'] && $query['subid'] != '') {
							echo $query['subid'];
							$link = str_replace('subid=' . $query['subid'], 'subid=' . $subid . '&subid1=' . $query['subid'], $link);
						} else {
							$link = $link . '&subid=' . $subid;
						}
					} else {
						$link = $link . '?subid=' . $subid;
					}
				}
			}
			
			
			//echo $affkey_keys[0]; echo '---'.$affkey_keys[1];
			//echo '<br />';
			// echo 'url '.$link;
			if ($query_request['view'] && $query_request['view'] == 'true') {
				$click_type = 'view';
			} else {
				$click_type = 'click';
			}
			$db_subid = htmlspecialchars($_COOKIE["_ym_uid"]);
			/*echo 'url: '.$link;
			echo '<br />';
			echo 'wp_id: '.$post_id;
			echo '<br />';
			echo 'slug: '.'visit1/'.$affkey_key;
			echo '<br />';
			echo 'subid: '.$db_subid;
			echo '<br />';
			echo 'click_type: '.$click_type;*/
			header("X-Robots-Tag: noindex, nofollow", true);
			header('Location: ' . $link . "\n\n");
			///вернутьMYDB
			/*$mydb = new wpdb('clicks', '2K7v8K8w', 'clicks', 'localhost');
			$mydb->insert(
				'clicks',
				array('click_id' => $db_subid, 'wp_id' => $post_id, 'slug' => 'visit1/' . $affkey_key, 'redirect_url' => $link, 'type' => $click_type),
				array('%s', '%s', '%s', '%s', '%s')
			);*/
			///вернутьMYDB
			
			exit;
		} else {
			global $wp_query;
			$wp_query->set_404();
			status_header(404);
			include(TEMPLATEPATH . "/404.php");
			exit();
		}
		
	}
	
}
function hrt_redirect_rooms_5 () {
	global $wpdb;
	
	$request = $_SERVER['REQUEST_URI'];
	$parts_request = parse_url($request);
	parse_str($parts_request['query'], $query_request);
	if(!empty($query_request)) {
		$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
		$request = 'https://' . $_SERVER['HTTP_HOST'] . $uri_parts[0];
		
	}
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	if (isset($_GET['affkey'])) {
		$request = '/visit2/'.$_GET['affkey'].'/';
	}
	
	
	if ( strpos('/'.$request, '/visit2/') ) {
		$affkey_key = explode('visit2/', $request);
		$affkey_key = $affkey_key[1];
		$affkey_key = str_replace('/', '', $affkey_key);
		$affkey_keys = explode("-",$affkey_key);
		$promocodes = get_field('promocodes_items',$affkey_keys[0]);
		$code = $affkey_keys[1]-1;
		$link = $promocodes[$code]['partner_link'];
		$current_visits = $promocodes[$code]['visits'];
		if(!$current_visits || $current_visits == '' || $current_visits == 0) {
			$current_visits = 1;
		}
		$current_visits++;
		update_sub_field( array('promocodes_items', $affkey_keys[1], 'visits'), $current_visits,$affkey_keys[0] );
		if($link && $link != '') {
			$pos = strpos($link, 'admitad');
			if ($pos !== false) {
				$subid = htmlspecialchars($_COOKIE["_ym_uid"]);
				$parts = parse_url($link);
				parse_str($parts['query'], $query);
				if($subid && $subid != '') {
					if(!empty($query)) {
						if($query['subid'] && $query['subid'] != '') {
							echo $query['subid'];
							$link = str_replace('subid='.$query['subid'], 'subid='.$subid.'&subid1='.$query['subid'], $link);
						} else {
							$link = $link.'&subid='.$subid;
						}
					} else {
						$link = $link.'?subid='.$subid;
					}
				}
			}
			
			//echo $affkey_keys[0]; echo '---'.$affkey_keys[1];
			if($query_request['view'] && $query_request['view'] == 'true') {
				$click_type = 'view';
			} else {
				$click_type = 'click';
			}
			$db_subid = htmlspecialchars($_COOKIE["_ym_uid"]);
			/*echo 'url: '.$link;
			echo '<br />';
			echo 'wp_id: '.$affkey_keys[0];
			echo '<br />';
			echo 'slug: '.'visit2/'.$affkey_key;
			echo '<br />';
			echo 'subid: '.$db_subid;
			echo '<br />';
			echo 'click_type: '.$click_type;*/
			header("X-Robots-Tag: noindex, nofollow", true);
			header('Location: ' . $link . "\n\n");
			///вернутьMYDB
			/*$mydb = new wpdb('clicks','2K7v8K8w','clicks','localhost');
			$mydb->insert(
				'clicks',
				array('click_id'=> $db_subid,'wp_id' => $affkey_keys[0],'slug' => 'visit2/'.$affkey_key, 'redirect_url' => $link,'type'=>$click_type),
				array( '%s', '%s', '%s','%s','%s')
			);*/
			///вернутьMYDB
			
			exit;
		} else {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
			include(TEMPLATEPATH . "/404.php"); exit();
		}
	}
	
}
add_action('init', 'hrt_redirect_rooms');

function hrt_redirect_rooms () {
	global $wpdb;
	
	$request = $_SERVER['REQUEST_URI'];
	$parts_request = parse_url($request);
	parse_str($parts_request['query'], $query_request);
	//print_r($query_request);
	if(!empty($query_request)) {
		$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
		$request = 'https://' . $_SERVER['HTTP_HOST'] . $uri_parts[0];
		
	}
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	if (isset($_GET['affkey'])) {
		$request = '/visit/'.$_GET['affkey'].'/';
	}
	
	
	if ( strpos('/'.$request, '/visit/') ) {
		$affkey_key = explode('visit/', $request);
		$affkey_key = $affkey_key[1];
		$affkey_key = str_replace('/', '', $affkey_key);
		$room = room($affkey_key);
		$url=$room['url'];
		$post_id = $room['post_id'];
		//echo $url;
		if($url && $url != '') {
			$pos = strpos($url, 'admitad');
			if ($pos !== false) {
				$subid = htmlspecialchars($_COOKIE["_ym_uid"]);
				$parts = parse_url($url);
				parse_str($parts['query'], $query);
				if($subid && $subid != '') {
					if(!empty($query)) {
						if($query['subid'] && $query['subid'] != '') {
							echo $query['subid'];
							$url = str_replace('subid='.$query['subid'], 'subid='.$subid.'&subid1='.$query['subid'], $url);
						} else {
							$url = $url.'&subid='.$subid;
						}
					} else {
						$url = $url.'?subid='.$subid;
					}
				}
			}
			
			$db_subid = htmlspecialchars($_COOKIE["_ym_uid"]);
			if($query_request['view'] && $query_request['view'] == 'true') {
				$click_type = 'view';
			} else {
				$click_type = 'click';
			}
			/*echo 'url: '.$url;
			echo '<br />';
			echo 'wp_id: '.$post_id;
			echo '<br />';
			echo 'slug: '.'visit/'.$affkey_key;
			echo '<br />';
			echo 'subid: '.$db_subid;
			echo '<br />';
			echo 'click_type: '.$click_type;*/
			header("X-Robots-Tag: noindex, nofollow", true);
			header('Location: ' . $url . "\n\n");
			///вернутьMYDB
			/*$mydb = new wpdb('clicks','2K7v8K8w','clicks','localhost');
			$mydb->insert(
				'clicks',
				array('click_id'=> $db_subid,'wp_id' => $post_id,'slug' => 'visit/'.$affkey_key, 'redirect_url' => $url,'type'=>$click_type),
				array( '%s', '%s', '%s','%s','%s')
			);*/
			///вернутьMYDB
			
			
			exit;
		} else {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
			include(TEMPLATEPATH . "/404.php"); exit();
		}
	}
	
}

function room($affkey_key) {
	global $wpdb;
	global $post;
	
	query_posts('post_type=casino&post_status=publish,draft&meta_key=company_redirect_key&meta_value='.$affkey_key .'');
	if ( have_posts() ) {
		the_post();
		
		$url['url']= get_field('company_site_affiliate_url',$post->ID);
		$url['post_id'] = $post->ID;
		$get_locale = get_locale();
		foreach ( get_field('company_site_affiliate_url_lang',$post->ID) as $item ) {
			if ($item['language'] == $get_locale) {
				$url['url'] = $item['url'];
				break;
			}
		}
		/*if ($url['post_id'] == 159538) {
			$url['url']= 'https://vk.com/';
		}*/
		//159538 https://www.binance.com/?ref=26852381
		//  do_action('flytonic-room-redirect', $post);
		
	} else {
		$args = array(
			'name'        => $affkey_key,
			'post_type'   => 'redirects',
			'post_status' => 'publish',
			'numberposts' => 1
		);
		$my_posts = get_posts($args);
		if( $my_posts ) :
			$url['url'] = get_field('url',$my_posts[0]->ID);
			$count_hits = get_field('hits',$my_posts[0]->ID);
			$count_hits ++;
			update_field('hits',$count_hits, $my_posts[0]->ID);
			$url['post_id'] = $my_posts[0]->ID;
		endif;
		//$url = 'https://google.com/5';
		/* $redirects = get_option('flytonic_custom_redirects');
		if (array_key_exists($affkey_key, $redirects)) {
			$redirect = $redirects[$affkey_key];
			$redirect['hits'] += 1;

			$redirects[$affkey_key] = $redirect;
			update_option('flytonic_custom_redirects', $redirects);

			$url = $redirect['url'];

		}  */
	}
	
	return $url;
}

function room2($dl_key) {
	global $wpdb;
	global $post;
	
	query_posts('post_type=casino&meta_key=_as_redirectkey&meta_value='.$dl_key .'');
	if ( have_posts() ) : the_post();
		
		$url= get_post_meta($post->ID, '_as_downloadurl', true);
	
	endif;
	
	return $url;
}

add_action('init', 'set_dashboard_profile_company');

function set_dashboard_profile_company () {
	global $wpdb;
	global $current_user;
	
	$request = $_SERVER['REQUEST_URI'];
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	if (isset($_GET['affke3y'])) {
		$request = '/dashboard/profile/company/'.$_GET['affke3y'].'/';
	}
	
	
	if ( strpos('/'.$request, '/dashboard/profile/company/') ) {
		$affkey_key = explode('dashboard/profile/company/', $request);
		$affkey_key = $affkey_key[1];
		$affkey_key = str_replace('/', '', $affkey_key);
		if($affkey_key) {
			
			
			
			$affkey_key2 = explode('?',$affkey_key);
			$affkey_key = $affkey_key2[0];
			
			
			if (get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' ) ) {
				
				$idPage = intval(get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']);
				
				$get_users = get_users( [
					'meta_key'     => 'company_user',
					'meta_value'   => sprintf('"%s"', $idPage),
					'meta_compare' => 'LIKE',
				] );
				$current_user_id = get_current_user_id();
				$get_user_id = $get_users[0]->data->ID;
				//проверяем кто и чью компанию пытается просмотреть
				if ($current_user_id == $get_user_id) {
					
					
					status_header(200);
					
					set_query_var('page_title', __('Дашборд компании').' '.$affkey_key);
					
					set_query_var('user_id', $current_user_id);
					set_query_var('company_slug', $affkey_key);
					set_query_var('company_dashboard', 'company_dashboard');
					set_query_var('comp_id', $idPage);
					
					wp_localize_script( 'jquery', 'company_page',
						array( 'user_id' =>  $get_users[0]->data->ID,'company_id' => $idPage,'company_slug' => $affkey_key));
					//echo 2;
					get_template_part( 'user', 'company_profile' );
					exit;
				}
			}
			
		}
	}
	
}


/*add_action('init', 'set_dashboard_profile_company');

function set_dashboard_profile_company () {
	global $wpdb;
	global $current_user;

	$request = $_SERVER['REQUEST_URI'];
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	if (isset($_GET['affkey'])) {
		$request = '/dashboard/profile/company/'.$_GET['affkey'].'/';
	}


	if ( strpos('/'.$request, '/dashboard/profile/company/') ) {
		$affkey_key = explode('dashboard/profile/company/', $request);
		$affkey_key = $affkey_key[1];
		$affkey_key = str_replace('/', '', $affkey_key);
		if($affkey_key) {
			//get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']
			if (get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' ) ) {
				$idPage = intval(get_page_by_path( $affkey_key, 'ARRAY_A', 'casino' )['ID']);

				$get_users = get_users( [
					'meta_key'     => 'company_user',
					'meta_value'   => sprintf('"%s"', $idPage),
					'meta_compare' => 'LIKE',
				] );
				$current_user_id = get_current_user_id();
				$get_user_id = $get_users[0]->data->ID;
				//проверяем кто и чью компанию пытается просмотреть
				if ($current_user_id == $get_user_id) {


					status_header(200);

					set_query_var('page_title', __('Дашборд компании').' '.$affkey_key);

					set_query_var('user_id', $current_user_id);
					set_query_var('company_slug', $affkey_key);
					set_query_var('company_dashboard', 'company_dashboard');
					set_query_var('comp_id', $idPage);

					wp_localize_script( 'jquery', 'company_page',
						array( 'user_id' =>  $get_users[0]->data->ID,'company_id' => $idPage,'company_slug' => $affkey_key));
					get_template_part( 'user', 'company_profile' );
					exit;
				}
			}

		}
	}

}*/
?>