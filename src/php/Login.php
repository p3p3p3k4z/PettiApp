<?php
header("Content-Type: application/json");
include('../conecta.php'); // Importar la conexión

session_start(); // Iniciar sesión

$data = json_decode(file_get_contents('php://input'), true);

// Verificar que se envió la solicitud correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['phone']) && isset($data['password'])) {
    $phone = $data['phone'];
    $password = $data['password'];

    // Consulta segura con `prepare()`
    $stmt = $conecta->prepare('SELECT id, phone, password, nombre, area FROM empleados WHERE phone = ?');
    $stmt->bind_param('s', $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Comparar la contraseña en texto plano
        if ($password === $user['password']) {  // ⚠️ Comparación directa sin password_verify()
            // Guardar datos en sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['area'] = $user['area'];

            // Determinar la URL de redirección
            $redirectUrl = match ($user['area']) {
                'barra' => './ventana.php',
                'cocina' => './ventana_cocina.php',
                'admin' => './administra.php',
                'repartidor' => './repartidor.php',
                default => 'index.html'
            };

            echo json_encode(['success' => true, 'redirectUrl' => $redirectUrl]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Número de teléfono no encontrado.']);
    }

    $stmt->close();
    $conecta->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud no válida.']);
}
?>
