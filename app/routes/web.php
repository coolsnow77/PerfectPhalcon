<?php
use App\Utils\Router;

Router::get("/", "index::index");
Router::get("/test", "index::test");
Router::get("/test2", "index::test2")->middleware(['csrf']);
Router::post("/test3", "index::test3")->middleware(['csrf']);