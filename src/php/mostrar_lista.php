<?php
// Incluir el archivo de conexión
include '../conecta.php';

// Verificar si la conexión fue exitosa
if (!$conecta) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Comprobar que el tipo se pasa correctamente
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'general'; // Valor predeterminado 'general'

// Lógica para cargar las listas según el tipo
if ($tipo == 'editable') {
    // Cargar el archivo muestra_edita.php para mostrar la lista editable
    include 'muestra_edita.php';
} else {
    // Aquí se define la consulta SQL según el tipo de lista
    if ($tipo == 'barra') {
        $query = "SELECT * FROM vista_pedidos_barra";
    } elseif ($tipo == 'cocina') {
        $query = "SELECT * FROM vista_pedidos_cocina";
    } elseif ($tipo == 'surtir') {
        // Si el tipo es 'surtir', pasar la consulta a surtiendo.php
        include 'surtiendo.php';
        exit; // Asegurarse de que el script no continúe después de incluir surtiendo.php
    } elseif ($tipo == 'general') {
        $query = "SELECT * FROM pedido"; 
    } else {
        echo 'Tipo de lista no válido.';
        exit;
    }

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
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo "No se encontraron resultados.";
        }
    } else {
        // Mostrar el error de la consulta
        echo "Error en la consulta: " . mysqli_error($conecta);
    }
}
?>
