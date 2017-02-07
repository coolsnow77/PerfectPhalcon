<?php
use App\Utils\Router;
use App\Middleware\Middleware;
trait ControllerPerfect
{
    /**
     * before execute route
     * @author shizhice <shizhice@gmial.com>
     * @return mixed
     */
    final public function beforeExecuteRoute()
    {
        // 获取当前匹配上的路由
        $matchedRouter = $this->router->getMatchedRoute();
        // 获取路由中间件配置
        $middleware = Router::getMiddleware();

        //判断当前路由是否绑定中间件
        if (isset($matchedRouter->middleware)) {
            //遍历当前路由所有中间件
            foreach ($matchedRouter->middleware as $middle) {
                //验证当前中间件是否已经注册
                if (!isset($middleware[$middle])) {
                    throw new \Exception("\"$middle\"中间件不存在");
                }
                $currentMiddleware = new $middleware[$middle];
                if (!$currentMiddleware instanceof Middleware) {
                    throw new \Exception("[{$middleware[$middle]}]没有实现接口[App\\Middleware\\Middleware]");
                }
                //执行中间件，如返回值为false,则终止后续操作
                if ($currentMiddleware->handle($this->request) === false) {
                    return false;
                }
            }
        }

        // 判断是否存在自定义中间件，如果有调用
        if (method_exists($this,'_beforeExecuteRoute')) {
            if ($this->_beforeExecuteRoute($this->dispatcher) === false) {
                return false;
            }
        }
        return true;
    }
}