<?php include "includes/a_config.php"; ?>
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

                    <a href="../vistaprevia.php" class="text-decoration-none tarjetasProductos font-small">
                        <div class="card h-100">
                            <img src="../assets/img/camisetaAdidas.webp" class="card-img-top img-fluid">
                            <div class="card-body border-top">
                                <p class="font-marcas">Adidas</p>
                                <p>Camiseta blanca Adidas</p>
                                <p class="font-medium">10€</p>
                            </div>
                        </div>
                    </a>

                    <a href="vistaprevia.php" class="text-decoration-none tarjetasProductos font-small">
                        <div class="card h-100">
                            <img src="assets/img/pantalonNike.jpg" class="card-img-top img-fluid">
                            <div class="card-body border-top">
                                <p class="font-marcas">Nike</p>
                                <p>Pantalon blanca Nike</p>
                                <p class="font-medium">39€</p>
                            </div>
                        </div>
                    </a>

                    <a href="vistaprevia.php" class="text-decoration-none tarjetasProductos font-small">
                        <div class="card h-100">
                            <img src="assets/img/chaquetonNorth.jpg" class="card-img-top img-fluid">
                            <div class="card-body border-top">
                                <p class="font-marcas">The North Face</p>
                                <p>Chaquetón North Face</p>
                                <p class="font-medium">219€</p>
                            </div>
                        </div>
                    </a>

                    <a href="vistaprevia.php" class="text-decoration-none tarjetasProductos font-small">
                        <div class="card h-100">
                            <img src="assets/img/unnamed.jpg" class="card-img-top img-fluid">
                            <div class="card-body border-top">
                                <p class="font-marcas">Scuffer</p>
                                <p>Sudadera Scuffer rosa</p>
                                <p class="font-medium">79€</p>
                            </div>
                        </div>
                    </a>


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
    <!--Footer-->
    <?php include "includes/footer.php"; ?>
</body>

</html>