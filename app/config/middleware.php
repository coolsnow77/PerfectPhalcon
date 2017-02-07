<?php

    /*
    |--------------------------------------------------------------------------
    | middleware config
    |--------------------------------------------------------------------------
    |
    | 此处是对middleware的配置，路由中调用中间件，框架会检查中间在时候在此注册
    |
    |
    */

return [
    'csrf' => App\Middleware\CsrfMiddleware::class,//csrf
    'checkForMaintenanceMode' => App\Middleware\CheckForMaintenanceMode::class,//检查维护模式
];