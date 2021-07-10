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

namespace Raylin666\Framework\Command;

use Raylin666\Framework\Contract\EnvironmentInterface;
use Raylin666\Server\Contract\ServerInterface;
use Raylin666\Server\ServerConfig;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class HttpServerCommand
 * @package Raylin666\Framework\Command
 */
class HttpServerCommand extends ServerCommand
{
    /**
     * @var string
     */
    protected static $name = 'server:http';

    /**
     * @var string
     */
    protected static $description = '创建一个 Swoole Http 服务';

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ServerInterface $server */
        $server = $this->container->get(ServerInterface::class);

        $this->setServerStatusType($input);
        $this->isDaemon($input);

        // 初始化服务配置
        $server->init(new ServerConfig($this->config->get('server')));

        $server->start();
    }
}