<?php

class Admin_Model_Banner2 extends Core_Model {

    protected $_tableBanner;

    public function __construct() {
        $this->_tableBanner = new Application_Model_DbTable_Banner2();
    }

    public function findAllByType($idType, $visible = false, $replaceData = array()) {
        $select = $this->_tableBanner->getAdapter()->select()
                ->from(array('b' => $this->_tableBanner->getName()), array('b.idbanner', 'b.codtbanner', 'b.titulo', 'b.ImgAvanzado', 'b.ImgBasico128', 'b.ImgBasico240', 'b.ImgBasico360',
                    'b.descripcion', 'b.url', 'b.vchestado')
                )->join(array('tb' => 'ttipobanner'), "b.codtbanner = tb.codtbanner", array('carpeta' => "CONCAT(tb.codproy, '/', tb.anchoimg, 'x', tb.altoimg)")
                )->join(array('i' => 'timagen'), "b.idimagen = i.idimagen", array('imagen' => 'i.nombre')
                )->where("b.codtbanner = ?", $idType)
                ->order("b.norder ASC");
        if (!$visible)
            $select->where("b.vchestado IN ('A', 'I')");
        else
            $select->where("b.vchestado LIKE 'A'");

        $select = $select->query();
        $result = array();

        while ($row = $select->fetch()) {
            foreach ($replaceData as $key => $value)
                $row['url'] = str_replace('__' . $key . '__', $value, $row['url']);
            $result[] = $row;
        }

        $select->closeCursor();
        return $result;
    }

    public function select($id) {
        $select = $this->_tableBanner->getAdapter()->select()
                        ->from($this->_tableBanner->getName(), array('ImgAvanzado', 'ImgBasico128', 'ImgBasico240', 'ImgBasico360'))
                        ->where('vchestado LIKE ?', 'A')
                        ->where("idbanner = ?", $id)
                        ->order('norder ASC')->query();
        $result = $select->fetch();
        $select->closeCursor();
        return $result;
    }

    public function insert($params) {
        $data = array();
        if (isset($params['ImgAvanzado']))
            $data['ImgAvanzado'] = $params['ImgAvanzado'];
        if (isset($params['ImgBasico128']))
            $data['ImgBasico128'] = $params['ImgBasico128'];
        if (isset($params['ImgBasico240']))
            $data['ImgBasico240'] = $params['ImgBasico240'];
        if (isset($params['ImgBasico360']))
            $data['ImgBasico360'] = $params['ImgBasico360'];
        if (isset($params['imagenName']))
            $data['imagenName'] = $params['imagenName'];
        if (isset($params['idimagen']))
            $data['idimagen'] = $params['idimagen'];
        if (isset($params['codtbanner']))
            $data['codtbanner'] = $params['codtbanner'];
        if (isset($params['titulo']))
            $data['titulo'] = $params['titulo'];
        if (isset($params['descripcion']))
            $data['descripcion'] = $params['descripcion'];
        if (isset($params['norder']))
            $data['norder'] = $params['norder'];
        if (isset($params['url']))
            $data['url'] = $params['url'];
        if (isset($params['vchestado']))
            $data['vchestado'] = $params['vchestado'] == 1 ? 'A' : 'I';
        if (isset($params['tmsfeccrea']))
            date('Y-m-d H:i:s');
        if (isset($params['vchusucrea']))
            $data['vchusucrea'] = $params['vchusucrea'];

        $this->_tableBanner->insert($data);
        return $this->_tableBanner->getAdapter()->lastInsertId();
    }

    public function update($params, $idBanner) {
        $data = array();
        if (isset($params['ImgAvanzado']))
            $data['ImgAvanzado'] = $params['ImgAvanzado'];
        if (isset($params['ImgBasico128']))
            $data['ImgBasico128'] = $params['ImgBasico128'];
        if (isset($params['ImgBasico240']))
            $data['ImgBasico240'] = $params['ImgBasico240'];
        if (isset($params['ImgBasico360']))
            $data['ImgBasico360'] = $params['ImgBasico360'];
        if (isset($params['idimagen']))
            $data['idimagen'] = $params['idimagen'];
        if (isset($params['codtbanner']))
            $data['codtbanner'] = $params['codtbanner'];
        if (isset($params['titulo']))
            $data['titulo'] = $params['titulo'];
        if (isset($params['descripcion']))
            $data['descripcion'] = $params['descripcion'];
        if (isset($params['norder']))
            $data['norder'] = $params['norder'];
        if (isset($params['url']))
            $data['url'] = $params['url'];
        if (isset($params['vchestado']))
            $data['vchestado'] = $params['vchestado'] == 1 ? 'A' : 'I';
        if (isset($params['tmsfecmodif']))
            date('Y-m-d H:i:s');
        if (isset($params['vchusumodif']))
            $data['vchusumodif'] = $params['vchusumodif'];

        $where = $this->_tableBanner->getAdapter()->quoteInto('idbanner = ?', $idBanner);
        $this->_tableBanner->update($data, $where);
        return $this->_tableBanner->getAdapter()->lastInsertId();
    }

    public function deleteAll($notDelete = "", $idBannerType = "") {
        $where = "";
        if (!empty($notDelete))
            $where .= $this->_tableBanner->getAdapter()
                    ->quoteInto('NOT idbanner IN (?)', explode(',', $notDelete));
        if (!empty($idBannerType))
            $where .= (!empty($where) ? ' AND ' : '') .
                            $this->_tableBanner->getAdapter()
                            ->quoteInto('codtbanner LIKE ?', $idBannerType);

        $this->_tableBanner->delete($where);
    }

    public function BannersAll() {
        $select = $this->_tableBanner->getAdapter()->select()
                        // ->from($this->_tableBanner->getName(), array('titulo',"CONCAT(url, '?&banner=banner',codtbanner, '.',norder ) As url", 'codtbanner', 'ImgAvanzado', 'ImgBasico128', 'ImgBasico240', 'ImgBasico360', 'norder','descripcion'))
                        ->from($this->_tableBanner->getName(), array('titulo', 'url', 'codtbanner', 'ImgAvanzado', 'ImgBasico128', 'ImgBasico240', 'ImgBasico360', 'norder', "descripcion As integrador"))
                        ->where('vchestado LIKE ?', 'A')
//                        ->where('codtbanner  <=?', 5)
                        ->order('norder ASC')->query();
        $result = $select->fetchAll();
        $select->closeCursor();
        if (empty($result)) {
            $result = $result[0];
        }
        return $result;
    }

    public function BannersCorreo() {
        $select = $this->_tableBanner->getAdapter()->select()
                        ->from($this->_tableBanner->getName(), array('titulo', 'url', 'codtbanner', 'norder', "descripcion As integrador"))
                        ->where('vchestado LIKE ?', 'A')
//                        ->where('codtbanner  <=?', 5)
                        ->order('norder ASC')->query();
        $result = $select->fetchAll();
        $select->closeCursor();
        if (empty($result)) {
            $result = $result[0];
        }
        return $result;
    }

    
    public function BannerMovistar() {
        $select = $this->_tableBanner->getAdapter()->select()
                        ->from($this->_tableBanner->getName(), array('titulo', 'url', 'codtbanner', 'ImgAvanzado', 'ImgBasico128', 'ImgBasico240', 'ImgBasico360', 'norder', "descripcion As integrador"))
                        ->where('vchestado LIKE ?', 'A')
                        ->where('codtbanner  = ?', 11)->query();
        $result = $select->fetch();
        $select->closeCursor();
        return $result;
    }

}
