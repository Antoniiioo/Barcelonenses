<?php
session_start();

// Si hay sesión de Google, revocar el token
if (isset($_SESSION['access_token'])) {
    require_once 'includes/a_config.php';
    
    try {
        // Revocar el token de acceso de Google
        $google_client->revokeToken($_SESSION['access_token']);
    } catch (Exception $e) {
        // Si falla la revocación, continuar con el logout local
    }
}

// Eliminar todas las variables de sesión
session_unset();

// Si se desea destruir la sesión completamente, borrar también la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruir la sesión
session_destroy();

// Redirigir al inicio
header("Location: index.php");
exit();
?>