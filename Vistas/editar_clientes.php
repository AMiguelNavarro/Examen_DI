<?php

include 'header_vistas.php';


/* SCRIPT PARA MOSTRAR UN FORMULARIO PARA EDITAR EL REGISTRO ELEGIDO. POR ID */
function renderForm($id, $nombre, $apellido, $codPostal, $error){

    if ($error != '') {
        echo "<div style='padding:4px; border: 1px solid #ff0000; color: red;'>" .$error. "</div>";
    }
    ?>

    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <div>
            <p><strong>ID:</strong><?php echo $id; ?></strong></p>
            <strong>Nombre: *</strong> <input type="text" name="nombre" value="<?php echo $nombre; ?>"/><br/>
            <strong>Apellido: *</strong> <input type="text" name="apellido" value="<?php echo $apellido; ?>"/><br/>
            <strong>Codigo Postal: *</strong> <input type="number" name="codPostal" value="<?php echo $codPostal; ?>"/><br/>
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
    $apellido = htmlspecialchars($_POST['apellido']);
    $codPostal = htmlspecialchars($_POST['codPostal']);

    //Confirmar que el id es válido
    if (is_numeric($_POST['id']) && $nombre != "" && $apellido != ""){
        //obtener datos del formulario asegurando que son validos
        $id = $_POST['id'];

        try {
            $sentencia = $conexion ->prepare("UPDATE clientes SET nombre = ?, apellidos = ?, codPostal = ? WHERE idCliente= ?");
            $sentencia->bindParam(1, $nombre, PDO::PARAM_STR);
            $sentencia->bindParam(2, $apellido, PDO::PARAM_STR);
            $sentencia->bindParam(3, $codPostal, PDO::PARAM_STR);
            $sentencia->bindParam(4, $id, PDO::PARAM_STR);
            $sentencia->execute();
        } catch (PDOException $e){
            echo "ERROR: " .$e->getMessage();
        }

        // Una vez guardados los datos se redirige a la pagina principal
        header("Location: clientes_vista.php");
    } else {
        //Si el valor del id no es válido
        $error = "ERROR en el id o nombre o apellido";
        renderForm($_GET['id'],$nombre ,$apellido,$codPostal ,$error);

    }
} else {
    // Si el formulario no se ha enviado, obtenemos los datos del formulario desde la bd y visualizamos el formulario
    if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
        //Obtenemos el id desde la URL, si este existe y se comprueba que sea valido
        // Consulta a la base de datos
        $id = $_GET['id'];

        try {
            $sentencia = $conexion->prepare("SELECT * FROM clientes WHERE idCliente= ?");
            $sentencia -> bindParam(1, $id, PDO::PARAM_STR);
            $sentencia->execute();

            $resultado = $sentencia->fetchAll();

            if ($resultado){
                foreach ($resultado as $cliente) {
                    $nombre = $cliente['nombre'];
                    $apellido = $cliente['apellidos'];
                    $codPostal = $cliente['codPostal'];
                }

                // Se muestra el formulario
                renderForm($id, $nombre, $apellido, $codPostal, "");
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

