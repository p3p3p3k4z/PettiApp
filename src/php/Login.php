<?php
header("Content-Type: application/json");
include('conecta.php');

// Obtener el cuerpo de la solicitud en formato JSON
$data = json_decode(file_get_contents('php://input'), true);

// Ruta para validación de login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($data['phone']) && isset($data['password'])) {
    $phone = $data['phone'];
    $password = $data['password'];

    // Consulta SQL para verificar el login
    $stmt = $conn->prepare('SELECT * FROM registro WHERE phone = ? AND password = ?');
    $stmt->bind_param('ss', $phone, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $area = $user['area'];

        // Determinar la URL de redirección según el área
        if ($area === 'cocina') {
            $redirectUrl = 'ventana.php';
        } else if ($area === 'admin') {
            $redirectUrl = 'admin.php';
        } else if ($area === 'repartidor') {
            $redirectUrl = 'repartidor.php';
        } else {
            $redirectUrl = 'index.html';
        }

        echo json_encode(['success' => true, 'redirectUrl' => $redirectUrl]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos.']);
    }
}
$conn->close();
?>
