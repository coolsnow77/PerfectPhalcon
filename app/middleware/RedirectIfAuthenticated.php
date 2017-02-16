<?php
namespace App\Middleware;

use App\Services\Auth\Auth;
use App\Utils\Response;
class RedirectIfAuthenticated implements Middleware
{
    protected $except = [
        '/error/notFound',
        '/error/uncaughtException',
        '/login',
    ];

    public function handle($request)
    {
        $uri = $request->getUri();
        if (! in_array($uri,$this->except)) {
            if(! Auth::guard()->check()) {
                Response::redirect('/login');
                return false;
            }
        }
    }
}
