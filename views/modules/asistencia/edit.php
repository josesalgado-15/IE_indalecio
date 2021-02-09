<?php

//require_once("../../partials/check_login.php");
require("../../partials/routes.php");;

use App\Controllers\AsistenciaController;
use App\Controllers\MatriculaController;
use App\Controllers\UsuarioController;
use App\Models\GeneralFunctions;
use Carbon\Carbon;

$nameModel = "Asistencia";
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION['frm'.$pluralModel] ?? NULL;

?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Editar <?= $nameModel ?></title>
    <?php require("../../partials/head_imports.php"); ?>
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require("../../partials/navbar_customization.php"); ?>

    <?php require("../../partials/sliderbar_main_menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editar <?= $nameModel ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
                            <li class="breadcrumb-item active">Editar</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Generar Mensajes de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <?= (empty($_GET['id'])) ? GeneralFunctions::getAlertDialog('error', 'Faltan Criterios de Búsqueda') : ""; ?>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i> &nbsp; Información De La Asistencia</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="card-refresh"
                                            data-source="create.php" data-source-selector="#card-refresh-content"
                                            data-load-on-init="false"><i class="fas fa-sync-alt"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                            class="fas fa-expand"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i></button>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <?php if (!empty($_GET["id"]) && isset($_GET["id"])) { ?>
                                <p>
                                <?php
                                $DataAsistencia = AsistenciaController::searchForID(["id" => $_GET["id"]]);

                                if (!empty($DataAsistencia)) {
                                    ?>

                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <!-- form start -->
                                        <form class="form-horizontal" method="post" id="frmEdit<?= $nameModel ?>"
                                              name="frmEdit<?= $nameModel ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=edit">

                                        <input id="id" name="id" value="<?= $DataAsistencia->getId(); ?>" hidden
                                                   required="required" type="text">

                                            <div class="form-group row">
                                                <label for="fecha" class="col-sm-2 col-form-label">Fecha</label>
                                                <div class="col-sm-10">
                                                    <input required type="date" max="<?= Carbon::now()->format('Y-m-d') ?>" value="<?= $DataAsistencia->getFecha()->toDateString(); ?>" class="form-control" id="fecha"
                                                           name="fecha" placeholder="Ingrese la fecha">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="hora_ingreso" class="col-sm-2 col-form-label">Hora De Ingreso</label>
                                                <div class="col-sm-10">
                                                    <input required type="time" class="form-control" id="hora_ingreso" name="hora_ingreso"
                                                           value="<?= $DataAsistencia->getHoraIngreso(); ?>">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="observacion" class="col-sm-2 col-form-label">Observación</label>
                                                <div class="col-sm-10">
                                                    <select id="observacion" name="observacion" class="custom-select">

                                                        <option <?= ($DataAsistencia->getObservacion() == "Ninguna") ? "selected" : ""; ?> value="Ninguna">Ninguna</option>
                                                        <option <?= ($DataAsistencia->getObservacion() == "Ejemplo1") ? "selected" : ""; ?> value="Ejemplo1">Ejemplo1</option>
                                                        <option <?= ($DataAsistencia->getObservacion() == "Ejemplo2") ? "selected" : ""; ?> value="Ejemplo2">Ejemplo2</option>
                                                        <option <?= ($DataAsistencia->getObservacion() == "Ejemplo3") ? "selected" : ""; ?> value="Ejemplo3">Ejemplo3</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tipo_ingreso" class="col-sm-2 col-form-label">Tipo De Ingreso</label>
                                                <div class="col-sm-4">

                                                    <div class="form-group">
                                                        <select id="tipo_ingreso" name="tipo_ingreso" multiple class="form-control">

                                                            <option <?= ($DataAsistencia->getTipoIngreso() == "Institucion") ? "selected" : ""; ?> value="Institucion">Institución</option>
                                                            <option <?= ($DataAsistencia->getTipoIngreso() == "Restaurante") ? "selected" : ""; ?> value="Restaurante">Restaurante</option>

                                                        </select>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="hora_salida" class="col-sm-2 col-form-label">Hora De Salida</label>
                                                <div class="col-sm-10">
                                                    <input required type="time" class="form-control" id="hora_salida" name="hora_salida"
                                                           value="<?= $DataAsistencia->getHoraSalida(); ?>">
                                                </div>
                                            </div>


                                            <?php
                                            $dataAsistencia = null;
                                            if (!empty($_GET['id'])) {
                                                $dataAsistencia = AsistenciaController::searchForID(["id" => $_GET["id"]]);
                                            }
                                            ?>

                                            <div class="form-group row">
                                                <label for="usuarios_id" class="col-sm-2 col-form-label">Estudiante</label>
                                                <div class="col-sm-10">
                                                    <?= MatriculaController::selectMatricula(array (
                                                        'id' => 'matriculas_id',
                                                        'name' => 'matriculas_id',
                                                        'defaultValue' => (!empty($dataAsistencia)) ? $dataAsistencia->getMatricula()->getId() : '',
                                                        'class' => 'form-control select2bs4 select2-info',
                                                        'where' => "estado = 'Activo'"))

                                                    ?>


                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                                <div class="col-sm-10">
                                                    <select id="estado" name="estado" class="custom-select">
                                                        <option <?= ($DataAsistencia->getEstado() == "Activo") ? "selected" : ""; ?> value="Activo">Activo</option>
                                                        <option <?= ($DataAsistencia->getEstado() == "Inactivo") ? "selected" : ""; ?> value="Inactivo">Inactivo</option>

                                                    </select>
                                                </div>
                                            </div>


                                            <hr>
                                            <button type="submit" class="btn btn-info">Enviar</button>
                                            <a href="index.php" role="button" class="btn btn-default float-right">Cancelar</a>
                                            <!-- /.card-footer -->
                                        </form>
                                    </div>
                                    <!-- /.card-body -->
                                <?php } else { ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                        No se encontro ningun registro con estos parametros de
                                        busqueda <?= ($_GET['mensaje']) ?? "" ?>
                                    </div>
                                <?php } ?>
                                </p>
                            <?php } ?>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require('../../partials/footer.php'); ?>
</div>
<!-- ./wrapper -->
<?php require('../../partials/scripts.php'); ?>
</body>
</html>