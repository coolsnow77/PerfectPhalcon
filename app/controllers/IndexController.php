<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        dd(session('abc'));
        dd(session()->get('aaa'));
        dd(session());
        dd($this->session);
    }

    public function testAction()
    {
        echo 111;
    }

    public function test2Action()
    {
        echo 222;
    }

    public function test3Action()
    {
        echo 333;
    }
}

