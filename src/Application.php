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

namespace Raylin666\Framework;

use Exception;
use ErrorException;
use Psr\Http\Message\ResponseInterface;
use Raylin666\Config\Config;
use Raylin666\Config\ConfigOptions;
use Raylin666\Container\Container;
use Raylin666\Container\ContainerFactory;
use Raylin666\Contract\ConfigInterface;
use Raylin666\Contract\ServiceProviderInterface;
use Raylin666\Framework\Contract\ApplicationInterface;
use Raylin666\Framework\Contract\CommandInterface;
use Raylin666\Framework\Contract\EnvironmentInterface;
use Raylin666\Framework\Exception\DebugLogsException;
use Raylin666\Framework\Exception\HttpException;
use Raylin666\Framework\Exception\ResponseException;
use Raylin666\Framework\Helper\EnvironmentHelper;
use Raylin666\Framework\Http\Response;
use Raylin666\Framework\ServiceProvider\ConfigServiceProvider;

/**
 * Class Application
 * @package Raylin666\Framework
 */
class Application implements ApplicationInterface
{
    /**
     * 应用
     * @var
     */
    protected static $app;

    /**
     * 项目根目录
     * @var
     */
    protected $path;

    /**
     * 配置目录参数
     * @var ConfigOptions
     */
    protected $configOptions;

    /**
     * 容器
     * @var
     */
    protected $container;

    /**
     * 应用是否已启动运行
     * @var bool
     */
    protected $isExecute = false;

    /**
     * Application constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;

        $this->configOptions = new ConfigOptions($path);

        static::$app = $this;

        $this->container = (new ContainerFactory(new Container()))->getContainer();

        // 绑定应用
        $this->container->singleton(ApplicationInterface::class, function () {
            return static::$app;
        });

        // 绑定配置
        $this->container->singleton(ConfigInterface::class, function () {
            $config = new Config();
            $config(require sprintf('%s/config.php', dirname(__DIR__)));
            return $config;
        });
    }

    /**
     * 初始化项目配置
     * @throws Exception
     */
    public function __invoke()
    {
        // TODO: Implement __invoke() method.

        // 注册配置服务提供者
        (new ConfigServiceProvider())->register($this->container);

        // 时区设置
        date_default_timezone_set($this->container->get(ConfigInterface::class)->get('timezone'));

        // 注册环境配置
        $this->container->singleton(EnvironmentInterface::class, function () {
            return new EnvironmentHelper($this->container->get(ConfigInterface::class)->get('environment'));
        });

        // 注册其他服务提供者
        $providers = $this->container->get(ConfigInterface::class)->get('providers');
        foreach ($providers as $provider) {
            $provider = new $provider;
            if ($provider instanceof ServiceProviderInterface) {
                $provider->register($this->container);
            }
        }

        // 注册响应服务
        $this->container->bind(ResponseInterface::class, function () {
           return new Response();
        });

        // 注册异常处理
        $this->registerExceptionHandler();
    }

    /**
     * 注册异常处理
     */
    protected function registerExceptionHandler()
    {
        $level = $this->container->get(ConfigInterface::class)->get('error_reporting');

        // 设置错误级别
        error_reporting($level);

        // 设置异常处理器
        set_exception_handler(function ($e) {
            // 异常捕获转换
            if (! $e instanceof Exception) {
                $e = new ErrorException($e);
            }

            try {
                $trace = DebugLogsException::getReturn($e);
            } catch (Exception $exception) {
                $trace = [
                    'original' => explode("\n", $e->getTraceAsString()),
                    'handler'  => explode("\n", $exception->getTraceAsString()),
                ];
            }

            logger()->error($e->getMessage(), $trace);

            $status = ($e instanceof HttpException) ? $e->getStatusCode() : $e->getCode();
            if (! array_key_exists($status, Response::$statusTexts)) {
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            }

            $response = $this->container->get(ResponseInterface::class)->RESTfulAPI(ResponseException::getReturn($e), $status);

            // 处理响应
            return $this->isExecute() ? $response : $response->send();
        });

        // 设置错误处理器
        set_error_handler(function ($level, $message, $file, $line) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }, $level);
    }

    /**
     * 获取应用
     * @return ApplicationInterface
     */
    public static function app(): ApplicationInterface
    {
        return static::$app;
    }

    /**
     * 获取项目根目录
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * 设置配置目录参数
     * @param string $path
     * @param string $configPathName
     * @param string $configFileName
     * @param string $readPathName
     * @return Application
     */
    public function withConfigOptions(
        string $path,
        $configPathName = 'config',
        $configFileName = 'app',
        $readPathName = 'autoload'
    ): self
    {
        $this->configOptions->withPath($path)
            ->withConfigPathName($configPathName)
            ->withConfigFileName($configFileName)
            ->withReadPathName($readPathName);

        return $this;
    }

    /**
     * 获取配置目录参数
     * @return ConfigOptions
     */
    public function getConfigOptions(): ConfigOptions
    {
        return $this->configOptions;
    }

    /**
     * 应用运行状态/是否已启动
     * @return bool
     */
    public function isExecute(): bool
    {
        return $this->isExecute;
    }

    /**
     * 应用名称
     * @return string
     */
    public function name(): string
    {
        // TODO: Implement name() method.

        return $this->container->get(ConfigInterface::class)->get('name');
    }

    /**
     * 获取版本
     * @return string
     */
    public function version(): string
    {
        // TODO: Implement version() method.

        return $this->container->get(ConfigInterface::class)->get('version');
    }

    /**
     * 获取容器
     * @return Container
     */
    public function container(): Container
    {
        // TODO: Implement container() method.

        return $this->container;
    }

    /**
     * 应用启动
     * @return mixed|void
     */
    public function run()
    {
        // TODO: Implement run() method.

        $this->isExecute = true;

        $this->container->get(CommandInterface::class)->run();
    }
}