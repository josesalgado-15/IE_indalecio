<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array

use App\Models\GeneralFunctions;
use App\Models\Curso;
use Carbon\Carbon;



class CursoController
{

    private array $dataCurso;

    public function __construct(array $_FORM)
    {
        $this->dataCurso = array();
        $this->dataCurso['id'] = $_FORM['id'] ?? NULL;
        $this->dataCurso['nombre'] = $_FORM['nombre'] ?? NULL;
        $this->dataCurso['director'] = $_FORM['director'] ?? NULL;
        $this->dataCurso['representante'] = $_FORM['representante'] ?? NULL;
        $this->dataCurso['cantidad'] = $_FORM['cantidad'] ?? 0;
        $this->dataCurso['grados_id'] = $_FORM['grados_id'] ?? 0;
        $this->dataCurso['horarios_id'] = $_FORM['horarios_id'] ?? 0;
        $this->dataCurso['estado'] = $_FORM['estado'] ?? 'Activo';
        var_dump($this->dataCurso);


    }

    public function create() {
        try {
            if (!empty($this->dataCurso['nombre'] and $this->dataCurso['director']) && !Curso::cursoRegistrado($this->dataCurso['nombre'], $this->dataCurso['director']))

            {
                $Curso = new Curso($this->dataCurso);
                if ($Curso->insert()) {
                    unset($_SESSION['frmCursos']);
                    header("Location: ../../views/modules/curso/index.php?respuesta=success&mensaje=Curso Registrada!");
                }
            } else {
                header("Location: ../../views/modules/curso/create.php?respuesta=error&mensaje=Curso ya registradas");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }


    public function edit()
    {
        try {
            $curso = new Curso($this->dataCurso);
            if($curso->update()){
                unset($_SESSION['frmCursos']);
            }

            header("Location: ../../views/modules/curso/show.php?id=" . $curso->getId() . "&respuesta=success&mensaje=Curso Actualizada");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Curso::searchForId($data['id']);
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
            $result = Curso::getAll();
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