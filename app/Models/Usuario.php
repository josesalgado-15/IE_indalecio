<?php

namespace App\Models;
use App\Models\BasicModel;
use Carbon\Carbon;

require_once('BasicModel.php');


class Usuario extends BasicModel
{
    //Propiedades

    protected int $id; //Visibilidad (public, protected, private)
    protected string $nombres;
    protected string $apellidos;
    protected int $edad;
    protected int $telefono;
    protected int $numero_documento;
    protected string $tipo_documento;
    protected string $fecha_nacimiento;
    protected string $direccion;

    protected int $municipios_id;

    protected string $genero;
    protected string $rol;
    protected string $correo;
    protected ?string $contrasena;
    protected string $estado;
    protected string $nombre_acudiente;
    protected string $telefono_acudiente;
    protected string $correo_acudiente;


    protected int $instituciones_id;
    protected string $created_at;
    protected string $updated_at;
    protected string $deleted_at;



    /**
     * Usuario constructor.
     *
     */

    //Metodo Constructor
    public function __construct ($usuario = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->id = $usuario['id'] ?? 0;
        $this->nombres = $usuario['nombres'] ?? '';
        $this->apellidos = $usuario['apellidos'] ?? '';
        $this->edad = $usuario['edad'] ?? 0;
        $this->telefono = $usuario['telefono'] ?? 0;
        $this->numero_documento = $usuario['numero_documento'] ?? 0;
        $this->tipo_documento = $usuario['tipo_documento'] ?? '';
        $this->fecha_nacimiento = $usuario['fecha_nacimiento'] ?? new Carbon();
        $this->direccion = $usuario['direccion'] ?? '';
        $this->municipios_id = $usuario['municipios_id'] ?? 0;
        $this->genero = $usuario['genero'] ?? '';
        $this->rol = $usuario['rol'] ?? '';
        $this->correo = $usuario['correo'] ?? '';
        $this->contrasena = $usuario['contrasena'] ?? null;
        $this->estado = $usuario['estado'] ?? '';
        $this->nombre_acudiente = $usuario['nombre_acudiente'] ?? '';
        $this->telefono_acudiente = $usuario['telefono_acudiente'] ?? '';
        $this->correo_acudiente = $usuario['correo_acudiente'] ?? '';
        $this->instituciones_id = $usuario['instituciones_id'] ?? 0;
        $this->created_at = $usuario['created_at'] ?? new Carbon();
        $this->updated_at = $usuario['updated_at'] ?? new Carbon();
        $this->deleted_at = $usuario['deleted_at'] ?? new Carbon();
    }


    function __destruct()
    {
        //    $this->Disconnect(); // Cierro Conexiones
    }

