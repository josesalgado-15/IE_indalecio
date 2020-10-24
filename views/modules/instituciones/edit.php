<?php
require("../../partials/routes.php");
require("../../../app/Controllers/InstitucionController.php");

use App\Controllers\InstitucionController;
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Editar Institucion</title>
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
                        <h1>Editar Institucion</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/">Institucion</a></li>
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
                        Error al crear la institucion: <?= $_GET['mensaje'] ?>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i> &nbsp; Información de la Institución</h3>
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
                                $DataInstitucion = InstitucionController::searchForID($_GET["id"]);
                                if (!empty($DataInstitucion)) {
                                    ?>

                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <!-- form start -->
                                        <form class="form-horizontal" method="post" id="frmEditInstitucion"
                                              name="frmEditInstitucion"
                                              action="../../../app/Controllers/InstitucionController.php?action=edit">
                                            <input id="id" name="id" value="<?php echo $DataInstitucion->getId(); ?>" hidden
                                                   required="required" type="text">

                                            <div class="form-group row">
                                                <label for="nombre" class="col-sm-2 col-form-label">Nombres</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="nombre" name="nombre"
                                                           placeholder="Ingrese sus nombres"  value="<?php echo $DataInstitucion->getNombre(); ?>">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="direccion" class="col-sm-2 col-form-label">Direccion</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" class="form-control" id="direccion"
                                                           name="direccion" placeholder="Ingrese su direccion" value="<?php echo $DataInstitucion->getDireccion(); ?>">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="municipios_id" class="col-sm-2 col-form-label">Municipio</label>
                                                <div class="col-sm-10">
                                                    <select id="municipios_id" name="municipios_id" class="custom-select">
                                                        <option>Seleccione</option>
                                                        <option <?= ($DataInstitucion->getMunicipiosId() == "EjemploMunicipio")? "selected" : ""; ?> value="Ejemplo Municipio">Municipio</option>
                                                        <option <?= ($DataInstitucion->getMunicipiosId() == "EjemploMunicipio")? "selected" : ""; ?> value="Ejemplo Municipio">Municipio</option>
                                                        <option <?= ($DataInstitucion->getMunicipiosId() == "EjemploMunicipio")? "selected" : ""; ?> value="Ejemplo Municipio">Municipio</option>
                                                        <option <?= ($DataInstitucion->getMunicipiosId() == "EjemploMunicipio")? "selected" : ""; ?> value="Ejemplo Municipio">Municipio</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="rector" class="col-sm-2 col-form-label">Rector</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" minlength="1" class="form-control"
                                                           id="rector" name="rector" placeholder="Ingrese su rector" value="<?php echo $DataInstitucion->getRector(); ?>">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="telefono" class="col-sm-2 col-form-label">Telefono</label>
                                                <div class="col-sm-10">
                                                    <input required type="text" minlength="6" class="form-control"
                                                           id="telefono" name="telefono" placeholder="Ingrese su telefono" value="<?php echo $DataInstitucion->getTelefono(); ?>">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="correo" class="col-sm-2 col-form-label">Correo Electrónico</label>
                                                <div class="col-sm-10">
                                                    <input required type="email" class="form-control" id="correo"
                                                           name="correo" placeholder="Ingrese su correo electrónico" value="<?php echo $DataInstitucion->getCorreo(); ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                                <div class="col-sm-10">
                                                    <select id="estado" name="estado" class="custom-select">
                                                        <option <?= ($DataInstitucion->getEstado() == "Activo")? "selected" : ""; ?> value="Activo">Activo</option>
                                                        <option <?= ($DataInstitucion->getEstado() == "Inactivo")? "selected" : ""; ?> value="Inactivo">Inactivo</option>

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
