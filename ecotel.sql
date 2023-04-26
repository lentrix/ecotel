-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: ecotel
-- ------------------------------------------------------
-- Server version	10.4.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `addons`
--

DROP TABLE IF EXISTS `addons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `addon_type` varchar(255) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addons`
--

LOCK TABLES `addons` WRITE;
/*!40000 ALTER TABLE `addons` DISABLE KEYS */;
INSERT INTO `addons` VALUES (1,'Breakfast Package 1','Fried Rice with sunny side up Egg and Carne Norte','food',300.00,'2023-04-21 22:40:39','2023-04-21 22:40:39'),(2,'Campuccino Coffee','Filipino style Campuccino Coffe','beverage',150.00,'2023-04-21 22:41:09','2023-04-21 22:41:09'),(3,'Others','Custom Addon','others',0.00,NULL,NULL);
/*!40000 ALTER TABLE `addons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `booking_addons`
--

DROP TABLE IF EXISTS `booking_addons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking_addons` (
  `booking_id` bigint(20) unsigned NOT NULL,
  `addon_id` bigint(20) unsigned NOT NULL,
  `qty` int(10) unsigned NOT NULL DEFAULT 1,
  `amount` decimal(8,2) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `added_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`booking_id`,`addon_id`),
  KEY `booking_addons_added_by_foreign` (`added_by`),
  KEY `booking_addons_addon_id_foreign` (`addon_id`),
  CONSTRAINT `booking_addons_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  CONSTRAINT `booking_addons_addon_id_foreign` FOREIGN KEY (`addon_id`) REFERENCES `addons` (`id`),
  CONSTRAINT `booking_addons_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_addons`
--

LOCK TABLES `booking_addons` WRITE;
/*!40000 ALTER TABLE `booking_addons` DISABLE KEYS */;
INSERT INTO `booking_addons` VALUES (7,1,1,300.00,NULL,1,'2023-04-24 05:42:39','2023-04-24 05:42:39'),(7,3,1,350.00,'Additional Pax',1,'2023-04-24 05:44:21','2023-04-24 05:44:21');
/*!40000 ALTER TABLE `booking_addons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `booking_guests`
--

DROP TABLE IF EXISTS `booking_guests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking_guests` (
  `guest_id` bigint(20) unsigned NOT NULL,
  `booking_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`guest_id`,`booking_id`),
  KEY `booking_guests_booking_id_foreign` (`booking_id`),
  CONSTRAINT `booking_guests_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  CONSTRAINT `booking_guests_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_guests`
--

LOCK TABLES `booking_guests` WRITE;
/*!40000 ALTER TABLE `booking_guests` DISABLE KEYS */;
INSERT INTO `booking_guests` VALUES (37,7,'2023-04-24 04:41:26','2023-04-24 04:41:26');
/*!40000 ALTER TABLE `booking_guests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `check_in` datetime NOT NULL,
  `check_out` datetime NOT NULL,
  `room_id` bigint(20) unsigned NOT NULL,
  `room_rate` decimal(8,2) NOT NULL,
  `added_by` bigint(20) unsigned NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `down_payment` decimal(8,2) NOT NULL DEFAULT 0.00,
  `payment_mode` varchar(255) DEFAULT NULL,
  `source` varchar(255) NOT NULL DEFAULT 'Walk-in',
  `with_breakfast` tinyint(1) NOT NULL DEFAULT 0,
  `purpose` varchar(255) NOT NULL,
  `discount_remarks` varchar(255) DEFAULT NULL,
  `discount_amount` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cc_surcharge_percent` decimal(4,2) DEFAULT NULL,
  `cc_surcharge_portion` varchar(255) DEFAULT NULL,
  `vat` decimal(8,2) NOT NULL DEFAULT 0.00,
  `final_payment` decimal(10,2) DEFAULT NULL,
  `final_pmt_mode` varchar(255) DEFAULT NULL,
  `checkout_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bookings_added_by_foreign` (`added_by`),
  KEY `bookings_room_id_foreign` (`room_id`),
  CONSTRAINT `bookings_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES (7,'2023-04-28 00:00:00','2023-04-29 00:00:00',1,800.00,1,'confirmed by lentrix',0.00,'Cash','Walk-in',0,'Leisure/Vacation',NULL,NULL,'2023-04-24 04:41:26','2023-04-24 05:55:06',NULL,NULL,0.00,NULL,NULL,NULL);
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=240 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'AF','AFGHANISTAN','Afghanistan','AFG',4,93),(2,'AL','ALBANIA','Albania','ALB',8,355),(3,'DZ','ALGERIA','Algeria','DZA',12,213),(4,'AS','AMERICAN SAMOA','American Samoa','ASM',16,1684),(5,'AD','ANDORRA','Andorra','AND',20,376),(6,'AO','ANGOLA','Angola','AGO',24,244),(7,'AI','ANGUILLA','Anguilla','AIA',660,1264),(8,'AQ','ANTARCTICA','Antarctica',NULL,NULL,0),(9,'AG','ANTIGUA AND BARBUDA','Antigua and Barbuda','ATG',28,1268),(10,'AR','ARGENTINA','Argentina','ARG',32,54),(11,'AM','ARMENIA','Armenia','ARM',51,374),(12,'AW','ARUBA','Aruba','ABW',533,297),(13,'AU','AUSTRALIA','Australia','AUS',36,61),(14,'AT','AUSTRIA','Austria','AUT',40,43),(15,'AZ','AZERBAIJAN','Azerbaijan','AZE',31,994),(16,'BS','BAHAMAS','Bahamas','BHS',44,1242),(17,'BH','BAHRAIN','Bahrain','BHR',48,973),(18,'BD','BANGLADESH','Bangladesh','BGD',50,880),(19,'BB','BARBADOS','Barbados','BRB',52,1246),(20,'BY','BELARUS','Belarus','BLR',112,375),(21,'BE','BELGIUM','Belgium','BEL',56,32),(22,'BZ','BELIZE','Belize','BLZ',84,501),(23,'BJ','BENIN','Benin','BEN',204,229),(24,'BM','BERMUDA','Bermuda','BMU',60,1441),(25,'BT','BHUTAN','Bhutan','BTN',64,975),(26,'BO','BOLIVIA','Bolivia','BOL',68,591),(27,'BA','BOSNIA AND HERZEGOVINA','Bosnia and Herzegovina','BIH',70,387),(28,'BW','BOTSWANA','Botswana','BWA',72,267),(29,'BV','BOUVET ISLAND','Bouvet Island',NULL,NULL,0),(30,'BR','BRAZIL','Brazil','BRA',76,55),(31,'IO','BRITISH INDIAN OCEAN TERRITORY','British Indian Ocean Territory',NULL,NULL,246),(32,'BN','BRUNEI DARUSSALAM','Brunei Darussalam','BRN',96,673),(33,'BG','BULGARIA','Bulgaria','BGR',100,359),(34,'BF','BURKINA FASO','Burkina Faso','BFA',854,226),(35,'BI','BURUNDI','Burundi','BDI',108,257),(36,'KH','CAMBODIA','Cambodia','KHM',116,855),(37,'CM','CAMEROON','Cameroon','CMR',120,237),(38,'CA','CANADA','Canada','CAN',124,1),(39,'CV','CAPE VERDE','Cape Verde','CPV',132,238),(40,'KY','CAYMAN ISLANDS','Cayman Islands','CYM',136,1345),(41,'CF','CENTRAL AFRICAN REPUBLIC','Central African Republic','CAF',140,236),(42,'TD','CHAD','Chad','TCD',148,235),(43,'CL','CHILE','Chile','CHL',152,56),(44,'CN','CHINA','China','CHN',156,86),(45,'CX','CHRISTMAS ISLAND','Christmas Island',NULL,NULL,61),(46,'CC','COCOS (KEELING) ISLANDS','Cocos (Keeling) Islands',NULL,NULL,672),(47,'CO','COLOMBIA','Colombia','COL',170,57),(48,'KM','COMOROS','Comoros','COM',174,269),(49,'CG','CONGO','Congo','COG',178,242),(50,'CD','CONGO, THE DEMOCRATIC REPUBLIC OF THE','Congo, the Democratic Republic of the','COD',180,242),(51,'CK','COOK ISLANDS','Cook Islands','COK',184,682),(52,'CR','COSTA RICA','Costa Rica','CRI',188,506),(53,'CI','COTE D\'IVOIRE','Cote D\'Ivoire','CIV',384,225),(54,'HR','CROATIA','Croatia','HRV',191,385),(55,'CU','CUBA','Cuba','CUB',192,53),(56,'CY','CYPRUS','Cyprus','CYP',196,357),(57,'CZ','CZECH REPUBLIC','Czech Republic','CZE',203,420),(58,'DK','DENMARK','Denmark','DNK',208,45),(59,'DJ','DJIBOUTI','Djibouti','DJI',262,253),(60,'DM','DOMINICA','Dominica','DMA',212,1767),(61,'DO','DOMINICAN REPUBLIC','Dominican Republic','DOM',214,1809),(62,'EC','ECUADOR','Ecuador','ECU',218,593),(63,'EG','EGYPT','Egypt','EGY',818,20),(64,'SV','EL SALVADOR','El Salvador','SLV',222,503),(65,'GQ','EQUATORIAL GUINEA','Equatorial Guinea','GNQ',226,240),(66,'ER','ERITREA','Eritrea','ERI',232,291),(67,'EE','ESTONIA','Estonia','EST',233,372),(68,'ET','ETHIOPIA','Ethiopia','ETH',231,251),(69,'FK','FALKLAND ISLANDS (MALVINAS)','Falkland Islands (Malvinas)','FLK',238,500),(70,'FO','FAROE ISLANDS','Faroe Islands','FRO',234,298),(71,'FJ','FIJI','Fiji','FJI',242,679),(72,'FI','FINLAND','Finland','FIN',246,358),(73,'FR','FRANCE','France','FRA',250,33),(74,'GF','FRENCH GUIANA','French Guiana','GUF',254,594),(75,'PF','FRENCH POLYNESIA','French Polynesia','PYF',258,689),(76,'TF','FRENCH SOUTHERN TERRITORIES','French Southern Territories',NULL,NULL,0),(77,'GA','GABON','Gabon','GAB',266,241),(78,'GM','GAMBIA','Gambia','GMB',270,220),(79,'GE','GEORGIA','Georgia','GEO',268,995),(80,'DE','GERMANY','Germany','DEU',276,49),(81,'GH','GHANA','Ghana','GHA',288,233),(82,'GI','GIBRALTAR','Gibraltar','GIB',292,350),(83,'GR','GREECE','Greece','GRC',300,30),(84,'GL','GREENLAND','Greenland','GRL',304,299),(85,'GD','GRENADA','Grenada','GRD',308,1473),(86,'GP','GUADELOUPE','Guadeloupe','GLP',312,590),(87,'GU','GUAM','Guam','GUM',316,1671),(88,'GT','GUATEMALA','Guatemala','GTM',320,502),(89,'GN','GUINEA','Guinea','GIN',324,224),(90,'GW','GUINEA-BISSAU','Guinea-Bissau','GNB',624,245),(91,'GY','GUYANA','Guyana','GUY',328,592),(92,'HT','HAITI','Haiti','HTI',332,509),(93,'HM','HEARD ISLAND AND MCDONALD ISLANDS','Heard Island and Mcdonald Islands',NULL,NULL,0),(94,'VA','HOLY SEE (VATICAN CITY STATE)','Holy See (Vatican City State)','VAT',336,39),(95,'HN','HONDURAS','Honduras','HND',340,504),(96,'HK','HONG KONG','Hong Kong','HKG',344,852),(97,'HU','HUNGARY','Hungary','HUN',348,36),(98,'IS','ICELAND','Iceland','ISL',352,354),(99,'IN','INDIA','India','IND',356,91),(100,'ID','INDONESIA','Indonesia','IDN',360,62),(101,'IR','IRAN, ISLAMIC REPUBLIC OF','Iran, Islamic Republic of','IRN',364,98),(102,'IQ','IRAQ','Iraq','IRQ',368,964),(103,'IE','IRELAND','Ireland','IRL',372,353),(104,'IL','ISRAEL','Israel','ISR',376,972),(105,'IT','ITALY','Italy','ITA',380,39),(106,'JM','JAMAICA','Jamaica','JAM',388,1876),(107,'JP','JAPAN','Japan','JPN',392,81),(108,'JO','JORDAN','Jordan','JOR',400,962),(109,'KZ','KAZAKHSTAN','Kazakhstan','KAZ',398,7),(110,'KE','KENYA','Kenya','KEN',404,254),(111,'KI','KIRIBATI','Kiribati','KIR',296,686),(112,'KP','KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF','Korea, Democratic People\'s Republic of','PRK',408,850),(113,'KR','KOREA, REPUBLIC OF','Korea, Republic of','KOR',410,82),(114,'KW','KUWAIT','Kuwait','KWT',414,965),(115,'KG','KYRGYZSTAN','Kyrgyzstan','KGZ',417,996),(116,'LA','LAO PEOPLE\'S DEMOCRATIC REPUBLIC','Lao People\'s Democratic Republic','LAO',418,856),(117,'LV','LATVIA','Latvia','LVA',428,371),(118,'LB','LEBANON','Lebanon','LBN',422,961),(119,'LS','LESOTHO','Lesotho','LSO',426,266),(120,'LR','LIBERIA','Liberia','LBR',430,231),(121,'LY','LIBYAN ARAB JAMAHIRIYA','Libyan Arab Jamahiriya','LBY',434,218),(122,'LI','LIECHTENSTEIN','Liechtenstein','LIE',438,423),(123,'LT','LITHUANIA','Lithuania','LTU',440,370),(124,'LU','LUXEMBOURG','Luxembourg','LUX',442,352),(125,'MO','MACAO','Macao','MAC',446,853),(126,'MK','MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','Macedonia, the Former Yugoslav Republic of','MKD',807,389),(127,'MG','MADAGASCAR','Madagascar','MDG',450,261),(128,'MW','MALAWI','Malawi','MWI',454,265),(129,'MY','MALAYSIA','Malaysia','MYS',458,60),(130,'MV','MALDIVES','Maldives','MDV',462,960),(131,'ML','MALI','Mali','MLI',466,223),(132,'MT','MALTA','Malta','MLT',470,356),(133,'MH','MARSHALL ISLANDS','Marshall Islands','MHL',584,692),(134,'MQ','MARTINIQUE','Martinique','MTQ',474,596),(135,'MR','MAURITANIA','Mauritania','MRT',478,222),(136,'MU','MAURITIUS','Mauritius','MUS',480,230),(137,'YT','MAYOTTE','Mayotte',NULL,NULL,269),(138,'MX','MEXICO','Mexico','MEX',484,52),(139,'FM','MICRONESIA, FEDERATED STATES OF','Micronesia, Federated States of','FSM',583,691),(140,'MD','MOLDOVA, REPUBLIC OF','Moldova, Republic of','MDA',498,373),(141,'MC','MONACO','Monaco','MCO',492,377),(142,'MN','MONGOLIA','Mongolia','MNG',496,976),(143,'MS','MONTSERRAT','Montserrat','MSR',500,1664),(144,'MA','MOROCCO','Morocco','MAR',504,212),(145,'MZ','MOZAMBIQUE','Mozambique','MOZ',508,258),(146,'MM','MYANMAR','Myanmar','MMR',104,95),(147,'NA','NAMIBIA','Namibia','NAM',516,264),(148,'NR','NAURU','Nauru','NRU',520,674),(149,'NP','NEPAL','Nepal','NPL',524,977),(150,'NL','NETHERLANDS','Netherlands','NLD',528,31),(151,'AN','NETHERLANDS ANTILLES','Netherlands Antilles','ANT',530,599),(152,'NC','NEW CALEDONIA','New Caledonia','NCL',540,687),(153,'NZ','NEW ZEALAND','New Zealand','NZL',554,64),(154,'NI','NICARAGUA','Nicaragua','NIC',558,505),(155,'NE','NIGER','Niger','NER',562,227),(156,'NG','NIGERIA','Nigeria','NGA',566,234),(157,'NU','NIUE','Niue','NIU',570,683),(158,'NF','NORFOLK ISLAND','Norfolk Island','NFK',574,672),(159,'MP','NORTHERN MARIANA ISLANDS','Northern Mariana Islands','MNP',580,1670),(160,'NO','NORWAY','Norway','NOR',578,47),(161,'OM','OMAN','Oman','OMN',512,968),(162,'PK','PAKISTAN','Pakistan','PAK',586,92),(163,'PW','PALAU','Palau','PLW',585,680),(164,'PS','PALESTINIAN TERRITORY, OCCUPIED','Palestinian Territory, Occupied',NULL,NULL,970),(165,'PA','PANAMA','Panama','PAN',591,507),(166,'PG','PAPUA NEW GUINEA','Papua New Guinea','PNG',598,675),(167,'PY','PARAGUAY','Paraguay','PRY',600,595),(168,'PE','PERU','Peru','PER',604,51),(169,'PH','PHILIPPINES','Philippines','PHL',608,63),(170,'PN','PITCAIRN','Pitcairn','PCN',612,0),(171,'PL','POLAND','Poland','POL',616,48),(172,'PT','PORTUGAL','Portugal','PRT',620,351),(173,'PR','PUERTO RICO','Puerto Rico','PRI',630,1787),(174,'QA','QATAR','Qatar','QAT',634,974),(175,'RE','REUNION','Reunion','REU',638,262),(176,'RO','ROMANIA','Romania','ROM',642,40),(177,'RU','RUSSIAN FEDERATION','Russian Federation','RUS',643,70),(178,'RW','RWANDA','Rwanda','RWA',646,250),(179,'SH','SAINT HELENA','Saint Helena','SHN',654,290),(180,'KN','SAINT KITTS AND NEVIS','Saint Kitts and Nevis','KNA',659,1869),(181,'LC','SAINT LUCIA','Saint Lucia','LCA',662,1758),(182,'PM','SAINT PIERRE AND MIQUELON','Saint Pierre and Miquelon','SPM',666,508),(183,'VC','SAINT VINCENT AND THE GRENADINES','Saint Vincent and the Grenadines','VCT',670,1784),(184,'WS','SAMOA','Samoa','WSM',882,684),(185,'SM','SAN MARINO','San Marino','SMR',674,378),(186,'ST','SAO TOME AND PRINCIPE','Sao Tome and Principe','STP',678,239),(187,'SA','SAUDI ARABIA','Saudi Arabia','SAU',682,966),(188,'SN','SENEGAL','Senegal','SEN',686,221),(189,'CS','SERBIA AND MONTENEGRO','Serbia and Montenegro',NULL,NULL,381),(190,'SC','SEYCHELLES','Seychelles','SYC',690,248),(191,'SL','SIERRA LEONE','Sierra Leone','SLE',694,232),(192,'SG','SINGAPORE','Singapore','SGP',702,65),(193,'SK','SLOVAKIA','Slovakia','SVK',703,421),(194,'SI','SLOVENIA','Slovenia','SVN',705,386),(195,'SB','SOLOMON ISLANDS','Solomon Islands','SLB',90,677),(196,'SO','SOMALIA','Somalia','SOM',706,252),(197,'ZA','SOUTH AFRICA','South Africa','ZAF',710,27),(198,'GS','SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS','South Georgia and the South Sandwich Islands',NULL,NULL,0),(199,'ES','SPAIN','Spain','ESP',724,34),(200,'LK','SRI LANKA','Sri Lanka','LKA',144,94),(201,'SD','SUDAN','Sudan','SDN',736,249),(202,'SR','SURINAME','Suriname','SUR',740,597),(203,'SJ','SVALBARD AND JAN MAYEN','Svalbard and Jan Mayen','SJM',744,47),(204,'SZ','SWAZILAND','Swaziland','SWZ',748,268),(205,'SE','SWEDEN','Sweden','SWE',752,46),(206,'CH','SWITZERLAND','Switzerland','CHE',756,41),(207,'SY','SYRIAN ARAB REPUBLIC','Syrian Arab Republic','SYR',760,963),(208,'TW','TAIWAN, PROVINCE OF CHINA','Taiwan, Province of China','TWN',158,886),(209,'TJ','TAJIKISTAN','Tajikistan','TJK',762,992),(210,'TZ','TANZANIA, UNITED REPUBLIC OF','Tanzania, United Republic of','TZA',834,255),(211,'TH','THAILAND','Thailand','THA',764,66),(212,'TL','TIMOR-LESTE','Timor-Leste',NULL,NULL,670),(213,'TG','TOGO','Togo','TGO',768,228),(214,'TK','TOKELAU','Tokelau','TKL',772,690),(215,'TO','TONGA','Tonga','TON',776,676),(216,'TT','TRINIDAD AND TOBAGO','Trinidad and Tobago','TTO',780,1868),(217,'TN','TUNISIA','Tunisia','TUN',788,216),(218,'TR','TURKEY','Turkey','TUR',792,90),(219,'TM','TURKMENISTAN','Turkmenistan','TKM',795,7370),(220,'TC','TURKS AND CAICOS ISLANDS','Turks and Caicos Islands','TCA',796,1649),(221,'TV','TUVALU','Tuvalu','TUV',798,688),(222,'UG','UGANDA','Uganda','UGA',800,256),(223,'UA','UKRAINE','Ukraine','UKR',804,380),(224,'AE','UNITED ARAB EMIRATES','United Arab Emirates','ARE',784,971),(225,'GB','UNITED KINGDOM','United Kingdom','GBR',826,44),(226,'US','UNITED STATES','United States','USA',840,1),(227,'UM','UNITED STATES MINOR OUTLYING ISLANDS','United States Minor Outlying Islands',NULL,NULL,1),(228,'UY','URUGUAY','Uruguay','URY',858,598),(229,'UZ','UZBEKISTAN','Uzbekistan','UZB',860,998),(230,'VU','VANUATU','Vanuatu','VUT',548,678),(231,'VE','VENEZUELA','Venezuela','VEN',862,58),(232,'VN','VIET NAM','Viet Nam','VNM',704,84),(233,'VG','VIRGIN ISLANDS, BRITISH','Virgin Islands, British','VGB',92,1284),(234,'VI','VIRGIN ISLANDS, U.S.','Virgin Islands, U.s.','VIR',850,1340),(235,'WF','WALLIS AND FUTUNA','Wallis and Futuna','WLF',876,681),(236,'EH','WESTERN SAHARA','Western Sahara','ESH',732,212),(237,'YE','YEMEN','Yemen','YEM',887,967),(238,'ZM','ZAMBIA','Zambia','ZMB',894,260),(239,'ZW','ZIMBABWE','Zimbabwe','ZWE',716,263);
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guests`
--

DROP TABLE IF EXISTS `guests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `guests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `idno` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `company_tin` varchar(255) DEFAULT NULL,
  `ofw` tinyint(1) NOT NULL DEFAULT 0,
  `added_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guests_added_by_foreign` (`added_by`),
  CONSTRAINT `guests_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guests`
--

LOCK TABLES `guests` WRITE;
/*!40000 ALTER TABLE `guests` DISABLE KEYS */;
INSERT INTO `guests` VALUES (1,'Von','Amira','Cummerata','9127 Leopold Crescent Apt. 977\nHarrisborough, RI 34806-5572','Serbia','+1.251.947.9837','4-3832-216','durgan.brian@example.com','Dicki Inc','80166 Luna Greens\nNaomieside, CA 66356-4326','412-127-671',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(2,'Ankunding','Gilberto','Mante','6577 Nicolas Lake Apt. 831\nWest Tyshawn, WA 35334-6661','Jamaica','+1-650-998-3611','3-9257-584','hauck.scotty@example.net','Mohr, Lebsack and Walter','695 Rosenbaum Land Suite 357\nEast Adeleshire, OR 91586','143-602-051',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(3,'Wisoky','Raymond','Homenick','5889 Alvena Mountain\nNew Anika, HI 54654','Tuvalu','+12487867769','4-0021-428','otis.heaney@example.net','Borer-Ziemann','7610 Eleanora Drives\nAlbertoburgh, NY 07953-9495','879-349-710',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(4,'Hessel','Waldo','Bins','21967 Kertzmann Estate Apt. 672\nNorth Tom, MD 86849-1026','Lebanon','351-902-3558','1-9845-345','brakus.lulu@example.net','Streich, Weissnat and Schuppe','3831 Clyde Summit\nOdaburgh, DC 41220','370-061-390',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(5,'O\'Conner','Fern','Metz','995 Joy Field\nSouth Hester, ND 30560-2119','Armenia','+1-678-487-1104','7-9190-936','rolfson.jarred@example.net','Konopelski PLC','4483 Dolores Fields Suite 231\nNorth Dylanmouth, NM 95068-3626','549-088-024',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(6,'Yost','Ellie','Upton','1987 Cronin Tunnel\nRunteshire, HI 84260-5128','Japan','920.967.3226','7-6484-833','kaya89@example.net','Nader-Smith','3567 Merritt Stravenue Suite 068\nBradyfurt, KY 11842-2221','542-094-499',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(7,'Stroman','Leta','Sanford','740 Colleen Ridges\nLake Rhianna, AK 39740-2000','Italy','531.221.4276','8-6602-444','lbogisich@example.com','Green, Lueilwitz and Wunsch','629 Graham Turnpike\nPort Greggland, AR 74431','931-862-439',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(8,'Halvorson','Florine','Flatley','90115 Trantow Walk\nKozeyfurt, CO 01353-4884','Burundi','325-907-1036','1-0498-568','sawayn.manuela@example.org','Upton-Stanton','44926 Arely Via Apt. 742\nEast Colleen, IL 11754','039-928-582',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(9,'Armstrong','Oscar','Simonis','2431 Yost Square Suite 128\nCorkeryfort, AZ 21737','Saint Martin','720-648-6596','3-0319-017','cpredovic@example.com','Jaskolski-Schinner','59180 O\'Reilly Branch Apt. 763\nBarrowsfort, OR 85026-2813','208-051-860',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(10,'Towne','Frankie','Glover','667 Julia Inlet Suite 788\nWilkinsonbury, WY 09467-6602','Pitcairn Islands','260-565-0131','8-3586-523','irving63@example.org','Ledner, Labadie and Abernathy','571 Josefa Villages\nNew Isobel, NE 94951-9376','258-983-696',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(11,'Johnston','Kaleb','Veum','29993 Onie Coves\nOttilieton, SC 56379','Guernsey','+1-775-353-2909','1-9253-735','dibbert.keeley@example.com','Feil-Heidenreich','5004 Ward Manor Apt. 618\nHermannville, WY 69530','851-205-371',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(12,'Swaniawski','Alexandria','Thiel','81652 Theo Fall Apt. 869\nJoesphhaven, MA 19632-9895','Estonia','+1.562.438.4777','7-6998-478','amya.friesen@example.net','Glover-Schmidt','4879 Green Mission Suite 770\nSouth Pearl, AZ 63705','763-171-471',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(13,'Lowe','Donavon','Smitham','21482 Roel Divide\nShaniyafurt, MN 49771','Uzbekistan','(860) 941-4332','2-8261-919','braeden58@example.org','Stehr-Collins','44693 Braeden Turnpike\nEllieburgh, OK 81359','075-902-319',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(14,'Beahan','Gregg','Skiles','1415 Sedrick Extension\nLarkinberg, ID 77907-0513','Bouvet Island (Bouvetoya)','+1 (430) 447-1389','3-0642-189','john.heathcote@example.net','Mante, Leuschke and Pagac','3830 Crooks Mountain\nHilpertburgh, AL 41633','561-764-024',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(15,'Rogahn','Leopold','Hane','137 Kathryn Keys Apt. 338\nPort Merlinside, MD 44308-7282','Congo','786-445-7602','1-7428-312','armand80@example.com','Koelpin, Ebert and Aufderhar','9058 Schamberger Lodge\nJeaniebury, MD 15426','172-513-265',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(17,'Roberts','Orion','Ankunding','94676 Bettie Centers Apt. 683\nNew Johnathon, OK 00231-7372','Somalia','1-574-870-3610','8-7816-248','brittany.torphy@example.com','Glover Group','73086 Mina Island Apt. 369\nDaphneyhaven, IL 02075','706-421-245',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(18,'King','Elda','Hill','3709 Collier Gateway\nLebsackstad, SC 99717','Malta','+17145714079','3-8584-812','lowe.darrion@example.org','Koelpin and Sons','1393 Aurelia View\nWest Karley, DC 65692-1303','052-680-364',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(19,'Senger','Kara','O\'Reilly','564 Rodriguez Stravenue Suite 763\nMatteomouth, OH 43384-4084','Norfolk Island','978-521-4908','7-6189-113','ureynolds@example.net','White, Schultz and Collins','97139 Miller Mews\nKirlintown, OR 63325','137-454-489',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(20,'Bednar','Antonia','Willms','41789 Sandra Roads Apt. 339\nOndrickaburgh, CA 41941-8242','Faroe Islands','1-563-934-5823','3-5488-016','norma.krajcik@example.com','Pfeffer-Mayert','30307 Isobel Flats Suite 148\nBreanaview, ME 96142-3386','244-296-013',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(22,'O\'Kon','Reinhold','Pollich','565 Bernie Mission Apt. 307\nGeneralberg, GA 16634','Niue','+1-774-899-9775','4-1374-046','cyrus54@example.org','Homenick-VonRueden','2930 Feil Mall\nSchinnerton, OH 39360','363-684-794',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(23,'Corkery','Kelsie','Kutch','70390 Chaz Ridge Apt. 340\nBraunfurt, UT 70454-4111','American Samoa','938-766-9539','8-4030-882','xwolf@example.org','Gulgowski LLC','51416 Buckridge Landing Suite 653\nLeschfort, NE 86797-3802','347-209-939',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(24,'Bode','Aron','Murazik','27564 Melvin Motorway Suite 428\nNew Maximo, WA 26973','Burkina Faso','321-395-9389','5-4309-447','nia.corkery@example.com','Trantow-Jenkins','5557 Amalia Inlet Suite 716\nEast Rebafurt, NH 02575-6103','246-829-512',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(25,'Bruen','Cruz','Mueller','4370 Chadrick Squares Apt. 777\nWest Penelope, DC 78800','Bulgaria','+1 (432) 938-4069','9-3080-127','goodwin.gregg@example.net','Kilback Inc','9523 Lauriane Shoal\nNew Eastonstad, NY 75945','654-642-400',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(26,'Brekke','Kareem','Collins','6155 Efren Villages\nMcCulloughfurt, OK 46411-3270','Bouvet Island (Bouvetoya)','229.977.1604','0-4628-009','reginald.oconnell@example.org','Brakus Ltd','18466 Fabian River\nWest Adah, WY 68531-0367','237-951-527',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(27,'Harber','Kellen','Gaylord','82258 Wilderman Dam\nSanfordville, ME 61169-7659','Israel','+1-231-848-0963','9-2167-148','lonny62@example.net','Mertz-Schmitt','897 Raynor Land Apt. 587\nHauckberg, AL 07523-5502','041-056-455',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(28,'Ruecker','Reilly','Barton','834 Amari Hollow\nRoslynmouth, LA 94181-7110','Cocos (Keeling) Islands','+1-541-505-0413','2-2956-885','camylle.oreilly@example.org','Stracke, Hegmann and McLaughlin','6428 Stracke Dale\nProsaccostad, WV 68988-5588','575-052-306',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(29,'Strosin','Lera','Mohr','1512 Angela Fields\nCraigfurt, NH 96516','Ethiopia','+1-301-540-8939','7-1814-015','ethan.kutch@example.com','Bogan, Reilly and Bergnaum','320 Jaqueline Meadows\nLake Jefferystad, MD 76056-4122','805-746-044',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(30,'Bins','Elisabeth','Wyman','418 Predovic Common Apt. 026\nWest Kristastad, ID 87469','United Arab Emirates','858.663.3286','9-7640-939','zlegros@example.org','Rath PLC','58628 Helmer Plaza\nNew Delfinaborough, NH 95541-6419','298-078-654',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(31,'McGlynn','Iliana','Wehner','723 Grimes Hill Apt. 715\nJesusfort, MA 72414','Mozambique','1-757-970-8278','7-3089-187','ukrajcik@example.org','Carroll LLC','388 Russel Crescent Apt. 377\nJaskolskichester, DE 38094-1111','166-000-703',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(33,'Hyatt','Scottie','Mueller','307 Strosin Fall\nLake Taliaton, SD 33883','South Georgia and the South Sandwich Islands','(732) 909-7711','6-9200-185','wisozk.alf@example.org','Schaden-Rice','267 Reilly Mountains\nNew Veldachester, SC 74565','301-466-388',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(34,'Hansen','Jaquelin','Kub','4166 Marcia Lake Apt. 514\nIanport, ID 87085','Armenia','+1-302-409-4858','8-2855-336','roberts.myah@example.org','Prosacco Ltd','67909 Assunta Circle\nSouth Rosaliachester, KY 29210-2536','237-539-395',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(35,'Rice','Aiden','Hackett','4352 Beth Inlet\nStephonchester, NV 27364','Chad','(360) 572-8763','1-2033-732','owaters@example.com','Tillman LLC','9954 Simonis Villages\nWilliamsonburgh, NC 24297','612-102-454',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(36,'Wisoky','Bettye','Donnelly','640 Abernathy Ville Apt. 154\nWest Joey, NV 11016-9234','Guernsey','608.367.7753','2-6789-453','aurelie.mckenzie@example.net','Conroy Ltd','234 White Union\nNew Tillmanshire, IL 56281-2873','903-128-499',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(37,'Boehm','Nia','Hackett','383 Collier Ways\nSouth Donaldmouth, WV 36038-1216','Nepal','248.393.2812','8-2418-815','bednar.rigoberto@example.net','Morar-Doyle','2405 Keagan Center Suite 125\nBerylshire, NY 08557','266-613-021',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(38,'Durgan','Eleazar','Orn','4194 Treva Squares\nEast Lexus, MI 02448','Italy','+15209194388','0-2175-328','harber.jovany@example.org','Mohr, Rice and Renner','1866 Shields Common\nKuhnport, AR 29508-9605','797-893-861',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(39,'Kerluke','Justine','Kuphal','67488 Crawford Court\nLubowitzshire, WV 10477-2991','Montserrat','+1.850.503.2359','4-4352-236','jmedhurst@example.com','Dibbert, Weimann and Brekke','5798 Alexandrea Parkways\nSouth Olen, TN 30462','553-211-498',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(40,'Bartoletti','Jesse','Kassulke','502 Grant Cove Suite 215\nLake Alysa, TN 25740','Ukraine','+12202958100','4-7090-204','weldon.boehm@example.net','Block Ltd','353 Nelda Lake\nSouth Dariantown, OH 01133','873-668-886',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(41,'Kilback','Chris','Bahringer','5497 Runolfsson Parkway Apt. 555\nVonRuedenbury, KS 84205','Slovakia (Slovak Republic)','(442) 868-2990','5-2721-676','maxwell.schimmel@example.org','Grady LLC','7825 Huels Curve\nPort Joanneland, ND 80720-4530','840-589-630',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(42,'Mills','Shirley','Johnson','864 Shany Run\nPort Josephmouth, FL 54856','Bolivia','+1.424.434.3446','5-1764-260','mueller.verda@example.org','Schulist, Reichert and Harber','85781 Mante Valleys\nSouth Brianborough, ID 99621-7504','095-038-795',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(43,'Johnston','Eloise','Hegmann','3942 Kohler Lane Apt. 488\nEast Waylon, OK 67935-1848','Lithuania','+1-908-706-8405','9-5828-646','karen.schaefer@example.net','Grady, Mills and Sporer','590 Lynn Canyon\nCarlobury, ID 28993-0920','787-268-928',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(44,'Gerhold','Elliot','Cartwright','97390 Waelchi Centers Suite 472\nHowellport, IL 80776-5101','Netherlands','802.724.2319','4-4539-946','sydnie.streich@example.com','Pollich, Abernathy and Schroeder','76190 Kutch Lodge Suite 838\nEast Evastad, CT 57095','428-831-931',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(45,'Reilly','Joanny','Adams','226 Mollie Green\nFisherview, CA 55007','El Salvador','+13606382307','3-9533-184','guiseppe.yundt@example.com','Ankunding, Erdman and Borer','31506 Wunsch Crest Suite 174\nSouth Providenciborough, TX 42658-6869','772-510-981',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(46,'Tromp','Bettie','Murazik','477 Jerrod Highway Apt. 143\nRosenbaumshire, OH 05116-4745','Italy','1-281-681-6935','1-0230-021','charlene14@example.org','Ondricka, Champlin and Ryan','786 Beer Station Suite 618\nStokesmouth, ME 68919','927-009-629',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(47,'Murphy','Trey','Breitenberg','237 Raynor Mountains Suite 788\nNorth Jillian, RI 05200-9593','Cayman Islands','+19078179889','0-6523-850','marie59@example.org','Stark, Larson and McDermott','339 Weimann Circle\nFlatleyfurt, MD 27607-8280','513-036-305',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(48,'Okuneva','Art','Cormier','776 Jeffery Isle Suite 863\nEulashire, AL 71595-9035','Kazakhstan','1-520-748-6086','9-5854-555','hillary37@example.org','Wyman-Simonis','4040 Norma Hills Apt. 633\nNorth Angel, WV 96801','185-072-482',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(49,'Rohan','Brooks','Lang','8004 Pacocha Isle\nAbebury, WA 21819','Turks and Caicos Islands','(332) 917-2235','5-7109-101','gfay@example.net','Kshlerin-Russel','528 Joyce Stream\nAubreyport, MD 52960-3747','702-916-617',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(50,'Mohr','Tianna','Rippin','42780 Stefan Throughway Apt. 908\nNorth Virgil, WI 91138-7571','Guyana','602.452.9181','6-9367-583','conor07@example.org','Lindgren, Stark and Hoeger','32408 Labadie Views Apt. 943\nNorth Mckennaport, KY 38673-2551','022-829-890',0,1,'2023-04-21 22:26:26','2023-04-21 22:26:26');
/*!40000 ALTER TABLE `guests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `table` varchar(255) NOT NULL,
  `ref_no` bigint(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (28,1,'bookings',5,'Added VAT to booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 29, 2023','2023-04-25 05:18:12','2023-04-25 05:18:12'),(29,1,'bookings',5,'Removed VAT from booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 29, 2023','2023-04-25 05:18:19','2023-04-25 05:18:19'),(30,1,'bookings',5,'Added VAT to booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 29, 2023','2023-04-25 05:24:59','2023-04-25 05:24:59'),(31,1,'bookings',5,'Removed VAT from booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 29, 2023','2023-04-25 05:25:03','2023-04-25 05:25:03'),(32,1,'bookings',5,'Added VAT to booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 29, 2023','2023-04-25 05:25:09','2023-04-25 05:25:09'),(33,1,'bookings',5,'Removed VAT from booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 29, 2023','2023-04-25 05:25:15','2023-04-25 05:25:15'),(34,1,'bookings',5,'Added VAT to booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 29, 2023','2023-04-25 05:26:01','2023-04-25 05:26:01'),(35,1,'bookings',5,'Removed VAT from booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 29, 2023','2023-04-25 05:26:06','2023-04-25 05:26:06'),(36,1,'bookings',5,'Added VAT to booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 29, 2023','2023-04-25 05:26:09','2023-04-25 05:26:09'),(37,1,'bookings',5,'Created the booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 29, 2023','2023-04-26 03:29:45','2023-04-26 03:29:45'),(38,1,'bookings',5,'Removed addon (1 Others amounting to 300.00) from booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 29, 2023','2023-04-26 03:29:59','2023-04-26 03:29:59'),(39,1,'bookings',5,'Added VAT to booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 29, 2023','2023-04-26 03:30:16','2023-04-26 03:30:16'),(40,1,'bookings',5,'Removed VAT from booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 29, 2023','2023-04-26 03:30:42','2023-04-26 03:30:42'),(41,1,'bookings',5,'Updated the booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 26, 2023','2023-04-26 03:43:41','2023-04-26 03:43:41'),(42,1,'bookings',5,'Cancelled booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 26, 2023','2023-04-26 03:44:09','2023-04-26 03:44:09'),(43,1,'bookings',0,'The booking of Scottie M. Hyatt dated Apr 24, 2023 to Apr 26, 2023 has been deleted.','2023-04-26 03:44:12','2023-04-26 03:44:12');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2019_12_14_000001_create_personal_access_tokens_table',1),(3,'2023_01_11_114259_create_guests_table',1),(4,'2023_01_11_114324_create_rooms_table',1),(5,'2023_01_11_114327_create_bookings_table',1),(6,'2023_01_11_115805_create_addons_table',1),(7,'2023_01_11_115857_create_booking_addons_table',1),(8,'2023_01_20_062838_create_booking_guests_table',1),(9,'2023_01_26_124619_updated_bookings_table',1),(10,'2023_04_23_122006_create_logs_table',2),(11,'2023_04_25_122148_add_checkout_fields_to_bookings_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `room_type` varchar(255) NOT NULL,
  `rate` decimal(8,2) NOT NULL,
  `capacity` int(10) unsigned NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'Economy 1','Economy room with 1 bed and cable TV','Economy',800.00,1,'2023-04-21 22:26:25','2023-04-21 22:26:25'),(2,'Economy 2','Economy room with 1 bed and cable TV','Economy',800.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(3,'Economy 3','Economy room with 1 bed and cable TV','Economy',800.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(4,'Economy 4','Economy room with 1 bed and cable TV','Economy',800.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(5,'Economy 5','Economy room with 1 bed and cable TV','Economy',800.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(6,'Economy 6','Economy room with 1 bed and cable TV','Economy',800.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(7,'Double 1','Standard room with two beds, air conditioning, and cable TV','Superior',1500.00,2,'2023-04-21 22:26:26','2023-04-22 03:55:02'),(8,'Double 2','Standard room with two beds, air conditioning, and cable TV','Double',1500.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(9,'Double 3','Standard room with two beds, air conditioning, and cable TV','Double',1500.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(10,'Double 4','Standard room with two beds, air conditioning, and cable TV','Double',1500.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(11,'Double 5','Standard room with two beds, air conditioning, and cable TV','Double',1500.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(12,'Double 6','Standard room with two beds, air conditioning, and cable TV','Double',1500.00,2,'2023-04-21 22:26:26','2023-04-21 23:15:33'),(13,'Standard 1','Standard single room with air-conditioning and cable TV','Standard',1200.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(14,'Standard 2','Standard single room with air-conditioning and cable TV','Standard',1200.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(15,'Standard 3','Standard single room with air-conditioning and cable TV','Standard',1200.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(16,'Standard 4','Standard single room with air-conditioning and cable TV','Standard',1200.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(17,'Standard 5','Standard single room with air-conditioning and cable TV','Standard',1200.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(18,'Standard 6','Standard single room with air-conditioning and cable TV','Standard',1200.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(19,'Family Suite 1','Family-size room with two beds good for 4-5 persons with air-conditioning and cable TV','Family Suite',2300.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(20,'Family Suite 2','Family-size room with two beds good for 4-5 persons with air-conditioning and cable TV','Family Suite',2300.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(21,'Family Suite 3','Family-size room with two beds good for 4-5 persons with air-conditioning and cable TV','Family Suite',2300.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(22,'Family Suite 4','Family-size room with two beds good for 4-5 persons with air-conditioning and cable TV','Family Suite',2300.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(23,'Family Suite 5','Family-size room with two beds good for 4-5 persons with air-conditioning and cable TV','Family Suite',2300.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26'),(24,'Family Suite 6','Family-size room with two beds good for 4-5 persons with air-conditioning and cable TV','Family Suite',2300.00,1,'2023-04-21 22:26:26','2023-04-21 22:26:26');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'user',
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'lentrix','Benjie B. Lenteria','admin','$2y$10$P60K8e9GO1DErToz4kT.belM4rKNNewqUSPZdRzUEroCi84X4RE5S',1),(2,'mitch','Michelle H. Boromeo','user','$2y$10$HO4qImACiwse./4sLF7vQek4ZghfG97vEPXBdUp9p4rVv3xeGuMHi',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-26 20:13:57
