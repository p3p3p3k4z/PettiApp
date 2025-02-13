<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PetiApp - Cafetería Clásica</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- FontAwesome para iconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  
  <!-- Estilos personalizados -->
  <style>
    body {
      font-family: Arial, sans-serif; /* Fuente básica */
      background-color: #f5f3ea; /* Fondo crema */
      color: #5B2333; /* Texto café oscuro */
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #922C40; /* Rojo oscuro */
      padding: 20px;
      text-align: center;
      font-size: 2rem;
      color: #ffffff; /* Texto blanco */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      position: relative; /* Para posicionar el botón de cerrar sesión */
    }
    header img {
      width: 60px;
      vertical-align: middle;
      margin-right: 10px;
    }
    .menu {
      display: flex;
      justify-content: space-around;
      padding: 20px;
      background-color: #ffffff; /* Fondo blanco */
      border-bottom: 2px solid #922C40; /* Línea decorativa roja */
    }
    .menu a {
      color: #5B2333; /* Texto café oscuro */
      text-decoration: none;
      font-size: 1.2rem;
      display: flex;
      align-items: center;
      padding: 10px 20px;
      border-radius: 10px;
      background-color: #f5f3ea; /* Fondo crema */
      transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
    }
    .menu a:hover {
      transform: translateY(-5px) scale(1.05); /* Efecto de salto */
      box-shadow: 0 8px 15px rgba(146, 44, 64, 0.3); /* Sombra roja */
      background-color: #922C40; /* Fondo rojo al pasar el cursor */
      color: #ffffff; /* Texto blanco al pasar el cursor */
    }
    .menu a i {
      margin-right: 10px;
    }
    .container {
      text-align: center;
      margin-top: 20px;
      padding: 20px;
      background-color: #ffffff; /* Fondo blanco */
      border-radius: 15px;
      width: 80%;
      margin-left: auto;
      margin-right: auto;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .container p {
      font-size: 1.2rem;
      color: #5B2333; /* Texto café oscuro */
    }
    .regresar {
      position: fixed;
      bottom: 0;
      left: 0;
      margin: 10px;
      color: #5B2333; /* Texto café oscuro */
    }
    .regresar a {
      color: #5B2333; /* Texto café oscuro */
      text-decoration: none;
      transition: color 0.3s ease;
    }
    .regresar a:hover {
      color: #922C40; /* Rojo oscuro al pasar el cursor */
    }
    /* Estilos para el botón de cerrar sesión */
    .logout-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      background-color: #ff4444; /* Color de fondo */
      color: white; /* Color del texto */
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }
    .logout-btn:hover {
      background-color: #cc0000; /* Cambia el color al pasar el ratón */
    }
  </style>
</head>
<body>
  <header>
    <img src="https://app.petirrojo.mx/ci/uploads/apppetirrojo/logos/logo_header_mini.png" alt="Logo PetiApp">
    Gestion de Insumos
    <!-- Botón de cerrar sesión -->
    <button class="logout-btn" onclick="logout()">Cerrar sesión</button>
  </header>

  <div class="menu">
    <a href="index_agregar.php">
      <i class="fas fa-search"></i>
      Buscar Insumo
    </a>
    <a href="index_lista.php">
      <i class="fas fa-list"></i>
      Generar Lista
    </a>
    <a href="ver_lista.php">
      <i class="fas fa-eye"></i>
      Ver Lista
    </a>
    <a href="nota.html">
      <i class="fas fa-edit"></i>
      Notas
    </a>
  </div>

  <div class="container">
    <p>ventana beta.</p>
  </div>

  <div class="regresar">
    <a href="ventana.php">Regresar al Inicio</a>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script para cerrar sesión -->
  <script>
    function logout() {
      // Redirigir a index.html
      window.location.href = "index.html";
    }
  </script>
</body>
</html>





