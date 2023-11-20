<?php
set_query_var('dashboard_type', 'dashboard_messages');
set_query_var('dashboard_breadcrumb_name', 'Сообщения');
$current_user = wp_get_current_user();
$user_id = $current_user->data->ID;
set_query_var('user_id',$user_id);
wp_localize_script( 'jquery', 'dashboard_var',array('1','1'));
wp_enqueue_style('messages', get_template_directory_uri() . '/css/messages.css', [], $special_word.filemtime(TEMPLATEPATH . '/css/messages.css'));
if (!( is_user_logged_in())) {
	wp_redirect('/');
	exit;
}
get_header();
wp_enqueue_script( 'user-messages', get_template_directory_uri() . '/js/user-messages.js', array('jquery'), $special_word.filemtime(TEMPLATEPATH . '/js/user-messages.js') );
?>
<?php if (is_user_logged_in()) {
	echo user_dashboard_messages();
} ?>

<?php
get_footer('profile');
?>