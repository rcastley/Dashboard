<?php

class IndexController extends Zend_Controller_Action
{

    protected $_tests;
    
    protected $_summary;
    
    public function init()
    {
        $this->_tests = new Application_Model_TestsMapper();
        
       
        
        $this->_summary = new Application_Model_SummaryMapper();
    }

    public function indexAction()
    {
        
        $this->view->count = $this->_tests->fetchAll()->count();
        
        
        $this->view->failed = $this->_summary->fetchFailed();
        
        $this->view->uptime = $this->_summary->fetchAll()->testid;
               
    }

    public function failedAction()
    {
        $this->view->failed = $this->_summary->fetchFailed();
    }

}

