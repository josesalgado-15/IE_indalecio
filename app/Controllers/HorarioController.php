<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array

use App\Models\GeneralFunctions;
use App\Models\Horario;
use Carbon\Carbon;



class HorarioController
{

    private array $dataHorario;

    public function __construct(array $_FORM)
    {
        $this->dataHorario = array();
        $this->dataHorario['id'] = $_FORM['id'] ?? NULL;
        $this->dataHorario['hora_entrada_sede'] = (!empty($_FORM['hora_entrada_sede']) ? date("H:i:s", strtotime($_FORM['hora_entrada_sede'])) : date("H:i:s"));
        $this->dataHorario['hora_salida'] = $formated_time = date("H:i:s", strtotime($_FORM['hora_salida'])) ?? date("H:i:s");
        $this->dataHorario['hora_entrada_restaurante'] = $formated_time = date("H:i:s", strtotime($_FORM['hora_entrada_restaurante'])) ?? date("H:i:s");
        $this->dataHorario['fecha'] = !empty($_FORM['fecha']) ? Carbon::parse($_FORM['fecha']) : new Carbon();
        $this->dataHorario['estado'] = $_FORM['estado'] ?? 'Activo';
        $this->dataHorario['sedes_id'] = $_FORM['sedes_id'] ?? 0;



    }


    public function create() {
        try {

            //PENDIENTE VERIFICAR CON QUE CAMPOS SE REALIZARÁ LA VALIDACIÓN?

            if (!empty($this->dataHorario['hora_entrada_sede'] and $this->dataHorario['hora_salida'] and $this->dataHorario['hora_entrada_restaurante']and $this->dataHorario['sedes_id']) && !Horario::horarioRegistrado($this->dataHorario['hora_entrada_sede'], $this->dataHorario['hora_salida'], $this->dataHorario['hora_entrada_restaurante'], $this->dataHorario['sedes_id']))

            {
                $Horario = new Horario ($this->dataHorario);
                if ($Horario->insert()) {
                    unset($_SESSION['frmHorarios']);
                    header("Location: ../../views/modules/horario/index.php?respuesta=success&mensaje=Horario Registrado!");
                }
            } else {
                header("Location: ../../views/modules/horario/create.php?respuesta=error&mensaje=Horario ya registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    public function edit()
    {
        try {
            $horario = new Horario($this->dataHorario);
            if($horario->update()){
                unset($_SESSION['frmHorarios']);
            }

            header("Location: ../../views/modules/horario/show.php?id=" . $horario->getId() . "&respuesta=success&mensaje=Horario Actualizada");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }


    static public function searchForID (array $data){
        try {
            $result = Horario::searchForId($data['id']);
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
            $result = Horario::getAll();
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
            $ObjHorario = Horario::searchForId($id);
            $ObjHorario->setEstado("Activo");
            if ($ObjHorario->update()) {
                header("Location: ../../views/modules/horario/index.php");
            } else {
                header("Location: ../../views/modules/horario/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjHorario = Horario::searchForId($id);
            $ObjHorario->setEstado("Inactivo");
            if ($ObjHorario->update()) {
                header("Location: ../../views/modules/horario/index.php");
            } else {
                header("Location: ../../views/modules/horario/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }


    static public function selectHorario (array $params = []){

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "horarios_id";
        $params['name'] = $params['name'] ?? "horarios_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrHorario = array();
        if($params['where'] != ""){
            $base = "SELECT * FROM horarios WHERE ";
            $arrHorario = Horario::search($base.$params['where']);
        }else{
            $arrHorario = Horario::getAll();
        }

        $htmlSelect = "<select ".(($params['isMultiple']) ? "multiple" : "")." ".(($params['isRequired']) ? "required" : "")." id= '".$params['id']."' name='".$params['name']."' class='".$params['class']."'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrHorario) > 0){
            /* @var $arrHorario Horario[] */
            foreach ($arrHorario as $horario)
                if (!HorarioController::horarioIsInArray($horario->getId(),$params['arrExcluir']))
                    $htmlSelect .= "<option ".(($horario != "") ? (($params['defaultValue'] == $horario->getId()) ? "selected" : "" ) : "")." value='".$horario->getId() . "'>" . $horario->getSedesId() . " -Ingreso Institución: " . $horario->getHoraEntradaSede() . " -Salida: ". $horario->getHoraSalida(). " -Ingreso Restaurante: ". $horario->getHoraEntradaRestaurante(). "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }



    public static function horarioIsInArray($idHorario, $ArrHorario){
        if(count($ArrHorario) > 0){
            foreach ($ArrHorario as $Horario){
                if($Horario->getId() == $idHorario){
                    return true;
                }
            }
        }
        return false;
    }


}