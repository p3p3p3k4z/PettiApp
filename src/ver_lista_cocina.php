<?php
// Conexión a la base de datos
$servername = "db"; // Nombre del servicio en docker-compose.yml
$username = "user"; // Usuario definido en docker-compose.yml
$password = "password"; // Contraseña definida en docker-compose.yml
$database = "insumos"; // Base de datos creada en docker-compose.yml


try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener categorías disponibles
    $query_categorias = "SELECT DISTINCT categoria FROM pedido_cocina";
    $stmt_categorias = $conn->prepare($query_categorias);
    $stmt_categorias->execute();
    $categorias = $stmt_categorias->fetchAll(PDO::FETCH_COLUMN);

    // Filtrar por categoría si se ha seleccionado una
    $categoria_seleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : '';

    $query_pedidos = "SELECT * FROM pedido_cocina";
    if (!empty($categoria_seleccionada)) {
        $query_pedidos .= " WHERE categoria = :categoria";
    }

    $stmt_pedidos = $conn->prepare($query_pedidos);
    if (!empty($categoria_seleccionada)) {
        $stmt_pedidos->bindParam(':categoria', $categoria_seleccionada);
    }
    $stmt_pedidos->execute();
    $pedidos = $stmt_pedidos->fetchAll(PDO::FETCH_ASSOC);

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
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    
    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f3ea;
        }
        .container {
            margin-top: 50px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-family: 'Satisfy', cursive;
            color: #6b4226;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            background-color: #6b4226 !important;
            color: white !important;
            text-align: center;
        }
        td {
            text-align: center;
        }
        tbody tr:hover {
            background-color: #f0e6d2;
        }
        .filter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .btn-cafe {
            background-color: #8c5b3f;
            color: white;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-cafe:hover {
            background-color: #6b4226;
        }
    </style>
    <title>Lista de Pedidos</title>
</head>
<body>

<div class="container">
    <h1>Lista de Productos</h1>

    <!-- Selector de Categoría -->
    <div class="filter-container">
        <label for="categoria" class="form-label"><strong>Filtrar por categoría:</strong></label>
        <select id="categoria" class="form-select w-50">
            <option value="">Todas</option>
            <?php
            // Obtener categorías únicas de la tabla
            $query = "SELECT DISTINCT categoria FROM pedido";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($categorias as $cat) {
                echo '<option value="' . htmlspecialchars($cat['categoria']) . '">' . htmlspecialchars($cat['categoria']) . '</option>';
            }
            ?>
        </select>
    </div>

    <!-- Tabla de Pedidos -->
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Empleado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr data-categoria="<?= htmlspecialchars($pedido['categoria']) ?>">
                    <td><?= htmlspecialchars($pedido['codigo']) ?></td>
                    <td><?= htmlspecialchars($pedido['nombre']) ?></td>
                    <td><?= htmlspecialchars($pedido['cantidad']) ?></td>
                    <td><?= htmlspecialchars($pedido['empleado']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Botón de regreso -->
    <div class="text-center mt-4">
        <a href="ventana_cocina.php" class="btn btn-cafe">
            <i class="bi bi-house-heart"></i> Regresar al Inicio
        </a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Filtro de Categoría (JavaScript) -->
<script>
    document.getElementById('categoria').addEventListener('change', function() {
        let categoriaSeleccionada = this.value.toLowerCase();
        document.querySelectorAll("tbody tr").forEach(row => {
            let categoria = row.getAttribute("data-categoria").toLowerCase();
            row.style.display = (categoriaSeleccionada === "" || categoria === categoriaSeleccionada) ? "" : "none";
        });
    });
</script>

</body>
</html>
