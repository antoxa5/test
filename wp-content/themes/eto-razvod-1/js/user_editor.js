function updata_first_last_names() {
    first_name = $('input[name="firstname"]').val();
    last_name = $('input[name="lastname"]').val();
    city_id = $('input[name="name__city"]').data('city_id');
    country_id = $('input[name="name__country"]').data('country_id');
    /*console.log(typeof city_id);
    console.log(typeof country_id);*/
    if ( (typeof city_id == 'number') && (city_id > 0)){
        console.log(city_id);
        city = $('input[name="name__city"]').val();
    } else {
        city = $('input[name="name__city"]').val();
    }
    if( (typeof country_id == 'number') && (country_id > 0)) {
        console.log(country_id);
        country = $('input[name="name__country"]').val();
    } else {
        country = $('input[name="name__country"]').val();
    }
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: 'POST',
        data: 'action=savefio&first_name=' + first_name+'&last_name=' + last_name +'&city='+ city +'&country='+ country,
        beforeSend: function(xhr) {
            console.log('action=savefio&first_name=' + first_name+'&last_name=' + last_name +'&city='+ city +'&country='+ country);
        },
        success: function(data) {

            result = $.parseJSON(data);

            if ((first_name == '') && (last_name == '')) {
                $('.user_edit_avatar_block_title').text($('.user_edit_bar').attr('data-name'));
            } else {
                $('.user_edit_avatar_block_title').text(first_name+' '+last_name);
            }

            if (first_name == '') {

            } else {
                $('.user_name .display_name').text(first_name);
            }
        }
    });
}

function ajax_vk_load_countries(field_id, q) {

    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=ajax_vk_load_countries&q="+q,
        beforeSend: function(xhr) {
        },
        success: function( data ) {
            $('.block_search_results').html('');
            $('#'+field_id+' .block_search_results').append(data);
        }
    });
};

function ajax_vk_load_cities(country, q) {
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=ajax_vk_load_cities&country="+country+"&q="+q,
        beforeSend: function(xhr) {

        },
        success: function( data ) {
            //alert(data);
            $('.city_fields').remove();
            $('#city_input .block_search_results').append(data);
            //$('#name__city').hide();
        }
    });
};

function update_contact_email() {
    email = $('input[name="profile_mail_input"]').val();
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: 'POST',
        async: false,
        data: 'action=update_contact_email&email='+email,
        beforeSend: function(xhr) {

        },
        success: function(data) {
            result = $.parseJSON(data);

            $('.email_troubles').remove();
            if (result.status == 'ok') {
                //$('.profile_sidebar_contact_link__email').attr('href','mailto:'+email);
                //$('.profile_sidebar_contact_link__email').html('<span class="profile_mail"></span>'+email);
                $('.profile_sidebar_contact_link__email_wrapper').html('<a class="profile_sidebar_contact_link profile_sidebar_contact_link__email" href="mailto:'+email+'"><span class="profile_mail"></span>'+email+'</a>');

                if (email == '') {
                    $('.profile_sidebar_contact_link__email_wrapper').html('');
                }
            } else {
                texttroubles = '';
                jQuery.each( $.parseJSON(result.troubles), function( i, val ) {
                    texttroubles += '<span>'+val+'</span>';
                });
                $('input[name="profile_mail_input"]').after('<span class="email_troubles troubles_o color_red flex flex_column font_small">'+texttroubles+'</span>')
            }


        }
    });
}

function update_contact_skype() {
    skype = $('input[name="profile_skype_mail_input"]').val();
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: 'POST',
        data: 'action=update_contact_skype&skype=' + skype,
        beforeSend: function (xhr) {

        },
        success: function (data) {
            result = $.parseJSON(data);

            $('.skype_troubles').remove();
            if (result.status == 'ok') {
                //$('.profile_sidebar_contact_link__skype').html('<span class="profile_skype"></span>'+skype);
                $('.profile_sidebar_contact_link__skype_wrapper').html('<a class="profile_sidebar_contact_link profile_sidebar_contact_link__skype" href="skype:'+skype+'f?chat"><span class="profile_skype"></span>'+skype+'</a>');
                if (skype == '') {
                    $('.profile_sidebar_contact_link__skype_wrapper').html('');
                }
            } else {
                texttroubles = '';
                jQuery.each( $.parseJSON(result.troubles), function( i, val ) {
                    texttroubles += '<span>'+val+'</span>';
                });
                $('input[name="profile_skype_mail_input"]').after('<span class="skype_troubles troubles_o color_red flex flex_column font_small">'+texttroubles+'</span>')
            }


        }
    });
}

