<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array

use App\Models\GeneralFunctions;
use App\Models\Asistencia;
use App\Models\Usuario;
use App\Models\Matricula;
use Carbon\Carbon;



class AsistenciaController
{

    private array $dataAsistencia;

    public function __construct(array $_FORM)
    {
        $this->dataAsistencia = array();
        $this->dataAsistencia['id'] = $_FORM['id'] ?? NULL;
        $this->dataAsistencia['fecha'] = !empty($_FORM['fecha']) ? Carbon::parse($_FORM['fecha']) : new Carbon();
        $this->dataAsistencia['observacion'] = $_FORM['observacion'] ?? NULL;
        $this->dataAsistencia['matriculas_id'] = $_FORM['matriculas_id'] ?? 0;
        $this->dataAsistencia['estado'] = $_FORM['estado'] ?? 'Activo';
        $this->dataAsistencia['reporte'] = $_FORM['reporte'] ?? 'Asiste';
        $this->dataAsistencia['created_at'] = !empty($_FORM['created_at']) ? Carbon::parse($_FORM['created_at']) : new Carbon();


    }

    public function create() {
        try {
            if (!empty($this->dataAsistencia['fecha'] and $this->dataAsistencia['matriculas_id']) && !Asistencia::asistenciaRegistrada($this->dataAsistencia['fecha'], $this->dataAsistencia['matriculas_id']))

            {
                $Asistencia = new Asistencia ($this->dataAsistencia);
                if ($Asistencia->insert()) {
                    unset($_SESSION['frmAsistencias']);
                    header("Location: ../../views/modules/asistencia/index.php?respuesta=success&mensaje=Asistencia Registrada!");
                }
            } else {
                header("Location: ../../views/modules/asistencia/create.php?respuesta=error&mensaje=Asistencia ya registrada");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }


    public function edit()
    {
        try {
            $asistencia = new Asistencia($this->dataAsistencia);
            if($asistencia->update()){
                unset($_SESSION['frmAsistencias']);
            }

            header("Location: ../../views/modules/asistencia/show.php?id=" . $asistencia->getId() . "&respuesta=success&mensaje=Asistencia Actualizada");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Asistencia::searchForId($data['id']);
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
            $result = Asistencia::getAll();
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
            $ObjAsistencia = Asistencia::searchForId($id);
            $ObjAsistencia->setEstado("Activo");
            if ($ObjAsistencia->update()) {
                header("Location: ../../views/modules/asistencia/index.php");
            } else {
                header("Location: ../../views/modules/asistencia/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjAsistencia = Asistencia::searchForId($id);
            $ObjAsistencia->setEstado("Inactivo");
            if ($ObjAsistencia->update()) {
                header("Location: ../../views/modules/asistencia/index.php");
            } else {
                header("Location: ../../views/modules/asistencia/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function asiste(int $id)
    {
        try {
            $ObjAsistencia = Asistencia::searchForId($id);
            $ObjAsistencia->setReporte("Asiste");
            if ($ObjAsistencia->update()) {
                header("Location: ../../views/modules/asistencia/index.php");
            } else {
                header("Location: ../../views/modules/asistencia/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function no_asiste(int $id)
    {
        try {
            $ObjAsistencia = Asistencia::searchForId($id);
            $ObjAsistencia->setReporte("No asiste");
            if ($ObjAsistencia->update()) {
                header("Location: ../../views/modules/asistencia/index.php");
            } else {
                header("Location: ../../views/modules/asistencia/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }


    static public function selectAsistencia (array $params = []){

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "matriculas_id";
        $params['name'] = $params['name'] ?? "matriculas_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrAsistencia = array();
        if($params['where'] != ""){
            $base = "SELECT * FROM asistencias WHERE ";
            $arrAsistencia = Asistencia::search($base.$params['where']);
        }else{
            $arrAsistencia = Asistencia::getAll();
        }

        $htmlSelect = "<select ".(($params['isMultiple']) ? "multiple" : "")." ".(($params['isRequired']) ? "required" : "")." id= '".$params['id']."' name='".$params['name']."' class='".$params['class']."'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrAsistencia) > 0){
            /* @var $arrAsistencia Asistencia[] */
            foreach ($arrAsistencia as $asistencia)
                if (!AsistenciaController::asistenciaIsInArray($asistencia->getId(),$params['arrExcluir']))
                    $htmlSelect .= "<option ".(($asistencia != "") ? (($params['defaultValue'] == $asistencia->getId()) ? "selected" : "" ) : "")." value='".$asistencia->getId() . "'>" . $asistencia->getMatricula()->getUsuario()->getNombres(). " ". $asistencia->getMatricula()->getUsuario()->getApellidos(). " - ". $asistencia->getFecha() . " - " . $asistencia->getTipoIngreso() . " - " . $asistencia->getHoraIngreso() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }



    public static function asistenciaIsInArray($idAsistencia, $ArrAsistencia){
        if(count($ArrAsistencia) > 0){
            foreach ($ArrAsistencia as $Asistencia){
                if($Asistencia->getId() == $idAsistencia){
                    return true;
                }
            }
        }
        return false;
    }
}