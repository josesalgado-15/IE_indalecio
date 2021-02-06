<?php

namespace App\Models;
use App\Controllers\InstitucionController;
use App\Models\BasicModel;
use Carbon\Carbon;

require_once('BasicModel.php');


class Institucion extends BasicModel

{
    protected int $id; //Visibilidad (public, protected, private)
    protected string $nombre;
    protected string $nit;
    protected string $direccion;
    protected string $municipios_id;
    protected string $rector_id;
    protected string $telefono;
    protected string $correo;
    protected string $estado;

    protected string $created_at;
    protected string $updated_at;
    protected string $deleted_at;

    /**suario
     * Institucion constructor.
     *
     */

    public function __construct ($Institucion = array ())

    {

        parent::__construct();
        $this->id = $Institucion['id'] ?? 0;
        $this->nombre = $Institucion['nombre'] ?? '';
        $this->nit = $Institucion ['nit'] ?? '';
        $this->direccion = $Institucion['direccion'] ?? '';
        $this->municipios_id = $Institucion['municipios_id'] ?? 0 ;
        $this->rector_id = $Institucion['rector_id'] ?? '';
        $this->telefono = $Institucion['telefono'] ?? '';
        $this->correo = $Institucion['correo'] ?? '';
        $this->estado= $Institucion['estado'] ?? '';

        $this->created_at =  $Institucion ['created_at'] ?? new Carbon();
        $this->updated_at =  $Institucion['updated_at'] ?? new Carbon();
        $this->deleted_at =  $Institucion ['deleted_at'] ?? new Carbon();

    }

    function __destruct()
    {
        //    $this->Disconnect(); // Cierro Conexiones
    }

