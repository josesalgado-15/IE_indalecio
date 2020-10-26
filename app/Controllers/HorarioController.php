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
            $arrayUsuario['estado'] = 'Activo';
            $arrayUsuario['sedes_id'] = ($_POST['sedes_id']);
            $arrayUsuario['created_at'] = Carbon::now(); //Fecha Actual

            //PENDIENTE verificar con que datos se va a hacer la validación

            if (!Horario::usuarioRegistrado($arrayHorario['numero_documento'])) {
                $Horario = new Horario ($arrayHorario);
                if ($Horario->create()) {
                    //var_dump($_POST);
                    header("Location: ../../views/modules/horario/index.php?accion=create&respuesta=correcto");
                }
            } else {
                header("Location: ../../views/modules/horario/create.php?respuesta=error&mensaje=Usuario ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/horario/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }



}
