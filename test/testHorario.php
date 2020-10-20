<?php

require_once ('..\app\Models\Horario.php');


//Creacion de horario en base de datos
$Horario1 = new Horario(1, '06:30:00', '13:30:00', '12:30:00', '2020-10-18' ,'Activo', '2020-10-19','2020-10-19', '2020-10-19' );
$Horario1->create();