<header class="d-flex justify-content-between align-items-center px-4 py-2">
    <a href="../index.php" class="text-decoration-none text-dark">
        <div class="d-flex align-items-center gap-2">
            <img src="assets/img/Logo.png" alt="Logo" class="logo img-fluid">
            <h1 class="m-0 font-titulos fs-4">R&V</h1>
        </div>
    </a>

    <div class="d-flex align-items-center gap-4 fs-5">
        <!-- Dropdown de Usuario -->
        <div class="dropdown">
            <a href="#"
               class="text-dark text-decoration-none"
               id="dropdownUsuario"
               data-bs-toggle="dropdown"
               aria-expanded="false">
                <span class="bi bi-person"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUsuario">
                <?php if(isset($_SESSION['email'])): ?>
                    <!-- Usuario logueado -->
                    <li>
                        <a class="dropdown-item text-danger" href="../salir.php">
                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Usuario no logueado -->
                    <li>
                        <a class="dropdown-item" href="../login.php">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="../registro.php">
                            <i class="bi bi-person-plus me-2"></i>Registrarse
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div><a href="../cesta.php"><span class="bi bi-cart"></span></a>
        <a href="../favoritos.php"><span class="bi bi-heart"></span></a>
    </div>
</header>
