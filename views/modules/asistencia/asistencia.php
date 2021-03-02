<?php

//require_once("../../partials/check_login.php");
require("../../partials/routes.php");;

use App\Controllers\AsistenciaController;
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
    <title> Gestionar <?= $nameModel?> | <?= $_ENV['TITLE_SITE'] ?></title>
    <?php require("../../partials/head_imports.php"); ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-responsive/css/responsive.bootstrap4.css">
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-buttons/css/buttons.bootstrap4.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <?php include_once ('../../partials/navbar_customization.php') ?>

    <?php include_once ('../../partials/sliderbar_main_menu.php') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gestionar Asistencias</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestionar Asistencias</li>
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
            <!-- Default box -->
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user"></i> &nbsp; Gestionar Asistencias</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="card-refresh"
                                data-source="index.php" data-source-selector="#card-refresh-content"
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
                    <div class="row">
                        <div class="col-auto mr-auto"></div>
                        <div class="col-auto">
                            <a role="button" href="create.php" class="btn btn-primary float-right"
                               style="margin-right: 5px;">
                                <i class="fas fa-plus"></i> Crear Asistencia
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <table id="tblAsistencias" class="datatable table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Curso</th>
                                    <th>Estudiante</th>
                                    <th>Observación</th>
                                    <th>Estado</th>
                                    <th>Reporte</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php if (!empty($_GET["cursos_id"]) && isset($_GET["cursos_id"])) {
                                $DataAsistencia = AsistenciaController::searchForMatricula(["cursos_id" => $_GET["cursos_id"]]);

                                if (!empty($DataAsistencia)) {
                                ?>

                                    <tr>
                                        <td><?php echo $DataAsistencia->getId(); ?></td>
                                        <td><?php echo $DataAsistencia->getFecha()->translatedFormat('l, j \\de F Y'),".";  ?></td>
                                        <td><?php echo $DataAsistencia->getMatricula()->getCurso()->getNombre(); ?></td>
                                        <td><?php echo $DataAsistencia->getMatricula()->getUsuario()->getNumeroDocumento(),"-",  $DataAsistencia->getMatricula()->getUsuario()->getNombres()," ",  $DataAsistencia->getMatricula()->getUsuario()->getApellidos(); ?></td>
                                        <td><?php echo $DataAsistencia->getObservacion(); ?></td>
                                        <td><?php echo $DataAsistencia->getEstado(); ?></td>
                                        <td><?php echo $DataAsistencia->getReporte(); ?></td>
                                        <td>


                                            <?php if ($DataAsistencia->getReporte() != "Asiste") { ?>
                                                <a href="../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=asiste&id=<?= $DataAsistencia->getId(); ?>"
                                                   type="button" data-toggle="tooltip" title="Asiste"
                                                   class="btn docs-tooltip btn-success btn-xs"><i
                                                            class="fa fa-hand-paper"></i></a>
                                            <?php } else { ?>
                                                <a type="button"
                                                   href="../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=no_asiste&id=<?= $DataAsistencia->getId(); ?>"
                                                   data-toggle="tooltip" title="No asiste"
                                                   class="btn docs-tooltip btn-danger btn-xs"><i
                                                            class="fa fa-user-times"></i></a>
                                            <?php } ?>
                                            <a href="edit.php?id=<?php echo $DataAsistencia->getId(); ?>"
                                               type="button" data-toggle="tooltip" title="Actualizar"
                                               class="btn docs-tooltip btn-primary btn-xs"><i
                                                        class="fa fa-edit"></i></a>
                                            <a href="show.php?id=<?php echo $DataAsistencia->getId(); ?>"
                                               type="button" data-toggle="tooltip" title="Ver"
                                               class="btn docs-tooltip btn-warning btn-xs"><i
                                                        class="fa fa-eye"></i></a>


                                            <?php if ($DataAsistencia->getEstado() != "Activo") { ?>
                                                <a href="../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=activate&id=<?= $DataAsistencia->getId(); ?>"
                                                   type="button" data-toggle="tooltip" title="Activar"
                                                   class="btn docs-tooltip btn-success btn-xs"><i
                                                            class="fa fa-check-square"></i></a>
                                            <?php } else { ?>
                                                <a type="button"
                                                   href="../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=inactivate&id=<?= $DataAsistencia->getId(); ?>"
                                                   data-toggle="tooltip" title="Inactivar"
                                                   class="btn docs-tooltip btn-danger btn-xs"><i
                                                            class="fa fa-times-circle"></i></a>
                                            <?php } ?>



                                        </td>
                                    </tr>


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


                                </tbody>
                                <tfoot>
                                <tr>

                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Curso</th>
                                    <th>Estudiante</th>
                                    <th>Observación</th>
                                    <th>Estado</th>
                                    <th>Reporte</th>
                                    <th>Acciones</th>
                                    <!--<th></th> Si se quieren mostrar todos los registros en una vista-->
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    Pie de Página.
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php include_once ('../../partials/footer.php') ?>
</div>

</div>
<!-- ./wrapper -->
<?php require('../../partials/scripts.php'); ?>
<!-- Scripts requeridos para las datatables -->
<?php require('../../partials/datatables_scripts.php'); ?>

</body>
</html>