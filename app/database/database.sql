-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para alguarisa_transporte
CREATE DATABASE IF NOT EXISTS `alguarisa_transporte` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `alguarisa_transporte`;

-- Volcando estructura para tabla alguarisa_transporte.municipios
CREATE TABLE IF NOT EXISTS `municipios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mini` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parroquias` int DEFAULT '0',
  `estatus` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla alguarisa_transporte.municipios: ~11 rows (aproximadamente)
INSERT INTO `municipios` (`id`, `nombre`, `mini`, `parroquias`, `estatus`, `created_at`, `updated_at`) VALUES
	(2, 'FRANCISCO DE MIRANDA', 'MIRANDA', 3, 1, '2023-09-27 12:03:47', '2023-09-27 12:03:47'),
	(3, 'LEONARDO INFANTE', 'INFANTE', 1, 1, '2023-09-27 12:03:47', '2023-09-27 12:03:47'),
	(4, 'PEDRO ZARAZA', 'ZARAZA', 2, 1, '2023-09-27 12:03:47', '2023-09-27 12:03:47'),
	(5, 'JOSE TADEO MONAGAS', 'MONAGAS', 5, 1, '2023-09-27 12:03:47', '2023-09-27 12:03:47'),
	(6, 'JOSE FELIX RIBAS', 'RIBAS', 2, 1, '2023-09-27 12:03:47', '2023-09-27 12:03:47'),
	(7, 'CAMAGUAN', 'CAMAGUANasdfg', 2, 1, '2023-09-27 12:03:47', '2023-09-30 04:00:00'),
	(8, 'JULIAN MELLADO', 'MELLADO', 2, 1, '2023-09-27 12:03:47', '2023-09-27 12:03:47'),
	(9, 'EL SOCORRO', 'EL SOCORRO', 1, 0, '2023-09-27 12:03:47', '2023-09-27 12:03:47'),
	(10, 'SANTA MARIA DE IPIRE', 'SANTA MARIA', 1, 1, '2023-09-27 12:03:47', '2023-09-27 12:03:47'),
	(14, 'SAN GERONIMO DE GUAYABAL', 'GUAYABAL', 2, 1, '2023-09-27 12:03:47', '2023-09-27 12:03:47'),
	(15, 'ORTIZ', 'ORTIZ', 4, 1, '2023-09-27 12:03:47', '2023-09-27 12:03:47');

-- Volcando estructura para tabla alguarisa_transporte.parametros
CREATE TABLE IF NOT EXISTS `parametros` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `tabla_id` int DEFAULT NULL,
  `valor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.parametros: ~0 rows (aproximadamente)

-- Volcando estructura para tabla alguarisa_transporte.parroquias
CREATE TABLE IF NOT EXISTS `parroquias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mini` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `municipios_id` bigint unsigned NOT NULL,
  `estatus` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parroquias_municipios_id_foreign` (`municipios_id`),
  CONSTRAINT `parroquias_municipios_id_foreign` FOREIGN KEY (`municipios_id`) REFERENCES `municipios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla alguarisa_transporte.parroquias: ~25 rows (aproximadamente)
INSERT INTO `parroquias` (`id`, `nombre`, `mini`, `municipios_id`, `estatus`, `created_at`, `updated_at`) VALUES
	(2, 'PUERTO MIRANDA', NULL, 7, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(3, 'UVERITO', NULL, 7, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(5, 'EL SOCORRO', NULL, 9, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(7, 'EL RASTRO', NULL, 2, 0, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(8, 'GUARDATINAJAS', NULL, 2, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(9, 'EL CALVARIO', NULL, 2, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(10, 'TUCUPIDO', NULL, 6, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(11, 'SAN RAFAEL DE LAYA', NULL, 6, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(13, 'SAN RAFAEL DE ORITUCO', 'SAN RAFAEL', 5, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(14, 'LIBERTAD DE ORITUCO', 'LIBERTAD', 5, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(15, 'SAN FRANCISCO DE MACAIRA', 'MACAIRA', 5, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(16, 'PASO REAL DE MACAIRA', 'PASO REAL', 5, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(18, 'FRANCISCO JAVIER DE LAZAMA', 'LEZAMA', 5, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(25, 'EL SOMBRERO', NULL, 8, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(26, 'SOSA', NULL, 8, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(27, 'VALLE DE LA PASCUA', NULL, 3, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(29, 'Ortiz', NULL, 15, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(30, 'SAN JOSE DE TIZNADOS', 'SAN JOSE', 15, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(31, 'SAN LORENZO DE TIZNADOS', 'SAN LORENZO', 15, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(32, 'SAN FRANCISCO DE TIZNADOSº', 'SAN FRANCISCO', 15, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(33, 'ZARAZA', NULL, 4, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(34, 'SAN JOSE DE UNARE', NULL, 4, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(35, 'GUAYABAL', NULL, 14, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48'),
	(36, 'CAZORLAx', 'sasxdasd', 14, 1, '2023-09-27 12:03:48', '2023-09-30 04:00:00'),
	(38, 'SANTA MARIA', NULL, 10, 1, '2023-09-27 12:03:48', '2023-09-27 12:03:48');

-- Volcando estructura para tabla alguarisa_transporte.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `password` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci,
  `date_token` datetime DEFAULT NULL,
  `path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci,
  `role` int NOT NULL DEFAULT '0',
  `role_id` int DEFAULT '0',
  `permisos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci,
  `estatus` int NOT NULL DEFAULT '1',
  `band` int NOT NULL DEFAULT '1',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `dispositivo` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla alguarisa_transporte.users: ~3 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `telefono`, `token`, `date_token`, `path`, `role`, `role_id`, `permisos`, `estatus`, `band`, `created_at`, `updated_at`, `deleted_at`, `dispositivo`) VALUES
	(1, 'Yonathan Castillo', 'leothan522@gmail.com', '$2y$10$D2ohRbgCgGaECIjGLM0GHunPKCf9xsJIl1T0a4KOQIW0iIFRTInJm', '(0424) 338-66.00', NULL, NULL, NULL, 100, 0, NULL, 1, 1, '2023-08-12', '2023-10-02', NULL, 0),
	(2, 'Antonny Maluenga', 'gabrielmalu15@gmail.com', '$2y$10$XibWahOwcjxTdM.YWlhrTuA8gJZeyK7fLe9Ge5yrI5loizvfE2sea', '(0412) 199-56.47', NULL, NULL, NULL, 100, 0, NULL, 1, 1, '2023-08-28', NULL, NULL, 0),
	(3, 'Administrador', 'admin@alguarisa.com', '$2y$10$5Fl3weju4a/JQi/x92lIMuXgXUr0dsxp6CIIikPNtNRyjDUlxj4ge', '(0424) 338-66.00', NULL, NULL, NULL, 99, 0, '{"usuarios.index":true}', 0, 0, '2023-09-28', NULL, '2023-09-29', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
