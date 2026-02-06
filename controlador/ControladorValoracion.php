<?php
require_once "modelo/Valoracion.php";
require_once "Conexion.php";
class ControladorValoracion
{
    public static function getAll()
    {
        try {
            $valoraciones = [];
            $conex = new Conexion();
            $sql = "SELECT * FROM valoracion";
            $stmt = $conex->prepare($sql);
            $stmt->execute();
            while ($result = $stmt->fetchObject()) {
                $valoracion = new Valoracion(
                    $result->id_valoracion,
                    $result->id_producto,
                    $result->puntuacion,
                    $result->comentario,
                    $result->id_usuario
                );
                $valoraciones[] = $valoracion;
            }
            return $valoraciones;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function getPorProducto($idProducto) {
        try {
            $valoraciones = [];
            $conex = new Conexion();
            $sql = "SELECT * FROM valoracion WHERE id_producto = :idProducto";
            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':idProducto', $idProducto);
            $stmt->execute();
            while ($result = $stmt->fetchObject()) {
                $valoracion = new Valoracion(
                    $result->id_valoracion,
                    $result->id_producto,
                    $result->puntuacion,
                    $result->comentario,
                    $result->id_usuario
                );
                $valoraciones[] = $valoracion;
            }
            return $valoraciones;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function obtenerValoracionesPorProducto($idProducto) {
        try {
            $conex = new Conexion();

            // Obtener valoraciones con información del usuario
            $sql = "SELECT v.*, u.nombre as nombre_usuario, u.apellido1 
                    FROM valoracion v
                    LEFT JOIN usuario u ON v.id_usuario = u.id_usuario
                    WHERE v.id_producto = :idProducto
                    ORDER BY v.id_valoracion DESC";

            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':idProducto', $idProducto);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function obtenerPromedioValoracion($idProducto) {
        try {
            $conex = new Conexion();

            $sql = "SELECT AVG(puntuacion) as promedio, COUNT(*) as total
                    FROM valoracion
                    WHERE id_producto = :idProducto";

            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':idProducto', $idProducto);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return null;
        }
    }

    public static function insertarValoracion($idProducto, $puntuacion, $comentario, $idUsuario) {
        try {
            $conex = new Conexion();

            $sql = "INSERT INTO valoracion (id_producto, puntuacion, comentario, id_usuario)
                    VALUES (:idProducto, :puntuacion, :comentario, :idUsuario)";

            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':idProducto', $idProducto);
            $stmt->bindParam(':puntuacion', $puntuacion);
            $stmt->bindParam(':comentario', $comentario);
            $stmt->bindParam(':idUsuario', $idUsuario);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function eliminarValoracion($idValoracion) {
        try {
            $conex = new Conexion();

            $sql = "DELETE FROM valoracion WHERE id_valoracion = :idValoracion";

            $stmt = $conex->prepare($sql);
            $stmt->bindParam(':idValoracion', $idValoracion);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}