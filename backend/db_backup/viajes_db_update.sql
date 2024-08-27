-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 27-08-2024 a las 22:33:43
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
-- Base de datos: `viajes_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `cedula` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `edad` int(11) DEFAULT NULL,
  `rol` enum('admin','usuario','invitado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinos`
--

CREATE TABLE `destinos` (
  `id_destino` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado_destino` enum('activo','inactivo') DEFAULT 'activo',
  `precio` decimal(10,2) NOT NULL,
  `descuento` decimal(5,2) DEFAULT 0.00,
  `numero_dias` int(11) NOT NULL,
  `numero_noches` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `destinos`
--

INSERT INTO `destinos` (`id_destino`, `nombre`, `descripcion`, `estado_destino`, `precio`, `descuento`, `numero_dias`, `numero_noches`, `fecha_creacion`) VALUES
(1, 'Destino A', 'Descripción del Destino A', 'activo', 500.00, 50.00, 7, 6, NULL),
(2, 'Destino B', 'Descripción del Destino B', 'activo', 600.00, 75.00, 10, 9, NULL),
(3, 'Destino C', 'Descripción del Destino C', 'activo', 450.00, 30.00, 5, 4, NULL),
(4, 'Destino D', 'Descripción del Destino D', 'inactivo', 700.00, 100.00, 14, 13, NULL),
(5, 'Destino E', 'Descripción del Destino E', 'activo', 550.00, 40.00, 8, 7, NULL),
(6, 'Destino F', 'Descripción del Destino F', 'activo', 650.00, 60.00, 12, 11, NULL),
(7, 'Destino G', 'Descripción del Destino G', 'activo', 480.00, 25.00, 6, 5, NULL),
(8, 'Destino H', 'Descripción del Destino H', 'inactivo', 720.00, 90.00, 15, 14, NULL),
(9, 'Destino I', 'Descripción del Destino I', 'activo', 500.00, 55.00, 7, 6, NULL),
(10, 'Destino J', 'Descripción del Destino J', 'activo', 630.00, 70.00, 11, 10, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `idx_cedula` (`cedula`),
  ADD UNIQUE KEY `idx_correo` (`correo`);

--
-- Indices de la tabla `destinos`
--
ALTER TABLE `destinos`
  ADD PRIMARY KEY (`id_destino`),
  ADD KEY `idx_nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `destinos`
--
ALTER TABLE `destinos`
  MODIFY `id_destino` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
