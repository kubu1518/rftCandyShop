-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2015. Dec 13. 12:30
-- Kiszolgáló verziója: 10.1.8-MariaDB
-- PHP verzió: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `candyshopdb`
--

-- --------------------------------------------------------



INSERT INTO `termekek` (`t_azon`, `nev`, `kat_azon`, `kisz_azon`, `suly`, `egysegar`, `min_keszlet`, `min_rend`, `kim_azon`, `akcio`, `reszletek`, `kep`) VALUES
(12, 'Almás cukorka', 2, 1, 200, 120, 1, 300, 1, 0, 'Nagyon finom almás cukorka, cukor nélkül készült.\r\nSzuper egészséges!', '1450004109.jpg'),
(13, 'Kemény cukorka', 2, 1, 250, 300, 10, 400, 4, 10, 'Nagyon finom kemény gyümölcsös cukorka.', '1450004209.jpg'),
(14, 'Miska', 1, 2, 200, 345, 5, 200, 3, 0, 'Legújabb ízesítésű Miska csokoládénk: Marcipános.', '1450004382.jpg'),
(15, 'Tibi csoki', 1, 2, 250, 269, 2, 100, 1, 0, 'Hazai termék, mogyorós.', '1450004510.jpg'),
(16, 'Balaton csoki tejcsokis', 1, 3, 100, 150, 2, 100, 1, 0, 'Magyar termék, tradicionális módon elkészítve.\r\nTejcsokis.', '1450004698.jpg'),
(17, 'Sportszelet', 1, 3, 80, 120, 5, 200, 1, 0, 'Energizáld magad ezzel az energia bomba szelettel!', '1450004825.jpg'),
(18, 'Obit', 3, 1, 50, 120, 10, 500, 3, 0, 'Friss leheletet biztosít a nap bármely szakában.', '1450004949.jpg'),
(19, 'Airveawes', 3, 1, 90, 100, 10, 300, 4, 10, 'Az év bármely szakában biztosítja számodra a friss leheletet és még torokfájás ellen is jó.', '1450005044.jpeg'),
(20, 'Maoam Cukorka drzazsé', 2, 1, 500, 1000, 1, 50, 1, 0, 'Egy csomagnyi öröm vödörben.', '1450006015.jpg');


