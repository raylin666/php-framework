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

use Exception;

/**
 * 抛出异常结果集
 * Interface ThrowExceptionInterface
 * @package Raylin666\Framework\Contract
 */
interface ThrowExceptionInterface
{
    /**
     * 返回异常的结果集
     * @param Exception $e
     * @return mixed
     */
    public static function getReturn(Exception $e);
}