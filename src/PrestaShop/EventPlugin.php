<?php

namespace TheMarketingLab\Hg\Plugins\PrestaShop\Plugin;

use Guzzle\Http\Client as GuzzleClient;
use TheMarketingLab\Hg\Events\EventClient;
use Symfony\Component\HttpFoundation\Request;

class EventPlugin
{
    private $controller;
    private $eventClient;

    public function __construct($controller, $url)
    {
        $this->controller = $controller;
        $guzzle = new GuzzleClient($url);
        $this->eventClient = new EventClient($guzzle);
    }

    private function makeEvent()
    {
        $sessionId = Utils::getSessionId($this->$controller);
        $appId = Utils::getAppId();
        $name = "request";
        $request = Request::createFromGlobals();
        $event = new Event($appId, $sessionId, $name, $request, Utils::getTimeStamp());

        return $event;
    }

    public function publish()
    {
        $this->eventClient->publish($this->makeEvent());
    }
}
