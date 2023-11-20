function updata_first_last_names() {
    first_name = $('input[name="firstname"]').val();
    last_name = $('input[name="lastname"]').val();
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: 'POST',
        data: 'action=savefio&first_name=' + first_name+'&last_name=' + last_name,
        beforeSend: function(xhr) {

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

$('body').on('change', '.file_upload_avatar input', function() {
    var file_data = $(this).prop('files')[0];
    var append_id = $(this).closest('form').attr('id');
    ajax_upload_file_avatar(file_data,append_id);
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



function after_popup_login(type,action,user_id,step) {
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
        after_popup_login('reg_site', 'auth_new', userid,'avatar');
        $(this).toggleClass('active');
    } else {
        $('#popup_update_fields').remove();
        $(this).toggleClass('active');
        $('.user-form__avatar .profile_logo').attr('style',$('.user-form__avatar .profile_logo').attr('data-style'));
    }

});