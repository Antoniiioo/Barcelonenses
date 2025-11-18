<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "includes/design-top.php"; ?>
    <?php include "includes/navigation.php"; ?>

    <main class="container-fluid row justify-content-center flex-grow-1">
        <div class="col-lg-10 col-xl-9">
            <h1 class="text-center mb-4 mt-4 font-titulos">Crea tu cuenta</h1>

            <div class="col-md-10 col-lg-8 mx-auto">
                <form action="/register" method="post" autocomplete="on">

                    <div class="row mb-3 justify-content-center">
                        <label for="nombre" class="col-sm-4 col-form-label text-sm-start">Nombre *</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control border-secondary" id="nombre" name="nombre" required
                                autocomplete="given-name">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="apellidos" class="col-sm-4 col-form-label text-sm-start">Apellidos *</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control border-secondary" id="apellidos" name="apellidos"
                                required autocomplete="family-name">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="email" class="col-sm-4 col-form-label text-sm-start">Dirección e-mail *</label>
                        <div class="col-sm-7">
                            <input type="email" class="form-control border-secondary" id="email" name="email" required
                                autocomplete="email">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="telefono" class="col-sm-4 col-form-label text-sm-start">Teléfono móvil *</label>
                        <div class="col-sm-7">
                            <input type="tel" class="form-control border-secondary" id="telefono" name="telefono"
                                required autocomplete="tel">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="contrasena" class="col-sm-4 col-form-label text-sm-start">Contraseña *</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control border-secondary" id="contrasena"
                                name="contrasena" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="confirmar-contrasena" class="col-sm-4 col-form-label text-sm-start">Confirmar
                            contraseña *</label>
                        <div class="col-sm-7 mb-3">
                            <input type="password" class="form-control border-secondary" id="confirmar-contrasena"
                                name="confirmar_contrasena" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-3 mt-4">
                        <div class="col-12 d-flex justify-content-center flex-wrap gap-2">
                            <a href="login.php" class="btn btn-info">YA TENGO CUENTA</a>
                            <button type="submit" class="btn btn-primary">REGISTRAR</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </main>

    <?php include "includes/footer.php"; ?>
</body>

</html>