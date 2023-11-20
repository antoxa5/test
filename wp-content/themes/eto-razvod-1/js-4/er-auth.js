jQuery(document).ready(function($){
	$('#popup_auth_form').on('submit', function(e) {
		e.preventDefault();
		$('.reg_error').remove();
		var form = $(this);
		$.post(form.attr('action'), form.serialize(), function(data) {
			result = JSON.parse(data);
				if(result.status === 'ok') {
					$('#popup_auth').remove();
					auth_action();
				} else {
					$( '<div class="font_smaller m_b_20 color_red reg_error">'+result.message+'</div>' ).insertBefore( $( '#popup_auth_form input[name="email"]' ) );
					setTimeout(function() {
					  $('.reg_error').remove();
					}, 5000);
				}
		});
	});
	
	

});