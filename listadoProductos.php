<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "includes/design-top.php"; ?>
    <?php include "includes/navigation.php"; ?>
    <main class="flex-grow-1 container">
        <form action="" class="row mx-5 my-4">
            <div class="col-6 my-2 my-md-0 col-md-3">
                <div class="custom-select-wrapper">
                    <select class="form-select overflow-hidden" aria-label="Selecciona una marca">
                        <option selected disabled>Marca</option>
                        <option>Adidas</option>
                        <option>Nike</option>
                        <option>New Balance</option>
                    </select>
                </div>
            </div>
            <div class="col-6 my-2 my-md-0 col-md-3">
                <div class="custom-select-wrapper">
                    <select class="form-select overflow-hidden" aria-label="Selecciona una marca">
                        <option selected disabled>Color</option>
                        <option>Rojo</option>
                        <option>Azul</option>
                        <option>Amarillo</option>
                    </select>
                </div>
            </div>
            <div class="col-6 my-2 my-md-0 col-md-3">
                <div class="custom-select-wrapper">
                    <select class="form-select overflow-hidden" aria-label="Selecciona una marca">
                        <option selected disabled>Tipo</option>
                        <option>Pantalon</option>
                        <option>Camiseta</option>
                        <option>Rejoj</option>
                    </select>
                </div>
            </div>
            <div class="col-6 my-2 my-md-0 col-md-3">
                <div class="custom-select-wrapper">
                    <select class="form-select overflow-hidden" aria-label="Selecciona una marca">
                        <option selected disabled>Ordenar</option>
                        <option>Precio menor a mayor</option>
                        <option>Precio mayor a menor</option>
                        <option>Mas relevantes</option>
                    </select>
                </div>
            </div>
        </form>
        <section class="row mx-5 my-4">
            <?php for ($i = 0; $i < 10; $i++) { ?>
                <div class="col-6 col-md-4">
                    <div class="card tarjetasProductos font-small">
                        <a href="" class="text-decoration-none text-dark">
                            <img src="assets/img/camisetaAdidas.webp" class="card-img-top">
                            <div class="card-body border-top">
                                <p class="font-marcas">Adidas</p>
                                <p>Camiseta blanca Adidas</p>
                                <p class="font-medium">10€</p>
                            </div>
                        </a>
                        <div class="card-footer bg-white p-0 overflow-hidden">
                            <form action="" method="post" class="row g-0">
                                <button type="submit"
                                    class="btn col-6 rounded-0 border-end py-3 d-flex align-items-center justify-content-center hover-gray">
                                    <span class="bi bi-heart"></span> 
                                </button>
                                <button type="submit"
                                    class="btn col-6 rounded-0 bg-info text-white py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-cart"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </section>
    </main>
    <?php include "includes/footer.php"; ?>
</body>

</html>