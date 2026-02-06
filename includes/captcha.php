<?php
/**
 * Sistema de Captcha Avanzado
 * 
 * Genera preguntas aleatorias variadas para validación anti-bot.
 * Incluye operaciones matemáticas complejas y preguntas de lógica.
 * 
 * @package Barcelonenses
 * @subpackage Seguridad
 * @version 2.0
 */

// Constantes de configuración
if (!defined('CAPTCHA_MAX_INTENTOS')) {
    define('CAPTCHA_MAX_INTENTOS', 5);
}
if (!defined('CAPTCHA_TIEMPO_EXPIRACION')) {
    define('CAPTCHA_TIEMPO_EXPIRACION', 600); // 10 minutos
}
if (!defined('CAPTCHA_TIPOS_PREGUNTA')) {
    define('CAPTCHA_TIPOS_PREGUNTA', 5);
}

// Inicializar contador de intentos si no existe
if (!isset($_SESSION['captcha_intentos'])) {
    $_SESSION['captcha_intentos'] = 0;
}

// Verificar si el captcha ha expirado
if (isset($_SESSION['captcha_timestamp'])) {
    $tiempoTranscurrido = time() - $_SESSION['captcha_timestamp'];
    if ($tiempoTranscurrido > CAPTCHA_TIEMPO_EXPIRACION) {
        limpiarCaptchaInterno();
    }
}

// Generar nuevo captcha solo si no existe (no en POST para evitar regeneración)
if (!isset($_SESSION['captcha_generado']) && !$_POST) {
    generarNuevoCaptcha();
}

/**
 * Genera un nuevo captcha con pregunta y respuesta.
 * 
 * Crea diferentes tipos de preguntas (matemáticas, lógica, secuencias)
 * y almacena la respuesta hasheada en sesión para validación posterior.
 * 
 * @return void
 */
function generarNuevoCaptcha() {
    $tipoPregunta = rand(1, CAPTCHA_TIPOS_PREGUNTA);
    
    switch($tipoPregunta) {
        case 1: // Operación matemática compleja
            $num1 = rand(5, 20);
            $num2 = rand(2, 10);
            $num3 = rand(1, 5);
            $operaciones = [
                ['pregunta' => "($num1 + $num2) × $num3", 'respuesta' => ($num1 + $num2) * $num3],
                ['pregunta' => "($num1 - $num2) × $num3", 'respuesta' => ($num1 - $num2) * $num3],
                ['pregunta' => "$num1 + $num2 - $num3", 'respuesta' => $num1 + $num2 - $num3],
                ['pregunta' => "$num1 × $num2 - $num3", 'respuesta' => $num1 * $num2 - $num3]
            ];
            $op = $operaciones[array_rand($operaciones)];
            $_SESSION['captcha_pregunta'] = $op['pregunta'];
            $_SESSION['captcha_respuesta'] = $op['respuesta'];
            break;
            
        case 2: // Secuencia numérica
            $inicio = rand(2, 10);
            $incremento = rand(2, 5);
            $secuencia = [$inicio, $inicio + $incremento, $inicio + ($incremento * 2)];
            $respuesta = $inicio + ($incremento * 3);
            $_SESSION['captcha_pregunta'] = implode(', ', $secuencia) . ', ?';
            $_SESSION['captcha_respuesta'] = $respuesta;
            $_SESSION['captcha_texto'] = 'Continúa la secuencia';
            break;
            
        case 3: // Problema de lógica simple
            $opciones = [
                ['pregunta' => 'días que tiene una semana', 'respuesta' => 7],
                ['pregunta' => 'meses que tiene un año', 'respuesta' => 12],
                ['pregunta' => 'horas que tiene un día', 'respuesta' => 24],
                ['pregunta' => 'minutos que tiene una hora', 'respuesta' => 60],
                ['pregunta' => 'lados que tiene un triángulo', 'respuesta' => 3],
                ['pregunta' => 'lados que tiene un cuadrado', 'respuesta' => 4],
                ['pregunta' => 'lados que tiene un hexágono', 'respuesta' => 6]
            ];
            $logica = $opciones[array_rand($opciones)];
            $_SESSION['captcha_pregunta'] = $logica['pregunta'];
            $_SESSION['captcha_respuesta'] = $logica['respuesta'];
            $_SESSION['captcha_texto'] = '¿Cuántos';
            break;
            
        case 4: // Operación con texto
            $numeros_texto = [
                1 => 'uno', 2 => 'dos', 3 => 'tres', 4 => 'cuatro', 5 => 'cinco',
                6 => 'seis', 7 => 'siete', 8 => 'ocho', 9 => 'nueve', 10 => 'diez'
            ];
            $num1 = rand(1, 10);
            $num2 = rand(1, 5);
            $operaciones_texto = [
                ['texto' => 'más', 'op' => '+', 'resultado' => $num1 + $num2],
                ['texto' => 'menos', 'op' => '-', 'resultado' => $num1 - $num2],
                ['texto' => 'por', 'op' => '×', 'resultado' => $num1 * $num2]
            ];
            $op_texto = $operaciones_texto[array_rand($operaciones_texto)];
            $_SESSION['captcha_pregunta'] = $numeros_texto[$num1] . ' ' . $op_texto['texto'] . ' ' . $numeros_texto[$num2];
            $_SESSION['captcha_respuesta'] = $op_texto['resultado'];
            $_SESSION['captcha_texto'] = '¿Cuánto es';
            break;
            
        case 5: // División exacta
            $divisor = rand(2, 10);
            $multiplicador = rand(2, 15);
            $dividendo = $divisor * $multiplicador;
            $_SESSION['captcha_pregunta'] = "$dividendo ÷ $divisor";
            $_SESSION['captcha_respuesta'] = $multiplicador;
            $_SESSION['captcha_texto'] = '¿Cuánto es';
            break;
    }
    
    // Encriptar la respuesta para mayor seguridad
    $_SESSION['captcha_hash'] = hash('sha256', $_SESSION['captcha_respuesta'] . session_id());
    $_SESSION['captcha_timestamp'] = time();
    $_SESSION['captcha_generado'] = true;
}

