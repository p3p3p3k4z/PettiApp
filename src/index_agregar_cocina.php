<?php
// Conexión a la base de datos
include 'conecta.php';

// Hacer la búsqueda ya sea por nombre o código
$busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';

if ($busqueda != '') {
    // Consulta que busca por código o nombre
    $query = "SELECT * FROM productos_generales 
              WHERE codigo LIKE '%$busqueda%' 
                 OR nombre LIKE '%$busqueda%'";
    
    $resultado = mysqli_query($conecta, $query);
}

// Verificar si el producto ya está en la base de datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verificarProducto'])) {
  $codigo = mysqli_real_escape_string($conecta, $_POST['codigo']);

  // Consulta para verificar si el producto ya está en la tabla "productos_cocina"
  $query = "SELECT * FROM productos_cocina WHERE codigo = '$codigo'";
  $resultado = mysqli_query($conecta, $query);

  if (mysqli_num_rows($resultado) > 0) {
      echo json_encode(["status" => "error", "message" => "Producto ya fue agregado anteriormente"]);
  } else {
      echo json_encode(["status" => "success", "message" => "Producto no encontrado, puede agregarse"]);
  }
  exit(); // Importante para que el script termine aquí y no cargue el HTML innecesariamente
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
  <link rel="stylesheet" href="css/agregar.css"> 
  <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
	<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet"> <!--Totally optional :) -->
</head>

<body>

  <!-- Sección del buscador -->
  <div class="custom-container d-flex align-items-center justify-content-center">
    <nav class="navbar navbar-expand-lg navbar-custom">
      <div class="container-fluid">
        <a class="navbar-brand ingrid-darling-regular" style="color:rgb(252, 232, 216);">
        <img src="https://app.petirrojo.mx/ci/uploads/apppetirrojo/logos/logo_header_mini.png" alt="Logo PetiApp" width="60" height="60">
          PetiApp</a>
        <form class="d-flex mx-auto p-2" role="search" method="POST">
          <input class="form-control me-2 w" type="search" placeholder="Escribe lo que estas buscando"
            aria-label="Search" id="buscadorcito" name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>">
          <button class="btn custom-btn yuji-syuku-regular" type="submit">Buscar</button>
        </form>
              <!-- Nombre del usuario -->
        <div class="ms-auto">
          <span class="navbar-text yuji-syuku-regular" style="color:rgb(252, 232, 216); font-size: 25px; " id="nom-usario">
            Carlitos
          </span>
        </div>

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
        echo '<p style="color:#f8f6f0;">No se encontraron productos que coincidan con la búsqueda.</p>';
    }
    ?>
  </div>

  <!-- Botón de listo -->
  <button class="btn bt-listo yuji-syuku-regular d-flex justify-content-center" type="submit" id="listo">Listo</button>

  <!--PARTE DE REGRESAR A CASA-->
  <div class="regresar">
    <a  href="ventana_cocina.php" class="-sourgummy-1" style="display: flex; align-items: center;"><i class="bi bi-house-heart"><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-house-heart" viewBox="0 0 20 20">
  <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.309 8 6.982"/>
  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.707L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.646a.5.5 0 0 0 .708-.707L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
</svg></i><span style="margin-left: 10px;">Regresar al Inicio</span></a>
  </div>

  <script>
// Recuperar productos guardados en localStorage al cargar la página
let productosAgregados = JSON.parse(localStorage.getItem('productosAgregados')) || [];

document.querySelectorAll('.btn-agregar').forEach(button => {
    button.addEventListener('click', async function() {
        const productCodigo = this.getAttribute('data-codigo');
        const productName = this.getAttribute('data-name');
        const productCategory = this.getAttribute('data-category');
        const productEmpleado = document.getElementById('nom-usario').innerText;

        // Verificar si el producto ya está en el localStorage
        const productoExistente = productosAgregados.some(p => p.codigo === productCodigo);

        if (productoExistente) {
            alert("Este producto ya fue agregado.");
        } else {
            // Verificar si el producto existe en la base de datos
            const existe = await verificarProducto(productCodigo);

            if (existe) {
                alert("Producto ya fue agregado anteriormente en la base de datos");
            } else {
                const producto = {
                    codigo: productCodigo,
                    nombre: productName,
                    categoria: productCategory,
                    empleado: productEmpleado
                };

                productosAgregados.push(producto);
                localStorage.setItem('productosAgregados', JSON.stringify(productosAgregados)); // Guardar en localStorage
                alert("Producto agregado correctamente.");
                console.log("Producto agregado:", productosAgregados);
            }
        }
    });
});

// Función para limpiar el almacenamiento cuando se presiona "Listo"
document.getElementById('listo').addEventListener('click', async function() {
    if (productosAgregados.length > 0) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'agregar_cocina.php', true); // Cambiado a agregar_cocina.php
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === "success") {
                        alert(response.message);
                        productosAgregados = []; // Limpiar productos agregados
                        localStorage.removeItem('productosAgregados');
                    } else {
                        alert("⚠ Error: " + response.message);
                    }
                } catch (e) {
                    console.error("Error al procesar respuesta del servidor:", xhr.responseText);
                    alert("⚠ Error inesperado en la respuesta del servidor.");
                }
            }
        };

        // Enviar productos en el mismo request
        console.log("📤 Enviando productos:", JSON.stringify({ productos: productosAgregados }));
        xhr.send(JSON.stringify({ productos: productosAgregados }));
    } else {
        alert('⚠ No has agregado productos');
    }
});

// Función para verificar si el producto ya existe en la base de datos
async function verificarProducto(codigo) {
    return new Promise((resolve) => {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'index_agregar_cocina.php', true); // Cambiado a index_agregar_cocina.php
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const response = JSON.parse(xhr.responseText);
                resolve(response.status === "error"); // Si el producto ya está, devuelve true
            }
        };
        xhr.send(`verificarProducto=true&codigo=${codigo}`);
    });
}
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>