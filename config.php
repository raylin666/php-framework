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

use Monolog\DateTimeImmutable;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Raylin666\Logger\Logger;
use Raylin666\Framework\ServiceProvider\LoggerServiceProvider;

return [
    /**
     * 应用名称
     */
    'name' => 'raylin66 framework',

    /**
     * 应用版本
     */
    'version' => '1.0.0',

    /**
     * 应用时区
     */
    'timezone' => 'PRC',

    /**
     * 应用环境 local:本地环境 ｜ dev:测试环境 ｜ pre:预发布环境 ｜ prod:生产环境
     */
    'environment' => 'dev',

    /**
     * 错误级别
     */
    'error_reporting' => E_ALL,

    /**
     * 服务提供者
     */
    'providers' => [
        LoggerServiceProvider::class
    ],

    /**
     * 日志服务
     */
    'logger' => [
        'default' => [
            'handlers' => [
                [
                    'class'         =>  RotatingFileHandler::class,
                    'constructor'   => [
                        'filename'      =>  '',
                        'maxFiles'      =>  31,
                        'level'         =>  Logger::DEBUG,
                        'bubble'        =>  true,
                        'filePermission'=>  0666,
                        'useLocking'    =>  false,
                    ],
                ]
            ],
            'formatter' => [
                'class'         =>  LineFormatter::class,
                'constructor'   =>  [
                    'format'                        =>  "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
                    'dateFormat'                    =>  new DateTimeImmutable(true, new DateTimeZone(date_default_timezone_get() ?: 'PRC')),
                    'allowInlineLineBreaks'         => true,
                    'ignoreEmptyContextAndExtra'    => false,
                ]
            ],
        ],
    ]
];