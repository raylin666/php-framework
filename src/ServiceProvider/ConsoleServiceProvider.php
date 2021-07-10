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
use Raylin666\Framework\Command\Application;
use Raylin666\Framework\Contract\CommandInterface;

/**
 * Class ConsoleServiceProvider
 * @package Raylin666\Framework\ServiceProvider
 */
class ConsoleServiceProvider implements ServiceProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return mixed
     */
    public function register(ContainerInterface $container)
    {
        // TODO: Implement register() method.

        $application = new Application();

        // 添加控制台命令
        $commandsConfig = $container->get(ConfigInterface::class)->get('commands', []);
        foreach ($commandsConfig as $name => $command) {
            $application->add(new $command['name']($name));
        }

        $container->singleton(CommandInterface::class, function () use ($application) {
            return $application;
        });
    }
}