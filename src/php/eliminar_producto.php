<?php
// Incluir el archivo de conexión
include '../conecta.php';

// Verificar si se ha recibido el código del producto
if (isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];

    // Consulta SQL para eliminar el producto de las tres tablas
    $query = "
        DELETE p, pf, pr
        FROM pedido p
        JOIN pedido_final pf ON p.codigo = pf.codigo
        JOIN productos pr ON p.codigo = pr.codigo
        WHERE p.codigo = '$codigo';
    ";

    // Ejecutar la consulta
    if (mysqli_query($conecta, $query)) {
        // Si la eliminación fue exitosa, redirigir o enviar un mensaje
        echo 'Elimado de productos, pedido y pedido_final';
    } else {
        // Si hubo un error al eliminar el producto
        echo 'Error al eliminar el producto: ' . mysqli_error($conecta);
    }
} else {
    echo 'Código no recibido.';
}
?>
