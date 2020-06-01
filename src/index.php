<?php

use app\components\Application;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

$env_array = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . '.env');
if ($env_array['PROJECT_DEBUG'] === true) {
    error_reporting(E_ALL);
} else {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED );
}

session_start();

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php');

$app = Application::getInstance($env_array);
try {
    $app->run();
} catch (Exception $e) {
    print_r($e->getMessage());
}