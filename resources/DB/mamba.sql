-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2023 at 08:07 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mamba`
--

-- --------------------------------------------------------

--
-- Table structure for table `preguntaseguridad`
--

CREATE TABLE `preguntaseguridad` (
  `Pregunta` varchar(100) NOT NULL,
  `ID_Pregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `ID_Pto` int(11) NOT NULL,
  `Nombre_Pto` varchar(50) NOT NULL,
  `Categoria` varchar(100) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `Existencia` int(11) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Imagen` varchar(50) NOT NULL,
  `Descuento` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `ID` int(11) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Correo_Usr` varchar(50) NOT NULL,
  `Password_Usr` varchar(50) NOT NULL,
  `PregSeguridad` int(11) NOT NULL,
  `Nombre_Usr` varchar(50) NOT NULL,
  `RespuestaPregSeg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `venta`
--

CREATE TABLE `venta` (
  `ID_Cte` int(11) NOT NULL,
  `Id_Prod` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Cart` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `preguntaseguridad`
--
ALTER TABLE `preguntaseguridad`
  ADD PRIMARY KEY (`ID_Pregunta`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`ID_Pto`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `PregSeguridad` (`PregSeguridad`);

--
-- Indexes for table `venta`
--
ALTER TABLE `venta`
  ADD KEY `ID_Cte` (`ID_Cte`),
  ADD KEY `Id_Prod` (`Id_Prod`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `preguntaseguridad`
--
ALTER TABLE `preguntaseguridad`
  MODIFY `ID_Pregunta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `ID_Pto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`PregSeguridad`) REFERENCES `preguntaseguridad` (`ID_Pregunta`);

--
-- Constraints for table `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`ID_Cte`) REFERENCES `usuario` (`ID`),
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`Id_Prod`) REFERENCES `producto` (`ID_Pto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
