<?php
require("../../partials/routes.php");
//require_once("../../partials/check_login.php");

use App\Controllers\CursoController;
use App\Controllers\MatriculaController;
use App\Models\Matricula;
use App\Models\GeneralFunctions;
use Carbon\Carbon;

$nameModel = "Asistencia";
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION['frm'.$pluralModel] ?? NULL;
?>

<?php
    $dataCurso = null;
    $fechaReporte = null;
    if (!empty($_GET['cursos_id'])) {
        $dataCurso = \App\Controllers\CursoController::searchForID(["id" => $_GET['cursos_id']]);
        $fechaReporte = $_GET['fecha'];
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title> Crear Asistencia | <?= $_ENV['TITLE_SITE'] ?></title>
    <?php require("../../partials/head_imports.php"); ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-responsive/css/responsive.bootstrap4.css">
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-buttons/css/buttons.bootstrap4.css">
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require("../../partials/navbar_customization.php"); ?>

    <?php require("../../partials/sliderbar_main_menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Generar Mensaje de alerta -->
        <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
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
                            <li class="breadcrumb-item active">Crear</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- /.row -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-shopping-cart"></i> &nbsp; Información de la
                                    <?= $nameModel ?></h3>
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

                            <div class="card-body">
                                <form class="form-horizontal" method="get" id="frmCreate<?= $nameModel ?>" name="frmCreate<?= $nameModel ?>"
                                      action="#">

                                    <div class="form-group row">
                                        <label for="fecha" class="col-sm-4 col-form-label">Fecha</label>
                                        <div class="col-sm-8">
                                            <input required type="date" class="form-control datetimepicker-input"  id="fecha"
                                                   name="fecha" placeholder="Ingrese la fecha" value="<?= $frmSession['fecha'] ?? ($_GET['fecha'] ?? "") ?>">
                                        </div>
                                    </div>




                                    <div class="form-group row">
                                        <label for="cursos_id" class="col-sm-4 col-form-label">Curso</label>
                                        <div class="col-sm-8">
                                            <?= CursoController::selectCurso(
                                                array(
                                                    'id' => 'cursos_id',
                                                    'name' => 'cursos_id',
                                                    'defaultValue' => (!empty($dataCurso)) ? $dataCurso->getId() : '',
                                                    'class' => 'form-control select2bs4 select2-info',
                                                    'where' => "estado = 'Activo'"
                                                )
                                            );
                                            ?>
                                        </div>
                                    </div>


                                    <?php
                                    if (!empty($dataAsistencia)) {
                                        ?>
                                        <div class="form-group row">
                                            <label for="fecha" class="col-sm-4 col-form-label">Fecha</label>
                                            <div class="col-sm-8">
                                                <?= $dataAsistencia->getFecha() ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="Curso" class="col-sm-4 col-form-label">Curso</label>
                                            <div class="col-sm-8">
                                                <?= $dataAsistencia->getMatricula()->getCurso()->getId() ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <hr>
                                    <button type="submit" class="btn btn-info">Enviar</button>
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-8">
                        <div class="card card-lightblue">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-parachute-box"></i> &nbsp; Listado de Alumnos</h3>
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

                            <div class="card-body">

                                <div class="row">
                                    <div class="col">
                                        <table id="tblAsistencias" class="datatable table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Nombre</th>
                                                <th>Curso</th>
                                                <th>Reporte</th>
                                                <th>Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php

                                            if (!empty($dataCurso) and !empty($dataCurso->getId())) {
                                                $arrMatriculasCurso = $dataCurso->getMatriculasCurso();
                                                if(count($arrMatriculasCurso) > 0) {
                                                    /* @var $arrMatriculasCurso Matricula[]  */
                                                    foreach ($arrMatriculasCurso as $detalleMatricula) {
                                                        ?>
                                                        <tr>


                                                            <td><?php echo $detalleMatricula->getId(); ?></td>
                                                            <td><?php echo Carbon::parse($_GET['fecha'])->locale('es')->translatedFormat('l, j \\de F Y'); ?></td>
                                                            <td><?php echo $detalleMatricula->getUsuario()->getApellidos()," ",  $detalleMatricula->getUsuario()->getNombres(), "-", $detalleMatricula->getUsuario()->getNumeroDocumento()  ; ?></td>
                                                            <td><?php echo $detalleMatricula->getCurso()->getNombre(); ?></td>
                                                            <td><?php echo $detalleMatricula->getReporteAsistencia(); ?></td>

                                                            <td>
                                                                <!--
                                                                <a type="button"
                                                                   href="../../../app/Controllers/MainController.php?controller=Asistencia&action=registrar&id=<?= $detalleMatricula->getId(); ?>&fecha=<?= $_GET['fecha']; ?>"
                                                                   data-toggle="tooltip" title="Registrar Inasistencia"
                                                                   class="btn docs-tooltip btn-danger btn-xs"><i
                                                                            class="fa fa-times-circle"></i></a>
                                                                    -->
                                                                <?php if ($detalleMatricula->getReporteAsistencia() != "Asiste") { ?>

                                                                    <a  href="../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=asiste&id=<?=$detalleMatricula->getId();?>&fecha=<?=$_GET['fecha'];?>&cursos_id=<?=$_GET['cursos_id'];  ?>"
                                                                        type="button" data-toggle="tooltip" title="Asiste"
                                                                        class="btn docs-tooltip btn-success btn-xs"><i
                                                                                class="fa fa-hand-paper"></i></a>
                                                                <?php } else { ?>
                                                                    <a type="button"
                                                                       href="../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=no_asiste&id=<?=$detalleMatricula->getId();?>&fecha=<?=$_GET['fecha'];?>&cursos_id=<?=$_GET['cursos_id'];  ?>"
                                                                       data-toggle="tooltip" title="No asiste"
                                                                       class="btn docs-tooltip btn-danger btn-xs"><i
                                                                                class="fa fa-user-times"></i></a>
                                                                <?php } ?>

                                                               <!-- <?php /*if ($detalleMatricula->getEstado() != "Activo") { */?>
                                                                    <a href="../../../app/Controllers/MainController.php?controller=<?/*= $nameModel */?>&action=activate&id=<?/*= $detalleMatricula->getId(); */?>"
                                                                       type="button" data-toggle="tooltip" title="Activar"
                                                                       class="btn docs-tooltip btn-success btn-xs"><i
                                                                                class="fa fa-check-square"></i></a>
                                                                <?php /*} else { */?>
                                                                    <a type="button"
                                                                       href="../../../app/Controllers/MainController.php?controller=<?/*= $nameModel */?>&action=inactivate&id=<?/*= $detalleMatricula->getId(); */?>"
                                                                       data-toggle="tooltip" title="Inactivar"
                                                                       class="btn docs-tooltip btn-danger btn-xs"><i
                                                                                class="fa fa-times-circle"></i></a>
                                                                --><?php /*} */?>
                                                            </td>


                                                        </tr>
                                                    <?php }
                                                }
                                            }?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Nombre</th>
                                                <th>Curso</th>
                                                <th>Reporte</th>
                                                <th>Acciones</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require('../../partials/footer.php'); ?>
</div>
<!-- ./wrapper -->
<?php require('../../partials/scripts.php'); ?>
<!-- Scripts requeridos para las datatables -->
<?php require('../../partials/datatables_scripts.php'); ?>

<script>
    function saveAsistencia(matriculas_id, reporte) {

        if(matriculas_id !== "") {
            $.post("../../../app/Controllers/MainController.php?controller=<?= $nameModel ?>&action=registrarAsistencia",
                {
                    fecha: "<?= $_GET['fecha']?>",
                    observacion: "No justificada",
                    matriculas_id: matriculas_id,
                    estado: "Activo",
                    reporte: reporte,
                    request: 'ajax'
                }, "json"
            )
            .done(function( resultProducto ) {
                alert(resultProducto)
            })
            .fail(function(err) {
                console.log( "Error al realizar la consulta"+err );
            })
        }

    }

    $(function () {


            /*var dataSelect = e.params.data;
            var dataProducto = null;
            if(dataSelect.id !== ""){
                $.post("../../../app/Controllers/MainController.php?controller=Productos&action=searchForID",
                    {
                        id: dataSelect.id,
                        request: 'ajax'
                    }, "json"
                )
                    .done(function( resultProducto ) {
                        dataProducto = resultProducto;
                    })
                    .fail(function(err) {
                        console.log( "Error al realizar la consulta"+err );
                    })
                    .always(function() {
                        updateDataProducto(dataProducto);
                    });
            }else{
                updateDataProducto(dataProducto);
            }*/

    });
</script>

</body>
</html>
