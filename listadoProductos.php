<?php
session_start();
include("includes/a_config.php");
require_once './controlador/ControladorProducto.php';

// Manejar clic en producto para guardar ID en sesión
if(isset($_GET['producto_id'])) {
    $_SESSION['producto_seleccionado'] = intval($_GET['producto_id']);
    header("Location: vistaprevia.php");
    exit;
}

// Obtener todos los productos con imágenes
$controladorProducto = new ControladorProducto();
$todosProductos = $controladorProducto->obtenerProductosConImagenes();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "includes/design-top.php"; ?>
    <?php include "includes/navigation.php"; ?>
    <main class="flex-grow-1 container-fuid m-auto">
        <form action="" class="row mx-md-5 mx-2 my-4">
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
            <?php if(!empty($todosProductos)): ?>
                <?php foreach($todosProductos as $producto): ?>
                    <div class="col-6 col-md-3 mb-4">
                        <div class="card tarjetasProductos font-small h-100">
                            <a href="listadoProductos.php?producto_id=<?= $producto->id_producto ?>" class="text-decoration-none text-dark">
                                <?php if(!empty($producto->url_image)): ?>
                                    <img src="<?= $producto->url_image ?>"
                                         class="card-img-top"
                                         alt="<?= $producto->nombre ?>">
                                <?php else: ?>
                                    <img src="assets/img/placeholder.jpg" class="card-img-top" alt="Sin imagen">
                                <?php endif; ?>
                                <div class="card-body border-top">
                                    <p class="font-marcas"><?= $producto->marca ?></p>
                                    <p><?= $producto->nombre ?></p>
                                    <p class="font-medium"><?= number_format($producto->precio, 2) ?>€</p>
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
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center py-5">
                        <i class="bi bi-info-circle-fill fs-1 d-block mb-3"></i>
                        <h4>No hay productos disponibles</h4>
                        <p>Actualmente no hay productos en el catálogo.</p>
                    </div>
                </div>
            <?php endif; ?>

        </section>
    </main>
    <?php include "includes/footer.php"; ?>
</body>

</html>