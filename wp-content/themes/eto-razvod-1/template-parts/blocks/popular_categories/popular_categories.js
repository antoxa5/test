$ = jQuery.noConflict();

function ajax_show_popular_cat_content(term_id,block_id,post_type,block_append) {
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=ajax_show_popular_cat_content&term_id="+term_id+"&post_type="+post_type+"&block_id="+block_id+"&block_append="+block_append,
			beforeSend: function(xhr) {
				$('#'+block_id+'_result .wrap').empty();
				$('#'+block_id+'_result .wrap').append('<div class="load_ajax"></div>');
			},
			complete: function(){
				$('#'+block_id+'_result .wrap .load_ajax').remove();
			},
			success: function( data ) {
				$('#'+block_id+'_result .wrap').append(data);
				$('#'+block_id+'_result .review_average_round' ).each(function() {
					var id = $(this).attr('id');
					var percent = $(this).attr('data-percent');
					append_circle_bar(id,percent);
					
				});
				
			}
		});
	}

function load_more_content(offset,post_type,tag,container,block_id,per_page,total) {
	//alert('offset ' + offset + ' post_type ' + post_type + ' container ' + container + ' tag' + tag  + ' block_id ' + block_id + ' per_page ' + per_page + ' total '+total);
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: 'POST',
		data: "action=load_more&offset="+offset+"&post_type="+post_type+"&tag="+tag,
		beforeSend: function(xhr) {
			$('#'+block_id+' .line_show_more').removeClass('inactive');
			$('#'+block_id+' .line_show_more').append('<div class="spinner spinner_white"></div>');
			$('#'+block_id+' .line_show_more .spinner').show();

		},
		complete: function(){
			$('#'+block_id+' .line_show_more .spinner').remove();
			$('#'+block_id+' .line_show_more').addClass('inactive');
		},
		success: function( data ) {
			var new_offset = +offset + +per_page;
			$('#'+block_id+' '+container).append(data);
			if(new_offset >= total) {
				$('#'+block_id+' .line_show_more').remove();
			} else {
				$('#'+block_id+' .line_show_more').attr( 'data-offset', new_offset );
			}
			$( ".review_average_round" ).each(function() {
				var id = $(this).attr('id');
				var percent = $(this).attr('data-percent');
				append_circle_bar(id,percent);
			});
			
		}
	});
}

jQuery(document).ready(function($){
	$('.block_reviews_list .review_average_round' ).each(function() {
		var id = $(this).attr('id');
		var percent = $(this).attr('data-percent');
		append_circle_bar(id,percent);
	});
	$('body').on('click','.show_more_popular_categories',function() {
		var block_id = $(this).closest('.block_popular_cats').attr('id');
		$('#'+block_id+' .hide_more').toggleClass('active');
		$(this).remove();
	});
	$('body').on('click','.popular_cats li',function() {
		var block_id = $(this).closest('.block_popular_cats').attr('id');
		var term_id = $(this).attr('data-term-id');
		var block_append = $(this).attr('data-block-append');
		var post_type = $(this).attr('data-post-type');
		//alert(term_id);
		$('#'+block_id+' .popular_cats li').removeClass('active');
		ajax_show_popular_cat_content(term_id,block_id,post_type,block_append)
		$(this).addClass('active');
	});
	$('body').on('click', '.line_show_more.inactive', function(){
		var offset = $(this).attr('data-offset');
		var block_id = $(this).attr('data-block-id');
		var per_page = $(this).attr('data-per-page');
		var total = $(this).attr('data-total');
		var post_type = $(this).attr('data-post-type');
		var tag = $(this).attr('data-tag');
		var container = $(this).attr('data-container');
		//alert(args);
		load_more_content(offset,post_type,tag,container,block_id,per_page,total);
	});


	if ($(window).width() < 701) {
		$.getScript("/wp-content/themes/eto-razvod-1/js/jquery.touchSwipe.min.js", function() {
			$(".popular_cat_ul").swipe( {
				swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
					$('.tabs_mobile_mover_popular_cat_ul .tabs_mobile_mover__item_active').next().click();
				},
				threshold:0,
				excludedElements: "a, .link_promocode_show_more, .link_promocode_show_more_text, .promocode_single_text, .link_promocode_get_visit, .link_promocode_text_copy",
			});
			$(".popular_cat_ul").swipe( {
				swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
					$('.tabs_mobile_mover_popular_cat_ul .tabs_mobile_mover__item_active').prev().click();
				},
				threshold:0,
				excludedElements: "a, .link_promocode_show_more, .link_promocode_show_more_text, .promocode_single_text, .link_promocode_get_visit, .link_promocode_text_copy"
			});
		});
	}
});

$('body').on('click', '.tabs_mobile_mover_popular_cat_ul .tabs_mobile_mover__item', function () {
	active_number = $('.tabs_mobile_mover_popular_cat_ul .tabs_mobile_mover__item_active').attr('data-n');
	data_number = $(this).attr('data-n');
	step = parseInt(data_number) - parseInt(active_number);

	t = 22;
	t = t * (data_number - 1);
	v = (100 * data_number) - 100;
	if (data_number == 1) {
		$('.popular_cat_ul > li:first-child').attr('style','margin-left: 0;');
	} else {
		$('.popular_cat_ul > li:first-child').attr('style','margin-left: calc(-'+v+'% - '+t+'px);');
	}

	$('.tabs_mobile_mover_popular_cat_ul .tabs_mobile_mover__item').removeClass('tabs_mobile_mover__item_active');
	$(this).addClass('tabs_mobile_mover__item_active');
})