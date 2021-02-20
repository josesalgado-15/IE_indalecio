<?php
require("../../partials/routes.php");

use App\Controllers\DepartamentosController;
use App\Controllers\InstitucionController;
use App\Controllers\MunicipiosController;
use App\Models\GeneralFunctions;
use Carbon\Carbon;

$nameModel = "Sede";
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION['frm'.$pluralModel] ?? NULL;
?>

<!DOCTYPE html>
<html>
<head>
    <title> Crear <?= $nameModel?> | <?= $_ENV['TITLE_SITE'] ?></title>
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
                        <h1>Crear una Nueva <?= $nameModel ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
                            <li class="breadcrumb-item active">Crear</li>
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
                                <form class="form-horizontal" method="post" id="frmCreateSede"
                                      name="frmCreate<?= $nameModel ?>"
                                      action="../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=create">
                                    <div class="form-group row">
                                        <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                        <div class="col-sm-10">
                                            <input required type="text" class="form-control" id="nombre"
                                                   name="nombre" placeholder="Ingrese le nombre" value="<?= $frmSession['nombre'] ?? '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="direccion" class="col-sm-2 col-form-label">Dirección</label>
                                        <div class="col-sm-10">
                                            <input required type="text" class="form-control" id="direccion"
                                                   name="direccion" placeholder="Ingrese la direccion" value="<?= $frmSession['direccion'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="municipio_id" class="col-sm-2 col-form-label">Municipio</label>
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
                                                'id' => 'municipio_id',
                                                'name' => 'municipio_id',
                                                'defaultValue' => (!empty($frmSession['municipio_id'])) ? $frmSession['municipio_id'] : '',
                                                'class' => 'form-control select2bs4 select2-info',
                                                'where' => "departamento_id = 15 and estado = 'Activo'"))
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
                                        <div class="col-sm-10">
                                            <input required type="number" minlength="6" class="form-control"
                                                   id="telefono" name="telefono" placeholder="Ingrese telefono"
                                                   value="<?= $frmSession['telefono'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="instituciones_id" class="col-sm-2 col-form-label">Institución Sede</label>
                                        <div class="col-sm-10">
                                            <?= InstitucionController::selectInstitucion(
                                                array(
                                                    'id' => 'instituciones_id',
                                                    'name' => 'instituciones_id',
                                                    'defaultValue' => (!empty($frmSession['instituciones_id'])) ? $frmSession['instituciones_id'] : '',
                                                    'class' => 'form-control select2bs4 select2-info',
                                                    'where' => "estado = 'Activo'"
                                                )
                                            );
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