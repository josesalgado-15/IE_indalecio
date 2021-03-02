<?php
namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Horario extends AbstractDBConnection implements Model, JsonSerializable
{
    //Propiedades

    protected ?int $id; //Visibilidad (public, protected, private)
    protected string $hora_entrada_sede;
    protected string $hora_salida;
    protected string $hora_entrada_restaurante;
    protected Carbon $fecha;
    protected string $estado;
    protected int $sedes_id;
    protected Carbon $created_at;
    protected Carbon $updated_at;
    protected Carbon $deleted_at;

    /* Relaciones */
    private ?Sede $sede;

    /**
     * Asistencia constructor. Recibe un array asociativo
     * @param array $horario
     */

    //Metodo Constructor
    public function __construct (array $horario = [])
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->setId($horario['id'] ?? NULL);
        $this->setHoraEntradaSede($horario['hora_entrada_sede'] ?? '');
        $this->setHoraSalida($horario['hora_salida'] ?? '');
        $this->setHoraEntradaRestaurante($horario['hora_entrada_restaurante'] ?? '');
        $this->setFecha( !empty($horario['fecha']) ? Carbon::parse($horario['fecha']) : new Carbon());
        $this->setEstado($horario['estado'] ?? '');
        $this->setSedesId($horario['sedes_id'] ?? 0);
        $this->setCreatedAt(!empty($horario['created_at']) ? Carbon::parse($horario['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($horario['updated_at']) ? Carbon::parse($horario['updated_at']) : new Carbon());
        $this->setDeletedAt(!empty($horario['deleted_at']) ? Carbon::parse($horario['deleted_at']) : new Carbon());
    }


    function __destruct()
    {
        if($this->isConnected){
            $this->Disconnect();
        }
    }

    /**
     * @return int|mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed|string
     */
    public function getHoraEntradaSede(): string
    {
        return $this->hora_entrada_sede;
    }

    /**
     * @param mixed|string $hora_entrada_sede
     */
    public function setHoraEntradaSede(string $hora_entrada_sede): void
    {
        $this->hora_entrada_sede = $hora_entrada_sede;
    }

    /**
     * @return mixed|string
     */
    public function getHoraSalida(): string
    {
        return $this->hora_salida;
    }

    /**
     * @param mixed|string $hora_salida
     */
    public function setHoraSalida(string $hora_salida): void
    {
        $this->hora_salida = $hora_salida;
    }

    /**
     * @return mixed|string
     */
    public function getHoraEntradaRestaurante(): string
    {
        return $this->hora_entrada_restaurante;
    }

    /**
     * @param mixed|string $hora_entrada_restaurante
     */
    public function setHoraEntradaRestaurante(string $hora_entrada_restaurante): void
    {
        $this->hora_entrada_restaurante = $hora_entrada_restaurante;
    }

    /**
     * @return Carbon|mixed
     */
    public function getFecha(): Carbon
    {
        return $this->fecha->locale('es');
    }

    /**
     * @param Carbon|mixed $fecha
     */
    public function setFecha(Carbon $fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed|string
     */
    public function getEstado(): string
    {
        return $this->estado;
    }

    /**
     * @param mixed|string $hora_ingreso
     */
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return int|mixed
     */
    public function getSedesId(): int
    {
        return $this->sedes_id;
    }

    /**
     * @param int $sedes_id
     */
    public function setSedesId(int $sedes_id): void
    {
        $this->sedes_id = $sedes_id;
    }

    /**
     * @return Carbon|mixed
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at->locale('es');
    }

    /**
     * @param Carbon|mixed $created_at
     */
    public function setCreatedAt(Carbon $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return Carbon|mixed
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at->locale('es');
    }

    /**
     * @param Carbon|mixed $updated_at
     */
    public function setUpdatedAt(Carbon $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return Carbon|mixed
     */
    public function getDeletedAt(): Carbon
    {
        return $this->deleted_at->locale('es');
    }

    /**
     * @param Carbon|mixed $deleted_at
     */
    public function setDeletedAt(Carbon $deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }

    /**
     * @return Sede|null
     */
    public function getSede(): ?Sede
    {
        if(!empty($this->sedes_id)){
            $this->sede = Sede::searchForId($this->sedes_id) ?? new Sede();
            return $this->sede;
        }
        return NULL;
    }


    /**
     * @param string $query
     * @return bool|null
     */
    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' =>    $this->getId(),
            ':hora_entrada_sede' =>  $this->getHoraEntradaSede(),
            ':hora_salida' =>   $this->getHoraSalida(),
            ':hora_entrada_restaurante' =>  $this->getHoraEntradaRestaurante(),
            ':fecha' =>   $this->getFecha()->toDateTimeString(),
            ':estado' =>   $this->getEstado(),
            ':sedes_id' =>   $this->getSedesId()


        ];
        $this->Connect();
        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;
    }


    /**
     * @return bool|null
     */

    function insert(): ?bool
    {
        $query = "INSERT INTO dbindalecio.horarios VALUES (:id,:hora_entrada_sede,:hora_salida,:hora_entrada_restaurante,:fecha,:estado,:sedes_id,NOW(),NULL,NULL)";
        return $this->save($query);
    }


    /**
     * @return bool|null
     */
    public function update() : ?bool
    {
        $query = "UPDATE dbindalecio.horarios SET 
            hora_entrada_restaurante = :hora_entrada_restaurante, hora_salida = :hora_salida,
            hora_entrada_restaurante = :hora_entrada_restaurante, fecha = :fecha,
            estado = :estado, sedes_id = :sedes_id, updated_at = NOW() WHERE id = :id";
        return $this->save($query);
    }


    /**
     * @return mixed
     */
    public function deleted() : bool
    {
        $this->setEstado("Inactivo"); //Cambia el estado
        return $this->update();                    //Guarda los cambios..
    }


    /**
     * @param $query
     * @return mixed
     */
    public static function search($query) : ?array
    {
        try {
            $arrHorarios = array();
            $tmp = new Horario();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Horario = new Horario($valor);
                array_push($arrHorarios, $Horario);
                unset($Horario);
            }
            return $arrHorarios;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return NULL;
    }


    /**
     * @param $id
     * @return Horario
     * @throws Exception
     */
    public static function searchForId($id) : ?Horario
    {
        try {
            if ($id > 0) {
                $Horario = new Horario();
                $Horario->Connect();
                $getrow = $Horario->getRow("SELECT * FROM dbindalecio.horarios WHERE id =?", array($id));

                $Horario->Disconnect();
                return ($getrow) ? new Horario($getrow) : null;
            }else{
                throw new Exception('Id de Horario Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return NULL;
    }


    /**
     * @return array
     * @throws Exception
     */
    public static function getAll() : array
    {
        return Horario::search("SELECT * FROM dbindalecio.horarios");
    }

    static function horarioRegistrado($hora_entrada_sede, $hora_salida, $hora_entrada_restaurante, $sedes_id): bool
    {
        $result = Horario::search("SELECT * FROM dbindalecio.horarios where hora_entrada_sede = '" . $hora_entrada_sede. "' and hora_salida = '".$hora_salida ."'  and hora_entrada_restaurante = '".$hora_entrada_restaurante ."' and $sedes_id = '".$sedes_id ."'" );
        if ( !empty($result) && count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function __toString() : string
    {
        return "Hora de entrada a Sede: $this->hora_entrada_sede, Hora de salida: $this->hora_salida, Hora de entrada a Restaurante: $this->hora_entrada_restaurante, Fecha: $this->fecha,  Sede: $this->sedes_id, Estado: $this->estado";
    }

    /*
    public function Login($User, $Password){
        try {
            $resultUsuarios = Usuarios::search("SELECT * FROM usuarios WHERE user = '$User'");
            if(count($resultUsuarios) >= 1){
                if($resultUsuarios[0]->password == $Password){
                    if($resultUsuarios[0]->estado == 'Activo'){
                        return $resultUsuarios[0];
                    }else{
                        return "Usuario Inactivo";
                    }
                }else{
                    return "Contraseña Incorrecta";
                }
            }else{
                return "Usuario Incorrecto";
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
            return "Error en Servidor";
        }
    }
*/


    public function jsonSerialize()
    {
        return [

            'id' =>    $this->getId(),
            'hora_entrada_sede' =>  $this->getHoraEntradaSede(),
            'hora_salida' =>   $this->getHoraSalida(),
            'hora_entrada_restaurante' =>  $this->getHoraEntradaRestaurante(),
            'fecha' =>   $this->getFecha()->toDateTimeString(),
            'estado' =>   $this->getEstado(),
            'sedes_id' =>   $this->getSedesId(),
            'created_at' =>  $this->getCreatedAt()->toDateTimeString(), //YYYY-MM-DD HH:MM:SS
            'updated_at' =>  $this->getUpdatedAt()->toDateTimeString(),
            'deleted_at' =>  $this->getDeletedAt()->toDateTimeString()


        ];
    }

}