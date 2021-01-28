<?php

include 'header_vistas.php';


/* SCRIPT PARA MOSTRAR UN FORMULARIO PARA EDITAR EL REGISTRO ELEGIDO. POR ID */
function renderForm($usuario, $password, $error){

    if ($error != '') {
        echo "<div style='padding:4px; border: 1px solid #ff0000; color: red;'>" .$error. "</div>";
    }
    ?>
    <form action="" method="post">
        <div>
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
    $usuario = htmlspecialchars($_POST['usuario']);
    $password = htmlspecialchars($_POST['password']);

    //Se comprueba que no estén en blanco
    if ($usuario == '' || $password == ''){
        //Error
        $error = "ERROR: debes rellenar los campos requeridos '*'";
        renderForm($usuario, $password, $error);
    } else {
        //Guardar los datos en la bd
        try {
            $sentencia = $conexion->prepare("SELECT * FROM empleados WHERE usuario = ? AND password = ?");
            $sentencia->bindParam(1, $usuario, PDO::PARAM_STR);
            $sentencia->bindParam(2, $password, PDO::PARAM_STR);

            $sentencia -> execute();

            $usuarios = $sentencia -> fetchAll(PDO::FETCH_ASSOC);

            if ($usuarios) {
                foreach ($usuarios as $usuario) {
                    session_start();
                    $_SESSION['usuario'] = $usuario['usuario'];
                }
                header("Location: ../index.php");
            } else {
                $error = "El usuario no existe";
                renderForm($usuario, $password, $error);
            }
            //Una vez se han guardado los datos, se redirige a la pagina principal 'View'

        } catch (PDOException $e){
            echo "ERROR al buscar los datos en la base de datos " .$e->getMessage();
        }
    }
} else {
// Si el formulario no se ha enviado, lo muestra vacio
    renderForm("","","");
}
?>
