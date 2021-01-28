<?php
$nombrebd = 'examen';
$usuario = 'root';
$contrasenia = '';

try {
    $driver = "mysql:host=localhost;dbname=$nombrebd";
    $conexion = new PDO($driver, $usuario, $contrasenia, array(PDO::ATTR_PERSISTENT => true, PDO:: ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    // ERRMODE_EXCEPTION para que si hay un fallo, se lance una excepción capturable y se controle correctamente
    // ATTR_ERRMODE determina lo que ocurrira si se produce un fallo en una operación con la bas de datos
} catch (PDOException $e) {
    echo "Error de conexión: " . $e -> getMessage();

}
