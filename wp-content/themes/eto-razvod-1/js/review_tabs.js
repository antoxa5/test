$ = jQuery.noConflict();

jQuery(document).ready(function($){

	$('body').on('click','.reviews_count_reviews .link_dashed',function() {
		link = my_ajax_object.actual_link;
		if (link.indexOf("/comment-") >= 0) {
			window.location.href = review_page.permalink_comments;
		} else if (link.indexOf("/news/") >= 0) {
			window.location.href = window.location.href.replace("news/", "")+'#comments';
		} else {
			//alert('reviews');
			$('.review_links li').removeClass('active');
			$('.review_links li.review_link_reviews').addClass('active');
			$('.page_container').removeClass('visible');
			$('.review_container_reviews').addClass('visible');
			$('.comment_reply_count').addClass('active');
			$('.children').addClass('visible');
			if (my_ajax_object.post_type != 'casino') {
				ajax_comments('new');
			}/*  else if ($('html').attr('lang') != 'ru-RU' && my_ajax_object.post_type == 'casino') {
				ajax_comments('new');
			}*/
			/*$('.review_sidebar_banner').removeClass('sticky');
            var $cache = $('.review_container_reviews .review_sidebar_banner');
            var vTop = $cache.offset().top;
            var vBottom = $('.footer_top').offset().top;
            $(window).scroll(function(){
                if ($(window).scrollTop() >= vTop+200+380) {
                    $('.review_container_reviews .review_sidebar_banner').addClass('sticky');console.log('review_tabs.js #6');
                }
                else {
                    $('.review_container_reviews .review_sidebar_banner').removeClass('sticky');
                }
            });*/

			$('.review_sidebar_banner').removeClass('sticky');
			var $cache = $('.review_container_reviews .review_sidebar_banner');
			var vTop = $cache.offset().top;
			$(window).scroll(function(){
				if ($(window).scrollTop() >= vTop+200+380) {
					console.log('review_tabs.js #1');
					if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
						$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');
					} else {
						$('.review_container_reviews .review_sidebar_banner').addClass('sticky');console.log('review_tabs.js #7');
					}

				}
				else {
					console.log('review_tabs.js #2');
					if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
						$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');
					} else {
						$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');
					}
				}
			});
		}
	});
	$('body').on('click','.reviews_count_abuses .link_dashed',function() {
		if (link.indexOf("/comment-") >= 0) {
			window.location.href = review_page.permalink_abuses;
		} else if (link.indexOf("/news/") >= 0) {

			window.location.href = window.location.href.replace("news/", "")+'#abuses';
		} else {
			//alert('reviews');
			$('.review_links li').removeClass('active');
			$('.review_links li.review_link_abuses').addClass('active');
			$('.page_container').removeClass('visible');
			$('.review_container_abuses').addClass('visible');
			ajax_abuses('new');
			list_more_ajax(my_ajax_object.current_post_id,'review_container_abuses');
			$('.review_sidebar_banner').removeClass('sticky');
			/*var $cache = $('.review_container_abuses .review_sidebar_banner');
            var vTop = $cache.offset().top;
            $(window).scroll(function(){
                if ($(window).scrollTop() >= vTop+200+380) {
                    $('.review_container_abuses .review_sidebar_banner').addClass('sticky');
                }
                else {
                    $('.review_container_abuses .review_sidebar_banner').removeClass('sticky');
                }
            });*/
		}
	});
	$('.review_links').on('click','li',function() {
		var container_class = $(this).attr('data-tab');
		if ($('.active_fixed_page__single_comments').length == 0) {
			if(container_class === 'review_container_about') {
				if (typeof userid === 'undefined') {
					$('#reviewsummary').addClass('visible');
					//ajax_append_address(my_ajax_object.current_post_id);
					list_more_ajax(my_ajax_object.current_post_id,container_class);
				} else {
					get_feed_user_profile('new',userid,0,0,0,0,0,'normal');
				}
			}
			if(container_class !== 'review_container_actions do_not_translate_css_class') {
				$('.review_links li').removeClass('active');
				$('.review_links li').removeClass('color_dark_blue');
				$('.page_container').removeClass('visible');

				$('.'+container_class).addClass('visible');
				$(this).addClass('active');
				$(this).addClass('color_dark_blue');
				//$('.review_links li.review_link_reviews').removeClass('active');
				if (typeof userid === 'undefined') {
					if(container_class == 'review_container_reviews') {
						if (link.indexOf("/news/") >= 0) {
							window.location.href = window.location.href.replace("news/", "")+'#comments';

						} else {
							$('.comment_reply_count').addClass('active');
							$('.children').addClass('visible');
							if (my_ajax_object.post_type != 'casino') {
								ajax_comments('new');
							}/*  else if ($('html').attr('lang') != 'ru-RU' && my_ajax_object.post_type == 'casino') {
							ajax_comments('new');
						}*/
							/*$('.review_sidebar_banner').removeClass('sticky');
							var $cache = $('.review_container_reviews .review_sidebar_banner');
							var vTop = $cache.offset().top;
							var vBottom = $('.footer_top').offset().top;
							$(window).scroll(function(){
							if ($(window).scrollTop() >= vTop+200+380) {
									$('.review_container_reviews .review_sidebar_banner').addClass('sticky');console.log('review_tabs.js #4');
								}
								else {
									$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');
								}
							});*/

							$('.review_sidebar_banner').removeClass('sticky');
							var $cache = $('.review_container_reviews .review_sidebar_banner');
							var vTop = $cache.offset().top;
							$(window).scroll(function(){
								if ($(window).scrollTop() >= vTop+200+380) {
									if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
										$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');
									} else {
										$('.review_container_reviews .review_sidebar_banner').addClass('sticky');console.log('review_tabs.js #5');
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
						}

					} else if(container_class == 'review_container_about') {
						list_more_ajax(my_ajax_object.current_post_id,container_class);
						//ajax_append_address(my_ajax_object.current_post_id);

						/*$('.review_sidebar_banner').removeClass('sticky');
                        var $cache = $('.review_container_about .review_sidebar_banner');
                        var vTop = $cache.offset().top;
                        var vBottom = $('.footer_top').offset().top;
                        $(window).scroll(function(){
                            if ($(window).scrollTop() >= vTop+200+380) {
                                $('.review_container_about .review_sidebar_banner').addClass('sticky');
                            }
                            else {
                                $('.review_container_about .review_sidebar_banner').removeClass('sticky');
                            }
                        });*/

						$('.review_sidebar_banner').removeClass('sticky');
						var $cache = $('.review_container_about .review_sidebar_banner');
						var vTop = $cache.offset().top;
						$(window).scroll(function(){
							if ($(window).scrollTop() >= vTop+200+380) {
								if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
									$('.review_container_about .review_sidebar_banner').removeClass('sticky');
								} else {
									$('.review_container_about .review_sidebar_banner').addClass('sticky');
								}

							}
							else {
								if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
									$('.review_container_about .review_sidebar_banner').removeClass('sticky');
								} else {
									$('.review_container_about .review_sidebar_banner').removeClass('sticky');
								}
							}
						});

					} else if(container_class == 'review_container_content') {
						list_more_ajax(my_ajax_object.current_post_id,container_class);
					} else if(container_class == 'review_container_abuses') {
						if (link.indexOf("/news/") >= 0) {
							window.location.href = window.location.href.replace("news/", "")+'#abuses';
						} else {
							ajax_abuses('new');
							list_more_ajax(my_ajax_object.current_post_id,container_class);
							$('.review_sidebar_banner').removeClass('sticky');
						}

						/*var $cache = $('.review_container_abuses .review_sidebar_banner');
                        var vTop = $cache.offset().top;
                        $(window).scroll(function(){
                            if ($(window).scrollTop() >= vTop+200+380) {
                                $('.review_container_abuses .review_sidebar_banner').addClass('sticky');
                            }
                            else {
                                $('.review_container_abuses .review_sidebar_banner').removeClass('sticky');
                            }
                        });*/
					} else if(container_class == 'review_container_similar') {
						ajax_similar_companies(my_ajax_object.current_post_id);
						list_more_ajax(my_ajax_object.current_post_id,container_class);

						/*$('.review_sidebar_banner').removeClass('sticky');
                        var $cache = $('.review_container_similar .review_sidebar_banner');
                        var vTop = $cache.offset().top;
                        var vBottom = $('.footer_top').offset().top;
                        $(window).scroll(function(){
                            if ($(window).scrollTop() >= vTop+200+380) {
                                $('.review_container_similar .review_sidebar_banner').addClass('sticky');
                            }
                            else {
                                $('.review_container_similar .review_sidebar_banner').removeClass('sticky');
                            }
                        });*/


						$('.review_sidebar_banner').removeClass('sticky');
						var $cache = $('.review_container_similar .review_sidebar_banner');
						var vTop = $cache.offset().top;
						$(window).scroll(function(){
							if ($(window).scrollTop() >= vTop+200+380) {
								if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
									$('.review_container_similar .review_sidebar_banner').removeClass('sticky');
								} else {
									$('.review_container_similar .review_sidebar_banner').addClass('sticky');
								}

							}
							else {
								if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
									$('.review_container_similar .review_sidebar_banner').removeClass('sticky');
								} else {
									$('.review_container_similar .review_sidebar_banner').removeClass('sticky');
								}
							}
						});
					}
				}


				if (container_class == 'review_container_abuses_profile') {
					ajax_abuses('user',userid);
				}

				if (container_class == 'review_container_comments_profile') {
					ajax_comments('new',userid);
				}

				if (container_class == 'review_container_reviews_profile') {
					ajax_posts('new',userid);
				}
			}
		}

	});
});


