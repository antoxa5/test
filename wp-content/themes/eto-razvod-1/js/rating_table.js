$ = jQuery.noConflict();


function resort_table_load_more(tag,offset,post_id,per_page,total,ascdesc = 'DESC') {
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=resort_table_load_more&tag="+tag+"&offset="+offset+"&post_id="+post_id+"&per_page="+per_page+"&total="+total+"&ascdesc="+ascdesc,
			beforeSend: function(xhr) {
				
				$('.rating_container .wrap .line_show_more_rating_rows').removeClass('inactive');
				$('.rating_container .wrap .line_show_more_rating_rows').append('<div class="spinner spinner_white"></div>');
				$('.rating_container .wrap .line_show_more_rating_rows .spinner').show();
				
			},
			complete: function(){
				$('.rating_container .wrap .line_show_more_rating_rows .spinner').remove();
				$('.rating_container .wrap .line_show_more_rating_rows').addClass('inactive');
			},
			success: function( data ) {
				var new_offset = +offset + +per_page;
				if(new_offset >= total) {
					$('.rating_container .wrap .line_show_more_rating_rows').remove();
				} else {
					$('.rating_container .wrap .line_show_more_rating_rows').attr( 'data-offset', new_offset );
				}
				$('.rating_container .wrap .rating_table').append(data);
				
			}
		});
	}

function resort_table(field,tag,order) {
	const obj = {};
	$('#sa_rating_filter_form input:text[name^="filter_fields"]').each(function() {
		obj[$(this).attr('name')] = $(this).val();
	});
	$('#sa_rating_filter_form input:checkbox[name^="filter_fields"]').each(function() {
		if($(this).is(':checked')) {
			obj[$(this).attr('name')] = $(this).val();
		}

	});
	$('#sa_rating_filter_form input[type="number"]').each(function() {
		obj[$(this).attr('name')] = $(this).val();
	});
	const params_pass = $.param(obj);
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=resort_table&sort=1&field="+field+"&order="+order+"&tag="+tag+"&post_id="+my_ajax_object.current_post_id+"&"+params_pass,
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
				get_h_info(banners_info.b_p_id,'all');

				total = $('.page_content .white_block.rating_table > .rating_table_row').length;

				if ((order == 'ASC') && (field == 'number') && (total < 100)) {

					subTotal = total;
					$('.page_content .white_block.rating_table > .rating_table_row').each(function(index) {

						console.log(index+1 +' '+$(this).attr('data-row-id'));
						if (1 == parseInt($(this).attr('data-row-id'))) {
							$(this).find('.rating_field_number').text(total);
						} else {
							subTotal = --subTotal;
							$(this).find('.rating_field_number').text(subTotal);
						}
					});
					console.log(total);
				}
				subTotal_second = parseInt($('.count_rating').text());
				if ((order == 'ASC') && (field == 'number') && (subTotal_second >= 100)) {


					subTotal_temp = subTotal_second;
					$('.page_content .white_block.rating_table > .rating_table_row').each(function(index) {

						$(this).find('.rating_field_number').text(subTotal_temp);
						subTotal_temp = --subTotal_temp;
					});
					console.log(total);
				}

				if (tag == 'courses') {
					if (field == 'number') {
						$('.dropdowncourse').each(function(index){

							if (!$(this).parent().parent().hasClass('setdnblockmofieid4')) {
								if (i != 0){
									//$('.syuda').text(i);
									$('.syuda').removeClass('syuda');
								}
								if (index != 0 && i == 0) {
									$('.syuda').remove();
									$('.syuda').removeClass('syuda');

									$(this).addClass('syuda');
								} else {

									$('.syuda').removeClass('syuda');
									$(this).addClass('syuda');
									i = 0;
								}


							} else {
								$(this).remove();
								i = i+1;
								//declOfNum1 = declOfNum(i, ['курс', 'курса', 'курсов']);
								//$('.syuda').text('Ещё '+i+' '+declOfNum1);

							}
						});
					} else {
						$('.dropdowncourse').remove();
					}

					/*$('.dropdowncourse').each(function(index){

						if ($(this).is(":visible")) {
							if (i != 0){
								//$('.syuda').text(i);
								$('.syuda').removeClass('syuda');
							}
							if (index != 0 && i == 0) {
								$('.syuda').remove();
								$('.syuda').removeClass('syuda');

								$(this).addClass('syuda');
							} else {

								$('.syuda').removeClass('syuda');
								$(this).addClass('syuda');
								i = 0;
							}


						} else {
							i = i+1;
							declOfNum1 = declOfNum(i, ['курс', 'курса', 'курсов']);
							$('.syuda').text('Ещё '+i+' '+declOfNum1);

						}
					});*/
				}
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
	order_global = 'DESC';

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
	$('body').on('click', '.line_show_more_rating_rows.inactive', function(){
		var tag = $(this).attr('data-tag');
		var offset = $(this).attr('data-offset');
		var post_id = $(this).attr('data-post-id');
		var total = $(this).attr('data-total');
		var per_page = $(this).attr('data-per-page');
		var ascdesc = 'ASC';

		console.log(''+tag+','+''+offset+','+''+post_id+','+''+total+','+''+per_page);//resort_table_load_more('shop',100,59679,1056,100);
		resort_table_load_more(tag,offset,post_id,per_page,total,order_global);
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
		order_global = 'ASC';
		//alert(tag);
		resort_table(field,tag,order);

	});
	$('.rating_header').on('click', '.sort_ASC', function(){
		var field = $(this).attr('data-rating-field');
		var tag = $(this).closest('.rating_header').attr('data-tag');
		var order = 'DESC';
		order_global = 'DESC';
		resort_table(field,tag,order);
	});
});

