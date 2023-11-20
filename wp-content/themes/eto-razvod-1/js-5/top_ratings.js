$('body').on('click', '.tabs_mobile_mover_top_ratings_item .tabs_mobile_mover__item', function () {
    active_number = $('.tabs_mobile_mover_top_ratings_item .tabs_mobile_mover__item_active').attr('data-n');
    data_number = $(this).attr('data-n');
    step = parseInt(data_number) - parseInt(active_number);

    t = 12;
    if (step > 0) {
        t = 24 + (12 * (data_number - 1));
        if ($(window).width() > 701) {
            t = 0;
        }
        v = (100 * data_number) - 100;
        if (data_number == 3) {
            if ($(window).width() > 701) {
                $('.top_ratings > div:first-child').attr('style','margin-left: calc(-'+v+'% / 3 + '+t+'px);');
            } else {
                $('.top_ratings > div:first-child').attr('style','margin-left: calc(-'+v+'% + 50px);');
            }

        } else {
            if ($(window).width() > 701) {
                $('.top_ratings > div:first-child').attr('style', 'margin-left: calc(-' + v + '% / 3 + ' + t + 'px);');
            } else {
                t = 22 + ((data_number - 1) * 14);
                $('.top_ratings > div:first-child').attr('style','margin-left: calc(-'+v+'% + '+t+'px);');
            }
        }
    } else {
        t = 24 + (12 * (data_number - 1));
        if ($(window).width() > 701) {
            t = 0;
        }
        v = (100 * data_number) - 100;
        if (data_number == 3) {
            if ($(window).width() > 701) {
                $('.top_ratings > div:first-child').attr('style','margin-left: calc(-'+v+'% / 3 + '+t+'px);');
            } else {
                $('.top_ratings > div:first-child').attr('style','margin-left: calc(-'+v+'% + 50px);');
            }

        } else {
            if ($(window).width() > 701) {
                $('.top_ratings > div:first-child').attr('style', 'margin-left: calc(-' + v + '% / 3 + ' + t + 'px);');
            } else {
                t = 22;
                $('.top_ratings > div:first-child').attr('style','margin-left: calc(-'+v+'% + '+t+'px);');
            }
        }
    }

    $('.tabs_mobile_mover_top_ratings_item .tabs_mobile_mover__item').removeClass('tabs_mobile_mover__item_active');
    $(this).addClass('tabs_mobile_mover__item_active');
    $(this).addClass('tabs_mobile_mover__item_active_2');
    console.log('1111111');
});

$('body').on('click','.big_links_icons_rate_arrow_right', function () {
    if ($('.tabs_mobile_mover_top_ratings_item span.tabs_mobile_mover__item_active').next().size() == 0) {
        $('.tabs_mobile_mover_top_ratings_item > span:first-child').click();
    } else {
        $('.tabs_mobile_mover_top_ratings_item span.tabs_mobile_mover__item_active').next().click();
    }
});

$('body').on('click','.big_links_icons_rate_arrow_left', function () {
    if ($('.tabs_mobile_mover_top_ratings_item span.tabs_mobile_mover__item_active').prev().size() == 0) {
        $('.tabs_mobile_mover_top_ratings_item > span:last-child').click();
    } else {
        $('.tabs_mobile_mover_top_ratings_item span.tabs_mobile_mover__item_active').prev().click();
    }
});


if ($(window).width() < 701) {
    $.getScript("/wp-content/themes/eto-razvod-1/js/jquery.touchSwipe.min.js", function() {
        $(".top_ratings").swipe( {
            swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
                $('.tabs_mobile_mover_top_ratings_item .tabs_mobile_mover__item_active').next().click();
                //$('.tabs_mobile_mover_new_companies_ul .tabs_mobile_mover__item_active').next().click();
                // } else {
                //
                // }
            },
            threshold:0,
            excludedElements: "a, .compare_container",
        });
        $(".top_ratings").swipe( {
            swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
                $('.tabs_mobile_mover_top_ratings_item .tabs_mobile_mover__item_active').prev().click();
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