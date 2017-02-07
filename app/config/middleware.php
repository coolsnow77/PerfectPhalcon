<?php
return [
    'csrf' => App\Middleware\CsrfMiddleware::class,//csrf
    'checkForMaintenanceMode' => App\Middleware\CheckForMaintenanceMode::class,//检查维护模式
];