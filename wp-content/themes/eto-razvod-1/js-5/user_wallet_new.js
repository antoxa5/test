$ = jQuery.noConflict();


$(document).ready(function () {
    $('body').on('click', '.send_money__footer__btn', function(){
        amount = parseInt(($('input[name="send_money__footer__amount"]').val()));
        button = $(this);
        if (amount > 399) {
            button.addClass('act');
            button.append('<div class="load_ajax"></div>');
            amountParseInt = amount;
            amount = ''+amount+'.00';
            //current_userfunc
            $.ajax({
                url: my_ajax_object.ajax_url,
                type: 'POST',
                data: 'action=card_before_new&amountval=' + amountParseInt,
                beforeSend: function (xhr) {
                },
                success: function (data) {
                    result = $.parseJSON(data);
                    email = result.email;
                    userid_new = result.userid;
                    trans_id = result.trans_id;
                    id = result.id;

                    $.ajax({
                        type: "POST",
                        url: 'https://eto-razvod.ru/yookassa/payer.php',
                        data: {amount: amount, email: email, userid: userid_new, trans_id: trans_id, id: id},
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
            popup_alert_message('Укажите сумму выше 400 рублей',"error");
        }
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
});