<?php require("partials/routes.php"); ?>


<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="public/css/estilos.css">

    <title> Inicio | <?= $_ENV['TITLE_SITE'] ?></title>
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



                <!-- Carusel-->

                <div class="container">

                    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class ="caruselimg"  src="<?= $baseURL ?>/views/public/img/pes1.jpg" width="100%" height="50%" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Institución Educativa Indalecio Vásquez</h5>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class ="caruselimg"  src="<?= $baseURL ?>/views/public/img/pes2.jpg" width="100%" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Institución Educativa Indalecio Vásquez</h5>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class ="caruselimg"  src="<?= $baseURL ?>/views/public/img/pes3.jpg" width="100%" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Institución Educativa Indalecio Vásquez</h5>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
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