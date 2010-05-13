<?php

class IndexController extends Zend_Controller_Action
{

    protected $_em = null;

    public function init()
    {
        $registry = Zend_Registry::getInstance();
        $this->_em = $registry->entitymanager;
    }

    public function indexAction()
    {
        $test = new Apt_Model_User;
        $test->name = 'Test';
        $test->username = "A";
        $test->password = "B";
        $this->_em->persist($test);
        $this->_em->flush();
    }


}

