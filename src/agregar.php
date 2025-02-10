<?php
// Habilitar la visualización de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a la base de datos
include 'conecta.php';

// Obtener los datos enviados desde JavaScript (JSON)
$productos = json_decode(file_get_contents('php://input'), true);

// Verificar si los productos están vacíos
if (empty($productos['productos'])) {
    echo "No se recibieron productos.";
    exit;
}

// Mostrar los datos recibidos para depuración
var_dump($productos['productos']);  // Verifica si los datos están siendo recibidos correctamente

// Comenzar a insertar cada producto en la tabla "agregados"
foreach ($productos['productos'] as $producto) {
    // Escapar los valores para prevenir inyecciones SQL
    $codigo = mysqli_real_escape_string($conecta, $producto['codigo']);
    $nombre = mysqli_real_escape_string($conecta, $producto['nombre']);
    $categoria = mysqli_real_escape_string($conecta, $producto['categoria']);

    // Consulta para insertar el producto en la tabla "agregados"
    $query = "INSERT INTO productos (codigo, nombre, categoria) VALUES ('$codigo', '$nombre', '$categoria')";

    // Ejecutar la consulta y verificar si se insertó correctamente
    if (mysqli_query($conecta, $query)) {
        echo "Producto guardado correctamente.";
    } else {
        // Mostrar el error exacto de la consulta
        echo "Error al guardar el producto: " . mysqli_error($conecta);
        exit;  // Detener la ejecución si ocurre un error
    }
}
?>

