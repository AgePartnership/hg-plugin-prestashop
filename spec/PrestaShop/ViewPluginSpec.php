<?php

namespace spec\TheMarketingLab\Hg\Plugins\PrestaShop;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use TheMarketingLab\Hg\Views\ViewInterface;

class ViewPluginSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('http://api.example.com/view');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheMarketingLab\Hg\Plugins\PrestaShop\ViewPlugin');
        $this->shouldImplement('TheMarketingLab\Hg\Plugins\PrestaShop\ViewPluginInterface');
    }

    function it_should_get_view()
    {
        $this->getView()->shouldImplement('TheMarketingLab\Hg\Views\ViewInterface');
    }

    function it_should_have_client()
    {
        $this->getClient()->shouldHaveType('TheMarketingLab\Hg\Views\ViewClient');
    }

    function it_should_get_existing_view_from_database(ViewInterface $view)
    {
        $view->getSegment()->willReturn('default');
        $view->getTest()->
        $this->getViewFromDatabase(12345)->should
    }

}
