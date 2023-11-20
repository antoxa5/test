<!doctype html>
<?php //error_reporting(0);
?>
<html <?php language_attributes(); ?> itemscope="" itemtype="http://schema.org/WebPage" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <?php 
	if (is_404()) {
		$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		if (strpos($actual_link, "/comment-") !== false) {
			set_query_var( 'page_title', '' );
			set_query_var( 'page_description', er_description() );
		}
	}
	ob_start();
	$page_title = get_query_var('page_title'); 
	if( $page_title && $page_title != '' ) { 
		echo $page_title; 
	} 
	echo er_title();
	$page_title_full = ob_get_contents();
	ob_end_clean();

	$page_description = get_query_var('page_description'); 
	if( $page_description && $page_description != '' ) { 
	} else { 
		$page_description = er_description(); 
	}

    ?>
    <title><?php echo $page_title_full; ?></title>
    <meta name="description" content="<?php echo $page_description; ?>">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
	<?php $curr_language = get_locale(); ?>
	<link rel="preconnect dns-prefetch" href="https://www.googletagmanager.com/" crossorigin>
	<link rel="preconnect dns-prefetch" href="https://cdn.jsdelivr.net/" crossorigin>
	<link rel="preconnect dns-prefetch" href="https://eto-razvod.net/" crossorigin>
    <meta name="ermp-site-verification" value="F95EC1D2-4D40-4302-91A1-58754D3E3C47">
    <meta name="ermp-site-verification" value="76F22630-5ED2-4CE1-A4EE-263287F74E7D">

	<?php $userprofile = get_query_var('userprofile');

    if($curr_language != 'ru_RU'){
        $lang_class = ' lang_'.$curr_language;
    } else {
        $lang_class = ' lang_main';
        //echo '<meta name="apple-itunes-app" content="app-id=1612079343">';

    }
    if($userprofile && $userprofile != '') {
        echo '<meta name="robots" content="noindex, nofollow">';
    }
    //if (gettype(get_query_var('comment_single_page'))) {
        //echo '<!-- '.gettype(get_query_var('comment_single_page')).'-->';
    //}
    if (gettype(get_query_var('comment_single_page')) == 'object') {
        $commentCanonical = get_query_var('comment_single_page');
		$canonical_url = get_the_permalink($commentCanonical->comment_post_ID).'comment-'.$commentCanonical->comment_ID . "/";
    } else {
		$canonical_url = wp_get_canonical_url();
	}

	$current_language = get_locale();
	if ( $current_language == 'ru_RU' ) {
		$image_src = site_url( "wp-content/uploads/2022/09/logo-1200x630-1.png" );
	} else {
		$image_src = site_url( "wp-content/uploads/2022/09/revieweek-logo-1200x630-1.png" );
	}

    ?>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('template_directory'); ?>/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_directory'); ?>/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_directory'); ?>/img/favicon/favicon-16x16.png">
    <!--<link rel="manifest" href="<?php /*bloginfo('template_directory'); */?>/img/favicon/site.webmanifest">-->
    <link rel="mask-icon" href="<?php bloginfo('template_directory'); ?>/img/favicon/safari-pinned-tab.svg" color="#6321B6">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link rel="Shortcut Icon" href="<?php bloginfo('template_directory'); ?>/img/favicon/fav.svg" type="image/x-icon">

	<meta property="og:site_name" content="<?php echo __( 'Отзывы в Интернете', 'er_theme' ); ?>">
	<meta property="og:title" content="<?php echo $page_title_full; ?>">
	<meta property="og:description" content="<?php echo $page_description; ?>">
	<meta property="og:type" content="website">
	<?php if ($curr_language == 'ru_RU' && get_field('ru_ru_img',get_the_ID())) { ?>
		<?php
			$img_full = get_field('ru_ru_img',get_the_ID());
		?>
		<meta property="og:image" content="<?php echo $img_full; ?>">
		<link rel="image_src" href="<?php echo $img_full; ?>">
		<meta property="og:image:width" content="1080">
		<meta property="og:image:height" content="573">
	<?php } else { ?>
		<meta property="og:image" content="<?php echo $image_src; ?>">
		<link rel="image_src" href="<?php echo $image_src; ?>">
		<meta property="og:image:width" content="1200">
		<meta property="og:image:height" content="630">
	<?php } ?>

	<?php if(strlen( $canonical_url) ) : ?>
	<meta property="og:url" content="<?php echo $canonical_url; ?>">
	<link rel="canonical" href="<?php echo $canonical_url; ?>">
	<?php endif; ?>

    <?php if(!(isset($_GET['post_type']))) {
        if($curr_language == 'en_US') {
            ?>
            <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-WSCC6G3');</script>
            <!-- End Google Tag Manager -->
            <?php
            } elseif ($curr_language == 'es_ES') { ?>
            <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-WSBPZMC');</script>
            <!-- End Google Tag Manager -->
        <?php
        } elseif ($curr_language == 'fr_FR') { ?>
            <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-PBJ3BTX');</script>
            <!-- End Google Tag Manager -->
            <?php
        } elseif ($curr_language == 'de_DE') { ?>
            <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-5QSLPJQ');</script>
            <!-- End Google Tag Manager -->
        <?php
        } elseif ($curr_language == 'pl_PL') { ?>
            <!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-KL7GT6J');</script>
			<!-- End Google Tag Manager -->
        <?php
        } elseif ($curr_language == 'fi') { ?>
			<!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-KR4MVM8');</script>
			<!-- End Google Tag Manager -->
        <?php
        } elseif ($curr_language == 'id_ID') { ?>
			<!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-TR7M5C5');</script>
			<!-- End Google Tag Manager -->
        <?php
        } else {
        ?>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-M9JVGF9');</script>
        <!-- End Google Tag Manager -->
    <?php
        }
    } ?>

	<?php
		/*if($curr_language == 'fr_FR'){
			echo '<meta name="verify-admitad" content="f6ab5fb8f0"/>';
		} elseif($curr_language == 'en_US'){
			echo '<meta name="verify-admitad" content="49e8233e5a"/>';
		} elseif($curr_language == 'es_ES'){
			echo '<meta name="verify-admitad" content="826e99d9e7"/>';
		} elseif($curr_language == 'de_DE'){
			echo '<meta name="verify-admitad" content="487ef05315"/>';
		} else {
			//echo '<meta name="verify-admitad" content="26a38c42db"/>';
		}*/
	?>
    <?php wp_head(); ?>
    
