<?php
session_start();

require_once './controlador/ControladorProducto.php';
require_once './controlador/ControladorUsuario.php';
require_once './controlador/ControladorTipoProducto.php';

$controlador = new ControladorProducto();

// Procesar guardado/edición de producto
if (isset($_POST['guardar'])) {
    try {
        // Validar campos requeridos
        if (empty($_POST['nombre']) || empty($_POST['marca']) || empty($_POST['precio']) || 
            empty($_POST['talla']) || empty($_POST['color']) || 
            empty($_POST['idTipoProducto']) || empty($_POST['idUsuario'])) {
            $mensaje = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Por favor, completa todos los campos obligatorios
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
        } else {
            // idImgProducto se gestionará en el módulo de imágenes
            $idImgProducto = null;

            if (isset($_POST['idProducto']) && $_POST['idProducto'] !== '') {
                // Editar producto existente
                $controlador->editarProducto(
                    $_POST['idProducto'],
                    $_POST['idTipoProducto'],
                    $_POST['idUsuario'],
                    $_POST['nombre'],
                    $_POST['marca'],
                    $_POST['precio'],
                    $_POST['talla'],
                    $_POST['color']
                );
                $mensaje = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    Producto actualizado correctamente
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                </div>";
            } else {
                // Crear nuevo producto
                $controlador->crearProducto(
                    $_POST['idTipoProducto'],
                    $_POST['idUsuario'],
                    $_POST['nombre'],
                    $_POST['marca'],
                    $_POST['precio'],
                    $_POST['talla'],
                    $_POST['color']
                );
                $mensaje = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    Producto creado correctamente
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                </div>";
            }
            // Redirigir para evitar reenvío de formulario
            header("Location: panelProducto.php?success=1");
            exit();
        }
    } catch (Exception $e) {
        $mensaje = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Error: " . htmlspecialchars($e->getMessage()) . "
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        </div>";
    }
}

// Procesar eliminación de producto
if (isset($_POST['eliminar'])) {
    try {
        $controlador->eliminarProducto($_POST['idProducto']);
        header("Location: panelProducto.php?deleted=1");
        exit();
    } catch (Exception $e) {
        $mensaje = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Error: " . htmlspecialchars($e->getMessage()) . "
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        </div>";
    }
}

// Procesar subida de imagen
if (isset($_POST['subir_imagen'])) {
    try {
        $idProducto = $_POST['idProducto'];
        
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $archivo = $_FILES['imagen'];
            
            // Validar tipo de archivo
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($archivo['type'], $tiposPermitidos)) {
                throw new Exception('Formato de imagen no permitido. Usa JPG, PNG, GIF o WEBP');
            }
            
            // Validar tamaño (máximo 5MB)
            if ($archivo['size'] > 5 * 1024 * 1024) {
                throw new Exception('La imagen no debe superar los 5MB');
            }
            
            // Crear directorio si no existe
            $directorioDestino = 'assets/img/productos/';
            if (!is_dir($directorioDestino)) {
                mkdir($directorioDestino, 0755, true);
            }
            
            // Generar nombre único
            $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            $nombreArchivo = 'producto_' . $idProducto . '_' . time() . '.' . $extension;
            $rutaDestino = $directorioDestino . $nombreArchivo;
            
            // Mover archivo
            if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
                // Guardar en base de datos
                if ($controlador->agregarImagenProducto($idProducto, $rutaDestino)) {
                    header("Location: panelProducto.php?imagenes=$idProducto&img_success=1");
                    exit();
                } else {
                    throw new Exception('Error al guardar la imagen en la base de datos');
                }
            } else {
                throw new Exception('Error al subir el archivo');
            }
        } else {
            throw new Exception('No se recibió ninguna imagen o hubo un error en la subida');
        }
    } catch (Exception $e) {
        $errorImagen = $e->getMessage();
    }
}

// Procesar eliminación de imagen
if (isset($_POST['eliminar_imagen'])) {
    try {
        $idImagenProducto = $_POST['idImagenProducto'];
        $idProducto = $_POST['idProducto'];
        
        if ($controlador->eliminarImagenProducto($idImagenProducto)) {
            header("Location: panelProducto.php?imagenes=$idProducto&img_deleted=1");
            exit();
        } else {
            throw new Exception('Error al eliminar la imagen');
        }
    } catch (Exception $e) {
        $errorImagen = $e->getMessage();
    }
}

// Mensajes de éxito desde parámetros GET
if (isset($_GET['success'])) {
    $mensaje = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        Producto guardado correctamente
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    </div>";
}
if (isset($_GET['deleted'])) {
    $mensaje = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        Producto eliminado correctamente
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    </div>";
}

// Obtener producto para editar si se solicita
$productoEditar = null;
if (isset($_GET['editar'])) {
    try {
        $productoEditar = $controlador->obtenerProductoPorId($_GET['editar']);
    } catch (Exception $e) {
        $mensaje = "<div class='alert alert-danger'>Error al cargar producto</div>";
    }
}

// Obtener todos los productos
try {
    $productos = $controlador->obtenerTodosProductos();
} catch (Exception $e) {
    $productos = [];
    $mensaje = "<div class='alert alert-warning'>No se pudieron cargar los productos</div>";
}

