-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2015. Dec 13. 12:50
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

--
-- Tábla szerkezet ehhez a táblához `kiemelesek`
--

CREATE TABLE `kiemelesek` (
  `kim_azon` int(11) NOT NULL COMMENT 'A kiemelés egyedi azonosítója.',
  `kim_nev` varchar(40) NOT NULL COMMENT 'A kiemelés megnevezése.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='A termék kiemelés kategóriákat tartalmazza';

--
-- A tábla adatainak kiíratása `kiemelesek`
--

INSERT INTO `kiemelesek` (`kim_azon`, `kim_nev`) VALUES
(1, 'nincs'),
(2, 'árcsökkentett'),
(3, 'új termék'),
(4, 'akciós');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `kiemelesek`
--
ALTER TABLE `kiemelesek`
  ADD PRIMARY KEY (`kim_azon`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `kiemelesek`
--
ALTER TABLE `kiemelesek`
  MODIFY `kim_azon` int(11) NOT NULL AUTO_INCREMENT COMMENT 'A kiemelés egyedi azonosítója.', AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
