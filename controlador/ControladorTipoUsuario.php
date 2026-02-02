<?php
require_once 'Conexion.php';
require_once './modelo/TipoUsuario.php';
class ControladorTipoUsuario
{
    public static function getAll() {
        $tiposUsuario = [];
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("SELECT * FROM tipo_usuario");
            $stmt->execute();
            while ($row = $stmt->fetchObject()) {
                $tipoUsuario = new TipoUsuario(
                    $row->id_tipo_usuario,
                    $row->tipo
                );
                $tiposUsuario[] = $tipoUsuario;
            }
            return $tiposUsuario;
        } catch (PDOException $e) {
            return "Error al obtener los tipos de usuario: " . $e->getMessage();
        }
    }
}