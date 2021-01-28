<?php

include 'header_vistas.php';

try {

    $statement = $conexion -> prepare('SELECT * FROM empleados');
    $statement -> execute();

    $empleados = $statement -> fetchAll(PDO::FETCH_ASSOC);

    // Se visualizan todos los datos en una tabla
    // Se muestran los links necesarios para ver sin paginar o paginados.
    // El parametro ?page, nos indicará al tener valor 1 que es primera página de resultados posibles
    echo "<p><b>Ver todos</b> | <a href='ver_paginados_empleados.php?page=1'>Ver paginados</a> | <a href='../index.php'>INICIO</a></p>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr> <th>Nombre</th> <th>Usuario</th> <th> </th></tr>";
//    <th>ID</th>

    foreach ($empleados as $empleado) {
        echo "<tr>";

        echo "<td>" ,$empleado['nombre'], "</td>";
        echo "<td>" ,$empleado['usuario'], "</td>";

        if (isset($_SESSION['usuario'])){
            echo "<td><a href='editar_empleados.php?id=", $empleado['idEmpleado'],"'>Editar</a></td>";
        }

        echo "</tr>";
    }

    echo"</table>";

} catch (PDOException $pdoe){
    echo "Error al mostrar los datos ", $pdoe->getMessage();
}

if (isset($_SESSION['usuario'])){
    echo "<p><a href='insertar_empleado.php'>Añadir Registro</a></p>";
} else{
    echo "<p><a href='inicio_sesion.php'>Inicia sesión</a> para añadir un nuevo empleado</p>";
}



include 'footer.php';
