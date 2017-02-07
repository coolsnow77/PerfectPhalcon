<?php

class ErrorController extends ControllerBase
{
    public function notFoundAction()
    {
        $this->view->pick('errors/404');
    }

    public function uncaughtExceptionAction()
    {
        $this->view->pick('errors/503');
    }
}