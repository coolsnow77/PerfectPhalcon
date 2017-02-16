<?php
use App\Utils\Request;
class IndexController extends ControllerBase
{
    public function indexAction()
    {
        $this->view->pick('index/index');
    }

    public function testAction()
    {
        echo 'test';
    }
}

