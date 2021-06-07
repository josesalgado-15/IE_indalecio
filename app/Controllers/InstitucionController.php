<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array


use App\Models\GeneralFunctions;
use App\Models\Institucion;
use App\Models\Usuario;

use Carbon\Carbon;

class InstitucionController
{
    private array $dataInstitucion;

    public function __construct(array $_FORM)
    {
        $this->dataInstitucion = array();
        $this->dataInstitucion['id'] = $_FORM['id'] ?? NULL;
        $this->dataInstitucion['nombre'] = $_FORM['nombre'] ?? NULL;
        $this->dataInstitucion['nit'] = $_FORM['nit'] ?? NULL;
        $this->dataInstitucion['direccion'] = $_FORM['direccion'] ?? NULL;
        $this->dataInstitucion['municipios_id'] = $_FORM['municipios_id'] ?? NULL;
        $this->dataInstitucion['rector_id'] = $_FORM['rector_id'] ?? NULL;
        $this->dataInstitucion['telefono'] = $_FORM['telefono'] ?? NULL;
        $this->dataInstitucion['correo'] = $_FORM['correo'] ?? NULL;
        $this->dataInstitucion['estado'] = $_FORM['estado'] ?? 'Activo';

    }
    public function create($withFiles = null) {
        try {
            if (!empty($this->dataInstitucion['nit']) && !Institucion::institucionRegistrada($this->dataInstitucion['nit'])) {

                $Institucion= new Institucion($this->dataInstitucion);
                if ($Institucion->insert()) {
                    unset($_SESSION['frmInstituciones']);
                    header("Location: ../../views/modules/instituciones/index.php?respuesta=success&mensaje=Institucion Registrada");
                }
            } else {
                header("Location: ../../views/modules/instituciones/create.php?respuesta=error&mensaje=Institucion ya registrada");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    public function edit($withFiles = null)
    {
        try {
            $user = new Institucion($this->dataInstitucion);
            if($user->update()){
                unset($_SESSION['frmInstituciones']);
            }

            header("Location: ../../views/modules/instituciones/show.php?id=" . $user->getId() . "&respuesta=success&mensaje=Institucion Actualizada");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID(array $data)
    {
        try {
            $result = Institucion::searchForId($data['id']);
            if (!empty($data['request']) and $data['request'] === 'ajax' and !empty($result)) {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result->jsonSerialize());
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }

    static public function getAll(array $data = null)
    {
        try {
            $result = Institucion::getAll();
            if (!empty($data['request']) and $data['request'] === 'ajax') {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result);
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }

    static public function activate(int $id)
    {
        try {
            $ObjInstitucion = Institucion::searchForId($id);
            $ObjInstitucion->setEstado("Activo");
            if ($ObjInstitucion->update()) {
                header("Location: ../../views/modules/instituciones/index.php");
            } else {
                header("Location: ../../views/modules/instituciones/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjInstitucion = Institucion::searchForId($id);
            $ObjInstitucion->setEstado("Inactivo");
            if ($ObjInstitucion->update()) {
                header("Location: ../../views/modules/instituciones/index.php");
            } else {
                header("Location: ../../views/modules/instituciones/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    static public function selectInstitucion(array $params = [])
    {

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "instituciones_id";
        $params['name'] = $params['name'] ?? "instituciones_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrInstitucion = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM instituciones WHERE ";
            $arrInstitucion = Institucion::search($base . ' ' . $params['where']);
        } else {
            $arrInstitucion = Institucion::getAll();
        }
        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (count($arrInstitucion) > 0) {
            /* @var $arrInstitucion Institucion[] */
            foreach ($arrInstitucion as $institucion)
                if (!InstitucionController::institucionIsInArray($institucion->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($institucion != "") ? (($params['defaultValue'] == $institucion->getId()) ? "selected" : "") : "") . " value='" . $institucion->getId() . "'>" . "NIT " . $institucion->getNit() . " - " . $institucion->getNombre() . " - " . $institucion->getTelefono() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function institucionIsInArray($idInstitucion, $ArrInstitucion)
    {
        if (count($ArrInstitucion) > 0) {
            foreach ($ArrInstitucion as $Institucion) {
                if ($Institucion->getId() == $idInstitucion) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function login()
    {
        try {
            if (!empty($_POST['user']) && !empty($_POST['password'])) {
                $tmpUser = new Institucion();
                $respuesta = $tmpUser->Login($_POST['user'], $_POST['password']);
                if (is_a($respuesta, "App\Models\Institucion")) {
                    $_SESSION['UserInSession'] = $respuesta->jsonSerialize();
                    header("Location: ../../views/index.php");
                } else {
                    header("Location: ../../views/modules/site/login.php?respuesta=error&mensaje=" . $respuesta);
                }
            } else {
                header("Location: ../../views/modules/site/login.php?respuesta=error&mensaje=Datos Vacíos");
            }
        } catch (\Exception $e) {
            header("Location: ../../views/modules/site/login.php?respuesta=error" . $e->getMessage());
        }
    }

    public static function cerrarSession()
    {
        session_unset();
        session_destroy();
        header("Location: ../../views/modules/site/login.php");
    }



}