function update_contact_telegram() {
    telegram = $('input[name="profile_telegram_mail_input"]').val();
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: 'POST',
        data: 'action=update_contact_telegram&telegram='+telegram,
        beforeSend: function(xhr) {

        },
        success: function(data) {
            result = $.parseJSON(data);
            $('.telegram_troubles').remove();

            if (result.status == 'ok') {
                $('.profile_sidebar_contact_link__telegram_wrapper').html('<a class="profile_sidebar_contact_link profile_sidebar_contact_link__telegram" href="https://t.me/'+telegram+'"><span class="profile_telegram"></span>'+telegram+'</a>');
                //$('.profile_sidebar_contact_link__telegram').html('<span class="profile_telegram"></span>'+telegram);
                if (telegram == '') {
                    $('.profile_sidebar_contact_link__telegram_wrapper').html('');
                }
            } else {
                texttroubles = '';
                jQuery.each( $.parseJSON(result.troubles), function( i, val ) {
                    texttroubles += '<span>'+val+'</span>';
                });
                $('input[name="profile_telegram_mail_input"]').after('<span class="telegram_troubles troubles_o color_red flex flex_column font_small">'+texttroubles+'</span>')
            }


        }
    });
}


function update_contact_about() {
    edit_about = $('textarea[name="edit_about"]').val();
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: 'POST',
        data: 'action=update_contact_about&edit_about=' + edit_about,
        beforeSend: function(xhr) {

        },
        success: function(data) {

            result = $.parseJSON(data);
            $('.user-desc__text_user-editor').text(edit_about);
        }
    });
}

$('body').on('click', '.update_user_editor', function (){
    updata_first_last_names();
    $('.popup_close_button[data-close="popup_edit_user_form"]').click();
});

$('body').on('click', '.update_user_editor_contacts', function (){
    update_contact_email();
    update_contact_skype();
    update_contact_telegram();
    if ($('.troubles_o').size() == 0) {
        $('.popup_close_button[data-close="popup_edit_user_form"]').click();
    }
});

$('body').on('click', '.update_user_editor_about', function (){
    update_contact_about();
    $('.popup_close_button[data-close="popup_edit_user_form"]').click();
});

function ajax_upload_file_avatar(file_data,append_id) {
    console.log(file_data);
    form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('action', 'ajax_upload_avatar');

    $.ajax({
        url: my_ajax_object.ajax_url,
        type: 'POST',
        contentType: false,
        processData: false,
        data: form_data,
        beforeSend: function(xhr) {
        },
        complete: function(){
        },
        success: function( data ) {
            result = JSON.parse(data);
            //console.log(result);
            if(result.status === 'ok') {

                $('.user-form__avatar .profile_logo').attr('style',"background-image:url("+result.medium_url+");background-size: cover;")
                $('#'+append_id+' .link_upload_avatar').text(result.text_2);
                $('#'+append_id+' .link_upload_avatar').css('display','none');
                $('<input type="submit" name="submit" class="button button_green radius_small m_b_10 pointer link_submit_avatar" value="'+result.text_1+'">').insertBefore('#'+append_id+' .link_container');
                $('#popup_modals').on('click', '.file_upload_avatar .file_delete', function(e){
                    e.preventDefault();
                    $('#'+append_id+' .file_upload_avatar_image').css('background-image', 'none');
                    $('#'+append_id+' .link_upload_avatar').text(result.text_0);
                    $('#'+append_id+' .link_submit_avatar').remove();
                });

            }
        }
    });
}

function clear_fields_country_and_city(){
    $('input[name="name__country"]').val('');
    $('input[name="name__city"]').val('');
    $('.block_search_results').removeClass('show_results').html('');
    $('.select__country').removeClass('active_search');
    $('.city_input').css('display','none');
}

$('body').on('input', 'input[name="name__country"]', function(){
    $('.select__country .block_search_results').addClass('show_results');
    $('.city_fields').remove(); // удаляем блок с городами
    $('.city_input').css('display','none');
    $('#name__city').val('');
    var id = $(this).parents('.select__country').attr('id');
    var q = $(this).val();
    $('#'+id).addClass('active_search');
    if (q.length == 0 ) {
        clear_fields_country_and_city();
    }
    ajax_vk_load_countries(id,q);
});

