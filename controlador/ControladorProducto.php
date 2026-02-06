<?php
require_once './modelo/Producto.php';
require_once 'Conexion.php';

class ControladorProducto
{
    function crearProducto($id_tipo_producto, $id_usuario, $nombre, $marca, $precio, $talla, $id_img_producto, $color) {
        $pdo = new Conexion();

        $sql = "INSERT INTO producto 
            (id_tipo_producto, id_usuario, nombre, marca, precio, talla, id_img_producto, color)
            VALUES 
            (:id_tipo_producto, :id_usuario, :nombre, :marca, :precio, :talla, :id_img_producto, :color)";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":id_tipo_producto" => $id_tipo_producto,
            ":id_usuario"       => $id_usuario,
            ":nombre"           => $nombre,
            ":marca"            => $marca,
            ":precio"           => $precio,
            ":talla"            => $talla,
            ":id_img_producto"  => $id_img_producto,
            ":color"            => $color
        ]);
    }

    function editarProducto($id_producto, $id_tipo_producto, $id_usuario, $nombre, $marca, $precio, $talla, $id_img_producto, $color) {
        $pdo = new Conexion();

        $sql = "UPDATE producto SET
                id_tipo_producto = :id_tipo_producto,
                id_usuario = :id_usuario,
                nombre = :nombre,
                marca = :marca,
                precio = :precio,
                talla = :talla,
                id_img_producto = :id_img_producto,
                color = :color
            WHERE id_producto = :id_producto";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ":id_producto"      => $id_producto,
            ":id_tipo_producto" => $id_tipo_producto,
            ":id_usuario"       => $id_usuario,
            ":nombre"           => $nombre,
            ":marca"            => $marca,
            ":precio"           => $precio,
            ":talla"            => $talla,
            ":id_img_producto"  => $id_img_producto,
            ":color"            => $color
        ]);
    }

    function eliminarProducto($id_producto) {
        $pdo = new Conexion();

        $sql = "DELETE FROM producto WHERE id_producto = :id_producto";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ":id_producto" => $id_producto
        ]);
    }

    function obtenerTodosProductos() {
        $pdo = new Conexion();
        $sql = "SELECT * FROM producto ORDER BY id_producto DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    function obtenerProductoPorId($id_producto) {
        $pdo = new Conexion();
        $sql = "SELECT * FROM producto WHERE id_producto = :id_producto";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id_producto" => $id_producto]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    function buscarProductosConValoracionesPorNombre($nombreProducto) {
        try {
            $pdo = new Conexion();

            // Buscar productos por nombre con LIKE y que tengan al menos una valoración
            // Incluye nombre del tipo de producto y del usuario propietario
            $sql = "SELECT DISTINCT 
                        p.id_producto,
                        p.nombre,
                        p.marca,
                        p.precio,
                        p.talla,
                        p.color,
                        tp.tipo as tipo_producto,
                        CONCAT(u.nombre, ' ', u.apellido1) as nombre_usuario
                    FROM producto p
                    INNER JOIN valoracion v ON p.id_producto = v.id_producto
                    LEFT JOIN tipo_producto tp ON p.id_tipo_producto = tp.id_tipo_producto
                    LEFT JOIN usuario u ON p.id_usuario = u.id_usuario
                    WHERE p.nombre LIKE :nombreProducto
                    ORDER BY p.nombre ASC";

            $stmt = $pdo->prepare($sql);
            $parametro = "%{$nombreProducto}%";
            $stmt->bindParam(':nombreProducto', $parametro);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return [];
        }
    }

    function obtenerProductosConImagenes($limite = null) {
        try {
            $pdo = new Conexion();

            $sql = "SELECT 
                        p.id_producto,
                        p.nombre,
                        p.marca,
                        p.precio,
                        p.talla,
                        p.color,
                        p.id_tipo_producto,
                        img.url_image,
                        img.id_image_producto
                    FROM producto p
                    LEFT JOIN image_producto img ON p.id_producto = img.id_producto
                    GROUP BY p.id_producto
                    ORDER BY p.id_producto DESC";

            if ($limite) {
                $sql .= " LIMIT :limite";
            }

            $stmt = $pdo->prepare($sql);

            if ($limite) {
                $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return [];
        }
    }
}


?>