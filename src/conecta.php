<?php 
// Declarar las variables de conexión para la base de datos en Docker
$servidor = "db"; // Nombre del servicio MySQL en docker-compose.yml
$usuario = "user"; // Usuario definido en docker-compose.yml
$password = "password"; // Contraseña definida en docker-compose.yml
$bd = "insumos";

// Crear conexión
$conecta = mysqli_connect($servidor, $usuario, $password, $bd);

// Validar conexión
if (!$conecta) {
    die('Error de conexión: ' . mysqli_connect_error());
}
?>
