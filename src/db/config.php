<?php
$servername = "localhost";
$username = "chris";
$password = "PATIT0DEHULE";
$dbname = "tpi";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