?>

<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="d-flex flex-column min-vh-100">
<?php include "includes/design-top.php"; ?>
<?php include "includes/navigation.php"; ?>

<main class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-11 col-xl-10">

            <!-- Encabezado -->
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h1 class="font-titulos text-primary mb-0">Panel de Productos</h1>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <a href="panelProducto.php?crear=1" class="btn btn-info btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Crear Nuevo Producto
                    </a>
                </div>
            </div>

            <?php if (isset($mensaje)) echo $mensaje; ?>

            <!-- Tabla de Productos -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4">ID</th>
                                    <th class="py-3">Nombre</th>
                                    <th class="py-3">Marca</th>
                                    <th class="py-3">Precio</th>
                                    <th class="py-3">Talla</th>
                                    <th class="py-3">Color</th>
                                    <th class="py-3 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($productos)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        No hay productos registrados
                                    </td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach ($productos as $producto): ?>
                                    <tr>
                                        <td class="px-4 align-middle">#<?= $producto->id_producto ?></td>
                                        <td class="align-middle fw-bold"><?= $producto->nombre ?></td>
                                        <td class="align-middle"><?= $producto->marca ?></td>
                                        <td class="align-middle"><?= number_format($producto->precio, 2) ?>€</td>
                                        <td class="align-middle">
                                            <span class="badge bg-secondary"><?= $producto->talla ?></span>
                                        </td>
                                        <td class="align-middle"><?= $producto->color ?></td>
                                        <td class="align-middle text-center">
                                            <a href="panelProducto.php?editar=<?= $producto->id_producto ?>"
                                               class="btn btn-sm btn-outline-primary me-1"
                                               title="Editar producto">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="panelProducto.php?imagenes=<?= $producto->id_producto ?>"
                                               class="btn btn-sm btn-outline-info me-1"
                                               title="Gestionar imágenes">
                                                <i class="bi bi-image"></i>
                                            </a>
                                            <a href="panelProducto.php?confirmar_eliminar=<?= $producto->id_producto ?>"
                                               class="btn btn-sm btn-outline-danger"
                                               title="Eliminar producto">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<?php if (isset($_GET['crear']) || isset($_GET['editar'])): ?>
