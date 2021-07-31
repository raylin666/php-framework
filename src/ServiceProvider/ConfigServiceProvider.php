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

namespace Raylin666\Framework\ServiceProvider;

use Psr\Container\ContainerInterface;
use Raylin666\Config\Config;
use Raylin666\Contract\ConfigInterface;
use Raylin666\Contract\ServiceProviderInterface;
use Raylin666\Framework\Application;
use Raylin666\Framework\Contract\ApplicationInterface;
use Symfony\Component\Yaml\Yaml;

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

        // 配置合并
        $configMakeMerge = function () use ($app, $config) {
            return array_merge($config->toArray(), $config->make($app->getConfigOptions()));
        };

        // 合并 env.yml 文件配置内容
        $configYmlMerge = function (array $configMerge) {
            $yamlFile = $configMerge['yml_config_file'] ?? app()->path() . '/.env.yml';
            if (file_exists($yamlFile)) {
                $yamlConfig = Yaml::parseFile($yamlFile);
                if (is_array($yamlConfig)) {
                    $configMerge = $yamlConfig + $configMerge;
                }
            }

            return $configMerge;
        };

        // 循环覆盖配置, 解决配置想函数调用静态化问题
        for ($i = 0; $i < 2; $i++) {
            $config($configYmlMerge($configMakeMerge()));
        }

        // 重新绑定配置
        $container->singleton(ConfigInterface::class, function () use ($config) {
            return $config;
        });
    }
}