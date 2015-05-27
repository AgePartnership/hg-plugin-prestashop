<?php

namespace TheMarketingLab\Hg\Plugins\PrestaShop;

use Guzzle\Http\Client as GuzzleClient;
use TheMarketingLab\Hg\Events\EventClient;
use TheMarketingLab\Hg\Events\Event;
use Symfony\Component\HttpFoundation\Request;

class EventPlugin
{
    private $eventClient;

    public function __construct($url)
    {
        $guzzle = new GuzzleClient($url);
        $this->eventClient = new EventClient($guzzle);
    }

    private function makeEvent($user)
    {
        $appId = Utils::getAppId();
        $name = "request";
        $request = Request::createFromGlobals();
        $event = new Event(Utils::getTimeStamp(), $appId, $user->getSessionId(), $name, $user->getView(), $request);

        return $event;
    }

    public function publish($user)
    {
        if ($user->getIdGuest()) {
            $this->eventClient->publish($this->makeEvent($user));
        }
        
    }
}
