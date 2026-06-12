-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: taskflow
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-admin@gmail.com|127.0.0.1','i:1;',1779958183),('laravel-cache-admin@gmail.com|127.0.0.1:timer','i:1779958183;',1779958183),('laravel-cache-thanhbo@gmail.com|127.0.0.1','i:2;',1779958108),('laravel-cache-thanhbo@gmail.com|127.0.0.1:timer','i:1779958108;',1779958108);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_05_27_150205_create_tasks_table',1),(5,'2026_05_28_012714_create_notifications_table',1),(6,'2026_05_28_025816_create_teams_table',1),(7,'2026_05_28_025822_create_team_user_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES ('1cc678dd-f3a2-4a1e-bcc7-9b4cd5b8a55e','App\\Notifications\\TaskActivityNotification','App\\Models\\User',7,'{\"task_id\":41,\"title\":\"Thi\\u1ebft k\\u1ebf giao di\\u1ec7n trang ch\\u1ee7\",\"action\":\"c\\u1eadp nh\\u1eadt tr\\u1ea1ng th\\u00e1i\",\"message\":\"B\\u1ea1n v\\u1eeba c\\u1eadp nh\\u1eadt tr\\u1ea1ng th\\u00e1i c\\u00f4ng vi\\u1ec7c: Thi\\u1ebft k\\u1ebf giao di\\u1ec7n trang ch\\u1ee7\"}','2026-05-28 01:57:52','2026-05-28 01:56:15','2026-05-28 01:57:52'),('2df7e2f4-2416-46fc-bb17-5482c5d5574b','App\\Notifications\\TaskActivityNotification','App\\Models\\User',7,'{\"task_id\":51,\"title\":\"Ph\\u00e2n t\\u00edch y\\u00eau c\\u1ea7u v\\u00e0 Thi\\u1ebft k\\u1ebf s\\u01a1 \\u0111\\u1ed3 c\\u01a1 s\\u1edf d\\u1eef li\\u1ec7u (ERD)\",\"action\":\"t\\u1ea1o m\\u1edbi\",\"message\":\"B\\u1ea1n v\\u1eeba t\\u1ea1o m\\u1edbi c\\u00f4ng vi\\u1ec7c: Ph\\u00e2n t\\u00edch y\\u00eau c\\u1ea7u v\\u00e0 Thi\\u1ebft k\\u1ebf s\\u01a1 \\u0111\\u1ed3 c\\u01a1 s\\u1edf d\\u1eef li\\u1ec7u (ERD)\"}','2026-05-28 00:56:35','2026-05-28 00:55:26','2026-05-28 00:56:35'),('40e13581-9480-4c50-aa1a-ec815c4b294d','App\\Notifications\\ReportNotification','App\\Models\\User',7,'{\"title\":\"B\\u00e1o c\\u00e1o\",\"action\":\"xu\\u1ea5t b\\u00e1o c\\u00e1o\",\"message\":\"B\\u1ea1n v\\u1eeba xu\\u1ea5t m\\u1ed9t file b\\u00e1o c\\u00e1o c\\u00f4ng vi\\u1ec7c (CSV) v\\u1ec1 thi\\u1ebft b\\u1ecb.\"}','2026-05-28 02:03:34','2026-05-28 01:59:10','2026-05-28 02:03:34'),('48249ae9-1ad3-4bf0-be40-442cddcd5b96','App\\Notifications\\TaskActivityNotification','App\\Models\\User',7,'{\"task_id\":52,\"title\":\"L\\u1eadp tr\\u00ecnh ch\\u1ee9c n\\u0103ng qu\\u1ea3n l\\u00fd c\\u00f4ng vi\\u1ec7c (CRUD)\",\"action\":\"t\\u1ea1o m\\u1edbi\",\"message\":\"B\\u1ea1n v\\u1eeba t\\u1ea1o m\\u1edbi c\\u00f4ng vi\\u1ec7c: L\\u1eadp tr\\u00ecnh ch\\u1ee9c n\\u0103ng qu\\u1ea3n l\\u00fd c\\u00f4ng vi\\u1ec7c (CRUD)\"}','2026-05-28 00:56:35','2026-05-28 00:56:02','2026-05-28 00:56:35'),('568bb7ae-ea5d-4d5e-86a0-55d43f8f9480','App\\Notifications\\ReportNotification','App\\Models\\User',7,'{\"title\":\"B\\u00e1o c\\u00e1o\",\"action\":\"xu\\u1ea5t b\\u00e1o c\\u00e1o\",\"message\":\"B\\u1ea1n v\\u1eeba xu\\u1ea5t m\\u1ed9t file b\\u00e1o c\\u00e1o c\\u00f4ng vi\\u1ec7c (CSV) v\\u1ec1 thi\\u1ebft b\\u1ecb.\"}','2026-05-28 02:03:34','2026-05-28 02:00:17','2026-05-28 02:03:34'),('6d545a38-c4ee-4972-92b0-6ba0aced540f','App\\Notifications\\ReportNotification','App\\Models\\User',7,'{\"title\":\"B\\u00e1o c\\u00e1o\",\"action\":\"xu\\u1ea5t b\\u00e1o c\\u00e1o\",\"message\":\"B\\u1ea1n v\\u1eeba xu\\u1ea5t m\\u1ed9t file b\\u00e1o c\\u00e1o c\\u00f4ng vi\\u1ec7c (CSV) v\\u1ec1 thi\\u1ebft b\\u1ecb.\"}','2026-05-28 02:03:34','2026-05-28 02:01:13','2026-05-28 02:03:34'),('b6c70e21-e894-4a70-81fe-14fb02f62387','App\\Notifications\\TaskActivityNotification','App\\Models\\User',7,'{\"task_id\":42,\"title\":\"Ph\\u00e1t tri\\u1ec3n Frontend trang Dashboard\",\"action\":\"c\\u1eadp nh\\u1eadt tr\\u1ea1ng th\\u00e1i\",\"message\":\"B\\u1ea1n v\\u1eeba c\\u1eadp nh\\u1eadt tr\\u1ea1ng th\\u00e1i c\\u00f4ng vi\\u1ec7c: Ph\\u00e1t tri\\u1ec3n Frontend trang Dashboard\"}','2026-05-28 01:57:52','2026-05-28 01:56:21','2026-05-28 01:57:52'),('d803e771-ce03-4231-b044-2a8016246842','App\\Notifications\\TaskActivityNotification','App\\Models\\User',7,'{\"task_id\":53,\"title\":\"Tich h\\u1ee3p L\\u1ecbch bi\\u1ec3u v\\u00e0 xu\\u1ea5t d\\u1eef li\\u1ec7u b\\u00e1o c\\u00e1o\",\"action\":\"t\\u1ea1o m\\u1edbi\",\"message\":\"B\\u1ea1n v\\u1eeba t\\u1ea1o m\\u1edbi c\\u00f4ng vi\\u1ec7c: Tich h\\u1ee3p L\\u1ecbch bi\\u1ec3u v\\u00e0 xu\\u1ea5t d\\u1eef li\\u1ec7u b\\u00e1o c\\u00e1o\"}','2026-05-28 00:56:35','2026-05-28 00:56:26','2026-05-28 00:56:35');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('5NrL4XzFGhXeU5BdURKLzVDnm1gXyMhXTloyjdfN',7,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:151.0) Gecko/20100101 Firefox/151.0','eyJfdG9rZW4iOiJpb1RJaG1JU25WRkNIeGJJOU1OQnJCVmk2YXh3S2I4cDN0Y3lnWXZ5IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2Rhc2hib2FyZCIsInJvdXRlIjoiZGFzaGJvYXJkIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjo3fQ==',1779959017),('YnqdB3boaQdhM0kFRAIk2pfZWPgtElPecpllkqzU',NULL,'127.0.0.1','curl/8.19.0','eyJfdG9rZW4iOiJraDJROHZvRVpUdG9CeWpHZGFoNkNVRzJLajFoWWxSc2F0ZDFxTFFnIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1779954609);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','in_progress','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `due_date` datetime DEFAULT NULL,
  `assigned_to` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_assigned_to_foreign` (`assigned_to`),
  KEY `tasks_created_by_foreign` (`created_by`),
  CONSTRAINT `tasks_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tasks_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (41,'Thiết kế giao diện trang chủ','Vẽ wireframe và thiết kế giao diện Figma cho trang chủ của dự án.','in_progress','2026-06-01 17:00:00',7,1,'2026-05-28 08:52:55','2026-05-28 01:56:15'),(42,'Phát triển Frontend trang Dashboard','Cắt HTML/CSS và ghép giao diện Bootstrap 5 cho Dashboard.','completed','2026-06-05 18:00:00',7,1,'2026-05-28 08:52:55','2026-05-28 01:56:21'),(43,'Xây dựng cơ sở dữ liệu','Thiết kế cơ sở dữ liệu và viết các file migration cho Task, User, Notification.','pending','2026-05-29 12:00:00',7,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(44,'Viết tài liệu hướng dẫn','Viết file README.md và tài liệu đặc tả API cho các bên liên quan.','pending','2026-06-10 09:00:00',7,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(45,'Kiểm thử giao diện mobile','Kiểm tra độ tương thích của giao diện trên các thiết bị iOS và Android.','pending','2026-06-12 17:00:00',7,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(46,'Tích hợp cổng thanh toán','Kết nối hệ thống với cổng thanh toán VNPay và viết logic xử lý IPN.','pending','2026-06-04 15:00:00',8,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(47,'Tối ưu hiệu năng truy vấn SQL','Đánh chỉ mục (index) và tối ưu các câu lệnh SELECT phức tạp trên hệ thống.','pending','2026-05-30 10:00:00',8,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(48,'Cấu hình Mail Server','Thiết lập dịch vụ gửi email thông báo qua Amazon SES hoặc Gmail SMTP.','pending','2026-06-07 14:00:00',8,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(49,'Kiểm tra bảo mật hệ thống','Quét các lỗi bảo mật SQL Injection, XSS và phân quyền middleware.','pending','2026-06-15 16:00:00',8,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(50,'Phân tích yêu cầu khách hàng','Họp với đối tác để chốt các yêu cầu nâng cấp hệ thống giai đoạn 2.','pending','2026-05-28 11:00:00',8,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(51,'Xây dựng module chat thời gian thực','Sử dụng Laravel Reverb hoặc Pusher để viết tính năng chat nội bộ.','pending','2026-06-08 17:00:00',9,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(52,'Quản lý phân quyền với Spatie','Cài đặt và thiết lập Roles/Permissions cho từng cấp độ người dùng.','pending','2026-05-29 17:00:00',9,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(53,'Deploy ứng dụng lên VPS','Cấu hình Nginx, SSL Let\'s Encrypt và triển khai code lên Ubuntu server.','pending','2026-06-06 08:00:00',9,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(54,'Viết Unit Test cho Module Auth','Viết các ca kiểm thử tự động cho chức năng Đăng ký, Đăng nhập, Quên mật khẩu.','pending','2026-06-11 17:00:00',9,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(55,'Backup dữ liệu tự động','Viết cronjob tự động sao lưu database hàng ngày lên Google Drive.','pending','2026-05-27 23:00:00',9,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(56,'Tích hợp Firebase Notification','Cấu hình gửi thông báo đẩy (push notification) trên thiết bị di động.','pending','2026-06-09 10:00:00',10,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(57,'Xây dựng API cho ứng dụng di động','Thiết lập các router API và controller trả về dữ liệu định dạng JSON.','pending','2026-05-30 16:00:00',10,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(58,'Import/Export file Excel','Sử dụng Laravel Excel để xuất báo cáo công việc và nhập dữ liệu user.','pending','2026-06-03 17:00:00',10,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(59,'Setup môi trường Docker','Viết file docker-compose.yml thiết lập môi trường Nginx, PHP, MySQL.','pending','2026-06-05 13:00:00',10,1,'2026-05-28 08:52:55','2026-05-28 08:52:55'),(60,'Nghiệm thu dự án giai đoạn 1','Bàn giao các tài liệu kỹ thuật và chạy thử nghiệm hệ thống thực tế.','pending','2026-05-28 09:00:00',10,1,'2026-05-28 08:52:55','2026-05-28 08:52:55');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_user`
--

DROP TABLE IF EXISTS `team_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `team_user_team_id_foreign` (`team_id`),
  KEY `team_user_user_id_foreign` (`user_id`),
  CONSTRAINT `team_user_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `team_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_user`
--

LOCK TABLES `team_user` WRITE;
/*!40000 ALTER TABLE `team_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `team_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teams_created_by_foreign` (`created_by`),
  CONSTRAINT `teams_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','admin@example.com','2026-05-28 00:32:17','$2y$12$HgoIBKebeVfxjrY5uQazg.hPEczo1HLgzVGAurze4JOuVfemmoz8m','admin','MjOHk22SFExsBdFlVLUmdGCfUKNjjvh53JLokmpAiYoeODSs57NJAQjLih3H','2026-05-28 00:32:17','2026-05-28 00:32:17'),(7,'Nguyen Van Thanh','xuanpq359@gmail.com',NULL,'$2y$12$ZUcYu5To4MtPy1OqgRdfQ.6F5nzo.lYNEfgeyLXZP7gfnKGGDqd2i','user',NULL,'2026-05-28 00:54:00','2026-05-28 00:54:00'),(8,'Dat','dat@gmail.com',NULL,'$2y$12$0makP0p5qcLqnhVNi1PcZ.tgntDcqBmERfGhJCqMHqTx0XZEQsm6q','user',NULL,'2026-05-28 01:32:42','2026-05-28 01:32:42'),(9,'Nghia','nghia@gmail.com',NULL,'$2y$12$Zst8VssB/m7v6fhfCpEHwuTIHu2oaz75wha0Vb6aku9YX6ICOztX6','user',NULL,'2026-05-28 01:33:12','2026-05-28 01:33:12'),(10,'Ngoc Toan','ngoctoan@gmail.com',NULL,'$2y$12$D7LvJ53Z.Xb2GxTrk3htBOt5umWWu.N/B8E.M3BXDhxcBjUOSM16.','user',NULL,'2026-05-28 01:33:41','2026-05-28 01:33:41');
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

-- Dump completed on 2026-05-28 16:17:42
