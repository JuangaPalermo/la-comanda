-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-11-2021 a las 20:01:32
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `la-comanda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

DROP TABLE IF EXISTS `empleado`;
CREATE TABLE `empleado` (
  `empleadoID` int(11) NOT NULL,
  `empleadoPerfil` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `empleadoNombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `empleadoApellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `empleadoCorreo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `empleadoClave` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `empleadoEstado` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `empleadoDisponible` tinyint(1) NOT NULL,
  `empleadoFechaAlta` date NOT NULL,
  `empleadoFechaBaja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`empleadoID`, `empleadoPerfil`, `empleadoNombre`, `empleadoApellido`, `empleadoCorreo`, `empleadoClave`, `empleadoEstado`, `empleadoDisponible`, `empleadoFechaAlta`, `empleadoFechaBaja`) VALUES
(17, 'bartender', 'Claudia', 'Falotico', 'cfmed@gmail.com', '$2y$10$38tm1TsK4FCr2uGPEdsg8uYly.gALmG22VYwSkr8c2VyYl9OHsRKS', 'disponible', 1, '2021-11-15', NULL),
(18, 'cervecero', 'Noelia', 'Perez', 'njpa@gmail.com', '$2y$10$QlTiofcrHUf0fKvUbp3Xyu.9j6fa5/Ceh79btnU82F6ku4SLHGtEC', 'disponible', 1, '2021-11-15', NULL),
(19, 'cocinero', 'Carlos', 'Mejia', 'came@gmail.com', '$2y$10$PIA44gWuZoWHz9zqID4AjeBqgpkGjPJIYHfUZK4vRsmO32jR7VF.e', 'disponible', 1, '2021-11-15', NULL),
(20, 'mozo', 'Pedro', 'Gomez', 'pego@gmail.com', '$2y$10$0H6EXmSKmd4W00WJzlYhM.OXeAIyumP9ke.S3KMxKIw5J70LOC2YO', 'disponible', 1, '2021-11-15', NULL),
(21, 'socio', 'Juan', 'Palermo', 'jupa@gmail.com', '$2y$10$RyoAVQ8TIlzHJ2SLh6MXLuk61XOKgrzm98sjRXYOt4A0Ysn3mvxVm', 'disponible', 1, '2021-11-16', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logeo`
--

DROP TABLE IF EXISTS `logeo`;
CREATE TABLE `logeo` (
  `logeoId` int(11) NOT NULL,
  `perfilEmpleado` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `correoEmpleado` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fechaLogeo` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `logeo`
--

INSERT INTO `logeo` (`logeoId`, `perfilEmpleado`, `idEmpleado`, `correoEmpleado`, `fechaLogeo`) VALUES
(1, 'mozo', 20, 'pego@gmail.com', '2021-11-30 15:59:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

DROP TABLE IF EXISTS `mesa`;
CREATE TABLE `mesa` (
  `mesaID` int(11) NOT NULL,
  `mesaEstado` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `mesaUsos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`mesaID`, `mesaEstado`, `mesaUsos`) VALUES
