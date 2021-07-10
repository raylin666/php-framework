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

namespace Raylin666\Framework\Helper;

use Exception;
use Raylin666\Framework\Contract\ServerStateInterface;

/**
 * Class ServerStateHelper
 * @package Raylin666\Framework\Helper
 */
class ServerStateHelper implements ServerStateInterface
{
    /**
     * 服务状态类型
     */
    const SERVER_TYPE_STATUS = 'status';
    const SERVER_TYPE_START = 'start';
    const SERVER_TYPE_STOP = 'stop';
    const SERVER_TYPE_RELOAD = 'reload';

    /**
     * 服务状态类型集合
     */
    const SERVER_TYPES = [
        self::SERVER_TYPE_STATUS,
        self::SERVER_TYPE_START,
        self::SERVER_TYPE_RELOAD,
        self::SERVER_TYPE_STOP,
    ];

    /**
     * 服务状态类型
     * @var string
     */
    protected $serverStatusType = self::SERVER_TYPE_STATUS;

    /**
     * 是否守护进程模式
     * @var bool
     */
    protected $isDaemon = false;

    /**
     * 获取服务状态类型
     * @return string
     */
    public function getServerStatusType(): string
    {
        // TODO: Implement getServerStatusType() method.

        return $this->serverStatusType;
    }

    /**
     * 是否守护进程模式
     * @return bool
     */
    public function isDaemon(): bool
    {
        // TODO: Implement isDaemon() method.

        return $this->isDaemon;
    }

    /**
     * 设置服务状态类型
     * @param string $serverStatusType
     * @return self
     */
    public function withServerStatusType(string $serverStatusType): self
    {
        // TODO: Implement withServerStatusType() method.

        $serverStatusType = strtolower($serverStatusType);
        if (! in_array($serverStatusType, self::SERVER_TYPES)) {
            throw new Exception(
                sprintf(
                    '%s 服务状态类型未定义，请输入合法的服务状态类型 %s',
                    $serverStatusType,
                    implode(' | ', self::SERVER_TYPES)
                )
            );
        }

        $this->serverStatusType = $serverStatusType;
        return $this;
    }

    /**
     * 设置守护进程模式
     * @param bool $isDaemon
     * @return self
     */
    public function withDaemon(bool $isDaemon): self
    {
        // TODO: Implement withDaemon() method.

        $this->isDaemon = $isDaemon;
        return $this;
    }
}