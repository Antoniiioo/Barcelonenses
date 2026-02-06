-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-02-2026 a las 15:03:01
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `barcelonenses`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `id_direccion` int(11) NOT NULL,
  `calle` varchar(50) NOT NULL,
  `num_calle` varchar(10) NOT NULL,
  `cod_postal` int(5) NOT NULL,
  `localidad` varchar(30) NOT NULL,
  `pais` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`id_direccion`, `calle`, `num_calle`, `cod_postal`, `localidad`, `pais`) VALUES
(1, 'Gran Vía', '45', 8001, 'Barcelona', 'España'),
(2, 'Passeig de Gràcia', '123', 8008, 'Barcelona', 'España'),
(3, 'Carrer de Pau Claris', '78', 8010, 'Barcelona', 'España'),
(4, 'Rambla Catalunya', '56', 8007, 'Barcelona', 'España'),
(5, 'Avinguda Diagonal', '234', 8013, 'Barcelona', 'España'),
(6, 'Carrer de Balmes', '89', 8008, 'Barcelona', 'España'),
(7, 'Carrer Pelai', '12', 8001, 'Barcelona', 'España'),
(8, 'Carrer de Provença', '167', 8036, 'Barcelona', 'España');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `image_producto`
--

CREATE TABLE `image_producto` (
  `id_image_producto` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `url_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `image_producto`
--

INSERT INTO `image_producto` (`id_image_producto`, `id_producto`, `url_image`) VALUES
(1, 1, 'assets/img/camisetaAdidas.png'),
(2, 2, 'assets/img/camiseta-nike-deportiva.png'),
(3, 3, 'assets/img/pantalonNike.png'),
(4, 4, 'assets/img/pantalon-chino-zara.png'),
(5, 5, 'assets/img/chaquetonNorth.png'),
(6, 6, 'assets/img/zapatillas-running.png'),
(7, 7, 'assets/img/zapatillas-casual-nike.png'),
(8, 8, 'assets/img/gorra-puma.png'),
(9, 9, 'assets/img/sudadera-adidas.png'),
(10, 10, 'assets/img/camiseta-vintage.png'),
(11, 11, 'assets/img/short-nike.png'),
(12, 12, 'assets/img/chaqueta-vaquera.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `id_tipo_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `marca` varchar(40) NOT NULL,
  `precio` float(7,2) NOT NULL,
  `talla` varchar(20) NOT NULL,
  `color` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `id_tipo_producto`, `id_usuario`, `nombre`, `marca`, `precio`, `talla`, `color`) VALUES
(1, 1, 3, 'Camiseta Básica', 'Adidas', 29.99, 'M', 'Blanco'),
(2, 1, 3, 'Camiseta Deportiva', 'Nike', 35.50, 'L', 'Negro'),
(3, 2, 4, 'Pantalón Vaquero', 'Levi\'s', 79.99, '32', 'Azul'),
(4, 2, 4, 'Pantalón Chino', 'Zara', 45.00, '34', 'Beige'),
(5, 3, 3, 'Chaqueta North Face', 'The North Face', 159.99, 'XL', 'Rojo'),
(6, 4, 4, 'Zapatillas Running', 'Adidas', 89.99, '42', 'Negro'),
(7, 4, 3, 'Zapatillas Casual', 'Nike', 95.00, '43', 'Blanco'),
(8, 5, 9, 'Gorra Deportiva', 'Puma', 19.99, 'Única', 'Azul'),
(9, 6, 9, 'Sudadera Con Capucha', 'Adidas', 55.00, 'L', 'Gris'),
(10, 1, 4, 'Camiseta Vintage', 'Stussy', 42.50, 'S', 'Verde'),
(11, 7, 3, 'Short Deportivo', 'Nike', 28.00, 'M', 'Negro'),
(12, 3, 9, 'Chaqueta Vaquera', 'Levi\'s', 89.99, 'L', 'Azul');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_producto`
--

CREATE TABLE `tipo_producto` (
  `id_tipo_producto` int(11) NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_producto`
--

INSERT INTO `tipo_producto` (`id_tipo_producto`, `tipo`) VALUES
(1, 'Camisetas'),
(2, 'Pantalones'),
(3, 'Chaquetas'),
(4, 'Zapatillas'),
(5, 'Accesorios'),
(6, 'Sudaderas'),
(7, 'Shorts');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo_usuario`, `tipo`) VALUES
(1, 'admin'),
(2, 'editor'),
(3, 'valorador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `id_direccion` int(11) DEFAULT NULL,
  `pass` varchar(60) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `apellido1` varchar(40) NOT NULL,
  `apellido2` varchar(40) DEFAULT NULL,
  `email` varchar(60) NOT NULL,
  `fecha_nac` date NOT NULL,
  `telefono` int(9) NOT NULL,
  `id_tipo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `id_direccion`, `pass`, `nombre`, `apellido1`, `apellido2`, `email`, `fecha_nac`, `telefono`, `id_tipo_usuario`) VALUES
