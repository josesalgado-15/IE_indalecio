<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php');
use App\Models\GeneralFunctions;
use App\Models\Usuario;
use Carbon\Carbon;

class UsuarioController
{
    private array $dataUsuario;

    public function __construct(array $_FORM)
    {
        $this->dataUsuario = array();
        $this->dataUsuario['id'] = $_FORM['id'] ?? NULL;
        $this->dataUsuario['nombres'] = $_FORM['nombres'] ?? NULL;
        $this->dataUsuario['apellidos'] = $_FORM['apellidos'] ?? null;
        $this->dataUsuario['edad'] = $_FORM['edad'] ?? null;
        $this->dataUsuario['telefono'] = $_FORM['telefono'] ?? null;
        $this->dataUsuario['numero_documento'] = $_FORM['numero_documento'] ?? NULL;
        $this->dataUsuario['tipo_documento'] = $_FORM['tipo_documento'] ?? NULL;
        $this->dataUsuario['fecha_nacimiento'] = !empty($_FORM['fecha_nacimiento']) ? Carbon::parse($_FORM['fecha_nacimiento']) : new Carbon();
        $this->dataUsuario['direccion'] = $_FORM['direccion'] ?? NULL;
        $this->dataUsuario['municipios_id'] = $_FORM['municipios_id'] ?? NULL;
        $this->dataUsuario['genero'] = $_FORM['genero'] ?? NULL;
        $this->dataUsuario['rol'] = $_FORM['rol'] ?? 'Estudiante';
        $this->dataUsuario['correo'] = $_FORM['correo'] ?? NULL;
        $this->dataUsuario['contrasena'] = $_FORM['contrasena'] ?? NULL;
        $this->dataUsuario['estado'] = $_FORM['estado'] ?? 'Activo';
        $this->dataUsuario['nombre_acudiente'] = $_FORM['nombre_acudiente'] ?? NULL;
        $this->dataUsuario['telefono_acudiente'] = $_FORM['telefono_acudiente'] ?? NULL;
        $this->dataUsuario['correo_acudiente'] = $_FORM['correo_acudiente'] ?? NULL;
        $this->dataUsuario['instituciones_id'] = $_FORM['instituciones_id'] ?? NULL;
        var_dump($this->dataUsuario);


    }

    public function create() {
        try {
            if (!empty($this->dataUsuario['numero_documento']) && !Usuario::usuarioRegistrado($this->dataUsuario['numero_documento'])) {

                $Usuario = new Usuario ($this->dataUsuario);
                if ($Usuario->insert()) {
                  var_dump($this->dataUsuario);
                    unset($_SESSION['frmUsuarios']);
                    header("Location: ../../views/modules/usuario/index.php?respuesta=success&mensaje=Usuario Registrado");
                }
            } else {
                header("Location: ../../views/modules/usuario/create.php?respuesta=error&mensaje=Usuario ya registrado");
            }
        } catch (\Exception $e) {

            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    public function edit()
    {
        try {

            $user = new Usuario($this->dataUsuario);
            if($user->update()){
                unset($_SESSION['frmUsuarios']);
            }

            header("Location: ../../views/modules/usuario/show.php?id=" . $user->getId() . "&respuesta=success&mensaje=Usuario Actualizado");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID(array $data)
    {
        try {
            $result = Usuario::searchForId($data['id']);
            if (!empty($data['request']) and $data['request'] === 'ajax' and !empty($result)) {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result->jsonSerialize());
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    static public function getAll(array $data = null)
    {
        try {
            $result = Usuario::getAll();
            if (!empty($data['request']) and $data['request'] === 'ajax') {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result);
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    static public function activate(int $id)
    {
        try {
            $ObjUsuario = Usuario::searchForId($id);
            $ObjUsuario->setEstado("Activo");
            if ($ObjUsuario->update()) {
                header("Location: ../../views/modules/usuario/index.php");
            } else {
                header("Location: ../../views/modules/usuario/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjUsuario = Usuario::searchForId($id);
            $ObjUsuario->setEstado("Inactivo");
            if ($ObjUsuario->update()) {
                header("Location: ../../views/modules/usuario/index.php");
            } else {
                header("Location: ../../views/modules/usuario/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function selectUsuario(array $params = []) {

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "usuario_id";
        $params['name'] = $params['name'] ?? "usuario_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrUsuarios = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM usuarios WHERE ";
            $arrUsuarios = Usuario::search($base . ' ' . $params['where']);
        } else {
            $arrUsuarios = Usuario::getAll();
        }
        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (count($arrUsuarios) > 0) {
            /* @var $arrUsuarios Usuario[] */
            foreach ($arrUsuarios as $usuario)
                if (!UsuarioController::usuarioIsInArray($usuario->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($usuario != "") ? (($params['defaultValue'] == $usuario->getId()) ? "selected" : "") : "") . " value='" . $usuario->getId() . "'>" . $usuario->getNumeroDocumento() . " - " . $usuario->getNombres() . " " . $usuario->getApellidos() . "</option>";
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
            if(!empty($_POST['correo']) && !empty($_POST['contrasena'])){
                $tmpUser = new Usuario();
                $respuesta = $tmpUser->Login($_POST['correo'], $_POST['contrasena']);
                if (is_a($respuesta,"App\Models\Usuario")) {
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

}