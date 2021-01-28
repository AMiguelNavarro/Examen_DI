<?php

include 'header_vistas.php';

if (!isset($_SESSION['usuario'])){
    header("Location: ../index.php");
}

/* SCRIPT PARA MOSTRAR UN FORMULARIO PARA EDITAR EL REGISTRO ELEGIDO. POR ID */
function renderForm($nombre, $precio, $idCategoria, $error){

    if ($error != '') {
        echo "<div style='padding:4px; border: 1px solid #ff0000; color: red;'>" .$error. "</div>";
    }
    ?>
    <form action="" method="post">
        <div>
            <strong>Nombre: *</strong> <input type="text" name="nombre" value="<?php echo $nombre; ?>"/><br/>
            <strong>Precio: *</strong> <input type="text" name="precio" value="<?php echo $precio; ?>"/><br/>
            <strong>ID Categoria: *</strong> <input type="number" name="idCategoria" value="<?php echo $idCategoria; ?>"/><br/>
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
    $precio = htmlspecialchars($_POST['precio']);
    $idCategoria = htmlspecialchars($_POST['idCategoria']);

    //Se comprueba que no estén en blanco
    if ($nombre == '' || $precio == '' || $idCategoria == '') {
        //Error
        $error = "ERROR: debes rellenar los campos requeridos '*'";
        renderForm($nombre, $precio, $idCategoria, $error);
    } else {
        //Guardar los datos en la bd
        try {
            $sentencia = $conexion->prepare("INSERT INTO productos (Nombre, Precio, idCategoria) VALUES (?,?,?)");
            $sentencia->bindParam(1, $nombre, PDO::PARAM_STR);
            $sentencia->bindParam(2, $precio, PDO::PARAM_STR);
            $sentencia->bindParam(3, $idCategoria, PDO::PARAM_STR);

            $sentencia -> execute();
            //Una vez se han guardado los datos, se redirige a la pagina principal 'View'
            header("Location: productos_vista.php");
        } catch (PDOException $e){
            echo "ERROR al guardar los datos en la base de datos " .$e->getMessage();
        }
    }
} else {
// Si el formulario no se ha enviado, lo muestra vacio
    renderForm("","","", "");
}
?>


