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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">  
  <title>SELECCION</title>
  <style>
    .regresar {
          color:antiquewhite;
          position: fixed; /* Fijo en la pantalla */
          bottom: 0; /* Alinear en la parte inferior */
          left: 0; /* Alinear al lado izquierdo */
         margin: 10px; /* Margen opcional para separar un poco del borde */
          display: flex; /* Por si deseas usar flexbox para contenido adicional */
          align-items: flex-start; /* Alinear al inicio del eje cruzado si es necesario */
          justify-content: flex-start; /* Alinear al inicio del eje principal */
}

.sour-gummy-1 {
  font-family: "Sour Gummy", serif;
  font-optical-sizing: auto;
  font-weight: 500;
  font-style: normal;
  font-variation-settings:50;
}

a{
  color:antiquewhite;
  text-decoration: none;
  
}
a:hover{
  color:white;
  text-decoration: underline;
  
}
  </style>
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


    <!--PARTE DE REGRESAR A CASA-->
  <div class="regresar">
    <a  href="ventana.php" class="sour-gummy-1"><i class="bi bi-house-heart"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-house-heart" viewBox="0 0 20 20">
  <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.309 8 6.982"/>
  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.707L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.646a.5.5 0 0 0 .708-.707L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
</svg></i>Regresar al Inicio</a>
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
        

        // Solicitud para vaciar la tabla "productos" en la base de datos
        fetch('vaciar_tabla_productos.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        })
        .then(response => response.text())
        .then(result => {
            alert("Tabla de productos vaciada: " + result);
        })
        .catch(error => console.error("Error al vaciar la tabla:", error));
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
