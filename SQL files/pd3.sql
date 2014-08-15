-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生日期: 2014 年 08 月 15 日 21:19
-- 伺服器版本: 5.5.27
-- PHP 版本: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- 資料庫: `pd3`
--

-- --------------------------------------------------------

--
-- 表的結構 `announce`
--

CREATE TABLE IF NOT EXISTS `announce` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 轉存資料表中的資料 `announce`
--

INSERT INTO `announce` (`id`, `date`, `content`) VALUES
(1, '2014-02-19', '<p>To submit Homework 1:</p>\r\n	<ul>\r\n		<li>For the PDF for Problems 1 to 3 and the CPP for Problem 4, submit to "PD14-1a"</li>\r\n		<li>For the CPP for Problem 5 (bonus), submit to "PD14-1b"</li>\r\n	</ul>'),
(2, '2014-02-22', '<p>Because we will manual check your homework 1, so we didn''t upload testing data to the PDOGS. </p>\r\n	<p>So you will get 0 point and runtime error even your code is totally correct!</p>'),
(3, '2014-02-24', '<p>To submit Homework 2:</p>\r\n	<ul>\r\n		<li>For the PDF for Problems 1 to 2 and the CPP for Problem 3, submit to "PD14-02a"</li>\r\n		<li>For the CPP for Problem 4 (bonus), submit to "PD14-02b"</li>\r\n		<li>Download <a href="/PD/problem/PD14-2-template.cpp">template</a> that repeatedly reads the testing data for Problem 3</li>\r\n	</ul>');

-- --------------------------------------------------------

--
-- 表的結構 `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `group_num` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `rank` int(11) NOT NULL,
  `best_score` float NOT NULL,
  `worst_score` float NOT NULL,
  `total_score` float NOT NULL,
  PRIMARY KEY (`group_num`),
  UNIQUE KEY `group_num` (`group_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `group`
--

