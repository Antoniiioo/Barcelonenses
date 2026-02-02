<?php
require_once './modelo/TipoProducto.php';
require_once 'Conexion.php';

class ControladorTipoProducto
{
    function crearTipoProducto($tipo) {
        $pdo = new Conexion();

        $sql = "INSERT INTO tipo_producto (tipo) VALUES (:tipo)";
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([
            ":tipo" => $tipo
        ]);
    }

    function editarTipoProducto($id_tipo_producto, $tipo) {
        $pdo = new Conexion();

        $sql = "UPDATE tipo_producto SET tipo = :tipo WHERE id_tipo_producto = :id_tipo_producto";
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([
            ":id_tipo_producto" => $id_tipo_producto,
            ":tipo" => $tipo
        ]);
    }

    function eliminarTipoProducto($id_tipo_producto) {
        $pdo = new Conexion();

        $sql = "DELETE FROM tipo_producto WHERE id_tipo_producto = :id_tipo_producto";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ":id_tipo_producto" => $id_tipo_producto
        ]);
    }

    function obtenerTodosTiposProducto() {
        $pdo = new Conexion();
        $sql = "SELECT * FROM tipo_producto ORDER BY id_tipo_producto ASC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    function obtenerTipoProductoPorId($id_tipo_producto) {
        $pdo = new Conexion();
        $sql = "SELECT * FROM tipo_producto WHERE id_tipo_producto = :id_tipo_producto";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id_tipo_producto" => $id_tipo_producto]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

?>
