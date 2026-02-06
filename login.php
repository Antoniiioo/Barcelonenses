<?php
session_start();
require_once 'includes/a_config.php'; // PRIMERO: inicializa $google_client
require_once 'includes/google_connect.php'; // DESPUÉS: usa $google_client
require_once './controlador/ControladorUsuario.php';

$error = '';
$success = '';

// Verificar si hay errores de Google
if (isset($_SESSION['error_google'])) {
    $error = $_SESSION['error_google'];
    unset($_SESSION['error_google']);
}

// Procesar login
if (isset($_POST['login'])) {
    try {
        $email = $_POST['email'] ?? '';
        $password = $_POST['contrasena'] ?? '';

        if (empty($email) || empty($password)) {
            $error = "Por favor, completa todos los campos";
        } else {
            if (ControladorUsuario::login($email, $password)) {
                header("Location: index.php");
                exit();
            } else {
                $error = "Email o contraseña incorrectos";
            }
        }
    } catch (Exception $e) {
        $error = "Error al iniciar sesión: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "includes/design-top.php"; ?>
    <?php include "includes/navigation.php"; ?>
    <!--Fase 2:no poner container-fluid y row en en mismo elemento-->
    <main class="container flex-grow-1 justify-content-center"">
        <div clase="row justify-content-center">
            <div class="col-md-12">

                <h1 class="text-center mt-5 mb-3 font-titulos">Inicio sesion</h1>

                <div class="col-md-6 mx-auto">
                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post">

                        <div class="mb-3">
                            <label for="email" class="form-label ">Email:</label>
                            <input type="email" class="form-control border-secondary" id="email" name="email" required
                                autocomplete="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                        </div>

                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña:</label>
                            <div class="input-group">
                                <input type="password" class="form-control border-secondary" id="contrasena" name="contrasena" required
                                    autocomplete="current-password">
                                <button class="btn btn-primary" type="submit" name="login" aria-label="Iniciar sesión"><i
                                        class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>

                        <div class="text-center mt-4 mb-4 d-flex justify-content-center flex-wrap gap-2">
                            <a href="registro.php" class="text-dark">No tienes
                                cuenta</a>
                            <span class="text-muted">|</span>
                            <a href="/forgot-password" class="text-dark">Has
                                olvidado la contraseña</a>
                        </div>

                        <div class="d-grid gap-3 mt-2">
                            <?php
                                echo $login_button;
                            ?>
                            <button type="button" class="btn btn-outline-secondary py-2 d-flex align-items-center justify-content-center">
                                <i class="fab fa-apple fa-lg me-2 text-dark"></i>
                                <p class="text-dark my-auto"> Autentificase con Apple</p>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php include "includes/footer.php"; ?>
</body>

</html>