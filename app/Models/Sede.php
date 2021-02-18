<?php
namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Sede extends AbstractDBConnection implements Model, JsonSerializable
{
    /* Tipos de Datos => bool, int, float,  */
    private ?int $id;
    private string $nombre;
    private string $direccion;
    private int $municipio_id;
    private int $telefono;
    private int $instituciones_id;
    private string $estado;
    private Carbon $created_at;
    private Carbon $updated_at;

    /* Relaciones */
    private ?Municipios $municipio;

    /**
     * Usuarios constructor. Recibe un array asociativo
     * @param array $sede
     */
    public function __construct(array $sede = [])
    {
        parent::__construct();
        $this->setId($sede['id'] ?? NULL);
        $this->setNombre($sede['nombre'] ?? '');
        $this->setDireccion($sede['direccion'] ?? '');
        $this->setMunicipioId($sede['municipio_id'] ?? 0);
        $this->setTelefono($sede['telefono'] ?? 0);
        $this->setInstitucionesId($sede['instituciones_id'] ?? 0);
        $this->setEstado($sede['estado'] ?? '');
        $this->setCreatedAt(!empty($sede['created_at']) ? Carbon::parse($sede['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($sede['updated_at']) ? Carbon::parse($sede['updated_at']) : new Carbon());
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
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
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
     * @return int
     */
    public function getMunicipioId(): int
    {
        return $this->municipio_id;
    }

    /**
     * @param int $municipio_id
     */
    public function setMunicipioId(int $municipio_id): void
    {
        $this->municipio_id = $municipio_id;
    }

    /**
     * @return int
     */
    public function getTelefono(): int
    {
        return $this->telefono;
    }

    /**
     * @param int $telefono
     */
    public function setTelefono(int $telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return int
     */
    public function getInstitucionesId(): int
    {
        return $this->instituciones_id;
    }

    /**
     * @param int $instituciones_id
     */
    public function setInstitucionesId(int $instituciones_id): void
    {
        $this->instituciones_id = $instituciones_id;
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
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    /**
     * @param Carbon $created_at
     */
    public function setCreatedAt(Carbon $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    /**
     * @param Carbon $updated_at
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
        if(!empty($this->municipio_id)){
            $this->municipio = Municipios::searchForId($this->municipio_id) ?? new Municipios();
            return $this->municipio;
        }
        return NULL;
    }

    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' =>    $this->getId(),
            ':nombre' =>   $this->getNombre(),
            ':direccion' =>   $this->getDireccion(),
            ':municipio_id' =>   $this->getMunicipioId(),
            ':telefono' =>   $this->getTelefono(),
            ':instituciones_id' =>   $this->getInstitucionesId(),
            ':estado' =>   $this->getEstado()
        ];
        $this->Connect();

        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;
    }

    function insert()
    {
        $query = "INSERT INTO dbindalecio.sedes VALUES (
            :id,:nombre,:direccion,:municipio_id,
            :telefono,:instituciones_id,
            :estado,NOW(),NULL)
        )";
        return $this->save($query);
    }

    function update()
    {
        $query = "UPDATE dbindalecio.sedes SET 
            nombre = :nombre,direccion = :direccion, municipio_id = :municipio_id,
            telefono = :telefono, instituciones_id = :instituciones_id,  
            estado = :estado, updated_at = NOW() WHERE id = :id";
        return $this->save($query);
    }

    function deleted()
    {
        $this->setEstado("Inactivo");
        return $this->update();
    }

    public static function search($query): ?array
    {
        try {
            $arrSedes = array();
            $tmp = new Sede();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Sede = new Sede($valor);
                array_push($arrSedes, $Sede);
                unset($Sede);
            }
            return $arrSedes;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    public static function searchForId($id) : ?Sede
    {
        try {
            if ($id > 0) {
                $tmpSede = new Sede();
                $tmpSede->Connect();
                $getrow = $tmpSede->getRow("SELECT * FROM dbindalecio.sedes WHERE id =?", array($id));
                $tmpSede->Disconnect();
                return ($getrow) ? new Sede($getrow) : null;
            }else{
                throw new Exception('Id de sede Invalida');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    static function getAll(): ?array
    {
        return Sede::search("SELECT * FROM dbindalecio.sedes");
    }

    public static function sedesRegistrado($nombre): bool
    {
        $nombre = trim(strtolower($nombre));
        $result = Sede::search("SELECT * FROM dbindalecio.sedes where nombre = '". $nombre."'");
        if ( !empty($result) && count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'direccion' => $this->getDireccion(),
            'municipio_id' => $this->getMunicipioId(),
            'telefono' => $this->getTelefono(),
            'instituciones_id' => $this->getInstitucionesId(),
            'estado' => $this->getEstado(),
            'created_at' => $this->getCreatedAt()->toDateTimeString(),
            'updated_at' => $this->getUpdatedAt()->toDateTimeString(),
        ];
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return "Nombre: $this->nombre, Direccion: $this->direccion, Municipios_id: $this->municipio_id, Telefono: $this->telefono, Instituciones_id: $this->instituciones_id";
    }

}