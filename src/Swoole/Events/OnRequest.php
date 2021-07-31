<?php
// +----------------------------------------------------------------------
// | Created by linshan. 版权所有 @
// +----------------------------------------------------------------------
// | Copyright (c) 2021 All rights reserved.
// +----------------------------------------------------------------------
// | Technology changes the world . Accumulation makes people grow .
// +----------------------------------------------------------------------
// | Author: kaka梦很美 <1099013371@qq.com>
// +----------------------------------------------------------------------

namespace Raylin666\Framework\Swoole\Events;

use Raylin666\Http\SwooleServerRequest;
use Swoole\Http\Request;
use Swoole\Http\Response;

/**
 * Class OnRequest
 * @package Raylin666\Framework\Swoole\Events
 */
class OnRequest extends \Raylin666\Server\Callbacks\OnRequest
{
    /**
     * 转移 Swoole 请求对象
     * @param Request  $swooleRequest
     * @param Response $swooleResponse
     */
    public function OnRequest(Request $swooleRequest, Response $swooleResponse)
    {
        $request = SwooleServerRequest::createServerRequestFromSwoole($swooleRequest);
        $response = app()->handlerRequest($request);
        foreach ($response->getHeaders() as $key => $header) {
            $swooleResponse->header($key, $response->getHeaderLine($key));
        }
        foreach ($response->getCookieParams() as $key => $cookieParam) {
            $swooleResponse->cookie(
                $key,
                $cookieParam->getValue(),
                $cookieParam->getExpire(),
                $cookieParam->getPath(),
                $cookieParam->getDomain(),
                $cookieParam->isSecure(),
                $cookieParam->isHttpOnly()
            );
        }

        $swooleResponse->status($response->getStatusCode());
        $swooleResponse->end((string) $response->getBody());
    }
}