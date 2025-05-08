<?php
class Database {
    private $hostname = "localhost";
    private $database = "proyecto";
    private $username = "root";
    private $password = "";
    private $charset = "utf8";

    function conectar() {
        $conexion = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        $conexion->set_charset($this->charset);
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        return $conexion;
    }
}
?>
