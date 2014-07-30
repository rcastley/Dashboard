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
        $this->view->count = $this->_tests->fetchAll()->count();
        
        $this->view->failed = $this->_summary->fetchFailed()->count();
        
        $this->view->uptime = $this->_summary->fetchAll()->count();
        
        $this->view->nodes = $this->_nodes->fetchAll()->count();
        
        $tests = $this->_tests->fetchAll();
        
        $keysArray = array();
        foreach ($tests as $test) {
            $dataArray = array();
            
            $data = $this->_summary->dailyPerf($test->id);
            
            $keysArray[] = $test->name;
            foreach ($data as $d) {
                $dataArray[] = array(
                        'y' => $d->interval,
                        $d->name => number_format($d->total, 0, '.', '')
                );
            }
        }
        
        $this->view->chartData = json_encode($dataArray);
        $this->view->keys = json_encode($keysArray);
    }

    public function failedAction ()
    {
        $this->view->tests = $this->_summary->fetchFailed();
    }

    public function testsAction ()
    {
        $getMonitor = new Catchpoint_Monitors();
        $getType = new Catchpoint_Types();
        $this->view->monitor = $getMonitor;
        $this->view->type = $getType;
        $this->view->tests = $this->_tests->fetchAll();
    }
    
    public function testdetailAction()
    {
        $testId = $this->_getParam('id');
        $testName = $this->_tests->fetchRow($testId);
        $data = $this->_summary->dailyPerf($testId);
        
        $keysArray[] = $testName->name;
        foreach ($data as $d) {
            $dataArray[] = array(
                    'y' => $d->interval,
                    $d->name => number_format($d->total, 0, '.', '')
            );
        }
        
        $this->view->testName = $testName->name;
        $this->view->chartData = json_encode($dataArray);
        $this->view->keys = json_encode($keysArray);
    }
}

