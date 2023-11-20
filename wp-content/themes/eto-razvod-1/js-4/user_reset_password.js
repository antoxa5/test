$ = jQuery.noConflict();
$(document).ready(function(){
    $('#rpgo').click(function() {
        alert(1);
        $('#rpmessage_error').css('display','none');
        retrivemailnew = $('#emailget').val();

        $.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: 'action=retrivemailnew&retrivemailnew=' + retrivemailnew+'',
            beforeSend: function(xhr) {

            },
            success: function(data) {
                result = $.parseJSON(data);
                if (result.status == 'ok') {
                    popup_alert_message('Сообщение со ссылкой для изменения пароля было Вам отправлено по e-mail','ok');
                } else if (result.status == 'notexist') {
                    popup_alert_message('Пользователь с указанным e-mail адресом не был найден','error');
                } else if (result.status == 'notemail') {
                    alert(result.check);
                    popup_alert_message('Вы указали некорректный e-mail','error');
                } else if (result.status == 'recaptcha') {
                    popup_alert_message('Не пройдена каптча! Попробуйте еще раз!','error');
                }
            }
        });
    });

    $('#rpgosetnewpassword').click(function() {
        block_input_username = $('#rp .block_input_username').val();
        block_input_psw1 = $('#rp .block_input_psw1').val();
        block_input_psw2 = $('#rp .block_input_psw2').val();

        if ($('#rp .block_input_psw1').val().length < 8) {
            popup_alert_message('Минимальная длина пароля 8 символов','error');
        } else {
            //Сравнение пароля
            if (encodeURIComponent(block_input_psw1) == encodeURIComponent(block_input_psw2)) {
                //Проверка на пробел
                if (/\s/.test(block_input_psw1)) {
                    popup_alert_message('В пароле используется пробел','error');
                } else {
                    //Проверка на кириллицу
                    if (/[а-яА-ЯЁё]/.test(block_input_psw1)) {
                        popup_alert_message('Используйте буквы латинского алфавита и спецсимволы','error');
                    } else {
                        //Проверка на пустой символ
                        if (block_input_psw1 != '') {
                            $.ajax({
                                url: my_ajax_object.ajax_url,
                                type: 'POST',
                                data: 'action=setlostpwnew&block_input_username='+block_input_username+'&block_input_psw1='+block_input_psw1+'&block_input_psw2='+ block_input_psw2,
                                beforeSend: function(xhr) {

                                },
                                success: function(data) {
                                    result = $.parseJSON(data);

                                    if (result.status == 'ok') {
                                        window.location.replace("/user/");
                                    } else {
                                        popup_alert_message(result.secondstatus,'error');
                                    }
                                }
                            });

                        } else {
                            $('.rpmessage').text('Нет пароля');
                        }
                        //Проверка на пустой символ
                    }
                    //Проверка на кириллицу
                }
                //Проверка на пробел
            } else {
                popup_alert_message('Пароли не совпадают','error');
            }
        }
    }); });