$('body').on('click','.fixed_header_review__inside .review_links li',function(event) {
	//event.preventDefault();
	var container_class = $(this).attr('data-tab');
	if ($('.active_fixed_page__single_comments').length == 0) {
		if(container_class === 'review_container_about') {
			if (typeof userid === 'undefined') {
				$('#reviewsummary').addClass('visible');
				//ajax_append_address(my_ajax_object.current_post_id);
				list_more_ajax(my_ajax_object.current_post_id,container_class);
			} else {
				get_feed_user_profile('new',userid,0,0,0,0,0,'normal');
			}
		}
		if(container_class !== 'review_container_actions do_not_translate_css_class') {
			$('.review_links li').removeClass('active');
			$('.review_links li').removeClass('color_dark_blue');
			$('.page_container').removeClass('visible');

			$('.'+container_class).addClass('visible');
			$(this).addClass('active');
			$(this).addClass('color_dark_blue');
			//$('.review_links li.review_link_reviews').removeClass('active');
			if (typeof userid === 'undefined') {
				if(container_class == 'review_container_reviews') {
					if (link.indexOf("/news/") >= 0) {
						window.location.href = window.location.href.replace("news/", "")+'#comments';

					} else {
						if (my_ajax_object.post_type != 'casino') {
							ajax_comments('new');
						}/*  else if ($('html').attr('lang') != 'ru-RU' && my_ajax_object.post_type == 'casino') {
						ajax_comments('new');
					}*/
						/*$('.review_sidebar_banner').removeClass('sticky');
						var $cache = $('.review_container_reviews .review_sidebar_banner');
						var vTop = $cache.offset().top;
						var vBottom = $('.footer_top').offset().top;
						$(window).scroll(function(){
						if ($(window).scrollTop() >= vTop+200+380) {
								$('.review_container_reviews .review_sidebar_banner').addClass('sticky');console.log('review_tabs.js #4');
							}
							else {
								$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');
							}
						});*/
						$('.comment_reply_count').addClass('active');
						$('.children').addClass('visible');
						$('.review_sidebar_banner').removeClass('sticky');
						var $cache = $('.review_container_reviews .review_sidebar_banner');
						var vTop = $cache.offset().top;
						$(window).scroll(function(){
							if ($(window).scrollTop() >= vTop+200+380) {
								if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
									$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');
								} else {
									$('.review_container_reviews .review_sidebar_banner').addClass('sticky');console.log('review_tabs.js #5');
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
					}

				} else if(container_class == 'review_container_about') {
					list_more_ajax(my_ajax_object.current_post_id,container_class);
					//ajax_append_address(my_ajax_object.current_post_id);

					/*$('.review_sidebar_banner').removeClass('sticky');
                    var $cache = $('.review_container_about .review_sidebar_banner');
                    var vTop = $cache.offset().top;
                    var vBottom = $('.footer_top').offset().top;
                    $(window).scroll(function(){
                        if ($(window).scrollTop() >= vTop+200+380) {
                            $('.review_container_about .review_sidebar_banner').addClass('sticky');
                        }
                        else {
                            $('.review_container_about .review_sidebar_banner').removeClass('sticky');
                        }
                    });*/

					$('.review_sidebar_banner').removeClass('sticky');
					var $cache = $('.review_container_about .review_sidebar_banner');
					var vTop = $cache.offset().top;
					$(window).scroll(function(){
						if ($(window).scrollTop() >= vTop+200+380) {
							if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
								$('.review_container_about .review_sidebar_banner').removeClass('sticky');
							} else {
								$('.review_container_about .review_sidebar_banner').addClass('sticky');
							}

						}
						else {
							if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
								$('.review_container_about .review_sidebar_banner').removeClass('sticky');
							} else {
								$('.review_container_about .review_sidebar_banner').removeClass('sticky');
							}
						}
					});

				} else if(container_class == 'review_container_content') {
					list_more_ajax(my_ajax_object.current_post_id,container_class);
				} else if(container_class == 'review_container_abuses') {
					if (link.indexOf("/news/") >= 0) {
						window.location.href = window.location.href.replace("news/", "")+'#abuses';

					} else {
						ajax_abuses('new');
						list_more_ajax(my_ajax_object.current_post_id,container_class);
						$('.review_sidebar_banner').removeClass('sticky');
						/*var $cache = $('.review_container_abuses .review_sidebar_banner');
						var vTop = $cache.offset().top;
						$(window).scroll(function(){
							if ($(window).scrollTop() >= vTop+200+380) {
								$('.review_container_abuses .review_sidebar_banner').addClass('sticky');
							}
							else {
								$('.review_container_abuses .review_sidebar_banner').removeClass('sticky');
							}
						});*/
					}

				} else if(container_class == 'review_container_similar') {
					ajax_similar_companies(my_ajax_object.current_post_id);
					list_more_ajax(my_ajax_object.current_post_id,container_class);

					/*$('.review_sidebar_banner').removeClass('sticky');
                    var $cache = $('.review_container_similar .review_sidebar_banner');
                    var vTop = $cache.offset().top;
                    var vBottom = $('.footer_top').offset().top;
                    $(window).scroll(function(){
                        if ($(window).scrollTop() >= vTop+200+380) {
                            $('.review_container_similar .review_sidebar_banner').addClass('sticky');
                        }
                        else {
                            $('.review_container_similar .review_sidebar_banner').removeClass('sticky');
                        }
                    });*/


					$('.review_sidebar_banner').removeClass('sticky');
					var $cache = $('.review_container_similar .review_sidebar_banner');
					var vTop = $cache.offset().top;
					$(window).scroll(function(){
						if ($(window).scrollTop() >= vTop+200+380) {
							if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
								$('.review_container_similar .review_sidebar_banner').removeClass('sticky');
							} else {
								$('.review_container_similar .review_sidebar_banner').addClass('sticky');
							}

						}
						else {
							if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 650) {
								$('.review_container_similar .review_sidebar_banner').removeClass('sticky');
							} else {
								$('.review_container_similar .review_sidebar_banner').removeClass('sticky');
							}
						}
					});
				}
			}


			if (container_class == 'review_container_abuses_profile') {
				ajax_abuses('user',userid);
			}

			if (container_class == 'review_container_comments_profile') {

					ajax_comments('new', userid);

			}

			if (container_class == 'review_container_reviews_profile') {
				ajax_posts('new',userid);
			}
		}
	}
	//return false;
	$('.review_bar .review_links li').removeClass('active');
	$('.review_bar .review_links li').removeClass('color_dark_blue');
	$('.review_bar .review_links li[data-tab="'+$(this).attr('data-tab')+'"]').addClass('active');
	$('.review_bar .review_links li[data-tab="'+$(this).attr('data-tab')+'"]').addClass('color_dark_blue');


});