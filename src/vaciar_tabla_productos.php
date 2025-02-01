<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'insumos';

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
echo "Conexión exitosa.<br>";

// Probar consulta
$sql = "DELETE FROM productos";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'productos' vaciada correctamente.";
} else {
    echo "Error al vaciar la tabla: " . $conn->error;
}

$conn->close();
?>
