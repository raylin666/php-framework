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

namespace Raylin666\Framework\Http;

use Raylin666\Framework\Contract\ValidationInterface;

/**
 * Class Controller
 * @package Raylin666\Framework\Http
 */
abstract class Controller
{
    /**
     * @var \Psr\Http\Message\RequestInterface|Response|\Raylin666\Http\Request
     */
    protected $request;

    /**
     * @var \Psr\Http\Message\ResponseInterface|Response|\Raylin666\Http\Response
     */
    protected $response;

    /**
     * @var \Raylin666\Container\Container|\Raylin666\Contract\ContainerInterface
     */
    protected $container;

    /**
     * Controller constructor.
     * @throws \Exception
     */
    final public function __construct()
    {
        // Set container
        $this->container = container();
        // Set request
        $this->request = request();
        // Set response
        $this->response = response();

        // initialize controller
        $this->initialize();
    }

    /**
     * @return ValidationInterface
     * @throws \Exception
     */
    public function validator()
    {
        return $this->container->get(ValidationInterface::class);
    }

    /**
     * 初始化数据方法等效于__construct的使用。对于框架的管理，禁止所有重写构造函数，而此方法是伪构造的。
     */
    public function initialize() {}
}