-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2014 年 05 月 21 日 12:48
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `yii_yiii4`
--
CREATE DATABASE IF NOT EXISTS `yii_yiii4` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `yii_yiii4`;

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(16) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `username`, `email`, `password`, `status`, `create_time`, `update_time`) VALUES
(1, 'admin', 'admin', 'sam@ozchamp.net', '72870614884a05be92e3c79d8969a3eb', 1, '2013-06-01 00:00:00', '2014-05-21 17:27:46'),
(2, 'administrator', 'administrator', 'sam@ozchamp.net', '72870614884a05be92e3c79d8969a3eb', 1, '2013-06-01 12:03:02', '2013-08-22 03:47:36'),
(5, 'ozchamp', 'ozchamp', 'sam@ozchamp.net', '72870614884a05be92e3c79d8969a3eb', 1, '2013-08-22 03:27:11', '2014-03-04 12:14:10');

-- --------------------------------------------------------

--
-- 表的结构 `admin_authassignment`
--

CREATE TABLE IF NOT EXISTS `admin_authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin_authassignment`
--

INSERT INTO `admin_authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('Admin', '1', NULL, 'N;'),
('Administrator', '2', NULL, 'N;'),
('Authenticated', '5', NULL, 'N;');

-- --------------------------------------------------------

--
-- 表的结构 `admin_authitem`
--

CREATE TABLE IF NOT EXISTS `admin_authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin_authitem`
--

INSERT INTO `admin_authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('Admin', 2, '開發者（開發模式，任意權限）', NULL, 'N;'),
('Admin.Account', 0, 'Admin.Account', NULL, 'N;'),
('Admin.Create', 0, 'Admin.Create', NULL, 'N;'),
('Admin.Delete', 0, 'Admin.Delete', NULL, 'N;'),
('Admin.Gridviewdelete', 0, 'Admin.Gridviewdelete', NULL, 'N;'),
('Admin.Gridviewupdate', 0, 'Admin.Gridviewupdate', NULL, 'N;'),
('Admin.Index', 0, 'Admin.Index', NULL, 'N;'),
('Admin.Update', 0, 'Admin.Update', NULL, 'N;'),
('Administrator', 2, '超級用戶（具備普通管理員的權限,同時允許管理後臺用戶）', NULL, 'N;'),
('Authenticated', 2, '普通用戶（具備多數內容的操作權限，允許且僅允許更新自身個人信息）', NULL, 'N;'),
('Category.*', 1, 'Category.*', NULL, 'N;'),
('Contact.*', 1, 'Contact.*', NULL, 'N;'),
('Customer.*', 1, 'Customer.*', NULL, 'N;'),
('CustomerGroup.*', 1, 'CustomerGroup.*', NULL, 'N;'),
('Guest', 2, '匿名用戶（不具備管理權限）', NULL, 'N;'),
('Information.*', 1, 'Information.*', NULL, 'N;'),
('News.*', 1, 'News.*', NULL, 'N;'),
('Picture.*', 1, 'Picture.*', NULL, 'N;'),
('PictureType.*', 1, 'PictureType.*', NULL, 'N;'),
('Product.*', 1, 'Product.*', NULL, 'N;'),
('Setting.*', 1, 'Setting.*', NULL, 'N;'),
('Site.*', 1, 'Site.*', NULL, 'N;');

-- --------------------------------------------------------

--
-- 表的结构 `admin_authitemchild`
--

CREATE TABLE IF NOT EXISTS `admin_authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin_authitemchild`
--

INSERT INTO `admin_authitemchild` (`parent`, `child`) VALUES
('Authenticated', 'Admin.Account'),
('Administrator', 'Admin.Create'),
('Administrator', 'Admin.Delete'),
('Administrator', 'Admin.Gridviewdelete'),
('Administrator', 'Admin.Gridviewupdate'),
('Administrator', 'Admin.Index'),
('Administrator', 'Admin.Update'),
('Administrator', 'Authenticated'),
('Authenticated', 'Category.*'),
('Authenticated', 'Contact.*'),
('Authenticated', 'Customer.*'),
('Authenticated', 'CustomerGroup.*'),
('Authenticated', 'Guest'),
('Authenticated', 'Information.*'),
('Authenticated', 'News.*'),
('Authenticated', 'Picture.*'),
('Authenticated', 'PictureType.*'),
('Authenticated', 'Product.*'),
('Authenticated', 'Setting.*'),
('Authenticated', 'Site.*');

-- --------------------------------------------------------

--
-- 表的结构 `admin_rights`
--

CREATE TABLE IF NOT EXISTS `admin_rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin_rights`
--

INSERT INTO `admin_rights` (`itemname`, `type`, `weight`) VALUES
('Category.*', 1, 3),
('Contact.*', 1, 4),
('Information.*', 1, 5),
('News.*', 1, 6),
('Picture.*', 1, 0),
('PictureType.*', 1, 1),
('Product.*', 1, 7),
('Setting.*', 1, 8),
('Site.*', 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `sort_order` int(5) NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`category_id`, `parent_id`, `sort_order`, `create_time`, `update_time`) VALUES
(4, NULL, 3, '2013-08-24 04:13:48', '2014-03-10 16:13:23'),
(7, 4, 1, '2013-08-24 05:23:17', '2014-03-10 15:58:47'),
(10, NULL, 0, '2014-01-14 20:39:00', '2014-01-22 16:07:14');

-- --------------------------------------------------------

--
-- 表的结构 `category_i18n`
--

