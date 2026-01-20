<?php
class Valoracion
{
    private $id_Valoracion;
    private $id_Producto;
    private $puntuacion;
    private $comentario;

    public function __construct($id_Valoracion, $id_Producto, $puntuacion, $comentario)
    {
        $this->id_Valoracion = $id_Valoracion;
        $this->id_Producto = $id_Producto;
        $this->puntuacion = $puntuacion;
        $this->comentario = $comentario;
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