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
use Raylin666\Contract\EventDispatcherInterface;
use Raylin666\Contract\ListenerProviderInterface;
use Raylin666\Contract\ServiceProviderInterface;
use Raylin666\EventDispatcher\Dispatcher;
use Raylin666\EventDispatcher\ListenerProvider;

/**
 * Class EventListenerServiceProvider
 * @package Raylin666\Framework\ServiceProvider
 */
class EventListenerServiceProvider implements ServiceProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return mixed|void
     */
    public function register(ContainerInterface $container)
    {
        // TODO: Implement register() method.

        $container->singleton(ListenerProviderInterface::class, function () {
            return new ListenerProvider;
        });

        $container->singleton(EventDispatcherInterface::class, function () use ($container) {
            $dispatcher = new Dispatcher;
            $dispatcher($container->get(ListenerProviderInterface::class));
            return $dispatcher;
        });
    }
}