    public static function usuarioRegistrado($numeroDocumento): bool
    {
        $result = Usuario::search("SELECT * FROM dbindalecio.usuarios where numero_documento = " . $numeroDocumento);
        if ( count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombres(): string
    {
        return $this->nombres;
    }

    /**
     * @param string $nombres
     */
    public function setNombres(string $nombres): void
    {
        $this->nombres = $nombres;
    }

    /**
     * @return string
     */
    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     */
    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return int
     */
    public function getEdad(): int
    {
        return $this->edad;
    }

    /**
     * @param int $edad
     */
    public function setEdad(int $edad): void
    {
        $this->edad = $edad;
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
    public function getNumeroDocumento(): int
    {
        return $this->numero_documento;
    }

    /**
     * @param int $numero_documento
     */
    public function setNumeroDocumento(int $numero_documento): void
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
    public function getFechaNacimiento(): string
    {
        return $this->fecha_nacimiento;
    }

    /**
     * @param string $fecha_nacimiento
     */
    public function setFechaNacimiento(string $fecha_nacimiento): void
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
    public function getRol(): string
    {
        return $this->rol;
    }

    /**
     * @param string $rol
     */
    public function setRol(string $rol): void
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
     * @return int|mixed|string
     */
    public function getMunicipiosId()
    {
        return $this->municipios_id;
    }

    /**
     * @param int|mixed|string $municipios_id
     */
    public function setMunicipiosId($municipios_id): void
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

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return string
     */
    public function getDeletedAt(): string
    {
        return $this->deleted_at;
    }

    /**
     * @param string $deleted_at
     */
    public function setDeletedAt(string $deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }


    //PENDIENTE CORREGIR ERROR El argumento 1 pasado a Dotenv \ Dotenv :: create () debe ser una instancia de Dotenv \ Repository \
    // RepositoryInterface, cadena dada, llamada en C: \ laragon \ www \ institucion-educativa-indalecio- vasquez \ app \ Models \
    // GeneralFunctions.php en la línea 14 y definido en C: \ laragon \ www \ institucion-educativa-indalecio-vasquez \ vendor \ vlucas \ phpdotenv \ src \ Dotenv.php en la línea 62

    //No permite crear el usuario en la base de datos

    public function create()
    {
        var_dump($this);
        $result = $this->insertRow("INSERT INTO dbindalecio.usuarios VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW() , NULL ,NULL)", array(

                $this->getNombres(),
                $this->getApellidos(),
                $this->getEdad(),
                $this->getTelefono(),
                $this->getNumeroDocumento(),
                $this->getTipoDocumento(),
                $this->getFechaNacimiento(),
                $this->getDireccion(),
                $this->getMunicipiosId(),
                $this->getGenero(),
                $this->getRol(),
                $this->getCorreo(),
                $this->getContrasena(),
                $this->getEstado(),
                $this->getNombreAcudiente(),
                $this->getTelefonoAcudiente(),
                $this->getCorreoAcudiente(),
                $this->getInstitucionesId(),

                //$this->getCreatedAt(),
                //$this->getUpdatedAt(),
                //$this->getDeletedAt()


            )
        );
        $this->Disconnect();
        return $result;

    }

    public function update()
    {
        $result = $this->updateRow("UPDATE dbindalecio.usuarios SET nombres = ?, apellidos = ?, edad = ?, telefono = ?, numero_documento = ?, tipo_documento = ?, 
            fecha_nacimiento = ?, direccion = ?, municipios_id = ?,  genero = ?,  rol = ?,  correo = ?, contrasena = ?, estado = ?, nombre_acudiente = ?, telefono_acudiente = ?, correo_acudiente = ?,  instituciones_id = ? WHERE id = ?", array(

                $this->getNombres(),
                $this->getApellidos(),
                $this->getEdad(),
                $this->getTelefono(),
                $this->getNumeroDocumento(),
                $this->getTipoDocumento(),
                $this->getFechaNacimiento(),
                $this->getDireccion(),
                $this->getMunicipiosId(),
                $this->getGenero(),
                $this->getRol(),
                $this->getCorreo(),
                $this->getContrasena(),
                $this->getEstado(),
                $this->getNombreAcudiente(),
                $this->getTelefonoAcudiente(),
                $this->getCorreoAcudiente(),
                $this->getInstitucionesId(),
                //$this->getCreatedAt(),
                //$this->getUpdatedAt(),
                //$this->getDeletedAt(),
                $this->getId()

            )
        );
        $this->Disconnect();
        return $this;
    }

    public function deleted($id)
    {
        $result = $this->updateRow('UPDATE dbindalecio.usuarios SET estado = ? WHERE id = ?', array(
                'Inactivo',
                $this->getId()
            )
        );
    }

    public static function search($query)
    {
        $arrUsuarios = array();
        $tmp = new Usuario();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {

            $Usuario = new Usuario();
            $Usuario->setId($valor['id']);
            $Usuario->setNombres($valor['nombres']);
            $Usuario->setApellidos($valor['apellidos']);
            $Usuario->setEdad($valor['edad']);
            $Usuario->setTelefono($valor['telefono']);
            $Usuario->setNumeroDocumento($valor['numero_documento']);
            $Usuario->setTipoDocumento($valor['tipo_documento']);
            $Usuario->setFechaNacimiento($valor['fecha_nacimiento']);
            $Usuario->setDireccion($valor['direccion']);
            $Usuario->setMunicipiosId($valor['municipios_id']);
            $Usuario->setGenero($valor['genero']);
            $Usuario->setRol($valor['rol']);
            $Usuario->setCorreo($valor['correo']);
            $Usuario->setContrasena($valor['contrasena']);
            $Usuario->setEstado($valor['estado']);
            $Usuario->setNombreAcudiente($valor['nombre_acudiente']);
            $Usuario->setTelefonoAcudiente($valor['telefono_acudiente']);
            $Usuario->setCorreoAcudiente($valor['correo_acudiente']);
            $Usuario->setInstitucionesId($valor['instituciones_id']);
            //$Usuario->setCreatedAt($valor['created_at']);
            //$Usuario->setUpdatedAt($valor['updated_at']);
            //$Usuario->setDeletedAt($valor['deleted_at']);
            $Usuario->Disconnect();
            array_push($arrUsuarios, $Usuario);

        }
        $tmp->Disconnect();
        return $arrUsuarios;

    }

    public static function getAll()
    {
        return Usuario::search("SELECT * FROM dbindalecio.usuarios");
    }

    public static function searchForId($id)
    {
        $Usuario = null;
        if ($id>0){
            $Usuario = new Usuario();
            $getrow = $Usuario->getRow("SELECT * FROM dbindalecio.usuarios WHERE id =?", array($id));
            $Usuario->setId($getrow['id']);
            $Usuario->setNombres($getrow['nombres']);
            $Usuario->setApellidos($getrow['apellidos']);
            $Usuario->setEdad($getrow['edad']);
            $Usuario->setTelefono($getrow['telefono']);
            $Usuario->setNumeroDocumento($getrow['numero_documento']);
            $Usuario->setTipoDocumento($getrow['tipo_documento']);
            $Usuario->setFechaNacimiento($getrow['fecha_nacimiento']);
            $Usuario->setDireccion($getrow['direccion']);
            $Usuario->setMunicipiosId($getrow['municipios_id']);
            $Usuario->setGenero($getrow['genero']);
            $Usuario->setRol($getrow['rol']);
            $Usuario->setCorreo($getrow['correo']);
            $Usuario->setContrasena($getrow['contrasena']);
            $Usuario->setEstado($getrow['estado']);
            $Usuario->setNombreAcudiente($getrow['nombre_acudiente']);
            $Usuario->setTelefonoAcudiente($getrow['telefono_acudiente']);
            $Usuario->setCorreoAcudiente($getrow['correo_acudiente']);
            $Usuario->setInstitucionesId($getrow['instituciones_id']);
            //$Usuario->setCreatedAt($getrow['created_at']);
            //$Usuario->setUpdatedAt($getrow['updated_at']);
            //$Usuario->setDeletedAt($getrow['deleted_at']);
        }
        $Usuario->Disconnect();
        return $Usuario;
    }


    //Metodos
    public function saludar(?string $nombres = "Julian"): string
    { //Visibilidad, function, nombre metodo(parametros), retorno
        return "Hola " . $nombres . ", Soy " . $this->apellidos . " de color " . " como estas?<br/>";
    }

    public function __toString(): string
    {
        return
            "<strong>Sus datos son:</strong> ".
            "<br>".
            "<br>".
            "<strong>Id:</strong> " . $this->getId() . "<br/>" .
            "<strong>Nombres:</strong> " . $this->getNombres() . "<br/>" .
            "<strong>Apellidos:</strong> " . $this->getApellidos() . "<br/>".
            "<strong>Edad:</strong> " . $this->getEdad() . "<br/>".
            "<strong>Teléfono:</strong> " . $this->getTelefono() . "<br/>".
            "<strong>Número de documento:</strong> " . $this->getNumeroDocumento() . "<br/>" .
            "<strong>Tipo de documento:</strong> " . $this->getTipoDocumento() . "<br/>".
            "<strong>Fecha de nacimiento:</strong> " . $this->getFechaNacimiento() . "<br/>".
            "<strong>Dirección:</strong> " . $this->getDireccion() . "<br/>".
            "<strong>Municipio:</strong> " . $this->getMunicipiosId() . "<br/>".
            "<strong>Genero:</strong> " . $this->getGenero() . "<br/>".
            "<strong>Rol:</strong> " . $this->getRol() . "<br/>".
            "<strong>Correo:</strong> " . $this->getCorreo() . "<br/>".
            "<strong>Contraseña:</strong> " . $this->getContrasena() . "<br/>".
            "<strong>Estado:</strong> " . $this->getEstado() . "<br/>".
            "<strong>Nombre de acudiente:</strong> " . $this->getNombreAcudiente() . "<br/>".
            "<strong>Teléfono de acudiente:</strong> " . $this->getTelefonoAcudiente() . "<br/>".
            "<strong>Correo de acudiente:</strong> " . $this->getCorreoAcudiente() . "<br/>".
            "<strong>Institución:</strong> " . $this->getInstitucionesId() . "<br/>";

        /*
            "<strong>Id de Institución:</strong> " . $this->getInstitucionIdInstitucion() . "<br/>";
        */



    }


}
