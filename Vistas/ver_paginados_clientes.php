<?php

include 'header_vistas.php';

// Numero de resultados a mostrar por página
$porPagina = 3;

//Pagina a mostrar y el inicio del registro a mostrar
$page = 1;
$inicio = 0;

if (isset($_GET["page"])) {
    $page = $_GET["page"];
    $inicio = ($page - 1) * $porPagina;
}

try {
    // Ver el nº total de registros de la tabla. Configurar preparestatement
    $statement = $conexion->prepare("SELECT * FROM clientes");
    $statement->execute();

    $totalResultados = $statement->rowCount();
}catch (PDOException $pdoe){
    echo "ERROR: ", $pdoe->getMessage();
}

// Total de paginas
$totalPaginas = ceil($totalResultados / $porPagina);

try {
    $sql = "SELECT * FROM clientes LIMIT " . $inicio . "," . $porPagina;
    $resultado = $conexion->prepare($sql);
    $resultado->execute();
} catch (PDOException $e){
    echo "ERROR: " .$e->getMessage();
}

echo "<p><a href='clientes_vista.php'>Ver todas</a> | <a href='../index.php'>INICIO</a></p> | <b>Ver Página</b> ";

// mostrar los distintos indices de las paginas, si es que hay varias
if ($totalPaginas > 1){
    for ($i = 1; $i <= $totalPaginas; $i++){
        if ($page == $i){
            echo $page . " ";
        } else {
            echo "<a href='ver_paginados_clientes.php?page=". $i . "'>" .$i. "</a>";
        }
    }
}

echo "</p>";

// Se pinta la tabla
echo "<table border='1' cellpadding='10'>";
echo "<tr> <th>Nombre</th> <th>Apellido</th> <th>Codigo Postal</th> <th> </th></tr>";

while ($fila = $resultado->fetchAll(PDO::FETCH_ASSOC)) {
    foreach ($fila as $cliente) {
        echo "<tr>";
        echo "<td>" ,$cliente['nombre'], "</td>";
        echo "<td>" ,$cliente['apellidos'], "</td>";
        echo "<td>" ,$cliente['codPostal'], "</td>";

        if (isset($_SESSION['usuario'])) {
            echo "<td><a href='editar_clientes.php?id=", $cliente['idCliente'],"'>Editar</a></td>";
        }
        echo "</tr>";
    }
}

echo "</table>";

if (isset($_SESSION['usuario'])) {
    echo "<p><a href='insertar_cliente.php'>Añadir Registro</a></p>";
} else {
    echo "<p><a href='inicio_sesion.php'>Inicia sesión</a> para añadir un nuevo cliente</p>";
}
