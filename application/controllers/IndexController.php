<?php

class IndexController extends Zend_Controller_Action
{

    protected $_tests;

    protected $_nodes;

    protected $_summary;

    public function init ()
    {
        $this->_tests = new Application_Model_TestsMapper();
        
        $this->_nodes = new Application_Model_NodesMapper();
        
        $this->_summary = new Application_Model_SummaryMapper();
    }

    public function indexAction ()
    {
        $tests = $this->_tests->fetchAll();
                
        $testArray = array();

        $dataArray = array();
        
        foreach ($tests as $test) {
            
            $data = $this->_summary->dailyPerf($test->id);
            
            $dataArray = null; 
            
            foreach ($data as $d) {
                $dataArray[] = array( 
                    $d->interval, number_format($d->total, 0, '.', '')
                );
            }

            $testArray[] = array('name' => $test->name, 'data' => $dataArray);
        }
        
        $this->view->count = $this->_tests->fetchAll()->count();
        $this->view->failed = $this->_summary->fetchFailed('-24 hours')->count();
        $this->view->uptime = $this->_summary->count();
        $this->view->nodes = $this->_nodes->count();
        $this->view->chartData = json_encode($testArray, JSON_NUMERIC_CHECK);
    }

}

