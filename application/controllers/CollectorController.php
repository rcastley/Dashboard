<?php

class CollectorController extends Zend_Controller_Action
{

    public function init ()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction ()
    {
        $nodeMapper = new Application_Model_NodesMapper();
        $testMapper = new Application_Model_TestsMapper();
        $summaryMapper = new Application_Model_SummaryMapper();
        
        $xml = simplexml_load_string($this->getRequest()->getRawBody());
        
        if ($this->getRequest()->isPost()) {
            
            $checkNode = $nodeMapper->fetchAll($xml->attributes()->nodeId);
            
            if (! $checkNode) {
                $newNode = new Application_Model_Nodes(
                        array(
                                'id' => $xml->attributes()->nodeId,
                                'name' => $xml->NodeName
                        ));
                
                $nodeMapper->create($newNode);
            }
            
            $checkTest = $testMapper->fetchAll($xml->attributes()->testId);
            
            if (! $checkTest) {
                $newTest = new Application_Model_Tests(
                        array(
                                'id' => $xml->attributes()->testId,
                                'type' => $xml->TestDetail->TypeId,
                                'monitor' => $xml->TestDetail->MonitorTypeId,
                                'name' => $xml->TestDetail->Name
                        ));
                
                $testMapper->create($newTest);
            }
            
            $summary = new Application_Model_Summary(
                    array(
                            'testid' => $xml->attributes()->testId,
                            'nodeid' => $xml->attributes()->nodeId,
                            'timestamp' => $xml->Summary->Timestamp,
                            'total' => $xml->Summary->Timing->Total,
                            'connect' => $xml->Summary->Timing->Connect,
                            'dns' => $xml->Summary->Timing->Dns,
                            'contentload' => $xml->Summary->Timing->ContentLoad,
                            'load' => $xml->Summary->Timing->Load,
                            'send' => $xml->Summary->Timing->Send,
                            'wait' => $xml->Summary->Timing->Wait,
                            'documentcomplete' => $xml->Summary->Timing->DocumentComplete,
                            'domload' => $xml->Summary->Timing->DomLoad,
                            'renderstart' => $xml->Summary->Timing->RenderStart,
                            'content' => $xml->Summary->Byte->Response->Content,
                            'headers' => $xml->Summary->Byte->Response->Headers,
                            'totalcontent' => $xml->Summary->Byte->Response->TotalContent,
                            'totalheaders' => $xml->Summary->Byte->Response->TotalHeaders,
                            'connections' => $xml->Summary->Counter->Connections,
                            'hosts' => $xml->Summary->Counter->Hosts,
                            'failedrequests' => $xml->Summary->Counter_FailedRequests,
                            'requests' => $xml->Summary->Counter->Requests
                    ));
            
            $summaryMapper->create($summary);
        }
    }
}