<?php

require_once ('..\app\Models\Grado.php');


//Creacion de grado en base de datos
$Grado1 = new Grado(1, 'Octavo', 'Activo');
$Grado1->create();


//Pendiente corregir el test para update de la tabla usuarios para implemetar en el resto de tablas