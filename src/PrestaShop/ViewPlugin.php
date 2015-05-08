<?php

namespace TheMarketingLab\Hg\Plugins\PrestaShop;

use TheMarketingLab\Hg\Tests\Test;
use TheMarketingLab\Hg\Views\View;
use Guzzle\Http\Client as GuzzleClient;
use TheMarketingLab\Hg\Views\ViewClient;

class ViewPlugin implements ViewPluginInterface
{

    private $client;
    private $dbh;

    public function __construct($url, $dbh)
    {
        $client = new GuzzleClient($url);
        $this->client = new ViewClient($client);

        $this->dbh = $dbh;
    }

    public function getView($sessionId)
    {
        $view = $this->getViewFromDatabase($sessionId);
        //$view = $this->getClient()->get($view);
        // Need to mock View atm
        if ($view === null) {
            $view = new View('default');
        }
        $this->storeViewInDatabase($sessionId, $view);
        return $view;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getDBH()
    {
        return $this->dbh;
    }

    private function getViewFromDatabase($sessionId)
    {
        $sql = "SELECT session_id, segment, test_id, test_variant FROM hg_view WHERE session_id=$sessionId";
        $result = $this->dbh->executeS($sql);
        if ($result === false) {
            $view = null;
        } else {
            if ($results['test_id'] === null) {
                $test = null;
            } else {
                $test = new Test($results['test_id'], $results['test_variant']);
            }
            $view = new View($results['segment'], $test);
        }

        return $view;
    }

    private function storeViewInDatabase($sessionId, $view)
    {
        $data = array(
            "session_id" => $sessionId,
            "segment" => $view->getSegment()
        );
        $test = $view->getTest();
        if ($test !== null) {
            $data['test_id'] = $test->getId();
            $data['test_variant'] =  $test->getVariant();
        }
        $this->getDBH()->insert('hg_view', $data, true, false, \Db::REPLACE, false);
    }
}
