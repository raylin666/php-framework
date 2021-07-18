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
use Raylin666\Framework\Contract\ValidationInterface;
use Raylin666\Framework\Handler\ValidationHandler;

/**
 * Class ValidatorServiceProvider
 * @package Raylin666\Framework\ServiceProvider
 */
class ValidatorServiceProvider implements ServiceProviderInterface
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

        $container->singleton(ValidationInterface::class, function () use ($config) {
            $validator = new ValidationHandler();
            return $validator->boot(
                $config->get('validator.lang_path'),
                $config->get('validator.lang')
            );
        });
    }
}