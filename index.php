<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <!--Encabezado-->
    <?php include "includes/design-top.php"; ?>
    <!--Menu-->
    <?php include "includes/navigation.php"; ?>

    <main class="container-fluid flex-grow-1">
        <section class="row">
            <div class="bg-primary col-4 col-md-3 text-center align-content-center">
                <h2 class="fs-md-3 text-white font-titulos">Puede que te interese:</h2>
            </div>

            <div class="bg-secondary col-8 col-md-9 d-flex flex-nowrap overflow-auto p-2 p-md-4 gap-2 gap-md-4 align-items-start">

                <?php for ($i = 0; $i < 10; $i++) { ?>
                    <a href="vistaprecia.php" class="text-decoration-none tarjetasProductos font-small">
                        <div class="card h-100">
                            <img src="assets/img/camisetaAdidas.webp" class="card-img-top img-fluid">
                            <div class="card-body border-top">
                                <p class="font-marcas">Adidas</p>
                                <p>Camiseta blanca Adidas</p>
                                <p class="font-medium">10€</p>
                            </div>
                        </div>
                    </a>
                    <?php } ?>

            </div>
        </section>
        <section class="container mt-4 mx-auto categorias">

            <div class="row g-0 border border-dark my-5">
                <a href="listadoProductos.php"
                    class="col-12 col-md-4 d-flex align-items-center text-decoration-none text-black border border-dark">
                    <img src="assets/img/fotoNinho.png" alt="Niño" class="w-50 object-fit-cover">
                    <p class="w-50 m-0 text-center text-uppercase fs-6 fw-bold">Niños</p>
                </a>
                <a href="listadoProductos.php"
                    class="col-12 col-md-4 d-flex align-items-center text-decoration-none text-black border border-dark">
                    <img src="assets/img/fotoHombre.png" alt="Hombre" class="w-50 object-fit-cover">
                    <p class="w-50 m-0 text-center text-uppercase fs-6 fw-bold">Hombre</p>
                </a>
                <a href="listadoProductos.php" class="col-12 col-md-4 d-flex align-items-center text-decoration-none text-black border border-dark">
                    <img src="assets/img/fotoMujer.png" alt="Mujer" class="w-50 object-fit-cover">
                    <p class="w-50 m-0 text-center text-uppercase fs-6 fw-bold">Mujer</p>
                </a>
            </div>
        </section>
    </main>
    <!--Footer-->
    <?php include "includes/footer.php"; ?>
</body>

</html>