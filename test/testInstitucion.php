<?php
use App\Models\Institucion;


require_once ('..\app\Models\Institucion.php');



/*
$Institucion = new Institucion (7, 'Juan Andres Perea Padilla', );
*/




//Actualizacion de informacion, corrección de numero de documento y contraseña
$Institucion = new Institucion();
$Institucion->setId(7); //Propiedad recibida y asigna a una propiedad de la clase
$Institucion->setNombre('Juan Andres Perea Padilla');
$Institucion->setNit(8031231590);
$Institucion->setDireccion('Calle 2 sur#3-09');
$Institucion->setMunicipiosId('1');
$Institucion->setRectorId('10');
$Institucion->setTelefono(3132594565);
$Institucion->setCorreo('juancamar@gmail.com');
$Institucion->setEstado('Activo');
$Institucion->setCreatedAt('2020-10-21 12:26:54');
$Institucion->setUpdatedAt('2020-10-21');
$Institucion->setDeletedAt('2020-10-21');
$Institucion->create();


//Creacion de institucion en base de datos
//$Institcuib->create();

/*
 //Actualizacion de informacion
$Institucion->setId(5); //Propiedad recibida y asigna a una propiedad de la clase
$Institucion->setNombre('Luis Paez');
$Institucion->setDireccion('Calle 2 sur#3-09');
$Institucion->setMunicipioId(2);
$Institucion->setRector('Juan Cruz');
$Institucion->setTelefono('3132594465');
$Institucion->setCorreo('juancruz@gmail.com');
$Institucion->setEstado('Activo');
$Institucion->setCreatedAt('2020-10-21 12:26:54');
$Institucion->setUpdatedAt('2020-10-21');
$Institucion->setDeletedAt('2020-10-21');
$Institucion->create();
*/
/*
//Eliminacion de usuario, cambio de estado.
$Institucion->deleted(7);
echo $Institucion;
*/
$allInstitucion = Institucion::getAll();
var_dump($allInstitucion);
/*
 $arrInstitcuon = Institucion::search("SELECT * FROM dbindalecio.instituciones WHERE id= 7");
var_dump($arrInstitucion);
 */

/*
//Busqueda por Id
/*
$busqueda = Institucion::searchForId(5);
echo ($busqueda);
*/
