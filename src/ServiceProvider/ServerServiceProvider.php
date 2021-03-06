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
use Raylin666\Contract\ServiceProviderInterface;
use Raylin666\Server\Contract\ServerInterface;
use Raylin666\Server\Contract\ServerManangerInterface;
use Raylin666\Server\Server;
use Raylin666\Server\ServerManager;

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

        $container->bind(ServerManangerInterface::class, function () {
            return ServerManager::class;
        });

        $container->singleton(ServerInterface::class, function () {
            return new Server();
        });
    }
}