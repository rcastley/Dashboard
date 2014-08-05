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
        
        $keysArray = array();
        
        $dataArray = array();
        
        foreach ($nodePerf as $p) {
            
            $this->view->nodeName = $p->nodename;
            $keysArray[] = $p->testname;
            $dataArray[] = array(
                    'y' => $p->testname,
                    $p->testname => number_format($p->total, 0, '.', '')
            );
        }
        
        $this->view->chartData = json_encode($dataArray);
        $this->view->keys = json_encode($keysArray);
    }
}

