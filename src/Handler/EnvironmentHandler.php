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

namespace Raylin666\Framework\Handler;

use Raylin666\Framework\Contract\EnvironmentInterface;

/**
 * Class EnvironmentHandler
 * @package Raylin666\Framework\Handler
 */
class EnvironmentHandler implements EnvironmentInterface
{
    /**
     * 当前环境
     * @var string
     */
    protected $value = EnvironmentInterface::ENVIRONMENT_DEV;

    /**
     * EnvironmentHandler constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * 获取环境名称
     * @return string
     */
    public function value(): string
    {
        // TODO: Implement value() method.

        return $this->value;
    }

    /**
     * 是否本地环境
     * @return bool
     */
    public function isLocal(): bool
    {
        // TODO: Implement isLocal() method.

        return $this->value == EnvironmentInterface::ENVIRONMENT_LOCAL;
    }

    /**
     * 是否测试环境
     * @return bool
     */
    public function isDev(): bool
    {
        // TODO: Implement isDev() method.

        return $this->value == EnvironmentInterface::ENVIRONMENT_DEV;
    }

    /**
     * 是否预发布环境
     * @return bool
     */
    public function isPre(): bool
    {
        // TODO: Implement isPre() method.

        return $this->value == EnvironmentInterface::ENVIRONMENT_PRE;
    }

    /**
     * 是否生产环境
     * @return bool
     */
    public function isProd(): bool
    {
        // TODO: Implement isProd() method.

        return $this->value == EnvironmentInterface::ENVIRONMENT_PROD;
    }
}