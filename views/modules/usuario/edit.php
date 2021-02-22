<?php session_start();
require("../../partials/routes.php");
//require_once("../../partials/check_login.php");
require("../../../app/Controllers/UsuarioController.php");

use App\Controllers\DepartamentosController;
use App\Controllers\MunicipiosController;
use App\Controllers\UsuarioController;
use App\Controllers\InstitucionController;
use App\Models\GeneralFunctions;
use App\Models\Usuario;
use Carbon\Carbon;

$nameModel = "Usuario";
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
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
                            <li class="breadcrumb-item active">Editar</li>
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
                                <h3 class="card-title"><i class="fas fa-user"></i> &nbsp; Información del <?= $nameModel ?></h3>
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
                                $DataUsuario = UsuarioController::searchForID(["id" => $_GET["id"]]);
                                /* @var $DataUsuario Usuario */
                                if (!empty($DataUsuario)) {
                                    ?>

                                    <!-- form start -->
                                    <div class="card-body">
                                        <form class="form-horizontal"  method="post" id="frmEdit<?= $nameModel ?>"
                                              name="frmEdit<?= $nameModel ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=edit">

                                            <input id="id" name="id" value="<?= $DataUsuario->getId(); ?>" hidden
                                                   required="required" type="text">

                                            <div class="row">
                                                <div class="col-sm-10">
                                                    <div class="form-group row">
                                                        <label for="nombres" class="col-sm-2 col-form-label">Nombres</label>
                                                        <div class="col-sm-10">
                                                            <input required type="text" class="form-control" id="nombres"
                                                                   name="nombres" value="<?= $DataUsuario->getNombres(); ?>"
                                                                   placeholder="Ingrese sus nombres">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="apellidos" class="col-sm-2 col-form-label">Apellidos</label>
                                                        <div class="col-sm-10">
                                                            <input required type="text" class="form-control" id="apellidos"
                                                                   name="apellidos" value="<?= $DataUsuario->getApellidos(); ?>"
                                                                   placeholder="Ingrese sus apellidos">
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label for="telefono" class="col-sm-2 col-form-label">Telefono</label>
                                                        <div class="col-sm-10">
                                                            <input required type="number" minlength="6" class="form-control"
                                                                   id="telefono" name="telefono" value="<?= $DataUsuario->getTelefono(); ?>" placeholder="Ingrese su telefono">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="numero_documento" class="col-sm-2 col-form-label">Documento</label>
                                                        <div class="col-sm-10">
                                                            <input required type="number" minlength="6" class="form-control"
                                                                   id="numero_documento" name="numero_documento" value="<?= $DataUsuario->getNumeroDocumento(); ?>" placeholder="Ingrese su documento">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="tipo_documento" class="col-sm-2 col-form-label">Tipo
                                                            Documento</label>
                                                        <div class="col-sm-10">
                                                            <select id="tipo_documento" name="tipo_documento" class="custom-select">
                                                                <option <?= ($DataUsuario->getTipoDocumento() == "CC") ? "selected" : ""; ?> value="CC">Cedula de Ciudadania</option>
                                                                <option <?= ($DataUsuario->getTipoDocumento() == "CE") ? "selected" : ""; ?> value="CE">Cedula de Extranjeria</option>
                                                                <option <?= ($DataUsuario->getTipoDocumento() == "TI") ? "selected" : ""; ?> value="TI">Tarjeta de Identidad</option>
                                                                <option <?= ($DataUsuario->getTipoDocumento() == "PASAPORTE") ? "selected" : ""; ?> value="PASAPORTE">Pasaporte</option>
                                                                <option <?= ($DataUsuario->getTipoDocumento() == "REGISTRO CIVIL") ? "selected" : ""; ?> value="REGISTRO CIVIL">Registro Civil</option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="fecha_nacimiento" class="col-sm-2 col-form-label">Fecha Nacimiento</label>
                                                        <div class="col-sm-10">
                                                            <input required type="date" max="<?= Carbon::now()->subYear(12)->format('Y-m-d') ?>"
                                                                   value="<?= $DataUsuario->getFechaNacimiento()->toDateString(); ?>" class="form-control" id="fecha_nacimiento"
                                                                   name="fecha_nacimiento" placeholder="Ingrese su Fecha de Nacimiento">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="direccion" class="col-sm-2 col-form-label">Direccion</label>
                                                        <div class="col-sm-10">
                                                            <input required type="text" class="form-control" id="direccion"
                                                                   name="direccion" value="<?= $DataUsuario->getDireccion(); ?>" placeholder="Ingrese su direccion">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="municipios_id" class="col-sm-2 col-form-label">Municipios</label>
                                                        <div class="col-sm-5">
                                                            <?= DepartamentosController::selectDepartamentos(
                                                                array(
                                                                    'id' => 'departamento_id',
                                                                    'name' => 'departamento_id',
                                                                    'defaultValue' => (!empty($DataUsuario)) ? $DataUsuario->getMunicipio()->getDepartamento()->getId() : '15',
                                                                    'class' => 'form-control select2bs4 select2-info',
                                                                    'where' => "estado = 'Activo'"
                                                                )
                                                            )
                                                            ?>
                                                        </div>
                                                        <div class="col-sm-5 ">
                                                            <?= MunicipiosController::selectMunicipios(
                                                                array (
                                                                    'id' => 'municipios_id',
                                                                    'name' => 'municipios_id',
                                                                    'defaultValue' => (!empty($DataUsuario)) ? $DataUsuario->getMunicipiosId(): '',
                                                                    'class' => 'form-control select2bs4 select2-info',
                                                                    'where' => "departamento_id = ".$DataUsuario->getMunicipio()->getDepartamento()->getId()." and estado = 'Activo'")
                                                            )
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="genero" class="col-sm-2 col-form-label">Género</label>
                                                        <div class="col-sm-10">
                                                            <select id="genero" name="genero" class="custom-select">
                                                                <option <?= ($DataUsuario->getGenero() == "Masculino") ? "selected" : ""; ?> value="Masculino">Masculino</option>
                                                                <option <?= ($DataUsuario->getGenero() == "Femenino") ? "selected" : ""; ?> value="Femenino">Femenino</option>
                                                                <option <?= ($DataUsuario->getGenero() == "Otro") ? "selected" : ""; ?> value="Otro">Otro</option>

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

                                                    <div class="form-group row">
                                                        <label for="correo" class="col-sm-2 col-form-label">Correo Electrónico</label>
                                                        <div class="col-sm-10">
                                                            <input required type="email" class="form-control" id="correo"
                                                                   name="correo"  value="<?= $DataUsuario->getCorreo(); ?>"
                                                                   placeholder="Ingrese su correo electrónico">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="contrasena" class="col-sm-2 col-form-label">Contraseña</label>
                                                        <div class="col-sm-10">
                                                            <input required type="password" class="form-control" id="contrasena"
                                                                   name="contrasena"  value="<?= $DataUsuario->getContrasena(); ?>"
                                                                   placeholder="Ingrese su contraseña">
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
                                                        <label for="nombre_acudiente" class="col-sm-2 col-form-label">Nombres Acudientes</label>
                                                        <div class="col-sm-10">
                                                            <input required type="text" class="form-control" id="nombre_acudiente" name="nombre_acudiente"
                                                                   value="<?= $DataUsuario->getNombreAcudiente(); ?>" placeholder="Ingrese sus nombres completos">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="telefono_acudiente" class="col-sm-2 col-form-label">Telefono Acudiente</label>
                                                        <div class="col-sm-10">
                                                            <input required type="number" minlength="6" class="form-control"
                                                                   id="telefono_acudiente" name="telefono_acudiente" value="<?= $DataUsuario->getTelefonoAcudiente(); ?>" placeholder="Ingrese su telefono">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="correo_acudiente" class="col-sm-2 col-form-label">Correo Electrónico</label>
                                                        <div class="col-sm-10">
                                                            <input required type="email" class="form-control" id="correo_acudiente"
                                                                   name="correo_acudiente" value="<?= $DataUsuario->getCorreoAcudiente(); ?>" placeholder="Ingrese su correo electrónico">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="instituciones_id" class="col-sm-2 col-form-label">Institución</label>
                                                        <div class="col-sm-10">
                                                            <?= InstitucionController::selectInstitucion(
                                                                array(
                                                                    'id' => 'instituciones_id',
                                                                    'name' => 'instituciones_id',
                                                                    'defaultValue' => (!empty($DataUsuario)) ? $DataUsuario->getInstitucion()->getId() : '',
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
            })
        });
    });
</script>
</body>
</html>