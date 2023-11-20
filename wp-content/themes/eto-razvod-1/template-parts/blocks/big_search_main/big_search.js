$ = jQuery.noConflict();


function load_more_search(offset,phrase,tag,container,block_id,per_page,total) {
	//alert('offset ' + offset + ' phrase ' + phrase + ' container ' + container + ' tag' + tag  + ' block_id ' + block_id + ' per_page ' + per_page + ' total '+total);
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: 'POST',
		data: "action=load_more_search&offset="+offset+"&phrase="+phrase+"&tag="+tag,
		beforeSend: function(xhr) {
			$('#'+block_id+' .line_show_more_search').removeClass('inactive');
			$('#'+block_id+' .line_show_more_search').append('<div class="spinner spinner_white"></div>');
			$('#'+block_id+' .line_show_more_search .spinner').show();

		},
		complete: function(){
			$('#'+block_id+' .line_show_more_search .spinner').remove();
			$('#'+block_id+' .line_show_more_search').addClass('inactive');
		},
		success: function( data ) {
			var new_offset = +offset + +per_page;
			$('#'+block_id+' '+container).append(data);
			if(new_offset >= total) {
				$('#'+block_id+' .line_show_more_search').remove();
			} else {
				$('#'+block_id+' .line_show_more_search').attr( 'data-offset', new_offset );
			}
			$( ".review_average_round" ).each(function() {
				var id = $(this).attr('id');
				var percent = $(this).attr('data-percent');
				append_circle_bar(id,percent);
			});
			
		}
	});
}




function big_search_load_cats(block_id,tag,type) {
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=big_search_load_cats&tag="+tag+"&type="+type,
        beforeSend: function(xhr) {
			$('#'+block_id+' .selector li.link_dropdown').append('<div class="spinner spinner_blue"></div>');
        },
		
        success: function( data ) {
			$('#'+block_id+' .selector li .spinner').remove();
			$('#' + block_id + ' .selector .big_search_load_cats').remove();
			$('#' + block_id + ' .selector').append(data);
			$('#' + block_id + ' .selector').removeClass('inactive');
			$('#' + block_id + ' .selector').addClass('active');

        }
    });
};

function show_more_filter(tag,block_id) {
    alert(tag);
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=show_more_filter&tag="+tag,
        beforeSend: function(xhr) {

        },
        success: function( data ) {
           alert(data);
           $('#'+block_id+' .search_box').append(data);

        }
    });
};

