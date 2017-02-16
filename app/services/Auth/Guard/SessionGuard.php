<?php
namespace App\Services\Auth\Guard;

use App\Utils\Factory;
use App\Services\Auth\AuthInterface;
class SessionGuard implements AuthInterface
{
    public function check()
    {
        return !! Factory::session()->get($this->sessionAuthKey());
    }

    public function login()
    {

    }

    public function logout()
    {

    }

    public function user()
    {

    }

    private function sessionAuthKey()
    {
        return 'Auth_'.md5(self::class);
    }
}