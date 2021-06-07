<?php

//require_once("../../partials/check_login.php");
require("../../partials/routes.php");;

use App\Controllers\CursoController;
use App\Controllers\GradoController;
use App\Controllers\HorarioController;
use App\Models\GeneralFunctions;
use Carbon\Carbon;

$nameModel = "Curso";
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION['frm'.$pluralModel] ?? NULL;

?>

<!DOCTYPE html>
<html>
<head>
    <title> Editar <?= $nameModel?> | <?= $_ENV['TITLE_SITE'] ?></title>
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
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/">Asistencia</a></li>
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
                                <h3 class="card-title"><i class="fas fa-user"></i> &nbsp; Información Del Curso</h3>
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
                                $DataCurso = CursoController::searchForID(["id" => $_GET["id"]]);

                                if (!empty($DataCurso)) {
                                    ?>

                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <!-- form start -->
                                        <form class="form-horizontal" method="post" id="frmEdit<?= $nameModel ?>"
                                              name="frmEdit<?= $nameModel ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=edit">

                                            <input id="id" name="id" value="<?= $DataCurso->getId(); ?>" hidden
                                                   required="required" type="text">


                                            <div class="form-group row">
                                                <label for="grados_id" class="col-sm-2 col-form-label">Grado</label>
                                                <div class="col-sm-10">
                                                    <?= GradoController::selectGrado(
                                                        array(
                                                            'id' => 'grados_id',
                                                            'name' => 'grados_id',
                                                            'defaultValue' => (!empty($DataCurso)) ? $DataCurso->getGrado()->getId() : '',
                                                            'class' => 'form-control select2bs4 select2-info',
                                                            'where' => "estado = 'Activo'"
                                                        )
                                                    );
                                                    ?>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="nombre" name="nombre"
                                                           placeholder="Ingrese el nombre del curso" value="<?= $DataCurso->getNombre(); ?>">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="director" class="col-sm-2 col-form-label">Director</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="director" name="director"
                                                           placeholder="Ingrese el nombre del director" value="<?= $DataCurso->getDirector(); ?>">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="cantidad" class="col-sm-2 col-form-label">Cantidad</label>
                                                <div class="col-sm-10">
                                                    <input required type="number" class="form-control" id="cantidad" name="cantidad"
                                                           placeholder="Ingrese la cantidad" value="<?= $DataCurso->getCantidad(); ?>">
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