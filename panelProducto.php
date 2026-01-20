<?php include("includes/a_config.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include "includes/head-tag-contents.php"; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Ajustes visuales para la tabla */
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .img-thumbnail-table {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        .table td, .table th {
            vertical-align: middle; /* Centra verticalmente el contenido */
        }
        
        /* Opcional: Si quieres forzar el azul de tu marca en botones bootstrap */
        .btn-primary {
            background-color: #1e2a78; 
            border-color: #1e2a78;
        }
        .btn-primary:hover {
            background-color: #151d55;
            border-color: #151d55;
        }
        
        /* Color para el título */
        .admin-title {
            color: #1e2a78;
            font-weight: bold;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    
    <?php include "includes/design-top.php"; ?>
    <?php include "includes/navigation.php"; ?>

    <main class="container-fluid row justify-content-center my-5 font-medium">
        <div class="col-md-10 col-12">
            
            <div class="row mb-4 align-items-center">
                <div class="col-6">
                    <h2 class="admin-title fs-1">Panel de Administración</h2>
                </div>
                <div class="col-6 text-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productoModal">
                        <i class="fa-solid fa-plus"></i> Nuevo Producto
                    </button>
                </div>
            </div>

            <div class="table-container">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Marca</th>
                            <th>Tipo</th>
                            <th>Precio</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#101</td>
                            <td><img src="https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/3bbecb5681e944b58496a8bf0117cf62_9366/Camiseta_Entrada_18_Blanco_CD8438_01_laydown.jpg" class="img-thumbnail-table"></td>
                            <td class="fw-bold">Camiseta blanca Adidas</td>
                            <td>Adidas</td>
                            <td><span class="badge bg-secondary">Camiseta</span></td>
                            <td>10.00€</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary me-1"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-outline-danger" onclick="confirmarEliminar()"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#102</td>
                            <td><img src="https://static.nike.com/a/images/t_PDP_1280_v1/f_auto,q_auto:eco/e6443652-3203-4c55-8d5f-42283e0c030d/pantalon-de-chandal-de-tejido-fleece-phoenix-fleece-mujer-tall-Xvr99P.png" class="img-thumbnail-table"></td>
                            <td class="fw-bold">Pantalón Nike Beige</td>
                            <td>Nike</td>
                            <td><span class="badge bg-secondary">Pantalón</span></td>
                            <td>39.00€</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary me-1"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn btn-sm btn-outline-danger" onclick="confirmarEliminar()"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

    <?php include "includes/footer.php"; ?>

    <div class="modal fade" id="productoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gestión de Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Marca</label>
                                <select class="form-select" name="marca">
                                    <option selected>Elegir...</option>
                                    <option value="Adidas">Adidas</option>
                                    <option value="Nike">Nike</option>
                                    <option value="North Face">The North Face</option>
                                    <option value="Scuffers">Scuffers</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Precio (€)</label>
                                <input type="number" step="0.01" class="form-control" name="precio" placeholder="0.00">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Imagen</label>
                            <input type="file" class="form-control" name="imagen">
                        </div>
                        
                        <div class="modal-footer px-0 pb-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" name="guardar_producto">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function confirmarEliminar() {
            if(confirm("¿Estás seguro de que quieres eliminar este producto?")) {
                // Aquí iría la lógica PHP o AJAX para borrar
                alert("Acción de borrar detectada");
            }
        }
    </script>
</body>
</html>