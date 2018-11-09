-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-07-11 06:01:11
-- 服务器版本： 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `autoppm`
--

-- --------------------------------------------------------

--
-- 表的结构 `common_table`
--

CREATE TABLE `common_table` (
  `c_id` int(11) UNSIGNED NOT NULL,
  `c_image_num` varchar(30) NOT NULL,
  `c_forging_ratio` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `c_tb_direction` varchar(30) DEFAULT NULL,
  `c_zuan_data` int(5) UNSIGNED DEFAULT NULL,
  `c_image_path` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `common_table`
--

INSERT INTO `common_table` (`c_id`, `c_image_num`, `c_forging_ratio`, `c_tb_direction`, `c_zuan_data`, `c_image_path`) VALUES
(1, 'test', '3\r\n        5:1', '橫向、縱向', 100, '/image/test.png'),
(3, 'test', '3\r\n        5:1', '橫向、縱向', 100, '/image/test.png');

-- --------------------------------------------------------

--
-- 表的结构 `depot_table`
--

CREATE TABLE `depot_table` (
  `dt_id` int(11) NOT NULL,
  `dt_meta_id` int(11) DEFAULT NULL,
  `dt_meta_num` int(11) DEFAULT NULL,
  `dt_op_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `info_table`
--

CREATE TABLE `info_table` (
  `it_id` int(11) NOT NULL,
  `it_order` varchar(10) DEFAULT '""',
  `it_routnum` varchar(30) DEFAULT '""',
  `it_partnum` varchar(30) DEFAULT '""',
  `it_imagenum` varchar(30) DEFAULT '""',
  `it_partname` varchar(30) DEFAULT '""',
  `it_materialnum` varchar(30) DEFAULT '""',
  `it_spec` int(11) DEFAULT NULL,
  `it_quantity` int(11) DEFAULT NULL,
  `it_count` int(5) UNSIGNED NOT NULL DEFAULT '1',
  `it_weight` int(11) DEFAULT NULL,
  `it_batchnum` varchar(30) DEFAULT '""',
  `it_reportnum` varchar(30) DEFAULT '""',
  `it_reportsheetnum` varchar(30) DEFAULT '""',
  `it_testnum` varchar(30) DEFAULT NULL,
  `it_thickness` int(11) DEFAULT NULL,
  `it_sliplen` int(11) DEFAULT NULL,
  `it_quaprovenum` varchar(30) DEFAULT '""',
  `it_metaprovenum` varchar(30) DEFAULT '""',
  `it_cheminum` varchar(30) DEFAULT '""',
  `it_mechnum` varchar(30) DEFAULT '""',
  `it_metalnum` varchar(30) DEFAULT '""'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `info_table`
--

INSERT INTO `info_table` (`it_id`, `it_order`, `it_routnum`, `it_partnum`, `it_imagenum`, `it_partname`, `it_materialnum`, `it_spec`, `it_quantity`, `it_count`, `it_weight`, `it_batchnum`, `it_reportnum`, `it_reportsheetnum`, `it_testnum`, `it_thickness`, `it_sliplen`, `it_quaprovenum`, `it_metaprovenum`, `it_cheminum`, `it_mechnum`, `it_metalnum`) VALUES
(1, '333', '18297', '9431', '222.555-146', '焊接座板 40', '123abc', 250, 155, 1, 240250, '13703011525-27', '2.2.7', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(2, '881', '88023', '4284', '222.555-146', '焊接座板 40', '123abc', 250, 155, 1, 240250, '13703011525-27', '2.2.8', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(3, '241', '55250', '8104', '222.555-293(II)', '杯形管节', '123abc', 350, 310, 1, 672700, '17301031541-1', '2.2.9', 'AFVVR/3-888-88888-GR-345-5', 'D40041', NULL, 60, '160411T0154', '20180513', '(化）字（2016）第31231234号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123126号'),
(4, '150', '52123', '6870', '222.555-293(II)', '杯形管节', '123abc', 350, 310, 1, 672700, '17301031541-1', '2.2.10', 'AFVVR/3-888-88888-GR-345-5', 'D40041', NULL, 60, '160411T0154', '20180513', '(化）字（2016）第31231234号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123126号'),
(5, '581', '18153', '4555', '111.555－55-01 III', '电缆填料函', 'DD586', 100, 345, 1, 213900, '17301031541-1', '2.2.11', 'AFVVR/3-888-88888-GR-345-5', 'D40065', NULL, 60, '160411T0154', '20180515', '(化）字（2016）第31231236号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123128号'),
(6, '837', '82963', '6911', '111.555－55-01 III', '电缆填料函', 'DD586', 100, 345, 1, 213900, '17301031541-1', '2.2.12', 'AFVVR/3-888-88888-GR-345-5', 'D40065', NULL, 60, '160411T0154', '20180515', '(化）字（2016）第31231236号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123128号'),
(7, '721', '35434', '8194', '111.555－55-01 I', '电缆填料函', 'DD586', 100, 115, 1, 71300, '17301031541-1', '2.2.13', 'AFVVR/3-888-88888-GR-345-5', 'D40065', NULL, 60, '160411T0154', '20180515', '(化）字（2016）第31231236号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123128号'),
(8, '604', '72450', '9291', '111.555－55-01 I', '电缆填料函', 'DD586', 100, 115, 1, 71300, '17301031541-1', '2.2.14', 'AFVVR/3-888-88888-GR-345-5', 'D40065', NULL, 60, '160411T0154', '20180515', '(化）字（2016）第31231236号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123128号'),
(9, '90', '80310', '2002', '111.555－55-01 Ⅷ', '电缆杯形管节', 'DD586', 180, 115, 1, 128340, '17301031541-1', '2.2.15', 'AFVVR/3-888-88888-GR-345-5', 'D40066', NULL, 60, '160411T0154', '20180514', '(化）字（2016）第31231235号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123127号'),
(10, '574', '61944', '3845', '111.555－55-01 Ⅷ', '电缆杯形管节', 'DD586', 180, 230, 1, 256680, '17301031541-1', '2.2.16', 'AFVVR/3-888-88888-GR-345-5', 'D40066', NULL, 60, '160411T0154', '20180514', '(化）字（2016）第31231235号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123127号'),
(11, '405', '88500', '1801', '111.555－55-01 Ⅷ', '电缆杯形管节', 'DD586', 180, 230, 1, 256680, '17301031541-1', '2.2.17', 'AFVVR/3-888-88888-GR-345-5', 'D40066', NULL, 60, '160411T0154', '20180514', '(化）字（2016）第31231235号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123127号'),
(12, '74', '41361', '4017', '111.555－55-01 Ⅷ', '电缆杯形管节', 'DD586', 180, 115, 1, 128340, '17301031541-1', '2.2.18', 'AFVVR/3-888-88888-GR-345-5', 'D40066', NULL, 60, '160411T0154', '20180514', '(化）字（2016）第31231235号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123127号'),
(13, '717', '97925', '7448', '111.555－57', '电缆焊接垫套', 'DD586', 250, 65, 1, 100750, '17301031541-1', '2.2.19', 'AFVVR/3-888-88888-GR-345-5', 'D40068', NULL, 60, '160411T0154', '20180516', '(化）字（2016）第31231237号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123129号'),
(14, '174', '25861', '7400', '111.555－57', '电缆焊接垫套', 'DD586', 250, 65, 1, 100750, '17301031541-1', '2.2.20', 'AFVVR/3-888-88888-GR-345-5', 'D40068', NULL, 60, '160411T0154', '20180516', '(化）字（2016）第31231237号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123129号'),
(15, '935', '45261', '9234', '111.555－56', '电缆焊接垫套', 'DD586', 250, 75, 1, 116250, '17301031541-1', '2.2.21', 'AFVVR/3-888-88888-GR-345-5', 'D40068', NULL, 70, '160411T0154', '20180516', '(化）字（2016）第31231237号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123129号'),
(16, '56', '59013', '9094', '111.555－56', '电缆焊接垫套', 'DD586', 250, 75, 1, 116250, '17301031541-1', '2.2.22', 'AFVVR/3-888-88888-GR-345-5', 'D40068', NULL, 60, '160411T0154', '20180516', '(化）字（2016）第31231237号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123129号'),
(17, '510', '55766', '2385', '222.555-147', '杯形管节 50', '123abc', 180, 320, 1, 357120, '17303011573-21', '2.3.156', 'AFVVR/3-888-88888-GR-345-5', 'D40047', NULL, 70, '160411T0154', '20180517', '(化）字（2016）第31231238号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123130号'),
(18, '662', '33177', '7321', '222.555-147', '杯形管节 50', '123abc', 180, 320, 1, 357120, '17303011573-21', '2.3.157', 'AFVVR/3-888-88888-GR-345-5', 'D40047', NULL, 60, '160411T0154', '20180517', '(化）字（2016）第31231238号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123130号'),
(19, '596', '37000', '4926', '222.555-147', '杯形管节 50', '123abc', 180, 320, 1, 357120, '17303011573-21', '2.3.158', 'AFVVR/3-888-88888-GR-345-5', 'D40047', NULL, 60, '160411T0154', '20180517', '(化）字（2016）第31231238号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123130号'),
(20, '755', '25044', '9703', '222.555-147', '杯形管节 50', '123abc', 180, 320, 1, 357120, '17303011573-21', '2.3.159', 'AFVVR/3-888-88888-GR-345-5', 'D40047', NULL, 60, '160411T0154', '20180517', '(化）字（2016）第31231238号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123130号'),
(21, '236', '54209', '9252', '222.555-147', '杯形管节 50', '123abc', 180, 320, 1, 357120, '17303011573-21', '2.3.160', 'AFVVR/3-888-88888-GR-345-5', 'D40047', NULL, 70, '160411T0154', '20180517', '(化）字（2016）第31231238号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123130号'),
(22, '988', '67626', '9122', '222.555-147', '杯形管节 50', '123abc', 180, 320, 1, 357120, '17303011573-21', '2.3.161', 'AFVVR/3-888-88888-GR-345-5', 'D40047', NULL, 80, '160411T0154', '20180517', '(化）字（2016）第31231238号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123130号'),
(23, '426', '32509', '8456', '222.555-147', '杯形管节 50', '123abc', 180, 320, 1, 357120, '17303011573-21', '2.3.162', 'AFVVR/3-888-88888-GR-345-5', 'D40047', NULL, 60, '160411T0154', '20180517', '(化）字（2016）第31231238号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123130号'),
(24, '729', '41068', '3566', '222.555-299', '焊接座板', '123abc', 180, 320, 1, 357120, '17303011573-22', '2.3.163', 'AFVVR/3-888-88888-GR-345-5', 'D40047', NULL, 80, '160411T0154', '20180518', '(化）字（2016）第31231239号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123131号'),
(25, '84', '56339', '7283', '222.555-299', '焊接座板', '123abc', 180, 320, 1, 357120, '17303011573-22', '2.3.164', 'AFVVR/3-888-88888-GR-345-5', 'D40047', NULL, 50, '160411T0154', '20180518', '(化）字（2016）第31231239号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123131号'),
(26, '95', '97050', '6212', '222.555-299', '焊接座板', '123abc', 180, 320, 1, 357120, '17303011573-22', '2.3.165', 'AFVVR/3-888-88888-GR-345-5', 'D40047', NULL, 60, '160411T0154', '20180518', '(化）字（2016）第31231239号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123131号'),
(27, '608', '59631', '8581', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.166', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(28, '738', '60082', '7380', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.167', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 70, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(29, '737', '20781', '5624', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.168', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(30, '516', '10522', '6956', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.169', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(31, '860', '79810', '8941', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.170', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(32, '413', '99744', '6030', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.171', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(33, '1', '17248', '4238', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.172', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(34, '956', '46287', '5519', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.173', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(35, '629', '79233', '7010', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.174', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(36, '860', '43496', '9055', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.175', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(37, '393', '72595', '1425', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.176', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(38, '218', '15125', '4652', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.177', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(39, '893', '93404', '1850', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.178', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(40, '250', '97778', '8003', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.179', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(41, '171', '55183', '3638', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.180', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(42, '910', '10299', '6848', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.181', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(43, '179', '80188', '7555', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.182', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(44, '203', '32398', '8819', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.183', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(45, '608', '46616', '5958', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.184', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(46, '87', '91482', '8711', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.185', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(47, '339', '87444', '4898', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.186', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(48, '358', '39887', '6523', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.187', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(49, '96', '73312', '9917', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.188', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(50, '796', '51709', '4281', '222.555-146', '焊接座板 32', '123abc', 250, 55, 1, 85250, '17303011525-30', '2.3.189', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(51, '484', '40761', '6739', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.190', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(52, '396', '99208', '5161', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.191', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(53, '486', '12334', '4555', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.192', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(54, '541', '58379', '9056', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.193', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(55, '831', '96188', '1756', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.194', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(56, '51', '48012', '9949', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.195', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(57, '552', '42425', '7971', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.196', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(58, '580', '59069', '2704', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.197', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(59, '413', '55302', '2793', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.198', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(60, '442', '70561', '6798', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.199', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(61, '585', '55127', '8425', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.200', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(62, '557', '57941', '1257', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.201', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(63, '939', '32027', '9432', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.202', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(64, '814', '75122', '1594', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.203', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(65, '743', '27666', '9269', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.204', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(66, '660', '99810', '9147', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.205', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(67, '64', '77073', '6289', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.206', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(68, '619', '49822', '7569', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.207', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(69, '991', '70959', '6304', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.208', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(70, '652', '27754', '4972', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.209', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(71, '547', '20292', '3846', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.210', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(72, '198', '95542', '3502', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.211', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(73, '159', '14952', '5869', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.212', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(74, '887', '66416', '4303', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.213', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(75, '830', '34034', '1180', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.214', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(76, '79', '74097', '1278', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.215', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(77, '474', '12244', '2930', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.216', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(78, '74', '96588', '8259', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.217', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(79, '165', '98797', '2860', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.218', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(80, '77', '65441', '4547', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.219', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(81, '661', '95288', '5238', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.220', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(82, '679', '78137', '5644', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.221', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(83, '295', '62969', '3615', '222.555-146', '焊接座板 40', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.222', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(84, '842', '67664', '5976', '222.555-297-00', '焊接座架 （I）', '123abc', 250, 62, 1, 96100, '13703011525-27', '2.3.223', 'AFVVR/3-888-88888-GR-345-5', 'D40043', NULL, 60, '160411T0154', '20180510', '(化）字（2016）第31231231号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123123号'),
(85, '1000', '73903', '4105', '222.555-297-00', '焊接座架 （I）', '123abc', 250, 62, 1, 96100, '17303011495-3', '2.3.224', 'AFVVR/3-888-88888-GR-345-5', 'D40089', NULL, 60, '160411T0154', '20180511', '(化）字（2016）第31231232号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123124号'),
(86, '983', '13058', '7907', '222.555-297-00', '焊接座架 （I）', '123abc', 250, 62, 1, 96100, '17303011495-3', '2.3.225', 'AFVVR/3-888-88888-GR-345-5', 'D40052', NULL, 60, '160411T0154', '20180511', '(化）字（2016）第31231232号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123124号'),
(87, '698', '87549', '6682', '222.555-146', '焊接座板 50', '123abc', 250, 68, 1, 105400, '17303011525-30', '2.3.226', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(88, '82', '77576', '3192', '222.555-146', '焊接座板 50', '123abc', 250, 68, 1, 105400, '17303011525-30', '2.3.227', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(89, '16', '42279', '2791', '222.555-146', '焊接座板 50', '123abc', 250, 68, 1, 105400, '17303011525-30', '2.3.228', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(90, '58', '56151', '3780', '222.555-146', '焊接座板 60', '123abc', 250, 68, 1, 105400, '17303011525-30', '2.3.229', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(91, '537', '63597', '6663', '222.555-146', '焊接座板 70', '123abc', 250, 68, 1, 105400, '17303011525-30', '2.3.230', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(92, '186', '15344', '2745', '222.555-146', '焊接座板 70', '123abc', 250, 68, 1, 105400, '17303011525-30', '2.3.231', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(93, '171', '37066', '1019', '222.555-146', '焊接座板 70', '123abc', 250, 68, 1, 105400, '17303011525-30', '2.3.232', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(94, '589', '14209', '2996', '222.555-146', '焊接座板 70', '123abc', 250, 68, 1, 105400, '17303011525-30', '2.3.233', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(95, '543', '41867', '3344', '222.555-146', '焊接座板 70', '123abc', 250, 68, 1, 105400, '17303011525-30', '2.3.234', 'AFVVR/3-888-88888-GR-345-5', 'D40044', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(96, '480', '22376', '8923', '222.555-296', '杯形管节 (IV)', '123abc', 250, 495, 1, 767250, '17303011525-30', '2.3.235', 'AFVVR/3-888-88888-GR-345-5', 'D40058', NULL, 60, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(97, '44', '52224', '1369', '222.555-296', '杯形管节 (IV)', '123abc', 250, 605, 1, 937750, '17303011525-30', '2.3.236', 'AFVVR/3-888-88888-GR-345-5', 'D40058', NULL, 160, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(98, '319', '84813', '7628', '222.555-296', '杯形管节 (IV)', '123abc', 250, 605, 1, 937750, '17303011525-30', '2.3.237', 'AFVVR/3-888-88888-GR-345-5', 'D40058', NULL, 160, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(99, '821', '65686', '1612', '222.555-262-00', '杯形管节', '123abc', 250, 650, 1, 1007500, '17303011525-30', '2.3.238', 'AFVVR/3-888-88888-GR-345-5', 'D40060', NULL, 120, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号'),
(100, '810', '29229', '4483', '222.555-262-00', '杯形管节', '123abc', 250, 650, 1, 1007500, '17303011525-30', '2.3.239', 'AFVVR/3-888-88888-GR-345-5', 'D40060', NULL, 120, '160411T0154', '20180512', '(化）字（2016）第31231233号', '(力）字（2016）第12312312312号', '(金）字（2016）第123123125号');

-- --------------------------------------------------------

--
-- 表的结构 `process_status`
--

CREATE TABLE `process_status` (
  `ps_id` int(8) NOT NULL,
  `ps_percent` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `process_status`
--

INSERT INTO `process_status` (`ps_id`, `ps_percent`) VALUES
(1, 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `common_table`
--
ALTER TABLE `common_table`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `image_index` (`c_image_num`);

--
-- Indexes for table `depot_table`
--
ALTER TABLE `depot_table`
  ADD PRIMARY KEY (`dt_id`);

--
-- Indexes for table `info_table`
--
ALTER TABLE `info_table`
  ADD KEY `it_id` (`it_id`);

--
-- Indexes for table `process_status`
--
ALTER TABLE `process_status`
  ADD KEY `ps_id` (`ps_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `common_table`
--
ALTER TABLE `common_table`
  MODIFY `c_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `depot_table`
--
ALTER TABLE `depot_table`
  MODIFY `dt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `info_table`
--
ALTER TABLE `info_table`
  MODIFY `it_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- 使用表AUTO_INCREMENT `process_status`
--
ALTER TABLE `process_status`
  MODIFY `ps_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;