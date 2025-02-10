<?php
// Incluir el archivo de conexión a la base de datos.
include 'conecta.php';

// Opcional: Desactivar la generación de excepciones en mysqli para poder controlar los errores manualmente.
mysqli_report(MYSQLI_REPORT_OFF);

// *******************************************************
// 1. Procesar el filtro por categoría (usando GET)
// *******************************************************
$filtro_categoria = "";
$where = "";
if (isset($_GET['categoria']) && $_GET['categoria'] !== "") {
    $filtro_categoria = mysqli_real_escape_string($conecta, $_GET['categoria']);
    $where = "WHERE categoria = '$filtro_categoria'";
}

// *******************************************************
// 2. Ejecutar la consulta para obtener los pedidos
// *******************************************************
$query = "SELECT * FROM pedido_final $where";
// Usamos el operador @ para suprimir errores que se mostrarían en pantalla
$result = @mysqli_query($conecta, $query);

// Si la consulta falla (por ejemplo, si la tabla no existe) o no hay registros...
if (!$result || mysqli_num_rows($result) == 0) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Sin Pedidos - PettiApp</title>
        <!-- Incluir Tailwind CSS -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <style>
            body {
                background: #f7fafc;
            }
        </style>
    </head>
    <body class="min-h-screen flex flex-col items-center justify-center">
        <div class="container mx-auto px-4 py-8 text-center">
            <h1 class="text-3xl font-semibold mb-6">Aún no existe ningún pedido.</h1>
            <a href="index.html" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Regresar al Inicio
            </a>
        </div>
    </body>
    </html>
    <?php
    exit; // Finalizamos la ejecución para que no se cargue el resto de la página.
}

// *******************************************************
// 3. Si la consulta es exitosa y hay registros, seguimos con el panel
// *******************************************************

// Procesar eliminación de pedidos (marcarlos como entregados)
if (isset($_POST['delete_selected'])) {
    if (isset($_POST['selected']) && is_array($_POST['selected']) && count($_POST['selected']) > 0) {
        $codigos = array();
        foreach ($_POST['selected'] as $codigo) {
            $codigos[] = "'" . mysqli_real_escape_string($conecta, $codigo) . "'";
        }
        $codigos_lista = implode(",", $codigos);

        $deleteQuery = "DELETE FROM pedido_final WHERE codigo IN ($codigos_lista)";
        if (mysqli_query($conecta, $deleteQuery)) {
            $mensaje = "El/los pedido(s) se han marcado como entregado(s).";
        } else {
            $mensaje = "Error al marcar como entregado: " . mysqli_error($conecta);
        }
    } else {
        $mensaje = "No se seleccionaron pedidos para marcar como entregados.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PetiApp Repartidor</title>
    <!-- Incluir Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: #f7fafc;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Encabezado -->
    <nav class="bg-gradient-to-r from-yellow-500 to-yellow-700 shadow-lg">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center">
                <!-- Cambia 'logo.png' por el logotipo de tu cafetería -->
                <img src="../images/peti/logo.png" alt="Logotipo" class="h-10 w-10 mr-3">
                <span class="text-white text-xl font-bold">Repartidor</span>
            </div>
            <div class="text-white text-lg">
                Panel de Entregas
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <h1 class="text-3xl font-semibold mb-6">Pedidos para entregar</h1>

        <!-- Mensaje de respuesta (por ejemplo, tras eliminar pedidos) -->
        <?php if (isset($mensaje)) { ?>
            <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
                <?php echo $mensaje; ?>
            </div>
        <?php } ?>

        <!-- Formulario para filtrar por categoría -->
        <div class="mb-6">
            <form method="GET" action="" class="flex items-center">
                <label for="categoria" class="mr-2 text-lg font-medium">Filtrar por categoría:</label>
                <select name="categoria" id="categoria" class="border border-gray-300 rounded p-2">
                    <option value="">Todas</option>
                    <?php
                    // Obtener las categorías existentes para llenar el select.
                    $catQuery = "SELECT DISTINCT categoria FROM pedido_final";
                    $catResult = mysqli_query($conecta, $catQuery);
                    if ($catResult && mysqli_num_rows($catResult) > 0) {
                        while ($catRow = mysqli_fetch_assoc($catResult)) {
                            $selected = ($filtro_categoria === $catRow['categoria']) ? "selected" : "";
                            echo "<option value=\"{$catRow['categoria']}\" $selected>{$catRow['categoria']}</option>";
                        }
                    }
                    ?>
                </select>
                <button type="submit" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">
                    Filtrar
                </button>
            </form>
        </div>

        <!-- Listado de Pedidos -->
        <form method="POST" action="">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-yellow-600 text-white">
                        <tr>
                            <!-- Columna de selección (checkbox) -->
                            <th class="px-6 py-3">
                                <input type="checkbox" id="select_all" onclick="toggleSelectAll(this)" class="h-5 w-5">
                            </th>
                            <th class="px-6 py-3">ID Pedido</th>
                            <th class="px-6 py-3">Código</th>
                            <th class="px-6 py-3">Producto</th>
                            <th class="px-6 py-3">Cantidad</th>
                            <th class="px-6 py-3">Empleado</th>
                            <th class="px-6 py-3">Categoría</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php
                        // Listar los pedidos ya que sabemos que existen registros.
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr class="border-b hover:bg-gray-100 transition duration-200">';
                            echo '<td class="px-6 py-4 text-center">
                                    <input type="checkbox" name="selected[]" value="' . $row['codigo'] . '" class="h-5 w-5">
                                  </td>';
                            echo '<td class="px-6 py-4">' . $row['id'] . '</td>';
                            echo '<td class="px-6 py-4">' . $row['codigo'] . '</td>';
                            echo '<td class="px-6 py-4">' . $row['nombre'] . '</td>';
                            echo '<td class="px-6 py-4">' . $row['cantidad'] . '</td>';
                            echo '<td class="px-6 py-4">' . $row['empleado'] . '</td>';
                            echo '<td class="px-6 py-4">' . $row['categoria'] . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Botón para marcar como entregado -->
            <div class="mt-6 flex justify-end">
                <button type="submit" name="delete_selected" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 transition duration-300">
                    Marcar como Entregado
                </button>
            </div>
        </form>
    </main>

    <!-- Pie de página -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="container mx-auto text-center">
            &copy; <?php echo date("Y"); ?> PetiApp.
        </div>
    </footer>

    <!-- Script para seleccionar/deseleccionar todos los checkboxes -->
    <script>
        function toggleSelectAll(source) {
            const checkboxes = document.getElementsByName('selected[]');
            for (let i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
</body>
</html>
