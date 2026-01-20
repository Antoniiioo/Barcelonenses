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


}


?>