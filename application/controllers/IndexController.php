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

    public function failedAction ()
    {
        $this->view->tests = $this->_summary->fetchFailed('-24 hours');
    }

    public function testsAction ()
    {
        $getMonitor = new Catchpoint_Monitors();
        $getType = new Catchpoint_Types();
        
        $this->view->monitor = $getMonitor;
        $this->view->type = $getType;
        
        $tests = $this->_tests->fetchAll();
        
        $this->view->tests = $tests;

        foreach ($tests as $test) {
            
            $data = $this->_summary->dailyPerf($test->id);
            
            $dataArray = null; 
            
            foreach ($data as $d) {
                $dataArray[] =  
                    number_format($d->total, 0, '.', '')
                ;
            }

            $testArray[] = array('name' => $test->name, 'type' => $test->type, 'monitor' => $test->monitor, 'id' => $test->id, 'data' => $dataArray);
        }

        $this->view->chartData = $testArray;

        //print_r ($testArray);

    }

    public function testdetailAction ()
    {
        $testId = $this->_getParam('id');
        
        $testName = $this->_tests->fetchRow($testId);
        
        $data = $this->_summary->dailyPerf($testId, '-7 day');

        $this->view->lastWeek = $this->_summary->comparePerf($testId, '-3 day', '-2 day');

        $this->view->thisWeek = $this->_summary->comparePerf($testId, '-2 day', '0 day');
        
        $testArray = array();

        $dataArray = array();
        
            
            foreach ($data as $d) {
                $dataArray[] = array( 
                    $d->interval, number_format($d->total, 0, '.', '')
                );
            }

        $testArray[] = array('name' => $testName->name, 'data' => $dataArray);
        
        
        $this->view->testName = $testName->name;
        //$this->view->chartData = json_encode($dataArray);
        //$this->view->label = json_encode($dateArray);
        //$this->view->keys = json_encode($keysArray);

        $this->view->chartData = json_encode($testArray, JSON_NUMERIC_CHECK);
        
        $city = $this->_summary->perfByCity($testId, '-7 day');

        /*
        foreach ($city as $c) {
            $mapArray[] = array(
                    $c->city,
                    $c->city . ' - ' . $c->carrier . ': ' .
                             number_format($c->total, 0, '.', '') . ' ms'
            );
        }
        */
        foreach ($city as $c) {

            $mapArray = null; 
            $mapArray[] = array(

                             number_format($c->total, 0, '.', '')
            );
            $cityArray[] = array('name' => $c->city . ' - ' . $c->carrier, 'data' => $mapArray);
        }


        $this->view->mapData = json_encode($cityArray, JSON_NUMERIC_CHECK);        
    }

    public function nodesAction ()
    {
        $this->view->nodes = $this->_nodes->fetchAll();
    }
}

