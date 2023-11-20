$ = jQuery.noConflict();

var widget = new cp.CloudPayments();
amountval = 0;
this.pay = function () {
    amountval = Math.abs(parseInt(amountval));
    widget.pay('charge',
        { //options
            publicId: 'pk_9e9845c4d45b6acc7a06acc1a1841',
            description: 'Пополнение счёта',
            amount: amountval,
            currency: 'RUB',
            invoiceId: invoiceId,
            accountId: email,
            skin: "modern",
            data: {
                myProp: 'myProp value'
            }
        },
        {
            onSuccess: function (options) {
                invoiceId = options.invoiceId;
                $.ajax({
                    url: my_ajax_object.ajax_url,
                    type: 'POST',
                    data: 'action=card_after&invoceid=' + invoiceId + '&resultid=' + resultid,
                    beforeSend: function (xhr) {
                    },
                    success: function (data) {
                        result = $.parseJSON(data);
                        $('.balance_service .number-stat-profile__number').text(result.balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ')+' Р');

                    }
                });
            },
            onFail: function (reason, options) {
                location.reload();
            },
            onComplete: function (paymentResult, options) {
            }
        }
    )
};

this.pay2 = function () {
    amountval = Math.abs(parseInt(amountval));
    //descriptionvar = 'Пополнение счёта';
    //descriptionvar = 'Покупка тарифа '+$('.formed-wrapper-input[data-step="finish_him"] .title-service-accept.title-service-accept-fin').text()+' на '+ $('.formed-wrapper-input[data-step="finish_him"] .mounth-dater').text()+'';
    descriptionvar = 'Покупка тарифа PRO на 1 месяц';

    widget.pay('charge',
        {
            publicId: 'pk_9e9845c4d45b6acc7a06acc1a1841',
            description: descriptionvar,
            amount: parseInt(amountval),
            currency: 'RUB',
            invoiceId: invoiceId,
            accountId: email,
            skin: "modern",
            data: {
                myProp: 'myProp value'
            }
        },
        {
            onSuccess: function (options) {

                invoiceId = options.invoiceId;
                //dataid = $('.title-service.title-service-main').attr('data-id');
                dataid = 84175;
                //inputnumbermod = $('.input-number-mod').val();
                inputnumbermod = 1;
                console.log(invoiceId+' '+dataid+' '+inputnumbermod+' '+resultid);
                $.ajax({
                    url: my_ajax_object.ajax_url,
                    type: 'POST',
                    data: 'action=card_pay_for_service&invoceid='+invoiceId+'&resultid='+resultid+'&dataid='+dataid+'&inputnumbermod='+inputnumbermod,
                    beforeSend: function(xhr) {
                    },
                    success: function(data) {
                        result = $.parseJSON(data);
                        //location.reload();
                    }
                });
            },
            onFail: function (reason, options) {
                //location.reload();
            },
            onComplete: function (paymentResult, options) {
            }
        }
    )
};

function card_before(clickarg = '',val = 'val',pay = 'pay'){
    if (val == 'val') {
        amountval = Math.abs(parseInt($(clickarg).val()));
    } else {
        amountval = Math.abs(parseInt($(clickarg).attr('data-price')));;
    }

    if ((amountval != "") && (amountval != "0") && (amountval != 0) && (!(isNaN(amountval)))) {
        alert(amountval);
        alert(pay);
        if (pay == 'pay') {
        if (amountval > 399) {
            if ($('input[name="payfrombalance"]').is(':checked')) {
                pay_from_balance();
            } else {
                $.ajax({
                    url: my_ajax_object.ajax_url,
                    type: 'POST',
                    data: 'action=card_before&amountval=' + amountval,
                    beforeSend: function (xhr) {
                    },
                    success: function (data) {
                        result = $.parseJSON(data);
                        resultid = result.id;
                        $.ajax({
                            url: my_ajax_object.ajax_url,
                            type: 'POST',
                            data: 'action=get_more_info',
                            beforeSend: function (xhr) {
                            },
                            success: function (data) {
                                result = $.parseJSON(data);
                                invoiceId = parseInt(result.time);
                                email = result.email;
                                if (pay == 'pay') {
                                    $('.bycardfunc').click();
                                } else if (pay == 'pay2') {
                                    if ($('input[name="payfrombalance"]').is(':checked')) {
                                        pay_from_balance();
                                    } else {
                                        $('.bycardfunc2').click();
                                    }
                                    $('.popup_close_button[data-close="popup_edit_user_form"]').click();
                                }

                            }
                        });

                    }
                });
            }
        } else {
            popup_alert_message('Укажите сумму выше 400 рублей', 'error');
        }
    }

    } else {
        popup_alert_message('Не указана сумма','error');
    }
}

$(document).ready(function () {
    $('body').on('click', '.popup_service__paybtn_this', function(){

        card_before('.popup_service__about[data-price]','attr','pay2');
    });

    $('body').on('click', '.send_money__footer__btn_act', function(){

        card_before('input[name="send_money__footer__amount"]','val','pay');
    });

    $( "#accept_pay" ).change(function() {
        if($(this).prop("checked")) {
            $('.send_money__footer__btn').addClass('send_money__footer__btn_act');
        } else {
            $('.send_money__footer__btn').removeClass('send_money__footer__btn_act');
        }
    });

    $('body').on('click', '.wallet_history__row__icon_card', function(){
        serviceid = 84175;
        popup_user_form('service_popup',my_ajax_object.user_id,serviceid,'card');
    });

    $('body').on('click', '.wallet_history__row__icon_balance', function(){
        serviceid = 84175;
        popup_user_form('service_popup',my_ajax_object.user_id,serviceid,'balance');
    });

    $('.bycardfunc').click(pay);
    $('.bycardfunc2').click(pay2);
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
});

function pay_from_balance() {
    dataid = 84175;
    inputnumbermod = 1;
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=balance_pay_for_service&dataid="+dataid+"&inputnumbermod="+inputnumbermod,
        beforeSend: function(xhr) {
        },
        success: function(data) {
            result = $.parseJSON(data);
            console.log(result.status);
            console.log(result.id);
        }
    });
}