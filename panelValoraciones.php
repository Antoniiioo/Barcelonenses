<?php
session_start();

require_once './controlador/ControladorProducto.php';
require_once './controlador/ControladorUsuario.php';

$error = [];
$msg = '';

// Datos de ejemplo - Productos siempre visibles
$productoEjemplo1 = new stdClass();
$productoEjemplo1->id_Producto = 1;
$productoEjemplo1->nombre = "Camiseta Adidas";
$productoEjemplo1->marca = "Adidas";
$productoEjemplo1->precio = 29.99;
$productoEjemplo1->talla = "M";
$productoEjemplo1->color = "#000000";
$productoEjemplo1->id_Tipo_Producto = "Ropa Deportiva";
$productoEjemplo1->id_Usuario = "Juan Pérez";
$productoEjemplo1->valoracionPromedio = 4.5;
$productoEjemplo1->numValoraciones = 12;

$productoEjemplo2 = new stdClass();
$productoEjemplo2->id_Producto = 2;
$productoEjemplo2->nombre = "Pantalón Nike";
$productoEjemplo2->marca = "Nike";
$productoEjemplo2->precio = 49.99;
$productoEjemplo2->talla = "L";
$productoEjemplo2->color = "#0000FF";
$productoEjemplo2->id_Tipo_Producto = "Ropa Deportiva";
$productoEjemplo2->id_Usuario = "María García";
$productoEjemplo2->valoracionPromedio = 3.8;
$productoEjemplo2->numValoraciones = 8;

$productoEjemplo3 = new stdClass();
$productoEjemplo3->id_Producto = 3;
$productoEjemplo3->nombre = "Chaquetón North Face";
$productoEjemplo3->marca = "The North Face";
$productoEjemplo3->precio = 129.99;
$productoEjemplo3->talla = "XL";
$productoEjemplo3->color = "#8B4513";
$productoEjemplo3->id_Tipo_Producto = "Abrigos";
$productoEjemplo3->id_Usuario = "Carlos López";
$productoEjemplo3->valoracionPromedio = 5.0;
$productoEjemplo3->numValoraciones = 25;

// Array con todos los productos de ejemplo
$productosBuscados = [$productoEjemplo1, $productoEjemplo2, $productoEjemplo3];
?>

<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "includes/head-tag-contents.php"; ?>
    <title>Panel de Valoraciones - Barcelonenses</title>
</head>
<body class="d-flex flex-column min-vh-100">
<?php include "includes/design-top.php"; ?>
<?php include "includes/navigation.php"; ?>

