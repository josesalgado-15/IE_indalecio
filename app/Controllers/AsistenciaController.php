<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array
require_once(__DIR__ . '/../Models/Asistencia.php');
require_once(__DIR__ . '/../Models/Usuario.php');
require_once(__DIR__ . '/../Models/GeneralFunctions.php');

use App\Models\GeneralFunctions;
use App\Models\Asistencia;
use App\Models\Usuario;
use Carbon\Carbon;


if (!empty($_GET['action'])) {
    AsistenciaController::main($_GET['action']);
}

class AsistenciaController
{

    static function main($action)
    {
        if ($action == "create") {
            AsistenciaController::create();
        } else if ($action == "edit") {
            AsistenciaController::edit();
        } else if ($action == "searchForID") {
            AsistenciaController::searchForID($_REQUEST['idPersona']);
        } else if ($action == "searchAll") {
            AsistenciaController::getAll();
        } else if ($action == "changeStatus") {
            AsistenciaController::changeStatus();
        }

    }

    static public function create()
    {
        try {
            $arrayAsistencia = array();

            //Pendiente preguntar si la fecha se definira sola o el usuario la define
            $arrayAsistencia['fecha'] = $_POST['fecha'];
            $arrayAsistencia['hora_ingreso'] = $_POST['hora_ingreso'];
            $arrayAsistencia['observacion'] = $_POST['observacion'];
            $arrayAsistencia['tipo_ingreso'] = $_POST['tipo_ingreso'];
            $arrayAsistencia['hora_salida'] = $_POST['hora_salida'];
            $arrayAsistencia['usuarios_id'] = Usuario::searchForId($_POST['usuarios_id']);
            $arrayAsistencia['estado'] = 'Activo';
            $arrayAsistencia['hora_ingreso'] = $formated_time = date("H:i:s", strtotime($arrayAsistencia['hora_ingreso']));
            //$arrayAsistencia['created_at'] = Carbon::now(); //Fecha Actual


            //PENDIENTE PREGUNTAR COMO DEFINIR LAS 3 CONDICIONES DE FECHA, HORA_INGRESO Y USUARIOS_ID
            if (!Asistencia::asistenciaRegistrada($arrayAsistencia['fecha'], $arrayAsistencia['hora_ingreso'])) {
                $Asistencia = new Asistencia ($arrayAsistencia);
                if ($Asistencia->create()) {
                    //var_dump($_POST);
                    header("Location: ../../views/modules/asistencia/index.php?accion=create&respuesta=correcto");
                }
            } else {
                header("Location: ../../views/modules/asistencia/create.php?respuesta=error&mensaje=Asistencia ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuarios/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit()
    {
        try {

            $arrayAsistencia = array();


            //Pendiente preguntar si la fecha se definira sola o el usuario la define

            $arrayAsistencia['fecha'] = $_POST['fecha'];
            $arrayAsistencia['hora_ingreso'] = $_POST['hora_ingreso'];
            $arrayAsistencia['observacion'] = $_POST['observacion'];
            $arrayAsistencia['tipo_ingreso'] = $_POST['tipo_ingreso'];
            $arrayAsistencia['hora_salida'] = $_POST['hora_salida'];
            $arrayAsistencia['usuarios_id'] = Usuario::searchForId($_POST['usuarios_id']);
            $arrayAsistencia['estado'] = $_POST['estado'];
            $arrayAsistencia['hora_ingreso'] = $formated_time = date("H:i:s", strtotime($arrayAsistencia['hora_ingreso']));
            //$arrayAsistencia['created_at'] = Carbon::now(); //Fecha Actual
            $arrayAsistencia['id'] = $_POST['id'];


            $asistencia = new Asistencia($arrayAsistencia);
            $asistencia->update();

            header("Location: ../../views/modules/asistencia/show.php?id=" . $asistencia->getId() . "&respuesta=correcto");

        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuario/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function searchForID($id)
    {
        try {
            return Asistencia::searchForId($id);
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuarios/manager.php?respuesta=error");
        }
    }

    static public function getAll()
    {
        try {
            return Asistencia::getAll();
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'log', 'errorStack');
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }



    static public function selectAsistencia($isMultiple = false,
                                            $isRequired = true,
                                            $id = "idAsistencia",
                                            $nombre = "idAsistencia",
                                            $defaultValue = "",
                                            $class = "form-control",
                                            $where = "",
                                            $arrExcluir = array())
    {
        $arrAsistencias = array();
        if ($where != "") {
            $base = "SELECT * FROM asistencias WHERE ";
            $arrAsistencias = Asistencia::search($base . ' ' . $where);
        } else {
            $arrAsistencias = Asistencia::getAll();
        }

        $htmlSelect = "<select " . (($isMultiple) ? "multiple" : "") . " " . (($isRequired) ? "required" : "") . " id= '" . $id . "' name='" . $nombre . "' class='" . $class . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (count($arrAsistencias) > 0) {
            /* @var $arrAsistencias \App\Models\Asistencia[] */
            foreach ($arrAsistencias as $asistencia)
                if (!AsistenciaController::asistenciaIsInArray($asistencia->getId(), $arrExcluir))
                    $htmlSelect .= "<option " . (($asistencia != "") ? (($defaultValue == $asistencia->getId()) ? "selected" : "") : "") . " value='" . $asistencia->getId() . "'>" . $asistencia->getUsuariosId()->getNombres(). " ". $asistencia->getUsuariosId()->getApellidos(). " - ". $asistencia->getFecha() . " - " . $asistencia->getTipoIngreso() . " - " . $asistencia->getHoraIngreso() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }


    public static function asistenciaIsInArray($idAsistencia, $arrAsistencias)
    {
        if (count($arrAsistencias) > 0) {
            foreach ($arrAsistencias as $asistencia) {
                if ($asistencia->getId() == $idAsistencia) {
                    return true;
                }
            }
        }
        return false;
    }
}