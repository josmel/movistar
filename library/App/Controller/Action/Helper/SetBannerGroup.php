<?php

class App_Controller_Action_Helper_SetBannerGroup extends Zend_Controller_Action_Helper_Abstract {

    public function setBanners($params, $bannerType, $idUser, $mBanner, $mImage,$config) {
        $links = isset($params['txtLink']) ? $params['txtLink'] : array();
        $titles = isset($params['txtTitulo']) ? $params['txtTitulo'] : array();
        $states = isset($params['chkEstado']) ? $params['chkEstado'] : array();
        $images = isset($params['txtImagen']) ? $params['txtImagen'] : array();
             $nombre = isset($params['txtNombre']) ? $params['txtNombre'] : array();
        $avanzado = isset($params['avanzado']) ? $params['avanzado'] : array();
        $basico128 = isset($params['basico128']) ? $params['basico128'] : array();
        $basico240 = isset($params['basico240']) ? $params['basico240'] : array();
        $basico360 = isset($params['basico360']) ? $params['basico360'] : array();

        $ids = "";
        $i = 1;
        foreach ($titles as $key => $title) {
            $dataItem = array();
            $dataItem['codtbanner'] = $bannerType['codtbanner'];
            $dataItem['titulo'] = $titles[$key];
            $dataItem['ImgAvanzado'] = $avanzado[$key];
            $dataItem['ImgBasico128'] = $basico128[$key];
            $dataItem['ImgBasico240'] = $basico240[$key];
            $dataItem['ImgBasico360'] = $basico360[$key];
            $dataItem['url'] = $links[$key];
            $dataItem['image'] = $images[$key];
            $dataItem['descripcion'] = $nombre[$key];
            $dataItem['vchestado'] = isset($states[$key]) ? : '0';
            $dataItem['norder'] = $i;
            $dataItem['idbanner'] = is_numeric($key) ? $key : 0;
            if ($dataItem['idbanner'] > 0) {
                //Update
                $dataItem['tmsfecmodif'] = date('Y-m-d H:i:s');
                $dataItem['vchusumodif'] = $idUser;
                $mBanner->update($dataItem, $dataItem['idbanner']);
            } else {
                if (isset($dataItem['image'])) {
                    $image = array(
                        'nombre' => $dataItem['image'],
                        'vchestado' => 1,
                        'vchusucrea' => $idUser
                    );

                    $dataItem['idimagen'] = $mImage->insert($image);
                }
                //Registrar
                $dataItem['tmsfeccrea'] = date('Y-m-d H:i:s');
                $dataItem['vchusucrea'] = $idUser;
                $dataItem['idbanner'] = $mBanner->insert($dataItem);
            }

            $i++;
            $ids = $ids . ($ids != '' ? ',' : '') . $dataItem['idbanner'];
        }
//        $this->coneccionSshImg($ids, $mBanner, $config);
        $mBanner->deleteAll($ids, $bannerType['codtbanner']);
    }

    function coneccionSshImg($ids, $mBanner, $config) {

        $porciones = explode(",", $ids);
        foreach ($porciones as $value) {
            $dataBanner = $mBanner->select($value);
            $avanzado = ROOT_IMG_DINAMIC . '/banner/avanzado/' . $dataBanner ["ImgAvanzado"];
            $basico128 = ROOT_IMG_DINAMIC . '/banner/basico128/' . $dataBanner ["ImgBasico128"];
            $basico240 = ROOT_IMG_DINAMIC . '/banner/basico240/' . $dataBanner ["ImgBasico240"];
            $basico360 = ROOT_IMG_DINAMIC . '/banner/basico360/' . $dataBanner ["ImgBasico360"];
            if (!function_exists("ssh2_connect"))
                die("function ssh2_connect doesn't exist");
            if (!($con = ssh2_connect($config['app']['server'], $config['app']['puerto']))) {
                echo "fail: unable to establish connection\n";
            } else {
                if (!ssh2_auth_password($con, $config['app']['user'], $config['app']['pass'])) {
                    echo "fail: unable to authenticate\n";
                } else {
                    ssh2_scp_send($con, $avanzado, $config['app']['rutaImg'] . 'banner/avanzado/' . $dataBanner ["ImgAvanzado"], 0644);
                    ssh2_scp_send($con, $basico128, $config['app']['rutaImg'] . 'banner/basico128/' . $dataBanner ["ImgBasico128"], 0644);
                    ssh2_scp_send($con, $basico240, $config['app']['rutaImg'] . 'banner/basico240/' . $dataBanner ["ImgBasico240"], 0644);
                    ssh2_scp_send($con, $basico360, $config['app']['rutaImg'] . 'banner/basico360/' . $dataBanner ["ImgBasico360"], 0644);
                }
                ssh2_exec( $con, 'exit' );
            }
        }
        return;
    }

}
