-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 08 月 25 日 06:31
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
(1, 'admin', 'admin', 'sam@ozchamp.net', '544a5c496570c9fc4ab46ed2ea7df075', 1, 1, '2013-06-01 00:00:00', '2013-08-22 03:51:54'),
(2, 'administor', 'administor', 'sam@ozchamp.net', '72870614884a05be92e3c79d8969a3eb', 1, 1, '2013-06-01 12:03:02', '2013-08-22 03:47:36'),
(5, 'ozchamp', 'ozchamp', 'sam@ozchamp.net', '72870614884a05be92e3c79d8969a3eb', 1, 0, '2013-08-22 03:27:11', '2013-08-22 03:34:45');

-- --------------------------------------------------------

--
-- 表的结构 `authassignment`
--

CREATE TABLE IF NOT EXISTS `authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `authassignment`
--

INSERT INTO `authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('admin', '1', NULL, 'N;'),
('administor', '2', NULL, 'N;'),
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
('admin', 2, 'role which can access all', NULL, 'N;'),
('Admin.Account', 0, NULL, NULL, 'N;'),
('Admin.Create', 0, NULL, NULL, 'N;'),
('Admin.Delete', 0, NULL, NULL, 'N;'),
('Admin.Gridviewdelete', 0, NULL, NULL, 'N;'),
('Admin.Index', 0, NULL, NULL, 'N;'),
('Admin.Update', 0, NULL, NULL, 'N;'),
('administor', 2, 'role which can access all but not the super admin ,that is mean the super property of admin model belong to items of this role is equal to false', NULL, 'N;'),
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
('administor', 'Admin.Create'),
('administor', 'Admin.Delete'),
('administor', 'Admin.Gridviewdelete'),
('administor', 'Admin.Index'),
('administor', 'Admin.Update'),
('administor', 'Authenticated'),
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
  `parent_id` int(11) NOT NULL,
  `sort_id` int(11) NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`category_id`, `parent_id`, `sort_id`, `create_time`, `update_time`) VALUES
