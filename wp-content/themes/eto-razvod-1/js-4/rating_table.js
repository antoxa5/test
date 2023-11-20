$ = jQuery.noConflict();

function resort_table(field,tag,order) {
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=resort_table&sort=1&field="+field+"&order="+order+"&tag="+tag,
			beforeSend: function(xhr) {
				$('.rating_container .wrap').empty();
				$('.rating_container .wrap').append('<div class="load_ajax"></div>');
				$('.rating_header .rating_field_'+field).removeClass('sort_default');
				$('.rating_header .rating_th').removeClass('ASC DESC');
				$('.rating_header .rating_field_'+field).addClass(order);
				$('.rating_header .rating_field_'+field).addClass('sort_'+order);
				if(order === 'DESC') {
					$('.rating_header .rating_field_'+field).removeClass('sort_ASC');
				} else if(order === 'ASC') {
					$('.rating_header .rating_field_'+field).removeClass('sort_DESC');
				}
				
			},
			complete: function(){
				$(".rating_container .wrap .load_ajax").remove();
			},
			success: function( data ) {
				$('.rating_container .wrap').empty();
				$('.rating_container .wrap').append(data);
				
			}
		});
	}

function filter_table(tag,fields) {
	alert(tag);
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=filter_table&tag="+tag+"&fields="+fields,
			beforeSend: function(xhr) {
				$('.rating_container .wrap').empty();
				$('.rating_container .wrap').append('<div class="load_ajax"></div>');
				
			},
			complete: function(){
				$(".rating_container .wrap .load_ajax").remove();
			},
			success: function( data ) {
				$('.rating_container .wrap').empty();
				$('.rating_container .wrap').append(data);
				
			}
		});
	}


jQuery(document).ready(function($){
	
	$( ".review_average_round" ).each(function() {
					
					var id = $(this).attr('id');
					var percent = $(this).attr('data-percent');
					append_circle_bar(id,percent);
				});
	
	$('body').on('click', '.rating_table_link_more', function(){
		var row_id = $(this).closest('.main_row').attr('id');
		$('#'+row_id).toggleClass('show_more box_shadow');
		$(this).toggleClass('active');
	});
	$('body').on('submit', '#main_filter', function(e){
		e.preventDefault();
		var fields = $( this ).serialize();
		arr = [];
		$('#main_filter input, #main_filter select').each(function() {
		thisitem1 = $(this).attr('name');
		thisitem2 = $(this).val();
		thisitem3 = $(this).attr('type');
		   arr.push([thisitem1,thisitem2,thisitem3]);
		})
		alert(JSON.stringify(arr));
		filter_table('fx',JSON.stringify(arr));
	});
	$('.rating_header').on('click', '.sort_default, .sort_DESC', function(){
		
		var field = $(this).attr('data-rating-field');
		var tag = $(this).closest('.rating_header').attr('data-tag');
		var order = 'ASC';
		//alert(tag);
		resort_table(field,tag,order);
	});
	$('.rating_header').on('click', '.sort_ASC', function(){
		var field = $(this).attr('data-rating-field');
		var tag = $(this).closest('.rating_header').attr('data-tag');
		var order = 'DESC';
		resort_table(field,tag,order);
	});
});