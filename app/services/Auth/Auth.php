<?php
namespace App\Services\Auth;

class Auth
{
    static public function guard($guard = 'session')
    {
        $guardClass = '\\App\\Services\\Auth\\Guard\\'.ucfirst(strtolower($guard)).'Guard';
        return new $guardClass;
    }
}