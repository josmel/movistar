<?php

class Application_Model_DbTable_Banner2 extends Core_Db_Table
{
    protected $_name = 'tbanner';
    protected $_primary = "idbanner";
    const NAMETABLE='tbanner';
    
    public function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
        //$this->setDefaultAdapter(Zend_Registry::get('dbAdmin'));
      //  $this->_setAdapter(Zend_Registry::get('db_movistar_admin'));
    }
    
    static function populate($params) {
        $data = array();
        if(isset($params['idimagen'])) $data['idimagen'] = $params['idimagen'];
        if(isset($params['url'])) $data['url'] = $params['url'];
        if(isset($params['codtbanner'])) $data['codtbanner'] = $params['codtbanner'];
        if(isset($params['idbanner'])) $data['idbanner'] = $params['idbanner'];
        if(isset($params['codproy'])) $data['codproy'] = $params['codproy'];
         if(isset($params['norden'])) $data['norden'] = $params['norden'];
        if(isset($params['nombre'])) $data['nombre'] = $params['nombre'];
        if(isset($params['titulo'])) $data['titulo'] = $params['titulo'];
        if(isset($params['descripcion'])) $data['descripcion'] = $params['descripcion'];
        if(isset($params['fechainicio'])) $data['fechainicio'] = $params['fechainicio'];
        if(isset($params['fechafin'])) $data['fechafin'] = $params['fechafin'];
        if(isset($params['vchusucrea'])) $data['vchusucrea'] = $params['vchusucrea'];
        if(isset($params['tmsfeccrea'])) $data['tmsfeccrea'] = $params['tmsfeccrea'];
        if(isset($params['imagenName'])) $data['imagenName'] = $params['imagenName'];

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

