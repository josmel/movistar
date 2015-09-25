<?php

class Admin_Model_Link extends Core_Model
{
    protected $_tableLink; 
    
    public function __construct() {
        $this->_tableLink = new Application_Model_DbTable_Link();
    }    
  
    
    public function findAllByType( $visible = false, $replaceData = array()) {
        $select = $this->_tableLink->getAdapter()->select()
                ->from(array('b' => $this->_tableLink->getName()), 
                       array('b.idlink',
                             'b.descripcion', 'b.url', 'b.vchestado')
                )->join(array('i' => 'timagenlink'), 
                        "b.idtimagenlink = i.idtimagenlink", 
                        array('imagen' => 'i.nombre')
                ) 
                ->order("b.norder ASC");
        if (!$visible) $select->where("b.vchestado IN ('A', 'I')");
        else $select->where("b.vchestado LIKE 'A'");
        $select = $select->query();
        $result = array();
        while($row = $select->fetch()) {
            foreach($replaceData as $key => $value)
                $row['url'] = str_replace('__'.$key.'__', $value, $row['url']);
            $result[] = $row;
        }
        $select->closeCursor();
        return $result;
    }
    
    
    
    public function select($id) {
         $select = $this->_tableLink->getAdapter()->select()
                ->from(array('b' => $this->_tableLink->getName()), 
                       array()
                )->join(array('i' => 'timagenlink'), 
                        "b.idtimagenlink = i.idtimagenlink", 
                        array('imagen' => 'i.nombre')
                ) ->where("b.vchestado LIKE 'A'")
            ->where("idlink = ?", $id)->query(); 
        $result = $select->fetch();
        $select->closeCursor();
        return $result;
    }
    
    
    public function insert($params) {
        $data = array();
        if(isset($params['idtimagenlink'])) $data['idtimagenlink'] = $params['idtimagenlink'];
        if(isset($params['codtbanner'])) $data['codtbanner'] = $params['codtbanner'];
        if(isset($params['titulo'])) $data['titulo'] = $params['titulo'];
        if(isset($params['descripcion'])) $data['descripcion'] = $params['descripcion'];
        if(isset($params['norder'])) $data['norder'] = $params['norder'];
        if(isset($params['url'])) $data['url'] = $params['url'];
        if(isset($params['vchestado']))
            $data['vchestado'] = $params['vchestado'] == 1 ? 'A' : 'I';
        if(isset($params['vchusucrea'])) $data['vchusucrea'] = $params['vchusucrea'];
        $data['fecha_creacion']= date('Y-m-d H:i:s');
        $this->_tableLink->insert($data);
        return $this->_tableLink->getAdapter()->lastInsertId();
    }
    
    public function update($params, $idlink) {
        $data = array();
        if(isset($params['idtimagenlink'])) $data['idtimagenlink'] = $params['idtimagenlink'];
        if(isset($params['titulo'])) $data['titulo'] = $params['titulo'];
        if(isset($params['descripcion'])) $data['descripcion'] = $params['descripcion'];
        if(isset($params['norder'])) $data['norder'] = $params['norder'];
        if(isset($params['url'])) $data['url'] = $params['url'];
        if(isset($params['vchestado'])) 
            $data['vchestado'] = $params['vchestado'] == 1 ? 'A' : 'I';
        if(isset($params['vchusumodif'])) $data['vchusumodif'] = $params['vchusumodif'];
        $data['fecha_edicion']= date('Y-m-d H:i:s');
        $where = $this->_tableLink->getAdapter()->quoteInto('idlink = ?', $idlink);
        $this->_tableLink->update($data, $where);
        return $this->_tableLink->getAdapter()->lastInsertId();
    }
    
    public function deleteAll($notDelete = "") {
       
        $where = "";
        if(!empty($notDelete))
            $where .= $this->_tableLink->getAdapter()
                          ->quoteInto('NOT idlink IN (?)', explode(',', $notDelete));
        
        $this->_tableLink->delete($where);
    }
    
      public function BannersAll() {
        $select = $this->_tableLink->getAdapter()->select()
                        ->from($this->_tableLink->getName(), array('titulo', 'url','norder'))
                        ->where('vchestado LIKE ?', 'A')
                        ->order('norder ASC')->query();
        $result = $select->fetchAll();
        $select->closeCursor();
        if (empty($result)) {
            $result = $result[0];
        }
        return $result;
    }
}