var xhrCount = 0;
function big_search_results(phrase,block_id,tag,type) {
    //alert(block_id);
    var seqNumber = ++xhrCount;
    	var jqXHR;
        jqXHR = $.ajax({
            url: my_ajax_object.ajax_url,
            type: "POST",
            data: "action=big_search_results&phrase=" + phrase+"&tag="+tag+"&type="+type,
            beforeSend: function (xhr) {
				if (seqNumber !== xhrCount) {
						
                        jqXHR.abort();
                    } else {
                $('#' + block_id + ' .big_search_results').empty();
                $('#' + block_id + ' .big_search_results').append('<div class="load_ajax"></div>');
					}
            },
            complete: function () {
                
            },
            success: function (data) {
				if (seqNumber === xhrCount) {
					$('#' + block_id + ' .big_search_results .load_ajax').remove();
                // alert(data);
                // $('#'+block_id+' form').addClass('not_typing');
					$('#' + block_id + ' .big_search_results').empty();
					$('#' + block_id + ' .big_search_results').append(data);
						$('#'+block_id+' .big_search_results .review_average_round' ).each(function() {
						var id = $(this).attr('id');
						var percent = $(this).attr('data-percent');
						append_circle_bar(id,percent);
					});
					
				}		
            }
        });
    
};
jQuery(document).ready(function($){
    $('body').on('click','.promocodes_big .search_box ul.tags li, .big_search_load_cats ul li',function() {
        var block_id = $(this).closest('.search_big').attr('id');
        var term_id = $(this).attr('data-term-id');
		var slug = $(this).attr('data-slug');
		var link = $(this).attr('data-link');
        var text = $(this).text();
		$('#'+block_id+' .selector .big_search_load_cats').remove();
        $('#'+block_id+' .selector li').remove();
        $('#'+block_id+' .selector').append('<li class="active link_dropdown pointer" data-category="'+term_id+'" data-slug="'+slug+'" data-link="'+link+'">'+text+'</li>');

		$('#' + block_id + ' .selector').removeClass('active');
			$('#' + block_id + ' .selector').addClass('inactive');
    });
    $('body').on('click','.link_search_more',function() {
        var block_id = $(this).closest('.search_big').attr('id');
        var tag = $('#'+block_id+' ul.selector li').attr('data-category');
        $('#'+block_id+' .filter_tags').remove();
        show_more_filter(tag,block_id);
    });
	$('body').on('focus','.search_box .form_container .not_typing input',function() {
		var block_id = $(this).closest('.search_big').attr('id');
		$('#' + block_id + ' .placeholder_text').hide();
		$('#'+block_id+' .big_search_icon_clear').show();
    });
	$('body').on('click','.search_box .form_container .not_typing .placeholder_text .example_placeholder',function() {
		var block_id = $(this).closest('.search_big').attr('id');
		$('#' + block_id + ' .placeholder_text').hide();
		$('#' + block_id + ' input').focus();
		$('#'+block_id+' .big_search_icon_clear').show();
    });
	$('body').on('click','.search_box .form_container .big_search_icon_clear',function() {
		var block_id = $(this).closest('.search_big').attr('id');
		$('#'+block_id+' .big_search_icon_clear').hide();
		$('#' + block_id + ' .placeholder_text').show();
		$('#' + block_id + ' input').val('');
    });
	$('body').on('click','.search_box .form_container .selector.inactive li.link_dropdown',function() {
		var block_id = $(this).closest('.search_big').attr('id');
		var search_type = $(this).closest('.search_big').attr('data-type');
		var tag = $(this).attr('data-category');
		big_search_load_cats(block_id,tag,search_type);
		$(this).closest('.selector').removeClass('inactive');
		$(this).closest('.selector').addClass('active');
    });
	$('body').on('click','.search_box .form_container .selector.active li.link_dropdown',function() {
		var block_id = $(this).closest('.search_big').attr('id');
		$(this).closest('.selector').removeClass('active');
		$(this).closest('.selector').addClass('inactive');
		$('#'+block_id+' .big_search_load_cats').remove();
    });
	$('body').on('input','.search_box .form_container .not_typing input',function() {

		var phrase = $(this).val();
		var block_id = $(this).closest('.search_big').attr('id');
		var search_type = $(this).closest('.search_big').attr('data-type');
		var tag = $('#'+block_id+' ul.selector li').attr('data-category');
		$('#'+block_id+' .big_search_icon_clear').show();
		if((phrase.length > 1)){

			//$(this).closest('form').removeClass('not_typing');
       // big_search_results(phrase,block_id,tag,search_type);
			$('#' + block_id + ' .selector .big_search_load_cats').remove();
			$('#' + block_id + ' .selector').removeClass('active');
			$('#' + block_id + ' .selector').addClass('inactive');
		} else {
			$('#' + block_id + ' .big_search_results').empty();
		}
    });
	$('body').on('click','.search_box .form_container .not_typing .search_example_text',function() {
		var block_id = $(this).closest('.search_big').attr('id');
		var search_type = $(this).closest('.search_big').attr('data-type');
		var text = $(this).text();
		var tag = $('#'+block_id+' ul.selector li').attr('data-category');
		$('#'+block_id+' .big_search_icon_clear').show();
		$('#' + block_id + ' .placeholder_text').hide();
		//alert(text);
		$('#' + block_id + ' input').val(text);
		big_search_results(text,block_id,tag,search_type);
		$('#' + block_id + ' .selector .big_search_load_cats').remove();
		$('#' + block_id + ' .selector').removeClass('active');
			$('#' + block_id + ' .selector').addClass('inactive');
    });
    $('body').on('submit','.search_box form',function(e) {
        e.preventDefault();
		
		var block_id = $(this).closest('.search_big').attr('id');
		var search_type = $(this).closest('.search_big').attr('data-type');
		var tag = $('#'+block_id+' ul.selector li').attr('data-category');
		var phrase = $('#'+block_id+' input').val();

			//$(this).closest('form').removeClass('not_typing');
        
		if(tag !== 'all') {
			//alert(tag);
			var slug = $('#'+block_id+' ul.selector li').attr('data-slug');
			var link = $('#'+block_id+' ul.selector li').attr('data-link');
			if((phrase.length < 1)){
			if(search_type === 'promocodes_big') {
				window.location.href = my_ajax_object_new.er_blog_url+'/promocode/'+slug+'/';
			} else {
				window.location.href = link;
			}
			
			} else {
				if(search_type === 'promocodes_big') {
					window.location.href = my_ajax_object_new.er_blog_url+'/promocode/'+slug+'/?q='+phrase;
				} else {
					window.location.href = my_ajax_object_new.er_blog_url+'/search/'+slug+'/?q='+phrase;
				}
				
			}
			//big_search_results(phrase,block_id,tag,search_type);
			$('#' + block_id + ' .selector .big_search_load_cats').remove();
			$('#' + block_id + ' .selector').removeClass('active');
			$('#' + block_id + ' .selector').addClass('inactive');
		} else {
			if((phrase.length < 1)){
				
				if(search_type === 'promocodes_big') {
					window.location.href = my_ajax_object_new.er_blog_url+'/promocode/?q='+phrase;
				} else {
					window.location.href = my_ajax_object_new.er_blog_url+'/search/?q='+phrase;
				}
        		//big_search_results(phrase,block_id,tag,search_type);
				$('#' + block_id + ' .selector .big_search_load_cats').remove();
				$('#' + block_id + ' .selector').removeClass('active');
			$('#' + block_id + ' .selector').addClass('inactive');
			} 
		}
       // alert('ll');
    });
	$('body').on('click','.search_box form .big_search_icon',function() {		
		var block_id = $(this).closest('.search_big').attr('id');
		var search_type = $(this).closest('.search_big').attr('data-type');
		var tag = $('#'+block_id+' ul.selector li').attr('data-category');
		var phrase = $('#'+block_id+' input').val();
		if(tag !== 'all') {
			var slug = $('#'+block_id+' ul.selector li').attr('data-slug');
			var link = $('#'+block_id+' ul.selector li').attr('data-link');
			if(phrase.length < 1){
				if(search_type === 'promocodes_big') {
					window.location.href = my_ajax_object_new.er_blog_url+'/promocode/'+slug+'/';
				} else {
					window.location.href = link;
				}
			
			} else {
				
				if(search_type === 'promocodes_big') {
					window.location.href = my_ajax_object_new.er_blog_url+'/promocode/'+slug+'/?q='+phrase;
				} else {
					window.location.href = my_ajax_object_new.er_blog_url+'/search/'+slug+'/?q='+phrase;
				}
			}
			//big_search_results(phrase,block_id,tag,search_type);
			$('#' + block_id + ' .selector .big_search_load_cats').remove();
			$('#' + block_id + ' .selector').removeClass('active');
			$('#' + block_id + ' .selector').addClass('inactive');
		} else {
			if((phrase.length < 1)){
				if(search_type === 'promocodes_big') {
					window.location.href = my_ajax_object_new.er_blog_url+'/promocode/?q='+phrase;
				} else {
					window.location.href = my_ajax_object_new.er_blog_url+'/search/?q='+phrase;
				}
				
        		//big_search_results(phrase,block_id,tag,search_type);
				$('#' + block_id + ' .selector .big_search_load_cats').remove();
				$('#' + block_id + ' .selector').removeClass('active');
			$('#' + block_id + ' .selector').addClass('inactive');
			}  else {
				if(search_type === 'promocodes_big') {
					window.location.href = my_ajax_object_new.er_blog_url+'/promocode/?q='+phrase;
				} else {
					window.location.href = my_ajax_object_new.er_blog_url+'/search/?q='+phrase;
				}
			}
		}
        
		
    });
});