(1, 'con cliente esperando pedido', 0),
(2, 'cerrada', 0),
(4, 'con cliente esperando pedido', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE `pedido` (
  `pedidoID` int(11) NOT NULL,
  `pedidoCodigo` int(11) NOT NULL,
  `pedidoEmpleadoID` int(11) DEFAULT NULL,
  `pedidoProductoID` int(11) NOT NULL,
  `pedidoMesaID` int(11) NOT NULL,
  `pedidoCliente` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `pedidoEstado` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `pedidoFechaCreacion` datetime NOT NULL,
  `pedidoFechaTomado` datetime DEFAULT NULL,
  `pedidoFechaEstimadaEntrega` datetime DEFAULT NULL,
  `pedidoFechaEntregado` datetime DEFAULT NULL,
  `pedidoFechaFinalizacion` datetime DEFAULT NULL,
  `pedidoImagen` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `pedidoCalificacion` int(11) DEFAULT NULL,
  `pedidoComentario` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`pedidoID`, `pedidoCodigo`, `pedidoEmpleadoID`, `pedidoProductoID`, `pedidoMesaID`, `pedidoCliente`, `pedidoEstado`, `pedidoFechaCreacion`, `pedidoFechaTomado`, `pedidoFechaEstimadaEntrega`, `pedidoFechaEntregado`, `pedidoFechaFinalizacion`, `pedidoImagen`, `pedidoCalificacion`, `pedidoComentario`) VALUES
(8, 1234, 19, 1, 4, 'pedro@test.com', 'concluido', '2021-11-16 01:49:06', '2021-11-16 12:14:10', '2021-11-16 12:34:10', '2021-11-16 13:12:39', '2021-11-16 14:49:17', './ImagenesDeLosPedidos/1234-4-pedro.', 5, 'muy rico todo y buena atencion'),
(9, 1234, 19, 2, 4, 'pedro@test.com', 'concluido', '2021-11-16 01:54:42', '2021-11-16 12:14:02', '2021-11-16 12:34:02', '2021-11-16 13:12:43', '2021-11-16 14:49:17', './ImagenesDeLosPedidos/1234-4-pedro.jpg', 5, 'muy rico todo y buena atencion'),
(10, 1234, 19, 2, 4, 'pedro@test.com', 'concluido', '2021-11-16 01:56:58', '2021-11-16 12:14:06', '2021-11-16 12:34:06', '2021-11-16 13:12:47', '2021-11-16 14:49:17', './ImagenesDeLosPedidos/1234-4-pedro.jpg', 5, 'muy rico todo y buena atencion'),
(11, 1234, 18, 3, 4, 'pedro@test.com', 'concluido', '2021-11-16 01:57:27', '2021-11-16 12:13:21', '2021-11-16 12:28:21', '2021-11-16 13:13:47', '2021-11-16 14:49:17', './ImagenesDeLosPedidos/1234-4-pedro.jpg', 5, 'muy rico todo y buena atencion'),
(12, 1234, 17, 4, 4, 'pedro@test.com', 'concluido', '2021-11-16 01:57:30', '2021-11-16 10:10:46', '2021-11-16 10:45:46', '2021-11-16 13:14:26', '2021-11-16 14:49:17', './ImagenesDeLosPedidos/1234-4-pedro.jpg', 5, 'muy rico todo y buena atencion'),
(16, 666, 19, 4, 1, 'pedro@test.com', 'en preparacion', '2021-11-16 16:05:42', '2021-11-16 16:05:56', '2021-11-16 16:25:56', NULL, NULL, './ImagenesDeLosPedidos/666-1-pedro.jpg', NULL, NULL),
(17, 1122, NULL, 1, 4, 'pedro@test.com', 'pendiente', '2021-11-29 19:39:10', NULL, NULL, NULL, NULL, './ImagenesDeLosPedidos/1122-4-pedro.', NULL, NULL),
(18, 1122, NULL, 1, 4, 'pedro@test.com', 'pendiente', '2021-11-29 19:40:21', NULL, NULL, NULL, NULL, './ImagenesDeLosPedidos/1122-4-pedro.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
  `productoID` int(11) NOT NULL,
  `productoNombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `productoPrecio` float NOT NULL,
  `productoPerfilEmpleado` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`productoID`, `productoNombre`, `productoPrecio`, `productoPerfilEmpleado`) VALUES
(1, 'milanesa a caballo', 150.6, 'cocinero'),
(2, 'hamburguesa de garbanzo', 300, 'cocinero'),
(3, 'corona', 100, 'cervecero'),
(4, 'daikiri', 150, 'bartender'),
(6, 'naranjada', 110, 'bartender');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`empleadoID`);

--
-- Indices de la tabla `logeo`
--
ALTER TABLE `logeo`
  ADD PRIMARY KEY (`logeoId`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`mesaID`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`pedidoID`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`productoID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `empleadoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `logeo`
--
ALTER TABLE `logeo`
  MODIFY `logeoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `mesaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `pedidoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `productoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
