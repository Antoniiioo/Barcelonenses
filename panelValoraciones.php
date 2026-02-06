<?php
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_tipo_usuario'] != 1) {
    header("Location: login.php");
    exit;
}


require_once './controlador/ControladorProducto.php';
require_once './controlador/ControladorUsuario.php';
require_once './controlador/ControladorValoracion.php';

$error = [];
$msg = '';
$msgSuccess = '';

// Variables para el modal de ver valoraciones
$mostrarModalValoraciones = false;
$valoracionesProducto = [];
$nombreProductoModal = '';
$idProductoVer = null;

// Variables para el modal de agregar valoración
$mostrarModalAgregar = false;
$idProductoAgregar = null;
$nombreProductoAgregar = '';

// Manejar la eliminación de una valoración
if(isset($_GET['eliminar_valoracion']) && isset($_GET['id_producto_ver'])) {
    $idValoracion = intval($_GET['eliminar_valoracion']);
    $idProductoEliminar = intval($_GET['id_producto_ver']);

    $resultado = ControladorValoracion::eliminarValoracion($idValoracion);

    if($resultado) {
        $_SESSION['msg_success_eliminacion'] = "Valoración eliminada exitosamente.";
    } else {
        $_SESSION['error_eliminacion'] = "Error al eliminar la valoración.";
    }

    // Redirigir de vuelta a ver las valoraciones del producto
    header("Location: panelValoraciones.php?id_producto_ver=" . $idProductoEliminar);
    exit;
}

// Manejar el envío del formulario para agregar valoración
if(isset($_POST['agregar_valoracion'])) {
    $idProductoAgregar = intval($_POST['id_producto']);
    $puntuacion = intval($_POST['puntuacion']);
    $comentario = trim($_POST['comentario']);

    // Validaciones
    if(empty($puntuacion) || $puntuacion < 1 || $puntuacion > 5) {
        $error[] = "Debes seleccionar una puntuación válida (1-5 estrellas).";
        $mostrarModalAgregar = true;
    }

    // Verificar que el usuario esté logueado
    if(!isset($_SESSION['id_usuario'])) {
        $error[] = "Debes estar logueado para agregar una valoración.";
        $mostrarModalAgregar = true;
    }

    if(empty($error)) {
        $idUsuario = $_SESSION['id_usuario'];

        // Insertar la valoración
        $resultado = ControladorValoracion::insertarValoracion($idProductoAgregar, $puntuacion, $comentario, $idUsuario);

        if($resultado) {
            $msgSuccess = "¡Valoración agregada exitosamente!";
            // Redirigir para ver las valoraciones del producto
            header("Location: panelValoraciones.php?id_producto_ver=" . $idProductoAgregar . "&success=1");
            exit;
        } else {
            $error[] = "Error al agregar la valoración. Por favor, inténtalo de nuevo.";
            $mostrarModalAgregar = true;
        }
    }

    // Si hay errores, obtener el nombre del producto para mostrar en el modal
    if($mostrarModalAgregar) {
        $controladorProducto = new ControladorProducto();
        $producto = $controladorProducto->obtenerProductoPorId($idProductoAgregar);
        if($producto) {
            $nombreProductoAgregar = $producto->nombre;
        }
    }
}

// Verificar si se está solicitando abrir el modal de agregar valoración
if(isset($_GET['id_producto_agregar'])) {
    $idProductoAgregar = intval($_GET['id_producto_agregar']);
    $mostrarModalAgregar = true;

    // Obtener el nombre del producto
    $controladorProducto = new ControladorProducto();
    $producto = $controladorProducto->obtenerProductoPorId($idProductoAgregar);
    if($producto) {
        $nombreProductoAgregar = $producto->nombre;
    }

    // Limpiar los resultados de búsqueda de la sesión cuando se abre un modal
    if(isset($_SESSION['productos_buscados'])) {
        unset($_SESSION['productos_buscados']);
        unset($_SESSION['termino_busqueda']);
    }
}

// Verificar si se está solicitando ver valoraciones de un producto
if(isset($_GET['id_producto_ver'])) {
    $idProductoVer = intval($_GET['id_producto_ver']);
    $mostrarModalValoraciones = true;

    // Obtener las valoraciones del producto
    $valoracionesProducto = ControladorValoracion::obtenerValoracionesPorProducto($idProductoVer);

    // Obtener el nombre del producto
    $controladorProducto = new ControladorProducto();
    $producto = $controladorProducto->obtenerProductoPorId($idProductoVer);
    if($producto) {
        $nombreProductoModal = $producto->nombre;
    }

    // Mostrar mensaje de éxito si viene de agregar valoración
    if(isset($_GET['success']) && $_GET['success'] == 1) {
        $msgSuccess = "¡Valoración agregada exitosamente!";
    }

    // Mostrar mensaje de éxito si viene de eliminar valoración
    if(isset($_SESSION['msg_success_eliminacion'])) {
        $msgSuccess = $_SESSION['msg_success_eliminacion'];
        unset($_SESSION['msg_success_eliminacion']);
    }

    // Mostrar mensaje de error si hubo problema al eliminar
    if(isset($_SESSION['error_eliminacion'])) {
        $error[] = $_SESSION['error_eliminacion'];
        unset($_SESSION['error_eliminacion']);
    }

    // Limpiar los resultados de búsqueda de la sesión cuando se abre un modal
    if(isset($_SESSION['productos_buscados'])) {
        unset($_SESSION['productos_buscados']);
        unset($_SESSION['termino_busqueda']);
    }
}

