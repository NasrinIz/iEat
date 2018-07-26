/*
SQLyog Ultimate
MySQL - 10.2.6-MariaDB : Database - mehranis_ieat
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`mehranis_ieat` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `mehranis_ieat`;

/*Table structure for table `addresses` */

DROP TABLE IF EXISTS `addresses`;

CREATE TABLE `addresses` (
  `AddressID` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerID` int(11) NOT NULL,
  `ProvinceID` int(2) NOT NULL,
  `Address` text DEFAULT NULL,
  `POBox` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`AddressID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `addresses` */

insert  into `addresses`(`AddressID`,`CustomerID`,`ProvinceID`,`Address`,`POBox`) values 
(1,1,1,'1010 Guy','A1B2C3');

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `CustomerID` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(60) DEFAULT NULL,
  `Phone` varchar(10) DEFAULT NULL,
  `Mobile` varchar(10) DEFAULT NULL,
  `Reward` int(1) DEFAULT NULL,
  `UserName` varchar(60) DEFAULT NULL,
  `UserPass` varchar(60) DEFAULT NULL,
  `ActivityStatus` int(1) DEFAULT 1,
  PRIMARY KEY (`CustomerID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `customers` */

insert  into `customers`(`CustomerID`,`FullName`,`Phone`,`Mobile`,`Reward`,`UserName`,`UserPass`,`ActivityStatus`) values 
(1,'Mehran Ishanian','5149296960','5149296960',0,'superadmin','Ad123456',1);

/*Table structure for table `deliverytypes` */

DROP TABLE IF EXISTS `deliverytypes`;

CREATE TABLE `deliverytypes` (
  `DeliveryTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(60) NOT NULL,
  PRIMARY KEY (`DeliveryTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `deliverytypes` */

insert  into `deliverytypes`(`DeliveryTypeID`,`Name`) values 
(1,'PickUp'),
(2,'Cash On Delivery');

/*Table structure for table `employees` */

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `EmployeeID` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(60) NOT NULL,
  `UserName` varchar(20) DEFAULT NULL,
  `UserPass` varchar(20) DEFAULT NULL,
  `Level` int(1) DEFAULT NULL,
  `Phone` varchar(10) DEFAULT NULL,
  `Mobile` varchar(10) DEFAULT NULL,
  `Address` varchar(120) DEFAULT NULL,
  `ProvinceID` int(1) DEFAULT NULL,
  `ZipCode` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `employees` */

insert  into `employees`(`EmployeeID`,`FullName`,`UserName`,`UserPass`,`Level`,`Phone`,`Mobile`,`Address`,`ProvinceID`,`ZipCode`) values 
(1,'Nasreen','nasreen','1234',-2,NULL,NULL,NULL,2,NULL);

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `MenuID` int(3) NOT NULL AUTO_INCREMENT,
  `Name` varchar(60) NOT NULL,
  `Picture` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`MenuID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `menus` */

insert  into `menus`(`MenuID`,`Name`,`Picture`) values 
(1,'Paninis & Wraps','S1-1.jpg'),
(2,'Featured Products','S1-2.jpg'),
(3,'All Sandwiches','S1-3.jpg'),
(4,'8 Under 6','S1-4.jpg'),
(5,'Breakfast','S1-5.jpg'),
(6,'Salads','S1-6.jpg'),
(7,'Sides','S1-7.jpg');

/*Table structure for table `orderdetails` */

DROP TABLE IF EXISTS `orderdetails`;

CREATE TABLE `orderdetails` (
  `OrderDetailID` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL,
  `Quantity` int(2) NOT NULL DEFAULT 1,
  `MenuID` int(3) NOT NULL,
  `SubMenu` int(3) NOT NULL,
  `Price` double(6,2) NOT NULL,
  PRIMARY KEY (`OrderDetailID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `orderdetails` */

insert  into `orderdetails`(`OrderDetailID`,`OrderID`,`Quantity`,`MenuID`,`SubMenu`,`Price`) values 
(1,1,1,1,4,6.00),
(2,1,2,2,10,7.00);

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerID` int(11) DEFAULT NULL,
  `FullName` varchar(60) NOT NULL,
  `ProvinceID` int(1) NOT NULL,
  `Address` text NOT NULL,
  `ZipCode` varchar(6) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Discount` double(5,2) DEFAULT NULL,
  `TotalPrice` double(7,2) NOT NULL,
  `PaymentTypeID` int(1) NOT NULL,
  `DeliveryTypeID` int(1) NOT NULL,
  `Description` text DEFAULT NULL,
  `FeedBack` text DEFAULT NULL,
  `OrderDateTime` datetime NOT NULL,
  PRIMARY KEY (`OrderID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `orders` */

insert  into `orders`(`OrderID`,`CustomerID`,`FullName`,`ProvinceID`,`Address`,`ZipCode`,`Phone`,`Discount`,`TotalPrice`,`PaymentTypeID`,`DeliveryTypeID`,`Description`,`FeedBack`,`OrderDateTime`) values 
(1,1,'Mehran Ishanian',1,'152 Rene Levesque','A1B2C3','+151412345',0.00,50.00,1,2,NULL,NULL,'2018-07-26 00:00:00');

/*Table structure for table `paymenttypes` */

DROP TABLE IF EXISTS `paymenttypes`;

CREATE TABLE `paymenttypes` (
  `PaymentTypeID` int(1) NOT NULL AUTO_INCREMENT,
  `Name` varchar(60) NOT NULL,
  PRIMARY KEY (`PaymentTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `paymenttypes` */

insert  into `paymenttypes`(`PaymentTypeID`,`Name`) values 
(1,'Cash'),
(2,'Credit Card'),
(3,'PayPal');

/*Table structure for table `provinces` */

DROP TABLE IF EXISTS `provinces`;

CREATE TABLE `provinces` (
  `ProvinceID` int(1) NOT NULL AUTO_INCREMENT,
  `Name` varchar(60) NOT NULL,
  PRIMARY KEY (`ProvinceID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `provinces` */

insert  into `provinces`(`ProvinceID`,`Name`) values 
(1,'Quebec'),
(2,'Ontario'),
(3,'Nova Scotia'),
(4,'New Brunswick'),
(5,'Manitoba'),
(6,'British Columbia'),
(7,'Prince Edward Island'),
(8,'Saskatchewan'),
(9,'Alberta'),
(10,'Newfoundland and Labrador');

/*Table structure for table `stores` */

DROP TABLE IF EXISTS `stores`;

CREATE TABLE `stores` (
  `StoreID` int(1) NOT NULL AUTO_INCREMENT,
  `Name` varchar(60) NOT NULL,
  `ProvinceID` int(1) NOT NULL,
  `Address` varchar(60) NOT NULL,
  `ZipCode` varchar(6) NOT NULL,
  PRIMARY KEY (`StoreID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `stores` */

insert  into `stores`(`StoreID`,`Name`,`ProvinceID`,`Address`,`ZipCode`) values 
(1,'Guy',1,'1520 Guy Avenue','H3H23Z'),
(2,'Sherbrook',1,'230 Sherbrook Street','H2H1S1'),
(3,'Rene Levesque',1,'580 Rene Levesque','H4S1S5');

/*Table structure for table `sub_menus` */

DROP TABLE IF EXISTS `sub_menus`;

CREATE TABLE `sub_menus` (
  `SubMenuID` int(3) NOT NULL AUTO_INCREMENT,
  `MenuID` int(3) NOT NULL,
  `Name` varchar(60) DEFAULT NULL,
  `Picture` varchar(60) DEFAULT NULL,
  `Price` double(6,2) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  PRIMARY KEY (`SubMenuID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `sub_menus` */

insert  into `sub_menus`(`SubMenuID`,`MenuID`,`Name`,`Picture`,`Price`,`Description`) values 
(1,1,'Chicken Cordon Bleu Panini','S1-1.jpg',10.00,'Say “Oui” to our Chicken Cordon Bleu Panini, featuring layers of Black Forest ham and 100% Canadian rotisserie-style chicken drizzled with creamy honey mustard, on our Ciabatta bread. Topped with slices of rich Swiss cheese, baby spinach and tomatoes, and pressed to perfection on our Panini grill, it\'s sure to deliver a distinctly crispy and delicious experience.'),
(2,1,'Chipotle Steak and Cheese Panini','S1-2.jpg',12.00,'Our Chipotle Steak & Cheese Panini combines exciting flavours all pressed to crispy perfection on our Panini grill.  Featuring our tender, 100% Canadian steak with cheddar cheese, green peppers and red onions, on our Ciabatta bread, it\'s bursting with flavour and will be sure to deliver a crave-worthy and delicious taste experience.'),
(3,1,'Triple Cheese','S1-3.jpg',11.00,'Satisfy your comfort food cravings with our Triple Grilled Cheese Panini. It’s the classic melty-cheese taste you love, pressed on our Panini grill. We combine cheddar, Swiss and Monterey cheddar cheeses, and load it up with fresh baby spinach, juicy red tomatoes and crunchy red onions on our Ciabatta bread. We then press it to perfection, melding all the flavours together to deliver a warm and crispy grilled cheese experience.'),
(4,1,'B.L.T.','S1-4.jpg',20.00,'Introducing our new grilled wraps! Bacon, lettuce and tomatoes are topped with mayonnaise, wrapped in a flour tortilla, and grilled to tasty B.L.T. perfection.'),
(5,1,'Chicken & Bacon Ranch','S1-5.jpg',10.00,'Filled with 100% Canadian rotisserie-style chicken, Maple wood smoked bacon, Monterey Cheddar cheese rolled in a tortilla and grilled to perfection, the Chicken & Bacon Ranch is the perfect combination of crispy and melty.'),
(6,1,'Chipotle Steak & Bacon','S1-6.jpg',11.00,'The all-new Chipotle Steak & Bacon grilled wrap!  A delight made with 100% Canadian seasoned beef, bacon, Monterey cheddar, topped with creamy Chipotle Southwest sauce, and wrapped in a delicious tortilla that’s grilled to perfection.'),
(7,1,'Chipotle Southwest Steak & Cheese Signature Wrap','S1-7.jpg',6.00,'Saddle up with this delicious tomato basil wrap jam-packed with a double portion of 100% canadian steak and topped with your favorite tex-mex flavors like Monterey cheddar, guacamole, lettuce, tomatoes, red onions, green peppers and Chipotle Southwest sauce.'),
(8,1,'Turkey, Bacon & Guacamole Wrap','S1-8.jpg',8.00,'The name says it all. A delicious Tomato Basil wrap filled with a double portion of 100% canadian turkey breast and Maple wood smoked bacon topped with guacamole, lettuce, tomatoes, red onions, and Ranch.'),
(9,1,'Savoury Chicken Caesar Signature Wrap','S1-9.jpg',9.00,'Who can resist the classic combination of a delicious Spinach wrap filled with a double portion of tender chicken with seasoning and marinade topped with Monterey Cheddar, Parmesan cheese, lettuce, tomatoes and Savory Caesar sauce? It’s fit for an emperor.'),
(10,2,'Chipotle Southwest Steak & Cheese Signature Wrap','S2-1.jpg',7.00,'Saddle up with this delicious tomato basil wrap jam-packed with a double portion of 100% canadian steak and topped with your favorite tex-mex flavors like Monterey cheddar, guacamole, lettuce, tomatoes, red onions, green peppers and Chipotle Southwest sauce.'),
(11,2,'Savoury Chicken Caesar Signature Wrap','S2-2.jpg',12.00,'Who can resist the classic combination of a delicious Spinach wrap filled with a double portion of tender chicken with seasoning and marinade topped with Monterey Cheddar, Parmesan cheese, lettuce, tomatoes and Savory Caesar sauce? It’s fit for an emperor.'),
(12,2,'Turkey, Bacon & Guacamole Wrap','S2-3.jpg',11.00,'The name says it all. A delicious Tomato Basil wrap filled with a double portion of 100% canadian turkey breast and Maple wood smoked bacon topped with guacamole, lettuce, tomatoes, red onions, and Ranch.');

/*Table structure for table `timings` */

DROP TABLE IF EXISTS `timings`;

CREATE TABLE `timings` (
  `StoreID` int(1) NOT NULL,
  `DayoftheWeek` int(1) NOT NULL,
  `OrderTimeFrom` time NOT NULL DEFAULT '09:00:00',
  `OrderTimeTo` time NOT NULL DEFAULT '20:00:00',
  PRIMARY KEY (`StoreID`,`DayoftheWeek`,`OrderTimeFrom`,`OrderTimeTo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `timings` */

insert  into `timings`(`StoreID`,`DayoftheWeek`,`OrderTimeFrom`,`OrderTimeTo`) values 
(1,1,'09:00:00','20:00:00');

/*Table structure for table `userlevelpermissions` */

DROP TABLE IF EXISTS `userlevelpermissions`;

CREATE TABLE `userlevelpermissions` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL,
  PRIMARY KEY (`userlevelid`,`tablename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `userlevelpermissions` */

insert  into `userlevelpermissions`(`userlevelid`,`tablename`,`permission`) values 
(-2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}customers',0),
(-2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}deliverytypes',0),
(-2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}employees',0),
(-2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}menus',0),
(-2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}orderdetails',0),
(-2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}orders',0),
(-2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}paymenttypes',0),
(-2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}provinces',0),
(-2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}stores',0),
(-2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}sub_menus',0),
(-2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}timings',0),
(-2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}userlevelpermissions',0),
(-2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}userlevels',0),
(1,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}customers',104),
(1,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}deliverytypes',104),
(1,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}employees',104),
(1,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}menus',104),
(1,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}orderdetails',104),
(1,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}orders',104),
(1,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}paymenttypes',0),
(1,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}provinces',0),
(1,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}stores',0),
(1,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}sub_menus',104),
(1,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}timings',0),
(1,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}userlevelpermissions',0),
(1,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}userlevels',0),
(2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}customers',111),
(2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}deliverytypes',111),
(2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}employees',111),
(2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}menus',111),
(2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}orderdetails',111),
(2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}orders',111),
(2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}paymenttypes',111),
(2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}provinces',111),
(2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}stores',111),
(2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}sub_menus',111),
(2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}timings',111),
(2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}userlevelpermissions',111),
(2,'{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}userlevels',111);

/*Table structure for table `userlevels` */

DROP TABLE IF EXISTS `userlevels`;

CREATE TABLE `userlevels` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(80) NOT NULL,
  PRIMARY KEY (`userlevelid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `userlevels` */

insert  into `userlevels`(`userlevelid`,`userlevelname`) values 
(-2,'Anonymous'),
(-1,'Administrator'),
(0,'Default'),
(1,'Employee'),
(2,'Manager');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
