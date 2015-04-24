<?php

namespace TheMarketingLab\Hg\Plugins\PrestaShop;

use Guzzle\Http\Client as GuzzleClient;
use TheMarketingLab\Hg\Events\SessionClient;
use Symfony\Component\HttpFoundation\Request;

class SessionPlugin implements SessionPluginInterface
{
    private $controller;
    private $sessionClient;
    private $db;
    private $table_exists = false;
    private $session_table = 'hg_session_store';
    private $client;

    public function __construct($controller, $url, $db)
    {
        $this->controller = $controller;
        $guzzle = new GuzzleClient($url);
        $this->client = new SessionClient($guzzle);
        $this->db = $db;
    }

    private function checkTableExists()
    {
        if (!$this->table_exists) {
            $session_table = $this->session_table;
            $db->execute("CREATE TABLE IF NOT EXISTS `$session_table` (session_id INT AUTO_INCREMENT PRIMARY KEY, test_id INT, variant INT)");
        }
    }

    private function getTableName()
    {
        $this->checkTableExists();
        return $this->session_table;
    }

    public function getSession()
    {
        $sessionId = Utils::getSessionId();
        $this->sessionClient->get(Utils::getSessionId());
        return array("current_test"=>array('id'=>2,'side'=>1));
    }

    private function getTestFromDatabase($session_id)
    {
        $table_name = $this->getTableName();
        
    }

}
