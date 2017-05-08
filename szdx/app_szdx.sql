-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- 主机: w.rdc.sae.sina.com.cn:3307
-- 生成日期: 2017 年 05 月 08 日 16:08
-- 服务器版本: 5.6.23
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `app_szdx`
--

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_activity`
--

DROP TABLE IF EXISTS `sdbk_activity`;
CREATE TABLE IF NOT EXISTS `sdbk_activity` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `startTime` int(10) NOT NULL,
  `endTime` int(10) NOT NULL,
  `limit` int(10) NOT NULL,
  `param` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_activity_record`
--

DROP TABLE IF EXISTS `sdbk_activity_record`;
CREATE TABLE IF NOT EXISTS `sdbk_activity_record` (
  `aid` int(10) NOT NULL,
  `uid` int(5) NOT NULL,
  `param` text NOT NULL,
  `mark` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_admin`
--

DROP TABLE IF EXISTS `sdbk_admin`;
CREATE TABLE IF NOT EXISTS `sdbk_admin` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(37) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `rank` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uuid` (`uuid`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_apps`
--

DROP TABLE IF EXISTS `sdbk_apps`;
CREATE TABLE IF NOT EXISTS `sdbk_apps` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `rank` int(3) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `icon` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  `available` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `thirdpart` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_baoxiangui`
--

DROP TABLE IF EXISTS `sdbk_baoxiangui`;
CREATE TABLE IF NOT EXISTS `sdbk_baoxiangui` (
  `code` varchar(255) COLLATE utf8_bin NOT NULL,
  `openid` varchar(255) COLLATE utf8_bin NOT NULL,
  `user` varchar(255) COLLATE utf8_bin NOT NULL,
  `headimgurl` varchar(255) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `time` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_board`
--

DROP TABLE IF EXISTS `sdbk_board`;
CREATE TABLE IF NOT EXISTS `sdbk_board` (
  `aid` int(7) unsigned NOT NULL,
  `type` varchar(10) NOT NULL,
  `department` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `attachment` int(2) NOT NULL,
  `date` varchar(11) NOT NULL,
  `fixed` tinyint(1) unsigned NOT NULL,
  `fetchtime` int(10) unsigned NOT NULL,
  `lastedit` varchar(50) NOT NULL,
  PRIMARY KEY (`aid`),
  UNIQUE KEY `aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_board_article`
--

DROP TABLE IF EXISTS `sdbk_board_article`;
CREATE TABLE IF NOT EXISTS `sdbk_board_article` (
  `aid` int(10) unsigned NOT NULL,
  `title` varchar(200) NOT NULL,
  `department` varchar(30) NOT NULL,
  `releasetime` varchar(50) NOT NULL,
  `article` longtext NOT NULL,
  `attachment` longtext NOT NULL,
  `lastedit` varchar(50) NOT NULL,
  `count` int(10) unsigned NOT NULL,
  UNIQUE KEY `aid` (`aid`),
  FULLTEXT KEY `text` (`article`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_book`
--

DROP TABLE IF EXISTS `sdbk_book`;
CREATE TABLE IF NOT EXISTS `sdbk_book` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `book` varchar(51) DEFAULT NULL,
  `num` int(2) DEFAULT NULL,
  `title` varchar(104) DEFAULT NULL,
  `desc` varchar(4067) DEFAULT NULL,
  `pic` varchar(10) DEFAULT NULL,
  `no` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_book2`
--

DROP TABLE IF EXISTS `sdbk_book2`;
CREATE TABLE IF NOT EXISTS `sdbk_book2` (
  `id` int(3) DEFAULT NULL,
  `book` varchar(51) DEFAULT NULL,
  `num` int(2) DEFAULT NULL,
  `title` varchar(104) DEFAULT NULL,
  `desc` varchar(4067) DEFAULT NULL,
  `pic` varchar(10) DEFAULT NULL,
  `no` varchar(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_card`
--

DROP TABLE IF EXISTS `sdbk_card`;
CREATE TABLE IF NOT EXISTS `sdbk_card` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `studentNo` int(11) unsigned NOT NULL,
  `studentName` varchar(30) NOT NULL,
  `getName` varchar(30) NOT NULL,
  `remark` text NOT NULL,
  `isreturn` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=731 ;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_cataphone`
--

DROP TABLE IF EXISTS `sdbk_cataphone`;
CREATE TABLE IF NOT EXISTS `sdbk_cataphone` (
  `cata` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `ybphone` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_cet_zkz`
--

DROP TABLE IF EXISTS `sdbk_cet_zkz`;
CREATE TABLE IF NOT EXISTS `sdbk_cet_zkz` (
  `studentNo` int(10) unsigned NOT NULL,
  `studentName` varchar(30) NOT NULL,
  `cetzkz` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_class`
--

DROP TABLE IF EXISTS `sdbk_class`;
CREATE TABLE IF NOT EXISTS `sdbk_class` (
  `classname` varchar(255) DEFAULT NULL,
  `studentNo` int(11) DEFAULT NULL,
  `studentName` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `zy` varchar(255) DEFAULT NULL,
  `college` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_course`
--

DROP TABLE IF EXISTS `sdbk_course`;
CREATE TABLE IF NOT EXISTS `sdbk_course` (
  `KCH` varchar(50) NOT NULL,
  `KCMC` varchar(200) NOT NULL,
  `XF` float(50,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_dormassphone`
--

DROP TABLE IF EXISTS `sdbk_dormassphone`;
CREATE TABLE IF NOT EXISTS `sdbk_dormassphone` (
  `teacher` varchar(255) NOT NULL,
  `ass` varchar(255) NOT NULL,
  `assdorm` varchar(255) NOT NULL,
  `assphone` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_dormphone`
--

DROP TABLE IF EXISTS `sdbk_dormphone`;
CREATE TABLE IF NOT EXISTS `sdbk_dormphone` (
  `dorm` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_dormtphone`
--

DROP TABLE IF EXISTS `sdbk_dormtphone`;
CREATE TABLE IF NOT EXISTS `sdbk_dormtphone` (
  `teacher` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `dorm` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_dorm_new`
--

DROP TABLE IF EXISTS `sdbk_dorm_new`;
CREATE TABLE IF NOT EXISTS `sdbk_dorm_new` (
  `studentNo` int(10) DEFAULT NULL,
  `studentName` varchar(50) DEFAULT NULL,
  `building` varchar(50) DEFAULT NULL,
  `roomname` varchar(20) DEFAULT NULL,
  `personalId` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_exam`
--

DROP TABLE IF EXISTS `sdbk_exam`;
CREATE TABLE IF NOT EXISTS `sdbk_exam` (
  `studentNo` char(10) NOT NULL,
  `studentName` char(30) NOT NULL,
  `orgCollege` varchar(50) NOT NULL,
  `orgMajor` varchar(50) NOT NULL,
  `classNo` varchar(50) NOT NULL,
  `className` varchar(50) NOT NULL,
  `examTime` varchar(42) NOT NULL,
  `examLocation` varchar(50) NOT NULL,
  `examLocationIn` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_exam_copy`
--

DROP TABLE IF EXISTS `sdbk_exam_copy`;
CREATE TABLE IF NOT EXISTS `sdbk_exam_copy` (
  `studentNo` char(10) NOT NULL,
  `studentName` char(30) NOT NULL,
  `orgCollege` varchar(50) NOT NULL,
  `orgMajor` varchar(50) NOT NULL,
  `classNo` varchar(50) NOT NULL,
  `className` varchar(50) NOT NULL,
  `examTime` varchar(42) NOT NULL,
  `examLocation` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_issue`
--

DROP TABLE IF EXISTS `sdbk_issue`;
CREATE TABLE IF NOT EXISTS `sdbk_issue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `replied` tinyint(1) NOT NULL DEFAULT '0',
  `asso` varchar(50) NOT NULL,
  `reply` text NOT NULL,
  `responder` varchar(50) NOT NULL,
  `support` int(10) unsigned NOT NULL DEFAULT '0',
  `submitTime` int(10) unsigned NOT NULL,
  `replyTime` int(10) unsigned NOT NULL,
  `hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `hidden` (`hidden`),
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `content` (`content`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2989 ;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_jsll`
--

DROP TABLE IF EXISTS `sdbk_jsll`;
CREATE TABLE IF NOT EXISTS `sdbk_jsll` (
  `studentNo` char(10) NOT NULL,
  `studentName` char(30) NOT NULL,
  `className` varchar(50) NOT NULL,
  `examTime` varchar(42) NOT NULL,
  `examLocation` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_log`
--

DROP TABLE IF EXISTS `sdbk_log`;
CREATE TABLE IF NOT EXISTS `sdbk_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `log` text NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4391 ;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_missyou_log`
--

DROP TABLE IF EXISTS `sdbk_missyou_log`;
CREATE TABLE IF NOT EXISTS `sdbk_missyou_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `time` int(10) unsigned DEFAULT NULL,
  `building` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roomname` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=16595 ;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_pk_student`
--

DROP TABLE IF EXISTS `sdbk_pk_student`;
CREATE TABLE IF NOT EXISTS `sdbk_pk_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stu_num` int(10) DEFAULT NULL,
  `name` varchar(38) DEFAULT NULL,
  `is_book` int(1) DEFAULT NULL,
  `bookname` varchar(200) DEFAULT NULL,
  `bh` varchar(10) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1900 ;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_pk_student2`
--

DROP TABLE IF EXISTS `sdbk_pk_student2`;
CREATE TABLE IF NOT EXISTS `sdbk_pk_student2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stu_num` int(10) DEFAULT NULL,
  `name` varchar(35) DEFAULT NULL,
  `is_book` int(1) DEFAULT NULL,
  `bookname` varchar(200) DEFAULT '',
  `bh` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2201 ;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_room`
--

DROP TABLE IF EXISTS `sdbk_room`;
CREATE TABLE IF NOT EXISTS `sdbk_room` (
  `building` varchar(255) NOT NULL,
  `roomname` int(10) unsigned NOT NULL,
  `roomid` int(10) unsigned NOT NULL,
  `code` int(10) unsigned NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_room_bind`
--

DROP TABLE IF EXISTS `sdbk_room_bind`;
CREATE TABLE IF NOT EXISTS `sdbk_room_bind` (
  `openid` varchar(50) NOT NULL,
  `code` int(9) unsigned DEFAULT NULL,
  `warnpush` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`openid`),
  KEY `code` (`code`),
  FULLTEXT KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_room_fee`
--

DROP TABLE IF EXISTS `sdbk_room_fee`;
CREATE TABLE IF NOT EXISTS `sdbk_room_fee` (
  `roomcode` int(10) unsigned NOT NULL,
  `fee` double NOT NULL,
  `fee_15days` text NOT NULL,
  `updateTime` varchar(255) NOT NULL,
  PRIMARY KEY (`roomcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_room_fee_bak`
--

DROP TABLE IF EXISTS `sdbk_room_fee_bak`;
CREATE TABLE IF NOT EXISTS `sdbk_room_fee_bak` (
  `roomcode` int(10) unsigned NOT NULL,
  `fee` double NOT NULL,
  `fee_15days` text NOT NULL,
  `updateTime` varchar(255) NOT NULL,
  PRIMARY KEY (`roomcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_room_usage`
--

DROP TABLE IF EXISTS `sdbk_room_usage`;
CREATE TABLE IF NOT EXISTS `sdbk_room_usage` (
  `code` int(9) unsigned NOT NULL,
  `yesterdayUsage` float(5,2) DEFAULT NULL,
  `lastUsage` float(5,2) DEFAULT NULL,
  `lastUpdate` varchar(20) DEFAULT NULL,
  `averageUsage` float(5,2) DEFAULT NULL,
  `enoughFor` int(5) DEFAULT NULL,
  `sevenDayData` text,
  `lastFetch` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`code`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_room_warn`
--

DROP TABLE IF EXISTS `sdbk_room_warn`;
CREATE TABLE IF NOT EXISTS `sdbk_room_warn` (
  `openid` varchar(255) NOT NULL,
  `roomcode` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_score`
--

DROP TABLE IF EXISTS `sdbk_score`;
CREATE TABLE IF NOT EXISTS `sdbk_score` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `XH` int(10) unsigned NOT NULL,
  `KCH` varchar(50) NOT NULL,
  `KCLB` varchar(50) NOT NULL,
  `XF` float(10,2) NOT NULL,
  `DJCJ` varchar(50) NOT NULL,
  `JD` float(10,2) NOT NULL,
  `XFJD` float(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_score_20152`
--

DROP TABLE IF EXISTS `sdbk_score_20152`;
CREATE TABLE IF NOT EXISTS `sdbk_score_20152` (
  `XH` int(10) unsigned NOT NULL,
  `XM` varchar(30) DEFAULT NULL,
  `KCH` varchar(50) NOT NULL,
  `KCLB` varchar(50) NOT NULL,
  `KCMC` varchar(100) NOT NULL,
  `XF` float(10,2) unsigned NOT NULL,
  `DJCJ` varchar(50) NOT NULL,
  `JD` float(10,2) NOT NULL,
  `XFJD` float(10,2) NOT NULL,
  `SFXX` varchar(10) DEFAULT NULL,
  `KCLB_A` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_sign_in`
--

DROP TABLE IF EXISTS `sdbk_sign_in`;
CREATE TABLE IF NOT EXISTS `sdbk_sign_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `sign_days` int(10) NOT NULL,
  `sign_num` int(10) NOT NULL,
  `jf` int(10) NOT NULL,
  `last_sign` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_teacherphone`
--

DROP TABLE IF EXISTS `sdbk_teacherphone`;
CREATE TABLE IF NOT EXISTS `sdbk_teacherphone` (
  `college` varchar(255) NOT NULL,
  `teacher` varchar(255) NOT NULL,
  `atime` varchar(255) NOT NULL,
  `aplace` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_timemachine`
--

DROP TABLE IF EXISTS `sdbk_timemachine`;
CREATE TABLE IF NOT EXISTS `sdbk_timemachine` (
  `userid` int(11) NOT NULL,
  `text` text NOT NULL,
  `time` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_tvote`
--

DROP TABLE IF EXISTS `sdbk_tvote`;
CREATE TABLE IF NOT EXISTS `sdbk_tvote` (
  `teacherId` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `teacherName` varchar(10) NOT NULL,
  `teacherDes` text NOT NULL,
  `teacherBallot` int(10) unsigned NOT NULL,
  `teacherCollege` varchar(30) NOT NULL,
  `full` text NOT NULL,
  PRIMARY KEY (`teacherId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_user`
--

DROP TABLE IF EXISTS `sdbk_user`;
CREATE TABLE IF NOT EXISTS `sdbk_user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) CHARACTER SET utf8 NOT NULL,
  `unionid` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `nickname` varchar(200) CHARACTER SET utf8 NOT NULL,
  `email` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `headimgurl` varchar(200) CHARACTER SET utf8 NOT NULL,
  `country` varchar(200) CHARACTER SET utf8 NOT NULL,
  `province` varchar(200) CHARACTER SET utf8 NOT NULL,
  `city` varchar(200) CHARACTER SET utf8 NOT NULL,
  `studentNo` bigint(12) unsigned NOT NULL DEFAULT '0',
  `studentName` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `icAccount` int(10) unsigned NOT NULL DEFAULT '0',
  `personalId` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `sex` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `org` text CHARACTER SET utf8,
  `rankName` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `group` int(1) NOT NULL DEFAULT '0',
  `time` bigint(20) unsigned NOT NULL,
  `phone` bigint(14) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  KEY `openid` (`openid`),
  KEY `studentNo` (`studentNo`),
  KEY `icAccount` (`icAccount`),
  KEY `headimgurl` (`headimgurl`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=47332 ;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_user_b`
--

DROP TABLE IF EXISTS `sdbk_user_b`;
CREATE TABLE IF NOT EXISTS `sdbk_user_b` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) CHARACTER SET utf8 NOT NULL,
  `unionid` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `nickname` varchar(200) CHARACTER SET utf8 NOT NULL,
  `email` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `headimgurl` varchar(200) CHARACTER SET utf8 NOT NULL,
  `country` varchar(200) CHARACTER SET utf8 NOT NULL,
  `province` varchar(200) CHARACTER SET utf8 NOT NULL,
  `city` varchar(200) CHARACTER SET utf8 NOT NULL,
  `studentNo` bigint(12) unsigned NOT NULL DEFAULT '0',
  `studentName` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `icAccount` int(10) unsigned NOT NULL DEFAULT '0',
  `personalId` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `sex` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `org` text CHARACTER SET utf8,
  `rankName` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `group` int(1) NOT NULL DEFAULT '0',
  `time` bigint(20) unsigned NOT NULL,
  `phone` bigint(14) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  KEY `openid` (`openid`),
  KEY `studentNo` (`studentNo`),
  KEY `icAccount` (`icAccount`),
  KEY `headimgurl` (`headimgurl`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=30855 ;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_vote_record`
--

DROP TABLE IF EXISTS `sdbk_vote_record`;
CREATE TABLE IF NOT EXISTS `sdbk_vote_record` (
  `id` int(10) unsigned NOT NULL,
  `openid` varchar(33) NOT NULL,
  `time` bigint(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_xuanke1`
--

DROP TABLE IF EXISTS `sdbk_xuanke1`;
CREATE TABLE IF NOT EXISTS `sdbk_xuanke1` (
  `studentNo` int(10) unsigned NOT NULL,
  `classNo` varchar(50) NOT NULL,
  `className` varchar(50) NOT NULL,
  `score` double unsigned NOT NULL,
  `req` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_xuanke1_copy`
--

DROP TABLE IF EXISTS `sdbk_xuanke1_copy`;
CREATE TABLE IF NOT EXISTS `sdbk_xuanke1_copy` (
  `studentNo` int(10) unsigned NOT NULL,
  `classNo` varchar(50) NOT NULL,
  `className` varchar(50) NOT NULL,
  `score` double unsigned NOT NULL,
  `req` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sdbk_xuefei`
--

DROP TABLE IF EXISTS `sdbk_xuefei`;
CREATE TABLE IF NOT EXISTS `sdbk_xuefei` (
  `studentNo` varchar(12) NOT NULL,
  `studentName` varchar(30) NOT NULL,
  `xuefei` varchar(6) NOT NULL,
  `zhusu` varchar(6) NOT NULL,
  `sum` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `wechat_keywords`
--

DROP TABLE IF EXISTS `wechat_keywords`;
CREATE TABLE IF NOT EXISTS `wechat_keywords` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  `keyword` text NOT NULL,
  `replyType` varchar(30) NOT NULL,
  `reply` text NOT NULL,
  `weight` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=22 ;
