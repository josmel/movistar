<?php

class Core_Controller_ActionAdmin extends Core_Controller_Action {

    protected $_identity;

    public function init() {
        parent::init();
        $this->_helper->layout->setLayout('layout-admin');
        $this->_mailHelper = $this->_helper->getHelper('Mail');
        $this->_serverSoap = new Zend_Soap_Client($this->_config['resources']['view']['urlSoapWsdl']);
    }

    public function preDispatch() {
        parent::preDispatch();
        $this->permisos();
        $this->_identity = Zend_Auth::getInstance()->getIdentity();
//        $this->view->menu = $this->getMenu();
        $this->view->identity = $this->_identity;
    }

    function permisos() {
        $auth = Zend_Auth::getInstance();
        $controller = $this->_request->getControllerName();
        if ($auth->hasIdentity()) {
            $user = $auth->getIdentity();
            $modelAcl = new Application_Model_Acl();
            $aclsRole = $modelAcl->getAclByRole($user->idrol);
            foreach ($aclsRole as $permission) {
                $actions[] = explode('::', $permission);
            }
            $this->view->menu = $this->getMenuAdmin($actions);
        } else {
//            if ($this->_request->getModuleName() == 'preview') {
//                if (!$auth->hasIdentity()) {
//                    $this->_redirect('/');
//                }
//            }
            if ($controller != 'index') {
                $this->_redirect('/');
            }
        }
    }

     function getMenuAdmin($actions) {
        $menu['dashboard'] = array('class' => 'icad-dashb', 'url' => '/admin/dashboard', 'title' => 'DASHBOARD');
        foreach ($actions as $role => $parents) {
            $menu[$parents[1]] = array('class' => 'icad-prom', 'url' => '/' . $parents[0] . '/' . $parents[1], 'title' => $parents[1]);
        }
        return $menu;
    }
    
    function coneccionSshImg($nane, $tipo) {
        switch ($tipo) {
            case 'LINK':
                $avanzado = ROOT_IMG_DINAMIC . '/link/' . $nane;
                break;
            case 'SERVICIO':
                $avanzado = ROOT_IMG_DINAMIC . '/servicio/' . $nane;
                break;
            case 'MUSICA':
                $avanzado = ROOT_IMG_DINAMIC . '/musica/avanzado/' . $nane;
                $basico360 = ROOT_IMG_DINAMIC . '/musica/basico360/' . $nane;
                break;
            case 'JUEGO':
                $avanzado = ROOT_IMG_DINAMIC . '/juego/avanzado/' . $nane;
                $basico360 = ROOT_IMG_DINAMIC . '/juego/basico360/' . $nane;
                break;
            default:
                break;
        }
//        if (!function_exists("ssh2_connect"))
//            die("function ssh2_connect doesn't exist");
//        if (!($con = ssh2_connect($this->_config['app']['server'], $this->_config['app']['puerto']))) {
////            $this->_flashMessenger->info('No se puede establecer conexión. Comuniquese con el administrador.'); 
//        } else {
//            if (!ssh2_auth_password($con, $this->_config['app']['user'], $this->_config['app']['pass'])) {
////                  $this->_flashMessenger->info('Error al autentificarse, intentelo nuevamente ó comuniquese con el administrador.');           
//            } else {
//                switch ($tipo) {
//                    case 'LINK':
//                        ssh2_scp_send($con, $avanzado, $this->_config['app']['rutaImg'] . 'link/' . $nane, 0644);
//                        break;
//                    case 'SERVICIO':
//                        ssh2_scp_send($con, $avanzado, $this->_config['app']['rutaImg'] . 'servicio/' . $nane, 0644);
//                        break;
//                    case 'MUSICA':
//                        ssh2_scp_send($con, $avanzado, $this->_config['app']['rutaImg'] . 'musica/avanzado/' . $nane, 0644);
//                        ssh2_scp_send($con, $basico360, $this->_config['app']['rutaImg'] . 'musica/basico360/' . $nane, 0644);
//                        break;
//                    case 'JUEGO':
//                        ssh2_scp_send($con, $avanzado, $this->_config['app']['rutaImg'] . 'juego/avanzado/' . $nane, 0644);
//                        ssh2_scp_send($con, $basico360, $this->_config['app']['rutaImg'] . 'juego/basico360/' . $nane, 0644);
//                        break;
//                    default:
//                        break;
//                }
////                 $this->_flashMessenger->info('Los cambios se realizaron correctamente.');
//                ssh2_exec($con, 'exit');
//            }
//        }
        return;
    }

