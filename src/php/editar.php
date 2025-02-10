<?php
// Incluir la conexión
include '../conecta.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si se ha presionado el botón "Enviar al repartidor"
if (isset($_POST['enviar_repartidor'])) {
    // Verificar si la tabla 'pedido_final' existe, si no, crearla
    $check_table_query = "SHOW TABLES LIKE 'pedido_final'";
    $check_result = mysqli_query($conecta, $check_table_query);
    
    if (mysqli_num_rows($check_result) == 0) {
        // Crear la tabla 'pedido_final' si no existe
        $create_table_query = "CREATE TABLE pedido_final (
            id INT AUTO_INCREMENT PRIMARY KEY,
            codigo VARCHAR(50),
            nombre VARCHAR(100),
            cantidad INT,
            empleado VARCHAR(100),
            categoria VARCHAR(50)
        )";
        if (!mysqli_query($conecta, $create_table_query)) {
            echo 'Error al crear la tabla pedido_final: ' . mysqli_error($conecta);
            exit();
        }
    }

    // Ahora procesamos los datos enviados en el formulario
    if (isset($_POST['cantidad'])) {
        // Recorremos los valores de cantidad enviados
        foreach ($_POST['cantidad'] as $id => $cantidad) {
            // Asegurarnos de que el ID y la cantidad no estén vacíos
            if (!empty($id) && !empty($cantidad)) {
                // Recuperar los datos del pedido
                $query = "SELECT * FROM pedido WHERE id = $id";
                $result = mysqli_query($conecta, $query);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);

                    // Insertar en la tabla 'pedido_final'
                    $insert_query = "INSERT INTO pedido_final (codigo, nombre, cantidad, empleado, categoria) 
                                     VALUES ('" . mysqli_real_escape_string($conecta, $row['codigo']) . "', '" . mysqli_real_escape_string($conecta, $row['nombre']) . "', " . intval($cantidad) . ", '" . mysqli_real_escape_string($conecta, $row['empleado']) . "', '" . mysqli_real_escape_string($conecta, $row['categoria']) . "')";
                    
                    if (!mysqli_query($conecta, $insert_query)) {
                        echo 'Error al insertar en pedido_final: ' . mysqli_error($conecta);
                        exit(); // Detener el proceso si hay un error en la inserción
                    }
                }
            }
        }

        // Mostrar mensaje de éxito
        echo '<script>alert("¡Pedidos enviados al repartidor correctamente!");</script>';
    } else {
        // Si no se enviaron cantidades
        echo '<script>alert("No se han recibido cantidades para enviar.");</script>';
    }
} else {
    // Si no se presionó el botón
    echo 'Opción no editable seleccionada.';
}

?>
