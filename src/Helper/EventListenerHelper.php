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

use Raylin666\Contract\EventDispatcherInterface;
use Raylin666\Contract\ListenerProviderInterface;

/**
 * Class EventListenerHelper
 * @package Raylin666\Framework\Helper
 */
class EventListenerHelper
{
    /**
     * @return ListenerProviderInterface
     * @throws \Exception
     */
    public static function listener(): ListenerProviderInterface
    {
        return container()->get(ListenerProviderInterface::class);
    }

    /**
     * @return EventDispatcherInterface
     * @throws \Exception
     */
    public static function dispatcher(): EventDispatcherInterface
    {
        return container()->get(EventDispatcherInterface::class);
    }
}