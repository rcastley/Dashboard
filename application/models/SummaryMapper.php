<?php

class Application_Model_SummaryMapper
{

    protected $_dbTable;

    public function setDbTable ($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (! $dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Summary');
        }
        return $this->_dbTable;
    }

    public function create (Application_Model_Summary $data)
    {
        $data = array(
                'testid' => $data->getTestid(),
                'nodeid' => $data->getNodeid(),
                'timestamp' => $data->getTimestamp(),
                'total' => $data->getTotal(),
                'connect' => $data->getConnect(),
                'dns' => $data->getDns(),
                'contentload' => $data->getContentLoad(),
                'load' => $data->getLoad(),
                'send' => $data->getSend(),
                'wait' => $data->getWait(),
                'documentcomplete' => $data->getDocumentComplete(),
                'domload' => $data->getDomLoad(),
                'renderstart' => $data->getRenderStart(),
                'content' => $data->getContent(),
                'headers' => $data->getHeaders(),
                'totalcontent' => $data->getTotalContent(),
                'totalheaders' => $data->getTotalHeaders(),
                'connections' => $data->getConnections(),
                'hosts' => $data->getHosts(),
                'failedrequests' => $data->getFailedRequests(),
                'requests' => $data->getRequests()
        );
        var_dump($this->getDbTable()->insert($data));
    }

    public function fetchAll ($testId)
    {
        $query = $this->getDbTable()
            ->select()
            ->where('testid = ?', $testId);
        $resultSet = $this->getDbTable()->fetchRow($query);
        return $resultSet;
    }
}

