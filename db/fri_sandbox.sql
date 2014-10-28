-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: Út 28.Okt 2014, 23:49
-- Verzia serveru: 5.6.20
-- Verzia PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáza: `fri_sandbox`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `article`
--

CREATE TABLE IF NOT EXISTS `article` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `published` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Sťahujem dáta pre tabuľku `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `published`) VALUES
(1, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet consectetuer nec tincidunt rhoncus dolor nibh. Pretium ligula enim sed pellentesque orci pretium Maecenas vel semper eget. Pellentesque consectetuer leo laoreet tincidunt semper Nulla nulla non ligula semper. Neque sed Maecenas Integer tortor mollis velit laoreet eu orci non. Orci convallis non magnis et orci eu Sed.\r\n\r\n', '2014-10-01 00:00:00'),
(2, 'Accumsan ligula et enim lacinia', 'Accumsan ligula et enim lacinia Sed condimentum Phasellus convallis neque consectetuer. Suspendisse porttitor facilisis Aliquam urna hendrerit euismod at vitae interdum elit. Nulla Curabitur adipiscing congue et rhoncus montes sociis urna eget ultrices. Adipiscing Phasellus tempor adipiscing consequat enim et purus In nunc venenatis. Tincidunt metus libero Nam mus consequat eget Curabitur ut quis consectetuer. Sit dignissim quis malesuada Nam porta ante rutrum nulla dignissim nunc. Turpis adipiscing In.', '2014-10-02 00:00:00'),
(3, 'Dolor lorem orci consequat nibh', 'Dolor lorem orci consequat nibh tincidunt tellus vitae ligula interdum cursus. Semper congue mattis ac velit nunc at pretium in pellentesque laoreet. Nulla turpis vitae condimentum eget Aenean Aliquam Phasellus Lorem mollis Nunc. Et pretium nulla Donec magnis consequat consectetuer pede convallis ligula faucibus. Pellentesque ac gravida orci elit netus Vestibulum Nullam vel nibh turpis. Eros pede id fames vel at venenatis turpis.', '2014-10-03 00:00:00');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `age` int(10) unsigned NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `lastLog` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Sťahujem dáta pre tabuľku `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `email`, `age`, `password`, `lastLog`) VALUES
(2, 'Poke', 'Mon', 'poke@mon.com', 24, '6e017b5464f820a6c1bb5e9f6d711a667a80d8ea', '2014-10-28 23:03:02'),
(5, 'John', 'Doe', 'john@doe.com', 26, '6e017b5464f820a6c1bb5e9f6d711a667a80d8ea', '2014-10-28 23:47:28'),
(7, 'Jožko', 'Mrkvička', 'jozko@mrkvicka.sk', 20, '6e017b5464f820a6c1bb5e9f6d711a667a80d8ea', NULL),
(9, 'Anička', 'Malá', 'anicka@mala.sk', 16, '6e017b5464f820a6c1bb5e9f6d711a667a80d8ea', NULL);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `usergroup`
--

CREATE TABLE IF NOT EXISTS `usergroup` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Sťahujem dáta pre tabuľku `usergroup`
--

INSERT INTO `usergroup` (`id`, `name`, `description`) VALUES
(2, 'Skupina A', '<p>Velit laoreet eros enim non adipiscing hendrerit laoreet Sed metus sodales. Mollis nunc lacus odio lacinia Morbi leo sem auctor ut ac. Vestibulum cursus velit at aliquet Ut Vivamus pulvinar platea eleifend laoreet. Tempus vitae enim laoreet Nullam Vivamus justo eget tempus vel a. Ut cursus habitant et pede metus id a Suspendisse accumsan nec. Non.</p> <p>Risus leo dictumst eu et adipiscing adipiscing convallis sem fermentum magna. Justo adipiscing et interdum penatibus purus amet Suspendisse tortor velit urna. Nam risus eu In Lorem ante nulla commodo eleifend nec Aliquam. Curabitur facilisi tempus sit malesuada metus tempor Suspendisse urna ut laoreet. Accumsan nulla Maecenas Maecenas lacinia ante adipiscing quis Vestibulum interdum hac. Amet porttitor dui et pellentesque convallis interdum turpis Vestibulum mauris elit. Sed sem.</p> <p>Facilisis pede quis egestas Integer at a elit Donec eros Maecenas. Vel ac Morbi tristique dictumst a fringilla turpis dolor Lorem faucibus. Diam congue ligula In Donec nec gravida nunc feugiat id Vivamus. Nec id nibh quam risus tempus elit convallis at risus ante. Justo netus ut orci vestibulum Morbi at Nulla urna dapibus justo. Sed nunc convallis non Curabitur cursus eu.</p>'),
(4, 'Skupina B', '<p>Lorem ipsum dolor sit amet consectetuer pretium Curabitur quis Phasellus ligula. Nam in mauris amet In vitae eu scelerisque Curabitur Curabitur aliquet. Gravida nonummy et convallis Vestibulum ut eu lobortis felis Vestibulum ut. Vel suscipit amet nisl odio Nulla Vivamus orci nunc tortor eros. Nullam nunc Vestibulum velit nec et malesuada quis habitant fringilla eu. Mollis hendrerit Aenean neque gravida hendrerit elit consectetuer fringilla Pellentesque at. </p><p>Gravida laoreet et elit pede feugiat orci Vestibulum mauris id condimentum. Neque sem Nam quis vel gravida Sed commodo orci Vestibulum Nunc. Suspendisse egestas ut Nullam Sed consequat Curabitur leo velit convallis id. Elit Aenean vitae est In cursus Nulla felis ac Pellentesque ligula. Ac Nam arcu nunc quis mi pede id ut ornare urna. Justo ac sed.</p>');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `user_usergroup`
--

CREATE TABLE IF NOT EXISTS `user_usergroup` (
  `user_id` int(10) unsigned NOT NULL,
  `usergroup_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Sťahujem dáta pre tabuľku `user_usergroup`
--

INSERT INTO `user_usergroup` (`user_id`, `usergroup_id`) VALUES
(2, 2),
(5, 2),
(5, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `usergroup`
--
ALTER TABLE `usergroup`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `user_usergroup`
--
ALTER TABLE `user_usergroup`
 ADD KEY `user_id` (`user_id`,`usergroup_id`), ADD KEY `usergroup_id` (`usergroup_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `usergroup`
--
ALTER TABLE `usergroup`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Obmedzenie pre exportované tabuľky
--

--
-- Obmedzenie pre tabuľku `user_usergroup`
--
ALTER TABLE `user_usergroup`
ADD CONSTRAINT `user_usergroup_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `user_usergroup_ibfk_2` FOREIGN KEY (`usergroup_id`) REFERENCES `usergroup` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
