<?php


use App\Models\BasicModel;

require_once('BasicModel.php');


class Horario extends BasicModel
{
    //Propiedades

    protected int $id; //Visibilidad (public, protected, private)
    protected string $horario_entrada_sede;
    protected string $horario_salida;
    protected string $horario_entrada_restaurante;
    protected string $fecha_horario;
    protected string $estado;
    protected string $created_at;
    protected string $updated_at;
    protected string $deleted_at;



    /**
     * Horario constructor.
     *
     */

    //Metodo Constructor
    public function __construct ($id=0, $horario_entrada_sede='Fecha', $horario_salida='Fecha' , $horario_entrada_restaurante='Fecha', $fecha_horario='Fecha', $estado='estado', $created_at='Fecha',$updated_at='Fecha', $deleted_at='Fecha')
    {

        parent::__construct();
        $this->setId($id); //Propiedad recibida y asigna a una propiedad de la clase
        $this->setHorarioEntradaSede($horario_entrada_sede);
        $this->setHorarioSalida($horario_salida);
        $this->setHorarioEntradaRestaurante($horario_entrada_restaurante);
        $this->setFechaHorario($fecha_horario);
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
    public function getHorarioEntradaSede(): string
    {
        return $this->horario_entrada_sede;
    }

    /**
     * @param string $horario_entrada_sede
     */
    public function setHorarioEntradaSede(string $horario_entrada_sede): void
    {
        $this->horario_entrada_sede = $horario_entrada_sede;
    }

    /**
     * @return string
     */
    public function getHorarioSalida(): string
    {
        return $this->horario_salida;
    }

    /**
     * @param string $horario_salida
     */
    public function setHorarioSalida(string $horario_salida): void
    {
        $this->horario_salida = $horario_salida;
    }

    /**
     * @return string
     */
    public function getHorarioEntradaRestaurante(): string
    {
        return $this->horario_entrada_restaurante;
    }

    /**
     * @param string $horario_entrada_restaurante
     */
    public function setHorarioEntradaRestaurante(string $horario_entrada_restaurante): void
    {
        $this->horario_entrada_restaurante = $horario_entrada_restaurante;
    }

    /**
     * @return string
     */
    public function getFechaHorario(): string
    {
        return $this->fecha_horario;
    }

    /**
     * @param string $fecha_horario
     */
    public function setFechaHorario(string $fecha_horario): void
    {
        $this->fecha_horario = $fecha_horario;
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

        $result = $this->insertRow("INSERT INTO dbindalecio.horarios VALUES (NULL, ?, ?, ?, ?, ?, NOW() , NULL ,NULL)", array(

                $this->getHorarioEntradaSede(),
                $this->getHorarioSalida(),
                $this->getHorarioEntradaRestaurante(),
                $this->getFechaHorario(),
                $this->getEstado()
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
        $result = $this->updateRow("UPDATE dbindalecio.horarios SET hora_entrada_sede = ?, hora_salida = ?, hora_entrada_restaurante = ?, fecha_horario = ?, estado = ?,  created_at = ?, updated_at = ?, deleted_at = ? WHERE id = ?", array(

                $this->getHorarioEntradaSede(),
                $this->getHorarioSalida(),
                $this->getHorarioEntradaRestaurante(),
                $this->getFechaHorario(),
                $this->getEstado(),
                $this->getCreatedAt(),
                $this->getUpdatedAt(),
                $this->getDeletedAt(),
                $this->getId()

            )
        );
        $this->Disconnect();
        return $this;
    }

    public function deleted($id)
    {
        $result = $this->updateRow('UPDATE dbindalecio.horarios SET estado = ? WHERE id = ?', array(
                'Inactivo',
                $this->getId()
            )
        );
    }

    public static function search($query)
    {
        $arrHorarios = array();
        $tmp = new Horario();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {

            $Horario = new Horario();
            $Horario->setId($valor['id']);
            $Horario->setHorarioEntradaSede($valor['hora_entrada_sede']);
            $Horario->setHorarioSalida($valor['hora_salida']);
            $Horario->setHorarioEntradaRestaurante($valor['hora_entrada_restaurante']);
            $Horario->setFechaHorario($valor['fecha_horario']);
            $Horario->setEstado($valor['estado']);
            $Horario->setCreatedAt($valor['created_at']);
            $Horario->setUpdatedAt($valor['updated_at']);
            $Horario->setDeletedAt($valor['deleted_at']);



            $Horario->Disconnect();
            array_push($arrHorarios, $Horario);

        }
        $tmp->Disconnect();
        return $arrHorarios;

    }

    public static function getAll()
    {
        return Usuario::search("SELECT * FROM dbindalecio.horarios");
    }

    public static function searchForId($id)
    {
        $Horario = null;
        if ($id>0){
            $Horario = new Horario();
            $getrow = $Horario->getRow("SELECT * FROM dbindalecio.horarios WHERE id =?", array($id));

            $Horario->setId($getrow['id']);
            $Horario->setHorarioEntradaSede($getrow['hora_entrada_sede']);
            $Horario->setHorarioSalida($getrow['hora_salida']);
            $Horario->setHorarioEntradaRestaurante($getrow['hora_entrada_restaurante']);
            $Horario->setFechaHorario($getrow['fecha_horario']);
            $Horario->setEstado($getrow['estado']);
            $Horario->setCreatedAt($getrow['created_at']);
            $Horario->setUpdatedAt($getrow['updated_at']);
            $Horario->setDeletedAt($getrow['deleted_at']);


        }
        $Horario->Disconnect();
        return $Horario;
    }


}