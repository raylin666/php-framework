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

use RuntimeException;
use Raylin666\Http\Response;

/**
 * Class HttpException
 * @package Raylin666\Framework\Exception
 */
class HttpException extends RuntimeException
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * HttpException constructor.
     * @param int  $statusCode
     * @param string $message
     */
    public function __construct(int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR, $message = '')
    {
        $this->statusCode = $statusCode;
        if (empty($message) && isset(Response::$statusTexts[$statusCode])) {
            $message = Response::$statusTexts[$statusCode];
        }

        parent::__construct($message);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}