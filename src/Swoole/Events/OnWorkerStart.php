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

namespace Raylin666\Framework\Swoole\Events;

use Raylin666\Database\Config;
use Raylin666\Database\Connection;
use Raylin666\Database\DB;
use Raylin666\Database\PDO;
use Raylin666\Database\Pool\DatabasePool;
use Raylin666\Framework\Contract\DatabaseConfigInterface;
use Raylin666\Pool\PoolConfig;
use Swoole\Server;

/**
 * Class OnWorkerStart
 * @package Raylin666\Framework\Swoole\Events
 */
class OnWorkerStart extends \Raylin666\Server\Callbacks\OnWorkerStart
{
    /**
     * 数据库链接
     * @param Server $server
     * @param int    $workerId
     * @throws \Exception
     */
    public function DatabaseConnection(Server $server, int $workerId)
    {
        if (! container()->has(DatabaseConfigInterface::class)) return;

        $dbConfig = container()->get(DatabaseConfigInterface::class);
        /** @var Config $config */
        foreach ($dbConfig as $config) {
            $callback = function () use ($config) {
                return (new Connection(new PDO($config)))();
            };

            $options = [];
            if (isset($config->getOptions()['min_connections'])) $options['min_connections'] = $config->getOptions()['min_connections'];
            if (isset($config->getOptions()['max_connections'])) $options['max_connections'] = $config->getOptions()['max_connections'];
            if (isset($config->getOptions()['connect_timeout'])) $options['connect_timeout'] = $config->getOptions()['connect_timeout'];
            if (isset($config->getOptions()['wait_timeout'])) $options['wait_timeout'] = $config->getOptions()['wait_timeout'];
            if (isset($config->getOptions()['heartbeat'])) $options['heartbeat'] = $config->getOptions()['heartbeat'];
            if (isset($config->getOptions()['max_idle_time'])) $options['max_idle_time'] = $config->getOptions()['max_idle_time'];

            $pool = new DatabasePool(
                new PoolConfig(
                    $config->getName(),
                    $callback,
                    $options
                )
            );

            DB::setDatabasePool($config->getName(), $pool);
        }
    }
}