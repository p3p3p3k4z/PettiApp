CREATE DATABASE IF NOT EXISTS insumos;
USE insumos;

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    cantidad INT NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS productos_generales (
    codigo INT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    categoria VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    cantidad INT NOT NULL DEFAULT 0
);

-- Insertar datos en productos
INSERT INTO productos (codigo, nombre, cantidad) VALUES
('P001', 'Producto 1', 10),
('P002', 'Producto 2', 5),
('P003', 'Producto 3', 20);

-- Insertar productos para una cafetería en productos_generales
INSERT INTO productos_generales (codigo, nombre, categoria) VALUES
(13, 'Vaso desechable', 'Desechables'),
(124, 'Jarabe de vainilla', 'Otros'),
(125, 'Café en grano', 'Bebidas'),
(126, 'Leche entera', 'Lácteos'),
(127, 'Azúcar', 'Endulzantes'),
(128, 'Canela en polvo', 'Especias'),
(129, 'Pan dulce', 'Panadería'),
(130, 'Té negro', 'Bebidas'),
(131, 'Chocolate en polvo', 'Bebidas'),
(132, 'Servilletas', 'Desechables'),
(133, 'Cucharas de plástico', 'Desechables'),
(134, 'Miel', 'Endulzantes'),
(135, 'Jarabe de caramelo', 'Otros'),
(136, 'Espumador de leche', 'Accesorios');