INSERT INTO `group` (`group_num`, `group_name`, `rank`, `best_score`, `worst_score`, `total_score`) VALUES
(1, 'ADMIN', 0, 0, 0, 0),
(2, '[Judge] 帥哥哥', 0, 0, 0, 0),
(3, '測試隊2號', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的結構 `lab_hw`
--

CREATE TABLE IF NOT EXISTS `lab_hw` (
  `lab_id` varchar(10) NOT NULL,
  `submit_code` tinyint(1) NOT NULL,
  `submit_pdf` tinyint(1) NOT NULL,
  `data_number` int(11) NOT NULL,
  `total_score` int(11) NOT NULL,
  `deadline` datetime NOT NULL,
  PRIMARY KEY (`lab_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `lab_score`
--

CREATE TABLE IF NOT EXISTS `lab_score` (
  `s_id` int(11) NOT NULL,
  `lab_id` varchar(10) NOT NULL,
  `status` text NOT NULL,
  `time` datetime NOT NULL,
  `exec_time` float NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`s_id`,`lab_id`,`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `past_hw`
--

CREATE TABLE IF NOT EXISTS `past_hw` (
  `past_id` varchar(10) NOT NULL,
  `total_score` int(11) NOT NULL,
  PRIMARY KEY (`past_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `past_score`
--

CREATE TABLE IF NOT EXISTS `past_score` (
  `s_id` int(11) NOT NULL,
  `past_id` varchar(10) NOT NULL,
  `status` text NOT NULL,
  `time` datetime NOT NULL,
  `exec_time` float NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`s_id`,`past_id`,`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `pd_hw`
--

CREATE TABLE IF NOT EXISTS `pd_hw` (
  `p_id` varchar(10) NOT NULL,
  `submit_code` tinyint(1) NOT NULL,
  `submit_pdf` tinyint(1) NOT NULL,
  `data_number` int(1) NOT NULL DEFAULT '1',
  `type` int(1) NOT NULL,
  `total_score` int(11) NOT NULL,
  `deadline` datetime NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `pd_hw`
--

INSERT INTO `pd_hw` (`p_id`, `submit_code`, `submit_pdf`, `data_number`, `type`, `total_score`, `deadline`) VALUES
('Problem_A', 1, 0, 2, 0, 8, '2014-12-23 23:59:59'),
('Problem_B', 1, 0, 2, 0, 8, '2014-12-23 23:59:59'),
('Problem_C', 1, 0, 2, 0, 8, '2014-12-23 23:59:59'),
('Problem_D', 1, 0, 2, 0, 8, '2014-12-23 23:59:59'),
('Problem_E', 1, 0, 2, 0, 8, '2014-12-23 23:59:59'),
('Problem_F', 1, 0, 2, 1, 8, '2014-12-23 23:59:59'),
('Problem_G', 1, 0, 2, 0, 8, '2014-12-23 23:59:59'),
('Problem_H', 1, 0, 2, 0, 8, '2014-12-23 23:59:59'),
('Problem_I', 1, 0, 2, 3, 8, '2014-12-23 23:59:59'),
('Problem_J', 1, 0, 2, 3, 8, '2014-08-28 00:00:00'),
('P_TEST', 1, 0, 1, 3, 100, '2015-01-01 01:01:01');

-- --------------------------------------------------------

--
-- 表的結構 `pd_score`
--

CREATE TABLE IF NOT EXISTS `pd_score` (
  `s_id` int(11) NOT NULL,
  `p_id` varchar(10) NOT NULL,
  `status` text NOT NULL,
  `time` datetime NOT NULL,
  `exec_time` float NOT NULL,
  `score` int(11) NOT NULL,
  `result` varchar(4096) DEFAULT NULL,
  PRIMARY KEY (`s_id`,`p_id`,`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `pd_score`
--

INSERT INTO `pd_score` (`s_id`, `p_id`, `status`, `time`, `exec_time`, `score`, `result`) VALUES
(72, 'Problem_A', 'Accepted', '2014-08-10 00:38:32', 0, 8, '4,4,'),
(72, 'Problem_B', 'Time limit exceed', '2014-08-10 00:38:46', 6, 0, '0,0,'),
(72, 'Problem_C', 'Wrong answer', '2014-08-10 00:44:07', 0, 4, '4,0,'),
(72, 'Problem_D', 'Accepted', '2014-08-10 00:48:35', 0, 8, '3,5,'),
(72, 'Problem_E', 'Wrong answer', '2014-08-13 16:16:54', 0, 5, '0,5,'),
(72, 'Problem_F', 'Accepted', '2014-08-15 12:06:28', 0, 8, '4,4,'),
(72, 'Problem_G', 'Accepted', '2014-08-10 00:50:56', 0, 8, '3,5,'),
(72, 'Problem_H', 'Accepted', '2014-08-10 00:51:18', 0, 8, '3,5,'),
(72, 'Problem_I', 'Wrong answer', '2014-08-15 21:18:56', 0, 2, '2,0,'),
(72, 'P_TEST', 'Wrong answer', '2014-08-13 17:04:48', 0, 0, '0,'),
(74, 'Problem_A', 'Wrong answer', '2014-08-16 01:14:27', 0, 0, '0,0,'),
(74, 'Problem_C', 'Time limit exceed', '2014-08-16 01:15:02', 5.5, 4, '4,0,'),
(74, 'Problem_C', 'Time limit exceed', '2014-08-16 01:18:55', 2, 0, '0,0,'),
(74, 'Problem_F', 'Accepted', '2014-08-16 01:17:22', 0, 8, '4,4,');

-- --------------------------------------------------------

--
-- 表的結構 `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(11) NOT NULL,
  `total_score` int(11) NOT NULL,
  `deadline` datetime NOT NULL,
  `onjudge` tinyint(1) NOT NULL,
  `isUpdate` bigint(20) NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `project_group`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的結構 `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(9) NOT NULL,
  `password` text NOT NULL,
  `group_num` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=79 ;

--
-- 轉存資料表中的資料 `student`
--

INSERT INTO `student` (`s_id`, `account`, `password`, `group_num`, `type`) VALUES
(72, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 0),
(74, 'b02705021', '71cdda0264a89b5556c7a6f505f69c78', 2, 0),
(75, 'b02705001', '138cd22d4458437c9b134ac412767d7b', 3, 1),
(76, '23432', '726784b1a8c22c54054674ef3bdb4153', 0, 1),
(77, '333', '310dcbbf4cce62f762a2aaa148d556bd', 0, 1),
(78, '444', '550a141f12de6341fba65b0ad0433500', 0, 1);
