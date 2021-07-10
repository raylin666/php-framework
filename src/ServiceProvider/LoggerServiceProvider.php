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
use Raylin666\Logger\LoggerFactory;
use Raylin666\Logger\LoggerFactoryInterface;
use Raylin666\Logger\LoggerOptions;

/**
 * Class LoggerServiceProvider
 * @package Raylin666\Framework\ServiceProvider
 */
class LoggerServiceProvider implements ServiceProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return mixed|void
     */
    public function register(ContainerInterface $container)
    {
        // TODO: Implement register() method.

        $loggerConfig = $container->get(ConfigInterface::class)->get('logger');
        $loggerFactory = new LoggerFactory();
        foreach ($loggerConfig as $group => $item) {
            $loggerOption = new LoggerOptions($group, $item['handlers'] ?? [], $item['formatter'] ?? []);
            $loggerFactory->make($loggerOption);
        }

        // 绑定日志工厂
        $container->singleton(LoggerFactoryInterface::class, function () use ($loggerFactory) {
            return $loggerFactory;
        });
    }
}