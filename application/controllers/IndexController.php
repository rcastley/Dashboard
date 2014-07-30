<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $tests = new Application_Model_TestsMapper();
        
        $this->view->count = $tests->fetchAll()->count();
        
        $summary = new Application_Model_SummaryMapper();
        
        print_r ($summary->fetchFailed()->count());
        $this->view->failed = $summary->fetchFailed()->count();
        
    }


}

