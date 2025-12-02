<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "includes/design-top.php"; ?>
    <?php include "includes/navigation.php"; ?>
    <main class="flex-grow-1 row container-fluid">
        <form action="" class="col-12 col-md-3 d-flex flex-column gap-5 pt-3 sticky-md-top align-self-start">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 border-secondary text-body">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control border-start-0 border-secondary" placeholder="Buscar">
                <button class="btn btn-primary" type="button">
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
            <div class="custom-select-wrapper">
                <select class="form-select overflow-hidden" aria-label="Selecciona una marca">
                    <option selected disabled>Marca</option>
                    <option>Adidas</option>
                    <option>Nike</option>
                    <option>New Balance</option>
                </select>
            </div>
            <div class="custom-select-wrapper">
                <select class="form-select overflow-hidden" aria-label="Selecciona una marca">
                    <option selected disabled>Genero</option>
                    <option>Hombre</option>
                    <option>Mujer</option>
                    <option>Niño</option>
                </select>
            </div>
        </form>
        <section class="mx-md-4 col-12 col-md-8">
            <div class="row">
                <?php for ($i = 0; $i < 10; $i++) { ?>
                    <div class="col-6 col-md-4">
                        <div class="card tarjetasProductos font-small">
                            <a href="vistaprevia.php" class="text-decoration-none text-dark">
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
                                        class="btn col-6 rounded-0 bg-danger text-white border-end py-3 d-flex align-items-center justify-content-center">
                                        <span class="bi bi-dash"></span> 
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
            </div>
        </section>
    </main>
    <?php include "includes/footer.php"; ?>
</body>

</html>