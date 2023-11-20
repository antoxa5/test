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

                        $('.show-new-window-need > .show-new-window-inside').text(    parseInt(el[0].value) * parseInt($('.popup_service__middle_servicename').attr('data-price'))    );


                        if ((parseInt(el[0].value)) == 1) {
                            $('.popup_service__middle_takewordmonth-continue').text('');
                        } else if (((parseInt(el[0].value)) == 2) || ((parseInt(el[0].value)) == 3) || ((parseInt(el[0].value)) == 4)) {
                            $('.popup_service__middle_takewordmonth-continue').text('а');
                        } else if (((parseInt(el[0].value)) == 5) || ((parseInt(el[0].value)) == 6) || ((parseInt(el[0].value)) == 7) || ((parseInt(el[0].value)) == 8) || ((parseInt(el[0].value)) == 9) || ((parseInt(el[0].value)) == 0)) {
                            $('.popup_service__middle_takewordmonth-continue').text('ев');
                        }

                        if ( (parseInt(el[0].value) < 20) &&  (parseInt(el[0].value) > 9)) {
                            $('.popup_service__middle_takewordmonth-continue').text('ев');
                        } else if ( (parseInt(el[0].value) > 20)) {
                            if ((parseInt(el[0].value) % 10) == 1) {
                                $('.popup_service__middle_takewordmonth-continue').text('');
                            } else if (((parseInt(el[0].value) % 10) == 2) || ((parseInt(el[0].value) % 10) == 3) || ((parseInt(el[0].value) % 10) == 4)) {
                                $('.popup_service__middle_takewordmonth-continue').text('а');
                            } else if (((parseInt(el[0].value) % 10) == 5) || ((parseInt(el[0].value) % 10) == 6) || ((parseInt(el[0].value) % 10) == 7) || ((parseInt(el[0].value) % 10) == 8) || ((parseInt(el[0].value) % 10) == 9) || ((parseInt(el[0].value) % 10) == 0)) {
                                $('.popup_service__middle_takewordmonth-continue').text('ев');
                            }
                        }

                        if (parseInt(el[0].value) * parseInt($('.popup_service__middle_servicename').attr('data-price')) <= parseInt($('.popup_service__header_number').attr('data-balance'))) {





                            if ($('input[name="payfrombalance"]').is(':checked') == false) {

                                // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса




                                //$(\'span.nonebalance.nonebalance_last > span:first-child\').text( parseInt(el[0].value) * parseInt($('.popup_service__middle_servicename').attr('data-price') );

                            } else {
                                // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
                                //$(\'.fromcardjs\').css(\'display\',\'none\');
                            }

                        } else {



                            //$(\'span.nonebalance > span:first-child,.show-new-window-not-have>span:first-child\').text(parseInt($(\'span.price2.pricer3.pricer_first_chapter\').text()) - parseInt($(\'.balancer2ins.balancer2ins3ins\').text()));
                            if (parseInt($('.popup_service__header_number').attr('data-balance')) > 0) {
                                if ($('input[name="payfrombalance"]').is(':checked') == false) {

                                    // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса



                                    //$('span.nonebalance.nonebalance_last > span:first-child').text( parseInt(el[0].value) * parseInt($('.popup_service__middle_servicename').attr('data-price') );

                                } else {
                                    // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
                                }
                            } else {
                                // если у юзверя нет баланса вообще
                            }


                        }



                    }
                }

                function increment() {
                    var value = el[0].value;
                    value++;
                    if(!max || value <= max) {
                        el[0].value = value++;
                        $('.show-new-window-need > .show-new-window-inside').text(    parseInt(el[0].value) * parseInt($('.popup_service__middle_servicename').attr('data-price')    ));


                        if ((parseInt(el[0].value)) == 1) {
                            $('.popup_service__middle_takewordmonth-continue').text('');
                        } else if (((parseInt(el[0].value)) == 2) || ((parseInt(el[0].value)) == 3) || ((parseInt(el[0].value)) == 4)) {
                            $('.popup_service__middle_takewordmonth-continue').text('а');
                        } else if (((parseInt(el[0].value)) == 5) || ((parseInt(el[0].value)) == 6) || ((parseInt(el[0].value)) == 7) || ((parseInt(el[0].value)) == 8) || ((parseInt(el[0].value)) == 9) || ((parseInt(el[0].value)) == 0)) {
                            $('.popup_service__middle_takewordmonth-continue').text('ев');
                        }

                        if ( (parseInt(el[0].value) < 20) &&  (parseInt(el[0].value) > 9)) {
                            $('.popup_service__middle_takewordmonth-continue').text('ев');
                        } else if ( (parseInt(el[0].value) > 20)) {
                            if ((parseInt(el[0].value) % 10) == 1) {
                                $('.popup_service__middle_takewordmonth-continue').text('');
                            } else if (((parseInt(el[0].value) % 10) == 2) || ((parseInt(el[0].value) % 10) == 3) || ((parseInt(el[0].value) % 10) == 4)) {
                                $('.popup_service__middle_takewordmonth-continue').text('а');
                            } else if (((parseInt(el[0].value) % 10) == 5) || ((parseInt(el[0].value) % 10) == 6) || ((parseInt(el[0].value) % 10) == 7) || ((parseInt(el[0].value) % 10) == 8) || ((parseInt(el[0].value) % 10) == 9) || ((parseInt(el[0].value) % 10) == 0)) {
                                $('.popup_service__middle_takewordmonth-continue').text('ев');
                            }
                        }

                        if (parseInt(el[0].value) * parseInt($('.popup_service__middle_servicename').attr('data-price')) <= parseInt($('.popup_service__header_number').attr('data-balance'))) {





//        $(\'.frombalance\').attr(\'style\',\'display:block\');$(\'.fromcard\').attr(\'style\',\'display:none\');
//        $(\'#balancer_main_wrapper\').css(\'display\',\'block\');
//        $(\'span.price2.pricer3.pricer5.pricer6\').parent().css(\'display\',\'block\');


                            if ($('input[name="payfrombalance"]').is(':checked') == false) {

                                // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса



                                //$(\'span.nonebalance.nonebalance_last > span:first-child\').text( parseInt(el[0].value) * parseInt($('.popup_service__middle_servicename').attr('data-price') );

                            } else {
                                //paytype = \'twospay\';
                                // если у юзверя есть баланс более чем 0 и он хочет платить с баланса
                                //$(\'.fromcardjs\').css(\'display\',\'none\');


                            }


                        } else {


                        }
                    } else {
                        // если у юзверя нет баланса вообще



                        //$(\'.tgw-wrapper\').css(\'justify-content\',\'center\');

                    }

                }


            }
        }

    }


)();

