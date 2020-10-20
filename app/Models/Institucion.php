<?php

use App\Models\BasicModel;
use Carbon\Carbon;

require_once('BasicModel.php');


class Institucion extends BasicModel

{
    protected int $id; //Visibilidad (public, protected, private)
    protected string $nombre;
    protected string $direccion;
    protected string $municipios_id;
    protected string $rector;
    protected string $telefono;
    protected string $correo;
    protected string $estado;
    protected string $created_at;
    protected string $updated_at;
    protected string $deleted_at;


    public function __construct($id = 0, $nombre = 'Nombres', $direccion = 'Dirección', $municipios_id = 'Fecha', $rector = 'Rector', $telefono = 0000000000, $correo = 'Correo', $estado = 'estado', $created_at = 'Fecha', $updated_at = 'Fecha', $deleted_at = 'Fecha')

    {

        parent::__construct();
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setDireccion($direccion);
        $this->setMunicipiosId($municipios_id);
        $this->setRector($rector);
        $this->setTelefono($telefono);
        $this->setCorreo($correo);
        $this->setEstado($estado);
        $this->setCreatedAt($created_at);
        $this->setUpdatedAt($updated_at);
        $this->setDeletedAt($deleted_at);
    }

    function __destruct()
    {
        //    $this->Disconnect(); // Cierro Conexiones
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
    public function getRector(): string
    {
        return $this->rector;
    }

    /**
     * @param string $rector
     */
    public function setRector(string $rector): void
    {
        $this->rector = $rector;
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


    public function create()
    {
        $result = $this->insertRow("INSERT INTO dbindalecio.instituciones VALUES (NULL, ?, ?, ?, ?, ?, ?, ? ,? , ? ,?)", array(

                $this->setNombre(),
                $this->setDireccion(),
                $this->setMunicipiosId(),
                $this->setRector(),
                $this->setTelefono(),
                $this->setCorreo(),
                $this->setEstado(),
                $this->setCreatedAt(),
                $this->setUpdatedAt(),
                $this->setDeletedAt(),

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
        $result = $this->updateRow("UPDATE dbindalecio.usuarios SET nombre = ?,  direccion = ?, municipios_id = ?, rector = ?,  telefono = ?,
          correo = ?, estado = ?, created_at = ?, updated_at = ?, deleted_at = ? WHERE id = ?", array(
                $this->getNombre(),
                $this->getDireccion(),
                $this->getMunicipiosId(),
                $this->getRector(),
                $this->getTelefono(),
                $this->getCorreo(),
                $this->getEstado(),
                $this->getCreatedAt(),
                $this->getUpdatedAt(),
                $this->getDeletedAt(),

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

    public static function search($query)
    {
        $arrInsti = array();
        $tmp = new Institucion();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {

            $Insti = new Institucion();
            $Insti->setId($valor['id']);
            $Insti->setNombre($valor['nombre']);
            $Insti->setDireccion($valor['direccion']);
            $Insti->setMunicipiosId($valor['municipios_id']);
            $Insti->setRector($valor['rector']);
            $Insti->setTelefono($valor['telefono']);
            $Insti->setCorreo($valor['correo']);
            $Insti->setEstado($valor['estado']);
            $Insti->setCreatedAt($valor['created_at']);
            $Insti->setUpdatedAt($valor['updated_at']);
            $Insti->setDeletedAt($valor['deleted_at']);

            $Insti->Disconnect();
            array_push($arrInsti,  $Insti);

        }
        $tmp->Disconnect();
        return $arrInsti ;

    }

    public static function getAll()
    {
        return Institucion::search("SELECT * FROM dbindalecio.instituciones");
    }

    public static function searchForId($id)
    {
        $Insti = null;
        if ($id>0){
            $Insti = new Institucion();
            $getrow = $Insti->getRow("SELECT * FROM dbindalecio.instituciones WHERE id =?", array($id));

            $Insti->setId($getrow['id']);
            $Insti->setNombre($getrow['nombre']);
            $Insti->setDireccion($getrow['direccion']);
            $Insti->setMunicipiosId($getrow['municipio_id']);
            $Insti->setRector($getrow['rector']);
            $Insti->setTelefono($getrow['telefono']);
            $Insti->setCorreo($getrow['correo']);
            $Insti->setEstado($getrow['estado']);
            $Insti->setCreatedAt($getrow['created_at']);
            $Insti->setUpdatedAt($getrow['updated_at']);
            $Insti->setDeletedAt($getrow['deleted_at']);

        }
        $Insti->Disconnect();
        return $Insti;
    }
}