<?php
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

require_once './controlador/ControladorUsuario.php';
require_once './controlador/ControladorDireccion.php';
require_once './controlador/Conexion.php';

$idUsuario = $_SESSION['id_usuario'];
$mensaje = '';

// ========== PROCESAR ACTUALIZACIÓN DE PERFIL ==========

// --- ACTUALIZAR DATOS PERSONALES ---
if (isset($_POST['btn_actualizar_perfil'])) {
    $nombre = trim($_POST['nombre']);
    $apellido1 = trim($_POST['apellido1']);
    $apellido2 = trim($_POST['apellido2']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $fechaNac = $_POST['fecha_nac'];

    if (empty($nombre) || empty($apellido1) || empty($email) || empty($telefono) || empty($fechaNac)) {
        $mensaje = '<i class="bi bi-exclamation-triangle-fill text-warning"></i> Todos los campos obligatorios deben estar completos';
    } else {
        try {
            $resultado = ControladorUsuario::actualizarPerfilUsuario(
                $idUsuario,
                $nombre,
                $apellido1,
                $apellido2,
                $email,
                $telefono,
                $fechaNac
            );
            $mensaje = $resultado ? '<i class="bi bi-check-circle-fill text-success"></i> Perfil actualizado correctamente' : '<i class="bi bi-x-circle-fill text-danger"></i> Error al actualizar el perfil';
        } catch (Exception $e) {
            $mensaje = '<i class="bi bi-x-circle-fill text-danger"></i> Error: ' . $e->getMessage();
        }
    }

    $_SESSION['mensaje_perfil'] = $mensaje;
    header("Location: perfil.php");
    exit;
}

// --- CAMBIAR CONTRASEÑA ---
if (isset($_POST['btn_cambiar_contrasena'])) {
    $passActual = $_POST['pass_actual'];
    $passNueva = $_POST['pass_nueva'];
    $passConfirmar = $_POST['pass_confirmar'];

    if ($passNueva !== $passConfirmar) {
        $mensaje = '<i class="bi bi-x-circle-fill text-danger"></i> Las contraseñas nuevas no coinciden';
    } elseif (strlen($passNueva) < 8) {
        $mensaje = '<i class="bi bi-x-circle-fill text-danger"></i> La contraseña debe tener al menos 8 caracteres';
    } else {
        try {
            // Verificar contraseña actual
            if (!ControladorUsuario::verificarContrasena($idUsuario, $passActual)) {
                $mensaje = '<i class="bi bi-x-circle-fill text-danger"></i> La contraseña actual es incorrecta';
            } else {
                $resultado = ControladorUsuario::cambiarContrasena($idUsuario, $passNueva);
                $mensaje = $resultado ? '<i class="bi bi-check-circle-fill text-success"></i> Contraseña actualizada correctamente' : '<i class="bi bi-x-circle-fill text-danger"></i> Error al actualizar la contraseña';
            }
        } catch (Exception $e) {
            $mensaje = '<i class="bi bi-x-circle-fill text-danger"></i> Error: ' . $e->getMessage();
        }
    }

    $_SESSION['mensaje_perfil'] = $mensaje;
    header("Location: perfil.php");
    exit;
}

// --- ACTUALIZAR/CREAR DIRECCIÓN ---
if (isset($_POST['btn_actualizar_direccion'])) {
    $calle = trim($_POST['calle']);
    $numCalle = trim($_POST['num_calle']);
    $codPostal = trim($_POST['cod_postal']);
    $localidad = trim($_POST['localidad']);
    $pais = trim($_POST['pais']);

    if (empty($calle) || empty($numCalle) || empty($codPostal) || empty($localidad) || empty($pais)) {
        $mensaje = '<i class="bi bi-exclamation-triangle-fill text-warning"></i> Todos los campos de dirección son obligatorios';
    } else {
        try {
            // Verificar si el usuario ya tiene una dirección
            $pdo = new Conexion();
            $stmt = $pdo->prepare("SELECT id_direccion FROM usuario WHERE id_usuario = :id_usuario");
            $stmt->execute([':id_usuario' => $idUsuario]);
            $usuarioCheck = $stmt->fetch(PDO::FETCH_OBJ);

            if ($usuarioCheck && $usuarioCheck->id_direccion) {
                // Actualizar dirección existente
                $resultado = ControladorDireccion::actualizarDireccionPorId(
                    $usuarioCheck->id_direccion,
                    $calle,
                    $numCalle,
                    $codPostal,
                    $localidad,
                    $pais
                );
                $mensaje = $resultado ? '<i class="bi bi-check-circle-fill text-success"></i> Dirección actualizada correctamente' : '<i class="bi bi-x-circle-fill text-danger"></i> Error al actualizar la dirección';
            } else {
                // Crear nueva dirección
                $resultado = ControladorDireccion::crearDireccionYAsociarUsuario(
                    $idUsuario,
                    $calle,
                    $numCalle,
                    $codPostal,
                    $localidad,
                    $pais
                );
                $mensaje = $resultado ? '<i class="bi bi-check-circle-fill text-success"></i> Dirección creada correctamente' : '<i class="bi bi-x-circle-fill text-danger"></i> Error al crear la dirección';
            }
        } catch (Exception $e) {
            $mensaje = '<i class="bi bi-x-circle-fill text-danger"></i> Error: ' . $e->getMessage();
        }
    }

    $_SESSION['mensaje_perfil'] = $mensaje;
    header("Location: perfil.php");
    exit;
}

// Recuperar mensaje de sesión
if (isset($_SESSION['mensaje_perfil'])) {
    $mensaje = $_SESSION['mensaje_perfil'];
    unset($_SESSION['mensaje_perfil']);
}

// ========== OBTENER DATOS DEL USUARIO ==========
include "includes/a_config.php";

$controladorUsuario = new ControladorUsuario();
$usuario = $controladorUsuario->obtenerUsuarioPorId($idUsuario);

// Obtener dirección del usuario si tiene
$direccion = null;
if ($usuario && isset($usuario->id_direccion)) {
    $controladorDireccion = new ControladorDireccion();
    $direccion = $controladorDireccion->obtenerDireccionPorId($usuario->id_direccion);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "includes/design-top.php"; ?>
    <?php include "includes/navigation.php"; ?>

    <main class="flex-grow-1 py-5">
        <div class="container">
            <?php if ($mensaje): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= $mensaje ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($usuario): ?>
                <div class="row">
                    <!-- Información Personal -->
                    <div class="col-lg-4 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <div class="mb-4">
                                    <?php if(isset($_SESSION['user_image'])): ?>
                                        <!-- Foto de perfil de Google -->
                                        <img src="<?= htmlspecialchars($_SESSION['user_image']) ?>" 
                                             alt="" 
                                             class="rounded-circle" 
                                             id="profileImage"
                                             referrerpolicy="no-referrer"
                                             crossorigin="anonymous"
                                             style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #0d6efd;"
                                             onerror="this.style.display='none'; document.getElementById('profileIconFallback').style.display='inline-flex';">
                                        <div id="profileIconFallback" class="rounded-circle bg-primary text-white align-items-center justify-content-center"
                                             style="width: 120px; height: 120px; font-size: 3rem; display: none !important;">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                    <?php else: ?>
                                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                                             style="width: 120px; height: 120px; font-size: 3rem;">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <h4 class="card-title mb-1">
                                    <?= $usuario->nombre ?> <?= $usuario->apellido1 ?> <?= $usuario->apellido2 ?? '' ?>
                                </h4>
                                <p class="text-muted mb-3">
                                    <i class="bi bi-envelope me-2"></i><?= $usuario->email ?>
                                </p>
                                <span class="badge bg-primary mb-3">
                                    <i class="bi bi-shield-check me-1"></i>
                                    <?= ucfirst($usuario->tipo_usuario ?? 'Usuario') ?>
                                </span>
                                <hr>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditarPerfil">
                                        <i class="bi bi-pencil-square me-2"></i>Editar Perfil
                                    </button>
                                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalCambiarContrasena">
                                        <i class="bi bi-key me-2"></i>Cambiar Contraseña
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles del Usuario -->
                    <div class="col-lg-8 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-person-badge me-2"></i>Información Personal
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-4 fw-bold">
                                        <i class="bi bi-person me-2 text-primary"></i>Nombre:
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $usuario->nombre ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-4 fw-bold">
                                        <i class="bi bi-person me-2 text-primary"></i>Primer Apellido:
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $usuario->apellido1 ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-4 fw-bold">
                                        <i class="bi bi-person me-2 text-primary"></i>Segundo Apellido:
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $usuario->apellido2 ?? 'No especificado' ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-4 fw-bold">
                                        <i class="bi bi-envelope me-2 text-primary"></i>Email:
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $usuario->email ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-4 fw-bold">
                                        <i class="bi bi-telephone me-2 text-primary"></i>Teléfono:
                                    </div>
                                    <div class="col-sm-8">
                                        <?= ($usuario->telefono && $usuario->telefono != '0') ? $usuario->telefono : 'No especificado' ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-sm-4 fw-bold">
                                        <i class="bi bi-calendar me-2 text-primary"></i>Fecha de Nacimiento:
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $usuario->fecha_nac ? date('d/m/Y', strtotime($usuario->fecha_nac)) : 'No especificada' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-geo-alt me-2"></i>Dirección
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if ($direccion): ?>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-house-door text-success me-3 fs-4"></i>
                                                <div>
                                                    <small class="text-muted d-block">Calle y Número</small>
                                                    <strong><?= $direccion->calle ?>, <?= $direccion->num_calle ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-mailbox text-success me-3 fs-4"></i>
                                                <div>
                                                    <small class="text-muted d-block">Código Postal</small>
                                                    <strong><?= $direccion->cod_postal ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-pin-map text-success me-3 fs-4"></i>
                                                <div>
                                                    <small class="text-muted d-block">Localidad</small>
                                                    <strong><?= $direccion->localidad ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-globe text-success me-3 fs-4"></i>
                                                <div>
                                                    <small class="text-muted d-block">País</small>
                                                    <strong><?= $direccion->pais ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end mt-3">
                                        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalEditarDireccion">
                                            <i class="bi bi-pencil me-2"></i>Editar Dirección
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center py-5">
                                        <i class="bi bi-house-x text-muted fs-1 d-block mb-3"></i>
                                        <p class="text-muted mb-3">No tienes dirección registrada</p>
                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalEditarDireccion">
                                            <i class="bi bi-plus-circle me-2"></i>Agregar Dirección
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <div class="alert alert-danger text-center">
                    <i class="bi bi-exclamation-triangle fs-1 d-block mb-3"></i>
                    <h4>Error al cargar el perfil</h4>
                    <p>No se pudo encontrar la información del usuario.</p>
                    <a href="index.php" class="btn btn-primary">Volver al inicio</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Modal Editar Perfil -->
    <div class="modal fade" id="modalEditarPerfil" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i>Editar Perfil
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="perfil.php">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label fw-bold">Nombre *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                   value="<?= $usuario->nombre ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido1" class="form-label fw-bold">Primer Apellido *</label>
                            <input type="text" class="form-control" id="apellido1" name="apellido1"
                                   value="<?= $usuario->apellido1 ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido2" class="form-label fw-bold">Segundo Apellido</label>
                            <input type="text" class="form-control" id="apellido2" name="apellido2"
                                   value="<?= $usuario->apellido2 ?? '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email *</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="<?= $usuario->email ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label fw-bold">Teléfono *</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono"
                                   value="<?= $usuario->telefono ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_nac" class="form-label fw-bold">Fecha de Nacimiento *</label>
                            <input type="date" class="form-control" id="fecha_nac" name="fecha_nac"
                                   value="<?= $usuario->fecha_nac ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn_actualizar_perfil" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Cambiar Contraseña -->
    <div class="modal fade" id="modalCambiarContrasena" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-key me-2"></i>Cambiar Contraseña
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="perfil.php" id="formCambiarPass">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="pass_actual" class="form-label fw-bold">Contraseña Actual *</label>
                            <input type="password" class="form-control" id="pass_actual" name="pass_actual" required>
                        </div>
                        <div class="mb-3">
                            <label for="pass_nueva" class="form-label fw-bold">Nueva Contraseña *</label>
                            <input type="password" class="form-control" id="pass_nueva" name="pass_nueva"
                                   minlength="8" required>
                            <small class="text-muted">Mínimo 8 caracteres</small>
                        </div>
                        <div class="mb-3">
                            <label for="pass_confirmar" class="form-label fw-bold">Confirmar Nueva Contraseña *</label>
                            <input type="password" class="form-control" id="pass_confirmar" name="pass_confirmar"
                                   minlength="8" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn_cambiar_contrasena" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Cambiar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Dirección -->
    <div class="modal fade" id="modalEditarDireccion" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-geo-alt me-2"></i><?= $direccion ? 'Editar' : 'Agregar' ?> Dirección
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="perfil.php">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="calle" class="form-label fw-bold">Calle *</label>
                            <input type="text" class="form-control" id="calle" name="calle"
                                   value="<?= $direccion->calle ?? '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="num_calle" class="form-label fw-bold">Número *</label>
                            <input type="text" class="form-control" id="num_calle" name="num_calle"
                                   value="<?= $direccion->num_calle ?? '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="cod_postal" class="form-label fw-bold">Código Postal *</label>
                            <input type="text" class="form-control" id="cod_postal" name="cod_postal"
                                   value="<?= $direccion->cod_postal ?? '' ?>" maxlength="5" required>
                        </div>
                        <div class="mb-3">
                            <label for="localidad" class="form-label fw-bold">Localidad *</label>
                            <input type="text" class="form-control" id="localidad" name="localidad"
                                   value="<?= $direccion->localidad ?? '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="pais" class="form-label fw-bold">País *</label>
                            <input type="text" class="form-control" id="pais" name="pais"
                                   value="<?= $direccion->pais ?? 'España' ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn_actualizar_direccion" class="btn btn-success">
                            <i class="bi bi-save me-2"></i>Guardar Dirección
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>

    <script>
        // Validación de contraseñas
        document.getElementById('formCambiarPass').addEventListener('submit', function(e) {
            const nueva = document.getElementById('pass_nueva').value;
            const confirmar = document.getElementById('pass_confirmar').value;

            if (nueva !== confirmar) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                return false;
            }

            if (nueva.length < 8) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 8 caracteres');
                return false;
            }
        });
    </script>
</body>

</html>
