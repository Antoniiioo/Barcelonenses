<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body>
    <!--Encabezado-->
    <?php include "includes/design-top.php"; ?>
    <!--Menu-->
    <?php include "includes/navigation.php"; ?>

    <main class="container-fluid">
        <section class="row">
            <div class="bg-primary col-3 text-center align-content-center">
                <h2 class="h1 text-white font-titulos">Puede que te interese:</h2>
            </div>

            <div class="bg-secondary col-9 d-flex flex-nowrap overflow-auto p-4 gap-4 align-items-center">

                <a href="" class="text-decoration-none tarjetasProductos" >
                    <div class="card h-100"> <img src="assets/img/camisetaAdidas.webp" class="card-img-top img-fluid">
                        <div class="card-body border-top">
                            <p class="font-marcas font">Adidas</p>
                            <p>Camiseta blanca Adidas</p>
                            <p>10€</p>
                        </div>
                    </div>
                </a>

                <a href="" class="text-decoration-none tarjetasProductos" >
                    <div class="card h-100">
                        <img src="assets/img/camisetaAdidas.webp" class="card-img-top img-fluid">
                        <div class="card-body border-top">
                            <p class="font-marcas font">Adidas</p>
                            <p>Camiseta blanca Adidas</p>
                            <p>10€</p>
                        </div>
                    </div>
                </a>

                <a href="" class="text-decoration-none tarjetasProductos" >
                    <div class="card h-100">
                        <img src="assets/img/camisetaAdidas.webp" class="card-img-top img-fluid">
                        <div class="card-body border-top">
                            <p class="font-marcas font">Adidas</p>
                            <p>Camiseta blanca Adidas</p>
                            <p>10€</p>
                        </div>
                    </div>
                </a>

                <a href="" class="text-decoration-none tarjetasProductos" >
                    <div class="card h-100">
                        <img src="assets/img/camisetaAdidas.webp" class="card-img-top img-fluid">
                        <div class="card-body border-top">
                            <p class="font-marcas font">Adidas</p>
                            <p>Camiseta blanca Adidas</p>
                            <p>10€</p>
                        </div>
                    </div>
                </a>

            </div>
        </section>
        <section class="container mt-4 mx-auto" style="max-width: 800px;">

            <div class="row g-0 border border-dark my-5">
                <a href="#"
                    class="col-4 d-flex align-items-center text-decoration-none text-black border-end border-dark">
                    <img src="assets/img/fotoNinho.png" alt="Niño" class="w-50 object-fit-cover" style="height: 200px;">
                    <p class="w-50 m-0 text-center text-uppercase fs-6 fw-bold">Niños</p>
                </a>
                <a href="#"
                    class="col-4 d-flex align-items-center text-decoration-none text-black border-end border-dark">
                    <img src="assets/img/fotoHombre.png" alt="Hombre" class="w-50 object-fit-cover"
                        style="height: 200px;">
                    <p class="w-50 m-0 text-center text-uppercase fs-6 fw-bold">Hombre</p>
                </a>
                <a href="#" class="col-4 d-flex align-items-center text-decoration-none text-black">
                    <img src="assets/img/fotoMujer.png" alt="Mujer" class="w-50 object-fit-cover"
                        style="height: 200px;">
                    <p class="w-50 m-0 text-center text-uppercase fs-6 fw-bold">Mujer</p>
                </a>
            </div>
        </section>
    </main>
    <!--Footer-->
    <?php include "includes/footer.php"; ?>
</body>

</html>