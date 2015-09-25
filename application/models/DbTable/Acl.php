<?php

class Application_Model_DbTable_Acl extends Core_Db_Table {

    protected $_name = 'tacl';
    protected $_primary = "idacl";

    public function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    static function populate($params) {
        $data = array();
        if (isset($params['urlacl']))
            $data['urlacl'] = $params['urlacl'];
        if (isset($params['lastUpdate']))
            $data['lastUpdate'] = $params['lastUpdate'];
        if (isset($params['creatingDate']))
            $data['creatingDate'] = $params['creatingDate'];
        $data = array_filter($data);
        $data['state'] = isset($params['state']) ? $params['state'] : 1;
        return $data;
    }

    public function getWhereActive() {
        return " AND state=1 ";
    }

    public function getByRole($idRole) {
        $smt = $this->select()->from(array('a' => $this->_name))->join(array('ar' => 'troles_acl'), 'a.idacl = ar.idacl', array())
                ->where('ar.idrol = ?', $idRole)
                ->query();
        $result = $smt->fetchAll();
        $smt->closeCursor();
        return $result;
    }

    public function getPrimaryKey() {
        return $this->_primary;
    }

    public function columnDisplay() {
        return array("urlacl", "IF(state=1, 'Activo', 'Inactivo')");
    }

}
