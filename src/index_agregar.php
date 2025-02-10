<?php
// Conexión a la base de datos
include 'conecta.php';

// Inicializar la variable de búsqueda
$busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';

// Si la búsqueda no está vacía, realiza la consulta
if ($busqueda != '') {
    $query = "SELECT * FROM productos_generales WHERE nombre LIKE '%$busqueda%'";
    $resultado = mysqli_query($conecta, $query);
} else {
    $resultado = [];  // Si no hay búsqueda, no se ejecuta la consulta
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!--Fuentes de HTML-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Ole&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Ingrid+Darling&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Yuji+Syuku&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Yuji+Mai&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">  
  <title>SELECCION</title>
    <style>
    body {
      background-color: #410218;
    }

    .navbar-custom {
      background-color: #f5e5b8;
      margin-top: 15px;
      height: 10vh;
      width: 100vw;
      box-shadow: 0 5px 8px rgba(0, 0, 0, 0.584);
      margin-bottom: 10px;
    }

    /* Línea de decoración después del div */
    .linea-separa {
      height: 10px;
      background-color: #baa690;
      margin-top: 15px;
      margin-bottom: 10px;
    }

    .p1 {
      color: #fff;
    }

    /* CSS de fuentes de letra */
    .ole-regular {
      font-family: "Ole", serif;
      font-weight: 500;
      font-style: normal;
      font-size: 50PX;
    }

    .ingrid-darling-regular {
      font-family: "Ingrid Darling", serif;
      font-weight: 550;
      font-style: normal;
      font-size: 50PX;
    }

    .yuji-syuku-regular {
      font-family: "Yuji Syuku", serif;
      font-weight: 900;
      font-style: normal;
      font-size: large;
    }

    .yuji-syuku-regular2 {
      font-family: "Yuji Syuku", serif;
      font-weight: 900;
      font-style: normal;
      font-size: xx-large;
    }
    .yuji-syuku-regular3{
      font-family: "Yuji Syuku", serif;
      font-weight: 400;
      font-style: normal;
      font-size: large;
    }
    .yuji-mai-regular {
      font-family: "Yuji Mai", serif;
      font-weight: 900;
      font-style: normal;
    }

    /* Botón de buscar */
    .custom-btn {
      background-color: rgb(236, 225, 225);
      color: #2c0411;
      border: 2px solid;
      border-radius: 5px;
      border-color: #2c0411;
    }

    .custom-btn:hover {
      background-color: #2c0411;
      border: 2px solid;
      border-radius: 5px;
      border-color: #320132;
      color: antiquewhite;
    }

    /* Estilos para la lista de productos */
    #espacio-lista ul {
      list-style-type: none;
      padding: 0;
    }

    #espacio-lista li {
      background-color: #fff;
      color: #410218;
      padding: 10px;
      margin: 5px 0;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    #espacio-lista li:hover {
      background-color: #f5e5b8;
      cursor: pointer;
    }

    /* Botón verde de agregar */
.btn-agregar {
  background-color: #850731; /* rojito */
  color: white;
  border: none;
  padding: 5px 15px;
  border-radius: 5px;
  margin-left: 60px; /* Espacio de 20px entre el texto y el botón */
  border-color: #850746;/*rojito chiquito*/ 
}

.btn-agregar:hover {
  background-color: #3b0118f0; /* Verde oscuro */
  color: antiquewhite;
  cursor: pointer;
}

