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

namespace Raylin666\Framework\Handler;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
use Raylin666\Framework\Contract\ValidationInterface;

/**
 * Class ValidationHandler
 * @package Raylin666\Framework\Handler
 */
class ValidationHandler implements ValidationInterface
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * 是否返回所有错误信息
     * @var bool
     */
    protected $isShowAllError = false;

    /**
     * 启动, 初始化
     * @param null   $langPath      语言包路径
     * @param string $langName      语言包名称
     * @param string $FileName      语言包文件名称
     * @return $this
     */
    public function boot($langPath = null, $langName = 'zh', $FileName = 'validator'): ValidationHandler
    {
        if (! $this->factory) {
            $filesystem = new Filesystem();

            if (! $langPath) {
                $langPath = dirname(__DIR__, 2) . '/lang';
            }

            $fileloader = new FileLoader($filesystem, $langPath);
            $fileloader->addNamespace('lang', $langPath);
            $fileloader->load($langName, $FileName, 'lang');

            // unique 验证需要set DB,暂时没找到脱离 Laravel 框架使用该验证规则的实现方式。

            $this->factory = new Factory(new Translator($fileloader, $langName));
        }

        return $this;
    }

    /**
     * 设置是否提示出所有错误
     * @param bool $is_show
     * @return $this
     */
    public function withShowAllError(bool $is_show): ValidationHandler
    {
        $this->isShowAllError = $is_show;
        return $this;
    }

    /**
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @return mixed
     */
    public function validate(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        // TODO: Implement validate() method.

        $validator = $this->factory->make($data, $rules, $messages, $customAttributes);

        try {
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        } catch (ValidationException $validationException) {
            if ($this->isShowAllError) {
                $this->isShowAllError = false;
                return json_encode($validationException->errors());
            }
            return current(current($validationException->errors()));
        }

        return $validator->getData();
    }
}