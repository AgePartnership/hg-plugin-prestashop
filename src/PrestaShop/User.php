<?php

namespace TheMarketingLab\Hg\Plugins\PrestaShop;

use TheMarketingLab\Hg\Tests\Test;
use TheMarketingLab\Hg\Views\View;

class User
{
    private $dbh;
    private $session_id;
    private $id_guest;
    private $id_customer;
    private $view;
    
    public function __construct($dbh, $id_guest, $id_customer)
    {
        $this->dbh = $dbh;
        $this->setIdGuest(empty($id_guest) ? null : $id_guest);
        $this->setIdCustomer(empty($id_customer) ? null : $id_customer);
        $this->load();
    }

    private function getFromViewTable($where)
    {
        $sql = "SELECT session_id, id_guest, id_customer, segment, test_id, test_variant FROM hg_user WHERE $where LIMIT 1";
        $result = $this->dbh->executeS($sql);
        if (empty($result)) {
            $result = false;
        } else {
            $result = $result[0];
            $this->session_id = $result['session_id'];
            if ($results['test_id'] === null) {
                $test = null;
            } else {
                $test = new Test($results['test_id'], $results['test_variant']);
            }
            $view = new View($results['segment'], $test);
            $this->setView($view);
            $result = true;
        }
        return $result;
    }

    private function getNewSessionId()
    {
        $data = array();
        if ($this->id_guest !== null) {
            $data['id_guest'] = $this->id_guest;
        }
        if ($this->id_customer !== null) {
            $data['id_customer'] = $this->id_customer;
        }
        $this->dbh->insert('hg_user', $data, true, false, \Db::INSERT, false);

        $this->session_id = $this->dbh->Insert_ID();

        return true;
    }

    private function load()
    {
        $result = false;
        // Lookup on id_customer first
        if ($this->id_customer !== null) {
            $where = "id_customer=".$this->id_customer;
            $result = $this->getFromViewTable($where);
        }
        // Lookup id_guest next
        if ($result === false && $this->id_guest !== null) {
            $where = "id_guest=".$this->id_guest;
            $result = $this->getFromViewTable($where);
        }
        // If result is still false we need to generate sessionId
        if ($result === false) {
            $result = $this->getNewSessionId();
        }
    }

    public function setView($view)
    {
        $this->view = $view;
        return $view;
    }

    public function getView()
    {
        return $this->view;
    }

    public function getSessionId()
    {
        return $this->sessionId;
    }

    public function getIdGuest()
    {
        return $this->id_guest;
    }

    public function setIdGuest($id)
    {
        $this->id_guest = $id;
    }

    public function getIdCustomer()
    {
        return $this->id_customer;
    }

    public function setIdCustomer($id)
    {
        $this->id_customer = $id;
    }

    public function store()
    {
        $data = array(
            'session_id' => $this->getSessionId(),
            'id_guest' => $this->getIdGuest(),
            'id_customer' => $this->getIdCustomer(),
            'segment' => $this->getView()->getSegment()
        );
        $test = $this->getView()->getTest();
        if ($test !== null) {
            $data['test_id'] = $test->getId();
            $data['test_variant'] =  $test->getVariant();
        }

        $this->dbh->insert('hg_user', $data, true, false, \Db::REPLACE, false);
    }
}
