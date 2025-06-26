-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-06-2025 a las 04:37:20
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
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `identificacion` varchar(30) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `identificacion`, `direccion`, `correo`, `clave`) VALUES
(1, 'JESUS CORTEZ', '32137510', 'BOBARE, LARA', 'jesuscortez290306@gmail.com', '$2y$10$3ea6TelnM8H4XST/uYWsbOtczMeV/CXpLnFGzvOWHDoxxE4RMjHZS'),
(2, 'JESUS CORTEZ TORRES', '32137511', 'BOBARE, LARA', 'jesuscortez@gmail.com', '$2y$10$LDM4cVsI2ReD5s5DxVDRhuxcAOmKrGttsFjjL1WGzMjpo8SY/9JK2'),
(3, 'JUAN PERDOMO ', '28167776', 'OBELISCO, LARA', 'juan@gmail.com', '$2y$10$lX7O8lnFpFZIJw2rMYAiReH2xkWtoQfUbZgK.qIa0EjxricHQPsSG'),
(4, 'Richard Cortez', '28712893', 'Barquisieto, Lara', 'richardcort9@gmail.com', '$2y$10$vMaUbJLx38xFOaCPFYS2EOidUvWmmn.BIkEh/iVxvMQLuNRzn/snW');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identificacion` (`identificacion`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `clave` (`clave`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
