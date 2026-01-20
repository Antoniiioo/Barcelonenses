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

<main class="container">
    <a href="vistaUsuario.php">Panel Usuario</a>
    <a href="panelProducto.php">Panel Productos</a>
    <a href="">Panel Valoraciones</a>
</main>

<?php include "includes/footer.php"; ?>
</body>
</html>
