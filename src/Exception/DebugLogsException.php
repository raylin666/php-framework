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

namespace Raylin666\Framework\Exception;

use Exception;
use Raylin666\Framework\Contract\ThrowExceptionInterface;

/**
 * 用于错误记录（不作为接口响应）
 * Class DebugLogsException
 * @package Raylin666\Framework\Exception
 */
class DebugLogsException implements ThrowExceptionInterface
{
    /**
     * @param Exception $e
     * @return array|mixed
     */
    public static function getReturn(Exception $e)
    {
        // TODO: Implement getReturn() method.

        return [
            'message'   =>  $e->getMessage(),
            'code'      =>  $e->getCode(),
            'file'      =>  $e->getFile(),
            'line'      =>  $e->getLine(),
            'trace'     =>  explode("\n", $e->getTraceAsString()),
        ];
    }
}