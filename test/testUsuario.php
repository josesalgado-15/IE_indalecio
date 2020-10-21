<?php

require_once ('..\app\Models\Usuario.php');

$Persona1 = new Usuario(2, 'Juan Jose',
    'Diaz Camargo', 18, 3108886595,
    1002723428, 'CC', '2001-05-07',
    'Calle 2 sur#3-09', '1', 'Masculino', 'Estudiante', 'juancamar@gmail.com',
    '1002723428', 'Activo', 'Pablo Diaz', 3132564588,'juanca21@gmail.com',
    '2', '2020-10-07','2020-10-07', '2020-10-07');

//Creacion de usuario en base de datos
$Persona1->create();

/*
//Actualizacion de informacion, corrección de numero de documento y contraseña
$Persona1 ->setId(7); //Propiedad recibida y asigna a una propiedad de la clase
$Persona1 ->setNumeroDocumento(1006111455);
$Persona1 ->setNombres('Juan Jose');
$Persona1 ->setApellidos('Diaz Camargo');
$Persona1 ->setTipoDocumento('CC');
$Persona1 ->setFechaNacimiento('2001-05-07');
$Persona1 ->setEdad(19);
$Persona1 ->setCorreo('juancamar@gmail.com');
$Persona1 ->setDireccion('Calle 2 sur#3-09');
$Persona1 ->setCiudad('Pesca');
$Persona1 ->setTelefono('3132594565');
$Persona1 ->setGenero('Masculino');
$Persona1 ->setRol('Estudiante');
$Persona1 ->setPassword(1006111455);
$Persona1 ->setNombreAcudiente('Pablo Diaz');
$Persona1 ->setTelefonoAcudiente('3132591544');
$Persona1 ->setCorreoAcudiente('juancamar@gmail.com');
$Persona1 ->setEstado('Activo');
//$Persona1->update();
*/

/*
//Eliminacion de usuario, cambio de estado.
$Persona1->deleted(7);
echo $Persona1;
*/

/*
//Busquedas, no funciona ya que pide llenar el a
$allUsuarios = Usuario::getAll();
var_dump($allUsuarios);
$arrUsuarios = Usuario::search("SELECT * FROM dbindalecio.usuario WHERE numeroDocumento = 1005343425");
var_dump($arrUsuarios);
*/


//Busqueda por Id
/*
$busqueda = Usuario::searchForId(6);
echo ($busqueda);
*/
