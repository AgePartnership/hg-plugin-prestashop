<?php

namespace TheMarketingLab\Hg\Plugins\PrestaShop;

use TheMarketingLab\Hg\ConfigurationInterface;
use TheMarketingLab\Hg\Events\EventClient;
use TheMarketingLab\Hg\Events\Event;
use Symfony\Component\HttpFoundation\Request;

class EventPlugin
{
    private $eventClient;

    public function __construct(ConfigurationInterface $config)
    {
        $this->eventClient = new EventClient($config);
    }

    private function makeEvent($collection, User $user, array $data = array())
    {
        $request = Request::createFromGlobals();
        $event = new Event(Utils::getTimeStamp(), $user->getSessionId(), $collection, $data, $user->getView(), $request);

        return $event;
    }

    public function publish($collection, User $user, array $data = array())
    {
        if ($user->getIdGuest()) {
            $this->eventClient->publish($this->makeEvent($collection, $user, $data));
        }
        
    }
}
