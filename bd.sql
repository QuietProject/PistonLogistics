-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-09-2023 a las 06:17:11
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacenes`
--

INSERT INTO `almacenes` (`id`, `nombre`, `calle`, `numero`, `baja`) VALUES
(15, 'Deposito central', 'Jose Batlle y Ordoñez', '8975', 1),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `pass`, `nombre`, `apellido`, `telefono`, `rol`, `pass_deafault`, `baja`) VALUES
(59, 'usuario', '$2y$10$Uf2JYGmAQK5C8cXQP7mFvuILv/DRoFV3KM4oT/41w/EAQI4XVXQ/i', 'usuario', 'usuario', '099999999', 0, 0, 0),
(60, 'lucas.marsiglia', '$2y$10$.2v374EubroJS/9DPIiVuuT3T0hYXlu1.ZgcZ9Shwff.5ik8yT3oy', 'Lucas', 'Marsiglia', '098555444', 0, 0, 0),
(61, 'Ignacio.Tondo', '$2y$10$1N9WSs5bDynO9DHJyHlS3.MbhxGgAcCoKdjzwR0eggg5pmqqam40G', 'Ignacio', 'Tondo', '099333777', 2, 0, 0),
(62, 'Lorenzo.Echeverria', '$2y$10$RjDAEPrlSXSh5ukplaHBH.5wJH1e9gqC1PHCcusnpgSsDPKTB1Iiq', 'Lorenzo', 'Echeverria', '099333111', 2, 0, 0),
(63, 'sandino', '$2y$10$BGM9D/QlQqkeWHRpnikh5ukAt.guQ1J6Mwg066wHMqwCpyda2W8qW', 'sandino', 'lopez', '098363777', 1, 0, 0),
(64, 'prueba', 'Piston.Logistics', 'prueba', 'prueba', '09090909', 0, 1, 1),
(65, '876', 'Piston.Logistics', 'uy87', '68768', '76876', 0, 1, 1),
(66, '87687', 'Piston.Logistics', '687687', '6876', '876786', 0, 1, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

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
--
-- Base de datos: `gestor`
--
CREATE DATABASE IF NOT EXISTS `gestor` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gestor`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `ID` int(11) NOT NULL,
  `IdUE` int(11) DEFAULT NULL,
  `Nombre` varchar(60) DEFAULT NULL,
  `Nomenclatura` varchar(10) DEFAULT NULL,
  `bajaLogica` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`ID`, `IdUE`, `Nombre`, `Nomenclatura`, `bajaLogica`) VALUES
(1, 1, 'Sistemas', 'SIS', 0),
(2, 1, 'Obras y Servicios', 'OYS', 0),
(3, 1, 'Asuntos Constitucionales', 'ASCL', 0),
(4, 1, 'Asesoria Letrada', 'ASL', 0),
(5, 1, 'Ciudadania Digital', 'CDIG', 0),
(6, 1, 'Cooperacion y Proyectos', 'CIP', 0),
(7, 1, 'Comunicaciones', 'COM', 0),
(8, 1, 'Direccion General', 'DIR', 0),
(9, 1, 'Gestion Financiero', 'GFIN', 0),
(10, 1, 'Juridico Notarial', 'JNOT', 0),
(11, 1, 'PECA', 'PECA', 0),
(12, 1, 'Recursos Humanos', 'RRHH', 0),
(13, 1, 'Subsecretaria', 'SUB', 0),
(14, 1, 'Sistemas Prestamo', 'SISP', 0),
(15, 1, 'Gestion Documental', 'GDOC', 0),
(16, 1, 'Tribunal de Cuentas', 'AUTC', 0),
(17, 1, 'Financiero Contable', 'FCON', 0),
(18, 1, 'Centro de Info', 'CIOP', 0),
(19, 1, 'Servicio Medico', 'RRHH', 0),
(20, 1, 'Liquidacion de Haberes', 'RRHH', 0),
(21, 1, 'Autoridad Central', 'ASCL', 0),
(31, 1, 'Registro de Instituciones Culturales y de Enseñanza', 'ASCL', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `ID` int(11) NOT NULL,
  `CiTecnico` int(11) NOT NULL,
  `IdArea` int(11) NOT NULL,
  `NSerie` varchar(20) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `Nombre` varchar(30) DEFAULT NULL,
  `Apellido` varchar(30) DEFAULT NULL,
  `Usuario` varchar(30) DEFAULT NULL,
  `NombrePC` varchar(30) DEFAULT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `IdInventario` varchar(20) NOT NULL,
  `SistemaOp` varchar(20) DEFAULT NULL,
  `TipoEquipo` varchar(20) DEFAULT NULL,
  `Modelo` varchar(32) DEFAULT NULL,
  `Observaciones` varchar(256) DEFAULT NULL,
  `bajaLogica` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`ID`, `CiTecnico`, `IdArea`, `NSerie`, `Telefono`, `Nombre`, `Apellido`, `Usuario`, `NombrePC`, `Fecha`, `IdInventario`, `SistemaOp`, `TipoEquipo`, `Modelo`, `Observaciones`, `bajaLogica`) VALUES
