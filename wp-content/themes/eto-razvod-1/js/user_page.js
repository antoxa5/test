jQuery(document).ready(function ($) {

    (function() {

        window.inputNumber = function(el) {

            var min = el.attr('min') || false;
            var max = el.attr('max') || false;

            var els = {};

            els.dec = el.prev();
            els.inc = el.next();

            el.each(function() {
                init($(this));
            });

            function init(el) {

                els.dec.on('click', decrement);
                els.inc.on('click', increment);

                function decrement() {
                    var value = el[0].value;
                    value--;
                    if(!min || value >= min) {
                        el[0].value = value;
                    }


                    if ((parseInt(el[0].value)) == 1) {
                        $('.sklon').text('');
                    } else if (((parseInt(el[0].value)) == 2) || ((parseInt(el[0].value)) == 3) || ((parseInt(el[0].value)) == 4)) {
                        $('.sklon').text('а');
                    } else if (((parseInt(el[0].value)) == 5) || ((parseInt(el[0].value)) == 6) || ((parseInt(el[0].value)) == 7) || ((parseInt(el[0].value)) == 8) || ((parseInt(el[0].value)) == 9) || ((parseInt(el[0].value)) == 0)) {
                        $('.sklon').text('ев');
                    }

                    if ( (parseInt(el[0].value) < 20) &&  (parseInt(el[0].value) > 9)) {
                        $('.sklon').text('ев');
                    } else if ( (parseInt(el[0].value) > 20)) {
                        if ((parseInt(el[0].value) % 10) == 1) {
                            $('.sklon').text('');
                        } else if (((parseInt(el[0].value) % 10) == 2) || ((parseInt(el[0].value) % 10) == 3) || ((parseInt(el[0].value) % 10) == 4)) {
                            $('.sklon').text('а');
                        } else if (((parseInt(el[0].value) % 10) == 5) || ((parseInt(el[0].value) % 10) == 6) || ((parseInt(el[0].value) % 10) == 7) || ((parseInt(el[0].value) % 10) == 8) || ((parseInt(el[0].value) % 10) == 9) || ((parseInt(el[0].value) % 10) == 0)) {
                            $('.sklon').text('ев');
                        }
                    }
                }

                function increment() {
                    var value = el[0].value;
                    value++;
                    if(!max || value <= max) {
                        el[0].value = value++;
                    }

                    if ((parseInt(el[0].value)) == 1) {
                        $('.sklon').text('');
                    } else if (((parseInt(el[0].value)) == 2) || ((parseInt(el[0].value)) == 3) || ((parseInt(el[0].value)) == 4)) {
                        $('.sklon').text('а');
                    } else if (((parseInt(el[0].value)) == 5) || ((parseInt(el[0].value)) == 6) || ((parseInt(el[0].value)) == 7) || ((parseInt(el[0].value)) == 8) || ((parseInt(el[0].value)) == 9) || ((parseInt(el[0].value)) == 0)) {
                        $('.sklon').text('ев');
                    }

                    if ( (parseInt(el[0].value) < 20) &&  (parseInt(el[0].value) > 9)) {
                        $('.sklon').text('ев');
                    } else if ( (parseInt(el[0].value) > 20)) {
                        if ((parseInt(el[0].value) % 10) == 1) {
                            $('.sklon').text('');
                        } else if (((parseInt(el[0].value) % 10) == 2) || ((parseInt(el[0].value) % 10) == 3) || ((parseInt(el[0].value) % 10) == 4)) {
                            $('.sklon').text('а');
                        } else if (((parseInt(el[0].value) % 10) == 5) || ((parseInt(el[0].value) % 10) == 6) || ((parseInt(el[0].value) % 10) == 7) || ((parseInt(el[0].value) % 10) == 8) || ((parseInt(el[0].value) % 10) == 9) || ((parseInt(el[0].value) % 10) == 0)) {
                            $('.sklon').text('ев');
                        }
                    }
                }
            }
        }
    })();

    inputNumber($('.input-number'));

    $(".input-number").on("change paste keyup", function() {
        $('.input-number-increment').click();
        $('.input-number-decrement').click();
    });


    jQuery('form#modalAjaxTrying :submit').click(function(event){
        event.preventDefault();
        var form_data = {'action' : 'acf/validate_save_post'};
        jQuery('form#modalAjaxTrying :input').each(function(){
            form_data[jQuery(this).attr('name')] = jQuery(this).val()
        })

        form_data.action = 'save_my_data';
        jQuery.post(my_ajax_object.ajax_url, form_data)
            .done(function(save_data){
                $('.edit_field').removeClass('transparent');
                $('form#modalAjaxTrying .load_ajax').remove();
                $('.save_to_moderate').attr('style','');
                $('.save_to_moderate .load_ajax').remove();
                //popup_alert_message('Данные успешно обновлены','ok');
            });

    });

    $('.acf-form-submit').before($('.text_form_dashboard'));
    $('.acf-form-submit').after($('.send_to_moderate'));
    $('.acf-form-submit').after($('.save_to_moderate'));

    $('body').on('click','.save_to_moderate',function (){
        $('form#modalAjaxTrying .load_ajax').remove();
        $(this).attr('style','font-size:0;');
        $(this).append('<div class="load_ajax white"></div>');
        $('form#modalAjaxTrying :submit').click();

    });

    $('.acf_form_edit .acf-fields.acf-form-fields > .acf-field.acf-field-text input[type="text"], .acf_form_edit .acf-fields.acf-form-fields > .acf-field.acf-field-date-picker input[type="text"]').each(function(){
        $(this).parent().addClass('inactive');
        $(this).parent().append('<span class="pointer edit_field"></span>');
    });

    $('body').on('click','.edit_field', function(event){
        $( this ).toggleClass('active');
        if ($(this).attr('class') == 'pointer edit_field active') {
            $(this).parent().removeClass('inactive');
        } else {
            $(this).parent().addClass('inactive');
            $(this).addClass('transparent');
            $(this).parent().append('<div class="load_ajax"></div>');
            $('form#modalAjaxTrying :submit').click();

        }

    });

    $('body').on('change','.acf_form_edit .acf-true-false label > input[checked="checked"]',function() {
       // $('form#modalAjaxTrying :submit').click();
    });
    rounder_html();
    $('body').on('click', '.menu-take-comments-dashboard__item_services', function(){
        var sort_type = $(this).attr('data-sort-type');
        if (sort_type == 'my_service') {
            $('.get_service_item__turner_turnoff').parent().parent().css('display','none');
            $('.get_service_item__turner_turnon').parent().parent().attr('style','');
        }
        if (sort_type == 'add_service') {
            $('.get_service_item__turner_turnon').parent().parent().css('display','none');
            $('.get_service_item__turner_turnoff').parent().parent().attr('style','');
        }
    });
    userid = parseInt(my_ajax_object.user_id);
    if (my_ajax_object.slug == "notifications") {
        if ($('.popup_notifications_list').size() == 0) {
            $('.profile-wrapper__center.dashboard_page_center').append('<div class="user_zero_message">Новых уведомлений нет.</div>');
        }
    }

    $('.subscribe_widget_user_profile').click(function() {
        if (typeof company_page === 'undefined') {
            window.location.href = '/dashboard/subscription/';
        }
    })

    if (document.cookie.indexOf('skillsform=') != '-1') {
        console.log('3333');
    } else {
        console.log('3434');
        if (typeof userid !== 'undefined') {
            console.log(1);
            var data = {
                action: 'is_user_logged_in'
            };

            jQuery.post(my_ajax_object.ajax_url, data, function (response) {
                if (response == 'yes') {
                    console.log(2);
                    var datanew = {
                        action: 'check_user_skills'
                    };
                    jQuery.post(my_ajax_object.ajax_url, datanew, function (response) {
                        if (response == 'yes') {
                            console.log(3);
                            setTimeout(function() {
                                if($('.turn_off_skills').length){

                                } else{
                                    console.log(4);
                                    ///popup_user_form('edit_skills_popup',0,'','simpleform');
                                }
                            }, 5000);

                        } else {

                        }
                    });
                } else {

                }
            });
        } else {
            console.log('353535')
        }
    }

    $('.profile_comments_stats').click(function() {
        if (typeof company_page === 'undefined') {
            window.location.href = '/dashboard/comments/';
        }
    })

    $('.profile_abuse_stats').click(function() {
        if (typeof company_page === 'undefined') {
            window.location.href = '/dashboard/abuses/';
        }
    })


    $('.my_posts_profile').click(function() {
        //if (typeof company_page === 'undefined') {
        //    window.location.href = '/dashboard/news/';
        //}
    })
    $('.edit-button-profile').click(function() {
        $(this).toggleClass('active');
        $(this).parent().toggleClass('active_editing_profile');
        $('.skills-comments__add').toggleClass('active');

    });

    $('.edit_editor').click(function() {
        //if ($(this).attr('data-type') == 'edit-profile') {
        if ($(this).hasClass('edit_editor_company')) {

            popup_user_form($(this).attr('data-type'),my_ajax_object.user_id);
        } else {
            popup_user_form($(this).attr('data-type'),my_ajax_object.user_id);
        }

        //}



    });


    $('.edit_your_about').click(function() {
        popup_user_form('edit-about',my_ajax_object.user_id);
    });

    $('.skills-comments__add,.skills-comments__add_s').click(function () {

        popup_user_form('edit_skills_popup',my_ajax_object.user_id);

        //user_skills_add();
    })



    $('body').on('click', '.active_editing_profile .skills-comments__myskill', function(){
    	console.log(111);
        obj = $(this);
        skillid = obj.attr('data-skill');
        $.ajax({
            url: my_ajax_object.ajax_url,
            type: "POST",
            data: "action=user_skills_remove&id="+skillid,
            beforeSend: function(xhr) {
            },
            complete: function(){
            },
            success: function( data ) {
                obj.remove();

            }
        });
    });

    $('body').on('click','.pro_account_buy',function (){
        month = parseInt($('input.input-number').val());
        if (isNaN(month)) {
            month = 1
        }
        window.location.href = '/dashboard/wallet/?service=PRO&month='+month;
    });
})

