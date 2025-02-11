<?php
include '../conecta.php'; // Conexión a la base de datos

// Consultas para borrar todo el contenido de las tablas "pedido" y "pedido_final"
$query1 = "DELETE FROM pedido";
$query2 = "DELETE FROM pedido_final";

// Ejecutar ambas consultas
if (mysqli_query($conecta, $query1) && mysqli_query($conecta, $query2)) {
    echo "<script>
        alert('Todos los pedidos han sido surtidos.');
        window.location.href = '../administra.php'; // Redirigir de vuelta
    </script>";
} else {
    echo "Error al eliminar pedidos: " . mysqli_error($conecta);
}
echo '<script>window.location.href = "../administra.php";</script>';
exit();
?>
