<?php
namespace App\Models;

use App\Interfaces\Model;
use App\Models\Municipios;
use Carbon\Carbon;
use Exception;
use JsonSerializable;
use function Symfony\Component\Translation\t;

class Institucion extends AbstractDBConnection implements Model, JsonSerializable
{
    protected ?int $id; //Visibilidad (public, protected, private)
    protected string $nombre;
    protected string $nit;
    protected string $direccion;
    protected string $municipios_id;
    protected string $rector_id;
    protected int $telefono;
    protected string $correo;
    protected string $estado;

    protected Carbon $created_at;
    protected Carbon $updated_at;


    /* Relaciones */
    private ?Municipios $municipio;
    private ?Usuario $rector;

    /**
     * Usuarios constructor. Recibe un array asociativo
     * @param array $Institucion
     */

    public function __construct(array $Institucion = [])
    {

        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->setId($Institucion['id'] ?? NULL);

        $this->setNombre($Institucion['nombre'] ?? '');
        $this->setNit($Institucion ['nit'] ?? '');
        $this->setDireccion($Institucion['direccion'] ?? '');
        $this->setMunicipiosId($Institucion['municipios_id'] ?? 0);
        $this->setRectorId($Institucion['rector_id'] ?? '');
        $this->setTelefono($Institucion['telefono'] ?? 0);
        $this->setCorreo($Institucion['correo'] ?? '');
        $this->setEstado($Institucion['estado'] ?? '');

        $this->setCreatedAt(!empty ($Institucion ['created_at']) ? Carbon::parse($Institucion['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty ($Institucion ['updated_at']) ? Carbon::parse($Institucion['updated_at']) : new Carbon());
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
    public function getNombre(): string
    {
        return ucwords($this->nombre);
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = trim(mb_strtolower($nombre, 'UTF-8'));
    }

    /**
     * @return mixed|string
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * @param mixed|string $nit
     */
    public function setNit($nit): void
    {
        $this->nit = $nit;
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
    public function getMunicipiosId(): string
    {
        return $this->municipios_id;
    }

    /**
     * @param string $municipios_id
     */
    public function setMunicipiosId(string $municipios_id): void
    {
        $this->municipios_id = $municipios_id;
    }

    /**
     * @return string
     */
    public function getRectorId(): string
    {
        return $this->rector_id;
    }

    /**
     * @param string $rector_id
     */
    public function setRectorId(string $rector_id): void
    {
        $this->rector_id = $rector_id;
    }


    /**
     * @return string
     */
    public function getTelefono(): string
    {
        return $this->telefono;
    }

    /**
     * @param string $telefono
     */
    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
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

    public function getInstitucion(): ?Institucion
    {
        if (!empty($this->instituciones_id)) {
            $this->institucion = Institucion::searchForId($this->instituciones_id) ?? new Institucion();
            return $this->institucion;
        }
        return NULL;
    }


    public function getRector(): ?Usuario
    {
        if(!empty($this->rector_id)){
            $this->rector = Usuario::searchForId($this->rector_id) ?? new Usuario();
            return $this->rector;
        }
        return NULL;
    }

    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' => $this->getId(),
            ':nombre' => $this->getNombre(),
            ':nit' => $this->getNit(),
            ':direccion' => $this->getDireccion(),
            ':municipios_id' => $this->getMunicipiosId(),
            ':rector_id' => $this->getRectorId(),
            ':telefono' => $this->getTelefono(),
            ':correo' => $this->getCorreo(),
            ':estado' => $this->getEstado(),
            ':created_at' => $this->getCreatedAt()->toDateTimeString(),
            ':updated_at' => $this->getUpdatedAt()->toDateTimeString(),
        ];
        $this->Connect();
        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;

    }

    public function insert(): ?bool
    {
        $query = "INSERT INTO dbindalecio.instituciones VALUES (
            :id,:nombre,:nit,:direccion,:municipios_id,
            :rector_id,:telefono,:correo,:estado,:created_at,:updated_at
        )";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */

    public function update(): ?bool
    {
        $query = "UPDATE dbindalecio.instituciones SET 
            nombre = :nombre, nit= :nit, direccion = :direccion, municipios_id = :municipios_id,
            rector_id = :rector_id, telefono = :telefono, correo = :correo,
            estado = :estado, created_At = :created_at, updated_at = :updated_at
          WHERE id = :id";

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
     * @return Institucion|array
     * @throws Exception
     */
    public static function search($query): ?array
    {
        try {
            $arrInstitucion = array();
            $tmp = new Institucion();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            if (!empty($getrows)) {
                foreach ($getrows as $valor) {
                    $Institucion = new Institucion($valor);
                    array_push($arrInstitucion, $Institucion);
                    unset($Institucion);
                }
                return $arrInstitucion;
            }
            return null;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }

    /**
     * @param $id
     * @return Institucion
     * @throws Exception
     */
    public static function searchForId(int $id): ?Institucion
    {
        try {
            if ($id > 0) {
                $tmpInstitucion = new Institucion();
                $tmpInstitucion->Connect();
                $getrow = $tmpInstitucion->getRow("SELECT * FROM dbindalecio.instituciones WHERE id =?", array($id));
                $tmpInstitucion->Disconnect();
                return ($getrow) ? new Institucion($getrow) : null;
            } else {
                throw new Exception('Id de Institucion Invalido');
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
        return Institucion::search("SELECT * FROM dbindalecio.instituciones");
    }

    /**
     * @param $documento
     * @return bool
     * @throws Exception
     */
    public static function institucionRegistrada($nit): bool
    {
        $result = Institucion::search("SELECT * FROM dbindalecio.instituciones where nit = " . $nit);
        if (!empty($result) && count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "Nombre: $this->nombre, Nit: $this->nit, Direccion: $this->direccion, Municipip: $this->municipio_id, Rector: $this->rector_id, Telefono: $this->telefono, Correo: $this->correo, Estado: $this->estado";
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'nit' => $this->getNit(),
            'direccion' => $this->getDireccion(),
            'municipio_id' => $this->getMunicipiosId(),
            'rector_id' => $this->getRectorId(),
            'telefono' => $this->getTelefono(),
            'correo' => $this->getCorreo(),
            'estado' => $this->getEstado(),
            'created_at' => $this->getCreatedAt()->toDateTimeString(),
            'updated_at' => $this->getUpdatedAt()->toDateTimeString(),
        ];
    }


}