/**
 * Valida la respuesta del captcha con verificaciones de seguridad
 * @param string $respuestaUsuario - Respuesta ingresada por el usuario
 * @return array ['valido' => bool, 'mensaje' => string]
 */
function validarCaptcha($respuestaUsuario) {
    // Verificar que existe una respuesta esperada
    if (!isset($_SESSION['captcha_respuesta']) || !isset($_SESSION['captcha_hash'])) {
        return ['valido' => false, 'mensaje' => 'Captcha no generado correctamente'];
    }
    
    // Verificar expiración
    if (isset($_SESSION['captcha_timestamp'])) {
        $tiempoTranscurrido = time() - $_SESSION['captcha_timestamp'];
        if ($tiempoTranscurrido > CAPTCHA_TIEMPO_EXPIRACION) {
            limpiarCaptchaInterno();
            return ['valido' => false, 'mensaje' => 'Captcha expirado. Recarga la página'];
        }
    }
    
    // Verificar intentos máximos
    if ($_SESSION['captcha_intentos'] >= CAPTCHA_MAX_INTENTOS) {
        return ['valido' => false, 'mensaje' => 'Demasiados intentos fallidos. Recarga la página'];
    }
    
    // Validar el hash (usar hash_equals para prevenir timing attacks)
    $hashEsperado = hash('sha256', $_SESSION['captcha_respuesta'] . session_id());
    if (!hash_equals($hashEsperado, $_SESSION['captcha_hash'])) {
        return ['valido' => false, 'mensaje' => 'Error de validación. Intenta de nuevo'];
    }
    
    // Validar respuesta (sanitizar entrada)
    $respuestaUsuario = trim($respuestaUsuario);
    
    // Verificar que sea un número válido (permitir negativos)
    if (!is_numeric($respuestaUsuario)) {
        $_SESSION['captcha_intentos']++;
        return ['valido' => false, 'mensaje' => 'Por favor, introduce solo números'];
    }
    
    $respuestaUsuario = (int)$respuestaUsuario;
    $captchaCorrecto = (int)$_SESSION['captcha_respuesta'];
    
    // Comparación segura
    if ($respuestaUsuario === $captchaCorrecto) {
        // Respuesta correcta - marcar como validado pero no limpiar aún
        $_SESSION['captcha_validado'] = true;
        $_SESSION['captcha_intentos'] = 0;
        return ['valido' => true, 'mensaje' => 'Captcha válido'];
    } else {
        // Respuesta incorrecta
        $_SESSION['captcha_intentos']++;
        $intentosRestantes = CAPTCHA_MAX_INTENTOS - $_SESSION['captcha_intentos'];
        $mensaje = $intentosRestantes > 0 
            ? "Respuesta incorrecta. Te quedan $intentosRestantes intentos" 
            : 'Respuesta incorrecta. Recarga la página';
        return ['valido' => false, 'mensaje' => $mensaje];
    }
}

