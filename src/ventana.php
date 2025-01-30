<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Markazi+Text:wght@400..700&family=Yuji+Mai&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Syne+Mono&display=swap" rel="stylesheet">    
<link href="https://fonts.googleapis.com/css2?family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<title>Ventana-Principal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ba9f85; /* Color vino */
            color: white;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #5d2728;
            /*background-color: #8C2F39; /* Color rojo oscuro */
            padding: 1rem;
            text-align: center;

        }
        header h1 {
            margin: 0;
            font-size: 2rem;
        }
        nav {
            background-color: #947151;
            width: 200px; /* Ancho del menú */
            height: 100vh; /* Alto igual al de la pantalla */
            width: 20vh;
            position: fixed; /* Fijo al lado izquierdo */
            top: 50; /*distancia de arriba*/
            left: 0;
            display: flex;
            flex-direction: column; /* Alinear contenido en vertical */
            align-items: left; /*centra horizontal*/
            justify-content:center; /*centra vertical*/
            
            padding-top: 4rem;
            box-shadow: 2px 0 4px rgba(0, 0, 0, 0.4);

        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 1.2rem;
            padding-bottom: 4rem;
    
        }
        nav a:hover {
            text-decoration: underline;
            color: #3f1608;

        }
        .container {
             margin-left: 200px; /* Ajustar según el ancho del nav */
            padding: 2rem;
            text-align: center;
        }
        .yuji-mai-regular {
  font-family: "Yuji Mai", serif;
  font-weight: 500;
  font-style: normal;
}
        .markazi-text-titulo {
  font-family: "Markazi Text", serif;
  font-optical-sizing: 600;
  font-weight: 600;
  font-style: normal;
}
.syne-mono-regular {
  font-family: "Syne Mono", serif;
  font-weight: 640;
  font-style: normal;
}
    .sour-gummy-1 {
  font-family: "Sour Gummy", serif;
  font-optical-sizing: auto;
  font-weight: 600;
  font-style: normal;
  font-variation-settings:50;
}

       .linea1{
        background: #8c463f;
        margin bottom: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.400);
        height: 8px
       }
    </style>
</head>
<body>
    <header>
        <h1 class="syne-mono-regular " >Bienvenido a PetiApp</h1>
    </header>
    <div class="linea1"></div>
    <div>
    <nav>
        <a href="index_agregar.php" class="sour-gummy-1"><i class="bi bi-search-heart" padding-right="2rem"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-search-heart" viewBox="0 0 23 23"  >
  <path d="M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018"/>
  <path d="M13 6.5a6.47 6.47 0 0 1-1.258 3.844q.06.044.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11"/>
</svg></i>Buscar Insumo</a>
        <a href="index.php " class="sour-gummy-1"><i class="bi bi-card-list"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-card-list" viewBox="0 0 24 24">
  <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
  <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
</svg></i>Generar Lista</a>
        <a href="ver_lista.php" class="sour-gummy-1"><i class="bi bi-eyeglasses"><svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-eyeglasses" viewBox="0 0 20 20">
  <path d="M4 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4m2.625.547a3 3 0 0 0-5.584.953H.5a.5.5 0 0 0 0 1h.541A3 3 0 0 0 7 8a1 1 0 0 1 2 0 3 3 0 0 0 5.959.5h.541a.5.5 0 0 0 0-1h-.541a3 3 0 0 0-5.584-.953A2 2 0 0 0 8 6c-.532 0-1.016.208-1.375.547M14 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0"/>
</svg></i>Ver Lista</a>
        <a href="tablero_nota/nota.html" class="sour-gummy-1"><i class="bi bi-pencil-square"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 25 25">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
</svg></i>Notas</a>
    </nav>
    </div>
    <div class="container">
        <p>¡Bienvenido! es una beta del programa.</p>
    </div>
</body>
</html>
