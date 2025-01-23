<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "insumos";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear tabla "pedido" si no existe
    $createTableQuery = "
        CREATE TABLE IF NOT EXISTS pedido (
            id INT AUTO_INCREMENT PRIMARY KEY,
            codigo VARCHAR(255),
            nombre VARCHAR(255),
            cantidad INT
        )";
    $conn->exec($createTableQuery);

    // Consulta para obtener los productos
    $query = "SELECT * FROM productos";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si se presionó el botón "Generar Lista"
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedido'])) {
        $pedido = json_decode($_POST['pedido'], true);

        // Insertar los productos con cantidades en la tabla "pedido"
        $conn->exec("DELETE FROM pedido"); // Limpia la tabla antes de insertar
        $insertQuery = "INSERT INTO pedido (codigo, nombre, cantidad) VALUES (:codigo, :nombre, :cantidad)";
        $stmt = $conn->prepare($insertQuery);

        foreach ($pedido as $item) {
            $stmt->execute([
                ':codigo' => $item['codigo'],
                ':nombre' => $item['nombre'],
                ':cantidad' => $item['cantidad']
            ]);
        }

        // Responder solo con el mensaje de éxito, evitando que el HTML de la página principal se cargue
        echo "Lista generada correctamente.";
        exit(); // Detener la ejecución para evitar que el HTML de la página principal se cargue
    }
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
  <title>Gestión de Productos</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <!-- Menú -->
    <div class="menu">
      <button id="menu-button">☰ Menu</button>
      <div id="menu-options" class="hidden">
        <a href="ver_lista.php">Ver Lista</a>
      </div>
    </div>



    <h1>Gestión de Productos</h1>


    <!-- Lista de productos generada dinámicamente -->
    <div class="product-list">
      <?php foreach ($productos as $producto): ?>
        <div class="product-row" data-codigo="<?= $producto['codigo']; ?>" data-nombre="<?= $producto['nombre']; ?>">
          <span class="product-code">Código: <?= $producto['codigo']; ?></span>
          <span class="product-name"><?= $producto['nombre']; ?></span>
          <div class="quantity-controls">
            <button class="action-button decrement">-</button>
            <span class="quantity-display">0</span>
            <button class="action-button increment">+</button>
          </div>
          <button class="delete-button">Eliminar</button>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Botón para generar lista -->
    <button id="generate-list">Generar Lista</button>
  </div>

  <div class="button-container">
        <a href="ventana.php" class="back-button">Volver a la página principal</a>
    </div>
  <script>
    // Ocultar línea al hacer clic en "Eliminar"
    document.querySelectorAll('.delete-button').forEach(button => {
      button.addEventListener('click', () => {
        button.parentElement.remove();
      });
    });

    // Incrementar y decrementar cantidad
    document.querySelectorAll('.increment').forEach(button => {
      button.addEventListener('click', () => {
        const quantityDisplay = button.previousElementSibling;
        quantityDisplay.textContent = parseInt(quantityDisplay.textContent) + 1;
      });
    });

    document.querySelectorAll('.decrement').forEach(button => {
      button.addEventListener('click', () => {
        const quantityDisplay = button.nextElementSibling;
        const currentQuantity = parseInt(quantityDisplay.textContent);
        if (currentQuantity > 0) {
          quantityDisplay.textContent = currentQuantity - 1;
        }
      });
    });

    // Generar lista y enviarla al servidor
    // Generar lista y enviarla al servidor
    document.getElementById('generate-list').addEventListener('click', () => {
        const rows = document.querySelectorAll('.product-row');
        const pedido = Array.from(rows).map(row => ({
            codigo: row.dataset.codigo,
            nombre: row.dataset.nombre,
            cantidad: parseInt(row.querySelector('.quantity-display').textContent)
        })).filter(item => item.cantidad > 0);

        if (pedido.length === 0) {
            alert("Debe seleccionar al menos un producto con cantidad.");
            return;
        }

        fetch('index.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'pedido=' + encodeURIComponent(JSON.stringify(pedido))
        })
        .then(response => response.text()) // Usamos .text() para recibir el mensaje
        .then(data => {
            alert(data); // Mostrar el mensaje recibido
        })
        .catch(error => console.error("Error:", error));
    });



    // Menú desplegable
    document.addEventListener("DOMContentLoaded", function () {
      const menuButton = document.getElementById('menu-button');
      const menuOptions = document.getElementById('menu-options');

      menuButton.addEventListener('click', () => {
        menuOptions.classList.toggle('hidden'); // Alterna la visibilidad del menú
      });
    });


  </script>
</body>
</html>
