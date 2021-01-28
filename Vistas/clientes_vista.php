<?php

include 'header_vistas.php';

try {

    $statement = $conexion -> prepare('SELECT * FROM clientes');
    $statement -> execute();

    $clientes = $statement -> fetchAll(PDO::FETCH_ASSOC);

    // Se visualizan todos los datos en una tabla
    // Se muestran los links necesarios para ver sin paginar o paginados.
    // El parametro ?page, nos indicará al tener valor 1 que es primera página de resultados posibles
    echo "<p><b>Ver todos</b> | <a href='ver_paginados_clientes.php?page=1'>Ver paginados</a> | <a href='../index.php'>INICIO</a></p> ";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr> <th>Nombre</th> <th>Apellido</th> <th>Codigo Postal</th> <th> </th></tr>";
//    <th>ID</th>

    foreach ($clientes as $cliente) {
        echo "<tr>";

        echo "<td>" ,$cliente['nombre'], "</td>";
        echo "<td>" ,$cliente['apellidos'], "</td>";
        echo "<td>" ,$cliente['codPostal'], "</td>";

        if (isset($_SESSION['usuario'])) {
            echo "<td><a href='editar_clientes.php?id=", $cliente['idCliente'],"'>Editar</a></td>";
        }


        echo "</tr>";
    }

    echo"</table>";

} catch (PDOException $pdoe){
    echo "Error al mostrar los datos ", $pdoe->getMessage();
}

if (isset($_SESSION['usuario'])) {
    echo "<p><a href='insertar_cliente.php'>Añadir Registro</a></p>";
} else {
    echo "<p><a href='inicio_sesion.php'>Inicia sesión</a> para añadir un nuevo cliente</p>";
}



include 'footer.php';