(4, 0, 0, '2013-08-24 04:13:48', '2013-08-24 06:18:54'),
(7, 4, 1, '2013-08-24 05:23:17', '2013-08-24 06:19:15');

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
  KEY `lang` (`language_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `category_i18n`
--

INSERT INTO `category_i18n` (`category_i18n_id`, `category_id`, `language_id`, `title`, `keywords`, `description`) VALUES
(10, 4, 1, 'twc1', NULL, NULL),
(11, 4, 2, 'enc1', NULL, NULL),
(19, 7, 1, 'twc2', NULL, NULL),
(20, 7, 2, 'enc2', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `telphone` varchar(16) NOT NULL,
  `cellphone` varchar(16) DEFAULT NULL,
  `fax` varchar(16) DEFAULT NULL,
  `email` varchar(64) NOT NULL,
  `corporation` varchar(256) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `message` text,
  `note` text,
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
  `sort_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`information_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `information`
--

INSERT INTO `information` (`information_id`, `sort_id`, `status`, `create_time`, `update_time`) VALUES
(1, 0, 1, '2013-06-30 03:22:08', '2013-08-23 22:57:29');

-- --------------------------------------------------------

--
-- 表的结构 `information_i18n`
--

CREATE TABLE IF NOT EXISTS `information_i18n` (
  `information_i18n_id` int(15) NOT NULL AUTO_INCREMENT,
  `information_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `keywords` text,
  `description` text,
  PRIMARY KEY (`information_i18n_id`),
  KEY `faq_id` (`information_id`),
  KEY `lang` (`language_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `information_i18n`
--

INSERT INTO `information_i18n` (`information_i18n_id`, `information_id`, `language_id`, `title`, `keywords`, `description`) VALUES
(1, 1, 1, 't', '', '<p>\r\n	tttty</p>\r\n'),
(2, 1, 2, 'ens', '', '<p>\r\n	eeees</p>\r\n');

-- --------------------------------------------------------

--
-- 表的结构 `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `language_id` int(15) NOT NULL AUTO_INCREMENT,
  `code` varchar(8) NOT NULL,
  `title` varchar(64) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`language_id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `language`
--

INSERT INTO `language` (`language_id`, `code`, `title`, `image`, `sort_id`, `status`) VALUES
(1, 'zh_tw', '繁體中文', '_ozman/image/flags\\hk.png', 0, 1),
(2, 'en_us', 'English', '_ozman/image/flags\\us.png', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `top` tinyint(1) NOT NULL DEFAULT '0',
  `sort_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_added` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `news`
--

INSERT INTO `news` (`news_id`, `top`, `sort_id`, `status`, `date_added`, `create_time`, `update_time`) VALUES
(1, 1, 1, 0, '2013-07-23 00:00:00', '2013-07-24 00:32:49', '2013-08-24 07:07:05');

-- --------------------------------------------------------

--
-- 表的结构 `news_i18n`
--

CREATE TABLE IF NOT EXISTS `news_i18n` (
  `news_i18n_id` int(15) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `pic` varchar(256) DEFAULT NULL,
  `title` varchar(256) NOT NULL,
  `keywords` text,
  `description` text,
  PRIMARY KEY (`news_i18n_id`),
  KEY `news_id` (`news_id`),
  KEY `lang` (`language_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `news_i18n`
--

INSERT INTO `news_i18n` (`news_i18n_id`, `news_id`, `language_id`, `pic`, `title`, `keywords`, `description`) VALUES
(1, 1, 1, 'upload/2013/07/23/51eeaff87c4b8.jpg', 'tw', 'ktw', '<p>\r\n	ddddddddddddtw</p>\r\n'),
(2, 1, 2, 'upload/2013/07/23/51eeb009c6f69.jpg', 'enttt', 'ken', '<p>\r\n	ennnnnnnnnnnnnnnnnnnggggdddddddddddd</p>\r\n');

-- --------------------------------------------------------

--
-- 表的结构 `pic`
--

CREATE TABLE IF NOT EXISTS `pic` (
  `pic_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_id` int(11) NOT NULL DEFAULT '0',
  `pic` varchar(256) NOT NULL,
  `pic_type_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`pic_id`),
  KEY `pic_type_id` (`pic_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `pic`
--

INSERT INTO `pic` (`pic_id`, `sort_id`, `pic`, `pic_type_id`, `status`, `create_time`, `update_time`) VALUES
(13, 0, 'upload/2013/08/21/521421eedbc32.jpg', 1, 1, '2013-08-21 10:13:17', '2013-08-21 10:13:17');

-- --------------------------------------------------------

--
-- 表的结构 `pic_i18n`
--

CREATE TABLE IF NOT EXISTS `pic_i18n` (
  `pic_i18n_id` int(15) NOT NULL AUTO_INCREMENT,
  `pic_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `url` varchar(256) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `keywords` text,
  `description` text,
  PRIMARY KEY (`pic_i18n_id`),
  KEY `news_id` (`pic_id`),
  KEY `lang` (`language_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `pic_i18n`
--

INSERT INTO `pic_i18n` (`pic_i18n_id`, `pic_id`, `language_id`, `url`, `title`, `keywords`, `description`) VALUES
(1, 13, 1, 'http://www.google.com.hk/', 'tw', 'ktw', '<p>\r\n	ddddtw</p>\r\n'),
(2, 13, 2, 'http://www.google.com/', 'en', 'ken', '<p>\r\n	dddden</p>\r\n');

-- --------------------------------------------------------

--
-- 表的结构 `pic_type`
--

CREATE TABLE IF NOT EXISTS `pic_type` (
  `pic_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `pic_type` varchar(256) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`pic_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `pic_type`
--

INSERT INTO `pic_type` (`pic_type_id`, `pic_type`, `create_time`, `update_time`) VALUES
(1, 'Banner', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `top` tinyint(1) NOT NULL DEFAULT '0',
  `sort_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_added` date DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`product_id`, `top`, `sort_id`, `status`, `date_added`, `create_time`, `update_time`) VALUES
(4, 0, 0, 1, '2013-07-29', '2013-07-29 23:21:01', '2013-08-20 22:26:06');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `product2image`
--

CREATE TABLE IF NOT EXISTS `product2image` (
  `product2image_id` int(15) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `pic` varchar(256) NOT NULL,
  PRIMARY KEY (`product2image_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=128 ;

--
-- 转存表中的数据 `product2image`
--

INSERT INTO `product2image` (`product2image_id`, `product_id`, `pic`) VALUES
(123, 4, 'upload/2013/07/29/51f6b4009933c.jpg'),
(124, 4, 'upload/2013/07/29/51f6b4014a31d.jpg'),
(125, 4, 'upload/2013/07/29/51f6abb0d6e59.jpg'),
(126, 4, 'upload/2013/07/29/51f6ab5237318.jpg'),
(127, 4, 'upload/2013/07/29/51f6abb18308f.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `product_i18n`
--

CREATE TABLE IF NOT EXISTS `product_i18n` (
  `product_i18n_id` int(15) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `pic` varchar(256) NOT NULL,
  `title` varchar(256) NOT NULL,
  `keywords` text,
  `description` text,
  PRIMARY KEY (`product_i18n_id`),
  KEY `product_id` (`product_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `product_i18n`
--

INSERT INTO `product_i18n` (`product_i18n_id`, `product_id`, `language_id`, `pic`, `title`, `keywords`, `description`) VALUES
(10, 4, 1, 'upload/2013/08/20/52136768c64dc.jpg', 'tw', 'ktw', '<p>\r\n	dtw</p>\r\n'),
(11, 4, 2, 'upload/2013/07/29/51f68844c85bf.jpg', 'en', 'ken', '<p>\r\n	den</p>\r\n');

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
('analysis_google', 's:0:"";'),
('mail_email_contact', 's:15:"Sam@ozchamp.net";'),
('mail_smtp_host', 's:12:"smtp.163.com";'),
('mail_smtp_password', 's:9:"oz3661000";'),
('mail_smtp_port', 's:2:"25";'),
('mail_smtp_user', 's:9:"oz3661000";'),
('meta_description_1', 's:0:"";'),
('meta_description_2', 's:0:"";'),
('meta_description_3', 's:0:"";'),
('meta_keywords_1', 's:0:"";'),
('meta_keywords_2', 's:0:"";'),
('meta_keywords_3', 's:0:"";'),
('meta_title_1', 's:0:"";'),
('meta_title_2', 's:0:"";'),
('meta_title_3', 's:0:"";');

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
-- 限制表 `category_i18n`
--
ALTER TABLE `category_i18n`
  ADD CONSTRAINT `category_i18n_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_i18n_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`language_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- 限制表 `pic`
--
ALTER TABLE `pic`
  ADD CONSTRAINT `pic_ibfk_1` FOREIGN KEY (`pic_type_id`) REFERENCES `pic_type` (`pic_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `pic_i18n`
--
ALTER TABLE `pic_i18n`
  ADD CONSTRAINT `pic_i18n_ibfk_1` FOREIGN KEY (`pic_id`) REFERENCES `pic` (`pic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pic_i18n_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`language_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `product2category`
--
ALTER TABLE `product2category`
  ADD CONSTRAINT `product2category_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product2category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `product2image`
--
ALTER TABLE `product2image`
  ADD CONSTRAINT `product2image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `product_i18n`
--
ALTER TABLE `product_i18n`
  ADD CONSTRAINT `product_i18n_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_i18n_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`language_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `rights`
--
ALTER TABLE `rights`
  ADD CONSTRAINT `rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
