<?php

require_once 'Conexion.php';
require_once 'Modelo/ImageProducto.php';
class ControladorImageProducto
{
    public static function crearImageProducto($id_producto, $url_image)
    {
        $conex = new Conexion();
        $sql = "INSERT INTO image_producto (id_producto, url_image) 
                VALUES (:id_producto, :url_image)";
        $stmt = $conex->prepare($sql);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->bindParam(':url_image', $url_image);
        return $stmt->execute();
    }

    public static function getImagenesPorProducto($id_producto)
    {
        $conex = new Conexion();
        $sql = "SELECT * FROM image_producto WHERE id_producto = :id_producto";
        $stmt = $conex->prepare($sql);
        $stmt->bindParam(':id_producto', $id_producto);
        $stmt->execute();
        $imagenes = [];
        while ($row = $stmt->fetchObject()) {
            $imagen = new ImageProducto(
                $row->id_image_producto,
                $row->id_producto,
                $row->url_image
            );
            $imagenes[] = $imagen;
        }
        return $imagenes;
    }
}