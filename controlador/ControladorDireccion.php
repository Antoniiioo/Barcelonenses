<?php

class ControladorDireccion
{
    public static function crearDireccion($calle, $numCalle, $cp, $localidad, $pais)
    {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("INSERT INTO direccion (calle, num_calle, cp, localidad, pais) 
                                     VALUES (:calle, :num_calle, :cp, :localidad, :pais)");
            $stmt->bindParam(':calle', $calle);
            $stmt->bindParam(':num_calle', $numCalle);
            $stmt->bindParam(':cp', $cp);
            $stmt->bindParam(':localidad', $localidad);
            $stmt->bindParam(':pais', $pais);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al crear dirección: " . $e->getMessage());
        }
    }

}