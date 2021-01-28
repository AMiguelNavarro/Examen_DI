<?php

session_start();

include 'header_vistas.php';

try {

    $statement = $conexion -> prepare('SELECT * FROM productos');
    $statement -> execute();

    $productos = $statement -> fetchAll(PDO::FETCH_ASSOC);

    // Se visualizan todos los datos en una tabla
    // Se muestran los links necesarios para ver sin paginar o paginados.
    // El parametro ?page, nos indicará al tener valor 1 que es primera página de resultados posibles
    echo "<p><b>Ver todos</b> | <a href='ver_paginados_productos.php?page=1'>Ver paginados</a> | <a href='../index.php'>INICIO</a></p>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr> <th>Nombre</th> <th>Precio</th> <th>Id Categoria</th> <th> </th></tr>";
//    <th>ID</th>

    foreach ($productos as $producto) {
        echo "<tr>";

        echo "<td>" ,$producto['Nombre'], "</td>";
        echo "<td>" ,$producto['Precio'], "</td>";
        echo "<td>" ,$producto['idCategoria'], "</td>";

        echo "<td><a href='editar_productos.php?id=", $producto['idProducto'],"'>Editar</a></td>";

        echo "</tr>";
    }

    echo"</table>";

} catch (PDOException $pdoe){
    echo "Error al mostrar los datos ", $pdoe->getMessage();
}

echo "<p><a href='Vistas/iniciarSesion.php'>Inicia sesión</a> para añadir un nuevo cliente</p>";
echo "<p><a href='insertar_producto.php'>Añadir Registro</a></p>";

include 'footer.php';
