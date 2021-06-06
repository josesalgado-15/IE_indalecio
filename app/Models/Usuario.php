<?php
namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Usuario extends AbstractDBConnection implements Model, JsonSerializable
{
    //Propiedades

    protected ?int $id; //Visibilidad (public, protected, private)
    protected string $nombres;
    protected string $apellidos;
    protected string $telefono;
    protected string $numero_documento;
    protected string $tipo_documento;
    protected Carbon $fecha_nacimiento;
    protected string $direccion;
    protected int $municipios_id;
    protected string $genero;
    protected ?string $rol;
    protected string $correo;
    protected ?string $contrasena;
    protected string $estado;
    protected ?string $nombre_acudiente;
    protected string $telefono_acudiente;
    protected ?string $correo_acudiente;
    protected int $instituciones_id;
    protected Carbon $created_at;
    protected Carbon $updated_at;


    /* Relaciones */
    private ?Municipios $municipio;
    private ?Institucion $institucion;
    private ?array $matriculas;
    private ?array $novedades;
    private ?array $asistencias;

    /**
     * Usuarios constructor. Recibe un array asociativo
     * @param array $usuario
     */

    public function __construct(array $usuario = [])
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->setId($usuario['id'] ?? NULL);
        $this->setNombres($usuario['nombres'] ?? '');
        $this->setApellidos($usuario['apellidos'] ?? '');
        $this->setTelefono($usuario['telefono'] ?? '');
        $this->setNumeroDocumento($usuario['numero_documento'] ?? '');
        $this->setTipoDocumento($usuario['tipo_documento'] ?? '');
        $this->setFechaNacimiento(!empty($usuario['fecha_nacimiento']) ? Carbon::parse($usuario['fecha_nacimiento']) : new Carbon());
        $this->setDireccion($usuario['direccion'] ?? '');
        $this->setMunicipiosId($usuario['municipios_id'] ?? 0);
        $this->setGenero($usuario['genero'] ?? '');
        $this->setRol($usuario['rol'] ?? '');
        $this->setCorreo($usuario['correo'] ?? '');
        $this->setContrasena($usuario['contrasena'] ?? '');
        $this->setEstado($usuario['estado'] ?? '');
        $this->setNombreAcudiente($usuario['nombre_acudiente'] ?? '');
        $this->setTelefonoAcudiente($usuario['telefono_acudiente'] ?? '');
        $this->setCorreoAcudiente($usuario['correo_acudiente'] ?? '');
        $this->setInstitucionesId($usuario['instituciones_id'] ?? 0);
        $this->setCreatedAt(!empty($usuario['created_at']) ? Carbon::parse($usuario['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($usuario['updated_at']) ? Carbon::parse($usuario['updated_at']) : new Carbon());;
    }


    function __destruct()
    {
        if ($this->isConnected) {
            $this->Disconnect();
        }
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombres(): string
    {
        return ucwords($this->nombres);
    }

    /**
     * @param string $nombres
     */
    public function setNombres(string $nombres): void
    {
        $this->nombres = trim(mb_strtolower($nombres, 'UTF-8'));
    }

    /**
     * @return string
     */
    public function getApellidos(): string
    {
        return ucwords($this->apellidos);
    }

    /**
     * @param string $apellidos
     */
    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = trim(mb_strtolower($apellidos, 'UTF-8'));
    }


    /**
     * @return int
     */
    public function getTelefono(): string
    {
        return $this->telefono;
    }

    /**
     * @param int $telefono
     */
    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }


    /**
     * @return int
     */
    public function getNumeroDocumento(): string
    {
        return $this->numero_documento;
    }

    /**
     * @param int $numero_documento
     */
    public function setNumeroDocumento(string $numero_documento): void
    {
        $this->numero_documento = $numero_documento;
    }

    /**
     * @return string
     */
    public function getTipoDocumento(): string
    {
        return $this->tipo_documento;
    }

    /**
     * @param string $tipo_documento
     */
    public function setTipoDocumento(string $tipo_documento): void
    {
        $this->tipo_documento = $tipo_documento;
    }

    /**
     * @return string
     */
    public function getFechaNacimiento(): Carbon
    {
        return $this->fecha_nacimiento->locale('es');
    }

    /**
     * @param string $fecha_nacimiento
     */
    public function setFechaNacimiento(Carbon $fecha_nacimiento): void
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    /**
     * @return string
     */
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     */
    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return string
     */
    public function getGenero(): string
    {
        return $this->genero;
    }

    /**
     * @param string $genero
     */
    public function setGenero(string $genero): void
    {
        $this->genero = $genero;
    }


    /**
     * @return string
     */
    public function getRol(): ?string
    {
        return $this->rol;
    }

    /**
     * @param mixed|string $rol
     */
    public function setRol(?string $rol): void
    {
        $this->rol = $rol;
    }

    /**
     * @return string
     */
    public function getCorreo(): string
    {
        return $this->correo;
    }

    /**
     * @param string $correo
     */
    public function setCorreo(string $correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return string|null
     */
    public function getContrasena(): ?string
    {
        return $this->contrasena;
    }

    /**
     * @param string|null $contrasena
     */
    public function setContrasena(?string $contrasena): void
    {
        $this->contrasena = $contrasena;
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
    public function getNombreAcudiente(): string
    {
        return $this->nombre_acudiente;
    }

    /**
     * @param string $nombre_acudiente
     */
    public function setNombreAcudiente(string $nombre_acudiente): void
    {
        $this->nombre_acudiente = $nombre_acudiente;
    }


    /**
     * @return string
     */
    public function getTelefonoAcudiente(): string
    {
        return $this->telefono_acudiente;
    }

    /**
     * @param string $telefono_acudiente
     */
    public function setTelefonoAcudiente(string $telefono_acudiente): void
    {
        $this->telefono_acudiente = $telefono_acudiente;
    }

    /**
     * @return string
     */
    public function getCorreoAcudiente(): string
    {
        return $this->correo_acudiente;
    }

    /**
     * @param string $correo_acudiente
     */
    public function setCorreoAcudiente(string $correo_acudiente): void
    {
        $this->correo_acudiente = $correo_acudiente;
    }

    /**
     * @return int
     */
    public function getMunicipiosId(): int
    {
        return $this->municipios_id;
    }

    /**
     * @param int $municipios_id
     */
    public function setMunicipiosId(int $municipios_id): void
    {
        $this->municipios_id = $municipios_id;
    }

    /**
     * @return int|mixed|string
     */
    public function getInstitucionesId()
    {
        return $this->instituciones_id;
    }

    /**
     * @param int|mixed|string $instituciones_id
     */
    public function setInstitucionesId($instituciones_id): void
    {
        $this->instituciones_id = $instituciones_id;
    }


    /**
     * @return string
     */

    public function getCreatedAt(): Carbon
    {
        return $this->created_at->locale('es');
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(Carbon $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at->locale('es');
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt(Carbon $updated_at): void
    {
        $this->updated_at = $updated_at;
    }


    /**
     * @return Municipios
     */
    public function getMunicipio(): ?Municipios
    {
        if (!empty($this->municipios_id)) {
            $this->municipio = Municipios::searchForId($this->municipios_id) ?? new Municipios();
            return $this->municipio;
        }
        return NULL;
    }

    /**
     * @return Institucion
     */
    public function getInstitucion(): ?Institucion
    {
        if (!empty($this->instituciones_id)) {
            $this->institucion = Institucion::searchForId($this->instituciones_id) ?? new Institucion();
            return $this->institucion;
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
            ':id' => $this->getId(),
            ':nombres' => $this->getNombres(),
            ':apellidos' => $this->getApellidos(),
            ':telefono' => $this->getTelefono(),
            ':numero_documento' => $this->getNumeroDocumento(),
            ':tipo_documento' => $this->getTipoDocumento(),
            ':fecha_nacimiento' => $this->getFechaNacimiento()->toDateString(),
            ':direccion' => $this->getDireccion(),
            ':municipios_id' => $this->getMunicipiosId(),
            ':genero' => $this->getGenero(),
            ':rol' => $this->getRol(),
            ':correo' => $this->getCorreo(),
            ':contrasena' => $this->getContrasena(),
            ':estado' => $this->getEstado(),
            ':nombre_acudiente' => $this->getNombreAcudiente(),
            ':telefono_acudiente' => $this->getTelefonoAcudiente(),
            ':correo_acudiente' => $this->getCorreoAcudiente(),
            ':instituciones_id' => $this->getInstitucionesId(),

        ];
        $this->Connect();
        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;

    }

    public function insert(): ?bool
    {
        $query = "INSERT INTO dbindalecio.usuarios VALUES (
            :id,:nombres,:apellidos,:telefono,
            :numero_documento,:tipo_documento,:fecha_nacimiento,:direccion,:municipios_id,
            :genero,:rol,:correo,:contrasena,:estado,:nombre_acudiente,:telefono_acudiente,:correo_acudiente,:instituciones_id,NOW(),NULL)";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */

    public function update(): ?bool
    {
        $query = "UPDATE dbindalecio.usuarios SET 
            nombres = :nombres, apellidos = :apellidos, telefono = :telefono,
            numero_documento = :numero_documento, tipo_documento = :tipo_documento, fecha_nacimiento = :fecha_nacimiento,
            direccion = :direccion, municipios_id = :municipios_id,
            genero = :genero, rol = :rol, correo = :correo, contrasena = :contrasena, estado = :estado,
            nombre_acudiente = :nombre_acudiente, telefono_acudiente = :telefono_acudiente, correo_acudiente = :correo_acudiente,
          instituciones_id = :instituciones_id, updated_at = NOW() WHERE id = :id";

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
    public static function search($query): ?array
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
            GeneralFunctions::logFile('Exception', $e, 'error');
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
            } else {
                throw new Exception('Id de usuario Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
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
     * @param $documento
     * @return bool
     * @throws Exception
     */
    public static function usuarioRegistrado($documento): bool
    {
        $result = Usuario::search("SELECT * FROM dbindalecio.usuarios where numero_documento = " . $documento);
        if (!empty($result) && count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function nombresCompletos(): string
    {
        return $this->nombres . " " . $this->apellidos;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "Nombres: $this->nombres, Apellidos: $this->nombres, Tipo Documento: $this->tipo_documento, Documento: $this->numero_documento, Telefono: $this->telefono, Direccion: $this->direccion, Direccion: $this->fecha_nacimiento->toDateTimeString()";
    }

    public function Login($correo, $contrasena)
    {
        try {
            $resultUsuarios = Usuario::search("SELECT * FROM usuarios WHERE correo = '$correo'");
            if (count($resultUsuarios) >= 1) {
                if ($resultUsuarios[0]->contrasena == $contrasena) {
                    if ($resultUsuarios[0]->estado == 'Activo') {
                        return $resultUsuarios[0];
                    } else {
                        return "Usuario Inactivo";
                    }
                } else {
                    return "Contraseña Incorrecta";
                }
            } else {
                return "Usuario Incorrecto";
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
            return "Error en Servidor";
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nombres' => $this->getNombres(),
            'apellidos' => $this->getApellidos(),
            'telefono' => $this->getTelefono(),
            'numero_documento' => $this->getNumeroDocumento(),
            'tipo_documento' => $this->getTipoDocumento(),
            'fecha_nacimiento' => $this->getFechaNacimiento()->toDateString(),
            'direccion' => $this->getDireccion(),
            'municipios_id' => $this->getMunicipiosId(),
            'genero' => $this->getGenero(),
            'rol' => $this->getRol(),
            'correo' => $this->getCorreo(),
            'contrasena' => $this->getContrasena(),
            'estado' => $this->getEstado(),
            'nombre_acudiente' => $this->getNombreAcudiente(),
            'telegono_acudiente' => $this->getTelefonoAcudiente(),
            'correo_acudiente' => $this->getCorreoAcudiente(),
            'instituciones_id' => $this->getInstitucionesId(),
            'created_at' => $this->getCreatedAt()->toDateTimeString(),
            'updated_at' => $this->getUpdatedAt()->toDateTimeString(),
        ];
    }

}