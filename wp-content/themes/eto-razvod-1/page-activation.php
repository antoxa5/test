<?php status_header(404); ?>
<?php
date_default_timezone_set( 'Europe/Moscow' );
global $wpdb;
$mydb = new wpdb('eto_sendmail','V9OgJszo3sgUmm3r','eto_sendmail','localhost');

if ($_GET['key']) {
	$mail_key = htmlspecialchars($_GET['key']);
	$mail = $mydb->get_results("select * from mails WHERE mail_key = '$mail_key'");
	$mydb->update(
		'mails',
		array('status'=> 'clicked'),
		array( 'id' => $mail[0]->id ),
		array( '%s' )
	);
	$mydb->update(
		'mails',
		array('updated'=> date('Y-m-d H:i:s')),
		array( 'id' => $mail[0]->id ),
		array( '%s' )
	);
}
?>
<?php if (is_user_logged_in()) { ?>
	<?php $user_info = get_userdata(get_current_user_id()); ?>
	<?php if (($_GET['activation']) && ($_GET['user'])) {
		if (    ($_GET['activation'] == get_field('key_activation', 'user_'.get_current_user_id( )) ) && ($_GET['user'] ==  ($user_info->data->user_nicename) )    ) {
			update_field( 'user_activation', 'yes', 'user_'.get_current_user_id());
			if ($_GET['key']) {
				$mail_key = htmlspecialchars($_GET['key']);
				$mail = $mydb->get_results("select * from mails WHERE mail_key = '$mail_key'");
				$mydb->update(
					'mails',
					array('status'=> 'clicked_activated_auth'),
					array( 'id' => $mail[0]->id ),
					array( '%s' )
				);
				$mydb->update(
					'mails',
					array('updated'=> date('Y-m-d H:i:s')),
					array( 'id' => $mail[0]->id ),
					array( '%s' )
				);
			}
			$content_reg = 'Поздравляем, Вы успешно подтвердили ваш E-mail адрес '.$user_info->data->user_email;
			notify_user_action('system_email_activated',$user_info->ID,'Ваш аккаунт активирован!',$content_reg);
			wp_redirect('/user/?activation=ok');
		} else {
			wp_redirect('/user/?activation=error');
		}
	} ?>
<?php } else { ?>
	<?php $user = get_user_by( 'slug', $_GET['user'] ); ?>
	<?php $user_info = get_userdata($user->ID); ?>
	<?php if (($_GET['activation']) && ($_GET['user'])) {
		if (    ($_GET['activation'] == get_field('key_activation', 'user_'.$user->ID) ) && ($_GET['user'] ==  ($user_info->data->user_nicename) )    ) {
			update_field( 'user_activation', 'yes', 'user_'.$user->ID);
			if ($_GET['key']) {
				$mail_key = htmlspecialchars($_GET['key']);
				$mail = $mydb->get_results("select * from mails WHERE mail_key = '$mail_key'");
				$mydb->update(
					'mails',
					array('status'=> 'clicked_activated_noauth'),
					array( 'id' => $mail[0]->id ),
					array( '%s' )
				);
				$mydb->update(
					'mails',
					array('updated'=> date('Y-m-d H:i:s')),
					array( 'id' => $mail[0]->id ),
					array( '%s' )
				);
			}
			//echo 'Не залогинен и активирован';
			wp_redirect('/?status=not_logged_and_activate');
			//include_once(TEMPLATEPATH .'/inc/addons/login-activation.php');
			//wp_redirect('/user/?activation=ok');
			//exit;
		} else {
			//echo 'Не залогинен и не активирован';
			//include_once(TEMPLATEPATH .'/inc/addons/login-activation.php');
			wp_redirect('/?status=not_logged_and_not_activate');
		}
	} ?>
	<?php //include_once(TEMPLATEPATH .'/inc/addons/login-activation.php'); ?>
<?php } ?>