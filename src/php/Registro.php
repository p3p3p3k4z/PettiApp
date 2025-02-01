<?php
header("Content-Type: application/json");
include('conecta.php');

// Obtener los datos enviados en la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si se recibieron los datos necesarios
if (isset($data['phone'])) {
    $phone = $data['phone'];

    // Limpiar el número de teléfono
    $cleanPhone = preg_replace('/^MX \+52\s*/', '', $phone); // Eliminar "MX +52" al inicio
    $cleanPhone = preg_replace('/\D/', '', $cleanPhone); // Eliminar cualquier carácter no numérico
    //$cleanPhone = preg_replace('/[^0-9]/', '', $phone);

    // Consultar en la base de datos si el teléfono ya está registrado
    $stmt = $conn->prepare('SELECT COUNT(*) FROM registro WHERE phone = ?');
    $stmt->bind_param('s', $cleanPhone);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // Si el teléfono ya está registrado, devolver "true"
    if ($count > 0) {
        echo json_encode(['exists' => true]);
    } else {
        // Si el teléfono no está registrado, proceder con la inserción de datos
        if (isset($data['firstName'], $data['password'], $data['age'], $data['address'], $data['area'])) {
            $firstName = $data['firstName'];
            $password = $data['password']; // Encriptar la contraseña
            $age = $data['age'];
            $address = $data['address'];
            $area = $data['area'];

            // Insertar los datos en la base de datos
            $insertStmt = $conn->prepare('INSERT INTO registro (firstName, password, age, phone, address, area) VALUES (?, ?, ?, ?, ?, ?)');
            // Limpiar el número de teléfono (eliminando el prefijo "MX +52" y caracteres no numéricos)
            //$clean_Phone = preg_replace('/^MX \+52\s*/', '', $phone); // Eliminar "MX +52" al inicio
            //$clean_Phone = preg_replace('/\D/', '', $clean_Phone); // Eliminar cualquier carácter no numérico

            $insertStmt->bind_param('ssisss', $firstName, $password, $age, $cleanPhone, $address, $area);

            if ($insertStmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Registro exitoso']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Hubo un error al registrar los datos']);
            }

            $insertStmt->close();
        } else {
            echo json_encode(['error' => 'Faltan datos necesarios para el registro']);
        }
    }
} else {
    echo json_encode(['error' => 'No se recibió el número de teléfono.']);
}

$conn->close();
?>
