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
        
        //echo $query->__toString();
        
        return $resultSet;
    }

    public function fetchFailed ($time)
    {
        $query = $this->getDbTable()
            ->select()
            ->from(array(
                's' => 'summary'
        ), 
                array(
                        's.testid',
                        's.nodeid',
                        's.error',
                        's.timestamp',
                        'nodename' => 'n.name',
                        'testname' => 't.name'
                ))
            ->join(array(
                't' => 'tests'
        ), 'testid = t.id', array())
            ->join(array(
                'n' => 'nodes'
        ), 'nodeid = n.id', array())
            ->where('error != 0')
            ->where("timestamp >=  datetime('now', '" . $time . "')")
            ->setIntegrityCheck(false);
        
        $resultSet = $this->getDbTable()->fetchAll($query);
        
        //echo $query->__toString() . PHP_EOL;
        
        return $resultSet;
    }

    public function fetchFailedById ($testid, $time)
    {
        $query = $this->getDbTable()
            ->select()
            ->from(array(
                's' => 'summary'
        ), 
                array(
                        's.testid',
                        's.nodeid',
                        's.error',
                        's.timestamp',
                        'nodename' => 'n.name',
                        'testname' => 't.name'
                ))
            ->join(
                array(
                        't' => 'tests'
                ), 'testid = t.id', array())
            ->join(
                array(
                        'n' => 'nodes'
                ), 'nodeid = n.id', array())
            ->where('s.testid = ?', $testid)
            ->where('error != 0')
            ->where("timestamp >=  datetime('now', '" . $time . "')")
            ->setIntegrityCheck(false);
        
        $resultSet = $this->getDbTable()->fetchAll($query);
        
        //echo $query->__toString() . PHP_EOL;
        
        return $resultSet;
    }

    public function fetchAll ()
    {
        $query = $this->getDbTable()
            ->select()
            ->from(array(
                's' => 'summary'
        ))
            ->where("timestamp >=  datetime('now', '-1 day')");
        
        //echo $query->__toString() . PHP_EOL;
        
        $resultSet = $this->getDbTable()->fetchAll($query);
        
        return $resultSet;
    }

    public function count ()
    {
        $query = $this->getDbTable()
            ->select()
            ->from('summary', 
                array(
                        'COUNT(*) AS stotal'
                ))
            ->where("timestamp >=  datetime('now', '-1 day')");
                
        $resultSet = $this->getDbTable()->fetchAll($query)->toArray();
        
        return $resultSet;
    }

    public function dailyPerf ($id, $timeFrame = '-1 day')
    {
        $query = $this->getDbTable()
            ->select()
            ->from(array(
                's' => 'summary'
        ), 
                array(
                        'testid',
                        //'interval' => "datetime((strftime('%s', timestamp) / 1800) * 1800, 'unixepoch')",
                        'interval' => "(strftime('%s', timestamp) / 1800 * 1800 * 1000)",
                        'total' => 'AVG(total)'
                ))
            ->join(array(
                't' => 'tests'
        ), 's.testid = t.id')
            ->where("timestamp >=  datetime('now', '" . $timeFrame . "')")
            ->where("s.testid = ?", $id)
            ->order(
                array(
                        'interval',
                        'testid'
                ))
            ->group(
                array(
                        'interval',
                        'testid'
                ))
            ->setIntegrityCheck(false);
        
        $resultSet = $this->getDbTable()->fetchAll($query);
        
        //echo $query->__toString() . PHP_EOL;
        
        return $resultSet;
    }


