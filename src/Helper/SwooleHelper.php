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

/**
 * Class SwooleHelper
 * @package Raylin666\Framework\Helper
 */
class SwooleHelper
{
    /**
     * 获取得到执行进程命令
     * @param string $search_keyword
     * @return string
     */
    public static function getPsAuxProcessCommand(string $search_keyword): string
    {
        $scriptName = pathinfo($_SERVER['SCRIPT_FILENAME'], PATHINFO_BASENAME);
        $command = sprintf(
            'ps aux | grep %s | grep %s | grep -v grep',
            $scriptName,
            $search_keyword
        ) . sprintf(
            ' |grep %s',
            ServerStateHandler::SERVER_TYPE_START
            );
        return $command;
    }

    /**
     * 获取所有相关进程列表
     * @param string $search_keyword
     * @return array
     */
    public static function getAllProcess(string $search_keyword): array
    {
        exec(static::getPsAuxProcessCommand($search_keyword), $output);

        // list all process
        $output = array_map(function ($v) {
            $status = preg_split('/\s+/', $v);
            unset($status[2], $status[3], $status[4], $status[6], $status[9]);
            $status = array_values($status);
            $status[5] = $status[5] . ' ' . implode(' ', array_slice($status, 6));
            return array_slice($status, 0, 6);
        }, $output);

        return $output;
    }

    /**
     * 设置进程名称
     * @param $name
     */
    public static function setProcessRename($name)
    {
        set_error_handler(function () {});
        if (function_exists('cli_set_process_title')) {
            cli_set_process_title($name);
        } else if (function_exists('swoole_set_process_name')) {
            swoole_set_process_name($name);
        }
        restore_error_handler();
    }

    /**
     * 进程是否已在运行
     * @param $search_keyword
     * @return bool
     */
    public static function isRunningProcess($search_keyword): bool
    {
        exec(static::getPsAuxProcessCommand($search_keyword), $output);
        return !empty($output);
    }

    /**
     * 端口是否已在运行
     * @param $port
     * @return bool
     */
    public static function isRunningPort($port): bool
    {
        exec(sprintf('lsof -i:%d', intval($port)), $output);
        return !empty($output);
    }

    /**
     * 获取当前计算机所有网络接口的IP地址
     * @return string
     */
    public static function getLocalIp(): string
    {
        $localIp = '';
        $ips = swoole_get_local_ip();
        foreach ($ips as $eth => $val){
            $localIp .= 'ip@' . $eth . $val . ', ';
        }
        return $localIp;
    }
}