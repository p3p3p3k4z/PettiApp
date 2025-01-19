<?php 
// Conexión a la base de datos
$dsn = "mysql:host=mysql;dbname=my_database;charset=utf8mb4";
$user = "mysql_user";
$password = "mysql_password";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Si la conexión es exitosa
    echo "<h2>Conexión exitosa a la base de datos</h2>";
} catch (PDOException $e) {
    // Manejo de errores
    echo "<h2>Error al conectar a la base de datos</h2>";
    echo "<p>Detalles: " . $e->getMessage() . "</p>";
    exit;
}
?>
