$ = jQuery.noConflict();

function ajax_comments(sort_type,userid) {
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
			data: "action=ajax_comments&post_id="+current_post_id+"&sort_type="+sort_type+"&user_id="+userid+"&slug="+slug,
			beforeSend: function(xhr) {
				$('#reviews').append('<div class="load_ajax"></div>');
				//alert('i am sending');
			},
			complete: function(){
				$("#reviews .load_ajax").remove();
			},
			success: function( data ) {
				$('#reviews').append(data);
				if ( (typeof userid !== 'undefined') && (typeof company_page === 'undefined') ){
					$("#reviews > li").each(function (){
						postUrl = $(this).attr('data-url');
						postCompany = $(this).attr('data-company');
						$(this).find('.comment_to_id').html('написал(а) отзыв к компании <a href="/review/'+postUrl+'/" class="color_dark_blue link_no_underline hover_dark font_bold">'+postCompany+'</a>');
					})
					if ($('ul#reviews > li').size() == 0) {
						//$('ul#reviews > *').css('display','none');
					}
				}
				if ( (slug == "comments") ){
					$('.ans_get').text($('.ans').size());
					$('.noans_get').text($('.noans').size());
				}
				/*
				$( ".review_average_round" ).each(function() {

					var id = $(this).attr('id');
					var percent = $(this).attr('data-percent');
					append_circle_bar(id,percent);
				});*/
				/*if ( (typeof userid === 'undefined') && (typeof company_page === 'undefined') ){
				var b_p_id = banners_info.b_p_id;
				get_h_info(b_p_id,'review_reviews_1');
				get_h_info(b_p_id,'review_reviews_2');
				}*/
				var string = window.location.hash;
				var substring = 'comment';
				if(string.indexOf(substring) !== -1 && string !== '#comments') {
					$(window).scrollTop($(string).offset().top - 130);
				}
			}
		});
	}
sort_type_feed = '';


function append_new_reply(comment_id,type,parent_id) {
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
			//$(data).insertAfter( ".comments_top" );
			$("#reviews").prepend(data);
			
		}
	});
}





function form_icon_img(form_id) {
	
	$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=ajax_append_form_images",
			beforeSend: function(xhr) {
				$('form#'+form_id+' .form_add_images').remove();
				$('form#'+form_id+' .form_icon_img').removeClass('inactive');
			},
			complete: function(){
				$('form#'+form_id+' .form_icon_img').addClass('active');
			},
			success: function( data ) {
				//alert(data);
				$(data).insertBefore( 'form#'+form_id+' .review_form_icons' );
				
			}
		});
}

function ajax_reply_form(appendto_id,parent_id,post_id) {
	//alert(appendto_id);

	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=ajax_show_reply_form&parent_id="+parent_id+"&post_id="+post_id,
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

function ajax_upload_file(file_data,append_id) {
	console.log(file_data);
	form_data = new FormData();
	form_data.append('file', file_data);
	form_data.append('action', 'ajax_upload_file');
	$.ajax({
			url: my_ajax_object.ajax_url,
			type: 'POST',
			contentType: false,
			processData: false,
			data: form_data,
			beforeSend: function(xhr) {
			},
			complete: function(){
			},
			success: function( data ) {
				result = JSON.parse(data);
				//alert(data);
				if(result.status === 'ok') {
					$('<li class="form_add_item" style="background-image:url(\''+result.thumb_url+'\');"><input type="hidden" name="files[]" value="'+result.file_id+'" /><span class="close"></span></li>').insertBefore('#'+append_id+' .form_add_images li.add_new');
				}
			}
		});
}



jQuery(document).ready(function($){
	$('body').on('click', '.form_icon_img.inactive', function(){
		var form_id = $(this).closest('form').attr('id');
		form_icon_img(form_id);
	});
	$('body').on('click', '.form_icon_img.active', function(){
		var form_id = $(this).closest('form').attr('id');
		$('form#'+form_id+' .form_add_images').remove();
		$('form#'+form_id+' .form_icon_img').removeClass('active');
		$('form#'+form_id+' .form_icon_img').addClass('inactive');
	});
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
	$('body').on('change', '.form_add_images li.add_new input', function() {
		var file_data = $(this).prop('files')[0];
		var append_id = $(this).closest('form').attr('id');;
		ajax_upload_file(file_data,append_id);
	});
	$('body').on('click', '.form_add_images .close', function(){
		$(this).closest('li').remove();
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
				}
			}
		);
	});
	ajax_comments('new');
	$('body').on('click','.single_new_comment',function() {
		popup_form('review',my_ajax_object.current_post_id);
	});
});