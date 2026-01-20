<?php

class tipoProducto
{
    private $id_Tipo_Producto;
    private $tipo;

    public function __construct($id_Tipo_Producto, $tipo)
    {
        $this->id_Tipo_Producto = $id_Tipo_Producto;
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