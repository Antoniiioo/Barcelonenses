<?php
session_start();


require_once './controlador/ControladorTipoUsuario.php';
require_once './controlador/ControladorDireccion.php';
require_once './controlador/ControladorUsuario.php';

?>

<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="d-flex flex-column min-vh-100">
<?php include "includes/design-top.php"; ?>
<?php include "includes/navigation.php"; ?>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="text-center mb-4">
                <h2 class="font-titulos text-primary">Panel de Administración</h2>
                <p class="text-secondary">Selecciona una opción para gestionar</p>
            </div>

            <div class="d-flex flex-column gap-3">
                <a href="vistaUsuario.php" class="btn btn-primary btn-lg rounded-3 py-3 text-start d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-person-gear me-2"></i>Panel de Usuarios</span>
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a href="panelProducto.php" class="btn btn-info btn-lg rounded-3 py-3 text-start d-flex align-items-center justify-content-between text-white">
                    <span><i class="bi bi-box-seam me-2"></i>Panel de Productos</span>
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a href="#" class="btn btn-secondary btn-lg rounded-3 py-3 text-start d-flex align-items-center justify-content-between text-white">
                    <span><i class="bi bi-star me-2"></i>Panel de Valoraciones</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</main>

<?php include "includes/footer.php"; ?>
</body>
</html>
