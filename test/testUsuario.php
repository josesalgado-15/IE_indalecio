<?php

use App\Models\Usuario;

require_once ('..\app\Models\Usuario.php');
/*
$Persona1 = new Usuario(0, 'David Maria',
    'Diaz Camargo', 18, 3108886595,
    1002723421, 'CC', '2001-05-07',
    'Calle 2 sur#3-09', 1, 'Masculino', 'Estudiante', 'juancamar@gmail.com',
    '1002723421', 'Activo', 'Pablo Diaz', 3132564588,'juanca21@gmail.com',
    2);
*/
/*
$Persona1 = new Usuario(); //Propiedad recibida y asigna a una propiedad de la clase
$Persona1 ->setId(0);
$Persona1 ->setNombres('Pablo David'); //se cambió nombre de pedro a luis
$Persona1 ->setApellidos('Diaz Camargo');
$Persona1 ->setEdad(18);
$Persona1 ->setTelefono(3132594565);
$Persona1 ->setNumeroDocumento(1201723422);
$Persona1 ->setTipoDocumento('CC');
$Persona1 ->setFechaNacimiento('2001-05-07');
$Persona1 ->setDireccion('Calle 2 sur#3-09');
$Persona1 ->setMunicipioId('1');
$Persona1 ->setGenero('Masculino');
$Persona1 ->setRol('Estudiante');
$Persona1 ->setCorreo('juancamar@gmail.com');
$Persona1 ->setContrasena('1002723422');
$Persona1 ->setEstado('Activo');
$Persona1 ->setNombreAcudiente('Pablo Diaz');
$Persona1 ->setTelefonoAcudiente('3132591544');
$Persona1 ->setCorreoAcudiente('juancamar@gmail.com');
$Persona1 ->setInstitucionesId('2');
$Persona1->setCreatedAt('2020-10-21 12:26:54');
$Persona1->setUpdatedAt('2020-10-21');
$Persona1->setDeletedAt('2020-10-21');
$Persona1->create();
*/

//Creacion de usuario en base de datos
//$Persona1->create();

/*
//Actualizacion de informacion, corrección de numero de documento y contraseña
$Persona1 ->setId(5); //Propiedad recibida y asigna a una propiedad de la clase
$Persona1 ->setNombres('Luis Jose'); //se cambió nombre de pedro a luis
$Persona1 ->setApellidos('Diaz Camargo');
$Persona1 ->setEdad(18);
$Persona1 ->setTelefono(3132594565);
$Persona1 ->setNumeroDocumento(1002723422);
$Persona1 ->setTipoDocumento('CC');
$Persona1 ->setFechaNacimiento('2001-05-07');
$Persona1 ->setDireccion('Calle 2 sur#3-09');
$Persona1 ->setMunicipioId('1');
$Persona1 ->setGenero('Masculino');
$Persona1 ->setRol('Estudiante');
$Persona1 ->setCorreo('juancamar@gmail.com');
$Persona1 ->setContrasena('1002723422');
$Persona1 ->setEstado('Activo');
$Persona1 ->setNombreAcudiente('Pablo Diaz');
$Persona1 ->setTelefonoAcudiente('3132591544');
$Persona1 ->setCorreoAcudiente('juancamar@gmail.com');
$Persona1 ->setInstitucionesId('2');
$Persona1->setCreatedAt('2020-10-21 12:26:54');
$Persona1->setUpdatedAt('2020-10-21');
$Persona1->setDeletedAt('2020-10-21');
$Persona1->update();

*/
/*
//Eliminacion de usuario, cambio de estado.
$Persona1->deleted(7);
echo $Persona1;
*/



$allUsuarios = Usuario::getAll();
var_dump($allUsuarios);
/*
$arrUsuarios = Usuario::search("SELECT * FROM dbindalecio.usuarios WHERE numero_documento= 1002723422");
var_dump($arrUsuarios);
*/


//Busqueda por Id

/*
$busqueda = Usuario::searchForId(5);
echo ($busqueda);
*/