$('body').on('input', 'input[name="name__city"]', function(){
    $('.city_input').addClass('active_search');
    $('.city_input .block_search_results').addClass('show_results');
    var q = $(this).val();
    var country_id = $('.active_country').attr('data-country-id');        
    if (q.length >= 3 ) {
        ajax_vk_load_cities(country_id,q);
    }
});

$('body').on('click', '.country_search_icon_close', function(){
    clear_fields_country_and_city();
});

$('body').on('click', '.user_field_countries li', function(){
    $('.block_search_results').removeClass('show_results');
    $('.city_input').css('display','block');
    $('#name__country').parent().show();
    $('#name__city').val('');
    $(this).addClass('active_country');
    $(this).parents('.user_field_countries').hide();
    var text = $(this).text();
    $('#name__country').val(text).attr('data-country_id', $(this).attr('data-country-id')).focus();
});

$('body').on('click', '.city_fields li', function(){
    $('.city_fields li').removeClass('active_city');
    $('.block_search_results').removeClass('show_results');
    $(this).addClass('active_city');
    var text = $(this).find('.city_title').text();
    $('#name__city').val(text).attr('data-city_id', $(this).attr('data-city-id')).focus();
    $('.user_field_countries').hide();
    $('.city_fields').remove();
})


$('body').on('change', '.file_upload_avatar input', function() {
    var file_data = $(this).prop('files')[0];
    var append_id = $(this).closest('form').attr('id');
    ajax_upload_file_avatar(file_data,append_id);
    $('.remove-button-profile-avatar').attr('style','');
});

$('body').on('submit', '#popup_update_fields', function(e) {
    e.preventDefault();
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: 'POST',
        data: 'action=user_update_fields_avatar',
        beforeSend: function (xhr) {

        },
        success: function (data) {
            result = JSON.parse(data);
            //alert(result);
            $('.user_edit_bar .profile_logo').attr('style','background-image:url('+result.url+');background-size: cover;');
            $('.user_picture').attr('style','background-image:url('+result.url_thumb+');');
            $('#popup_update_fields').remove();
            $('.edit-button-profile-avatar').removeClass('active');
        }
    })
});



function after_popup_login2(type,action,user_id,step) {
    if(action === 'auth_new') {
		
        $.ajax({
            url: my_ajax_object.ajax_url,
            type: "POST",
            data: "action=user_after_reg_fields&user_id="+user_id+"&step="+step,
            beforeSend: function(xhr) {
                $('.spinner').show();
            },
            complete: function(){
                $(".spinner").hide();
            },
            success: function( data ) {
                if(data === 'ok') {

                } else {
                    $('.user-form__avatar').after(data);
                    //$('#popup_modals .popup_container').addClass('show');
                    $('#popup_modals').on('click', '.link_skip_fields_avatar', function(){
                        $(this).closest('.popup_container').remove();
                        after_popup_login(type, action, user_id,'fields');
                    });
                }
            }
        });
    }
}

$('body').on('click','.edit-button-profile-avatar', function() {

    if (!($(this).hasClass('active'))) {
        $('.user-form__avatar .profile_logo').attr('data-style',$('.user-form__avatar .profile_logo').attr('style'));
        after_popup_login2('reg_site', 'auth_new', userid,'avatar');
        $(this).toggleClass('active');
    } else {
        $('#popup_update_fields').remove();
        $(this).toggleClass('active');
        $('.user-form__avatar .profile_logo').attr('style',$('.user-form__avatar .profile_logo').attr('data-style'));
    }

});

$('body').on('click','.remove-button-profile-avatar', function() {
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=remove_avatar",
        beforeSend: function(xhr) {
        },
        complete: function(){
        },
        success: function( data ) {
            if ($('.user-form__avatar .profile_logo').attr('style') == 'background-image: url(/wp-content/themes/eto-razvod-1/img/icon_user_default.svg);background-size: cover;border: 1px solid #cfdadf;') {

            } else {
                $('.user_picture,.profile_logo').attr('style',data);
                $('#popup_update_fields').remove();
                $('.edit-button-profile-avatar').removeClass('active');
                $('.user-form__avatar .profile_logo').attr('style',$('.user-form__avatar .profile_logo').attr('data-style'));
                $('.remove-button-profile-avatar').attr('style','display: none;');
            }

        }
    });
});

