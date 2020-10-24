<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array
require_once(__DIR__ . '/../Models/Grado.php');
require_once(__DIR__ . '/../Models/GeneralFunctions.php');

use App\Models\GeneralFunctions;
use App\Models\Grado;
use Carbon\Carbon;

if (!empty($_GET['action'])) {
    GradoController::main($_GET['action']);
}

class GradoController
{

    static function main($action)
    {
        if ($action == "create") {
            GradoController::create();
        } else if ($action == "edit") {
            GradoController::edit();
        } else if ($action == "searchForID") {
            GradoController::searchForID($_REQUEST['idGrado']);
        } else if ($action == "searchAll") {
            GradoController::getAll();
        } else if ($action == "changeStatus") {
            GradoController::changeStatus();
        }

    }

    static public function create()
    {
        try {
            $arrayGrado = array();
            $arrayGrado['nombre'] = $_POST['nombre'];
            $arrayGrado['estado'] = 'estado';
            $arrayGrado['created_at'] = Carbon::now(); //Fecha Actual


            if (!Grado::gradoRegistrado($arrayGrado['nombre'])) {
                $Grado = new Grado ($arrayGrado);
                if ($Grado->create()) {
                    //var_dump($_POST);
                    header("Location: ../../views/modules/grado/index.php?accion=create&respuesta=correcto");

                }
            } else {
                //echo "Grado ya creado";
                header("Location: ../../views/modules/grado/create.php?respuesta=error&mensaje=Grado ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/grado/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit()
    {
        try {

            $arrayGrado = array();
            $arrayGrado['nombre'] = $_POST['nombre'];
            $arrayGrado['estado'] = 'Activo';
            $arrayGrado['id'] = $_POST['id'];

            $grado = new Grado($arrayGrado);
            $grado->update();

            header("Location: ../../views/modules/grado/index.php?id=" . $grado->getId() . "&respuesta=correcto");

        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/grado/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function searchForID($id)
    {
        try {
            return Grado::searchForId($id);
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/grado/manager.php?respuesta=error");
        }
    }

    static public function getAll()
    {
        try {
            return Grado::getAll();
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'log', 'errorStack');
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }



    private static function usuarioIsInArray($idUsuario, $ArrUsuarios)
    {
        if (count($ArrUsuarios) > 0) {
            foreach ($ArrUsuarios as $Usuario) {
                if ($Usuario->getId() == $idUsuario) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function login (){
        try {
            if(!empty($_POST['user']) && !empty($_POST['password'])){
                $tmpUser = new Usuarios();
                $respuesta = $tmpUser->Login($_POST['user'], $_POST['password']);
                if (is_a($respuesta,"App\Models\Usuarios")) {
                    $_SESSION['UserInSession'] = $respuesta->jsonSerialize();
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