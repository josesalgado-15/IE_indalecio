<?php use Carbon\Carbon;
require("../../partials/routes.php");;
?>

<!DOCTYPE html>
<html>
<head>
    <title> Crear Usuario | <?= $_ENV['TITLE_SITE'] ?></title>
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
                        <h1>Crear un Nuevo Usuario</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/">Usuario</a></li>
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
                        Error al crear el usuario: <?= $_GET['mensaje'] ?>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i> &nbsp; Información del Usuario</h3>
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
                                <form class="form-horizontal" method="post" id="frmCreateUsuario"
                                      name="frmCreateUsuario"
                                      action="../../../app/Controllers/UsuarioController.php?action=create">
                                    <div class="form-group row">
                                        <label for="nombres" class="col-sm-2 col-form-label">Nombres</label>
                                        <div class="col-sm-10">
                                            <input required type="text" class="form-control" id="nombres" name="nombres"
                                                   placeholder="Ingrese sus nombres">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="apellidos" class="col-sm-2 col-form-label">Apellidos</label>
                                        <div class="col-sm-10">
                                            <input required type="text" class="form-control" id="apellidos"
                                                   name="apellidos" placeholder="Ingrese sus apellidos">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="edad" class="col-sm-2 col-form-label">Edad</label>
                                        <div class="col-sm-10">
                                            <input required type="number" minlength="1" class="form-control"
                                                   id="edad" name="edad" placeholder="Ingrese su edad">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="telefono" class="col-sm-2 col-form-label">Telefono</label>
                                        <div class="col-sm-10">
                                            <input required type="number" minlength="6" class="form-control"
                                                   id="telefono" name="telefono" placeholder="Ingrese su telefono">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="numero_documento" class="col-sm-2 col-form-label">Documento</label>
                                        <div class="col-sm-10">
                                            <input required type="number" minlength="6" class="form-control"
                                                   id="numero_documento" name="numero_documento" placeholder="Ingrese su documento">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tipo_documento" class="col-sm-2 col-form-label">Tipo
                                            Documento</label>
                                        <div class="col-sm-10">
                                            <select id="tipo_documento" name="tipo_documento" class="custom-select">
                                                <option value="CC">Cedula de Ciudadania</option>
                                                <option value="CE">Cedula de Extranjeria</option>
                                                <option value="TI">Tarjeta de Identidad</option>
                                                <option value="PASAPORTE">Pasaporte</option>
                                                <option value="REGISTRO CIVIL">Registro Civil</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="fecha_nacimiento" class="col-sm-2 col-form-label">Fecha Nacimiento</label>
                                        <div class="col-sm-10">
                                            <input required type="date" max="<?= Carbon::now()->subYear(12)->format('Y-m-d') ?>" class="form-control" id="fecha_nacimiento"
                                                   name="fecha_nacimiento" placeholder="Ingrese su Fecha de Nacimiento">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="direccion" class="col-sm-2 col-form-label">Direccion</label>
                                        <div class="col-sm-10">
                                            <input required type="text" class="form-control" id="direccion"
                                                   name="direccion" placeholder="Ingrese su direccion">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="municipios_id" class="col-sm-2 col-form-label">Municipio</label>
                                        <div class="col-sm-10">
                                            <select id="municipios_id" name="municipios_id" class="custom-select">
                                                <option value="1">Ejemplo Municipio 1</option>
                                                <option value="2">Ejemplo Municipio</option>
                                                <option value="3">Ejemplo Municipio</option>
                                                <option value="4">Ejemplo Municipio</option>
                                                <option value="5">Ejemplo Municipio</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="genero" class="col-sm-2 col-form-label">Género</label>
                                        <div class="col-sm-10">
                                            <select id="genero" name="genero" class="custom-select">
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                                <option value="Otro">Otro</option>

                                            </select>
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
                                        <label for="correo" class="col-sm-2 col-form-label">Correo Electrónico</label>
                                        <div class="col-sm-10">
                                            <input required type="email" class="form-control" id="correo"
                                                   name="correo" placeholder="Ingrese su correo electrónico">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="contrasena" class="col-sm-2 col-form-label">Contraseña</label>
                                        <div class="col-sm-10">
                                            <input required type="password" class="form-control" id="correo"
                                                   name="contrasena" placeholder="Ingrese una contraseña">
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
                                        <label for="nombre_acudiente" class="col-sm-2 col-form-label">Nombres Acudientes</label>
                                        <div class="col-sm-10">
                                            <input required type="text" class="form-control" id="nombre_acudiente" name="nombre_acudiente"
                                                   placeholder="Ingrese sus nombres completos">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="telefono_acudiente" class="col-sm-2 col-form-label">Telefono Acudiente</label>
                                        <div class="col-sm-10">
                                            <input required type="number" minlength="6" class="form-control"
                                                   id="telefono_acudiente" name="telefono_acudiente" placeholder="Ingrese su telefono">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="correo_acudiente" class="col-sm-2 col-form-label">Correo Electrónico</label>
                                        <div class="col-sm-10">
                                            <input required type="email" class="form-control" id="correo_acudiente"
                                                   name="correo_acudiente" placeholder="Ingrese su correo electrónico">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="instituciones_id" class="col-sm-2 col-form-label">Sede Institución</label>
                                        <div class="col-sm-10">
                                            <select id="instituciones_id" name="instituciones_id" class="custom-select">
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