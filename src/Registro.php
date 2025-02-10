<?php
$servidor = "db";
$usuario = "user";
$password = "password";
$bd = "insumos";

// Crear conexión
$conn = new mysqli($servidor, $usuario, $password, $bd);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $area = $_POST['area'];

    // Validar si el número de teléfono ya existe en la base de datos
    $sql = "SELECT * FROM empleados WHERE phone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si ya existe un registro con ese teléfono
        echo "<script>alert('El número de teléfono ya está registrado.'); window.location.href = 'index.html';</script>";
    } else {
        // Si el número no existe, realizar el insert
        $stmt = $conn->prepare("INSERT INTO empleados (nombre, phone, password, area) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $phone, $password, $area);

        if ($stmt->execute()) {
            echo "<script>alert('Registro exitoso.'); window.location.href = 'index.html';</script>";
        } else {
            echo "<script>alert('Error en el registro.'); window.location.href = 'index.html';</script>";
        }
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>
