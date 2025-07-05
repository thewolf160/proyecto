-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-07-2025 a las 21:35:14
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pincos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `fecha_compra` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','cancela','completada','encarrito') DEFAULT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_compras`
--

CREATE TABLE `detalles_compras` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `fecha_ultima_entrada` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_ultima_salida` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `producto_id`, `stock`, `fecha_ultima_entrada`, `fecha_ultima_salida`) VALUES
(1, 1, 14, '2025-07-04 23:31:12', NULL),
(2, 2, 6, '2025-07-05 01:40:01', NULL),
(3, 3, 120, '2025-07-05 19:33:14', NULL),
(4, 4, 85, '2025-07-05 19:33:14', NULL),
(5, 5, 60, '2025-07-05 19:33:14', NULL),
(6, 6, 45, '2025-07-05 19:33:14', NULL),
(7, 7, 30, '2025-07-05 19:33:14', NULL),
(8, 8, 20, '2025-07-05 19:33:14', NULL),
(9, 9, 200, '2025-07-05 19:33:14', NULL),
(10, 10, 150, '2025-07-05 19:33:14', NULL),
(11, 11, 75, '2025-07-05 19:33:14', NULL),
(12, 12, 180, '2025-07-05 19:33:14', NULL),
(13, 13, 90, '2025-07-05 19:33:14', NULL),
(14, 14, 110, '2025-07-05 19:33:14', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre_producto`, `descripcion`, `precio`, `categoria`, `fecha_creacion`, `activo`) VALUES
(1, 'PTN123', 'Pintura Azul Marino', 'Pintura Mamalona. Esta Good. cómprenla.\r\n', 234.00, 'Madera', '2025-07-04 23:21:55', 1),
(2, 'PPN456', 'Pintura Rojo Sangre', 'Rojo sangre god.', 567.00, 'Industrial', '2025-07-05 01:39:31', 1),
(3, 'BRP001', 'Barniz Poliuretano Sayerlack', 'Barniz transparente para protección de madera contra rayaduras y humedad.', 455.99, 'Madera', '2025-07-05 19:31:35', 1),
(4, 'ESM002', 'Esmalte Sintético Comex Madera', 'Pintura brillante o mate resistente a la intemperie para muebles y estructuras.', 322.50, 'Madera', '2025-07-05 19:31:35', 1),
(5, 'LAM003', 'Laca Acrílica Sherwin-Williams', 'Acabado duradero para interiores y ebanistería, bajo olor.', 552.75, 'Madera', '2025-07-05 19:31:35', 1),
(6, 'EPX004', 'Epoxi PPG Amerlock 400', 'Recubrimiento anticorrosivo para metales, resistente a químicos.', 892.99, 'Industrial', '2025-07-05 19:31:35', 1),
(7, 'ATR005', 'Pintura Alto Tráfico Tile-Clad HS', 'Para pisos industriales, soporta maquinaria pesada y químicos.', 120.00, 'Industrial', '2025-07-05 19:31:35', 1),
(8, 'INT006', 'Pintura Intumescente Nullifire', 'Protege estructuras metálicas en incendios, se expande con calor.', 150.50, 'Industrial', '2025-07-05 19:31:35', 1),
(9, 'FAH007', 'Acrílica Comex Vinimex', 'Pintura elástica para fachadas, resistente a grietas y hongos.', 289.99, 'Arquitectonica', '2025-07-05 19:31:35', 1),
(10, 'TEX008', 'Recubrimiento Texturizado Behr', 'Acabado decorativo que disimula imperfecciones en paredes.', 352.75, 'Arquitectonica', '2025-07-05 19:31:35', 1),
(11, 'MIN009', 'Pintura Mineral Keim Soldalit', 'A base de silicato para restauración de edificios históricos.', 456.00, 'Arquitectonica', '2025-07-05 19:31:35', 1),
(12, 'LAT010', 'Latex Acrílico Duration Home', 'Pintura lavable para paredes interiores, resistente a hongos.', 252.99, 'Domestica', '2025-07-05 19:31:35', 1),
(13, 'ESM011', 'Esmalte al Agua Benjamin Moore', 'Bajo olor, acabado suave para muebles y gabinetes.', 402.50, 'Domestica', '2025-07-05 19:31:35', 1),
(14, 'PIZ012', 'Pintura Pizarra Rust-Oleum', 'Convierte superficies en pizarras escribibles, ideal para niños.', 232.99, 'Domestica', '2025-07-05 19:31:35', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `identificacion` varchar(20) NOT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `identificacion`, `direccion`, `correo`, `clave`, `fecha_registro`, `activo`) VALUES
(1, 'root', '11111111', 'Ninguna', 'root@gmail.com', '$2y$10$FUc0BRrgDu/R2fwq31kBZuT1YCSbMr9NvGXK71hzpnQtGQn3IheXC', '2025-07-04 22:12:49', 1),
(2, 'Jesus Cortez', '32137510', 'Bobare, Lara, Venezuela', 'jesuscortez290306@gmail.com', '$2y$10$EivoAVtKrP7suDtWk6LAzuNptw.qju4RSUMaoz/qnKqXOoRQO2kj2', '2025-07-04 22:41:11', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `detalles_compras`
--
ALTER TABLE `detalles_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compra_id` (`compra_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identificacion` (`identificacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalles_compras`
--
ALTER TABLE `detalles_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `detalles_compras`
--
ALTER TABLE `detalles_compras`
  ADD CONSTRAINT `detalles_compras_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `fk_compra_id` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
