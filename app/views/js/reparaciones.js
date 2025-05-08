function llenarFormulario(id, movil, tecnico, repuestos, total_repuestos, servicio, total_servicio, fecha) {
    // Asigna el valor del ID de la reparación al campo oculto con el id 'id'
    document.getElementById('id').value = id;

    // Asigna el valor del móvil asociado a la reparación al campo de texto con el id 'movil'
    document.getElementById('movil').value = movil;

    // Asigna el nombre del técnico que realizó la reparación al campo de texto con el id 'tecnico'
    document.getElementById('tecnico').value = tecnico;

    // Asigna los repuestos utilizados en la reparación al campo de texto con el id 'repuestos'
    document.getElementById('repuestos').value = repuestos;

    // Asigna el costo total de los repuestos al campo de texto con el id 'total_repuestos'
    document.getElementById('total_repuestos').value = total_repuestos;

    // Asigna el tipo de servicio realizado (por ejemplo, reparación o mantenimiento) al campo de texto con el id 'servicio'
    document.getElementById('servicio').value = servicio;

    // Asigna el costo total del servicio al campo de texto con el id 'total_servicio'
    document.getElementById('total_servicio').value = total_servicio;

    // Asigna la fecha de la reparación al campo de fecha con el id 'FechaReparacion'
    document.getElementById('FechaReparacion').value = fecha;
}
