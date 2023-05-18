/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 10.4.24-MariaDB : Database - aksara_diskret
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`aksara_diskret` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `aksara_diskret`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `admin` */

LOCK TABLES `admin` WRITE;

insert  into `admin`(`id`,`email`,`password`) values 
(1,'adminprivilege@mail.com','$2a$12$2b8uiUy9MaEC58WX7Bv6Xu37soPa7ZkhFhGOfSVjRZLqFOtG33Q8e');

UNLOCK TABLES;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `users` */

LOCK TABLES `users` WRITE;

insert  into `users`(`id`,`first_name`,`last_name`,`email`,`password`) values 
(1,'farhan','sunge','farhanSunge12@gmail.com','$2y$10$iHSzgvVamjUawkdwzSe9uexDYMfXdwiOnpLJiwzQGCj.OGI2RZyL2'),
(5,'Haikal','Takapesi','Haikal123@gmail.com','$2y$10$RxVk61DkvW8YB8n1QZTEb.sJ0QSQjgdeGj5KMKIj/e/.wa6.T2wWS'),
(7,'rizky','saria','mrizkisaria002@gmail.com','$2y$10$vkosR2Z0GNrpW3dWcoZcOetI/eYZo0GzPxsZSAIxJTB9KOuELntoC');

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
