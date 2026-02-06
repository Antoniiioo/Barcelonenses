<?php
/**
 * Sistema de Captcha Avanzado
 * Genera preguntas aleatorias variadas para validación anti-bot
 * Incluye operaciones matemáticas complejas y preguntas de lógica
 */

// Inicializar contador de intentos si no existe
if (!isset($_SESSION['captcha_intentos'])) {
    $_SESSION['captcha_intentos'] = 0;
}

// Generar nuevo captcha
if (!isset($_SESSION['captcha_generado']) || isset($_POST['registrar']) || isset($_POST['regenerar_captcha'])) {
    generarNuevoCaptcha();
}

/**
 * Genera un nuevo captcha con pregunta y respuesta
 */
function generarNuevoCaptcha() {
    $tipoPregunta = rand(1, 5);
    
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
    
    // Verificar expiración (10 minutos)
    if (isset($_SESSION['captcha_timestamp'])) {
        $tiempoTranscurrido = time() - $_SESSION['captcha_timestamp'];
        if ($tiempoTranscurrido > 600) { // 10 minutos
            limpiarCaptcha();
            return ['valido' => false, 'mensaje' => 'Captcha expirado. Genera uno nuevo'];
        }
    }
    
    // Verificar intentos máximos
    if ($_SESSION['captcha_intentos'] >= 5) {
        return ['valido' => false, 'mensaje' => 'Demasiados intentos fallidos. Recarga la página'];
    }
    
    // Validar el hash
    $hashEsperado = hash('sha256', $_SESSION['captcha_respuesta'] . session_id());
    if ($hashEsperado !== $_SESSION['captcha_hash']) {
        return ['valido' => false, 'mensaje' => 'Error de validación. Intenta de nuevo'];
    }
    
    // Validar respuesta
    $respuestaUsuario = trim($respuestaUsuario);
    $captchaCorrecto = $_SESSION['captcha_respuesta'];
    
    if ($respuestaUsuario == $captchaCorrecto) {
        // Respuesta correcta
        $_SESSION['captcha_intentos'] = 0;
        return ['valido' => true, 'mensaje' => 'Captcha válido'];
    } else {
        // Respuesta incorrecta
        $_SESSION['captcha_intentos']++;
        return ['valido' => false, 'mensaje' => 'Respuesta incorrecta. Intenta de nuevo'];
    }
}

/**
 * Limpia el captcha de la sesión
 */
function limpiarCaptcha() {
    unset(
        $_SESSION['captcha_generado'], 
        $_SESSION['captcha_pregunta'], 
        $_SESSION['captcha_respuesta'],
        $_SESSION['captcha_hash'],
        $_SESSION['captcha_timestamp'],
        $_SESSION['captcha_texto'],
        $_SESSION['captcha_intentos']
    );
}

/**
 * Renderiza el campo de captcha para el formulario
 * @param array $erroresValidacion - Array de errores de validación
 * @param string $valorActual - Valor actual del campo (para mantener tras error)
 */
function renderCaptcha($erroresValidacion = [], $valorActual = '') {
    $pregunta = $_SESSION['captcha_pregunta'] ?? '0 + 0';
    $texto = $_SESSION['captcha_texto'] ?? '¿Cuánto es';
    $tieneError = in_array('valCaptcha', $erroresValidacion);
    $intentos = $_SESSION['captcha_intentos'] ?? 0;
    
    // Calcular tiempo restante
    $tiempoRestante = 600; // 10 minutos por defecto
    if (isset($_SESSION['captcha_timestamp'])) {
        $tiempoRestante = 600 - (time() - $_SESSION['captcha_timestamp']);
    }
    ?>
    <div class="row mb-3 justify-content-center">
        <label for="captcha" class="col-sm-4 col-form-label text-sm-start">
            Verificación Anti-Bot *
        </label>
        <div class="col-sm-7">
            <div class="card border-primary mb-2">
                <div class="card-body bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted">
                            <i class="bi bi-shield-check"></i> Seguridad
                        </small>
                        <?php if ($tiempoRestante > 0): ?>
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> <?= gmdate("i:s", $tiempoRestante) ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    <p class="mb-0 fw-bold text-primary">
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
                   placeholder="Escribe tu respuesta aquí"
                   value="<?= htmlspecialchars($valorActual) ?>"
                   autocomplete="off">
            
            <?php if ($tieneError): ?>
                <div class="invalid-feedback">
                    <?= $intentos > 0 ? "Intento $intentos/5 - " : "" ?>Respuesta incorrecta
                </div>
            <?php endif; ?>
            
            <small class="text-muted d-block mt-1">
                <i class="bi bi-info-circle"></i> Resuelve la operación para continuar
            </small>
        </div>
    </div>
    <?php
}
?>
