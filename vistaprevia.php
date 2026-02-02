<?php
session_start();
include("includes/a_config.php");

// Obtener valoraciones del producto (simuladas por ahora)
$valoraciones = [
    [
        'nombre' => 'Juan García',
        'fecha' => '15/01/2024',
        'puntuacion' => 5,
        'comentario' => 'Excelente producto, muy buena calidad y el envío fue rápido.'
    ],
    [
        'nombre' => 'María López',
        'fecha' => '10/01/2024',
        'puntuacion' => 4,
        'comentario' => 'Buena camiseta, aunque esperaba que fuera un poco más grande.'
    ],
    [
        'nombre' => 'Pedro Sánchez',
        'fecha' => '05/01/2024',
        'puntuacion' => 5,
        'comentario' => 'Perfecta, tal como se describe. Muy recomendable.'
    ]
];
?>
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

            <!-- Sección de Valoraciones -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="font-titulos mb-4">Valoraciones de clientes</h3>

                    <?php if(isset($mensaje)) echo $mensaje; ?>

                    <!-- Formulario para nueva valoración -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="mb-3">Escribe tu valoración</h5>
                            <form method="post" action="">
                                <input type="hidden" name="idProducto" value="1">

                                <div class="mb-3">
                                    <label class="form-label">Puntuación *</label>
                                    <div class="d-flex gap-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="puntuacion" id="star1" value="1" required>
                                            <label class="form-check-label" for="star1">
                                                1 <i class="fas fa-star text-warning"></i>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="puntuacion" id="star2" value="2">
                                            <label class="form-check-label" for="star2">
                                                2 <i class="fas fa-star text-warning"></i>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="puntuacion" id="star3" value="3">
                                            <label class="form-check-label" for="star3">
                                                3 <i class="fas fa-star text-warning"></i>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="puntuacion" id="star4" value="4">
                                            <label class="form-check-label" for="star4">
                                                4 <i class="fas fa-star text-warning"></i>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="puntuacion" id="star5" value="5">
                                            <label class="form-check-label" for="star5">
                                                5 <i class="fas fa-star text-warning"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="comentario" class="form-label">Comentario</label>
                                    <textarea class="form-control" id="comentario" name="comentario" rows="4"
                                              placeholder="Cuéntanos tu experiencia con este producto..."></textarea>
                                </div>

                                <button type="submit" name="enviar_valoracion" class="btn btn-primary">
                                    Enviar Valoración
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Lista de valoraciones existentes -->
                    <div class="row g-3">
                        <?php foreach($valoraciones as $valoracion): ?>
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1 fw-bold"><?= htmlspecialchars($valoracion['nombre']) ?></h6>
                                            <small class="text-muted"><?= $valoracion['fecha'] ?></small>
                                        </div>
                                        <div class="text-warning">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <i class="<?= $i <= $valoracion['puntuacion'] ? 'fas' : 'far' ?> fa-star"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-muted"><?= htmlspecialchars($valoracion['comentario']) ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if(empty($valoraciones)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-chat-left-text fs-1 d-block mb-2"></i>
                        <p>Todavía no hay valoraciones. ¡Sé el primero en valorar este producto!</p>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </main>

    <?php include "includes/footer.php"; ?>
</body>

</html>