<?php
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_tipo_usuario'] != 1) {
    header("Location: login.php");
    exit;
}


require_once './controlador/ControladorUsuario.php';
require_once './controlador/ControladorTipoUsuario.php';
require_once './controlador/ControladorDireccion.php';

$error = [];
$msg ='';

// Manejar actualización de usuario
if(isset($_POST['actualizar'])) {
    try {
        if(ControladorUsuario::actualizarUsuario(
            $_POST['id_usuario'],
            $_POST['nombre'],
            $_POST['apellido1'],
            $_POST['apellido2'],
            $_POST['email'],
            $_POST['telefono'],
            $_POST['fechaNac'],
            $_POST['idTipoUsuario']
        )) {
            $msg = "Usuario actualizado con éxito.";
        } else {
            $msg = "Error al actualizar el usuario.";
        }
    } catch (Exception $e) {
        $msg = "Error: " . $e->getMessage();
    }
}

// Manejar eliminación de usuario
if(isset($_POST['eliminar'])) {
    try {
        if(ControladorUsuario::eliminarUsuario($_POST['id_usuario'])) {
            $msg = "Usuario eliminado con éxito.";
        } else {
            $msg = "Error al eliminar el usuario.";
        }
    } catch (Exception $e) {
        $msg = "Error: " . $e->getMessage();
    }
}

// Manejar creación de usuario
if(isset($_POST['guardar'])) {
     $error = ControladorUsuario::validarDatos(
        $_POST['nombre'],
        $_POST['apellido1'],
        $_POST['email'],
        $_POST['telefono'],
        $_POST['contrasena'],
        $_POST['confirmar_contrasena']
     );
     if(empty($error)) {
         if(ControladorUsuario::registrarUsuarioAdmin(
            $_POST['nombre'],
            $_POST['apellido1'],
            $_POST['apellido2'],
            $_POST['email'],
            $_POST['telefono'],
            $_POST['fechaNac'],
            $_POST['contrasena'],
            $_POST['idTipoUsuario']
         )) {
             $msg = "Usuario creado con éxito.";
         } else {
            $msg = "Error al crear el usuario.";
         }
     } else {
            $msg = implode(", ", $error);
     }
}

