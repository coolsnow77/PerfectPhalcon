<?php
use App\Utils\Request;
class IndexController extends ControllerBase
{
    public function indexAction()
    {
        dd(11);
        dd((new \Phalcon\Http\Request)->get());
        dump($this->request->get());
        $this->request->get('a','dg');
        dd($this->request->get());
        dd(\Users::_columns('id,name,sex')->_find());
        dd(\Users::_find());
        $this->view->pick('index/index');
    }

    public function testAction()
    {
        echo 'test';
    }
}

