<?php

namespace TheMarketingLab\Hg\Plugins\PrestaShop;

class Plugin
{
    private $controller;
    public $eventPlugin;
    public $sessionPlugin;
    public $splitPlugin;

    public function __construct($controller, $agentURL, $remoteURL)
    {
        $this->controller = $controller;
        $this->eventPlugin = new EventPlugin($controller, $agentURL);
        $this->sessionPlugin = new SessionPlugin($controller, $remoteURL);
        $this->splitPlugin = new SplitPlugin($controller);
    }
}
