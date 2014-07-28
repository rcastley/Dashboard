<?php

class Application_Model_NodesMapper
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
            $this->setDbTable('Application_Model_DbTable_Nodes');
        }
        return $this->_dbTable;
    }

    public function create (Application_Model_Nodes $node)
    {
        $data = array(
                'id' => $node->getId(),
                'name' => $node->getName()
        );
        $this->getDbTable()->insert($data);
    }

    public function fetchAll ($id)
    {
        $query = $this->getDbTable()
            ->select()
            ->where('id = ?', $id);
        $resultSet = $this->getDbTable()->fetchRow($query);
        return $resultSet;
    }
}

