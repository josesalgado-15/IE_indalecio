<?php

namespace App\Models;
use App\Models\BasicModel;
use Carbon\Carbon;

class Asistencia extends BasicModel
{

    //Propiedades

    protected int $id; //Visibilidad (public, protected, private)
    protected string $fecha;
    protected string $hora_ingreso;
    protected string $observacion;
    protected string $tipo_ingreso;
    protected string $hora_salida;
    protected int $usuarios_id;
    protected string $estado;
    protected string $created_at;
    protected string $updated_at;
    protected string $deleted_at;



    /**
     * Asistencia constructor.
     *
     */

    //Metodo Constructor
    public function __construct ($asistencia = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->id = $asistencia['id'] ?? 0;
        $this->fecha = $asistencia['fecha'] ?? '';
        $this->hora_ingreso = $asistencia['hora_ingreso'] ?? '';
        $this->observacion = $asistencia['observacion'] ?? '';
        $this->tipo_ingreso = $asistencia['tipo_ingreso'] ?? '';
        $this->hora_salida = $asistencia['hora_salida'] ?? '';
        $this->usuarios_id = $asistencia['usuarios_id'] ?? 0;


        $this->estado = $asistencia['estado'] ?? '';
        $this->created_at = $asistencia['created_at'] ?? new Carbon();
        $this->updated_at = $asistencia['updated_at'] ?? new Carbon();
        $this->deleted_at = $asistencia['deleted_at'] ?? new Carbon();
    }

    function __destruct()
    {
        //    $this->Disconnect(); // Cierro Conexiones
    }

    /**
     * @return int|mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed|string
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed|string $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed|string
     */
    public function getHoraIngreso()
    {
        return $this->hora_ingreso;
    }

    /**
     * @param mixed|string $hora_ingreso
     */
    public function setHoraIngreso($hora_ingreso): void
    {
        $this->hora_ingreso = $hora_ingreso;
    }

    /**
     * @return mixed|string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * @param mixed|string $observacion
     */
    public function setObservacion($observacion): void
    {
        $this->observacion = $observacion;
    }

    /**
     * @return mixed|string
     */
    public function getTipoIngreso()
    {
        return $this->tipo_ingreso;
    }

    /**
     * @param mixed|string $tipo_ingreso
     */
    public function setTipoIngreso($tipo_ingreso): void
    {
        $this->tipo_ingreso = $tipo_ingreso;
    }

    /**
     * @return mixed|string
     */
    public function getHoraSalida()
    {
        return $this->hora_salida;
    }

    /**
     * @param mixed|string $hora_salida
     */
    public function setHoraSalida($hora_salida): void
    {
        $this->hora_salida = $hora_salida;
    }

    /**
     * @return int|mixed
     */
    public function getUsuariosId()
    {
        return $this->usuarios_id;
    }

    /**
     * @param int|mixed $usuarios_id
     */
    public function setUsuariosId($usuarios_id): void
    {
        $this->usuarios_id = $usuarios_id;
    }

    /**
     * @return mixed|string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed|string $estado
     */
    public function setEstado($estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return Carbon|mixed|string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param Carbon|mixed|string $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return Carbon|mixed|string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param Carbon|mixed|string $updated_at
     */
    public function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return Carbon|mixed|string
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * @param Carbon|mixed|string $deleted_at
     */
    public function setDeletedAt($deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }





    public function create()
    {
        var_dump($this);
        $result = $this->insertRow("INSERT INTO dbindalecio.asistencias VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, NOW() , NULL ,NULL)", array(

                $this->getFecha(),
                $this->getHoraIngreso(),
                $this->getObservacion(),
                $this->getTipoIngreso(),
                $this->getHoraSalida(),
                $this->getUsuariosId(),
                $this->getEstado(),

                //$this->getCreatedAt(),
                //$this->getUpdatedAt(),
                //$this->getDeletedAt()


            )
        );
        $this->Disconnect();
        return $result;
    }

    public function update()
    {
        $result = $this->updateRow("UPDATE dbindalecio.asistencias SET fecha = ?, hora_ingreso = ?, observacion = ?, tipo_ingreso = ?, hora_salida = ?, usuarios_id = ?, 
            estado = ? WHERE id = ?", array(

                $this->getFecha(),
                $this->getHoraIngreso(),
                $this->getObservacion(),
                $this->getTipoIngreso(),
                $this->getHoraSalida(),
                $this->getUsuariosId(),
                $this->getEstado(),

                //$this->getCreatedAt(),
                //$this->getUpdatedAt(),
                //$this->getDeletedAt()

                $this->getId()

            )
        );
        $this->Disconnect();
        return $this;
    }

    public function deleted($id)
    {
        $result = $this->updateRow('UPDATE dbindalecio.asistencias SET estado = ? WHERE id = ?', array(
                'Inactivo',
                $this->getId()
            )
        );
    }

    public static function search($query)
    {
        $arrAsistencias = array();
        $tmp = new Asistencia();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {

            $Asistencia = new Asistencia();
            $Asistencia->setId($valor['id']);
            $Asistencia->setFecha($valor['fecha']);
            $Asistencia->setHoraIngreso($valor['hora_ingreso']);
            $Asistencia->setObservacion($valor['observacion']);
            $Asistencia->setTipoIngreso($valor['tipo_ingreso']);
            $Asistencia->setHoraSalida($valor['hora_salida']);
            $Asistencia->setUsuariosId($valor['usuarios_id']);
            $Asistencia->setEstado($valor['estado']);
            //$Asistencia->setCreatedAt($valor['created_at']);
            //$Asistencia->setUpdatedAt($valor['updated_at']);
            //$Asistencia->setDeletedAt($valor['deleted_at']);
            $Asistencia->Disconnect();
            array_push($arrAsistencias, $Asistencia);

        }
        $tmp->Disconnect();
        return $arrAsistencias;

    }

    public static function getAll()
    {
        return Asistencia::search("SELECT * FROM dbindalecio.asistencias");
    }

    public static function searchForId($id)
    {
        $Asistencia = null;
        if ($id>0){
            $Asistencia = new Asistencia();
            $getrow = $Asistencia->getRow("SELECT * FROM dbindalecio.asistencias WHERE id =?", array($id));
            $Asistencia->setId($getrow['id']);
            $Asistencia->setFecha($getrow['fecha']);
            $Asistencia->setHoraIngreso($getrow['hora_ingreso']);
            $Asistencia->setObservacion($getrow['observación']);
            $Asistencia->setTipoIngreso($getrow['tipo_ingreso']);
            $Asistencia->setHoraSalida($getrow['hora_salida']);
            $Asistencia->setUsuariosId($getrow['usuarios_id']);

            $Asistencia->setEstado($getrow['estado']);
            //$Usuario->setCreatedAt($getrow['created_at']);
            //$Usuario->setUpdatedAt($getrow['updated_at']);
            //$Usuario->setDeletedAt($getrow['deleted_at']);
        }
        $Asistencia->Disconnect();
        return $Asistencia;
    }
}