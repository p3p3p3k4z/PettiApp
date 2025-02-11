-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 11-02-2025 a las 00:24:21
-- Versión del servidor: 5.7.44
-- Versión de PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `insumos`
--
CREATE DATABASE IF NOT EXISTS `insumos` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `insumos`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE IF NOT EXISTS `empleados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `area` enum('admin','barra','repartidor','cocina') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `phone`, `password`, `nombre`, `area`) VALUES
(1, '5551234567', 'claveSegura1', 'Juan PÃ©rez', 'admin'),
(2, '5559876543', 'reparto123', 'MarÃ­a GonzÃ¡lez', 'repartidor'),
(3, '5555555555', 'barraFuerte', 'Carlos LÃ³pez', 'barra'),
(4, '5553334444', 'adminBoss', 'Laura MÃ©ndez', 'admin'),
(5, '5556667777', 'deliveryGo', 'Pedro RamÃ­rez', 'repartidor'),
(6, '5552223333', 'mojitosBest', 'SofÃ­a Torres', 'barra'),
(7, '5558889999', 'seguroAdmin', 'Ana Villalobos', 'admin'),
(8, '5557776666', 'speedyMoto', 'Diego Herrera', 'repartidor'),
(9, '5554445555', 'mixDrinks', 'Elena Rojas', 'barra'),
(10, '5551112222', 'adminPower', 'Fernando Castro', 'admin'),
(11, '9511196182', 'picapapas', 'pepe pecas', 'barra'),
(12, '9876543210', 'POIUYTREWQ', 'juanita', 'cocina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cantidad` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `empleado` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_cocina`
--

DROP TABLE IF EXISTS `pedido_cocina`;
CREATE TABLE IF NOT EXISTS `pedido_cocina` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cantidad` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `empleado` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_final`
--

DROP TABLE IF EXISTS `pedido_final`;
CREATE TABLE IF NOT EXISTS `pedido_final` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `empleado` varchar(100) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `empleado` varchar(255) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_cocina`
--

DROP TABLE IF EXISTS `productos_cocina`;
CREATE TABLE IF NOT EXISTS `productos_cocina` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_generales`
--

DROP TABLE IF EXISTS `productos_generales`;
CREATE TABLE IF NOT EXISTS `productos_generales` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos_generales`
--

