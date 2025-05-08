<?php
  session_start();
  require_once '../controllers/ReparacionController.php';
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
    <link rel="stylesheet" href="css/vistaReparaciones.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/fda2d00f8d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include('helpers/menu.php') ?>
    <!-- Contenedor de los títulos de bienvenida o encabezado de sección -->
    <div class="contenedor-titulo">
        <div class="titulo">
        <h2>Ingrese las reparaciones</h2>
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
                    <!-- Campo para seleccionar al cliente y el dispositivo -->
                    <div class="form-content">
                        <input type="hidden" name="id" id="id">
                        <label for="movil" class="form-label">Cliente con su Dispositivo</label>
                        <select class="select" id="movil" name="movil" required>
                            <option value="">--Seleccione el telefono--</option>
                            <?php foreach ($dispositivo as $row) { ?>
                                <option value="<?php echo $row['Id_Dispositivo'] ?>"><?php echo $row['Nombre_Completo'] ?> <?php echo $row['Modelo'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- Campo para seleccionar el tecnico del dispositivo -->
                    <div class="form-content">
                        <label for="tecnico" class="form-label">Tecnico</label>
                        <select class="select" id="tecnico" name="tecnico" required>
                            <option value="">--Seleccione el tecnico--</option>
                            <?php foreach ($tecnico as $fila) { ?>
                                <option value="<?php echo $fila['Id_Tecnico'] ?>"><?php echo $fila['Nombre_Tecnico'] ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Segundo grupo de campos del formulario -->
                <div class="form-group">
                    <!-- Campo para ingresar los repuestos utilizados en la reparacion -->
                    <div class="form-content">
                        <label for="repuestos" class="form-label">Repuestos</label>
                        <input type="text" class="form-input" name="repuestos" id="repuestos"  required>
                    </div>
                    <!-- Campo para ingresar el total en costo de los repuestos -->
                    <div class="form-content">
                        <label for="total_repuestos" class="form-label">Total Repuestos</label>
                        <input type="text" class="form-input" name="total_repuestos" id="total_repuestos" pattern="\d+" required>
                    </div>
                    
                </div>

                <!-- Tercer grupo de campos del formulario -->
                <div class="form-group">
                    <!-- Campo para ingresar el servicio realizado en la reparacion -->
                    <div class="form-content">
                        <label for="servicio" class="form-label">Servicio</label>
                        <input type="text" class="form-input" name="servicio" id="servicio" required>
                    </div>
                    <!-- Campo para ingresar el total en costo del servicio -->
                    <div class="form-content">
                        <label for="total_servicio" class="form-label">Total Servicio</label>
                        <input type="text" class="form-input" name="total_servicio" id="total_servicio" pattern="\d+" required>
                    </div>
                </div>

                <!-- Cuarto grupo de campos del formulario -->
                <div class="form-group">
                    <!-- Campo para ingresar la fecha de la reparacion -->
                    <div class="form-content">
                        <label for="FechaReparacion" class="form-label">Fecha de la Reparacion</label>
                        <input type="datetime-local" class="form-input-date" name="FechaReparacion" id="FechaReparacion" required>
                    </div>
                </div>

                <input type="submit" name="guardar" class="btn-Guardar" value="Guardar">
            </form>
        </div>
        
        <!-- Contenedor que agrupa la informacion de la tabla -->
        <div class="contenedor-tabla">
            <h1>Reparaciones Ingresadas</h1>
            <hr>
            <div class="scroll-wrapper">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Cliente</th>
                            <th>Tecnico</th>
                            <th>Tipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Repuestos</th>
                            <th>Total Repuestos</th>
                            <th>Servicio</th>
                            <th>Total Servicio</th>
                            <th>Fecha Reparacion</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado as $row): ?>
                        <tr>
                            <td><?= $row["Id_Reparacion"] ?></td>
                            <td><?= $row["Nombre_Completo"] ?></td>
                            <td><?= $row["Nombre_Tecnico"] ?></td>
                            <td><?= $row["Tipo"] ?></td>
                            <td><?= $row["Marca"] ?></td>
                            <td><?= $row["Modelo"] ?></td>
                            <td><?= $row["Repuestos"] ?></td>
                            <td><?= $row["Total_Repuestos"] ?></td>
                            <td><?= $row["Servicio"] ?></td>
                            <td><?= $row["Total_Servicio"] ?></td>
                            <td><?= $row["Fecha_Reparacion"] ?></td>
                            <td>
                                <button type="button" class="btn btn-outline-warning" 
                                    onclick="llenarFormulario(
                                        '<?= $row["Id_Reparacion"] ?>',
                                        '<?= $row["Id_Dispositivo"] ?>',
                                        '<?= $row["Id_Tecnico"] ?>',
                                        '<?= $row["Repuestos"] ?>',
                                        '<?= $row["Total_Repuestos"] ?>',
                                        '<?= $row["Servicio"] ?>',
                                        '<?= $row["Total_Servicio"] ?>',
                                        '<?= $row["Fecha_Reparacion"] ?>'
                                    )">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                
                                <!-- Botón para eliminar el cliente -->
                                <form action="" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $row["Id_Reparacion"] ?>">
                                    <button type="submit" name="eliminar" value="1" class="btn btn-outline-danger" onclick="return confirm('¿Seguro que quieres eliminar este cliente?')">
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

    <script src="js/reparaciones.js"></script>

    <?php include("helpers/footer.php") ?>
</html>