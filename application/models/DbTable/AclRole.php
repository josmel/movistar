<?php

class Application_Model_DbTable_AclRole extends Core_Db_Table {

    protected $_name = 'troles_acl';
//    protected $_nameUserRoles = 'tusers_to_roles';
    protected $_primary = "id";

    const NAMETABLE = 'troles_acl';

    public function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    static function populate($params) {
        $data = array();
        if (isset($params['idrol']))$data['idrol'] = $params['idrol'];
        if (isset($params['idacl']))
            $data['idacl'] = $params['idacl'];
     
        $data = array_filter($data);
        return $data;
    }

    public function getPrimaryKey() {
        return $this->_primary;
    }

}
