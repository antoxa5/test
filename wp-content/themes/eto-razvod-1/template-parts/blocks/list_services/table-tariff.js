Date.isLeapYear = function (year) { 
return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0)); 
};

Date.getDaysInMonth = function (year, month) {
return [31, (Date.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
};

Date.prototype.isLeapYear = function () { 
return Date.isLeapYear(this.getFullYear()); 
};

Date.prototype.getDaysInMonth = function () { 
return Date.getDaysInMonth(this.getFullYear(), this.getMonth());
};

Date.prototype.addMonths = function (value) {
var n = this.getDate();
this.setDate(1);
this.setMonth(this.getMonth() + value);
this.setDate(Math.min(n, this.getDaysInMonth()));
return this;
};
function convertDate(inputFormat) {
  function pad(s) { return (s < 10) ? '0' + s : s; }
  var d = new Date(inputFormat)
  return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('/')
}

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

          $('.price2, .show-new-window-need > .show-new-window-inside').text(    parseInt(el[0].value) * parseInt($('.title-service').attr('data-price'))    );


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
                    
                    if ((parseInt(el[0].value) * parseInt($('.title-service').attr('data-price'))) <= parseInt($('.balancer').text())) {
                    $('.buy-from-balance').attr('style','display:block');
                    $('.buy-from-card').attr('style','display:none');
                    $('.buycardlink').attr('style','display:none');
                    $('.no-balance').attr('style','display:none');
                    $('#balancer_main_wrapper').css('display','block');
                    $('span.price2.pricer3.pricer5.pricer6').parent().css('display','block');

                            if ($('input[name="payfrombalance"]').is(':checked') == false) {
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            $('.buy-from-card').attr('style','display:block');
            $('.buy-from-balance').attr('style','display:none');
            paytype = 'onespay';
            $('span.nonebalance.nonebalance_last > span:first-child').text( parseInt(el[0].value) * parseInt($('.title-service').attr('data-price')) );
        } else {
            //paytype = 'twospay';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $('.buy-from-card').attr('style','display:none');
            $('.buy-from-balance').attr('style','display:block');
        } 

                    } else {
                    $('.buy-from-balance').attr('style','display:none');
                    $('.buy-from-card').attr('style','display:block');
                    $('.buycardlink').attr('style','display:block');

                    $('#balancer_main_wrapper').css('display','none');
                    $('span.price2.pricer3.pricer5.pricer6').parent().css('display','none');
                    $('span.nonebalance > span:first-child').text(parseInt($('span.price2.pricer3.pricer_first_chapter').text()) - parseInt($('.balancer2ins.balancer2ins3ins').text()));
    if (parseInt($('.balancer').text()) > 0) {
        if ($('input[name="payfrombalance"]').is(':checked') == false) {
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            paytype = 'onespay';
            $('.no-balance').attr('style','display:none');
            $('span.nonebalance.nonebalance_last > span:first-child').text( parseInt(el[0].value) * parseInt($('.title-service').attr('data-price')) );
        } else {
            paytype = 'twospay';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $('.no-balance').attr('style','display:block');
        } 
    } else {
        // если у юзверя нет баланса вообще
        paytype = 'onespay';
        $('.no-balance').attr('style','display:none');
        $('.payfrombalancewrap').css('display','none');
        //$('.tgw-wrapper').css('justify-content','center');
    }


                    }



        }
      }

      function increment() {
        var value = el[0].value;
        value++;
        if(!max || value <= max) {
          el[0].value = value++;
          $('.price2, .show-new-window-need > .show-new-window-inside').text(    parseInt(el[0].value) * parseInt($('.title-service').attr('data-price'))    );


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

                    if ((parseInt(el[0].value) * parseInt($('.title-service').attr('data-price'))) <= parseInt($('.balancer').text())) {
                    $('.buy-from-balance').attr('style','display:block');
                    $('.buy-from-card').attr('style','display:none');
                    $('.buycardlink').attr('style','display:none');
                    $('.no-balance').attr('style','display:none');
                    $('#balancer_main_wrapper').css('display','block');
                    $('span.price2.pricer3.pricer5.pricer6').parent().css('display','block');


                            if ($('input[name="payfrombalance"]').is(':checked') == false) {
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            $('.buy-from-card').attr('style','display:block');
            $('.buy-from-balance').attr('style','display:none');
            paytype = 'onespay';
            $('span.nonebalance.nonebalance_last > span:first-child').text( parseInt(el[0].value) * parseInt($('.title-service').attr('data-price')) );
        } else {
            //paytype = 'twospay';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $('.buy-from-card').attr('style','display:none');
            $('.buy-from-balance').attr('style','display:block');
        } 


                    } else {
                    $('.buy-from-balance').attr('style','display:none');
                    $('.buy-from-card').attr('style','display:block');
                    $('.buycardlink').attr('style','display:block');

                    $('#balancer_main_wrapper').css('display','none');
                    $('span.price2.pricer3.pricer5.pricer6').parent().css('display','none');
                    $('span.nonebalance > span:first-child').text(parseInt($('span.price2.pricer3.pricer_first_chapter').text()) - parseInt($('.balancer2ins.balancer2ins3ins').text()));
    if (parseInt($('.balancer').text()) > 0) {
        if ($('input[name="payfrombalance"]').is(':checked') == false) {
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            paytype = 'onespay';
            $('.no-balance').attr('style','display:none');
            $('span.nonebalance.nonebalance_last > span:first-child').text( parseInt(el[0].value) * parseInt($('.title-service').attr('data-price')) );
            $('span.nonebalance.nonebalance_last > span:first-child').text( parseInt(el[0].value) * parseInt($('.title-service').attr('data-price')) );
        } else {
            paytype = 'twospay';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $('.no-balance').attr('style','display:block');
        } 
    } else {
        // если у юзверя нет баланса вообще
        paytype = 'onespay';
        $('.no-balance').attr('style','display:none');
        $('.payfrombalancewrap').css('display','none');
        //$('.tgw-wrapper').css('justify-content','center');
    }

                    }


        }
      }

    }
    
  }
})();

