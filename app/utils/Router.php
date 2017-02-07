<?php

namespace App\Utils;

use \Phalcon\Mvc\Router as baseRouter;
class Router extends baseRouter
{
    static private $_instance;
    static private $_router;
    static private $_middleware;
    static private $_overallMiddleware = [
        'csrf',
        'checkForMaintenanceMode',
    ];

    /**
     * get middleware
     * @return mixed
     */
    static public function getMiddleware()
    {
        return self::$_middleware;
    }

    /**
     * load router
     */
    static public function load()
    {
        foreach(glob(APP_PATH.'/routes/*.php') as $router_file) {
            require_once $router_file;
        }
        self::$_middleware = require_once APP_PATH.'/config/middleware.php';
        self::getInstance()->removeExtraSlashes(true);
        return self::getInstance();
    }

    /**
     * add get router
     */
    static public function get()
    {
        self::$_router = self::getInstance()->addGet(...func_get_args());
        return self::getInstance();
    }

    /**
     * add post router
     */
    static public function post()
    {
        self::$_router = self::getInstance()->addPost(...func_get_args());
        return self::getInstance();
    }

    /**
     * add put router
     */
    static public function put()
    {
        self::$_router = self::getInstance()->addPut(...func_get_args());
        return self::getInstance();
    }

    /**
     * add delete router
     */
    static public function delete()
    {
        self::$_router = self::getInstance()->addDelete(...func_get_args());
        return self::getInstance();
    }

    /**
     * middleware
     * @param array $middleware
     * @return Router
     */
    public function middleware(array $middleware)
    {
        self::$_router->middleware = array_unique(array_merge(self::$_overallMiddleware,$middleware));
        return self::getInstance();
    }

    /**
     * get instance
     * @return Router
     */
    static private function getInstance()
    {
        self::$_instance or self::$_instance = new self(false);

        return self::$_instance;
    }
}
