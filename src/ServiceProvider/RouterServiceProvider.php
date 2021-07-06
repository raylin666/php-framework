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

namespace Raylin666\Framework\ServiceProvider;

use Psr\Container\ContainerInterface;
use Raylin666\Contract\ConfigInterface;
use Raylin666\Contract\ServiceProviderInterface;
use Raylin666\Router\RouteCollection;
use Raylin666\Router\RouteDispatcher;
use Raylin666\Router\RouterDispatcherInterface;
use Raylin666\Router\RouterInterface;

/**
 * Class RouterServiceProvider
 * @package Raylin666\Framework\ServiceProvider
 */
class RouterServiceProvider implements ServiceProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return mixed|void
     */
    public function register(ContainerInterface $container)
    {
        // TODO: Implement register() method.

        /** @var ConfigInterface $config */
        $config = $container->get(ConfigInterface::class);

        $router = new RouteCollection($config->get('router.namespace'));
        $routerDispatcher = new RouteDispatcher($router, $config->get('middlewares'));

        // 注册路由
        $container->bind(RouterInterface::class, function () use ($router) {
            return $router;
        });

        // 注册路由分发器
        $container->bind(RouterDispatcherInterface::class, function () use ($routerDispatcher) {
           return $routerDispatcher;
        });

        // 加载路由
        $router->group(['prefix' => ''], function () use ($config) {
            foreach ($config->get('router.files') as $routerFile) {
                include $routerFile;
            }
        });
    }
}