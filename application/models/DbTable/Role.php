<?php

class Application_Model_DbTable_Role extends Core_Db_Table {

    protected $_name = 'troles';
    protected $_primary = "idrol";

//    protected $_nameRoleAcls = 'troles_acl';
    const NAMETABLE = 'troles';

    public function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    static function populate($params) {
        $data = array();
        if (isset($params['idrol']))
            $data['idrol'] = $params['idrol'];
        if (isset($params['desrol']))
            $data['desrol'] = $params['desrol'];
        if (isset($params['name']))
            $data['name'] = $params['name'];
        if (isset($params['lastUpdate']))
            $data['lastUpdate'] = $params['lastUpdate'];
        if (isset($params['creatingDate']))
            $data['creatingDate'] = $params['creatingDate'];
        if (isset($params['grado']))
            $data['grado'] = $params['grado'];
//        if(isset($params['acls'])) $data['acls'] = $params['acls'];
        $data = array_filter($data);
        $data['state'] = isset($params['state']) ? $params['state'] : 1;
        return $data;
    }

//    public function insert(array $data) {
//        $acls = $data['acls'];
//        unset($data['acls']);
//        parent::insert($data);
//        
//        $idRole = $this->_db->lastInsertId();
//        $this->addAcls($idRole, $acls);     
//    }
//    public function update(array $data, $where) {
//        $acls = array();
//        if(isset($data['acls'])) {
//            $acls = $data['acls'];
//            unset($data['acls']);       
//            $idRole = $data[$this->_primary];
//            $this->addAcls($idRole, $acls); 
//        }
//        parent::update($data, $where);
//                
//    }
//    
//    private function addAcls($idRole, $acls) {
//        $this->_db->delete($this->_nameRoleAcls, $this->_db->quoteInto('idrol = ?', $idRole));
//        foreach($acls as $idAcl) {
//            $this->_db->insert($this->_nameRoleAcls, array('idrol' => $idRole, 'idacl' => $idAcl));
//        }
//    }

    public function getByUser($idUser) {
        $smt = $this->select()->from(array('r' => $this->_name))->join(array('ur' => 'tusers'), 'r.idrol = ur.idrol', array())
                ->where('iduser = ?', $idUser)
                // ->where('state = 1')
                ->query();

        $result = $smt->fetchAll();
        $smt->closeCursor();

        return $result;
    }

    /**
     * 
     * @param obj DB $resulQuery
     */
    public function columnDisplay() {
        return array("name", "IF(state=1, 'Activo', 'Inactivo')");
    }

    public function getPrimaryKey() {
        return $this->_primary;
    }

    public function getWhereActive() {
        return " AND state= 1";
    }

}