(2, NULL, '$2y$12$WPBHp42PBVcABlocJ/sU/ep3vb2cn5Ly8fUPCGmQgAJJazqfTHq1.', 'admin', 'admin', '', 'admin@gmail.com', '2026-01-27', 123456789, 1),
(3, 1, '$2y$12$aSpzVwz35FiWC/9h14QO5.r8yBLNu.prH/T0rkJwr2S8EEIZpP8ES', 'Carlos', 'García', 'López', 'carlos.garcia@barcelonenses.com', '1990-05-15', 612345678, 2),
(4, 2, '$2y$12$aSpzVwz35FiWC/9h14QO5.r8yBLNu.prH/T0rkJwr2S8EEIZpP8ES', 'María', 'Martínez', 'Fernández', 'maria.martinez@barcelonenses.com', '1988-08-22', 623456789, 2),
(5, 3, '$2y$12$aSpzVwz35FiWC/9h14QO5.r8yBLNu.prH/T0rkJwr2S8EEIZpP8ES', 'Juan', 'Rodríguez', 'Sánchez', 'juan.rodriguez@barcelonenses.com', '1995-03-10', 634567890, 3),
(6, 4, '$2y$12$aSpzVwz35FiWC/9h14QO5.r8yBLNu.prH/T0rkJwr2S8EEIZpP8ES', 'Ana', 'López', 'Gómez', 'ana.lopez@barcelonenses.com', '1992-11-30', 645678901, 3),
(7, 5, '$2y$12$aSpzVwz35FiWC/9h14QO5.r8yBLNu.prH/T0rkJwr2S8EEIZpP8ES', 'Pedro', 'González', 'Ruiz', 'pedro.gonzalez@barcelonenses.com', '1985-07-18', 656789012, 3),
(8, 6, '$2y$12$aSpzVwz35FiWC/9h14QO5.r8yBLNu.prH/T0rkJwr2S8EEIZpP8ES', 'Laura', 'Hernández', 'Díaz', 'laura.hernandez@barcelonenses.com', '1998-01-25', 667890123, 3),
(9, 7, '$2y$12$aSpzVwz35FiWC/9h14QO5.r8yBLNu.prH/T0rkJwr2S8EEIZpP8ES', 'David', 'Jiménez', 'Moreno', 'david.jimenez@barcelonenses.com', '1993-09-05', 678901234, 2),
(10, 8, '$2y$12$aSpzVwz35FiWC/9h14QO5.r8yBLNu.prH/T0rkJwr2S8EEIZpP8ES', 'Sara', 'Muñoz', 'Álvarez', 'sara.munoz@barcelonenses.com', '1991-04-12', 689012345, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracion`
--

CREATE TABLE `valoracion` (
  `id_valoracion` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `puntuacion` tinyint(4) NOT NULL,
  `comentario` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `valoracion`
--

INSERT INTO `valoracion` (`id_valoracion`, `id_producto`, `puntuacion`, `comentario`, `id_usuario`) VALUES
(1, 1, 5, 'Excelente calidad, muy cómoda y el tejido es suave. La recomiendo.', 5),
(2, 1, 4, 'Buena camiseta, pero el tallaje es un poco grande.', 6),
(3, 2, 5, 'Perfecta para hacer deporte, transpira muy bien.', 7),
(4, 3, 5, 'Los mejores vaqueros que he comprado, ajuste perfecto.', 5),
(5, 3, 4, 'Buena calidad pero un poco caros.', 8),
(6, 4, 3, 'Están bien pero esperaba mejor calidad por el precio.', 6),
(7, 5, 5, 'Abriga muchísimo y es muy resistente al agua. Perfecta para invierno.', 10),
(8, 5, 5, 'La mejor inversión, vale cada euro.', 5),
(9, 6, 4, 'Muy cómodas para correr, aunque necesitan un periodo de adaptación.', 7),
(10, 7, 5, 'Diseño increíble y súper cómodas para el día a día.', 8),
(11, 8, 4, 'Buena gorra, protege bien del sol.', 6),
(12, 9, 5, 'Sudadera de calidad premium, muy calentita.', 10),
(13, 9, 4, 'Me encanta pero es un poco pesada.', 5),
(14, 10, 5, 'Diseño único, recibo muchos cumplidos cuando la llevo.', 7),
(15, 11, 4, 'Cómodos y ligeros, perfectos para el gym.', 8),
(16, 12, 5, 'Estilo clásico que nunca pasa de moda. Perfecta.', 6),
(17, 1, 3, 'Esperaba mejor calidad por ser Adidas.', 10),
(18, 2, 5, 'Nike nunca decepciona, producto de 10.', 5),
(19, 6, 3, 'Se desgastan rápido para el precio que tienen.', 6),
(20, 7, 4, 'Buenas zapatillas, cómodas desde el primer día.', 7),
(23, 12, 5, '<p><strong>Hola, <em>Esto es una</em></strong><u> prueba</u></p>', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`id_direccion`);

--
-- Indices de la tabla `image_producto`
--
ALTER TABLE `image_producto`
  ADD PRIMARY KEY (`id_image_producto`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_tipo_producto` (`id_tipo_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`id_tipo_producto`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_tipo_usuario` (`id_tipo_usuario`),
  ADD KEY `id_direccion` (`id_direccion`);

--
-- Indices de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD PRIMARY KEY (`id_valoracion`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `image_producto`
--
ALTER TABLE `image_producto`
  MODIFY `id_image_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tipo_producto`
--
ALTER TABLE `tipo_producto`
  MODIFY `id_tipo_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  MODIFY `id_valoracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_tipo_producto`) REFERENCES `tipo_producto` (`id_tipo_producto`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_direccion`) REFERENCES `direccion` (`id_direccion`);

--
-- Filtros para la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD CONSTRAINT `valoracion_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  ADD CONSTRAINT `valoracion_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
