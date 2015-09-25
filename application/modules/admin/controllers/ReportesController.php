<?php

class Admin_ReportesController extends Core_Controller_ActionAdmin {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $numeroSemana = $this->obtenerSemanaAMostrar();
        $LunesPasado = $this->obtenerLunes();
        $fechaAtual = date('Y-m-d');
        if ($fechaAtual == $LunesPasado):
            $titulo = "Datos de la Última Semana";
        else:
            $titulo = "Datos de la Actual Semana";
        endif;
        $this->view->titulo = $titulo;
        $this->addYosonVar('semana', $numeroSemana);
    }

    public function visitasAction() {
        $numeroSemana = $this->obtenerSemanaAMostrar();
        $idSemana = $this->_getParam('semana', $numeroSemana);
        $alter = $this->_getParam('alter');
        $top = $this->_getParam('top');
        $resultados = $this->genericoSemana($idSemana, $alter, $top, $numeroSemana);
        $this->addYosonVar('semana', $resultados[2]);
        $this->view->semanas = $resultados[0];
        $this->view->tituloSemana = $resultados[1];
    }

    public function bannersAction() {
        $numeroSemana = $this->obtenerSemanaAMostrar();
        $idSemana = $this->_getParam('semana', $numeroSemana);
        $alter = $this->_getParam('alter');
        $top = $this->_getParam('top');
        $resultados = $this->genericoSemana($idSemana, $alter, $top, $numeroSemana);
        $this->addYosonVar('semana', $resultados[2]);
        $this->view->semanas = $resultados[0];
        $this->view->tituloSemana = $resultados[1];
    }

    public function totalAction() {
        $numeroSemana = $this->obtenerSemanaAMostrar();
        $idSemana = $this->_getParam('semana', $numeroSemana);
        $alter = $this->_getParam('alter');
        $top = $this->_getParam('top');
        $resultados = $this->genericoSemana($idSemana, $alter, $top, $numeroSemana);
        $this->addYosonVar('semana', $resultados[2]);
        $this->view->semanas = $resultados[0];
        $this->view->tituloSemana = $resultados[1];
    }

    public function genericoSemana($idSemana, $alter, $top, $numeroSemana) {
        $year = date("Y");
        if ($idSemana > $numeroSemana or $idSemana <= 0) {
            $this->_redirect("/admin/reportes/");
        } else {
            $resultadosSemana = $this->obtenerFechas($idSemana, $year, $alter, $top);
        }
        if (strlen($idSemana) == 1) {
            $idSemana = '0' . $idSemana;
        }
        $titulo = "Semana: " . $idSemana . " del " . $resultadosSemana[1] . " al " . $resultadosSemana[2];
        return array($resultadosSemana[0], $titulo, $idSemana);
    }

    public function obtenerFechas($idSemanaOrigen, $year, $alter, $top) {
        $numeroSemana = $this->obtenerSemanaAMostrar();
        if (isset($alter)) {
            if ($alter == 2) {
                $idSemana = $idSemanaOrigen;
            } elseif ($alter == 1) {
                $idSemana = $idSemanaOrigen + 4;
            }
        } else {
            if (isset($top)) {
                $idSemana = $top;
            } else {
                $idSemana = $numeroSemana;
            }
        }
        for ($i = $idSemana - 4; $i <= $idSemana; $i++) {
            $arrayDeSemanas[] = $i;
        }
        $timestamp = mktime(0, 0, 0, 1, 1, $year);
        $timestamp+=$idSemanaOrigen * 7 * 24 * 60 * 60;
        $ultimoDia = $timestamp - date("w", mktime(0, 0, 0, 1, 1, $year)) * 24 * 60 * 60;
        $primerDia = $ultimoDia - 86400 * (date('N', $ultimoDia) - 1);
        return array($arrayDeSemanas, date("d-m-Y", $primerDia), date("d-m-Y", $ultimoDia));
    }

    public function anualAction() {
        
    }

    public function probandoAction() {

        $this->addYosonVar('semana', 19);
    }

    function obtenerSemanaAMostrar() {
        $LunesPasado = $this->obtenerLunes();
        $fechaAtual = date('Y-m-d');
        if ($fechaAtual == $LunesPasado):
            $numeroSemana = (date("W") - 1);
        else:
            $numeroSemana = date("W");
        endif;
        return $numeroSemana;
    }

    function obtenerLunes() {
        $unix = date("U"); /// esto nos convierte la fecha de hoy en Unix
        switch (date("w")) { /// segun el dia de la semana damos un valor en seg a $dia
            case 0:
                $dia = 518400;
                break;
            case 1:
                $dia = 0;
                break;
            case 2:
                $dia = 86400;
                break;
            case 3:
                $dia = 172800;
                break;
            case 4:
                $dia = 259200;
                break;
            case 5:
                $dia = 345600;
                break;
            case 6:
                $dia = 432000;
                break;
        }//switch
        $inicio_semana = ($unix - $dia); ///restamos la fecha de hoy con $dia y nos dara la fecha del lunes pasado
        $LunesPasado = date("Y-m-d", $inicio_semana); ///pasamos la fecha en unix a el formato normal
        return $LunesPasado;
    }

}
