<?php

namespace TheMarketingLab\Hg\Plugins\PrestaShop;

class Utils
{

    public static function getSessionId($controller)
    {
        $cookie = $controller->context->cookie;
        return (string)$cookie->__get('id_guest');
    }

    public static function getTimestamp()
    {
        return time();
    }

    public static function getAppId()
    {
        return _HG_APPID_;
    }
}
