<div class="footer_top">
	<?=pre_footer_php()?>
</div>
<?php //echo fast_links('footer_fast_links');?>

<div class="footer" itemscope="" itemtype="http://schema.org/WPFooter">
    <?php
    global $post;
    $current_language = get_locale();
    $is_enabled = array();
    $is_enabled = get_field('enable_translations',$post->ID);
    if(	
		// $current_language == 'ru_RU' && in_array( 'en_US', $is_enabled ) || 
		$current_language == 'en_US' || 
		$current_language == 'fr_FR' || 
		$current_language == 'de_DE' || 
		$current_language == 'es_ES' || 
		$current_language == 'pl_PL' ||
		$current_language == 'id_ID' ||
		$current_language == 'fi' 
	) {

        echo '<div class="translate-switcher"><div class="wrap">' . do_shortcode('[language-switcher]') . '</div></div>';

    }?>

	<?=main_footer_php()?>
</div>
<span class="ID_hid" style="display:none;"><?php echo $post->ID; ?></span>

</div>
<?php
$sitemap_name = 'Карта сайта';
$current_language = get_locale();
if($current_language == 'en_US') {$sitemap_name = 'Sitemap'; ?>
    
<style type="text/css">
    .popup_banners_get .popup_banner:before {
        content: 'Special Offer' !important;
    }
    .promocode_heygo .popup_close_button:after, .popup_banners_get .popup_close_button:after, .heygo_container .popup_close_button:after {
        content: 'Close' !important;
    }
    .white_block.flex.flex_column.soon:after, .bar_nav ul li.soon span:after, .services_list a.soon:after {
        content: 'Soon' !important;
    }
    @media screen and (max-width: 1210px) {
        .main_row .rating_field_number:before {
            content: 'Place # ' !important;
        }
    }

	.popup_bs_get .popup_b:before {
		content: 'Special Offer' !important;
	}
	.promocode_heygo .popup_close_button:after, .popup_bs_get .popup_close_button:after, .heygo_container .popup_close_button:after {
		content: 'Close' !important;
	}
	.white_block.flex.flex_column.soon:after, .bar_nav ul li.soon span:after, .services_list a.soon:after {
		content: 'Soon' !important;
	}
	@media screen and (max-width: 1210px) {
		.main_row .rating_field_number:before {
			content: 'Place # ' !important;
		}
	}
</style>
<?php } elseif($current_language == 'fr_FR') {$sitemap_name = 'Sitemap'; ?>
    <style type="text/css">
        .popup_banners_get .popup_banner:before {
            content: 'Offre spéciale' !important;
        }
        .promocode_heygo .popup_close_button:after, .popup_banners_get .popup_close_button:after, .heygo_container .popup_close_button:after {
            content: 'Fermer' !important;
        }
		.popup_bs_get .popup_b:before {
			content: 'Offre spéciale' !important;
		}
		.promocode_heygo .popup_close_button:after, .popup_bs_get .popup_close_button:after, .heygo_container .popup_close_button:after {
			content: 'Fermer' !important;
		}
        .white_block.flex.flex_column.soon:after, .bar_nav ul li.soon span:after, .services_list a.soon:after {
            content: 'Bientôt' !important;
        }
        @media screen and (max-width: 1210px) {
            .main_row .rating_field_number:before {
                content: 'Place # ' !important;
            }
        }

    </style>
<?php } elseif($current_language == 'es_ES') {$sitemap_name = 'Sitemap'; ?>
    <style type="text/css">
        .popup_banners_get .popup_banner:before {
            content: 'Oferta especial' !important;
        }
        .promocode_heygo .popup_close_button:after, .popup_banners_get .popup_close_button:after, .heygo_container .popup_close_button:after {
            content: 'Cerrar' !important;
        }
		.popup_bs_get .popup_b:before {
			content: 'Oferta especial' !important;
		}
		.promocode_heygo .popup_close_button:after, .popup_bs_get .popup_close_button:after, .heygo_container .popup_close_button:after {
			content: 'Cerrar' !important;
		}
        .white_block.flex.flex_column.soon:after, .bar_nav ul li.soon span:after, .services_list a.soon:after {
            content: 'Próximamente' !important;
        }
        @media screen and (max-width: 1210px) {
            .main_row .rating_field_number:before {
                content: 'Lugar # ' !important;
            }
        }
    </style>
<?php } elseif($current_language == 'de_DE') {$sitemap_name = 'Sitemap'; ?>
    <style type="text/css">
        .popup_banners_get .popup_banner:before {
            content: 'Sonderangebot' !important;
        }
        .promocode_heygo .popup_close_button:after, .popup_banners_get .popup_close_button:after, .heygo_container .popup_close_button:after {
            content: 'Schließen' !important;
        }
		.popup_bs_get .popup_b:before {
			content: 'Sonderangebot' !important;
		}
		.promocode_heygo .popup_close_button:after, .popup_bs_get .popup_close_button:after, .heygo_container .popup_close_button:after {
			content: 'Schließen' !important;
		}
        .white_block.flex.flex_column.soon:after, .bar_nav ul li.soon span:after, .services_list a.soon:after {
            content: 'Demnächst' !important;
        }
        @media screen and (max-width: 1210px) {
            .main_row .rating_field_number:before {
                content: 'Platz # ' !important;
            }
        }
    </style>
<?php } elseif($current_language == 'pl_PL') {$sitemap_name = 'Mapa strony'; ?>
    <style type="text/css">
        .popup_banners_get .popup_banner:before {
            content: 'Oferta Specjalna' !important;
        }
        .promocode_heygo .popup_close_button:after, .popup_banners_get .popup_close_button:after, .heygo_container .popup_close_button:after {
            content: 'Zamknij' !important;
        }
		.popup_bs_get .popup_b:before {
			content: 'Oferta Specjalna' !important;
		}
		.promocode_heygo .popup_close_button:after, .popup_bs_get .popup_close_button:after, .heygo_container .popup_close_button:after {
			content: 'Zamknij' !important;
		}
        .white_block.flex.flex_column.soon:after, .bar_nav ul li.soon span:after, .services_list a.soon:after {
            content: 'Wkrótce' !important;
        }
        @media screen and (max-width: 1210px) {
            .main_row .rating_field_number:before {
                content: 'Miejsce # ' !important;
            }
        }
    </style>
<?php } elseif($current_language == 'fi') {$sitemap_name = 'Sivukartta'; ?>
    <style type="text/css">
        .popup_banners_get .popup_banner:before {
            content: 'Erikoistarjous' !important;
        }
        .promocode_heygo .popup_close_button:after, .popup_banners_get .popup_close_button:after, .heygo_container .popup_close_button:after {
            content: 'Sulje' !important;
        }
		.popup_bs_get .popup_b:before {
			content: 'Erikoistarjous' !important;
		}
		.promocode_heygo .popup_close_button:after, .popup_bs_get .popup_close_button:after, .heygo_container .popup_close_button:after {
			content: 'Sulje' !important;
		}
        .white_block.flex.flex_column.soon:after, .bar_nav ul li.soon span:after, .services_list a.soon:after {
            content: 'Pian' !important;
        }
        @media screen and (max-width: 1210px) {
            .main_row .rating_field_number:before {
                content: 'Paikka # ' !important;
            }
        }
    </style>
<?php } elseif($current_language == 'id_ID') {$sitemap_name = 'Sitemap'; ?>
    <style type="text/css">
        .popup_banners_get .popup_banner:before {
            content: 'Penawaran Khusus' !important;
        }
        .promocode_heygo .popup_close_button:after, .popup_banners_get .popup_close_button:after, .heygo_container .popup_close_button:after {
            content: 'Tutup' !important;
        }
		.popup_bs_get .popup_b:before {
			content: 'Penawaran Khusus' !important;
		}
		.promocode_heygo .popup_close_button:after, .popup_bs_get .popup_close_button:after, .heygo_container .popup_close_button:after {
			content: 'Tutup' !important;
		}
        .white_block.flex.flex_column.soon:after, .bar_nav ul li.soon span:after, .services_list a.soon:after {
            content: 'Segera' !important;
        }
        @media screen and (max-width: 1210px) {
            .main_row .rating_field_number:before {
                content: 'Tempat # ' !important;
            }
        }
    </style>
<?php }
?>
<a href="<?php echo get_bloginfo('url'); ?>/sitemap/" class="sitemap_link"><?php _e($sitemap_name,'er_theme'); ?></a>
<div id="popup_modals"></div>
<div class="popup_bs_get popup_bs_get__updated"></div>
<!--div class="popup_bs_get popup_bs_get__updated"><?php //show_popup_old_php(get_the_ID()); ?></div-->
<div class="cookie_container"></div>
<button onclick="topFunction()" id="myBtn" title="Go to top" style=""></button>
<?php if($current_language == 'ru_RU') { ?>
	<?php if (get_field('right_side_show', $post->ID) != 1) { ?>
		<!-- Begin Talk-Me {literal} -->
		<script type='text/javascript'>
			setTimeout(function() {

				(function(d, w, m) {
					window.supportAPIMethod = m;
					var s = d.createElement('script');
					s.type ='text/javascript'; s.id = 'supportScript'; s.charset = 'utf-8';
					s.async = true;
					var id = '894884f085404f7ade01407ad744b3d6';
					s.src = 'https://lcab.talk-me.ru/support/support.js?h='+id;
					var sc = d.getElementsByTagName('script')[0];
					w[m] = w[m] || function() { (w[m].q = w[m].q || []).push(arguments); };
					if (sc) sc.parentNode.insertBefore(s, sc);
					else d.documentElement.firstChild.appendChild(s);
				})(document, window, 'TalkMe');
			}, 5000);
		</script>
		<!-- {/literal} End Talk-Me -->
	<?php } else {
		//echo '<style>#myBtn {right: unset;left: 28px;} #icon_user_gift{right: unset;left: 20px;}</style>';
	} ?>
<?php } else { ?>
	<?php if($current_language == 'fr_FR') { ?>
		<!-- Begin Talk-Me {literal} -->
		<script>
			(function(){(function c(d,w,m,i) {
				window.supportAPIMethod = m;
				var s = d.createElement('script');
				s.id = 'supportScript';
				var id = '894884f085404f7ade01407ad744b3d6';
				s.src = (!i ? 'https://lcab.talk-me.ru/support/support.js' : 'https://static.site-chat.me/support/support.int.js') + '?h=' + id;
				s.onerror = i ? undefined : function(){c(d,w,m,true)};
				w[m] = w[m] || function(){(w[m].q = w[m].q || []).push(arguments);};
				(d.head || d.body).appendChild(s);
			})(document,window,'TalkMe')})();
		</script>
		<!-- {/literal} End Talk-Me -->
	<?php } elseif ($current_language == 'es_ES') { ?>
		<!-- Begin Talk-Me {literal} -->
		<script>
			(function(){(function c(d,w,m,i) {
				window.supportAPIMethod = m;
				var s = d.createElement('script');
				s.id = 'supportScript';
				var id = '894884f085404f7ade01407ad744b3d6';
				s.src = (!i ? 'https://lcab.talk-me.ru/support/support.js' : 'https://static.site-chat.me/support/support.int.js') + '?h=' + id;
				s.onerror = i ? undefined : function(){c(d,w,m,true)};
				w[m] = w[m] || function(){(w[m].q = w[m].q || []).push(arguments);};
				(d.head || d.body).appendChild(s);
			})(document,window,'TalkMe')})();
		</script>
		<!-- {/literal} End Talk-Me -->
	<?php } elseif($current_language == 'de_DE') { ?>
		<!-- Begin Talk-Me {literal} -->
		<script>
			(function(){(function c(d,w,m,i) {
				window.supportAPIMethod = m;
				var s = d.createElement('script');
				s.id = 'supportScript';
				var id = '894884f085404f7ade01407ad744b3d6';
				s.src = (!i ? 'https://lcab.talk-me.ru/support/support.js' : 'https://static.site-chat.me/support/support.int.js') + '?h=' + id;
				s.onerror = i ? undefined : function(){c(d,w,m,true)};
				w[m] = w[m] || function(){(w[m].q = w[m].q || []).push(arguments);};
				(d.head || d.body).appendChild(s);
			})(document,window,'TalkMe')})();
		</script>
		<!-- {/literal} End Talk-Me -->
	<?php } elseif($current_language == 'en_US') { ?>
		<!-- Begin Talk-Me {literal} -->
		<script>
			(function(){(function c(d,w,m,i) {
				window.supportAPIMethod = m;
				var s = d.createElement('script');
				s.id = 'supportScript';
				var id = '894884f085404f7ade01407ad744b3d6';
				s.src = (!i ? 'https://lcab.talk-me.ru/support/support.js' : 'https://static.site-chat.me/support/support.int.js') + '?h=' + id;
				s.onerror = i ? undefined : function(){c(d,w,m,true)};
				w[m] = w[m] || function(){(w[m].q = w[m].q || []).push(arguments);};
				(d.head || d.body).appendChild(s);
			})(document,window,'TalkMe')})();
		</script>
		<!-- {/literal} End Talk-Me -->
	<?php } elseif($current_language == 'pl_PL') { ?>
		<!-- Begin Talk-Me {literal} -->
		<script>
			(function(){(function c(d,w,m,i) {
				window.supportAPIMethod = m;
				var s = d.createElement('script');
				s.id = 'supportScript';
				var id = '894884f085404f7ade01407ad744b3d6';
				s.src = (!i ? 'https://lcab.talk-me.ru/support/support.js' : 'https://static.site-chat.me/support/support.int.js') + '?h=' + id;
				s.onerror = i ? undefined : function(){c(d,w,m,true)};
				w[m] = w[m] || function(){(w[m].q = w[m].q || []).push(arguments);};
				(d.head || d.body).appendChild(s);
			})(document,window,'TalkMe')})();
		</script>
		<!-- {/literal} End Talk-Me -->
	<?php } elseif($current_language == 'id_ID') { ?>
		<!-- Begin Talk-Me {literal} -->
		<script>
			(function(){(function c(d,w,m,i) {
				window.supportAPIMethod = m;
				var s = d.createElement('script');
				s.id = 'supportScript';
				var id = '894884f085404f7ade01407ad744b3d6';
				s.src = (!i ? 'https://lcab.talk-me.ru/support/support.js' : 'https://static.site-chat.me/support/support.int.js') + '?h=' + id;
				s.onerror = i ? undefined : function(){c(d,w,m,true)};
				w[m] = w[m] || function(){(w[m].q = w[m].q || []).push(arguments);};
				(d.head || d.body).appendChild(s);
			})(document,window,'TalkMe')})();
		</script>
		<!-- {/literal} End Talk-Me -->
	<?php } elseif($current_language == 'fi') { ?>
		<!-- Begin Talk-Me {literal} -->
		<script>
			(function(){(function c(d,w,m,i) {
				window.supportAPIMethod = m;
				var s = d.createElement('script');
				s.id = 'supportScript';
				var id = '894884f085404f7ade01407ad744b3d6';
				s.src = (!i ? 'https://lcab.talk-me.ru/support/support.js' : 'https://static.site-chat.me/support/support.int.js') + '?h=' + id;
				s.onerror = i ? undefined : function(){c(d,w,m,true)};
				w[m] = w[m] || function(){(w[m].q = w[m].q || []).push(arguments);};
				(d.head || d.body).appendChild(s);
			})(document,window,'TalkMe')})();
		</script>
		<!-- {/literal} End Talk-Me -->
	<?php } ?>
<?php } ?>

