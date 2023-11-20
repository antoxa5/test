$ = jQuery.noConflict();

function load_thread(thread_id) {
	$('.user_messages_thread').empty();
	
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=load_thread&thread_id="+thread_id,
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

function company_direct_message_redirect(user_id,company_id,company_slug) {
	
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=company_direct_message_redirect&user_id="+user_id+"&company_id="+company_id+"&company_slug="+company_slug,
		beforeSend: function(xhr) {
			//$('.user_messages_thread').append('<div class="load_ajax"></div>');
		},
		complete: function(){
			//$('.user_messages_thread .load_ajax').remove();
		},
		success: function( data ) {
			result = JSON.parse(data);
			
			if(result.type === 'new') {
				//alert(result.user_id);
				window.location.href = '/dashboard/messages/company/'+result.company_slug+'/?new='+result.user_id;
			} else if (result.type === 'thread') {
				//alert(result.thread_id);
				window.location.href = '/dashboard/messages/company/'+result.company_slug+'/?thread='+result.thread_id;
			}
		}
	});
};

function load_thread_company(thread_id,comp_id) {
	$('.user_messages_thread').empty();
	
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=load_thread_company&thread_id="+thread_id+"&comp_id="+comp_id,
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
	//alert('load');
	
	//alert(thread_id_first);
	$('body').on('click','.message_users_list.users li.inactive',function (){
			var thread_id = $(this).attr('data-thread-id');
		$('.message_users_list li').removeClass('current');
		load_thread(thread_id);
		$(this).addClass('current');
	});
	//$('.message_users_list li.inactive:first-child').trigger('click');
	//$( window ).load(function() {
	  
		//$('.message_users_list li.inactive:first-child').trigger('click');
	//});
	
	$('body').on('click','.go_private_mail',function (e){
			//alert('go');
		e.preventDefault();
		var user_id = $(this).attr('data-user-id');
		var company_id = $(this).attr('data-company-id');
		var company_slug = $(this).attr('data-company-slug');
		company_direct_message_redirect(user_id,company_id,company_slug);
	});
	$('body').on('click','.message_users_list.companies li.inactive',function (){
			var thread_id = $(this).attr('data-thread-id');
		$('.message_users_list li').removeClass('current');
		var comp_id = $(this).attr('data-company-id');
		load_thread_company(thread_id,comp_id);
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
				load_thread(result.thread_id);
				//alert(result.thread_id);
			} else {
				//alert(result.message);
				$( '<div class="font_smaller m_b_20 color_red reg_error">'+result.message+'</div>' ).insertBefore( $( '#messages-respond .respond-buttons' ) );
				setTimeout(function() {
					$('#messages-respond .reg_error').remove();
				}, 3000);
			}
		});
	});
	$('body').on('submit','.from_company#messages-respond',function (e){
		//alert('ddd');
		e.preventDefault();
		var form = $(this);
		$.post(form.attr('action'), form.serialize(), function(data) {
			//alert(data);
			result = JSON.parse(data);
			
			if(result.status === 'ok') {
				load_thread_company(result.thread_id,result.comp_id);
			} else {
				//alert(result.message);
				$( '<div class="font_smaller m_b_20 color_red reg_error">'+result.message+'</div>' ).insertBefore( $( '#messages-respond .respond-buttons' ) );
				setTimeout(function() {
					$('#messages-respond .reg_error').remove();
				}, 3000);
			}
		});
	});
	$('body').on('submit','.from_company_new#messages-respond',function (e){
		//alert('ddd');
		e.preventDefault();
		var form = $(this);
		$.post(form.attr('action'), form.serialize(), function(data) {
			//alert(data);
			result = JSON.parse(data);
			
			if(result.status === 'ok') {
				window.location.replace('/dashboard/messages/company/'+result.company_slug+'/');
				//window.location.replace = '/dashboard/messages/company/'+result.company_slug+'/';
				//alert('kk');
				//load_thread_company(result.thread_id,result.comp_id);
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