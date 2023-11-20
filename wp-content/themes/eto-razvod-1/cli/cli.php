#!/usr/bin/php
<?php

//error_reporting(E_ALL ^ E_WARNING);

if( $argc == 1 ) {
	echo <<<EOT
Использование: cli.php [OPTION]

Аргументы:
  --test-arg    Тестовый метод

EOT;

	exit;
}

// Let's load WordPress
chdir( __DIR__ . "/../../../../" );
echo __DIR__ . "/../../../../".PHP_EOL;
define('SHORTINIT', true);
require( 'wp-load.php' );

if ( ! function_exists( 'wp' ) ) {
        exit;
}


$key = $argv[1];
switch( $key ) {
	case '--test-arg':
		echo "Тестовый метод\n";
        test_method();
	break;

}

echo PHP_EOL;

//   --test-arg    Тестовый метод
function test_method() {

    print_r( [ basename(__FILE__) . ':' . __LINE__,  ], 1 );

}
