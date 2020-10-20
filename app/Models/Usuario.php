<?php


use App\Models\BasicModel;

require_once('BasicModel.php');


class Usuario extends BasicModel
{
    //Propiedades

    protected int $id; //Visibilidad (public, protected, private)
    protected string $nombres;
    protected string $apellidos;
    protected int $edad;
    protected string $telefono;
    protected int $numeroDocumento;
    protected string $tipoDocumento;
    protected string $fechaNacimiento;
    protected string $direccion;

    protected string $municipios_id;

    protected string $genero;
    protected string $rol;
    protected string $correo;
    protected ?string $contrasena;
    protected string $estado;
    protected string $nombreAcudiente;
    protected string $telefonoAcudiente;
    protected string $correoAcudiente;

    //Dejé las llaves foraneas como string para despues cambiarlas al saber de que tipo o como deben quedar

    protected string $instituciones_id;
    protected string $created_at;
    protected string $updated_at;
    protected string $deleted_at;



    /**
     * Usuario constructor.
     *
     */

    //Metodo Constructor
    public function __construct ($id=0, $nombres = 'Nombres', $apellidos = 'Apellidos', $edad = 0,  $telefono = 0000000000, $numeroDocumento = 0000000000, $tipoDocumento = 'TipoDoc', $fechaNacimiento = '00-00-0000', $direccion = 'Dirección', $municipios_id = 'MunicipioId', $genero = 'Genero Persona', $rol = 'Rol', $correo = 'Correo', $contrasena='Contraseña', $estado='estado',  $nombreAcudiente = 'Nombre de acudiente', $telefonoAcudiente = 0, $correoAcudiente = 'Correo de acudiante', $instituciones_id='0', $created_at='Fecha',$updated_at='Fecha', $deleted_at='Fecha')
    {

        parent::__construct();
        $this->setId($id); //Propiedad recibida y asigna a una propiedad de la clase
        $this->setNombres($nombres);
        $this->setApellidos($apellidos);
        $this->setEdad($edad);
        $this->setTelefono($telefono);
        $this->setNumeroDocumento($numeroDocumento);
        $this->setTipoDocumento($tipoDocumento);
        $this->setFechaNacimiento($fechaNacimiento);
        $this->setDireccion($direccion);
        $this->setMunicipiosId($municipios_id);
        $this->setGenero($genero);
        $this->setRol($rol);
        $this->setCorreo($correo);
        $this->setContrasena($contrasena);
        $this->setEstado($estado);
        $this->setNombreAcudiente($nombreAcudiente);
        $this->setTelefonoAcudiente($telefonoAcudiente);
        $this->setCorreoAcudiente($correoAcudiente);


        $this->setInstitucionesId($instituciones_id);
        $this->setCreatedAt($created_at);
        $this->setUpdatedAt($updated_at);
        $this->setDeletedAt($deleted_at);

    }


    function __destruct()
    {
        //    $this->Disconnect(); // Cierro Conexiones
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
     * @return int
     */
    public function getNumeroDocumento(): int
    {
        return $this->numeroDocumento;
    }

    /**
     * @param int $numeroDocumento
     */
    public function setNumeroDocumento(int $numeroDocumento): void
    {
        $this->numeroDocumento = $numeroDocumento;
    }

    /**
     * @return string
     */
    public function getTipoDocumento(): string
    {
        return $this->tipoDocumento;
    }

    /**
     * @param string $tipoDocumento
     */
    public function setTipoDocumento(string $tipoDocumento): void
    {
        $this->tipoDocumento = $tipoDocumento;
    }

    /**
     * @return string
     */
    public function getFechaNacimiento(): string
    {
        return $this->fechaNacimiento;
    }

    /**
     * @param string $fechaNacimiento
     */
    public function setFechaNacimiento(string $fechaNacimiento): void
    {
        $this->fechaNacimiento = $fechaNacimiento;
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
        return $this->nombreAcudiente;
    }

    /**
     * @param string $nombreAcudiente
     */
    public function setNombreAcudiente(string $nombreAcudiente): void
    {
        $this->nombreAcudiente = $nombreAcudiente;
    }


    /**
     * @return string
     */
    public function getTelefonoAcudiente(): string
    {
        return $this->telefonoAcudiente;
    }

    /**
     * @param string $telefonoAcudiente
     */
    public function setTelefonoAcudiente(string $telefonoAcudiente): void
    {
        $this->telefonoAcudiente = $telefonoAcudiente;
    }

    /**
     * @return string
     */
    public function getCorreoAcudiente(): string
    {
        return $this->correoAcudiente;
    }

    /**
     * @param string $correoAcudiente
     */
    public function setCorreoAcudiente(string $correoAcudiente): void
    {
        $this->correoAcudiente = $correoAcudiente;
    }

    /**
     * @return string
     */
    public function getInstitucionesId(): string
    {
        return $this->instituciones_id;
    }

    /**
     * @param string $instituciones_id
     */
    public function setInstitucionesId(string $instituciones_id): void
    {
        $this->instituciones_id = $instituciones_id;
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

            $result = $this->insertRow("INSERT INTO dbindalecio.usuarios VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(

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
                    $this->getCreatedAt(),
                    $this->getUpdatedAt(),
                    $this->getDeletedAt()


                )
            );
            $this->Disconnect();
            return $result;

    }

