<?php

class App_Controller_Action_Helper_SetTopGroup extends Zend_Controller_Action_Helper_Abstract {

    public function setBanners($params, $idUser, $mLink, $mImage, $config) {
        $links = isset($params['txtLink']) ? $params['txtLink'] : array();
        $titles = isset($params['txtTitulo']) ? $params['txtTitulo'] : array();
        $states = isset($params['chkEstado']) ? $params['chkEstado'] : array();
        $images = isset($params['txtImagen']) ? $params['txtImagen'] : array();

        $ids = "";
        $i = 1;
        foreach ($titles as $key => $title) {
            $dataItem = array();
            $dataItem['descripcion'] = $titles[$key];
            $dataItem['url'] = $links[$key];
            $dataItem['image'] = $images[$key];
            $dataItem['vchestado'] = isset($states[$key]) ? : '0';
            $dataItem['norder'] = $i;
            $dataItem['idlink'] = is_numeric($key) ? $key : 0;
            if ($dataItem['idlink'] > 0) {
                //Update
                $dataItem['vchusumodif'] = $idUser;
                $mLink->update($dataItem, $dataItem['idlink']);
            } else {
                if (isset($dataItem['image'])) {
//                    $resize = new Core_Utils_ResizeImage(
//                            ROOT_IMG_DINAMIC.'/banner/origin/'.$dataItem['image']
//                        );
//
//                    $resize->resizeImage(
//                            $bannerType['anchoimg'], $bannerType['altoimg'], 
//                            'exact'
//                        );
//                    
//                    $destinyFolder = ROOT_IMG_DINAMIC.'/banner/'.$bannerType['codproy']
//                        .'/'.$bannerType['anchoimg'].'x'.$bannerType['altoimg'];
//                    if(!file_exists($destinyFolder))
//                        mkdir($destinyFolder, 0777, true);
//                        
//                    $resize->saveImage($destinyFolder.'/'.$dataItem['image']);

                    $image = array(
                        'nombre' => $dataItem['image'],
                        'vchestado' => 1,
                        'vchusucrea' => $idUser
                    );

                    $dataItem['idtimagenlink'] = $mImage->insert($image);
                }

                //Registrar
                $dataItem['tmsfeccrea'] = date('Y-m-d H:i:s');
                $dataItem['vchusucrea'] = $idUser;
                $dataItem['idlink'] = $mLink->insert($dataItem);
            }

            $i++;
            $ids = $ids . ($ids != '' ? ',' : '') . $dataItem['idlink'];
        }
        $this->coneccionSshImg($ids, $mLink, $config);
        $mLink->deleteAll($ids);
    }

    function coneccionSshImg($ids, $mLink, $config) {

        $porciones = explode(",", $ids);
        foreach ($porciones as $value) {
            $dataLink = $mLink->select($value);
            if ($dataLink) {
                $avanzado = ROOT_IMG_DINAMIC . '/link/' . $dataLink ["imagen"];
                if (!function_exists("ssh2_connect"))
                    die("function ssh2_connect doesn't exist");
                if (!($con = ssh2_connect($config['app']['server'], $config['app']['puerto']))) {
                    echo "fail: unable to establish connection\n";
                } else {
                    if (!ssh2_auth_password($con, $config['app']['user'], $config['app']['pass'])) {
                        echo "fail: unable to authenticate\n";
                    } else {
                        ssh2_scp_send($con, $avanzado, $config['app']['rutaImg'] . 'link/' . $dataLink ["imagen"], 0644);
                    }
                    ssh2_exec($con, 'exit');
                }
            }
        }
        return;
    }

}
