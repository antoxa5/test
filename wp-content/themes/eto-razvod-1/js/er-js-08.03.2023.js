$ = jQuery.noConflict();

//alert(my_ajax_object_new.er_blog_url);
function clickAuthAction(link) {
	if (link == 'send_blog_post') {
		linked = '/dashboard/services/blog/';
	}
	if (link == 'gotodashboard') {
		linked = '/dashboard-add-company/';
	}
	if (link == 'gotodashboard_notifications') {
		linked = '/dashboard/notifications/';
	}
	if (link == 'gotodashboard_messages') {
		linked = '/dashboard/messages/';
	}
	if (link == 'gotodashboard_blog') {
		linked = '/dashboard/services/blog/';
	}

	if (link == 'gotodashboard_pro') {
		linked = '/dashboard/services/pro/';
	}
//gotodashboard
	if (document.body.classList.contains( 'logged_in' ) == true) {
		window.location.href = linked;
	} else {
		auth_link();
	}
}

function set_cookie_skills() {
	var timeToAdd = 1000 * 60 * 60 * 24;
	var date = new Date();
	var expiryTime = parseInt(date.getTime()) + timeToAdd;
	date.setTime(expiryTime);
	var utcTime = date.toUTCString();
	document.cookie = "skillsform=1; expires=" + utcTime + ";";
}

function get_ajax_all_comments() {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=get_ajax_all_comments",
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			$('.rating_table_all').append(data);
		}
	});
}

function compare_icon() {
	/*$( ".compare_container" ).empty();
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
	});*/
}


function append_notify_icons() {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=notify_user_icons",
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			$('.header .notify_user_icons_container').empty();
			$('.header .notify_user_icons_container').append(data);
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
	$('.rate-comment-'+comment_id+'').addClass('loading');
	//alert(action + ' ' + comment_id);
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=comment_rate_action&rate_action="+action+"&comment_id="+comment_id,
		beforeSend: function(xhr) {
			console.log(comment_id);
			$('.rate-comment-'+comment_id+'').append('<div class="load_ajax"></div>');

		},
		complete: function(){
		},
		success: function( data ) {
			$('.rate-comment-'+comment_id+'').removeClass('loading');
			$('.rate-comment-'+comment_id+'').find('.load_ajax').remove();
			console.log('test');
			result = JSON.parse(data);
			console.log(result.settings);
			console.log(result.status);
			console.log(result);
			if(result.status === 'error') {
				popup_alert_message(result.message,'error');
				$('.rate-comment-'+comment_id+' .rate_plus_wrapper .number_plus').text(result.positive_array);
				$('.rate-comment-'+comment_id+' .rate_minus_wrapper .number_minus').text(result.minus_array);
				$('.rate-comment-'+comment_id+' .rate_number').empty();
				$('.rate-comment-'+comment_id+' .rate_number').append(result.new_value);
				$('.rate-comment-'+comment_id+' .rate_number').removeClass('negative positive neutral');
				$('.rate-comment-'+comment_id+' .rate_number').addClass(result.new_value_type);
			} else {
				if (action == 'plus') {
					thisnumber_rate = 1;
				} else if (action == 'minus') {
					thisnumber_rate = -1;
				}
				console.log('result.positive_array'+result.positive_array);
				console.log('result.minus_array'+result.minus_array);

				$('.rate-comment-'+comment_id+' .rate_plus_wrapper .number_plus').text(result.positive_array);
				$('.rate-comment-'+comment_id+' .rate_minus_wrapper .number_minus').text(result.minus_array);

				$('.rate-comment-'+comment_id+' .rate_number').empty();
				$('.rate-comment-'+comment_id+' .rate_number').append(result.new_value);
				$('.rate-comment-'+comment_id+' .rate_number').removeClass('negative positive neutral');
				$('.rate-comment-'+comment_id+' .rate_number').addClass(result.new_value_type);
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
function check_login_for_services() {
	if (document.body.classList.contains( 'logged_in' ) == true) {
		$('.header_icon_services').addClass('hide_div');
	} else {
		$('.header_icon_services').removeClass('hide_div');
	}
	/*$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=check_login_for_services",
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			//console.log(data);
			if(data == 'yes') {
				$('.header_icon_services').addClass('hide_div');
			} else {
				$('.header_icon_services').removeClass('hide_div');
			}
		}
	});*/
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

function update_info() {

	checkedurl = $('input[name="checkedurl"]').val();
	$.ajax({
		url: 'https://eto-razvod.ru/wp-admin/admin-ajax.php',
		type: "POST",
		data: "action=checkinfobyurl&checkedurl="+checkedurl,
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			alert(data);
		}
	});
}
//Выключено
function header_sections() {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=append_main_nav&actual_link="+my_ajax_object.actual_link,
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			console.log('header_sections');
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
			console.log('header_sections_more');
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

function notify_single_popup(id) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=notify_single_popup&id="+id,
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			//alert(data);
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

function notify_main_popup() {

	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=notify_main_popup",
		beforeSend: function(xhr) {

		},
		success: function( data ) {
			//alert(data);
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

function notify_show_recent_popup(type,container) {

	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=notify_show_recent_popup&type="+type,
		beforeSend: function(xhr) {
		},
		complete: function(){

		},
		success: function( data ) {
			//alert(data);
			$('.notify_user_icons .'+container).append(data);
		}
	});
}

function auth_action() {

	user_bar();
	single_review_icons();
	compare_icon();
	append_notify_icons();
	check_login_for_services();
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

	if (typeof click_sidebar !== 'undefined') {
		if (click_sidebar == 99999999999) {
			window.location.href = '/dashboard-add-company/';//https://eto-razvod.ru/dashboard/services/blog/
		} else {
			window.location.href = '/dashboard-add-company/?company_sidebar='+click_sidebar;
		}

	}

	if (typeof linked !== 'undefined') {
		window.location.href = linked;
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

function another_comm_1() {
	if ($('.another_comm_1').length != 0) {
		current_language = $('.another_comm_1').attr('data-current_language');
		comment_post_id = $('.another_comm_1').attr('data-comment_post_id');
		comment__not_in = $('.another_comm_1').attr('data-comment__not_in');
		tex_more_rev_about = $('.another_comm_1').attr('data-tex_more_rev_about');
		company_name = $('.another_comm_1').attr('data-company_name');

		//console.log(tex_more_rev_about+' '+company_name);

		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=another_comm_1&current_language="+current_language+"&comment_post_id="+comment_post_id+"&comment__not_in="+comment__not_in+"&tex_more_rev_about="+tex_more_rev_about+"&company_name="+company_name,
			beforeSend: function(xhr) {
				$('.another_comm_1').append('<div class="load_ajax"></div>');
			},
			success: function( data ) {
				$('.another_comm_1').empty();
				$('.another_comm_1').append(data);
			}
		});
	}

}


function another_comm_2() {
	if ($('.another_comm_2').length != 0) {
		current_language = $('.another_comm_2').attr('data-current_language');
		comment_post_id = $('.another_comm_2').attr('data-comment_post_id');
		comment__not_in = $('.another_comm_2').attr('data-comment__not_in');
		tex_more_rev_about = $('.another_comm_2').attr('data-tex_more_rev_about');
		company_name = $('.another_comm_2').attr('data-company_name');
		text_rev_ab_comp = $('.another_comm_2').attr('data-text_rev_ab_comp');
		text_rev_ab_sim_companies = $('.another_comm_2').attr('data-text_rev_ab_sim_companies');

		//console.log(tex_more_rev_about+' '+company_name);

		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=another_comm_2&current_language="+current_language+"&comment_post_id="+comment_post_id+"&comment__not_in="+comment__not_in+"&tex_more_rev_about="+tex_more_rev_about+"&company_name="+company_name+"&text_rev_ab_comp="+text_rev_ab_comp+"&text_rev_ab_sim_companies="+text_rev_ab_sim_companies,
			beforeSend: function(xhr) {
				$('.another_comm_2').append('<div class="load_ajax"></div>');
			},
			success: function( data ) {
				$('.another_comm_2').empty();
				$('.another_comm_2').append(data);
			}
		});
	}

}

function after_popup_login(type,action,user_id) {

	if(action === 'auth_new') {
		//alert(type+ ' ' + action + ' ' + user_id);
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=get_user_notify&userid="+user_id,
			success: function( data ) {

			}
		});
		popup_user_form('edit_skills_popup',0,'','reg');

		//тутт запускаешь аякс с передачей юзер айди, внутри того аякса проверяешь емейл, нормальный он или нет
	}
	var pathname = window.location.pathname;

	if(pathname.indexOf("/add-review/") >= 0) {
		//alert(pathname);
		var comment_id = $('#after_login_new_comment_form input[name="comment_id"]').val();
		var post_id = $('#after_login_new_comment_form input[name="post_id"]').val();
		//alert(comment_id);
		attach_new_review_to_new_user(comment_id,post_id);
	}

}

function attach_new_review_to_new_user_after_reg(comment_id,post_id,user_id,password) {
	$('.review_form_separate .wrap').empty();
	//alert(password);
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=attach_new_review_to_new_user_after_reg&comment_id="+comment_id+"&post_id="+post_id+"&user_id="+user_id+"&password="+password,
		beforeSend: function(xhr) {
			$('.review_form_separate .wrap').append('<div class="load_ajax"></div>');
		},
		complete: function(){
			$('.review_form_separate .wrap .load_ajax').remove();
		},
		success: function( data ) {
			result = JSON.parse(data);
			$('.spam_link_result').remove();
			if(result.status === 'ok') {
				auth_action();
				$('.review_form_separate .wrap').append(result.message);
				$('#myBtn').trigger('click');

			} else if (result.status === 'error') {
				$('.review_form_separate .wrap').append(result.message);
				$('#myBtn').trigger('click');
			}

		}
	});
}

function remove_promo(id,num,company_id,company_slug) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=remove_promo&id="+id+"&num="+num+"&company_id="+company_id+"&company_slug="+company_slug,
		beforeSend: function(xhr) {
			//$('.review_form_separate .wrap').append('<div class="load_ajax"></div>');
		},
		complete: function(){
			//$('.review_form_separate .wrap .load_ajax').remove();
		},
		success: function( data ) {
			result = data;
			popup_alert_message('Промокод успешно удалён! Он','ok');


		}
	});
}

function attach_new_review_to_new_user(comment_id,post_id) {
	$('.review_form_separate .wrap').empty();
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=attach_new_review_to_new_user&comment_id="+comment_id+"&post_id="+post_id,
		beforeSend: function(xhr) {
			$('.review_form_separate .wrap').append('<div class="load_ajax"></div>');
		},
		complete: function(){
			$('.review_form_separate .wrap .load_ajax').remove();
		},
		success: function( data ) {
			result = JSON.parse(data);
			$('.spam_link_result').remove();
			if(result.status === 'ok') {
				$('.review_form_separate .wrap').append(result.message);
				$('#myBtn').trigger('click');
			} else if (result.status === 'error') {
				$('.review_form_separate .wrap').append(result.message);
				$('#myBtn').trigger('click');
			}

		}
	});
};

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

