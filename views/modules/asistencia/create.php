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
    <title><?= $_ENV['TITLE_SITE'] ?> | Crear <?= $nameModel ?></title>
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
                        <h1>Crear Una Nueva <?= $nameModel ?></h1>
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
            <!-- Generar Mensaje de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i> &nbsp; Información de la Asistencia</h3>
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
                                <!-- form start -->
                                <div class="card-body">
                                    <form class="form-horizontal" method="post" id="frmCreate<?= $nameModel ?>"
                                          name="frmCreate<?= $nameModel ?>"
                                          action="../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=create">

                                    <div class="form-group row">
                                        <label for="fecha" class="col-sm-2 col-form-label">Fecha</label>
                                        <div class="col-sm-10">
                                            <input required type="date" class="form-control" id="fecha"
                                                   name="fecha" placeholder="Ingrese la fecha" value="<?= $frmSession['fecha'] ?? '' ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="hora_ingreso" class="col-sm-2 col-form-label">Hora De Ingreso</label>
                                        <div class="col-sm-10">
                                            <input required type="time" class="form-control" id="hora_ingreso" name="hora_ingreso"
                                                   placeholder="Ingrese la hora de ingreso" value="<?= $frmSession['hora_ingreso'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="observacion" class="col-sm-2 col-form-label">Observación</label>
                                        <div class="col-sm-10">
                                            <select id="observacion" name="observacion" class="custom-select">

                                                <option <?= (!empty($frmSession['observacion']) && $frmSession['observacion'] == "Ninguna") ? "selected" : ""; ?> value="Ninguna">Ninguna</option>
                                                <option <?= (!empty($frmSession['observacion']) && $frmSession['observacion'] == "Ejemplo1") ? "selected" : ""; ?> value="Ejemplo1">Ejemplo1</option>
                                                <option <?= (!empty($frmSession['observacion']) && $frmSession['observacion'] == "Ejemplo2") ? "selected" : ""; ?> value="Ejemplo2">Ejemplo2</option>
                                                <option <?= (!empty($frmSession['observacion']) && $frmSession['observacion'] == "Ejemplo3") ? "selected" : ""; ?> value="Ejemplo3">Ejemplo3</option>

                                            </select>
                                        </div>
                                    </div>

                                    <!--

                                    <div class="form-group row">
                                        <label for="tipo_ingreso" class="col-sm-2 col-form-label">Tipo De Ingreso</label>
                                        <div class="col-sm-10">
                                            <select id="tipo_ingreso" name="tipo_ingreso" class="custom-select">
                                                <option value="Institución">Institución</option>
                                                <option value="Restaurante">Restaurante</option>

                                            </select>
                                        </div>
                                    </div>
                                    -->


                                    <div class="form-group row">
                                        <label for="tipo_ingreso" class="col-sm-2 col-form-label">Tipo De Ingreso</label>
                                        <div class="col-sm-4">

                                            <div class="form-group">
                                                <select multiple class="form-control" id="tipo_ingreso" name="tipo_ingreso">
                                                    <option <?= (!empty($frmSession['tipo_ingreso']) && $frmSession['tipo_ingreso'] == "Institución") ? "selected" : ""; ?> value="Institución">Institución</option>
                                                    <option <?= (!empty($frmSession['tipo_ingreso']) && $frmSession['tipo_ingreso'] == "Restaurante") ? "selected" : ""; ?> value="Restaurante">Restaurante</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="hora_salida" class="col-sm-2 col-form-label">Hora De Salida</label>
                                        <div class="col-sm-10">
                                            <input required type="time" class="form-control" id="hora_salida" name="hora_salida"
                                                   placeholder="Ingrese la hora de salida" value="<?= $frmSession['hora_salida'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <!--

                                    <div class="form-group row">
                                        <label for="usuarios_id" class="col-sm-2 col-form-label">Documento Estudiante</label>
                                        <div class="col-sm-10">
                                            <input required type="number" minlength="6" class="form-control"
                                                   id="usuarios_id" name="usuarios_id" placeholder="Ingrese su documento">
                                        </div>
                                    </div>

                                    -->



                                    <div class="form-group row">
                                        <label for="usuarios_id" class="col-sm-2 col-form-label">Estudiante</label>
                                        <div class="col-sm-10">
                                            <?= UsuarioController::selectUsuario(false,
                                                true,
                                                'usuarios_id',
                                                'usuarios_id',
                                                (!empty($dataAsistencia)) ? $dataAsistencia->getUsuariosId()->getId() : '',
                                                'form-control select2bs4 select2-info',
                                                "rol = 'Estudiante' and estado = 'Activo'")
                                            ?>
                                        </div>
                                    </div>



                                    <hr>
                                    <button type="submit" class="btn btn-info">Enviar</button>
                                    <a href="index.php" role="button" class="btn btn-default float-right">Cancelar</a>
                                    <!-- /.card-footer -->
                                </form>
                            </div>
                            <!-- /.card-body -->

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