inputNumber($('.input-number-mod'));
$(".input-number-mod").on("change paste keyup", function() {
    if ($(this).val() == '') {
        numberinputnumbermod = 1;
    } else {
        numberinputnumbermod = $(this).val();
    }

    if ((numberinputnumbermod) == 1) {
        $('.popup_service__middle_takewordmonth-continue').text('');
    } else if (((numberinputnumbermod) == 2) || ((numberinputnumbermod) == 3) || ((numberinputnumbermod) == 4)) {
        $('.popup_service__middle_takewordmonth-continue').text('а');
    } else if (((numberinputnumbermod) == 5) || ((numberinputnumbermod) == 6) || ((numberinputnumbermod) == 7) || ((numberinputnumbermod) == 8) || ((numberinputnumbermod) == 9) || ((numberinputnumbermod) == 0)) {
        $('.popup_service__middle_takewordmonth-continue').text('ев');
    }

    if ( (numberinputnumbermod < 20) &&  (numberinputnumbermod > 9)) {
        $('.popup_service__middle_takewordmonth-continue').text('ев');
    } else if ( (numberinputnumbermod > 20)) {
        if ((numberinputnumbermod % 10) == 1) {
            $('.popup_service__middle_takewordmonth-continue').text('');
        } else if (((numberinputnumbermod % 10) == 2) || ((numberinputnumbermod % 10) == 3) || ((numberinputnumbermod % 10) == 4)) {
            $('.popup_service__middle_takewordmonth-continue').text('а');
        } else if (((numberinputnumbermod % 10) == 5) || ((numberinputnumbermod % 10) == 6) || ((numberinputnumbermod % 10) == 7) || ((numberinputnumbermod % 10) == 8) || ((numberinputnumbermod % 10) == 9) || ((numberinputnumbermod % 10) == 0)) {
            $('.popup_service__middle_takewordmonth-continue').text('ев');
        }
    }


    numberinputnumbermod = Math.abs(parseInt(numberinputnumbermod));
    if (numberinputnumbermod == "0") {
        numberinputnumbermod = 1;
    }

    if (isNaN(numberinputnumbermod)) {
        numberinputnumbermod = 1;
    }

    $('.show-new-window-need > .show-new-window-inside').text(    parseInt(numberinputnumbermod) * parseInt($('.popup_service__middle_servicename').attr('data-price')    ));

    if ((parseInt(numberinputnumbermod) * parseInt($('.popup_service__middle_servicename').attr('data-price')) <= parseInt($('.popup_service__header_number').attr('data-balance'))) {










        if ($('input[name="payfrombalance"]').is(':checked') == false) {

// если у юзверя есть баланс более чем 0 и он не хочет платить с баланса




        } else {
            //paytype = \'twospay\';
            // если у юзверя есть баланс более чем 0 и он хочет платить с баланса


        }


    } else {



        if (parseInt($('.popup_service__header_number').attr('data-balance')) > 0) {
            if ($('input[name="payfrombalance"]').is(':checked') == false) {


                // если у юзверя есть баланс более чем 0 и он не хочет платить с баланса




            } else {

                // если у юзверя есть баланс более чем 0 и он хочет платить с баланса

            }
        } else {
            // если у юзверя нет баланса вообще



            //$(\'.tgw-wrapper\').css(\'justify-content\',\'center\');
        }

    }
});


});
});




});

$('input[name="payfrombalance"]').change(function() {
    $('.input-number-mod-increment').click();
    $('.input-number-mod-decrement').click();
});