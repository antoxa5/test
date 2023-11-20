$ = jQuery.noConflict();








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





jQuery(document).ready(function($){
	var string = window.location.hash;
	var substring = 'comment';
	if(string == '#fullreview') {
		//alert(string);
	} else if (string == '#abuse') {
	} else if (string == '#similar') {
	} else if (string == '#about') {
		$('#reviewsummary').addClass('visible');
		$( "#company_in_ratings_widget" ).clone().insertAfter( ".review_container_about .container_side .subscribe_container" );
		$( ".review_container_content .the_content" ).clone().insertAfter( ".review_container_about .container_left #reviewsummary" );
		if ($('.get_b_table').length != 0) {
			if ($('.get_b_table').attr('data-id') != '') {
				$.ajax({
					url: my_ajax_object.ajax_url,
					type: "POST",
					data: "action=get_b_table_f&tag=" + $('.get_b_table').attr('data-id'),
					success: function (data) {
						$('#reviewsummary').after('<div class="bonus_b_t"></div>');
						$('.bonus_b_t').html(data);
					}
				});
			}
		}
		var container_class = 'review_container_about';
		$( ".review_container_about .the_content" ).addClass('white_block');
		$( ".review_container_about .the_content" ).css('padding','20px 25px');
		$( ".review_container_reviews .block_rating" ).clone().insertBefore( ".review_container_about .container_left #reviews" );
		$( ".review_container_about .the_content .list_more_container" ).remove();

		ajax_comments_about('new');
		console.log(444444);
		//ajax_append_address(my_ajax_object.current_post_id);
		list_more_ajax(my_ajax_object.current_post_id,container_class);
		//$(".review_container_about .review_sidebar_banner").empty();
		//$(".review_container_about .review_sidebar_banner").append(data);

		//33333
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




		$('.review_sidebar_banner').removeClass('sticky');////console.log('review_ajax_content.js #1');
		var $cache = $('.review_container_about .review_sidebar_banner');
		var vTop = $cache.offset().top;
		$(window).scroll(function(){
			//console.log('review_ajax_content.js #3');
			if ($(window).scrollTop() >= vTop+200+380) {
				if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 250) {
					$('.review_container_about .review_sidebar_banner').removeClass('sticky');//console.log('review_ajax_content.js #11');
				} else {
					$('.review_container_about .review_sidebar_banner').addClass('sticky');//console.log('review_ajax_content.js #2');
				}

			}
			else {
				if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 250) {
					$('.review_container_about .review_sidebar_banner').removeClass('sticky');//console.log('review_ajax_content.js #12');
				} else {
					$('.review_container_about .review_sidebar_banner').removeClass('sticky');////console.log('review_ajax_content.js #13');
				}
			}
		});

	} else if (string == '#comments') {

	} else if (string.indexOf(substring) !== -1) {
	} else if(string == '') {
		$('#reviewsummary').addClass('visible');
		$( "#company_in_ratings_widget" ).clone().insertAfter( ".review_container_about .container_side .subscribe_container" );
		$( ".review_container_content .the_content" ).clone().insertAfter( ".review_container_about .container_left #reviewsummary" );
		if ($('.get_b_table').length != 0) {
			if ($('.get_b_table').attr('data-id') != '') {
				$.ajax({
					url: my_ajax_object.ajax_url,
					type: "POST",
					data: "action=get_b_table_f&tag=" + $('.get_b_table').attr('data-id'),
					success: function (data) {
						$('#reviewsummary').after('<div class="bonus_b_t"></div>');
						$('.bonus_b_t').html(data);
					}
				});
			}
		}
		$( ".review_container_about .the_content" ).addClass('white_block');
		$( ".review_container_about .the_content" ).css('padding','20px 25px');
		$( ".review_container_reviews .block_rating" ).clone().insertBefore( ".review_container_about .container_left #reviews" );

		ajax_comments_about('new');
		$( ".review_container_about .the_content .list_more_container" ).remove();
		var container_class = 'review_container_about';
		console.log(33333333);
		//ajax_append_address(my_ajax_object.current_post_id);
		list_more_ajax(my_ajax_object.current_post_id,container_class);

		$('.review_sidebar_banner').removeClass('sticky');//console.log('review_ajax_content.js #4');
		var $cache = $('.review_container_about .review_sidebar_banner');
		var vTop = $cache.offset().top;
		$(window).scroll(function(){
			//console.log(133);
			if ($(window).scrollTop() >= vTop+200+380) {
				if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 250) {
					$('.review_container_about .review_sidebar_banner').removeClass('sticky');//console.log('review_ajax_content.js #5');
				} else {
					$('.review_container_about .review_sidebar_banner').addClass('sticky');//console.log('review_ajax_content.js #6');
				}

			}
			else {
				if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 250) {
					$('.review_container_about .review_sidebar_banner').removeClass('sticky');//console.log('review_ajax_content.js #7');
				} else {
					$('.review_container_about .review_sidebar_banner').removeClass('sticky');//console.log('review_ajax_content.js #8');
				}
			}
		});

		// $('.review_sidebar_banner').removeClass('sticky');
		// var $cache = $('.review_container_about .review_sidebar_banner');
		//
		// var vTop = $cache.offset().top;
		// var vBottom = $('.footer_top').offset().top;
		// $(window).scroll(function(){
		// 	//if ($(window).scrollTop() >= vTop+200+380 && $(window).scrollTop() <= vBottom) {
		// 	if ($(window).scrollTop() >= vTop+200+380) {
		// 		$('.review_container_about .review_sidebar_banner').addClass('sticky');
		// 	}
		// 	else {
		// 		$('.review_container_about .review_sidebar_banner').removeClass('sticky');
		// 	}
		// });
	} else {

	}

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
$('body').on('click', '.review_container_content .toc_list a[href="#comments"], .link_show_review_tab', function () {
	$('.review_links li').removeClass('active');
	$('.review_links li').removeClass('color_dark_blue');
	$('.page_container').removeClass('visible');
	var container_class = 'review_container_reviews';
	$('.'+container_class).addClass('visible');
	$('.review_links li.review_link_reviews').addClass('active');
	$('.review_links li.review_link_reviews').addClass('color_dark_blue');
	ajax_comments('new');
	$( "#myBtn" ).trigger( "click" );
	/*$('.review_sidebar_banner').removeClass('sticky');
		var $cache = $('.review_container_reviews .review_sidebar_banner');
		var vTop = $cache.offset().top;
		var vBottom = $('.footer_top').offset().top;
		$(window).scroll(function(){
			if ($(window).scrollTop() >= vTop+200+380) {
				$('.review_container_reviews .review_sidebar_banner').addClass('sticky');
			}
			else {
				$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');
			}
		});*/

	$('.review_sidebar_banner').removeClass('sticky');//console.log('review_ajax_content.js #9');
	var $cache = $('.review_container_reviews .review_sidebar_banner');
	var vTop = $cache.offset().top;
	$(window).scroll(function(){
		if ($(window).scrollTop() >= vTop+200+380) {
			if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 250) {
				$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');//console.log('review_ajax_content.js #10');
			} else {
				$('.review_container_reviews .review_sidebar_banner').addClass('sticky');//console.log('review_ajax_content.js #11');
			}

		}
		else {
			if ($(window).scrollTop() > $('body').outerHeight() - ($('.page_after_content').outerHeight() + $('.footer_top').outerHeight() + $('.footer').outerHeight()) - 250) {
				$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');//console.log('review_ajax_content.js #12');
			} else {
				$('.review_container_reviews .review_sidebar_banner').removeClass('sticky');//console.log('review_ajax_content.js #13');
			}
		}
	});
});
$('body').on('click', '.review_container_about .toc_list a[href="#comments"]', function (e) {
	e.preventDefault();
	$(window).scrollTop($('#reviews_about').offset().top);
});
$('body').on('click', '.link_show_content_tab', function () {
	$('.review_links li').removeClass('active');
	$('.review_links li').removeClass('color_dark_blue');
	$('.page_container').removeClass('visible');
	var container_class = 'review_container_content';
	$('.'+container_class).addClass('visible');
	$('.review_links li.review_link_fullreview').addClass('active');
	$('.review_links li.review_link_fullreview').addClass('color_dark_blue');
	list_more_ajax(my_ajax_object.current_post_id,container_class);
	$( "#myBtn" ).trigger( "click" );
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
	$(this).addClass('tabs_mobile_mover__item_active_1');
	console.log('222222222');
});