-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-07-2025 a las 23:10:09
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
(1, 1, 25, '2025-07-06 21:02:09', NULL),
(2, 2, 18, '2025-07-06 21:02:09', NULL),
(3, 3, 30, '2025-07-06 21:02:09', NULL),
(4, 4, 15, '2025-07-06 21:02:09', NULL),
(5, 5, 12, '2025-07-06 21:02:09', NULL),
(6, 6, 20, '2025-07-06 21:02:09', NULL),
(7, 7, 30, '2025-07-06 21:02:09', NULL),
(8, 8, 8, '2025-07-06 21:02:09', NULL),
(9, 9, 28, '2025-07-06 21:02:09', NULL),
(10, 10, 15, '2025-07-06 21:02:09', NULL),
(11, 11, 10, '2025-07-06 21:02:09', NULL),
(12, 12, 22, '2025-07-06 21:02:09', NULL),
(13, 13, 5, '2025-07-06 21:02:09', NULL),
(14, 14, 18, '2025-07-06 21:02:09', NULL),
(15, 15, 30, '2025-07-06 21:02:09', NULL),
(16, 16, 30, '2025-07-06 21:02:09', NULL),
(17, 17, 25, '2025-07-06 21:02:09', NULL),
(18, 18, 14, '2025-07-06 21:02:09', NULL),
(19, 19, 20, '2025-07-06 21:02:09', NULL),
(20, 20, 30, '2025-07-06 21:02:09', NULL);

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
  `activo` tinyint(1) DEFAULT 1,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre_producto`, `descripcion`, `precio`, `categoria`, `fecha_creacion`, `activo`, `img`) VALUES
(1, 'MAD001', 'Barniz Protector Premium', 'Barniz incoloro para muebles de interior/exterior. Base agua. Rendimiento: 10 m²/L', 850.00, 'Madera', '2025-07-06 20:51:40', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(2, 'MAD002', 'Esmalte para Muebles', 'Acabado brillante, resistente a golpes. Disponible en 8 colores', 720.00, 'Madera', '2025-07-06 20:51:40', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(3, 'MAD003', 'Protector UV para Deck', 'Protección contra rayos UV y humedad. Duración: 3 años', 950.00, 'Madera', '2025-07-06 20:51:40', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(4, 'MAD004', 'Lasur Ecológico', 'Para madera en contacto con alimentos (juguetes, cocina)', 680.00, 'Madera', '2025-07-06 20:51:40', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(5, 'MAD005', 'Kit Restauración Madera', 'Incluye barniz, lijas y guantes. Cubre 5 m²', 1100.00, 'Madera', '2025-07-06 20:51:40', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(6, 'IND001', 'Pintura Epoxi para Metales', 'Anticorrosiva para maquinaria y estructuras. Rendimiento: 4 m²/L', 1500.00, 'Industrial', '2025-07-06 20:52:04', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(7, 'IND002', 'Pintura Poliuretano', 'Resistente a químicos y abrasión. Color gris RAL 7016', 1800.00, 'Industrial', '2025-07-06 20:52:04', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(8, 'IND003', 'Pintura Ignífuga', 'Retardante de llamas para instalaciones eléctricas', 2200.00, 'Industrial', '2025-07-06 20:52:04', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(9, 'IND004', 'Spray Anticorrosivo', 'Aplicación directa sobre óxido. Protección 5 años', 650.00, 'Industrial', '2025-07-06 20:52:04', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(10, 'IND005', 'Recubrimiento para Suelos', 'Para naves industriales. Soporta tráfico intenso', 1250.00, 'Industrial', '2025-07-06 20:52:04', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(11, 'ARQ001', 'Pintura Térmica Acrílica', 'Reduce temperatura interior en 5°C. Blanco y colores', 2800.00, 'Arquitectonica', '2025-07-06 20:52:38', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(12, 'ARQ002', 'Revestimiento Texturado', 'Efecto piedra natural. Ideal para hoteles', 1750.00, 'Arquitectonica', '2025-07-06 20:52:38', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(13, 'ARQ003', 'Pintura Fotocatalítica', 'Purifica el aire. Certificada LEED', 3200.00, 'Arquitectonica', '2025-07-06 20:52:38', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(14, 'ARQ004', 'Microcemento Líquido', 'Para suelos continuos. Acabado mate', 4200.00, 'Arquitectonica', '2025-07-06 20:52:38', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(15, 'ARQ005', 'Pintura de Silicato', 'Mineral, transpirable. Duración 15+ años', 1950.00, 'Arquitectonica', '2025-07-06 20:52:38', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(16, 'DOM001', 'Pintura Lavable', 'Resistente a manchas y lavados. 20 colores', 890.00, 'Domestica', '2025-07-06 20:52:48', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(17, 'DOM002', 'Kit Pintura Pizarra', 'Incluye rodillo y tizas. Cubre 6 m²', 750.00, 'Domestica', '2025-07-06 20:52:48', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(18, 'DOM003', 'Pintura Magnética', 'Base para imanes. Requiere 2 capas', 1300.00, 'Domestica', '2025-07-06 20:52:48', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(19, 'DOM004', 'Esmalte para Cocina', 'Antimanchas y antihongos. Blanco brillante', 980.00, 'Domestica', '2025-07-06 20:52:48', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg'),
(20, 'DOM005', 'Pintura Ecológica', 'Libre de VOC. Certificada para niños', 1150.00, 'Domestica', '2025-07-06 20:52:48', 1, 'https://latitas-online.es/media/catalog/product/cache/61ca00f5e0007de330088524c71874eb/b/o/bote_de_pintura_1000_ml_1.jpg');

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
(2, 'Jesus Cortez', '32137510', 'Bobare, Lara, Venezuela', 'jesuscortez290306@gmail.com', '$2y$10$EivoAVtKrP7suDtWk6LAzuNptw.qju4RSUMaoz/qnKqXOoRQO2kj2', '2025-07-04 22:41:11', 1),
(3, 'Richard Cortez', '28712893', 'Barquisimeto, Carrera 19, Calle 54A', 'richardcort09@gmail.com', '$2y$10$ipL9.5aILEXLbq7sK/sXzu4m5uRVrlq.8G4.0Wu3HDRe0/nZhvNeW', '2025-07-06 09:32:17', 1),
(4, 'Yonathan Nieles', '31161696', 'Carora, calle 98, carrera 3', 'yonathannieles@hotmal.com', '$2y$10$.WGWZhC7VyAu2/XM/oNQX.i2MAi9OWILnVPZBaqROae56O.zlUtMi', '2025-07-06 09:34:07', 1),
(5, 'Juan Perdomo', '27198676', 'Barquisimeto, Bloque 10, Obelisco', 'jaberuskk@gmail.com', '$2y$10$6HYFgFu4gx.f3bT/uf8k4uobkynyDrzPMAFC7403FfW/vDXZMVxB6', '2025-07-06 09:35:37', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
