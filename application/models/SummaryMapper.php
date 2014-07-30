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
                'contentload' => $data->getContentload(),
                'load' => $data->getLoad(),
                'send' => $data->getSend(),
                'wait' => $data->getWait(),
                'documentcomplete' => $data->getDocumentcomplete(),
                'domload' => $data->getDomload(),
                'renderstart' => $data->getRenderstart(),
                'content' => $data->getContent(),
                'headers' => $data->getHeaders(),
                'totalcontent' => $data->getTotalcontent(),
                'totalheaders' => $data->getTotalheaders(),
                'connections' => $data->getConnections(),
                'hosts' => $data->getHosts(),
                'failedrequests' => $data->getFailedrequests(),
                'requests' => $data->getRequests(),
                'error' => $data->getError()
        );
        $this->getDbTable()->insert($data);
    }

    public function fetchRow ($testId)
    {
        $query = $this->getDbTable()
            ->select()
            ->where('testid = ?', $testId);
        $resultSet = $this->getDbTable()->fetchRow($query);
        return $resultSet;
    }

    public function fetchFailed ()
    {
        $query = $this->getDbTable()
            ->select()
            ->where('error != 0')
            ->where("DATE(timestamp) >=  date('now', '-1 day')");
        $resultSet = $this->getDbTable()->fetchAll($query);
        
        return $resultSet;
    }

    public function fetchAll ()
    {
        $query = $this->getDbTable()
            ->select()
            ->from(array(
                's' => 'summary'
        ), array(
                'tdate' => 'DATE(timestamp)'
        ))
            ->where("tdate >=  date('now', '-1 day')");
        
        $resultSet = $this->getDbTable()->fetchAll($query);
        
        return $resultSet;
    }

    public function dailyPerf ($id)
    {
        $query = $this->getDbTable()
            ->select()
            ->from(array(
                's' => 'summary'
        ), 
                array(
                        'testid',
                        'timestamp',
                        'total'
                ))
            ->where("DATE(timestamp) >=  date('now', '-1 day')");
        //->group("strftime('%H', timestamp)");
        
        $resultSet = $this->getDbTable()->fetchAll($query);
        
        //echo $query->__toString();
        return $resultSet;
    }
}