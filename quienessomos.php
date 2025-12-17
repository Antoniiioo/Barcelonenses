<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "includes/design-top.php"; ?>
    <?php include "includes/navigation.php"; ?>
    <main class="container-fluid my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 d-flex justify-content-center">
                <div class="text-center mb-4 w-50">
                    <img src="assets/img/quienesSomos.png" alt="Equipo R&V" class="img-fluid">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 bg-primary text-white text-center py-2">
                <h2 class="m-0 font-titulos fs-2">Quienes somos</h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-10 col-md-8 font-medium">
                <div class="p-4 text-center">
                    <p class="mb-0">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                        but also the leap into electronic typesetting, remaining essentially unchanged. It was
                        popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                        and more recently with desktop publishing software like Aldus PageMaker including versions of
                        Lorem Ipsum.
                    </p>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center gap-3">
                    <a href="./JuegoAntonio/index.php" class="botonJuego">
                        <img src="../assets/img/arkanoid.png">
                        <p>Juego de Antonio</p>
                    </a>
                    <a href="./JuegoRuben/juego.html" class="botonJuego">
                        <img src="../assets/img/flapy.png">
                        <p>Juego de Ruben</p>
                    </a>
                </div>
            </div>
        </div>

    </main>

    <?php include "includes/footer.php"; ?>
</body>

</html>