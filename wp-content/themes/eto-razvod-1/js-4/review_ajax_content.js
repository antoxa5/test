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
	$.ajax({
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


function ajax_popup_add_links(type,post_id) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=ajax_popup_add_links&type="+type+"&id="+post_id,
		beforeSend: function(xhr) {
		},
		complete: function(){
		},
		success: function( data ) {
			alert(data);
			$('#popup_modals').empty();
			$('#popup_modals').append(data);
			$('#popup_modals .popup_container').addClass('show');
			$('.popup_close_button').click(function() {
				var popup_id = $(this).closest('.popup_container').attr('id');
				$('#'+popup_id).remove();

			});
		}
	});

}


function list_more_ajax(post_id,tab_class) {
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
				$( '.'+tab_class+' .list_more_container' ).append( data );
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
		list_more_ajax(my_ajax_object.current_post_id,container_class);
	} else if (string == '#abuse') {
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_abuses';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_abuses').addClass('active');
		$('.review_links li.review_link_abuses').addClass('color_dark_blue');
		ajax_abuses('new');
		list_more_ajax(my_ajax_object.current_post_id,container_class);
	} else if (string == '#similar') {
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_similar';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_similar').addClass('active');
		$('.review_links li.review_link_similar').addClass('color_dark_blue');
		ajax_similar_companies(my_ajax_object.current_post_id);
		list_more_ajax(my_ajax_object.current_post_id,container_class);
	} else if (string == '#about') {
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_about';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_company').addClass('active');
		$('.review_links li.review_link_company').addClass('color_dark_blue');
		list_more_ajax(my_ajax_object.current_post_id,container_class);
	} else if (string == '#comments') {
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_reviews';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_reviews').addClass('active');
		$('.review_links li.review_link_reviews').addClass('color_dark_blue');
		ajax_comments('new');
	} else if (string.indexOf(substring) !== -1) {
		//alert(string);
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_reviews';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_reviews').addClass('active');
		$('.review_links li.review_link_reviews').addClass('color_dark_blue');
		ajax_comments('new');
	} else if(string == '') {
		//alert(string);
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_reviews';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_reviews').addClass('active');
		$('.review_links li.review_link_reviews').addClass('color_dark_blue');
		ajax_comments('new');
	} else {
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_content';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_fullreview').addClass('active');
		$('.review_links li.review_link_fullreview').addClass('color_dark_blue');
		list_more_ajax(my_ajax_object.current_post_id,container_class);
	}
	ajax_subscribe_block(my_ajax_object.current_post_id);
	ajax_verify_company_block(my_ajax_object.current_post_id);
	ajax_company_activities_abuses_block(my_ajax_object.current_post_id);
	ajax_new_companies_block(my_ajax_object.current_post_id);
	$('body').on('click', '.subscribe_widget', function(){
		var block_id = $(this).attr('id');
		var type = $('#'+block_id+' .subscribe_link').attr('data-type');
		var id = $('#'+block_id+' .subscribe_link').attr('data-id');
		var button_id = block_id;
		ajax_subscribe(type,id,button_id);
	});

	/*$('body').on('click', '.add_links li a', function(e){
		e.preventDefault();
		var post_id = $(this).attr('data-post-id');
		var type = $(this).attr('data-type');
		//alert(type);
		ajax_popup_add_links(type,post_id);
	});*/

});
$('body').on('click', '.toc_list a[href="#comments"]', function () {
	$('.review_links li').removeClass('active');
	$('.review_links li').removeClass('color_dark_blue');
	$('.page_container').removeClass('visible');
	var container_class = 'review_container_reviews';
	$('.'+container_class).addClass('visible');
	$('.review_links li.review_link_reviews').addClass('active');
	$('.review_links li.review_link_reviews').addClass('color_dark_blue');
	ajax_comments('new');
});
$('body').on('click', '.tabs_mobile_mover_new_companies_ul .tabs_mobile_mover__item', function () {
	active_number = $('.tabs_mobile_mover_new_companies_ul .tabs_mobile_mover__item_active').attr('data-n');
	data_number = $(this).attr('data-n');
	step = parseInt(data_number) - parseInt(active_number);

	t = 25;
	if (step > 0) {
		t = t - (2 * (data_number-1));
		v = (100 * data_number) - 100;
		$('.new_companies_ul > li:first-child').attr('style','margin-left: calc(-'+v+'% + '+t+'px);');
	} else {
		t = t - (2 * (data_number-1));
		v = (100 * data_number) - 100;
		$('.new_companies_ul > li:first-child').attr('style','margin-left: calc(-'+v+'% + '+t+'px);');
	}

	$('.tabs_mobile_mover_new_companies_ul .tabs_mobile_mover__item').removeClass('tabs_mobile_mover__item_active');
	$(this).addClass('tabs_mobile_mover__item_active');
})