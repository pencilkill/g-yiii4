-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 01 月 21 日 13:32
-- 服务器版本: 5.5.24-log
-- PHP 版本: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `yii_yiii4`
--

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
  `super` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `username`, `email`, `password`, `status`, `super`, `create_time`, `update_time`) VALUES
(1, 'admin', 'admin', 'sam@ozchamp.net', '1a85380e2ae37e8385ecd73b468f632d', 1, 1, '2013-06-01 00:00:00', '2013-08-22 03:51:54'),
(2, 'administrator', 'administrator', 'sam@ozchamp.net', '72870614884a05be92e3c79d8969a3eb', 1, 1, '2013-06-01 12:03:02', '2013-08-22 03:47:36'),
(5, 'ozchamp', 'ozchamp', 'sam@ozchamp.net', '72870614884a05be92e3c79d8969a3eb', 1, 0, '2013-08-22 03:27:11', '2014-01-18 13:16:23');

-- --------------------------------------------------------

--
-- 表的结构 `authassignment`
--

CREATE TABLE IF NOT EXISTS `authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `authassignment`
--

INSERT INTO `authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('Admin', '1', NULL, 'N;'),
('Administrator', '2', NULL, 'N;'),
('Authenticated', '5', NULL, 'N;');

-- --------------------------------------------------------

--
-- 表的结构 `authitem`
--

CREATE TABLE IF NOT EXISTS `authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `authitem`
--

INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('Admin', 2, 'role which can access all', NULL, 'N;'),
('Admin.Account', 0, NULL, NULL, 'N;'),
('Admin.Create', 0, NULL, NULL, 'N;'),
('Admin.Delete', 0, NULL, NULL, 'N;'),
('Admin.Gridviewdelete', 0, NULL, NULL, 'N;'),
('Admin.Index', 0, NULL, NULL, 'N;'),
('Admin.Update', 0, NULL, NULL, 'N;'),
('Administrator', 2, 'role which can access all but not the super admin ,that is mean the super property of admin model belong to items of this role is equal to false', NULL, 'N;'),
('Authenticated', 2, 'role which can not access admin controller except account action to update himself informations', NULL, 'N;'),
('Category.*', 1, 'Category.*', NULL, 'N;'),
('Contact.*', 1, 'Contact.*', NULL, 'N;'),
('Guest', 2, 'role which can access a few actions only.\r\ncause rights RBAC can not get actions() item from controller,role guest filter actions will be defined in site controller->allowedactions()', NULL, 'N;'),
('Information.*', 1, 'Information.*', NULL, 'N;'),
('News.*', 1, 'News.*', NULL, 'N;'),
('Pic.*', 1, 'Pic.*', NULL, 'N;'),
('PicType.*', 1, 'PicType.*', NULL, 'N;'),
('Product.*', 1, 'Product.*', NULL, 'N;'),
('Setting.*', 1, 'Setting.*', NULL, 'N;'),
('Site.*', 1, 'Site.*', NULL, 'N;');

-- --------------------------------------------------------

--
-- 表的结构 `authitemchild`
--

CREATE TABLE IF NOT EXISTS `authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `authitemchild`
--

INSERT INTO `authitemchild` (`parent`, `child`) VALUES
('Authenticated', 'Admin.Account'),
('Administrator', 'Admin.Create'),
('Administrator', 'Admin.Delete'),
('Administrator', 'Admin.Gridviewdelete'),
('Administrator', 'Admin.Index'),
('Administrator', 'Admin.Update'),
('Administrator', 'Authenticated'),
('Authenticated', 'Category.*'),
('Authenticated', 'Contact.*'),
('Authenticated', 'Guest'),
('Authenticated', 'Information.*'),
('Authenticated', 'News.*'),
('Authenticated', 'Pic.*'),
('Authenticated', 'PicType.*'),
('Authenticated', 'Product.*'),
('Authenticated', 'Setting.*'),
('Authenticated', 'Site.*');

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
(4, NULL, 0, '2013-08-24 04:13:48', '2014-01-14 16:42:20'),
(7, 4, 1, '2013-08-24 05:23:17', '2014-01-08 19:28:22'),
(10, NULL, 0, '2014-01-14 20:39:00', '2014-01-15 00:47:05');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- 转存表中的数据 `category_i18n`
--

