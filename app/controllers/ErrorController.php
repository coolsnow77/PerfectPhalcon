<?php

class ErrorController extends ControllerBase
{
    /*
    |--------------------------------------------------------------------------
    | error controller
    |--------------------------------------------------------------------------
    |
    | 异常 控制器
    |
    |
    */

    /**
     * not found
     */
    public function notFoundAction()
    {
        $this->view->pick('errors/404');
    }

    /**
     * uncaught exception
     */
    public function uncaughtExceptionAction()
    {
        $this->view->pick('errors/503');
    }
}