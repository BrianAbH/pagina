<?php
// Se incluyen los archivos necesarios:
// - Dispositivo.php contiene la lógica del modelo Dispositivo.
// - database.php contiene la clase para la conexión a la base de datos.
require_once __DIR__ . '/../models/Dispositivo.php';
require_once __DIR__ . '/../../config/database.php';

// Se crea una instancia de la clase Database y se obtiene la conexión.
$db = new Database();
$con = $db->conectar();

// Se crea una instancia del modelo Dispositivo, pasando la conexión como parámetro.
$dispositivo = new Dispositivo($con);

// Verifica si la solicitud HTTP es de tipo POST (es decir, si se envió un formulario).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si el formulario incluye el botón 'guardar', se procesa el guardado del dispositivo.
    if (isset($_POST['guardar'])) {
        // Llama al método guardar del modelo Dispositivo con los datos del formulario.
        $resultadoD = $dispositivo->guardar($_POST);

        // Si hay un error, se guarda en la sesión para mostrar al usuario.
        if (isset($resultadoD['error'])) {
            $_SESSION['error'] = $resultadoD['error'];
        }

        // Si el dispositivo fue actualizado correctamente, se guarda un mensaje de éxito en la sesión.
        if (isset($resultadoD['actualizar'])) {
            $_SESSION['exito'] = '<div class="alert alert-primary">Dispositivo Actualizado correctamente.</div>';
        }

        // Si el dispositivo fue guardado (creado) correctamente, se guarda otro mensaje de éxito.
        if (isset($resultadoD['guardar'])) {
            $_SESSION['exito'] = '<div class="alert alert-success">Dispositivo Guardado correctamente.</div>';
        }

    // Si el formulario incluye el botón 'eliminar', se elimina el dispositivo correspondiente.
    } elseif (isset($_POST['eliminar'])) {
        // Llama al método eliminar con el ID del dispositivo.
        $dispositivo->eliminar($_POST['id']);
        // Se guarda un mensaje en la sesión indicando que el dispositivo fue eliminado.
        $_SESSION['exito'] = '<div class="alert alert-danger">Dispositivo Eliminado correctamente.</div>';
    }

    // Redirige a la vista principal de dispositivos para evitar reenvíos de formulario al recargar.
    header("Location: vistaDispositivo.php"); 
    exit();
}

// Si no se envió un formulario POST, se obtienen todos los dispositivos registrados.
$resultadoD = $dispositivo->obtenerDispositivos();

// También se obtienen dispositivos asociados a clientes (probablemente para mostrarlos agrupados o filtrados).
$resultadoByCliente = $dispositivo->obtenerByCliente();

?>