/**
 * Limpia el captcha de la sesión (uso interno)
 */
function limpiarCaptchaInterno() {
    unset(
        $_SESSION['captcha_generado'], 
        $_SESSION['captcha_pregunta'], 
        $_SESSION['captcha_respuesta'],
        $_SESSION['captcha_hash'],
        $_SESSION['captcha_timestamp'],
        $_SESSION['captcha_texto']
    );
    $_SESSION['captcha_intentos'] = 0;
}

/**
 * Limpia el captcha de la sesión (uso externo - post validación)
 */
function limpiarCaptcha() {
    limpiarCaptchaInterno();
}

/**
 * Renderiza el campo de captcha para el formulario.
 * 
 * Muestra la pregunta del captcha con contador de tiempo y de intentos.
 * Incluye mejoras de accesibilidad (ARIA labels, roles).
 * 
 * @param array $erroresValidacion Array de errores de validación
 * @param string $valorActual Valor actual del campo (para mantener tras error)
 * @return void
 */
function renderCaptcha($erroresValidacion = [], $valorActual = '') {
    // Validar que existe captcha generado
    if (!isset($_SESSION['captcha_pregunta'])) {
        generarNuevoCaptcha();
    }
    
    $pregunta = $_SESSION['captcha_pregunta'] ?? '0 + 0';
    $texto = $_SESSION['captcha_texto'] ?? '¿Cuánto es';
    $tieneError = in_array('valCaptcha', $erroresValidacion);
    $intentos = $_SESSION['captcha_intentos'] ?? 0;
    $intentosRestantes = CAPTCHA_MAX_INTENTOS - $intentos;
    
    // Calcular tiempo restante
    $tiempoRestante = CAPTCHA_TIEMPO_EXPIRACION;
    if (isset($_SESSION['captcha_timestamp'])) {
        $tiempoRestante = CAPTCHA_TIEMPO_EXPIRACION - (time() - $_SESSION['captcha_timestamp']);
        $tiempoRestante = max(0, $tiempoRestante); // Asegurar no negativo
    }
    ?>
    <div class="row mb-3 justify-content-center" role="group" aria-labelledby="captcha-label">
        <label for="captcha" id="captcha-label" class="col-sm-4 col-form-label text-sm-start">
            Verificación Anti-Bot *
        </label>
        <div class="col-sm-7">
            <div class="card border-primary mb-2" role="region" aria-label="Pregunta de seguridad">
                <div class="card-body bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted" aria-label="Verificación de seguridad">
                            <i class="bi bi-shield-check" aria-hidden="true"></i> Seguridad
                        </small>
                        <small class="text-muted" 
                               id="captcha-timer"
                               data-tiempo-inicial="<?= $tiempoRestante ?>"
                               aria-live="polite">
                            <i class="bi bi-clock" aria-hidden="true"></i> 
                            <span id="captcha-timer-display">
                                <?= $tiempoRestante > 0 ? gmdate("i:s", $tiempoRestante) : 'Expirado' ?>
                            </span>
                        </small>
                    </div>
                    <p class="mb-0 fw-bold text-primary" id="captcha-question">
                        <?= htmlspecialchars($texto) ?> 
                        <span class="fs-5 text-dark"><?= htmlspecialchars($pregunta) ?></span>
                    </p>
                </div>
            </div>
            
            <input type="number" 
                   class="form-control border-secondary <?= $tieneError ? 'is-invalid' : '' ?>" 
                   id="captcha" 
                   name="captcha" 
                   required 
                   aria-required="true"
                   aria-describedby="captcha-question captcha-help <?= $tieneError ? 'captcha-error' : '' ?>"
                   aria-invalid="<?= $tieneError ? 'true' : 'false' ?>"
                   placeholder="Escribe tu respuesta aquí"
                   value="<?= htmlspecialchars($valorActual) ?>"
                   autocomplete="off"
                   inputmode="numeric"
                   pattern="[0-9]*">
            
            <?php if ($tieneError): ?>
                <div id="captcha-error" class="invalid-feedback" role="alert">
                    <?php if ($intentos > 0): ?>
                        Intento <?= $intentos ?>/<?= CAPTCHA_MAX_INTENTOS ?> - 
                    <?php endif; ?>
                    Respuesta incorrecta.
                    <?php if ($intentosRestantes > 0): ?>
                        Te quedan <?= $intentosRestantes ?> <?= $intentosRestantes === 1 ? 'intento' : 'intentos' ?>.
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <small id="captcha-help" class="text-muted d-block mt-1">
                <i class="bi bi-info-circle" aria-hidden="true"></i> 
                Resuelve la operación para continuar
                <span id="captcha-tiempo-alerta"></span>
            </small>
            
            <div id="captcha-expirado-container" style="display: none;" class="mt-2">
                <button type="button" class="btn btn-warning btn-sm w-100" onclick="location.reload()">
                    <i class="bi bi-arrow-clockwise"></i> Captcha expirado - Click para recargar
                </button>
            </div>
        </div>
    </div>
    
    <script>
    (function() {
        const timerElement = document.getElementById('captcha-timer');
        const timerDisplay = document.getElementById('captcha-timer-display');
        const alertaElement = document.getElementById('captcha-tiempo-alerta');
        const expiradoContainer = document.getElementById('captcha-expirado-container');
        const captchaInput = document.getElementById('captcha');
        
        if (!timerElement || !timerDisplay) return;
        
        let tiempoRestante = parseInt(timerElement.dataset.tiempoInicial) || 0;
        
        function actualizarTemporizador() {
            if (tiempoRestante <= 0) {
                timerElement.className = 'text-danger fw-bold';
                timerDisplay.innerHTML = '<strong>Expirado</strong>';
                timerElement.setAttribute('role', 'alert');
                alertaElement.innerHTML = '<span class="text-danger fw-bold"> - ¡Captcha expirado!</span>';
                
                // Mostrar botón de recarga y deshabilitar input
                if (expiradoContainer) expiradoContainer.style.display = 'block';
                if (captchaInput) captchaInput.disabled = true;
                return;
            }
            
            const minutos = Math.floor(tiempoRestante / 60);
            const segundos = tiempoRestante % 60;
            const textoTiempo = String(minutos).padStart(2, '0') + ':' + String(segundos).padStart(2, '0');
            
            timerDisplay.textContent = textoTiempo;
            timerElement.setAttribute('aria-label', `Tiempo restante: ${minutos} minutos ${segundos} segundos`);
            
            // Alerta cuando quede poco tiempo
            if (tiempoRestante <= 60 && tiempoRestante > 30) {
                timerElement.className = 'text-warning fw-bold';
                alertaElement.innerHTML = '<span class="text-warning"> - ¡Poco tiempo restante!</span>';
            } else if (tiempoRestante <= 30) {
                timerElement.className = 'text-danger fw-bold';
                alertaElement.innerHTML = '<span class="text-danger"> - ¡Muy poco tiempo!</span>';
            }
            
            tiempoRestante--;
            setTimeout(actualizarTemporizador, 1000);
        }
        
        // Iniciar el temporizador
        if (tiempoRestante > 0) {
            setTimeout(actualizarTemporizador, 1000);
        } else {
            actualizarTemporizador();
        }
    })();
    </script>
    <?php
}
?>
