<?php

use App\Models\Grado;

require_once ('..\app\Models\Grado.php');


//Creacion de grado en base de datos
$Grado1 = new Grado(1, 'Octavo', 'Activo');
//$Grado1->create();

/*
//Actualizacion de informacion
$Grado1 ->setId(1); //Propiedad recibida y asigna a una propiedad de la clase
$Grado1 ->setNombre('Sexto'); //Se cambio hora
$Grado1 ->setEstado('Activo');
//$Horario1->setCreatedAt('2020-10-21 12:26:54');
//$Horario1->setUpdatedAt('2020-10-21');
//$Horario1->setDeletedAt('2020-10-21');
$Grado1->update();
*/

/*
$allGrados = Grado::getAll();
var_dump($allGrados);
*/


//Busqueda por Id

$busqueda = Grado::searchForId(2);
var_dump($busqueda);
