<?php session_start();
require("../../partials/routes.php");
//require_once("../../partials/check_login.php");//

use App\Controllers\DepartamentosController;
use App\Controllers\MunicipiosController;
use App\Models\GeneralFunctions;
use App\Controllers\UsuarioController;
use App\Controllers\InstitucionController;
use Carbon\Carbon;

$nameModel = "Institucion";
$pluralModel = $nameModel.'es';
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
                        <h1>Crear una nueva <?= $nameModel ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
                            <li class="breadcrumb-item active">Crear </li>
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
                                <h3 class="card-title"><i class="fas fa-user"></i> &nbsp; Información de la <?= $nameModel ?></h3>
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
                                <form class="form-horizontal" enctype="multipart/form-data" method="post" id="frmCreate<?= $nameModel ?>"
                                      name="frmCreate<?= $nameModel ?>"
                                      action="../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=create">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="form-group row">
                                                <label for="nombre" class="col-sm-2 col-form-label">Nombres</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="nombre" name="nombre"
                                                           placeholder="Ingrese sus nombres" value="<?= $frmSession['nombre'] ?? '' ?>">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="nit" class="col-sm-2 col-form-label">Nit</label>
                                                <div class="col-sm-10">
                                                    <input required type="number" class="form-control" id="nit"
                                                           name="nit" placeholder="Ingrese su nit" value="<?= $frmSession['nit'] ?? '' ?>">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="direccion" class="col-sm-2 col-form-label">Direccion</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="direccion"
                                                           name="direccion" placeholder="Ingrese su direccion" value="<?= $frmSession['edad'] ?? '' ?>">
                                                </div>
                                            </div>



                                            <div class="form-group row">
                                                <label for="municipios_id" class="col-sm-2 col-form-label">Municipio</label>
                                                <div class="col-sm-5">
                                                    <?= DepartamentosController::selectDepartamentos(
                                                        array(
                                                            'id' => 'departamento_id',
                                                            'name' => 'departamento_id',
                                                            'defaultValue' => '15', //Boyacá
                                                            'class' => 'form-control select2bs4 select2-info',
                                                            'where' => "estado = 'Activo'"
                                                        )
                                                    )
                                                    ?>
                                                </div>
                                                <div class="col-sm-5 ">
                                                    <?= MunicipiosController::selectMunicipios(array (
                                                        'id' => 'municipios_id',
                                                        'name' => 'municipios_id',
                                                        'defaultValue' => (!empty($frmSession['municipios_id'])) ? $frmSession['municipios_id'] : '',
                                                        'class' => 'form-control select2bs4 select2-info',
                                                        'where' => "departamento_id = 15 and estado = 'Activo'"))
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="rector_id" class="col-sm-2 col-form-label">Rector</label>
                                                <div class="col-sm-10">

                                                    <?= UsuarioController::selectUsuario(
                                                        array(
                                                            'id' => 'rector_id',
                                                            'name' =>'rector_id',
                                                            'defaultValue' =>  '',
                                                            'class' =>'form-control select2bs4 select2-info',
                                                            'where' => "rol = 'Administrador' and estado = 'Activo'")
                                                    )
                                                    ?>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="telefono" class="col-sm-2 col-form-label">Telefono</label>
                                                <div class="col-sm-10">
                                                    <input required type="number" minlength="6" class="form-control"
                                                           id="telefono" name="telefono" placeholder="Ingrese su telefono"
                                                           value="<?= $frmSession['telefono'] ?? '' ?>">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="correo" class="col-sm-2 col-form-label">Correo Electrónico</label>
                                                <div class="col-sm-10">
                                                    <input required type="email" class="form-control" id="correo"
                                                           name="correo" placeholder="Ingrese su correo electrónico"
                                                           value="<?= $frmSession['correo'] ?? '' ?>">
                                                </div>
                                            </div>



                                            <?php  if (!empty($_SESSION['UserInSession']) && $_SESSION['UserInSession']['rol'] == 'Administrador'){ ?>
                                                <div class="form-group row">
                                                    <label for="numero_documento" class="col-sm-2 col-form-label">Usuario</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="numero_documento" name="numero_documento"
                                                               placeholder="Ingrese su Usuario" value="<?= $frmSession['user'] ?? '' ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="contrasena" class="col-sm-2 col-form-label">Contraseña</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" class="form-control" id="contrasena"
                                                               name="contrasena" placeholder="Ingrese una contraseña">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                                    <div class="col-sm-10">
                                                        <select required id="estado" name="estado" class="custom-select">
                                                            <option <?= ( !empty($frmSession['estado']) && $frmSession['estado'] == "Activo") ? "selected" : ""; ?> value="Activo">Activo</option>
                                                            <option <?= ( !empty($frmSession['estado']) && $frmSession['estado'] == "Inactivo") ? "selected" : ""; ?> value="Inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="rol" class="col-sm-2 col-form-label">Rol</label>
                                                    <div class="col-sm-10">
                                                        <select required id="rol" name="rol" class="custom-select">
                                                            <option <?= (!empty($frmSession['rol']) && $frmSession['rol'] == "Administrador") ? "selected" : ""; ?> value="Administrador">Administrador</option>
                                                            <option <?= (!empty($frmSession['rol']) && $frmSession['rol'] == "Estudiante") ? "selected" : ""; ?> value="Estudiante">Estudiante</option>

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
<script>
    $(function() {
        $('#departamento_id').on('change', function() {
            $.post("../../../app/Controllers/MainController.php?controller=Municipios&action=selectMunicipios", {
                isMultiple: false,
                isRequired: true,
                id: "municipio_id",
                nombre: "municipio_id",
                defaultValue: "",
                class: "form-control select2bs4 select2-info",
                where: "departamento_id = "+$('#departamento_id').val()+" and estado = 'Activo'",
                request: 'ajax'
            }, function(e) {
                if (e)
                    console.log(e);
                $("#municipio_id").html(e).select2({ height: '100px'});
            });
        });
        $('.btn-file span').html('Seleccionar');
    });
</script>
</body>
</html>