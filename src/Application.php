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

namespace Raylin666\Framework;

use Raylin666\Config\Config;
use Raylin666\Container\Container;
use Raylin666\Contract\ConfigInterface;
use Raylin666\Framework\Contract\ApplicationInterface;

/**
 * Class Application
 * @package Raylin666\Framework
 */
class Application implements ApplicationInterface
{
    /**
     * 项目根目录
     * @var
     */
    protected $path;

    /**
     * 容器
     * @var
     */
    protected $container;

    /**
     * Application constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;

        $this->container = new Container();
        // 绑定应用
        $this->container->bind(ApplicationInterface::class, function () {
            return $this;
        });
        // 绑定配置
        $this->container->bind(ConfigInterface::class, function () {
            $config = new Config();
            $config(require sprintf('%s/config.php', dirname(__DIR__)));
            return $config;
        });
    }

    /**
     * 获取项目根目录
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * 应用名称
     * @return string
     */
    public function name(): string
    {
        // TODO: Implement name() method.

        return $this->container()->get(ConfigInterface::class)->get('name');
    }

    /**
     * 获取版本
     * @return string
     */
    public function version(): string
    {
        // TODO: Implement version() method.

        return $this->container()->get(ConfigInterface::class)->get('version');
    }

    /**
     * 获取容器
     * @return Container
     */
    public function container(): Container
    {
        // TODO: Implement container() method.

        return $this->container;
    }

    /**
     * 应用启动
     * @return mixed|void
     */
    public function run()
    {
        // TODO: Implement run() method.
    }
}