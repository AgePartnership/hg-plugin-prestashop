# hg-plugin-prestashop

This plugin intends to be as self contained as possible to minimise the amount of code that has to go in the overides

To enable autoloading add the following lines to config/autoload.php in PS1.6

    // Hg3 Autoloads
    define('_HG_VENDOR_DIR_',        _PS_ROOT_DIR_.'/vendor/');
    require_once(_HG_VENDOR_DIR_.'autoload.php');

## Example Overidden methods for FrontController

    public $splitPlugin;
    public $context;
    public $template;

    public function run()
    {
        $splitP = new SplitPlugin($this, array("current_test"=>array("side"=>1,'id'=>1)));
        $this->splitPlugin = $splitP;
        $this->splitPlugin->setParams();

        parent::run();
        //error_log(print_r($event,true));
    }

    public function display()
    {
        $this->splitPlugin->setSplitThemeDir();
        $this->splitPlugin->addCSS();
        parent::display();
    }

    public function setTemplate($template) 
    {
        parent::setTemplate($template);
        $this->splitPlugin->setTemplate();
    }

    public function getLayout()
    {
        $layout = parent::getLayout();
        return $this->splitPlugin->getLayout($layout);
    }