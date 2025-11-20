<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="d-flex flex-column h-100">
    <?php include "includes/design-top.php"; ?>
    <?php include "includes/navigation.php"; ?>

    <main class="py-5">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 mb-5 mb-lg-0">
                    <h4 class="fw-bold mb-4 fs-5">Tu cesta (1 artículo)</h4>

                    <div class="mb-3">
                        <div class="text-center mb-3">
                            <img src="/assets/img/camisetaAdidas.webp" alt="camiseta adidas" class="img-fluid">
                        </div>
                        <h5 class="fw-bold mb-1">Adidas</h5>
                        <p class="mb-1 text-muted">Camiseta adidas blanca - camisetas</p>

                        <div class="mb-2">
                            <span class="text-danger fw-bold fs-5">10,00 €</span>
                        </div>

                        <div class="small text-muted mb-3">
                            Precio original: <span class="text-decoration-line-through">20,00 €</span> <span
                                class="text-danger">-50%</span><br>
                            Color: blanco<br>
                            Talla: m
                        </div>

                        <div class="mb-3">
                            <select class="form-select form-select-sm border-secondary">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2 align-items-center">
                            <button class="btn btn-danger text-white btn-sm rounded-0 px-3" type="button">
                                -
                            </button>
                            <button class="btn border-0" type="button">
                                <i class="far fa-heart fa-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 mb-5 mb-lg-0 px-lg-4">

                    <div class="border border-dark p-2 text-center mb-4">
                        <span class="fw-bold small">Dirección de envío</span>
                    </div>

                    <form>
                        <div class="mb-3 border border-dark p-1">
                            <label class="small fw-bold ps-2">Nombre:</label>
                            <input type="text" class="form-control border-0 p-1 ps-2 shadow-none" required>
                        </div>

                        <div class="mb-3 border border-dark p-1">
                            <label class="small fw-bold ps-2">Apellidos:</label>
                            <input type="text" class="form-control border-0 p-1 ps-2 shadow-none" required>
                        </div>

                        <div class="mb-3 border border-dark p-1">
                            <label class="small fw-bold ps-2">Codigo postal:</label>
                            <input type="text" class="form-control border-0 p-1 ps-2 shadow-none" required>
                        </div>

                        <div class="mb-3 border border-dark p-1">
                            <label class="small fw-bold ps-2">Dirección:</label>
                            <input type="text" class="form-control border-0 p-1 ps-2 shadow-none" required>
                        </div>

                        <div class="mb-3 border border-dark p-1">
                            <label class="small fw-bold ps-2">Mas información:</label>
                            <input type="text" class="form-control border-0 p-1 ps-2 shadow-none">
                        </div>

                        <div class="mb-4 border border-dark p-1">
                            <label class="small fw-bold ps-2">Población</label>
                            <input type="text" class="form-control border-0 p-1 ps-2 shadow-none" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-black bg-black text-white rounded-4 px-4 py-2">
                                Guardar dirección
                            </button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4">

                    <div class="d-grid gap-2 mb-4">
                        <button class="btn btn-outline-secondary border-primary-subtle text-dark py-2"
                            type="button">Contrarrembolso</button>
                        <button class="btn btn-outline-secondary border-primary-subtle text-dark py-2"
                            type="button">Tarjeta de crédito</button>
                        <button class="btn text-white py-2" 
                            type="button">PayPal</button>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>20,00 €</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Descuento:</span>
                            <span>10,00 €</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span>Envío:</span>
                            <span>0,00 €</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold fs-5 mb-5">
                            <span>Total con IVA:</span>
                            <span>10,00 €</span>
                        </div>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-black bg-black text-white rounded-4 px-4 py-2">
                            Confirmar pedido
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </main>

    <?php include "includes/footer.php"; ?>
</body>

</html>