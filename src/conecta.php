<?php
$servidor = "db";
$usuario = "user";
$password = "password";
$bd = "insumos";

// Crear conexión
$conecta = new mysqli($servidor, $usuario, $password, $bd);

// Validar conexión
if ($conecta->connect_error) {
    die(json_encode(["success" => false, "message" => "Error de conexión: " . $conecta->connect_error]));
}

// Configurar para UTF-8 y evitar problemas de codificación
$conecta->set_charset("utf8");
?>
