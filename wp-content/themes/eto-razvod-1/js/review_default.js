$ = jQuery.noConflict();


function ajax_similar_companies(post_id) {
	$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=ajax_similar_companies&post_id="+post_id,
			beforeSend: function(xhr) {
				$( '.review_container_similar .container_left .similar_container' ).empty();
				$('.review_container_similar .container_left .similar_container').append('<div class="load_ajax"></div>');
			},
			complete: function(){
				$('.review_container_similar .container_left .load_ajax').remove();
			},
			success: function( data ) {
				
				$( '.review_container_similar .container_left .similar_container' ).append( data );
				$('.review_container_similar .review_average_round' ).each(function() {
					
					var id = $(this).attr('id');
					var percent = $(this).attr('data-percent');
					append_circle_bar(id,percent);
				});
			}
		});
}

function list_more_ajax(post_id,tab_class) {
	/*$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=list_more_ajax&post_id="+post_id,
			beforeSend: function(xhr) {
			},
			complete: function(){
			},
			success: function( data ) {
				$('.list_more_widget').remove();
				$( '.'+tab_class+' .list_more_container' ).append( data );
			}
		});*/
}



function ajax_subscribe_block(post_id) {
	$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=ajax_subscribe_block&post_id="+post_id,
			beforeSend: function(xhr) {
			},
			complete: function(){
			},
			success: function( data ) {
				$('.subscribe_container .subscribe_widget').remove();
				$('.subscribe_container').append(data);
			}
		});
}

function ajax_verify_company_block(post_id) {
	$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=ajax_verify_company_block&post_id="+post_id,
			beforeSend: function(xhr) {
			},
			complete: function(){
			},
			success: function( data ) {
				$('.verify_container .verify_company_widget').remove();
				$('.verify_container').append(data);
			}
		});
}

function ajax_company_activities_abuses_block(post_id) {
	/*$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=ajax_company_activities_abuses&post_id="+post_id,
			beforeSend: function(xhr) {
			},
			complete: function(){
			},
			success: function( data ) {
				$('.abuse_activity_container .company_activity_abuses').remove();
				$('.abuse_activity_container').append(data);
			}
		});*/
}

function ajax_append_address(post_id) {
	$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=ajax_append_address&post_id="+post_id,
			beforeSend: function(xhr) {
			},
			complete: function(){
			},
			success: function( data ) {
				
				//alert(data);
				$('.ajax_address_container').empty();
				$('.ajax_address_container').append(data);
			}
		});
}

function ajax_new_companies_block(post_id) {
	/*$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=ajax_new_companies_block&post_id="+post_id,
			beforeSend: function(xhr) {
			},
			complete: function(){
			},
			success: function( data ) {
				$('.new_companies_widget').remove();
				$( '.page_after_content' ).append( data );*/
				$('.new_companies_widget .review_average_round' ).each(function() {
					
					var id = $(this).attr('id');
					var percent = $(this).attr('data-percent');
					append_circle_bar(id,percent);
					if ($(window).width() < 701) {
						$.getScript("/wp-content/themes/eto-razvod-1/js/jquery.touchSwipe.min.js", function() {
							$(".new_companies_ul").swipe( {
								swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
									$('.tabs_mobile_mover_new_companies_ul .tabs_mobile_mover__item_active').next().click();
										//$('.tabs_mobile_mover_new_companies_ul .tabs_mobile_mover__item_active').next().click();
									// } else {
									//
									// }
								},
								threshold:0,
								excludedElements: "a, .compare_container",
							});
							$(".new_companies_ul").swipe( {
								swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
									$('.tabs_mobile_mover_new_companies_ul .tabs_mobile_mover__item_active').prev().click();
									//$('.tabs_mobile_mover_new_companies_ul .tabs_mobile_mover__item_active').next().click();
									// } else {
									//
									// }
								},
								threshold:0,
								excludedElements: "a, .compare_container"
							});
						});
					}
				});
		/*	}
		});*/
}

function ajax_append_address(post_id) {
	$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=ajax_append_address&post_id="+post_id,
			beforeSend: function(xhr) {
			},
			complete: function(){
			},
			success: function( data ) {
				
				//alert(data);
				$('.ajax_address_container').empty();
				$('.ajax_address_container').append(data);
			}
		});
}

