<?php
set_query_var('dashboard_type', 'dashboard_notifications');
set_query_var('dashboard_breadcrumb_name', 'Уведомления');
$current_user = wp_get_current_user();
$user_id = $current_user->data->ID;
set_query_var('user_id',$user_id);
wp_localize_script( 'jquery', 'dashboard_var',array('1','1'));
if (!( is_user_logged_in())) {
	wp_redirect('/');
	exit;
}
get_header();
?>
<?php if (is_user_logged_in()) {
	echo user_dashboard_notification();
} ?>

<?php
get_footer('profile');;
?>