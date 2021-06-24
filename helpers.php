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

use Raylin666\Framework\Application;
use Raylin666\Contract\ConfigInterface;

if (! function_exists('app')) {
    /**
     * 获取应用
     * @return \Raylin666\Framework\Contract\ApplicationInterface
     */
    function app()
    {
        return Application::app();
    }
}

if (! function_exists('container')) {
    /**
     * 获取容器
     * @return \Raylin666\Container\Container
     */
    function container()
    {
        return app()->container();
    }
}

if (! function_exists('config')) {
    /**
     * 获取配置
     * @return ConfigInterface
     */
    function config()
    {
        return app()->container()->get(ConfigInterface::class);
    }
}