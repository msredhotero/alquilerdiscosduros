-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-08-2018 a las 11:16:19
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `alquilerdiscosduros`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbalquileres`
--

CREATE TABLE IF NOT EXISTS `dbalquileres` (
  `idalquiler` int(11) NOT NULL AUTO_INCREMENT,
  `fechaentrega` date NOT NULL,
  `metodoentrega` int(11) NOT NULL,
  `refmoviles` int(11) DEFAULT NULL,
  `reftransporteterceros` int(11) DEFAULT NULL,
  `numeroguia` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechadevolucion` date DEFAULT NULL,
  `fechacreacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idalquiler`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbalquileresprestatarios`
--

CREATE TABLE IF NOT EXISTS `dbalquileresprestatarios` (
  `idalquilerprestatario` int(11) NOT NULL AUTO_INCREMENT,
  `refalquileres` int(11) NOT NULL,
  `refprestatarios` int(11) NOT NULL,
  PRIMARY KEY (`idalquilerprestatario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbclientes`
--

CREATE TABLE IF NOT EXISTS `dbclientes` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `razonsocial` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `cuit` varchar(13) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(18) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `provincia` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ciudad` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idcliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbdevoluciones`
--

CREATE TABLE IF NOT EXISTS `dbdevoluciones` (
  `iddevolucion` int(11) NOT NULL AUTO_INCREMENT,
  `refprestatarios` int(11) NOT NULL,
  `metodoentrega` int(11) NOT NULL,
  `refmoviles` int(11) DEFAULT NULL,
  `reftransporteterceros` int(11) DEFAULT NULL,
  `numeroguia` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechadevolucion` date NOT NULL,
  `aldeposito` bit(1) NOT NULL,
  `observaciones` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`iddevolucion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbdiscos`
--

CREATE TABLE IF NOT EXISTS `dbdiscos` (
  `iddisco` int(11) NOT NULL AUTO_INCREMENT,
  `numerohard` int(11) NOT NULL,
  `refpeliculas` int(11) NOT NULL,
  PRIMARY KEY (`iddisco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbpeliculas`
--

CREATE TABLE IF NOT EXISTS `dbpeliculas` (
  `idpelicula` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `fechaestreno` date NOT NULL,
  `refclientes` int(11) NOT NULL,
  PRIMARY KEY (`idpelicula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbprestatarios`
--

CREATE TABLE IF NOT EXISTS `dbprestatarios` (
  `idprestatario` int(11) NOT NULL AUTO_INCREMENT,
  `razonsocial` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `localidad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `provincia` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idprestatario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbmoviles`
--

CREATE TABLE IF NOT EXISTS `tbmoviles` (
  `idmovil` int(11) NOT NULL AUTO_INCREMENT,
  `movil` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `placa` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idmovil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtransporteterceros`
--

CREATE TABLE IF NOT EXISTS `tbtransporteterceros` (
  `idtransportetercero` int(11) NOT NULL AUTO_INCREMENT,
  `razonsocial` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idtransportetercero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
