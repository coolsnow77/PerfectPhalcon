<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Flash\Direct as Flash;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ]);

            return $volt;
        },
        '.phtml' => PhpEngine::class

    ]);

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $connection = new $class([
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ]);

    return $connection;
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    ini_set('session.gc_maxlifetime', env('SESSION_LIFETIME'));
    ini_set('session.cookie_lifetime', env('SESSION_LIFETIME'));
    ini_set('session.cookie_domain', env('SESSION_COOKIE_DOMAIN'));
    ini_set('session.cookie_httponly', env('SESSION_COOKIE_HTTP_ONLY'));
    session_name(env('SESSION_NAME'));
    session_set_cookie_params(env('SESSION_LIFETIME'));

    $driver = strtolower(env('SESSION_DRIVER','file'));
    if ($driver == 'redis') {
        $session = new Phalcon\Session\Adapter\Redis([
            'uniqueId'   => env('REDIS_UNIQUE_ID'),
            'host'       => env('REDIS_HOST'),
            'port'       => env('REDIS_PORT'),
            #'auth'       => env('REDIS_AUTH'),
            'persistent' => env('REDIS_PERSISTENT'),
            'lifetime'   => env('REDIS_LIFETIME'),
            'prefix'     => env('REDIS_PREFIX'),
            'index'      => env('REDIS_INDEX'),
        ]);
    }else{
        $session = new Phalcon\Session\Adapter\Files();
    }
    $session->isStarted() or $session->start();
    return $session;
});
/**
 * Register Route
 */
$di->setShared('router',function(){
    /**
     * load router
     */
    return App\Utils\Router::load();
});

/**
 * use crypt
 */
$di->setShared('crypt', function () {
    $crypt = new Phalcon\Crypt();
    $crypt->setKey(env('APP_KEY'));
    return $crypt;
});