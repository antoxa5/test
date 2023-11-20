$ = jQuery.noConflict();
//alert(my_ajax_object_new.er_blog_url);


function compare_icon() {
	$( ".compare_container" ).empty();
	//alert('ddd');
	$( ".compare_container" ).each(function() {

		var id = $(this).attr('id');
		//alert(id);
		var post_id = $(this).attr('data-post-id');
		//alert(post_id);
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=compare_icon_ajax&post_id="+post_id,
			beforeSend: function(xhr) {
			},
			complete: function(){
			},
			success: function( data ) {
				//alert(data);
				$( "#"+id ).append(data);
			}
		});
	});
}

function user_bar() {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=user_auth",
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			$('.header .auth_button').remove();
			$('.header .mobile_auth_icon').remove();
			$('.header .user_nav_mobile').remove();
			$('.header .user_bar').remove();
			$('.header .wrap').append(data);
		}
	});
}


function user_nav_mobile() {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=user_nav_mobile",
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			$('.header .user_nav_mobile .user_mobile_content').empty();
			$('.header .user_nav_mobile .user_mobile_content').append(data);
			$('.header .user_nav_mobile').show();
		}
	});
}
var queries = new Object();
function comment_rate_action(action,comment_id) {
	//alert(action + ' ' + comment_id);
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=comment_rate_action&rate_action="+action+"&comment_id="+comment_id,
		beforeSend: function(xhr) {

		},
		complete: function(){
		},
		success: function( data ) {
			result = JSON.parse(data);
			if(result.status === 'error') {
				popup_alert_message(result.message,'error');
			} else {
				if (action == 'plus') {
					thisnumber_rate = 1;
				} else if (action == 'minus') {
					thisnumber_rate = -1;
				}

				$.ajax({
					url: my_ajax_object.ajax_url,
					type: "POST",
					data: "action=updownrate&user_id="+comment_id+"&thisnumber_rate="+thisnumber_rate,
					beforeSend: function(xhr) {

					},
					complete: function(){
					},
					success: function( data ) {
						result = $.parseJSON(data);
					}
				});

				$('#rate-comment-'+comment_id+' .rate_number').empty();
				$('#rate-comment-'+comment_id+' .rate_number').append(result.new_value);
				$('#rate-comment-'+comment_id+' .rate_number').removeClass('negative positive neutral');
				$('#rate-comment-'+comment_id+' .rate_number').addClass(result.new_value_type);
			}

		}
	});
}


function recent_visited() {

	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=recent_visited",
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			alert(data);
			$('.footer .recent_visited').remove();
			$('.footer').append(data);

		}
	});
}
function pre_footer() {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=pre_footer",
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			$('.footer_top .pre_footer').remove();
			$('.footer_top').append(data);
		}
	});
}

function header_sections() {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=append_main_nav&actual_link="+my_ajax_object.actual_link,
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			$('#header_sections_nav').empty();
			$('#header_sections_nav').append(data);
		}
	});
}

function header_sections_more() {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=append_main_nav_more&actual_link="+my_ajax_object.actual_link,
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			$('.header_section_sub_links').remove();
			$('#header_sections_nav').append(data);
		}
	});
}

function main_footer() {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=main_footer",
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			$('.footer .main_footer').remove();
			$('.footer').append(data);
		}
	});
}

function auth_action() {

	user_bar();
	single_review_icons();
	compare_icon();
	$('.user_mobile_content').empty();
	$('.user_nav_mobile').hide();
	var c_post_id = my_ajax_object.current_post_id;
	var userid = parseInt(my_ajax_object.user_id);
	if((c_post_id !== 0) && (c_post_id != null)) {
		//ajax_subscribe_block(my_ajax_object.current_post_id);
	}
	if(userid != 0) {
		ajax_subscribe_profile_block(userid);
	}

}

function link_logout() {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=user_logout_ajax",

		success: function( data ) {
			//alert(data);
			if (parseInt(data) == 0) {
				if (typeof dashboard_var === 'undefined') {
					//location.href="/";
				} else {
					location.href="/";
				}
			}
			auth_action();
		}
	});

}

function user_nav() {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=user_nav",
		success: function( data ) {
			$('.header .user_bar .user_nav').remove();
			$('.header .user_bar').append(data);
		}
	});

}

function user_nav_settings() {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=user_nav_settings",
		success: function( data ) {
			$('.header .user_bar .user_nav').remove();
			$('.header .user_bar').append(data);
			var hidden = $('.user_nav_settings');
			hidden.animate({"right":"0px"}, 500).addClass('visible');
		}
	});

}

function popup_form(type,post_id) {

	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=popup_form_ajax&type="+type+"&post_id="+post_id,
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			$('#popup_modals').empty();
			$('#popup_modals').append(data);
			$('#popup_modals .popup_container').addClass('show');
			$('.popup_close_button').click(function() {
				var popup_id = $(this).closest('.popup_container').attr('id');
				$('#'+popup_id).remove();

			});
		}
	});
}

function popup_user_form(type,userid,service = '',typespend = '') {

	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=user_form&type="+type+"&userid="+userid+"&service="+service+"&typespend="+typespend,
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			$('#popup_modals').empty();
			$('#popup_modals').append(data);
			$('#popup_modals .popup_container').addClass('show');
			$('.popup_close_button').click(function() {
				var popup_id = $(this).closest('.popup_container').attr('id');
				$('#'+popup_id).remove();

			});

			if (type == 'edit_skills_popup') {
				$('.skills-comments__myskill').each(function() {
					skillturned = parseInt($(this).attr('data-skill'));
					$('#select_skills option').each(function() {
						select_skills = $(this).attr('value');
						if (skillturned == select_skills) {
							$(this).attr('disabled','disabled');
						}
					})
				})
			}
		}
	});
}

function popup_alert_message(message,type) {

	$.ajax({
		url: my_ajax_object.ajax_url,
		type: 'POST',
		data: 'action=popup_alert_message&message='+message+'&type='+type,
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			$('#popup_modals').empty();
			$('#popup_modals').append(data);
			$('#popup_modals .popup_container').addClass('show');
			$('.popup_close_button').click(function() {
				var popup_id = $(this).closest('.popup_container').attr('id');
				$('#'+popup_id).remove();

			});
		}
	});
}


function auth_link(message) {
	$('#popup_modals').empty();
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=popup_auth",
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			$('#popup_modals').append(data);
			$('#popup_modals .popup_container').addClass('show');
			$('.popup_close_button').click(function() {
				var popup_id = $(this).closest('.popup_container').attr('id');
				$('#'+popup_id).remove();

			});
			if(message == null) {
			} else {
				$( '<div class="font_smaller m_b_20 color_red">'+message+'</div>' ).insertBefore( $( '#popup_auth #popup_auth_form input[name="email"]' ) );
			}
			$('.reg_link').click(function() {
				reg_link();
			});
		}
	});
}

