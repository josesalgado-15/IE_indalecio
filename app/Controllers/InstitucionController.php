<?php

namespace App\Controllers;


require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array
require_once(__DIR__ . '/../Models/Institucion.php');
require_once(__DIR__ . '/../Models/GeneralFunctions.php');

use App\Models\GeneralFunctions;
use App\Models\Institucion;


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
            $arrayInstitucion['direccion'] = $_POST['direccion'];
            $arrayInstitucion['municipios_id'] = $_POST['municipios_id'];
            $arrayInstitucion['rector'] = $_POST['rector'];
            $arrayInstitucion['telefono'] = $_POST['telefono'];
            $arrayInstitucion['correo'] = $_POST['correo'];
            $arrayInstitucion['estado'] = $_POST['estado'];

            if (!Institucion::InstitucionRegistrada($arrayInstitucion['rector'], $arrayInstitucion['telefono'])) {
                $Institucion = new Institucion($arrayInstitucion);
                if ($Institucion->create()) {
                    //var_dump($Institucion);
                    header("Location: ../../views/modules/instituciones/index.php?action=create&respuesta=correcto");
                }
            } else {
                // echo "Institucion ya registrada";
                header("Location: ../../views/modules/instituciones/create.php?respuesta=error&mensaje=Carro ya registrado");
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
            $arrayInstitucion['nombres'] = $_POST['nombres'];
            $arrayInstitucion['direccion'] = $_POST['direccion'];

            $arrayInstitucion['rector'] = $_POST['rector'];
            $arrayInstitucion['telefono'] = $_POST['telefono'];
            $arrayInstitucion['correo'] = $_POST['correo'];
            $arrayInstitucion['estado'] = $_POST['estado'];
            $arrayInstitucion['id'] = $_POST['id'];

            $Institucion = new Institucion($arrayInstitucion);
            $Institucion->update();

            header("Location: ../../views/modules/instituciones/index.php?id=" . $Institucion->getId() . "&respuesta=correcto");
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/instituciones/edit.php?respuesta=error&mensaje=".$e->getMessage());
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
            //header("Location: ../views/modules/instituciones/manager.php?respuesta=error");
        }
    }

}