<?php
define( 'WP_CACHE', false ); // Added by WP Rocket

define( 'WP_REDIS_MAXTTL', '43200' );
define( 'WP_REDIS_SELECTIVE_FLUSH', true );
define( 'WP_CACHE_KEY_SALT', 'beta2.eto-razvod.ru' );
define( 'WP_REDIS_IGBINARY', true );
define( 'WP_REDIS_HOST', '127.0.0.1' );
define( 'WP_REDIS_PORT', '6379' );
define( 'WP_REDIS_DATABASE', 1 );


$REQUEST_URI = $_SERVER['REQUEST_URI'];
$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];

//if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
//    header('Location: https://' . substr($_SERVER['HTTP_HOST'], 4).$_SERVER['REQUEST_URI']);
//    exit;
//}


/*function BadSocTraf() {
// список рефереров которым показывать антибота:
return preg_match("/(vk.com|ok.ru|facebook.com|instagram.com)/i", @$_SERVER['HTTP_REFERER']);
}
$sss_pages = array('/review/gemini/','/review/binance/','/review/exmo/','/review/gram/','/review/hitbtc/','/review/future-cryptomining/','/review/stormgain/','/review/shapeshift/','/review/buy-bitcoin/','/review/c-cex/','/review/wirexapp/','/review/poloniex/','/review/paxful/','/review/yobit/','/review/revenuebot/','/review/cex-io/','/review/mercatox/','/review/iqmining/','/review/etoro/','/trade-cryptocurrency/','/stock-exchange/','/cryptocurrency-make-money/','/true-about-cryptocurrency/','/review/bittrex/','/review/coinbase/','/review/3commas/','/review/kraken/');
if(in_array($_SERVER['REQUEST_URI'],$sss_pages)) {

// в итоге антибот будет покзываться только трафу с плохим реферером, а также закладочному трафику:
if (BadSocTraf() OR @trim($_SERVER['HTTP_REFERER']) == '' OR isset($_COOKIE['lastcid']) OR isset($_POST['antibot'])) {
require_once($_SERVER['DOCUMENT_ROOT'].'/antibot/code/include.php');
}
}*/
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'beta2_beta2');//eto_prod2208


/** Имя пользователя MySQL */
define('DB_USER', 'beta2_beta2');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'mkJ4hye7JQZuY2X');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

define('DISABLE_WP_CRON', true);

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'f3~W0ogHEg+Y5x2-RDIF~?,,`Xoc2h0MWC^)D^I|hlZu8uh{AGycQ4(VPC>HVg)[');
define('SECURE_AUTH_KEY',  'cp/+.66h,N-mT?5`V0iL/lCmp(V@$C(eT|<,JCiR6;h+W8^7o?5Y4x-6uZP95$G*');
define('LOGGED_IN_KEY',    'goum(/6BX7uG-6|.1Adr~{vRq;UW(KXxipHkn$L+NN-cqbyrrS}w-_<&[G$?1kwM');
define('NONCE_KEY',        'Q=hv? tM-S(A3<4~]-ufR4)Lb0?!q8L5hJ10*$NV_m~~|m~|N/tqsi&&Y.dyj9k9');
define('AUTH_SALT',        '3O3N|?~dnO -qUnB+k9k( :_qz]m HPc#|aC0[he==pzfEdHhg-wb(u:TnBN%`g%');
define('SECURE_AUTH_SALT', 'OSVxzXXD){:V|T_0%RrRNCa P.EQtA-CpKS66!Jo,PWjEW!T+>P&;vW *ZrVy`Ff');
define('LOGGED_IN_SALT',   'W2XFc5fK+7$l6x+Awup#p+(IV0^&%!bL^Uso.<RKdW|=-[P+Js[v5mrdL~^kvvvr');
define('NONCE_SALT',       '!Dvl1rz]fUz:ozfmsqz,[k:BS.sR(m*>LM+PVtDq$<Lm%L~9DV#W,9:)Bs]|c-&;');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */

//ini_set('display_errors','Off');
//ini_set('error_reporting', E_ALL );
//define('WP_DEBUG', false);
//define('WP_DEBUG_DISPLAY', false);

//ini_set('error_log', dirname(__FILE__) . '/error_log.txt');

ini_set('error_reporting', error_reporting( E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED & ~E_USER_DEPRECATED ) );
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', true );

define ('WP_HOME', 'https://'.$_SERVER['HTTP_HOST']);
define ('WP_SITEURL', 'https://'.$_SERVER['HTTP_HOST']);

define( 'SAVEQUERIES', true );


define( 'WP_MEMORY_LIMIT', '1024M' );
define('WP_POST_REVISIONS', 2 );
/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Specify wordpress temp dir */
define('WP_TEMP_DIR', ABSPATH . 'wp-content/temp');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