INSERT INTO `category_i18n` (`category_i18n_id`, `category_id`, `language_id`, `title`, `keywords`, `description`) VALUES
(19, 7, 1, 'twc2', NULL, NULL),
(20, 7, 2, 'enc2', NULL, NULL),
(21, 7, 2, 'enc2', NULL, NULL),
(22, 7, 2, 'enc2', NULL, NULL),
(23, 7, 2, 'enc2', NULL, NULL),
(24, 7, 2, 'enc2', NULL, NULL),
(25, 7, 2, 'enc2', NULL, NULL),
(26, 7, 2, 'enc2', NULL, NULL),
(27, 7, 2, 'enc2', NULL, NULL),
(28, 7, 2, 'enc2', NULL, NULL),
(29, 7, 2, 'enc2', NULL, NULL),
(30, 7, 2, 'enc2', NULL, NULL),
(32, 7, 2, 'enc2', NULL, NULL),
(33, 7, 2, 'enc2', NULL, NULL),
(34, 7, 2, 'enc2', NULL, NULL),
(38, 4, 1, 'twc1', NULL, NULL),
(39, 4, 2, 'enc1', NULL, NULL),
(44, 10, 1, 'twc3', NULL, NULL),
(45, 10, 2, 'aaaaaa3', NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
(2, NULL, 0, '2013-08-30 03:32:29', '2014-01-15 09:05:08'),
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
(1, 1, 0, '2013-07-23 00:00:00', '2013-07-24 00:32:49', '2013-10-25 09:38:29');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `news_i18n`
--

INSERT INTO `news_i18n` (`news_i18n_id`, `news_id`, `language_id`, `status`, `pic`, `title`, `keywords`, `description`) VALUES
(1, 1, 1, 1, 'upload/2013/07/23/51eeaff87c4b8.jpg', 'tw', 'ktw', '<p>\r\n	ddddddddddddtw</p>\r\n'),
(2, 1, 2, 1, 'upload/2013/07/23/51eeb009c6f69.jpg', 'enttt', 'ken', '<p>\r\n	ennnnnnnnnnnnnnnnnnnggggdddddddddddd</p>\r\n');

-- --------------------------------------------------------

--
-- 表的结构 `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `picture_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `pic` varchar(256) NOT NULL,
  `picture_type_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`picture_id`),
  KEY `pic_type_id` (`picture_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `picture`
--

INSERT INTO `picture` (`picture_id`, `sort_order`, `pic`, `picture_type_id`, `status`, `create_time`, `update_time`) VALUES
(13, 0, 'upload/2013/08/21/521421eedbc32.jpg', 1, 1, '2013-08-21 10:13:17', '2013-08-21 10:13:17');

-- --------------------------------------------------------

--
-- 表的结构 `picture_i18n`
--

CREATE TABLE IF NOT EXISTS `picture_i18n` (
  `picture_i18n_id` int(15) NOT NULL AUTO_INCREMENT,
  `picture_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `url` varchar(256) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `keywords` text,
  `description` text,
  PRIMARY KEY (`picture_i18n_id`),
  KEY `language_id` (`language_id`),
  KEY `picture_id` (`picture_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `picture_i18n`
--

INSERT INTO `picture_i18n` (`picture_i18n_id`, `picture_id`, `language_id`, `url`, `title`, `keywords`, `description`) VALUES
(1, 13, 1, 'http://www.google.com.hk/', 'tw', 'ktw', '<p>\r\n	ddddtw</p>\r\n'),
(2, 13, 2, 'http://www.google.com/', 'en', 'ken', '<p>\r\n	dddden</p>\r\n');

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
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`product_id`, `sort_order`, `create_time`, `update_time`) VALUES
(4, 0, '2013-07-29 23:21:01', '2014-01-15 14:09:47'),
(5, 0, '2013-10-29 11:30:17', '2013-10-29 11:30:17');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `product2category`
--

INSERT INTO `product2category` (`product2category_id`, `product_id`, `category_id`) VALUES
(5, 5, 7),
(9, 4, 7);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `product_i18n`
--

INSERT INTO `product_i18n` (`product_i18n_id`, `product_id`, `language_id`, `status`, `pic`, `title`, `keywords`, `description`) VALUES
(12, 5, 1, 1, 'upload/2013/10/29/526f2bb450dd5.jpg', 'tw1', NULL, NULL),
(13, 5, 2, 1, 'upload/2013/10/29/526f2bc317c47.jpg', 'en1', NULL, NULL),
(16, 4, 1, 1, 'upload/2013/10/28/526dd05dbb6ea.jpg', 'tw', 'ktw', '<p>\r\n	dtw</p>\r\n'),
(17, 4, 2, 1, 'upload/2014/01/15/52d6260bc91b3.jpg', 'en', 'ken', '<p>\r\n	den</p>\r\n');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=171 ;

--
-- 转存表中的数据 `product_image`
--

INSERT INTO `product_image` (`product_image_id`, `product_id`, `pic`) VALUES
(165, 4, 'upload/2013/07/29/51f6b4009933c.jpg'),
(166, 4, 'upload/2013/07/29/51f6b4014a31d.jpg'),
(167, 4, 'upload/2013/07/29/51f6abb0d6e59.jpg'),
(168, 4, 'upload/2013/07/29/51f6ab5237318.jpg'),
(169, 4, 'upload/2013/07/29/51f6abb18308f.jpg'),
(170, 4, 'upload/2014/01/15/52d6255d16431.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `rights`
--

CREATE TABLE IF NOT EXISTS `rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `rights`
--

INSERT INTO `rights` (`itemname`, `type`, `weight`) VALUES
('Category.*', 1, 0),
('Contact.*', 1, 1),
('Information.*', 1, 2),
('News.*', 1, 3),
('Pic.*', 1, 6),
('PicType.*', 1, 4),
('Product.*', 1, 5),
('Setting.*', 1, 7);

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
('analysis_google', 's:1:"s";'),
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

--
-- 限制导出的表
--

--
-- 限制表 `authassignment`
--
ALTER TABLE `authassignment`
  ADD CONSTRAINT `authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `authitemchild`
--
ALTER TABLE `authitemchild`
  ADD CONSTRAINT `authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- 限制表 `rights`
--
ALTER TABLE `rights`
  ADD CONSTRAINT `rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
