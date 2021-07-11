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

namespace Raylin666\Framework\Command;

use Exception;
use Raylin666\Framework\Helper\SwooleHelper;
use Raylin666\Server\ServerConfig;
use swoole_process;

/**
 * Class HttpServerCommand
 * @package Raylin666\Framework\Command
 */
class HttpServerCommand extends ServerCommand
{
    /**
     * @var string
     */
    protected static $name = 'server:http';

    /**
     * @var string
     */
    protected static $description = '创建一个 Swoole Http 服务';

    /**
     * 获取服务状态
     */
    protected function status()
    {
        exec(SwooleHelper::getPsAuxProcessCommand(self::$name), $output);

        // 进程列表
        $rows = SwooleHelper::getAllProcess(self::$name);
        $headers = ['USER', 'PID', 'RSS', 'STAT', 'START', 'COMMAND'];
        foreach ($rows as $key => $value) {
            $rows[$key] = array_combine($headers, $value);
        }

        $this->getIO()->table($headers, $rows);
        $pidFile = $this->config->get('server.settings.pid_file');
        if (file_exists($pidFile)) {
            $this->getIO()->success('服务已处于运行状态');
        } else {
            $this->getIO()->warning('服务已处于停止状态');
        }

        unset($headers, $output, $rows);
    }

    /**
     * 启动服务
     */
    protected function start()
    {
        $config = $this->config->get('server');

        $server = $this->getServer();

        // 是否守护进程模式
        $daemonize = $config['settings']['daemonize'] ?? false;
        if (! $daemonize) {
            $config['settings']['daemonize'] = $this->getServerState()->isDaemon();
        }

        // 初始化服务配置
        $server->init(new ServerConfig($config));

        $messages = [
            ['Swoole 服务名称', 'HTTP SERVER'],
            ['PHP 运行版本', phpversion()],
            ['Swoole 运行版本', SWOOLE_VERSION],
            ['服务监控地址', $server->getServer()->host],
            ['服务监听端口', $server->getServer()->port],
            ['服务 PID 文件', $config['settings']['pid_file'] ?? ''],
            ['当前机器所有网络接口的IP地址', SwooleHelper::getLocalIp()],
            ['正在运行的服务用户', get_current_user()],
            ['是否守护进程模式', $this->getServerState()->isDaemon() ? '是' : '否'],
            ['框架运行名称', $this->app->name()],
            ['框架运行版本', $this->app->version()],
        ];

        $headers = ['信息名称', '信息内容'];
        foreach ($messages as $key => $value) {
            $messages[$key] = array_combine($headers, $value);
        }

        $this->getIO()->table($headers, $messages);
        $this->getIO()->success(
            sprintf(
                '服务已成功启动 - %s:%d, 启动时间 - %s',
                $server->getServer()->host,
                $server->getServer()->port,
                date('Y-m-d H:i:s')
            )
        );

        unset($headers, $rows);

        // 启动服务
        $this->getServer()->start();
    }

    protected function reload()
    {

    }

    /**
     * 停止服务
     * @throws Exception
     */
    protected function stop()
    {
        $pidFile = $this->config->get('server.settings.pid_file');
        if (! file_exists($pidFile)) {
            throw new Exception('服务 PID 文件不存在, 只能手动 KILL 进程, 并请检查它是否在守护程序模式下运行！');
        }

        $pid = intval(file_get_contents($pidFile));
        if (! swoole_process::kill($pid, SIG_DFL)) {
            throw new Exception(sprintf('服务 PID : %d 不存在 ', $pid));
        }

        swoole_process::kill($pid, SIGTERM);

        // 检查进程是否已杀死, 发送停止服务信号
        $this->getIO()->success(sprintf('服务已成功停止, 停止时间 - %s', date('Y-m-d H:i:s')));
    }
}