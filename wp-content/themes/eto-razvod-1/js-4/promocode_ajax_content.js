$ = jQuery.noConflict();

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


function ajax_new_companies_block(post_id) {
	$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=ajax_new_companies_block&post_id="+post_id,
			beforeSend: function(xhr) {
			},
			complete: function(){
			},
			success: function( data ) {
				$('.new_companies_widget').remove();
				$( '.page_after_content' ).append( data );
				$('.new_companies_widget .review_average_round' ).each(function() {
					
					var id = $(this).attr('id');
					var percent = $(this).attr('data-percent');
					append_circle_bar(id,percent);
				});
			}
		});
}

function list_more_ajax(post_id) {
	$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=list_more_ajax&post_id="+post_id,
			beforeSend: function(xhr) {
			},
			complete: function(){
			},
			success: function( data ) {
				$('.list_more_widget').remove();
				$( '.list_more_container' ).append( data );
			}
		});
}

function ajax_subscribe(type,id,button_id) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=ajax_subscribe&type="+type+"&id="+id+"&button_id="+button_id,
		beforeSend: function(xhr) {
		},
		complete: function(){
		},
		success: function( data ) {
			result = JSON.parse(data);
			if(result.status === 'added') {
				$('#'+button_id+' .subscribe_link').addClass('active');
				$('#'+button_id+' .subscribe_link').empty();
				$('#'+button_id+' .subscribe_link').append(result.message);
				$('#'+button_id+' .alertsimg').addClass('active');
			} else if (result.status === 'deleted') {
				$('#'+button_id+' .subscribe_link').removeClass('active');
				$('#'+button_id+' .alertsimg').removeClass('active');
				$('#'+button_id+' .subscribe_link').empty();
				$('#'+button_id+' .subscribe_link').append(result.message);
			} else if (result.status === 'auth') {
				auth_link(result.message);
			}
		}
	});

}

jQuery(document).ready(function($){
	size_li = $(".single_promocodes_list li").size();
    x=9;
    $('.single_promocodes_list li:lt('+x+')').show();
    $('.load_more_single_promocodes').click(function () {
        x= (x+5 <= size_li) ? x+5 : size_li;
        $('.single_promocodes_list li:lt('+x+')').show();
		if(x == size_li){
            $('.load_more_single_promocodes').hide();
        }
    });
    
	ajax_subscribe_block(my_ajax_object.current_post_id);
	ajax_verify_company_block(my_ajax_object.current_post_id);
	ajax_new_companies_block(my_ajax_object.current_post_id);
	list_more_ajax(my_ajax_object.current_post_id);
	$('body').on('click', '.subscribe_widget', function(){
		var block_id = $(this).attr('id');
		var type = $('#'+block_id+' .subscribe_link').attr('data-type');
		var id = $('#'+block_id+' .subscribe_link').attr('data-id');
		var button_id = block_id;
		ajax_subscribe(type,id,button_id);
	});
	$('body').on('click', '.schema-faq-question', function(){
		var q_id = $(this).closest('.schema-faq-section').attr('id');
		$('#'+q_id).toggleClass('active');
	});
});