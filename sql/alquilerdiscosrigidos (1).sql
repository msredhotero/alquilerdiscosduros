-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-08-2018 a las 23:09:02
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `alquilerdiscosrigidos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbalquileres`
--

CREATE TABLE IF NOT EXISTS `dbalquileres` (
`idalquiler` int(11) NOT NULL,
  `fechaentrega` date NOT NULL,
  `metodoentrega` int(11) NOT NULL,
  `refmoviles` int(11) DEFAULT NULL,
  `reftransporteterceros` int(11) DEFAULT NULL,
  `numeroguia` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechadevolucion` date DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT NULL,
  `refdiscos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbalquileresprestatarios`
--

CREATE TABLE IF NOT EXISTS `dbalquileresprestatarios` (
`idalquilerprestatario` int(11) NOT NULL,
  `refalquileres` int(11) NOT NULL,
  `refprestatarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbclientes`
--

CREATE TABLE IF NOT EXISTS `dbclientes` (
`idcliente` int(11) NOT NULL,
  `razonsocial` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `cuit` varchar(13) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(18) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `provincia` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ciudad` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dbclientes`
--

INSERT INTO `dbclientes` (`idcliente`, `razonsocial`, `cuit`, `telefono`, `email`, `direccion`, `provincia`, `ciudad`) VALUES
(1, 'Pelipedia', '20158779443', '456112378', '', '', 'bs as', 'Bahia blanca');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbdevoluciones`
--

CREATE TABLE IF NOT EXISTS `dbdevoluciones` (
`iddevolucion` int(11) NOT NULL,
  `refprestatarios` int(11) NOT NULL,
  `metodoentrega` int(11) NOT NULL,
  `refmoviles` int(11) DEFAULT NULL,
  `reftransporteterceros` int(11) DEFAULT NULL,
  `numeroguia` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechadevolucion` date NOT NULL,
  `aldeposito` bit(1) NOT NULL,
  `observaciones` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbdiscos`
--

CREATE TABLE IF NOT EXISTS `dbdiscos` (
`iddisco` int(11) NOT NULL,
  `numerohard` int(11) NOT NULL,
  `refpeliculas` int(11) NOT NULL,
  `refestados` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dbdiscos`
--

INSERT INTO `dbdiscos` (`iddisco`, `numerohard`, `refpeliculas`, `refestados`) VALUES
(1, 500, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbpeliculas`
--

CREATE TABLE IF NOT EXISTS `dbpeliculas` (
`idpelicula` int(11) NOT NULL,
  `titulo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `fechaestreno` date NOT NULL,
  `refclientes` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dbpeliculas`
--

INSERT INTO `dbpeliculas` (`idpelicula`, `titulo`, `fechaestreno`, `refclientes`) VALUES
(1, 'Rambo 16', '2018-08-28', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbprestatarios`
--

CREATE TABLE IF NOT EXISTS `dbprestatarios` (
`idprestatario` int(11) NOT NULL,
  `razonsocial` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `localidad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `provincia` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dbprestatarios`
--

INSERT INTO `dbprestatarios` (`idprestatario`, `razonsocial`, `nombre`, `telefono`, `direccion`, `email`, `localidad`, `provincia`) VALUES
(1, 'Juan Carlos Pereira', 'Cinema 8', '4217799', '8 e/50 y 51', '', 'La Plata', 'Bs As');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbusuarios`
--

CREATE TABLE IF NOT EXISTS `dbusuarios` (
`idusuario` int(11) NOT NULL,
  `usuario` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `refroles` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nombrecompleto` varchar(120) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `dbusuarios`
--

INSERT INTO `dbusuarios` (`idusuario`, `usuario`, `password`, `refroles`, `email`, `nombrecompleto`) VALUES
(1, 'Marcos', 'marcos', 1, 'msredhotero@msn.com', 'Safar Marcos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predio_menu`
--

CREATE TABLE IF NOT EXISTS `predio_menu` (
`idmenu` int(11) NOT NULL,
  `url` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `icono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Orden` smallint(6) DEFAULT NULL,
  `hover` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `permiso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `predio_menu`
--

INSERT INTO `predio_menu` (`idmenu`, `url`, `icono`, `nombre`, `Orden`, `hover`, `permiso`) VALUES
(1, '../index.php', 'icodashboard', 'Dashboard', 1, NULL, 'Administrador, Usuario'),
(8, '../logout.php', 'icosalir', 'Salir', 30, NULL, 'Administrador, Usuario'),
(18, '../clientes/', 'icojugadores', 'Clientes', 2, NULL, 'Administrador'),
(30, '../usuarios/', 'icousuarios', 'Usuarios', 14, NULL, 'Administrador'),
(31, '../alquileres/', 'icoalquileresnuevo', 'Alquileres', 15, NULL, 'Administrador'),
(32, '../devoluciones/', 'icodevoluciones', 'Devoluciones', 16, NULL, 'Administrador'),
(33, '../discos/', 'icodiscos', 'Discos', 17, NULL, 'Administrador'),
(34, '../peliculas/', 'icopeliculas', 'Peliculas', 18, NULL, 'Administrador'),
(35, '../prestatarios/', 'icoprestatarios', 'Prestatarios', 19, NULL, 'Administrador'),
(36, '../moviles/', 'icomoviles', 'Moviles', 20, NULL, 'Administrador'),
(37, '../transporteterceros/', 'icotransporteterceros', 'Transporte Terceros', 21, NULL, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbestados`
--

CREATE TABLE IF NOT EXISTS `tbestados` (
`idestado` int(11) NOT NULL,
  `estado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `color` varchar(8) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbestados`
--

INSERT INTO `tbestados` (`idestado`, `estado`, `color`) VALUES
(1, 'Deposito', NULL),
(2, 'Viaje', NULL),
(3, 'Alquilado', NULL),
(4, 'Devuelto', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbmoviles`
--

CREATE TABLE IF NOT EXISTS `tbmoviles` (
`idmovil` int(11) NOT NULL,
  `movil` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `placa` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbmoviles`
--

INSERT INTO `tbmoviles` (`idmovil`, `movil`, `placa`, `descripcion`) VALUES
(1, 'Movil 1', 'lop 123', 'Citroen Berlingo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbroles`
--

CREATE TABLE IF NOT EXISTS `tbroles` (
`idrol` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `activo` bit(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbroles`
--

INSERT INTO `tbroles` (`idrol`, `descripcion`, `activo`) VALUES
(1, 'Administrador', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtransporteterceros`
--

CREATE TABLE IF NOT EXISTS `tbtransporteterceros` (
`idtransportetercero` int(11) NOT NULL,
  `razonsocial` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbtransporteterceros`
--

INSERT INTO `tbtransporteterceros` (`idtransportetercero`, `razonsocial`, `telefono`, `email`) VALUES
(1, 'Viacargo', '4215588', 'info@viacargo.com.ar');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dbalquileres`
--
ALTER TABLE `dbalquileres`
 ADD PRIMARY KEY (`idalquiler`), ADD KEY `fk_alquileres_discos_idx` (`refdiscos`);

--
-- Indices de la tabla `dbalquileresprestatarios`
--
ALTER TABLE `dbalquileresprestatarios`
 ADD PRIMARY KEY (`idalquilerprestatario`), ADD KEY `fk_ap_alquiler_idx` (`refalquileres`), ADD KEY `fk_ap_prestatario_idx` (`refprestatarios`);

--
-- Indices de la tabla `dbclientes`
--
ALTER TABLE `dbclientes`
 ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `dbdevoluciones`
--
ALTER TABLE `dbdevoluciones`
 ADD PRIMARY KEY (`iddevolucion`), ADD KEY `fk_dev_prestatarios_idx` (`refprestatarios`);

--
-- Indices de la tabla `dbdiscos`
--
ALTER TABLE `dbdiscos`
 ADD PRIMARY KEY (`iddisco`), ADD KEY `fk_discos_peliculas_idx` (`refpeliculas`), ADD KEY `fk_discos_estados_idx` (`refestados`);

--
-- Indices de la tabla `dbpeliculas`
--
ALTER TABLE `dbpeliculas`
 ADD PRIMARY KEY (`idpelicula`), ADD KEY `fk_peliculas_clientes_idx` (`refclientes`);

--
-- Indices de la tabla `dbprestatarios`
--
ALTER TABLE `dbprestatarios`
 ADD PRIMARY KEY (`idprestatario`);

--
-- Indices de la tabla `dbusuarios`
--
ALTER TABLE `dbusuarios`
 ADD PRIMARY KEY (`idusuario`), ADD KEY `fk_dbusuarios_tbroles1_idx` (`refroles`);

--
-- Indices de la tabla `predio_menu`
--
ALTER TABLE `predio_menu`
 ADD PRIMARY KEY (`idmenu`);

--
-- Indices de la tabla `tbestados`
--
ALTER TABLE `tbestados`
 ADD PRIMARY KEY (`idestado`);

--
-- Indices de la tabla `tbmoviles`
--
ALTER TABLE `tbmoviles`
 ADD PRIMARY KEY (`idmovil`);

--
-- Indices de la tabla `tbroles`
--
ALTER TABLE `tbroles`
 ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `tbtransporteterceros`
--
ALTER TABLE `tbtransporteterceros`
 ADD PRIMARY KEY (`idtransportetercero`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dbalquileres`
--
ALTER TABLE `dbalquileres`
MODIFY `idalquiler` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `dbalquileresprestatarios`
--
ALTER TABLE `dbalquileresprestatarios`
MODIFY `idalquilerprestatario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `dbclientes`
--
ALTER TABLE `dbclientes`
MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `dbdevoluciones`
--
ALTER TABLE `dbdevoluciones`
MODIFY `iddevolucion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `dbdiscos`
--
ALTER TABLE `dbdiscos`
MODIFY `iddisco` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `dbpeliculas`
--
ALTER TABLE `dbpeliculas`
MODIFY `idpelicula` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `dbprestatarios`
--
ALTER TABLE `dbprestatarios`
MODIFY `idprestatario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `dbusuarios`
--
ALTER TABLE `dbusuarios`
MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `predio_menu`
--
ALTER TABLE `predio_menu`
MODIFY `idmenu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT de la tabla `tbestados`
--
ALTER TABLE `tbestados`
MODIFY `idestado` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tbmoviles`
--
ALTER TABLE `tbmoviles`
MODIFY `idmovil` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbroles`
--
ALTER TABLE `tbroles`
MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbtransporteterceros`
--
ALTER TABLE `tbtransporteterceros`
MODIFY `idtransportetercero` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dbalquileres`
--
ALTER TABLE `dbalquileres`
ADD CONSTRAINT `fk_alquileres_discos` FOREIGN KEY (`refdiscos`) REFERENCES `dbdiscos` (`iddisco`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbalquileresprestatarios`
--
ALTER TABLE `dbalquileresprestatarios`
ADD CONSTRAINT `fk_ap_alquiler` FOREIGN KEY (`refalquileres`) REFERENCES `dbalquileres` (`idalquiler`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ap_prestatario` FOREIGN KEY (`refprestatarios`) REFERENCES `dbprestatarios` (`idprestatario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbdevoluciones`
--
ALTER TABLE `dbdevoluciones`
ADD CONSTRAINT `fk_dev_prestatarios` FOREIGN KEY (`refprestatarios`) REFERENCES `dbprestatarios` (`idprestatario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbdiscos`
--
ALTER TABLE `dbdiscos`
ADD CONSTRAINT `fk_discos_estados` FOREIGN KEY (`refestados`) REFERENCES `tbestados` (`idestado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_discos_peliculas` FOREIGN KEY (`refpeliculas`) REFERENCES `dbpeliculas` (`idpelicula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbpeliculas`
--
ALTER TABLE `dbpeliculas`
ADD CONSTRAINT `fk_peliculas_clientes` FOREIGN KEY (`refclientes`) REFERENCES `dbclientes` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
