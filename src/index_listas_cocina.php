<?php
// Configuración de conexión a la base de datos en Docker
$servername = "db"; // Nombre del servicio en docker-compose.yml
$username = "user"; // Usuario definido en docker-compose.yml
$password = "password"; // Contraseña definida en docker-compose.yml
$database = "insumos"; // Base de datos creada en docker-compose.yml

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear tabla "pedido_cocina" si no existe
    $createTableQuery = "
        CREATE TABLE IF NOT EXISTS pedido_cocina (
            id INT AUTO_INCREMENT PRIMARY KEY,
            codigo VARCHAR(255),
            nombre VARCHAR(255),
            categoria VARCHAR(255),
            cantidad VARCHAR(255),
            empleado VARCHAR(255)
        )";
    $conn->exec($createTableQuery);

    // Consulta para obtener los productos de cocina
    $query = "SELECT codigo, nombre, categoria FROM productos_cocina";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $productos_cocina = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si se presionó el botón "Generar Lista"
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Decodificar los datos JSON recibidos
        $data = json_decode(file_get_contents('php://input'), true);
        $pedido_cocina = $data['pedido'];
        $empleado = $data['empleado'];

        // Insertar los productos con cantidades en la tabla "pedido_cocina"
        $conn->exec("DELETE FROM pedido_cocina"); // Limpia la tabla antes de insertar
        $insertQuery = "INSERT INTO pedido_cocina (codigo, nombre, categoria, cantidad, empleado) VALUES (:codigo, :nombre, :categoria, :cantidad, :empleado)";
        $stmt = $conn->prepare($insertQuery);

        foreach ($pedido_cocina as $item) {
            $stmt->execute([
                ':codigo' => $item['codigo'],
                ':nombre' => $item['nombre'],
                ':categoria' => $item['categoria'],
                ':cantidad' => $item['cantidad'],
                ':empleado' => $empleado
            ]);
        }

        // Responder con un mensaje de éxito
        echo json_encode(["message" => "Lista generada correctamente por: " . $empleado]);
        exit();
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Error al conectar a la base de datos: " . $e->getMessage()]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Productos</title>
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
      position: relative;
    }
    h1 {
      font-family: 'Satisfy', cursive;
      color: #6b4226;
      text-align: center;
      margin-bottom: 20px;
    }
    .product-list table {
      width: 100%;
      border-collapse: collapse;
    }
    .product-list th,
    .product-list td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    .product-list tr:hover {
      background-color: #f0e6d2;
      transform: scale(1.02);
      transition: transform 0.2s ease, background-color 0.2s ease;
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
    .btn-outline-danger {
      border-color: #dc3545;
      color: #dc3545;
    }
    .btn-outline-danger:hover {
      background-color: #dc3545;
      color: white;
    }
    .btn-success {
      background-color: rgb(216, 35, 35);
      color: white;
      border-radius: 5px;
      transition: 0.3s;
    }
    .btn-success:hover {
      background-color: rgb(199, 34, 34);
    }
    .hidden {
      display: none;
    }
    .header-image {
      position: absolute;
      top: 20px;
      right: 20px;
      width: 100px;
      height: auto;
    }
  </style>
</head>
<>
  <div class="container">
    <!-- Imagen en la esquina superior derecha -->
    <img src="https://www3.gobiernodecanarias.org/medusa/wiki/images/9/99/Petirrojo.png" alt="Logo" class="header-image">

    <!-- Menú desplegable -->
    <div class="menu">
      <button id="menu-button" class="btn btn-cafe">☰ Menú</button>
      <div id="menu-options" class="hidden">
        <a href="ver_lista.php" class="dropdown-item">Ver Lista</a>
      </div>
    </div>

    <!-- Título de la página -->
    <h1>Gestión de Productos</h1>

    <!-- Lista de productos -->
    <div class="product-list">
      <table>
        <thead>
          <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($productos as $producto): ?>
            <!-- Fila de producto -->
            <tr class="product-row" data-codigo="<?= $producto['codigo']; ?>" data-nombre="<?= $producto['nombre']; ?>" data-categoria="<?= $producto['categoria']; ?>">
              <td class="product-code"><?= $producto['codigo']; ?></td> <!-- Código del producto -->
              <td class="product-name"><?= $producto['nombre']; ?></td> <!-- Nombre del producto -->
              <td>
                <!-- Campo de texto para ingresar la cantidad y unidad -->
                <input type="text" class="form-control quantity-input" placeholder="Ej: 1 kg">
              </td>
              <td>
                <!-- Botón para eliminar el producto de la lista -->
                <button class="btn btn-outline-danger delete-button">Eliminar</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Botón para generar la lista -->
    <div class="text-center mt-4">
      <button id="generate-list" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#empleadoModal">Generar Lista</button>
    </div>

    <!-- Botón para regresar al inicio -->
    <div class="text-center mt-4">
      <a href="ventana.php" class="btn btn-cafe">
        <i class="bi bi-house-heart"></i> Regresar al Inicio
      </a>
    </div>
  </div>

  <!-- Modal para ingresar el nombre del empleado -->
  <div class="modal fade" id="empleadoModal" tabindex="-1" aria-labelledby="empleadoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="empleadoModalLabel">Ingrese su nombre</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="text" id="empleadoNombre" class="form-control" placeholder="Nombre del empleado">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="confirmarGenerar">Generar Lista</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Scripts personalizados -->
  <script>
    // Eliminar una fila de producto al hacer clic en "Eliminar"
    document.querySelectorAll('.delete-button').forEach(button => {
      button.addEventListener('click', () => {
        button.closest('tr').remove(); // Elimina la fila más cercana al botón
      });
    });

    // Generar la lista y enviarla al servidor
    // Generar la lista y enviarla al servidor
    document.getElementById('confirmarGenerar').addEventListener('click', () => {
        const empleado = document.getElementById('empleadoNombre').value.trim(); // Obtener el nombre del empleado
        if (!empleado) {
            alert("Por favor, ingrese su nombre.");
            return;
        }

        const rows = document.querySelectorAll('.product-row'); // Obtener todas las filas de productos
        const pedido_cocina = Array.from(rows).map(row => ({
            codigo: row.dataset.codigo,
            nombre: row.dataset.nombre,
            categoria: row.dataset.categoria,
            cantidad: row.querySelector('.quantity-input').value.trim()
        })).filter(item => item.cantidad !== ""); // Filtrar solo los productos con cantidad ingresada

        // Validar que al menos un producto tenga cantidad ingresada
        if (pedido_cocina.length === 0) {
            alert("Debe ingresar la cantidad para al menos un producto.");
            return;
        }

        // Enviar los datos al servidor usando fetch
        fetch('index_lista.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json' // Indicar que se envía JSON
            },
            body: JSON.stringify({ pedido_cocina, empleado }) // Enviar los datos como JSON
        })
        .then(response => response.json()) // Leer la respuesta como JSON
        .then(data => {
            if (data.error) {
                alert(data.error); // Mostrar error si existe
            } else {
                alert(data.message); // Mostrar mensaje de éxito
                window.location.reload(); // Recargar la página
            }
        })
        .catch(error => console.error("Error:", error)); // Manejar errores
    });

    // Mostrar/ocultar el menú desplegable
    document.addEventListener("DOMContentLoaded", function () {
      const menuButton = document.getElementById('menu-button');
      const menuOptions = document.getElementById('menu-options');

      menuButton.addEventListener('click', () => {
        menuOptions.classList.toggle('hidden'); // Alternar la visibilidad del menú
      });
    });
  </script>
</body>
</html>
