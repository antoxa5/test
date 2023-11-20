<?php
set_query_var('dashboard_type', 'dashboard_abuses');
set_query_var('dashboard_breadcrumb_name', 'Жалобы');
get_header();
$userid = get_query_var('user_id');
$company_slug = get_query_var('company_slug');
$comp_id = get_query_var('comp_id');
$counters = profile_stats_count( $userid );
//echo profile_top($userid,$counters);
if (is_user_logged_in()) {
	echo company_dashboard_abuses($userid,$comp_id,$company_slug);
}
get_footer('profile');
?>