<?php
// Se incluye el archivo de configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

// Se incluye el archivo que define excepciones personalizadas relacionadas con el cliente
require_once __DIR__ . '/../models/ClienteException.php'; // Ajusta el path si es necesario

// Clase Cliente: maneja operaciones relacionadas con clientes en la base de datos
class Cliente {
    private $con; // Conexión a la base de datos

    // Constructor que recibe una conexión a la base de datos
    public function __construct($db) {
        $this->con = $db;
    }

    // Método para guardar o actualizar un cliente
    public function guardar($data) {
        extract(array: $data); // Extrae variables del array $data (por ejemplo: $nombre, $apellido, etc.)

        // Verifica si la cédula ya existe (evita duplicados)
        if ($this->cedulaExiste($cedula, $id)) {
            throw new CedulaDuplicadaException(); // Lanza excepción personalizada si ya existe
        }

        if ($id) { // Si hay un ID, se actualiza el cliente existente
            $this->actualizar($data);
            return ['actualizar' => true]; // Retorna que se actualizó
        } else { // Si no hay ID, se inserta un nuevo cliente
            $this->insertar($data);
            return ['guardar' => true]; // Retorna que se guardó
        }
    }

    //Funcion para insertar
    public function insertar($data){
        extract($data);
        $nombre_completo = "$nombre $apellido"; // Genera el nombre completo
        $stmt = $this->con->prepare("INSERT INTO datoscliente 
                                         (Cedula, Nombres, Apellidos, Telefono, Direccion, Nombre_Completo, Activo) 
                                         VALUES (?, ?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("ssssss", $cedula, $nombre, $apellido, $telefono, $direccion, $nombre_completo);
        if (!$stmt->execute()) {
            throw new ErrorBaseDatosException($stmt->error); // Lanza excepción si hay error en ejecución
        }
    }
    
    //Funcion para actualizar
    public function actualizar($data){
        extract($data);
        $nombre_completo = "$nombre $apellido"; // Genera el nombre completo
        $stmt = $this->con->prepare("UPDATE datoscliente 
                                         SET Cedula=?, Nombres=?, Apellidos=?, Telefono=?, Direccion=?, Nombre_Completo=? 
                                         WHERE Id_Cliente=?");
            $stmt->bind_param("ssssssi", $cedula, $nombre, $apellido, $telefono, $direccion, $nombre_completo, $id);

            if (!$stmt->execute()) {
                throw new ErrorBaseDatosException($stmt->error); // Lanza excepción si hay error en ejecución
            }
            
    }
    
    // Método para eliminar (desactivar) un cliente
    public function eliminar($id) {
        $stmt = $this->con->prepare("UPDATE datoscliente SET Activo = 0 WHERE Id_Cliente = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute(); // Ejecuta y retorna resultado (true/false)
    }

    // Método para obtener todos los clientes activos
    public function obtenerClientes() {
        $stmt = $this->con->prepare("SELECT * FROM datoscliente WHERE Activo = 1");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC); // Retorna todos los resultados como array asociativo
    }

    // Método para verificar si una cédula ya existe (evitando duplicados)
    public function cedulaExiste($cedula, $id = null) {
        if ($id) {
            // Consulta excluyendo al cliente actual (útil en actualizaciones)
            $stmt = $this->con->prepare("SELECT 1 FROM datoscliente WHERE Cedula = ? AND Id_Cliente != ? AND Activo = 1");
            $stmt->bind_param("si", $cedula, $id);
        } else {
            // Consulta sin excluir ningún ID (útil al crear)
            $stmt = $this->con->prepare("SELECT 1 FROM datoscliente WHERE Cedula = ? AND Activo = 1");
            $stmt->bind_param("s", $cedula);
        }
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0; // Retorna true si la cédula existe
    }
}
?>