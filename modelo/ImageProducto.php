<?php

class ImageProducto
{
    private $id_image_producto;
    private $id_producto;
    private $url_image;

    public function __construct($id_image_producto, $id_producto, $url_image)
    {
        $this->id_image_producto = $id_image_producto;
        $this->id_producto = $id_producto;
        $this->url_image = $url_image;
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