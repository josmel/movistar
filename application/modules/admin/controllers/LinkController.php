<?php

class Admin_LinkController extends Core_Controller_ActionAdmin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $mBanner = new Admin_Model_Link();
        if ($this->_request->isPost()) {
            $params = $this->getAllParams();
            $setBannerHelper = $this->getHelper('SetTopGroup');
            $setBannerHelper->setBanners(
                    $params, $this->_identity->iduser, $mBanner, new Admin_Model_ImageLink(), $this->_config
            );
            $Link = $this->_config['app']['jsonLink'];
            $this->coneccionSsh($Link, 'LINK');
            $this->_redirect('/admin/link');
        }
        $banners = $mBanner->findAllByType();
        $this->view->banners = $banners;
    }

    public function bannerImageAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $form = new Core_Form_Form();
        $i = new Zend_Form_Element_File('imagen');
        $form->addElement($i);
        $form->getElement('imagen')
                ->setDestination(ROOT_IMG_DINAMIC . '/link/')
                ->addValidator('Size', false, 10024000) // limit to 100k
                ->addValidator('Extension', true, 'jpg,png,gif,jpeg')// only JPEG, PNG, and GIFs
                ->setRequired(false);
        $rpta = array();
        if ($this->_request->isPost()) {
            try {
                if ($form->imagen->receive()) {
                    $fileName = $form->imagen->getFileName();
                    $nombre = "";
                    $code = "";
                    if (!empty($fileName)) {
                        $fInfo = $form->imagen->getFileInfo();
                        $nombre = explode('.', $fInfo['imagen']['name']);
                        $ext = $nombre[count($nombre) - 1];
                        unset($nombre[count($nombre) - 1]);
                        $nombre = implode('_', $nombre);
                        $code = Core_Utils_Utils::getRamdomChars(15, 'A');
                        $nombre = $code . '.' . $ext;
                        $newName = ROOT_IMG_DINAMIC . "/link/" . $nombre;
                        rename($fileName, $newName);
                    }
                    $rpta['state'] = '1';
                    $rpta['msg'] = 'Ok';
                    $rpta['code'] = $code;
                    $rpta['nombre'] = $nombre;
                    $rpta['source'] = DINAMIC_URL . "link/" . $nombre;
                }
            } catch (Exception $e) {
                $rpta['state'] = '0';
                $rpta['msg'] = 'Ocurrió un error al subir la imagen.';
            }
        }
        echo json_encode($rpta);
        exit;
    }

}
