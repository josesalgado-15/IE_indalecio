<?php
namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Novedad extends AbstractDBConnection implements Model, JsonSerializable
{

    //Propiedades

    protected ?int $id; //Visibilidad (public, protected, private)
    protected string $tipo;
    protected string $justificacion;
    protected string $observacion;
    protected string $estado;
    protected int $administrador_id;
    protected int $asistencia_id;

    protected Carbon $created_at;
    protected Carbon $updated_at;
    protected Carbon $deleted_at;

    /* Relaciones */
    private ?Usuario $administrador;
    private ?Asistencia $asistencia;



    //Metodo Constructor
    /**
     * Novedad constructor. Recibe un array asociativo
     * @param array $novedad
     */
    public function __construct (array $novedad = [])
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->setId($novedad['id'] ?? NULL);
        $this->setTipo($novedad['tipo'] ?? '');
        $this->setJustificacion($novedad['justificacion'] ?? '');
        $this->setObservacion($novedad['observacion'] ?? '');
        $this->setEstado( $novedad['estado'] ?? '');
        $this->setAdministradorId($novedad['administrador_id'] ?? 0) ;
        $this->setAsistenciaId($novedad['asistencia_id'] ?? 0);
        $this->setCreatedAt(!empty($novedad['created_at']) ? Carbon::parse($novedad['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($novedad['updated_at']) ? Carbon::parse($novedad['updated_at']) : new Carbon());
        $this->setDeletedAt(!empty($novedad['deleted_at']) ? Carbon::parse($novedad['deleted_at']) : new Carbon());

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
    public function getTipo(): string
    {
        return $this->tipo;
    }

    /**
     * @param mixed|string $tipo
     */
    public function setTipo(string $tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed|string
     */
    public function getJustificacion(): string
    {
        return $this->justificacion;
    }

    /**
     * @param mixed|string $justificacion
     */
    public function setJustificacion(string $justificacion): void
    {
        $this->justificacion = $justificacion;
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
     * @return int
     */
    public function getAdministradorId(): int
    {
        return $this->administrador_id;
    }

    /**
     * @param int $administrador_id
     */
    public function setAdministradorId(int $administrador_id): void
    {
        $this->administrador_id = $administrador_id;
    }

    /**
     * @return int
     */
    public function getAsistenciaId(): int
    {
        return $this->asistencia_id;
    }

    /**
     * @param int $asistencia_id
     */
    public function setAsistenciaId(int $asistencia_id): void
    {
        $this->asistencia_id = $asistencia_id;
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

    /* Relaciones */
    /**
     * Retorna el objeto usuario
     * @return Usuario|null
     */


    public function getAdministrador(): ?Usuario
    {
        if(!empty($this->administrador_id)){
            $this->administrador = Usuario::searchForId($this->administrador_id) ?? new Usuario();
            return $this->administrador;
        }
        return NULL;
    }


    /**
     * Retorna el objeto asistencia
     * @return Asistencia|null
     */
    public function getAsistencia(): ?Asistencia
    {
        if(!empty($this->asistencia_id)){
            $this->asistencia = Asistencia::searchForId($this->asistencia_id) ?? new Asistencia();
            return $this->asistencia;
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
            ':tipo' =>  $this->getTipo(),
            ':justificacion' =>   $this->getJustificacion(),
            ':observacion' =>  $this->getObservacion(),
            ':estado' =>   $this->getEstado(),
            ':administrador_id' =>   $this->getAdministradorId(),
            ':asistencia_id' =>   $this->getAsistenciaId()



        ];
        $this->Connect();
        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;
    }

    function insert(): ?bool
    {
        $query = "INSERT INTO dbindalecio.novedades VALUES (:id,:tipo,:justificacion,:observacion,:estado,:administrador_id,:asistencia_id,NOW(),NULL,NULL)";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update() : ?bool
    {
        $query = "UPDATE dbindalecio.novedades SET 
            tipo = :tipo, justificacion = :justificacion,
            observacion = :observacion, estado = :estado,
            administrador_id = :administrador_id, asistencia_id = :asistencia_id, updated_at = NOW() WHERE id = :id";
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
            $arrNovedades = array();
            $tmp = new Novedad();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Novedad = new Novedad($valor);
                array_push($arrNovedades, $Novedad);
                unset($Novedad);
            }
            return $arrNovedades;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return NULL;
    }



    /**
     * @param $id
     * @return Novedad
     * @throws Exception
     */
    public static function searchForId($id) : ?Novedad
    {
        try {
            if ($id > 0) {
                $Novedad = new Novedad();
                $Novedad->Connect();
                $getrow = $Novedad->getRow("SELECT * FROM dbindalecio.novedades WHERE id =?", array($id));

                $Novedad->Disconnect();
                return ($getrow) ? new Novedad($getrow) : null;
            }else{
                throw new Exception('Id de Novedad Invalido');
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
        return Novedad::search("SELECT * FROM dbindalecio.novedades");
    }

    public static function novedadRegistrada(string $tipo, int $asistencia_id): bool
    {
        $result = Novedad::search("SELECT * FROM dbindalecio.novedades where tipo = '" . $tipo. "' and asistencia_id = '".$asistencia_id ."'");
        if ( count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function __toString() : string
    {
        return "Tipo: $this->tipo, Justificación: $this->justificacion, Observación: $this->observacion, Estado: $this->estado, Administrador: $this->administrador_id, Asistencia: $this->asistencia_id";
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
            'tipo' =>  $this->getTipo(),
            'justificacion' =>   $this->getJustificacion(),
            'observacion' =>  $this->getObservacion(),
            'estado' =>   $this->getEstado(),
            'administrador_id' =>   $this->getAdministradorId(),
            'asistencia_id' =>   $this->getAsistenciaId(),
            'created_at' =>  $this->getCreatedAt()->toDateTimeString(), //YYYY-MM-DD HH:MM:SS
            'updated_at' =>  $this->getUpdatedAt()->toDateTimeString(),
            'deleted_at' =>  $this->getDeletedAt()->toDateTimeString()

        ];
    }

}
