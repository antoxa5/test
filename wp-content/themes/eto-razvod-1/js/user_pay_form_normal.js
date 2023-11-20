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
            el.prev().on('click', decrement);
            el.next().on('click', increment);

            function decrement() {
                var value = el[0].value;
                value--;
                (value < 1) ? value = 1: '';
                if (!min || value >= min) {
                    el[0].value = value;
                }
            }

            function increment() {
                var value = el[0].value;
                value++;
                if (!max || value <= max) {
                    el[0].value = value++;
                }
            }
        }
    };
})();

inputNumber($('.input-number-mod'));
$(".input-number-mod").on("change paste keyup", function() {
    if ($(this).val() == '') {
        numberinputnumbermod = 1;
    } else {
        numberinputnumbermod = $(this).val();
    }
    alert(numberinputnumbermod);
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


});
$('input[name="payfrombalance"]').change(function() {
    $('.input-number-mod-increment').click();
    $('.input-number-mod-decrement').click();
});