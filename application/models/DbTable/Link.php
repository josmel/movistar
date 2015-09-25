<?php

class Application_Model_DbTable_Link extends Core_Db_Table
{
    protected $_name = 'link';
    protected $_primary = "idlink";
    const NAMETABLE='link';
    
    public function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }
    
    static function populate($params) {
        $data = array();
        if(isset($params['idtimagenlink'])) $data['idtimagenlink'] = $params['idtimagenlink'];
        if(isset($params['url'])) $data['url'] = $params['url'];
        if(isset($params['idlink'])) $data['idlink'] = $params['idlink'];
        if(isset($params['norder'])) $data['norder'] = $params['norder'];
        if(isset($params['descripcion'])) $data['descripcion'] = $params['descripcion'];;
        if(isset($params['vchusucrea'])) $data['vchusucrea'] = $params['vchusucrea'];
        if(isset($params['vchusumodif'])) $data['vchusumodif'] = $params['vchusumodif'];
        if(isset($params['fecha_creacion'])) $data['fecha_creacion'] = $params['fecha_creacion'];
        if(isset($params['fecha_edicion'])) $data['fecha_edicion'] = $params['fecha_edicion'];
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
        return array("descripcion", "DATE_FORMAT(fecha_creacion, '%d/%m/%Y')", "DATE_FORMAT(fecha_edicion, '%d/%m/%Y')", "IF(vchestado LIKE 'A', 'Activo', 'Inactivo')");
    }
        
    public function getPrimaryKey() {
        return $this->_primary;
    }
    
    public function getWhereActive() {
        return " AND vchestado LIKE 'A'";
    }
}

