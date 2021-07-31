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
use Raylin666\Database\Config;
use Raylin666\Framework\Contract\DatabaseConfigInterface;
use Raylin666\Server\Contract\ServerInterface;
use Raylin666\Server\SwooleEvent;

/**
 * Class ValidatorServiceProvider
 * @package Raylin666\Framework\ServiceProvider
 */
class DatabaseServiceProvider implements ServiceProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return mixed|void
     */
    public function register(ContainerInterface $container)
    {
        // TODO: Implement register() method.

        $dbConfig = null;
        $config = $container->get(ConfigInterface::class)->get('database', []);
        foreach ($config as $name => $item) {
            $new = (new Config())
                ->setDriver($item['driver'])
                ->setName($name)
                ->setHost($item['host'])
                ->setPort($item['port'])
                ->setUsername($item['username'])
                ->setPassword($item['password'])
                ->setCharset($item['charset'])
                ->setCollation($item['collation'])
                ->setDbname($item['dbname'])
                ->setTablePrefix($item['prefix']);

            $options = [];
            if (isset($item['min_connections'])) $options['min_connections'] = $item['min_connections'];
            if (isset($item['max_connections'])) $options['max_connections'] = $item['max_connections'];
            if (isset($item['connect_timeout'])) $options['connect_timeout'] = $item['connect_timeout'];
            if (isset($item['wait_timeout'])) $options['wait_timeout'] = $item['wait_timeout'];
            if (isset($item['heartbeat'])) $options['heartbeat'] = $item['heartbeat'];
            if (isset($item['max_idle_time'])) $options['max_idle_time'] = $item['max_idle_time'];
            if ($options) {
                $new->setOptions($options);
            }

            $dbConfig[$name] = $new;
        }

        $container->bind(DatabaseConfigInterface::class, function () use ($dbConfig) {
            return $dbConfig;
        });
    }
}