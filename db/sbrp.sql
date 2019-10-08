-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-10-2019 a las 22:31:28
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sbrp`
--
CREATE DATABASE IF NOT EXISTS `sbrp` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sbrp`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albaranes_compra`
--
-- Creación: 17-09-2019 a las 13:19:37
--

DROP TABLE IF EXISTS `albaranes_compra`;
CREATE TABLE `albaranes_compra` (
  `ID` int(11) NOT NULL,
  `ID_SERIE` int(11) NOT NULL,
  `ID_PROVEEDOR` int(11) DEFAULT NULL,
  `FECHA` date DEFAULT NULL,
  `ID_ALBARAN_PROVEEDOR` varchar(20) DEFAULT NULL,
  `ID_METODO_PAGO` int(11) DEFAULT NULL,
  `DESCUENTO_GENERAL` decimal(6,3) DEFAULT NULL,
  `ID_SERIE_FACTURA` int(11) DEFAULT NULL,
  `ID_FACTURA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `albaranes_compra`:
--   `ID_SERIE`
--       `series` -> `ID`
--   `ID_PROVEEDOR`
--       `proveedores` -> `ID`
--   `ID_METODO_PAGO`
--       `metodos_pago` -> `ID`
--   `ID_SERIE_FACTURA`
--       `facturas_compra` -> `ID_SERIE`
--   `ID_FACTURA`
--       `facturas_compra` -> `ID`
--

--
-- Disparadores `albaranes_compra`
--
DROP TRIGGER IF EXISTS `del_alb_regs`;
DELIMITER $$
CREATE TRIGGER `del_alb_regs` BEFORE UPDATE ON `albaranes_compra` FOR EACH ROW DELETE FROM registros_albaran_compra
WHERE id_albaran = OLD.id AND id_serie_albaran = OLD.id_serie
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `albaranes_venta`
--
-- Creación: 16-09-2019 a las 16:41:36
--

