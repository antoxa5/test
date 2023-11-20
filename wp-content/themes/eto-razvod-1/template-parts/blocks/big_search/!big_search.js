$ = jQuery.noConflict();
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
function big_search_results(phrase,block_id) {
    //alert(block_id);
	
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=big_search_results&phrase="+phrase,
        beforeSend: function(xhr) {
			$('#'+block_id+' .big_search_results').empty();
			$('#'+block_id+' .big_search_results').append('<div class="load_ajax"></div>');
        },
		complete: function(){
			$('#'+block_id+' .big_search_results .load_ajax').remove();
		},
        success: function( data ) {
          // alert(data);
		  // $('#'+block_id+' form').addClass('not_typing');
           $('#'+block_id+' .big_search_results').append(data);

        }
    });
};
jQuery(document).ready(function($){
    $('body').on('click','.search_box ul.tags li',function() {
        var block_id = $(this).closest('.companies_big').attr('id');
        var term_id = $(this).attr('data-term-id');
        var text = $(this).text();
        $('#'+block_id+' .selector').empty();
        $('#'+block_id+' .selector').append('<li class="active link_dropdown pointer" data-category="'+term_id+'">'+text+'</li>');
    });
    $('body').on('click','.link_search_more',function() {
        var block_id = $(this).closest('.companies_big').attr('id');
        var tag = $('#'+block_id+' ul.selector li').attr('data-category');
        $('#'+block_id+' .filter_tags').remove();
        show_more_filter(tag,block_id);
    });
	$('body').on('focus','.search_box .form_container .not_typing input',function() {
		alert('f');
    });
	$('body').on('input','.search_box .form_container .not_typing input',function() {
		var phrase = $(this).val();
		var block_id = $(this).closest('.companies_big').attr('id');
		if(phrase.length > 1){
			$('#'+block_id+' .big_search_results').empty();
			//$(this).closest('form').removeClass('not_typing');
        big_search_results(phrase,block_id);
		}
    });
    $('body').on('submit','.search_box form',function(e) {
        e.preventDefault();
       // alert('ll');
    });
});