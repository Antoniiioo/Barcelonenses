<?php

class tipoUsuario
{
    private $idTipoUsuario;
    private $tipo;

    public function __construct($idTipoUsuario, $tipo)
    {
        $this->idTipoUsuario = $idTipoUsuario;
        $this->tipo = $tipo;
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