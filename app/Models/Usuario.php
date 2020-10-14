<?php

use App\Models\BasicModel;
use Carbon\Carbon;

require_once('BasicModel.php');


class Usuario extends BasicModel
{
    //Propiedades

    protected int $idPersona; //Visibilidad (public, protected, private)
    protected float $numeroDocumento;
    protected string $nombres;
    protected string $apellidos;
    protected string $tipoDocumento;
    protected string $fechaNacimiento;
    protected int $edad;
    protected string $correo;
    protected string $direccion;
    protected string $ciudad;
    protected string $telefono;
    protected string $genero;
    protected string $rol;
    protected ?string $password;
    protected string $nombreAcudiente;
    protected string $telefonoAcudiente;
    protected string $correoAcudiente;

    /*
    protected int $institucion_id_institucion;
    */
    /**
     * Usuario constructor.
     */

    //Metodo Constructor
    public function __construct ($idPersona, $numeroDocumento, $nombres , $apellidos, $tipoDocumento, $fechaNacimiento, $edad, $correo, $direccion, $ciudad, $telefono, $genero, $rol, $password, $nombreAcudiente, $telefonoAcudiente, $correoAcudiente)
    {

        parent::__construct();
        $this->setIdPersona($idPersona); //Propiedad recibida y asigna a una propiedad de la clase
        $this->setNumeroDocumento($numeroDocumento);
        $this->setNombres($nombres);
        $this->setApellidos($apellidos);
        $this->setTipoDocumento($tipoDocumento);
        $this->setFechaNacimiento($fechaNacimiento);
        $this->setEdad($edad);
        $this->setCorreo($correo);
        $this->setDireccion($direccion);
        $this->setCiudad($ciudad);
        $this->setTelefono($telefono);
        $this->setGenero($genero);
        $this->setRol($rol);
        $this->setPassword($password);
        $this->setNombreAcudiente($nombreAcudiente);
        $this->setTelefonoAcudiente($telefonoAcudiente);
        $this->setCorreoAcudiente($correoAcudiente);


        /*
        $this->setInstitucionIdInstitucion($institucion_id_institucion);
        */
    }


    /*
    public function __construct($usuario = array())
    {
        $this->idPersona = $usuario['idPersona'] ?? 0;
        $this->numeroDocumento = $usuario['numeroDocumento'] ?? '';
        $this->nombres = $usuario['nombres'] ?? '';
        $this->apellidos = $usuario['apellidos'] ?? '';
        $this->tipoDocumento = $usuario['tipoDocumento'] ?? '';
        $this->fechaNacimiento = $usuario['fechaNacimiento'] ?? new Carbon();
        $this->edad = $usuario['edad'] ?? '';
        $this->correo = $usuario['correo'] ?? '';
        $this->direccion = $usuario['direccion'] ?? '';
        $this->telefono = $usuario['telefono'] ?? '';
        $this->genero = $usuario['genero'] ?? '';
        $this->rol = $usuario['rol'] ?? '';
        $this->password = $usuario['password'] ?? null;
        $this->nombreAcudiente = $usuario['nombreAcudiente'] ?? '';
        $this->telefonoAcudiente = $usuario['telefonoAcudiente'] ?? '';
        $this->correoAcudiente = $usuario['correoAcudiente'] ?? '';
        $this->institucion_id_institucion = $usuario['institucion_id_institucion'] ?? '';
    }
    */

    function __destruct()
    {
        //    $this->Disconnect(); // Cierro Conexiones
    }

    /**
     * @return int|mixed
     */
    public function getIdPersona(): int
    {
        return $this->idPersona;
    }

    /**
     * @param int|mixed $idPersona
     */
    public function setIdPersona(int $idPersona): void
    {
        $this->idPersona = $idPersona;
    }

    /**
     * @return int|mixed|string
     */
    public function getNumeroDocumento(): float
    {
        return $this->numeroDocumento;
    }

    /**
     * @param int|mixed|string $numeroDocumento
     */
    public function setNumeroDocumento(float $numeroDocumento): void
    {
        $this->numeroDocumento = $numeroDocumento;
    }

    /**
     * @return mixed|string
     */
    public function getNombres(): string
    {
        return $this->nombres;
    }

    /**
     * @param mixed|string $nombres
     */
    public function setNombres(string $nombres): void
    {
        $this->nombres = $nombres;
    }

    /**
     * @return mixed|string
     */
    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    /**
     * @param mixed|string $apellidos
     */
    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return mixed|string
     */
    public function getTipoDocumento(): string
    {
        return $this->tipoDocumento;
    }

    /**
     * @param mixed|string $tipoDocumento
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
     * @return Carbon|mixed
     */




    /*
    Pendiente verificar como usar las fechas con Carbon

    public function getFechaNacimiento(): Carbon
       {
           return $this->fechaNacimiento->locale('es');
       }

       /**
        * @param Carbon|mixed $fechaNacimiento
        */
    /*   public function setFechaNacimiento(Carbon $fechaNacimiento): void
       {
           $this->fechaNacimiento = $fechaNacimiento;
       }

       /**
        * @return mixed|string
        */


