<?php


namespace App\Controllers;

require(__DIR__ . '/../../vendor/autoload.php');

use App\Models\GeneralFunctions;
use App\Models\Municipio;

class MunicipioController
{

    static public function searchForID(array $data)
    {
        try {
            $result = Municipio::searchForId($data['id']);
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
            $result = Municipio::getAll();
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

    static public function selectMunicipios(array $params = [])
    {
        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "municipios_id";
        $params['name'] = $params['name'] ?? "municipios_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrMunicipio = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM municipios WHERE ";
            $arrMunicipio = Municipio::search($base . $params['where']);
        } else {
            $arrMunicipio = Municipio::getAll();
        }
        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (count($arrMunicipio) > 0) {
            /* @var $arrMunicipio Municipio[] */
            foreach ($arrMunicipio as $municipio)
                if (!MunicipioController::municipioIsInArray($municipio->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($municipio != "") ? (($params['defaultValue'] == $municipio->getId()) ? "selected" : "") : "") . " value='" . $municipio->getId() . "'>" . $municipio->getNombre() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function municipioIsInArray($idMunicipio, $ArrMunicipio)
    {
        if (count($ArrMunicipio) > 0) {
            foreach ($ArrMunicipio as $Municipio) {
                if ($Municipio->getId() == $idMunicipio) {
                    return true;
                }
            }
        }
        return false;
    }

}