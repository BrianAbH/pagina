<?php
// Se incluyen los archivos necesarios:
// - Tecnico.php contiene la lógica del modelo Técnico.
// - database.php contiene la clase para conectarse a la base de datos.
require_once __DIR__ . '/../models/Tecnico.php';
require_once __DIR__ . '/../../config/database.php';

// Se crea una instancia de la clase Database y se obtiene la conexión.
$db = new Database();
$con = $db->conectar();

// Se crea una instancia del modelo Técnico utilizando la conexión obtenida.
$tecnico = new Tecnico($con);

// Se verifica si la solicitud HTTP es de tipo POST (formulario enviado).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['guardar'])) {
        // Se llama al método guardar del modelo Técnico con los datos del formulario.
        $resultado = $tecnico->guardar($_POST);

        // Si hay un error al guardar, se guarda el mensaje en la sesión para mostrarlo al usuario.
        if (isset($resultado['error'])) {
            $_SESSION['error'] = $resultado['error'];
        }

        // Si el técnico fue actualizado correctamente, se guarda un mensaje de éxito.
        if (isset($resultado['actualizar'])) {
            $_SESSION['exito'] = '<div class="alert alert-primary">Tecnico Actualizado correctamente.</div>';
        }

        // Si el técnico fue guardado por primera vez, también se muestra un mensaje de éxito.
        if (isset($resultado['guardar'])) {
            $_SESSION['exito'] = '<div class="alert alert-success">Tecnico Guardado correctamente.</div>';
        }

    // Si se presionó el botón 'eliminar' en el formulario
    } elseif (isset($_POST['eliminar'])) {
        // Se elimina el técnico con el ID proporcionado.
        $tecnico->eliminar($_POST['id']);

        // Se muestra un mensaje informando que el técnico fue eliminado correctamente.
        $_SESSION['exito'] = '<div class="alert alert-danger">Tecnico Eliminado correctamente.</div>';
    }

    // Redirige a la vista principal de técnicos para evitar reenvíos del formulario al recargar la página.
    header("Location: VistaTecnico.php"); 
    exit();
}

$resultado = $tecnico->obtenerTecnico();

?>
