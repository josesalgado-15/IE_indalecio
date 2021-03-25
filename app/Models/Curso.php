<?php
namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Curso extends AbstractDBConnection implements Model, JsonSerializable
{

    //Propiedades

    protected ?int $id; //Visibilidad (public, protected, private)
    protected string $nombre;
    protected string $director;
    protected string $representante;
    protected int $cantidad;
    protected int $grados_id;
    protected int $horarios_id;

    protected string $estado;
    protected Carbon $created_at;
    protected Carbon $updated_at;
    protected Carbon $deleted_at;

    /* Relaciones */
    private ?Grado $grado;
    private ?Horario $horario;
    private ?array $MatriculasCurso;


    /**
     * Asistencia constructor. Recibe un array asociativo
     * @param array $curso
     */

    //Metodo Constructor
    public function __construct (array $curso = [])
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->setId($curso['id'] ?? NULL);
        $this->setNombre($curso['nombre'] ?? '');
        $this->setDirector($curso['director'] ?? '');
        $this->setRepresentante($curso['representante'] ?? '');
        $this->setCantidad($curso['cantidad'] ?? 0);
        $this->setGradosId($curso['grados_id'] ?? 0);
        $this->setHorariosId($curso['horarios_id'] ?? 0);
        $this->setEstado($curso['estado'] ?? '');
        $this->setCreatedAt(!empty($curso['created_at']) ? Carbon::parse($curso['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($curso['updated_at']) ? Carbon::parse($curso['updated_at']) : new Carbon());
        $this->setDeletedAt(!empty($curso['deleted_at']) ? Carbon::parse($curso['deleted_at']) : new Carbon());

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
    public function getDirector(): string
    {
        return $this->director;
    }

    /**
     * @param mixed|string $director
     */
    public function setDirector(string $director): void
    {
        $this->director = $director;
    }

    /**
     * @return mixed|string
     */
    public function getRepresentante(): string
    {
        return $this->representante;
    }

    /**
     * @param mixed|string representante
     */
    public function setRepresentante(string $representante): void
    {
        $this->representante = $representante;
    }

    /**
     * @return int
     */
    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    /**
     * @param int $cantidad
     */
    public function setCantidad(int $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return int
     */
    public function getGradosId(): int
    {
        return $this->grados_id;
    }

    /**
     * @param int $grados_id
     */
    public function setGradosId(int $grados_id): void
    {
        $this->grados_id = $grados_id;
    }

    /**
     * @return int
     */
    public function getHorariosId(): int
    {
        return $this->horarios_id;
    }

    /**
     * @param int $horarios_id
     */
    public function setHorariosId(int $horarios_id): void
    {
        $this->horarios_id = $horarios_id;
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
        return $this->created_at;
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
        return $this->updated_at;
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
        return $this->deleted_at;
    }

    /**
     * @param Carbon|mixed deleted_at
     */
    public function setDeletedAt(Carbon $deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }

    /* Relaciones */

    /**
     * @return Grado|null
     */
    public function getGrado(): ?Grado
    {
        if(!empty($this->grados_id)){
            $this->grado = Grado::searchForId($this->grados_id) ?? new Grado();
            return $this->grado;
        }
        return NULL;
    }


    /**
     * @return Horario|null
     */
    public function getHorario(): ?Horario
    {
        if(!empty($this->horarios_id)){
            $this->horario = Horario::searchForId($this->horarios_id) ?? new Horario();
            return $this->horario;
        }
        return NULL;
    }

    /**
     * retorna un array de matriculas que perteneces a un Curso
     * @return array
     */
    public function getMatriculasCurso(): ?array
    {
        if(!empty($this->id)){
            $this-> MatriculasCurso = Matricula::search("SELECT * FROM matriculas WHERE cursos_id = ".$this->id);
            return $this-> MatriculasCurso;
        }
        return null;
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
            ':director' =>   $this->getDirector(),
            ':representante' =>  $this->getRepresentante(),
            ':cantidad' =>   $this->getCantidad(),
            ':grados_id' =>   $this->getGradosId(),
            ':horarios_id' =>   $this->getHorariosId(),
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
        $query = "INSERT INTO dbindalecio.cursos VALUES (:id,:nombre,:director,:representante,:cantidad,:grados_id,:horarios_id,:estado,NOW(),NULL,NULL)";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update() : ?bool
    {
        $query = "UPDATE dbindalecio.cursos SET 
            nombre = :nombre, director = :director,
            representante = :representante, cantidad = :cantidad,
            grados_id = :grados_id, horarios_id = :horarios_id,
            estado = :estado,updated_at = NOW() WHERE id = :id";
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
            $arrCursos = array();
            $tmp = new Curso();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Curso = new Curso($valor);
                array_push($arrCursos, $Curso);
                unset($Curso);
            }
            return $arrCursos;
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
    public static function searchForId($id) : ?Curso
    {
        try {
            if ($id > 0) {
                $Curso = new Curso();
                $Curso->Connect();
                $getrow = $Curso->getRow("SELECT * FROM dbindalecio.cursos WHERE id =?", array($id));

                $Curso->Disconnect();
                return ($getrow) ? new Curso($getrow) : null;
            }else{
                throw new Exception('Id de Curso Invalido');
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
        return Curso::search("SELECT * FROM dbindalecio.cursos");
    }

    static function cursoRegistrado($nombre, $director): bool
    {
        $nombre = strtolower(trim($nombre));
        $result = Curso::search("SELECT * FROM dbindalecio.cursos where nombre = '" . $nombre. "' and director = '".$director ."'" );
        if ( !empty($result) && count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function __toString() : string
    {
        return "Nombre: $this->nombre, Director: $this->director, Representante: $this->representante, Cantidad: $this->cantidad, Grado: $this->grados_id, Horario: $this->horarios_id, Estado: $this->estado";
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
            'nombre' =>  $this->getNombre(),
            'director' =>   $this->getDirector(),
            'representante' =>  $this->getRepresentante(),
            'cantidad' =>   $this->getCantidad(),
            'grados_id' =>   $this->getGradosId(),
            'horarios_id' =>   $this->getHorariosId(),
            'estado' =>   $this->getEstado(),
            'created_at' =>  $this->getCreatedAt()->toDateTimeString(), //YYYY-MM-DD HH:MM:SS
            'updated_at' =>  $this->getUpdatedAt()->toDateTimeString(),
            'deleted_at' =>  $this->getDeletedAt()->toDateTimeString()

        ];
    }
}