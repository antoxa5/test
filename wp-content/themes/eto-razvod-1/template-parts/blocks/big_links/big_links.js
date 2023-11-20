var paddingL = 38;
var paddingR = 38;
var borderL = 1;
var borderR = 1;
var marginL = 10;
var marginR = 10;
var additional = 0;
var i = 0;

$('body').on('click', '.big_link_arrow', function () {
    if ($(window).width() > 699) {
        if ($( this ).hasClass( "clicked" )) {
        } else {
            $(this).addClass('clicked');
            var data_link = $(this).attr('data-link');
            var clicked_block = $(this);
            if (data_link == "left") {
                elem = '.block_big_links ul > li:first-child';
            } else {
                elem = '.block_big_links ul > li:first-child';
            }
            var thisHtml = $(elem);
            var blockWidth = $(elem).width();
            var blockWidthFull = blockWidth + paddingL + paddingR + borderL + borderR + marginL + marginR + additional;

            if (data_link == "left") {
                thisHtml.clone().appendTo('.block_big_links ul');
            } else {
                $(elem).addClass('thisEl');
                $('.block_big_links ul > li:last-child').clone().prependTo('.block_big_links ul').css({
                    "position": "absolute",
                    "width": blockWidth,
                    "left": '-=' + blockWidthFull
                });
            }

            if (data_link == "left") {
                $(elem).animate({"margin-left": '-=' + blockWidthFull + ''}, 500, function () {
                    $('.block_big_links ul > li:last-child').attr('style', '');
                    $(elem).remove();
                    clicked_block.removeClass('clicked');
                })

                $(elem).animate({"margin-left": '-=' + blockWidthFull + ''}, 500, function () {
                    $('.block_big_links ul > li:last-child').attr('style', '');
                    $(elem).remove();
                    clicked_block.removeClass('clicked');
                })

            } else {

                $('.block_big_links ul > li:first-child').animate({"left": ''+marginL+''}, 500, function () {
                    $('.block_big_links ul > li:first-child').attr('style', '');
                });

                $('.thisEl').animate({"margin-left": '+=' + blockWidthFull + ''}, 500, function () {
                    $('.thisEl').attr('style', '');
                    $('.block_big_links ul > li:last-child').remove();
                    $('.thisEl').removeClass('thisEl');
                    clicked_block.removeClass('clicked');
                });



            }

        }
    } else {
        var data_link = $(this).attr('data-link');
        if (data_link == "left") {
            $('.tabs_mobile_mover_big_links .tabs_mobile_mover__item_active').prev().click();
        } else {
            $('.tabs_mobile_mover_big_links .tabs_mobile_mover__item_active').next().click();
        }
    }
});

$('body').on('click','.big_link_arrow.big_links_icon_left', function () {

});
$('body').on('click', '.tabs_hidden_tabs span.inactive', function () {
    var tab = $(this).attr('data-container');
    var block_id = $(this).closest('.block_big_links').attr('id');
    $('#'+block_id+' .tabs_hidden_tabs span.active').addClass('inactive');
    $('#'+block_id+' .tabs_hidden_tabs span.active').removeClass('active');
	$('#'+block_id+' ul.flex.active').removeClass('active');
    $('#'+block_id+' ul.flex.active').addClass('inactive');
   // $('#'+block_id+' ul.flex').hide();
	$('#'+block_id+' ul.flex.'+tab).removeClass('inactive');
    $('#'+block_id+' ul.flex.'+tab).addClass('active');
    $(this).addClass('active');
    $(this).removeClass('inactive');

});
$('body').on('click', '.tabs_mobile_mover_big_links .tabs_mobile_mover__item', function () {
    active_number = $('.tabs_mobile_mover_big_links .tabs_mobile_mover__item_active').attr('data-n');
    data_number = $(this).attr('data-n');
    step = parseInt(data_number) - parseInt(active_number);
    console.log('test');
    t = 40;
    if (step > 0) {
        t = t + (10 * (data_number-1));
        v = (100 * data_number) - 100;
        $('.block_big_links .first_tabs > li:first-child').attr('style','margin-left: calc(-'+v+'% + '+t+'px);');
    } else {
        t = t + (10 * (data_number-1));
        v = (100 * data_number) - 100;
        $('.block_big_links .first_tabs > li:first-child').attr('style','margin-left: calc(-'+v+'% + '+t+'px);');
    }

    $('.tabs_mobile_mover_big_links .tabs_mobile_mover__item').removeClass('tabs_mobile_mover__item_active');
    $(this).addClass('tabs_mobile_mover__item_active');
})


if ($(window).width() < 701) {
    $.getScript("/wp-content/themes/eto-razvod-1/js/jquery.touchSwipe.min.js", function() {
        $(".first_tabs").swipe( {
            swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
                $('.tabs_mobile_mover_big_links .tabs_mobile_mover__item_active').next().click();
                //$('.tabs_mobile_mover_new_companies_ul .tabs_mobile_mover__item_active').next().click();
                // } else {
                //
                // }
            },
            threshold:0,
            excludedElements: "a, .compare_container",
        });
        $(".first_tabs").swipe( {
            swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
                $('.tabs_mobile_mover_big_links .tabs_mobile_mover__item_active').prev().click();
                //$('.tabs_mobile_mover_new_companies_ul .tabs_mobile_mover__item_active').next().click();
                // } else {
                //
                // }
            },
            threshold:0,
            excludedElements: "a, .compare_container"
        });
    });
}