if(isset($_POST['guardarPass'])) {
    $error = ControladorUsuario::validarCambioContrasena(
        $_POST['nueva_contrasena'],
        $_POST['confirmar_contrasena']
    );

    if(empty($error)) {
        if(ControladorUsuario::cambiarContrasena(
            $_POST['id_usuario_pass'],
            $_POST['nueva_contrasena']
        )) {
            $msg = "Contraseña actualizada con éxito.";
        } else {
            $msg = "Error al actualizar la contraseña.";
        }
    } else {
        $msg = "Error de validación: ";
        if(in_array("valNuevaPass", $error)) {
            $msg .= "La contraseña debe tener mínimo 8 caracteres. ";
        }
        if(in_array("valConfirmarPass", $error)) {
            $msg .= "Las contraseñas no coinciden.";
        }
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

<main class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-11">

            <!-- Encabezado con botón crear -->
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h2 class="font-titulos text-primary mb-0">Panel Usuario</h2>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <button type="button" class="btn btn-primary" onclick="abrirModalCrearUsuario()">
                        <i class="bi bi-person-plus-fill me-2"></i>Crear Usuario
                    </button>
                </div>
            </div>

            <!-- Mensajes de éxito o error -->
            <?php if(!empty($msg)): ?>
                <div class="alert <?= empty($error) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                    <?= $msg ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-3">Nombre</th>
                                    <th class="py-3">1º Apellido</th>
                                    <th class="py-3">2º Apellido</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Teléfono</th>
                                    <th class="py-3">Fecha nacimiento</th>
                                    <th class="py-3">Tipo Usuario</th>
                                    <th class="py-3 text-center">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $usuarios = ControladorUsuario::obtenerTodosUsuarios();
                                foreach ($usuarios as $usuario):
                                    $tiposUsuario = ControladorTipoUsuario::getAll();
                                ?>
                                <tr>
                                    <td class="px-3">
                                        <form method="post" action="" id="form_<?= $usuario->idUsuario ?>">
                                            <input type="hidden" name="id_usuario" value="<?= $usuario->idUsuario ?>">
                                        </form>
                                        <input type="text" class="form-control form-control-sm" name="nombre" value="<?= $usuario->nombre ?>" form="form_<?= $usuario->idUsuario ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="apellido1" value="<?= $usuario->apellido1 ?>" form="form_<?= $usuario->idUsuario ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="apellido2" value="<?= $usuario->apellido2 ?>" form="form_<?= $usuario->idUsuario ?>">
                                    </td>
                                    <td>
                                        <input type="email" class="form-control form-control-sm" name="email" value="<?= $usuario->email ?>" form="form_<?= $usuario->idUsuario ?>">
                                    </td>
                                    <td>
                                        <input type="tel" class="form-control form-control-sm" name="telefono" value="<?= $usuario->telefono ?>" form="form_<?= $usuario->idUsuario ?>">
                                    </td>
                                    <td>
                                        <input type="date" class="form-control form-control-sm" name="fechaNac" value="<?= $usuario->fechaNac ?>" form="form_<?= $usuario->idUsuario ?>">
                                    </td>
                                    <td>
                                        <select class="form-select form-select-sm" name="idTipoUsuario" form="form_<?= $usuario->idUsuario ?>">
                                            <?php
                                            foreach ($tiposUsuario as $tipo) {
                                                $selected = ($tipo->idTipoUsuario == $usuario->idTipoUsuario) ? 'selected' : '';
                                                echo "<option value='{$tipo->idTipoUsuario}' {$selected}>{$tipo->tipo}</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="submit" name="actualizar" class="btn btn-success" title="Guardar" form="form_<?= $usuario->idUsuario ?>">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                            <button type="submit" name="eliminar" class="btn btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este usuario?')" form="form_<?= $usuario->idUsuario ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning"
                                                    onclick="abrirModalContrasena(<?= $usuario->idUsuario ?>, '<?= $usuario->nombre . ' ' . $usuario->apellido1 ?>')"
                                                    title="Cambiar Contraseña">
                                                <i class="bi bi-key"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<!-- Modal para crear usuario -->
<div class="modal fade" id="modalCrearUsuario" tabindex="-1" aria-labelledby="modalCrearUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCrearUsuarioLabel">Crear Nuevo Usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="" id="formCrearUsuario">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="crear_nombre" class="form-label">Nombre *</label>
                            <input type="text" class="form-control" id="crear_nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="crear_apellido1" class="form-label">1º Apellido *</label>
                            <input type="text" class="form-control" id="crear_apellido1" name="apellido1" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="crear_apellido2" class="form-label">2º Apellido</label>
                            <input type="text" class="form-control" id="crear_apellido2" name="apellido2">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="crear_email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="crear_email" name="email" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="crear_telefono" class="form-label">Teléfono *</label>
                            <input type="tel" class="form-control" id="crear_telefono" name="telefono" pattern="[0-9]{9}" required>
                            <div class="form-text">9 dígitos</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="crear_fechaNac" class="form-label">Fecha de Nacimiento *</label>
                            <input type="date" class="form-control" id="crear_fechaNac" name="fechaNac" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="crear_tipoUsuario" class="form-label">Tipo de Usuario *</label>
                            <select class="form-select" id="crear_tipoUsuario" name="idTipoUsuario" required>
                                <option value="">Selecciona un tipo</option>
                                <?php
                                $tiposUsuario = ControladorTipoUsuario::getAll();
                                foreach ($tiposUsuario as $tipo) {
                                    echo "<option value='{$tipo->idTipoUsuario}'>{$tipo->tipo}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="crear_contrasena" class="form-label">Contraseña *</label>
                            <input type="password" class="form-control" id="crear_contrasena" name="contrasena" minlength="8" required>
                            <div class="form-text">Mínimo 8 caracteres</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="crear_confirmar_contrasena" class="form-label">Confirmar Contraseña *</label>
                        <input type="password" class="form-control" id="crear_confirmar_contrasena" name="confirmar_contrasena" minlength="8" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" name="guardar">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para cambiar contraseña -->
<div class="modal fade" id="modalContrasena" tabindex="-1" aria-labelledby="modalContrasenaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="modalContrasenaLabel">Cambiar Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="" id="formCambiarContrasena">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="nueva_contrasena" class="form-label">Nueva Contraseña *</label>
                        <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena" minlength="8" required>
                        <div class="form-text">Mínimo 8 caracteres</div>
                    </div>

                    <div class="mb-3">
                        <label for="confirmar_contrasena" class="form-label">Confirmar Contraseña *</label>
                        <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" minlength="8" required>
                    </div>

                    <input type="hidden" id="id_usuario_pass" name="id_usuario_pass">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning" name="guardarPass">Guardar Contraseña</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function abrirModalCrearUsuario() {
    // Limpiar el formulario
    document.getElementById('formCrearUsuario').reset();

    // Abrir el modal
    const modal = new bootstrap.Modal(document.getElementById('modalCrearUsuario'));
    modal.show();
}

function abrirModalContrasena(idUsuario, nombreUsuario) {
    // Actualizar el título del modal con el nombre del usuario
    document.getElementById('modalContrasenaLabel').textContent = 'Cambiar Contraseña - ' + nombreUsuario;

    // Establecer el ID del usuario
    document.getElementById('id_usuario_pass').value = idUsuario;

    // Limpiar los campos
    document.getElementById('nueva_contrasena').value = '';
    document.getElementById('confirmar_contrasena').value = '';

    // Abrir el modal
    const modal = new bootstrap.Modal(document.getElementById('modalContrasena'));
    modal.show();
}

// Validación de contraseñas en el modal
document.getElementById('formCambiarContrasena').addEventListener('submit', function(e) {
    const nuevaPass = document.getElementById('nueva_contrasena').value;
    const confirmarPass = document.getElementById('confirmar_contrasena').value;

    // Validar mínimo 8 caracteres
    if (nuevaPass.length < 8) {
        e.preventDefault();
        alert('La contraseña debe tener mínimo 8 caracteres.');
        return false;
    }

    // Validar que coincidan
    if (nuevaPass !== confirmarPass) {
        e.preventDefault();
        alert('Las contraseñas no coinciden.');
        return false;
    }
});
</script>

<?php include "includes/footer.php"; ?>
</body>
</html>
