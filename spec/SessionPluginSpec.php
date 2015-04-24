<?php

namespace spec\TheMarketingLab\Hg\Plugins\PrestaShop;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SessionPluginSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('TheMarketingLab\Hg\Plugins\PrestaShop\SessionPlugin');
        $this->shoudlImplement('TheMarketingLab\Hg\Plugins\PrestaShop\SessionPluginInterface');
    }
}
