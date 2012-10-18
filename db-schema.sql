-- MySQL dump 10.13  Distrib 5.1.63, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: helpdesk
-- ------------------------------------------------------
-- Server version	5.1.63-0+squeeze1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `group`
--

DROP TABLE IF EXISTS `group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notify`
--

DROP TABLE IF EXISTS `notify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notify` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `request_id` bigint(20) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `delete` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67987 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `atl_lastdatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'дата последней правки',
  `atl_lastuser` int(10) unsigned NOT NULL COMMENT 'кто последний правил',
  `type_request_id` int(10) unsigned NOT NULL COMMENT 'тип заявки',
  `request_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Дата поступления заявки',
  `who_ip` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `request_user_id` int(10) unsigned NOT NULL COMMENT 'кто подал заявку',
  `date_plan` date DEFAULT NULL COMMENT 'плановая дата исполнения',
  `date_end` datetime DEFAULT NULL COMMENT 'фактическая дата исполнения',
  `department` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'подразделение пользователя',
  `position` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'должность пользователя',
  `fio` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ФИО пользователя',
  `phone` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'телефон пользователя',
  `pc` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '№ системного блока, IP адресс',
  `description` text COLLATE utf8_unicode_ci COMMENT 'описание проблемы',
  `closed` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'закрыта ли заявка',
  PRIMARY KEY (`id`),
  KEY `request_user_id` (`request_user_id`),
  KEY `request_datetime` (`request_datetime`),
  KEY `type_request_id` (`type_request_id`),
  KEY `closed` (`closed`)
) ENGINE=InnoDB AUTO_INCREMENT=4113 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='таблица заявок';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `type_of_request`
--

