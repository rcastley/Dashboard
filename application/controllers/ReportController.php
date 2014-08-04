<?php

class ReportController extends Zend_Controller_Action
{

    protected $_summary;

    protected $_tests;

    public $timeArray = array(
            '5' => '-5 minutes',
            '15' => '-15 minutes',
            '1' => '-1 hour',
            '24' => '-24 hours'
    );

    public function init ()
    {
        $this->_summary = new Application_Model_SummaryMapper();
        
        $this->_tests = new Application_Model_TestsMapper();
    }

    public function indexAction ()
    {
        $activeTests = $this->_tests->fetchAll()->toArray();
        
        $testName = array();
        
        $dataArray = array();
        
        foreach ($activeTests as $test) {
            $testName[] = $test['name'];
            
            foreach ($this->timeArray as $k => $v) {
                $gd = $this->_summary->getDataByTime($test['id'], $v);
                $dataArray[$test['name']][$k] = number_format($gd[0]['total']);
            }
        }
        
        foreach ($activeTests as $test) {
            $testName[] = $test['name'];
            
            foreach ($this->timeArray as $k => $v) {
                $gd = $this->_summary->fetchFailedById($test['id'], $v)->count();
                $ga = $this->_summary->getDataByTime($test['id'], $v);
                //echo $gd;
                //print_r ($gd);
                //echo "100 - (gd / number_format($ga[0]['count']) * 100)
                if ($gd === 0) {
                    $result = 100;
                } else {
                    $result = number_format(100 - ($gd / number_format($ga[0]['count']) * 100), 2);
                }
                $availArray[$test['name']][$k] = $result;
            }
        }
        
        //print_r($availArray);
        
        //print_r($dataArray);
        $this->view->data = $dataArray;
        
        $this->view->avail = $availArray;
        
        $this->view->a = array_merge_recursive($dataArray, $availArray);
        
        print_r ($a);
        
    }
}

