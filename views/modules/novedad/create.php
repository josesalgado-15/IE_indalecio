<?php

use App\Controllers\NovedadController;
use App\Controllers\UsuarioController;
use Carbon\Carbon;
require("../../partials/routes.php");
require_once("../../../app/Controllers/NovedadController.php");
require_once("../../../app/Controllers/UsuarioController.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title> Crear Novedad | <?= $_ENV['TITLE_SITE'] ?></title>
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
                        <h1>Crear Una Nueva Novedad</h1>
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
            <?php if (!empty($_GET['respuesta'])) { ?>
                <?php if ($_GET['respuesta'] != "correcto") { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                        Error al crear la novedad: <?= $_GET['mensaje'] ?>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i> &nbsp; Información de la Novedad</h3>
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
                            <div class="card-body">
                                <!-- form start -->
                                <form class="form-horizontal" method="post" id="frmCreateNovedad"
                                      name="frmCreateNovedad"
                                      action="../../../app/Controllers/NovedadController.php?action=create">

                                    <div class="form-group row">
                                        <label for="tipo" class="col-sm-2 col-form-label">Tipo</label>
                                        <div class="col-sm-10">
                                            <select id="tipo" name="tipo" class="custom-select">
                                                <option value="Ejemplo">Ejemplo</option>
                                                <option value="Ejemplo1">Ejemplo1</option>
                                                <option value="Ejemplo2">Ejemplo2</option>
                                                <option value="Ejemplo3">Ejemplo3</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="justificacion" class="col-sm-2 col-form-label">Justificación</label>
                                        <div class="col-sm-10">
                                            <select id="justificacion" name="justificacion" class="custom-select">
                                                <option value="Ejemplo">Ejemplo</option>
                                                <option value="Ejemplo1">Ejemplo1</option>
                                                <option value="Ejemplo2">Ejemplo2</option>
                                                <option value="Ejemplo3">Ejemplo3</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="observacion" class="col-sm-2 col-form-label">Observación</label>
                                        <div class="col-sm-6">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <textarea id="observacion" name="observacion"  class="form-control" rows="3" placeholder="Ingrese ..."></textarea>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                        <div class="col-sm-10">
                                            <select id="estado" name="estado" class="custom-select">
                                                <option value="Activo">Activo</option>
                                                <option value="Inactivo">Inactivo</option>

                                            </select>
                                        </div>
                                    </div>

                                    <?php
                                    $dataNovedad = null;
                                    if (!empty($_GET['id'])) {
                                        $dataNovedad = NovedadController::searchForID($_GET['id']);
                                    }
                                    ?>

                                    <div class="form-group row">
                                        <label for="administrador_id" class="col-sm-2 col-form-label">Administrador</label>
                                        <div class="col-sm-8">
                                            <?= UsuarioController::selectUsuario(false,
                                                true,
                                                'usuarios_id',
                                                'usuarios_id',
                                                (!empty($dataAsistencia)) ? $dataAsistencia->getUsuariosId()->getId() : '',
                                                'form-control select2bs4 select2-info',
                                                "rol = 'Administrador' and estado = 'Activo'")
                                            ?>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="asistencias_id" class="col-sm-2 col-form-label">Asistencia</label>
                                        <div class="col-sm-10">
                                            <select id="asistencias_id" name="asistencias_id" class="custom-select">
                                                <option value="Asistencia 1">Asistencia 1</option>
                                                <option value="Asistencia 2">Asistencia 2</option>
                                                <option value="Asistencia 3">Asistencia 3</option>

                                            </select>
                                        </div>
                                    </div>


                                    <?php if ((!empty($_SESSION['UserInSession']['rol'])) && $_SESSION['UserInSession']['rol'] == 'Administrador'){ ?>
                                        <div class="form-group row">
                                            <label for="user" class="col-sm-2 col-form-label">Usuario</label>
                                            <div class="col-sm-10">
                                                <input required type="text" class="form-control" id="user" name="user" placeholder="Ingrese su Usuario">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10">
                                                <input required type="password" class="form-control" id="password" name="password" placeholder="Ingrese su Usuario">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="rol" class="col-sm-2 col-form-label">Rol</label>
                                            <div class="col-sm-10">
                                                <select id="rol" name="rol" class="custom-select">
                                                    <option value="Estudiante">Estudiante</option>
                                                    <option value="Administrador">Administrador</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                            <div class="col-sm-10">
                                                <select id="rol" name="Estado" class="custom-select">
                                                    <option value="Activo">Activo</option>
                                                    <option value="Inactivo">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>

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
