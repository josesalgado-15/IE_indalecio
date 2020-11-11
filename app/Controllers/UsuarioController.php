<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array
require_once(__DIR__ . '/../Models/Usuario.php');
require_once(__DIR__ . '/../Models/GeneralFunctions.php');

use App\Models\GeneralFunctions;
use App\Models\Usuario;
use Carbon\Carbon;

if (!empty($_GET['action'])) {
    UsuarioController::main($_GET['action']);
}

class UsuarioController
{

    static function main($action)
    {
        if ($action == "create") {
            UsuarioController::create();
        } else if ($action == "edit") {
            UsuarioController::edit();
        } else if ($action == "searchForID") {
            UsuarioController::searchForID($_REQUEST['idPersona']);
        } else if ($action == "searchAll") {
            UsuarioController::getAll();
        } else if ($action == "changeStatus") {
            CarroController::changeStatus();
        }

    }

    static public function create()
    {
        try {
            $arrayUsuario = array();
            $arrayUsuario['nombres'] = $_POST['nombres'];
            $arrayUsuario['apellidos'] = $_POST['apellidos'];
            $arrayUsuario['edad'] = $_POST['edad'];
            $arrayUsuario['telefono'] = $_POST['telefono'];
            $arrayUsuario['numero_documento'] = $_POST['numero_documento'];
            $arrayUsuario['tipo_documento'] = $_POST['tipo_documento'];
            $arrayUsuario['fecha_nacimiento'] = Carbon::parse($_POST['fecha_nacimiento']);
            $arrayUsuario['direccion'] = $_POST['direccion'];

            $arrayUsuario['municipios_id'] = ($_POST['municipios_id']);

            $arrayUsuario['genero'] = $_POST['genero'];
            $arrayUsuario['rol'] = $_POST['rol'];
            $arrayUsuario['correo'] = $_POST['correo'];
            $arrayUsuario['contrasena'] = $_POST['contrasena'] ?? null;
            $arrayUsuario['estado'] = 'Activo';
            $arrayUsuario['nombre_acudiente'] = $_POST['nombre_acudiente'];
            $arrayUsuario['telefono_acudiente'] = $_POST['telefono_acudiente'];
            $arrayUsuario['correo_acudiente'] = $_POST['correo_acudiente'];

            $arrayUsuario['instituciones_id'] = ($_POST['instituciones_id']);

            $arrayUsuario['created_at'] = Carbon::now(); //Fecha Actual

            if (!Usuario::usuarioRegistrado($arrayUsuario['numero_documento'])) {
                $Usuario = new Usuario ($arrayUsuario);
                if ($Usuario->create()) {
                    //var_dump($_POST);
                    header("Location: ../../views/modules/usuario/index.php?accion=create&respuesta=correcto");
                }
            } else {
                header("Location: ../../views/modules/usuario/create.php?respuesta=error&mensaje=Usuario ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuarios/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit()
    {
        try {

            $arrayUsuario = array();
            $arrayUsuario['nombres'] = $_POST['nombres'];
            $arrayUsuario['apellidos'] = $_POST['apellidos'];
            $arrayUsuario['edad'] = $_POST['edad'];
            $arrayUsuario['telefono'] = $_POST['telefono'];
            $arrayUsuario['numero_documento'] = $_POST['numero_documento'];
            $arrayUsuario['tipo_documento'] = $_POST['tipo_documento'];
            $arrayUsuario['fecha_nacimiento'] = Carbon::parse($_POST['fecha_nacimiento']);
            $arrayUsuario['direccion'] = $_POST['direccion'];

            $arrayUsuario['municipios_id'] = ($_POST['municipios_id']);

            $arrayUsuario['genero'] = $_POST['genero'];
            $arrayUsuario['rol'] = $_POST['rol'];
            $arrayUsuario['correo'] = $_POST['correo'];
            $arrayUsuario['contrasena'] = $_POST['contrasena'] ?? null;
            $arrayUsuario['estado'] = $_POST['estado'];
            $arrayUsuario['nombre_acudiente'] = $_POST['nombre_acudiente'];
            $arrayUsuario['telefono_acudiente'] = $_POST['telefono_acudiente'];
            $arrayUsuario['correo_acudiente'] = $_POST['correo_acudiente'];
            $arrayUsuario['instituciones_id'] = ($_POST['instituciones_id']);
            //$arrayUsuario['created_at'] = Carbon::now(); //Fecha Actual
            $arrayUsuario['id'] = $_POST['id'];

            $usuario = new Usuario($arrayUsuario);
            $usuario->update();

            header("Location: ../../views/modules/usuario/show.php?id=" . $usuario->getId() . "&respuesta=correcto");

        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuario/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function searchForID($id)
    {
        try {
            return Usuario::searchForId($id);
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuarios/manager.php?respuesta=error");
        }
    }

    static public function getAll()
    {
        try {
            return Usuario::getAll();
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'log', 'errorStack');
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }

    static public function activate()
    {
        try {
            $ObjUsuario = Usuario::searchForId($_GET['Id']);
            $ObjUsuario->setEstado("Activo");
            if ($ObjUsuario->update()) {
                header("Location: ../../views/modules/usuarios/index.php");
            } else {
                header("Location: ../../views/modules/usuarios/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuarios/index.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function inactivate()
    {
        try {
            $ObjUsuario = Usuarios::searchForId($_GET['Id']);
            $ObjUsuario->setEstado("Inactivo");
            if ($ObjUsuario->update()) {
                header("Location: ../../views/modules/usuarios/index.php");
            } else {
                header("Location: ../../views/modules/usuarios/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/usuarios/index.php?respuesta=error");
        }
    }

    static public function selectUsuario($isMultiple = false,
                                         $isRequired = true,
                                         $id = "idUsuario",
                                         $nombre = "idUsuario",
                                         $defaultValue = "",
                                         $class = "form-control",
                                         $where = "",
                                         $arrExcluir = array())
    {
        $arrUsuarios = array();
        if ($where != "") {
            $base = "SELECT * FROM usuarios WHERE ";
            $arrUsuarios = Usuarios::search($base . ' ' . $where);
        } else {
            $arrUsuarios = Usuarios::getAll();
        }

        $htmlSelect = "<select " . (($isMultiple) ? "multiple" : "") . " " . (($isRequired) ? "required" : "") . " id= '" . $id . "' name='" . $nombre . "' class='" . $class . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (count($arrUsuarios) > 0) {
            /* @var $arrUsuarios \App\Models\Usuarios[] */
            foreach ($arrUsuarios as $usuario)
                if (!UsuarioController::usuarioIsInArray($usuario->getId(), $arrExcluir))
                    $htmlSelect .= "<option " . (($usuario != "") ? (($defaultValue == $usuario->getId()) ? "selected" : "") : "") . " value='" . $usuario->getId() . "'>" . $usuario->getDocumento() . " - " . $usuario->getNombres() . " " . $usuario->getApellidos() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
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