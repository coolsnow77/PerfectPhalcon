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
    'overallMiddleware' => [
        App\Middleware\Csrf::class,//csrf认证
        App\Middleware\CheckForMaintenanceMode::class,//检查维护模式
        App\Middleware\RedirectIfAuthenticated::class,//没有登录跳转到登录页
    ],
    'routeMiddleware' => [
        'csrf' => App\Middleware\Csrf::class,//csrf
        'checkForMaintenanceMode' => App\Middleware\CheckForMaintenanceMode::class,//检查维护模式
    ],
    'validate' => [
        'test' => App\Middleware\Validate\Test::class,
        'login' => App\Middleware\Validate\LoginValidate::class,
    ],
];
