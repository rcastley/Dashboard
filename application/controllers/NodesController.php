<?php

class NodesController extends Zend_Controller_Action
{

    protected $_summary;

    public function init ()
    {
        $this->_summary = new Application_Model_SummaryMapper();
    }

    public function indexAction ()
    {
        $nodeId = $this->_getParam('nodeid');
        $nodePerf = $this->_summary->nodePerf($nodeId);
        
        $nodeArray = array();
        
        $dataArray = array();
        
        foreach ($nodePerf as $p) { 
                    $dataArray = null;        
            $dataArray[] = array(
                    $p->nodename, number_format($p->total, 0, '.', '')
            );
            $nodeArray[] = array('name' => $p->testname, 'data' => $dataArray);
        }

        $this->view->nodeName = $p->nodename;        
        $this->view->chartData = json_encode($nodeArray, JSON_NUMERIC_CHECK);
        
    }
}

