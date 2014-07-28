<?php

class Application_Model_Tests
{

    protected $_id;

    protected $_name;

    protected $_type;

    protected $_monitor;

    public function __construct (array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set ($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Invalid property');
        }
        $this->$method($value);
    }

    public function __get ($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || ! method_exists($this, $method)) {
            throw new Exception('Invalid property');
        }
        return $this->$method();
    }

    public function setOptions (array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function setId ($n)
    {
        $this->_id = (int) $n;
        return $this;
    }

    public function getId ()
    {
        return $this->_id;
    }

    public function setName ($ts)
    {
        $this->_name = (string) $ts;
        return $this;
    }

    public function getName ()
    {
        return $this->_name;
    }

    public function setType ($ts)
    {
        $this->_type = (int) $ts;
        return $this;
    }

    public function getType ()
    {
        return $this->_type;
    }

    public function setMonitor ($ts)
    {
        $this->_monitor = (int) $ts;
        return $this;
    }

    public function getMonitor ()
    {
        return $this->_monitor;
    }
}