<?php wp_footer(); ?>
<?php
if (isset($_GET['translateid']) && !(empty($_GET['translateid']))) {
	if (is_user_logged_in()) {
		$vals = get_field('enable_translations',108048);
		if (get_field('enable_translations',intval($_GET['translateid'])) != $vals) {
			$arr = [ 'en_US', 'fr_FR', 'es_ES', 'de_DE' ];
			update_field( 'enable_translations', $vals, intval($_GET['translateid']) );
		}
	}
}
if (isset($_GET['check_untranslated'])) {
	if (is_user_logged_in()) {
		echo '<style>.main_row[data-b="en_US,fr_FR,es_ES,de_DE,pl_PL,fi,id_ID"] {
    			background: #21b57b;
		}</style>';
	}
}

$curr_language = get_locale();
if ( $curr_language == 'ru_RU' ) {
	if ( get_field( 'widget_social', $post->ID ) == 'stoyuristov' ) {
		if ( get_field( 'turn_off_stoyuristov', $post->ID ) == 1 ) {

		} else {

		}
		echo '
			<div id="widget100Form">
				<script class="widget100-script" src="/widget100.js?uuid=FG42NGhUoGmYDFNJCMpmcp"></script>
			</div>';
	}

	if ( get_field( 'widget_social', $post->ID ) == 'stoyuristov_zvonok' ) {
		if ( get_field( 'turn_off_stoyuristov', $post->ID ) == 1 ) {

		} else {

		}
		echo '
			<div id="widget100Form">
				<script class="widget100-script" src="/widget100.js?uuid=WMs5WwFmrN9xbJzjoUP26r"></script>
			</div>';
	}

	if ( get_field( 'widget_social', $post->ID ) == 'feedot_chat' ) { ?>
		<!-- Загрузчик виджетов Feedot -->
		<script>
			(function(f,ee,d,o,t) {
				if (ee._feedot) return;
				ee._feedot = f;
				o = d.createElement('script');
				o.src = 'https://widget.info-static.ru/js/init.js?t='+(new Date().getTime());
				o.defer = true;
				d.body.appendChild(o);
			})('1c94885a3baabafe0ead07987653059d', window, document);
		</script>
		<!-- /Загрузчик виджетов Feedot -->
		<div id="feedot--inline-form-popup--16448"></div>
	<?php }
	if ( get_field( 'widget_social', $post->ID ) == 'justiva' ) { ?>
		<script type="text/javascript">(function(metaWindow,c){metaWindow.jus_custom_param={webmaster:{webmaster_id:"15124",subaccount:""},widgetStyle:{position:"left",bottom:"0",left:"0",right:"0",mobileBottom:"0"}};var WebDGapLoadScripts=function(widgetURL,$q){var script=c.createElement("script");script.type="text/javascript";script.charset="UTF-8";script.src=widgetURL;if("undefined"!==typeof $q){metaWindow.lcloaderror=true;script.onerror=$q}c.body.appendChild(script)};WebDGapLoadScripts("/8894f3bdbcdf.php",function(){WebDGapLoadScripts("https://uberlaw.ru/js/widget-a-b.js")})})(window,document);</script>
	<?php 
	}
	
// 	if ( get_field( 'widget_social', $post->ID ) == 'osago24online' ) {

// 		echo "
// 			<div id='widgetosago24online'>
// 				<script>var B2CWidgetLocation = 'https://my.agenters.ru/widgets/eosago/';</script>
// 				<script id='app-b2c-module-root' src='https://my.agenters.ru/widgets/eosago/assets/b2c-frame.loader.js'></script>
// 			</div>
// 			<script>
// 				$('#widgetosago24online').on('bonus_b_t_appended', function( event ) {
// 					$('#reviewsummary').after($('#widgetosago24online'));

// // console.log('APPEND');
// // 					if( $('.bonus_b_t') ) {
// // console.log('APPEND bonus_b_t');
// // 						$('#reviewsummary').after($('#widgetosago24online'));
// // 					} else {
// // console.log('APPEND reviewsummary');
// // 						$('#reviewsummary').after($('#widgetosago24online'));
// // 					}
// 				});

// 				$('#reviewsummary').after($('#widgetosago24online'));
// 				$('#widgetosago24online').show();
// 			</script>
// 		";

// 	}

}
if (((get_post_type(get_the_ID()) == 'casino') || (get_post_type(get_the_ID()) == 'post') || (get_post_type(get_the_ID()) == 'page'))  && get_locale() == 'en_US' && $_GET['go_translate'] == 1) {
	$get_id_casino = get_the_ID();
	$translations = get_field('translations',$get_id_casino);
	$arr_translations = [];
	foreach ($translations  as $item ) {
		$arr_translations[] = $item['translation_language'];
	}

	if (!in_array('pl_PL',$arr_translations)) {
		update_field('translate_separately',true,$get_id_casino);
		$url = get_the_permalink($get_id_casino).'?get_translated';

		$content = file_get_contents($url);

		$first_step = explode( 'id="get_con">' , $content );

		$second_step = explode('<span class="d_class_m">' , $first_step[1] );
		$raised = trim($second_step[0]);
		$raised = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $raised);
		$raised = str_replace('fraudbroker.com', 'revieweek.com', $raised);
		$raised = str_replace('https://revieweek.com', 'https://pl.revieweek.com', $raised);

		$message = trp_translate($raised, 'pl_PL',false);
		$row = array(
			'translation_language' => 'pl_PL',
			'translation_content' => $message
		);

		add_row('translations', $row,$get_id_casino);
	} else {
		$position = array_search('pl_PL', $arr_translations);
		$position = ++$position;
		update_field('translate_separately',true,$get_id_casino);
		$url = get_the_permalink($get_id_casino).'?get_translated';

		$content = file_get_contents($url);

		$first_step = explode( 'id="get_con">' , $content );

		$second_step = explode('<span class="d_class_m">' , $first_step[1] );
		$raised = trim($second_step[0]);
		$raised = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $raised);
		$raised = str_replace('fraudbroker.com', 'revieweek.com', $raised);
		$raised = str_replace('https://revieweek.com', 'https://pl.revieweek.com', $raised);

		$message = trp_translate($raised, 'pl_PL',false);
		$row = array(
			'translation_language' => 'pl_PL',
			'translation_content' => $message
		);
		update_row('translations', $position, $row,$get_id_casino);
	}
}