CREATE TABLE IF NOT EXISTS `category_i18n` (
  `category_i18n_id` int(15) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `keywords` text,
  `description` text,
  PRIMARY KEY (`category_i18n_id`),
  KEY `category_id` (`category_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=80 ;

--
-- 转存表中的数据 `category_i18n`
--

INSERT INTO `category_i18n` (`category_i18n_id`, `category_id`, `language_id`, `title`, `keywords`, `description`) VALUES
(44, 10, 1, 'twc3', NULL, NULL),
(45, 10, 2, 'aaaaaa3', NULL, NULL),
(58, 7, 1, 'twc2', NULL, NULL),
(59, 7, 2, 'enc2', NULL, NULL),
(78, 4, 1, 'twc1', NULL, NULL),
(79, 4, 2, 'enc1', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '1',
  `telephone` varchar(16) NOT NULL,
  `cellphone` varchar(16) DEFAULT NULL,
  `fax` varchar(16) DEFAULT NULL,
  `email` varchar(64) NOT NULL,
  `company` varchar(256) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `message` text,
  `remark` text,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `contact`
--

INSERT INTO `contact` (`contact_id`, `status`, `firstname`, `lastname`, `sex`, `telephone`, `cellphone`, `fax`, `email`, `company`, `address`, `message`, `remark`, `create_time`, `update_time`) VALUES
(1, 0, 'fi', 'a', 1, '0123456789', NULL, NULL, 'cmd.dos@hotmail.com', NULL, NULL, NULL, NULL, '2014-03-01 11:03:23', '2014-03-01 11:03:23');

-- --------------------------------------------------------

--
-- 表的结构 `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_type_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `token` varchar(32) DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `username` (`username`),
  KEY `customer_type_id` (`customer_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_type_id`, `name`, `username`, `password`, `token`, `activated`, `status`, `create_time`, `update_time`) VALUES
(1, 1, 'Sam', 'sam@ozchamp.net', 'fcea920f7412b5da7be0cf42b8c93759', NULL, 1, 1, '2014-02-28 17:10:33', '2014-03-05 10:22:31'),
(7, 1, 'Sam2', 'cmd.dos@hotmail.com', 'fcea920f7412b5da7be0cf42b8c93759', '59f61aa9478c77d0943ed50862278bfa', 1, 1, '2014-03-05 10:11:52', '2014-03-05 10:20:29');

-- --------------------------------------------------------

--
-- 表的结构 `customer_authassignment`
--

CREATE TABLE IF NOT EXISTS `customer_authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `customer_authassignment`
--

INSERT INTO `customer_authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('Admin', '1', NULL, 'N;'),
('Administrator', '2', NULL, 'N;'),
('Authenticated', '5', NULL, 'N;');

-- --------------------------------------------------------

--
-- 表的结构 `customer_authitem`
--

CREATE TABLE IF NOT EXISTS `customer_authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `customer_authitem`
--

INSERT INTO `customer_authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('Admin', 2, '開發模式。\r\n任意權限。', NULL, 'N;'),
('Admin.Account', 0, 'Admin.Account', NULL, 'N;'),
('Admin.Create', 0, 'Admin.Create', NULL, 'N;'),
('Admin.Delete', 0, 'Admin.Delete', NULL, 'N;'),
('Admin.Gridviewdelete', 0, 'Admin.Gridviewdelete', NULL, 'N;'),
('Admin.Gridviewupdate', 0, 'Admin.Gridviewupdate', NULL, 'N;'),
('Admin.Index', 0, 'Admin.Index', NULL, 'N;'),
('Admin.Update', 0, 'Admin.Update', NULL, 'N;'),
('Administrator', 2, '超級用戶。\r\n具備普通管理員的權限。\r\n同時允許管理後臺用戶。', NULL, 'N;'),
('Authenticated', 2, '普通用戶。\r\n具備多數內容的操作權限。\r\n允許且僅允許更新自身個人信息。', NULL, 'N;'),
('Category.*', 1, 'Category.*', NULL, 'N;'),
('Contact.*', 1, 'Contact.*', NULL, 'N;'),
('Customer.*', 1, 'Customer.*', NULL, 'N;'),
('CustomerGroup.*', 1, 'CustomerGroup.*', NULL, 'N;'),
('Guest', 2, '匿名用戶。\r\n不具備管理權限。', NULL, 'N;'),
('Information.*', 1, 'Information.*', NULL, 'N;'),
('News.*', 1, 'News.*', NULL, 'N;'),
('Picture.*', 1, 'Picture.*', NULL, 'N;'),
('PictureType.*', 1, 'PictureType.*', NULL, 'N;'),
('Product.*', 1, 'Product.*', NULL, 'N;'),
('Setting.*', 1, 'Setting.*', NULL, 'N;'),
('Site.*', 1, 'Site.*', NULL, 'N;');

-- --------------------------------------------------------

--
-- 表的结构 `customer_authitemchild`
--

CREATE TABLE IF NOT EXISTS `customer_authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `customer_authitemchild`
--

INSERT INTO `customer_authitemchild` (`parent`, `child`) VALUES
('Authenticated', 'Admin.Account'),
('Administrator', 'Admin.Create'),
('Administrator', 'Admin.Delete'),
('Administrator', 'Admin.Gridviewdelete'),
('Administrator', 'Admin.Gridviewupdate'),
('Administrator', 'Admin.Index'),
('Administrator', 'Admin.Update'),
('Administrator', 'Authenticated'),
('Authenticated', 'Category.*'),
('Authenticated', 'Contact.*'),
('Authenticated', 'Customer.*'),
('Authenticated', 'CustomerGroup.*'),
('Authenticated', 'Guest'),
('Authenticated', 'Information.*'),
('Authenticated', 'News.*'),
('Authenticated', 'Picture.*'),
('Authenticated', 'PictureType.*'),
('Authenticated', 'Product.*'),
('Authenticated', 'Setting.*'),
('Authenticated', 'Site.*');

-- --------------------------------------------------------

--
-- 表的结构 `customer_rights`
--

CREATE TABLE IF NOT EXISTS `customer_rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `customer_rights`
--

INSERT INTO `customer_rights` (`itemname`, `type`, `weight`) VALUES
('Category.*', 1, 3),
('Contact.*', 1, 4),
('Information.*', 1, 5),
('News.*', 1, 6),
('Picture.*', 1, 0),
('PictureType.*', 1, 1),
('Product.*', 1, 7),
('Setting.*', 1, 8),
('Site.*', 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `customer_type`
--

CREATE TABLE IF NOT EXISTS `customer_type` (
  `customer_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`customer_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `customer_type`
--

INSERT INTO `customer_type` (`customer_type_id`, `name`, `default`) VALUES
(1, 'Default', 1);

-- --------------------------------------------------------

--
-- 表的结构 `information`
--

CREATE TABLE IF NOT EXISTS `information` (
  `information_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `sort_order` int(5) NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`information_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `information`
--

INSERT INTO `information` (`information_id`, `parent_id`, `sort_order`, `create_time`, `update_time`) VALUES
(1, 2, 0, '2013-06-30 03:22:08', '2014-01-15 09:01:50'),
(2, NULL, 1, '2013-08-30 03:32:29', '2014-03-04 16:11:59'),
(3, 1, 0, '2013-08-30 03:35:07', '2014-01-15 09:02:02'),
(4, NULL, 0, '2013-08-30 03:50:44', '2013-10-29 11:24:38'),
(5, NULL, 0, '2013-08-30 03:50:53', '2013-10-29 11:24:38'),
(6, NULL, 0, '2013-08-30 03:51:01', '2013-10-29 11:24:38'),
(7, NULL, 0, '2013-08-30 03:51:09', '2013-10-29 11:24:38'),
(8, NULL, 0, '2013-08-30 03:51:17', '2013-10-29 11:24:38'),
(9, 5, 0, '2013-08-30 03:51:25', '2014-01-15 09:02:08'),
(10, NULL, 0, '2013-08-30 03:51:33', '2013-10-29 11:24:38'),
(11, 8, 0, '2013-08-30 03:51:41', '2014-01-15 09:02:16'),
(12, NULL, 0, '2013-08-30 03:51:55', '2013-10-29 11:24:39');

-- --------------------------------------------------------

--
-- 表的结构 `information_i18n`
--

CREATE TABLE IF NOT EXISTS `information_i18n` (
  `information_i18n_id` int(15) NOT NULL AUTO_INCREMENT,
  `information_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(256) NOT NULL,
  `keywords` text,
  `description` text,
  PRIMARY KEY (`information_i18n_id`),
  KEY `language_id` (`language_id`),
  KEY `information_id` (`information_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- 转存表中的数据 `information_i18n`
--

INSERT INTO `information_i18n` (`information_i18n_id`, `information_id`, `language_id`, `status`, `title`, `keywords`, `description`) VALUES
(7, 4, 1, 1, 'a', NULL, NULL),
(8, 4, 2, 1, 'b', NULL, NULL),
(9, 5, 1, 1, 'a', NULL, NULL),
(10, 5, 2, 1, 'b', NULL, NULL),
(11, 6, 1, 1, 'a', NULL, NULL),
(12, 6, 2, 1, 'b', NULL, NULL),
(13, 7, 1, 1, 'a', NULL, NULL),
(14, 7, 2, 1, 'b', NULL, NULL),
(15, 8, 1, 1, 'a', NULL, NULL),
(16, 8, 2, 1, 'b', NULL, NULL),
(19, 10, 1, 1, 'a', NULL, NULL),
(20, 10, 2, 1, 'b', NULL, NULL),
(23, 12, 1, 1, 'a', NULL, NULL),
(24, 12, 2, 1, 'b', NULL, NULL),
(25, 1, 1, 1, 't', NULL, '<p>\r\n	tttty</p>\r\n'),
(26, 1, 2, 1, 'ens', NULL, '<p>\r\n	eeees</p>\r\n'),
(27, 3, 1, 1, 'a', NULL, NULL),
(28, 3, 2, 1, 'b', NULL, NULL),
(29, 9, 1, 1, 'a', NULL, NULL),
(30, 9, 2, 1, 'b', NULL, NULL),
(31, 11, 1, 1, 'a', NULL, NULL),
(32, 11, 2, 1, 'b', NULL, NULL),
(35, 2, 1, 1, 'aaa', NULL, NULL),
(36, 2, 2, 1, 'bbbbbbb', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `language_id` int(15) NOT NULL AUTO_INCREMENT,
  `code` varchar(8) NOT NULL,
  `title` varchar(64) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`language_id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `language`
--

INSERT INTO `language` (`language_id`, `code`, `title`, `sort_order`, `status`) VALUES
(1, 'zh_tw', '繁體中文', 0, 1),
(2, 'en_us', 'English', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `top` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `news`
--

INSERT INTO `news` (`news_id`, `top`, `sort_order`, `date_added`, `create_time`, `update_time`) VALUES
(1, 1, 0, '2013-07-04 00:00:00', '2013-07-24 00:32:49', '2014-01-23 17:54:55');

-- --------------------------------------------------------

--
-- 表的结构 `news_i18n`
--

CREATE TABLE IF NOT EXISTS `news_i18n` (
  `news_i18n_id` int(15) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `pic` varchar(256) DEFAULT NULL,
  `title` varchar(256) NOT NULL,
  `keywords` text,
  `description` text,
  PRIMARY KEY (`news_i18n_id`),
  KEY `news_id` (`news_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `news_i18n`
--

INSERT INTO `news_i18n` (`news_i18n_id`, `news_id`, `language_id`, `status`, `pic`, `title`, `keywords`, `description`) VALUES
(7, 1, 1, 1, 'upload/2013/07/23/51eeaff87c4b8.jpg', 'tw', 'ktw', '<p>\r\n	ddddddddddddtw</p>\r\n'),
(8, 1, 2, 1, 'upload/2013/07/23/51eeb009c6f69.jpg', 'enttt', 'ken', '<p>\r\n	ennnnnnnnnnnnnnnnnnnggggdddddddddddd</p>\r\n');

-- --------------------------------------------------------

--
-- 表的结构 `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `picture_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `pic` varchar(256) NOT NULL,
  `picture_type_id` int(11) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`picture_id`),
  KEY `pic_type_id` (`picture_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `picture_i18n`
--

CREATE TABLE IF NOT EXISTS `picture_i18n` (
  `picture_i18n_id` int(15) NOT NULL AUTO_INCREMENT,
  `picture_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `url` varchar(256) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `keywords` text,
  `description` text,
  PRIMARY KEY (`picture_i18n_id`),
  KEY `language_id` (`language_id`),
  KEY `picture_id` (`picture_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `picture_type`
--

CREATE TABLE IF NOT EXISTS `picture_type` (
  `picture_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `picture_type` varchar(256) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`picture_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `picture_type`
--

INSERT INTO `picture_type` (`picture_type_id`, `picture_type`, `create_time`, `update_time`) VALUES
(1, 'Banner', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `price` decimal(10,0) NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`product_id`, `sort_order`, `price`, `create_time`, `update_time`) VALUES
(4, 0, '300', '2013-07-29 23:21:01', '2014-05-09 01:08:18'),
(5, 0, '289', '2013-10-29 11:30:17', '2014-02-20 16:20:39');

-- --------------------------------------------------------

--
-- 表的结构 `product2category`
--

CREATE TABLE IF NOT EXISTS `product2category` (
  `product2category_id` int(15) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product2category_id`),
  KEY `product_id` (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `product2category`
--

INSERT INTO `product2category` (`product2category_id`, `product_id`, `category_id`) VALUES
(5, 5, 7),
(18, 4, 7);

-- --------------------------------------------------------

--
-- 表的结构 `product_i18n`
--

CREATE TABLE IF NOT EXISTS `product_i18n` (
  `product_i18n_id` int(15) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `pic` varchar(256) NOT NULL,
  `title` varchar(256) NOT NULL,
  `keywords` text,
  `description` text,
  PRIMARY KEY (`product_i18n_id`),
  KEY `product_id` (`product_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- 转存表中的数据 `product_i18n`
--

INSERT INTO `product_i18n` (`product_i18n_id`, `product_id`, `language_id`, `status`, `pic`, `title`, `keywords`, `description`) VALUES
(12, 5, 1, 1, 'upload/2013/10/29/526f2bb450dd5.jpg', 'tw1', NULL, NULL),
(13, 5, 2, 1, 'upload/2013/10/29/526f2bc317c47.jpg', 'en1', NULL, NULL),
(34, 4, 1, 1, 'upload/2014/04/12/534831b94c4b4.jpg', 'tw', 'ktw', '<p>dtw</p>\r\n'),
(35, 4, 2, 1, 'upload/2014/04/12/5348204329f63.jpg', 'en', 'ken', '<p>den</p>\r\n');

-- --------------------------------------------------------

--
-- 表的结构 `product_image`
--

CREATE TABLE IF NOT EXISTS `product_image` (
  `product_image_id` int(15) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `pic` varchar(256) NOT NULL,
  PRIMARY KEY (`product_image_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `key` varchar(100) NOT NULL,
  `value` text,
  PRIMARY KEY (`key`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `setting`
--

INSERT INTO `setting` (`key`, `value`) VALUES
('analysis_google', 's:0:"";'),
('mail_email_contact', 's:15:"sam@ozchamp.net";'),
('mail_smtp_host', 's:12:"smtp.163.com";'),
('mail_smtp_password', 's:9:"oz3661000";'),
('mail_smtp_port', 's:2:"25";'),
('mail_smtp_user', 's:14:"oz_sam@163.com";'),
('meta_description_1', 's:26:"元伸科技 | description";'),
('meta_description_2', 's:21:"Ozchamp | description";'),
('meta_keywords_1', 's:23:"元伸科技 | keywords";'),
('meta_keywords_2', 's:18:"Ozchamp | keywords";'),
('meta_title_1', 's:12:"元伸科技";'),
('meta_title_2', 's:7:"Ozchamp";');

-- --------------------------------------------------------

--
-- 表的结构 `twzip_city`
--

CREATE TABLE IF NOT EXISTS `twzip_city` (
  `twzip_city_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`twzip_city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='縣市' AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `twzip_city`
--

INSERT INTO `twzip_city` (`twzip_city_id`, `sort_order`, `name`) VALUES
(1, 23, '基隆市'),
(2, 22, '台北市'),
(3, 21, '新北市'),
(4, 20, '宜蘭縣'),
(5, 19, '新竹市'),
(6, 18, '新竹縣'),
(7, 17, '桃園縣'),
(8, 16, '苗栗縣'),
(9, 15, '台中市'),
(10, 14, '彰化縣'),
(11, 13, '南投縣'),
(12, 12, '嘉義市'),
(13, 11, '嘉義縣'),
(14, 10, '雲林縣'),
(15, 9, '台南市'),
(16, 8, '高雄市'),
(17, 7, '屏東縣'),
(18, 6, '台東縣'),
(19, 5, '花蓮縣'),
(20, 4, '金門縣'),
(21, 3, '連江縣'),
(22, 2, '澎湖縣'),
(23, 1, '南海諸島');

-- --------------------------------------------------------

--
-- 表的结构 `twzip_county`
--

CREATE TABLE IF NOT EXISTS `twzip_county` (
  `twzip_county_id` int(11) NOT NULL AUTO_INCREMENT,
  `twzip_city_id` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `postcode` varchar(32) DEFAULT '',
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`twzip_county_id`),
  KEY `twzip_city_id` (`twzip_city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='郵區號' AUTO_INCREMENT=372 ;

--
-- 转存表中的数据 `twzip_county`
--

INSERT INTO `twzip_county` (`twzip_county_id`, `twzip_city_id`, `sort_order`, `postcode`, `name`) VALUES
(1, 1, 7, '200', '仁愛區'),
(2, 1, 6, '201', '信義區'),
(3, 1, 5, '202', '中正區'),
(4, 1, 4, '203', '中山區'),
(5, 1, 3, '204', '安樂區'),
(6, 1, 2, '205', '暖暖區'),
(7, 1, 1, '206', '七堵區'),
(8, 2, 12, '100', '中正區'),
(9, 2, 11, '103', '大同區'),
(10, 2, 10, '104', '中山區'),
(11, 2, 9, '105', '松山區'),
(12, 2, 8, '106', '大安區'),
(13, 2, 7, '108', '萬華區'),
(14, 2, 6, '110', '信義區'),
(15, 2, 5, '111', '士林區'),
(16, 2, 4, '112', '北投區'),
(17, 2, 3, '114', '內湖區'),
(18, 2, 2, '115', '南港區'),
(19, 2, 1, '116', '文山區'),
(20, 3, 29, '207', '萬里區'),
(21, 3, 28, '208', '金山區'),
(22, 3, 27, '220', '板橋區'),
(23, 3, 26, '221', '汐止區'),
(24, 3, 25, '222', '深坑區'),
(25, 3, 24, '223', '石碇區'),
(26, 3, 23, '224', '瑞芳區'),
(27, 3, 22, '226', '平溪區'),
(28, 3, 21, '227', '雙溪區'),
(29, 3, 20, '228', '貢寮區'),
(30, 3, 19, '231', '新店區'),
(31, 3, 18, '232', '坪林區'),
(32, 3, 17, '233', '烏來區'),
(33, 3, 16, '234', '永和區'),
(34, 3, 15, '235', '中和區'),
(35, 3, 14, '236', '土城區'),
(36, 3, 13, '237', '三峽區'),
(37, 3, 12, '238', '樹林區'),
(38, 3, 11, '239', '鶯歌區'),
(39, 3, 10, '241', '三重區'),
(40, 3, 9, '242', '新莊區'),
(41, 3, 8, '243', '泰山區'),
(42, 3, 7, '244', '林口區'),
(43, 3, 6, '247', '蘆洲區'),
(44, 3, 5, '248', '五股區'),
(45, 3, 4, '249', '八里區'),
(46, 3, 3, '251', '淡水區'),
(47, 3, 2, '252', '三芝區'),
(48, 3, 1, '253', '石門區'),
(49, 4, 13, '260', '宜蘭市'),
(50, 4, 12, '261', '頭城鎮'),
(51, 4, 11, '262', '礁溪鄉'),
(52, 4, 10, '263', '壯圍鄉'),
(53, 4, 9, '264', '員山鄉'),
(54, 4, 8, '265', '羅東鎮'),
(55, 4, 7, '266', '三星鄉'),
(56, 4, 6, '267', '大同鄉'),
(57, 4, 5, '268', '五結鄉'),
(58, 4, 4, '269', '冬山鄉'),
(59, 4, 3, '270', '蘇澳鎮'),
(60, 4, 2, '272', '南澳鄉'),
(61, 4, 1, '290', '釣魚台列嶼'),
(62, 5, 3, '300', '東區'),
(63, 5, 2, '300', '北區'),
(64, 5, 1, '300', '香山區'),
(65, 6, 13, '302', '竹北市'),
(66, 6, 12, '303', '湖口鄉'),
(67, 6, 11, '304', '新豐鄉'),
(68, 6, 10, '305', '新埔鎮'),
(69, 6, 9, '306', '關西鎮'),
(70, 6, 8, '307', '芎林鄉'),
(71, 6, 7, '308', '寶山鄉'),
(72, 6, 6, '310', '竹東鎮'),
(73, 6, 5, '311', '五峰鄉'),
(74, 6, 4, '312', '橫山鄉'),
(75, 6, 3, '313', '尖石鄉'),
(76, 6, 2, '314', '北埔鄉'),
(77, 6, 1, '315', '峨嵋鄉'),
(78, 7, 13, '320', '中壢市'),
(79, 7, 12, '324', '平鎮市'),
(80, 7, 11, '325', '龍潭鄉'),
(81, 7, 10, '326', '楊梅鎮'),
(82, 7, 9, '327', '新屋鄉'),
(83, 7, 8, '328', '觀音鄉'),
(84, 7, 7, '330', '桃園市'),
(85, 7, 6, '333', '龜山鄉'),
(86, 7, 5, '334', '八德市'),
(87, 7, 4, '335', '大溪鎮'),
(88, 7, 3, '336', '復興鄉'),
(89, 7, 2, '337', '大園鄉'),
(90, 7, 1, '338', '蘆竹鄉'),
(91, 8, 18, '350', '竹南鎮'),
(92, 8, 17, '351', '頭份鎮'),
(93, 8, 16, '352', '三灣鄉'),
(94, 8, 15, '353', '南庄鄉'),
(95, 8, 14, '354', '獅潭鄉'),
(96, 8, 13, '356', '後龍鎮'),
(97, 8, 12, '357', '通霄鎮'),
(98, 8, 11, '358', '苑裡鎮'),
(99, 8, 10, '360', '苗栗市'),
(100, 8, 9, '361', '造橋鄉'),
(101, 8, 8, '362', '頭屋鄉'),
(102, 8, 7, '363', '公館鄉'),
(103, 8, 6, '364', '大湖鄉'),
(104, 8, 5, '365', '泰安鄉'),
(105, 8, 4, '366', '銅鑼鄉'),
(106, 8, 3, '367', '三義鄉'),
(107, 8, 2, '368', '西湖鄉'),
(108, 8, 1, '369', '卓蘭鎮'),
(109, 9, 29, '400', '中區'),
(110, 9, 28, '401', '東區'),
(111, 9, 27, '402', '南區'),
(112, 9, 26, '403', '西區'),
(113, 9, 25, '404', '北區'),
(114, 9, 24, '406', '北屯區'),
(115, 9, 23, '407', '西屯區'),
(116, 9, 22, '408', '南屯區'),
(117, 9, 21, '411', '太平區'),
(118, 9, 20, '412', '大里區'),
(119, 9, 19, '413', '霧峰區'),
(120, 9, 18, '414', '烏日區'),
(121, 9, 17, '420', '豐原區'),
(122, 9, 16, '421', '后里區'),
(123, 9, 15, '422', '石岡區'),
(124, 9, 14, '423', '東勢區'),
(125, 9, 13, '424', '和平區'),
(126, 9, 12, '426', '新社區'),
(127, 9, 11, '427', '潭子區'),
(128, 9, 10, '428', '大雅區'),
(129, 9, 9, '429', '神岡區'),
(130, 9, 8, '432', '大肚區'),
(131, 9, 7, '433', '沙鹿區'),
(132, 9, 6, '434', '龍井區'),
(133, 9, 5, '435', '梧棲區'),
(134, 9, 4, '436', '清水區'),
(135, 9, 3, '437', '大甲區'),
(136, 9, 2, '438', '外埔區'),
(137, 9, 1, '439', '大安區'),
(138, 10, 26, '500', '彰化市'),
(139, 10, 25, '502', '芬園鄉'),
(140, 10, 24, '503', '花壇鄉'),
(141, 10, 23, '504', '秀水鄉'),
(142, 10, 22, '505', '鹿港鎮'),
(143, 10, 21, '506', '福興鄉'),
(144, 10, 20, '507', '線西鄉'),
(145, 10, 19, '508', '和美鎮'),
(146, 10, 18, '509', '伸港鄉'),
(147, 10, 17, '510', '員林鎮'),
(148, 10, 16, '511', '社頭鄉'),
(149, 10, 15, '512', '永靖鄉'),
(150, 10, 14, '513', '埔心鄉'),
(151, 10, 13, '514', '溪湖鎮'),
(152, 10, 12, '515', '大村鄉'),
(153, 10, 11, '516', '埔鹽鄉'),
(154, 10, 10, '520', '田中鎮'),
(155, 10, 9, '521', '北斗鎮'),
(156, 10, 8, '522', '田尾鄉'),
(157, 10, 7, '523', '埤頭鄉'),
(158, 10, 6, '524', '溪州鄉'),
(159, 10, 5, '525', '竹塘鄉'),
(160, 10, 4, '526', '二林鎮'),
(161, 10, 3, '527', '大城鄉'),
(162, 10, 2, '528', '芳苑鄉'),
(163, 10, 1, '530', '二水鄉'),
(164, 11, 13, '540', '南投市'),
(165, 11, 12, '541', '中寮鄉'),
(166, 11, 11, '542', '草屯鎮'),
(167, 11, 10, '544', '國姓鄉'),
(168, 11, 9, '545', '埔里鎮'),
(169, 11, 8, '546', '仁愛鄉'),
(170, 11, 7, '551', '名間鄉'),
(171, 11, 6, '552', '集集鎮'),
(172, 11, 5, '553', '水里鄉'),
(173, 11, 4, '555', '魚池鄉'),
(174, 11, 3, '556', '信義鄉'),
(175, 11, 2, '557', '竹山鎮'),
(176, 11, 1, '558', '鹿谷鄉'),
(177, 12, 2, '600', '東區'),
(178, 12, 1, '600', '西區'),
(179, 13, 18, '602', '番路鄉'),
(180, 13, 17, '603', '梅山鄉'),
(181, 13, 16, '604', '竹崎鄉'),
(182, 13, 15, '605', '阿里山'),
(183, 13, 14, '606', '中埔鄉'),
(184, 13, 13, '607', '大埔鄉'),
(185, 13, 12, '608', '水上鄉'),
(186, 13, 11, '611', '鹿草鄉'),
(187, 13, 10, '612', '太保市'),
(188, 13, 9, '613', '朴子市'),
(189, 13, 8, '614', '東石鄉'),
(190, 13, 7, '615', '六腳鄉'),
(191, 13, 6, '616', '新港鄉'),
(192, 13, 5, '621', '民雄鄉'),
(193, 13, 4, '622', '大林鎮'),
(194, 13, 3, '623', '溪口鄉'),
(195, 13, 2, '624', '義竹鄉'),
(196, 13, 1, '625', '布袋鎮'),
(197, 14, 20, '630', '斗南鎮'),
(198, 14, 19, '631', '大埤鄉'),
(199, 14, 18, '632', '虎尾鎮'),
(200, 14, 17, '633', '土庫鎮'),
(201, 14, 16, '634', '褒忠鄉'),
(202, 14, 15, '635', '東勢鄉'),
(203, 14, 14, '636', '臺西鄉'),
(204, 14, 13, '637', '崙背鄉'),
(205, 14, 12, '638', '麥寮鄉'),
(206, 14, 11, '640', '斗六市'),
(207, 14, 10, '643', '林內鄉'),
(208, 14, 9, '646', '古坑鄉'),
(209, 14, 8, '647', '莿桐鄉'),
(210, 14, 7, '648', '西螺鎮'),
(211, 14, 6, '649', '二崙鄉'),
(212, 14, 5, '651', '北港鎮'),
(213, 14, 4, '652', '水林鄉'),
(214, 14, 3, '653', '口湖鄉'),
(215, 14, 2, '654', '四湖鄉'),
(216, 14, 1, '655', '元長鄉'),
(217, 15, 37, '700', '中西區'),
(218, 15, 36, '701', '東區'),
(219, 15, 35, '702', '南區'),
(220, 15, 34, '704', '北區'),
(221, 15, 33, '708', '安平區'),
(222, 15, 32, '709', '安南區'),
(223, 15, 31, '710', '永康區'),
(224, 15, 30, '711', '歸仁區'),
(225, 15, 29, '712', '新化區'),
(226, 15, 28, '713', '左鎮區'),
(227, 15, 27, '714', '玉井區'),
(228, 15, 26, '715', '楠西區'),
(229, 15, 25, '716', '南化區'),
(230, 15, 24, '717', '仁德區'),
(231, 15, 23, '718', '關廟區'),
(232, 15, 22, '719', '龍崎區'),
(233, 15, 21, '720', '官田區'),
(234, 15, 20, '721', '麻豆區'),
(235, 15, 19, '722', '佳里區'),
(236, 15, 18, '723', '西港區'),
(237, 15, 17, '724', '七股區'),
(238, 15, 16, '725', '將軍區'),
(239, 15, 15, '726', '學甲區'),
(240, 15, 14, '727', '北門區'),
(241, 15, 13, '730', '新營區'),
(242, 15, 12, '731', '後壁區'),
(243, 15, 11, '732', '白河區'),
(244, 15, 10, '733', '東山區'),
(245, 15, 9, '734', '六甲區'),
(246, 15, 8, '735', '下營區'),
(247, 15, 7, '736', '柳營區'),
(248, 15, 6, '737', '鹽水區'),
(249, 15, 5, '741', '善化區'),
(250, 15, 4, '742', '大內區'),
(251, 15, 3, '743', '山上區'),
(252, 15, 2, '744', '新市區'),
(253, 15, 1, '745', '安定區'),
(254, 16, 38, '800', '新興區'),
(255, 16, 37, '801', '前金區'),
(256, 16, 36, '802', '苓雅區'),
(257, 16, 35, '803', '鹽埕區'),
(258, 16, 34, '804', '鼓山區'),
(259, 16, 33, '805', '旗津區'),
(260, 16, 32, '806', '前鎮區'),
(261, 16, 31, '807', '三民區'),
(262, 16, 30, '811', '楠梓區'),
(263, 16, 29, '812', '小港區'),
(264, 16, 28, '813', '左營區'),
(265, 16, 27, '814', '仁武區'),
(266, 16, 26, '815', '大社區'),
(267, 16, 25, '820', '岡山區'),
(268, 16, 24, '821', '路竹區'),
(269, 16, 23, '822', '阿蓮區'),
(270, 16, 22, '823', '田寮鄉'),
(271, 16, 21, '824', '燕巢區'),
(272, 16, 20, '825', '橋頭區'),
(273, 16, 19, '826', '梓官區'),
(274, 16, 18, '827', '彌陀區'),
(275, 16, 17, '828', '永安區'),
(276, 16, 16, '829', '湖內鄉'),
(277, 16, 15, '830', '鳳山區'),
(278, 16, 14, '831', '大寮區'),
(279, 16, 13, '832', '林園區'),
(280, 16, 12, '833', '鳥松區'),
(281, 16, 11, '840', '大樹區'),
(282, 16, 10, '842', '旗山區'),
(283, 16, 9, '843', '美濃區'),
(284, 16, 8, '844', '六龜區'),
(285, 16, 7, '845', '內門區'),
(286, 16, 6, '846', '杉林區'),
(287, 16, 5, '847', '甲仙區'),
(288, 16, 4, '848', '桃源區'),
(289, 16, 3, '849', '那瑪夏區'),
(290, 16, 2, '851', '茂林區'),
(291, 16, 1, '852', '茄萣區'),
(292, 17, 33, '900', '屏東市'),
(293, 17, 32, '901', '三地門'),
(294, 17, 31, '902', '霧臺鄉'),
(295, 17, 30, '903', '瑪家鄉'),
(296, 17, 29, '904', '九如鄉'),
(297, 17, 28, '905', '里港鄉'),
(298, 17, 27, '906', '高樹鄉'),
(299, 17, 26, '907', '鹽埔鄉'),
(300, 17, 25, '908', '長治鄉'),
(301, 17, 24, '909', '麟洛鄉'),
(302, 17, 23, '911', '竹田鄉'),
(303, 17, 22, '912', '內埔鄉'),
(304, 17, 21, '913', '萬丹鄉'),
(305, 17, 20, '920', '潮州鎮'),
(306, 17, 19, '921', '泰武鄉'),
(307, 17, 18, '922', '來義鄉'),
(308, 17, 17, '923', '萬巒鄉'),
(309, 17, 16, '924', '崁頂鄉'),
(310, 17, 15, '925', '新埤鄉'),
(311, 17, 14, '926', '南州鄉'),
(312, 17, 13, '927', '林邊鄉'),
(313, 17, 12, '928', '東港鎮'),
(314, 17, 11, '929', '琉球鄉'),
(315, 17, 10, '931', '佳冬鄉'),
(316, 17, 9, '932', '新園鄉'),
(317, 17, 8, '940', '枋寮鄉'),
(318, 17, 7, '941', '枋山鄉'),
(319, 17, 6, '942', '春日鄉'),
(320, 17, 5, '943', '獅子鄉'),
(321, 17, 4, '944', '車城鄉'),
(322, 17, 3, '945', '牡丹鄉'),
(323, 17, 2, '946', '恆春鎮'),
(324, 17, 1, '947', '滿州鄉'),
(325, 18, 16, '950', '臺東市'),
(326, 18, 15, '951', '綠島鄉'),
(327, 18, 14, '952', '蘭嶼鄉'),
(328, 18, 13, '953', '延平鄉'),
(329, 18, 12, '954', '卑南鄉'),
(330, 18, 11, '955', '鹿野鄉'),
(331, 18, 10, '956', '關山鎮'),
(332, 18, 9, '957', '海端鄉'),
(333, 18, 8, '958', '池上鄉'),
(334, 18, 7, '959', '東河鄉'),
(335, 18, 6, '961', '成功鎮'),
(336, 18, 5, '962', '長濱鄉'),
(337, 18, 4, '963', '太麻里鄉'),
(338, 18, 3, '964', '金峰鄉'),
(339, 18, 2, '965', '大武鄉'),
(340, 18, 1, '966', '達仁鄉'),
(341, 19, 13, '970', '花蓮市'),
(342, 19, 12, '971', '新城鄉'),
(343, 19, 11, '972', '秀林鄉'),
(344, 19, 10, '973', '吉安鄉'),
(345, 19, 9, '974', '壽豐鄉'),
(346, 19, 8, '975', '鳳林鎮'),
(347, 19, 7, '976', '光復鄉'),
(348, 19, 6, '977', '豐濱鄉'),
(349, 19, 5, '978', '瑞穗鄉'),
(350, 19, 4, '979', '萬榮鄉'),
(351, 19, 3, '981', '玉里鎮'),
(352, 19, 2, '982', '卓溪鄉'),
(353, 19, 1, '983', '富里鄉'),
(354, 20, 6, '890', '金沙鎮'),
(355, 20, 5, '891', '金湖鎮'),
(356, 20, 4, '892', '金寧鄉'),
(357, 20, 3, '893', '金城鎮'),
(358, 20, 2, '894', '烈嶼鄉'),
(359, 20, 1, '896', '烏坵鄉'),
(360, 21, 4, '209', '南竿鄉'),
(361, 21, 3, '210', '北竿鄉'),
(362, 21, 2, '211', '莒光鄉'),
(363, 21, 1, '212', '東引鄉'),
(364, 22, 6, '880', '馬公市'),
(365, 22, 5, '881', '西嶼鄉'),
(366, 22, 4, '882', '望安鄉'),
(367, 22, 3, '883', '七美鄉'),
(368, 22, 2, '884', '白沙鄉'),
(369, 22, 1, '885', '湖西鄉'),
(370, 23, 2, '817', '東沙'),
(371, 23, 1, '819', '南沙');

--
-- 限制导出的表
--

--
-- 限制表 `admin_authassignment`
--
ALTER TABLE `admin_authassignment`
  ADD CONSTRAINT `admin_authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `admin_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `admin_authitemchild`
--
ALTER TABLE `admin_authitemchild`
  ADD CONSTRAINT `admin_authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `admin_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `admin_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `admin_rights`
--
ALTER TABLE `admin_rights`
  ADD CONSTRAINT `admin_rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `admin_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `category` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `category_i18n`
--
ALTER TABLE `category_i18n`
  ADD CONSTRAINT `category_i18n_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_i18n_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`language_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_4` FOREIGN KEY (`customer_type_id`) REFERENCES `customer_type` (`customer_type_id`) ON UPDATE CASCADE;

--
-- 限制表 `customer_authassignment`
--
ALTER TABLE `customer_authassignment`
  ADD CONSTRAINT `customer_authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `customer_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `customer_authitemchild`
--
ALTER TABLE `customer_authitemchild`
  ADD CONSTRAINT `customer_authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `customer_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `customer_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `customer_rights`
--
ALTER TABLE `customer_rights`
  ADD CONSTRAINT `customer_rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `customer_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `information`
--
ALTER TABLE `information`
  ADD CONSTRAINT `information_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `information` (`information_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `information_i18n`
--
ALTER TABLE `information_i18n`
  ADD CONSTRAINT `information_i18n_ibfk_1` FOREIGN KEY (`information_id`) REFERENCES `information` (`information_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `information_i18n_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`language_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `news_i18n`
--
ALTER TABLE `news_i18n`
  ADD CONSTRAINT `news_i18n_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`news_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `news_i18n_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`language_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `picture_ibfk_1` FOREIGN KEY (`picture_type_id`) REFERENCES `picture_type` (`picture_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `picture_i18n`
--
ALTER TABLE `picture_i18n`
  ADD CONSTRAINT `picture_i18n_ibfk_1` FOREIGN KEY (`picture_id`) REFERENCES `picture` (`picture_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `picture_i18n_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`language_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `product2category`
--
ALTER TABLE `product2category`
  ADD CONSTRAINT `product2category_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product2category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `product_i18n`
--
ALTER TABLE `product_i18n`
  ADD CONSTRAINT `product_i18n_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_i18n_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`language_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `twzip_county`
--
ALTER TABLE `twzip_county`
  ADD CONSTRAINT `twzip_county_ibfk_1` FOREIGN KEY (`twzip_city_id`) REFERENCES `twzip_city` (`twzip_city_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