function comment_link_spam(comment_id) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=comment_link_spam&comment_id="+comment_id,
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			result = JSON.parse(data);
			$('.spam_link_result').remove();
			if(result.status === 'ok') {
				$('.comment_more_actions_links_' + comment_id).toggleClass('visible');
				$( '<div class="font_smaller m_b_20 color_green spam_link_result">'+result.message+'</div>' ).insertBefore( $( '.comment_text_'+comment_id ) );
			} else if (result.status === 'error') {
				$('.comment_more_actions_links_' + comment_id).toggleClass('visible');
				$( '<div class="font_smaller m_b_20 color_red spam_link_result">'+result.message+'</div>' ).insertBefore( $( '.comment_text_'+comment_id ) );
			} else if (result.status === 'auth') {
				auth_link(result.message);
			}
			setTimeout(function() {
				$('.spam_link_result').remove();
			}, 2000);
		}
	});
}


function ajax_bookmark(id,button_id) {
	//alert(id+' '+button_id);
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=ajax_bookmark&id="+id+"&button_id="+button_id,
		beforeSend: function(xhr) {
			//$('.spinner').show();
		},
		complete: function(){
			//$(".spinner").hide();
		},
		success: function( data ) {
			//alert(data);

			result = JSON.parse(data);
			if(result.status === 'added') {
				$('#'+button_id).addClass('active');
			} else if (result.status === 'deleted') {
				$('#'+button_id).removeClass('active');
			} else if (result.status === 'auth') {
				auth_link(result.message);
			}
		}
	});

}

function ajax_compare(id,button_id) {
	//alert(id+' '+button_id);
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=ajax_compare&id="+id+"&button_id="+button_id,
		beforeSend: function(xhr) {
			//$('.spinner').show();
		},
		complete: function(){
			//$(".spinner").hide();
		},
		success: function( data ) {
			//alert(data);

			result = JSON.parse(data);
			if(result.status === 'added') {
				$( '#'+button_id).each(function() {
					//alert('kk');
					$( '#'+button_id).addClass('active');
				});
			} else if (result.status === 'deleted') {
				$( '#'+button_id).each(function() {
					$( '#'+button_id).removeClass('active');
				});
			} else if (result.status === 'auth') {
				auth_link(result.message);
			}
		}
	});

}

function single_review_icons() {
	$( ".review_icons" ).each(function() {
		var id = $(this).attr('id');
		var post_id = $(this).attr('data-id');
		//alert(post_id);
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=single_review_icons&post_id="+post_id,
			beforeSend: function(xhr) {
				$( ".review_icons" ).empty();
				//$('.spinner').show();
			},
			complete: function(){
				//$(".spinner").hide();
			},
			success: function( data ) {
				//	alert(data);
				$( "#"+id ).append(data);
			}
		});
	});
}


function link_reset_password() {

	$('#popup_modals').empty();
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=ajax_popup_reset_password",
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			$('#popup_modals').append(data);
			$('#popup_modals .popup_container').addClass('show');
			$('.popup_close_button').click(function() {
				var popup_id = $(this).closest('.popup_container').attr('id');
				$('#'+popup_id).remove();

			});
			$('.reg_link').click(function() {
				reg_link();
			});
			$('.auth_link').click(function() {
				auth_link();
			});
		}
	});

}

function reg_link() {

	$('#popup_modals').empty();
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=popup_reg",
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			$('#popup_modals').append(data);
			$('#popup_modals .popup_container').addClass('show');
			$('.popup_close_button').click(function() {
				var popup_id = $(this).closest('.popup_container').attr('id');
				$('#'+popup_id).remove();

			});
			$('.auth_link').click(function() {
				auth_link();
			});
		}
	});

}

function topFunction() {
	document.body.scrollTop = 0; // For Safari
	document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
function auth_popup(provider) {

	// replace 'path/to/hybridauth' with the real path to this script
	//alert(my_ajax_object.h_auth_callback);
	var authWindow = window.open(my_ajax_object.h_auth_callback+'?provider=' + provider, 'authWindow', 'width=600,height=400,scrollbars=yes');

	window.closeAuthWindow = function () {
		authWindow.close();
		$('#popup_modals').empty();
		//auth_action();
	}



	return false;

}
function after_popup_login(type,action) {
	//alert(type+' '+action+' '+my_ajax_object.actual_link);
}
function append_circle_bar(id,percent) {
	var progressBar =
		new ProgressBar.Circle('.review_average_round#'+id, {
			color: '#001640',
			strokeWidth: 5,
			duration: 500, // milliseconds
			easing: 'easeInOut'
		});

	progressBar.animate(percent); // percent
};

function append_circle_bar_comments(id,percent,color) {
	var progressBar =
		new ProgressBar.Circle('.review_average_round#'+id, {
			color: color,
			strokeWidth: 5,
			duration: 500, // milliseconds
			easing: 'easeInOut'
		});

	progressBar.animate(percent); // percent
};

function append_services() {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=popup_nav&nav_place=header_services",
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			$('.header_icon_services .services_list').remove();
			$('.header_icon_services').append(data);

		}
	});
};
function ajax_load_list(taxonomy,id) {
	$('#'+id+' .taxonomy_field_terms').remove();
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=ajax_load_list&taxonomy="+taxonomy,
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			//alert(data);
			$('#'+id).append(data);
		}
	});
};

function ajax_show_company_map(post_id) {
	$('#map_container').empty();
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=show_company_map&post_id="+post_id,
		beforeSend: function(xhr) {
			$('#map_container').append('<div class="load_ajax"></div>');
		},
		complete: function(){
			$('#map_container .load_ajax').remove();
		},
		success: function( data ) {
			$('#map_container').append(data);
		}
	});
};


function load_popup_outside_form(type,company_name,id,exists,block_id,container) {
	$('#'+block_id+' .outside_form_container').empty();
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=load_popup_outside_form&type="+type+"&id="+id+"&exists="+exists+"&company_name="+company_name,
		beforeSend: function(xhr) {

			$('#'+block_id+' .outside_form_container').append('<div class="load_ajax"></div>');
		},
		complete: function(){
			$('#'+block_id+' .outside_form_container .load_ajax').remove();
		},
		success: function( data ) {
			$('#'+block_id+' .outside_form_container').append(data);
		}
	});
};

function copy_text(id) {
	var el = document.getElementById(id);
	var range = document.createRange();
	range.selectNodeContents(el);
	var sel = window.getSelection();
	sel.removeAllRanges();
	sel.addRange(range);
	document.execCommand('copy');
	return false;
}



