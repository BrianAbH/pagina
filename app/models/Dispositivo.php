<?php
// Se incluyen los archivos necesarios:
// - database.php contiene la clase para conectarse a la base de datos
require_once __DIR__ . '/../../config/database.php';

$db = new Database(); // Se instancia la conexión a la base de datos

// Definición de la clase Dispositivo
class Dispositivo {
    private $con; // Propiedad que almacena la conexión a la base de datos

    // Constructor: recibe una conexión y la guarda para uso posterior
    public function __construct($db) {
        $this->con = $db;
    }

    // Método para guardar (insertar o actualizar) un dispositivo
    public function guardar($data) {
        extract($data); // Extrae las variables del arreglo $data: $cliente, $tipo, $marca, etc.
        // Si se proporciona un ID, se actualiza el registro existente
        if ($id) {
            $this->actualizar($data);
            return ['actualizar' => true];

        } else {
            // Si no hay ID, se trata de un nuevo dispositivo (se inserta)
            $this->insertar($data);
            return ['guardar' => true];
        }
    }

    //Funcion para insertar un dispositivo
    public function insertar($data) {
        extract($data);
        $stmt = $this->con->prepare("INSERT INTO datosdispositivos 
                                         (Id_Cliente, Tipo, Marca, Modelo, Año, Activo) 
                                         VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("sssss", $cliente, $tipo, $marca, $modelo, $anio); 
        $stmt->execute();
    }

    //Funcion para actualizar un dispositivo
    public function actualizar($data) {
        extract($data);
        $stmt = $this->con->prepare("UPDATE datosdispositivos 
                                         SET Id_Cliente=?, Tipo=?, Marca=?, Modelo=?, Año=? 
                                         WHERE Id_Dispositivo=?");
        $stmt->bind_param("sssssi", $cliente, $tipo, $marca, $modelo, $anio, $id);
        $stmt->execute();
    }

    // Método para eliminar un dispositivo (eliminación lógica)
    public function eliminar($id) {
        $stmt = $this->con->prepare("UPDATE datosdispositivos SET Activo = 0 WHERE Id_Dispositivo = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Método para obtener todos los dispositivos activos, incluyendo datos del cliente relacionado
    public function obtenerDispositivos() {
        $stmt = $this->con->prepare("SELECT r.Id_Dispositivo, r.Id_Cliente, c.Nombre_Completo, c.Apellidos, 
                                            r.Tipo, r.Marca, r.Modelo, r.Año, r.Activo 
                                     FROM datosdispositivos r 
                                     INNER JOIN datoscliente c ON r.Id_Cliente = c.Id_Cliente 
                                     WHERE r.Activo=1");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Método para obtener una lista de clientes activos (usado probablemente para un combo desplegable)
    public function obtenerByCliente() {
        $stmt = $this->con->prepare("SELECT Id_Cliente, Nombre_Completo FROM datoscliente WHERE Activo = 1");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