public function comparePerf ($id, $from = '-14 day', $to = '-7 day')
    {
        $query = $this->getDbTable()
            ->select()
            ->from(array(
                's' => 'summary'
        ), 
                array(
                        'testid',
                        //'interval' => "datetime((strftime('%s', timestamp) / 1800) * 1800, 'unixepoch')",
                        //'interval' => "(strftime('%s', timestamp) / 1800 * 1800 * 1000)",
                        'interval' => "timestamp",
                        'total' => 'AVG(total)',
                        'doc' => 'documentcomplete',
                        'render' => 'renderstart',
                        'wait' => 'wait'
                ))
            ->join(array(
                't' => 'tests'
        ), 's.testid = t.id')
            ->where("timestamp <= datetime('now', '" . $to . "')")
            ->where("timestamp >= datetime('now', '". $from . "')")
            ->where("s.testid = ?", $id)
            /*
            ->order(
                array(
                        'interval',
                        'testid'
                ))
            ->group(
                array(
                        'interval',
                        'testid'
                ))
            */
            ->setIntegrityCheck(false);
        
        $resultSet = $this->getDbTable()->fetchAll($query)->toArray();
        
        echo $query->__toString() . PHP_EOL;
        
        return $resultSet;
    }
    public function nodePerf ($nodeId)
    {
        $query = $this->getDbTable()
            ->select()
            ->from(array(
                's' => 'summary'
        ), 
                array(
                        'testid',
                        'total' => 'AVG(total)',
                        'nodename' => 'n.name',
                        'testname' => 't.name'
                ))
            ->join(array(
                't' => 'tests'
        ), 's.testid = t.id')
            ->join(array(
                'n' => 'nodes'
        ), 's.nodeid = n.id')
            ->where("timestamp >= datetime('now', '-1 day')")
            ->where("s.nodeid = ?", $nodeId)
            ->group(array(
                'testid'
        ))
            ->setIntegrityCheck(false);
        
        $resultSet = $this->getDbTable()->fetchAll($query);
        
        //echo $query->__toString() . PHP_EOL;
        
        return $resultSet;
    }

    public function getDataByTime ($testid, $time)
    {
        $query = $this->getDbTable()
            ->select()
            ->from(array(
                's' => 'summary'
        ), 
                array(
                        'total' => 'AVG(total)',
                        // 'testname' => 't.name'
                        'count' => 'COUNT(*)'
                ))
            ->join(array(
                't' => 'tests'
        ), 'testid = t.id', array())
            ->where('testid IN (?)', $testid)
            ->where("timestamp >= datetime('now', '" . $time . "')")
            ->setIntegrityCheck(false);
        
        $resultSet = $this->getDbTable()
            ->fetchAll($query)
            ->toArray();
        
        //echo $query->__toString() . PHP_EOL;
        
        return $resultSet;
    }

    public function getAvailability ($testid, $time)
    {
        $query = $this->getDbTable()
            ->select()
            ->from(array(
                's' => 'summary'
        ), 
                array(
                        'total' => 'AVG(total)',
                        // 'testname' => 't.name'
                        'count' => 'COUNT(*)'
                ))
            ->join(
                array(
                        't' => 'tests'
                ), 'testid = t.id', array())
            ->where('testid = ?', $testid)
            ->where("timestamp >= datetime('now', '" . $time . "')")
            ->setIntegrityCheck(false);
        
        $resultSet = $this->getDbTable()
            ->fetchAll($query)
            ->toArray();
        
        //echo $query->__toString() . PHP_EOL;
        
        return $resultSet;
    }

    public function perfByCity ($testid, $timeFrame = '-1 day')
    {
        $query = $this->getDbTable()
            ->select()
            ->from(array(
                's' => 'summary'
        ), 
                array(
                        'testid',
                        'total' => 'AVG(total)'
                // 'city' => 'n.city'
                                ))
            ->join(
                array(
                        't' => 'tests'
                ), 's.testid = t.id')
            ->join(
                array(
                        'n' => 'nodes'
                ), 's.nodeid = n.id')
            ->where("timestamp >= datetime('now', '". $timeFrame . "')")
            ->where("s.testid = ?", $testid)
            ->group(array(
                'n.id'
        ))
            ->setIntegrityCheck(false);
        
        $resultSet = $this->getDbTable()->fetchAll($query);
        
        //echo $query->__toString() . PHP_EOL;
        
        return $resultSet;
    }
}