function ajax_link_outside(type) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=ajax_link_outside&type="+type,
		beforeSend: function(xhr) {
		},
		complete: function(){
		},
		success: function( data ) {
			result = JSON.parse(data);
			if(result.status === 'ok') {
				$('#popup_modals').empty();
				$('#popup_modals').append(result.message);
				$('#popup_modals .popup_container').addClass('show');
				$('.popup_close_button').click(function() {
					var popup_id = $(this).closest('.popup_container').attr('id');
					$('#'+popup_id).remove();

				});
			} else if (result.status === 'auth') {
				auth_link(result.message);
			}
		}
	});

}

function ajax_upload_file(file_data,append_id) {
	console.log(file_data);
	form_data = new FormData();
	form_data.append('file', file_data);
	form_data.append('action', 'ajax_upload_file');
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: 'POST',
		contentType: false,
		processData: false,
		data: form_data,
		beforeSend: function(xhr) {
		},
		complete: function(){
		},
		success: function( data ) {
			result = JSON.parse(data);
			//alert(data);
			if(result.status === 'ok') {
				$('<li class="form_add_item" style="background-image:url(\''+result.thumb_url+'\');"><input type="hidden" name="files[]" value="'+result.file_id+'" /><span class="close"></span></li>').insertBefore('#'+append_id+' .form_add_images li.add_new');
			}
		}
	});
}

function form_icon_img(form_id) {

	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=ajax_append_form_images",
		beforeSend: function(xhr) {
			$('form#'+form_id+' .form_add_images').remove();
			$('form#'+form_id+' .form_icon_img').removeClass('inactive');
		},
		complete: function(){
			$('form#'+form_id+' .form_icon_img').addClass('active');
		},
		success: function( data ) {
			//alert(data);
			$(data).insertBefore( 'form#'+form_id+' .review_form_icons' );

		}
	});
}


var xhrCount_ac = 0;
function autocomplete_search_results(phrase,block_id,type, tags_values) {
	//alert(block_id);
	//alert(tags_values);
	var seqNumber = ++xhrCount_ac;
	var jqXHR;
	jqXHR = $.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=autocomplete_search_results&phrase=" + phrase+"&type="+type+"&tags="+tags_values,
		beforeSend: function (xhr) {
			if (seqNumber !== xhrCount_ac) {

				jqXHR.abort();
			} else {
				$('#' + block_id + ' .autocomplete_search_results').empty();
				$('#'+block_id+' .autocomplete_search_results').removeClass('active');
				$('.autocomplete_container#' + block_id).append('<div class="load_ajax"></div>');
			}
		},
		complete: function () {

		},
		success: function (data) {
			if (seqNumber === xhrCount_ac) {
				$('.autocomplete_container#' + block_id + ' .load_ajax').remove();
				// alert(data);
				// $('#'+block_id+' form').addClass('not_typing');
				$('#' + block_id + ' .autocomplete_search_results').empty();

				$('#' + block_id + ' .autocomplete_search_results').append(data);
				$('#'+block_id+' .autocomplete_search_results').addClass('active');


			}
		}
	});

};


function outside_append_new_comment(comment_id,type) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=outside_append_new_comment&comment_id="+comment_id+"&type="+type,
		beforeSend: function(xhr) {

		},
		complete: function(){

		},
		success: function( data ) {
			//alert(data);
			//$(data).insertAfter( ".comments_top" );
			$('#popup_link_outside_'+type+' .p_30').empty();
			$('#popup_link_outside_'+type+' .p_30').append(data);
			//$(".comments_top").after(data);
			$( ".review_average_round" ).each(function() {

				var id = $(this).attr('id');
				var percent = $(this).attr('data-percent');
				append_circle_bar(id,percent);
			});
		}
	});
}

var xhrCount_fr = 0;
function resort_ratings_all(block_id) {
	var form = $('#'+block_id+' form.outside_tags');
	var action = $('#'+block_id+' form.outside_tags input[name="action"]').val();
	var url = form.attr('action');
	var seqNumber_fr = ++xhrCount_fr;
	var jqXHR_fr;
	jqXHR_fr = $.ajax({
		type: "POST",
		url: url+'?action='+action,
		data: form.serialize(), // serializes the form's elements.
		beforeSend: function (xhr) {
			if (seqNumber_fr !== xhrCount_fr) {

				jqXHR_fr.abort();
			} else {
				$('.rating_container .wrap').empty();
				$('.rating_container .wrap').append('<div class="load_ajax"></div>');
			}
		},
		complete: function () {

		},
		success: function(data)
		{
			if (seqNumber_fr === xhrCount_fr) {
				$('.rating_container .wrap .load_ajax').remove();
				$('.rating_container .wrap').empty();
				$('.rating_container .wrap').append(data); // show response from the php script.
			}
		}
	});
}


function user_skills_add(skillid) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=user_skills_add&id="+skillid,
		beforeSend: function(xhr) {
		},
		complete: function(){
		},
		success: function( data ) {
			//obj.remove();
			console.log(skillid);
			//$()
			$('.skills-comments__myskill-wrapper').append(data);
			$('.popup_close_button').click();

		}
	});

}

function user_skills_add_mass(skillid) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=user_skills_add_mass&id="+skillid,
		beforeSend: function(xhr) {
		},
		complete: function(){
		},
		success: function( data ) {
			//obj.remove();
			console.log(skillid);
			//$()
			$('.skills-comments__myskill-wrapper').append(data);
			$('.popup_close_button').click();

		}
	});
}
var getUrlParameter = function getUrlParameter(sParam) {
	var sPageURL = window.location.search.substring(1),
		sURLVariables = sPageURL.split('&'),
		sParameterName,
		i;

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');

		if (sParameterName[0] === sParam) {
			return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
		}
	}
	return false;
};

