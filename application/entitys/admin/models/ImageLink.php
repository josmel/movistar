<?php

class Admin_Model_ImageLink extends Core_Model
{
    protected $_tableImagelink; 
    
    public function __construct() {
        $this->_tableImagelink = new Application_Model_DbTable_ImageLink();
    }    
    
    public function insert($params) {
        $data = array();
          
        if(isset($params['nombre'])) $data['nombre'] = $params['nombre'];
        if(isset($params['vchestado'])) 
            $data['vchestado'] = $params['vchestado'] == 1 ? 'A' : 'I';
        if(isset($params['vchusucrea'])) $data['vchusucrea'] = $params['vchusucrea'];
        
        $this->_tableImagelink->insert($data);
        return $this->_tableImagelink->getAdapter()->lastInsertId();
    }
    
}
