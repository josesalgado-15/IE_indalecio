<?php

//require_once("../../partials/check_login.php");
require("../../partials/routes.php");;

use App\Controllers\NovedadController;
use App\Controllers\AsistenciaController;
use App\Controllers\UsuarioController;
use App\Models\GeneralFunctions;
use Carbon\Carbon;

$nameModel = "Novedad";
$pluralModel = $nameModel.'es';
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
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/">Novedad</a></li>
                            <li class="breadcrumb-item active">Inicio</li>
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
                                <h3 class="card-title"><i class="fas fa-user"></i> &nbsp; Información De La Novedad</h3>
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
                                $DataNovedad = NovedadController::SearchForID(["id" => $_GET["id"]]);
                                if (!empty($DataNovedad)) {
                                    ?>

                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <!-- form start -->
                                        <form class="form-horizontal" method="post" id="frmEdit<?= $nameModel ?>"
                                              name="frmEdit<?= $nameModel ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=edit">

                                            <input id="id" name="id" value="<?= $DataNovedad->getId(); ?>" hidden
                                                   required="required" type="text">


                                            <div class="form-group row">
                                                <label for="tipo" class="col-sm-2 col-form-label">Tipo</label>
                                                <div class="col-sm-10">
                                                    <select id="tipo" name="tipo" class="custom-select">

                                                        <option <?= ($DataNovedad->getTipo() == "Inasistencia") ? "selected" : ""; ?> value="Inasistencia">Inasistencia</option>
                                                        <option <?= ($DataNovedad->getTipo() == "Llegada Tarde") ? "selected" : ""; ?> value="Llegada Tarde">Llegada Tarde</option>
                                                        <option <?= ($DataNovedad->getTipo() == "Salida Temprana") ? "selected" : ""; ?> value="Salida Temprana">Salida Temprana</option>
                                                        <option <?= ($DataNovedad->getTipo() == "Salida Tarde") ? "selected" : ""; ?> value="Salida Tarde">Salida Tarde</option>


                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="justificacion" class="col-sm-2 col-form-label">Justificación</label>
                                                <div class="col-sm-10">
                                                    <select id="justificacion" name="justificacion" class="custom-select">

                                                        <option <?= ($DataNovedad->getJustificacion() == "Ejemplo") ? "selected" : ""; ?> value="Ejemplo">Ejemplo</option>
                                                        <option <?= ($DataNovedad->getJustificacion() == "Ejemplo1") ? "selected" : ""; ?> value="Ejemplo1">Ejemplo1</option>
                                                        <option <?= ($DataNovedad->getJustificacion() == "Ejemplo2") ? "selected" : ""; ?> value="Ejemplo2">Ejemplo2</option>
                                                        <option <?= ($DataNovedad->getJustificacion() == "Ejemplo3") ? "selected" : ""; ?> value="Ejemplo3">Ejemplo3</option>


                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="observacion" class="col-sm-2 col-form-label">Observación</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="observacion" name="observacion"
                                                           value="<?= $DataNovedad->getObservacion(); ?>">
                                                </div>
                                            </div>



                                            <?php
                                            $DataNovedad = null;
                                            if (!empty($_GET['id'])) {
                                                $DataNovedad = NovedadController::searchForID(["id" => $_GET["id"]]);
                                            }
                                            ?>


                                            <div class="form-group row">
                                                <label for="administrador_id" class="col-sm-2 col-form-label">Administrador</label>
                                                <div class="col-sm-10">

                                                    <?= UsuarioController::selectUsuario(array (
                                                        'id' => 'administrador_id',
                                                        'name' => 'administrador_id',
                                                        'defaultValue' => (!empty($DataNovedad)) ? $DataNovedad->getAdministradorId() : '',
                                                        'class' => 'form-control select2bs4 select2-info',
                                                        'where' => "rol = 'Administrador' and estado = 'Activo'"))

                                                    ?>


                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="asistencias_id" class="col-sm-2 col-form-label">Asistencia</label>
                                                <div class="col-sm-10">
                                                    <?= NovedadController::selectAsistencia(
                                                        array(
                                                            'id' => 'asistencia_id',
                                                            'name' => 'asistencia_id',
                                                            'defaultValue' => (!empty($DataNovedad)) ? $DataNovedad->getAsistencia()->getId() : '',
                                                            'class' => 'form-control select2bs4 select2-info',
                                                            'where' => "estado = 'Activo'"
                                                        )
                                                    );
                                                    ?>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                                <div class="col-sm-10">
                                                    <select id="estado" name="estado" class="custom-select">
                                                        <option <?= ($DataNovedad->getEstado() == "Activo") ? "selected" : ""; ?> value="Activo">Activo</option>
                                                        <option <?= ($DataNovedad->getEstado() == "Inactivo") ? "selected" : ""; ?> value="Inactivo">Inactivo</option>

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