<?php

class Admin_BannerController extends Core_Controller_ActionAdmin {

    public function init() {
        parent::init();
    }

    public function indexAction() { 
        $mBannerType = new Admin_Model_BannerType();
        $mBanner = new Admin_Model_Banner2();
        $bannerTypes = $mBannerType->getPairsAll();
        $bTypeCodes = array_keys($bannerTypes);
        $selectedType = $this->getParam('type', '');
        if (empty($selectedType)) {
            $selectedType = $bTypeCodes[0];
        }
        if ($this->_request->isPost()) {
            $params = $this->getAllParams();
            $bannerType = $mBannerType->findById($selectedType);

            foreach ($_FILES["avanzado"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $nombre = $this->renombrarImage($_FILES["avanzado"]["name"][$key]);
                    move_uploaded_file($_FILES["avanzado"]["tmp_name"][$key], ROOT_IMG_DINAMIC . '/banner/avanzado/' . $nombre);
                    chmod(ROOT_IMG_DINAMIC . '/banner/avanzado/' . $nombre, 0777);
                    $_FILES["avanzado"]["name"][$key] = $nombre;
                } else {
                    $_FILES["avanzado"]["name"][$key] = $params["hiddenAvanzado"][$key];
                }
            }
            foreach ($_FILES["basico128"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $nombre = $this->renombrarImage($_FILES["basico128"]["name"][$key]);
                    move_uploaded_file($_FILES["basico128"]["tmp_name"][$key], ROOT_IMG_DINAMIC . '/banner/basico128/' . $nombre);
                    chmod(ROOT_IMG_DINAMIC . '/banner/basico128/' . $nombre, 0777);
                    $_FILES["basico128"]["name"][$key] = $nombre;
                } else {
                    $_FILES["basico128"]["name"][$key] = $params["hiddenBasico128"][$key];
                }
            }
            foreach ($_FILES["basico240"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $nombre = $this->renombrarImage($_FILES["basico240"]["name"][$key]);
                    move_uploaded_file($_FILES["basico240"]["tmp_name"][$key], ROOT_IMG_DINAMIC . '/banner/basico240/' . $nombre);
                    chmod(ROOT_IMG_DINAMIC . '/banner/basico240/' . $nombre, 0777);
                    $_FILES["basico240"]["name"][$key] = $nombre;
                } else {
                    $_FILES["basico240"]["name"][$key] = $params["hiddenBasico240"][$key];
                }
            }
            foreach ($_FILES["basico360"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $nombre = $this->renombrarImage($_FILES["basico360"]["name"][$key]);
                    move_uploaded_file($_FILES["basico360"]["tmp_name"][$key], ROOT_IMG_DINAMIC . '/banner/basico360/' . $nombre);
                    chmod(ROOT_IMG_DINAMIC . '/banner/basico360/' . $nombre, 0777);
                    $_FILES["basico360"]["name"][$key] = $nombre;
                } else {
                    $_FILES["basico360"]["name"][$key] = $params["hiddenBasico360"][$key];
                }
            }
            $params['avanzado'] = $_FILES["avanzado"]["name"];
            $params['basico128'] = $_FILES["basico128"]["name"];
            $params['basico240'] = $_FILES["basico240"]["name"];
            $params['basico360'] = $_FILES["basico360"]["name"];
            $setBannerHelper = $this->getHelper('SetBannerGroup');
            $setBannerHelper->setBanners(
                    $params, $bannerType, $this->_identity->iduser, $mBanner, new Admin_Model_Image(),$this->_config 
            );
            $Banner = $this->_config['app']['jsonBanner'];
            $this->coneccionSsh($Banner, 'BANNER');
            $this->_redirect('/admin/banner?type='.$selectedType);
        }
        $banners = $mBanner->findAllByType($selectedType);
        $this->addYosonVar('bannerType', SITE_URL . 'admin/banner?type=');
        $this->view->types = $bannerTypes;
        $this->view->selectedType = $selectedType;
        $this->view->banners = $banners;
    }

    public function bannerImageAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $form = new Core_Form_Form();

        $i = new Zend_Form_Element_File('imagen');
        $form->addElement($i);
        $form->getElement('imagen')
                ->setDestination(ROOT_IMG_DINAMIC . '/banner/origin/')
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
                        $newName = ROOT_IMG_DINAMIC . "/banner/origin/" . $nombre;
                        rename($fileName, $newName);
                    }

                    $rpta['state'] = '1';
                    $rpta['msg'] = 'Ok';
                    $rpta['code'] = $code;
                    $rpta['nombre'] = $nombre;
                    $rpta['source'] = DINAMIC_URL . "banner/origin/" . $nombre;
                }
            } catch (Exception $e) {
                $rpta['state'] = '0';
                $rpta['msg'] = 'Ocurrió un error al subir la imagen.';
            }
        }
        echo json_encode($rpta);
        exit;
    }

    

    private function renombrarImage($nombre_fichero) {
        $nombre = explode('.', $nombre_fichero);
        $ext = $nombre[count($nombre) - 1];
        unset($nombre[count($nombre) - 1]);
        $nombre = implode('_', $nombre);
        $code = Core_Utils_Utils::getRamdomChars(15, 'A');
        $nombre = $code . '.' . $ext;
        return $nombre;
    }

}
