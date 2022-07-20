-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-07-2022 a las 00:56:04
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `taller3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `idLog` int(11) NOT NULL,
  `detalle` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` date DEFAULT NULL,
  `Persona_idPersona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `idCita` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` date DEFAULT NULL,
  `motivo` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `Paciente_idPersona` int(11) NOT NULL,
  `Medico_idPersona` int(11) NOT NULL,
  `Especialidad_idEspecialidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diagnostico`
--

CREATE TABLE `diagnostico` (
  `idDiagnostico` int(11) NOT NULL,
  `detalle` varchar(45) DEFAULT NULL,
  `nivel_estado` varchar(45) DEFAULT NULL,
  `enfermedad` varchar(45) DEFAULT NULL,
  `Cita_idCita` int(11) NOT NULL,
  `Cita_Paciente_idPersona` int(11) NOT NULL,
  `Cita_Medico_idPersona` int(11) NOT NULL,
  `Cita_Especialidad_idEspecialidad` int(11) NOT NULL,
  `Receta_idReceta` int(11) NOT NULL,
  `Examenes_idExamenes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `idEspecialidad` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `fecha_creacion` timestamp(1) NULL DEFAULT NULL,
  `fecha_mod` date DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes`
--

CREATE TABLE `examenes` (
  `idExamenes` int(11) NOT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `idHorarios` int(11) NOT NULL,
  `franja` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta`
--

CREATE TABLE `receta` (
  `idReceta` int(11) NOT NULL,
  `medicamento` varchar(45) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tiempo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `cedula` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `born` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `cedula`, `password`, `email`, `phone`, `address`, `city`, `born`, `gender`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BRYAN PALACIOS', 1724421282, '$2y$10$o6MZzbmEUHEaIkbs1fQEmea/V3cURr7Nvdm5h0On.rpU/hR5a1NtO', 'patient@gmail.com', '0996863725', 'santo domingo', 'santo domingo', '1995-04-21', 'male', 0, NULL, NULL),
(2, 'Richard López', 13989085, '$2y$10$GTSgZGy8XPOfSp6u/4ayoeeG9FRtyKNvfMSymTcb/TD6tlzWTRyZa', 'rlopezing@hotmail.com', '04144436900', 'Las Acacias', 'Valencia', '1977-11-01', 'Masculino', 1, '2022-07-03 02:25:03.000000', '2022-07-03 04:34:26.000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_has_especialidad`
--

CREATE TABLE `users_has_especialidad` (
  `Persona_idPersona` int(11) NOT NULL,
  `Especialidad_idEspecialidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_has_horarios`
--

CREATE TABLE `users_has_horarios` (
  `Persona_idPersona` int(11) NOT NULL,
  `Horarios_idHorarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_has_rol`
--

CREATE TABLE `users_has_rol` (
  `Persona_idPersona` int(11) NOT NULL,
  `Rol_idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`idLog`,`Persona_idPersona`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`idCita`,`Paciente_idPersona`,`Medico_idPersona`,`Especialidad_idEspecialidad`);

--
-- Indices de la tabla `diagnostico`
--
ALTER TABLE `diagnostico`
  ADD PRIMARY KEY (`idDiagnostico`,`Cita_idCita`,`Cita_Paciente_idPersona`,`Cita_Medico_idPersona`,`Cita_Especialidad_idEspecialidad`,`Receta_idReceta`,`Examenes_idExamenes`);

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`idEspecialidad`);

--
-- Indices de la tabla `examenes`
--
ALTER TABLE `examenes`
  ADD PRIMARY KEY (`idExamenes`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`idHorarios`);

--
-- Indices de la tabla `receta`
--
ALTER TABLE `receta`
  ADD PRIMARY KEY (`idReceta`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users_has_especialidad`
--
ALTER TABLE `users_has_especialidad`
  ADD PRIMARY KEY (`Persona_idPersona`,`Especialidad_idEspecialidad`);

--
-- Indices de la tabla `users_has_horarios`
--
ALTER TABLE `users_has_horarios`
  ADD PRIMARY KEY (`Persona_idPersona`,`Horarios_idHorarios`);

--
-- Indices de la tabla `users_has_rol`
--
ALTER TABLE `users_has_rol`
  ADD PRIMARY KEY (`Persona_idPersona`,`Rol_idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