if (((get_post_type(get_the_ID()) == 'casino') || (get_post_type(get_the_ID()) == 'post') || (get_post_type(get_the_ID()) == 'page'))  && get_locale() == 'en_US' && $_GET['go_translate_id'] == 1) {
	$get_id_casino = get_the_ID();
	$translations = get_field('translations',$get_id_casino);
	$arr_translations = [];
	foreach ($translations  as $item ) {
		$arr_translations[] = $item['translation_language'];
	}

	if (!in_array('id_ID',$arr_translations)) {
		update_field('translate_separately',true,$get_id_casino);
		$url = get_the_permalink($get_id_casino).'?get_translated_id';

		$content = file_get_contents($url);

		$first_step = explode( 'id="get_con">' , $content );

		$second_step = explode('<span class="d_class_m">' , $first_step[1] );
		$raised = trim($second_step[0]);
		$raised = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $raised);
		$raised = str_replace('fraudbroker.com', 'revieweek.com', $raised);
		$raised = str_replace('https://revieweek.com', 'https://id.revieweek.com', $raised);

		$message = trp_translate($raised, 'id_ID',false);
		$row = array(
			'translation_language' => 'id_ID',
			'translation_content' => $message
		);

		add_row('translations', $row,$get_id_casino);
	} else {
		$position = array_search('id_ID', $arr_translations);
		$position = ++$position;
		update_field('translate_separately',true,$get_id_casino);
		$url = get_the_permalink($get_id_casino).'?get_translated_id';

		$content = file_get_contents($url);

		$first_step = explode( 'id="get_con">' , $content );

		$second_step = explode('<span class="d_class_m">' , $first_step[1] );
		$raised = trim($second_step[0]);
		$raised = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $raised);
		$raised = str_replace('fraudbroker.com', 'revieweek.com', $raised);
		$raised = str_replace('https://revieweek.com', 'https://id.revieweek.com', $raised);

		$message = trp_translate($raised, 'id_ID',false);
		$row = array(
			'translation_language' => 'id_ID',
			'translation_content' => $message
		);
		update_row('translations', $position, $row,$get_id_casino);
	}
}
if (((get_post_type(get_the_ID()) == 'casino') || (get_post_type(get_the_ID()) == 'post') || (get_post_type(get_the_ID()) == 'page'))  && get_locale() == 'en_US' && $_GET['go_translate_fi'] == 1) {
	$get_id_casino = get_the_ID();
	$translations = get_field('translations',$get_id_casino);
	$arr_translations = [];
	foreach ($translations  as $item ) {
		$arr_translations[] = $item['translation_language'];
	}

	if (!in_array('fi',$arr_translations)) {
		update_field('translate_separately',true,$get_id_casino);
		$url = get_the_permalink($get_id_casino).'?get_translated_fi';

		$content = file_get_contents($url);

		$first_step = explode( 'id="get_con">' , $content );

		$second_step = explode('<span class="d_class_m">' , $first_step[1] );
		$raised = trim($second_step[0]);
		$raised = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $raised);
		$raised = str_replace('fraudbroker.com', 'revieweek.com', $raised);
		$raised = str_replace('https://revieweek.com', 'https://fi.revieweek.com', $raised);

		$message = trp_translate($raised, 'fi',false);
		$row = array(
			'translation_language' => 'fi',
			'translation_content' => $message
		);

		add_row('translations', $row,$get_id_casino);
	} else {
		$position = array_search('fi', $arr_translations);
		$position = ++$position;
		update_field('translate_separately',true,$get_id_casino);
		$url = get_the_permalink($get_id_casino).'?get_translated_fi';

		$content = file_get_contents($url);

		$first_step = explode( 'id="get_con">' , $content );

		$second_step = explode('<span class="d_class_m">' , $first_step[1] );
		$raised = trim($second_step[0]);
		$raised = str_replace('fraudbroker.com/wp-content/uploads/', 'revieweek.com/wp-content/wp-broker/', $raised);
		$raised = str_replace('fraudbroker.com', 'revieweek.com', $raised);
		$raised = str_replace('https://revieweek.com', 'https://fi.revieweek.com', $raised);

		$message = trp_translate($raised, 'fi',false);
		$row = array(
			'translation_language' => 'fi',
			'translation_content' => $message
		);
		update_row('translations', $position, $row,$get_id_casino);
	}
}
?>
</body></html>