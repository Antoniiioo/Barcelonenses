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

    <main>
        <section class="row container-fluid">
            <div class="bg-primary col-3 text-center align-content-center">
                <h2 class="h1 text-white font-titulos">Puede que te interese:</h2>
            </div>
            <div class="bg-secondary col-9 container-fluid">
                <div class="row p-4">
                    <a href="" class="text-decoration-none">
                        <div class="card col-3">
                            <img src="assets/img/camisetaAdidas.webp" class="card-img-top img-fluid">
                            <div class="card-body border-top">
                                <p class="font-marcas">Adidas</p>
                                <p class="font-texto">Camiseta blanca Adidas</p>
                                <p>10€</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>
        <section>
            <div>
                <a href="">
                    <img src="" alt="Foto">
                    <p>Niño</p>
                </a>
            </div>
            <div>
                <a href="">
                    <img src="" alt="Foto">
                    <p>Hombre</p>
                </a>
            </div>
            <div>
                <a href="">
                    <img src="" alt="Foto">
                    <p>Mujer</p>
                </a>
            </div>
        </section>
    </main>
    <!--Footer-->
    <?php include "includes/footer.php"; ?>
</body>

</html>