    public static function InstitucionRegistrada($nit): bool
    {
        $result = Institucion::search("SELECT * FROM dbindalecio.instituciones where nit = " . $nit);
        if ( count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed|string
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * @param mixed|string $nit
     */
    public function setNit($nit): void
    {
        $this->nit = $nit;
    }


    /**
     * @return string
     */
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     */
    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return string
     */
    public function getMunicipiosId(): string
    {
        return $this->municipios_id;
    }

    /**
     * @param string $municipios_id
     */
    public function setMunicipiosId(string $municipios_id): void
    {
        $this->municipios_id = $municipios_id;
    }

    /**
     * @return string
     */
    public function getRectorId(): string
    {
        return $this->rector_id;
    }

    /**
     * @param string $rector_id
     */
    public function setRectorId(string $rector_id): void
    {
        $this->rector_id = $rector_id;
    }


    /**
     * @return string
     */
    public function getTelefono(): string
    {
        return $this->telefono;
    }

    /**
     * @param string $telefono
     */
    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return string
     */
    public function getCorreo(): string
    {
        return $this->correo;
    }

    /**
     * @param string $correo
     */
    public function setCorreo(string $correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return string
     */
    public function getEstado(): string
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return string
     */

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     */

    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return string
     */

    public function getDeletedAt(): string
    {
        return $this->deleted_at;
    }

    /**
     * @param string $deleted_at
     */

    public function setDeletedAt(string $deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }

    /**
     * @return mixed
     */


    public function create()
    {
        var_dump($this);
        $result = $this->insertRow("INSERT INTO dbindalecio.instituciones VALUES (NULL, ?, ?, ?, ?, ?, ?, ? ,? , NOW() , NULL ,NULL )", array(

                $this->getNombre(),
                $this->getNit(),
                $this->getDireccion(),
                $this->getMunicipiosId(),
                $this->getRectorId(),
                $this->getTelefono(),
                $this->getCorreo(),
                $this->getEstado(),
                /*
                                $this->getCreatedAt(),
                                $this->getUpdatedAt(),
                                $this->getDeletedAt(),
                */
            )
        );

        $this->Disconnect();
        return $this;

    }

    /**
     * @return mixed
     */


    public function update()
    {
        $result = $this->updateRow("UPDATE dbindalecio.instituciones SET nombre = ?, nit = ?,  direccion = ?, municipios_id = ?, rector_id = ?,  telefono = ?,
          correo = ?, estado = ? /*created_at = ?, updated_at = ?, deleted_at = ?*/   WHERE id = ?", array(

                $this->getNombre(),
                $this->getNit(),
                $this->getDireccion(),
                $this->getMunicipiosId(),
                $this->getRectorId(),
                $this->getTelefono(),
                $this->getCorreo(),
                $this->getEstado(),
                /*
                                $this->getCreatedAt(),
                                $this->getUpdatedAt(),
                                $this->getDeletedAt(),
                */
                $this->getId()

            )
        );
        $this->Disconnect();
        return $this;
    }

    /**
     * @param $id
     * @return mixed
     */

    public function deleted($id)
    {
        $result = $this->updateRow('UPDATE dbindalecio.instituciones SET estado = ? WHERE id = ?', array(
                'Inactivo',
                $this->getId()
            )
        );
    }

    /**
     * @param $query
     * @return mixed
     */

    public static function search($query)
    {
        $arrInstitucion = array();
        $tmp = new Institucion();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {

            $Institucion = new Institucion();
            $Institucion->setId($valor['id']);
            $Institucion->setNombre($valor['nombre']);
            $Institucion->setNit($valor ['nit']);
            $Institucion->setDireccion($valor['direccion']);
            $Institucion->setMunicipiosId($valor['municipios_id']);
            $Institucion->setRectorId($valor['rector_id']);
            $Institucion->setTelefono($valor['telefono']);
            $Institucion->setCorreo($valor['correo']);
            $Institucion->setEstado($valor['estado']);

            //$Institucion->setCreatedAt($valor['created_at']);
            //$Institucion->setUpdatedAt($valor['updated_at']);
            //$Institucion->setDeletedAt($valor['deleted_at']);

            $Institucion->Disconnect();
            array_push($arrInstitucion, $Institucion);

        }
        $tmp->Disconnect();
        return $arrInstitucion ;

    }



    public static function getAll()
    {
        return Institucion::search("SELECT * FROM dbindalecio.instituciones");
    }



    public static function searchForId($id)
    {
        $Institucion = null;
        if ($id>0){
            $Institucion = new Institucion();
            $getrow = $Institucion->getRow("SELECT * FROM dbindalecio.instituciones WHERE id =?", array($id));
            $Institucion->setId($getrow['id']);
            $Institucion->setNit($getrow['nit']);
            $Institucion->setNombre($getrow['nombre']);
            $Institucion->setDireccion($getrow['direccion']);
            $Institucion->setMunicipiosId($getrow['municipios_id']);
            $Institucion->setRectorId($getrow['rector_id']);
            $Institucion->setTelefono($getrow['telefono']);
            $Institucion->setCorreo($getrow['correo']);
            $Institucion->setEstado($getrow['estado']);

            //$Institucion->setCreatedAt($getrow['created_at']);
            //$Institucion->setUpdatedAt($getrow['updated_at']);
            //$Institucion->setDeletedAt($getrow['deleted_at']);


        }
        $Institucion->Disconnect();
        return $Institucion;
    }



    public function __toString(): string
    {
        return
            "<strong>Sus datos son:</strong> ".
            "<br>".
            "<br>".
            "<strong>Id:</strong> " . $this->getId() . "<br/>" .
            "<strong>Nombre:</strong> " . $this->getNombre() . "<br/>" .
            "<strong>Nit:</strong> " . $this->getNit() . "<br/>" .
            "<strong>Dirección:</strong> " . $this->getDireccion() . "<br/>".
            "<strong>Id Municipio:</strong> " . $this->getMunicipiosId() . "<br/>".
            "<strong>Id Rector:</strong> " . $this->getRectorId() . "<br/>".
            "<strong>Teléfono:</strong> " . $this->getTelefono() . "<br/>".
            "<strong>Correo:</strong> " . $this->getCorreo() . "<br/>".
            "<strong>Estado:</strong> " . $this->getEstado() . "<br/>" ;


        /*
        */



    }
}