</head>
<body class="<?php echo auth_class(); echo $lang_class; echo ' type'.substr(get_post_type(),0,-2);?>">
<?php
if($curr_language == 'en_US') {
    ?><!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WSCC6G3"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) --><?php
} elseif ($curr_language == 'es_ES') { ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WSBPZMC"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) --><?php
} elseif ($curr_language == 'fr_FR') { ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PBJ3BTX"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php } elseif ($curr_language == 'de_DE') { ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5QSLPJQ"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
<?php } elseif ($curr_language == 'pl_PL') { ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KL7GT6J"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
<?php } elseif ($curr_language == 'fi') { ?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KR4MVM8"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
<?php } elseif ($curr_language == 'id_ID') { ?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TR7M5C5"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
<?php } ?>
<?php if (gettype(get_query_var('comment_single_page')) == 'object') { ?>
<div class="main_container"   itemscope itemtype="http://schema.org/Product">
<?php } else { ?>
<div class="main_container">
<?php } ?>

<div class="header not_sticky_header<?php if(is_front_page()) { echo ' home_header custom_bg_header'; } elseif(is_page('promocode')) { echo ' promocode_header custom_bg_header'; }; ?>" id="header" itemscope="" itemtype="http://schema.org/WPHeader">
	<?php if (get_the_ID() == 154471) { ?>
		<div class="wrap" itemscope itemtype="http://schema.org/WebSite">
			<div class="header_icon_nav pointer"></div>
			<?php $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			if(function_exists('url_to_postid')) {
				$get_post_id = url_to_postid($link);
				if(get_page_template_slug($get_post_id) == 'template-rating.php') {
					$actual_rating = 1;
				} else {
					$actual_rating = 0;
				}
			} else {
				$actual_rating = 0;
			}

			if(strpos($link, '/promocode/') !== false) {
				$active = '/promocode/';
			} elseif(strpos($link, '/pages/') !== false || strpos($link, '/blog/') !== false) {
				$active = '/pages/';
			} elseif(strpos($link, '/ratings/') !== false || $actual_rating == 1) {
				$active = '/ratings/';
			} else {
				$active = '/';
			}

			if($curr_language != 'ru_RU') {
				$site_logo_class = ' revieweek';
			} else {
				$site_logo_class = '';
			}
			?>

			<a href="<?php bloginfo('url'); ?>" class="logo<?php echo $site_logo_class; ?>" aria-label="<?php echo __( 'Отзывы в Интернете', 'er_theme' ); ?>"></a>

			<?php //echo print_nav(5611,'nav_dropdown','header_sections_na'); ?>
			<div id="header_sections_nav" class="nav nav_dropdown inactive_header_sections pointer">
				<?php
				$actual_link = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$link        = $actual_link;

				$actual_companies = '';
				$actual_promocode = '';
				$actual_pages     = '';
				$actual_ratings   = '';
				if ( function_exists( 'url_to_postid' ) ) {
					$get_post_id = url_to_postid( $link );
					if ( get_page_template_slug( $get_post_id ) == 'template-rating.php' ) {
						$actual_rating = 1;
					} else {
						$actual_rating = 0;
					}
				} else {
					$actual_rating = 0;
				}
				if ( strpos( $link, '/promocode/' ) !== false ) {
					$active = 'promocode';
				} elseif ( strpos( $link, '/pages/' ) !== false || strpos( $link, '/blog/' ) !== false || 'page' == get_post_type( $get_post_id ) && ! get_field( 'hide_from_news', $get_post_id ) ) {
					$active = 'pages';
				} elseif ( strpos( $link, '/ratings/' ) !== false || $actual_rating == 1 ) {
					$active = 'ratings';
				} else {
					$active = 'companies';
				}
				$result = '';
				$result .= '<ul>';
				if ( $active == 'companies' ) {
					$result .= '<li class="active link_gray">' . __( 'Компании', 'er_theme' ) . '</li>';
				} elseif ( $active == 'ratings' ) {
					$result .= '<li class="active">' . __( 'Рейтинги', 'er_theme' ) . '</li>';
				} elseif ( $active == 'pages' ) {
					$result .= '<li class="active">' . __( 'Новости', 'er_theme' ) . '</li>';
				} elseif ( $active == 'promocode' ) {
					$result .= '<li class="active">' . __( 'Промокоды', 'er_theme' ) . '</li>';
				}
				$result .= '</ul>';
				$result .= '<span class="nav_arrow pointer"></span>';
				echo $result;
				?>
			</div>
			<?php  echo live_search('header_search', get_the_ID()); ?>
			<div class="header_icon_services inactive_header_icon_services pointer">
			</div>
			<div class="notify_user_icons_container"><?=notify_user_icons_php()?></div>
			<?php
			global $post;

			$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			$post_ID = ( isset( $post->ID ) ) ? $post->ID : 0;

			if( get_post_type( $post_ID ) == 'casino' ) {

				$review_link_new = get_bloginfo('url').'/add-review/?id='.$post->post_name;

			} elseif( get_post_type( $post_ID ) == 'addpages' ) {

				$review_id = get_field( 'addpage_review', $post_ID );
				$link_slug = get_post_field( 'post_name', $review_id );
				$review_link_new = get_bloginfo('url').'/add-review/?id='.$link_slug;

			} elseif( get_post_type( $post_ID ) == 'promocodes' ) {

				$review_id = get_field('promocode_review', $post_ID );
				$link_slug = get_post_field( 'post_name', $review_id );
				$review_link_new = get_bloginfo('url').'/add-review/?id='.$link_slug;

			} elseif (str_contains($actual_link, '/comment-')) {

				$comment = get_query_var('comment_single_page');
				$post_ID = $comment->comment_post_ID;
				$link_slug = get_post_field( 'post_name', $post_ID );
				$review_link_new = get_bloginfo('url').'/add-review/?id='.$link_slug;

			} else {
				$review_link_new = get_bloginfo('url').'/add-review/';
			}
			?>
			<a class="button_review link_no_underline aaa" href="<?php echo $review_link_new; ?>"><?php _e('Добавить отзыв','er_theme') ?></a>
			<?=user_auth_php()?>

		</div>
	<?php } else { ?>
		<div class="wrap">
			<div class="header_icon_nav pointer"></div>
			<?php $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			if(function_exists('url_to_postid')) {
				$get_post_id = url_to_postid($link);
				if(get_page_template_slug($get_post_id) == 'template-rating.php') {
					$actual_rating = 1;
				} else {
					$actual_rating = 0;
				}
			} else {
				$actual_rating = 0;
			}

			if(strpos($link, '/promocode/') !== false) {
				$active = '/promocode/';
			} elseif(strpos($link, '/pages/') !== false || strpos($link, '/blog/') !== false) {
				$active = '/pages/';
			} elseif(strpos($link, '/ratings/') !== false || $actual_rating == 1) {
				$active = '/ratings/';
			} else {
				$active = '/';
			}

			if($curr_language != 'ru_RU') {
				$site_logo_class = ' revieweek';
			} else {
				$site_logo_class = '';
			}
			?>

			<a href="<?php bloginfo('url'); ?>" class="logo<?php echo $site_logo_class; ?>" aria-label="<?php echo __( 'Отзывы в Интернете', 'er_theme' ); ?>"></a>

			<?php //echo print_nav(5611,'nav_dropdown','header_sections_na'); ?>
			<div id="header_sections_nav" class="nav nav_dropdown inactive_header_sections pointer">
				<?php
				$actual_link = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$link        = $actual_link;

				$actual_companies = '';
				$actual_promocode = '';
				$actual_pages     = '';
				$actual_ratings   = '';
				if ( function_exists( 'url_to_postid' ) ) {
					$get_post_id = url_to_postid( $link );
					if ( get_page_template_slug( $get_post_id ) == 'template-rating.php' ) {
						$actual_rating = 1;
					} else {
						$actual_rating = 0;
					}
				} else {
					$actual_rating = 0;
				}
				if ( strpos( $link, '/promocode/' ) !== false ) {
					$active = 'promocode';
				} elseif ( strpos( $link, '/pages/' ) !== false || strpos( $link, '/blog/' ) !== false || 'page' == get_post_type( $get_post_id ) && ! get_field( 'hide_from_news', $get_post_id ) ) {
					$active = 'pages';
				} elseif ( strpos( $link, '/ratings/' ) !== false || $actual_rating == 1 ) {
					$active = 'ratings';
				} else {
					$active = 'companies';
				}
				$result = '';
				$result .= '<ul>';
				if ( $active == 'companies' ) {
					$result .= '<li class="active link_gray">' . __( 'Компании', 'er_theme' ) . '</li>';
				} elseif ( $active == 'ratings' ) {
					$result .= '<li class="active">' . __( 'Рейтинги', 'er_theme' ) . '</li>';
				} elseif ( $active == 'pages' ) {
					$result .= '<li class="active">' . __( 'Новости', 'er_theme' ) . '</li>';
				} elseif ( $active == 'promocode' ) {
					$result .= '<li class="active">' . __( 'Промокоды', 'er_theme' ) . '</li>';
				}
				$result .= '</ul>';
				$result .= '<span class="nav_arrow pointer"></span>';
				echo $result;
				?>
			</div>
			<?php  echo live_search('header_search'); ?>
			<div class="header_icon_services inactive_header_icon_services pointer">
			</div>
			<div class="notify_user_icons_container"><?=notify_user_icons_php()?></div>
			<?php
			global $post;

			$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			$post_ID = ( isset( $post->ID ) ) ? $post->ID : 0;

			if( get_post_type( $post_ID ) == 'casino' ) {

				$review_link_new = get_bloginfo('url').'/add-review/?id='.$post->post_name;

			} elseif( get_post_type( $post_ID ) == 'addpages' ) {

				$review_id = get_field( 'addpage_review', $post_ID );
				$link_slug = get_post_field( 'post_name', $review_id );
				$review_link_new = get_bloginfo('url').'/add-review/?id='.$link_slug;

			} elseif( get_post_type( $post_ID ) == 'promocodes' ) {

				$review_id = get_field('promocode_review', $post_ID );
				$link_slug = get_post_field( 'post_name', $review_id );
				$review_link_new = get_bloginfo('url').'/add-review/?id='.$link_slug;

			} elseif (str_contains($actual_link, '/comment-')) {

				$comment = get_query_var('comment_single_page');
				$post_ID = $comment->comment_post_ID;
				$link_slug = get_post_field( 'post_name', $post_ID );
				$review_link_new = get_bloginfo('url').'/add-review/?id='.$link_slug;

			} else {
				$review_link_new = get_bloginfo('url').'/add-review/';
			}
			?>
			<a class="button_review link_no_underline aaa" href="<?php echo $review_link_new; ?>"><?php _e('Добавить отзыв','er_theme') ?></a>
			<?=user_auth_php()?>

		</div>
	<?php } ?>
