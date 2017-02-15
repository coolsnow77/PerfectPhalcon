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
            if ((decrypt(self::$_token) != $this->getCsrfToken()) || !self::$_token) {

                header('HTTP/1.1 500 Internal Server Error');

                throw new \Exception("csrf验证失败, 请刷新后重试!");
            }
        }
    }

    private function getCsrfToken()
    {
        if (!session()->has('_token')) {
            session(['_token',str_random(40)]);
        }

        return session('_token');
    }
}