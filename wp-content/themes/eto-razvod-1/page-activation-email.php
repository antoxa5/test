<?php status_header(404); ?>
<?php if (is_user_logged_in()) { ?>
	<?php $user_info = get_userdata(get_current_user_id()); ?>
	<?php if (($_GET['activation']) && ($_GET['user'])) {
		if (    ($_GET['activation'] == get_field('key_activation', 'user_'.get_current_user_id( )) ) && ($_GET['user'] ==  ($user_info->data->user_nicename) )    ) {
			update_field( 'user_activation', 'yes', 'user_'.get_current_user_id());
			
			
			if (get_field('from_site_send', 'user_'.get_current_user_id())) {
				if (intval(get_field('from_site_send', 'user_'.get_current_user_id())) == 1) {
					$from_site_send = 1;
				} else {
					$from_site_send = 0;
				}
			} else {
				$from_site_send = 1;
			}
			
			if (get_field('all_send', 'user_'.get_current_user_id())) {
				if (intval(get_field('all_send', 'user_'.get_current_user_id())) == 1) {
					$all_send = 1;
				} else {
					$all_send = 0;
				}
			} else {
				$all_send = 0;
			}
			
			if (get_field('tematics_send', 'user_'.get_current_user_id())) {
				if (intval(get_field('tematics_send', 'user_'.get_current_user_id())) == 1) {
					$tematics_send = 1;
				} else {
					$tematics_send = 0;
				}
			} else {
				$tematics_send = 0;
			}
			
			if ($tematics_send != 0 || $all_send != 0) {
				savesendingmails_static($from_site_send, 0, 0);
				savesendingmails_static($from_site_send, $all_send, $tematics_send, get_field('new_email_field','user_'.get_current_user_id()));
			}
			
			$user_id = wp_update_user( [
				'ID'       => get_current_user_id(),
				'user_email'      => get_field('new_email_field','user_'.get_current_user_id())
			] );
			update_field('new_email_field', '', 'user_'.get_current_user_id());
			update_field('date_from_update', '', 'user_'.get_current_user_id());
			wp_redirect('/user/?activation=ok_email');
			exit;
		} else {
			wp_redirect('/user/?activation=error');
			exit;
		}
	} ?>
<?php } else { ?>
	<?php wp_redirect('/?status=not_logged_and_not_activate'); ?>
<?php } ?>
