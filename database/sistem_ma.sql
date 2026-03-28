/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.2.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: sistem_ma
-- ------------------------------------------------------
-- Server version	12.2.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_code` varchar(30) NOT NULL,
  `device_type` enum('pc','laptop','server') NOT NULL,
  `brand` varchar(50) NOT NULL,
  `model` varchar(100) NOT NULL,
  `serial_number` varchar(100) NOT NULL,
  `processor` varchar(100) DEFAULT NULL,
  `ram_size` int(11) DEFAULT NULL COMMENT 'GB',
  `storage_size` int(11) DEFAULT NULL COMMENT 'GB',
  `storage_type` enum('ssd','hdd','nvme') DEFAULT NULL,
  `os` varchar(50) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `warranty_until` date DEFAULT NULL,
  `status` enum('active','maintenance','retired','in_use') NOT NULL DEFAULT 'active',
  `location` varchar(100) DEFAULT NULL,
  `assigned_to` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `devices_asset_code_unique` (`asset_code`),
  UNIQUE KEY `devices_serial_number_unique` (`serial_number`),
  KEY `devices_asset_code_index` (`asset_code`),
  KEY `devices_status_index` (`status`),
  KEY `devices_location_index` (`location`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
INSERT INTO `devices` VALUES
(1,'IT-00002','laptop','HP','EliteBook 840 G8','SN-HP-002','Intel Core i7-1165G7',16,512,'nvme','Windows 11 Pro','2024-03-28','2028-03-28','in_use','Marketing','Sarah Connor',NULL,NULL,'2026-03-28 06:48:15','2026-03-28 06:48:15'),
(2,'IT-00003','server','Dell','PowerEdge R740','SN-DELL-003','Intel Xeon Silver 4210',64,2000,'ssd','Ubuntu 22.04 LTS','2025-03-28','2028-03-28','active','Server Room',NULL,NULL,NULL,'2026-03-28 06:48:15','2026-03-28 06:48:15'),
(3,'IT-00004','pc','Lenovo','ThinkCentre M90q','SN-LEN-004','Intel Core i5-10500',8,256,'ssd','Windows 10 Pro','2025-03-28','2027-03-28','maintenance','HR Dept','Mike Johnson',NULL,NULL,'2026-03-28 06:48:15','2026-03-28 06:48:15'),
(4,'IT-00005','laptop','Lenovo','ThinkPad X1 Carbon','SN-LEN-005','Intel Core i7-10510U',16,512,'nvme','Windows 11 Pro','2024-03-28','2027-03-28','active','Executive','CEO',NULL,NULL,'2026-03-28 06:48:15','2026-03-28 06:48:15'),
(5,'IT-00006','pc','Asus','ExpertCenter D500','SN-ASUS-006','Intel Core i3-10100',4,500,'hdd','Windows 10 Home','2022-03-28','2028-03-28','retired','Storage',NULL,NULL,NULL,'2026-03-28 06:48:15','2026-03-28 06:48:15'),
(6,'IT-001','pc','Dell','Optiplex 3080','DELL-001-SN',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'active',NULL,NULL,NULL,NULL,'2026-03-28 06:50:02','2026-03-28 06:50:02');
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `maintenance_logs`
--

DROP TABLE IF EXISTS `maintenance_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `maintenance_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `maintenance_date` date NOT NULL,
  `maintenance_type` enum('preventive','corrective','upgrade') NOT NULL,
  `description` text NOT NULL,
  `sparepart_id` int(11) DEFAULT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `technician` varchar(100) NOT NULL,
  `next_maintenance` date DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `maintenance_logs_sparepart_id_foreign` (`sparepart_id`),
  KEY `maintenance_logs_device_id_index` (`device_id`),
  KEY `maintenance_logs_maintenance_date_index` (`maintenance_date`),
  CONSTRAINT `maintenance_logs_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`),
  CONSTRAINT `maintenance_logs_sparepart_id_foreign` FOREIGN KEY (`sparepart_id`) REFERENCES `spareparts` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maintenance_logs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `maintenance_logs` WRITE;
/*!40000 ALTER TABLE `maintenance_logs` DISABLE KEYS */;
INSERT INTO `maintenance_logs` VALUES
(1,4,'2026-02-10','corrective','Laptop battery replacement',NULL,1360000.00,'Eric Green','2026-08-10','2026-03-28 06:48:15'),
(2,3,'2025-12-01','preventive','Server inspection and firmware update',NULL,0.00,'IT Admin','2026-04-02','2026-03-28 06:48:15'),
(3,5,'2025-11-20','preventive','Cleaning and OS update',NULL,0.00,'IT Admin','2026-03-30','2026-03-28 06:48:15'),
(4,6,'2026-03-28','upgrade','Upgrade RAM',NULL,0.00,'Muhammad Fajar',NULL,'2026-03-28 06:51:11');
/*!40000 ALTER TABLE `maintenance_logs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_03_28_003237_create_devices_table',1),
(5,'2026_03_28_003239_create_spareparts_table',1),
(6,'2026_03_28_003240_create_transactions_table',1),
(7,'2026_03_28_003241_create_maintenance_logs_table',1),
(8,'2026_03_28_110000_fix_maintenance_logs_foreign_key',1),
(9,'2026_03_28_111000_add_indexes_to_tables',1),
(10,'2026_03_28_120000_add_role_to_users_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('eBqZzGchg2duDUMWQqtSlQd8x4LtQteq6shfBfRc',1,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJveXV5WkQyTlFIbGpJVGxJeXI1aHA0UEgzVHU3ZXFTVmdSeVJZWkRZIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL21haW50ZW5hbmNlIiwicm91dGUiOiJtYWludGVuYW5jZS5pbmRleCJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=',1774681396);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `spareparts`
--

