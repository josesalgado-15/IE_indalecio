<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array
require_once(__DIR__ . '/../Models/Novedad.php');
require_once(__DIR__ . '/../Models/GeneralFunctions.php');

use App\Models\GeneralFunctions;
use App\Models\Novedad;
use Carbon\Carbon;

if (!empty($_GET['action'])) {
    NovedadController::main($_GET['action']);
}

class NovedadController
{

    static function main($action)
    {
        if ($action == "create") {
            NovedadController::create();
        } else if ($action == "edit") {
            NovedadController::edit();
        } else if ($action == "searchForID") {
            NovedadController::searchForID($_REQUEST['idPersona']);
        } else if ($action == "searchAll") {
            NovedadController::getAll();
        } else if ($action == "changeStatus") {
            NovedadController::changeStatus();
        }

    }

    static public function create()
    {
        try {

            $arrayNovedad = array();
            $arrayNovedad['tipo'] = $_POST['tipo'];
            $arrayNovedad['justificacion'] = $_POST['justificacion'];
            $arrayNovedad['observacion'] = $_POST['observacion'];
            $arrayNovedad['estado'] = 'Activo';
            $arrayNovedad['administrador_id'] = $_POST['administrador_id'];
            $arrayNovedad['asistencias_id'] = $_POST['asistencias_id'];
            $arrayNovedad['created_at'] = Carbon::now(); //Fecha Actual


            //Preguntar al ingeniero como definir la validación
            if (!Novedad::novedadRegistrada($arrayNovedad['asistencias_id'])) {
                $Novedad = new Novedad ($arrayNovedad);
                if ($Novedad->create()) {
                    //var_dump($_POST);
                    header("Location: ../../views/modules/asistencia/index.php?accion=create&respuesta=correcto");
                }
            } else {
                header("Location: ../../views/modules/asistencia/create.php?respuesta=error&mensaje=Usuario ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuarios/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit()
    {
        try {

            $arrayNovedad = array();
            $arrayNovedad['tipo'] = $_POST['tipo'];
            $arrayNovedad['justificacion'] = $_POST['justificacion'];
            $arrayNovedad['observacion'] = $_POST['observacion'];
            $arrayNovedad['estado'] = 'Activo';
            $arrayNovedad['administrador_id'] = $_POST['administrador_id'];
            $arrayNovedad['asistencias_id'] = $_POST['asistencias_id'];
            $arrayNovedad['created_at'] = Carbon::now(); //Fecha Actual
            $arrayNovedad['id'] = $_POST['id'];

            $novedad = new Novedad($arrayNovedad);
            $novedad->update();

            header("Location: ../../views/modules/novedad/show.php?id=" . $novedad->getId() . "&respuesta=correcto");

        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuario/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function searchForID($id)
    {
        try {
            return Novedad::searchForId($id);
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuarios/manager.php?respuesta=error");
        }
    }

    static public function getAll()
    {
        try {
            return Novedad::getAll();
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'log', 'errorStack');
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }
}