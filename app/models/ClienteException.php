<?php

// Clase base para excepciones relacionadas con clientes
class ClienteException extends Exception {}

// Excepción específica para cuando una cédula ya existe en la base de datos
class CedulaDuplicadaException extends ClienteException {
    // Mensaje de error personalizado
    protected $message = "Ya existe un cliente con esa cédula.";
}

// Excepción para errores que ocurren al interactuar con la base de datos
class ErrorBaseDatosException extends ClienteException {
    // Constructor que recibe el mensaje de error del sistema
    public function __construct($error) {
        // Llama al constructor de Exception con un mensaje personalizado
        parent::__construct("Error en la base de datos: " . $error);
    }
}
?>
