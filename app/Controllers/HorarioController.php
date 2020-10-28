<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array
require_once(__DIR__ . '/../Models/Horario.php');
require_once(__DIR__ . '/../Models/GeneralFunctions.php');

use App\Models\GeneralFunctions;
use App\Models\Horario;
use Carbon\Carbon;

if (!empty($_GET['action'])) {
    HorarioController::main($_GET['action']);
}

class HorarioController
{
    static function main($action)
    {
        if ($action == "create") {
            HorarioController::create();
        } else if ($action == "edit") {
            HorarioController::edit();
        } else if ($action == "searchForID") {
            HorarioController::searchForID($_REQUEST['idPersona']);
        } else if ($action == "searchAll") {
            HorarioController::getAll();
        } else if ($action == "changeStatus") {
            HorarioController::changeStatus();
        }

    }


    static public function create()
    {
        try {
            $arrayHorario = array();
            $arrayHorario['hora_entrada_sede'] = $_POST['hora_entrada_sede'];
            $arrayHorario['hora_salida'] = $_POST['hora_salida'];
            $arrayHorario['hora_entrada_restaurante'] = $_POST['hora_entrada_restaurante'];
            $arrayHorario['fecha_horario'] = $_POST['fecha_horario'];
            $arrayHorario['estado'] = $_POST['estado'];
            $arrayHorario['sedes_id'] = ($_POST['sedes_id']);
            $arrayHorario['created_at'] = Carbon::now(); //Fecha Actual

            //PENDIENTE verificar con que datos se va a hacer la validación

            $Horario = new Horario ($arrayHorario);
            if($Horario->create()){
                header("Location: ../../views/modules/horario/create.php?id=".$Horario->getId());
            }
        } catch (\Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/ventas/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit()
    {
        try {

            $arrayHorario = array();
            $arrayHorario['hora_entrada_sede'] = $_POST['hora_entrada_sede'];
            $arrayHorario['hora_salida'] = $_POST['hora_salida'];
            $arrayHorario['hora_entrada_restaurante'] = $_POST['hora_entrada_restaurante'];
            $arrayHorario['fecha_horario'] = $_POST['fecha_horario'];
            $arrayHorario['estado'] = $_POST['estado'];
            $arrayHorario['sedes_id'] = ($_POST['sedes_id']);
            $arrayHorario['created_at'] = Carbon::now(); //Fecha Actual
            $arrayHorario['id'] = $_POST['id'];

            $horario = new Horario($arrayHorario);
            $horario->update();

            header("Location: ../../views/modules/horario/show.php?id=" . $horario->getId() . "&respuesta=correcto");

        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/horario/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function searchForID($id)
    {
        try {
            return Horario::searchForId($id);
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/horario/manager.php?respuesta=error");
        }
    }

    static public function getAll()
    {
        try {
            return Horario::getAll();
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'log', 'errorStack');
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }



}