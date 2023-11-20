jQuery(document).ready(function($){
	
	$( ".review_top_rating_container .review_average_round" ).each(function() {
					
		var id = $(this).attr('id');
		var percent = $(this).attr('data-percent');
		append_circle_bar(id,percent);
	});
	
});