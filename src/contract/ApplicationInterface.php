<?php
// +----------------------------------------------------------------------
// | Created by linshan. 版权所有 @
// +----------------------------------------------------------------------
// | Copyright (c) 2019 All rights reserved.
// +----------------------------------------------------------------------
// | Technology changes the world . Accumulation makes people grow .
// +----------------------------------------------------------------------
// | Author: kaka梦很美 <1099013371@qq.com>
// +----------------------------------------------------------------------

namespace Raylin666\Framework\Contract;

use Raylin666\Container\Container;

/**
 * Interface ApplicationInterface
 * @package Raylin666\Framework\Contract
 */
interface ApplicationInterface
{
    /**
     * 应用名称
     * @return string
     */
    public function name(): string;

    /**
     * 获取版本
     * @return string
     */
    public function version(): string;

    /**
     * 获取容器
     * @return Container
     */
    public function container(): Container;

    /**
     * 应用启动
     * @return mixed
     */
    public function run();
}