inputNumber($('.input-number-mod'));
$(".input-number-mod").on("change paste keyup", function() {
    if ($(this).val() == '') {
        numberinputnumbermod = 1;
    } else {
        numberinputnumbermod = $(this).val();
    }

    numberinputnumbermod = Math.abs(parseInt(numberinputnumbermod));
    if (numberinputnumbermod == "0") {
        numberinputnumbermod = 1;
    }

    if (isNaN(numberinputnumbermod)) {
        numberinputnumbermod = 1;
    }
    
    $('.price2, .show-new-window-need > .show-new-window-inside').text(    parseInt(numberinputnumbermod) * parseInt($('.title-service').attr('data-price'))    );

    if ((parseInt(numberinputnumbermod) * parseInt($('.title-service').attr('data-price'))) <= parseInt($('.balancer').text())) {
    $('.buy-from-balance').attr('style','display:block');
    $('.buy-from-card').attr('style','display:none');
    $('.buycardlink').attr('style','display:none');
    $('.no-balance').attr('style','display:none');
    $('#balancer_main_wrapper').css('display','block');
    $('span.price2.pricer3.pricer5.pricer6').parent().css('display','block');
    $('.no-balance').attr('style','display:none');
    $('#balancer_main_wrapper').css('display','block');
    $('span.price2.pricer3.pricer5.pricer6').parent().css('display','block');



        if ($('input[name="payfrombalance"]').is(':checked') == false) {
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            $('.buy-from-card').attr('style','display:block');
            $('.buy-from-balance').attr('style','display:none');
            paytype = 'onespay';
        } else {
            //paytype = 'twospay';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $('.buy-from-card').attr('style','display:none');
            $('.buy-from-balance').attr('style','display:block');
        } 


    } else {
    $('.buy-from-balance').attr('style','display:none');
    $('.buy-from-card').attr('style','display:block');
    $('.buycardlink').attr('style','display:block');
    $('#balancer_main_wrapper').css('display','none');
    $('span.price2.pricer3.pricer5.pricer6').parent().css('display','none');
    $('span.nonebalance > span:first-child').text(parseInt($('span.price2.pricer3.pricer_first_chapter').text()) - parseInt($('.balancer2ins.balancer2ins3ins').text()));
    $('#balancer_main_wrapper').css('display','none');
    $('span.price2.pricer3.pricer5.pricer6').parent().css('display','none');
    $('span.nonebalance > span:first-child').text(parseInt($('span.price2.pricer3.pricer_first_chapter').text()) - parseInt($('.balancer2ins.balancer2ins3ins').text()));
    if (parseInt($('.balancer').text()) > 0) {
        if ($('input[name="payfrombalance"]').is(':checked') == false) {
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            paytype = 'onespay';
            $('.no-balance').attr('style','display:none');
            $('span.nonebalance.nonebalance_last > span:first-child').text( parseInt(el[0].value) * parseInt($('.title-service').attr('data-price')) );
        } else {
            paytype = 'twospay';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $('.no-balance').attr('style','display:block');
        } 
    } else {
        // если у юзверя нет баланса вообще
        paytype = 'onespay';
        $('.no-balance').attr('style','display:none');
        $('.payfrombalancewrap').css('display','none');
        //$('.tgw-wrapper').css('justify-content','center');
    }

    }
});

