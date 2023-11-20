$ = jQuery.noConflict();

function load_popular_rating(rating_id,block_id) {
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=load_popular_rating&rating_id="+rating_id,
			beforeSend: function(xhr) {
				$('#'+block_id+' .popular_ratings_right').empty();
				$('#'+block_id+' .popular_ratings_right').append('<div class="load_ajax"></div>');
			},
			complete: function(){
				$('#'+block_id+' .popular_ratings_right .load_ajax').remove();
			},
			success: function( data ) {
				$('#'+block_id+' .popular_ratings_right').append(data);
				$('#'+block_id+' .popular_ratings_right .review_average_round' ).each(function() {
					var id = $(this).attr('id');
					var percent = $(this).attr('data-percent');
					append_circle_bar(id,percent);
				});


				if ($(window).width() < 701) {

					$.getScript("/wp-content/themes/eto-razvod-1/js/jquery.touchSwipe.min.js", function() {
						$(".load_popular_rating").swipe( {
							swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
								if ($('.tabs_rates .tabs_mobile_mover__item_active').next().attr('data-n') == '7') {

								} else {
									$('.tabs_rates .tabs_mobile_mover__item_active').next().click();
								}

								//$('tabs_mobile_mover__item tabs_mobile_mover__item_active"')
							},
							threshold:0,
							excludedElements: "a, .compare_container",
						});
						a = '1';
						$(".load_popular_rating").swipe( {

							swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
								$('.tabs_rates .tabs_mobile_mover__item_active').prev().click();
							},
							threshold:0,
							excludedElements: "a, .compare_container"
						});
					});
				}
			}
		});
	}

jQuery(document).ready(function($){
	$('body').on('click','.show_more_popular_ratings',function() {
		var block_id = $(this).closest('.block_popular_ratings').attr('id');
		$('#'+block_id+' .hide_more').toggleClass('active');
		$(this).remove();
	});
	$('.popular_ratings_list li.active' ).each(function() {
			var block_id = $(this).closest('.block_popular_ratings').attr('id');
			var rating_id = $(this).attr('data-rating-id');
			console.log(block_id+' '+rating_id);
			load_popular_rating(rating_id,block_id);
		});
	$('body').on('click','.popular_ratings_list li.inactive',function() {
		var block_id = $(this).closest('.block_popular_ratings').attr('id');
		var rating_id = $(this).attr('data-rating-id');
		$('#'+block_id+' .popular_ratings_list li').removeClass('active');
		$('#'+block_id+' .popular_ratings_list li').addClass('inactive');
		load_popular_rating(rating_id,block_id);
		$(this).removeClass('inactive');
		$(this).addClass('active');
	});
});

$('body').on('click', '.tabs_rates .tabs_mobile_mover__item', function () {
	if ($(window).width() < 701) {

		active_number = $('.tabs_rates .tabs_mobile_mover__item_active').attr('data-n');
		data_number = $(this).attr('data-n');
		step = parseInt(data_number) - parseInt(active_number);

		t = 25;
		if (step > 0) {
			t = t - (2 * (data_number - 1));
			v = (100 * data_number) - 100;
			$('.load_popular_rating > li:first-child').attr('style', 'margin-left: calc(-' + v + '% + ' + t + 'px);');
		} else {
			t = t - (2 * (data_number - 1));
			v = (100 * data_number) - 100;
			$('.load_popular_rating > li:first-child').attr('style', 'margin-left: calc(-' + v + '% + ' + t + 'px);');
		}

		/*$(this).prev().removeClass('tabs_mobile_mover__item_active');
		$(this).next().removeClass('tabs_mobile_mover__item_active');*/
		$(this).parent().find('.tabs_mobile_mover__item').removeClass('tabs_mobile_mover__item_active');
		$(this).addClass('tabs_mobile_mover__item_active');

	} else {
		active_number = $('.tabs_rates .tabs_mobile_mover__item_active').attr('data-n');
		data_number = $(this).attr('data-n');
		step = parseInt(data_number) - parseInt(active_number);

		t = 25;
		if (step > 0) {
			//t = t - (2 * (data_number - 1));
			v = (397 * (data_number - 1));
			$('.load_popular_rating > li:first-child').attr('style', 'margin-left: calc(-' + v + 'px);');
		} else {
			//t = t - (2 * (data_number - 1));
			v = (397 * (data_number - 1));
			$('.load_popular_rating > li:first-child').attr('style', 'margin-left: calc(-' + v + 'px);');
		}

		//$('.tabs_rates .tabs_mobile_mover__item').removeClass('tabs_mobile_mover__item_active');
		$(this).parent().find('.tabs_mobile_mover__item').removeClass('tabs_mobile_mover__item_active');
		$(this).addClass('tabs_mobile_mover__item_active');
	}
})

$('body').on('click', '.arrow_right_rate', function(){
	if ($(this).parent().prev().find('.tabs_mobile_mover__item_active').next().size() == 0) {
		$(this).parent().prev().find('.tabs_mobile_mover__item:first-child').click();
	} else {
		$(this).parent().prev().find('.tabs_mobile_mover__item_active').next().click();
	}
});

$('body').on('click', '.arrow_left_rate', function(){
	if ($(this).parent().prev().find('.tabs_mobile_mover__item_active').prev().size() == 0) {
		$(this).parent().prev().find('.tabs_mobile_mover__item:last-child').click();
	} else {
		$(this).parent().prev().find('.tabs_mobile_mover__item_active').prev().click();
	}
});