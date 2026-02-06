<?php
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

include("includes/a_config.php");
require_once './controlador/ControladorProducto.php';

// Manejar clic en producto para guardar ID en sesión
if(isset($_GET['producto_id'])) {
    $_SESSION['producto_seleccionado'] = intval($_GET['producto_id']);
    header("Location: vistaprevia.php");
    exit;
}

// Obtener productos favoritos (con límite de 8 para ejemplo)
$controladorProducto = new ControladorProducto();
$productosFavoritos = $controladorProducto->obtenerProductosConImagenes(8);
?>
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
            <h2 class="mb-4">Mis Favoritos</h2>
            <div class="row">
                <?php if(!empty($productosFavoritos)): ?>
                    <?php foreach($productosFavoritos as $producto): ?>
                        <div class="col-6 col-md-4 mb-4">
                            <div class="card tarjetasProductos font-small h-100">
                                <a href="favoritos.php?producto_id=<?= $producto->id_producto ?>" class="text-decoration-none text-dark">
                                    <?php if(!empty($producto->url_image)): ?>
                                        <img src="<?= $producto->url_image ?>"
                                             class="card-img-top"
                                             alt="<?= $producto->nombre ?>">
                                    <?php else: ?>
                                        <img src="assets/img/placeholder.jpg"
                                             class="card-img-top"
                                             alt="Sin imagen">
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
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center py-5">
                            <i class="bi bi-heart fs-1 d-block mb-3"></i>
                            <h4>No tienes productos favoritos</h4>
                            <p>Agrega productos a tus favoritos para verlos aquí.</p>
                            <a href="listadoProductos.php" class="btn btn-primary mt-3">Ver productos</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <?php include "includes/footer.php"; ?>
</body>

</html>