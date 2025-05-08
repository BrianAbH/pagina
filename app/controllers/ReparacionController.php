<?php
// - Reparacion.php contiene la lógica del modelo Reparacion.
// - database.php contiene la clase Database para la conexión con la base de datos.
require_once __DIR__ . '/../models/Reparacion.php';
require_once __DIR__ . '/../../config/database.php';

// Se crea una instancia de la base de datos y se obtiene la conexión.
$db = new Database();
$con = $db->conectar();

// Se crea una instancia del modelo Reparacion usando la conexión.
$reparacion = new Reparacion($con);

// Se verifica si la petición HTTP es de tipo POST (es decir, si se envió un formulario).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Si se presionó el botón 'guardar' en el formulario
    if (isset($_POST['guardar'])) {
        // Se llama al método guardar del modelo Reparacion con los datos del formulario.
        $resultado = $reparacion->guardar($_POST);

        // Si se actualizó una reparación existente, se guarda un mensaje de éxito en la sesión.
        if (isset($resultado['actualizar'])) {
            $_SESSION['exito'] = '<div class="alert alert-primary">Reparacion Actualizado correctamente.</div>';
        }

        // Si se guardó una nueva reparación, se guarda otro mensaje de éxito.
        if (isset($resultado['guardar'])) {
            $_SESSION['exito'] = '<div class="alert alert-success">Reparacion Guardado correctamente.</div>';
        }

    // Si se presionó el botón 'eliminar' en el formulario
    } elseif (isset($_POST['eliminar'])) {
        // Se llama al método eliminar con el ID de la reparación.
        $reparacion->eliminar($_POST['id']);

        // Se guarda un mensaje indicando que la reparación fue eliminada.
        $_SESSION['exito'] = '<div class="alert alert-danger">Reparacion Eliminado correctamente.</div>';
    }

    // Se redirige a la vista de reparaciones para evitar reenvíos al recargar la página.
    header("Location: vistaReparaciones.php"); 
    exit();
}

// - Se obtienen todas las reparaciones registradas.
$resultado = $reparacion->obtenerReparacion();

// - Se obtienen los dispositivos por cliente, probablemente para usarlos en formularios desplegables o tablas.
$dispositivo = $reparacion->obtenerDispositivosByCliente();

// - Se obtienen los datos del técnico por ID, posiblemente para vincular reparaciones a técnicos específicos.
$tecnico = $reparacion->obtenerTecnicoById();

?>
