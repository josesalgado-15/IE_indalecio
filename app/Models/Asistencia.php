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
    protected string $observacion;
    protected int $matriculas_id;
    protected string $estado;
    protected string $reporte;
    protected Carbon $created_at;
    protected Carbon $updated_at;
    protected Carbon $deleted_at;

    /* Relaciones */
    private ?Matricula $matricula;



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
        $this->setObservacion($asistencia['observacion'] ?? '');
        $this->setMatriculasId($asistencia['matriculas_id'] ?? 0);
        $this->setEstado($asistencia['estado'] ?? '');
        $this->setReporte($asistencia['reporte'] ?? '');
        $this->setCreatedAt(!empty($asistencia['created_at']) ? Carbon::parse($asistencia['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($asistencia['updated_at']) ? Carbon::parse($asistencia['updated_at']) : new Carbon());
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
     * @return int
     */
    public function getMatriculasId(): int
    {
        return $this->matriculas_id;
    }

    /**
     * @param int $matriculas_id
     */
    public function setMatriculasId(int $matriculas_id): void
    {
        $this->matriculas_id = $matriculas_id;
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
     * @return string
     */
    public function getReporte(): string
    {
        return $this->reporte;
    }

    /**
     * @param string $reporte
     */
    public function setReporte(string $reporte): void
    {
        $this->reporte = $reporte;
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


    /* Relaciones */
    /**
     * @return Matricula|null
     */
    public function getMatricula(): ?Matricula
    {
        if(!empty($this->matriculas_id)){
            $this->matricula = Matricula::searchForId($this->matriculas_id) ?? new Matricula();
            return $this->matricula;
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
            ':observacion' =>  $this->getObservacion(),
            ':matriculas_id' =>   $this->getMatriculasId(),
            ':estado' =>   $this->getEstado(),
            ':reporte' =>   $this->getReporte()


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
        $query = "INSERT INTO dbindalecio.asistencias VALUES (:id,:fecha,:observacion,:matriculas_id,:estado,:reporte, NOW(),NULL)";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update() : ?bool
    {
        $query = "UPDATE dbindalecio.asistencias SET 
            fecha = :fecha,observacion = :observacion,matriculas_id = :matriculas_id,
            estado = :estado, reporte = :reporte, updated_at = NOW() WHERE id = :id";
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

    public static function searchForMatricula($matriculas_id) : ?Asistencia
    {
        try {
            if ($matriculas_id > 0) {
                $Asistencia = new Asistencia();
                $Asistencia->Connect();
                $getrow = $Asistencia->getRow("SELECT * FROM dbindalecio.asistencias WHERE matriculas_id =?", array($matriculas_id));

                $Asistencia->Disconnect();
                return ($getrow) ? new Asistencia($getrow) : null;
            }else{
                throw new Exception('Id de Matricula Invalido');
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

    static function asistenciaRegistrada($fecha, $matriculas_id): bool
    {
        $fecha= strtotime(date_create_from_format('d M, Y', '00:00:00'));
        $result = Asistencia::search("SELECT * FROM dbindalecio.asistencias where fecha = '" . $fecha ."' and matriculas_id = '".$matriculas_id ."'" );
        if ( !empty($result) && count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function __toString() : string
    {
        return "Fecha: $this->fecha, Observación: $this->observacion, Usuario: $this->matriculas_id, Estado: $this->estado";
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
            'observacion' =>  $this->getObservacion(),
            'matriculas_id' =>   $this->getMatriculasId(),
            'estado' =>   $this->getEstado(),
            'reporte' =>   $this->getReporte(),
            'updated_at' =>  $this->getUpdatedAt()->toDateTimeString()

        ];
    }
}