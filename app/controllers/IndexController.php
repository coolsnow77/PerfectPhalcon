<?php

class IndexController extends ControllerBase
{
    public function indexAction()
    {
        dd(\Users::_columns('id,name,sex')->_find());
        dd(\Users::_find());
        $this->view->pick('index/index');
    }

    public function testAction()
    {
        echo 'test';
    }
}

