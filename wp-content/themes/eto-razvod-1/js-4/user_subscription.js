$ = jQuery.noConflict();

function ajax_subscribes_list(userid, sort) {
    $('.subscribes_wrapper').empty();
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=get_user_subs&userid="+userid+"&sort="+sort,
        beforeSend: function(xhr) {
            $('.subscribes_wrapper').append('<div class="load_ajax"></div>');
        },
        complete: function(){
            $(".subscribes_wrapper .load_ajax").remove();
        },
        success: function( data ) {
            $('.subscribes_wrapper').html(data);
            if ((($(data).length < 2) || (parseInt($('.comments_top_count').text()) == 0)) && (typeof userid !== 'undefined')) {
                $('.subscribes_wrapper').empty();
                user_zero_message('subs');
            }
            $( ".review_average_round" ).each(function() {

                var id = $(this).attr('id');
                var percent = $(this).attr('data-percent');
                append_circle_bar(id,percent);
                append_circle_bar_n(id,percent);

            });
        }
    });
}
function append_circle_bar_n(id,percent) {
    var progressBar =
        new ProgressBar.Circle('.third_column .review_average_round#'+id, {
            color: '#001640',
            strokeWidth: 5,
            duration: 500, // milliseconds
            easing: 'easeInOut'
        });

    progressBar.animate(percent); // percent
};
jQuery(document).ready(function($){
    ajax_subscribes_list(my_ajax_object.user_id, 'new');
});
