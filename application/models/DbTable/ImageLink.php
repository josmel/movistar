<?php

class Application_Model_DbTable_ImageLink extends Core_Db_Table
{
    protected $_name = 'timagenlink';
    protected $_primary = "idtimagenlink";
    const NAMETABLE='timagenlink';
    
    public function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }
    
    static function populate($params) {
        $data = array();
        if(isset($params['nombre'])) $data['nombre'] = $params['nombre'];
        if(isset($params['vchusucrea'])) $data['vchusucrea'] = $params['vchusucrea'];

        //$data = array_filter($data);
        if(isset($params['vchestado']))
            $data['vchestado']= $params['vchestado'] ? 'A' : 'I';
        return $data;
    }
    
    /**
     * 
     * @param obj DB $resulQuery
     */
    public function columnDisplay()
    {
        return array("titulo", "DATE_FORMAT(fechainicio, '%d/%m/%Y')", "DATE_FORMAT(fechafin, '%d/%m/%Y')", "IF(vchestado LIKE 'A', 'Activo', 'Inactivo')");
    }
        
    public function getPrimaryKey() {
        return $this->_primary;
    }
    
    public function getWhereActive() {
        return " AND vchestado LIKE 'A'";
    }
}

