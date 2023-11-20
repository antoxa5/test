<?php
set_query_var('dashboard_type', 'dashboard_promo');
set_query_var('dashboard_breadcrumb_name', 'Акции');
get_header();
$userid = get_query_var('user_id');
$company_slug = get_query_var('company_slug');
$comp_id = get_query_var('comp_id');
$counters = profile_stats_count( $userid );
//echo profile_top($userid,$counters);
wp_enqueue_script( 'user-messages', get_template_directory_uri() . '/js/user-messages.js', array('jquery'), filemtime(TEMPLATEPATH . '/js/user-messages.js') );
if (is_user_logged_in()) {
	echo company_dashboard_promo($userid,$comp_id,$company_slug);
}
get_footer('profile');
?>