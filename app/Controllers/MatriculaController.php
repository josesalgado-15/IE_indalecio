<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array

use App\Models\GeneralFunctions;
use App\Models\Matricula;
use Carbon\Carbon;



class MatriculaController
{

    private array $dataMatricula;

    public function __construct(array $_FORM)
    {
        $this->dataMatricula = array();
        $this->dataMatricula['id'] = $_FORM['id'] ?? NULL;
        $this->dataMatricula['vigencia'] = !empty($_FORM['vigencia']) ? Carbon::parse($_FORM['vigencia']) : new Carbon();
        $this->dataMatricula['usuarios_id'] = $_FORM['usuarios_id'] ?? 0;
        $this->dataMatricula['cursos_id'] = $_FORM['cursos_id'] ?? 0;
        $this->dataMatricula['estado'] = $_FORM['estado'] ?? 'Asiste';
        $this->dataMatricula['estado'] = $_FORM['estado'] ?? 'Activo';
        var_dump($this->dataMatricula);


    }

    public function create() {
        try {
            if (!empty($this->dataMatricula['vigencia'] and $this->dataMatricula['usuarios_id'] or $this->dataMatricula['cursos_id']) && !Matricula::matriculaRegistrada($this->dataMatricula['vigencia'], $this->dataMatricula['usuarios_id'], $this->dataMatricula['cursos_id']))

            {
                $Matricula = new Matricula($this->dataMatricula);
                if ($Matricula->insert()) {
                    unset($_SESSION['frmMatriculas']);
                    header("Location: ../../views/modules/matricula/index.php?respuesta=success&mensaje=Matricula Registrada!");
                }
            } else {
                header("Location: ../../views/modules/matricula/create.php?respuesta=error&mensaje=Matricula ya registradas");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }


    public function edit()
    {
        try {
            $matricula = new Matricula($this->dataMatricula);
            if($matricula->update()){
                unset($_SESSION['frmMatriculas']);
            }

            header("Location: ../../views/modules/matricula/show.php?id=" . $matricula->getId() . "&respuesta=success&mensaje=Matricula Actualizada");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Matricula::searchForId($data['id']);
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
            $result = Matricula::getAll();
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
            $ObjMatricula = Matricula::searchForId($id);
            $ObjMatricula->setEstado("Activo");
            if ($ObjMatricula->update()) {
                header("Location: ../../views/modules/matricula/index.php");
            } else {
                header("Location: ../../views/modules/matricula/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjMatricula = Matricula::searchForId($id);
            $ObjMatricula->setEstado("Inactivo");
            if ($ObjMatricula->update()) {
                header("Location: ../../views/modules/matricula/index.php");
            } else {
                header("Location: ../../views/modules/matricula/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function selectMatricula(array $params = []) {

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "matriculas_id";
        $params['name'] = $params['name'] ?? "matriculas_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrMatriculas = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM matriculas WHERE ";
            $arrMatriculas = Matricula::search($base . ' ' . $params['where']);
        } else {
            $arrMatriculas = Matricula::getAll();
        }
        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (count($arrMatriculas) > 0) {
            /* @var $arrMatriculas Matricula[] */
            foreach ($arrMatriculas as $matricula)
                if (!MatriculaController::matriculaIsInArray($matricula->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($matricula != "") ? (($params['defaultValue'] == $matricula->getId()) ? "selected" : "") : "") . " value='" . $matricula->getId() . "'>" . $matricula->getUsuario()->getNombres() . " " . $matricula->getUsuario()->getApellidos() . " - " . $matricula->getCurso()->getNombre() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function matriculaIsInArray($idMatricula, $ArrMatriculas)
    {
        if (count($ArrMatriculas) > 0) {
            foreach ($ArrMatriculas as $Matricula) {
                if ($Matricula->getId() == $idMatricula) {
                    return true;
                }
            }
        }
        return false;
    }



}