$(document).ready(function(){
    $('input[name="accept"]').change(function() {
    if($(this).is(":checked")) {
    var returnVal = "ok";
    $(this).attr("checked", returnVal);
    }
    if ($(this).is(':checked') == false) {
    $(this).parent().next().addClass('pricewrapturnedoff');
    } else {
    $(this).parent().next().removeClass('pricewrapturnedoff');
    }
    });
});

$(document).ready(function(){
        //Оплата по карте тарифа
indexvari = 0;        
$('span.buy-from-card').click(function() {
    if (paytype == 'twospay') {
        amountval = $('span.nonebalance.nonebalance_last > span:first-child').text();
        if ((amountval != "") && (amountval != "0") && (amountval != 0)) {

        if (indexvari != 1) {
        $.ajax({
        url: avatar.ajaxurl,
        type: 'POST',
        data: 'action=cardbefore&amountval='+amountval,
        beforeSend: function(xhr) {
        },
        success: function(data) {
        result = $.parseJSON(data);
        resultid = result.id;
        $('.bycardfunc3').click();
        indexvari = 1;
        $('.popup_container').attr('style','visibility: hidden !important;');
        //$('input.submit_summa').slideUp();
        //$('.formed-wrapper-input[data-step="another"]').slideUp();
        console.log('buy-from-card: cardbefore = twospay');
        }
        });
        } else {
        location.reload();
        }

        } else {
        $('.incorrect').remove();    
        $('input[data-id="amount"]').parent().after('<span class="incorrect">Некорректная сумма</span>');
        } 
    } else {
                amountval = $('span.nonebalance.nonebalance_last > span:first-child').text();
                if ((amountval != "") && (amountval != "0") && (amountval != 0)) {

                if (indexvari != 1) {
                $.ajax({
                url: avatar.ajaxurl,
                type: 'POST',
                data: 'action=cardbefore&amountval='+amountval,
                beforeSend: function(xhr) {
                },
                success: function(data) {
                result = $.parseJSON(data);
                resultid = result.id;
                $('.bycardfunc2').click();
                indexvari = 1;
                $('.popup_container').attr('style','visibility: hidden !important;');
                console.log('buy-from-card: cardbefore = onespay');
                //$('input.submit_summa').slideUp();
                //$('.formed-wrapper-input[data-step="another"]').slideUp();
                }
                });
                } else {
                location.reload();
                }

                } else {
                $('.incorrect').remove();    
                $('input[data-id="amount"]').parent().after('<span class="incorrect">Некорректная сумма</span>');
                } 
    }

});
$('.bycardfunc2').click(pay2);
$('.bycardfunc3').click(pay3);

});

$('input[name="payfrombalance"]').change(function() {
    $('.input-number-mod-increment').click();
    $('.input-number-mod-decrement').click();
});