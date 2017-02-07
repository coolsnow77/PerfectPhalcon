<?php

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {
    $di = require_once BASE_PATH.'/bootstrap/autoload.php';
    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);
//dd($application->request->getURI());
    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
