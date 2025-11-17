<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "includes/head-tag-contents.php"; ?>
</head>

<body class="container-fluid d-flex flex-column h-100">
    <?php include "includes/design-top.php"; ?>
    <?php include "includes/navigation.php"; ?>

    <main class="row justify-content-center h-100">
        <div class="col-lg-10 col-xl-9">
            <h1 class="text-center mb-5">Crea tu cuenta</h1>
            <form action="/register" method="post" autocomplete="on" class="">
                <div class="row mb-3">
                    <label for="nombre" class="col-sm-4 col-form-label text-end">Nombre *</label>
                    <div class="col-sm-5 ">
                        <input type="text" class="form-control" id="nombre" name="nombre" required
                            autocomplete="given-name">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="apellidos" class="col-sm-4 text-end">Apellidos *</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="apellidos" name="apellidos" required
                            autocomplete="family-name">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-sm-4 col-form-label text-end">Dirección e-mail *</label>
                    <div class="col-sm-5">
                        <input type="email" class="form-control" id="email" name="email" required autocomplete="email">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="telefono" class="col-sm-4 col-form-label text-end">Teléfono móvil *</label>
                    <div class="col-sm-5">
                        <input type="tel" class="form-control" id="telefono" name="telefono" required
                            autocomplete="tel">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="contrasena" class="col-sm-4 col-form-label text-end">Contraseña *</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" id="contrasena" name="contrasena" required
                            autocomplete="new-password">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="confirmar-contrasena" class="col-sm-4 col-form-label text-end">Confirmar contraseña
                        *</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" id="confirmar-contrasena"
                            name="confirmar_contrasena" required autocomplete="new-password">
                    </div>
                </div>

                <div class="row mb-3 mt-4">
                    <div class="col-sm-6 offset-sm-4">
                        <div class="d-flex flex-wrap gap-2 ms-5">
                            <a href="/login" class="btn btn-info">YA TENGO CUENTA</a>
                            <button type="submit" class="btn btn-primary">REGISTRAR</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <?php include "includes/footer.php"; ?>
</body>

</html>