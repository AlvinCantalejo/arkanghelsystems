-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: db_arkanghel_systems
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `as_learner_additional_info`
--

DROP TABLE IF EXISTS `as_learner_additional_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_learner_additional_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_learner_uk` varchar(45) DEFAULT NULL,
  `learner_classification` varchar(45) DEFAULT NULL,
  `type_disability` varchar(45) DEFAULT NULL,
  `causes_disability` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_learner_additional_info`
--

LOCK TABLES `as_learner_additional_info` WRITE;
/*!40000 ALTER TABLE `as_learner_additional_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_learner_additional_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_learner_profile`
--

DROP TABLE IF EXISTS `as_learner_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_learner_profile` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_learner_id` varchar(45) DEFAULT NULL,
  `fk_learner_uk` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `street_number` varchar(45) DEFAULT NULL,
  `barangay` varchar(45) DEFAULT NULL,
  `district` varchar(45) DEFAULT NULL,
  `city_municipality` varchar(45) DEFAULT NULL,
  `province` varchar(45) DEFAULT NULL,
  `region` varchar(45) DEFAULT NULL,
  `email_address` varchar(45) DEFAULT NULL,
  `facebook_account` varchar(45) DEFAULT NULL,
  `contact_number` varchar(45) DEFAULT NULL,
  `nationality` varchar(45) DEFAULT NULL,
  `date_added` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_learner_profile`
--

LOCK TABLES `as_learner_profile` WRITE;
/*!40000 ALTER TABLE `as_learner_profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_learner_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_learner_t2mis`
--

DROP TABLE IF EXISTS `as_learner_t2mis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_learner_t2mis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `learner_uk` varchar(45) DEFAULT NULL,
  `uli_number` varchar(45) DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  `del` int DEFAULT NULL,
  `date_added` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `learner_uk_UNIQUE` (`learner_uk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_learner_t2mis`
--

LOCK TABLES `as_learner_t2mis` WRITE;
/*!40000 ALTER TABLE `as_learner_t2mis` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_learner_t2mis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_personal_information`
--

DROP TABLE IF EXISTS `as_personal_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_personal_information` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fk_learner_uk` varchar(45) DEFAULT NULL,
  `sex` int DEFAULT NULL,
  `civil_status` int DEFAULT NULL,
  `employment_status` int DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `age` int DEFAULT NULL,
  `birthplace_city` varchar(45) DEFAULT NULL,
  `birthplace_province` varchar(45) DEFAULT NULL,
  `birthplace_region` varchar(45) DEFAULT NULL,
  `educational_attainment` varchar(45) DEFAULT NULL,
  `parent_guardian_name` varchar(45) DEFAULT NULL,
  `parent_guardian_address` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_personal_information`
--

LOCK TABLES `as_personal_information` WRITE;
/*!40000 ALTER TABLE `as_personal_information` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_personal_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_user`
--

DROP TABLE IF EXISTS `as_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(45) NOT NULL,
  `email_address` varchar(45) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `role` varchar(45) DEFAULT 'Admin',
  `del` int DEFAULT '0',
  `date_added` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_user`
--

LOCK TABLES `as_user` WRITE;
/*!40000 ALTER TABLE `as_user` DISABLE KEYS */;
INSERT INTO `as_user` VALUES (1,'Alvin Joshua Cantalejo','alvin@testing.com','admin','fc0c830942e9f5ac0937f5f7a0485b67','Admin',0,'2023-01-08 00:48:13');
/*!40000 ALTER TABLE `as_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-08  1:35:16
