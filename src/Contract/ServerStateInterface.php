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
 * Interface ServerStateInterface
 * @package Raylin666\Framework\Contract
 */
interface ServerStateInterface
{
    /**
     * 获取服务状态类型
     * @return string
     */
    public function getServerStatusType(): string;

    /**
     * 是否守护进程模式
     * @return bool
     */
    public function isDaemon(): bool;

    /**
     * 设置服务状态类型
     * @param string $serverStatusType
     * @return mixed
     */
    public function withServerStatusType(string $serverStatusType);

    /**
     * 设置守护进程模式
     * @param bool $isDaemon
     * @return mixed
     */
    public function withDaemon(bool $isDaemon);
}