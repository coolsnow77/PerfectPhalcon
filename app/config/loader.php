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
        'App\Middleware' => APP_PATH . '/middleware/',
    ]
)->register();
