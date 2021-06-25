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
 * 用于接口响应错误
 * Class ResponseException
 * @package Raylin666\Framework\Exception
 */
class ResponseException implements ThrowExceptionInterface
{
    /**
     * @param Exception $e
     * @return array|mixed
     */
    public static function getReturn(Exception $e)
    {
        // TODO: Implement getReturn() method.

        return environment()->isPre() || environment()->isProd()
            ? DebugLogsException::getReturn($e)
            : null;
    }
}