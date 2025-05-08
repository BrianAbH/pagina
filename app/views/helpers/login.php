<?php
    if(!empty($_POST['acceder'])){
        $nombre = $_POST['nombre'];
        $password = $_POST['password'];
        if($nombre =="Admin" && $password == "Admin"){
            header("Location: app/views/VistaCliente.php");
            exit();
        }else{
            echo'<div class="alert alert-warning"> El usuario o contraseña no son validos </div>';
        }
    }
?>

