<?php
namespace App\Services\Auth;

interface AuthInterface
{
    public function check();
    public function login();
    public function logout();
    public function user();
}