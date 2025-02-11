<?php
// Habilitar la visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conectar a la base de datos
include 'conecta.php';

// Verificar si la conexión es válida
if (!$conecta) {
    die(json_encode(["status" => "error", "message" => "Error de conexión: " . mysqli_connect_error()]));
}

// Obtener datos JSON desde JavaScript
$productos = json_decode(file_get_contents('php://input'), true);

// Verificar si se recibieron productos
if (empty($productos['productos'])) {
    echo json_encode(["status" => "error", "message" => "No se recibieron productos."]);
    exit;
}

// Inicializar respuesta
$response = ["status" => "success", "message" => "Productos guardados correctamente", "productos" => []];

foreach ($productos['productos'] as $producto) {
    $codigo = mysqli_real_escape_string($conecta, $producto['codigo']);
    $nombre = mysqli_real_escape_string($conecta, $producto['nombre']);
    $categoria = mysqli_real_escape_string($conecta, $producto['categoria']);
    $empleado = mysqli_real_escape_string($conecta, $producto['empleado']); // Asegurar que se recibe el valor

    // Asegurar que todos los valores están presentes
    if (empty($codigo) || empty($nombre) || empty($categoria) || empty($empleado)) {
        echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios."]);
        exit;
    }

    // Insertar producto con el campo 'empleado'
    $query = "INSERT INTO productos (codigo, nombre, categoria, empleado) VALUES ('$codigo', '$nombre', '$categoria', '$empleado')";

    if (mysqli_query($conecta, $query)) {
        $response['productos'][] = ["codigo" => $codigo, "nombre" => $nombre, "empleado" => $empleado];
    } else {
        $response["status"] = "error";
        $response["message"] = "Error al guardar el producto: " . mysqli_error($conecta);
        echo json_encode($response);
        exit;
    }
}

// Respuesta final en JSON
echo json_encode($response);
?>
