-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 06-01-2018 a las 18:24:47
-- Versión del servidor: 5.7.20-0ubuntu0.16.04.1
-- Versión de PHP: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lemonclub`
--
CREATE DATABASE IF NOT EXISTS `lemonclub` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `lemonclub`;

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
-- Estructura de tabla para la tabla `ingrediente`
--

CREATE TABLE `ingrediente` (
  `id_ingrediente` int(11) NOT NULL,
  `id_ingrediente_tipo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `path_imagen` varchar(512) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `calorias` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Estructura de tabla para la tabla `ingrediente_tipo`
--

CREATE TABLE `ingrediente_tipo` (
  `id_ingrediente_tipo` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente_tipo_cantidad`
--

CREATE TABLE `ingrediente_tipo_cantidad` (
  `id_producto` int(11) NOT NULL,
  `id_ingrediente_tipo` int(11) NOT NULL,
  `cantidad_minima` int(11) NOT NULL,
  `cantidad_máxima` int(11) NOT NULL
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `fecha_pedido` datetime DEFAULT NULL,
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
(1, NULL, 1, 1, NULL, NULL, NULL, NULL),
(2, '2018-01-06 16:36:39', 2, 1, 2, 1, 1, '2018-01-06 17:00:00'),
(3, NULL, 1, 1, NULL, NULL, NULL, NULL),
(4, NULL, 1, 1, 3, NULL, NULL, NULL),
(5, '2018-01-06 16:56:27', 2, 1, 4, 1, 1, '2018-01-06 17:00:00'),
(6, NULL, 1, 1, NULL, NULL, NULL, NULL),
(7, '2018-01-06 17:12:30', 2, 1, 5, 1, 1, '2018-01-06 18:00:00'),
(8, NULL, 1, 1, NULL, NULL, NULL, NULL);

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
  `cantidad` int(11) NOT NULL DEFAULT '1',
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedido_producto`
--

INSERT INTO `pedido_producto` (`id_pedido_producto`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(3, 1, 2, 1, '90.00'),
(4, 2, 7, 2, '80.00'),
(5, 4, 2, 1, '90.00'),
(6, 4, 9, 1, '100.00'),
(7, 5, 11, 1, '130.00'),
(8, 5, 1, 1, '80.00'),
(9, 6, 11, 1, '130.00'),
(10, 6, 1, 1, '80.00'),
(11, 6, 5, 1, '90.00'),
(12, 7, 14, 2, '95.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_producto_ingrediente`
--

CREATE TABLE `pedido_producto_ingrediente` (
  `id_pedido_producto` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_token`
--

CREATE TABLE `pedido_token` (
  `id_pedido` int(11) NOT NULL,
  `token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedido_token`
--

INSERT INTO `pedido_token` (`id_pedido`, `token`) VALUES
(1, 'c01990e82e921ac6bd9150c9dba36b8406ae0c4c'),
(2, 'f98f590073f8ac089ecb5c820f22882d307b4e03'),
(4, '490d076c62fc1b0b1ea25253e2331176869864bd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `id_producto_tipo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `path_imagen` varchar(512) DEFAULT 'sin_imagen.jpg',
  `descripcion` varchar(2000) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `orden_aparicion_web` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `id_producto_tipo`, `nombre`, `path_imagen`, `descripcion`, `precio`, `orden_aparicion_web`) VALUES
(1, 1, 'Romano', '6c6de-romano.jpg', 'Jamón crudo, rúcula, queso tybo, tomate y queso crema', '80.00', NULL),
(2, 3, 'Pechiguitas a la plancha', '864a4-pechuguitasconensa-min.jpg', 'Pechuguitas de pollo marinadas con limón, romero y mostaza con guarnición', '90.00', NULL),
(3, 4, 'Ensalda cesar', 'c441b-ensalada-cesar-clasica-573.jpg', 'Crutones con pollo, salsa cesar', '222.00', NULL),
(4, 2, 'Ternerita y cheddar', '17817-panini.jpg', 'Ternera braseada, cebolla asada, morrón, queso cheddar y aderezo 1000 islas', '95.00', NULL),
(5, 1, 'Tuna caesar', '6e60f-cmrgmefw8aerbvi.jpg', 'Atún, apio, cebolla morada, lechuga, tomate y aderezo caesar', '90.00', NULL),
(6, 5, 'Ranchero', '0587d-huevos-rancheros-wraps1.jpg', 'Pechuga de pollo, jamón cocido, panceta crocante, tomate, lechuga y aderezo ranchero', '90.00', NULL),
(7, 2, 'Pollo y palta', '6a73a-turkey-caprese-panini.jpg', 'Pechuga de pollo, palta, cebolla morada, queso tybo, limón y mayonesa', '80.00', NULL),
(8, 3, 'Mila Napo', '399d3-milanesa-a-la_-napolitana-credit-greg-devilliers-main.jpg', 'Milanesa con salsa de tomate, queso y tomate fresco con guarnición ', '100.00', NULL),
(9, 4, 'Quinoa Kanikama palmitos', 'd9c58-db806fcfbedeed3299cbe5dd5e73aafa-quinoa-salad-bolivian-recipes.jpg', 'Mix verdes, quinoa, cherry, huevo, zanahoria, palmitos y kanikama aderezo 10000 islas', '100.00', NULL),
(10, 5, 'Tejano (HOT)', '39a94-nikklas-greek-gyros-and.jpg', 'Pechuga de pollo, panceta crocante, cebolla cocida, morrón, cheddar y salsa BBQ', '90.00', NULL),
(11, 1, 'Mar & Timo Deluxe', 'e783d-marytimodeluxe-min.jpg', 'Salmón ahumado, palta, rúcula, queso crema y nuez', '130.00', NULL),
(12, 2, 'Doble Queso y BBQ', '5a113-dobleq-min.jpg', 'Ternera braseada, queso tybo, queso cheddar, tomate, panceta crocante y BBQ', '100.00', NULL),
(13, 4, 'Ensalada Mediterranea', '7414b-ensmediterranea-min.jpg', 'Mix de hojas verdes, tomate cherry, queso en hebras, olivas negras, nueces y semillas de sesamo con aderezo de limón, oliva, mostaza y miel ', '90.00', NULL),
(14, 6, 'Wok Oriental', '4809e-wokoriental-min.jpg', 'Cebolla, morrón, zapallito, brotes de soja, arroz y pollo salteados con jengibre', '95.00', NULL),
(15, 5, 'Palta Wrap', '256b5-paltawrap-min.jpg', 'Espinaca, tomate, palta, cebolla morada, queso en hebras y pollo con mayonesa y limón', '90.00', NULL),
(16, 7, 'House Burguer', '7fdd9-houseburguer-min.jpg', 'Hamburguesa de ternera, rucula, tomate, panceta crocante, cebolla caramelizada, cheddar y aderezo 1000 islas con papas fritas bastón', '130.00', NULL);

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
  `orden_aparicion_web` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto_tipo`
--

INSERT INTO `producto_tipo` (`id_producto_tipo`, `descripcion`, `path_imagen`, `orden_aparicion_web`) VALUES
(1, 'Sandwich', 'btn_sandwich.jpg', NULL),
(2, 'Paninis', 'btn_paninis.jpg', NULL),
(3, 'Platos calientes', 'btn_platos_calientes.jpg', NULL),
(4, 'Ensaladas', 'btn_ensaladas.jpg', NULL),
(5, 'Wraps', 'btn_wraps.jpg', NULL),
(6, 'Woks', 'btn_woks.jpg', NULL),
(7, 'Hamburguesas', 'btn_hamburguesas.jpg', NULL);

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
  `registrado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `email`, `registrado`) VALUES
(1, '2adrian.magliola@gmail.com', 0),
(2, 'adrian.mag2liola@gmail.com', 0),
(3, 'adrian.ma33gliola@gmail.com', 0),
(4, 'adrian.maglio2la@gmail.com', 0),
(5, 'adrian.magliola@gmail.com', 1);

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
  `telefono` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_registrado`
--

INSERT INTO `usuario_registrado` (`id_usuario`, `password`, `nombre`, `apellido`, `direccion`, `telefono`) VALUES
(3, 'a8f5f167f44f4964e6c998dee827110c', 'Adrian', 'Matias', NULL, NULL),
(5, 'a8f5f167f44f4964e6c998dee827110c', 'Adrian', 'aaa', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_token_registro`
--

CREATE TABLE `usuario_token_registro` (
  `id_usuario` int(11) NOT NULL,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Indices de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`id_ingrediente`),
  ADD KEY `fk_ingrediente_tipo_01_idx` (`id_ingrediente_tipo`);

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
-- Indices de la tabla `ingrediente_tipo`
--
ALTER TABLE `ingrediente_tipo`
  ADD PRIMARY KEY (`id_ingrediente_tipo`);

--
-- Indices de la tabla `ingrediente_tipo_cantidad`
--
ALTER TABLE `ingrediente_tipo_cantidad`
  ADD PRIMARY KEY (`id_producto`,`id_ingrediente_tipo`),
  ADD KEY `fk_ingrediente_tipo_cantidad_01_idx` (`id_ingrediente_tipo`),
  ADD KEY `fk_ingrediente_tipo_cantidad_02_idx` (`id_producto`);

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
  ADD KEY `fk_pedido_producto_has_ingrediente_ingrediente1_idx` (`id_ingrediente`),
  ADD KEY `fk_pedido_producto_has_ingrediente_pedido_producto1_idx` (`id_pedido_producto`);

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
-- AUTO_INCREMENT de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  MODIFY `id_ingrediente` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ingrediente_tipo`
--
ALTER TABLE `ingrediente_tipo`
  MODIFY `id_ingrediente_tipo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pago_online`
--
ALTER TABLE `pago_online`
  MODIFY `id_pago_online` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  MODIFY `id_pedido_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `producto_tipo`
--
ALTER TABLE `producto_tipo`
  MODIFY `id_producto_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
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
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
-- Filtros para la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD CONSTRAINT `fk_ingrediente_tipo_01` FOREIGN KEY (`id_ingrediente_tipo`) REFERENCES `ingrediente_tipo` (`id_ingrediente_tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ingrediente_estado_sucursal`
--
ALTER TABLE `ingrediente_estado_sucursal`
  ADD CONSTRAINT `fk_ingrediente_estado_sucursal_01` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id_ingrediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingrediente_estado_sucursal_02` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingrediente_estado_sucursal_03` FOREIGN KEY (`id_ingrediente_estado`) REFERENCES `ingrediente_estado` (`id_ingrediente_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ingrediente_tipo_cantidad`
--
ALTER TABLE `ingrediente_tipo_cantidad`
  ADD CONSTRAINT `fk_ingrediente_tipo_cantidad_01` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingrediente_tipo_cantidad_02` FOREIGN KEY (`id_ingrediente_tipo`) REFERENCES `ingrediente_tipo` (`id_ingrediente_tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_pedido_producto_has_ingrediente_pedido_producto1` FOREIGN KEY (`id_pedido_producto`) REFERENCES `pedido_producto` (`id_pedido_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
-- Filtros para la tabla `producto_ingrediente`
--
ALTER TABLE `producto_ingrediente`
  ADD CONSTRAINT `fk_producto_ingrediente_01` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_ingrediente_02` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id_ingrediente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sucursal_horario`
--
ALTER TABLE `sucursal_horario`
  ADD CONSTRAINT `fk_horarios_01` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_registrado`
--
ALTER TABLE `usuario_registrado`
  ADD CONSTRAINT `fk_usuario_registrado_01` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_token_registro`
--
ALTER TABLE `usuario_token_registro`
  ADD CONSTRAINT `fk_usuario_token_registro_01` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