function notify_change_status(id,status) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=notify_change_status&id="+id+"&status="+status,
		success: function( data ) {
			append_notify_icons();
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


function popup_company_form(type,userid,service = '',typespend = '', company_id = '',company_slug = '') {

	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=company_form&type="+type+"&userid="+userid+"&service="+service+"&typespend="+typespend+"&company_id="+company_id+"&company_slug="+company_slug,
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
			if (type == 'copy_widget') {
				$('#popup_copy_widget textarea').val('<a href="https://eto-razvod.ru/"><img src="https://eto-razvod.ru/widget/rate_img_mini.png?id='+$('#popup_search_companies input[name="autocomplete_result"]').val()+'" alt=""></a>');
			}
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
			$('#popup_modals').empty();
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

			/*if (typeof click_sidebar !== 'undefined') {
				alert(1);
			}*/
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
				//auth_link(result.message);
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
		data: "action=popup_reg&test="+getUrlParameter('a'),
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
function append_circle_bar(id,percent) {
	//console.log('test3333'+percent);
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
	console.log('test4444');
	var progressBar =
		new ProgressBar.Circle('.review_average_round#'+id, {
			color: color,
			strokeWidth: 5,
			duration: 500, // milliseconds
			easing: 'easeInOut'
		});

	progressBar.animate(percent); // percent
};


function append_circle_bar_comments_show_comments(id,percent,color) {
	console.log('test4444');
	var progressBar =
		new ProgressBar.Circle('.show-comments .review_average_round#'+id, {
			color: '#001640',
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

function load_more_news(offset,tag,total) {
	$('.load_more_news').remove();
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=load_more_news&tag="+tag+"&offset="+offset+"&total="+total,
		beforeSend: function(xhr) {
			$('.news_middle').append('<div class="load_ajax"></div>');
		},
		complete: function(){
			$('.news_middle .load_ajax').remove();
		},
		success: function( data ) {

			$('.news_middle').append(data);
		}
	});
};

function get_single_newform_by_name(post_id,new_name) {
	$('.review_form_separate .outside_form_container').empty();
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=get_single_newform_by_name&post_id="+post_id+"&new_name="+new_name,
		beforeSend: function(xhr) {
			$('.review_form_separate h1').remove();
			$('.review_form_separate #popup_search_companies').remove();
			$('.review_form_separate .outside_form_container').append('<div class="load_ajax"></div>');
		},
		complete: function(){
			$('.review_form_separate .outside_form_container .load_ajax').remove();
		},
		success: function( data ) {

			$('.review_form_separate .outside_form_container').append(data);
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
	//console.log(block_id);
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

function check_policy() {
	if (document.cookie.indexOf("er_cookie_accepted_once") == -1) {
		console.log('check_policy()');
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=check_cookie_accept_popup_multilanguge&cookie_id=er_cookie_accepted_once",
			success: function( data ) {

				var cookies_exist = data;
				if (cookies_exist == "000") {
					/*if ($('.lang_en_US').length == 1) {
						$( ".cookie_container" ).append( '<div class="cookies_popup"><div class="cookie_wrap_popup" style="padding-bottom: calc( env(safe-area-inset-bottom) - 20px);"><span class="mobile_cookie_text">Read <a href="/privacy-policy/" target="_blank">the Privacy Policy</a>.</span><span class="pc_cookie_text">If you continue using this site, you are <br>agreeing to <a href="/privacy-policy/" target="_blank">the Privacy Policy</a>.</span> <span class="closer_coockie_accept"></span><a class="cookie_accept" style="display:none">Принимаю</a></div></div>' );
					} else if ($('.lang_es_ES').length == 1) {
						$( ".cookie_container" ).append( '<div class="cookies_popup"><div class="cookie_wrap_popup" style="padding-bottom: calc( env(safe-area-inset-bottom) - 20px);"><span class="mobile_cookie_text">Lea la <a href="/privacy-policy/" target="_blank">política de privacidad</a>.</span><span class="pc_cookie_text">Al continuar utilizando este sitio web, <br>usted acepta a <br>agreeing to <a href="/privacy-policy/" target="_blank">la política de privacidad</a>.</span> <span class="closer_coockie_accept"></span><a class="cookie_accept" style="display:none">Принимаю</a></div></div>' );
					} else {
						$( ".cookie_container" ).append( '<div class="cookies_popup"><div class="cookie_wrap_popup" style="padding-bottom: calc( env(safe-area-inset-bottom) - 20px);"><span class="mobile_cookie_text">Ознакомьтесь с <a href="/privacy-policy/" target="_blank">Политикой конфиденциальности</a>.</span><span class="pc_cookie_text">Продолжив работу с сайтом, вы соглашаетесь <br>с <a href="/privacy-policy/" target="_blank">Политикой конфиденциальности</a>.</span> <span class="closer_coockie_accept"></span><a class="cookie_accept" style="display:none">Принимаю</a></div></div>' );
					}*/
					$( ".cookie_container" ).append(my_ajax_object.cookie_text);
					$(".closer_coockie_accept").click(function(){
						$( ".cookie_container" ).empty();
						$.ajax({
							url:  my_ajax_object.ajax_url,
							type: "POST",
							data: "action=set_cookie_accept_popup_multilanguage&cookie_id=er_cookie_accepted_once&cookie_time=31556926",
							success: function( data ) {
							}
						});
					});
				}
			}
		});
	}
}

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

function savesendingmails(site, all, tematics) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=savesendingmails&site="+site+"&all="+all+"&tematics="+tematics,
		beforeSend: function(xhr) {
			$('.savenotify').append('<div class="load_ajax"></div>')
			$('.savenotify').addClass('active');
		},
		complete: function(){
		},
		success: function( data ) {
			$('.savenotify').removeClass('active');
			$('.savenotify .load_ajax').remove();
			console.log(data);
			popup_alert_message('Настройки уведомлений и рассылок успешно сохранены!','ok');

		}
	});

}

function ajax_link_outside_add_company(type) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=ajax_link_outside_add_company&type="+type,
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
	//console.log(file_data);
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

function ajax_upload_file_2(file_data,append_id) {
	//console.log(file_data);
	form_data = new FormData();
	form_data.append('file', file_data);
	form_data.append('action', 'ajax_upload_file_doc');
	fd = form_data;
	var res = Array.from(fd.entries(), ([key, prop]) => ({
		[key]: {
			"ContentLength": typeof prop === "string" ?
				prop.length :
				prop.size
		}
	}));
	if (res[0].file.ContentLength > 2097152) {
		popup_alert_message('Размер загружаемого файла превышает 2МБ','error');
	} else if ($('div#img_uploaded > li').length == 10) {
		popup_alert_message('Колличество загруженных файлов не может превышать 10 штук','error');
	} else {
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
				console.log(result.status);
				if(result.status === 'ok') {
					console.log(result);
					$("div#get_status").hide();
					$("#imgstatus").attr("idstatus","1");
					$("#imgstatus .notice-title").text($("#imgstatus .notice-title").attr("attr-normal"));
					$("#imgstatus .notice-title + span").text($("#imgstatus .notice-title + span").attr("attr-normal"));
					$("#imgstatus .notice-title").css("color","#4CA109");

					$('#'+append_id+'').append('<li class="form_add_item" data-attr="'+result.thumb_url+'" data-full="'+result.file_url+'" style="background-image:url(\''+result.thumb_url+'\');"><input type="hidden" name="files_doc[]" value="'+result.file_id+'" /><span class="close"></span></li>');
					//$('<li class="form_add_item" style="background-image:url(\''+result.thumb_url+'\');"><input type="hidden" name="files[]" value="'+result.file_id+'" /><span class="close"></span></li>').append('#'+append_id+'');
				}
			}
		});

	}
}


