<?php
namespace App\Middleware\Validate;

use App\Middleware\Middleware;
class LoginValidate implements Middleware
{
    public function handle($request)
    {
        dd($request->get());
    }
}