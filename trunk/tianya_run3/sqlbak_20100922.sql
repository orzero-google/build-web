-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2010 年 09 月 21 日 01:11
-- 服务器版本: 5.1.41
-- PHP 版本: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 数据库: `tianya_run`
--

-- --------------------------------------------------------

--
-- 表的结构 `cache`
--

CREATE TABLE IF NOT EXISTS `cache` (
  `cacheid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `furl` varchar(1023) NOT NULL,
  `turl` varchar(1023) NOT NULL,
  `file` varchar(1023) NOT NULL,
  `size` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `posts` smallint(6) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cacheid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 表的结构 `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `contentid` int(11) NOT NULL AUTO_INCREMENT,
  `info_id` int(11) NOT NULL,
  `pg_id` int(11) NOT NULL,
  `page_num` mediumint(9) NOT NULL,
  `channel_cn` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `dir` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `posts` smallint(6) NOT NULL,
  PRIMARY KEY (`contentid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `info`
--

CREATE TABLE IF NOT EXISTS `info` (
  `infoid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `channel_en` varchar(255) NOT NULL,
  `channel_cn` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `pid_list` text NOT NULL,
  `count` smallint(6) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`infoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `pageid` int(11) NOT NULL AUTO_INCREMENT,
  `furl` varchar(1023) NOT NULL,
  `title` varchar(255) NOT NULL,
  `channel_en` varchar(255) NOT NULL,
  `channel_cn` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `tpid` mediumint(9) NOT NULL,
  `pcount` mediumint(9) NOT NULL,
  `plist` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pageid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `pg`
--

CREATE TABLE IF NOT EXISTS `pg` (
  `pgid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `dir` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `form_vars` varchar(255) NOT NULL,
  `fid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `page_size` int(11) NOT NULL,
  `cache_size` int(11) NOT NULL,
  `state` tinyint(4) NOT NULL,
  PRIMARY KEY (`pgid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