INSERT INTO `productos_generales` (`codigo`, `nombre`, `categoria`) VALUES
(0, 'Cebolla Blanca', 'Frutas y verduras'),
(101, 'ChicharrÃ³n De Puerco', 'Carne, embutidos y mariscos'),
(228, 'Ajax multiuso', 'Material de uso'),
(230, 'PASTILLA PARA BAÃ‘O PATO 4PZ', 'Material de uso'),
(308, 'TAPA 4 Oz', 'Desechables'),
(311, 'Vaso 4oz', 'Desechables'),
(494, 'CafÃ© de la casa 70 30 1 KG', 'CafÃ©, endulzantes y saborizantes'),
(495, 'CafÃ© de la casa 90 10', 'CafÃ©, endulzantes y saborizantes'),
(496, 'Salsa de chocolate', 'Cafe endulzantes y saborizantes'),
(506, 'CamarÃ³n', 'Carne, embutidos y mariscos'),
(512, 'Aguacate', 'Frutas y verduras'),
(513, 'Ajo de cabeza grande', 'Frutas y verduras'),
(517, 'Calabaza', 'Frutas y verduras'),
(519, 'Cebolla morada', 'Frutas y verduras'),
(520, 'ChampiÃ±ones', 'Frutas y verduras'),
(521, 'Chile serrano', 'Frutas y verduras'),
(522, 'Rollo de Cilantro', 'Frutas y verduras'),
(524, 'Rollo de Epazote', 'Frutas y verduras'),
(525, 'Rollo de Espinacas', 'Frutas y verduras'),
(527, 'Chile habanero', 'Frutas y verduras'),
(533, 'OrÃ©gano', 'Frutas y verduras'),
(534, 'Papaya', 'Frutas y verduras'),
(535, 'Ramo de Perejil', 'Frutas y verduras'),
(537, 'PlÃ¡tano tabasco', 'Frutas y verduras'),
(538, 'Tomate Verde', 'Frutas y Verduras'),
(539, 'Zanahoria', 'Frutas y Verduras'),
(541, 'Blueberry 400g', 'Frutas y verduras'),
(542, 'Nopales limpios', 'Frutas y verduras'),
(545, 'Apio', 'Frutas y verduras'),
(546, 'PiÃ±a', 'Frutas y verduras'),
(550, 'Tomate cherry cajita', 'Frutas y Verduras'),
(551, 'Arrachera', 'Carne, embutidos y mariscos'),
(552, 'Bistec de res', 'Carne, embutidos y mariscos'),
(554, 'Tasajo', 'Carne embutidos y mariscos'),
(555, 'Carne Enchilada', 'Carne, embutidos y mariscos'),
(556, 'Tocino', 'Carne embutido y mariscos'),
(557, 'Pechuga De Pollo Entera', 'Carne, embutidos y mariscos'),
(559, 'Pechuga De Pollo Aplanada', 'Carne, embutidos y mariscos'),
(560, 'Carne Molida De Pollo', 'Carne, embutidos y mariscos'),
(561, 'Carne Molida De Res', 'Carne, embutidos y mariscos'),
(562, 'Carne Molida Mixta', 'Material de uso'),
(563, 'Pepperoni', 'Carne, embutidos y mariscos'),
(564, 'Salchichas En Paquete', 'Carne embutidos y mariscos'),
(565, 'Alitas de pollo', 'Carne, embutidos y mariscos'),
(567, 'Tocineta', 'Carne embutido y mariscos'),
(574, 'Quesos De Aro', 'Lacteos'),
(576, 'Queso Panela 400 Grs', 'Lacteos'),
(578, 'Queso manchego rallado', 'Lacteos'),
(584, 'Yogurt Natural', 'Lacteos'),
(585, 'Queso parmesano rayado', 'Lacteos'),
(588, 'Arroz de kilo', 'Abarrotes'),
(592, 'Semilla de girasol 1/4', 'Chiles secos, semillas, harinas y pastas'),
(593, 'ArÃ¡ndanos', 'Chiles secos, semillas, harinas y pastas'),
(600, 'Pan de hamburguesa wonder 8 pzas', 'PanaderÃ­a y pastelerÃ­a'),
(601, 'Pan integral de caja', 'PanaderÃ­a y pastelerÃ­a'),
(602, 'Baguettes grandes', 'PanaderÃ­a y pastelerÃ­a'),
(605, 'Teleras', 'Panaderia y pasteleria'),
(606, 'Pan dulce', 'PanaderÃ­a y pastelerÃ­a'),
(609, 'Pan molido', 'PanaderÃ­a y pastelerÃ­a'),
(613, 'Capacillo para postres', 'PanaderÃ­a y pastelerÃ­a'),
(615, 'Canela molida/ en polvo', 'PanaderÃ­a y pastelerÃ­a'),
(617, 'Chispas de chocolate', 'PanaderÃ­a y pastelerÃ­a'),
(618, 'Chocolate TurÃ­n amargo 100g', 'PanaderÃ­a y pastelerÃ­a'),
(620, 'Queso crema la cima cubeta 4kg', 'Panaderia y pasteleria'),
(624, 'Papas a la francesa en bolsa kg', 'Abarrotes'),
(626, 'Te manzanilla sobres', 'Abarrotes'),
(628, 'Mermelada grande', 'Abarrotes'),
(633, 'Casilleros de huevo', 'Abarrotes'),
(634, 'Bolsa de hielos', 'Abarrotes'),
(635, 'Pimienta molida con sal', 'Abarrotes'),
(636, 'Palillos', 'Abarrotes'),
(637, 'Valentina sobre 8gr', 'Abarrotes'),
(639, 'Stevia', 'Cafe endulzantes y saborizantes'),
(640, 'Catsup en sobrecitos', 'Abarrotes'),
(642, 'Vino California', 'Abarrotes'),
(643, 'AzÃºcar estÃ¡ndar de 1kg', 'Abarrotes'),
(645, 'Chamoy 1l', 'Abarrotes'),
(646, 'Aderezo ranch', 'Abarrotes'),
(649, 'Sal blanca de 1kg', 'Abarrotes'),
(650, 'Chile chipotle lata', 'Abarrotes'),
(652, 'Microdyn 100ml', 'Abarrotes'),
(655, 'Mole', 'Abarrotes'),
(660, 'Pinol', 'Productos de limpieza'),
(663, 'Sanitas 1 paquete', 'Productos de limpieza'),
(664, 'Papel higiÃ©nico junior por pieza', 'Productos de limpieza'),
(667, 'Rollo papel higienico', 'Productos de limpieza'),
(672, 'Salsa De Caramelo', 'Cafe endulzantes y saborizantes'),
(677, 'Tenedores Desechables Jumbo', 'Desechables'),
(682, 'Bolsas De Papel No.3', 'Desechables'),
(683, 'Bolsas Para Porcionar', 'Desechables'),
(684, 'Aluminio 100 Metros', 'Desechables'),
(686, 'Tapa Negra 8oz', 'Desechables'),
(688, 'Vaso Bamboo 8oz', 'Desechables'),
(689, 'Vaso Bamboo 12oz', 'Desechables'),
(691, 'Servitoallas', 'Desechables'),
(692, 'Vaso Cristal 7oz', 'Desechables'),
(693, 'Popotes Estuchados 26cm', 'Desechables'),
(699, 'Vaso Cristal 16oz', 'Desechables'),
(700, 'Vaso Bamboo 16oz', 'Desechables'),
(701, 'Porta Vasos pieza', 'Desechables'),
(702, 'Bolsa 35x40 chica con asa', 'Desechables'),
(703, 'Bolsa 50x60 grande con asa', 'Desechables'),
(726, 'Salsa de Chocolate Blanco', 'Cafe endulzantes y saborizantes'),
(727, 'Polvo Frappe Base Agua', 'CafÃ©, endulzantes y saborizantes'),
(728, 'Polvo Frappe Base Leche', 'CafÃ©, endulzantes y saborizantes'),
(729, 'Te Jamaica en sobres', 'Cafe endulzantes y saborizantes'),
(730, 'Te Hierbabuena en sobres', 'Cafe endulzantes y saborizantes'),
(731, 'Te de Canela en sobres', 'Cafe endulzantes y saborizantes'),
(733, 'Te Manzana-Canela en sobres', 'Cafe endulzantes y saborizantes'),
(736, 'Tizana Oms Garden 500g', 'Cafe endulzantes y saborizantes'),
(737, 'Tizana Mumbai 500g', 'Cafe endulzantes y saborizantes'),
(738, 'Tizana Manzana-Arandano 500g', 'Cafe endulzantes y saborizantes'),
(739, 'Tizana Ponche de Guayaba 500g', 'Cafe endulzantes y saborizantes'),
(740, 'Tizana Pina Colada 500g', 'Cafe endulzantes y saborizantes'),
(741, 'Tizana Goji Berry 500g', 'Cafe endulzantes y saborizantes'),
(742, 'Tizana Besos Rosas 500g', 'Cafe endulzantes y saborizantes'),
(743, 'Tizana Atardecer 500g', 'Cafe endulzantes y saborizantes'),
(744, 'Tizana Dulce Amanecer 500g', 'Cafe endulzantes y saborizantes'),
(745, 'Tizana Hakuna Matata 500g', 'Cafe endulzantes y saborizantes'),
(746, 'Tizana Raiz 500g', 'Cafe endulzantes y saborizantes'),
(747, 'Tizana strawberry Kiwi 500g', 'Cafe endulzantes y saborizantes'),
(750, 'Chocolate Oaxacanita', 'CafÃ©, endulzantes y saborizantes'),
(762, 'Pulpa de concentrado de piÃ±a coco', 'Material de uso'),
(772, 'Pulpa de Mango', 'Cafe endulzantes y saborizantes'),
(773, 'Pulpa de Zarzamora', 'Cafe endulzantes y saborizantes'),
(774, 'Pulpa de Kiwi', 'Cafe endulzantes y saborizantes'),
(778, 'Tizana Recuerdame 500 gramos', 'Cafe endulzantes y saborizantes'),
(779, 'Aceite 123', 'Abarrotes'),
(783, 'Bolsas 1kg 90X120', 'Desechables'),
(784, 'Bolsas 1kg 60X90', 'Desechables'),
(786, 'Pulpa de Maracuya', 'Cafe endulzantes y saborizantes'),
(787, 'Pulpa de Mixies berries', 'Cafe endulzantes y saborizantes'),
(789, 'Tortillas', 'Panaderia y pasteleria'),
(790, 'Tapa domo de vaso Cristal', 'Desechables'),
(791, 'Bulto de naranja', 'Frutas y verduras'),
(793, 'Papa blanca', 'Frutas y verduras'),
(795, 'Pepino', 'Frutas y verduras'),
(796, 'Chayote', 'Frutas y verduras'),
(798, 'Pollo surtido', 'Carne, embutidos y mariscos'),
(799, 'PeÃ±afiel mineral paquete de 6', 'Bebidas no alcohÃ³licas'),
(800, 'Tapa negra 12/16 oz 50 piezas', 'Desechables'),
(801, 'Chile/ pimiento morrÃ³n', 'Frutas y verduras'),
(803, 'Cebolla Cambray', 'Frutas y verduras'),
(811, 'Sandia', 'Frutas y verduras'),
(813, 'Cecina', 'Carne, embutidos y mariscos'),
(816, 'Azucar mascabado en kilo', 'CafÃ©, endulzantes y saborizantes'),
(817, 'Te de limon en sobres', 'Cafe endulzantes y saborizantes'),
(818, 'Te de 7 en sobres', 'Cafe endulzantes y saborizantes'),
(819, 'Pasta tornillo rotini 1kg', 'Chiles secos, semillas, harinas y pastas'),
(820, 'SALSA CATSUP 450 G', 'Material de uso'),
(821, 'Pasta fideo para sopa', 'Chiles secos, semillas, harinas y pastas'),
(822, 'Sal sol / sal fina', 'Material de uso'),
(823, 'Servilletas paquete grande', 'Desechables'),
(827, 'Avena a granel de un 1kg', 'Abarrotes'),
(828, 'PiÃ±a en rebanadas en almibar', 'Cocina-ProducciÃ³n - Comidas'),
(829, 'Vainilla Sayes 1L', 'Caliente'),
(831, 'Brocoli', 'Frutas y verduras'),
(832, 'Carne para freir', 'Carne, embutidos y mariscos'),
(841, 'AtÃºn en lata', 'Carne, embutidos y mariscos'),
(843, 'AzÃºcar mascabado en sobresitos', 'CafÃ©, endulzantes y saborizantes'),
(844, 'Splenda endulzante sobres', 'Cafe endulzantes y saborizantes'),
(845, 'Achiote', 'Chiles secos, semillas, harinas y pastas'),
(848, 'Carnation en polvo de 460g', 'Barra-Bebidas - Fri@s'),
(849, 'Cajeta', 'Barra-Bebidas - Caliente'),
(850, 'Salsa Hunts BBQ 620g', 'Abarrotes'),
(851, 'Queso gouda el buen pastor de 500g', 'Cocina-Produccion - Comidas'),
(853, 'Chile jalapeÃ±o', 'Frutas y verduras'),
(854, 'Aderezo cÃ©sar', 'Abarrotes'),
(855, 'Cereza en almibar', 'Frutas y verduras'),
(857, 'Miel de maple', 'CafÃ©, endulzantes y saborizantes'),
(858, 'Mostaza', 'Abarrotes'),
(859, 'Platos desechables para fruta n.2', 'Desechables'),
(860, 'Queso americano/amarillo paquetes', 'Material de uso'),
(861, 'Salsa hunts tipo bolonesa', 'Abarrotes'),
(862, 'Vino Blanco', 'Abarrotes'),
(863, 'Aceite de oliva', 'Abarrotes'),
(864, 'Aceite en aerosol', 'Abarrotes'),
(868, 'Nuez entera', 'Chiles secos, semillas, harinas y pastas'),
(869, 'Nuez picada', 'Chiles secos, semillas, harinas y pastas'),
(870, 'Tapas contenedores consome 1/2', 'Desechables'),
(871, 'AzÃºcar glass', 'CafÃ©, endulzantes y saborizantes'),
(873, 'Vinagre', 'Abarrotes'),
(877, 'Pasta para lasaÃ±a', 'Abarrotes'),
(879, 'Bolsas de papel #6', 'Abarrotes'),
(882, 'Agitadores', 'Abarrotes'),
(886, 'Te caja varios sabores', 'Cafe endulzantes y saborizantes'),
(889, 'Chocolate lÃ­quido', 'CafÃ©, endulzantes y saborizantes'),
(890, 'Tapas para jugo 7 oz', 'Desechables'),
(892, 'Salsa inglesa', 'Abarrotes'),
(893, 'Piloncillo por pieza', 'Abarrotes'),
(897, 'Carne para hervir', 'Carne, embutidos y mariscos'),
(898, 'Pulpa de fresa', 'Cafe endulzantes y saborizantes'),
(899, 'Chile costeÃ±o amarillo de 150g', 'Cocina-ProducciÃ³n - Comidas'),
(900, 'Papel corrugado paquete 10 pliegos', 'Otros'),
(904, 'Tapa 1 oz 100 piezas', 'Desechables'),
(905, 'Vaso 12oz', 'Desechables'),
(906, 'Servitoallas para secar verduras', 'Abarrotes'),
(907, 'Chiles en vinagre en rajas', 'Abarrotes'),
(911, 'Papas francesas en porciones', 'Abarrotes'),
(920, 'Azucar refinado en sobres', 'Material de uso'),
(922, 'Queso para nachos', 'Abarrotes'),
(924, 'Valentina 1 LT', 'Abarrotes'),
(925, 'Vaso 2oz', 'Desechables'),
(926, 'Sal con ajo', 'Abarrotes'),
(927, 'Tapa vaso 2 oz', 'Abarrotes'),
(929, 'Aceitunas', 'Abarrotes'),
(930, 'Nutela / crema de avellanas', 'Abarrotes'),
(932, 'Tajin', 'Abarrotes'),
(933, 'Banderillas de tamarindo', 'Abarrotes'),
(936, 'Plastico aderhente 100m', 'Otros - Otros'),
(952, 'Sal de grano de 1kg', 'Cocina-Produccion - A cualquier hora'),
(963, 'PeÃ±afiel mineral grande', 'Abarrotes'),
(967, 'Canela en trozos', 'Abarrotes'),
(970, 'Te verde en sobres', 'Barra-Bebidas - Caliente'),
(975, 'Bolsa 40x50 mediana con asa', 'Material de uso'),
(977, 'Pasta espaguetti', 'Material de uso'),
(981, 'Naranja por kilo', 'Frutas y verduras'),
(985, 'Pan para hamburguesa bimbollo', 'Abarrotes'),
(986, 'Salsa bufalo', 'Abarrotes'),
(987, 'Salsa magui', 'Abarrotes'),
(988, 'Quesillo 1Kg', 'Lacteos'),
(989, 'Semillas de calabaza', 'Abarrotes'),
(990, 'Chispas de colores', 'Abarrotes'),
(991, 'Polvo flan', 'CafÃ©, endulzantes y saborizantes'),
(994, 'Retazo', 'Carne embutidos y mariscos'),
(999, 'Chile guajillo', 'Frutas y verduras'),
(1012, 'Cafe de la casa tueste medio', 'Barra-Bebidas - Caliente'),
(1017, 'Aderezo chipotle', 'Abarrotes'),
(1023, 'Microfibra', 'Otros - Otros'),
(1032, 'Red para cabello', 'Material de uso'),
(1039, 'CafÃ©s fino Cuatepec tueste medio', 'Cocina-ProducciÃ³n - A cualquier hora'),
(1057, 'Cafe Especial tueste medio Cuatepec', 'Barra-Bebidas - Caliente');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_pedidos_barra`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vista_pedidos_barra`;
CREATE TABLE IF NOT EXISTS `vista_pedidos_barra` (
`id` int(11)
,`codigo` varchar(255)
,`nombre` varchar(255)
,`cantidad` varchar(255)
,`categoria` varchar(255)
,`empleado` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_pedidos_cocina`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vista_pedidos_cocina`;
CREATE TABLE IF NOT EXISTS `vista_pedidos_cocina` (
`id` int(11)
,`codigo` varchar(255)
,`nombre` varchar(255)
,`cantidad` varchar(255)
,`categoria` varchar(255)
,`empleado` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_pedidos_barra`
--
DROP TABLE IF EXISTS `vista_pedidos_barra`;

DROP VIEW IF EXISTS `vista_pedidos_barra`;
CREATE ALGORITHM=UNDEFINED DEFINER=`user`@`%` SQL SECURITY DEFINER VIEW `vista_pedidos_barra`  AS SELECT `p`.`id` AS `id`, `p`.`codigo` AS `codigo`, `p`.`nombre` AS `nombre`, `p`.`cantidad` AS `cantidad`, `p`.`categoria` AS `categoria`, `p`.`empleado` AS `empleado` FROM (`pedido` `p` join `empleados` `e` on((`p`.`empleado` = `e`.`nombre`))) WHERE (`e`.`area` = 'barra') ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_pedidos_cocina`
--
DROP TABLE IF EXISTS `vista_pedidos_cocina`;

DROP VIEW IF EXISTS `vista_pedidos_cocina`;
CREATE ALGORITHM=UNDEFINED DEFINER=`user`@`%` SQL SECURITY DEFINER VIEW `vista_pedidos_cocina`  AS SELECT `p`.`id` AS `id`, `p`.`codigo` AS `codigo`, `p`.`nombre` AS `nombre`, `p`.`cantidad` AS `cantidad`, `p`.`categoria` AS `categoria`, `p`.`empleado` AS `empleado` FROM (`pedido` `p` join `empleados` `e` on((`p`.`empleado` = `e`.`nombre`))) WHERE (`e`.`area` = 'cocina') ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