function share_update_count(post_id,social_id,container_id) {
	$.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=share_update_count&post_id="+post_id+"&social_id="+social_id,
		beforeSend: function(xhr) {

		},
		complete: function(){
			//$(".spinner").hide();
		},
		success: function( data ) {
			//alert(data);
			$('#'+container_id+' li.social_item_icon_'+social_id+' .social_item_count').empty();
			$('#'+container_id+' li.social_item_icon_'+social_id+' .social_item_count').append(data);
			$('#'+container_id+' li.social_item_icon_'+social_id+' .social_item_count').show();
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
function autocomplete_search_results(phrase,block_id,type, tags_values, addcompany = 0) {
	//alert(block_id);
	//alert(tags_values);
	var seqNumber = ++xhrCount_ac;
	var jqXHR;
	jqXHR = $.ajax({
		url: my_ajax_object.ajax_url,
		type: "POST",
		data: "action=autocomplete_search_results&phrase=" + phrase+"&type="+type+"&tags="+tags_values+"&addcompany="+addcompany,
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

function declOfNum(number, titles) {
	cases = [2, 0, 1, 1, 1, 2];
	return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
}




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


function resort_news_tags(block_id) {
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
				$('.news_middle').empty();
				$('.news_middle').append('<div class="load_ajax"></div>');
			}
		},
		complete: function () {

		},
		success: function(data)
		{
			if (seqNumber_fr === xhrCount_fr) {
				//alert(data);
				$('.news_middle .load_ajax').remove();
				$('.news_middle').empty();
				$('.news_middle').append(data); // show response from the php script.
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
			console.log('4 a'+skillid);
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
			$('.add_skills_popup').append('<div class="load_ajax"></div>')
			$('.add_skills_popup').addClass('active');
		},
		complete: function(){
		},
		success: function( data ) {
			$('.add_skills_popup').removeClass('active');
			$('.add_skills_popup .load_ajax').remove();
			//obj.remove();
			console.log('3 a'+skillid);
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

	if ($('#list_more_container_main').length != 0) {
		t = $('#list_more_container_main').html();
		$('.list_more_container').empty();
		$('.list_more_container').html(t);
	}

	$('body').on('click','.apptagings .apptaging',function(){
		if ($(this).hasClass('active')) {

			$('.apptaging').removeClass('active');
			$(this).removeClass('active');
			text = $(this).text();
			$('.apptagings').parent().parent().parent().removeClass('setmain');
			$('.apptagings').parent().parent().parent().attr('style','');
			//alert(text);
			$('.apptagings').each(function(){
				text2 = $(this).text();
				if (~text2.indexOf(text)){

				} else {

					$(this).parent().parent().parent().attr('style','');
					//$(this).parent().parent().parent().removeClass('setl');
				}
				//alert($(this).text());

			});
		} else {
			$('.apptaging').removeClass('active');
			$('.apptaging').parent().parent().parent().addClass('setmain');
			$('.apptaging').parent().parent().parent().attr('style','');

			console.log(2222);
			$(this).addClass('active');
			text = $(this).text();
			//alert(text);
			$('.apptagings .apptaging').each(function(){
				if ($(this).text() == text) {
					$(this).addClass('active');
				}
			});

			$('.apptagings').each(function(){
				text2 = $(this).text();
				console.log(1);
				//alert($(this).text());
				if (~text2.indexOf(text)){
					$(this).parent().parent().parent().addClass('setmain');
					$(this).parent().parent().parent().attr('style','display:flex!important');
				} else {
					$(this).parent().parent().parent().removeClass('setmain');
					$(this).parent().parent().parent().attr('style','display:none!important');
					//$(this).parent().parent().parent().addClass('setl');
				}
			});
		}
	});

	$('body').on('click','.rll-youtube-player', function(){
		let src = $(this).attr('data-src');
		$( '<iframe src="'+src+'?&autoplay=1" width="100%" height="355" frameborder="0" allowfullscreen="allowfullscreen"></iframe>' ).insertAfter( $(this) );
		$(this).remove();
	});

	$('body').on('click', '.get-faq', function(){
		$(this).toggleClass('active');
	});

	check_policy();
	if ($('html[lang="ru-RU"]').length == 0) {
		if (($('body').text().indexOf('е') == -1) && ($('body').text().indexOf('а') == -1) && ($('body').text().indexOf('о') == -1)) {

		}

	}
	$('.invest_form select').on('change', function() {
		option_first_child = $('.invest_form select > option:first-child').text();
		if (this.value != option_first_child) {
			$(this).css('display','none');
			placeholder_main = 'Логин';
			$('.login_message').attr('placeholder',''+placeholder_main+' '+this.value+'');
			$('.login_wrapper_form').removeClass('displaynone');
		}
	});

	$('body').on('click','.login_close',function (){
		$('.invest_form select').attr('style','');
		$('.login_message').val('');
		$('.login_wrapper_form').addClass('displaynone');
	})
	if (window.location.href.indexOf("/comment-") > -1) {
		another_comm_1();another_comm_2();
	}

	if (window.location.href.indexOf("/misson/") > -1) {
		if (document.body.classList.contains( 'logged_in' )) {
			$('.reg_btn_main').attr('href','/dashboard/');
			$('.reg_btn_main').text('Войти в личный кабинет');
		} else {
			$('.reg_btn_main').attr('onclick','reg_link();');
		}
	}

	if (typeof my_ajax_object !== 'undefined') {
		link = my_ajax_object.actual_link;
		if (link.indexOf("/search/") >= 0) {
			if ($('.current_tag > li').size() == 0) {
				$('#search_results_top_sorter').before($('.search_result_tabs'));

				if ($('.not_found').size() == 0) {
					var arr = [];
					$('.main_result > .active > *').each(function(){
						arr.push(parseInt($(this).attr('data-tags')));
					});
					var unique = arr.filter(function(itm, i, a) {
						return i == arr.indexOf(itm);
					});
					//console.log(unique);
					$('.search_results_filter_tags  li').attr('style','');
					$('.search_results_filter_tags  li').each(function(){
						if (unique.indexOf(parseInt($(this).attr('data-term-id'))) != -1) {

						} else {
							$(this).css('display','none')
						}
					});
					$('.search_results_filter_tags_more').addClass('active');
					$('.link_show_more_results_filter_tags').remove();
					$('.link_show_more_results_filter_tags').click();
				}


			} else {
				$('.search_result_tabs').remove();
			}
		}
	}
	n = 1;
	$('.add_links > li').each(function (){
		$(this).attr('data-n',n);
		n = ++n;
	})

	$('body').on('click', '.arrow_right_review', function () {
		$('.add_links > li:last-child').after($('.add_links > li:first-child'));
		if ($('.add_links > li:first-child').attr('data-n') != 1) {
			$('.add_links').css('margin-left','30px');
			$('.arrow_left_review').attr('style','');
		} else {
			$('.add_links').css('margin-left','0');
			$('.arrow_left_review').attr('style','display:none;');
		}
	});

	$('body').on('click', '.arrow_left_review', function () {
		$('.add_links > li:first-child').before($('.add_links > li:last-child'));
		if ($('.add_links > li:first-child').attr('data-n') != 1) {
			$('.add_links').css('margin-left','30px');
			$('.arrow_left_review').attr('style','');
		} else {
			$('.add_links').css('margin-left','0');
			$('.arrow_left_review').attr('style','display:none;');
		}
	});

	loaded_metrics = 0;

	if(typeof meta_page === 'undefined') {
		//console.log('Без метки');
		pathname = window.location.pathname

		if(pathname.indexOf('/user/') != -1){
			if (typeof window.ym != 'undefined') {
				ym(32912255,'reachGoal','userprofile');
				console.log('userprofile');
			}
		}


	} else {
		if ((loaded_metrics == 0) && (typeof ym == 'function')) {
			if ($('html').attr('lang') == 'ru') {
				nmetrics = 32912255;
			} else if ($('html').attr('lang') == 'en') {
				nmetrics = 87732294;
			} else if ($('html').attr('lang') == 'de') {
				nmetrics = 88421393;
			} else if ($('html').attr('lang') == 'es') {
				nmetrics = 88566951;
			} else if ($('html').attr('lang') == 'fr') {
				nmetrics = 88209537;
			} else {
				nmetrics = 32912255;
			}
			if (meta_page.affiliate_tags != null) {
				affiliate_tags = meta_page.affiliate_tags;
				var array = affiliate_tags.split(',');
				$.each(array, function( index, value ) {
					ym(nmetrics,'reachGoal',value);
					ym(nmetrics,'reachGoal','metka');
					console.log(value);
					loaded_metrics = 1;
				});
			}
		}
	}

	$(window).one("scroll", function() {
		if(typeof meta_page === 'undefined') {

		} else {
			if ($('html').attr('lang') == 'ru') {
				nmetrics = 32912255;
			} else if ($('html').attr('lang') == 'en') {
				nmetrics = 87732294;
			} else if ($('html').attr('lang') == 'de') {
				nmetrics = 88421393;
			} else if ($('html').attr('lang') == 'es') {
				nmetrics = 88566951;
			} else if ($('html').attr('lang') == 'fr') {
				nmetrics = 88209537;
			} else {
				nmetrics = 32912255;
			}
			// console.log(loaded_metrics+' '+typeof ym)
			if ((loaded_metrics == 0) && (typeof ym == 'function')) {
				if (meta_page.affiliate_tags != null) {
					affiliate_tags = meta_page.affiliate_tags;
					var array = affiliate_tags.split(',');
					$.each(array, function( index, value ) {
						ym(nmetrics,'reachGoal',value);
						ym(nmetrics,'reachGoal','metka');
						console.log(value);
						loaded_metrics = 1;
					});
				}
			}
		}
	});

	$('body').on('click','.back_btn_to_start',function (){
		window.location.href = '/dashboard-add-company/?add_new_company='+getUrlParameter('company');

	});

	if (getUrlParameter('company')) {
		$('div[data-name="company_name"] > .acf-label > label, div[data-name="websites"] > .acf-label > label, div[data-name="company_established"] > .acf-label > label, div[data-name="company_established"] > .acf-label > label, div[data-name="company_main_office"] > .acf-label > label, div[data-name="company_owner"] > .acf-label > label, div[data-name="base_2_support"] > .acf-label > label').each(function(){
			$(this).append('<span class="acf_star_m">*</span>');
		});
	}

	if (getUrlParameter('add_new_company')) {
		//bg_add_company
		$('.bg_add_company').remove();
		$('.bg_add_company_temp').attr('style','');
		$('.bg_add_company_temp').attr('class','bg_add_company');

	}

	$('body').on('click','.back_first_step', function(){
		$('.outside_form_container').empty();
		$('div#popup_search_companies[data-type="search_companies"] .autocomplete_icon_close').click();
		$('.text_1st_step_addcomp').css('display','block');
	});


	$('body').on('click','.get_cat_add_company .autocomplete_icon_close',function (){
		$('.go_next_add_company').remove();
	});

	$('body').on('click','div#popup_link_outside_review[data-form-type="reviewgetcompany"] div#popup_search_companies',function (){
		$('div#popup_link_outside_review[data-form-type="reviewgetcompany"] .outside_form_container').empty();
	});

	$('body').on('click','.get_cat_add_company .autocomplete_search_results ul li',function (){
		$('.outside_tags ul').empty();
		$('.go_next_add_company').remove();
		$('.bg_add_company_insert').append('<div class="button button_violet font_small font_bold  go_next_add_company pointer">Далее</div>')
	});
	$('body').on('click','.get_cat_add_company .outside_tags ul li',function (){

		$('.go_next_add_company').remove();
	});
	$('body').on('click', '.finish_btn_add_company', function(e){
		$(this).addClass('go_next_add_company_act');
		$(this).append('<div class="load_ajax"></div>');
		company_name = $('div[data-form-type="reviewgetcompany"] input[name="autocomplete_text"]').val();
		comp_id = $('div[data-form-type="reviewgetcompany"] input[name="autocomplete_result"]').val();
		comment_company = $('textarea[name="add_comment_company"]').val();
		contact_type = $( 'select[name="select_contact"]' ).val();
		login_type = $( 'input[name="contact_name"]' ).val();

		if ($( 'select[name="select_contact"]' ).val() == 'Мессенджер для связи') {
			$('.finish_btn_add_company').removeClass('go_next_add_company_act');
			$('.finish_btn_add_company .load_ajax').remove();
			popup_alert_message('Вы не выбрали мессенджер для связи','error');
		} else {
			if ($('input[name="contact_name"]').val() == '') {
				$('.finish_btn_add_company').removeClass('go_next_add_company_act');
				$('.finish_btn_add_company .load_ajax').remove();
				popup_alert_message('Вы не заполнили логин '+contact_type,'error');
			} else {
				fileuploadcomp_item_ids = [];
				$('.fileuploadcomp_item').each(function (){
					fileuploadcomp_item_ids.push(	$(this).attr('att-id')	);
				})
				fileuploadcomp_item_ids_text = fileuploadcomp_item_ids.join(", ");
				verify_method = $('.add_company_wrap input[name="verify_method"]:checked').attr('id');

				$.ajax({
					url: my_ajax_object.ajax_url,
					type: "POST",
					data: "action=connect_company&company_name="+company_name+"&contact_type="+contact_type+"&login_type="+login_type+"&comp_id="+comp_id+"&comment_company="+comment_company+"&image_views="+fileuploadcomp_item_ids_text+"&verify_method="+verify_method,
					beforeSend: function(xhr) {
						/*$('.main_result').empty();
                        $('.main_result').append('<div class="load_ajax"></div>');*/
					},
					complete: function(){
						/*$('.main_result .load_ajax').remove();*/
					},
					success: function( data ) {
						result = JSON.parse(data);
						amountParseInt = 3990;
						if (verify_method == 'pay') {
							$.ajax({
								url: my_ajax_object.ajax_url,
								type: 'POST',
								data: 'action=card_before_new&amountval=' + amountParseInt+'&id_trans_wp=' + result.poster_id,
								beforeSend: function (xhr) {
								},
								success: function (data) {
									$('.finish_btn_add_company').removeClass('go_next_add_company_act');
									$('.finish_btn_add_company .load_ajax').remove();
									$('div[data-form-type="reviewgetcompany"] .popup_close_button').click();
									window.location.href = '/dashboard/wallet/?price=3990&id='+result.poster_id;
								}
							});
						} else {
							window.location.href = '/dashboard/';
						}

					}
				});
			}

		}
	});

	$('body').on('change','input[name="verify_method"]',function (){
		if ($('input[name="verify_method"]:checked').attr('id') == 'pay') {
			$('.finish_btn_add_company').text('Далее');
		} else {
			popup_alert_message('','copy_widget');
			$('.finish_btn_add_company').text('Отправить на модерацию');
		}
	});

	//$('#popup_auth_form').on('submit', function(e) {
	$('body').on('submit', '#popup_auth_form', function(e){
		e.preventDefault();
		$('.reg_error').remove();
		var form = $(this);
		$.post(form.attr('action'), form.serialize(), function(data) {
			result = JSON.parse(data);
			if(result.status === 'ok') {
				$('#popup_auth').remove();
				auth_action();
				if ($('input[name="thispage"]').val() == 'notpopup') {
					window.location.href = '/dashboard/';
				}
			} else {
				$( '<div class="font_smaller m_b_20 color_red reg_error">'+result.message+'</div>' ).insertBefore( $( '#popup_auth_form input[name="email"]' ) );
				setTimeout(function() {
					$('.reg_error').remove();
				}, 5000);
			}
		});
	});

	//compare_icon('compare_container');

	/*
	a_i_2 = 0;
        if ($(".comment_avatar").length > 0) {

            $('.comment_avatar').each(function() {
                whMain = $(window).height();
                if (!(whMain <= $(this).offset().top)) {
                    var img = $(this).attr("data-img");
                    $(this).css('background-image', 'url(' + img + ')');
                }
            })

            $(window).scroll(function () {
                var hT2 = $('.comment_avatar').offset().top,
                    hH2 = $('.comment_avatar').outerHeight(),
                    wH2 = $(window).height(),
                    wS2 = $(this).scrollTop();
                if (wS2 > (hT2 + hH2 - wH2)) {
                    if (a_i_2 == 0) {
                        $(".comment_avatar").each(function () {
                            var img = $(this).attr("data-img");
                            $(this).css('background-image', 'url(' + img + ')');
                        });
                        a_i_2 = 1;
                    }

                }
            });
        }

a_i_3 = 0;
        if ($(".review_logo").length > 0) {

            $('.review_logo').each(function() {
                whMain = $(window).height();
                if (!(whMain <= $(this).offset().top)) {
                    var img = $(this).attr("data-img");
                    $(this).css('background-image', 'url(' + img + ')');
                }
            })

            $(window).scroll(function () {
                var hT3 = $('.review_logo').offset().top,
                    hH3 = $('.review_logo').outerHeight(),
                    wH3 = $(window).height(),
                    wS3 = $(this).scrollTop();
                if (wS3 > (hT3 + hH3 - wH3)) {
                    if (a_i_2 == 0) {
                        $(".review_logo").each(function () {
                            var img = $(this).attr("data-img");
                            $(this).css('background-image', 'url(' + img + ')');
                        });
                        a_i_3 = 1;
                    }

                }
            });
        }

	*/
	if (getUrlParameter('status') == 'not_logged_and_activate') {
		auth_link();
	}

	if (getUrlParameter('activation') == 'ok') {
		popup_alert_message('Поздравляем! Вы подтвердили профиль!','ok');
	}

	if (getUrlParameter('activation') == 'ok_email') {
		popup_alert_message('Новый E-mail адрес успешно привязан','ok');
	}

	if (getUrlParameter('activation') == 'error') {
		popup_alert_message('Произошла ошибка активации, обратитесь за помощью на e-mail адрес - info@eto-razvod.ru','error');
	}

	if (getUrlParameter('activation') == 'error_email') {
		popup_alert_message('Произошла ошибка подтверждения нового E-mail адреса, обратитесь за помощью на e-mail адрес - info@eto-razvod.ru','error');
	}

	if (getUrlParameter('company')) {
		$('.bg_add_company input').attr('autocomplete','off');$('.bg_add_company input').attr('autocorrect','off');$('.bg_add_company input').attr('autocapitalize','off');$('.bg_add_company input').attr('spellcheck','false');
	}

	$('body').on('click','.back_to_price',function(){
		if (getUrlParameter('price')) {
			attrid = $('.wallet_history > .wallet_history__row:nth-of-type(2)').attr('attr-id');
			window.location.href = '/dashboard-add-company/?attrid='+attrid;
		} else {
			$(this).parent().css('display', 'none');
			$(this).parent().prev().css('display', 'flex');
		}
	});

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
	$('body').on('click', '.form_add_images_2 .close', function(){
		$(this).closest('li').remove();
		if ($('#img_uploaded li').length == 0) {
			$("div#get_status").show();
			$("#imgstatus").attr("idstatus","2");
			$("#imgstatus .notice-title").text($("#imgstatus .notice-title").attr("attr-negative"));
			$("#imgstatus .notice-title + span").text($("#imgstatus .notice-title + span").attr("attr-negative"));
			$("#imgstatus .notice-title").attr("style","");
		}
	});
	/*$('body').on('click', '.form_add_images .close', function(){
		$(this).closest('li').remove();
	});*/

	$('body').on('click', '.notify_container_small .notify_item_notifications', function(){
		var id = $(this).attr('data-id');
		//alert(id);
		notify_single_popup(id);
	});
	$('body').on('click', '.notify_container_small .notify_item_messages', function(){
		var id = $(this).attr('data-thread-id');
		//alert(id);
		window.location.replace('/dashboard/messages/?thread='+id);
		//notify_single_popup(id);
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
	$('body').on('click', '.show-comments .comments_sorter .comments_sorter_title', function(){
		$(this).parent().toggleClass('active');
	});

	$('body').on('click','.show-comments .comments_top_show_comments ul > li',function(){
		$(this).parent().parent().removeClass('active');
		$('.show-comments .comments_top_show_comments ul > li').removeClass('active');
		$(this).addClass('active');
		$('.show-comments').addClass('hider');
		if ($(this).data('sort-type') == 'old') {
			var result = $('.show-comments > li.comment').sort(function (a, b) {

				var contentA =parseInt( $(a).data('date'));
				var contentB =parseInt( $(b).data('date'));
				return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
			});
			var comments_top = $('.show-comments .comments_top').html();
			$('.show-comments').html(result);
			$('<div class="white_block comments_top flex">'+comments_top+'</div>').insertBefore('.show-comments > li.comment:first-child');
		} else if ($(this).data('sort-type') == 'new') {
			var result = $('.show-comments > li.comment').sort(function (a, b) {

				var contentA =parseInt( $(a).data('date'));
				var contentB =parseInt( $(b).data('date'));
				return (contentA > contentB) ? -1 : (contentA < contentB) ? 1 : 0;
			});
			var comments_top = $('.show-comments .comments_top').html();
			$('.show-comments').html(result);
			$('<div class="white_block comments_top flex">'+comments_top+'</div>').insertBefore('.show-comments > li.comment:first-child');
		} else if ($(this).data('sort-type') == 'goodrun') {
			var result = $('.show-comments > li.comment').sort(function (a, b) {

				var contentA =parseInt( $(a).data('stars'));
				var contentB =parseInt( $(b).data('stars'));
				return (contentA > contentB) ? -1 : (contentA < contentB) ? 1 : 0;
			});
			var comments_top = $('.show-comments .comments_top').html();
			$('.show-comments').html(result);
			$('<div class="white_block comments_top flex">'+comments_top+'</div>').insertBefore('.show-comments > li.comment:first-child');
		}  else if ($(this).data('sort-type') == 'badrun') {
			var result = $('.show-comments > li.comment').sort(function (a, b) {

				var contentA =parseInt( $(a).data('stars'));
				var contentB =parseInt( $(b).data('stars'));
				return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
			});
			var comments_top = $('.show-comments .comments_top').html();
			$('.show-comments').html(result);
			$('<div class="white_block comments_top flex">'+comments_top+'</div>').insertBefore('.show-comments > li.comment:first-child');
		}  else if ($(this).data('sort-type') == 'best') {
			var result = $('.show-comments > li.comment').sort(function (a, b) {

				var contentA =parseInt( $(a).data('best'));
				var contentB =parseInt( $(b).data('best'));
				return (contentA > contentB) ? -1 : (contentA < contentB) ? 1 : 0;
			});
			var comments_top = $('.show-comments .comments_top').html();
			$('.show-comments').html(result);
			$('<div class="white_block comments_top flex">'+comments_top+'</div>').insertBefore('.show-comments > li.comment:first-child');
		}

		$('.show-comments').append('<div class="load_ajax"></div>');
		setTimeout(() => {
			$('.show-comments').removeClass('hider');
			$('.show-comments .load_ajax').remove();
		}, "1000")
	})


	$('body').on('click', '#reviews_about .comments_sorter .comments_sorter_title', function(){
		$(this).parent().toggleClass('active');
	});

	$('body').on('click','#reviews_about .comments_top_show_comments ul > li',function(){
		$(this).parent().parent().removeClass('active');
		$('#reviews_about .comments_top_show_comments ul > li').removeClass('active');
		$(this).addClass('active');
		$('ul#reviews_about').addClass('hider');
		if ($(this).data('sort-type') == 'old') {
			var result = $('#reviews_about > li.comment').sort(function (a, b) {

				var contentA =parseInt( $(a).data('date'));
				var contentB =parseInt( $(b).data('date'));
				return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
			});
			var comments_top = $('#reviews_about .comments_top').html();
			$('#reviews_about').html(result);
			$('<div class="white_block comments_top flex">'+comments_top+'</div>').insertBefore('#reviews_about > li.comment:first-child');
		} else if ($(this).data('sort-type') == 'new') {
			var result = $('#reviews_about > li.comment').sort(function (a, b) {

				var contentA =parseInt( $(a).data('date'));
				var contentB =parseInt( $(b).data('date'));
				return (contentA > contentB) ? -1 : (contentA < contentB) ? 1 : 0;
			});
			var comments_top = $('#reviews_about .comments_top').html();
			$('#reviews_about').html(result);
			$('<div class="white_block comments_top flex">'+comments_top+'</div>').insertBefore('#reviews_about > li.comment:first-child');
		} else if ($(this).data('sort-type') == 'goodrun') {
			var result = $('#reviews_about > li.comment').sort(function (a, b) {

				var contentA =parseInt( $(a).data('stars'));
				var contentB =parseInt( $(b).data('stars'));
				return (contentA > contentB) ? -1 : (contentA < contentB) ? 1 : 0;
			});
			var comments_top = $('#reviews_about .comments_top').html();
			$('#reviews_about').html(result);
			$('<div class="white_block comments_top flex">'+comments_top+'</div>').insertBefore('#reviews_about > li.comment:first-child');
		}  else if ($(this).data('sort-type') == 'badrun') {
			var result = $('#reviews_about > li.comment').sort(function (a, b) {

				var contentA =parseInt( $(a).data('stars'));
				var contentB =parseInt( $(b).data('stars'));
				return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
			});
			var comments_top = $('#reviews_about .comments_top').html();
			$('#reviews_about').html(result);
			$('<div class="white_block comments_top flex">'+comments_top+'</div>').insertBefore('#reviews_about > li.comment:first-child');
		}  else if ($(this).data('sort-type') == 'best') {
			var result = $('#reviews_about > li.comment').sort(function (a, b) {

				var contentA =parseInt( $(a).data('best'));
				var contentB =parseInt( $(b).data('best'));
				return (contentA > contentB) ? -1 : (contentA < contentB) ? 1 : 0;
			});
			var comments_top = $('#reviews_about .comments_top').html();
			$('#reviews_about').html(result);
			$('<div class="white_block comments_top flex">'+comments_top+'</div>').insertBefore('#reviews_about > li.comment:first-child');
		}

		$('ul#reviews_about').append('<div class="load_ajax"></div>');
		setTimeout(() => {
			$('ul#reviews_about').removeClass('hider');
			$('ul#reviews_about .load_ajax').remove();
		}, "1000")
	})

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

	$('body').on('click','.savenotify',function(){
		if (document.querySelector('#tech_notify').checked == true) {
			var site = 1;
		} else {
			var site = 0;
		}

		if (document.querySelector('#main_notify').checked == true) {
			var all = 1;
		} else {
			var all = 0;
		}

		if (document.querySelector('#insterest_notify').checked == true) {
			var tematics = 1;
		} else {
			var tematics = 0;
		}

		savesendingmails(site, all, tematics);

	});

	$('body').on('click', '.link_new_abuse_outside', function(){
		ajax_link_outside('abuse');
	});

	$('body').on('click', '.review_icon_share', function(){
		var type = $(this).attr('data-type');
		var id = $(this).attr('data-id');
		popup_form(type,id);
	});

	$('body').on('click', '.notify_user_icons .all_notify_button', function(){
		//	alert();
		notify_main_popup();
	});
	$('body').on('click', '.notify_user_icons .user_icon_notify_new.inactive', function(){
		$('.notify_user_icons li').removeClass('active');
		$('.notify_user_icons li').addClass('inactive');
		$(this).removeClass('inactive');
		$(this).addClass('active');
		$('.notify_container_small').remove();
		notify_show_recent_popup('notifications','user_icon_notify_new');
	});
	$('body').on('click', '.notify_user_icons .user_icon_notify_new.active', function(){
		$(this).removeClass('active');
		$(this).addClass('inactive');
		$('.notify_container_small').remove();
	});
	$('body').on('click', '.notify_user_icons .user_icon_msg_new.inactive', function(){
		$('.notify_user_icons li').removeClass('active');
		$('.notify_user_icons li').addClass('inactive');
		$(this).removeClass('inactive');
		$(this).addClass('active');
		$('.notify_container_small').remove();
		notify_show_recent_popup('messages','user_icon_msg_new');
	});
	$('body').on('click', '.notify_user_icons .user_icon_msg_new.active', function(){
		$(this).removeClass('active');
		$(this).addClass('inactive');
		$('.notify_container_small').remove();
	});

	$('body').on('input','input[name="autocomplete_text"]',function() {

		var phrase = $(this).val();
		var block_id = $(this).closest('.autocomplete_container').attr('id');
		var search_type = $(this).closest('.autocomplete_container').attr('data-type');
		var container_id = $('#'+block_id).closest('.popup_container').attr('id');
		//console.log(phrase +' '+ block_id +' '+ search_type +' '+ container_id);
		//alert(search_type);
		if(search_type === 'filter_ratings') {
			$('#'+container_id+' .outside_form_container').empty();
			var tags_values = $('#'+block_id+' .outside_tags input[name="tags[]"]').map(function(){return $(this).val();}).get();
			autocomplete_search_results(phrase,block_id,search_type,tags_values);
		} else if (search_type === 'filter_news') {
			$('#'+container_id+' .outside_form_container').empty();
			var tags_values = $('#'+block_id+' .outside_tags input[name="tags[]"]').map(function(){return $(this).val();}).get();
			autocomplete_search_results(phrase,block_id,search_type,tags_values);
		} else {
			if(phrase.length > 1){
				$('#'+container_id+' .outside_form_container').empty();
				//$(this).closest('form').removeClass('not_typing');
				var c_post_id = my_ajax_object.current_post_id;
				autocomplete_search_results(phrase,block_id,search_type, 0, c_post_id);

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
		if ($(this).hasClass('active')) {

		} else {
			if (window.sidebar && window.sidebar.addPanel) { // Mozilla Firefox Bookmark
				window.sidebar.addPanel(document.title, window.location.href, '');
			} else if (window.external && ('AddFavorite' in window.external)) { // IE Favorite
				window.external.AddFavorite(location.href, document.title);
			} else if (window.opera && window.print) { // Opera Hotlist
				this.title = document.title;
				return true;
			} else { // webkit - safari/chrome
				popup_alert_message('Нажмите ' + (navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Command/Cmd' : 'CTRL') + ' и D для добавления страницы в Закладки.','ok');
			}
		}
		ajax_bookmark(id,button_id);
	});

	$('body').on('click', '.inactive .rating_all_sort_title', function(){
		var id = $(this).closest('.rating_all_sort').attr('id');
		$('#'+id).removeClass('inactive');
		$('#'+id).addClass('active');
	});
	$('body').on('click','div.comment_single_title, h3.comment_single_title',function() {
		window.location.href = $(this).parent().attr('data-set');
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
		} else if (search_type === 'filter_news') {
			var myDiv1Para = $(this).remove();
			myDiv1Para.appendTo('#'+block_id+' .autocomplete_search_results ul');
			//console.log(block_id);
			resort_news_tags(block_id);
		}
	});
	$('body').on('click', '.autocomplete_search_results ul li', function(){
		var company_id = $(this).attr('data-id');
		var company_name = $(this).text();
		var block_id = $(this).closest('.autocomplete_container').attr('id');
		//console.log(block_id);
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
		} else if(search_type === 'filter_news') {
			var myDiv1Para = $(this).remove();
			myDiv1Para.appendTo('#'+block_id+' .outside_tags ul');
			//console.log(block_id);
			resort_news_tags(block_id);
			$('#' + block_id + ' .autocomplete_search_results').empty();
			$('#'+block_id).removeClass('active_search');
			$('#'+block_id+' input[name="autocomplete_text"]').val('');
			$('#'+block_id+' input[name="autocomplete_result"]').val('');
		} else {
			$('#'+block_id+' input[name="autocomplete_text"]').val(company_name);
			$('#'+block_id+' input[name="autocomplete_result"]').val(company_id);
			$('#'+block_id+' .autocomplete_search_results').removeClass('active');
			$('#'+block_id+' .autocomplete_search_results').empty();
			if (my_ajax_object.current_post_id == "150534") {
				var popup_container_id = $('#'+block_id).closest('.popup_container1').attr('id');
			} else {
				var popup_container_id = $('#'+block_id).closest('.popup_container').attr('id');
			}

			var form_type = $('#'+popup_container_id).attr('data-form-type');
			load_popup_outside_form(form_type,company_name,company_id,1,popup_container_id,'.outside_form_container');
			//console.log(1444);
		}
	});

	$('body').on('click', '.autocomplete_search_results .autocomplete_add_new', function(){
		if (my_ajax_object.current_post_id != "150534") {
			var block_id = $(this).closest('.autocomplete_container').attr('id');
			var company_id = 0;
			var company_name = $('#' + block_id + ' input[name="autocomplete_text"]').val();
			//$('#'+block_id+' input[name="autocomplete_text"]').val(company_name);
			$('#' + block_id + ' input[name="autocomplete_result"]').val(company_id);
			$('#' + block_id + ' .autocomplete_search_results').removeClass('active');
			$('#' + block_id + ' .autocomplete_search_results').empty();
			var popup_container_id = $('#' + block_id).closest('.popup_container').attr('id');
			var form_type = $('#' + popup_container_id).attr('data-form-type');
			load_popup_outside_form(form_type, company_name, company_id, 0, popup_container_id, '.outside_form_container');

		} else {
			$.ajax({
				url: my_ajax_object.ajax_url,
				type: "POST",
				data: "action=show_tags_this",
				beforeSend: function(xhr) {
				},
				complete: function(){
				},
				success: function( data ) {
					name = $('div[data-form-type="reviewgetcompany"] input[name="autocomplete_text"]').val();
					$('.bg_add_company').append('<div class="bg_add_company_insert"></div>');
					$('.bg_add_company .bg_add_company_insert').append('<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase m_b_20">Добавление компании</div>');
					$('.bg_add_company .bg_add_company_insert').append('<span class="not_founded_company">'+name+'</span>');
					$('.popup_container1').remove();
					$('.bg_add_company .bg_add_company_insert').append(data);
					$('.bg_add_company').css('display','flex');
					$('.bg_add_company').css('flex-direction','column-reverse');
				}
			});
			/*name = $('div[data-form-type="reviewgetcompany"] input[name="autocomplete_text"]').val();
			$.ajax({
				url: my_ajax_object.ajax_url,
				type: "POST",
				data: "action=add_company_by_user&name="+name,
				beforeSend: function(xhr) {
				},
				complete: function(){
				},
				success: function( data ) {
					result = JSON.parse(data);
					window.location.href = window.location.href + "?company="+result.poster_id;
				}
			});*/
		}
	});


	

	$('body').on('click','.go_next_add_company',function (){
		$(this).addClass('go_next_add_company_act');
		$(this).append('<div class="load_ajax"></div>');
		name = $('.not_founded_company').text();
		cat = $('div[data-type="filter_ratings_comp_type"] input[name="autocomplete_result"]').attr('value');
		if (getUrlParameter('add_new_company')) {
			$.ajax({
				url: my_ajax_object.ajax_url,
				type: "POST",
				data: "action=add_company_by_user_editer&name="+name+"&cat="+cat+"&add_new_company="+parseInt(getUrlParameter('add_new_company')),
				beforeSend: function(xhr) {
				},
				complete: function(){
				},
				success: function( data ) {
					result = JSON.parse(data);
					window.location.href = "/dashboard-add-company/?company="+parseInt(getUrlParameter('add_new_company'));
					//window.location.href = window.location.href + "?company="+result.poster_id;
				}
			});

		} else {
			$.ajax({
				url: my_ajax_object.ajax_url,
				type: "POST",
				data: "action=add_company_by_user&name="+name+"&cat="+cat,
				beforeSend: function(xhr) {
				},
				complete: function(){
				},
				success: function( data ) {
					result = JSON.parse(data);
					window.location.href = window.location.href + "?company="+result.poster_id;
				}
			});
		}

	})



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
		$('.header').addClass('active_type');
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
						$.ajax({
							url: my_ajax_object.ajax_url,
							type: "POST",
							data: "action=live_search_ajax_add_phrase&phrase="+phrase,
							beforeSend: function(xhr) {
							},
							complete: function(){
							},
							success: function( data ) {

							}
						});
					}
				}
			});
		}
	});
	$('.inactive_live_search input[name="s"], .inactive_live_search .search_icon').click(function() {
		$('.live_search input[name="s"]').addClass('active_input');

		$('.live_search').addClass('active_live_search');
		$('.live_search').closest(".header").addClass('active_header');
		$('.live_search').removeClass('inactive_live_search');
		$('.live_search input[name="s"]').focus();
		var close_icon = '<div class="close_icon pointer"></div>';
		$('.live_search').append(close_icon);
		$('.live_search .close_icon').click(function() {
			$('.live_search input[name="s"]').removeClass('active_input');
			$('.live_search').removeClass('active_live_search');
			$('.header').removeClass('active_header');
			$('.live_search').addClass('inactive_live_search');
			$('.live_search_results').remove();
			$('.header').removeClass('active_type');
			$('.live_search .close_icon').remove();
			$('.live_search input[name="s"]').val('');
			$('.fixed_header_review').removeClass('dn');
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
		if (tab == 'promocodes') {
			$('#search_results_top_sorter').attr('style','display:none;');
		} else {
			$('#search_results_top_sorter').attr('style','');
		}
		$(this).addClass('active');
		$(this).removeClass('inactive');
		$('.result_tab_content').removeClass('active');
		$('.result_tab_content.result_'+tab).addClass('active');
		$('.result_tab_content_search_page').removeClass('active');
		$('.result_tab_content_search_page.result_'+tab).addClass('active');
		$('.result_tab_content_search_page.active > *').attr('style','');
		$('.result_tab_content.active > *').attr('style','');

		//$('.search_results_filter_tags_more').addClass('active');
		var arr = [];
		if ($(this).hasClass('tab_promocodes')) {
			$('.result_tab_content.result_promocodes > li').each(function(){
				arr.push(parseInt($(this).attr('data-tags')));
			});
		} else {
			$('.main_result > .active > *').each(function(){
				arr.push(parseInt($(this).attr('data-tags')));
			});
		}

		var unique = arr.filter(function(itm, i, a) {
			return i == arr.indexOf(itm);
		});
		//console.log(unique);
		$('.search_results_filter_tags  li').attr('style','');
		$('.search_results_filter_tags  li').each(function(){
			if (unique.indexOf(parseInt($(this).attr('data-term-id'))) != -1) {

			} else {
				$(this).css('display','none')
			}
		});
		$('.link_show_more_results_filter_tags').click();

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
		if ($('#'+promocode_id+' .promo_title').text().length > 30) {
		} else {
			$('#'+promocode_id+' .promocode_full_description').attr('style','display: block;padding-top: 40px;');
		}
	});

	$('body').on('click', '.link_promocode_show_more.active', function(){
		var promocode_id = $(this).closest('li.white_block').attr('id');
		$('#'+promocode_id+' .promocode_full_description').hide();
		$(this).removeClass('active');
		$(this).addClass('inactive');
		$('#'+promocode_id+' .promocode_full_description').attr('style','display: none;');
	});


	$('body').on('click', '.link_promocode_text_copy', function(){
		var promocode_id = $(this).closest('li').attr('id');
		//console.log(promocode_id);
		var text_id = $('#'+promocode_id+' .promocode_single_text').attr('id');
		//console.log(text_id);
		copy_text(text_id);
		if ($('html').attr('lang') == 'fr-FR') {
			$(this).text('Copié de');
		} else if ($('html').attr('lang') == 'en-US') {
			$(this).text('Copied');
		} else if ($('html').attr('lang') == 'de-DE') {
			$(this).text('Kopiert von');
		} else if ($('html').attr('lang') == 'es-ES') {
			$(this).text('Copiado de');
		} else {
			$(this).text('Скопировано');
		}

	});

	$('body').on('click', '.link_promocode_text_copy_popup', function(){
		var promocode_id = $(this).closest('.promocode_text_container').attr('id');
		var text_id = $('#'+promocode_id+' .promocode_single_text').attr('id');
		/*copy_text(text_id);*/

		var copyText = document.getElementById(text_id+"_input");
		copyText.select();
		copyText.setSelectionRange(0, 99999)
		document.execCommand("copy");

		if ($('html').attr('lang') == 'fr-FR') {
			$(this).text('Copié de');
		} else if ($('html').attr('lang') == 'en-US') {
			$(this).text('Copied');
		} else if ($('html').attr('lang') == 'de-DE') {
			$(this).text('Kopiert von');
		} else if ($('html').attr('lang') == 'es-ES') {
			$(this).text('Copiado de');
		} else {
			$(this).text('Скопировано');
		}
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
		//$('#'+block_id+' .fast_links_content').slideDown('slow');
		$('#'+block_id+' .fast_links_content').attr('style','display:flex;');
	});
	$('body').on('click', '.fast_links.active .fast_links_opener', function(){
		var block_id = $(this).closest('.fast_links').attr('id');
		$('#'+block_id).removeClass('active');
		$('#'+block_id).addClass('inactive');
		//$('#'+block_id+' .fast_links_content').slideUp('slow');
		$('#'+block_id+' .fast_links_content').attr('style','display:none;');
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
		} else if (search_type === 'filter_news') {
			var tags_values = $('#'+block_id+' .outside_tags input[name="tags[]"]').map(function(){return $(this).val();}).get();
			//alert(tags_values);
			autocomplete_search_results(phrase,block_id,search_type,tags_values);
		} else if (search_type === 'filter_ratings_comp_type') {
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

	$('body').on('change', '#popup_reg_form input[type=checkbox]', function(){
		var name =    $(this).attr('name');
		if($(this).is(':checked')){
			$('input[name= "' +name +'"]').val('1');
			$(this).val('1');
		}
		else{
			$(this).val('0');
			$('input[name= "' +name +'"]').val('0');
		}
	});

	$('body').on('submit', '#popup_reg_form', function(e) {
		console.log('ok');
		e.preventDefault();
		$('.reg_error').remove();
		var form = $(this);
		console.log(form.serialize());
		$.post(form.attr('action'), form.serialize(), function(data) {
			result = JSON.parse(data);
			if(result.status === 'ok') {
				$('#popup_reg').remove();
				auth_action();
				//popup_alert_message(result.message,result.status);

				if ($('input[name="thispage"]').val() == 'notpopup') {
					window.location.href = '/dashboard/';
				} else {
					popup_user_form('edit_skills_popup',0,'','reg');
				}
			} else {
				console.log(result.status);
				console.log(result.mail);
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

	$('body').on('click','.status_new .read_button',function() {
		var id = $(this).closest('li.notify_item').attr('data-id');
		notify_change_status(id,'read');
		$(this).removeClass('read_button');
		$(this).addClass('read_button_read');
		$(this).text('Прочитано');
		$(this).closest('li.notify_item').removeClass('status_new');

	});

	$('body').on('click','.single_notify_item .read_button',function() {
		var id = $(this).attr('data-id');
		notify_change_status(id,'read');
		$('#popup_modals #popup_single_notify').remove();
		//append_notify_icons();

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

	$('body').on('click','.copy_code_widget',function (){
		document.querySelector("#popup_copy_widget textarea").select();
		document.execCommand('copy');
		if ($('html').attr('lang') == 'fr-FR') {
			$('.copy_code_widget').text('Copié de');
		} else if ($('html').attr('lang') == 'en-US') {
			$('.copy_code_widget').text('Copied');
		} else if ($('html').attr('lang') == 'de-DE') {
			$('.copy_code_widget').text('Kopiert von');
		} else if ($('html').attr('lang') == 'es-ES') {
			$('.copy_code_widget').text('Copiado de');
		} else {
			$('.copy_code_widget').text('Скопировано');
		}

	})

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

		if ($('.search_result_tabs > li[data-id="companies"]').hasClass("inactive")) {
			$('.result_tab_content > *').css('display','none');
			$('.result_tab_content > *[data-tags="'+$(this).attr('data-term-id')+'"]').css('display','flex');
			$('.search_results_filter_tags li').css('opacity','0.5');
			$(this).css('opacity','1');
		} else {
			if(phrase.length > 1){
				window.location.href = my_ajax_object_new.er_blog_url+'/search/'+tag+'/?q='+phrase;
			} else {
				window.location.href = my_ajax_object_new.er_blog_url+'/search/'+tag+'/';
			}
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
		$(this).closest('#toc_container').removeClass('no_bullets');
		$(this).closest('#toc_container').addClass('active');

	});
	$('body').on('click', '.active#toc_container .toc_title', function(){
		$(this).closest('#toc_container').removeClass('active');
		$(this).closest('#toc_container').addClass('no_bullets');

	});
	/*$('body').on('click', '.no_bullets#toc_container a', function(e){
		e.preventDefault();
	});*/
	$('body').on('click', '.search_results_top_sorter ul li', function(){
	    console.log(1);
		var id = $(this).closest('.search_results_top_sorter').attr('id');
		$('#'+id).removeClass('active');
		$('#'+id).addClass('inactive');
		$('#'+id+' ul li.active').removeClass('active');
		var type = $(this).attr('data-sort-type');
		var key = $('#search_results_form input').val();
		var tag = $('.search_results_filter_header .current_tag li').attr('data-term-id');
		var search_result_tabs_active = $('ul.search_result_tabs > .active').attr('data-id');
		//var form = $(this).closest('.rating_all_sort').attr('data-autocomplete-form');
		//var block_id = $(form).closest('.autocomplete_container').attr('id');
		$(this).addClass('active');
		console.log(type+' '+key+' '+tag);
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=resort_show_search_category_results&sort="+type+"&key="+key+"&term_id="+tag+"&search_result_tabs_active="+search_result_tabs_active,
			beforeSend: function(xhr) {
				$('.main_result[data-main_result="'+$('ul.search_result_tabs > .active').attr('data-id')+'"]').empty();
				$('.main_result[data-main_result="'+$('ul.search_result_tabs > .active').attr('data-id')+'"]').append('<div class="load_ajax"></div>');
			},
			complete: function(){
				$('.main_result[data-main_result="'+$('ul.search_result_tabs > .active').attr('data-id')+'"] .load_ajax').remove();
			},
			success: function( data ) {
				//$('.main_result').append(data);
				//if ($('.search_result_tabs'))
				if ($('ul.search_result_tabs > .active').attr('data-id') == 'companies') {
					console.log(1);
					data = data.replace('class="results_content"','class="уе уеу result_tab_content result_'+$('ul.search_result_tabs > .active').attr('data-id')+' results_content active"');
				} else {
					console.log(2);
					data = data.replace('class="results_content"','class="уе уеу result_tab_content result_'+$('ul.search_result_tabs > .active').attr('data-id')+' results_content active"');
				}
					console.log($('ul.search_result_tabs > .active').attr('data-id'));
				$('.main_result[data-main_result="'+$('ul.search_result_tabs > .active').attr('data-id')+'"]').append(data);
				//$('.main_result[data-main_result="'+$('.tab_companies.active').attr('data-id')+'"] > *:first-child').attr('class','result_tab_content result_'+$('.tab_companies.active').attr('data-id')+' results_content active');
			}
		});
		console.log(search_result_tabs_active);

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
		console.log('132523235 '+ select_skills);
		text = '';
		text = filter_form_ratings_all_filter_autocomplete_skills();
		console.log(text);
		//console.log(select_skills);
		if (select_skills != 0){
			//console.log(3000);
			user_skills_add_mass(text);
		}

	});

	function filter_form_ratings_all_filter_autocomplete_skills() {
		text1 = '';
		$('#filter_form_ratings_all_filter_autocomplete_skills ul li').each(function (){
			text1 = text1 + $(this).attr('data-id')+',';
			console.log('12421124'+text1);
			//console.log(3);
		})
		console.log('filter_form_ratings_all_filter_autocomplete_skills');
		return text1;
	}

	$('body').on('click','.skip_skills',function(){
		$('.popup_close_button').click();

	});
	$('body').on('click','.popup_close_button',function(){

		var popup_id = $(this).closest('.popup_container').attr('id');
		$('#' + popup_id + ' .popup_window').removeClass('shown');
		//$('#'+popup_id).remove();

		$('#' + popup_id + ' .popup_window').hide("slow", function () {
			$('#' + popup_id).remove();
		});
		//console.log(1);
		var expires = (new Date(Date.now() + 86400 * 1000)).toUTCString();
		console.log(expires);
		var expires_second = (new Date(Date.now() + 86400 * 3000)).toUTCString();
		console.log(expires_second);
		document.cookie = parseInt(my_ajax_object.current_post_id) + "_popup=1; path=/; expires=" + expires;
		document.cookie = "popupmaincookie=1; path=/; expires=" + expires_second;
		console.log('1');
	});

	$('body').on('click','a[href*="visit"]',function(){
		console.log('VISIT')
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('VISIT', {URL: document.location.href, offer: offer_slug});
		if ($(this).parent().parent().attr('class') == 'fixed_header_review fixed_header_review_2 fixed_header_review_3') {
			yaCounter32912255.reachGoal('VISITFIXEDHEADER', {URL: document.location.href, offer: offer_slug});
		}
	});

	$('body').on('click','.review_card a[href*="visit"]',function(){
		console.log('review_card')
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('CARD', {URL: document.location.href, offer: offer_slug});

	});

	$('body').on('click','.top_companies_heygo_best_com a[href*="visit"]',function(){
		console.log('POPUPTOP')
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('POPUPTOP', {URL: document.location.href, offer: offer_slug});

	});

	$('body').on('click','.top_companies_heygo_gift a[href*="visit"]',function(){
		console.log('GIFTFORREVIEW')
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('GIFTFORREVIEW', {URL: document.location.href, offer: offer_slug});

	});

	$('body').on('click','.popup_link_main .popup_main_link_main',function(){
		if ($(this).hasClass('popup_quiz')) {

		} else {
			console.log('POPUP')
			var offer_slug = this.href.split("/")[4];
			yaCounter32912255.reachGoal('POPUP', {URL: document.location.href, offer: offer_slug});
			let id = $(this).attr('data-id');
			if (id != "") {
				$.ajax({
					url: my_ajax_object.ajax_url,
					type: "POST",
					data: "action=clicktelegram&id=" + id,
					success: function (data) {

					}
				});
			}
		}



	});

	$('body').on('click','.social_links_quiz > .link.telegram',function (){
		ym(32912255,'reachGoal','TELEGRAM');
		let id = $(this).attr('data-id');
		if (id != "") {
			$.ajax({
				url: my_ajax_object.ajax_url,
				type: "POST",
				data: "action=clicktelegram&id=" + id,
				success: function (data) {

				}
			});
		}
	});

	$('body').on('click','.social_links_quiz > .link.viber',function (){
		ym(32912255,'reachGoal','VIBER');
		let id = $(this).attr('data-id');
		if (id != "") {
			$.ajax({
				url: my_ajax_object.ajax_url,
				type: "POST",
				data: "action=clickviber&id="+id,
				success: function (data) {

				}
			});
		}

	});

	$('body').on('click','.popup_window ul.heygo_promocodes .get_promocode_1',function(){
		console.log('POPUP_PROMOCODE')
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('POPUP_PROMOCODE', {URL: document.location.href, offer: offer_slug});

	});

	//.popup_window ul.heygo_promocodes .get_promocode_1

	$('body').on('click','#hey_content_review_reviews_1 a[href*="visit"], #hey_content_review_reviews_2 a[href*="visit"]',function(){
		console.log('NATIVECOMMENTS')
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('NATIVECOMMENTS', {URL: document.location.href, offer: offer_slug});

	});

	$('body').on('click','#hey_content_review_content_1 a[href*="visit"], #hey_content_review_content_2 a[href*="visit"]',function(){
		console.log('NATIVEREVIEW');
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('NATIVEREVIEW', {URL: document.location.href, offer: offer_slug});

	});

	$('body').on('click','#hey_content_rating_1 a[href*="visit"], #hey_content_rating_2 a[href*="visit"]',function(){
		console.log('NATIVERATING');
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('NATIVERATING', {URL: document.location.href, offer: offer_slug});

	});

	$('body').on('click','.row_buttons a[href*="visit"]',function(){
		console.log('RATINGBUTTON');
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('RATINGBUTTON', {URL: document.location.href, offer: offer_slug});

	});

	$('body').on('click','.similar_container a[href*="review"]',function(){
		console.log('SIMILARMAIN');
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('SIMILARMAIN', {URL: document.location.href, offer: offer_slug});

	});

	$('body').on('click','.side_block .company_in_rating_item a[href*="review"]',function(){
		console.log('SIMILARSIDE');
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('SIMILARSIDE', {URL: document.location.href, offer: offer_slug});

	});

	$('body').on('click','.container_left .promocode_list_single_right .promocode_button_container a',function(){
		console.log('PROMOCODESINGLE');
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('PROMOCODESINGLE', {URL: document.location.href, offer: offer_slug});

	});

	$('body').on('click','.block_reviews_list .promocode_button_container a, .er_list_promocodes .promocode_button_container a, .list_promocodes .promocode_button_container a',function(){
		console.log('PROMOCODELIST');
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('PROMOCODELIST', {URL: document.location.href, offer: offer_slug});

	});

	$('body').on('click','#reviewsummary a[href*="visit"]',function(){
		console.log('TABLE');
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('TABLE', {URL: document.location.href, offer: offer_slug});

	});

	$('body').on('click','.review_container_content a[href*="visit"]',function(){
		console.log('CONTENT');
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('CONTENT', {URL: document.location.href, offer: offer_slug});

	});

	$('body').on('click','.review_sidebar_banner a[href*="visit"]',function(){
		console.log('SIDEBAR');
		var offer_slug = this.href.split("/")[4];
		yaCounter32912255.reachGoal('SIDEBAR', {URL: document.location.href, offer: offer_slug});

	});

	$('body').on('click','.load_more_news',function(){
		var offset = $(this).attr('data-offset');
		var tag = $(this).attr('data-tag');
		var total = $(this).attr('data-total');
		load_more_news(offset,tag,total);
	});

	$('body').on('click', '.review_connect_company_btn', function () {
		$('.outside_form_container').empty();
		$('.text_1st_step_addcomp').css('display','none');
		$.ajax({
			url: my_ajax_object.ajax_url,
			type: "POST",
			data: "action=ajax_load_documents_form",
			beforeSend: function (xhr) {
				$('#popup_link_outside_review .outside_form_container').append('<div class="load_ajax"></div>');
			},
			complete: function () {
				$('#popup_link_outside_review .outside_form_container .load_ajax').remove();
			},
			success: function (data) {
				$('#popup_link_outside_review .outside_form_container').html(data);

			}
		});
	});

	$('body').on('change', '#fileuploadcomp', function () {
		$this = $(this);
		file_obj = $this.prop('files');
		form_data = new FormData();
		for (i = 0; i < file_obj.length; i++) {
			form_data.append('file[]', file_obj[i]);
		}
		form_data.append('action', 'file_upload');

		$.ajax({
			url: my_ajax_object.ajax_url,
			type: 'POST',
			contentType: false,
			processData: false,
			data: form_data,
			success: function (response) {
				$this.val('');
				$( ".fileuploadcomp_wrapper" ).prepend(response);
				//var result = response.split(',');
				/*$.each( result, function( key, value ) {
					if (value != '') {
						$( ".fileuploadcomp_wrapper" ).prepend( '<span class="fileuploadcomp_item" style="background-image:url(\''+value+'\');"><span class="close"></span></span>' );
					}
				});*/
			}
		});
	});

	$('body').on('click', '.fileuploadcomp_item .close', function () {
		$(this).parent().remove();
	});
	$('body').on('click', '.line_show_more_comments', function () {
		var height = $(this).attr('data-height');
		var new_height = parseInt(height,10) + parseInt('400',10);
		var block_id = $(this).closest('.er_block_comments').attr('id');
		//alert(new_height);
		$(this).attr('data-height',new_height);
		$('#'+block_id).css('max-height',new_height);
	});
	$('body').on('click', '#popup_form_review_newform .preview_review.clickable', function () {
		$('.reg_error').remove();
		$(this).removeClass('clickable');
		$('#popup_form_review_newform input[name="action"]').val('new_submit_review_newform_preview');
		var form = $(this).closest('form');
		$('.form_separate_review_single .preview').empty();
		$('.form_separate_review_single .preview').append('<div class="load_ajax"></div>');
		$.post(
			form.attr('action'),
			form.serialize(),
			function(data) {

				$('.form_separate_review_single .preview .load_ajax').remove();
				//alert(data);

				$('.form_separate_review_single .preview').append(data);
				if ($('#img_uploaded > li').length !== 0) {
					if ($('.publish_accept').hasClass('publish_not_accept') === false) {
						$( ".review_text" ).after( "<ul class=\"comment_attached_files_list\"></ul>" );
						$('#img_uploaded > li').each(function(){
							val_img = $(this).attr('data-attr');
							val_full_img = $(this).attr('data-full');
							$('.comment_attached_files_list').append('<li><a href="'+val_full_img+'" style="background-image:url('+val_img+');" target="_blank"></a></li>')
						});
					}
				}
				$('#popup_form_review_newform .preview_review').addClass('clickable');
			}
		);
	});
	$('body').on('click', '#popup_form_review_newform .plus_minus_container.plus .plus', function () {
		var total = $(this).attr('data-total');

		if(total < 7) {
			var total_new = parseInt(total,10) + parseInt('1',10);
			$(this).attr('data-total',total_new);
			$('#popup_form_review_newform .plus_minus_container.plus').append('<div class="review_pluses_new"><input type="text" name="review_pluses[]" value="" class="m_b_20" /><span class="delete">x</span></div>');
		}


	});
	$('body').on('click','.page_header_rating .show_more_popular_categories',function() {
		if ($(this).text() == 'Показать все') {
			$('.page_header_rating li').css('display','inline-block');
			$(this).text('Скрыть');
			$(this).addClass('rotate_180deg');
		} else {
			$('.page_header_rating li').attr('style','');
			$(this).text('Показать все');
			$(this).removeClass('rotate_180deg');
		}
	});
	$('body').on('click', '#popup_form_review_newform .plus_minus_container.minus .plus', function () {
		var total = $(this).attr('data-total');
		if(total < 7) {
			var total_new = parseInt(total,10) + parseInt('1',10);
			$(this).attr('data-total',total_new);
			$('#popup_form_review_newform .plus_minus_container.minus').append('<div class="review_minuses_new"><input type="text" name="review_minuses[]" value="" class="m_b_20" /><span class="delete">x</span></div>');
		}
	});
	$('body').on('click', '#popup_form_review_newform .plus_minus_container.plus .delete', function () {
		$(this).closest('.review_pluses_new').remove();
		var total = $('#popup_form_review_newform .plus_minus_container.plus .plus').attr('data-total');
		var total_new = parseInt(total,10) - parseInt('1',10);
		$('#popup_form_review_newform .plus_minus_container.plus .plus').attr('data-total',total_new);
	});

	$('body').on('click', '#popup_form_review_newform .plus_minus_container.minus .delete', function () {
		$(this).closest('.review_minuses_new').remove();
		var total = $('#popup_form_review_newform .plus_minus_container.minus .plus').attr('data-total');
		var total_new = parseInt(total,10) - parseInt('1',10);
		$('#popup_form_review_newform .plus_minus_container.minus .plus').attr('data-total',total_new);
	});
	$('body').on('click', '#popup_form_review_newform .form_icon_notify.inactive', function () {
		$('#popup_form_review_newform .form_icon_notify').append('<input type="hidden" name="notify_me" value="on" />');
		$(this).removeClass('inactive');
		$(this).addClass('active');
	});
	$('body').on('click', '#popup_form_review_newform .form_icon_notify.active', function () {
		$('#popup_form_review_newform .form_icon_notify input[name="notify_me"]').remove();
		$(this).removeClass('active');
		$(this).addClass('inactive');
	});
	$('body').on('click', '#popup_search_companies .autocomplete_search_results ul li', function () {
		var id = $(this).attr('data-id');
		get_single_newform_by_name(id,'');
	});
	$('body').on('click', '#popup_search_companies .autocomplete_search_results .autocomplete_add_new', function () {
		var id = 0;
		var new_name = $('.review_form_separate input[name="autocomplete_text"]').val();
		//alert(new_name);
		get_single_newform_by_name(id,new_name);
	});
	$('body').on('submit', '#after_login_new_comment_form_update_name', function(e) {
		e.preventDefault();
		var form = $(this);
		$.post(
			form.attr('action'),
			form.serialize(),
			function(data) {
				result = JSON.parse(data);
				if(result.status === 'error') {
					$('.reg_error').remove();
					$( '<div class="font_smaller m_b_20 color_red reg_error">'+result.message+'</div>' ).insertAfter( $( '#after_login_new_comment_form_update_name' ) );
					setTimeout(function() {
						$('.reg_error').remove();
					}, 5000);
				} else if (result.status === 'ok') {
					$('.reg_error').remove();
					$('#after_login_new_comment_form_update_name').empty();
					$('#after_login_new_comment_form_update_name').append('<div class="m_t_20 color_green reg_error">'+result.message+'</div>');
					setTimeout(function() {
						$('.reg_error').remove();
					}, 5000);
				}
			}
		);
	});
	$('body').on('submit', '#after_login_new_comment_form', function(e) {
		e.preventDefault();

		var form = $(this);
		//alert(form);
		$.post(
			form.attr('action'),
			form.serialize(),
			function(data) {
				result = JSON.parse(data);
				if(result.status === 'error') {
					$('.reg_error').remove();
					$( '<div class="font_smaller m_b_20 color_red reg_error">'+result.message+'</div>' ).insertAfter( $( '#after_login_new_comment_form' ) );
					setTimeout(function() {
						$('.reg_error').remove();
					}, 5000);
				} else if (result.status === 'auth') {
					$('.reg_error').remove();
					$( '#after_login_new_comment_form' ).append('<div class="font_smaller m_b_20 color_green reg_success line_new_form_100">'+result.message+'</div>');
					if ($('html').attr('lang') == 'en-US') {
						text1 = 'Enter';
					} else if ($('html').attr('lang') == 'de-DE') {
						text1 = 'Betreten';
					} else if ($('html').attr('lang') == 'fr-FR') {
						text1 = 'Entrer';
					} else if ($('html').attr('lang') == 'es-ES') {
						text1 = 'Entrar';
					} else {
						text1 = 'Войти';
					}
					$('#after_login_new_comment_form input[type="submit"]').val('Войти');
					$('#after_login_new_comment_form input[name="action"]').val('after_login_new_comment_form_submit_auth_me');
					$('body').on('click', '.change_email_newform', function () {
						if ($('html').attr('lang') == 'en-US') {
							text1 = 'Further';
						} else if ($('html').attr('lang') == 'de-DE') {
							text1 = 'Des Weiteren';
						} else if ($('html').attr('lang') == 'fr-FR') {
							text1 = 'Plus loin';
						} else if ($('html').attr('lang') == 'es-ES') {
							text1 = 'Más lejos';
						} else {
							text1 = 'Далее';
						}
						$('#after_login_new_comment_form input[type="submit"]').val(text1);
						$('#after_login_new_comment_form input[name="action"]').val('after_login_new_comment_form_submit');
						$('.reg_success').remove();
						$('#after_login_new_comment_form input[name="email"]').val('');
					});
				} else if(result.status === 'login_error') {
					$('.reg_error').remove();
					$( '<div class="font_smaller m_b_20 color_red reg_error">'+result.message+'</div>' ).insertAfter( $( '#after_login_new_comment_form' ) );
					setTimeout(function() {
						$('.reg_error').remove();
					}, 5000);
				} else if(result.status === 'login_ok') {
					var comment_id = $('#after_login_new_comment_form input[name="comment_id"]').val();
					var post_id = $('#after_login_new_comment_form input[name="post_id"]').val();
					attach_new_review_to_new_user(comment_id,post_id);
					auth_action();
				} else if(result.status === 'new_reg') {
					//alert(result.message);
					$('.reg_error').remove();
					$('<div class="font_smaller m_b_20 color_green reg_success line_new_form_100">'+result.message+'</div>').insertAfter($( '#after_login_new_comment_form input[name="email"]' ) );
					var comment_id = $('#after_login_new_comment_form input[name="comment_id"]').val();
					var post_id = $('#after_login_new_comment_form input[name="post_id"]').val();
					if ($('html').attr('lang') == 'en-US') {
						text1 = 'Complete registration';
					} else if ($('html').attr('lang') == 'de-DE') {
						text1 = 'Komplette Registrierung';
					} else if ($('html').attr('lang') == 'fr-FR') {
						text1 = 'Enregistrement complet';
					} else if ($('html').attr('lang') == 'es-ES') {
						text1 = 'Registro completo';
					} else {
						text1 = 'Завершить регистрацию';
					}
					$('#after_login_new_comment_form input[type="submit"]').val(text1);
					$('#after_login_new_comment_form input[name="action"]').val('after_login_new_comment_form_submit_reg_me');
					//alert(comment_id);
					//attach_new_review_to_new_user_after_reg(comment_id,post_id,result.user_id,result.password);
				} else if(result.status === 'reg_ok') {
					var comment_id = $('#after_login_new_comment_form input[name="comment_id"]').val();
					var post_id = $('#after_login_new_comment_form input[name="post_id"]').val();
					attach_new_review_to_new_user_after_reg(comment_id,post_id,result.user_id,result.password);
					auth_action();
				}
			}
		);
	});

	$('body').on('click','.islogclick',function (ev){
		ev.preventDefault();
		if ($(this).hasClass('send_blog_post')) {
			linked = '/dashboard/services/blog/';
		}
		if ($(this).hasClass('gotodashboard')) {
			linked = '/dashboard-add-company/';
		}
		if ($(this).hasClass('gotodashboard_notifications')) {
			linked = '/dashboard/notifications/';
		}

		if ($(this).hasClass('gotodashboard_messages')) {
			linked = '/dashboard/messages/';
		}

		if ($(this).hasClass('gotodashboard_blog')) {
			linked = '/dashboard/services/blog/';
		}


		if ($(this).hasClass('gotodashboard_pro')) {
			linked = '/dashboard/services/pro/';
		}

		if ($(this).hasClass('islogclick-simple')) {
			linked = $(this).attr('data-islogclick');
		}
//gotodashboard
		if (document.body.classList.contains( 'logged_in' ) == true) {
			window.location.href = linked;
		} else {
			auth_link();
		}
	});
	$('body').on('submit', '.unclickable#popup_form_review_newform', function(e) {
		e.preventDefault();
	});
	$('body').on('submit', '.clickable#popup_form_review_newform', function(e) {
		console.log('0000000000000000000000333333');
		$('#popup_form_review_newform .review_single_button_container_width').append('<div class="load_ajax white"></div>');
		$('#popup_form_review_newform input[type="submit"]').addClass('has_load_ajax');
		$(this).removeClass('clickable');
		$(this).addClass('unclickable');
		$('.reg_error').remove();
		e.preventDefault();
		$('#popup_form_review_newform input[name="action"]').val('new_submit_review_newform');

		var form = $(this);

		$.post(
			form.attr('action'),
			form.serialize(),
			function(data) {
				console.log('11111111111133333');
				$('#popup_form_review_newform .review_single_button_container_width .load_ajax').remove();
				$('#popup_form_review_newform input[type="submit"]').removeClass('has_load_ajax');
				$('#popup_form_review_newform').removeClass('unclickable');
				$('#popup_form_review_newform').addClass('clickable');
				//alert(data);
				result = JSON.parse(data);
				if(result.status === 'error') {
					$( '<div class="font_smaller m_b_20 color_red reg_error">'+result.message+'</div>' ).insertBefore( $( '#popup_form_review_newform input[type="submit"]' ) );
					setTimeout(function() {
						$('.reg_error').remove();
					}, 5000);
				} else if (result.status === 'ok') {

					$.ajax({
						url: my_ajax_object.ajax_url,
						type: "POST",
						data: "action=success_review_form&post_id="+result.post_id+"&comment_id="+result.comment_id+"&user_id="+result.user_id,
						beforeSend: function(xhr) {
							$('#popup_form_review_newform').closest('.review_form_separate .wrap').empty();
							$('.review_form_separate .wrap ').append('<div class="load_ajax"></div>');
						},
						complete: function(){
							$('.review_form_separate .wrap .load_ajax').remove();
						},
						success: function( data ) {
							console.log('2222222222233333');
							result_new = JSON.parse(data);
							if(result_new.status === 'need_reg') {
								$('.review_form_separate .wrap').append(result_new.message);
							} else if (result_new.status === 'ok') {
								$('.review_form_separate .wrap').append(result_new.message);
							}
							$('#myBtn').trigger('click');


						}
					});

				}
				//$( '<div class="font_smaller m_b_20 color_red reg_error">'+data+'</div>' ).insertBefore( $( '#popup_form_review_newform input[type="submit"]' ) );
				//alert(data);

			}
		);
	});


	$('body').on('click','.dropdowncourse',function(){
		if ($(this).hasClass('active')) {

			num = parseInt($(this).parent().parent().attr('data-show-set'))+1;
			$('.setdnblockmofieid4[data-show-set="'+num+'"]').removeClass('antisetdnblockmofieid');
			$(this).removeClass('active');

		} else {

			num = parseInt($(this).parent().parent().attr('data-show-set'))+1;
			$('.setdnblockmofieid4[data-show-set="'+num+'"]').addClass('antisetdnblockmofieid');
			$(this).addClass('active');

		}

	});

	$('body').on('click', '.social_share_links ul li', function(){
		var link = $(this).attr('data-link');
		var post_id = $(this).attr('data-post-id');
		var social_id = $(this).attr('data-social-id');
		var container_id = $(this).closest('.social_share_links').attr('id');
		//  alert(link+' '+post_id+' '+social_id+' '+container_id);
		//
		if(social_id === 'viber' || social_id === 'whatsapp' || social_id === 'email') {
			window.location = link;
		} else {
			window.open(link, '_blank', 'width=400,height=400');
		}
		share_update_count(post_id,social_id,container_id);
	});


	$('body').on('click', '.button_review_link_comment', function () {
		ym(32912255,'reachGoal','CLICK_OFFER_FROM_COMMENT');
	});

	$('body').on('click', '#header .active_live_search .search_icon', function () {
		val_search = $('#header .active_live_search .active_input').val();
		if (val_search != '') {
			window.location.href = my_ajax_object_new.er_blog_url+'/search/?q='+val_search;
		}
	});

	if ($('.add_links').width() > $(window).width()) {
		$('.arrow_right_review').removeClass('dn');
	}

	$('body').on('click', '.search_icon', function () {
		$('.fixed_header_review').addClass('dn');
	});

	/*$(window).scroll(function () {
		if (($('.active_fixed_page__single_review').size() == 1) || ($('.active_fixed_page__single_prcode').size() == 1) || ($('.active_fixed_page__single_comments').size() == 1) || ($('.active_fixed_page__single_addpage').size() == 1)) {

			review_bar_main = $('.review_bar').position().top;

			review_block_main_button = $('.container_side .review_block_main_button').position().top;
			review_block_main_button_href = $('.container_side .review_block_main_button').attr('href');
			review_block_main_button_text = $('.container_side .review_block_main_button').text();
			review_block_main_button_width = $('.container_side .review_block_main_button').outerWidth();
			if (review_block_main_button_width < 50) {
				review_block_main_button_width = $('.main_button_mobile .review_block_main_button').width() + 30;
				review_block_main_button = $('.main_button_mobile .review_block_main_button').position().top;
			}


			if ($(window).scrollTop() + 1 >= review_bar_main) {
				if ($('.fixed_header_review').size() == 0) {
					if ($('#wpadminbar').size() == 1) {
						wpadminbar = $('#wpadminbar').outerHeight();
					} else {
						wpadminbar = 0;
					}

					outerHeight = $('#header').outerHeight() + wpadminbar;
					review_bar_width = $('.review_bar').width();

					$('.main_container').append('<div class="fixed_header_review fixed_header_review_2 fixed_header_review_3"><div class="fixed_header_review__inside wrap"><ul class="review_links font_uppercase flex font_smaller_2 font_bolder color_dark_gray">' + $('.review_links').html() + '</ul></div></div>');
					$('.fixed_header_review').css({
						"position": "fixed",
						"width": "100%",
						"background": "#fff",
						"text-align": "center",
						"top": outerHeight + "px",
						"z-index": 100,
						"border-bottom": "1px solid #E9F0F3"
					});
					/!*$('.fixed_header_review__inside').css({
                        "width": review_bar_width+"px",
                        "margin": "0 auto",
                    });*!/
				}
			} else {
				if ($('.fixed_header_review').size() != 0) {
					$('.fixed_header_review').remove();
				}
			}

			if ($(window).scrollTop() + 1 >= review_block_main_button) {
				if ($('.button_review_link').size() == 0) {
					$('.fixed_header_review__inside').append('<a href="' + review_block_main_button_href + '" class="button_review_link" target="_blank">' + review_block_main_button_text + '</a>');
					if ($(window).width() > 1210) {
						$('.button_review_link').css('width', review_block_main_button_width + 'px');
						$('.button_review_link').css('padding', '0');
					} else {

					}
				}
			} else {
				if ($('.button_review_link').size() != 0) {
					$('.button_review_link').remove();
				}
			}

			if ($('.review_sidebar_banner.sticky').size() != 0) {
				if ($(window).width() > 1210) {
					$('.review_sidebar_banner.sticky').css('top', '164px');
				}

			}
		}
	});*/


	$(window).scroll(function(){
		/*if (getUrlParameter('testfixed')) {
			review_bar_main = $('.review_bar').position().top;

			review_block_main_button = $('.container_side .review_block_main_button').position().top;
			review_block_main_button_href = $('.container_side .review_block_main_button').attr('href');
			review_block_main_button_text = $('.container_side .review_block_main_button').text();
			review_block_main_button_width = $('.container_side .review_block_main_button').outerWidth();
			if (review_block_main_button_width < 50) {
				review_block_main_button_width = $('.main_button_mobile .review_block_main_button').width() + 30;
				review_block_main_button = $('.main_button_mobile .review_block_main_button').position().top;
			}


			if ($(window).scrollTop()+1 >= review_bar_main) {
				if ($('.fixed_header_review').size() == 0) {
					if ($('#wpadminbar').size() == 1) {
						wpadminbar = $('#wpadminbar').outerHeight();
					} else {
						wpadminbar = 0;
					}

					outerHeight = $('#header').outerHeight() + wpadminbar;
					review_bar_width = $('.review_bar').width();

					$('.main_container').append('<div class="fixed_header_review"><div class="fixed_header_review__inside wrap"><ul class="review_links font_uppercase flex font_smaller_2 font_bolder color_dark_gray">'+$('.review_links').html()+'</ul></div></div>');
					$('.fixed_header_review').css({
						"position": "fixed",
						"width": "100%",
						"background": "#fff",
						"text-align": "center",
						"top": outerHeight+"px",
						"z-index": 100,
						"border-bottom": "1px solid #E9F0F3"
					});
					/!*$('.fixed_header_review__inside').css({
						"width": review_bar_width+"px",
						"margin": "0 auto",
					});*!/
				}
			} else {
				if ($('.fixed_header_review').size() != 0) {
					$('.fixed_header_review').remove();
				}
			}

			if ($(window).scrollTop()+1 >= review_block_main_button) {
				if ($('.button_review_link').size() == 0) {
					$('.fixed_header_review__inside').append('<a href="'+review_block_main_button_href+'" class="button_review_link" target="_blank">'+review_block_main_button_text+'</a>');
					if ($(window).width() > 1210) {
						$('.button_review_link').css('width', review_block_main_button_width + 'px');
						$('.button_review_link').css('padding', '0');
					} else {
						
					}
				}
			} else {
				if ($('.button_review_link').size() != 0) {
					$('.button_review_link').remove();
				}
			}

			if ($('.review_sidebar_banner.sticky').size() != 0) {
				if ($(window).width() > 1210) {
					$('.review_sidebar_banner.sticky').css('top','164px');
				}

			}
		}

		if (getUrlParameter('testfixed_2')) {
			review_bar_main = $('.review_bar').position().top;

			review_block_main_button = $('.container_side .review_block_main_button').position().top;
			review_block_main_button_href = $('.container_side .review_block_main_button').attr('href');
			review_block_main_button_text = $('.container_side .review_block_main_button').text();
			review_block_main_button_width = $('.container_side .review_block_main_button').outerWidth();
			if (review_block_main_button_width < 50) {
				review_block_main_button_width = $('.main_button_mobile .review_block_main_button').width() + 30;
				review_block_main_button = $('.main_button_mobile .review_block_main_button').position().top;
			}


			if ($(window).scrollTop()+1 >= review_bar_main) {
				if ($('.fixed_header_review').size() == 0) {
					if ($('#wpadminbar').size() == 1) {
						wpadminbar = $('#wpadminbar').outerHeight();
					} else {
						wpadminbar = 0;
					}

					outerHeight = $('#header').outerHeight() + wpadminbar;
					review_bar_width = $('.review_bar').width();

					$('.main_container').append('<div class="fixed_header_review fixed_header_review_2"><div class="fixed_header_review__inside wrap"><ul class="review_links font_uppercase flex font_smaller_2 font_bolder color_dark_gray">'+$('.review_links').html()+'</ul></div></div>');
					$('.fixed_header_review').css({
						"position": "fixed",
						"width": "100%",
						"background": "#fff",
						"text-align": "center",
						"top": outerHeight+"px",
						"z-index": 100,
						"border-bottom": "1px solid #E9F0F3"
					});
					/!*$('.fixed_header_review__inside').css({
						"width": review_bar_width+"px",
						"margin": "0 auto",
					});*!/
				}
			} else {
				if ($('.fixed_header_review').size() != 0) {
					$('.fixed_header_review').remove();
				}
			}

			if ($(window).scrollTop()+1 >= review_block_main_button) {
				if ($('.button_review_link').size() == 0) {
					$('.fixed_header_review__inside').append('<a href="'+review_block_main_button_href+'" class="button_review_link" target="_blank">'+review_block_main_button_text+'</a>');
					if ($(window).width() > 1210) {
						$('.button_review_link').css('width', review_block_main_button_width + 'px');
						$('.button_review_link').css('padding', '0');
					} else {

					}
				}
			} else {
				if ($('.button_review_link').size() != 0) {
					$('.button_review_link').remove();
				}
			}

			if ($('.review_sidebar_banner.sticky').size() != 0) {
				if ($(window).width() > 1210) {
					$('.review_sidebar_banner.sticky').css('top','164px');
				}

			}
		}

		if (getUrlParameter('testfixed_3')) {
			review_bar_main = $('.review_bar').position().top;

			review_block_main_button = $('.container_side .review_block_main_button').position().top;
			review_block_main_button_href = $('.container_side .review_block_main_button').attr('href');
			review_block_main_button_text = $('.container_side .review_block_main_button').text();
			review_block_main_button_width = $('.container_side .review_block_main_button').outerWidth();
			if (review_block_main_button_width < 50) {
				review_block_main_button_width = $('.main_button_mobile .review_block_main_button').width() + 30;
				review_block_main_button = $('.main_button_mobile .review_block_main_button').position().top;
			}


			if ($(window).scrollTop()+1 >= review_bar_main) {
				if ($('.fixed_header_review').size() == 0) {
					if ($('#wpadminbar').size() == 1) {
						wpadminbar = $('#wpadminbar').outerHeight();
					} else {
						wpadminbar = 0;
					}

					outerHeight = $('#header').outerHeight() + wpadminbar;
					review_bar_width = $('.review_bar').width();

					$('.main_container').append('<div class="fixed_header_review fixed_header_review_2 fixed_header_review_3"><div class="fixed_header_review__inside wrap"><ul class="review_links font_uppercase flex font_smaller_2 font_bolder color_dark_gray">'+$('.review_links').html()+'</ul></div></div>');
					$('.fixed_header_review').css({
						"position": "fixed",
						"width": "100%",
						"background": "#fff",
						"text-align": "center",
						"top": outerHeight+"px",
						"z-index": 100,
						"border-bottom": "1px solid #E9F0F3"
					});
					/!*$('.fixed_header_review__inside').css({
						"width": review_bar_width+"px",
						"margin": "0 auto",
					});*!/
				}
			} else {
				if ($('.fixed_header_review').size() != 0) {
					$('.fixed_header_review').remove();
				}
			}

			if ($(window).scrollTop()+1 >= review_block_main_button) {
				if ($('.button_review_link').size() == 0) {
					$('.fixed_header_review__inside').append('<a href="'+review_block_main_button_href+'" class="button_review_link" target="_blank">'+review_block_main_button_text+'</a>');
					if ($(window).width() > 1210) {
						$('.button_review_link').css('width', review_block_main_button_width + 'px');
						$('.button_review_link').css('padding', '0');
					} else {

					}
				}
			} else {
				if ($('.button_review_link').size() != 0) {
					$('.button_review_link').remove();
				}
			}

			if ($('.review_sidebar_banner.sticky').size() != 0) {
				if ($(window).width() > 1210) {
					$('.review_sidebar_banner.sticky').css('top','164px');
				}

			}
		}
*/
		if ($('.active_fixed_page__single_review_2').length != 0) {
			review_bar_main = $('.review_bar').position().top;

			review_block_main_button = $('.container_side .review_block_main_button').position().top;
			review_block_main_button_href = $('.container_side .review_block_main_button').attr('href');
			review_block_main_button_text = $('.container_side .review_block_main_button').text();
			review_block_main_button_width = $('.container_side .review_block_main_button').outerWidth();
			if (review_block_main_button_width < 50) {
				review_block_main_button_width = $('.main_button_mobile .review_block_main_button').width() + 30;
				review_block_main_button = $('.main_button_mobile .review_block_main_button').position().top;
			}


			if ($(window).scrollTop()-70 >= review_bar_main) {
				if ($('.fixed_header_review').length == 0) {
					if ($('#wpadminbar').length == 1) {
						wpadminbar = $('#wpadminbar').outerHeight();
					} else {
						wpadminbar = 0;
					}

					outerHeight = $('#header').outerHeight() + wpadminbar;
					review_bar_width = $('.review_bar').width();

					$('.main_container').append('<div class="fixed_header_review fixed_header_review_2 fixed_header_review_3"><div class="fixed_header_review__inside wrap"><ul class="review_links font_uppercase flex font_smaller_2 font_bolder color_dark_gray">'+$('.review_links').html()+'</ul></div></div>');
					$('.fixed_header_review').css({
						"position": "fixed",
						"width": "100%",
						"background": "#fff",
						"text-align": "center",
						"top": outerHeight+"px",
						"z-index": 100,
						"border-bottom": "1px solid #E9F0F3"
					});
					/*$('.fixed_header_review__inside').css({
						"width": review_bar_width+"px",
						"margin": "0 auto",
					});*/
				}
			} else {
				if ($('.fixed_header_review').length != 0) {
					$('.fixed_header_review').remove();
				}
			}

			if ($(window).scrollTop()-50 >= review_block_main_button) {

				if ($('.button_review_link').length == 0) {
					if ($(window).width() < 400) {
						if (review_block_main_button_text.length > 40) {
							css = 'style="font-size:10px;"';
						} else if (review_block_main_button_text.length > 29) {
							css = 'style="font-size:12px;"';
						} else {
							css = '';
						}
					} else if ($(window).width() < 440) {
						if (review_block_main_button_text.length > 40) {
							css = 'style="font-size:13px;"';
						} else if (review_block_main_button_text.length > 29) {
							css = 'style="font-size:14px;"';
						} else {
							css = '';
						}
					} else {
						if (review_block_main_button_text.length > 40) {
							css = 'style="font-size:12px;"';
						} else if (review_block_main_button_text.length > 29) {
							css = 'style="font-size:14px;"';
						} else {
							css = '';
						}
					}

					$('.fixed_header_review__inside').append('<a href="'+review_block_main_button_href+'" class="button_review_link" target="_blank" '+css+'>'+review_block_main_button_text+'</a>');
					if ($(window).width() > 1210) {
						/*$('.button_review_link').css('width', review_block_main_button_width + 'px');
						$('.button_review_link').css('padding', '0');*/
					} else {

					}
				}
			} else {
				if ($('.button_review_link').length != 0) {
					$('.button_review_link').remove();
				}
			}

			if ($('.review_sidebar_banner.sticky').length != 0) {
				if ($(window).width() > 1210) {
					$('.review_sidebar_banner.sticky').css('top','164px');
				}

			}
		}
	});

	$('body').on('click','.accord .title_text_image_block',function(){
		$(this).parent().parent().toggleClass('accord-active');
	});



	$('body').on('click','.fixed_header_review__inside ul.review_links > li',function(e){


		if (($(this).attr('data-tab') != '') && (typeof $(this).attr('data-tab') !== 'undefined') ){
			if ($('#wpadminbar').size() == 1) {
				wpadminbar = $('#wpadminbar').outerHeight();
			} else {
				wpadminbar = 0;
			}

			if ($(window).width() > 1210) {
				minus = $('.fixed_header_review').height();
				$('html, body').animate({
					//scrollTop: $("."+$(this).attr('data-tab')).offset().top-98 //review_bar
					scrollTop: $('.review_bar').offset().top-minus //
				}, 1000);

				if (	($('.button_review_link').size() == 0) && ($('.review_block_main_button').is(":visible") == false)		) {
					$('.fixed_header_review__inside').append('<a href="'+review_block_main_button_href+'" class="button_review_link" target="_blank">'+review_block_main_button_text+'</a>');
				}
			} else if ($(window).width() > 929) {
				minus = $('.fixed_header_review').height()+$('#header').height()+wpadminbar;
				if ($(this).attr('data-tab') == 'review_container_about') {
					minus = 0+wpadminbar;

					$('html, body').animate({
						scrollTop: $('.review_container_about').offset().top-minus
					}, 1000);
				} else {
					$('html, body').animate({
						scrollTop: $('.'+$(this).attr('data-tab')).offset().top-minus
					}, 1000);
				}
			} else if ($(window).width() < 930) {
				minus = $('.fixed_header_review').height()+$('#header').height()+wpadminbar;
				if ($(this).attr('data-tab') == 'review_container_about') {
					minus = $('.button_review_link').height()+wpadminbar;

					$('html, body').animate({
						scrollTop: $('.review_container_about').offset().top-minus
					}, 1000);
				} else {
					$('html, body').animate({
						scrollTop: $('.'+$(this).attr('data-tab')).offset().top-minus
					}, 1000);
				}
			}

		}
	});

	$('img.lazyloaded').each(function (){
		console.log('testload');
		if ((/data:image/i.test($(this).attr('src')))) {
			if ($(this).attr('data-lazy-src') != '') {
				$(this).attr('src',$(this).attr('data-lazy-src'));
			}
		}
	});

	i = 0;
	$('.dropdowncourse').each(function(index){

		if (!$(this).parent().parent().hasClass('setdnblockmofieid4')) {
			if (i != 0){
				//$('.syuda').text(i);
				$('.syuda').removeClass('syuda');
			}
			if (index != 0 && i == 0) {
				$('.syuda').remove();
				$('.syuda').removeClass('syuda');

				$(this).addClass('syuda');
			} else {

				$('.syuda').removeClass('syuda');
				$(this).addClass('syuda');
				i = 0;
			}


		} else {
			$(this).remove();
			i = i+1;
			//declOfNum1 = declOfNum(i, ['курс', 'курса', 'курсов']);
			//$('.syuda').text('Ещё '+i+' '+declOfNum1);

		}
	});

	if ($('html').attr('lang') == 'fr-FR') {
		$('.the_content a').each(function(index){
			$(this).after('<span class="spanspacing">393259325932952395</span>');
			if ( ($('.the_content').text().indexOf('395)') != -1) || ($('.the_content').text().indexOf('395,') != -1) || ($('.the_content').text().indexOf('395.') != -1) || ($('.the_content').text().indexOf('395!') != -1) || ($('.the_content').text().indexOf('395(') != -1) || ($('.the_content').text().indexOf('395;') != -1) || ($('.the_content').text().indexOf('395 ') != -1)) {
				$('.spanspacing').remove();
				$(this).addClass('ok');
			} else {
				$('.spanspacing').remove();
				$(this).after(' ')
				$(this).addClass('notok');
			}
		});
	} else if ($('html').attr('lang') == 'en-US') {
		$('.the_content a').each(function(index){
			$(this).after('<span class="spanspacing">393259325932952395</span>');
			if ( ($('.the_content').text().indexOf('395)') != -1) || ($('.the_content').text().indexOf('395,') != -1) || ($('.the_content').text().indexOf('395.') != -1) || ($('.the_content').text().indexOf('395!') != -1) || ($('.the_content').text().indexOf('395(') != -1) || ($('.the_content').text().indexOf('395;') != -1) || ($('.the_content').text().indexOf('395 ') != -1)) {
				$('.spanspacing').remove();
				$(this).addClass('ok');
			} else {
				$('.spanspacing').remove();
				$(this).after(' ')
				$(this).addClass('notok');
			}
		});
	} else if ($('html').attr('lang') == 'de-DE') {
		$('.the_content a').each(function(index){
			$(this).after('<span class="spanspacing">393259325932952395</span>');
			if ( ($('.the_content').text().indexOf('395)') != -1) || ($('.the_content').text().indexOf('395,') != -1) || ($('.the_content').text().indexOf('395.') != -1) || ($('.the_content').text().indexOf('395!') != -1) || ($('.the_content').text().indexOf('395(') != -1) || ($('.the_content').text().indexOf('395;') != -1) || ($('.the_content').text().indexOf('395 ') != -1)) {
				$('.spanspacing').remove();
				$(this).addClass('ok');
			} else {
				$('.spanspacing').remove();
				$(this).after(' ')
				$(this).addClass('notok');
			}
		});
	} else if ($('html').attr('lang') == 'es-ES') {
		$('.the_content a').each(function(index){
			$(this).after('<span class="spanspacing">393259325932952395</span>');
			if ( ($('.the_content').text().indexOf('395)') != -1) || ($('.the_content').text().indexOf('395,') != -1) || ($('.the_content').text().indexOf('395.') != -1) || ($('.the_content').text().indexOf('395!') != -1) || ($('.the_content').text().indexOf('395(') != -1) || ($('.the_content').text().indexOf('395;') != -1) || ($('.the_content').text().indexOf('395 ') != -1)) {
				$('.spanspacing').remove();
				$(this).addClass('ok');
			} else {
				$('.spanspacing').remove();
				$(this).after(' ')
				$(this).addClass('notok');
			}
		});
	}
});

/*
//setTimeout(function(){
var mql = window.matchMedia('screen and (min-width: 901px)');
	//var clientHeight_left = document.getElementById('middlecontent').clientHeight;
	//var clientHeight_right = document.getElementById('sidebar').clientHeight;
	// var clientHeight_floating = document.getElementById('sidebar_floating').clientHeight;
	// alert('left: '+clientHeight_left+' right: '+clientHeight_right);
	//  alert(clientHeight_floating);
	//if (mql.matches && (clientHeight_right) < clientHeight_left) {

	if (mql.matches) {
		jQuery(function($) {
			var $cache = $('.review_sidebar_banner');
			var vTop = $cache.offset().top;
			//alert(vTop);

			jQuery(function($) {

				function fixDiv() {
					//	alert(vTop);
					if ($(window).scrollTop() >= vTop)
						$cache.css({
							'position': 'fixed',
							'top': '100px',
							'width': '378px',
						});
					else if ($(window).scrollTop() < (vTop))
						$cache.css({
							'position': 'relative',
							'top': 'auto'
						});
				}
				$(window).scroll(fixDiv);
				fixDiv();
			});
		});
	}
//	}, 6000);*/