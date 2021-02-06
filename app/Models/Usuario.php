<?php
namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Usuario extends AbstractDBConnection implements Model, JsonSerializable
{
    //Propiedades

    private ?int $id; //Visibilidad (public, protected, private)
    private string $nombres;
    private string $apellidos;
    private int $edad;
    private int $telefono;
    private int $numero_documento;
    private string $tipo_documento;
    private Carbon $fecha_nacimiento;
    private string $direccion;
    private int $municipios_id;

    private string $genero;
    private string $rol;
    private ?string $correo;
    private ?string $contrasena;
    private string $estado;
    private string $nombre_acudiente;
    private string $telefono_acudiente;
    private string $correo_acudiente;


    private int $instituciones_id;
    private Carbon $created_at;
    private Carbon $updated_at;
    private Carbon $deleted_at;

    /* Relaciones */
    private ?Municipio $municipio;
    private ?Institucion $institucion;




    /**
     * Usuario constructor.
     *
     */

    //Metodo Constructor
    public function __construct ($usuario = array())
    {
        parent::__construct();
        $this->setId($usuario['id'] ?? NULL);
        $this->setNombres($usuario['nombres'] ?? '');
        $this->setApellidos($usuario['apellidos'] ?? '');
        $this->setEdad($usuario['edad'] ?? 0);
        $this->setTelefono($usuario['telefono'] ?? 0);
        $this->setNumeroDocumento($usuario['numero_documento'] ?? 0);
        $this->setTipoDocumento($usuario['tipo_documento'] ?? '');
        $this->setFechaNacimiento( !empty($usuario['fecha_nacimiento']) ? Carbon::parse($usuario['fecha_nacimiento']) : new Carbon());
        $this->setDireccion($usuario['direccion'] ?? '');
        $this->setMunicipiosId($usuario['municipios_id'] ?? 0);
        $this->setGenero($usuario['genero'] ?? '');
        $this->setRol($usuario['rol'] ?? '');
        $this->setCorreo($usuario['correo'] ?? '');
        $this->setContrasena($usuario['contrasena'] ?? '');
        $this->setNombreAcudiente($usuario['nombre_acudiente'] ?? '');
        $this->setTelefonoAcudiente($usuario['telefono_acudiente'] ?? '');
        $this->setCorreoAcudiente($usuario['correo_acudiente'] ?? '');
        $this->setInstitucionesId($usuario['instituciones_id'] ?? 0);
        $this->setEstado($usuario['estado'] ?? '');
        $this->setCreatedAt(!empty($usuario['created_at']) ? Carbon::parse($usuario['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($usuario['updated_at']) ? Carbon::parse($usuario['updated_at']) : new Carbon());
        $this->setDeletedAt(!empty($usuario['created_at']) ? Carbon::parse($usuario['deleted_at']) : new Carbon());
    }


    function __destruct()
    {
        if($this->isConnected){
            $this->Disconnect();
        }
    }

    public static function usuarioRegistrado($numeroDocumento): bool
    {
        $result = Usuario::search("SELECT * FROM dbindalecio.usuarios where numero_documento = " . $numeroDocumento);
        if ( !empty($result) && count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }




    /**
     * @return int|mixed|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|mixed|null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed|string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param mixed|string $nombres
     */
    public function setNombres($nombres): void
    {
        $this->nombres = $nombres;
    }

    /**
     * @return mixed|string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param mixed|string $apellidos
     */
    public function setApellidos($apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return int|mixed
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * @param int|mixed $edad
     */
    public function setEdad($edad): void
    {
        $this->edad = $edad;
    }

    /**
     * @return int|mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param int|mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return int|mixed
     */
    public function getNumeroDocumento()
    {
        return $this->numero_documento;
    }

    /**
     * @param int|mixed $numero_documento
     */
    public function setNumeroDocumento($numero_documento): void
    {
        $this->numero_documento = $numero_documento;
    }

    /**
     * @return mixed|string
     */
    public function getTipoDocumento()
    {
        return $this->tipo_documento;
    }

    /**
     * @param mixed|string $tipo_documento
     */
    public function setTipoDocumento($tipo_documento): void
    {
        $this->tipo_documento = $tipo_documento;
    }

    /**
     * @return Carbon|mixed
     */
    public function getFechaNacimiento(): Carbon
    {
        return $this->fecha_nacimiento->locale('es');
    }

    /**
     * @param Carbon|mixed $fecha_nacimiento
     */
    public function setFechaNacimiento($fecha_nacimiento): void
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    /**
     * @return mixed|string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed|string $direccion
     */
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return int|mixed
     */
    public function getMunicipiosId()
    {
        return $this->municipios_id;
    }

    /**
     * @param int|mixed $municipios_id
     */
    public function setMunicipiosId($municipios_id): void
    {
        $this->municipios_id = $municipios_id;
    }

    /**
     * @return mixed|string
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * @param mixed|string $genero
     */
    public function setGenero($genero): void
    {
        $this->genero = $genero;
    }

    /**
     * @return mixed|string
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * @param mixed|string $rol
     */
    public function setRol($rol): void
    {
        $this->rol = $rol;
    }

    /**
     * @return mixed|string|null
     */
    public function getCorreo() : ?string
    {
        return $this->correo;
    }

    /**
     * @param mixed|string|null $correo
     */
    public function setCorreo(?string $correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed|string|null
     */
    public function getContrasena() : ?string
    {
        return $this->contrasena;
    }

    /**
     * @param mixed|string|null $contrasena
     */
    public function setContrasena(?string $contrasena): void
    {
        $this->contrasena = $contrasena;
    }

    /**
     * @return mixed|string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed|string $estado
     */
    public function setEstado($estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed|string
     */
    public function getNombreAcudiente()
    {
        return $this->nombre_acudiente;
    }

    /**
     * @param mixed|string $nombre_acudiente
     */
    public function setNombreAcudiente($nombre_acudiente): void
    {
        $this->nombre_acudiente = $nombre_acudiente;
    }

    /**
     * @return mixed|string
     */
    public function getTelefonoAcudiente()
    {
        return $this->telefono_acudiente;
    }

    /**
     * @param mixed|string $telefono_acudiente
     */
    public function setTelefonoAcudiente($telefono_acudiente): void
    {
        $this->telefono_acudiente = $telefono_acudiente;
    }

    /**
     * @return mixed|string
     */
    public function getCorreoAcudiente()
    {
        return $this->correo_acudiente;
    }

    /**
     * @param mixed|string $correo_acudiente
     */
    public function setCorreoAcudiente($correo_acudiente): void
    {
        $this->correo_acudiente = $correo_acudiente;
    }

    /**
     * @return int|mixed
     */
    public function getInstitucionesId()
    {
        return $this->instituciones_id;
    }

    /**
     * @param int|mixed $instituciones_id
     */
    public function setInstitucionesId($instituciones_id): void
    {
        $this->instituciones_id = $instituciones_id;
    }

    /**
     * @return Carbon|mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param Carbon|mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return Carbon|mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param Carbon|mixed $updated_at
     */
    public function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return Carbon|mixed
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * @param Carbon|mixed $deleted_at
     */
    public function setDeletedAt($deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }

    /**
     * @return Municipio
     */
    public function getMunicipio(): ?Municipio
    {
        if(!empty($this->municipios_id)){
            $this->municipio = Municipio::searchForId($this->municipios_id) ?? new Municipio();
            return $this->municipio;
        }
        return NULL;
    }

    /**
     * @return Institucion|null
     */
    public function getInstitucion(): ?Institucion
    {
        if(!empty($this->instituciones_id)){
            $this->institucion = Institucion::searchForId($this->instituciones_id) ?? new Institucion();
            return $this->institucion;
        }
        return NULL;
    }


    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' =>    $this->getId(),
            ':nombres' =>   $this->getNombres(),
            ':apellidos' =>   $this->getApellidos(),
            ':edad' =>   $this->getEdad(),
            ':telefono' =>   $this->getTelefono(),
            ':numero_documento' =>   $this->getNumeroDocumento(),
            ':tipo_documento' =>  $this->getTipoDocumento(),
            ':fecha_nacimiento' =>  $this->getFechaNacimiento()->toDateString(), //YYYY-MM-DD
            ':direccion' =>   $this->getDireccion(),
            ':municipios_id' =>   $this->getMunicipiosId(),
            ':genero' =>  $this->getGenero(),
            ':rol' =>   $this->getRol(),
            ':correo' =>   $this->getCorreo(),
            ':contrasena' =>   $this->getContrasena(),
            ':estado' =>   $this->getEstado(),
            ':nombre_acudiente' =>   $this->getNombreAcudiente(),
            ':telefono_acudiente' =>   $this->getTelefonoAcudiente(),
            ':correo_acudiente' =>   $this->getCorreoAcudiente(),
            ':instituciones_id' =>   $this->getInstitucionesId(),

            ':created_at' =>  $this->getCreatedAt()->toDateTimeString(), //YYYY-MM-DD HH:MM:SS
            ':updated_at' =>  $this->getUpdatedAt()->toDateTimeString(),
            ':deleted_at' =>  $this->getDeletedAt()->toDateTimeString()
        ];
        $this->Connect();
        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;
    }

    /**
     * @return bool|null
     */
    public function insert(): ?bool
    {
        $query = "INSERT INTO dbindalecio.usuarios VALUES (
            :id,:nombres,:apellidos,:edad,:telefono,
            :numero_documento,:tipo_documento,:fecha_nacimiento,:direccion,:municiopios_id,
            :genero,:rol,:correo,:contrasena,:estado,:nombre_acudiente,:telefono_acudiente,:correo_acudiente,instituciones_id,
            :created_at,:updated_at,:deleted_at
            
            
        )";
        return $this->save($query);
    }


    /**
     * @return bool|null
     */
    public function update(): ?bool
    {
        $query = "UPDATE dbindalecio.usuarios SET 
            nombres = :nombres, apellidos = :apellidos, edad = :edad, 
            telefono = :telefono, numero_documento = :numero_documento, tipo_documento = :tipo_documento, 
            fecha_nacimiento = :fecha_nacimiento, direccion = :direccion, municipios_id = :municipios_id,  
            genero = :genero, rol = :rol, correo = :correo, contrasena = :contrasena, estado = :estado, 
            nombre_acudiente = :nombre_acudiente, telefono_acudiente = :telefono_acudiente, correo_acudiente = :correo_acudiente, 
            instituciones_id = :instituciones_id, created_at = :created_at, updated_at = :updated_at, deleted_at = :deleted_at WHERE id = :id";
        return $this->save($query);
    }


    /**
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function deleted(): bool
    {
        $this->setEstado("Inactivo"); //Cambia el estado del Usuario
        return $this->update();                    //Guarda los cambios..
    }

    /**
     * @param $query
     * @return Usuario|array
     * @throws Exception
     */
    public static function search($query) : ?array
    {
        try {
            $arrUsuarios = array();
            $tmp = new Usuario();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            if (!empty($getrows)) {
                foreach ($getrows as $valor) {
                    $Usuario = new Usuario($valor);
                    array_push($arrUsuarios, $Usuario);
                    unset($Usuario);
                }
                return $arrUsuarios;
            }
            return null;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    /**
     * @param $id
     * @return Usuario
     * @throws Exception
     */
    public static function searchForId(int $id): ?Usuario
    {
        try {
            if ($id > 0) {
                $tmpUsuario = new Usuario();
                $tmpUsuario->Connect();
                $getrow = $tmpUsuario->getRow("SELECT * FROM dbindalecio.usuarios WHERE id =?", array($id));
                $tmpUsuario->Disconnect();
                return ($getrow) ? new Usuario($getrow) : null;
            }else{
                throw new Exception('Id de usuario Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }



    /**
     * @return array
     * @throws Exception
     */
    public static function getAll(): array
    {
        return Usuario::search("SELECT * FROM dbindalecio.usuarios");
    }

    /**
     * @return string
     */
    public function nombresCompletos() : string
    {
        return $this->nombres . " " . $this->apellidos;
    }



    /**
     * @return string
     */
    public function __toString() : string
    {
        return "Nombres: $this->nombres, Apellidos: $this->apellidos, Edad: $this->edad, Numero De Documento: $this->numero_documento, tipo_documento: $this->tipo_documento, Fecha De Nacimiento: $this->fecha_nacimiento->toDateTimeString(), Direccion: $this->direccion, Municipio: $this->municipios_id,
         genero: $this->genero, rol: $this->rol, Correo: $this->correo, contraseña: $this->contrasena, estado: $this->estado, Nombre De Acudiente: $this->nombre_acudiente, Telefono De Acudiente: $this->telefono_acudiente, Correo De Acudiente: $this->correo_acudiente, Institucion: $this->instituciones_id";
    }

    public function Login($Correo, $Contrasena){
        try {
            $resultUsuarios = Usuario::search("SELECT * FROM usuarios WHERE correo = '$Correo'");
            if(count($resultUsuarios) >= 1){
                if($resultUsuarios[0]->contrasena == $Contrasena){
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

    public function jsonSerialize()
    {
        return [

            'id' =>    $this->getId(),
            'nombres' =>   $this->getNombres(),
            'apellidos' =>   $this->getApellidos(),
            'edad' =>   $this->getEdad(),
            'telefono' =>   $this->getTelefono(),
            'numero_documento' =>   $this->getNumeroDocumento(),
            'tipo_documento' =>  $this->getTipoDocumento(),
            'fecha_nacimiento' =>  $this->getFechaNacimiento()->toDateString(), //YYYY-MM-DD
            'direccion' =>   $this->getDireccion(),
            'municipios_id' =>   $this->getMunicipiosId(),
            'genero' =>  $this->getGenero(),
            'rol' =>   $this->getRol(),
            'correo' =>   $this->getCorreo(),
            'contrasena' =>   $this->getContrasena(),
            'estado' =>   $this->getEstado(),
            'nombre_acudiente' =>   $this->getNombreAcudiente(),
            'telefono_acudiente' =>   $this->getTelefonoAcudiente(),
            'correo_acudiente' =>   $this->getCorreoAcudiente(),
            'instituciones_id' =>   $this->getInstitucionesId(),

            'created_at' =>  $this->getCreatedAt()->toDateTimeString(), //YYYY-MM-DD HH:MM:SS
            'updated_at' =>  $this->getUpdatedAt()->toDateTimeString(),
            'deleted_at' =>  $this->getDeletedAt()->toDateTimeString()

        ];
    }


}
