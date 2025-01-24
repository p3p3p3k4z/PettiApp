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
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">  
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
      <!--PARTE DE REGRESAR A CASA-->
  <div class="regresar">
    <a  href="ventana.php" class="sour-gummy-1"><i class="bi bi-house-heart"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-house-heart" viewBox="0 0 20 20">
  <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.309 8 6.982"/>
  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.707L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.646a.5.5 0 0 0 .708-.707L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
</svg></i>Regresar al Inicio</a>
  </div>
</body>
</html>
