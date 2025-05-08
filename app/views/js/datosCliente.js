function llenarFormulario(id, cedula, nombre, apellido, telefono, direccion) {
    document.getElementById('id').value = id;
    document.getElementById('cedula').value = cedula;
    document.getElementById('nombre').value = nombre;
    document.getElementById('apellido').value = apellido;
    document.getElementById('telefono').value = telefono;
    document.getElementById('direccion').value = direccion;
}