<?php

error_reporting(E_ALL);

if (version_compare(PHP_VERSION,'7.0.0','<')) die('require PHP > 7');

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

$di = require_once BASE_PATH.'/bootstrap/autoload.php';
/**
 * Handle the request
 */
$application = new \Phalcon\Mvc\Application($di);

if (env('debug') === true) {
    (new \Phalcon\Debug)->listen();
    echo $application->handle()->getContent();
}else{
    try{
        echo $application->handle()->getContent();
    }catch (\Exception $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/error/uncaughtException');
    }catch (\Error $e){
        header('HTTP/1.1 500 Internal Server Error');
        echo file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/error/uncaughtException');
    }
}