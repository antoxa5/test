$ = jQuery.noConflict();

function get_ad_text_show_comment(post_id) {
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

	if ($(".data-ad")[0]){
		var comment_current_post_id = $('.data-ad').attr('data-main-post-id');
		//alert(comment_current_post_id);
		get_ad_text_show_comment(comment_current_post_id);
	};

});