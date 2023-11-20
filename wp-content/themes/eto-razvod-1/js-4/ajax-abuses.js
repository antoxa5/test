$ = jQuery.noConflict();

function ajax_abuses(sort_type,userid,typepage) {
	$('#abuses').empty();
	if (typeof company_page === 'undefined') {
		current_post_id = my_ajax_object.current_post_id;
		slug = my_ajax_object.slug;
	} else {
		current_post_id = company_page.company_id;
		slug = 'dashboard_company';
	}
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=ajax_abuses&post_id="+current_post_id+"&sort_type="+sort_type+"&user_id="+userid+"&slug="+slug,
			beforeSend: function(xhr) {
				$('#abuses').append('<div class="load_ajax"></div>');
			},
			complete: function(){
				$("#abuses .load_ajax").remove();
			},
			success: function( data ) {
				$('#abuses').append(data);
				if ((typeof userid !== 'undefined') && (typeof company_page === 'undefined')){
					$("#abuses > li").each(function (){
						postUrl = $(this).attr('data-url');
						postCompany = $(this).attr('data-company');
						$('.date_abuse').css('margin-left','15px');
						$(this).find('.date_abuse').text($(this).find('.date_abuse').attr('data-profile'));
						$(this).find('.comment_to_id').html('жалоба на <a href="/review/'+postUrl+'/" class="color_dark_blue link_no_underline hover_dark">'+postCompany+'</a>');
					})
				}
				if ( (typeof userid === 'undefined') && (typeof company_page === 'undefined') ){
					var b_p_id = banners_info.b_p_id;
					get_h_info(b_p_id,'review_abuses_1');
					get_h_info(b_p_id,'review_abuses_2');
				}
				if (typeof company_page !== 'undefined') {
					popup_inside_dashboard__wrapper();
				}
				if (slug == 'dashboard_company') {
					$('.comment-reply-link').css('display','inline-block');
					$('.comment-reply-link').addClass('button button_green button_comments font_small font_bold m_b_10 pointer');
					$('.comment_reply_count,.comment_permalink, span.comment_share').css('display','none');
					$('.comment_reply_count').click();
				}

				if ((($(data).length < 2) || (parseInt($('.comments_top_count').text()) == 0)) && (typeof userid !== 'undefined')) {
					$('#abuses').empty();
					user_zero_message('abuse');
				}
				if (((typeof userid !== 'undefined') || (typeof company_page !== 'undefined')) && (typeof rounder_html !== 'undefined')) {
					rounder_html();
				}
			}
		});
	}



jQuery(document).ready(function($){
	
	$('body').on('submit', '#popup_form_abuse', function(e) {
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
				} else if (result.status === 'ok') {
					$('#popup_form_abuse').closest('.popup_container').remove();
					append_new_comment(result.comment_id,'abuse');
				}
			}
		);
	});

	$('body').on('click','.comment-reply-link_abuse', function(e) {
		if (typeof company_page !== 'undefined') {
			$('.comment-reply-link_abuse').css('display','block');
			$(this).css('display','none');
		}
	});
});