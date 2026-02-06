<?php

class ControladorDireccion
{
    public static function crearDireccion($calle, $numCalle, $cp, $localidad, $pais)
    {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("INSERT INTO direccion (calle, num_calle, cod_postal, localidad, pais) 
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

    public static function actualizarDireccion($idDireccion, $cp, $localidad, $pais, $numCalle) {
        $conex = new Conexion();
        $stmt = $conex->prepare("UPDATE direccion 
                                 SET cod_postal = :cp, localidad = :localidad, pais = :pais, num_calle = :numCalle, calle = :calle 
                                 WHERE id_direccion = :idDireccion");
        $stmt->bindParam(':cp', $cp);
        $stmt->bindParam(':localidad', $localidad);
        $stmt->bindParam(':pais', $pais);
        $stmt->bindParam(':numCalle', $numCalle);
        $stmt->bindParam(':idDireccion', $idDireccion);
        $stmt->bindParam(':calle', $calle);
        return $stmt->execute();
    }

    public static function getDireccionPorUsuario($idUsuario) {
        $conex = new Conexion();
        $stmt = $conex->prepare("SELECT d.* FROM direccion d 
                                 JOIN usuario u ON d.id_direccion = u.id_direccion 
                                 WHERE u.id_usuario = :idUsuario");
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public static function obtenerDireccionPorId($idDireccion) {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("SELECT * FROM direccion WHERE id_direccion = :id_direccion");
            $stmt->bindParam(':id_direccion', $idDireccion);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener dirección: " . $e->getMessage());
        }
    }

    public static function crearDireccionYAsociarUsuario($idUsuario, $calle, $numCalle, $codPostal, $localidad, $pais)
    {
        try {
            $conex = new Conexion();

            // Insertar dirección
            $stmt = $conex->prepare("INSERT INTO direccion (calle, num_calle, cod_postal, localidad, pais)
                                     VALUES (:calle, :num_calle, :cod_postal, :localidad, :pais)");
            $stmt->bindParam(':calle', $calle);
            $stmt->bindParam(':num_calle', $numCalle);
            $stmt->bindParam(':cod_postal', $codPostal);
            $stmt->bindParam(':localidad', $localidad);
            $stmt->bindParam(':pais', $pais);

            if ($stmt->execute()) {
                $idDireccion = $conex->lastInsertId();

                // Asociar al usuario
                $stmtUser = $conex->prepare("UPDATE usuario SET id_direccion = :id_direccion WHERE id_usuario = :id_usuario");
                $stmtUser->bindParam(':id_direccion', $idDireccion);
                $stmtUser->bindParam(':id_usuario', $idUsuario);
                return $stmtUser->execute();
            }
            return false;
        } catch (PDOException $e) {
            throw new Exception("Error al crear dirección: " . $e->getMessage());
        }
    }

    public static function actualizarDireccionPorId($idDireccion, $calle, $numCalle, $codPostal, $localidad, $pais)
    {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("UPDATE direccion SET
                                     calle = :calle,
                                     num_calle = :num_calle,
                                     cod_postal = :cod_postal,
                                     localidad = :localidad,
                                     pais = :pais
                                     WHERE id_direccion = :id_direccion");
            $stmt->bindParam(':calle', $calle);
            $stmt->bindParam(':num_calle', $numCalle);
            $stmt->bindParam(':cod_postal', $codPostal);
            $stmt->bindParam(':localidad', $localidad);
            $stmt->bindParam(':pais', $pais);
            $stmt->bindParam(':id_direccion', $idDireccion);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar dirección: " . $e->getMessage());
        }
    }

}

