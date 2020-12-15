<?php


namespace App\Models;
use App\Models\BasicModel;
use Carbon\Carbon;

require_once('BasicModel.php');

class Novedad extends BasicModel
{

    //Propiedades

    protected int $id; //Visibilidad (public, protected, private)
    protected string $tipo;
    protected string $justificacion;
    protected string $observacion;
    protected string $estado;
    protected Usuario $administrador_id;
    protected Asistencia $asistencias_id;

    protected string $created_at;
    protected string $updated_at;
    protected string $deleted_at;

    /**
     * Novedad constructor.
     *
     */

    //Metodo Constructor
    public function __construct ($novedad = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->id = $novedad['id'] ?? 0;
        $this->tipo = $novedad['tipo'] ?? '';
        $this->justificacion = $novedad['justificacion'] ?? '';
        $this->observacion = $novedad['observacion'] ?? '';
        $this->estado = $novedad['estado'] ?? '';
        $this->administrador_id = $novedad['administrador_id'] ?? new Usuario();
        $this->asistencias_id = $novedad['asistencias_id'] ?? new Asistencia();

        $this->created_at = $usuario['created_at'] ?? new Carbon();
        $this->updated_at = $usuario['updated_at'] ?? new Carbon();
        $this->deleted_at = $usuario['deleted_at'] ?? new Carbon();
    }

    function __destruct()
    {
        //    $this->Disconnect(); // Cierro Conexiones
    }

    public static function novedadRegistrada(string $tipo, int $asistencias_id): bool
    {
        $result = Novedad::search("SELECT * FROM dbindalecio.novedades where tipo = '" . $tipo. "' and asistencias_id = '".$asistencias_id ."'");
        if ( count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
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
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed|string $tipo
     */
    public function setTipo($tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return string
     */
    public function getJustificacion(): string
    {
        return $this->justificacion;
    }

    /**
     * @param string $justificacion
     */
    public function setJustificacion(string $justificacion): void
    {
        $this->justificacion = $justificacion;
    }

    /**
     * @return string
     */
    public function getObservacion(): string
    {
        return $this->observacion;
    }

    /**
     * @param string $observacion
     */
    public function setObservacion(string $observacion): void
    {
        $this->observacion = $observacion;
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
     @return int|mixed
     */
    public function getAdministradorId()
    {
        return $this->administrador_id;
    }

    /**
     * @param int|mixed $administrador_id
     */
    public function setAdministradorId($administrador_id): void
    {
        $this->administrador_id = $administrador_id;
    }



    /**
     * @return int
     */
    public function getAsistenciasId()
    {
        return $this->asistencias_id;
    }

    /**
     * @param  int|mixed $asistencias_id
     */
    public function setAsistenciasId($asistencias_id): void
    {
        $this->asistencias_id = $asistencias_id;
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
        $result = $this->insertRow("INSERT INTO dbindalecio.novedades VALUES (NULL, ?, ?, ?, ?, ?, ?, NOW() , NULL ,NULL)", array(

                $this->getTipo(),
                $this->getJustificacion(),
                $this->getObservacion(),
                $this->getEstado(),
                $this->getAdministradorId()->getId(),
                $this->getAsistenciasId()->getId(),

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
        $result = $this->updateRow("UPDATE dbindalecio.novedades SET tipo = ?, justificacion = ?, observacion = ?, 
        estado = ?, administrador_id = ?, asistencias_id = ? WHERE id = ?", array(

                $this->getTipo(),
                $this->getJustificacion(),
                $this->getObservacion(),
                $this->getEstado(),
                $this->getAdministradorId()->getId(),
                $this->getAsistenciasId()->getId(),
                //$this->getCreatedAt(),
                //$this->getUpdatedAt(),
                //$this->getDeletedAt(),
                $this->getId()

            )
        );
        $this->Disconnect();
        return $this;
    }


    public function deleted($id)
    {
        $result = $this->updateRow('UPDATE dbindalecio.novedades SET estado = ? WHERE id = ?', array(
                'Inactivo',
                $this->getId()
            )
        );
    }

    public static function search($query)
    {
        $arrNovedades = array();
        $tmp = new Novedad();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {

            $Novedad = new Novedad();
            $Novedad->setId($valor['id']);
            $Novedad->setTipo($valor['tipo']);
            $Novedad->setJustificacion($valor['justificacion']);
            $Novedad->setObservacion($valor['observacion']);
            $Novedad->setEstado($valor['estado']);
            $Novedad->setAdministradorId(Usuario::searchForId ($valor['administrador_id']));
            $Novedad->setAsistenciasId(Asistencia::searchForId ($valor['asistencias_id']));
            $Novedad->setEstado($valor['estado']);
            //$Novedad->setCreatedAt($valor['created_at']);
            //$Novedad->setUpdatedAt($valor['updated_at']);
            //$Novedad->setDeletedAt($valor['deleted_at']);
            $Novedad->Disconnect();
            array_push($arrNovedades, $Novedad);

        }
        $tmp->Disconnect();
        return $arrNovedades;

    }

    public static function searchForId($id)
    {
        $Novedad = null;
        if ($id>0){
            $Novedad = new Novedad();
            $getrow = $Novedad->getRow("SELECT * FROM dbindalecio.novedades WHERE id =?", array($id));
            $Novedad->setId($getrow['id']);
            $Novedad->setTipo($getrow['tipo']);
            $Novedad->setJustificacion($getrow['justificacion']);
            $Novedad->setObservacion($getrow['observacion']);
            $Novedad->setEstado($getrow['estado']);
            $Novedad->setAdministradorId(Usuario::searchForId ($getrow['administrador_id']));
            $Novedad->setAsistenciasId(Asistencia::searchForId ($getrow['asistencias_id']));
            $Novedad->setEstado($getrow['estado']);

            //$Usuario->setCreatedAt($getrow['created_at']);
            //$Usuario->setUpdatedAt($getrow['updated_at']);
            //$Usuario->setDeletedAt($getrow['deleted_at']);
        }
        $Novedad->Disconnect();
        return $Novedad;
    }

    public static function getAll()
    {
        return Novedad::search("SELECT * FROM dbindalecio.novedades");
    }


}
