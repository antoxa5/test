$ = jQuery.noConflict();

function ajax_subscribe_profile_block(userid,type) {
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=user_subscribe_data&userid="+userid+"&type="+type,
        beforeSend: function(xhr) {
        },
        complete: function(){
        },
        success: function( data ) {
            $('.subscribe_widget_user_profile').remove();
            $('.container_side').prepend(data);

        }
    });

}

function ajax_subscribe_user(userid) {
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=ajax_subscribe_user&userid="+userid,
        beforeSend: function(xhr) {
        },
        complete: function(){
        },
        success: function( data ) {
            result = JSON.parse(data);
            if(result.status === 'added') {
                $('#subcribe_user').addClass('active');
            } else if (result.status === 'deleted') {
                $('#subcribe_user').removeClass('active');
            } else if (result.status === 'auth') {
                auth_link(result.message);
            } else if (result.status === 'this') {
            }
        }
    });
}

jQuery(document).ready(function($){
    userid = parseInt(my_ajax_object.user_id);
    current_user_id = parseInt(my_ajax_object.current_user_id);
    ajax_subscribe_profile_block(userid,"profile");
    get_feed_user_profile('new',userid,0,0,0,0,0,'normal');

    $('body').on('click', '#subcribe_user', function(){
        ajax_subscribe_user(userid);
    });

    $('.profile_arrow_wrapper > span').click(function(){

        //valuerate = parseInt($(this).parent().parent().attr('data-value-rate'));

        if ($(this).hasClass( "number_profile_up" ) == true) {
            thisnumber_rate = 1
        } else {
            thisnumber_rate = -1
        }
        rateObj = $(this);

        $.ajax({
            url: my_ajax_object.ajax_url,
            type: "POST",
            data: "action=updownrate&user_id="+user_page.user_id+"&thisnumber_rate="+thisnumber_rate,
            beforeSend: function(xhr) {
                //$('#reviews').append('<div class="load_ajax"></div>');
            },
            complete: function(){
                //$("#reviews .load_ajax").remove();
            },
            success: function( data ) {
                //$('#reviews').append(data);

                result = $.parseJSON(data);
                popup_alert_message(result.message,result.status);
                if (result.status == "ok") {
                    $('.number_profile > span:first-child').text(result.all_rates_gl);
                    // if (rateObj.hasClass( "number_profile_up" ) == true) {
                    //     $('.number_profile > span:first-child').text(valuerate+1);
                        //     numberchecker = valuerate+1;
                    // } else {
                    //     $('.number_profile > span:first-child').text(valuerate-1);
                    //     numberchecker = valuerate-1;
                    // }
                    $('.this-number-profile_plus').html(result.good_rates_gl);
                    $('.this-number-profile_minus').html(result.all_rates_minus);
                    $('.minus_name').html(result.minus_name);
                    $('.plus_name').html(result.plus_name);

                    if (parseInt(result.all_rates_gl) == 0) {
                        $('.number_profile > span:first-child').attr('class','temp');
                        $('.number_profile > span:first-child').attr('class','color_medium_gray');
                    }
                    if (parseInt(result.all_rates_gl) < 0) {
                        $('.number_profile > span:first-child').attr('class','temp');
                        $('.number_profile > span:first-child').attr('class','color_red');
                    }

                    if (parseInt(result.all_rates_gl) > 0) {
                        $('.number_profile > span:first-child').attr('class','temp');
                        $('.number_profile > span:first-child').attr('class','color_green');
                        $('.number_profile > span:first-child').text('+'+result.all_rates_gl);
                    }
                }
            }
        });

    })

    /*starnumbers = 0;*/
/*    $('.profile_main_footer > .stars > div').each(function() {
        starnumbers = ++starnumbers;
        $(this).attr('data-star',starnumbers);
    })
    $('.profile_main_footer > .stars > div').on("mouseover mouseout mousemove",function(evt){
        var x = evt.pageX - $(this).offset().left;
        $(this).removeAttr('class');
        if (x < 25) {
            $(this).addClass('half');
        } else {
            $(this).addClass('full');
        }

        $(this).nextAll().removeAttr('class');
        $(this).prevAll().removeAttr('class');
        $(this).prevAll().addClass('full');
    });

    $( ".profile_main_footer > .stars > div" ).mouseleave(function(){
        $( ".profile_main_footer > .stars > div").removeAttr('class');
    });
    $( ".profile_main_footer > .stars > div" ).click(function(evt1) {
        var x_pos = evt1.pageX - $(this).offset().left;
        var stars = $(this).attr('data-star');
        $.ajax({
            url: my_ajax_object.ajax_url,
            type: "POST",
            data: "action=update_user_star_rating&userid="+userid+"&stars="+stars+"&x_pos="+x_pos,
            beforeSend: function(xhr) {
            },
            complete: function(){
            },
            success: function( data ) {
                alert(data);

            }
        });
    });*/

    $( ".feed-info" ).on( "click", ".load_more_feed_profile", function() {

        data_review_post = $(this).attr('data_review_post');
        data_post = $(this).attr('data_post');
        data_review = $(this).attr('data_review');
        data_comment = $(this).attr('data_comment');
        data_abuse = $(this).attr('data_abuse');
        $('.load_more_feed_profile').remove();
        get_feed_user_profile(sort_type_feed,userid,data_review_post,data_post,data_review,data_comment,data_abuse, 'append');

    });
});

$('body').on("click",'.edit-button-profile',function (){
    window.location.href = '/dashboard/';
})