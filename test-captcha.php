<?php
session_start();
require_once './includes/captcha.php';

$error = '';
$success = '';
$erroresValidacion = [];

// Procesar formulario
if (isset($_POST['probar'])) {
    $captchaUsuario = $_POST['captcha'] ?? '';
    
    // Debug info
    echo "<div class='alert alert-info'><strong>DEBUG:</strong><br>";
    echo "Entrada usuario: " . htmlspecialchars($captchaUsuario) . "<br>";
    echo "Respuesta esperada: " . ($_SESSION['captcha_respuesta'] ?? 'N/A') . "<br>";
    echo "is_numeric: " . (is_numeric(trim($captchaUsuario)) ? 'SI' : 'NO') . "<br>";
    echo "(int) entrada: " . (int)trim($captchaUsuario) . "<br>";
    echo "</div>";
    
    $resultadoCaptcha = validarCaptcha($captchaUsuario);
    
    if ($resultadoCaptcha['valido']) {
        $success = "¡Captcha correcto! ✅ " . $resultadoCaptcha['mensaje'];
        limpiarCaptcha(); // Limpiar después de validación exitosa
        // Generar uno nuevo se hace automáticamente en el siguiente render
    } else {
        $error = "❌ " . $resultadoCaptcha['mensaje'];
        $erroresValidacion[] = 'valCaptcha';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Captcha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">🧪 Prueba de Captcha</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success" role="alert">
                                <?= htmlspecialchars($success) ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <?php renderCaptcha($erroresValidacion, $_POST['captcha'] ?? ''); ?>
                            
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" name="probar" class="btn btn-primary btn-lg">
                                    Validar Captcha
                                </button>
                            </div>
                        </form>
                        
                        <hr class="my-4">
                        
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5>🔍 Debug Info:</h5>
                                <ul class="small mb-0">
                                    <li><strong>Pregunta:</strong> <?= $_SESSION['captcha_pregunta'] ?? 'No generada' ?></li>
                                    <li><strong>Respuesta esperada:</strong> <?= $_SESSION['captcha_respuesta'] ?? 'N/A' ?></li>
                                    <li><strong>Intentos:</strong> <?= $_SESSION['captcha_intentos'] ?? 0 ?></li>
                                    <li><strong>Timestamp:</strong> <?= $_SESSION['captcha_timestamp'] ?? 'N/A' ?></li>
                                    <li><strong>Hash generado:</strong> <?= isset($_SESSION['captcha_hash']) ? 'Sí' : 'No' ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