    function coneccionSsh($ruta, $nane) {
        $Data = $this->_serverSoap->estructuraValores($nane);
        $fp = fopen($ruta, "w")
                or die("Error al abrir fichero de salida");
        fwrite($fp, json_encode($Data, 128));  //JSON_PRETTY_PRINT=128
        fclose($fp);

//        if (!function_exists("ssh2_connect"))
//            die("function ssh2_connect doesn't exist");
//        if (!($con = ssh2_connect($this->_config['app']['server'], $this->_config['app']['puerto']))) {
//            $this->_flashMessenger->info('No se puede establecer conexión. Comuniquese con el administrador.');
//        } else {
//            if (!ssh2_auth_password($con, $this->_config['app']['user'], $this->_config['app']['pass'])) {
//                $this->_flashMessenger->info('Error al autentificarse, intentelo nuevamente ó comuniquese con el administrador.');
//            } else {
//                ssh2_scp_send($con, $ruta, $this->_config['app']['rutaJson'] . $nane . '.json', 0644);
//                ssh2_exec($con, 'exit');
//                $this->_flashMessenger->info('Los cambios se realizaron correctamente.');
//            }
//        }
        $this->correo($nane, $Data);
        return;
    }

    function correo($seccion, $Data) {
        if($seccion=='BANNER'):
            $Data=$this->_serverSoap->receiveMessage('BANNERCORREO');
        endif;
        try {
            $sendMail = array(
                'seccion' => $seccion,
                'cuerpo' => $Data
            );
            $this->_mailHelper->correoAlerta($sendMail);
        } catch (Exception $e) {
            $this->_flashMessage->error($e->getMessage());
        }
    }

    function getMenuDos() {
        $menu = array(
            'dashboard' =>
            array('class' => 'icad-dashb', 'url' => '/dashboard', 'title' => 'Dashboard'),
            'banner' =>
            array('class' => 'icad-prom', 'url' => '/admin/banner', 'title' => 'BANNERS '),
            'text' =>
            array('class' => 'icad-prom', 'url' => '/admin/text', 'title' => 'TEXT LINK')
        );
        return $menu;
    }

    function getMenu() {
        $menu = array(
            'dashboard' =>
            array('class' => 'icad-dashb', 'url' => '/dashboard', 'title' => 'DASHBOARD'),
            'banner2' =>
            array('class' => 'icad-prom', 'url' => '/admin/banner2', 'title' => 'BANNERS'),
            'servicio' =>
            array('class' => 'icad-prom', 'url' => '/admin/servicio', 'title' => 'SERVICIOS'),
            'musica' =>
            array('class' => 'icad-prom', 'url' => '/admin/musica', 'title' => 'MÚSICA'),
            'juego' =>
            array('class' => 'icad-prom', 'url' => '/admin/juego', 'title' => 'JUEGOS'),
            'text' =>
            array('class' => 'icad-prom', 'url' => '/admin/text', 'title' => 'TEXT LINK'),
            'link' =>
            array('class' => 'icad-prom', 'url' => '/admin/link', 'title' => 'LINKS '),
        );
        return $menu;
    }

    public function auth($usuario, $password, $url = null) {
        $dbAdapter = Zend_Registry::get('multidb');
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        $authAdapter
                ->setTableName('tusers')
                ->setIdentityColumn('login')
                ->setCredentialColumn('password')
                ->setIdentity($usuario)
                ->setCredential($password);
        try {
            $select = $authAdapter->getDbSelect();
            $select->where('state = 1');
            //echo $select->assemble(); //exit;
            //var_dump($authAdapter); exit;
            $result = Zend_Auth::getInstance()->authenticate($authAdapter);
            //var_dump($result); exit;
            if ($result->isValid()) {
                $storage = Zend_Auth::getInstance()->getStorage();
                $bddResultRow = $authAdapter->getResultRowObject();
                $storage->write($bddResultRow);
                $msj = 'Bienvenido Usuario ' . $result->getIdentity();
                //$this->_flashMessenger->success($msj);
                $this->_identity = Zend_Auth::getInstance()->getIdentity();
                if (!empty($url)) {
                    $this->_redirect($url);
                }
                $return = true;
            } else {
                switch ($result->getCode()) {
                    case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
                        $msj = 'El usuario no existe';
                        break;
                    case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
                        $msj = 'Password incorrecto';
                        break;
                    case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
                        $msj = 'dsdsdsd';
                        break;
                    default:
                        $msj = 'Datos incorrectos';
                        break;
                }
                $this->_flashMessenger->warning($msj);
                $return = false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }

        return $return;
    }

}
