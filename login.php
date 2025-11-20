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
        <div class="col-md-10">

            <h1 class="text-center mt-5 mb-3 font-titulos">Inicio sesion</h1>

            <div class="col-md-8 mx-auto">
                <form action="/login" method="post">

                    <div class="mb-3">
                        <label for="username" class="form-label ">Usuario:</label>
                        <input type="text" class="form-control border-secondary" id="username" name="username" required
                            autocomplete="username">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <div class="input-group">
                            <input type="password" class="form-control border-secondary" id="password" name="password" required
                                autocomplete="current-password">
                            <button class="btn btn-primary" type="submit" aria-label="Iniciar sesión"><i
                                    class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>

                    <div class="text-center mt-4 mb-4 d-flex justify-content-center flex-wrap gap-2">
                        <a href="registro.php" class="text-dark">No tienes
                            cuenta</a>
                        <span class="text-muted">|</span>
                        <a href="/forgot-password" class="text-dark">Has
                            olvidado la contraseña</a>
                    </div>

                    <div class="d-grid gap-3 mt-2">
                        <button type="button" class="btn btn-outline-secondary py-2 d-flex align-items-center justify-content-center">
                            <i class="fab fa-google fa-lg me-2 text-dark"></i><p class="text-dark my-auto"> Autentificase con Google</p>
                        </button>
                        <button type="button" class="btn btn-outline-secondary py-2 d-flex align-items-center justify-content-center">
                            <i class="fab fa-apple fa-lg me-2 text-dark"></i><p class="text-dark my-auto"> Autentificase con Apple</p>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php include "includes/footer.php"; ?>
</body>

</html>