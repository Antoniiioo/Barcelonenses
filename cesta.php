<?php
session_start();
include("includes/a_config.php");
require_once './controlador/ControladorProducto.php';

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

                    <form>
                        <div class="mb-3 border border-dark p-2 d-flex align-items-center">
                            <label class="small fw-bold ps-2 mb-0 text-nowrap">Calle:</label>
                            <input type="text" class="form-control border-0 shadow-none bg-transparent" required>
                        </div>

                        <div class="mb-3 border border-dark p-2 d-flex align-items-center">
                            <label class="small fw-bold ps-2 mb-0 text-nowrap">Numero calle:</label>
                            <input type="text" class="form-control border-0 shadow-none bg-transparent" required>
                        </div>

                        <div class="mb-3 border border-dark p-2 d-flex align-items-center">
                            <label class="small fw-bold ps-2 mb-0 text-nowrap">Codigo postal:</label>
                            <input type="text" class="form-control border-0 shadow-none bg-transparent" required>
                        </div>

                        <div class="mb-3 border border-dark p-2 d-flex align-items-center">
                            <label class="small fw-bold ps-2 mb-0 text-nowrap">Localidad:</label>
                            <input type="text" class="form-control border-0 shadow-none bg-transparent" required>
                        </div>

                        <div class="mb-3 border border-dark p-2 d-flex align-items-center">
                            <label class="small fw-bold ps-2 mb-0 text-nowrap">Provincia:</label>
                            <input type="text" class="form-control border-0 shadow-none bg-transparent">
                        </div>

                        <div class="mb-4 border border-dark p-2 d-flex align-items-center">
                            <label class="small fw-bold ps-2 mb-0 text-nowrap">Pais:</label>
                            <input type="text" class="form-control border-0 shadow-none bg-transparent" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-black bg-black text-white rounded-4 px-4 py-2">
                                Guardar dirección
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