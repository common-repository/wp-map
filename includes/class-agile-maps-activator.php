<?php

/**
 * Fired during plugin activation
 *
 * @link       http://agilelogix.com
 * @since      1.0.0
 *
 * @package    AgileMaps
 * @subpackage AgileMaps/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    AgileMaps
 * @subpackage AgileMaps/includes
 * @author     Your Name <email@agilelogix.com>
 */
class AgileMaps_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		AgileMaps_Activator::add_basic_tables();
	}


	public static function add_basic_tables() {

		//ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	
		global $wpdb;
		$charset_collate = 'utf8';
		$prefix 	 	 = $wpdb->prefix."amaps_";

		

		/*Categories*/
		$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}categories` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `category_name` varchar(255) DEFAULT NULL,
			  `is_active` tinyint(4) NOT NULL,
			  `icon` varchar(100) NOT NULL,
			  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;";
		dbDelta( $sql );

		//Alter Character SET
		$sql = "ALTER TABLE {$prefix}categories CHARACTER SET utf8;";
		$wpdb->query( $sql );

		###############################################################################


	
		/*Config*/
		$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}configs` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `key` varchar(50) DEFAULT NULL,
			  `value` varchar(100) DEFAULT NULL,
			  `type` varchar(50) DEFAULT NULL,
			  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;";
		dbDelta( $sql );
		

		/*Countries*/
		$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}countries` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `country` varchar(255) NOT NULL,
				  `iso_code_2` char(2) NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `IDX_COUNTRIES_NAME` (`country`)
				) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8;";
		dbDelta( $sql );


		/*locations Markers*/
		$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}markers` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `marker_name` varchar(255) DEFAULT NULL,
			  `is_active` tinyint(4) NOT NULL,
			  `icon` varchar(100) NOT NULL,
			  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;";
		dbDelta( $sql );


		###########################################################################

		/*CREATE locations*/
		$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}locations` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `title` varchar(255) DEFAULT NULL,
			  `description` text,
			  `street` text,
			  `city` varchar(100) DEFAULT NULL,
			  `state` varchar(100) DEFAULT NULL,
			  `postal_code` varchar(50) DEFAULT NULL,
			  `country` int(11) DEFAULT NULL,
			  `lat` varchar(50) DEFAULT NULL,
			  `lng` varchar(50) DEFAULT NULL,
			  `phone` varchar(50) DEFAULT NULL,
			  `fax` varchar(50) DEFAULT NULL,
			  `email` varchar(100) DEFAULT NULL,
			  `website` varchar(255) DEFAULT NULL,
			  `description_2` text,
			  `logo_id` int(11) DEFAULT NULL,
			  `marker_id` int(11) DEFAULT NULL,
			  `is_disabled` varchar(20) DEFAULT NULL,
			  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
			  `updated_on` datetime DEFAULT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=utf8;";
		dbDelta( $sql );



		/*CREATE locations Categories*/
		$sql = "CREATE TABLE IF NOT EXISTS `{$prefix}locations_categories` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `category_id` int(11) NOT NULL,
			  `location_id` int(11) NOT NULL,
			  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8;";
		dbDelta( $sql );


		//Config;
		$c = $wpdb->get_results("SELECT count(*) AS 'count' FROM {$prefix}configs");
		if($c[0]->count != 36) {
			
			//remove previous configation
			$sql = "TRUNCATE TABLE `{$prefix}configs`";
			$wpdb->query($sql);	
	
			$sql =  "INSERT INTO `{$prefix}configs`(`id`,`key`,`value`,`type`,`created_on`) VALUES (1,'zoom','10',NULL,'2016-05-07 20:11:30'),(2,'default_lat','-33.624911521500394',NULL,'2016-05-07 20:12:31'),(3,'default_lng','151.3016510009765',NULL,'2016-05-07 20:12:34'),(4,'api_key','',NULL,'2016-06-03 16:20:21')";
			dbDelta( $sql );			
		}


		//categories;
		$c = $wpdb->get_results("SELECT count(*) AS 'count' FROM {$prefix}categories");
		if($c[0]->count <= 0) {
			
			$sql =  "INSERT INTO `{$prefix}categories`(`id`,`category_name`,`is_active`,`icon`,`created_on`) VALUES  (1,'Arts & Entertainment',1,'art gallery.png','2016-05-07 20:31:04'),(2,'For The Home',1,'store.png','2016-05-07 20:31:09'),(3,'Appliances',1,'laundry.png','2016-05-07 20:31:16'),(4,'Medical & Dental',1,'hospital.png','2016-05-07 20:31:20'),(5,'Jewelry',1,'jewelry store.png','2016-05-07 20:31:23'),(6,'Fitness',1,'gym.png','2016-05-07 20:31:26'),(7,'Electronics',1,'electronics store.png','2016-05-07 20:31:32'),(8,'Pets',1,'pet store.png','2016-05-07 20:31:33'),(9,'Auto',1,'car repair.png','2016-05-07 20:31:36'),(10,'Local Services',1,'local government.png','2016-05-07 20:31:39'),(11,'Beauty and Spas',1,'spa.png','2016-05-07 20:31:50'),(12,'Nightlife',1,'night club.png','2016-05-07 20:31:55'),(13,'Restaurants',1,'restuarant.png','2016-05-07 20:32:03'),(14,'Travel',1,'train-station.png','2016-05-07 20:32:55'),(15,'Anthem ',1,'default.png','2016-12-12 21:52:30')";
			dbDelta( $sql );
		}

		//countries
		$c = $wpdb->get_results("SELECT count(*) AS 'count' FROM {$prefix}countries");
		if($c[0]->count <= 0) {
			$sql =  "INSERT INTO `{$prefix}countries`(`id`,`country`,`iso_code_2`) VALUES (1,'Afghanistan','AF'),(2,'Albania','AL'),(3,'Algeria','DZ'),(4,'American Samoa','AS'),(5,'Andorra','AD'),(6,'Angola','AO'),(7,'Anguilla','AI'),(8,'Antarctica','AQ'),(9,'Antigua and Barbuda','AG'),(10,'Argentina','AR'),(11,'Armenia','AM'),(12,'Aruba','AW'),(13,'Australia','AU'),(14,'Austria','AT'),(15,'Azerbaijan','AZ'),(16,'Bahamas','BS'),(17,'Bahrain','BH'),(18,'Bangladesh','BD'),(19,'Barbados','BB'),(20,'Belarus','BY'),(21,'Belgium','BE'),(22,'Belize','BZ'),(23,'Benin','BJ'),(24,'Bermuda','BM'),(25,'Bhutan','BT'),(26,'Bolivia','BO'),(27,'Bosnia and Herzegowina','BA'),(28,'Botswana','BW'),(29,'Bouvet Island','BV'),(30,'Brazil','BR'),(31,'British Indian Ocean Territory','IO'),(32,'Brunei Darussalam','BN'),(33,'Bulgaria','BG'),(34,'Burkina Faso','BF'),(35,'Burundi','BI'),(36,'Cambodia','KH'),(37,'Cameroon','CM'),(38,'Canada','CA'),(39,'Cape Verde','CV'),(40,'Cayman Islands','KY'),(41,'Central African Republic','CF'),(42,'Chad','TD'),(43,'Chile','CL'),(44,'China','CN'),(45,'Christmas Island','CX'),(46,'Cocos (Keeling) Islands','CC'),(47,'Colombia','CO'),(48,'Comoros','KM'),(49,'Congo','CG'),(50,'Cook Islands','CK'),(51,'Costa Rica','CR'),(52,'Cote D\'Ivoire','CI'),(53,'Croatia','HR'),(54,'Cuba','CU'),(55,'Cyprus','CY'),(56,'Czech Republic','CZ'),(57,'Denmark','DK'),(58,'Djibouti','DJ'),(59,'Dominica','DM'),(60,'Dominican Republic','DO'),(61,'East Timor','TP'),(62,'Ecuador','EC'),(63,'Egypt','EG'),(64,'El Salvador','SV'),(65,'Equatorial Guinea','GQ'),(66,'Eritrea','ER'),(67,'Estonia','EE'),(68,'Ethiopia','ET'),(69,'Falkland Islands (Malvinas)','FK'),(70,'Faroe Islands','FO'),(71,'Fiji','FJ'),(72,'Finland','FI'),(73,'France','FR'),(74,'France, Metropolitan','FX'),(75,'French Guiana','GF'),(76,'French Polynesia','PF'),(77,'French Southern Territories','TF'),(78,'Gabon','GA'),(79,'Gambia','GM'),(80,'Georgia','GE'),(81,'Germany','DE'),(82,'Ghana','GH'),(83,'Gibraltar','GI'),(84,'Greece','GR'),(85,'Greenland','GL'),(86,'Grenada','GD'),(87,'Guadeloupe','GP'),(88,'Guam','GU'),(89,'Guatemala','GT'),(90,'Guinea','GN'),(91,'Guinea-bissau','GW'),(92,'Guyana','GY'),(93,'Haiti','HT'),(94,'Heard and Mc Donald Islands','HM'),(95,'Honduras','HN'),(96,'Hong Kong','HK'),(97,'Hungary','HU'),(98,'Iceland','IS'),(99,'India','IN'),(100,'Indonesia','ID'),(101,'Iran (Islamic Republic of)','IR'),(102,'Iraq','IQ'),(103,'Ireland','IE'),(104,'Israel','IL'),(105,'Italy','IT'),(106,'Jamaica','JM'),(107,'Japan','JP'),(108,'Jordan','JO'),(109,'Kazakhstan','KZ'),(110,'Kenya','KE'),(111,'Kiribati','KI'),(112,'Korea, Democratic People\'s Republic of','KP'),(113,'Korea, Republic of','KR'),(114,'Kuwait','KW'),(115,'Kyrgyzstan','KG'),(116,'Lao People\'s Democratic Republic','LA'),(117,'Latvia','LV'),(118,'Lebanon','LB'),(119,'Lesotho','LS'),(120,'Liberia','LR'),(121,'Libyan Arab Jamahiriya','LY'),(122,'Liechtenstein','LI'),(123,'Lithuania','LT'),(124,'Luxembourg','LU'),(125,'Macau','MO'),(126,'Macedonia, The Former Yugoslav Republic of','MK'),(127,'Madagascar','MG'),(128,'Malawi','MW'),(129,'Malaysia','MY'),(130,'Maldives','MV'),(131,'Mali','ML'),(132,'Malta','MT'),(133,'Marshall Islands','MH'),(134,'Martinique','MQ'),(135,'Mauritania','MR'),(136,'Mauritius','MU'),(137,'Mayotte','YT'),(138,'Mexico','MX'),(139,'Micronesia, Federated States of','FM'),(140,'Moldova, Republic of','MD'),(141,'Monaco','MC'),(142,'Mongolia','MN'),(143,'Montserrat','MS'),(144,'Morocco','MA'),(145,'Mozambique','MZ'),(146,'Myanmar','MM'),(147,'Namibia','NA'),(148,'Nauru','NR'),(149,'Nepal','NP'),(150,'Netherlands','NL'),(151,'Netherlands Antilles','AN'),(152,'New Caledonia','NC'),(153,'New Zealand','NZ'),(154,'Nicaragua','NI'),(155,'Niger','NE'),(156,'Nigeria','NG'),(157,'Niue','NU'),(158,'Norfolk Island','NF'),(159,'Northern Mariana Islands','MP'),(160,'Norway','NO'),(161,'Oman','OM'),(162,'Pakistan','PK'),(163,'Palau','PW'),(164,'Panama','PA'),(165,'Papua New Guinea','PG'),(166,'Paraguay','PY'),(167,'Peru','PE'),(168,'Philippines','PH'),(169,'Pitcairn','PN'),(170,'Poland','PL'),(171,'Portugal','PT'),(172,'Puerto Rico','PR'),(173,'Qatar','QA'),(174,'Reunion','RE'),(175,'Romania','RO'),(176,'Russian Federation','RU'),(177,'Rwanda','RW'),(178,'Saint Kitts and Nevis','KN'),(179,'Saint Lucia','LC'),(180,'Saint Vincent and the Grenadines','VC'),(181,'Samoa','WS'),(182,'San Marino','SM'),(183,'Sao Tome and Principe','ST'),(184,'Saudi Arabia','SA'),(185,'Senegal','SN'),(186,'Seychelles','SC'),(187,'Sierra Leone','SL'),(188,'Singapore','SG'),(189,'Slovakia (Slovak Republic)','SK'),(190,'Slovenia','SI'),(191,'Solomon Islands','SB'),(192,'Somalia','SO'),(193,'South Africa','ZA'),(194,'South Georgia and the South Sandwich Islands','GS'),(195,'Spain','ES'),(196,'Sri Lanka','LK'),(197,'St. Helena','SH'),(198,'St. Pierre and Miquelon','PM'),(199,'Sudan','SD'),(200,'Suriname','SR'),(201,'Svalbard and Jan Mayen Islands','SJ'),(202,'Swaziland','SZ'),(203,'Sweden','SE'),(204,'Switzerland','CH'),(205,'Syrian Arab Republic','SY'),(206,'Taiwan','TW'),(207,'Tajikistan','TJ'),(208,'Tanzania, United Republic of','TZ'),(209,'Thailand','TH'),(210,'Togo','TG'),(211,'Tokelau','TK'),(212,'Tonga','TO'),(213,'Trinidad and Tobago','TT'),(214,'Tunisia','TN'),(215,'Turkey','TR'),(216,'Turkmenistan','TM'),(217,'Turks and Caicos Islands','TC'),(218,'Tuvalu','TV'),(219,'Uganda','UG'),(220,'Ukraine','UA'),(221,'United Arab Emirates','AE'),(222,'United Kingdom','GB'),(223,'United States','US'),(224,'United States Minor Outlying Islands','UM'),(225,'Uruguay','UY'),(226,'Uzbekistan','UZ'),(227,'Vanuatu','VU'),(228,'Vatican City State (Holy See)','VA'),(229,'Venezuela','VE'),(230,'Viet Nam','VN'),(231,'Virgin Islands (British)','VG'),(232,'Virgin Islands (U.S.)','VI'),(233,'Wallis and Futuna Islands','WF'),(234,'Western Sahara','EH'),(235,'Yemen','YE'),(236,'Yugoslavia','YU'),(237,'Zaire','ZR'),(238,'Zambia','ZM'),(239,'Zimbabwe','ZW');";
			dbDelta( $sql );
		}

		//markers
		$c = $wpdb->get_results("SELECT count(*) AS 'count' FROM {$prefix}markers");
		
		if($c[0]->count <= 0) {
			
			$sql =  "INSERT INTO `{$prefix}markers`(`id`,`marker_name`,`is_active`,`icon`,`created_on`) values (1,'Default',1,'default.png','2016-11-18 21:58:44')";
			dbDelta( $sql );
		}


		//locations
		$c = $wpdb->get_results("SELECT count(*) AS 'count' FROM {$prefix}locations");
		

		if($c[0]->count == 0) {
			

			$sql =  "INSERT INTO `{$prefix}locations`(`id`,`title`,`description`,`street`,`city`,`state`,`postal_code`,`country`,`lat`,`lng`,`phone`,`fax`,`email`,`website`,`description_2`,`marker_id`) VALUES (1,'Sound with Vision','Brands we Sell: Anthem&#44; Paradigm&#44; Sony','246 Pacific Highway ','Crows Nest','NSW','2065',223,'-33.8291258','151.2014051','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(2,'Wyndham Audio','Brands we Sell: Isotek','555 East Highway','Wyndham Vale','VIC','3024',223,'-37.89','144.63','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(3,'Invision Home Theatre & Automation','Brands we Sell: Anthem&#44; Isotek&#44; MartinLogan&#44; Paradigm&#44; Sony','Shop 19, 2 Euston Walk','Mawson Lakes ','SA','5095',223,'-34.807388','138.6141467','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(4,'Cinasonic Home Cinema & HiFi','Brands we Sell: MartinLogan','18 Flora Bassett Street','Franklin','ACT','2912',223,'-35.206416','149.141726','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(5,'Bunbury Hi Fi & Car Stereo','Brands we Sell: Paradigm&#44; Vincent Audio','73 Spencer Street','Bunbury','WA','6230',223,'-33.33307','115.640654','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(6,'Premier AV Installs','Brands we Sell: Isotek&#44; Isotek Premium&#44; MartinLogan&#44; Primare&#44; Sony&#44; Sony High Resolution Audio&#44; Vienna Acoustics','76 Murray Street','The Range','QLD','4700',223,'-23.376133','150.500245','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(7,'Living Entertainment North Coast','Brands we Sell: Anthem&#44; Sony&#44; Tannoy','16-17/98 Woodlark Street','Lismore','New South Wales','2480',223,'-28.807181','153.278989','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(8,'Sound by Design','Brands we Sell: Isotek&#44; Isotek Premium&#44; Sony&#44; Tannoy&#44; Tannoy Prestige','Building Solution Centre ','Hobart','TAS','7000',223,'-42.8819032','147.3238148','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(9,'Mcleans Smarter Home Entertainment','Brands we Sell: MartinLogan','Shop 1, 41-45 Victoria Street','East Gosford','NSW','2250',223,'-33.438612','151.354902','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(10,'Digital Interiors','Brands we Sell: Blue Horizon&#44; Isotek&#44; Isotek Premium','46 Parer Drive','Wagaman','NT','810',223,'-12.383336','130.881779','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(11,'Infrared Home Entertainment & Automation ','Brands we Sell: Isotek&#44; Isotek Premium&#44; MartinLogan&#44; Primare&#44; Sony','14 Irvine Crescent','Ryde','NSW','2112',223,'-33.816138','151.113492','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(12,'Audio Visual Technology','Brands we Sell: Sony High Resolution Audio','37 Eagleview Place','Eagle Farm','QLD','4009',223,'-27.43737','153.083835','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(13,'Cableman','Brands we Sell: Isotek&#44; Isotek Premium&#44; Van Den Hul','3 Egan Street','Carnegie','VIC','3163',223,'-37.885087','145.056926','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(14,'Urban Intelligence','Brands we Sell: Anthem&#44; Isotek&#44; Isotek Premium&#44; Paradigm Classic Series&#44; Paradigm Custom Series&#44; Van Den Hul','59 Garden Street','South Yarra','VIC','3141',223,'-37.843334','144.998341','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(15,'All About Audio','Brands we Sell: Anthem&#44; MartinLogan&#44; Paradigm Classic Series&#44; Paradigm Custom Series&#44; Sony&#44; Tannoy&#44; Vincent Audio','Shop 2, 116 William Street','Rockhampton','Queensland','4700',223,'-23.382613','150.509948','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(16,'Blackwood Sound Centre','Brands we Sell: Anthem&#44; Isotek&#44; Isotek Premium&#44; Paradigm Classic Series&#44; Paradigm Custom Series&#44; Van Den Hul','2-6 Coromandel Parade','Blackwood','S.A.','5051',223,'-35.021587','138.6170344','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(17,'Gladstone Hi-Fi','Brands we Sell: Anthem','3/28 Tank Street','Gladstone','QLD','4680',223,'-23.847808','151.261062','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1),(18,'Sydney Hi Fi Mona Vale','Brands we Sell: Anthem&#44; Paradigm Classic Series&#44; Paradigm Custom Series','1 Mona Vale Road','Mona Vale','NSW','2103',223,'-33.6786064','151.302227','+123435345','+223435345','support@agilelogix.com','https://wpmaps.co',NULL,1);";
			$wpdb->query( $sql );

			//location category relation
			$sql =  "INSERT INTO `{$prefix}locations_categories`(`id`,`category_id`,`location_id`,`created_on`) VALUES (1,1,1,'2016-12-12 21:52:30'),(2,2,2,'2016-12-12 21:52:31'),(3,3,3,'2016-12-12 21:52:31'),(4,4,4,'2016-12-12 21:52:31'),(5,5,5,'2016-12-12 21:52:31'),(6,6,6,'2016-12-12 21:52:32'),(7,7,7,'2016-12-12 21:52:33'),(8,8,8,'2016-12-12 21:52:33'),(9,9,9,'2016-12-12 21:52:34'),(10,10,10,'2016-12-12 21:52:34'),(11,11,11,'2016-12-12 21:52:34'),(12,12,12,'2016-12-12 21:52:35'),(13,13,13,'2016-12-12 21:52:35'),(14,14,14,'2016-12-12 21:52:36'),(15,15,15,'2016-12-12 21:52:36'),(16,5,16,'2016-12-12 21:52:36'),(17,6,17,'2016-12-12 21:52:38'),(18,8,18,'2016-12-12 21:52:39'),(19,2,12,'2016-12-12 21:52:39'),(20,3,11,'2016-12-12 21:52:41'),(21,12,8,'2016-12-12 21:52:47'),(22,11,5,'2016-12-12 21:52:47'),(23,15,3,'2016-12-12 21:52:47'),(24,1,2,'2016-12-12 21:52:47'),(25,2,7,'2016-12-12 21:52:48')";
			dbDelta( $sql );
		}
	}

}
