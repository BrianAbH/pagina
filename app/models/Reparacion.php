<?php
// Inclusión de la configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

$db = new Database(); // Se instancia la conexión a la base de datos

// Definición de la clase Reparacion
class Reparacion {
    private $con; // Propiedad que almacena la conexión

    // Constructor que recibe la conexión como parámetro
    public function __construct($db) {
        $this->con = $db;
    }

    // Método para guardar (insertar o actualizar) una reparación
    public function guardar($data) {
        extract($data); 
        if ($id) {
            $this->actualizar($data);
            return ['actualizar' => true];
        } else {
            // Si no hay ID, se inserta una nueva reparación
            $this->insertar($data);
            return ['guardar' => true];
        }
    }

    //Funcion para insertar las reparaciones
    public function insertar($data){
        extract($data); 
        $stmt = $this->con->prepare("INSERT INTO reparaciones 
                                         (Id_Dispositivo, Id_Tecnico, Repuestos, Total_Repuestos, Servicio, Total_Servicio, Fecha_Reparacion, Activo) 
                                         VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("iisisis", $movil, $tecnico, $repuestos, $total_repuestos, $servicio, $total_servicio, $FechaReparacion); 
        $stmt->execute();
    }

    //Funcion para actualizar las reparacion
    public function actualizar($data){ 
        extract($data);
        // Si existe un ID, se actualiza el registro existente
        $stmt = $this->con->prepare("UPDATE reparaciones 
                                        SET Id_Dispositivo=?, Id_Tecnico=?, Repuestos=?, Total_Repuestos=?, 
                                        Servicio=?, Total_Servicio=?, Fecha_Reparacion=? 
                                        WHERE Id_Reparacion=?");
        $stmt->bind_param("iisisisi", $movil, $tecnico, $repuestos, $total_repuestos, $servicio, $total_servicio, $FechaReparacion, $id);
        $stmt -> execute();
    }

    // Método para eliminar lógicamente una reparación (marcándola como inactiva)
    public function eliminar($id) {
        $stmt = $this->con->prepare("UPDATE reparaciones SET Activo = 0 WHERE Id_Reparacion = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Método para obtener todas las reparaciones activas con datos relacionados del cliente, dispositivo y técnico
    public function obtenerReparacion() {
        $stmt = $this->con->prepare("SELECT r.Id_Reparacion, 
                                            c.Nombre_Completo, 
                                            t.Id_Tecnico, t.Nombre_Tecnico, 
                                            dm.Id_Dispositivo, dm.Tipo, dm.Marca, dm.Modelo, 
                                            r.Repuestos, r.Total_Repuestos, 
                                            r.Servicio, r.Total_Servicio, 
                                            r.Fecha_Reparacion
                                     FROM reparaciones r
                                     INNER JOIN datosdispositivos dm ON r.Id_Dispositivo = dm.Id_Dispositivo 
                                     INNER JOIN datoscliente c ON dm.Id_Cliente = c.Id_Cliente
                                     INNER JOIN datostecnico t ON r.Id_Tecnico = t.Id_Tecnico 
                                     WHERE r.Activo = 1");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Método para obtener todos los dispositivos activos junto al nombre del cliente (útil para dropdowns o formularios)
    public function obtenerDispositivosByCliente() {
        $stmt = $this->con->prepare("SELECT r.Id_Dispositivo, c.Nombre_Completo, r.Modelo 
                                     FROM datosdispositivos r 
                                     INNER JOIN datoscliente c ON r.Id_Cliente = c.Id_Cliente 
                                     WHERE r.Activo = 1");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Método para obtener todos los técnicos activos
    public function obtenerTecnicoById() {
        $stmt = $this->con->prepare("SELECT Id_Tecnico, Nombre_Tecnico FROM datostecnico WHERE Activo = 1");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
}
?>
