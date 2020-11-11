<?php

use App\Models\Horario;

require_once ('..\app\Models\Horario.php');


//Creacion de horario en base de datos
$Horario1 = new Horario(0, '07:00:00', '13:30:00', '11:30:00', '2020-10-20' ,'Activo', 1);
//$Horario1->create();


/*
//Actualizacion de informacion
$Horario1 ->setId(2); //Propiedad recibida y asigna a una propiedad de la clase
$Horario1 ->setHorarioEntradaSede('07:00:00'); //Se cambio hora
$Horario1 ->setHorarioSalida('13:00:00');
$Horario1 ->setHorarioEntradaRestaurante('11:00:00');
$Horario1 ->setFecha('2020-10-20');
$Horario1 ->setEstado('Activo');
$Horario1 ->setSedesId(1);
//$Horario1->setCreatedAt('2020-10-21 12:26:54');
//$Horario1->setUpdatedAt('2020-10-21');
//$Horario1->setDeletedAt('2020-10-21');
$Horario1->update();
*/

/*
$allHorarios = Horario::getAll();
var_dump($allHorarios);
*/

//Busqueda por Id

$busqueda = Horario::searchForId(2);
var_dump($busqueda);
