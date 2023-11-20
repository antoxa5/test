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



				if (document.cookie.indexOf("popupmaincookie") != "-1") {

				} else {
					$('#popup_modals').append(data);
					$('#popup_modals .popup_container').addClass('show');
					$('#popup_modals .popup_window').addClass('shown');
				}

				$('.popup_close_button').click(function() {

					var popup_id = $(this).closest('.popup_container').attr('id');
					$('#'+popup_id+' .popup_window').removeClass('shown');
					//$('#'+popup_id).remove();

					$('#'+popup_id+' .popup_window').hide("slow",function() {
						$('#'+popup_id).remove();
					});
					//console.log(1);
					var expires = (new Date(Date.now()+ 86400*1000)).toUTCString();console.log(expires);
					var expires_second = (new Date(Date.now()+ 86400*1000)).toUTCString();console.log(expires_second);
					document.cookie = post_id+"_popup=1; path=/; expires="+expires;
					document.cookie = "popupmaincookie=1; path=/; expires="+expires_second;
					console.log('1');

				});



				if ($(window).width() < 701) {
					$.getScript("/wp-content/themes/eto-razvod-1/js/jquery.touchSwipe.min.js", function() {
						$(".top_companies_heygo").swipe( {
							swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
								if ($('.heygo_slider_mobile span.active').next().size() == 0) {
									$('.heygo_slider_mobile > span:first-child').click();
								} else {
									$('.heygo_slider_mobile span.active').next().click();
								}
								//$('.heygo_slider_mobile span.active').next().click();
							},
							threshold:0,
							excludedElements: "a, .link_promocode_show_more",
						});
						$(".top_companies_heygo").swipe( {
							swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
								if ($('.heygo_slider_mobile span.active').prev().size() == 0) {
									$('.heygo_slider_mobile > span:last-child').click();
								} else {
									$('.heygo_slider_mobile span.active').prev().click();
								}
								//$('.heygo_slider_mobile span.active').prev().click();
							},
							threshold:0,
							excludedElements: "a, .link_promocode_show_more"
						});
						$('.heygo_promocodes').swipe( {
							swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
								if ($('.heygo_slider_big_promocodes span.active').prev().size() == 0) {
									$('.heygo_slider_big_promocodes > span:last-child').click();
								} else {
									$('.heygo_slider_big_promocodes span.active').prev().click();
								}
							},
							threshold:0,
							excludedElements: "a, .link_promocode_show_more, .link_promocode_text_copy"
						});
						$(".heygo_promocodes").swipe( {
							swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
								if ($('.heygo_slider_big_promocodes span.active').next().size() == 0) {
									$('.heygo_slider_big_promocodes > span:first-child').click();
								} else {
									$('.heygo_slider_big_promocodes span.active').next().click();
								}
								//$('.heygo_slider_mobile span.active').next().click();
							},
							threshold:0,
							excludedElements: "a, .link_promocode_show_more, .link_promocode_text_copy",
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
				$('#hey_content_'+goal).remove();
				step = 0;
				first_step = 0;
				second_step = 0;
				
				$('.the_content p').each(function() {
					if( (!($(this).hasClass('topreview'))) && (!($(this).prev().hasClass('topreview')))  && (!($(this).next().hasClass('topreview'))) ) {
						step++;
						if(step == 9) {
							$(this).addClass('here_1');
						} else if(step == 20) {
							$(this).addClass('here_2');
						}
						
					}
				});
				
				
				if(data !== 'none') {
					$(".the_content p.here_1").prepend(data);
				}
				
				
				
				
			} else if (goal === 'review_content_2') {
				//alert(data);
				$('#hey_content_'+goal).remove();
				if(data !== 'none') {
					$(".the_content p.here_2").prepend(data);
				}
			} else if (goal === 'review_sidebar') {
				//alert(data);
				$('.review_sidebar_banner').empty();
				console.log('side: '+data);
				if(data !== 'none') {
					$(".review_sidebar_banner").append(data);

					if ( $('.review_container_reviews').hasClass( "visible" ) ) {
						$('.review_sidebar_banner').removeClass('sticky');
						var $cache = $('.review_container_reviews .review_sidebar_banner');
						var vTop = $cache.offset().top;
						$(window).scroll(function(){

							if ($(window).scrollTop() >= vTop+200+380) {
								if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 250) {
									$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');
								} else {
									$('.review_container_reviews .review_sidebar_banner').addClass('sticky');console.log('heygo.js #1');
								}

							}
							else {
								if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 250) {
									$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');
								} else {
									$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');
								}
							}
						});
					}
					
				}
			} else if (goal === 'rating_1') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none') {
					$(".rating_table:nth-of-type(1) > div.main_row:nth-of-type(3)").after(data);
				}
			} else if (goal === 'rating_2') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none') {
					$(".rating_table:nth-of-type(1) > div.main_row:nth-of-type(13)").after(data);
				}
			} else if (goal === 'rating_3') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none') {
					$(".rating_table:nth-of-type(1) > div.main_row:nth-of-type(25)").after(data);
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
			if (my_ajax_object.current_post_id != '176586') {
				if(goal === 'popup') {
					if(data !== 'none') {
						$('body').append('<div id="icon_user_gift" class="inactive"></div>');
						//console.log(data.find('.heygo_promocodes').attr('data-id'));




						if (!(/top_companies_heygo/i.test(data))){
							if (/review/i.test(my_ajax_object.actual_link)){
								var mySubString = data.substring(
									data.lastIndexOf('data-count="') + 12,
									data.lastIndexOf('" data-count-list')
								);
								$('#icon_user_gift').append('<span class="number_g">'+mySubString+'</span>');
							}
						}
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
						}, 30000);
					} else {
						//alert(data);
					}
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
	//jjdjdjd = 0;
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
		} else if(number === '3') {
			var offset = '-200%';
		} else {
			var offset = '0';
		}

		hidden.animate({"margin-left":offset}, 500,function() {
			//$('.user_nav_settings').remove();
		});

	});
	/*$('body').on('click', '.top_companies_heygo li', function(e){
		e.preventDefault();
		var id = $(this).attr('id');

		var link = $('#'+id+' a.go_more').attr('href');
		//alert(link);
		window.open(link,'_newtab');
		//$( "#"+id+" .go_more" ).trigger( "click" );
	});*/
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
	});

	$('body').on('click', '.heygo_slider_big_promocodes span', function () {
		active_number = $('.heygo_slider_big_promocodes span.active').attr('data-number');
		data_number = $(this).attr('data-number');
		step = parseInt(data_number) - parseInt(active_number);

		t = 100;
		if (step > 0) {
			t = t + ((data_number-1));
			v = (100 * (data_number-1));
			pastevar = '-'+v+'%';
			$('.heygo_promocodes > li:first-child').animate({"margin-left": ""+pastevar+""}, 500,function() {
			});
		} else {
			t = t + ((data_number-1));
			v = (100 * (data_number-1));
			pastevar = '-'+v+'%';
			$('.heygo_promocodes > li:first-child').animate({"margin-left": ""+pastevar+""}, 500,function() {
			});
		}

		$('.heygo_slider_big_promocodes span').removeClass('active');
		$(this).addClass('active');
		$('.heygo_promocodes .link_promocode_show_more').removeClass('active');
		$('.heygo_promocodes .promocode_full_description').removeClass('active');
	});


	$('body').on('click','.arrow_right_top_promocodes', function () {
		if ($('.heygo_slider_big_promocodes span.active').next().size() == 0) {
			$('.heygo_slider_big_promocodes > span:first-child').click();
		} else {
			$('.heygo_slider_big_promocodes span.active').next().click();
		}
	});

	$('body').on('click','.arrow_left_top_promocodes', function () {
		if ($('.heygo_slider_big_promocodes span.active').prev().size() == 0) {
			$('.heygo_slider_big_promocodes > span:last-child').click();
		} else {
			$('.heygo_slider_big_promocodes span.active').prev().click();
		}

	});


	$('body').on('click','.arrow_right_top_companies', function () {
		if ($(window).width() < 701) {
			if ($('.heygo_slider_mobile span.active').next().size() == 0) {
				$('.heygo_slider_mobile > span:first-child').click();
			} else {
				$('.heygo_slider_mobile span.active').next().click();
			}
		} else {
			if ($('.heygo_slider span.active').next().size() == 0) {
				$('.heygo_slider > span:first-child').click();
			} else {
				$('.heygo_slider span.active').next().click();
			}
		}
	});

	$('body').on('click','.arrow_left_top_companies', function () {
		if ($(window).width() < 701) {
			if ($('.heygo_slider_mobile span.active').prev().size() == 0) {
				$('.heygo_slider_mobile > span:last-child').click();
			} else {
				$('.heygo_slider_mobile span.active').prev().click();
			}
		} else {
			if ($('.heygo_slider span.active').prev().size() == 0) {
				$('.heygo_slider > span:last-child').click();
			} else {
				$('.heygo_slider span.active').prev().click();
			}
		}
	});

	$('body').on('click','.heygo_promocodes .link_promocode_show_more',function(){
		$(this).prev('.promocode_full_description').toggleClass('active');
	})
	//setTimeout(function() {
		var b_p_id = banners_info.b_p_id;
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=banner_popup_ajax&post_id="+b_p_id,
			beforeSend: function(xhr) {

			},
			success: function( data ) {
				//alert(data);
			console.log(data);
				$('.popup_banners_get').html(data);
			}
		});

	//}, 6000);
});