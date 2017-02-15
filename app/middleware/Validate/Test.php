<?php
namespace App\Middleware\Validate;
use App\Middleware\Middleware;
class Test implements Middleware
{
    public function handle($request)
    {
        dd('这里是验证');
    }
}