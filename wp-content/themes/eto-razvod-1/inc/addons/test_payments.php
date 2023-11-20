<?php

add_action( 'wp_ajax_show_popup_serice_pager', 'show_popup_serice_pager' );
add_action( 'wp_ajax_nopriv_show_popup_serice_pager', 'show_popup_serice_pager' );


function show_popup_serice_pager() {
	$service_id = htmlspecialchars($_POST['id']);
	$balancer = intval(get_field('balance','user_'.get_current_user_id()));
	if ($balancer == '') {
		$balancer = 0;
	}
	$pageid = htmlspecialchars($_POST['pageid']);
//if ((intval($pageid) == 98260) || (intval($pageid) == 88311)) {
	if($service_id != '') {
		if ((    get_field('price',intval($service_id))    )) {
			$getprice = get_field('price',intval($service_id));
			if ($getprice != '') { ?>
				<?php //$num .= '<script src="/wp-content/themes/eto-razvod-1/template-parts/blocks/list_services/table-tariff.js"></script>'; ?>
				<?php $num .= '<script>Date.isLeapYear = function (year) { 
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
  function pad(s) { return (s < 10) ? \'0\' + s : s; }
  var d = new Date(inputFormat)
  return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join(\'/\')
}

(function() {
 
  window.inputNumber = function(el) {

    var min = el.attr(\'min\') || false;
    var max = el.attr(\'max\') || false;

    var els = {};

    els.dec = el.prev();
    els.inc = el.next();

    el.each(function() {
      init($(this));
    });

    function init(el) {

      els.dec.on(\'click\', decrement);
      els.inc.on(\'click\', increment);

      function decrement() {
        var value = el[0].value;
        value--;
        if(!min || value >= min) {
          el[0].value = value;

          $(\'.price2, .show-new-window-need > .show-new-window-inside\').text(    parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\'))    );


                    if ((parseInt(el[0].value)) == 1) {
                    $(\'.sklon\').text(\'\');
                    } else if (((parseInt(el[0].value)) == 2) || ((parseInt(el[0].value)) == 3) || ((parseInt(el[0].value)) == 4)) {
                    $(\'.sklon\').text(\'а\');
                    } else if (((parseInt(el[0].value)) == 5) || ((parseInt(el[0].value)) == 6) || ((parseInt(el[0].value)) == 7) || ((parseInt(el[0].value)) == 8) || ((parseInt(el[0].value)) == 9) || ((parseInt(el[0].value)) == 0)) {
                    $(\'.sklon\').text(\'ев\');
                    }

                    if ( (parseInt(el[0].value) < 20) &&  (parseInt(el[0].value) > 9)) {
                    $(\'.sklon\').text(\'ев\');
                    } else if ( (parseInt(el[0].value) > 20)) {
                    if ((parseInt(el[0].value) % 10) == 1) {
                    $(\'.sklon\').text(\'\');
                    } else if (((parseInt(el[0].value) % 10) == 2) || ((parseInt(el[0].value) % 10) == 3) || ((parseInt(el[0].value) % 10) == 4)) {
                    $(\'.sklon\').text(\'а\');
                    } else if (((parseInt(el[0].value) % 10) == 5) || ((parseInt(el[0].value) % 10) == 6) || ((parseInt(el[0].value) % 10) == 7) || ((parseInt(el[0].value) % 10) == 8) || ((parseInt(el[0].value) % 10) == 9) || ((parseInt(el[0].value) % 10) == 0)) {
                    $(\'.sklon\').text(\'ев\');
                    }
                    }
                    
                    if ((parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\'))) <= parseInt($(\'.balancer\').text())) {
                    $(\'.buy-from-balance\').attr(\'style\',\'display:block\');
                    $(\'.buy-from-card\').attr(\'style\',\'display:none\');
                    $(\'.buycardlink\').attr(\'style\',\'display:none\');
                    $(\'.no-balance.texterb,.frombalanceandcard\').attr(\'style\',\'display:none\');$(\'.frombalance\').attr(\'style\',\'display:block\');$(\'.fromcard\').attr(\'style\',\'display:none\');
                    $(\'#balancer_main_wrapper\').css(\'display\',\'block\');
                    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'block\');

                            if ($(\'input[name="payfrombalance"]\').is(\':checked\') == false) {
                                $(\'.fromcardjs\').css(\'display\',\'block\');$(\'#balancer_main_wrapper\').css(\'display\',\'block\');
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            $(\'.buy-from-card\').attr(\'style\',\'display:block\');
            $(\'.buy-from-balance\').attr(\'style\',\'display:none\');
            paytype = \'onespay\';
            $(\'.fromcard, .frombalance, .frombalanceandcard\').css(\'display\',\'none\');
            $(\'span.nonebalance.nonebalance_last > span:first-child\').text( parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\')) );

        } else {
            //paytype = \'twospay\';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $(\'.fromcardjs\').css(\'display\',\'none\');
            $(\'.buy-from-card\').attr(\'style\',\'display:none\');
            $(\'.buy-from-balance\').attr(\'style\',\'display:block\');
        } 

                    } else {
                    $(\'.buy-from-balance\').attr(\'style\',\'display:none\');
                    $(\'.buy-from-card\').attr(\'style\',\'display:block\');
                    $(\'.buycardlink\').attr(\'style\',\'display:block\');

                    $(\'#balancer_main_wrapper\').css(\'display\',\'none\');
                    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'none\');
                    $(\'span.nonebalance > span:first-child,.show-new-window-not-have>span:first-child\').text(parseInt($(\'span.price2.pricer3.pricer_first_chapter\').text()) - parseInt($(\'.balancer2ins.balancer2ins3ins\').text()));
    if (parseInt($(\'.balancer\').text()) > 0) {
        if ($(\'input[name="payfrombalance"]\').is(\':checked\') == false) {
            $(\'.fromcardjs\').css(\'display\',\'block\');$(\'#balancer_main_wrapper\').css(\'display\',\'block\');
            $(\'.frombalance\').attr(\'style\',\'display:none\');$(\'.fromcard\').attr(\'style\',\'display:none\');
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            paytype = \'onespay\';
            $(\'.no-balance.texterb,.frombalanceandcard\').attr(\'style\',\'display:none\');
            $(\'.frombalance\').attr(\'style\',\'display:none\');$(\'.fromcard\').attr(\'style\',\'display:none\');
            $("#testfieldwrapper2priced").attr("style","display:flex");
            $(\'span.nonebalance.nonebalance_last > span:first-child\').text( parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\')) );
            $(\'.fromcard, .frombalance, .frombalanceandcard\').css(\'display\',\'none\');
        } else {
            paytype = \'twospay\';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $(\'.fromcardjs\').css(\'display\',\'none\');
            $(\'.no-balance.texterb,.frombalanceandcard\').attr(\'style\',\'display:block\');
            $(\'.frombalance\').attr(\'style\',\'display:none\');$(\'.fromcard\').attr(\'style\',\'display:none\');
            $("#testfieldwrapper2priced").attr("style","display:none");
        } 
    } else {
        // если у юзверя нет баланса вообще
        paytype = \'onespay\';
        $(\'.no-balance.texterb,.frombalanceandcard\').attr(\'style\',\'display:none\');
        $(\'.frombalance\').attr(\'style\',\'display:none\');$(\'.fromcard\').attr(\'style\',\'display:block\');
        $(\'.payfrombalancewrap\').css(\'display\',\'none\');
        //$(\'.tgw-wrapper\').css(\'justify-content\',\'center\');
        $("#testfieldwrapper2priced").attr("style","display:flex");
    }


                    }



        }
      }

      function increment() {
        var value = el[0].value;
        value++;
        if(!max || value <= max) {
          el[0].value = value++;
          $(\'.price2, .show-new-window-need > .show-new-window-inside\').text(    parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\'))    );


                if ((parseInt(el[0].value)) == 1) {
                $(\'.sklon\').text(\'\');
                } else if (((parseInt(el[0].value)) == 2) || ((parseInt(el[0].value)) == 3) || ((parseInt(el[0].value)) == 4)) {
                $(\'.sklon\').text(\'а\');
                } else if (((parseInt(el[0].value)) == 5) || ((parseInt(el[0].value)) == 6) || ((parseInt(el[0].value)) == 7) || ((parseInt(el[0].value)) == 8) || ((parseInt(el[0].value)) == 9) || ((parseInt(el[0].value)) == 0)) {
                $(\'.sklon\').text(\'ев\');
                }

                if ( (parseInt(el[0].value) < 20) &&  (parseInt(el[0].value) > 9)) {
                $(\'.sklon\').text(\'ев\');
                } else if ( (parseInt(el[0].value) > 20)) {
                if ((parseInt(el[0].value) % 10) == 1) {
                $(\'.sklon\').text(\'\');
                } else if (((parseInt(el[0].value) % 10) == 2) || ((parseInt(el[0].value) % 10) == 3) || ((parseInt(el[0].value) % 10) == 4)) {
                $(\'.sklon\').text(\'а\');
                } else if (((parseInt(el[0].value) % 10) == 5) || ((parseInt(el[0].value) % 10) == 6) || ((parseInt(el[0].value) % 10) == 7) || ((parseInt(el[0].value) % 10) == 8) || ((parseInt(el[0].value) % 10) == 9) || ((parseInt(el[0].value) % 10) == 0)) {
                $(\'.sklon\').text(\'ев\');
                }
                }

                    if ((parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\'))) <= parseInt($(\'.balancer\').text())) {
                    $(\'.buy-from-balance\').attr(\'style\',\'display:block\');

                    $(\'.buy-from-card\').attr(\'style\',\'display:none\');
                    $(\'.buycardlink\').attr(\'style\',\'display:none\');
                    $(\'.no-balance.texterb,.frombalanceandcard\').attr(\'style\',\'display:none\');
                    $(\'.frombalance\').attr(\'style\',\'display:block\');$(\'.fromcard\').attr(\'style\',\'display:none\');
                    $(\'#balancer_main_wrapper\').css(\'display\',\'block\');
                    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'block\');
                    $("#testfieldwrapper2priced").attr("style","display:flex");

                            if ($(\'input[name="payfrombalance"]\').is(\':checked\') == false) {
                                $(\'.fromcardjs\').css(\'display\',\'block\');$(\'#balancer_main_wrapper\').css(\'display\',\'block\');
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            $(\'.buy-from-card\').attr(\'style\',\'display:block\');
            $(\'.buy-from-balance\').attr(\'style\',\'display:none\');
            paytype = \'onespay\';
            $(\'span.nonebalance.nonebalance_last > span:first-child\').text( parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\')) );
            $(\'.fromcard, .frombalance, .frombalanceandcard\').css(\'display\',\'none\');
        } else {
            //paytype = \'twospay\';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $(\'.fromcardjs\').css(\'display\',\'none\');
            $(\'.buy-from-card\').attr(\'style\',\'display:none\');
            $(\'.buy-from-balance\').attr(\'style\',\'display:block\');
        } 


                    } else {
                    $(\'.buy-from-balance\').attr(\'style\',\'display:none\');
                    $(\'.buy-from-card\').attr(\'style\',\'display:block\');
                    $(\'.buycardlink\').attr(\'style\',\'display:block\');

                    $(\'#balancer_main_wrapper\').css(\'display\',\'none\');
                    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'none\');
                    $(\'span.nonebalance > span:first-child,.show-new-window-not-have>span:first-child\').text(parseInt($(\'span.price2.pricer3.pricer_first_chapter\').text()) - parseInt($(\'.balancer2ins.balancer2ins3ins\').text()));
    if (parseInt($(\'.balancer\').text()) > 0) {
        if ($(\'input[name="payfrombalance"]\').is(\':checked\') == false) {
            $(\'.fromcardjs\').css(\'display\',\'block\');$(\'#balancer_main_wrapper\').css(\'display\',\'block\');
            $(\'.frombalance\').attr(\'style\',\'display:none\');$(\'.fromcard\').attr(\'style\',\'display:none\');
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            paytype = \'onespay\';
            $(\'.no-balance.texterb,.frombalanceandcard\').attr(\'style\',\'display:none\');
            $(\'.frombalance\').attr(\'style\',\'display:none\');$(\'.fromcard\').attr(\'style\',\'display:none\');
            $(\'span.nonebalance.nonebalance_last > span:first-child\').text( parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\')) );
            $(\'span.nonebalance.nonebalance_last > span:first-child\').text( parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\')) );
            $("#testfieldwrapper2priced").attr("style","display:flex");
        } else {
            paytype = \'twospay\';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $(\'.fromcardjs\').css(\'display\',\'none\');
            $(\'.no-balance.texterb,.frombalanceandcard\').attr(\'style\',\'display:block\');
            $(\'.frombalance\').attr(\'style\',\'display:none\');$(\'.fromcard\').attr(\'style\',\'display:none\');
            $("#testfieldwrapper2priced").attr("style","display:none");
        } 
    } else {
        // если у юзверя нет баланса вообще
        paytype = \'onespay\';
        $(\'.no-balance.texterb,.frombalanceandcard\').attr(\'style\',\'display:none\');
        $(\'.frombalance\').attr(\'style\',\'display:none\');$(\'.fromcard\').attr(\'style\',\'display:block\');
        $(\'.payfrombalancewrap\').css(\'display\',\'none\');
        //$(\'.tgw-wrapper\').css(\'justify-content\',\'center\');
        $("#testfieldwrapper2priced").attr("style","display:flex");
    }

                    }


        }
      }

    }
    
  }
})();

inputNumber($(\'.input-number-mod\'));
$(".input-number-mod").on("change paste keyup", function() {
    if ($(this).val() == \'\') {
        numberinputnumbermod = 1;
    } else {
        numberinputnumbermod = $(this).val();
    }

 if ((numberinputnumbermod) == 1) {
                    $(\'.sklon\').text(\'\');
                    } else if (((numberinputnumbermod) == 2) || ((numberinputnumbermod) == 3) || ((numberinputnumbermod) == 4)) {
                    $(\'.sklon\').text(\'а\');
                    } else if (((numberinputnumbermod) == 5) || ((numberinputnumbermod) == 6) || ((numberinputnumbermod) == 7) || ((numberinputnumbermod) == 8) || ((numberinputnumbermod) == 9) || ((numberinputnumbermod) == 0)) {
                    $(\'.sklon\').text(\'ев\');
                    }

                    if ( (numberinputnumbermod < 20) &&  (numberinputnumbermod > 9)) {
                    $(\'.sklon\').text(\'ев\');
                    } else if ( (numberinputnumbermod > 20)) {
                    if ((numberinputnumbermod % 10) == 1) {
                    $(\'.sklon\').text(\'\');
                    } else if (((numberinputnumbermod % 10) == 2) || ((numberinputnumbermod % 10) == 3) || ((numberinputnumbermod % 10) == 4)) {
                    $(\'.sklon\').text(\'а\');
                    } else if (((numberinputnumbermod % 10) == 5) || ((numberinputnumbermod % 10) == 6) || ((numberinputnumbermod % 10) == 7) || ((numberinputnumbermod % 10) == 8) || ((numberinputnumbermod % 10) == 9) || ((numberinputnumbermod % 10) == 0)) {
                    $(\'.sklon\').text(\'ев\');
                    }
                    }

                    
    numberinputnumbermod = Math.abs(parseInt(numberinputnumbermod));
    if (numberinputnumbermod == "0") {
        numberinputnumbermod = 1;
    }

    if (isNaN(numberinputnumbermod)) {
        numberinputnumbermod = 1;
    }
    
    $(\'.price2, .show-new-window-need > .show-new-window-inside\').text(    parseInt(numberinputnumbermod) * parseInt($(\'.title-service\').attr(\'data-price\'))    );

    if ((parseInt(numberinputnumbermod) * parseInt($(\'.title-service\').attr(\'data-price\'))) <= parseInt($(\'.balancer\').text())) {
    $(\'.buy-from-balance\').attr(\'style\',\'display:block\');
    $(\'.buy-from-card\').attr(\'style\',\'display:none\');
    $(\'.buycardlink\').attr(\'style\',\'display:none\');
    $(\'.no-balance.texterb,.frombalanceandcard\').attr(\'style\',\'display:none\');
    $(\'.frombalance\').attr(\'style\',\'display:block\');$(\'.fromcard\').attr(\'style\',\'display:none\');
    $(\'#balancer_main_wrapper\').css(\'display\',\'block\');
    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'block\');
    $(\'.no-balance.texterb,.frombalanceandcard\').attr(\'style\',\'display:none\');
    $(\'.frombalance\').attr(\'style\',\'display:block\');$(\'.fromcard\').attr(\'style\',\'display:none\');
    $(\'#balancer_main_wrapper\').css(\'display\',\'block\');
    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'block\');
    $("#testfieldwrapper2priced").attr("style","display:flex");


        if ($(\'input[name="payfrombalance"]\').is(\':checked\') == false) {
            $(\'.fromcardjs\').css(\'display\',\'block\');$(\'#balancer_main_wrapper\').css(\'display\',\'block\');
            $(\'.frombalance\').attr(\'style\',\'display:none\');$(\'.fromcard\').attr(\'style\',\'display:none\');
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            $(\'.buy-from-card\').attr(\'style\',\'display:block\');
            $(\'.buy-from-balance\').attr(\'style\',\'display:none\');
            $(\'.fromcard, .frombalance, .frombalanceandcard\').css(\'display\',\'none\');
            paytype = \'onespay\';
        } else {
            //paytype = \'twospay\';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $(\'.fromcardjs\').css(\'display\',\'none\');
            $(\'.buy-from-card\').attr(\'style\',\'display:none\');
            $(\'.buy-from-balance\').attr(\'style\',\'display:block\');
        } 


    } else {
    $(\'.buy-from-balance\').attr(\'style\',\'display:none\');
    $(\'.buy-from-card\').attr(\'style\',\'display:block\');
    $(\'.buycardlink\').attr(\'style\',\'display:block\');
    $(\'#balancer_main_wrapper\').css(\'display\',\'none\');
    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'none\');
    $(\'span.nonebalance > span:first-child,.show-new-window-not-have>span:first-child\').text(parseInt($(\'span.price2.pricer3.pricer_first_chapter\').text()) - parseInt($(\'.balancer2ins.balancer2ins3ins\').text()));
    $(\'#balancer_main_wrapper\').css(\'display\',\'none\');
    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'none\');
    $(\'span.nonebalance > span:first-child,.show-new-window-not-have>span:first-child\').text(parseInt($(\'span.price2.pricer3.pricer_first_chapter\').text()) - parseInt($(\'.balancer2ins.balancer2ins3ins\').text()));
    if (parseInt($(\'.balancer\').text()) > 0) {
        if ($(\'input[name="payfrombalance"]\').is(\':checked\') == false) {
            $(\'.fromcardjs\').css(\'display\',\'block\');$(\'#balancer_main_wrapper\').css(\'display\',\'block\');
            $(\'.frombalance\').attr(\'style\',\'display:none\');$(\'.fromcard\').attr(\'style\',\'display:none\');
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            paytype = \'onespay\';
            $(\'.no-balance.texterb,.frombalanceandcard\').attr(\'style\',\'display:none\');
            $(\'.frombalance\').attr(\'style\',\'display:none\');$(\'.fromcard\').attr(\'style\',\'display:none\');
            $(\'span.nonebalance.nonebalance_last > span:first-child\').text( parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\')) );
        } else {
            paytype = \'twospay\';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $(\'.fromcardjs\').css(\'display\',\'none\');
            $(\'.no-balance.texterb,.frombalanceandcard\').attr(\'style\',\'display:block\');
            $(\'.frombalance\').attr(\'style\',\'display:none\');$(\'.fromcard\').attr(\'style\',\'display:none\');
        } 
    } else {
        // если у юзверя нет баланса вообще
        paytype = \'onespay\';
        $(\'.no-balance.texterb,.frombalanceandcard\').attr(\'style\',\'display:none\');
        $(\'.frombalance\').attr(\'style\',\'display:none\');$(\'.fromcard\').attr(\'style\',\'display:block\');
        $(\'.payfrombalancewrap\').css(\'display\',\'none\');
        //$(\'.tgw-wrapper\').css(\'justify-content\',\'center\');
    }

    }
});

$(document).ready(function(){
    $(\'input[name="accept"]\').change(function() {
    if($(this).is(":checked")) {
    var returnVal = "ok";
    $(this).attr("checked", returnVal);
    }
    if ($(this).is(\':checked\') == false) {
    $(this).parent().next().addClass(\'pricewrapturnedoff\');
    } else {
    $(this).parent().next().removeClass(\'pricewrapturnedoff\');
    }
    });
});

$(document).ready(function(){
        //Оплата по карте тарифа
indexvari = 0;        
$(\'span.buy-from-card\').click(function() {
    if (paytype == \'twospay\') {
        amountval = $(\'span.nonebalance.nonebalance_last > span:first-child\').text();
        if ((amountval != "") && (amountval != "0") && (amountval != 0)) {

        if (indexvari != 1) {
        $.ajax({
        url: avatar.ajaxurl,
        type: \'POST\',
        data: \'action=cardbefore&amountval=\'+amountval,
        beforeSend: function(xhr) {
        },
        success: function(data) {
        result = $.parseJSON(data);
        resultid = result.id;
        $(\'.bycardfunc3\').click();
        indexvari = 1;
        $(\'.popup_container\').attr(\'style\',\'visibility: hidden !important;\');
        //$(\'input.submit_summa\').slideUp();
        //$(\'.formed-wrapper-input[data-step="another"]\').slideUp();
        console.log(\'buy-from-card: cardbefore = twospay\');
        }
        });
        } else {
        location.reload();
        }

        } else {
        $(\'.incorrect\').remove();    
        $(\'input[data-id="amount"]\').parent().after(\'<span class="incorrect">Некорректная сумма</span>\');
        } 
    } else {
                amountval = $(\'span.nonebalance.nonebalance_last > span:first-child\').text();
                if ((amountval != "") && (amountval != "0") && (amountval != 0)) {

                if (indexvari != 1) {
                $.ajax({
                url: avatar.ajaxurl,
                type: \'POST\',
                data: \'action=cardbefore&amountval=\'+amountval,
                beforeSend: function(xhr) {
                },
                success: function(data) {
                result = $.parseJSON(data);
                resultid = result.id;
                $(\'.bycardfunc2\').click();
                indexvari = 1;
                $(\'.popup_container\').attr(\'style\',\'visibility: hidden !important;\');
                console.log(\'buy-from-card: cardbefore = onespay\');
                //$(\'input.submit_summa\').slideUp();
                //$(\'.formed-wrapper-input[data-step="another"]\').slideUp();
                }
                });
                } else {
                location.reload();
                }

                } else {
                $(\'.incorrect\').remove();    
                $(\'input[data-id="amount"]\').parent().after(\'<span class="incorrect">Некорректная сумма</span>\');
                } 
    }

});
$(\'.bycardfunc2\').click(pay2);
$(\'.bycardfunc3\').click(pay3);

});

$(\'input[name="payfrombalance"]\').change(function() {
    $(\'.input-number-mod-increment\').click();
    $(\'.input-number-mod-decrement\').click();
});</script>'; ?>
				<?php if ((get_field("services_user_services","user_".get_current_user_id())[0] == intval($service_id)) || (get_field("services_user_services","user_".get_current_user_id()) == intval($service_id))) {
					////////////////////////Продление тарифа
					// $paytype = 'Продление тарифа';
					//     if ($balancer == 0) {
					//         $paytype = 'Продление тарифа по карте';
					//     } elseif ($balancer >= intval(get_field('price',intval($service_id)))    ) {
					//         $paytype = 'Продление тарифа по балансу';

					//         $windowpayfirst = '<span class="show-new-window" style="display:block"  title-attr-1="Продление тарифа" title-attr-2="Подтверждение операции" title-attr-3="Успешное продление тарифа">
					// Для продления тарифа вам нужно <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>
					// На балансе вашего аккаунта на данный момент есть <span class="inlinebeen"><span class="show-new-window-now"><span class="show-new-window-inside">'.$balancer.'</span> <span class="rur">a</span></span> .</span><br>
					// Вы можете переходить к оплате продления тарифа.
					// </span>
					// <span class="last-row-about-pay">Оплатить <span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span>  <span class="rur">a</span></span> для продления тарифа <span class="tariffname">'.get_the_title($service_id).'</span></span>';
					// $additional = '<span class="line-second">Стоимость продления тарифа <span class="tariffname">'.get_the_title($service_id).'</span> - <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>Эта сумма будет списана с баланса вашего аккаунта.</span>';

					//     } else {
					//         $paytype = 'Продление тарифа по балансу + карте';
					//     }

					$paytype = 'fromcardjs';

					$windowpayfirst .= '<span class="show-new-window fromcardjs" title-attr-1="Продление тарифа" title-attr-2="Подтверждение операции" title-attr-3="Подтверждение операции" style="display:none;">
Для продления тарифа вам нужно <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>
<span class="show-new-window-now" style="display:none"><span class="show-new-window-inside">'.$balancer.'</span> <span class="rur">a</span></span>
Вы можете оплатить эту операцию с банковской карты.
</span>
<span class="last-row-about-pay fromcardjs" style="display:none;">Оплатить <span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span>  <span class="rur">a</span></span> для продления тарифа <span class="tariffname">'.get_the_title($service_id).'</span></span>';
					$additional .= '<span class="line-second fromcardjs"  style="display:none;">Стоимость продления тарифа <span class="tariffname">'.get_the_title($service_id).'</span> - <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> будет списано с вашей банковской карты.</span>';


					$paytype = 'fromcard';
					if ($balancer == 0) {
						$css1 = "display:block";
					} else {
						$css1 = "display:none";
					}
					$windowpayfirst .= '<span class="show-new-window fromcard" title-attr-1="Продление тарифа" title-attr-2="Подтверждение операции" title-attr-3="Подтверждение операции" style="'.$css1.'">
Для продления тарифа вам нужно <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>
На балансе вашего аккаунта нет средств. <span class="show-new-window-now" style="display:none"><span class="show-new-window-inside">'.$balancer.'</span> <span class="rur">a</span></span><br>
Вы можете оплатить продление тарифа банковской картой.
</span>
<span class="last-row-about-pay fromcard" style="'.$css1.'">Оплатить <span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span>  <span class="rur">a</span></span> для продления тарифа <span class="tariffname">'.get_the_title($service_id).'</span></span>';
					$additional .= '<span class="line-second fromcard"  style="'.$css1.'">Стоимость продления тарифа <span class="tariffname">'.get_the_title($service_id).'</span> - <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>Эта сумма будет списана с вашей банковской карты.</span>';



					//} elseif ($balancer >= intval(get_field('price',intval($service_id)))    ) {

					if ($balancer >= intval(get_field('price',intval($service_id)))) {
						$css2 = "display:block";
					} else {
						$css2 = "display:none";
					}
					$paytype .= 'frombalance';

					$windowpayfirst .= '<span class="show-new-window frombalance" title-attr-1="Продление тарифа" title-attr-2="Подтверждение операции" title-attr-3="Успешное продление тарифа" style="'.$css2.'">
Для продления тарифа вам нужно <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>
На балансе вашего аккаунта на данный момент есть <span class="inlinebeen"><span class="show-new-window-now"><span class="show-new-window-inside">'.$balancer.'</span> <span class="rur">a</span></span> .</span><br>
Вы можете переходить к оплате продления тарифа.
</span>
<span class="last-row-about-pay frombalance" style="'.$css2.'">Оплатить <span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span>  <span class="rur">a</span></span> для продления тарифа <span class="tariffname">'.get_the_title($service_id).'</span></span>';
					$additional .= '<span class="line-second frombalance" style="'.$css2.'">Стоимость продления тарифа <span class="tariffname">'.get_the_title($service_id).'</span> - <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>Эта сумма будет списана с баланса вашего аккаунта.</span>';

					//} else {
					$paytype .= 'frombalanceandcard';

					if (($css1 == "display:none") && ($css2 == "display:none")) {
						$css3 = "display:block";
					} else {
						$css3 = "display:none";
					}

					$windowpayfirst .= '<span class="show-new-window frombalanceandcard" title-attr-1="Продление тарифа" title-attr-2="Подтверждение операции" title-attr-3="Подтверждение операции" style="'.$css3.'">
Для продления тарифа вам нужно <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>
На балансе вашего аккаунта на данный момент есть <span class="inlinebeen"><span class="show-new-window-now"><span class="show-new-window-inside">'.$balancer.'</span> <span class="rur">a</span></span> .</span><br>
Недостающую сумму <span class="show-new-window-not-have"><span class="show-new-window-inside"></span> <span class="rur">a</span></span> вы можете оплатить банковской картой. 
</span>
<span  style="'.$css3.'" class="last-row-about-pay frombalanceandcard">Оплатить <span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span>  <span class="rur">a</span></span> для продления тарифа <span class="tariffname">'.get_the_title($service_id).'</span></span>';
					$additional .= '<span style="'.$css3.'" class="line-second frombalanceandcard">Стоимость продления тарифа <span class="tariffname">'.get_the_title($service_id).'</span> - <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span></span>';


					////////////////////////
				} elseif ((  ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ||
				              (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) &&
				             (intval($service_id) == 84178)    )) {
					////////////////////////2Переход тарифа
// $paytype = 'Переход тарифа';

//     if ($balancer == 0) {
//             $paytype = 'Переход тарифа по карте';
//         } elseif ($balancer >= intval(get_field('price',intval($service_id)))    ) {
//             $paytype = 'Переход тарифа по балансу';

//             $windowpayfirst = '<span class="show-new-window" style="display:block"  title-attr-1="Обновление тарифа" title-attr-2="Подтверждение операции" title-attr-3="Успешное обновление тарифа">
//     Для обновления тарифа вам нужно <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>
//     На балансе вашего аккаунта на данный момент есть <span class="inlinebeen"><span class="show-new-window-now"><span class="show-new-window-inside">'.$balancer.'</span> <span class="rur">a</span></span> .</span><br>
//     Вы можете переходить к оплате обновления тарифа.
//     </span>
//     <span class="last-row-about-pay">Оплатить <span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span>  <span class="rur">a</span></span> для обновления тарифа <span class="tariffname">'.get_the_title($service_id).'</span></span>';
//     $additional = '<br><span class="line-second">Стоимость обновления тарифа <span class="tariffname">'.get_the_title($service_id).'</span> - <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>Эта сумма будет списана с баланса вашего аккаунта.</span>';

//         } else {
//             $paytype = 'Переход тарифа по балансу + карте';
//         }


					$paytype = 'fromcardjs';

					$windowpayfirst .= '<span class="show-new-window fromcardjs" title-attr-1="Обновление тарифа" title-attr-2="Подтверждение операции" title-attr-3="Подтверждение операции" style="display:none;">
Для обновления тарифа вам нужно <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>
<span class="show-new-window-now" style="display:none;"><span class="show-new-window-inside">'.$balancer.'</span> <span class="rur">a</span></span>
Вы можете оплатить эту операцию с банковской карты.
</span>
<span class="last-row-about-pay fromcardjs" style="display:none;">Оплатить <span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span>  <span class="rur">a</span></span> для обновления тарифа <span class="tariffname">'.get_the_title($service_id).'</span></span>';
					$additional .= '<span class="line-second fromcardjs"  style="display:none;">Стоимость обновления тарифа <span class="tariffname">'.get_the_title($service_id).'</span> - <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> будет списано с вашей банковской карты.</span>';

					//if ($balancer == 0) {
					$paytype = 'fromcard';
					if ($balancer == 0) {
						$css1 = "display:block";
					} else {
						$css1 = "display:none";
					}
					$windowpayfirst .= '<span class="show-new-window fromcard" title-attr-1="Обновление тарифа" title-attr-2="Подтверждение операции" title-attr-3="Подтверждение операции" style="'.$css1.'">
Для обновления тарифа вам нужно <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>
На балансе вашего аккаунта нет средств<span class="show-new-window-now" style="display:none;"><span class="show-new-window-inside">'.$balancer.'</span> <span class="rur">a</span></span>.<br>
Вы можете оплатить активацию тарифа банковской картой.
</span>
<span class="last-row-about-pay fromcard" style="'.$css1.'">Оплатить <span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span>  <span class="rur">a</span></span> для обновления тарифа <span class="tariffname">'.get_the_title($service_id).'</span></span>';
					$additional .= '<span class="line-second fromcard"  style="'.$css1.'">Стоимость обновления тарифа <span class="tariffname">'.get_the_title($service_id).'</span> - <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>Эта сумма будет списана с вашей банковской карты.</span>';



					//} elseif ($balancer >= intval(get_field('price',intval($service_id)))    ) {

					if ($balancer >= intval(get_field('price',intval($service_id)))) {
						$css2 = "display:block";
					} else {
						$css2 = "display:none";
					}
					$paytype .= 'frombalance';

					$windowpayfirst .= '<span class="show-new-window frombalance" title-attr-1="Обновление тарифа" title-attr-2="Подтверждение операции" title-attr-3="Успешное обновление тарифа" style="'.$css2.'">
Для обновления тарифа вам нужно <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>
На балансе вашего аккаунта на данный момент есть <span class="inlinebeen"><span class="show-new-window-now"><span class="show-new-window-inside">'.$balancer.'</span> <span class="rur">a</span></span> .</span><br>
Вы можете переходить к оплате обновления тарифа.
</span>
<span class="last-row-about-pay frombalance" style="'.$css2.'">Оплатить <span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span>  <span class="rur">a</span></span> для обновления тарифа <span class="tariffname">'.get_the_title($service_id).'</span></span>';
					$additional .= '<span class="line-second frombalance" style="'.$css2.'">Стоимость обновления тарифа <span class="tariffname">'.get_the_title($service_id).'</span> - <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>Эта сумма будет списана с баланса вашего аккаунта.</span>';

					//} else {
					$paytype .= 'frombalanceandcard';

					if (($css1 == "display:none") && ($css2 == "display:none")) {
						$css3 = "display:block";
					} else {
						$css3 = "display:none";
					}

					$windowpayfirst .= '<span class="show-new-window frombalanceandcard" title-attr-1="Обновление тарифа" title-attr-2="Подтверждение операции" title-attr-3="Подтверждение операции" style="'.$css3.'">
Для обновления тарифа вам нужно <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>
На балансе вашего аккаунта на данный момент есть <span class="inlinebeen"><span class="show-new-window-now"><span class="show-new-window-inside">'.$balancer.'</span> <span class="rur">a</span></span> .</span><br>
Недостающую сумму <span class="show-new-window-not-have"><span class="show-new-window-inside"></span> <span class="rur">a</span></span> вы можете оплатить банковской картой. 
</span>
<span  style="'.$css3.'" class="last-row-about-pay frombalanceandcard">Оплатить <span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span>  <span class="rur">a</span></span> для обновления тарифа <span class="tariffname">'.get_the_title($service_id).'</span></span>';
					$additional .= '<span style="'.$css3.'" class="line-second frombalanceandcard">Стоимость обновления тарифа <span class="tariffname">'.get_the_title($service_id).'</span> - <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span></span>';

////////////////////////2
				} else {
					////////////////////////3
					//if ($balancer == 0) {



					$paytype = 'fromcardjs';

					$windowpayfirst .= '<span class="show-new-window fromcardjs" title-attr-1="Активация тарифа" title-attr-2="Подтверждение операции" title-attr-3="Подтверждение операции" style="display:none;">
Для активации тарифа вам нужно <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>
<span class="show-new-window-now" style="display:none;"><span class="show-new-window-inside">'.$balancer.'</span> <span class="rur">a</span></span>
Вы можете оплатить эту операцию с банковской карты.
</span>
<span class="last-row-about-pay fromcardjs" style="display:none;">Оплатить <span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span>  <span class="rur">a</span></span> для активации тарифа <span class="tariffname">'.get_the_title($service_id).'</span></span>';
					$additional .= '<span class="line-second fromcardjs"  style="display:none;">Стоимость активации тарифа <span class="tariffname">'.get_the_title($service_id).'</span> - <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> будет списано с вашей банковской карты.</span>';


					$paytype = 'fromcard';
					if ($balancer == 0) {
						$css1 = "display:block";
					} else {
						$css1 = "display:none";
					}
					$windowpayfirst .= '<span class="show-new-window fromcard" title-attr-1="Активация тарифа" title-attr-2="Подтверждение операции" title-attr-3="Подтверждение операции" style="'.$css1.'">
Для активации тарифа вам нужно <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>
На балансе вашего аккаунта нет средств<span class="show-new-window-now" style="display:none;"><span class="show-new-window-inside">'.$balancer.'</span> <span class="rur">a</span></span>.<br>
Вы можете пополнить баланс банковской картой.
</span>
<span class="last-row-about-pay fromcard" style="'.$css1.'">Оплатить <span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span>  <span class="rur">a</span></span> для активации тарифа <span class="tariffname">'.get_the_title($service_id).'</span></span>';
					$additional .= '<span class="line-second fromcard"  style="'.$css1.'">Стоимость активации тарифа <span class="tariffname">'.get_the_title($service_id).'</span> - <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>Эта сумма будет списана с вашей банковской карты.</span>';



					//} elseif ($balancer >= intval(get_field('price',intval($service_id)))    ) {

					if ($balancer >= intval(get_field('price',intval($service_id)))) {
						$css2 = "display:block";
					} else {
						$css2 = "display:none";
					}
					$paytype .= 'frombalance';

					$windowpayfirst .= '<span class="show-new-window frombalance" title-attr-1="Активация тарифа" title-attr-2="Подтверждение операции" title-attr-3="Успешная активация тарифа" style="'.$css2.'">
Для активации тарифа вам нужно <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>
На балансе вашего аккаунта на данный момент есть <span class="inlinebeen"><span class="show-new-window-now"><span class="show-new-window-inside">'.$balancer.'</span> <span class="rur">a</span></span> .</span><br>
Вы можете переходить к оплате тарифа с баланса аккаунта.
</span>
<span class="last-row-about-pay frombalance" style="'.$css2.'">Оплатить <span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span>  <span class="rur">a</span></span> для активации тарифа <span class="tariffname">'.get_the_title($service_id).'</span></span>';
					$additional .= '<span class="line-second frombalance" style="'.$css2.'">Стоимость активации тарифа <span class="tariffname">'.get_the_title($service_id).'</span> - <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>Эта сумма будет списана с баланса вашего аккаунта.</span>';

					//} else {
					$paytype .= 'frombalanceandcard';

					if (($css1 == "display:none") && ($css2 == "display:none")) {
						$css3 = "display:block";
					} else {
						$css3 = "display:none";
					}

					$windowpayfirst .= '<span class="show-new-window frombalanceandcard" title-attr-1="Активация тарифа" title-attr-2="Подтверждение операции" title-attr-3="Подтверждение операции" style="'.$css3.'">
Для активации тарифа вам нужно <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span><br>
На балансе вашего аккаунта на данный момент есть <span class="inlinebeen"><span class="show-new-window-now"><span class="show-new-window-inside">'.$balancer.'</span> <span class="rur">a</span></span> .</span><br>
Недостающую сумму <span class="show-new-window-not-have"><span class="show-new-window-inside"></span> <span class="rur">a</span></span> вы можете оплатить банковской картой. 
</span>
<span  style="'.$css3.'" class="last-row-about-pay frombalanceandcard">Оплатить <span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span>  <span class="rur">a</span></span> для активации тарифа <span class="tariffname">'.get_the_title($service_id).'</span></span>';
					$additional .= '<span style="'.$css3.'" class="line-second frombalanceandcard">Стоимость активации тарифа <span class="tariffname">'.get_the_title($service_id).'</span> - <span class="inlinebeen"><span class="show-new-window-need"><span class="show-new-window-inside">'.get_field('price',intval($service_id)).'</span> <span class="rur">a</span></span> .</span></span>';
///////////////////////////////////////3
					//}

				} ?>
				<?php $num .='<div class="formed-wrapper-input" data-step="content_tariff">'; ?>
				<?php $num .= '<span class="balancer" style="display:none;">'.$balancer.'</span>'; ?>
				<?php  if ((get_field('services_user_services','user_'.get_current_user_id())[0] == intval($service_id)) || (get_field('services_user_services','user_'.get_current_user_id()) == intval($service_id))) {
					$namep = get_field('services_user_services','user_'.get_current_user_id())[0];
					$num .= '<div class="activated">На данный момент у вас активирован тариф  <span class="activated-name">'.get_the_title($namep).'</span> до <span class="activated-date">'.str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')).'</span></div>';
				} ?>
				<?php if (
				(    ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ||
				      (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) &&
				     (intval($service_id) == 84178)    )) {

					$date1 = '10-02-2021';
					$date2 = '10-06-2022';

					$ts1 = strtotime($date1);
					$ts2 = strtotime($date2);

					$year1 = date('Y', $ts1);
					$year2 = date('Y', $ts2);

					$month1 = date('m', $ts1);
					$month2 = date('m', $ts2);

					$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
					//echo $diff;

				} else {

				} ?>
				<?php  if ((get_field('services_user_services','user_'.get_current_user_id())[0] == intval($service_id)) || (get_field('services_user_services','user_'.get_current_user_id()) == intval($service_id))) {  ?>
					<?php $num .='<p class="show-usl">Вы выбрали продление тарифа <span class="title-service title-service-main" data-price="'.get_field('price',intval($service_id)).'" data-id="'.$service_id.'">'.get_the_title($service_id).'</span> на <span class="brset"></span><span class="decwrap"><span class="input-number-mod-decrement">–</span>';
					$num .='<input class="input-number-mod" type="text" value="1" min="1" max="110"><span class="input-number-mod-increment">+</span></span> <span class="takewordmonth">месяц<span class="sklon"></span></span></p>';
				} elseif (
				(    ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ||
				      (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) &&
				     (intval($service_id) == 84178)    )    ) {


					date_default_timezone_set( 'Europe/Moscow' );
					$start = strtotime(date('d-m-Y H:i:s'));
					$end = strtotime(   str_replace(    '/', '-', get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id())    )    );

					$days_between = ceil(abs($end - $start) / 86400);
					//echo $days_between;
					//echo "<br>";
					//echo '$start '.$start.' date '.date('d/m/Y H:i:s');
					//echo "<hr>";
					//echo '$end  '.$end.'services_user_add_transaction_date_before_end '.get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id());
					//echo "<hr>";
//2    ===============================================================================================
//Находим количество дней для тарифа ПРО от АКТИВАЦИИ - до даты ОКОНЧАНИЯ
					$start = strtotime(    str_replace(    '/', '-', get_field('services_user_date_activation','user_'.get_current_user_id()) )    );
					$end = strtotime(    str_replace(    '/', '-', get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()) )    );

					$days_between2 = ceil(abs($end - $start) / 86400);
					//echo $days_between2;
					//echo "<br>";
//5    ===============================================================================================
//НАХОДИМ ЦЕНУ за 1 день ПРО
// ЦЕНА ЗА ПРО * 12 / 365
					$priceforonedaypro = (intval(get_field('price', 84175)) * 12) / 365;
//6    ===============================================================================================
//Вычиляем цену (от сегодняшнего дня ДО конечного) дня для тарифа ПРО
//Шаг 1 умножаем шаг 5
					$prorealprice = $priceforonedaypro * $days_between;
//8    ===============================================================================================
//НАХОДИМ ЦЕНУ за 1 день ПРО+
// ЦЕНА ЗА ПРО+ * 12 / 365
					$priceforonedayproplus = (intval(get_field('price', 84178)) * 12) / 365;
//9    ===============================================================================================
//Вычиляем цену (от сегодняшнего дня ДО конечного) дня для тарифа ПРО+
//Шаг 1 умножаем шаг 8
					$proplusrealprice = $priceforonedayproplus * $days_between;
//10    ===============================================================================================
//РАЗНИЦА
//вычетаем из Шаг 9 - Шаг 6
					$raznica = $proplusrealprice - $prorealprice;
					update_field('secret_balance_spend_for_update',ceil($raznica),'user_'.get_current_user_id());

					$num .='<p class="show-usl">Вы выбрали обновление тарифа с <span class="go2tariffs"><span class="title-service-listed">PRO</span> <!--span class="arrowbg"><i class="fas fa-chevron-right"></i></span--> на <span class="title-service title-service-main" data-price="'.ceil($raznica).'" data-id="84178">'.get_the_title(84178).'</span></span> до ';
					$num .='<span style="display:none"><span class="brset"></span><span class="input-number-mod-decrement">–</span><input class="input-number-mod" type="text" value="1" min="1" max="110"><span class="input-number-mod-increment">+</span> <span class="takewordmonth">месяц<span class="sklon"></span></span></span>';
					$num .= '<span class="services_user_add_transaction_date_before_end">'.str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')).'</span>';

				} else {
					$num .='<p class="show-usl">Вы выбрали тариф <span class="title-service title-service-main" data-price="'.get_field('price',intval($service_id)).'" data-id="'.$service_id.'">'.get_the_title($service_id).'</span> на <span class="brset"></span><span class="dec-wrap"><span class="input-number-mod-decrement">–</span>';
					$num .='<input class="input-number-mod" type="text" value="1" min="1" max="110"><span class="input-number-mod-increment">+</span></span> <span class="takewordmonth">месяц<span class="sklon"></span></span></p>'; ?>
				<?php } ?>

				<?php $num .='<div class="tgw-wrapper"><span class="textgetterwrap">'; ?>
				<?php $num .='<input type="checkbox" name="autoupdate" checked="checked"> '; ?>
				<?php if ((get_field("services_user_services","user_".get_current_user_id())[0] == intval($service_id)) || (get_field("services_user_services","user_".get_current_user_id()) == intval($service_id))) {
					$services_user_date_activation_beta = get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id());
					$timestampstart_beta = strtotime( str_replace(    '/', '-',$services_user_date_activation_beta) );


					$datetojs = date('Y-m-d', $timestampstart_beta);
				} else {
					$datetojs = date("m/d/Y");
				} ?>
				<?php $num .='<span class="textgetter"> Автопродление тарифа 
<i class="fas fa-question">
<span class="showadvice">По истечению срока действия тарифа - мы автоматически спишем с Вашего баланса недостающую сумму. Если Вам это интересно, то оставьте опцию включенной. Позже её можно будет изменить в настройках личного кабинета</span></i></span>
</span>
<span class="textgetterwrap payfrombalancewrap"><input type="checkbox" name="payfrombalance" checked="checked"> <span class="textgetter"> Использовать баланс сайта
<!--i class="fas fa-question">
<span class="showadvice">По истечению срока действия тарифа - мы автоматически спишем с Вашего баланса недостающую сумму. Если Вам это интересно, то оставьте опцию включенной. Позже её можно будет изменить в настройках личного кабинета</span></i--></span>
</span></div>
<span class="no-balance" style="display:none;">
Данной суммы у Вас нет на балансе аккаунта<br>
На балансе Вашего аккаунта на данный момент есть <span class="balancer2"><span class="balancer2ins">'.$balancer.'</span> <span class="rur">a</span></span><br>
Вы можете оплатить недостающую сумму <span class="nonebalance"><span>'.$n = intval(get_field('price',intval($service_id))) - intval($balancer).'</span> <span class="rur">a</span></span> по карте 
</span>';
				$num .= $windowpayfirst;
				if (  ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ||
				       (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) &&
				      (intval($service_id) == 84178)    ) {



					$num .='<div class="price-wrapper price-wrapper2"><span class="price2 pricer3 pricer_first_chapter">'.ceil($raznica).'</span> <span class="name-valute">рублей</span></div>';
				} else {
					$num .='<div class="price-wrapper price-wrapper2"><span class="price2 pricer3 pricer_first_chapter">'.get_field('price',intval($service_id)).'</span> <span class="name-valute">рублей</span></div>';
				}

				$num .='<!--span class="text-l text-l2">
<input type="checkbox" name="accept" checked="checked"> 
<span class="text-wrapper-accept text-wrapper-accept-mainer">Нажимая на кнопку «Оплата», Вы автоматически соглашаетесь с <a href="https://etorazvod.ru/offer/" target="_blank">Офертой на заключение договора</a>, <a href="https://etorazvod.ru/rules/" target="_blank">Правилами пользования сервисом</a>, <a href="https://etorazvod.ru/terms-of-use/" target="_blank">Пользовательским соглашением</a> и <a href="https://etorazvod.ru/privacy-policy/" target="_blank">Политикой Конфиденциальности</a>.</span></span>
</span-->
<!--div class="pricewrap pricewrapturned">
<span class="buy-from-balance">Оплатить с баланса</span>
<span href="/balance-test/?service_id='.$service_id.'" data-mounth="" style="display:none;" class="buycardlink">Оплатить по карте</span>
</div-->

<!--div class="pricewrap pricewrapturned">
<span class="backpack getbackpack" data-back=".form-wrapper-step[data-step=&quot;step_0_1&quot;]" data-now=".formed-wrapper-input[data-step=&quot;content_tariff&quot;],.formed-wrapper-input[data-step=&quot;another&quot;]">Назад</span>

<span class="dalee" data-back=".formed-wrapper-input[data-step=&quot;accept_from_card&quot;]" data-now=".formed-wrapper-input[data-step=&quot;content_tariff&quot;],.formed-wrapper-input[data-step=&quot;another&quot;]">Далее</span>
</div-->
<div class="pricewrap pricewrapturned" style="justify-content: center;">
<!--span class="backpack getbackpack" data-back=\'.form-wrapper-step[data-step="step_0_1"]\' data-now=\'.formed-wrapper-input[data-step="content_tariff"],.formed-wrapper-input[data-step="another"]\'>Назад</span-->
<span class="dalee" data-back=\'.formed-wrapper-input[data-step="accept_from_card"]\' data-now=\'.formed-wrapper-input[data-step="content_tariff"],.formed-wrapper-input[data-step="another"]\' style="width: 100% !important;max-width: unset !important;">Далее</span>
</div>
</div>

<div class="formed-wrapper-input" data-step="accept_from_card" style="display: none;">'; ?>
				<?php if ((get_field("services_user_services","user_".get_current_user_id())[0] == intval($service_id)) || (get_field("services_user_services","user_".get_current_user_id()) == intval($service_id))) { ?>
					<?php $num .='<p class="text-balance-w" style="text-align: center;">Вы собираетесь продлить тариф <span class="title-service-accept">'.get_the_title($service_id).'</span> на <span class="mounth-dater">1 месяц</span> <span class="inlinebeen"><span class="daterealfuture">до 01/01/2021</span> .</span>   <span style="display: none;"><span class="pricer-content"></span></span>'; ?>
				<?php } elseif (  ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ||
				                   (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) &&
				                  (intval($service_id) == 84178)    ) {
					$num .='<p class="text-balance-w" style="text-align: center;">Вы собираетесь обновить тариф <span class="title-service-accept">PRO</span> на тариф <span class="title-service-accept" data-price="'.ceil($raznica).'" data-id="84178">PRO+</span> до <span class="inlinebeen"><span class="services_user_add_transaction_date_before_end">'.str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')).'</span> .</span>';
				} else { ?>
					<?php $num .='<p class="text-balance-w" style="text-align: center;">Вы собираетесь активировать тариф <span class="title-service-accept">'.get_the_title($service_id).'</span> на <span class="mounth-dater">1 месяц</span> <span class="inlinebeen"><span class="daterealfuture">до 01/01/2021</span> .</span>   <span style="display: none;"><span class="pricer-content"></span></span>'; ?>
				<?php } ?>
				<?php $num .= $additional.'</p>'; ?>
				<?php $num .='<div class="texterb no-balance"  style="display: none;">Будет списано с баланса аккаунта <span class="balancer2"><span class="balancer2ins balancer2ins3ins">'.$balancer.'</span> <span class="rur">a</span></span><br>
Будет списано с вашей банковской карты <span class="nonebalance nonebalance_last"><span>'.$n = intval(get_field('price',intval($service_id))) - intval($balancer).'</span> <span class="rur">a</span></span><div class="price-wrapper price-wrapper2" style="display: flex;"><span class="price2 pricer3 pricer5">'.get_field('price',intval($service_id)).'</span> <span class="name-valute">рублей</span></div></div>';

				if (  ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ||
				       (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) &&
				      (intval($service_id) == 84178)    ) {
					$num .= '<div class="price-wrapper price-wrapper2" style="display: flex;" id="testfieldwrapper2priced"><span class="price2 pricer3 pricer5 pricer6">'.ceil($raznica).'</span> <span class="name-valute">рублей</span></div>';
				} else {
					$num .= '<div class="price-wrapper price-wrapper2" id="testfieldwrapper2priced" style="display: flex;"><span class="price2 pricer3 pricer5 pricer6">'.get_field('price',intval($service_id)).'</span> <span class="name-valute">рублей</span></div>';
				}

				$num .= '<span class="text-l text-l2" style="display: none"><input type="checkbox" name="accept" checked="checked"> <span class="text-wrapper-accept text-wrapper-accept-mainer">Нажимая на кнопку «Оплата», Вы автоматически соглашаетесь с <a href="https://etorazvod.ru/offer/" target="_blank">Офертой на заключение договора</a>, <a href="https://etorazvod.ru/rules/" target="_blank">Правилами пользования сервисом</a>, <a href="https://etorazvod.ru/terms-of-use/" target="_blank">Пользовательским соглашением</a> и <a href="https://etorazvod.ru/privacy-policy/" target="_blank">Политикой Конфиденциальности</a>.</span></span></span>
<span class="text-l text-l2">
<input type="checkbox" name="accept" checked="checked"> 
<span class="text-wrapper-accept text-wrapper-accept-mainer">Нажимая на кнопку «Оплата», Вы автоматически соглашаетесь с <a href="https://etorazvod.ru/offer/" target="_blank">Офертой на заключение договора</a>, <a href="https://etorazvod.ru/rules/" target="_blank">Правилами пользования сервисом</a>, <a href="https://etorazvod.ru/terms-of-use/" target="_blank">Пользовательским соглашением</a> и <a href="https://etorazvod.ru/privacy-policy/" target="_blank">Политикой Конфиденциальности</a>.</span></span>
</span>
<div class="pricewrap pricewrapturned">
<span class="backpack getbackpack" data-now=\'.formed-wrapper-input[data-step="accept_from_card"]\' data-back=\'.formed-wrapper-input[data-step="content_tariff"],.formed-wrapper-input[data-step="another"]\'>Назад</span>
<span class="buy-from-balance">Оплата</span>
<!-- <span class="dalee" data-back=\'.formed-wrapper-input[data-step="another"]\' data-now=\'.formed-wrapper-input[data-step="content_tariff"]\'></span> -->
<span class="buy-from-card">Оплата</span>
</div>

</div>';

				if (  ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ||
				       (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) &&
				      (intval($service_id) == 84178)    ) {
					$num .= '<div class="formed-wrapper-input" data-step="finish_him" style="display: none;">
<p class="text-balance-w" style="text-align: center;">Поздравляем! Вы успешно обновили тариф <span class="title-service-accept">PRO</span> на тариф <span class="title-service-accept title-service-accept-fin">PRO+</span> до <span class="daterealfuture1">'. str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')).'</span></p>
<p class="balancer-wrapper">Баланс вашего аккаунта после обновления тарифа составляет <span class="balanceost"><span>'.$balancer.'</span> <span class="rur">a</span></span></p>
<a href="/user/" class="gotomycab">Перейти в личный кабинет</a> 
</div>';
				} elseif (((get_field("services_user_services","user_".get_current_user_id())[0] == intval($service_id)) || (get_field("services_user_services","user_".get_current_user_id()) == intval($service_id)))) {
					$num .= '<div class="formed-wrapper-input" data-step="finish_him" style="display: none;">
<p class="text-balance-w" style="text-align: center;">Поздравляем! Вы успешно продлили тариф <span class="title-service-accept title-service-accept-fin">'.get_the_title($service_id).'</span> на <span class="mounth-dater">1 месяц</span> <span class="inlinebeen"><span class="daterealfuture">до 01/01/2021</span> .</span></p>
<p class="balancer-wrapper">Баланс вашего аккаунта после продления тарифа составляет <span class="balanceost"><span>'.$balancer.'</span> <span class="rur">a</span></span></p>
<a href="/user/" class="gotomycab">Перейти в личный кабинет</a>
</div>';
				} else {
					$num .= '<div class="formed-wrapper-input" data-step="finish_him" style="display: none;">
<p class="text-balance-w" style="text-align: center;">Поздравляем! Вы успешно активировали тариф <span class="title-service-accept title-service-accept-fin">'.get_the_title($service_id).'</span> на <span class="mounth-dater">1 месяц</span> <span class="inlinebeen"><span class="daterealfuture">до 01/01/2021</span> .</span></p>
<p class="balancer-wrapper">Баланс вашего аккаунта после активации тарифа составляет <span class="balanceost"><span>'.$balancer.'</span> <span class="rur">a</span></span></p>
<a href="/user/" class="gotomycab">Перейти в личный кабинет</a> 
</div>';
				}
				$num .= '<script>$(".dalee").click(function() {
    $("#sender_form_popup_title").text($(".show-new-window").attr("title-attr-2"));
    datanow = $(this).attr("data-now");
    databack = $(this).attr("data-back");
    datanow = $(this).attr("data-now");
    $(""+databack+"").css("display","block");
    $(""+datanow+"").css("display","none");
    if ($(".input-number-mod").val() == "") {
        numberinputnumbermod = 1;
    } else {
        numberinputnumbermod = $(".input-number-mod").val();
    }

    numberinputnumbermod = Math.abs(parseInt(numberinputnumbermod));
    if (numberinputnumbermod == "0") {
        numberinputnumbermod = 1;
    }

    if (isNaN(numberinputnumbermod)) {
        numberinputnumbermod = 1;
    }


    $(".mounth-dater").text(numberinputnumbermod+" "+$(".takewordmonth").text());
    var myDate = new Date("'.$datetojs.'");
var result1 = myDate.addMonths(parseInt(numberinputnumbermod));
$(".daterealfuture").text("до "+convertDate(result1));
})

$("span.backpack").click(function() {
$("#sender_form_popup_title").text($(".show-new-window").attr("title-attr-1"));
$(".incorrect").remove();
$(".linkbalance").parent().remove();
$(".pricewrap").removeClass("newjcc");
$(".submit_summa_main").removeAttr("style");
databack = $(this).attr("data-back");
datanow = $(this).attr("data-now");
$(""+databack+"").slideDown();
$(""+datanow+"").slideUp();
})
$(".buy-from-balance, .buy-from-card").click(function(){
//$("#sender_form_popup_title").text($(".show-new-window").attr("title-attr-3"));
});
$("span.buy-from-balance").click(function(){
    dataid = '.$service_id.';
    inputnumbermod = $(".input-number-mod").val();
    
    $.ajax({
    url: "'.admin_url("admin-ajax.php").'",
    type: "POST",
    data: "action=payfrombalance&dataid="+dataid+"&inputnumbermod="+inputnumbermod,
    beforeSend: function(xhr) {
    },
    success: function(data) {
    result = $.parseJSON(data);
    console.log(result.status);
    console.log(result.id);
    $(\'.formed-wrapper-input[data-step="finish_him"]\').css("display","block");
    $(\'#sender_form_popup_title\').text($("span.show-new-window.frombalance").attr("title-attr-3"));
    $(\'.formed-wrapper-input[data-step="accept_from_card"]\').css("display","none");
    var balance = $(\'#sender_form_popup_title\').attr(\'data-balance\');
    var cena = $(\'span.price2.pricer3.pricer_first_chapter\').text();
    var ostalos = parseInt(balance) - parseInt(cena);
    $(".balanceost > span:first-child").text(ostalos);
    $(".popup_close_button").attr("onclick", "location.reload();");
    $("#balancer_main_wrapper").css("display","none");
    }
    });

});

// $("span.buy-from-card").click(function(){
//     dataid = '.$service_id.';
//     inputnumbermod = $(".input-number-mod").val();
    
//     $.ajax({
//     url: "'.admin_url("admin-ajax.php").'",
//     type: "POST",
//     data: "action=payfrombalanceandcard&dataid="+dataid+"&inputnumbermod="+inputnumbermod,
//     beforeSend: function(xhr) {
//     },
//     success: function(data) {
//     result = $.parseJSON(data);
//     console.log(result.status);
//     console.log(result.id);
//     $(\'.formed-wrapper-input[data-step="finish_him"]\').css("display","block");
//     $(\'.formed-wrapper-input[data-step="accept_from_card"]\').css("display","none");
//     var balance = $(\'#sender_form_popup_title\').attr(\'data-balance\');
//     var cena = $(\'span.price2.pricer3.pricer_first_chapter\').text();
//     var ostalos = parseInt(balance) - parseInt(cena);
//     $(".balanceost > span:first-child").text(ostalos);
//     $("a.popup_close_button").attr("onclick", "location.reload();");
//     $("#balancer_main_wrapper").css("display","none");
//     }
//     });

// });
</script>
'; ?>
			<?php } ?>
		<?php } ?>
	<?php }
	//$cur_user_id = get_current_user_id();
	//$user_info = get_userdata($cur_user_id);
	$result .= '<div class="popup_container">';
	$result .= '<div class="popup_banner border_radius_general box_shadow_general" id="newformpayfortariff">';
	$result .= '<a class="popup_close_button" onclick=\'$("#popup_price_modal").empty();$("#popup_price_modal_footer").empty();\'></a>';
	//$result .= '<script src="https://www.google.com/recaptcha/api.js"></script>';
	if ((get_field("services_user_services","user_".get_current_user_id())[0] == intval($service_id)) || (get_field("services_user_services","user_".get_current_user_id()) == intval($service_id))) {
		$result .= '<div class="form_popup_title" id="sender_form_popup_title" data-balance="'.$balancer.'">Продление тарифа</div><div class="er_form_subtext" id="balancer_main_wrapper">Баланс аккаунта <span class="balancer_main"><span>'.$balancer.'</span> <span class="rur">a</span></span></div>';
	} elseif ((  ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ||
	              (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) &&
	             (intval($service_id) == 84178)    )) {
		$result .= '<div class="form_popup_title" id="sender_form_popup_title" data-balance="'.$balancer.'">Обновление тарифа</div><div class="er_form_subtext" id="balancer_main_wrapper">Баланс аккаунта <span class="balancer_main"><span>'.$balancer.'</span> <span class="rur">a</span></span></div>';
	} else {
		$result .= '<div class="form_popup_title" id="sender_form_popup_title" data-balance="'.$balancer.'">Активация тарифа</div><div class="er_form_subtext" id="balancer_main_wrapper">Баланс аккаунта <span class="balancer_main"><span>'.$balancer.'</span> <span class="rur">a</span></span></div>';
	}
	$result .= '<form class="order-form-mail-pdf" method="post"  action="">';
	$result .= $num;
	//$result .= '<div class="er_form_input_container"><input type="email" name="emailpdfsended" class="required border_radius_general" placeholder="'.$user_info->data->user_email.'" value="'.$user_info->data->user_email.'"></div>';
	//$result .= '<div class="er_form_input_container" style="display:none;"><input type="text" name="filepdfsended" id="filepdfsended" placeholder="" value=""></div>';
	//$result .= '<div class="er_form_input_container"><div class="g-recaptcha" data-sitekey="6Lf6dpIUAAAAALNlGI5LwOMRyOOFLLuSqoeBExgr" data-theme="light" style="transform:scale(0.8); transform-origin:0;"></div></div>';
	//$result .= '<input type="submit" name="submit" value="Отправить" class="er_form_submit">';
	$result .= '</form>';
	$result .= '</div>';
	$result .= '</div>';
	echo $result;

	echo '
    <script type="text/javascript">
    //jQuery(document).ready(function($){
      //  alert("go");
        //$(\'.popup_close_button\').on(\'click\', function(){
          //$("#popup_price_modal").empty();
          //$("#popup_price_modal_footer").empty();
      //});
    //});
    
    </script>
    ';
	echo '<script type="text/javascript">
    $(document).ready(function(){
        $(\'.order-form-mail-pdf\').on(\'submit\', function(e) {
        e.preventDefault();
        $.ajax({
            url: "'.get_site_url().'/wp-admin/admin-ajax.php",
            type: \'POST\',
            data: \'action=sendpdf&\'+$(this).serialize(),
            beforeSend: function(xhr) {

            },
            success: function(data) {
                result = $.parseJSON(data);    
                if (result.status == "notemail") {
                    $(\'.text-wrapper-accept\').remove();
                    $(\'input[name="emailpdfsended"]\').after(\'<span class="text-wrapper-accept">Некорректный e-mail</span>\');
                    grecaptcha.reset();
                } else if (result.status == "recaptcha") {
                    $(\'.text-wrapper-accept\').remove();
                    $(\'input[name="emailpdfsended"]\').after(\'<span class="text-wrapper-accept">Не пройдена проверка reCAPTCHA</span>\');
                    grecaptcha.reset();
                } else if (result.status == "ok") {
                    $(".order-form-mail-pdf").css("display","none");
                    $("#sender_form_popup_title").text("Сообщение успешно отправлено");
                    $(".er_form_subtext").remove();
                } 
               
            }
            });
        })
    });    
    </script>';
	die;
//}
	if ($service_id === 33431335) {
		if($service_id != '') {
			if ((    get_field('price',intval($service_id))    )) {
				$getprice = get_field('price',intval($service_id));
				if ($getprice != '') { ?>
					<?php //$num .= '<script src="/wp-content/themes/eto-razvod-1/template-parts/blocks/list_services/table-tariff.js"></script>'; ?>
					<?php $num .= '<script>Date.isLeapYear = function (year) { 
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
  function pad(s) { return (s < 10) ? \'0\' + s : s; }
  var d = new Date(inputFormat)
  return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join(\'/\')
}

(function() {
 
  window.inputNumber = function(el) {

    var min = el.attr(\'min\') || false;
    var max = el.attr(\'max\') || false;

    var els = {};

    els.dec = el.prev();
    els.inc = el.next();

    el.each(function() {
      init($(this));
    });

    function init(el) {

      els.dec.on(\'click\', decrement);
      els.inc.on(\'click\', increment);

      function decrement() {
        var value = el[0].value;
        value--;
        if(!min || value >= min) {
          el[0].value = value;

          $(\'.price2\').text(    parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\'))    );


                    if ((parseInt(el[0].value)) == 1) {
                    $(\'.sklon\').text(\'\');
                    } else if (((parseInt(el[0].value)) == 2) || ((parseInt(el[0].value)) == 3) || ((parseInt(el[0].value)) == 4)) {
                    $(\'.sklon\').text(\'а\');
                    } else if (((parseInt(el[0].value)) == 5) || ((parseInt(el[0].value)) == 6) || ((parseInt(el[0].value)) == 7) || ((parseInt(el[0].value)) == 8) || ((parseInt(el[0].value)) == 9) || ((parseInt(el[0].value)) == 0)) {
                    $(\'.sklon\').text(\'ев\');
                    }

                    if ( (parseInt(el[0].value) < 20) &&  (parseInt(el[0].value) > 9)) {
                    $(\'.sklon\').text(\'ев\');
                    } else if ( (parseInt(el[0].value) > 20)) {
                    if ((parseInt(el[0].value) % 10) == 1) {
                    $(\'.sklon\').text(\'\');
                    } else if (((parseInt(el[0].value) % 10) == 2) || ((parseInt(el[0].value) % 10) == 3) || ((parseInt(el[0].value) % 10) == 4)) {
                    $(\'.sklon\').text(\'а\');
                    } else if (((parseInt(el[0].value) % 10) == 5) || ((parseInt(el[0].value) % 10) == 6) || ((parseInt(el[0].value) % 10) == 7) || ((parseInt(el[0].value) % 10) == 8) || ((parseInt(el[0].value) % 10) == 9) || ((parseInt(el[0].value) % 10) == 0)) {
                    $(\'.sklon\').text(\'ев\');
                    }
                    }
                    
                    if ((parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\'))) <= parseInt($(\'.balancer\').text())) {
                    $(\'.buy-from-balance\').attr(\'style\',\'display:block\');
                    $(\'.buy-from-card\').attr(\'style\',\'display:none\');
                    $(\'.buycardlink\').attr(\'style\',\'display:none\');
                    $(\'.no-balance\').attr(\'style\',\'display:none\');
                    $(\'#balancer_main_wrapper\').css(\'display\',\'block\');
                    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'block\');

                            if ($(\'input[name="payfrombalance"]\').is(\':checked\') == false) {
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            $(\'.buy-from-card\').attr(\'style\',\'display:block\');
            $(\'.buy-from-balance\').attr(\'style\',\'display:none\');
            paytype = \'onespay\';
            $(\'span.nonebalance.nonebalance_last > span:first-child\').text( parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\')) );

        } else {
            //paytype = \'twospay\';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $(\'.buy-from-card\').attr(\'style\',\'display:none\');
            $(\'.buy-from-balance\').attr(\'style\',\'display:block\');
        } 

                    } else {
                    $(\'.buy-from-balance\').attr(\'style\',\'display:none\');
                    $(\'.buy-from-card\').attr(\'style\',\'display:block\');
                    $(\'.buycardlink\').attr(\'style\',\'display:block\');

                    $(\'#balancer_main_wrapper\').css(\'display\',\'none\');
                    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'none\');
                    $(\'span.nonebalance > span:first-child\').text(parseInt($(\'span.price2.pricer3.pricer_first_chapter\').text()) - parseInt($(\'.balancer2ins.balancer2ins3ins\').text()));
    if (parseInt($(\'.balancer\').text()) > 0) {
        if ($(\'input[name="payfrombalance"]\').is(\':checked\') == false) {
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            paytype = \'onespay\';
            $(\'.no-balance\').attr(\'style\',\'display:none\');
            $("#testfieldwrapper2priced").attr("style","display:flex");
            $(\'span.nonebalance.nonebalance_last > span:first-child\').text( parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\')) );
        } else {
            paytype = \'twospay\';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $(\'.no-balance\').attr(\'style\',\'display:block\');
            $("#testfieldwrapper2priced").attr("style","display:none");
        } 
    } else {
        // если у юзверя нет баланса вообще
        paytype = \'onespay\';
        $(\'.no-balance\').attr(\'style\',\'display:none\');
        $(\'.payfrombalancewrap\').css(\'display\',\'none\');
        //$(\'.tgw-wrapper\').css(\'justify-content\',\'center\');
        $("#testfieldwrapper2priced").attr("style","display:flex");
    }


                    }



        }
      }

      function increment() {
        var value = el[0].value;
        value++;
        if(!max || value <= max) {
          el[0].value = value++;
          $(\'.price2\').text(    parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\'))    );


                if ((parseInt(el[0].value)) == 1) {
                $(\'.sklon\').text(\'\');
                } else if (((parseInt(el[0].value)) == 2) || ((parseInt(el[0].value)) == 3) || ((parseInt(el[0].value)) == 4)) {
                $(\'.sklon\').text(\'а\');
                } else if (((parseInt(el[0].value)) == 5) || ((parseInt(el[0].value)) == 6) || ((parseInt(el[0].value)) == 7) || ((parseInt(el[0].value)) == 8) || ((parseInt(el[0].value)) == 9) || ((parseInt(el[0].value)) == 0)) {
                $(\'.sklon\').text(\'ев\');
                }

                if ( (parseInt(el[0].value) < 20) &&  (parseInt(el[0].value) > 9)) {
                $(\'.sklon\').text(\'ев\');
                } else if ( (parseInt(el[0].value) > 20)) {
                if ((parseInt(el[0].value) % 10) == 1) {
                $(\'.sklon\').text(\'\');
                } else if (((parseInt(el[0].value) % 10) == 2) || ((parseInt(el[0].value) % 10) == 3) || ((parseInt(el[0].value) % 10) == 4)) {
                $(\'.sklon\').text(\'а\');
                } else if (((parseInt(el[0].value) % 10) == 5) || ((parseInt(el[0].value) % 10) == 6) || ((parseInt(el[0].value) % 10) == 7) || ((parseInt(el[0].value) % 10) == 8) || ((parseInt(el[0].value) % 10) == 9) || ((parseInt(el[0].value) % 10) == 0)) {
                $(\'.sklon\').text(\'ев\');
                }
                }

                    if ((parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\'))) <= parseInt($(\'.balancer\').text())) {
                    $(\'.buy-from-balance\').attr(\'style\',\'display:block\');
                    $(\'.buy-from-card\').attr(\'style\',\'display:none\');
                    $(\'.buycardlink\').attr(\'style\',\'display:none\');
                    $(\'.no-balance\').attr(\'style\',\'display:none\');
                    $(\'#balancer_main_wrapper\').css(\'display\',\'block\');
                    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'block\');
                    $("#testfieldwrapper2priced").attr("style","display:flex");

                            if ($(\'input[name="payfrombalance"]\').is(\':checked\') == false) {
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            $(\'.buy-from-card\').attr(\'style\',\'display:block\');
            $(\'.buy-from-balance\').attr(\'style\',\'display:none\');
            paytype = \'onespay\';
            $(\'span.nonebalance.nonebalance_last > span:first-child\').text( parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\')) );
        } else {
            //paytype = \'twospay\';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $(\'.buy-from-card\').attr(\'style\',\'display:none\');
            $(\'.buy-from-balance\').attr(\'style\',\'display:block\');
        } 


                    } else {
                    $(\'.buy-from-balance\').attr(\'style\',\'display:none\');
                    $(\'.buy-from-card\').attr(\'style\',\'display:block\');
                    $(\'.buycardlink\').attr(\'style\',\'display:block\');

                    $(\'#balancer_main_wrapper\').css(\'display\',\'none\');
                    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'none\');
                    $(\'span.nonebalance > span:first-child\').text(parseInt($(\'span.price2.pricer3.pricer_first_chapter\').text()) - parseInt($(\'.balancer2ins.balancer2ins3ins\').text()));
    if (parseInt($(\'.balancer\').text()) > 0) {
        if ($(\'input[name="payfrombalance"]\').is(\':checked\') == false) {
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            paytype = \'onespay\';
            $(\'.no-balance\').attr(\'style\',\'display:none\');
            $(\'span.nonebalance.nonebalance_last > span:first-child\').text( parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\')) );
            $(\'span.nonebalance.nonebalance_last > span:first-child\').text( parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\')) );
            $("#testfieldwrapper2priced").attr("style","display:flex");
        } else {
            paytype = \'twospay\';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $(\'.no-balance\').attr(\'style\',\'display:block\');
            $("#testfieldwrapper2priced").attr("style","display:none");
        } 
    } else {
        // если у юзверя нет баланса вообще
        paytype = \'onespay\';
        $(\'.no-balance\').attr(\'style\',\'display:none\');
        $(\'.payfrombalancewrap\').css(\'display\',\'none\');
        //$(\'.tgw-wrapper\').css(\'justify-content\',\'center\');
        $("#testfieldwrapper2priced").attr("style","display:flex");
    }

                    }


        }
      }

    }
    
  }
})();

inputNumber($(\'.input-number-mod\'));
$(".input-number-mod").on("change paste keyup", function() {
    if ($(this).val() == \'\') {
        numberinputnumbermod = 1;
    } else {
        numberinputnumbermod = $(this).val();
    }
if ((numberinputnumbermod) == 1) {
                    $(\'.sklon\').text(\'\');
                    } else if (((numberinputnumbermod) == 2) || ((numberinputnumbermod) == 3) || ((numberinputnumbermod) == 4)) {
                    $(\'.sklon\').text(\'а\');
                    } else if (((numberinputnumbermod) == 5) || ((numberinputnumbermod) == 6) || ((numberinputnumbermod) == 7) || ((numberinputnumbermod) == 8) || ((numberinputnumbermod) == 9) || ((numberinputnumbermod) == 0)) {
                    $(\'.sklon\').text(\'ев\');
                    }

                    if ( (numberinputnumbermod < 20) &&  (numberinputnumbermod > 9)) {
                    $(\'.sklon\').text(\'ев\');
                    } else if ( (numberinputnumbermod > 20)) {
                    if ((numberinputnumbermod % 10) == 1) {
                    $(\'.sklon\').text(\'\');
                    } else if (((numberinputnumbermod % 10) == 2) || ((numberinputnumbermod % 10) == 3) || ((numberinputnumbermod % 10) == 4)) {
                    $(\'.sklon\').text(\'а\');
                    } else if (((numberinputnumbermod % 10) == 5) || ((numberinputnumbermod % 10) == 6) || ((numberinputnumbermod % 10) == 7) || ((numberinputnumbermod % 10) == 8) || ((numberinputnumbermod % 10) == 9) || ((numberinputnumbermod % 10) == 0)) {
                    $(\'.sklon\').text(\'ев\');
                    }
                    }
    numberinputnumbermod = Math.abs(parseInt(numberinputnumbermod));
    if (numberinputnumbermod == "0") {
        numberinputnumbermod = 1;
    }

    if (isNaN(numberinputnumbermod)) {
        numberinputnumbermod = 1;
    }
    
    $(\'.price2\').text(    parseInt(numberinputnumbermod) * parseInt($(\'.title-service\').attr(\'data-price\'))    );

    if ((parseInt(numberinputnumbermod) * parseInt($(\'.title-service\').attr(\'data-price\'))) <= parseInt($(\'.balancer\').text())) {
    $(\'.buy-from-balance\').attr(\'style\',\'display:block\');
    $(\'.buy-from-card\').attr(\'style\',\'display:none\');
    $(\'.buycardlink\').attr(\'style\',\'display:none\');
    $(\'.no-balance\').attr(\'style\',\'display:none\');
    $(\'#balancer_main_wrapper\').css(\'display\',\'block\');
    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'block\');
    $(\'.no-balance\').attr(\'style\',\'display:none\');
    $(\'#balancer_main_wrapper\').css(\'display\',\'block\');
    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'block\');
    $("#testfieldwrapper2priced").attr("style","display:flex");


        if ($(\'input[name="payfrombalance"]\').is(\':checked\') == false) {
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            $(\'.buy-from-card\').attr(\'style\',\'display:block\');
            $(\'.buy-from-balance\').attr(\'style\',\'display:none\');
            paytype = \'onespay\';
        } else {
            //paytype = \'twospay\';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $(\'.buy-from-card\').attr(\'style\',\'display:none\');
            $(\'.buy-from-balance\').attr(\'style\',\'display:block\');
        } 


    } else {
    $(\'.buy-from-balance\').attr(\'style\',\'display:none\');
    $(\'.buy-from-card\').attr(\'style\',\'display:block\');
    $(\'.buycardlink\').attr(\'style\',\'display:block\');
    $(\'#balancer_main_wrapper\').css(\'display\',\'none\');
    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'none\');
    $(\'span.nonebalance > span:first-child\').text(parseInt($(\'span.price2.pricer3.pricer_first_chapter\').text()) - parseInt($(\'.balancer2ins.balancer2ins3ins\').text()));
    $(\'#balancer_main_wrapper\').css(\'display\',\'none\');
    $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'none\');
    $(\'span.nonebalance > span:first-child\').text(parseInt($(\'span.price2.pricer3.pricer_first_chapter\').text()) - parseInt($(\'.balancer2ins.balancer2ins3ins\').text()));
    if (parseInt($(\'.balancer\').text()) > 0) {
        if ($(\'input[name="payfrombalance"]\').is(\':checked\') == false) {
            // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса
            paytype = \'onespay\';
            $(\'.no-balance\').attr(\'style\',\'display:none\');
            $(\'span.nonebalance.nonebalance_last > span:first-child\').text( parseInt(el[0].value) * parseInt($(\'.title-service\').attr(\'data-price\')) );
        } else {
            paytype = \'twospay\';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
            $(\'.no-balance\').attr(\'style\',\'display:block\');
        } 
    } else {
        // если у юзверя нет баланса вообще
        paytype = \'onespay\';
        $(\'.no-balance\').attr(\'style\',\'display:none\');
        $(\'.payfrombalancewrap\').css(\'display\',\'none\');
        //$(\'.tgw-wrapper\').css(\'justify-content\',\'center\');
    }

    }
});

$(document).ready(function(){
    $(\'input[name="accept"]\').change(function() {
    if($(this).is(":checked")) {
    var returnVal = "ok";
    $(this).attr("checked", returnVal);
    }
    if ($(this).is(\':checked\') == false) {
    $(this).parent().next().addClass(\'pricewrapturnedoff\');
    } else {
    $(this).parent().next().removeClass(\'pricewrapturnedoff\');
    }
    });
});

$(document).ready(function(){
        //Оплата по карте тарифа
indexvari = 0;        
$(\'span.buy-from-card\').click(function() {
    if (paytype == \'twospay\') {
        amountval = $(\'span.nonebalance.nonebalance_last > span:first-child\').text();
        if ((amountval != "") && (amountval != "0") && (amountval != 0)) {

        if (indexvari != 1) {
        $.ajax({
        url: avatar.ajaxurl,
        type: \'POST\',
        data: \'action=cardbefore&amountval=\'+amountval,
        beforeSend: function(xhr) {
        },
        success: function(data) {
        result = $.parseJSON(data);
        resultid = result.id;
        $(\'.bycardfunc3\').click();
        indexvari = 1;
        $(\'.popup_container\').attr(\'style\',\'visibility: hidden !important;\');
        //$(\'input.submit_summa\').slideUp();
        //$(\'.formed-wrapper-input[data-step="another"]\').slideUp();
        console.log(\'buy-from-card: cardbefore = twospay\');
        }
        });
        } else {
        location.reload();
        }

        } else {
        $(\'.incorrect\').remove();    
        $(\'input[data-id="amount"]\').parent().after(\'<span class="incorrect">Некорректная сумма</span>\');
        } 
    } else {
                amountval = $(\'span.nonebalance.nonebalance_last > span:first-child\').text();
                if ((amountval != "") && (amountval != "0") && (amountval != 0)) {

                if (indexvari != 1) {
                $.ajax({
                url: avatar.ajaxurl,
                type: \'POST\',
                data: \'action=cardbefore&amountval=\'+amountval,
                beforeSend: function(xhr) {
                },
                success: function(data) {
                result = $.parseJSON(data);
                resultid = result.id;
                $(\'.bycardfunc2\').click();
                indexvari = 1;
                $(\'.popup_container\').attr(\'style\',\'visibility: hidden !important;\');
                console.log(\'buy-from-card: cardbefore = onespay\');
                //$(\'input.submit_summa\').slideUp();
                //$(\'.formed-wrapper-input[data-step="another"]\').slideUp();
                }
                });
                } else {
                location.reload();
                }

                } else {
                $(\'.incorrect\').remove();    
                $(\'input[data-id="amount"]\').parent().after(\'<span class="incorrect">Некорректная сумма</span>\');
                } 
    }

});
$(\'.bycardfunc2\').click(pay2);
$(\'.bycardfunc3\').click(pay3);

});

$(\'input[name="payfrombalance"]\').change(function() {
    $(\'.input-number-mod-increment\').click();
    $(\'.input-number-mod-decrement\').click();
});</script>'; ?>
					<?php $num .='<div class="formed-wrapper-input" data-step="content_tariff">'; ?>
					<?php $num .= '<span class="balancer" style="display:none;">'.$balancer.'</span>'; ?>
					<?php  if ((get_field('services_user_services','user_'.get_current_user_id())[0] == intval($service_id)) || (get_field('services_user_services','user_'.get_current_user_id()) == intval($service_id))) {
						$namep = get_field('services_user_services','user_'.get_current_user_id())[0];
						$num .= '<div class="activated">На данный момент у вас активирован тариф  <span class="activated-name">'.get_the_title($namep).'</span> до <span class="activated-date">'.str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')).'</span></div>';
					} ?>
					<?php if (
					(    ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ||
					      (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) &&
					     (intval($service_id) == 84178)    )) {

						$date1 = '10-02-2021';
						$date2 = '10-06-2022';

						$ts1 = strtotime($date1);
						$ts2 = strtotime($date2);

						$year1 = date('Y', $ts1);
						$year2 = date('Y', $ts2);

						$month1 = date('m', $ts1);
						$month2 = date('m', $ts2);

						$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
						//echo $diff;

					} else {

					} ?>
					<?php  if ((get_field('services_user_services','user_'.get_current_user_id())[0] == intval($service_id)) || (get_field('services_user_services','user_'.get_current_user_id()) == intval($service_id))) {  ?>
						<?php $num .='<p class="show-usl">Вы выбрали продление тарифа <span class="title-service title-service-main" data-price="'.get_field('price',intval($service_id)).'" data-id="'.$service_id.'">'.get_the_title($service_id).'</span> на <span class="brset"></span><span class="decwrap"><span class="input-number-mod-decrement">–</span>';
						$num .='<input class="input-number-mod" type="text" value="1" min="1" max="110"><span class="input-number-mod-increment">+</span></span> <span class="takewordmonth">месяц<span class="sklon"></span></span></p>';
					} elseif (
					(    ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ||
					      (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) &&
					     (intval($service_id) == 84178)    )    ) {


						date_default_timezone_set( 'Europe/Moscow' );
						$start = strtotime(date('d-m-Y H:i:s'));
						$end = strtotime(   str_replace(    '/', '-', get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id())    )    );

						$days_between = ceil(abs($end - $start) / 86400);
						//echo $days_between;
						//echo "<br>";
						//echo '$start '.$start.' date '.date('d/m/Y H:i:s');
						//echo "<hr>";
						//echo '$end  '.$end.'services_user_add_transaction_date_before_end '.get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id());
						//echo "<hr>";
//2    ===============================================================================================
//Находим количество дней для тарифа ПРО от АКТИВАЦИИ - до даты ОКОНЧАНИЯ
						$start = strtotime(    str_replace(    '/', '-', get_field('services_user_date_activation','user_'.get_current_user_id()) )    );
						$end = strtotime(    str_replace(    '/', '-', get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()) )    );

						$days_between2 = ceil(abs($end - $start) / 86400);
						//echo $days_between2;
						//echo "<br>";
//5    ===============================================================================================
//НАХОДИМ ЦЕНУ за 1 день ПРО
// ЦЕНА ЗА ПРО * 12 / 365
						$priceforonedaypro = (intval(get_field('price', 84175)) * 12) / 365;
//6    ===============================================================================================
//Вычиляем цену (от сегодняшнего дня ДО конечного) дня для тарифа ПРО
//Шаг 1 умножаем шаг 5
						$prorealprice = $priceforonedaypro * $days_between;
//8    ===============================================================================================
//НАХОДИМ ЦЕНУ за 1 день ПРО+
// ЦЕНА ЗА ПРО+ * 12 / 365
						$priceforonedayproplus = (intval(get_field('price', 84178)) * 12) / 365;
//9    ===============================================================================================
//Вычиляем цену (от сегодняшнего дня ДО конечного) дня для тарифа ПРО+
//Шаг 1 умножаем шаг 8
						$proplusrealprice = $priceforonedayproplus * $days_between;
//10    ===============================================================================================
//РАЗНИЦА
//вычетаем из Шаг 9 - Шаг 6
						$raznica = $proplusrealprice - $prorealprice;
						update_field('secret_balance_spend_for_update',ceil($raznica),'user_'.get_current_user_id());

						$num .='<p class="show-usl">Вы выбрали обновление тарифа <span class="go2tariffs"><span class="title-service-listed">PRO</span> <span class="arrowbg"><i class="fas fa-chevron-right"></i></span> <span class="title-service title-service-main" data-price="'.ceil($raznica).'" data-id="84178">'.get_the_title(84178).'</span></span> до ';
						$num .='<span style="display:none"><span class="brset"></span><span class="input-number-mod-decrement">–</span><input class="input-number-mod" type="text" value="1" min="1" max="110"><span class="input-number-mod-increment">+</span> <span class="takewordmonth">месяц<span class="sklon"></span></span></span>';
						$num .= '<span class="services_user_add_transaction_date_before_end">'.str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')).'</span>';

					} else {
						$num .='<p class="show-usl">Вы выбрали тариф <span class="title-service title-service-main" data-price="'.get_field('price',intval($service_id)).'" data-id="'.$service_id.'">'.get_the_title($service_id).'</span> на <span class="brset"></span><span class="dec-wrap"><span class="input-number-mod-decrement">–</span>';
						$num .='<input class="input-number-mod" type="text" value="1" min="1" max="110"><span class="input-number-mod-increment">+</span></span> <span class="takewordmonth">месяц<span class="sklon"></span></span></p>'; ?>
					<?php } ?>

					<?php $num .='<div class="tgw-wrapper"><span class="textgetterwrap">'; ?>
					<?php $num .='<input type="checkbox" name="autoupdate" checked="checked"> '; ?>
					<?php if ((get_field("services_user_services","user_".get_current_user_id())[0] == intval($service_id)) || (get_field("services_user_services","user_".get_current_user_id()) == intval($service_id))) {
						$services_user_date_activation_beta = get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id());
						$timestampstart_beta = strtotime( str_replace(    '/', '-',$services_user_date_activation_beta) );


						$datetojs = date('Y-m-d', $timestampstart_beta);
					} else {
						$datetojs = date("m/d/Y");
					} ?>
					<?php $num .='<span class="textgetter"> Автопродление тарифа 
<i class="fas fa-question">
<span class="showadvice">По истечению срока действия тарифа - мы автоматически спишем с Вашего баланса недостающую сумму. Если Вам это интересно, то оставьте опцию включенной. Позже её можно будет изменить в настройках личного кабинета</span></i></span>
</span>
<span class="textgetterwrap payfrombalancewrap"><input type="checkbox" name="payfrombalance" checked="checked"> <span class="textgetter"> Использовать баланс сайта
<!--i class="fas fa-question">
<span class="showadvice">По истечению срока действия тарифа - мы автоматически спишем с Вашего баланса недостающую сумму. Если Вам это интересно, то оставьте опцию включенной. Позже её можно будет изменить в настройках личного кабинета</span></i--></span>
</span></div>
<span class="no-balance" style="display:none;">
Данной суммы у Вас нет на балансе аккаунта<br>
На балансе Вашего аккаунта на данный момент есть <span class="balancer2"><span class="balancer2ins">'.$balancer.'</span> <span class="rur">a</span></span><br>
Вы можете оплатить недостающую сумму <span class="nonebalance"><span>'.$n = intval(get_field('price',intval($service_id))) - intval($balancer).'</span> <span class="rur">a</span></span> по карте 
</span>';

					if (  ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ||
					       (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) &&
					      (intval($service_id) == 84178)    ) {



						$num .='<div class="price-wrapper price-wrapper2"><span class="price2 pricer3 pricer_first_chapter">'.ceil($raznica).'</span> <span class="name-valute">рублей</span></div>';
					} else {
						$num .='<div class="price-wrapper price-wrapper2"><span class="price2 pricer3 pricer_first_chapter">'.get_field('price',intval($service_id)).'</span> <span class="name-valute">рублей</span></div>';
					}

					$num .='<!--span class="text-l text-l2">
<input type="checkbox" name="accept" checked="checked"> 
<span class="text-wrapper-accept text-wrapper-accept-mainer">Нажимая на кнопку «Оплата», Вы автоматически соглашаетесь с <a href="https://etorazvod.ru/offer/" target="_blank">Офертой на заключение договора</a>, <a href="https://etorazvod.ru/rules/" target="_blank">Правилами пользования сервисом</a>, <a href="https://etorazvod.ru/terms-of-use/" target="_blank">Пользовательским соглашением</a> и <a href="https://etorazvod.ru/privacy-policy/" target="_blank">Политикой Конфиденциальности</a>.</span></span>
</span-->
<!--div class="pricewrap pricewrapturned">
<span class="buy-from-balance">Оплатить с баланса</span>
<span href="/balance-test/?service_id='.$service_id.'" data-mounth="" style="display:none;" class="buycardlink">Оплатить по карте</span>
</div-->

<!--div class="pricewrap pricewrapturned">
<span class="backpack getbackpack" data-back=".form-wrapper-step[data-step=&quot;step_0_1&quot;]" data-now=".formed-wrapper-input[data-step=&quot;content_tariff&quot;],.formed-wrapper-input[data-step=&quot;another&quot;]">Назад</span>

<span class="dalee" data-back=".formed-wrapper-input[data-step=&quot;accept_from_card&quot;]" data-now=".formed-wrapper-input[data-step=&quot;content_tariff&quot;],.formed-wrapper-input[data-step=&quot;another&quot;]">Далее</span>
</div-->
<div class="pricewrap pricewrapturned" style="justify-content: center;">
<!--span class="backpack getbackpack" data-back=\'.form-wrapper-step[data-step="step_0_1"]\' data-now=\'.formed-wrapper-input[data-step="content_tariff"],.formed-wrapper-input[data-step="another"]\'>Назад</span-->
<span class="dalee" data-back=\'.formed-wrapper-input[data-step="accept_from_card"]\' data-now=\'.formed-wrapper-input[data-step="content_tariff"],.formed-wrapper-input[data-step="another"]\' style="width: 100% !important;max-width: unset !important;">Далее</span>
</div>
</div>

<div class="formed-wrapper-input" data-step="accept_from_card" style="display: none;">'; ?>
					<?php if ((get_field("services_user_services","user_".get_current_user_id())[0] == intval($service_id)) || (get_field("services_user_services","user_".get_current_user_id()) == intval($service_id))) { ?>
						<?php $num .='<p class="text-balance-w" style="text-align: center;">Вы собираетесь продлить тариф <span class="title-service-accept">'.get_the_title($service_id).'</span> на <span class="mounth-dater">1 месяц</span> <span class="daterealfuture">до 01/01/2021</span>    <span style="display: none;"><span class="pricer-content"></span></span></p>'; ?>
					<?php } elseif (  ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ||
					                   (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) &&
					                  (intval($service_id) == 84178)    ) {
						$num .='<p class="text-balance-w" style="text-align: center;">Вы собираетесь обновить тариф <span class="title-service-accept">PRO</span> на <span class="title-service-accept" data-price="'.ceil($raznica).'" data-id="84178">PRO+</span> до <span class="services_user_add_transaction_date_before_end">'.str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')).'</span></p>';
					} else { ?>
						<?php $num .='<p class="text-balance-w" style="text-align: center;">Вы собираетесь приобрести тариф <span class="title-service-accept">'.get_the_title($service_id).'</span> на <span class="mounth-dater">1 месяц</span> <span class="daterealfuture">до 01/01/2021</span>    <span style="display: none;"><span class="pricer-content"></span></span></p>'; ?>
					<?php } ?>
					<?php $num .='<div class="texterb no-balance"  style="display: none;">Будет списано с баланса аккаунта <span class="balancer2"><span class="balancer2ins balancer2ins3ins">'.$balancer.'</span> <span class="rur">a</span></span><br>
Будет списано с вашей банковской карты <span class="nonebalance nonebalance_last"><span>'.$n = intval(get_field('price',intval($service_id))) - intval($balancer).'</span> <span class="rur">a</span></span><div class="price-wrapper price-wrapper2" style="display: flex;"><span class="price2 pricer3 pricer5">'.get_field('price',intval($service_id)).'</span> <span class="name-valute">рублей</span></div></div>';

					if (  ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ||
					       (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) &&
					      (intval($service_id) == 84178)    ) {
						$num .= '<div class="price-wrapper price-wrapper2" style="display: flex;" id="testfieldwrapper2priced"><span class="price2 pricer3 pricer5 pricer6">'.ceil($raznica).'</span> <span class="name-valute">рублей</span></div>';
					} else {
						$num .= '<div class="price-wrapper price-wrapper2" id="testfieldwrapper2priced" style="display: flex;"><span class="price2 pricer3 pricer5 pricer6">'.get_field('price',intval($service_id)).'</span> <span class="name-valute">рублей</span></div>';
					}

					$num .= '<span class="text-l text-l2" style="display: none"><input type="checkbox" name="accept" checked="checked"> <span class="text-wrapper-accept text-wrapper-accept-mainer">Нажимая на кнопку «Оплата», Вы автоматически соглашаетесь с <a href="https://etorazvod.ru/offer/" target="_blank">Офертой на заключение договора</a>, <a href="https://etorazvod.ru/rules/" target="_blank">Правилами пользования сервисом</a>, <a href="https://etorazvod.ru/terms-of-use/" target="_blank">Пользовательским соглашением</a> и <a href="https://etorazvod.ru/privacy-policy/" target="_blank">Политикой Конфиденциальности</a>.</span></span></span>
<span class="text-l text-l2">
<input type="checkbox" name="accept" checked="checked"> 
<span class="text-wrapper-accept text-wrapper-accept-mainer">Нажимая на кнопку «Оплата», Вы автоматически соглашаетесь с <a href="https://etorazvod.ru/offer/" target="_blank">Офертой на заключение договора</a>, <a href="https://etorazvod.ru/rules/" target="_blank">Правилами пользования сервисом</a>, <a href="https://etorazvod.ru/terms-of-use/" target="_blank">Пользовательским соглашением</a> и <a href="https://etorazvod.ru/privacy-policy/" target="_blank">Политикой Конфиденциальности</a>.</span></span>
</span>
<div class="pricewrap pricewrapturned">
<span class="backpack getbackpack" data-now=\'.formed-wrapper-input[data-step="accept_from_card"]\' data-back=\'.formed-wrapper-input[data-step="content_tariff"],.formed-wrapper-input[data-step="another"]\'>Назад</span>
<span class="buy-from-balance">Оплата</span>
<!-- <span class="dalee" data-back=\'.formed-wrapper-input[data-step="another"]\' data-now=\'.formed-wrapper-input[data-step="content_tariff"]\'></span> -->
<span class="buy-from-card">Оплата</span>
</div>

</div>';

					if (  ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ||
					       (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) &&
					      (intval($service_id) == 84178)    ) {
						$num .= '<div class="formed-wrapper-input" data-step="finish_him" style="display: none;">
<p class="text-balance-w" style="text-align: center;">Вы успешно обновили тариф <span class="title-service-accept">PRO</span> на <span class="title-service-accept title-service-accept-fin">PRO+</span> до <span class="daterealfuture1">'. str_replace(    '/', '.', strtok(get_field('services_user_add_transaction_date_before_end','user_'.get_current_user_id()), ' ')).'</span></p>
<p class="balancer-wrapper">Ваш баланс после обновления тарифа составляет <span class="balanceost"><span>'.$balancer.'</span> <span class="rur">a</span></span></p>
</div>';
					} elseif (((get_field("services_user_services","user_".get_current_user_id())[0] == intval($service_id)) || (get_field("services_user_services","user_".get_current_user_id()) == intval($service_id)))) {
						$num .= '<div class="formed-wrapper-input" data-step="finish_him" style="display: none;">
<p class="text-balance-w" style="text-align: center;">Вы успешно подлили тариф <span class="title-service-accept title-service-accept-fin">'.get_the_title($service_id).'</span> на <span class="mounth-dater">1 месяц</span> <span class="daterealfuture">до 01/01/2021</span></p>
<p class="balancer-wrapper">Ваш баланс после подления тарифа составляет <span class="balanceost"><span>'.$balancer.'</span> <span class="rur">a</span></span></p>
</div>';
					} else {
						$num .= '<div class="formed-wrapper-input" data-step="finish_him" style="display: none;">
<p class="text-balance-w" style="text-align: center;">Вы успешно активировали тариф <span class="title-service-accept title-service-accept-fin">'.get_the_title($service_id).'</span> на <span class="mounth-dater">1 месяц</span> <span class="daterealfuture">до 01/01/2021</span></p>
<p class="balancer-wrapper">Ваш баланс после активации тарифа составляет <span class="balanceost"><span>'.$balancer.'</span> <span class="rur">a</span></span></p>
</div>';
					}
					$num .= '<script>$(".dalee").click(function() {
    datanow = $(this).attr("data-now");
    databack = $(this).attr("data-back");
    datanow = $(this).attr("data-now");
    $(""+databack+"").css("display","block");
    $(""+datanow+"").css("display","none");
    if ($(".input-number-mod").val() == "") {
        numberinputnumbermod = 1;
    } else {
        numberinputnumbermod = $(".input-number-mod").val();
    }

    numberinputnumbermod = Math.abs(parseInt(numberinputnumbermod));
    if (numberinputnumbermod == "0") {
        numberinputnumbermod = 1;
    }

    if (isNaN(numberinputnumbermod)) {
        numberinputnumbermod = 1;
    }


    $(".mounth-dater").text(numberinputnumbermod+" "+$(".takewordmonth").text());
    var myDate = new Date("'.$datetojs.'");
var result1 = myDate.addMonths(parseInt(numberinputnumbermod));
$(".daterealfuture").text("до "+convertDate(result1));
})

$("span.backpack").click(function() {
$(".incorrect").remove();
$(".linkbalance").parent().remove();
$(".pricewrap").removeClass("newjcc");
$(".submit_summa_main").removeAttr("style");
databack = $(this).attr("data-back");
datanow = $(this).attr("data-now");
$(""+databack+"").slideDown();
$(""+datanow+"").slideUp();
})

$("span.buy-from-balance").click(function(){
    dataid = '.$service_id.';
    inputnumbermod = $(".input-number-mod").val();
    
    $.ajax({
    url: "'.admin_url("admin-ajax.php").'",
    type: "POST",
    data: "action=payfrombalance&dataid="+dataid+"&inputnumbermod="+inputnumbermod,
    beforeSend: function(xhr) {
    },
    success: function(data) {
    result = $.parseJSON(data);
    console.log(result.status);
    console.log(result.id);
    $(\'.formed-wrapper-input[data-step="finish_him"]\').css("display","block");
    $(\'.formed-wrapper-input[data-step="accept_from_card"]\').css("display","none");
    var balance = $(\'#sender_form_popup_title\').attr(\'data-balance\');
    var cena = $(\'span.price2.pricer3.pricer_first_chapter\').text();
    var ostalos = parseInt(balance) - parseInt(cena);
    $(".balanceost > span:first-child").text(ostalos);
    $("a.popup_close_button").attr("onclick", "location.reload();");
    $("#balancer_main_wrapper").css("display","none");
    }
    });

});
</script>
'; ?>
				<?php } ?>
			<?php } ?>
		<?php }
		$result .= '<div class="popup_container">';
		$result .= '<div class="popup_banner border_radius_general box_shadow_general">';
		$result .= '<a class="popup_close_button" onclick=\'$("#popup_price_modal").empty();$("#popup_price_modal_footer").empty();\'></a>';
		//$result .= '<script src="https://www.google.com/recaptcha/api.js"></script>';
		if ((get_field("services_user_services","user_".get_current_user_id())[0] == intval($service_id)) || (get_field("services_user_services","user_".get_current_user_id()) == intval($service_id))) {
			$result .= '<div class="form_popup_title" id="sender_form_popup_title" data-balance="'.$balancer.'">Продление тарифа</div><div class="er_form_subtext" id="balancer_main_wrapper">Баланс аккаунта <span class="balancer_main"><span>'.$balancer.'</span> <span class="rur">a</span></span></div>';
		} elseif ((  ((get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ||
		              (get_field('services_user_services','user_'.get_current_user_id()) == 84175)) &&
		             (intval($service_id) == 84178)    )) {
			$result .= '<div class="form_popup_title" id="sender_form_popup_title" data-balance="'.$balancer.'">Обновление тарифа</div><div class="er_form_subtext" id="balancer_main_wrapper">Баланс аккаунта <span class="balancer_main"><span>'.$balancer.'</span> <span class="rur">a</span></span></div>';
		} else {
			$result .= '<div class="form_popup_title" id="sender_form_popup_title" data-balance="'.$balancer.'">Активация тарифа</div><div class="er_form_subtext" id="balancer_main_wrapper">Баланс аккаунта <span class="balancer_main"><span>'.$balancer.'</span> <span class="rur">a</span></span></div>';
		}
		$result .= '<form class="order-form-mail-pdf" method="post"  action="">';
		$result .= $num;
		//$result .= '<div class="er_form_input_container"><input type="email" name="emailpdfsended" class="required border_radius_general" placeholder="'.$user_info->data->user_email.'" value="'.$user_info->data->user_email.'"></div>';
		//$result .= '<div class="er_form_input_container" style="display:none;"><input type="text" name="filepdfsended" id="filepdfsended" placeholder="" value=""></div>';
		//$result .= '<div class="er_form_input_container"><div class="g-recaptcha" data-sitekey="6Lf6dpIUAAAAALNlGI5LwOMRyOOFLLuSqoeBExgr" data-theme="light" style="transform:scale(0.8); transform-origin:0;"></div></div>';
		//$result .= '<input type="submit" name="submit" value="Отправить" class="er_form_submit">';
		$result .= '</form>';
		$result .= '</div>';
		$result .= '</div>';
		echo $result;

		echo '
    <script type="text/javascript">
    //jQuery(document).ready(function($){
      //  alert("go");
        //$(\'.popup_close_button\').on(\'click\', function(){
          //$("#popup_price_modal").empty();
          //$("#popup_price_modal_footer").empty();
      //});
    //});
    
    </script>
    ';
		echo '<script type="text/javascript">
    $(document).ready(function(){
        $(\'.order-form-mail-pdf\').on(\'submit\', function(e) {
        e.preventDefault();
        $.ajax({
            url: "https://etorazvod.ru/wp-admin/admin-ajax.php",
            type: \'POST\',
            data: \'action=sendpdf&\'+$(this).serialize(),
            beforeSend: function(xhr) {

            },
            success: function(data) {
                result = $.parseJSON(data);    
                if (result.status == "notemail") {
                    $(\'.text-wrapper-accept\').remove();
                    $(\'input[name="emailpdfsended"]\').after(\'<span class="text-wrapper-accept">Некорректный e-mail</span>\');
                    grecaptcha.reset();
                } else if (result.status == "recaptcha") {
                    $(\'.text-wrapper-accept\').remove();
                    $(\'input[name="emailpdfsended"]\').after(\'<span class="text-wrapper-accept">Не пройдена проверка reCAPTCHA</span>\');
                    grecaptcha.reset();
                } else if (result.status == "ok") {
                    $(".order-form-mail-pdf").css("display","none");
                    $("#sender_form_popup_title").text("Сообщение успешно отправлено");
                    $(".er_form_subtext").remove();
                } 
               
            }
            });
        })
    });    
    </script>';
		die;
	}
} ?>