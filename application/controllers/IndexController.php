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
        
        
        $this->view->failed = $this->_summary->fetchFailed()->count();
        
        $this->view->uptime = $this->_summary->fetchAll()->count();
        
        print_r($this->_summary->fetchAll()->count());
               
    }

    public function failedAction()
    {
        $this->view->tests = $this->_summary->fetchFailed();
    }
    
    public function testsAction()
    {
        $this->view->tests = $this->_tests->fetchAll();
    }

}

