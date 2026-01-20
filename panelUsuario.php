<?php
session_start();

require_once './controlador/ControladorTipoUsuario.php';
require_once './controlador/ControladorDireccion.php';
require_once './controlador/ControladorUsuario.php';

// Guardar usuario con dirección
if (isset($_POST['guardar'])) {
    try {
        // 1. Crear dirección primero
        $idDireccion = ControladorDireccion::crearDireccion($_POST['calle'],
                $_POST['numCalle'],
                $_POST['codPostal'],
                $_POST['localidad'],
                $_POST['pais']
        );

        // 2. Crear usuario con el id_direccion
        $nuevoUsuario = new Usuario(
                null,
                $_POST['nombre'],
                $_POST['apellido1'],
                $_POST['apellido2'],
                $_POST['email'],
                $_POST['telefono'],
                $_POST['fechaNac'],
                password_hash($_POST['contrasena'], PASSWORD_DEFAULT),
                $_POST['idTipoUsuario'],
                $idDireccion
        );
        ControladorUsuario::crearUsuario($nuevoUsuario);

        echo "<div class='alert alert-success'>Usuario creado correctamente</div>";
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
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

<main class="container-fluid row justify-content-center flex-grow-1 py-4">
    <div class="col-lg-10 col-xl-9">
        <h1 class="text-center mb-4 font-titulos">Panel de Usuarios</h1>

        <!-- Selector de Usuario -->
        <div class="col-md-10 col-lg-8 mx-auto mb-4">
            <form action="" method="post">
                <div class="row mb-3 justify-content-center">
                    <label for="eligeUsuario" class="col-sm-4 col-form-label text-sm-start">Seleccionar Usuario</label>
                    <div class="col-sm-7">
                        <select name="elegirUsuario" id="eligeUsuario" class="form-select border-secondary">
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
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 d-flex justify-content-center flex-wrap gap-2">
                        <button type="submit" name="seleccionarUsuario" class="btn btn-primary">SELECCIONAR</button>
                        <button type="submit" name="eliminarUsuario" class="btn btn-danger">ELIMINAR</button>
                        <button type="submit" name="crear" class="btn btn-info">CREAR NUEVO</button>
                    </div>
                </div>
            </form>
        </div>

        <?php if (isset($_POST['crear']) || isset($_POST['seleccionarUsuario'])) { ?>
            <!-- Formulario único con Usuario + Dirección -->
            <div class="col-md-10 col-lg-8 mx-auto">
                <form action="" method="post" autocomplete="on">

                    <h2 class="text-center mb-4 font-titulos text-primary">Datos del Usuario</h2>

                    <div class="row mb-3 justify-content-center">
                        <label for="nombre" class="col-sm-4 col-form-label text-sm-start">Nombre *</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control border-secondary" id="nombre" name="nombre" required autocomplete="given-name">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="apellido1" class="col-sm-4 col-form-label text-sm-start">Primer Apellido *</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control border-secondary" id="apellido1" name="apellido1" required autocomplete="family-name">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="apellido2" class="col-sm-4 col-form-label text-sm-start">Segundo Apellido</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control border-secondary" id="apellido2" name="apellido2" autocomplete="family-name">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="email" class="col-sm-4 col-form-label text-sm-start">Dirección e-mail *</label>
                        <div class="col-sm-7">
                            <input type="email" class="form-control border-secondary" id="email" name="email" required autocomplete="email">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="telefono" class="col-sm-4 col-form-label text-sm-start">Teléfono móvil *</label>
                        <div class="col-sm-7">
                            <input type="tel" class="form-control border-secondary" id="telefono" name="telefono" required autocomplete="tel">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="fechaNac" class="col-sm-4 col-form-label text-sm-start">Fecha Nacimiento *</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control border-secondary" id="fechaNac" name="fechaNac" required autocomplete="bday">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="contrasena" class="col-sm-4 col-form-label text-sm-start">Contraseña *</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control border-secondary" id="contrasena" name="contrasena" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="idTipoUsuario" class="col-sm-4 col-form-label text-sm-start">Tipo Usuario *</label>
                        <div class="col-sm-7">
                            <select class="form-select border-secondary" id="idTipoUsuario" name="idTipoUsuario" required>
                                <option value="">Selecciona un tipo</option>
                                <option value="1">Usuario</option>
                                <option value="2">Administrador</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h2 class="text-center mb-4 font-titulos text-secondary">Datos de Dirección</h2>

                    <div class="row mb-3 justify-content-center">
                        <label for="calle" class="col-sm-4 col-form-label text-sm-start">Calle *</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control border-secondary" id="calle" name="calle" required autocomplete="street-address">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="numCalle" class="col-sm-4 col-form-label text-sm-start">Número *</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control border-secondary" id="numCalle" name="numCalle" required>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="codPostal" class="col-sm-4 col-form-label text-sm-start">Código Postal *</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control border-secondary" id="codPostal" name="codPostal" required autocomplete="postal-code">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="localidad" class="col-sm-4 col-form-label text-sm-start">Localidad *</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control border-secondary" id="localidad" name="localidad" required autocomplete="address-level2">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="pais" class="col-sm-4 col-form-label text-sm-start">País *</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control border-secondary" id="pais" name="pais" required autocomplete="country-name">
                        </div>
                    </div>

                    <div class="row mb-3 mt-4">
                        <div class="col-12 d-flex justify-content-center">
                            <button type="submit" name="guardar" class="btn btn-primary btn-lg">GUARDAR TODO</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</main>

<?php include "includes/footer.php"; ?>
</body>
</html>
