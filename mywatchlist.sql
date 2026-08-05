-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-08-2026 a las 17:03:51
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
-- Base de datos: `mywatchlist`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_usuarios`
--

CREATE TABLE `lista_usuarios` (
  `id_usuarios` int(11) NOT NULL,
  `mal_id` int(11) NOT NULL,
  `tipo` enum('anime','manga') NOT NULL,
  `estado` enum('viendo','completado','planeado','abandonado') NOT NULL,
  `calificacion` tinyint(4) DEFAULT 0,
  `progreso` int(11) DEFAULT 0,
  `notas` varchar(500) DEFAULT NULL,
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `titulo` varchar(255) DEFAULT NULL,
  `imagen` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `user` varchar(25) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `bio` varchar(500) DEFAULT 'Un poco de mi..',
  `foto` varchar(255) DEFAULT 'assets/img/img_usuario/default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `user`, `contraseña`, `email`, `fecha_registro`, `bio`, `foto`) VALUES
(5, 'sergio', '$2y$10$HcEGZtgi0QnDR6dF3UkmxOefaMQkZ7tZlvV.Pf/ACxjtzEEXEBYz2', 'nero995@hotmail.com', '2026-06-08 12:40:11', 'Un poco de mi..', 'assets/img/img_usuario/default.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lista_usuarios`
--
ALTER TABLE `lista_usuarios`
  ADD PRIMARY KEY (`id_usuarios`,`mal_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lista_usuarios`
--
ALTER TABLE `lista_usuarios`
  ADD CONSTRAINT `lista_usuarios_ibfk_1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
