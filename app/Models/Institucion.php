<?php

use App\Models\BasicModel;
use Carbon\Carbon;

require_once('BasicModel.php');


class Institucion extends BasicModel

{
    protected int $idInstitucion; //Visibilidad (public, protected, private)
    protected string $nombre;
    protected string $direccion;
    protected string $rector;
    protected string $departamento;
    protected string $ciudad;
    protected string $telefono;
    protected string $correo;

    public function __construct ($nombre, $direccion, $rector, $departamento, $ciudad, $telefono ,$correo){

        parent::__construct();

        $this->setNombres($nombre);
        $this->setDireccion($direccion);
        $this->setRector($rector);
        $this->setDepartamento($departamento);
        $this->setCiudad($ciudad);
        $this->setTelefono($telefono);
        $this->setCorreo($correo);
    }

    function __destruct()
    {
        //    $this->Disconnect(); // Cierro Conexiones
    }

    /**
     * @return int
     */
    public function getIdInstitucion(): int
    {
        return $this->idInstitucion;
    }

    /**
     * @param int $idInstitucion
     */
    public function setIdInstitucion(int $idInstitucion): void
    {
        $this->idInstitucion = $idInstitucion;
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
    public function getDepartamento(): string
    {
        return $this->departamento;
    }

    /**
     * @param string $departamento
     */
    public function setDepartamento(string $departamento): void
    {
        $this->departamento = $departamento;
    }

    /**
     * @return string
     */
    public function getCiudad(): string
    {
        return $this->ciudad;
    }

    /**
     * @param string $ciudad
     */
    public function setCiudad(string $ciudad): void
    {
        $this->ciudad = $ciudad;
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

    public function save() : Institucion
    {
        $result = $this->insertRow("INSERT INTO dbindalecio.usuario VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)", array(

        $this->setNombre(),
        $this->setDireccion(),
        $this->setRector(),
        $this->setDepartamento(),
        $this->setCiudad(),
        $this->setTelefono(),
        $this->setCorreo(),

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
        $result = $this->updateRow("UPDATE dbindalecio.usuario SET nombre = ?, direccion = ?, rector = ?, departamento = ?, ciudad = ?, telefono = ?, correo = ? , WHERE id = ?", array(
                $this->setNombre(),
                $this->setDireccion(),
                $this->setRector(),
                $this->setDepartamento(),
                $this->setCiudad(),
                $this->setTelefono(),
                $this->setCorreo(),
            )
        );
        $this->Disconnect();
        return $this;
    }

    /**
     * @param $idPersona
     * @return mixed
     */

    public function deleted($idPersona)
    {
        $result = $this->updateRow("UPDATE dbindalecio.usuario SET estado = ? WHERE id = ?", array(
                'Inactivo',
                $this->getIdInstitucion()
            )
        );
        $this->Disconnect();
        return $this;
    }
    protected static function search($query)
    {
        // TODO: Implement search() method.
    }

    protected static function getAll()
    {
        // TODO: Implement getAll() method.
    }

    protected static function searchForId($id)
    {
        // TODO: Implement searchForId() method.
    }
}