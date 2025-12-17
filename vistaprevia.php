<?php include("includes/a_config.php"); ?>
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
            <div class="row">

                <div class="col-md-7 mb-4 mb-md-0">
                    <div class="row">

                        <div class="col-3 col-md-3 d-flex flex-column gap-2 justify-content-center">
                            <div class="ratio ratio-1x1 border border-secondary-subtle cursor-pointer">
                                <img src="../assets/img/camisetaAdidas.webp" alt="Vista Lat 1" class="object-fit-cover">
                            </div>
                            <div class="ratio ratio-1x1 border border-secondary-subtle cursor-pointer">
                                <img src="../assets/img/camisetaAdidas.webp" alt="Vista Lat 2" class="object-fit-cover">
                            </div>
                            <div class="ratio ratio-1x1 border border-secondary-subtle cursor-pointer">
                                <img src="../assets/img/camisetaAdidas.webp" alt="Vista Lat 3" class="object-fit-cover">
                            </div>
                        </div>

                        <div class="col-9 col-md-9">

                            <div class="ratio ratio-4x3 text-center mb-3 border border-secondary-subtle">
                                <img src="../assets/img/camisetaAdidas.webp" alt="Imagen Principal"
                                    class="object-fit-contain p-3">
                            </div>

                            <div class="row justify-content-center g-2">
                                <div class="col-4">
                                    <div class="ratio ratio-1x1 border border-secondary-subtle cursor-pointer">
                                        <img src="../assets/img/camisetaAdidas.webp" alt="Vista Inf 1"
                                            class="object-fit-cover">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="ratio ratio-1x1 border border-secondary-subtle cursor-pointer">
                                        <img src="../assets/img/camisetaAdidas.webp" alt="Vista Inf 2"
                                            class="object-fit-cover">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="ratio ratio-1x1 border border-secondary-subtle cursor-pointer">
                                        <img src="../assets/img/camisetaAdidas.webp" alt="Vista Inf 3"
                                            class="object-fit-cover">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-5 ps-md-5">

                    <h5 class="fw-bold mb-1">Adidas</h5>
                    <h2 class="fs-3 fw-normal mb-3">Camiseta adidas - blanca</h2>

                    <div class="mb-4 text-dark">
                        <span class="me-2 fw-bold">4.4</span>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-baseline gap-2">
                            <span class="text-danger fw-bold fs-3">10,00€</span>
                            <span class="text-muted small">IVA incluido</span>
                        </div>
                        <div class="text-muted small">
                            Precio original:
                            <span class="text-decoration-line-through">20,00€</span>
                            <span class="text-danger">-50%</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <select class="form-select border-secondary rounded-0" aria-label="Seleccionar talla">
                            <option selected disabled>One size</option>
                            <option value="1">S</option>
                            <option value="2">M</option>
                            <option value="3">L</option>
                            <option value="4">XL</option>
                        </select>
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
        </div>
    </main>

    <?php include "includes/footer.php"; ?>
</body>

</html>