DROP TABLE IF EXISTS `albaranes_venta`;
CREATE TABLE `albaranes_venta` (
  `ID` int(11) NOT NULL,
  `ID_SERIE` int(11) NOT NULL,
  `ID_CLIENTE` int(11) NOT NULL,
  `ID_METODO_PAGO` int(11) DEFAULT NULL,
  `FECHA` date DEFAULT NULL,
  `DESCUENTO_GENERAL` decimal(3,2) DEFAULT NULL,
  `ID_SERIE_FACTURA` int(11) DEFAULT NULL,
  `ID_FACTURA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `albaranes_venta`:
--   `ID_SERIE`
--       `series` -> `ID`
--   `id_cliente`
--       `clientes` -> `id`
--   `ID_METODO_PAGO`
--       `metodos_pago` -> `ID`
--   `ID_SERIE_FACTURA`
--       `facturas_venta` -> `ID_SERIE`
--   `ID_FACTURA`
--       `facturas_venta` -> `ID`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--
-- Creación: 16-09-2019 a las 21:24:33
--

DROP TABLE IF EXISTS `articulos`;
CREATE TABLE `articulos` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `DESCRIPCION` varchar(100) DEFAULT NULL,
  `ID_CATEGORIA` int(11) DEFAULT NULL,
  `ID_PROVEEDOR` int(11) DEFAULT NULL,
  `CANTIDAD_MASTER` decimal(5,2) DEFAULT NULL,
  `IVA` decimal(5,2) DEFAULT NULL,
  `COSTE_ANTERIOR` decimal(8,3) DEFAULT '0.000',
  `COSTE` decimal(8,3) DEFAULT NULL,
  `PVP_DETALLE` decimal(8,3) DEFAULT NULL,
  `PVP_MAYOR` decimal(8,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `articulos`:
--   `ID_CATEGORIA`
--       `categorias` -> `ID`
--   `ID_PROVEEDOR`
--       `proveedores` -> `ID`
--

--
-- Disparadores `articulos`
--
DROP TRIGGER IF EXISTS `set_precio_anterior`;
DELIMITER $$
CREATE TRIGGER `set_precio_anterior` BEFORE UPDATE ON `articulos` FOR EACH ROW BEGIN
	IF (NEW.COSTE <> OLD.COSTE) THEN
    SET NEW.coste_anterior = OLD.coste;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--
-- Creación: 27-08-2019 a las 05:57:31
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `DESCRIPCION` varchar(100) DEFAULT NULL,
  `IVA_POR_DEFECTO` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `categorias`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--
-- Creación: 31-08-2019 a las 22:34:24
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `NOMBRE_COMERCIAL` varchar(50) DEFAULT NULL,
  `CIF` varchar(10) DEFAULT NULL,
  `PERSONA_CONTACTO` varchar(50) DEFAULT NULL,
  `DIRECCION` varchar(50) DEFAULT NULL,
  `TELEFONO` varchar(20) DEFAULT NULL,
  `FAX` varchar(20) DEFAULT NULL,
  `PRECIO_ALBARAN` tinyint(1) DEFAULT '0',
  `FACTURA_AUTOMATICA` tinyint(1) DEFAULT '0',
  `ID_METODO_PAGO` int(11) DEFAULT NULL,
  `CUENTA_BANCARIA` varchar(30) DEFAULT NULL,
  `SITIO_WEB` varchar(30) DEFAULT NULL,
  `EMAIL` varchar(30) DEFAULT NULL,
  `FECHA_NACIMIENTO` date DEFAULT NULL,
  `FECHA_CAPTACION` date DEFAULT NULL,
  `DESCUENTO` decimal(5,2) DEFAULT NULL,
  `INFORMACION_ADICIONAL` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `clientes`:
--   `ID_METODO_PAGO`
--       `metodos_pago` -> `ID`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_compra`
--
-- Creación: 01-04-2019 a las 11:59:28
--

DROP TABLE IF EXISTS `facturas_compra`;
CREATE TABLE `facturas_compra` (
  `ID` int(11) NOT NULL,
  `ID_SERIE` int(11) NOT NULL,
  `ID_PROVEEDOR` int(11) NOT NULL,
  `FECHA` date NOT NULL,
  `ID_FACTURA_PROVEEDOR` varchar(20) DEFAULT NULL,
  `ID_METODO_PAGO` int(11) DEFAULT NULL,
  `DESCUENTO_GENERAL` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `facturas_compra`:
--   `ID_SERIE`
--       `series` -> `ID`
--   `ID_PROVEEDOR`
--       `proveedores` -> `ID`
--   `ID_METODO_PAGO`
--       `metodos_pago` -> `ID`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_venta`
--
-- Creación: 01-04-2019 a las 11:59:28
--

DROP TABLE IF EXISTS `facturas_venta`;
CREATE TABLE `facturas_venta` (
  `ID` int(11) NOT NULL,
  `ID_SERIE` int(11) NOT NULL,
  `ID_CLIENTE` int(11) NOT NULL,
  `FECHA` date DEFAULT NULL,
  `ID_METODO_PAGO` int(11) DEFAULT NULL,
  `DESCUENTO_GENERAL` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `facturas_venta`:
--   `ID_SERIE`
--       `series` -> `ID`
--   `ID_CLIENTE`
--       `clientes` -> `ID`
--   `ID_METODO_PAGO`
--       `metodos_pago` -> `ID`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `global_settings`
--
-- Creación: 02-10-2019 a las 16:07:38
--

DROP TABLE IF EXISTS `global_settings`;
CREATE TABLE `global_settings` (
  `serie_actual` int(11) DEFAULT NULL,
  `logo` blob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `global_settings`:
--   `serie_actual`
--       `series` -> `ID`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--
-- Creación: 01-04-2019 a las 11:59:28
--

DROP TABLE IF EXISTS `metodos_pago`;
CREATE TABLE `metodos_pago` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `DESCRIPCION` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `metodos_pago`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_venta`
--
-- Creación: 01-04-2019 a las 11:59:28
--

DROP TABLE IF EXISTS `pedidos_venta`;
CREATE TABLE `pedidos_venta` (
  `ID_SERIE` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `ID_CLIENTE` int(11) NOT NULL,
  `FECHA_PEDIDO` date DEFAULT NULL,
  `FECHA_ENTREGA` date DEFAULT NULL,
  `ID_SERIE_ALBARAN` int(11) DEFAULT NULL,
  `ID_ALBARAN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `pedidos_venta`:
--   `ID_SERIE`
--       `series` -> `ID`
--   `ID_CLIENTE`
--       `clientes` -> `ID`
--   `ID_SERIE_ALBARAN`
--       `albaranes_venta` -> `ID_SERIE`
--   `ID_ALBARAN`
--       `albaranes_venta` -> `ID`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--
-- Creación: 24-04-2019 a las 18:23:59
--

DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `CIF` varchar(10) DEFAULT NULL,
  `PERSONA_CONTACTO` varchar(50) DEFAULT NULL,
  `DIRECCION` varchar(50) DEFAULT NULL,
  `TELEFONO` varchar(15) DEFAULT NULL,
  `FAX` varchar(15) DEFAULT NULL,
  `ID_METODO_PAGO` int(11) DEFAULT NULL,
  `CUENTA_BANCARIA` varchar(30) DEFAULT NULL,
  `SITIO_WEB` varchar(30) DEFAULT NULL,
  `EMAIL` varchar(30) DEFAULT NULL,
  `INFORMACION_ADICIONAL` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `proveedores`:
--   `ID_METODO_PAGO`
--       `metodos_pago` -> `ID`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros_albaran_compra`
--
-- Creación: 17-09-2019 a las 16:04:11
--

DROP TABLE IF EXISTS `registros_albaran_compra`;
CREATE TABLE `registros_albaran_compra` (
  `N` int(11) NOT NULL,
  `ID_SERIE_ALBARAN` int(11) NOT NULL,
  `ID_ALBARAN` int(11) NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  `NOMBRE_REGISTRO` varchar(30) DEFAULT NULL,
  `IVA` decimal(6,3) DEFAULT NULL,
  `CANTIDAD_MASTER` decimal(5,3) DEFAULT NULL,
  `PRECIO_COSTE` decimal(5,3) DEFAULT NULL,
  `DESCUENTO` decimal(6,3) DEFAULT NULL,
  `CANTIDAD` decimal(5,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `registros_albaran_compra`:
--   `ID_SERIE_ALBARAN`
--       `albaranes_compra` -> `ID_SERIE`
--   `ID_ALBARAN`
--       `albaranes_compra` -> `ID`
--   `ID_ARTICULO`
--       `articulos` -> `ID`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros_albaran_venta`
--
-- Creación: 17-09-2019 a las 16:06:07
--

DROP TABLE IF EXISTS `registros_albaran_venta`;
CREATE TABLE `registros_albaran_venta` (
  `N` int(11) NOT NULL,
  `ID_SERIE_ALBARAN` int(11) NOT NULL,
  `ID_ALBARAN` int(11) NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  `NOMBRE_REGISTRO` varchar(30) DEFAULT NULL,
  `IVA` decimal(3,2) DEFAULT NULL,
  `CANTIDAD_MASTER` decimal(3,2) DEFAULT NULL,
  `PRECIO_COSTE` decimal(5,3) DEFAULT NULL,
  `DESCUENTO` decimal(3,2) DEFAULT NULL,
  `CANTIDAD` decimal(5,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `registros_albaran_venta`:
--   `ID_SERIE_ALBARAN`
--       `albaranes_venta` -> `ID_SERIE`
--   `ID_ALBARAN`
--       `albaranes_venta` -> `ID`
--   `ID_ARTICULO`
--       `articulos` -> `ID`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros_pedido_venta`
--
-- Creación: 17-09-2019 a las 16:06:17
--

DROP TABLE IF EXISTS `registros_pedido_venta`;
CREATE TABLE `registros_pedido_venta` (
  `N` int(11) NOT NULL,
  `ID_SERIE_PEDIDO` int(11) NOT NULL,
  `ID_PEDIDO` int(11) NOT NULL,
  `ID_ARTICULO` int(11) NOT NULL,
  `NOMBRE_REGISTRO` varchar(30) DEFAULT NULL,
  `CANTIDAD_MASTER` decimal(3,2) DEFAULT NULL,
  `CANTIDAD` decimal(5,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `registros_pedido_venta`:
--   `ID_SERIE_PEDIDO`
--       `pedidos_venta` -> `ID_SERIE`
--   `ID_PEDIDO`
--       `pedidos_venta` -> `ID`
--   `ID_ARTICULO`
--       `articulos` -> `ID`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `series`
--
-- Creación: 01-04-2019 a las 11:59:28
--

DROP TABLE IF EXISTS `series`;
CREATE TABLE `series` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `DESCRIPCION` varchar(100) DEFAULT NULL,
  `FECHA_DESDE` date DEFAULT NULL,
  `FECHA_HASTA` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `series`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_usuario`
--
-- Creación: 19-08-2019 a las 23:31:48
--

DROP TABLE IF EXISTS `tipos_usuario`;
CREATE TABLE `tipos_usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `tipos_usuario`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--
-- Creación: 01-04-2019 a las 11:59:28
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `nombre` varchar(10) NOT NULL,
  `apellido` varchar(10) DEFAULT NULL,
  `contrasena` varchar(10) DEFAULT NULL,
  `id_tipo_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELACIONES PARA LA TABLA `usuarios`:
--   `id_tipo_usuario`
--       `tipos_usuario` -> `id`
--

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `albaranes_compra`
--
ALTER TABLE `albaranes_compra`
  ADD PRIMARY KEY (`ID_SERIE`,`ID`),
  ADD KEY `ID_PROVEEDOR` (`ID_PROVEEDOR`),
  ADD KEY `ID_METODO_PAGO` (`ID_METODO_PAGO`),
  ADD KEY `ID_FACTURA` (`ID_SERIE_FACTURA`,`ID_FACTURA`) USING BTREE;

--
-- Indices de la tabla `albaranes_venta`
--
ALTER TABLE `albaranes_venta`
  ADD PRIMARY KEY (`ID`,`ID_SERIE`),
  ADD KEY `ID_SERIE` (`ID_SERIE`),
  ADD KEY `ID_METODO_PAGO` (`ID_METODO_PAGO`),
  ADD KEY `ID_SERIE_FACTURA` (`ID_SERIE_FACTURA`,`ID_FACTURA`),
  ADD KEY `albaranes_venta_ibfk_2` (`ID_CLIENTE`);

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_CATEGORIA` (`ID_CATEGORIA`),
  ADD KEY `ID_PROVEEDOR` (`ID_PROVEEDOR`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ID_METODO_PAGO` (`ID_METODO_PAGO`);

--
-- Indices de la tabla `facturas_compra`
--
ALTER TABLE `facturas_compra`
  ADD PRIMARY KEY (`ID_SERIE`,`ID`),
  ADD KEY `ID_PROVEEDOR` (`ID_PROVEEDOR`),
  ADD KEY `ID_METODO_PAGO` (`ID_METODO_PAGO`);

--
-- Indices de la tabla `facturas_venta`
--
ALTER TABLE `facturas_venta`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_SERIE` (`ID_SERIE`),
  ADD KEY `ID_CLIENTE` (`ID_CLIENTE`),
  ADD KEY `ID_METODO_PAGO` (`ID_METODO_PAGO`);

--
-- Indices de la tabla `global_settings`
--
ALTER TABLE `global_settings`
  ADD KEY `serie_actual` (`serie_actual`);

--
-- Indices de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `pedidos_venta`
--
ALTER TABLE `pedidos_venta`
  ADD PRIMARY KEY (`ID_SERIE`,`ID`),
  ADD KEY `ID_CLIENTE` (`ID_CLIENTE`),
  ADD KEY `ID_SERIE_ALBARAN` (`ID_SERIE_ALBARAN`),
  ADD KEY `ID_ALBARAN` (`ID_ALBARAN`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD KEY `ID_METODO_PAGO` (`ID_METODO_PAGO`);

--
-- Indices de la tabla `registros_albaran_compra`
--
ALTER TABLE `registros_albaran_compra`
  ADD PRIMARY KEY (`ID_SERIE_ALBARAN`,`ID_ALBARAN`,`N`),
  ADD KEY `ID_ARTICULO` (`ID_ARTICULO`);

--
-- Indices de la tabla `registros_albaran_venta`
--
ALTER TABLE `registros_albaran_venta`
  ADD PRIMARY KEY (`ID_SERIE_ALBARAN`,`ID_ALBARAN`,`N`),
  ADD KEY `ID_ARTICULO` (`ID_ARTICULO`);

--
-- Indices de la tabla `registros_pedido_venta`
--
ALTER TABLE `registros_pedido_venta`
  ADD PRIMARY KEY (`ID_SERIE_PEDIDO`,`ID_PEDIDO`,`N`),
  ADD KEY `ID_ARTICULO` (`ID_ARTICULO`);

--
-- Indices de la tabla `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tipos_usuario`
--
ALTER TABLE `tipos_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`nombre`),
  ADD KEY `id_tipo_usuario` (`id_tipo_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tipos_usuario`
--
ALTER TABLE `tipos_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `albaranes_compra`
--
ALTER TABLE `albaranes_compra`
  ADD CONSTRAINT `albaranes_compra_ibfk_1` FOREIGN KEY (`ID_SERIE`) REFERENCES `series` (`ID`),
  ADD CONSTRAINT `albaranes_compra_ibfk_2` FOREIGN KEY (`ID_PROVEEDOR`) REFERENCES `proveedores` (`ID`),
  ADD CONSTRAINT `albaranes_compra_ibfk_3` FOREIGN KEY (`ID_METODO_PAGO`) REFERENCES `metodos_pago` (`ID`),
  ADD CONSTRAINT `albaranes_compra_ibfk_4` FOREIGN KEY (`ID_SERIE_FACTURA`,`ID_FACTURA`) REFERENCES `facturas_compra` (`ID_SERIE`, `ID`);

--
-- Filtros para la tabla `albaranes_venta`
--
ALTER TABLE `albaranes_venta`
  ADD CONSTRAINT `albaranes_venta_ibfk_1` FOREIGN KEY (`ID_SERIE`) REFERENCES `series` (`ID`),
  ADD CONSTRAINT `albaranes_venta_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `albaranes_venta_ibfk_3` FOREIGN KEY (`ID_METODO_PAGO`) REFERENCES `metodos_pago` (`ID`),
  ADD CONSTRAINT `albaranes_venta_ibfk_4` FOREIGN KEY (`ID_SERIE_FACTURA`,`ID_FACTURA`) REFERENCES `facturas_venta` (`ID_SERIE`, `ID`);

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`ID_CATEGORIA`) REFERENCES `categorias` (`ID`),
  ADD CONSTRAINT `articulos_ibfk_2` FOREIGN KEY (`ID_PROVEEDOR`) REFERENCES `proveedores` (`ID`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`ID_METODO_PAGO`) REFERENCES `metodos_pago` (`ID`);

--
-- Filtros para la tabla `facturas_compra`
--
ALTER TABLE `facturas_compra`
  ADD CONSTRAINT `facturas_compra_ibfk_1` FOREIGN KEY (`ID_SERIE`) REFERENCES `series` (`ID`),
  ADD CONSTRAINT `facturas_compra_ibfk_2` FOREIGN KEY (`ID_PROVEEDOR`) REFERENCES `proveedores` (`ID`),
  ADD CONSTRAINT `facturas_compra_ibfk_3` FOREIGN KEY (`ID_METODO_PAGO`) REFERENCES `metodos_pago` (`ID`);

--
-- Filtros para la tabla `facturas_venta`
--
ALTER TABLE `facturas_venta`
  ADD CONSTRAINT `facturas_venta_ibfk_1` FOREIGN KEY (`ID_SERIE`) REFERENCES `series` (`ID`),
  ADD CONSTRAINT `facturas_venta_ibfk_2` FOREIGN KEY (`ID_CLIENTE`) REFERENCES `clientes` (`ID`),
  ADD CONSTRAINT `facturas_venta_ibfk_3` FOREIGN KEY (`ID_METODO_PAGO`) REFERENCES `metodos_pago` (`ID`);

--
-- Filtros para la tabla `global_settings`
--
ALTER TABLE `global_settings`
  ADD CONSTRAINT `global_settings_ibfk_1` FOREIGN KEY (`serie_actual`) REFERENCES `series` (`ID`);

--
-- Filtros para la tabla `pedidos_venta`
--
ALTER TABLE `pedidos_venta`
  ADD CONSTRAINT `pedidos_venta_ibfk_1` FOREIGN KEY (`ID_SERIE`) REFERENCES `series` (`ID`),
  ADD CONSTRAINT `pedidos_venta_ibfk_2` FOREIGN KEY (`ID_CLIENTE`) REFERENCES `clientes` (`ID`),
  ADD CONSTRAINT `pedidos_venta_ibfk_3` FOREIGN KEY (`ID_SERIE_ALBARAN`) REFERENCES `albaranes_venta` (`ID_SERIE`),
  ADD CONSTRAINT `pedidos_venta_ibfk_4` FOREIGN KEY (`ID_ALBARAN`) REFERENCES `albaranes_venta` (`ID`);

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `proveedores_ibfk_1` FOREIGN KEY (`ID_METODO_PAGO`) REFERENCES `metodos_pago` (`ID`);

--
-- Filtros para la tabla `registros_albaran_compra`
--
ALTER TABLE `registros_albaran_compra`
  ADD CONSTRAINT `registros_albaran_compra_ibfk_1` FOREIGN KEY (`ID_SERIE_ALBARAN`,`ID_ALBARAN`) REFERENCES `albaranes_compra` (`ID_SERIE`, `ID`),
  ADD CONSTRAINT `registros_albaran_compra_ibfk_2` FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulos` (`ID`);

--
-- Filtros para la tabla `registros_albaran_venta`
--
ALTER TABLE `registros_albaran_venta`
  ADD CONSTRAINT `registros_albaran_venta_ibfk_1` FOREIGN KEY (`ID_SERIE_ALBARAN`,`ID_ALBARAN`) REFERENCES `albaranes_venta` (`ID_SERIE`, `ID`),
  ADD CONSTRAINT `registros_albaran_venta_ibfk_2` FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulos` (`ID`);

--
-- Filtros para la tabla `registros_pedido_venta`
--
ALTER TABLE `registros_pedido_venta`
  ADD CONSTRAINT `registros_pedido_venta_ibfk_1` FOREIGN KEY (`ID_SERIE_PEDIDO`,`ID_PEDIDO`) REFERENCES `pedidos_venta` (`ID_SERIE`, `ID`),
  ADD CONSTRAINT `registros_pedido_venta_ibfk_2` FOREIGN KEY (`ID_ARTICULO`) REFERENCES `articulos` (`ID`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipos_usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