jQuery(document).ready(function($){
	//compare_icon('compare_container');
	if (getUrlParameter('status') == 'not_logged_and_activate') {
		auth_link();
	}

	if (getUrlParameter('activation') == 'ok') {
		popup_alert_message('Ваш профиль успешно подтвержден','ok');
	}

	if (getUrlParameter('activation') == 'error') {
		popup_alert_message('Произошла ошибка активации, обратитесь за помощью на e-mail адрес - info@eto-razvod.ru','error');
	}

	$( ".comments_widget .review_average_round" ).each(function() {
		var id = $(this).attr('id');
		var percent = $(this).attr('data-percent');
		var color = $(this).attr('data-color');
		append_circle_bar_comments(id,percent,color);
	});
	$('body').on('click', '.form_icon_img.inactive', function(){
		var form_id = $(this).closest('form').attr('id');
		form_icon_img(form_id);
	});
	$('body').on('click', '.form_icon_img.active', function(){
		var form_id = $(this).closest('form').attr('id');
		$('form#'+form_id+' .form_add_images').remove();
		$('form#'+form_id+' .form_icon_img').removeClass('active');
		$('form#'+form_id+' .form_icon_img').addClass('inactive');
	});

	$('body').on('click', '.form_add_images .close', function(){
		$(this).closest('li').remove();
	});
	$('body').on('change', '.form_add_images li.add_new input', function() {
		var file_data = $(this).prop('files')[0];
		var append_id = $(this).closest('form').attr('id');;
		ajax_upload_file(file_data,append_id);
	});
	$(window).scroll(function(){
		var mybutton = document.getElementById('myBtn');
		if ($(window).scrollTop() >= 60) {
			$('.main_container').addClass('sticky_header');
			$('.main_container .header').addClass('dropdown_shadow');
			$('.main_container .header').removeClass('not_sticky_header');
			mybutton.style.display = "block";
		}
		else {
			$('.main_container').removeClass('sticky_header');
			$('.main_container .header').removeClass('dropdown_shadow');
			$('.main_container .header').addClass('not_sticky_header');
			mybutton.style.display = "none";
		}
	});

	$('body').on('click', '.link_logout', function(){
		link_logout();
	});

	$('body').on('click', '.comment_more_actions_link_spam', function(){
		var id = $(this).closest('li.comment').attr('data-commentid');
		comment_link_spam(id);
	});

	$('body').on('click', '.link_new_review_outside', function(){
		ajax_link_outside('review');
	});

	$('body').on('click', '.link_new_abuse_outside', function(){
		ajax_link_outside('abuse');
	});

	$('body').on('click', '.review_icon_share', function(){
		var type = $(this).attr('data-type');
		var id = $(this).attr('data-id');
		popup_form(type,id);
	});

	$('body').on('input','input[name="autocomplete_text"]',function() {

		var phrase = $(this).val();
		var block_id = $(this).closest('.autocomplete_container').attr('id');
		var search_type = $(this).closest('.autocomplete_container').attr('data-type');
		var container_id = $('#'+block_id).closest('.popup_container').attr('id');
		console.log(phrase +' '+ block_id +' '+ search_type +' '+ container_id);
		//alert(search_type);
		if(search_type === 'filter_ratings') {
			$('#'+container_id+' .outside_form_container').empty();
			var tags_values = $('#'+block_id+' .outside_tags input[name="tags[]"]').map(function(){return $(this).val();}).get();
			autocomplete_search_results(phrase,block_id,search_type,tags_values);
		} else {
			if(phrase.length > 1){
				$('#'+container_id+' .outside_form_container').empty();
				//$(this).closest('form').removeClass('not_typing');
				autocomplete_search_results(phrase,block_id,search_type);
			} else {
				$('#' + block_id + ' .autocomplete_search_results').empty();
			}
		}

	});

	$('body').on('click', '.comment_fast_links .comment_share', function(){
		var type = 'share_comment';
		var id = $(this).closest('li.comment').attr('data-commentid');
		popup_form(type,id);
	});

	$('body').on('click', '.comment_fast_links .comment_permalink', function(){
		var type = 'permalik_comment';
		var id = $(this).closest('li.comment').attr('data-commentid');
		popup_form(type,id);
	});

	$('body').on('click', '.icon_bookmark', function(){
		var id = $(this).attr('data-id');
		var button_id = $(this).attr('id');
		ajax_bookmark(id,button_id);
	});

	$('body').on('click', '.inactive .rating_all_sort_title', function(){
		var id = $(this).closest('.rating_all_sort').attr('id');
		$('#'+id).removeClass('inactive');
		$('#'+id).addClass('active');
	});
	$('body').on('click', '.active .rating_all_sort_title', function(){
		var id = $(this).closest('.rating_all_sort').attr('id');

		$('#'+id).removeClass('active');
		$('#'+id).addClass('inactive');
	});
	$('body').on('click', '.rating_all_sort ul li', function(){
		var id = $(this).closest('.rating_all_sort').attr('id');
		$('#'+id).removeClass('active');
		$('#'+id).addClass('inactive');
		$('#'+id+' ul li.active').removeClass('active');
		var type = $(this).attr('data-sort-type');
		var form = $(this).closest('.rating_all_sort').attr('data-autocomplete-form');
		var block_id = $(form).closest('.autocomplete_container').attr('id');
		$(this).addClass('active');
		//alert(form);
		$(form+ ' input[name="sort"]').val(type);
		resort_ratings_all(block_id);
	});
	$('body').on('click', '.icon_compare', function(){
		var id = $(this).attr('data-id');
		var button_id = $(this).attr('id');
		ajax_compare(id,button_id);
	});

	$('body').on('click', '.social_login_icons li', function(){
		var provider_id = $(this).attr('data-provider-id');
		//alert(provider_id);
		auth_popup(provider_id);
	});

	$('body').on('click', '.comment_rate .rate_action', function(){
		var action = $(this).attr('data-commentaction');
		var comment_id = $(this).attr('data-comment-id');
		comment_rate_action(action,comment_id);
	});

	$('.header').on('click', '.user_nav_settings li', function(){
		var link = $(this).attr('data-link');
		window.location.href = link;
	});

	$('.header').on('click', '.mobile_auth_icon.inactive', function(){
		$(this).removeClass('inactive');
		$(this).addClass('active');
		user_nav_mobile();
	});

	$('body').on('click', '.outside_tags li', function(){
		var block_id = $(this).closest('.autocomplete_container').attr('id');
		var search_type = $(this).closest('.autocomplete_container').attr('data-type');
		if(search_type === 'filter_ratings') {
			//alert('ll');
			var myDiv1Para = $(this).remove();
			myDiv1Para.appendTo('#'+block_id+' .autocomplete_search_results ul');
			resort_ratings_all(block_id);
		}
	});
	$('body').on('click', '.autocomplete_search_results ul li', function(){
		var company_id = $(this).attr('data-id');
		var company_name = $(this).text();
		var block_id = $(this).closest('.autocomplete_container').attr('id');
		var search_type = $(this).closest('.autocomplete_container').attr('data-type');


		if(search_type === 'filter_ratings') {
			//alert('ll');
			var myDiv1Para = $(this).remove();
			myDiv1Para.appendTo('#'+block_id+' .outside_tags ul');
			resort_ratings_all(block_id);
			$('#' + block_id + ' .autocomplete_search_results').empty();
			$('#'+block_id).removeClass('active_search');
			$('#'+block_id+' input[name="autocomplete_text"]').val('');
			$('#'+block_id+' input[name="autocomplete_result"]').val('');
		} else {
			$('#'+block_id+' input[name="autocomplete_text"]').val(company_name);
			$('#'+block_id+' input[name="autocomplete_result"]').val(company_id);
			$('#'+block_id+' .autocomplete_search_results').removeClass('active');
			$('#'+block_id+' .autocomplete_search_results').empty();
			var popup_container_id = $('#'+block_id).closest('.popup_container').attr('id');
			var form_type = $('#'+popup_container_id).attr('data-form-type');
			load_popup_outside_form(form_type,company_name,company_id,1,popup_container_id,'.outside_form_container');
		}
	});

	$('body').on('click', '.autocomplete_search_results .autocomplete_add_new', function(){
		var block_id = $(this).closest('.autocomplete_container').attr('id');
		var company_id = 0;
		var company_name = $('#'+block_id+' input[name="autocomplete_text"]').val();
		//$('#'+block_id+' input[name="autocomplete_text"]').val(company_name);
		$('#'+block_id+' input[name="autocomplete_result"]').val(company_id);
		$('#'+block_id+' .autocomplete_search_results').removeClass('active');
		$('#'+block_id+' .autocomplete_search_results').empty();
		var popup_container_id = $('#'+block_id).closest('.popup_container').attr('id');
		var form_type = $('#'+popup_container_id).attr('data-form-type');
		load_popup_outside_form(form_type,company_name,company_id,0,popup_container_id,'.outside_form_container');
	});

	$('body').on('click', '.user_mobile_close_button', function(){
		$('.header .mobile_auth_icon').removeClass('active');
		$('.header .mobile_auth_icon').addClass('inactive');
		$('.header .mobile_user_picture').removeClass('active');
		$('.header .mobile_user_picture').addClass('inactive');
		$('.header .user_mobile_content').empty();
		$('.header .user_nav_mobile').hide();
	});

	$('.header').on('click', '.mobile_user_picture.inactive', function(){
		$(this).removeClass('inactive');
		$(this).addClass('active');
		user_nav_mobile();
	});

	$('.header').on('click', '.user_mobile_content .auth_button', function(){
		auth_link();
	});

	$('.header').on('click', '.user_mobile_content .reg_button', function(){
		reg_link();
	});

	$('body').on('click', '.link_recover_popup', function(){
		link_reset_password();
	});

	$('.header').on('click', '.inactive_user_nav', function(){
		$('.header .user_name').removeClass('inactive_user_nav');
		$('.header .user_name').addClass('active_user_nav');
		user_nav();
		$('.header .icon_settings').removeClass('active_user_settings_nav');
		$('.header .icon_settings').addClass('inactive_user_settings_nav');
		$('.header .user_bar .user_nav_settings').remove();
		$('.header .header_icon_services').removeClass('active_header_icon_services');
		$('.header .header_icon_services').addClass('inactive_header_icon_services');
		$('.header_icon_services .services_list').remove();
	});
	$('.header').on('click', '.active_user_nav', function(){
		$('.header .user_name').removeClass('active_user_nav');
		$('.header .user_name').addClass('inactive_user_nav');
		$('.header .user_bar .user_nav').remove();
	});

	$('.header').on('click', '.inactive_user_settings_nav', function(){
		$('.header .icon_settings').removeClass('inactive_user_settings_nav');
		$('.header .icon_settings').addClass('active_user_settings_nav');
		user_nav_settings();
		$('.header .user_name').removeClass('active_user_nav');
		$('.header .user_name').addClass('inactive_user_nav');
		$('.header .user_bar .user_nav').remove();
		$('.header .header_icon_services').removeClass('active_header_icon_services');
		$('.header .header_icon_services').addClass('inactive_header_icon_services');
		$('.header_icon_services .services_list').remove();
	});
	$('.header').on('click', '.active_user_settings_nav', function(){
		$('.header .icon_settings').removeClass('active_user_settings_nav');
		$('.header .icon_settings').addClass('inactive_user_settings_nav');
		var hidden = $('.user_nav_settings');
		hidden.animate({"right":"-1000px"}, 500,function() {
			$('.user_nav_settings').remove();
		});
	});
	$('body').on('submit','form#header_search',function(e) {
		e.preventDefault();
	});
	var xhrCount_ls = 0;
	$('.live_search input[name="s"]').on('input',function() {
		var phrase = $(this).val();
		$('.live_search_results').remove();
		$('.main_container').append('<div class="live_search_results"></div>');
		if(phrase.length > 1){
			var seqNumber_ls = ++xhrCount_ls;
			var jqXHR;
			jqXHR = $.ajax({
				url: my_ajax_object.ajax_url,
				type: "POST",
				data: "action=live_search_ajax&s="+phrase,
				beforeSend: function(xhr) {
					if (seqNumber_ls !== xhrCount_ls) {

						jqXHR.abort();
					} else {
						$('.live_search_results').html("<progress id='bar' value='0' max='100'></progress").show();
						$('.live_search_results').append('<div class="load_ajax"></div>');
					}
				},
				complete: function(){

					$('.live_search_results #bar').val(100);
				},
				success: function( data ) {
					if (seqNumber_ls === xhrCount_ls) {
						//$('.live_search_results #bar').val(100);
						$('.live_search_results .load_ajax').remove();
						$('.live_search_results .search_results').remove();
						$('.live_search_results').append(data);

					}
				}
			});
		}
	});
	$('.inactive_live_search input[name="s"], .inactive_live_search .search_icon').click(function() {
		$('.live_search input[name="s"]').addClass('active_input');

		$('.live_search').addClass('active_live_search');
		$('.live_search').removeClass('inactive_live_search');
		$('.live_search input[name="s"]').focus();
		var close_icon = '<div class="close_icon pointer"></div>';
		$('.live_search').append(close_icon);
		$('.live_search .close_icon').click(function() {
			$('.live_search input[name="s"]').removeClass('active_input');
			$('.live_search').removeClass('active_live_search');
			$('.live_search').addClass('inactive_live_search');
			$('.live_search_results').remove();
			$('.live_search .close_icon').remove();
			$('.live_search input[name="s"]').val('');
		});
		//$('.live_search_results').remove();
		/*$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=popup_nav&nav_place=header_main",
			beforeSend: function(xhr) {

			},
			success: function( data ) {
				alert(data);
			}
		});*/
	});
	$('.nav_dropdown .nav_arrow').click(function() {
		var container_id = $(this).closest('.nav_dropdown').attr('id');
		//alert(container_id);
	});
	/*$(document).on("click", function(e) {
		if ($(e.target).is(".live_search .active_input, .search_results .wrap, .search_results_content, .search_results .wrap div, .live_search_results, .live_search .search_icon") === false) {
		  	$('.live_search input[name="s"]').removeClass('active_input');
		  	$('.live_search_results').remove();
			$('.live_search .close_icon').remove();
			$('.live_search input[name="s"]').val('');
			$('.live_search').removeClass('active_live_search');
			$('.live_search').addClass('inactive_live_search');
		}
		
	});*/
	$('body').on('click','.search_result_tabs li.inactive',function(){
		$('.search_result_tabs li.active').addClass('inactive');
		$('.search_result_tabs li').removeClass('active');
		var tab = $(this).attr('data-id');
		$(this).addClass('active');
		$(this).removeClass('inactive');
		$('.result_tab_content').removeClass('active');
		$('.result_tab_content.result_'+tab).addClass('active');
	});
	$('.header').on('click', '.inactive_header_icon_services', function(){
		$('.header .header_icon_services').removeClass('inactive_header_icon_services');
		$('.header .header_icon_services').addClass('active_header_icon_services');
		$('.header .icon_settings').removeClass('active_user_settings_nav');
		$('.header .icon_settings').addClass('inactive_user_settings_nav');
		$('.header .user_bar .user_nav_settings').remove();
		$('.header .user_name').removeClass('active_user_nav');
		$('.header .user_name').addClass('inactive_user_nav');
		$('.header .user_bar .user_nav').remove();
		append_services();
	});
	$('.header').on('click', '.active_header_icon_services', function(){
		$('.header .header_icon_services').removeClass('active_header_icon_services');
		$('.header .header_icon_services').addClass('inactive_header_icon_services');
		$('.header_icon_services .services_list').remove();
	});

	$('body').on('click', '.link_review_map.inactive', function(){
		var post_id = $(this).attr('data-post-id');
		ajax_show_company_map(post_id);
		$(this).removeClass('inactive');
		$(this).addClass('active');
	});

	$('body').on('click', '.link_review_map.active', function(){
		$(this).removeClass('active');
		$(this).addClass('inactive');
		$('#map_container').empty();
	});



	$('body').on('click', '.link_promocode_show_more_text', function(){
		var promocode_id = $(this).closest('li.white_block').attr('id');
		$('#'+promocode_id+' .promocode_text_container').css('display', 'flex');
		$(this).hide();
	});

	$('body').on('click', '.link_promocode_show_more_text_popup', function(){
		var promocode_id = $(this).closest('li.white_block').attr('id');
		popup_alert_message(promocode_id,'single_promocode');
		//$('#'+promocode_id+' .promocode_text_container').css('display', 'flex');
		//$(this).hide();
	});

	$('body').on('click', '.link_promocode_show_more.inactive', function(){
		var promocode_id = $(this).closest('li.white_block').attr('id');
		$('#'+promocode_id+' .promocode_full_description').show();
		$(this).removeClass('inactive');
		$(this).addClass('active');
	});

	$('body').on('click', '.link_promocode_show_more.active', function(){
		var promocode_id = $(this).closest('li.white_block').attr('id');
		$('#'+promocode_id+' .promocode_full_description').hide();
		$(this).removeClass('active');
		$(this).addClass('inactive');
	});


	$('body').on('click', '.link_promocode_text_copy', function(){
		var promocode_id = $(this).closest('li.white_block').attr('id');
		var text_id = $('#'+promocode_id+' .promocode_single_text').attr('id');
		copy_text(text_id);
		$(this).text('Скопировано');
	});

	$('body').on('click', '.link_promocode_text_copy_popup', function(){
var promocode_id = $(this).closest('.promocode_text_container').attr('id');
		var text_id = $('#'+promocode_id+' .promocode_single_text').attr('id');
		/*copy_text(text_id);*/

		var copyText = document.getElementById(text_id+"_input");
		copyText.select();
		copyText.setSelectionRange(0, 99999)
		document.execCommand("copy");

		$(this).text('Скопировано');
	});

	$('.header').on('click', '.inactive_header_sections', function(){
		$('#header_sections_nav').removeClass('inactive_header_sections');
		$('#header_sections_nav').addClass('active_header_sections');
		header_sections_more();
	});
	$('.header').on('click', '.active_header_sections', function(){

		$('#header_sections_nav').removeClass('active_header_sections');
		$('#header_sections_nav').addClass('inactive_header_sections');
		$('.header_section_sub_links').remove();
	});
	$('body').on('click', '.contents_list.inactive', function(e){
		e.preventDefault();
		$(this).removeClass('inactive');
		$(this).addClass('active');
	});
	$('body').on('click', '.contents_list.active .nav_arrow', function(){
		$(this).closest('.contents_list').removeClass('active');
		$(this).closest('.contents_list').addClass('inactive');
	});
	$('body').on('click', '.filter_field_select_tax.inactive', function(){
		var taxonomy = $(this).attr('data-taxonomy');
		var id = $(this).attr('id');
		ajax_load_list(taxonomy,id);
		$(this).addClass('active');
		$(this).removeClass('inactive');
	});
	$('body').on('click', '.filter_field_select_tax.active', function(){
		var taxonomy = $(this).attr('data-taxonomy');
		var id = $(this).attr('id');
		$(this).addClass('inactive');
		$(this).removeClass('active');
		$('#'+id+' .taxonomy_field_terms').remove();
	});

	$('body').on('click', '.reg_type_links li.inactive', function(){

		var form_id = $(this).closest('form').attr('id');
		//alert(form_id);
		$('#'+form_id+' .reg_type_links li.active').addClass('inactive');
		$('#'+form_id+' .reg_type_links li.active').removeClass('active');
		$(this).addClass('active');
		$(this).removeClass('inactive');
		var reg_type = $(this).attr('data-type');
		$('#'+form_id+' input[name="reg_type"]').val(reg_type);
	});

	$('body').on('click', '.fast_links.inactive .fast_links_opener', function(){
		var block_id = $(this).closest('.fast_links').attr('id');
		$('#'+block_id).removeClass('inactive');
		$('#'+block_id).addClass('active');
		$('#'+block_id+' .fast_links_content').slideDown('slow');
	});
	$('body').on('click', '.fast_links.active .fast_links_opener', function(){
		var block_id = $(this).closest('.fast_links').attr('id');
		$('#'+block_id).removeClass('active');
		$('#'+block_id).addClass('inactive');
		$('#'+block_id+' .fast_links_content').slideUp('slow');
	});

	$('body').on('click', '.taxonomy_field_terms li', function(){
		var term_id = $(this).attr('data-term-id');
		var field_id = $(this).closest('.filter_field_select_tax').attr('id');
		var title = $(this).text();
		//alert(field_id);
		$('#'+field_id+' input').val(term_id);
		$('#'+field_id+' .field_title').text(title);
	});
	$('body').on('click', '.link_open_reviews', function(e) {
		e.preventDefault();
		$( ".review_links .review_link_reviews" ).trigger( "click" );
	});

	var string = window.location.hash;
	var substring = 'comment';
	/*if(string.indexOf(substring) !== -1) {
		$('.review_links li').removeClass('active');
		$('.review_links li').removeClass('color_dark_blue');
		$('.page_container').removeClass('visible');
		var container_class = 'review_container_reviews';
		$('.'+container_class).addClass('visible');
		$('.review_links li.review_link_reviews').addClass('active');
		$('.review_links li.review_link_reviews').addClass('color_dark_blue');
		ajax_comments('new');
	}*/

	$('body').on('click','.link_go_to_profile', function(e) {
		window.location.href = '/dashboard/';
	});
	$('body').on('focus','input[name="autocomplete_text"]', function() {
		$(this).closest('.autocomplete_container').addClass('active_search');
		var phrase = $(this).val();
		var block_id = $(this).closest('.autocomplete_container').attr('id');
		var search_type = $(this).closest('.autocomplete_container').attr('data-type');
		var container_id = $('#'+block_id).closest('.popup_container').attr('id');

		if (block_id == 'ratings_all_filter_autocomplete_skills') {
			$('.edit_skills_popup').addClass('edit_skills_popup_height');
		}
		//alert(search_type);


		if(search_type === 'filter_ratings') {
			var tags_values = $('#'+block_id+' .outside_tags input[name="tags[]"]').map(function(){return $(this).val();}).get();
			//alert(tags_values);
			autocomplete_search_results(phrase,block_id,search_type,tags_values);
		}
	});
	$('body').on('click','.autocomplete_container .autocomplete_icon_close', function() {
		$(this).closest('.autocomplete_container').removeClass('active_search');
		var popup_id = $(this).closest('.autocomplete_container').attr('id');
		$('#'+popup_id+' input[name="autocomplete_text"]').val('');
		$('#'+popup_id+' input[name="autocomplete_result"]').val('');
		$('#'+popup_id+' .autocomplete_search_results').empty();
		$('#'+popup_id+' .autocomplete_search_results').removeClass('active');
		var popup_container_id = $(this).closest('.popup_container').attr('id');
		$('#'+popup_container_id+' .outside_form_container').empty();
		$('.edit_skills_popup').removeClass('edit_skills_popup_height');
	});
	$('body').on('click','a[href*=".jpg"],a[href*=".png"],a[href*=".jpeg"],a[href*=".gif"]', function(e) {
		e.preventDefault();
		var img_url = $(this).attr('href');
		//alert(img_url);
		popup_alert_message(img_url,'image');
	});
	$('body').on('submit', '#check_cuez', function(e) {
		e.preventDefault();

		var form = $(this);
		$.post(form.attr('action'), form.serialize(), function(data) {
			//alert(data);
			result = JSON.parse(data);
			if(result.status === 'ok') {
				window.location.href = result.redirect;
			}
			//alert(data);
		});
	});
	$('body').on('submit', '#popup_reg_form', function(e) {
		e.preventDefault();
		$('.reg_error').remove();
		var form = $(this);
		$.post(form.attr('action'), form.serialize(), function(data) {
			result = JSON.parse(data);
			if(result.status === 'ok') {
				$('#popup_reg').remove();
				auth_action();
				//popup_alert_message(result.message,result.status);
				popup_user_form('edit_skills_popup',0,'','reg');
			} else {
				$( '<div class="font_smaller m_b_20 color_red reg_error">'+result.message+'</div>' ).insertBefore( $( '#popup_reg_form input[name="email"]' ) );
				setTimeout(function() {
					$('.reg_error').remove();
				}, 5000);
			}
		});
	});
	$('body').on('submit', '#footer_subscribe', function(e) {
		e.preventDefault();
		var form = $(this);
		$.post(form.attr('action'), form.serialize(), function(data) {
			result = JSON.parse(data);
			if(result.status === 'ok') {
				popup_alert_message(result.message,result.status);
				$('#footer_subscribe input[name="email"]').val('');
			} else {
				popup_alert_message(result.message,result.status);
			}
		});
	});

	$('body').on('submit', '#popup_reset_password_new', function(e) {
		e.preventDefault();
		$('.reg_error').remove();
		var form = $(this);
		$.post(form.attr('action'), form.serialize(), function(data) {
			result = JSON.parse(data);
			if(result.status === 'ok') {
				$( '<div class="font_smaller m_b_20 color_green reg_error">'+result.message+'</div>' ).insertBefore( $( '#popup_reset_password_new input[name="email"]' ) );
				setTimeout(function() {
					$('#popup_auth').remove();
				}, 5000);
			} else {
				$( '<div class="font_smaller m_b_20 color_red reg_error">'+result.message+'</div>' ).insertBefore( $( '#popup_reset_password_new input[name="email"]' ) );
				setTimeout(function() {
					$('.reg_error').remove();
				}, 5000);
			}
		});
	});
	$('body').on('submit', '#popup_outside_form_form', function(e) {
		e.preventDefault();
		var form = $(this);
		//alert(form);
		$.post(
			form.attr('action'),
			form.serialize(),
			function(data) {
				//alert(data);
				result = JSON.parse(data);
				if(result.status === 'error') {
					popup_alert_message(result.message,'error');
				} else if (result.status === 'ok') {
					outside_append_new_comment(result.comment_id,result.type);
				}
			}
		);
	});

	$('body').on('click','form#search_results_form input',function() {

		var form_id = $(this).closest('form').attr('id');
		$('#'+form_id).addClass('active');

	});
	$('body').on('click','form#search_results_form_promocodes input',function() {

		var form_id = $(this).closest('form').attr('id');
		$('#'+form_id).addClass('active');

	});



	$('body').on('click','form#search_results_form .big_search_icon_clear',function() {
		var form_id = $(this).closest('form').attr('id');
		$('#'+form_id).removeClass('active');
		$('#'+form_id+' input').val('');

	});

	$('body').on('click','form#search_results_form_promocodes .big_search_icon_clear',function() {
		var form_id = $(this).closest('form').attr('id');
		$('#'+form_id).removeClass('active');
		$('#'+form_id+' input').val('');

	});

	$('body').on('focus','form#search_results_form input',function() {

		var form_id = $(this).closest('form').attr('id');
		$('#'+form_id).addClass('active');

	});

	$('body').on('focus','form#search_results_form_promocodes input',function() {

		var form_id = $(this).closest('form').attr('id');
		$('#'+form_id).addClass('active');

	});

	$('body').on('click','form#search_results_form .big_search_icon',function() {

		var form_id = $(this).closest('form').attr('id');
		var phrase = $('#'+form_id+' input').val();
		var tag = $('.search_results_filter_header .current_tag li').attr('data-slug');
		if(typeof tag === 'undefined') {
			if(phrase.length > 1){
				window.location.href = my_ajax_object_new.er_blog_url+'/search/?q='+phrase;
			}
		} else {
			if(phrase.length > 1){
				window.location.href = my_ajax_object_new.er_blog_url+'/search/'+tag+'/?q='+phrase;
			} else {
				window.location.href = my_ajax_object_new.er_blog_url+'/search/'+tag+'/';
			}
		}

	});

	$('body').on('click','form#search_results_form_promocodes .big_search_icon',function() {

		var form_id = $(this).closest('form').attr('id');
		var phrase = $('#'+form_id+' input').val();
		var tag = $('#'+form_id).attr('data-slug');
		if(typeof tag === 'undefined') {
			if(phrase.length > 1){
				window.location.href = my_ajax_object_new.er_blog_url+'/promocode/?q='+phrase;
			}
		} else {
			if(phrase.length > 1){
				window.location.href = my_ajax_object_new.er_blog_url+'/promocode/'+tag+'/?q='+phrase;
			} else {
				window.location.href = my_ajax_object_new.er_blog_url+'/promocode/'+tag+'/';
			}
		}

	});

	$('body').on('submit','form#search_results_form',function(e) {
		e.preventDefault();
		var form_id = $(this).attr('id');
		var phrase = $('#'+form_id+' input').val();
		var tag = $('.search_results_filter_header .current_tag li').attr('data-slug');
		//alert(tag);
		if(typeof tag === 'undefined') {
			if(phrase.length > 1){
				window.location.href = my_ajax_object_new.er_blog_url+'/search/?q='+phrase;
			}
		} else {
			if(phrase.length > 1){
				window.location.href = my_ajax_object_new.er_blog_url+'/search/'+tag+'/?q='+phrase;
			} else {
				window.location.href = my_ajax_object_new.er_blog_url+'/search/'+tag+'/';
			}
		}

	});

	$('body').on('submit','form#search_results_form_promocodes',function(e) {
		e.preventDefault();
		var form_id = $(this).attr('id');
		var phrase = $('#'+form_id+' input').val();
		var tag = $(this).attr('data-slug');
		//alert(tag);
		if(typeof tag === 'undefined') {
			if(phrase.length > 1){
				window.location.href = my_ajax_object_new.er_blog_url+'/promocode/?q='+phrase;
			}
		} else {
			if(phrase.length > 1){
				window.location.href = my_ajax_object_new.er_blog_url+'/promocode/'+tag+'/?q='+phrase;
			} else {
				window.location.href = my_ajax_object_new.er_blog_url+'/promocode/'+tag+'/';
			}
		}

	});

	$('body').on('click','.link_show_more_results_filter_tags',function() {
		$(this).remove();
		$('.search_results_filter_tags_more').addClass('active');

	});

	$('body').on('click','.search_results_top_sorter.inactive .rating_all_sort_title',function() {
		var id = $(this).closest('.search_results_top_sorter').attr('id');
		$('#'+id).addClass('active');
		$('#'+id).removeClass('inactive');
	});

	$('body').on('click','.search_results_top_sorter.active .rating_all_sort_title',function() {
		var id = $(this).closest('.search_results_top_sorter').attr('id');
		$('#'+id).removeClass('active');
		$('#'+id).addClass('inactive');
	});

	$('body').on('click', '.search_results_filter_tags li', function(){
		var tag = $(this).attr('data-slug');
		//$('.search_results_filter_header .current_tag').empty();
		//var myDiv1Para = $(this).remove();
		//myDiv1Para.appendTo('.search_results_filter_header .current_tag');
		var phrase = $('#search_results_form input').val();

		if(phrase.length > 1){
			window.location.href = my_ajax_object_new.er_blog_url+'/search/'+tag+'/?q='+phrase;
		} else {
			window.location.href = my_ajax_object_new.er_blog_url+'/search/'+tag+'/';
		}

	});

	$('body').on('click', '.search_results_filter_header .current_tag li', function(){
		var tag = $(this).attr('data-slug');
		//$('.search_results_filter_header .current_tag').empty();
		//var myDiv1Para = $(this).remove();
		//myDiv1Para.appendTo('.search_results_filter_header .current_tag');
		var phrase = $('#search_results_form input').val();

		if(phrase.length > 1){
			window.location.href = my_ajax_object_new.er_blog_url+'/search/?q='+phrase;
		} else {
			window.location.href = my_ajax_object_new.er_blog_url+'/search/';
			//var myDiv1Para = $(this).remove();
		}

	});
	$('body').on('click', '.no_bullets#toc_container .toc_title', function(){
		$('#toc_container').removeClass('no_bullets');
		$('#toc_container').addClass('active');

	});
	$('body').on('click', '.active#toc_container .toc_title', function(){
		$('#toc_container').removeClass('active');
		$('#toc_container').addClass('no_bullets');

	});
	/*$('body').on('click', '.no_bullets#toc_container a', function(e){
		e.preventDefault();
	});*/
	$('body').on('click', '.search_results_top_sorter ul li', function(){
		var id = $(this).closest('.search_results_top_sorter').attr('id');
		$('#'+id).removeClass('active');
		$('#'+id).addClass('inactive');
		$('#'+id+' ul li.active').removeClass('active');
		var type = $(this).attr('data-sort-type');
		var key = $('#search_results_form input').val();
		var tag = $('.search_results_filter_header .current_tag li').attr('data-term-id');
		//var form = $(this).closest('.rating_all_sort').attr('data-autocomplete-form');
		//var block_id = $(form).closest('.autocomplete_container').attr('id');
		$(this).addClass('active');
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=resort_show_search_category_results&sort="+type+"&key="+key+"&term_id="+tag,
			beforeSend: function(xhr) {
				$('.main_result').empty();
				$('.main_result').append('<div class="load_ajax"></div>');
			},
			complete: function(){
				$('.main_result .load_ajax').remove();
			},
			success: function( data ) {
				$('.main_result').append(data);
			}
		});
		//alert(form);
		//$(form+ ' input[name="sort"]').val(type);
		//resort_ratings_all(block_id);
	});

	$('body').on('click', '.active_editing_profile .skills-comments__myskill', function(){
		obj = $(this);
		skillid = obj.attr('data-skill');
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=user_skills_remove&id="+skillid,
			beforeSend: function(xhr) {
			},
			complete: function(){
			},
			success: function( data ) {
				obj.remove();

			}
		});
	});


	$('body').on('click','.add_skills_popup',function(){
		select_skills = parseInt($( "#select_skills option:selected" ).attr('value'));
		text = '';
		$('#filter_form_ratings_all_filter_autocomplete_skills ul li').each(function (){
			text = text + $(this).attr('data-id')+',';

		})
		//console.log(select_skills);
		if (select_skills != 0){
			user_skills_add_mass(text);
		}

	})

	$('body').on('click','.skip_skills',function(){
		$('.popup_close_button').click();

	})


});

