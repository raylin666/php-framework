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

/**
 * Interface EnvironmentInterface
 * @package Raylin666\Framework\Contract
 */
interface EnvironmentInterface
{
    /**
     * 本地环境
     */
    const ENVIRONMENT_LOCAL = 'local';

    /**
     * 测试环境
     */
    const ENVIRONMENT_DEV = 'dev';

    /**
     * 预发布环境
     */
    const ENVIRONMENT_PRE = 'pre';

    /**
     * 生产环境
     */
    const ENVIRONMENT_PROD = 'prod';

    /**
     * 获取环境名称
     * @return string
     */
    public function value(): string;

    /**
     * 是否本地环境
     * @return bool
     */
    public function isLocal(): bool;

    /**
     * 是否测试环境
     * @return bool
     */
    public function isDev(): bool;

    /**
     * 是否预发布环境
     * @return bool
     */
    public function isPre(): bool;

    /**
     * 是否生产环境
     * @return bool
     */
    public function isProd(): bool;
}