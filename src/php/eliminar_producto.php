<?php
// Incluir el archivo de conexión
include '../conecta.php';

// Verificar si se ha recibido el código del producto
if (isset($_POST['codigo'])) {
    $codigo = mysqli_real_escape_string($conecta, $_POST['codigo']); // Sanitizar entrada

    // Eliminar el producto solo de la tabla 'pedido_final'
    $delete_pedido_final = "DELETE FROM pedido_final WHERE codigo = '$codigo'";

    if (mysqli_query($conecta, $delete_pedido_final)) {
        echo 'Producto eliminado de pedido_final correctamente.';
    } else {
        echo 'Error al eliminar en pedido_final: ' . mysqli_error($conecta);
    }
} else {
    echo 'Código no recibido.';
}
echo '<script>window.location.href = "../administra.php";</script>';
exit();
?>