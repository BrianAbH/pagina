<?php
  session_start();
  require_once '../controllers/TecnicoController.php';
  $mensaje = '';
  if (isset($_SESSION['error'])) {
    $mensaje = "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
    unset($_SESSION['error']);
  } else if (isset($_SESSION['exito'])) {
      $mensaje = "{$_SESSION['exito']}";
      unset($_SESSION['exito']);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/vistaTecnico.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/fda2d00f8d.js" crossorigin="anonymous"></script>
</head>
<body>
  <!-- Incluye el menú de navegación -->
  <?php include('helpers/menu.php') ?>
  <!-- Contenedor de los títulos de bienvenida o encabezado de sección -->
  <div class="contenedor-titulo">
    <div class="titulo">
      <h2>Ingrese los datos del Tecnico</h2>
      <h1>Proyecto Para el Registro de Reparaciones de Dispositivos</h1>
    </div>
  </div>

    <!-- Contenedor que agrupa todos los elementos del formulario y a la tabla -->
  <div class="contenedor-datos">
    <!-- Contenedor del formulario -->
    <div class="contenedor-form">
      <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <?= $mensaje ?>
        <!-- Primer grupo de campos del formulario -->
        <div class="form-group">
          <!-- Campo para ingresar la cedula del tecnico -->
          <div class="form-content">
            <input type="hidden" name="id" id="id">
            <label for="cedula" class="form-label">Cedula</label>
            <input type="text" class="form-input" name="cedula" id="cedula" pattern="\d{10,10}" required>
          </div>
          <!-- Campo para ingresar el nombre del tecnico -->
          <div class="form-content">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-input" name="nombre" id="nombre" pattern="[A-Za-z]+" required>
          </div>
        </div>

        <!-- Segundo grupo de campos del formulario -->
        <div class="form-group">
          <!-- Campo para ingresar los apellidos del tecnico -->
          <div class="form-content">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-input" name="apellido" id="apellido" pattern="[A-Za-z]+" required>
          </div>
          <!-- Campo para ingresar el teléfono del tecnico -->
          <div class="form-content">
            <label for="telefono" class="form-label">Telefono</label>
            <input type="text" class="form-input" name="telefono" id="telefono" pattern="\d{10,10}" required>
          </div>
        </div>

        <!-- Tercer grupo de campos del formulario -->
        <div class="form-group-select">
          <!-- Campo para ingresar la especialidad del tecnico -->
          <div class="form-content-select">
                <label for="especialidad" class="form-label">Especialidad</label>
                <select class="select" id="especialidad" name="especialidad" required>
                    <option value="">-- Selecciona una Especialidad --</option>
                    <option value="En Telefono Android">En Telefono Android</option>
                    <option value="En Telefono Iphone">En Telefono Iphone</option>
                    <option value="En Telefono Xiaomi">En Telefono Xiaomi</option>
                    <option value="En Telefono Huawei">En Telefono Huawei</option>
                </select>
          </div>
        </div>
        <!-- Botón para guardar los datos -->
        <input type="submit" name="guardar" class="btn-Guardar" value="Guardar">
      </form>
    </div>

    <!-- Contenedor que agrupa la informacion de la tabla -->
    <div class="contenedor-tabla">
      <h1>Tecnicos Ingresados</h1>
      <hr>
      <!-- Tabla scrolleable -->
      <div class="scroll-wrapper">
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th>Id</th>
              <th>Cedula</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Telefono</th>
              <th>Especialidad</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($resultado as $row): ?>
              <!-- Se muestra cada técnico ingresado en una fila de la tabla -->
              <tr>
                <td><?= $row["Id_Tecnico"] ?></td>
                <td><?= $row["Cedula"] ?></td>
                <td><?= $row["Nombres"] ?></td>
                <td><?= $row["Apellidos"] ?></td>
                <td><?= $row["Telefono"] ?></td>
                <td><?= $row["Especialidad"] ?></td>
                <td>
                  <!-- Botón para editar el técnico -->
                  <button 
                    type="button" class="btn btn-outline-warning" onclick="llenarFormulario(
                      '<?= $row["Id_Tecnico"] ?>',
                      '<?= $row["Cedula"] ?>',
                      '<?= $row["Nombres"] ?>',
                      '<?= $row["Apellidos"] ?>',
                      '<?= $row["Telefono"] ?>',
                      '<?= $row["Especialidad"] ?>')"><i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <!-- Botón para eliminar el técnico -->
                  <form action="" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $row["Id_Tecnico"] ?>">
                    <button type="submit" name="eliminar" value="1" class="btn btn-outline-danger" onclick="return confirm('¿Seguro que quieres eliminar este Tecnico?')">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <!-- Script para la funcionalidad de los datos móviles -->
  <script src="js/datosTecnico.js"></script>

  <!-- Incluye el pie de página -->
  <?php include('helpers/footer.php') ?>
</body>
</html>
