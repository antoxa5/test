$ = jQuery.noConflict();
function show_h_info(goal,object,post_id) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=show_h_info&post_id="+post_id+"&goal="+goal+"&object="+object,
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			if(goal === 'popup') {
				//$('#popup_modals').empty();
				$('#popup_modals').append(data);
				$('#popup_modals .popup_container').addClass('show');
				$('#popup_modals .popup_window').addClass('shown');
				$('.popup_close_button').click(function() {

					var popup_id = $(this).closest('.popup_container').attr('id');
					$('#'+popup_id+' .popup_window').removeClass('shown');
					//$('#'+popup_id).remove();

					$('#'+popup_id+' .popup_window').hide("slow",function() {
						$('#'+popup_id).remove();
					});

					document.cookie = post_id+"_popup=1; path=/; expires=Tue, 19 Jan 2038 03:14:07 GMT";
				});

				if ($(window).width() < 701) {
					$.getScript("/wp-content/themes/eto-razvod-1/js/jquery.touchSwipe.min.js", function() {
						$(".top_companies_heygo").swipe( {
							swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
								$('.heygo_slider_mobile span.active').next().click();
							},
							threshold:0,
							excludedElements: "a, .link_promocode_show_more",
						});
						$(".top_companies_heygo").swipe( {
							swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
								$('.heygo_slider_mobile span.active').prev().click();
							},
							threshold:0,
							excludedElements: "a, .link_promocode_show_more"
						});
					});
				}
			} else if (goal === 'review_reviews_1') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none') {
					$("#reviews > li.white_block:nth-of-type(2)").after(data);
				}

			} else if (goal === 'review_reviews_2') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none') {
					$("#reviews > li.white_block:nth-of-type(9)").after(data);
				}

			} else if (goal === 'review_abuses_1') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none') {
					$("#abuses > li.white_block:nth-of-type(2)").after(data);
				}

			} else if (goal === 'review_abuses_2') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none') {
					$("#abuses > li.white_block:nth-of-type(9)").after(data);
				}
			} else if (goal === 'review_content_1') {
				//alert(data);
				$('#hey_content_'+goal).remove();
				if(data !== 'none') {
					$(".the_content p:nth-of-type(5)").append(data);
				}
			} else if (goal === 'review_content_2') {
				//alert(data);
				$('#hey_content_'+goal).remove();
				if(data !== 'none') {
					$(".the_content p:nth-of-type(10)").append(data);
				}
			} else if (goal === 'rating_1') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none') {
					$(".rating_table:nth-of-type(1) > div.main_row:nth-of-type(2)").after(data);
				}
			} else if (goal === 'rating_2') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none') {
					$(".rating_table:nth-of-type(1) > div.main_row:nth-of-type(7)").after(data);
				}
			}

		}
	});
}


function hey_check_content(goal,object,post_id) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=show_h_info&post_id="+post_id+"&goal="+goal+"&object="+object,
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			if(goal === 'popup') {
				if(data !== 'none') {
					$('body').append('<div id="icon_user_gift" class="inactive"></div>');

					var mouseX = 0;
					var mouseY = 0;
					var popupCounter = 0;

					document.addEventListener("mousemove", function(e) {
						mouseX = e.clientX;
						mouseY = e.clientY;
					});

					$(document).mouseleave(function () {
						if (mouseY < 100) {
							if (popupCounter < 1) {
								if (document.cookie.indexOf(post_id+'_popup') != '-1') {
								} else {
									show_h_info(goal,object,post_id);
								}

							}
							popupCounter ++;
						}
					});

					setTimeout(function() {
						if (document.cookie.indexOf(post_id+'_popup') != '-1') {
						} else {
							show_h_info(goal,object,post_id);
						}
					}, 20000);
				} else {
					//alert(data);
				}
			}

		}
	});
}


function get_h_info(post_id,goal) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=get_h_info&post_id="+post_id+"&goal="+goal,
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			data = JSON.parse(data);
			$.each(data, function(k, v) {
				if(goal === 'all') {
					if(k === 'popup') {
						hey_check_content(k,v,post_id);
					} else {
						show_h_info(k,v,post_id);
					}
				} else {
					show_h_info(k,v,post_id);
				}
			});
		}
	});
}

jQuery(document).ready(function($){
	jjdjdjd = 0;
	var b_p_id = banners_info.b_p_id;

	get_h_info(b_p_id,'all');

	$('body').on('click', '#icon_user_gift.inactive', function(){
		get_h_info(b_p_id,'popup');
	});

	$('body').on('click', '.heygo_slider span.inactive', function(){
		$('.heygo_slider span.active').addClass('inactive');
		$('.heygo_slider span.active').removeClass('active');
		$(this).removeClass('inactive');
		$(this).addClass('active');
		var hey_id = $(this).closest('.heygo_container').attr('id');
		var number = $(this).attr('data-number');
		//alert(hey_id + ' '+ number);
		var hidden = $('#'+hey_id+ ' .top_companies_heygo li.white_block:nth-of-type(1)');
		if(number === '2') {
			var offset = '-100%';
		} else {
			var offset = '0';
		}

		hidden.animate({"margin-left":offset}, 500,function() {
			//$('.user_nav_settings').remove();
		});

	});
	$('body').on('click', '.top_companies_heygo li', function(e){
		e.preventDefault();
		var id = $(this).attr('id');

		var link = $('#'+id+' a.go_more').attr('href');
		//alert(link);
		window.open(link,'_newtab');
		//$( "#"+id+" .go_more" ).trigger( "click" );
	});
	$('body').on('click', '.heygo_slider_mobile span', function () {
		active_number = $('.heygo_slider_mobile span.active').attr('data-number');
		data_number = $(this).attr('data-number');
		step = parseInt(data_number) - parseInt(active_number);

		t = 100;
		if (step > 0) {
			t = t + ((data_number-1));
			v = (100 * (data_number-1));
			pastevar = '-'+v+'%';
			$('.top_companies_heygo > li:first-child').animate({"margin-left": ""+pastevar+""}, 500,function() {
			});
		} else {
			t = t + ((data_number-1));
			v = (100 * (data_number-1));
			pastevar = '-'+v+'%';
			$('.top_companies_heygo > li:first-child').animate({"margin-left": ""+pastevar+""}, 500,function() {
			});
		}

		$('.heygo_slider_mobile span').removeClass('active');
		$(this).addClass('active');
	})
});