<main class="container-fluid py-4 mb-5 pb-4">
    <div class="row justify-content-center">
        <div class="col-11">

            <!-- Encabezado -->
            <div class="row mb-4 align-items-center">
                <div class="col-md-12">
                    <h2 class="font-titulos text-primary mb-0">Panel de Valoraciones</h2>
                    <p class="text-muted mt-2">Gestiona las valoraciones de los productos</p>
                </div>
            </div>

            <!-- Formulario de búsqueda -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <form method="post" action="" class="row g-3">
                        <div class="col-md-10">
                            <label for="nombre_producto" class="form-label fw-bold">
                                <i class="bi bi-search me-2"></i>Buscar Producto
                            </label>
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                id="nombre_producto"
                                name="nombre_producto"
                                placeholder="Ingresa el nombre del producto..."
                                required
                            >
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" name="buscar" class="btn btn-primary w-100 btn-lg">
                                <i class="bi bi-search me-2"></i>Buscar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Mensajes de éxito o error -->
            <?php if(!empty($msg)): ?>
                <div class="alert <?= empty($error) ? 'alert-info' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i><?= $msg ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Tabla de resultados -->
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-star-fill me-2"></i>Productos con Valoraciones
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-3">Nombre</th>
                                    <th class="py-3">Marca</th>
                                    <th class="py-3">Precio</th>
                                    <th class="py-3">Talla</th>
                                    <th class="py-3">Color</th>
                                    <th class="py-3">Tipo Producto</th>
                                    <th class="py-3">Usuario</th>
                                    <th class="py-3 text-center">Valoración</th>
                                    <th class="py-3 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($productosBuscados)): ?>
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                        <p class="mb-0">No se encontraron productos con ese nombre</p>
                                    </td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach ($productosBuscados as $producto): ?>
                                    <tr>
                                        <td class="px-3">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-box-seam text-primary me-2"></i>
                                                <span class="fw-semibold"><?= htmlspecialchars($producto->nombre) ?></span>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($producto->marca) ?></td>
                                        <td>
                                            <span class="badge bg-success fs-6"><?= number_format($producto->precio, 2) ?>€</span>
                                        </td>
                                        <td><?= htmlspecialchars($producto->talla) ?></td>
                                        <td>
                                            <span class="badge" style="background-color: <?= htmlspecialchars($producto->color) ?>">
                                                <?= htmlspecialchars($producto->color) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($producto->id_Tipo_Producto) ?></td>
                                        <td><?= htmlspecialchars($producto->id_Usuario) ?></td>
                                        <td class="text-center">
                                            <div class="text-warning">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star"></i>
                                                <small class="text-muted ms-1">(4.0)</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button"
                                                        class="btn btn-outline-primary"
                                                        onclick="verValoraciones(<?= $producto->id_Producto ?>)"
                                                        title="Ver valoraciones">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                                <button type="button"
                                                        class="btn btn-outline-success"
                                                        onclick="agregarValoracion(<?= $producto->id_Producto ?>)"
                                                        title="Agregar valoración">
                                                    <i class="bi bi-plus-circle-fill"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Total de productos encontrados: <strong><?= count($productosBuscados) ?></strong>
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<!-- Modal para ver valoraciones (estructura sin funcionalidad) -->
<div class="modal fade" id="modalVerValoraciones" tabindex="-1" aria-labelledby="modalVerValoracionesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalVerValoracionesLabel">
                    <i class="bi bi-star-fill me-2"></i>Valoraciones del Producto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Funcionalidad pendiente de implementar
                </div>
                <!-- Aquí irán las valoraciones cuando se implemente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar valoración (estructura sin funcionalidad) -->
<div class="modal fade" id="modalAgregarValoracion" tabindex="-1" aria-labelledby="modalAgregarValoracionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalAgregarValoracionLabel">
                    <i class="bi bi-plus-circle-fill me-2"></i>Agregar Valoración
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label for="puntuacion" class="form-label">Puntuación *</label>
                    <select class="form-select" id="puntuacion" name="puntuacion" required>
                        <option value="">Selecciona una puntuación</option>
                        <option value="5">⭐⭐⭐⭐⭐ (5 estrellas)</option>
                        <option value="4">⭐⭐⭐⭐ (4 estrellas)</option>
                        <option value="3">⭐⭐⭐ (3 estrellas)</option>
                        <option value="2">⭐⭐ (2 estrellas)</option>
                        <option value="1">⭐ (1 estrella)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="comentario" class="form-label">Comentario</label>
                    <textarea class="form-control" id="comentario" name="comentario" rows="4" placeholder="Escribe tu opinión sobre el producto..."></textarea>
                </div>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Funcionalidad pendiente de implementar
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success">Guardar Valoración</button>
            </div>
        </div>
    </div>
</div>

<script>
function verValoraciones(idProducto) {
    // Funcionalidad pendiente de implementar
    const modal = new bootstrap.Modal(document.getElementById('modalVerValoraciones'));
    modal.show();
}

function agregarValoracion(idProducto) {
    // Funcionalidad pendiente de implementar
    const modal = new bootstrap.Modal(document.getElementById('modalAgregarValoracion'));
    modal.show();
}
</script>

<?php include "includes/footer.php"; ?>
</body>
</html>