.bt-listo{
  text-align: center;
  background-color: rgb(236, 225, 225);
      color: black;
      border: 2px solid;
      border-radius: 5px;
      border-color: #320132
      display: block;
  margin: 0 auto; /* Centra el botón */
}
.bt-listo:hover{
  text-align: center;
  background-color: #2c0411;
      color: antiquewhite;;
      border: 2px solid;
      border-radius: 5px;
      border-color: #320132
      display: block;
  margin: 0 auto; /* Centra el botón */
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
  <!-- Sección del buscador -->
  <div class="custom-container d-flex align-items-center justify-content-center">
    <nav class="navbar navbar-expand-lg navbar-custom">
      <div class="container-fluid">
        <a class="navbar-brand ingrid-darling-regular">PetiApp</a>
        <form class="d-flex mx-auto p-2" role="search" method="POST">
          <input class="form-control me-2 w" type="search" placeholder="Escribe lo que estas buscando"
            aria-label="Search" id="buscadorcito" name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>">
          <button class="btn custom-btn yuji-syuku-regular" type="submit">Buscar</button>
        </form>
      </div>
    </nav>
  </div>

  <!-- Línea decorativa -->
  <div class="linea-separa"></div>

  <!-- Texto que indica tabla de que es -->
  <div class="d-flex justify-content-center">
    <p class="p1 text-center yuji-syuku-regular2">LISTA DE PRODUCTOS</p>
  </div>

  <!-- Generación de lista -->
  <div class="d-flex justify-content-center" id="espacio-lista">
    <?php
    if (!empty($resultado) && mysqli_num_rows($resultado) > 0) {
        echo '<ul>';
        while ($producto = mysqli_fetch_assoc($resultado)) {
            echo '<li>';
            echo htmlspecialchars($producto['nombre']);
            // Aquí agregamos los atributos data-codigo, data-name, y data-category al botón
            echo ' <button class="btn-agregar yuji-syuku-regular3" data-codigo="' . $producto['codigo'] . '" data-name="' . $producto['nombre'] . '" data-category="' . $producto['categoria'] . '">Agregar</button>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo 'No se encontraron productos que coincidan con la búsqueda.';
    }
    ?>
  </div>

  <!-- Botón de listo -->
  <button class="btn bt-listo yuji-syuku-regular d-flex justify-content-center" type="submit" id="listo">Listo</button>

  <!--PARTE DE REGRESAR A CASA-->
  <div class="regresar">
    <a  href="ventana.php" class="sour-gummy-1"><i class="bi bi-house-heart"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-house-heart" viewBox="0 0 20 20">
  <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.309 8 6.982"/>
  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.707L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.646a.5.5 0 0 0 .708-.707L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
</svg></i>Regresar al Inicio</a>
  </div>
  <script>
    let productosAgregados = [];

    document.querySelectorAll('.btn-agregar').forEach(button => {
      button.addEventListener('click', function() {
        const productCodigo = this.getAttribute('data-codigo'); // Obtener el codigo del producto
        const productName = this.getAttribute('data-name'); // Obtener el nombre del producto
        const productCategory = this.getAttribute('data-category'); // Obtener la categoría del producto
        agregarProducto(productCodigo, productName, productCategory);
      });
    });

    // Función para agregar el producto al array con todos sus datos
    function agregarProducto(productCodigo, productName, productCategory) {
      // Crear un objeto con los datos del producto
      const producto = {
        codigo: productCodigo, // Usamos "codigo" en lugar de "id"
        nombre: productName,
        categoria: productCategory
      };

      // Verificar si el producto ya está en el array
      if (!productosAgregados.some(p => p.codigo === productCodigo)) {
        productosAgregados.push(producto); // Agregar el objeto completo al array
        console.log("Producto agregado:", producto);
        alert('Producto agregado correctamente');
      } else {
        alert('Este producto ya ha sido agregado');
      }
    }

    // Función para enviar los productos agregados al servidor cuando se haga clic en "Listo"
    document.getElementById('listo').addEventListener('click', function() {
      if (productosAgregados.length > 0) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'agregar.php', true);  // Ahora enviamos a index_agregar.php
        xhr.setRequestHeader('Content-Type', 'application/json'); // Cambiar el tipo de contenido
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            console.log("Respuesta del servidor:", xhr.responseText); // Verificar la respuesta
            alert('Productos guardados correctamente');
            productosAgregados = []; // Limpiar la lista de productos agregados después de guardarlos
            console.log("Productos agregados después de guardar:", productosAgregados);
          }
        };
        console.log("Enviando productos:", JSON.stringify({ productos: productosAgregados })); // Verificar los productos que se están enviando
        xhr.send(JSON.stringify({ productos: productosAgregados })); // Enviar los productos agregados como JSON
      } else {
        alert('No has agregado productos');
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>
