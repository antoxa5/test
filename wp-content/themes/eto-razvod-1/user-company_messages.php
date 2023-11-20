<?php
set_query_var('dashboard_type', 'dashboard_messages');
set_query_var('dashboard_breadcrumb_name', 'Сообщения');
get_header();
$userid = get_query_var('user_id');
$company_slug = get_query_var('company_slug');
$comp_id = get_query_var('comp_id');
$counters = profile_stats_count( $userid );
//echo profile_top($userid,$counters);
wp_enqueue_style('messages', get_template_directory_uri() . '/css/messages.css', [], $special_word.filemtime(TEMPLATEPATH . '/css/messages.css'));
wp_enqueue_script( 'user-messages', get_template_directory_uri() . '/js/user-messages.js', array('jquery'), $special_word.filemtime(TEMPLATEPATH . '/js/user-messages.js') );
if (is_user_logged_in()) {
	echo company_dashboard_messages($userid,$comp_id,$company_slug);
}
get_footer('profile');
?>