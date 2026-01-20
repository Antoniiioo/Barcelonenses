<?php

class Direccion
{
    private $idDireccion;
    private $calle;
    private $numCalle;
    private $codPostal;
    private $localidad;
    private $pais;

    public function __construct($idDireccion, $calle, $numCalle, $codPostal, $localidad, $pais)
    {
        $this->idDireccion = $idDireccion;
        $this->calle = $calle;
        $this->numCalle = $numCalle;
        $this->codPostal = $codPostal;
        $this->localidad = $localidad;
        $this->pais = $pais;
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