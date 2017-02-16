<?php
namespace App\Middleware;

class Csrf implements Middleware
{
    private static $_token;

    public function __construct()
    {
        self::$_token = request()->get('_token') ?: (request()->getHeader('X-CSRF-TOKEN') ?: cookies('X-CSRF-TOKEN')->getValue());
    }

    public function handle($request)
    {
        if ($request->isPost() || $request->isPut()) {
            if ((decrypt(self::$_token) != csrf_token()) || !self::$_token) {

                header('HTTP/1.1 500 Internal Server Error');

                throw new \Exception("csrf验证失败, 请刷新后重试!");
            }
        }
    }
}