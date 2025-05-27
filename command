<?php

// current directory
define('_BASEDIR_', getcwd() . '/');

// Path to the application folder
define('_SYSDIR_', _BASEDIR_ . 'app/');

include_once (_SYSDIR_ . 'system/inc/console/Command.php');

try {
    new Command();
} catch (Exception $e) {
    echo $e->getMessage();
}
