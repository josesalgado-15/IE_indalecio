<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array
require_once(__DIR__ . '/../Models/Horario.php');
require_once(__DIR__ . '/../Models/GeneralFunctions.php');

use App\Models\GeneralFunctions;
use App\Models\Horario;
use Carbon\Carbon;

if (!empty($_GET['action'])) {
    UsuarioController::main($_GET['action']);
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



}