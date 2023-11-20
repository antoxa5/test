$ = jQuery.noConflict();

var xhrCount_ac = 0;
function autocomplete_search_results(phrase,block_id,type, tags_values) {
    //alert(block_id);
    //alert(to_exclude);
    var seqNumber = ++xhrCount_ac;
    var jqXHR;
    jqXHR = $.ajax({
        url: 'https://etorazvod.ru/wp-admin/admin-ajax.php',
        type: "POST",
        data: "action=autocomplete_search_results&phrase=" + phrase+"&type="+type+"&tags="+tags_values,
        beforeSend: function (xhr) {
            if (seqNumber !== xhrCount_ac) {

                jqXHR.abort();
            } else {
                $('#' + block_id + ' .autocomplete_search_results').empty();
                $('#'+block_id+' .autocomplete_search_results').removeClass('active');
                $('.autocomplete_container#' + block_id).append('<div class="load_ajax"></div>');
            }
        },
        complete: function () {

        },
        success: function (data) {
            if (seqNumber === xhrCount_ac) {
                $('.autocomplete_icon_close').css('display','block');
                $('.autocomplete_icon_close').css('right','50px');
                $('.autocomplete_container#' + block_id + ' .load_ajax').remove();
                // alert(data);
                // $('#'+block_id+' form').addClass('not_typing');
                $('#' + block_id + ' .autocomplete_search_results').empty();

                $('#' + block_id + ' .autocomplete_search_results').append(data);
                $('#'+block_id+' .autocomplete_search_results').addClass('active');




            }
        }
    });

};

function mass_update_reviews_show_fields(selected_company) {
   // alert(selected_company);
    $.ajax({
        url: 'https://etorazvod.ru/wp-admin/admin-ajax.php',
        type: "POST",
        data: "action=mass_update_reviews_show_fields&selected_company="+selected_company,
        beforeSend: function(xhr) {

        },
        complete: function(){

        },
        success: function( data ) {
          // alert(data);
            $('.mass_update_reviews_company_type select[name="company_type"]').prop('disabled',false);
            if(data !== 'none') {

                $('.mass_update_reviews_field_name').show();
                $('.mass_update_reviews_field_name').append(data);
                $('.mass_update_reviews_field_values').hide();
                $('.mass_update_reviews_field_values .admin_autocomplete_select').remove();
                $('.mass_update_reviews_reviews_list').hide();
                $('.mass_update_reviews_submit_container').hide();
                $('input[type="submit"]').prop('disabled',false);
                $('input[type="submit"]').addClass('button-primary');
                $('input[type="submit"]').removeClass('button-secondary');
                $('input[type="submit"]').val('Добавить значения в указанные обзоры');
            }

        }
    });
}

function mass_update_reviews_show_field_values(field_to_update) {
    // alert(selected_company);
    $.ajax({
        url: 'https://etorazvod.ru/wp-admin/admin-ajax.php',
        type: "POST",
        data: "action=mass_update_reviews_show_field_values&field_to_update="+field_to_update,
        beforeSend: function(xhr) {

        },
        complete: function(){

        },
        success: function( data ) {
            // alert(data);
            $('.mass_update_reviews_field_name select[name="field_to_update"]').prop('disabled',false);
            if(data !== 'none') {
                $('.mass_update_reviews_field_values').show();
                $('.mass_update_reviews_field_values').append(data);
                $('.mass_update_reviews_reviews_list').show();
                $('.mass_update_reviews_submit_container').show();
            }

        }
    });
}

