-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- ����: localhost
-- ��������: 2010 �� 04 �� 20 �� 13:35
-- �������汾: 5.1.37
-- PHP �汾: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- ���ݿ�: `info`
--

-- --------------------------------------------------------

--
-- ��Ľṹ `areas`
--

CREATE TABLE IF NOT EXISTS `areas` (
  `areasid` int(11) NOT NULL AUTO_INCREMENT,
  `layer` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`areasid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ת����е����� `areas`
--


-- --------------------------------------------------------

--
-- ��Ľṹ `categorys`
--

CREATE TABLE IF NOT EXISTS `categorys` (
  `categorysid` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`categorysid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ת����е����� `categorys`
--


-- --------------------------------------------------------

--
-- ��Ľṹ `configs`
--

CREATE TABLE IF NOT EXISTS `configs` (
  `configsid` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`configsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ת����е����� `configs`
--


-- --------------------------------------------------------

--
-- ��Ľṹ `contents`
--

CREATE TABLE IF NOT EXISTS `contents` (
  `contentsid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `keys_id` bigint(20) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `mode_id` tinyint(4) NOT NULL,
  `perm_id` tinyint(4) NOT NULL,
  `ref_id` bigint(20) NOT NULL,
  `order_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`contentsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ת����е����� `contents`
--


-- --------------------------------------------------------

--
-- ��Ľṹ `keywords`
--

CREATE TABLE IF NOT EXISTS `keywords` (
  `keywordsid` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`keywordsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ת����е����� `keywords`
--


-- --------------------------------------------------------

--
-- ��Ľṹ `modes`
--

CREATE TABLE IF NOT EXISTS `modes` (
  `modesid` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`modesid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ת����е����� `modes`
--


-- --------------------------------------------------------

--
-- ��Ľṹ `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `permissionsid` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`permissionsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ת����е����� `permissions`
--