function user_skills_add(skillid) {
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=user_skills_add&id="+skillid,
        beforeSend: function(xhr) {
        },
        complete: function(){
        },
        success: function( data ) {
            //obj.remove();
            console.log('1 a'+skillid);
            //$()
            $('.skills-comments__myskill-wrapper').append(data);
            $('.popup_close_button').click();

        }
    });
}

function user_skills_add_mass(skillid) {
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=user_skills_add_mass&id="+skillid,
        beforeSend: function(xhr) {
			$('.add_skills_popup').append('<div class="load_ajax"></div>')
			$('.add_skills_popup').addClass('active');
        },
        complete: function(){
        },
        success: function( data ) {
			$('.add_skills_popup').removeClass('active');
			$('.add_skills_popup .load_ajax').remove();
            //obj.remove();
            console.log('2 a'+skillid);
            //$()
            $('.skills-comments__myskill-wrapper').append(data);
            $('.popup_close_button').click();

        }
    });
}

function rounder_html() {
    $('.new-comments-profile__number').each(function(){
        number = parseInt($(this).text());
        if (number < 10) {
            $(this).css('border-radius','50%');
            $(this).css('padding',0);
            $(this).css('width',$(this).height()+'px')
        }
    })
}



$('body').on('click','.skip_skills',function(){
    $('.popup_close_button').click();

})

