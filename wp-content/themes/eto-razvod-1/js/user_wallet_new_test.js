$ = jQuery.noConflict();


$(document).ready(function () {

    fromstory = 0;
    $('body').on('click','.next_btn_r',function(){
        amount = parseInt(($('input[name="send_money__footer__amount"]').val()));
        if (amount > 399) {
            $(this).parent().css('display', 'none');
            $(this).parent().next().css('display', 'flex');
            $('.price_from_input').text(amount);
        } else {
            popup_alert_message('Укажите сумму выше 400 рублей',"error");
        }
    });


    $('body').on('click', '.send_money__footer__btn', function () {
        if (fromstory == 0) {
            amount = parseInt(($('input[name="send_money__footer__amount"]').val()));
            //method = $('select[name="select_method"]').val();
            method = $('input[name="paymethod"]:checked').parent().attr('value');
            button = $(this);
            if (amount > 399) {
                button.addClass('act');
                button.append('<div class="load_ajax"></div>');
                amountParseInt = amount;
                amount = '' + amount + '.00';
                service = getUrlParameter('service');
                month = getUrlParameter('month');
                //current_userfunc
                $.ajax({
                    url: my_ajax_object.ajax_url,
                    type: 'POST',
                    data: 'action=card_before_new&amountval=' + amountParseInt+'&service='+service+'&month='+month,
                    beforeSend: function (xhr) {
                    },
                    success: function (data) {
                        result = $.parseJSON(data);
                        email = result.email;
                        userid_new = result.userid;
                        trans_id = result.trans_id;
                        id = result.id;
                        payer = 'https://etorazvod.ru/yookassa/payer.php';
                        if ((parseInt(my_ajax_object.user_id) == 17) || (parseInt(my_ajax_object.user_id) == 3111111111)) {
                            payer = 'https://etorazvod.ru/yookassa/payer_adm.php';
                        }
                        $.ajax({
                            type: "POST",
                            url: payer,
                            data: {
                                amount: amount,
                                email: email,
                                userid: userid_new,
                                trans_id: trans_id,
                                id: id,
                                method: method
                            },
                            success: function (data) {
                                button.removeClass('act');
                                $('.send_money__footer__btn .load_ajax').remove();
                                window.location.href = data;
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr);
                            }
                        });
                    }
                });
            } else {
                popup_alert_message('Укажите сумму выше 400 рублей', "error");
            }
        } else {
            payer = 'https://etorazvod.ru/yookassa/payer.php';
            if ((parseInt(my_ajax_object.user_id) == 17) || (parseInt(my_ajax_object.user_id) == 3111111111)) {
                payer = 'https://etorazvod.ru/yookassa/payer_adm.php';
            }
            method = $(this).attr('data-method');
            $.ajax({
                type: "POST",
                url: payer,
                data: {amount: amount, email: email, userid: userid_new, trans_id: trans_id, id: id, method: method},
                success: function (data) {
                    button.removeClass('act');
                    $('.wallet_history__row__icon .load_ajax').remove();
                    window.location.href = data;
                },
                error: function (xhr, status, error) {
                    console.error(xhr);
                }
            });
        }
    });

    $('body').on('click', '.wallet_history__row__icon', function(){
        fromstory = 1;
        button = $(this);
        button.addClass('act');
        button.append('<div class="load_ajax"></div>');
        amount = $(this).attr('data-amount');
        email = $(this).attr('data-email');
        userid_new = $(this).attr('data-userid');
        trans_id = $(this).attr('data-trans_id');
        id = $(this).attr('data-id');
        $('input[name="send_money__footer__amount"]').val(amount);
        $('.next_btn_r').click();
        button.removeClass('act');
        $('.wallet_history__row__icon .load_ajax').remove();


       /* method = $(this).attr('data-method');
        $.ajax({
            type: "POST",
            url: 'https://etorazvod.ru/yookassa/payer.php',
            data: {amount: amount, email: email, userid: userid_new, trans_id: trans_id, id: id, method: method},
            success: function (data) {
                button.removeClass('act');
                $('.wallet_history__row__icon .load_ajax').remove();
                window.location.href = data;
            },
            error: function (xhr, status, error) {
                console.error(xhr);
            }
        });*/
    });


    $( "#accept_pay" ).change(function() {
        if($(this).prop("checked")) {
            $('.send_money__footer__btn').addClass('send_money__footer__btn_act');
        } else {
            $('.send_money__footer__btn').removeClass('send_money__footer__btn_act');
        }
    });
    //
    $('.wallet_history__header').on('click', '.rating_th', function(){
        if ($(".rating_th").hasClass("DESC")) {
            $(this).removeClass('DESC sort_DESC');
            $('.wallet_history__header .rating_th').removeClass('ASC DESC');
            $(this).addClass('ASC sort_ASC');
        } else {
            $(this).removeClass('ASC sort_ASC');
            $('.wallet_history__header .rating_th').removeClass('ASC DESC');
            $(this).addClass('DESC sort_DESC');
        }
    })

    if (getUrlParameter('price') == "4990") {
        $('.wallet_history > .wallet_history__row:nth-of-type(2) .wallet_history__row__icon_card').click();

        //$('.next_btn_r').click();

    }

    if (getUrlParameter('service') == "PRO") {
        $('input[name="send_money__footer__amount"]').val(400*parseInt(getUrlParameter('month')));
        $('.next_btn_r').click();
        //$('.next_btn_r').click();

    }

    if (getUrlParameter('conn_id')) {
        $('.wallet_history > .wallet_history__row[attr-id="'+getUrlParameter('conn_id')+'"] .wallet_history__row__icon_card').click();
        //$('.next_btn_r').click();
    }
});