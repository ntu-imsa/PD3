-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2014-05-24: 14:47:55
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
  `group_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `rank` int(11) NOT NULL,
  `best_score` float NOT NULL,
  `worst_score` float NOT NULL,
  `total_score` float NOT NULL,
  PRIMARY KEY (`group_num`),
  UNIQUE KEY `group_num` (`group_num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `group`
--

INSERT INTO `group` (`group_num`, `group_name`, `rank`, `best_score`, `worst_score`, `total_score`) VALUES
(1, '資管帥哥哥裁判隊', 0, 0, 0, 0),
(2, '測試隊1號', 0, 0, 0, 0),
(3, '測試隊2號', 0, 0, 0, 0);

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
('P_TESTPRO', 1, 0, 2, 8, '3014-05-15 23:59:59'),
('P_STACKSZ', 1, 0, 2, 8, '3014-05-15 23:59:59'),
('ProblemA', 1, 0, 2, 8, '3014-05-15 23:59:59'),
('ProblemB', 1, 0, 2, 8, '3014-05-15 23:59:59'),
('ProblemC', 1, 0, 2, 8, '3014-05-15 23:59:59'),
('ProblemD', 1, 0, 2, 8, '3014-05-15 23:59:59'),
('ProblemE', 1, 0, 2, 8, '3014-05-15 23:59:59'),
('ProblemF', 1, 0, 2, 8, '3014-05-15 23:59:59'),
('ProblemG', 1, 0, 2, 8, '3014-05-15 23:59:59');

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
(75, 'ProblemA', 'Accepted', '2014-05-24 16:35:44', 0, 8, '4,4,'),
(75, 'ProblemB', 'Accepted', '2014-05-24 16:35:48', 0, 8, '4,4,'),
(75, 'ProblemC', 'Accepted', '2014-05-24 16:35:52', 0, 8, '4,4,'),
(75, 'ProblemD', 'Accepted', '2014-05-24 16:35:56', 0, 8, '4,4,'),
(75, 'ProblemE', 'Accepted', '2014-05-24 16:35:59', 0, 8, '4,4,'),
(75, 'ProblemF', 'Accepted', '2014-05-24 16:36:03', 0, 8, '4,4,'),
(75, 'ProblemG', 'Accepted', '2014-05-24 16:36:07', 0, 8, '4,4,'),
(75, 'P_STACKSZ', 'Accepted', '2014-05-24 16:36:10', 0, 8, '4,4,'),
(75, 'P_TESTPRO', 'Accepted', '2014-05-24 16:36:14', 0, 8, '4,4,'),
(72, 'P_TESTPRO', 'Time limit exceed', '2014-05-24 18:06:45', 1, 4, '4,0,'),
(72, 'P_TESTPRO', 'Time limit exceed', '2014-05-24 18:07:03', 1, 4, '4,0,'),
(72, 'ProblemA', 'Time limit exceed', '2014-05-24 18:08:04', 2, 0, '0,0,'),
(72, 'ProblemA', 'Time limit exceed', '2014-05-24 18:08:10', 2, 0, '0,0,'),
(72, 'P_STACKSZ', 'Accepted', '2014-05-24 20:11:55', 0, 8, '4,4,'),
(72, 'ProblemC', 'Time limit exceed', '2014-05-24 20:12:33', 2, 0, '0,0,'),
(72, 'ProblemC', 'Time limit exceed', '2014-05-24 20:18:33', 2, 0, '0,0,'),
(72, 'ProblemC', 'Time limit exceed', '2014-05-24 20:18:46', 2, 0, '0,0,'),
(72, 'ProblemC', 'Time limit exceed', '2014-05-24 20:19:10', 2, 0, '0,0,'),
(72, 'ProblemC', 'Accepted', '2014-05-24 20:19:34', 0, 8, '4,4,'),
(72, 'ProblemA', 'Accepted', '2014-05-24 20:19:57', 0, 8, '4,4,');

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
