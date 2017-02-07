<?php
use App\Utils\Router;

/*
|--------------------------------------------------------------------------
| web 路由文件
|--------------------------------------------------------------------------
|
| 如添加中间件 可使用 Router::get("/test", "test::test")->middleware(['api']);
|
|
*/

Router::get("/", "index::index");
Router::get("/test", "index::test");