(1, 50921456, 18, '8CC218222R', '1010', 'CIOP', '.', 'CIOP', 'DGS-PC-CIOP-001', '2023-02-14 16:39:42', '7913', 'Windows 10', 'PC', 'HP MINI PC', '', 0),
(2, 50921456, 2, '8CC2182248', '0', 'Julio', 'Bentancor', 'bentancor', 'DGS-PC-OYS-002', '2023-02-15 10:59:43', '0000007822', 'Win 10', 'PC', 'PC ...', '', 0),
(3, 50921456, 2, '24925', '0', 'Ana', 'Martinez', 'ana.martinez', 'DGS-PC-OYS-003', '2023-02-15 11:02:08', '414', 'Win 10', 'PC', 'PC ...', '', 0),
(4, 50921456, 2, 'D1931GB00183', '0', 'Anibal', 'Crossa', 'acrossa', 'DGS-PC-OYS-004', '2023-02-15 11:03:46', '2648', 'Win ...', 'PC', 'PC ...', '', 0),
(5, 50921456, 2, 'D1931GB00138', '0', 'Miguel', 'Deandrea', 'xxxxxxxx', 'DGS-PC-OYS-005', '2023-02-15 11:06:43', '2640', 'Win ...', 'PC', 'PC ...', '', 0),
(6, 50921456, 2, '8CC21821MH', '0', 'Daniel', 'Silva', 'silvad', 'DGS-PC-OYS-006', '2023-02-15 11:09:08', '0000007927', 'Win ...', 'PC', 'PC ...', '', 0),
(7, 50921456, 21, '8CC21822B', '1511', 'Maria Jose', 'Rocha', 'maria.rocha', 'DGS-PC-ASCL-004', '2023-02-15 11:12:40', '0000007899', 'Windows 10', 'PC', 'HP MiniPC', '', 0),
(8, 50921456, 3, '8CC21821LF', '0', 'Fatima', 'Bray', 'fatima.bray', 'DGS-PC-ASCL-010', '2023-02-15 11:15:06', '00000', 'Win 10', 'PC', 'MiniPC HP i5', '', 0),
(9, 50921456, 4, '0000000', '0', 'Alexandra', 'Echeverry', 'xxxxxxxx', 'DGS-PC-ASL-001', '2023-02-15 11:18:34', '00000000', 'Win ...', 'PC', 'PC ...', '', 0),
(10, 50921456, 4, '8CC218225L', '0', 'Giuliana', 'Charlo', 'giuliana.charlo', 'DGS-PC-ASL-002', '2023-02-15 11:20:00', '0000007874', 'Win ...', 'PC', 'PC ...', '', 0),
(11, 50921456, 4, '8CC21821RX', '0', 'Mariano', 'Passagio', '28411673', 'DGS-PC-ASL-003', '2023-02-15 11:22:57', '0000008118', 'Win ...', 'PC', 'PC ...', '', 0),
(12, 50921456, 4, '8CC21821JM', '0', 'Aldo', 'Alvarez', '19774569', 'DGS-PC-ASL-004', '2023-02-15 11:24:43', '0000007870', 'Win ...', 'PC', 'PC ...', '', 0),
(13, 50921456, 4, '8CC21821T1', '0', 'Juan Manuel', 'Gimeno', 'juan.gimeno', 'DGS-PC-ASL-005', '2023-02-15 11:26:53', '0000007907', 'Win ...', 'PC', 'PC ...', '', 0),
(14, 50921456, 4, '00000', '0', 'Vanessa', 'Casciano', 'vanessa.casciano', 'DGS-PC-ASL-006', '2023-02-15 11:27:42', '00000', 'Win ...', 'PC', 'PC ...', '', 0),
(15, 50921456, 4, '8CC21821SJ', '0', 'Adriana', 'Cabrera', 'acabrera', 'DGS-PC-ASL-008', '2023-02-15 11:29:56', '0000007926', 'Win ...', 'PC', 'PC ...', '', 0),
(16, 50921456, 4, '8CC1293SB6', '0', 'Hilda', 'Schol', 'schol', 'DGS-PC-ASL-009', '2023-02-15 11:41:09', '0000007122', 'Win ...', 'PC', 'PC ...', '', 0),
(17, 50921456, 5, 'SMJ06B1GV', '0', 'Roberto', 'Mendez', 'mendez', 'DGS-PC-CDIG-001', '2023-02-15 11:48:13', '0000004021', 'Win 10', 'PC', 'MiniPC HP i5', '', 0),
(18, 50921456, 5, 'DDB08L201190', '0', 'Ezequiel', 'Soarez', 'ezequiel.soarez', 'DGS-PC-CDIG-002', '2023-02-15 11:49:48', '0000007231', 'Win 10', 'PC', 'MiniPC HP i5', '', 0),
(19, 50921456, 6, 'CLON-291210-853', '0', 'Frieder', 'Walker', 'frieder.walker', 'DGS-PC-CIP-002', '2023-02-15 11:51:19', '00000', 'Win 10', 'PC', 'PC ...', '', 0),
(20, 50921456, 6, '8CC218221X', '0', 'Marcela', 'Olano', 'olano', 'DGS-PC-CIP-004', '2023-02-15 14:14:22', '0000007895', 'Win 10', 'PC', 'PC ...', '', 0),
(21, 50921456, 6, 'SMJ07G2Y1', '0', 'Graciela', 'Morelli', 'graciela.morelli', 'DGS-PC-CIP-006', '2023-02-15 15:17:46', '0000004921', 'Win ...', 'PC', 'PC ...', '', 0),
(22, 50921456, 6, '8CC21821T6', '0', 'Noela', 'Picun', 'noela.picun', 'DGS-PC-CIP-007', '2023-02-15 15:20:17', '0000007898', 'Win ...', 'PC', 'PC ...', '', 0),
(25, 55440384, 1, '987897', '9789', '7897897', '987987', '987987', 'DGS-PC-SIS-002', '2023-02-15 15:26:42', '=', 'Windoes 10', 'PC', '', '', 0),
(26, 50921456, 8, '8CC218223H', '0', 'Mercedes', 'Zamarripa', 'zamarripa', 'DGS-PC-DIR-002', '2023-02-15 16:43:10', '0000007847', 'Win 10', 'PC', 'PC ...', '', 0),
(27, 50921456, 8, '8CC218226N', '0', 'Carla', 'Klappenbach', 'klappenbach', 'DGS-PC-DIR-003', '2023-02-15 16:55:20', '0000007840', 'Win ...', 'PC', 'PC ...', '', 0),
(28, 50921456, 9, '00000', '0', 'Maria', 'Rodriguez', 'xxxxxxxxx', 'DGS-PC-GFIN-001', '2023-02-16 11:25:13', '00000', 'Win 10', 'PC', 'PC ...', '', 0),
(29, 50921456, 9, 'SMJ0EGFN8', '0', 'Purificacion', 'Castro', 'purificacion.castro', 'DGS-PC-GFIN-002', '2023-02-16 11:27:27', '0000006860', 'Win 10', 'PC', 'MiniPC Lenovo', '', 0),
(30, 50921456, 9, '8CC21821LS', '0', 'Paula', 'Villar', 'paula.villar', 'DGS-PC-GFIN-003', '2023-02-16 11:28:28', '0000007838', 'Win ...', 'PC', 'PC ...', '', 0),
(31, 50921456, 9, '8CC21821KS', '0', 'Yasmin', 'Diaz', 'yasmin.diaz', 'DGS-PC-GFIN-004', '2023-02-16 11:29:37', '0000007866', 'Win ...', 'PC', 'PC ...', '', 0),
(32, 50921456, 9, '8CC218221F', '0', 'Vanesa', 'Martinez', 'martinezv', 'DGS-PC-GFIN-005', '2023-02-16 11:40:17', '0000007827', 'Win 10', 'PC', 'PC ...', '', 0),
(33, 50921456, 9, '8CC21821RW', '0', 'Gloria', 'Zelpo', 'gloria.zelpo', 'DGS-PC-GFIN-006', '2023-02-16 12:48:09', '0000007831', 'Win 10', 'PC', 'PC ...', '', 0),
(34, 50921456, 9, '8CC218222W', '0', 'Jose', 'Carrera', 'carrera', 'DGS-PC-GFIN-007', '2023-02-16 12:49:55', '0000007867', 'Win 10', 'PC', 'PC ...', '', 0),
(35, 50921456, 9, 'DDB08L201186', '0', 'Mabel', 'Pereira', 'xxxxxx', 'DGS-PC-GFIN-008', '2023-02-16 12:51:22', '0000007226', 'Win 10', 'PC', 'PC ...', '', 0),
(36, 50921456, 9, '8CC21821JR', '0', 'Sandra', 'Cestaro', 'cestaro', 'DGS-PC-GFIN-009', '2023-02-16 12:53:49', '0000007836', 'Win 10', 'PC', 'MiniPC HP i5', '', 0),
(37, 50921456, 9, 'SMJ06B1GX', '0', 'Franco', 'Guerra', 'franco.guerra', 'DGS-PC-GFIN-010', '2023-02-16 12:55:26', '0000004029', 'Win ...', 'PC', 'PC ...', '', 0),
(38, 50921456, 12, '8CC218221N', '0', 'Fabiana', 'Concheso', 'xxxxxx', 'DGS-PC-RRHH-001', '2023-02-16 13:00:10', '0000007921', 'Win 10', 'PC', 'PC ...', '', 0),
(39, 50921456, 12, '8CC21821TG', '0', 'Ivone', 'Garda', 'garda', 'DGS-PC-RRHH-002', '2023-02-16 13:03:15', '0000007832', 'Win 10', 'PC', 'MiniPc HP i5', '', 0),
(40, 50921456, 12, '8CC21821JW', '0', 'Juanita', 'Sicilia', 'sicilia', 'DGS-PC-RRHH-003', '2023-02-16 13:05:27', '0000007903', 'Win ...', 'PC', 'PC ...', '', 0),
(41, 50921456, 12, '8CC21821WH', '0', 'Daniela', 'Cabrera', 'dcabrera', 'DGS-PC-RRHH-004', '2023-02-16 13:06:32', '0000007891', 'Win ...', 'PC', 'PC ...', '', 0),
(42, 50921456, 12, '8CC2182257', '0', 'Jennifer', 'Miller', 'jennifer.miller', 'DGS-PC-RRHH-005', '2023-02-16 13:08:10', '0000007891', 'Win ...', 'PC', 'PC ...', '', 0),
(43, 50921456, 12, '8CC21821ZV', '0', 'Pamela', 'Guarino', 'pguarino', 'DGS-PC-RRHH-006', '2023-02-16 13:09:26', '0000007845', 'Win ...', 'PC', 'PC ...', '', 0),
(44, 50921456, 12, '8CC218221W', '0', 'Silvia', 'Velazquez', 'svelazquez', 'DGS-PC-RRHH-007', '2023-02-16 13:10:48', '0000007846', 'Win ...', 'PC', 'PC ...', '', 0),
(45, 50921456, 12, '8CC21821TL', '0', 'Ianara', 'portillo', 'ianara.portillo', 'DGS-PC-RRHH-008', '2023-02-16 13:14:25', '0000007856', 'Win ...', 'PC', 'PC ...', '', 0),
(46, 50921456, 12, '8CC218221V', '0', 'Florencia', 'Perez', 'xxxxxx', 'DGS-PC-RRHH-009', '2023-02-16 13:16:27', '0000007868', 'Win ...', 'PC', 'PC ...', '', 0),
(47, 50921456, 12, '8CC21821M3', '0', 'Mariana', 'Campos', 'mariana.campos', 'DGS-PC-RRHH-010', '2023-02-16 13:17:57', '0000007869', 'Win ...', 'PC', 'PC ...', '', 0),
(48, 50921456, 12, '8CC218223N', '0', 'Adriana', 'Melissari', 'melissaria', 'DGS-PC-RRHH-011', '2023-02-16 13:19:30', '0000007880', 'Win ...', 'PC', 'PC ...', '', 0),
(49, 50921456, 12, '8CC21821KR', '0', 'Alejandra', 'Morales', 'amorales', 'DGS-PC-RRHH-012', '2023-02-16 13:21:12', '0000007893', 'Win ...', 'PC', 'PC ...', '', 0),
(50, 50921456, 12, '8CC21821V9', '0', 'Elen', 'Alzamendi', 'elen.alzamendi', 'DGS-PC-RRHH-013', '2023-02-16 13:22:43', '0000007826', 'Win ...', 'PC', 'PC ...', '', 0),
(51, 50921456, 12, '8CC21821HN', '0', 'Vanessa', 'NuÃ±ez', 'vanessa.nunez', 'DGS-PC-RRHH-014', '2023-02-16 13:24:08', '0000007892', 'Windoes 10', 'PC', 'PC ...', '', 0),
(52, 50921456, 12, '8CC2182250', '0', 'Ramiro', 'Pintos', 'ramiro.pintos', 'DGS-PC-RRHH-015', '2023-02-16 13:25:23', '0000007897', 'Win 10', 'PC', 'PC ...', '', 0),
(53, 50921456, 12, '8CC21821P3', '0', 'Carolina', 'Casotti', 'CASOTTI', 'DGS-PC-RRHH-017', '2023-02-16 13:37:01', '0000007910', 'Win ...', 'PC', 'PC ...', '', 0),
(54, 50921456, 12, '8CC21821RG', '0', 'Yesica', 'Bozzolasco', 'BOZZOLASCOY', 'DGS-PC-RRHH-018', '2023-02-16 13:39:19', '0000007911', 'Win ...', 'PC', 'PC ...', '', 0),
(55, 50921456, 12, '8CC21821VT', '0', 'Ana Clara', 'Landes', 'anaclara.landes', 'DGS-PC-RRHH-022', '2023-02-16 13:41:56', '0000007924', 'Win ...', 'PC', 'PC ...', '', 0),
(56, 50921456, 19, '8CC21821PY', '1537', 'Ana', 'Oyamburo', 'oyamburo', 'DGS-PC-RRHH-023', '2023-02-16 13:42:54', '0000007841', 'Win 10', 'PC', 'HP MiniPC', 'Se realizo cambio de GHM a MiniPC HP', 0),
(57, 50921456, 12, '8CC21821HD', '0', 'Ana', 'Cabrera', 'cabrera', 'DGS-PC-RRHH-024', '2023-02-16 13:43:52', 'xxxxxx', 'Win ...', 'PC', 'PC ...', '', 0),
(58, 50921456, 12, '8CC2182249', '0', 'Consultorio', 'Medico', 'xxxxx', 'DGS-PC-RRHH-025', '2023-02-16 13:44:57', '00000', 'Win ...', 'PC', 'PC ...', '', 0),
(59, 50921456, 12, '8CC21821R1', '1537', 'Naomi', 'Gonzalez', 'naomi.gonzalez', 'DGS-PC-RRHH-027', '2023-02-16 13:47:32', '0000008243', 'Windows 10', 'PC', 'HP MiniPC', 'Se realizo cambio de GHM a MiniPC HP', 0),
(60, 50921456, 12, '8CC2182223', '0', 'Romina', 'Olivera', 'romina.olivera', 'DGS-PC-RRHH-033', '2023-02-16 13:48:43', '00000', 'Win ...', 'PC', 'PC ...', '', 0),
(61, 50921456, 1, '8CC1293SGN', '0', 'Gabriela', 'Velazquez', 'velazquezg', 'DGS-PC-SIS-001', '2023-02-16 13:50:22', '0000007125', 'Win 10', 'PC', 'MiniPC HP i5', '', 0),
(62, 50921456, 13, 'D1931GB00028', '0', 'Marianella', 'Ceriani', 'marianella.ceriani', 'DGS-PC-SUB-001', '2023-02-16 13:54:10', '00000', 'Win 10', 'PC', 'PC ...', '', 0),
(63, 19145380, 15, '000', '0', 'Nicolas', 'Miraballe', 'nicolas.miraballe', 'DGS-PC-GDOC-001', '2023-02-16 14:05:24', '00', 'windows 10', 'PC', 'PC..', '', 0),
(64, 50921456, 15, '00000', '0', 'Sonia', 'Bertino', 'sonia.bertino', 'DGS-PC-GDOC-002', '2023-02-16 14:17:24', '00000', 'Win 10', 'PC', 'PC ...', '', 0),
(65, 50921456, 15, '00000', '0', 'Kimberly', 'Durante', 'kimberly.durante', 'DGS-PC-GDOC-003', '2023-02-16 14:18:44', '000000', 'Win 10', 'PC', 'PC ...', '', 0),
(66, 50921456, 16, '00000', '0', 'Veronica', 'Valdez', 'veronica.valdez', 'DGS-PC-AUTC-001', '2023-02-16 14:20:51', '00000', 'Win 10', 'PC', 'MiniPc HP i5', '', 0),
(67, 50921456, 16, '00000', '0', 'Leticia', 'Luzardo', 'leticia.luzardo', 'DGS-PC-AUTC-002', '2023-02-16 14:22:04', '00000', 'Win 10', 'PC', 'PC ...', '', 0),
(68, 50921456, 16, '00000', '0', 'Julio', 'Mello', 'julio.mello', 'DGS-PC-AUTC-003', '2023-02-16 14:23:18', '00000', 'Win 10', 'PC', 'PC ...', '', 0),
(69, 50921456, 16, '00000', '0', 'Marcos', 'Tio', 'marcos.tio', 'DGS-PC-AUTC-004', '2023-02-16 14:24:05', '00000', 'Win 10', 'PC', 'PC ...', '', 0),
(71, 50921456, 17, 'MJ07G2IG', '0', 'Leticia', 'Nasso', 'nasso', 'DGS-PC-FCON-001', '2023-02-16 14:31:50', '0000004932', 'Win 10', 'PC', 'Lenovo i5', '', 0),
(78, 56347325, 5, '8CC2182258', '1010', 'CIOP', 'CIOP', 'ciop.ciop', 'DGS-PC-CDIG-004', '2023-03-01 16:53:34', '07923', 'Windows 10', 'PC', 'HP MINI PC', '', 0),
(79, 56347325, 5, '8CC21821QJ', '1010', 'CIOP', '.', 'CIOP', 'DGS-PC-CDIG-003', '2023-03-03 12:56:02', '7908', 'Windows 10', 'PC', 'HP MINI PC', '', 0),
(80, 56347325, 18, '8CC21821YP', '1010', 'CIOP', '.', 'CIOP', 'DGS-PC-CIOP-002', '2023-03-03 13:03:57', '787', 'Windows 10', 'PC', 'HP MINI PC', '', 0),
(82, 50921456, 19, '8CC21821L9', '1537', 'Ricardo', 'Rodo', 'rodo', 'DGS-PC-RRHH-019', '2023-03-09 12:35:57', '0000007900', 'Windows 10', 'PC', 'HP MiniPC', '', 0),
(83, 50921456, 20, '8CC21821WQ', '1424', 'Fabiana', 'Saura', 'sauraf', 'DGS-PC-RRHH-099', '2023-03-09 13:51:46', '0000007889', 'Win 10', 'PC', 'HP MiniPc', 'Puesto provisoriamente el nombre de PC DGS-PC-RRHH-099', 0),
(94, 50833392, 21, '8CC21821YS', '', 'Monica', 'Cardoso', 'monica.cardoso', 'DGS-PC-ASCL-002', '2023-03-27 15:00:51', '0000007887', 'Windows 10', 'PC', 'HP PRODESK  400 G6', '', 0),
(95, 50921456, 21, '8CC218220Z', '1511', 'Daniel', 'Trecca', 'trecca', 'DGS-PC-ASCL-003', '2023-03-29 11:42:32', '0000007861', 'Windows 10', 'PC', 'HP MiniPC', '', 0),
(96, 50921456, 31, '8CC21821WP', '0', 'Rossana', 'Debenedetti', 'rdebenedetti', 'DGS-PC-ASCL-005', '2023-03-29 15:51:28', '0000007849', 'Windows 10', 'PC', 'HP MiniPC', '', 0),
(97, 50921456, 31, '8CC21821WM', '0', 'Irene', 'Cajarville', 'cajarville', 'DGS-PC-ASCL-006', '2023-03-29 15:56:14', '0000007833', 'Windows 10', 'PC', 'HP MiniPC', '', 0),
(98, 50921456, 31, '8CC2182233', '1511', 'Claudia', 'Pacheli', 'pacheli', 'DGS-PC-ASCL-007', '2023-03-29 16:15:25', '0000007863', 'Windows 10', 'PC', 'HP MiniPC', '', 0),
(99, 50921456, 21, '8CC21821V2', '1511', 'Miguel', 'Marchesano', 'marchesano', 'DGS-PC-ASCL-008', '2023-03-30 11:49:02', '0000007925', 'Windows 10', 'PC', 'HP MiniPC', '', 0),
(100, 50921456, 31, '8CC21821Q4', '1522', 'Gabriela', 'Morales', 'morales', 'DGS-PC-ASCL-009', '2023-03-30 11:54:08', '0000007864', 'Windows 10', 'PC', 'HP MiniPC', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `ID` int(11) NOT NULL,
  `CiUsuario` int(11) NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `Titulo` varchar(50) DEFAULT NULL,
  `Descripcion` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`ID`, `CiUsuario`, `Fecha`, `Titulo`, `Descripcion`) VALUES
