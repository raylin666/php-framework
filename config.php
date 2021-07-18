<?php
// +----------------------------------------------------------------------
// | Created by linshan. 版权所有 @
// +----------------------------------------------------------------------
// | Copyright (c) 2021 All rights reserved.
// +----------------------------------------------------------------------
// | Technology changes the world . Accumulation makes people grow .
// +----------------------------------------------------------------------
// | Author: kaka梦很美 <1099013371@qq.com>
// +----------------------------------------------------------------------

use Monolog\DateTimeImmutable;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Raylin666\Logger\Logger;
use Raylin666\Server\SwooleEvent;
use Raylin666\Server\Contract\ServerInterface;
use Raylin666\Framework\ServiceProvider\LoggerServiceProvider;
use Raylin666\Framework\ServiceProvider\RouterServiceProvider;
use Raylin666\Framework\ServiceProvider\ServerServiceProvider;
use Raylin666\Framework\ServiceProvider\ConsoleServiceProvider;
use Raylin666\Framework\ServiceProvider\EventListenerServiceProvider;
use Raylin666\Framework\ServiceProvider\ValidatorServiceProvider;
use Raylin666\Framework\Command\ServerCommand;
use Raylin666\Server\Callbacks\OnRequest;

return [
    /**
     * 应用名称
     */
    'name' => 'raylin',

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
        ConsoleServiceProvider::class,
        RouterServiceProvider::class,
        ServerServiceProvider::class,
        LoggerServiceProvider::class,
        EventListenerServiceProvider::class,
        ValidatorServiceProvider::class,
    ],

    /**
     * 控制台命令
     */
    'commands' => [
        'server' => [
            'name' => ServerCommand::class,
        ],
    ],

    /**
     * 路由服务
     */
    'router' => [
        'namespace' => '\\App\\Http\\Controllers\\',
        'files' => [],
    ],

    /**
     * 中间件服务
     */
    'middlewares' => [],

    /**
     * 数据验证
     */
    'validator' => [
        // 语言包存放目录路径
        'lang_path' => __DIR__ . '/lang',
        // 所使用的语言包
        'lang' => 'zh',
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
    ],

    /**
     * 应用服务
     */
    'server' => [
        'mode' => SWOOLE_PROCESS,
        'servers' => [
            [
                'name' => 'http',
                'type' => ServerInterface::SERVER_HTTP,
                'host' => '0.0.0.0',
                'port' => 9901,
                'sock_type' => SWOOLE_SOCK_TCP,
                'callbacks' => [
                    SwooleEvent::ON_REQUEST => OnRequest::class
                ],
            ],
        ],
        'settings' => [
            'enable_coroutine' => true,
            'worker_num' => swoole_cpu_num(),
            'pid_file' => 'runtime/server.pid',
            'log_level' => SWOOLE_LOG_INFO,
            'open_tcp_nodelay' => true,
            'max_coroutine' => 100000,
            'open_http2_protocol' => true,
            'max_request' => 100000,
            'socket_buffer_size' => 2 * 1024 * 1024,
            'buffer_output_size' => 2 * 1024 * 1024,
            'daemonize' => false,
        ],
        'callbacks' => [],
    ],
];