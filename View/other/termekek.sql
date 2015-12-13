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

--
-- Tábla szerkezet ehhez a táblához `termekek`
--

CREATE TABLE `termekek` (
  `t_azon` int(11) NOT NULL COMMENT 'A termék egyedi azonosítója.',
  `nev` varchar(40) NOT NULL COMMENT 'A termék neve.',
  `kat_azon` int(11) NOT NULL COMMENT 'A termék kategóriájának azonosítója.',
  `kisz_azon` int(11) NOT NULL COMMENT 'A termék kiszerelésének azonosítója.',
  `suly` int(10) UNSIGNED NOT NULL COMMENT 'A termék súlya gramm mértékegységben.',
  `egysegar` int(10) UNSIGNED NOT NULL COMMENT 'A termék egységára.',
  `min_keszlet` int(10) UNSIGNED NOT NULL COMMENT 'Az a mennyiség, amit raktáron kell tartani az adott termékből.',
  `min_rend` int(11) NOT NULL COMMENT 'Az a legkisebb mennyiség, ami rendelhető az adott termékből.',
  `kim_azon` int(11) DEFAULT NULL COMMENT 'A termék kiemelésének azonosítója (Lehet null).',
  `akcio` int(10) UNSIGNED DEFAULT NULL COMMENT 'Az akció mértéke százalékban megadva (Lehet null).',
  `reszletek` varchar(500) DEFAULT NULL COMMENT 'A termék részletes leírása.',
  `kep` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'A termékről készített kép elérési útvonalát tartalmazza.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='A termékeket reprezentáló tábla.';

--
-- A tábla adatainak kiíratása `termekek`
--

INSERT INTO `termekek` (`t_azon`, `nev`, `kat_azon`, `kisz_azon`, `suly`, `egysegar`, `min_keszlet`, `min_rend`, `kim_azon`, `akcio`, `reszletek`, `kep`) VALUES
(1, 'Orbit wájtening hagyma izesítés', 3, 1, 20, 210, 2000, 10, 1, NULL, 'Minden randi előtt kapj be egy hagymás Orbitot', 'image/tudja/a/tokom'),
(2, 'Bajunti', 1, 3, 100, 200, 5000, 5, 2, 25, 'Harapj rá a kókuszdióra', 'image/tudja/a/mogyim.png'),
(3, 'Nikersz', 1, 3, 80, 300, 3000, 5, 3, NULL, 'Nikersz: dohányozni tilos', 'image/tudja/a/hoher.png'),
(12, 'Almás cukorka', 2, 1, 200, 120, 1, 300, 1, 0, 'Nagyon finom almás cukorka, cukor nélkül készült.\r\nSzuper egészséges!', '1450004109.jpg'),
(13, 'Kemény cukorka', 2, 1, 250, 300, 10, 400, 4, 10, 'Nagyon finom kemény gyümölcsös cukorka.', '1450004209.jpg'),
(14, 'Miska', 1, 2, 200, 345, 5, 200, 3, 0, 'Legújabb ízesítésű Miska csokoládénk: Marcipános.', '1450004382.jpg'),
(15, 'Tibi csoki', 1, 2, 250, 269, 2, 100, 1, 0, 'Hazai termék, mogyorós.', '1450004510.jpg'),
(16, 'Balaton csoki tejcsokis', 1, 3, 100, 150, 2, 100, 1, 0, 'Magyar termék, tradicionális módon elkészítve.\r\nTejcsokis.', '1450004698.jpg'),
(17, 'Sportszelet', 1, 3, 80, 120, 5, 200, 1, 0, 'Energizáld magad ezzel az energia bomba szelettel!', '1450004825.jpg'),
(18, 'Obit', 3, 1, 50, 120, 10, 500, 3, 0, 'Friss leheletet biztosít a nap bármely szakában.', '1450004949.jpg'),
(19, 'Airveawes', 3, 1, 90, 100, 10, 300, 4, 10, 'Az év bármely szakában biztosítja számodra a friss leheletet és még torokfájás ellen is jó.', '1450005044.jpeg'),
(20, 'Maoam Cukorka drzazsé', 2, 1, 500, 1000, 1, 50, 1, 0, 'Egy csomagnyi öröm vödörben.', '1450006015.jpg');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `termekek`
--
ALTER TABLE `termekek`
  ADD PRIMARY KEY (`t_azon`),
  ADD KEY `kat_azon_fk_idx` (`kat_azon`),
  ADD KEY `kisz_azon_fk_idx` (`kisz_azon`),
  ADD KEY `kim_azon_fk_idx` (`kim_azon`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `termekek`
--
ALTER TABLE `termekek`
  MODIFY `t_azon` int(11) NOT NULL AUTO_INCREMENT COMMENT 'A termék egyedi azonosítója.', AUTO_INCREMENT=21;
--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `termekek`
--
ALTER TABLE `termekek`
  ADD CONSTRAINT `kat_azon_fk` FOREIGN KEY (`kat_azon`) REFERENCES `kategoriak` (`kat_azon`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `kim_azon_fk` FOREIGN KEY (`kim_azon`) REFERENCES `kiemelesek` (`kim_azon`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `kisz_azon_fk` FOREIGN KEY (`kisz_azon`) REFERENCES `kiszerelesek` (`kisz_azon`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