    public function update()
    {
            $result = $this->updateRow("UPDATE dbindalecio.usuarios SET nombres = ?, apellidos = ? edad = ?, telefono = ?, numeroDocumento = ?, tipoDocumento = ?, 
            fechaNacimiento = ?, direccion = ?, municipio_id = ?,  genero = ?,  rol = ?,  correo = ?, contrasena = ?, estado = ?, nombreAcudiente = ?, telefonoAcudiente = ?, correoAcudiente = ?,  instituciones_id = ?, created_at = ?, updated_at = ?, deleted_at = ? WHERE id = ?", array(

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
                    $this->getCreatedAt(),
                    $this->getUpdatedAt(),
                    $this->getDeletedAt()

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
             $Usuario->setNumeroDocumento($valor['numeroDocumento']);
             $Usuario->setTipoDocumento($valor['tipoDocumento']);
             $Usuario->setFechaNacimiento($valor['fechaNacimiento']);
             $Usuario->setDireccion($valor['direccion']);
             $Usuario->setMunicipiosId($valor['municipio_id']);
             $Usuario->setGenero($valor['genero']);
             $Usuario->setRol($valor['rol']);
             $Usuario->setCorreo($valor['correo']);
             $Usuario->setContrasena($valor['contrasena']);
             $Usuario->setEstado($valor['estado']);
             $Usuario->setNombreAcudiente($valor['nombreAcudiente']);
             $Usuario->setTelefonoAcudiente($valor['telefonoAcudiente']);
             $Usuario->setCorreoAcudiente($valor['correoAcudiente']);
             $Usuario->setInstitucionesId($valor['instituciones_id']);
             $Usuario->setCreatedAt($valor['created_at']);
             $Usuario->setUpdatedAt($valor['updated_at']);
             $Usuario->setDeletedAt($valor['deleted_at']);



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
            $Usuario->setNumeroDocumento($getrow['numeroDocumento']);
            $Usuario->setTipoDocumento($getrow['tipoDocumento']);
            $Usuario->setFechaNacimiento($getrow['fechaNacimiento']);
            $Usuario->setDireccion($getrow['direccion']);
            $Usuario->setMunicipiosId($getrow['municipio_id']);
            $Usuario->setGenero($getrow['genero']);
            $Usuario->setRol($getrow['rol']);
            $Usuario->setCorreo($getrow['correo']);
            $Usuario->setContrasena($getrow['contrasena']);
            $Usuario->setEstado($getrow['estado']);
            $Usuario->setNombreAcudiente($getrow['nombreAcudiente']);
            $Usuario->setTelefonoAcudiente($getrow['telefonoAcudiente']);
            $Usuario->setCorreoAcudiente($getrow['correoAcudiente']);
            $Usuario->setInstitucionesId($getrow['instituciones_id']);
            $Usuario->setCreatedAt($getrow['created_at']);
            $Usuario->setUpdatedAt($getrow['updated_at']);
            $Usuario->setDeletedAt($getrow['deleted_at']);
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
            "<strong>Número de documento:</strong> " . $this->getNumeroDocumento() . "<br/>" .
            "<strong>Nombres:</strong> " . $this->getNombres() . "<br/>" .
            "<strong>Apellidos:</strong> " . $this->getApellidos() . "<br/>".
            "<strong>Tipo de documento:</strong> " . $this->getTipoDocumento() . "<br/>".
            "<strong>Fecha de nacimiento:</strong> " . $this->getFechaNacimiento() . "<br/>".
            "<strong>Edad:</strong> " . $this->getEdad() . "<br/>".
            "<strong>Correo:</strong> " . $this->getCorreo() . "<br/>".
            "<strong>Dirección:</strong> " . $this->getDireccion() . "<br/>".
            "<strong>Ciudad:</strong> " . $this->getCiudad() . "<br/>".
            "<strong>Teléfono:</strong> " . $this->getTelefono() . "<br/>".
            "<strong>Genero:</strong> " . $this->getGenero() . "<br/>".
            "<strong>Rol:</strong> " . $this->getRol() . "<br/>".
            "<strong>Contraseña:</strong> " . $this->getContrasena() . "<br/>".
            "<strong>Nombre de acudiente:</strong> " . $this->getNombreAcudiente() . "<br/>".
            "<strong>Teléfono de acudiente:</strong> " . $this->getTelefonoAcudiente() . "<br/>".
            "<strong>Correo de acudiente:</strong> " . $this->getCorreoAcudiente() . "<br/>".
            "<strong>Estado:</strong> " . $this->getEstado() . "<br/>";

        /*
            "<strong>Id de Institución:</strong> " . $this->getInstitucionIdInstitucion() . "<br/>";
        */



    }


}


