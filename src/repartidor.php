<?php
// Configuración de conexión a la base de datos
$servername = "db"; // Nombre del servicio en docker-compose.yml
$username = "user"; // Usuario definido en docker-compose.yml
$password = "password"; // Contraseña definida en docker-compose.yml
$database = "insumos"; // Base de datos creada en docker-compose.yml

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Procesar la solicitud para eliminar pedidos seleccionados
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
        if (!empty($_POST['ids'])) {
            $ids = $_POST['ids']; // IDs de los pedidos seleccionados
            $placeholders = implode(',', array_fill(0, count($ids), '?')); // Crear placeholders para la consulta
            $deleteQuery = "DELETE FROM pedido WHERE id IN ($placeholders)";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->execute($ids);
            echo "<p>Pedidos eliminados correctamente.</p>";
        } else {
            echo "<p>No se seleccionaron pedidos para eliminar.</p>";
        }
    }

    // Obtener el filtro de búsqueda (si existe)
    $filtroNombre = isset($_GET['filtro_nombre']) ? $_GET['filtro_nombre'] : '';

    // Consulta para obtener los pedidos (filtrados por nombre si es necesario)
    $query = "SELECT * FROM pedido";
    if (!empty($filtroNombre)) {
        $query .= " WHERE nombre LIKE :filtro_nombre";
    }
    $stmt = $conn->prepare($query);
    if (!empty($filtroNombre)) {
        $stmt->bindValue(':filtro_nombre', "%$filtroNombre%", PDO::PARAM_STR);
    }
    $stmt->execute();
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .search-box {
            margin-bottom: 20px;
        }
        .search-box input {
            padding: 5px;
            width: 200px;
        }
        .search-box button {
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <h1>Lista de Pedidos</h1>

    <!-- Formulario de búsqueda por nombre -->
    <div class="search-box">
        <form method="GET" action="">
            <input type="text" name="filtro_nombre" placeholder="Filtrar por nombre" value="<?= htmlspecialchars($filtroNombre) ?>">
            <button type="submit">Buscar</button>
        </form>
    </div>

    <!-- Formulario para eliminar pedidos seleccionados -->
    <form method="POST" action="">
        <table>
            <thead>
                <tr>
                    <th>Seleccionar</th>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pedidos)): ?>
                    <tr>
                        <td colspan="5">No hay pedidos registrados.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><input type="checkbox" name="ids[]" value="<?= $pedido['id'] ?>"></td>
                            <td><?= htmlspecialchars($pedido['id']) ?></td>
                            <td><?= htmlspecialchars($pedido['codigo']) ?></td>
                            <td><?= htmlspecialchars($pedido['nombre']) ?></td>
                            <td><?= htmlspecialchars($pedido['cantidad']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <br>
        <button type="submit" name="eliminar">Eliminar Seleccionados</button>
    </form>
</body>
</html>