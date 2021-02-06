<?php use Carbon\Carbon;
require("partials/routes.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Crear Usuario</title>
    <?php include_once ('partials/head_imports.php') ?>
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <?php include_once ('partials/navbar_customization.php') ?>

    <?php include_once ('partials/sliderbar_main_menu.php') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Institución Educativa Indalecio Vásquez - Pesca </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>

                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>Descripcion de la Institución</b></h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <p>
                        <font  size=3px face="Century Gothic">LA INSTITUCION EDUCATIVA INDALECIO VASQUEZ, la cual cuenta en la actualidad con 9 sedes activas, 7 en el sector rural que prestan el servicio de educación en básica primaria, 2 sedes ubicadas en la parte urbana del municipio, 1 que su planta física es propiedad de LA FUNDACION DE INSTURCCION CRISTIANA CATOLICA INDALECIO VASQUEZ, se encuentra en calidad de arrendamiento por parte de la gobernación y atiende a estudiantes de preescolar a 4° de primaria. </font>
                    </p>
                </div>
                <!-- /.card-body -->

                <div class="slider">
                    <ul>
                        <li>
                            <img src="http://dominicushoeve.com/wp-content/uploads/ktz/latest-high-resolution-wallpaper-1920x1080-70558-pictures-high-resolution-wallpaper-30whtvl34j4r12m8b0c1sa.jpg" alt="">
                        </li>
                        <li>
                            <img src="http://youghaltennisclub.ie/wp-content/uploads/2014/06/Tennis-Wallpaper-High-Definition-700x300.jpg" alt="">
                        </li>
                        <li>
                            <img src="http://welltechnically.com/wp-content/uploads/2013/08/android-wallpapers-700x300.jpg" alt="">
                        </li>
                        <li>
                            <img src="http://welltechnically.com/wp-content/uploads/2013/09/android-widescreen-wallpaper-14165-hd-wallpapers-700x300.jpg" alt="">
                        </li>
                    </ul>
                </div>

            </div>
            <!-- /.card-footer-->
    </div>
    <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once ('partials/footer.php') ?>
</div>
<!-- ./wrapper -->

<?php include_once ('partials/scripts.php') ?>
</body>
</html>