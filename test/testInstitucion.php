<?php

require_once ('..\app\Models\Institucion.php');


$Insti1 = new Institucion  (1, 'Institución Educativa Indalecio Vásquez' , 'Calle 1 sur#1-05', 1 ,  'Rector' ,  '3132594565' ,
    'juancamar@gmail.com' ,  'Activo' );

//Creacion de usuario en base de datos

$Insti1->create();

/*
//Actualizacion de informacion, corrección de numero de documento y contraseña
$Insti1 ->setId(7); //Propiedad recibida y asigna a una propiedad de la clase
$Insti1 ->setNombre('Juan Andres Perea Padilla');
$Insti1 ->setDireccion('Calle 2 sur#3-09');
$Insti1 ->setMunicipiosId(2);
$Insti1 ->setRector('Rector');
$Insti1 ->setTelefono('3132594565');
$Insti1 ->setCorreo('juancamar@gmail.com');
$Insti1 ->setEstado('Activo');
//$Insti1->update();
*/

/*
//Eliminacion de usuario, cambio de estado.
$Insti1->deleted(7);
echo $Insti1;
*/

/*
//Busquedas, no funciona ya que pide llenar el a
$allInstituciones = Institucion::getAll();
var_dump($allInstituciones);
$arrInsti = Institucion::search("SELECT * FROM dbindalecio.usuario WHERE numeroDocumento = 1005343425");
var_dump($arrInsti);
*/


//Busqueda por Id
/*
$busqueda = Institucion::searchForId(6);
echo ($busqueda);
*/
