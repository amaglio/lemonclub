-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 12-11-2018 a las 16:09:03
-- Versión del servidor: 5.6.40-log
-- Versión de PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `c0920276_lemonv1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristica`
--

CREATE TABLE `caracteristica` (
  `id_caracteristica` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combo`
--

CREATE TABLE `combo` (
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combo_producto`
--

CREATE TABLE `combo_producto` (
  `id_producto_combo` int(11) NOT NULL,
  `id_producto_componente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_entrega`
--

CREATE TABLE `forma_entrega` (
  `id_forma_entrega` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `forma_entrega`
--

INSERT INTO `forma_entrega` (`id_forma_entrega`, `descripcion`) VALUES
(1, 'Take away'),
(2, 'Delivery');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_pago`
--

CREATE TABLE `forma_pago` (
  `id_forma_pago` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `forma_pago`
--

INSERT INTO `forma_pago` (`id_forma_pago`, `descripcion`) VALUES
(1, 'Efectivo'),
(2, 'Digital');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id_grupo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `usar_precio_ingrediente` tinyint(1) NOT NULL COMMENT 'Si usar_precio_ingrediente es igual a 1 (true) el precio del producto_grupo es por los ingredientes default, si se agrega un ingrediente que no es default se le suma el precio del ingrediente.\nSi usar_precio_ingrediente es igual a 0 (false) el precio del producto_grupo es por la cantidad default, si se agrega una cantidad de ingredientes mayor se suma el precio_adicional por cada ingrediente que exceda.',
  `cantidad_default` int(11) DEFAULT NULL,
  `cantidad_minima` int(11) DEFAULT NULL,
  `cantidad_maxima` int(11) DEFAULT NULL,
  `precio_adicional` decimal(10,2) DEFAULT NULL,
  `fecha_alta` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id_grupo`, `nombre`, `usar_precio_ingrediente`, `cantidad_default`, `cantidad_minima`, `cantidad_maxima`, `precio_adicional`, `fecha_alta`, `fecha_modificacion`, `fecha_baja`) VALUES
(1, 'Vegetales calientes', 0, 2, 1, 3, '15.00', NULL, NULL, NULL),
(2, 'carnes', 1, 1, 1, 2, '15.00', NULL, NULL, NULL),
(3, 'Fiambres', 0, 3, 2, 4, '5.00', NULL, NULL, NULL),
(4, 'Base', 0, 5, NULL, NULL, '20.00', NULL, NULL, NULL),
(5, 'Toppins', 0, NULL, NULL, NULL, '15.00', NULL, NULL, NULL),
(6, 'Premium', 0, NULL, NULL, NULL, '80.00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_ingrediente`
--

CREATE TABLE `grupo_ingrediente` (
  `id_ingrediente` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupo_ingrediente`
--

INSERT INTO `grupo_ingrediente` (`id_ingrediente`, `id_grupo`) VALUES
(1, 1),
(2, 4),
(4, 1),
(6, 3),
(7, 3),
(7, 5),
(9, 2),
(10, 2),
(11, 2),
(12, 4),
(13, 1),
(14, 3),
(14, 5),
(15, 3),
(15, 5),
(16, 1),
(17, 4),
(18, 4),
(19, 4),
(20, 4),
(21, 4),
(22, 4),
(23, 5),
(25, 2),
(25, 5),
(27, 5),
(28, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente`
--

CREATE TABLE `ingrediente` (
  `id_ingrediente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `path_imagen` varchar(512) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `calorias` int(11) NOT NULL,
  `fecha_alta` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ingrediente`
--

INSERT INTO `ingrediente` (`id_ingrediente`, `nombre`, `path_imagen`, `precio`, `calorias`, `fecha_alta`, `fecha_modificacion`, `fecha_baja`) VALUES
(1, 'tomate', '96553-tomate.jpeg', '10.00', 15, NULL, NULL, '2018-07-29 14:12:10'),
(2, 'lechuga francesa', 'a8d4b-lechuga.jpeg', '10.00', 13, NULL, NULL, NULL),
(3, 'cebolla morada', '02cbe-cebolla_morada.jpeg', '8.00', 14, NULL, NULL, NULL),
(4, 'ajo', '8b116-ajo.jpeg', '8.00', 10, NULL, NULL, NULL),
(5, 'salame', 'eb83c-salame.jpeg', '12.00', 14, NULL, NULL, NULL),
(6, 'gouda', '4b17b-gouda.jpg', '11.00', 18, NULL, NULL, NULL),
(7, 'jamon cocido', 'da081-jamon.jpeg', '19.00', 5, NULL, NULL, NULL),
(8, 'roquefort', 'd52e7-roquefort.jpeg', '20.00', 16, NULL, NULL, NULL),
(9, 'Pechuga de pollo', 'ae590-pechuga.jpg', '10.00', 5, NULL, NULL, NULL),
(10, 'Carne vaca', '18c2e-bife.png', '12.00', 0, NULL, NULL, NULL),
(11, 'Cerdo', 'b16e5-cerdo.jpeg', '11.00', 0, NULL, NULL, NULL),
(12, 'zanahoria', '15440-zanahoria_rodaja_1024x1024.jpg', '5.00', 0, NULL, NULL, NULL),
(13, 'Morron rojo', '9ea4f-moron.jpeg', '11.00', 0, NULL, NULL, NULL),
(14, 'queso mozzarela', '02f90-muzzarela.jpeg', '32.00', 0, NULL, NULL, NULL),
(15, 'jamon crudo', '4527a-download.jpeg', '0.00', 0, NULL, NULL, NULL),
(16, 'cebolla', 'ad98a-cebolla.jpeg', '1.00', 0, NULL, NULL, NULL),
(17, 'Rucula', 'a161a-rucula.jpg', '12.00', 0, NULL, NULL, NULL),
(18, 'Espinaca', '9542a-espinaca.jpg', '16.00', 0, NULL, NULL, NULL),
(19, 'Quinoa', '8c78f-quinoa.jpg', '34.00', 0, NULL, NULL, NULL),
(20, 'Apio', 'd0fef-apio.jpg', '0.00', 0, NULL, NULL, NULL),
(21, 'Arroz', '713d6-arroz.jpg', '0.00', 0, NULL, NULL, NULL),
(22, 'Huevo', 'b78f2-huevo.jpg', '21.00', 0, NULL, NULL, NULL),
(23, 'Panceta', '2f735-panceta.jpg', '43.00', 0, NULL, NULL, NULL),
(24, 'Palta', 'cb7bb-palta.jpg', '4.00', 0, NULL, NULL, NULL),
(25, 'Palmitos', '26c34-palmitos.jpeg', '13.00', 0, NULL, NULL, NULL),
(26, 'Nueces', '894d1-nuezpelada.jpg', '30.00', 0, NULL, NULL, NULL),
(27, 'Mani', 'e8c90-mani.jpg', '22.00', 0, NULL, NULL, NULL),
(28, 'Salmon ahumado', '17c65-ahumada.jpg', '56.00', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente_estado`
--

CREATE TABLE `ingrediente_estado` (
  `id_ingrediente_estado` int(11) NOT NULL,
  `descricpcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente_estado_sucursal`
--

CREATE TABLE `ingrediente_estado_sucursal` (
  `id_ingrediente` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_ingrediente_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_sp`
--

CREATE TABLE `log_sp` (
  `id_log_sp` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `sp_nombre` varchar(50) NOT NULL,
  `sp_parametros` varchar(1024) NOT NULL,
  `sp_cod_error` int(11) NOT NULL,
  `sp_mensaje` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_mercadopago`
--

CREATE TABLE `pago_mercadopago` (
  `id_pago_online` int(11) NOT NULL,
  `id_mercadopago` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_online`
--

CREATE TABLE `pago_online` (
  `id_pago_online` int(11) NOT NULL,
  `fecha_pago` datetime NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_pago_online_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_online_estado`
--

CREATE TABLE `pago_online_estado` (
  `id_pago_online_estado` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pago_online_estado`
--

INSERT INTO `pago_online_estado` (`id_pago_online_estado`, `descripcion`) VALUES
(1, 'Aceptado'),
(2, 'Rechazado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `fecha_pedido` datetime NOT NULL,
  `id_pedido_estado` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_forma_pago` int(11) DEFAULT NULL,
  `id_forma_entrega` int(11) DEFAULT NULL,
  `fecha_entrega` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `fecha_pedido`, `id_pedido_estado`, `id_sucursal`, `id_usuario`, `id_forma_pago`, `id_forma_entrega`, `fecha_entrega`) VALUES
(1, '2018-07-08 00:00:00', 2, 1, 5, 1, 2, '2018-07-27 00:00:00'),
(2, '0000-00-00 00:00:00', 1, 1, 30, NULL, NULL, NULL),
(3, '0000-00-00 00:00:00', 1, 1, 30, NULL, NULL, NULL),
(4, '0000-00-00 00:00:00', 1, 1, 30, NULL, NULL, NULL),
(5, '0000-00-00 00:00:00', 1, 1, 30, NULL, NULL, NULL),
(6, '0000-00-00 00:00:00', 1, 1, 30, NULL, NULL, NULL),
(7, '2018-07-08 00:00:00', 2, 1, 5, 1, 1, '2018-06-25 14:00:00'),
(8, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(9, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(10, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(11, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(12, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(13, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(14, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(15, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(16, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(17, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(18, '2018-07-16 17:44:55', 2, 1, 28, 1, 1, '2018-06-15 21:00:00'),
(19, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(20, '2018-07-16 20:39:24', 2, 1, 28, 1, 1, '2018-07-16 21:00:00'),
(21, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(22, '2018-07-17 22:25:52', 2, 1, 28, 1, 1, '2018-07-17 23:00:00'),
(23, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(24, '2018-07-18 18:25:50', 2, 1, 28, 1, 1, '2018-07-18 19:00:00'),
(25, '2018-07-18 19:53:50', 2, 1, 28, 1, 1, '2018-07-18 20:00:00'),
(26, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(27, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(28, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(29, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(30, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(31, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(32, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(33, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(34, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(35, '2018-07-30 17:28:42', 2, 1, 28, 1, 1, '2018-07-30 18:00:00'),
(36, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(37, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(38, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(39, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(40, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(41, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(42, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(43, '2018-08-20 23:04:15', 2, 1, 28, 1, 1, '2018-08-20 12:45:00'),
(44, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(45, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(46, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(47, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(48, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(49, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(50, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(51, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(52, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL),
(53, '0000-00-00 00:00:00', 1, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_delivery`
--

CREATE TABLE `pedido_delivery` (
  `id_pedido` int(11) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `latitud` varchar(45) DEFAULT NULL,
  `longitud` varchar(45) DEFAULT NULL,
  `nota` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_estado`
--

CREATE TABLE `pedido_estado` (
  `id_pedido_estado` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `id_pedido_estado_siguiente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedido_estado`
--

INSERT INTO `pedido_estado` (`id_pedido_estado`, `descripcion`, `id_pedido_estado_siguiente`) VALUES
(1, 'Sin confirmar', NULL),
(2, 'Pendiente', NULL),
(3, 'En elaboración', NULL),
(4, 'Listo para entregar', NULL),
(5, 'Entregado', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_estado_historico`
--

CREATE TABLE `pedido_estado_historico` (
  `id_pedido` int(11) NOT NULL,
  `id_pedido_estado` int(11) NOT NULL,
  `fecha_pedido_estado` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_producto`
--

CREATE TABLE `pedido_producto` (
  `id_pedido_producto` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedido_producto`
--

INSERT INTO `pedido_producto` (`id_pedido_producto`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(10, 2, 16, 1, '130.00'),
(15, 3, 7, 1, '80.00'),
(16, 4, 1, 2, '215.00'),
(18, 4, 5, 1, '90.00'),
(19, 4, 1, 1, '200.00'),
(22, 5, 11, 1, '130.00'),
(23, 5, 3, 1, '222.00'),
(24, 7, 1, 1, '215.00'),
(25, 9, 8, 1, '100.00'),
(26, 9, 11, 1, '130.00'),
(27, 9, 5, 1, '90.00'),
(28, 9, 12, 1, '100.00'),
(29, 9, 7, 1, '80.00'),
(30, 9, 4, 1, '95.00'),
(31, 9, 2, 1, '90.00'),
(32, 9, 1, 1, '200.00'),
(38, 1, 2, 1, '90.00'),
(39, 1, 2, 1, '90.00'),
(42, 10, 1, 1, '200.00'),
(43, 11, 12, 1, '100.00'),
(44, 12, 1, 1, '200.00'),
(45, 12, 5, 1, '90.00'),
(46, 12, 11, 1, '130.00'),
(47, 14, 5, 1, '90.00'),
(48, 14, 5, 1, '90.00'),
(49, 15, 5, 1, '90.00'),
(50, 16, 5, 1, '90.00'),
(51, 17, 5, 1, '90.00'),
(52, 17, 17, 1, '85.00'),
(53, 18, 5, 1, '120.00'),
(54, 20, 5, 1, '120.00'),
(55, 22, 5, 1, '105.00'),
(56, 24, 5, 1, '120.00'),
(57, 24, 1, 1, '200.00'),
(60, 25, 12, 1, '100.00'),
(61, 27, 11, 1, '130.00'),
(62, 27, 5, 1, '90.00'),
(63, 29, 5, 1, '90.00'),
(64, 29, 1, 1, '200.00'),
(65, 29, 11, 1, '130.00'),
(66, 29, 17, 1, '85.00'),
(67, 30, 1, 1, '200.00'),
(68, 30, 1, 1, '200.00'),
(69, 30, 14, 1, '95.00'),
(71, 31, 5, 1, '90.00'),
(72, 32, 5, 1, '90.00'),
(74, 34, 17, 1, '85.00'),
(75, 34, 15, 1, '90.00'),
(76, 35, 13, 1, '90.00'),
(77, 35, 5, 1, '90.00'),
(78, 35, 14, 1, '95.00'),
(79, 35, 14, 1, '95.00'),
(80, 35, 17, 1, '85.00'),
(81, 39, 11, 1, '130.00'),
(82, 40, 5, 1, '120.00'),
(83, 42, 13, 1, '90.00'),
(85, 44, 14, 1, '95.00'),
(86, 45, 14, 1, '95.00'),
(87, 43, 11, 1, '130.00'),
(88, 43, 5, 1, '90.00'),
(89, 48, 5, 1, '90.00'),
(90, 49, 14, 1, '95.00'),
(91, 49, 11, 1, '130.00'),
(92, 49, 1, 1, '200.00'),
(93, 53, 1, 1, '230.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_producto_ingrediente`
--

CREATE TABLE `pedido_producto_ingrediente` (
  `id_pedido_producto` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedido_producto_ingrediente`
--

INSERT INTO `pedido_producto_ingrediente` (`id_pedido_producto`, `id_grupo`, `id_ingrediente`) VALUES
(16, 1, 3),
(16, 1, 7),
(16, 1, 8),
(19, 1, 3),
(19, 1, 7),
(24, 1, 3),
(24, 1, 7),
(24, 1, 8),
(32, 1, 3),
(32, 1, 7),
(44, 1, 7),
(47, 1, 1),
(47, 1, 3),
(50, 1, 1),
(50, 1, 3),
(51, 1, 1),
(51, 1, 3),
(53, 1, 1),
(53, 1, 3),
(53, 1, 13),
(54, 1, 1),
(54, 1, 4),
(54, 1, 13),
(55, 1, 1),
(55, 1, 13),
(55, 1, 16),
(56, 1, 1),
(56, 1, 4),
(56, 1, 13),
(57, 1, 7),
(57, 1, 8),
(62, 1, 1),
(62, 1, 3),
(63, 1, 1),
(63, 1, 3),
(64, 1, 7),
(64, 1, 8),
(67, 1, 7),
(67, 1, 8),
(68, 1, 7),
(68, 1, 8),
(71, 1, 1),
(71, 1, 3),
(72, 1, 1),
(72, 1, 3),
(77, 1, 1),
(77, 1, 3),
(82, 1, 1),
(82, 1, 13),
(82, 1, 16),
(88, 1, 1),
(89, 1, 1),
(89, 1, 3),
(92, 1, 1),
(92, 1, 3),
(92, 1, 4),
(92, 1, 7),
(92, 1, 8),
(92, 1, 13),
(93, 1, 1),
(93, 1, 4),
(93, 1, 13),
(44, 2, 11),
(47, 2, 10),
(47, 2, 11),
(50, 2, 9),
(50, 2, 10),
(50, 2, 11),
(51, 2, 9),
(53, 2, 9),
(53, 2, 25),
(54, 2, 9),
(54, 2, 10),
(55, 2, 9),
(56, 2, 9),
(56, 2, 25),
(62, 2, 10),
(63, 2, 10),
(71, 2, 10),
(72, 2, 10),
(77, 2, 10),
(82, 2, 10),
(82, 2, 25),
(88, 2, 10),
(89, 2, 10),
(93, 2, 9),
(93, 2, 10),
(93, 3, 6),
(66, 4, 2),
(66, 4, 12),
(74, 4, 2),
(74, 4, 12),
(80, 4, 2),
(80, 4, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_token`
--

CREATE TABLE `pedido_token` (
  `id_pedido` int(11) NOT NULL,
  `token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `id_producto_tipo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `path_imagen` varchar(512) DEFAULT 'sin_imagen.jpg',
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `orden_aparicion_web` int(11) DEFAULT NULL,
  `fecha_alta` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `id_producto_tipo`, `nombre`, `path_imagen`, `descripcion`, `precio`, `orden_aparicion_web`, `fecha_alta`, `fecha_modificacion`, `fecha_baja`) VALUES
(1, 1, 'Romano 2', '6c6de-romano.jpg', 'Jamón crudo, rúcula, queso tybo, tomate y queso crema', '200.00', NULL, NULL, NULL, NULL),
(2, 3, 'Pechiguitas a la plancha', '864a4-pechuguitasconensa-min.jpg', 'Pechuguitas de pollo marinadas con limón, romero y mostaza con guarnición', '90.00', NULL, NULL, NULL, '2018-07-03 21:38:18'),
(3, 4, 'Ensalda cesar', 'c441b-ensalada-cesar-clasica-573.jpg', 'Crutones con pollo, salsa cesar', '222.00', NULL, NULL, NULL, '2018-07-03 20:18:56'),
(4, 2, 'Ternerita y cheddar', '17817-panini.jpg', 'Ternera braseada, cebolla asada, morrón, queso cheddar y aderezo 1000 islas', '95.00', NULL, NULL, NULL, '2018-07-03 21:43:17'),
(5, 1, 'Tuna caesar', '6e60f-cmrgmefw8aerbvi.jpg', 'Atún, apio, cebolla morada, lechuga, tomate y aderezo caesar asdasd \r\n', '90.00', NULL, NULL, NULL, NULL),
(6, 5, 'Ranchero', '0587d-huevos-rancheros-wraps1.jpg', 'Pechuga de pollo, jamón cocido, panceta crocante, tomate, lechuga y aderezo ranchero', '90.00', NULL, NULL, NULL, NULL),
(7, 2, 'Pollo y palta', '6a73a-turkey-caprese-panini.jpg', 'Pechuga de pollo, palta, cebolla morada, queso tybo, limón y mayonesa', '80.00', NULL, NULL, NULL, NULL),
(8, 3, 'Mila Napo', '399d3-milanesa-a-la_-napolitana-credit-greg-devilliers-main.jpg', 'Milanesa con salsa de tomate, queso y tomate fresco con guarnición ', '100.00', NULL, NULL, NULL, NULL),
(9, 4, 'Quinoa Kanikama palmitos', 'd9c58-db806fcfbedeed3299cbe5dd5e73aafa-quinoa-salad-bolivian-recipes.jpg', 'Mix verdes, quinoa, cherry, huevo, zanahoria, palmitos y kanikama aderezo 10000 islas', '100.00', NULL, NULL, NULL, NULL),
(10, 5, 'Tejano (HOT)', '39a94-nikklas-greek-gyros-and.jpg', 'Pechuga de pollo, panceta crocante, cebolla cocida, morrón, cheddar y salsa BBQ', '90.00', NULL, NULL, NULL, NULL),
(11, 1, 'Mar & Timo Deluxe', 'e783d-marytimodeluxe-min.jpg', 'Salmón ahumado, palta, rúcula, queso crema y nuez', '130.00', NULL, NULL, NULL, NULL),
(12, 2, 'Doble Queso y BBQ', '5a113-dobleq-min.jpg', 'Ternera braseada, queso tybo, queso cheddar, tomate, panceta crocante y BBQ', '100.00', NULL, NULL, NULL, NULL),
(13, 4, 'Ensalada Mediterranea', '7414b-ensmediterranea-min.jpg', 'Mix de hojas verdes, tomate cherry, queso en hebras, olivas negras, nueces y semillas de sesamo con aderezo de limón, oliva, mostaza y miel ', '90.00', NULL, NULL, NULL, NULL),
(14, 6, 'Wok Oriental', '4809e-wokoriental-min.jpg', 'Cebolla, morrón, zapallito, brotes de soja, arroz y pollo salteados con jengibre', '95.00', NULL, NULL, NULL, NULL),
(15, 5, 'Palta Wrap', '256b5-paltawrap-min.jpg', 'Espinaca, tomate, palta, cebolla morada, queso en hebras y pollo con mayonesa y limón', '90.00', NULL, NULL, NULL, NULL),
(16, 7, 'House Burguer', '7fdd9-houseburguer-min.jpg', 'Hamburguesa de ternera, rucula, tomate, panceta crocante, cebolla caramelizada, cheddar y aderezo 1000 islas con papas fritas bastón', '130.00', NULL, NULL, NULL, NULL),
(17, 4, 'Salad bar', '25158-salad.jpeg', 'Armá tu ensalada', '85.00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_caracteristica`
--

CREATE TABLE `producto_caracteristica` (
  `id_producto` int(11) NOT NULL,
  `id_caracteristica` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_dia`
--

CREATE TABLE `producto_dia` (
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto_dia`
--

INSERT INTO `producto_dia` (`id_producto`) VALUES
(14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_estado`
--

CREATE TABLE `producto_estado` (
  `id_producto_estado` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_estado_sucursal`
--

CREATE TABLE `producto_estado_sucursal` (
  `id_producto` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_producto_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_grupo`
--

CREATE TABLE `producto_grupo` (
  `id_producto` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `es_obligatorio` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto_grupo`
--

INSERT INTO `producto_grupo` (`id_producto`, `id_grupo`, `orden`, `es_obligatorio`) VALUES
(1, 1, 0, 0),
(1, 2, 0, 0),
(1, 3, 0, 0),
(2, 1, 0, 0),
(5, 1, 0, 0),
(5, 2, 0, 0),
(13, 2, 0, 0),
(17, 4, 0, 0),
(17, 5, 0, 0),
(17, 6, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_grupo_ingrediente`
--

CREATE TABLE `producto_grupo_ingrediente` (
  `id_producto` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL,
  `es_fijo` tinyint(1) NOT NULL,
  `es_default` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto_grupo_ingrediente`
--

INSERT INTO `producto_grupo_ingrediente` (`id_producto`, `id_grupo`, `id_ingrediente`, `es_fijo`, `es_default`) VALUES
(1, 1, 1, 0, 1),
(1, 1, 3, 0, 1),
(1, 1, 4, 0, 1),
(1, 1, 7, 0, 1),
(1, 1, 8, 1, 0),
(1, 1, 13, 1, 1),
(1, 2, 9, 0, 0),
(1, 2, 11, 0, 0),
(1, 3, 14, 0, 0),
(1, 3, 15, 0, 0),
(2, 1, 3, 0, 0),
(2, 1, 7, 0, 0),
(2, 1, 8, 0, 0),
(5, 1, 1, 0, 1),
(5, 1, 3, 0, 1),
(5, 1, 4, 0, 0),
(5, 1, 13, 0, 0),
(5, 1, 16, 0, 0),
(5, 2, 9, 0, 0),
(5, 2, 10, 0, 1),
(5, 2, 11, 0, 0),
(5, 2, 25, 0, 0),
(13, 2, 9, 0, 0),
(13, 2, 11, 0, 0),
(17, 4, 2, 0, 1),
(17, 4, 12, 0, 1),
(17, 5, 7, 0, 0),
(17, 5, 14, 0, 0),
(17, 5, 15, 0, 0),
(17, 5, 23, 0, 0),
(17, 5, 25, 0, 0),
(17, 5, 27, 0, 0),
(17, 6, 28, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_ingrediente`
--

CREATE TABLE `producto_ingrediente` (
  `id_producto` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL,
  `ingrediente_default` tinyint(1) NOT NULL,
  `ingrediente_fijo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_tipo`
--

CREATE TABLE `producto_tipo` (
  `id_producto_tipo` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `path_imagen` varchar(512) DEFAULT 'sin_imagen.jpg',
  `orden_aparicion_web` int(11) DEFAULT NULL,
  `fecha_alta` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto_tipo`
--

INSERT INTO `producto_tipo` (`id_producto_tipo`, `descripcion`, `path_imagen`, `orden_aparicion_web`, `fecha_alta`, `fecha_modificacion`, `fecha_baja`) VALUES
(1, 'Sandwich', '3bdc5-btn_sandwich.jpg', NULL, NULL, NULL, NULL),
(2, 'Paninis', 'btn_paninis.jpg', NULL, NULL, NULL, NULL),
(3, 'Platos calientes', 'btn_platos_calientes.jpg', NULL, NULL, NULL, NULL),
(4, 'Ensaladas', 'btn_ensaladas.jpg', NULL, NULL, NULL, NULL),
(5, 'Wraps', 'btn_wraps.jpg', NULL, NULL, NULL, NULL),
(6, 'Woks', 'btn_woks.jpg', NULL, NULL, NULL, NULL),
(7, 'Hamburguesas', 'btn_hamburguesas.jpg', NULL, NULL, NULL, NULL),
(8, 'asdasd', '55824-were-playing-a-game-its-not-supposed-to-be-fun.jpg', NULL, NULL, NULL, '2018-07-08 20:45:04'),
(9, 'Salad bar', '70592-salad.jpeg', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE `sucursal` (
  `id_sucursal` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `latitud` varchar(45) NOT NULL,
  `longitud` varchar(45) NOT NULL,
  `margen_entrega` int(10) UNSIGNED NOT NULL,
  `capacidad_entrega` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`id_sucursal`, `nombre`, `direccion`, `latitud`, `longitud`, `margen_entrega`, `capacidad_entrega`) VALUES
(1, 'Lemon reconquista', 'Reconquista 869', '34.5977059', '58.372842', 15, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal_horario`
--

CREATE TABLE `sucursal_horario` (
  `id_horario` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `dia` int(1) UNSIGNED NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sucursal_horario`
--

INSERT INTO `sucursal_horario` (`id_horario`, `id_sucursal`, `dia`, `hora_inicio`, `hora_fin`) VALUES
(1, 1, 0, '07:00:00', '23:00:00'),
(3, 1, 1, '07:00:00', '23:00:00'),
(4, 1, 2, '07:00:00', '23:00:00'),
(5, 1, 3, '07:00:00', '23:00:00'),
(6, 1, 4, '07:00:00', '23:00:00'),
(7, 1, 5, '07:00:00', '23:00:00'),
(8, 1, 6, '07:00:00', '23:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `registrado` tinyint(1) NOT NULL,
  `fecha_alta` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `email`, `registrado`, `fecha_alta`, `fecha_modificacion`, `fecha_baja`) VALUES
(1, '2adrian.magliola@gmail.com', 0, NULL, NULL, NULL),
(2, 'adrian.mag2liola@gmail.com', 0, NULL, NULL, NULL),
(3, 'adrian.ma33gliola@gmail.com', 0, NULL, NULL, NULL),
(4, 'adrian.maglio2la@gmail.com', 0, NULL, NULL, NULL),
(5, 'adrian.magl22iola@gmail.com', 1, NULL, NULL, NULL),
(6, 'adria333n.magliola@gmail.com', 0, NULL, NULL, NULL),
(7, 'adrian.maglio222la@gmail.com', 0, NULL, NULL, NULL),
(8, 'adaarian.magliola@gmail.com', 0, NULL, NULL, NULL),
(9, 'adrian.ma333gliola@gmail.com', 0, NULL, NULL, NULL),
(10, 'adrian.maasgliola@gmail.com', 0, NULL, NULL, NULL),
(11, 'adrian.magaaaaaliola@gmail.com', 0, NULL, NULL, NULL),
(12, 'adrian.m55agliola@gmail.com', 0, NULL, NULL, NULL),
(13, 'adrian.a@gmail.com', 0, NULL, NULL, NULL),
(14, 'ffadrian.magliola@gmail.com', 0, NULL, NULL, NULL),
(15, 'adrian.maaagliola@gmail.com', 0, NULL, NULL, NULL),
(16, 'ggadrian.magliola@gmail.com', 0, NULL, NULL, NULL),
(17, 'adrian.aaa@gmail.com', 1, NULL, NULL, NULL),
(18, 't.magliola@gmail.com', 0, NULL, NULL, NULL),
(19, 'adraaian.aaa@gmail.com', 1, NULL, NULL, NULL),
(20, 'adrian.magliol58a@gmail.com', 1, NULL, NULL, NULL),
(24, 'adrian.magli222ola@gmail.com', 0, NULL, NULL, NULL),
(25, 'adrian.ae13@gmail.com', 1, NULL, NULL, NULL),
(26, 'adrian.magli2qaaola@gmail.com', 1, NULL, NULL, NULL),
(27, 'adria22221n.magliola@gmail.com', 1, NULL, NULL, NULL),
(28, 'adrian.magliola@gmail.com', 1, NULL, NULL, NULL),
(29, 'lindosugus@hotmail.com', 1, NULL, NULL, NULL),
(30, 'carabajal.m.a@gmail.com', 1, NULL, NULL, NULL),
(31, 'fabianmayoral@hotmail.com', 0, NULL, NULL, NULL),
(32, 'fabianmayoral@gmail.com', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_registrado`
--

CREATE TABLE `usuario_registrado` (
  `id_usuario` int(11) NOT NULL,
  `password` varchar(64) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_registrado`
--

INSERT INTO `usuario_registrado` (`id_usuario`, `password`, `nombre`, `apellido`, `direccion`, `telefono`, `fecha_registro`) VALUES
(3, 'a8f5f167f44f4964e6c998dee827110c', 'Adrian', 'Matias', NULL, NULL, NULL),
(5, 'a8f5f167f44f4964e6c998dee827110c', 'Adrian', 'aaa', NULL, NULL, NULL),
(6, 'a8f5f167f44f4964e6c998dee827110c', 'Usuario', 'Nuevo', NULL, NULL, NULL),
(7, 'a8f5f167f44f4964e6c998dee827110c', 'aa', 'ss', NULL, NULL, NULL),
(8, 'a8f5f167f44f4964e6c998dee827110c', 'Adrian', 'Magliola', NULL, NULL, NULL),
(9, 'a8f5f167f44f4964e6c998dee827110c', 'aa', 'aa', NULL, NULL, NULL),
(10, 'a8f5f167f44f4964e6c998dee827110c', 'aaa', 'aaa', NULL, NULL, NULL),
(11, 'a8f5f167f44f4964e6c998dee827110c', 'aaa', 'aaa', NULL, NULL, NULL),
(12, 'a8f5f167f44f4964e6c998dee827110c', 'aa', 'a', NULL, NULL, NULL),
(13, 'a8f5f167f44f4964e6c998dee827110c', 'a', 'a', NULL, NULL, NULL),
(14, 'a8f5f167f44f4964e6c998dee827110c', 'a', 'a', NULL, NULL, NULL),
(15, 'a8f5f167f44f4964e6c998dee827110c', 'adrian', 'adrian', NULL, NULL, NULL),
(16, 'a8f5f167f44f4964e6c998dee827110c', 'adrian', 'adrian', NULL, NULL, NULL),
(17, 'a8f5f167f44f4964e6c998dee827110c', 'aa', 'ss', NULL, NULL, NULL),
(18, 'a8f5f167f44f4964e6c998dee827110c', 'a', 'v', NULL, NULL, NULL),
(19, 'a8f5f167f44f4964e6c998dee827110c', 'a', 'a', NULL, NULL, NULL),
(20, 'a8f5f167f44f4964e6c998dee827110c', 'a', 'a', NULL, NULL, NULL),
(24, 'a8f5f167f44f4964e6c998dee827110c', 'adrian', 'adrian', NULL, NULL, NULL),
(25, 'a8f5f167f44f4964e6c998dee827110c', 'aa', 'aa', NULL, NULL, NULL),
(26, 'a8f5f167f44f4964e6c998dee827110c', 'a', 'a', NULL, NULL, NULL),
(27, 'a8f5f167f44f4964e6c998dee827110c', 'AER', 'asTREE', NULL, NULL, NULL),
(28, 'a8f5f167f44f4964e6c998dee827110c', 'ss', 'aa', NULL, NULL, NULL),
(29, 'a8f5f167f44f4964e6c998dee827110c', 'invitado', 'invitado', NULL, NULL, NULL),
(30, 'e10adc3949ba59abbe56e057f20f883e', 'Mariano', 'Carabajal', NULL, NULL, NULL),
(31, 'e10adc3949ba59abbe56e057f20f883e', 'fabian', 'mayoral', NULL, NULL, NULL),
(32, 'e10adc3949ba59abbe56e057f20f883e', 'fabian', 'mayoral', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_token_registro`
--

CREATE TABLE `usuario_token_registro` (
  `id_usuario` int(11) NOT NULL,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_token_registro`
--

INSERT INTO `usuario_token_registro` (`id_usuario`, `token`) VALUES
(20, 'da933cbf1ef5d1d54c671147dcdb521e4993063d'),
(24, 'faa329b358b9c9a76ef42c45f7a261f077569abc'),
(25, '3e690eadaca6975da0ad83553d8d38b3f77b382e'),
(26, '79b1c5b15659dbac4a3308790282aa59710f3741'),
(27, '4c927a277ca52a9875745416720edcb3a5e3416e'),
(28, '1c69d7d270a65ed73d532bf7c39f794f4a25f02c');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caracteristica`
--
ALTER TABLE `caracteristica`
  ADD PRIMARY KEY (`id_caracteristica`);

--
-- Indices de la tabla `combo`
--
ALTER TABLE `combo`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `combo_producto`
--
ALTER TABLE `combo_producto`
  ADD PRIMARY KEY (`id_producto_combo`,`id_producto_componente`),
  ADD KEY `fk_combo_producto_01_idx` (`id_producto_componente`),
  ADD KEY `fk_combo_producto_02_idx` (`id_producto_combo`);

--
-- Indices de la tabla `forma_entrega`
--
ALTER TABLE `forma_entrega`
  ADD PRIMARY KEY (`id_forma_entrega`);

--
-- Indices de la tabla `forma_pago`
--
ALTER TABLE `forma_pago`
  ADD PRIMARY KEY (`id_forma_pago`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `grupo_ingrediente`
--
ALTER TABLE `grupo_ingrediente`
  ADD PRIMARY KEY (`id_ingrediente`,`id_grupo`),
  ADD KEY `fk_grupo_ingrediente_01_idx` (`id_ingrediente`),
  ADD KEY `fk_grupo_ingrediente_02_idx` (`id_grupo`);

--
-- Indices de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`id_ingrediente`);

--
-- Indices de la tabla `ingrediente_estado`
--
ALTER TABLE `ingrediente_estado`
  ADD PRIMARY KEY (`id_ingrediente_estado`);

--
-- Indices de la tabla `ingrediente_estado_sucursal`
--
ALTER TABLE `ingrediente_estado_sucursal`
  ADD PRIMARY KEY (`id_ingrediente`,`id_sucursal`,`id_ingrediente_estado`),
  ADD KEY `fk_ingrediente_estado_sucursal_01_idx` (`id_sucursal`),
  ADD KEY `fk_ingrediente_estado_sucursal_02_idx` (`id_ingrediente_estado`);

--
-- Indices de la tabla `log_sp`
--
ALTER TABLE `log_sp`
  ADD PRIMARY KEY (`id_log_sp`),
  ADD KEY `fk_log_sp_01_idx` (`id_usuario`);

--
-- Indices de la tabla `pago_mercadopago`
--
ALTER TABLE `pago_mercadopago`
  ADD PRIMARY KEY (`id_pago_online`);

--
-- Indices de la tabla `pago_online`
--
ALTER TABLE `pago_online`
  ADD PRIMARY KEY (`id_pago_online`),
  ADD KEY `fk_pago_online_01_idx` (`id_pedido`),
  ADD KEY `fk_pago_online_02_idx` (`id_pago_online_estado`);

--
-- Indices de la tabla `pago_online_estado`
--
ALTER TABLE `pago_online_estado`
  ADD PRIMARY KEY (`id_pago_online_estado`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedido_01_idx` (`id_pedido_estado`),
  ADD KEY `fk_pedido_02_idx` (`id_sucursal`),
  ADD KEY `fk_pedido_03_idx` (`id_usuario`),
  ADD KEY `fk_pedido_04_idx` (`id_forma_pago`),
  ADD KEY `fk_pedido_05_idx` (`id_forma_entrega`);

--
-- Indices de la tabla `pedido_delivery`
--
ALTER TABLE `pedido_delivery`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `pedido_estado`
--
ALTER TABLE `pedido_estado`
  ADD PRIMARY KEY (`id_pedido_estado`),
  ADD KEY `fk_pedido_estado_pedido_01_idx` (`id_pedido_estado_siguiente`);

--
-- Indices de la tabla `pedido_estado_historico`
--
ALTER TABLE `pedido_estado_historico`
  ADD PRIMARY KEY (`id_pedido`,`id_pedido_estado`),
  ADD KEY `fk_pedido_estado_historico_01_idx` (`id_pedido_estado`),
  ADD KEY `fk_pedido_estado_historico_02_idx` (`id_usuario`);

--
-- Indices de la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  ADD PRIMARY KEY (`id_pedido_producto`),
  ADD KEY `fk_pedido_producto_01_idx` (`id_producto`),
  ADD KEY `fk_pedido_producto_02_idx` (`id_pedido`);

--
-- Indices de la tabla `pedido_producto_ingrediente`
--
ALTER TABLE `pedido_producto_ingrediente`
  ADD PRIMARY KEY (`id_pedido_producto`,`id_ingrediente`),
  ADD KEY `fk_pedido_producto_ingrediente_01_idx` (`id_pedido_producto`) USING BTREE,
  ADD KEY `fk_pedido_producto_ingrediente_02_idx` (`id_ingrediente`) USING BTREE,
  ADD KEY `fk_pedido_producto_ingrediente_03_idx` (`id_grupo`);

--
-- Indices de la tabla `pedido_token`
--
ALTER TABLE `pedido_token`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_producto_01_idx` (`id_producto_tipo`);

--
-- Indices de la tabla `producto_caracteristica`
--
ALTER TABLE `producto_caracteristica`
  ADD PRIMARY KEY (`id_producto`,`id_caracteristica`),
  ADD KEY `fk_producto_caracteristica_01_idx` (`id_caracteristica`),
  ADD KEY `fk_producto_caracteristica_02_idx` (`id_producto`);

--
-- Indices de la tabla `producto_dia`
--
ALTER TABLE `producto_dia`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `producto_estado`
--
ALTER TABLE `producto_estado`
  ADD PRIMARY KEY (`id_producto_estado`);

--
-- Indices de la tabla `producto_estado_sucursal`
--
ALTER TABLE `producto_estado_sucursal`
  ADD PRIMARY KEY (`id_producto`,`id_sucursal`,`id_producto_estado`),
  ADD KEY `fk_producto_estado_sucursal_01_idx` (`id_sucursal`),
  ADD KEY `fk_producto_estado_sucursal_02_idx` (`id_producto_estado`);

--
-- Indices de la tabla `producto_grupo`
--
ALTER TABLE `producto_grupo`
  ADD PRIMARY KEY (`id_producto`,`id_grupo`),
  ADD KEY `fk_producto_grupo_01_idx` (`id_grupo`);

--
-- Indices de la tabla `producto_grupo_ingrediente`
--
ALTER TABLE `producto_grupo_ingrediente`
  ADD PRIMARY KEY (`id_producto`,`id_grupo`,`id_ingrediente`),
  ADD KEY `fk_producto_grupo_ingrediente_01_idx` (`id_ingrediente`),
  ADD KEY `fk_producto_grupo_ingrediente_02_idx` (`id_producto`,`id_grupo`);

--
-- Indices de la tabla `producto_ingrediente`
--
ALTER TABLE `producto_ingrediente`
  ADD PRIMARY KEY (`id_producto`,`id_ingrediente`),
  ADD KEY `fk_producto_ingrediente_01_idx` (`id_ingrediente`),
  ADD KEY `fk_producto_ingrediente_02_idx` (`id_producto`);

--
-- Indices de la tabla `producto_tipo`
--
ALTER TABLE `producto_tipo`
  ADD PRIMARY KEY (`id_producto_tipo`);

--
-- Indices de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`id_sucursal`);

--
-- Indices de la tabla `sucursal_horario`
--
ALTER TABLE `sucursal_horario`
  ADD PRIMARY KEY (`id_horario`),
  ADD KEY `fk_horarios_01_idx` (`id_sucursal`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indices de la tabla `usuario_registrado`
--
ALTER TABLE `usuario_registrado`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `usuario_token_registro`
--
ALTER TABLE `usuario_token_registro`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caracteristica`
--
ALTER TABLE `caracteristica`
  MODIFY `id_caracteristica` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  MODIFY `id_ingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `log_sp`
--
ALTER TABLE `log_sp`
  MODIFY `id_log_sp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago_online`
--
ALTER TABLE `pago_online`
  MODIFY `id_pago_online` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  MODIFY `id_pedido_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `producto_tipo`
--
ALTER TABLE `producto_tipo`
  MODIFY `id_producto_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  MODIFY `id_sucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sucursal_horario`
--
ALTER TABLE `sucursal_horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `combo`
--
ALTER TABLE `combo`
  ADD CONSTRAINT `fk_combo_01` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `combo_producto`
--
ALTER TABLE `combo_producto`
  ADD CONSTRAINT `fk_combo_producto_01` FOREIGN KEY (`id_producto_combo`) REFERENCES `combo` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_combo_producto_02` FOREIGN KEY (`id_producto_componente`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `grupo_ingrediente`
--
ALTER TABLE `grupo_ingrediente`
  ADD CONSTRAINT `fk_grupo_ingrediente_01` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id_ingrediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_grupo_ingrediente_02` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ingrediente_estado_sucursal`
--
ALTER TABLE `ingrediente_estado_sucursal`
  ADD CONSTRAINT `fk_ingrediente_estado_sucursal_01` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id_ingrediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingrediente_estado_sucursal_02` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingrediente_estado_sucursal_03` FOREIGN KEY (`id_ingrediente_estado`) REFERENCES `ingrediente_estado` (`id_ingrediente_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `log_sp`
--
ALTER TABLE `log_sp`
  ADD CONSTRAINT `fk_log_sp_01` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pago_mercadopago`
--
ALTER TABLE `pago_mercadopago`
  ADD CONSTRAINT `fk_pago_mercadopago_01` FOREIGN KEY (`id_pago_online`) REFERENCES `pago_online` (`id_pago_online`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pago_online`
--
ALTER TABLE `pago_online`
  ADD CONSTRAINT `fk_pago_online_01` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pago_online_02` FOREIGN KEY (`id_pago_online_estado`) REFERENCES `pago_online_estado` (`id_pago_online_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_01` FOREIGN KEY (`id_pedido_estado`) REFERENCES `pedido_estado` (`id_pedido_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_02` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_03` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_04` FOREIGN KEY (`id_forma_pago`) REFERENCES `forma_pago` (`id_forma_pago`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_05` FOREIGN KEY (`id_forma_entrega`) REFERENCES `forma_entrega` (`id_forma_entrega`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido_delivery`
--
ALTER TABLE `pedido_delivery`
  ADD CONSTRAINT `fk_pedido_delivery_01` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido_estado`
--
ALTER TABLE `pedido_estado`
  ADD CONSTRAINT `fk_pedido_estado_01` FOREIGN KEY (`id_pedido_estado_siguiente`) REFERENCES `pedido_estado` (`id_pedido_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido_estado_historico`
--
ALTER TABLE `pedido_estado_historico`
  ADD CONSTRAINT `fk_pedido_estado_historico_01` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_estado_historico_02` FOREIGN KEY (`id_pedido_estado`) REFERENCES `pedido_estado` (`id_pedido_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_estado_historico_03` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  ADD CONSTRAINT `fk_pedido_producto_01` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_producto_02` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido_producto_ingrediente`
--
ALTER TABLE `pedido_producto_ingrediente`
  ADD CONSTRAINT `fk_pedido_producto_has_ingrediente_ingrediente1` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id_ingrediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_producto_ingrediente_01` FOREIGN KEY (`id_pedido_producto`) REFERENCES `pedido_producto` (`id_pedido_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_producto_ingrediente_02` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id_ingrediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_producto_ingrediente_03` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido_token`
--
ALTER TABLE `pedido_token`
  ADD CONSTRAINT `fk_pedido_token_01` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_01` FOREIGN KEY (`id_producto_tipo`) REFERENCES `producto_tipo` (`id_producto_tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto_caracteristica`
--
ALTER TABLE `producto_caracteristica`
  ADD CONSTRAINT `fk_producto_caracteristica_01` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_caracteristica_02` FOREIGN KEY (`id_caracteristica`) REFERENCES `caracteristica` (`id_caracteristica`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto_dia`
--
ALTER TABLE `producto_dia`
  ADD CONSTRAINT `fk_producto_dia_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto_estado_sucursal`
--
ALTER TABLE `producto_estado_sucursal`
  ADD CONSTRAINT `fk_producto_estado_sucursal_01` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_estado_sucursal_02` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_estado_sucursal_03` FOREIGN KEY (`id_producto_estado`) REFERENCES `producto_estado` (`id_producto_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto_grupo`
--
ALTER TABLE `producto_grupo`
  ADD CONSTRAINT `fk_producto_grupo_01` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_grupo_02` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto_ingrediente`
--
ALTER TABLE `producto_ingrediente`
  ADD CONSTRAINT `fk_producto_ingrediente_01` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_ingrediente_02` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id_ingrediente`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
