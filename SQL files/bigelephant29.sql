-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2014-05-24: 08:45:15
-- 伺服器版本: 5.6.16
-- PHP 版本： 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫： `pd course`
--

-- --------------------------------------------------------

--
-- 資料表結構 `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `group_num` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `best_score` float NOT NULL,
  `worst_score` float NOT NULL,
  `total_score` float NOT NULL,
  PRIMARY KEY (`group_num`),
  UNIQUE KEY `group_num` (`group_num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 資料表結構 `lab_hw`
--

CREATE TABLE IF NOT EXISTS `lab_hw` (
  `lab_id` varchar(10) NOT NULL,
  `submit_code` tinyint(1) NOT NULL,
  `submit_pdf` tinyint(1) NOT NULL,
  `data_number` int(11) NOT NULL,
  `total_score` int(11) NOT NULL,
  `deadline` datetime NOT NULL,
  PRIMARY KEY (`lab_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 資料表結構 `lab_score`
--

CREATE TABLE IF NOT EXISTS `lab_score` (
  `s_id` int(11) NOT NULL,
  `lab_id` varchar(10) NOT NULL,
  `status` text CHARACTER SET armscii8 NOT NULL,
  `time` datetime NOT NULL,
  `exec_time` float NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`s_id`,`lab_id`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 資料表結構 `past_hw`
--

CREATE TABLE IF NOT EXISTS `past_hw` (
  `past_id` varchar(10) NOT NULL,
  `total_score` int(11) NOT NULL,
  PRIMARY KEY (`past_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 資料表結構 `past_score`
--

CREATE TABLE IF NOT EXISTS `past_score` (
  `s_id` int(11) NOT NULL,
  `past_id` varchar(10) NOT NULL,
  `status` text NOT NULL,
  `time` datetime NOT NULL,
  `exec_time` float NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`s_id`,`past_id`,`time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 資料表結構 `pd_hw`
--

CREATE TABLE IF NOT EXISTS `pd_hw` (
  `p_id` varchar(10) NOT NULL,
  `submit_code` tinyint(1) NOT NULL,
  `submit_pdf` tinyint(1) NOT NULL,
  `data_number` int(1) NOT NULL DEFAULT '1',
  `total_score` int(11) NOT NULL,
  `deadline` datetime NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `pd_hw`
--

INSERT INTO `pd_hw` (`p_id`, `submit_code`, `submit_pdf`, `data_number`, `total_score`, `deadline`) VALUES
('P_TESTPRO', 1, 0, 4, 100, '3014-05-15 23:59:59'),
('P_STACKSZ', 1, 0, 2, 8, '3014-05-15 23:59:59');

-- --------------------------------------------------------

--
-- 資料表結構 `pd_score`
--

CREATE TABLE IF NOT EXISTS `pd_score` (
  `s_id` int(11) NOT NULL,
  `p_id` varchar(10) NOT NULL,
  `status` text CHARACTER SET armscii8 NOT NULL,
  `time` datetime NOT NULL,
  `exec_time` float NOT NULL,
  `score` int(11) NOT NULL,
  `result` varchar(4096) DEFAULT NULL,
  PRIMARY KEY (`s_id`,`p_id`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `pd_score`
--

INSERT INTO `pd_score` (`s_id`, `p_id`, `status`, `time`, `exec_time`, `score`, `result`) VALUES
(72, 'P_STACKSZ', 'Accepted', '2014-05-24 13:16:04', 0, 8, '4,4,'),
(72, 'P_TESTPRO', 'Time limit exceed', '2014-05-24 13:16:17', 1, 84, '0,23,41,20,'),
(72, 'P_TESTPRO', 'Time limit exceed', '2014-05-24 13:17:54', 1, 84, '0,23,41,20,'),
(74, 'P_STACKSZ', 'Accepted', '2014-05-24 13:36:48', 0, 8, '4,4,'),
(75, 'P_TESTPRO', 'Time limit exceed', '2014-05-24 13:39:35', 1, 84, '0,23,41,20,'),
(75, 'P_TESTPRO', 'Accepted', '2014-05-24 13:39:54', 0, 95, '11,23,41,20,'),
(75, 'P_TESTPRO', 'Accepted', '2014-05-24 13:42:29', 0, 95, '11,23,41,20,'),
(75, 'P_TESTPRO', 'Accepted', '2014-05-24 13:43:40', 0, 95, '11,23,41,20,'),
(75, 'P_TESTPRO', 'Accepted', '2014-05-24 13:44:24', 0, 95, '11,23,41,20,'),
(75, 'P_TESTPRO', 'Wrong answer', '2014-05-24 13:47:43', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Wrong answer', '2014-05-24 13:48:49', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Wrong answer', '2014-05-24 13:49:10', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Wrong answer', '2014-05-24 13:49:53', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Wrong answer', '2014-05-24 13:56:29', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Wrong answer', '2014-05-24 13:56:59', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Wrong answer', '2014-05-24 13:57:44', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Wrong answer', '2014-05-24 14:02:16', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Wrong answer', '2014-05-24 14:02:41', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Time limit exceed', '2014-05-24 14:03:36', 1, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Wrong answer', '2014-05-24 14:03:45', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Time limit exceed', '2014-05-24 14:07:25', 1, 84, '0,23,41,20,'),
(75, 'P_TESTPRO', 'Wrong answer', '2014-05-24 14:07:34', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Compilation error', '2014-05-24 14:14:26', 0, 0, ''),
(75, 'P_TESTPRO', 'Wrong answer', '2014-05-24 14:14:57', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Compilation error', '2014-05-24 14:15:05', 0, 0, ''),
(75, 'P_TESTPRO', 'Compilation error', '2014-05-24 14:16:11', 0, 0, ''),
(75, 'P_TESTPRO', 'Time limit exceed', '2014-05-24 14:16:34', 1, 84, '0,23,41,20,'),
(75, 'P_TESTPRO', 'Wrong answer', '2014-05-24 14:17:11', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Wrong answer', '2014-05-24 14:37:05', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Wrong answer', '2014-05-24 14:38:22', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Runtime error', '2014-05-24 14:39:46', 0, 0, '0,0,0,0,'),
(75, 'P_TESTPRO', 'Time limit exceed', '2014-05-24 14:39:55', 1, 84, '0,23,41,20,');

-- --------------------------------------------------------

--
-- 資料表結構 `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(11) NOT NULL,
  `total_score` int(11) NOT NULL,
  `deadline` datetime NOT NULL,
  `onjudge` tinyint(1) NOT NULL,
  `isUpdate` bigint(20) NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 資料表結構 `project_group`
--

CREATE TABLE IF NOT EXISTS `project_group` (
  `project_id` int(11) NOT NULL,
  `group_num` int(11) NOT NULL,
  `status` text,
  `time` datetime DEFAULT NULL,
  `exec_time` float DEFAULT NULL,
  `distance1` int(11) DEFAULT '-1',
  `distance2` int(11) DEFAULT '-1',
  `distance3` int(11) DEFAULT '-1',
  `distance4` int(11) DEFAULT '-1',
  `distance5` int(11) DEFAULT '-1',
  `distance6` int(11) DEFAULT '-1',
  `distance7` int(11) DEFAULT '-1',
  `distance8` int(11) DEFAULT '-1',
  `distance9` int(11) DEFAULT '-1',
  `distance10` int(11) DEFAULT '-1',
  `distance11` int(11) DEFAULT '-1',
  `distance12` int(11) DEFAULT '-1',
  `distance13` int(11) DEFAULT '-1',
  `distance14` int(11) DEFAULT '-1',
  `distance15` int(11) DEFAULT '-1',
  `distance16` int(11) DEFAULT '-1',
  `distance17` int(11) DEFAULT '-1',
  `distance18` int(11) DEFAULT '-1',
  `distance19` int(11) DEFAULT '-1',
  `distance20` int(11) DEFAULT '-1',
  PRIMARY KEY (`project_id`,`group_num`),
  KEY `project_id` (`project_id`),
  KEY `group_num` (`group_num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 資料表結構 `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `s_id` int(11) NOT NULL,
  `account` varchar(9) CHARACTER SET armscii8 NOT NULL,
  `password` text CHARACTER SET armscii8 NOT NULL,
  `group_num` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `student`
--

INSERT INTO `student` (`s_id`, `account`, `password`, `group_num`, `type`) VALUES
(75, 'b02705001', '138cd22d4458437c9b134ac412767d7b', 3, 1),
(74, 'b02705021', '7cf0199933ee85d80ecda21f3b5c35ed', 2, 1),
(72, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
