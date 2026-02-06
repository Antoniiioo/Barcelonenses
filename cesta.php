<?php
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

include("includes/a_config.php");
require_once './controlador/ControladorProducto.php';
require_once './controlador/ControladorUsuario.php';
require_once './controlador/ControladorDireccion.php';
require_once './controlador/Conexion.php';

$idUsuario = $_SESSION['id_usuario'];
$mensaje = '';

// ========== PROCESAR DIRECCIÓN ==========
if (isset($_POST['btn_guardar_direccion'])) {
    $calle = trim($_POST['calle']);
    $numCalle = trim($_POST['num_calle']);
    $codPostal = trim($_POST['cod_postal']);
    $localidad = trim($_POST['localidad']);
    $pais = trim($_POST['pais']);

    if (empty($calle) || empty($numCalle) || empty($codPostal) || empty($localidad) || empty($pais)) {
        $mensaje = '<i class="bi bi-exclamation-triangle-fill text-warning"></i> Todos los campos obligatorios deben estar completos';
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
                $mensaje = $resultado ? '<i class="bi bi-check-circle-fill text-success"></i> Dirección guardada correctamente' : '<i class="bi bi-x-circle-fill text-danger"></i> Error al guardar la dirección';
            }
        } catch (Exception $e) {
            $mensaje = '<i class="bi bi-x-circle-fill text-danger"></i> Error: ' . $e->getMessage();
        }
    }

    $_SESSION['mensaje_cesta'] = $mensaje;
    header("Location: cesta.php");
    exit;
}

// Recuperar mensaje de sesión
if (isset($_SESSION['mensaje_cesta'])) {
    $mensaje = $_SESSION['mensaje_cesta'];
    unset($_SESSION['mensaje_cesta']);
}

// Obtener datos del usuario y su dirección
$controladorUsuario = new ControladorUsuario();
$usuario = $controladorUsuario->obtenerUsuarioPorId($idUsuario);

$direccion = null;
if ($usuario && isset($usuario->id_direccion)) {
    $controladorDireccion = new ControladorDireccion();
    $direccion = $controladorDireccion->obtenerDireccionPorId($usuario->id_direccion);
}

// Obtener productos de la cesta (con límite de 2 para ejemplo)
$controladorProducto = new ControladorProducto();
$productosCesta = $controladorProducto->obtenerProductosConImagenes(2);

