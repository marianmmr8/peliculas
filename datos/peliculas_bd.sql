-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-10-2026 a las 17:02:56
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
-- Base de datos: `peliculas_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `director`
--

CREATE TABLE `director` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `nacimiento` int(11) NOT NULL,
  `biografia` text NOT NULL,
  `creado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE IF NOT EXISTS `peliculas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `director` varchar(120) NOT NULL,
  `anio` int(11) NOT NULL,
  `genero` varchar(80) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `visto` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `director`
--

INSERT INTO `director` (`id`, `nombre`, `nacimiento`, `biografia`, `creado`) VALUES
(1, 'Alejandro Amenabar', 1972, 'Alejandro Amenábar (nombre completo: Alejandro Fernando Amenábar Cantos) es un destacado director, guionista y compositor hispano-chileno, nacido el 31 de marzo de 1972 en Santiago de Chile. \r\n\r\nOrigen y formación\r\nHijo de padre chileno y madre española, emigró a Madrid a los pocos meses de vida para escapar del golpe de Estado de Augusto Pinochet.  Estudió en la Universidad Complutense de Madrid, aunque abandonó la carrera de Ciencias de la Información para dedicarse plenamente al cine, comenzando con cortometrajes como La cabeza (1991). \r\n\r\nTrayectoria y reconocimientos\r\nSe consolidó como uno de los cineastas españoles más exitosos con su ópera prima, Tesis (1996), ganadora de siete Premios Goya.  Su carrera internacional despegó con Los otros (2001) y alcanzó su mayor hito con Mar adentro (2004), película por la que obtuvo el Óscar y el Globo de Oro a la Mejor Película Extranjera. Ha recibido un total de once Premios Goya y es conocido por escribir los guiones y componer la música de la mayoría de sus filmes.\r\n', '2026-10-30 16:01:45');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `director`
--
ALTER TABLE `director`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `director`
--
ALTER TABLE `director`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
