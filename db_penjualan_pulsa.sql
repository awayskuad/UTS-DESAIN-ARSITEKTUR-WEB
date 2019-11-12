/*
SQLyog Ultimate - MySQL GUI v8.2 
MySQL - 5.5.5-10.1.37-MariaDB : Database - db_penjualan_pulsa
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_penjualan_pulsa` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_penjualan_pulsa`;

/*Table structure for table `tbl_pelanggan` */

DROP TABLE IF EXISTS `tbl_pelanggan`;

CREATE TABLE `tbl_pelanggan` (
  `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_pelanggan` */

insert  into `tbl_pelanggan`(`id_pelanggan`,`nama`,`no_hp`) values (3,'agus S','087726026878'),(4,'agus','0877260268781'),(5,'agus','0877260268781'),(7,'anwar','0852234457772'),(8,'anwar','0852234457772');

/*Table structure for table `tbl_penjualan` */

DROP TABLE IF EXISTS `tbl_penjualan`;

CREATE TABLE `tbl_penjualan` (
  `id_penjualan` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `pelanggan` int(11) NOT NULL,
  `pulsa` int(11) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  PRIMARY KEY (`id_penjualan`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_penjualan` */

insert  into `tbl_penjualan`(`id_penjualan`,`tanggal`,`pelanggan`,`pulsa`,`jumlah_bayar`) values (1,'2019-10-31',7,1,7000),(2,'2019-11-01',7,1,7000);

/*Table structure for table `tbl_pulsa` */

DROP TABLE IF EXISTS `tbl_pulsa`;

CREATE TABLE `tbl_pulsa` (
  `id_pulsa` int(11) NOT NULL AUTO_INCREMENT,
  `provider` varchar(15) NOT NULL,
  `nominal` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  PRIMARY KEY (`id_pulsa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_pulsa` */

insert  into `tbl_pulsa`(`id_pulsa`,`provider`,`nominal`,`harga`) values (1,'TELKOMSEL',5000,7000),(2,'TELKOMSEL',5000,7000);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
