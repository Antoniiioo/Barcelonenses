<?php
class Producto {
    private $id_Producto;
    private $id_Tipo_Producto;
    private $id_Usuario;
    private $nombre;
    private $marca;
    private $precio;
    private $talla;
    private $id_Img_Producto;
    private $color;


    public function __construct($id_Producto, $id_Tipo_Producto, $id_Usuario, $nombre, $marca, $precio, $talla, $id_Img_Producto, $color)
    {
        $this->id_Producto = $id_Producto;
        $this->id_Tipo_Producto = $id_Tipo_Producto;
        $this->id_Usuario = $id_Usuario;
        $this->nombre = $nombre;
        $this->marca = $marca;
        $this->precio = $precio;
        $this->talla = $talla;
        $this->id_Img_Producto = $id_Img_Producto;
        $this->color = $color;
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



?>