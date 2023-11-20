$ = jQuery.noConflict();

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
				get_h_info(b_p_id,'review_reviews_1');
				get_h_info(b_p_id,'review_reviews_2');
			}
			var string = window.location.hash;
			var substring = 'comment';
			if(string.indexOf(substring) !== -1 && string !== '#comments') {
				$(window).scrollTop($(string).offset().top - 130);
			}


			if (((typeof userid !== 'undefined') || (typeof company_page !== 'undefined')) && (typeof rounder_html !== 'undefined')) {
				rounder_html();
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
			$( ".review_average_round" ).each(function() {

				var id = $(this).attr('id');
				var percent = $(this).attr('data-percent');
				append_circle_bar(id,percent);
			});
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
				window.open(link, '_blank');
			} else {
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

	$('body').on('click', '.comment_avatar, .comment-author', function(){
		var link = $(this).attr('data-link');
		show_profile_link(link);
	});
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
		//вызывает new_submit_reply
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