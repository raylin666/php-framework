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
use Raylin666\Server\Contract\ServerInterface;
use Raylin666\Server\Server;

/**
 * Class ServerServiceProvider
 * @package Raylin666\Framework\ServiceProvider
 */
class ServerServiceProvider implements ServiceProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return mixed|void
     */
    public function register(ContainerInterface $container)
    {
        // TODO: Implement register() method.

        $container->bind(ServerInterface::class, function () {
            return new Server();
        });
    }
}