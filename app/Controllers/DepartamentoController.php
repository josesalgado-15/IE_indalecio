<?php


namespace App\Controllers;


use App\Models\GeneralFunctions;
use App\Models\Departamento;


class DepartamentoController
{

    static public function searchForID(array $data)
    {
        try {
            $result = Departamento::searchForId($data['id']);
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
            $result = Departamento::getAll();
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

    static public function selectDepartamentos (array $params = [])
    {
        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "municipio_id";
        $params['name'] = $params['name'] ?? "municipio_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrDepartamento = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM departamentos WHERE ";
            $arrDepartamento = Departamento::search($base . ' ' . $params['where']);
        } else {
            $arrDepartamento = Departamento::getAll();
        }

        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (count($arrDepartamento) > 0) {
            /* @var $arrDepartamento Departamento[] */
            foreach ($arrDepartamento as $departamento)
                if (!DepartamentoController::departamentoIsInArray($departamento->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($departamento != "") ? (($params['defaultValue'] == $departamento->getId()) ? "selected" : "") : "") . " value='" . $departamento->getId() . "'>" . $departamento->getNombre() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function departamentoIsInArray($idDepartamento, $ArrDepartamento)
    {
        if (count($ArrDepartamento) > 0) {
            foreach ($ArrDepartamento as $Departamento) {
                if ($Departamento->getId == $idDepartamento) {
                    return true;
                }
            }
        }
        return false;
    }

}