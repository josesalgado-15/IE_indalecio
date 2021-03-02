<?php
namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Grado extends AbstractDBConnection implements Model, JsonSerializable
{
    //Propiedades

    protected ?int $id; //Visibilidad (public, protected, private)
    protected string $nombre;
    protected string $estado;
    protected Carbon $created_at;
    protected Carbon $updated_at;
    protected Carbon $deleted_at;


    /**
     * Grado constructor. Recibe un array asociativo
     * @param array $grado
     */

    public function __construct(array $grado = [])
    {
        parent::__construct();
        $this->setId($grado['id'] ?? NULL);
        $this->setNombre( $grado['nombre'] ?? '');
        $this->setEstado($grado['estado'] ?? '');
        $this->setCreatedAt(!empty($grado['created_at']) ? Carbon::parse($grado['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($grado['updated_at']) ? Carbon::parse($grado['updated_at']) : new Carbon());
        $this->setDeletedAt(!empty($grado['deleted_at']) ? Carbon::parse($grado['deleted_at']) : new Carbon());
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
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param mixed|string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
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
     * @param string $query
     * @return bool|null
     */
    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' =>    $this->getId(),
            ':nombre' =>  $this->getNombre(),
            ':estado' =>   $this->getEstado()

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
        $query = "INSERT INTO dbindalecio.grados VALUES (:id,:nombre,:estado,NOW(),NULL,NULL)";
        return $this->save($query);
    }


    /**
     * @return bool|null
     */
    public function update() : ?bool
    {
        $query = "UPDATE dbindalecio.grados SET 
            nombre = :nombre, estado = :estado, created_at = :created_at, updated_at = NOW() WHERE id = :id";
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
            $arrGrados = array();
            $tmp = new Grado();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Grado = new Grado($valor);
                array_push($arrGrados, $Grado);
                unset($Grado);
            }
            return $arrGrados;
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
    public static function searchForId($id) : ?Grado
    {
        try {
            if ($id > 0) {
                $Grado = new Grado();
                $Grado->Connect();
                $getrow = $Grado->getRow("SELECT * FROM dbindalecio.grados WHERE id =?", array($id));

                $Grado->Disconnect();
                return ($getrow) ? new Grado($getrow) : null;
            }else{
                throw new Exception('Id de Grado Invalido');
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
        return Grado::search("SELECT * FROM dbindalecio.grados");
    }

    static function gradoRegistrado($nombre): bool
    {
        $nombre = strtolower(trim($nombre));
        $result = Grado::search("SELECT * FROM dbindalecio.grados where nombre = '" . $nombre. "'");
        if ( !empty($result) && count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function __toString() : string
    {
        return "nombre: $this->nombre, Estado: $this->estado";
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
            'nombre' =>  $this->getNombre(), //YYYY-MM-DD
            'estado' =>   $this->getEstado(),
            'created_at' =>  $this->getCreatedAt()->toDateTimeString(), //YYYY-MM-DD HH:MM:SS
            'updated_at' =>  $this->getUpdatedAt()->toDateTimeString(),
            'deleted_at' =>  $this->getDeletedAt()->toDateTimeString()

        ];
    }

}