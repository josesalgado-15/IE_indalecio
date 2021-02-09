<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array
require_once(__DIR__ . '/../Models/Institucion.php');
require_once(__DIR__ . '/../Models/GeneralFunctions.php');

use App\Models\GeneralFunctions;
use App\Models\Institucion;
use Carbon\Carbon;


if (!empty($_GET['action'])) { //InstitucionController.php?action=create
    InstitucionController::main($_GET['action']);
}

class InstitucionController
{
    static function main($action)
    {
        if ($action == "create") {
            InstitucionController::create();
        } else if ($action == "edit") {
            InstitucionController::edit();
        } else if ($action == "searchForID") {
            InstitucionController::searchForID($_REQUEST['id']);
        } else if ($action == "searchAll") {
            InstitucionController::getAll();
        } else if ($action == "changeStatus") {
            InstitucionController::changeStatus();
        }
    }

    static public function create()
    {
        try {

            $arrayInstitucion = array();
            $arrayInstitucion['nombre'] = $_POST['nombre'];
            $arrayInstitucion['nit'] = $_POST['nit'];
            $arrayInstitucion['direccion'] = $_POST['direccion'];
            $arrayInstitucion['municipio_id'] = $_POST['municipio_id'];
            $arrayInstitucion['rector_id'] = $_POST['rector_id'];
            $arrayInstitucion['telefono'] = $_POST['telefono'];
            $arrayInstitucion['correo'] = $_POST['correo'];
            $arrayInstitucion['estado'] = $_POST['estado'];

            $arrayInstitucion['created_at'] = Carbon::now();

            if (!Institucion::InstitucionRegistrada($arrayInstitucion['nit'] )) {
                $Institucion = new Institucion ($arrayInstitucion);
                if ($Institucion->create()) {
                    //var_dump($_POST);
                    header("Location: ../../views/modules/instituciones/index.php?accion=create&respuesta=correcto");
                }
            } else {

                header("Location: ../../views/modules/instituciones/create.php?respuesta=error&mensaje=Institucion ya creada");
            }
        } catch (Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/instituciones/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit()
    {
        try {
            $arrayInstitucion = array();
            $arrayInstitucion['nombre'] = $_POST['nombre'];
            $arrayInstitucion['nit'] = $_POST['nit'];
            $arrayInstitucion['direccion'] = $_POST['direccion'];
            $arrayInstitucion['municipio_id'] = ($_POST['municipio_id']);
            $arrayInstitucion['rector_id'] = $_POST['rector_id'];
            $arrayInstitucion['telefono'] = $_POST['telefono'];
            $arrayInstitucion['correo'] = $_POST['correo'];
            $arrayInstitucion['estado'] = $_POST['estado'];
            $arrayInstitucion['id'] = $_POST['id'];

            $institucion = new Institucion($arrayInstitucion);
            $institucion->update();

            header("Location: ../../views/modules/instituciones/index.php?id=" . $institucion->getId() . "&respuesta=correcto");

        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuario/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function searchForID($id)
    {
        try {
            return Institucion::searchForId($id);
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/instituciones/manager.php?respuesta=error");
        }
    }

    static public function getAll()
    {
        try {
            return Institucion::getAll();
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'log', 'errorStack');
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }

    static public function activate()
    {
        try {
            $ObjInstitucion = Institucion::searchForId($_GET['Id']);
            $ObjInstitucion->setEstado("Activo");
            if ($ObjInstitucion->update()) {
                header("Location: ../../views/modules/instituciones/index.php");
            } else {
                header("Location: ../../views/modules/instituciones/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuarios/index.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function inactivate()
    {
        try {
            $ObjInstitucion = Institucion::searchForId($_GET['Id']);
            $ObjInstitucion->setEstado("Inactivo");
            if ($ObjInstitucion->update()) {
                header("Location: ../../views/modules/instituciones/index.php");
            } else {
                header("Location: ../../views/modules/instituciones/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/instituciones/index.php?respuesta=error");
        }
    }

    static public function selectInstitucion($isMultiple = false,
                                             $isRequired = true,
                                             $id = "idUsuario",
                                             $nombre = "idUsuario",
                                             $defaultValue = "",
                                             $class = "form-control",
                                             $where = "",
                                             $arrExcluir = array())
    {
        $arrInstitucion = array();
        if ($where != "") {
            $base = "SELECT * FROM instituciones WHERE ";
            $arrInstitucion = Institucion::search($base . ' ' . $where);
        } else {
            $arrInstitucion = Institucion::getAll();
        }

        $htmlSelect = "<select " . (($isMultiple) ? "multiple" : "") . " " . (($isRequired) ? "required" : "") . " id= '" . $id . "' name='" . $nombre . "' class='" . $class . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (count($arrInstitucion) > 0) {
            /* @var $arrInstitucion \App\Models\Institucion[] */
            foreach ($arrInstitucion as $institucion)
                if (!InstitucionController::institucionIsInArray($id->getId(), $arrExcluir))
                    $htmlSelect .= "<option " . (($institucion != "") ? (($defaultValue == $institucion->getId()) ? "selected" : "") : "") . " value='" . $institucion->getId() . "'>" . $institucion->getDireccion() . " - " . $institucion->getNombre() . " " . $institucion->getRectorId() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function institucionIsInArray($id, $ArrInstitucion)
    {
        if (count($ArrInstitucion) > 0) {
            foreach ($ArrInstitucion as $Institucion) {
                if ($Institucion->getId() == $id) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function login (){
        try {
            if(!empty($_POST['user']) && !empty($_POST['password'])){
                $tmpUser = new Institucion();
                $respuesta = $tmpUser->Login($_POST['user'], $_POST['password']);
                if (is_a($respuesta,"App\Models\Instituciones")) {
                    $_SESSION['InstitucionInSession'] = $respuesta->jsonSerialize();
                    header("Location: ../../views/index.php");
                }else{
                    header("Location: ../../views/modules/site/login.php?respuesta=error&mensaje=".$respuesta);
                }
            }else{
                header("Location: ../../views/modules/site/login.php?respuesta=error&mensaje=Datos Vacíos");
            }
        } catch (\Exception $e) {
            header("Location: ../../views/modules/site/login.php?respuesta=error".$e->getMessage());
        }
    }

    public static function cerrarSession (){
        session_unset();
        session_destroy();
        header("Location: ../../views/modules/site/login.php");
    }
    /*
    public function buscar ($Query){
        try {
            return Persona::buscar($Query);
        } catch (Exception $e) {
            header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }
    static public function asociarEspecialidad (){
        try {
            $Persona = new Persona();
            $Persona->asociarEspecialidad($_POST['Persona'],$_POST['Especialidad']);
            header("Location: ../Vista/modules/persona/managerSpeciality.php?respuesta=correcto&id=".$_POST['Persona']);
        } catch (Exception $e) {
            header("Location: ../Vista/modules/persona/managerSpeciality.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }
    static public function eliminarEspecialidad (){
        try {
            $ObjPersona = new Persona();
            if(!empty($_GET['Persona']) && !empty($_GET['Especialidad'])){
                $ObjPersona->eliminarEspecialidad($_GET['Persona'],$_GET['Especialidad']);
            }else{
                throw new Exception('No se recibio la informacion necesaria.');
            }
            header("Location: ../Vista/modules/persona/managerSpeciality.php?id=".$_GET['Persona']);
        } catch (Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }*/

}