function llenarFormulario(id, cedula, nombre, apellido, telefono, especialidad) {
    document.getElementById('id').value = id;
    document.getElementById('cedula').value = cedula;
    document.getElementById('nombre').value = nombre;
    document.getElementById('apellido').value = apellido;
    document.getElementById('telefono').value = telefono;
    document.getElementById('especialidad').value = especialidad;
}