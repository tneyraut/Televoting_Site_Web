<?php

if($_SERVER['SERVER_NAME'] == 'localhost') {
    error_reporting(E_ALL);
}
else {
    error_reporting(0);
}

$rootDirectoryPath = realpath(dirname(__FILE__));
define('__ROOT_DIR__', $rootDirectoryPath);

$base_url = explode('/', $_SERVER['PHP_SELF']);
array_pop($base_url);
define('__BASE_URL__', implode('/', $base_url));

require_once(__ROOT_DIR__ . '/config/config.php');
require_once(__ROOT_DIR__ . '/classes/Autoloader.class.php');

$request = Request::getCurrentRequest();

try
{
    $controller = Dispatcher::dispatch($request);
    $controller->execute();
}
catch(Exception $e)
{
    echo 'Error : ' . $e->getMessage() . "\n";
}

