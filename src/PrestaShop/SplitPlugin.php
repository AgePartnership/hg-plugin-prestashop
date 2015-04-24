<?php

namespace TheMarketingLab\Hg\Plugins\PrestaShop;

use TheMarketingLab\Hg\Sessions\TestInterface;

class SplitPlugin
{
    private $controller;
    private $session;
    private $test;

    public function __construct($controller, TestInterface $test)
    {
        $this->controller = $controller;
        $this->test = $test;
        $this->config = json_decode(file_get_contents($this->getSplitThemeDir()."config.json"));
    }

    public function setTemplate()
    {
        if ($this->test->getVariant() != 0) {
            $current_template = str_replace(_PS_THEME_DIR_, '', $this->controller->template);
            if (file_exists($this->getSplitThemeDir() . $current_template)) {
                $this->controller->template = $this->getSplitThemeDir() . $current_template;
            }
        }
    }
    public function getLayout($layout)
    {
        if ($this->test->getVariant() != 0) {
            if (file_exists($this->getSplitThemeDir().'layout.tpl')) {
                $layout = $this->getSplitThemeDir().'layout.tpl';
            }
        }
        return $layout;
    }

    public function setSplitThemeDir()
    {
        $this->controller->context->smarty->assign(array('split_tpl_dir'=>$this->getSplitThemeDir()));
    }

    public function getSplitThemeDir()
    {
        return _PS_THEME_DIR_ . 'split_tests/'. $this->test->getId() . '/';
    }

    public function setParams()
    {
        foreach ($this->config->params as $key => $value) {
            $this->controller->$key = $value;
        }
    }

    public function addCSS()
    {
        if ($this->test->getVariant() != 0) {
            $splitCSSdir = $this->getSplitThemeDir() . 'css/';
            $cssFiles = scandir($splitCSSdir);
            foreach ($cssFiles as $file) {
                if (!is_dir($file)) {
                    $this->controller->addCSS($splitCSSdir.$file);
                }
                
            }
            
        }
    }
}
