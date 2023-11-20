$ = jQuery.noConflict();
jQuery(function($){
	$('body').on('click','span.change',function (){
		let foo = prompt('Введите ID нового обзора, если случайно нажали - то нажмите отмена');
		if (foo != null && foo !== null && foo != '') {
			var input = $(this),
				parent_id = foo,
				comment_id = input.attr('comment_id');
			console.log(parent_id);
			console.log(comment_id);

			$.ajax({
				url: '/wp-admin/admin-ajax.php',
				type: "POST",
				method : 'POST', //Post method
				data: "action=misha_change_comment_parent&parent_id=" + parent_id + "&comment_id=" + comment_id,
				beforeSend: function (xhr) {

				},
				success: function (data) {
					location.reload();
				}
			});
		}
		/**/
	});

});

