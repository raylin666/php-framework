<?php
// +----------------------------------------------------------------------
// | Created by linshan. 版权所有 @
// +----------------------------------------------------------------------
// | Copyright (c) 2020 All rights reserved.
// +----------------------------------------------------------------------
// | Technology changes the world . Accumulation makes people grow .
// +----------------------------------------------------------------------
// | Author: kaka梦很美 <1099013371@qq.com>
// +----------------------------------------------------------------------

namespace Raylin666\Framework\Http;

use Psr\Http\Message\RequestInterface;
use Raylin666\Http\Response as HttpResponse;

/**
 * Class Response
 * @package Raylin666\Framework\Http
 */
class Response extends HttpResponse
{
    /**
     * 请求时间
     */
    protected $requestTime;

    /**
     * 响应总时长
     */
    protected $responseTotalTime;

    /**
     * @return mixed
     */
    public function getRequestTime()
    {
        return $this->requestTime;
    }

    /**
     * @return mixed
     */
    public function getResponseTotalTime()
    {
        return $this->responseTotalTime;
    }

    /**
     * RESTful API Json Response
     * @param null  $data
     * @param int   $status
     * @param array $headers
     * @return \Raylin666\Http\Message\Response|HttpResponse
     * @throws \Exception
     */
    public function RESTfulAPI($data = null, $status = Response::HTTP_OK, array $headers = [])
    {
        $status = intval($status);
        /** @var \Raylin666\Http\Request $request */
        if (container()->has(RequestInterface::class)) {
            $request = container()->get(RequestInterface::class);
            $this->requestTime = isset($request->getServerParams()['REQUEST_TIME_FLOAT']) ? $request->getServerParams()['REQUEST_TIME_FLOAT'] : 0;
        } else {
            $this->requestTime = isset($_SERVER['REQUEST_TIME_FLOAT']) ? $_SERVER['REQUEST_TIME_FLOAT'] : 0;
        }

        $this->responseTotalTime = microtime(true) - $this->requestTime;

        $message = Response::$statusTexts[$status] ?? '';
        $code = ($status < 100 || $status >= 600) ? Response::HTTP_OK : $status;
        return $this->toJson(
            [
                'code'    =>  $status,
                'message' =>  $message,
                'data'    =>  $data,
                'time'    =>  $this->responseTotalTime,
            ],
            $code,
            $headers
        );
    }
}