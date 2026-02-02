<?php

class Conexion extends PDO
{
    private $user = "dwes";
    private $pass = "abc123.";
    private $db = 'mysql:host=127.0.0.1;port=3306;dbname=barcelonenses;charset=utf8mb4';
    private $opc = array(PDO::ATTR_CASE => PDO::CASE_LOWER);

    public function __construct()
    {
        parent::__construct($this->db, $this->user, $this->pass, $this->opc);
    }

    public function __get($name)
    {
        return $this->name;
    }

    public function __set($name, $value)
    {
        $this->name = $this->value;
    }
}
