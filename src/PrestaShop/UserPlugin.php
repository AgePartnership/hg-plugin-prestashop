<?php

namespace TheMarketingLab\Hg\Plugins\PrestaShop;

use TheMarketingLab\Hg\Tests\Test;
use TheMarketingLab\Hg\Views\View;
use Guzzle\Http\Client as GuzzleClient;
use TheMarketingLab\Hg\Views\ViewClient;

class UserPlugin
{

    private $client;
    private $dbh;
    private $session_id;
    private $user;

    public function __construct($url, $dbh)
    {
        $client = new GuzzleClient($url);
        $this->client = new ViewClient($client);
        $this->dbh = $dbh;
    }

    public function loadUser($id_guest, $id_customer)
    {
        $this->user = new User($this->getDBH(), $id_guest, $id_customer);
        //$view = $this->getClient()->get($this->getUser()->getView());
        //$this->getUser->setView($view);
        // Mock View Atm
        if ($this->getUser()->getView() === null) {
            $this->getUser()->setView(new View('default'));
        }

        return $this->getUser();
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getDBH()
    {
        return $this->dbh;
    }
}
