<?php
namespace App\Controllers\Auth;

use ControllerBase;
class LoginController extends ControllerBase
{
    public function showLoginFormAction()
    {
        $this->view->pick('auth/login');
    }
    public function loginAction()
    {
        dd('login action');
    }
}