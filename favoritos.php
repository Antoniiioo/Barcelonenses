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
        <form action="" class="col-3 d-flex flex-column gap-5 mt-3 sticky-top align-self-start"
            style="top: 20px; z-index: 1;">
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
        <div class="col-2"></div>
        <section class="col-7">
            <div class="row">
                <div class="col-3">
                    <div class="card tarjetasProductos">
                        <a href="" class="text-decoration-none text-dark">
                            <img src="assets/img/camisetaAdidas.webp" class="card-img-top">
                            <div class="card-body border-top">
                                <p class="font-marcas">Adidas</p>
                                <p>Camiseta blanca Adidas</p>
                                <p>10€</p>
                            </div>
                        </a>
                        <div class="card-footer bg-white p-0 overflow-hidden">
                            <div class="row g-0">
                                <a href=""
                                    class="btn col-6 rounded-0 bg-danger text-white border-end py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-dash"></span> </a>
                                <a href=""
                                    class="btn col-6 rounded-0 bg-info text-white py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-cart"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card tarjetasProductos">
                        <a href="" class="text-decoration-none text-dark">
                            <img src="assets/img/camisetaAdidas.webp" class="card-img-top">
                            <div class="card-body border-top">
                                <p class="font-marcas">Adidas</p>
                                <p>Camiseta blanca Adidas</p>
                                <p>10€</p>
                            </div>
                        </a>
                        <div class="card-footer bg-white p-0 overflow-hidden">
                            <div class="row g-0">
                                <a href=""
                                    class="btn col-6 rounded-0 bg-danger text-white border-end py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-dash"></span> </a>
                                <a href=""
                                    class="btn col-6 rounded-0 bg-info text-white py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-cart"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card tarjetasProductos">
                        <a href="" class="text-decoration-none text-dark">
                            <img src="assets/img/camisetaAdidas.webp" class="card-img-top">
                            <div class="card-body border-top">
                                <p class="font-marcas">Adidas</p>
                                <p>Camiseta blanca Adidas</p>
                                <p>10€</p>
                            </div>
                        </a>
                        <div class="card-footer bg-white p-0 overflow-hidden">
                            <div class="row g-0">
                                <a href=""
                                    class="btn col-6 rounded-0 bg-danger text-white border-end py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-dash"></span> </a>
                                <a href=""
                                    class="btn col-6 rounded-0 bg-info text-white py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-cart"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card tarjetasProductos">
                        <a href="" class="text-decoration-none text-dark">
                            <img src="assets/img/camisetaAdidas.webp" class="card-img-top">
                            <div class="card-body border-top">
                                <p class="font-marcas">Adidas</p>
                                <p>Camiseta blanca Adidas</p>
                                <p>10€</p>
                            </div>
                        </a>
                        <div class="card-footer bg-white p-0 overflow-hidden">
                            <div class="row g-0">
                                <a href=""
                                    class="btn col-6 rounded-0 bg-danger text-white border-end py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-dash"></span> </a>
                                <a href=""
                                    class="btn col-6 rounded-0 bg-info text-white py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-cart"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card tarjetasProductos">
                        <a href="" class="text-decoration-none text-dark">
                            <img src="assets/img/camisetaAdidas.webp" class="card-img-top">
                            <div class="card-body border-top">
                                <p class="font-marcas">Adidas</p>
                                <p>Camiseta blanca Adidas</p>
                                <p>10€</p>
                            </div>
                        </a>
                        <div class="card-footer bg-white p-0 overflow-hidden">
                            <div class="row g-0">
                                <a href=""
                                    class="btn col-6 rounded-0 bg-danger text-white border-end py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-dash"></span> </a>
                                <a href=""
                                    class="btn col-6 rounded-0 bg-info text-white py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-cart"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card tarjetasProductos">
                        <a href="" class="text-decoration-none text-dark">
                            <img src="assets/img/camisetaAdidas.webp" class="card-img-top">
                            <div class="card-body border-top">
                                <p class="font-marcas">Adidas</p>
                                <p>Camiseta blanca Adidas</p>
                                <p>10€</p>
                            </div>
                        </a>
                        <div class="card-footer bg-white p-0 overflow-hidden">
                            <div class="row g-0">
                                <a href=""
                                    class="btn col-6 rounded-0 bg-danger text-white border-end py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-dash"></span> </a>
                                <a href=""
                                    class="btn col-6 rounded-0 bg-info text-white py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-cart"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card tarjetasProductos">
                        <a href="" class="text-decoration-none text-dark">
                            <img src="assets/img/camisetaAdidas.webp" class="card-img-top">
                            <div class="card-body border-top">
                                <p class="font-marcas">Adidas</p>
                                <p>Camiseta blanca Adidas</p>
                                <p>10€</p>
                            </div>
                        </a>
                        <div class="card-footer bg-white p-0 overflow-hidden">
                            <div class="row g-0">
                                <a href=""
                                    class="btn col-6 rounded-0 bg-danger text-white border-end py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-dash"></span> </a>
                                <a href=""
                                    class="btn col-6 rounded-0 bg-info text-white py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-cart"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card tarjetasProductos">
                        <a href="" class="text-decoration-none text-dark">
                            <img src="assets/img/camisetaAdidas.webp" class="card-img-top">
                            <div class="card-body border-top">
                                <p class="font-marcas">Adidas</p>
                                <p>Camiseta blanca Adidas</p>
                                <p>10€</p>
                            </div>
                        </a>
                        <div class="card-footer bg-white p-0 overflow-hidden">
                            <div class="row g-0">
                                <a href=""
                                    class="btn col-6 rounded-0 bg-danger text-white border-end py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-dash"></span> </a>
                                <a href=""
                                    class="btn col-6 rounded-0 bg-info text-white py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-cart"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card tarjetasProductos">
                        <a href="" class="text-decoration-none text-dark">
                            <img src="assets/img/camisetaAdidas.webp" class="card-img-top">
                            <div class="card-body border-top">
                                <p class="font-marcas">Adidas</p>
                                <p>Camiseta blanca Adidas</p>
                                <p>10€</p>
                            </div>
                        </a>
                        <div class="card-footer bg-white p-0 overflow-hidden">
                            <div class="row g-0">
                                <a href=""
                                    class="btn col-6 rounded-0 bg-danger text-white border-end py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-dash"></span> </a>
                                <a href=""
                                    class="btn col-6 rounded-0 bg-info text-white py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-cart"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card tarjetasProductos">
                        <a href="" class="text-decoration-none text-dark">
                            <img src="assets/img/camisetaAdidas.webp" class="card-img-top">
                            <div class="card-body border-top">
                                <p class="font-marcas">Adidas</p>
                                <p>Camiseta blanca Adidas</p>
                                <p>10€</p>
                            </div>
                        </a>
                        <div class="card-footer bg-white p-0 overflow-hidden">
                            <div class="row g-0">
                                <a href=""
                                    class="btn col-6 rounded-0 bg-danger text-white border-end py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-dash"></span> </a>
                                <a href=""
                                    class="btn col-6 rounded-0 bg-info text-white py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-cart"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card tarjetasProductos">
                        <a href="" class="text-decoration-none text-dark">
                            <img src="assets/img/camisetaAdidas.webp" class="card-img-top">
                            <div class="card-body border-top">
                                <p class="font-marcas">Adidas</p>
                                <p>Camiseta blanca Adidas</p>
                                <p>10€</p>
                            </div>
                        </a>
                        <div class="card-footer bg-white p-0 overflow-hidden">
                            <div class="row g-0">
                                <a href=""
                                    class="btn col-6 rounded-0 bg-danger text-white border-end py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-dash"></span> </a>
                                <a href=""
                                    class="btn col-6 rounded-0 bg-info text-white py-3 d-flex align-items-center justify-content-center">
                                    <span class="bi bi-cart"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include "includes/footer.php"; ?>
</body>

</html>