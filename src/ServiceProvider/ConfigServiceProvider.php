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
use Raylin666\Config\Config;
use Raylin666\Contract\ConfigInterface;
use Raylin666\Contract\ServiceProviderInterface;
use Raylin666\Framework\Application;
use Raylin666\Framework\Contract\ApplicationInterface;

/**
 * Class ConfigServiceProvider
 * @package Raylin666\Framework\ServiceProvider
 */
class ConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return mixed|void
     */
    public function register(ContainerInterface $container)
    {
        // TODO: Implement register() method.

        /** @var ApplicationInterface|Application $app */
        $app = $container->get(ApplicationInterface::class);

        /** @var ConfigInterface|Config $config */
        $config = $container->get(ConfigInterface::class);
        $configArray = $config->make($app->getConfigOptions());
        // 配置合并
        $configMerge = array_merge($config->toArray(), $configArray);

        $config($configMerge);

        // 重新绑定配置
        $container->bind(ConfigInterface::class, function () use ($config) {
            return $config;
        });
    }
}