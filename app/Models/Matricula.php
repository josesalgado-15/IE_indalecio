<?php
namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Matricula extends AbstractDBConnection implements Model, JsonSerializable
{

    //Propiedades

    protected ?int $id; //Visibilidad (public, protected, private)
    protected Carbon $vigencia;
    protected int $usuarios_id;
    protected int $cursos_id;
    protected string $estado;
    protected Carbon $created_at;
    protected Carbon $updated_at;
    protected Carbon $deleted_at;

    /* Relaciones */
    private ?Usuario $usuario;
    private ?Curso $curso;




    /**
     * Matricula constructor. Recibe un array asociativo
     * @param array $matricula
     */

    //Metodo Constructor
    public function __construct (array $matricula = [])
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->setId($matricula['id'] ?? NULL);
        $this->setVigencia( !empty($matricula['vigencia']) ? Carbon::parse($matricula['vigencia']) : new Carbon());
        $this->setUsuariosId($matricula['usuarios_id'] ?? 0);
        $this->setCursosId($matricula['cursos_id'] ?? 0);
        $this->setEstado($matricula['estado'] ?? '');
        $this->setCreatedAt(!empty($matricula['created_at']) ? Carbon::parse($matricula['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($matricula['updated_at']) ? Carbon::parse($matricula['updated_at']) : new Carbon());
        $this->setDeletedAt(!empty($matricula['deleted_at']) ? Carbon::parse($matricula['deleted_at']) : new Carbon());

    }

    function __destruct()
    {
        if($this->isConnected){
            $this->Disconnect();
        }
    }

    /**
     * @return int|null
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
    public function getVigencia(): Carbon
    {
        return $this->vigencia->locale('es');
    }

    /**
     * @param Carbon|mixed $vigencia
     */
    public function setVigencia(Carbon $vigencia): void
    {
        $this->vigencia = $vigencia;
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
     * @return int
     */
    public function getCursosId(): int
    {
        return $this->cursos_id;
    }

    /**
     * @param int $cursos_id
     */
    public function setCursosId(int $cursos_id): void
    {
        $this->cursos_id = $cursos_id;
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
     * @return Curso|null
     */
    public function getCurso(): ?Curso
    {
        if(!empty($this->cursos_id)){
            $this->curso = Curso::searchForId($this->cursos_id) ?? new Curso();
            return $this->curso;
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
            ':vigencia' =>  $this->getVigencia()->toDateTimeString(),
            ':usuarios_id' =>   $this->getUsuariosId(),
            ':cursos_id' =>  $this->getCursosId(),
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
        $query = "INSERT INTO dbindalecio.matriculas VALUES (:id,:vigencia,:usuarios_id,:cursos_id,:estado,NOW(),NULL,NULL)";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update() : ?bool
    {
        $query = "UPDATE dbindalecio.matriculas SET 
            vigencia = :vigencia, usuarios_id = :usuarios_id,
            cursos_id = :cursos_id, estado = :estado, updated_at = NOW() WHERE id = :id";
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
            $arrMatriculas = array();
            $tmp = new Matricula();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Matricula = new Matricula($valor);
                array_push($arrMatriculas, $Matricula);
                unset($Matricula);
            }
            return $arrMatriculas;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return NULL;
    }


    /**
     * @param $id
     * @return Matricula
     * @throws Exception
     */
    public static function searchForId($id) : ?Matricula
    {
        try {
            if ($id > 0) {
                $Matricula = new Matricula();
                $Matricula->Connect();
                $getrow = $Matricula->getRow("SELECT * FROM dbindalecio.matriculas WHERE id =?", array($id));

                $Matricula->Disconnect();
                return ($getrow) ? new Matricula($getrow) : null;
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
        return Matricula::search("SELECT * FROM dbindalecio.matriculas");
    }

    static function matriculaRegistrada($vigencia, $usuarios_id, $cursos_id): bool
    {
        $result = Matricula::search("SELECT * FROM dbindalecio.matriculas where vigencia = '" . $vigencia. "' and usuarios_id = '" . $usuarios_id. "' and cursos_id =  '".$cursos_id ."'" );
        if ( !empty($result) && count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function __toString() : string
    {
        return "Vigencia: $this->vigencia, Usuario: $this->usuarios_id, Curso: $this->cursos_id, Estado: $this->estado";
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
            'vigencia' =>  $this->getVigencia()->toDateTimeString(),
            'usuarios_id' =>   $this->getUsuariosId(),
            'cursos_id' =>  $this->getCursosId(),
            'estado' =>   $this->getEstado(),
            'created_at' =>  $this->getCreatedAt()->toDateTimeString(), //YYYY-MM-DD HH:MM:SS
            'updated_at' =>  $this->getUpdatedAt()->toDateTimeString(),
            'deleted_at' =>  $this->getDeletedAt()->toDateTimeString()

        ];
    }
}