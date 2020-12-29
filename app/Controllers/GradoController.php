<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array

use App\Models\GeneralFunctions;
use App\Models\Grado;
use Carbon\Carbon;



class GradoController
{

    private array $dataGrado;

    public function __construct(array $_FORM)
    {
        $this->dataGrado = array();
        $this->dataGrado['id'] = $_FORM['id'] ?? NULL;
        $this->dataGrado['nombre'] = $_FORM['nombre'] ?? NULL;
        $this->dataGrado['estado'] = $_FORM['estado'] ?? 'Activo';


    }

    public function create() {
        try {
            if (!empty($this->dataGrado['nombre'] && !Grado::gradoRegistrado($this->dataGrado['nombre'])))

            {
                $Grado = new Grado ($this->dataGrado);
                if ($Grado->insert()) {
                    unset($_SESSION['frmGrados']);
                    header("Location: ../../views/modules/grado/index.php?respuesta=success&mensaje=Grado Registrado!");
                }
            } else {
                header("Location: ../../views/modules/grado/create.php?respuesta=error&mensaje=Grado ya registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    public function edit()
    {
        try {
            $grado = new Grado($this->dataGrado);
            if($grado->update()){
                unset($_SESSION['frmGrados']);
            }

            header("Location: ../../views/modules/grado/show.php?id=" . $grado->getId() . "&respuesta=success&mensaje=Grado Actualizado");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Grado::searchForId($data['id']);
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
            $result = Grado::getAll();
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


}