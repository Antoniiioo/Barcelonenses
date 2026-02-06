<?php

require_once './modelo/Usuario.php';
require_once 'Conexion.php';

class ControladorUsuario
{
    public static function login($email, $password)
    {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("SELECT * FROM usuario WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $row['pass'])) {
                    session_start();
                    $_SESSION['id_usuario'] = $row['id_usuario'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['id_tipo_usuario'] = $row['id_tipo_usuario'];
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception("Error al iniciar sesión: " . $e->getMessage());
        }
    }

    public static function validarDatos($nombre, $apellido1, $email,
                                        $telefono, $pass, $repPass)
    {
        // Validar nombre - solo letras, espacios y guiones, max 40 caracteres
        $error = [];
        if (!preg_match("/^[a-z\s-]{1,40}$/i", $nombre)) {
            $error[] = "valNombre";
        }

        // Validar apellido 1 - solo letras, espacios y guiones, max 40 caracteres
        $error = [];
        if (!preg_match("/^[a-z\s-]{1,40}$/i", $apellido1)) {
            $error[] = "valApellido1";
        }

        // Validar email - formato correcto y máximo 60 caracteres
        if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email) || strlen($email) > 60) {
            $error[] = "valEmail";
        }

        // Validar teléfono - 9 dígitos
        if (!preg_match("/^\d{9}$/", $telefono)) {
            $error[] = "valTelefono";
        }

        // Validar contraseña - mínimo 8 caracteres
        if (!preg_match("/^.{8,}$/", $pass)) {
            $error[] = "valPass";
        }

        // Validar que las contraseñas coincidan
        if ($pass !== $repPass) {
            $error[] = "valRepPass";
        }

        return $error;
    }

    public static function registrarUsuarioCliente($nombre, $apellido1, $apellido2, $email,
                                                   $telefono, $pass)
    {
        try {
            $conex = new Conexion();
            $hashedPass = password_hash($pass, PASSWORD_BCRYPT);
            $stmt = $conex->prepare("INSERT INTO usuario (nombre, apellido1, apellido2, email, telefono, pass, id_tipo_usuario) 
                                     VALUES (:nombre, :apellido1, :apellido2, :email, :telefono, :pass, :id_tipo_usuario)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido1', $apellido1);
            $stmt->bindParam(':apellido2', $apellido2);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':pass', $hashedPass);
            $idTipoUsuario = 3; // Asignar tipo de usuario predeterminado (por ejemplo, 3 para usuarios valoradores)
            $stmt->bindParam(':id_tipo_usuario', $idTipoUsuario);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al registrar usuario: " . $e->getMessage());
        }
    }

    public static function registrarUsuarioAdmin($nombre, $apellido1, $apellido2, $email,
                                                 $telefono, $fechaNac, $pass, $idTipoUsuario)
    {
        try {
            $conex = new Conexion();
            $hashedPass = password_hash($pass, PASSWORD_BCRYPT);
            $stmt = $conex->prepare("INSERT INTO usuario (nombre, apellido1, apellido2, email, telefono, fecha_nac, pass, id_tipo_usuario) 
                                     VALUES (:nombre, :apellido1, :apellido2, :email, :telefono, :fecha_nac, :pass, :id_tipo_usuario)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido1', $apellido1);
            $stmt->bindParam(':apellido2', $apellido2);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':fecha_nac', $fechaNac);
            $stmt->bindParam(':pass', $hashedPass);
            $stmt->bindParam(':id_tipo_usuario', $idTipoUsuario);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al registrar usuario: " . $e->getMessage());
        }
    }

    public static function obtenerTodosUsuarios()
    {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("SELECT * FROM usuario");
            $stmt->execute();
            $usuarios = [];
            while ($row = $stmt->fetchObject()) {
                $usuario = new Usuario(
                    $row->id_usuario,
                    $row->id_direccion,
                    $row->id_tipo_usuario,
                    $row->pass,
                    $row->nombre,
                    $row->apellido1,
                    $row->apellido2,
                    $row->email,
                    $row->fecha_nac,
                    $row->telefono
                );
                $usuarios[] = $usuario;
            }
            return $usuarios;
        } catch (PDOException $e) {
            throw new Exception("Error al obtener los usuarios: " . $e->getMessage());
        }
    }

    public static function actualizarUsuario($idUsuario, $nombre, $apellido1, $apellido2,
                                            $email, $telefono, $fechaNac, $idTipoUsuario)
    {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("UPDATE usuario 
                                     SET nombre = :nombre, 
                                         apellido1 = :apellido1, 
                                         apellido2 = :apellido2, 
                                         email = :email, 
                                         telefono = :telefono, 
                                         fecha_nac = :fecha_nac, 
                                         id_tipo_usuario = :id_tipo_usuario 
                                     WHERE id_usuario = :id_usuario");
            $stmt->bindParam(':id_usuario', $idUsuario);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido1', $apellido1);
            $stmt->bindParam(':apellido2', $apellido2);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':fecha_nac', $fechaNac);
            $stmt->bindParam(':id_tipo_usuario', $idTipoUsuario);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar usuario: " . $e->getMessage());
        }
    }

    public static function eliminarUsuario($idUsuario)
    {
        try {
            $conex = new Conexion();
            $stmt = $conex->prepare("DELETE FROM usuario WHERE id_usuario = :id_usuario");
            $stmt->bindParam(':id_usuario', $idUsuario);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar usuario: " . $e->getMessage());
        }
    }

    public static function validarCambioContrasena($nuevaContrasena, $confirmarContrasena)
    {
        $error = [];

        // Validar contraseña - mínimo 8 caracteres
        if (!preg_match("/^.{8,}$/", $nuevaContrasena)) {
            $error[] = "valNuevaPass";
        }

        // Validar que las contraseñas coincidan
        if ($nuevaContrasena !== $confirmarContrasena) {
            $error[] = "valConfirmarPass";
        }

        return $error;
    }

    public static function cambiarContrasena($idUsuario, $nuevaContrasena)
    {
        try {
            $conex = new Conexion();
            $hashedPass = password_hash($nuevaContrasena, PASSWORD_BCRYPT);
            $stmt = $conex->prepare("UPDATE usuario SET pass = :pass WHERE id_usuario = :id_usuario");
            $stmt->bindParam(':pass', $hashedPass);
            $stmt->bindParam(':id_usuario', $idUsuario);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al cambiar contraseña: " . $e->getMessage());
        }
    }

}

