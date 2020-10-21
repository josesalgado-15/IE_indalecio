<?php

namespace App\Controllers;
require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array
require_once(__DIR__ . '/../Models/Institucion.php');
require_once(__DIR__ . '/../Models/GeneralFunctions.php');

use App\Models\GeneralFunctions;
use App\Models\Institucion;


if (!empty($_GET['action'])) { //CarroController.php?action=create
   InstiController::main($_GET['action']);
}

class InstiController
{
    static function main($action)
    {
        if ($action == "create") {
            InstiController::create();
        } else if ($action == "edit") {
            InstiController::edit();
        } else if ($action == "searchForID") {
            InstiController::searchForID($_REQUEST['id']);
        } else if ($action == "searchAll") {
            InstiController::getAll();
        } else if ($action == "changeStatus") {
            InstiController::changeStatus();
        }
    }

    static public function create()
    {
        try {

            $arrayInsti = array();
            $arrayInsti['nombres'] = $_POST['nombres'];
            $arrayInsti['direccion'] = $_POST['direccion'];
            /*
            $arrayInsti['municipios_id'] = $_POST['municipios_id'];
            */
            $arrayInsti['rector'] = $_POST['rector'];
            $arrayInsti['telefono'] = $_POST['telefono'];
            $arrayInsti['correo'] = $_POST['correo'];
            $arrayInsti['estado'] = $_POST['estado'];

            if (!Institucion::InstiRegistrada($arrayInsti['marca'], $arrayInsti['anno'])) {
                $Insti1 = new Institucion($arrayInsti);
                if ($Insti1->save()) {
                    //var_dump($Carro);
                    header("Location: ../../views/modules/instituciones/index.php?action=create&respuesta=correcto");
                }
            } else {
                // echo "Carro ya registrado";
                header("Location: ../../views/modules/instituciones/create.php?respuesta=error&mensaje=Carro ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuarios/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }
    static public function edit()
    {
        try {
            $arrayInsti = array();
            $arrayInsti['nombres'] = $_POST['nombres'];
            $arrayInsti['direccion'] = $_POST['direccion'];
            /*
            $arrayInsti['municipios_id'] = $_POST['municipios_id'];
            */
            $arrayInsti['rector'] = $_POST['rector'];
            $arrayInsti['telefono'] = $_POST['telefono'];
            $arrayInsti['correo'] = $_POST['correo'];
            $arrayInsti['estado'] = $_POST['estado'];

            $Insti1 = new Institucion($arrayInsti);
            $Insti1->update();

            header("Location: ../../views/modules/carro/index.php?id=" . $Insti1->getId() . "&respuesta=correcto");
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuarios/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }
    static public function searchForID($id)
    {
        try {
            return Institucion::searchForId($id);
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuarios/manager.php?respuesta=error");
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






}