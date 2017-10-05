-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2017-09-29 17:52:44
-- 伺服器版本: 10.1.21-MariaDB
-- PHP 版本： 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `reminder`
--

-- --------------------------------------------------------

--
-- 資料表結構 `categorys`
--

CREATE TABLE `categorys` (
  `id` int(11) NOT NULL COMMENT '編號',
  `name` varchar(20) NOT NULL COMMENT '帳號',
  `remark` varchar(50) NOT NULL COMMENT '備註',
  `build_time` int(11) NOT NULL COMMENT '建立時間',
  `op_time` int(11) NOT NULL COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='類別';

--
-- 資料表的匯出資料 `categorys`
--

INSERT INTO `categorys` (`id`, `name`, `remark`, `build_time`, `op_time`) VALUES
(1, '我是類別1-11', '', 1506678162, 1506678197),
(2, '我是類別2', '', 1506678167, 0),
(3, '我是類別3', '', 1506678173, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `reminders`
--

CREATE TABLE `reminders` (
  `id` int(11) NOT NULL COMMENT '編號',
  `title` varchar(20) NOT NULL COMMENT '標題',
  `remind_time` int(11) NOT NULL COMMENT '提醒時間',
  `isCompleted` tinyint(1) NOT NULL COMMENT '是否完成',
  `categoryId` int(11) NOT NULL COMMENT '類別編號',
  `remark` varchar(50) NOT NULL COMMENT '備註',
  `build_time` int(11) NOT NULL COMMENT '建立時間',
  `op_time` int(11) NOT NULL COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提醒事項';

--
-- 資料表的匯出資料 `reminders`
--

INSERT INTO `reminders` (`id`, `title`, `remind_time`, `isCompleted`, `categoryId`, `remark`, `build_time`, `op_time`) VALUES
(1, '我是標題', 1504368000, 0, 1, '', 1506678631, 0),
(2, '我是標題2', 1505836800, 0, 2, '', 1506678668, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `reminders_tag`
--

CREATE TABLE `reminders_tag` (
  `id` int(11) NOT NULL COMMENT '編號',
  `reminderId` int(20) NOT NULL COMMENT '提醒事項編號',
  `tagId` int(11) NOT NULL COMMENT '標籤Id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提醒事項標籤';

--
-- 資料表的匯出資料 `reminders_tag`
--

INSERT INTO `reminders_tag` (`id`, `reminderId`, `tagId`) VALUES
(2, 1, 1),
(1, 1, 3),
(3, 2, 2);

-- --------------------------------------------------------

--
-- 資料表結構 `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL COMMENT '編號',
  `name` varchar(20) NOT NULL COMMENT '帳號',
  `remark` varchar(50) NOT NULL COMMENT '備註',
  `build_time` int(11) NOT NULL COMMENT '建立時間',
  `op_time` int(11) NOT NULL COMMENT '更新時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='標籤';

--
-- 資料表的匯出資料 `tags`
--

INSERT INTO `tags` (`id`, `name`, `remark`, `build_time`, `op_time`) VALUES
(1, '我是標籤1', '', 1506677981, 0),
(2, '我是標籤2', '', 1506677992, 0),
(3, '我是標籤3', '', 1506677997, 0);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `categorys`
--
ALTER TABLE `categorys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 資料表索引 `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `reminders_tag`
--
ALTER TABLE `reminders_tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reminderId` (`reminderId`,`tagId`);

--
-- 資料表索引 `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `categorys`
--
ALTER TABLE `categorys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '編號', AUTO_INCREMENT=4;
--
-- 使用資料表 AUTO_INCREMENT `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '編號', AUTO_INCREMENT=3;
--
-- 使用資料表 AUTO_INCREMENT `reminders_tag`
--
ALTER TABLE `reminders_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '編號', AUTO_INCREMENT=4;
--
-- 使用資料表 AUTO_INCREMENT `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '編號', AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