// Procesar búsqueda y redirigir para limpiar URL
if(isset($_POST['buscar'])) {
    $nombreProducto = trim($_POST['nombre_producto']);
    if(empty($nombreProducto)) {
        $_SESSION['error_busqueda'] = "El nombre del producto no puede estar vacío.";
    } else {
        // Buscar productos con valoraciones por nombre usando ControladorProducto
        $controladorProducto = new ControladorProducto();
        $productosBuscados = $controladorProducto->buscarProductosConValoracionesPorNombre($nombreProducto);

        // Guardar resultados en sesión
        $_SESSION['productos_buscados'] = $productosBuscados;
        $_SESSION['termino_busqueda'] = $nombreProducto;

        if(empty($productosBuscados)) {
            $_SESSION['msg_busqueda'] = "No se encontraron productos con valoraciones que coincidan con '{$nombreProducto}'.";
        } else {
            $_SESSION['msg_busqueda'] = "Se encontraron " . count($productosBuscados) . " producto(s) con valoraciones.";
        }
    }

    // Redirigir para limpiar POST y parámetros GET
    header("Location: panelValoraciones.php");
    exit;
}

// Recuperar resultados de búsqueda de la sesión
$productosBuscados = [];
if(isset($_SESSION['productos_buscados'])) {
    $productosBuscados = $_SESSION['productos_buscados'];

    // Recuperar mensajes
    if(isset($_SESSION['msg_busqueda'])) {
        $msg = $_SESSION['msg_busqueda'];
        unset($_SESSION['msg_busqueda']);
    }
    if(isset($_SESSION['error_busqueda'])) {
        $error[] = $_SESSION['error_busqueda'];
        unset($_SESSION['error_busqueda']);
    }
}
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
            <?php if(!empty($msgSuccess)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= $msgSuccess ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?php if(is_array($error)): ?>
                        <ul class="mb-0">
                            <?php foreach($error as $err): ?>
                                <li><?= $err ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <?= $error ?>
                    <?php endif; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(!empty($msg)): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
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
                                                <span class="fw-semibold"><?= $producto->nombre ?></span>
                                            </div>
                                        </td>
                                        <td><?= $producto->marca ?></td>
                                        <td>
                                            <span class="badge bg-success fs-6"><?= number_format($producto->precio, 2) ?>€</span>
                                        </td>
                                        <td><?= $producto->talla ?></td>
                                        <td>
                                            <span class="badge" style="background-color: <?= $producto->color ?>; color: #fff;">
                                                <?= $producto->color ?>
                                            </span>
                                        </td>
                                        <td><?= $producto->tipo_producto ?? 'Sin tipo' ?></td>
                                        <td><?= $producto->nombre_usuario ?? 'Sin usuario' ?></td>
                                        <td class="text-center">
                                            <div class="text-warning">
                                                <?php
                                                // Calcular la valoración promedio del producto
                                                $promedioData = ControladorValoracion::obtenerPromedioValoracion($producto->id_producto);
                                                $promedio = $promedioData ? round($promedioData->promedio, 1) : 0;
                                                $totalValoraciones = $promedioData ? $promedioData->total : 0;

                                                // Mostrar estrellas según el promedio
                                                for($i = 1; $i <= 5; $i++) {
                                                    if($i <= floor($promedio)) {
                                                        echo '<i class="bi bi-star-fill"></i>';
                                                    } elseif($i == ceil($promedio) && $promedio - floor($promedio) >= 0.5) {
                                                        echo '<i class="bi bi-star-half"></i>';
                                                    } else {
                                                        echo '<i class="bi bi-star"></i>';
                                                    }
                                                }
                                                ?>
                                                <small class="text-muted ms-1">(<?= $promedio ?>) <?= $totalValoraciones ?> valoración<?= $totalValoraciones != 1 ? 'es' : '' ?></small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button"
                                                        class="btn btn-outline-primary"
                                                        onclick="verValoraciones(<?= $producto->id_producto ?>)"
                                                        title="Ver valoraciones">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                                <button type="button"
                                                        class="btn btn-outline-success"
                                                        onclick="agregarValoracion(<?= $producto->id_producto ?>)"
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

<!-- Modal para ver valoraciones -->
<div class="modal fade" id="modalVerValoraciones" tabindex="-1" aria-labelledby="modalVerValoracionesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalVerValoracionesLabel">
                    <i class="bi bi-star-fill me-2"></i>Valoraciones de: <?= $nombreProductoModal ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <?php if(empty($valoracionesProducto)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Este producto aún no tiene valoraciones.
                    </div>
                <?php else: ?>
                    <!-- Lista de valoraciones -->
                    <div class="list-group">
                        <?php foreach($valoracionesProducto as $valoracion): ?>
                            <div class="list-group-item mb-3 border rounded shadow-sm">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1 fw-bold">
                                            <i class="bi bi-person-circle me-2 text-primary"></i>
                                            <?= $valoracion->nombre_usuario ?? 'Usuario' ?>
                                            <?= $valoracion->apellido1 ?? '' ?>
                                        </h6>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="text-warning">
                                            <?php
                                            // Mostrar estrellas según la puntuación
                                            for($i = 1; $i <= 5; $i++) {
                                                if($i <= $valoracion->puntuacion) {
                                                    echo '<i class="bi bi-star-fill"></i>';
                                                } else {
                                                    echo '<i class="bi bi-star"></i>';
                                                }
                                            }
                                            ?>
                                            <span class="text-dark ms-1">(<?= $valoracion->puntuacion ?>/5)</span>
                                        </div>
                                        <!-- Botón de eliminar -->
                                        <a href="panelValoraciones.php?eliminar_valoracion=<?= $valoracion->id_valoracion ?>&id_producto_ver=<?= $idProductoVer ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('¿Estás seguro de que deseas eliminar esta valoración?');"
                                           title="Eliminar valoración">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php if(!empty($valoracion->comentario)): ?>
                                    <p class="mb-0 text-muted">
                                        <i class="bi bi-chat-left-quote me-2"></i>
                                        <?= $valoracion->comentario ?>
                                    </p>
                                <?php else: ?>
                                    <p class="mb-0 text-muted fst-italic">
                                        <i class="bi bi-chat-left me-2"></i>
                                        Sin comentario
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Resumen de valoraciones -->
                    <div class="alert alert-light mt-3">
                        <div class="row text-center">
                            <div class="col-md-6">
                                <i class="bi bi-star-fill text-warning fs-4"></i>
                                <p class="mb-0 fw-bold">
                                    <?php
                                    $promedioData = ControladorValoracion::obtenerPromedioValoracion($idProductoVer);
                                    $promedio = $promedioData ? round($promedioData->promedio, 1) : 0;
                                    echo $promedio;
                                    ?>
                                    / 5
                                </p>
                                <small class="text-muted">Puntuación promedio</small>
                            </div>
                            <div class="col-md-6">
                                <i class="bi bi-chat-dots-fill text-primary fs-4"></i>
                                <p class="mb-0 fw-bold"><?= count($valoracionesProducto) ?></p>
                                <small class="text-muted">Total de valoraciones</small>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <a href="panelValoraciones.php" class="btn btn-secondary">Cerrar</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar valoración -->
<div class="modal fade" id="modalAgregarValoracion" tabindex="-1" aria-labelledby="modalAgregarValoracionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalAgregarValoracionLabel">
                        <i class="bi bi-plus-circle-fill me-2"></i>Agregar Valoración
                        <?php if(!empty($nombreProductoAgregar)): ?>
                            - <?= $nombreProductoAgregar ?>
                        <?php endif; ?>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id_producto" value="<?= $idProductoAgregar ?>">

                    <div class="mb-3">
                        <label for="puntuacion" class="form-label fw-bold">Puntuación *</label>
                        <select class="form-select" id="puntuacion" name="puntuacion" required>
                            <option value="">Selecciona una puntuación</option>
                            <option value="5">★★★★★ (5 estrellas - Excelente)</option>
                            <option value="4">★★★★☆ (4 estrellas - Muy bueno)</option>
                            <option value="3">★★★☆☆ (3 estrellas - Bueno)</option>
                            <option value="2">★★☆☆☆ (2 estrellas - Regular)</option>
                            <option value="1">★☆☆☆☆ (1 estrella - Malo)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="comentario" class="form-label fw-bold">Comentario (opcional)</label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="4"
                                  placeholder="Escribe tu opinión sobre el producto..."></textarea>
                        <small class="text-muted">Comparte tu experiencia con este producto</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="panelValoraciones.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" name="agregar_valoracion" class="btn btn-success">
                        <i class="bi bi-check-circle-fill me-2"></i>Guardar Valoración
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function verValoraciones(idProducto) {
    // Redirigir a la misma página con el parámetro del producto
    window.location.href = 'panelValoraciones.php?id_producto_ver=' + idProducto;
}

function agregarValoracion(idProducto) {
    // Redirigir a la misma página con el parámetro para agregar valoración
    window.location.href = 'panelValoraciones.php?id_producto_agregar=' + idProducto;
}

<?php if($mostrarModalValoraciones): ?>
// Mostrar automáticamente el modal de ver valoraciones cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal(document.getElementById('modalVerValoraciones'));
    modal.show();
});
<?php endif; ?>

<?php if($mostrarModalAgregar): ?>
// Mostrar automáticamente el modal de agregar valoración cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal(document.getElementById('modalAgregarValoracion'));
    modal.show();
});
<?php endif; ?>
</script>

<?php include "includes/footer.php"; ?>
</body>
</html>
