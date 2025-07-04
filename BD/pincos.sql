-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-07-2025 a las 22:22:47
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

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `usuario_id`, `total`, `fecha_compra`, `estado`, `metodo_pago`) VALUES
(1, 2, 8050.00, '2025-07-03 07:40:04', 'pendiente', 'efectivo');

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

--
-- Volcado de datos para la tabla `detalles_compras`
--

INSERT INTO `detalles_compras` (`id`, `compra_id`, `producto_id`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(1, 1, 14, 3, 14.00, 42.00),
(2, 1, 15, 1, 300.00, 300.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) DEFAULT 10,
  `stock_maximo` int(11) DEFAULT 100,
  `fecha_ultima_entrada` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_ultima_salida` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `producto_id`, `stock`, `stock_minimo`, `stock_maximo`, `fecha_ultima_entrada`, `fecha_ultima_salida`) VALUES
(1, 12, 20, 0, 30, '2025-06-30 09:31:40', NULL),
(2, 13, 0, 0, 0, '2025-06-29 06:45:18', NULL),
(3, 14, 4, 2, 10, '2025-07-03 06:23:21', '2025-07-03 07:40:04'),
(4, 15, 2, 0, 10, '2025-06-29 22:46:24', '2025-07-03 07:40:04');

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
(12, 'CRI23C', 'Pintura Gris', 'Pintura de color gris', 1999.99, 'Madera', '2025-06-29 02:17:33', 0),
(13, 'PMN009', 'Pintura Marron ', 'Pintura marron', 290.00, 'Industrial', '2025-06-29 06:45:18', 0),
(14, 'PRD2025X', 'Café Supremo Lara', 'Un café tostado artesanal de altura con aroma envolvente y sabor intenso.', 14.00, 'Madera', '2025-06-29 21:26:15', 1),
(15, 'PRJ2006', 'Pintura Roja Sangre ', 'Pintura Roja, sangre como el agua. Muy resaltante.', 300.00, 'Domestica', '2025-06-29 22:46:24', 1);

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
(1, 'root', '11222333', 'VENEZUELA, BARQUISIMETO', 'root@gmail.com', '$2y$10$W.ygujWPqDApw727kVdlPO5Q5Ldfpcm96LCaEkRaDKR4q7CPuN1/y', '2025-06-28 06:07:05', 1),
(2, 'Richard', '28712893', 'Lara, Barquisimeto', 'richardcortez@gmail.com', '$2y$10$e/Nbs1NZ3WmZ.uGMAT6lTO6aY3HuBNUw6DZdnZbLHN.ITMH/Fe0W6', '2025-06-28 06:22:47', 1),
(4, 'JESUS CORTEZ', '32137510', 'BOBARE', 'jesuscortez290306@gmal.com', '$2y$10$0T4kL3xjHQKGOjtw7C3Gj.PMXodQX7F44LHkixnhyvVzJIMlMfX0W', '2025-06-29 05:58:35', 1),
(5, 'YONATHAN NIELES', '31161151', 'CARORA', 'yonathannieles@hotmail.com', '$2y$10$0JE4SdgKqR11YTXJjFXw/OFizxLKOvOnXNHmUS7drv6nhJwhTyjR.', '2025-06-29 06:04:16', 1),
(6, 'MICHI', '11999888', 'BOBARE ', 'michi@gmail.com', '$2y$10$.hHGBhGTI8fhXVRCMUBzOuNWaY84I1GyVzfBmfDM5NVjgwEoHOFP2', '2025-06-29 09:33:57', 0),
(8, 'Juan Perdomo', '28196676', 'OBELISCO, BARQUISIMETO, LARA', 'juanperdomo@gmail.com', 'clave', '2025-06-30 00:45:35', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalles_compras`
--
ALTER TABLE `detalles_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  ADD CONSTRAINT `detalles_compras_ibfk_1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`),
  ADD CONSTRAINT `detalles_compras_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
