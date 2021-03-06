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

use Raylin666\Framework\Application;
use Raylin666\Contract\ConfigInterface;
use Raylin666\Framework\Contract\EnvironmentInterface;
use Raylin666\Logger\LoggerFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Raylin666\Router\RouterInterface;

if (! function_exists('app')) {
    /**
     * 获取应用
     * @return \Raylin666\Framework\Contract\ApplicationInterface|Application
     */
    function app()
    {
        return Application::app();
    }
}

if (! function_exists('container')) {
    /**
     * 获取容器
     * @return \Raylin666\Container\Container
     */
    function container()
    {
        return app()->container();
    }
}

if (! function_exists('config')) {
    /**
     * 获取配置
     * @return ConfigInterface
     */
    function config()
    {
        return container()->get(ConfigInterface::class);
    }
}

if (! function_exists('environment')) {
    /**
     * 获取环境
     * @return EnvironmentInterface
     */
    function environment()
    {
        return container()->get(EnvironmentInterface::class);
    }
}

if (! function_exists('logger')) {
    /**
     * 获取日志
     * @param null   $channel
     * @param string $group
     * @return \Raylin666\Contract\LoggerInterface|\Raylin666\Logger\Logger
     */
    function logger($channel = null, $group = 'default')
    {
        /** @var LoggerFactoryInterface $factory **/
        $factory = container()->get(LoggerFactoryInterface::class);
        $logger = $factory->get($group);
        return $channel ? $logger->withName($channel) : $logger;
    }
}

if (! function_exists('request')) {
    /**
     * 获取请求
     * @return RequestInterface|\Raylin666\Http\Request
     * @throws Exception
     */
    function request()
    {
        return container()->get(RequestInterface::class);
    }
}

if (! function_exists('response')) {
    /**
     * 获取响应
     * @return ResponseInterface|\Raylin666\Framework\Http\Response
     * @throws Exception
     */
    function response()
    {
        return container()->get(ResponseInterface::class);
    }
}

if (! function_exists('route')) {
    /**
     * 获取路由
     * @return mixed|object|\Raylin666\Router\RouteCollection
     * @throws Exception
     */
    function route()
    {
        return container()->get(RouterInterface::class);
    }
}