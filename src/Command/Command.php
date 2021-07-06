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

use Raylin666\Contract\ConfigInterface;
use Raylin666\Contract\ContainerInterface;
use Raylin666\Framework\Contract\ApplicationInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

/**
 * Class Command
 * @package Raylin666\Framework\Command
 */
class Command extends SymfonyCommand
{
    /**
     * @var ApplicationInterface
     */
    protected $app;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * Script name
     * @var
     */
    protected static $name;

    /**
     * Script description
     * @var
     */
    protected static $description;

    /**
     * Console configure
     */
    protected function configure()
    {
        parent::configure(); // TODO: Change the autogenerated stub

        $this->app = app();
        $this->container = container();
        $this->config = config();

        /**
         * 设置命令属性
         */
        $this->setName(static::$name);
        $this->setDescription(static::$description);
    }
}