jQuery(document).ready(function($){
    $('body').on('submit', '.active#mass_update_reviews_form', function(e) {
        e.preventDefault();
    });
    $('body').on('change', '.mass_update_reviews_company_type select[name="company_type"]', function(e) {

        var selected_company = $(this).val();

        $(this).prop('disabled',true);

        $('.mass_update_reviews_field_name select').remove();
        $('.mass_update_reviews_field_name .default_text').remove();
        $('.mass_update_reviews_field_name').hide();
        mass_update_reviews_show_fields(selected_company);
    });
    $('body').on('change', '.mass_update_reviews_field_name select[name="field_to_update"]', function(e) {

        var field_to_update = $(this).val();
       // alert(field_to_update);
        $(this).prop('disabled',true);
        mass_update_reviews_show_field_values(field_to_update);
        $('.mass_update_reviews_field_values').hide();
        $('.mass_update_reviews_field_values .admin_autocomplete_select').remove();
    });


    $('body').on('click', '.admin_autocomplete_select select[name="field_values_list"] option', function(e) {
        var term_id = $(this).val();
        var term_name = $(this).text();
        if(term_id !== 'none') {
            $(this).remove();
            //alert(term_id + ' ' + term_name);
            $('.admin_autocomplete_select .insert_field_values').append('<div class="field_value_item"><span class="field_value_name">'+term_name+'</span><span class="close"></span><input name="field_values[]" type="hidden" value="'+term_id+'" /></div>');
        }

    });
    $('body').on('click', '.autocomplete_search_results ul li', function(e) {
        var term_id = $(this).attr('data-id');
        var term_name = $(this).text();
        if(term_id !== 'none') {
            $(this).remove();
            //alert(term_id + ' ' + term_name);
            $('.insert_field_companies').append('<div class="field_company_item"><span class="field_company_name">'+term_name+'</span><span class="close"></span><input name="field_companies[]" type="hidden" value="'+term_id+'" /></div>');
        }

    });
    $('body').on('click', '.insert_field_companies .field_company_item', function(e) {
        var term_id = $(this).children('input').val();
        var term_name = $(this).children('.field_value_name').text();
        $(this).remove();
        //$('.admin_autocomplete_select select[name="field_values_list"]').append('<option value="'+term_id+'">'+term_name+'</option>');
        //alert(term_id + ' ' + term_name);
    });
    $('body').on('click', '.admin_autocomplete_select .insert_field_values .field_value_item', function(e) {
        var term_id = $(this).children('input').val();
        var term_name = $(this).children('.field_value_name').text();
        $(this).remove();
        $('.admin_autocomplete_select select[name="field_values_list"]').append('<option value="'+term_id+'">'+term_name+'</option>');
        //alert(term_id + ' ' + term_name);
    });

    $('body').on('submit', '.inactive#mass_update_reviews_form', function(e) {
        e.preventDefault();
        var form = $(this);
        $(this).removeClass('inactive');
        $(this).addClass('active');
        var form_id = $(this).attr('id');
        //alert(form_id);
        $('#'+form_id+' input[type="submit"]').removeClass('button-primary');
        $('#'+form_id+' input[type="submit"]').addClass('button-secondary');
        $('#'+form_id+' input[type="submit"]').val('Происходит обновление');
        $('#'+form_id+' input[type="submit"]').prop('disabled',true);
        $.post(form.attr('action'), form.serialize(), function(data) {
            alert(data);
            result = JSON.parse(data);
            if(result.status === 'ok') {
                $('.mass_update_reviews_field_values').hide();
                $('.mass_update_reviews_field_values .admin_autocomplete_select').remove();
                $('.mass_update_reviews_field_name').hide();
                $('.mass_update_reviews_company_type select').val('none');
                $('.mass_update_reviews_field_name select').remove();
                $('.mass_update_reviews_reviews_list').css('display','none');
                $('.mass_update_reviews_submit_container').hide();
                $('#'+form_id).addClass('inactive');
                $('#'+form_id).removeClass('active');
                $( '<div class="font_smaller m_b_20 color_green reg_error">'+result.message+'</div>' ).insertBefore( $( 'form' ) );
                setTimeout(function() {
                    $('.reg_error').remove();
                }, 5000);
            } else {
                $( '<div class="font_smaller m_b_20 color_red reg_error">'+result.message+'</div>' ).insertBefore( $( 'input[type="submit"]' ) );
                setTimeout(function() {
                    $('.reg_error').remove();
                }, 5000);
            }

        });
    });

    $('body').on('input','input[name="autocomplete_text"]',function() {

        var phrase = $(this).val();
        //alert(phrase);
        //var to_exclude = $('input[name="field_companies[]"]').val();
        var block_id = $(this).closest('.autocomplete_container').attr('id');
        var search_type = $(this).closest('.autocomplete_container').attr('data-type');
        var container_id = $('#'+block_id).closest('.mass_update_reviews_reviews_list').attr('id');
        var selected_company_tag = $('.mass_update_reviews_company_type select[name="company_type"] option:selected').attr('data-new-id');
        console.log(phrase +' '+ block_id +' '+ search_type +' '+ container_id);
        //alert(search_type);

            if(phrase.length > 1){
                $('#'+container_id+' .outside_form_container').empty();
                //$(this).closest('form').removeClass('not_typing');
                //var c_post_id = my_ajax_object.current_post_id;
                autocomplete_search_results(phrase,block_id,search_type, selected_company_tag);

            } else {
                $('#' + block_id + ' .autocomplete_search_results').empty();
            }


    });
    $('body').on('click','.autocomplete_container .autocomplete_icon_close', function() {
        $('.autocomplete_container input[name="autocomplete_text"]').val('');
        $('.autocomplete_container input[name="autocomplete_result"]').val('');
        $('.autocomplete_container .autocomplete_search_results').empty();
        $('.autocomplete_container .autocomplete_search_results').removeClass('active');
        $(this).css('display','none');
    });
});