$('body').on('click','.send_blog_post',function (){
    $(this).addClass('go_next_add_company_act');
    $(this).append('<div class="load_ajax"></div>');
    text_blogpost = $('textarea[name="text_blogpost"]').val();
    contact_type = $( 'select[name="select_contact"]' ).val();
    login_type = $( 'input[name="contact_name"]' ).val();
    title_name = $( 'input[name="title_name"]' ).val();

    fileuploadcomp_item_ids = [];
    $('.fileuploadcomp_item').each(function (){
        fileuploadcomp_item_ids.push(	$(this).attr('att-id')	);
    })
    fileuploadcomp_item_ids_text = fileuploadcomp_item_ids.join(", ");

    if ($( 'select[name="select_contact"]' ).val() == 'Мессенджер для связи') {
        $('.send_blog_post').removeClass('go_next_add_company_act');
        $('.send_blog_post .load_ajax').remove();
        popup_alert_message('Вы не выбрали мессенджер для связи','error');
    } else {
        if ($('input[name="contact_name"]').val() == '') {
            $('.send_blog_post').removeClass('go_next_add_company_act');
            $('.send_blog_post .load_ajax').remove();
            popup_alert_message('Вы не заполнили логин ' + contact_type, 'error');
        } else {
            $.ajax({
                url: my_ajax_object.ajax_url,
                type: "POST",
                data: "action=send_blog_post&contact_type="+contact_type+"&login_type="+login_type+"&text_blogpost="+text_blogpost+"&title_name="+title_name+"&image_views="+fileuploadcomp_item_ids_text,
                beforeSend: function(xhr) {

                },
                complete: function(){

                },
                success: function( data ) {
                    $('.send_blog_post').removeClass('go_next_add_company_act');
                    $('.send_blog_post .load_ajax').remove();
                    result = JSON.parse(data);
                    popup_alert_message('Ваше сообщение отправлено! Наш менеджер свяжется с вами!','ok');
                }
            });
        }
    }
});

$('body').on('click', '.load_more_single_promocodes', function(){
    $('.white_block.flex.border_biolet').removeClass('hidden');
    $(this).remove();
});

$('body').on('click', '.acf-form-submit input[type="submit"]', function(){
    company_id = getUrlParameter('company');
    select_contact = $('select[name="select_contact"]').val();
    contact_name = $('input[name="contact_name"]').val();
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=send_to_moderate&company_id="+company_id+"&select_contact="+select_contact+"&contact_name="+contact_name,
        beforeSend: function(xhr) {

        },
        complete: function(){

        },
        success: function( data ) {

        }
    });
});