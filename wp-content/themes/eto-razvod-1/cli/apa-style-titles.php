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

function capitalize_string( $string ) {

	$short_terms = [
		"a", "aboard", "about", "above", "accordingly", "across", "after", "against", "ahead", "along", "although", "amid", "amidst", "among", "amongst", 
		"an", "and", "are", "around", "as", "at", 
		"because", "before", "behind", "below", "beneath", "beside", "between", "beyond", "but", "by", 
		"concerning", "consequently", "considering", 
		"despite", "down", "due", "during", "even though", "except", 
		"for", "from", "furthermore", 
		"hence", "however", 
		"if", "in", "inside", "into", "is", 
		"like", 
		"meanwhile", "moreover", 
		"near", "nevertheless", "nor", "notwithstanding", 
		"of", "off", "on", "onto", "or", "otherwise", "out", "outside", "over", 
		"past", "per", 
		"regarding", "round", 
		"since", "so", 
		"than", "the", "thereby", "though", "through", "throughout", "thus", "till", "to", "toward", "towards", 
		"under", "underneath", "unlike", "until", "unto", "up", "upon", 
		"via", 
		"whereas", "while", "with", "within", "without", 
		"yet", 
	];

	$words = explode( ' ', trim( $string ) );

	foreach ($words as $key => $value) {

		if( !in_array( $value, $short_terms ) ) {
			$words[$key] = ucfirst( $value );
		}

		if( mb_strpos( $value, '-' ) !== false ) {

			$in_words = explode( '-', $value );
			foreach( $in_words as $in_key => $in_value ) {

				$in_words[$in_key] = ucfirst( $in_value );

			}

			$words[$key] = implode( '-', $in_words );
		}
	}

	return trim( ucfirst( implode( ' ', $words ) ) );

}

function repair_tail( $string ) {

	$current = explode( '|', $string );
	if( mb_strpos( $current[count($current)-1], '™' ) !== false ) {
		$current[count($current)-1] = ' Revieweek™';
	}

	$current = implode( '|', $current );

	return $current;

}

echo PHP_EOL.PHP_EOL;


