<?php
session_start();

include "includes/a_config.php";
include "includes/google_connect.php";
require_once './controlador/ControladorProducto.php';

// Manejar clic en producto para guardar ID en sesión
if(isset($_GET['producto_id'])) {
    $_SESSION['producto_seleccionado'] = intval($_GET['producto_id']);
    header("Location: vistaprevia.php");
    exit;
}

// Obtener productos con imágenes (límite 4 para "Puede que te interese")
$controladorProducto = new ControladorProducto();
$productosDestacados = $controladorProducto->obtenerProductosConImagenes(7);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="min-vh-100">
    <!--Encabezado-->
    <?php include "includes/design-top.php"; ?>
    <!--Menu-->
    <?php include "includes/navigation.php"; ?>

    <main class="container-fluid p-0">
        <section class="container-fluid p-0 m-0">
            <div class="row p-0 m-0">
                <div class="bg-primary col-12 col-md-3 p-4 text-center align-content-center">
                    <h2 class="fs-2 text-white font-titulos">Puede que te interese:</h2>
                </div>

                <div class="bg-secondary col-12 col-md-9 d-flex flex-nowrap overflow-auto p-2 p-md-4 gap-2 gap-md-4 align-items-start">
                    <?php if(!empty($productosDestacados)): ?>
                        <?php foreach($productosDestacados as $producto): ?>
                            <a href="index.php?producto_id=<?= $producto->id_producto ?>" class="text-decoration-none tarjetasProductos font-small">
                                <div class="card h-100">
                                    <?php if(!empty($producto->url_image)): ?>
                                        <img src="<?= $producto->url_image ?>"
                                             class="card-img-top img-fluid"
                                             alt="<?= $producto->nombre ?>">
                                    <?php else: ?>
                                        <img src="assets/img/placeholder.jpg"
                                             class="card-img-top img-fluid"
                                             alt="Sin imagen">
                                    <?php endif; ?>
                                    <div class="card-body border-top">
                                        <p class="font-marcas"><?= $producto->marca ?></p>
                                        <p><?= $producto->nombre ?></p>
                                        <p class="font-medium"><?= number_format($producto->precio, 2) ?>€</p>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-info w-100 m-3">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            No hay productos disponibles en este momento.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="video-contenedor">
            <video id="heroVideo" autoplay muted loop playsinline>
                <source src="./assets/video/anuncio.mp4" type="video/mp4">
            </video>

            <div class="overlay">
                <h2 class="video-titulo">Aprovecha nuestras maravillosas ofertas</h2>
            </div>

            <div class="video-controls" id="videoControls" aria-label="Controles del vídeo">
                <button type="button" id="btnPlay" aria-label="Reproducir">▶︎</button>
                <button type="button" id="btnMute" aria-label="Silenciar">🔊</button>
                <div class="progress-container" id="progressContainer" aria-hidden="false">
                    <div class="progress" id="videoProgress"></div>
                </div>
                <button type="button" id="btnFullscreen" aria-label="Pantalla completa">⤢</button>
            </div>

            <script src="./js/video_contros.js" defer></script>
        </section>

        <section class="container mt-4 mx-auto categorias">

            <div class="row g-0 border border-dark my-5">
                <a href="../listadoProductos.php"
                    class="col-12 col-md-4 d-flex align-items-center text-decoration-none text-black border border-dark">
                    <img src="../assets/img/fotoNinho.png" alt="Niño">
                    <p class="w-50 m-0 text-center text-uppercase fs-6 fw-bold">Niños</p>
                </a>
                <a href="../listadoProductos.php"
                    class="col-12 col-md-4 d-flex align-items-center text-decoration-none text-black border border-dark">
                    <img src="../assets/img/fotoHombre.png" alt="Hombre">
                    <p class="w-50 m-0 text-center text-uppercase fs-6 fw-bold">Hombre</p>
                </a>
                <a href="../listadoProductos.php" class="col-12 col-md-4 d-flex align-items-center text-decoration-none text-black border border-dark">
                    <img src="../assets/img/fotoMujer.png" alt="Mujer">
                    <p class="w-50 m-0 text-center text-uppercase fs-6 fw-bold">Mujer</p>
                </a>
            </div>
        </section>
    </main>

    <!-- Modal de Cookies Moderno -->
    <div class="cookies-modal-overlay" id="cookiesModalOverlay" style="display: none;">
        <div class="cookies-modal">
            <div class="cookies-modal-header">
                <div class="cookies-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M6 7.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm4.5.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm-.5 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                        <path d="M8 0a7.963 7.963 0 0 0-4.075 1.114q-.245.14-.445.294C1.304 3.14 0 5.398 0 8c0 4.411 3.589 8 8 8s8-3.589 8-8-3.589-8-8-8zm3.5 14.5A6.5 6.5 0 1 1 14.5 8a6.5 6.5 0 0 1-3 5.5z"/>
                    </svg>
                </div>
                <h2 class="cookies-title">Configuración de Cookies</h2>
                <p class="cookies-description">
                    Utilizamos cookies para mejorar tu experiencia de navegación. Puedes configurar qué tipos de cookies deseas aceptar.
                </p>
            </div>

            <div class="cookies-modal-body">
                <!-- Cookies Esenciales -->
                <div class="cookie-category">
                    <div class="cookie-category-header">
                        <div class="cookie-category-info">
                            <h3 class="cookie-category-title">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                                Cookies Esenciales
                            </h3>
                            <p class="cookie-category-description">
                                Estas cookies son necesarias para el funcionamiento básico del sitio web y no se pueden desactivar.
                            </p>
                        </div>
                        <div class="cookie-toggle">
                            <input type="checkbox" id="cookiesEsenciales" checked disabled>
                            <label for="cookiesEsenciales" class="toggle-label disabled">
                                <span class="toggle-switch"></span>
                            </label>
                            <span class="toggle-status">Siempre activas</span>
                        </div>
                    </div>
                </div>

                <!-- Cookies Opcionales -->
                <div class="cookie-category">
                    <div class="cookie-category-header">
                        <div class="cookie-category-info">
                            <h3 class="cookie-category-title">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                                    <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319z"/>
                                </svg>
                                Cookies de Análisis y Personalización
                            </h3>
                            <p class="cookie-category-description">
                                Estas cookies nos ayudan a entender cómo interactúas con el sitio y mejorar tu experiencia mediante contenido personalizado.
                            </p>
                        </div>
                        <div class="cookie-toggle">
                            <input type="checkbox" id="cookiesOpcionales" checked>
                            <label for="cookiesOpcionales" class="toggle-label">
                                <span class="toggle-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="cookies-modal-footer">
                    <button type="button" class="btn-cookies btn-cookies-rechazar" id="btnRechazarOpcionales">
                        Rechazar todas
                    </button>
                    <button type="button" class="btn-cookies btn-cookies-todas" id="btnAceptarTodas">
                        Aceptar todas
                    </button>
                </div>

                <div class="cookies-privacy-link">
                    <a href="privacidad.php" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        </svg>
                        Política de Privacidad y Cookies
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="js/modal-cookies.js"></script>

    <!--Footer-->
    <?php include "includes/footer.php"; ?>
</body>

</html>