function get_ad_text_show(post_id) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=get_ad_text_show&post_id="+post_id,
		beforeSend: function(xhr) {
		},
		complete: function(){
		},
		success: function( data ) {

			// alert(data);
			$('.data-ad').empty();
			$('.data-ad').append(data);
		}
	});
}

jQuery(document).ready(function($){
	var string = window.location.hash;
	var substring = 'comment';
	if(string == '#fullreview') {
		//alert(string);
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_content';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_fullreview').addClass('active');
		$('.review_links li.review_link_fullreview').addClass('color_dark_blue');
		//list_more_ajax(my_ajax_object.current_post_id,container_class);
	} else if (string == '#abuse') {
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_abuses';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_abuses').addClass('active');
		$('.review_links li.review_link_abuses').addClass('color_dark_blue');
		ajax_abuses('new');
		//list_more_ajax(my_ajax_object.current_post_id,container_class);
	} else if (string == '#similar') {
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_similar';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_similar').addClass('active');
		$('.review_links li.review_link_similar').addClass('color_dark_blue');
		ajax_similar_companies(my_ajax_object.current_post_id);
		//list_more_ajax(my_ajax_object.current_post_id,container_class);
	} else if (string == '#about') {
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_about';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_company').addClass('active');
		$('.review_links li.review_link_company').addClass('color_dark_blue');
		
	} else if (string == '#comments') {
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_reviews';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_reviews').addClass('active');
		$('.review_links li.review_link_reviews').addClass('color_dark_blue');
		if (my_ajax_object.post_type != 'casino') {
			ajax_comments('new');
	/*	}  else if ($('html').attr('lang') != 'ru-RU' && my_ajax_object.post_type == 'casino') {
			ajax_comments('new');*/
		} else {
			$('.comment_text a').each(function(){
				if (!$(this).hasClass('continue_reading')){
					$(this).attr('target','_blank');
				}
			});
			$( ".review_average_round" ).each(function() {

				var id = $(this).attr('id');
				var percent = $(this).attr('data-percent');
				append_circle_bar(id,percent);
			});
			if ( (typeof userid === 'undefined') && (typeof company_page === 'undefined') ){
				var b_p_id = banners_info.b_p_id;
				if (typeof get_h_info !== 'undefined') {
					get_h_info(b_p_id,'review_reviews_1');
					get_h_info(b_p_id,'review_reviews_2');
				}

			}

			if ( (typeof userid === 'undefined') && (typeof company_page === 'undefined') ){
				var b_p_id = banners_info.b_p_id;
				if (typeof get_h_info !== 'undefined') {
					get_h_info(b_p_id,'review_reviews_1');
					get_h_info(b_p_id,'review_reviews_2');
				}

			}
			var string = window.location.hash;
			var substring = 'comment';
			if(string.indexOf(substring) !== -1 && string !== '#comments') {
				tempvar = $(string).offset();
				if (typeof tempvar === 'undefined') {
//alert(1);
				} else {
					$(window).scrollTop($(string).offset().top - 130);
				}

			}

			if (typeof userid === 'undefined') {
				$('.show-comments > li').removeAttr('data-hold');$('.moderate_text').remove();
//data-hold="1"
			}


			$('.show-comments .comment_reply_count.dropdown.flex.color_dark_gray.m_right_20.pointer').addClass('active');
			$('.show-comments .children').addClass('visible');



			$('.show-comments > li').each(function(){
				if ($(this).text().length < 10) {
					$(this).remove();
				}
			});
			if ($('.show-comments > li').size() < 50) {
				$('.load_more_reviews').remove();
			}


			i = 0;
			if ($('html').attr('lang') == 'ru-RU') {
				if (window.location.href.indexOf("/review/") > -1) {
					if (meta_page.affiliate_tags != null) {
						affiliate_tags = meta_page.affiliate_tags;
						var array = affiliate_tags.split(',');
						$.each(array, function (index, value) {
							if ((value == 'bi') || (value == 'fx') || (value == 'fond') || (value == 'exchange')) {
								if ($('.review_block_main_button').attr('href') != $('.company_site').attr('href')) {
									$('.show-comments .button_review_link_comment').remove();
									$.ajax({
										url: my_ajax_object.ajax_url,
										type: "POST",
										data: "action=get_posts_companies_ajax&post_id=" + parseInt(my_ajax_object.current_post_id),
										beforeSend: function (xhr) {
											$('.another_comm_1').append('<div class="load_ajax"></div>');
										},
										success: function (data) {
											$('.show-comments > li').each(function (index) {
												let val_rating = $(this).find('.comment_total_rating').attr('data-value');
												if (val_rating >= 4 && index > 1) {
													$(this).attr('data-index', index);
													if (data[0] == '')
														data_0 = $(".site_url").text();
													else
														data_0 = data[0];

													if (data[1] == '')
														data_1 = $(".site_url").text();
													else
														data_1 = data[1];

													if (data[2] == '')
														data_2 = $(".site_url").text();
													else
														data_2 = data[2];

													i = ++i;
													console.log(i);

													switch (i) {
														case 1:
															name = 'Попробовать ' + data_0;
															break;
														case 2:
															name = 'Зарегистироваться на ' + data_1;
															break;
														default:
															name = 'Перейти на сайт ' + data_2;
													}

													if (i < 4) {
														$('<a class="button_review_link_comment" href="' + $('.company_site').attr('href') + '">' + name + '</a>').insertAfter($(this).find('.comment_footer_parent .comment_fast_links'));
														$(this).find('.comment_footer_parent .comment_fast_links').addClass('flex-auto-none');
													} else {
														return false;
													}

												}
											});
											t = data[1];
										}
									});
								} else {
									$('.show-comments .button_review_link_comment').remove();
									$('.show-comments > li').each(function (index) {
										let val_rating = $(this).find('.comment_total_rating').attr('data-value');
										if (val_rating >= 4 && index > 1) {
											$(this).attr('data-index', index);
											i = ++i;
											console.log(i);

											switch (i) {
												case 1:
													name = 'Попробовать ' + $(".site_url").text();
													break;
												case 2:
													name = 'Зарегистироваться на ' + $(".site_url").text();
													break;
												default:
													name = 'Перейти на сайт ' + $(".site_url").text();
											}

											if (i < 4) {
												$('<a class="button_review_link_comment" href="' + $('.company_site').attr('href') + '">' + name + '</a>').insertAfter($(this).find('.comment_footer_parent .comment_fast_links'));
												$(this).find('.comment_footer_parent .comment_fast_links').addClass('flex-auto-none');
											} else {
												return false;
											}


										}
									});
								}

							}
						});
					}
				}
			}
		}
	} else if (string.indexOf(substring) !== -1) {
		//alert(string);
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_reviews';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_reviews').addClass('active');
		$('.review_links li.review_link_reviews').addClass('color_dark_blue');
		if (my_ajax_object.post_type != 'casino') {
			ajax_comments('new');
		/*}  else if ($('html').attr('lang') != 'ru-RU' && my_ajax_object.post_type == 'casino') {
			ajax_comments('new');*/
		} else {
			$('.comment_text a').each(function(){
				if (!$(this).hasClass('continue_reading')){
					$(this).attr('target','_blank');
				}
			});
			$( ".review_average_round" ).each(function() {

				var id = $(this).attr('id');
				var percent = $(this).attr('data-percent');
				append_circle_bar(id,percent);
			});
			if ( (typeof userid === 'undefined') && (typeof company_page === 'undefined') ){
				var b_p_id = banners_info.b_p_id;
				if (typeof get_h_info !== 'undefined') {
					get_h_info(b_p_id,'review_reviews_1');
					get_h_info(b_p_id,'review_reviews_2');
				}

			}

			if ( (typeof userid === 'undefined') && (typeof company_page === 'undefined') ){
				var b_p_id = banners_info.b_p_id;
				if (typeof get_h_info !== 'undefined') {
					get_h_info(b_p_id,'review_reviews_1');
					get_h_info(b_p_id,'review_reviews_2');
				}

			}
			var string = window.location.hash;
			var substring = 'comment';
			if(string.indexOf(substring) !== -1 && string !== '#comments') {
				tempvar = $(string).offset();
				if (typeof tempvar === 'undefined') {
//alert(1);
				} else {
					$(window).scrollTop($(string).offset().top - 130);
				}

			}

			if (typeof userid === 'undefined') {
				$('.show-comments > li').removeAttr('data-hold');$('.moderate_text').remove();
//data-hold="1"
			}


			$('.show-comments .comment_reply_count.dropdown.flex.color_dark_gray.m_right_20.pointer').addClass('active');
			$('.show-comments .children').addClass('visible');



			$('.show-comments > li').each(function(){
				if ($(this).text().length < 10) {
					$(this).remove();
				}
			});
			if ($('.show-comments > li').size() < 50) {
				$('.load_more_reviews').remove();
			}


			i = 0;
			if ($('html').attr('lang') == 'ru-RU') {
				if (window.location.href.indexOf("/review/") > -1) {
					if (meta_page.affiliate_tags != null) {
						affiliate_tags = meta_page.affiliate_tags;
						var array = affiliate_tags.split(',');
						$.each(array, function (index, value) {
							if ((value == 'bi') || (value == 'fx') || (value == 'fond') || (value == 'exchange')) {
								if ($('.review_block_main_button').attr('href') != $('.company_site').attr('href')) {
									$('.show-comments .button_review_link_comment').remove();
									$.ajax({
										url: my_ajax_object.ajax_url,
										type: "POST",
										data: "action=get_posts_companies_ajax&post_id=" + parseInt(my_ajax_object.current_post_id),
										beforeSend: function (xhr) {
											$('.another_comm_1').append('<div class="load_ajax"></div>');
										},
										success: function (data) {
											$('.show-comments > li').each(function (index) {
												let val_rating = $(this).find('.comment_total_rating').attr('data-value');
												if (val_rating >= 4 && index > 1) {
													$(this).attr('data-index', index);
													if (data[0] == '')
														data_0 = $(".site_url").text();
													else
														data_0 = data[0];

													if (data[1] == '')
														data_1 = $(".site_url").text();
													else
														data_1 = data[1];

													if (data[2] == '')
														data_2 = $(".site_url").text();
													else
														data_2 = data[2];

													i = ++i;
													console.log(i);

													switch (i) {
														case 1:
															name = 'Попробовать ' + data_0;
															break;
														case 2:
															name = 'Зарегистироваться на ' + data_1;
															break;
														default:
															name = 'Перейти на сайт ' + data_2;
													}

													if (i < 4) {
														$('<a class="button_review_link_comment" href="' + $('.company_site').attr('href') + '">' + name + '</a>').insertAfter($(this).find('.comment_footer_parent .comment_fast_links'));
														$(this).find('.comment_footer_parent .comment_fast_links').addClass('flex-auto-none');
													} else {
														return false;
													}

												}
											});
											t = data[1];
										}
									});
								} else {
									$('.show-comments .button_review_link_comment').remove();
									$('.show-comments > li').each(function (index) {
										let val_rating = $(this).find('.comment_total_rating').attr('data-value');
										if (val_rating >= 4 && index > 1) {
											$(this).attr('data-index', index);
											i = ++i;
											console.log(i);

											switch (i) {
												case 1:
													name = 'Попробовать ' + $(".site_url").text();
													break;
												case 2:
													name = 'Зарегистироваться на ' + $(".site_url").text();
													break;
												default:
													name = 'Перейти на сайт ' + $(".site_url").text();
											}

											if (i < 4) {
												$('<a class="button_review_link_comment" href="' + $('.company_site').attr('href') + '">' + name + '</a>').insertAfter($(this).find('.comment_footer_parent .comment_fast_links'));
												$(this).find('.comment_footer_parent .comment_fast_links').addClass('flex-auto-none');
											} else {
												return false;
											}


										}
									});
								}

							}
						});
					}
				}
			}
		}

	} else if(string == '') {
		//alert(string);
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_about';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_company').addClass('active');
		$('.review_links li.review_link_company').addClass('color_dark_blue');
	} else {
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_content';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_fullreview').addClass('active');
		$('.review_links li.review_link_fullreview').addClass('color_dark_blue');
		//list_more_ajax(my_ajax_object.current_post_id,container_class);
	}
	//ajax_subscribe_block(my_ajax_object.current_post_id);
	ajax_verify_company_block(my_ajax_object.current_post_id);
	//ajax_company_activities_abuses_block(my_ajax_object.current_post_id);
	ajax_new_companies_block(my_ajax_object.current_post_id);
	get_ad_text_show(my_ajax_object.current_post_id);
});