(239, 56347325, '2023-02-14 14:38:09', 'Creacion de usuario', 'Se creo el usuario lucas.marsiglia'),
(240, 56347325, '2023-02-14 14:44:56', 'Creacion de usuario', 'Se creo el usuario wilson.rodriguez'),
(241, 56347325, '2023-02-14 14:48:19', 'Edicion de usuario', 'Se edito el usuario bruno.alvezdacruz'),
(242, 55440384, '2023-02-14 14:57:51', 'Creacion de unidad ejecutora', 'Se creo la unidad DGS-Direccion General de Secretaria'),
(243, 55440384, '2023-02-14 14:58:50', 'Creacion de Area', 'Se creo la area SIS-Sistemas ,Perteneciente a la UE 1|DGS'),
(244, 56347325, '2023-02-14 15:04:12', 'Creacion de usuario', 'Se creo el usuario nicolas.perez'),
(245, 50921456, '2023-02-14 15:28:52', 'Edicion de usuario', 'Se modifico el usuario nicolas.perez'),
(246, 50921456, '2023-02-14 15:32:32', 'Creacion de unidad ejecutora', 'Se creo la unidad EDU-Educacion'),
(247, 50921456, '2023-02-14 15:46:36', 'Creacion de unidad ejecutora', 'Se creo el area OYS-Obras y Servicios, Perteneciente a DGS'),
(248, 50921456, '2023-02-14 15:48:26', 'Creacion de unidad ejecutora', 'Se creo el area ASCL-Asuntos Constitucionales, Perteneciente a DGS'),
(249, 50921456, '2023-02-14 15:49:00', 'Creacion de unidad ejecutora', 'Se creo el area ASL-Asesoria Letrada, Perteneciente a DGS'),
(250, 50921456, '2023-02-14 15:49:36', 'Creacion de unidad ejecutora', 'Se creo el area CDIG-Ciudadania Digital, Perteneciente a DGS'),
(251, 50921456, '2023-02-14 15:50:39', 'Creacion de unidad ejecutora', 'Se creo el area CIP-Cooperacion y Proyectos, Perteneciente a DGS'),
(252, 50921456, '2023-02-14 15:52:02', 'Creacion de unidad ejecutora', 'Se creo el area COM-Comunicaciones, Perteneciente a DGS'),
(253, 50921456, '2023-02-14 15:55:24', 'Creacion de unidad ejecutora', 'Se creo el area DIR-Direccion General, Perteneciente a DGS'),
(254, 50921456, '2023-02-14 15:56:14', 'Creacion de unidad ejecutora', 'Se creo el area GFIN-Gestion Financiero, Perteneciente a DGS'),
(255, 50921456, '2023-02-14 15:58:58', 'Creacion de unidad ejecutora', 'Se creo el area JNOT-Juridico Notarial, Perteneciente a DGS'),
(256, 50921456, '2023-02-14 16:02:01', 'Creacion de unidad ejecutora', 'Se creo el area PECA-PECA, Perteneciente a DGS'),
(257, 50921456, '2023-02-14 16:02:45', 'Creacion de unidad ejecutora', 'Se creo el area RRHH-Recursos Humanos, Perteneciente a DGS'),
(258, 50921456, '2023-02-14 16:04:59', 'Creacion de unidad ejecutora', 'Se creo el area SUB-Subsecretaria, Perteneciente a DGS'),
(259, 50921456, '2023-02-14 16:06:10', 'Creacion de unidad ejecutora', 'Se creo el area SISP-Sistemas Prestamo, Perteneciente a DGS'),
(260, 50921456, '2023-02-14 16:11:46', 'Creacion de unidad ejecutora', 'Se creo el area GDOC-Gestion Documental, Perteneciente a DGS'),
(261, 50921456, '2023-02-14 16:13:14', 'Creacion de unidad ejecutora', 'Se creo el area AUTC-Tribunal de Cuentas, Perteneciente a DGS'),
(262, 50921456, '2023-02-14 16:39:43', 'Registro PC', 'Se registro la pc DGS-PC-OYS-001'),
(263, 55440384, '2023-02-14 16:42:36', 'Edicion de Area', 'Se edito la area SIS-Sistemas ,Perteneciente a la UE '),
(264, 55440384, '2023-02-14 16:42:51', 'Edicion de Area', 'Se edito la area SOS-Sostemas ,Perteneciente a la UE '),
(265, 55440384, '2023-02-14 16:43:07', 'Edicion de Area', 'Se edito la area SIS-Sistemas ,Perteneciente a la UE '),
(266, 55440384, '2023-02-14 16:47:26', 'Edicion de Area', 'Se edito la area SIS-Sistemas ,Perteneciente a la UE '),
(267, 55440384, '2023-02-14 16:52:30', 'Edicion de Area', 'Se edito la area SIS-Sistemas ,Perteneciente a la UE '),
(268, 56347325, '2023-02-14 17:21:11', 'Edicion de usuario', 'Se edito el usuario bruno.alvezdacruz'),
(269, 50921456, '2023-02-15 10:59:44', 'Registro PC', 'Se registro la pc DGS-PC-OYS-002'),
(270, 50921456, '2023-02-15 11:02:08', 'Registro PC', 'Se registro la pc DGS-PC-OYS-003'),
(271, 50921456, '2023-02-15 11:03:46', 'Registro PC', 'Se registro la pc DGS-PC-OYS-004'),
(272, 50921456, '2023-02-15 11:06:43', 'Registro PC', 'Se registro la pc DGS-PC-OYS-005'),
(273, 50921456, '2023-02-15 11:09:09', 'Registro PC', 'Se registro la pc DGS-PC-OYS-006'),
(274, 50921456, '2023-02-15 11:12:40', 'Registro PC', 'Se registro la pc DGS-PC-ASCL-001'),
(275, 50921456, '2023-02-15 11:15:06', 'Registro PC', 'Se registro la pc DGS-PC-ASCL-002'),
(276, 50921456, '2023-02-15 11:18:35', 'Registro PC', 'Se registro la pc DGS-PC-ASL-001'),
(277, 50921456, '2023-02-15 11:20:00', 'Registro PC', 'Se registro la pc DGS-PC-ASL-002'),
(278, 50921456, '2023-02-15 11:22:57', 'Registro PC', 'Se registro la pc DGS-PC-ASL-003'),
(279, 50921456, '2023-02-15 11:24:43', 'Registro PC', 'Se registro la pc DGS-PC-ASL-004'),
(280, 50921456, '2023-02-15 11:26:53', 'Registro PC', 'Se registro la pc DGS-PC-ASL-005'),
(281, 50921456, '2023-02-15 11:27:42', 'Registro PC', 'Se registro la pc DGS-PC-ASL-006'),
(282, 50921456, '2023-02-15 11:29:57', 'Registro PC', 'Se registro la pc DGS-PC-ASL-007'),
(283, 50921456, '2023-02-15 11:41:09', 'Registro PC', 'Se registro la pc DGS-PC-ASL-008'),
(284, 55440384, '2023-02-15 11:42:09', 'Edicion de Area', 'Se edito la area SIS-Sistemas ,Perteneciente a la UE '),
(285, 55440384, '2023-02-15 11:42:19', 'Edicion de Area', 'Se edito la area SIS-Sistemas ,Perteneciente a la UE '),
(286, 55440384, '2023-02-15 11:42:52', 'Edicion de Area', 'Se edito la area SIS-perepepeep ,Perteneciente a la UE '),
(287, 55440384, '2023-02-15 11:47:28', 'Edicion de Area', 'Se edito la area SIS-perepepeep ,Perteneciente a la UE 1'),
(288, 55440384, '2023-02-15 11:47:36', 'Edicion de Area', 'Se edito la area SIS-Sistemas ,Perteneciente a la UE 1'),
(289, 55440384, '2023-02-15 11:47:56', 'Edicion de Area', 'Se edito la area SIS-Sistemas ,Perteneciente a la UE 1'),
(290, 55440384, '2023-02-15 11:48:01', 'Edicion de Area', 'Se edito la area SIS-Sistemas ,Perteneciente a la UE 2'),
(291, 55440384, '2023-02-15 11:48:13', 'Edicion de Area', 'Se edito la area SIS-Sistemas ,Perteneciente a la UE 1'),
(292, 50921456, '2023-02-15 11:48:13', 'Registro PC', 'Se registro la pc DGS-PC-CDIG-001'),
(293, 50921456, '2023-02-15 11:49:48', 'Registro PC', 'Se registro la pc DGS-PC-CDIG-002'),
(294, 50921456, '2023-02-15 11:51:19', 'Registro PC', 'Se registro la pc DGS-PC-CIP-001'),
(295, 55440384, '2023-02-15 12:57:23', 'Edicion de Area', 'Se edito la area SIS-Sistemas ,Perteneciente a la UE 2'),
(296, 55440384, '2023-02-15 12:57:33', 'Edicion de Area', 'Se edito la area SIS-Sistemas ,Perteneciente a la UE 1'),
(297, 55440384, '2023-02-15 12:58:46', 'Creacion de unidad ejecutora', 'Se creo la unidad PRB-Prueba'),
(298, 55440384, '2023-02-15 14:06:39', 'Edicion de unidad ejecutora', 'Se edito la unidad PRB-Prueba'),
(299, 55440384, '2023-02-15 14:06:43', 'Edicion de unidad ejecutora', 'Se edito la unidad PRB-Prueba'),
(300, 55440384, '2023-02-15 14:07:24', 'Edicion de unidad ejecutora', 'Se edito la unidad PRB-Prueba'),
(301, 55440384, '2023-02-15 14:07:34', 'Edicion de unidad ejecutora', 'Se edito la unidad PRB-ueueueueueeuu'),
(302, 55440384, '2023-02-15 14:07:51', 'Edicion de unidad ejecutora', 'Se edito la unidad PRB-ueueueueueeuu'),
(303, 55440384, '2023-02-15 14:07:58', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(304, 55440384, '2023-02-15 14:08:40', 'Edicion de unidad ejecutora', 'Se edito la unidad JHGJH-gjhgjh'),
(305, 55440384, '2023-02-15 14:10:07', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(306, 55440384, '2023-02-15 14:12:37', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(307, 55440384, '2023-02-15 14:12:59', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(308, 50921456, '2023-02-15 14:14:22', 'Registro PC', 'Se registro la pc DGS-PC-CIP-003'),
(309, 55440384, '2023-02-15 14:14:55', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(310, 55440384, '2023-02-15 14:14:58', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(311, 55440384, '2023-02-15 14:14:58', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(312, 55440384, '2023-02-15 14:14:59', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(313, 55440384, '2023-02-15 14:14:59', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(314, 55440384, '2023-02-15 14:14:59', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(315, 55440384, '2023-02-15 14:15:30', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(316, 55440384, '2023-02-15 14:15:58', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(317, 55440384, '2023-02-15 14:16:12', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(318, 55440384, '2023-02-15 14:16:17', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(319, 55440384, '2023-02-15 14:16:58', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(320, 55440384, '2023-02-15 14:17:05', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(321, 55440384, '2023-02-15 14:17:20', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(322, 55440384, '2023-02-15 14:17:25', 'Edicion de unidad ejecutora', 'Se edito la unidad 878-ueueueueueeuu'),
(323, 55440384, '2023-02-15 14:17:29', 'Edicion de unidad ejecutora', 'Se edito la unidad 878HIHIUH-iuhi'),
(324, 55440384, '2023-02-15 14:17:45', 'Edicion de unidad ejecutora', 'Se edito la unidad PRB-prueba'),
(325, 55440384, '2023-02-15 14:18:20', 'Edicion de unidad ejecutora', 'Se edito la unidad NO-Direccion General de Secretaria'),
(326, 55440384, '2023-02-15 14:18:32', 'Edicion de unidad ejecutora', 'Se edito la unidad DGS-Direccion General de Secretaria'),
(327, 55440384, '2023-02-15 14:19:03', 'Edicion de unidad ejecutora', 'Se edito la unidad DGS-Direccion General de Secretaria'),
(328, 55440384, '2023-02-15 14:19:46', 'Edicion de unidad ejecutora', 'Se edito la unidad DGS-Direccion General de Secretaria'),
(329, 55440384, '2023-02-15 14:20:23', 'Edicion de Area', 'Se edito la area OYS-Obras y Servicios ,Perteneciente a la UE 2'),
(330, 55440384, '2023-02-15 14:20:42', 'Edicion de Area', 'Se edito la area OYS-Obras y Servicios ,Perteneciente a la UE 1'),
(331, 55440384, '2023-02-15 14:22:40', 'Edicion de Area', 'Se edito la area OYS-Bobras y Servicios ,Perteneciente a la UE 1'),
(332, 55440384, '2023-02-15 14:23:08', 'Edicion de Area', 'Se edito la area OYS-Bobras y Servicios ,Perteneciente a la UE 1'),
(333, 55440384, '2023-02-15 14:23:15', 'Edicion de Area', 'Se edito la area OYS-Obras y Servicios ,Perteneciente a la UE 1'),
(334, 55440384, '2023-02-15 14:25:27', 'Creacion de unidad ejecutora', 'Se creo la unidad PRB2-Prueba 2'),
(335, 55440384, '2023-02-15 14:27:15', 'Creacion de unidad ejecutora', 'Se creo la unidad PRB3-Prueba 3'),
(336, 55440384, '2023-02-15 14:29:01', 'Creacion de unidad ejecutora', 'Se creo la unidad PRB4-Prueba 4'),
(337, 55440384, '2023-02-15 14:29:45', 'Creacion de unidad ejecutora', 'Se creo la unidad RYTR-ytrty'),
(338, 55440384, '2023-02-15 14:33:55', 'Creacion de unidad ejecutora', 'Se creo la unidad 87686-78686'),
(339, 55440384, '2023-02-15 14:34:08', 'Creacion de Area', 'Se creo la area PRUEBA-prueba ,Perteneciente a la UE 1'),
(340, 56347325, '2023-02-15 14:43:05', 'Creacion de usuario', 'Se creo el usuario pereiran'),
(341, 50921456, '2023-02-15 15:17:46', 'Registro PC', 'Se registro la pc DGS-PC-CIP-005'),
(342, 50921456, '2023-02-15 15:20:17', 'Registro PC', 'Se registro la pc DGS-PC-CIP-007'),
(343, 50921456, '2023-02-15 15:22:40', 'Edicion de usuario', 'Se modifico el usuario lucas.marsiglia'),
(344, 55440384, '2023-02-15 15:26:04', 'Registro PC', 'Se registro la pc DGS-PC-OYS-007'),
(345, 55440384, '2023-02-15 15:26:21', 'Registro PC', 'Se registro la pc DGS-PC-SIS-001'),
(346, 55440384, '2023-02-15 15:26:42', 'Registro PC', 'Se registro la pc DGS-PC-SIS-002'),
(347, 50921456, '2023-02-15 16:43:10', 'Registro PC', 'Se registro la pc DGS-PC-DIR-001'),
(348, 50921456, '2023-02-15 16:55:20', 'Registro PC', 'Se registro la pc DGS-PC-DIR-003'),
(349, 50921456, '2023-02-16 11:25:13', 'Registro PC', 'Se registro la pc DGS-PC-GFIN-001'),
(350, 50921456, '2023-02-16 11:27:27', 'Registro PC', 'Se registro la pc DGS-PC-GFIN-002'),
(351, 50921456, '2023-02-16 11:28:28', 'Registro PC', 'Se registro la pc DGS-PC-GFIN-003'),
(352, 50921456, '2023-02-16 11:29:37', 'Registro PC', 'Se registro la pc DGS-PC-GFIN-004'),
(353, 50921456, '2023-02-16 11:40:17', 'Registro PC', 'Se registro la pc DGS-PC-GFIN-005'),
(354, 50921456, '2023-02-16 12:48:09', 'Registro PC', 'Se registro la pc DGS-PC-GFIN-006'),
(355, 50921456, '2023-02-16 12:49:55', 'Registro PC', 'Se registro la pc DGS-PC-GFIN-007'),
(356, 50921456, '2023-02-16 12:51:22', 'Registro PC', 'Se registro la pc DGS-PC-GFIN-008'),
(357, 50921456, '2023-02-16 12:53:49', 'Registro PC', 'Se registro la pc DGS-PC-GFIN-009'),
(358, 50921456, '2023-02-16 12:55:26', 'Registro PC', 'Se registro la pc DGS-PC-GFIN-010'),
(359, 50921456, '2023-02-16 13:00:10', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-001'),
(360, 50921456, '2023-02-16 13:03:15', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-002'),
(361, 50921456, '2023-02-16 13:05:29', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-003'),
(362, 50921456, '2023-02-16 13:06:34', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-004'),
(363, 50921456, '2023-02-16 13:08:14', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-005'),
(364, 50921456, '2023-02-16 13:09:27', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-006'),
(365, 50921456, '2023-02-16 13:10:48', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-007'),
(366, 50921456, '2023-02-16 13:14:26', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-008'),
(367, 50921456, '2023-02-16 13:16:27', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-009'),
(368, 50921456, '2023-02-16 13:17:58', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-010'),
(369, 50921456, '2023-02-16 13:19:30', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-011'),
(370, 50921456, '2023-02-16 13:21:12', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-012'),
(371, 50921456, '2023-02-16 13:22:43', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-013'),
(372, 50921456, '2023-02-16 13:24:08', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-014'),
(373, 50921456, '2023-02-16 13:25:23', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-015'),
(374, 50921456, '2023-02-16 13:37:01', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-017'),
(375, 50921456, '2023-02-16 13:39:19', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-018'),
(376, 50921456, '2023-02-16 13:41:56', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-022'),
(377, 50921456, '2023-02-16 13:42:54', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-023'),
(378, 50921456, '2023-02-16 13:43:52', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-024'),
(379, 50921456, '2023-02-16 13:44:57', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-025'),
(380, 50921456, '2023-02-16 13:47:32', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-027'),
(381, 50921456, '2023-02-16 13:48:43', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-033'),
(382, 50921456, '2023-02-16 13:50:22', 'Registro PC', 'Se registro la pc DGS-PC-SIS-001'),
(383, 50921456, '2023-02-16 13:54:10', 'Registro PC', 'Se registro la pc DGS-PC-SUB-001'),
(384, 19145380, '2023-02-16 14:05:24', 'Registro PC', 'Se registro la pc DGS-PC-GDOC-001'),
(385, 50921456, '2023-02-16 14:17:24', 'Registro PC', 'Se registro la pc DGS-PC-GDOC-002'),
(386, 50921456, '2023-02-16 14:18:45', 'Registro PC', 'Se registro la pc DGS-PC-GDOC-003'),
(387, 50921456, '2023-02-16 14:20:51', 'Registro PC', 'Se registro la pc DGS-PC-AUTC-001'),
(388, 50921456, '2023-02-16 14:22:04', 'Registro PC', 'Se registro la pc DGS-PC-AUTC-002'),
(389, 50921456, '2023-02-16 14:23:18', 'Registro PC', 'Se registro la pc DGS-PC-AUTC-003'),
(390, 50921456, '2023-02-16 14:24:05', 'Registro PC', 'Se registro la pc DGS-PC-AUTC-004'),
(391, 50921456, '2023-02-16 14:25:36', 'Registro PC', 'Se registro la pc DGS-PC-AUTC-005'),
(392, 50921456, '2023-02-16 14:29:19', 'Edicion de PC', 'Se modifico el PC DGS-PC-RRHH-034'),
(393, 50921456, '2023-02-16 14:30:01', 'Creacion de unidad ejecutora', 'Se creo el area FCON-Financiero Contable, Perteneciente a DGS'),
(394, 50921456, '2023-02-16 14:31:50', 'Registro PC', 'Se registro la pc DGS-PC-FCON-001'),
(395, 56347325, '2023-02-16 15:26:18', 'Creacion de usuario', 'Se creo el usuario barros'),
(396, 56347325, '2023-02-17 16:39:36', 'Creacion de usuario', 'Se creo el usuario daniel.nalotto'),
(397, 55440384, '2023-02-22 15:18:03', 'Edicion PC', 'Se edito la pc DGS-PC-RRHH-014'),
(398, 55440384, '2023-02-22 17:01:56', 'Creacion de usuario', 'Se creo el usuario christian.lessa'),
(399, 55440384, '2023-02-22 17:02:19', 'Edicion de usuario', 'Se edito el usuario christian.lessa'),
(400, 50833392, '2023-02-23 12:15:44', 'Registro PC', 'Se registro la pc DGS-PC-OYS-001'),
(401, 55440384, '2023-02-23 12:20:58', 'Registro PC', 'Se registro la pc DGS-PC-CIP-001'),
(402, 55440384, '2023-02-23 12:21:46', 'Registro PC', 'Se registro la pc DGS-PC-CIP-003'),
(403, 55440384, '2023-02-23 12:23:38', 'Registro PC', 'Se registro la pc DGS-PC-CIP-005'),
(404, 55440384, '2023-02-23 12:24:01', 'Registro PC', 'Se registro la pc DGS-PC-CIP-008'),
(405, 50833392, '2023-02-23 12:32:19', 'Edicion PC', 'Se edito la pc DGS-PC-SIS-001'),
(406, 50833392, '2023-02-23 12:32:28', 'Edicion PC', 'Se edito la pc DGS-PC-SIS-001'),
(407, 50833392, '2023-02-23 12:32:33', 'Edicion PC', 'Se edito la pc DGS-PC-SIS-001'),
(408, 50833392, '2023-02-23 12:32:46', 'Edicion PC', 'Se edito la pc DGS-PC-SIS-001'),
(409, 50833392, '2023-02-23 12:34:56', 'Edicion PC', 'Se edito la pc DGS-PC-SIS-001'),
(410, 55440384, '2023-02-23 12:50:36', 'Edicion PC', 'Se edito la pc DGS-PC-RRHH-034'),
(411, 55440384, '2023-02-23 12:50:40', 'Edicion PC', 'Se edito la pc DGS-PC-RRHH-034'),
(412, 55440384, '2023-02-23 12:50:42', 'Edicion PC', 'Se edito la pc DGS-PC-RRHH-034'),
(413, 55440384, '2023-02-23 12:50:45', 'Edicion PC', 'Se edito la pc DGS-PC-RRHH-034'),
(414, 55440384, '2023-02-23 13:21:21', 'Edicion de unidad ejecutora', 'Se edito la unidad DGS-Direccion General de Secretari'),
(415, 55440384, '2023-02-23 13:21:24', 'Edicion de unidad ejecutora', 'Se edito la unidad DGS-Direccion General de Secretaria'),
(416, 55440384, '2023-02-23 13:22:17', 'Edicion de Area', 'Se edito la area SIS-Sistemas ,Perteneciente a la UE 2'),
(417, 55440384, '2023-02-23 13:22:20', 'Edicion de Area', 'Se edito la area SIS-Sistemas ,Perteneciente a la UE 1'),
(418, 55440384, '2023-02-23 13:22:23', 'Edicion de Area', 'Se edito la area SIS-Sistemas ,Perteneciente a la UE 1'),
(419, 50833392, '2023-02-23 13:36:15', 'Edicion PC', 'Se edito la pc DGS-PC-OYS-001'),
(420, 50833392, '2023-02-23 13:40:04', 'Edicion PC', 'Se edito la pc DGS-PC-RRHH-034'),
(421, 55440384, '2023-02-27 13:03:17', 'Creacion de usuario', 'Se creo el usuario 123'),
(422, 55440384, '2023-02-27 13:06:22', 'Edicion de usuario', 'Se edito el usuario nicolas.perez'),
(423, 55440384, '2023-02-27 13:07:01', 'Edicion de usuario', 'Se edito el usuario nicolas.perez'),
(424, 55440384, '2023-02-27 13:07:18', 'Edicion de usuario', 'Se edito el usuario nicolas.perez'),
(425, 55440384, '2023-02-27 13:07:56', 'Edicion de usuario', 'Se edito el usuario nicolas.perez'),
(426, 55440384, '2023-02-27 13:30:19', 'Edicion de usuario', 'Se edito el usuario nicolas.perez'),
(427, 55440384, '2023-02-27 14:32:22', 'Edicion de usuario', 'Se edito el usuario bruno.alvezdacruz'),
(428, 55440384, '2023-02-27 14:34:22', 'Edicion de usuario', 'Se edito el usuario bruno.alvezdacruz'),
(429, 50921456, '2023-02-28 13:15:40', 'Edicion de PC', 'Se modifico el PC DGS-PC-AUTC-006'),
(430, 50921456, '2023-02-28 13:17:46', 'Eliminar PC', 'Se elimino el PC DGS-PC-AUTC-005'),
(431, 50921456, '2023-02-28 14:04:07', 'Edicion de PC', 'Se modifico el PC DGS-PC-AUTC-006'),
(432, 56347325, '2023-03-01 16:49:20', 'Creacion de unidad ejecutora', 'Se creo el area CIOP-Centro de Info, Perteneciente a DGS'),
(433, 56347325, '2023-03-01 16:52:46', 'Registro PC', 'Se registro la pc DGS-PC-CIOP-003'),
(434, 56347325, '2023-03-01 16:53:34', 'Registro PC', 'Se registro la pc DGS-PC-CIOP-004'),
(435, 56347325, '2023-03-01 16:53:53', 'Edicion de PC', 'Se modifico el PC DGS-PC-CIOP-003'),
(436, 56347325, '2023-03-01 16:54:23', 'Eliminar PC', 'Se elimino el PC DGS-PC-CIOP-003'),
(437, 56347325, '2023-03-03 12:52:40', 'Edicion PC', 'Se edito la pc DGS-PC-CIOP-004'),
(438, 56347325, '2023-03-03 12:52:55', 'Edicion PC', 'Se edito la pc DGS-PC-CIOP-004'),
(439, 56347325, '2023-03-03 12:56:02', 'Registro PC', 'Se registro la pc DGS-PC-CDIG-003'),
(440, 56347325, '2023-03-03 13:03:57', 'Registro PC', 'Se registro la pc DGS-PC-CIOP-002'),
(441, 56347325, '2023-03-03 13:10:08', 'Edicion PC', 'Se edito la pc DGS-PC-CIOP-001'),
(442, 50921456, '2023-03-09 12:32:04', 'Creacion de unidad ejecutora', 'Se creo el area RRHH-Servicio Medico, Perteneciente a DGS'),
(443, 50921456, '2023-03-09 12:34:51', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-016'),
(444, 50921456, '2023-03-09 12:35:57', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-019'),
(445, 50921456, '2023-03-09 12:41:19', 'Edicion de PC', 'Se modifico el PC DGS-PC-RRHH-023'),
(446, 50921456, '2023-03-09 12:42:28', 'Eliminar PC', 'Se elimino el PC DGS-PC-RRHH-016'),
(447, 50921456, '2023-03-09 12:43:22', 'Edicion de PC', 'Se modifico el PC DGS-PC-RRHH-023'),
(448, 50921456, '2023-03-09 13:44:32', 'Creacion de unidad ejecutora', 'Se creo el area RRHH-Liquidacion de Haberes, Perteneciente a DGS'),
(449, 50921456, '2023-03-09 13:51:46', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-099'),
(450, 50921456, '2023-03-10 11:58:52', 'Edicion PC', 'Se edito la pc DGS-PC-RRHH-027'),
(451, 55440384, '2023-03-15 19:46:31', 'Edicion PC', 'Se edito la pc Prueba'),
(452, 55440384, '2023-03-15 20:11:08', 'Baja PC', 'Se dio de baja la PC de id: 23'),
(453, 55440384, '2023-03-15 20:13:04', 'Edicion PC', 'Se edito la pc DGS-PC-OYS-001'),
(454, 55440384, '2023-03-15 20:13:06', 'Baja PC', 'Se dio de baja la PC de id: 72'),
(455, 55440384, '2023-03-15 21:00:36', 'Creacion de unidad ejecutora', 'Se creo la unidad FDS-df'),
(456, 55440384, '2023-03-15 21:00:48', 'Creacion de Area', 'Se creo la area KJHKJH-jhkjh ,Perteneciente a la UE 3'),
(457, 55440384, '2023-03-15 21:00:53', 'Creacion de Area', 'Se creo la area KJHKJH-kjhkjh ,Perteneciente a la UE 3'),
(458, 55440384, '2023-03-15 21:00:58', 'Creacion de Area', 'Se creo la area JHKJH-kjhk ,Perteneciente a la UE 3'),
(459, 55440384, '2023-03-15 21:23:13', 'Creacion de unidad ejecutora', 'Se creo la unidad O-pok'),
(460, 55440384, '2023-03-22 20:20:02', 'Baja PC', 'Se dio de baja la PC de id: 23'),
(461, 55440384, '2023-03-22 20:20:03', 'Baja PC', 'Se dio de baja la PC de id: 23'),
(462, 55440384, '2023-03-22 20:20:04', 'Baja PC', 'Se dio de baja la PC de id: 23'),
(463, 55440384, '2023-03-22 20:20:04', 'Baja PC', 'Se dio de baja la PC de id: 23'),
(464, 55440384, '2023-03-22 20:20:04', 'Baja PC', 'Se dio de baja la PC de id: 23'),
(465, 55440384, '2023-03-22 20:35:52', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 23'),
(466, 55440384, '2023-03-22 20:37:13', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 72'),
(467, 55440384, '2023-03-22 20:37:24', 'Baja PC', 'Se dio de baja la PC de id: 73'),
(468, 55440384, '2023-03-22 20:37:26', 'Baja PC', 'Se dio de baja la PC de id: 74'),
(469, 55440384, '2023-03-22 20:37:28', 'Baja PC', 'Se dio de baja la PC de id: 75'),
(470, 55440384, '2023-03-22 20:37:29', 'Baja PC', 'Se dio de baja la PC de id: 76'),
(471, 55440384, '2023-03-22 20:37:32', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 73'),
(472, 55440384, '2023-03-22 20:37:36', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 74'),
(473, 55440384, '2023-03-22 20:37:39', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 75'),
(474, 55440384, '2023-03-22 20:37:44', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 76'),
(475, 55440384, '2023-03-23 15:19:47', 'Baja PC', 'Se dio de baja la PC de id: 1'),
(476, 55440384, '2023-03-23 15:20:55', 'Alta PC', 'Se dio de alta la PC de id: 1'),
(477, 55440384, '2023-03-23 15:38:05', 'Registro PC', 'Se registro la pc DGS-PC-SIS-003'),
(478, 55440384, '2023-03-23 15:43:15', 'Baja PC', 'Se dio de baja la PC de id: 84'),
(479, 55440384, '2023-03-23 15:43:20', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 84'),
(480, 55440384, '2023-03-23 15:59:57', 'Registro PC', 'Se registro la pc DGS-PC-SIS-003'),
(481, 55440384, '2023-03-23 16:00:21', 'Registro PC', 'Se registro la pc DGS-PC-RRHH-016'),
(482, 55440384, '2023-03-23 16:00:59', 'Baja PC', 'Se dio de baja la PC de id: 85'),
(483, 55440384, '2023-03-23 16:01:00', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 85'),
(484, 55440384, '2023-03-23 16:01:04', 'Baja PC', 'Se dio de baja la PC de id: 86'),
(485, 55440384, '2023-03-23 16:01:05', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 86'),
(486, 55440384, '2023-03-23 16:10:20', 'Registro PC', 'Se registro la pc DGS-PC-SIS-003'),
(487, 55440384, '2023-03-23 16:10:50', 'Edicion PC', 'Se edito la pc DGS-PC-SIS-003'),
(488, 55440384, '2023-03-23 16:10:56', 'Edicion PC', 'Se edito la pc DGS-PC-SIS-003'),
(489, 55440384, '2023-03-23 16:11:11', 'Baja PC', 'Se dio de baja la PC de id: 87'),
(490, 55440384, '2023-03-23 16:11:13', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 87'),
(491, 55440384, '2023-03-23 16:11:34', 'Creacion de usuario', 'Se creo el usuario prueba'),
(492, 55440384, '2023-03-23 16:11:42', 'Edicion de usuario', 'Se edito el usuario '),
(493, 55440384, '2023-03-23 16:12:25', 'Edicion de usuario', 'Se edito el usuario '),
(494, 55440384, '2023-03-23 16:12:46', 'Edicion de usuario', 'Se edito el usuario '),
(495, 55440384, '2023-03-23 16:12:50', 'Edicion de usuario', 'Se edito el usuario '),
(496, 55440384, '2023-03-23 16:13:03', 'Edicion de usuario', 'Se edito el usuario '),
(497, 55440384, '2023-03-23 16:13:15', 'Edicion de usuario', 'Se edito el usuario '),
(498, 55440384, '2023-03-23 16:13:17', 'Edicion de usuario', 'Se edito el usuario '),
(499, 50833392, '2023-03-23 16:21:58', 'Edicion de usuario', 'Se edito el usuario 2'),
(500, 50833392, '2023-03-23 16:23:24', 'Creacion de unidad ejecutora', 'Se creo la unidad PRU-Prueba'),
(501, 50833392, '2023-03-23 16:25:46', 'Registro PC', 'Se registro la pc DGS-PC-SIS-003'),
(502, 50833392, '2023-03-23 16:26:16', 'Registro PC', 'Se registro la pc DGS-PRT-SIS-001'),
(503, 55440384, '2023-03-24 17:13:26', 'Registro PC', 'Se registro la pc DGS-PC-SIS-004'),
(504, 55440384, '2023-03-24 17:13:39', 'Registro PC', 'Se registro la pc DGS-PC-SIS-005'),
(505, 55440384, '2023-03-24 17:15:17', 'Edicion de usuario', 'Se edito el usuario 20'),
(506, 55440384, '2023-03-24 17:46:47', 'Edicion de usuario', 'Se edito el usuario 20'),
(507, 55440384, '2023-03-24 17:46:50', 'Edicion de usuario', 'Se edito el usuario 20i'),
(508, 55440384, '2023-03-24 17:50:18', 'Edicion de usuario', 'Se edito el usuario uyguyguyguyg'),
(509, 55440384, '2023-03-24 17:50:29', 'Edicion de usuario', 'Se edito el usuario iuyiu'),
(510, 55440384, '2023-03-24 17:50:32', 'Edicion de usuario', 'Se edito el usuario '),
(511, 55440384, '2023-03-24 18:01:44', 'Edicion de usuario', 'Se edito el usuario '),
(512, 55440384, '2023-03-24 18:01:49', 'Edicion de usuario', 'Se edito el usuario '),
(513, 55440384, '2023-03-24 18:01:52', 'Edicion de usuario', 'Se edito el usuario 8'),
(514, 55440384, '2023-03-24 18:41:57', 'Edicion de usuario', 'Se edito el usuario 8'),
(515, 55440384, '2023-03-24 18:41:58', 'Edicion de usuario', 'Se edito el usuario 8'),
(516, 55440384, '2023-03-24 18:42:43', 'Edicion de usuario', 'Se edito el usuario 8'),
(517, 55440384, '2023-03-24 18:43:18', 'Edicion de usuario', 'Se edito el usuario 8'),
(518, 55440384, '2023-03-24 18:43:22', 'Edicion de usuario', 'Se edito el usuario 8'),
(519, 55440384, '2023-03-24 18:44:16', 'Edicion de usuario', 'Se edito el usuario 987897'),
(520, 55440384, '2023-03-24 18:47:56', 'Edicion de usuario', 'Se edito el usuario 987897'),
(521, 55440384, '2023-03-24 18:49:01', 'Edicion de usuario', 'Se edito el usuario 987897'),
(522, 55440384, '2023-03-24 18:49:07', 'Edicion de usuario', 'Se edito el usuario 987897'),
(523, 55440384, '2023-03-24 18:52:06', 'Edicion de usuario', 'Se edito el usuario uyguyguyguyg'),
(524, 55440384, '2023-03-24 19:11:53', 'Edicion de usuario', 'Se edito el usuario uyguyguyguyg'),
(525, 55440384, '2023-03-24 19:11:56', 'Edicion de usuario', 'Se edito el usuario uyguyguyguyg'),
(526, 55440384, '2023-03-24 19:54:15', 'Creacion de Area', 'Se creo la area 78-897 ,Perteneciente a la UE 2'),
(527, 55440384, '2023-03-24 19:54:33', 'Creacion de Area', 'Se creo la area 987-987 ,Perteneciente a la UE 2'),
(528, 55440384, '2023-03-24 19:54:43', 'Creacion de Area', 'Se creo la area 777-876 ,Perteneciente a la UE 1'),
(529, 55440384, '2023-03-24 19:54:48', 'Creacion de Area', 'Se creo la area 87-87 ,Perteneciente a la UE 2'),
(530, 55440384, '2023-03-24 20:21:56', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 27'),
(531, 55440384, '2023-03-24 20:22:24', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 26'),
(532, 55440384, '2023-03-24 20:25:53', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 25'),
(533, 55440384, '2023-03-24 20:31:41', 'Baja PC', 'Se dio de baja la PC de id: 88'),
(534, 55440384, '2023-03-24 20:31:43', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 88'),
(535, 55440384, '2023-03-24 20:37:08', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 24'),
(536, 55440384, '2023-03-24 20:37:46', 'Creacion de Area', 'Se creo la area PTB-prueba ,Perteneciente a la UE 1'),
(537, 55440384, '2023-03-24 20:37:52', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 28'),
(538, 55440384, '2023-03-24 20:43:59', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 999'),
(539, 55440384, '2023-03-24 20:44:12', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 999'),
(540, 55440384, '2023-03-24 20:44:25', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 999'),
(541, 55440384, '2023-03-24 20:46:39', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 999'),
(542, 55440384, '2023-03-24 20:46:55', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 2'),
(543, 55440384, '2023-03-24 20:47:32', 'Creacion de unidad ejecutora', 'Se creo la unidad HGF-tyhf'),
(544, 55440384, '2023-03-24 20:47:36', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 76'),
(545, 55440384, '2023-03-24 20:49:08', 'Creacion de unidad ejecutora', 'Se creo la unidad EDU-Educacion'),
(546, 55440384, '2023-03-24 20:49:16', 'Creacion de unidad ejecutora', 'Se creo la unidad PRB-prueba'),
(547, 55440384, '2023-03-24 20:49:20', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 3'),
(548, 55440384, '2023-03-24 20:52:36', 'Creacion de unidad ejecutora', 'Se creo la unidad PRB-prb'),
(549, 55440384, '2023-03-24 20:52:43', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 3'),
(550, 55440384, '2023-03-24 21:11:40', 'Creacion de unidad ejecutora', 'Se creo la unidad PRUEBA-prueba'),
(551, 55440384, '2023-03-24 21:12:01', 'Creacion de Area', 'Se creo la area PRUEBA-prueba ,Perteneciente a la UE 9'),
(552, 55440384, '2023-03-24 21:23:58', 'Registro PC', 'Se registro la pc PRUEBA-PC-PRUEBA-001'),
(553, 55440384, '2023-03-24 21:24:08', 'Baja PC', 'Se dio de baja la PC de id: 92'),
(554, 55440384, '2023-03-24 21:24:45', 'Baja PC', 'Se dio de baja la PC de id: 91'),
(555, 55440384, '2023-03-24 21:24:47', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 91'),
(556, 55440384, '2023-03-24 21:25:35', 'Baja PC', 'Se dio de baja la PC de id: 90'),
(557, 55440384, '2023-03-24 21:25:41', 'Baja PC', 'Se dio de baja la PC de id: 89'),
(558, 55440384, '2023-03-24 21:25:43', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 89'),
(559, 55440384, '2023-03-24 21:25:47', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 90'),
(560, 55440384, '2023-03-24 21:25:51', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 92'),
(561, 55440384, '2023-03-24 21:26:03', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 29'),
(562, 55440384, '2023-03-24 21:26:07', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 9'),
(563, 55440384, '2023-03-24 21:29:43', 'Creacion de unidad ejecutora', 'Se creo la unidad PRUEBA-Prueba'),
(564, 55440384, '2023-03-24 21:29:50', 'Creacion de Area', 'Se creo la area PRUEBA-Prueba ,Perteneciente a la UE 9'),
(565, 55440384, '2023-03-24 21:34:10', 'Registro PC', 'Se registro la pc Prueba'),
(566, 55440384, '2023-03-24 21:34:39', 'Edicion PC', 'Se edito la pc PRUEBA-PC-PRUEBA-001'),
(567, 55440384, '2023-03-24 21:34:41', 'Baja PC', 'Se dio de baja la PC de id: 93'),
(568, 55440384, '2023-03-24 21:34:42', 'Eliminacion PC', 'Se elimino definitivamente la PC de id: 93'),
(569, 55440384, '2023-03-24 21:34:48', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 30'),
(570, 55440384, '2023-03-24 21:34:53', 'Eliminacion UE', 'Se elimino definitivamente la UE de id: 9'),
(571, 50833392, '2023-03-27 15:00:51', 'Registro PC', 'Se registro la pc DGS-PC-ASCL-002'),
(572, 50921456, '2023-03-27 15:14:43', 'Edicion de PC', 'Se modifico el PC DGS-PC-ASCL-002'),
(573, 50921456, '2023-03-29 11:42:32', 'Registro PC', 'Se registro la pc DGS-PC-ASCL-003'),
(574, 50921456, '2023-03-29 11:49:37', 'Edicion de PC', 'Se modifico el PC DGS-PC-ASCL-004'),
(575, 50921456, '2023-03-29 15:45:11', 'Creacion de unidad ejecutora', 'Se creo el area ASCL-Registro de Instituciones Culturales y de Enseñanza, Perteneciente a DGS'),
(576, 50921456, '2023-03-29 15:51:28', 'Registro PC', 'Se registro la pc DGS-PC-ASCL-005'),
(577, 50921456, '2023-03-29 15:56:14', 'Registro PC', 'Se registro la pc DGS-PC-ASCL-006'),
(578, 50921456, '2023-03-29 16:15:25', 'Registro PC', 'Se registro la pc DGS-PC-ASCL-007'),
(579, 50921456, '2023-03-30 11:49:02', 'Registro PC', 'Se registro la pc DGS-PC-ASCL-008'),
(580, 50921456, '2023-03-30 11:54:08', 'Registro PC', 'Se registro la pc DGS-PC-ASCL-009'),
(581, 55440384, '2023-05-06 00:09:56', 'Edicion de usuario', 'Se edito el usuario lucas.marsiglia'),
(582, 55440384, '2023-05-06 15:18:27', 'Edicion de usuario', 'Se edito el usuario lucas.marsiglia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnico`
--

CREATE TABLE `tecnico` (
  `CI` int(11) NOT NULL,
  `Mail` varchar(64) DEFAULT NULL,
  `Nombre` varchar(30) DEFAULT NULL,
  `Apellido` varchar(30) DEFAULT NULL,
  `Usuario` varchar(30) DEFAULT NULL,
  `Pass` varchar(256) DEFAULT NULL,
  `Permisos` int(11) NOT NULL,
  `PassDefault` tinyint(1) NOT NULL DEFAULT 1,
  `FechaCreacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tecnico`
--

INSERT INTO `tecnico` (`CI`, `Mail`, `Nombre`, `Apellido`, `Usuario`, `Pass`, `Permisos`, `PassDefault`, `FechaCreacion`) VALUES
(12340, 'hfhgfhgfhgfhgf', '1234', '1232', 'uyguyguyguyg', '$2y$10$/PNPxwtnL3.YCsJ9SQVHdOYmuOstcRu4mjWL89H9hSyjw70RKl9Ai', 0, 1, '2023-02-27 13:03:17'),
(98798, 'oiuiou', '98798', '987987', '987897', '$2y$10$2h8OOQEIZZ5Q55YBwxFtkO1Dj3xXtcn9sAvzP2CDasS84/Y1AyAbO', 0, 1, '2023-03-23 16:11:34'),
(19145380, 'pereiran@mec.gub.uy', 'Nelson', 'Pereira', 'pereiran', '$2y$10$8rBvU6.6Gms53E33Ex9qqO/cPDYoZqT0uRQIo3XTHG83humgycKAO', 2, 0, '2023-02-15 14:43:05'),
(27157490, 'barros@mec.gub.uy', 'Natalia', 'Barros', 'barros', '$2y$10$nrOVmOJr8Xz7YmFddPG/HubWXAQSIb54RfUw3Nu3HHRPHDPqWNpii', 2, 0, '2023-02-16 15:26:18'),
(50833392, 'christian.lessa@mec.gub.uy', 'Christian', 'Lessa', 'christian.lessa', '$2y$10$6lXLBhznDWBfZ7VPs1gpQeBPgBLp9Bfo2KnX29mWvQzHjyHwOCIg2', 2, 0, '2023-02-22 17:01:56'),
(50921456, ' nicolas.perez@mec.gub.uy', 'Nicolas', 'Pereza', 'nicolas.perez', '$2y$10$BEozd9TKR8GpOCzuCAt0A.5IN/uY/sVdNRbeVBGmu5j0kBe.iJ.v.', 2, 0, '2023-02-14 15:04:12'),
(52030716, 'daniel.nalotto@mec.gub.uy', 'Daniel', 'Nalotto', 'daniel.nalotto', '$2y$10$Wquba/8ZnfhmJ4htNZTcVuaZWQbMZmGgIZJlZK4vBeptnh2wcHCd2', 2, 1, '2023-02-17 16:39:36'),
(54591102, 'wilson.rodriguez@mec.gub.uy', 'Wilson', 'Rodriguez', 'wilson.rodriguez', '$2y$10$.G9.ZUNq7qwclP5it9rXD.p3DbRjcqMVEFrlcz.R/OhHo/NzxeNJG', 2, 1, '2023-02-14 14:44:56'),
(55440384, ' lucas.marsiglia@mec.gub.uy', 'Lucas', 'Marsiglia', 'lucas.marsiglia', '$2y$10$W5gYoedXLc0oexjI1I3kT.EuFSivV8DV/KoTFLw/4f9/3FkjiiCA2', 2, 0, '2023-02-14 14:38:09'),
(56347325, 'bruno.alvezdacruz@mec.gub.uy', 'Bruno', 'Alvez da Cruz', 'bruno.alvezdacruz', '$2y$10$7/4qALjqmtiH7XJ9ZDmg2eJcbZfkWoPb70kWOPBe20VFsOvYVgKje', 2, 0, '2023-01-26 16:48:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ue`
--

CREATE TABLE `ue` (
  `ID` int(11) NOT NULL,
  `Nombre` text NOT NULL,
  `Nomenclatura` varchar(10) DEFAULT NULL,
  `bajaLogica` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ue`
--

INSERT INTO `ue` (`ID`, `Nombre`, `Nomenclatura`, `bajaLogica`) VALUES
(1, 'Direccion General de Secretaria', 'DGS', 0),
(2, 'Educacion', 'EDU', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IdUE` (`IdUE`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`ID`,`IdArea`,`CiTecnico`),
  ADD KEY `IdArea` (`IdArea`),
  ADD KEY `CiTecnico` (`CiTecnico`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ci` (`CiUsuario`);

--
-- Indices de la tabla `tecnico`
--
ALTER TABLE `tecnico`
  ADD PRIMARY KEY (`CI`),
  ADD UNIQUE KEY `mail` (`Mail`),
  ADD UNIQUE KEY `Usuario` (`Usuario`);

--
-- Indices de la tabla `ue`
--
ALTER TABLE `ue`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=583;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `area_ibfk_1` FOREIGN KEY (`IdUE`) REFERENCES `ue` (`ID`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD CONSTRAINT `equipo_ibfk_1` FOREIGN KEY (`IdArea`) REFERENCES `area` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `equipo_ibfk_2` FOREIGN KEY (`CiTecnico`) REFERENCES `tecnico` (`CI`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `ci` FOREIGN KEY (`CiUsuario`) REFERENCES `tecnico` (`CI`);
--
-- Base de datos: `lista_personas`
--
CREATE DATABASE IF NOT EXISTS `lista_personas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `lista_personas`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atributos`
--

CREATE TABLE `atributos` (
  `id` int(11) NOT NULL,
  `dato` varchar(64) NOT NULL,
  `valor` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(64) DEFAULT NULL,
  `apellido` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `atributos`
--
ALTER TABLE `atributos`
  ADD PRIMARY KEY (`id`,`dato`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `atributos`
--
ALTER TABLE `atributos`
  ADD CONSTRAINT `Foreign key id` FOREIGN KEY (`id`) REFERENCES `personas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Base de datos: `microcms`
--
CREATE DATABASE IF NOT EXISTS `microcms` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `microcms`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `excerpt` text NOT NULL,
  `content` text NOT NULL,
  `published_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`id`, `title`, `excerpt`, `content`, `published_on`) VALUES
(1, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae pulvinar turpis', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae pulvinar turpis. Nam ut arcu tellus. Morbi sit amet elit lacinia, tincidunt leo a, posuere mi. Mauris nec odio at quam lacinia consequat. Fusce mattis orci ex, eget accumsan neque vehicula et. Vivamus consectetur tempor lacus, in tincidunt massa rutrum ut. Pellentesque augue felis, iaculis eu interdum et, semper eu purus. Vestibulum a viverra justo.', '2018-10-11 10:15:00'),
(2, 'Nunc eget enim vulputate', 'Integer placerat hendrerit pharetra. Nunc eget enim vulputate, efficitur dolor pretium', 'Integer placerat hendrerit pharetra. Nunc eget enim vulputate, efficitur dolor pretium, pharetra nulla. Proin mattis aliquam sem. Morbi vel mi ac magna consequat tempus vitae eget diam. Aliquam ac sapien a tortor rutrum faucibus nec nec urna. Ut et nisl magna. Vivamus elit risus, rhoncus vitae elit suscipit, porta pulvinar justo. Aliquam sodales urna eu scelerisque ultrices. Fusce et neque id risus gravida vestibulum a et urna. Curabitur aliquam accumsan leo, pharetra tempus velit condimentum et. Donec dapibus faucibus lorem a tincidunt. Donec ultricies id metus et aliquam. Vestibulum dapibus magna nec elit ultrices, ornare pretium nisi dictum.', '2018-10-11 10:15:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Base de datos: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Volcado de datos para la tabla `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"prueba\",\"table\":\"tareas\"}]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Volcado de datos para la tabla `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2022-09-07 00:39:24', '{\"Console\\/Mode\":\"collapse\",\"lang\":\"es\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indices de la tabla `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indices de la tabla `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indices de la tabla `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indices de la tabla `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indices de la tabla `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indices de la tabla `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indices de la tabla `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indices de la tabla `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indices de la tabla `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indices de la tabla `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indices de la tabla `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indices de la tabla `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indices de la tabla `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Base de datos: `prueba`
--
CREATE DATABASE IF NOT EXISTS `prueba` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `prueba`;
--
-- Base de datos: `surno`
--
CREATE DATABASE IF NOT EXISTS `surno` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `surno`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacenes`
--

CREATE TABLE `almacenes` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `direccion` varchar(128) NOT NULL,
  `baja` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacenes`
--

INSERT INTO `almacenes` (`ID`, `nombre`, `direccion`, `baja`) VALUES
(1, 'Almacén 1', 'Calle A 123', b'0'),
(2, 'Almacén 2', 'Calle B 456', b'0'),
(3, 'Almacén 3', 'Calle C 789', b'0'),
(4, 'Almacén 4', 'Calle D 101', b'0'),
(5, 'Almacén 5', 'Calle E 202', b'0'),
(6, 'Almacén 6', 'Calle F 303', b'0'),
(7, 'Almacén 7', 'Calle G 404', b'0'),
(8, 'Almacén 8', 'Calle H 505', b'0'),
(9, 'Almacén 9', 'Calle I 606', b'0'),
(10, 'Almacén 10', 'Calle J 707', b'0'),
(11, 'Almacén 11', 'Calle K 808', b'0'),
(12, 'Almacén 12', 'Calle L 909', b'0'),
(13, 'Almacén 13', 'Calle M 010', b'0'),
(14, 'Almacén 14', 'Calle N 111', b'0'),
(15, 'Almacén 15', 'Calle O 212', b'0'),
(16, 'Almacén 16', 'Calle P 313', b'0'),
(17, 'Almacén 17', 'Calle Q 414', b'0'),
(18, 'Almacén 18', 'Calle R 515', b'0'),
(19, 'Almacén 19', 'Calle S 616', b'0'),
(20, 'Almacén 20', 'Calle T 717', b'0'),
(21, 'Almacén 21', 'Calle U 515', b'0'),
(22, 'Almacén 22', 'Calle V 616', b'0'),
(23, 'Almacén 23', 'Calle X 717', b'0'),
(24, 'Almacén 24', 'Calle Y 717', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacenes_clientes`
--

CREATE TABLE `almacenes_clientes` (
  `ID` int(11) NOT NULL,
  `RUT` char(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacenes_clientes`
--

INSERT INTO `almacenes_clientes` (`ID`, `RUT`) VALUES
(16, '213456789012'),
(17, '213456789012'),
(18, '213456789012'),
(20, '456789123012'),
(19, '987654321012');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacenes_propios`
--

CREATE TABLE `almacenes_propios` (
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacenes_propios`
--

INSERT INTO `almacenes_propios` (`ID`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(21),
(22),
(23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camioneros`
--

CREATE TABLE `camioneros` (
  `CI` char(8) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `apellido` varchar(32) NOT NULL,
  `baja` bit(1) NOT NULL DEFAULT b'0'
) ;

--
-- Volcado de datos para la tabla `camioneros`
--

INSERT INTO `camioneros` (`CI`, `nombre`, `apellido`, `baja`) VALUES
('12341234', 'Alejandro', 'Gonzale', b'0'),
('12345678', 'Juan', 'Perez', b'0'),
('23452345', 'Isabel', 'Lopez', b'0'),
('23456789', 'Maria', 'Gomez', b'0'),
('32109875', 'Javier', 'Luna', b'0'),
('32109876', 'Luis', 'Mendoza', b'0'),
('34563456', 'Pablo', 'Fernandez', b'0'),
('34567890', 'Pedro', 'Lopez', b'0'),
('43210986', 'Sofia', 'Guerrero', b'0'),
('43210987', 'Carmen', 'Sanchez', b'0'),
('45674567', 'Carolina', 'Gomez', b'0'),
('45678901', 'Ana', 'Martinez', b'0'),
('54321086', 'Diego', 'Paredes', b'0'),
('54321087', 'Fernando', 'Torres', b'0'),
('54321098', 'Andres', 'Ramirez', b'0'),
('56789012', 'Carlos', 'Rodriguez', b'0'),
('65432107', 'Valentina', 'Cabrera', b'0'),
('65432108', 'Maria', 'Jimenez', b'0'),
('65432109', 'Eva', 'Vargas', b'0'),
('67890123', 'Laura', 'Hernandez', b'0'),
('77777777', '876876', '876876', b'0'),
('98798798', '98787', '987', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camiones`
--

CREATE TABLE `camiones` (
  `matricula` char(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camiones`
--

INSERT INTO `camiones` (`matricula`) VALUES
('ABC1234'),
('DEF5678'),
('eee1111'),
('GHI9012'),
('JKL3456'),
('MNO7890'),
('PQR1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camionetas`
--

CREATE TABLE `camionetas` (
  `matricula` char(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camionetas`
--

INSERT INTO `camionetas` (`matricula`) VALUES
('ABD2399'),
('BCD7890'),
('CDE3450'),
('EFG1234'),
('FGH6789'),
('HIJ5678'),
('jua1234'),
('KLM9012'),
('NOP3456'),
('QRS7890'),
('STU5678'),
('TUV1234'),
('VWX9012'),
('WXY3367'),
('YZA3456');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `RUT` char(12) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `baja` bit(1) NOT NULL DEFAULT b'0'
) ;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`RUT`, `nombre`, `baja`) VALUES
('213456789012', 'Crecom', b'0'),
('456789123012', 'SuperTienda', b'1'),
('987654321012', 'EcoShop', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conducen`
--

CREATE TABLE `conducen` (
  `CI` char(8) NOT NULL,
  `matricula` char(7) NOT NULL,
  `desde` timestamp NOT NULL DEFAULT current_timestamp(),
  `hasta` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `conducen`
--

INSERT INTO `conducen` (`CI`, `matricula`, `desde`, `hasta`) VALUES
('12341234', 'STU5678', '2023-04-27 17:01:26', '2023-05-31 15:48:25'),
('12341234', 'STU5678', '2023-08-08 06:48:25', '2023-08-25 06:48:25'),
('12345678', 'ABC1234', '2023-04-05 17:01:26', '2023-06-13 17:01:26'),
('12345678', 'ABC1234', '2023-09-05 17:01:26', '2023-09-13 17:01:26'),
('12345678', 'DEF5678', '2023-09-14 16:17:29', '2023-09-15 16:17:29'),
('23452345', 'VWX9012', '2023-08-30 23:53:28', '2023-08-30 23:53:28'),
('23456789', 'ABC1234', '2023-09-14 17:01:26', '2023-09-15 17:01:26'),
('23456789', 'DEF5678', '2023-04-24 16:17:29', '2023-06-29 16:17:29'),
('23456789', 'DEF5678', '2023-07-24 16:17:29', '2023-08-29 16:17:29'),
('32109875', 'CDE3450', '2023-08-04 01:05:06', NULL),
('32109876', 'QRS7890', '2023-08-05 21:07:43', NULL),
('34563456', 'GHI9012', '2023-09-01 21:12:12', '2023-09-12 21:12:12'),
('34563456', 'YZA3456', '2023-07-26 15:11:12', '2023-08-26 15:11:12'),
('34567890', 'GHI9012', '2023-07-29 21:12:12', '2023-09-01 21:12:12'),
('34567890', 'YZA3456', '2023-09-03 15:11:12', NULL),
('43210986', 'ABD2399', '2023-09-11 15:41:15', NULL),
('43210987', 'NOP3456', '2023-08-11 05:40:35', NULL),
('45674567', 'BCD7890', '2023-08-18 08:18:24', NULL),
('45678901', 'JKL3456', '2023-08-27 09:03:14', '2023-09-15 09:03:14'),
('54321086', 'WXY3367', '2023-09-11 09:43:39', NULL),
('54321087', 'KLM9012', '2023-07-24 03:18:07', NULL),
('54321098', 'EFG1234', '2023-08-09 08:05:36', NULL),
('56789012', 'MNO7890', '2023-08-26 19:18:09', '2023-09-01 19:18:09'),
('56789012', 'PQR1234', '2023-04-12 23:07:10', NULL),
('65432107', 'FGH6789', '2023-04-02 20:42:11', NULL),
('65432108', 'TUV1234', '2023-09-10 10:31:15', NULL),
('65432109', 'HIJ5678', '2023-08-14 02:16:22', NULL),
('67890123', 'MNO7890', '2023-09-01 20:18:09', NULL),
('67890123', 'PQR1234', '2023-08-12 23:07:10', '2023-08-27 23:07:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destino_lote`
--

CREATE TABLE `destino_lote` (
  `ID_lote` int(11) NOT NULL,
  `ID_almacen` int(11) NOT NULL,
  `ID_troncal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `destino_lote`
--

INSERT INTO `destino_lote` (`ID_lote`, `ID_almacen`, `ID_troncal`) VALUES
(4, 1, 6),
(5, 2, 1),
(6, 2, 1),
(1, 2, 4),
(9, 4, 5),
(7, 5, 2),
(10, 8, 4),
(3, 11, 1),
(2, 11, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lleva`
--

CREATE TABLE `lleva` (
  `ID_lote` int(11) NOT NULL,
  `matricula` char(7) DEFAULT NULL,
  `fecha_carga` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_descarga` timestamp NULL DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `lleva`
--

INSERT INTO `lleva` (`ID_lote`, `matricula`, `fecha_carga`, `fecha_descarga`) VALUES
(1, 'MNO7890', '2023-09-18 10:27:40', '2023-09-18 13:40:40'),
(2, 'PQR1234', '2023-09-18 15:45:40', NULL),
(3, 'DEF5678', '2023-05-12 10:15:35', '2023-05-12 14:23:40'),
(4, 'GHI9012', '2023-08-31 13:24:00', '2023-08-31 17:24:00'),
(5, 'PQR1234', '2023-08-06 17:23:08', NULL),
(6, 'MNO7890', '2023-09-10 13:29:22', '2023-09-10 18:07:42'),
(7, 'JKL3456', '2023-09-12 11:13:42', '2023-09-12 13:41:51'),
(9, 'DEF5678', '2023-08-06 13:13:07', '2023-08-06 18:05:07'),
(10, 'GHI9012', '2023-08-02 13:23:32', '2023-08-02 16:03:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes`
--

CREATE TABLE `lotes` (
  `ID` int(11) NOT NULL,
  `ID_troncal` int(11) NOT NULL,
  `ID_almacen` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_pronto` timestamp NULL DEFAULT NULL,
  `fecha_cerrado` timestamp NULL DEFAULT NULL,
  `tipo` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lotes`
--

INSERT INTO `lotes` (`ID`, `ID_troncal`, `ID_almacen`, `fecha_creacion`, `fecha_pronto`, `fecha_cerrado`, `tipo`) VALUES
(1, 4, 15, '2023-09-17 15:23:40', '2023-09-17 16:23:40', '2023-09-18 13:50:40', b'0'),
(2, 1, 2, '2023-09-18 13:45:40', '2023-09-18 14:20:40', NULL, b'0'),
(3, 1, 2, '2023-05-11 16:10:35', '2023-05-11 18:15:35', '2023-05-12 14:40:40', b'0'),
(4, 6, 9, '2023-08-29 17:26:35', '2023-08-29 21:24:00', '2023-08-31 18:24:00', b'0'),
(5, 5, 4, '2023-08-04 17:23:08', '2023-08-05 17:23:08', NULL, b'0'),
(6, 1, 14, '2023-09-04 18:32:42', '2023-09-07 14:45:49', '2023-09-10 18:32:42', b'0'),
(7, 1, 2, '2023-09-10 18:32:47', '2023-09-11 11:45:21', '2023-09-12 13:57:14', b'0'),
(8, 2, 5, '2023-09-12 13:57:14', NULL, NULL, b'1'),
(9, 5, 3, '2023-08-02 19:13:07', '2023-08-03 11:04:07', '2023-08-06 18:13:07', b'0'),
(10, 4, 15, '2023-07-30 19:12:07', '2023-07-31 12:23:31', '2023-08-02 16:23:42', b'0'),
(11, 4, 8, '2023-07-30 19:12:07', NULL, NULL, b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `ID_almacen` int(11) NOT NULL,
  `ID_troncal` int(11) NOT NULL,
  `orden` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`ID_almacen`, `ID_troncal`, `orden`) VALUES
(1, 2, 4),
(1, 3, 5),
(1, 5, 2),
(1, 6, 2),
(2, 1, 6),
(2, 4, 3),
(2, 5, 3),
(2, 6, 3),
(2, 7, 7),
(3, 2, 3),
(3, 3, 1),
(3, 4, 1),
(3, 5, 4),
(3, 6, 4),
(4, 5, 5),
(4, 7, 6),
(5, 2, 7),
(5, 5, 6),
(6, 1, 2),
(6, 2, 9),
(6, 3, 7),
(6, 5, 7),
(6, 7, 5),
(7, 2, 5),
(7, 3, 3),
(7, 4, 2),
(8, 2, 8),
(8, 4, 4),
(8, 7, 4),
(9, 1, 1),
(9, 2, 1),
(9, 5, 1),
(9, 6, 1),
(11, 1, 4),
(11, 2, 6),
(12, 1, 3),
(12, 2, 10),
(12, 3, 4),
(13, 2, 2),
(13, 3, 6),
(14, 1, 5),
(14, 3, 2),
(15, 4, 5),
(21, 7, 3),
(22, 7, 2),
(23, 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE `paquetes` (
  `ID` int(11) NOT NULL,
  `ID_almacen` int(11) NOT NULL,
  `fecha_registrado` timestamp NOT NULL DEFAULT current_timestamp(),
  `ID_pickup` int(11) NOT NULL,
  `direccion` varchar(128) DEFAULT NULL,
  `peso` int(10) UNSIGNED DEFAULT NULL,
  `volumen` int(10) UNSIGNED DEFAULT NULL,
  `fecha_entregado` timestamp NULL DEFAULT NULL,
  `mail` varchar(64) DEFAULT NULL,
  `cedula` varchar(8) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `paquetes`
--

INSERT INTO `paquetes` (`ID`, `ID_almacen`, `fecha_registrado`, `ID_pickup`, `direccion`, `peso`, `volumen`, `fecha_entregado`, `mail`, `cedula`) VALUES
(1, 16, '2023-09-15 10:37:40', 2, 'Calle 123, florida', 1000, 2000, NULL, 'correo1@example.com', NULL),
(2, 16, '2023-09-14 10:34:40', 11, 'Calle 456, punta del este', 1500, 2500, NULL, 'correo2@example.com', NULL),
(3, 16, '2023-09-15 02:32:40', 2, 'Calle 789, chuy', 1200, 2200, NULL, 'correo3@example.com', NULL),
(4, 16, '2023-08-26 19:28:20', 4, 'Calle 101, melo', 800, 1800, NULL, 'correo4@example.com', NULL),
(5, 16, '2023-05-04 08:25:35', 11, 'Calle 202, melo', 1400, 2400, '2023-05-12 17:22:00', 'correo5@example.com', '56789012'),
(6, 16, '2023-05-10 20:06:01', 11, 'Calle 404, melo', 1300, 2300, '2023-05-12 19:26:00', 'correo6@example.com', '78901234'),
(7, 16, '2023-08-27 21:22:58', 1, 'Calle 303, salto', 1100, 2100, '2023-09-01 17:01:00', 'correo7@example.com', '67890123'),
(8, 16, '2023-07-23 08:37:47', 8, 'Calle 505, canelones', 900, 1900, NULL, 'correo8@example.com', NULL),
(9, 16, '2023-09-11 04:38:22', 7, 'Calle 606, montevideo', 1600, 2600, NULL, 'correo9@example.com', NULL),
(10, 16, '2023-08-13 07:06:42', 12, 'Calle 707, montevideo', 700, 1700, '2023-08-16 15:54:42', 'correo10@example.com', '01234567'),
(11, 17, '2023-08-02 07:22:08', 14, 'Calle 808, colonia del sacramento', 1800, 2800, NULL, 'correo11@example.com', NULL),
(12, 18, '2023-08-29 14:42:52', 5, NULL, 1100, 2500, NULL, 'correo13@example.com', NULL),
(13, 18, '2023-09-05 13:42:49', 5, NULL, 1500, 2000, '2023-09-15 19:34:14', 'correo12@example.com', '22345669'),
(14, 18, '2023-07-30 08:22:07', 4, 'Calle 111, montevideo', 1400, 2100, '2023-08-01 08:22:07', 'correo14@example.com', '44567871'),
(15, 19, '2023-09-14 02:29:45', 5, 'Calle 212, montevideo', 900, 2400, NULL, 'correo15@example.com', NULL),
(16, 19, '2023-08-29 02:54:46', 7, 'Calle 313, montevideo', 1700, 1900, NULL, 'correo16@example.com', '66789073'),
(17, 20, '2023-07-29 22:17:39', 8, 'Calle 414, minas', 1200, 2700, NULL, 'correo17@example.com', NULL),
(18, 20, '2023-07-29 22:18:39', 8, NULL, 1200, 2200, NULL, 'correo18@example.com', NULL),
(19, 20, '2023-09-20 15:18:39', 14, 'Calle 413, florida', 1200, 2200, NULL, 'correo19@example.com', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes_lotes`
--

CREATE TABLE `paquetes_lotes` (
  `ID_paquete` int(11) NOT NULL,
  `ID_lote` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paquetes_lotes`
--

INSERT INTO `paquetes_lotes` (`ID_paquete`, `ID_lote`, `fecha`) VALUES
(1, 1, '2023-09-17 15:27:40'),
(2, 1, '2023-09-17 15:27:40'),
(2, 2, '2023-09-18 13:50:41'),
(3, 1, '2023-09-17 15:27:40'),
(5, 3, '2023-05-11 16:16:35'),
(6, 3, '2023-05-11 16:16:50'),
(7, 4, '2023-08-29 17:26:35'),
(11, 5, '2023-08-04 17:23:08'),
(12, 6, '2023-09-04 18:32:42'),
(12, 7, '2023-09-10 18:32:47'),
(12, 8, '2023-09-12 14:45:14'),
(13, 6, '2023-09-07 14:45:49'),
(13, 7, '2023-09-10 18:32:47'),
(13, 8, '2023-09-12 14:45:14'),
(14, 9, '2023-08-02 19:13:07'),
(17, 10, '2023-07-30 19:13:07'),
(18, 10, '2023-07-30 19:14:34'),
(18, 11, '2023-08-02 16:03:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reparte`
--

CREATE TABLE `reparte` (
  `ID_paquete` int(11) NOT NULL,
  `matricula` char(7) DEFAULT NULL,
  `fecha_carga` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_descarga` timestamp NULL DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `reparte`
--

INSERT INTO `reparte` (`ID_paquete`, `matricula`, `fecha_carga`, `fecha_descarga`) VALUES
(3, 'KLM9012', '2023-09-18 15:05:00', NULL),
(5, 'STU5678', '2023-05-12 15:56:00', '2023-05-12 17:22:00'),
(6, 'STU5678', '2023-05-12 15:47:00', '2023-05-12 19:26:00'),
(7, 'BCD7890', '2023-09-01 13:20:00', '2023-09-01 17:01:00'),
(10, 'QRS7890', '2023-08-16 12:54:42', '2023-08-16 15:54:42'),
(14, 'QRS7890', '2023-08-07 12:45:07', '2023-08-07 15:22:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trae`
--

CREATE TABLE `trae` (
  `ID_paquete` int(11) NOT NULL,
  `matricula` char(7) DEFAULT NULL,
  `fecha_carga` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_descarga` timestamp NULL DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `trae`
--

INSERT INTO `trae` (`ID_paquete`, `matricula`, `fecha_carga`, `fecha_descarga`) VALUES
(1, 'NOP3456', '2023-09-17 12:37:40', '2023-09-17 15:23:40'),
(2, 'NOP3456', '2023-09-17 12:38:40', '2023-09-17 15:24:40'),
(3, 'NOP3456', '2023-09-17 12:39:40', '2023-09-17 15:25:40'),
(4, 'DEF5678', '2023-08-27 13:48:20', NULL),
(5, 'ABC1234', '2023-05-11 11:25:35', '2023-05-11 16:15:35'),
(6, 'ABC1234', '2023-05-11 11:26:35', '2023-05-11 16:16:35'),
(7, 'QRS7890', '2023-08-29 11:47:00', '2023-08-29 13:17:00'),
(9, 'QRS7890', '2023-09-12 14:28:22', '2023-09-12 18:26:22'),
(10, 'CDE3450', '2023-08-14 11:56:42', '2023-08-14 15:54:42'),
(11, 'YZA3456', '2023-08-04 13:22:08', '2023-08-04 17:23:08'),
(12, 'EFG1234', '2023-09-03 14:56:52', '2023-09-04 18:32:42'),
(13, 'MNO7890', '2023-09-07 11:23:49', '2023-09-07 14:45:49'),
(14, 'GHI9012', '2023-08-02 15:22:07', '2023-08-02 19:13:07'),
(17, 'GHI9012', '2023-07-30 15:43:39', '2023-07-30 19:13:07'),
(18, 'GHI9012', '2023-07-30 15:44:45', '2023-07-30 19:14:34'),
(19, 'GHI9012', '2023-09-22 14:18:39', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `troncales`
--

CREATE TABLE `troncales` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `baja` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `troncales`
--

INSERT INTO `troncales` (`ID`, `nombre`, `baja`) VALUES
(1, 'Troncal 1', b'0'),
(2, 'Troncal 2', b'0'),
(3, 'Troncal 3', b'0'),
(4, 'Troncal 4', b'0'),
(5, 'Troncal 5', b'0'),
(6, 'Troncal 6', b'0'),
(7, 'Troncal 7', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` tinyint(4) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user`, `password`, `rol`, `remember_token`) VALUES
('prueba', '$2y$10$kFGjTv25JcZ5ZeOpLSQOguhN6rM/VZvdNP223G4Xh4sAfsNO1KTlq', 0, NULL),
('usuario1', 'contraseña1', 0, NULL),
('usuario10', 'contraseña10', 0, NULL),
('usuario11', 'contraseña11', 1, NULL),
('usuario12', 'contraseña12', 2, NULL),
('usuario13', 'contraseña13', 0, NULL),
('usuario14', 'contraseña14', 1, NULL),
('usuario15', 'contraseña15', 2, NULL),
('usuario16', 'contraseña16', 0, NULL),
('usuario17', 'contraseña17', 1, NULL),
('usuario18', 'contraseña18', 2, NULL),
('usuario19', 'contraseña19', 0, NULL),
('usuario2', 'contraseña2', 1, NULL),
('usuario20', 'contraseña20', 1, NULL),
('usuario3', 'contraseña3', 2, NULL),
('usuario4', 'contraseña4', 0, NULL),
('usuario5', 'contraseña5', 1, NULL),
('usuario6', 'contraseña6', 2, NULL),
('usuario7', 'contraseña7', 0, NULL),
('usuario8', 'contraseña8', 1, NULL),
('usuario9', 'contraseña9', 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `matricula` char(7) NOT NULL,
  `vol_max` int(10) UNSIGNED NOT NULL,
  `peso_max` int(10) UNSIGNED NOT NULL,
  `es_operativo` bit(1) NOT NULL DEFAULT b'1',
  `baja` bit(1) NOT NULL DEFAULT b'0'
) ;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`matricula`, `vol_max`, `peso_max`, `es_operativo`, `baja`) VALUES
('ABC1234', 500, 2009, b'0', b'0'),
('ABD2399', 550, 2000, b'1', b'0'),
('BCD7890', 600, 2100, b'0', b'1'),
('CDE3450', 500, 1900, b'1', b'0'),
('DEF5678', 700, 2500, b'1', b'0'),
('eee1111', 10, 10, b'1', b'0'),
('EFG1234', 550, 2000, b'1', b'0'),
('FGH6789', 450, 1800, b'1', b'1'),
('GHI9012', 600, 1800, b'1', b'1'),
('HIJ5678', 500, 1900, b'1', b'0'),
('JKL3456', 550, 2100, b'1', b'0'),
('jua1234', 10, 10, b'1', b'0'),
('KLM9012', 450, 1800, b'1', b'0'),
('MNO7890', 650, 2200, b'1', b'0'),
('NOP3456', 750, 500, b'1', b'0'),
('PQR1234', 450, 1900, b'1', b'0'),
('QRS7890', 800, 2700, b'1', b'0'),
('STU5678', 750, 2600, b'1', b'0'),
('TUV1234', 700, 2300, b'0', b'0'),
('VWX9012', 800, 2400, b'1', b'0'),
('WXY3367', 600, 2100, b'1', b'0'),
('YZA3456', 700, 2300, b'1', b'1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `almacenes_clientes`
--
ALTER TABLE `almacenes_clientes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `RUT` (`RUT`);

--
-- Indices de la tabla `almacenes_propios`
--
ALTER TABLE `almacenes_propios`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `camioneros`
--
ALTER TABLE `camioneros`
  ADD PRIMARY KEY (`CI`);

--
-- Indices de la tabla `camiones`
--
ALTER TABLE `camiones`
  ADD PRIMARY KEY (`matricula`);

--
-- Indices de la tabla `camionetas`
--
ALTER TABLE `camionetas`
  ADD PRIMARY KEY (`matricula`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`RUT`);

--
-- Indices de la tabla `conducen`
--
ALTER TABLE `conducen`
  ADD PRIMARY KEY (`CI`,`matricula`,`desde`),
  ADD KEY `matricula` (`matricula`);

--
-- Indices de la tabla `destino_lote`
--
ALTER TABLE `destino_lote`
  ADD PRIMARY KEY (`ID_lote`),
  ADD KEY `ID_almacen` (`ID_almacen`,`ID_troncal`);

--
-- Indices de la tabla `lleva`
--
ALTER TABLE `lleva`
  ADD PRIMARY KEY (`ID_lote`),
  ADD KEY `matricula` (`matricula`);

--
-- Indices de la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_almacen` (`ID_almacen`,`ID_troncal`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`ID_almacen`,`ID_troncal`),
  ADD KEY `ID_troncal` (`ID_troncal`);

--
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_almacen` (`ID_almacen`),
  ADD KEY `ID_pickup` (`ID_pickup`);

--
-- Indices de la tabla `paquetes_lotes`
--
ALTER TABLE `paquetes_lotes`
  ADD PRIMARY KEY (`ID_paquete`,`ID_lote`),
  ADD KEY `ID_lote` (`ID_lote`);

--
-- Indices de la tabla `reparte`
--
ALTER TABLE `reparte`
  ADD PRIMARY KEY (`ID_paquete`),
  ADD KEY `matricula` (`matricula`);

--
-- Indices de la tabla `trae`
--
ALTER TABLE `trae`
  ADD PRIMARY KEY (`ID_paquete`),
  ADD KEY `matricula` (`matricula`);

--
-- Indices de la tabla `troncales`
--
ALTER TABLE `troncales`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`matricula`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `lotes`
--
ALTER TABLE `lotes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `troncales`
--
ALTER TABLE `troncales`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacenes_clientes`
--
ALTER TABLE `almacenes_clientes`
  ADD CONSTRAINT `almacenes_clientes_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `almacenes` (`ID`),
  ADD CONSTRAINT `almacenes_clientes_ibfk_2` FOREIGN KEY (`RUT`) REFERENCES `clientes` (`RUT`);

--
-- Filtros para la tabla `almacenes_propios`
--
ALTER TABLE `almacenes_propios`
  ADD CONSTRAINT `almacenes_propios_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `almacenes` (`ID`);

--
-- Filtros para la tabla `camiones`
--
ALTER TABLE `camiones`
  ADD CONSTRAINT `camiones_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `vehiculos` (`matricula`) ON DELETE CASCADE;

--
-- Filtros para la tabla `camionetas`
--
ALTER TABLE `camionetas`
  ADD CONSTRAINT `camionetas_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `vehiculos` (`matricula`) ON DELETE CASCADE;

--
-- Filtros para la tabla `conducen`
--
ALTER TABLE `conducen`
  ADD CONSTRAINT `conducen_ibfk_1` FOREIGN KEY (`CI`) REFERENCES `camioneros` (`CI`),
  ADD CONSTRAINT `conducen_ibfk_2` FOREIGN KEY (`matricula`) REFERENCES `vehiculos` (`matricula`);

--
-- Filtros para la tabla `destino_lote`
--
ALTER TABLE `destino_lote`
  ADD CONSTRAINT `destino_lote_ibfk_1` FOREIGN KEY (`ID_lote`) REFERENCES `lotes` (`ID`),
  ADD CONSTRAINT `destino_lote_ibfk_2` FOREIGN KEY (`ID_almacen`,`ID_troncal`) REFERENCES `ordenes` (`ID_almacen`, `ID_troncal`);

--
-- Filtros para la tabla `lleva`
--
ALTER TABLE `lleva`
  ADD CONSTRAINT `lleva_ibfk_1` FOREIGN KEY (`ID_lote`) REFERENCES `lotes` (`ID`),
  ADD CONSTRAINT `lleva_ibfk_2` FOREIGN KEY (`matricula`) REFERENCES `camiones` (`matricula`);

--
-- Filtros para la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD CONSTRAINT `lotes_ibfk_1` FOREIGN KEY (`ID_almacen`,`ID_troncal`) REFERENCES `ordenes` (`ID_almacen`, `ID_troncal`);

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `ordenes_ibfk_1` FOREIGN KEY (`ID_almacen`) REFERENCES `almacenes_propios` (`ID`),
  ADD CONSTRAINT `ordenes_ibfk_2` FOREIGN KEY (`ID_troncal`) REFERENCES `troncales` (`ID`);

--
-- Filtros para la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD CONSTRAINT `paquetes_ibfk_1` FOREIGN KEY (`ID_almacen`) REFERENCES `almacenes_clientes` (`ID`),
  ADD CONSTRAINT `paquetes_ibfk_2` FOREIGN KEY (`ID_pickup`) REFERENCES `almacenes_propios` (`ID`);

--
-- Filtros para la tabla `paquetes_lotes`
--
ALTER TABLE `paquetes_lotes`
  ADD CONSTRAINT `paquetes_lotes_ibfk_1` FOREIGN KEY (`ID_paquete`) REFERENCES `paquetes` (`ID`),
  ADD CONSTRAINT `paquetes_lotes_ibfk_2` FOREIGN KEY (`ID_lote`) REFERENCES `lotes` (`ID`);

--
-- Filtros para la tabla `reparte`
--
ALTER TABLE `reparte`
  ADD CONSTRAINT `reparte_ibfk_1` FOREIGN KEY (`ID_paquete`) REFERENCES `paquetes` (`ID`),
  ADD CONSTRAINT `reparte_ibfk_2` FOREIGN KEY (`matricula`) REFERENCES `camionetas` (`matricula`);

--
-- Filtros para la tabla `trae`
--
ALTER TABLE `trae`
  ADD CONSTRAINT `trae_ibfk_1` FOREIGN KEY (`ID_paquete`) REFERENCES `paquetes` (`ID`),
  ADD CONSTRAINT `trae_ibfk_2` FOREIGN KEY (`matricula`) REFERENCES `vehiculos` (`matricula`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
