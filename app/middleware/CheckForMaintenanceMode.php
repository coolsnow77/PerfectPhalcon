<?php
namespace App\Middleware;

class CheckForMaintenanceMode implements Middleware
{
    public function handle($request)
    {
        if (env('APP_MAINTENANCE')) {
            exit("网站维护中!");
        }
        return true;
    }
}
