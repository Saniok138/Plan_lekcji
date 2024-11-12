-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 12 2024 г., 02:33
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_plan`
--

-- --------------------------------------------------------

--
-- Структура для представления `najwczesniejsza_najpozniejsza_godzina`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `najwczesniejsza_najpozniejsza_godzina`  AS SELECT `pl`.`dzien` AS `dzien`, min(`g`.`start`) AS `najwczesniejsza_godzina`, max(`g`.`koniec`) AS `najpozniejsza_godzina` FROM (`plan_lekcji` `pl` join `godzina` `g` on(`pl`.`id_g` = `g`.`id_g`)) GROUP BY `pl`.`dzien` ;

--
-- VIEW `najwczesniejsza_najpozniejsza_godzina`
-- Данные: Ни одного
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
