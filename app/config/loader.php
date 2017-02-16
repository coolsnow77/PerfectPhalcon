<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
)->registerNamespaces(
    [
        'App\Utils' => APP_PATH . '/utils/',
        'App\Services' => APP_PATH . '/services/',
        'App\Middleware' => APP_PATH . '/middleware/',
        'App\Controllers' => APP_PATH . '/controllers/',
    ]
)->register();
