<?php

namespace App\Utils;

class Response
{
    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    |
    | Response 响应
    |
    |
    */

    /**
     * redirect
     * @param string $uri
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    static public function redirect($uri = '/')
    {
        return Factory::response()->redirect($uri);
    }

    /**
     * json return
     * @param array $data
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    static public function jsonReturn($data = [])
    {
        Factory::response()->setContentType('application/json', 'UTF-8');
        Factory::view()->disable();
        Factory::response()->setJsonContent($data,JSON_UNESCAPED_UNICODE);
        return Factory::response()->send();
    }
}
