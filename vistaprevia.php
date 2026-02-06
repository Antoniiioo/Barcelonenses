<?php
session_start();
include("includes/a_config.php");
require_once './controlador/ControladorProducto.php';
require_once './controlador/ControladorImageProducto.php';
require_once './controlador/ControladorValoracion.php';

// Variables para mensajes
$mensaje = '';
$error = [];

// Verificar si hay un producto seleccionado en sesión
$productoSeleccionado = null;
$imagenesProducto = [];
$valoraciones = [];

if(isset($_SESSION['producto_seleccionado'])) {
    $idProducto = $_SESSION['producto_seleccionado'];

    // Procesar formulario de agregar valoración
    if(isset($_POST['enviar_valoracion'])) {
        $puntuacion = intval($_POST['puntuacion']);
        $comentario = trim($_POST['comentario']);

        // Validaciones
        if(empty($puntuacion) || $puntuacion < 1 || $puntuacion > 5) {
            $error[] = "Debes seleccionar una puntuación válida (1-5 estrellas).";
        }

        // Verificar que el usuario esté logueado
        if(!isset($_SESSION['id_usuario'])) {
            $error[] = "Debes estar logueado para agregar una valoración.";
        }

        if(empty($error)) {
            $idUsuario = $_SESSION['id_usuario'];

            // Insertar la valoración
            $resultado = ControladorValoracion::insertarValoracion($idProducto, $puntuacion, $comentario, $idUsuario);

            if($resultado) {
                $mensaje = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>¡Valoración agregada exitosamente!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>';
            } else {
                $error[] = "Error al agregar la valoración. Por favor, inténtalo de nuevo.";
            }
        }

        if(!empty($error)) {
            $mensaje = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><ul class="mb-0">';
            foreach($error as $err) {
                $mensaje .= '<li>' . $err . '</li>';
            }
            $mensaje .= '</ul><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        }
    }

    // Obtener datos del producto
    $controladorProducto = new ControladorProducto();
    $productoSeleccionado = $controladorProducto->obtenerProductoPorId($idProducto);

    // Obtener imágenes del producto
    $imagenesProducto = ControladorImageProducto::getImagenesPorProducto($idProducto);

    // Obtener valoraciones del producto
    $valoraciones = ControladorValoracion::obtenerValoracionesPorProducto($idProducto);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="d-flex flex-column vh-100">
    <?php include "includes/design-top.php"; ?>
    <?php include "includes/navigation.php"; ?>

    <main class="py-4 container-fluid">
        <div class="container">
            <?php if($productoSeleccionado): ?>
            <div class="row">

                <div class="col-md-7 mb-4 mb-md-0">
                    <div class="row">

                        <div class="col-3 col-md-3 d-flex flex-column gap-2 justify-content-center">
                            <?php
                            // Mostrar miniaturas laterales (primeras 3 imágenes)
                            $imagenesMiniatura = array_slice($imagenesProducto, 0, 3);
                            foreach($imagenesMiniatura as $imagen):
                            ?>
                                <div class="ratio ratio-1x1 border border-secondary-subtle cursor-pointer">
                                    <img src="<?= $imagen->url_image ?>"
                                         alt="<?= $productoSeleccionado->nombre ?>"
                                         class="object-fit-cover">
                                </div>
                            <?php endforeach; ?>

                            <?php if(count($imagenesProducto) < 3): ?>
                                <?php for($i = count($imagenesProducto); $i < 3; $i++): ?>
                                    <div class="ratio ratio-1x1 border border-secondary-subtle">
                                        <img src="assets/img/placeholder.jpg" alt="Sin imagen" class="object-fit-cover">
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </div>

                        <div class="col-9 col-md-9">

                            <div class="ratio ratio-4x3 text-center mb-3 border border-secondary-subtle">
                                <?php if(!empty($imagenesProducto[0])): ?>
                                    <img src="<?= $imagenesProducto[0]->url_image ?>"
                                         alt="<?= $productoSeleccionado->nombre ?>"
                                         class="object-fit-contain p-3">
                                <?php else: ?>
                                    <img src="assets/img/placeholder.jpg" alt="Sin imagen" class="object-fit-contain p-3">
                                <?php endif; ?>
                            </div>

                            <div class="row justify-content-center g-2">
                                <?php
                                // Mostrar miniaturas inferiores (siguientes 3 imágenes)
                                $imagenesInferiores = array_slice($imagenesProducto, 3, 3);
                                for($i = 0; $i < 3; $i++):
                                ?>
                                    <div class="col-4">
                                        <div class="ratio ratio-1x1 border border-secondary-subtle cursor-pointer">
                                            <?php if(isset($imagenesInferiores[$i])): ?>
                                                <img src="<?= $imagenesInferiores[$i]->url_image ?>"
                                                     alt="<?= $productoSeleccionado->nombre ?>"
                                                     class="object-fit-cover">
                                            <?php else: ?>
                                                <img src="assets/img/placeholder.jpg" alt="Sin imagen" class="object-fit-cover">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-5 ps-md-5">

                    <h5 class="fw-bold mb-1"><?= $productoSeleccionado->marca ?></h5>
                    <h2 class="fs-3 fw-normal mb-3"><?= $productoSeleccionado->nombre ?></h2>

                    <div class="mb-4 text-dark">
                        <?php
                        // Calcular promedio de valoraciones
                        $promedioData = ControladorValoracion::obtenerPromedioValoracion($productoSeleccionado->id_producto);
                        $promedio = $promedioData ? round($promedioData->promedio, 1) : 0;
                        $totalValoraciones = $promedioData ? $promedioData->total : 0;
                        ?>
                        <span class="me-2 fw-bold"><?= $promedio ?></span>
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <?php if($i <= $promedio): ?>
                                <i class="bi bi-star-fill text-warning"></i>
                            <?php else: ?>
                                <i class="bi bi-star"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <span class="ms-2 text-muted small">(<?= $totalValoraciones ?> <?= $totalValoraciones == 1 ? 'valoración' : 'valoraciones' ?>)</span>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-baseline gap-2">
                            <span class="text-danger fw-bold fs-3"><?= number_format($productoSeleccionado->precio, 2) ?>€</span>
                            <span class="text-muted small">IVA incluido</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Talla:</label>
                        <p class="mb-1"><?= $productoSeleccionado->talla ?></p>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Color:</label>
                        <p class="mb-1"><?= $productoSeleccionado->color ?></p>
                    </div>

                    <div class="d-flex gap-3 align-items-center">
                        <a href="cesta.php" class="btn btn-dark w-100 py-2 fw-bold rounded-0"> 
                            <button class="btn btn-dark ">
                                Añadir a la cesta
                            </button>
                        </a>
                        <button class="btn border-0" type="button">
                            <i class="far fa-heart fa-lg"></i>
                        </button>
                    </div>

                </div>
            </div>

            <!-- Sección de Valoraciones -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="font-titulos mb-4">Valoraciones de clientes</h3>

                    <?php if(!empty($mensaje)) echo $mensaje; ?>

                    <!-- Formulario para nueva valoración -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="mb-3">Escribe tu valoración</h5>

                            <?php if(!isset($_SESSION['id_usuario'])): ?>
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    Debes <a href="login.php" class="alert-link">iniciar sesión</a> para agregar una valoración.
                                </div>
                            <?php else: ?>
                                <form method="post" action="">
                                    <input type="hidden" name="idProducto" value="<?= $productoSeleccionado->id_producto ?>">

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Puntuación *</label>
                                        <div class="d-flex gap-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="puntuacion" id="star1" value="1" required>
                                                <label class="form-check-label" for="star1">
                                                    1 <i class="bi bi-star-fill text-warning"></i>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="puntuacion" id="star2" value="2">
                                                <label class="form-check-label" for="star2">
                                                    2 <i class="bi bi-star-fill text-warning"></i>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="puntuacion" id="star3" value="3">
                                                <label class="form-check-label" for="star3">
                                                    3 <i class="bi bi-star-fill text-warning"></i>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="puntuacion" id="star4" value="4">
                                                <label class="form-check-label" for="star4">
                                                    4 <i class="bi bi-star-fill text-warning"></i>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="puntuacion" id="star5" value="5">
                                                <label class="form-check-label" for="star5">
                                                    5 <i class="bi bi-star-fill text-warning"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="comentario" class="form-label fw-bold">Comentario (opcional)</label>
                                        <!-- Editor Quill -->
                                        <div id="quill-editor" style="height: 200px;"></div>
                                        <!-- Campo oculto para almacenar el contenido -->
                                        <input type="hidden" id="comentario" name="comentario">
                                    </div>

                                    <button type="submit" name="enviar_valoracion" class="btn btn-primary" onclick="return submitValoracion()">
                                        <i class="bi bi-send-fill me-2"></i>Enviar Valoración
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Lista de valoraciones existentes -->
                    <div class="row g-3">
                        <?php if(!empty($valoraciones)): ?>
                            <?php foreach($valoraciones as $valoracion): ?>
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1 fw-bold">
                                                    <?= $valoracion->nombre_usuario ?? 'Usuario' ?>
                                                    <?= $valoracion->apellido1 ?? '' ?>
                                                </h6>
                                            </div>
                                            <div class="text-warning">
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                    <i class="<?= $i <= $valoracion->puntuacion ? 'bi bi-star-fill' : 'bi bi-star' ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <?php if(!empty($valoracion->comentario)): ?>
                                            <div class="mb-0 text-muted ql-editor" style="padding: 0;">
                                                <?= $valoracion->comentario ?>
                                            </div>
                                        <?php else: ?>
                                            <p class="mb-0 text-muted fst-italic">Sin comentario</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="text-center py-5 text-muted">
                                    <i class="bi bi-chat-left-text fs-1 d-block mb-2"></i>
                                    <p>Todavía no hay valoraciones. ¡Sé el primero en valorar este producto!</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

            <?php else: ?>
                <!-- Mensaje si no hay producto seleccionado -->
                <div class="alert alert-warning text-center py-5">
                    <i class="bi bi-exclamation-triangle-fill fs-1 d-block mb-3"></i>
                    <h4>No hay producto seleccionado</h4>
                    <p class="mb-3">Por favor, selecciona un producto desde la página principal.</p>
                    <a href="index.php" class="btn btn-primary">Volver al inicio</a>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <?php include "includes/footer.php"; ?>

    <script>
        // Inicializar Quill solo si el usuario está logueado
        <?php if(isset($_SESSION['id_usuario']) && $productoSeleccionado): ?>
        var quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Cuéntanos tu experiencia con este producto...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'color': [] }, { 'background': [] }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        // Función para enviar el formulario
        function submitValoracion() {
            // Obtener el contenido HTML del editor
            var comentarioHTML = quill.root.innerHTML;

            // Si el editor está vacío, enviar cadena vacía
            if (quill.getText().trim().length === 0) {
                comentarioHTML = '';
            }

            // Asignar el contenido al campo oculto
            document.getElementById('comentario').value = comentarioHTML;

            return true; // Permitir el envío del formulario
        }
        <?php endif; ?>
    </script>
</body>

</html>