$(document).ready(function() {
    $('.comments_top_count').text($('.all_promos_number').text());

    $('.promocode_btn_add').click(function() {
        $('.promocode_btn_add').removeClass('act');
        $(this).addClass('act');
    })
});

$('body').on('click','.menu-take-comments-dashboard__item_comp_d_promo[data-sort-type="answers"]', function () {
    $('.single_promocodes_list > li').css('display','none');
    $('.single_promocodes_list > li.border_biolet').css('display','flex');
});

$('body').on('click','.menu-take-comments-dashboard__item_comp_d_promo[data-sort-type="noanswers"]', function () {
    $('.single_promocodes_list > li').css('display','none');
    $('.single_promocodes_list > li.border_green').css('display','flex');
});

$('body').on('click','.menu-take-comments-dashboard__item_comp_d_promo[data-sort-type="new"]', function () {
    $('.single_promocodes_list > li').css('display','flex');
});

$('body').on('click','.add_promocode_btn_main',function (){
    if (typeof typeact_promo === 'undefined') {
        typeact_promo = 'promo';
    }
    popup_company_form('add_promo',0,'',typeact_promo,company_page.company_id,company_page.company_slug);
});

$('body').on('click','.send_promocode',function (){
    typemain = $(this).attr('data-type');
    if (typemain == 'edit') {
        get_id_from_class = $('.get_id_from_class').attr('data-id');
        get_number_from_class = $('.get_id_from_class').attr('data-number');
        if (typeof typeact_promo !== 'undefined') {
            typeact_promo = 'promo';
        } else {
            typeact_promo = '';
        }
        $(this).append('<div class="load_ajax"></div>');
        select_promotype = $( 'select[name="select_promotype"]' ).val();
        add_promo_name = $('input[name="add_promo_name"]').val();
        add_promo_desc = $('textarea[name="add_promo_desc"]').val();
        add_promo_link = $('input[name="add_promo_link"]').val();
        add_promo_amount = $('input[name="add_promo_amount"]').val();
        add_promo_discount_currency = $('input[name="add_promo_discount_currency"]').val();
        add_promo_text = $('input[name="add_promo_text"]').val();
        start_promo = $('input[name="start_promo"]').val();
        end_promo = $('input[name="end_promo"]').val();
        $(this).addClass('send_promocode_loading');
        //alert(get_id_from_class+' '+get_number_from_class+' '+typemain);
        $.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: 'action=add_promocode_main&select_promotype='+select_promotype+'&add_promo_name='+add_promo_name+'&add_promo_desc='+add_promo_desc+'&add_promo_link='+add_promo_link+'&add_promo_amount='+add_promo_amount+'&add_promo_discount_currency='+add_promo_discount_currency+'&add_promo_text='+add_promo_text+'&start_promo='+start_promo+'&end_promo='+end_promo+'&company_id='+company_page.company_id+'&typeact_promo='+typeact_promo+'&get_id_from_class='+get_id_from_class+'&get_number_from_class='+get_number_from_class+'&type_main='+typemain,
            beforeSend: function(xhr) {

            },
            success: function( data ) {
                $('.send_promocode .load_ajax').remove();
                $('div[data-close="popup_edit_user_form"]').click();
                $('.send_promocode').removeClass('send_promocode_loading');

                popup_alert_message('Промокод успешно обновлен','ok');

            }
        });
    } else {
        if (typeof typeact_promo !== 'undefined') {
            typeact_promo = 'promo';
        } else {
            typeact_promo = '';
        }
        $(this).append('<div class="load_ajax"></div>');
        select_promotype = $( 'select[name="select_promotype"]' ).val();
        add_promo_name = $('input[name="add_promo_name"]').val();
        add_promo_desc = $('textarea[name="add_promo_desc"]').val();
        add_promo_link = $('input[name="add_promo_link"]').val();
        add_promo_amount = $('input[name="add_promo_amount"]').val();
        add_promo_discount_currency = $('input[name="add_promo_discount_currency"]').val();
        add_promo_text = $('input[name="add_promo_text"]').val();
        start_promo = $('input[name="start_promo"]').val();
        end_promo = $('input[name="end_promo"]').val();
        $(this).addClass('send_promocode_loading');

        $.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: 'action=add_promocode_main&select_promotype='+select_promotype+'&add_promo_name='+add_promo_name+'&add_promo_desc='+add_promo_desc+'&add_promo_link='+add_promo_link+'&add_promo_amount='+add_promo_amount+'&add_promo_discount_currency='+add_promo_discount_currency+'&add_promo_text='+add_promo_text+'&start_promo='+start_promo+'&end_promo='+end_promo+'&company_id='+company_page.company_id+'&typeact_promo='+typeact_promo+'&type_main='+typemain,
            beforeSend: function(xhr) {

            },
            success: function( data ) {
                $('.send_promocode .load_ajax').remove();
                $('div[data-close="popup_edit_user_form"]').click();
                $('.send_promocode').removeClass('send_promocode_loading');
                popup_alert_message('Промокод отправлен на проверку','ok');

            }
        });
    }
});