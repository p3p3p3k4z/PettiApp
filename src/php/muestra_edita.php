<?php
// Incluir la conexión
include '../conecta.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Recuperar el tipo que fue enviado
$tipo = $_GET['tipo'];

// Solo mostrar si el tipo es 'editable'
if ($tipo == 'editable') {
    // Realizar la consulta para obtener los pedidos
    $query = "SELECT * FROM pedido ORDER BY categoria"; // Organiza por categoría
    $result = mysqli_query($conecta, $query);

    if (mysqli_num_rows($result) > 0) {
        // Inicializar la variable para almacenar la categoría actual
        $categoria_actual = null;

        echo '<div class="overflow-x-auto shadow-lg sm:rounded-lg">';
        echo '<form id="formulario_pedido" action="php/editar.php" method="POST" class="mt-4 text-center">';
        
        // Campo oculto para saber si el formulario fue enviado
        echo '<input type="hidden" name="enviar_repartidor" value="1">';

        echo '<table class="min-w-full table-auto border-collapse bg-white text-sm text-left text-gray-500">';
        echo '<thead class="text-s text-yellow-50 uppercase bg-yellow-900 sour-gummy-1">';
        echo '<tr>';
        echo '<th class="px-6 py-3">ID</th>';
        echo '<th class="px-6 py-3">Código</th>';
        echo '<th class="px-6 py-3">Nombre</th>';
        echo '<th class="px-6 py-3">Cantidad</th>';
        echo '<th class="px-6 py-3">Empleado</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Mostrar los registros agrupados por categoría
        while ($row = mysqli_fetch_assoc($result)) {
            // Verifica si la categoría cambió
            if ($categoria_actual != $row['categoria']) {
                // Mostrar una fila de encabezado de categoría
                echo '<tr class="bg-red-700 ">';
                echo '<td colspan="5" class="px-4 py-1 font-semibold text-red-50">' . $row['categoria'] . '</td>';
                echo '</tr>';
                $categoria_actual = $row['categoria']; // Actualizar la categoría actual
            }

            // Mostrar los productos
            echo '<tr class="odd:bg-white even:bg-gray-200">';
            echo '<td class="px-6 py-4 ">' . $row['id'] . '</td>';
            echo '<td class="px-6 py-4">' . $row['codigo'] . '</td>';
            echo '<td class="px-6 py-4">' . $row['nombre'] . '</td>';
            echo '<td class="px-6 py-4">
                    <input type="number" name="cantidad[' . $row['id'] . ']" value="' . $row['cantidad'] . '" min="1" class="form-input border border-gray-300 rounded-md p-1" />
                  </td>';
            echo '<td class="px-6 py-4">' . $row['empleado'] . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

        // Botón para enviar los datos al procesador
        echo '<button type="submit" class="bg-yellow-700 hover:bg-yellow-900 text-white font-bold py-2 px-4 rounded">Enviar al repartidor</button>';
        echo '</form>';
        echo '</div>';

        
    } else {
        echo 'No hay registros en la base de datos.';
    }
} else {
    echo 'Opción no editable seleccionada.';
}

?>
