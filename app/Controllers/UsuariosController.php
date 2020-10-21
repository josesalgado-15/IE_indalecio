<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array
require_once(__DIR__ . '/../Models/Usuario.php');
require_once(__DIR__ . '/../Models/GeneralFunctions.php');

use App\Models\GeneralFunctions;
use App\Models\Usuario;
use Carbon\Carbon;