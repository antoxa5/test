$ = jQuery.noConflict();

function ajax_posts(sort_type,userid) {
	$('.profile_posts_wrapper').empty();
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=get_user_posts&sort_type="+sort_type+"&user_id="+userid,
			beforeSend: function(xhr) {
				$('.profile_posts_wrapper').append('<div class="load_ajax"></div>');
			},
			complete: function(){
				$(".profile_posts_wrapper .load_ajax").remove();
			},
			success: function( data ) {
				$('.profile_posts_wrapper').append(data);
				// if (typeof userid !== 'undefined'){
				// 	$("#abuses > li").each(function (){
				// 		postUrl = $(this).attr('data-url');
				// 		postCompany = $(this).attr('data-company');
				// 		$('.date_abuse').css('margin-left','15px');
				// 		$(this).find('.date_abuse').text($(this).find('.date_abuse').attr('data-profile'));
				// 		$(this).find('.comment_to_id').html('жалоба на <a href="/review/'+postUrl+'/" class="color_dark_blue link_no_underline hover_dark">'+postCompany+'</a>');
				// 	})
				// }
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
});