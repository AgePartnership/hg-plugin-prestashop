<?php

namespace TheMarketingLab\Hg\Plugins\PrestaShop;

use Symfony\Component\Yaml\Yaml;

class MCXPlugin {

    private $variant;
    private $routesFile;
    private $routes;

    public function __construct($variant)
    {
        if (!isset($variant['segment'])) {
            throw Exception('A segment is required to route');
        }
        $this->variant = $variant;
        if (isset($variant['test'])) {
            $this->routesFile = $variant['segment'] . '.' . $variant['test']['side'] . '.yaml';
        } else {
            $this->routesFile = $variant['segment'] . '.yaml';
        }
    }

    private function getRoutes()
    {
        $this->routes = \Yaml::parse(file_get_contents(_THEME_DIR_ . 'landing/' . $this->routesFile));
        error_log(print_r($this->routes));
    }

    private function findMatchingRoute($mc0,$mc1,$mc2)
    {
        
    }

    public function getMCXDir($mc0,$mc1,$mc2)
    {
        $this->getRoutes();

    }

}