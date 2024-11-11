-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 09:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plan_lekcji`
--

-- --------------------------------------------------------

--
-- Table structure for table `godzina`
--

CREATE TABLE `godzina` (
  `id_g` bigint(2) NOT NULL,
  `start` varchar(4) NOT NULL,
  `koniec` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `godzina`
--

INSERT INTO `godzina` (`id_g`, `start`, `koniec`) VALUES
(1, '7:45', '8:30'),
(2, '8:40', '9:25');

-- --------------------------------------------------------

--
-- Table structure for table `klasa`
--

CREATE TABLE `klasa` (
  `numer_k` char(2) NOT NULL,
  `grupy` varchar(50) NOT NULL,
  `ilosc_godzin` int(50) NOT NULL,
  `dni_wolne` varchar(14) DEFAULT NULL,
  `wychowawca` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klasa`
--

INSERT INTO `klasa` (`numer_k`, `grupy`, `ilosc_godzin`, `dni_wolne`, `wychowawca`) VALUES
('1B', 'jezyk;religia;WF;zawod', 31, 'Wt', 'RO'),
('3D', 'jezyk;religia;WF;zawod', 41, NULL, 'JL');

-- --------------------------------------------------------

--
-- Table structure for table `nauczyciele`
--

CREATE TABLE `nauczyciele` (
  `skrot` char(2) NOT NULL,
  `imie_nazwisko` varchar(50) NOT NULL,
  `dni_robocze` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nauczyciele`
--

INSERT INTO `nauczyciele` (`skrot`, `imie_nazwisko`, `dni_robocze`) VALUES
('JL', 'Joanna Lipiecka', 'Pn;Wt;Sr;Cz;Pt'),
('RO', 'Krzysztof Rogalski', 'Pn;Wt;Sr;Cz;Pt'),
('WB', 'Wiesław Burczyk', 'Pn;Wt;Sr;Cz;Pt');

-- --------------------------------------------------------

--
-- Table structure for table `nauczyciele_klasa`
--

CREATE TABLE `nauczyciele_klasa` (
  `numer_k` char(2) NOT NULL,
  `skrot` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nauczyciele_klasa`
--

INSERT INTO `nauczyciele_klasa` (`numer_k`, `skrot`) VALUES
('1B', 'RO'),
('1B', 'WB'),
('3D', 'JL');

-- --------------------------------------------------------

--
-- Table structure for table `nauczyciele_przedmiot`
--

CREATE TABLE `nauczyciele_przedmiot` (
  `skrot` char(2) NOT NULL,
  `id_p` bigint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nauczyciele_przedmiot`
--

INSERT INTO `nauczyciele_przedmiot` (`skrot`, `id_p`) VALUES
('JL', 1),
('JL', 3),
('RO', 2),
('WB', 1);

-- --------------------------------------------------------

--
-- Table structure for table `plan_lekcji`
--

CREATE TABLE `plan_lekcji` (
  `id` bigint(4) NOT NULL,
  `numer_k` char(2) DEFAULT NULL,
  `id_p` bigint(2) DEFAULT NULL,
  `skrot` char(2) DEFAULT NULL,
  `numer_s` varchar(4) DEFAULT NULL,
  `id_g` bigint(2) DEFAULT NULL,
  `dzien` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plan_lekcji`
--

INSERT INTO `plan_lekcji` (`id`, `numer_k`, `id_p`, `skrot`, `numer_s`, `id_g`, `dzien`) VALUES
(1, '1B', 1, 'WB', '143', 1, 'Pn'),
(2, '1B', 2, 'RO', 'WF_1', 2, 'Pn'),
(3, '3D', 3, 'JL', '329', 1, 'Pn'),
(4, '3D', 3, 'JL', '329', 2, 'Pn');

-- --------------------------------------------------------

--
-- Table structure for table `przedmiot`
--

CREATE TABLE `przedmiot` (
  `id_p` bigint(2) NOT NULL,
  `nazwa` varchar(50) NOT NULL,
  `min_ilosc` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `przedmiot`
--

INSERT INTO `przedmiot` (`id_p`, `nazwa`, `min_ilosc`) VALUES
(1, 'j.angielski', 1),
(2, 'WF', 3),
(3, 'j.ang.zaw', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `przedmiot_klasa`
--

CREATE TABLE `przedmiot_klasa` (
  `numer_k` char(2) NOT NULL,
  `id_p` bigint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `przedmiot_klasa`
--

INSERT INTO `przedmiot_klasa` (`numer_k`, `id_p`) VALUES
('1B', 1),
('1B', 2),
('1B', 3),
('3D', 1),
('3D', 2),
('3D', 3);

-- --------------------------------------------------------

--
-- Table structure for table `sala`
--

CREATE TABLE `sala` (
  `numer` varchar(4) NOT NULL,
  `rozmiar` int(2) NOT NULL,
  `typ` varchar(17) NOT NULL,
  `wychowawca` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sala`
--

INSERT INTO `sala` (`numer`, `rozmiar`, `typ`, `wychowawca`) VALUES
('143', 1, 'Jezykowa', 'WB'),
('329', 1, 'Jezykowa', 'JL'),
('WF_1', 2, 'WF', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `godzina`
--
ALTER TABLE `godzina`
  ADD PRIMARY KEY (`id_g`);

--
-- Indexes for table `klasa`
--
ALTER TABLE `klasa`
  ADD PRIMARY KEY (`numer_k`);

--
-- Indexes for table `nauczyciele`
--
ALTER TABLE `nauczyciele`
  ADD PRIMARY KEY (`skrot`);

--
-- Indexes for table `nauczyciele_klasa`
--
ALTER TABLE `nauczyciele_klasa`
  ADD PRIMARY KEY (`numer_k`,`skrot`),
  ADD KEY `skrot` (`skrot`);

--
-- Indexes for table `nauczyciele_przedmiot`
--
ALTER TABLE `nauczyciele_przedmiot`
  ADD PRIMARY KEY (`skrot`,`id_p`),
  ADD KEY `id_p` (`id_p`);

--
-- Indexes for table `plan_lekcji`
--
ALTER TABLE `plan_lekcji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `numer_k` (`numer_k`),
  ADD KEY `id_p` (`id_p`),
  ADD KEY `skrot` (`skrot`),
  ADD KEY `numer_s` (`numer_s`),
  ADD KEY `id_g` (`id_g`);

--
-- Indexes for table `przedmiot`
--
ALTER TABLE `przedmiot`
  ADD PRIMARY KEY (`id_p`);

--
-- Indexes for table `przedmiot_klasa`
--
ALTER TABLE `przedmiot_klasa`
  ADD PRIMARY KEY (`numer_k`,`id_p`),
  ADD KEY `id_p` (`id_p`);

--
-- Indexes for table `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`numer`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nauczyciele_klasa`
--
ALTER TABLE `nauczyciele_klasa`
  ADD CONSTRAINT `nauczyciele_klasa_ibfk_1` FOREIGN KEY (`numer_k`) REFERENCES `klasa` (`numer_k`),
  ADD CONSTRAINT `nauczyciele_klasa_ibfk_2` FOREIGN KEY (`skrot`) REFERENCES `nauczyciele` (`skrot`);

--
-- Constraints for table `nauczyciele_przedmiot`
--
ALTER TABLE `nauczyciele_przedmiot`
  ADD CONSTRAINT `nauczyciele_przedmiot_ibfk_1` FOREIGN KEY (`skrot`) REFERENCES `nauczyciele` (`skrot`),
  ADD CONSTRAINT `nauczyciele_przedmiot_ibfk_2` FOREIGN KEY (`id_p`) REFERENCES `przedmiot` (`id_p`);

--
-- Constraints for table `plan_lekcji`
--
ALTER TABLE `plan_lekcji`
  ADD CONSTRAINT `plan_lekcji_ibfk_1` FOREIGN KEY (`numer_k`) REFERENCES `klasa` (`numer_k`),
  ADD CONSTRAINT `plan_lekcji_ibfk_2` FOREIGN KEY (`id_p`) REFERENCES `przedmiot` (`id_p`),
  ADD CONSTRAINT `plan_lekcji_ibfk_3` FOREIGN KEY (`skrot`) REFERENCES `nauczyciele` (`skrot`),
  ADD CONSTRAINT `plan_lekcji_ibfk_4` FOREIGN KEY (`numer_s`) REFERENCES `sala` (`numer`),
  ADD CONSTRAINT `plan_lekcji_ibfk_5` FOREIGN KEY (`id_g`) REFERENCES `godzina` (`id_g`);

--
-- Constraints for table `przedmiot_klasa`
--
ALTER TABLE `przedmiot_klasa`
  ADD CONSTRAINT `przedmiot_klasa_ibfk_1` FOREIGN KEY (`numer_k`) REFERENCES `klasa` (`numer_k`),
  ADD CONSTRAINT `przedmiot_klasa_ibfk_2` FOREIGN KEY (`id_p`) REFERENCES `przedmiot` (`id_p`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
