<?php

namespace TheMarketingLab\Hg\Plugins\PrestaShop;

class Utils
{

    public static function getTimestamp()
    {
        return time();
    }

    public static function getAppId()
    {
        return _HG_APPID_;
    }
}
