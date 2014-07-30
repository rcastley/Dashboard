<?php

class IndexController extends Zend_Controller_Action
{

    protected $_tests;
    
    protected $_nodes;
    
    protected $_summary;
    
    public function init()
    {
        $this->_tests = new Application_Model_TestsMapper();
        
        $this->_nodes = new Application_Model_NodesMapper();
        
        $this->_summary = new Application_Model_SummaryMapper();
    }

    public function indexAction()
    {
        
        $this->view->count = $this->_tests->fetchAll()->count();
        
        
        $this->view->failed = $this->_summary->fetchFailed()->count();
        
        $this->view->uptime = $this->_summary->fetchAll()->count();
        
        $this->view->nodes = $this->_nodes->fetchAll()->count();

        $tests = $this->_tests->fetchAll();
        
        foreach ($tests as $test) {
            $dataArray = array();
            $keysArray = array();
            $data = $this->_summary->dailyPerf($test->id);
            $keysArray[] = $test->id;
            foreach ($data as $d) {
                $dataArray[] = array('y' => $d->timestamp, $d->testid => $d->total);
            
            }
        }
        
        print_r($keysArray);
       $this->view->chartData = json_encode($dataArray);
       $this->view->keys = json_encode($keysArray);
       
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

