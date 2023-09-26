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
