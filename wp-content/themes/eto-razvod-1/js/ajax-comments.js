$ = jQuery.noConflict();


function ajax_comments_about(sort_type,userid,typecomments = '') {
	rating_fields_group = my_ajax_object.rating_fields_group;
	if (typeof company_page === 'undefined') {
		current_post_id = my_ajax_object.current_post_id;
		slug = my_ajax_object.slug;
	} else {
		current_post_id = company_page.company_id;
		slug = 'dashboard_company';
	}
	$('#reviews_about').empty();
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=ajax_comments&post_id="+current_post_id+"&rating_fields_group="+rating_fields_group+"&sort_type="+sort_type+"&user_id="+userid+"&slug="+slug+"&typecomments="+typecomments,
		beforeSend: function(xhr) {
			$('#reviews_about').append('<div class="load_ajax"></div>');
		},
		complete: function(){
			$("#reviews_about .load_ajax").remove();
		},
		success: function( data ) {
			$('#reviews_about').append(data);
			if ((($(data).length < 2) || (parseInt($('.comments_top_count').text()) == 0)) && (typeof userid !== 'undefined')) {
				$('#reviews_about').empty();
				user_zero_message('reviews_about');
			}
			if ( (typeof userid !== 'undefined') && (typeof company_page === 'undefined') ){
				$("#reviews > li").each(function (){
					postUrl = $(this).attr('data-url');
					postCompany = $(this).attr('data-company');
					$(this).find('.comment_to_id').addClass('comment_to_post font_normal color_dark_gray"');
					$(this).find('.comment_to_id').html('написал(а) отзыв к компании <a href="/review/'+postUrl+'/" class="color_dark_blue link_no_underline hover_dark font_bold">'+postCompany+'</a>');
				})
				$('.comment_footer .comment-reply-link, .comment_footer_right, .comment_fast_links').remove();
				if ($('ul#reviews_about > li').size() == 0) {
					//$('ul#reviews > *').css('display','none');
				}
			}
			if ( (slug == "comments") || (slug == "dashboard_company") ){
				$('.ans_get').text($('.ans').size());
				$('.noans_get').text($('.noans').size());
			}

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
				$('#reviews_about > li').removeAttr('data-hold');$('.moderate_text').remove();
				//data-hold="1"
			}

			if (((typeof userid !== 'undefined') || (typeof company_page !== 'undefined')) && (typeof rounder_html !== 'undefined')) {
				rounder_html();
			}


			//console.log(444444);
			$('#reviews_about .comment_reply_count.dropdown.flex.color_dark_gray.m_right_20.pointer').addClass('active');
			$('#reviews_about .children').addClass('visible');

			$('.comment_text a:not(.continue_reading)').attr('target','_blank');

			$('#reviews_about > li').each(function(){
				if ($(this).text().length < 10) {
					$(this).remove();
				}
			});
			if ($('#reviews_about > li').size() < 50) {
				$('.load_more_reviews').remove();
			}

			i = 0;
			if ($('html').attr('lang') == 'ru-RU') {
				console.log('кнопи');
				if (window.location.href.indexOf("/review/") > -1) {
					if (meta_page.affiliate_tags != null) {
						affiliate_tags = meta_page.affiliate_tags;
						var array = affiliate_tags.split(',');
						$.each(array, function (index, value) {
							if ((value == 'bi') || (value == 'fx') || (value == 'fond') || (value == 'exchange')) {
								if ($('.review_block_main_button').attr('href') != $('.company_site').attr('href')) {
									$('#reviews_about .button_review_link_comment').remove();
									$.ajax({
										url: my_ajax_object.ajax_url,
										type: "POST",
										data: "action=get_posts_companies_ajax&post_id=" + parseInt(my_ajax_object.current_post_id),
										beforeSend: function (xhr) {
											$('.another_comm_1').append('<div class="load_ajax"></div>');
										},
										success: function (data) {
											$('#reviews_about > li').each(function (index) {
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
									$('#reviews_about .button_review_link_comment').remove();
									$('#reviews_about > li').each(function (index) {
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
	});
}



function ajax_comments(sort_type,userid,typecomments = '') {
	rating_fields_group = my_ajax_object.rating_fields_group;
	if (typeof company_page === 'undefined') {
		current_post_id = my_ajax_object.current_post_id;
		slug = my_ajax_object.slug;
	} else {
		current_post_id = company_page.company_id;
		slug = 'dashboard_company';
	}
	$('#reviews').empty();
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=ajax_comments&post_id="+current_post_id+"&rating_fields_group="+rating_fields_group+"&sort_type="+sort_type+"&user_id="+userid+"&slug="+slug+"&typecomments="+typecomments,
		beforeSend: function(xhr) {
			$('#reviews').append('<div class="load_ajax"></div>');
		},
		complete: function(){
			$("#reviews .load_ajax").remove();
		},
		success: function( data ) {
			$('#reviews').append(data);
			if ((($(data).length < 2) || (parseInt($('.comments_top_count').text()) == 0)) && (typeof userid !== 'undefined')) {
				$('#reviews').empty();
				user_zero_message('reviews');
			}
			if ( (typeof userid !== 'undefined') && (typeof company_page === 'undefined') ){
				$("#reviews > li").each(function (){
					postUrl = $(this).attr('data-url');
					postCompany = $(this).attr('data-company');
					$(this).find('.comment_to_id').addClass('comment_to_post font_normal color_dark_gray"');
					$(this).find('.comment_to_id').html('написал(а) отзыв к компании <a href="/review/'+postUrl+'/" class="color_dark_blue link_no_underline hover_dark font_bold">'+postCompany+'</a>');
				})
				$('.comment_footer .comment-reply-link, .comment_footer_right, .comment_fast_links').remove();
				if ($('ul#reviews > li').size() == 0) {
					//$('ul#reviews > *').css('display','none');
				}
			}
			if ( (slug == "comments") || (slug == "dashboard_company") ){
				$('.ans_get').text($('.ans').size());
				$('.noans_get').text($('.noans').size());
			}

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
				$('#reviews > li').removeAttr('data-hold');$('.moderate_text').remove();
				//data-hold="1"
			}

			if (((typeof userid !== 'undefined') || (typeof company_page !== 'undefined')) && (typeof rounder_html !== 'undefined')) {
				rounder_html();
			}

			if ( (typeof company_page !== 'undefined') ) {
				$('.comment-reply-link').text('Ответить публично');
				company_id = company_page.company_id;
				company_slug = company_page.company_slug;
				$('.comment-reply-link').each(function (){
					usdid = $(this).attr('data-user-id');
					$(this).after('<a href="#" class="go_private_mail color_dark_blue pointer link_no_underline" data-user-id="'+usdid+'" data-company-slug="'+company_slug+'" data-company-id="'+company_id+'">Написать личное сообщение</a>');
				})

			}

			//console.log(55555);
			$('#reviews .comment_reply_count.dropdown.flex.color_dark_gray.m_right_20.pointer').addClass('active');
			$('#reviews .children').addClass('visible');

			$('#reviews > li').each(function(){
				if ($(this).text().length < 10) {
					$(this).remove();
				}
			});
			if ($('#reviews > li').size() < 50) {
				$('.load_more_reviews').remove();
			}


			i = 0;
			if ($('html').attr('lang') == 'ru-RU') {
				console.log('кнопи');

				if (window.location.href.indexOf("/review/") > -1) {
					if (meta_page.affiliate_tags != null) {
						affiliate_tags = meta_page.affiliate_tags;
						var array = affiliate_tags.split(',');
						$.each(array, function (index, value) {
							if ((value == 'bi') || (value == 'fx') || (value == 'fond') || (value == 'exchange')) {
								if ($('.review_block_main_button').attr('href') != $('.company_site').attr('href')) {
									$('#reviews .button_review_link_comment').remove();
									$.ajax({
										url: my_ajax_object.ajax_url,
										type: "POST",
										data: "action=get_posts_companies_ajax&post_id=" + parseInt(my_ajax_object.current_post_id),
										beforeSend: function (xhr) {
											$('.another_comm_1').append('<div class="load_ajax"></div>');
										},
										success: function (data) {
											$('#reviews > li').each(function (index) {
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
									$('#reviews .button_review_link_comment').remove();
									$('#reviews > li').each(function (index) {
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
	});
}
sort_type_feed = '';
function get_feed_user_profile(sort_type_feed_t,userid,data_review_post,data_post,data_review,data_comment,data_abuse,type) {
	sort_type_feed = sort_type_feed_t;

	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=get_feed_user_profile_new&sort_type="+sort_type_feed_t+"&user_id="+userid+"&slug="+my_ajax_object.slug+"&data_review_post="+data_review_post+"&data_post="+data_post+"&data_review="+data_review+"&data_comment="+data_comment+"&data_abuse="+data_abuse,
		beforeSend: function(xhr) {

			if (type == 'append') {
				$('.feed-info').append('<div class="load_ajax"></div>');
			} else {
				$('.feed-info').empty();
				$('.feed-info').append('<div class="load_ajax"></div>');
			}

		},
		complete: function(){
			$(".feed-info .load_ajax").remove();
		},
		success: function( data ) {
			if (type == 'append') {
				$('.feed-info').append(data);
			} else {
				$('.feed-info').append(data);
			}


			// if (typeof userid !== 'undefined'){
			// 	$(".feed-info > li").each(function (){
			// 		postUrl = $(this).attr('data-url');
			// 		postCompany = $(this).attr('data-company');
			// 		$(this).find('.comment_to_id').html('написал(а) отзыв к компании <a href="/review/'+postUrl+'/" class="color_dark_blue link_no_underline hover_dark font_bold">'+postCompany+'</a>');
			// 	})
			// 	if ($('ul.feed-info > li').size() == 0) {
			// 		$('ul.feed-info > *').css('display','none');
			// 	}
			// }
			$( ".review_average_round" ).each(function() {

				var id = $(this).attr('id');
				var percent = $(this).attr('data-percent');
				append_circle_bar(id,percent);
			});
			var string = window.location.hash;
			var substring = 'comment';
			if(string.indexOf(substring) !== -1) {
				$(window).scrollTop($(string).offset().top - 130);
			}
			$('.comment_to_id').empty();
			$(".reviews > li").each(function (){
				postUrl = $(this).attr('data-url');
				postCompany = $(this).attr('data-company');
				$(this).find('.comment_to_id').addClass('comment_to_post font_normal color_dark_gray"');
				$(this).find('.comment_to_id').html('написал(а) отзыв к компании <a href="/review/'+postUrl+'/" class="color_dark_blue link_no_underline hover_dark font_bold">'+postCompany+'</a>');
			})
			$(".abuses > li").each(function (){
				postUrl = $(this).attr('data-url');
				postCompany = $(this).attr('data-company');
				$('.date_abuse').css('margin-left','15px');
				$(this).find('.date_abuse').text($(this).find('.date_abuse').attr('data-profile'));
				$(this).find('.comment_to_id').html('жалоба на <a href="/review/'+postUrl+'/" class="color_dark_blue link_no_underline hover_dark">'+postCompany+'</a>');
			})
		}
	});
}

function append_new_reply(comment_id,type,parent_id,from = 0) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=append_new_comment&comment_id="+comment_id+"&type="+type+"&from="+from,
		beforeSend: function(xhr) {

		},
		complete: function(){

		},
		success: function( data ) {
			//alert(data);
			$('<ul class="children visible_new">'+data+'</ul>').insertAfter( '.body_'+parent_id );
			if (typeof userid === 'undefined') {
				$('#reviews > li').removeAttr('data-hold');$('.moderate_text').remove();
				//data-hold="1"
			}
			$('<span class="success color_green font_small m_b_20">Спасибо, ваш комментарий добавлен на сайт. Сейчас он на модерации.</span>').insertBefore('.body_'+comment_id+' .comment_text');
			
			$('ul.visible_new').show();
		}
	});
}

function append_new_comment(comment_id,type) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=append_new_comment&comment_id="+comment_id+"&type="+type,
		beforeSend: function(xhr) {

		},
		complete: function(){

		},
		success: function( data ) {
			//alert(data);
			//$(data).insertAfter( ".comments_top" );
			$(".comments_top").after(data);
			if ($('.body_'+comment_id).parent().parent().attr('id') == "abuses") {
				$('<span class="success color_green font_small m_b_20">Спасибо, ваша жалоба добавлена на сайт. Сейчас она на модерации.</span>').insertBefore('.body_'+comment_id+' .comment_text');
			} else {
				$('<span class="success color_green font_small m_b_20">Спасибо, ваш отзыв добавлен на сайт. Сейчас он на модерации.</span>').insertBefore('.body_'+comment_id+' .comment_text');
			}
			$( ".review_average_round" ).each(function() {

				var id = $(this).attr('id');
				var percent = $(this).attr('data-percent');
				append_circle_bar(id,percent);
			});
			if (typeof userid === 'undefined') {
				$('#reviews > li').removeAttr('data-hold');$('.moderate_text').remove();
				//data-hold="1"
			}
		}
	});
}




function show_profile_link(link) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=check_user_logged_in",
		beforeSend: function(xhr) {

		},
		complete: function(){

		},
		success: function( data ) {
			//alert(data);
			result = JSON.parse(data);
			if(result.status === 'ok') {
				//alert(link);
				window.location.href = link;
				//window.open(link, '_blank');
			} else {
				$('#popup_auth').remove();
				auth_link(result.message);
			}
		}
	});
}




function ajax_reply_form(appendto_id,parent_id,post_id) {
	//alert(appendto_id);
	if (typeof company_page === 'undefined') {
		company_id = 0;
	} else {
		company_id = company_page.company_id;
	}
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=ajax_show_reply_form&parent_id="+parent_id+"&post_id="+post_id+"&company_id="+company_id,
		beforeSend: function(xhr) {

		},
		complete: function(){

		},
		success: function( data ) {
			if(data === 'auth') {
				auth_link('');
			} else {
				$(data).insertAfter('.body_'+appendto_id);
			}
			//alert(data);

			/*result = JSON.parse(data);
			if(result.status === 'ok') {
				//alert(link);
				window.open(link, '_blank');
			} else {
				auth_link(result.message);
			}*/
		}
	});
}





jQuery(document).ready(function($){

	$('body').on('click', '.form_icon_notify.inactive', function(){
		var form_id = $(this).closest('form').attr('id');
		$(this).removeClass('inactive');
		$(this).addClass('active');
		$('#'+form_id).append('<input class="notify_input" type="hidden" name="notify" value="yes" />');
	});
	$('body').on('click', '.form_icon_notify.active', function(){
		var form_id = $(this).closest('form').attr('id');
		$(this).removeClass('active');
		$(this).addClass('inactive');
		$('#'+form_id+' .notify_input').remove();
	});
	$('body').on('click', '.form_icon_link', function(){
		var form_id = $(this).closest('form').attr('id');
		//alert('form_icon_link '+form_id);
	});
	$('body').on('click', '.comment-reply-link.inactive', function(){
		$('form.reply_form').remove();
		var parent_id = $(this).attr('data-commentid');
		var appendto_id = $(this).attr('data-appendto');
		var post_id = $(this).attr('data-postid');
		$(this).removeClass('inactive');
		$(this).addClass('active');
		ajax_reply_form(appendto_id,parent_id,post_id);

	});
	$('body').on('click', '.comment-reply-link.active', function(){
		$(this).removeClass('active');
		$('form.reply_form').remove();
		$(this).addClass('inactive');
	});
	
	$('body').on('click', '.load_more_reviews', function(){
		var offset = $(this).attr('data-offset');
		var type = $(this).attr('data-type');
		var post_id = $(this).attr('data-post-id');
		rating_fields_group = my_ajax_object.rating_fields_group;
		//alert(offset + type + post_id + rating_fields_group);
		$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=ajax_comments&post_id="+post_id+"&rating_fields_group="+rating_fields_group+"&sort_type="+type+"&user_id=undefined&offset="+offset,
		beforeSend: function(xhr) {
			$("#reviews .load_more_reviews").remove();
			$('#reviews').append('<div class="load_ajax"></div>');
		},
		complete: function(){
			$("#reviews .load_ajax").remove();
		},
		success: function( data ) {
			$('#reviews').append(data);
		

			$( ".review_average_round" ).each(function() {

				var id = $(this).attr('id');
				var percent = $(this).attr('data-percent');
				append_circle_bar(id,percent);
			});

			if ($('#reviews > li').size() >= parseInt($('ul#reviews .comments_top_count').text())) {
				$('#reviews .load_more_reviews').remove();
			}
		}
	});
	});
	
	$('#reviews_about').on('click', '.load_more_reviews', function(){
		var offset = $(this).attr('data-offset');
		var type = $(this).attr('data-type');
		var post_id = $(this).attr('data-post-id');
		rating_fields_group = my_ajax_object.rating_fields_group;
		//alert(offset + type + post_id + rating_fields_group);
		$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=ajax_comments&post_id="+post_id+"&rating_fields_group="+rating_fields_group+"&sort_type="+type+"&user_id=undefined&offset="+offset,
		beforeSend: function(xhr) {
			$("#reviews_about .load_more_reviews").remove();
			$('#reviews_about').append('<div class="load_ajax"></div>');
		},
		complete: function(){
			$("#reviews_about .load_ajax").remove();
		},
		success: function( data ) {
			$('#reviews_about').append(data);
		

			$( ".review_average_round" ).each(function() {

				var id = $(this).attr('id');
				var percent = $(this).attr('data-percent');
				append_circle_bar(id,percent);
			});

			if ($('#reviews_about > li').size() >= parseInt($('ul#reviews_about .comments_top_count').text())) {
				$('#reviews_about .load_more_reviews').remove();
			}
		}
	});
	});

	$('body').on('submit', '#popup_form_review', function(e) {
		e.preventDefault();
		var form = $(this);
		//alert(form);
		$.post(
			form.attr('action'),
			form.serialize(),
			function(data) {
				//alert(data);
				result = JSON.parse(data);
				if(result.status === 'error') {
					//alert(result.message);
					$( '<div class="font_smaller m_b_20 color_red reg_error">'+result.message+'</div>' ).insertBefore( $( '#popup_form_review input[type="submit"]' ) );
					setTimeout(function() {
						$('.reg_error').remove();
					}, 5000);
				} else if (result.status === 'ok') {
					$('#popup_form_review').closest('.popup_container').remove();
					append_new_comment(result.comment_id,'review');
				}
			}
		);
	});
	
	$('body').on('submit', '#form_reply', function(e) {
		$('#reviews').append('<div class="load_ajax"></div>');
		//вызывает new_submit_reply
		$('#form_reply .button_green').addClass('spinner_before');
		e.preventDefault();
		var form = $(this);
		var parent_id = $('#form_reply input[name="parent_id"]').val();
		//alert(parent_id);
		$.post(
			form.attr('action'),
			form.serialize(),
			function(data) {
				//alert(data);
				result = JSON.parse(data);
				//$('#form_reply .button_green').removeClass('spinner_before');
				if(result.status === 'error') {
					popup_alert_message(result.message,result.status);
				} else if (result.status === 'ok') {
					//alert(result.comment_id);
					$('#form_reply').remove();
					$('.body_'+parent_id+' .comment-reply-link').removeClass('active');
					$('.body_'+parent_id+' .comment-reply-link').addClass('inactive');
					append_new_reply(result.comment_id,'comment',parent_id);
					$('.comment-reply-link_abuse').css('display','block');
				}
			}
		);
	});
	if ($('#reviews > li:nth-of-type(50)').length != 0 && $('#reviews .load-more-comments').length == 0) {
		$('#reviews > li:nth-of-type(50)').after('<div class="load-more-comments disab"><span>'+__('Загрузить ещё', 'er_theme')+'<svg viewBox="0 -4.5 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>arrow_down [#339]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-180.000000, -6684.000000)" fill="#000000"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M144,6525.39 L142.594,6524 L133.987,6532.261 L133.069,6531.38 L133.074,6531.385 L125.427,6524.045 L124,6525.414 C126.113,6527.443 132.014,6533.107 133.987,6535 C135.453,6533.594 134.024,6534.965 144,6525.39" id="arrow_down-[#339]"> </path> </g> </g> </g> </g></svg></span></div>');
	}
	if ($('.show-comments > li:nth-of-type(50)').length != 0 && $('.show-comments .load-more-comments').length == 0) {
		$('.show-comments > li:nth-of-type(50)').after('<div class="load-more-comments disab"><span>'+__('Загрузить ещё', 'er_theme')+'<svg viewBox="0 -4.5 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>arrow_down [#339]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-180.000000, -6684.000000)" fill="#000000"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M144,6525.39 L142.594,6524 L133.987,6532.261 L133.069,6531.38 L133.074,6531.385 L125.427,6524.045 L124,6525.414 C126.113,6527.443 132.014,6533.107 133.987,6535 C135.453,6533.594 134.024,6534.965 144,6525.39" id="arrow_down-[#339]"> </path> </g> </g> </g> </g></svg></span></div>');
	}
	if ($('#reviews_about > li:nth-of-type(50)').length != 0 && $('#reviews_about .load-more-comments').length == 0) {
		$('#reviews_about > li:nth-of-type(50)').after('<div class="load-more-comments disab"><span>'+__('Загрузить ещё', 'er_theme')+'<svg viewBox="0 -4.5 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>arrow_down [#339]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-180.000000, -6684.000000)" fill="#000000"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M144,6525.39 L142.594,6524 L133.987,6532.261 L133.069,6531.38 L133.074,6531.385 L125.427,6524.045 L124,6525.414 C126.113,6527.443 132.014,6533.107 133.987,6535 C135.453,6533.594 134.024,6534.965 144,6525.39" id="arrow_down-[#339]"> </path> </g> </g> </g> </g></svg></span></div>');
	}
});


function get_childs_ajax(userid,parentid) {

	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=get_childs_ajax&parentid="+parentid,
		beforeSend: function(xhr) {
			//alert(1);
			$('li[data-commentid="'+parseInt(parentid)+'"] ul.children').append('<div class="load_ajax"></div>');
		},
		complete: function(){
			$('li[data-commentid=\"'+parseInt(parentid)+'\"] ul.children .load_ajax').remove();
		},
		success: function( data ) {
			//console.log(111111);
			//$('#reviews').append(data);

			$('li[data-commentid="'+parseInt(parentid)+'"] ul.children').append(data);
			userid == 'undefined';
			if (typeof userid !== 'undefined'){
				$("#reviews > li").each(function (){
					postUrl = $(this).attr('data-url');
					postCompany = $(this).attr('data-company');
					$(this).find('.comment_to_id').html('написал(а) отзыв к компании <a href="/review/'+postUrl+'/" class="color_dark_blue link_no_underline hover_dark font_bold">'+postCompany+'</a>');
				})
				if ($('ul#reviews > li').size() == 0) {
					$('ul#reviews > *').css('display','none');
				}
			}
			$( ".review_average_round" ).each(function() {

				var id = $(this).attr('id');
				var percent = $(this).attr('data-percent');
				append_circle_bar(id,percent);
			});

			var string = window.location.hash;
			var substring = 'comment';
			if(string.indexOf(substring) !== -1) {
				$(window).scrollTop($(string).offset().top - 130);
			}
		}
	});
}