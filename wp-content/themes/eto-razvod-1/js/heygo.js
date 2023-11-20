$ = jQuery.noConflict();
test = 0;
function show_h_info(goal,object,post_id,second = 0) {
	console.log('55555555'+goal);
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=show_h_info&post_id="+post_id+"&goal="+goal+"&object="+object+"&second="+second,
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			if(goal === 'popup') {
				//console.log('00000000000000000000000000000000124214124124124124214');
				//$('#popup_modals').empty();
				if (document.cookie.indexOf("popupmaincookie") != "-1") {
					if (test == 1) {
						//console.log('545353535370000000000000000000000000000000000000000top_companies_heygo_best_com_3');
						setTimeout(function() {
							if ($('div#popup_modals').text().length == 0) {
								console.log('!!!!!!!77777753535353353535');
								//console.warn('f5');
								$('#popup_modals').append(data);
								$('#popup_modals .popup_window').addClass('shown');
								$('#popup_modals .popup_window').addClass('lshown91');
								$('#popup_modals .popup_container').addClass('show');
							}
						}, 7000);
					}

				} else {
					/*if (~data.indexOf("top_companies_heygo_best_com_3")) {
						setTimeout(function() {
							$('#popup_modals').append(data);
							$('#popup_modals .popup_container').addClass('show');
							$('#popup_modals .popup_window').addClass('shown');
						}, 3000);
					} else {
						$('#popup_modals').append(data);
						$('#popup_modals .popup_container').addClass('show');
						$('#popup_modals .popup_window').addClass('shown');
					}*/

					if (~data.indexOf("top_companies_heygo_best_com_3") && ((typeof clicked === 'undefined'))) {
						//console.log('0000000000000000000000000000000000000000top_companies_heygo_best_com_3');
						if (my_ajax_object.current_post_id == '59916') {

							if ($('div#popup_modals').text().length == 0) {
								//console.log('!!!!!!!53535353353535');
								//console.log(new Date(performance.timing.connectStart));
								//console.warn('f1');
								//console.log(new Date(Date.now()));
								$('#popup_modals').append(data);
								$('#popup_modals .popup_window').addClass('shown');
								$('#popup_modals .popup_window').addClass('lshown9413');
								$('#popup_modals .popup_container').addClass('show');
							}

						} else {
							//setTimeout(function() {
							if ($('div#popup_modals').text().length == 0) {
								//console.log(new Date(performance.timing.connectStart));
								//console.warn('f1');
								//console.log(new Date(Date.now()));
								$('#popup_modals').append(data);
								$('#popup_modals .popup_window').addClass('shown');
								$('#popup_modals .popup_window').addClass('lshown813');
								$('#popup_modals .popup_container').addClass('show');
							}
							//}, 7000);
						}


					} else {

						//console.log('simplebanner')
						if ($('div#popup_modals').text().length == 0) {
							console.log(new Date(performance.timing.connectStart));
							//console.warn('f2');
							console.log(new Date(Date.now()));
							$('#popup_modals').append(data);
							$('#popup_modals .popup_window').addClass('shown');
							$('#popup_modals .popup_window').addClass('lshown3');
							$('#popup_modals .popup_container').addClass('show');

							if (~data.indexOf("promocode_heygo")) {
								test = 1;
								//console.log('Ура, вызрвали');
								if (typeof clicked === 'undefined') {
									setTimeout(function () {
										//console.warn('pref2');
										show_h_info(goal, object, post_id, '1');
									}, 10000);
								}
							}
						} else {
							console.log(777777777777777777777777777777777777777777777);
							var timerId = setInterval(function(){
								console.log(9999999999999999999999999999);
								if ($('div#popup_modals').text().length == 0) {
									console.log(6666666666666666666666666666666666);
									//console.warn('f3');
									$('#popup_modals').append(data);
									$('#popup_modals .popup_window').addClass('shown');
									$('#popup_modals .popup_window').addClass('lshown5');
									$('#popup_modals .popup_container').addClass('show');

									if (~data.indexOf("promocode_heygo")) {
										console.log(33333333333333333333333333333333333);
										test = 1;
										//console.log('Ура, вызрвали');
										if (typeof clicked === 'undefined') {
											setTimeout(function () {
												//console.warn('pref1');
												show_h_info(goal, object, post_id, '1');
											}, 10000);
										}
									}
									clearInterval(timerId);
								}
								//console.log(3333);
							},7000);
						}
					}




				}

				if (~data.indexOf("top_companies_heygo_best_com_3") && ((typeof clicked === 'undefined'))) {
					//console.log('top_companies_heygo_best_com_3');
					setTimeout(function () {

						/*$('.popup_close_button').click(function () {

							var popup_id = $(this).closest('.popup_container').attr('id');
							$('#' + popup_id + ' .popup_window').removeClass('shown');
							//$('#'+popup_id).remove();

							$('#' + popup_id + ' .popup_window').hide("slow", function () {
								$('#' + popup_id).remove();
							});
							//console.log(1);
							var expires = (new Date(Date.now() + 86400 * 1000)).toUTCString();
							console.log(expires);
							var expires_second = (new Date(Date.now() + 86400 * 3000)).toUTCString();
							console.log(expires_second);
							document.cookie = post_id + "_popup=1; path=/; expires=" + expires;
							document.cookie = "popupmaincookie=1; path=/; expires=" + expires_second;
							console.log('1');
						});*/

						if ($(window).width() < 701) {
							$.getScript("/wp-content/themes/eto-razvod-1/js/jquery.touchSwipe.min.js", function () {
								$(".top_companies_heygo").swipe({
									swipeLeft: function (event, direction, distance, duration, fingerCount, fingerData) {
										if ($('.heygo_slider_mobile span.active').next().size() == 0) {
											$('.heygo_slider_mobile > span:first-child').click();
										} else {
											$('.heygo_slider_mobile span.active').next().click();
										}
										//$('.heygo_slider_mobile span.active').next().click();
									},
									threshold: 0,
									excludedElements: "a, .link_promocode_show_more",
								});
								$(".top_companies_heygo").swipe({
									swipeRight: function (event, direction, distance, duration, fingerCount, fingerData) {
										if ($('.heygo_slider_mobile span.active').prev().size() == 0) {
											$('.heygo_slider_mobile > span:last-child').click();
										} else {
											$('.heygo_slider_mobile span.active').prev().click();
										}
										//$('.heygo_slider_mobile span.active').prev().click();
									},
									threshold: 0,
									excludedElements: "a, .link_promocode_show_more"
								});
								$('.heygo_promocodes').swipe({
									swipeRight: function (event, direction, distance, duration, fingerCount, fingerData) {
										if ($('.heygo_slider_big_promocodes span.active').prev().size() == 0) {
											$('.heygo_slider_big_promocodes > span:last-child').click();
										} else {
											$('.heygo_slider_big_promocodes span.active').prev().click();
										}
									},
									threshold: 0,
									excludedElements: "a, .link_promocode_show_more, .link_promocode_text_copy"
								});
								$(".heygo_promocodes").swipe({
									swipeLeft: function (event, direction, distance, duration, fingerCount, fingerData) {
										if ($('.heygo_slider_big_promocodes span.active').next().size() == 0) {
											$('.heygo_slider_big_promocodes > span:first-child').click();
										} else {
											$('.heygo_slider_big_promocodes span.active').next().click();
										}
										//$('.heygo_slider_mobile span.active').next().click();
									},
									threshold: 0,
									excludedElements: "a, .link_promocode_show_more, .link_promocode_text_copy",
								});
							});
						}
					}, 7000);

				} else {

					$('.popup_close_button').click(function () {

						var popup_id = $(this).closest('.popup_container').attr('id');
						$('#' + popup_id + ' .popup_window').removeClass('shown');
						//$('#'+popup_id).remove();

						$('#' + popup_id + ' .popup_window').hide("slow", function () {
							$('#' + popup_id).remove();
						});
						//console.log(1);
						var expires = (new Date(Date.now() + 86400 * 1000)).toUTCString();
						console.log(expires);
						var expires_second = (new Date(Date.now() + 86400 * 3000)).toUTCString();
						console.log(expires_second);
						document.cookie = post_id + "_popup=1; path=/; expires=" + expires;
						document.cookie = "popupmaincookie=1; path=/; expires=" + expires_second;
						//console.log('1');
					});

					if ($(window).width() < 701) {
						$.getScript("/wp-content/themes/eto-razvod-1/js/jquery.touchSwipe.min.js", function () {
							$(".top_companies_heygo").swipe({
								swipeLeft: function (event, direction, distance, duration, fingerCount, fingerData) {
									if ($('.heygo_slider_mobile span.active').next().size() == 0) {
										$('.heygo_slider_mobile > span:first-child').click();
									} else {
										$('.heygo_slider_mobile span.active').next().click();
									}
									//$('.heygo_slider_mobile span.active').next().click();
								},
								threshold: 0,
								excludedElements: "a, .link_promocode_show_more",
							});
							$(".top_companies_heygo").swipe({
								swipeRight: function (event, direction, distance, duration, fingerCount, fingerData) {
									if ($('.heygo_slider_mobile span.active').prev().size() == 0) {
										$('.heygo_slider_mobile > span:last-child').click();
									} else {
										$('.heygo_slider_mobile span.active').prev().click();
									}
									//$('.heygo_slider_mobile span.active').prev().click();
								},
								threshold: 0,
								excludedElements: "a, .link_promocode_show_more"
							});
							$('.heygo_promocodes').swipe({
								swipeRight: function (event, direction, distance, duration, fingerCount, fingerData) {
									if ($('.heygo_slider_big_promocodes span.active').prev().size() == 0) {
										$('.heygo_slider_big_promocodes > span:last-child').click();
									} else {
										$('.heygo_slider_big_promocodes span.active').prev().click();
									}
								},
								threshold: 0,
								excludedElements: "a, .link_promocode_show_more, .link_promocode_text_copy"
							});
							$(".heygo_promocodes").swipe({
								swipeLeft: function (event, direction, distance, duration, fingerCount, fingerData) {
									if ($('.heygo_slider_big_promocodes span.active').next().size() == 0) {
										$('.heygo_slider_big_promocodes > span:first-child').click();
									} else {
										$('.heygo_slider_big_promocodes span.active').next().click();
									}
									//$('.heygo_slider_mobile span.active').next().click();
								},
								threshold: 0,
								excludedElements: "a, .link_promocode_show_more, .link_promocode_text_copy",
							});
						});
					}
				}
				clicked = null;
			} else if (goal === 'review_reviews_1') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none' && data.length > 15) {
					$("#reviews > li.white_block:nth-of-type(2)").after(data);
					$(".show-comments > li.white_block:nth-of-type(2)").after(data);
				}

			} else if (goal === 'review_reviews_2') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none' && data.length > 15) {
					$("#reviews > li.white_block:nth-of-type(9)").after(data);
					$(".show-comments > li.white_block:nth-of-type(9)").after(data);
				}

			} else if (goal === 'review_abuses_1') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none'  && data.length > 15) {
					$("#abuses > li.white_block:nth-of-type(2)").after(data);
				}

			} else if (goal === 'review_abuses_2') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none' && data.length > 15) {
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


				/*if(data !== 'none' && data.length > 15) {//14032023
					$(".the_content p.here_1").prepend(data);
				}*/




			} else if (goal === 'review_content_2') {
				//alert(data);
				$('#hey_content_'+goal).remove();
				if(data !== 'none' && data.length > 15) {
					$(".the_content p.here_2").prepend(data);
				}
			} else if (goal === 'review_sidebar') {
				//console.log('!!!!!!!!!!2222222');
				//alert(data);
				$('.review_sidebar_banner').empty();
				//console.log('side: '+data);
				if(data !== 'none' && data.length > 15) {
					$(".review_sidebar_banner").append(data);

					if ( $('.review_container_reviews').hasClass( "visible" ) ) {
						$('.review_sidebar_banner').removeClass('sticky');
						var $cache = $('.review_container_reviews .review_sidebar_banner');
						var vTop = $cache.offset().top;
						$(window).scroll(function(){

							if ($(window).scrollTop() >= vTop+200+380) {
								if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
									$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');
								} else {
									$('.review_container_reviews .review_sidebar_banner').addClass('sticky');//console.log('heygo.js #1');
								}

							}
							else {
								if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
									$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');
								} else {
									$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');
								}
							}
						});
					} else if ( $('.review_container_actions').hasClass( "visible" ) ) {
					    $('.review_sidebar_banner').removeClass('sticky');
						var $cache = $('.review_container_actions .review_sidebar_banner');
						var vTop = $cache.offset().top;
						$(window).scroll(function(){

							if ($(window).scrollTop() >= vTop+200+380) {
								if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
									$('.review_container_actions .review_sidebar_banner').removeClass('sticky');
								} else {
									$('.review_container_actions .review_sidebar_banner').addClass('sticky');//console.log('heygo.js #1');
								}

							}
							else {
								if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
									$('.review_container_actions .review_sidebar_banner').removeClass('sticky');
								} else {
									$('.review_container_actions .review_sidebar_banner').removeClass('sticky');
								}
							}
						});
					}

				}
			} else if (goal === 'rating_1') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none' && data.length > 15) {
					$(".rating_table:nth-of-type(1) > div.main_row:nth-of-type(3)").after(data);
				}
			} else if (goal === 'rating_2') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none' && data.length > 15) {
					$(".rating_table:nth-of-type(1) > div.main_row:nth-of-type(13)").after(data);
				}
			} else if (goal === 'rating_3') {
				$('#hey_content_'+goal).remove();
				if(data !== 'none' && data.length > 15) {
					$(".rating_table:nth-of-type(1) > div.main_row:nth-of-type(25)").after(data);
				}
			} else if (goal === 'quizpost') {
					$('#hey_content_'+goal).remove();
					if(data !== 'none' && data.length > 15) {
						step1 = 0;
						first_step1 = 0;
						second_step1 = 0;

						$('.the_content').each(function(index) {

							$(this).addClass('add'+index);
						});

						$('.the_content.add0 p').each(function(index) {
							$(this).attr('index',index);

							if( (!($(this).hasClass('topreview'))) && (!($(this).prev().hasClass('topreview')))  && (!($(this).next().hasClass('topreview'))) && !($(this).next().hasClass('rll-youtube-player')) && (!($(this).prev().is('h2'))) ) {
								console.log(1);
								step1 = step1+1;
								$(this).attr('step1',step1);
								if(step1 == 5) {
									console.log(2);
									$(this).addClass('here3_1');
									$(this).addClass('here3_12');
								}

							}
						});

						step1 = 0;
						first_step1 = 0;
						second_step1 = 0;

						$('.the_content.add1 p').each(function(index) {
							$(this).attr('index',index);
							if( (!($(this).hasClass('topreview'))) && (!($(this).prev().hasClass('topreview')))  && (!($(this).next().hasClass('topreview'))) && !($(this).next().hasClass('rll-youtube-player')) && (!($(this).prev().is('h2'))) ) {
								console.log(1);
								step1 = step1+1;
								$(this).attr('step1',step1);
								if(step1 == 5) {
									console.log(2);
									$(this).addClass('here3_1');
									$(this).addClass('here3_13');
								}

							}
						});
						console.log(4);

						$(".the_content p.here3_1").prepend(data);

						$('.the_content').removeClass('add0');
						$('.the_content').removeClass('add1');
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
			//console.log('6) Вывод');
			if (my_ajax_object.current_post_id != '176586') {
				if(goal === 'popup') {
					if(data !== 'none' && data.length > 30) {
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
										//console.log('7) Вывод мауслив');
										//show_h_info(goal,object,post_id);
									}

								}
								popupCounter ++;
							}
						});
						if (goal == 'popup') {
							/*loadTime = window.performance.timing.domContentLoadedEventEnd- window.performance.timing.navigationStart;
							console.log(loadTime);
							if (loadTime >= 0) {
								st = 9000 - loadTime;
							} else {
								st = 0;
							}
							if (st < 0) {
								st = 0;
							}*/
							setTimeout(function() {
								if (document.cookie.indexOf(post_id+'_popup') != '-1') {
								} else {
									console.log('1) '+535353525+' '+goal+' '+object);
									//console.warn('pref4');
									show_h_info(goal,object,post_id);
								}
							}, 9000);
						} else {
							setTimeout(function() {
								if (document.cookie.indexOf(post_id+'_popup') != '-1') {
								} else {
									console.log('2) '+535353525+' '+goal+' '+object);
									////console.warm('pref5');
									show_h_info(goal,object,post_id);
								}
							}, 30000);
						}

					} else {
						//alert(data);
					}
				}
			}
		}
	});
}


function get_h_info(post_id,goal) {
	console.log(goal);
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=get_h_info&post_id="+post_id+"&goal="+goal,
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			console.log(data);
			data = JSON.parse(data);
			console.log(data);
			$.each(data, function(k, v) {
				if(goal === 'all') {
					if(k === 'popup') {
						//console.warn('pref9');
						hey_check_content(k,v,post_id);

					} else {
						console.log('3) '+'aaaa'+k+' '+v+' '+post_id);
						//console.warn('pref7');
						show_h_info(k,v,post_id);
					}
				} else {
					console.log('4) '+'aaaa'+k+' '+v+' '+post_id);
					//console.warn('pref8');
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
		clicked = 1;
		document.cookie = "popupmaincookie=1; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT";
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
		/*var b_p_id = banners_info.b_p_id;
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=banner_popup_ajax&post_id="+b_p_id,
			beforeSend: function(xhr) {

			},
			success: function( data ) {

				$('.popup_banners_get').html(data);
			}
		});*/
	var b_p_id = banners_info.b_p_id;
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=banner_popup_ajax&post_id="+b_p_id,
		beforeSend: function(xhr) {

		},
		success: function( data ) {

			$('.popup_bs_get').html(data);
		}
	});
});