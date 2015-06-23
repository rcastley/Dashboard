<?php

class NodesController extends Zend_Controller_Action
{

    public function indexAction ()
    {
        $nodes = new Application_Model_NodesMapper();
        $this->view->nodes = $nodes->fetchAll();
    }

    public function summaryAction ()
    {
        $summary = new Application_Model_SummaryMapper();

        $nodeId = $this->_getParam('nodeid');
        $nodePerf = $summary->nodePerf($nodeId);
        
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

