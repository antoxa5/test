#!/usr/bin/php
<?php

// Let's load WordPress
chdir( __DIR__ . "/../../../../" );
echo __DIR__ . "/../../../../".PHP_EOL;

define('SHORTINIT', true);
require( 'wp-load.php' );

if ( ! function_exists( 'wp' ) ) {
        exit;
}

global $wpdb;

$users = $wpdb->get_results( "
	SELECT u.user_login, u.user_email, u.display_name, u.user_registered, um.meta_value FROM wp_users AS u 
	LEFT JOIN wp_usermeta AS um ON u.ID=um.user_id AND um.meta_key='user_skills' 
	WHERE 
	u.id IN (
		SELECT um.user_id FROM wp_usermeta AS um WHERE
			um.user_id NOT IN (
				SELECT um.user_id FROM wp_usermeta AS um 
				WHERE um.meta_key='user_reg_type' AND um.meta_value='company'
			)
	)
	AND
	u.id NOT IN (
		SELECT c.user_id FROM wp_comments AS c WHERE c.comment_approved = 'spam'
	)
	AND um.meta_value IS NOT NULL AND um.meta_value != '' AND um.meta_value != 'a:0:{}'
	ORDER BY u.user_registered DESC
");

$new_skills = [];
$named_skills = [];

foreach( $users as $user ) {

	$user_skills = unserialize($user->meta_value);

	foreach( $user_skills as $user_skill ) {

		$new_skills[$user_skill][] = $user->user_email;

	}

}

// print_r($new_skills);


foreach( $new_skills as $new_skill_key => $new_skill ) {

	$skill_name = $wpdb->get_results( $wpdb->prepare( "SELECT name FROM wp_terms WHERE term_id='%s' LIMIT 0,1", $new_skill_key ) );

	$named_skills[$skill_name[0]->name] = $new_skill;

}

// print_r($named_skills);

// echo join(';', array_keys( $named_skills ) ) . PHP_EOL;

foreach( array_keys( $named_skills ) as $named_skill ) {

	echo $named_skill . PHP_EOL;

	echo implode( PHP_EOL, $named_skills[$named_skill] );

	echo PHP_EOL.PHP_EOL.PHP_EOL;
}
