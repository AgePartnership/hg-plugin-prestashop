<?php

namespace TheMarketingLab\Hg\Plugins\PrestaShop;

class Utils
{

    public static function getTimestamp()
    {
        return time();
    }

    public static function getAccessToken()
    {
        return _HG_ACCESSTOKEN_;
    }
}
