<?php

require_once ('..\app\Models\Institucion.php');


use App\Models\Institucion;

$id= $_POST['id'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$municipios_id = $_POST['municipios_id'];
$rector = $_POST['rector'];
$telefono = $_POST['telefono'];
$correo= $_POST['correo'];
$estado = $_POST['estado'];

$Institucion = new Institucion ($id, $nombre, $direccion, $municipios_id, $rector , $telefono, $correo , $estado);

var_dump($Institucion->create());

//Creacion de usuario en base de datos


/*
$Institucion ->create();


//Actualizacion de informacion, corrección de numero de documento y contraseña
$Institucion->setId(7); //Propiedad recibida y asigna a una propiedad de la clase
$Institucion->setNombre('Juan Andres Perea Padilla');
$Institucion->setDireccion('Calle 2 sur#3-09');
$Institucion->setMunicipiosId(2);
$Institucion->setRector('Rector');
$Institucion->setTelefono('3132594565');
$Institucion->setCorreo('juancamar@gmail.com');
$Institucion->setEstado('Activo');
$Institucion->setCreatedAt('2020-10-21 12:26:54');
$Institucion->setUpdatedAt('2020-10-21');
$Institucion->setDeletedAt('2020-10-21');
$Institucion->create();
/*
//$Institucion->update();
*/

/*
//Eliminacion de usuario, cambio de estado.
$Institucion->deleted(7);
echo $Institucion;
*/

/*
//Busquedas, no funciona ya que pide llenar el a
$allInstituciones = Institucion::getAll();
var_dump($allInstituciones);
$arrInstituciones = Institucion::search("SELECT * FROM dbindalecio.usuario WHERE numeroDocumento = 1005343425");
var_dump($arrInstituciones);
*/


//Busqueda por Id
/*
$busqueda = Institucion::searchForId(6);
echo ($busqueda);
*/


