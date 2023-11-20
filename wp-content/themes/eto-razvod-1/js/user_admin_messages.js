$ = jQuery.noConflict();

function load_thread_admin(thread_id) {
    $('.user_messages_thread').empty();

    $.ajax({
        url: 'https://etorazvod.ru/wp-admin/admin-ajax.php',
        type: "POST",
        data: "action=load_thread_admin&thread_id="+thread_id,
        beforeSend: function(xhr) {
            $('.user_messages_thread').append('<div class="load_ajax"></div>');
        },
        complete: function(){
            $('.user_messages_thread .load_ajax').remove();
        },
        success: function( data ) {

            $('.user_messages_thread').append(data);
            $(".user_messages_thread .messages_list").scrollTop(function() { return this.scrollHeight; });
        }
    });
};




jQuery(document).ready(function($){
    $('body').on('click','.message_users_list.users li.inactive',function (){
        var thread_id = $(this).attr('data-thread-id');
        $('.message_users_list li').removeClass('current');
        load_thread_admin(thread_id);
        $(this).addClass('current');
    });

    $('body').on('submit','.from_user#messages-respond',function (e){
        //alert('ddd');
        e.preventDefault();
        var form = $(this);
        $.post(form.attr('action'), form.serialize(), function(data) {
            //alert(data);
            result = JSON.parse(data);

            if(result.status === 'ok') {
                load_thread_admin(result.thread_id);
            } else {
                //alert(result.message);
                $( '<div class="font_smaller m_b_20 color_red reg_error">'+result.message+'</div>' ).insertBefore( $( '#messages-respond .respond-buttons' ) );
                setTimeout(function() {
                    $('#messages-respond .reg_error').remove();
                }, 3000);
            }
        });
    });
});