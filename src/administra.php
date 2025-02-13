<?php
//incluir la conexion 
include 'conecta.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <!--Fuentes de google font / letritas-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Ole&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Ingrid+Darling&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Yuji+Syuku&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Yuji+Mai&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">  
    <title>Ventana Administrador</title>
    <link rel="stylesheet" href="css/ventana_admin.css"> 
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
    <!-- Estilos personalizados para el botón de cerrar sesión -->
    <style>
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
     <!-- Sección de bienvenida, logo y usuario-->
  <div class="custom-container d-flex align-items-center justify-content-center">
    <nav class="navbar navbar-expand-lg navbar-custom">
      <div class="container-fluid">
        <a class="navbar-brand ingrid-darling-regular" style="color:rgb(252, 232, 216);">
        <img src="https://app.petirrojo.mx/ci/uploads/apppetirrojo/logos/logo_header_mini.png" alt="Logo PetiApp" width="60" height="60">
          PetiApp</a>
              <!-- Nombre del usuario -->
        <div class="ms-auto">
          <span class="navbar-text yuji-syuku-regular" style="color:rgb(252, 232, 216); font-size: 25px; " id="nom-usario">
            TRUISTAN
          </span>
        </div>
        <!-- Botón de cerrar sesión -->
        <button class="logout-btn" onclick="logout()">Cerrar sesión</button>
      </div>
    </nav>
  </div>
      </div>
    </nav>
  </div>

  <!-- Línea decorativa  y quee contiene  las opciones -->
  <div class="linea-separa custom-container d-flex align-items-center justify-content-center flex-wrap justify-center gap-2">
    <!-- Agregamos los botones bonitos ver lista y modificar barra, cocina// surtir lista,lista general, enviar lista a repartidor-->
    <button type="button" class="sour-gummy-1 text-l text-white bg-gradient-to-r from-red-400 hover:from-red-600  via-red-500 hover:via-red-800  to-red-600 hover:to-red-950 
    focus:outline-none font-large rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 min-w-[180px]" id="LBarra">
  Lista de Barra
</button>
<button type="button" class=" sour-gummy-1 text-xl text-white bg-gradient-to-r from-red-400 hover:from-red-600  via-red-500 hover:via-red-800  to-red-600 hover:to-red-950 
    focus:outline-none font-large rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2  min-w-[180px]" id="LCocina">
  Lista de Cocina
</button>
<button type="button" class=" sour-gummy-1 text-xl text-white bg-gradient-to-r from-red-400 hover:from-red-600  via-red-500 hover:via-red-800  to-red-600 hover:to-red-950 
    focus:outline-none font-large rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 min-w-[180px]" id="LGeneral">
  Lista general
</button>
<button type="button" class=" sour-gummy-1 text-xl text-white bg-gradient-to-r from-red-400 hover:from-red-600  via-red-500 hover:via-red-800  to-red-600 hover:to-red-950 
    focus:outline-none font-large rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 min-w-[180px]" id="Editable">
  Separar por categorias y editar
</button>
<button type="button" class=" sour-gummy-1 text-xl text-white bg-gradient-to-r from-red-400 hover:from-red-600  via-red-500 hover:via-red-800  to-red-600 hover:to-red-950 
    focus:outline-none font-large rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 min-w-[180px]" id="Surtir">
    Surtir 
</button>
  </div>

  <!-- Área para mostrar las listas -->
<div id="lista" class="container mt-4">
  <!-- Aquí se cargará la vista dinámica -->
</div>

<script>
  // Función para manejar los clics en los botones
document.getElementById('LBarra').addEventListener('click', function() {
    cargarLista('barra');
});

document.getElementById('LCocina').addEventListener('click', function() {
    cargarLista('cocina');
});
document.getElementById('LGeneral').addEventListener('click', function() {
    cargarLista('general');
});
document.getElementById('Editable').addEventListener('click', function() {
    cargarLista('editable');
});
document.getElementById('Surtir').addEventListener('click', function() {
    cargarLista('surtir');
});

// Función para cargar la lista a través de AJAX
function cargarLista(tipo) {
    console.log("Cargando lista para tipo: " + tipo); // Verificar el tipo recibido
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'php/mostrar_lista.php?tipo=' + tipo, true);
    
    xhr.onload = function() {
        console.log("Respuesta del servidor: " + xhr.status); // Mostrar el código de estado HTTP

        if (xhr.status == 200) {
            // Verificar que el contenido sea válido
            console.log("Contenido recibido: " + xhr.responseText); // Ver el contenido recibido
            document.getElementById('lista').innerHTML = xhr.responseText;
        } else {
            console.log('Error al cargar la lista, código de estado: ' + xhr.status);
        }
    };
    
    xhr.onerror = function() {
        console.log('Hubo un error en la solicitud AJAX');
    };

    xhr.send();
}

// Función para cerrar sesión
function logout() {
    // Redirigir a index.html
    window.location.href = "index.html";
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
    
</body>
</html>