<?php

class TestsController extends Zend_Controller_Action
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
		$this->view->monitor = new Catchpoint_Monitors();
		$this->view->type = new Catchpoint_Types();

		$tests = $this->_tests->fetchAll();

		$this->view->tests = $tests;

		foreach ($tests as $test) {

			$data = $this->_summary->dailyPerf($test->id);

			if(count($data) == 0) {
				$this->_tests->delete($test->id);
			} else {
				$dataArray = null;

				foreach ($data as $d) {
					$dataArray[] =  number_format($d->total, 0, '.', '');
				}
			}

			$testArray[] = array('name' => $test->name, 'type' => $test->type, 'monitor' => $test->monitor, 'id' => $test->id, 'data' => $dataArray);
		}

		$this->view->chartData = $testArray;
	}

	public function failedAction ()
	{
		//$getError = new Catchpoint_Errors();

		//$this->view->error = $getError;
		$this->view->tests = $this->_summary->fetchFailed('-24 hours');
	}

	public function detailAction ()
	{
		$testId = $this->_getParam('id');

		$testName = $this->_tests->fetchRow($testId);

		$data = $this->_summary->dailyPerf($testId, '-7 days');

		$this->view->lastWeek = $this->_summary->comparePerf($testId, '-2 days', '-1 day');

		$this->view->thisWeek = $this->_summary->comparePerf($testId, '-1 day', '-0 hour');

		$testArray = array();

		$dataArray = array();

			foreach ($data as $d) {
				$dataArray[] = array(
					$d->interval, number_format($d->total, 0, '.', '')
				);
			}

		$testArray[] = array('name' => $testName->name, 'data' => $dataArray);


		$this->view->testName = $testName->name;

		$this->view->chartData = json_encode($testArray, JSON_NUMERIC_CHECK);

		$city = $this->_summary->perfByCity($testId, '-7 day');

		foreach ($city as $c) {

			$mapArray = null;

			$mapArray[] = array(

							 number_format($c->total, 0, '.', '')
			);
			$cityArray[] = array('name' => $c->city . ' - ' . $c->carrier, 'data' => $mapArray);
		}

		$this->view->mapData = json_encode($cityArray, JSON_NUMERIC_CHECK);
	}

}