// Calcular totales
$subtotal = 0;
foreach($productosCesta as $producto) {
    $subtotal += $producto->precio;
}
$descuento = 0; // Sin descuento por ahora
$envio = 0; // Envío gratis
$total = $subtotal - $descuento + $envio;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="d-flex flex-column h-100">
    <?php include "includes/design-top.php"; ?>
    <?php include "includes/navigation.php"; ?>

    <main class="py-5">
        <div class="container">
            <?php if ($mensaje): ?>
                <div class="alert alert-dismissible fade show" role="alert">
                    <?= $mensaje ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-3 mb-5 mb-md-0">
                    <h4 class="fw-bold mb-4 fs-5">Tu cesta (<?= count($productosCesta) ?> <?= count($productosCesta) == 1 ? 'artículo' : 'artículos' ?>)</h4>

                    <?php if(!empty($productosCesta)): ?>
                        <?php foreach($productosCesta as $producto): ?>
                            <div class="mb-4 pb-4 border-bottom">
                                <div class="text-center mb-3">
                                    <?php if(!empty($producto->url_image)): ?>
                                        <img src="<?= $producto->url_image ?>"
                                             alt="<?= $producto->nombre ?>"
                                             class="img-fluid">
                                    <?php else: ?>
                                        <img src="assets/img/placeholder.jpg" alt="Sin imagen" class="img-fluid">
                                    <?php endif; ?>
                                </div>
                                <h5 class="fw-bold mb-1"><?= $producto->marca ?></h5>
                                <p class="mb-1 text-muted"><?= $producto->nombre ?></p>

                                <div class="mb-2">
                                    <span class="text-danger fw-bold fs-5"><?= number_format($producto->precio, 2) ?> €</span>
                                </div>

                                <div class="small text-muted mb-3">
                                    Color: <?= $producto->color ?><br>
                                    Talla: <?= $producto->talla ?>
                                </div>

                                <div class="mb-3">
                                    <select class="form-select form-select-sm border-secondary">
                                        <option value="1" selected>1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>

                                <div class="d-flex gap-2 align-items-center">
                                    <button class="btn btn-danger text-white btn-sm rounded-0 px-3" type="button">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <button class="btn border-0" type="button">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <i class="bi bi-cart fs-1 d-block mb-3"></i>
                            <p>Tu cesta está vacía</p>
                            <a href="listadoProductos.php" class="btn btn-primary mt-2">Ver productos</a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-5 mb-5 mb-md-0 px-md-4">

                    <div class="border border-dark p-2 text-center mb-4">
                        <span class="fw-bold small">Dirección de envío</span>
                    </div>

                    <?php if ($direccion): ?>
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-info-circle me-2"></i>Ya tienes una dirección guardada. Puedes actualizarla si lo deseas.
                        </div>
                    <?php endif; ?>

                    <form method="post" action="cesta.php">
                        <div class="mb-3 border border-dark p-2 d-flex align-items-center">
                            <label class="small fw-bold ps-2 mb-0 text-nowrap" for="calle">Calle:</label>
                            <input type="text"
                                   class="form-control border-0 shadow-none bg-transparent"
                                   id="calle"
                                   name="calle"
                                   value="<?= $direccion->calle ?? '' ?>"
                                   required>
                        </div>

                        <div class="mb-3 border border-dark p-2 d-flex align-items-center">
                            <label class="small fw-bold ps-2 mb-0 text-nowrap" for="num_calle">Numero calle:</label>
                            <input type="text"
                                   class="form-control border-0 shadow-none bg-transparent"
                                   id="num_calle"
                                   name="num_calle"
                                   value="<?= $direccion->num_calle ?? '' ?>"
                                   required>
                        </div>

                        <div class="mb-3 border border-dark p-2 d-flex align-items-center">
                            <label class="small fw-bold ps-2 mb-0 text-nowrap" for="cod_postal">Codigo postal:</label>
                            <input type="text"
                                   class="form-control border-0 shadow-none bg-transparent"
                                   id="cod_postal"
                                   name="cod_postal"
                                   value="<?= $direccion->cod_postal ?? '' ?>"
                                   maxlength="5"
                                   required>
                        </div>

                        <div class="mb-3 border border-dark p-2 d-flex align-items-center">
                            <label class="small fw-bold ps-2 mb-0 text-nowrap" for="localidad">Localidad:</label>
                            <input type="text"
                                   class="form-control border-0 shadow-none bg-transparent"
                                   id="localidad"
                                   name="localidad"
                                   value="<?= $direccion->localidad ?? '' ?>"
                                   required>
                        </div>

                        <div class="mb-4 border border-dark p-2 d-flex align-items-center">
                            <label class="small fw-bold ps-2 mb-0 text-nowrap" for="pais">Pais:</label>
                            <input type="text"
                                   class="form-control border-0 shadow-none bg-transparent"
                                   id="pais"
                                   name="pais"
                                   value="<?= $direccion->pais ?? 'España' ?>"
                                   required>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="btn_guardar_direccion" class="btn btn-black bg-black text-white rounded-4 px-4 py-2">
                                <i class="bi bi-save me-2"></i><?= $direccion ? 'Actualizar dirección' : 'Guardar dirección' ?>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="col-md-4">

                    <div class="d-grid gap-2 mb-4">
                        <button class="btn btn-outline-secondary border-primary-subtle text-dark py-2"
                            type="button">Contrarrembolso</button>
                        <button class="btn btn-outline-secondary border-primary-subtle text-dark py-2"
                            type="button">Tarjeta de crédito</button>
                        <button class="btn text-white py-2" type="button">PayPal</button>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span><?= number_format($subtotal, 2) ?> €</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Descuento:</span>
                            <span><?= number_format($descuento, 2) ?> €</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span>Envío:</span>
                            <span><?= number_format($envio, 2) ?> €</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold fs-5 mb-5">
                            <span>Total con IVA:</span>
                            <span><?= number_format($total, 2) ?> €</span>
                        </div>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-black bg-black text-white rounded-4 px-4 py-2">
                            Confirmar pedido
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "includes/footer.php"; ?>
</body>

</html>