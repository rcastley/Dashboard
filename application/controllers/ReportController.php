<?php

class ReportController extends Zend_Controller_Action
{

	protected $_summary;

	protected $_tests;

	public $timeArray = array(
			'5m' => '-5 minutes',
			'15m' => '-15 minutes',
			'1h' => '-1 hour',
			'24h' => '-24 hours',
			'7d' => '-7 days',
			'1m' => '-1 month'
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
		
		$perfArray = array();
		
		$availArray = array();
		
		foreach ($activeTests as $test) {
			$testName[] = $test['name'];
			
			foreach ($this->timeArray as $k => $v) {
				$perfData = $this->_summary->getDataByTime($test['id'], $v);
				$perfArray[$test['name']]['perf'][$k] = $perfData[0]['total'];
		  //  }
		//}
		
		//foreach ($activeTests as $test) {
		//    $testName[] = $test['name'];
			
		   // foreach ($this->timeArray as $k => $v) {
				$gd = $this->_summary->fetchFailedById($test['id'], $v)->count();
				//$ga = $this->_summary->getDataByTime($test['id'], $v);
				
				if ($gd === 0) {
					$result = 100;
				} else {
					$result = ($gd / $perfData[0]['count']) * 100;
					$result = 100 - $result;
				}
				$availArray[$test['name']]['avail'][$k] = number_format($result, 
						2);
			}
		}
		
		$merge = array_merge_recursive($perfArray, $availArray);
		foreach ($merge as $k => $v) {
			$name[] = $k;
			if ($v['perf']) {
				foreach ($v['perf'] as $p) {
					if ($p == 0) {
						$p = '-';
					}
					$perf[$k][] = $p;
				}
			}
			if ($v['avail']) {
				foreach ($v['avail'] as $a) {
					$avail[$k][] = $a;
				}
			}
		}
		
		$this->view->name = $name;
		$this->view->perf = $perf;
		$this->view->avail = $avail;
		$this->view->color = new Catchpoint_Rag();
	}
}

