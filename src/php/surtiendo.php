<?php
// Incluir el archivo de conexión
include '../conecta.php';

// Consulta SQL para 'surtir'
$query = "SELECT * FROM pedido_final";

// Ejecutar la consulta
$result = mysqli_query($conecta, $query);

// Verificar si la consulta fue exitosa
if ($result) {
    // Verificar si hay resultados
    if (mysqli_num_rows($result) > 0) {
        // Crear la tabla con clases de Tailwind
        echo '<div class="relative overflow-x-auto shadow-xl sm:rounded-lg">';
        echo '<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">';
        echo '<thead class="text-s text-yellow-50 uppercase bg-yellow-900 sour-gummy-1">';
        echo '<tr class="odd:bg-gray-400 even:bg-gray-600 border-b-2 border-yellow-800">';
        echo '<th scope="col" class="px-6 py-3">ID Pedido</th>';
        echo '<th scope="col" class="px-6 py-3">Código Producto</th>';
        echo '<th scope="col" class="px-6 py-3">Nombre Producto</th>';
        echo '<th scope="col" class="px-6 py-3">Cantidad</th>';
        echo '<th scope="col" class="px-6 py-3">Empleado</th>';
        echo '<th scope="col" class="px-6 py-3">Categoría</th>';
        echo '<th scope="col" class="px-6 py-3">Acción</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Recorrer los resultados y mostrarlos en filas
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">';
            echo '<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">' . $row['id'] . '</td>';
            echo '<td class="px-6 py-4">' . $row['codigo'] . '</td>';
            echo '<td class="px-6 py-4">' . $row['nombre'] . '</td>';
            echo '<td class="px-6 py-4">' . $row['cantidad'] . '</td>';
            echo '<td class="px-6 py-4">' . $row['empleado'] . '</td>';
            echo '<td class="px-6 py-4">' . $row['categoria'] . '</td>';
            echo '<td class="px-6 py-4">
                    <form action="php/eliminar_producto.php" method="POST">
                        <input type="hidden" name="codigo" value="' . $row['codigo'] . '">
                        <button type="submit" class="bg-yellow-900 text-white px-4 py-2 rounded">Listo</button>
                    </form>
                  </td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';

          // 🔹 BOTÓN "SURTIR TODO"
          echo '<div class="flex justify-center mt-4">';
          echo '<form action="php/elimar_todosF.php" method="POST">';
          echo '    <button type="submit" class="bg-yellow-900 hover:bg-yellow-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">Surtir Todo</button>';
          echo '</form>';
          echo '</div>';
    } else {
        echo "No se encontraron resultados.";
    }
} else {
    // Mostrar el error de la consulta
    echo "Error en la consulta: " . mysqli_error($conecta);
}
?>