    public function getEdad(): int
    {
        return $this->edad;
    }

    /**
     * @param mixed|string $edad
     */
    public function setEdad(int $edad): void
    {
        $this->edad = $edad;
    }

    /**
     * @return mixed|string
     */
    public function getCorreo(): string
    {
        return $this->correo;
    }

    /**
     * @param mixed|string $correo
     */
    public function setCorreo(string $correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed|string
     */
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    /**
     * @param mixed|string $direccion
     */
    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return string
     */
    public function getCiudad(): string
    {
        return $this->ciudad;
    }

    /**
     * @param string $ciudad
     */
    public function setCiudad(string $ciudad): void
    {
        $this->ciudad = $ciudad;
    }

    /**
     * @return int|mixed|string
     */

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    /**
     * @param int|mixed|string $telefono
     */
    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed|string
     */
    public function getGenero(): string
    {
        return $this->genero;
    }

    /**
     * @param mixed|string $genero
     */
    public function setGenero(string $genero): void
    {
        $this->genero = $genero;
    }

    /**
     * @return mixed|string
     */
    public function getRol(): string
    {
        return $this->rol;
    }

    /**
     * @param mixed|string $rol
     */
    public function setRol(string $rol): void
    {
        $this->rol = $rol;
    }

    /**
     * @return mixed|string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param mixed|string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed|string
     */
    public function getNombreAcudiente(): string
    {
        return $this->nombreAcudiente;
    }

    /**
     * @param mixed|string $nombreAcudiente
     */
    public function setNombreAcudiente(string $nombreAcudiente): void
    {
        $this->nombreAcudiente = $nombreAcudiente;
    }

    /**
     * @return int|mixed|string
     */
    public function getTelefonoAcudiente(): string
    {
        return $this->telefonoAcudiente;
    }

    /**
     * @param int|mixed|string $telefonoAcudiente
     */
    public function setTelefonoAcudiente(string $telefonoAcudiente): void
    {
        $this->telefonoAcudiente = $telefonoAcudiente;
    }

    /**
     * @return mixed|string
     */
    public function getCorreoAcudiente(): string
    {
        return $this->correoAcudiente;
    }

    /**
     * @param mixed|string $correoAcudiente
     */
    public function setCorreoAcudiente(string $correoAcudiente): void
    {
        $this->correoAcudiente = $correoAcudiente;
    }

    /**
     * @return int|mixed|string
     */
    /*
    public function getInstitucionIdInstitucion(): int
    {
        return $this->institucion_id_institucion;
    }

    /**
     * @param int|mixed|string $institucion_id_institucion
     */
    /*
    public function setInstitucionIdInstitucion(int $institucion_id_institucion): void
    {
        $this->institucion_id_institucion = $institucion_id_institucion;
    }
    */

    public function create()
    {

            $result = $this->insertRow("INSERT INTO dbindalecio.usuario VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                    $this->getNumeroDocumento(),
                    $this->getNombres(),
                    $this->getApellidos(),
                    $this->getTipoDocumento(),
                    $this->getFechaNacimiento(),
                    $this->getEdad(),
                    $this->getCorreo(),
                    $this->getDireccion(),
                    $this->getCiudad(),
                    $this->getTelefono(),
                    $this->getGenero(),
                    $this->getRol(),
                    $this->getPassword(),
                    $this->getNombreAcudiente(),
                    $this->getTelefonoAcudiente(),
                    $this->getCorreoAcudiente()

                )
            );
            $this->Disconnect();
            return $result;

    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function deleted($id)
    {
        // TODO: Implement deleted() method.
    }

    public static function search($query)
    {
        // TODO: Implement search() method.
    }

    public static function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public static function searchForId($id)
    {
        // TODO: Implement searchForId() method.
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
            "<strong>Id:</strong> " . $this->getIdPersona() . "<br/>" .
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
            "<strong>Password:</strong> " . $this->getPassword() . "<br/>".
            "<strong>Nombre de acudiente:</strong> " . $this->getNombreAcudiente() . "<br/>".
            "<strong>Teléfono de acudiente:</strong> " . $this->getTelefonoAcudiente() . "<br/>".
            "<strong>Correo de acudiente:</strong> " . $this->getCorreoAcudiente() . "<br/>";

        /*
            "<strong>Id de Institución:</strong> " . $this->getInstitucionIdInstitucion() . "<br/>";
        */



    }


}


$Persona1 = new Usuario(1, 1002723452,
    'Juan Jose', 'Diaz Camargo', 'CC',
    '2001-05-07', 19, 'juancamar@gmail.com',
    'Calle 2 sur#3-09', 'Pesca', '3132594565', 'Masculino',
    'Estudiante', 1002723452, 'Pablo Diaz',
    '3132591544', 'juancamar@gmail.com');

$Persona1->create();

echo $Persona1;


