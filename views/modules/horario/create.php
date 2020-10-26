<?php use Carbon\Carbon;
require("../../partials/routes.php");;
?>

<!DOCTYPE html>
<html>
<head>
    <title> Crear Horario | <?= $_ENV['TITLE_SITE'] ?></title>
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
                        <h1>Crear un Nuevo Horario</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/">Horario</a></li>
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
                        Error al crear el horario: <?= $_GET['mensaje'] ?>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i> &nbsp; Información del Horario</h3>
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
                                <form class="form-horizontal" method="post" id="frmCreateHorario"
                                      name="frmCreateHorario"
                                      action="../../../app/Controllers/HorarioController.php?action=create">
                                    <div class="form-group row">
                                        <label for="hora_entrada_sede" class="col-sm-2 col-form-label">Hora de Entrada a Institución</label>
                                        <div class="col-sm-10">
                                            <input required type="time" class="form-control" id="hora_entrada_sede" name="hora_entrada_sede"
                                                   placeholder="Ingrese la hora de ingreso a institución">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="hora_salida" class="col-sm-2 col-form-label">Hora de Salida</label>
                                        <div class="col-sm-10">
                                            <input required type="time" class="form-control" id="hora_salida" name="hora_salida"
                                                   placeholder="Ingrese la hora de salida">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="hora_entrada_restaurante" class="col-sm-2 col-form-label">Hora de Entrada a Restaurante</label>
                                        <div class="col-sm-10">
                                            <input required type="time" class="form-control" id="hora_entrada_restaurante" name="hora_entrada_restaurante"
                                                   placeholder="Ingrese la hora de ingreso a restaurante">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="fecha_horario" class="col-sm-2 col-form-label">Fecha Nacimiento</label>
                                        <div class="col-sm-10">
                                            <input required type="date" max="<?= Carbon::now()->subYear(12)->format('Y-m-d') ?>" class="form-control" id="fecha_horario"
                                                   name="fecha_horario" placeholder="Ingrese su Fecha de Nacimiento">
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

                                    <div class="form-group row">
                                        <label for="sedes_id" class="col-sm-2 col-form-label">Sede Institución</label>
                                        <div class="col-sm-10">
                                            <select id="sedes_id" name="sedes_id" class="custom-select">
                                                <option value="1">Sede Principal</option>
                                                <option value="2">Sede Ejemplo</option>

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