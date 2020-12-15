<?php
require("../../partials/routes.php");

require("../../../app/Controllers/NovedadController.php");

use App\Controllers\NovedadController; ?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Datos de la Novedad</title>
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
                        <h1>Informacion del la Novedad</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/Views/">Institución Educativa Indalecio Vásquez</a></li>
                            <li class="breadcrumb-item active">Inicio</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <?php if (!empty($_GET['respuesta'])) { ?>
                <?php if ($_GET['respuesta'] == "error") { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                        Error al consultar la novedad: <?= ($_GET['mensaje']) ?? "" ?>
                    </div>
                <?php } ?>
            <?php } else if (empty($_GET['id'])) { ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    Faltan criterios de busqueda <?= ($_GET['mensaje']) ?? "" ?>
                </div>
            <?php } ?>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-green">
                            <?php if (!empty($_GET["id"]) && isset($_GET["id"])) {
                                $DataNovedad = NovedadController::searchForID($_GET["id"]);
                                if (!empty($DataNovedad)) {
                                    ?>
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-info"></i> &nbsp; Ver Información </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="card-refresh"
                                                    data-source="show.php" data-source-selector="#card-refresh-content"
                                                    data-load-on-init="false"><i class="fas fa-sync-alt"></i></button>
                                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                                        class="fas fa-expand"></i></button>
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                                    data-toggle="tooltip" title="Collapse">
                                                <i class="fas fa-minus"></i></button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove"
                                                    data-toggle="tooltip" title="Remove">
                                                <i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p>
                                            <strong><i class="fas fa-user mr-1"></i>Tipo</strong>
                                        <p class="text-muted">
                                            <?= $DataNovedad->getTipo() ?>
                                        </p>
                                        <hr>

                                        <p>
                                            <strong><i class="fas fa-user mr-1"></i>Justificación</strong>
                                        <p class="text-muted">
                                            <?= $DataNovedad->getJustificacion() ?>
                                        </p>
                                        <hr>

                                        <p>
                                            <strong><i class="fas fa-user mr-1"></i>Observación</strong>
                                        <p class="text-muted">
                                            <?= $DataNovedad->getObservacion() ?>
                                        </p>
                                        <hr>

                                        <p>
                                            <strong><i class="fas fa-user mr-1"></i>Administrador ID</strong>
                                        <p class="text-muted">
                                            <?= $DataNovedad->getAdministradorId()->getNombres(), " ", $DataNovedad->getAdministradorId()->getApellidos(); ?>

                                        </p>
                                        <hr>

                                        <p>
                                            <strong><i class="fas fa-user mr-1"></i>Asistencia ID</strong>
                                        <p class="text-muted">
                                            <?= $DataNovedad->getAsistenciasId() ?>
                                        </p>
                                        <hr>


                                        <strong><i class="far fa-file-alt mr-1"></i>Estado</strong>
                                        <p class="text-muted">
                                            <?= $DataNovedad->getEstado() ?>
                                        </p>


                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-auto mr-auto">
                                                <a role="button" href="index.php" class="btn btn-success float-right"
                                                   style="margin-right: 5px;">
                                                    <i class="fas fa-tasks"></i> Gestionar Novedades
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <a role="button" href="create.php" class="btn btn-primary float-right"
                                                   style="margin-right: 5px;">
                                                    <i class="fas fa-plus"></i> Crear Novedades
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                        No se encontro ningun registro con estos parametros de
                                        busqueda <?= ($_GET['mensaje']) ?? "" ?>
                                    </div>
                                <?php }
                            } ?>
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
