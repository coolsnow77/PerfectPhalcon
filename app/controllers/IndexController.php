<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->pick('index/index');
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

