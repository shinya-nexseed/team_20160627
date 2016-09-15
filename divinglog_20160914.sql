-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016 年 9 月 14 日 09:00
-- サーバのバージョン： 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `divinglog`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `following`
--

CREATE TABLE `following` (
  `follow_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `licenses`
--

CREATE TABLE `licenses` (
  `license_id` int(11) NOT NULL,
  `license` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `licenses`
--

INSERT INTO `licenses` (`license_id`, `license`) VALUES
(2, 'レスキュー'),
(3, 'マスター'),
(0, 'オープン'),
(1, 'アドバンス'),
(4, '童貞');

-- --------------------------------------------------------

--
-- テーブルの構造 `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `depth` int(11) NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `temperature` int(11) NOT NULL,
  `surface` int(11) NOT NULL,
  `underwater` int(11) NOT NULL,
  `suits` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `tank` int(11) NOT NULL,
  `ltank` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `logs`
--

INSERT INTO `logs` (`log_id`, `title`, `depth`, `lat`, `lng`, `temperature`, `surface`, `underwater`, `suits`, `comment`, `image_path`, `tank`, `ltank`, `member_id`, `created`, `modified`) VALUES
(18, 'issinlog', 35, '39.72831359282791', '127.74902299999997', 30, 30, 26, '5', '北朝鮮楽しかった！！', '20160908072820IMG_3788.jpg', 200, 30, 10, '2016-09-08 13:28:20', '2016-09-08 05:28:20'),
(19, '2quad', -1000, '10.31432841403968', '123.90535310864254', 29, -1000, -1000, '0', 'ako si yuri', '20160908073354IMG_3657.jpg', 190, 10, 11, '2016-09-08 13:33:54', '2016-09-08 05:33:54'),
(20, '硫黄島', 20, '24.761796732699487', '141.30615190624997', 26, 22, 19, '0', '硫黄島楽しかった！', '20160908073744IMG_3495.jpg', 200, 0, 12, '2016-09-08 13:37:44', '2016-09-08 05:37:44'),
(21, 'ロシア', 46, '53.50438443126013', '108.76464799999997', 2, -1000, 3, '0', '寒かった', '20160908074026IMG_3531.jpg', -1000, 10, 13, '2016-09-08 13:40:26', '2016-09-08 05:40:26'),
(23, '地元！恩納村！', 1, '26.441065776546417', '127.80670122265622', 33, 29, 25, '-1000', '地元だよん！', '20160908074830IMG_3532.jpg', 10, -1000, 14, '2016-09-08 13:48:30', '2016-09-08 05:48:30'),
(24, '南極！！！！', 49, '-70.04122308885523', '76.42089799999997', -1000, -1000, -1000, '0', '南に行ったらあったかいと思ったのに・・・寒かった', '20160908075230IMG_2149.jpg', 200, 0, 15, '2016-09-08 13:52:30', '2016-09-08 05:52:30');

-- --------------------------------------------------------

--
-- テーブルの構造 `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `picture_path` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `license_id` int(11) NOT NULL,
  `delete_flag` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `members`
--

INSERT INTO `members` (`id`, `name`, `password`, `email`, `picture_path`, `country`, `license_id`, `delete_flag`, `created`, `modified`) VALUES
(10, 'issin', 'fe62e017947eb2c8e9b3ffaf8c273544059e100d', 'issin@issin', '20160908072550IMG_4075.jpg', 'japan', 0, 0, '2016-09-08 07:25:55', '2016-09-08 05:25:55'),
(11, 'yuri', 'aaf6fd97230863eae371b8b6c4c40693d5d84b30', 'yuri@yuri', '20160908072946IMG_0979.jpg', 'japan', 1, 0, '2016-09-08 07:29:49', '2016-09-08 05:29:49'),
(12, 'gaku', 'f6b1b6e5d2c878a0c9e2a4cec3b269b4a08ea2ef', 'gaku@gaku', '20160908073505IMG_4071.jpg', 'japan', 2, 0, '2016-09-08 07:35:07', '2016-09-08 05:35:07'),
(13, 'kento', '296772f418d516ab770e6cfa0e18dc5c52443fb2', 'kento@kento', '20160908073829IMG_1967.jpg', 'america', 3, 0, '2016-09-08 07:38:31', '2016-09-08 05:38:31'),
(14, 'ichi', '63441e6bf2b8ca7fb5dc9f3e46bf82f397d13651', 'ichi@ichi', '20160908074122IMG_2354.jpg', 'japan', 4, 0, '2016-09-08 07:41:23', '2016-09-08 05:41:23'),
(15, '平井真哉様', 'd0e9ea4e903150ceca4d5ddbb0b7df31432f0728', 'sinya@sinya', '20160908075018IMG_2684.jpg', 'america', 4, 0, '2016-09-08 07:50:21', '2016-09-08 05:50:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
