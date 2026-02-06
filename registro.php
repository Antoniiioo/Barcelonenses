<?php
session_start();
require_once './controlador/ControladorUsuario.php';
require_once './includes/captcha.php';

// Pre-rellenar datos de Google si vienen del login
$nombrePrefill = $_SESSION['google_nombre'] ?? '';
$apellidoPrefill = $_SESSION['google_apellido'] ?? '';
$emailPrefill = $_SESSION['google_email'] ?? '';

// Limpiar variables de sesión de Google después de usarlas
unset($_SESSION['google_email'], $_SESSION['google_nombre'], $_SESSION['google_apellido']);

$error = '';
$success = '';
$erroresValidacion = [];

// Verificar si hay errores de Google
if (isset($_SESSION['error_google'])) {
    $error = $_SESSION['error_google'];
    unset($_SESSION['error_google']);
}

// Procesar registro
if (isset($_POST['registrar'])) {
    try {
        // Validar captcha primero
        $captchaUsuario = $_POST['captcha'] ?? '';
        $resultadoCaptcha = validarCaptcha($captchaUsuario);
        
        if (!$resultadoCaptcha['valido']) {
            $error = $resultadoCaptcha['mensaje'];
            $erroresValidacion[] = 'valCaptcha';
        } else {
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido1 = trim($_POST['apellido1'] ?? '');
            $apellido2 = trim($_POST['apellido2'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $password = $_POST['contrasena'] ?? '';
            $confirmarPassword = $_POST['confirmar_contrasena'] ?? '';

            // Validar datos
            $erroresValidacion = ControladorUsuario::validarDatos(
                $nombre, 
                $apellido1, 
                $email, 
                $telefono, 
                $password, 
                $confirmarPassword
            );

            if (empty($erroresValidacion)) {
                // Registrar usuario
                if (ControladorUsuario::registrarUsuarioCliente(
                    $nombre, 
                    $apellido1, 
                    $apellido2, 
                    $email, 
                    $telefono, 
                    $password
                )) {
                    $success = "Usuario registrado correctamente. Ahora puedes iniciar sesión.";
                    // Limpiar campos y captcha
                    $_POST = [];
                    limpiarCaptcha();
                } else {
                    $error = "Error al registrar usuario. Inténtalo de nuevo.";
                }
            } else {
                $error = "Por favor, corrige los errores en el formulario";
            }
        }
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
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
    <!--Fase 2:¿no se debe poner la clase container-fluid y row en el mismo div?-->
    <main class="container-fluid row justify-content-center flex-grow-1">
        <div class="col-lg-10 col-xl-9">
            <h1 class="text-center mb-4 mt-4 font-titulos">Crea tu cuenta</h1>

            <div class="col-md-10 col-lg-8 mx-auto">
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($success) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="" method="post" autocomplete="on">

                    <div class="row mb-3 justify-content-center">
                        <label for="nombre" class="col-sm-4 col-form-label text-sm-start">Nombre *</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control border-secondary <?= in_array('valNombre', $erroresValidacion) ? 'is-invalid' : '' ?>" 
                                id="nombre" name="nombre" required autocomplete="given-name" 
                                value="<?= isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : htmlspecialchars($nombrePrefill) ?>">
                            <?php if (in_array('valNombre', $erroresValidacion)): ?>
                                <div class="invalid-feedback">Nombre inválido (máx. 40 caracteres, solo letras)</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="apellido1" class="col-sm-4 col-form-label text-sm-start">Apellido 1 *</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control border-secondary <?= in_array('valApellido1', $erroresValidacion) ? 'is-invalid' : '' ?>" 
                                id="apellido1" name="apellido1" required autocomplete="family-name"
                                value="<?= isset($_POST['apellido1']) ? htmlspecialchars($_POST['apellido1']) : htmlspecialchars($apellidoPrefill) ?>">
                            <?php if (in_array('valApellido1', $erroresValidacion)): ?>
                                <div class="invalid-feedback">Apellido inválido (máx. 40 caracteres, solo letras)</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="apellido2" class="col-sm-4 col-form-label text-sm-start">Apellido 2</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control border-secondary" 
                                id="apellido2" name="apellido2" autocomplete="family-name"
                                value="<?= isset($_POST['apellido2']) ? htmlspecialchars($_POST['apellido2']) : '' ?>">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="email" class="col-sm-4 col-form-label text-sm-start">Dirección e-mail *</label>
                        <div class="col-sm-7">
                            <input type="email" class="form-control border-secondary <?= in_array('valEmail', $erroresValidacion) ? 'is-invalid' : '' ?>" 
                                id="email" name="email" required autocomplete="email"
                                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : htmlspecialchars($emailPrefill) ?>">
                            <?php if (in_array('valEmail', $erroresValidacion)): ?>
                                <div class="invalid-feedback">Email inválido (máx. 60 caracteres)</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="telefono" class="col-sm-4 col-form-label text-sm-start">Teléfono móvil *</label>
                        <div class="col-sm-7">
                            <input type="tel" class="form-control border-secondary <?= in_array('valTelefono', $erroresValidacion) ? 'is-invalid' : '' ?>" 
                                id="telefono" name="telefono" required autocomplete="tel" pattern="[0-9]{9}"
                                value="<?= isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : '' ?>">
                            <?php if (in_array('valTelefono', $erroresValidacion)): ?>
                                <div class="invalid-feedback">Teléfono inválido (debe tener 9 dígitos)</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="contrasena" class="col-sm-4 col-form-label text-sm-start">Contraseña *</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control border-secondary <?= in_array('valPass', $erroresValidacion) ? 'is-invalid' : '' ?>" 
                                id="contrasena" name="contrasena" required autocomplete="new-password" minlength="8">
                            <?php if (in_array('valPass', $erroresValidacion)): ?>
                                <div class="invalid-feedback">Contraseña debe tener exactamente 8 caracteres</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="confirmar-contrasena" class="col-sm-4 col-form-label text-sm-start">Confirmar
                            contraseña *</label>
                        <div class="col-sm-7 mb-3">
                            <input type="password" class="form-control border-secondary <?= in_array('valRepPass', $erroresValidacion) ? 'is-invalid' : '' ?>" 
                                id="confirmar-contrasena" name="confirmar_contrasena" required autocomplete="new-password" minlength="8">
                            <?php if (in_array('valRepPass', $erroresValidacion)): ?>
                                <div class="invalid-feedback">Las contraseñas no coinciden</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Captcha matemático -->
                    <?php 
                    renderCaptcha(
                        $erroresValidacion, 
                        isset($_POST['captcha']) && !$success ? $_POST['captcha'] : ''
                    ); 
                    ?>

                    <div class="row mb-3 mt-4">
                        <div class="col-12 d-flex justify-content-center flex-wrap gap-2">
                            <a href="login.php" class="btn btn-info">YA TENGO CUENTA</a>
                            <button type="submit" name="registrar" class="btn btn-primary">REGISTRAR</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </main>

    <?php include "includes/footer.php"; ?>
</body>

</html>