DROP TABLE IF EXISTS `type_of_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_of_request` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `group_full` int(10) unsigned DEFAULT NULL,
  `group_work` int(10) unsigned DEFAULT NULL,
  `group_notify` int(10) unsigned DEFAULT NULL,
  `group_view` int(10) unsigned DEFAULT NULL,
  `norma` int(10) unsigned DEFAULT NULL,
  `complexity` float unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='дерево типов заявок';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `locked` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `jabber` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `changepass` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `number` int(10) unsigned DEFAULT NULL,
  `razr` tinyint(3) unsigned DEFAULT NULL,
  `activity` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  KEY `locked` (`locked`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_group` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `user_id` (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `v_group`
--

DROP TABLE IF EXISTS `v_group`;
/*!50001 DROP VIEW IF EXISTS `v_group`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v_group` (
  `gid` int(10) unsigned,
  `gname` varchar(64),
  `uid` int(10) unsigned,
  `uname` varchar(200),
  `ingroup` bigint(21)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_notify`
--

DROP TABLE IF EXISTS `v_notify`;
/*!50001 DROP VIEW IF EXISTS `v_notify`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v_notify` (
  `id` bigint(20) unsigned,
  `request_id` bigint(20) unsigned,
  `tr_name` varchar(200),
  `delete` tinyint(1) unsigned,
  `message` text,
  `u_name` varchar(200),
  `jabber` varchar(100),
  `date_begin` datetime,
  `date_end` datetime,
  `comment` text
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_request`
--

DROP TABLE IF EXISTS `v_request`;
/*!50001 DROP VIEW IF EXISTS `v_request`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v_request` (
  `id` bigint(20) unsigned,
  `regtime` datetime,
  `department` varchar(200),
  `position` varchar(100),
  `fio` varchar(100),
  `phone` varchar(32),
  `pc` varchar(64),
  `ip` varchar(32),
  `description` text,
  `closed` int(10) unsigned,
  `utime` timestamp,
  `uuser` int(10) unsigned,
  `rtype` varchar(200),
  `rtype_id` int(10) unsigned,
  `group_full` int(10) unsigned,
  `group_work` int(10) unsigned,
  `group_view` int(10) unsigned,
  `date_plan` date,
  `date_end` datetime,
  `deadline` int(1)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_request_open`
--

DROP TABLE IF EXISTS `v_request_open`;
/*!50001 DROP VIEW IF EXISTS `v_request_open`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v_request_open` (
  `id` bigint(20) unsigned,
  `regtime` datetime,
  `department` varchar(200),
  `position` varchar(100),
  `fio` varchar(100),
  `phone` varchar(32),
  `pc` varchar(64),
  `ip` varchar(32),
  `description` text,
  `closed` int(10) unsigned,
  `utime` timestamp,
  `uuser` int(10) unsigned,
  `rtype` varchar(200),
  `rtype_id` int(10) unsigned,
  `group_full` int(10) unsigned,
  `group_work` int(10) unsigned,
  `group_view` int(10) unsigned,
  `worker_id` int(10) unsigned,
  `date_plan` date,
  `date_end` datetime,
  `deadline` int(1),
  `wcount` bigint(21)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_request_work`
--

DROP TABLE IF EXISTS `v_request_work`;
/*!50001 DROP VIEW IF EXISTS `v_request_work`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v_request_work` (
  `id` bigint(20) unsigned,
  `regtime` datetime,
  `department` varchar(200),
  `position` varchar(100),
  `fio` varchar(100),
  `phone` varchar(32),
  `pc` varchar(64),
  `ip` varchar(32),
  `description` text,
  `closed` int(10) unsigned,
  `utime` timestamp,
  `uuser` int(10) unsigned,
  `rtype` varchar(200),
  `rtype_id` int(10) unsigned,
  `group_full` int(10) unsigned,
  `group_work` int(10) unsigned,
  `group_view` int(10) unsigned,
  `worker_id` int(10) unsigned,
  `date_plan` date,
  `date_end` datetime,
  `deadline` int(1)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_user_group`
--

DROP TABLE IF EXISTS `v_user_group`;
/*!50001 DROP VIEW IF EXISTS `v_user_group`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v_user_group` (
  `user_id` int(10) unsigned,
  `login` varchar(20),
  `jabber` varchar(100),
  `group_id` int(10) unsigned,
  `groupname` varchar(64)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_worker`
--

DROP TABLE IF EXISTS `v_worker`;
/*!50001 DROP VIEW IF EXISTS `v_worker`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v_worker` (
  `request_id` bigint(20) unsigned,
  `name` varchar(200),
  `uid` int(10) unsigned
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_works`
--

DROP TABLE IF EXISTS `v_works`;
/*!50001 DROP VIEW IF EXISTS `v_works`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v_works` (
  `id` bigint(20) unsigned,
  `rtype` int(10) unsigned,
  `uid` int(10) unsigned,
  `rtype_name` varchar(200),
  `date_begin` datetime,
  `date_end` datetime,
  `rtime` decimal(12,1),
  `wtime` double
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_works_service`
--

DROP TABLE IF EXISTS `v_works_service`;
/*!50001 DROP VIEW IF EXISTS `v_works_service`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v_works_service` (
  `id` bigint(20) unsigned,
  `rtype` int(10) unsigned,
  `uid` int(10) unsigned,
  `rtype_name` varchar(200),
  `date_begin` datetime,
  `date_end` datetime,
  `complexity` float unsigned,
  `norma` int(10) unsigned,
  `raw_time` decimal(14,4),
  `wtime` double
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `worker_request`
--

DROP TABLE IF EXISTS `worker_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `worker_request` (
  `request_id` bigint(20) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `date_begin` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`request_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='таблица исполнителей по заявкам';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `v_group`
--

/*!50001 DROP TABLE IF EXISTS `v_group`*/;
/*!50001 DROP VIEW IF EXISTS `v_group`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_group` AS select `group`.`id` AS `gid`,`group`.`groupname` AS `gname`,`user`.`id` AS `uid`,`user`.`name` AS `uname`,(select count(`user_group`.`user_id`) from `user_group` where ((`user_group`.`group_id` = `group`.`id`) and (`user_group`.`user_id` = `user`.`id`))) AS `ingroup` from (`group` join `user`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_notify`
--

/*!50001 DROP TABLE IF EXISTS `v_notify`*/;
/*!50001 DROP VIEW IF EXISTS `v_notify`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`helpdesk`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `v_notify` AS select `n`.`id` AS `id`,`n`.`request_id` AS `request_id`,`tr`.`name` AS `tr_name`,`n`.`delete` AS `delete`,`n`.`message` AS `message`,`u`.`name` AS `u_name`,`u`.`jabber` AS `jabber`,`wr`.`date_begin` AS `date_begin`,`wr`.`date_end` AS `date_end`,`wr`.`comment` AS `comment` from (((`user` `u` join `type_of_request` `tr`) join `request` `r`) join (`notify` `n` left join `worker_request` `wr` on(((`wr`.`request_id` = `n`.`request_id`) and (`wr`.`user_id` = `n`.`user_id`))))) where ((`n`.`user_id` = `u`.`id`) and (`r`.`id` = `n`.`request_id`) and (`r`.`type_request_id` = `tr`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_request`
--

/*!50001 DROP TABLE IF EXISTS `v_request`*/;
/*!50001 DROP VIEW IF EXISTS `v_request`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_request` AS select `rq`.`id` AS `id`,`rq`.`request_datetime` AS `regtime`,`rq`.`department` AS `department`,`rq`.`position` AS `position`,`rq`.`fio` AS `fio`,`rq`.`phone` AS `phone`,`rq`.`pc` AS `pc`,`rq`.`who_ip` AS `ip`,`rq`.`description` AS `description`,`rq`.`closed` AS `closed`,`rq`.`atl_lastdatetime` AS `utime`,`rq`.`atl_lastuser` AS `uuser`,`rt`.`name` AS `rtype`,`rt`.`id` AS `rtype_id`,`rt`.`group_full` AS `group_full`,`rt`.`group_work` AS `group_work`,`rt`.`group_view` AS `group_view`,`rq`.`date_plan` AS `date_plan`,`rq`.`date_end` AS `date_end`,(((`rq`.`date_plan` is not null) and isnull(`rq`.`date_end`) and (`rq`.`date_plan` < now())) or ((`rq`.`date_end` is not null) and (`rq`.`date_plan` < `rq`.`date_end`))) AS `deadline` from (`request` `rq` left join `type_of_request` `rt` on((`rt`.`id` = `rq`.`type_request_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_request_open`
--

/*!50001 DROP TABLE IF EXISTS `v_request_open`*/;
/*!50001 DROP VIEW IF EXISTS `v_request_open`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_request_open` AS select `rq`.`id` AS `id`,`rq`.`request_datetime` AS `regtime`,`rq`.`department` AS `department`,`rq`.`position` AS `position`,`rq`.`fio` AS `fio`,`rq`.`phone` AS `phone`,`rq`.`pc` AS `pc`,`rq`.`who_ip` AS `ip`,`rq`.`description` AS `description`,`rq`.`closed` AS `closed`,`rq`.`atl_lastdatetime` AS `utime`,`rq`.`atl_lastuser` AS `uuser`,`rt`.`name` AS `rtype`,`rt`.`id` AS `rtype_id`,`rt`.`group_full` AS `group_full`,`rt`.`group_work` AS `group_work`,`rt`.`group_view` AS `group_view`,`wk`.`user_id` AS `worker_id`,`rq`.`date_plan` AS `date_plan`,`rq`.`date_end` AS `date_end`,(((`rq`.`date_plan` is not null) and isnull(`rq`.`date_end`) and (`rq`.`date_plan` < now())) or ((`rq`.`date_end` is not null) and (`rq`.`date_plan` < `rq`.`date_end`))) AS `deadline`,(select count(`worker_request`.`user_id`) from `worker_request` where (isnull(`worker_request`.`date_end`) and (`worker_request`.`request_id` = `rq`.`id`))) AS `wcount` from ((`request` `rq` left join `type_of_request` `rt` on((`rt`.`id` = `rq`.`type_request_id`))) left join `worker_request` `wk` on((`wk`.`request_id` = `rq`.`id`))) where (`rq`.`closed` = 0) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_request_work`
--

/*!50001 DROP TABLE IF EXISTS `v_request_work`*/;
/*!50001 DROP VIEW IF EXISTS `v_request_work`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_request_work` AS select `rq`.`id` AS `id`,`rq`.`request_datetime` AS `regtime`,`rq`.`department` AS `department`,`rq`.`position` AS `position`,`rq`.`fio` AS `fio`,`rq`.`phone` AS `phone`,`rq`.`pc` AS `pc`,`rq`.`who_ip` AS `ip`,`rq`.`description` AS `description`,`rq`.`closed` AS `closed`,`rq`.`atl_lastdatetime` AS `utime`,`rq`.`atl_lastuser` AS `uuser`,`rt`.`name` AS `rtype`,`rt`.`id` AS `rtype_id`,`rt`.`group_full` AS `group_full`,`rt`.`group_work` AS `group_work`,`rt`.`group_view` AS `group_view`,`wk`.`user_id` AS `worker_id`,`rq`.`date_plan` AS `date_plan`,`rq`.`date_end` AS `date_end`,(((`rq`.`date_plan` is not null) and isnull(`rq`.`date_end`) and (`rq`.`date_plan` < now())) or ((`rq`.`date_end` is not null) and (`rq`.`date_plan` < `rq`.`date_end`))) AS `deadline` from ((`request` `rq` left join `type_of_request` `rt` on((`rt`.`id` = `rq`.`type_request_id`))) join `worker_request` `wk` on((`wk`.`request_id` = `rq`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_user_group`
--

/*!50001 DROP TABLE IF EXISTS `v_user_group`*/;
/*!50001 DROP VIEW IF EXISTS `v_user_group`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`helpdesk`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `v_user_group` AS select `u`.`id` AS `user_id`,`u`.`login` AS `login`,`u`.`jabber` AS `jabber`,`g`.`id` AS `group_id`,`g`.`groupname` AS `groupname` from ((`user` `u` left join `user_group` `ug` on((`u`.`id` = `ug`.`user_id`))) left join `group` `g` on((`g`.`id` = `ug`.`group_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_worker`
--

/*!50001 DROP TABLE IF EXISTS `v_worker`*/;
/*!50001 DROP VIEW IF EXISTS `v_worker`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_worker` AS select `worker_request`.`request_id` AS `request_id`,`user`.`name` AS `name`,`user`.`id` AS `uid` from (`worker_request` left join `user` on((`user`.`id` = `worker_request`.`user_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_works`
--

/*!50001 DROP TABLE IF EXISTS `v_works`*/;
/*!50001 DROP VIEW IF EXISTS `v_works`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_works` AS select `request`.`id` AS `id`,`request`.`type_request_id` AS `rtype`,`worker_request`.`user_id` AS `uid`,`type_of_request`.`name` AS `rtype_name`,`worker_request`.`date_begin` AS `date_begin`,`worker_request`.`date_end` AS `date_end`,round(((unix_timestamp(`worker_request`.`date_end`) - unix_timestamp(`worker_request`.`date_begin`)) / 60),1) AS `rtime`,if(isnull(`type_of_request`.`norma`),((unix_timestamp(`worker_request`.`date_end`) - unix_timestamp(`worker_request`.`date_begin`)) / 60),if((((unix_timestamp(`worker_request`.`date_end`) - unix_timestamp(`worker_request`.`date_begin`)) / 60) < 1),`type_of_request`.`norma`,if((((unix_timestamp(`worker_request`.`date_end`) - unix_timestamp(`worker_request`.`date_begin`)) / 60) > `type_of_request`.`norma`),if((((unix_timestamp(`worker_request`.`date_end`) - unix_timestamp(`worker_request`.`date_begin`)) / 60) > (`type_of_request`.`norma` * `type_of_request`.`complexity`)),(`type_of_request`.`norma` * `type_of_request`.`complexity`),`type_of_request`.`norma`),((unix_timestamp(`worker_request`.`date_end`) - unix_timestamp(`worker_request`.`date_begin`)) / 60)))) AS `wtime` from ((`request` left join `type_of_request` on((`type_of_request`.`id` = `request`.`type_request_id`))) left join `worker_request` on((`worker_request`.`request_id` = `request`.`id`))) where (`worker_request`.`date_end` is not null) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_works_service`
--

/*!50001 DROP TABLE IF EXISTS `v_works_service`*/;
/*!50001 DROP VIEW IF EXISTS `v_works_service`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_works_service` AS select `request`.`id` AS `id`,`request`.`type_request_id` AS `rtype`,`worker_request`.`user_id` AS `uid`,`type_of_request`.`name` AS `rtype_name`,`worker_request`.`date_begin` AS `date_begin`,`worker_request`.`date_end` AS `date_end`,`type_of_request`.`complexity` AS `complexity`,`type_of_request`.`norma` AS `norma`,((unix_timestamp(`worker_request`.`date_end`) - unix_timestamp(`worker_request`.`date_begin`)) / 60) AS `raw_time`,if(isnull(`type_of_request`.`norma`),((unix_timestamp(`worker_request`.`date_end`) - unix_timestamp(`worker_request`.`date_begin`)) / 60),if((((unix_timestamp(`worker_request`.`date_end`) - unix_timestamp(`worker_request`.`date_begin`)) / 60) < 1),`type_of_request`.`norma`,if((((unix_timestamp(`worker_request`.`date_end`) - unix_timestamp(`worker_request`.`date_begin`)) / 60) > `type_of_request`.`norma`),if((((unix_timestamp(`worker_request`.`date_end`) - unix_timestamp(`worker_request`.`date_begin`)) / 60) > (`type_of_request`.`norma` * `type_of_request`.`complexity`)),(`type_of_request`.`norma` * `type_of_request`.`complexity`),`type_of_request`.`norma`),((unix_timestamp(`worker_request`.`date_end`) - unix_timestamp(`worker_request`.`date_begin`)) / 60)))) AS `wtime` from ((`request` left join `type_of_request` on((`type_of_request`.`id` = `request`.`type_request_id`))) left join `worker_request` on((`worker_request`.`request_id` = `request`.`id`))) where (`worker_request`.`date_end` is not null) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-10-18 14:59:32
