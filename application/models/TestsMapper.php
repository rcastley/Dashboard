<?php

class Application_Model_TestsMapper
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
            $this->setDbTable('Application_Model_DbTable_Tests');
        }
        return $this->_dbTable;
    }

    public function create (Application_Model_Tests $test)
    {
        $data = array(
                'id' => $test->getId(),
                'type' => $test->getType(),
                'monitor' => $test->getMonitor(),
                'name' => $test->getName()
        );
       
        $check = $this->fetchRow($test->getId());
        
        if (null === ($id = $check)) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array("id = ?" => $check->id));
        }
    }

    public function fetchAll ()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        return $resultSet;
    }
    
    public function fetchRow ($id)
    {
        $query = $this->getDbTable()
            ->select()
            ->where('id = ?', $id);
        $resultSet = $this->getDbTable()->fetchRow($query);
        
        //echo $query->__toString();
        
        return $resultSet;  
    }
}