DROP TABLE IF EXISTS `spareparts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `spareparts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `part_code` varchar(30) NOT NULL,
  `part_category` enum('ram','ssd','hdd','psu','motherboard','keyboard','mouse','cable','other') NOT NULL,
  `part_name` varchar(100) NOT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `specification` varchar(200) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `min_stock` int(11) NOT NULL DEFAULT 0,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `supplier` varchar(100) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `spareparts_part_code_unique` (`part_code`),
  KEY `spareparts_part_code_index` (`part_code`),
  KEY `spareparts_part_category_index` (`part_category`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spareparts`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `spareparts` WRITE;
/*!40000 ALTER TABLE `spareparts` DISABLE KEYS */;
INSERT INTO `spareparts` VALUES
(1,'SPR-00002','ssd','SSD SATA 256GB','WD','256GB SATA 2.5\"',6,3,720000.00,'PC Store','Shelf A-2','2026-03-28 06:48:15','2026-03-28 06:48:15'),
(2,'SPR-00003','hdd','HDD 1TB','Seagate','1TB 7200RPM SATA',2,3,880000.00,'TechSupplies Co.','Shelf A-3','2026-03-28 06:48:15','2026-03-28 06:48:15'),
(3,'SPR-00004','keyboard','USB Keyboard','Logitech','Wired USB Full Size',8,5,250000.00,'iBox','Shelf B-1','2026-03-28 06:48:15','2026-03-28 06:48:15'),
(4,'SPR-00005','mouse','USB Optical Mouse','Logitech','Wired USB Optical',3,5,180000.00,'iBox','Shelf B-2','2026-03-28 06:48:15','2026-03-28 06:48:15'),
(5,'SPR-00006','psu','PSU 500W','Corsair','500W 80+ Bronze',3,2,1200000.00,'TechSupplies Co.','Shelf C-1','2026-03-28 06:48:15','2026-03-28 06:48:15'),
(6,'SPR-00007','cable','Cat6 LAN Cable 1m','Belden','UTP Cat6 1 meter',20,10,35000.00,'Network Mart','Shelf D-1','2026-03-28 06:48:15','2026-03-28 06:48:15'),
(7,'SPR-00008','ram','RAM DDR4 16GB','Corsair','16GB DDR4 3600MHz',1,2,1100000.00,'TechSupplies Co.','Shelf A-1','2026-03-28 06:48:15','2026-03-28 06:48:15'),
(8,'SPR-001','ram','RAM DDR4 8GB','Kingston','8GB DDR4 3200MHz',4,5,0.00,NULL,NULL,'2026-03-28 06:50:22','2026-03-28 06:52:19');
/*!40000 ALTER TABLE `spareparts` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_code` varchar(30) NOT NULL,
  `part_id` int(11) NOT NULL,
  `device_id` int(11) DEFAULT NULL,
  `transaction_type` enum('in','out') NOT NULL,
  `quantity` int(11) NOT NULL,
  `purpose` varchar(200) DEFAULT NULL,
  `requester` varchar(100) DEFAULT NULL,
  `technician` varchar(100) DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_transaction_code_unique` (`transaction_code`),
  KEY `transactions_part_id_index` (`part_id`),
  KEY `transactions_device_id_index` (`device_id`),
  KEY `transactions_transaction_date_index` (`transaction_date`),
  CONSTRAINT `transactions_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE SET NULL,
  CONSTRAINT `transactions_part_id_foreign` FOREIGN KEY (`part_id`) REFERENCES `spareparts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES
(1,'TRX-20260310-0002',7,2,'out',1,'SSD replacement','Sarah Connor','Eric G.','2026-03-10',NULL,'2026-03-28 06:48:15'),
(2,'TRX-20260315-0001',2,NULL,'in',10,NULL,'iBox','Eric G.','2026-03-15',NULL,'2026-03-28 06:48:15'),
(3,'TRX-20260320-0001',5,4,'out',1,'Replace broken mouse','CEO','Eric G.','2026-03-20',NULL,'2026-03-28 06:48:15'),
(4,'TRX-20260328-0001',8,6,'out',1,'Upgrade RAM pada PC IT-001','Ahmad Rizki',NULL,'2026-03-28',NULL,'2026-03-28 06:50:51'),
(5,'TRX-20260328-0002',8,NULL,'in',10,NULL,NULL,NULL,'2026-03-28',NULL,'2026-03-28 06:51:46'),
(6,'TRX-20260328-0003',8,NULL,'out',15,'Tes','Ahmad Rizki',NULL,'2026-03-28',NULL,'2026-03-28 06:52:19');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','technician','viewer') NOT NULL DEFAULT 'viewer' COMMENT 'User role: admin (full access), technician (maintenance & sparepart), viewer (read-only)',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Admin User','admin@test.local','admin',NULL,'$2y$12$ifK/.weuBfy6VtNktCiA9eu13zjvHBox8g5zgyJtyWganLFpy.UFC',NULL,'2026-03-27 23:48:14','2026-03-27 23:48:14'),
(2,'Technician User','technician@test.local','technician',NULL,'$2y$12$wEz0hc8UAmyZOMuMiP0qjOAIA7LJik0aV1KyHV2foILzXks9gVcbK',NULL,'2026-03-27 23:48:15','2026-03-27 23:48:15'),
(3,'Viewer User','viewer@test.local','viewer',NULL,'$2y$12$DmmMbnUW0RKo8WKf5etUV.IpcBrvrlsRICw7TvHzwwkmPEeDBkqKG',NULL,'2026-03-27 23:48:15','2026-03-27 23:48:15');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-03-28 14:10:30
