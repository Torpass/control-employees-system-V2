<?php

class ConexionSQL {

    // Variables de conexión
    private $servidor = "localhost";
    private $usuario = "root";
    private $contraseña = "";
    private $base_datos = "complex_project";
    protected $conexion;
  
    // Constructor
    public function __construct() {
      $dsn = "mysql:host=$this->servidor;dbname=$this->base_datos;charset=utf8mb4";
      try {
        $this->conexion = new PDO($dsn, $this->usuario, $this->contraseña);
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
      }
    }
}
