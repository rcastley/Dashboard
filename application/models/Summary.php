<?php

class Application_Model_Summary
{

    protected $_testid;

    protected $_nodeid;

    protected $_timestamp;

    protected $_total;

    protected $_connect;

    protected $_dns;

    protected $_contentload;

    protected $_load;

    protected $_send;

    protected $_wait;

    protected $_documentcomplete;

    protected $_domload;

    protected $_renderstart;

    protected $_content;

    protected $_headers;

    protected $_totalcontent;

    protected $_totalheaders;

    protected $_connections;

    protected $_hosts;

    protected $_failedrequests;

    protected $_requests;

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

    public function setTestid ($n)
    {
        $this->_testid = (int) $n;
        return $this;
    }

    public function getTestid ()
    {
        return $this->_testid;
    }

    public function setNodeid ($n)
    {
        $this->_nodeid = (int) $n;
        return $this;
    }

    public function getNodeid ()
    {
        return $this->_nodeid;
    }

    public function setTimestamp ($n)
    {
        $date = date_create_from_format('YmdHisu', $n);
        $nDate = date_format($date, 'Y-m-d H:i:s');
        $this->_timestamp = $nDate;
        
        var_dump($nDate);
        return $this;
    }

    public function getTimestamp ()
    {
        return $this->_timestamp;
    }

    public function setTotal ($n)
    {
        $this->_total = (int) $n;
        return $this;
    }

    public function getTotal ()
    {
        return $this->_total;
    }

    public function setConnect ($n)
    {
        $this->_connect = (int) $n;
        return $this;
    }

    public function getConnect ()
    {
        return $this->_connect;
    }

    public function setDns ($n)
    {
        $this->_dns = (int) $n;
        return $this;
    }

    public function getDns ()
    {
        return $this->_dns;
    }

    public function setContentload ($n)
    {
        $this->_contentload = (int) $n;
        return $this;
    }

    public function getContentload ()
    {
        return $this->_contentload;
    }

    public function setLoad ($n)
    {
        $this->_load = (int) $n;
        return $this;
    }

    public function getLoad ()
    {
        return $this->_load;
    }

    public function setSend ($n)
    {
        $this->_send = (int) $n;
        return $this;
    }

    public function getSend ()
    {
        return $this->_send;
    }

    public function setWait ($n)
    {
        $this->_wait = (int) $n;
        return $this;
    }

    public function getWait ()
    {
        return $this->_wait;
    }

    public function setDocumentcomplete ($n)
    {
        $this->_documentcomplete = (int) $n;
        return $this;
    }

    public function getDocumentcomplete ()
    {
        return $this->_documentcomplete;
    }

    public function setDomload ($n)
    {
        $this->_domload = (int) $n;
        return $this;
    }

    public function getDomload ()
    {
        return $this->_domload;
    }

    public function setRenderstart ($n)
    {
        $this->_renderstart = (int) $n;
        return $this;
    }

    public function getRenderstart ()
    {
        return $this->_renderstart;
    }

    public function setContent ($n)
    {
        $this->_content = (int) $n;
        return $this;
    }

    public function getContent ()
    {
        return $this->_content;
    }

    public function setHeaders ($n)
    {
        $this->_headers = (int) $n;
        return $this;
    }

    public function getHeaders ()
    {
        return $this->_headers;
    }

    public function setTotalcontent ($n)
    {
        $this->_totalcontent = (int) $n;
        return $this;
    }

    public function getTotalcontent ()
    {
        return $this->_totalcontent;
    }

    public function setTotalheaders ($n)
    {
        $this->_totalheaders = (int) $n;
        return $this;
    }

    public function getTotalheaders ()
    {
        return $this->_totalheaders;
    }

    public function setConnections ($n)
    {
        $this->_connections = (int) $n;
        return $this;
    }

    public function getConnections ()
    {
        return $this->_connections;
    }

    public function setHosts ($n)
    {
        $this->_hosts = (int) $n;
        return $this;
    }

    public function getHosts ()
    {
        return $this->_hosts;
    }

    public function setFailedrequests ($n)
    {
        $this->_failedrequests = (int) $n;
        return $this;
    }

    public function getFailedrequests ()
    {
        return $this->_failedrequests;
    }

    public function setRequests ($n)
    {
        $this->_requests = (int) $n;
        return $this;
    }

    public function getRequests ()
    {
        return $this->_requests;
    }
}

