<?php

namespace App\Utils;

use Phalcon\Mvc\Controller;
class Factory extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Factory
    |--------------------------------------------------------------------------
    |
    | 此类便于获取di中的对象，方便操作
    |
    */
    static $_instance;

    static public function session()
    {
        return self::getInstance()->session;
    }

    static public function request()
    {
        return self::getInstance()->request;
    }

    static public function cookies()
    {
        return self::getInstance()->cookies;
    }

    static public function config()
    {
        return self::getInstance()->config;
    }

    static public function crypt()
    {
        return self::getInstance()->crypt;
    }

    static public function response()
    {
        return self::getInstance()->response;
    }

    static public function view()
    {
        return self::getInstance()->view;
    }

    static private function getInstance()
    {
        self::$_instance or self::$_instance = new self;

        return self::$_instance;
    }
}
