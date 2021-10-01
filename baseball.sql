-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2021 年 10 月 01 日 12:12
-- サーバのバージョン： 5.7.34
-- PHP のバージョン: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `baseball`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `bb_predict`
--

CREATE TABLE `bb_predict` (
  `id` int(12) NOT NULL,
  `getscore` int(12) NOT NULL,
  `lostscore` int(12) NOT NULL,
  `winlose` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `bb_predict`
--

INSERT INTO `bb_predict` (`id`, `getscore`, `lostscore`, `winlose`, `name`, `comment`, `date`) VALUES
(36, 3, 5, 'lose', 'MA', '巨人4連敗、、、、、、、、', '2021-09-29 23:47:14');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `bb_predict`
--
ALTER TABLE `bb_predict`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `bb_predict`
--
ALTER TABLE `bb_predict`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
