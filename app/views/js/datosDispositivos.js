function llenarFormulario(id, nombre_completo, tipo, marca, modelo, año) {
    // Asigna el valor del ID del dispositivo al campo oculto con el id 'id'
    document.getElementById('id').value = id;

    // Asigna el nombre completo del cliente al campo de selección con el id 'cliente'
    document.getElementById('cliente').value = nombre_completo;

    // Asigna el tipo de dispositivo (Smartphone o Tablet) al campo de selección con el id 'tipo'
    document.getElementById('tipo').value = tipo;

    // Asigna la marca del dispositivo al campo de texto con el id 'marca'
    document.getElementById('marca').value = marca;

    // Asigna el modelo del dispositivo al campo de texto con el id 'modelo'
    document.getElementById('modelo').value = modelo;

    // Asigna el año del dispositivo al campo de texto con el id 'anio'
    document.getElementById('anio').value = año;
}
