<?php
//$result .= 'удалить66666666'.transliterator_transliterate('Russian-Latin/BGN', $prase);
$prase_explode = explode(' ',$prase);
if (count($prase_explode) == 1) {
	//$result .= 'удалить'.'test1';
	if(isRussian($prase)) {

		//$result .= 'RU';
		$letters = [['ай','i'],['кс','x'],['аль','al'],['с','c'],['тиньк','tink'],['блэк','black'],['э','a'],['гик','geek'],['брейн','brain'],['бреин','brain'],['гикбреин','geekbrain'],['гикбрейнс','geekbrain']];

		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase, $value[0])) {
				if (strpos($prase, $value[0]) !== FALSE) {

					$args['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase)),
						'compare' => 'LIKE'
					);
					//$result .= 'удалить56565656999'.$test;

				}
			}
		}

		$letters2 = [[' ','-'],[' ','.']];

		$arr = [];
		foreach ($letters2 as $value) {

			if (strstr($prase, $value[0])) {
				if (strpos($prase, $value[0]) !== FALSE) {
					$test = str_replace($value[0], $value[1], $prase);
					$args['meta_query'][] = array(
						'key' => 'company_name',
						'value' => str_replace($value[0], $value[1], $prase),
						'compare' => 'LIKE'
					);

				}
			}
		}
		//$result .= $test;


		$phrase_alter = transliterator_transliterate('Russian-Latin/BGN', $prase);
		//$result .= 'удалить436346346'.transliterator_transliterate('Russian-Latin/BGN', $prase);

		//$result .= '<br />';
		//$result .= $phrase_alter;

	} else {
		//$result .= 'not_RU';
		$letters = [['h','х'],['tink','тиньк'],['tink','тиньк'],['black','блэк'],['a','э']];

		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase, $value[0])) {
				if (strpos($prase, $value[0]) !== FALSE) {

					$args['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase)),
						'compare' => 'LIKE'
					);

				}
			}
		}
		$phrase_alter = transliterator_transliterate('Latin-Russian/BGN', $prase);
		//$result .= 'удалить3463463463'.transliterator_transliterate('Latin-Russian/BGN', $prase);
		//print_r(transliterator_list_ids());
		//$result .= '<br />';
		//$result .= $phrase_alter;

	}
}
elseif (count($prase_explode) == 2) {
	//$result .= 'удалить'.'test2';
	//разбивка на 2 слова
	//if (    ((isRussian($prase_explode[0])) && !(isRussian($prase_explode[1]))) || (isRussian($prase_explode[1])) && !(isRussian($prase_explode[0])) ) {
	//если оно из слов русское, а второе нет
	//$result .= 'удалить'.'test4';
	if(isRussian($prase_explode[0])) {

		//$result .= 'RU';
		$letters = [['ай','i'],['кс','x'],['аль','al'],['с','c'],['тиньк','tink'],['блэк','black'],['э','a'],['гик','geek'],['брейн','brain'],['бреин','brain'],['гикбреин','geekbrain'],['гикбрейнс','geekbrain']];

		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase_explode[0], $value[0])) {
				if (strpos($prase_explode[0], $value[0]) !== FALSE) {

					$args['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase_explode[0])),
						'compare' => 'LIKE'
					);

				}
			}
		}

		$letters2 = [[' ','-'],[' ','.']];

		$arr = [];
		foreach ($letters2 as $value) {

			if (strstr($prase_explode[0], $value[0])) {
				if (strpos($prase_explode[0], $value[0]) !== FALSE) {
					$test = str_replace($value[0], $value[1], $prase_explode[0]);
					$args['meta_query'][] = array(
						'key' => 'company_name',
						'value' => str_replace($value[0], $value[1], $prase_explode[0]),
						'compare' => 'LIKE'
					);

				}
			}
		}
		//$result .= $test;


		$phrase_alter = transliterator_transliterate('Russian-Latin/BGN', $prase_explode[0]);
		//$result .= '<br />';
		//$result .= $phrase_alter;

	} else {
		//$result .= 'удалить'.'3 шаг';
		//$result .= 'not_RU';
		$letters = [['h','х'],['tink','тиньк'],['tink','тиньк'],['black','блэк'],['a','э']];

		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase_explode[0], $value[0])) {
				if (strpos($prase_explode[0], $value[0]) !== FALSE) {

					$args['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase_explode[0])),
						'compare' => 'LIKE'
					);

				}
			}
		}
		$phrase_alter = transliterator_transliterate('Latin-Russian/BGN', $prase_explode[0]);
		//$result .= 'удалить9999'.transliterator_transliterate('Latin-Russian/BGN', $prase_explode[0]);
		//print_r(transliterator_list_ids());
		//$result .= '<br />';
		//$result .= $phrase_alter;

	}

	if(isRussian($prase_explode[1])) {

		//$result .= 'RU';
		$letters = [['ай','i'],['кс','x'],['аль','al'],['с','c'],['тиньк','tink'],['блэк','black'],['э','a'],['гик','geek'],['брейн','brain'],['бреин','brain'],['гикбреин','geekbrain'],['гикбрейнс','geekbrain']];

		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase_explode[1], $value[0])) {
				if (strpos($prase_explode[1], $value[0]) !== FALSE) {

					$args['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase_explode[1])),
						'compare' => 'LIKE'
					);

				}
			}
		}

		$letters2 = [[' ','-'],[' ','.']];

		$arr = [];
		foreach ($letters2 as $value) {

			if (strstr($prase_explode[1], $value[0])) {
				if (strpos($prase_explode[1], $value[0]) !== FALSE) {
					$test = str_replace($value[0], $value[1], $prase_explode[1]);
					$args['meta_query'][] = array(
						'key' => 'company_name',
						'value' => str_replace($value[0], $value[1], $prase_explode[1]),
						'compare' => 'LIKE'
					);

				}
			}
		}
		//$result .= $test;


		$phrase_alter = transliterator_transliterate('Russian-Latin/BGN', $prase_explode[1]);
		//$result .= '<br />';
		//$result .= $phrase_alter;

	} else {
		//$result .= 'not_RU';
		$letters = [['h','х'],['tink','тиньк'],['tink','тиньк'],['black','блэк'],['a','э']];

		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase_explode[1], $value[0])) {
				if (strpos($prase_explode[1], $value[0]) !== FALSE) {

					$args['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase_explode[1])),
						'compare' => 'LIKE'
					);

				}
			}
		}
		$phrase_alter = transliterator_transliterate('Latin-Russian/BGN', $prase_explode[1]);
		//$result .= 'удалить8888888'.transliterator_transliterate('Latin-Russian/BGN', $prase_explode[1]);
		//print_r(transliterator_list_ids());
		//$result .= '<br />';
		//$result .= $phrase_alter;

	}
	/*} else {
		//$result .= 'удалить'.'test5';
		if(isRussian($prase)) {

			//$result .= 'RU';
			$letters = [['ай','i'],['кс','x'],['аль','al'],['с','c'],['тиньк','tink'],['блэк','black'],['э','a'],['гик],'geek;
,['брейнс
,'brains								$arr = [];
			foreach ($letters as $value) {

				if (strstr($prase, $value[0])) {
					if (strpos($prase, $value[0]) !== FALSE) {

						$args['meta_query'][] = array(
							'key' => 'company_name',
							'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase)),
							'compare' => 'LIKE'
						);

					}
				}
			}

			$letters2 = [[' ','-'],[' ','.']];

			$arr = [];
			foreach ($letters2 as $value) {

				if (strstr($prase, $value[0])) {
					if (strpos($prase, $value[0]) !== FALSE) {
						$test = str_replace($value[0], $value[1], $prase);
						$args['meta_query'][] = array(
							'key' => 'company_name',
							'value' => str_replace($value[0], $value[1], $prase),
							'compare' => 'LIKE'
						);

					}
				}
			}
			//$result .= $test;


			$phrase_alter = transliterator_transliterate('Russian-Latin/BGN', $prase);
			//$result .= '<br />';
			//$result .= $phrase_alter;

		} else {
			//$result .= 'not_RU';
			$letters = [['h','х'],['tink','тиньк'],['tink','тиньк'],['black','блэк'],['a','э']];

			$arr = [];
			foreach ($letters as $value) {

				if (strstr($prase, $value[0])) {
					if (strpos($prase, $value[0]) !== FALSE) {

						$args['meta_query'][] = array(
							'key' => 'company_name',
							'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase)),
							'compare' => 'LIKE'
						);

					}
				}
			}
			$phrase_alter = transliterator_transliterate('Latin-Russian/BGN', $prase);
			//$result .= 'удалить333'.transliterator_transliterate('Latin-Russian/BGN', $prase);
			//print_r(transliterator_list_ids());
			//$result .= '<br />';
			//$result .= $phrase_alter;

		}
	}*/

}
else {
	//$result .= 'удалить'.'test3';
	if(isRussian($prase)) {

		//$result .= 'RU';
		$letters = [['ай','i'],['кс','x'],['аль','al'],['с','c'],['тиньк','tink'],['блэк','black'],['э','a'],['гик','geek'],['брейн','brain'],['бреин','brain'],['гикбреин','geekbrain'],['гикбрейнс','geekbrain']];


		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase, $value[0])) {
				if (strpos($prase, $value[0]) !== FALSE) {

					$args['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Russian-Latin/BGN', str_replace($value[0], $value[1], $prase)),
						'compare' => 'LIKE'
					);

				}
			}
		}

		$letters2 = [[' ','-'],[' ','.']];

		$arr = [];
		foreach ($letters2 as $value) {

			if (strstr($prase, $value[0])) {
				if (strpos($prase, $value[0]) !== FALSE) {
					$test = str_replace($value[0], $value[1], $prase);
					$args['meta_query'][] = array(
						'key' => 'company_name',
						'value' => str_replace($value[0], $value[1], $prase),
						'compare' => 'LIKE'
					);

				}
			}
		}
		//$result .= $test;


		$phrase_alter = transliterator_transliterate('Russian-Latin/BGN', $prase);
		//$result .= '<br />';
		//$result .= $phrase_alter;

	} else {
		//$result .= 'not_RU';
		$letters = [['h','х'],['tink','тиньк'],['tink','тиньк'],['black','блэк'],['a','э']];

		$arr = [];
		foreach ($letters as $value) {

			if (strstr($prase, $value[0])) {
				if (strpos($prase, $value[0]) !== FALSE) {

					$args['meta_query'][] = array(
						'key' => 'company_name',
						'value' => transliterator_transliterate('Latin-Russian/BGN', str_replace($value[0], $value[1], $prase)),
						'compare' => 'LIKE'
					);

				}
			}
		}
		$phrase_alter = transliterator_transliterate('Latin-Russian/BGN', $prase);
		//$result .= 'удалить4444'.transliterator_transliterate('Latin-Russian/BGN', $prase);
		//print_r(transliterator_list_ids());
		//$result .= '<br />';
		//$result .= $phrase_alter;

	}
}

if($phrase_alter != '') {
	$args['meta_query'][] = array(
		'key' => 'company_name',
		'value' => $phrase_alter,
		'compare' => 'LIKE'
	);
}
if($prase != '') {
	$args['meta_query'][] = array(
		'key'     => 'company_name',
		'value'   => $prase,
		'compare' => 'LIKE'
	);
	$args['meta_query'][] = array(
		'key'		=> 'websites_$_site_url',
		'compare'	=> 'LIKE',
		'value'		=> $prase
	);
}



?>