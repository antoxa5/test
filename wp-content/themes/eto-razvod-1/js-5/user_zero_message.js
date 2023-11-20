function user_zero_message(type) {
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: "POST",
        data: "action=user_zero_messages&type="+type,
        beforeSend: function(xhr) {
        },
        complete: function(){

        },
        success: function( data ) {
            $('#abuses, #reviews,.subscribes_wrapper').append(data);
        }
    });
}