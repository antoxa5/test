<?php
set_query_var('dashboard_type', 'dashboard_blog');
set_query_var('dashboard_breadcrumb_name', 'Публикация статьи в блог');
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
	echo user_dashboard_pro_buy();
}

//(get_field('services_user_services','user_'.get_current_user_id())[0] == 84175) ?>
<!--<div class="infoblock button_gray border_radius_4px">        <span href="#" class="infoblock__link color_dark_blue font_bold flex">            <span class="infoblock__icon"></span>            <span class="infoblock__text">На данный момент у вас подключен <span class="user_label font_smaller pro_get_t">PRO</span> до 11/12/2021</span>        </span></div>-->
<?php
get_footer('profile');;
?>
