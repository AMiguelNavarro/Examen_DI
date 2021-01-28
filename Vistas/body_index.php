<?php

if (isset($_SESSION['usuario'])) {
    echo "<h1> BIENVENIDO -> ",$_SESSION['usuario']," </h1>";
}
?>

<p><a href="Vistas/clientes_vista.php"> CLIENTES </a></p>
<p><a href="Vistas/empleados_vista.php"> EMPLEADOS </a></p>
<p><a href="Vistas/productos_vista.php"> PRODUCTOS </a></p>

<?php
if (isset($_SESSION['usuario'])) {
    echo '<p><a href="Vistas/cerrar_sesion.php"> Cerrar Sesión </a></p>';
} else {
    echo '<p><a href="Vistas/inicio_sesion.php"> Iniciar Sesión </a></p>';
}
?>

