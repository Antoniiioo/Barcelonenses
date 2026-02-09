<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug - Sesión</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #f5f5f5; }
        .debug-box { background: white; border: 2px solid #333; padding: 20px; margin: 10px 0; }
        .debug-box h2 { margin-top: 0; color: #0066cc; }
        .session-var { padding: 8px; margin: 5px 0; background: #e8f4f8; border-left: 3px solid #0066cc; }
        .image-test { margin: 20px 0; padding: 20px; background: #fff3cd; border: 2px solid #ffc107; }
        img { border: 3px solid #0066cc; margin: 10px; }
    </style>
</head>
<body>
    <h1>🔍 Debug de Sesión y Foto de Google</h1>
    
    <div class="debug-box">
        <h2>Variables de Sesión Completas</h2>
        <pre><?php print_r($_SESSION); ?></pre>
    </div>

    <div class="debug-box">
        <h2>Información de Usuario</h2>
        <?php if(isset($_SESSION['id_usuario'])): ?>
            <div class="session-var"><strong>ID Usuario:</strong> <?= $_SESSION['id_usuario'] ?></div>
            <div class="session-var"><strong>Email:</strong> <?= $_SESSION['email'] ?? 'No definido' ?></div>
            <div class="session-var"><strong>Nombre:</strong> <?= $_SESSION['nombre'] ?? 'No definido' ?></div>
            <div class="session-var"><strong>Tipo Usuario:</strong> <?= $_SESSION['id_tipo_usuario'] ?? 'No definido' ?></div>
        <?php else: ?>
            <p style="color: red;">❌ No hay usuario logueado</p>
        <?php endif; ?>
    </div>

    <div class="debug-box">
        <h2>Información de Google</h2>
        <?php if(isset($_SESSION['user_image'])): ?>
            <div class="session-var"><strong>URL de Imagen:</strong> <?= htmlspecialchars($_SESSION['user_image']) ?></div>
        <?php else: ?>
            <p style="color: red;">❌ $_SESSION['user_image'] no está definida</p>
        <?php endif; ?>

        <?php if(isset($_SESSION['user_first_name'])): ?>
            <div class="session-var"><strong>Nombre (Google):</strong> <?= $_SESSION['user_first_name'] ?></div>
        <?php endif; ?>

        <?php if(isset($_SESSION['user_last_name'])): ?>
            <div class="session-var"><strong>Apellido (Google):</strong> <?= $_SESSION['user_last_name'] ?></div>
        <?php endif; ?>

        <?php if(isset($_SESSION['user_email_address'])): ?>
            <div class="session-var"><strong>Email (Google):</strong> <?= $_SESSION['user_email_address'] ?></div>
        <?php endif; ?>
    </div>

    <?php if(isset($_SESSION['user_image'])): ?>
    <div class="image-test">
        <h2>🖼️ Test de Carga de Imagen</h2>
        <p><strong>Intentando cargar imagen de Google...</strong></p>
        
        <div style="background: white; padding: 20px; margin: 10px 0;">
            <h3>Imagen pequeña (32x32 - header)</h3>
            <img src="<?= htmlspecialchars($_SESSION['user_image']) ?>" 
                 alt="Preview pequeño" 
                 class="rounded-circle"
                 style="width: 32px; height: 32px; object-fit: cover;"
                 onload="document.getElementById('status-small').innerHTML='✅ Cargada correctamente';"
                 onerror="document.getElementById('status-small').innerHTML='❌ Error al cargar. Verifica la URL.';">
            <span id="status-small" style="margin-left: 10px;">⏳ Cargando...</span>
        </div>

        <div style="background: white; padding: 20px; margin: 10px 0;">
            <h3>Imagen grande (120x120 - perfil)</h3>
            <img src="<?= htmlspecialchars($_SESSION['user_image']) ?>" 
                 alt="Preview grande" 
                 class="rounded-circle"
                 style="width: 120px; height: 120px; object-fit: cover;"
                 onload="document.getElementById('status-large').innerHTML='✅ Cargada correctamente';"
                 onerror="document.getElementById('status-large').innerHTML='❌ Error al cargar. Verifica la URL.';">
            <span id="status-large" style="margin-left: 10px;">⏳ Cargando...</span>
        </div>

        <div style="background: white; padding: 20px; margin: 10px 0;">
            <h3>Imagen original (sin redimensionar)</h3>
            <img src="<?= htmlspecialchars($_SESSION['user_image']) ?>" 
                 alt="Preview original"
                 onload="document.getElementById('status-original').innerHTML='✅ Cargada correctamente';"
                 onerror="document.getElementById('status-original').innerHTML='❌ Error al cargar';">
            <br>
            <span id="status-original">⏳ Cargando...</span>
        </div>
    </div>
    <?php endif; ?>

    <div class="debug-box">
        <h2>🔗 Enlaces Útiles</h2>
        <p><a href="index.php">← Volver al inicio</a></p>
        <p><a href="perfil.php">Ver perfil</a></p>
        <p><a href="salir.php">Cerrar sesión</a></p>
    </div>

    <div class="debug-box">
        <h2>💡 Instrucciones</h2>
        <ol>
            <li>Si la imagen de Google <strong>NO</strong> se carga aquí, el problema es con la URL de Google (puede estar bloqueada, expirada o el usuario no tiene foto)</li>
            <li>Si la imagen <strong>SÍ</strong> se carga aquí pero no en tu página, hay un problema en el código de tu página</li>
            <li>Verifica que <code>$_SESSION['user_image']</code> esté definida arriba</li>
        </ol>
    </div>
</body>
</html>
