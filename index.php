<?php
ini_set('session.gc_maxlifetime', 172800);
ini_set('session.cookie_lifetime', 172800);

define('_START_MEMORY_', memory_get_usage());
define('_START_TIME_', microtime(1));

/**
 * APP URL's
 */
//get current link
$currentLink = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

//Live url
define('PROD_URL', 'https://gitflow.com/');
//Dev url
define('DEV_URL', 'https://bolddev7.co.uk/gitflow/');
//Local url
define('LOC_URL', 'http://gitflow.loc/');

/**
 * The main path constants
 */
// DIR
define('_DIR_', '/'  . (strpos($currentLink, DEV_URL) !== false ? 'example/': '')); // NEED TO REPLACE! ex: '/example/'

// Path to the application folder
define('_BASEPATH_', rtrim($_SERVER['DOCUMENT_ROOT'], '/') . _DIR_);

// The name of THIS file
define('_SELF_', pathinfo(__FILE__, PATHINFO_BASENAME));

// Path to the front controller (this file in filesystem)
define('_FCPATH_', str_replace(_SELF_, '', __FILE__));

// Path to the application folder
define('_SYSDIR_', _BASEPATH_ . 'app/');

// Path to the styles folder
define('_SITEDIR_', _DIR_ . 'app/');

// URI
define('_URI_', mb_substr($_SERVER['REQUEST_URI'], mb_strlen(_DIR_) - 1));

/**
 * LOAD SYSTEM
 */

$config = 'Config_loc.php';
if (strpos($currentLink, PROD_URL) !== false) {
    $config = 'Config_live.php';
} elseif (strpos($currentLink, DEV_URL) !== false) {
    $config = 'Config.php';
}

include_once(_SYSDIR_ . 'system/' . $config);

if ($_SERVER['SCRIPT_FILENAME'] == _BASEPATH_ . 'index.php') {
    include_once(_SYSDIR_ . 'system/Core.php');
    $core = new Core;
}

/* End of file */