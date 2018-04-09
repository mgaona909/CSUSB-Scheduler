-- MySQL dump 10.13  Distrib 5.5.54, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: b18_20197884_csusb
-- ------------------------------------------------------
-- Server version	5.5.54-0ubuntu0.14.04.1

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
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `classID` int(11) NOT NULL AUTO_INCREMENT,
  `facultyid` varchar(500) NOT NULL,
  `department` varchar(20) NOT NULL,
  `course` varchar(20) NOT NULL,
  `instructor` varchar(50) NOT NULL,
  `session` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`classID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (6,'117810802876925190091','CSE','455-01','Scott Raymond','Summer 2017'),(7,'117810802876925190091','ART','322','Scott Raymond','Summer 2017'),(8,'117810802876925190091','ENG','306','Scott Raymond','Summer 2017');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrollment`
--

DROP TABLE IF EXISTS `enrollment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enrollment` (
  `studentid` varchar(500) NOT NULL,
  `classID` int(11) DEFAULT NULL,
  KEY `classID` (`classID`),
  KEY `studentid` (`studentid`),
  CONSTRAINT `enrollment_ibfk_1` FOREIGN KEY (`classID`) REFERENCES `classes` (`classID`),
  CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`studentid`) REFERENCES `googleUsers` (`googleID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrollment`
--

LOCK TABLES `enrollment` WRITE;
/*!40000 ALTER TABLE `enrollment` DISABLE KEYS */;
INSERT INTO `enrollment` VALUES ('115588004099358144340',6),('115588004099358144340',7);
/*!40000 ALTER TABLE `enrollment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `eventID` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(500) NOT NULL,
  `title` varchar(255) NOT NULL,
  `eventType` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  PRIMARY KEY (`eventID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (8,'117810802876925190091','Event for CSE 455','Homework','Test event','#0071c5','6','2017-06-12 00:00:00','2017-06-13 00:00:00'),(9,'117810802876925190091','Event 2','Project','Test2','#008000','6','2017-06-14 00:00:00','2017-06-15 00:00:00'),(10,'115588004099358144340','Event 2','Project','Test2','#008000',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(11,'115588004099358144340','Event for CSE 455','Homework','Test event','#0071c5',NULL,'2017-06-12 00:00:00','2017-06-13 00:00:00'),(13,'117810802876925190091','Exam test','Exam','test1','#0071c5',NULL,'2017-06-13 00:00:00','2017-06-14 00:00:00'),(14,'117810802876925190091','Homework test','Homework','testtest','#0071c5',NULL,'2017-06-12 00:00:00','2017-06-13 00:00:00'),(15,'117810802876925190091','Project test','Project','test','#0071c5',NULL,'2017-06-14 00:00:00','2017-06-15 00:00:00'),(16,'117810802876925190091','Quiz test','Quiz','test','#0071c5',NULL,'2017-06-15 00:00:00','2017-06-16 00:00:00'),(17,'117810802876925190091','Reminder test','Reminder','test','#0071c5',NULL,'2017-06-16 00:00:00','2017-06-17 00:00:00'),(19,'105188458492530773254','Math Exam1','Exam','Exam for math','#0071c5',NULL,'2017-06-14 00:00:00','2017-06-15 00:00:00');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `googleUsers`
--

DROP TABLE IF EXISTS `googleUsers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `googleUsers` (
  `googleID` varchar(500) NOT NULL,
  `fname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `account` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`googleID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `googleUsers`
--

LOCK TABLES `googleUsers` WRITE;
/*!40000 ALTER TABLE `googleUsers` DISABLE KEYS */;
INSERT INTO `googleUsers` VALUES ('105188458492530773254','Miguel','Gaona','004352152@coyote.csusb.edu','Student'),('108625779049954301791','Miguel','Gaona','mgaona909@gmail.com','Faculty'),('115588004099358144340','Scott','Raymond','005199476@coyote.csusb.edu','Student'),('117810802876925190091','Scott','Raymond','codemonkey552@gmail.com','Faculty');
/*!40000 ALTER TABLE `googleUsers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-18 19:03:51
