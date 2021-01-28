<?php

include 'header_vistas.php';


/* SCRIPT PARA MOSTRAR UN FORMULARIO PARA EDITAR EL REGISTRO ELEGIDO. POR ID */
function renderForm($id, $nombre, $usuario, $password, $error){

    if ($error != '') {
        echo "<div style='padding:4px; border: 1px solid #ff0000; color: red;'>" .$error. "</div>";
    }
    ?>

    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <div>
            <p><strong>ID:</strong><?php echo $id; ?></strong></p>
            <strong>Nombre: *</strong> <input type="text" name="nombre" value="<?php echo $nombre; ?>"/><br/>
            <strong>Usuario: *</strong> <input type="text" name="usuario" value="<?php echo $usuario; ?>"/><br/>
            <strong>Password: *</strong> <input type="text" name="password" value="<?php echo $password; ?>"/><br/>
            <p>* Requerido</p>
            <input type="submit" name="submit" value="Enviar"/>
        </div>
    </form>
    <?php
    include "footer.php";
}

// Comprobar si formulario ha sido enviado
if (isset($_POST['submit'])){

    $nombre = htmlspecialchars($_POST['nombre']);
    $usuario = htmlspecialchars($_POST['usuario']);
    $password = htmlspecialchars($_POST['password']);


    //Confirmar que el id es válido
    if (is_numeric($_POST['id']) && $nombre != "" && $usuario != ""){
        //obtener datos del formulario asegurando que son validos
        $id = $_POST['id'];

        try {
            $sentencia = $conexion ->prepare("UPDATE empleados SET nombre = ?, usuario = ?, password = ? WHERE idEmpleado= ?");
            $sentencia->bindParam(1, $nombre, PDO::PARAM_STR);
            $sentencia->bindParam(2, $usuario, PDO::PARAM_STR);
            $sentencia->bindParam(3, $password, PDO::PARAM_STR);
            $sentencia->bindParam(4, $id, PDO::PARAM_STR);
            $sentencia->execute();
        } catch (PDOException $e){
            echo "ERROR: " .$e->getMessage();
        }

        // Una vez guardados los datos se redirige a la pagina principal
        header("Location: empleados_vista.php");
    } else {
        //Si el valor del id no es válido
        $error = "ERROR en el id o nombre o apellido";
        renderForm($_GET['id'],$nombre ,$usuario, $password ,$error);

    }
} else {
    // Si el formulario no se ha enviado, obtenemos los datos del formulario desde la bd y visualizamos el formulario
    if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
        //Obtenemos el id desde la URL, si este existe y se comprueba que sea valido
        // Consulta a la base de datos
        $id = $_GET['id'];

        try {
            $sentencia = $conexion->prepare("SELECT * FROM empleados WHERE idEmpleado= ?");
            $sentencia -> bindParam(1, $id, PDO::PARAM_STR);
            $sentencia->execute();

            $resultado = $sentencia->fetchAll();

            if ($resultado){
                foreach ($resultado as $empleado) {
                    $nombre = $empleado['nombre'];
                    $usuario = $empleado['usuario'];
                    $password = $empleado['password'];
                }

                // Se muestra el formulario
                renderForm($id, $nombre, $usuario, $password, "");
            } else {
                // Si no coincide
                echo "No hay resultados";
            }
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    } else {
        // Si el ID de la URL no es válido
        echo "ERROR, id no válido";
    }
}
