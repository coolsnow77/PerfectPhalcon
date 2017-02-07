<?php
use Phalcon\Di\FactoryDefault;
use Dotenv\Dotenv;

/*
|--------------------------------------------------------------------------
| autoload
|--------------------------------------------------------------------------
|
| 此处是对phalcon框架的调用，使框架可以正常使用
|
|
*/

$di = new FactoryDefault();
/**
 * require composer autoload
 */
require_once BASE_PATH.'/vendor/autoload.php';

/**
 * Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically.
 */
(new Dotenv(BASE_PATH))->load();

/**
 * require helper
 */
require_once APP_PATH.'/helper.php';

/**
 * Read services
 */
include APP_PATH . "/config/services.php";

/**
 * Get config service for use in inline setup below
 */
$config = $di->getConfig();

/**
 * Include Autoloader
 */
include APP_PATH . '/config/loader.php';

/**
 * The FactoryDefault Dependency Injector automatically registers
 * the services that provide a full stack framework.
 */
return $di;