<?php
namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Asistencia extends AbstractDBConnection implements Model, JsonSerializable
{

    //Propiedades

    protected ?int $id; //Visibilidad (public, protected, private)
    protected Carbon $fecha;
    protected string $hora_ingreso;
    protected string $observacion;
    protected string $tipo_ingreso;
    protected string $hora_salida;
    protected int $usuarios_id;
    protected string $estado;
    protected Carbon $updated_at;
    protected Carbon $deleted_at;

    /* Relaciones */
    private ?Usuario $usuario;



    /**
     * Asistencia constructor. Recibe un array asociativo
     * @param array $asistencia
     */

    //Metodo Constructor
    public function __construct (array $asistencia = [])
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->setId($asistencia['id'] ?? NULL);
        $this->setFecha( !empty($asistencia['fecha']) ? Carbon::parse($asistencia['fecha']) : new Carbon());
        $this->setHoraIngreso($asistencia['hora_ingreso'] ?? '');
        $this->setObservacion($asistencia['observacion'] ?? '');
        $this->setTipoIngreso($asistencia['tipo_ingreso'] ?? '');
        $this->setHoraSalida($asistencia['hora_salida'] ?? '');
        $this->setUsuariosId($asistencia['usuarios_id'] ?? 0);
        $this->setEstado($asistencia['estado'] ?? '');
        $this->setUpdatedAt(!empty($asistencia['updated_at']) ? Carbon::parse($asistencia['updated_at']) : new Carbon());
        $this->setDeletedAt(!empty($asistencia['deleted_at']) ? Carbon::parse($asistencia['deleted_at']) : new Carbon());
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
    public function getHoraIngreso(): string
    {
        return $this->hora_ingreso;
    }

    /**
     * @param mixed|string $hora_ingreso
     */
    public function setHoraIngreso(string $hora_ingreso): void
    {
        $this->hora_ingreso = $hora_ingreso;
    }

    /**
     * @return mixed|string
     */
    public function getObservacion(): string
    {
        return $this->observacion;
    }

    /**
     * @param mixed|string $observacion
     */
    public function setObservacion(string $observacion): void
    {
        $this->observacion = $observacion;
    }

    /**
     * @return mixed|string
     */
    public function getTipoIngreso(): string
    {
        return $this->tipo_ingreso;
    }

    /**
     * @param mixed|string $tipo_ingreso
     */
    public function setTipoIngreso(string $tipo_ingreso): void
    {
        $this->tipo_ingreso = $tipo_ingreso;
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
     * @return int
     */
    public function getUsuariosId(): int
    {
        return $this->usuarios_id;
    }

    /**
     * @param int $usuarios_id
     */
    public function setUsuariosId(int $usuarios_id): void
    {
        $this->usuarios_id = $usuarios_id;
    }

    /**
     * @return mixed|string
     */
    public function getEstado(): string
    {
        return $this->estado;
    }

    /**
     * @param mixed|string $estado
     */
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
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
     * @return Carbon
     */
    public function getDeletedAt(): Carbon
    {
        return $this->deleted_at->locale('es');
    }

    /**
     * @param Carbon $deleted_at
     */
    public function setDeletedAt(Carbon $deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }

    /* Relaciones */
    /**
     * @return Usuario|null
     */
    public function getUsuario(): ?Usuario
    {
        if(!empty($this->usuarios_id)){
            $this->usuario = Usuario::searchForId($this->usuarios_id) ?? new Usuario();
            return $this->usuario;
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
            ':fecha' =>  $this->getFecha()->toDateString(), //YYYY-MM-DD
            ':hora_ingreso' =>   $this->getHoraIngreso(),
            ':observacion' =>  $this->getObservacion(),
            ':tipo_ingreso' =>   $this->getTipoIngreso(),

            ':hora_salida' =>   $this->getHoraSalida(),
            ':usuarios_id' =>   $this->getUsuariosId(),

            ':estado' =>   $this->getEstado(),
            ':updated_at' =>  $this->getUpdatedAt()->toDateTimeString(),
            ':deleted_at' =>  $this->getDeletedAt()->toDateTimeString() //YYYY-MM-DD HH:MM:SS

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
        $query = "INSERT INTO dbindalecio.asistencias VALUES (:id,:fecha,:hora_ingreso,:observacion,:tipo_ingreso,:hora_salida,:usuarios_id,:estado,:updated_at,:deleted_at)";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update() : ?bool
    {
        $query = "UPDATE dbindalecio.asistencias SET 
            fecha = :fecha, hora_ingreso = :hora_ingreso,
            observacion = :observacion, tipo_ingreso = :tipo_ingreso,
            hora_salida = :hora_salida, usuarios_id = :usuarios_id,
            estado = :estado, updated_at = :updated_at, deleted_at = :deleted_at WHERE id = :id";
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
            $arrAsistencias = array();
            $tmp = new Asistencia();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Asistencia = new Asistencia($valor);
                array_push($arrAsistencias, $Asistencia);
                unset($Asistencia);
            }
            return $arrAsistencias;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return NULL;
    }


    /**
     * @param $id
     * @return Asistencia
     * @throws Exception
     */
    public static function searchForId($id) : ?Asistencia
    {
        try {
            if ($id > 0) {
                $Asistencia = new Asistencia();
                $Asistencia->Connect();
                $getrow = $Asistencia->getRow("SELECT * FROM dbindalecio.asistencias WHERE id =?", array($id));

                $Asistencia->Disconnect();
                return ($getrow) ? new Asistencia($getrow) : null;
            }else{
                throw new Exception('Id de Asistencia Invalido');
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
        return Asistencia::search("SELECT * FROM dbindalecio.asistencias");
    }

    static function asistenciaRegistrada($fecha, $hora_ingreso, $usuarios_id): bool
    {
        $result = Asistencia::search("SELECT * FROM dbindalecio.asistencias where fecha = '" . $fecha. "' and hora_ingreso = '".$hora_ingreso ."' and usuarios_id = '".$usuarios_id ."'" );
        if ( !empty($result) && count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function __toString() : string
    {
        return "Fecha: $this->fecha, Hora de Ingreso: $this->hora_ingreso, Observación: $this->observacion, Tipo de Ingreso: $this->tipo_ingreso, Hora de Salida: $this->hora_salida, Usuario: $this->usuarios_id, Estado: $this->estado";
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
            'fecha' =>  $this->getFecha()->toDateString(), //YYYY-MM-DD
            'hora_ingreso' =>   $this->getHoraIngreso(),
            'observacion' =>  $this->getObservacion(),
            'tipo_ingreso' =>   $this->getTipoIngreso(),
            'hora_salida' =>   $this->getHoraSalida(),
            'usuarios_id' =>   $this->getUsuariosId(),
            'estado' =>   $this->getEstado(),
            'updated_at' =>  $this->getUpdatedAt()->toDateTimeString(),
            'deleted_at' =>  $this->getDeletedAt()->toDateTimeString() //YYYY-MM-DD HH:MM:SS

        ];
    }
}