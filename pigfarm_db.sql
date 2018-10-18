-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2018-10-18 22:22:16
-- 服务器版本： 5.5.59-log
-- PHP Version: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pigfarm_db`
--

-- --------------------------------------------------------

--
-- 表的结构 `pig_cwh`
--

CREATE TABLE IF NOT EXISTS `pig_cwh` (
  `id` int(10) unsigned NOT NULL COMMENT '场id',
  `xmname` varchar(100) NOT NULL COMMENT '项目',
  `region` varchar(100) NOT NULL COMMENT '所属区域',
  `province` varchar(100) NOT NULL COMMENT '所属省份',
  `zgs` varchar(100) NOT NULL COMMENT '所属子公司',
  `address` varchar(200) NOT NULL COMMENT '地址',
  `fzrname` varchar(50) NOT NULL COMMENT '负责人',
  `tel` varchar(20) NOT NULL COMMENT '电话',
  `explains` varchar(255) NOT NULL COMMENT '说明',
  `bjtel` varchar(20) NOT NULL COMMENT '报警电话',
  `time` time NOT NULL COMMENT '添加时间'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='场列表';

--
-- 转存表中的数据 `pig_cwh`
--

INSERT INTO `pig_cwh` (`id`, `xmname`, `region`, `province`, `zgs`, `address`, `fzrname`, `tel`, `explains`, `bjtel`, `time`) VALUES
(1, '项目项目项目项目项目项目项目项目', '华南地区', '山东省', '所属子公司所属子公司', '地址地址地址地址地址地址地址', '负责人', '15764272571', '说明说明说明说明说明说明说明说明说明说明说明说明说明', '15764272573', '00:00:00'),
(2, '1', '1', '1', '1', '1', '1', '11', '1', '1', '00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pig_cwh`
--
ALTER TABLE `pig_cwh`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pig_cwh`
--
ALTER TABLE `pig_cwh`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '场id',AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
