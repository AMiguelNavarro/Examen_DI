<?php

session_start();

include 'header_vistas.php';

/* SCRIPT PARA MOSTRAR UN FORMULARIO PARA EDITAR EL REGISTRO ELEGIDO. POR ID */
function renderForm($nombre, $usuario, $password, $error){

    if ($error != '') {
        echo "<div style='padding:4px; border: 1px solid #ff0000; color: red;'>" .$error. "</div>";
    }
    ?>
    <form action="" method="post">
        <div>
            <strong>Nombre: *</strong> <input type="text" name="nombre" value="<?php echo $nombre; ?>"/><br/>
            <strong>Usuario: *</strong> <input type="text" name="usuario" value="<?php echo $usuario; ?>"/><br/>
            <strong>Password: *</strong> <input type="text" name="password" value="<?php echo $password; ?>"/><br/>
            <p>* Requerido</p>
            <input type="submit" name="submit" value="Enviar"/>
        </div>
    </form>
    </body>
    </html>
    <?php
}

//Comprobar si se ha enviado
if (isset($_POST['submit'])){
    //Recogemos los datos
    $nombre = htmlspecialchars($_POST['nombre']);
    $usuario = htmlspecialchars($_POST['usuario']);
    $password = htmlspecialchars($_POST['password']);

    //Se comprueba que no estén en blanco
    if ($nombre == '' || $usuario == '' || $password == '') {
        //Error
        $error = "ERROR: debes rellenar los campos requeridos '*'";
        renderForm($nombre, $usuario, $password, $error);
    } else {
        //Guardar los datos en la bd
        try {
            $sentencia = $conexion->prepare("INSERT INTO empleados (nombre, usuario, password) VALUES (?,?,?)");
            $sentencia->bindParam(1, $nombre, PDO::PARAM_STR);
            $sentencia->bindParam(2, $usuario, PDO::PARAM_STR);
            $sentencia->bindParam(3, $password, PDO::PARAM_STR);

            $sentencia -> execute();
            //Una vez se han guardado los datos, se redirige a la pagina principal 'View'
            header("Location: empleados_vista.php");
        } catch (PDOException $e){
            echo "ERROR al guardar los datos en la base de datos " .$e->getMessage();
        }
    }
} else {
// Si el formulario no se ha enviado, lo muestra vacio
    renderForm("","","", "");
}
?>


