<?php
require_once("../../../app/Controllers/UsuarioController.php");
require_once("../../partials/routes.php");
//require_once("../../partials/check_login.php");

use App\Controllers\UsuarioController;
use App\Models\GeneralFunctions;
use App\Models\Usuario;

$nameModel = "Usuario";
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
                        <h1>Gestionar Usuarios</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestionar Usuarios</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Generar Mensajes de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Default box -->
                        <div class="card card-dark">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i> &nbsp; Gestionar Usuarios</h3>
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
                                <i class="fas fa-plus"></i> Crear Usuario
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <table id="tblUsuarios" class="datatable table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Documento/Código</th>
                                    <th>Típo de documento</th>
                                    <th>Dirección</th>
                                    <th>Género</th>
                                    <th>Rol</th>
                                    <th>Institución</th>
                                    <th>Fecha de nacimiento</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th>Nombres de acudiente</th>
                                    <th>Télefono de acudiente</th>
                                    <th>Correo de acudiente</th>
                                    <th>Estado</th>
                                    <th>Creación</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $arrUsuarios = UsuarioController::getAll();
                                /* @var $arrUsuarios \App\Models\Usuario[] */
                                foreach ($arrUsuarios as $usuario) {
                                    ?>
                                    <tr>
                                        <td><?=  $usuario->getId(); ?></td>
                                        <td><?=  $usuario->getNombres(); ?></td>
                                        <td><?=  $usuario->getApellidos(); ?></td>
                                        <td><?=  $usuario->getNumeroDocumento(); ?></td>
                                        <td><?=  $usuario->getTipoDocumento(); ?></td>
                                        <td><?=  $usuario->getDireccion(); ?> - <?=  $usuario->getMunicipio()->getNombre() ; ?> - <?= $usuario->getMunicipio()->getDepartamento()->getNombre(); ?></td>
                                        <td><?=  $usuario->getGenero(); ?></td>
                                        <td><?=  $usuario->getRol(); ?></td>
                                        <td> <?= $usuario->getInstitucion()->getNombre() ?></td>
                                        <td><?=  $usuario->getFechaNacimiento()->translatedFormat('l, j \\de F Y'); ?></td>
                                        <td><?=  $usuario->getTelefono(); ?></td>
                                        <td><?=  $usuario->getCorreo(); ?></td>
                                        <td><?=  $usuario->getNombreAcudiente(); ?></td>
                                        <td><?=  $usuario->getTelefonoAcudiente(); ?></td>
                                        <td><?=  $usuario->getCorreoAcudiente(); ?></td>
                                        <td><?=  $usuario->getEstado(); ?></td>
                                        <td><?=  $usuario->getCreatedAt(); ?></td>
                                        <td>
                                            <a href="edit.php?id=<?php echo $usuario->getId(); ?>"
                                               type="button" data-toggle="tooltip" title="Actualizar"
                                               class="btn docs-tooltip btn-primary btn-xs"><i
                                                        class="fa fa-edit"></i></a>
                                            <a href="show.php?id=<?php echo $usuario->getId(); ?>"
                                               type="button" data-toggle="tooltip" title="Ver"
                                               class="btn docs-tooltip btn-warning btn-xs"><i
                                                        class="fa fa-eye"></i></a>

                                            <?php if ($usuario->getEstado() != "Activo") { ?>
                                                <a href="../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=activate&id=<?= $usuario->getId(); ?>"
                                                   type="button" data-toggle="tooltip" title="Activar"
                                                   class="btn docs-tooltip btn-success btn-xs"><i
                                                            class="fa fa-check-square"></i></a>
                                            <?php } else { ?>
                                                <a type="button"
                                                   href="../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=inactivate&id=<?= $usuario->getId(); ?>"
                                                   data-toggle="tooltip" title="Inactivar"
                                                   class="btn docs-tooltip btn-danger btn-xs"><i
                                                            class="fa fa-times-circle"></i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Documento/Código</th>
                                    <th>Típo de documento</th>
                                    <th>Dirección</th>
                                    <th>Género</th>
                                    <th>Rol</th>
                                    <th>Institución</th>
                                    <th>Fecha de nacimiento</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th>Nombres de acudiente</th>
                                    <th>Télefono de acudiente</th>
                                    <th>Correo de acudiente</th>
                                    <th>Estado</th>
                                    <th>Creación</th>
                                    <th>Acciones</th>

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

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php include_once ('../../partials/footer.php') ?>
</div>
<!-- ./wrapper -->

<?php include_once ('../../partials/scripts.php') ?>
<!-- DataTables -->
<script src="<?= $adminlteURL ?>/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-responsive/js/dataTables.responsive.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-responsive/js/responsive.bootstrap4.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-buttons/js/dataTables.buttons.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-buttons/js/buttons.bootstrap4.js"></script>
<script src="<?= $adminlteURL ?>/plugins/jszip/jszip.js"></script>
<script src="<?= $adminlteURL ?>/plugins/pdfmake/pdfmake.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-buttons/js/buttons.html5.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-buttons/js/buttons.print.js"></script>
<script src="<?= $adminlteURL ?>/plugins/datatables-buttons/js/buttons.colVis.js"></script>

<script>
    $(function () {
        $('.datatable').DataTable({
            "dom": 'Bfrtip',
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "language": {
                "url": "../../public/Spanish.json" //Idioma
            },
            "buttons": [
                'copy', 'print', 'excel', 'pdf'
            ],
            "pagingType": "full_numbers",
            "responsive": true,
            "stateSave": true, //Guardar la configuracion del usuario
        });
    });
</script>
</body>
</html>