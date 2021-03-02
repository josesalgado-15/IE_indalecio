<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array

use App\Models\GeneralFunctions;
use App\Models\Novedad;
use App\Models\Asistencia;
use App\Models\Usuario;
use Carbon\Carbon;



class NovedadController
{

    private array $dataNovedad;

    public function __construct(array $_FORM)
    {
        $this->dataNovedad = array();
        $this->dataNovedad['id'] = $_FORM['id'] ?? NULL;
        $this->dataNovedad['tipo'] = $_FORM['tipo'] ?? NULL;
        $this->dataNovedad['justificacion'] = $_FORM['justificacion'] ?? NULL;
        $this->dataNovedad['observacion'] = $_FORM['observacion'] ?? NULL;
        $this->dataNovedad['estado'] = $_FORM['estado'] ?? 'Activo';
        $this->dataNovedad['administrador_id'] = $_FORM['administrador_id'] ?? 0;
        $this->dataNovedad['asistencia_id'] = $_FORM['asistencia_id'] ?? 0;
        var_dump($this->dataNovedad);

    }

    public function create() {
        try {
            if (!empty($this->dataNovedad['tipo'] and $this->dataNovedad['asistencia_id']  && !Novedad::novedadRegistrada($this->dataNovedad['tipo'], $this->dataNovedad['asistencia_id'])))

            {
                $Novedad = new Novedad ($this->dataNovedad);
                if ($Novedad->insert()) {

                    unset($_SESSION['frmNovedades']);
                    header("Location: ../../views/modules/novedad/index.php?respuesta=success&mensaje=Novedad Registrada!");
                }
            } else {
                header("Location: ../../views/modules/asistencia/create.php?respuesta=error&mensaje=Novedad ya registradas");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }


    public function edit()
    {
        try {
            $novedad = new Novedad($this->dataNovedad);
            if($novedad->update()){
                unset($_SESSION['frmNovedades']);
            }

            header("Location: ../../views/modules/novedad/show.php?id=" . $novedad->getId() . "&respuesta=success&mensaje=Novedad Actualizada");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Novedad::searchForId($data['id']);
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
            $result = Novedad::getAll();
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
            $ObjNovedad = Novedad::searchForId($id);
            $ObjNovedad->setEstado("Activo");
            if ($ObjNovedad->update()) {
                header("Location: ../../views/modules/novedad/index.php");
            } else {
                header("Location: ../../views/modules/novedad/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjNovedad = Novedad::searchForId($id);
            $ObjNovedad->setEstado("Inactivo");
            if ($ObjNovedad->update()) {
                header("Location: ../../views/modules/novedad/index.php");
            } else {
                header("Location: ../../views/modules/novedad/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }


    static public function selectAsistencia (array $params = []){

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "asistencia_id";
        $params['name'] = $params['name'] ?? "asistencia_id";
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
                    $htmlSelect .= "<option ".(($asistencia != "") ? (($params['defaultValue'] == $asistencia->getId()) ? "selected" : "" ) : "")." value='".$asistencia->getId() . "'>" . $asistencia->getMatricula()->getCurso()->getNombre().  " - " . $asistencia->getMatricula()->getUsuario()->getNombres(). " ". $asistencia->getMatricula()->getUsuario()->getApellidos(). " - ". $asistencia->getReporte(). " - ". $asistencia->getFecha()->translatedFormat('l, j \\de F Y') . "</option>";
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