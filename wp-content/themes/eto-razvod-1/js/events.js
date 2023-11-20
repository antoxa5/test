jQuery(document).ready(function($){

	$('.header_icon_nav').click(function() {
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=popup_nav&nav_place=header_main",
			beforeSend: function(xhr) {

			},
			success: function( data ) {
				$('body').append(data);

			}
		});
	});





	$('.reg_link').click(function() {
		reg_link();
	});

	$('.auth_button').click(function() {
		auth_link();
	});

	/*$('.comments_sorter li, .menu-take-comments-dashboard__item_comments').click(function() {
		var sort_type = $(this).attr('data-sort-type');
		if (typeof userid === 'undefined'){
			if ($(this).parent().parent().parent().parent().attr('id') == 'reviews_about') {
				ajax_comments_about(sort_type);
			} else {
				ajax_comments(sort_type);
			}
		} else {

			if (typeof company_page === 'undefined') {
				ajax_comments(sort_type,userid);
			} else {
				ajax_comments(sort_type);
			}
		}
	});*/
	$('.profile_sorter li').click(function() {
		var sort_type = $(this).attr('data-sort-type');
		if (typeof userid === 'undefined'){
			ajax_posts(sort_type);
		} else {
			ajax_posts(sort_type,userid);
		}
	});

	$('.comments_sorter_subs li').click(function() {
		var sort_type = $(this).attr('data-sort-type');

		ajax_subscribes_list(my_ajax_object.user_id, sort_type);

	});

	$('.abuses_sorter li, .menu-take-comments-dashboard__item_abuses').click(function() {
		var sort_type = $(this).attr('data-sort-type');
		if (typeof userid === 'undefined'){
			ajax_abuses(sort_type);
		} else {
			if (typeof company_page === 'undefined') {
				ajax_abuses(sort_type,userid);
			} else {
				ajax_abuses(sort_type);
			}

		}

	});
	/*$('.comments_sorter .comments_sorter_title').click(function() {
		$(this).parent().toggleClass('active');
	});*/

	$('.profile_sorter .profile_sorter_title').click(function() {
		$('.profile_sorter').toggleClass('active');
	});

	$('.comments_sorter_subs .comments_sorter_title').click(function() {
		$('.comments_sorter_subs').toggleClass('active');
	});

	$('.abuses_sorter .abuses_sorter_title').click(function() {
		$('.abuses_sorter').toggleClass('active');
	});

	/*$('.comment_total_rating').click(function() {
		var comment_body = $(this).closest('.comment-body').attr('data-body-id');
		$('.'+comment_body+' .comment_rating_details').toggleClass('visible');
	});*/

	$('body').on('click','.comment_total_rating',function (){
		var comment_body = $(this).closest('.comment-body').attr('data-body-id');
		$('.'+comment_body+' .comment_rating_details').toggleClass('visible');
	})



	$('.comment_more_actions').click(function() {
		var comment_id = $(this).closest('li').attr('data-commentid');
		//alert(comment_id);
		$('.comment_more_actions_links_'+comment_id).toggleClass('visible');
	});
	//$('ul#reviews').on('click', '.comment_reply_count', function(){

	$('.link_review_popup').click(function() {
		popup_form('review',my_ajax_object.current_post_id);
	});
	$('.link_abuse_popup').click(function() {
		popup_form('abuse',my_ajax_object.current_post_id);
	});
	$('body').on('click','.comment_reply_count',function (){
//$('.comment_reply_count').click(function() {
		console.log(222222);
		var comment_id = $(this).closest('li').attr('data-commentid');
		console.log(comment_id);
		//alert(comment_id);
		if (( (my_ajax_object.slug == "user_profile") || (my_ajax_object.slug == "comments") ) && ( !($(this).hasClass("ones")) ) ) {
			console.log(1222222);

			if ( (typeof userid !== 'undefined') || (typeof company_page !== 'undefined') ) {

				$(this).parent().parent().next('.children').remove();

				$(this).parent().parent().after('<ul class="children"></ul>');
				get_childs_ajax(0, comment_id);
				$(this).addClass('ones');
			}
		} else if (( $(this).parents('#abuses') ) && ( !($(this).hasClass("ones")) )) {
			console.log(3222222);
			//console.log(typeof userid);
			actual_link = my_ajax_object.actual_link

			if ( (typeof userid !== 'undefined') || (typeof company_page !== 'undefined') || (actual_link.includes('comment-') == true) ) {
				console.log(5222222);
				$(this).parent().parent().next('.children').remove();

				$(this).parent().parent().after('<ul class="children"></ul>');
				get_childs_ajax(0, comment_id);
				$(this).addClass('ones');
				//console.log(5222222);
			} else if ($(this).hasClass('comment_reply_count_get_abuse')) {
				console.log(4222222);
				$(this).parent().parent().next('.children').remove();

				$(this).parent().parent().after('<ul class="children"></ul>');
				get_childs_ajax(0, comment_id);
				$(this).addClass('ones');
				//console.log(6222222);
			}
		}
		$('#comment-'+comment_id+' ul.children, #ajax-comment-'+comment_id+' ul.children').toggleClass('visible');
		$('#comment-'+comment_id+' .comment_reply_count, #ajax-comment-'+comment_id+' .comment_reply_count').toggleClass('active');

	});

});

$('body').on('click','.comment_total_rating',function (e) {
	var comment_body = $(this).closest('.comment-body').attr('data-body-id');
	//console.log($(this).closest('.comment-body').parent().attr('class'));
	if ($(this).closest('.comment-body').parent().attr('class') === 'white_block li_statusbad') {
		console.log(3333311111);
	} else {
		$('.'+comment_body+' .comment_rating_details').toggleClass('visible');
	}

})

$('body').on('click','.comment_reply_count',function (){
//$('.comment_reply_count').click(function() {
	console.log(222222);
	var comment_id = $(this).closest('li').attr('data-commentid');
	console.log(comment_id);
	//alert(comment_id);
	if (( (my_ajax_object.slug == "user_profile") || (my_ajax_object.slug == "comments") ) && ( !($(this).hasClass("ones")) ) ) {
		//console.log(1222222);

		if ( (typeof userid !== 'undefined') || (typeof company_page !== 'undefined') ) {

			$(this).parent().parent().next('.children').remove();

			$(this).parent().parent().after('<ul class="children"></ul>');
			get_childs_ajax(0, comment_id);
			$(this).addClass('ones');
		}
	} else if (( $(this).parents('#abuses') ) && ( !($(this).hasClass("ones")) )) {
		//console.log(3222222);
		//console.log(typeof userid);
		actual_link = my_ajax_object.actual_link

		if ( (typeof userid !== 'undefined') || (typeof company_page !== 'undefined') || (actual_link.includes('comment-') == true) ) {

			$(this).parent().parent().next('.children').remove();

			$(this).parent().parent().after('<ul class="children"></ul>');
			get_childs_ajax(0, comment_id);
			$(this).addClass('ones');
			//console.log(5222222);
		} else if ($(this).hasClass('comment_reply_count_get_abuse')) {

			$(this).parent().parent().next('.children').remove();

			$(this).parent().parent().after('<ul class="children"></ul>');
			get_childs_ajax(0, comment_id);
			$(this).addClass('ones');
			//console.log(6222222);
		}
	}
	$('#comment-'+comment_id+' ul.children, #ajax-comment-'+comment_id+' ul.children').toggleClass('visible');
	$('#comment-'+comment_id+' .comment_reply_count, #ajax-comment-'+comment_id+' .comment_reply_count').toggleClass('active');

});