<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php');

use App\Models\GeneralFunctions;
use App\Models\Sede;
use Carbon\Carbon;

class SedeController
{
    private array $dataSede;

    public function __construct(array $_FORM)
    {
        $this->dataSede = array();
        $this->dataSede['id'] = $_FORM['id'] ?? NULL;
        $this->dataSede['nombre'] = $_FORM['nombre'] ?? NULL;
        $this->dataSede['direccion'] = $_FORM['direccion'] ?? NULL;
        $this->dataSede['municipio_id'] = $_FORM['municipio_id'] ?? NULL;
        $this->dataSede['telefono'] = $_FORM['telefono'] ?? NULL;
        $this->dataSede['instituciones_id'] = $_FORM['instituciones_id'] ?? NULL;
        $this->dataSede['estado'] = $_FORM['estado'] ?? 'Activo';
        var_dump($this->dataSede);
    }

    public function create() {
        try {
            var_dump($this->dataSede);
            if (!empty($this->dataSede['nombre']) && !Sede::sedesRegistrado($this->dataSede['nombre']))

            {
                $Sede = new Sede($this->dataSede);
                if ($Sede->insert()) {
                    unset($_SESSION['frmSedes']);
                    header("Location: ../../views/modules/sede/index.php?respuesta=success&mensaje=Sede Registrada!");
                }
            } else {
                header("Location: ../../views/modules/sede/create.php?respuesta=error&mensaje=Sede ya registradas");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    public function edit()
    {
        try {
            $Sede = new Sede($this->dataSede);
            if($Sede->update()){
                unset($_SESSION['frmSedes']);
            }

            header("Location: ../../views/modules/sede/show.php?id=" . $Sede->getId() . "&respuesta=success&mensaje=Sede Actualizada");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Sede::searchForId($data['id']);
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

    static public function getAll (array $data = null){
        try {
            $result = Sede::getAll();
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
            $ObjSede = Sede::searchForId($id);
            $ObjSede->setEstado("Activo");
            if ($ObjSede->update()) {
                header("Location: ../../views/modules/sede/index.php");
            } else {
                header("Location: ../../views/modules/sede/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjSede = Sede::searchForId($id);
            $ObjSede->setEstado("Inactivo");
            if ($ObjSede->update()) {
                header("Location: ../../views/modules/sede/index.php");
            } else {
                header("Location: ../../views/modules/sede/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function selectSede (array $params = []){

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "sedes_id";
        $params['name'] = $params['name'] ?? "sedes_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrSede = array();
        if($params['where'] != ""){
            $base = "SELECT * FROM sedes WHERE ";
            $arrSede = Sede::search($base.$params['where']);
        }else{
            $arrSede = Sede::getAll();
        }

        $htmlSelect = "<select ".(($params['isMultiple']) ? "multiple" : "")." ".(($params['isRequired']) ? "required" : "")." id= '".$params['id']."' name='".$params['name']."' class='".$params['class']."'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrSede) > 0){
            /* @var $arrSede Sede[] */
            foreach ($arrSede as $sedes)
                if (!SedeController::sedeIsInArray($sedes->getId(),$params['arrExcluir']))
                    $htmlSelect .= "<option ".(($sedes != "") ? (($params['defaultValue'] == $sedes->getId()) ? "selected" : "" ) : "")." value='".$sedes->getId()."'>".$sedes->getNombre()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    public static function sedeIsInArray($idSede, $ArrSede){
        if(count($ArrSede) > 0){
            foreach ($ArrSede as $Sede){
                if($Sede->getId() == $idSede){
                    return true;
                }
            }
        }
        return false;
    }

}