$('body').on('click','.nonactivated_profile', function () {
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: 'POST',
        data: 'action=gotoverify_profile',
        beforeSend: function(xhr) {

        },
        success: function(data) {
            result = $.parseJSON(data);
            popup_alert_message(result.answear,result.status);

        }
    });
})

$('body').on('click', '.edit_password', function() {
    $(this).toggleClass('active');
    $('.psw_input').toggleClass('input_locked');
    $('.update_password').toggleClass('displaynone');
    $('input[name="password_1"],input[name="password_2"]').val('');
    $('.eye-closed').addClass('displaynone');
    $('.eye-show').removeClass('displaynone');
    $('input[name="password_1"],input[name="password_2"]').attr('type','text');
    $('.about_psw').text('');
});
$.fn.toggleAttrVal = function(attr, val1, val2) {
    var test = $(this).attr(attr);
    if ( test === val1) {
        $(this).attr(attr, val2);
        return this;
    }
    if ( test === val2) {
        $(this).attr(attr, val1);
        return this;
    }
    // default to val1 if neither
    $(this).attr(attr, val1);
    return this;
};

$('body').on('click', '.showpsw', function() {
    $('.showpsw .eye-show').toggleClass('displaynone');
    $('.showpsw .eye-closed').toggleClass('displaynone');
    $('input[name="password_1"],input[name="password_2"]').toggleAttrVal('type', "text", "password");

})
$('body').on('click', '.update_password', function() {
    savepass = $('input[name="password_1"]').val();
    savepass2 = $('input[name="password_2"]').val();


    if (encodeURIComponent(savepass) == encodeURIComponent(savepass2)) {
        if (/\s/.test($('input[name="password_1"]').val())) {
            $('.about_psw').text('В пароле используется пробел');
        } else {
            if (/[а-яА-ЯЁё]/.test($('input[name="password_1"]').val())) {
                $('.about_psw').text('Используйте буквы латинского алфавита и спецсимволы');

            } else {
                if ($('input[name="password_1"]').val() != '') {

                    $.ajax({
                        url: my_ajax_object.ajax_url,
                        type: 'POST',
                        data: 'action=savepass&savepass=' + encodeURIComponent(savepass)+'&savepass2=' + encodeURIComponent(savepass2),
                        beforeSend: function(xhr) {

                        },
                        success: function(data) {
                            result = $.parseJSON(data);
                            if (result.status != 'errr') {
                                $('.about_psw').text('Ваш новый пароль: '+$('input[name="password_1"]').val()+'');
                                $('.update_password').addClass('displaynone');
                                $('.eye-closed').addClass('displaynone');
                                $('.eye-show').removeClass('displaynone');
                                $('.psw_input').addClass('input_locked');

                                $('input[name="password_1"],input[name="password_2"]').val('');
                                $('input[name="password_1"],input[name="password_2"]').attr('type','text');
                            } else {
                                $('.about_psw').text('Вы указали некорректный пароль');
                            }

                        }
                    });
                }
            }
        }
    } else {
        $('.about_psw').text('Пароли не совпадают');
    }


});

$('body').on('click', '.edit_email', function() {
    $(this).toggleClass('active');
    $('.email_input').toggleClass('input_locked');
    $('.submit-user-emails').toggleClass('displaynone');
    $('input[name="email_name"]').val($('input[name="email_name"]').attr('data-mail'));
    $('.about_email').text('');
});

$('body').on('click','.submit-user-emails',function() {
    emailnew = $('input[name="email_name"]').val();

    $.ajax({
        url: my_ajax_object.ajax_url,
        type: 'POST',
        data: 'action=setemailnew&emailnew='+emailnew,
        beforeSend: function(xhr) {

        },
        success: function(data) {
            result = $.parseJSON(data);
            console.log(result.status);
            $('.about_email').text(result.status);
            if (result.status_second == 'ok') {
                $('.email_input').addClass('input_locked');
                $('.submit-user-emails').addClass('displaynone');
                $('input[name="email_name"]').val($('input[name="email_name"]').attr('data-mail'));
                $('.edit_email').removeClass('active');
				console.log($('.notifystatused').attr('data-from_site_send'));
				console.log($('.notifystatused').attr('data-all_send'));
				console.log($('.notifystatused').attr('data-all_send'));
            }
            if (result.status_second == 'refresh') {

            }

        }
    });

});