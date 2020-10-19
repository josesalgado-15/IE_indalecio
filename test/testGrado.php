<?php

require_once ('..\app\Models\Grado.php');


//Creacion de grado en base de datos
$Grado1 = new Grado(1, 'Septimo', 'Activo', '2020-10-18', '2020-10-18' ,'2020-10-18');
$Grado1->create();