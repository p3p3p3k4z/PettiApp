<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "insumos";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los datos de la tabla "pedido"
    $query = "SELECT * FROM pedido";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Lista</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #5B2333;
            color: white;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #762D40;
        }
        th, td {
            border: 1px solid #fff;
            text-align: center;
            padding: 10px;
        }
        th {
            background-color: #922C40;
        }
        .button-container {
            text-align: center;
            margin: 20px;
        }
        .back-button {
            display: inline-block;
            text-decoration: none;
            color: white;
            background-color: #922C40;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #B54050;
        }
    </style>
</head>
<body>
    <h1>Lista de Productos</h1>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= htmlspecialchars($pedido['codigo']) ?></td>
                    <td><?= htmlspecialchars($pedido['nombre']) ?></td>
                    <td><?= htmlspecialchars($pedido['cantidad']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="button-container">
        <a href="ventana.php" class="back-button">Volver a la página principal</a>
    </div>
</body>
</html>
