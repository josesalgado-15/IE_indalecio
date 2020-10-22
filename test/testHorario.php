<?php

require_once ('..\app\Models\Horario.php');


//Creacion de horario en base de datos
$Horario1 = new Horario(0, '07:00:00', '13:30:00', '11:30:00', '2020-10-20' ,'Activo');
//$Horario1->create();

//Pendiente corregir el test para update de la tabla usuarios para implemetar en el resto de tablas