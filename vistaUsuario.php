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

<main class="d-flex justify-content-between">
    <form action="" method="post">
        <label for="eligeUsuario">Elige el Usuario</label>
        <select name="elegirUsuario" id="eligeUsuario">
            <?php
            try {
                $listaUsuarios = ControladorUsuario::obtenerTodosUsuarios();
                foreach ($listaUsuarios as $usuario) {
                    echo "<option value='" . $usuario->id_usuario . "'>" . $usuario->email . "</option>";
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            ?>
        </select>
        <input type="submit" value="Seleccionar Usuario">
        <input type="submit" value="Eliminar Usuario">
    </form>
    <form action="" method="post">
        <input type="submit" value="Crear" name="crear">
    </form>
</main>

<?php include "includes/footer.php"; ?>
</body>
</html>
