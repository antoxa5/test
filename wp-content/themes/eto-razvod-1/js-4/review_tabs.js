$ = jQuery.noConflict();

jQuery(document).ready(function($){

	$('body').on('click','.reviews_count_reviews .link_dashed',function() {
		//alert('reviews');
		$('.review_links li').removeClass('active');
		$('.review_links li.review_link_reviews').addClass('active');
		$('.page_container').removeClass('visible');
		$('.review_container_reviews').addClass('visible');
		ajax_comments('new');
	});
	$('body').on('click','.reviews_count_abuses .link_dashed',function() {
		//alert('reviews');
		$('.review_links li').removeClass('active');
		$('.review_links li.review_link_abuses').addClass('active');
		$('.page_container').removeClass('visible');
		$('.review_container_abuses').addClass('visible');
		ajax_abuses('new');
		list_more_ajax(my_ajax_object.current_post_id,'review_container_abuses');
	});
	$('.review_links').on('click','li',function() {
		var container_class = $(this).attr('data-tab');
		if(container_class !== 'review_container_actions') {
			$('.review_links li').removeClass('active');
			$('.review_links li').removeClass('color_dark_blue');
			$('.page_container').removeClass('visible');

			$('.'+container_class).addClass('visible');
			$(this).addClass('active');
			$(this).addClass('color_dark_blue');
			//$('.review_links li.review_link_reviews').removeClass('active');
			if(container_class == 'review_container_reviews') {
				ajax_comments('new');
			} else if(container_class == 'review_container_about') {
				list_more_ajax(my_ajax_object.current_post_id,container_class);
			} else if(container_class == 'review_container_content') {
				list_more_ajax(my_ajax_object.current_post_id,container_class);
			} else if(container_class == 'review_container_abuses') {
				ajax_abuses('new');
				list_more_ajax(my_ajax_object.current_post_id,container_class);
			} else if(container_class == 'review_container_similar') {
				ajax_similar_companies(my_ajax_object.current_post_id);
				list_more_ajax(my_ajax_object.current_post_id,container_class);
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
	});
});