<!-- Formulario para Crear/Editar Producto -->
<div class="modal fade show d-block" id="modalProducto" tabindex="-1" aria-labelledby="modalProductoLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header <?= isset($_GET['editar']) ? 'bg-secondary' : 'bg-primary' ?> text-white">
                <h5 class="modal-title font-titulos" id="modalProductoLabel">
                    <?= isset($_GET['editar']) ? 'Editar Producto #' . $_GET['editar'] : 'Nuevo Producto' ?>
                </h5>
                <a href="panelProducto.php" class="btn-close btn-close-white" aria-label="Close"></a>
            </div>
            <form action="" method="post" class="p-4">
                <input type="hidden" name="idProducto" value="<?= isset($productoEditar) ? $productoEditar->id_producto : '' ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" class="form-control border-secondary" id="nombre" name="nombre"
                               value="<?= isset($productoEditar) ? $productoEditar->nombre : '' ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="marca" class="form-label">Marca *</label>
                        <input type="text" class="form-control border-secondary" id="marca" name="marca"
                               value="<?= isset($productoEditar) ? $productoEditar->marca : '' ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="precio" class="form-label">Precio (€) *</label>
                        <input type="number" step="0.01" class="form-control border-secondary" id="precio" name="precio"
                               value="<?= isset($productoEditar) ? $productoEditar->precio : '' ?>" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="talla" class="form-label">Talla *</label>
                        <select class="form-select border-secondary" id="talla" name="talla" required>
                            <option value="">Selecciona</option>
                            <?php
                            $tallas = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                            foreach ($tallas as $t) {
                                $selected = (isset($productoEditar) && $productoEditar->talla === $t) ? 'selected' : '';
                                echo "<option value='$t' $selected>$t</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="color" class="form-label">Color *</label>
                        <input type="text" class="form-control border-secondary" id="color" name="color"
                               value="<?= isset($productoEditar) ? $productoEditar->color : '' ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="idTipoProducto" class="form-label">Tipo Producto *</label>
                        <select class="form-select border-secondary" id="idTipoProducto" name="idTipoProducto" required>
                            <option value="">Selecciona un tipo</option>
                            <?php
                            try {
                                $controladorTipo = new ControladorTipoProducto();
                                $tiposProducto = $controladorTipo->obtenerTodosTiposProducto();
                                foreach ($tiposProducto as $tipo) {
                                    $selected = (isset($productoEditar) && $productoEditar->id_tipo_producto == $tipo->id_tipo_producto) ? 'selected' : '';
                                    echo "<option value='" . $tipo->id_tipo_producto . "' $selected>" . $tipo->tipo . "</option>";
                                }
                            } catch (Exception $e) {
                                echo "<option value=''>Error al cargar tipos</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="idUsuario" class="form-label">Usuario Vendedor *</label>
                        <select class="form-select border-secondary" id="idUsuario" name="idUsuario" required>
                            <option value="">Selecciona un usuario</option>
                            <?php
                            try {
                                $listaUsuarios = ControladorUsuario::obtenerTodosUsuarios();
                                foreach ($listaUsuarios as $usuario) {
                                    $selected = (isset($productoEditar) && $productoEditar->id_usuario == $usuario->idUsuario) ? 'selected' : '';
                                    echo "<option value='" . $usuario->idUsuario . "' $selected>" . $usuario->nombre . "</option>";
                                }
                            } catch (Exception $e) {
                                echo "<option value=''>Error al cargar usuarios</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="panelProducto.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" name="guardar" class="btn btn-primary">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
<?php endif; ?>

<?php if (isset($_GET['confirmar_eliminar'])): ?>
<!-- Modal de Confirmación para Eliminar -->
<?php
$idEliminar = $_GET['confirmar_eliminar'];
$productoEliminar = null;
try {
    $productoEliminar = $controlador->obtenerProductoPorId($idEliminar);
} catch (Exception $e) {}
?>
<div class="modal fade show d-block" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalEliminarLabel">Confirmar Eliminación</h5>
                <a href="panelProducto.php" class="btn-close btn-close-white" aria-label="Close"></a>
            </div>
            <div class="modal-body p-4">
                <p>¿Estás seguro de que quieres eliminar el producto <strong><?= $productoEliminar ? $productoEliminar->nombre : '#' . $idEliminar ?></strong>?</p>
                <p class="text-muted mb-0">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer p-3">
                <form action="" method="post" class="d-flex gap-2 w-100">
                    <input type="hidden" name="idProducto" value="<?= $idEliminar ?>">
                    <a href="panelProducto.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
<?php endif; ?>

<?php if (isset($_GET['imagenes'])): ?>
<!-- Modal de Gestión de Imágenes -->
<?php
$idProducto = (int)$_GET['imagenes'];
$productoImg = $controlador->obtenerProductoPorId($idProducto);
$imagenesProducto = $controlador->obtenerImagenesProducto($idProducto);
?>
<div class="modal fade show d-block" id="modalImagenes" tabindex="-1" aria-labelledby="modalImagenesLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title font-titulos" id="modalImagenesLabel">
                    <i class="bi bi-images"></i> Gestionar Imágenes - <?= $productoImg ? htmlspecialchars($productoImg->nombre) : 'Producto' ?>
                </h5>
                <a href="panelProducto.php" class="btn-close btn-close-white" aria-label="Close"></a>
            </div>
            <div class="modal-body p-4">
                <?php if (isset($_GET['img_success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> Imagen subida correctamente
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['img_deleted'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> Imagen eliminada correctamente
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($errorImagen)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($errorImagen) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <!-- Formulario para subir imagen -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-cloud-upload"></i> Subir Nueva Imagen</h6>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="idProducto" value="<?= $idProducto ?>">
                            
                            <div class="row align-items-end">
                                <div class="col-md-9 mb-3 mb-md-0">
                                    <label for="imagen" class="form-label">Seleccionar Imagen</label>
                                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                                    <small class="text-muted">Formatos: JPG, PNG, GIF, WEBP | Tamaño máximo: 5MB</small>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" name="subir_imagen" class="btn btn-primary w-100">
                                        <i class="bi bi-upload"></i> Subir
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Lista de imágenes actuales -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="bi bi-collection"></i> Imágenes del Producto 
                            <span class="badge bg-primary"><?= count($imagenesProducto) ?></span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <?php if (empty($imagenesProducto)): ?>
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-images fs-1 d-block mb-2"></i>
                                <p class="mb-0">No hay imágenes subidas para este producto</p>
                            </div>
                        <?php else: ?>
                            <div class="row g-3">
                                <?php foreach ($imagenesProducto as $imagen): ?>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="card h-100">
                                            <div class="position-relative">
                                                <img src="<?= htmlspecialchars($imagen->url_image) ?>" 
                                                     class="card-img-top" 
                                                     alt="Imagen producto"
                                                     style="height: 200px; object-fit: cover;">
                                                <div class="position-absolute top-0 end-0 p-2">
                                                    <span class="badge bg-dark">ID: <?= $imagen->id_image_producto ?></span>
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <small class="text-muted d-block text-truncate" title="<?= htmlspecialchars($imagen->url_image) ?>">
                                                    <i class="bi bi-file-image"></i> <?= basename($imagen->url_image) ?>
                                                </small>
                                            </div>
                                            <div class="card-footer p-2 bg-transparent">
                                                <form action="" method="post" onsubmit="return confirm('¿Eliminar esta imagen?')">
                                                    <input type="hidden" name="idImagenProducto" value="<?= $imagen->id_image_producto ?>">
                                                    <input type="hidden" name="idProducto" value="<?= $idProducto ?>">
                                                    <button type="submit" name="eliminar_imagen" class="btn btn-sm btn-danger w-100">
                                                        <i class="bi bi-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="panelProducto.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver al Panel
                </a>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
<?php endif; ?>

<?php include "includes/footer.php"; ?>

</body>
</html>

