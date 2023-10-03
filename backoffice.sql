-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-07-2023 a las 06:15:01
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `backoffice`
--
CREATE DATABASE IF NOT EXISTS `backoffice` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `backoffice`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacenes`
--

CREATE TABLE `almacenes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `calle` varchar(64) NOT NULL,
  `numero` varchar(8) NOT NULL,
  `baja` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `almacenes`
--

INSERT INTO `almacenes` (`id`, `nombre`, `calle`, `numero`, `baja`) VALUES
(15, 'Deposito central', 'Jose Batlle y Ordoñez', '8975', 0),
(16, 'Deposito Salto', '19 de abril', '8975', 0),
(17, 'Deposio Montevideo 1', 'Veracierto', '2347', 0),
(18, 'Almacen Sosam', 'Vilardebo', '2024', 0),
(19, 'Almacen puerto', 'Panama', '2341', 0),
(20, 'Barraca central', 'Belloni', '2345', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacenes_clientes`
--

CREATE TABLE `almacenes_clientes` (
  `id` int(11) NOT NULL,
  `RUT` char(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `almacenes_clientes`
--

INSERT INTO `almacenes_clientes` (`id`, `RUT`) VALUES
(18, '213121286779'),
(17, '213456789012'),
(19, '213456789012'),
(20, '213956789012');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacenes_propios`
--

CREATE TABLE `almacenes_propios` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `almacenes_propios`
--

INSERT INTO `almacenes_propios` (`id`) VALUES
(15),
(16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camioneros`
--

CREATE TABLE `camioneros` (
  `id` int(11) NOT NULL,
  `licencia` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `camioneros`
--

INSERT INTO `camioneros` (`id`, `licencia`) VALUES
(61, 2),
(62, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `RUT` char(12) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `baja` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`RUT`, `nombre`, `baja`) VALUES
('213121286779', 'Sosam Inc', 1),
('213456789012', 'Crecom', 0),
('213956789012', 'Ferreteria S,R.L', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `pass` varchar(256) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `apellido` varchar(32) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `rol` int(1) NOT NULL,
  `pass_deafault` tinyint(1) NOT NULL DEFAULT 1,
  `baja` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `pass`, `nombre`, `apellido`, `telefono`, `rol`, `pass_deafault`, `baja`) VALUES
(59, 'usuario', '$2y$10$Uf2JYGmAQK5C8cXQP7mFvuILv/DRoFV3KM4oT/41w/EAQI4XVXQ/i', 'usuario', 'usuario', '099999999', 0, 0, 0),
(60, 'lucas.marsiglia', '$2y$10$.2v374EubroJS/9DPIiVuuT3T0hYXlu1.ZgcZ9Shwff.5ik8yT3oy', 'Lucas', 'Marsiglia', '098555444', 0, 0, 0),
(61, 'Ignacio.Tondo', '$2y$10$1N9WSs5bDynO9DHJyHlS3.MbhxGgAcCoKdjzwR0eggg5pmqqam40G', 'Ignacio', 'Tondo', '099333777', 2, 0, 0),
(62, 'Lorenzo.Echeverria', '$2y$10$RjDAEPrlSXSh5ukplaHBH.5wJH1e9gqC1PHCcusnpgSsDPKTB1Iiq', 'Lorenzo', 'Echeverria', '099333111', 2, 0, 0),
(63, 'sandino', '$2y$10$BGM9D/QlQqkeWHRpnikh5ukAt.guQ1J6Mwg066wHMqwCpyda2W8qW', 'sandino', 'lopez', '098363777', 1, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `almacenes_clientes`
--
ALTER TABLE `almacenes_clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `RUT` (`RUT`);

--
-- Indices de la tabla `almacenes_propios`
--
ALTER TABLE `almacenes_propios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `camioneros`
--
ALTER TABLE `camioneros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`RUT`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacenes_clientes`
--
ALTER TABLE `almacenes_clientes`
  ADD CONSTRAINT `almacenes_clientes_ibfk_1` FOREIGN KEY (`RUT`) REFERENCES `clientes` (`RUT`),
  ADD CONSTRAINT `almacenes_clientes_ibfk_2` FOREIGN KEY (`id`) REFERENCES `almacenes` (`id`);

--
-- Filtros para la tabla `almacenes_propios`
--
ALTER TABLE `almacenes_propios`
  ADD CONSTRAINT `Foreign key id` FOREIGN KEY (`id`) REFERENCES `almacenes` (`id`);

--
-- Filtros para la tabla `camioneros`
--
ALTER TABLE `camioneros`
  ADD CONSTRAINT `camioneros_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
