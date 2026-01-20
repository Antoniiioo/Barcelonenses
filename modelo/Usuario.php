<?php

namespace modelo;
class Usuario
{
    private $idUsuario;
    private $idDireccion;
    private $idTipoUsuario;
    private $pass;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $email;
    private $fechaNac;
    private $telefono;

    public function __construct($idUsuario, $idDireccion, $idTipoUsuario, $pass, $nombre, $apellido1, $apellido2, $email, $fechaNac, $telefono)
    {
        $this->idUsuario = $idUsuario;
        $this->idDireccion = $idDireccion;
        $this->idTipoUsuario = $idTipoUsuario;
        $this->pass = $pass;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->email = $email;
        $this->fechaNac = $fechaNac;
        $this->telefono = $telefono;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}