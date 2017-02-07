<?php

namespace App\Utils;

use Phalcon\Mvc\Controller;
class Factory extends Controller
{
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

    static private function getInstance()
    {
        self::$_instance or self::$_instance = new self;

        return self::$_instance;
    }
}
