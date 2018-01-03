<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEW_PATH', ROOT . DS . 'views');

use Lib\App;
use Lib\Config;

require_once ROOT . DS . 'lib' . DS . 'init.php';

if (Config::get('production')) {
    ini_set("display_errors", 'Off');
}
if (Config::get('log_errors')) {
    ini_set("log_errors", 'On');
    ini_set("error_log", ROOT . DS . 'logs' . DS . 'log-' . date('Y-m-d') . '.log');
}

session_start();

try {
    App::run();
} catch (\Exception $ex) {
    if (Config::get('log_errors')) {
	error_log("Erro inesperado: {$ex->getMessage()}");
    }

    if (Config::get('production')) {
	// Geramos uma exceção para o servidor gerar um err 500.
	throw new Exception('');
    } else {
	echo "Erro inesperado: {$ex->getMessage()}";
    }
}

\Lib\DB::close();