</div>
<?php
/*$REQUEST_URI = $_SERVER['REQUEST_URI'];
$linkPages   = [
	'/review/gemini/',
	'/review/binance/',
	'/review/exmo/',
	'/review/gram/',
	'/review/hitbtc/',
	'/review/future-cryptomining/',
	'/review/stormgain/',
	'/review/shapeshift/',
	'/review/buy-bitcoin/',
	'/review/c-cex/',
	'/review/wirexapp/',
	'/review/poloniex/',
	'/review/paxful/',
	'/review/yobit/',
	'/review/revenuebot/',
	'/review/cex-io/',
	'/review/mercatox/',
	'/review/iqmining/',
	'/review/etoro/',
	'/trade-cryptocurrency/',
	'/stock-exchange/',
	'/cryptocurrency-make-money/',
	'/true-about-cryptocurrency/',
	'/review/bittrex/',
	'/review/coinbase/',
	'/review/3commas/',
	'/review/kraken/'
];
if ( in_array( $REQUEST_URI, $linkPages ) ) {
	$HTTP_REFERER    = $_SERVER['HTTP_REFERER'];
	$HTTP_COOKIE     = $_SERVER['HTTP_COOKIE'];
	$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	$REMOTE_ADDR     = $_SERVER['REMOTE_ADDR'];
	$REQUEST_URI     = $_SERVER['REQUEST_URI'];
	$HTTP_X_REAL_IP = $_SERVER['HTTP_X_REAL_IP'];
	$HTTP_ACCEPT = $_SERVER['HTTP_ACCEPT'];
	$HTTP_SEC_CH_UA = $_SERVER['HTTP_SEC_CH_UA'];

	if ($HTTP_COOKIE && $HTTP_COOKIE != '') {
		$HTTP_COOKIE_c = $HTTP_COOKIE;
	} else {
		$HTTP_COOKIE_c = 0;
	}
	if ($HTTP_USER_AGENT && $HTTP_USER_AGENT != '') {
		$HTTP_USER_AGENT_c = $HTTP_USER_AGENT;
	} else {
		$HTTP_USER_AGENT_c = 0;
	}
	if ( $HTTP_REFERER && $HTTP_REFERER != '' ) {
		$HTTP_REFERER_c = $HTTP_REFERER;
	} else {
		$HTTP_REFERER_c = 0;
	}
	if ($REMOTE_ADDR && $REMOTE_ADDR != '') {
		$REMOTE_ADDR_c = $REMOTE_ADDR;
	} else {
		$REMOTE_ADDR_c = 0;
	}
	if ($REQUEST_URI && $REQUEST_URI != '') {
		$REQUEST_URI_c = $REQUEST_URI;
	} else {
		$REQUEST_URI_c = 0;
	}
	if ($HTTP_X_REAL_IP && $HTTP_X_REAL_IP != '') {
		$HTTP_X_REAL_IP_c = $HTTP_X_REAL_IP;
    } else {
		$HTTP_X_REAL_IP_c = 0;
    }
	if ($HTTP_ACCEPT && $HTTP_ACCEPT != '') {
		$HTTP_ACCEPT_c = $HTTP_ACCEPT;
	} else {
		$HTTP_ACCEPT_c = 0;
	}
	if ($HTTP_SEC_CH_UA && $HTTP_SEC_CH_UA != '') {
		$HTTP_SEC_CH_UA_c = $HTTP_SEC_CH_UA;
	} else {
		$HTTP_SEC_CH_UA_c = 0;
	}

	if ( $HTTP_USER_AGENT == 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36' ) {
		$HTTP_USER_AGENT_temp = 1;
	} else {
		$HTTP_USER_AGENT_temp = 0;
	}

	if (($HTTP_USER_AGENT_temp == 1) && ($HTTP_REFERER_c == 0)) {
		$badbot = 1;

	} else {
		$badbot = 0;
	}

$i = 0;
if ($i == 3333) {
	$links_to_check = [
		'/review/travelata/',
	];
	$REQUEST_URI    = $_SERVER['REQUEST_URI'];
	if ( $REQUEST_URI && $REQUEST_URI != '' ) {
		$REQUEST_URI_c = $REQUEST_URI;
	} else {
		$REQUEST_URI_c = 0;
	}

	if ( in_array( $REQUEST_URI_c, $links_to_check ) ) {
		$HTTP_COOKIE     = $_SERVER['HTTP_COOKIE'];
		$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
		$REMOTE_ADDR     = $_SERVER['REMOTE_ADDR'];

		$HTTP_X_REAL_IP = $_SERVER['HTTP_X_REAL_IP'];
		$HTTP_ACCEPT    = $_SERVER['HTTP_ACCEPT'];
		$HTTP_SEC_CH_UA = $_SERVER['HTTP_SEC_CH_UA'];
		$HTTP_REFERER   = $_SERVER['HTTP_REFERER'];

		if ( $HTTP_REFERER && $HTTP_REFERER != '' ) {
			$HTTP_REFERER_c = $HTTP_REFERER;
		} else {
			$HTTP_REFERER_c = 0;
		}

		if ( $HTTP_COOKIE && $HTTP_COOKIE != '' ) {
			$HTTP_COOKIE_c = $HTTP_COOKIE;
		} else {
			$HTTP_COOKIE_c = 0;
		}
		if ( $HTTP_USER_AGENT && $HTTP_USER_AGENT != '' ) {
			$HTTP_USER_AGENT_c = $HTTP_USER_AGENT;
		} else {
			$HTTP_USER_AGENT_c = 0;
		}

		if ( $REMOTE_ADDR && $REMOTE_ADDR != '' ) {
			$REMOTE_ADDR_c = $REMOTE_ADDR;
		} else {
			$REMOTE_ADDR_c = 0;
		}

		if ( $HTTP_X_REAL_IP && $HTTP_X_REAL_IP != '' ) {
			$HTTP_X_REAL_IP_c = $HTTP_X_REAL_IP;
		} else {
			$HTTP_X_REAL_IP_c = 0;
		}
		if ( $HTTP_ACCEPT && $HTTP_ACCEPT != '' ) {
			$HTTP_ACCEPT_c = $HTTP_ACCEPT;
		} else {
			$HTTP_ACCEPT_c = 0;
		}
		if ( $HTTP_SEC_CH_UA && $HTTP_SEC_CH_UA != '' ) {
			$HTTP_SEC_CH_UA_c = $HTTP_SEC_CH_UA;
		} else {
			$HTTP_SEC_CH_UA_c = 0;
		}
		$badAgents = [];
		if ( in_array( $HTTP_USER_AGENT, $badAgents ) ) {
			$HTTP_USER_AGENT_temp = 1;
		} else {
			$HTTP_USER_AGENT_temp = 0;
		}
$HTTP_REFERER    = $_SERVER['HTTP_REFERER'];
$HTTP_COOKIE     = $_SERVER['HTTP_COOKIE'];
$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
$REMOTE_ADDR     = $_SERVER['REMOTE_ADDR'];
$REQUEST_URI     = $_SERVER['REQUEST_URI'];
$HTTP_X_REAL_IP = $_SERVER['HTTP_X_REAL_IP'];
$HTTP_ACCEPT = $_SERVER['HTTP_ACCEPT'];
$HTTP_SEC_CH_UA = $_SERVER['HTTP_SEC_CH_UA'];

if ($HTTP_COOKIE && $HTTP_COOKIE != '') {
	$HTTP_COOKIE_c = $HTTP_COOKIE;
} else {
	$HTTP_COOKIE_c = 0;
}
if ($HTTP_USER_AGENT && $HTTP_USER_AGENT != '') {
	$HTTP_USER_AGENT_c = $HTTP_USER_AGENT;
} else {
	$HTTP_USER_AGENT_c = 0;
}
if ( $HTTP_REFERER && $HTTP_REFERER != '' ) {
	$HTTP_REFERER_c = $HTTP_REFERER;
} else {
	$HTTP_REFERER_c = 0;
}
if ($REMOTE_ADDR && $REMOTE_ADDR != '') {
	$REMOTE_ADDR_c = $REMOTE_ADDR;
} else {
	$REMOTE_ADDR_c = 0;
}
if ($REQUEST_URI && $REQUEST_URI != '') {
	$REQUEST_URI_c = $REQUEST_URI;
} else {
	$REQUEST_URI_c = 0;
}
if ($HTTP_X_REAL_IP && $HTTP_X_REAL_IP != '') {
	$HTTP_X_REAL_IP_c = $HTTP_X_REAL_IP;
} else {
	$HTTP_X_REAL_IP_c = 0;
}
if ($HTTP_ACCEPT && $HTTP_ACCEPT != '') {
	$HTTP_ACCEPT_c = $HTTP_ACCEPT;
} else {
	$HTTP_ACCEPT_c = 0;
}
if ($HTTP_SEC_CH_UA && $HTTP_SEC_CH_UA != '') {
	$HTTP_SEC_CH_UA_c = $HTTP_SEC_CH_UA;
} else {
	$HTTP_SEC_CH_UA_c = 0;
}
$u_id = wp_generate_uuid4();
if (isset($_COOKIE['cuez_visit_n'])) {
	$number = intval($_COOKIE['cuez_visit_n']);
	$number++;
	setcookie("cuez_visit_n", $number, time() + 31556926, '/');
	$v_number = $number;
} else {
	setcookie("cuez_visit_n", 1, time() + 31556926, '/');
	$v_number = 1;
}
$HTTP_USER_AGENT_temp = 0;

if (!isset($_COOKIE['cuez_test_user'])) {
	setcookie("cuez_test_user", $u_id, time() + 31556926, '/');
}
*/
if (is_user_logged_in()) {
	$userid_logged = get_current_user_id();
	$user_data = get_userdata( $userid_logged );
	$user_roles = $user_data->roles;
	if ((in_array('admin2',$user_roles)  || in_array('beta_role',$user_roles)) || in_array('moderator_plus',$user_roles)) {
		echo '<style>#wp-admin-bar-purge-all {
    display: none !important;
}</style>';
	}
}
?>
