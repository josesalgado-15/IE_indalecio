<?php

use App\Models\BasicModel;

require_once('BasicModel.php');

class Grado extends BasicModel
{
    //Propiedades

    protected int $id; //Visibilidad (public, protected, private)
    protected string $nombre;
    protected string $estado;
    protected string $created_at;
    protected string $updated_at;
    protected string $deleted_at;

    /**
     * Grado constructor.
     * @param int $id
     * @param string $nombre
     * @param string $estado
     * @param string $created_at
     * @param string $updated_at
     * @param string $deleted_at
     */
    public function __construct(int $id, string $nombre, string $estado, string $created_at, string $updated_at, string $deleted_at)
    {
        parent::__construct();
        $this->setId($id); //Propiedad recibida y asigna a una propiedad de la clase
        $this->setNombre($nombre);
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

        $result = $this->insertRow("INSERT INTO dbindalecio.grados VALUES (NULL, ?, ?, ?, ?, ?)", array(

                $this->getNombre(),
                $this->getEstado(),
                $this->getCreatedAt(),
                $this->getUpdatedAt(),
                $this->getDeletedAt()


            )
        );
        $this->Disconnect();
        return $result;

    }

    protected function update()
    {


        $result = $this->updateRow("UPDATE dbindalecio.grados SET nombre = ?, estado = ?, created_at = ?, updated_at = ?, deleted_at = ? WHERE id = ?", array(

            $this->getNombre(),
            $this->getEstado(),
            $this->getCreatedAt(),
            $this->getUpdatedAt(),
            $this->getDeletedAt(), $this->getId()

            )
        );
        $this->Disconnect();
        return $this;
    }
    protected function deleted($id)
    {
        $result = $this->updateRow('UPDATE dbindalecio.grados SET estado = ? WHERE id = ?', array(
                'Inactivo',
                $this->getId()
            )
        );
    }

    protected static function search($query)
    {
        $arrGrados = array();
        $tmp = new Grado();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {

            $Grado = new Grado();
            $Grado->setId($valor['id']);
            $Grado->setNombre($valor['nombre']);
            $Grado->setEstado($valor['estado']);
            $Grado->setCreatedAt($valor['created_at']);
            $Grado->setUpdatedAt($valor['updated_at']);
            $Grado->setDeletedAt($valor['deleted_at']);



            $Grado->Disconnect();
            array_push($arrGrados, $Grado);

        }
        $tmp->Disconnect();
        return $arrGrados;

    }

    protected static function getAll()
    {
        return Usuario::search("SELECT * FROM dbindalecio.grados");
    }

    protected static function searchForId($id)
    {
        $Grado = null;
        if ($id>0){
            $Grado = new Grado();
            $getrow = $Grado->getRow("SELECT * FROM dbindalecio.grados WHERE id =?", array($id));

            $Grado->setId($getrow['id']);
            $Grado->setNombre($getrow['nombre']);
            $Grado->setEstado($getrow['estado']);
            $Grado->setCreatedAt($getrow['created_at']);
            $Grado->setUpdatedAt($getrow['updated_at']);
            $Grado->setDeletedAt($getrow['deleted_at']);
        }
        $Grado->Disconnect();
        return $Grado;
    }
}