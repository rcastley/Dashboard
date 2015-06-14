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
                'name' => $node->getName(),
                'city' => $node->getCity(),
                'carrier' => $node->getCarrier()
        );
        
        $check = $this->fetchRow($node->getId());
        
        if (null === ($id = $check)) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, 
                    array(
                            "id = ?" => $check->id
                    ));
        }
    }

    public function fetchRow ($id)
    {
        $query = $this->getDbTable()
            ->select()
            ->where('id = ?', $id);
        $resultSet = $this->getDbTable()->fetchRow($query);
        
        //echo $query->__toString() . PHP_EOL;
        
        return $resultSet;
    }

    public function fetchAll ()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        return $resultSet;
    }

    public function count ()
    {
        $query = $this->getDbTable()
            ->select()
            ->from('nodes', 
                array(
                        'COUNT(id) AS tnodes'
                ));
        
        //echo $query->__toString() . PHP_EOL;

        $resultSet = $this->getDbTable()->fetchAll($query)->toArray();
        
        return $resultSet;
    }
}