$strings = $wpdb->get_results( "SELECT p.ID AS post_id, td.id AS translated_id, td.translated FROM wp_posts AS p, wp_trp_dictionary_ru_ru_en_us AS td
	WHERE p.post_title=td.original AND p.post_type IN ('post', 'page', 'casino', 'promocodes', 'promocodes_cats') AND p.post_status IN ('publish') AND td.translated <> ''");

foreach( $strings as $string ) {

	$current = capitalize_string( $string->translated );

	echo "POST[".$string->post_id."] ".$current.PHP_EOL;

	if( strlen( $current) ) {

		$wpdb->query( $wpdb->prepare( "
			UPDATE wp_trp_dictionary_ru_ru_en_us
			SET translated='%s'
			WHERE id='%d'
			", $current, $string->translated_id
		));

	}

	// $meta_strings = $wpdb->query( $wpdb->prepare( "
	// 		SELECT td.id, td.translated FROM wp_postmeta AS pm, wp_trp_dictionary_ru_ru_en_us AS td
	// 		WHERE 
	// 		pm.post_id='%d' AND
	// 		pm.meta_key='seo_title' AND
	// 		pm.meta_value=td.original AND
	// 		td.translated <> ''
	// 		LIMIT 0,1
	// 	", $string->post_id
	// ));

	// $current = capitalize_string( $meta_strings[0]->translated );

	// echo "META: ".$current.PHP_EOL;

	// $wpdb->query( $wpdb->prepare( "
	// 	UPDATE wp_trp_dictionary_ru_ru_en_us
	// 	SET translated='%s'
	// 	WHERE id='%d'
	// 	", capitalize_string( $string->translated ), $string->translated_id
	// ));

}

$strings = $wpdb->get_results( "SELECT td.id AS translated_id, td.translated FROM wp_trp_dictionary_ru_ru_en_us AS td 
	WHERE (
		td.translated LIKE '%| Revieweek™%' OR 
		td.translated LIKE '%| It\'s a scam™%' OR 
		td.translated LIKE '%| It\'s a scam ™%' OR 
		td.translated LIKE '%| It\'s a Deal™%' OR
		td.translated LIKE '%| It\'s a divorce™%'
	)
" );

foreach( $strings as $string ) {

	$current = repair_tail( $string->translated );

	$current = capitalize_string( $current );

	echo "TRANSLATED[".$string->translated_id."] ".$string->translated.' > '.$current.PHP_EOL;

	if( strlen( $current) ) {

		$wpdb->query( $wpdb->prepare( "
			UPDATE wp_trp_dictionary_ru_ru_en_us
			SET translated='%s'
			WHERE id='%d'
			", $current, $string->translated_id
		));
	
	}

}


$strings2 = $wpdb->get_results( "SELECT td.id AS translated_id, td.translated FROM wp_trp_dictionary_ru_ru_de_de AS td 
	WHERE (
		td.translated LIKE '%| Revieweek™%' OR 
		td.translated LIKE '%| It\'s a scam™%' OR 
		td.translated LIKE '%| It\'s a scam ™%' OR 
		td.translated LIKE '%| It\'s a Deal™%' OR 
		td.translated LIKE '%| It\'s a divorce™%' OR 
		td.translated LIKE '%| Es ist ein Betrug ™%' OR 
		td.translated LIKE '%| Es ist ein Betrug™%'
	)
" );

foreach( $strings2 as $string ) {

	$current = repair_tail( $string->translated );

	echo "TRANSLATED[".$string->translated_id."] ".$string->translated.' > '.$current.PHP_EOL;

	if( strlen( $current) ) {

		$wpdb->query( $wpdb->prepare( "
			UPDATE wp_trp_dictionary_ru_ru_de_de
			SET translated='%s'
			WHERE id='%d'
			", $current, $string->translated_id
		));
	
	}

}


$strings3 = $wpdb->get_results( "SELECT td.id AS translated_id, td.translated FROM wp_trp_dictionary_ru_ru_es_es AS td 
	WHERE (
		td.translated LIKE '%| Revieweek™%' OR 
		td.translated LIKE '%| It\'s a scam™%' OR 
		td.translated LIKE '%| It\'s a scam ™%' OR 
		td.translated LIKE '%| It\'s a Deal™%' OR 
		td.translated LIKE '%| It\'s a divorce™%' OR 
		td.translated LIKE '%| Es un divorcio ™%' OR 
		td.translated LIKE '%| Es un divorcio™%'
	)
" );

foreach( $strings3 as $string ) {

	$current = repair_tail( $string->translated );

	echo "TRANSLATED[".$string->translated_id."] ".$string->translated.' > '.$current.PHP_EOL;

	if( strlen( $current) ) {

		$wpdb->query( $wpdb->prepare( "
			UPDATE wp_trp_dictionary_ru_ru_es_es
			SET translated='%s'
			WHERE id='%d'
			", $current, $string->translated_id
		));
	
	}

}


$strings4 = $wpdb->get_results( "SELECT td.id AS translated_id, td.translated FROM wp_trp_dictionary_ru_ru_fr_fr AS td 
	WHERE (
		td.translated LIKE '%| Revieweek™%' OR 
		td.translated LIKE '%| It\'s a scam™%' OR 
		td.translated LIKE '%| It\'s a scam ™%' OR 
		td.translated LIKE '%| It\'s a Deal™%' OR 
		td.translated LIKE '%| It\'s a divorce™%' OR 
		td.translated LIKE '%| C\'est un divorce ™%' OR 
		td.translated LIKE '%| C\'est un divorce™%' OR 
		td.translated LIKE '%| C\'est une arnaque™%'
	)
" );

foreach( $strings4 as $string ) {

	$current = repair_tail( $string->translated );

	echo "TRANSLATED[".$string->translated_id."] ".$string->translated.' > '.$current.PHP_EOL;

	if( strlen( $current) ) {

		$wpdb->query( $wpdb->prepare( "
			UPDATE wp_trp_dictionary_ru_ru_fr_fr
			SET translated='%s'
			WHERE id='%d'
			", $current, $string->translated_id
		));
	
	}

}


$strings5 = $wpdb->get_results( "SELECT td.id AS translated_id, td.translated FROM wp_trp_dictionary_ru_ru_pl_pl AS td 
	WHERE (
		td.translated LIKE '%| Revieweek™%' OR 
		td.translated LIKE '%| It\'s a scam™%' OR 
		td.translated LIKE '%| It\'s a scam ™%' OR 
		td.translated LIKE '%| It\'s a Deal™%' OR 
		td.translated LIKE '%| It\'s a divorce™%' OR 
		td.translated LIKE '%| To jest rozwód ™%' OR
		td.translated LIKE '%| To jest rozwód™%'
	)
" );

foreach( $strings5 as $string ) {

	$current = repair_tail( $string->translated );

	echo "TRANSLATED[".$string->translated_id."] ".$string->translated.' > '.$current.PHP_EOL;

	if( strlen( $current) ) {

		$wpdb->query( $wpdb->prepare( "
			UPDATE wp_trp_dictionary_ru_ru_pl_pl
			SET translated='%s'
			WHERE id='%d'
			", $current, $string->translated_id
		));
	
	}

}


$strings6 = $wpdb->get_results( "SELECT td.id AS translated_id, td.translated FROM wp_trp_dictionary_ru_ru_fi AS td 
	WHERE (
		td.translated LIKE '%| Revieweek™%' OR 
		td.translated LIKE '%| It\'s a scam™%' OR 
		td.translated LIKE '%| It\'s a scam ™%' OR 
		td.translated LIKE '%| It\'s a Deal™%' OR 
		td.translated LIKE '%| It\'s a divorce™%' OR 
		td.translated LIKE '%| Se on avioero ™%' OR
		td.translated LIKE '%| Se on avioero™%'
	)
" );

foreach( $strings6 as $string ) {

	$current = repair_tail( $string->translated );

	echo "TRANSLATED[".$string->translated_id."] ".$string->translated.' > '.$current.PHP_EOL;

	if( strlen( $current) ) {

		$wpdb->query( $wpdb->prepare( "
			UPDATE wp_trp_dictionary_ru_ru_fi
			SET translated='%s'
			WHERE id='%d'
			", $current, $string->translated_id
		));
	
	}

}


$strings7 = $wpdb->get_results( "SELECT td.id AS translated_id, td.translated FROM wp_trp_dictionary_ru_ru_id_id AS td 
	WHERE (
		td.translated LIKE '%| Revieweek™%' OR 
		td.translated LIKE '%| It\'s a scam™%' OR 
		td.translated LIKE '%| It\'s a scam ™%' OR 
		td.translated LIKE '%| It\'s a Deal™%' OR 
		td.translated LIKE '%| It\'s a divorce™%' OR 
		td.translated LIKE '%| Ini adalah perceraian ™%' OR
		td.translated LIKE '%| Ini adalah perceraian™%'
	)
" );

foreach( $strings7 as $string ) {

	$current = repair_tail( $string->translated );

	echo "TRANSLATED[".$string->translated_id."] ".$string->translated.' > '.$current.PHP_EOL;

	if( strlen( $current) ) {

		$wpdb->query( $wpdb->prepare( "
			UPDATE wp_trp_dictionary_ru_ru_id_id
			SET translated='%s'
			WHERE id='%d'
			", $current, $string->translated_id
		));
	
	}

}


echo PHP_EOL;
